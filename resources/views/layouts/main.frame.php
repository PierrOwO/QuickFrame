<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <script src="<?= asset('js/jquery/3.7.1/jquery.js') ?>" ></script>
    <link rel="stylesheet" href="<?= asset('css/select2/4.1.0.min.css') ?>">
    <script src="<?= asset('js/select2/4.1.0.min.js') ?>" ></script>
   
@yield('styles')
</head>
<body>
@yield('content')
</body>
</html>
@yield('scripts')
<script>
    const _token = $('meta[name="csrf-token"]').attr('content');
    console.log('csrf token: ' + _token);
</script>