<?php
	function addStudentToGroep($studid,$groepid){
		$query="insert into prac_groep_stud (groepid,studid) values($groepid,$studid)";
		//echo "addStudent query: $query";
		mysql_query($query);
	}
	/*
	returns associative array: key is the id of groupe, value is the group number
	*/
	function getAllGroups($pracid){
		$groepQuery="select id,nummer from prac_groep where pracid=$pracid order by nummer";
		//echo $groepQuery;
		$groepResult=mysql_query($groepQuery);
		$ids=array();
		
		while($groepRow=mysql_fetch_array($groepResult)){
			//studenten opzoeken die bij deze groep horen
			$groepId=$groepRow[0];
			$groepNumber=$groepRow[1];
			$ids[$groepId]=$groepNumber;
			
		}
		return $ids;
					
	}
	/*
	param addSnummer: if 1, studentnumber is added
	returns associative array: key is the id of student, value is the name of the student
	*/
	function getAllMembers($groepid,$addSnummer=1){
		$leeg=empty($groepid);
		//echo "groepid $groepid".$leeg."<br/>";
		$result=array();
		if(!$leeg){
			$groepQuery="SELECT prac_student.id,naam,voornaam,snummer,pracreeks,qnummer FROM prac_groep_stud,prac_student WHERE groepid=$groepid and studid=prac_student.id order by prac_groep_stud.groepid";
			$groepResult=mysql_query($groepQuery);
			
			
			while($groepRow=mysql_fetch_array($groepResult)){
				//echo "$groepid studentid ".$groepRow[0];
				$result[$groepRow[0]]=$groepRow[1]." ".$groepRow[2];
				if($addSnummer==1){
					$result[$groepRow[0]].=" (".$groepRow[3]."|".$groepRow[5].")";
				}
			}
		}
		return $result;
					
	}
	function getMaxGroupNumber($pracId){
		$query="select max(nummer) from prac_groep where pracid=$pracId";
		$result=mysql_query($query);
		$row=mysql_fetch_array($result);
		return $row[0];
	}
	
	function getCreationDate($groepid){
		$groepQuery="select creationDate from prac_groep where id=$groepid";
		//echo $groepQuery;
		$result=mysql_query($groepQuery);
		$row=mysql_fetch_array($result);
		return $row[0];
	}
	
	function makeNewGroup($pracId,$pracReeks){
		$maxNr=getMaxGroupNumber($pracId);
		$nextNr=$maxNr+1;
		$time=time();
		$query="insert into prac_groep (pracId,nummer,pracreeks,creationDate) values($pracId,$nextNr,'$pracReeks',$time)";
		//echo "new groep $query";
		$result=mysql_query($query);
		return mysql_insert_id();
	}
	/** returns true if #members of group is between bounders*/
	function aantalOk($pracId,$number){
		$query="select minStuds,maxStuds from prac_practicum where id=$pracId";
		$result=mysql_query($query);
		$row=mysql_fetch_array($result);
		$min=$row[0];
		$max=$row[1];
		$ok=($min<=$number && $number<=$max);
		return $ok; 
	}
	/** returns true if #members of group is between bounders, the registrating student NOT included*/
	function aantalOkZonderIngelogdeStudent($pracId,$number){
		return aantalOk($pracId, ($number+1));
	}
	
	/**$submitted=1 enkel studenten die alles ingediend hebben;$submitted=0: niets ingediend; $submitted=0.5: helft ingediend**/
	function getIngeschrevenStudentenFromReeks($pracId,$reeks,$submitted=1){
		$query="select prac_student.id,naam,voornaam,nummer from prac_groep,prac_student,prac_groep_stud where prac_student.pracreeks='$reeks' and prac_student.id=prac_groep_stud.studid and prac_groep.id=prac_groep_stud.groepid and prac_groep.pracid=$pracId and prac_groep.submitted>=$submitted order by nummer,prac_student.id";
		//echo $query;
		$result=mysql_query($query);
		$studs=array();
		while($row=mysql_fetch_array($result)){
			$studs[]=$row;	
		}
		return $studs;
	}
	/**$submitted=1 enkel studenten die alles ingediend hebben;$submitted=0: niets ingediend; $submitted=0.5: helft ingediend
	 *  Alfabetisch op familienaam volgens de Kak wijze van kul (sorteren zonder rekening te houden met spaties)
	 */
	function getIngeschrevenStudentenAlfabetisch($pracId,$submitted=1){
		$query="select prac_student.id,naam,voornaam,nummer,prac_student.pracreeks from prac_groep,prac_student,prac_groep_stud where prac_student.id=prac_groep_stud.studid and prac_groep.id=prac_groep_stud.groepid and prac_groep.pracid=$pracId and prac_groep.submitted>=$submitted order by replace(naam , ' ','')";
		//echo $query;
		$result=mysql_query($query);
		$studs=array();
		while($row=mysql_fetch_array($result)){
			$studs[]=$row;	
		}
		return $studs;
	}
	//returns alle pracreeksen van studenten in groep $groepId
	function getGroepPracreeksen($groepId){
		$query="select prac_groep.pracreeks from prac_groep where id=$groepId";
		$result=mysql_query($query);
		
		return $row[0];
	}
	/**$submitted=1 enkel groepen die alles ingediend hebben;$submitted=0: niets ingediend;;$submitted=0.5: helft ingediend**/	
	function getIngeschrevenGroepenFromReeks($pracId,$reeks,$submitted=1){
		$query="select prac_groep.nummer,prac_groep.id from prac_groep where prac_groep.pracreeks='$reeks' and prac_groep.pracid=$pracId and prac_groep.submitted>=$submitted order by prac_groep.id";
		//echo $query;
		$result=mysql_query($query);
		$groeps=array();
		while($row=mysql_fetch_array($result)){
			$groeps[]=$row;	
		}
		return $groeps;
	}
	function getGroepId($pracId,$studId){
		$query="select prac_groep.id from prac_groep,prac_groep_stud where prac_groep.pracid=$pracId and prac_groep_stud.groepid=prac_groep.id and prac_groep_stud.studid=$studId";
		//echo $query;
		$result=mysql_query($query);
		$row=mysql_fetch_array($result);
		$nr=$row[0];
		return $nr;
	}
	function getGroepNr($pracId,$studId){
		$query="select prac_groep.nummer from prac_groep,prac_groep_stud where prac_groep.pracid=$pracId and prac_groep_stud.groepid=prac_groep.id and prac_groep_stud.studid=$studId";
		//echo $query;
		$result=mysql_query($query);
		$row=mysql_fetch_array($result);
		$nr=$row[0];
		return $nr;
	}
	
	//telt het aantal verschillende groepen (A,B) van de studenten die in groep $groepId zitten
	function countGroeps($groepId){
		$query="SELECT count(distinct  groep) FROM `prac_groep`,prac_groep_stud,prac_student where prac_groep.id=$groepId and prac_groep.id=prac_groep_stud.groepid and prac_groep_stud.studid=prac_student.id";
		//echo $query;
		$result=mysql_query($query);
		$row=mysql_fetch_array($result);
		$nr=$row[0];
		return $nr;
	}
	//telt het aantal verschillende reeksen (1,2,3,...) van de studenten die in groep $groepId zitten
	function countReeks($groepId){
		$query="SELECT count(distinct  reeks) FROM `prac_groep`,prac_groep_stud,prac_student where prac_groep.id=$groepId and prac_groep.id=prac_groep_stud.groepid and prac_groep_stud.studid=prac_student.id";
		//echo $query;
		$result=mysql_query($query);
		$row=mysql_fetch_array($result);
		$nr=$row[0];
		return $nr;
	}
	function getGroepReeksen($groepId){
		$query="SELECT reeks FROM `prac_groep`,prac_groep_stud,prac_student where prac_groep.id=$groepId and prac_groep.id=prac_groep_stud.groepid and prac_groep_stud.studid=prac_student.id";
		//echo $query;
		$result=mysql_query($query);
		$reeksen=array();
		//echo "groepId : $groepId";
		while($row=mysql_fetch_array($result)){
			//echo $row[0].'+';
			$reeksen[]=$row[0];	
		}
		return $reeksen;
	}
	

?>