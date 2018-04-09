<?php
    session_start();
    if (!isset($_SESSION['login'])){
        header("Location: index.php");
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
                        <a class="navbar-brand" href="index.php">LandKings</a>
                    </div>
                    <div class="collapse navbar-collapse" id="navbar-main">
                        <ul class="nav navbar-nav pull-right">
                            <li><a href="/todo">ТАСКИ</a></li>
                            <li><a href="clear.php" id="logout"></a></li>
                            <li class="active"><a href="game.php">Меню игры</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1 col-sm-4 col-sm-offset-1 col-xs-12">
                <div class="form-group code-form">
                    <label for="codeArea">Поле для ввода кода:</label>
                    <textarea id="codeArea" class="form-control" name="code"></textarea>
                    <!--<label for="nickname">Имя персонажа:</label>-->
                    <input id="nickname" class="form-control" type="text" name="user">
                    <button id="sendButton" class="btn btn-default" name="submit">Send code</button>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                <div class="all-canvases">
                    <canvas id="npcsCanvas" width="600" height="600" style="position: absolute; top: 35; z-index: 3;"></canvas>
                    <canvas id="playersCanvas" width="600" height="600" style="position: absolute; top: 35; z-index: 2;"></canvas>
                    <canvas id="myCanvas" width="600" height="600" style="background: lightblue; position: absolute; top: 35; z-index: 0;"></canvas>
                    <canvas id="obstaclesCanvas" width="600" height="600" style="position: absolute; top: 35; z-index: 1;"></canvas>
                    <script> 
                            var arrow_keys_handler = function(e) {
                                switch(e.keyCode){
                                    case 37: case 39: case 38:  case 40: // Arrow keys
                                    case 32: e.preventDefault(); break; // Space
                                    default: break; // do not block other keys
                                }
                            };
                            window.addEventListener("keydown", arrow_keys_handler, false);
                    </script>>
                </div>
                <div class="row">
                    <div class="col-lg-5 col-md-6 col-sm-8 col-xs-12" style="margin-top: 645px;">
                        <p class="text-muted pull-left nick-bar" style="float: left;">Ваше имя:</p> 
                        <p><strong><font id="info-nick" class="text-primary"></font></strong></p>
                        <p class="text-muted pull-left nick-bar" style="float: left;">Уровень: </p>  
                        <p><strong><font id="info-level" class="text-primary"></font></strong></p>

                    </div>
                </div>
                <!--<div class="row">
                    <div class="col-lg-5 col-md-6 col-sm-8 col-xs-12" style="margin-top: 5px;">
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
                </div>-->
            </div>
        </div>
    </div>
    <br>
    <div class="container-fluid info_bar">
        <div class="row">
            <div class="col-lg-7 col-md-7">
                <div class="row">
                    <div class="col-lg-12 col-md-12 players-list">
                        <h4 align="center"><strong>Персонажи на сервере: <font id="cnt_of_players" color="#0047ab"></font></strong></h4><hr>
                        <div id="list_players" class="row">
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-12 col-md-12 players-list">
                        <div class="row">
                            <h4 align="center"><strong>Шаблоны:</strong></h4>
                            <div class="col-lg-6 col-md-6">
                                <h4 align="center">Персонаж ходит по квадрату</h4>
                                <pre class="lua" style="font-family:monospace;"><ol><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/   1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">a <span style="color: #66cc66;">=</span> <span style="color:   #cc66cc;">0</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace;    margin:0; padding:0; background:none; vertical-align:top;">border <span style="color: #66cc66;">=</span> <span style="color: #cc66cc;">    100</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0;    padding:0; background:none; vertical-align:top;"><span style="color: #aa9900; font-weight: bold;">function</span> move<span style="color: #66cc66;">&#40;</span>scene<span style="color: #66cc66;">&#41;</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">    setAction<span style="color: #66cc66;">&#40;</span>Action<span style="color: #66cc66;">.</span>Move<span style="color: #66cc66;">&#41;</span></div></li><li style="font-weight: bold; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">    <span style="color: #aa9900; font-weight: bold;">if</span> a <span style="color: #66cc66;">&lt;</span> border <span style="color: #aa9900; font-weight: bold;">then</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">        setDirection<span style="color: #66cc66;">&#40;</span>Direction<span style="color: #66cc66;">.</span>Right<span style="color: #66cc66;">&#41;</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">    <span style="color: #aa9900; font-weight: bold;">elseif</span> a <span style="color: #66cc66;">&lt;</span> border <span style="color: #66cc66;">*</span> <span style="color: #cc66cc;">2</span> <span style="color: #aa9900; font-weight: bold;">then</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">        setDirection<span style="color: #66cc66;">&#40;</span>Direction<span style="color: #66cc66;">.</span>Down<span style="color: #66cc66;">&#41;</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">    <span style="color: #aa9900; font-weight: bold;">elseif</span> a <span style="color: #66cc66;">&lt;</span> border <span style="color: #66cc66;">*</span> <span style="color: #cc66cc;">3</span> <span style="color: #aa9900; font-weight: bold;">then</span></div></li><li style="font-weight: bold; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">        setDirection<span style="color: #66cc66;">&#40;</span>Direction<span style="color: #66cc66;">.</span>Left<span style="color: #66cc66;">&#41;</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">    <span style="color: #aa9900; font-weight: bold;">elseif</span> a <span style="color: #66cc66;">&lt;</span> border <span style="color: #66cc66;">*</span> <span style="color: #cc66cc;">4</span> <span style="color: #aa9900; font-weight: bold;">then</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">        setDirection<span style="color: #66cc66;">&#40;</span>Direction<span style="color: #66cc66;">.</span>Up<span style="color: #66cc66;">&#41;</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">    <span style="color: #aa9900; font-weight: bold;">end</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">    a <span style="color: #66cc66;">=</span> <span style="color: #66cc66;">&#40;</span>a <span style="color: #66cc66;">+</span> <span style="color: #cc66cc;">1</span><span style="color: #66cc66;">&#41;</span> <span style="color: #66cc66;">%</span> <span style="color: #66cc66;">&#40;</span><span style="color: #cc66cc;">4</span> <span style="color: #66cc66;">*</span> border<span style="color: #66cc66;">&#41;</span></div></li><li style="font-weight: bold; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;"><span style="color: #aa9900; font-weight: bold;">end</span></div></li></ol></pre>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <h4 align="center">Персонаж ходит по змейке?!</h4>
                                <pre class="lua" style="font-family:monospace;"><ol><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">a <span style="color: #66cc66;">=</span> <span style="color: #cc66cc;">0</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">border <span style="color: #66cc66;">=</span> <span style="color: #cc66cc;">100</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;"><span style="color: #aa9900; font-weight: bold;">function</span> move<span style="color: #66cc66;">&#40;</span>scene<span style="color: #66cc66;">&#41;</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">    setAction<span style="color: #66cc66;">&#40;</span>Action<span style="color: #66cc66;">.</span>Move<span style="color: #66cc66;">&#41;</span></div></li><li style="font-weight: bold; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">    <span style="color: #aa9900; font-weight: bold;">if</span> a <span style="color: #66cc66;">&lt;</span> border <span style="color: #aa9900; font-weight: bold;">then</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">        setDirection<span style="color: #66cc66;">&#40;</span>Direction<span style="color: #66cc66;">.</span>Up<span style="color: #66cc66;">&#41;</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">    <span style="color: #aa9900; font-weight: bold;">elseif</span> a <span style="color: #66cc66;">&lt;</span> <span style="color: #cc66cc;">2</span> <span style="color: #66cc66;">*</span> border <span style="color: #aa9900; font-weight: bold;">then</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">        setDirection<span style="color: #66cc66;">&#40;</span>Direction<span style="color: #66cc66;">.</span>Right<span style="color: #66cc66;">&#41;</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">    <span style="color: #aa9900; font-weight: bold;">elseif</span> a <span style="color: #66cc66;">&lt;</span> <span style="color: #cc66cc;">3</span> <span style="color: #66cc66;">*</span> border <span style="color: #aa9900; font-weight: bold;">then</span></div></li><li style="font-weight: bold; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">        setDirection<span style="color: #66cc66;">&#40;</span>Direction<span style="color: #66cc66;">.</span>Left<span style="color: #66cc66;">&#41;</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">    <span style="color: #aa9900; font-weight: bold;">elseif</span> a <span style="color: #66cc66;">&lt;</span> <span style="color: #cc66cc;">5</span> <span style="color: #66cc66;">*</span> border <span style="color: #aa9900; font-weight: bold;">then</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">        setDirection<span style="color: #66cc66;">&#40;</span>Direction<span style="color: #66cc66;">.</span>Down<span style="color: #66cc66;">&#41;</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">    <span style="color: #aa9900; font-weight: bold;">elseif</span> a <span style="color: #66cc66;">&lt;</span> <span style="color: #cc66cc;">6</span> <span style="color: #66cc66;">*</span> border <span style="color: #aa9900; font-weight: bold;">then</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">        setDirection<span style="color: #66cc66;">&#40;</span>Direction<span style="color: #66cc66;">.</span>Left<span style="color: #66cc66;">&#41;</span></div></li><li style="font-weight: bold; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">    <span style="color: #aa9900; font-weight: bold;">elseif</span> a <span style="color: #66cc66;">&lt;</span> <span style="color: #cc66cc;">7</span> <span style="color: #66cc66;">*</span> border <span style="color: #aa9900; font-weight: bold;">then</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">        setDirection<span style="color: #66cc66;">&#40;</span>Direction<span style="color: #66cc66;">.</span>Right<span style="color: #66cc66;">&#41;</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">    <span style="color: #aa9900; font-weight: bold;">elseif</span> a <span style="color: #66cc66;">&lt;</span> <span style="color: #cc66cc;">8</span> <span style="color: #66cc66;">*</span> border <span style="color: #aa9900; font-weight: bold;">then</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">        setDirection<span style="color: #66cc66;">&#40;</span>Direction<span style="color: #66cc66;">.</span>Up<span style="color: #66cc66;">&#41;</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">    <span style="color: #aa9900; font-weight: bold;">end</span></div></li><li style="font-weight: bold; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">    a <span style="color: #66cc66;">=</span> <span style="color: #66cc66;">&#40;</span>a <span style="color: #66cc66;">+</span> <span style="color: #cc66cc;">1</span><span style="color: #66cc66;">&#41;</span> <span style="color: #66cc66;">%</span> <span style="color: #66cc66;">&#40;</span><span style="color: #cc66cc;">8</span> <span style="color: #66cc66;">*</span> border<span style="color: #66cc66;">&#41;</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;"><span style="color: #aa9900; font-weight: bold;">end</span></div></li></ol></pre></div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <h4 align="center">Персонаж ищет и убивает всё подряд</h4>
                                <pre class="lua" style="font-family:monospace;"><ol><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">a <span style="color: #66cc66;">=</span> <span style="color: #cc66cc;">0</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;"><span style="color: #aa9900; font-weight: bold;">function</span> move<span style="color: #66cc66;">&#40;</span>scene<span style="color: #66cc66;">&#41;</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">    setAction<span style="color: #66cc66;">&#40;</span>Action<span style="color: #66cc66;">.</span>Move<span style="color: #66cc66;">&#41;</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">    <span style="color: #aa9900; font-weight: bold;">if</span> <span style="color: #66cc66;">#</span><span style="color: #66cc66;">&#40;</span>scene<span style="color: #66cc66;">:</span>getObjects<span style="color: #66cc66;">&#40;</span><span style="color: #66cc66;">&#41;</span><span style="color: #66cc66;">&#41;</span> <span style="color: #66cc66;">&gt;</span> <span style="color: #cc66cc;">0</span> <span style="color: #aa9900; font-weight: bold;">and</span> getStamina<span style="color: #66cc66;">&#40;</span><span style="color: #66cc66;">&#41;</span> <span style="color: #66cc66;">&gt;</span> <span style="color: #cc66cc;">20</span>  <span style="color: #aa9900; font-weight: bold;">then</span></div></li><li style="font-weight: bold; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">        setAction<span style="color: #66cc66;">&#40;</span>Action<span style="color: #66cc66;">.</span>Attack<span style="color: #66cc66;">&#41;</span>    </div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">        setAttackDirection<span style="color: #66cc66;">&#40;</span>AttackDirection<span style="color: #66cc66;">.</span>Torso<span style="color: #66cc66;">&#41;</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">        setTarget<span style="color: #66cc66;">&#40;</span>scene<span style="color: #66cc66;">:</span>getObjects<span style="color: #66cc66;">&#40;</span><span style="color: #66cc66;">&#41;</span><span style="color: #66cc66;">&#91;</span><span style="color: #cc66cc;">1</span><span style="color: #66cc66;">&#93;</span><span style="color: #66cc66;">&#41;</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">    <span style="color: #aa9900; font-weight: bold;">else</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">        setAction<span style="color: #66cc66;">&#40;</span>Action<span style="color: #66cc66;">.</span>Empty<span style="color: #66cc66;">&#41;</span></div></li><li style="font-weight: bold; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;">    <span style="color: #aa9900; font-weight: bold;">end</span></div></li><li style="font-weight: normal; vertical-align:top;"><div style="font: normal normal 1em/1.2em monospace; margin:0; padding:0; background:none; vertical-align:top;"><span style="color: #aa9900; font-weight: bold;">end</span></div></li></ol></pre>
                            </div>
                        </div>     
                    </div>
                </div>
                <div class="col-lg-5 col-md-5" style="box-sizing: border-box; padding-left: 25px; padding-right: 20px;">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 players-list">
                            <h4 align="center"><strong>Мини-Документация:</strong></h4><hr>
                            <pre>
----------------------------------------
Enums:

Action:
    Move
    Attack
    Block
    Empty
    
Direction:
    Up
    Right
    Down
    Left
    Unknown

AttackType:
    Fast
    Strong

AttackDirection:
    Head
    Torso
    Legs

MovementType:
    Default
    Sprint

Parameters:
    MovementSpeed
    AttackSpeed
    AttackRange
    HitPoints
    StamingPoints
    AttackDamage
    VisionRange
    StaminaCostReduction
    StaminaRegenFrequency

ObjectType:
    Player
    HealingItem
    ExpItem
    NPC


-----------------------------------------


Global functions:
    setAction(Action)              
    getAction()            
    setDirection(Direction)
    getDirection()
    setTarget(Target)             
    getTarget()              
    getPosition()            
    getStamina()             
    getHp()                  
    setAttackType(AttackType)
    setMovementType(MovementType)        
    getMovementType()        
    setAttackDirection(AttackDirection)     
    setBlockDirection(AttackDirection)      
    getMe()                  
    getAttackStaminaCost()   
    getMoveStaminaCost()     
    getBlockStaminaCost()    
    getSprintStaminaCost()   
    levelUp(Parameter)                
    getCurrentExp()          
    getNextLevelExp()        
    getAvailableSkillPoints()
    getParameterLevelUpCost(Parameter)
    canMove(Direction)  
    canAttack(Target)

Scene methods:
    getObjects()
    getSafeZone()

Character methods:
    getPosition()
    getObjectType()

Item methods:
    getObjectType()
    getPosition()

SafeZone methods:
    getPosition()
    getRadius()

Vec2i methods:
    getX()
    getY()


                            </pre>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <?php
        $sessid = $_SESSION["token"];
        echo("<script>var sessid = '$sessid';</script>");
    ?>
    <script src="jquery-3.2.1.js"></script>
    <script src="jquery.session.js"></script>
    <script src="canvas.js"></script>
    <script src="sync.js"></script>
    <script type="text/javascript">
        $("#nickname").prop('disabled', true);
        $("#nickname").hide();
        var editor = CodeMirror.fromTextArea(codeArea, {
            lineNumbers: true,
            mode: 'lua',
            tabSize: 2,
        });
    </script>
    <script type="text/javascript">
        setInterval(createListPlayers, 1000);
        function createPlayerLink(word){
          $("#nickname").empty();
          $("#nickname").val(word);
        }
        $("#sendButton").click(function(){
            var nick = $.session.get('login');
            var code = editor.getValue();
            $("#sendButton").text('Sending...');
            $("#sendButton").prop('disabled', true);
            $("#nickname").prop('disabled', true);
            $.post("http://localhost/Landkings-Client/handler.php", 
                {
                    nick: nick, 
                    code: code
                }, 
                function(data){
                    $("#sendButton").text('Done!');
                    function unblock(){
                        $("#sendButton").text('Send code');
                        $("#sendButton").prop('disabled', false);
                    }
                    setTimeout(unblock, 2500);
                }
            );
        });
    </script>
    <!--<script src="socket.js"></script>-->
    <!--<script src="form.js"></script>-->
</body>
</html>
