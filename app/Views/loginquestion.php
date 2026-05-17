<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>GSCGEA - VOTING SYSTEM</title>

  <!-- Bootstrap core CSS-->
  <link href="<?php echo base_url() . "assets/"; ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url() . "assets/"; ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet"
    type="text/css">

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url() . "assets/"; ?>css/sb-admin.css" rel="stylesheet">
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


  <style type="text/css">
    body {
        background-image: url('http://localhost:8181/gscgeavotingsystem/uploads/GSCGEAVOTE.png');
        background-repeat: repeat;
        background-position: center center;
        background-size: auto;
    }

    .card {
      border: none;
      border-radius: 15px;
      background: rgba(255, 255, 255, 0.95);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(5px);
    }

    .card-header {
      background: linear-gradient(135deg, #28a745, #218838);
      color: #fff;
      font-size: 20px;
      font-weight: bold;
      text-align: center;
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
    }

    .form-control {
      border-radius: 10px;
      padding: 12px;
      border: 1px solid #ddd;
      transition: 0.3s;
    }

    .form-control:focus {
      border-color: #28a745;
      box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
    }

    .form-group label {
      font-weight: 600;
      margin-bottom: 5px;
    }

    .form-group small {
      display: block;
      margin-top: 2px;
      color: #666;
    }

    #divPleaseAllow {
      background: #f8f9fa;
      border-radius: 12px;
      padding: 15px;
      border: 1px solid #ddd;
      margin-bottom: 15px;
    }

    #my_camera canvas {
      border-radius: 10px;
      border: 3px solid #28a745;
    }

    #results img {
      border-radius: 10px;
      border: 3px solid #28a745;
      margin-top: 10px;
    }

    .btn {
      border-radius: 10px;
      padding: 10px 15px;
      font-weight: 600;
      transition: 0.3s;
    }

    .btn-success {
      background: linear-gradient(135deg, #28a745, #20c997);
      border: none;
    }

    .btn-success:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
    }

    .btn-primary {
      background: linear-gradient(135deg, #007bff, #0056b3);
      border: none;
    }

    .btn-danger {
      background: linear-gradient(135deg, #dc3545, #b02a37);
    }

    .alert {
      border-radius: 10px;
      font-size: 14px;
    }

    .container {
      max-width: 500px;
      margin-top: 1px;
    }

    #nocamera {
      font-size: 16px;
      display: block;
      margin-top: 15px;
    }

    #nocameratutorial {
      border-radius: 10px;
      margin-top: 10px;
    }

    /* CAMERA + RESULT WRAPPER */
    #my_camera,
    #results {
      width: 100%;
      max-width: 640px;
      /* 👈 limit size on desktop */
      margin: 0 auto;
      /* center it */
      overflow: hidden;
      text-align: center;
    }

    /* CANVAS */
    #my_camera canvas {
      width: 100% !important;
      height: auto !important;
      border-radius: 10px;
    }

    /* CAPTURED IMAGE */
    #results img {
      width: 100%;
      height: auto;
      border-radius: 10px;
    }

    /* FIX CARD OVERFLOW ON SMALL SCREENS */
    .card {
      overflow: hidden;
    }

    .flatpickr-input {
    background-color: #fff !important;
    cursor: pointer;
}

.flatpickr-calendar {
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

    @media (max-width: 576px) {
      .container {
        padding: 10px;
      }

      .card {
        margin: 10px;
      }
    }

    th {
      background-color: #4CAF50;
      color: white;
    }
  </style>

  <!-- camera -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>

  <script src="<?php echo base_url() . "assets/"; ?>js/camera face/camvas.js"></script>
  <script src="<?php echo base_url() . "assets/"; ?>js/camera face/pico.js"></script>
  <script src="<?php echo base_url() . "assets/"; ?>js/camera face/lploc.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />

  <!-- <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css"> -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
  <style type="text/css">
    /*#results { padding:20px; border:1px solid; background:#ccc; }*/
  </style>

</head>

<body class="bg-dark">
<?= phpinfo(); ?>
  <div class="container">
    <div class="card">
      <div class="card-header">Security Question</div>
      <div class="card-body">
        <?php if (isset($message)) { ?>
          <!-- <div class="alert alert-warning" role="alert">
            <strong><?= $message; ?></strong></a>
          </div> -->
        <?php } ?>

        <?php if (!empty(validation_errors())) { ?>
          <div class="alert alert-danger" role="alert">
            <strong><?= validation_errors(); ?></strong></a>
          </div>
        <?php } ?>

        <form action="Auth/securityquestion_confirm" method="post" class="login-form">
          <div class="form-group" id="divMiddleName">
            <label>Middle Name </label><small> (If you do not have a middle name, enter your last name)</small>
            <div class="form-label-group">
              <input type="text" id="MiddleName" name="MiddleName" class="form-control" placeholder="MiddleName"
                required="required" autofocus="autofocus">
            </div>
          </div>




<div class="form-group" id="divBirthDay">
    <label>Birthday (Year/Month/Day)</label>

    <div class="row">

        <!-- YEAR -->
        <div class="col-4">
            <select id="birthYear" class="form-control" required></select>
        </div>

        <!-- MONTH -->
        <div class="col-4">
            <select id="birthMonth" class="form-control" required></select>
        </div>

        <!-- DAY -->
        <div class="col-4">
            <select id="birthDay" class="form-control" required></select>
        </div>

    </div>

    <input type="hidden" id="Birthday" name="Birthday">
</div>





          <!-- CAMERA -->
          <div id="divPleaseAllow">

            <div>
              <div class="text-center">
                <FONT COLOR="red"><label><B>AUTOMATIC FACE CAPTURING<B></label></font><BR>
                <label>(Please allow this site to use your Camera)</label>
              </div>
              <div id="my_camera"><canvas width=640 height=480></canvas></div>
              <div id="results"></div>
              <br />
              <input type="hidden" name="image" id="image" class="image-tag">
<div class="d-flex justify-content-center">
  <button type="button" class="btn btn-primary mb-2" onclick="retakePhoto()" id="btnReTakePhoto">
    <i class="fa fa-refresh" aria-hidden="true"></i> Retake Photo
  </button>
</div>
            </div>

          </div>

          <button id="submit" type="submit" class="btn btn-success btn-block mb-2 btn-lg">
            Continue
          </button>
        </form>


        <label id="nocamera">
          <font color="red"><B>NO CAMERA DETECTED! PLEASE ENABLE YOUR CAMERA TO PROCEED.</b></font>
        </label>
        <img id="nocameratutorial" src="https://media.giphy.com/media/KZvMDcVOHg9JAlyBe8/giphy.gif" width="300"
          height="300">
        <!-- 
          <br> -->
        <button type="button" class="btn btn-primary btn-block mb-2" onclick="location.reload()" id="btnReload"><i
            class="fa fa-refresh"></i> Reload this Page </button>

        <!-- <br> -->
<a href="<?= site_url('/logout'); ?>" 
   class="btn btn-default btn-block mb-2">
    <i class="fa fa-ban"></i> Cancel
</a>

      </div>
    </div>
  </div>

<!-- jQuery (ONLY ONE) -->
<script src="<?php echo base_url() . "assets/"; ?>vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap -->
<script src="<?php echo base_url() . "assets/"; ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Optional (keep if used elsewhere) -->
<script src="<?php echo base_url() . "assets/"; ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Flatpickr -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <!-- <script>
    $(function () {
      $('#datetimepicker1').datetimepicker({
        viewMode: 'years',
        format: 'YYYY-MM-DD'
      });
    });
  </script> -->


  <!-- Configure a few settings and attach camera -->
  <!-- <script language="JavaScript">
    Webcam.set({
        width: 370,
        height: 270,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
  
    Webcam.attach( '#my_camera' );
  
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            // HIDE CAMERA
            var x = document.getElementById("my_camera");
            x.style.display = "none";
            // SHOW SNAPSHOT
            var y = document.getElementById("results");
            y.style.display = "block";

            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img name="image2" and id="image2" src="'+data_uri+'"/>';

        } );
    }

    function reset_snapshot() {
        Webcam.snap( function(data_uri) {
            // SHOW CAMERA
            var x = document.getElementById("my_camera");
            x.style.display = "block";
            // HIDE SNAPSHOT
            var y = document.getElementById("results");
            y.style.display = "none";
        } );
    }
</script> -->

  <script type="text/javascript">

    var btnReTakePhoto = document.getElementById("btnReTakePhoto");
    var z = document.getElementById("submit");
    var a = document.getElementById("nocamera");
    var b = document.getElementById("nocameratutorial");
    var c = document.getElementById("divPleaseAllow");
    var d = document.getElementById("divMiddleName");
    var e = document.getElementById("divBirthDay");

    btnReTakePhoto.style.display = "none";
    z.style.display = "none";
    a.style.display = "none";
    b.style.display = "none";
    c.style.display = "none";
    d.style.display = "none";
    e.style.display = "none";

    function success(stream) {
      // The success function receives an argument which points to the webcam stream
      // document.getElementById('myVideo').src = stream; 
      //z.style.display = "block";
      a.style.display = "none";
      b.style.display = "none";
      c.style.display = "block";
      d.style.display = "block";
      e.style.display = "block";
      button_callback();
    }

    function error() {
      showReloadButton();
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Please allow this site to use your Camera.'
      });
      btnReTakePhoto.style.display = "none";
      z.style.display = "none";
      a.style.display = "block";
      b.style.display = "block";
      c.style.display = "none";
      d.style.display = "none";
      e.style.display = "none";
    }

    function showReloadButton() {
      document.getElementById("btnReload").style.display = "block";
    }

    function hideReloadButton() {
      document.getElementById("btnReload").style.display = "none";
    }

    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia ||
      navigator.msGetUserMedia;

    if (navigator.getUserMedia) {
      hideReloadButton();
      navigator.getUserMedia({ video: true, audio: false }, success, error);
    } else {
      error();
    }


  </script>

  <script>
    var initialized = false;
    var IsFaceCapture = 'false';
    function button_callback() {

      /*
        (0) check whether we're already running face detection
      */
      if (initialized)
        return; // if yes, then do not initialize everything again
      /*
        (1) initialize the pico.js face detector
      */




      var update_memory = pico.instantiate_detection_memory(5); // we will use the detecions of the last 5 frames
      var facefinder_classify_region = function (r, c, s, pixels, ldim) { return -1.0; };
      var cascadeurl = 'https://raw.githubusercontent.com/nenadmarkus/pico/c2e81f9d23cc11d1a612fd21e4f9de0921a5d0d9/rnt/cascades/facefinder';
      fetch(cascadeurl).then(function (response) {
        response.arrayBuffer().then(function (buffer) {
          var bytes = new Int8Array(buffer);
          facefinder_classify_region = pico.unpack_cascade(bytes);
          console.log('* facefinder loaded');
        })
      })
      /*
        (2) initialize the lploc.js library with a pupil localizer
      */
      var do_puploc = function (r, c, s, nperturbs, pixels, nrows, ncols, ldim) { return [-1.0, -1.0]; };
      var puplocurl = 'https://drone.nenadmarkus.com/data/blog-stuff/puploc.bin'
      fetch(puplocurl).then(function (response) {
        response.arrayBuffer().then(function (buffer) {
          var bytes = new Int8Array(buffer);
          do_puploc = lploc.unpack_localizer(bytes);
          console.log('* puploc loaded');
        })
      })
      /*
        (3) get the drawing context on the canvas and define a function to transform an RGBA image to grayscale
      */
      var ctx = document.getElementsByTagName('canvas')[0].getContext('2d');
      function rgba_to_grayscale(rgba, nrows, ncols) {
        var gray = new Uint8Array(nrows * ncols);
        for (var r = 0; r < nrows; ++r)
          for (var c = 0; c < ncols; ++c)
            // gray = 0.2*red + 0.7*green + 0.1*blue
            gray[r * ncols + c] = (2 * rgba[r * 4 * ncols + 4 * c + 0] + 7 * rgba[r * 4 * ncols + 4 * c + 1] + 1 * rgba[r * 4 * ncols + 4 * c + 2]) / 10;
        return gray;
      }
      /*
        (4) this function is called each time a video frame becomes available
      */
      var processfn = function (video, dt) {
        // render the video frame to the canvas element and extract RGBA pixel data
        ctx.drawImage(video, 0, 0);
        var rgba = ctx.getImageData(0, 0, 640, 480).data;
        // prepare input to `run_cascade`
        image = {
          "pixels": rgba_to_grayscale(rgba, 480, 640),
          "nrows": 480,
          "ncols": 640,
          "ldim": 640
        }
        params = {
          "shiftfactor": 0.1, // move the detection window by 10% of its size
          "minsize": 100,     // minimum size of a face
          "maxsize": 1000,    // maximum size of a face
          "scalefactor": 1.1  // for multiscale processing: resize the detection window by 10% when moving to the higher scale
        }
        // run the cascade over the frame and cluster the obtained detections
        // dets is an array that contains (r, c, s, q) quadruplets
        // (representing row, column, scale and detection score)
        dets = pico.run_cascade(image, facefinder_classify_region, params);
        dets = update_memory(dets);
        dets = pico.cluster_detections(dets, 0.2); // set IoU threshold to 0.2
        // draw detections
        for (i = 0; i < dets.length; ++i)
          // if face capture then exit
          if (IsFaceCapture == 'false') {
            console.log(IsFaceCapture);

            // check the detection score
            // if it's above the threshold, draw it
            // (the constant 50.0 is empirical: other cascades might require a different one)
            if (dets[i][3] > 50.0) {
              var r, c, s;
              //
              ctx.beginPath();
              ctx.arc(dets[i][1], dets[i][0], dets[i][2] / 2, 0, 2 * Math.PI, false);
              ctx.lineWidth = 3;
              ctx.strokeStyle = 'red';
              ctx.stroke();
              //
              // find the eye pupils for each detected face
              // starting regions for localization are initialized based on the face bounding box
              // (parameters are set empirically)
              // first eye
              r = dets[i][0] - 0.075 * dets[i][2];
              c = dets[i][1] - 0.175 * dets[i][2];
              s = 0.35 * dets[i][2];
              [r, c] = do_puploc(r, c, s, 63, image)
              if (r >= 0 && c >= 0) {
                ctx.beginPath();
                ctx.arc(c, r, 1, 0, 2 * Math.PI, false);
                ctx.lineWidth = 3;
                ctx.strokeStyle = 'red';
                ctx.stroke();
              }
              // second eye
              r = dets[i][0] - 0.075 * dets[i][2];
              c = dets[i][1] + 0.175 * dets[i][2];
              s = 0.35 * dets[i][2];
              [r, c] = do_puploc(r, c, s, 63, image)
              if (r >= 0 && c >= 0) {
                ctx.beginPath();
                ctx.arc(c, r, 1, 0, 2 * Math.PI, false);
                ctx.lineWidth = 3;
                ctx.strokeStyle = 'red';
                ctx.stroke();
              }

              // At this point, we already know that the human face is detected in webcam. So, We'll simply create an image from canvas that is displaying the webcam result in real-time.
              var can = document.getElementsByTagName('canvas')[0]
              var img = new Image();
              img.src = can.toDataURL('image/jpeg', 1.0);


              // HIDE CAMERA
              var x = document.getElementById("my_camera");
              x.style.display = "none";
              // SHOW SNAPSHOT
              var y = document.getElementById("results");
              y.style.display = "block";
              //SHOW CONTINUE BUTTON
              var z = document.getElementById("submit");
              z.style.display = "block";

              btnReTakePhoto.style.display = "block";

              $(".image-tag").val(img.src);
              document.getElementById('results').innerHTML = '<img name="image2" and id="image2" src="' + img.src + '"/>';


              // // Now, we will send the image to server and process it using PHP. Also, we have to save its path in MySQL database for later use.
              // var data = JSON.stringify({ image: img.src });
              // fetch("save.php",
              // {
              //  method: "POST",
              //  body: data
              // })
              // .then(function(res){ return res.json(); })
              // .then(function(data){ return alert( data.message ); })

              // This alert statement is a little hack to temporarily stop the execution of script.
              //alert('Face found!');
              IsFaceCapture = 'true';
            }
          }
      }
      /*
        (5) instantiate camera handling (see https://github.com/cbrandolino/camvas)
      */
      var mycamvas = new camvas(ctx, processfn);
      /*
        (6) it seems that everything went well
      */
      initialized = true;
    }

    function retakePhoto() {
      // Reset flags
      initialized = false;
      IsFaceCapture = 'false';

      // Show camera again
      document.getElementById("my_camera").style.display = "block";

      // Hide result
      document.getElementById("results").style.display = "none";
      document.getElementById("results").innerHTML = "";

      // Hide submit button again
      document.getElementById("submit").style.display = "none";

      // Clear image value
      document.getElementById("image").value = "";

      // Restart camera detection
      button_callback();
    }



  </script>

  <script>
    $(document).ready(function () {

      $('.login-form').on('submit', function (e) {
        e.preventDefault();

        Swal.fire({
          title: 'Continue?',
          text: "",
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Yes, continue'
        }).then((result) => {

          if (result.isConfirmed) {

            // ⏳ LOADING
            Swal.fire({
              title: 'Processing...',
              text: 'Please wait...',
              allowOutsideClick: false,
              didOpen: () => {
                Swal.showLoading();
              }
            });

            $.ajax({
              url: "<?= site_url('securityquestion/confirm') ?>",
              type: "POST",
              data: $(this).serialize(),
              dataType: "json",
              success: function (response) {


                if (response.status === 'success') {
                  // Swal.fire({
                  //   icon: 'success',
                  //   title: 'Success',
                  //   text: response.message
                  // }).then(() => {
                    window.location.href = response.redirect;
                    
                Swal.close();
                  // });
                }
                else if (response.status === 'locked') {
                  Swal.fire({
                    icon: 'warning',
                    title: 'Locked',
                    text: response.message
                  }).then(() => {
                                Swal.fire({
                        title: 'Redirecting...',
                        text: 'Please wait...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });


                    window.location.href = response.redirect;
                  });
                }
                else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                  });
                }
              },
              error: function () {
                Swal.fire({
                  icon: 'error',
                  title: 'Server Error',
                  text: 'Something went wrong.'
                });
              }
            });

          }

        });

      });

    });


$(document).ready(function () {

    // =========================
    // YEAR
    // =========================
    var currentYear = new Date().getFullYear();

    $('#birthYear').append('<option value="">Select Year</option>');

    for (var y = currentYear; y >= 1900; y--) {
        $('#birthYear').append(
            '<option value="' + y + '">' + y + '</option>'
        );
    }

    // =========================
    // MONTH
    // =========================
    var months = [
        { value: "01", text: "January" },
        { value: "02", text: "February" },
        { value: "03", text: "March" },
        { value: "04", text: "April" },
        { value: "05", text: "May" },
        { value: "06", text: "June" },
        { value: "07", text: "July" },
        { value: "08", text: "August" },
        { value: "09", text: "September" },
        { value: "10", text: "October" },
        { value: "11", text: "November" },
        { value: "12", text: "December" }
    ];

    $('#birthMonth').append('<option value="">Select Month</option>');

    months.forEach(function (m) {
        $('#birthMonth').append(
            '<option value="' + m.value + '">' + m.text + '</option>'
        );
    });

    // =========================
    // POPULATE DAYS
    // =========================
    function populateDays() {

        var year = $('#birthYear').val();
        var month = $('#birthMonth').val();

        $('#birthDay')
            .empty()
            .append('<option value="">Select Day</option>');

        if (year && month) {

            var days = new Date(year, month, 0).getDate();

            for (var d = 1; d <= days; d++) {

                let day = d < 10 ? '0' + d : d;

                $('#birthDay').append(
                    '<option value="' + day + '">' + d + '</option>'
                );
            }
        }

        // refresh select2
        $('#birthDay').trigger('change.select2');
    }

    // =========================
    // UPDATE HIDDEN
    // =========================
    function updateHidden() {

        var y = $('#birthYear').val();
        var m = $('#birthMonth').val();
        var d = $('#birthDay').val();

        if (y && m && d) {
            $('#Birthday').val(y + '-' + m + '-' + d);
        } else {
            $('#Birthday').val('');
        }
    }

    // =========================
    // EVENTS
    // =========================
    $('#birthYear, #birthMonth').on('change', function () {
        populateDays();
        updateHidden();
    });

    $('#birthDay').on('change', function () {
        updateHidden();
    });

    // =========================
    // SELECT2 SEARCHABLE
    // =========================
    $('#birthYear').select2({
        placeholder: "Select Year",
        width: '100%'
    });

    $('#birthMonth').select2({
        placeholder: "Select Month",
        width: '100%'
    });

    $('#birthDay').select2({
        placeholder: "Select Day",
        width: '100%'
    });

});



  </script>
</body>

</html>