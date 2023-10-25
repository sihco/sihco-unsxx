<?php
require('header.php');
$fill=false;
if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
  $r=DBPatientRemissionSurgeryiiInfo($id);
  //$r=DBSurgeryiiInfo($id);
  if($r==null){
    ForceLoad("listadmission.php");
  }
  if($r["clinicalid"]!=6)
    ForceLoad("listadmission.php");

}else{
  ForceLoad("listadmission.php");
}
$pat=$r;
?>
<style media="screen">
/*Por debajo de 700px*/
@media screen and (max-width: 700px){
  .readtext{
    font-size: 12px;
  }
}
/*Por debajo de 400px*/
@media screen and (max-width: 400px){
  .readtext{
    font-size: 6px;
  }
}
</style>
                    <div class="container-fluid px-3">
                        <!--<h2 align="center" class="mt-4">
                          Ficha Clinica de Cirugia Bucal II
                        </h2>-->

<div class="card p-3 shadow rounded text-half">
  <div class="fixed-bottom mb-3" align="center">
    <a href="listadmission.php" class="btn btn-outline-secondary">Volver<i class="fa fa-solid fa-reply-all"></i></a>
    <a href="surgeryii.php?id=<?php echo $id; ?>" class="btn btn-sm btn-outline-primary"><i class="fa fa-2x fa-edit"></i></a>
    <a href="reportsurgeryii.php?id=<?php echo $id; ?>" class="btn btn-sm btn-warning"><i class="fa fa-2x fa-solid fa-print"></i></a>



  </div>
  <div class="row readtext">
    <div class="col-6">
      <i>UNIVERSIDAD NACIONAL "SIGLO XX"</i>
    </div>
    <div class="col-6" align="right">
      <i>CARRERA ODONTOLOGÍA ACREDITADA</i>
    </div>
  </div>
  <div class="row readtext">
    <div class="col-12" align="center">
      <b>FICHA CLINICA DE CIRUGIA BUCAL II</b>
    </div>
  </div>
  <br>
  <div class="row readtext">
    <div class="col-8">
      <label for="patientfullname"><b>Nombre del paciente:</b></label>&nbsp;&nbsp;&nbsp;
      <span class="text-secondary">
      <?php
      if(isset($pat["patientname"])){
        echo $pat["patientname"]." ".$pat["patientfirstname"]." ".$pat["patientlastname"];
      }
      ?></span>
    </div>
    <div class="col-4">
      <label for="patientage"><b>Edad:</b></label>&nbsp;&nbsp;&nbsp;
      <span class="text-secondary"><?php if(isset($pat["patientage"])) echo $pat["patientage"];  ?></span>
    </div>
    <div class="col-12 px-5">
      1. Estado general del paciente:
      <span class="text-secondary">
      <?php
      $msg="";
      if(isset($pat["generalstatus"])&& trim($pat["generalstatus"])!='') $msg .= $pat["generalstatus"].'</span>';
      else $msg.="...................................................................................................";
      echo $msg;
      ?>
      </span>
      <br>
      2. Antecedentes psicotraumáticos del paciente:
      <span class="text-secondary">
      <?php
      $msg="";
      if(isset($pat["surgeryiidisease"])&& trim($pat["surgeryiidisease"])!='') $msg .= $pat["surgeryiidisease"].'</span>';
      else $msg.="...................................................................................................";
      echo $msg;
      ?>
      </span>
    </div>
  </div>


  <div class="row readtext">
    <div class="col-12">
      <b>I. Examen Clínico</b><br>
      <u><b>Extraoral</u></b>
    </div>
  </div>
  <div class="row mb-2 readtext">
    <div class="col-4">
      Facies:
      <span class="text-secondary">
      <?php
      $msg="";
      if(isset($pat["dentalfaces"]) && $pat["dentalfaces"]){
          echo ucfirst($pat['dentalfaces']);
      }else{
        echo "............................";
      }
      ?>
      </span>
    </div>
    <div class="col-4">
      <div class="col-4">
        Perfil:
        <span class="text-secondary">
        <?php
        $msg="";
        if(isset($pat["dentalprofile"]) && $pat["dentalprofile"]){
            echo ucfirst($pat['dentalprofile']);
        }else{
          echo "............................";
        }
        ?>
        </span>
      </div>
    </div>
    <div class="col-4">
      Cicatrices:
      <span class="text-secondary">
      <?php
      $msg="";
      if(isset($pat["dentalscars"]) && $pat["dentalscars"]){
          echo ucfirst($pat['dentalscars']);
      }else{
        echo "............................";
      }
      ?>
      </span>
    </div>
  </div>
  <div class="row mb-2 readtext">
    <div class="col-4">
      <div class="input-group input-group-sm">
        A.T.M:&nbsp;
        <span class="text-secondary">
        <?php
        $msg="";
        if(isset($pat["dentalscars"]) && $pat["dentalscars"]){
          if($pat["dentalatm"] == 'normal') echo "Aparentemente Normal";
          if($pat["dentalatm"] == 'dolor') echo "Dolor";
          if($pat["dentalatm"] == 'chasquidos') echo "Chasquidos";
          if($pat["dentalatm"] == 'crujidos') echo "Crujidos";
          if($pat["dentalatm"] == 'dtm') echo "D.T.M";
          if($pat["dentalatm"] == 'trismus') echo "Trismus";
        }else{
          echo "............................";
        }
        ?>
        </span>

      </div>
    </div>
    <div class="col-4">
      <div class="input-group input-group-sm">
        Ganglios:&nbsp;
        <span class="text-secondary">
        <?php
        $msg="";
        if(isset($pat["dentalganglia"]) && $pat["dentalganglia"]){
          if($pat["dentalganglia"] == 'normal') echo "Aparentemente Normal";
          if($pat["dentalganglia"] == 'inflamados') echo "Inflamados";
          if($pat["dentalganglia"] == 'adenitis') echo "Adenitis";
        }else{
          echo "............................";
        }
        ?>
        </span>
      </div>
    </div>
    <div class="col-4">
      <div class="input-group input-group-sm">
        Labios:&nbsp;
        <span class="text-secondary">
        <?php
        $msg="";
        if(isset($pat["dentallips"]) && $pat["dentallips"]){
          if($pat["dentallips"] == 'medianos') echo "Medianos";
          if($pat["dentallips"] == 'delgados') echo "Delgados";
          if($pat["dentallips"] == 'gruesos') echo "Gruesos";
        }else{
          echo "............................";
        }
        ?>
        </span>
      </div>
    </div>


  </div>
  <div class="row mb-2 readtext">
    <div class="col-4">
      <div class="input-group input-group-sm">
        Ulceraciones:&nbsp;
        <span class="text-secondary">
        <?php
        $msg="";
        if(isset($pat["dentalulcerations"]) && $pat["dentalulcerations"]){
          echo ucfirst($pat["dentalulcerations"]);
        }else{
          echo "............................";
        }
        ?>
        </span>
      </div>
    </div>
    <div class="col-4">
      <div class="input-group input-group-sm">
        Queilitis:&nbsp;
        <span class="text-secondary">
        <?php
        $msg="";
        if(isset($pat["dentalcheilitis"]) && $pat["dentalcheilitis"]){
          echo ucfirst($pat["dentalcheilitis"]);
        }else{
          echo "............................";
        }
        ?>
        </span>
      </div>
    </div>

    <div class="col-4">
      <div class="input-group input-group-sm">
        Comisuras:&nbsp;
        <span class="text-secondary">
        <?php
        $msg="";
        if(isset($pat["dentalcommissures"]) && $pat["dentalcommissures"]){
          if($pat["dentalcommissures"] == 'normal') echo "Aparentemente Normal";
          if($pat["dentalcommissures"] == 'presenta') echo "Presenta queilitis";
        }else{
          echo "............................";
        }
        ?>
        </span>
      </div>
    </div>
  </div>
  <div class="row readtext">
    <div class="col-12">
      <u><b>Intraoral</u></b>
    </div>
  </div>
  <div class="row mb-2 readtext">
    <div class="col-4">
      <div class="input-group input-group-sm">
        Lengua:&nbsp;
        <span class="text-secondary">
        <?php
        $msg="";
        if(isset($pat["dentaltongue"]) && $pat["dentaltongue"]){
          if($pat["dentaltongue"] == 'saburra') echo "Saburral";
          if($pat["dentaltongue"] == 'fisurada') echo "Fisurada";
          if($pat["dentaltongue"] == 'geografica') echo "Geográfica";
          if($pat["dentaltongue"] == 'otros') echo "Otros";
        }else{
          echo "............................";
        }
        ?>
        </span>
      </div>
    </div>
    <div class="col-4">
      <div class="input-group input-group-sm">
        Piso de la boca:&nbsp;
        <span class="text-secondary">
        <?php
        $msg="";
        if(isset($pat["dentalpiso"]) && $pat["dentalpiso"]){
          if($pat["dentalpiso"] == 'aparentemente') echo "Aparentemente Normal";
          if($pat["dentalpiso"] == 'toruslingua') echo "Torus Lingual";
          if($pat["dentalpiso"] == 'ranula') echo "Ránula";
          if($pat["dentalpiso"] == 'frenillo') echo "Frenillo lingual Alto";
          if($pat["dentalpiso"] == 'mucocele') echo "Mucocele";
        }else{
          echo "............................";
        }
        ?>
        </span>
      </div>
    </div>
    <div class="col-4">
      <div class="input-group input-group-sm">
        Encias:&nbsp;
        <span class="text-secondary">
        <?php
        $msg="";
        if(isset($pat["dentalencias"]) && $pat["dentalencias"]){
          if($pat["dentalencias"] == 'difusa') echo "Gingivitis Difusa";
          if($pat["dentalencias"] == 'aguda') echo "Gingivitis Aguda";
          if($pat["dentalencias"] == 'gingivitis') echo "Gingivitis cronoca no complicada";
          if($pat["dentalencias"] == 'papilar') echo "Papilar";
          if($pat["dentalencias"] == 'guna') echo "G.U.N.A";
          if($pat["dentalencias"] == 'hiperplasia') echo "Hiperplasia gingival";
        }else{
          echo "............................";
        }
        ?>
        </span>
      </div>
    </div>
  </div>
  <div class="row mb-2 readtext">
    <div class="col-4">
      <div class="input-group input-group-sm">
        Mucosa Bucal:&nbsp;
        <span class="text-secondary">
        <?php
        $msg="";
        if(isset($pat["dentalmucosa"]) && $pat["dentalmucosa"]){
          if($pat["dentalmucosa"] == 'normal') echo "Aparentemente Normal";
          if($pat["dentalmucosa"] == 'alteracion') echo "Con Alteración";
        }else{
          echo "............................";
        }
        ?>
        </span>
      </div>
    </div>
    <div class="col-4">
      <div class="input-group input-group-sm">
        Tipo de Oclusión:&nbsp;
        <span class="text-secondary">
        <?php
        $msg="";
        if(isset($pat["dentaltypeo"]) && $pat["dentaltypeo"]){
          if($pat["dentaltypeo"] == 'normo') echo "Normo oclusion";
          if($pat["dentaltypeo"] == 'disto') echo "Disto oclusion";
          if($pat["dentaltypeo"] == 'mesio') echo "Mesio oclusion";
          if($pat["dentaltypeo"] == 'abierta') echo "Mordida abierta anterior";
        }else{
          echo "............................";
        }
        ?>
        </span>
      </div>
    </div>
    <div class="col-4">
      <div class="input-group input-group-sm">
        Tipo de Protesis:&nbsp;
        <span class="text-secondary">
        <?php
        $msg="";
        if(isset($pat["dentaltypeo"]) && $pat["dentaltypeo"]){
          if($pat["dentaltypep"] == 'removible') echo "Removible";
          if($pat["dentaltypep"] == 'fija') echo "Fija";
          if($pat["dentaltypep"] == 'total') echo "Total";
        }else{
          echo "............................";
        }
        ?>
        </span>
      </div>
    </div>

  </div>
  <div class="row mb-2 readtext">
    <div class="col-4">
      <div class="input-group input-group-sm">
        Higiene Bucal:&nbsp;
        <span class="text-secondary">
        <?php
        $msg="";
        if(isset($pat["dentalhygiene"]) && $pat["dentalhygiene"]){
          if($pat["dentalhygiene"] == 'regular') echo "Regular";
          if($pat["dentalhygiene"] == 'buena') echo "Buena";
          if($pat["dentalhygiene"] == 'mala') echo "Mala";
        }else{
          echo "............................";
        }
        ?>
        </span>
      </div>
    </div>
  </div>

  <div class="row mt-2 readtext">
    <div class="col-12">
      <b>II. Examenes Complementarios</b><br>
    </div>
  </div>
  <div class="row readtext">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
      <div class="input-group input-group-sm">
        <?php
        $msg="";
        if($pat["exam"] == 'periapical'){
          $msg.='<span class="text-secondary">';
          $msg.= "<u>RX PERIAPICAL</u>&nbsp;Pieza:";
          if(isset($pat['pieza'])&& $pat['pieza']!='') $msg.= '&nbsp;'.$pat['pieza'].'&nbsp;';
          else $msg.= '&nbsp;...........&nbsp;';
          $msg.='</span>';
        } else $msg.= "RX PERIAPICAL&nbsp;Pieza:&nbsp;...........&nbsp;";
        $msg.="&nbsp;";
        if($pat["exam"] == 'oclusal'){
          $msg.='<span class="text-secondary">';
          $msg.= "<u>RX OCLUSAL</u>&nbsp;Pieza:";
          if(isset($pat['pieza'])&& $pat['pieza']!='') $msg.= '&nbsp;'.$pat['pieza'].'&nbsp;';
          else $msg.= '&nbsp;...........&nbsp;';
          $msg.='</span>';
        } else $msg.= "RX OCLUSAL&nbsp;Pieza:&nbsp;...........&nbsp;";
        $msg.="&nbsp;";
        if($pat["exam"] == 'panoramico'){
          $msg.='<span class="text-secondary">';
          $msg.= "<u>RX PANORAMICO</u>&nbsp;Pieza:";
          if(isset($pat['pieza'])&& $pat['pieza']!='') $msg.= '&nbsp;'.$pat['pieza'].'&nbsp;';
          else $msg.= '&nbsp;...........&nbsp;';
          $msg.='</span>';
        } else $msg.= "RX PANORAMICO&nbsp;Pieza:&nbsp;...........&nbsp;";
        $msg.="&nbsp;";
        if($pat["exam"] == 'otros'&& $pat['pieza']!=''){
          $msg.='<span class="text-secondary">';
          $msg.= "<u>Otros</u>&nbsp;Pieza:";
          if(isset($pat['pieza'])) $msg.= '&nbsp;'.$pat['pieza'].'&nbsp;';
          else $msg.= '&nbsp;...........&nbsp;';
          $msg.='</span>';
        } else $msg.= "Otros&nbsp;Pieza:&nbsp;...........&nbsp;";

        echo $msg;
        ?>

      </div>
    </div>
  </div>
  <div class="row mt-2 readtext">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
      <label for="diagnostico"><u><b>III. Diagnostico</b></u></label>
      <br>
      <span class="text-secondary">
      <?php
      if(isset($pat["surgeryiidiagnosis"])&& $pat["surgeryiidiagnosis"]!='') echo $pat["surgeryiidiagnosis"];
      else echo ".................................................................................................................................................................................";
      ?>
      </span>
    </div>
  </div>
  <hr>
  <div class="row readtext">
    <div class="col-12">
      <label for=""><u><b>IV. Tratamiento</b></u></label>
    </div>
  </div>
  <div class="row readtext">
    <div class="col-4">
      <div class="input-group input-group-sm">
        <label for="hygiene">a. QUIRURGICO:&nbsp;&nbsp;</label>
        <span class="text-secondary">
        <?php
        if(isset($pat['treatment']['quirurgico'])&& $pat['treatment']['quirurgico']=='true') echo "Si";
        else echo 'No';
        ?>
        </span>
      </div>
      <div class="input-group input-group-sm mt-2">
        <label for="hygiene">b. Medico Farmacologico:&nbsp;&nbsp;</label>
        <span class="text-secondary">
        <?php
        if(isset($pat['treatment']['farmacologico'])&& $pat['treatment']['farmacologico']=='true') echo "Si";
        else echo 'No';
        ?>
        </span>
      </div>
    </div>
    <div class="col-8">
      <div class="input-group input-group-sm">
        <div class="border">
          <table class="table table-sm table-hover table-bordered border-primary">
            <thead>
               <th scope="col">Tecnica Anestesia</th>
               <th scope="col">Autorizado</th>
               <th scope="col">Despachado</th>
            </thead>
            <tbody>
                <?php
                $msg="";
                if(isset($pat['anestesia']['spix'])&& $pat['anestesia']['spix']=='true'){
                  $msg.='<tr class="table-info text-secondary">';
                }else{
                  $msg.='<tr>';
                }
                $msg.='<td>SPIX</td>';
                $msg.='<td>';
                if(isset($pat['anestesia']['spixteacher'])&&$pat['anestesia']['spixteacher']!='*'){
                  $data=explode('*', $pat['anestesia']['spixteacher']);
                  $infouser=DBUserInfo($data[0]);
                  $time=trim($data[1]);
                  $msg.=$infouser['userfullname'].'<br>';
                  $msg.=datetimeconv($time);
                }
                $msg.='</td>';
                $msg.='<td>';
                if(isset($pat['anestesia']['spixnursing'])&&$pat['anestesia']['spixnursing']!='*'){
                  $data=explode('*', $pat['anestesia']['spixnursing']);
                  $infouser=DBUserInfo($data[0]);
                  $time=trim($data[1]);
                  $msg.=$infouser['userfullname'].'<br>';
                  $msg.=datetimeconv($time);
                }
                $msg.='</td>';
                $msg.='</tr>';

                if(isset($pat['anestesia']['mentoniana'])&& $pat['anestesia']['mentoniana']=='true'){
                  $msg.='<tr class="table-info text-secondary">';
                }else{
                  $msg.='<tr>';
                }
                $msg.='<td>MENTONIANA</td>';
                $msg.='<td>';
                if(isset($pat['anestesia']['mentonianateacher'])&&$pat['anestesia']['mentonianateacher']!='*'){
                  $data=explode('*', $pat['anestesia']['mentonianateacher']);
                  $infouser=DBUserInfo($data[0]);
                  $time=trim($data[1]);
                  $msg.=$infouser['userfullname'].'<br>';
                  $msg.=datetimeconv($time);
                }
                $msg.='</td>';
                $msg.='<td>';
                if(isset($pat['anestesia']['mentoniananursing'])&&$pat['anestesia']['mentoniananursing']!='*'){
                  $data=explode('*', $pat['anestesia']['mentoniananursing']);
                  $infouser=DBUserInfo($data[0]);
                  $time=trim($data[1]);
                  $msg.=$infouser['userfullname'].'<br>';
                  $msg.=datetimeconv($time);
                }
                $msg.='</td>';
                $msg.='</tr>';

                if(isset($pat['anestesia']['local'])&& $pat['anestesia']['local']=='true'){
                  $msg.='<tr class="table-info text-secondary">';
                }else{
                  $msg.='<tr>';
                }
                $msg.='<td>LOCAL</td>';
                $msg.='<td>';
                if(isset($pat['anestesia']['localteacher'])&&$pat['anestesia']['localteacher']!='*'){
                  $data=explode('*', $pat['anestesia']['localteacher']);
                  $infouser=DBUserInfo($data[0]);
                  $time=trim($data[1]);
                  $msg.=$infouser['userfullname'].'<br>';
                  $msg.=datetimeconv($time);
                }
                $msg.='</td>';
                $msg.='<td>';
                if(isset($pat['anestesia']['localnursing'])&&$pat['anestesia']['localnursing']!='*'){
                  $data=explode('*', $pat['anestesia']['localnursing']);
                  $infouser=DBUserInfo($data[0]);
                  $time=trim($data[1]);
                  $msg.=$infouser['userfullname'].'<br>';
                  $msg.=datetimeconv($time);
                }
                $msg.='</td>';
                $msg.='</tr>';

                if(isset($pat['anestesia']['infraorbitaria'])&& $pat['anestesia']['infraorbitaria']=='true'){
                  $msg.='<tr class="table-info text-secondary">';
                }else{
                  $msg.='<tr>';
                }
                $msg.='<td>INFRAORBITARIA</td>';
                $msg.='<td>';
                if(isset($pat['anestesia']['infraorbitariateacher'])&&$pat['anestesia']['infraorbitariateacher']!='*'){
                  $data=explode('*', $pat['anestesia']['infraorbitariateacher']);
                  $infouser=DBUserInfo($data[0]);
                  $time=trim($data[1]);
                  $msg.=$infouser['userfullname'].'<br>';
                  $msg.=datetimeconv($time);
                }
                $msg.='</td>';
                $msg.='<td>';
                if(isset($pat['anestesia']['infraorbitarianursing'])&&$pat['anestesia']['infraorbitarianursing']!='*'){
                  $data=explode('*', $pat['anestesia']['infraorbitarianursing']);
                  $infouser=DBUserInfo($data[0]);
                  $time=trim($data[1]);
                  $msg.=$infouser['userfullname'].'<br>';
                  $msg.=datetimeconv($time);
                }
                $msg.='</td>';
                $msg.='</tr>';

                if(isset($pat['anestesia']['tuberositaria'])&& $pat['anestesia']['tuberositaria']=='true'){
                  $msg.='<tr class="table-info text-secondary">';
                }else{
                  $msg.='<tr>';
                }
                $msg.='<td>TUBEROSITARIA</td>';
                $msg.='<td>';
                if(isset($pat['anestesia']['tuberositariateacher'])&&$pat['anestesia']['tuberositariateacher']!='*'){
                  $data=explode('*', $pat['anestesia']['tuberositariateacher']);
                  $infouser=DBUserInfo($data[0]);
                  $time=trim($data[1]);
                  $msg.=$infouser['userfullname'].'<br>';
                  $msg.=datetimeconv($time);
                }
                $msg.='</td>';
                $msg.='<td>';
                if(isset($pat['anestesia']['tuberositarianursing'])&&$pat['anestesia']['tuberositarianursing']!='*'){
                  $data=explode('*', $pat['anestesia']['infraorbitarianursing']);
                  $infouser=DBUserInfo($data[0]);
                  $time=trim($data[1]);
                  $msg.=$infouser['userfullname'].'<br>';
                  $msg.=datetimeconv($time);
                }
                $msg.='</td>';
                $msg.='</tr>';

                if(isset($pat['anestesia']['carrea'])&& $pat['anestesia']['carrea']=='true'){
                  $msg.='<tr class="table-info text-secondary">';
                }else{
                  $msg.='<tr>';
                }
                $msg.='<td>CARREA</td>';
                $msg.='<td>';
                if(isset($pat['anestesia']['carreateacher'])&&$pat['anestesia']['carreateacher']!='*'){
                  $data=explode('*', $pat['anestesia']['carreateacher']);
                  $infouser=DBUserInfo($data[0]);
                  $time=trim($data[1]);
                  $msg.=$infouser['userfullname'].'<br>';
                  $msg.=datetimeconv($time);
                }
                $msg.='</td>';
                $msg.='<td>';
                if(isset($pat['anestesia']['carreanursing'])&&$pat['anestesia']['carreanursing']!='*'){
                  $data=explode('*', $pat['anestesia']['carreanursing']);
                  $infouser=DBUserInfo($data[0]);
                  $time=trim($data[1]);
                  $msg.=$infouser['userfullname'].'<br>';
                  $msg.=datetimeconv($time);
                }
                $msg.='</td>';
                $msg.='</tr>';


                echo $msg;
                ?>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>

  <div class="row mt-3 readtext">
    <div class="col-12">
      <label for=""><u><b>V. Prescripcion Farmacologica</b></u></label>
    </div>
  </div>
  <div class="row mt-2 readtext">
    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
      <label for="prescriptions"><u>RP/</u></label>
      <br>
      <span class="text-secondary">
      <?php
      if(isset($pat["surgeryiiprescriptions"])&& $pat["surgeryiiprescriptions"]!='') echo $pat["surgeryiiprescriptions"];
      else echo ".................................................................................................................................................................................";
      ?>
      </span>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
      <label for="indications"><u>INDICACIONES</u></label>
      <br>
      <span class="text-secondary">
      <?php
      if(isset($pat["surgeryiiindications"])&& $pat["surgeryiiindications"]!='') echo $pat["surgeryiiindications"];
      else echo ".................................................................................................................................................................................";
      ?>
      </span>
    </div>
  </div>
  <div class="row mt-3 readtext">
    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
      <label for="evolution"><u><b>VI. Tratamiento post operatorio y evolución</b></u></label>
      <br>
      <span class="text-secondary">
      <?php
      if(isset($pat["surgeryiievolution"])&& $pat["surgeryiievolution"]!='') echo $pat["surgeryiievolution"];
      else echo ".................................................................................................................................................................................";
      ?>
      </span>
    </div>
    <input type="hidden" name="remissionid" id="remissionid"value="<?php if(isset($_GET['id'])) echo $_GET['id'];?>">
    <input type="hidden" name="ficha" id="ficha"value="<?php if(isset($pat["surgeryiiid"])) echo $pat["surgeryiiid"]?>">

  </div>
  <br>
  <div class="row readtext">
    <div class="col-6">
      <?php
      $name="Docente:&nbsp;&nbsp;&nbsp;&nbsp;";

      if(isset($pat) && $pat['teacherid']!=0){
        $teacher=DBUserInfo($pat['teacherid']);
        $name.='<span class="text-secondary">'.$teacher['userfullname'].'</span><br>Fecha Inicio:&nbsp;&nbsp;&nbsp;&nbsp;';
        if($pat['stdatetime']!=-1){
          $name.='<span class="text-secondary">'.datetimeconv($pat['stdatetime']).'</span>';
        }
      }else{
        $name.="<br>Fecha Inicio:";
      }
      echo $name;
      ?>
    </div>

    <div class="col-6">
      <?php

      $name="Docente:&nbsp;&nbsp;&nbsp;&nbsp;";
      $size=count($pat['areviewteacher']);
      if($size>0){
        $it=DBUserInfo($pat['areviewteacher'][$size-1]['teacher']);
      }

      if(isset($it['userfullname']) && $it['userfullname']!="" && $pat['endatetime']!=-1){
        $name.='<span class="text-secondary">'.$it['userfullname'].'</span><br>Fecha Conclusión:&nbsp;&nbsp;&nbsp;&nbsp;';
        $name.='<span class="text-secondary">'.datetimeconv($pat['endatetime']).'</span>';
      }else{
        $name.="<br>Fecha Conclusión:";
      }
      echo $name;
      ?>
    </div>
  </div>


</div>
<br>


                    </div>

<?php
require('footer.php');
?>
