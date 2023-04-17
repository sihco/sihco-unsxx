<?php
session_start();//para iniciar session_sta
require_once("../globals.php");
require_once("../db.php");

if (isset($_POST["designed"]) && isset($_POST["student"])) {
    $student = htmlspecialchars(trim($_POST["student"]));
    $designed = htmlspecialchars(trim($_POST["designed"]));
    $a=DBUserDesignedInfoFullname($student, $designed);
    if($a==null){
      echo "estudiante no encontrado ".$student. " ". $designed;
    }else {
      echo "yes";
    }
    exit;
}

if(isset($_POST["mod"]) && isset($_POST["padmissionid"]) && isset($_POST["patientname"]) &&
    isset($_POST["patientfirstname"]) && isset($_POST["patientlastname"]) &&
    isset($_POST["patientdirection"]) && isset($_POST["patientlocation"]) && isset($_POST["patientage"]) &&
    isset($_POST["patientprovenance"]) && isset($_POST["patientphone"]) && is_numeric($_POST["patientphone"]) &&
    isset($_POST["patientgender"]) && isset($_POST["patientcivilstatus"]) &&
    isset($_POST["patientoccupation"]) && isset($_POST["patientnationality"]) &&
    isset($_POST["patientschool"]) && isset($_POST["patientattorney"]) && isset($_POST["yesno0"]) && isset($_POST["obs0"]) && isset($_POST["obs13"]) &&
    isset($_POST["temperature"]) && isset($_POST["headache"]) && isset($_POST["respiratory"]) && isset($_POST["throat"]) && isset($_POST["general"]) && isset($_POST["vaccine"]) &&
    isset($_POST["tongue"]) && isset($_POST["piso"]) &&
    isset($_POST["encias"]) && isset($_POST["mucosa"]) && isset($_POST["occlusion"]) && isset($_POST["prosthesis"]) &&
    isset($_POST["hygiene"]) && isset($_POST["lastconsultation"]) && isset($_POST["consultation"]) &&
    isset($_POST["tr"]) && isset($_POST["tl"]) &&
    isset($_POST["tlr"]) && isset($_POST["tll"]) && isset($_POST["bl"]) && isset($_POST["br"]) &&
    isset($_POST["bll"]) && isset($_POST["blr"]) && isset($_POST["diagnostico"])) {// && isset($_POST["clinical"]) && isset($_POST["examined"]) && isset($_POST["examinedid"])

      $param=array();
      $param["mod"]=htmlspecialchars(trim($_POST["mod"]));
    	$param['idpa'] = htmlspecialchars(trim($_POST["padmissionid"]));

      //$param['patientname'] = htmlspecialchars(trim($_POST["patientfullname"]));
      $param['patientname'] = htmlspecialchars(trim($_POST["patientname"]));
    	$param['patientfirstname'] = htmlspecialchars(trim($_POST["patientfirstname"]));
    	$param['patientlastname'] = htmlspecialchars(trim($_POST["patientlastname"]));
    	$param['patientdirection'] = htmlspecialchars(trim($_POST["patientdirection"]));
    	$param['patientlocation'] = htmlspecialchars(trim($_POST["patientlocation"]));
    	$param['patientage'] = htmlspecialchars(trim($_POST["patientage"]));
    	$param['patientprovenance'] = htmlspecialchars(trim($_POST["patientprovenance"]));
    	$param['patientphone'] = htmlspecialchars(trim($_POST["patientphone"]));
    	$param['patientgender'] = htmlspecialchars(trim($_POST["patientgender"]));
    	$param['patientcivilstatus'] = htmlspecialchars(trim($_POST["patientcivilstatus"]));
    	$param['patientoccupation'] = htmlspecialchars(trim($_POST["patientoccupation"]));
    	$param['patientnationality'] = htmlspecialchars(trim($_POST["patientnationality"]));
    	$param['patientschool'] = htmlspecialchars(trim($_POST["patientschool"]));
    	$param['patientattorney']=htmlspecialchars(trim($_POST["patientattorney"]));
      //registra un nuevo paciente
      //triage de paciente
      $param['temperature']=$_POST["temperature"];
      $param['headache']=$_POST["headache"];
      $param['respiratory']=$_POST["respiratory"];
      $param['throat']=$_POST["throat"];
      $param['general']=$_POST["general"];
      $param['vaccine']=$_POST["vaccine"];

      //examen buco dental
      $param['tongue'] = htmlspecialchars($_POST["tongue"]);
      $param['piso'] = htmlspecialchars($_POST["piso"]);
      $param['encias'] = htmlspecialchars($_POST["encias"]);
      $param['mucosa'] = htmlspecialchars($_POST["mucosa"]);
      $param['occlusion'] = htmlspecialchars($_POST["occlusion"]);
      $param['prosthesis'] = htmlspecialchars($_POST["prosthesis"]);
      $param['hygiene'] = htmlspecialchars($_POST["hygiene"]);
      $param['lastconsultation'] = htmlspecialchars($_POST["lastconsultation"]);
      $param['consultation'] = htmlspecialchars($_POST["consultation"]);

      //odontogram
      $conf=globalconf();
      $param['tr'] = encryptData($_POST["tr"], $conf["key"], false);
      $param['tl'] = encryptData($_POST["tl"], $conf["key"], false);
      $param['tlr'] = encryptData($_POST["tlr"], $conf["key"], false);
      $param['tll'] = encryptData($_POST["tll"], $conf["key"], false);
      $param['bl'] = encryptData($_POST["bl"], $conf["key"], false);
      $param['br'] = encryptData($_POST["br"], $conf["key"], false);
      $param['bll'] = encryptData($_POST["bll"], $conf["key"], false);
      $param['blr'] = encryptData($_POST["blr"], $conf["key"], false);
      //remission
      $param['diagnosis'] = htmlspecialchars($_POST["diagnostico"]);

      //$admission=$_SESSION["usertable"]["usernumber"];
      if(!isset($_SESSION["usertable"]["usernumber"])){
        echo "Recarge la pagina nuevamente";
        exit;
      }
      if(($userspinfo=DBSpecialtyInfo($_SESSION['usertable']['usernumber'],1,3))==null){
        echo "No Tiene Privilegios Para Realizar Admisiones";
        exit;
      }
      $param['reid']=$userspinfo['userid'];
      $param['reclinicalid']=$userspinfo['clinicalid'];
      $param['recourseid']=$userspinfo['coursenumber'];

      if($userspinfo['userid']==0){
        $param['stid']=$userspinfo['userid'];
        $param['stclinicalid']=$userspinfo['clinicalid'];
        $param['stcourseid']=$userspinfo['coursenumber'];
      }else{
        if((isset($_SESSION['usertable2']['usernumber'])&&
          ($userspinfo=DBSpecialtyInfo($_SESSION['usertable2']['usernumber'],1,3))!=null)){
          $param['stid']=$userspinfo['userid'];
          $param['stclinicalid']=$userspinfo['clinicalid'];
          $param['stcourseid']=$userspinfo['coursenumber'];
        }else{
          echo "No Tiene Privilegios Para Realizar Admisiones";
          exit;
        }
      }

      if(isset($_POST['clinical'])&&is_numeric($_POST['clinical']))
        $param['clinical'] = htmlspecialchars($_POST["clinical"]);
      if(isset($_POST['examined'])&&trim($_POST['examined'])!="")
        $param['examined'] = htmlspecialchars($_POST["examined"]);
      if(isset($_POST['examinedid'])&&is_numeric($_POST['examinedid']))
        $param['examinedid'] = htmlspecialchars($_POST["examinedid"]);
      //$param['admission']=$_SESSION["usertable"]["usernumber"];
      if(!isset($param['examinedid'])&&
      isset($param['clinical'])&& isset($param['examined'])){
        $a=DBUserDesignedInfoFullname($param['examined'],$param["clinical"]);
        if($a==null){
          echo "Estudiante no encontrado";
          exit;
        }
        $param["examined"]=$a["user"];
      }else{
        if(isset($param['examinedid'])&& isset($param['clinical'])){
            $a=DBUserDesignedInfo($param['examinedid'], $param['clinical']);
            if($a==null){
              echo "Estudiante no encontrado";
              exit;
            }
            $param["examined"]=$a["user"];
        }
      }
      //updatetime
      if (isset($_POST['meeting_time'])&&($timestamp = strtotime($_POST['meeting_time'])) !== false) {
          $param['updatetime']=$timestamp;
      }

      $a=array();
      for ($i=0; $i <= 13; $i++) {
        $a[$i]['disease']=$i;
        $a[$i]['status']=$_POST["yesno".$i];
        $a[$i]['obs']=$_POST["obs".$i];
      }
      $param["patientgmh"]=patientgmh($a);
      $param["patientpa"]='['.$_POST['sistolica'].']['.$_POST['diastolica'].']';
      $param["odontogramdesc"]='';
      if(isset($_POST["odontodiagnostico"]))
        $param["odontogramdesc"] = $_POST["odontodiagnostico"];//odontogram desc
      $param["odontodraw"]='';
      if(isset($_POST["odontodraw"]) && $_POST["odontodraw"]!="")
        $param["odontodraw"] = encryptData($_POST["odontodraw"], $conf["key"], false);
      DBNewRemissionPatient($param);
      echo "yes";
      exit;

}

if(isset($_POST["mod"]) && $_POST["mod"]='surgeryii' &&
    isset($_POST["faces"]) &&   isset($_POST["ficha"]) && isset($_POST["profile"]) && isset($_POST["scars"]) &&
    isset($_POST["atm"]) && isset($_POST["ganglia"]) && isset($_POST["lips"]) &&
    isset($_POST["ulcerations"]) && isset($_POST["cheilitis"]) && isset($_POST["commissures"]) &&
    isset($_POST["tongue"]) && isset($_POST["piso"]) &&
    isset($_POST["encias"]) && isset($_POST["mucosa"]) && isset($_POST["occlusion"]) && isset($_POST["prosthesis"]) &&
    isset($_POST["hygiene"]) && isset($_POST["lastconsultation"]) && isset($_POST["consultation"]) && isset($_POST["generalstatus"]) &&
    isset($_POST["tr"]) && isset($_POST["tl"]) &&
    isset($_POST["tlr"]) && isset($_POST["tll"]) && isset($_POST["bl"]) && isset($_POST["br"]) &&
    isset($_POST["bll"]) && isset($_POST["blr"]) && isset($_POST["diagnostico"]) && isset($_POST["remission"])&& is_numeric($_POST["remission"])) {

      $param=array();
      $param["mod"]='update';
      $param["patientid"]=htmlspecialchars(trim($_POST["patientid"]));

      //examen buco dental
      $param['dentalid'] = htmlspecialchars($_POST["dental"]);
      $param['faces'] = htmlspecialchars($_POST["faces"]);
      $param['profile'] = htmlspecialchars($_POST["profile"]);
      $param['scars'] = htmlspecialchars($_POST["scars"]);
      $param['atm'] = htmlspecialchars($_POST["atm"]);
      $param['ganglia'] = htmlspecialchars($_POST["ganglia"]);
      $param['lips'] = htmlspecialchars($_POST["lips"]);
      $param['ulcerations'] = htmlspecialchars($_POST["ulcerations"]);
      $param['cheilitis'] = htmlspecialchars($_POST["cheilitis"]);
      $param['commissures'] = htmlspecialchars($_POST["commissures"]);

      $param['tongue'] = htmlspecialchars($_POST["tongue"]);
      $param['piso'] = htmlspecialchars($_POST["piso"]);
      $param['encias'] = htmlspecialchars($_POST["encias"]);
      $param['mucosa'] = htmlspecialchars($_POST["mucosa"]);
      $param['occlusion'] = htmlspecialchars($_POST["occlusion"]);
      $param['prosthesis'] = htmlspecialchars($_POST["prosthesis"]);
      $param['hygiene'] = htmlspecialchars($_POST["hygiene"]);
      $param['lastconsultation'] = htmlspecialchars($_POST["lastconsultation"]);
      $param['consultation'] = htmlspecialchars($_POST["consultation"]);
      $param['generalstatus'] = htmlspecialchars($_POST["generalstatus"]);

      //odontogram
      $conf=globalconf();
      $param['odontogramid'] = htmlspecialchars($_POST["odontogram"]);
      $param['tr'] = encryptData($_POST["tr"], $conf["key"], false);
      $param['tl'] = encryptData($_POST["tl"], $conf["key"], false);
      $param['tlr'] = encryptData($_POST["tlr"], $conf["key"], false);
      $param['tll'] = encryptData($_POST["tll"], $conf["key"], false);
      $param['bl'] = encryptData($_POST["bl"], $conf["key"], false);
      $param['br'] = encryptData($_POST["br"], $conf["key"], false);
      $param['bll'] = encryptData($_POST["bll"], $conf["key"], false);
      $param['blr'] = encryptData($_POST["blr"], $conf["key"], false);
      //remission

      $param["odontogramdesc"]='';

      if(isset($_POST["odontodiagnostico"]))
        $param["odontogramdesc"] = $_POST["odontodiagnostico"];//odontogram desc
      $param["odontodraw"]='';
      $param["odontodraw"] = encryptData($_POST["odontodraw"], $conf["key"], false);

      //DBNewRemissionPatient($param);

      //cirugia bucal II
      $param['disease'] = htmlspecialchars($_POST["disease"]);

      $param['exam'] = htmlspecialchars($_POST["exam"]);
      $param['pieza'] = htmlspecialchars($_POST["pieza"]);
      $param['exam'] = '['.myhtmlspecialchars($param['exam'], true).']'.'['.myhtmlspecialchars($param['pieza'], true).']';
      $param['diagnosis'] = htmlspecialchars($_POST["diagnostico"]);

      //if(isset($_POST["odontodraw"]) && $_POST["odontodraw"]!="")
      //$param['sintomatico'] = htmlspecialchars($_POST["sintomatico"]);
      //$param['etiologica'] = htmlspecialchars($_POST["etiologica"]);
      //$param['quirurgico'] = htmlspecialchars($_POST["quirurgico"]);
      //$param['farmacologico'] = htmlspecialchars($_POST["farmacologico"]);

      $param['anestesia'] = htmlspecialchars($_POST["anestesia"]);
      $param['treatment'] = '['.htmlspecialchars($_POST["treatment"], true).']['.htmlspecialchars($param['anestesia'],true).']';//'['.$param['sintomatico'].']'.'['.$param['etiologica'].']'.'['.$param['quirurgico'].']'.'['.$param['farmacologico'].']'.'['.$param['anestesia'].']';
      $param['prescriptions'] = htmlspecialchars($_POST["prescriptions"]);
      $param['indications'] = htmlspecialchars($_POST["indications"]);
      $param['evolution'] = htmlspecialchars($_POST["evolution"]);
      $param['remissionid'] = htmlspecialchars($_POST["remission"]);
      $param['status'] = 'process';
      $infoch=DBClinicHistoryInfo($param['remissionid']);

      $param['idpa'] = $infoch['patientadmissionid'];

      $r=DBUpdateRemissionPatientSurgeryii($param);
      if($r==0){ echo "No se actualizó los datos";exit;}
      DBUpdateReviewStatus($param['remissionid'], false);
      $ret=DBNewSurgeryii($param);
      if($ret==2){
        echo "yes";
      }else{
        echo "No se gurdaron los datos, el tiempo actual debe ser mayor al tiempo de registro";
      }
      exit;
}
?>
