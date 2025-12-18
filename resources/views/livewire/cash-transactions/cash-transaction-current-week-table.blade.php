<div>
  {{-- 1. PANGGIL KOMPONEN MODAL (Cukup sekali disini) --}}
  @livewire('cash-transactions.create-cash-transaction')

  {{-- Bagian Statistik Cards --}}
  <div class="row">
    <div class="col-6">
      <div class="card">
        <div class="card-body px-4">
          <div class="row">
            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
              <div class="stats-icon">
                <i class="iconly-boldChart"></i>
              </div>
            </div>
            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
              <h6 class="text-muted font-semibold">Total Bulan Ini</h6>
              <h6 class="font-extrabold mb-0">{{ $this->statistics['totalCurrentMonth'] }}</h6>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6">
      <div class="card">
        <div class="card-body px-4">
          <div class="row">
            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
              <div class="stats-icon">
                <i class="iconly-boldChart"></i>
              </div>
            </div>
            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
              <h6 class="text-muted font-semibold">Total Tahun Ini</h6>
              <h6 class="font-extrabold mb-0">{{ $this->statistics['totalCurrentYear'] }}</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Statistik Card Baris 2 --}}
  <div class="row">
    <div class="col-6">
      <div class="card">
        <div class="card-body px-4">
          <div class="row">
            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
              <div class="stats-icon red">
                <i class="iconly-boldActivity"></i>
              </div>
            </div>
            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
              <h6 class="text-muted font-semibold">Sudah Membayar Bulan Ini</h6>
              <h6 class="font-extrabold mb-0">{{ $this->statistics['studentsPaidThisWeekCount'] }}</h6>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6">
      <div class="card">
        <div class="card-body px-4">
          <div class="row">
            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
              <div class="stats-icon purple">
                <i class="iconly-boldActivity"></i>
              </div>
            </div>
            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
              <h6 class="text-muted font-semibold">Belum Membayar Minggu Ini</h6>
              <h6 class="font-extrabold mb-0">{{ $this->statistics['studentsNotPaidThisWeekCount'] }}</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Daftar Belum Bayar --}}
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header text-center">
          @if ($this->statistics['studentsNotPaidThisWeekCount'] > 0)
            <h4>
              Daftar Yang Belum Membayar Bulan Ini
              <span class="fw-bolder fst-italic">
                ({{ $currentWeek['startOfWeek'] }} sampai {{ $currentWeek['endOfWeek'] }})
              </span>
            </h4>
          @endif
        </div>

        <div class="card-body">
          @if($this->statistics['studentsNotPaidThisWeekCount'] > 0)
            <button type="button" class="btn btn-danger btn-block btn-xl font-bold" data-bs-toggle="modal"
              data-bs-target="#notPaidModal">
              Ada <b>{{ $this->statistics['studentsNotPaidThisWeekCount'] }}</b> orang belum membayar pada bulan ini! <i
                class="bi bi-exclamation-triangle"></i>
            </button>
          @else
            <button type="button" class="btn btn-success btn-block btn-xl font-bold" data-bs-toggle="modal"
              data-bs-target="#notPaidModal">
              Semua sudah membayar pada bulan ini! <i class="bi bi-emoji-smile"></i>
            </button>
          @endif
        </div>
      </div>
    </div>
  </div>

  {{-- Modal Belum Bayar --}}
  <div wire:ignore.self data-bs-backdrop="static" class="modal fade" id="notPaidModal" tabindex="-1"
    aria-labelledby="notPaidModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="notPaidModalLabel">Daftar Pelajar Yang Belum Membayar</h1>
          <button wire:loading.attr="disabled" type="button" class="btn-close" data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            @foreach ($this->statistics['studentsNotPaidThisWeek'] as $student)
                      <div class="col-sm-12 col-md-6 mb-3">
                        <div class="card border rounded">
                          <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $student->name }}</h5>
                            <p class="card-text text-muted">{{ $student->identification_number }}</p>
                            <p class="card-text text-muted">
                              <span class="badge bg-secondary">
                                <i class="bi bi-telephone-fill"></i> {{ $student->phone_number }}
                              </span>
                            </p>
                            <span class="badge bg-primary"><i class="bi bi-bookmark"></i> {{
    $student->schoolClass->name }}</span>
                            <span class="badge bg-success"><i class="bi bi-briefcase"></i> {{
    $student->schoolMajor->name }}</span>
                            <span class="badge bg-light-{{ $student->gender == 1 ? 'primary' : 'danger' }}"><i
                                class="bi bi-gender-{{ $student->gender == 1 ? 'male' : 'female' }}"></i></span>
                          </div>
                        </div>
                      </div>
            @endforeach
          </div>
        </div>
        <div class="modal-footer">
          <button wire:loading.attr="disabled" type="button" class="btn btn-secondary"
            data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  {{-- TABEL UTAMA --}}
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Daftar Transaksi SPP Bulan Ini</h5>
          <div class="d-flex flex-wrap justify-content-end mb-3 gap-3">
            <select wire:model.live="limit" class="form-select form-select-sm w-auto rounded">
              <option value="5">5</option>
              <option value="10">10</option>
              <option value="15">15</option>
              <option value="25">25</option>
            </select>

            <select wire:model.live="orderByColumn" class="form-select form-select-sm w-auto rounded">
              <option value="amount">Total Bayar</option>
              <option value="date_paid">Tanggal Transaksi</option>
            </select>

            <select wire:model.live="orderBy" class="form-select form-select-sm w-auto rounded">
              <option value="asc">A-Z</option>
              <option value="desc">Z-A</option>
            </select>

            <button wire:click="resetFilter" type="button" class="btn btn-outline-warning btn-sm rounded">
              <i class="bi bi-x-circle me-1"></i> Reset Filter
            </button>

            {{-- Menu Filter --}}
            <button wire:click="toggleFilter" class="btn btn-primary btn-sm" type="button">
              <i class="bi bi-funnel me-1"></i>
              {{ $showFilter ? 'Sembunyikan' : 'Tampilkan' }} Filter
            </button>

            <button type="button" class="btn btn-primary btn-sm rounded" data-bs-toggle="modal"
              data-bs-target="#createModal">
              <i class="bi bi-plus-circle me-1"></i> Tambah Data
            </button>

            <button wire:click="$refresh" class="btn btn-outline-secondary btn-sm rounded">
              <i class="bi bi-arrow-clockwise me-1"></i> Refresh
            </button>
          </div>

          {{-- Konten Filter --}}
          @if($showFilter)
            <div class="mb-3">
              <div class="card card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h6 class="mb-0">Filter Data</h6>
                  <button wire:click="toggleFilter" type="button" class="btn-close" aria-label="Close"></button>
                </div>

                <div class="row g-3">
                  <div class="col-12 col-md-6">
                    <label for="user_id" class="form-label">Dicatat Oleh:</label>
                    <select wire:model.live="filters.user_id" class="form-select" id="user_id">
                      <option value="" selected>Pilih Dicatat Oleh</option>
                      @foreach ($this->users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-12 col-md-6">
                    <label for="school_major_id" class="form-label">Jurusan:</label>
                    <select wire:model.live="filters.schoolMajorID" class="form-select" id="school_major_id">
                      <option value="" selected>Pilih Jurusan</option>
                      @foreach ($this->schoolMajors as $schoolMajor)
                        <option value="{{ $schoolMajor->id }}">{{ $schoolMajor->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-12 col-md-6">
                    <label for="school_class_id" class="form-label">Kelas:</label>
                    <select wire:model.live="filters.schoolClassID" class="form-select" id="school_class_id">
                      <option value="" selected>Pilih Kelas</option>
                      @foreach ($this->schoolClasses as $schoolClass)
                        <option value="{{ $schoolClass->id }}">{{ $schoolClass->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            </div>
          @endif

          <div class="mb-3">
            <div class="form-group has-icon-left">
              <div class="position-relative">
                <input wire:model.live="query" type="text" class="form-control form-control shadow-sm rounded fw-bold"
                  placeholder="Masukan keyword pencarian...">
                <div class="form-control-icon">
                  <i class="bi bi-search"></i>
                </div>
              </div>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nama Pelajar</th>
                  <th scope="col">Nominal</th>
                  <th scope="col">Tanggal</th>
                  <th scope="col">Dicatat Oleh</th>
                  <th scope="col" class="text-center">Bukti</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr wire:loading>
                  <td colspan="7" class="text-center">
                    <div class="spinner-border" role="status">
                      <span class="visually-hidden">Loading...</span>
                    </div>
                  </td>
                </tr>

                @php
$startIndex = ($this->cashTransactions->currentPage() - 1) * $this->cashTransactions->perPage() + 1;
                @endphp

                @forelse ($this->cashTransactions as $index => $cashTransaction)
                  <tr wire:key="{{ $cashTransaction->id }}">
                    <th scope="row">{{ $startIndex + $index }}</th>
                    <td class="text-uppercase fw-bold">
                      <div>{{ $cashTransaction->student->name }}</div>
                      <span class="badge bg-success mt-1">
                        <i class="bi bi-briefcase-fill"></i>
                        {{ $cashTransaction->student->schoolMajor->name }}
                      </span>
                      <span class="badge bg-primary mt-1">
                        <i class="bi bi-bookmark-fill"></i>
                        {{ $cashTransaction->student->schoolClass->name }}
                      </span>
                      <small class="d-block text-muted mt-1">
                        {{ $cashTransaction->student->schoolProgram->name ?? 'Non-Program' }}
                      </small>
                    </td>
                    <td>{{ local_amount_format($cashTransaction->amount) }}</td>
                    <td>{{ $cashTransaction->date_paid }}</td>
                    <td class="text-center">
                      <span class="badge bg-primary w-100">
                        <i class="bi bi-person-badge-fill"></i>
                        {{ $cashTransaction->createdBy->name }}
                      </span>
                    </td>

                    <td class="text-center">
                      @if ($cashTransaction->proof_image)
                        @php
                          $imageUrl = asset('uploads/' . $cashTransaction->proof_image);
                        @endphp
                        <button type="button" class="btn btn-link p-0 border-0" onclick="showProofPreview('{{ $imageUrl }}',
                                                                                     '{{ $cashTransaction->student->identification_number }}',
                                                                                     '{{ addslashes($cashTransaction->student->name) }}',
                                                                                     '{{ $cashTransaction->date_paid }}')">
                          <img src="{{ $imageUrl }}" alt="Bukti" class="img-thumbnail"
                            style="width: 50px; height: 50px; object-fit: cover; cursor: pointer;" title="Klik untuk preview dan download"
                            onerror="this.onerror=null; this.src='{{ asset('images/no-image.png') }}'; this.alt='Gambar tidak dapat dimuat';">
                        </button>
                      @else
                        <img src="{{ asset('images/no-image.png') }}" alt="Tidak ada bukti" class="img-thumbnail opacity-50"
                          style="width: 50px; height: 50px; object-fit: cover;">
                      @endif
                    </td>

                    <td>
                      <div class="btn-group gap-1" role="group">
                        <button wire:loading.attr="disabled"
                          wire:click="$dispatch('cash-transaction-edit', {cashTransaction: {{ $cashTransaction->id }}})"
                          type="button" class="btn btn-sm btn-success rounded" data-bs-toggle="modal"
                          data-bs-target="#editTransactionModal">
                          <i class="bi bi-pencil-square"></i>
                        </button>
                        <button wire:loading.attr="disabled"
                          wire:click="$dispatch('cash-transaction-delete', {cashTransaction: {{ $cashTransaction->id }}})"
                          type="button" class="btn btn-sm btn-danger rounded" data-bs-toggle="modal"
                          data-bs-target="#deleteModal">
                          <i class="bi bi-trash-fill"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr wire:loading.remove class="text-center">
                    <th colspan="7" class="fw-bold">Tidak ada data yang ditemukan!</th>
                  </tr>
                @endforelse
              </tbody>
            </table>
            {{ $this->cashTransactions->links(data: ['scrollTo' => false]) }}
          </div>
        </div>
      </div>
    </div>

    {{-- Modal Preview Gambar Bukti --}}
    <div wire:ignore.self class="modal fade" id="proofPreviewModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">
              <i class="bi bi-receipt me-2"></i>Bukti Pembayaran SPP
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center">
            <div id="proofInfo" class="mb-3 text-start">
              <p class="mb-1"><strong>Siswa:</strong> <span id="studentName"></span></p>
              <p class="mb-1"><strong>NIS:</strong> <span id="studentNIS"></span></p>
              <p class="mb-1"><strong>Tanggal:</strong> <span id="paymentDate"></span></p>
            </div>
            <img id="previewProofImage" src="" class="img-fluid rounded shadow" alt="Preview Bukti Pembayaran"
              style="max-height: 60vh; object-fit: contain;">
            <div class="mt-3 text-muted small" id="fileNameInfo"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              <i class="bi bi-x-circle me-1"></i> Tutup
            </button>
            <a id="downloadProofLink" href="" download class="btn btn-primary">
              <i class="bi bi-download me-1"></i> Download Bukti
            </a>
          </div>
        </div>
      </div>
    </div>

    <livewire:cash-transactions.edit-cash-transaction :students="$this->students" />
    <livewire:cash-transactions.delete-cash-transaction />
  </div>

@script
<script>
  // Fungsi untuk preview dan download bukti pembayaran
  window.showProofPreview = function (imageSrc, studentId, studentName, paymentDate) {
    // 1. Format Nama File untuk Download
    const cleanName = studentName.replace(/[^a-zA-Z0-9]/g, '_');
    const cleanDate = paymentDate.split(' ')[0]; // Ambil tanggal saja (YYYY-MM-DD)
    const fileExtension = imageSrc.split('.').pop().split('?')[0]; // Ambil ekstensi (jpg/png)

    // Format: SPP_ID_NAMA_TANGGAL.ext
    const fileName = `SPP_${studentId}_${cleanName}_${cleanDate}.${fileExtension}`;

    // 2. Format Tanggal untuk Tampilan
    const displayDate = new Date(paymentDate).toLocaleDateString('id-ID', {
      day: '2-digit',
      month: 'long',
      year: 'numeric'
    });

    // 3. Update Info di Modal
    document.getElementById('studentName').textContent = studentName;
    document.getElementById('studentNIS').textContent = studentId;
    document.getElementById('paymentDate').textContent = displayDate;
    document.getElementById('fileNameInfo').textContent = `File: ${fileName}`;

    // 4. Handle Gambar & Download
    const previewImage = document.getElementById('previewProofImage');
    const downloadLink = document.getElementById('downloadProofLink');

    // Reset gambar ke loading state
    previewImage.src = '';
    previewImage.alt = 'Memuat gambar...';

    const img = new Image();
    img.onload = function () {
      previewImage.src = imageSrc;
      previewImage.alt = `Bukti pembayaran ${studentName}`;

      // Set link download
      downloadLink.href = imageSrc;
      downloadLink.download = fileName;
      downloadLink.style.display = 'inline-block';

      // Tampilkan Modal
      const modalElement = document.getElementById('proofPreviewModal');
      const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
      modal.show();
    };

    img.onerror = function () {
      alert("Gambar tidak ditemukan atau rusak.");
      previewImage.src = '{{ asset("images/no-image.png") }}';
      previewImage.alt = 'Gambar tidak ditemukan';
    };

    img.src = imageSrc;
  }
</script>
@endscript
</div>
