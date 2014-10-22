<?php
	//returns monday midnight of the week the timestamp $ts is in
	function maandagmorgen($ts){
		$monday=strtotime("last Monday",$ts);
		$info=getdate($ts);
		if($info['wday']==1){
			//$ts is al een maandag
			$monday=$ts;
		}
		
		$result= date('D d M Y',$monday);
		return $result;
	}
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
	$insertAll=$_GET["insertAll"];
	include_once('../../daos/dbConnect.php');
	include_once('../../daos/pracDao.php');
	include_once('../../daos/groepDao.php');
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
	//echo "$ondervraagtype";
	//aantal berekenen die ondervraagd kunnen worden
	$duration=getInterrogationDuration($pracId);
	$ts=strtotime($datum);
	$startts=getTimestamp($ts,$start);
	$stopts=getTimestamp($ts,$stop);
	$number=($stopts-$startts)/($duration*60);//min omzetten naar seconden
	
	//echo "kan er $number ondervragen;<br/>duration $duration<br/> stop $stopts;start $startts";
	//print("<br/>".date('D d M Y H:i',$startts));
	//print("<br/>".date('D d M Y H:i',$stopts));
	//$diff=($stopts-$startts)/(60);
	//print("diff $diff");
	//reedsgeplande ondervragingen
	$nrScheduled=getNrInterrogations($pracId,$ondervragerId,$startts,$stopts);
	//aantal dat nog gepland kan worden
	$canSchedule=$number-$nrScheduled;
	$freeids=getFree($pracId,$pracReeks,$canSchedule);
	
	echo "reeds gepland: $nrScheduled  <br/>";
	$offset=$duration*$nrScheduled;
	$tijdstip=strtotime("+$offset minutes",$startts);
	if($tijdstip<$stopts){
		foreach($freeids as $id){
			
			//echo "<br/>$pracId ondervraagdeid $id,ondervrager $ondervragerId<br/>";
			print(date('D d M Y H:i',$tijdstip));
			$groepNr=getGroepNr($pracId,$id);
			$studInfo=getStudentInfo($id);
			//print_r($studInfo);
			$pracReeks=$studInfo["pracreeks"];
			print(" groep $groepNr pracreeks $pracReeks ");
			if($tijdstip<$stopts){
				
				if($insertAll==1){
					ondervragingInvoeren($pracId,$id,$ondervragerId,$tijdstip);
					print("inserted<br/>");
				}
				else{
					print(" not inserted <br/>");
				}
				$tijdstip=strtotime("+$duration minutes",$tijdstip);
			}	
			else{
				echo "eindtijd overschreden";
			}
			
		}
	}
	


?>