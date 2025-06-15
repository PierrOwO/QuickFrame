@extends('layouts.main')
@section('title', 'Home page')
@section('styles')
<style>
h1, h2, h3, h4, button {
    display: block;
    margin: 10px;
}
</style>
@endsection
@section('content')
<h1>Hello world!</h1>
<h2>This is home page</h2>
<button id="button" onclick="showMagic()">Click here to see magic</button>
<h3 style="opacity: 0;" id="magic">Magic</h3>
@endsection
@section('scripts')
<script>
var isMagic = false;
function showMagic(){
    const magic =document.getElementById('magic');
    const button =document.getElementById('button');
    if(!isMagic) {
        magic.style.opacity = '1';
        button.textContent = "Click here to hide magic"
        isMagic = true;
    }
    else {
        magic.style.opacity = '0';
        button.textContent = "Click here to see magic"
        isMagic = false;
    }
    
}
</script>
@endsection