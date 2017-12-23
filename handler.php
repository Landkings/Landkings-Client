<?php
	if (isset($_POST['submit'])){
		$data = $_POST['code'];
		$nickname = $_POST['user'];
		
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://10.193.31.203:19997");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("nickname: $nickname"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_POST, 1); 
        $result = curl_exec ($ch);
        curl_close ($ch);
        print $result;
	}

?>