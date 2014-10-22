<?php
	function getNewGroupId($pracId){
		$query="select max(groupid) from prac_group where pracid=$pracId";
		$result=mysql_query($query);
		$row=mysql_fetch_array($result);
		return $row[0]+1;
	}
	include('../connect.php');
	include('../gegevensVakonline.php');
	connect($db_host,$database,$user,$paswoord);
	$pracId=3;
	$query="select studid from prac_studenten,prac_practicum where pracid=$pracId and prac_studenten.year=prac_practicum.year and prac_studenten.study=prac_practicum.study";
	$result=mysql_query($query);
	while($row=mysql_fetch_array($result)){
		$groupId=getNewGroupId($pracId);
		$query="insert into prac_group (pracid,studid,groupid) values($pracId,$row[0],$groupId)";
		echo "$query<br>";
		mysql_query($query);
	}
	
	

?>