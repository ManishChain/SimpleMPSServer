<?php
try {
    include("config.php");
    
    $_POST = json_decode(file_get_contents('php://input'), true);

    $passkey = $_POST ["passkey"] ;	

    if(strcmp($passkey,$SERVER_PASS_KEY)!=0) {
        echo "Wrong passkey";
        die("Wrong passkey");
    }

    $owner = $_POST ["owner"] ;	
    $device_id = $_POST ["device_id"] ;
    $message = $_POST ["message"] ;
    $spy = $_POST ["spy"] ;	
    $testing = $_POST ["testing"] ;
    $active = $_POST ["active"] ;
    $battery = $_POST ["battery"] ;
    
    $query = "INSERT INTO `MESSAGE`(`OWNER`, `DEVICE_ID`, `MESSAGE`, `SPY`, `TESTING`, `ACTIVE`, `BATTERY`) VALUES ( '$owner', $device_id, '$message', $spy, $testing, $active, $battery ) " ;
    mysqli_query ($connection, $query) or die ('request "Could not execute SQL query" '.$query);

} catch (ExceptionType $e) {
    
} finally {
    $connection->close();
}

?>

<?php
$jsonData = array(
    'status' => 'ok'
);
header('Content-Type: application/json');
echo json_encode($jsonData);
?>
