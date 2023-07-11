<?php

    // Nommage des dossiers d'importation et d'exportation 

    $importFolderName = 'mac_urls';
    $exportFolderName = 'win_urls';

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
    
    // Existence du fichier ou du dossier ET Détermination : fichier ou dossier ?

    newLine(1);
    echo $horizontalSeparator;
    newLine(2);
    echo "Existence du fichier ou du dossier ET Détermination : fichier ou dossier ? - [$importFolderName]";
    newLine(1);
    
    // importFolderName
    if (!file_exists($importFolderName) && !is_dir($importFolderName)) 
    {
        echo "Le dossier [$importFolderName] n'existe pas.";
        newLine(1);
        mkdir($importFolderName, 0755, true);
        echo "Le dossier [$importFolderName] a été créé.";
        newLine(1);
    } else {
        echo "Le dossier [$importFolderName] existe.";
        newLine(1);
    }

    newLine(1);
    echo "Existence du fichier ou du dossier ET Détermination : fichier ou dossier ? - [$exportFolderName]";
    newLine(1);

    // exportFolderName
    if (!file_exists($exportFolderName) && !is_dir($exportFolderName)) 
    {
        echo "Le dossier [$exportFolderName] n'existe pas.";
        newLine(1);
        mkdir($exportFolderName, 0755, true);
        echo "Le dossier [$exportFolderName] a été créé.";
        newLine(1);
    } else {
        echo "Le dossier [$exportFolderName] existe.";
        newLine(1);
    }

    newLine(1);

    echo $horizontalSeparator;
   
    newLine(1);

    $importFolder = opendir($importFolderName);
    $listItemCounter = 1;

    while($importFile = readdir($importFolder)){
        if($importFile != '.' && $importFile != '..')
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