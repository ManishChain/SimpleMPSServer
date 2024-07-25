<?php
 
/* Define MySQL connection details and database table name 
User “myperzem_simplemps” was added to the database “myperzem_simplemps”.
*/ 

$SETTINGS["hostname"] = 'localhost:3306' ;
$SETTINGS["mysql_user"] = 'myperzem_simplemps';
$SETTINGS["mysql_pass"] = 'zxcv1234@MS$';
$SETTINGS["mysql_database"] = 'myperzem_simplemps';

$connection = mysqli_connect($SETTINGS["hostname"], $SETTINGS["mysql_user"], $SETTINGS["mysql_pass"], $SETTINGS["mysql_database"]) or die ('Unable to connect to MySQL server.<br ><br >Please make sure your MySQL login details are correct.');

$SERVER_PASS_KEY = 'r1mr1m@2024#MPS';

$response_success = array(
  'status' => 'success'
);
$response_error = array(
  'status' => 'fail'
);

?>