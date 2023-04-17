<?php
require('header.php');

?>

                    <div class="container-fluid px-4">
<br>
<div class="row">
  <div class="col-lg-4 col-md-4 col-sm-12 col-12">
    <div class="from-group">

        <label for="patientfullname">Nombres y Apellidos:</label>
        <!--<input type="text" name="patientfullname" class="form-control" id="patientfullname" value="<?php //echo $a["username"]; ?>"> readonly="readonly"-->

        <div class="dropdown">
          <input type="hidden" name="userid" id="userid" value="">
          <input type="text" class="dropdown-toggle form-control" name="userfullname" id="userfullname" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" placeholder="buscar usuario" autocomplete="off" value="<?php if (isset($_GET["name"])) echo $_GET["name"];?>">

          <div class="dropdown-menu" aria-labelledby="search" id="result">

          </div>

        </div>

    </div>
  </div>
  <div class="col-lg-4 col-md-4 col-sm-8 col-8">
    <label for="">Modulos:</label>
    <!--onChange="contestch()" -->
    <select id = "clinical"name="clinical" class="form-select" aria-label="Default select example">
    <?php
    //DBAllClinicalInfo
    $cs = DBAllClinicalInfo();
    $isfake=false;
    $clinical='CIRUGIA BUCAL II';
    for ($i=0; $i<count($cs); $i++) {
      echo "<option value=\"" . $cs[$i]["clinicalid"] . "\" ";
      if ($clinical == $cs[$i]["clinicalspecialty"]) {
        echo "selected";
      }
      echo ">" . $cs[$i]["clinicalspecialty"] ."</option>\n";
    }
    ?>
    <option value="-1" class="text-success bg-warning">Todos</option>
    </select>

  </div>
  <div class="col-lg-4 col-md-4 col-sm-4 col-4">
    <br>
    <button type="button" class="btn btn-success" name="registerclinical_button" id="registerclinical_button">Inscribir</button>
  </div>

</div>






  <script language="javascript">
    function conf2(url) {
      if (confirm("Are you sure?")) {
        document.location=url;
      } else {
        document.location='user.php';
      }
    }
  </script>
<br>

<div class="row">
  <div class="col-12">
    <div class="table-responsive">
    <table class="table table-sm table-hover">
        <thead>
            <tr>
                <th scope="col">ID #</th>
                <th scope="col">Nombre Completo</th>
                <th scope="col">Tipo</th>
                <th scope="col">Especialidad</th>
                <th scope="col">Fecha de Inscripción</th>
                <th scope="col">Fecha de Baja</th>
                <th scope="col">Accion</th>

            </tr>
        </thead>
        <tbody id="cuerpo">

        </tbody>
    </table>
    </div>
  </div>
</div>



</div>

<?php
require('footer.php');
?>



<script>
function save(id, clinical){

  var iduser=id;
  var idclinical=clinical;
  var data='t';
  var uno = document.getElementById(id+''+clinical);

	if(uno.innerText=="Activar"){
		uno.innerText = "Inactivar";
    data='t';
		uno.className="btn btn-danger";
	}else{
    data='f';
		uno.innerText = "Activar";
		uno.className="btn btn-warning";
	}

  $.ajax({

       url:"../include/i_user.php",
       method:"POST",
       data: {userid:iduser, clinicalid:idclinical, status:data},

       success:function(data)
       {
          alert(data);
       }
  });
}
$(document).ready(function(){

     //solo una vez
     $(".click_write").on('click', function(event){
       event.stopPropagation();
       event.stopImmediatePropagation();

       $('#userfullname').val('grover');
       $('#userid').val(1);
     });



     $("#clinical").change(function(){
       //capturamos valor de campo de texto
         var search1 = $('#userfullname').val()
         var search2 = $('select[name=clinical]').val()

         $.ajax({
           type: 'POST',
           url: '../include/search.php',
           data: {'search1': search1, 'search2':search2},
           beforeSend: function(){
             $('#cuerpo').html('<img src="../images/google.gif">')
           }
         })
         .done(function(resultado){
           //div para mostrar resultado
           $('#cuerpo').html(resultado)
         })
         .fail(function(){
           //alerta para un error
           alert('Hubo un error :(')
         })

     });
     //funcion para buscar pacientes
     $('#userfullname').on('keyup', function(){
       //capturamos valor de campo de texto
         var search1 = $('#userfullname').val()
         var search2 = $('select[name=clinical]').val()
         $.ajax({
           type: 'POST',
           url: '../include/search.php',
           data: {'search1': search1},
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

         $.ajax({
           type: 'POST',
           url: '../include/search.php',
           data: {'search1': search1, 'search2':search2},
           beforeSend: function(){
             $('#cuerpo').html('<img src="../images/google.gif">')
           }
         })
         .done(function(resultado){
           //div para mostrar resultado
           $('#cuerpo').html(resultado)
         })
         .fail(function(){
           //alerta para un error
           alert('Hubo un error :(')
         })

     })

     $('#registerclinical_button').click(function(){
        var userid = $('#userid').val();
        var userfullname = $('#userfullname').val();
        var clinical = $('select[name=clinical]').val()
        if(clinical!=''){

          $.ajax({

               url:"../include/i_user.php",
               method:"POST",
               data: {userid:userid, userfullname:userfullname, clinical:clinical},

               success:function(data)
               {

                    alert(data);

                    //capturamos valor de campo de texto
                    var search1 = userfullname
                    var search2 = clinical

                    $.ajax({
                      type: 'POST',
                      url: '../include/search.php',
                      data: {'search1': search1, 'search2':search2},
                      beforeSend: function(){
                        $('#cuerpo').html('<img src="../images/google.gif">')
                      }
                    })
                    .done(function(resultado){
                      //div para mostrar resultado
                      $('#cuerpo').html(resultado)
                    })
                    .fail(function(){
                      //alerta para un error
                      alert('Hubo un error :(')
                    })

               }
          });
        }else{
          alert('Debes seleccionar una de las especialidades');
        }

     });



});
</script>
