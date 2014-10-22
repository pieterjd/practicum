#dit script mag pas uitgevoerd worden nadat inzendingen uitgepakt werden met het andere powershell script en VOOR het groepsnummer toegevoegd werd
#dit script haalt het s-nummer uit de folder naam en maakt de bijhorende sql-udate  aan die dan in een file geschreven worden $outFile="c:\temp\201003-mi-galliers.txt"
###PRAC ID !!!!!!!!!!!!!
$pracId=33
###UPDATE: submitted is nu 'percentage completed'. Voor MI 2012-2013 gebeuren inzendingen in 2 delen. Enkel groepen met 100% submission worden ondervraagd.
## pas submission_Increment aan
###SUBMISSION INCREMENT !!!!!!!!!!!!!
$sub_inc = 1
#om duplicate inzendingen te vermijden, worden enkel de submission levels van de groepen veranderen waarvan de huidige waarde gelijk is aan prev_value
#bv bij verwerking van 1e deel van examen: studenten hebben nog niets ingediend, dus enkel de groepen aanpassen waarvan de vorige waarde nul is
#bv bij verwerking van 2e deel van examen: studenten hebben die 1e deel ingediend hebben, dus enkel de groepen aanpassen waarvan de vorige waarde 0.5 is
$prev_value = 0
#folder moet eindigen op \
$folder='C:\temp\2013-2014-inf2-september\'
$outFile=$folder+"201408-inf2.txt"
function Get-Query([int]$pracId,[String]$qnummer,[decimal] $sub_inc,$prev_value){
    return "update prac_groep,prac_student,prac_groep_stud set submitted=submitted+$sub_inc where prac_student.qnummer='$qnummer' and  prac_groep_stud.studid=prac_student.id and prac_groep.id=prac_groep_stud.groepid and prac_groep.pracid=$pracId and prac_groep.submitted=$prev_value;"
    
}
#$s=Get-ChildItem -Path $folder *.zip |select name
$s = Get-ChildItem -Path $folder | ?{$_.PSIsContainer} | select name
#"update prac_groep,prac_student,prac_groep_stud set submitted=1 where prac_student.snummer='$matches[0]' and  prac_groep_stud.studid=prac_student.id and prac_groep.id=prac_groep_stud.groepid and prac_groep.pracid=$pracId;"
$s |%{$_ -match "([mqsr]{1}\d{7})"|Out-Null;$Matches[1]}|%{get-Query $pracId $_ $sub_inc $prev_value}|Out-File $outFile -Force

