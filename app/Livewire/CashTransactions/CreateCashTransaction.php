<?php

namespace App\Livewire\CashTransactions;

use App\Livewire\Forms\StoreCashTransactionForm;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;

class CreateCashTransaction extends Component
{
    use WithFileUploads;

    public StoreCashTransactionForm $form;
    public $detectedProgramName = '';

    public function mount()
    {
        $this->form->date_paid = date('Y-m-d');
    }

    public function updatedFormStudentId($value)
    {
        if ($value) {
            $student = Student::with('schoolProgram')->find($value);

            if ($student && $student->schoolProgram) {
                $this->form->amount = $student->schoolProgram->fee;
                $this->detectedProgramName = $student->schoolProgram->name;
            } else {
                $this->form->amount = 0;
                $this->detectedProgramName = 'Tidak ada program';
            }
        }
    }

    public function save()
    {
        $this->form->store();

        // Dispatch event
        $this->dispatch('cash-transaction-created');
        $this->dispatch('close-modal');

        $this->form->reset();
        $this->detectedProgramName = '';
        $this->form->date_paid = date('Y-m-d');
    }

    public function render()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $students = Student::with(['schoolClass', 'schoolProgram'])
            ->whereDoesntHave('cashTransactions', function (Builder $query) use ($currentMonth, $currentYear) {
                $query->whereMonth('date_paid', $currentMonth)
                    ->whereYear('date_paid', $currentYear);
            })
            ->orderBy('name', 'asc')
            ->get();

        return view('livewire.cash-transactions.create-cash-transaction', [
            'students' => $students
        ]);
    }
}
