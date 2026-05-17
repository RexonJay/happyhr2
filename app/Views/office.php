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
            <th>OFFICE CODE</th>
            <th>OFFICE NAME</th>
            <th>SHORT NAME</th>
            <th>ASSIGNED<BR>PRECINCTS</th>
            <th>ASSIGNED<BR>DEVICES</th>
            <th>ASSIGNED<BR>VOTERS</th>
		</tr>
    </thead>
    <tbody>
	<?php foreach ($record as $r):?>
		<tr>
            <td><?php echo htmlspecialchars($r->OfficeCode,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($r->OfficeName,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($r->ShortName,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($r->PrecinctNumber,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($r->PrecinctDevices,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($r->VoterCount,ENT_QUOTES,'UTF-8');?></td>
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
    <!-- Buttons CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<!-- JSZip (required for Excel) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<!-- Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            text: 'Print',
            extend: 'excelHtml5',
            text: 'Export Excel',
            className: 'btn btn-success'
        }
    ]
});</script>
