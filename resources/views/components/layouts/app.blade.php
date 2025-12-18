<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $title ?? config('app.name') }} - SPP</title>

  <link rel="shortcut icon"
    href="{{ asset('images/Logo.png') }}"
    type="image/x-icon" />
  <link rel="shortcut icon"
    href="{{ asset('images/Logo.png') }}"
    type="image/png" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" crossorigin href="{{ asset('compiled/css/app.css') }}" />
  <link rel="stylesheet" crossorigin href="{{ asset('compiled/css/app-dark.css') }}" />
  <link rel="stylesheet" crossorigin href="{{ asset('compiled/css/iconly.css') }}" />
  <link rel="stylesheet" crossorigin href="{{ asset('extensions/sweetalert2/sweetalert2.min.css') }}" />
  @vite('resources/js/app.js')
</head>

<body>
  <script src="{{ asset('static/js/initTheme.js') }}" data-navigate-once></script>
  <div id="app">
    <div id="sidebar">
      <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
          <div class="d-flex justify-content-between align-items-center">
            <div class="logo">
              <a href="{{ route('dashboard') }}"></a>
              <h2 style="font-size: 20px;" class="text-primary mb-0">SPP Management System</h2>
            </div>
            <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                role="img" class="iconify iconify--system-uicons" width="20" height="20"
                preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                  <path
                    d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                    opacity=".3"></path>
                  <g transform="translate(-210 -1)">
                    <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                    <circle cx="220.5" cy="11.5" r="4"></circle>
                    <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
                    </path>
                  </g>
                </g>
              </svg>
              <div class="form-check form-switch fs-6">
                <input class="form-check-input me-0" type="checkbox" id="toggle-dark" style="cursor: pointer" />
                <label class="form-check-label"></label>
              </div>
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet"
                viewBox="0 0 24 24">
                <path fill="currentColor"
                  d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                </path>
              </svg>
            </div>
            <div class="sidebar-toggler x">
              <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
            </div>
          </div>
        </div>
        <div class="sidebar-menu">
          <ul class="menu">
            <li class="sidebar-title">Menu</li>

            <x-sidebar.sidebar-item :active="request()->routeIs('dashboard')">
              <x-sidebar.sidebar-link :href="route('dashboard')" icon="bi bi-grid-fill" wire:navigate>
                Dashboard
              </x-sidebar.sidebar-link>
            </x-sidebar.sidebar-item>

            <li class="sidebar-title"><i class="bi bi-menu-button-wide-fill"></i></li>

            <x-sidebar.sidebar-item :active="request()->routeIs('students.index')">
              <x-sidebar.sidebar-link :href="route('students.index')" icon="bi bi-people-fill" wire:navigate>
                Pelajar
              </x-sidebar.sidebar-link>
            </x-sidebar.sidebar-item>

            <x-sidebar.sidebar-item :active="request()->routeIs('school-classes.index')">
              <x-sidebar.sidebar-link :href="route('school-classes.index')" icon="bi bi-bookmark-fill" wire:navigate>
                Kelas
              </x-sidebar.sidebar-link>
            </x-sidebar.sidebar-item>

            <x-sidebar.sidebar-item :active="request()->routeIs('school-majors.index')">
              <x-sidebar.sidebar-link :href="route('school-majors.index')" icon="bi bi-briefcase-fill" wire:navigate>
                Jurusan
              </x-sidebar.sidebar-link>
            </x-sidebar.sidebar-item>

            <x-sidebar.sidebar-item class="has-sub" :active="request()->routeIs('cash-transactions.*')">
              <x-sidebar.sidebar-link href="#" icon="bi bi-cash-stack">
                SPP
              </x-sidebar.sidebar-link>

              <ul class="submenu">
                <x-sidebar.submenu-item :active="request()->routeIs('cash-transactions.index')">
                  <x-sidebar.submenu-link :href="route('cash-transactions.index')" wire:navigate>
                    SPP Bulan Ini
                  </x-sidebar.submenu-link>
                </x-sidebar.submenu-item>

                <x-sidebar.submenu-item :active="request()->routeIs('cash-transactions.filter')">
                  <x-sidebar.submenu-link :href="route('cash-transactions.filter')" wire:navigate>
                    Filter SPP
                  </x-sidebar.submenu-link>
                </x-sidebar.submenu-item>
              </ul>
            </x-sidebar.sidebar-item>

            <li class="sidebar-item {{ request()->routeIs('administrators.index') ? 'active' : '' }}">
              <a href="/pengguna" wire:navigate class="sidebar-link">
                <i class="bi bi-person-badge-fill"></i>
                <span>Administrator</span>
              </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('update-profiles.index') ? 'active' : '' }}">
              <a href="/profil" wire:navigate class="sidebar-link">
                <i class="bi bi-person-fill-gear"></i>
                <span>Pengaturan Profil</span>
              </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('school-programs.*') ? 'active' : '' }}">
              <x-sidebar.sidebar-link href="{{ route('school-programs.index') }}" icon="bi bi-journal-bookmark"
                class="{{ request()->routeIs('school-programs.*') ? 'active' : '' }}">
                Manajemen Program
              </x-sidebar.sidebar-link>
            </li>

            <li class="sidebar-item">
              <livewire:authentication.logout />
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div id="main">
      <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
          <i class="bi bi-justify fs-3"></i>
        </a>
      </header>

      <div class="page-heading">
        <h3>{{ $title ?? config('app.name') }}</h3>
      </div>
      <div class="page-content">
        {{ $slot }}
      </div>

      <footer>
        <div class="footer clearfix mb-0 text-muted">
          <div class="float-start">
            <p class="mb-0 opacity-75">&copy; {{ date('Y') }} SMK 54 Negeri Jakarta. All Rights Reserved.</p>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <script src="{{ asset('static/js/components/dark.js') }}" data-navigate-once></script>
  <script src="{{ asset('extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

  <script src="{{ asset('compiled/js/app.js') }}"></script>
  <script src="{{ asset('extensions/sweetalert2/sweetalert2.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Need: Apexcharts -->
  <script src="{{ asset('extensions/apexcharts/apexcharts.min.js') }}"></script>

  <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

<script data-navigate-once>
  const MY_THEME_KEY = "theme";

  document.addEventListener("change", (e) => {
    if (e.target && e.target.id === "toggle-dark") {
      const newTheme = e.target.checked ? "dark" : "light";

      localStorage.setItem(MY_THEME_KEY, newTheme);
      document.documentElement.setAttribute("data-bs-theme", newTheme);
      if (typeof setTheme === 'function') {
        setTheme(newTheme, true);
      }
    }
  });
  const syncThemeUI = () => {
    const toggler = document.getElementById("toggle-dark");
    if (!toggler) return;

    const storedTheme = localStorage.getItem(MY_THEME_KEY);

    toggler.checked = storedTheme === "dark";
    if (storedTheme) {
      document.documentElement.setAttribute("data-bs-theme", storedTheme);
    }
  };
  document.addEventListener("livewire:navigated", () => {
    syncThemeUI();

    document.querySelectorAll(".modal").forEach((modalElement) => {
      modalElement.addEventListener("show.bs.modal", () => {
        document.querySelectorAll(".modal-backdrop").forEach(b => b.remove());
      });
    });

    document.addEventListener("close-modal", () => {
      ["createModal", "editModal", "deleteModal"].forEach(id => {
        const modal = document.getElementById(id);
        if (modal) {
          const inst = bootstrap.Modal.getInstance(modal);
          if (inst) inst.hide();
        }
      });
    });
  });

  document.addEventListener("livewire:init", () => {
    const Toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true
    });
    Livewire.on("success", (e) => Toast.fire({ icon: "success", title: e.message }));
    Livewire.on("warning", (e) => Toast.fire({ icon: "warning", title: e.message }));
  });
</script>
  <style>
    /* Efek hover untuk gambar di tabel */
    .img-thumbnail {
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .img-thumbnail:hover {
      transform: scale(1.05);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Styling untuk modal preview */
    #previewProofImage,
    #editPreviewImage {
      max-height: 70vh;
      width: auto;
      max-width: 100%;
      margin: 0 auto;
      display: block;
    }

    /* Button download styling */
    #downloadProofLink,
    #editDownloadLink {
      min-width: 120px;
    }

    .img-thumbnail {
      transition: all 0.2s ease-in-out;
      border: 2px solid #dee2e6;
    }

    .img-thumbnail:hover {
      transform: scale(1.1);
      border-color: #0d6efd;
      box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
    }
  </style>
  @stack('scripts')
</body>

</html>
