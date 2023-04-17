<?php
session_start();//para iniciar session_sta
require_once("../globals.php");
require_once("../db.php");

//para
if(isset($_POST['patientid'])&&isset($_POST['ficha'])&&isset($_POST['patientdatebirth'])&&
isset($_POST['patientplacebirth'])&&isset($_POST['patientfathername'])&&
isset($_POST['patientfatheroccupation'])&&isset($_POST['patientmothername'])&&
isset($_POST['patientmotheroccupation'])&&isset($_POST['name'])&&isset($_POST['age'])&&
isset($_POST['patientschools'])&&isset($_POST['patientschool'])&&isset($_POST['refer'])&&
isset($_POST['reason'])&&isset($_POST['temp'])&&isset($_POST['fc'])&&isset($_POST['fr'])&&
isset($_POST['pd'])&&isset($_POST['talla'])&&isset($_POST['peso'])&&isset($_POST['constit'])&&
isset($_POST['pulso'])&&isset($_POST['diast'])&&isset($_POST['motconsult'])&&isset($_POST['attitude'])&&
isset($_POST['chair'])&&isset($_POST['prior'])&&isset($_POST['lastattention'])&&isset($_POST['periodica'])&&
isset($_POST['periodicacuales'])&&isset($_POST['traumaticas'])&&isset($_POST['traumaticascuales'])&&
isset($_POST['attitudeodont'])&&isset($_POST['diseases'])&&isset($_POST['interventions'])&&
isset($_POST['conexplicaciones'])&&isset($_POST['sinconexplicaciones'])&&
isset($_POST['experienciastraumaticas'])&&isset($_POST['experienciastraumaticasotros'])&&
isset($_POST['medicoperiodicamente'])&&isset($_POST['medicoirregularmente'])&&isset($_POST['consistency'])&&
isset($_POST['desayuno'])&&isset($_POST['desayunoalmuerzo'])&&isset($_POST['almuerzo'])&&
isset($_POST['merienda'])&&isset($_POST['cena'])&&isset($_POST['despuescena'])&&isset($_POST['despierta'])&&
isset($_POST['dulcedia'])&&isset($_POST['riesgocaries'])&&isset($_POST['actitudalimentacion'])&&
isset($_POST['tecnicabacterial'])&&isset($_POST['ensenadopor'])&&isset($_POST['tipocepillo'])&&
isset($_POST['dentifrico'])&&isset($_POST['fluoruros'])&&isset($_POST['foururoedad'])&&
isset($_POST['foururocontinua'])&&isset($_POST['topicos'])&&isset($_POST['topicostiempo'])&&
isset($_POST['topicoscontinua'])&&isset($_POST['enjuagatorio'])&&isset($_POST['enjuagatoriocontinua'])&&
isset($_POST['sealants'])&&isset($_POST['oralhabits'])&&isset($_POST['resumefather'])&&
isset($_POST['actituddelnino'])&&isset($_POST['actituddelpadre'])&&isset($_POST['actitudacompanante'])&&
isset($_POST['firstsynthesis'])&&isset($_POST['cpod'])&&isset($_POST['cpos'])&&isset($_POST['ceod'])&&
isset($_POST['ceos'])&&isset($_POST['pri'])&&isset($_POST['per'])&&isset($_POST['activa'])&&
isset($_POST['lenta'])&&isset($_POST['detenida'])&&
isset($_POST['tl8'])&&isset($_POST['tl7'])&&isset($_POST['tl6'])&&isset($_POST['tl5'])&&
isset($_POST['tl4'])&&isset($_POST['tl3'])&&isset($_POST['tl2'])&&isset($_POST['tl1'])&&
isset($_POST['tr8'])&&isset($_POST['tr7'])&&isset($_POST['tr6'])&&isset($_POST['tr5'])&&
isset($_POST['tr4'])&&isset($_POST['tr3'])&&isset($_POST['tr2'])&&isset($_POST['tr1'])&&
isset($_POST['bl8'])&&isset($_POST['bl7'])&&isset($_POST['bl6'])&&isset($_POST['bl5'])&&
isset($_POST['bl4'])&&isset($_POST['bl3'])&&isset($_POST['bl2'])&&isset($_POST['bl1'])&&
isset($_POST['br8'])&&isset($_POST['br7'])&&isset($_POST['br6'])&&isset($_POST['br5'])&&
isset($_POST['br4'])&&isset($_POST['br3'])&&isset($_POST['br2'])&&isset($_POST['br1'])){


   $param=array();
   $info=DBPediatricsiInfo(htmlspecialchars(trim($_POST["ficha"])));
   if($info==null){
     echo "No Registrado";
     exit;
   }
   $param['patientid'] = htmlspecialchars($_POST["patientid"]);
   $param['patientdatebirth'] = htmlspecialchars($_POST["patientdatebirth"]);
   $param['patientplacebirth'] = htmlspecialchars($_POST["patientplacebirth"]);
   $param['patientfather'] = '['.htmlspecialchars($_POST["patientfathername"]).']['.htmlspecialchars($_POST["patientfatheroccupation"]).']';

   $param['patientmother'] = '['.htmlspecialchars($_POST["patientmothername"]).']['.htmlspecialchars($_POST["patientmotheroccupation"]).']';

   $param['brothers'] = htmlspecialchars($_POST["name"]).'#'.htmlspecialchars($_POST["age"]);

   $param['patientschools'] = htmlspecialchars($_POST["patientschools"]);
   $param['patientschool'] = htmlspecialchars($_POST["patientschool"]);
   //para tres inicio



   //$param['treatmentplan'] = htmlspecialchars($_POST["plantxt"]);
   $param['monitoring'] = htmlspecialchars($_POST["monitoreo"]);
   $param['comment'] = htmlspecialchars($_POST["comentario"]);

   //para tres fin
   $param['refer'] = htmlspecialchars($_POST["refer"]);
   $param['reason'] = htmlspecialchars($_POST["reason"]);
   $param['vitalsigns'] = '['.htmlspecialchars($_POST["temp"]).']['.htmlspecialchars($_POST["fc"]).']['.htmlspecialchars($_POST["fr"]).']['.htmlspecialchars($_POST["pd"]).']['.htmlspecialchars($_POST["talla"]).']['.
                          htmlspecialchars($_POST["peso"]).']['.htmlspecialchars($_POST["constit"]).']['.htmlspecialchars($_POST["pulso"]).']['.htmlspecialchars($_POST["diast"]).']';

   $param['motconsult'] = htmlspecialchars($_POST["motconsult"]);
   $param['attitude'] = htmlspecialchars($_POST["attitude"]);
   $chair=-1;
   if(is_numeric($_POST["chair"])){
     $chair=htmlspecialchars($_POST["chair"]);
   }
   $param['armchair'] = $chair;
   $param['prior'] = htmlspecialchars($_POST["prior"]);
   $param['lastattention'] = htmlspecialchars($_POST["lastattention"]);

   $param['periodic'] = '['.htmlspecialchars($_POST["periodica"]).']['.htmlspecialchars($_POST["periodicacuales"]).']';

   $param['experiences'] = '['.htmlspecialchars($_POST["traumaticas"]).']['.htmlspecialchars($_POST["traumaticascuales"]).']';

   $param['odontoattitude'] = htmlspecialchars($_POST["attitudeodont"]);
   $param['diseases'] = htmlspecialchars($_POST["diseases"]);
   $param['interventions'] = htmlspecialchars($_POST["interventions"]);
   $param['explanations'] = '['.htmlspecialchars($_POST["conexplicaciones"]).']['.htmlspecialchars($_POST["sinconexplicaciones"]).']';

   $param['experiencesinye'] = '['.htmlspecialchars($_POST["experienciastraumaticas"]).']['.htmlspecialchars($_POST["experienciastraumaticasotros"]).']';
   $param['godoctor'] = '['.htmlspecialchars($_POST["medicoperiodicamente"]).']['.htmlspecialchars($_POST["medicoirregularmente"]).']';

   $param['consistency'] = htmlspecialchars($_POST["consistency"]);
   $param['dieta'] = '['.htmlspecialchars($_POST["desayuno"]).']['.htmlspecialchars($_POST["desayunoalmuerzo"]).']['.htmlspecialchars($_POST["almuerzo"]).']['.
                      htmlspecialchars($_POST["merienda"]).']['.htmlspecialchars($_POST["cena"]).']['.htmlspecialchars($_POST["despuescena"]).']['.htmlspecialchars($_POST["despierta"]).']['.
                      htmlspecialchars($_POST["dulcedia"]).']['.htmlspecialchars($_POST["riesgocaries"]).']['.htmlspecialchars($_POST["actitudalimentacion"]).']';

   $param['bacterialcontrol'] = '['.htmlspecialchars($_POST["tecnicabacterial"]).']['.htmlspecialchars($_POST["ensenadopor"]).']['.htmlspecialchars($_POST["tipocepillo"]).']['.htmlspecialchars($_POST["dentifrico"]).']';

   $param['fluoridetherapy'] = '['.htmlspecialchars($_POST["fluoruros"]).']['.htmlspecialchars($_POST["foururoedad"]).']['.htmlspecialchars($_POST["foururocontinua"]).']['.
                                htmlspecialchars($_POST["topicos"]).']['.htmlspecialchars($_POST["topicostiempo"]).']['.htmlspecialchars($_POST["topicoscontinua"]).']['.
                                htmlspecialchars($_POST["enjuagatorio"]).']['.htmlspecialchars($_POST["enjuagatoriocontinua"]).']';

   $param['sealants'] = htmlspecialchars($_POST["sealants"]);
   $param['oralhabits'] = htmlspecialchars($_POST["oralhabits"]);
   $param['resumefather'] = htmlspecialchars($_POST["resumefather"]);

   $param['firstvisit'] = '['.htmlspecialchars($_POST["actituddelnino"]).']['.htmlspecialchars($_POST["actituddelpadre"]).']['.htmlspecialchars($_POST["actitudacompanante"]).']';

   $param['firstsynthesis'] = htmlspecialchars($_POST["firstsynthesis"]);
   $param['cpce'] = '['.htmlspecialchars($_POST["cpod"]).']['.htmlspecialchars($_POST["cpos"]).']['.htmlspecialchars($_POST["ceod"]).']['.htmlspecialchars($_POST["ceos"]).']';

   $param['teethpresent'] = '['.htmlspecialchars($_POST["pri"]).']['.htmlspecialchars($_POST["per"]).']';


   $param['teethtype'] = '['.htmlspecialchars($_POST["activa"]).']['.htmlspecialchars($_POST["lenta"]).']['.htmlspecialchars($_POST["detenida"]).']';


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
   $param["odontometa"] = '['.htmlspecialchars($_POST["tl8"]).']'.'['.htmlspecialchars($_POST["tl7"]).']'.'['.htmlspecialchars($_POST["tl6"]).']'.'['.htmlspecialchars($_POST["tl5"]).']'.
   '['.htmlspecialchars($_POST["tl4"]).']'.'['.htmlspecialchars($_POST["tl3"]).']'.'['.htmlspecialchars($_POST["tl2"]).']'.'['.htmlspecialchars($_POST["tl1"]).']'.
   '['.htmlspecialchars($_POST["tr8"]).']'.'['.htmlspecialchars($_POST["tr7"]).']'.'['.htmlspecialchars($_POST["tr6"]).']'.'['.htmlspecialchars($_POST["tr5"]).']'.
   '['.htmlspecialchars($_POST["tr4"]).']'.'['.htmlspecialchars($_POST["tr3"]).']'.'['.htmlspecialchars($_POST["tr2"]).']'.'['.htmlspecialchars($_POST["tr1"]).']'.
   '['.htmlspecialchars($_POST["bl8"]).']'.'['.htmlspecialchars($_POST["bl7"]).']'.'['.htmlspecialchars($_POST["bl6"]).']'.'['.htmlspecialchars($_POST["bl5"]).']'.
   '['.htmlspecialchars($_POST["bl4"]).']'.'['.htmlspecialchars($_POST["bl3"]).']'.'['.htmlspecialchars($_POST["bl2"]).']'.'['.htmlspecialchars($_POST["bl1"]).']'.
   '['.htmlspecialchars($_POST["br8"]).']'.'['.htmlspecialchars($_POST["br7"]).']'.'['.htmlspecialchars($_POST["br6"]).']'.'['.htmlspecialchars($_POST["br5"]).']'.
   '['.htmlspecialchars($_POST["br4"]).']'.'['.htmlspecialchars($_POST["br3"]).']'.'['.htmlspecialchars($_POST["br2"]).']'.'['.htmlspecialchars($_POST["br1"]).']';


    if($info['clinicalid']==15){
      if(isset($_POST['dentaria'])&&isset($_POST['anquilosis'])&&
       isset($_POST['agenesias'])&&isset($_POST['ectopica'])&&isset($_POST['supernumerarios'])&&
       isset($_POST['precoz'])&&isset($_POST['dentariaobs'])){
         $param['diagnosisradiographic']='['.htmlspecialchars($_POST["dentaria"]).']'.'['.htmlspecialchars($_POST["anquilosis"]).']'.
                                         '['.htmlspecialchars($_POST["agenesias"]).']'.'['.htmlspecialchars($_POST["ectopica"]).']'.
                                         '['.htmlspecialchars($_POST["supernumerarios"]).']'.'['.htmlspecialchars($_POST["precoz"]).']'.
                                         '['.htmlspecialchars($_POST["dentariaobs"]).']';
       }
       $iniciacion='f';
       //echo $_POST['iniciacion'].' '.$_POST['histo'].' '.$_POST['morfo'].' '.$_POST['aposicion'];
       if(isset($_POST['iniciacion'])&&$_POST['iniciacion']=='true'){
         $iniciacion='t';
       }
       $histo='f';
       if(isset($_POST['histo'])&&$_POST['histo']=='true'){
         $histo='t';
       }
       $morfo='f';
       if(isset($_POST['morfo'])&&$_POST['morfo']=='true'){
         $morfo='t';
       }
       $aposicion='f';
       if(isset($_POST['aposicion'])&&$_POST['aposicion']=='true'){
         $aposicion='t';
       }
       $calcificacion='f';
       if(isset($_POST['calcificacion'])&&$_POST['calcificacion']=='true'){
         $calcificacion='t';
       }
       $erupcion='f';
       if(isset($_POST['erupcion'])&&$_POST['erupcion']=='true'){
         $erupcion='t';
       }
       $abrasion='f';
       if(isset($_POST['abrasion'])&&$_POST['abrasion']=='true'){
         $abrasion='t';
       }
       $anomaliaobs='';
       if(isset($_POST['anomaliaobs'])&&$_POST['anomaliaobs']){
         $anomaliaobs=htmlspecialchars($_POST["anomaliaobs"]);
       }

      $param['anomaly']="[$iniciacion][$histo][$morfo][$aposicion][$calcificacion][$erupcion][$abrasion][$anomaliaobs]";
    }
   $param['status'] = 'process';

   $param['student'] = $info['student'];
   $param['teacher'] = $info['teacher'];
   $param['clinical'] = $info['clinicalid'];
   $param['remissionid'] = $info['remissionid'];
   $param['file'] = $info['pediatricsiid'];//id of clinical

   $inforemission=DBPatientRemissionInfo($info['remissionid']);
   $param['patientadmissionid']=$inforemission['patientadmissionid'];

   DBUpdatePatientPediatrics($param);//funcion para asignar datos de fecha de nacimiento y lugar de nacimiento.
   $param['mod']='update';
   DBNewOdontogram($param);

   $ret=DBNewPediatricsi($param);
   //DBNewObservation($param);//registra una nueva observacion en una tabla aislado
   if($ret==2){
     DBNewObservation($param);
     echo "yes";
   }else{
     echo "No se gurdaron los datos, el tiempo actual debe ser mayor al tiempo de registro";
   }
   //echo "yes";
   exit;
}
//para ortodoncia I
if(isset($_POST['patientid'])&&isset($_POST['ficha'])&&isset($_POST['motconsult'])&&
isset($_POST['alteration'])&&isset($_POST['hereditary'])&&isset($_POST['nutritional'])&&
isset($_POST['tipolactancia'])&&isset($_POST['duracionlactancia'])&&isset($_POST['diseases'])&&
isset($_POST['treatments'])&&isset($_POST['importance'])&&isset($_POST['badhabits'])&&
isset($_POST['trauma'])&&isset($_POST['respirator'])&&isset($_POST['eruption'])&&isset($_POST['faces'])&&
isset($_POST['profile'])&&isset($_POST['liprelation'])&&isset($_POST['mucosa'])&&isset($_POST['encias'])&&
isset($_POST['braces'])&&isset($_POST['palatine'])&&isset($_POST['tongue'])&&isset($_POST['forma'])&&
isset($_POST['tamano'])&&isset($_POST['simetria'])&&isset($_POST['dentition'])&&
isset($_POST['tipoausente'])&&isset($_POST['piezaausente'])&&isset($_POST['cavities'])&&
isset($_POST['included'])&&isset($_POST['retained'])&&isset($_POST['numerous'])&&isset($_POST['sealed'])&&
isset($_POST['rebuilt'])&&isset($_POST['endodontics'])&&isset($_POST['photo'])&&isset($_POST['model'])&&
isset($_POST['radiographic'])&&isset($_POST['diagnosispreg'])&&isset($_POST['diagnosisdef'])&&
isset($_POST['treatmentplan'])&&isset($_POST['study'])&&isset($_POST['treatment'])&&
isset($_POST['design'])&&isset($_POST['wire'])&&isset($_POST['wax'])&&isset($_POST['making'])&&
isset($_POST['acrylic'])&&isset($_POST['facility'])&&isset($_POST['controls'])&&isset($_POST['year'])){


   $param=array();
   $info=DBOrthodonticsInfo(htmlspecialchars(trim($_POST["ficha"])));
   if($info==null){
     echo "No Registrado";
     exit;
   }
   $param['patientid'] = htmlspecialchars($_POST["patientid"]);

   $param['motconsult'] = htmlspecialchars($_POST["motconsult"]);
   $param['alterations'] = htmlspecialchars($_POST["alteration"]);
   $param['hereditary'] = htmlspecialchars($_POST["hereditary"]);
   $param['nutritional'] = htmlspecialchars($_POST["nutritional"]);
   $param['year'] = htmlspecialchars($_POST["year"]);

   $param['lactation'] = '['.htmlspecialchars($_POST["tipolactancia"]).']['.htmlspecialchars($_POST["duracionlactancia"]).']';

   $param['diseases'] = htmlspecialchars($_POST["diseases"]);
   $param['treatments'] = htmlspecialchars($_POST["treatments"]);
   $param['importance'] = htmlspecialchars($_POST["importance"]);
   $param['badhabits'] = htmlspecialchars($_POST["badhabits"]);
   $param['trauma'] = htmlspecialchars($_POST["trauma"]);
   $param['respirator'] = htmlspecialchars($_POST["respirator"]);
   $param['eruption'] = htmlspecialchars($_POST["eruption"]);
   //para admision
   $param['faces'] = htmlspecialchars($_POST["faces"]);
   $param['profile'] = htmlspecialchars($_POST["profile"]);
   $param['liprelation'] = htmlspecialchars($_POST["liprelation"]);
   $param['mucosa'] = htmlspecialchars($_POST["mucosa"]);
   $param['encias'] = htmlspecialchars($_POST["encias"]);
   $param['braces'] = htmlspecialchars($_POST["braces"]);
   $param['palatine'] = htmlspecialchars($_POST["palatine"]);
   $param['tongue'] = htmlspecialchars($_POST["tongue"]);
   //arcade
   $param['arcade'] = '['.htmlspecialchars($_POST["forma"]).']['.htmlspecialchars($_POST["tamano"]).']['.htmlspecialchars($_POST["simetria"]).']';

   $param['dentition'] = htmlspecialchars($_POST["dentition"]);

   $param['missing'] = '['.htmlspecialchars($_POST["tipoausente"]).']['.htmlspecialchars($_POST["piezaausente"]).']';

   $param['cavities'] = htmlspecialchars($_POST["cavities"]);
   $param['included'] = htmlspecialchars($_POST["included"]);
   $param['retained'] = htmlspecialchars($_POST["retained"]);
   $param['numerous'] = htmlspecialchars($_POST["numerous"]);
   $param['sealed'] = htmlspecialchars($_POST["sealed"]);
   $param['rebuilt'] = htmlspecialchars($_POST["rebuilt"]);
   $param['endodontics'] = htmlspecialchars($_POST["endodontics"]);

   $param['photo'] = htmlspecialchars($_POST["photo"]);
   $param['model'] = htmlspecialchars($_POST["model"]);
   $param['radiographic'] = htmlspecialchars($_POST["radiographic"]);
   $param['diagnosispre'] = htmlspecialchars($_POST["diagnosispreg"]);
   $param['diagnosisdef'] = htmlspecialchars($_POST["diagnosisdef"]);
   $param['treatmentplan'] = htmlspecialchars($_POST["treatmentplan"]);
   $param['study'] = htmlspecialchars($_POST["study"]);
   $param['treatment'] = htmlspecialchars($_POST["treatment"]);
   $param['design'] = htmlspecialchars($_POST["design"]);
   $param['wire'] = htmlspecialchars($_POST["wire"]);
   $param['wax'] = htmlspecialchars($_POST["wax"]);
   $param['making'] = htmlspecialchars($_POST["making"]);
   $param['acrylic'] = htmlspecialchars($_POST["acrylic"]);
   $param['facility'] = htmlspecialchars($_POST["facility"]);
   $param['controls'] = htmlspecialchars($_POST["controls"]);

   $param['status'] = 'process';

   $param['student'] = $info['student'];
   $param['teacher'] = $info['teacher'];
   $param['clinical'] = $info['clinicalid'];
   $param['remissionid'] = $info['remissionid'];
   $param['file'] = $info['orthodonticsid'];//id of clinical

   $inforemission=DBPatientRemissionInfo($info['remissionid']);
   $param['dentalid']=$inforemission['patientdentalid'];

   DBUpdatePatientOrthodontics($param);//funcion para asignar datos de fecha de nacimiento y lugar de nacimiento.
   $param['mod']='update';

   $ret=DBNewOrthodontics($param);
   if($ret==2){
     DBNewObservation($param);
     echo "yes";
   }else{
     echo "No se gurdaron los datos, el tiempo actual debe ser mayor al tiempo de registro";
   }
   //DBNewObservation($param);//registra una nueva observacion en una tabla aislado
   //echo "yes";
   exit;
}
if(isset($_POST['olygram']) && $_POST['olygram'] != '' && isset($_POST['ficha']) && is_numeric($_POST['ficha'])){
  $conf=globalconf();
  $rev="";
  if($_SESSION['usertable']['usertype']=='student'){
    $rev='f';
  }
  if($_SESSION['usertable']['usertype']=='teacher'){
    $rev='t';
  }
  $param['olearygram'] = encryptData(trim($_POST["olygram"].'[xrev='.$rev.']'), $conf["key"], false);
  $param['file']=$_POST['ficha'];

  DBUpdateOleary($param);
  //echo $_POST['olygram'];
  echo "yes";
  exit;
}

if(isset($_POST['ficha']) && is_numeric($_POST['ficha']) && isset($_POST['urgencias'])&&
isset($_POST['urgfecha']) && isset($_POST['urgpieza']) && isset($_POST['urgdiagnostico']) &&
isset($_POST['urgtratamiento'])){

  $info=DBPediatricsiInfo(htmlspecialchars(trim($_POST["ficha"])));
  if($info==null){
    echo "No Registrado";
    exit;
  }

  $param=array();

  $param['student'] = $info['student'];
  $param['teacher'] = $info['teacher'];
  $param['file'] = $info['pediatricsiid'];//id of clinical

  //echo $_POST['urgencias'];
  $urgid=explode('.:.',trim($_POST['urgencias']));

  $urgfecha=explode(',',trim($_POST['urgfecha']));
  $urginicio=explode(',',trim($_POST['iniciofirma']));
  $urgfin=explode(',',trim($_POST['finfirma']));
  $urgpieza=explode('.:.',trim($_POST['urgpieza']));
  $urgdiagnostico=explode('.:.',trim($_POST['urgdiagnostico']));
  $urgtratamiento=explode('.:.',trim($_POST['urgtratamiento']));
  $size=count($urgid);
  $len=$size;
  $urg=DBAllPediatricsiControlInfo($_POST['ficha'], 'urgency');

  if($urg==null){
    for ($i=0; $i < $size-1; $i++) {
      if($urgid[$i]==''){
        $param['id']=-1;
      }else{
        $param['id']=$urgid[$i];
      }
      $param['date']=$urgfecha[$i];
      $param['part']=$urgpieza[$i];
      $param['diagnosis']=$urgdiagnostico[$i];
      $param['treatment']=$urgtratamiento[$i];
      $param['start']=$urginicio[$i];
      $param['end']=$urgfin[$i];
      $param['type']='urgency';

      DBNewPediatricsiControl($param);
    }
  }else{
    $size=count($urg);
    $visit=array();
    $data=array();
    for ($i=0; $i < $size; $i++) {
      $visit[$urg[$i]['controlid']]='f';
      $data[$i]=$urg[$i]['controlid'];
    }

    for ($i=0; $i < $len-1; $i++) {
      $param['id']=-1;
      if($urgid[$i]!=''){
        $param['id']=$urgid[$i];
      }
      $param['date']=$urgfecha[$i];
      $param['part']=$urgpieza[$i];
      $param['diagnosis']=$urgdiagnostico[$i];
      $param['treatment']=$urgtratamiento[$i];
      $param['start']=$urginicio[$i];
      $param['end']=$urgfin[$i];
      $param['type']='urgency';

      if (InArray($data, $param['id'])!==false) {
        $visit[$param['id']]='t';
      }
      DBNewPediatricsiControl($param);//funcion para añadir una urgencia
    }

    foreach ($visit as $key => $value) {
      if($value=='f'){
        DBDeletePediatricsiControl($key);
      }
    }

  }

  echo "yes";
  exit;
}

//revision....
if(isset($_POST['ficha']) && is_numeric($_POST['ficha']) && isset($_POST['inactivacion'])&&
isset($_POST['inafecha']) && isset($_POST['inapieza']) && isset($_POST['inadiagnostico']) &&
isset($_POST['inatratamiento'])){

  $info=DBPediatricsiInfo(htmlspecialchars(trim($_POST["ficha"])));
  if($info==null){
    echo "No Registrado";
    exit;
  }

  $param=array();

  $param['student'] = $info['student'];
  $param['teacher'] = $info['teacher'];
  $param['file'] = $info['pediatricsiid'];//id of clinical

  //echo $_POST['urgencias'];
  $urgid=explode('.:.',trim($_POST['inactivacion']));

  $urgfecha=explode(',',trim($_POST['inafecha']));
  $urginicio=explode(',',trim($_POST['inainicio']));
  $urgfin=explode(',',trim($_POST['inafin']));
  $urgpieza=explode('.:.',trim($_POST['inapieza']));
  $urgdiagnostico=explode('.:.',trim($_POST['inadiagnostico']));
  $urgtratamiento=explode('.:.',trim($_POST['inatratamiento']));
  $size=count($urgid);
  $len=$size;
  $urg=DBAllPediatricsiControlInfo($_POST['ficha'], 'inactivation');

  if($urg==null){
    for ($i=0; $i < $size-1; $i++) {
      if($urgid[$i]==''){
        $param['id']=-1;
      }else{
        $param['id']=$urgid[$i];
      }
      $param['date']=$urgfecha[$i];
      $param['part']=$urgpieza[$i];
      $param['diagnosis']=$urgdiagnostico[$i];
      $param['treatment']=$urgtratamiento[$i];
      $param['start']=$urginicio[$i];
      $param['end']=$urgfin[$i];
      $param['type']='inactivation';

      DBNewPediatricsiControl($param);
    }
  }else{
    $size=count($urg);
    $visit=array();
    $data=array();
    for ($i=0; $i < $size; $i++) {
      $visit[$urg[$i]['controlid']]='f';
      $data[$i]=$urg[$i]['controlid'];
    }

    for ($i=0; $i < $len-1; $i++) {
      $param['id']=-1;
      if($urgid[$i]!=''){
        $param['id']=$urgid[$i];
      }
      $param['date']=$urgfecha[$i];
      $param['part']=$urgpieza[$i];
      $param['diagnosis']=$urgdiagnostico[$i];
      $param['treatment']=$urgtratamiento[$i];
      $param['start']=$urginicio[$i];
      $param['end']=$urgfin[$i];
      $param['type']='inactivation';

      if (InArray($data, $param['id'])!==false) {
        $visit[$param['id']]='t';
      }
      DBNewPediatricsiControl($param);//funcion para añadir una urgencia
    }

    foreach ($visit as $key => $value) {
      if($value=='f'){
        DBDeletePediatricsiControl($key);
      }
    }

  }

  echo "yes";
  exit;
}

//quimico
if(isset($_POST['ficha']) && is_numeric($_POST['ficha']) && isset($_POST['quimico'])&&
isset($_POST['quifecha']) && isset($_POST['quipieza']) && isset($_POST['quidiagnostico']) &&
isset($_POST['quitratamiento'])){

  $info=DBPediatricsiInfo(htmlspecialchars(trim($_POST["ficha"])));
  if($info==null){
    echo "No Registrado";
    exit;
  }

  $param=array();

  $param['student'] = $info['student'];
  $param['teacher'] = $info['teacher'];
  $param['file'] = $info['pediatricsiid'];//id of clinical

  //echo $_POST['urgencias'];
  $urgid=explode('.:.',trim($_POST['quimico']));

  $urgfecha=explode(',',trim($_POST['quifecha']));
  $urginicio=explode(',',trim($_POST['quiinicio']));
  $urgfin=explode(',',trim($_POST['quifin']));
  $urgpieza=explode('.:.',trim($_POST['quipieza']));
  $urgdiagnostico=explode('.:.',trim($_POST['quidiagnostico']));
  $urgtratamiento=explode('.:.',trim($_POST['quitratamiento']));
  $size=count($urgid);
  $len=$size;
  $urg=DBAllPediatricsiControlInfo($_POST['ficha'], 'quimic');

  if($urg==null){
    for ($i=0; $i < $size-1; $i++) {
      if($urgid[$i]==''){
        $param['id']=-1;
      }else{
        $param['id']=$urgid[$i];
      }
      $param['date']=$urgfecha[$i];
      $param['part']=$urgpieza[$i];
      $param['diagnosis']=$urgdiagnostico[$i];
      $param['treatment']=$urgtratamiento[$i];
      $param['start']=$urginicio[$i];
      $param['end']=$urgfin[$i];
      $param['type']='quimic';

      DBNewPediatricsiControl($param);
    }
  }else{
    $size=count($urg);
    $visit=array();
    $data=array();
    for ($i=0; $i < $size; $i++) {
      $visit[$urg[$i]['controlid']]='f';
      $data[$i]=$urg[$i]['controlid'];
    }

    for ($i=0; $i < $len-1; $i++) {
      $param['id']=-1;
      if($urgid[$i]!=''){
        $param['id']=$urgid[$i];
      }
      $param['date']=$urgfecha[$i];
      $param['part']=$urgpieza[$i];
      $param['diagnosis']=$urgdiagnostico[$i];
      $param['treatment']=$urgtratamiento[$i];
      $param['start']=$urginicio[$i];
      $param['end']=$urgfin[$i];
      $param['type']='quimic';

      if (InArray($data, $param['id'])!==false) {
        $visit[$param['id']]='t';
      }
      DBNewPediatricsiControl($param);//funcion para añadir una urgencia
    }

    foreach ($visit as $key => $value) {
      if($value=='f'){
        DBDeletePediatricsiControl($key);
      }
    }

  }

  echo "yes";
  exit;
}
//morfologico
if(isset($_POST['ficha']) && is_numeric($_POST['ficha']) && isset($_POST['morfologico'])&&
isset($_POST['morfecha']) && isset($_POST['morpieza']) && isset($_POST['mordiagnostico']) &&
isset($_POST['mortratamiento'])){

  $info=DBPediatricsiInfo(htmlspecialchars(trim($_POST["ficha"])));
  if($info==null){
    echo "No Registrado";
    exit;
  }

  $param=array();

  $param['student'] = $info['student'];
  $param['teacher'] = $info['teacher'];
  $param['file'] = $info['pediatricsiid'];//id of clinical

  //echo $_POST['urgencias'];
  $urgid=explode('.:.',trim($_POST['morfologico']));

  $urgfecha=explode(',',trim($_POST['morfecha']));
  $urginicio=explode(',',trim($_POST['morinicio']));
  $urgfin=explode(',',trim($_POST['morfin']));
  $urgpieza=explode('.:.',trim($_POST['morpieza']));
  $urgdiagnostico=explode('.:.',trim($_POST['mordiagnostico']));
  $urgtratamiento=explode('.:.',trim($_POST['mortratamiento']));
  $size=count($urgid);
  $len=$size;
  $urg=DBAllPediatricsiControlInfo($_POST['ficha'], 'morfologic');

  if($urg==null){
    for ($i=0; $i < $size-1; $i++) {
      if($urgid[$i]==''){
        $param['id']=-1;
      }else{
        $param['id']=$urgid[$i];
      }
      $param['date']=$urgfecha[$i];
      $param['part']=$urgpieza[$i];
      $param['diagnosis']=$urgdiagnostico[$i];
      $param['treatment']=$urgtratamiento[$i];
      $param['start']=$urginicio[$i];
      $param['end']=$urgfin[$i];
      $param['type']='morfologic';

      DBNewPediatricsiControl($param);
    }
  }else{
    $size=count($urg);
    $visit=array();
    $data=array();
    for ($i=0; $i < $size; $i++) {
      $visit[$urg[$i]['controlid']]='f';
      $data[$i]=$urg[$i]['controlid'];
    }

    for ($i=0; $i < $len-1; $i++) {
      $param['id']=-1;
      if($urgid[$i]!=''){
        $param['id']=$urgid[$i];
      }
      $param['date']=$urgfecha[$i];
      $param['part']=$urgpieza[$i];
      $param['diagnosis']=$urgdiagnostico[$i];
      $param['treatment']=$urgtratamiento[$i];
      $param['start']=$urginicio[$i];
      $param['end']=$urgfin[$i];
      $param['type']='morfologic';

      if (InArray($data, $param['id'])!==false) {
        $visit[$param['id']]='t';
      }
      DBNewPediatricsiControl($param);//funcion para añadir una urgencia
    }

    foreach ($visit as $key => $value) {
      if($value=='f'){
        DBDeletePediatricsiControl($key);
      }
    }

  }

  echo "yes";
  exit;
}


//estructural
if(isset($_POST['ficha']) && is_numeric($_POST['ficha']) && isset($_POST['plantxt'])){

  $info=DBPediatricsiInfo(htmlspecialchars(trim($_POST["ficha"])));
  if($info==null){
    echo "No Registrado";
    exit;
  }

  $param=array();

  $param['student'] = $info['student'];
  $param['teacher'] = $info['teacher'];
  $param['file'] = $info['pediatricsiid'];//id of clinical
  $param['plantxt'] = htmlspecialchars(trim($_POST["plantxt"]));

  DBUpdatePlan($param);//para actualizar plan de tratamiento

  echo "yes";
  exit;
}

//morfologico
if(isset($_POST['ficha']) && is_numeric($_POST['ficha']) && isset($_POST['morfologico'])&&
isset($_POST['morfecha']) && isset($_POST['morpieza']) && isset($_POST['mordiagnostico']) &&
isset($_POST['mortratamiento'])){

  $info=DBPediatricsiInfo(htmlspecialchars(trim($_POST["ficha"])));
  if($info==null){
    echo "No Registrado";
    exit;
  }

  $param=array();

  $param['student'] = $info['student'];
  $param['teacher'] = $info['teacher'];
  $param['file'] = $info['pediatricsiid'];//id of clinical

  //echo $_POST['urgencias'];
  $urgid=explode('.:.',trim($_POST['morfologico']));

  $urgfecha=explode(',',trim($_POST['morfecha']));
  $urginicio=explode(',',trim($_POST['morinicio']));
  $urgfin=explode(',',trim($_POST['morfin']));
  $urgpieza=explode('.:.',trim($_POST['morpieza']));
  $urgdiagnostico=explode('.:.',trim($_POST['mordiagnostico']));
  $urgtratamiento=explode('.:.',trim($_POST['mortratamiento']));
  $size=count($urgid);
  $len=$size;
  $urg=DBAllPediatricsiControlInfo($_POST['ficha'], 'morfologic');

  if($urg==null){
    for ($i=0; $i < $size-1; $i++) {
      if($urgid[$i]==''){
        $param['id']=-1;
      }else{
        $param['id']=$urgid[$i];
      }
      $param['date']=$urgfecha[$i];
      $param['part']=$urgpieza[$i];
      $param['diagnosis']=$urgdiagnostico[$i];
      $param['treatment']=$urgtratamiento[$i];
      $param['start']=$urginicio[$i];
      $param['end']=$urgfin[$i];
      $param['type']='morfologic';

      DBNewPediatricsiControl($param);
    }
  }else{
    $size=count($urg);
    $visit=array();
    $data=array();
    for ($i=0; $i < $size; $i++) {
      $visit[$urg[$i]['controlid']]='f';
      $data[$i]=$urg[$i]['controlid'];
    }

    for ($i=0; $i < $len-1; $i++) {
      $param['id']=-1;
      if($urgid[$i]!=''){
        $param['id']=$urgid[$i];
      }
      $param['date']=$urgfecha[$i];
      $param['part']=$urgpieza[$i];
      $param['diagnosis']=$urgdiagnostico[$i];
      $param['treatment']=$urgtratamiento[$i];
      $param['start']=$urginicio[$i];
      $param['end']=$urgfin[$i];
      $param['type']='morfologic';

      if (InArray($data, $param['id'])!==false) {
        $visit[$param['id']]='t';
      }
      DBNewPediatricsiControl($param);//funcion para añadir una urgencia
    }

    foreach ($visit as $key => $value) {
      if($value=='f'){
        DBDeletePediatricsiControl($key);
      }
    }

  }

  echo "yes";
  exit;
}


//estructural
if(isset($_POST['ficha']) && is_numeric($_POST['ficha']) && isset($_POST['estructural'])&&
isset($_POST['estfecha']) && isset($_POST['estpieza']) && isset($_POST['estdiagnostico']) &&
isset($_POST['esttratamiento'])){

  $info=DBPediatricsiInfo(htmlspecialchars(trim($_POST["ficha"])));
  if($info==null){
    echo "No Registrado";
    exit;
  }

  $param=array();

  $param['student'] = $info['student'];
  $param['teacher'] = $info['teacher'];
  $param['file'] = $info['pediatricsiid'];//id of clinical




  //echo $_POST['urgencias'];
  $urgid=explode('.:.',trim($_POST['estructural']));

  $urgfecha=explode(',',trim($_POST['estfecha']));
  $urginicio=explode(',',trim($_POST['estinicio']));
  $urgfin=explode(',',trim($_POST['estfin']));
  $urgpieza=explode('.:.',trim($_POST['estpieza']));
  $urgdiagnostico=explode('.:.',trim($_POST['estdiagnostico']));
  $urgtratamiento=explode('.:.',trim($_POST['esttratamiento']));
  $size=count($urgid);
  $len=$size;
  $urg=DBAllPediatricsiControlInfo($_POST['ficha'], 'estruct');

  if($urg==null){
    for ($i=0; $i < $size-1; $i++) {
      if($urgid[$i]==''){
        $param['id']=-1;
      }else{
        $param['id']=$urgid[$i];
      }
      $param['date']=$urgfecha[$i];
      $param['part']=$urgpieza[$i];
      $param['diagnosis']=$urgdiagnostico[$i];
      $param['treatment']=$urgtratamiento[$i];
      $param['start']=$urginicio[$i];
      $param['end']=$urgfin[$i];
      $param['type']='estruct';

      DBNewPediatricsiControl($param);

    }

  }else{

    $size=count($urg);
    $visit=array();
    $data=array();
    for ($i=0; $i < $size; $i++) {
      $visit[$urg[$i]['controlid']]='f';
      $data[$i]=$urg[$i]['controlid'];
    }

    for ($i=0; $i < $len-1; $i++) {
      $param['id']=-1;
      if($urgid[$i]!=''){
        $param['id']=$urgid[$i];
      }
      $param['date']=$urgfecha[$i];
      $param['part']=$urgpieza[$i];
      $param['diagnosis']=$urgdiagnostico[$i];
      $param['treatment']=$urgtratamiento[$i];
      $param['start']=$urginicio[$i];
      $param['end']=$urgfin[$i];
      $param['type']='estruct';

      if (InArray($data, $param['id'])!==false) {
        $visit[$param['id']]='t';
      }
      DBNewPediatricsiControl($param);//funcion para añadir una urgencia
    }

    foreach ($visit as $key => $value) {
      if($value=='f'){
        DBDeletePediatricsiControl($key);
      }
    }

  }

  echo "yes";
  exit;
}

//cirugia
if(isset($_POST['ficha']) && is_numeric($_POST['ficha']) && isset($_POST['cirugia'])&&
isset($_POST['cirfecha']) && isset($_POST['cirpieza']) && isset($_POST['cirdiagnostico']) &&
isset($_POST['cirtratamiento'])){

  $info=DBPediatricsiInfo(htmlspecialchars(trim($_POST["ficha"])));
  if($info==null){
    echo "No Registrado";
    exit;
  }

  $param=array();

  $param['student'] = $info['student'];
  $param['teacher'] = $info['teacher'];
  $param['file'] = $info['pediatricsiid'];//id of clinical

  //echo $_POST['urgencias'];
  $urgid=explode('.:.',trim($_POST['cirugia']));

  $urgfecha=explode(',',trim($_POST['cirfecha']));
  $urginicio=explode(',',trim($_POST['cirinicio']));
  $urgfin=explode(',',trim($_POST['cirfin']));
  $urgpieza=explode('.:.',trim($_POST['cirpieza']));
  $urgdiagnostico=explode('.:.',trim($_POST['cirdiagnostico']));
  $urgtratamiento=explode('.:.',trim($_POST['cirtratamiento']));
  $size=count($urgid);
  $len=$size;
  $urg=DBAllPediatricsiControlInfo($_POST['ficha'], 'surgery');

  if($urg==null){
    for ($i=0; $i < $size-1; $i++) {
      if($urgid[$i]==''){
        $param['id']=-1;
      }else{
        $param['id']=$urgid[$i];
      }
      $param['date']=$urgfecha[$i];
      $param['part']=$urgpieza[$i];
      $param['diagnosis']=$urgdiagnostico[$i];
      $param['treatment']=$urgtratamiento[$i];
      $param['start']=$urginicio[$i];
      $param['end']=$urgfin[$i];
      $param['type']='surgery';

      DBNewPediatricsiControl($param);
    }
  }else{
    $size=count($urg);
    $visit=array();
    $data=array();
    for ($i=0; $i < $size; $i++) {
      $visit[$urg[$i]['controlid']]='f';
      $data[$i]=$urg[$i]['controlid'];
    }

    for ($i=0; $i < $len-1; $i++) {
      $param['id']=-1;
      if($urgid[$i]!=''){
        $param['id']=$urgid[$i];
      }
      $param['date']=$urgfecha[$i];
      $param['part']=$urgpieza[$i];
      $param['diagnosis']=$urgdiagnostico[$i];
      $param['treatment']=$urgtratamiento[$i];
      $param['start']=$urginicio[$i];
      $param['end']=$urgfin[$i];
      $param['type']='surgery';

      if (InArray($data, $param['id'])!==false) {
        $visit[$param['id']]='t';
      }
      DBNewPediatricsiControl($param);//funcion para añadir una urgencia
    }

    foreach ($visit as $key => $value) {
      if($value=='f'){
        DBDeletePediatricsiControl($key);
      }
    }

  }

  echo "yes";
  exit;
}


//pulpar
if(isset($_POST['ficha']) && is_numeric($_POST['ficha']) && isset($_POST['pulpar'])&&
isset($_POST['pulfecha']) && isset($_POST['pulpieza']) && isset($_POST['puldiagnostico']) &&
isset($_POST['pultratamiento'])){

  $info=DBPediatricsiInfo(htmlspecialchars(trim($_POST["ficha"])));
  if($info==null){
    echo "No Registrado";
    exit;
  }

  $param=array();

  $param['student'] = $info['student'];
  $param['teacher'] = $info['teacher'];
  $param['file'] = $info['pediatricsiid'];//id of clinical

  //echo $_POST['urgencias'];
  $urgid=explode('.:.',trim($_POST['pulpar']));

  $urgfecha=explode(',',trim($_POST['pulfecha']));
  //pulpar session inicio
  $urginicio=explode(']',trim($_POST['pulparsession']));

  $urgfin=explode(',',trim($_POST['pulfin']));
  $urgpieza=explode('.:.',trim($_POST['pulpieza']));
  $urgdiagnostico=explode('.:.',trim($_POST['puldiagnostico']));
  $urgtratamiento=explode('.:.',trim($_POST['pultratamiento']));
  $size=count($urgid);
  $len=$size;
  $urg=DBAllPediatricsiControlInfo($_POST['ficha'], 'pulpar');

  if($urg==null){
    for ($i=0; $i < $size-1; $i++) {
      if($urgid[$i]==''){
        $param['id']=-1;
      }else{
        $param['id']=$urgid[$i];
      }
      $param['date']=$urgfecha[$i];
      $param['part']=$urgpieza[$i];
      $param['diagnosis']=$urgdiagnostico[$i];
      $param['treatment']=$urgtratamiento[$i];
      $param['start']=$urginicio[$i];
      $param['end']=$urgfin[$i];
      $param['type']='pulpar';

      DBNewPediatricsiControl($param);
    }
  }else{
    $size=count($urg);
    $visit=array();
    $data=array();
    for ($i=0; $i < $size; $i++) {
      $visit[$urg[$i]['controlid']]='f';
      $data[$i]=$urg[$i]['controlid'];
    }

    for ($i=0; $i < $len-1; $i++) {
      $param['id']=-1;
      if($urgid[$i]!=''){
        $param['id']=$urgid[$i];
      }
      $param['date']=$urgfecha[$i];
      $param['part']=$urgpieza[$i];
      $param['diagnosis']=$urgdiagnostico[$i];
      $param['treatment']=$urgtratamiento[$i];
      $param['start']=$urginicio[$i];
      $param['end']=$urgfin[$i];
      $param['type']='pulpar';

      if (InArray($data, $param['id'])!==false) {
        $visit[$param['id']]='t';
      }
      DBNewPediatricsiControl($param);//funcion para añadir una urgencia
    }

    foreach ($visit as $key => $value) {
      if($value=='f'){
        DBDeletePediatricsiControl($key);
      }
    }

  }

  echo "yes";
  exit;
}

//rehabilitacion
if(isset($_POST['ficha']) && is_numeric($_POST['ficha']) && isset($_POST['rehabilitation'])&&
isset($_POST['rehfecha']) && isset($_POST['rehpieza']) && isset($_POST['rehdiagnostico']) &&
isset($_POST['rehtratamiento'])){

  $info=DBPediatricsiInfo(htmlspecialchars(trim($_POST["ficha"])));
  if($info==null){
    echo "No Registrado";
    exit;
  }

  $param=array();

  $param['student'] = $info['student'];
  $param['teacher'] = $info['teacher'];
  $param['file'] = $info['pediatricsiid'];//id of clinical

  //echo $_POST['urgencias'];
  $urgid=explode('.:.',trim($_POST['rehabilitation']));

  $urgfecha=explode(',',trim($_POST['rehfecha']));
  //rehpar session inicio
  $urginicio=explode(']',trim($_POST['rehabilitationsession']));

  $urgfin=explode(',',trim($_POST['rehfin']));
  $urgpieza=explode('.:.',trim($_POST['rehpieza']));
  $urgdiagnostico=explode('.:.',trim($_POST['rehdiagnostico']));
  $urgtratamiento=explode('.:.',trim($_POST['rehtratamiento']));
  $size=count($urgid);
  $len=$size;
  $urg=DBAllPediatricsiControlInfo($_POST['ficha'], 'rehabilitation');

  if($urg==null){
    for ($i=0; $i < $size-1; $i++) {
      if($urgid[$i]==''){
        $param['id']=-1;
      }else{
        $param['id']=$urgid[$i];
      }
      $param['date']=$urgfecha[$i];
      $param['part']=$urgpieza[$i];
      $param['diagnosis']=$urgdiagnostico[$i];
      $param['treatment']=$urgtratamiento[$i];
      $param['start']=$urginicio[$i];
      $param['end']=$urgfin[$i];
      $param['type']='rehabilitation';

      DBNewPediatricsiControl($param);
    }
  }else{
    $size=count($urg);
    $visit=array();
    $data=array();
    for ($i=0; $i < $size; $i++) {
      $visit[$urg[$i]['controlid']]='f';
      $data[$i]=$urg[$i]['controlid'];
    }

    for ($i=0; $i < $len-1; $i++) {
      $param['id']=-1;
      if($urgid[$i]!=''){
        $param['id']=$urgid[$i];
      }
      $param['date']=$urgfecha[$i];
      $param['part']=$urgpieza[$i];
      $param['diagnosis']=$urgdiagnostico[$i];
      $param['treatment']=$urgtratamiento[$i];
      $param['start']=$urginicio[$i];
      $param['end']=$urgfin[$i];
      $param['type']='rehabilitation';

      if (InArray($data, $param['id'])!==false) {
        $visit[$param['id']]='t';
      }
      DBNewPediatricsiControl($param);//funcion para añadir una urgencia
    }

    foreach ($visit as $key => $value) {
      if($value=='f'){
        DBDeletePediatricsiControl($key);
      }
    }

  }

  echo "yes";
  exit;
}

//rehabilitacion
if(isset($_POST['ficha'])&&  isset($_POST['study'])&&  isset($_POST['treatment'])&&
  isset($_POST['design'])&&  isset($_POST['wire'])&&  isset($_POST['wax'])&&
  isset($_POST['making'])&&  isset($_POST['acrylic'])&&  isset($_POST['logiadesc'])&&
  isset($_POST['logiafirma'])&&  isset($_POST['logiadate'])){

  $info=DBOrthodonticsInfo(htmlspecialchars(trim($_POST["ficha"])));
  if($info==null){
    echo "No Registrado";
    exit;
  }
  $param=array();

  $param['student'] = $info['student'];
  $param['teacher'] = $info['teacher'];
  $param['file'] = $info['orthodonticsid'];//id of clinical

  $param['study'] = htmlspecialchars($_POST["study"]);
  $param['treatment'] = htmlspecialchars($_POST["treatment"]);
  $param['design'] = htmlspecialchars($_POST["design"]);
  $param['wire'] = htmlspecialchars($_POST["wire"]);
  $param['wax'] = htmlspecialchars($_POST["wax"]);
  $param['making'] = htmlspecialchars($_POST["making"]);
  $param['acrylic'] = htmlspecialchars($_POST["acrylic"]);
  if ($_POST["logiadesc"]==''&&$_POST["logiafirma"]==''&&$_POST["logiadate"]=='') {
    $param['facility']='';
  }else{
    $param['facility']='['.htmlspecialchars($_POST["logiadesc"]).']['.htmlspecialchars($_POST["logiafirma"]).']['.htmlspecialchars($_POST["logiadate"]).']';
  }
  DBUpdateOrthodonticsImpresion($param);
  echo "yes";
  exit;
}

if(isset($_POST['ficha'])&&  isset($_POST['controlesdesc'])){

  $info=DBOrthodonticsInfo(htmlspecialchars(trim($_POST["ficha"])));
  if($info==null){
    echo "No Registrado";
    exit;
  }
  $param=array();

  $param['student'] = $info['student'];
  $param['teacher'] = $info['teacher'];
  $param['file'] = $info['orthodonticsid'];//id of clinical

  $param['controls'] = htmlspecialchars($_POST["controlesdesc"]);

  DBUpdateOrthodonticsControls($param);
  echo "yes";
  exit;
}
if(isset($_POST['ficha'])&&  isset($_POST['imggram'])){

  $info=DBOrthodonticsInfo(htmlspecialchars(trim($_POST["ficha"])));
  if($info==null){
    echo "No Registrado";
    exit;
  }
  $param=array();

  $param['student'] = $info['student'];
  $param['teacher'] = $info['teacher'];
  $param['file'] = $info['orthodonticsid'];//id of clinical

  //$conf=globalconf();
  $param['gram'] = $_POST["imggram"];//encryptData($_POST["imggram"], $conf["key"], false);

  DBUpdateOrthodonticsGram($param);
  echo "yes";
  exit;
}

if (isset($_POST["idfile"]) && is_numeric($_POST["idfile"]) && isset($_FILES["finalinput"]["name"]) &&
$_FILES["finalinput"]["name"]!="") {

    $type=myhtmlspecialchars($_FILES["finalinput"]["type"]);
    $size=myhtmlspecialchars($_FILES["finalinput"]["size"]);
    $name=myhtmlspecialchars($_FILES["finalinput"]["name"]);
    $temp=myhtmlspecialchars($_FILES["finalinput"]["tmp_name"]);
    if (!is_uploaded_file($temp)) {
      IntrusionNotify("problema al cargar el archivo.");
      echo "no";
      //ForceLoad("../index.php");//index.php
    }
  $param = array();
  $param['file'] = $_POST["idfile"];
  $param['inputfilename'] = $name;
  $param['inputfilepath'] = $temp;

  $param['startdatetime']=strtotime(trim($_POST["meeting-time"]));
  $param['updatetime'] = strtotime(trim($_POST["meeting-time"]));
  $param['enddatetime'] = strtotime(trim($_POST["meeting-time"]));
  $param['teacher'] = $_POST['teacher'];
  if($param['teacher']==''){
    echo "Debe seleccionar Docente";
    exit;
  }
  $teacher = $_POST['teacher'];
  $table='pediatricsi';
  $param['table'] = $table;

  $info=DBPediatricsiInfo($param['file']);
  if($info==null){
    echo "No Registrado";
    exit;
  }
  $param['patientid'] = $info['patientid'];
  $param['student'] = $info['student'];
  $param['clinical'] = $info['clinicalid'];
  $param['remissionid'] = $info['remissionid'];
  $param['file'] = $info['pediatricsiid'];//id of clinical
  // actuliza un archivo el importa un archivo a base de datos y devuelve oid
  $ret=DBNewFinalInputData ($_SESSION["usertable"]["usernumber"], $param);
  DBUpdateTableToEnd($table, $param['file']);

  if($ret==2){
    $param['observationevaluated']='t';
    $param['observationaccepted']='t';
    DBNewObservation($param);
    $ret=DBDesignedTeacher($teacher, $param['file'], $param["clinical"],$param['startdatetime']);

  }

  echo "Yes";//exito
  exit;
}
?>
