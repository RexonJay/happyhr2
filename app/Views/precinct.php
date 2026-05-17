<style>
    /* Make Select2 look like Bootstrap input */
    .select2-container {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--single {
        height: calc(2.875rem + 2px);
        /* same as form-control-lg */
        padding: 0.5rem 0.75rem;
        border: 1px solid #ced4da;
        border-radius: 0.3rem;
        display: flex;
        align-items: center;
    }

    .select2-selection__rendered {
        line-height: normal !important;
        padding-left: 0 !important;
    }

    .select2-selection__arrow {
        height: 100% !important;
        right: 10px !important;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row">
                    <div class="col-sm-6">
                        <button class="btn btn-primary" type="submit" id="addPrecinctBtn"><i class="fa fa-plus"></i> Add
                            Precinct</button>
                    </div>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
            <br />

            <div id="infoMessage"><?php if (isset($message)) {
                echo $message;
            } ?></div>

            <table class="table table-hover table-bordered" id="sampleTable">

                <thead>
                    <tr>
                        <th>PRECINCT NUMBER</th>
                        <th>OFFICE NAME</th>
                        <th>DEVICE NAME</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>


<!-- Modal -->
<div class="modal fade" id="precinctModal" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content shadow-lg border-0">

            <!-- HEADER -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fa fa-plus mr-2"></i> Add Precinct
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    &times;
                </button>
            </div>

            <!-- BODY -->
            <div class="modal-body px-4 py-3">
                <form id="precinctForm">
                    <!-- Precinct Number -->
                    <div class="form-group">
                        <label class="font-weight-bold">Precinct Name/Number</label>
                        <input type="text" name="PrecinctNumber" id="PrecinctNumber" class="form-control form-control-lg"
                            placeholder="Enter precinct name/number" required maxlength="35">
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Office Name</label>
                        <select name="OfficeCode" id="OfficeCode" class="form-control select2" style="width:100%">
                            <option value="">Select Office</option>
                            <?php foreach ($record_office as $o): ?>
                                <option value="<?= $o->OfficeCode ?>"><?= $o->OfficeName ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Device Name</label>
                        <select name="DeviceID" id="DeviceID" class="form-control select2" style="width:100%">
                            <option value="">Select Device</option>
                            <?php foreach ($record_device as $d): ?>
                                <option value="<?= $d->id ?>"><?= $d->Remarks ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer px-4 py-3">
                <button type="button" class="btn btn-light border" data-dismiss="modal">
                    Cancel
                </button>
                <button type="submit" class="btn btn-success px-4">
                    <i class="fa fa-save mr-1"></i> Submit
                </button>
            </div>

            <input type="hidden" name="precinct_id" id="precinct_id" readonly>
            </form>
        </div>
    </div>
</div>

<!-- Data table plugin-->
<script type="text/javascript"
    src="<?php echo base_url() . "assets/"; ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript"
    src="<?php echo base_url() . "assets/"; ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>


<script>
var table;
    $(document).ready(function () {
        table = $('#sampleTable').DataTable({
            ajax: {
                url: "<?= site_url('precinct/precinctrecord') ?>",
                type: "GET"
            }
        });

        $('.select2').select2({
            dropdownParent: $('#precinctModal'),
            width: '100%'
        });

        // OPEN MODAL
        $('#addPrecinctBtn').click(function () {
            $('#precinctModal').modal('show');
        });

        // SUBMIT FORM
        $('#precinctForm').submit(function (e) {
            e.preventDefault();

            let formData = $(this).serialize();
console.log(formData);
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to save this precinct?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, save it!'
            }).then((result) => {

                if (result.isConfirmed) {

                    // LOADING
                    Swal.fire({
                        title: 'Saving...',
                        text: 'Please wait...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    $.post("<?= site_url('precinct/save') ?>", formData, function (response) {

                        if (response.status === 'success') {

                            Swal.fire({
                                icon: 'success',
                                title: 'Saved!',
                                text: response.message
                            });

                            table.ajax.reload(null, false); // no page reset

                            // RESET FORM
                            // $('#precinctForm')[0].reset();
                            // $('.select2').val(null).trigger('change');
                            // $('#precinctModal').modal('hide');

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }

                    }, 'json').fail(function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error',
                            text: 'Something went wrong.'
                        });
                    });

                }
            });
        });

    });


function editPrecinct(id) {

    // RESET FORM FIRST
    $('#precinctForm')[0].reset();
    $('.select2').val(null).trigger('change');

    $.ajax({
        url: "<?= site_url('precinct/precinctbyid') ?>",
        type: "GET",
        data: { id: id },
        dataType: "json",
        success: function (res) {

            if (res.status === 'success') {

                let d = res.data;

                // SET VALUES
                $('#precinct_id').val(d.id);
                $('input[name="PrecinctNumber"]').val(d.PrecinctNumber);
                $('#OfficeCode').val(d.OfficeCode).trigger('change');
                $('#DeviceID').val(d.DeviceID).trigger('change');

                // CHANGE TITLE
                $('.modal-title').html('<i class="fa fa-edit"></i> Edit Precinct');

                $('#precinctModal').modal('show');

            } else {
                Swal.fire('Error', res.message, 'error');
            }
        }
    });
}

function deletePrecinct(id) {

    Swal.fire({
        title: 'Are you sure?',
        text: 'This will delete the precinct.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {

        if (result.isConfirmed) {

            Swal.fire({
                title: 'Deleting...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.post("<?= site_url('precinct/delete') ?>", { id: id }, function (res) {

                if (res.status === 'success') {

                    Swal.fire('Deleted!', res.message, 'success');
                    table.ajax.reload(null, false);

                } else {
                    Swal.fire('Error', res.message, 'error');
                }

            }, 'json');
        }
    });
}
</script>