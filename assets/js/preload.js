function drawer() {
  $('.set_list').css("left", "0px")
}

function close_drawer() {
  $('.set_list').css("left", "-100%")
}

let opened = false;
function regulator() {
  if (opened) {
    list_close();
    opened = false;
  } else {
    list_open();
    opened = true;
  }
}
function list_open() {
  $('.menu_items').css('height', '150px');
  $('.menu_items').css('opacity', '1');
  $('._span').html(`<i class="fas fa-times"></i>`);
}

function list_close() {
  $('.menu_items').css('height', '0px');
  $('.menu_items').css('opacity', '0');
  $('._span').html(`<i class="fas fa-ellipsis-v"></i>`);
}

$('.close').on("click", function() {
  modal_close();
});

function modal_close() {
  $('.modal').css("visibility", "hidden")
  $('.modal').css("backdrop-filter", "blur(0px)")
}
function modal_open() {
  $('.modal').css("visibility", "visible")
  $('.modal').css("backdrop-filter", "blur(3px)")
}

var state = true;
var  turnSwitch = document.getElementById('switch');

var Switch = document.querySelector('.switch-btn');
turnSwitch.onclick = ()=> {
  // Logic for operating Switch On/Off
  if (state) {
    switchOn()
  } else {
    switchOff();
  }
}
function switchOn () {
  // Code For Switch On
  $('.select-1').css("display", "inline");
  Switch.style.left = "20px";
  turnSwitch.style.background = "#F29F1B";
  _switch = true;
  ctrl_switch(true);
  state = false;
  $('.switch_text .on_off').text(' ON');
}
function switchOff() {
  // Code For Switch Off
  $('.select-1').css("display", "none");
  Switch.style.left = "0px";
  turnSwitch.style.background = "grey";
  _switch = false;
  ctrl_switch(false);
  state = true;
  $('.switch_text .on_off').text(' OFF');
}
function folder_tree(element) {
  oldElement = element;
  element = element.parentElement;
  path = element.getAttribute('data-path');


  $.ajax({
    url: "load_folders.php",
    type: "get",
    data: {
      path: path
    },
    beforeSend: function () {
      $(element).children('.load').css("visibility", "visible");
    },
    success: function (data, status) {
      //  alert(status);
      $(element).children('.load').css("visibility", "hidden");
      $(oldElement).toggleClass("open")
      if (data == "<ul></ul>") {
        html = `<ul>
        <li class='list_empty'>
        No More Directories
        </li>
        </ul>
        `;
        $(element).append(html);
      } else {
        $(element).append(data);
      }
      oldElement.setAttribute('onclick', 'open_close(this)');
    },
    error: function (error) {
      alert(error);
    }
  });
}

function open_close(element) {
  oldElement = element;
  element = element.parentElement;
  element = $(element).children('ul')
  element.toggleClass("active");
  $(oldElement).toggleClass("open");

}


/* -- Upload --*/

let upload_url = "chunk_uploader.php?path=..";


let uploader = new plupload.Uploader({
  browse_button: 'browse-btn',
  url: upload_url,
  chunk_size: '2mb',
  max_retries: 2,
  filters: {
    max_file_size: '5000mb',
    mime_types: [{
      title: "Image files",
      extensions: "jpg,gif,png,svg"
    },
      {
        title: "Zip files",
        extensions: "zip"
      },
      {
        title: "Video files",
        extensions: "mp4,mkv"
      },
      {
        title: "Code Files",
        extensions: "php,js,html,css"
      }]
  }
});

uploader.init();


uploader.bind('BeforeUpload', function() {
  $('.progress').css('display', 'block');
  upload_url = "chunk_uploader.php?path="+$('.__path').val();
  uploader.setOption('url', upload_url);
});

uploader.bind('FilesAdded', function(up, files) {
  let files_html = '';
  plupload.each(files, function(file) {
    files_html += '<li id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></li>';
  });
  document.getElementById('filelist').innerHTML += files_html;
});

uploader.bind('UploadProgress', function(up, file) {

  //document.getElementById('b').innerText = percentage_uploaded
  document.getElementById('progress').value = file.percent;
  document.getElementById('percent_complete').innerText = file.percent;

  if (file.percent === 100) {
    //alert('_+')

    setTimeout(function() {
      document.querySelector('.progress').innerHTML = "Files uploaded successfully ! ";
      document.querySelector('.reset').classList.remove('disabled-btn');
      re_reload($('.__path').val())
    }, 1000);
  }

})

uploader.bind('Error', function(up, err) {


  document.getElementById('console').style.display = "block";

  document.getElementById('console').innerHTML = "Error #" + err.code + ": " + err.message + "\n";
});

document.getElementById('start-upload').onclick = function() {


  if (uploader.files.length != 0) {
    document.querySelector('.reset').classList.add('disabled-btn');
    uploader.start();
  } else {
    alert("Zero files selected ! ")
  }
};


function upload_set() {



  document.querySelector('.progress').innerHTML = `
  <progress id="progress" min="0" max="100" value="0"></progress>
  <span id="percent_complete" class="percent">0</span>
  <span>%</span>
  `;
  document.querySelector('.progress').style.display = "none";


  document.getElementById('console').style.display = "none";

  document.getElementById('console').innerHTML = "";

  document.getElementById('filelist').innerHTML = "";
  document.getElementById('b').innerHTML = "";
  uploader.splice();

}