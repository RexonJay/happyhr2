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

<?php echo form_open('Search'); ?>
                <div class="form-group">
                    <label class="control-label" for="inputDefault">Enter Your Reference Number:</label>
                    <input type="text" class="form-control" id="ReferenceNumber" name="ReferenceNumber" required="">
                </div>
<?php echo form_submit(array('id' => 'submit', 'value' => '  Submit  ', 'class' => 'btn btn-primary btn-block')); ?>
<?php echo form_close(); ?>
<br>
<table class="table table-hover table-bordered table-responsive" id="sampleTable" width="100%" border="0" cellspacing="0" cellpadding="0">
    <thead>
        <tr>
            <th>Position</th>
            <th>Candidate</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($record as $r):?>
        <tr>
            <td><?php echo htmlspecialchars($r->Position,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($r->Candidate,ENT_QUOTES,'UTF-8');?></td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>

       <button type="button" class="btn btn-default btn-block" onclick="window.location='<?php echo site_url("/logout");?>'">Back to Home Page</button>     
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
