<?php
	session_start();
	//Очищаем сессию и отправляем серверу запрос на удаление пользователя
    $secret = '3435';
    $data = $secret."e".$_SESSION["login"];


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://5.100.95.19:19997");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_POST, 1);
    $result = curl_exec ($ch);
    curl_close ($ch);

	//Удаляем сессию
    $_SESSION = array();
    session_destroy();
    header("Location: index.php");
    exit();
?>