<?php
function displayFile($file) {
    $file_content = file_get_contents($file);
    if ($file_content === false) {
        return "Impossible de lire le fichier demandé : ".$file;
    } else {
        return htmlentities($file_content);
    }
}
?>