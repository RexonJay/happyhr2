<style>
.report-container {
    max-width: 900px;
    margin: auto;
    font-family: Arial, sans-serif;
}

.report-header {
    text-align: center;
    margin-bottom: 15px;
}

.header-inner {
    display: inline-flex;   /* 👈 KEY */
    align-items: center;
    gap: 15px;
}

.logo {
    width: 70px;
    height: 70px;
    object-fit: contain;
}


.report-title {
    font-size: 15px;
    font-weight: bold;
}

.report-sub {
    font-size: 12px;
}

.report-year {
    font-size: 14px;
    font-weight: bold;
}

.table-report {
    width: 100%;
    border-collapse: collapse;
    margin-top: 8px;
    border: 2px solid #000;
    font-size: 13px;
    table-layout: fixed; /* 👈 IMPORTANT */
}

.table-report th,
.table-report td {
    border: 1px solid #000;
    padding: 4px 6px;
    line-height: 1.2;
}

.table-report th:first-child,
.table-report td:first-child {
    width: 78%; /* Candidate column */
}

.table-report th:last-child,
.table-report td:last-child {
    width: 22%; /* Votes column */
}

.vote-col {
    text-align: right;
    font-weight: bold;
}

.position-title {
    margin-top: 12px;   /* was too big */
    margin-bottom: 5px;
    font-weight: bold;
    font-size: 14px;
    border-bottom: 2px solid #000;
    padding-bottom: 3px;
}


.winner {
    background: #c8f7c5;
    font-weight: bold;
    border-left: 5px solid green;
}

.total-row {
    background: #f9f9f9;
    font-weight: bold;
}

.signatory-section {
    margin-top: 60px;
    width: 100%;
}

.signatory-row {
    display: flex;
    justify-content: space-between;
    gap: 40px;
    margin-bottom: 50px;
}

.center-row {
    justify-content: center;
}

.signatory-box {
    width: 280px;
    text-align: center;
}

.sign-line {
    border-top: 1px solid #000;
    margin-bottom: 5px;
}

.sign-name {
    font-weight: bold;
    text-transform: uppercase;
    font-size: 13px;
}

.sign-position {
    font-size: 12px;
    color: #444;
}
</style>

<style>
@media print {

    body {
        font-size: 12px;
    }

    .report-container {
        padding: 5px;
    }

    .table-report th, 
    .table-report td {
        padding: 3px 5px;
    }

    .position-title {
        margin-top: 8px;
    }

    /* prevent breaking mid-table */
    table {
        page-break-inside: avoid;
    }


    .no-print {
        display: none !important;
    }

}

.btn-print {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: #fff;
    border: none;
    padding: 12px 25px;
    font-size: 16px;
    border-radius: 30px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    transition: all 0.2s ease;
}

.btn-print:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.3);
}

.btn-print .icon {
    font-size: 18px;
}

.print-btn-wrapper {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}
</style>


<div class="no-print print-btn-wrapper">
    <button onclick="printReport()" class="btn-print">
        <span class="icon">🖨</span>
        <span>Print Report</span>
    </button>
</div>
<div class="report-container">

<div class="report-header">

    <div class="header-inner">

        <img src="<?= site_url('uploads/gscgea_logo.jpg') ?>" class="logo">

        <div class="header-text">
            <div class="report-title">
                GENERAL SANTOS CITY GOVERNMENT EMPLOYEES ASSOCIATION
            </div>
            <div class="report-sub">City of General Santos</div>

            <div class="report-title" style="margin-top:5px;">
                OFFICIAL ELECTION RESULT REPORT
            </div>

            <div class="report-year">
                ELECTION YEAR: 2026
            </div>
        </div>

    </div>

</div>
<?php foreach($grouped as $position => $records){ ?>

<?php
    // sort descending by votes
    usort($records, function($a, $b){
        return $b->NumberOfVotes <=> $a->NumberOfVotes;
    });

    // determine how many winners
    $winnerCount = 1;

    if($position == 'Board of Trustees'){
        $winnerCount = 10;
    }

    // get cutoff vote
    $cutoffVote = 0;

    if(count($records) >= $winnerCount){
        $cutoffVote = $records[$winnerCount - 1]->NumberOfVotes;
    }
?>

<!-- <div class="position-title"></div> -->

<table class="table-report">
    <thead>
        <tr>
            <th><?= $position ?></th>
            <th class="vote-col">Votes</th>
        </tr>
    </thead>
    <tbody>

    <?php 
    $total = 0;

    foreach($records as $index => $r){ 
        $total += $r->NumberOfVotes;

        // highlight winners
        $isWinner = false;

        if($winnerCount == 1){
            $isWinner = ($index == 0);
        } else {
            // include ties
            $isWinner = ($r->NumberOfVotes >= $cutoffVote);
        }
    ?>
        <tr class="<?= $isWinner ? 'winner' : '' ?>">
            <td>
                <?= $r->Candidate ?>
                <?= $isWinner ? '🏆' : '' ?>
            </td>
            <td class="vote-col"><?= number_format($r->NumberOfVotes) ?></td>
        </tr>
    <?php } ?>

        <tr class="total-row">
            <td>Total Votes</td>
            <td class="vote-col"><?= number_format($total) ?></td>
        </tr>

    </tbody>
</table>

<?php } ?>
<div style="text-align:right; font-size:12px;">
    Generated: <?= date('F d, Y h:i A') ?>
</div>


<div class="signatory-section">

    <!-- FIRST ROW -->
    <div class="signatory-row">
        <div class="signatory-box">
            <div class="sign-line"></div>
            <div class="sign-name"></div>
            <div class="sign-position">Election Committee Member</div>
        </div>

        <div class="signatory-box">
            <div class="sign-line"></div>
            <div class="sign-name"></div>
            <div class="sign-position">Election Committee Member</div>
        </div>
    </div>

        <!-- FIRST ROW -->
    <div class="signatory-row">
        <div class="signatory-box">
            <div class="sign-line"></div>
            <div class="sign-name"></div>
            <div class="sign-position">Election Committee Member</div>
        </div>

        <div class="signatory-box">
            <div class="sign-line"></div>
            <div class="sign-name"></div>
            <div class="sign-position">Election Committee Member</div>
        </div>
    </div>

    <!-- SECOND ROW -->
    <div class="signatory-row center-row">
        <div class="signatory-box">
            <div class="sign-line"></div>
            <div class="sign-name"></div>
            <div class="sign-position">Election Committee Chairperson</div>
        </div>
    </div>

</div>
</div>


<script>
function printReport() {
    window.print();
}
</script>