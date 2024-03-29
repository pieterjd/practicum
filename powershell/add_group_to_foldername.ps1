#run op de database de query gebookmarkt als 'qnummer_groep_lookup
#pas pracId aan
#zorg ervoor dat 
# 0/ dat je update_queries_for_submissions script eerst gerund hebt
# 1/ ; de delimiter is en 
# 2/ de quotes wegzijn bij 'fields enclosed by' optie en 
# 3/ fields names in first row
#open in teksteditor en noem de kolommen snummer en nummer
#pas de variabele $folder aan
$lookup=@{}
#Update CSV
$csv=Import-Csv -Delimiter ';' C:\temp\2013-2014-inf2-september\prac_groep.csv
$csv|%{$lookup.add($_.qnummer,$_.nummer)}
#UPDATE folder
$folder='C:\temp\2013-2014-inf2-september'
#uitgepakte folders overlopen
$s=dir $folder | Where {$_.psIsContainer -eq $true}

$s |%{
    $_.name -match "([mqsr]{1}\d{7})"|Out-Null;
    $snummer=$Matches[1]; 
    $newName=($_.parent.fullname + "\"+ ("{0:D3}" -f [int]$lookup[$snummer]));
    if(! (test-path $newName)){
        Rename-Item -Path $_.fullname -NewName $newName
        write-host $_.fullname + 'moved to '+ $newName
    }
    else{
        Write-Error "$newName already exits, skipped "+ $_.name
    }
}
#indien nog folders niet gerenamed zijn check welke groepen dat zijn
$s |?{$_.name -match "([msqr]{1}\d{7})"}|%{$_.name -match "([mqsr]{1}\d{7})"|Out-Null;$snummer=$Matches[1];[int]$lookup[$snummer]}|sort

#voor MI examen 2011-2012-twitter moest nog een UnitTest gecopieerd worden naar alle folders
#$file='C:\temp\2011-2012-mi-examen\TwitterClientTest.java'
#dir $folder | Where {$_.psIsContainer -and $_.name -match "^[\d]{3,3}"} | %{ Copy-Item -Path $file -Destination $_.fullname}