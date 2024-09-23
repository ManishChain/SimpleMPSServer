<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">

    <title>SimpleMPS Charts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link href="assets/css/tabulator.min.css" rel="stylesheet">
    <link href="assets/css/my.css" rel="stylesheet">
    <script type="text/javascript" src="assets/js/tabulator.min.js"></script>

    <!-- STYLE CSS -->
    <style type="text/css">
        .linechart {
            position: relative; z-index: 0; height: 300px; width: 500px;
            font: normal 13px "PT Sans", Arial; line-height: 17px;
        }
        .linechart > canvas {
            border: 1px solid #151515;
        }
        .linechart > div {
            display: none; 
            position: absolute; z-index: 1; left: 0; top: 0; 
            font-size: 12px; line-height: 16px; white-space: nowrap; color: black; 
            padding: 10px; border: 1px solid #D5D5D5; background-color: white;
            box-shadow: 0 5px 15px rgba(56,56,56,0.15); 
        }
    </style>

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- JQUERY EXTENSION -->
    <script type="text/javascript" src="assets/js/linechart_battery.js"></script>

</head>
<body>
    <?php
        include("config.php");
        $passkey = $SERVER_PASS_KEY;
        if(isset($_POST['passkey'])) {
            $passkey = $_POST ["passkey"] ;
        }
        //echo $passkey;
        if(empty($passkey)) {
            echo"Empty passkey ";
    ?>
            <form action="" id="form" method="post">
                <input type="password" name="passkey" id="passkey" required> 
                <input type="submit" value="Login">
            </form>
    <?php
            return;
        }
        if(strcmp($passkey,$SERVER_PASS_KEY)!=0) {
          echo"Wrong passkey : '$passkey' Please contact admin to resolve issue." ;
          return;
        };
    ?>
    
    
        <?php
        $sqlDevice = "SELECT * FROM `DEVICE` ORDER BY ID";
        $resultDevice = $connection->query($sqlDevice);
        if ($resultDevice->num_rows > 0) {
            $currentDeviceID = 0 ;
            while ($rowDevice = $resultDevice->fetch_assoc()) {
                $currentDeviceID = $rowDevice['ID'];
                $sql = "SELECT max(t.BATTERY) BATTERY, TIMESTAMPDIFF(HOUR, t.ADDED_ON, now()) DIFF, DATE_FORMAT(t.ADDED_ON, '%m/%d/%Y %H:%i') ADDED_ON from ADMIN_SMS t WHERE t.DEVICE_ID = ".$currentDeviceID." group by DIFF ORDER BY t.id DESC LIMIT 10";
                echo "<br><br><div style='background:#dfdfdf;padding:1px; border:solid red 0px;'>";
                echo displayLabel($rowDevice,'ID');
                echo displayLabel($rowDevice,'NUMBER');
                echo displayLabel($rowDevice,'ANDROID');
                echo displayLabel($rowDevice,'HANDET_INFO');
                echo displayLabel($rowDevice,'ADMIN');
                echo displayLabel($rowDevice,'OWNER');
                echo displayLabel($rowDevice,'OWNER_INFO');
                //echo displayLabel($rowDevice,'DEVICE_STATUS');
                //echo displayLabel($rowDevice,'LIVE');
                echo "</div>";
                //echo $sql;
                echo "<script type=\"text/javascript\">$.linechart_1({ id: '".$currentDeviceID."', data: [ [  ";
                $result = $connection->query($sql);
                if ($result->num_rows > 0) {
                    $count=0;
                    while ($row = $result->fetch_assoc()) {
                       echo "{ X:".$row['DIFF'].", Y: ".$row['BATTERY'].", tip: '<div style=\"background: white;padding:10px;\"><font color=\"red\">Battery <b>".$row['BATTERY']." %</b> at  ".$row['ADDED_ON']." </font></div>' }, \n" ; $count++;
                    }
                } else { 
                        echo "<h2>No logs found</h2>";
                };
                // echo "{ X:0, Y: 67, tip: 'tip 11' }, { X:1, Y: 57, tip: 'tip 12' } " ;
                echo " ] ] }); </script>";
                echo "</div>\n";
            }
        } else { 
                echo "<h2>No devices found</h2>";
        };
        
    ?>
    
<br><br><br>

</body>
</html>