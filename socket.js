var socket = new WebSocket("ws://5.100.95.19:19999", [sessid]);

socket.onopen = function() 
{
    //alert('Connection established');
};

var mapReceived = false;
var mapObject;

socket.onmessage = function()
{
    if (obj.messageType == "loadMap") 
    {
        mapObjbect = JSON.parse(event.data);
        console.log(obj.messageType);
        mapReceived = true;
    }
};

socket.onclose = function(event) 
{
    if (event.wasClean) 
    {  
        //alert('Closed clean');
    } 
    else 
    {
        //alert('Closed');
    }
    //alert('Code: ' + event.code + ' reason: ' + event.reason);
};
