<html>
<head>
<title>Ondervraagbladen</title>
<script src="./jquery/jquery-1.6.min.js"></script> 
<script src="questionAjax.js"></script> 
<script type="text/javascript">

function openOverview(){
	var pracId=document.getElementById("pracid").value;
	var winpops=window.open("overview.php?pracId="+pracId,"","width=900,height=600,scrollbars,resizable");
}
/*
$(document).ready(function(){  
	$("form.select,form.input").change(function(){  
		var pracId=document.getElementById("pracid").value;
		//alert("pracId: "+pracId);
		var ondervrager=document.getElementById("ondervrager").value;
		//alert("ondervrager: "+ondervrager);
		var groepen=document.getElementById("groepen").value;
		//alert("groepen: "+groepen);
		var datum=document.getElementById("datum").value;
		var gen=document.getElementById("genType").value;
		var codeGen=document.getElementById("codeGen").value;
		//alert("codepagina: "+codeGen);
		var url="generateQuestions.php";
		url=url+"?pracId="+pracId;

		
		url+="&ondervrager="+ondervrager;
		url+="&groepen="+groepen;
		url+="&datum="+datum;
		url+="&genType="+gen;
		url+="&codeGen="+codeGen;
		$("#output").load(url);  
    });  
});  
*/
</script>
</head>
<body>
<?php
	include_once('../../daos/dbConnect.php');
	connect();
	include_once('../../daos/groepDao.php');
	include_once('../../daos/studentDao.php');
	include_once('../../daos/pracDao.php');
?>
<form id="form"> 
<select  id="pracid" onchange="generatePages()" >
<?php
	$year=date('Y');
	$pracs=getAllPrac($year);
	foreach($pracs as $id=>$name){
		echo "<option value=\"$id\">$name</option>";
	}
?>
</select><!--practicum id-->
Vragen/checklist?: <select  id="genType" onkeyup="generatePages()" ><option value="1">Vragenblad (Voor infor. 2)</option><option value="0" selected >Checklist (Voor MI)</option></select>
ondervrager: <input type="text" size=10 id="ondervrager" onkeyup="generatePages()" value="Pieter-Jan" inputtooltiptext="Vul je naam in."/>
codeblad? <select id="codeGen" onchange="generatePages()" ><option value="1" selected>Ja</option><option value="0"  >Nee</option></select>
Aftekenblad? <select id="aftekenGen" onchange="generatePages()" ><option value="1" selected>Ja</option><option value="0" >Nee</option></select><br/>
groepen: <input type="text" id="groepen" onkeyup="generatePages()" value="2,3,4" /> <a href="javascript:openOverview()">Zoek groepsnummer</a><br/>
datum: <input type="text" id="datum" onkeyup="generatePages()" value="today"/> Je kan ook <code>+2 days</code> of <code>today</code> invullen


</form>
<hr/>
<br/><br/>
<span id="output"></span>
<!--<textarea rows="4" cols="50" id="output"></textarea>-->
</body>
</html>