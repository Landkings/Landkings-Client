window.addEventListener('load', eventWindowLoaded, false);

var tileSet = new Image();
tileSet.onload = function () {
    console.log(tileSet.src);
};
tileSet.src = "data/tileSet";

var grass = [ { x: 0, y : 384}, {x : 48, y : 384} ];
var tree = [ { x: 192, y : 432} ];

var camera = { x : 0, y : 0 };

var all_players;

$("#nickname").keyup(function() {
  for (var i = 0; i < all_players.length; ++i){
    if ($("#nickname").val() == all_players[i].id){
      $("#health").css("width", String(all_players[i].hp) + "%");
      $("#stamina").css("width", String(all_players[i].stamina) + "%");
    }
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
    ctx.beginPath();  
    ctx.clearRect(0, 0, myCanvas.width, myCanvas.height);
    var dx = 48;
    var dy = 48;
    var y = 0;
    var w = myCanvas.width;
    var h = myCanvas.height;
    ctx.lineWidth = 1;
    while (y < h) {
      var x = camera.x;
      while (x < w) {
        if ((x - camera.x) >= 0 && (y - camera.y) >= 0 && (x - camera.x) <= width && (y - camera.y) <= height) {
          var tile = grass[tileMap[Math.floor((x - camera.x) / dx)][Math.floor((y - camera.y) / dy)]];
          ctx.drawImage(tileSet, tile.x, tile.y, dx, dy, x - camera.x, y - camera.y, dx, dy);
        }
        x = x + dx;
      }
      y = y + dy;
    }
    obsctx.beginPath();
    obsctx.clearRect(0, 0, obstaclesCanvas.width, obstaclesCanvas.height);
    obsctx.drawImage(tileSet, tree[0].x, tree[0].y, 48, 48, (256 - camera.x), (256 - camera.y), dx, dy);
  }

document.addEventListener('keydown', function(event) {
    if(event.keyCode == 37) {
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

  function drawPlayers(players) {
        plctx.beginPath();
        plctx.clearRect(0, 0, playersCanvas.width, playersCanvas.height);
        plctx.closePath();
        for (var i = 0; i < players.length; ++i) {
            plctx.beginPath();
            plctx.fillRect(players[i].x - 10 - camera.x, players[i].y - 10 - camera.y, 20, 20);
            plctx.fillStyle = "#fff";
            plctx.fillStroke = "#000";
            plctx.font = "14px";
            plctx.fillText(players[i].id, players[i].x - 10 - camera.x - 10, players[i].y - 10 - camera.y - 5);
            plctx.closePath();
            if ($("#nickname").val() == players[i].id){
              $("#health").css("width", String(players[i].hp) + "%");
            }
            //$("#stamina").css("width", String(players[i].hp) + "%");
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
            drawPlayers(obj.players);  
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