<?php
// Start the session
session_start();
?>
<html>
<HEAD>
<link rel="stylesheet" type="text/css" href="feedback.css">

    <SCRIPT language="javascript">
      

            
    </SCRIPT>
</HEAD>

<body >



<?php
	$help_topic= "" ;
	if(isset($_GET["Help"])) {
		$help_topic=   $_GET["Help"] ;
	}
	
	
	
	include("dbCred.php");
	$conn = new mysqli($servername, $username, $password, $dbname);
	//mysqli_set_charset($conn, 'utf8');
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
/////Header section
	echo '<header>';
	echo '<h2>Help of: '.str_replace("_"," ",$help_topic).'<br></h2>';
	echo '</header>';
/////End of Header section
	echo '<section>';
	$sql4 = "SELECT Help_Description.description
			FROM Help_Description
			where Help_Description.group_name='".$help_topic."' order by order_index asc";
	
		
	$sql_result4 = $conn->query($sql4);
	echo '<h3>What is '.str_replace("_"," ",$help_topic).'??</h3>';
	while ($row4 = $sql_result4->fetch_assoc())
	{
		echo '<p>'.$row4["description"].'</p>';
	}
	
	
	$sql = "SELECT Help_Sentences.triple_id, Help_Sentences.group_name, Help_Sentences.help_comment,triples.sentence_id 
			FROM Help_Sentences,triples  
			where Help_Sentences.triple_id=triples.triple_id   and Help_Sentences.group_name='".$help_topic.
			"' order by order_index asc";
	
		 
	$sql_result = $conn->query($sql);
	
	echo '<h3>Real Examples of '.str_replace("_"," ",$help_topic).':</h3>';
	
	while ($row = $sql_result->fetch_assoc())
	{
		$triple_ID=$row["triple_id"];
		$help_comment=$row["help_comment"];
		$sentence_ID=$row["sentence_id"];
		/////////next level sentence and word level/////////
		$sql2 = "SELECT Words.sentence_id,word_ID ,word,pos
		 FROM Words,Sentences where Sentences.sentence_id=Words.sentence_id
		 and  Sentences.sentence_id=".$sentence_ID." order by word_ID" ;
		//echo $sql;
		$sql_result2 = $conn->query($sql2);
		$word_list=array();
		$pos_list=array();
		
		while ($row2 = $sql_result2->fetch_assoc())
		{
			array_push($word_list,$row2["word"]);
			array_push($pos_list,$row2["pos"]);
		}
		
		////////End of sentence and word level 
		
		///////Second level sentence and triples level/////////
		$sql3 = "SELECT sentence,triple_ID, predicate_id,relation,arg_start_id,arg_end_id,triple_type
		 FROM triples,Sentences where Sentences.sentence_id=triples.sentence_id
		  and Sentences.sentence_id=".$sentence_ID. " and triple_ID=".$triple_ID;
		$sql_result3 = $conn->query($sql3);
		//echo '<form action="Feedback_Succ.php" method="post">';
		
//		echo '<table class="readonly">';
		
		while ($row3 = $sql_result3->fetch_assoc())
		{
			echo '<table class="readonly">';
			echo '<tr class="data">';
			echo '<td>';
			echo '<label for="Predicate">The sentence:</label>';
			echo "<b>".$row3["sentence"]."</b>";
			echo '</td>';
			echo '</tr>';
			echo '</table>';
			
			echo '<table class="readonly">';
			echo '<tr class="data">';
			echo '<td>';
			echo '<label for="Predicate">The following entity/event:</label>';
			echo '<input type="text" value="'.getWordbyOrder($row3["sentence"] ,$row3["predicate_id"]).'" disabled="disabled">';
			echo '</td>';
			
			echo '<td>';
			echo '<label for="Relation">has a relation:</label>';
			echo '<input type="text" value="'.getUserFriendlyRelationName($row3["relation"]).'" disabled="disabled">';
			echo '</td>';
			
			echo '<td>';
			echo '<label for="Argument">with argument:</label>';
			echo '<input type="text" value="'.getWordsbyOrder($row3["sentence"] ,$row3["arg_start_id"],$row3["arg_end_id"]).'" disabled="disabled">';
			echo '</td>';
			echo '<td>';
			echo '</tr>';
			echo '</table>';
				
			echo '<table class="readonly">';
			echo '<tr class="data">';
			echo '<td>';
			echo 'In another form:';
			echo '</td>';
			echo '<td>';
			echo '"'.getWordsbyOrder($row3["sentence"] ,$row3["arg_start_id"],$row3["arg_end_id"]). '" play a role "'.$row3["relation"].'" of "'.getWordbyOrder($row3["sentence"] ,$row3["predicate_id"]).'"';
			echo '</td>';
			echo '<td>';
			echo '</td>';
			echo '</tr>';
			echo '</table>';
				
			echo '<table class="readonly">';
			echo '<tr class="spaceUnder">';
			echo '<td>';
			echo $help_comment;
			echo '</td>';
			echo '</tr>';
			echo '</table>';
		}
		
		/////////End of sentence and triples level/////////
		
	}
	echo '<p>';
	echo '<a href="index.php">Home</a>&nbsp';
	echo '<a href="HelpMain.php">Help</a>';
	echo '</p>';


$conn->close();
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
</section>
<footer>
<?php include 'footer.php';?>
</footer>
  
  
</body>
</html>