
<div class="row">
    <div class="col-md-12">
        <div class="tile">

            <table class="table table-hover table-bordered" id="sampleTable">

                <thead>
                    <tr>
                        <th>PRECINCT NUMBER</th>
                        <th>OFFICE NAME</th>
                        <th>DID NOT VOTE</th>
                        <th>ACTION</th>
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
<script type="text/javascript"
    src="<?php echo base_url() . "assets/"; ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript"
    src="<?php echo base_url() . "assets/"; ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script>
var table;

$(document).ready(function () {

    table = $('#sampleTable').DataTable({
        "pageLength": 25,
        ajax: {
            url: "<?= site_url('precinct/getprecinctrecord2') ?>",
            type: "POST"
        }
    });

    });

$(document).on('click', '.btnView', function () {

    var officecode = $(this).data('officecode');
    var officename = $(this).data('officename');

    $('#notVotedBody').html(`
        <tr>
            <td colspan="3" class="text-center">
                Loading...
            </td>
        </tr>
    `);

    $('.modal-title').text('Employees Who Did Not Vote - ' + officename);

    $('#notVotedModal').modal('show');

    $.ajax({
        url: "<?= site_url('precinct/notvotedemployees') ?>",
        type: "POST",
        data: {
            officecode: officecode
        },
        dataType: "json",
        success: function(response){

            let html = '';

            if(response.length > 0){

                $.each(response, function(i, row){

                    html += `
                        <tr>
                            <td>${row.ecode}</td>
                            <td>
                                ${row.last_name}, 
                                ${row.first_name} 
                                ${row.middle_name ?? ''}
                            </td>
                            <td>${row.Office}</td>
                        </tr>
                    `;
                });

            } else {

                html = `
                    <tr>
                        <td colspan="3" class="text-center">
                            No records found
                        </td>
                    </tr>
                `;
            }

            $('#notVotedBody').html(html);

        }
    });

});
</script>

<!-- Modal -->
<div class="modal fade" id="notVotedModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Employees Who Did Not Vote</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ECODE</th>
                            <th>NAME</th>
                            <th>OFFICE</th>
                        </tr>
                    </thead>
                    <tbody id="notVotedBody">

                    </tbody>
                </table>

            </div>

        </div>
    </div>
</div>