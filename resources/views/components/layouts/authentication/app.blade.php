<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? config('app.name') }} - SPP</title>
  <link rel="shortcut icon"
    href="{{ asset('images/Logo.png') }}"
    type="image/x-icon" />
  <link rel="shortcut icon"
    href="{{ asset('images/Logo.png') }}"
    type="image/png" />
  <link rel="stylesheet" crossorigin href="{{ asset('compiled/css/app.css') }}">
  <link rel="stylesheet" crossorigin href="{{ asset('compiled/css/app-dark.css') }}">
  <link rel="stylesheet" crossorigin href="{{ asset('compiled/css/auth.css') }}">
</head>

<body>
  <script src="{{ asset('static/js/initTheme.js') }}"></script>
  {{ $slot }}

  <script src="{{ asset('compiled/js/app.js') }}"></script>
</body>

</html>
