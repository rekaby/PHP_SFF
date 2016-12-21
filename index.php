<?php
// Start the session
session_start();
include("dbCred.php");
?>
<html>
<link rel="stylesheet" type="text/css" href="feedback.css">

<script>
function loadIDs(str) {

    //if(str=='')
   // {
   // 	str=document.getElementById("statement_Type").valueOf();
    //}
    var xmlhttp = new XMLHttpRequest();
    //alert(str);
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      //	 alert(xmlhttp.responseText);
       	document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
       	
         }
    }
    xmlhttp.open("GET", "getSentenceIds.php?sen_type="+str, true);
    xmlhttp.send();
}

function getSelected()
{
var elem = document.getElementById("statement_Type").getElementsByTagName("option");
var len = elem.length;
var sel = new Array();

for(i=0; i<len;i++)
{
    if(elem[i].selected == true)
  {
    sel.push(elem[i].value);
  }  
}


}
</script>

<body onload="loadIDs('New');">



<header>
<h1>Welcome To Semantic Flickr Feedback (SFF) Home Page</h1>
<div align="right">
<?php include 'Welcome_msg.php';?>
</div>
</header>
<section>


<form action="Sentence_Details.php" method="post">
<h2>Option 1: The whole sentence feedback</h2>
<p>
Here, you will check the complete semantic of a sentence, and give feedback on it. You can accept a part, reject another, and introduce new parts.<br>
Your Name: <input type="text" name="user_name" value="<?php echo $_SESSION["user_name"] ?>" maxlength="20"
			required pattern="(?=.{1,20}$)[A-Za-z0-9_]+" title="Usrname field is required, Alphanumeric in a length between 1-20 characters">

New to SFF? Please check the <a href="HelpMain.php">documentation</a> first!
</p>


<p>
Please select the type of sentence: 
<select class="search" id="statement_Type" name="statement_Type" onchange="loadIDs(this.value);">
  <option value="New" selected>New</option>
  <option value="Reviewed">Reviewed</option>
  <option value="Ref_Example">Reference Example</option>
</select>
</p>

<span id="txtHint"></span>
<p></p>
<h2>Option 2: Quick feedback</h2>
<b>Update:</b> Now we provide an easier way to give a feedback. You will see a sentence and only one semantic relation of it, you can quickly give a feedback on 
this simple relation without thinking of the whole meaning of the sentence. <br>Access it from 
<a href="quick_feedback.php">Here</a> 
</form>
</section>
<footer>

<?php include 'footer.php';?>
</footer>
</body>
