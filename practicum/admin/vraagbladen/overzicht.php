<html>
<head>
</head>
<body>
<?php
	include('../connect.php');
	include('../gegevensVakonline.php');
	connect($db_host,$database,$user,$paswoord);
	$group=$_GET['group'];
	$serie=$_GET['serie'];
	$pracId=$_GET['pracId'];
	$otherSerie=0;
	if($serie%2==0){
		$otherSerie=$serie-1;
	}
	else{
		$otherSerie=$serie+1;
	}
	
	$vopQuery="select count(distinct groupid) from prac_group,prac_studenten where pracid=$pracId and prac_studenten.studid=prac_group.studid and (serie=$serie or serie=$otherSerie) and vop=1";
	//echo "$vopquery<br>";
	$vopResult=mysql_query($vopQuery);
	$vopRow=mysql_fetch_array($vopResult);
	$vopGroepen=$vopRow[0];
	
	$query="select distinct groupid from prac_group,prac_studenten where pracid=$pracId and prac_studenten.studid=prac_group.studid and (serie=$serie or serie=$otherSerie) order by groupid";
	echo "$query<br>";
	$result=mysql_query($query);
	$groepen=mysql_num_rows($result);
	$echteGroepen=$groepen-$vopGroepen;
	echo "groepen: $groepen, VOPgroepen: $vopGroepen, gewone groepen: $echteGroepen";
	echo "<table>\n";
	
	while($row=mysql_fetch_array($result)){
		$groupId=$row[0];
		echo "<tr><td>$groupId</td><td>";
		$studQuery="select name,firstname,groep,serie,vop from prac_studenten,prac_group where groupid=$groupId and prac_group.studid=prac_studenten.studid";
		$studResult=mysql_query($studQuery);
		echo "<ol>";
		while($studRow=mysql_fetch_array($studResult)){
			echo "<li>$studRow[0] $studRow[1] ($studRow[2]$studRow[3])";
			if($studRow[4]==1){
				echo " VOP-er";
			}
		}
		echo "</ol></td></tr>\n";	
	}
	echo "</table\n";
	
?>
</body>
</html>