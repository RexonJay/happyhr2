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

<br>

    <div class="container">
      <div class="card">
        <div class="card-header bg-primary"><center><b>PRESIDENT</b></center></div>
        <div class="card-body">


   <table class="table table-hover table-bordered">
    <tbody>
    <?php foreach ($recordPresident as $r):?>
        <tr>
            <td width="5%"><img width="100" height="100" class="rounded-circle" src="<?php echo base_url().'uploads/candidates/'.$r->CandidateImage;?>">
            </td>
            <td>

<div class="card">
  <div class="card-header"><b><?= $r->Candidate ?>
    <?php if($r->Partylist!==''){ ?>(<?php echo htmlspecialchars($r->Partylist,ENT_QUOTES,'UTF-8');?>)<?php } ?>
  </b></div>
  <div class="card-body">
<div class="progress">
  <div class="progress-bar progress-bar-striped" style="width:<?= $r->NumberOfVotesPercent ?>%"><?= $r->NumberOfVotesPercent ?>%</div>
</div>
  </div>
  <div class="card-footer"><?= $r->NumberOfVotes ?> Vote/s</div>
</div>

            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>

        </div>
      </div>
    </div>
<br>



    <div class="container">
      <div class="card">
        <div class="card-header bg-warning"><center><b>VICE-PRESIDENT</b></center></div>
        <div class="card-body">


   <table class="table table-hover table-bordered">
    <tbody>
    <?php foreach ($recordVicePresident as $r):?>
        <tr>
            <td width="5%"><img width="100" height="100" class="rounded-circle" src="<?php echo base_url().'uploads/candidates/'.$r->CandidateImage;?>">
            </td>
            <td>

<div class="card">
  <div class="card-header"><b><?= $r->Candidate ?><?php if($r->Partylist!==''){ ?>(<?php echo htmlspecialchars($r->Partylist,ENT_QUOTES,'UTF-8');?>)<?php } ?></b></div>
  <div class="card-body">
<div class="progress">
  <div class="progress-bar bg-warning progress-bar-striped" style="width:<?= $r->NumberOfVotesPercent ?>%"><?= $r->NumberOfVotesPercent ?>%</div>
</div>
  </div>
  <div class="card-footer"><?= $r->NumberOfVotes ?> Vote/s</div>
</div>

            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>

        </div>
      </div>
    </div>

<br>
    <div class="container">
      <div class="card">
        <div class="card-header bg-success"><center><b>SECRETARY</b></center></div>
        <div class="card-body">


   <table class="table table-hover table-bordered">
    <tbody>
    <?php foreach ($recordSecretary as $r):?>
        <tr>
            <td width="5%"><img width="100" height="100" class="rounded-circle" src="<?php echo base_url().'uploads/candidates/'.$r->CandidateImage;?>">
            </td>
            <td>

<div class="card">
  <div class="card-header"><b><?= $r->Candidate ?><?php if($r->Partylist!==''){ ?>(<?php echo htmlspecialchars($r->Partylist,ENT_QUOTES,'UTF-8');?>)<?php } ?></b></div>
  <div class="card-body">
<div class="progress">
  <div class="progress-bar bg-success progress-bar-striped" style="width:<?= $r->NumberOfVotesPercent ?>%"><?= $r->NumberOfVotesPercent ?>%</div>
</div>
  </div>
  <div class="card-footer"><?= $r->NumberOfVotes ?> Vote/s</div>
</div>

            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>

        </div>
      </div>
    </div>

<br>

    <div class="container">
      <div class="card">
        <div class="card-header bg-danger"><center><b>TREASURER</b></center></div>
        <div class="card-body">


   <table class="table table-hover table-bordered">
    <tbody>
    <?php foreach ($recordTreasurer as $r):?>
        <tr>
            <td width="5%"><img width="100" height="100" class="rounded-circle" src="<?php echo base_url().'uploads/candidates/'.$r->CandidateImage;?>">
            </td>
            <td>

<div class="card">
  <div class="card-header"><b><?= $r->Candidate ?><?php if($r->Partylist!==''){ ?>(<?php echo htmlspecialchars($r->Partylist,ENT_QUOTES,'UTF-8');?>)<?php } ?></b></div>
  <div class="card-body">
<div class="progress">
  <div class="progress-bar bg-danger progress-bar-striped" style="width:<?= $r->NumberOfVotesPercent ?>%"><?= $r->NumberOfVotesPercent ?>%</div>
</div>
  </div>
  <div class="card-footer"><?= $r->NumberOfVotes ?> Vote/s</div>
</div>

            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>

        </div>
      </div>
    </div>


<br>
    <div class="container">
      <div class="card">
        <div class="card-header bg-info"><center><b>AUDITOR</b></center></div>
        <div class="card-body">


   <table class="table table-hover table-bordered">
    <tbody>
    <?php foreach ($recordAuditor as $r):?>
        <tr>
            <td width="5%"><img width="100" height="100" class="rounded-circle" src="<?php echo base_url().'uploads/candidates/'.$r->CandidateImage;?>">
            </td>
            <td>

<div class="card">
  <div class="card-header"><b><?= $r->Candidate ?><?php if($r->Partylist!==''){ ?>(<?php echo htmlspecialchars($r->Partylist,ENT_QUOTES,'UTF-8');?>)<?php } ?></b></div>
  <div class="card-body">
<div class="progress">
  <div class="progress-bar bg-info progress-bar-striped" style="width:<?= $r->NumberOfVotesPercent ?>%"><?= $r->NumberOfVotesPercent ?>%</div>
</div>
  </div>
  <div class="card-footer"><?= $r->NumberOfVotes ?> Vote/s</div>
</div>

            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>

        </div>
      </div>
    </div>

<br>
    <div class="container">
      <div class="card">
        <div class="card-header bg-warning"><center><b>BUSINESSS MANAGER</b></center></div>
        <div class="card-body">


   <table class="table table-hover table-bordered">
    <tbody>
    <?php foreach ($recordBusinessManager as $r):?>
        <tr>
            <td width="5%"><img width="100" height="100" class="rounded-circle" src="<?php echo base_url().'uploads/candidates/'.$r->CandidateImage;?>">
            </td>
            <td>

<div class="card">
  <div class="card-header"><b><?= $r->Candidate ?><?php if($r->Partylist!==''){ ?>(<?php echo htmlspecialchars($r->Partylist,ENT_QUOTES,'UTF-8');?>)<?php } ?></b></div>
  <div class="card-body">
<div class="progress">
  <div class="progress-bar bg-warning progress-bar-striped" style="width:<?= $r->NumberOfVotesPercent ?>%"><?= $r->NumberOfVotesPercent ?>%</div>
</div>
  </div>
  <div class="card-footer"><?= $r->NumberOfVotes ?> Vote/s</div>
</div>

            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>

        </div>
      </div>
    </div>

<br>

    <div class="container">
      <div class="card">
        <div class="card-header bg-success"><center><b>PUBLIC INFORMATION OFFICER</b></center></div>
        <div class="card-body">


   <table class="table table-hover table-bordered">
    <tbody>
    <?php foreach ($recordPublicInformationOfficer as $r):?>
        <tr>
            <td width="5%"><img width="100" height="100" class="rounded-circle" src="<?php echo base_url().'uploads/candidates/'.$r->CandidateImage;?>">
            </td>
            <td>

<div class="card">
  <div class="card-header"><b><?= $r->Candidate ?><?php if($r->Partylist!==''){ ?>(<?php echo htmlspecialchars($r->Partylist,ENT_QUOTES,'UTF-8');?>)<?php } ?></b></div>
  <div class="card-body">
<div class="progress">
  <div class="progress-bar bg-success progress-bar-striped" style="width:<?= $r->NumberOfVotesPercent ?>%"><?= $r->NumberOfVotesPercent ?>%</div>
</div>
  </div>
  <div class="card-footer"><?= $r->NumberOfVotes ?> Vote/s</div>
</div>

            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>

        </div>
      </div>
    </div>

<br>

    <div class="container">
      <div class="card">
        <div class="card-header bg-danger"><center><b>BOARD OF TRUSTEES</b></center></div>
        <div class="card-body">


   <table class="table table-hover table-bordered">
    <tbody>
    <?php foreach ($recordBoardOfTrustees as $r):?>
        <tr>
            <td width="5%"><img width="100" height="100" class="rounded-circle" src="<?php echo base_url().'uploads/candidates/'.$r->CandidateImage;?>">
            </td>
            <td>

<div class="card">
  <div class="card-header"><b><?= $r->Candidate ?><?php if($r->Partylist!==''){ ?>(<?php echo htmlspecialchars($r->Partylist,ENT_QUOTES,'UTF-8');?>)<?php } ?></b></div>
  <div class="card-body">
<div class="progress">
  <div class="progress-bar bg-danger progress-bar-striped" style="width:<?= $r->NumberOfVotesPercent ?>%"><?= $r->NumberOfVotesPercent ?>%</div>
</div>
  </div>
  <div class="card-footer"><?= $r->NumberOfVotes ?> Vote/s</div>
</div>

            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>

        </div>
      </div>
    </div>



    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url()."assets/"; ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url()."assets/"; ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url()."assets/"; ?>vendor/jquery-easing/jquery.easing.min.js"></script>
    <script type="text/javascript">
      
setTimeout(function() {
  location.reload();
}, 210000);

    </script>
  </body>

</html>
