<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (isset($_POST['array']) && isset($_POST['path'])) {

    $path = $_POST['path'];
    $array = $_POST['array'];
    $val = true;


function delTree($dir)
    { 
        $files = array_diff(scandir($dir), array('.', '..')); 

        foreach ($files as $file) { 
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
        }
        return rmdir($dir); 
    } 
    
    foreach ($array as $value) {
      if (is_dir($path."/".$value)) {
        try {
           if(file_exists($path."/".$value)){
         
           delTree($path."/".$value);
           
           }else{
            // echo "Folder Doesn't Exist";
           }
        } catch (EngineException $e) {
          echo 'Message: ' .$e->getMessage();
          $val = false;
        }

      } else {
        try {
          if(file_exists($path."/".$value)){
          unlink($path."/".$value);
          }
        } catch (EngineException $e) {
          echo 'Message: ' .$e->getMessage();
          $val = false;
        }
      }
    }

    if ($val) {
      echo "success";
    } else {
      echo "error";
    }

  }
}
?>