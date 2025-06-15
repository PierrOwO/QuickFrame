<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>404</title>
    <style>
        body{
            background-color: #EF4B4B;
            overflow: hidden;
        }
        .message{
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            width: 500px;
            height: 400px;
            border-radius: 8px;
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            overflow: hidden;
        }
        .message .content{
            height: 100%;
            width: 100%;
            display: flex;
            flex-direction: column;
            
            
        }
        .message .content .header{
            display: flex;
            font-size: 50px;
            width: 100%;
            align-items: left;
            font-weight: bold;
            height: 50px;
            color: #EF4B4B;
        }
        .message .content .header a{
            padding-left: 10px;
            padding-top: 10px;
        }
        .message .content .body{
            display: flex;
            height: 280px;
            font-size: 18px;
            color: black;
            width: 100%;
            align-items: left;
            font-weight: bold;
        }
        .message .content .body a{
            padding-top: 20px;
            padding-left: 10px;
        }
        .message .content .footer{
            width: 100%;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .message .content .footer button{
            height: 44px;
            width: 200px;
            border-radius: 4px;
            background-color: #EF4B4B;
            color: white;
            border: none;
            cursor: pointer;
        }
        .message .content .footer button:hover{
            background-color:rgb(202, 73, 73);
        }
        .message .content .footer button:active{
            background-color:rgb(170, 69, 69);
        }

    </style>
</head>
<body>
    <div class="message">
        <div class="content">
            <div class="header">
                <a>Error 404</a>
            </div>
            <div class="body">
                <a>{{ $message }}</a>
            </div>
            <div class="footer">
                <button onclick="homePage()">Go back to home page</button>
            </div>
        </div>
    </div>
</body>
</html>
<script>
    function homePage(){
        window.location.replace('/');
    }
</script>