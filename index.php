<?php
/**
*  File Management System

* last major  Version 1.3.7
* (Upload corrected )

* current version 1.4.0
* (Added Plupload support --> Chunk file uploading enabled now :) )
*
**/

$http = $_SERVER['HTTP_HOST'];
if (isset($_SERVER['HTTPS'])) {
  $http = "https://".$http;
} else {
  $http = "http://".$http;
}
if (isset($_GET['path'])) {
  //$path = $_GET['path'];
  $path = "..";
} else {
  $path = "..";
}
date_default_timezone_set("Asia/Calcutta");
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width  , initial-scale=1.0">

<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">


  <title>MonsterPress - File Manager</title>


  <link rel="apple-touch-icon" sizes="180x180" href="./assets/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="./assets/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="./assets/favicon-16x16.png">
  <link rel="mask-icon" href="./assets/safari-pinned-tab.svg" color="#000000">
  <link rel="shortcut icon" href="./assets/favicon.ico">
  <meta name="msapplication-TileColor" content="#000000">
  <meta name="msapplication-config" content="./assets/browserconfig.xml">
  <meta name="theme-color" content="#000000">


  <!-- FontAwsome icons  CSS and JavaScript -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" type="text/css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/regular.min.js" type="text/javascript" charset="utf-8"></script>

  <!-- Pluploader -->
  <script type="text/javascript" src="assets/js/plupload.full.min.js"></script>

  <!-- Linking Main Stylesheet -->
  <link rel="stylesheet" href="assets/css/style.css" title="" type="text/css" />

</head>
<body>

  <div class="modal">
    <div class="task close" style="padding: 10px 10px ; color: #F29F1B">
      <span>FILE UPLOADER</span>
    </div>
    <br>
    <div class="upload_task">
      <div class="progress" style="display:none">
        <progress id="progress" min="0" max="100" value="0"></progress>
        <span id="percent_complete" class="percent">0</span>
        <span>%</span>
      </div>
      <input style="display:none;" type="text" name="path" id="path_text" value="<?php echo $path ?>" />

      <ul id="filelist"></ul>


      <div class="flex-box">
        <a id="browse-btn" href="javascript:;">Browse Files </a>
        <a id="start-upload" href="javascript:;">Start Upload</a>
      </div>
      <a class="reset" onclick="upload_set()">Reset</a>
      <br />
      <pre style="display:none" id="console"></pre>

    </div>
    <br>
    <div class="task close" onclick="modal_close()">
      <span class="icon"> <i class="fas fa-times"></i></span>
      Close
    </div>

  </div>
  <div class="body">
    <div class="path">

      <div class="task_header_item">
        <div class="_previous gainFocus" tabindex="0" onkeypress="previous()" onclick="previous()">
          <i class="fas fa-arrow-left"></i>
        </div>
        <div class="_home gainFocus" tabindex="0" onclick="re_reload('..')"  onkeypress="re_reload('..')">
          <i class="fas fa-home"></i>
        </div>
        <!-- Disable this input -->
        <input class="__path"  type="text" disabled />
        <div class="_menu gainFocus"   tabindex="0"  onclick="regulator()" onkeypress="this.click()">
          <span class="_span"> <i class="fas fa-ellipsis-v"></i></span>
          <div class="menu_items">
            <div class="item gainFocus"  tabindex="0"  onkeypress="this.click()" onclick="create('folder')">
              New  Folder
            </div>
            <div class="item gainFocus"  tabindex="0"  onkeypress="this.click()"  onclick="create('file')">
              New File
            </div>
            <div class="item gainFocus"  tabindex="0"  onkeypress="this.click()" onclick="modal_open()">
              Upload File
            </div>
          </div>
        </div>

      </div>
      <br>
      <div class="_switching">
        <div class="switch_text">
          <span class="drawer gainFocus" onclick="drawer()"  onkeypress="drawer()" tabindex="0">
            <i class="fas fa-bars"></i>
          </span>

          <span class="select-1" onclick="selectAll()">
            <i class="fas fa-check-circle"></i>
          </span>
          <span class="select-1" onclick="deselectAll()">
            <i class="fas fa-circle"></i>
          </span>

          <span style="display:inline-block"> Edit Mode : </span>
          <span class="on_off"> OFF</span>

        </div>
        <div class="my_switch">
          <span id="switch"><span  tabindex="0" onkeypress="this.click()"  class="switch-btn"></span></span>
        </div>
      </div>


    </div>
    <div class="set_list">
      <div class="flex">
        <div class="flex_text">
          Directory Listing
        </div>
        <div onclick="close_drawer()" class="close_drawer">
          <i class="fas fa-times"></i>
        </div>
      </div>
      <div class="">

      </div>
      <?php require('load_folders.php') ?>
    </div>
    <div class="list">
      <?php require("load.php") ?>

    </div>
  </div>
  <div class="task_footer">
    <div class="major_tasks">

      <div class="btn" onclick="copy()">
        <div class="task_icon">
          <i class="far fa-clone"></i>
        </div>
        <div class="task_name">
          Copy
        </div>
      </div>

      <div class="btn" onclick="move()">
        <div class="task_icon">
          <i class="fas fa-file-export"></i>
        </div>
        <div class="task_name">
          Move
        </div>
      </div>

      <div class="btn" onclick="do_task('delete')">
        <div class="task_icon">
          <i class="fas fa-trash-alt"></i>
        </div>
        <div class="task_name">
          Delete
        </div>
      </div>

      <div class="btn rename" onclick="do_task('rename')">
        <div class="task_icon">
          <i class="fas fa-edit"></i>
        </div>
        <div class="task_name">
          Rename
        </div>
      </div>

      <div class="btn" onclick="do_task('zip')">
        <div class="task_icon">
          <i class="far fa-file-archive"></i>
        </div>
        <div class="task_name">
          Zip
        </div>
      </div>

    </div>
    <div class="download" onclick="do_task('download')">
      Download File
    </div>

  </div>
  <div class="file_task">

    <div class="paste_here">
      <div class="do_with">
        <span class="item_selected">0 items</span>
      </div>
      <div class="do_with">
        <button onclick="completeCopy('cancel')" class="btn">Cancel</button>

        <button class="btn" onclick="paste()"> Paste Here </button>
      </div>
    </div>

    <div class="move_here">
      <div class="do_with">
        <span class="item_selected">0 items</span>
      </div>
      <div class="do_with">
        <button onclick="completeMove('cancel')" class="btn">Cancel</button>

        <button class="btn" onclick="move_to()"> Move Here </button>
      </div>
    </div>

  </div>
  <div class="processing">
    <div class="processing_box">
      <i class="p_circle fas fa-circle-notch fa-spin"></i>
      <br>
      <br>
      <span id="processing_text">please wait for a moment</span>
    </div>

  </div>
  <!-- Loading Required Scripts -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    $(".__path").val("<?php echo $path; ?>");
    let  parent_path = "<?php echo $path ?>";
  </script>
  <script src="assets/js/preload.js" type="text/javascript" charset="utf-8"></script>
  <script src="assets/js/main.js" type="text/javascript" charset="utf-8"></script>

</body>
</html>
