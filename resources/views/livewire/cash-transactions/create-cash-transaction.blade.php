<div>
  <div wire:ignore.self data-bs-backdrop="static" class="modal fade" id="createModal" tabindex="-1"
    aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="createModalLabel">Tambah Pembayaran SPP</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <form wire:submit="save">
            <div class="row">
              {{-- PILIH SISWA (Single Select) --}}
              <div class="col-md-6 mb-3">
                <label class="form-label">Pilih Pelajar</label>
                <select class="form-select" wire:model.live="form.student_id">
                  <option value="">-- Cari Nama Siswa --</option>
                  @foreach ($students as $student)
                    <option value="{{ $student->id }}">
                      {{ $student->identification_number }} - {{ $student->name }}
                    </option>
                  @endforeach
                </select>
                @error('form.student_id') <span class="text-danger small">{{ $message }}</span> @enderror

                {{-- Info Program Otomatis --}}
                @if($detectedProgramName)
                  <div class="mt-2 text-info small fw-bold">
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
                  <label class="form-label">Tanggal</label>
                  <input type="date" class="form-control" wire:model="form.date_paid">
                  @error('form.date_paid') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- BUKTI BAYAR --}}
                <div class="mb-3">
                  <label class="form-label">Bukti Bayar</label>
                  <input type="file" class="form-control" wire:model="form.proof_image">
                  @error('form.proof_image') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- CATATAN (Gunakan transaction_note) --}}
                <x-forms.textarea-with-icon label="Catatan" name="transaction_note" wire:model="form.transaction_note"
                  icon="bi bi-card-text" placeholder="Opsional..." />
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary">
                <span wire:loading.remove>Simpan</span>
                <span wire:loading>Menyimpan...</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

<script>
  document.addEventListener('livewire:initialized', () => {
    Livewire.on('close-modal', () => {
      const el = document.getElementById('createModal');
      const modal = bootstrap.Modal.getInstance(el);
      if (modal) modal.hide();
    });

    // Refresh setelah create
    Livewire.on('cash-transaction-created', () => {
      @this.dispatch('$refresh');
    });
  });
</script>
</div>
