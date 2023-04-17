<?php
require('header.php');
if(isset($_POST["designed"]) && isset($_POST["clinical"]) && $_POST["designed"]!="" && $_POST["clinical"]!=""){
  DBDesignedTeacher($_SESSION["usertable"]["usernumber"], $_POST['designed'], $_POST["clinical"]);
}

if(isset($_POST['desc']) && isset($_POST['evaluated']) &&
  isset($_POST['status']) && isset($_POST['id'])){
    if($_POST['status']=='--'){
        MSGError('Debe Seleccionar Status');
        ForceLoad('surgeryii.php?id='.$_POST['id']);
    }
    $accepted='f';
    if($_POST['status']=='end')
      $accepted='t';
    if($accepted=='t'&&$_POST['evaluated']=='f'){
      MSGError('Debe seleccionar en Si la fila Revisado');
      ForceLoad('surgeryii.php?id='.$_POST['id']);
    }

  DBEvaluate($_POST['desc'], $_POST['evaluated'], $accepted, $_POST['status'], $_POST['id']);
  MSGError('Se guardo la revisión');
}
if(isset($_GET['id']) && $_GET['id']!=""){

  $f=DBSurgeryiiInfo2($_GET['id']);
  $pat=DBSurgeryiiInfo($_GET['id']);
  $ob=DBAllObservationInfo($f['remission'],$_GET['id']);
}else{
  if(isset($_POST['cid'])&&is_numeric($_POST['cid'])){
    ForceLoad('index.php?id='.$_POST['cid']);
  }else{
      ForceLoad('index.php');
  }
}

?>

            <!--inicio de div contenido-->
            <div id="layoutSidenav_content">
              <!--inicio de main-->
                <main>
                    <div class="container-fluid px-4">

                        <br>
                        <div class="border border-primary">
                          <form class="" action="surgeryii.php" method="post">
                            <input type="hidden" name="id" id="id" value="<?php if(isset($f['ficha'])) echo $f['ficha']; ?>">
                            <input type="hidden" name="cid" id="cid" value="<?php if(isset($pat['clinicalid'])) echo $pat['clinicalid']; ?>">
                          <div class="row">
                            <span align="center"><u><h5>EVALUACION</h5></u></span>
                          </div>
                          <div class="row">
                            <div class="col-7">
                              <table class="table table-bordered table-hover">

                                <tbody>
                                  <tr>
                                    <th scope="row">Estudiante</th>
                                    <td><?php if(isset($f['student'])) echo $f['student']; ?></td>
                                  </tr>
                                  <tr>
                                    <th scope="row">Especilidad</th>
                                    <td><?php if(isset($f['clinicalname'])) echo $f['clinicalname']; ?></td>
                                  </tr>
                                  <tr>
                                    <th scope="row">Visualizar Ficha</th>
                                    <td>
                                      <?php
                                      $report='surgeryii';
                                      if(isset($f['clinical'])&&$f['clinical']==13){
                                        $report.='i';
                                      }

                                      echo " <a href=\"#\" class=\"btn btn-sm btn-primary\" style=\"font-weight:bold\" onClick=\"window.open('report$report.php?id=".$f['ficha']."#toolbar=0', ".
                                  		"'Visualizar Ficha','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
                                  		"resizable=yes')\">Ver</a><br />\n";
                                      ?>
                                    </td>
                                  </tr>
                                  <tr>
                                    <th scope="row">Fecha</th>
                                    <td><?php if(isset($f['time'])) echo dateconv($f['time']); ?></td>
                                  </tr>
                                  <tr>
                                    <th scope="row">Docente Designado</th>
                                    <td><?php if(isset($f['teacher'])) echo DBUserInfo($f['teacher'])['userfullname'];?></td>

                                  </tr>
                                  <tr>
                                    <th scope="row">Revisado</th>
                                    <td>

                                      <select name="evaluated" class="form-select" aria-label="Default select example">

                                        <option <?php if(!isset($f) || $f["evaluated"] == '--') echo "selected"; ?> value="--">--</option>
                                        <option <?php if(isset($f) && $f["evaluated"] == 'f') echo "selected"; ?> value="f">No</option>
                                        <option <?php if(isset($f) && $f["evaluated"] == 't') echo "selected"; ?> value="t">Si</option>
                                      </select>
                                    </td>
                                  </tr>
                                  <tr>
                                    <th scope="row">Estado de Ficha</th>
                                    <td>
                                      <select name="status" class="form-select" aria-label="Default select example">
                                        <option <?php if(!isset($f) || $f["status"] == '--') echo "selected"; ?> value="--">--</option>
                                        <option <?php if(isset($f) && $f["status"] == 'process') echo "selected"; ?> value="process">En Proceso</option>
                                        <option <?php if(isset($f) && $f["status"] == 'canceled') echo "selected"; ?> value="canceled">Anulado</option>
                                        <option <?php if(isset($f) && $f["status"] == 'fail') echo "selected"; ?> value="fail">Abandonado</option>
                                        <option <?php if(isset($f) && $f["status"] == 'end') echo "selected"; ?> value="end">Finalizado</option>
                                      </select>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <div class="col-5">
                              <label for="desc"><u><b>Observaciones</b></u></label>
                              <textarea name="desc" id="desc" class="form-control" rows="8" ><?php if(isset($f['description'])) echo $f['description'];?></textarea>
                            </div>
                          </div>
                          <?php if(isset($f['clinical'])&&$f['clinical']==13){ ?>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">
                              EXAMENES COMPLEMENTARIOS
                            </button>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#operatoria">
                              PRE INTRA POST (OPERATORIO)
                            </button>
                          <?php } ?>
                          <div class="row">
                            <div align="center">
                              <input type="submit" name="" class="btn btn-primary col-4" value="Enviar">
                            </div>
                          </div>
                          <br>
                          </form>
                        </div>
                        <br>

                          <!-- Modal -->
                          <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLongTitle">F. EXAMENES COMPLEMENTARIOS</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <!--CUERPO DE BODY INICIO-->

                                  <div class="row">
                                    <div class="col-12">
                                      <span>EXAMEN DE LABORATORIO:</span>
                                    </div>
                                    <div class="col-12">
                                      <div class="form-check form-check-inline border py-2 pr-2">
                                        <?php
                                        if ((!isset($pat['laboratorio1']))||(isset($pat['laboratorio1'])&&($pat['laboratorio1']=='false'||$pat['laboratorio1']==''))) {
                                          echo "<span class=\"text-primary\" id=\"laboratorio1\"></span>";
                                        }elseif (isset($pat['laboratorio1'])&&$pat['laboratorio1']=='true') {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"laboratorio1\" value=\"option1\">".
                                          "<label class=\"form-check-label\" for=\"laboratorio1\">Firmar</label>";
                                        }elseif (isset($pat['laboratorio1'])&&is_numeric($pat['laboratorio1'])) {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"laboratorio1\" value=\"option1\" checked>".
                                          "<label class=\"form-check-label\" for=\"laboratorio1\">Firmar</label>";
                                        }else{
                                          echo "<span class=\"text-primary\" id=\"laboratorio1\"></span>";
                                        }
                                        ?>
                                        <br><span>hemograma</span>
                                      </div>
                                      <div class="form-check form-check-inline border py-2 pr-2">
                                        <?php
                                        if ((!isset($pat['laboratorio2']))||(isset($pat['laboratorio2'])&&($pat['laboratorio2']=='false'||$pat['laboratorio2']==''))) {
                                          echo "<span class=\"text-primary\" id=\"laboratorio2\"></span>";
                                        }elseif (isset($pat['laboratorio2'])&&$pat['laboratorio2']=='true') {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"laboratorio2\" value=\"option2\">".
                                          "<label class=\"form-check-label\" for=\"laboratorio2\">Firmar</label>";
                                        }elseif (isset($pat['laboratorio2'])&&is_numeric($pat['laboratorio2'])) {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"laboratorio2\" value=\"option2\" checked>".
                                          "<label class=\"form-check-label\" for=\"laboratorio2\">Firmar</label>";
                                        }else{
                                          echo "<span class=\"text-primary\" id=\"laboratorio2\"></span>";
                                        }
                                        ?>
                                        <br><span>cuagulograma</span>
                                      </div>
                                      <div class="form-check form-check-inline border py-2 pr-2">
                                        <?php
                                        if ((!isset($pat['laboratorio3']))||(isset($pat['laboratorio3'])&&($pat['laboratorio3']=='false'||$pat['laboratorio3']==''))) {
                                          echo "<span class=\"text-primary\" id=\"laboratorio3\"></span>";
                                        }elseif (isset($pat['laboratorio3'])&&$pat['laboratorio3']=='true') {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"laboratorio3\" value=\"option3\">".
                                          "<label class=\"form-check-label\" for=\"laboratorio3\">Firmar</label>";
                                        }elseif (isset($pat['laboratorio3'])&&is_numeric($pat['laboratorio3'])) {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"laboratorio3\" value=\"option3\" checked>".
                                          "<label class=\"form-check-label\" for=\"laboratorio3\">Firmar</label>";
                                        }else{
                                          echo "<span class=\"text-primary\" id=\"laboratorio3\"></span>";
                                        }
                                        ?>
                                        <br><span>glicemia</span>
                                      </div>
                                      <div class="form-check form-check-inline border py-2 pr-2">
                                        <?php
                                        if ((!isset($pat['laboratorio4']))||(isset($pat['laboratorio4'])&&($pat['laboratorio4']=='false'||$pat['laboratorio4']==''))) {
                                          echo "<span class=\"text-primary\" id=\"laboratorio4\"></span>";
                                        }elseif (isset($pat['laboratorio4'])&&$pat['laboratorio4']=='true') {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"laboratorio4\" value=\"option4\">".
                                          "<label class=\"form-check-label\" for=\"laboratorio4\">Firmar</label>";
                                        }elseif (isset($pat['laboratorio4'])&&is_numeric($pat['laboratorio4'])) {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"laboratorio4\" value=\"option4\" checked>".
                                          "<label class=\"form-check-label\" for=\"laboratorio4\">Firmar</label>";
                                        }else{
                                          echo "<span class=\"text-primary\" id=\"laboratorio4\"></span>";
                                        }
                                        ?>
                                        <br><span>creatinina</span>
                                      </div>
                                      <div class="form-check form-check-inline border py-2 pr-2">
                                        <?php
                                        if ((!isset($pat['laboratorio5']))||(isset($pat['laboratorio5'])&&($pat['laboratorio5']=='false'||$pat['laboratorio5']==''))) {
                                          echo "<span class=\"text-primary\" id=\"laboratorio5\"></span>";
                                        }elseif (isset($pat['laboratorio5'])&&$pat['laboratorio5']=='true') {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"laboratorio5\" value=\"option5\">".
                                          "<label class=\"form-check-label\" for=\"laboratorio5\">Firmar</label>";
                                        }elseif (isset($pat['laboratorio5'])&&is_numeric($pat['laboratorio5'])) {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"laboratorio5\" value=\"option5\" checked>".
                                          "<label class=\"form-check-label\" for=\"laboratorio5\">Firmar</label>";
                                        }else{
                                          echo "<span class=\"text-primary\" id=\"laboratorio5\"></span>";
                                        }
                                        ?>
                                        <br><span>otros</span>
                                      </div>
                                    </div>
                                    <div class="col-12">
                                      <span>ESTUDIO HISTOPATOLÓGICO:</span>
                                    </div>
                                    <div class="col-12">
                                      <div class="form-check form-check-inline border py-2 pr-2">
                                        <?php
                                        if ((!isset($pat['histopatologico1']))||(isset($pat['histopatologico1'])&&($pat['histopatologico1']=='false'||$pat['histopatologico1']==''))) {
                                          echo "<span class=\"text-primary\" id=\"histopatologico1\"></span>";
                                        }elseif (isset($pat['histopatologico1'])&&$pat['histopatologico1']=='true') {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"histopatologico1\" value=\"option1\">".
                                          "<label class=\"form-check-label\" for=\"histopatologico1\">Firmar</label>";
                                        }elseif (isset($pat['histopatologico1'])&&is_numeric($pat['histopatologico1'])) {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"histopatologico1\" value=\"option1\" checked>".
                                          "<label class=\"form-check-label\" for=\"histopatologico1\">Firmar</label>";
                                        }else{
                                          echo "<span class=\"text-primary\" id=\"histopatologico1\"></span>";
                                        }
                                        ?>
                                        <br><span>citología</span>
                                      </div>
                                      <div class="form-check form-check-inline border py-2 pr-2">
                                        <?php
                                        if ((!isset($pat['histopatologico2']))||(isset($pat['histopatologico2'])&&($pat['histopatologico2']=='false'||$pat['histopatologico2']==''))) {
                                          echo "<span class=\"text-primary\" id=\"histopatologico2\"></span>";
                                        }elseif (isset($pat['histopatologico2'])&&$pat['histopatologico2']=='true') {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"histopatologico2\" value=\"option2\">".
                                          "<label class=\"form-check-label\" for=\"histopatologico2\">Firmar</label>";
                                        }elseif (isset($pat['histopatologico2'])&&is_numeric($pat['histopatologico2'])) {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"histopatologico2\" value=\"option2\" checked>".
                                          "<label class=\"form-check-label\" for=\"histopatologico2\">Firmar</label>";
                                        }else{
                                          echo "<span class=\"text-primary\" id=\"histopatologico2\"></span>";
                                        }
                                        ?>
                                        <br><span>biopsia escisional</span>
                                      </div>
                                      <div class="form-check form-check-inline border py-2 pr-2">
                                        <?php
                                        if ((!isset($pat['histopatologico3']))||(isset($pat['histopatologico3'])&&($pat['histopatologico3']=='false'||$pat['histopatologico3']==''))) {
                                          echo "<span class=\"text-primary\" id=\"histopatologico3\"></span>";
                                        }elseif (isset($pat['histopatologico3'])&&$pat['histopatologico3']=='true') {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"histopatologico3\" value=\"option3\">".
                                          "<label class=\"form-check-label\" for=\"histopatologico3\">Firmar</label>";
                                        }elseif (isset($pat['histopatologico3'])&&is_numeric($pat['histopatologico3'])) {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"histopatologico3\" value=\"option3\" checked>".
                                          "<label class=\"form-check-label\" for=\"histopatologico3\">Firmar</label>";
                                        }else{
                                          echo "<span class=\"text-primary\" id=\"histopatologico3\"></span>";
                                        }
                                        ?>
                                        <br><span>biopsia incisional</span>
                                      </div>
                                      <div class="form-check form-check-inline border py-2 pr-2">
                                        <?php
                                        if ((!isset($pat['histopatologico4']))||(isset($pat['histopatologico4'])&&($pat['histopatologico4']=='false'||$pat['histopatologico4']==''))) {
                                          echo "<span class=\"text-primary\" id=\"histopatologico4\"></span>";
                                        }elseif (isset($pat['histopatologico4'])&&$pat['histopatologico4']=='true') {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"histopatologico4\" value=\"option4\">".
                                          "<label class=\"form-check-label\" for=\"histopatologico4\">Firmar</label>";
                                        }elseif (isset($pat['histopatologico4'])&&is_numeric($pat['histopatologico4'])) {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"histopatologico4\" value=\"option4\" checked>".
                                          "<label class=\"form-check-label\" for=\"histopatologico4\">Firmar</label>";
                                        }else{
                                          echo "<span class=\"text-primary\" id=\"histopatologico4\"></span>";
                                        }
                                        ?>
                                        <br><span>biopsia aspiración</span>
                                      </div>
                                    </div>
                                    <div class="col-12">
                                      <span>DIAGENOLOGÍA:</span>
                                    </div>
                                    <div class="col-12">
                                      <div class="form-check form-check-inline border py-2 pr-2">
                                        <?php
                                        if ((!isset($pat['diagenologia1']))||(isset($pat['diagenologia1'])&&($pat['diagenologia1']=='false'||$pat['diagenologia1']==''))) {
                                          echo "<span class=\"text-primary\" id=\"diagenologia1\"></span>";
                                        }elseif (isset($pat['diagenologia1'])&&$pat['diagenologia1']=='true') {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia1\" value=\"option1\">".
                                          "<label class=\"form-check-label\" for=\"diagenologia1\">Firmar</label>";
                                        }elseif (isset($pat['diagenologia1'])&&is_numeric($pat['diagenologia1'])) {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia1\" value=\"option1\" checked>".
                                          "<label class=\"form-check-label\" for=\"diagenologia1\">Firmar</label>";
                                        }else{
                                          echo "<span class=\"text-primary\" id=\"diagenologia1\"></span>";
                                        }
                                        ?>
                                        <br><span>periapical</span>
                                      </div>
                                      <div class="form-check form-check-inline border py-2 pr-2">
                                        <?php
                                        if ((!isset($pat['diagenologia2']))||(isset($pat['diagenologia2'])&&($pat['diagenologia2']=='false'||$pat['diagenologia2']==''))) {
                                          echo "<span class=\"text-primary\" id=\"diagenologia2\"></span>";
                                        }elseif (isset($pat['diagenologia2'])&&$pat['diagenologia2']=='true') {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia2\" value=\"option2\">".
                                          "<label class=\"form-check-label\" for=\"diagenologia2\">Firmar</label>";
                                        }elseif (isset($pat['diagenologia2'])&&is_numeric($pat['diagenologia2'])) {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia2\" value=\"option2\" checked>".
                                          "<label class=\"form-check-label\" for=\"diagenologia2\">Firmar</label>";
                                        }else{
                                          echo "<span class=\"text-primary\" id=\"diagenologia2\"></span>";
                                        }
                                        ?>
                                        <br><span>oclusal</span>
                                      </div>
                                      <div class="form-check form-check-inline border py-2 pr-2">
                                        <?php
                                        if ((!isset($pat['diagenologia3']))||(isset($pat['diagenologia3'])&&($pat['diagenologia3']=='false'||$pat['diagenologia3']==''))) {
                                          echo "<span class=\"text-primary\" id=\"diagenologia3\"></span>";
                                        }elseif (isset($pat['diagenologia3'])&&$pat['diagenologia3']=='true') {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia3\" value=\"option3\">".
                                          "<label class=\"form-check-label\" for=\"diagenologia3\">Firmar</label>";
                                        }elseif (isset($pat['diagenologia3'])&&is_numeric($pat['diagenologia3'])) {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia3\" value=\"option3\" checked>".
                                          "<label class=\"form-check-label\" for=\"diagenologia3\">Firmar</label>";
                                        }else{
                                          echo "<span class=\"text-primary\" id=\"diagenologia3\"></span>";
                                        }
                                        ?>
                                        <br><span>ortopantomografía</span>
                                      </div>
                                      <div class="form-check form-check-inline border py-2 pr-2">
                                        <?php
                                        if ((!isset($pat['diagenologia4']))||(isset($pat['diagenologia4'])&&($pat['diagenologia4']=='false'||$pat['diagenologia4']==''))) {
                                          echo "<span class=\"text-primary\" id=\"diagenologia4\"></span>";
                                        }elseif (isset($pat['diagenologia4'])&&$pat['diagenologia4']=='true') {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia4\" value=\"option4\">".
                                          "<label class=\"form-check-label\" for=\"diagenologia4\">Firmar</label>";
                                        }elseif (isset($pat['diagenologia4'])&&is_numeric($pat['diagenologia4'])) {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia4\" value=\"option4\" checked>".
                                          "<label class=\"form-check-label\" for=\"diagenologia4\">Firmar</label>";
                                        }else{
                                          echo "<span class=\"text-primary\" id=\"diagenologia4\"></span>";
                                        }
                                        ?>
                                        <br><span>lateral de cráneo</span>
                                      </div>
                                      <div class="form-check form-check-inline border py-2 pr-2">
                                        <?php
                                        if ((!isset($pat['diagenologia5']))||(isset($pat['diagenologia5'])&&($pat['diagenologia5']=='false'||$pat['diagenologia5']==''))) {
                                          echo "<span class=\"text-primary\" id=\"diagenologia5\"></span>";
                                        }elseif (isset($pat['diagenologia5'])&&$pat['diagenologia5']=='true') {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia5\" value=\"option5\">".
                                          "<label class=\"form-check-label\" for=\"diagenologia5\">Firmar</label>";
                                        }elseif (isset($pat['diagenologia5'])&&is_numeric($pat['diagenologia5'])) {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia5\" value=\"option5\" checked>".
                                          "<label class=\"form-check-label\" for=\"diagenologia5\">Firmar</label>";
                                        }else{
                                          echo "<span class=\"text-primary\" id=\"diagenologia5\"></span>";
                                        }
                                        ?>
                                        <br><span>tomografía</span>
                                      </div>
                                      <div class="form-check form-check-inline border py-2 pr-2">
                                        <?php
                                        if ((!isset($pat['diagenologia6']))||(isset($pat['diagenologia6'])&&($pat['diagenologia6']=='false'||$pat['diagenologia6']==''))) {
                                          echo "<span class=\"text-primary\" id=\"diagenologia6\"></span>";
                                        }elseif (isset($pat['diagenologia6'])&&$pat['diagenologia6']=='true') {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia6\" value=\"option6\">".
                                          "<label class=\"form-check-label\" for=\"diagenologia6\">Firmar</label>";
                                        }elseif (isset($pat['diagenologia6'])&&is_numeric($pat['diagenologia6'])) {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia6\" value=\"option6\" checked>".
                                          "<label class=\"form-check-label\" for=\"diagenologia6\">Firmar</label>";
                                        }else{
                                          echo "<span class=\"text-primary\" id=\"diagenologia6\"></span>";
                                        }
                                        ?>
                                        <br><span>otros</span>
                                      </div>
                                    </div>
                                    <div class="col-12">
                                      <span>FOTOGRAFÍA ODONTOLÓGICA:</span>
                                    </div>
                                    <div class="col-12">
                                      <div class="form-check form-check-inline border py-2 pr-2">
                                        <?php
                                        if ((!isset($pat['fotografia1']))||(isset($pat['fotografia1'])&&($pat['fotografia1']=='false'||$pat['fotografia1']==''))) {
                                          echo "<span class=\"text-primary\" id=\"fotografia1\"></span>";
                                        }elseif (isset($pat['fotografia1'])&&$pat['fotografia1']=='true') {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"fotografia1\" value=\"option1\">".
                                          "<label class=\"form-check-label\" for=\"fotografia1\">Firmar</label>";
                                        }elseif (isset($pat['fotografia1'])&&is_numeric($pat['fotografia1'])) {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"fotografia1\" value=\"option1\" checked>".
                                          "<label class=\"form-check-label\" for=\"fotografia1\">Firmar</label>";
                                        }else{
                                          echo "<span class=\"text-primary\" id=\"fotografia1\"></span>";
                                        }
                                        ?>
                                        <br><span>de frente</span>
                                      </div>
                                      <div class="form-check form-check-inline border py-2 pr-2">
                                        <?php
                                        if ((!isset($pat['fotografia2']))||(isset($pat['fotografia2'])&&($pat['fotografia2']=='false'||$pat['fotografia2']==''))) {
                                          echo "<span class=\"text-primary\" id=\"fotografia2\"></span>";
                                        }elseif (isset($pat['fotografia2'])&&$pat['fotografia2']=='true') {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"fotografia2\" value=\"option2\">".
                                          "<label class=\"form-check-label\" for=\"fotografia2\">Firmar</label>";
                                        }elseif (isset($pat['fotografia2'])&&is_numeric($pat['fotografia2'])) {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"fotografia2\" value=\"option2\" checked>".
                                          "<label class=\"form-check-label\" for=\"fotografia2\">Firmar</label>";
                                        }else{
                                          echo "<span class=\"text-primary\" id=\"fotografia2\"></span>";
                                        }
                                        ?>
                                        <br><span>de perfil</span>
                                      </div>
                                      <div class="form-check form-check-inline border py-2 pr-2">
                                        <?php
                                        if ((!isset($pat['fotografia3']))||(isset($pat['fotografia3'])&&($pat['fotografia3']=='false'||$pat['fotografia3']==''))) {
                                          echo "<span class=\"text-primary\" id=\"fotografia3\"></span>";
                                        }elseif (isset($pat['fotografia3'])&&$pat['fotografia3']=='true') {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"fotografia3\" value=\"option3\">".
                                          "<label class=\"form-check-label\" for=\"fotografia3\">Firmar</label>";
                                        }elseif (isset($pat['fotografia3'])&&is_numeric($pat['fotografia3'])) {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"fotografia3\" value=\"option3\" checked>".
                                          "<label class=\"form-check-label\" for=\"fotografia3\">Firmar</label>";
                                        }else{
                                          echo "<span class=\"text-primary\" id=\"fotografia3\"></span>";
                                        }
                                        ?>
                                        <br><span>maxilar intrabucal</span>
                                      </div>
                                      <div class="form-check form-check-inline border py-2 pr-2">
                                        <?php
                                        if ((!isset($pat['fotografia4']))||(isset($pat['fotografia4'])&&($pat['fotografia4']=='false'||$pat['fotografia4']==''))) {
                                          echo "<span class=\"text-primary\" id=\"fotografia4\"></span>";
                                        }elseif (isset($pat['fotografia4'])&&$pat['fotografia4']=='true') {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"fotografia4\" value=\"option4\">".
                                          "<label class=\"form-check-label\" for=\"fotografia4\">Firmar</label>";
                                        }elseif (isset($pat['fotografia4'])&&is_numeric($pat['fotografia4'])) {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"fotografia4\" value=\"option4\" checked>".
                                          "<label class=\"form-check-label\" for=\"fotografia4\">Firmar</label>";
                                        }else{
                                          echo "<span class=\"text-primary\" id=\"fotografia4\"></span>";
                                        }
                                        ?>
                                        <br><span>mandibular intrabucal</span>
                                      </div>
                                      <div class="form-check form-check-inline border py-2 pr-2">
                                        <?php
                                        if ((!isset($pat['fotografia5']))||(isset($pat['fotografia5'])&&($pat['fotografia5']=='false'||$pat['fotografia5']==''))) {
                                          echo "<span class=\"text-primary\" id=\"fotografia5\"></span>";
                                        }elseif (isset($pat['fotografia5'])&&$pat['fotografia5']=='true') {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"fotografia5\" value=\"option5\">".
                                          "<label class=\"form-check-label\" for=\"fotografia5\">Firmar</label>";
                                        }elseif (isset($pat['fotografia5'])&&is_numeric($pat['fotografia5'])) {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"fotografia5\" value=\"option5\" checked>".
                                          "<label class=\"form-check-label\" for=\"fotografia5\">Firmar</label>";
                                        }else{
                                          echo "<span class=\"text-primary\" id=\"fotografia5\"></span>";
                                        }
                                        ?>
                                        <br><span>en oclusión</span>
                                      </div>
                                    </div>
                                    <div class="col-12">
                                      <span>IMPRESIONES:</span>
                                    </div>
                                    <div class="col-12">
                                      <div class="form-check form-check-inline border py-2 pr-2">
                                        <?php
                                        if ((!isset($pat['impresiones1']))||(isset($pat['impresiones1'])&&($pat['impresiones1']=='false'||$pat['impresiones1']==''))) {
                                          echo "<span class=\"text-primary\" id=\"impresiones1\"></span>";
                                        }elseif (isset($pat['impresiones1'])&&$pat['impresiones1']=='true') {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"impresiones1\" value=\"option1\">".
                                          "<label class=\"form-check-label\" for=\"impresiones1\">Firmar</label>";
                                        }elseif (isset($pat['impresiones1'])&&is_numeric($pat['impresiones1'])) {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"impresiones1\" value=\"option1\" checked>".
                                          "<label class=\"form-check-label\" for=\"impresiones1\">Firmar</label>";
                                        }else{
                                          echo "<span class=\"text-primary\" id=\"impresiones1\"></span>";
                                        }
                                        ?>
                                        <br><span>parcial</span>
                                      </div>
                                      <div class="form-check form-check-inline border py-2 pr-2">
                                        <?php
                                        if ((!isset($pat['impresiones2']))||(isset($pat['impresiones2'])&&($pat['impresiones2']=='false'||$pat['impresiones2']==''))) {
                                          echo "<span class=\"text-primary\" id=\"impresiones2\"></span>";
                                        }elseif (isset($pat['impresiones2'])&&$pat['impresiones2']=='true') {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"impresiones2\" value=\"option2\">".
                                          "<label class=\"form-check-label\" for=\"impresiones2\">Firmar</label>";
                                        }elseif (isset($pat['impresiones2'])&&is_numeric($pat['impresiones2'])) {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"impresiones2\" value=\"option2\" checked>".
                                          "<label class=\"form-check-label\" for=\"impresiones2\">Firmar</label>";
                                        }else{
                                          echo "<span class=\"text-primary\" id=\"impresiones2\"></span>";
                                        }
                                        ?>
                                        <br><span>total</span>
                                      </div>
                                    </div>
                                  </div>
                                  <br>
                                  <!--CUERPO DE BODY FIN-->
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                  <button type="button" class="btn btn-success" id="btn_complementario" data-dismiss="modal">Guardar</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!--modal de datos fin-->

                          <!--ficha operatoria inicial-->

                          <!-- Modal -->

                          <div class="modal fade" id="operatoria" tabindex="-1" role="dialog" aria-labelledby="operatoriaTitle"aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">PRE INTRA POST (OPERATORIO)</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <?php
                                  $st=DBAllSurgeryTokenInfo($_GET['id']);//funcion para sacar la informacion
                                  $sw=false;
                                  for ($i=0; $i < count($st); $i++) {
                                    $sw=true;
                                    $userinfo=DBUserInfo($st[$i]['student']);
                                    echo "<input type=\"hidden\" name=\"token[]\" value=\"".$st[$i]['tokenid']."\">".
                                    "<div class=\"row\">".
                                    "  <div align=\"center\" class=\"col-12\">".
                                    "    <u>PREOPERATORIO</u>".
                                    "  </div>".
                                    "  <div class=\"col-12\">".
                                    "    <label for=\"\">Zona a intervenir:</label>".
                                    "    <br>".
                                    "    <div class=\"form-check form-check-inline ml-4\">".
                                    "      <input class=\"form-check-input\" type=\"checkbox\" name=\"preoperatorio1[]\" disabled ".($st[$i]['preoperatorio1']=='true'?'checked':'').">".
                                    "      <label class=\"form-check-label\">maxiliar anterior</label>".
                                    "    </div>".
                                    "    <div class=\"form-check form-check-inline\">".
                                    "      <input class=\"form-check-input\" type=\"checkbox\" name=\"preoperatorio2[]\" disabled ".($st[$i]['preoperatorio2']=='true'?'checked':'').">".
                                    "      <label class=\"form-check-label\">maxiliar posterior</label>".
                                    "    </div>".
                                    "    <div class=\"form-check form-check-inline\">".
                                    "      <input class=\"form-check-input\" type=\"checkbox\" name=\"preoperatorio3[]\" disabled ".($st[$i]['preoperatorio3']=='true'?'checked':'').">".
                                    "      <label class=\"form-check-label\">mandíbula anterior</label>".
                                    "    </div>".
                                    "    <div class=\"form-check form-check-inline\">".
                                    "      <input class=\"form-check-input\" type=\"checkbox\" name=\"preoperatorio4[]\" disabled ".($st[$i]['preoperatorio4']=='true'?'checked':'').">".
                                    "      <label class=\"form-check-label\">mandíbula posterior</label>".
                                    "    </div>".
                                    "  </div>".
                                    "  <div class=\"col-12\">".
                                    "    <label>Diagnostico quirúrgico</label>".
                                    "    <input type=\"text\" class=\"form-control\" name=\"diagnosisquirurjico[]\" value=\"".$st[$i]['tokendiagnosis']."\" disabled>".
                                    "  </div>".
                                    "  <div class=\"col-12\">".
                                    "    <label>Premedicación:</label>".
                                    "    <br>".
                                    "    <div class=\"form-check form-check-inline ml-4\">".
                                    "      <input class=\"form-check-input\" type=\"checkbox\" name=\"premedication1[]\" disabled ".($st[$i]['premedication1']=='true'?'checked':'').">".
                                    "      <label class=\"form-check-label\">Antibióticos</label>".
                                    "    </div>".
                                    "    <div class=\"form-check form-check-inline\">".
                                    "      <input class=\"form-check-input\" type=\"checkbox\" name=\"premedication2\" disabled ".($st[$i]['premedication2']=='true'?'checked':'').">".
                                    "      <label class=\"form-check-label\">Antiinflamatorios</label>".
                                    "    </div>".
                                    "    <div class=\"form-check form-check-inline\">".
                                    "      <input class=\"form-check-input\" type=\"checkbox\" name=\"premedication3\" disabled ".($st[$i]['premedication3']=='true'?'checked':'').">".
                                    "      <label class=\"form-check-label\">Analgésicos</label>".
                                    "    </div>".
                                    "    <div class=\"form-check form-check-inline\">".
                                    "      <input class=\"form-check-input\" type=\"checkbox\" name=\"premedication4\" disabled ".($st[$i]['premedication4']=='true'?'checked':'').">".
                                    "      <label class=\"form-check-label\">Ansiolíticos</label>".
                                    "    </div>".
                                    "  </div>".
                                    "  <div class=\"col-12\">".
                                    "    <div class=\"row\">".
                                    "      <div class=\"col-2\">".
                                    "        Dosis:".
                                    "      </div>".
                                    "      <div class=\"col-4\">".
                                    "        <input type=\"text\" class=\"form-control\" name=\"dosis\" value=\"".$st[$i]['tokendose']."\" disabled>".
                                    "      </div>".
                                    "    </div>".
                                    "  </div>".
                                    "  <div align=\"center\" class=\"col-12\">".
                                    "    <u>INTRAOPERATORIO</u>".
                                    "  </div>".
                                    "  <div class=\"col-12\">".
                                    "    <div class=\"row\">".
                                    "      <div class=\"col-4\">".
                                    "        <label>Fecha:</label>".
                                    "        <input type=\"date\" class=\"form-control\" name=\"intrafecha[]\" value=\"".$st[$i]['tokendate']."\" min=\"2015-01-01\" max=\"2099-01-01\" disabled>".
                                    "      </div>".
                                    "      <div class=\"col-4\">".
                                    "        <label>Hora inicio:</label>".
                                    "        <input type=\"time\" class=\"form-control\" name=\"intrahora1[]\" value=\"".$st[$i]['tokenhourstart']."\" disabled>".
                                    "      </div>".
                                    "      <div class=\"col-4\">".
                                    "          <label>Hora final:</label>".
                                    "          <input type=\"time\" class=\"form-control\" name=\"intrahora2[]\" value=\"".$st[$i]['tokenhourend']."\" disabled>".
                                    "      </div>".
                                    "    </div>".
                                    "  </div>".
                                    "  <div class=\"col-12\">".
                                    "    <div class=\"row\">".
                                    "      <div class=\"col-4\">".
                                    "        <label>Cirujano: ".$userinfo['userfullname']."</label>".
                                    "      </div>".
                                    "      <div class=\"col-8\">".
                                    "        <div class=\"row\">".
                                    "          <div class=\"col-5\">".
                                    "            <label>Asistente/Instrumentista</label>".
                                    "          </div>".
                                    "          <div class=\"col-7\">".
                                    "            <input type=\"text\" class=\"form-control\" name=\"asistente[]\" value=\"".$st[$i]['tokenattendee']."\" disabled>".
                                    "          </div>".
                                    "        </div>".
                                    "      </div>".
                                    "    </div>".
                                    "  </div>".
                                    "  <div class=\"col-12\">".
                                    "    <div class=\"row\">".
                                    "      <div class=\"col-6\">".
                                    "        <label>Medicamento anestésico</label>".
                                    "        <input type=\"text\" class=\"form-control\" name=\"anestesico[]\" value=\"".$st[$i]['tokenanesthetic']."\" disabled>".
                                    "      </div>".
                                    "      <div class=\"col-6\">".
                                    "        <label>Técnica</label>".
                                    "        <input type=\"text\" class=\"form-control\" name=\"tecnica[]\" value=\"".$st[$i]['tokentechnique']."\" disabled>".
                                    "      </div>".
                                    "    </div>".
                                    "  </div>".
                                    "  <div class=\"col-12\">".
                                    "    <br>".
                                    "    <div class=\"row border border-primary p-3\">".
                                    "      <div class=\"col-4\">".
                                    "        <div class=\"form-check form-check-inline\">".
                                    "".($st[$i]['tokenauthorization']=='true'?"<input class=\"form-check-input\" type=\"checkbox\" id=\"autorizacion$i\">":(is_numeric($st[$i]['tokenauthorization'])?"<input class=\"form-check-input\" type=\"checkbox\" id=\"autorizacion$i\" checked>":"<span id=\"autorizacion$i\"></span>"))."".
                                    "          <label class=\"form-check-label\" for=\"autorizacion$i\">Firma de autorización</label>".
                                    "        </div>".
                                    "      </div>".
                                    "      <div class=\"col-4\">".
                                    "        <div class=\"form-check form-check-inline\">".
                                    "".($st[$i]['tokentracing']=='true'?"<input class=\"form-check-input\" type=\"checkbox\" id=\"seguimiento$i\">":(is_numeric($st[$i]['tokentracing'])?"<input class=\"form-check-input\" type=\"checkbox\" id=\"seguimiento$i\" checked>":"<span id=\"seguimiento$i\"></span>"))."".
                                    "          <label class=\"form-check-label\" for=\"seguimiento$i\">Firma de seguimiento</label>".
                                    "        </div>".
                                    "      </div>".
                                    "      <div class=\"col-4\">".
                                    "        <div class=\"form-check form-check-inline\">".
                                    "".($st[$i]['tokenending']=='true'?"<input class=\"form-check-input\" type=\"checkbox\" id=\"finalizacion$i\">":(is_numeric($st[$i]['tokenending'])?"<input class=\"form-check-input\" type=\"checkbox\" id=\"finalizacion$i\" checked>":"<span id=\"finalizacion$i\"></span>"))."".
                                    "          <label class=\"form-check-label\" for=\"finalizacion$i\">Firma de finalización</label>".
                                    "        </div>".
                                    "      </div>".
                                    "    </div>".
                                    "  </div>".
                                    "  <div class=\"col-12\">".
                                    "    <label>Observaciones/recomendaciones del profesor</label>".
                                    "    <input type=\"text\" class=\"form-control\" name=\"obsintra$i\" id=\"obsintra$i\" value=\"".$st[$i]['tokenobsintra']."\">".
                                    "  </div>".
                                    "  <div align=\"center\" class=\"col-12\">".
                                    "    <u>POSTOPERATORIO</u>".
                                    "  </div>".
                                    "  <div class=\"col-12\">".
                                    "    <label>Sensibilidad:</label>".
                                    "    <br>".
                                    "    <div class=\"form-check form-check-inline ml-4\">".
                                    "      <input class=\"form-check-input\" type=\"checkbox\" name=\"sensibilidad1\" disabled ".($st[$i]['sensibilidad1']=='true'?'checked':'').">".
                                    "      <label class=\"form-check-label\">normal</label>".
                                    "    </div>".
                                    "    <div class=\"form-check form-check-inline\">".
                                    "      <input class=\"form-check-input\" type=\"checkbox\" name=\"sensibilidad2\" disabled ".($st[$i]['sensibilidad2']=='true'?'checked':'').">".
                                    "      <label class=\"form-check-label\">parestesia</label>".
                                    "    </div>".
                                    "    <div class=\"form-check form-check-inline\">".
                                    "      <input class=\"form-check-input\" type=\"checkbox\" name=\"sensibilidad3\" disabled ".($st[$i]['sensibilidad3']=='true'?'checked':'').">".
                                    "      <label class=\"form-check-label\">anestesia</label>".
                                    "    </div>".
                                    "    <div class=\"form-check form-check-inline\">".
                                    "      <input class=\"form-check-input\" type=\"checkbox\" name=\"sensibilidad4\" disabled ".($st[$i]['sensibilidad4']=='true'?'checked':'').">".
                                    "      <label class=\"form-check-label\">disestesia</label>".
                                    "    </div>".
                                    "  </div>".
                                    "  <div class=\"col-12\">".
                                    "    <label>Edema:</label>".
                                    "    <br>".
                                    "    <div class=\"form-check form-check-inline ml-4\">".
                                    "      <input class=\"form-check-input\" type=\"checkbox\" name=\"edema1\" disabled ".($st[$i]['edema1']=='true'?'checked':'').">".
                                    "      <label class=\"form-check-label\">ausente</label>".
                                    "    </div>".
                                    "    <div class=\"form-check form-check-inline\">".
                                    "      <input class=\"form-check-input\" type=\"checkbox\" name=\"edema2\" disabled ".($st[$i]['edema2']=='true'?'checked':'').">".
                                    "      <label class=\"form-check-label\">leve</label>".
                                    "    </div>".
                                    "    <div class=\"form-check form-check-inline\">".
                                    "      <input class=\"form-check-input\" type=\"checkbox\" name=\"edema3\" disabled ".($st[$i]['edema3']=='true'?'checked':'').">".
                                    "      <label class=\"form-check-label\">moderado</label>".
                                    "    </div>".
                                    "    <div class=\"form-check form-check-inline\">".
                                    "      <input class=\"form-check-input\" type=\"checkbox\" name=\"edema4\" disabled ".($st[$i]['edema4']=='true'?'checked':'').">".
                                    "      <label class=\"form-check-label\">agudo</label>".
                                    "    </div>".
                                    "  </div>".
                                    "  <div class=\"col-12\">".
                                    "    <label>Mucosa bucal:</label>".
                                    "    <br>".
                                    "    <div class=\"form-check form-check-inline ml-4\">".
                                    "      <input class=\"form-check-input\" type=\"checkbox\" name=\"buccalmucosa1\" disabled ".($st[$i]['buccalmucosa1']=='true'?'checked':'').">".
                                    "      <label class=\"form-check-label\">normal</label>".
                                    "    </div>".
                                    "    <div class=\"form-check form-check-inline\">".
                                    "      <input class=\"form-check-input\" type=\"checkbox\" name=\"buccalmucosa2\" disabled ".($st[$i]['buccalmucosa2']=='true'?'checked':'').">".
                                    "      <label class=\"form-check-label\">alterada</label>".
                                    "    </div>".
                                    "  </div>".
                                    "  <div class=\"col-12\">".
                                    "    <label>Observaciones/recomendaciones del profesor</label>".
                                    "    <input type=\"text\" class=\"form-control\" name=\"obspost$i\" id=\"obspost$i\" value=\"".$st[$i]['tokenobspost']."\">".
                                    "  </div>".
                                    " </div>".
                                    "<hr>";
                                  }
                                  ?>
                                </div>
                                <div class="modal-footer">
                                  <?php
                                  echo "<button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">Cancelar</button>";
                                  if($sw){
                                    echo "<button type=\"button\" class=\"btn btn-success\" id=\"btn_surgery\">Guardar Datos</button>";
                                  }
                                  ?>

                                </div>
                              </div>
                            </div>
                          </div>
                          <!--ficha operatoria final-->



                        <div class="border border-success">
                          <div class="row container">
                            <span align="center"><u><h5>OBSERVACIONES REALIZADAS</h5></u></span>
                            <?php
                            $size=count($ob);
                            for ($i=0; $i <$size ; $i++) {
                              if($ob[$i]['evaluated']=='t'){
                                echo "<div class=\"alert alert-success\" role=\"alert\">".
                                  "<h4 class=\"alert-heading\">Observacion ".($size-$i)."</h4>".
                                  "<p>".$ob[$i]["description"]."</p>".
                                  "<hr>".
                                  "<p class=\"mb-0\">Fecha de observacion: ".dateconv($ob[$i]["time"])."</p>".
                                  "</div>";
                              }

                            }
                            ?>

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
function designed(f){
  alert(f);
}
$(document).ready(function(){
      function complementario(){
         var idfilepageteacher=$('#id').val();

         var laboratorio1 = $('#laboratorio1').prop('checked');
         var laboratorio2 = $('#laboratorio2').prop('checked');
         var laboratorio3 = $('#laboratorio3').prop('checked');
         var laboratorio4 = $('#laboratorio4').prop('checked');
         var laboratorio5 = $('#laboratorio5').prop('checked');
         var histopatologico1 = $('#histopatologico1').prop('checked');
         var histopatologico2 = $('#histopatologico2').prop('checked');
         var histopatologico3 = $('#histopatologico3').prop('checked');
         var histopatologico4 = $('#histopatologico4').prop('checked');
         var diagenologia1 = $('#diagenologia1').prop('checked');
         var diagenologia2 = $('#diagenologia2').prop('checked');
         var diagenologia3 = $('#diagenologia3').prop('checked');
         var diagenologia4 = $('#diagenologia4').prop('checked');
         var diagenologia5 = $('#diagenologia5').prop('checked');
         var diagenologia6 = $('#diagenologia6').prop('checked');
         var fotografia1 = $('#fotografia1').prop('checked');
         var fotografia2 = $('#fotografia2').prop('checked');
         var fotografia3 = $('#fotografia3').prop('checked');
         var fotografia4 = $('#fotografia4').prop('checked');
         var fotografia5 = $('#fotografia5').prop('checked');
         var impresiones1 = $('#impresiones1').prop('checked');
         var impresiones2 = $('#impresiones2').prop('checked');

         $.ajax({

              url:"../include/i_surgery.php",
              method:"POST",
              data: {
                idfilepageteacher:idfilepageteacher, laboratorio1:laboratorio1, laboratorio2:laboratorio2,
                laboratorio3:laboratorio3, laboratorio4:laboratorio4, laboratorio5:laboratorio5,
                histopatologico1:histopatologico1, histopatologico2:histopatologico2, histopatologico3:histopatologico3,
                histopatologico4:histopatologico4, diagenologia1:diagenologia1, diagenologia2:diagenologia2,
                diagenologia3:diagenologia3, diagenologia4:diagenologia4, diagenologia5:diagenologia5,
                diagenologia6:diagenologia6, fotografia1:fotografia1, fotografia2:fotografia2, fotografia3:fotografia3,
                fotografia4:fotografia4, fotografia5:fotografia5, impresiones1:impresiones1, impresiones2:impresiones2
              },
              success:function(data){
                 if(data=='yes'){
                   alert('Se guardo los datos');
                   $('#exampleModalCenter').hide();
                 }else{
                   alert(data);
                   console.log(data);
                 }
              }
         });

      }
      $('#btn_complementario').click(function(){
          complementario();
      });
      $('#btn_surgery').click(function(){
        var fileid=$('#id').val();
        var token='', start='', proces='', end='', obsintra='', obspost='';
        $("input[name='token[]']").each(function(indice, elemento) {
          //console.log('El elemento con el índice '+indice+' contiene '+$(elemento).val());
          token+=$(elemento).val()+',';
          start+=$('#autorizacion'+indice).prop('checked')+',';
          proces+=$('#seguimiento'+indice).prop('checked')+',';
          end+=$('#finalizacion'+indice).prop('checked')+',';
          obsintra+=$('#obsintra'+indice).val()+',';
          obspost+=$('#obspost'+indice).val()+',';
        });
        if(token!=''&&start!=''&&proces!=''&&end!=''){
          $.ajax({
              url:"../include/i_surgeryiii.php",
              method:"POST",
              data: {fileid, token:token, start:start, proces:proces, end:end, obsintra, obspost},
              success:function(data)
              {
                 if(data=='yes'){
                    alert('Se guardo los datos');
                    //$('#operatoria').hide();
                 }else{
                   alert(data);
                   console.log(data);
                 }
              }
         });
       }else{
         alert('No hay datos para guardar');
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
