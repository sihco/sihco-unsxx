
<!-- para update -->


<div class="modal fade" role="dialog" id="updateModal">
<?php
if(isset($main)&&$main){
  $a=DBUserInfo($_SESSION["usertable2"]["usernumber"]);
}else{
  $a=DBUserInfo($_SESSION["usertable"]["usernumber"]);
}

?>
<div class="modal-dialog">
  <div class="modal-content">

    <div class="modal-header">
      <h3 class="modal-title">Actualizar</h3>

      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">

      <div class="from-group">
        <label for="">Usuario:</label>
        <input type="text" name="username" class="form-control" id="username" value="<?php echo $a["username"]; ?>" readonly="readonly">
      </div>

      <br>
      <div class="from-group">
        <label for="userfull">Nombres y Apellidos</label>
        <input type="text" name="userfull" class="form-control" id="userfull" value="<?php echo $a["userfullname"]; ?>">
      </div>
      <br>
      <div class="from-group">
        <label for="userdesc">Descripcion</label>
        <input type="text" name="userdesc" class="form-control" id="userdesc" value="<?php echo $a["userdesc"]; ?>">
      </div>
      <div class="from-group">
        <label for="passwordo">Anterior contraseña</label>
        <input type="password" name="passwordo" class="form-control" id="passwordo">
      </div>
      <div class="from-group">
        <label for="passwordn1">Nueva contraseña</label>
        <input type="password" name="passwordn1" class="form-control" id="passwordn1">
      </div>
      <div class="from-group">
        <label for="passwordn2">Repetir contraseña nueva</label>
        <input type="password" name="passwordn2" class="form-control" id="passwordn2">
      </div>

    </div>

    <div class="modal-footer">

      <button type="button" class="mx-5 btn btn-danger" data-bs-dismiss="modal" name="cancel_update">Cancelar</button>
      <button type="submit" class="btn btn-success" id="update_button" name="update_button">Actualizar</button>
    </div>

  </div>

  </div>
</div>

<div class="modal fade" role="dialog" id="qrModal">
<?php
$a=DBUserInfo($_SESSION["usertable"]["usernumber"]);
?>
<div class="modal-dialog">
  <div class="modal-content">

    <div class="modal-header">
      <h3 class="modal-title">Código Qr</h3>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">

      <div class="row">
        <div class="col-12" align="center">
          <span class=" text-primary"><b> <?php if($a['usertype']=='teacher') echo "Dr(a). ";echo $a["userfullname"]; ?></b></span>
          <button class="btn btn-outline-warning btn-sm" type="button" name="qr_button" id="qr_button"> Generar Nueva <i class="fa fa-solid fa-qrcode"></i></button>
          <a href="downloadqr.php" class="btn btn-outline-success btn-sm">Descargar <i class="fa fa-solid fa-qrcode"></i></a>

        </div>
        <div class="col-12" id="idqr">
          <?php include('../include/viewqr.php'); ?>
          <!--<img src="../include/qr.php" alt="QR Code" class="w-100">-->
        </div>
      </div>

    </div>

  </div>

  </div>
</div>
