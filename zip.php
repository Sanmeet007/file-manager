<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {

  if (isset($_POST['path']) && isset($_POST['array'])) {

    $array = $_POST['array'];
    $path = $_POST['path'];

    //$value = $array[0];

    $folder_name = "Zipped";
    $zip_name = $folder_name.".zip";



    function delTree($dir) {
      $files = array_diff(scandir($dir), array('.', '..'));

      foreach ($files as $file) {
        (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
      }
      return rmdir($dir);
    }


    if (file_exists("$path/$folder_name")) {
      delTree("$path/$folder_name");
      mkdir("$path/$folder_name");
    } else {
       $val = mkdir("$path/$folder_name");
    }

if($val == true){
   
   // Moving Selected Files to Folder to be Zipped
   
    foreach ($array as $value) {

      rename("$path/$value", "$path/$folder_name/$value");

    }
    
   //  Generating Zip File From Folder
  
    new GoodZipArchive("$path/$folder_name", "$path/$zip_name");

    if (file_exists("$path/$zip_name")) {
      delTree("$path/$folder_name");
     
     if(file_exists("$path/$folder_name")){
      echo "error deleting folder";
     }else{
       echo "success";
     }
    } else {
      echo "Error Creating Zip File";
    }
  }
  else{
    echo "error";
  }
  }
}

 class GoodZipArchive extends ZipArchive
    {
      public function __construct($a = false, $b = false) {
        $this->create_func($a, $b);
      }

      public function create_func($input_folder = false, $output_zip_file = false) {
        if ($input_folder !== false && $output_zip_file !== false) {
          $res = $this->open($output_zip_file, ZipArchive::CREATE);
          if ($res === TRUE) {
            $this->addDir($input_folder, basename($input_folder)); $this->close();
          } else {
            echo 'Could not create a zip archive. Contact Admin.';
          }
        }
      }

      // Add a Dir with Files and Subdirs to the archive
      public function addDir($location, $name) {
        $this->addEmptyDir($name);
        $this->addDirDo($location, $name);
      }

      // Add Files & Dirs to archive
      private function addDirDo($location, $name) {
        $name .= '/'; $location .= '/';
        // Read all Files in Dir
        $dir = opendir ($location);
        while ($file = readdir($dir)) {
          if ($file == '.' || $file == '..') continue;
          // Rekursiv, If dir: GoodZipArchive::addDir(), else ::File();
          $do = (filetype($location . $file) == 'dir') ? 'addDir' : 'addFile';
          $this->$do($location . $file, $name . $file);
        }
      }
    }

?>