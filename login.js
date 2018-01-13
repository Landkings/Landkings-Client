$("#submit-login").click(function(){
	var login = $("#inputLogin").val();
	var password = $("#inputPassword").val();
	var vars = {
        login: login,
        password: password,
    }
    $.ajax({
        url: 'http://landkings/login.php',
        method: 'POST',
        async: false,
        data: vars,
        success: function(data){
            try{
                var obj = JSON.parse(data);
                $.session.set("login", obj["login"]);
                $.session.set("id", obj["id"]);
                //$.session.set("pass", obj["pass"]);
                window.location = 'http://landkings/game.php';
            }
            catch (e){
                alert(data);
            }
        }
    });
});