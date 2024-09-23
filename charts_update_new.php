<?php
$dirPath = "./uploads";
if(isset($_GET['file'])) {
    $filePath = $dirPath . '/' . $_GET ["file"];
    //echo $filePath;
    include($filePath);
} else {
    echo "<html><body><br>";
    $files = scandir($dirPath, SCANDIR_SORT_DESCENDING);
    foreach ($files as $file) {
        $filePath = $dirPath . '/' . $file;
        if (is_file($filePath)) {
            echo "<a href='?file=".$file."'>".$file."</a><br>";
            echo "<hr>";
        }
    }
    echo "<br></body><html>";
}
?>