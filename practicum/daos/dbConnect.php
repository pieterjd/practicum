<?php
	function connect(){
		$db_host = "wwwdb.cc.kuleuven.ac.be";
		$database = "kckalender";
		$user= "kckalender";
		$paswoord="Aig8voop"; 
		mysql_connect($db_host,$user,$paswoord) or die("Verbinding is mislukt, probeer opnieuw of verwittig de systeembeheerder.");
		
		mysql_select_db($database)or die("Selecteren van database mislukt.");

	}
	
	function insertText($tekst){
		$query="insert into inlinetest (tekst) values('$tekst')";
		mysql_query($query);
	}
	function saveTekst($id,$tekst){
		$query="update inlinetest  set tekst'$tekst' where id=$id";
		mysql_query($query);
	}

?>