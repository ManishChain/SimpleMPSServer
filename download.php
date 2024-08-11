<?php
    $name= "SimpleMPS_4.apk";
    $apkFile = "apk/".$name;
    header('Content-Description: File Transfer');
    header('Content-Type: application/force-download');
    header("Content-Disposition: attachment; filename=\"" . basename($apkFile) . "\";");
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($apkFile));
    ob_clean();
    flush();
    readfile($apkFile); //showing the path to the server where the file is to be download
    exit;
?>