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

$url='../../doc/surgery.txt';
$temp=myhtmlspecialchars($url);

if (($ar = file($temp)) === false) {
    echo "No se puede abrir el archivo cargado.";
    exit;
}

for ($i=0; $i < count($ar) && strpos($ar[$i], "[cirugia]") === false; $i++) ;
if($i >= count($ar)) echo 'Formato de archivo no reconocido';
$conf=globalconf();
for ($i++; $i < count($ar) && $ar[$i][0] != "["; $i++) {

  $x = trim($ar[$i]);
  if (strpos($x, "cirugia") !== false && strpos($x, "cirugia") == 0) {
    $param = array();
		$teacher=0;
    while (strpos($x, "cirugia") !== false && strpos($x, "cirugia") == 0) {
      $tmp = explode ("=", $x, 2);
			$param['updatetime']='';
      switch (trim($tmp[0])) {
        case "cirugiaremissionid":    $param['remissionid']=trim($tmp[1]); break;

        case "cirugiafaces":    $param['faces']=trim($tmp[1]); break;
        case "cirugiaprofile":    $param['profile']=trim($tmp[1]); break;
        case "cirugiascars":    $param['scars']=trim($tmp[1]); break;
        case "cirugiaatm":    $param['atm']=trim($tmp[1]); break;
        case "cirugiaganglia":    $param['ganglia']=trim($tmp[1]); break;
        case "cirugialips":    $param['lips']=trim($tmp[1]); break;
        case "cirugiaulcerations":    $param['ulcerations']=trim($tmp[1]); break;
        case "cirugiacheilitis":    $param['cheilitis']=trim($tmp[1]); break;
        case "cirugiacommissures":    $param['commissures']=trim($tmp[1]); break;
        case "cirugiatongue":    $param['tongue']=trim($tmp[1]); break;
        case "cirugiapiso":    $param['piso']=trim($tmp[1]); break;
        case "cirugiaencias":    $param['encias']=trim($tmp[1]); break;
        case "cirugiamucosa":    $param['mucosa']=trim($tmp[1]); break;
        case "cirugiaocclusion":    $param['occlusion']=trim($tmp[1]); break;
        case "cirugiaprosthesis":    $param['prosthesis']=trim($tmp[1]); break;
        case "cirugiahygiene":    $param['hygiene']=trim($tmp[1]); break;
        case "cirugialastconsultation":    $param['lastconsultation']=trim($tmp[1]); break;
        case "cirugiaconsultation":    $param['consultation']=trim($tmp[1]); break;
        case "cirugiageneralstatus":    $param['generalstatus']=trim($tmp[1]); break;
        case "cirugiaexam":    $param['exam']=trim($tmp[1]); break;
        case "cirugiadiagnosis":    $param['diagnosis']=trim($tmp[1]); break;
        case "cirugiatreatment":    $param['treatment']=trim($tmp[1]); break;
        case "cirugiaprescriptions":    $param['prescriptions']=trim($tmp[1]); break;
        case "cirugiaindications":    $param['indications']=trim($tmp[1]); break;
        case "cirugiaevolution":    $param['evolution']=trim($tmp[1]); break;

        case "cirugiastatus":    $param['status']=trim($tmp[1]); break;
				case "cirugiateacher":    $teacher=trim($tmp[1]); break;
        case "cirugiaupdatetime":
					if(trim($tmp[1])!=''){
						$tmp[1]=strtotime($tmp[1])+3600*9;
						$param['updatetime']=trim($tmp[1]);
					}
				break;

      }
      $i++;
      if ($i>=count($ar)) break;
      $x = trim($ar[$i]);
    }
    if($param['remissionid'] != ""){
			//sacamos los datos por remission true
			$info=DBSurgeryiiInfo(htmlspecialchars(trim($param["remissionid"])), true);
	    if($info==null){
	      echo "No Registrado";
	      exit;
	    }
			$param['mod']='update';

			$param['patientid'] = $info['patientid'];
			$param['student'] = $info['student'];
	    $param['teacher'] = $info['teacher'];
	    $param['clinical'] = $info['clinicalid'];
	    $param['remissionid'] = $info['remissionid'];
	    $param['file'] = $info['surgeryiiid'];//id of clinical
			$inforemission=DBPatientRemissionInfo($info['remissionid']);
	    $param['dentalid']=$inforemission['patientdentalid'];
			if($param['lastconsultation']==''){
				$param['lastconsultation']=$inforemission['lastconsult'];
			}
			if($param['consultation']==''){
				$param['consultation']=$inforemission['motconsult'];
			}
			if($param['diagnosis']==''){
				$param['diagnosis']=$inforemission['diagnostico'];
			}
			$ret=DBNewDentalExam($param);
			echo "\n $ret dentaltable\n";
			if($param['updatetime']==''){
				$param['updatetime']=$inforemission['updatetime'];
			}
			$param['updatetime']=$param['updatetime']+3600*5;
			$param['startdatetime']=$param['updatetime'];
			$param['enddatetime']=$param['updatetime']+3600*5;

			$ret=DBNewSurgeryii($param);

	    if($ret==2){
				$param['observationevaluated']='t';
				$param['observationaccepted']='t';

	      DBNewObservation($param);
	      echo "yes Insertado";
				echo "\n";
				$ret=DBDesignedTeacher($teacher, $param['file'], $param["clinical"],$param['startdatetime']);
				echo "\n $ret asignado docente\n";

				echo "\nSe registro todos los datos\n";
			}
		}else{
			echo "No se gurdaron los datos, el tiempo actual debe ser mayor al tiempo de registro";
		}
	}
}

?>
