<?php

	/*returns array of student ids without ondervraging*/
	function getFree($pracId,$pracreeks,$aantal=0){
		//aparte tabel empty'n
		$query="truncate table tmp_ondervraging";
		mysql_query($query);
		//alle studenten met ondervraging in aparte tabel
		$query="insert into tmp_ondervraging(id) select prac_ondervraging.studentid from prac_ondervraging,prac_student where pracreeks='$pracreeks' and pracid=$pracId  and prac_ondervraging.studentid=prac_student.id;";
		mysql_query($query);
		//alle niet ondervraagde opvragen
		$query="select prac_student.id from prac_student,prac_groep_stud,prac_groep left join tmp_ondervraging on prac_student.id=tmp_ondervraging.id where tmp_ondervraging.id is null and prac_student.id=prac_groep_stud.studid and prac_groep_stud.groepid=prac_groep.id and prac_groep.pracid=$pracId and prac_student.pracreeks='$pracreeks' order by prac_groep.nummer";
		if($aantal<>0){
			$query.=" LIMIT 0,$aantal";
		}
		//echo $query;
		$result=mysql_query($query);
		$aantalRijen=mysql_num_rows($result);
		echo 'aantal rijen van getFreeStudents query: '.$aantalRijen.'<br/>';
		$ids=array();
		while($row=mysql_fetch_array($result)){
			$id=$row[0];
			$ids[]=$id;
		}
		return $ids;
		
		
	}
	//geeft terug hoeveel ondervragingen al gepland zijn voor een gegeven practicum en ondervrager en begin- en einduur
	function getNrInterrogations($pracId,$interrogatorId,$startts,$stopts){
		$query="select count(id) from prac_ondervraging where ondervragerid=$interrogatorId and pracid=$pracId and $startts<=tijdstip and tijdstip<=$stopts";
		//echo "$query<br/>";
		$result=mysql_query($query);
		$row=mysql_fetch_row($result);
		return $row[0];
	}
	function ondervragingInvoeren($pracId,$studId,$ondervragerId,$tijdstip){
		$query="insert into prac_ondervraging(pracid,studentid,ondervragerid,tijdstip) values ($pracId,$studId,$ondervragerId,$tijdstip)";
		mysql_query($query);	
		//echo $query;	
	}
	function getOndervragingen($pracId,$ondervragerId){
		$query="select * from prac_ondervraging where pracid=$pracId and ondervragerid=$ondervragerId order by tijdstip";
		$onder=array();
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result)){
			$onder[]=$row;	
		}
		return $onder;
		
	}
	function getOndervraging($pracId,$ondervragerId,$timestamp){
		$query="select studentid from prac_ondervraging where pracid=$pracId and ondervragerid=$ondervragerId and tijdstip=$timestamp";
		$result=mysql_query($query);
		$res= "";
		while($row=mysql_fetch_array($result)){
			$res="student $row[0]";
		}
		return $res;
		
	}
	function getOndervragers($pracId){
		$query="select prac_ondervragers.id,voornaam,naam from prac_ondervragers,prac_prac_inter where prac_prac_inter.pracid=$pracId and prac_prac_inter.interrogatorid=prac_ondervragers.id";
		//echo $query;
		$onder=array();
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result)){
			$onder[]=$row;	
		}
		return $onder;
		
	}
	function aantalOndervragingen($pracId,$pracReeks){
		$query="select count(prac_ondervraging.id) from prac_ondervraging,prac_student where pracid=$pracId and studentid=prac_student.id and prac_student.pracreeks='$pracReeks'";
		//echo $query;
		$result=mysql_query($query);
		$row=mysql_fetch_array($result);
		return $row[0];
	}
?>