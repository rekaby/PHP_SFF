<?php

$servername = "173.201.88.65";
$username = "ersildb";
$password_enc = "6YBnxFpbTIE+txVmjwRbAw==";
$password = "";
$dbname = "ersildb";


/*
$servername = "localhost";
$username = "rekaby";
$password_enc = "uO3+aKd6t8hPqQHLfn/G8g==";
$dbname = "feedbackDB";
*/


//$encrypted=safeEncrypt($password,"NATSHAMBURGUNI");
//echo $encrypted.'<br>';
safeDecrypt();
//safeDecrypt();
//echo $password.'<br>';

 function safeEncrypt($message, $key)
{
return openssl_encrypt($message,"cast5-cbc", $key);

} 

function safeDecrypt()
{
	$GLOBALS["password"]=openssl_decrypt($GLOBALS["password_enc"], "cast5-cbc", "NATSHAMBURGUNI");
	
}
?>