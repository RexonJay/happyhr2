<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
<?php 

$agentService = \Config\Services::request()->getUserAgent();


if ($agentService->isBrowser())
{
    $agent = $agentService->getBrowser() . ' ' . $agentService->getVersion();
}
elseif ($agentService->isRobot())
{
    $agent = $agentService->getRobot();
}
elseif ($agentService->isMobile())
{
    $agent = $agentService->getMobile();
}
else
{
    $agent = 'Unidentified User Agent';
}

$MAC = $agent .
       $agentService->getPlatform() .
       service('request')->getIPAddress();
// echo $MAC;

?>

<div class="mb-3">
    <button type="button" class="btn btn-success" id="addDeviceBtn">
        <i class="fa fa-plus"></i> Add Device
    </button>
</div>

<!-- DEVICE MODAL -->
<div class="modal fade" id="deviceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="deviceForm">

                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa fa-plus"></i> Add Device
                    </h5>

                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

<div class="modal-body">

    <input type="hidden" name="id" id="device_id">

    <div class="form-group">
        <label>Device Name / Remarks</label>

        <input type="text"
               class="form-control"
               name="Remarks"
               id="Remarks"
               required>
    </div>

    <div class="form-group">

        <div class="form-check mb-2">
            <input type="checkbox"
                   class="form-check-input"
                   id="useCurrentMac">

            <label class="form-check-label" for="useCurrentMac">
                Use Current Device MAC
            </label>
        </div>

        <label>Device MAC Address</label>

        <input type="text"
               name="DeviceMacAddress"
               id="DeviceMacAddress"
               class="form-control"
               required>

    </div>

</div>

                <div class="modal-footer">

                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> Save
                    </button>

                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">
                        Close
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>


 <br/>
 
<div id="infoMessage"><?php if(isset($message)){echo $message;} ?></div>

<table class="table table-hover table-bordered" id="sampleTable">

	<thead>
		<tr>
            <th>Device</th>
            <th>Remarks</th>
            <th>Created By</th>
            <th>Created When</th>
            <th>Created Where</th>
            <th>Is Active?</th>
            <th></th>
		</tr>
    </thead>
    <tbody>
	
	</tbody>
</table>
            </div>
        </div>                
    </div>                
</div>  


    <!-- Data table plugin-->
    <script type="text/javascript" src="<?php echo base_url()."assets/"; ?>vendor/datatables/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()."assets/"; ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script>

var table;

$(document).ready(function () {

    table = $('#sampleTable').DataTable({
        pageLength: 25,
        ajax: {
            url: "<?= site_url('device/devicerecord') ?>",
            type: "POST"
        }
    });

    // OPEN MODAL
$('#addDeviceBtn').click(function () {

    $('#deviceForm')[0].reset();

    $('#device_id').val('');

    $('#useCurrentMac').prop('checked', true);

    $('#DeviceMacAddress')
        .val(CURRENT_MAC)
        .prop('readonly', true);

    $('.modal-title').html(
        '<i class="fa fa-plus"></i> Add Device'
    );

    $('#deviceModal').modal('show');

});

    // SAVE DEVICE
    $('#deviceForm').submit(function (e) {

        e.preventDefault();

        let formData = $(this).serialize();

        Swal.fire({
            title: 'Are you sure?',
            text: 'Save this device?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {

            if (result.isConfirmed) {

                Swal.fire({
                    title: 'Saving...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                $.post(
                    "<?= site_url('device/save') ?>",
                    formData,
                    function (res) {

                        if (res.status == 'success') {

                            Swal.fire(
                                'Success',
                                res.message,
                                'success'
                            );

                            $('#deviceModal').modal('hide');

                            table.ajax.reload(null, false);

                        } else {

                            Swal.fire(
                                'Error',
                                res.message,
                                'error'
                            );
                        }

                    },
                    'json'
                );
            }
        });
    });



});


// EDIT
function editDevice(id)
{
    $.post(
        "<?= site_url('device/devicebyid') ?>",
        {id:id},
        function(res){

            if(res.status == 'success')
            {
                let d = res.data;

                $('#device_id').val(d.id);
                $('#Remarks').val(d.Remarks);

                $('#DeviceMacAddress')
                    .val(d.DeviceMacAddress)
                    .prop('readonly', false);

                $('#useCurrentMac').prop('checked', false);

                // OPTIONAL:
                // auto-check if same as current MAC
                if(d.DeviceMacAddress == CURRENT_MAC)
                {
                    $('#useCurrentMac').prop('checked', true);

                    $('#DeviceMacAddress')
                        .prop('readonly', true);
                }

                $('.modal-title').html(
                    '<i class="fa fa-edit"></i> Edit Device'
                );

                $('#deviceModal').modal('show');
            }

        },
        'json'
    );
}


// ENABLE / DISABLE
function setStatus(id,status)
{
    let text = status == 1
        ? 'Enable this device?'
        : 'Disable this device?';

    Swal.fire({
        title: 'Are you sure?',
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
    }).then((result)=>{
        if(result.isConfirmed)
        {
            $.post(
                "<?= site_url('device/set_devicestatus_ajax') ?>",
                {
                    id:id,
                    Status:status
                },
                function(res){

                    if(res.status=='success')
                    {
                        Swal.fire(
                            'Success',
                            res.message,
                            'success'
                        );

                        table.ajax.reload(null,false);
                    }
                    else
                    {
                        Swal.fire(
                            'Error',
                            res.message,
                            'error'
                        );
                    }

                },
                'json'
            );
        }

    });
}



</script>

<script>

const CURRENT_MAC = "<?= $MAC ?>";

// CHECKBOX CHANGE
$('#useCurrentMac').change(function () {

    if ($(this).is(':checked')) {

        $('#DeviceMacAddress')
            .val(CURRENT_MAC)
            .prop('readonly', true);

    } else {

        $('#DeviceMacAddress')
            .val('')
            .prop('readonly', false);
    }

});

</script>