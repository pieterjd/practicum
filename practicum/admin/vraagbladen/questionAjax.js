var xmlHttp;

function generatePages(){	  
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null){
	  alert ("Browser does not support HTTP Request")
	  return;
	} 
	var pracId=document.getElementById("pracid").value;
	//alert("pracId: "+pracId);
	var ondervrager=document.getElementById("ondervrager").value;
	//alert("ondervrager: "+ondervrager);
	var groepen=document.getElementById("groepen").value;
	//alert("groepen: "+groepen);
	var datum=document.getElementById("datum").value;
	var gen=document.getElementById("genType").value;
	var codeGen=document.getElementById("codeGen").value;
	var aftekenGen=document.getElementById("aftekenGen").value;
	//alert("codepagina: "+codeGen);
	var url="generateQuestions.php";
	url=url+"?pracId="+pracId;

	
	url+="&ondervrager="+ondervrager;
	url+="&groepen="+groepen;
	url+="&datum="+datum;
	url+="&genType="+gen;
	url+="&codeGen="+codeGen;
	url+="&aftekenGen="+aftekenGen;
	xmlHttp.onreadystatechange=stateChanged 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
} 

function stateChanged(){ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	 { 
	 document.getElementById("output").innerHTML=xmlHttp.responseText 
	 } 
}

function GetXmlHttpObject(){
	var xmlHttp=null;
	try
	 {
	 // Firefox, Opera 8.0+, Safari
	 xmlHttp=new XMLHttpRequest();
	 }
	catch (e)
	 {
	 // Internet Explorer
	 try
	  {
	  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
	  }
	 catch (e)
	  {
	  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	 }
	return xmlHttp;
}