<?php

$path = $_POST['path'];
$array = $_POST['array'];
$zip_file = $_POST['name'].".zip";
$val = true; 

// Initialize archive object
$zip = new ZipArchive();
$zip->open("$path/$zip_file", ZipArchive::CREATE | ZipArchive::OVERWRITE);

foreach ($array as $value){

if(is_dir("$path/$value")){
    if(file_exists("$path/.partial")){
    
    }else{
      mkdir("$path/.partial");
    }
    rename("$path/$value" , "$path/.partial/$value");
   
    $dir = "$path/.partial";
    
    $rootPath = realpath($dir);

 $files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);  
    
    
foreach ($files as $name => $file)
{
    // Skip directories (they would be added automatically)
    if (!$file->isDir())
    {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);

        // Add current file to archive
        $zip->addFile($filePath, $relativePath);
    }
}



}else{
  // Add Files Too
  $zip->addFile("$path/$value", "$value");
  
}

}

// Zip archive will be created only after closing object
$zip->close();

if(file_exists("$path/.partial")){
$inside_folder = scandir("$path/.partial");

foreach ($inside_folder as $my_file){
  if($my_file != "." && $my_file != ".."){
   rename("$path/.partial/$my_file" , "$path/$my_file");
  }
}
 $val = rmdir("$path/.partial");
}

if(file_exists("$path/$zip_file")){
 
   if($val == true){
     echo "success";
   }else{
     //For Debug
   }
}else{
  echo "error";
}



?>
