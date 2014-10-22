
 <html>                                                                  
 <head>
 <title>Practicum planner</title>
 <link rel="stylesheet" type="text/css" href="screen.css" />  
 <link rel="stylesheet" type="text/css" href="layout.css" />                                                                
 <script type="text/javascript" src="./js/jquery-1.2.6.min.js"></script> 
 <script type="text/javascript" src="./js/jquery-ui-personalized-1.6rc4.min.js"></script>          
 <script type="text/javascript">                                         
   // we will add our javascript code here      
   $(document).ready(function(){
	  $("#datum").datepicker({dateFormat: 'yy-mm-dd',firstDay:1});
	$("select,input").change(function(){
		inputChanged();
	}
	);
    
    $(".drop,td").droppable({accept:".block",hoverClass:"blue",drop: function(ev,ui){
	    $(this).html(ui.draggable.text());//copy text from dragged ui object
	    $("#outputDiv").prepend(ui.draggable.text()+"<br/>");
	    ui.draggable.remove();
	    $(this).droppable("disable");
		$.get("screen.css", function(data){
  			//$("#outputDiv").append(data).append("<hr/>");
		});


	    
	    
    }//end drop
   
    });//end droppable
    inputChanged();
    
  });//end ready
  
  function inputChanged(){
	  var pracId=$("#pracId").val(); 
	  var pracReeks=$("#pracReeks").val();
	  var ondervragerId=$("#ondervragerId").val();
	  var datum=$("#datum").val();
	  var start=$("#startUur").val();
	  var stop=$("#eindUur").val();
	  //alert(pracId+' '+pracReeks+' '+ondervragerId+' '+datum+' '+start+' '+stop);
	  
	  //alert(names);
	  //alert(values);
	  var parameters={pracId:$("#pracId").val(),pracReeks:$("#pracReeks").val(),ondervragerId:$("#ondervragerId").val(),datum:$("#datum").val(),start:$("#startUur").val(),stop:$("#eindUur").val(),insertAll:0};
	  //alert(parameters);
	  $.get("buildTable.php",parameters,function(data){
		//alert("Data Loaded: " + data);
		$("#tableWrapDiv").html(data+"<br/>");
		$("#tableWrapDiv .free").droppable({accept:".block",hoverClass:"blue",drop: function(ev,ui){
	    	$(this).html(ui.draggable.text());//copy text from dragged ui object
	    	$("#outputDiv").prepend(ui.draggable.text()+"<br/>");
	    	ui.draggable.remove();
	    	$(this).droppable("disable");
	    	
	    	
			
    	}//end drop
   
    	});//end droppable
	  }//end get callback	  
	  );//end .get
	  
	  $.get("interrogateAll.php",parameters,function(data){
			$("#toScheduleDiv").html(data);
			$("#toScheduleDiv").draggable();
			
	    }//end get callback	  
	  );//end .get
	  
	  $("#submit").unbind("click").click(function(){//eerst oude click handler verwijderen en dan de nieuwe eraan hangen
		  
		  
		  	var parameters={pracId:$("#pracId").val(),pracReeks:$("#pracReeks").val(),ondervragerId:$("#ondervragerId").val(),datum:$("#datum").val(),start:$("#startUur").val(),stop:$("#eindUur").val(),insertAll:1};
		  	$.get("interrogateAll.php",parameters);
		  	
	  	  
	  });//end click
  }
 </script>                                                               
 </head>                                                                 
 <body>                                                                  
   <!-- we will add our HTML content here --> 
<?php
	$pracId=$_GET['pracId'];
   	include_once('../../daos/dbConnect.php');
	connect();
	include_once('../../daos/pracDao.php');
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
   
   		
?>
   <div id="controlsDiv">
   	   Select all data:<br/>
   	   <form>
   	   		
   	   		<input id="pracId" size="1" value="<?php echo $pracId;?>" disabled/>
   	   			
   	   		pracreeks:
<?php
				echo '<select id="pracReeks">';
				$pracreeksen=getPracReeksen($pracId);
				foreach($pracreeksen as $pr){
					echo "<option value=\"$pr\">$pr</option>";
				}
				echo '</select>';
?>
   	   			
<?php
   	   		echo '<select id="ondervragerId">';
   	   		$inters=getOndervragers($pracId);
   	   		foreach($inters as $i){
   	   			echo "<option value=\"$i[0]\">$i[1]</option>";
   	   			
	   		}
   	   		echo "</select>";
?>
   	   		Datum<input type="text" id="datum" value="click to pick a date"/>
   	   		Start tijdstip (hh:mm)<input type="text" id="startUur" size="1" value="13:50"></input>
   	   		Eind tijdstip (hh:mm)<input type="text" id="eindUur" size="1" value="15:50"></input>
   	   		

   	  </form>
   </div> 
   <div id="topPartDiv">
   	   <input id="submit" type="submit" value="Insert All"></input>
	   <div id="toScheduleDiv" class="block">
	   
	   
	   </div>
	   <div id="tableWrapDiv">
	   
	   </div>
	    
   </div>
   <div id="outputDiv">
     Here comes the output.<br/>
     
   </div>                            
 </body>                                                                 
 </html>
