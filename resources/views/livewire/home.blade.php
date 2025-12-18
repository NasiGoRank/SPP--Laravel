<div class="home-wrapper">
  {{-- 1. NAVBAR --}}
  <nav class="navbar navbar-expand-lg bg-body shadow-sm fixed-top border-bottom border-transparent"
    style="z-index: 1080; position: fixed !important; top: 0; width: 100%; height: 80px;">
    <div class="container">
      <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="#">
        <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="me-2" style="height: 40px; width: auto;">
        <span>SMK 54 Negeri Jakarta</span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item"><a class="nav-link px-3" href="#info">Tentang Sekolah</a></li>
          <li class="nav-item"><a class="nav-link px-3" href="#programs">Program</a></li>
          <li class="nav-item"><a class="nav-link px-3" href="#majors">Jurusan</a></li>

          {{-- TOGGLE DARK MODE --}}
          <li class="nav-item px-lg-3 py-2 py-lg-0" wire:ignore>
            <div class="theme-toggle d-flex gap-2 align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="text-warning">
                <circle cx="12" cy="12" r="5"></circle>
                <line x1="12" y1="1" x2="12" y2="3"></line>
                <line x1="12" y1="21" x2="12" y2="23"></line>
                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                <line x1="1" y1="12" x2="3" y2="12"></line>
                <line x1="21" y1="12" x2="23" y2="12"></line>
                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
              </svg>
              <div class="form-check form-switch mb-0">
                <input class="form-check-input" type="checkbox" id="toggle-dark-home" style="cursor: pointer">
              </div>
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="text-primary">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
              </svg>
            </div>
          </li>

          <li class="nav-item ms-lg-2">
            <a href="{{ route('login') }}" class="btn btn-primary px-4 rounded-pill fw-bold">Masuk / Login</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  {{-- 2. HERO SECTION --}}
  <section class="d-flex align-items-center justify-content-center text-center text-white"
    style="min-height: 85vh; padding-top: 80px; background: linear-gradient(135deg, #435ebe 0%, #25396f 100%);">
    <div class="container">
      <h1 class="display-3 fw-bold mb-3 text-light">Selamat Datang di SMKN 54 Jakarta</h1>
      <p class="lead mb-4 px-md-5 mx-md-5 opacity-75">Membentuk Generasi Cerdas, Berkarakter, dan Siap Kerja.</p>
      <a href="#info" class="btn btn-light btn-lg rounded-pill px-5 text-primary fw-bold shadow">Pelajari Lebih Lanjut</a>
    </div>
  </section>

  {{-- 3. INFORMASI SEKOLAH --}}
  <section id="info" class="py-5 bg-body">
    <div class="container py-5">
      <div class="row align-items-stretch">
        <div class="col-lg-6 mb-4 mb-lg-0">
          <img src="https://smkn54jkt.sch.id/wp-content/uploads/2025/04/a38fc-panel-surya-1.webp" alt="Sekolah"
            class="img-fluid rounded-4 shadow-lg h-100 w-100" style="object-fit: cover; min-height: 350px;">
        </div>
        <div class="col-lg-6 ps-lg-5 d-flex flex-column justify-content-center">
          <h6 class="text-primary fw-bold text-uppercase ls-md">Tentang Kami</h6>
          <h2 class="fw-bold mb-4">Mewujudkan Pendidikan Berkualitas</h2>
          <p class="text-muted mb-4">SMK Hebat berkomitmen menyediakan lingkungan belajar yang kondusif dengan fasilitas
            modern.</p>
          <ul class="list-unstyled">
            <li class="mb-3 d-flex align-items-start">
              <i class="bi bi-check-circle-fill text-success me-3 fs-5 mt-1"></i>
              <div>
                <span class="fw-bold d-block">Fasilitas Lengkap</span>
                <small class="text-muted">Laboratorium modern, perpustakaan, dan area praktik memadai.</small>
              </div>
            </li>
            <li class="mb-3 d-flex align-items-start">
              <i class="bi bi-check-circle-fill text-success me-3 fs-5 mt-1"></i>
              <div>
                <span class="fw-bold d-block">Pengajar Berkompeten</span>
                <small class="text-muted">Guru praktisi ahli di bidangnya dan berpengalaman industri.</small>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  {{-- 4. PROGRAM PENDIDIKAN --}}
  <section id="programs" class="py-5 bg-body-tertiary">
    <div class="container py-5">
      <div class="text-center mb-5">
        <h6 class="text-primary fw-bold text-uppercase ls-md">Pilihan Masa Depan</h6>
        <h2 class="fw-bold">Program Pendidikan</h2>
      </div>
      <div class="row justify-content-center g-4">
        @foreach($programs as $program)
          <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm p-4 hover-lift transition-all">
              <div class="card-body d-flex flex-column text-center">
                <div class="mb-4">
                  <span class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block">
                    <i
                      class="bi {{ str_contains(strtolower($program->name), 'unggulan') ? 'bi-patch-check-fill' : 'bi-award-fill' }} text-primary fs-2"></i>
                  </span>
                </div>
                <h4 class="fw-bold mb-3">{{ $program->name }}</h4>
                <p class="text-muted small mb-4">Program dengan kurikulum terintegrasi langsung dengan mitra industri.</p>
                <div class="mt-auto pt-3">
                  <p class="text-muted mb-1 small">Biaya Per Bulan</p>
                  <h3 class="text-primary fw-bold">Rp {{ number_format($program->fee, 0, ',', '.') }}</h3>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- 5. JURUSAN (DI BALIKIN LAGI) --}}
  <section id="majors" class="py-5 bg-body">
    <div class="container py-5">
      <div class="text-center mb-5">
        <h2 class="fw-bold">Jurusan Tersedia</h2>
        <p class="text-muted">Fokus keahlian untuk masa depan karir Anda.</p>
      </div>

      <div class="row g-4">
        @forelse($majors as $major)
          <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm overflow-hidden bg-body-tertiary card-hover">
              <div class="row g-0 h-100">
                <div class="col-4 bg-primary d-flex align-items-center justify-content-center text-white">
                  <h2 class="fw-bold mb-0">{{ $major->abbreviation }}</h2>
                </div>
                <div class="col-8">
                  <div class="card-body d-flex flex-column justify-content-center h-100 p-4">
                    <h5 class="card-title fw-bold mb-2">{{ $major->name }}</h5>
                    <p class="card-text text-muted small">
                      Mempelajari bidang keilmuan {{ strtolower($major->name) }} dengan praktik dan teori seimbang.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12 text-center text-muted">
            <p>Data jurusan belum tersedia.</p>
          </div>
        @endforelse
      </div>
    </div>
  </section>

  {{-- FOOTER --}}
  <footer class="bg-dark text-white py-5 text-center mt-5">
    <div class="container">
      <p class="mb-0 opacity-75">&copy; {{ date('Y') }} SMK 54 Negeri Jakarta. All Rights Reserved.</p>
    </div>
  </footer>

  <script data-navigate-once>
    const syncHomeTheme = () => {
      const toggler = document.getElementById("toggle-dark-home");
      if (!toggler) return;
      const themeKey = "theme";
      const storedTheme = localStorage.getItem(themeKey) || 'light';
      toggler.checked = storedTheme === "dark";
      document.documentElement.setAttribute("data-bs-theme", storedTheme);

      toggler.addEventListener("change", (e) => {
        const newTheme = e.target.checked ? "dark" : "light";
        localStorage.setItem(themeKey, newTheme);
        document.documentElement.setAttribute("data-bs-theme", newTheme);
        if (typeof setTheme === 'function') setTheme(newTheme, true);
      });
    };
    document.addEventListener("livewire:navigated", syncHomeTheme);
  </script>

  <style>
    body {
      overflow-x: hidden;
      padding-right: 0 !important;
    }

    .navbar {
      transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .border-transparent {
      border-bottom: 1px solid transparent !important;
    }

    [data-bs-theme="dark"] .navbar {
      background-color: rgba(26, 26, 39, 0.95) !important;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
      backdrop-filter: blur(10px);
    }

    [data-bs-theme="dark"] .navbar-nav .nav-link {
      color: rgba(255, 255, 255, 0.8) !important;
    }

    [data-bs-theme="dark"] .navbar-brand,
    [data-bs-theme="dark"] .navbar-nav .nav-link:hover {
      color: #fff !important;
    }

    .hover-lift:hover {
      transform: translateY(-10px);
    }

    .card-hover:hover {
      transform: scale(1.02);
      transition: all 0.3s ease;
    }

    .ls-md {
      letter-spacing: 0.1rem;
    }
  </style>
</div>
