<?php
    session_start();
    if (isset($_SESSION['login'])){
        header("Location: game.php");
    }
?>
<!doctype html5>
<html>
<head>
    <title>LandKings</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="libraries/codemirror-5.32.0/lib/codemirror.css">
    <meta charset="utf-8">
    <script src="libraries/codemirror-5.32.0/lib/codemirror.js"></script>
    <script src="libraries/codemirror-5.32.0/mode/lua/lua.js"></script>

    <style>
        .popUp {
            top: 12%; 
            left: 45%; 
            height: 300px;
            position: fixed;
            width: 500px;  
            border-radius: 11px;
            background: #fef; 
            margin-left: -150px;    
            margin-top: -100px;
            display: none; 
            opacity: 0;
            padding: 17px;
            z-index: 6;
        }
        .popUp #close {
        cursor: pointer;
            position: absolute;
            width: 23px;
            height: 23px;
            top: 17px;
            right: 17px;
            display: block;
        }
        #overlay {
            z-index:4; 
            background-color:#010; 
            position:fixed; 
            opacity:0.86;
            width:100%; 
            height:100%;
            display:none; 
            top:0;
            left:0;
        }
    </style>

</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="navbar navbar-default">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-main">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="index.php">LandKings</a>
                    </div>
                    <div class="collapse navbar-collapse" id="navbar-main">
                        <ul class="nav navbar-nav pull-right">
                            <li class="active"><a href="index.php">Главная</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>Добро пожаловать в LandKings, странник</h3>
                <h4>Ты уже записался в наши ряды? Сделай это зарегистрировашись или назовись, я найду тебя в списке</h4>
            </div>
            <div class="col-lg-12">
                <button class="btn btn-default" id="login">Войти</button>
                <button class="btn btn-success" id="reg">Зарегистрироваться</button>
            </div>
        </div>
    </div>

    <div id="popUpReg" class="popUp">
        <span id="close">X</span>
        <h4>Регистрация нового пользователя:</h4>
        <div class="form-group">
          <label for="inputRegLogin">Логин: (3 <= длина имени <= 15)</label>
          <input type="text" class="form-control" id="inputRegLogin" placeholder="Введите логин">
        </div>
        <div class="form-group">
          <label for="inputRegPassword">Пароль: (не более 16 символов, но более 5)</label>
          <input type="password" class="form-control" id="inputRegPassword" placeholder="Введите пароль">
        </div>
        <button id="submit-reg" class="btn btn-default">Зарегистрироваться</button>
    </div>
    <div id="popUpLogin" class="popUp">
        <span id="close">X</span>
        <h4>Авторизация:</h4>
        <div class="form-group">
          <label for="inputLogin">Введите ваш логин:</label>
          <input type="text" class="form-control" id="inputLogin" placeholder="Введите логин">
        </div>
        <div class="form-group">
          <label for="inputPassword">Введите ваш пароль:</label>
          <input type="password" class="form-control" id="inputPassword" placeholder="Введите пароль">
        </div>
        <button id="submit-login" class="btn btn-default">Войти</button>
    </div>
    <div id="overlay"></div>

    <script src="jquery-3.2.1.js"></script>
    <script src="jquery.session.js"></script>
    <script src="registration.js"></script>
    <script src="login.js"></script>
    <script>
        //alert($.session.get('pass'));
        //if ($.session.get('pass') != undefined){
        //    $("#inputPassword").val($.session.get('pass'));
        //}
        $.session.clear();
        $(document).ready(function() { 
            $('#reg').click( function(event){ 
                event.preventDefault(); 
                $('#overlay').fadeIn(250, 
                    function(){
                        $('#popUpReg') 
                            .css('display', 'block') 
                            .animate({opacity: 1, top: '35%'}, 490); 
                });
            });
            $('#close, #overlay').click( function(){ 
                $('#popUpReg')
                    .animate({opacity: 0, top: '35%'}, 490, 
                        function(){ 
                            $(this).css('display', 'none'); 
                            $('#overlay').fadeOut(220); 
                        }
                    );
            });
            $('#login').click( function(event){ 
                event.preventDefault(); 
                $('#overlay').fadeIn(250, 
                    function(){
                        $('#popUpLogin') 
                            .css('display', 'block') 
                            .animate({opacity: 1, top: '35%'}, 490); 
                });
            });
            $('#close, #overlay').click( function(){
                $('#popUpLogin')
                    .animate({opacity: 0, top: '35%'}, 490, 
                        function(){ 
                            $(this).css('display', 'none'); 
                            $('#overlay').fadeOut(220); 
                        }
                    );
            });
        });
    </script>
</body>
</html>