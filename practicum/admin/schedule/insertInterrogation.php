<?php
	$pracId=$_GET["pracId"]; 
	$teOndervragenId=$_GET["ondervraagde"];
	$ondervragerId=$_GET["ondervragerId"];
	$tijdstip=$_GET["datum"];
	include_once('../../daos/dbConnect.php');
	connect();
	$query="select ondervraagtypeid from prac_practicum where id=$pracId";
	$result=mysql_query($query);
	$row=mysql_fetch_array($result);
	$ondervraagtype=$row[0];
	if($ondervraagtype==1){//individueel ondervragen
		include_once('../../daos/ondervragingDao.php');
		include_once('../../daos/studentDao.php');
	}
	else{
		//groepondervraging
		include_once('../../daos/groepOndervragingDao.php');
		include_once('../../daos/groepDao.php');
	}
	ondervragingInvoeren($pracId,$teOndervragenId,$ondervragerId,$tijdstip);
	foreach($_GET as $id=>$value){
		echo "$id -> $value<br/>";
	}


?>