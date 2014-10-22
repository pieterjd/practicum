<html>
<head>
</head>
<body>
<?php
	
function writePreamble(){
	echo('\documentclass[10pt]{article}<br>');
	echo('\begin{document}<br>');
}
function writeClosingStuff(){
	//echo('\documentclass[10pt]{article}');
	echo('\end{document}<br><br><br>');
}
function putInBox($text){
	return "\\noindent\n\\framebox{\n\\begin{minipage}{\\textwidth}\n$text\n\\end{minipage}}<br>";
}

function addBr($text){
	return $text.'<br/>';
}
function makeQuestions($pracid,$dynamic){
	$result="";
	if($dynamic==1){
		
		$questionQuery="select question,prac_vraagtype.description from prac_vragen,prac_vragen_prac,prac_vraagtype where prac_vragen_prac.pracid=$pracid and  vraagid=prac_vragen.id and prac_vraagtype.id=prac_vragen.typeid order by prac_vraagtype.id,prac_vragen.id";
		//echo $questionQuery;
		//echo $questionQuery;
		$qresult=mysql_query($questionQuery);
		$result="\\section*{Vragen}<br>\\begin{itemize}<br>";
		while($row=mysql_fetch_array($qresult)){
			$result=$result."\\item[$\\bigcirc$]$row[1]: $row[0]<br>";
		}
		$result=$result."\\end{itemize}<br>";
		if($pracid == 26 or $pracid == 29 or $pracid==30 or $pracid==33){//processing inf2
			//echo "calling processing page";
			$result = $result.getProcessingPage($pracid);
		}
		else{
			$result=$result.putInBox('Opmerkingen en score op 20:\\\\Implementatie(5);Kwaliteit(4);Design(8);Uitleg(3).\vspace{1.3in}');
		}
	}
	else{
		/* vragenblad MI tot en met 2011-2012
		$result=addBr('\begin{center}');
		$result=$result.addBr('\begin{tabular}{|l|r|}');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\textbf{Implementatie van de gevraagde functionaliteit} (3 pt.) &\hspace{0.2in} /3 \\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr(' Alles geimplementeerd en werkt perfect: 3/3&\\\\');
		$result=$result.addBr('\cline{1-1}');
		$result=$result.addBr('kleine problemen of een enkele feature niet geimplementeerd: 1/3&\\\\');
		$result=$result.addBr(' \cline{1-1}');
		$result=$result.addBr('teveel problemen, applicatie crasht, belangrijke zaken niet geimplementeerd: 0/3&\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\textbf{Kwaliteit van code, elke categorie max 1 punt} (4 pt.) &  /4 \\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('o Namen van variabelen en methoden, java conventie&\\\\');
		$result=$result.addBr('o Duidelijkheid code (documentatie,self-documenting code...)&\\\\');
		$result=$result.addBr('o indentatie, algemene leesbaarheid, grotte van methodes&\\\\');
		$result=$result.addBr('o locale variabelen vs. velden, onnodige velden en variabelen&\\\\');
	
		
		$result=$result.addBr('\hline');
		$result=$result.addBr('\textbf{Design}  & /10 \\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('Basis 6pt&\\\\');
		$result=$result.addBr('o Encapsulatie, gebruik modifiers (private,...) 2pt.&\\\\');
		$result=$result.addBr('o Cohesion \\& coupling: encapsulatie, velden = eigenschappen van object, juiste\\\\granulariteit van gegevens, plaatsen functionaliteit in juiste klassen  3pt.&\\\\');
		$result=$result.addBr('o Geen klasse a la "Berekeningen" etc., statische velden en methodes\\\\die onnodig zijn (1 strafpunt = dus -1 punt) &\\\\');
		$result=$result.addBr('Overerving 4pt&\\\\');
		$result=$result.addBr('o Enkel overerving bij is-a relatie&\\\\');
		$result=$result.addBr('o Gebruik polymorfisme en dynamische binding&\\\\');
		$result=$result.addBr('o geen gebruik van getType(), instanceof ed.&\\\\');
		$result=$result.addBr('o Juist gebruik abstracte klassen/methodes&\\\\');
		$result=$result.addBr('o Indien geen overerving: argumentatie?&\\\\');
		
		$result=$result.addBr('\hline');
		$result=$result.addBr('\textbf{Uitleg student} (3 pt.) & /3\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('o Kwaliteit uitleg&\\\\');
		$result=$result.addBr('o Kwaliteit verslag&\\\\');
		$result=$result.addBr('o Inzicht in aspecten van OO&\\\\');
		$result=$result.addBr('o aandeel in hoeveelheid werk (tussen -1 en +1 pt)&\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\textbf{Totale score}:& /20\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\end{tabular}');
		$result=$result.addBr('\end{center}');
		*/
		/*
		vragenblad MI testpracticum 2012-2013
		$result=addBr('\begin{center}');
		$result=$result.addBr('\begin{tabular}{|l|r|}');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\textbf{Gebruik van hulpfuncties} (2 pt.) &\hspace{0.2in} /2 \\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('Hoofdfunctie optimaal opgesplitst in kleinere hulpfuncties: 2/2&\\\\');
		$result=$result.addBr('\cline{1-1}');
		$result=$result.addBr('Gebruik van hulpfuncties, maar niet optimaal: 1/2&\\\\');
		$result=$result.addBr('\cline{1-1}');
		$result=$result.addBr('1 grote functie: 0/2&\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\textbf{Implementatie van de gevraagde functionaliteit} (2 pt.) &\hspace{0.2in} /2 \\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('Alles geimplementeerd, werkt perfect: 2/2&\\\\');
		$result=$result.addBr('\cline{1-1}');
		$result=$result.addBr('kleine problemen of een enkele feature niet geimplementeerd. : 1/2&\\\\');
		$result=$result.addBr('\cline{1-1}');
		$result=$result.addBr('teveel problemen, applicatie crasht, belangrijke zaken niet geimplementeerd: 0/2&\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\textbf{Kwaliteit van code, elke categorie max 1 punt} (3 pt.) & /3 \\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('o Namen van variabelen en functies, python conventie&\\\\');
		$result=$result.addBr('o Duidelijkheid code (documentatie,self-documenting code...)&\\\\');
		$result=$result.addBr('o locale vs. globale variabelen, onnodige (globale) variabelen&\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\textbf{Correctheid}  (maximaal helft van de punten indien niet formeel met asserts)& /8\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\emph{Specificatie 4pt}&\\\\');
		$result=$result.addBr('o postconditie volledig en correct 1pt.&\\\\');
		$result=$result.addBr('o precondities volledig en correct 1pt.&\\\\');
		$result=$result.addBr('o lusinvariant volledig en correct 2pt.&\\\\');
		$result=$result.addBr('\emph{Correctheidsbewijs 4pt}&\\\\');
		$result=$result.addBr('o initializatie 1pt.&\\\\');
		$result=$result.addBr('o body 1pt.&\\\\');
		$result=$result.addBr('o epiloog 1pt.&\\\\');
		$result=$result.addBr('o eindigheid 1pt.&\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\textbf{Testen} (1 pt.) & /1\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('o Full-coverage incl. randgevallen 1/1&\\\\');
		$result=$result.addBr('o Geen testen/ enkel triviale gevallen getest 0/1&\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\textbf{Uitbreidbaarheid} (1 pt.) & /1\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('o Goed gebruik van constanten, parameters, en globale variabelen 1/1&\\\\');
		$result=$result.addBr('o In de code gewerkt met specifieke getallen 0/1&\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\textbf{Effici\"entie} (1 pt.) & /1\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('o Slimme, effici\"ente oplossing 1/1&\\\\');
		$result=$result.addBr('o Complexe of minder effici\"ente oplossing  0/1&\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\textbf{Uitleg student} (2 pt.) & /2\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('o Kwaliteit uitleg&\\\\');
		$result=$result.addBr('o Kwaliteit verslag&\\\\');
		$result=$result.addBr('o aandeel in hoeveelheid werk (tussen -1 en +1 pt)&\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\textbf{Totale score}:& /20\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\end{tabular}');
		$result=$result.addBr('\end{center}');
		*/
		/*MI 2012-2013 Examenpracticum*/
		//echo "MI Examen";
		/*
		$result=addBr('\begin{center}');
		$result=$result.addBr('\begin{tabular}{|l|r|}');
		$result=$result.addBr('');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\textbf{Implementatie van de gevraagde functionaliteit} (5 pt.)  - Omcirkel&\hspace{0.2in} /5 \\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('');
		$result=$result.addBr('\begin{tabular}{l|c|c}');
		$result=$result.addBr('&deel 1&deel2\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('o Alles geimplementeerd, werkt perfect&3/3&2/2\\\\');
		$result=$result.addBr('o Alles geimplementeerd, 1 randgeval werkt niet& 2/3&-\\\\');
		$result=$result.addBr('o Alles geimplementeerd maar een paar fouten bij testen&1/3&1/2\\\\');
		$result=$result.addBr('o Niet alles geimplementeerd en/of veel fouten bij testen&0/3&0/2\\\\');
		$result=$result.addBr('\end{tabular}');
		$result=$result.addBr('&\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\textbf{Kwaliteit} (5 pt.) & /5 \\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\emph{kwaliteit van code (2pt.), elke categorie max 1 punt}&\\\\');
		$result=$result.addBr('o Duidelijkheid code (naamgeving, python conventie, documentatie,...)&\\\\');
		$result=$result.addBr('o locale vs. globale variabelen, onnodige (globale) variabelen&\\\\');
		$result=$result.addBr('');
		$result=$result.addBr('\emph{Gebruik van hulpfuncties (1 pt.)}&\\\\');
		$result=$result.addBr('o Hoofdfunctie optimaal opgesplitst in kleinere hulpfuncties: 1/1&\\\\');
		$result=$result.addBr('o Gebruik van hulpfuncties, maar niet optimaal: 0.5/1&\\\\');
		$result=$result.addBr('o 1 grote functie: 0/1&\\\\');
		$result=$result.addBr('');
		$result=$result.addBr('\emph{Kwaliteit van recursie (2 pt.)}&\\\\');
		$result=$result.addBr('o Minstens 1 hulpfunctie voor get$\_$optimal$\_$path moet recursief zijn uitgewerkt&\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\textbf{Correctheid en complexiteit}  & /7\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\emph{Specificatie (3pt) - max. helft indien niet formeel met asserts}&\\\\');
		$result=$result.addBr('o postconditie volledig en correct (get$\_$optimal$\_$path + get$\_$all$\_$dirty$\_$areas) 1pt.&\\\\');
		$result=$result.addBr('o precondities volledig en correct (get$\_$optimal$\_$path + get$\_$all$\_$dirty$\_$areas) 1pt.&\\\\');
		$result=$result.addBr('o lusinvariant volledig en correct (get$\_$all$\_$dirty$\_$areas) 1pt.&\\\\');
		$result=$result.addBr('');
		$result=$result.addBr('\emph{Correctheidsbewijs (3pt) - max. helft indien niet formeel met asserts}&\\\\');
		$result=$result.addBr('');
		$result=$result.addBr('o initializatie (1pt.), body (1pt.), epiloog (1pt.) (get$\_$all$\_$dirty$\_$areas)&\\\\');
		$result=$result.addBr('');
		$result=$result.addBr('\emph{Complexiteit (1pt) - get$\_$optimal$\_$path }&\\\\');
		$result=$result.addBr('o Juiste complexiteit en redenering 1/1&\\\\');
		$result=$result.addBr('o Foute complexiteit en/of foute of ontbrekende redenering 0/1&\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\textbf{OO-concepten} (3 pt.) & /3\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('o \emph{Ontwerp (1 pt)}: meer dan 1 klasse, goede opdeling, &\\\\koppeling (bv. klasse Position moet geen link naar Board of Robot hebben), ... &\\\\');
		$result=$result.addBr('o \emph{Attributen en constructor (1 pt)}: naamgeving volgens Python-conventies &\\\\ ($\_\_$attribuut), definitie van nodige getters en setters,');
		$result=$result.addBr('correcte initialisatie van &\\\\ attributen, gebruik van default waarden voor argumenten waar mogelijk&\\\\');
		$result=$result.addBr('o \emph{Methodes (1 pt)}: correcte uitwerking met o.a. self argument, correcte oproep met &\\\\objectgerichte notatie (object.method(x,y,z))');
		$result=$result.addBr(' correct gebruik van hidden methodes &\\\\zoals $\_\_$str$\_\_$, en eventueel andere methodes ($\_\_$eq$\_\_$?)&\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\textbf{Uitleg student} (tussen -1 en +1pt. indien nodig  - standaard 0) & \\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('o Kwaliteit uitleg, aandeel in hoeveelheid werk&\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\textbf{Totale score}:& /20\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\end{tabular}');
		$result=$result.addBr('\end{center}');
		*/
		//MI 201-2014
		$result=addBr('\small{DISCLAIMER: Het belangrijkste bij de verbetering zijn de punten per blok, en niet de individuele verdeling voor elk apart onderdeeltje binnen een blok.}');
		$result=$result.addBr('\begin{center}');
		$result=$result.addBr('\begin{tabular}{|l|rr|}');
		$result=$result.addBr('');
		$result=$result.addBr('');
		$result=$result.addBr('\multicolumn{1}{c}{\textbf{FUNCTIONALITEIT}} & \multicolumn{2}{r}{\textbf{/10}}\\\\');
		$result=$result.addBr('%\textbf{Implementatie van de gevraagde functionaliteit} (10 pt.) &\hspace{0.2in} /10 \\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\emph{Punten gegenereerd door testen}&& \\\\');
		$result=$result.addBr('');
		$result=$result.addBr('\hline');
		$result=$result.addBr('');
		$result=$result.addBr('\multicolumn{2}{c}{\textbf{PROJECT}} & \multicolumn{1}{r}{\textbf{/20}}\\\\');
		$result=$result.addBr('');
		$result=$result.addBr('');
		$result=$result.addBr('\hline');
		$result=$result.addBr('');
		$result=$result.addBr('\textbf{Kwaliteit}  & /8& \\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\emph{kwaliteit van fill$\_$intelligently (5pt.)}&&\\\\');
		$result=$result.addBr('o bevat oproep voor en correcte code van naked single (1pt)&&\\\\');
		$result=$result.addBr('o bevat oproep voor en correcte code van hidden single (1pt)&&\\\\');
		$result=$result.addBr('o bevat oproep voor en correcte code van en minste kandidaten (1pt)&&\\\\');
		$result=$result.addBr('o correct recursief (niet enkel kleine recursieve hulpfunctie) &&\\\\');
		$result=$result.addBr('(+ ongedaan maken foute keuze) (2pt)&&\\\\');
		$result=$result.addBr('');
		$result=$result.addBr('\emph{kwaliteit van nb$\_$solutions (3pt.), elke categorie max 1 punt}&&\\\\');
		$result=$result.addBr('o correct recursief (niet enkel kleine recursieve hulpfunctie)&&\\\\');
		$result=$result.addBr('o slim zoeken (enkel kijken naar mogelijke kandidaten)&&\\\\');
		$result=$result.addBr('o correct basisgeval &&\\\\');
		$result=$result.addBr('');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\textbf{Invarianten}: volledig en correct & /4&\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('o make$\_$roster$\_$positionally (2pt.)&&\\\\');
		$result=$result.addBr('o nb$\_$solutions  (2pt.)&&\\\\');
		$result=$result.addBr('');
		$result=$result.addBr('');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\textbf{List Comprehension} & /1& \\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('o kwaliteit van group$\_$positions &&\\\\');
		$result=$result.addBr('');
		$result=$result.addBr('');
		$result=$result.addBr('');
		$result=$result.addBr('');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\textbf{Complexiteit} - geen redenering = 0 pt  & /3&\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\emph{is$\_$correct$\_$sequence (1.5 pt)}  &&\\\\');
		$result=$result.addBr('o best case (T(N) = 1 of T(N) = N afhankelijk van case) 0.5pt.&&\\\\');
		$result=$result.addBr('o worst case (T(N) = ${N}^2$) 1pt.&&\\\\');
		$result=$result.addBr('\emph{is$\_$correct$\_$roster (1.5 pt)} &&\\\\ ');
		$result=$result.addBr('o best case (T(N) = ${N}^2$) 0.5pt.&&\\\\');
		$result=$result.addBr('o worst case (T(N) = $3{N}^4$) 1pt.&&\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\textbf{Extras (16+)} Enkel als rest van code aanvaardbaar is & /4& \\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('o Slimme implementatie van candidates$\_$at &&\\\\');
		$result=$result.addBr('');
		$result=$result.addBr('\hline');
		$result=$result.addBr('\textbf{Minpunten}   & &\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('o Geen/ onvoldoende gebruik van hulpfuncties (tot - 1pt)&&\\\\');
		$result=$result.addBr('o Code duplicatie (tot - 2pt)&&\\\\');
		$result=$result.addBr('o Onduidelijke code (naamgeving, Python conventies, documentatie, ...)&&\\\\(tot - 2pt)&&\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('');
		$result=$result.addBr('');
		$result=$result.addBr('\multicolumn{2}{c}{\textbf{KWALITEIT VERDEDIGING}}  & \multicolumn{1}{r}{\textbf{/10}}\\\\');
		$result=$result.addBr('');
		$result=$result.addBr('\hline');
		$result=$result.addBr('o max 8pt indien geen correcte oplossing voor het 16+ deel &&\\\\');
		$result=$result.addBr('o licht toe indien $<$ 5pt &&\\\\');
		$result=$result.addBr('\hline');
		$result=$result.addBr('');
		$result=$result.addBr('\multicolumn{1}{c}{\textbf{TOTALE SCORE}}&&');
		$result=$result.addBr('\multicolumn{1}{r}{\textbf{/40}}\\\\');
		$result=$result.addBr('');
		$result=$result.addBr('\end{tabular}');
		$result=$result.addBr('\end{center}');
		
	}
	return $result;
}
function maakVragenblad($pracid,$ondervrager,$group,$date,$genType,$individueel,$genCodePage=1,$aftekenGen=1){
	
	//connect($db_host,$database,$user,$paswoord);
	//pracinfo
	$pracQuery="select prac_practicum.name,prac_richting.name,year from prac_practicum,prac_richting where prac_practicum.id=$pracid and prac_practicum.richtingid=prac_richting.id";
	//echo $pracQuery;
	$pracResult=mysql_query($pracQuery);
	$row=mysql_fetch_array($pracResult);
	$pracString='\textbf{Practicum}: '."$row[0] ($row[1], $row[2])\\\\<br>";
	if($individueel){
		//aftekenbladgenereren
		if($aftekenGen){
			echo generateConfirmationPage($pracid,$group,$date);
		}
		//vragenblad per student
		$studQuery="select naam,voornaam,groep,reeks,nummer,prac_student.id as studId,snummer from prac_student,prac_groep,prac_groep_stud where prac_groep.nummer=$group and prac_groep.pracid=$pracid and prac_groep_stud.studid=prac_student.id and prac_groep_stud.groepid=prac_groep.id";
		//echo $studQuery.'<br>';
		$studResult=mysql_query($studQuery);
		//echo(mysql_error());
		
		
		while($studRow=mysql_fetch_array($studResult)){
			$studString=addBr('\textbf{Naam student}: '.$studRow['naam'].' '.$studRow['voornaam'].' ('.$studRow['snummer'].')\\\\');
			$groepId=getGroepId($pracid,$studRow['studId']);
			$ledenString='\textbf{Andere groepsleden}: ';
			$leden=getAllMembers($groepId);
			foreach($leden as $stud=>$name){
				if($stud!=$studRow['studId']){
					$ledenString.="$name ";
				}
			}
			$ledenString=addBr($ledenString.'\\\\');
			
		
			$interString="\\textbf{Verbeterd door:} $ondervrager\\\\ \\textbf{Datum: }".date('D d M Y',$date)."\\\\<br>";
			//commentaar opvragen
			//eerst groepid opzoeken
			$groepIdQuery="select id from prac_groep where pracid=$pracid and nummer=$group";
			$groepIdResult=mysql_query($groepIdQuery);
			$groepIdRow=mysql_fetch_array($groepIdResult);
			$groepId=$groepIdRow[0];
			//nu opmerking ophalen
			$commentQuery="select opmerking from prac_opmerking where groepid=$groepId";
			$commentResult=mysql_query($commentQuery);
			$comments='';
			if(mysql_num_rows($commentResult)==0){
				$comments='-';
			}
			else{		
				$commentRow=mysql_fetch_array($commentResult);
				$comments=$commentRow[0];
			}
			$commentString="\\textbf{Commentaar: }$comments<br>";
			echo putInBox($pracString.$studString.$ledenString.$interString.$commentString);
			echo makeQuestions($pracid,$genType);
			//echo putInBox("Opmerkingen en score op 20:\\ \\vspace{1.5in}");
			echo '\newpage<br>';
			
			if($genCodePage){
				echo generateCodePage($pracid,$studRow['studId'],$date);
			}
			
		}
		
		
	}
	else{
		//vragenblad per groep
		$studQuery="select naam,voornaam,groep,reeks,nummer,snummer from prac_student,prac_groep,prac_groep_stud where prac_groep.nummer=$group and prac_groep.pracid=$pracid and prac_groep_stud.studid=prac_student.id and prac_groep_stud.groepid=prac_groep.id";
		//echo $studQuery.'<br>';
		$studResult=mysql_query($studQuery);
		//echo(mysql_error());
		$studString="\\textbf{groep $group}: ";
		
		while($studRow=mysql_fetch_array($studResult)){
			$studString=$studString. "$studRow[0] $studRow[1] ($studRow[5]) ";
			//$comments=$studRow[4];
		}
		$studString=$studString." \\\\<br>";
		
		$interString="\\textbf{Verbeterd door:} $ondervrager\\\\ \\textbf{Datum: }".date('D d M Y',$date)."\\\\<br>";
		//commentaar opvragen
		//eerst groepid opzoeken
		$groepIdQuery="select id from prac_groep where pracid=$pracid and nummer=$group";
		$groepIdResult=mysql_query($groepIdQuery);
		$groepIdRow=mysql_fetch_array($groepIdResult);
		$groepId=$groepIdRow[0];
		//nu opmerking ophalen
		$commentQuery="select opmerking from prac_opmerking where groepid=$groepId";
		$commentResult=mysql_query($commentQuery);
		$comments='';
		if(mysql_num_rows($commentResult)==0){
			$comments='-';
		}
		else{		
			$commentRow=mysql_fetch_array($commentResult);
			$comments=$commentRow[0];
		}
		$commentString="\\textbf{Commentaar: }$comments<br>";
		echo putInBox($pracString.$studString.$interString.$commentString);
		echo makeQuestions($pracid,$genType);
		//echo putInBox("Opmerkingen en score op 20:\\ \\vspace{1.5in}");
		echo '\newpage<br>';
		
		//aftekenbladgenereren
		if($aftekenGen){
			echo generateConfirmationPage($pracid,$group,$date);
		}
		//checken of er pagina voor schriftelijke codevraag nodig is
		if($genCodePage){
			//per student een pagina genereren
			$studQuery="select naam,voornaam,groep,reeks,nummer,prac_student.id as studId,snummer from prac_student,prac_groep,prac_groep_stud where prac_groep.nummer=$group and prac_groep.pracid=$pracid and prac_groep_stud.studid=prac_student.id and prac_groep_stud.groepid=prac_groep.id";
			//echo $studQuery.'<br>';
			$studResult=mysql_query($studQuery);
			//echo(mysql_error());
			while($studRow=mysql_fetch_array($studResult)){
				echo generateCodePage($pracid,$studRow['studId'],$date);
			}
		}
		
		
	}
}
//voor informatica 2 & MI moet student een stuk code schrijven; het blad waarop dit neergepend wordt, wordt met volgende functie aangemaakt
function generateCodePage($pracId,$studId,$date){
	$pracQuery="select prac_practicum.name,prac_richting.name,year from prac_practicum,prac_richting where prac_practicum.id=$pracId and prac_practicum.richtingid=prac_richting.id";
	//echo $pracQuery;
	$pracResult=mysql_query($pracQuery);
	$row=mysql_fetch_array($pracResult);
	$pracString='\textbf{Practicum}: '."$row[0] ($row[1], $row[2]) - Codeervraag\\\\<br>";
	
	$dateString="\\textbf{Datum: }".date('D d M Y',$date).'\\\\<br/>';
	$studInfo=getStudentInfo($studId);
	$studString=$studString.'\textbf{Naam student}: '.$studInfo['naam'].' '.$studInfo['voornaam'].' - '.$studInfo['snummer'];
	
	$latex=putInBox($pracString.$studString.$dateString);
	$latex=$latex.putInBox('Schriftelijke vraag\\vspace{6.5in}');
	$latex=$latex.'\newpage<br/>';
	return $latex;
	
}

/**
maakt een pagina waarop student moet aftekenen dat hij aanwezig was. Wordt in tweevoud getekend, zodat student zijn exemplaar kan meenemen.

*/
function generateConfirmationPage($pracId,$group,$date){
	$studQuery="select naam,voornaam,snummer from prac_student,prac_groep,prac_groep_stud where prac_groep.nummer=$group and prac_groep.pracid=$pracId and prac_groep_stud.studid=prac_student.id and prac_groep_stud.groepid=prac_groep.id";
	//echo $studQuery.'<br>';
	$studResult=mysql_query($studQuery);
	
	
	$latexStud="";
	$latexAss="";
	
	while($studRow=mysql_fetch_array($studResult)){
		//$studInfo=getStudentInfo($studRow[0]);
		$studName="$studRow[0] $studRow[1] ($studRow[2])";
		//echo "studname is $studName<br/>";
		$latexStud.=generateConfirmationPageFragment($pracId,$studName,$date,1);
		$latexAss.=generateConfirmationPageFragment($pracId,$studName,$date,0);
		
		
	}
	
	$lijnLatex='\begin{center}\line(1,0){250}\end{center}';
	$newPage='\newpage<br/>';
	return ($latexStud.$newPage.$latexAss.$newPage);
}
function generateConfirmationPageFragment($pracId,$studName,$date,$studentVersie=0){
	
	$pracQuery="select prac_practicum.name,prac_richting.name,year from prac_practicum,prac_richting where prac_practicum.id=$pracId and prac_practicum.richtingid=prac_richting.id";
	
	$pracResult=mysql_query($pracQuery);
	$row=mysql_fetch_array($pracResult);
	//richting en jaar ($row[1], $row[2])
	$pracString='\begin{center}\textbf{'."$row[0]  - Bewijs van evaluatie -  ";
	if($studentVersie==1){
		$pracString.='student';
	}
	else{
		$pracString.='ondervrager';
	}
	$pracString.='}\end{center}<br/>';
	
	
	$latex=$pracString;
	$latex.=$studName.' verklaart het practicum te hebben verdedigd op '.date('D d M Y',$date).' en kennis te hebben genomen van artikel 42 van het examenreglement over de sancties op het begaan van onregelmatigheden.<br/>';
	//$latex.= '\begin{itemize}<br/>\item hij/zij het practicum verdedigd heeft op '.date('D d M Y',$date).'<br/>\item dat hij/zij het examenreglement en de gedragscode nageleefd heeft<br/>\end{itemize}<br/>';
	$handtekening='\begin{center}<br/>\begin{tabular}{cc}<br/>Handtekening Assistent&Handtekening Student\\\\<br/>&\\\\<br/>&\\\\<br/> \hline<br/>\end{tabular}<br/>\end{center}';
	$latex.='\\vspace{1in}<br/>';
	$latex.=$handtekening;
	$latex.='\\vspace{1in}<br/>';
	
	
	//$latex=$latex.'\newpage<br/>';
	return $latex;
	
}

function generatePages($pracid,$ondervrager,$groepen,$date,$genType,$individueel,$codeGen,$aftekenGen){
	//$file=fopen("$filename.tex",'w');
	writePreamble($file);
	//groepen separeren
	$groups=explode(",",$groepen);
	//if($genType==0){
		for($groep=reset($groups);$groep;$groep=next($groups)){
			maakVragenblad($pracid,$ondervrager,$groep,$date,$genType,$individueel,$codeGen,$aftekenGen);
			
			
		}
	//}
	//else{
		//generatePagesInf2($pracid);
		
	//}
	
	writeClosingStuff();
	
}
//inf 2 2012-2013: voor processing van informatica 2
function getProcessingPage($pracId){
	$result=addBr('\begin{center}');
	$result=$result.addBr('\begin{tabular}{|l|r|}');
	$result=$result.addBr('\hline');
	$result=$result.addBr('\textbf{Implementatie van de gevraagde functionaliteit} (3 pt.) &\hspace{0.2in} /3 \\\\');
	$result=$result.addBr('\hline');
	$result=$result.addBr(' Alles geimplementeerd en werkt perfect: 3/3&\\\\');
	$result=$result.addBr('\cline{1-1}');
	$result=$result.addBr('kleine problemen of parametrisaties te eenvoudig : 1/3&\\\\');
	$result=$result.addBr(' \cline{1-1}');
	$result=$result.addBr('teveel problemen, applicatie crasht, belangrijke zaken niet geimplementeerd: 0/3&\\\\');
	$result=$result.addBr('\hline');
	$result=$result.addBr('\textbf{Kwaliteit van code, elke categorie max 1 punt} (4 pt.) &  /4 \\\\');
	$result=$result.addBr('\hline');
	$result=$result.addBr('o Namen van variabelen en methoden, java conventie&\\\\');
	$result=$result.addBr('o Duidelijkheid code (documentatie,self-documenting code...)&\\\\');
	$result=$result.addBr('o indentatie, algemene leesbaarheid, grotte van methodes&\\\\');
	$result=$result.addBr('o locale variabelen vs. velden, onnodige velden en variabelen&\\\\');

	
	$result=$result.addBr('\hline');
	$result=$result.addBr('\textbf{Design}  & /10 \\\\');
	$result=$result.addBr('\hline');
	$result=$result.addBr('Basis 6pt&\\\\');
	$result=$result.addBr('o Encapsulatie, gebruik modifiers (private,...) 2pt.&\\\\');
	$result=$result.addBr('o Cohesion \\& coupling: encapsulatie, velden = eigenschappen van object, juiste\\\\granulariteit van gegevens, plaatsen functionaliteit in juiste klassen  3pt.&\\\\');
	$result=$result.addBr('o Geen klasse a la "Berekeningen" etc., statische velden en methodes\\\\die onnodig zijn (1 strafpunt = dus -1 punt) &\\\\');
	$result=$result.addBr('Overerving 4pt&\\\\');
	$result=$result.addBr('o Enkel overerving bij is-a relatie&\\\\');
	$result=$result.addBr('o Gebruik polymorfisme en dynamische binding&\\\\');
	$result=$result.addBr('o geen gebruik van getType(), instanceof ed.&\\\\');
	$result=$result.addBr('o Juist gebruik abstracte klassen/methodes&\\\\');
	$result=$result.addBr('o Theoretische vraag hierboven (vink aan)&\\\\');
	$result=$result.addBr('o Indien geen overerving: argumentatie?&\\\\');
	
	$result=$result.addBr('\hline');
	$result=$result.addBr('\textbf{Uitleg student} (3 pt.) & /3\\\\');
	$result=$result.addBr('\hline');
	$result=$result.addBr('o Kwaliteit uitleg&\\\\');
	$result=$result.addBr('o Kwaliteit verslag&\\\\');
	$result=$result.addBr('o Inzicht in aspecten van OO&\\\\');
	$result=$result.addBr('o aandeel in hoeveelheid werk (tussen -1 en +1 pt)&\\\\');
	$result=$result.addBr('\hline');
	$result=$result.addBr('\hline');
	$result=$result.addBr('\textbf{Totale score}:& /20\\\\');
	$result=$result.addBr('\hline');
	$result=$result.addBr('\end{tabular}');
	$result=$result.addBr('\end{center}');
	return $result;
}
//dit is enkel voor informatica 2
function generatePagesInf2($pracId){
	$ondervragers=getOndervragers($pracId);
	//print_r($ondervragers);
	foreach($ondervragers as $index=>$ass){
		$ondervragingen=getOndervragingen($pracId,$ass['id']);
		//print_r($ondervragingen);
		$ondervragerString=addBr('\textbf{Ondervrager}: '.$ass['voornaam'].' '.$ass['naam'].'\\\\');
		foreach($ondervragingen as $j=>$onder){
			$pracString=addBr('\textbf{Practicum}: '.getPracTitle($pracId).'\\\\');
			$studId=$onder['studentid'];
			$studInfo=getStudentInfo($studId);
			$studString=addBr('\textbf{Naam student}: '.$studInfo['naam'].' '.$studInfo['voornaam'].' ('.$studInfo['groep'].$studInfo['reeks'].')\\\\');
			$groepId=getGroepId($pracId,$studId);
			$ledenString='\textbf{Andere groepsleden}: ';
			$leden=getAllMembers($groepId);
			foreach($leden as $stud=>$name){
				if($stud!=$studId){
					$ledenString.="$name ";
				}
			}
			$ledenString=addBr($ledenString.'\\\\');
			$tijdstip=$onder['tijdstip'];
			$frmtDate=date('D d M Y H:i',$tijdstip);
			$tijdString=addBr('\textbf{Datum}: '.$frmtDate.'\\\\');
			echo putInBox($pracString.$ondervragerString.$tijdString.$studString.$ledenString);
			echo makeQuestions($pracId,1);
			//echo putInBox("Opmerkingen en score op 20:\\ \\vspace{1.5in}");
			echo '\newpage<br/>';
		}
		
	}
}


	include_once('../../daos/dbConnect.php');
	include_once('../../daos/pracDao.php');
	include_once('../../daos/ondervragingDao.php');
	include_once('../../daos/groepDao.php');
	include_once('../../daos/studentDao.php');
	connect();
	
	//connect($db_host,$database,$user,$paswoord);
	//connect($db_host,$database,$user,$paswoord);
	$pracId=$_GET['pracId'];
	$ondervrager=$_GET['ondervrager'];
	$groepen=$_GET['groepen'];//groepen gescheiden door kommas
	$datum=$_GET['datum'];
	$genType=$_GET['genType'];
	//extra codepagina nodig
	$codeGen=$_GET['codeGen'];
	//extra aftekenblad nodig
	$aftekenGen=$_GET['aftekenGen'];
	/*
	foreach($_GET as $key=>$value){
		echo "$key: $value//";
	}
	*/
	//checken of studenten individueel ondervraagd worden
	$query="select ondervraagtypeid from prac_practicum where id=$pracId";
	$result=mysql_query($query);
	$row=mysql_fetch_array($result);
	$individueel=($row[0]==1);
	///echo '<textarea rows="100" cols="50">';
	//echo "codegen is $codeGen";
	generatePages($pracId,$ondervrager,$groepen,strtotime($datum),$genType,$individueel,$codeGen,$aftekenGen);
	//echo '</textarea>';
?>
</body>
</html>