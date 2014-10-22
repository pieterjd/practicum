<?php

	/*returns array of groep ids without ondervraging*/
	function getFree($pracId,$pracreeks,$aantal=0){
		//aparte tabel empty'n
		$query="truncate table tmp_ondervraging";
		mysql_query($query);
		//alle studenten met ondervraging in aparte tabel
		$query="insert into tmp_ondervraging(id) select prac_groepondervraging.groepid from prac_groepondervraging,prac_groep where prac_groep.pracreeks='$pracreeks' and prac_groep.pracid=$pracId and prac_groepondervraging.groepid=prac_groep.id;";
		mysql_query($query);
		//alle niet ondervraagde opvragen
		$query="select prac_groep.id from prac_groep left join tmp_ondervraging on prac_groep.id=tmp_ondervraging.id where tmp_ondervraging.id is null and prac_groep.pracid=$pracId and prac_groep.pracreeks='$pracreeks' order by prac_groep.id";
		if($aantal<>0){
			$query.=" LIMIT 0,$aantal";
		}
		//echo $query;
		$result=mysql_query($query);
		$aantalRijen=mysql_num_rows($result);
		echo 'aantal rijen van getFreeGroeps query: '.$aantalRijen.'<br/>';
		$ids=array();
		while($row=mysql_fetch_array($result)){
			$id=$row[0];
			$ids[]=$id;
		}
		return $ids;
		
		
	}
	//geeft terug hoeveel ondervragingen al gepland zijn voor een gegeven practicum en ondervrager en begin- en einduur
	function getNrInterrogations($pracId,$interrogatorId,$startts,$stopts){
		$query="select count(id) from prac_groepondervraging where ondervragerid=$interrogatorId and pracid=$pracId and $startts<=tijdstip and tijdstip<=$stopts";
		//echo "$query<br/>";
		$result=mysql_query($query);
		$row=mysql_fetch_row($result);
		return $row[0];
	}
	
	function ondervragingInvoeren($pracId,$groepId,$ondervragerId,$tijdstip){
		$query="insert into prac_groepondervraging(pracid,groepid,ondervragerid,tijdstip) values ($pracId,$groepId,$ondervragerId,$tijdstip)";
		mysql_query($query);	
		echo $query;	
	}
	function getOndervragingen($pracId,$ondervragerId){
		$query="select * from prac_groepondervraging where pracid=$pracId and ondervragerid=$ondervragerId order by tijdstip";
		$onder=array();
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result)){
			$onder[]=$row;	
		}
		return $onder;
		
	}
	function getOndervraging($pracId,$ondervragerId,$timestamp){
		$query="select groepid from prac_groepondervraging where pracid=$pracId and ondervragerid=$ondervragerId and tijdstip=$timestamp";
		
		$result=mysql_query($query);
		$res= "";
		while($row=mysql_fetch_array($result)){
			$res="groep $row[0]";
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
		$query="select count(prac_groepondervraging.id) from prac_ondervraging,prac_groep where pracid=$pracId and groepid=prac_groep.id and prac_groep.pracreeks='$pracReeks'";
		//echo $query;
		$result=mysql_query($query);
		$row=mysql_fetch_array($result);
		return $row[0];
	}
	
	/*returns associative array*/
	function getInfo($groepId){
		$query="select * from prac_groep where id=$groepId";
		$result=mysql_query($query);
		$row=mysql_fetch_array($result,MYSQL_ASSOC);
		return $row;
	}
?>