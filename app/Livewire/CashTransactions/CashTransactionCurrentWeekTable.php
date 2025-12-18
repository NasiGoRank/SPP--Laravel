<?php

namespace App\Livewire\CashTransactions;

use App\Models\CashTransaction;
use App\Models\SchoolClass;
use App\Models\SchoolMajor;
use App\Models\Student;
use App\Models\User;
use App\Repositories\CashTransactionRepository;
use App\Repositories\StudentRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Bulan Ini')]
class CashTransactionCurrentWeekTable extends Component
{
    use WithPagination;

    protected StudentRepository $studentRepository;

    protected CashTransactionRepository $cashTransactionRepository;

    public ?string $query = '';

    public int $limit = 5;

    public string $orderByColumn = 'date_paid';

    public string $orderBy = 'desc';

    public ?array $currentWeek = [];

    public bool $showFilter = false;

    public array $filters = [
        'user_id' => '',
        'schoolMajorID' => '',
        'schoolClassID' => '',
    ];

    public function toggleFilter(): void
    {
        $this->showFilter = !$this->showFilter;
    }

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
        $this->currentWeek = [
            'startOfWeek' => now()->startOfMonth()->format('d-m-Y'),
            'endOfWeek'   => now()->endOfMonth()->format('d-m-Y'),
        ];
    }

    #[Computed]
    public function students(): Collection
    {
        return Student::select('id', 'identification_number', 'name')->get();
    }

    #[Computed]
    public function users(): Collection
    {
        return User::select('id', 'name')->orderBy('name')->get();
    }

    #[Computed]
    public function schoolMajors(): Collection
    {
        return SchoolMajor::select('id', 'name')->get();
    }

    #[Computed]
    public function schoolClasses(): Collection
    {
        return SchoolClass::select('id', 'name')->get();
    }

    #[Computed]
    public function statistics()
    {
        $startDate = now()->startOfMonth();
        $endDate   = now()->endOfMonth();
        $studentsNotPaidQuery = \App\Models\Student::whereDoesntHave('cashTransactions', function ($query) use ($startDate, $endDate) {
            $query->whereBetween('date_paid', [$startDate, $endDate]);
        });
        $studentsPaidCount = \App\Models\Student::whereHas('cashTransactions', function ($query) use ($startDate, $endDate) {
            $query->whereBetween('date_paid', [$startDate, $endDate]);
        })->count();
        $summaries = [
            'month' => \App\Models\CashTransaction::whereBetween('date_paid', [$startDate, $endDate])->sum('amount'),
            'year'  => \App\Models\CashTransaction::whereYear('date_paid', now()->year)->sum('amount'),
        ];

        return [
            'totalCurrentMonth' => local_amount_format($summaries['month']),
            'totalCurrentYear'  => local_amount_format($summaries['year']),

            // PERBAIKAN DISINI: Gunakan variabel hasil hitungan terpisah
            'studentsPaidThisWeekCount'    => $studentsPaidCount,

            'studentsNotPaidThisWeekCount' => $studentsNotPaidQuery->count(),
            'studentsNotPaidThisWeekLimit' => $studentsNotPaidQuery->get(),
            'studentsNotPaidThisWeek'      => $studentsNotPaidQuery->get(),
        ];
    }

    #[Computed]
    public function cashTransactions(): Paginator
    {
        return CashTransaction::query()
            ->with([
                'student.schoolMajor',
                'student.schoolClass',
                'createdBy',
            ])
            ->whereBetween('date_paid', [
                now()->createFromDate($this->currentWeek['startOfWeek'])->startOfDay(),
                now()->createFromDate($this->currentWeek['endOfWeek'])->endOfDay(),
            ])
            ->when($this->filters['user_id'], fn(Builder $q) => $q->where('created_by', $this->filters['user_id']))
            ->when($this->filters['schoolMajorID'], fn(Builder $q) => $q->whereRelation('student', 'school_major_id', $this->filters['schoolMajorID']))
            ->when($this->filters['schoolClassID'], fn(Builder $q) => $q->whereRelation('student', 'school_class_id', $this->filters['schoolClassID']))
            ->search($this->query)
            ->orderBy($this->orderByColumn, $this->orderBy)
            ->paginate($this->limit);
    }

    /**
     * This method is automatically triggered whenever a property of the component is updated.
     */
    public function updated(): void
    {
        $this->resetPage();
    }

    /**
     * Render the view.
     */
    #[On('cash-transaction-created')]
    #[On('cash-transaction-updated')]
    #[On('cash-transaction-deleted')]
    public function refreshTable()
    {
        // Method ini akan di-trigger oleh event, otomatis refresh table
    }

    public function render(): View
    {
        return view('livewire.cash-transactions.cash-transaction-current-week-table');
    }

    /**
     * Reset the filter criteria to default values.
     */
    public function resetFilter(): void
    {
        $this->reset([
            'query',
            'limit',
            'orderByColumn',
            'orderBy',
            'filters',
        ]);
    }
}
