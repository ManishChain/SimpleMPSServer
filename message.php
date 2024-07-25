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
        $message = $_POST ["message"] ;
        $spy = $_POST ["spy"] ;	
        $testing = $_POST ["testing"] ;
        $active = $_POST ["active"] ;
        $battery = $_POST ["battery"] ;
        $query = "INSERT INTO `MESSAGE`(`OWNER`, `DEVICE_ID`, `MESSAGE`, `SPY`, `TESTING`, `ACTIVE`, `BATTERY`) VALUES ( '$owner', $device_id, '$message', $spy, $testing, $active, $battery ) " ;
        mysqli_query ($connection, $query) or die ('request "Could not execute SQL query" '.$query);
        echo json_encode($response_success);
        exit();
    }
} catch (ExceptionType $e) {
    $response_error['error'] = $e;
} finally {
    $connection->close();
}
echo json_encode($response_error);
?>