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
    <link href="<?php echo base_url()."assets/"; ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url()."assets/"; ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url()."assets/"; ?>css/sb-admin.css" rel="stylesheet">

    <style type="text/css">
    body {
        background-image: url('http://localhost:8181/gscgeavotingsystem/uploads/GSCGEAVOTE.png');
        background-repeat: repeat;
        background-position: center center;
        background-size: auto;
    }

      th {
          background-color: #4CAF50;
          color: white;
      }
    </style>
    
  </head>

  <body class="bg-dark">

    <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header"><center><b>GSCGEA Online Voting System</b></center></div>
        <div class="card-body">
            <div class="form-group">
              <div class="container">
                <div class="jumbotron">
                  <h1>Successfully Registered! </h1>
                  <p>Thank you.</p>
                  <button type="button" class="btn btn-primary " onclick="window.location='<?php echo site_url("/logout");?>'">Back to Home Page</button>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url()."assets/"; ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url()."assets/"; ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url()."assets/"; ?>vendor/jquery-easing/jquery.easing.min.js"></script>

  </body>

</html>
