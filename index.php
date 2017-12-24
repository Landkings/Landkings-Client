<?php
    if (isset($_POST['submit'])){
        $data = $_POST['code'];
        $nickname = $_POST['user'];
        $secret = '3435';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://5.100.86.249:19997");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("nickname: $nickname", "secret: $secret"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        $result = curl_exec ($ch);
        curl_close ($ch);
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
                        <a class="navbar-brand" href="#">LandKings</a>
                    </div>
                    <div class="collapse navbar-collapse" id="navbar-main">
                        <ul class="nav navbar-nav pull-right">
                            <li class="active"><a href="#">Главная</a></li>
                            <li><a href="#">Регистрация</a></li>
                            <li><a href="#">Вход</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1 col-sm-4 col-sm-offset-1 col-xs-12">
                <form class="form-group code-form" method="post" action="index.php">
                    <label for="codeArea">Поле для ввода кода:</label>
                    <textarea id="codeArea" class="form-control" name="code"></textarea>
                    <label for="nickname">Имя персонажа:</label>
                    <input id="nickname" class="form-control" type="text" name="user">
                    <button id="sendButton" class="btn btn-default" name="submit">Send code</button>
                </form>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                <div class="all-canvases">
                    <canvas id="playersCanvas" width="600" height="600" style="position: absolute; top: 35; z-index: 2;"></canvas>
                    <canvas id="myCanvas" width="600" height="600" style="background: lightblue; position: absolute; top: 35; z-index: 0;"></canvas>
                    <canvas id="obstaclesCanvas" width="600" height="600" style="position: absolute; top: 35; z-index: 1;"></canvas>
                </div>
                <div class="row">
                    <div class="col-lg-5 col-md-6 col-sm-8 col-xs-12" style="margin-top: 650px;">
                        <p class="text-danger pull-left health-bar">Здоровье: </p>
                        <div class="progress">
                            <div id="health" class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">  
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-5 col-md-6 col-sm-8 col-xs-12">
                        <p class="text-success pull-left stamina-bar">Выносливость: </p>
                        <div class="progress">
                            <div id="stamina" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"> 
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="jquery-3.2.1.js"></script>
    <script type="text/javascript">
        var editor = CodeMirror.fromTextArea(codeArea, {
            lineNumbers: true,
            mode: 'lua',
            tabSize: 2,
        });
    </script>
    <script>
        /*$("#sendButton").click(function(){

            var xhr = new XMLHttpRequest();

            xhr.open('POST', 'http://5.100.86.249:19997', true);
            
            var nick = $("#nickname").val();   
            var code = editor.getValue();

            xhr.setRequestHeader('nickname', String(nick));
            xhr.setRequestHeader('secret', '3445');
            xhr.send(String(code));

            xhr.onreadystatechange = function() {
                if (xhr.readyState != 4) return;

                $("#sendButton").text('Done!');

                if (xhr.status != 200) {
                    alert(xhr.status + ': ' + xhr.statusText);
                } else {
                    alert(xhr.responseText);
                }

            }

            $("#sendButton").text('Sending...');
            $("#sendButton").prop('disabled', true);
            $("#nickname").prop('disabled', true);
        });*/
    </script>
    <script src="socket.js"></script>
    <!--<script src="form.js"></script>-->
    <script src="canvas.js"></script>
</body>
</html>