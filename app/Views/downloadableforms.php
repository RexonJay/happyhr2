<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                
				<div class="row">
                        <div class="col-md-4">
							<form class="navbar-form" role="search" action="" method="post">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Search" value="<?=$mykeyword?>" name="keyword" size="50px;">
									<div class="input-group-btn">
										<button class="btn btn-default" type="submit" value="Search"><i class="fa fa-search"></i></button>
									</div>
								</div>
							</form>
                        </div>
                        <div class="col-md-4">
							<?php 
								$user = auth()->user();
								if ($user->office_code == '200') {
							?>
                            	<button type="button" class="btn btn-primary" onclick="window.location='<?php echo site_url("Downloads/downloads_create");?>'">Add New Downloadable Form/Link</button>
							<?php } ?>
						</div>
                </div>
<br/>
<div id="infoMessage"><?php if(isset($message)){echo $message;} ?></div>

<table class="table table-hover table-bordered table-responsive" id="sampleTable">
	<thead>
		<tr>
            <th>Category</th>
            <th>File Name</th>
            <th>Remarks</th>
            <th>Action</th>
			<?php if(auth()->user()->office_code == '200'){ ?>
            	<th>Action</th>
			<?php } ?>
		</tr>
    </thead>
    <tbody>
<?php foreach ($record as $r):?>
		<tr>
            <td><?= $r->Category;?></td>
            <td><?= $r->FileName;?></td>
            <td><?= $r->Remarks;?></td>
            <td>
            <?php if($r->Type == 'link'){?>
                <a href="<?= $r->FilePath ?>" target="_blank"><i class="fa fa-hand-o-right"> Click Link</i></a>
            <?php } else if($r->Type == 'download'){ ?>
                <a href="<?php echo base_url().'uploads/downloadableforms/'. $r->FilePath?>" target="_blank"><i class="fa fa-download fa-sm"> Download</i></a>
            <?php } ?>
            </td>
<?php if(auth()->user()->office_code == '200'){ ?>
			<td>
				<form action="<?= site_url('Downloads/downloads_delete') ?>" method="post">
					<input type="hidden" name="id" value="<?= $r->id ?>">
					<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Remove</button>
				</form>
			</td>
<?php } ?>
		</tr>
<?php endforeach;?>
	</tbody>
</table>
            </div>
        </div>                
    </div>                
</div>

