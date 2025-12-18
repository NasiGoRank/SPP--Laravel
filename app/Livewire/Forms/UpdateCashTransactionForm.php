<?php

namespace App\Livewire\Forms;

use App\Models\CashTransaction;
use Illuminate\Support\Facades\File;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class UpdateCashTransactionForm extends Form
{
    public ?CashTransaction $cashTransaction;

    #[Validate('required|exists:students,id', as: 'siswa')]
    public $student_id = '';

    #[Validate('required|numeric|min:0', as: 'jumlah bayar')]
    public $amount = '';

    #[Validate('required|date')]
    public $date_paid = '';

    #[Validate('nullable|string|max:255')]
    public $transaction_note = '';

    #[Validate('nullable|image|max:2048')]
    public $proof_image;

    public function setTransaction(CashTransaction $transaction)
    {
        $this->cashTransaction = $transaction;
        $this->student_id = $transaction->student_id;
        $this->amount = $transaction->amount;
        $this->date_paid = $transaction->date_paid->format('Y-m-d');
        $this->transaction_note = $transaction->transaction_note;
    }

    public function update()
    {
        $this->validate();

        $data = [
            'student_id'       => $this->student_id,
            'amount'           => $this->amount,
            'date_paid'        => $this->date_paid,
            'transaction_note' => $this->transaction_note,
        ];

        // --- LOGIKA UPDATE PERBAIKAN ---
        if ($this->proof_image && $this->proof_image instanceof TemporaryUploadedFile) {
            $folderPath = public_path('uploads/proofs');

            // A. Buat Folder jika belum ada
            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0755, true, true);
            }

            // B. Hapus gambar lama jika ada
            if ($this->cashTransaction->proof_image && File::exists(public_path('uploads/' . $this->cashTransaction->proof_image))) {
                File::delete(public_path('uploads/' . $this->cashTransaction->proof_image));
            }

            // C. Simpan gambar baru dengan File::copy()
            $extension = $this->proof_image->getClientOriginalExtension();
            $fileName = time() . '_' . uniqid() . '.' . $extension;

            // FIX: Gunakan copy, dan pastikan path menggunakan separator yang benar
            File::copy($this->proof_image->getRealPath(), $folderPath . DIRECTORY_SEPARATOR . $fileName);

            $data['proof_image'] = 'proofs/' . $fileName;
        }
        // Note: Tidak perlu else, jika tidak ada gambar baru, $data['proof_image'] tidak di-set/di-update
        // -------------------------------------------

        $this->cashTransaction->update($data);
        $this->reset('proof_image');
    }
}
