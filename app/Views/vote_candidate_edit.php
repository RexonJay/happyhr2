<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
               
 <br/>
 
<div id="infoMessage"><?php if(isset($message)){echo $message;} ?></div>

<?php foreach ($record as $r):?>

<?php echo form_open_multipart('vote/vote_candidate_edit_save'); ?>
                <div class="form-group">
                    <label class="control-label" for="inputDefault">Candidate Name</label>
                    <input type="text" class="form-control" id="Candidate" name="Candidate" required="" value="<?= $r->Candidate;?>">
                </div>

                <div class="form-group">
                    <label class="control-label" for="inputDefault">Partylist</label>
                    <input type="text" class="form-control" id="Partylist" name="Partylist" value="<?= $r->Partylist;?>">
                </div>

                <div class="form-group">
                    <img width="200" height="200" class="img-thumbnail" src="<?php echo base_url().'uploads/'.$r->CandidateImage;?>">
                </div>

                <div class="form-group">
                    <input type="file" name="userfile" id="userfile" size="20" />
                </div>
<?php echo form_hidden('id',$id); ?>
<?php echo form_hidden('Description',$Description); ?>
<?php echo form_hidden('votemstid',$votemstid); ?>
<?php echo form_submit(array('id' => 'submit', 'value' => '  Save  ', 'class' => 'btn btn-primary')); ?>
<?php echo form_close(); ?>

<?php endforeach;?>

            </div>
        </div>                
    </div>                
</div>  
