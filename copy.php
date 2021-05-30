<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {

  if (isset($_POST['path_1']) && isset($_POST['path_2']) && isset($_POST['array'])) {

    $path_1 = $_POST['path_1'];
    $path_2 = $_POST['path_2'];
    $array = $_POST['array'];
    $val = true;
    $show_duplicate = false;
    $success = "success";
   
function full_copy( $source, $target ) {
    if ( is_dir( $source ) ) {
        @mkdir( $target );
        $d = dir( $source );
        while ( FALSE !== ( $entry = $d->read() ) ) {
            if ( $entry == '.' || $entry == '..' ) {
                continue;
            }
            $Entry = $source . '/' . $entry; 
            if ( is_dir( $Entry ) ) {
                full_copy( $Entry, $target . '/' . $entry );
                continue;
            }
            copy( $Entry, $target . '/' . $entry );
        }

        $d->close();
    }else {
        copy( $source, $target );
    }
}
 
 
    foreach ($array as $value) {
    
      try{
         if(file_exists($path_2."/".$value)){
         // Rename and the Paste Files 
         if(is_dir($path_1."/".$value)){
          $n = $path_1."/".$value."/".$value;
          $p = $path_2."/".$value;;
          if($n == $p){
           $success =  "error";
          }else{
           full_copy($path_1."/".$value , $path_2."/"."(Copy) ".$value);
          }
         }else{
         copy($path_1."/".$value, $path_2."/"."(Copy) ".$value);
         }
         $show_duplicate = true;
         }else{
         // Simple Paste
      
        if(is_dir($path_1."/".$value)){
          $n = $path_1."/".$value."/".$value;
          $p = $path_2."/".$value;
        if($n == $p){
          $success = "error";
        }else{
           full_copy($path_1."/".$value , $path_2."/".$value);
        }
         }else{
         copy($path_1."/".$value, $path_2."/".$value);
         }
         
         $show_duplicate = false;
         }
         
        } catch (EngineException $e) {
          echo 'Message: ' .$e->getMessage();
          $val = false;
        }
    }
        if($show_duplicate == true){
          echo  $success;
        }else{
          echo $success;
        }
      
    

  }
}
?>