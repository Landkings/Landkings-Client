<?php
        $data = $_POST['code'];
        $nickname = $_POST['nick'];
        $secret = '3435';

        $data = $secret."p".$nickname.">".$data;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://5.100.95.19:19997");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect: '));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_POST, 1);
        $result = curl_exec ($ch);
        curl_close ($ch);
?>