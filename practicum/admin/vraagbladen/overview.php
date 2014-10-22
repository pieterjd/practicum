<?php
	function getNewGroupId($pracId){
		$query="select max(groupid) from prac_group where pracid=$pracId";
		$result=mysql_query($query);
		$row=mysql_fetch_array($result);
		return $row[0]+1;
	}
	include_once('../../daos/dbConnect.php');
	include_once('../../daos/pracDao.php');
	connect();
	$pracId=$_GET['pracId'];
	$query="select maxStuds,prac_practicum.name,prac_richting.name,year from prac_practicum,prac_richting where prac_practicum.id=$pracId and richtingid=prac_richting.id";
	 //echo $query;
	 $result=mysql_query($query);
	 $row=mysql_fetch_array($result);
	 $maxTeamMembers=$row[0];
	 echo "<h2>Overzicht van de groepen $row[1] ($row[2], $row[3])</h2>\n";
	$query="select naam,voornaam,nummer from prac_student,prac_groep,prac_groep_stud where prac_groep.pracid=$pracId and prac_groep_stud.studid=prac_student.id and prac_groep_stud.groepid=prac_groep.id order by naam";
	//echo $query;
	
	$result=mysql_query($query);
	echo "<table>\n";
	echo "<tr><th>Naam</th><th>Groepsnummer</th>\n";
	while($row=mysql_fetch_array($result)){
		echo "<tr><td>$row[0] $row[1]</td><td>$row[2]</td></tr>\n";
	}
	echo "</table>\n";
	
	
	

?>