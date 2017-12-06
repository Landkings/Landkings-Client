sendButton = document.getElementById("sendButton");
sendButton.onclick = function()
{
    if (socket.readyState != 1)
        return;
    console.log("clicked");
    socket.send(JSON.stringify(
    {
        "messageType" : "sourceCode",
        "sourceCode" : codeArea.value,
        "nickname" : nickArea.value
    }));
};
