<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GSCGEA - VOTING SYSTEM</title>

    <!-- Bootstrap core CSS-->
    <link href="<?php echo base_url().'assets/'; ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url().'assets/'; ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url().'assets/'; ?>css/sb-admin.css" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<style>
/* Hide radio buttons */
.candidate-input {
    display: none;
}

/* Grid layout */
.candidate-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 15px;
}

/* Card style */
.candidate-card {
    background: #fff;
    border-radius: 15px;
    padding: 15px;
    text-align: center;
    cursor: pointer;
    transition: all 0.25s ease;
    border: 2px solid #eee;
    position: relative;
}

/* Hover effect */
.candidate-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}

/* Selected state */
.candidate-input:checked + .candidate-card {
    background: #28a745;
    color: #fff;
    border-color: #28a745;
    transform: scale(1.03);
    box-shadow: 0 8px 20px rgba(40,167,69,0.4);
}

/* Image */
.candidate-card img {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 10px;
    border: 3px solid #ddd;
}

/* Selected image border */
.candidate-input:checked + .candidate-card img {
    border-color: #fff;
}

/* Name */
.candidate-name {
    font-weight: bold;
    font-size: 16px;
}

/* Partylist */
.candidate-party {
    font-size: 13px;
    opacity: 0.8;
}

/* Check badge */
.checkmark {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #fff;
    color: #28a745;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transform: scale(0.5);
    transition: all 0.2s ease;
}

/* Show checkmark when selected */
.candidate-input:checked + .candidate-card .checkmark {
    opacity: 1;
    transform: scale(1);
}

/* FOR CHECKBOX (Board of Trustees) */
.candidate-checkbox:checked + .candidate-card {
    background: #28a745;
    color: #fff;
    border-color: #28a745;
    transform: scale(1.03);
    box-shadow: 0 8px 20px rgba(40,167,69,0.4);
}

/* Image border when selected */
.candidate-checkbox:checked + .candidate-card img {
    border-color: #fff;
}

/* Show checkmark */
.candidate-checkbox:checked + .candidate-card .checkmark {
    opacity: 1;
    transform: scale(1);
}

/* Hide checkbox (Board of Trustees) */
.candidate-checkbox {
    display: none;
}

.candidate-card:active {
    transform: scale(0.97);
}

.candidate-card.disabled {
    opacity: 0.4;
    pointer-events: none;
    filter: grayscale(80%);
}

/* Mobile spacing */
@media(max-width: 576px){
    .candidate-card {
        padding: 12px;
    }
}
</style>


    <style type="text/css">
    body {
        background-image: url('http://localhost:8181/gscgeavotingsystem/uploads/GSCGEAVOTE.png');
        background-repeat: repeat;
        background-position: center center;
        background-size: auto;
    }

      th {
          background-color: #4CAF50;
          color: white;
      }
    </style>


  </head>

  <body class="bg-dark">

<?php if(!empty(validation_errors())){ ?>
<div class="alert alert-danger" role="alert">
  <strong><?= validation_errors(); ?></strong></a>
</div>
<?php } ?>

<?php if(!empty($message)){ ?>
<div class="alert alert-danger" role="alert">
  <strong><?= $message; ?></strong></a>
</div>
<?php } ?>

    <div class="container">
      <div class="card mx-auto mt-5">
        <div class="card-body">
            <div class="form-group">
<h4 style="text-align: center;">
    <strong>
        Hi 
        <span style="color: #ff0000;">
            <?= auth()->user()->first_name; ?>
        </span>!
    </strong>
</h4>
<br>
<h5 style="text-align: center;">Welcome to GSCGEA Online Voting System.</strong></h5>


            </div>
        </div>
      </div>
    </div>

<?php echo form_open('vote/vote_submit',array("id"=>"formsubmit")); ?>

<?php
renderPosition('PRESIDENT', 'President', $RecordPresident);
renderPosition('VICE PRESIDENT', 'VicePresident', $RecordVicePresident);
renderPosition('SECRETARY', 'Secretary', $RecordSecretary);
renderPosition('TREASURER', 'Treasurer', $RecordTreasurer);
renderPosition('AUDITOR', 'Auditor', $RecordAuditor);
renderPosition('BUSINESS MANAGER', 'BusinessManager', $RecordBusinessManager);
renderPosition('PUBLIC INFORMATION OFFICER', 'PublicInformationOfficer', $RecordPIO);
?>

<div class="container">
    <div class="card mx-auto mt-5 position-group" data-max="10">
        <div class="card-header text-center">
            <b>BOARD OF TRUSTEES</b><br>
            <em>(Select up to 10 candidates)</em>

            <div class="selectionStatus text-center mt-2 text-muted">
                Selected: 0 / 10
            </div>
        </div>

        <div class="card-body">
            <div class="candidate-grid">

<?php foreach($RecordBoardOfTrustees as $r){ 

$image = 'user.png';
if (!empty($r->CandidateImage) && file_exists(FCPATH . 'uploads/candidates/' . $r->CandidateImage)) {
    $image = $r->CandidateImage;
}
?>

<label>
    <input 
        type="checkbox" 
        name="BoardOfTrustees[]" 
        value="<?= $r->votetrnid; ?>" 
        class="candidate-checkbox"
    >

    <div class="candidate-card">
        <div class="checkmark">✔</div>

        <img src="<?= base_url('uploads/candidates/' . $image); ?>">

        <div class="candidate-name">
            <?= htmlspecialchars($r->Candidate, ENT_QUOTES, 'UTF-8'); ?>
        </div>

        <?php if($r->Partylist !== ''){ ?>
        <div class="candidate-party">
            (<?= htmlspecialchars($r->Partylist, ENT_QUOTES, 'UTF-8'); ?>)
        </div>
        <?php } ?>
    </div>
</label>

<?php } ?>

            </div>
        </div>
    </div>
</div>







    <div class="container">
      <div class="card mx-auto mt-5">
        <div class="card-body">
          <?php echo form_submit(array('id' => 'submit', 'value' => 'Submit', 'class' => 'btn btn-success btn-block')); ?>
          <?php echo form_close(); ?>
<br/>
<button type="button" id="cancellogin" class="btn btn-default btn-block">
    Cancel
</button>
        </div>
      </div>
    </div>

<?php //echo form_hidden('votemstid',$votemstid); ?>









<?php
function renderPosition($title, $name, $records) {
?>
<div class="container">
    <div class="card mx-auto mt-5 position-group">
        <div class="card-header text-center">
            <div class="position-title"><b><?= $title ?></b></div><br>
            <em>(Please select your candidate)</em>

            <div class="selectionStatus text-center mt-2 text-muted">
                No candidate selected
            </div>
        </div>

        <div class="card-body">
            <div class="candidate-grid">

<?php foreach($records as $r){ 

$image = 'user.png';
if (!empty($r->CandidateImage) && file_exists(FCPATH . 'uploads/candidates/' . $r->CandidateImage)) {
    $image = $r->CandidateImage;
}
?>

<label>
    <input 
        type="radio" 
        name="<?= $name ?>" 
        value="<?= $r->votetrnid; ?>" 
        class="candidate-input"
    >

    <div class="candidate-card">
        <div class="checkmark">✔</div>

        <img src="<?= base_url('uploads/candidates/' . $image); ?>">

        <div class="candidate-name">
            <?= htmlspecialchars($r->Candidate, ENT_QUOTES, 'UTF-8'); ?>
        </div>

        <?php if($r->Partylist !== ''){ ?>
        <div class="candidate-party">
            (<?= htmlspecialchars($r->Partylist, ENT_QUOTES, 'UTF-8'); ?>)
        </div>
        <?php } ?>
    </div>
</label>

<?php } ?>

            </div>
        </div>
    </div>
</div>
<?php } ?>





<div id="imageModal" style="
    display:none;
    position:fixed;
    top:0; left:0;
    width:100%; height:100%;
    background:rgba(0,0,0,0.8);
    justify-content:center;
    align-items:center;
    z-index:9999;
">
    <img id="modalImage" style="
        max-width:90%;
        max-height:90%;
        border-radius:10px;
        cursor:pointer;
    ">
</div>









    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url().'assets/'; ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url().'assets/'; ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url().'assets/'; ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
let isSubmitting = false;

$('#formsubmit').on('submit', function(e) {
    e.preventDefault();

    if (isSubmitting) return;

    let form = $(this);

    let summary = '';

    // SINGLE POSITIONS
    $('.position-group').not('[data-max]').each(function() {

        let title = $(this).find('.position-title').text().trim();

        let selected = $(this).find('.candidate-input:checked');

        summary += `
            <div style="margin-bottom:10px;text-align:left;">
                <b>${title}</b><br>
        `;

        if (selected.length > 0) {

            let candidate = selected.closest('label').find('.candidate-name').text().trim();

            summary += `
                <span style="color:green;">
                    ✔ ${candidate}
                </span>
            `;
        } else {

            summary += `
                <span style="color:red;">
                    No selection
                </span>
            `;
        }

        summary += `</div>`;
    });

    // BOARD OF TRUSTEES
    let botSummary = '';

    $('[name="BoardOfTrustees[]"]:checked').each(function() {

        let candidate = $(this)
            .closest('label')
            .find('.candidate-name')
            .text()
            .trim();

        botSummary += `✔ ${candidate}<br>`;
    });

    summary += `
        <div style="margin-top:15px;text-align:left;">
            <b>BOARD OF TRUSTEES</b><br>
    `;

    if (botSummary !== '') {
        summary += `<span style="color:green;">${botSummary}</span>`;
    } else {
        summary += `<span style="color:red;">No selection</span>`;
    }

    summary += `</div>`;

    // PREVIEW MODAL
    Swal.fire({
        title: 'Review Your Votes',
        html: `
            <div style="
                max-height:400px;
                overflow-y:auto;
                padding-right:5px;
                font-size:14px;
            ">
                ${summary}
            </div>
        `,
        width: 600,
        showCancelButton: true,
        confirmButtonText: 'Submit Vote',
        cancelButtonText: 'Review Again',
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d'
    }).then((result) => {

        if (!result.isConfirmed) return;

        // 🚫 prevent double submit
        isSubmitting = true;

        // LOADING
        Swal.fire({
            title: 'Submitting vote...',
            text: 'Please wait...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        // AJAX SUBMIT
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',

            success: function(res) {

                if (res.status === 'success') {

                    Swal.fire({
                        icon: 'success',
                        title: 'Vote Submitted',
                        text: res.message,
                        confirmButtonColor: '#28a745'
                    }).then(() => {

                        Swal.fire({
                            title: 'Redirecting...',
                            allowOutsideClick: false,
                            didOpen: () => Swal.showLoading()
                        });

                        window.location.href = res.redirect;
                    });

                } else {

                    isSubmitting = false;

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: res.message
                    });
                }
            },

            error: function() {

                isSubmitting = false;

                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Something went wrong.'
                });
            }
        });

    });

});
</script>

<script>
document.querySelectorAll('.position-group').forEach(group => {

    const max = parseInt(group.dataset.max); // only for BOT
    const radios = group.querySelectorAll('.candidate-input');
    const checkboxes = group.querySelectorAll('.candidate-checkbox');
    const cards = group.querySelectorAll('.candidate-card');
    const statusEl = group.querySelector('.selectionStatus');

    let selectedRadio = null;

    function updateStatus() {

        // ✅ MULTI SELECT (Board of Trustees)
        if (max) {
            const count = group.querySelectorAll('.candidate-checkbox:checked').length;
            statusEl.innerText = `Selected: ${count} / ${max}`;

            checkboxes.forEach(cb => {
                if (!cb.checked) {
                    cb.disabled = (count >= max);
                    cb.nextElementSibling.classList.toggle('disabled', count >= max);
                }
            });

            return;
        }

        // ✅ SINGLE SELECT (Radio positions)
        const selected = group.querySelector('.candidate-input:checked');

        if (selected) {
            statusEl.innerText = "Candidate selected ✔";
            statusEl.classList.add('text-success');
            statusEl.classList.remove('text-danger');
        } else {
            statusEl.innerText = "No candidate selected";
            statusEl.classList.add('text-danger');
            statusEl.classList.remove('text-success');
        }
    }

    // ✅ RADIO LOGIC
    radios.forEach(input => {
        input.addEventListener('click', function () {

            if (selectedRadio === this) {
                this.checked = false;
                selectedRadio = null;

                cards.forEach(c => c.classList.remove('selected'));

                updateStatus();
                return;
            }

            selectedRadio = this;

            cards.forEach(c => c.classList.remove('selected'));

            this.checked = true;
            this.nextElementSibling.classList.add('selected');

            updateStatus();
        });
    });

    // ✅ CHECKBOX LOGIC (BOT)
    checkboxes.forEach(cb => {
        cb.addEventListener('change', function () {

            this.nextElementSibling.classList.toggle('selected', this.checked);

            updateStatus();
        });
    });

    updateStatus();
});

const modal = document.getElementById('imageModal');
const modalImg = document.getElementById('modalImage');

document.querySelectorAll('.candidate-card img').forEach(img => {
    img.addEventListener('click', function (e) {
        e.preventDefault();     // 🚀 important
        e.stopPropagation();    // 🚀 already added

        modal.style.display = 'flex';
        modalImg.src = this.src;
    });
});


// Click image or background → close
modal.addEventListener('click', function () {
    modal.style.display = 'none';
});


$('#cancellogin').on('click', function () {
    Swal.fire({
        title: 'Cancel Voting?',
        text: "Are you sure you want to cancel your vote?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, cancel it!',
        cancelButtonText: 'No',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: "<?= site_url('vote/vote_cancelvotelogin'); ?>",
                type: "POST",
                dataType: "json",
                success: function (response) {

                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Cancelled',
                            text: response.message
                        }).then(() => {
                            Swal.fire({
                                title: 'Redirecting...',
                                text: 'Please wait...',
                                allowOutsideClick: false,
                                didOpen: () => Swal.showLoading()
                            });

                            window.location.href = "<?= site_url('/logout'); ?>";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }

                },
                error: function () {
                    Swal.fire('Error', 'Something went wrong.', 'error');
                }
            });

        }
    });
});

</script>


  </body>

</html>
