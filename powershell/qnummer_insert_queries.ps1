#adds the qnummer to the student information

function get-query($qnummer,$snummer){
    $q = "update prac_student set qnummer='$qnummer' where snummer='$snummer';";    
    return $q;
}
#example call
import-csv .\H01B6a.csv -Delimiter ';' |% {get-query $_.qnummer $_.snummer} | Out-File 'qnummer.txt'
import-csv .\H01U3a.csv -Delimiter ';' |% {get-query $_.qnummer $_.snummer} | Out-File 'qnummer.txt' -Append