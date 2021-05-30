<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  if (isset($_POST['path']) && isset($_POST['file'])) {

    $path = $_POST["path"];
    $file = $_POST["file"];


    $file_path = "$path/$file";
    if (file_exists($file_path)) {
      $zip = new ZipArchive;
      $res = $zip->open($file_path);

      if ($res === TRUE) {
        $zip->extractTo($path);
        $zip->close();
        echo 'success';
      } else {
        echo 'error';
      }

    } else {
      echo "file doesn't exist";
    }
  } else {
    echo "Error";
  }
}
?>