window.addEventListener('load', eventWindowLoaded, false);

var tileSet = new Image();
tileSet.onload = function () {
    console.log(tileSet.src);
};
tileSet.src = "data/tileSet";

var knightSet = new Image();
knightSet.onload = function () {
    console.log(knightSet.src);
};
knightSet.src = "data/knight_asset.png";

var knight_up    = [ { x: 81, y: 0} ];
var knight_down  = [ { x: 0,  y: 0} ];
var knight_left  = [ { x: 27, y: 0} ];
var knight_right = [ { x: 54, y: 0} ];

var grass = [ { x: 0, y : 384}, {x : 48, y : 384} ];
var tree = [ { x: 192, y : 432} ];

var red_mushroom = [ { x: 576, y: 336} ];
var mushroom = [ { x: 624, y: 336} ];

var camera = { x : 0, y : 0 };

var all_players = [];

var prev_x, prev_y;

function changeStatements(players){
  var flag = false;
  for (var i = 0; i < players.length; ++i){
    if ($("#nickname").val() == players[i].id){
      prev_y = players[i].y;
      prev_x = players[i].x;
      flag = true;
      $("#health").css("width", String(players[i].hp) + "%");
      $("#stamina").css("width", String(players[i].stamina) + "%");
      var max_health = players[i].maxHp;
      var cur_health = players[i].hp;
      var max_stamina = players[i].maxStamina;
      var cur_stamina = players[i].stamina;
      $("#health").text(String(cur_health) + "/" + String(max_health));
      $("#stamina").text(String(cur_stamina) + "/" + String(max_stamina));
    }
  }
  return flag;
}

$("#nickname").keyup(function() {
  var flag = changeStatements(all_players);
  if (!flag){
      $("#health").empty();
      $("#stamina").empty();
      $("#health").css("width", "0%");
      $("#stamina").css("width", "0%");      
  }
});

function eventWindowLoaded () {
  canvasApp();
}

function canvasSupport (e) {
  return !!e.getContext;
}

var width = 4800;
var height = 4800;

var tileMap;
//var tileMap = new Array(Math.floor(height / 48));
//for (var i = 0; i * 48 < height; i++) {
//  tileMap[i] = new Array(Math.floor(width / 48));
//  for (var j = 0; j * 48 < width; j++) {
//    tileMap[i][j] = Math.floor(Math.random() * 2);
//  }
//}



function createListPlayers(){
  $("#list_players").empty();
  for (var i = 0; i < all_players.length; i++){
    if ($("#nickname").val() == all_players[i].id){
      $("#list_players").append("<div class='col-lg-4 col-md-4'><p class='text-muted' style='color: #f00;'>" + all_players[i].id + "</p></div>");
    }
    else
      $("#list_players").append('<div class="col-lg-4 col-md-4" onClick="createPlayerLink(\'' + all_players[i].id + '\');"><p class="text-muted">' + all_players[i].id + "</p></div>");
  }
}

function canvasApp () {
  var myCanvas = document.getElementById('myCanvas');
  var playersCanvas = document.getElementById('playersCanvas');
  var obstaclesCanvas = document.getElementById('obstaclesCanvas');
  if (!canvasSupport(myCanvas)) {
      return;
  }
  var ctx = myCanvas.getContext('2d');
  var plctx = playersCanvas.getContext('2d');
  var obsctx = obstaclesCanvas.getContext('2d');
  //ctx.save();
  myCanvas.width = 600;
  myCanvas.height = 600;
  obstaclesCanvas.width = 600;
  obstaclesCanvas.height = 600;
  playersCanvas.width = 600;
  playersCanvas.height = 600;
  //ctx.transform( 1, 0.5, -1, 0.5, 160, 0 );
  //obsctx.translate(-500, -600);
  //ctx.translate(-500, -600);
  //plctx.transform( 1, 0.5, -1, 0.5, 160, 0 );



  function drawScreen() {
    var players_x = 0;
    var players_y = 0;
    for (var i = 0; i < all_players.length; i++){
      if (all_players[i].id == $("#nickname").val()){
        camera.x = all_players[i].x - 290;
        camera.y = all_players[i].y - 290;
      }
    }
    ctx.beginPath();  
    ctx.clearRect(0, 0, myCanvas.width, myCanvas.height);
    var dx = 48;
    var dy = 48;
    var y = (-camera.y % dy);
    var w = myCanvas.width;
    var h = myCanvas.height;
    ctx.lineWidth = 1;
    while (y < h) {
      var x = -(camera.x % dx);
      while (x < w) {
        if ((x + camera.x) >= 0 && (y + camera.y) >= 0 && (x + camera.x) <= width && (y + camera.y) <= height) {
          var tile = grass[tileMap[Math.floor((x + camera.x) / dx)][Math.floor((y + camera.y) / dy)]];
          ctx.drawImage(tileSet, tile.x, tile.y, dx, dy, x, y, dx, dy);
        }
        x = x + dx;
      }
      y = y + dy;
    }
  }

document.addEventListener('keydown', function(event) {
    if(event.keyCode == 37) {
      console.log("kek");
      camera.x -= 48;
    }
    else if(event.keyCode == 39) {
      camera.x += 48;
    }
    else if (event.keyCode == 38) {
      camera.y -= 48;
    }
    else if (event.keyCode == 40) {
      camera.y += 48;
    }
    drawScreen();
});

/*
obsctx.beginPath();
obsctx.clearRect(0, 0, obstaclesCanvas.width, obstaclesCanvas.height);
obsctx.drawImage(tileSet, tree[0].x, tree[0].y, 48, 48, 256 - camera.x, 256 - camera.y, 48, 48);
*/

  function drawPlayers(players) {
        plctx.beginPath();
        plctx.clearRect(0, 0, playersCanvas.width, playersCanvas.height);
        plctx.closePath();
        for (var i = 0; i < players.length; ++i){
            plctx.beginPath();
            //plctx.fillStyle = "#fff";
            //plctx.fillStroke = "#000";
            //plctx.fillRect(players[i].x - 10 - camera.x, players[i].y - 10 - camera.y, 20, 20);
            if ($("#nickname").val() == players[i].id){
              var dx = prev_x - players[i].x;
              var dy = prev_y - players[i].y;
              prev_x = players[i].x;
              prev_y = players[i].y;
              if (dx < 0)
                dx = knight_right[0].x;
              else if (dx > 0)
                dx = knight_left[0].x;
              else if (dy > 0)
                dx = knight_up[0].x;
              else
                dx = knight_down[0].x;
              dy = 0;
              plctx.drawImage(knightSet, dx, dy, 27, 32, players[i].x - 10 - camera.x, players[i].y - 10 - camera.y, 27, 32);
            }
            else{
              plctx.drawImage(tileSet, mushroom[0].x, mushroom[0].y, 48, 48, players[i].x - 10 - camera.x, players[i].y - 10 - camera.y, 48, 48);
            }
            plctx.closePath();
            plctx.beginPath();
            if ($("#nickname").val() == players[i].id){
              plctx.fillStyle = "#000";
              plctx.fillStroke = "#000";
              plctx.font = "bold 18px Arial";
              plctx.fillText(players[i].id, players[i].x - 12 - camera.x - 5, players[i].y - 5 - camera.y - 5);
              plctx.fillText(players[i].id, players[i].x - 8 - camera.x - 5, players[i].y - 5 - camera.y - 5);
              plctx.fillText(players[i].id, players[i].x - 10 - camera.x - 5, players[i].y - 5 - camera.y - 3);
              plctx.fillText(players[i].id, players[i].x - 10 - camera.x - 5, players[i].y - 5 - camera.y - 7);
              plctx.fillStyle = "#f00";
            }
            else{
              plctx.fillStyle = "#fff";
              plctx.fillStroke = "#000";
              plctx.font = "14px Arial";
            }
            plctx.fillText(players[i].id, players[i].x - 10 - camera.x - 5, players[i].y - 10 - camera.y);
            plctx.closePath();
        }
  }

  function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
  }
  socket.onmessage = function(event) {
        var obj = JSON.parse(event.data);
        console.log(obj.messageType);
        if (obj.messageType == "loadObjects") {
            all_players = obj.players;
            drawScreen();
            drawPlayers(obj.players);
            changeStatements(obj.players);
        }
        else if (obj.messageType == "loadMap") {
          var arr = obj.tileMap;
          var ht = obj.height;
          var wh = width = obj.width;
          width = wh * 48;
          height = ht * 48;
          tileMap = new Array(Math.floor(height / 48));
          for (var i = 0; i < ht; i++) {
            tileMap[i] = new Array(Math.floor(width / 48));
            for (var j = 0; j < wh; j++) {
              tileMap[i][j] = arr[i * wh + j];
            }
          }
          drawScreen();
        }
  };
  //drawScreen();  
}