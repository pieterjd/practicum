<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php
	include_once('../daos/dbConnect.php');
	connect();
	include_once('../daos/groepDao.php');
	include_once('../daos/studentDao.php');
	include_once('../daos/pracDao.php');
?>
<head profile="http://gmpg.org/xfn/11">

	<title>Practicum Groep Overzicht</title>
	<link rel="stylesheet" type="text/css" href="./css/inschrijven.css" />
	<link rel="stylesheet" type="text/css" href="./css/ui.tabs.css" />
	<script src="./javascript/jquery-1.2.1.pack.js" type="text/javascript"></script>
        <script src="./javascript/ui.tabs.js" type="text/javascript"></script>


</head>

<body>
<?php
	
	$pracId=$_GET['pracId'];
	
	$snummer=$_SERVER['HTTP_SHIB_PERSON_UID'];
	$studId=getStudId($snummer);
	//echo "<div>maxgroepnummer:".getMaxGroupNumber($pracId).'</div>';
?>


<div id="container">
	<div id="groep_data" >
	
	<?php
		$practitel=getPracTitle($pracId);
		echo "<h2>$practitel: Overzicht van de ondervragingen</h2>";
		$interquery="select id,naam,voornaam from prac_ondervragers where pracid=$pracId";
		$interresult=mysql_query($interquery);
		
		while($interrow=mysql_fetch_array($interresult)){
			echo "<h3>".$interrow[1]." ".$interrow[2]."</h3>";
			$interId=$interrow[0];
			$query="select prac_student.naam,prac_student.voornaam,prac_ondervragers.naam,prac_ondervragers.voornaam,tijdstip,prac_student.pracreeks from prac_student,prac_ondervragers,prac_ondervraging where studentid=prac_student.id and ondervragerid=prac_ondervragers.id and prac_ondervraging.pracid=$pracId and prac_ondervragers.id=$interId";
			//echo $query;
			$result=mysql_query($query);
			echo "<ul>\n";
			while($row=mysql_fetch_array($result)){
				$formattedDate=date('D d M Y H:i',$row[4]);
				$stud=$row[0].' '.$row[1];
				$inter=$row[2].' '.$row[3];
				$pracReeks=$row[5];
				echo "<li>$formattedDate: $stud $pracReeks</li>\n";
			}
			echo "</ul>";
		}
		/*
		$pracreeksen=getPracReeksen($pracId);
		foreach($pracreeksen as $reeks){
			$aantalOnd=aantalOndervragingen($pracId,$reeks);
			echo "$reeks : $aantalOnd ondervragingen<br/>";
		}
		*/
		
	?>
	</div><!--groep_data-->


</div><!--container-->	



	
</body>
</html>
