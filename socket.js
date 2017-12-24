var socket = new WebSocket("ws://5.100.86.249:19999");

socket.onopen = function() 
{
    alert('Connection established');
};

socket.onclose = function(event) 
{
    if (event.wasClean) 
    {  
        alert('Closed clean');
    } 
    else 
    {
        alert('Closed');
    }
    alert('Code: ' + event.code + ' reason: ' + event.reason);
};