<?php
	include('../connect.php');
	include('../gegevensVakonline.php');
	connect($db_host,$database,$user,$paswoord);
	$query="select pracid,name,year,study from prac_practicum";
	echo "<form>\n";
	echo "<select id=\"pracId\" onChange=\"generatePages()\">\n";
	$result=mysql_query($query);
	while($row=mysql_fetch_array($query)){
		echo "<option value=\"$row[0]\">$row[1] ($row[3],$row[2])</option>\n";
	}
	echo"</form>\n";
?>