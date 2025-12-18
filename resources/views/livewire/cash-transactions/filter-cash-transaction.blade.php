<div>
  {{-- Card Statistik --}}
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

  {{-- Card Statistik Tambahan --}}
  <div class="row mb-4">
    <div class="col-12">
      <div class="card">
        <div class="card-body px-4">
          <div class="row">
            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
              <div class="stats-icon purple">
                <i class="iconly-boldChart"></i>
              </div>
            </div>
            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
              <h6 class="text-muted font-semibold">Total {{ $selectedMonthName ?? 'Bulan Dipilih' }}</h6>
              <h6 class="font-extrabold mb-0">
                {{ $this->statistics['totalSelectedRange'] ?? local_amount_format(0) }}
              </h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Filter Berdasarkan Bulan --}}
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header text-center">
          <h4>Filter Data Berdasarkan Bulan</h4>
        </div>
        <div class="card-body">
          <div class="row">
            {{-- Pilih Tahun --}}
            <div class="col-sm-12 col-md-6">
              <div class="mb-3">
                <label for="selected_year" class="form-label">Pilih Tahun:</label>
                <select wire:model.live="selected_year" class="form-select" id="selected_year">
                  @foreach ($this->years as $year)
                    <option value="{{ $year }}" {{ $year == $selected_year ? 'selected' : '' }}>
                      {{ $year }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            {{-- Pilih Bulan --}}
            <div class="col-sm-12 col-md-6">
              <div class="mb-3">
                <label for="selected_month" class="form-label">Pilih Bulan:</label>
                <select wire:model.live="selected_month" class="form-select" id="selected_month">
                  @foreach ($this->months as $key => $month)
                    <option value="{{ $key }}" {{ $key == $selected_month ? 'selected' : '' }}>
                      {{ $month }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          {{-- Info Bulan yang Dipilih --}}
          @if ($selected_month)
            <div class="alert alert-info mb-3">
              <div class="d-flex align-items-center">
                <div>
                  <strong>Menampilkan data untuk:</strong> {{ $selectedMonthName }}
                </div>
              </div>
            </div>
          @elseif($selected_year)
            <div class="alert alert-info mb-3">
              <div class="d-flex align-items-center">
                <div>
                  <strong>Menampilkan data untuk tahun:</strong> {{ $selected_year }}
                </div>
              </div>
            </div>
          @endif

          <div class="divider">
            <div class="divider-text fw-bold">Gunakan menu filter di atas untuk mencari data transaksi</div>
          </div>

          {{-- Notifikasi Siswa Belum Bayar --}}
          @if ($this->statistics['studentsNotPaidCount'] > 0)
            <div class="card mb-3">
              <div class="card-body">
                <button type="button" class="btn btn-primary btn-block btn-xl font-bold" data-bs-toggle="modal"
                  data-bs-target="#notPaidModal">
                  <i class="bi bi-exclamation-triangle me-2"></i>
                  Ada <b>{{ $this->statistics['studentsNotPaidCount'] }}</b> siswa belum membayar
                  pada
                  {{ $selectedMonthName ?? 'periode ini' }}! Klik untuk lihat detail
                </button>
              </div>
            </div>
          @endif

          {{-- Modal Siswa Belum Bayar --}}
          <div wire:ignore.self data-bs-backdrop="static" class="modal fade" id="notPaidModal" tabindex="-1"
            aria-labelledby="notPaidModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="notPaidModalLabel">
                    Daftar Siswa Yang Belum Membayar {{ $selectedMonthName ?? '' }}
                  </h1>
                  <button wire:loading.attr="disabled" type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    @foreach ($this->statistics['studentsNotPaid'] as $student)
                      <div class="col-sm-12 col-md-6 mb-3">
                        <div class="card border rounded">
                          <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $student->name }}</h5>
                            <p class="card-text text-muted">
                              {{ $student->identification_number }}
                            </p>
                            <p class="card-text text-muted">
                              <span class="badge bg-secondary">
                                <i class="bi bi-telephone-fill"></i>
                                {{ $student->phone_number }}
                              </span>
                            </p>
                            <span class="badge bg-primary"><i class="bi bi-bookmark"></i>
                              {{ $student->schoolClass->name }}</span>
                            <span class="badge bg-success"><i class="bi bi-briefcase"></i>
                              {{ $student->schoolMajor->name }}</span>
                            <span class="badge bg-light-{{ $student->gender == 1 ? 'primary' : 'danger' }}">
                              <i class="bi bi-gender-{{ $student->gender == 1 ? 'male' : 'female' }}"></i>
                            </span>
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

          {{-- Pencarian Nama Siswa --}}
          <div class="mb-3">
            <div class="form-group has-icon-left">
              <div class="position-relative">
                <input wire:model.live="query" type="text" class="form-control form-control shadow-sm rounded fw-bold"
                  placeholder="Cari berdasarkan nama siswa...">
                <div class="form-control-icon">
                  <i class="bi bi-search"></i>
                </div>
              </div>
            </div>
          </div>

          {{-- Tombol Refresh --}}
          <div class="d-flex justify-content-end mb-3">
            <button wire:click="$refresh" class="btn btn-outline-secondary btn-sm rounded">
              <i class="bi bi-arrow-clockwise me-1"></i> Refresh Data
            </button>
          </div>

          {{-- Tabel Hasil Filter --}}
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nama Siswa</th>
                  <th scope="col">Total Bayar</th>
                  <th scope="col">Tanggal</th>
                  <th scope="col">Dicatat Oleh</th>
                  <th scope="col" class="text-center">Bukti</th>
                </tr>
              </thead>
              <tbody>
                <tr wire:loading>
                  <td colspan="6">
                    <div class="d-flex justify-content-center">
                      <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                      </div>
                    </div>
                  </td>
                </tr>
                @php
                  $startIndex = ($filteredResult->currentPage() - 1) * $filteredResult->perPage() + 1;
                @endphp
                @forelse ($filteredResult as $index => $cashTransaction)
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
                    </td>
                    <td>{{ local_amount_format($cashTransaction->amount) }}</td>
                    <td>{{ \Carbon\Carbon::parse($cashTransaction->date_paid)->format('d-m-Y') }}
                    </td>
                    <td class="text-center">
                      <span class="badge bg-primary">
                        <i class="bi bi-person-badge-fill"></i>
                        {{ $cashTransaction->createdBy->name }}
                      </span>
                    </td>
                    <td class="text-center">
                      @if ($cashTransaction->proof_image)
                        {{-- BUTTON DENGAN FUNGSI BARU: showProofPreviewFilter --}}
                        <button type="button" class="btn btn-link p-0 border-0" onclick="window.showProofPreviewFilter(
                              '{{ asset('uploads/' . $cashTransaction->proof_image) }}',
                              '{{ $cashTransaction->student->identification_number }}',
                              '{{ addslashes($cashTransaction->student->name) }}',
                              '{{ $cashTransaction->date_paid }}'
                            )">
                          {{-- Tambahkan onerror di sini juga untuk jaga-jaga --}}
                          <img src="{{ asset('uploads/' . $cashTransaction->proof_image) }}" alt="Bukti"
                            class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover; cursor: pointer;"
                            title="Klik untuk perbesar & download"
                            onerror="this.onerror=null; this.src='{{ asset('images/no-image.png') }}';">
                        </button>
                      @else
                        {{-- Placeholder jika data null --}}
                        <img src="{{ asset('images/no-image.png') }}" alt="Tidak ada bukti" class="img-thumbnail opacity-50"
                          style="width: 50px; height: 50px; object-fit: cover;" title="Bukti belum diupload">
                      @endif
                    </td>
                  </tr>
                @empty
                  <tr wire:loading.remove class="text-center">
                    <th colspan="6" class="fw-bold">
                      @if ($selected_month || $selected_year)
                        Tidak ada transaksi ditemukan untuk periode yang dipilih!
                      @else
                        Silakan pilih bulan/tahun untuk melihat data transaksi!
                      @endif
                    </th>
                  </tr>
                @endforelse
              </tbody>
              @empty(!$filteredResult)
                <tfoot>
                  <tr role="row">
                    <td colspan="4" class="fw-bold">Total
                      {{ $selectedMonthName ?? 'Periode Dipilih' }}:
                    </td>
                    <td colspan="2">
                      <span class="fw-bold">{{ local_amount_format($sumAmountDateRange) }}</span>
                    </td>
                  </tr>
                </tfoot>
              @endempty
            </table>
            {{ $filteredResult->links(data: ['scrollTo' => false]) }}
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Modal Preview Bukti --}}
  <div wire:ignore.self class="modal fade" id="proofPreviewModalFilter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            <i class="bi bi-receipt me-2"></i>Bukti Pembayaran SPP
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <div id="proofInfoFilter" class="mb-3 text-start">
            <p class="mb-1"><strong>Siswa:</strong> <span id="studentNameFilter"></span></p>
            <p class="mb-1"><strong>NIS:</strong> <span id="studentNISFilter"></span></p>
            <p class="mb-1"><strong>Tanggal:</strong> <span id="paymentDateFilter"></span></p>
          </div>
          <img id="previewProofImageFilter" src="" class="img-fluid rounded shadow" alt="Preview Bukti Pembayaran"
            style="max-height: 60vh; object-fit: contain;">
          <div class="mt-3 text-muted small" id="fileNameInfoFilter"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-1"></i> Tutup
          </button>
          <a id="downloadProofLinkFilter" href="" download class="btn btn-primary">
            <i class="bi bi-download me-1"></i> Download Bukti
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

@script
<script>
  // GANTI NAMA FUNGSI MENJADI: showProofPreviewFilter
  window.showProofPreviewFilter = function (imageSrc, studentId, studentName, paymentDate) {

    // 1. Format Nama File
    const cleanName = studentName.replace(/[^a-zA-Z0-9]/g, '_');
    const cleanDate = paymentDate.split(' ')[0];
    const fileExtension = imageSrc.split('.').pop().split('?')[0];
    const fileName = `SPP_${studentId}_${cleanName}_${cleanDate}.${fileExtension}`;

    // 2. Format Tanggal
    const displayDate = new Date(paymentDate).toLocaleDateString('id-ID', {
      day: '2-digit',
      month: 'long',
      year: 'numeric'
    });

    // 3. Update Info di Modal (Pastikan ID sesuai dengan HTML modal di file ini)
    document.getElementById('studentNameFilter').textContent = studentName;
    document.getElementById('studentNISFilter').textContent = studentId;
    document.getElementById('paymentDateFilter').textContent = displayDate;
    document.getElementById('fileNameInfoFilter').textContent = `File: ${fileName}`;

    // 4. Handle Gambar & Download
    const previewImage = document.getElementById('previewProofImageFilter');
    const downloadLink = document.getElementById('downloadProofLinkFilter');

    previewImage.src = '';
    previewImage.alt = 'Memuat gambar...';

    const img = new Image();
    img.onload = function () {
      previewImage.src = imageSrc;
      previewImage.alt = `Bukti pembayaran ${studentName}`;

      downloadLink.href = imageSrc;
      downloadLink.download = fileName;
      downloadLink.style.display = 'inline-block';

      // Tampilkan Modal
      const modalElement = document.getElementById('proofPreviewModalFilter');
      const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
      modal.show();
    };

    img.onerror = function () {
      alert("Gambar tidak ditemukan atau rusak.");
    };

    img.src = imageSrc;
  }
</script>
@endscript
