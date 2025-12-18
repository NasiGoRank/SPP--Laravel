<?php

namespace App\Livewire\CashTransactions;

use App\Models\CashTransaction;
use App\Repositories\CashTransactionRepository;
use App\Repositories\StudentRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Collection;

#[Title('Filter Transaksi')]
class FilterCashTransaction extends Component
{
    use WithPagination;

    protected StudentRepository $studentRepository;
    protected CashTransactionRepository $cashTransactionRepository;

    public ?string $selected_month = '';
    public ?string $selected_year = '';
    public ?string $query = '';
    public ?array $statistics = [];
    public array $years = [];
    public array $months = [];
    public string $selectedMonthName = '';

    /**
     * Boot the component.
     */
    public function boot(
        StudentRepository $studentRepository,
        CashTransactionRepository $cashTransactionRepository
    ): void {
        $this->studentRepository = $studentRepository;
        $this->cashTransactionRepository = $cashTransactionRepository;
    }

    /**
     * Initialize the component's state.
     */
    public function mount(): void
    {
        // Set default ke bulan saat ini
        $currentYear = now()->year;
        $currentMonth = now()->format('m');
        $this->selected_year = (string) $currentYear;
        $this->selected_month = $currentMonth;

        // Generate daftar tahun (5 tahun terakhir)
        for ($i = 0; $i < 5; $i++) {
            $this->years[] = $currentYear - $i;
        }

        // Daftar bulan
        $this->months = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        // Set nama bulan yang dipilih
        $this->selectedMonthName = $this->months[$currentMonth] . ' ' . $currentYear;

        $this->statistics = [
            'totalCurrentWeek' => 0,
            'totalCurrentMonth' => 0,
            'totalCurrentYear' => 0,
            'totalSelectedRange' => 0,
            'studentsNotPaidLimit' => collect(),
            'studentsNotPaid' => collect(),
            'studentsNotPaidCount' => 0,
        ];
    }

    /**
     * Get start and end date from selected month and year
     */
    private function getDateRange(): array
    {
        try {
            $year = (int) $this->selected_year;
            $month = (int) $this->selected_month;

            // Validasi input
            if ($year < 2000 || $year > 2100) {
                $year = now()->year;
            }

            if ($month < 1 || $month > 12) {
                $month = now()->month;
            }

            // Update selectedMonthName
            $monthKey = str_pad($month, 2, '0', STR_PAD_LEFT);
            $this->selectedMonthName = $this->months[$monthKey] . ' ' . $year;

            // Format untuk query: hanya tanggal tanpa waktu, karena field date_paid adalah date (bukan datetime)
            $startDate = Carbon::create($year, $month, 1)->format('Y-m-d');
            $endDate = Carbon::create($year, $month, 1)->endOfMonth()->format('Y-m-d');

            return [
                'start' => $startDate,
                'end' => $endDate,
                'start_for_query' => $startDate, // Format Y-m-d sudah cukup untuk field date
                'end_for_query' => $endDate, // Format Y-m-d sudah cukup untuk field date
            ];
        } catch (\Exception $e) {
            // Fallback ke bulan ini jika terjadi error
            $startDate = now()->startOfMonth()->format('Y-m-d');
            $endDate = now()->endOfMonth()->format('Y-m-d');

            $monthKey = now()->format('m');
            $this->selectedMonthName = $this->months[$monthKey] . ' ' . now()->year;

            return [
                'start' => $startDate,
                'end' => $endDate,
                'start_for_query' => $startDate,
                'end_for_query' => $endDate,
            ];
        }
    }

    /**
     * This method is automatically triggered whenever a property of the component is updated.
     */
    public function updated($property): void
    {
        if (in_array($property, ['selected_year', 'selected_month', 'query'])) {
            $this->resetPage();
        }
    }

    /**
     * Render the view.
     */
    public function render(): View
    {
        $dateRange = $this->getDateRange();
        $startDate = $dateRange['start'];
        $endDate = $dateRange['end'];
        $startForQuery = $dateRange['start_for_query'];
        $endForQuery = $dateRange['end_for_query'];

        // Hitung total untuk rentang bulan yang dipilih
        $sumAmountDateRange = CashTransaction::whereBetween('date_paid', [$startForQuery, $endForQuery])->sum('amount');

        $filteredResult = CashTransaction::query()
            ->with([
                'student.schoolMajor',
                'student.schoolClass',
                'createdBy'
            ])
            ->when($this->query, function (Builder $query) {
                return $query->whereHas('student', function ($studentQuery) {
                    return $studentQuery->where('name', 'like', "%{$this->query}%")
                        ->orWhere('identification_number', 'like', "%{$this->query}%");
                });
            })
            ->whereBetween('date_paid', [$startForQuery, $endForQuery]);

        // Hitung siswa yang belum membayar
        // Repository mengembalikan SupportCollection, jadi kita perlu mengaksesnya dengan benar
        $studentPaymentStatus = $this->studentRepository->getStudentPaymentStatus($startForQuery, $endForQuery);

        // Akses collection dari repository
        $studentsNotPaid = $studentPaymentStatus->get('studentsNotPaid', collect());
        $studentsNotPaidCount = $studentsNotPaid->count();

        $this->statistics['studentsNotPaidLimit'] = $studentsNotPaid->take(6);
        $this->statistics['studentsNotPaid'] = $studentsNotPaid;
        $this->statistics['studentsNotPaidCount'] = $studentsNotPaidCount;

        // Hitung statistik lainnya
        $cashTransactionSummaries = $this->cashTransactionRepository->calculateTransactionSums();

        $this->statistics['totalToday'] = local_amount_format($cashTransactionSummaries['today'] ?? 0);
        $this->statistics['totalCurrentWeek'] = local_amount_format($cashTransactionSummaries['week'] ?? 0);
        $this->statistics['totalCurrentMonth'] = local_amount_format($cashTransactionSummaries['month'] ?? 0);
        $this->statistics['totalCurrentYear'] = local_amount_format($cashTransactionSummaries['year'] ?? 0);
        $this->statistics['totalSelectedRange'] = local_amount_format($sumAmountDateRange);

        return view('livewire.cash-transactions.filter-cash-transaction', [
            'filteredResult' => $filteredResult->paginate(10),
            'sumAmountDateRange' => $sumAmountDateRange,
            'selectedMonthName' => $this->selectedMonthName
        ]);
    }
}
