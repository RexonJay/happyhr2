<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- Modal for creating a new signatory -->
<div class="modal fade" id="signatoryModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form id="signatoryForm">
      <?= csrf_field(); ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create Signatory</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </div>

        <div class="modal-body">
          <div class="row g-3">

            <div class="col-md-6">
              <label class="form-label">Module</label>
              <select name="Module" class="form-control" required>
                <option value="DEFAULT">DEFAULT</option>
                <option value="BANK TRANSMITTAL">BANK TRANSMITTAL</option>
              </select>
            </div>

			<div class="col-md-6">
			  	<label class="form-label">Office</label>
				<select class="form-control" id="OfficeCode" name="OfficeCode" required>
				<option value="">-- Select Office --</option>
				<?php foreach ($record_office as $r): ?>
					<option value="<?= $r->OfficeCode ?>"><?= $r->ShortName .' (' . $r->OfficeCode . ')' ?></option>
				<?php endforeach; ?>
				</select>
			</div>
            <div class="col-md-6">
              <label>Prepared By</label>
              <input type="text" name="PreparedBy" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label>Prepared By Position</label>
              <input type="text" name="PreparedByPosition" class="form-control">
            </div>

            <div class="col-md-6">
              <label>Checked By</label>
              <input type="text" name="CheckedBy" class="form-control">
            </div>

            <div class="col-md-6">
              <label>Checked By Position</label>
              <input type="text" name="CheckedByPosition" class="form-control">
            </div>

            <div class="col-md-6">
              <label>Noted By</label>
              <input type="text" name="NotedBy" class="form-control">
            </div>

            <div class="col-md-6">
              <label>Noted By Position</label>
              <input type="text" name="NotedByPosition" class="form-control">
            </div>

            <div class="col-md-6">
              <label>Approved By</label>
              <input type="text" name="ApprovedBy" class="form-control">
            </div>

            <div class="col-md-6">
              <label>Approved By Position</label>
              <input type="text" name="ApprovedByPosition" class="form-control">
            </div>

          </div>
        </div>

        <div class="modal-footer">
           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			<button type="submit" class="btn btn-primary">Submit</button>
        </div>

      </div>
    </form>
  </div>
</div>



<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                
				<div class="row">
                        <div class="col-md-4">
							<form class="navbar-form" role="search" action="" method="get">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Search" value="<?=$mykeyword?>" name="keyword" size="50px;">
									<div class="input-group-btn">
										<button class="btn btn-default" type="submit" value="Search"><i class="fa fa-search"></i></button>
									</div>
								</div>
							</form>
                        </div>
                        <div class="col-md-4">
<button type="button" class="btn btn-primary"
        data-toggle="modal"
        data-target="#signatoryModal">
    Create Signatory
</button>
						</div>
						<div class="col-md-4 text-right">
						</div>
                </div>
<br/>
<div id="infoMessage"><?php if(isset($message)){echo $message;} ?></div>

<table class="table table-hover table-bordered" id="tblrecord">
	<thead>
		<tr>
            <th>Office</th>
            <th>Module</th>
            <th>Prepared By</th>
            <th>Checked By</th>
            <th>Noted By</th>
            <th>Approved By</th>
			<th>Action</th>
			<th>Action</th>
		</tr>
    </thead>
    <tbody>
<?php foreach ($record as $r):?>
		<tr id="row_<?= $r->id; ?>">
            <td><?= $r->OfficeName;?></td>
            <td><?= $r->Module;?></td>
            <td><?= $r->PreparedBy;?></td>
            <td><?= $r->CheckedBy;?></td>
            <td><?= $r->NotedBy;?></td>
            <td><?= $r->ApprovedBy;?></td>
			<td>
				<button type="button" class="btn btn-warning btn-sm edit-signatory-btn"
					data-id="<?= $r->id ?>"
					data-officename="<?= htmlspecialchars($r->OfficeName) ?>"
					data-module="<?= htmlspecialchars($r->Module) ?>"
					data-preparedby="<?= htmlspecialchars($r->PreparedBy) ?>"
					data-preparedbyposition="<?= htmlspecialchars($r->PreparedByPosition) ?>"
					data-checkedby="<?= htmlspecialchars($r->CheckedBy) ?>"
					data-checkedbyposition="<?= htmlspecialchars($r->CheckedByPosition) ?>"
					data-notedby="<?= htmlspecialchars($r->NotedBy) ?>"
					data-notedbyposition="<?= htmlspecialchars($r->NotedByPosition) ?>"
					data-approvedby="<?= htmlspecialchars($r->ApprovedBy) ?>"
					data-approvedbyposition="<?= htmlspecialchars($r->ApprovedByPosition) ?>"
				>
					<i class="fa fa-edit"></i> Edit
				</button> 
			</td>
			<td>
				<button type="button" class="btn btn-danger btn-sm delete-signatory-btn"
					data-id="<?= $r->id ?>"
					data-officename="<?= htmlspecialchars($r->OfficeName) ?>"
					data-module="<?= htmlspecialchars($r->Module) ?>"
					data-preparedby="<?= htmlspecialchars($r->PreparedBy) ?>"
					data-preparedbyposition="<?= htmlspecialchars($r->PreparedByPosition) ?>"
					data-checkedby="<?= htmlspecialchars($r->CheckedBy) ?>"
					data-checkedbyposition="<?= htmlspecialchars($r->CheckedByPosition) ?>"
					data-notedby="<?= htmlspecialchars($r->NotedBy) ?>"
					data-notedbyposition="<?= htmlspecialchars($r->NotedByPosition) ?>"
					data-approvedby="<?= htmlspecialchars($r->ApprovedBy) ?>"
					data-approvedbyposition="<?= htmlspecialchars($r->ApprovedByPosition) ?>"
				>
					<i class="fa fa-trash"></i> Delete
				</button> 
			</td>
		</tr>
<?php endforeach;?>
	</tbody>
</table>
            </div>
        </div>                
    </div>                
</div>


<!-- Edit Signatory Modal -->
<div class="modal fade" id="editSignatoryModal" tabindex="-1" role="dialog" aria-labelledby="editSignatoryModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="editSignatoryForm">
        <div class="modal-header">
          <h5 class="modal-title" id="editSignatoryModalLabel">Edit Signatory</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit_id">
          <div class="form-group">
            <label>Office Name</label>
            <input type="text" class="form-control" name="OfficeName" id="edit_OfficeName" readonly>
          </div>
          <div class="form-group">
            <label>Module</label>
            <input type="text" class="form-control" name="Module" id="edit_Module" readonly>
          </div>
          <div class="form-group">
            <label>Prepared By</label>
            <input type="text" class="form-control" name="PreparedBy" id="edit_PreparedBy">
          </div>
          <div class="form-group">
            <label>Prepared By Position</label>
            <input type="text" class="form-control" name="PreparedByPosition" id="edit_PreparedByPosition">
          </div>
          <div class="form-group">
            <label>Checked By</label>
            <input type="text" class="form-control" name="CheckedBy" id="edit_CheckedBy">
          </div>
          <div class="form-group">
            <label>Checked By Position</label>
            <input type="text" class="form-control" name="CheckedByPosition" id="edit_CheckedByPosition">
          </div>
          <div class="form-group">
            <label>Noted By</label>
            <input type="text" class="form-control" name="NotedBy" id="edit_NotedBy">
          </div>
          <div class="form-group">
            <label>Noted By Position</label>
            <input type="text" class="form-control" name="NotedByPosition" id="edit_NotedByPosition">
          </div>
          <div class="form-group">
            <label>Approved By</label>
            <input type="text" class="form-control" name="ApprovedBy" id="edit_ApprovedBy">
          </div>
          <div class="form-group">
            <label>Approved By Position</label>
            <input type="text" class="form-control" name="ApprovedByPosition" id="edit_ApprovedByPosition">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
document.querySelectorAll('.edit-signatory-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('edit_id').value = this.getAttribute('data-id');
        document.getElementById('edit_OfficeName').value = this.getAttribute('data-officename');
        document.getElementById('edit_Module').value = this.getAttribute('data-module');
        document.getElementById('edit_PreparedBy').value = this.getAttribute('data-preparedby');
        document.getElementById('edit_PreparedByPosition').value = this.getAttribute('data-preparedbyposition');
        document.getElementById('edit_CheckedBy').value = this.getAttribute('data-checkedby');
        document.getElementById('edit_CheckedByPosition').value = this.getAttribute('data-checkedbyposition');
        document.getElementById('edit_NotedBy').value = this.getAttribute('data-notedby');
        document.getElementById('edit_NotedByPosition').value = this.getAttribute('data-notedbyposition');
        document.getElementById('edit_ApprovedBy').value = this.getAttribute('data-approvedby');
        document.getElementById('edit_ApprovedByPosition').value = this.getAttribute('data-approvedbyposition');
        $('#editSignatoryModal').modal('show');
    });
});

document.getElementById('editSignatoryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Confirm',
        text: 'Are you sure you want to submit changes?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes'
    }).then(result => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Please wait...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading()
            });
            const formData = new FormData(document.getElementById('editSignatoryForm'));
            fetch('<?= site_url("masterdata/signatoryedit") ?>', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                Swal.fire({
                    title: data.status === 'success' ? 'Success' : 'Error',
                    text: data.message,
                    icon: data.status
                }).then(() => {
                    if (data.status === 'success') {
                        $('#editSignatoryModal').modal('hide');
                        setTimeout(() => location.reload(), 1500);
                    }
                });
            })
            .catch(() => {
                Swal.fire('Error', 'Failed to submit changes.', 'error');
            });
        }
    });
});
</script>



<script>
$('#signatoryForm').on('submit', function (e) {
    e.preventDefault();

    Swal.fire({
        title: 'Confirm Submission',
        text: 'Are you sure you want to save this signatory?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Save',
        cancelButtonText: 'Cancel'
    }).then((result) => {

        if (result.isConfirmed) {

            Swal.fire({
                title: 'Saving...',
                text: 'Please wait',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "<?= site_url('masterdata/signatoryinsert'); ?>",
                type: "POST",
                data: $('#signatoryForm').serialize(),
                dataType: "json",
                success: function (res) {

                    if (res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: res.message
                        }).then(() => {
                            location.reload();

							              Swal.fire({
                                title: 'Please wait...',
                                text: 'Reloading.',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: res.message
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong while saving.'
                    });
                }
            });

        }
    });
});

$(document).on('click', '.delete-signatory-btn', function () {

    var signatoryID = $(this).data('id');

    Swal.fire({
        title: 'Confirm Deletion',
        text: 'Are you sure you want to delete this signatory?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Delete',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#d33'
    }).then((result) => {

        if (result.isConfirmed) {

            Swal.fire({
                title: 'Deleting...',
                text: 'Please wait',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "<?= site_url('masterdata/signatorydelete'); ?>",
                type: "POST",
                data: { id: signatoryID },
                dataType: "json",
                success: function (res) {

                    if (res.status === 'success') {

                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                            text: res.message
                        }).then(() => {
                            $('#row_' + signatoryID).remove();
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: res.message
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong while deleting.'
                    });
                }
            });

        }
    });

});

</script>
