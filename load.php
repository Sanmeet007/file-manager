<?php

date_default_timezone_set("Asia/Calcutta");

// Use $addTime to add time
if(isset($_GET['path'])){
$path = $_GET['path'];
  $addTime = 0;
}else{
  $path = "..";
  $addTime = 0;
}

      function formatSizeUnits($bytes) {
        if ($bytes >= 1073741824) {
          $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
          $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
          $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
          $bytes = $bytes . ' B ';
        } elseif ($bytes == 1) {
          $bytes = $bytes . ' B';
        } else
        {
          $bytes = '0 B';
        }

        return $bytes;
      }

      $src = $path;
      if (is_dir($src)) {
        

        $files = scandir($src, 0);
        $items = count($files);
       
        if($items !=  2){
          for ($num = 0; $num < $items; $num += 1) {
              
              $id = $num;
            $file = $files[$num];
  
            switch ($file) {
              case '.':
                // code...
                break;
  
              case '..':
                // code...
                break;
  
              default:
                $stats = stat("$path/$file");
                $size = filesize("$path/$file");
                if (is_dir("$path/$file")) {
                  $type = "folder";
  
                  $folder_items = count(scandir("$path/$file")) - 2;
  
                  if ($folder_items == 1) {
                    $f_item = "item";
                  } else {
                    $f_item = "items";
                  }
      $time =  $stats["mtime"] + $addTime;
      $time =  date("F d Y h:i A", $time);
      
                  echo '
    <div onclick="reload('.$id.')" tabindex="0" onkeypress="this.click()" class="list-style" id="list-style-'.$id.'"  data-path="'.$path.'/'.$file.'"  data-type="'.$type.'">
          <div class="_checkbox">
            <!-- For  Check Box -->
            <label for="check_'.$id.'">
  
            </label>
            <input style="display: none" data-id="'.$id.'" type="checkbox" id="check_'.$id.'" class="check" value="" />
  
          </div>
          <div class="_icon">
            <div class="folder">
              <i class="fas fa-folder"></i>
            </div>
          </div>
          <div class="_name">
            <!-- For Name -->
            <div class="_fileName">
              '.$file.' 
            </div>
            <div class="_fileDetails">
              <span>
     '.$time.'
              </span>
              <span class="flowMe">'.$folder_items.' '.$f_item.'</span>
            </div>
          </div>
        </div>
    ';
  
                } else {
  
  
                  $icon = (explode(".", $file));
                  $array_length = count($icon);
                  $array_length = $array_length - 1;
  
                  $icon = $icon[$array_length];
  
  
                  switch ($icon) {
  
                    case 'php':
                      $icon = "php";
                      $class = "php";
                      break;
  
                    case 'txt':
                      $icon = "txt";
                      $class = "txt";
                      break;
  
                    case 'js':
                      $icon = "js";
                      $class = "js";
                      break;
  
                    case 'html':
                      $icon = "html";
                      $class = "html";
                      break;
  
                    case 'css':
                      $icon = "css";
                      $class = "css";
                      break;
  
                    case 'png':
                      $icon = "png";
                      $class = "png";
                      break;
  
  
                    case 'gif':
                      $icon = "gif";
                      $class = "gif";
                      break;
  
  
  
                    case 'pdf':
                      $icon = "pdf";
                      $class = "pdf";
                      break;
  
                    case 'jpg':
                      $icon = "jpg";
                      $class = "jpg";
                      break;
  
                    case 'jpeg':
                      $icon = "jpg";
                      $class = "jpg";
                      break;
  
                    case 'svg':
                      $icon = "svg";
                      $class = "svg";
                      break;
  
                    case 'mp4':
                      $icon = "mp4";
                      $class = "mp4";
                      break;
                      
                    case 'mkv':
                      $icon = "mkv";
                      $class = "mkv";
                      break;
  
                    case 'mp3':
                      $icon = "mp3";
                      $class = "mp3";
  
                      break;
                      
                    case 'zip':
                      $icon = "zip";
                      $class = "zip";
  
                      break;
  
  
                    default:
                      $icon = "<i style='font-size:20px' class='fas fa-file'></i >";
                      $class = "unknown";
                      break;
                  }
     $time =  $stats["mtime"] + $addTime;
      $time =  date("F d Y h:i A", $time);
      
                  echo '
    <div onclick="reload('.$id.')" tabindex="0"  onkeypress="this.click()" class="list-style" id="list-style-'.$id.'" data-path="'.$path.'/'.$file.'"  data-type="'.$class.'">
          <div class="_checkbox">
            <!-- For  Check Box -->
            <label for="check_'.$id.'">
  
            </label>
            <input style="display:none" data-id="'.$id.'" type="checkbox" id="check_'.$id.'" class="check" value="" />
  
          </div>
          <div class="_icon">
            <div class="file '.$class.'">
            '. $icon.'
            </div>
          </div>
          <div class="_name">
            <!-- For Name -->
            <div class="_fileName">
              '.$file.'
            </div>
            <div class="_fileDetails">
              <span>
           '.$time.'
              </span>
              <span style="float:right; padding-right:10px">
             '.formatSizeUnits($size).'
  
  </span>
            </div>
          </div>
        </div>
      
    ';
  
  
  
                }
  
                break;
            }
          }
           echo "<br><br>";
          }else{
            echo "empty"; 
          }
      } else {
        echo "error";
      }

     
?>
