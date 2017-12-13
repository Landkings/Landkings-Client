sendButton = document.getElementById("sendButton");

sendButton.onclick = function()
{
    if (socket.readyState != 1)
        return;
    socket.send(JSON.stringify(
    {
        "messageType" : "sourceCode",
        "sourceCode" : codeArea.value,
        "nickname" : nickArea.value
    }));
};

var firstCodeClick = true;
var firstNickClick = true;

codeArea = document.getElementById("codeArea");

codeArea.onclick = function()
{
    if (firstCodeClick)
    {
        codeArea.value = "";
        firstCodeClick = false;
    }
};

/*
nickArea = document.getElementById("nickArea");

nickArea.onclick = function()
{
    console.log("nick click");
    if (firstNickClick)
    {
        nickArea.value = "";
        firstNickClick = false;
    }
}
*/