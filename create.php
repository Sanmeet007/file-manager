<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (isset($_POST['create'])) {
    $path = $_POST['path'];
    $create = $_POST['create'];
    if ($create == "folder") {
      $folder = $_POST['folder'];
      $folder = $path."/".$folder;

      try {
        $bool = mkdir($folder);
        if ($bool == true) {
          echo "success";
        }
      }catch (Exception $e){
       echo 'Message: ' .$e->getMessage();
        
      }

    }
    if ($create == "file") {
      $file = $_POST['file'];
      $file = $path."/".$file;
      
      try {
        $bool = fopen($file, "w");
        if ($bool == true) {
          echo "success";
        }
      }catch(Exception $e){
       echo 'Message: ' .$e->getMessage();
      }
      
    }
  }
}


?>