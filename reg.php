<?php
	if (isset($_POST["login"]) && isset($_POST["password"])){

		$pass = $_POST["password"];
		$login = $_POST["login"];

		if (preg_match("/[а-я]/i", $login)){
			echo "В нашей игре предлагается воздержаться от использований никнеймов, содержащих русские символы.\n Приносим свои извинения за предоставленные неудобства(";
			exit();
		}

		$login = stripslashes($login);
    	$login = htmlspecialchars($login);
 		$pass = stripslashes($pass);
    	$pass = htmlspecialchars($pass);

    	if (strlen($login) == strlen(trim($login)) && strlen($pass) == strlen(trim($pass))){
    		$login = trim($login);
    		$pass = trim($pass);
    	}
    	else{
    		echo "Логин и пароль не должны содержать пробелов вначале строки";
    		exit();
    	}

    	$err = 0;
    	if (strlen($login) < 3 || strlen($login) > 15){
    		echo "Логин не соотвествует длине\n";
    		$err += 1;
    	}
    	if (strlen($pass) > 16 || strlen($pass) < 6){
    		echo "Пароль не соотвествует длине\n";
    		$err += 1;
    	}
    	if ($err > 0){
    		exit();
    	}

		$db = mysqli_connect("localhost", "root", "", "landkings");
		if (!$db) { 
   			echo "Ошибка подключения к базе данных. Код ошибки: ".mysqli_connect_error(); 
  			exit; 
		} 
    	$result = mysqli_query($db, "SELECT id FROM users WHERE login = '$login'");
    	$myrow = mysqli_fetch_assoc($result);
    	if (!empty($myrow['id'])) {
    		echo "Извините, введённый вами логин уже зарегистрирован. Введите другой логин.";
    		exit();
    	}
    	$result = mysqli_query($db, "INSERT INTO users (login, password) VALUES('$login', '$pass')");
    	if ($result)
    	{
    		echo "Ты принят, боец! А теперь немедленно войди в игру!\n";
    		echo "Твой ник: '".$login."'\n";
    		echo "Твой пароль: '".$pass."'\n";
    	}
 		else {
    		echo "Напортачил я где-то, парень. Попоробуй-ка снова - по-братски";
    	}
    	mysqli_close($db);
	}
	else{
		echo "Не удалось подключиться к модулю с регистрацией";
		exit();
	}

?>