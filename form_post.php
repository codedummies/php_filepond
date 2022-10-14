<?php

// echo "<pre>";
// print_r($_POST);
// echo "</pre>---------------------------------------<br>";
// echo "<pre>";
// print_r($_FILES);
// echo "</pre>";
// exit;


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "filepon";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$countfiles = count($_FILES['files']['name']);

// Upload Location
$upload_location = "uploads/";

// To store uploaded files path
$files_arr = array();
for($index = 0;$index < $countfiles;$index++){
   if(isset($_FILES['files']['name'][$index]) && $_FILES['files']['name'][$index] != ''){
      $filename = $_FILES['files']['name'][$index];
      $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
      $valid_ext = array("png","jpeg","jpg");
      if(in_array($ext, $valid_ext)){
         $path = $upload_location.'files/'.$filename;
         if(move_uploaded_file($_FILES['files']['tmp_name'][$index],$path)){
            $files_arr[]  = $path;
         }
      }
   }
}
$profile_uploaded_path = "";
if($_FILES['profile']['name']){
    $filename = $_FILES['profile']['name'];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $valid_ext = array("png","jpeg","jpg");
    if(in_array($ext, $valid_ext)){
        $path = $upload_location.'profile/'.$filename;
            if(move_uploaded_file($_FILES['profile']['tmp_name'],$path)){
            $profile_uploaded_path = $path;
        }
    }
}

$files = json_encode($files_arr);
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];

$sql = "INSERT INTO user (first_name,last_name,email,files,profile_photo) VALUES ('$first_name','$last_name','$email','$files','$profile_uploaded_path')";
if ($conn->query($sql) === TRUE) {
echo "New record created successfully";
} else {
echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


?>