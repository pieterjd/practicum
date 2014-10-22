<?php
	function getStudId($pracId,$snummer){
		$query="select prac_student.id from prac_student,prac_practicum where snummer='$snummer' and prac_student.richtingid=prac_practicum.richtingid and prac_practicum.id=$pracId";
		$result=mysql_query($query);
		$row=mysql_fetch_array($result);
		return $row[0];
	}
	/*
	returns associative array: key is the id of student, value is the full name of the student
	*/
	function getStudents($pracId,$groep,$pracreeks,$VOP){
		$query="select prac_student.id,voornaam,naam,groep,pracreeks from prac_student,prac_practicum where prac_practicum.id=$pracId and prac_practicum.richtingid=prac_student.richtingid  and pracreeks='$pracreeks' and VOP=$VOP order by naam,voornaam";
		//echo $query;
		$result=mysql_query($query);
		$students=array();
		while($row=mysql_fetch_array($result)){
			$id=$row[0];
			$naam=$row[2].' '.$row[1];
			$students[$id]=$naam;
		}
		return $students;
	}
	
	function getCandidateGroupMembers($pracId,$studId,$VOP){
		$query="select groep,pracreeks from prac_student where id=$studId";
		//echo $query;
		$result=mysql_query($query);
		$row=mysql_fetch_array($result);
		//echo "getcandidates-pracreeks: ".$row[1];
		$candidates=getStudents($pracId,$row[0],$row[1],$VOP);
		return $candidates;
	}
	
	function nrOfGroups($pracId,$studId){
		$query="select distinct groepid from prac_groep,prac_groep_stud where pracid=$pracId and studid=$studId and prac_groep.id=prac_groep_stud.groepid";
		//echo $query;
		$result=mysql_query($query);
		$nrrows=mysql_num_rows($result);
		//$row=mysql_fetch_array($result);
		return $nrrows;
	}
	/*returns associative array*/
	function getStudentInfo($studId){
		$query="select voornaam,naam,snummer,email,groep,reeks,VOP,pracreeks,id from prac_student where id=$studId";
		//echo $query;
		$result=mysql_query($query);
		$row=mysql_fetch_array($result,MYSQL_ASSOC);
		return $row;
	}
	/* werkt niet, voor een of andere reden heeft parameter $studId nooit een waarde
	function isAvailable($pracId,$StudId){
		echo "isAvailablestudId:$studId";
		return nrOfGroups($pracId,$studId)==0;
	}
	*/
	function getStudentMail($studId){
	}
	
	
	

?>