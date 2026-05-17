<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row">
                    <div class="col-lg-6">

                    </div>
                </div>
 <br/>
 
<div id="infoMessage"><?php if(isset($message)){echo $message;} ?></div>

<table class="table table-hover table-bordered" id="sampleTable">
	<thead>
		<tr>
            <th>Description</th>
            <th>View</th>
		</tr>
    </thead>
    <tbody>
	<?php foreach ($record as $r):?>
		<tr>
            <td><?php echo htmlspecialchars($r->Description,ENT_QUOTES,'UTF-8');?></td>

            <td width="1%">
                <button type="button" class="btn btn-warning btn-s" onclick="window.location='<?php echo site_url("vote/votetrn_create/$r->id/$r->Description");?>'"><i class="fa fa-view"> View</i></button>
            </td>


            

		</tr>
	<?php endforeach;?>
	</tbody>
</table>
            </div>
        </div>                
    </div>                
</div>  
