<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    
    <?= vite('js/app.js') ?>
    <?= vite('js/app-select2.js') ?>
   
@yield('styles')
</head>
<body>
@yield('content')
</body>
</html>
@yield('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const _token = $('meta[name="csrf-token"]').attr('content');
        console.log('csrf token: ' + _token);
    });
</script>