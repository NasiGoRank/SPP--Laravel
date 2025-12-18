<div wire:ignore.self class="modal fade text-left" id="createModal" tabindex="-1" role="dialog"
  aria-labelledby="myModalLabel1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Program Baru</h5>
        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close"><i
            data-feather="x"></i></button>
      </div>
      <form wire:submit="save">
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Program</label>
            <input type="text" wire:model="form.name" class="form-control @error('form.name') is-invalid @enderror">
            @error('form.name') <span class="text-danger small">{{ $message }}</span> @enderror
          </div>
          <div class="form-group">
            <label>Biaya (SPP)</label>
            <input type="number" wire:model="form.fee" class="form-control @error('form.fee') is-invalid @enderror">
            @error('form.fee') <span class="text-danger small">{{ $message }}</span> @enderror
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
