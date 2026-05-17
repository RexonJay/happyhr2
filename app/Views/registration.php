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

<?php if(!empty(validation_errors())){ ?>
<div class="alert alert-danger" role="alert">
  <strong><?= validation_errors(); ?></strong></a>
</div>
<?php } ?>

    <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header"><center><b>REGISTRATION OF CANDIDATES</b></center></div>
        <div class="card-body">
          <?php echo form_open_multipart("Registration/save");?>
            <div class="form-group">
              <div class="form-label-group">
                <input type="text" id="EmpNo" name="EmpNo" class="form-control" placeholder="Employee Number" required="required" autofocus="autofocus">
                <label for="EmpNo">Employee Number</label>
              </div>
            </div>
           
           <div class="form-group">
              <div class="form-label-group">
                <input type="text" id="FirstName" name="FirstName" class="form-control" placeholder="First Name" required="required">
                <label for="FirstName">First Name</label>
              </div>
            </div>

            <div class="form-group">
              <div class="form-label-group">
                <input type="text" id="MiddleName" name="MiddleName" class="form-control" placeholder="Middle Name" required="required">
                <label for="MiddleName">Middle Name</label>
              </div>
            </div>

            <div class="form-group">
              <div class="form-label-group">
                <input type="text" id="LastName" name="LastName" class="form-control" placeholder="Last Name" required="required">
                <label for="LastName">Last Name</label>
              </div>
            </div>

            <div class="form-group">
              <div class="form-label-group">
                <select name="Position" class="form-control">
                  <option selected value="">-- Select Position--</option>
                  <option value="President">President</option>
                  <option value="Vice-President">Vice-President</option>
                  <option value="Secretary">Secretary</option>
                  <option value="Treasurer">Treasurer</option>
                  <option value="Auditor">Auditor</option>
                  <option value="Business Manager">Business Manager</option>
                  <option value="Public Information Officer">Public Information Officer</option>
                  <option value="Board of Trustees">Board of Trustees</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <div class="form-label-group">
                <input type="file" class="form-control" name="upl_files[]" ID='userfile' required="required"/>  
                <label for="upl_files">Attach Official Receipt</label>   
              </div>
            </div>

          <?php echo form_submit(array('id' => 'submit', 'value' => '  Submit  ', 'class' => 'btn btn-primary btn-block','i class'=>'fa fa-sign-in fa-lg fa-fw'));?>
          <?php echo form_close();?>

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
