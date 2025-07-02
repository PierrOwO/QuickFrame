<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>View migrations</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 2rem;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 2rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            padding-bottom: 60px;
        }
        h1 {
            color: #333;
            margin-bottom: 1rem;
        }
        p {
            color: #555;
        }
        .table-wrapper {
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #000;
            margin: auto;
            width: 80%;
        }

        table {
            width: 100%;
            text-align: center;
            border-collapse: collapse;
            border-style: hidden;
        }
        table thead tr:first-child{
            background-color: rgb(212, 212, 212);
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
        }
        tbody td button{
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            transition: 0.25s;
        }
        tbody td button:first-child{
            background-color: rgb(99, 192, 84);
        }
        tbody td button:first-child:hover{
            background-color: rgb(94, 172, 82);
        }
        tbody td button:nth-child(2){
            background-color: rgb(245, 95, 95);
        }
        tbody td button:nth-child(2):hover{
            background-color: rgb(224, 101, 101);
        }
        tbody td button:last-child{
            background-color: rgb(101, 169, 229);
        }
        tbody td button:last-child:hover{
            background-color: rgb(100, 151, 196);
        }
        .modal{
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-color: rgb(0,0,0,0.5);
            display: none;
            justify-content: center;
            align-items: flex-start; 
            overflow-y: auto; 
            transition: 0.4s;
        }
        .modal .modal-content{
            position: relative;
            top: -100%;
            margin-top: 50px;
            margin-bottom: 50px;
            width: 400px;
            background-color: white;
            display: flex;
            flex-direction: column;
            border-radius: 10px;
            transition: 0.4;
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        }
        .modal .modal-content .modal-header,
        .modal .modal-content .modal-footer {
            height: 50px;
            line-height: 50px;
            display: flex;
            background-color: rgb(0,0,0,0.03);
            padding: 0px 5px;
        }
       .modal .modal-content .modal-body{
           
            padding: 20px
        }

        .modal .modal-content .modal-footer {
            justify-content: right;
            align-items: center;
        }
        .modal .modal-content .modal-footer button{
            height: 30px;
            margin-right: 5px;
            border-radius: 4px;
            border: none;
            background-color: rgb(235, 107, 107);
            color: white;
            transition: 0.25s;
        }
        .modal .modal-content .modal-footer button:hover{
            background-color: rgb(223, 86, 86);
            cursor: pointer;
        }

        .modal .modal-content-80{
            width: 80%;
        }
        @keyframes modal-background-on {
            from {background-color: rgb(0,0,0,0.0)}
            to {background-color: rgb(0,0,0,0.5)}
        }
        @keyframes modal-background-off {
            from {background-color: rgb(0,0,0,0.5)}
            to {background-color: rgb(0,0,0,0.0)}
        }
        @keyframes content-down {
            from {top: -100%}
            to {top: 0}
        }
        @keyframes content-up {
            from {top: 0}
            to {top: -100%}
        }
        .modal-background-on{
            animation: 0.4s modal-background-on ;
        }
        .modal-background-off{
            animation: 0.4s modal-background-off;
        }
        .content-up{
            animation: 0.4s content-up;
        }
        .content-down{
            animation: 0.4s content-down;
        }
    </style>
    <?= vite('js/app.js') ?>
    <?= vite('js/app-select2.js') ?>
    </head>
<body>
    <div class="container">
        <h1>Migrations setup</h1>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Migration file</th>
                        <th>Created at</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @if (!empty($migrations))
                @foreach ($migrations as $migration)
                    <tr>
                        <td>{{ $migration['name'] }}</td>
                        <td>{{ $migration['created_at'] }}</td>
                        <td>
                        <button data-value="{{ $migration['name'] }}" onclick="runMigration(this.dataset.value)">Run</button>
                        <button data-value="{{ $migration['name'] }}" onclick="dropMigration(this.dataset.value)">Drop</button>
                        <button data-value="{{ $migration['name'] }}" onclick="showMigration(this.dataset.value)">Show</button>
                        </td>
                    </tr>
                @endforeach
                @else
                    <tr>
                        <td colspan="3">No migrations found</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <div id="modal" class="modal">
        <div id="modal-content" class="modal-content">
            <div class="modal-header"><a id="modal-title">title</a></div>
            <div class="modal-body" id="modal-body"></div>
            <div class="modal-footer"><button onclick="closeModal()">Close</button></div>
        </div>
    </div>
    
</body>
</html>
<script>
    
    const modal = document.getElementById('modal');
    const modalContent = document.getElementById('modal-content');
    const modalTitle = document.getElementById('modal-title');
    const modalBody = document.getElementById('modal-body');

    function openModal(key, title, body){
        if(key === 1){
            modalContent.classList.add('modal-content-80');
            modalBody.classList.remove('modal-body');
            modalBody.classList.add('modal-body-large');
        }
        modal.style.display = 'flex';
        modal.classList.add('modal-background-on');
        modalContent.classList.add('content-down');

        modalTitle.textContent = title;
        modalBody.innerHTML = body;

        setTimeout(() => {
            modal.classList.remove('modal-background-on');
            modalContent.classList.remove('content-down');
            modalContent.style.top = '0';
            document.body.style.overflow  = 'hidden';
        }, 350); 
    }
    function closeModal(){
        
        
        modal.classList.add('modal-background-off');
        modalContent.classList.add('content-up');
        setTimeout( function() {
            modal.classList.remove('modal-background-off');
            modalContent.classList.remove('content-up');
            modalContent.style.top = '-100%';
            modal.style.display = 'none';
            modalContent.classList.remove('modal-content-80');
            modalBody.classList.add('modal-body');
            modalBody.classList.remove('modal-body-large');
            document.body.style.overflow = 'auto';
        }, 350);
    }

    function showMigration(migration){
        var formData = {
            migration: migration,
            _token: $('meta[name="csrf-token"]').attr('content')
        };
        $.ajax({
            url:"/migrations/show",
            method:"post",
            data: formData,
            success:function(response){  
                let jsonResponse = JSON.parse(response);
                openModal(1, "show mgration", jsonResponse.data);
                
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                alert(xhr.responseText);
            
                if (xhr.status === 419 || xhr.status === 401) {
                    window.location.reload();
                } else {
                    console.error(error);
                    alert('Error');
                }
            }
        });
    }
    function runMigration(migration){
        var formData = {
            migration: migration,
            _token: $('meta[name="csrf-token"]').attr('content')
        };
        $.ajax({
            url:"/migrations/run",
            method:"post",
            data: formData,
            success:function(response){  
                let jsonResponse = JSON.parse(response);
                openModal(0, "show mgration", jsonResponse.data);
                
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
               // alert(xhr.responseText);
            openModal(1, "show mgration", xhr.responseText);
                if (xhr.status === 419 || xhr.status === 401) {
                    window.location.reload();
                } else {
                    console.error(error);
                   //alert('Error');
                }
            }
        });
    }
    function dropMigration(migration){
        var formData = {
            migration: migration,
            _token: $('meta[name="csrf-token"]').attr('content')
        };
        $.ajax({
            url:"/migrations/drop",
            method:"post",
            data: formData,
            success:function(response){  
                let jsonResponse = JSON.parse(response);
                openModal(0, "show mgration", jsonResponse.data);
                
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
               // alert(xhr.responseText);
            openModal(1, "show mgration", xhr.responseText);
                if (xhr.status === 419 || xhr.status === 401) {
                    window.location.reload();
                } else {
                    console.error(error);
                   //alert('Error');
                }
            }
        });
    }
</script>