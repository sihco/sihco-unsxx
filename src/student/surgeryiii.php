
<?php
require('header.php');
$fill=false;
if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
  $r=DBPatientRemissionSurgeryiiInfo($id);
  //$r=DBSurgeryiiInfo($id);
  if($r==null){
    ForceLoad("index.php");
  }
  if($r["clinicalid"]!=14)
    ForceLoad("index.php");

}else{
  ForceLoad("index.php");
}
$pat=$r;
?>

                    <div class="container-fluid px-4">

                        <h2 align="center" class="mt-4">
                          Ficha Clinica de Cirugia Bucal III
                        </h2>


                        <!--notificaciones inicio-->
                        <?php
                        /*if(isset($pat['observationevaluated'])&&$pat['observationevaluated']=='f'){
                          echo "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">".
                            "<strong>Hola ".$_SESSION['usertable']['username']."!</strong> Tu ficha clinica aun no esta revisado.".
                            "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">".
                            "  <span aria-hidden=\"true\">&times;</span>".
                            "</button>".
                            "</div>";
                        }
                        if(isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f'&&isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t'&&isset($pat['surgeryiistatus'])&&$pat['surgeryiistatus']!='fail'){
                          echo "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">".
                            "<strong>Hola ".$_SESSION['usertable']['username']."!</strong> Tu ficha clinica tiene observaciones:<b>".$pat['observationdesc']."</b>".
                            "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">".
                            "  <span aria-hidden=\"true\">&times;</span>".
                            "</button>".
                            "</div>";
                        }
                        if(isset($pat['observationaccepted'])&&$pat['observationaccepted']=='t'&&isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t'){
                          echo "<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">".
                            "<strong>Hola ".$_SESSION['usertable']['username']."!</strong> Se concluyó tu ficha clinica".
                            "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">".
                            "  <span aria-hidden=\"true\">&times;</span>".
                            "</button>".
                            "</div>";
                        }
                        if(isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f'&&isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t'&&isset($pat['surgeryiistatus'])&&$pat['surgeryiistatus']=='fail'){
                          echo "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">".
                            "<strong>Hola ".$_SESSION['usertable']['username']."!</strong> Tu ficha clinica está en un estado de Abandono.".
                            "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">".
                            "  <span aria-hidden=\"true\">&times;</span>".
                            "</button>".
                            "</div>";
                        }*/

                        ?>

                        <!--notificaciones fin-->
                        <!--MODAL INICIO-->
                        <div class="modal fade" id="detail" tabindex="-1" aria-labelledby="modallabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="modallabel">Detalle de ficha</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="Restart()"></button>
                              </div>
                              <div class="modal-body" id="modaldetail">
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="Restart()">Cerrar</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!--MODAL FIN-->
<div class="card p-3 shadow rounded text-half">

    <?php
    //echo $pat['status'];
    if($pat["teacherid"]!=0&& is_numeric($pat["teacherid"])&& $pat['authorized']=='t'&& $pat['status']=='process'){
      //inicio autorizar por qr
      echo '<div class="fixed-top mt-5 pt-2" align="right"><button type="button" class="btn btn-outline-success btn-sm" name="local_button" onclick="readqr('.$_GET['id'].', \'endqr\')" data-bs-toggle="modal" data-bs-target="#modalqr">Finalizar <i class="fa fa-solid fa-qrcode"></i></button></div>';
      //fin autorizar por qr
    }else{
      if($pat["teacherid"]==0&& $pat['authorized']=='t'){
        echo '<div class="fixed-top mt-5 pt-2" align="right">Autorizando</div>';
      }else{
        if($pat["teacherid"]==0&& $pat['status']='new'){
          //inicio autorizar por qr
          echo '<div class="fixed-top mt-5 pt-2" align="right"><button type="button" class="btn btn-outline-primary btn-sm" name="local_button" onclick="readqr('.$_GET['id'].', \'authorizeqr\')" data-bs-toggle="modal" data-bs-target="#modalqr">Autorizame <i class="fa fa-solid fa-qrcode"></i></button></div>';
          //fin autorizar por qr
        }else{
          if($pat['authorized']=='t'&& $pat['status']=='end'){
            echo '<div class="fixed-top mt-5 pt-2 bg-success" align="right"><span class="text-white">Culminado <i class="fa fa-solid fa-check"></i></span></div>';
          }
        }

      }
    }
    ?>
  <div class="fixed-bottom mb-3" align="center">
    <a href="index.php" class="btn btn-outline-secondary">Volver<i class="fa fa-solid fa-reply-all"></i></a>
    <?php
    if($pat['status']!='end'&& $pat['status']!='canceled'&& $pat['status']!='fail'){
      echo '<button type="button" id="patientregister_button" name="patientregister_button" class="btn btn-success">
        <i class="fas fa-save fa-lg"></i> Guardar
      </button>';
    }
    ?>

    <button type="button" id="file_button" name="patientregister_button" class="btn btn-sm btn-outline-primary" onclick="file(<?php echo $id; ?>)">
      <i class="fas fa-2x fa-solid fa-eye"></i>
    </button>
    <a href="reportsurgeryii.php?id=<?php echo $id; ?>" class="btn btn btn-sm btn-warning"><i class="fa fa-2x fa-solid fa-print"></i></a>

  </div>

  <div class="row">
    <div class="col-12">
      <b>A. DATOS CIVILES</b>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-5 col-md-5 col-sm-12 col-12">
      <input type="hidden" name="patientid" id="patientid" value="<?php if(isset($pat["patientid"])) echo $pat["patientid"];  ?>">
      <label for="patientfullname"><b>Nombre del paciente:</b></label>&nbsp;&nbsp;&nbsp;
      <span class="text-secondary">
      <?php
      if(isset($pat["patientname"])){
        echo $pat["patientname"]." ".$pat["patientfirstname"]." ".$pat["patientlastname"];
      }
      ?></span>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-4">
      <label for="patientage"><b>Edad:</b></label>&nbsp;&nbsp;&nbsp;
      <span class="text-secondary"><?php if(isset($pat["patientage"])) echo $pat["patientage"];  ?></span>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-4">
      <label for="patientgender"><b>Sexo:</b></label>&nbsp;&nbsp;&nbsp;&nbsp;
      <span class="text-secondary">
        <?php
        if(!isset($pat) || $pat["patientgender"] == '--') echo "indefinido";
        if(isset($pat) && $pat["patientgender"] == 'masculino') echo "Masculino";
        if(isset($pat) && $pat["patientgender"] == 'femenino') echo "Femenino";
        ?>
      </span>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-4 col-4">
      <label for="patientgender"><b>Estado Civil:</b></label>&nbsp;&nbsp;&nbsp;&nbsp;
      <span class="text-secondary">
        <?php  if(isset($pat["patientcivilstatus"])) echo $pat['patientcivilstatus'];?>
      </span>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="patientgender"><b>Domicilio:</b></label>&nbsp;&nbsp;&nbsp;&nbsp;
      <span class="text-secondary">
        <?php if(isset($pat["patientdirection"])) echo $pat["patientdirection"]; ?>
      </span>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="patientgender"><b>Ocupación:</b></label>&nbsp;&nbsp;&nbsp;&nbsp;
      <span class="text-secondary">
        <?php if(isset($pat["patientoccupation"])) echo $pat["patientoccupation"]; ?>
      </span>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="patientgender"><b>Procedencia:</b></label>&nbsp;&nbsp;&nbsp;&nbsp;
      <span class="text-secondary">
        <?php if(isset($pat["patientprovenance"])) echo $pat["patientprovenance"]; ?>
      </span>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="patientgender"><b>Fono.:</b></label>&nbsp;&nbsp;&nbsp;&nbsp;
      <span class="text-secondary">
        <?php if(isset($pat["patientphone"])&&$pat['patientphone']!=0) echo $pat["patientphone"]; ?>
      </span>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-lg-2 col-md-2 col-sm-6 col-6">
      <div class="input-group input-group-sm mb-3">
        <label class="input-group-text" for="practice">Práctica N.:</label>
        <input type="text" class="form-control" name="practice" id="practice" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php if(isset($pat["surgeryiipractice"])) echo $pat["surgeryiipractice"];  ?>">
      </div>
    </div>
    <div class="col-lg-5 col-md-5 col-sm-6 col-6">
      <label><b>Supervisado Por Docente:</b></label>&nbsp;&nbsp;&nbsp;&nbsp;
      <span class="text-secondary">
        <?php
        $msg="";
        if(isset($pat['teacher'])&& $pat['teacher']!=0){
          $teacherinfo=DBUserInfo($pat['teacher']);
          $msg.=$teacherinfo['userfullname'];
        }
        echo $msg;
        ?>
      </span>
    </div>
    <div class="col-lg-5 col-md-5 col-sm-6 col-6">
      <label><b>Recepcionado Por Univ.:</b></label>&nbsp;&nbsp;&nbsp;&nbsp;
      <span class="text-secondary">
        <?php if(isset($pat["userfullname"])) echo $pat["userfullname"];?>
      </span>
    </div>
  </div>


  <div class="row">
    <div class="col-12">
      <b>B. ANAMNESIS</b><br>
      <u><b>B1. Anamnesis próxima personal</u></b>
    </div>
  </div>

  
  <div class="row mb-2">
    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="faces">Facies</label>
        <select name="faces" id="faces" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalfaces"] == 'simetrico') echo "selected"; ?> value="simetrico">Simétrico</option>
          <option <?php if(isset($pat) && $pat["dentalfaces"] == 'asimetrico') echo "selected"; ?> value="asimetrico">Asimétrico</option>
        </select>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="profile">Perfil</label>
        <select name="profile" id="profile" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalprofile"] == 'recto') echo "selected"; ?> value="recto">Recto</option>
          <option <?php if(isset($pat) && $pat["dentalprofile"] == 'concavo') echo "selected"; ?> value="concavo">Cóncavo</option>
          <option <?php if(isset($pat) && $pat["dentalprofile"] == 'convexo') echo "selected"; ?> value="convexo">Cónvexo</option>
        </select>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="scars">Cicatrices</label>
        <input type="text" name="scars" class="form-control" id="scars" value="<?php if(isset($pat["dentalscars"]) && $pat['dentalscars']!="") echo $pat["dentalscars"]; else echo "Ninguno"; ?>">
      </div>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="atm">A.T.M</label>
        <select name="atm" id="atm" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalatm"] == 'normal') echo "selected"; ?> value="normal">Aparentemente Normal</option>
          <option <?php if(isset($pat) && $pat["dentalatm"] == 'dolor') echo "selected"; ?> value="dolor">Dolor</option>
          <option <?php if(isset($pat) && $pat["dentalatm"] == 'chasquidos') echo "selected"; ?> value="chasquidos">Chasquidos</option>
          <option <?php if(isset($pat) && $pat["dentalatm"] == 'crujidos') echo "selected"; ?> value="crujidos">Crujidos</option>
          <option <?php if(isset($pat) && $pat["dentalatm"] == 'dtm') echo "selected"; ?> value="dtm">D.T.M</option>
          <option <?php if(isset($pat) && $pat["dentalatm"] == 'trismus') echo "selected"; ?> value="trismus">Trismus</option>
        </select>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="ganglia">Ganglios</label>
        <select name="ganglia" id="ganglia" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalganglia"] == 'normal') echo "selected"; ?> value="normal">Aparentemente Normal</option>
          <option <?php if(isset($pat) && $pat["dentalganglia"] == 'inflamados') echo "selected"; ?> value="inflamados">Inflamados</option>
          <option <?php if(isset($pat) && $pat["dentalganglia"] == 'adenitis') echo "selected"; ?> value="adenitis">Adenitis</option>

        </select>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="lips">Labios</label>
        <select name="lips" id="lips" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentallips"] == 'medianos') echo "selected"; ?> value="medianos">Medianos</option>
          <option <?php if(isset($pat) && $pat["dentallips"] == 'delgados') echo "selected"; ?> value="delgados">Delgados</option>
          <option <?php if(isset($pat) && $pat["dentallips"] == 'gruesos') echo "selected"; ?> value="gruesos">Gruesos</option>
        </select>
      </div>
    </div>
  </div>
  <div class="row mb-2">

    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="ulcerations">Ulceraciones</label>
        <select name="ulcerations" id="ulcerations" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalulcerations"] == 'no') echo "selected"; ?> value="no">No</option>
          <option <?php if(isset($pat) && $pat["dentalulcerations"] == 'si') echo "selected"; ?> value="si">Si</option>
        </select>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="cheilitis">Queilitis</label>
        <select name="cheilitis" id="cheilitis" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalcheilitis"] == 'no') echo "selected"; ?> value="no">No</option>
          <option <?php if(isset($pat) && $pat["dentalcheilitis"] == 'si') echo "selected"; ?> value="si">Si</option>
        </select>
      </div>
    </div>

  </div>
  <div class="row mb-3">
    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="commissures">Comisuras</label>
        <select name="commissures" id="commissures" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalcommissures"] == 'normal') echo "selected"; ?> value="normal">Aparentemente Normal</option>
          <option <?php if(isset($pat) && $pat["dentalcommissures"] == 'presenta') echo "selected"; ?> value="presenta">Presenta queilitis</option>
        </select>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <u><b>Intraoral</u></b>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="tongue">Lengua</label>
        <select name="tongue" id="tongue" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentaltongue"] == 'saburra') echo "selected"; ?> value="saburra">Saburral</option>
          <option <?php if(isset($pat) && $pat["dentaltongue"] == 'fisurada') echo "selected"; ?> value="fisurada">Fisurada</option>
          <option <?php if(isset($pat) && $pat["dentaltongue"] == 'geografica') echo "selected"; ?> value="geografica">Geográfica</option>
          <option <?php if(isset($pat) && $pat["dentaltongue"] == 'otros') echo "selected"; ?> value="otros">Otros</option>
        </select>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="piso">Piso de la boca</label>
        <select name="piso" id="piso" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalpiso"] == 'aparentemente') echo "selected"; ?> value="aparentemente">Aparentemente Normal</option>
          <option <?php if(isset($pat) && $pat["dentalpiso"] == 'toruslingua') echo "selected"; ?> value="toruslingua">Torus Lingua</option>
          <option <?php if(isset($pat) && $pat["dentalpiso"] == 'ranula') echo "selected"; ?> value="ranula">Ránula</option>
          <option <?php if(isset($pat) && $pat["dentalpiso"] == 'frenillo') echo "selected"; ?> value="frenillo">Frenillo lingual Alto</option>
          <option <?php if(isset($pat) && $pat["dentalpiso"] == 'mucocele') echo "selected"; ?> value="mucocele">Mucocele</option>
        </select>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="encias">Encias</label>
        <select name="encias" id="encias" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalencias"] == 'difusa') echo "selected"; ?> value="difusa">Gingivitis Difusa</option>
          <option <?php if(isset($pat) && $pat["dentalencias"] == 'aguda') echo "selected"; ?> value="aguda">Gingivitis Aguda</option>
          <option <?php if(isset($pat) && $pat["dentalencias"] == 'gingivitis') echo "selected"; ?> value="gingivitis">Gingivitis cronoca no complicada</option>
          <option <?php if(isset($pat) && $pat["dentalencias"] == 'papilar') echo "selected"; ?> value="papilar">Papilar</option>
          <option <?php if(isset($pat) && $pat["dentalencias"] == 'guna') echo "selected"; ?> value="guna">G.U.N.A</option>
          <option <?php if(isset($pat) && $pat["dentalencias"] == 'hiperplasia') echo "selected"; ?> value="hiperplasia">Hiperplasia gingival</option>
        </select>
      </div>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="mucosa">Mucosa Bucal</label>
        <select name="mucosa" id="mucosa" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalmucosa"] == 'normal') echo "selected"; ?> value="normal">Aparentemente Normal</option>
          <option <?php if(isset($pat) && $pat["dentalmucosa"] == 'alteracion') echo "selected"; ?> value="alteracion">Con Alteración</option>
        </select>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="occlusion">Tipo de Oclusion</label>
        <select name="occlusion" id="occlusion" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentaltypeo"] == 'normo') echo "selected"; ?> value="normo">Normo oclusion</option>
          <option <?php if(isset($pat) && $pat["dentaltypeo"] == 'disto') echo "selected"; ?> value="disto">Disto oclusion</option>
          <option <?php if(isset($pat) && $pat["dentaltypeo"] == 'mesio') echo "selected"; ?> value="mesio">Mesio oclusion</option>
          <option <?php if(isset($pat) && $pat["dentaltypeo"] == 'abierta') echo "selected"; ?> value="abierta">Mordida Abierta anterior</option>
        </select>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="prosthesis">Tipo de Protesis</label>
        <select name="prosthesis" id="prosthesis" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentaltypep"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat) && $pat["dentaltypep"] == 'removible') echo "selected"; ?> value="removible">Removible</option>
          <option <?php if(isset($pat) && $pat["dentaltypep"] == 'fija') echo "selected"; ?> value="fija">Fija</option>
          <option <?php if(isset($pat) && $pat["dentaltypep"] == 'total') echo "selected"; ?> value="total">Total</option>
        </select>
      </div>
    </div>

  </div>
  <div class="row mb-2">
    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="hygiene">Higiene Bucal</label>
        <select name="hygiene" id="hygiene" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalhygiene"] == 'regular') echo "selected"; ?> value="regular">Regular</option>
          <option <?php if(isset($pat) && $pat["dentalhygiene"] == 'buena') echo "selected"; ?> value="buena">Buena</option>
          <option <?php if(isset($pat) && $pat["dentalhygiene"] == 'mala') echo "selected"; ?> value="mala">Mala</option>
        </select>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <span style="cursor: pointer;"class="text-primary fst-italic btn-link" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="true" aria-controls="panelsStayOpen-collapseFour">Odontograma <i class="fa fa-solid fa-tooth"></i> </span>

      <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFour">
        <div class="accordion-body">
          <input type="hidden" name="odontogram" id="odontogram" value="<?php if(isset($pat["odontogramid"])) echo $pat["odontogramid"];  ?>">
  <!--odontograma inicio-->
          <?php
          include("../leftodontogram.php");
          $odontogramstatus="false";
          if (isset($pat['draw'])){
            $pat=decryptOdontogram($pat);
            $odontogramstatus="true";
          }
          ?>
  <!--odontograma fin-->
        <input type="hidden" name="draw" id="draw" value="<?php if(isset($pat["draw"])) echo $pat["draw"];?>">

        </div>
      </div>
    </div>
  </div>
  <div class="row mt-2">
    <div class="col-12">
      <b>II. Examenes Complementarios</b><br>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
      <div class="input-group input-group-sm">
        <!--<label class="input-group-text" for="exam"><u><b>Examenes Complementarios</b></u></label>-->
        <select name="exam" id="exam" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat["exam"]) || $pat["exam"] == '--') echo "selected"; ?> value="--">--</option>
          <option <?php if(isset($pat["exam"]) && $pat["exam"] == 'periapical') echo "selected"; ?> value="periapical">RX PERIAPICAL</option>
          <option <?php if(isset($pat["exam"]) && $pat["exam"] == 'oclusal') echo "selected"; ?> value="oclusal">RX OCLUSAL</option>
          <option <?php if(isset($pat["exam"]) && $pat["exam"] == 'panoramico') echo "selected"; ?> value="panoramico">RX PANORAMICO</option>
          <option <?php if(isset($pat["exam"]) && $pat["exam"] == 'otros') echo "selected"; ?> value="otros">Otros</option>
        </select>
        <label class="input-group-text" for="pieza">Pieza</label>
        <input type="text" name="pieza" class="form-control" id="pieza" value="<?php if(isset($pat['pieza'])) echo $pat['pieza'] ?>">
      </div>
    </div>
  </div>
  <div class="row mt-2">
    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
      <label for="diagnostico"><u><b>III. Diagnostico</b></u></label>
      <div class="input-group input-group-sm">
        <textarea class="form-control" id="diagnostico" name="diagnostico" rows="2"><?php if(isset($pat["surgeryiidiagnosis"])) echo $pat["surgeryiidiagnosis"];  ?></textarea>
      </div>
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-12">
      <label for=""><u><b>IV. Tratamiento</b></u></label>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="hygiene">a. QUIRURGICO:</label>
        <label class="input-group-text" for="quirurgico">No</label>
        <div class="form-check form-switch border my-1">
          <input class="form-check-input" type="checkbox" id="quirurgico" <?php if(isset($pat['treatment']['quirurgico'])&& $pat['treatment']['quirurgico']=='true') echo "checked"; ?>>
        </div>
        <label class="input-group-text" for="quirurgico">Si</label>
      </div>
      <div class="input-group input-group-sm mt-2">
        <label class="input-group-text" for="farmacologico">b. Medico Farmacologico:</label>
        <label class="input-group-text" for="farmacologico">No</label>
        <div class="form-check form-switch border my-1">
          <input class="form-check-input" type="checkbox" id="farmacologico" <?php if(isset($pat['treatment']['farmacologico'])&& $pat['treatment']['farmacologico']=='true') echo "checked"; ?>>
        </div>
        <label class="input-group-text" for="farmacologico">Si</label>
      </div>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-12 col-12">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="hygiene">Tecnicas Anestesicas</label>
        <div class="border">
          <div class="from-check form-check-inline border p-3" align="center">
            <input class="form-check-input" type="checkbox" id="spix" <?php if(isset($pat['anestesia']['spix'])&& $pat['anestesia']['spix']=='true') echo "checked"; ?>>
            <label for="spix">SPIX</label>
            <br>
            <div class="autorizar" id="a_spixteacher">
              <?php
              if(isset($pat['anestesia']['spixteacher'])&&$pat['anestesia']['spixteacher']!='*'){
                $data=explode('*', $pat['anestesia']['spixteacher']);
                $infouser=DBUserInfo($data[0]);
                $time=trim($data[1]);
                $msg='<span style="cursor: pointer;"class="text-primary fst-italic" data-bs-toggle="collapse"
                 data-bs-target="#spix_infoteacher" aria-expanded="true" aria-controls="spix_infoteacher">Autorizado Por Docente</span>';
                $msg.='<div id="spix_infoteacher" class="accordion-collapse collapse" aria-labelledby="spix_infoteacher">'.
                '<div class="accordion-body"><div class="row"><div class="col-12">'.$infouser['userfullname'].'</div><div class="col-12">'.datetimeconv($time).'</div></div></div></div>';
                echo $msg;
              }else{
                  echo '<button type="button" class="btn btn-outline-primary btn-sm" name="spix_button" onclick="readqr(\'spix\', \'authorizeqrtwo\')" data-bs-toggle="modal" data-bs-target="#modalqr">Docente <i class="fa fa-solid fa-qrcode"></i></button>';
              }
              ?>
            </div>
            <div class="mt-1 autorizar" id="a_spixnursing">
              <?php
              if(isset($pat['anestesia']['spixnursing'])&&$pat['anestesia']['spixnursing']!='*'){
                $data=explode('*', $pat['anestesia']['spixnursing']);
                $infouser=DBUserInfo($data[0]);
                $time=trim($data[1]);
                $msg='<span style="cursor: pointer;"class="text-success fst-italic" data-bs-toggle="collapse"
                 data-bs-target="#spix_infonursing" aria-expanded="true" aria-controls="spix_infonursing">Despachado</span>';
                $msg.='<div id="spix_infonursing" class="accordion-collapse collapse" aria-labelledby="spix_infonursing">'.
                '<div class="accordion-body"><div class="row"><div class="col-12">'.$infouser['userfullname'].'</div><div class="col-12">'.datetimeconv($time).'</div></div></div></div>';
                echo $msg;
              }else{
                  echo '<button type="button" class="btn btn-outline-success btn-sm" name="spix_button" onclick="readqr(\'spix\', \'authorizeqrtwo\')" data-bs-toggle="modal" data-bs-target="#modalqr">Enfermeria <i class="fa fa-solid fa-qrcode"></i></button>';
              }
              ?>

            </div>
          </div>
          <div class="from-check form-check-inline border p-3" align="center">
            <input class="form-check-input" type="checkbox" id="mentoniana" <?php if(isset($pat['anestesia']['mentoniana'])&& $pat['anestesia']['mentoniana']=='true') echo "checked"; ?>>
            <label for="mentoniana">MENTONIANA</label>
            <br>
            <div class="autorizar" id="a_mentonianateacher">
              <?php
              if(isset($pat['anestesia']['mentonianateacher'])&&$pat['anestesia']['mentonianateacher']!='*'){
                $data=explode('*', $pat['anestesia']['mentonianateacher']);
                $infouser=DBUserInfo($data[0]);
                $time=trim($data[1]);
                $msg='<span style="cursor: pointer;"class="text-primary fst-italic" data-bs-toggle="collapse"
                 data-bs-target="#mentoniana_infoteacher" aria-expanded="true" aria-controls="mentoniana_infoteacher">Autorizado Por Docente</span>';
                $msg.='<div id="mentoniana_infoteacher" class="accordion-collapse collapse" aria-labelledby="mentoniana_infoteacher">'.
                '<div class="accordion-body"><div class="row"><div class="col-12">'.$infouser['userfullname'].'</div><div class="col-12">'.datetimeconv($time).'</div></div></div></div>';
                echo $msg;
              }else{
                  echo '<button type="button" class="btn btn-outline-primary btn-sm" name="mentoniana_button" onclick="readqr(\'mentoniana\', \'authorizeqrtwo\')" data-bs-toggle="modal" data-bs-target="#modalqr">Docente <i class="fa fa-solid fa-qrcode"></i></button>';
              }
              ?>
            </div>
            <div class="mt-1 autorizar" id="a_mentoniananursing">
              <?php
              if(isset($pat['anestesia']['mentoniananursing'])&&$pat['anestesia']['mentoniananursing']!='*'){
                $data=explode('*', $pat['anestesia']['mentoniananursing']);
                $infouser=DBUserInfo($data[0]);
                $time=trim($data[1]);
                $msg='<span style="cursor: pointer;"class="text-success fst-italic" data-bs-toggle="collapse"
                 data-bs-target="#mentoniana_infonursing" aria-expanded="true" aria-controls="mentoniana_infonursing">Despachado</span>';
                $msg.='<div id="mentoniana_infonursing" class="accordion-collapse collapse" aria-labelledby="mentoniana_infonursing">'.
                '<div class="accordion-body"><div class="row"><div class="col-12">'.$infouser['userfullname'].'</div><div class="col-12">'.datetimeconv($time).'</div></div></div></div>';
                echo $msg;
              }else{
                  echo '<button type="button" class="btn btn-outline-success btn-sm" name="mentoniana_button" onclick="readqr(\'mentoniana\', \'authorizeqrtwo\')" data-bs-toggle="modal" data-bs-target="#modalqr">Enfermeria <i class="fa fa-solid fa-qrcode"></i></button>';
              }
              ?>
            </div>
          </div>
          <div class="from-check form-check-inline border p-3" align="center">
            <input class="form-check-input" type="checkbox" id="local" <?php if(isset($pat['anestesia']['local'])&& $pat['anestesia']['local']=='true') echo "checked"; ?>>
            <label for="local">LOCAL</label>
            <br>
            <div class="autorizar" id="a_localteacher">
              <?php
              if(isset($pat['anestesia']['localteacher'])&&$pat['anestesia']['localteacher']!='*'){
                $data=explode('*', $pat['anestesia']['localteacher']);
                $infouser=DBUserInfo($data[0]);
                $time=trim($data[1]);
                $msg='<span style="cursor: pointer;"class="text-primary fst-italic" data-bs-toggle="collapse"
                 data-bs-target="#local_infoteacher" aria-expanded="true" aria-controls="local_infoteacher">Autorizado Por Docente</span>';
                $msg.='<div id="local_infoteacher" class="accordion-collapse collapse" aria-labelledby="local_infoteacher">'.
                '<div class="accordion-body"><div class="row"><div class="col-12">'.$infouser['userfullname'].'</div><div class="col-12">'.datetimeconv($time).'</div></div></div></div>';
                echo $msg;
              }else{
                  echo '<button type="button" class="btn btn-outline-primary btn-sm" name="local_button" onclick="readqr(\'local\', \'authorizeqrtwo\')" data-bs-toggle="modal" data-bs-target="#modalqr">Docente <i class="fa fa-solid fa-qrcode"></i></button>';
              }
              ?>
            </div>
            <div class="mt-1 autorizar" id="a_localnursing">
              <?php
              if(isset($pat['anestesia']['localnursing'])&&$pat['anestesia']['localnursing']!='*'){
                $data=explode('*', $pat['anestesia']['localnursing']);
                $infouser=DBUserInfo($data[0]);
                $time=trim($data[1]);
                $msg='<span style="cursor: pointer;"class="text-success fst-italic" data-bs-toggle="collapse"
                 data-bs-target="#local_infonursing" aria-expanded="true" aria-controls="local_infonursing">Despachado</span>';
                $msg.='<div id="local_infonursing" class="accordion-collapse collapse" aria-labelledby="local_infonursing">'.
                '<div class="accordion-body"><div class="row"><div class="col-12">'.$infouser['userfullname'].'</div><div class="col-12">'.datetimeconv($time).'</div></div></div></div>';
                echo $msg;
              }else{
                  echo '<button type="button" class="btn btn-outline-success btn-sm" name="local_button" onclick="readqr(\'local\', \'authorizeqrtwo\')" data-bs-toggle="modal" data-bs-target="#modalqr">Enfermeria <i class="fa fa-solid fa-qrcode"></i></button>';
              }
              ?>
            </div>
          </div>
          <div class="from-check form-check-inline border p-3" align="center">
            <input class="form-check-input" type="checkbox" id="infraorbitaria" <?php if(isset($pat['anestesia']['infraorbitaria'])&& $pat['anestesia']['infraorbitaria']=='true') echo "checked"; ?>>
            <label for="infraorbitaria">INFRAORBITARIA</label>
            <br>
            <div class="autorizar" id="a_infraorbitariateacher">
              <?php
              if(isset($pat['anestesia']['infraorbitariateacher'])&&$pat['anestesia']['infraorbitariateacher']!='*'){
                $data=explode('*', $pat['anestesia']['infraorbitariateacher']);
                $infouser=DBUserInfo($data[0]);
                $time=trim($data[1]);
                $msg='<span style="cursor: pointer;"class="text-primary fst-italic" data-bs-toggle="collapse"
                 data-bs-target="#infraorbitaria_infoteacher" aria-expanded="true" aria-controls="infraorbitaria_infoteacher">Autorizado Por Docente</span>';
                $msg.='<div id="infraorbitaria_infoteacher" class="accordion-collapse collapse" aria-labelledby="infraorbitaria_infoteacher">'.
                '<div class="accordion-body"><div class="row"><div class="col-12">'.$infouser['userfullname'].'</div><div class="col-12">'.datetimeconv($time).'</div></div></div></div>';
                echo $msg;
              }else{
                  echo '<button type="button" class="btn btn-outline-primary btn-sm" name="infraorbitaria_button" onclick="readqr(\'infraorbitaria\', \'authorizeqrtwo\')" data-bs-toggle="modal" data-bs-target="#modalqr">Docente <i class="fa fa-solid fa-qrcode"></i></button>';
              }
              ?>
            </div>
            <div class="mt-1 autorizar" id="a_infraorbitarianursing">
              <?php
              if(isset($pat['anestesia']['infraorbitarianursing'])&&$pat['anestesia']['infraorbitarianursing']!='*'){
                $data=explode('*', $pat['anestesia']['infraorbitarianursing']);
                $infouser=DBUserInfo($data[0]);
                $time=trim($data[1]);
                $msg='<span style="cursor: pointer;"class="text-success fst-italic" data-bs-toggle="collapse"
                 data-bs-target="#infraorbitaria_infonursing" aria-expanded="true" aria-controls="infraorbitaria_infonursing">Despachado</span>';
                $msg.='<div id="infraorbitaria_infonursing" class="accordion-collapse collapse" aria-labelledby="infraorbitaria_infonursing">'.
                '<div class="accordion-body"><div class="row"><div class="col-12">'.$infouser['userfullname'].'</div><div class="col-12">'.datetimeconv($time).'</div></div></div></div>';
                echo $msg;
              }else{
                  echo '<button type="button" class="btn btn-outline-success btn-sm" name="infraorbitaria_button" onclick="readqr(\'infraorbitaria\', \'authorizeqrtwo\')" data-bs-toggle="modal" data-bs-target="#modalqr">Enfermeria <i class="fa fa-solid fa-qrcode"></i></button>';
              }
              ?>
            </div>
          </div>
          <div class="from-check form-check-inline border p-3" align="center">
            <input class="form-check-input" type="checkbox" id="tuberositaria" <?php if(isset($pat['anestesia']['tuberositaria'])&& $pat['anestesia']['tuberositaria']=='true') echo "checked"; ?>>
            <label for="tuberositaria">TUBEROSITARIA</label>
            <br>
            <div class="autorizar" id="a_tuberositariateacher">
              <?php
              if(isset($pat['anestesia']['tuberositariateacher'])&&$pat['anestesia']['tuberositariateacher']!='*'){
                $data=explode('*', $pat['anestesia']['tuberositariateacher']);
                $infouser=DBUserInfo($data[0]);
                $time=trim($data[1]);
                $msg='<span style="cursor: pointer;"class="text-primary fst-italic" data-bs-toggle="collapse"
                 data-bs-target="#tuberositaria_infoteacher" aria-expanded="true" aria-controls="tuberositaria_infoteacher">Autorizado Por Docente</span>';
                $msg.='<div id="tuberositaria_infoteacher" class="accordion-collapse collapse" aria-labelledby="tuberositaria_infoteacher">'.
                '<div class="accordion-body"><div class="row"><div class="col-12">'.$infouser['userfullname'].'</div><div class="col-12">'.datetimeconv($time).'</div></div></div></div>';
                echo $msg;
              }else{
                  echo '<button type="button" class="btn btn-outline-primary btn-sm" name="tuberositaria_button" onclick="readqr(\'tuberositaria\', \'authorizeqrtwo\')" data-bs-toggle="modal" data-bs-target="#modalqr">Docente <i class="fa fa-solid fa-qrcode"></i></button>';
              }
              ?>
            </div>
            <div class="mt-1 autorizar" id="a_tuberositarianursing">
              <?php
              if(isset($pat['anestesia']['tuberositarianursing'])&&$pat['anestesia']['tuberositarianursing']!='*'){
                $data=explode('*', $pat['anestesia']['tuberositarianursing']);
                $infouser=DBUserInfo($data[0]);
                $time=trim($data[1]);
                $msg='<span style="cursor: pointer;"class="text-success fst-italic" data-bs-toggle="collapse"
                 data-bs-target="#tuberositaria_infonursing" aria-expanded="true" aria-controls="tuberositaria_infonursing">Despachado</span>';
                $msg.='<div id="tuberositaria_infonursing" class="accordion-collapse collapse" aria-labelledby="tuberositaria_infonursing">'.
                '<div class="accordion-body"><div class="row"><div class="col-12">'.$infouser['userfullname'].'</div><div class="col-12">'.datetimeconv($time).'</div></div></div></div>';
                echo $msg;
              }else{
                  echo '<button type="button" class="btn btn-outline-success btn-sm" name="tuberositaria_button" onclick="readqr(\'tuberositaria\', \'authorizeqrtwo\')" data-bs-toggle="modal" data-bs-target="#modalqr">Enfermeria <i class="fa fa-solid fa-qrcode"></i></button>';
              }
              ?>
            </div>
          </div>
          <div class="from-check form-check-inline border p-3" align="center">
            <input class="form-check-input" type="checkbox" id="carrea" <?php if(isset($pat['anestesia']['carrea'])&& $pat['anestesia']['carrea']=='true') echo "checked"; ?>>
            <label for="carrea">CARREA</label>
            <br>
            <div class="autorizar" id="a_carreateacher">
              <?php
              if(isset($pat['anestesia']['carreateacher'])&&$pat['anestesia']['carreateacher']!='*'){
                $data=explode('*', $pat['anestesia']['carreateacher']);
                $infouser=DBUserInfo($data[0]);
                $time=trim($data[1]);
                $msg='<span style="cursor: pointer;"class="text-primary fst-italic" data-bs-toggle="collapse"
                 data-bs-target="#carrea_infoteacher" aria-expanded="true" aria-controls="carrea_infoteacher">Autorizado Por Docente</span>';
                $msg.='<div id="carrea_infoteacher" class="accordion-collapse collapse" aria-labelledby="carrea_infoteacher">'.
                '<div class="accordion-body"><div class="row"><div class="col-12">'.$infouser['userfullname'].'</div><div class="col-12">'.datetimeconv($time).'</div></div></div></div>';
                echo $msg;
              }else{
                  echo '<button type="button" class="btn btn-outline-primary btn-sm" name="carrea_button" onclick="readqr(\'carrea\', \'authorizeqrtwo\')" data-bs-toggle="modal" data-bs-target="#modalqr">Docente <i class="fa fa-solid fa-qrcode"></i></button>';
              }
              ?>
            </div>
            <div class="mt-1 autorizar" id="a_carreanursing">
              <?php
              if(isset($pat['anestesia']['carreanursing'])&&$pat['anestesia']['carreanursing']!='*'){
                $data=explode('*', $pat['anestesia']['carreanursing']);
                $infouser=DBUserInfo($data[0]);
                $time=trim($data[1]);
                $msg='<span style="cursor: pointer;"class="text-success fst-italic" data-bs-toggle="collapse"
                 data-bs-target="#carrea_infonursing" aria-expanded="true" aria-controls="carrea_infonursing">Despachado</span>';
                $msg.='<div id="carrea_infonursing" class="accordion-collapse collapse" aria-labelledby="carrea_infonursing">'.
                '<div class="accordion-body"><div class="row"><div class="col-12">'.$infouser['userfullname'].'</div><div class="col-12">'.datetimeconv($time).'</div></div></div></div>';
                echo $msg;
              }else{
                  echo '<button type="button" class="btn btn-outline-success btn-sm" name="carrea_button" onclick="readqr(\'carrea\', \'authorizeqrtwo\')" data-bs-toggle="modal" data-bs-target="#modalqr">Enfermeria <i class="fa fa-solid fa-qrcode"></i></button>';
              }
              ?>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
  <!--MODAL PARA SCANNEAR INICIO-->
  <?php require('../leftscannerqr.php'); ?>
  <!--MODAL PARA SCANNEAR FIN-->
  <div class="row mt-3">
    <div class="col-12">
      <label for=""><u><b>V. Prescripcion Farmacologica</b></u></label>
    </div>
  </div>
  <div class="row mt-2">
    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
      <label for="prescriptions"><u>RP/</u></label>
      <!--<input type="text" name="diagnostico" class="form-control" id="diagnostico" value="<?php //if(isset($pat["diagnostico"])) echo $pat["diagnostico"];  ?>">-->
      <textarea class="form-control" id="prescriptions" name="prescriptions" rows="3"><?php if(isset($pat["surgeryiiprescriptions"])) echo $pat["surgeryiiprescriptions"];  ?></textarea>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
      <label for="indications"><u>INDICACIONES</u></label>
      <!--<input type="text" name="diagnostico" class="form-control" id="diagnostico" value="<?php //if(isset($pat["diagnostico"])) echo $pat["diagnostico"];  ?>">-->
      <textarea class="form-control" id="indications" name="indications" rows="3"><?php if(isset($pat["surgeryiiindications"])) echo $pat["surgeryiiindications"];  ?></textarea>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
      <label for="evolution"><u><b>VI. Tratamiento post operatorio y evolución</b></u></label>
      <!--<input type="text" name="diagnostico" class="form-control" id="diagnostico" value="<?php //if(isset($pat["diagnostico"])) echo $pat["diagnostico"];  ?>">-->
      <textarea class="form-control" id="evolution" name="evolution" rows="3"><?php if(isset($pat["surgeryiievolution"])) echo $pat["surgeryiievolution"];  ?></textarea>
    </div>
    <input type="hidden" name="remissionid" id="remissionid"value="<?php if(isset($_GET['id'])) echo $_GET['id'];?>">
    <input type="hidden" name="ficha" id="ficha"value="<?php if(isset($pat["surgeryiiid"])) echo $pat["surgeryiiid"]?>">

  </div>
  <div class="row mt-3">
    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
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

    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
      <?php

      $name="Docente:&nbsp;&nbsp;&nbsp;&nbsp;";
      $size=0;
      if(isset($pat['areviewteacher']))
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
  <br>

</div>
<br>



                    </div>

<?php
require('footer.php');
?>



<?php
include("../leftodontogramjs.php");
?>
<script src="../leftscannerqr.js"></script>
<script>
function registerqr(content){
  var ch = $('#functionname').val();
  switch (ch) {
    case 'authorizeqrtwo':
      authorizeqrtwo(content);
      break;
    case 'authorizeqr':
      registerpatient(0);
      authorizeqr(content);
      break;
    case 'endqr':
      registerpatient(0);
      endqr(content);
      break;
  }
}
function endqr(content){
  var ch = $('#inputqr').val();
  //var ficha = $('#ficha').val();
  //window.location.href=content;
  //alert(content);
  $.ajax({
       url:"../include/i_clinichistory.php",
       method:"POST",
       data: {content:content, ch:ch, endch:'true'},
       success:function(data)
       {
          if(data=='yes'){
            alert('Se finalizó la ficha');
            location.reload();
          }else{
            alert(data);
          }
       }
  });
}
function authorizeqrtwo(content, remission){
  var remission = $('#remissionid').val();
  var ficha = $('#ficha').val();

  if(ficha==''){
    registerpatient(0);
  }

  var anesthesia = $('#inputqr').val();
  //var ficha = $('#ficha').val();
  //window.location.href=content;
  $.ajax({
       url:"../include/i_readqr.php",
       method:"POST",
       data: {content:content, anesthesia:anesthesia, remission:remission},
       success:function(data)
       {
          if(isNaN(data)){
            let arr = data.split('***');
            var type=arr[0];
            $('#a_'+anesthesia+''+type).html(arr[1]);
          }else{
              if(data==3){
                alert('Tipo de usuario invalido');
              }else if (data==3) {
                alert('No se realizo la autorización');
              }else if (data==1) {
                alert('Tecnica de anestesia no encontrado');
              }else if (data==0) {
                alert('QR Invalido');
              }else {
                alert('Error: '+data);
              }

          }

       }
  });
}
function authorizeqr(content){
  var ch = $('#inputqr').val();
  //var ficha = $('#ficha').val();
  //window.location.href=content;
  //alert(content);
  //alert(ch);
  $.ajax({
       url:"../include/i_clinichistory.php",
       method:"POST",
       data: {content:content, ch:ch},
       success:function(data)
       {
          //alert(data);
          if(data=='yes'){
            alert('Se autorizó la ficha');
            location.reload();
          }else{
            alert(data);
          }
       }
  });
}

function file(id){
  var st=`<?php echo $pat['status']; ?>`;
  if(st!='end'){
    registerpatient(0);
  }

  location.href="surgeryiiread.php?id="+id;
}
//scanner scan qr fin
function registerpatient(p=1){

  var patientid = $('#patientid').val();

  //exam buco dental
  //var dental = $('#dental').val();
  var faces = $('select[name=faces]').val();
  var profile = $('select[name=profile]').val();
  var scars = $('#scars').val();//$('select[name=scars]').val();
  var atm = $('select[name=atm]').val();
  var ganglia = $('select[name=ganglia]').val();
  var lips = $('select[name=lips]').val();
  var ulcerations = $('select[name=ulcerations]').val();
  var cheilitis = $('select[name=cheilitis]').val();
  var commissures = $('select[name=commissures]').val();

  var tongue = $('select[name=tongue]').val();// $('select[name=tongue]').val();// $('input:radio[name=tongue]:checked').val();
  var piso = $('select[name=piso]').val();// $('input:radio[name=piso]:checked').val();
  var encias = $('select[name=encias]').val();// $('input:radio[name=encias]:checked').val();
  var mucosa = $('select[name=mucosa]').val();// $('input:radio[name=mucosa]:checked').val();
  var occlusion = $('select[name=occlusion]').val();// $('input:radio[name=occlusion]:checked').val();
  var prosthesis = $('select[name=prosthesis]').val();// $('input:radio[name=prosthesis]:checked').val();
  var hygiene = $('select[name=hygiene]').val();// $('input:radio[name=hygiene]:checked').val();

  //var lastconsultation = $('#lastconsultation').val();
  //var consultation = $('#consultation').val();
  var generalstatus = $('#generalstatus').val();
  //alert(tongue);

  //datos del odontograma
  var odontogram = $('#odontogram').val();
  var tr = $('#tr').html();
  var tl = $('#tl').html();
  var tlr = $('#tlr').html();
  var tll = $('#tll').html();
  var bl = $('#bl').html();
  var br = $('#br').html();
  var bll = $('#bll').html();
  var blr = $('#blr').html();

  var odontodiagnostico = $('#areadiagnostico').val();
  var odontodraw = $('#draw').val();

  //variable para el modo de registro
  var mod = 'surgeryii';
  //variables de ficha cirugia bucal ii
  //enfermedad
  var disease = $('#disease').val();
  //examen
  var exam = $('select[name=exam]').val();
  var pieza = $('#pieza').val();
  //diagnostico
  var diagnostico = $('#diagnostico').val();
  //tratameinto y anestesias
  //var sintomatico = $('#sintomatico').val();
  //var etiologica = $('#etiologica').val();
  //var quirurgico = $('#quirurgico').val();
  //var farmacologico = $('#farmacologico').val();
  var treatment = $('#quirurgico').prop("checked")+'-'+$('#farmacologico').prop("checked");//$('select[name=treatment]').val();
  var anestesia = $('#spix').prop("checked")+'-'+$('#mentoniana').prop("checked")+'-'+$('#local').prop("checked")+'-'+
  $('#infraorbitaria').prop("checked")+'-'+$('#tuberositaria').prop("checked")+'-'+
  $('#carrea').prop("checked");//$('select[name=anestesia]').val();
  //alert(anestesia);
  //prescripciones
  var prescriptions = $('#prescriptions').val();
  //indicaciones
  var indications = $('#indications').val();
  //indicaciones
  var evolution = $('#evolution').val();
  var remission = $('#remissionid').val();
  var ficha = $('#ficha').val();
  $.ajax({

         url:"../include/i_patientadmission.php",
         method:"POST",
         data: {patientid:patientid, remission:remission, ficha:ficha, mod:mod, faces:faces, profile:profile, scars:scars, atm:atm, ganglia:ganglia,
           lips:lips, ulcerations:ulcerations, cheilitis:cheilitis, commissures:commissures,
           tongue:tongue, piso:piso, encias:encias, mucosa:mucosa, occlusion:occlusion,
           prosthesis:prosthesis, hygiene:hygiene, generalstatus:generalstatus,
           odontogram:odontogram, tr:tr, tl:tl, tlr:tlr, tll:tll, bl:bl, br:br, bll:bll, blr:blr,
           odontodiagnostico:odontodiagnostico, odontodraw:odontodraw,
           disease:disease, exam:exam, pieza:pieza,
           diagnostico:diagnostico, treatment:treatment, anestesia:anestesia,
           prescriptions:prescriptions, indications:indications, evolution:evolution},

         success:function(data)
         {
           if(data=='yes'){
             if(p!=0)
              //alert('Se guardó los datos de la ficha clinica');
              Swal.fire({
                icon: 'success',
                title: '¡Guardado!',
                html: 'Se guardó los datos de la ficha clinica',
                showConfirmButton: false,
                timer: 1500
              });
             //location.href="clinicalhistory.php";
           }else{
             alert(data);
             console.log(data);
           }
         }
      });

}
$(document).ready(function(){
      Stop();
      $(".detail_modal").click(function(event) {
        Stop();
        var ch=$(this).attr('ch');
        $.ajax({
             url:"../include/i_clinichistorydetail.php",
             method:"POST",
             data: {ch:ch},
             success:function(data)
             {
                $('#modaldetail').html(data);
             }
        });
      });
      //cancel cancel_button
     $('#cancel_button').click(function(){
        location.reload();
     });
     //registrar todos de datos del paciente





     var info='';
     //funcion para registrar datos del paciente



    //register patient
    $('#patientregister_button').click(function(){
      registerpatient();
      //if (confirm("Enviar los datos de ficha clinica?")) {
      //  registerpatient();
      //}else{
      //    location.reload();
      //}
    });

    $('#fulldatapatient').on('show.bs.collapse',function(){
      $('#divfull').html('<div class="col-12  pt-2 bg-primary"></div>');
    });
    $('#fulldatapatient').on('hide.bs.collapse',function(){
      $('#divfull').html('<div class="col-4  pt-2 bg-primary"></div>');
    });
});

</script>
