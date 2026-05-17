<style type="text/css">
  
  label {display:block; width:x; height:y; text-align:right;}

</style>


<div class="row">
        <div class="col-md-12">

<div class="row">

        <div class="col-md-12">
          <div class="tile">
            <!-- <h3 class="tile-title">Report</h3> -->
            <div class="tile-body">

<?php echo form_open('reports/generate', ['target' => '_blank']); ?>

                <div class="form-group row">
                  <label class="control-label col-md-3">Select Report</label>
                  <div class="col-md-8">
                    <select name="ReportType" class="form-control">
                    <option value="Vote Result">Vote Result</option>
                    <option value="Precinct Online">Precinct Report</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-md-3"></label>
                  <div class="col-md-8">
                  	<button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Generate</button>
                  </div>
                </div>

<?php echo form_close(); ?>


            </div>
          </div>
        </div>  




</div> 

  </div>           
</div>   