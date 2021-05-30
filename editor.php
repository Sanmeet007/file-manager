<?php

if (isset($_GET['path'])) {
  $path = $_GET['path'];
  $syntax = $_GET['syntax'];
  $contents = file_get_contents($path);
} else {
  // Make an exit to file manager
}
$http = $_SERVER['HTTP_HOST'];
if (isset($_SERVER['HTTPS'])) {
  $http = "https://".$http;
} else {
  $http = "http://".$http;
}

$old_path = $path;
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

$size = filesize($path);
$size = formatSizeUnits($size);
$filename = basename($path);

$link = $http."/".$path;
$path = substr($path, 6);


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width  , initial-scale=1.0">
  
  <link rel="icon" type="image/png" sizes="32x32" href="./assets/favicon-32x32.png">
  
  <title>Editor - <?php echo $filename ?></title>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <style type="text/css" media="screen">
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      outline: none;
    }
    body {
      overflow: hidden;
      background: black;
      visibility: hidden;
    }
    #editor {
      margin: 0;
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      margin-bottom: 50px;
    }
    .submit {
      position: absolute;
      z-index: 10;
      display: flex;
      align-items: center;
      height: 50px;
      width: 100%;
      background: #404040;
      bottom: 0;
      left: 0px;
      padding: 0px 1%;
    }
@media screen and (max-width: 899px) {
      ::-webkit-scrollbar {
        width: 2px;
      }

      ::-webkit-scrollbar-track {
        background: none;
        opacity: 0.8;
      }

      ::-webkit-scrollbar-thumb {
        background: rgba(103,103,103,0.5);
        opacity: 0.8;
      }

      ::-webkit-scrollbar-thumb:hover {
        background: #eaeaea;
      }
    }

@media screen and (min-width: 900px) {
      ::-webkit-scrollbar {
        width: 10px;
      }

      ::-webkit-scrollbar-track {
        background: rgb(92,92,92);
        opacity: 0.8;
      }

      ::-webkit-scrollbar-thumb {
        background: rgb(191,191,191);
        opacity: 0.8;
      }

      ::-webkit-scrollbar-thumb:hover {
        background: #eaeaea;
      }
      .submit button {
        cursor: pointer;
      }
      .submit .button:hover {
        background: rgb(255,169,30);
      }
    }
    .submit .button:active {
      opacity: 0.8;
    }
    .submit .input {
      width: 25%;
      background: #111;
      border: none;
      margin-right: 10px;
      padding: 8px;
      border-radius: 5px;
      font-family: Consolas,"courier new";
      color: grey;
    }
    .submit .input:nth-child(1) {
      width: 60%;
    }
    .submit .input:nth-child(2) {
      width: 30%;
    }
    .submit .input:nth-child(3) {
      width: 20%;
    }

    .submit .button {
      margin: 5px;
      margin-right: 10px;
      padding: 8px 15px;
      text-transform: uppercase;
      font-size: 15px;
      border: none;
      background: #F3A425;
      border-radius: 5px;
      box-shadow: 1px 1px 4px 0 rgba(255,255,255,.2);

    }
    ._right {
      width: 40%;
      justify-content: flex-end;
      display: flex;
    }
    ._left {
      width: 60%;
      display: flex;
    }
  </style>
</head>
<body>
  <div class="end">
    <div id="editor"><?php echo  htmlspecialchars($contents); ?></div>
    <div class="submit">
      <div class="_left">
        <input class="input" type="text" id="file_path" value="<?php echo $http."/".$path ?>" disabled />
        <input class="input"  type="text" id="file_name" value="<?php echo $filename ?>" />
        <input class="input"  type="text" id="file_size" value="<?php echo $size ?>" />
      </div>
      <div class="_right">
        <form id="save" action="editor.php" method="post">
          <button class="button" type="submit">Save</button>
        </form>
        <button  class="button" onclick="view()">View</button>
      </div>
    </div>
  </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js" type="text/javascript" charset="utf-8"></script>
  <script>
    function view() {
      window.open("<?php echo $link ?>");
    }
    
    syntax = "<?php echo $syntax ?>";
    var editor = ace.edit("editor");


    editor.setOptions({
      autoScrollEditorIntoView: true,
      copyWithEmptySelection: true,
    });

    editor.setTheme("ace/theme/twilight");
    editor.session.setUseSoftTabs(true);
    editor.session.setUseWrapMode(true)
    // For Setting editor
    editor.session.setMode("ace/mode/"+syntax);
    editor. setOptions({
      fontSize: "15px"
    });


    save_file = document.getElementById('save');
    save_file.addEventListener('submit', (e)=> {
      e.preventDefault();
      value = editor.getValue();
      $.ajax({
        url: "save.php",
        type: "post",
        data: {
          textarea: value,
          path: "<?php  echo $old_path ?>",
        },
        success: function(data, status) {
          if (data == "success") {
            alert("success")
          }
          if (data == "error") {
            alert("error saving file")
          }

        },
        error: function() {
          alert('error');
        }
      });
    })

    $(document).ready(function() {
      $('body').css("visibility",
        "visible");
    });


    $(document).bind("keydown", function(e) {
      if (e.which == 83 && event.ctrlKey) {
        e.preventDefault();
      
        value = editor.getValue();
        $.ajax({
          url: "save.php",
          type: "post",
          data: {
            textarea: value,
            path: "<?php  echo $old_path ?>",
          },
          success: function(data, status) {
            if (data == "success") {
              alert("success")
            }
            if (data == "error") {
              alert("error saving file")
            }

          },
          error: function() {
            alert('error');
          }
        });
      }
    });
  </script>
</body>
</html>