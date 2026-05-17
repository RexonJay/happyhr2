    <!-- Bootstrap core CSS-->
    
<?php
		if ($widescreen == 'true') {
			echo '<link href="' . base_url() . 'assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">';
		}
?>
<style>
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 10px;
}

.candidate-card {
    display: flex;
    align-items: center;
    padding: 6px; /* smaller */
    border: 1px solid #ddd;
    border-radius: 6px;
    background: #fff;
    font-size: 12px;
}

.candidate-card img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 8px;
}

.candidate-info {
    flex: 1;
}

.candidate-name {
    font-weight: bold;
    font-size: 12px;
}

.vote-count {
    font-size: 11px;
}

.progress {
    height: 5px;
    margin-top: 2px;
}

.winner {
    border: 2px solid #28a745;
    background: #eafaf1;
}

.card-body {
    padding: 10px !important;
}

<?php if ($widescreen == 'true') { ?>  
body {
    zoom: 0.8;
}
<?php } else{ ?>  
body {
    zoom: 1;
}
<?php } ?>  

</style>


      <div id="content-wrapper">

        <div class="container-fluid">
   
<?php if ($widescreen == 'true') { ?>         
        <br>
   <div class="row">
            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-primary o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                    <i class="fa fa-address-card"></i>
                  </div>
                  <div class="mr-5"><?= $EmployeeCount ?> Voters</div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-warning o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                    <i class="fa fa-address-book"></i>
                  </div>
                  <div class="mr-5"><?= $CandidateCount ?> Positions</div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-success o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                    <i class="fa fa-thumbs-o-up"></i>
                  </div>
                  <div class="mr-5"><?= $VoteCount ?> Already Voted!</div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-danger o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                    <i class="fa fa-exclamation-triangle"></i>
                  </div>
                  <div class="mr-5"><?= $NoVoteCount ?> Did not Vote!</div>
                </div>
              </div>
            </div>
          </div>

    <!-- <div class="row" >
    <div class="col-md-12 mb-2">
        <div class="progress" style="height:25px;">
        <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="<?= $TurnoutPercent ?>" aria-valuemin="0" aria-valuemax="100"
                    style="width:<?= $TurnoutPercent ?>%">
                    <b><?= $TurnoutPercent ?>% (<?= $VoteCount ?> out of <?= $EmployeeCount ?> voters)</b>
                </div>
            </div>
        </div>
    </div> -->
<?php } ?>


<div class="row" id="president-container">
  <div class="col-md-12 mb-2">
    <div class="bg-primary text-center text-white py-0">
      <b><FONT SIZE=2>PRESIDENT</FONT></b>
    </div>
  </div>


<?php 
$maxVotes = max(array_column($recordPresident, 'NumberOfVotes'));

foreach ($recordPresident as $r): 
?>

<div class="col-md-5 mb-2"> <!-- 👈 3 columns -->
    <div class="candidate-card  <?= $r->NumberOfVotes == $maxVotes ? 'winner' : '' ?>">

        <?php 
          $image = 'user.png';
          if (!empty($r->CandidateImage) && file_exists(FCPATH . 'uploads/candidates/' . $r->CandidateImage)) {
              $image = $r->CandidateImage;
          }
        ?>
        <img src="<?= base_url('uploads/candidates/'.$image); ?>">

        <div class="candidate-info">
            <div class="candidate-name">
                <?= $r->Candidate ?>
                <?= $r->NumberOfVotes == $maxVotes ? '🏆' : '' ?>
            </div>

            <div class="progress">
                <div class="progress-bar bg-info" 
                     style="width:<?= $r->NumberOfVotesPercent ?>%">
                </div>
            </div>

            <div class="vote-count">
                <?= $r->NumberOfVotes ?> (<?= number_format($r->NumberOfVotesPercent,1) ?>%)
            </div>
        </div>

    </div>

</div>

<?php endforeach; ?>



</div>



<div class="row">

  <div class="col-md-12 mb-2">
    <div class="bg-primary text-center text-white py-0">
      <b><FONT SIZE=2>VICE-PRESIDENT</FONT></b>
    </div>
  </div>
<?php 
$maxVotes = max(array_column($recordVicePresident, 'NumberOfVotes'));

foreach ($recordVicePresident as $r): 
?>

<div class="col-md-5 mb-2"> <!-- 👈 3 columns -->

    <div class="candidate-card <?= $r->NumberOfVotes == $maxVotes ? 'winner' : '' ?>">

        <?php 
          $image = 'user.png';
          if (!empty($r->CandidateImage) && file_exists(FCPATH . 'uploads/candidates/' . $r->CandidateImage)) {
              $image = $r->CandidateImage;
          }
        ?>
        <img src="<?= base_url('uploads/candidates/'.$image); ?>">

        <div class="candidate-info">
            <div class="candidate-name">
                <?= $r->Candidate ?>
                <?= $r->NumberOfVotes == $maxVotes ? '🏆' : '' ?>
            </div>

            <div class="progress">
                <div class="progress-bar bg-info" 
                     style="width:<?= $r->NumberOfVotesPercent ?>%">
                </div>
            </div>

            <div class="vote-count">
                <?= $r->NumberOfVotes ?> (<?= number_format($r->NumberOfVotesPercent,1) ?>%)
            </div>
        </div>

    </div>

</div>

<?php endforeach; ?>
</div>



<div class="row">

  <div class="col-md-12 mb-2">
    <div class="bg-primary text-center text-white py-0">
      <b><FONT SIZE=2>SECRETARY</FONT></b>
    </div>
  </div>
<?php 
$maxVotes = max(array_column($recordSecretary, 'NumberOfVotes'));

foreach ($recordSecretary as $r): 
?>

<div class="col-md-3 mb-2"> <!-- 👈 3 columns -->

    <div class="candidate-card <?= $r->NumberOfVotes == $maxVotes ? 'winner' : '' ?>">

        <?php 
          $image = 'user.png';
          if (!empty($r->CandidateImage) && file_exists(FCPATH . 'uploads/candidates/' . $r->CandidateImage)) {
              $image = $r->CandidateImage;
          }
        ?>
        <img src="<?= base_url('uploads/candidates/'.$image); ?>">

        <div class="candidate-info">
            <div class="candidate-name">
                <?= $r->Candidate ?>
                <?= $r->NumberOfVotes == $maxVotes ? '🏆' : '' ?>
            </div>

            <div class="progress">
                <div class="progress-bar bg-info" 
                     style="width:<?= $r->NumberOfVotesPercent ?>%">
                </div>
            </div>

            <div class="vote-count">
                <?= $r->NumberOfVotes ?> (<?= number_format($r->NumberOfVotesPercent,1) ?>%)
            </div>
        </div>

    </div>

</div>

<?php endforeach; ?>
</div>


<div class="row">

  <div class="col-md-12 mb-2">
    <div class="bg-primary text-center text-white py-0">
      <b><FONT SIZE=2>TREASURER</FONT></b>
    </div>
  </div>
<?php 
$maxVotes = max(array_column($recordTreasurer, 'NumberOfVotes'));

foreach ($recordTreasurer as $r): 
?>

<div class="col-md-3 mb-2"> <!-- 👈 3 columns -->

    <div class="candidate-card <?= $r->NumberOfVotes == $maxVotes ? 'winner' : '' ?>">

        <?php 
          $image = 'user.png';
          if (!empty($r->CandidateImage) && file_exists(FCPATH . 'uploads/candidates/' . $r->CandidateImage)) {
              $image = $r->CandidateImage;
          }
        ?>
        <img src="<?= base_url('uploads/candidates/'.$image); ?>">

        <div class="candidate-info">
            <div class="candidate-name">
                <?= $r->Candidate ?>
                <?= $r->NumberOfVotes == $maxVotes ? '🏆' : '' ?>
            </div>

            <div class="progress">
                <div class="progress-bar bg-info" 
                     style="width:<?= $r->NumberOfVotesPercent ?>%">
                </div>
            </div>

            <div class="vote-count">
                <?= $r->NumberOfVotes ?> (<?= number_format($r->NumberOfVotesPercent,1) ?>%)
            </div>
        </div>

    </div>

</div>

<?php endforeach; ?>
</div>



<div class="row">

  <div class="col-md-12 mb-2">
    <div class="bg-primary text-center text-white py-0">
      <b><FONT SIZE=2>AUDITOR</FONT></b>
    </div>
  </div>
<?php 
$maxVotes = max(array_column($recordAuditor, 'NumberOfVotes'));

foreach ($recordAuditor as $r): 
?>

<div class="col-md-3 mb-2"> <!-- 👈 3 columns -->

    <div class="candidate-card <?= $r->NumberOfVotes == $maxVotes ? 'winner' : '' ?>">

        <?php 
          $image = 'user.png';
          if (!empty($r->CandidateImage) && file_exists(FCPATH . 'uploads/candidates/' . $r->CandidateImage)) {
              $image = $r->CandidateImage;
          }
        ?>
        <img src="<?= base_url('uploads/candidates/'.$image); ?>">

        <div class="candidate-info">
            <div class="candidate-name">
                <?= $r->Candidate ?>
                <?= $r->NumberOfVotes == $maxVotes ? '🏆' : '' ?>
            </div>

            <div class="progress">
                <div class="progress-bar bg-info" 
                     style="width:<?= $r->NumberOfVotesPercent ?>%">
                </div>
            </div>

            <div class="vote-count">
                <?= $r->NumberOfVotes ?> (<?= number_format($r->NumberOfVotesPercent,1) ?>%)
            </div>
        </div>

    </div>

</div>

<?php endforeach; ?>
</div>




<div class="row">

  <div class="col-md-12 mb-2">
    <div class="bg-primary text-center text-white py-0">
      <b><FONT SIZE=2>BUSINESS MANAGER</FONT></b>
    </div>
  </div>
<?php 
$maxVotes = max(array_column($recordBusinessManager, 'NumberOfVotes'));

foreach ($recordBusinessManager as $r): 
?>

<div class="col-md-3 mb-2"> <!-- 👈 3 columns -->

    <div class="candidate-card <?= $r->NumberOfVotes == $maxVotes ? 'winner' : '' ?>">

        <?php 
          $image = 'user.png';
          if (!empty($r->CandidateImage) && file_exists(FCPATH . 'uploads/candidates/' . $r->CandidateImage)) {
              $image = $r->CandidateImage;
          }
        ?>
        <img src="<?= base_url('uploads/candidates/'.$image); ?>">

        <div class="candidate-info">
            <div class="candidate-name">
                <?= $r->Candidate ?>
                <?= $r->NumberOfVotes == $maxVotes ? '🏆' : '' ?>
            </div>

            <div class="progress">
                <div class="progress-bar bg-info" 
                     style="width:<?= $r->NumberOfVotesPercent ?>%">
                </div>
            </div>

            <div class="vote-count">
                <?= $r->NumberOfVotes ?> (<?= number_format($r->NumberOfVotesPercent,1) ?>%)
            </div>
        </div>

    </div>

</div>

<?php endforeach; ?>
</div>



<div class="row">

  <div class="col-md-12 mb-2">
    <div class="bg-primary text-center text-white py-0">
      <b><FONT SIZE=2>PUBLIC INFORMATION OFFICER</FONT></b>
    </div>
  </div>
<?php 
$maxVotes = max(array_column($recordPublicInformationOfficer, 'NumberOfVotes'));

foreach ($recordPublicInformationOfficer as $r): 
?>

<div class="col-md-3 mb-2"> <!-- 👈 3 columns -->

    <div class="candidate-card <?= $r->NumberOfVotes == $maxVotes ? 'winner' : '' ?>">

        <?php 
          $image = 'user.png';
          if (!empty($r->CandidateImage) && file_exists(FCPATH . 'uploads/candidates/' . $r->CandidateImage)) {
              $image = $r->CandidateImage;
          }
        ?>
        <img src="<?= base_url('uploads/candidates/'.$image); ?>">

        <div class="candidate-info">
            <div class="candidate-name">
                <?= $r->Candidate ?>
                <?= $r->NumberOfVotes == $maxVotes ? '🏆' : '' ?>
            </div>

            <div class="progress">
                <div class="progress-bar bg-info" 
                     style="width:<?= $r->NumberOfVotesPercent ?>%">
                </div>
            </div>

            <div class="vote-count">
                <?= $r->NumberOfVotes ?> (<?= number_format($r->NumberOfVotesPercent,1) ?>%)
            </div>
        </div>

    </div>

</div>

<?php endforeach; ?>
</div>

<div class="row">

  <div class="col-md-12 mb-2">
    <div class="bg-primary text-center text-white py-0">
      <b><FONT SIZE=2>BOARD OF TRUSTEES</FONT></b>
    </div>
  </div>
<?php 
$rank = 0;

foreach ($recordBoardOfTrustees as $r): 
$rank++;
?>

<div class="col-md-3 mb-2">

    <div class="candidate-card <?= $rank <= 10 ? 'winner' : '' ?>">
        <?php 
          $image = 'user.png';
          if (!empty($r->CandidateImage) && file_exists(FCPATH . 'uploads/candidates/' . $r->CandidateImage)) {
              $image = $r->CandidateImage;
          }
        ?>
        <img src="<?= base_url('uploads/candidates/'.$image); ?>">

        <div class="candidate-info">
            <div class="candidate-name">
                #<?= $rank ?> <?= $r->Candidate ?>
                <?= $rank <= 10 ? '🏆' : '' ?>
            </div>

            <div class="progress">
                <div class="progress-bar bg-info" 
                     style="width:<?= $r->NumberOfVotesPercent ?>%">
                </div>
            </div>

            <div class="vote-count">
                <?= $r->NumberOfVotes ?> (<?= number_format($r->NumberOfVotesPercent,1) ?>%)
            </div>
        </div>

    </div>

</div>

<?php endforeach; ?>
</div>


<script>
function loadDashboard() {

    $.ajax({
        url: "<?= site_url('main/dashboarddata') ?>",
        dataType: "json",
        success: function(res) {

            if (res.status !== 'success') return;

            let data = res.data;
console.log(data);
            Object.keys(data).forEach(position => {

                let candidates = data[position];
                if (!Array.isArray(candidates)) return;

                let maxVotes = Math.max(...candidates.map(c => parseInt(c.NumberOfVotes)));

                candidates.forEach(c => {

                    let card = $('.candidate-card[data-id="'+c.id+'"]');

                    if (card.length === 0) return;

                    // update votes
                    card.find('.vote-number').text(c.NumberOfVotes);

                    let percent = parseFloat(c.NumberOfVotesPercent || 0).toFixed(1);
                    card.find('.vote-percent').text(percent);

                    card.find('.vote-bar').css('width', percent + '%');

                    // highlight winner
                    if (c.NumberOfVotes == maxVotes) {
                        card.addClass('winner');
                        card.find('.winner-icon').text('🏆');
                    } else {
                        card.removeClass('winner');
                        card.find('.winner-icon').text('');
                    }
                });

            });
        }
    });
}


// load first time
loadDashboard();

// auto refresh every 60 seconds
setInterval(loadDashboard, 10000);

// setInterval(function(){
//     location.reload();
// }, 10000); // refresh every 10 seconds
</script>