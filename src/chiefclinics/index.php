<?php
require('header.php');
if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
  if(($pat=DBPatientRemissionInfo($id))==null){
    ForceLoad("admission.php");
  }
}

?>


            <!--inicio de div contenido-->
            <div id="layoutSidenav_content">
              <!--inicio de main-->
                <main>

                    <div class="container-fluid px-2">
<!--tabla para pacientes remitidos inicio-->
<br>

<div class="text-center text-success">
  <u><b>REGISTRO DE PACIENTES REMITIDOS</b></u>
</div>


<table class="table table-responsive table-sm table-hover" id="table_remission">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Paciente</th>
            <th scope="col">Consulta</th>
            <th scope="col">Diagnóstico</th>
            <th scope="col">Remisión</th>
            <th scope="col">Operador</th>
            <th scope="col">Fecha</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>


<?php
//$usr = DBAllUserInfo();
//student
$pr=array();
if(isset($_SESSION['usertable']['usernumber'])){
  $pr = DBAllPatientRemissionInfo();
  //$pr = DBAllRemissionInfo(null, false, 10000000);
}

$size=count($pr);
for ($i=0; $i < $size; $i++) {
      echo " <tr>\n";
      echo "   <td>" . ($size-$i) . "</td>";
      echo "   <td>" . $pr[$i]["patientname"] . " ".$pr[$i]["patientfirstname"]." ". $pr[$i]["patientlastname"] ."</td>";
      echo "   <td>" . $pr[$i]["motconsult"] . "</td>";
      echo "   <td>" . $pr[$i]["diagnosis"] . "</td>";
      echo "   <td>";
			if($pr[$i]['remission']!=null){
				$size2=count($pr[$i]['remission']);
				for ($j=0; $j < $size2 ; $j++) {
						echo $pr[$i]['remission'][$j]['clinicalspecialty'];
				}
			}
			echo "</td>";
      $in=DBUserInfo($pr[$i]['studentid']);
			echo "   <td>".$in['userfullname']."</td>";
      echo "   <td>" . datetimeconv($pr[$i]["updatetime"]) . "</td>";
      echo "   <td><a href=\"report.php?id=" . $pr[$i]["patientadmissionid"] . "\" class=\"btn btn-success btn-sm\">Imprimir</a></td>";


      echo "</tr>";
}
echo "</tbody></table>\n";

?>


<!--tabla para pacientes remitidos fin-->





                    </div>
                </main>



                <!--pie de pagina-->
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Unsxx &copy; Clinica Odontologica</div>
                            <div>
                                <a href="#">Politicas de Privacidad</a>
                                &middot;
                                <a href="#">Terminos &amp; Condiciones</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <!--fin div primero-->
        <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>-->
        <script src="../assets/graphic/bootstrap.bundle.min.js"></script>

        <script src="../js/scripts.js"></script>

        <!--bootstrap-->
        <!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>-->
        <script src="../assets/graphic/jquery-3.5.1.slim.min.js"></script>

        <!--<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>-->
        <script src="../assets/graphic/popper.min.js"></script>

        <!--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>-->
        <script src="../assets/graphic/jquery-3.5.1.min.js"></script>

        <script src="../assets/graphic/jquery.dataTables.min.js"></script>

        <!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>-->
        <script src="../assets/graphic/bootstrap.min.js"></script>
<!--odontograma inicio js-->
<!-- jQuery -->
<!--<script src="../jquery-1.10.2.min.js"></script>-->
<!-- Bootstrap JavaScript -->
<!--<script src="../tools/bootstrap/bootstrap.js"></script>-->
<!--ABRIMOS JAVASCRIPT-->
<?php
include("../leftodontogramjs.php");
?>
<!--odontograma fin js-->



    </body>
</html>
<script language="JavaScript" src="../sha256.js"></script>
<script language="JavaScript" src="../hex.js"></script>
<script>

//examined
function insert(id, val){
    event.preventDefault();
    $('#examinedid').val(id);
    $('#examined').val(val);
}
$(document).ready(function () {
    $('#table_remission').DataTable();
});
$(document).ready(function(){
  $(".write_student").on('click', function(event){
    event.stopPropagation();
    event.stopImmediatePropagation();

    $('#examined').val('grover');
  });

  $("#clinical").change(function(){
    //capturamos valor de campo de texto
      var examined = $('#examined').val()
      var clinical = $('select[name=clinical]').val()

      $.ajax({
        type: 'POST',
        url: '../include/search.php',
        data: {'examined': examined, 'clinical':clinical},
        beforeSend: function(){
          $('#resultstudent').html('<img src="../images/google.gif">')
        }
      })
      .done(function(resultado){
        //div para mostrar resultado
        $('#resultstudent').html(resultado)
      })
      .fail(function(){
        //alerta para un error
        alert('Hubo un error :(')
      })

  });

  //funcion para buscar pacientes
  $('#examined').on('keyup', function(){
    //capturamos valor de campo de texto
      var examined = $('#examined').val()
      var clinical = $('select[name=clinical]').val()

      $.ajax({
        type: 'POST',
        url: '../include/search.php',
        data: {'examined': examined, 'clinical':clinical},
        beforeSend: function(){
          $('#resultstudent').html('<img src="../images/google.gif">')
        }
      })
      .done(function(resultado){
        //div para mostrar resultado
        $('#resultstudent').html(resultado)
      })
      .fail(function(){
        //alerta para un error
        alert('Hubo un error :(')
      })

  })

  //shown.bs.collapse
    //para colapso  //hidden.bs.collapse
    $('#collapseOne').on('show.bs.collapse', function () {
        alert("colapso");
    })
      //cancel cancel_button
     $('#cancel_button').click(function(){
        location.reload();
     });
     //registrar todos de datos del paciente


     //update
     $('#update_button').click(function(){
		 var username,userdesc,userfull,passHASHo,passHASHn;
		 if($('#passwordn1').val() != $('#passwordn2').val()){
			 alert('password confirmacion debe ser igual');
		 }else{
			 if($('#passwordn1').val() == $('#passwordo').val()){
				 alert('password nuevo debe ser diferente al anterior');
			 }else{
				 username = $('#username').val();
				 userdesc = $('#userdesc').val();
				 userfull = $('#userfull').val();
				 passHASHo = js_myhash(js_myhash($('#passwordo').val())+'<?php echo session_id(); ?>');
				 passHASHn = bighexsoma(js_myhash($('#passwordn2').val()),js_myhash($('#passwordo').val()));
				 $('#passwordn1').val('                                                     ');
				 $('#passwordn2').val('                                                     ');
				 $('#passwordo').val('                                                     ');

				 $.ajax({

						  url:"../include/i_optionlower.php",
						  method:"POST",
						  data: {username:username, userdesc:userdesc, userfullname:userfull, passwordo:passHASHo, passwordn:passHASHn},

						  success:function(data)
						  {
							   //alert(data);
							   if(data.indexOf('Data updated.') !== -1)
							   {
									alert("Data updated.");
									$('#updateModal').hide();
									location.reload();
							   }
							   else
							   {
								   if (data.indexOf('Incorrect password')!== -1) {
									   alert("Incorrect password");

									   //location.href="../indexs.php";
								   }else{
									   alert(data);
								   }

							   }

						  }
				 });




			 }
		 }

     });

     //funcion para buscar pacientes
     $('#patientfullname').on('keyup', function(){
       //capturamos valor de campo de texto
         var search = $('#patientfullname').val()

         $.ajax({
           type: 'POST',
           url: '../include/search.php',
           data: {'search': search},
           beforeSend: function(){
             $('#result').html('<img src="../images/google.gif">')
           }
         })
         .done(function(resultado){
           //div para mostrar resultado
           $('#result').html(resultado)
         })
         .fail(function(){
           //alerta para un error
           alert('Hubo un error :(')
         })

     })

     var info='';
     //funcion para registrar datos del paciente
     function registerpatient(){

       var patientid = $('#patientid').val();
       var patientfullname = $('#patientfullname').val();
       var patientdirection = $('#patientdirection').val();
       var patientlocation = $('#patientlocation').val();
       var patientage = $('#patientage').val();
       var patientprovenance = $('#patientprovenance').val();
       var patientphone = $('#patientphone').val();
       var patientgender = $('select[name=patientgender]').val();//$('#patientgender').val();
       var patientcivilstatus = $('#patientcivilstatus').val();
       var patientoccupation = $('#patientoccupation').val();
       var patientnationality = $('#patientnationality').val();
       var patientschool = $('#patientschool').val();
       var patientattorney = $('#patientattorney').val();

       //variables de antecedentes medico general
       var yesno0 = $('#yesno0').prop('checked'),yesno1 = $('#yesno1').prop('checked'),yesno2 = $('#yesno2').prop('checked'),yesno3 = $('#yesno3').prop('checked');
       var yesno4 = $('#yesno4').prop('checked'),yesno5 = $('#yesno5').prop('checked'),yesno6 = $('#yesno6').prop('checked'),yesno7 = $('#yesno7').prop('checked');
       var yesno8 = $('#yesno8').prop('checked'),yesno9 = $('#yesno9').prop('checked'),yesno10 = $('#yesno10').prop('checked'),yesno11 = $('#yesno11').prop('checked');
       var yesno12 = $('#yesno12').prop('checked'),yesno13 = $('#yesno13').prop('checked');

       var obs0 = $('#obs0').val(),obs1 = $('#obs1').val(),obs2 = $('#obs2').val(),obs3 = $('#obs3').val();
       var obs4 = $('#obs4').val(),obs5 = $('#obs5').val(),obs6 = $('#obs6').val(),obs7 = $('#obs7').val();
       var obs8 = $('#obs8').val(),obs9 = $('#obs9').val(),obs10 = $('#obs10').val(),obs11 = $('#obs11').val();
       var obs12 = $('#obs12').val(),obs13 = $('#obs13').val();

       var sistolica = $('#sistolica').val();
       var diastolica = $('#diastolica').val();

       //patient triage
       var temperature = $('#temperature').val();
       var headache = $('input:radio[name=headache]:checked').val();
       var respiratory = $('input:radio[name=respiratory]:checked').val();
       var throat = $('input:radio[name=throat]:checked').val();
       var general = $('input:radio[name=general]:checked').val();
       var vaccine = $('input:radio[name=vaccine]:checked').val();

       //exam buco dental
       var tongue = $('select[name=tongue]').val();// $('select[name=tongue]').val();// $('input:radio[name=tongue]:checked').val();
       var piso = $('select[name=piso]').val();// $('input:radio[name=piso]:checked').val();
       var encias = $('select[name=encias]').val();// $('input:radio[name=encias]:checked').val();
       var mucosa = $('select[name=mucosa]').val();// $('input:radio[name=mucosa]:checked').val();
       var occlusion = $('select[name=occlusion]').val();// $('input:radio[name=occlusion]:checked').val();
       var prosthesis = $('select[name=prosthesis]').val();// $('input:radio[name=prosthesis]:checked').val();
       var hygiene = $('select[name=hygiene]').val();// $('input:radio[name=hygiene]:checked').val();

       var lastconsultation = $('#lastconsultation').val();
       var consultation = $('#consultation').val();
       //alert(tongue);

       //datos del odontograma
       var tr = $('#tr').html();
       var tl = $('#tl').html();
       var tlr = $('#tlr').html();
       var tll = $('#tll').html();
       var bl = $('#bl').html();
       var br = $('#br').html();
       var bll = $('#bll').html();
       var blr = $('#blr').html();
       //datos del examinado
       var diagnostico = $('#diagnostico').val();
       var clinical = $('select[name=clinical]').val();
       var examined = $('#examined').val();
       var examinedid = $('#examinedid').val();

       //variable para el modo de registro
       var mod = $('input:radio[name=mod]:checked').val();

       var odontodiagnostico = $('#areadiagnostico').val();
       var odontodraw = $('#draw').val();


       if(mod=== undefined)
          mod="new";
       //alert(mod);
       if(patientgender=='--'){
         alert("Debe seleccionar genero.");
         return false;
       }
       if(patientfullname != ''){

           $.ajax({

              url:"../include/i_patientadmission.php",
              method:"POST",
              data: {mod:mod, patientid:patientid, patientfullname:patientfullname, patientdirection:patientdirection, patientlocation:patientlocation, patientage:patientage, patientprovenance:patientprovenance,
                patientphone:patientphone, patientgender:patientgender, patientcivilstatus:patientcivilstatus, patientoccupation:patientoccupation, patientnationality:patientnationality,
                patientschool:patientschool, patientattorney:patientattorney, yesno0:yesno0, yesno1:yesno1, yesno2:yesno2, yesno3:yesno3, yesno4:yesno4, yesno5:yesno5, yesno6:yesno6,
                yesno7:yesno7, yesno8:yesno8, yesno9:yesno9, yesno10:yesno10, yesno11:yesno11, yesno12:yesno12, yesno13:yesno13,
                obs0:obs0, obs1:obs1, obs2:obs2, obs3:obs3, obs4:obs4, obs5:obs5, obs6:obs6, obs7:obs7, obs8:obs8, obs9:obs9, obs10:obs10, obs11:obs11, obs12:obs12, obs13:obs13, sistolica:sistolica, diastolica:diastolica,
                temperature:temperature, headache:headache, respiratory:respiratory, throat:throat, general:general, vaccine:vaccine,
                tongue:tongue, piso:piso, encias:encias, mucosa:mucosa, occlusion:occlusion,
                prosthesis:prosthesis, hygiene:hygiene, lastconsultation:lastconsultation, consultation:consultation,
                tr:tr, tl:tl, tlr:tlr, tll:tll, bl:bl, br:br, bll:bll, blr:blr,
                diagnostico:diagnostico, clinical:clinical, examined:examined, examinedid:examinedid, odontodiagnostico:odontodiagnostico, odontodraw:odontodraw},

              success:function(data)
              {

                if(data=='yes'){
                  alert('Se guardó los datos del paciente');
                  location.href="admission.php";
                }else{
                  alert(data);
                  console.log(data);
                }
              }
           });

       }else{
         alert('debe completar al menos nombres y apellidos');
       }
     }
     //register triage

     function registertriage(){

       var patientid = $('#patientid').val();
       var patientfullname = $('#patientfullname').val();


       var temperature = $('#temperature').val();
       var headache = $('input:radio[name=headache]:checked').val();
       var respiratory = $('input:radio[name=respiratory]:checked').val();
       var throat = $('input:radio[name=throat]:checked').val();
       var general = $('input:radio[name=general]:checked').val();
       var vaccine = $('input:radio[name=vaccine]:checked').val();
       if(patientfullname != ''){


           $.ajax({

              url:"../include/i_patientadmission.php",
              method:"POST",
              data: {id:patientid, fullname:patientfullname, temperature:temperature, headache:headache, respiratory:respiratory, throat:throat, general:general, vaccine:vaccine},

              success:function(data)
              {
                 //alert(data+'triage');
                 console.log(data);
              }

           });

       }else{
         alert('debe completar al menos nombres y apellidos');
       }

     }
     //dental
     function registerdental(){

       var patientid = $('#patientid').val();
       var patientfullname = $('#patientfullname').val();

       var tongue = $('input:radio[name=tongue]:checked').val();
       var piso = $('input:radio[name=piso]:checked').val();
       var encias = $('input:radio[name=encias]:checked').val();
       var mucosa = $('input:radio[name=mucosa]:checked').val();
       var occlusion = $('input:radio[name=occlusion]:checked').val();
       var prosthesis = $('input:radio[name=prosthesis]:checked').val();
       var hygiene = $('input:radio[name=hygiene]:checked').val();

       var lastconsultation = $('#lastconsultation').val();
       var consultation = $('#consultation').val();
       //alert(tongue);
       if(patientfullname != ''){
           $.ajax({

              url:"../include/i_patientadmission.php",
              method:"POST",
              data: {id:patientid, fullname:patientfullname,tongue:tongue, piso:piso, encias:encias, mucosa:mucosa, occlusion:occlusion,
                prosthesis:prosthesis, hygiene:hygiene, lastconsultation:lastconsultation, consultation:consultation},

              success:function(data)
              {
                 //alert(data+'dental');
                 console.log(data);
              }

           });

       }else{
         alert('debe completar al menos nombres y apellidos');
       }

     }
     //diagnostico
     //clinical
     function registerremision(){

       var patientid = $('#patientid').val();
       var patientfullname = $('#patientfullname').val();

       var diagnostico = $('#diagnostico').val();
       var clinical = $('select[name=clinical]').val();
       var examined = $('#examined').val();
       var examinedid = $('#examinedid').val();
       if(patientfullname != ''){
           $.ajax({

              url:"../include/i_patientadmission.php",
              method:"POST",
              data: {id:patientid, fullname:patientfullname, diagnostico:diagnostico, clinical:clinical, examined:examined, examinedid:examinedid},

              success:function(data)
              {
                if(data==''){
                  alert('Se registro de los datos del paciente');
                  location.href="admission.php";
                }else{
                  alert(data);
                  console.log(data);
                }
              }

           });

       }else{
         alert('debe completar al menos nombres y apellidos');
       }
     }
/*
function obten(){
  var x = $('#tr').html();
  alert(x);
}
*/
    function registerodontogram(){

      var patientid = $('#patientid').val();
      var patientfullname = $('#patientfullname').val();

      var tr = $('#tr').html();
      var tl = $('#tl').html();
      var tlr = $('#tlr').html();
      var tll = $('#tll').html();
      var bl = $('#bl').html();
      var br = $('#br').html();
      var bll = $('#bll').html();
      var blr = $('#blr').html();

      if(patientfullname != ''){
          $.ajax({

             url:"../include/i_patientadmission.php",
             method:"POST",
             data: {id:patientid, fullname:patientfullname, tr:tr, tl:tl, tlr:tlr, tll:tll, bl:bl, br:br, bll:bll, blr:blr},

             success:function(data)
             {

                //alert(data);
                console.log(data);

             }

          });

      }else{
        alert('debe completar al menos nombres y apellidos');
      }
    }
    //register patient
    $('#patientregister_button').click(function(){

      if (confirm("Registar todos los datos del paciente?")) {


        if ($('#patientfullname').val()==="" || $('#examined').val()==="") {


          alert('deben completarse al menos nombre del paciente y del estudiante examinado');
        }else{
          var clinical = $('select[name=clinical]').val();
          var examined = $('#examined').val();
          $.ajax({

             url:"../include/i_patientadmission.php",
             method:"POST",
             data: {designed:clinical, student:examined},

             success:function(data)
             {

                if(data == 'yes'){
                  registerpatient();

                  //registerdental();
                  //registertriage();
                  //registerodontogram();

                  //registerremision();

                }else{
                  alert(data);
                }

             }

          });

        }


      }else{
          location.reload();
      }

    });

});
</script>


<script>
$(document).ready(function(){
    $(".btn-primary").click(function(){
        $(".fffa").collapse('toggle');
    });
    $(".btn-success").click(function(){
        $(".fffa").collapse('show');
    });
    $(".btn-warning").click(function(){
        $(".fffa").collapse('hide');
    });
    $(".fffa").on('show.bs.collapse', function(){
        alert('The collapsible content is about to be shown.');
    });
    $(".fffa").on('shown.bs.collapse', function(){
        alert('The collapsible content is now fully shown.');
    });
    $(".fffa").on('hide.bs.collapse', function(){
        alert('The collapsible content is about to be hidden.');
    });
    $(".fffa").on('hidden.bs.collapse', function(){
        alert('The collapsible content is now hidden.');
    });
    $(".sierra").on('hide.bs.collapse', function(){
        alert('The collapsible content is about to be hidden.');
    });
    $(".sierra").on('hidden.bs.collapse', function(){
        alert('The collapsible content is now hidden.');
    });
});
</script>
<!--fin collapse-->
