<div>
  <section class="section">
    <div class="card">
      <div class="card-header d-flex justify-content-between">
        <h4 class="card-title">Daftar Program</h4>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
          <i class="bi bi-plus-circle"></i> Tambah Program
        </button>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Program</th>
                <th>Biaya (Fee)</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($programs as $program)
                <tr>
                  <td>{{ ($programs->currentPage() - 1) * $programs->perPage() + $loop->iteration }}</td>
                  <td>{{ $program->name }}</td>
                  <td>Rp {{ number_format($program->fee, 0, ',', '.') }}</td>
                  <td>
                    <button class="btn btn-sm btn-warning"
                      wire:click="$dispatch('school-program-edit', { schoolProgram: {{ $program->id }} })"
                      data-bs-toggle="modal" data-bs-target="#editModal">
                      <i class="bi bi-pencil-square"></i>
                    </button>
                    <button class="btn btn-sm btn-danger"
                      wire:click="$dispatch('school-program-delete', { schoolProgram: {{ $program->id }} })"
                      data-bs-toggle="modal" data-bs-target="#deleteModal">
                      <i class="bi bi-trash-fill"></i>
                    </button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        {{ $programs->links() }}
      </div>
    </div>
  </section>

  <livewire:school-programs.create-school-program />
  <livewire:school-programs.edit-school-program />
  <livewire:school-programs.delete-school-program />
</div>
