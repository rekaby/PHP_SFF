<?php
// get the q parameter from URL
$q = $_REQUEST["rel_type"];

/* $result=  '<a href="Help_Details.php?Help='.$q.'_Role" target="_blank">
		<img src="imgs\help.ico"  style="float:left;width:30;height:30;" \>
			</a>';
 */
$result=  '<a href="Help_Details.php?Help='.$q.'_Role" target="_blank">
			 <img src="imgs\\help.png" title="Help of '. $q .'"  width="20" height="20" \>
			</a>';

//'<img src="imgs\\help.ico"  style="float:left;width:30;height:30;" \>';

echo $result;

?>