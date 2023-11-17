<?php
require('header.php');
?>

                  <div class="container-fluid px-3">
                      <h3 class="mt-2" align = "center">Pacientes Admitidos</h3>
                      <div class="table-responsive">
                        <div class="row">
                          <div class="col-6">
                            <form id="myForm" action="pdf_reportadmission.php" method="post" onsubmit="generate_pdf()">
                              <button type="submit" class="btn btn-outline-success btn-sm" name="generar">Generar en PDF<i class="fa fa-solid fa-file-pdf"></i></button>
                            </form>

                          </div>
                        </div>
                        <br>
                        <div class="row">

                          <div class="col-12 mx-2 p-1 bg-secondary bg-opacity-10 border border-secondary">

                            <div class="btn-group-vertical btn-group-sm" role="group" aria-label="Small checkbox toggle button group">

                              <input type="checkbox" class="btn-check" id="removibleii" autocomplete="off" checked>
                              <label style="font-size: 12px" class="btn btn-outline-success" for="removibleii">Prostodoncia Removible II</label>
                              <input type="checkbox" class="btn-check" id="removibleiii" autocomplete="off" checked>
                              <label style="font-size: 12px" class="btn btn-outline-success" for="removibleiii">Prostodoncia Removible III</label>
                            </div>
                            <div class="btn-group-vertical btn-group-sm" role="group" aria-label="Small checkbox toggle button group">
                              <input type="checkbox" class="btn-check" id="fijaii" autocomplete="off" checked>
                              <label style="font-size: 12px" class="btn btn-outline-success" for="fijaii">Prostodoncia Fija II</label>
                              <input type="checkbox" class="btn-check" id="fijaiii" autocomplete="off" checked>
                              <label style="font-size: 12px" class="btn btn-outline-success" for="fijaiii">Prostodoncia Fija III</label>
                            </div>
                            <div class="btn-group-vertical btn-group-sm" role="group" aria-label="Small checkbox toggle button group">
                              <input type="checkbox" class="btn-check" id="dentalii" autocomplete="off" checked>
                              <label style="font-size: 12px" class="btn btn-outline-warning" for="dentalii">Operatoria Dental II</label>
                              <input type="checkbox" class="btn-check" id="dentaliii" autocomplete="off" checked>
                              <label style="font-size: 12px" class="btn btn-outline-warning" for="dentaliii">Operatoria Dental III</label>
                            </div>
                            <div class="btn-group-vertical btn-group-sm" role="group" aria-label="Small checkbox toggle button group">
                              <input type="checkbox" class="btn-check" id="endodonciaii" autocomplete="off" checked>
                              <label style="font-size: 12px" class="btn btn-outline-warning" for="endodonciaii">Endodoncia II</label>
                              <input type="checkbox" class="btn-check" id="endodonciaiii" autocomplete="off" checked>
                              <label style="font-size: 12px" class="btn btn-outline-warning" for="endodonciaiii">Endodoncia III</label>
                            </div>
                            <div class="btn-group-vertical btn-group-sm" role="group" aria-label="Small checkbox toggle button group">
                              <input type="checkbox" class="btn-check" id="bucalii" autocomplete="off" checked>
                              <label style="font-size: 12px" class="btn btn-outline-primary" for="bucalii">Cirugia Bucal II</label>
                              <input type="checkbox" class="btn-check" id="bucaliii" autocomplete="off" checked>
                              <label style="font-size: 12px" class="btn btn-outline-primary" for="bucaliii">Cirugia Bucal III</label>
                            </div>
                            <div class="btn-group-vertical btn-group-sm" role="group" aria-label="Small checkbox toggle button group">
                              <input type="checkbox" class="btn-check" id="periodonciaii" autocomplete="off" checked>
                              <label style="font-size: 12px" class="btn btn-outline-primary" for="periodonciaii">Periodoncia II</label>
                              <input type="checkbox" class="btn-check" id="periodonciaiii" autocomplete="off" checked>
                              <label style="font-size: 12px" class="btn btn-outline-primary" for="periodonciaiii">Periodoncia III</label>
                            </div>
                            <div class="btn-group-vertical btn-group-sm" role="group" aria-label="Small checkbox toggle button group">
                              <input type="checkbox" class="btn-check" id="pediatriai" autocomplete="off" checked>
                              <label style="font-size: 12px" class="btn btn-outline-danger" for="pediatriai">Odontopediatria I</label>
                              <input type="checkbox" class="btn-check" id="pediatriaii" autocomplete="off" checked>
                              <label style="font-size: 12px" class="btn btn-outline-danger" for="pediatriaii">Odontopediatria II</label>
                            </div>
                            <div class="btn-group-vertical btn-group-sm" role="group" aria-label="Small checkbox toggle button group">
                              <input type="checkbox" class="btn-check" id="ortodonciai" autocomplete="off" checked>
                              <label style="font-size: 12px" class="btn btn-outline-danger" for="ortodonciai">Ortodoncia I</label>
                              <input type="checkbox" class="btn-check" id="ortodonciaii" autocomplete="off" checked>
                              <label style="font-size: 12px" class="btn btn-outline-danger" for="ortodonciaii">Ortodoncia II</label>
                            </div>

                          </div>
                        </div>
                        <style media="screen">
                          td,th{
                            text-align: center;
                          }
                          table{
                            font-size: 15px
                          }
                        </style>
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 5%" scope="col">#</th>
                                    <th style="width: 20%" scope="col">
                                      <label for="patientname">Paciente</label>
                                      <input type="text" name="patientname" id="patientname" class="form-control form-control-sm" value="">
                                    </th>
                                    <th style="width: 15%" scope="col">
                                      Edad
                                      <div class="input-group input-group-sm">
                                        <input type="number" id="agestart"class="form-control" aria-label="Sizing example input" min="0" value="0">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"><></span>
                                        <input type="number" id="ageend"class="form-control" aria-label="Sizing example input" value="100">
                                      </div>
                                    </th>
                                    <th scope="col col-1">
                                      Genero
                                      <select class="form-select form-select-sm" id="patientgender">
                                        <option value="" selected>Todo</option>
                                        <option value="m">Masculino</option>
                                        <option value="f">Femenino</option>
                                      </select>
                                    </th>
                                    <th scope="col" class="bg-secondary bg-opacity-10 border border-top-0 border-secondary">Remisión</th>
                                    <th scope="col">
                                      Est. Designado
                                      <input type="text" name="studentname" id="studentname" class="form-control form-control-sm" value="">

                                    </th>
                                    <th scope="col">
                                      Fecha de registro
                                      <div class="input-group input-group-sm">
                                        <input type="date" id="stdate" name="stdate" value="2023-01-01" max="<?php echo date('Y-m-d'); ?>" class="form-control">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"><></span>
                                        <input type="date" id="endate" name="endate" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>" class="form-control">
                                      </div>
                                    </th>

                                    <!--<th scope="col">Accion</th>-->
                                </tr>
                            </thead>
                            <tbody id = "table-data">
                              <!--Los datos se generan de forma automatica-->
                            </tbody>
                        </table>
                        <div class='d-flex flex-wrap flex-sm-row justify-content-between' id="pagination-data"></div>
                      </div>

                    </div>

<?php
require('footer.php');
?>
<script>

var formData = new FormData(); // Crear un objeto FormData vacío
function restartFormData(){
  for (var key of formData.keys()) {
    formData.delete(key);
  }
}
var checkboxStates = new Array(16).fill(1);
function AddFormData(page){
  restartFormData();//reinicia el formulario
  formData.append('page', page);
  formData.append('checkboxStates', JSON.stringify(checkboxStates));
  formData.append('startage', $('#agestart').val());
  formData.append('endage', $('#ageend').val());
  formData.append('gender', $('#patientgender').val());
  formData.append('patientfullname', $('#patientname').val());
  formData.append('studentfullname', $('#studentname').val());
  formData.append('stdate', $('#stdate').val());
  formData.append('endate', $('#endate').val());
}
function loadData(page){
  AddFormData(page);
  //alert('entra');
  $.ajax({
    url: "tablereportadmission.php",
    type: "POST",
    data: formData,
    contentType: false, // Deshabilitar la codificación de tipo MIME
    processData: false, // Deshabilitar la codificación de datos
    success: function(r) {
      //$('#table-data').html(r);
      var jsonData = JSON.parse(r);
      $('#table-data').html(jsonData.tableData);
      $('#pagination-data').html(jsonData.paginationData);
    }
  });
}

function generate_pdf(){
  AddFormData(1);
  var idForm=document.getElementById('myForm');
  idForm.querySelectorAll('input[type="hidden"]').forEach(input => input.remove());

  idForm.formData = formData;
  for (var pair of formData.entries()) {
    idForm.appendChild(document.createElement('input')).setAttribute('type', 'hidden');
    idForm.lastChild.setAttribute('name', pair[0]);
    idForm.lastChild.setAttribute('value', pair[1]);
  }
  return true;
}

$('.btn-check').change(function (){
  var index = $('.btn-check').index(this);
  checkboxStates[index] = $(this).is(':checked') ? 1:0;
  loadData(1);
  //alert('Estado del '+(index+1)+': '+checkboxStates[index]);
});

$('#agestart, #ageend, #patientgender, #patientname, #studentname, #stdate, #endate').on('change', function() {
  loadData(1);
});
//cargar datos en la pagina inicial
loadData(1);
</script>
