<?php

include("dbCred.php");

// get the q parameter from URL
$q = $_REQUEST["sen_type"];

$ids_Result = array();

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}



if ($q == "New") {
	$sql = "SELECT sentence_id FROM Sentences where sentence_type='auto' and sentence_count=0";
}
if ($q == "Reviewed") {
	$sql = "SELECT sentence_id FROM Sentences where sentence_type='auto' and sentence_count>0";
}
if ($q == "Ref_Example") {
	$sql = "SELECT sentence_id FROM Sentences where sentence_type='sample' ";
//	array_push($ids_Result, 5,6);
}
$sql_result = $conn->query($sql);

// Output "no suggestion" if no hint was found or output correct values
 //$q;
$haveRecords=false;
$result='Please select the a sentence: <select id="sentence_ID" name="sentence_ID">';
	if ($sql_result->num_rows > 0) {
		while($row = $sql_result->fetch_assoc()) {
		$result.='<option value="'.$row["sentence_id"].'">'.$row["sentence_id"].'</option>'; //close your tags!!
		}
		$haveRecords=true;
	}
$result.='</select><br>';
if ($haveRecords) {
	$result.='<input type="submit" value="Show me the sentence to check"><br><br>';
}
else 
{
	$result.='<input type="submit" value="Show me the sentence to check" disabled=$haveRecords>';
}

		
echo $result;
$conn->close();
?>