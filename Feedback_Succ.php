<?php
// Start the session
session_start();
?>
<html>
<HEAD>
<link rel="stylesheet" type="text/css" href="feedback.css">
</HEAD>
</html>
<?php

$statment_ID = $_POST['statment_ID'];
include("dbCred.php");

/*
$servername = "localhost";
$username = "rekaby";
$password = "p@ssw0rd";
$dbname = "feedbackDB";
*/
$db_error="";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
	$db_error.=" Error in connecting to DB";
}
$dat_format="'Y-m-d H:i:s'";
$server_date=date($dat_format,$_SERVER['REQUEST_TIME']);
//echo $server_date;
$sql_select = "SELECT triple_ID,triple_correct,triple_incorrect,triple_no_input
		 FROM triples,Sentences where Sentences.sentence_id=triples.sentence_id
		  and Sentences.sentence_id=".$statment_ID;
$sql_result = $conn->query($sql_select);

$final_message='';
/* echo $sql_select;
if (!$sql_result) {
	throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
} */
//update Triples section
while ($row = $sql_result->fetch_assoc())
{
	$int_feedback=0;
	$sql_update_tripple="Update triples SET ";
//	echo $sql_update_tripple;
	if ($_POST['Correct'.$row["triple_ID"]]=="correct")
	{
		$int_feedback=1;
		$sql_update_tripple.=" triple_correct= ";
		$sql_update_tripple.=$row["triple_correct"]+1;
	//	echo $sql_update_tripple;
	}elseif ($_POST['Correct'.$row["triple_ID"]]=="incorrect")
	{
		$int_feedback=-1;
		$sql_update_tripple.= " triple_incorrect=";
		$sql_update_tripple.= $row["triple_incorrect"]+1;
	//	echo $sql_update_tripple;
	}
	elseif ($_POST['Correct'.$row["triple_ID"]]=="NA")
	{
		$int_feedback=0;
		$sql_update_tripple.= " triple_no_input=";
		$sql_update_tripple.= $row["triple_no_input"]+1;
	//	echo $sql_update_tripple;
	}
	$sql_update_tripple.=" where triple_ID= ";
	$sql_update_tripple.=$row["triple_ID"];
	//echo $sql_update_tripple."<br>";//_POST['Correct'.$row["triple_ID"]];
	if ($conn->query($sql_update_tripple) === TRUE) {
			$sql_insert_triples_Feedback="INSERT INTO triples_feedback (triple_id,user_name,feedback, time_stamp)
					VALUES(".$row["triple_ID"].",'".$_SESSION["user_name"]."',".$int_feedback.",".$server_date .");";//feedback here is -1,0, or 1. but always 1 with new triples
			//echo $sql_insert_triples_Feedback;
			if ($conn->query($sql_insert_triples_Feedback) === TRUE) {
				//Do nothing
			} 
			else 
			{
				$db_error.=" Error in Inserting the new triples";
				$db_error.= $conn->error;
			}
	} else {
		$db_error.=" Error in updating the triples";
		$db_error.= $conn->error;
	}
}
//update Sentences section
/* UPDATE Sentences s1, (SELECT sentence_count+1 sen_count, sentence_id
FROM Sentences
WHERE sentence_id = ?) s2
SET s1.sentence_count= s2.sen_count
WHERE s1.sentence_id = s2.sentence_id; */
$sql_update_statement="UPDATE Sentences s1, (SELECT sentence_count+1 sen_count, sentence_id
FROM Sentences
WHERE sentence_id =";
$sql_update_statement.=$statment_ID;
$sql_update_statement.=") s2
SET s1.sentence_count= s2.sen_count
WHERE s1.sentence_id = s2.sentence_id";
if ($conn->query($sql_update_statement) === TRUE) {
	//echo "Record updated successfully";
} else {
	$db_error.=" Error in updating the Sentences counter";
	$db_error.= $conn->error;
}

//Insert new triples section

if( isset($_POST['predicate']) )
{
	//$chkbox = $_POST['chk'];
	$predicate=$_POST['predicate'];
	$begin_args=$_POST['begin_args'];
	$end_args=$_POST['end_args'];
	$relation=$_POST['relation'];
	
	$hwords_list_row = $_POST['hwords_list'];
	$hwords_list = json_decode(str_replace("\\","",$hwords_list_row) ,true);
	
	
	$hpos_list_row = $_POST['hpos_list'];
	//$decodedText = html_entity_decode($hpos_list_row);
	$hpos_list = json_decode(str_replace("\\","",$hpos_list_row) ,true);//(array)json_decode($decodedText, true);
	
	//echo '$$hpos_list_row'.$hpos_list_row."<br>";
	//echo '$$decodedText'.$decodedText."<br>";
	//$element0=json_decode(str_replace("\\","",$hpos_list[0]) ,true);
	//echo '$$hpos_list'.$hpos_list."<br>";
	//echo '$$hpos_list'.count($hpos_list)."<br>";
	//echo '$$hpos_list'.$hpos_list[0]."<br>";
	//echo '$$hpos_list'.$element0."<br>";
	//echo '$$hpos_list'.count($element0)."<br>";
	/* echo count($predicate);
	echo "<br/>";
	echo "chkbox:".json_encode($chkbox);
	echo "<br/>";
	echo "Predicates:".json_encode($predicate);
	echo "<br/>";
	echo "begin_args:".json_encode($begin_args);
	echo "<br/>";
	echo "end_args:".json_encode($end_args);
	echo "<br/>";
	echo "relation:".json_encode($relation);
	echo "<br/>";
	echo json_encode($hwords_list);
	echo "<br/>";
 */
	

	foreach($predicate as $a => $b)
	{
		//echo 'a'.$a."<br>";
		//echo 'b'.$b."<br>";
		$sql_insert_triples="INSERT INTO triples (sentence_id, predicate_id,relation,arg_start_id,arg_end_id,triple_correct,triple_type)
			VALUES";
		$sql_insert_triples_values="";
		//$first_values=true;
		//start of triples validation to avoid the improper ones
		//echo '$begin_args[$a]'.$begin_args[$a]."<br>";
		//echo '$end_args[$a]'.$end_args[$a]."<br>";
		//echo '$predicate[$a]'.$predicate[$a]."<br>";
		
		if(($begin_args[$a]>$end_args[$a]) || ($predicate[$a]>=$begin_args[$a] && $predicate[$a]<=$end_args[$a]))
		{
			$final_message=$final_message. 'Relation with predicate: <b>'.$hwords_list[$b-1].'</b> and argument start: <b>'
				.$hwords_list[$begin_args[$a]-1] .
			'</b> and argument end: <b>'.$hwords_list[$end_args[$a]-1] .'</b> is ignored due to <font color="red">misordered arguments.</font>'."</div><br>";
			continue;
		}
		//echo 'predicate is'.$b-1;
		//echo 'a'.$hpos_list[$b-1]."<br>";
		if (strpos($hpos_list[$b-1], 'DT') !== false) 
		{  
			$final_message=$final_message. 'Relation with predicate: <b>'.$hwords_list[$b-1].'</b> and argument start: <b>'
				.$hwords_list[$begin_args[$a]-1] .
			'</b> and argument end: <b>'.$hwords_list[$end_args[$a]-1] .'</b> is ignored due to <font color="red">(predicate should not be a determiner)</font>'."</div><br>";
			
			continue;
		}
		
		$Duplicate=FALSE;
		for($j=0; $j<$a; $j++) {
			$tempPredicateID = $predicate[$j] ;//id
			$tempRelation = $relation[$j];//string
			//echo "Compare:tempPredicateID".$tempPredicateID." predicate[a]:".$predicate[$a]. " tempRelation:".$tempRelation. " relation[a]".$relation[$a]."<br>";
			if($tempPredicateID==$predicate[$a] && $tempRelation==$relation[$a])
			{
				//echo "Duplicate<br>";
				$Duplicate=TRUE;
				break;
			}
		}
		//echo "Duplicate:".$Duplicate;
		if($Duplicate==TRUE)
		{
			$final_message=$final_message. 'Relation with predicate: <b>'.$hwords_list[$b-1].'</b> and argument start: <b>'
				.$hwords_list[$begin_args[$a]-1] .
			'</b> and argument end: <b>'.$hwords_list[$end_args[$a]-1] .'</b> is ignored because it is <font color="red">duplicate.</font>'."</div><br>";
			
			continue;
		}
		
		$nounExist=FALSE;
		for ($j=$begin_args[$a]; $j<= $end_args[$a]; $j++) {
			//echo "POSLOC".strpos($hpos_list[$j-1], 'DT');
			//echo "A".$a.substr( $hpos_list[$j-1], 0, 2 )."  ".$hpos_list[$j-1]."<br>";
			if (substr( $hpos_list[$j-1], 0, 2 ) != "DT")
			{
				$nounExist=TRUE;
			}
		}
		//echo "Predicate:".$predicate[$a]." ".$nounExist."<br>";
		if(!$nounExist)
		{
			$final_message=$final_message. 'Relation with predicate: <b>'.$hwords_list[$b-1].'</b> and argument start: <b>'
					.$hwords_list[$begin_args[$a]-1] .
					'</b> and argument end: <b>'.$hwords_list[$end_args[$a]-1] .'</b> is ignored due to <font color="red">(Argument has no nouns).</font>'."</div><br>";
				
			continue;
		}
		//end of triples validation to avoid the improper ones
		//if($first_values==false)
		//{
		//	$sql_insert_triples_values.=",";
		//}
		$sql_insert_triples_values.="(";
		$sql_insert_triples_values.=$statment_ID;
		$sql_insert_triples_values.=",";
		$sql_insert_triples_values.=$predicate[$a] ;
		$sql_insert_triples_values.=",'";
		$sql_insert_triples_values.=$relation[$a];
		$sql_insert_triples_values.="',";
		$sql_insert_triples_values.=$begin_args[$a];
		$sql_insert_triples_values.=",";
		$sql_insert_triples_values.=$end_args[$a];
		$sql_insert_triples_values.=",1,";
		$sql_insert_triples_values.="'new');";
		//$sql_insert_triples_values.="'".$_SESSION["user_name"]."'";
		//$sql_insert_triples_values.=")";
		
		//$first_values=false;//to start adding , between values
		//echo 'values....'.$sql_insert_triples_values;
		if ($sql_insert_triples_values!= "")//if you have correct new triples to be inserted
		{
			//echo $sql_insert_triples.$sql_insert_triples_values;
			if ($conn->query($sql_insert_triples.$sql_insert_triples_values) === TRUE) {//after insert new triple, insert its feedback separaetly 
				//printf ("New Record has id %d.\n", $conn->insert_id);
				$sql_insert_triples_Feedback="INSERT INTO triples_feedback (triple_id,user_name,feedback, time_stamp)
					VALUES(".$conn->insert_id.",'".$_SESSION["user_name"]."',1,".$server_date .");";//feedback here is -1,0, or 1. but always 1 with new triples
				//echo $sql_insert_triples_Feedback;
				if ($conn->query($sql_insert_triples_Feedback) === TRUE) {
					//Do nothing
					$final_message=$final_message. 'Relation with predicate: <b>'.$hwords_list[$b-1].'</b> and argument start: <b>'
					.$hwords_list[$begin_args[$a]-1] .
					'</b> and argument end: <b>'.$hwords_list[$end_args[$a]-1] .'</b> <font color="green"> is saved.</font>' . "<br>";
						
				} 
				else 
				{
					$db_error.=" Error in Inserting the new triples";
					$db_error.= $conn->error;
				}
			} else {
				$db_error.=" Error in Inserting the new triples";
				$db_error.= $conn->error;
			}
		}
	}
	
	
	
}

//Here we start rendenring the page
if($db_error=="") //we dont have errors
{
	echo '<header>';
	echo '<h1>Thank you '.$_SESSION["user_name"].' for your feedback.<br></h1>';
	echo '<div align="right">';
	include 'Welcome_msg.php';
	echo '</div>';
	echo '</header>';
	echo '<section>';
	echo $final_message;
	echo '<h2>	Would you link to <a href="index.php">check another sentence</a></h2>';
	
	echo '</section>';
	
	echo '<footer>';
	include 'footer.php';
	echo '</footer>';
}
else //we have errors
{
	echo '<header>';
	echo '<h1>Some Errors are happened during your feedback<br></h1>';
	echo '</header>';
	echo '<section>';
	echo $final_message;
	echo '<h2>	Would you like to <a href="index.php">check another sentence</a></h2>';
	echo $db_error;
	echo '</section>';
	
	echo '<footer>';
	include 'footer.php';
	echo '</footer>';
	
}

$conn->close();
?>