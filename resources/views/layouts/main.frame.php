<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="<?= asset('css/select2/4.1.0.min.css') ?>">
    <script src="<?= asset('js/select2/4.1.0.min.js') ?>" defer></script>
    <script src="<?= asset('js/jquery/3.7.1/jquery.js') ?>" defer></script>
@yield('styles')
</head>
<body>
@yield('content')
</body>
</html>
@yield('scripts')