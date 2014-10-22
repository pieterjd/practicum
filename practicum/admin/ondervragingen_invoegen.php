<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php
	include_once('../daos/dbConnect.php');
	connect();
	include_once('../daos/groepDao.php');
	include_once('../daos/studentDao.php');
	include_once('../daos/pracDao.php');
	include_once('../daos/ondervragingDao.php');
?>
<head profile="http://gmpg.org/xfn/11">

	<title>Admin Ondervragingen invoegen</title>
	<link rel="stylesheet" type="text/css" href="./css/inschrijven.css" />
	<link rel="stylesheet" type="text/css" href="./css/ui.tabs.css" />
	<script src="./javascript/jquery-1.2.1.pack.js" type="text/javascript"></script>
<script src="./javascript/ui.tabs.js" type="text/javascript"></script>


</head>

<body>
<?php
	
	$pracId=$_GET['pracId'];
	function doeInschrijvingen($pracId,$reeks,$ondervragerId,$aantalStudenten,$startTijd,$minOndervraging){
		$nogNietIngeschrevenIds=getFreeStudents($pracId,$reeks,$aantalStudenten);
		$nr=count($nogNietIngeschrevenIds);
		echo "$nr nog niet ingeschreven<br/>";
		foreach($nogNietIngeschrevenIds as $studId){
			$info=getStudentInfo($studId);
			//print_r($info);
			$stud=$info['naam'].' '.$info['voornaam'];
			$formattedDate=date('D d M Y H:i',$startTijd);
			echo "Geplande ondervraging $stud: $formattedDate<br/>";
			ondervragingInvoeren($pracId,$studId,$ondervragerId,$startTijd);
			$startTijd=strtotime("+ $minOndervraging minutes",$startTijd);
			
		}
	}
	
	//echo "<div>maxgroepnummer:".getMaxGroupNumber($pracId).'</div>';
?>


<div id="container">
	<div id="groep_data" >
	
	<?php
		$practitel=getPracTitle($pracId);
		echo "<h2>$practitel: Invoegen ondervragingen - admin module</h2>";
		$startTijd=mktime(0,0,0,8,14,2008);
		$minOndervraging=15;
		$aantalStudenten=8;
		/*ondervragingen voor werner augustus 2008*/
		
		$ondervragerId=2;
		$reeks='B34';
		$begin=strtotime("+10 hours 15 minutes",$startTijd);	
		doeInschrijvingen($pracId,$reeks,$ondervragerId,$aantalStudenten,$begin,$minOndervraging);
		/*
		$begin=strtotime("+ 10 hours 35 minutes",$startTijd);
		doeInschrijvingen($pracId,$reeks,$ondervragerId,$aantalStudenten,$begin,$minOndervraging);
		$begin=strtotime("+ 13 hours 50 minutes",$startTijd);
		doeInschrijvingen($pracId,$reeks,$ondervragerId,$aantalStudenten,$begin,$minOndervraging);
		$begin=strtotime("+ 16 hours 0 minutes",$startTijd);
		doeInschrijvingen($pracId,$reeks,$ondervragerId,$aantalStudenten,$begin,$minOndervraging);
		*/
		
		/*ondervragingen voor werner*/
		/*
		$startTijd=mktime(0,0,0,3,19,2008);
		$ondervragerId=2;
		$reeks='A12';
		
		$begin=strtotime("+ 13 hours 50 minutes",$startTijd);
		doeInschrijvingen($pracId,$reeks,$ondervragerId,$aantalStudenten,$begin,$minOndervraging);
		
		$reeks='A34';
		$aantalStudenten=5;
		$begin=strtotime("+ 14 hours 35 minutes",$startTijd);
		doeInschrijvingen($pracId,$reeks,$ondervragerId,$aantalStudenten,$begin,$minOndervraging);
		
		$aantalStudenten=8;
		$begin=strtotime("+ 16 hours 0 minutes",$startTijd);
		doeInschrijvingen($pracId,$reeks,$ondervragerId,$aantalStudenten,$begin,$minOndervraging);
		
		
		$startTijd=mktime(0,0,0,3,21,2008);
		$ondervragerId=2;
		$reeks='A34';
		$aantalStudenten=8;
		$begin=strtotime("+8 hours 25 minutes",$startTijd);	
		doeInschrijvingen($pracId,$reeks,$ondervragerId,$aantalStudenten,$begin,$minOndervraging);
		$begin=strtotime("+ 10 hours 35 minutes",$startTijd);
		doeInschrijvingen($pracId,$reeks,$ondervragerId,$aantalStudenten,$begin,$minOndervraging);
		*/
		//Eryk op vrijdag
		/*
		$ondervragerId=3;
		$reeks='A34';
		$begin=strtotime("+8 hours 25 minutes",$startTijd);	
		doeInschrijvingen($pracId,$reeks,$ondervragerId,$aantalStudenten,$begin,$minOndervraging);
		*/
		//aram op woensdag
		/*
		$startTijd=mktime(0,0,0,3,19,2008);
		$ondervragerId=4;
		$reeks='B12';
		$begin=strtotime("+8 hours 25 minutes",$startTijd);	
		doeInschrijvingen($pracId,$reeks,$ondervragerId,$aantalStudenten,$begin,$minOndervraging);
		$begin=strtotime("+ 10 hours 35 minutes",$startTijd);
		doeInschrijvingen($pracId,$reeks,$ondervragerId,$aantalStudenten,$begin,$minOndervraging);
		$begin=strtotime("+ 13 hours 50 minutes",$startTijd);
		doeInschrijvingen($pracId,$reeks,$ondervragerId,$aantalStudenten,$begin,$minOndervraging);
		$begin=strtotime("+ 16 hours 0 minutes",$startTijd);
		doeInschrijvingen($pracId,$reeks,$ondervragerId,$aantalStudenten,$begin,$minOndervraging);
		*/
		
		//yves op woensdag
		/*
		$startTijd=mktime(0,0,0,3,19,2008);
		$ondervragerId=1;
		$reeks='B12';
		$begin=strtotime("+8 hours 25 minutes",$startTijd);	
		doeInschrijvingen($pracId,$reeks,$ondervragerId,$aantalStudenten,$begin,$minOndervraging);
		
		$reeks='B34';
		$begin=strtotime("+ 9 hours 10 minutes",$startTijd);	
		doeInschrijvingen($pracId,$reeks,$ondervragerId,5,$begin,$minOndervraging);
		
		$begin=strtotime("+ 10 hours 35 minutes",$startTijd);
		doeInschrijvingen($pracId,$reeks,$ondervragerId,$aantalStudenten,$begin,$minOndervraging);
		$begin=strtotime("+ 13 hours 50 minutes",$startTijd);
		doeInschrijvingen($pracId,$reeks,$ondervragerId,$aantalStudenten,$begin,$minOndervraging);
		$begin=strtotime("+ 16 hours 0 minutes",$startTijd);
		doeInschrijvingen($pracId,$reeks,$ondervragerId,$aantalStudenten,$begin,$minOndervraging);
		*/
		//yves op vrijdag
		/*
		$startTijd=mktime(0,0,0,3,21,2008);
		$ondervragerId=1;
		$reeks='B34';
		$begin=strtotime("+8 hours 25 minutes",$startTijd);	
		doeInschrijvingen($pracId,$reeks,$ondervragerId,5,$begin,$minOndervraging);
		*/
		//werner nog 1 op vrijdag
		/*$startTijd=mktime(0,0,0,3,21,2008);
		$ondervragerId=2;
		$reeks='B34';
		$aantalStudenten=8;
		$begin=strtotime("+12 hours 20 minutes",$startTijd);	
		doeInschrijvingen($pracId,$reeks,$ondervragerId,1,$begin,$minOndervraging);
		*/
		
		//Eryk op vrijdag
		/*
		$startTijd=mktime(0,0,0,3,21,2008);
		$ondervragerId=3;
		$reeks='A34';
		$begin=strtotime("+8 hours 25 minutes",$startTijd);	
		doeInschrijvingen($pracId,$reeks,$ondervragerId,4,$begin,$minOndervraging);
		$reeks='B34';
		$begin=strtotime("+9 hours 25 minutes",$startTijd);	
		doeInschrijvingen($pracId,$reeks,$ondervragerId,1,$begin,$minOndervraging);
		
		*/
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		/*
		$nogNietIngeschrevenIds=getFreeStudents($pracId,'A12');
		$nr=count($nogNietIngeschrevenIds);
		echo "$nr nog niet ingeschreven";
		foreach($nogNietIngeschrevenIds as $studId){
			$info=getStudentInfo($studId);
			//print_r($info);
			$formattedDate=date('D d M Y H:i',$startTijd);
			echo "student: ".$info['naam']." ".$info['voornaam'];
			echo "Geplande ondervraging: $formattedDate<br/>";
			
			//ondervragingInvoeren($pracId,$studId,$ondervragerId,$startTijd);
			$startTijd=strtotime("+ $minOndervraging minutes",$startTijd);
			
		}
		*/
	?>
	</div><!--groep_data-->


</div><!--container-->	



	
</body>
</html>
