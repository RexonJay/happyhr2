


<?php  $user = auth()->user(); ?>



<li class="treeview <?php if(isset($masterdata)) { ?>is-expanded<?php } ?>"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-credit-card"></i><span class="app-menu__label">SPMS</span><i class="treeview-indicator fa fa-angle-right"></i></a>
    <ul class="treeview-menu">
      <li><a class="treeview-item <?php if(isset($masterdata_spms)) { ?>active<?php } ?>" href="<?php echo site_url('masterdata/spms')?>"><i class="icon fa fa-circle-o"></i> List</a></li>
    </ul>
</li>


<li class="treeview <?php if(isset($masterdata)) { ?>is-expanded<?php } ?>"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-credit-card"></i><span class="app-menu__label">Masterdata</span><i class="treeview-indicator fa fa-angle-right"></i></a>
    <ul class="treeview-menu">
      <li><a class="treeview-item <?php if(isset($masterdata_signatory)) { ?>active<?php } ?>" href="<?php echo site_url('masterdata/signatory')?>"><i class="icon fa fa-circle-o"></i> Signatory</a></li>
    </ul>
</li>

<li>
  <a class="app-menu__item <?php if(isset($DownloadableForms)) { ?>active<?php } ?>" href="<?php echo site_url('downloads')?>"><i class="app-menu__icon fa fa-download"></i><span class="app-menu__label"> Downloadable Forms</span></a>
</li>



<li>
  <a class="app-menu__item <?php if(isset($ClientSatisfactionSurvey)) { ?>active<?php } ?>" href="https://csm.gensantos.gov.ph/?officecode=200"><i class="app-menu__icon fa fa-star"></i><span class="app-menu__label"> Client Satisfaction Survey</span></a>
</li>

<li>
  <a class="app-menu__item <?php if(isset($change_password)) { ?>active<?php } ?>" href="<?php echo site_url('/logout')?>"><i class="app-menu__icon fa fa-sign-out"></i><span class="app-menu__label">Log Out</span></a>
</li>