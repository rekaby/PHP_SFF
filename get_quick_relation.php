<?php

include("dbCred.php");

// get the q parameter from URL
$q = $_REQUEST["rel_type"];
$word_list=array();

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}



//if ($q == "New") {
	$sql = "SELECT * FROM triples where relation='".$q.
	"' and triple_correct=0 and triple_incorrect=0 and triple_no_input=0  ";//temp selection untill we have minimum 1 input for each triple
	//echo "SQL:".$sql;
//}

$sql_result = $conn->query($sql);

$result="";
$haveRecords=false;
//$result='Please select the a sentence: <select id="sentence_ID" name="sentence_ID">';
	if ($sql_result->num_rows > 0) {
		$triple_rank=rand(1,$sql_result->num_rows);
		//echo $sql_result->num_rows;
		//echo $triple_rank.'<br>';
		
		for ($i=1;$i<$triple_rank;$i++)
		{
			$row = $sql_result->fetch_assoc();
		}
		
		$result.=ConstructTheTable($row["triple_ID"],$row["sentence_id"],$conn);//' '.$row["triple_ID"].' '.$row["sentence_id"].' '.$row["relation"].' '.$row["predicate_id"].' ';
		
		$haveRecords=true;
	}
//$result.='</select><br>';
if ($haveRecords) {
	$result.='<input type="submit" value="Correct" name="SubmitAgree" class="agree">';
	$result.='<input type="submit" value="Incorrect" name="SubmitDisAgree" class="disagree">';
	$result.='<input type="submit" value="Not sure" name="SubmitDontKnow" ><br><br>';
	$result.='<input type="hidden" name="triple_ID" value='.$row["triple_ID"].'>';
	foreach($row as $row_element)
	{
		$result.='<input type="hidden" name="hidden_row[]" value='.$row_element.'>';
		
	}
	$result.= '<p>';
	$result.='<a href="index.php">Home</a>&nbsp';
	$result.= '</p>';
}
else 
{
	//$result.='At the moment: No more relations of this type needed to be verified. Please select another type.';
}

		
echo $result;
$conn->close();

function ConstructTheTable($triple_ID_arg,$sentence_ID_arg,$conn)
{
		$result='';
		$triple_ID=$triple_ID_arg;
		$sentence_ID=$sentence_ID_arg;
		/////////next level sentence and word level/////////
		$sql2 = "SELECT Words.sentence_id,word_ID ,word
		 FROM Words,Sentences where Sentences.sentence_id=Words.sentence_id
		 and  Sentences.sentence_id=".$sentence_ID." order by word_ID" ;
		//echo '<br>'.$sql2;
		$sql_result2 = $conn->query($sql2);
		$word_list=array();
		
	
		while ($row2 = $sql_result2->fetch_assoc())
		{
			array_push($GLOBALS['word_list'],$row2["word"]);
		}
	
		////////End of sentence and word level
	
		///////Second level sentence and triples level/////////
		$sql3 = "SELECT sentence,triple_ID, predicate_id,relation,arg_start_id,arg_end_id,triple_type
		 FROM triples,Sentences where Sentences.sentence_id=triples.sentence_id
		  and Sentences.sentence_id=".$sentence_ID. " and triple_ID=".$triple_ID;
		//echo '<br>'.$sql3;
		$sql_result3 = $conn->query($sql3);
		//echo '<form action="Feedback_Succ.php" method="post">';
	
		//		echo '<table class="readonly">';
	
		while ($row3 = $sql_result3->fetch_assoc())
		{
			$result.=  '<br>';
			$result.=  '<table class="readonly">';
			$result.=  '<tr class="spaceTop">';
			$result.=  '<td>';
			$result.=  '<label for="Predicate">The sentence: </label>';
			$result.=  "<b>".$row3["sentence"]."</b>";
			$result.=  '</td>';
			$result.=  '<td>';
			$result.=  '<label for="Predicate">The sentence#: </label>';
			$result.=  "<b>".$sentence_ID."</b>";
			$result.=  '</td>';
			$result.=  '</tr>';
			$result.=  '</table>';
				
			$result.=  '<table class="readonly">';
			$result.=  '<tr class="data">';
			$result.=  '<td>';
			$result.=  '<label for="Predicate">The following entity/event:</label>';
			$result.=  '<input type="text" value="'.getWordbyOrder($row3["sentence"] ,$row3["predicate_id"]).'" disabled="disabled">';
			$result.=  '</td>';
				
			$result.=  '<td>';
			$result.=  '<label for="Relation">has a relation:</label>';
			$result.=  '<input type="text" value="'.getUserFriendlyRelationName($row3["relation"]).'" disabled="disabled">';
			$result.=  '</td>';
				
			$result.=  '<td>';
			$result.=  '<label for="Argument">with argument:</label>';
			$result.=  '<input type="text" value="'.getWordsbyOrder($row3["sentence"] ,$row3["arg_start_id"],$row3["arg_end_id"]).'" disabled="disabled">';
			$result.=  '</td>';
			$result.=  '<td>';
			$result.=  '</tr>';
			$result.=  '</table>';
	
			$result.=  '<table class="readonly">';
			$result.=  '<tr class="spaceUnder">';
			$result.=  '<td>';
			$result.=  'In another form:';
			$result.=  '</td>';
			$result.=  '<td>';
			$result.=  '"'.getWordsbyOrder($row3["sentence"] ,$row3["arg_start_id"],$row3["arg_end_id"]). '" play a role "'.$row3["relation"].'" of "'.getWordbyOrder($row3["sentence"] ,$row3["predicate_id"]).'"';
			$result.=  '</td>';
			$result.=  '<td>';
			$result.=  '</td>';
			$result.=  '</tr>';
			$result.=  '</table>';
		
			return $result;
	}
}
function getWordbyOrder($string, $wordId)
{
	//$data   =  explode(" ", $string);//preg_split('/\s+/', $string);
	//echo $string.'         ';
	//	echo $data[0].'   '.$data[1].'   '.$data[2].'   ';
	return  $GLOBALS['word_list'][$wordId-1];//coz its 0 based
}
function getWordsbyOrder($string, $wordId,$wordEndId)
{
	//$data   = preg_split('/\s+/', $string);
	$words='';
	//echo $string.'         ';
	//	echo $data[0].'   '.$data[1].'   '.$data[2].'   ';
	for ($i=$wordId;$i<=$wordEndId;$i++)
	{
		$words.=$GLOBALS['word_list'][$i-1].' ';//coz its 0 based array
}
$words=trim($words);
return  $words;//coz its 0 based
}

function getUserFriendlyRelationName($relation)
{
	//if($relation=="Agent")
	//	$relation="Subject (Agent)";
	//if($relation=="Patient")
	//	$relation="Object (Patient)";
	if($relation=="Beneficiary")
		$relation="Goal (Beneficiary)";



	return  $relation;//coz its 0 based
}

?>