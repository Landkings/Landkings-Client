$(document).ready(function(){
	$.ajax({
        url: 'http://progra2r.bget.ru/session.php',
        method: 'POST',
        async: false,
        success: function(data){
            var obj = JSON.parse(data);
            $.session.set("login", obj["login"]);
            $.session.set("id", obj["id"]);
        	var _nick_ = $.session.get("login");
        	$("#logout").append("Выйти из " + _nick_); 
        	$("#nickname").val(_nick_);
            $("#info-nick").empty();
            $("#info-nick").append(_nick_);
        }
    });
});