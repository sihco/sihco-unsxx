<?php
require('header.php');
if(isset($_FILES["import"]) && isset($_POST["Submit"]) && $_FILES["import"]["name"]!=""){

    $file="../../tools/importdb.sh";
    $ex = escapeshellcmd($file);

    //tenemos la ruta
    require_once('../db.php');
    @include_once('../version.php');

    DBDropDatabase();

    DBCreateDatabase();

    //permisos de ejecucion
    $text=shell_exec("./".$file." ".$_FILES["import"]["tmp_name"]);
    //echo "(".$text.")";
    if(!$text)
        exit;
    else{
        //echo "importado db";
        MSGError("SE IMPORTÓ LA BASE DE DATOS");
        ForceLoad("backup.php");
    }

}
?>

<!--asdf-->
                    <div class="container-fluid px-4">

                      <div class="container">
                          <div class="row py-5 bg-secondary mt-5 mx-5">
                              <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-5">
                                  <label class="text-white"for="">Para exportar DB click en el Boton</label><br>

                                  <a href="../filedownload0.php" class="btn btn-success">Exportar DB</a>
                              </div>
                              <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                  <form method="POST" action="backup.php" enctype="multipart/form-data">
                                      <div class="from-group">
                                        <label class="text-white" for="import">Archivo para importar DB .sql</label>
                                        <input type="file" name="import" id="import" class="form-control" value="">
                                    </div><br>
                                      <button type="submit" name="Submit" class="btn btn-primary">Importar DB</button>
                                      <label class="text-warning">Nota. Si hay algún error al importar debe cerrar todas las conexciones a DB</label>
                                  </form>
                              </div>
                          </div>
                      </div>
                    </div>

<?php
require('footer.php');
?>
