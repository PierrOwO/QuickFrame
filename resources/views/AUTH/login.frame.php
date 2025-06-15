@php

@endphp
@extends('layouts.login')
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
</style>
@endsection
@section('content')
    <div class="login">
 	    <div class="content">
 	        <div class="body">
 	            <span>Logowanie</span>
                <input id="name" type="text" placeholder="Podaj login">
                <input id="password" type="password" placeholder="Podaj hasło">
                <button onclick="loginBiuro()" class="button5">Zaloguj</button>
                <span id="msg" class="report-msg"></span>
 	        </div>
 	    </div>
 	</div>
@endsection
@section('scripts')
<script>
    document.addEventListener("keydown", function(event) {
        if (event.key === "Enter" && event.target.tagName === "INPUT") {
            loginBiuro();
        }
    });
     function loginBiuro(){
        var name = document.getElementById('name').value;
        var password = document.getElementById('password').value;
        setMsg(3, '');
        if(password != ''){
            setMsg(2, 'Łączenie...');
            var formData = {
                operacja: '420',
                name: name,
                password: password,
            }
            setTimeout(() => {
                ajaxSendData(formData);
            }, 750);
        }else{
            setMsg(3, 'Wypełnij wszystkie pola');
        }
    }
</script>

<script>

   
    
    function setMsg(type, message){
        var msg = document.getElementById('msg');
        if(type == 1){
            var msgColor = 'green';
        }
        if(type == 2){
            var msgColor = 'blue';
        }
        if(type == 3){
            var msgColor = 'red';
        }
        msg.style.color = msgColor;
        msg.textContent = message;
    }
    
    
    function ajaxSendData(formData){
        $.ajax({
            url:"data/operacje.php",
            method:"post",
            data: formData,
            success:function(response){  
                let jsonResponse = JSON.parse(response);
                var msg = jsonResponse.message;
                if (jsonResponse.status === true){
                    setMsg(1, msg);
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                }
                else{
                    setMsg(3, msg);
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                alert(xhr.responseText);
            
                if (xhr.status === 419 || xhr.status === 401) {
                    window.location.reload();
                } else {
                    console.error(error);
                    alert('Błąd wczytywania');
                }
            }
        });
    }
</script>
@endsection