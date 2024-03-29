cd C:\Users\pieterjd\Dropbox
$rows=Import-Csv .\hoofdstukken.csv -Delimiter ';'
$partTitle=''
$previousRow = $null
$weight = 1;
$rows = $rows | %{
    if($_.part -eq 1){
        $partTitle = $_.title
    }
    else{
        if($_.course -ne $previousRow.course){
            $partTitle = ';'
        }
    }
    Add-Member -InputObject $_ -MemberType noteproperty -Value $partTitle -Name 'parttitle'
    #adding the weight property
    if($_.course -ne $previousRow.course){
        #nieuw vak reset weight
        $weight = 1
    }
    else{
        #increase weight
        $weight++
    }
    Add-Member -InputObject $_ -MemberType noteproperty -Value $weight -Name 'weight' -PassThru
    $previousRow = $_

} 

$rows | Export-Csv -Path .\hoofdstukken-v6.csv -Delimiter ';' 
