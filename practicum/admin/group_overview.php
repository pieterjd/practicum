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

	<title>Admin Groep Overzicht</title>
	<link rel="stylesheet" type="text/css" href="../css/inschrijven.css" />
	<link rel="stylesheet" type="text/css" href="../css/ui.tabs.css" />
	<script src="./javascript/jquery-1.2.1.pack.js" type="text/javascript"></script>
<script src="./javascript/ui.tabs.js" type="text/javascript"></script>


</head>

<body>
<?php
	
	$pracId=$_GET['pracId'];
	//$full=1 dan ook tabellen van groepen die uit studenten bestaan die op het zelfde moment oefeningnen hebben
	$full=($_GET['full']?$_GET['full']:0);
	//minimale submission level
	$sl= ($_GET['sl']?$_GET['sl']:1);
	$snummer=$_SERVER['HTTP_SHIB_PERSON_UID'];
	$studId=getStudId($pracId,$snummer);
	$ondervraagType=getOndervraagtype($pracId);
	//echo "<div>maxgroepnummer:".getMaxGroupNumber($pracId).'</div>';
?>


<div id="container">
	<div id="groep_data" >
	
	<?php
		$practitel=getPracTitle($pracId);
		echo "<h1>$practitel: Overzicht - admin module</h1><br/>";
		echo 'url params:';
		echo '<dl><dt>full</dt><dd>=1 overzicht van groepen die al dan niet op het zelfde moment oefeningen hebben</dd>';
		echo '<dt>sl</dt><dd>minimaal submission level: indien 1, dan alles ingediend; indien 0.5, minstens helft; indien 0 niets ingediend - defaults to 1</dd><dt></dt><dd></dd></dl>';
		echo '<br/>';
		echo "<b>Current url params</b>: full = $full ; sl = $sl";
		echo '<h2>Student Overzicht</h2>';
		$reeksen=getPracReeksen($pracId);
		echo '<a href="#groepen">Jump to groep overzicht</a> ';
		echo '<a href="#cijfers">Jump to cijfertjes</a> ';
		echo '<a href="#alfabet">Jump to student alfabetisch</a> ';
		$submittedStuds=0;
		$notSubmittedStuds=0;
		$submittedGroups=0;
		$notSubmittedGroups=0;
		foreach($reeksen as $reeks){
			//echo $reeks;
			
			//alle studenten van reeks $reeks oproepen
			//en overlopen
			$studs=getIngeschrevenStudentenFromReeks($pracId,$reeks);
			if($sl!=1){
				//echo 'niet submitted toevoegen';
				$nietIn=getIngeschrevenStudentenFromReeks($pracId,$reeks,$sl);
				$studs=array_merge($studs,$nietIn);
			}
			//print_r($reeksGroepen);
			
			$nrStuds=count($studs);
			$submittedStuds+=$nrStuds;
			$notSubStuds=getIngeschrevenStudentenFromReeks($pracId,$reeks,0);
			$notSubmittedStuds+=count($notSubStuds);
			echo "<h2>Reeks $reeks ($nrStuds studenten)</h2><br/>\n";
			//echo "<ul>";
			foreach($studs as $index => $studInfo){
				echo $studInfo['nummer']." ".$studInfo['naam']." ".$studInfo['voornaam']."<br/>";
				
			}
			//echo"</ul>";
		}
		echo '<a name="groepen"><h2>Groep Overzicht</h2></a>';
		foreach($reeksen as $reeks){
			//echo $reeks;
			
			//alle groepen van reeks $reeks oproepen
			//en overlopen
			$groeps=getIngeschrevenGroepenFromReeks($pracId,$reeks);
			if($sl!=1){
				//ook niet ingeschreven groepen nodig
				$nietIn=getIngeschrevenGroepenFromReeks($pracId,$reeks,$sl);
				$groeps=array_merge($groeps,$nietIn);
			}
			//print_r($groeps);
			
			$nrGroeps=count($groeps);
			$submittedGroups+=$nrGroeps;
			$notSubGroeps=getIngeschrevenGroepenFromReeks($pracId,$reeks,0);
			$notSubmittedGroups+=count($notSubGroeps);
			
			echo "<h2>Reeks $reeks ($nrGroeps groepen)</h2><br/>\n";
			
			$zelfdeMomentOef=array();
			$nietZelfdeMomentOef=array();
			
			$zelfdeReeks=array();
			$nietZelfdeReeks=array();
			
			foreach($groeps as $index => $groepRow){
				$groepNr=$groepRow[0];
				$groepId=$groepRow[1];
				if($ondervraagType==1){//individueel ondervraging
					$leden=getAllMembers($groepId);
					$toPrint="";
					foreach($leden as $snummer => $studName){
						$toPrint= "$groepNr $studName<br/>";
					}
				}
				else{//groepondervraging
					$leden=getAllMembers($groepId,0);
					$toPrint="$groepNr ";
					foreach($leden as $snummer => $studName){
						//$toPrint.= "$studName ";
					}
					//$toPrint.= "<br/>";
				}
				
				echo $toPrint."<br/>";
				
				if(countGroeps($groepId)==1){
					//alle studenten hebben op het zelfde moment oefeningen
					$zelfdeMomentOef[]=$toPrint."<br/>";
				}
				else{
					//zelfde namiddag oefeningen maar niet zelfde moment
					$nietZelfdeMomentOef[]=$toPrint."<br/>";
				}
				if(countReeks($groepId)==1){
					//alle studenten hebben zelfde reeksnr
					$zelfdeReeks[]=$toPrint."|".implode(',',getGroepReeksen($groepId))."<br/>";
				}
				else{
					//niet alle studenten hebben zelfde reeksnr
					$nietZelfdeReeks[]=$toPrint."|".implode(',',getGroepReeksen($groepId))."<br/>";
				}
				
			}
			//tabel maken
			if($full==1){
				echo "<table>";
				echo "<tr><th>zelfde namiddag,zelfde uur</th><th>zelfde namiddag, ander uur</th></td>";
				$leftCol="";
				foreach($zelfdeMomentOef as $line){
					$leftCol=$leftCol.$line;
				}
				$rightCol="";
				foreach($nietZelfdeMomentOef as $line){
					$rightCol=$rightCol.$line;
				}
				echo "<tr><td>$leftCol</td><td>$rightCol</td></tr>";
				echo "</table>";
				//tabel over zelfde reeks
				echo "<table>";
				echo "<tr><th>zelfde reeks</th><th>verschillende reeksen</th></td>";
				$leftCol="";
				foreach($zelfdeReeks as $line){
					$leftCol=$leftCol.$line;
				}
				$rightCol="";
				foreach($nietZelfdeReeks as $line){
					$rightCol=$rightCol.$line;
				}
				echo "<tr><td>$leftCol</td><td>$rightCol</td></tr>";
				echo "</table>";
			}
			
		}
		echo '<a name="alfabet"><h2>Student alfabetisch op familienaam</h2></a>';
		$list = getIngeschrevenStudentenAlfabetisch($pracId,$sl);
		foreach($list as $index => $studInfo){
			echo $studInfo['nummer']." ".$studInfo['naam']." ".$studInfo['voornaam']."<br/>";
		}
		
		
		$studs=$submittedStuds+$notSubmittedStuds;
		$groups=$submittedGroups+$notSubmittedGroups;
		$studsSubRel=round($submittedStuds/$studs*100,2);
		$studsNotSubRel=100-$studsSubRel;
		$groupsSubRel=round($submittedGroups/$groups*100,2);
		$groupsNotSubRel=100-$groupsSubRel;
		echo '<a name="cijfers"><h2>Cijferkes</h2></a>';
		echo '<table>';
		echo "<tr><th></th><th>Groep</th><th>Student</th></tr>";
		echo "<tr><td>Submitted</td><td>$submittedStuds ($studsSubRel%) </td><td>$submittedGroups ($groupsSubRel%)</td></tr>";
		echo "<tr><td>Not Submitted</td><td>$notSubmittedStuds ($studsNotSubRel%)</td><td>$notSubmittedGroups ($groupsNotSubRel%)</td></tr>";
		
		echo "<tr><td>Totaal</td><td>$studs</td><td>$groups</td></tr>";
		echo '</tabel>';
		
	?>
	</div><!--groep_data-->


</div><!--container-->	



	
</body>
</html>
