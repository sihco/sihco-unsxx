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
<?php
if($r["status"]=='process'&& $r["reviewteacher"]!=''&& $r["reviewstatus"]=='f'){
  $usr=DBUserInfo($r['studentid']);
  echo "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">".
    "<strong>".$usr['userfullname']." !</strong> Aun no visualizado por docente.".
    "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>".
  "</div>";
}
if($r["status"]=='process'&& $r["reviewteacher"]!=''&& $r["reviewstatus"]=='t'){
  echo "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">".
    "<strong>Se realizó la revisión por docente.</strong>".
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
            <td><?php if(isset($r['teacherid'])&& $r['teacherid']!=0) echo 'Dr(a). '.DBUserInfo($r['teacherid'])['userfullname'];?></td>
          </tr>
          <tr>
            <th scope="row">Estado de Ficha</th>
            <td>
              <?php
              $namestatus=array(''=>'', 'new'=>'Nuevo', 'process'=>'En proceso', 'fail'=>'Abandonado', 'end'=>'Finalizado', 'canceled'=>'Anulado');
              if(isset($r['status'])&& trim($r['status'])!=''){
                echo $namestatus[$r['status']];
              }
              ?>
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
