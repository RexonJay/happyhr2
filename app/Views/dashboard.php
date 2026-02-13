
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.js"></script> -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>



<div id="myAlert" class="alert alert-dismissible alert-danger">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <h4 class="alert-heading">Announcement!</h4>
  <p class="mb-0">HR Chatbot is now ready! <a href="https://hrmdo.gensantos.gov.ph/index.php/Chatbot"><u>Try it now!</u></a> 🤖</p>
</div>
<!-- <script>
  // Function to dismiss the alert after 5 seconds
  setTimeout(function(){
    document.getElementById('myAlert').style.display = 'none';
  }, 10000); // 5000 milliseconds = 5 seconds
</script> -->







<?= form_open('/dashboard') ?>
<div class="form-group">
  <label class="control-label mr-2">Date From</label>
  <input name="FromDate" id="FromDate" type="date" value="<?= (isset($FromDate)) ? $FromDate : date('Y-m-01') ?>" class="form-control" required>
</div>
<div class="form-group">
  <label class="control-label mx-2">Date To</label>
  <input name="ToDate" id="ToDate" type="date" value="<?= (isset($ToDate)) ? $ToDate : date('Y-m-01') ?>" class="form-control" required>
</div>
&nbsp;<button type="submit" class="btn btn-md btn-primary">Update Graph</button>
<?= form_close() ?>


<br>

        <!-- <div class="col-md-6 col-lg-3">
          <label>Date From</label>
          <input name="FromDate" id="FromDate" class="form-control" type="date" value="<?= (set_value('FromDate')) ? set_value('FromDate') : date('Y-m-01') ?>" required="">
        </div>
        <div class="col-md-6 col-lg-3">
          <label>Date From</label>
          <input name="FromDate" id="FromDate" class="form-control" type="date" value="<?= (set_value('FromDate')) ? set_value('FromDate') : date('Y-m-01') ?>" required="">
        </div> -->
        <!-- <div class="col-md-12"> -->
          <!-- <h5 class='mb-3 line-head'>Number of Request (<?= $ChartTitle ?>)</h5> -->
          <!-- <label>Date From</label>
          <input name="FromDate" id="FromDate" class="form-control" type="date" value="<?= (set_value('FromDate')) ? set_value('FromDate') : date('Y-m-01') ?>" required="">
        </div> -->
      <div class="row">
        <div class="col-md-6 col-lg-3">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-calendar fa-3x"></i>
            <div class="info">
              <h4>DTR</h4>
              <p><b><?= $DTRCount ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-calendar fa-3x"></i>
            <div class="info">
              <h4>DTR Corrections</h4>
              <p><b><?= $DTRCorrectionsCount ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small danger coloured-icon"><i class="icon fa fa-credit-card fa-3x"></i>
            <div class="info">
              <h4>Payroll</h4>
              <p><b><?= $PayrollCount ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small warning coloured-icon"><i class="icon fa fa-list-alt fa-3x"></i>
            <div class="info">
              <h4>Leave</h4>
              <p><b><?= $LeaveCount ?></b></p>
            </div>
          </div>
        </div>
      </div>

			<!-- CSM -->
      <div class="row">
        <div class="col-md-6">
          <div class="tile"><h4 class="mb-3 line-head">Customer Satisfaction Measurement Survey (SQD)</h4>
            <canvas id="myChart_CSM"></canvas>
          </div>
        </div>
        <div class="col-md-6">
          <div class="tile"><h4 class="mb-3 line-head">Customer Satisfaction Measurement Survey (CCQ)</h4>
            <canvas id="myChart_CSMCC" width="400" height="200"></canvas>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="tile"><h4 class="mb-3 line-head">Mental Health Survey (Smiley)</h4>
            <canvas id="myChart_MentalHealthSurveySmiley" width="400" height="225"></canvas>
            <!-- <canvas id="myChart_MentalHealthSurveySmiley"></canvas> -->
          </div>
        </div>
        <div class="col-md-6">
          <div class="tile"><h4 class="mb-3 line-head">Mental Health Survey (Heart)</h4>
            <!-- <canvas id="myChart_MentalHealthSurveyHeart"></canvas> -->
            <div class="embed-responsive embed-responsive-16by9">
              <canvas class="embed-responsive-item" id="myChart_MentalHealthSurveyHeart"></canvas>
              <canvas class="embed-responsive-item" id="myChart_MentalHealthSurveyHeart"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="mb-3 line-head">Mental Health Survey (Gratitude)</h3>
            <canvas id="myChart_MentalHealthSurveyGratitude"></canvas>
          </div>
        </div>
      </div>

  <!-- MENTAL HEALTH (SMILEY) -->
  <script>
    // Access the data passed from the controller
    var labels = <?php echo json_encode($labels_Smiley); ?>;
    var values = <?php echo json_encode($values_Smiley); ?>;
    var barColors = <?php echo json_encode($barColors_Smiley); ?>;

    var ctx = document.getElementById('myChart_MentalHealthSurveySmiley').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Smiley',
                data: values,
                backgroundColor: barColors, // Customize bar color
                borderColor: barColors, // Customize border color
                borderWidth: 1
            }]
        },
        options: {
            // indexAxis: 'y', //To make horizontal
            // Additional options for customization
            scales: { y: { beginAtZero: true } },
            // plugins: {
            //     title: {
            //         display: true,
            //         text: '<?= $ChartTitle ?>', // Title text
            //         font: {
            //             size: 16 // Adjust the font size as needed
            //         }
            //     }
            // }
        }
    });
    
</script>

<!-- MENTAL HEALTH (HEART) -->
<script>
// var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
// var yValues = [55, 49, 44, 24, 15];
// var barColors = [
//   "#b91d47",
//   "#00aba9",
//   "#2b5797",
//   "#e8c3b9",
//   "#1e7145"
// ];

var xlabels = <?php echo json_encode($labels_Heart); ?>;
var xvalues = <?php echo json_encode($values_Heart); ?>;
var xbarColors = <?php echo json_encode($barColors_Heart); ?>;

new Chart("myChart_MentalHealthSurveyHeart", {
  type: "doughnut",
  data: {
    labels: xlabels,
    datasets: [{
      backgroundColor: xbarColors,
      data: xvalues
    }]
  },
  options: {
    plugins: {
      // title: {
      //   display: true,
      //   text: '<?= $ChartTitle ?>',
      //   font: {
      //     size: 18
      //   }
      // },
      legend: {
        position: 'right',
      },
    },
    tooltip: {
      callbacks: {
        label: function (tooltipItem, data) {
          var dataset = data.datasets[tooltipItem.datasetIndex];
          var total = dataset.data.reduce(function (previousValue, currentValue, currentIndex, array) {
            return previousValue + currentValue;
          });
          var currentValue = dataset.data[tooltipItem.index];
          var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
          return percentage + "%";
        }
      }
    },
    responsive: true,
    maintainAspectRatio: false,
    aspectRatio: 1,
    layout: {
      padding: {
        top: 20,
        bottom: 20,
      },
    },
  }
});

</script>


<!-- MENTAL HEALTH (Gratitude) -->
 <script>
    // Access the data passed from the controller
    var labels = <?php echo json_encode($labels_Gratitude); ?>;
    var values = <?php echo json_encode($values_Gratitude); ?>;
    var barColors = <?php echo json_encode($barColors_Gratitude); ?>;

// Create an array of objects pairing labels and values
var dataPairs = labels.map(function(label, index) {
    return {
        label: label,
        value: values[index]
    };
});

// Sort the array based on values in descending order
dataPairs.sort(function(a, b) {
    return b.value - a.value;
});

// Extract sorted labels and values separately
var sortedLabels = dataPairs.map(function(pair) {
    return pair.label;
});

var sortedValues = dataPairs.map(function(pair) {
    return pair.value;
});


// console.log(sortedLabels);
// console.log(sortedValues);
// console.log(barColors);
    var ctx = document.getElementById('myChart_MentalHealthSurveyGratitude').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: sortedLabels,
            datasets: [{
                label: 'Gratitude',
                data: sortedValues,
                backgroundColor: barColors, // Customize bar color
                borderColor: barColors, // Customize border color
                borderWidth: 1
            }]
        },
        options: {
             indexAxis: 'y', //To make horizontal
            scales: { y: { beginAtZero: true } },
        }
    });
    
</script>

  <!-- CUSTOMER SATISFACTION MEASUREMENT SURVEY -->
  <script>
    var labels = <?php echo json_encode($labels_Smiley_CSM); ?>;
    var values = <?php echo json_encode($values_Smiley_CSM); ?>;
    var barColors = <?php echo json_encode($barColors_Smiley_CSM); ?>;

		// console.log(labels);
		// console.log(values);

    var ctx = document.getElementById('myChart_CSM').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'CSM',
                data: values,
                backgroundColor: barColors, // Customize bar color
                borderColor: barColors, // Customize border color
                borderWidth: 1
            }]
        },
        options: {
            scales: { y: { beginAtZero: true } },
        }
    });
    
</script>



  <!-- CUSTOMER SATISFACTION MEASUREMENT SURVEY - CC -->
  <script>
    var labels = <?php echo json_encode($labels_CSMCC); ?>;
    var values = <?php echo json_encode($values_CSMCC); ?>;
    var barColors = <?php echo json_encode($barColors_CSMCC); ?>;

    var ctx = document.getElementById('myChart_CSMCC').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'CC',
                data: values,
                backgroundColor: barColors,
                borderColor: barColors,
                borderWidth: 1
            }]
        },
				options: {

            plugins: {
                datalabels: {
                    anchor: 'center',
                    align: 'center',
                    color: '#fff', // Label text color
                    font: {
                        weight: 'bold' // Label font weight
                    }
                }
            }
        }
    });
</script>



<!-- <script src="<?php echo base_url().'assets/chatgpt/script.js'; ?>"></script>
<script>

const currentDate = new Date();
const formattedCurrentDate = currentDate.getFullYear() + '-' + (currentDate.getMonth() + 1).toString().padStart(2, '0') + '-' + currentDate.getDate().toString().padStart(2, '0');

const ChatbotLastDatePopup = '<?php //echo $this->ion_auth->user()->row()->ChatbotLastDatePopup; ?>';

if (formattedCurrentDate !== ChatbotLastDatePopup) {
  $.ajax({
      url:'<?php echo site_url("EmployeeEngagement/updateChatbotLastDatePopup"); ?>',
      dataType: 'json',
      success:function(response){
          if (response.status == 'success') {
            $('#ModalChatBot').modal('show');
          }
      }
    });
  
}

</script>

<script>
  $(document).ready(function() {
    $('.smiley-icon').on('click', function() {
      $(this).prop('disabled', true); // Disable the clicked smiley button
    });
  });
</script> -->
