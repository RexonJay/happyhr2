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
            <!-- <th>MIDDLE NAME</th> -->
            <th>DATETIME VOTED</th>
            <th>REFERENCE#</th>
		</tr>
    </thead>
    <tbody>
	<?php foreach ($record as $r):?>
		<tr>
            <td><?php echo htmlspecialchars($r->ecode,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($r->last_name,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($r->first_name,ENT_QUOTES,'UTF-8');?></td>
            <!-- <td><?php //echo htmlspecialchars($r->middle_name,ENT_QUOTES,'UTF-8');?></td> -->
            <td><?php echo htmlspecialchars($r->CreatedWhen,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($r->ReferenceNumber,ENT_QUOTES,'UTF-8');?></td>
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
