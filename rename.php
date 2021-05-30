<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (isset($_POST['new_name']) && isset($_POST['old_name'])) {

    $new_name = $_POST['new_name'];
    $old_name = $_POST['old_name'];


if($old_name != "../../Admin"){
    $val = true;

    try {
      if(file_exists($old_name)){
        rename($old_name, $new_name);
      }else{
        echo "File Doesn't Exist";
      }
    } catch (EngineException $e) {
      // Write Error Statement
      echo 'Message: ' .$e->getMessage();
      $val = false;
    }

    if ($val) {
      echo "success";
    } else {
      //echo "error";
    }
}else{
  echo "Can't Rename Admin";
}
  }
}
?>