<?php
try {
    include("config.php");
    $_POST = json_decode(file_get_contents('php://input'), true);
    $passkey = $_POST ["passkey"] ;	
    if(strcmp($passkey,$SERVER_PASS_KEY)!=0) {
        $response_error['error'] = "Wrong passkey";
    } else {
        $owner = $_POST ["owner"] ;	
        $android = $_POST ["android"] ;
        $handset_info = $_POST ["handset_info"] ;
        $admin = $_POST ["admin"] ;
        $owner = $_POST ["owner"] ;
        $owner_info = $_POST ["owner_info"] ;
        $query = "INSERT INTO `DEVICE`(`ANDROID`, `HANDET_INFO`, `ADMIN`, `OWNER`, `OWNER_INFO`) VALUES ( $android, '$handset_info', '$admin', '$owner', '$owner_info' ) " ;
        mysqli_query ($connection, $query) or die ('request "Could not execute SQL query" '.$query);
        $id = $connection->insert_id;
        $response_register_success = [];
        $response_register_success['device_id'] = $id;
        echo json_encode($response_register_success);
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