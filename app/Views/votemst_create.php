<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
               
 <br/>
 
<div id="infoMessage"><?php if(isset($message)){echo $message;} ?></div>

<?php echo form_open('Vote/votemst_save'); ?>
                <div class="form-group">
                    <label class="control-label" for="inputDefault">Description</label>
                    <input type="text" class="form-control" id="Description" name="Description" required="">
                </div>

<?php echo form_submit(array('id' => 'submit', 'value' => '  Save  ', 'class' => 'btn btn-primary')); ?>
<?php echo form_close(); ?>

            </div>
        </div>                
    </div>                
</div>  
