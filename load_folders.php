<?php
if (isset($_GET['path'])) {
  $path = $_GET['path'];
} else {
  $path = "..";
  $first = "first time opening file";
}
$dir = $path;

if (is_dir($dir)) {
  $folders = scandir($dir);
  if (!isset($first)) {
    echo "<ul>";
  }
  foreach ($folders as $folder) {
    if (is_dir("$dir/$folder")) {

      if ($folder != '.' && $folder != '..') {
        echo "<li tabindex='0' class='folder-list' data-path='$dir/$folder' onkeypress='re_reload(`$dir/$folder`)'>
             <span class='folder_icon'>
              <i class='fas fa-folder'></i>
             </span>
             <span>  $folder</span>
             <span onclick='re_reload(`$dir/$folder`)'> LOAD </span>
             <span  onclick='folder_tree(this)'>
             <i class='fas fa-angle-up'></i>
             </span>
             <span class='load'>
             <i class='fas fa-spinner'></i>
             </span>
             </li>";
      }
    }
  }
  if (!isset($first)) {
    echo "</ul>";
  }
} else {
  echo "dir error";
}
?>
