#!/usr/bin/php
<?php
//FABIAN SIERRA ACARAPI
$ds = DIRECTORY_SEPARATOR;
if($ds=="") $ds = "/";

if(is_readable('/etc/sihco.conf')) {
	$pif=parse_ini_file('/etc/sihco.conf');
	$sihcodir = trim($pif['sihcodir']) . $ds . 'src';
} else {
	$sihcodir = getcwd();
}

if(is_readable($sihcodir . $ds . '..' .$ds . 'db.php')) {
	require_once($sihcodir . $ds . '..' .$ds . 'db.php');
	@include_once($sihcodir . $ds . '..' .$ds . 'version.php');
} else {
  if(is_readable($sihcodir . $ds . 'db.php')) {
	require_once($sihcodir . $ds . 'db.php');
	@include_once($sihcodir . $ds . 'version.php');
  } else {
	  echo "no encontrado archivo db.php";
	  exit;
  }
}
if (getIP()!="UNKNOWN" || php_sapi_name()!=="cli") exit;
ini_set('memory_limit','600M');
ini_set('output_buffering','off');
ini_set('implicit_flush','on');
@ob_end_flush();

if(system('test "`id -u`" -eq "0"',$retval)===false || $retval!=0) {
	echo "Debe ejecutar como root\n";
	exit;
}
echo "\nINICIANDO SCRIPT...\n";

$url='../../doc/pediatrics.txt';
$temp=myhtmlspecialchars($url);

if (($ar = file($temp)) === false) {
    echo "No se puede abrir el archivo cargado.";
    exit;
}
$url='../../doc/plantxt.txt';
$temp2=myhtmlspecialchars($url);

if (($ar2 = file($temp2)) === false) {
    echo "No se puede abrir el archivo cargado.";
    exit;
}
$plantxt='';
for ($b=0; $b < count($ar2); $b++){
  $plantxt.=$ar2[$b];
}

for ($i=0; $i < count($ar) && strpos($ar[$i], "[odontopediatria]") === false; $i++) ;
if($i >= count($ar)) echo 'Formato de archivo no reconocido';
$conf=globalconf();
for ($i++; $i < count($ar) && $ar[$i][0] != "["; $i++) {

  $x = trim($ar[$i]);
  if (strpos($x, "odontopediatria") !== false && strpos($x, "odontopediatria") == 0) {
    $param = array();
		$teacher=0;
    while (strpos($x, "odontopediatria") !== false && strpos($x, "odontopediatria") == 0) {
      $tmp = explode ("<=>", $x, 2);
      switch (trim($tmp[0])) {
        case "odontopediatriaremissionid":    $param['remissionid']=trim($tmp[1]); break;
        case "odontopediatriapatientdatebirth":    $param['patientdatebirth']=trim($tmp[1]); break;
        case "odontopediatriapatientplacebirth":    $param['patientplacebirth']=trim($tmp[1]); break;
        case "odontopediatriapatientfather":    $param['patientfather']=trim($tmp[1]);break;
        case "odontopediatriapatientmother":    $param['patientmother']=trim($tmp[1]); break;
        case "odontopediatriabrothers":    $param['brothers']=trim($tmp[1]); break;
        case "odontopediatriapatientschools":    $param['patientschools']=trim($tmp[1]); break;
        case "odontopediatriamonitoring":    $param['monitoring']=trim($tmp[1]); break;
        case "odontopediatriacomment":    $param['comment']=trim($tmp[1]); break;
        case "odontopediatriarefer":    $param['refer']=trim($tmp[1]); break;
        case "odontopediatriareason":    $param['reason']=trim($tmp[1]); break;
        case "odontopediatriavitalsigns":    $param['vitalsigns']=trim($tmp[1]); break;
        case "odontopediatriamotconsult":    $param['motconsult']=trim($tmp[1]); break;
        case "odontopediatriaattitude":    $param['attitude']=trim($tmp[1]); break;
        case "odontopediatriaarmchair":    $param['armchair']=trim($tmp[1]); break;
        case "odontopediatriaprior":    $param['prior']=trim($tmp[1]); break;
        case "odontopediatrialastattention":    $param['lastattention']=trim($tmp[1]); break;
        case "odontopediatriaperiodic":    $param['periodic']=trim($tmp[1]); break;
        case "odontopediatriaexperiences":    $param['experiences']=trim($tmp[1]); break;
        case "odontopediatriaodontoattitude":    $param['odontoattitude']=trim($tmp[1]); break;
        case "odontopediatriadiseases":    $param['diseases']=trim($tmp[1]); break;
        case "odontopediatriainterventions":    $param['interventions']=trim($tmp[1]); break;
        case "odontopediatriaexplanations":    $param['explanations']=trim($tmp[1]); break;
        case "odontopediatriagodoctor":    $param['godoctor']=trim($tmp[1]); break;
        case "odontopediatriaconsistency":    $param['consistency']=trim($tmp[1]); break;
        case "odontopediatriadieta":    $param['dieta']=trim($tmp[1]); break;
        case "odontopediatriabacterialcontrol":    $param['bacterialcontrol']=trim($tmp[1]); break;
        case "odontopediatriafluoridetherapy":    $param['fluoridetherapy']=trim($tmp[1]); break;
        case "odontopediatriasealants":    $param['sealants']=trim($tmp[1]); break;
        case "odontopediatriaoralhabits":    $param['oralhabits']=trim($tmp[1]); break;
        case "odontopediatriaresumefather":    $param['resumefather']=trim($tmp[1]); break;
        case "odontopediatriafirstvisit":    $param['firstvisit']=trim($tmp[1]); break;
        case "odontopediatriafirstsynthesis":    $param['firstsynthesis']=trim($tmp[1]); break;
        case "odontopediatriacpce":    $param['cpce']=trim($tmp[1]); break;
        case "odontopediatriateethpresent":    $param['teethpresent']=trim($tmp[1]); break;
        case "odontopediatriateethtype":    $param['teethtype']=trim($tmp[1]); break;
        case "odontopediatriaodontometa":    $param['odontometa']=trim($tmp[1]); break;
        case "odontopediatriaanomaly":    $param['anomaly']=trim($tmp[1]); break;
        case "odontopediatriastatus":    $param['status']=trim($tmp[1]); break;
        case "odontopediatriaolygram":    $param['olearygram']=encryptData(trim($tmp[1].'t'), $conf["key"], false);break;
        case "odontopediatriaplantxt":    $param['plantxt']=trim($tmp[1]); break;

				case "odontopediatriaurgencias":    $param['urgencias']=trim($tmp[1]); break;
				case "odontopediatriaurgfecha":    $param['urgfecha']=trim($tmp[1]); break;
				case "odontopediatriaurginicio":    $param['urginicio']=trim($tmp[1]); break;
				case "odontopediatriaurgfin":    $param['urgfin']=trim($tmp[1]); break;
				case "odontopediatriaurgpieza":    $param['urgpieza']=trim($tmp[1]); break;
				case "odontopediatriaurgdiagnostico":    $param['urgdiagnostico']=trim($tmp[1]); break;
				case "odontopediatriaurgtratamiento":    $param['urgtratamiento']=trim($tmp[1]); break;
				case "odontopediatriainactivacion":    $param['inactivacion']=trim($tmp[1]); break;
				case "odontopediatriainafecha":    $param['inafecha']=trim($tmp[1]); break;
				case "odontopediatriainainicio":    $param['inainicio']=trim($tmp[1]); break;
				case "odontopediatriainafin":    $param['inafin']=trim($tmp[1]); break;
				case "odontopediatriainapieza":    $param['inapieza']=trim($tmp[1]); break;
				case "odontopediatriainadiagnostico":    $param['inadiagnostico']=trim($tmp[1]); break;
				case "odontopediatriainatratamiento":    $param['inatratamiento']=trim($tmp[1]); break;
				case "odontopediatriaquimico":    $param['quimico']=trim($tmp[1]); break;
				case "odontopediatriaquifecha":    $param['quifecha']=trim($tmp[1]); break;
				case "odontopediatriaquiinicio":    $param['quiinicio']=trim($tmp[1]); break;
				case "odontopediatriaquifin":    $param['quifin']=trim($tmp[1]); break;
				case "odontopediatriaquipieza":    $param['quipieza']=trim($tmp[1]); break;
				case "odontopediatriaquidiagnostico":    $param['quidiagnostico']=trim($tmp[1]); break;
				case "odontopediatriaquitratamiento":    $param['quitratamiento']=trim($tmp[1]); break;
				case "odontopediatriamorfologico":    $param['morfologico']=trim($tmp[1]); break;
				case "odontopediatriamorfecha":    $param['morfecha']=trim($tmp[1]); break;
				case "odontopediatriamorinicio":    $param['morinicio']=trim($tmp[1]); break;
				case "odontopediatriamorfin":    $param['morfin']=trim($tmp[1]); break;
				case "odontopediatriamorpieza":    $param['morpieza']=trim($tmp[1]); break;
				case "odontopediatriamordiagnostico":    $param['mordiagnostico']=trim($tmp[1]); break;
				case "odontopediatriamortratamiento":    $param['mortratamiento']=trim($tmp[1]); break;
				case "odontopediatriaestructural":    $param['estructural']=trim($tmp[1]); break;
				case "odontopediatriaestfecha":    $param['estfecha']=trim($tmp[1]); break;
				case "odontopediatriaestinicio":    $param['estinicio']=trim($tmp[1]); break;
				case "odontopediatriaestfin":    $param['estfin']=trim($tmp[1]); break;
				case "odontopediatriaestpieza":    $param['estpieza']=trim($tmp[1]); break;
				case "odontopediatriaestdiagnostico":    $param['estdiagnostico']=trim($tmp[1]); break;
				case "odontopediatriaesttratamiento":    $param['esttratamiento']=trim($tmp[1]); break;
				case "odontopediatriacirugia":    $param['cirugia']=trim($tmp[1]); break;
				case "odontopediatriacirfecha":    $param['cirfecha']=trim($tmp[1]); break;
				case "odontopediatriacirinicio":    $param['cirinicio']=trim($tmp[1]); break;
				case "odontopediatriacirfin":    $param['cirfin']=trim($tmp[1]); break;
				case "odontopediatriacirpieza":    $param['cirpieza']=trim($tmp[1]); break;
				case "odontopediatriacirdiagnostico":    $param['cirdiagnostico']=trim($tmp[1]); break;
				case "odontopediatriacirtratamiento":    $param['cirtratamiento']=trim($tmp[1]); break;
				case "odontopediatriapulpar":    $param['pulpar']=trim($tmp[1]); break;
				case "odontopediatriapulfecha":    $param['pulfecha']=trim($tmp[1]); break;
				case "odontopediatriapulinicio":    $param['pulinicio']=trim($tmp[1]); break;
				case "odontopediatriapulfin":    $param['pulfin']=trim($tmp[1]); break;
				case "odontopediatriapulpieza":    $param['pulpieza']=trim($tmp[1]); break;
				case "odontopediatriapuldiagnostico":    $param['puldiagnostico']=trim($tmp[1]); break;
				case "odontopediatriapultratamiento":    $param['pultratamiento']=trim($tmp[1]); break;
				case "odontopediatriarehabilitation":    $param['rehabilitation']=trim($tmp[1]); break;
				case "odontopediatriarehfecha":    $param['rehfecha']=trim($tmp[1]); break;
				case "odontopediatriarehinicio":    $param['rehinicio']=trim($tmp[1]); break;
				case "odontopediatriarehfin":    $param['rehfin']=trim($tmp[1]); break;
				case "odontopediatriarehpieza":    $param['rehpieza']=trim($tmp[1]); break;
				case "odontopediatriarehdiagnostico":    $param['rehdiagnostico']=trim($tmp[1]); break;
				case "odontopediatriarehtratamiento":    $param['rehtratamiento']=trim($tmp[1]); break;
				case "odontopediatriateacher":    $teacher=trim($tmp[1]); break;

        case "odontopediatriaupdatetime":        $tmp[1]=strtotime($tmp[1])+3600*9;
				$param['updatetime']=trim($tmp[1]);break;

      }
      $i++;
      if ($i>=count($ar)) break;
      $x = trim($ar[$i]);
    }
    if($param['remissionid'] != ""){
			//sacamos los datos por remission true
			$info=DBPediatricsiInfo(htmlspecialchars(trim($param["remissionid"])), true);
	    if($info==null){
	      echo "No Registrado";
	      exit;
	    }

			$param['patientid'] = $info['patientid'];
			$param['student'] = $info['student'];
	    $param['teacher'] = $info['teacher'];
	    $param['clinical'] = $info['clinicalid'];
	    $param['remissionid'] = $info['remissionid'];
	    $param['file'] = $info['pediatricsiid'];//id of clinical

			$inforemission=DBPatientRemissionInfo($info['remissionid']);
	    $param['patientadmissionid']=$inforemission['patientadmissionid'];
			DBUpdatePatientPediatrics($param);//funcion para asignar datos de fecha de nacimiento y lugar de nacimiento.

			$param['updatetime']=$param['updatetime']+3600*5;
			$param['startdatetime']=$param['updatetime'];
			$param['enddatetime']=$param['updatetime']+3600*5;

			$param['plantxt'] = htmlspecialchars(trim($plantxt));

			$ret=DBNewPediatricsi($param);

	    if($ret==2){
				$param['observationevaluated']='t';
				$param['observationaccepted']='t';

	      DBNewObservation($param);
	      echo "yes Insertado";
				echo "\n";
				$ret=DBDesignedTeacher($teacher, $param['file'], $param["clinical"],$param['startdatetime']);
				echo "\n $ret asignado docente\n";
				$param['teacher']=$teacher;
				DBUpdateOleary($param);
				echo "olary";
				DBUpdatePlan($param);//para actualizar plan de tratamiento
				echo "\n";
				echo "yes insertado plan\n";
				//insercion a pediatricsicontroltable

				$urgid=explode('.:.',trim($param['urgencias']));
			  $urgfecha=explode(',',trim($param['urgfecha']));
			  $urginicio=explode(',',trim($param['urginicio']));
			  $urgfin=explode(',',trim($param['urgfin']));
			  $urgpieza=explode('.:.',trim($param['urgpieza']));
			  $urgdiagnostico=explode('.:.',trim($param['urgdiagnostico']));
			  $urgtratamiento=explode('.:.',trim($param['urgtratamiento']));
			  $size=count($urgid);
			  $len=$size;
			  $urg=DBAllPediatricsiControlInfo($param['file'], 'urgency');
				if($urg==null){
			    for ($j=0; $j < $size-1; $j++) {
			      if($urgid[$j]==''){
			        $param['id']=-1;
			      }else{
			        $param['id']=$urgid[$j];
			      }
			      $param['date']=$urgfecha[$j];
			      $param['part']=$urgpieza[$j];
			      $param['diagnosis']=$urgdiagnostico[$j];
			      $param['treatment']=$urgtratamiento[$j];
			      $param['start']=$urginicio[$j];
			      $param['end']=$urgfin[$j];
			      $param['type']='urgency';

			      DBNewPediatricsiControl($param);
			    }
			  }else{
					echo "Ya esta registrado a tabla de urgencia";
				}

				//inactivacion
				$urgid=explode('.:.',trim($param['inactivacion']));
			  $urgfecha=explode(',',trim($param['inafecha']));
			  $urginicio=explode(',',trim($param['inainicio']));
			  $urgfin=explode(',',trim($param['inafin']));
			  $urgpieza=explode('.:.',trim($param['inapieza']));
			  $urgdiagnostico=explode('.:.',trim($param['inadiagnostico']));
			  $urgtratamiento=explode('.:.',trim($param['inatratamiento']));
			  $size=count($urgid);
			  $len=$size;
			  $urg=DBAllPediatricsiControlInfo($param['file'], 'inactivation');
				if($urg==null){
			    for ($j=0; $j < $size-1; $j++) {
			      if($urgid[$j]==''){
			        $param['id']=-1;
			      }else{
			        $param['id']=$urgid[$j];
			      }
			      $param['date']=$urgfecha[$j];
			      $param['part']=$urgpieza[$j];
			      $param['diagnosis']=$urgdiagnostico[$j];
			      $param['treatment']=$urgtratamiento[$j];
			      $param['start']=$urginicio[$j];
			      $param['end']=$urgfin[$j];
			      $param['type']='inactivation';

			      DBNewPediatricsiControl($param);
			    }
			  }else{
					echo "Ya esta registrado a tabla de inactivacion";
				}

				//Quimico mecanico del bio fil
				$urgid=explode('.:.',trim($param['quimico']));
				$urgfecha=explode(',',trim($param['quifecha']));
				$urginicio=explode(',',trim($param['quiinicio']));
				$urgfin=explode(',',trim($param['quifin']));
				$urgpieza=explode('.:.',trim($param['quipieza']));
				$urgdiagnostico=explode('.:.',trim($param['quidiagnostico']));
				$urgtratamiento=explode('.:.',trim($param['quitratamiento']));
				$size=count($urgid);
				$len=$size;
				$urg=DBAllPediatricsiControlInfo($param['file'], 'quimic');
				if($urg==null){
					for ($j=0; $j < $size-1; $j++) {
						if($urgid[$j]==''){
							$param['id']=-1;
						}else{
							$param['id']=$urgid[$j];
						}
						$param['date']=$urgfecha[$j];
						$param['part']=$urgpieza[$j];
						$param['diagnosis']=$urgdiagnostico[$j];
						$param['treatment']=$urgtratamiento[$j];
						$param['start']=$urginicio[$j];
						$param['end']=$urgfin[$j];
						$param['type']='quimic';

						DBNewPediatricsiControl($param);
					}
				}else{
					echo "Ya esta registrado a tabla de quimico";
				}


				//Refuerzo morfologico
				$urgid=explode('.:.',trim($param['morfologico']));
				$urgfecha=explode(',',trim($param['morfecha']));
				$urginicio=explode(',',trim($param['morinicio']));
				$urgfin=explode(',',trim($param['morfin']));
				$urgpieza=explode('.:.',trim($param['morpieza']));
				$urgdiagnostico=explode('.:.',trim($param['mordiagnostico']));
				$urgtratamiento=explode('.:.',trim($param['mortratamiento']));
				$size=count($urgid);
				$len=$size;
				$urg=DBAllPediatricsiControlInfo($param['file'], 'morfologic');
				if($urg==null){
					for ($j=0; $j < $size-1; $j++) {
						if($urgid[$j]==''){
							$param['id']=-1;
						}else{
							$param['id']=$urgid[$j];
						}
						$param['date']=$urgfecha[$j];
						$param['part']=$urgpieza[$j];
						$param['diagnosis']=$urgdiagnostico[$j];
						$param['treatment']=$urgtratamiento[$j];
						$param['start']=$urginicio[$j];
						$param['end']=$urgfin[$j];
						$param['type']='morfologic';

						DBNewPediatricsiControl($param);
					}
				}else{
					echo "Ya esta registrado a tabla de morfologico";
				}

				//Refuerzo estructural
				$urgid=explode('.:.',trim($param['estructural']));
				$urgfecha=explode(',',trim($param['estfecha']));
				$urginicio=explode(',',trim($param['estinicio']));
				$urgfin=explode(',',trim($param['estfin']));
				$urgpieza=explode('.:.',trim($param['estpieza']));
				$urgdiagnostico=explode('.:.',trim($param['estdiagnostico']));
				$urgtratamiento=explode('.:.',trim($param['esttratamiento']));
				$size=count($urgid);
				$len=$size;
				$urg=DBAllPediatricsiControlInfo($param['file'], 'estruct');
				if($urg==null){
					for ($j=0; $j < $size-1; $j++) {
						if($urgid[$j]==''){
							$param['id']=-1;
						}else{
							$param['id']=$urgid[$j];
						}
						$param['date']=$urgfecha[$j];
						$param['part']=$urgpieza[$j];
						$param['diagnosis']=$urgdiagnostico[$j];
						$param['treatment']=$urgtratamiento[$j];
						$param['start']=$urginicio[$j];
						$param['end']=$urgfin[$j];
						$param['type']='estruct';

						DBNewPediatricsiControl($param);
					}
				}else{
					echo "Ya esta registrado a tabla de estructural";
				}

				//cirugia
				$urgid=explode('.:.',trim($param['cirugia']));
				$urgfecha=explode(',',trim($param['cirfecha']));
				$urginicio=explode(',',trim($param['cirinicio']));
				$urgfin=explode(',',trim($param['cirfin']));
				$urgpieza=explode('.:.',trim($param['cirpieza']));
				$urgdiagnostico=explode('.:.',trim($param['cirdiagnostico']));
				$urgtratamiento=explode('.:.',trim($param['cirtratamiento']));
				$size=count($urgid);
				$len=$size;
				$urg=DBAllPediatricsiControlInfo($param['file'], 'surgery');
				if($urg==null){
					for ($j=0; $j < $size-1; $j++) {
						if($urgid[$j]==''){
							$param['id']=-1;
						}else{
							$param['id']=$urgid[$j];
						}
						$param['date']=$urgfecha[$j];
						$param['part']=$urgpieza[$j];
						$param['diagnosis']=$urgdiagnostico[$j];
						$param['treatment']=$urgtratamiento[$j];
						$param['start']=$urginicio[$j];
						$param['end']=$urgfin[$j];
						$param['type']='surgery';

						DBNewPediatricsiControl($param);
					}
				}else{
					echo "Ya esta registrado a tabla de cirugia";
				}

				//tratamiento pulpar
				$urgid=explode('.:.',trim($param['pulpar']));
				$urgfecha=explode(',',trim($param['pulfecha']));
				$urginicio=explode(']',trim($param['pulinicio']));
				$urgfin=explode(',',trim($param['pulfin']));
				$urgpieza=explode('.:.',trim($param['pulpieza']));
				$urgdiagnostico=explode('.:.',trim($param['puldiagnostico']));
				$urgtratamiento=explode('.:.',trim($param['pultratamiento']));
				$size=count($urgid);
				$len=$size;
				$urg=DBAllPediatricsiControlInfo($param['file'], 'pulpar');
				if($urg==null){
					for ($j=0; $j < $size-1; $j++) {
						if($urgid[$j]==''){
							$param['id']=-1;
						}else{
							$param['id']=$urgid[$j];
						}
						$param['date']=$urgfecha[$j];
						$param['part']=$urgpieza[$j];
						$param['diagnosis']=$urgdiagnostico[$j];
						$param['treatment']=$urgtratamiento[$j];
						$param['start']=$urginicio[$j];
						$param['end']=$urgfin[$j];
						$param['type']='pulpar';

						DBNewPediatricsiControl($param);
					}
				}else{
					echo "Ya esta registrado a tabla de pulpar";
				}

				//Rehabilitacion
				$urgid=explode('.:.',trim($param['rehabilitation']));
				$urgfecha=explode(',',trim($param['rehfecha']));
				$urginicio=explode(']',trim($param['rehinicio']));
				$urgfin=explode(',',trim($param['rehfin']));
				$urgpieza=explode('.:.',trim($param['rehpieza']));
				$urgdiagnostico=explode('.:.',trim($param['rehdiagnostico']));
				$urgtratamiento=explode('.:.',trim($param['rehtratamiento']));
				$size=count($urgid);
				$len=$size;
				$urg=DBAllPediatricsiControlInfo($param['file'], 'rehabilitation');
				if($urg==null){
					for ($j=0; $j < $size-1; $j++) {
						if($urgid[$j]==''){
							$param['id']=-1;
						}else{
							$param['id']=$urgid[$j];
						}
						$param['date']=$urgfecha[$j];
						$param['part']=$urgpieza[$j];
						$param['diagnosis']=$urgdiagnostico[$j];
						$param['treatment']=$urgtratamiento[$j];
						$param['start']=$urginicio[$j];
						$param['end']=$urgfin[$j];
						$param['type']='rehabilitation';

						DBNewPediatricsiControl($param);
					}
				}else{
					echo "Ya esta registrado a tabla de rehabilitacion";
				}
				echo "\nSe registro todos los datos\n";
			}
		}else{
			echo "No se gurdaron los datos, el tiempo actual debe ser mayor al tiempo de registro";
		}
	}
}

?>
