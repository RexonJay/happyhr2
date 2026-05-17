<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
               
 <br/>
 
<div id="infoMessage"><?php if(isset($message)){echo $message;} ?></div>

<?php echo form_open_multipart('vote/votetrn_save'); ?>
                <div class="form-group">
                    <label class="control-label" for="inputDefault">Vote Description</label>
                    <input type="text" class="form-control" id="Description" name="Description" readonly="" value="<?= $Description ?>">
                </div>


            </div>
        </div>                
    </div>                
</div>  


<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">


<h4 class="mb-3 line-head" id="buttons">Add Candidate</h4>

<table class="table table-hover table-bordered" id="sampleTable">
<tr>
<td><label class="control-label" for="inputDefault">Candidate (Last Name, First Name, Middle Name)</label></td>
<td><input type="text" class="form-control" id="Candidate" name="Candidate" required=""></td>
</tr>
<tr>
<td><label class="control-label" for="inputDefault">Partylist</label></td>
<td><input type="text" class="form-control" id="Partylist" name="Partylist" required=""></td>
</tr>
<tr>
<td><label class="control-label" for="inputDefault">Image</label></td>
<td><input type="file" name="userfile" id="userfile" size="20" accept="image/*" /></td>
</tr>
<tr>
<td>
</td>
<td>
    
<?php echo form_hidden('votemstid',$votemstid); ?>
<?php echo form_submit(array('id' => 'submit', 'value' => '  Add Candidate  ', 'class' => 'btn btn-primary btn-block')); ?>

</td>
</tr>
</table>

<?php echo form_close(); ?>

<br>

<h4 class="mb-3 line-head" id="buttons">List of Candidate/s</h4>
<table class="table table-hover table-bordered" id="sampleTable">
    <thead>
        <tr>
            <th>Candidate</th>
            <th>Partylist</th>
            <th>Image</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($record as $r):?>
        <tr>
            <td><?php echo htmlspecialchars($r->Candidate,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($r->Partylist,ENT_QUOTES,'UTF-8');?></td>
            <td><img width="200" height="200" class="img-thumbnail" src="<?php echo base_url().'uploads/candidates/'.$r->CandidateImage;?>">

            </td>

            <td width="1%">
                <?php echo form_open('vote/vote_candidate_edit'); ?>
                <?php echo form_hidden('id',(isset($r->id)) ? $r->id : ''); ?>
                <?php echo form_hidden('Description',(isset($Description)) ? $Description : ''); ?>
                <?php echo form_hidden('votemstid',(isset($votemstid)) ? $votemstid : ''); ?>
                <?php echo form_button(array('name' => 'form_submit', 'type' => 'submit', 'class' => 'btn btn-success btn-sm', 'content' => '<i class="fa fa-pencil-square-o"></i>Edit')); ?>
                <?php echo form_close(); ?>
            </td>
            
            <td width="1%"><?php echo anchor("", '<i class="fa fa-trash-o">Delete</i>','data-toggle="modal" data-target="#myModalDelete" onclick="showModal(this, '.$r->id.')" class="btn btn-danger btn-sm"'); ?></td>

        </tr>
    <?php endforeach;?>
    </tbody>
</table>

            </div>
        </div>                
    </div>                
</div>  
