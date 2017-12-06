window.addEventListener('load', eventWindowLoaded, false);

function eventWindowLoaded () 
{
    canvasApp();
}

function canvasSupport (e) 
{
    return !!e.getContext;
}

function canvasApp () 
{ 
  var myCanvas = document.getElementById('myCanvas');
  if (!canvasSupport(myCanvas)) {
      return;
  }
  var ctx = myCanvas.getContext('2d');
  myCanvas.width = window.innerWidth;
  myCanvas.height = window.innerHeight;

  function drawScreen () 
  {
    //ctx.clearRect(0, 0, 1000, 1000);
    ctx.beginPath();
    ctx.clearRect(0, 0, myCanvas.width, myCanvas.height);
    var dx = 40;
    var dy = 40;
    var x = 0;
    var y = 0;
    var w = myCanvas.width;
    var h = myCanvas.height;
    var xy = 10;
    ctx.lineWidth = 1;
    while (y < h) 
    {
      y = y + dy;
      ctx.moveTo(x, y);
      ctx.lineTo(w, y);
      ctx.stroke();
      xy += 10;
    }

    y = 0;
    xy = 10;
    while (x < w) 
    {
      x = x + dx;
      ctx.moveTo(x, y);
      ctx.lineTo(x, h);
      ctx.stroke();
      xy += 10;
    }
  }

  function drawPlayers(players) 
  {
        for (var i = 0; i < players.length; ++i) 
        {
            ctx.rect(players[i].x * 40 + 10, players[i].y * 40 + 10, 20, 20);
            ctx.stroke();
        }
  }

  drawScreen();
  socket.onmessage = function(event) 
  {
    drawScreen();
    var obj = JSON.parse(event.data);
    drawPlayers(obj.players);
  };

  function sleep(ms) 
  {
    return new Promise(resolve => setTimeout(resolve, ms));
  }

  var jobj = JSON.parse("{ \"players\" : [ {\"x\" : \"0\", \"y\" : \"10\"}, {\"x\" : \"5\", \"y\" : \"0\"} ] }");
  drawPlayers(jobj.players);

  async function demo() 
  {
    while (true) 
    {
      var json = "{\"grid\"}";
      if (socket.readyState == 1)
        socket.send(JSON.stringify({"messageType" : "getCharacters"}));
      sleep(500);
    }
  }
  demo();
}