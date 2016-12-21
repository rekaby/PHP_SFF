<?php
// Start the session
session_start();
?>
<html>
<HEAD>
<link rel="stylesheet" type="text/css" href="feedback.css">

    <SCRIPT language="javascript">
    function updateCombinedArgument(tableID) {
      //  alert ('update');
        var table = document.getElementById(tableID);
        var rowCount = table.rows.length;
		//alert("Row count:"+rowCount);
        for(var i=1; i<rowCount; i++) {
            var row = table.rows[i];
            var predicateID = parseInt(row.cells[1].childNodes[0].value);//id
            var relation = row.cells[2].childNodes[0].value;//string
            var begin_arg = parseInt(row.cells[3].childNodes[0].value);//id
            var end_arg = parseInt(row.cells[4].childNodes[0].value);//id
			//alert ('row:'+i+' P:'+predicateID+ ' b:'+begin_arg+ ' E:'+end_arg + ' Relation:'+relation);
            
			var wordList=document.getElementById('hwords_list').value;
			var wordarray= JSON.parse(wordList);
			var posarray= JSON.parse(document.getElementById('hpos_list').value);
			var arg_result="";
			var msg_result="";
			
            for (var j= begin_arg; j<= end_arg; j++) {
            	arg_result=arg_result+ wordarray[j-1] + " ";//coz its 0 based list
            	
			}
            
            row.cells[5].innerHTML = arg_result;

            var nounExist=false;
			 for(var l=begin_arg; l<= end_arg; l++) {
				if(!posarray[l-1].startsWith('DT'))
				{
					nounExist=true;
				}
			} 
			
			var duplicateRelation=false;
			 for(var k=1; k < i; k++) {
				var tempRow = table.rows[k];
				var tempPredicateID = parseInt(tempRow.cells[1].childNodes[0].value);//id
	            var tempRelation = tempRow.cells[2].childNodes[0].value;//string
	            var tempBegin_arg = parseInt(tempRow.cells[3].childNodes[0].value);//id
	            var tempEnd_arg = parseInt(tempRow.cells[4].childNodes[0].value);//id
	            if(tempPredicateID==predicateID && tempRelation==relation)
				{
					//alert(i+" "+k+" Duplicate");
					duplicateRelation=true;
				} 
			}
             
		 if(end_arg<begin_arg)
		{
			 msg_result="<div class=\"error\">This relation will be ignored:<br>Begin and End argument words are misordered</div>";
			 //alert ('MIS P:'+predicateID+ ' b:'+begin_arg+ ' E:'+end_arg + ' :'+relation);
			 
		}else if(predicateID>=begin_arg && predicateID<=end_arg)//end arg is less than begin arg
		{
			msg_result="<div class=\"error\">This relation will be ignored:<br>The event/entity can not be part of the argument</div>";
			//alert ('Contain P:'+predicateID+ ' b:'+begin_arg+ ' E:'+end_arg + ' :'+relation);
		}
		else if( duplicateRelation)//check duplicate relation
		{
			msg_result="<div class=\"error\">This relation will be ignored:<br>Similar entity/event and relation are mentioned above in the new relations</div>";
		}
		else if (posarray[predicateID-1].startsWith('DT') ) 
		{//check if POS verb, and relation is property
			msg_result="<div class=\"error\">This relation will be ignored:<br>entity/event should be verb or noun, but not a determiner</div>";
		}
		else if(!nounExist)//check noun in the arguments
		{
			msg_result="<div class=\"error\">This relation will be ignored:<br>No Noun is mentioned in the argument</div>";
		}
		else if (posarray[predicateID-1].startsWith('V') && relation=="Property") 
		{//check if POS verb, and relation is property
			msg_result="<div class=\"warning\">The relation is considered, Although we don't expect \"Property\" relation associated with a verb</div>";
		}
		else if (posarray[predicateID-1].startsWith('N') && !(relation=="Property" || relation=="Location"|| relation=="Material")) 
		{//check if POS Noun, and relation is not property nor location
			msg_result="<div class=\"warning\">The relation is considered, Although we don't expect this role associated with a NOUN word</div>";
		}else if (!(posarray[predicateID-1].startsWith('V')||posarray[predicateID-1].startsWith('N'))) {//check if POS neither verb nor noun
			msg_result="<div class=\"warning\">The relation is considered, Although we don't expect relation on such a kind of words</div>";
		}else
		{
			msg_result="<div class=\"accepted\">New relation...will be considered</div>";
		}
		
            row.cells[6].innerHTML = msg_result; 
		
        }
    }

    function addRow(tableID) {
    	    var table = document.getElementById(tableID);
 			
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
 
            var colCount = table.rows[0].cells.length;
            for(var i=0; i<colCount; i++) {
 
                var newcell = row.insertCell(i);
                switch(i) {
                case 0:
                	newcell.innerHTML ='<INPUT type="checkbox" name="chk[]" />';
                        break;
                case 1:
                	newcell.innerHTML =document.getElementById('hpredicate_list_choice').innerHTML;
                	   break;
                case 2:
                    
                	newcell.innerHTML =document.getElementById('hrelation_list_choice').innerHTML;
                       break;
                case 3:
                   
                	newcell.innerHTML =document.getElementById('hbegin_arg_list_choice').innerHTML;
                        break;
                case 4:
                    newcell.innerHTML =document.getElementById('hend_arg_list_choice').innerHTML;
                        break;
                case 5:
                case 6:
                	newcell.innerHTML ='';
                	break;
                        
            }
                //newcell.innerHTML = table.rows[0].cells[i].innerHTML;
                //alert(newcell.childNodes);
              /*   switch(newcell.childNodes[0].type) {
                    case "text":
                            newcell.childNodes[0].value = "KOKO";
                            newcell.childNodes[0].setAttribute("value", "false");
                            newcell.childNodes[0].setAttribute("value", "false");
                            break;
                    case "checkbox":
                            newcell.childNodes[0].checked = false;
                            break;
                    case "select-one":
                            newcell.childNodes[0].selectedIndex = 0;
                            break;
                } */
            }
            updateCombinedArgument(tableID);
        }
 
        function deleteRow(tableID) {
            try {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
 
            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox && true == chkbox.checked) {
                    if(rowCount <= 2) {//coz header row can't be deleted anyway
                        alert("You will delete all new relations.");
                        //break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }
 
 
            }
            }catch(e) {
                alert(e);
            }
            updateCombinedArgument(tableID);
        }


            
    </SCRIPT>
</HEAD>

<body >



<?php

	$_SESSION["user_name"]=$_POST["user_name"];
	
	include("dbCred.php");
	$conn = new mysqli($servername, $username, $password, $dbname);
	//mysqli_set_charset($conn, 'utf8');
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}


	$sql = "SELECT * FROM Sentences where Sentences.sentence_id=".$_POST["sentence_ID"];
		 
	$sql_result = $conn->query($sql);
	
	while ($row = $sql_result->fetch_assoc())
	{
		$sentence_ID=$row["sentence_id"];
		$sentence_Text=$row["sentence"];
		$sentence_Type=$row["sentence_type"];
		echo '<header>';
		echo '<h2>Sentence: '.$row["sentence"].'<br></h2>';
		echo '<h2>Sentence #: '.$row["sentence_id"].'</h2>';
		echo '<div align="right">';
		include 'Welcome_msg.php';
		echo '</div>';
		echo '</header>';
		echo '<section>';
		if(	$row["sentence_type"]=="auto")
		{
			echo '<h3>It is generated by the <font color="red">SSSA Annotator</font>,';
			echo '<span></span> got '.$row["sentence_count"].' feedback(s) so far</h3>';
			
		}else {
			echo '<h3>It is generated as a <font color="red">Reference sentence</font>,';
			echo '<span></span> where No feedbacks are needed!!</h3>';

		}
		
		
	}

	$sql2 = "SELECT Words.sentence_id,word_ID ,word,pos
		 FROM Words,Sentences where Sentences.sentence_id=Words.sentence_id
		 and  Sentences.sentence_id=".$_POST["sentence_ID"]." order by word_ID" ;
	//echo $sql;
	$sql_result2 = $conn->query($sql2);
	$word_list=array();
	$pos_list=array();
	$predicate_list_choice="<SELECT name=\"predicate[]\" onchange=\"updateCombinedArgument('dataTable')\">";
	$begin_arg__list_choice="<SELECT name=\"begin_args[]\" onchange=\"updateCombinedArgument('dataTable')\">";
	$end_arg_list_choice="<SELECT name=\"end_args[]\" onchange=\"updateCombinedArgument('dataTable')\">";
	
	//$word_id=1;
	while ($row2 = $sql_result2->fetch_assoc())
	{
		array_push($word_list,$row2["word"]);
		array_push($pos_list,$row2["pos"]);
		$predicate_list_choice.="<OPTION value=".$row2["word_ID"].">".$row2["word"]."</OPTION>";
		$begin_arg__list_choice.="<OPTION value=".$row2["word_ID"].">".$row2["word"]."</OPTION>";
		$end_arg_list_choice.="<OPTION value=".$row2["word_ID"].">".$row2["word"]."</OPTION>";
		
	//	$word_id++;
	
	}
	$predicate_list_choice.="</SELECT>";
	$begin_arg__list_choice.="</SELECT>";
	$end_arg_list_choice.="</SELECT>";
	
	$relation__list_choice="<SELECT name=\"relation[]\" onchange=\"updateCombinedArgument('dataTable')\">";
	
	$relation__list_choice.="<OPTION value=\"Agent\">Agent</OPTION>";
	$relation__list_choice.="<OPTION value=\"Attribute\">Attribute</OPTION>";
	//$relation__list_choice.="<OPTION value=\"Asset\">Asset</OPTION>";
	$relation__list_choice.="<OPTION value=\"Beneficiary\">Goal (Beneficiary)</OPTION>";
	$relation__list_choice.="<OPTION value=\"Destination\">Destination</OPTION>";
	//$relation__list_choice.="<OPTION value=\"Extent\">Extent</OPTION>";
	$relation__list_choice.="<OPTION value=\"Instrument\">Instrument</OPTION>";
	$relation__list_choice.="<OPTION value=\"Location\">Location</OPTION>";
	$relation__list_choice.="<OPTION value=\"Material\">Material</OPTION>";
	$relation__list_choice.="<OPTION value=\"Patient\">Patient</OPTION>";
	$relation__list_choice.="<OPTION value=\"Property\">Property</OPTION>";
	$relation__list_choice.="<OPTION value=\"Recipient\">Recipient</OPTION>";
	$relation__list_choice.="<OPTION value=\"Source\">Source</OPTION>";
	$relation__list_choice.="<OPTION value=\"Time\">Time</OPTION>";
	$relation__list_choice.="</SELECT>";
	
	//echo json_encode($word_list);
	//echo $word_list;	
	
$sql = "SELECT sentence,triple_ID, predicate_id,relation,arg_start_id,arg_end_id,triple_type
		 FROM triples,Sentences where Sentences.sentence_id=triples.sentence_id
		  and Sentences.sentence_id=".$_POST["sentence_ID"];
$sql_result = $conn->query($sql);
echo '<form action="Feedback_Succ.php" method="post">';

echo '<table class="readonly">';
while ($row = $sql_result->fetch_assoc())
{


echo '<tr class="data">';
echo '<td>';
if ($row["triple_type"]=="new")
{
	echo '<img src="imgs\\UserGen.png"  title="User added record"  style="float:left;width:20;height:20;" \>';
}
else 
{
	echo '<img src="imgs\\SystemGen.png" title="System generated record"style="float:left;width:20;height:20;" \>';
}
echo '<label for="Predicate">The following entity/event:</label>';
echo '<input type="text" value="'.getWordbyOrder($row["sentence"] ,$row["predicate_id"]).'" disabled="disabled">';
echo '</td>';
echo '<td>';
echo '<label for="Relation">has a relation:</label>';
echo '<a href="Help_Details.php?Help='.$row["relation"].'">';
echo '<input type="text" value="'.getUserFriendlyRelationName($row["relation"]).'" disabled="disabled">';
echo '</a>';
echo '</td>';
echo '<td>';
echo '<label for="Argument">with argument:</label>';
echo '<input type="text" value="'.getWordsbyOrder($row["sentence"] ,$row["arg_start_id"],$row["arg_end_id"]).'" disabled="disabled">';
echo '</td>';
echo '<td>';
//echo '<label for="Correct Label">Correct</label>';
echo '<input type="radio" name="Correct'.$row["triple_ID"].'"id="correct" value="correct" checked="checked"><br>';
echo '<label for="correct"><span></span>Correct</label>';
echo '</td>';
echo '<td>';
//echo '<label for="inCorrect Label">Incorrect</label>';
echo '<input type="radio" name="Correct'.$row["triple_ID"].'" id="incorrect" value="incorrect" ><br>';
echo '<label for="incorrect"><span></span>InCorrect</label>';
echo '</td>';
echo '<td>';
//echo '<label for="no input Label">No input</label>';
echo '<input type="radio" name="Correct'.$row["triple_ID"].'" id="NA" value="NA"><br>';
echo '<label for="NA"><span></span>Do not know</label>';
echo '</td>';
echo '</tr>';
echo '<tr class="spaceUnder">';
echo '<td>';
echo 'In another form: "'.getWordsbyOrder($row["sentence"] ,$row["arg_start_id"],$row["arg_end_id"]). '" play a role "'.$row["relation"].'" of "'.getWordbyOrder($row["sentence"] ,$row["predicate_id"]).'"';
echo '</td>';
echo '<td>';
echo '</td>';
echo '<td>';
echo '</td>';
echo '<td>';
echo '</td>';
echo '<td>';
echo '</td>';
echo '<td>';
echo '</td>';

echo '</tr>';




}
echo '</table>';


if($sentence_Type=='auto')
{
echo '<p>
<h4>Do you have something else in mind??? like to contribute new relations!!</h4><br>
    <INPUT type="button" value="Add Row" onclick="addRow(\'dataTable\')" />
 
    <INPUT type="button" value="Delete Row" onclick="deleteRow(\'dataTable\')" />
  
  
    <TABLE id="dataTable"  border="1">
        <TR>';
/* echo        '<TD>
            	<INPUT type="checkbox" name="chk[]" disabled="disabled"/></TD>
            <TD>
            	<INPUT type="text" name="predicate[]" disabled="disabled" value="Event/Entity"/></TD>
            <TD>
            	<INPUT type="text" name="relation[]" disabled="disabled" value="Relation"/></TD>
            <TD>
            	<INPUT type="text" name="begin_args[]" disabled="disabled" value="Begin of argument" onchange=""/>
            </TD>
            <TD>
            	<INPUT type="text" name="end_args[]" disabled="disabled" value="End of argument" onchange=""/>
            </TD>
            <TD>
            	<INPUT type="text" name="args[]" disabled="disabled"  value="Combined Argument" />
            </TD>
            <TD>
            	<INPUT type="text" name="messages[]" disabled="disabled"  value="Message to you!!" />
            </TD>';
 */
echo        '<TD>
            	<INPUT type="checkbox" name="chk[]" disabled="disabled"/></TD>
            <TD>
            	Event/Entity
            <TD>
            	Semantic Role
            <TD>
            	Begin of argument
            </TD>
            <TD>
            	End of argument
            </TD>
            <TD>
            	Combined Argument
            </TD>
            <TD>
            	Message to you!!
            </TD>';

 echo    '</TR>
    </TABLE>';
 
 





	echo '<input type="submit"  value="Submit feedback"/> ';
	echo '<a href="index.php">Back</a>&nbsp';
	echo '<a href="HelpMain.php">Help</a>';
}
else
{
	echo '<a href="index.php">Back</a>&nbsp';
	echo '<a href="HelpMain.php">Help</a>';
	
}
//echo $pos_list. "<br>";
//echo json_encode($pos_list). "<br>";
//echo json_decode(json_encode($pos_list)). "<br>";
//echo count(json_decode(json_encode($pos_list))). "<br>";
//var_dump ((array) json_decode(json_encode($pos_list),true));
//var_dump ((array) json_decode(json_encode($pos_list)));
//echo (array) json_decode(json_encode($pos_list),true)[0]. "<br>";

echo '<input type="hidden" name="statment_ID" value='.$sentence_ID.'>';
echo '<input type="hidden" id="hwords_list" name="hwords_list" value='.json_encode($word_list).'>';

//foreach($pos_list as $value_element)
//{
//	echo $value_element;
echo '<input type="hidden"  id="hpos_list" name="hpos_list"  value='.json_encode($pos_list).'>';
//}
//echo '<input type="hidden"  name=\"hpos_list[]\"  value='.json_encode($pos_list).'>';
//echo '<input type="hidden" id="hwords_list_choice" name="hwords_list_choice" value='.$word_list_choice.'>';


echo '</form>';
echo '<span class="hidden" id="hpredicate_list_choice">'.$predicate_list_choice.'</span>';
echo '<span class="hidden" id="hrelation_list_choice">'.$relation__list_choice.'</span>';
echo '<span class="hidden" id="hbegin_arg_list_choice">'.$begin_arg__list_choice.'</span>';
echo '<span class="hidden" id="hend_arg_list_choice">'.$end_arg_list_choice.'</span>';

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