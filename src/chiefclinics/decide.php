<?php
require('header.php');

?>

            <!--inicio de div contenido-->
            <div id="layoutSidenav_content">
              <!--inicio de main-->
                <main>
                    <div class="container-fluid px-4">

<br>
<div class="row">
  <div class="col-lg-4 col-md-4 col-sm-12 col-12">
    <div class="from-group">

        <label for="patientfullname">Nombres y Apellidos:</label>
        <!--<input type="text" name="patientfullname" class="form-control" id="patientfullname" value="<?php //echo $a["username"]; ?>"> readonly="readonly"-->

        <div class="dropdown">
          <input type="hidden" name="userid" id="userid" value="">
          <input type="text" class="dropdown-toggle form-control" name="userfullname" id="userfullname" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" placeholder="buscar usuario" autocomplete="off" value="<?php if (isset($_GET["name"])) echo $_GET["name"];?>">

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
    <table class="table table-responsive table-sm table-hover">
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

        <!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>-->
        <script src="../assets/graphic/bootstrap.min.js"></script>

        <!--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>-->
        <script src="../assets/graphic/jquery-3.5.1.min.js"></script>

    </body>
</html>
<script language="JavaScript" src="../sha256.js"></script>
<script language="JavaScript" src="../hex.js"></script>
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


                  /*if(data.indexOf('Data updated.') !== -1)
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

                  }*/

               }
          });
        }else{
          alert('Debes seleccionar una de las especialidades');
        }

     });
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


});
</script>
