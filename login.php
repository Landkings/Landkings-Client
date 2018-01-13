<?php
	if (isset($_POST["login"]) && isset($_POST["password"])){

		$pass = $_POST["password"];
		$login = $_POST["login"];

		$login = stripslashes($login);
    	$login = htmlspecialchars($login);
 		$pass = stripslashes($pass);
    	$pass = htmlspecialchars($pass);

    	$login = trim($login);
    	$pass = trim($pass);

		$db = mysqli_connect("localhost", "progra2r_land", "landkings", "progra2r_land");
		if (!$db){ 
   			echo "Ошибка подключения к базе данных. Код ошибки: ".mysqli_connect_error(); 
  			exit; 
		} 
    	
        $result = mysqli_query($db, "SELECT * FROM users WHERE login='$login'");
        $myrow = mysqli_fetch_assoc($result);
        if (empty($myrow['password'])){
            echo "Извините, введённый вами логин или пароль неверный";
            exit ();
        }
        else {
            if ($myrow['password'] == $pass) {
                session_start();
                $_SESSION['login'] = $myrow['login']; 
                $_SESSION['id'] = $myrow['id'];
                //$_SESSION['pass'] = $myrow['password'];
                echo json_encode($_SESSION);
            }
            else {
                echo "Извините, введённый вами логин или пароль неверный";
                exit ();
            }
        }

    	mysqli_close($db);
	}
	else{
		echo "Не удалось подключиться к модулю с авторизацией";
		exit();
	}

?>