<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="description" content="QuickFrame is a simple, lightweight PHP framework featuring routing, controllers, sessions, and Blade-like views. Perfect for small projects and learning." />
    <meta name="keywords" content="QuickFrame, PHP framework, routing, sessions, custom framework, lightweight framework" />
    <meta name="author" content="Piotr Miłoś" />
    
    @vite('js/auth.js')
  <style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #007bff;
    }
  </style>
   
@yield('styles')
</head>
<body>
@yield('content')
@yield('scripts')
</body>
</html>
