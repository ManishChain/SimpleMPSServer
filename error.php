<?php
$status = $_SERVER['REDIRECT_STATUS'];
$codes = array(
       301 => array('301 Forbidden', 'You are not authorized to view this page. Please contact support to resolve issues.'),
       403 => array('403 Forbidden', 'The server has refused to fulfill your request.'),
       404 => array('404 Not Found', 'The document/file requested was not found on this server.'),
       405 => array('405 Method Not Allowed', 'The method specified in the Request-Line is not allowed for the specified resource.'),
       408 => array('408 Request Timeout', 'Your browser failed to send a request in the time allowed by the server.'),
       500 => array('500 Internal Server Error', 'The request was unsuccessful due to an unexpected condition encountered by the server.'),
       502 => array('502 Bad Gateway', 'The server received an invalid response from the upstream server while trying to fulfill the request.'),
       504 => array('504 Gateway Timeout', 'The upstream server failed to send a request in the time allowed by the server.'),
);

if( is_null($status) || !isset($status)) {
        echo 'Null status';
} else {
    echo '<h1>'.$status.'</h1>
}

$title = $codes[$status][0];
$message = $codes[$status][1];

if ($title == false || strlen($status) != 3) {
       $message = 'Please supply a valid status code.';
}
// Insert headers here
echo '<h1>'.$title.'</h1>
<p>'.$message.'</p>';

?>