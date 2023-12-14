<?php
require "header.php";
 ?>
 <div class="row p-2">
   <div class="col-12">
     <form id="formulario" action='pdf_chart.php' method="POST">
       <input type="hidden" name="prostpng" id="prostpng" value="">
       <input type="hidden" name="operapng" id="operapng" value="">
       <input type="hidden" name="surgepng" id="surgepng" value="">
       <input type="hidden" name="pediapng" id="pediapng" value="">
       <input type="hidden" name="stdate" id="stdate" value="">
       <input type="hidden" name="endate" id="endate" value="">
       <button type="submit" name="button" class="btn btn-warning" onclick="generatechart()">Generar pdf</button>
     </form>
   </div>
 </div>
 <div class="row">
   <div class="col-12" align='center'>
     Número de pacientes X Especilidad
   </div>
 </div>
<div class="row m-3 form-inline">
    <div class="col-6 col-sm-6 col-md-6 col-lg-6">
      <div class="input-group">
          <label class="p-2"for="">Fecha I.</label>
          <input type="date" id='datei' name="datei" class="form-control" value="2023-01-01" onchange="admissionCount()">
      </div>
    </div>
    <div class="col-6 col-sm-6 col-md-6 col-lg-6">
        <div class="input-group">
          <label class="p-2"for="">Fecha F.</label>
          <input type="date" id='datef' name="datef" class="form-control"value="<?php echo date("Y-m-d"); ?>" onchange="admissionCount()">
        </div>
    </div>
</div>

<div class="row">
  <div class="col-xl-8 col-md-8 col-sm-12 col-12">
    <canvas id="prostChart"></canvas>
  </div>
</div>
<div class="row">
  <div class="col-xl-8 col-md-8 col-sm-12 col-12">
    <canvas id="operaChart"></canvas>
  </div>
</div>
<div class="row">
  <div class="col-xl-8 col-md-8 col-sm-12 col-12">
    <canvas id="surgeChart"></canvas>
  </div>
</div>
<div class="row">
  <div class="col-xl-8 col-md-8 col-sm-12 col-12">
    <canvas id="pediaChart"></canvas>
  </div>
</div>

<?php
  require('footer.php');
?>

<script>
let prostChart;
let operaChart;
let surgeChart;
let pediaChart;
function graphic(title, labels){
  const colors = ['rgb(255, 99, 132)', 'rgb(69,177,223)', 'rgb(99,201,122)', 'rgb(255,82,82)'];

  var data = {
    labels: labels,
    datasets: [{
      label: title,
      backgroundColor: colors,
      borderColor: colors,
      data: [0, 0, 0, 0],
    }]
  };
  var config = {
    type: 'bar',
    data: data,
    options: {}
  };
  return config;
}

function admissionChart(){
  var titleChart='Pacientes X Especilidad (PROSTODONCIA)';
  var labels = ['Prost. Removible II', 'Prost. Removible III', 'Prost. Fija II', 'Prost. Fija III'];
  prostChart = new Chart(document.getElementById('prostChart'), graphic(titleChart, labels));

  titleChart='Pacientes X Especilidad (OPERATORIA)';
  labels = ['Operatoria Dental II', 'Endodoncia II', 'Operatoria Dental III', 'Endodoncia III'];
  operaChart = new Chart(document.getElementById('operaChart'), graphic(titleChart, labels));

  titleChart='Pacientes X Especilidad (CIRUGIA)';
  labels = ['Cirugia II', 'Periodoncia II', 'Cirugia III', 'Periodoncia III'];
  surgeChart = new Chart(document.getElementById('surgeChart'), graphic(titleChart, labels));

  titleChart='Pacientes X Especilidad (ODONTOPEDIATRIA)';
  labels = ['Odontopediatria I', 'Ortodoncia I', 'Odontopediatria II', 'Ortodoncia II'];
  pediaChart = new Chart(document.getElementById('pediaChart'), graphic(titleChart, labels));

}

admissionChart();

function updateChart(newData, idChart){
  idChart.data.datasets[0].data = newData;
  idChart.update();
}

function admissionCount(){
  var stdate = document.getElementById("datei").value;
  var endate = document.getElementById("datef").value;
  $.ajax({
    url: "../include/i_admissioncount.php",
    method:"POST",
    data: {stdate:stdate, endate:endate},
    success: function(r) {
      //alert(r);
      var jsonData = JSON.parse(r);
      updateChart(jsonData.prosthodontics, prostChart);
      updateChart(jsonData.operative, operaChart);
      updateChart(jsonData.surgery, surgeChart);
      updateChart(jsonData.pediatrics, pediaChart);
    }
  });
}

admissionCount();


function generatechart(){
    // Obtén una referencia al elemento canvas
    var ctx = document.getElementById("prostChart");
    var image = ctx.toDataURL('image/png');
    document.getElementById('prostpng').value = image;

    ctx = document.getElementById("operaChart");
    image = ctx.toDataURL('image/png');
    document.getElementById('operapng').value = image;

    ctx = document.getElementById("surgeChart");
    image = ctx.toDataURL('image/png');
    document.getElementById('surgepng').value = image;

    ctx = document.getElementById("pediaChart");
    image = ctx.toDataURL('image/png');
    document.getElementById('pediapng').value = image;

    document.getElementById("stdate").value = document.getElementById("datei").value;
    document.getElementById("endate").value = document.getElementById("datef").value;
}
</script>
