Clear-Host
$javaDir="C:\temp\2010-2011-informatica2-juni\omwentelingslichaam\"



Get-ChildItem *.java -path $javaDir|%{
    $_
    $_.name -match "2010_2011_Omwentelingslichaam_a_([msr]{1}\d{7})_([A-Za-z\d]+.java)" |Out-Null;
    $snummer=$matches[1];
    $className=$matches[2];
    $folderName=$javaDir+$snummer
    $folderName
    New-Item $folderName -type directory 
    $dest=$folderName+$className
    $dest
    $_.fullname
    $_.fullname | Move-Item  -Destination $folderName
   


}
