$("#submit-reg").click(function(){
	var login = $("#inputRegLogin").val();
	var password = $("#inputRegPassword").val();
    var vars = {
    	login: login,
    	password: password,
    }
    $.ajax({
    	url: 'http://landkings/reg.php',
    	type: 'POST',
    	async: false,
    	data: vars,
    	success: function(data){
        	alert(data);
    	}
	});
});