#copy this year's assignments to plagiarism folder
#next onliner adds prefix
$prefix = '201404-'
$folder = 'C:\plagiaatcheck\201404-inf2-processing'
$s=dir $folder | Where {$_.psIsContainer -eq $true}
 $s|%{
    $newFolderName = $prefix + $_.name
    $newName=($_.parent.fullname + "\"+ $newFolderName);
    if(! (test-path $newName)){
        Rename-Item -Path $_.fullname -NewName $newName
        write-host $_.fullname + 'moved to '+ $newName
    }
}
#remove non-java files and non-folders
Get-ChildItem -Recurse -Exclude *.java|?{! $_.psIsContainer} | Remove-Item