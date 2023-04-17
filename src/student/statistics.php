<?php
require('header.php');
?>
                    <div class="container-fluid px-4">

                        <h2 class="mt-4">Fichas Clinicas</h2>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Odontologia(UNSXX)</li>
                        </ol>
                        <!--BODY INICIO-->

                        <div class="row border">
                          <div class="col-xl-3 col-md-3 col-sm-6 col-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="" id="cirugia2" checked>
                              <label class="form-check-label" for="cirugia2">
                                Cirugia Bucal II
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="" id="cirugia3" checked>
                              <label class="form-check-label" for="cirugia3">
                                Cirugia Bucal III
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="" id="periodoncia2" checked>
                              <label class="form-check-label" for="periodoncia2">
                                Periodoncia II
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="" id="periodoncia3" checked>
                              <label class="form-check-label" for="periodoncia3">
                                Periodoncia III
                              </label>
                            </div>

                          </div>
                          <div class="col-xl-3 col-md-3 col-sm-6 col-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="" id="odontopediatria1" checked>
                              <label class="form-check-label" for="odontopediatria1">
                                Odontopediatria I
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="" id="odontopediatria2" checked>
                              <label class="form-check-label" for="odontopediatria2">
                                Odontopediatria II
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="" id="ortodoncia1" checked>
                              <label class="form-check-label" for="ortodoncia1">
                                Ortodoncia I
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="" id="ortodoncia2" checked>
                              <label class="form-check-label" for="ortodoncia2">
                                Ortodoncia II
                              </label>
                            </div>
                          </div>
                          <div class="col-xl-3 col-md-3 col-sm-6 col-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="" id="removible2" checked>
                              <label class="form-check-label" for="removible2">
                                Prostodoncia Removible II
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="" id="removible3" checked>
                              <label class="form-check-label" for="removible3">
                                Prostodoncia Removible III
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="" id="fija2" checked>
                              <label class="form-check-label" for="fija2">
                                Prostodoncia Fija II
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="" id="fija3" checked>
                              <label class="form-check-label" for="fija3">
                                Prostodoncia Fija III
                              </label>
                            </div>
                          </div>
                          <div class="col-xl-3 col-md-3 col-sm-6 col-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="" id="endodoncia1" checked>
                              <label class="form-check-label" for="endodoncia1">
                                Endodoncia I
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="" id="endodoncia2" checked>
                              <label class="form-check-label" for="endodoncia2">
                                Endodoncia II
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="" id="operatoria2" checked>
                              <label class="form-check-label" for="operatoria2">
                                Operatoria dental II
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="" id="operatoria3" checked>
                              <label class="form-check-label" for="operatoria3">
                                Operatoria dental III
                              </label>
                            </div>
                          </div>

                        </div>
                        <div class="row">
                          <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                            <label for="intrafecha">Fecha Inicio:</label>
                            <input type="date" class="form-control" id="start" name="start" value="<?php echo date('Y-m-d', time()-2629743); ?>" min="2010-01-01" max="2099-01-01">
                          </div>
                          <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                            <label for="intrafecha">Fecha Fin:</label>
                            <input type="date" class="form-control" id="end" name="end" value="<?php echo date('Y-m-d', time()); ?>" min="2010-01-01" max="2099-01-01">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xl-8 col-md-8 col-sm-12 col-12">
                            <canvas id="myChart"></canvas>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-xl-8 col-md-8 col-sm-12 col-12">
                            <canvas id="myChart2"></canvas>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                            <span><b><u>Fichas clínicas X mes</u></b></span>
                          </div>
                          <div class="col-xl-2 col-md-2 col-sm-6 col-6">
                            <label for="year"><b>Gestión:</b></label>
                            <select class="form-select" name="year" id="year">
                              <?php
                              $value="";
                              $year=date('Y',time());
                              $tmp=$year;
                              for ($i=$year; $i >=2010 ; $i--) {
                                if($i==$tmp){
                                  $value.="<option value='".$i."' selected>".$i."</option>\n";
                                }else{
                                  $value.="<option value='".$i."'>".$i."</option>\n";
                                }
                              }
                              echo $value;
                              ?>
                            </select>
                          </div>
                          <div class="col-12">
                            <canvas id="myChart3"></canvas>
                          </div>
                        </div>

                        <!--BODY FIN-->
                    </div>

<?php
require('footer.php');
?>
<script>
  $(document).ready(function(){
    let myChart;
    let myChart2;
    let myChart3;
    function graphic(p1, p2, p3, p4, p5, p6){
      const labels = [
        'Nuevas',
        'En Proceso',
        'Finalizados',
        'Anulados',
        'Abandonados'
      ];

      const colors = ['rgb(255, 99, 132)', 'rgb(69,177,223)', 'rgb(99,201,122)', 'rgb(255,82,82)', 'rgb(229,224,88)'];//'rgb(255, 99, 132)',
      //'rgb(255, 99, 132)',
      const data = {
        labels: labels,
        datasets: [{
          label: 'Fichas Clínicas',
          backgroundColor: 'rgb(255, 99, 132)',
          borderColor: 'rgb(255, 99, 132)',
          data: [p1, p2, p3, p4, p5, p6],
        }]
      };
      const data2 = {
        labels: labels,
        datasets: [{
          label: 'Fichas Clínicas',
          backgroundColor: colors,
          borderColor: colors,
          data: [p1, p2, p3, p4, p5],
        }]
      };

      const config = {
        type: 'bar',
        data: data,
        options: {}
      };
      const config2 = {
        type: 'pie',
        data: data2,
        options: {}
      };
      if (myChart) {
        myChart.destroy();
      }
      if (myChart2) {
        myChart2.destroy();
      }
      myChart = new Chart(
        document.getElementById('myChart'),
        config
      );
      myChart2 = new Chart(
        document.getElementById('myChart2'),
        config2
      );
    }
    function graphic2(p1, p2, p3, p4, p5, p6, p7, p8, p9, p10, p11, p12){
      const labels3 = [
        'Enero',
        'Febrero',
        'Marzo',
        'Abril',
        'Mayo',
        'Junio',
        'Julio',
        'Agosto',
        'Septiembre',
        'Octubre',
        'Noviembre',
        'Diciembre'
      ];
      const data3 = {
        labels: labels3,
        datasets: [{
          label: 'Fichas clínicas X mes',
          data: [p1, p2, p3, p4, p5, p6, p7, p8, p9, p10, p11, p12],
          fill: false,
          borderColor: 'rgb(75, 192, 192)',
          tension: 0.1
        }]
      };
      const config3 = {
        type: 'line',
        data: data3,
        options: {}
      };
      if (myChart3) {
        myChart3.destroy();
      }
      myChart3 = new Chart(
        document.getElementById('myChart3'),
        config3
      );
    }
    function Update(){
      var start=$('#start').val();
      var end=$('#end').val();

      var cirugia2=$('#cirugia2').prop('checked');
      var cirugia3=$('#cirugia3').prop('checked');
      var periodoncia2=$('#periodoncia2').prop('checked');
      var periodoncia3=$('#periodoncia3').prop('checked');
      var odontopediatria1=$('#odontopediatria1').prop('checked');
      var odontopediatria2=$('#odontopediatria2').prop('checked');
      var ortodoncia1=$('#ortodoncia1').prop('checked');
      var ortodoncia2=$('#ortodoncia2').prop('checked');
      var removible2=$('#removible2').prop('checked');
      var removible3=$('#removible3').prop('checked');
      var fija2=$('#fija2').prop('checked');
      var fija3=$('#fija3').prop('checked');
      var endodoncia1=$('#endodoncia1').prop('checked');
      var endodoncia2=$('#endodoncia2').prop('checked');
      var operatoria2=$('#operatoria2').prop('checked');
      var operatoria3=$('#operatoria3').prop('checked');
      var year=$('select[name=year]').val();

      $.ajax({

           url:"../include/i_statistics.php",
           method:"POST",
           data: {start:start, end:end,
             cirugia2:cirugia2, cirugia3:cirugia3, periodoncia2:periodoncia2, periodoncia3:periodoncia3,
             odontopediatria1:odontopediatria1, odontopediatria2:odontopediatria2, ortodoncia1:ortodoncia1,
             ortodoncia2:ortodoncia2, removible2:removible2, removible3:removible3, fija2:fija2,
             fija3:fija3, endodoncia1:endodoncia1, endodoncia2:endodoncia2, operatoria2:operatoria2,
             operatoria3:operatoria3, year:year
           },
           success:function(data)
           {
             if(data=='Error de fechas enviadas'){
               alert(data);
             }else{
               //alert(data);
               var d=data.split('#');
               var first=d[0].split(',');
               var second=d[1].split(',');
               graphic(first[0], first[1], first[2], first[3], first[4], first[5]);
               graphic2(second[0], second[1], second[2], second[3], second[4], second[5], second[6], second[7], second[8], second[9], second[10], second[11]);
             }
           }
      });
    }
    Update();
    $("input").change(function(){
        //alert('cirugia');
        Update();
	  });
    $("#year").change(function(){
        //alert('cirugia');
        Update();
	  });

  });

</script>
