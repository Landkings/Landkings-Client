window.addEventListener('load', eventWindowLoaded, false);

var tileSet = new Image();
tileSet.onload = function () {
    console.log(tileSet.src);
};

tileSet.src = "data/tileSet";
var grasses = [ { x: 0, y : 384}, {x : 48, y : 384} ];
var tree = [ { x: 192, y : 432} ];

var camera = { x : 0, y : 0 };

function eventWindowLoaded () {
  canvasApp();
}

function canvasSupport (e) {
      return !!e.getContext;
}

var tileMap = new Array();
for (i = 0; i < width; i+=48) {
  tileMap[i] = new Array();
  for (j = 0; j < height; j+=48) {
    tileMap[i][j] = Math.floor((Math.random() * 2));
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
  myCanvas.width = 400;//window.innerWidth;
  myCanvas.height = 400;//window.innerHeight;
  obstaclesCanvas.width = 400;//window.innerWidth;
  obstaclesCanvas.height = 400;//window.innerHeight;
  playersCanvas.width = 400;
  playersCanvas.height = 400;
  //ctx.transform( 1, 0.5, -1, 0.5, 160, 0 );
  //obsctx.translate(-500, -600);
  //ctx.translate(-500, -600);
  //plctx.transform( 1, 0.5, -1, 0.5, 160, 0 );


  function drawScreen () {
    //ctx.restore();
    ctx.beginPath();  
    ctx.clearRect(0, 0, myCanvas.width, myCanvas.height);
    //ctx.save();
    var dx = 48;
    var dy = 48;
    var y = -48;
    var w = myCanvas.width;
    var h = myCanvas.height;
    //var   xy = 10;
    ctx.lineWidth = 1;
    while (y < h) {
      var x = camera.x;
      while (x < w) {
        if (x - camera.x >= -48 && y - camera.y >= -48) {
          //var tile = grasses[tileMap[Math.floor((x - camera.x) / 48)][Math.floor((y - camera.y) / 48)]];
          var tile = grasses[0];
          ctx.drawImage(tileSet, tile.x, tile.y, 48, 48, x - camera.x, y - camera.y, 48, 48);
        }

        //ctx.moveTo(x, y);
        //ctx.lineTo(w, y);
        //ctx.stroke();
        //xy += 10;
        x = x + dx;
      }
      y = y + dy;
    }

    //y = 0;
    //xy = 10;
    //while (x < w) {
    //  x = x + dx;
    //  ctx.moveTo(x, y);
    //  ctx.lineTo(x, h);
    //  ctx.stroke();
    //  xy += 10;
    //}
    obsctx.beginPath();
    obsctx.clearRect(0, 0, obstaclesCanvas.width, obstaclesCanvas.height);
    obsctx.drawImage(tileSet, tree[0].x, tree[0].y, 48, 48, 256 - camera.x, 256 - camera.y, 48, 48);
  }

document.addEventListener('keydown', function(event) {
    if(event.keyCode == 37) {
      camera.x += 10;
        //console.log('Left was pressed');
    }
    else if(event.keyCode == 39) {
      camera.x -= 10;
        //console.log('Right was pressed');
    }
    else if (event.keyCode == 38) {
      camera.y += 10;
    }
    else if (event.keyCode == 40) {
      camera.y -= 10;
    }
    drawScreen();
});

  function drawPlayers(players) {
        plctx.beginPath();
        plctx.clearRect(0, 0, playersCanvas.width, playersCanvas.height);
        for (var i = 0; i < players.length; ++i) {
            plctx.fillRect(players[i].x - 10 - camera.x, players[i].y - 10 - camera.y, 20, 20);
            //plctx.stroke();
        }
  }

  function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
  }

  //plctx.rect(players[i].x - 10, players[i].y - 10, 20, 20);
  //plctx.stroke();

  socket.onmessage = function(event) {
        //drawScreen();
        //ctx.restore();      
        var obj = JSON.parse(event.data);
        drawPlayers(obj.players);
  };

  async function demo() {
    while (true) {
        if (socket.readyState == 1) {
            socket.send(JSON.stringify({"messageType" : "getCharacters"}));
        }
        //console.log("Trying to sleep");
        await sleep(32);
    }
  }
  drawScreen();
  //demo();
  
}