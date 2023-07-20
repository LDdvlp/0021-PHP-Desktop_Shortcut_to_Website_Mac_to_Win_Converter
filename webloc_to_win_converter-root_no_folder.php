<?php

    // Fichier courant 
    $workingFileName = basename(__FILE__);

    // Nommage des dossiers d'importation et d'exportation 

    $workingFolderName = getcwd();
    $importFolderName = $workingFolderName;
    $exportFolderName = $workingFolderName;

    // Séparateur horizontal
    $horizontalSeparator = '--------------------------------------------------------------------------------------------';

    // Fonction n°1 : newLine
    function newLine($numberOfLines)
    {
        for ($i=1 ; $i<=$numberOfLines; $i++)
        {
            echo "\n" ;
        };
       
    }
    
    newLine(1);

    echo $horizontalSeparator;
   
    newLine(1);

    $importFolder = opendir($importFolderName);
    $listItemCounter = 1;

    while($importFile = readdir($importFolder)){
        if(file_exists($importFile) && !is_dir($importFile) && $importFile != '.' && $importFile != '..' && $importFile != $workingFileName)
        {
            // Affichage des fichiers à convertir
            //echo $separator;
            echo "\n";
            echo "Fichier n°" . $listItemCounter . " :";
            newLine(1);
            echo $importFile;
            newLine(1);
            // Récupération du contenu du fichier dans la variable $originalText
            $importPath = $importFolderName . "/" . $importFile;
            $originalText = file_get_contents($importPath);
            newLine(1);
            echo "Contenant :";
            newLine(2);
            echo $originalText;
                        
            // Extraction du texte compris entre les balises <string> et </string> dans la variable $extractedText
            preg_match('/<string>(.*?)<\/string>/s', $originalText, $extractedText);
            
            // Préparation du nouveau texte
            $newTextLine1 = "[InternetShortcut]\n";
            $newTextLine2 = "URL=";
            $newText = "";
            $newText .= $newTextLine1;
            $newText .= $newTextLine2;
            $newText .= $extractedText[1];
            $newText .= "\n";

            // Écriture du nouveau texte dans un fichier
            $exportFile = str_replace('webloc', 'url', $importFile);
            $exportPath = $exportFolderName . "/" . $exportFile;
            file_put_contents($exportPath, $newText);
            newLine(1);
            echo "Converti en :";
            newLine(1);
            echo $exportFile;
            newLine(2);
            echo "Contenant :";
            newLine(2);
            echo $newText;
            newLine(1);
            echo $horizontalSeparator;
            newLine(1);

            // Incrémentation du compteur de la liste des fichiers
            $listItemCounter += 1;
        }
    }

    closedir($importFolder);

?>