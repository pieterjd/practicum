<?php
	function getPracTitle($pracid){
		$q="select prac_practicum.name,prac_richting.name,year from prac_practicum,prac_richting where prac_practicum.id=$pracid and richtingid=prac_richting.id";
		//echo $q;
		$res=mysql_query($q);
		$row=mysql_fetch_array($res);
		$name=$row[0];
		$richting=$row[1];
		$year=$row[2];
		$title=$name."(".$richting.", ".$year.")";
		return $title;
	}
	function getInterrogationDuration($pracid){
		$q="select prac_practicum.interrogationduration from prac_practicum where prac_practicum.id=$pracid";
		//echo $q;
		$res=mysql_query($q);
		$row=mysql_fetch_array($res);
		$duration=$row[0];
		return $duration;
	}
	function getMinStudent($pracid){
		$q="select prac_practicum.minStuds from prac_practicum where prac_practicum.id=$pracid";
		//echo $q;
		$res=mysql_query($q);
		$row=mysql_fetch_array($res);
		
		return $row[0];
		
	}
	function getMaxStudent($pracid){
		$q="select prac_practicum.maxStuds from prac_practicum where prac_practicum.id=$pracid";
		//echo $q;
		$res=mysql_query($q);
		$row=mysql_fetch_array($res);
		
		return $row[0];
		
	}
	function getOndervraagtype($pracid){
		$q="select prac_practicum.ondervraagtypeid from prac_practicum where prac_practicum.id=$pracid";
		//echo $q;
		$res=mysql_query($q);
		$row=mysql_fetch_array($res);
		
		return $row[0];
		
	}
	function getDeadline($pracId){
		$q="select deadline from prac_practicum where prac_practicum.id=$pracId";
		//echo $q;
		$res=mysql_query($q);
		$row=mysql_fetch_array($res);
		
		return $row[0];
	}
	
	function getPracReeksen($pracId){
		$query="select distinct pracreeks from prac_groep where prac_groep.pracid=$pracId order by pracreeks";
		//echo "$query";
		$result=mysql_query($query);
		$reeksen=array();
		while($row=mysql_fetch_row($result)){
			$reeksen[]=$row[0];
			//echo "row ".$row[0];
		}
		return $reeksen;
	}
	function zendBevestigingsMail($pracId,$ingelogdeStud,$gekozenStuds,$additionalMessage = ''){
		$inlog=getStudentInfo($ingelogdeStud);
		$to=$inlog['email'];
		
		$initName=$inlog['voornaam']." ".$inlog['naam'];
		$titel=getPracTitle($pracId);
		$subject="Bevestiging Inschrijving ".$titel;
		$message="Beste student\n\n$initName heeft een groepje gevormd voor het practicum.";
		if(count($gekozenStuds)>0){
			
			 $message.=" Hij/zij koos volgende teamleden:\n\n";
			foreach($gekozenStuds as $index=>$studentId){
				$stud=getStudentInfo($studentId);
				$naam=$stud['voornaam']." ".$stud['naam'];
				$message.="* $naam\n";
				$to.=','.$stud['email'];
				
			}
		}
		$message .= "\n $additionalMessage";
		$message.="\n\nGelieve niet te replyen, dit is een automatisch gegenereerde mail. Bij problemen stuur je best een email naar de monitor van dit vak.\nVeel succes!";
		$html_message=str_replace("\n","<br/>",$message);
		echo "<dl><dt>Verzonden bericht:</dt><dd>$html_message</dd><dt>Ontvangers:</dt><dd>$to</dt></dl>";
		//echo "$to <br>$subject<br>$html_message<br>";
		mail($to,$subject,$message);
		
	}
	function getAllPrac($year){
		$prevYear=$year--;
		$q="select prac_practicum.id,prac_richting.year,prac_practicum.name from prac_practicum,prac_richting where (year like '%$year' or year like '%$prevYear') and prac_practicum.richtingid=prac_richting.id order by prac_practicum.id DESC";
		//echo $q;
		$pracs=array();
		$r=mysql_query($q);
		while($row=mysql_fetch_row($r)){
			$pracs[$row[0]]=$row[1]." ".$row[2];
		
		}
		return $pracs;
		
	}
	
?>