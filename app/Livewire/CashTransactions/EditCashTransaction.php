<?php

namespace App\Livewire\CashTransactions;

use App\Livewire\Forms\UpdateCashTransactionForm;
use App\Models\CashTransaction;
use App\Models\Student;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditCashTransaction extends Component
{
    use WithFileUploads;

    public UpdateCashTransactionForm $form;

    // Variabel UI
    public $detectedProgramName = '';
    public $existingProofImage = null; // Path gambar lama
    public $existingProofImageUrl = null; // URL lengkap untuk preview

    #[On('cash-transaction-edit')]
    public function edit($cashTransaction)
    {
        $transaction = CashTransaction::findOrFail($cashTransaction);

        $this->form->setTransaction($transaction);

        // Simpan path dan URL gambar lama untuk preview
        $this->existingProofImage = $transaction->proof_image;
        $this->existingProofImageUrl = $transaction->proof_image ?
            asset('uploads/' . $transaction->proof_image) : null;

        // Info Program Siswa saat ini
        $student = $transaction->student;
        if ($student && $student->schoolProgram) {
            $this->detectedProgramName = $student->schoolProgram->name;
        } else {
            $this->detectedProgramName = '';
        }

        $this->dispatch('show-edit-modal');
    }

    // --- LOGIKA HARGA OTOMATIS (Sama seperti Create) ---
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
        $this->form->update();
        $this->dispatch('cash-transaction-updated');
        $this->dispatch('hide-edit-modal');
        $this->dispatch('alert', type: 'success', message: 'Data berhasil diupdate!');
    }

    public function render()
    {
        return view('livewire.cash-transactions.edit-cash-transaction', [
            'students' => Student::orderBy('name', 'asc')->get()
        ]);
    }
}
