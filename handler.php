<?php

	if (isset($_POST['submit'])){
		$code = $_POST['code'];
		$user = $_POST['user'];
		echo $code.'\n'.$user.'\n';
	}

?>