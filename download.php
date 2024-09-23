<?php
    include("config.php");
    $passkey = "" ;
    if(isset($_POST['passkey'])) {
        $passkey = $_POST ["passkey"] ;
    }
    //echo $passkey;
    if(empty($passkey)) {
        echo"Empty passkey ";
?>
        <html>
        <head>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
            <link href="assets/css/tabulator.min.css" rel="stylesheet">
            <link href="assets/css/my.css" rel="stylesheet">
            <script type="text/javascript" src="assets/js/tabulator.min.js"></script>
        </head>
        <body>
            <form action="" id="form" method="post">
                <input type="password" name="passkey" id="passkey" required> 
                <input type="submit" value="Login">
            </form>
        </body>
        </html>    
<?php
        return;
    }
    if(strcmp($passkey,$DOWNLOAD_PASS_KEY)!=0) {
      echo"Wrong passkey : '$passkey' Please contact admin to resolve issue." ;
      return;
    };
    // download apk
    $name= "SimpleMPS_10_Sept.apk";
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
?>
