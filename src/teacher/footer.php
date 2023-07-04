
    <!--pie de pagina-->
    <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">UNSXX &copy; Clinica Odontologica 2022-2023</div>
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



<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>-->
<script src="../assets/graphic/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../js/scripts.js"></script>
<script src="../assets/graphic/jquery-3.5.1.min.js"></script>
<script src="../assets/graphic/chart.js"></script>

</body>
</html>
<script language="JavaScript" src="../sha256.js"></script>
<script language="JavaScript" src="../hex.js"></script>
<script>

$(document).ready(function(){

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

//regenerar qr
$('#qr_button').click(function(){
  $.ajax({

       url:"../include/i_qr.php",
       success:function(data){
         $('#idqr').html(data);

         if(data='<img src="../include/qr.php" alt="QR Code" class="w-100">'){
           alert('yes');
         }else{
           alert(data);
         }
       }
  });
});

});
</script>
