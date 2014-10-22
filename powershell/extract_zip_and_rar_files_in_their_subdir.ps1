# 11 aug 2014: onliner om spaties te verwijderen uit filenames
#gci processing* | %{ Rename-Item -Path $_.fullname -NewName $_.name.replace(' ','')}
#12 aug 2013: files van toledo bevat nu q-nummer ipv u nummer
#hieronder een one-liner om de folders te hernoemen naar unummer
#Get-ChildItem *  -Path $zipFileDir |?{$_.PSIsContainer} |%{$newName = $_.Name.replace('q','r'); Rename-Item -Path $_.fullname -NewName $newName}
Clear-Host
$teller = 0
#dir moet eindigen op backslash
$zipFileDir="C:\temp\2013-2014-inf2-september\";
Get-ChildItem *  -Path $zipFileDir | sort name |foreach{
    #snummer
    [IO.Path]::GetFileNameWithoutExtension($_) -match "([msqr]{1}\d{7})"|Out-Null;
    $snummer=$Matches[1];
    
	#http://www.vistax64.com/powershell/11126-get-childitem-files-names-without-extension.html
	$extractFolder=$zipFileDir+$snummer+"\"
	
	if(! (Test-Path $extractFolder) -and ($_.Extension -eq ".zip" -or $_.Extension -eq ".rar")){
		mkdir $extractFolder
        $zipCommand="C:\temp\7z\7z.exe x  -o$extractFolder $zipFileDir" +($_)+ ""
    	$rarCommand="c:\temp\unrar\unrar.exe x " +($_)
    	
    	if($_.extension -eq ".zip"){
            "Extracting "+($_.name)
    		#execute the string in $command as as an instruction
    		Invoke-Expression $zipCommand 
            #alternative
            #C:\temp\7z\7z.exe x  -o$extractFolder $zipFileDir "$_"
            $teller++
    	}
    	if($_.extension -eq ".rar"){
    		#execute the string in $command as as an instruction
    		#Invoke-Expression $rarCommand
    		#eerst rar file copieren naar extractdir
    		Copy-Item $_.FullName -Destination $extractFolder
    		#moet naar extractfolder gaan want unrar kan niet tegen lange filenames :s
    		cd $extractFolder
    		Invoke-Expression $rarCommand
    	}
        #eventuele stl files copieren naar folder
        
        #$filesToCopy=$zipFileDir+"Indienen_java_code_en_stl_bestanden_a_"+$snummer+"*.stl";
        #eventuele stl files copieren naar folder
        #Copy-Item $filesToCopy $extractFolder
	}
    elseif ((Test-Path $extractFolder) -and ($_.Extension -eq ".zip") ){
    
        Write-Warning  "$extractFolder exists when trying to extract $_ . SKIPPING"
        #Remove-Item $extractFolder
        #mkdir $extractFolder
        #$zipCommand="C:\temp\7z\7z.exe x -y -o$extractFolder $zipFileDir" +($_)+ ""
        #Invoke-Expression $zipCommand |Out-Null
        
    }
	
	
	
	
	
	
}
Write-Host $teller