<div>
  {{-- ID Modal HARUS BEDA dengan Create --}}
  <div wire:ignore.self data-bs-backdrop="static" class="modal fade" id="editTransactionModal" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="createModalLabel">Edit Pembayaran SPP</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <form wire:submit="save">
            <div class="row">

              {{-- PILIH SISWA (Dropdown Biasa) --}}
              <div class="col-md-6 mb-3">
                <label class="form-label">Pilih Pelajar</label>
                {{-- wire:model.live PENTING agar harga otomatis jalan --}}
                <select class="form-select" wire:model.live="form.student_id">
                  <option value="">-- Cari Nama Siswa --</option>
                  @foreach ($students as $student)
                    <option value="{{ $student->id }}">
                      {{ $student->identification_number }} - {{ $student->name }}
                    </option>
                  @endforeach
                </select>
                @error('form.student_id') <span class="text-danger small">{{ $message }}</span> @enderror

                @if($detectedProgramName)
                  <div class="mt-2 text-primary small fw-bold">
                    <i class="bi bi-info-circle"></i> Program: {{ $detectedProgramName }}
                  </div>
                @endif
              </div>

              <div class="col-md-6">
                {{-- NOMINAL --}}
                <x-forms.input-with-icon wire:model="form.amount" label="Nominal Tagihan" name="amount" type="number"
                  icon="bi bi-cash" />

                {{-- TANGGAL (Gunakan date_paid) --}}
                <div class="mb-3">
                  <label class="form-label">Tanggal Transaksi</label>
                  <input type="date" class="form-control" wire:model="form.date_paid">
                  @error('form.date_paid') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- Di bagian BUKTI BAYAR --}}
                <div class="mb-3">
                  <label class="form-label">Bukti Bayar (Opsional)</label>

                  {{-- Preview Gambar Lama --}}
                  @if($existingProofImage && !$form->proof_image)
                    <div class="mb-2">
                      <small class="text-muted">Bukti saat ini:</small><br>
                      <img src="{{ $existingProofImageUrl ?? asset('uploads/' . $existingProofImage) }}" class="img-thumbnail"
                        style="height: 100px;" alt="Bukti saat ini"
                        onerror="this.onerror=null; this.src='/images/no-image.png'; this.alt='Gambar tidak dapat dimuat';">
                    </div>
                  @endif

                  {{-- Preview Gambar Baru --}}
                  @if($form->proof_image)
                    <div class="mb-2">
                      <small class="text-success">Akan diganti dengan:</small><br>
                      <img src="{{ $form->proof_image->temporaryUrl() }}" class="img-thumbnail" style="height: 100px;" alt="Bukti baru">
                    </div>
                  @endif

                  <input type="file" class="form-control" wire:model="form.proof_image">
                  <div class="form-text">Upload file baru hanya jika ingin mengganti.</div>
                  @error('form.proof_image') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- CATATAN (Gunakan transaction_note) --}}
                <x-forms.textarea-with-icon label="Catatan" name="transaction_note" wire:model="form.transaction_note"
                  icon="bi bi-card-text" />
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Update Data</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- SCRIPT KHUSUS EDIT --}}
<script>
  document.addEventListener('livewire:initialized', () => {
    const editModalEl = document.getElementById('editTransactionModal');
    if (editModalEl) {
      const editModal = bootstrap.Modal.getOrCreateInstance(editModalEl);

      // Listener Buka Modal
      Livewire.on('show-edit-modal', () => editModal.show());

      // Listener Tutup Modal
      Livewire.on('hide-edit-modal', () => {
        editModal.hide();
        // Reset input file manual
        const fileInput = editModalEl.querySelector('input[type="file"]');
        if (fileInput) fileInput.value = '';
      });

      // Refresh tabel setelah update (gunakan event yang benar)
      Livewire.on('cash-transaction-updated', () => {
        @this.dispatch('$refresh');
      });
    }
  });
</script>
</div>
