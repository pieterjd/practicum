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
	//returns a html table with possible slots
	function buildTable($startts,$stopts,$ondervragingstijd,$pracId,$ondervragerId){
		$html="<table><tr><th>tijdstip</th><th>ondervraagden</th></tr>";
		$ondervraagts=$startts;
		while($ondervraagts<$stopts){
			$date=date('D d M Y H:i',$ondervraagts);
			//echo "$date<br/>";
			$ondervraging=getOndervraging($pracId,$ondervragerId,$ondervraagts);
			
			if($ondervraging==""){
				$html.="<tr><td >$date</td><td id=\"$ondervraagts\" class=\"free\">Nothing</td></tr>";
			}
			else{
				$html.="<tr><td >$date</td><td id=\"$ondervraagts\">$ondervraging</td></tr>";
			}
			$ondervraagts=strtotime("+$ondervragingstijd minutes",$ondervraagts);
		}
	
		$html.="</table>";
		return $html;
	}
	$pracId=$_GET["pracId"]; 
	$pracReeks=$_GET["pracReeks"];
	$ondervragerId=$_GET["ondervragerId"];
	$datum=$_GET["datum"];
	$start=$_GET["start"];
	$stop=$_GET["stop"];
	
	include_once('../../daos/dbConnect.php');
	include_once('../../daos/pracDao.php');
	connect();
	$query="select ondervraagtypeid from prac_practicum where id=$pracId";
	echo "$query";
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

	//tabel opbouwen met overzicht
	
	
	$ondervragingstijd=getInterrogationDuration($pracId);
	$ts=strtotime($datum);
	$m=maandagmorgen($ts);
	$info="pracid $pracId reeks $pracReeks ondervr$ondervragerId datum $datum start $start stop $stop maandagmorgen $m";
	//print("printinfo");
	//echo "$info";
	$ts=strtotime($datum);
	$startts=getTimestamp($ts,$start);
	$stopts=getTimestamp($ts,$stop);
	print(date('D d M Y H:i',$startts));
	print(buildTable($startts,$stopts,$ondervragingstijd,$pracId,$ondervragerId));
	
?>