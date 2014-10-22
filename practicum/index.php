<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php
	include_once('./daos/dbConnect.php');
	connect();
	include_once('./daos/groepDao.php');
	include_once('./daos/studentDao.php');
	include_once('./daos/pracDao.php');
?>
<head profile="http://gmpg.org/xfn/11">

	<title>Practicum Inschrijfsite</title>
	<link rel="stylesheet" type="text/css" href="./css/inschrijven.css" />
	<link rel="stylesheet" type="text/css" href="./css/ui.tabs.css" />
	<script src="./javascript/jquery-1.2.1.pack.js" type="text/javascript"></script>
        <script src="./javascript/ui.tabs.js" type="text/javascript"></script>


</head>

<body>
<?php
	
	$pracId=$_GET['pracId'];
	$snummer=$_SERVER['HTTP_SHIB_PERSON_UID'];
	//echo $snummer;
	$studId=getStudId($pracId,$snummer);
	//echo "<div>maxgroepnummer:".getMaxGroupNumber($pracId).'</div>';
?>


<div id="container">
	<?php $practitel=getPracTitle($pracId);?>
	<h1>Practicum Inschrijfsite: <?php echo $practitel;?></h1>
	<div class="geel"><strong>Bij problemen (je gegevens verschijnen niet, foute gegevens, ...) mail <a href="mailto:pieter-jan.drouillon@mirw.kuleuven.be?subject=practicum inschrijfsite: correctie gegevens">de monitor van dit vak</a> de juiste informatie door.</strong></div>
	<div id="some_output">
	<?php
		if(isset($_GET['submit'])){
			//echo 'submit gedrukt';
			$selectedIds=$_GET['selectedIds'];
			//print_r($selectedIds);
			//echo "ietsz veranderd";
			//aantal leden binnen grenzen?
			if(aantalOkZonderIngelogdeStudent($pracId,count($selectedIds))){
				//aantal ok, nieuwe groep maken	
				$gegevens=getStudentInfo($studId);	
				$pracReeks=$gegevens['pracreeks'];
				$newGroupId=makeNewGroup($pracId,$pracReeks);
				//echo "group id $newGroupId";
				//de ingelogde student toevoegen
				addStudentToGroep($studId,$newGroupId);
				echo "<div class=\"geel\">De inschrijving is gelukt!</div><br />\n";
				if(count($selectedIds)>0){
					foreach($selectedIds as $index=>$studentId){
						//echo "adding $studentId<br />";
						addStudentToGroep($studentId,$newGroupId);
					}
				}
				//nog mail sturen
				zendBevestigingsMail($pracId,$studId,$selectedIds);
			}
			else{
				echo "Teveel of te weinig leden aangeklikt, ga terug.";
			}
		}
	
		
	?>
	</div><!--some_output-->
		
    
    
    
    <div id="user_data" >
	    <div>
	    	
		<?php
			$gegevens=getStudentInfo($studId);
			echo "<dl>\n";
			foreach($gegevens as $type=>$info){
				echo "<dt>$type:</dt><dd>$info</dd>\n";
			}
			
			echo"</dl>\n";
			if((nrOfGroups($pracId,$studId))>0){
				echo "<div class=\"geel\">Je bent al ingeschreven in een groep voor dit practicum.</div>\n";
			}
			else{
				echo "<div class=\"geel\">Je moet nog inschrijven. Beschikbare studenten staan in <span class=\"beschikbaar\">deze kleur</span>, reeds ingeschreven studenten hebben <span class=\"onbeschikbaar\">deze kleur</span>.</div>\n";
				echo "<div class=\"geel\">Deadline: ".date("D d M Y, H:i",getDeadline($pracId))."</div>";
				echo '<div id="regular_students">'."\n";
				
					$students=getCandidateGroupMembers($pracId,$studId,0);
					echo '<h1>Aantal studenten: '.count($students)."</h1>\n";
					
					//checken of student die inlogt, al in een groep zit
					//$allesOk=(nrOfGroups($pracId,$studId)==0);
					$allesOk=getDeadline($pracId)>time();
					if($allesOk){
						$min=getMinStudent($pracId);
						$max=getMaxStudent($pracId);
						$minToChoose=$min-1;//-1 want ingelogde student is automatisch aangevinkt
						$maxToChoose=$max-1;//-1 want ingelogde student is automatisch aangevinkt
						echo "<div class=\"geel\">Voor dit practicum bestaat je groep uit minimaal $min en maximaal $max studenten.";
						echo "Je moet nog minstens $minToChoose en maximaal $maxToChoose vakjes aanvinken!</div>";
						//nog niet in groep dus form laten zien
						echo "<form id=\"studenten\" action=\"".$_SERVER["PHP_SELF"]."\" method=\"get\">\n";
						echo "<div>\n";
						foreach($students as $id=>$name){
							$groepen=nrOfGroups($pracId,$id);
							//echo "$groepen groepen voor $name<br/>";
							$checkboxCode="<input type=\"checkbox\" name=\"selectedIds[]\" value=\"$id\"";
							$class="beschikbaar";
							if($groepen>0){
								$class="onbeschikbaar";
								$checkboxCode=$checkboxCode." disabled=\"disabled\" ";
							}
							if($id==$studId){
								//de ingelogde student gevonden
								//deze automatisch op checked zetten
								//en op disabled
								$checkboxCode.=" checked disabled=\"disabled\" ";
							}
							
							$checkboxCode=$checkboxCode." /><span class=\"$class\">$name</span><br />\n";
							echo  $checkboxCode;
							
							
						}
						echo '<input type="submit" name="submit" value="submit"/>';
						echo '<b>gelieve maar 1 keer op de submit knop te drukken!!</b>';
						echo "<input type=\"hidden\" name=\"pracId\" value=\"$pracId\"/>";
						echo "<input type=\"hidden\" name=\"studId\" value=\"$studId\"/>";
						echo "<input type=\"hidden\" name=\"changed\" value=\"1\"/>";
						echo "</div>\n";
						echo "</form>\n";
					}
					else{
						echo "<div class=\"geel\">je bent al ingeschreven en je kan dus geen groep meer  vormen of de deadline is gepasseerd.</div>";
					}
				
				echo"</div><!--regular students-->\n";
			}
		?>
		
	    </div>
    </div><!--user_data-->
    
	


</div><!--container-->	



	
</body>
</html>
