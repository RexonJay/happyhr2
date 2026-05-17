
        <li class="nav-item <?php if(isset($dashboard)) { ?>active<?php } ?>">
          <a class="nav-link" href="<?php echo site_url('main?widescreen=false')?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>

        <li class="nav-item <?php if(isset($vote_list)) { ?>active<?php } ?>">
          <a class="nav-link" href="<?php echo site_url('vote/votelist')?>">
            <i class="app-menu__icon fa fa-address-book"></i>
            <span>Candidate Records</span></a>
        </li>

<!--         <li class="nav-item <?php if(isset($Candidate)) { ?>active<?php } ?>">
          <a class="nav-link" href="<?php echo site_url('candidate')?>">
            <i class="app-menu__icon fa fa-address-book"></i>
            <span>Candidate Registration</span></a>
        </li>
 -->
        <li class="nav-item <?php if(isset($employee_records)) { ?>active<?php } ?>">
          <a class="nav-link" href="<?php echo site_url('employee')?>">
            <i class="app-menu__icon fa fa-address-card"></i>
            <span>Employee Records</span></a>
        </li>

        <li class="nav-item <?php if(isset($office_records)) { ?>active<?php } ?>">
          <a class="nav-link" href="<?php echo site_url('office')?>">
            <i class="app-menu__icon fa fa-building"></i>
            <span>Office Records</span></a>
        </li>

        <li class="nav-item <?php if(isset($device)) { ?>active<?php } ?>">
          <a class="nav-link" href="<?php echo site_url('device')?>">
            <i class="app-menu__icon fa fa-laptop"></i>
            <span> Device Records</span></a>
        </li>

        <li class="nav-item <?php if(isset($precinct_records)) { ?>active<?php } ?>">
          <a class="nav-link" href="<?php echo site_url('precinct')?>">
            <i class="app-menu__icon fa fa-building"></i>
            <span>Precinct Records</span></a>
        </li>

        <li class="nav-item <?php if(isset($precinct_records2)) { ?>active<?php } ?>">
          <a class="nav-link" href="<?php echo site_url('precinct/records2')?>">
            <i class="app-menu__icon fa fa-building"></i>
            <span>Precinct Records 2</span></a>
        </li>

        <li class="nav-item <?php if(isset($reports)) { ?>active<?php } ?>">
          <a class="nav-link" href="<?php echo site_url('reports')?>">
            <i class="app-menu__icon fa fa-bar-chart"></i>
            <span>Reports</span></a>
        </li>

        <li class="nav-item">
        <a class="nav-link" href="<?php echo site_url('accountcontroller/changepassword')?>"><i class="app-menu__icon fa fa fa-key"></i><span> Change Password</span></a>
        </li>

        <li class="nav-item">
        <a class="nav-link" href="<?php echo site_url('logout')?>"><i class="app-menu__icon fa fa-sign-out"></i><span>Sign Out</span></a>
        </li>
