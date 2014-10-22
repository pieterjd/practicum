<?php
	//$datum is een ts om middernacht, $uur is string van de vorm 'hh:mm'
	function getTimestamp($datum,$uur){
		list($uur,$min)=split(':',$uur);
		//print(date('D d M Y h:m',$datum));
		//print ("uur $uur min $min");
		$result=strtotime("+ $uur hours $min minutes",$datum);
		
		return $result;
	}
	$pracId=$_GET["pracId"]; 
	$pracReeks=$_GET["pracReeks"];
	$ondervragerId=$_GET["ondervragerId"];
	$datum=$_GET["datum"];
	$start=$_GET["start"];
	$stop=$_GET["stop"];
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
	echo "$ondervraagtype";
	$ts=strtotime($datum);
	$startts=getTimestamp($ts,$start);
	$stopts=getTimestamp($ts,$stop);
	$nr=getNrInterrogations($pracId,$ondervragerId,$startts,$stopts);
	echo "reeds gepland: $nr";
	$freeids=getFree($pracId,$pracReeks,10);
	echo '<ul>';
	foreach($freeids as $id){
		$info=getInfo($id);
		if($ondervraagtype==1){
			//individuele ondervraging
			//elementen met css class 'block' worden omgevormd tot draggables
			echo "<li class=\"block\" id=\"$id\">studid $id</li>";
		}
		else{
			echo "<li class=\"block\" id=\"$id\">groepid $id</li>";
		}
	}
	echo "</ul>";


?>