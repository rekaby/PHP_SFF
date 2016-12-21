
<?php

if(isset($_SESSION["user_name"])){
	//echo '<div align="Right">Welcome '.$_SESSION["user_name"].'</div>' ;
	//include("dbCred.php");
	$conn_user = new mysqli($servername, $username, $password, $dbname);
	//mysqli_set_charset($conn, 'utf8');
	if ($conn_user->connect_error) {
		
	}
	else
	{
		$sql_user = "select count(*) as ac from triples_feedback where user_name='".
		$_SESSION["user_name"]."'";
		
		
		$sql_result_user = $conn_user->query($sql_user);
		while ($row_user = $sql_result_user->fetch_assoc())
		{
			echo 'Welcome '.$_SESSION["user_name"].'.<br>You gave feedback on '.$row_user["ac"].' relations...keep it up' ;
		}
		$conn_user->close();
	}
	
}
?>
