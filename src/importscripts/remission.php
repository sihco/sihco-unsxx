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

$url='../../doc/remission.txt';
$temp=myhtmlspecialchars($url);

if (($ar = file($temp)) === false) {
    echo "No se puede abrir el archivo cargado.";
    exit;
}

for ($i=0; $i < count($ar) && strpos($ar[$i], "[remission]") === false; $i++) ;
if($i >= count($ar)) echo 'Formato de archivo no reconocido';
$conf=globalconf();
for ($i++; $i < count($ar) && $ar[$i][0] != "["; $i++) {

  $x = trim($ar[$i]);
  if (strpos($x, "remission") !== false && strpos($x, "remission") == 0) {
    $param = array();
    $param['mod']='new';//cambio de password
    $param['patientid']='';//id de remission podemos dejar en vacio para new//DBUserNumberMax();//maximo id de usuario
    while (strpos($x, "remission") !== false && strpos($x, "remission") == 0) {
      $tmp = explode ("=", $x, 2);
      switch (trim($tmp[0])) {
        case "remissionpatientfullname":    $param['patientfullname']=trim($tmp[1]); break;
        case "remissionpatientdirection":    $param['patientdirection']=trim($tmp[1]); break;
        case "remissionpatientlocation":    $param['patientlocation']=trim($tmp[1]); break;
        case "remissionpatientage":    $param['patientage']=trim($tmp[1]); break;
        case "remissionpatientprovenance":    $param['patientprovenance']=trim($tmp[1]); break;
        case "remissionpatientphone":    $param['patientphone']=trim($tmp[1]); break;
        case "remissionpatientgender":    $param['patientgender']=trim($tmp[1]); break;
        case "remissionpatientcivilstatus":    $param['patientcivilstatus']=trim($tmp[1]); break;
        case "remissionpatientoccupation":    $param['patientoccupation']=trim($tmp[1]); break;
        case "remissionpatientnationality":    $param['patientnationality']=trim($tmp[1]); break;
        case "remissionpatientschool":    $param['patientschool']=trim($tmp[1]); break;
        case "remissionpatientattorney":    $param['patientattorney']=trim($tmp[1]); break;
        case "remissiontemperature":    $param['temperature']=trim($tmp[1]); break;
        case "remissionheadache":    $param['headache']=trim($tmp[1]); break;
        case "remissionrespiratory":    $param['respiratory']=trim($tmp[1]); break;
        case "remissionthroat":    $param['throat']=trim($tmp[1]); break;
        case "remissiongeneral":    $param['general']=trim($tmp[1]); break;
        case "remissionvaccine":    $param['vaccine']=trim($tmp[1]); break;
        case "remissiontongue":    $param['tongue']=trim($tmp[1]); break;
        case "remissionpiso":    $param['piso']=trim($tmp[1]); break;
        case "remissionencias":    $param['encias']=trim($tmp[1]); break;
        case "remissionmucosa":    $param['mucosa']=trim($tmp[1]); break;
        case "remissionocclusion":    $param['occlusion']=trim($tmp[1]); break;
        case "remissionprosthesis":    $param['prosthesis']=trim($tmp[1]); break;
        case "remissionhygiene":    $param['hygiene']=trim($tmp[1]); break;
        case "remissionlastconsultation":    $param['lastconsultation']=trim($tmp[1]); break;
        case "remissionconsultation":    $param['consultation']=trim($tmp[1]); break;
        case "remissiondiagnostico":    $param['diagnostico']=trim($tmp[1]); break;
        case "remissionclinical":    $param['clinical']=trim($tmp[1]); break;
        case "remissionexamined":    $param['examined']=trim($tmp[1]); break;
        case "remissionexaminedid":    $param['examinedid']=trim($tmp[1]); break;
        case "remissionadmission":    $param['admission']=trim($tmp[1]); break;
        case "remissionodontodraw":    $param['odontodraw']=encryptData(trim($tmp[1]), $conf["key"], false); break;
        case "remissionodontogramdesc":    $param['odontogramdesc']=trim($tmp[1]); break;
        case "remissionpatientgmh":    $param['patientgmh']=trim($tmp[1]); break;
        case "remissionpatientpa":    $param['patientpa']=trim($tmp[1]); break;

        case "remissionupdatetime":        $tmp[1]=strtotime($tmp[1])+3600*9;
				$param['updatetime']=trim($tmp[1]);break;

      }
      $i++;
      if ($i>=count($ar)) break;
      $x = trim($ar[$i]);
    }
    if($param['examinedid'] != 0){
			$usri=DBUserInfo($param['examinedid']);
			$auinfo=DBUserDesignedInfoFullname($usri['userfullname'],$param["clinical"]);
			if($auinfo==null){
				echo "estudiante no encontrado";
				exit;
			}
			$param["examined"]=$usri['usernumber'];
			$param['patientdirection']=$param['patientlocation'];
      $ufl=DBPatientSearchInfo($param['patientfullname'],false);

      $nufl=count($ufl);
    	echo "idpatient\t fullname\n";
    	for ($ii=0;$ii<$nufl;$ii++) {
    		echo $ufl[$ii]["id"]."\t".$ufl[$ii]["fullname"]."\n";
    	}

      echo "\n******Para Insertar(0) Actualizar(1) Terminar(2)*******=";
      $resp = strtoupper(trim(fgets(STDIN)));

      if($resp==0){
        $param['mod']='new';
      }elseif($resp==1){
        echo "Modo Actualizar\n";
				if($ii>0){
					echo "\n******Introduzca el id del registro para actualizar*******=";
					$param['patientid']=strtoupper(trim(fgets(STDIN)));
				}
	      $param["mod"] = 'update';
      }else{
				exit;
			}
			echo DBNewRemissionPatient($param,true);
			echo "\n";

    }

  }
}

?>
