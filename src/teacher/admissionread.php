<?php
require('header.php');
if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
  if(($pat=DBPatientRemissionInfo($id))==null){
    ForceLoad("admission.php");
  }
}

if(!isset($_SESSION['usertable']['usertype'])||
($_SESSION['usertable']['usertype']!='admin'&&$_SESSION['usertable']['usertype']!='admission'&&$_SESSION['usertable']['usertype']!='teacher'&&$_SESSION['usertable']['usertype']!='student'&&$_SESSION['usertable']['usertype']!='chiefclinics')){
  ForceLoad("admission.php");
}
?>
<style media="screen">
.ajuste {
 height: 100%;
 width: 100%;
 object-fit: contain;
}

/*Por debajo de 700px*/
@media screen and (max-width: 700px){
  .dinamictext{
    font-size: 12px;
  }
  .dinamictext-odontogram{
    font-size: 12px;
  }
}
/*Por debajo de 400px*/
@media screen and (max-width: 400px){
  .dinamictext{
    font-size: 10px;
  }
  .dinamictext-odontogram{
    font-size: 8px;
  }
}

</style>
<div class="container-fluid px-3">
    <div class="row">
      <div class="col-2">
        <?php
        $dir='../images/';
        $cdir = $dir."odontologia.jpg";

        $c = "data:image/jpg;base64," . base64_encode(file_get_contents($cdir));
        ?>
        <img class="ajuste" src="<?php echo $c; ?>" alt="">
      </div>
      <div class="col-10" align="center">
        <h2>CLINICA DE ADMISION</h2>
      </div>
    </div>
    <div class="dinamictext row">
      <div class="col-lg-8 col-md-8 col-sm-6 col-5"></div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-7">

        <div class="">
          Folio N. <?php
          if(isset($pat) && $pat["patientadmissionid"]!="")
            echo $pat["patientadmissionid"];
          ?>
          <br>
          Fecha/Hora:
          <?php
          if(isset($pat) && $pat["updatetime"]!="")
            echo $DateAndTime = date('d-m-Y h:i:s a', $pat["updatetime"]);
          else
            echo "..................................";
          ?>
        </div>
      </div>
    </div>
    <div class="dinamictext row">
      <div class="col-12">
        <span>DATOS PERSONALES O FILIACION:</span>
      </div>
    </div>
    <br>
    <div class="dinamictext row">
      <div class="col-12">
        <?php
        $name="Nombres y Apellidos:";
        $size=0;
        if(isset($pat) && $pat["patientname"]){

            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientname"].
            "&nbsp;".$pat["patientfirstname"]."&nbsp;".$pat["patientlastname"];

            echo $name;
        }else{
          echo $name."..............................................................................................................................................";
        }
        ?>
      </div>
    </div>
    <div class="dinamictext row">
      <div class="col-6">
        <?php
        $name="Direccion:";
        $size=0;
        if(isset($pat) && $pat["patientdirection"]){

            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientdirection"];
            $size=$size+strlen($pat["patientdirection"]);
            echo $name;
        }else{
          echo $name."........................................................................";
        }
        ?>
      </div>
      <div class="col-6">
        <?php
        $name="Localidad:";
        if(isset($pat) && $pat["patientlocation"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientlocation"];
          echo $name;
        }else{
          echo $name.".....................................................................";
        }
        ?>
      </div>
    </div>
    <div class="dinamictext row">
      <div class="col-2">
        <?php
        $name="Edad:";
        if(isset($pat) && $pat["patientage"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientage"];
          echo $name;
        }else{
          echo $name.".................";
        }
        ?>
      </div>
      <div class="col-6">
        <?php
        $name="Procedencia:";
        if(isset($pat) && $pat["patientprovenance"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientprovenance"];
          echo $name;
        }else{
          echo $name."...................................................";
        }
        ?>
      </div>
      <div class="col-4">
        <?php
        $name="Telf:";
        if(isset($pat) && $pat["patientphone"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientphone"];
          echo $name;
        }else{
          echo $name."..................";
        }
        ?>
      </div>
    </div>
    <div class="dinamictext row">
      <div class="col-4">
        <?php
        $name="Genero:";
        if(isset($pat) && $pat["patientgender"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["patientgender"]);
          echo $name;
        }else{
          echo $name."........................................";
        }
        ?>
      </div>
      <div class="col-4">
        <?php
        $name="Estado Civil:";
        if(isset($pat) && $pat["patientcivilstatus"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["patientcivilstatus"]);
          echo $name;
        }else{
          echo $name."................................";
        }
        ?>
      </div>
      <div class="col-4">
        <?php
        $name="Ocupación:";
        if(isset($pat) && $pat["patientoccupation"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientoccupation"];
          echo $name;
        }else{
          echo $name."..................................................";
        }
        ?>
      </div>
    </div>
    <br>
    <div class="dinamictext row">
      <div class="col-12">
        ANTECEDENTES MEDICOS GENERALES
      </div>
    </div>
    <div class="dinamictext row">
      <div class="col-12">
        <table class="table table-sm table-bordered">
          <tr>
            <td>ENFERMEDAD</td>
            <td>SI</td>
            <td>NO</td>
            <td>OBSERVACIONES</td>
          </tr>
        <?php
        $a = array('Cardiopatías', 'Fiebre Reumática', 'Artritis', 'Tuberculosis', 'Silicosis',
            'Epilepsia', 'Hepatitis', 'Diabetes', 'Hipertension Arterial', 'Alergias', 'Asma', 'Embarazo',
            'Habitos / vicios', 'Otros');//Recibe tratamiento Medico
        $st=false;
        if(isset($pat["patientgmh"])){
            $p=cleanpatientgmh($pat["patientgmh"]);
            $st=true;
        }
        for ($i=0; $i < count($a); $i++) {
          echo "<tr>";
          echo "<td>".$a[$i]."</td>";

          if ($st) {
            if ($p[$i]["status"]=="true") {
              echo "<td></td><td><i class=\"fa fa-solid fa-check\"></i></td>";
            }else {
              echo "<td><i class=\"fa fa-solid fa-check\"></i></td><td></td> ";
            }
            echo "<td>".$p[$i]["obs"]."</td>";
          }else{
            echo "<td></td><td></td><td></td>";
          }
          echo "</tr>";
        }
        ?>
        </table>
      </div>
    </div>
    <br>
    <div class="dinamictext row">
      <div class="col-12">
        TRIAGE
      </div>
    </div>
    <div class="dinamictext row">
      <div class="col-4">
        <?php
        $name="Temperatura:";
        if(isset($pat) && $pat["triagetemperature"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["triagetemperature"];
          echo $name;
        }else{
          echo $name."...................................";
        }
        ?>
      </div>
      <div class="col-4">
        <?php
        $name="Cefalea:";
        if(isset($pat)){
          if($pat["triageheadache"]=='t')
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
          else
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No";
          echo $name;
        }else{
          echo $name."...........................................";
        }
        ?>
      </div>
      <div class="col-4">
        <?php
        $name="Dificultad Respiratoria:";
        if(isset($pat)){
          if($pat["triagerespiratory"]=='t')
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
          else
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No";
          echo $name;
        }else{
          echo $name."...................";
        }
        ?>
      </div>
      <div class="col-4">
        <?php
        $name="Dolor de Garganta:";
        if(isset($pat)){
          if($pat["triagethroat"]=='t')
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
          else
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No";
          echo $name;
        }else{
          echo $name."..........................";
        }
        ?>
      </div>
      <div class="col-4">
        <?php
        $name="Malestar General:";
        if(isset($pat["triagegeneral"])){
          if($pat["triagegeneral"]=='t')
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
          else
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No";
          echo $name;
        }else{
          echo $name."............................";
        }
        ?>
      </div>
      <div class="col-4">
        <?php
        $name="Vacuna:";
        if(isset($pat)){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          if($pat["triagevaccine"]=='1')
            $name.="1 Dosis";
          if($pat["triagevaccine"]=='2')
            $name.="2 Dosis";
          if($pat["triagevaccine"]=='3')
            $name.="3 Dosis";
          if($pat["triagevaccine"]=='n')
            $name.="Ninguno";
          echo $name;
        }else{
          echo $name."............................................";
        }
        ?>
      </div>
    </div>
    <br>
    <div class="dinamictext row">
      <div class="col-12">
        EXAMEN BUCODENTAL
      </div>
    </div>
    <br>
    <div class="dinamictext row">
      <div class="col-6">
        <?php
        $name="Lengua:";
        if(isset($pat)){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          if($pat["dentaltongue"]=='normal')
            $name.="Normal";
          if($pat["dentaltongue"]=='saburra')
            $name.="Saburral";
          if($pat["dentaltongue"]=='fisurada')
            $name.="Fisurada";
          if($pat["dentaltongue"]=='geografica')
            $name.="Geografica";
          if($pat["dentaltongue"]=='otros')
            $name.="Otros";
          echo $name;
        }else{
          echo $name.".......................................................................";
        }
        ?>
      </div>
      <div class="col-6">
        <?php
        $name="Tipo de Oclusión:";
        if(isset($pat)){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          if($pat["dentaltypeo"]=='normo')
            $name.="Normo oclusión";
          if($pat["dentaltypeo"]=='disto')
            $name.="Disto oclusión";
          if($pat["dentaltypeo"]=='mesio')
            $name.="Mesio oclusión";
          //if($pat["dentaltypeo"]=='abierta')
          //  $name.="Abierta anterior";
          if($pat["dentaltypeo"]=='normal')
            $name.="Mordida Normal";
          if($pat["dentaltypeo"]=='malposicion')
            $name.="Mal posición dental";
          if($pat["dentaltypeo"]=='sobre')
            $name.="SobreMordida";
          if($pat["dentaltypeo"]=='abierta')
            $name.="Mordida Abierta";
          if($pat["dentaltypeo"]=='cruzada')
            $name.="Mordida Cruzada";
          if($pat["dentaltypeo"]=='bis')
            $name.="Mordida Bis a Bis";
          if($pat["dentaltypeo"]=='--')
            $name.="--";

          echo $name;
        }else{
          echo $name.".........................................................";
        }
        ?>
      </div>
      <div class="col-6">
        <?php
        $name="Piso de la boca:";
        if(isset($pat)){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          if($pat["dentalpiso"]=='aparentemente')
            $name.="Aparentemente Normal";
          if($pat["dentalpiso"]=='toruslingua')
            $name.="Torus lingual";

          echo $name;
        }else{
          echo $name."...........................................................";
        }
        ?>
      </div>
      <div class="col-6">
        <?php
        $name="Tipo de Protesis:";
        if(isset($pat)){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          if($pat["dentaltypep"]=='removible')
            $name.="Removible";
          if($pat["dentaltypep"]=='fija')
            $name.="Fija";
          if($pat["dentaltypep"]=='total')
            $name.="Total";

          echo $name;
        }else{
          echo $name."...........................................................";
        }
        ?>
      </div>
      <div class="col-6">
        <?php
        $name="Encias:";
        if(isset($pat)){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          if($pat["dentalencias"]=='normal')
            $name.="Normal";
          if($pat["dentalencias"]=='gingivitis')
            $name.="Gingivitis cronica no complicada";
          if($pat["dentalencias"]=='difusa')
            $name.="Difusa";
          if($pat["dentalencias"]=='papilar')
            $name.="Papilar";

          echo $name;
        }else{
          echo $name."........................................................................";
        }
        ?>
      </div>

      <div class="col-6">
        <?php
        $name="Higiene Bucal:";
        if(isset($pat)){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          if($pat["dentalhygiene"]=='buena')
            $name.="Buena";
          if($pat["dentalhygiene"]=='regular')
            $name.="Regular";
          if($pat["dentalhygiene"]=='mala')
            $name.="Mala";

          echo $name;
        }else{
          echo $name."..............................................................";
        }
        ?>
      </div>
      <div class="col-6">
        <?php
        $name="Mucosa Bucal:";
        if(isset($pat)){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          if($pat["dentalmucosa"]=='normal')
            $name.="Aparentemente normal";
          if($pat["dentalmucosa"]=='alteracion')
            $name.="Con alteración";


          echo $name;
        }else{
          echo $name."............................................................";
        }
        ?>
      </div>
    </div>
    <hr>
    <div class="dinamictext row">
      <div class="col-12">
        <?php
        $name="Ultima Consulta:";
        if(isset($pat) && $pat["lastconsult"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["lastconsult"];

          echo $name;
        }else{
          echo $name.".......................................................................................";
        }
        ?>
      </div>
      <div class="col-12">
        <?php
        $name="Motivo de Consulta:";
        if(isset($pat) && $pat["motconsult"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["motconsult"];

          echo $name;
        }else{
          echo $name."...........................................................................................";
        }
        ?>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-12">

        <!--odontograma inicio-->
        <div class="panel panel-primary">

            <div class="panel-heading">
                <h3 class="panel-title text-muted">Odontograma</h3>
            </div>
            <!--cuerpo del panel-->

                <div class="row">
                  <div id="tr" class="col-12 col-sm-12 col-md-6 col-lg-6">
                  </div>
                  <div id="tl" class="col-12 col-sm-12 col-md-6 col-lg-6">
                  </div>
                  <div id="tlr" class="col-12 col-sm-12 col-md-6 col-lg-6 text-right">
                  </div>
                  <div id="tll" class="col-12 col-sm-12 col-md-6 col-lg-6">
                  </div>
                </div>
                <!--CERRAMOS UN FILA-->
                <div class="row">
                    <div id="blr" class="col-12 col-sm-12 col-md-6 col-lg-6 text-right">
                    </div>
                    <div id="bll" class="col-12 col-sm-12 col-md-6 col-lg-6">
                    </div>
                    <div id="br" class="col-12 col-sm-12 col-md-6 col-lg-6">
                    </div>
                    <div id="bl" class="col-12 col-sm-12 col-md-6 col-lg-6">
                    </div>
                </div>
                <div class="dinamictext container">
                  <!--INICIAMOS OTRA FILA-->
                  <div class="row">
                      <div class="col-3 col-sm-3 col-md-3 col-lg-3">
                        <div style="height: 20px; width:20px; display:inline-block;" class="click-red"></div> = Fractura/Caries
                        <br>
                        <div style="height: 20px; width:20px; display:inline-block;" class="click-blue"></div> = Obturado
                      </div>
                      <div class="col-3 col-sm-3 col-md-3 col-lg-3">
                        Sellados = <i style="color:blue;" class="fa fa-solid fa-bacon fa-2x fa-fw"></i>
                        <br> Extraido o Ausente = <i style="color:blue;" class="fa fa-solid fa-grip-lines fa-2x fa-fw"></i>
                      </div>
                      <div class="col-3 col-sm-3 col-md-3 col-lg-3">
                        <span style="display:inline:block;"> Necrosis pulpar</span> = <img style="display:inline:block;" src="../images/extraccion.png">
                        <br>
                        <span style="display:inline:block;"> Coronas</span> = <img style="display:inline:block;" src="../images/pieza/corona.png">
                      </div>
                      <div class="col-3 col-sm-3 col-md-3 col-lg-3">
                        <br> Exodoncia Indicada = <i style="color:red;" class="fa fa-times fa-2x"></i>
                      </div>
                  </div>
                </div>
                <!--CERRAMOS OTRA FILA-->
        </div>
                <?php
                $odontogramstatus="false";
				        if (isset($pat['draw'])){
				          $odontogramstatus="true";
				          $pat=decryptOdontogram($pat);
				        }
                ?>
        <!--odontograma fin-->
      </div>
    </div>
    <div class="dinamictext-odontogram row">
      <br>
      <div class="col-12"></div>
      <?php

      if(isset($pat)&& $pat["description"]){
        $pat["description"] = str_replace("\n", "*", $pat["description"]);
        $datad=explode('*',$pat["description"]);
        //echo $pat["description"];

        $len=count($datad)-1;
        if($len!=0){
          $len1=$len/3;
          echo "<div class=\"border col-lg-4 col-md-4 col-sm-4 col-4\">";
          for($i=0;$i<$len1;$i++){
            echo "&nbsp;&nbsp;".$datad[$i]."<br>";
          }
          echo "</div>";
          echo "<div class=\"border col-lg-4 col-md-4 col-sm-4 col-4\">";
          for ($i=$i; $i < $len1*2; $i++) {
            echo "&nbsp;&nbsp;".$datad[$i]."<br>";
          }
          echo "</div>";
          echo "<div class=\"border col-lg-4 col-md-4 col-sm-4 col-4\">";
          for ($i=$i; $i < $len; $i++) {
            echo "&nbsp;&nbsp;".$datad[$i]."<br>";
          }
          echo "</div>";
        }else{
          echo $pat["description"];
        }
      }
      ?>
    </div>
    <br>
    <div class="dinamictext row">
      <div class="col-12">
        HISTORIA DE LA PATOLOGIA ACTUAL Y REMISION
      </div>
    </div>
    <br>
    <div class="dinamictext row">
      <div class="col-12">
        <?php
        $name="Diagnostico Presuntivo:";
        if(isset($pat) && $pat["diagnosis"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["diagnosis"];

          echo $name;
        }else{
          echo $name."........................................................................................................................................";
        }
        ?>
      </div>
      <div class="col-12">
        <?php
        $name="Estudiante Designado:";
        if(isset($pat['remission']['studentid']) && is_numeric($pat['remission']['studentid'])){
          $stinfo=DBUserInfo($pat['remission']['studentid']);
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Univ. ".$stinfo['userfullname'];
          echo $name;
        }else{
          echo $name."....................................................................................................................";
        }
        ?>
      </div>
      <div class="col-12">
        <?php
        $name="Responsable Clinica Admision:";

        if(isset($pat["responsibleid"]) && $pat["responsibleid"]){
          $uf=DBUserInfo($pat["responsibleid"]);
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dr.(a) ".$uf["userfullname"];

          echo $name;
        }else{
          echo $name."...........................................................................................................................";
        }
        ?>
      </div>

    </div>
    <br>
    <div class="dinamictext row">
      <div class="col-12">
        Los datos proporcionados por el <u>paciente</u> son confiables y se compromete a cumplir las normas de la
        Carrera de Odontologia.
      </div>
    </div>

</div>






<?php
require('footer.php');

include("../leftodontogramjs.php");
?>
