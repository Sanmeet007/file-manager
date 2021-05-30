/*
  File Manager Current Js version 1.4.0
*/

// Some Variables  and Constants

let path_1;
let path_2;
let copy_files = [];
let move_files = [];
let attr;
let html = "";


let checkbox = document.querySelectorAll(".check");


let empty_folder = `
<div class="empty">
No files
</div>
`;

//Function For Various Tasks Management

function do_task(task) {

  let array = [];
  checkbox = document.querySelectorAll(".check");

  checkbox.forEach(box => {
    if (_switch) {
      if (box.checked == true) {

        let id = "list-style-" + box.getAttribute("data-id");

        let file_named_path = document.querySelector("#"+id+" ._fileName").innerText;

        // USE PHP TO DO VARIOUS TASKS

        array.push(file_named_path);


      } else {
        // Do Nothing ! YAY
      }

    } else {
      box.checked = false;
    }
  });

  if (array.length != 0) {

    path = $('.__path').val();


    switch (task) {
      case 'delete':
        $.ajax({
          url: "delete.php",
          type: "post",
          data: {
            array: array,
            path: path,
          },
          beforeSend: function () {
            show_processing()
          },
          success: function (data, status) {

            if (data == "success") {
              //  alert("Files Deleted");
              re_reload($('.__path').val());
              _switch = false;
              switchOff();
              array = [];
            } else {
              hide_processing();
              alert(data);
            }
          }
        });
        break;

      case 'copy':
        copy_files = array;
        array = [];
        setCopy()

        break;

      case 'move':
        move_files = array;
        array = [];
        setMove();
        break;


      case 'rename':
        if (checked_checkboxes == 1) {
          let get_name = prompt("Enter Vaild Name");

          old_name = array[0];
          path = $('.__path').val();

          // alert(get_name);
          if (get_name != null) {
            $.ajax({
              url: "rename.php",
              type: "post",
              data: {

                old_name: path+"/"+ old_name,
                new_name: (path +"/"+get_name).trim(),

              },
              beforeSend: function() {
                show_processing();
              },
              success: function (data, status) {
                alert(data);
                if (data == "success") {
                  //  alert("Files Deleted");
                  re_reload($('.__path').val());
                  _switch = false;
                  array = [];
                  old_name = "";
                  new_name = "";
                } else {
                  hide_processing()
                  alert(data);
                }
              }
            });
          } else {
            //  alert();
          }
        } else {
          alert("Cannot Rename 2");
        }
        break;


      case 'download':

        var folder_exsits = document.querySelector("#"+id+" .folder");



        if (folder_exsits != null) {
        alert("Selected to download is folder");
          array = [];
          _switch = false;
          switchOff();
        } else {
          //alert("Selected to download is file");


        //  if (checked_checkboxes == 1) {
            path = $('.__path').val();
            
           window.location.href = "download.php?path="+path+"&filename="+array[0];
            array = [];
            _switch = false;
            switchOff();
        }
        break;


      case 'zip':
        zip_name = prompt("Enter Zip File Name");
        if (zip_name != null) {
          setTimeout(function() {
            switchOff();
          }, 100);
          $.ajax({
            url: "new_zip.php",
            type: "post",
            data: {
              array: array,
              path: path,
              name: zip_name,
            },
            beforeSend: function() {
              show_processing()
            },
            success: function (data, status) {
              // alert(status);

              if (data == "success") {
                // alert("Files zipped");

                re_reload($('.__path').val());


              } else {
                hide_processing();
                alert(data);
              }
              array = [];

            }
          });
        } else {}
        break;

      default:
        // code
      }

    }

  }
  function ctrl_switch(val) {
    _switch = val;

    if (_switch == false) {

      disable_all();
      document.querySelectorAll('._checkbox').forEach(box => {
        box.style.width = "0%"
      });

      document.querySelectorAll('.list-style').forEach(list => {
        list.classList.remove("hovered");


      });

      document.querySelectorAll(".list-style input[type='checkbox']").forEach(input => {
        input.checked = false;
      });

      document.querySelectorAll(".list-style label").forEach(lab=> {
        lab.style.background = "none";
        lab.innerHTML = "";
      });

    } else {

      document.querySelectorAll('._checkbox').forEach(box => {
        box.style.width = "8%"
      });
    }
  }

  let list_style = document.querySelectorAll('.list-style');

  var  _switch = false;

  // File and Folder Creation Function
  function create(abc) {
    path = $('.__path').val();
    if (abc == "folder") {
      let folder_name = prompt("Folder Name");

      if (folder_name != null) {
        if (state) {
          //   switchOn()
        } else {
          switchOff();
        }
        $.ajax({
          url: "create.php",
          type: "post",
          data: {
            folder: folder_name,
            create: "folder",
            path: (path).trim(),
          },
          beforeSend: function() {
            show_processing();
          },
          success: function(data, status) {
            //   alert(data);
            // window.location.href = "?path="+path;
            if (data == "success") {
              re_reload(path);

            } else {
              hide_processing();
              alert(data);
            }
          },
          error: function() {}
        });
      }
    }
    if (abc == "file") {

      let file_name = prompt("File Name");

      if (file_name != null) {

        if (state) {
          // switchOn()
        } else {
          switchOff();
        }

        $.ajax({
          url: "create.php",
          type: "post",
          data: {
            file: file_name,
            create: "file",
            path: (path).trim(),
          },
          beforeSend: function () {
            show_processing()
          },
          success: function(data, status) {
            if (data == "success") {
              re_reload(path);

            } else {
              hide_processing();
              alert(data);
            }

          },
          error: function() {}
        });
      }
    }

  }

  // Load / Reload Data Function
  function reload(e) {

    id = "list-style-"+e;

    e = document.getElementById("list-style-"+e);


    if (_switch == true) {

      let element = document.querySelector("#"+id+" input[type='checkbox']");


      // Adding checkbox functionality

      if (element.checked == false) {
        element.checked = true;
      } else {
        element.checked = false;
      }

      checked_checkboxes = $('input:checkbox:checked').length;


      if (checked_checkboxes == 1) {
        desired_line = checked_checkboxes+" item "
      } else {
        desired_line = checked_checkboxes+" items "
      }
      $('.item_selected').text(desired_line);
      //  To be used as event listener

      if (checked_checkboxes == 0) {
        // alert("Be disabled");
        disable_all();
      } else {
        //alert("enable All");
        enable_all();
      }

      if (element.checked == true) {

        document.querySelector("#"+id+"  label").style.background = "#F3A425";

        document.querySelector("#"+id+"  label").innerHTML = '<i class="fas fa-check"></i>';

        // My listener
  if (checked_checkboxes == 1) {

          enable_rename()

          final_id = document.querySelector('input[type="checkbox"]:checked').getAttribute("id");

          final_id = final_id.slice(6);

          check_this = document.querySelector("#list-style-"+final_id+" .folder");
          if (check_this == null) {
            // alert("picked right one");
            enable_download();
          }


        } else {
          if (checked_checkboxes == 0) {
            disable_all();
          } else {
            disable_download();
          }
          disable_rename();
        }
      } else {
        document.querySelector("#"+id+"  label").style.background = "none";

        document.querySelector("#"+id+"  label").innerHTML = '';

        // My listener
  
        if (checked_checkboxes == 1) {

          enable_rename()

          final_id = document.querySelector('input[type="checkbox"]:checked').getAttribute("id");

          final_id = final_id.slice(6);

          check_this = document.querySelector("#list-style-"+final_id+" .folder");
          if (check_this == null) {
            // alert("picked right one");
            enable_download();
          }


        } else {
          if (checked_checkboxes == 0) {
            disable_all();
          } else {
            disable_download();
          }
          disable_rename();
        }

      }




      if (!e.classList.contains("hovered")) {
        e.classList.add("hovered");
      } else {
        e.classList.remove("hovered");
      }

    } else {

      attr = e.getAttribute("data-path");
      type = e.getAttribute("data-type");


      switch (type) {
        case 'folder':
          re_reload(attr);
          break;

        case 'mp4':
          window.open(attr);

          break;

        case 'mkv':
          window.open(attr);
          break;

        case 'mp3':
          window.open(attr);
          break;

        case 'jpg':
          window.open(attr);

          break;

        case 'png':
          window.open(attr);
          break;

        case 'pdf':
          window.open(attr);
          break;

        case 'gif':
          window.open(attr);
          break;

        case 'svg':
          window.open(attr);
          break;

        case 'html':
          syntax = "html";
          window.open("editor.php?path="+attr+"&syntax="+syntax);
          break;

        case 'css':
          syntax = "css";
          window.open("editor.php?path="+attr+"&syntax="+syntax);
          break;

        case 'js':
          syntax = "javascript";
          window.open("editor.php?path="+attr+"&syntax="+syntax);
          break;

        case 'php':
          syntax = "php";
          window.open("editor.php?path="+attr+"&syntax="+syntax);
          break;

        case 'zip':
          confirmation = confirm("Unzip Selected Zip file");

          if (confirmation == true) {
            get_file_name = document.querySelector("#"+id+" ._fileName").innerText;

            setTimeout(function() {
              switchOff()
            }, 100);

            $.ajax({
              url: "unzip.php",
              type: "post",
              data: {
                file: get_file_name,
                path: $('.__path').val(),
              },
              beforeSend: function() {
                show_processing()
              },
              success: function (data, status) {
                //  alert(status);
                //    alert(data);
                if (data == "success") {
                  //alert("Files unzipped");

                  re_reload($('.__path').val());


                } else {
                  hide_processing();
                  alert(data);
                }
              }
            });

          } else {}
          break;


        default:
          // open in editor

          window.open("editor.php?path="+attr);
        }

      }

    }
    function re_reload(get_path) {
      if (!state) {
        setTimeout(function() {
          switchOff();
        }, 100);
      }
      $.ajax({
        url: "load.php",
        type: "get",
        data: {
          path: get_path,
        },
        beforeSend: function() {
          show_processing()
        },
        success: function(data, status) {

          if (data !== "error") {
            if (data === "empty") {
              $('.list').html(empty_folder);
            } else {
              $('.list').html(data);
            }
            $('.__path').val(get_path);
            hide_processing();
          } else {
            hide_processing();
            alert("Error Fetching Files");
          }

        }
      })
    }

    // Other  Filesystem Functions =>
    function move() {
      path_1 = $('.__path').val();
      do_task('move');
    }
    function move_to() {
      completeMove("move");
      path_2 = $('.__path').val();

      if (path_1 != "") {

        $.ajax({
          url: "move.php",
          type: "post",
          data: {
            array: move_files,
            path_1: (path_1).trim(),
            path_2: (path_2).trim(),
          },
          beforeSend: function () {
            show_processing();
          },
          success: function (data, status) {
            //  alert(data);
            if (data == "success") {
              //  alert("Files Deleted");
              re_reload($('.__path').val());

            } else {
              hide_processing()
              alert(data);
            }
            _switch = false;
            move_files = [];
            path_1 = "";
            path_2 = "";

          }
        });

      }

    }
    function copy() {
      path_1 = $('.__path').val();
      do_task('copy');

    }
    function paste() {
      completeCopy("paste")
      path_2 = $('.__path').val();
      if (path_1 != "") {
        $.ajax({
          url: "copy.php",
          type: "post",
          data: {
            array: copy_files,
            path_1: (path_1).trim(),
            path_2: (path_2).trim(),
          },
          beforeSend: function() {

            show_processing()
          },
          success: function (data, status) {
            if (data == "success") {
              re_reload($('.__path').val());

            } else {
              hide_processing();
              alert(data);
              alert("An Error Occurred");
            }
            _switch = false;
            copy_files = [];
            path_1 = "";
            path_2 = "";

          }
        });
      }

    }
    function previous() {


      path = $('.__path').val();
      if (path != "..") {

        if (path == parent_path) {
          current_path = parent_path;
        } else {
          allpath = path.substr(3);
          allpath = allpath.split("/");


          count = allpath.length;
          get_id = 0;

          if (allpath[0] == parent_path) {
            current_path = parent_path;
          } else {
            current_path = parent_path;
            previous_path = parent_path;

            while (get_id <= (count-1)) {
              current_path = current_path+"/"+allpath[get_id]
              get_id = get_id +1;
            }


          }
        }
        if (allpath.length == 1) {
          allpath = [];
          previous_path = parent_path;

        } else {
          allpath.pop();
          get_id = 0;
          count = allpath.length;

          while (get_id <= (count-1)) {
            previous_path = previous_path+"/"+allpath[get_id]
            get_id = get_id +1;
          }

        }

         //alert(current_path);
        //  alert(parent_path);
  //     alert(previous_path)

        re_reload(previous_path)
      } else {
        //alert("Currently at parent path");
      }
      
     
    }



    // Enable/Disable Functions
    var myHeight;

    function enable_download() {
      //alert("Download The File");
      $(".download").css("height", "40px");
      $(".download").css("opacity", "1");



      $(".list").css("height", `calc(100vh - 120px - 100px )`);
    }

    function  disable_download() {
      $(".download").css("height", "0px");
      $(".download").css("opacity", "0");



      $(".list").css("height", `calc(100vh - 120px - 60px)`);
      //   alert('disable download')
    }

    function  disable_rename() {
      try {
        $(".rename").addClass("disabled");
      }catch(e) {}
    }
    function enable_rename() {
      //  alert("Rename File");
      try {
        $(".rename").removeClass("disabled");
      }
      catch (e) {}

    }
    function enable_all() {
      $(".task_footer").css("transform", "translate(0px , 0%)");
      $(".task_footer").css("opacity", "1");


      $(".list").css("height", `calc(100vh - 120px - 60px)`);

      // alert("enable all");
      try {
        $('.task_footer').removeClass("disabled");
      }catch(e) {}

    }
    function disable_all() {

      $(".task_footer").css("transform", "translate(0px , 100%)");
      $(".task_footer").css("opacity", "0");


      $(".list").css("height", "calc(100vh - 120px)");
      //alert("disable_all");
      try {
        $(".task_footer").addClass("disabled")
      }catch(e) {}

    }



    function show_processing() {
      $('.processing').css('visibility', 'visible');
    }

    function hide_processing() {
      $('.processing').css('visibility', 'hidden');
    }


    function setCopy() {
      no =  $('input:checkbox:checked').length;
      if(no == 1){
      $('.item_selected').text(no+" item");
      }else{
      $('.item_selected').text(no+" items");
      }
      $('.file_task').css('visibility', 'visible');
      $('.file_task').css('transform', 'translate(0px , 0%)');
      $('.paste_here').css('visibility', 'visible');
      setTimeout(function() {
        switchOff();
      }, 10);
    }
    function completeCopy(finish_type) {
      $('.file_task').css('visibility', 'hidden');
      $('.file_task').css('transform', 'translate(0px , 100%)');
      $('.paste_here').css('visibility', 'hidden');

      if (finish_type == "cancel") {
        copy_files = [];
      } else {}
    }


    function setMove() {
         no =  $('input:checkbox:checked').length;
      if(no == 1){
      $('.item_selected').text(no+" item");
      }else{
      $('.item_selected').text(no+" items");
      }
      $('.file_task').css('visibility', 'visible');
      $('.file_task').css('transform', 'translate(0px , 0%)');
      $('.move_here').css('visibility', 'visible');

      setTimeout(function() {
        switchOff();
      }, 10);
    }
    function completeMove(finish_type) {
      $('.file_task').css('visibility', 'hidden');
      $('.file_task').css('transform', 'translate(0px , 100%)');
      $('.move_here').css('visibility', 'hidden');

      if (finish_type == "cancel") {
        move_files = [];
      } else {}
    }


    function check_path() {
      alert()
    }


let _select = true;


    $(document).bind("keydown", function(e) {
      /*
       CTRL + ALT + Z = Zip
       CTRL + ALT + N  = new file
       CTRL + N  = new folder
       CTRL + A = Select or Deselect all
       CTRL + I = rename
       CTRL + O = refresh 
       CTRL + H = Home
       CTRL + U = open file uploader
       CTRL + C = Copy
       CTRL + X = Cut
       CTRL + V = Paste
       CTRL + M = Mode
       del = Delete
      */
      if (e.which == 67 && event.ctrlKey) {
        if ($('.on_off').html() === " ON"){
         e.preventDefault()
          copy();
        }
      }
      if (e.which == 77 && event.ctrlKey) {
         e.preventDefault()
        if ($('.on_off').html() === " ON"){
           switchOff();
        }else{
          switchOn()
        }
      }
      if (e.which == 85 && event.ctrlKey) {
         e.preventDefault()
         modal_open();
      }
      if (e.which == 90 && event.ctrlKey) {
        
          checked_boxes = $('input:checkbox:checked').length;
        if(checked_boxes == 1 && $('.on_off').html() === " ON"){
         e.preventDefault()
         
          do_task('zip');
        }
      }
      if (e.which == 72 && event.ctrlKey) {
        e.preventDefault();
         re_reload("..");
      }
      if (e.which == 46) {
        checked_boxes = $('input:checkbox:checked').length;
        if(checked_boxes == 1 && $('.on_off').html() === " ON"){
          e.preventDefault();
          do_task('delete')
        }
      }
      if (e.which == 37 && event.ctrlKey) {
        e.preventDefault();
         previous()
      }
      if (e.which == 73 && event.ctrlKey) {
        checked_boxes = $('input:checkbox:checked').length;
        if(checked_boxes == 1 && $('.on_off').html() === " ON" ){
          e.preventDefault();
           do_task('rename');
        }
      }
      if (e.which == 79 && event.ctrlKey) {
         e.preventDefault();
         re_reload($('.__path').val());
      }
      if (e.which == 78 && event.ctrlKey && event.altKey) {
         e.preventDefault();
         create('folder')
      }
      if (e.which == 86 && event.ctrlKey) {
        if(copy_files.length != 0){
         e.preventDefault();
          paste();
        }
        if(move_files.length != 0){
          e.preventDefault()
          move_to()
        }
      }
      if (e.which == 70 && event.ctrlKey && event.altKey) {
         e.preventDefault();
         create('file')
      }
      if (e.which == 88 && event.ctrlKey) {
        if ($('.on_off').html() === " ON"){
         e.preventDefault()
           move()
        }
      }
      if (e.which == 65 && event.ctrlKey) {
        if ($('.on_off').html() === " ON") {
        e.preventDefault();
        
           if(_select){
             selectAll();
             _select = false;
           }else{
             deselectAll()
             _select =  true;
           }
        }

      }
      
    });
    
    function selectAll(){
         $('input:checkbox').prop('checked', true);

          $("label").css("background", "#F3A425");


          $("label").html('<i class="fas fa-check"></i>');
          try{
          $(".list-style").addClass("hovered");
          }catch(e){
           // console.log(e)
          }
          enable_all();
    }
    function deselectAll(){
         $('input:checkbox').prop('checked', false);
          $("label").css("background", "none");
          $("label").html('');
          
          try{
          $(".list-style").removeClass("hovered");
          }catch(e){
           // console.log(e)
          }
          disable_all();
    }
  