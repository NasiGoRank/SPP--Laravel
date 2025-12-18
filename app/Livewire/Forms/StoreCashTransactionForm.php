<?php

namespace App\Livewire\Forms;

use App\Models\CashTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class StoreCashTransactionForm extends Form
{
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

    public function store(): void
    {
        $this->validate();

        $proofPath = null;

        // --- LOGIKA PERBAIKAN (GUNAKAN COPY) ---
        if ($this->proof_image && $this->proof_image instanceof TemporaryUploadedFile) {
            // 1. Tentukan folder tujuan
            $folderPath = public_path('uploads/proofs');

            // 2. Buat folder jika belum ada
            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0755, true, true);
            }

            // 3. Buat nama file unik
            $extension = $this->proof_image->getClientOriginalExtension();
            $fileName = time() . '_' . uniqid() . '.' . $extension;

            // 4. FIX: Gunakan File::copy() bukan move() agar lebih stabil di Windows
            // getRealPath() mengambil lokasi file temp Livewire
            File::copy($this->proof_image->getRealPath(), $folderPath . DIRECTORY_SEPARATOR . $fileName);

            // 5. Simpan path relatif untuk database
            $proofPath = 'proofs/' . $fileName;
        }
        // ----------------------------------------------

        CashTransaction::create([
            'student_id'       => $this->student_id,
            'amount'           => $this->amount,
            'date_paid'        => $this->date_paid,
            'transaction_note' => $this->transaction_note,
            'created_by'       => Auth::id(),
            'proof_image'      => $proofPath,
        ]);

        $this->reset(['student_id', 'amount', 'date_paid', 'transaction_note', 'proof_image']);
    }
}
