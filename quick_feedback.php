<?php
// Start the session
session_start();
include("dbCred.php");
$selected_role = "";
if(isset($_POST['SubmitAgree']) ||isset($_POST['SubmitDisAgree'])||isset($_POST['SubmitDontKnow'])){
	
	$selected_role = $_POST['role_Type'];
	// print_r($_POST['hidden_row']);
	$hidden_row_var=array($_POST['hidden_row']);
	//print_r($hidden_row_var);
	//print_r($_POST['hidden_row[]']);
	//echo '<br>'.$hidden_row_var[0][1];
	
	$_SESSION["user_name"]=$_POST["user_name"];
	
	if(isset($_POST['SubmitAgree'])){ //check if form was submitted
		$error= saveTripleFeedback($hidden_row_var[0],1);
		echo $error;
		//echo $_POST['triple_ID'].' is agreed!';
	}
	elseif (isset($_POST['SubmitDisAgree'])) {
		$error= saveTripleFeedback($hidden_row_var[0],-1);//		echo $_POST['triple_ID'].' is Disagreed!';
		echo $error;
	}
	elseif (isset($_POST['SubmitDontKnow'])) {
		$error= saveTripleFeedback($hidden_row_var[0],0);//	echo $_POST['triple_ID'].' is Dont know!';
		echo $error;
	}
	//echo $_POST['role_Type'];
	
}
else
{
}


function saveTripleFeedback($hidden_row,$feedback_arg) {

	$db_error="";
	$conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
		$db_error.=" Error in connecting to DB";
	}
	$dat_format="'Y-m-d H:i:s'";
	$server_date=date($dat_format,$_SERVER['REQUEST_TIME']);
	//echo $server_date;
	/* $sql_select = "SELECT triple_ID,triple_correct,triple_incorrect,triple_no_input
		 FROM triples,Sentences where triples.triple_ID=".$statment_ID;
	$sql_result = $conn->query($sql_select); */
	
	//$final_message='';
	
	
	$int_feedback=0;
	$sql_update_tripple="Update triples SET ";
//	echo $sql_update_tripple;
	if ($feedback_arg==1)
	{
		$int_feedback=1;
		$sql_update_tripple.=" triple_correct= ";
		$sql_update_tripple.=$hidden_row[7]+1;//"triple_correct"
	//	echo $sql_update_tripple;
	}elseif ($feedback_arg==-1)
	{
		$int_feedback=-1;
		$sql_update_tripple.= " triple_incorrect=";
		$sql_update_tripple.= $hidden_row[8]+1;//"triple_incorrect"
	//	echo $sql_update_tripple;
	}
	elseif ($feedback_arg==0)
	{
		$int_feedback=0;
		$sql_update_tripple.= " triple_no_input=";
		$sql_update_tripple.= $hidden_row[9]+1;//"triple_no_input"
	//	echo $sql_update_tripple;
	}
	$sql_update_tripple.=" where triple_ID= ";
	$sql_update_tripple.=$hidden_row[0];//"triple_ID"
	//echo $sql_update_tripple."<br>";//_POST['Correct'.$row["triple_ID"]];
	if ($conn->query($sql_update_tripple) === TRUE) {
			$sql_insert_triples_Feedback="INSERT INTO triples_feedback (triple_id,user_name,feedback, time_stamp)
					VALUES(".$hidden_row[0].",'".$_SESSION["user_name"]."',".$int_feedback.",".$server_date .");";//feedback here is -1,0, or 1. but always 1 with new triples
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
	
	$conn->close();
	return $db_error;
}

?>
<html>
<link rel="stylesheet" type="text/css" href="feedback.css">

<script>
function loadRelations() {
	var php_var = "<?php echo $selected_role; ?>";
	
	if(php_var =='')
		{
			loadIDs('Agent');
		}
		else
		{
			loadIDs(php_var);
		}
}
function loadIDs(str) {

    //if(str=='')
   // {
   // 	str=document.getElementById("statement_Type").valueOf();
    //}
    updateLink(str);
    var xmlhttp = new XMLHttpRequest();
    //alert(str);
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      //	 alert(xmlhttp.responseText);
       	document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
       	
         }
    }
    xmlhttp.open("GET", "get_quick_relation.php?rel_type="+str, true);
    xmlhttp.send();
}
function updateLink(str) {

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
       	document.getElementById("dynalink").innerHTML = xmlhttp.responseText;
       	
         }
    }
    xmlhttp.open("GET", "get_dynamic_help_link.php?rel_type="+str, true);
    xmlhttp.send();
}


</script>

<body onload="loadRelations();">



<header>
<h1>Welcome To Semantic Flickr Feedback (SFF)... Quick feedback Page</h1>
<div align="right">
<?php include 'Welcome_msg.php';?>
</div>
</header>
<section>


<form action="" method="post">
<p>
Your Name: <input type="text" name="user_name" value="<?php echo $_SESSION["user_name"] ?>" maxlength="20"
			required pattern="(?=.{1,20}$)[A-Za-z0-9_]+" title="Usrname field is required, Alphanumeric in a length between 1-20 characters">

New to SFF? Please check the <a href="HelpMain.php">documentation</a> first!
</p>


<p>
Please select the type of relations you want to check: 
<select class="search" id="role_Type" name="role_Type" onchange="loadIDs(this.value);" >
  	<OPTION value="Agent" <?php if ($selected_role == 'Agent') echo 'selected'?>>Agent</OPTION>
	<OPTION value="Attribute"<?php if ($selected_role == 'Attribute') echo 'selected'?>>Attribute</OPTION>
	<OPTION value="Beneficiary"<?php if ($selected_role == 'Beneficiary') echo 'selected'?>>Goal (Beneficiary)</OPTION>
	<OPTION value="Destination"<?php if ($selected_role == 'Destination') echo 'selected'?>>Destination</OPTION>
	<OPTION value="Instrument"<?php if ($selected_role == 'Instrument') echo 'selected'?>>Instrument</OPTION>
	<OPTION value="Location"<?php if ($selected_role == 'Location') echo 'selected'?>>Location</OPTION>
	<OPTION value="Material"<?php if ($selected_role == 'Material') echo 'selected'?>>Material</OPTION>
	<OPTION value="Patient"<?php if ($selected_role == 'Patient') echo 'selected'?>>Patient</OPTION>
	<OPTION value="Property"<?php if ($selected_role == 'Property') echo 'selected'?>>Property</OPTION>
	<OPTION value="Recipient"<?php if ($selected_role == 'Recipient') echo 'selected'?>>Recipient</OPTION>
	<OPTION value="Source"<?php if ($selected_role == 'Source') echo 'selected'?>>Source</OPTION>
	<OPTION value="Time"<?php if ($selected_role == 'Time') echo 'selected'?>>Time</OPTION>
  
</select>
<span id="dynalink"></span>
</p>

<span id="txtHint"></span>

</form>
</section>
<footer>

<?php include 'footer.php';?>
</footer>
</body>
