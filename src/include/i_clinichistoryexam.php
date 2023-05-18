<?php
session_start();//para iniciar session_sta
require_once("../globals.php");
require_once("../db.php");
if(isset($_POST['ch'])&& is_numeric($_POST['ch'])){
  $param['remissionid']=htmlspecialchars($_POST['ch']);

  $r=DBClinicHistoryInfo($param['remissionid']);
  if($r==null){
    echo "No Encontrado Historial Clínico";
    exit;
  }
  $infouser=DBUserInfo($r['studentid']);
  $stname=$infouser['userfullname'];
  $info=DBClinicalInfo($r['clinicalid']);
  $clinicalname=$info['clinicalspecialty'];
}
?>
<div class="mb-3">
  <input type="hidden" name="formch" id="formch" value="<?php if(isset($r['remissionid'])&&is_numeric($r['remissionid'])) echo $r['remissionid']; ?>">
</div>

<?php
if($r["status"]=='process'&& $r["reviewteacher"]!=''&& $r["reviewstatus"]=='f'){
  $usr=DBUserInfo($r['studentid']);
  echo "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">".
    "<strong>".$usr['userfullname']." !</strong> Envió su ficha clínica para la revisión.".
    "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>".
  "</div>";
}
if($r["status"]=='process'&& $r["reviewteacher"]!=''&& $r["reviewstatus"]=='t'){
  echo "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">".
    "<strong>Se realizó la revisión.</strong>".
    "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>".
  "</div>";
}
if($r["status"]=='end'&& $r["reviewteacher"]!=''&& $r["reviewstatus"]=='t'){
  echo "<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">".
    "<strong>Se finalizó la ficha clínica.</strong>".
    "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>".
  "</div>";
}
?>

<div class="mb-3">
  <div class="row">
    <div class="col-lg-7 col-md-7 col-sm-12 col-12">
      <table class="table table-bordered table-hover">
        <tbody>
          <tr>
            <th scope="row">Estudiante</th>
            <td><?php if(isset($stname)) echo $stname; ?></td>
          </tr>
          <tr>
            <th scope="row">Especilidad</th>
            <td><?php if(isset($clinicalname)) echo $clinicalname; ?></td>
          </tr>
          <tr>
            <th scope="row">Visualizar Ficha</th>
            <td>
              <?php
              if (isset($r["inputfile"])&& $r["inputfile"] != null) {
                $tx = $r["inputfilehash"];
                echo "<a href=\"#\" class=\"btn btn-sm btn-outline-primary\" style=\"font-weight:bold\" onClick=\"window.open('../filewindow.php?".filedownload($r["inputfile"], $r["inputfilename"])."', 'Ver - Ficha', 'width=680,height=600,scrollbars=yes,resizable=yes')\"><i class=\"fas fa-2x fa-solid fa-eye\"></i></a>";
                echo "  <a class=\"btn btn-sm btn-outline-success\" href=\"../filedownload.php?" . filedownload($r["inputfile"] ,$r["inputfilename"]) ."\">" .
                      "<i class=\"fas fa-2x fa-solid fa-download\"></i></a>";
              }
              ?>
            </td>
          </tr>
          <?php
          $historytable=array(2=>'removable', 3=>'fixed', 4=>'operative', 5=>'endodontics',
            6=>'surgeryii', 7=>'periodonticsii', 8=>'pediatricsi', 9=>'orthodontics', 10=>'removable',
            11=>'fixed', 12=>'operative', 13=>'endodontics', 14=>'surgeryiii', 15=>'periodonticsiii',
            16=>'pediatricsi', 17=>'orthodontics');

          if($r['clinicalid'] == 6){
            $rs=DBSurgeryiiInfo($r['remissionid'], true);
            if($rs!=null){
              echo "<tr>";
              echo "<th scope=\"row\">Visualizar Ficha Digital</th>";
              echo "<td>";
              echo " <a href=\"#\" class=\"btn btn-sm btn-primary\" style=\"font-weight:bold\" onClick=\"window.open('report".$historytable[$r["clinicalid"]].".php?id=".$r['remissionid']."#toolbar=0', ".
              "'Visualizar Ficha','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
              "resizable=yes')\">Ver</a><br />\n";

              echo "</td>";
              echo "</tr>";
            }
          }

          ?>

          <tr>
            <th scope="row">Fecha Inicio</th>
            <td><?php if(isset($r['stdatetime'])) echo datetimeconv($r['stdatetime']); ?></td>
          </tr>
          <tr>
            <th scope="row">Fecha Culminación</th>
            <td><?php if(isset($r['endatetime'])&& $r['endatetime']!=-1) echo datetimeconv($r['endatetime']); ?></td>
          </tr>
          <tr>
            <th scope="row">Docente Autorizador</th>
            <td><?php if(isset($r['teacherid'])) echo DBUserInfo($r['teacherid'])['userfullname'];?></td>
          </tr>
          <?php
          if($r['teacherid']==$_SESSION['usertable']['usernumber']){
            echo "<tr>";
            echo "  <th scope=\"row\">Interacción de catedráticos</th>";
            echo "  <td>";
            echo "    <select name=\"evaluated\" class=\"form-select\" aria-label=\"Default select example\">";
            echo "    <option ";
            if((!isset($r['reviewany']) || $r['reviewany'] == '--')||(isset($r['reviewany']) && $r['reviewany'] == 'f')) echo "selected";
            echo "value=\"f\">No</option>";
            echo "    <option ";
            if(isset($r['reviewany']) && $r['reviewany'] == 't') echo "selected";
            echo "    value=\"t\">Si</option>";
            echo "  </select>";
            echo "  </td>";
            echo "</tr>";
          }
          ?>
          <tr>
            <th scope="row">Estado de Ficha</th>
            <td>
              <select name="status" class="form-select" aria-label="Default select example">
                <option <?php if(!isset($r['status']) || trim($r["status"]) == '') echo "selected"; ?> value="">--</option>
                <option <?php if(isset($r['status']) && $r["status"] == 'process') echo "selected"; ?> value="process">En Proceso</option>
                <option <?php if(isset($r['status']) && $r["status"] == 'canceled') echo "selected"; ?> value="canceled">Anulado</option>
                <option <?php if(isset($r['status']) && $r["status"] == 'fail') echo "selected"; ?> value="fail">Abandonado</option>
                <option <?php if(isset($r['status']) && $r["status"] == 'end') echo "selected"; ?> value="end">Finalizado</option>
              </select>
            </td>
          </tr>
          <tr>
            <th scope="row">Culminado por</th>
            <td>
              <?php
                if(isset($r['areviewteacher'])&& isset($r['status'])&& trim($r['status'])=='end'){
                  $size=count($r['areviewteacher']);
                  if (is_numeric($r['areviewteacher'][$size-1]['teacher'])) {
                    $it=DBUserInfo($r['areviewteacher'][$size-1]['teacher']);
                    echo "Dr(a). ".$it['userfullname'];
                  }
                }
              ?>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="col-lg-5 col-md-5 col-sm-12 col-12">
      <label for="obsdesc"><u><b>Observaciones</b></u></label>
      <textarea name="obsdesc" id="obsdesc" class="form-control" rows="4" ></textarea>
      <div class="border border-success bordered">
        <div class="row container">
          <span align="center"><u><h6>OBSERVACIONES REALIZADAS</h6></u></span>
            <?php
              if(isset($r['areviewteacher'])){
                $size=count($r['areviewteacher']);
                for ($i=$size-1; $i >=0 ; $i--) {
                  if(is_numeric($r['areviewteacher'][$i]['teacher'])){
                    $it=DBUserInfo($r['areviewteacher'][$i]['teacher']);
                    echo "<div class=\"alert alert-success bordered\" role=\"alert\">".
                      "<h6 class=\"alert-heading\">Observación ".($i+1)."</h6>".

                      "<p>Dr(a). ".$it['userfullname']."</p>".
                      "<p>".$r['areviewteacher'][$i]['obsdesc']."</p>".
                      "<hr>".
                      "<p class=\"mb-0\">".datetimeconv($r['areviewteacher'][$i]['time'])."</p>".
                      "</div>";
                  }

                }
              }
            ?>
          </div>
        </div>
    </div>
  </div>
</div>
