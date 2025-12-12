@extends('layouts.app')
@section('title', "$title")
@section('styles')
<style>
    body{
        background-color: #f8f8f8;
    }
    html {
  scroll-behavior: smooth;
}

</style>
@endsection
@section('content')

<div id="app" data-view="{{ $view }}"></div>

@endsection
@section('scripts')
<script>

</script>
@endsection
