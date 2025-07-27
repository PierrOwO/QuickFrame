@php

@endphp
@extends('layouts.auth')
@section('title', 'System - logowanie')
@section('styles')
<style>
.login{
    background-color: #AAC8A7;
    position: absolute;
    top:0;
    left: 0 ;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}
.login .content{
    width: 400px;
    height: 400px;
    overflow: hidden;
    background-color: #fff;
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 5px;
    font-size: 25px;
    background-color: #fff;
}
.login .content .body{
    width: 80%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}
.login .content .body span{
    text-align: center;
    margin-bottom: 15px;
}
.login .content .body input,
.login .content .body button{
    width: 100%;
    padding: 15px;
    margin-bottom: 15px;
    font-size: 20px;
    border-radius: 3px;
    
}
.login .content .body input{
    border: 1px solid #a6a6a6;
}

.login .content .body button{
    margin-bottom: 0px;
    transition: 0.3s;
    border: none;
    cursor: pointer;
    
}
.login .content .body .report-msg{
    font-size: 20px;
    height: 25px;
    line-height: 25px;
    margin-bottom: 0px;
    font-weight: bold;
    margin-top: 5px;
}

.button5 {
  background-color: #46a049; 
  color: white; 
  
}

.button5:hover {
  background-color: #5fb962;
}
.login .content .body .error-span{
    font-size: 14px;
    color: red;
    display: none;
    padding: 0px;
}
.login .content .body .input-error{
    border: 1px solid red;
}
</style>
@endsection
@section('content')
    <div class="login">
 	    <div class="content">
 	        <div class="body">
 	            <span>Logowanie</span>
                
                <input id="name" name="name" type="text" placeholder="Login" required minlength="3" maxlength="50" pattern="[A-Za-z0-9_-]+">
                <span id="error-name" class="error-span" role="alert"></span>
                
                <input id="password" name="password" type="password" placeholder="Password" required minlength="6">
                <span id="error-password" class="error-span" role="alert"></span>
               
                <button onclick="login()" class="button5">Login</button>
                <span id="msg" class="report-msg"></span>
 	        </div>
 	    </div>
 	</div>
@endsection