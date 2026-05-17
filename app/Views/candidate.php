<!-- <div class="alert alert-danger" role="alert">
  <strong>Please Read!</strong> Data Updated As Of <?= date('Y-m-d H:i:s'); ?></a>.
</div>
 -->

 <?php

 ?>

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                    <div class="col-md-12">
                     <div class="row">
                        <div class="col-md-6">
                            <form class="navbar-form" role="search" action="" method = "post">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search" value="<?=$mykeyword?>" name = "keyword"size="50px; ">
                                    <div class="input-group-btn">
                                    <button class="btn btn-default " type="submit" value = "Search"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                       
                     </div>
                    </div>
 <br/>
 
<div id="infoMessage"><?php if(isset($message)){echo $message;} ?></div>

<h4 class="mb-3 line-head" id="buttons">Pending Request (<?= count($record); ?>)</h4>

<table class="table table-hover table-bordered table-responsive" id="sampleTable" width="100%" border="0" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
            <th>ECODE</th>
            <th>FIRST NAME</th>
            <th>MIDDLE NAME</th>
            <th>LAST NAME</th>
            <th>POSITION</th>
            <th>DATE REGISTERED</th>
            <th>STATUS</th>
            <th>ATTACHMENT</th>
            <th>APPROVED</th>
            <th>DISAPPROVE</th>
		</tr>
    </thead>
    <tbody>
	<?php foreach ($record as $r):?>
		<tr>
            <td><?php echo htmlspecialchars($r->EmpNo,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($r->FirstName,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($r->MiddleName,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($r->LastName,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($r->Position,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($r->CreatedWhen,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($r->Status,ENT_QUOTES,'UTF-8');?></td>
            <td>
                <?php 
                    $this->db->select("Image", false);
                    $this->db->from("tblattachment");
                    $this->db->where("ReferenceID",$r->id);
                    $trade1 = $this->db->get();
                ?>


                <?php foreach ($trade1->result() as $row) {   ?>
                <a href="#" class="pop">
                  <img class="zoom" id="myImg" src="<?php echo base_url().'uploads/candidates/'.$row->Image;?>" alt="Snow" style="width:100%;max-width:300px"></a>
                <?php  } ?>
            </td>
            <td width="1%">
                <?php echo form_open('candidate/registration_approved'); ?>
                <?php echo form_hidden('id',$r->id); ?>
                <?php echo form_hidden('EmpNo',$r->EmpNo); ?>
                <?php echo form_hidden('Position',$r->Position); ?>
                <?php echo form_button(array('name' => 'form_submit', 'type' => 'submit', 'class' => 'btn btn-success btn-sm', 'content' => '<i class="fa fa-thumbs-o-up"></i>Approve')); ?>
                <?php echo form_close(); ?>
            </td>
            <td width="1%">
                <?php echo form_open('candidate/registration_disapproved'); ?>
                <?php echo form_hidden('id',$r->id); ?>
                <?php echo form_button(array('name' => 'form_submit', 'type' => 'submit', 'class' => 'btn btn-warning btn-sm', 'content' => '<i class="fa fa-thumbs-o-down"></i>Disapprove')); ?>
                <?php echo form_close(); ?>
            </td>

		</tr>
	<?php endforeach;?>
	</tbody>
</table>
            </div>
        </div>                
    </div>                
</div>  



<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">

<h4 class="mb-3 line-head" id="buttons">Approved/Disapproved Request (<?= count($recordaction); ?>)</h4>

<table class="table table-hover table-bordered table-responsive" id="sampleTable" width="100%" border="0" cellspacing="0" cellpadding="0">
    <thead>
        <tr>
            <th>ECODE</th>
            <th>FIRST NAME</th>
            <th>MIDDLE NAME</th>
            <th>LAST NAME</th>
            <th>POSITION</th>
            <th>DATE REGISTERED</th>
            <th>STATUS</th>
            <th>ATTACHMENT</th>
            <th>ACTION BY</th>
            <th>CANCEL</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($recordaction as $r):?>
        <tr>
            <td><?php echo htmlspecialchars($r->EmpNo,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($r->FirstName,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($r->MiddleName,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($r->LastName,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($r->Position,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($r->CreatedWhen,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($r->Status,ENT_QUOTES,'UTF-8');?></td>
            <td>
                <?php 
                    $this->db->select("Image", false);
                    $this->db->from("tblattachment");
                    $this->db->where("ReferenceID",$r->id);
                    $trade1 = $this->db->get();
                ?>


                <?php foreach ($trade1->result() as $row) {   ?>
                <a href="#" class="pop">
                  <img class="zoom" id="myImg" src="<?php echo base_url().'uploads/candidates/'.$row->Image;?>" alt="Snow" style="width:100%;max-width:300px"></a>
                <?php  } ?>
            </td>
            <td><?php echo ($r->ApprovedBy=='') ? $r->DisapprovedBy : $r->ApprovedBy; ?></td>

            <td width="1%">
                <?php echo form_open('Candidate/registration_cancelaction'); ?>
                <?php echo form_hidden('id',$r->id); ?>
                <?php echo form_hidden('EmpNo',$r->EmpNo); ?>
                <?php echo form_hidden('Position',$r->Position); ?>
                <?php echo form_button(array('name' => 'form_submit', 'type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'content' => '<i class="fa fa-ban"></i>Cancel Action')); ?>
                <?php echo form_close(); ?>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
            </div>
        </div>                
    </div>                
</div> 

<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">              
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <img src="" class="imagepreview" style="width: 100%;" >
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    
$(function() {
        $('.pop').on('click', function() {
            $('.imagepreview').attr('src', $(this).find('img').attr('src'));
            $('#imagemodal').modal('show');   
        });     
});

</script>
