@php

@endphp
@extends('layouts.auth')
@section('title', 'user register')
@section('styles')
<style>
    
    .register{
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
    .register .content{
        width: 400px;
        height: auto;
        padding: 20px 0px;
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
    .register .content .body{
        width: 80%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
    .register .content .body span{
        text-align: center;
        margin-bottom: 15px;
    }
    .register .content .body input,
    .register .content .body button{
        width: 100%;
        padding: 15px;
        margin-bottom: 15px;
        font-size: 20px;
        border-radius: 3px;
        
    }
    .register .content .body input{
        border: 1px solid #a6a6a6;
    }

    .register .content .body button{
        margin-bottom: 0px;
        transition: 0.3s;
        border: none;
        cursor: pointer;
        
    }
    .register .content .body .report-msg{
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
    .register .content .body .error-span{
        font-size: 14px;
        color: red;
        display: none;
        padding: 0px;
        
    }
    .register .content .body .input-error{
        border: 1px solid red;
    }
</style>
@endsection
@section('content')
    <div class="register">
 	    <div class="content">
 	        <div class="body">
 	            <span>Registration</span>
                
                <input id="first-name" name="first_name" type="text" placeholder="First name" required minlength="3" maxlength="50" pattern="[A-Za-z0-9_-]+">
                <span id="error-first_name" class="error-span" role="alert"></span>
                
                <input id="last-name" name="last_name" type="text" placeholder="Last name" required minlength="3" maxlength="50" pattern="[A-Za-z0-9_-]+">
                <span id="error-last_name" class="error-span" role="alert"></span>
                
                <input id="email" name="email" type="email" placeholder="E-mail" required>
                <span id="error-email" class="error-span" role="alert"></span>
                
                <input id="name" name="name" type="text" placeholder="Login" required minlength="3" maxlength="50" pattern="[A-Za-z0-9_-]+">
                <span id="error-name" class="error-span" role="alert"></span>
                
                <input id="password" name="password" type="password" placeholder="Password" required minlength="6">
                <span id="error-password" class="error-span" role="alert"></span>
                
                <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm Password" required minlength="6">
                <span id="error-password_confirmation" class="error-span" role="alert"></span>
                
                <button onclick="register()" class="button5">Register</button>
                <span id="msg" class="report-msg"></span>
 	        </div>
 	    </div>
 	</div>
@endsection