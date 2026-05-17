<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row">
                    <!-- <div class="col-lg-6">
                        <form class="navbar-form" role="search" action="" method = "post">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search" value="<?=$mykeyword?>" name = "keyword"size="50px; ">
                            <div class="input-group-btn">
                            <button class="btn btn-default" type="submit" value = "Search"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        </form>       
                    </div> -->
                </div>
 <br/>
 
<div id="infoMessage"><?php if(isset($message)){echo $message;} ?></div>

<table class="table table-hover table-bordered" id="sampleTable">

	<thead>
		<tr>
            <th>ECODE</th>
            <th>LAST NAME</th>
            <th>FIRST NAME</th>
            <th>MIDDLE NAME</th>
            <th>BIRTHDAY</th>
            <th>OFFICE</th>
            <th>VOTED ALREADY?</th>
            <th>ACTION</th>
            <th>ACTION</th>
		</tr>
    </thead>
    <tbody>
	<?php foreach ($record as $r):?>
		<tr>
            <td><?php echo htmlspecialchars($r->ecode,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($r->last_name,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($r->first_name,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($r->middle_name,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($r->birthdate,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($r->Office,ENT_QUOTES,'UTF-8');?></td>

            <td>
                <?php echo htmlspecialchars($r->IsAlreadyVoted,ENT_QUOTES,'UTF-8');?>
                <?php if($r->IsAlreadyVoted!=="No") { ?>
                    <?php echo form_open('Employee/vote_imagepreview',array('target' => 'blank')); ?>
                    <?php echo form_hidden('ecode',$r->ecode); ?>
                    <?php echo form_button(array('name' => 'form_submit', 'type' => 'submit', 'class' => 'btn btn-primary btn-sm', 'content' => '<i class="fa fa-view"></i>View Photo')); ?>
                    <?php echo form_close(); ?>
                <?php } ?>

            </td>

            <td width="1%">
            <?php if($r->active==1) { ?>
                <?php echo form_open('employee/account_disable'); ?>
                <?php echo form_hidden('id',(isset($r->id)) ? $r->id : ''); ?>
                <?php echo form_button(array('name' => 'form_submit', 'type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'content' => '<i class="fa fa-ban"></i> Disable')); ?>
                <?php echo form_close(); ?>
            <?php } else { ?>
                <?php echo form_open('employee/account_enable'); ?>
                <?php echo form_hidden('id',(isset($r->id)) ? $r->id : ''); ?>
                <?php echo form_button(array('name' => 'form_submit', 'type' => 'submit', 'class' => 'btn btn-success btn-sm', 'content' => '<i class="fa fa-thumbs-up"></i> Enable')); ?>
                <?php echo form_close(); ?>
            <?php } ?>
            </td>
            <td width="1%">
            <?php if($r->IsAlreadyVoted!=="No") { ?>
                 <?php echo form_open('vote/vote_reset'); ?>
                <?php echo form_hidden('id',(isset($r->id)) ? $r->id : ''); ?>
                <?php echo form_button(array('name' => 'form_submit', 'type' => 'submit', 'class' => 'btn btn-warning btn-sm', 'content' => '<i class="fa fa-undo"></i> Reset Vote')); ?>
                <?php echo form_close(); ?>
            <?php } ?>
             </td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
            </div>
        </div>                
    </div>                
</div>  


    <!-- Data table plugin-->
    <script type="text/javascript" src="<?php echo base_url()."assets/"; ?>vendor/datatables/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()."assets/"; ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
