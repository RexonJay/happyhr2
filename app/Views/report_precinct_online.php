<style>
.report-container {
    max-width: 900px;
    margin: auto;
    font-family: Arial;
}

/* HEADER */
.report-header {
    text-align: center;
    margin-bottom: 15px;
}

.header-inner {
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.logo {
    width: 60px;
}

.report-title {
    font-size: 14px;
    font-weight: bold;
}

.report-sub {
    font-size: 12px;
}

/* TABLE */
.table-report {
    width: 100%;
    border-collapse: collapse;
    border: 2px solid #000;
    font-size: 13px;
}

.table-report th, 
.table-report td {
    border: 1px solid #000;
    padding: 5px;
}

.table-report th {
    background: #eee;
    text-transform: uppercase;
}

/* FOOTER */
.footer {
    margin-top: 30px;
    font-size: 12px;
}

/* SIGNATURE */
.signature {
    margin-top: 60px;
    text-align: center;
}

.signature-line {
    width: 250px;
    border-top: 1px solid #000;
    margin: auto;
}

/* PRINT */
@media print {
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

td:last-child {
    border-bottom: 1px solid #000;
    height: 30px;
}
</style>


<div class="no-print print-btn-wrapper">
    <button onclick="printReport()" class="btn-print">
        <span class="icon">🖨</span>
        <span>Print Report</span>
    </button>
</div>

<div class="report-container">

    <!-- HEADER -->
    <div class="report-header">
        <div class="header-inner">
            <img src="<?= site_url('uploads/gscgea_logo.jpg') ?>" class="logo">
            <div class="header-text">
                <div class="report-title">GENERAL SANTOS CITY GOVERNMENT EMPLOYEES ASSOCIATION</div>
                <div class="report-sub">City of General Santos</div>
                <div class="report-title">PRECINCT REPORT</div>
            </div>
        </div>
    </div>

    <!-- TABLE -->
<table class="table-report">
    <thead>
        <tr>
            <th>Precinct</th>
            <th>Voted (Precinct)</th>
            <th>Voted (Online)</th>
            <th>Total Voted</th>
            <th>Not Voted</th>
            <th>Chair</th>
            <th>Member 1</th>
            <th>Member 2</th>
        </tr>
    </thead>
    <tbody>

<?php 
$totalP = 0;
$totalO = 0;
$totalNV = 0;

foreach($records as $r){ 
    $total = $r->VotedPrecinct + $r->VotedOnline;

    $totalP += $r->VotedPrecinct;
    $totalO += $r->VotedOnline;
    $totalNV += $r->NotVoted;
?>
    <tr>
        <td><?= $r->PrecinctNumber ?></td>
        <td align="right"><?= $r->VotedPrecinct ?></td>
        <td align="right"><?= $r->VotedOnline ?></td>
        <td align="right"><b><?= $total ?></b></td>
        <td align="right"><?= $r->NotVoted ?></td>
        <td style="width:150px;"></td>
        <td style="width:150px;"></td>
        <td style="width:150px;"></td>
    </tr>
<?php } ?>

    <tr style="font-weight:bold;">
        <td>Total</td>
        <td align="right"><?= $totalP ?></td>
        <td align="right"><?= $totalO ?></td>
        <td align="right"><?= $totalP + $totalO ?></td>
        <td align="right"><?= $totalNV ?></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>

    </tbody>
</table>

    <!-- SIGNATURE -->
    <!-- <div class="signature">
        <div class="signature-line"></div>
        <div>BEI</div>
    </div> -->

    <!-- FOOTER -->
    <div class="footer">
        Generated: <?= date('F d, Y h:i A') ?>
    </div>

</div>


<script>
function printReport() {
    window.print();
}
</script>