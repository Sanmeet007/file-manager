<?php

$success = "success";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    
  $path =  $_POST['path']."/";
 
//$files = array_filter($_FILES['upload']['name']); //something like that to be used before processing files.

// Count # of uploaded files in array
$total = count($_FILES['upload']['name']);

// Loop through each file
for( $i=0 ; $i < $total ; $i++ ) {

  //Get the temp file path
  $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

  //Make sure we have a file path
  if ($tmpFilePath != ""){
    //Setup our new file path
    //$newFilePath = "./uploadFiles/" . $_FILES['upload']['name'][$i];
      //$fileName = $_FILES['file']['tmp_name'];
      $target_path = $path;
      $target_path = $target_path.basename($_FILES['upload']['name'][$i]);

    //Upload the file into the temp dir
    if(move_uploaded_file($tmpFilePath, $target_path)) {
      $success = "success";
      //Handle other code here
    }else{
      $success = "error";
    }
  }
}
      echo $success;


}

?>