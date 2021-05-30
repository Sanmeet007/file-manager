<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  if (isset($_POST['path_1']) && isset($_POST['path_2']) && isset($_POST['array'])) {

    $path_1 = $_POST['path_1'];
    $path_2 = $_POST['path_2'];
    $array = $_POST['array'];
    $val = true;
    
 foreach ($array as $value) {
   try {
     if(file_exists("$path_2/$value")){
      rename("$path_1/$value", "$path_2/(Moved) $value");
     }else{
      rename("$path_1/$value", "$path_2/$value");
       
     }
     
   } catch (EngineException $e ) {
      echo 'Message: ' .$e->getMessage();
      $val = false;
   }
}
if($val){
  echo "success";
}else{
  echo "error";
}

  }
}
?>