<?php
try {
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  // Check if file already exists
  if (file_exists($target_file)) {
    $response_error['error'] = "file already exists";
    $uploadOk = 0;
  }
  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 500000) {
    $response_error['error'] = "file size > 50 KB";
    $uploadOk = 0;
  }
  // Allow certain file formats
  if($fileType != "txt" && $fileType != "log") {
    $response_error['error'] = "file not valid .txt or .log";
    $uploadOk = 0;
  }
  // if everything is ok, try to upload file
  if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      $response_success['message'] = "Saved file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
      echo json_encode($response_success);
      exit();
    } 
  }
} catch (ExceptionType $e) {
  // die("Error ".$e);
  $response_error['error'] = $e;
} finally {
    $connection->close();
}  
echo json_encode($response_error);
?>