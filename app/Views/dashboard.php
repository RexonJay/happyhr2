<!-- Icon Cards-->
          <div class="row">
            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-primary o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                    <i class="fa fa-address-card"></i>
                  </div>
                  <div class="mr-5"><?= $EmployeeCount ?> Voters</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="<?php echo site_url('employee')?>">
                  <span class="float-left">View Details</span>
                  <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
                </a>
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
                <a class="card-footer text-white clearfix small z-1" href="<?php echo site_url('vote/votelist')?>">
                  <span class="float-left">View Details</span>
                  <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
                </a>
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
                <a class="card-footer text-white clearfix small z-1" href="<?php echo site_url('vote/voted_list')?>">
                  <span class="float-left">View Details</span>
                  <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
                </a>
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
                <a class="card-footer text-white clearfix small z-1" href="<?php echo site_url('vote/votednot_list')?>">
                  <span class="float-left">View Details</span>
                  <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
                </a>
              </div>
            </div>
          </div>

          
<?= view('dashboard_wide') ?>