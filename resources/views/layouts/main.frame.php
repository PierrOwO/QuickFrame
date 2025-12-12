@php
use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="description" content="QuickFrame is a simple, lightweight PHP framework featuring routing, controllers, sessions, and Blade-like views. Perfect for small projects and learning." />
    <meta name="keywords" content="QuickFrame, PHP framework, routing, sessions, custom framework, lightweight framework" />
    <meta name="author" content="Piotr Miłoś" />
    
    @vite(['js/app.js', 'js/mainApp.js'])
@yield('headerScripts')
@yield('styles')
<style>
  body{
      background-color: #f8f8f8;
  }
</style>
</head>
<body>
<main>
    @yield('content')
  </main>
<footer class="footer">
  <div class="container">
    <p>&copy; {{Carbon::now()->format('Y')}} QuickFrame v{{config('app.version_framework')}} by PierrOwO. MIT License. <a href="https://github.com/PierrOwO/quickframe">GitHub</a></p>
  </div>
</footer>
@yield('scripts')
</body>
</html>
