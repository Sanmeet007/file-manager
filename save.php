<?php

if($_SERVER['REQUEST_METHOD'] == "POST"){
  if(isset($_POST['textarea'])){
     $path = $_POST['path'];
    $upload_content =     htmlspecialchars_decode($_POST['textarea']);
    file_put_contents($path, $upload_content);
    echo "success";
  
  }else{
    echo "error";
  }
}else{
  
}

?>