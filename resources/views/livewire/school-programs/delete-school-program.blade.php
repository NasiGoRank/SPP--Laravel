<div wire:ignore.self class="modal fade text-left" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title text-white">Konfirmasi Hapus</h5>
      </div>
      <div class="modal-body text-center py-4">
        <i class="bi bi-exclamation-triangle-fill text-danger fs-1"></i>
        <p class="mt-3">Apakah Anda yakin ingin menghapus program <strong>{{ $schoolProgram->name ?? '' }}</strong>?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" wire:click="destroy" class="btn btn-danger">Hapus Sekarang</button>
      </div>
    </div>
  </div>
</div>
