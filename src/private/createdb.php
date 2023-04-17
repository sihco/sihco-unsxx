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
echo "\nThis will erase all the data in your sihcodb database.";
echo "\n***** YOU WILL LOSE WHATEVER YOU HAVE THERE!!! *****";
echo "\nType YES and press return to continue or anything else will abort it: ";
$resp = strtoupper(trim(fgets(STDIN)));
if($resp != 'YES') exit;



echo "\ndropping database\n";
DBDropDatabase();
echo "creating database\n";
DBCreateDatabase();

echo "creating tables\n";


DBCreateUserTable();
DBCreateLogTable();

DBCreateClinicalTable();
DBCreateSpecialtyTable();
DBCreatePatientTable();
DBCreatePatientAdmissionTable();
DBCreateRemissionTable();
DBCreateClinichistoryTable();

DBCreateSurgeryiiTable();
/*DBCreateObservationTable();
DBCreatePeriodonticsiiTable();
DBCreateSessionPeriodonticsiiTable();

DBCreatePediatricsiTable();
DBCreatePediatricsiControlTable();*/

/*
DBCreatePediatricsiUrgencyTable();
DBCreatePediatricsiInactivationTable();
DBCreatePediatricsiControlqmTable();
DBCreatePediatricsiMorphologicalTable();
DBCreatePediatricsiStructuralTable();
DBCreatePediatricsiPulpTable();
DBCreatePediatricsiSurgeryTable();
DBCreatePediatricsiRehabilitationTable();
*/

/*
DBCreateOrthodonticsTable();
DBCreateRemovableTable();
DBCreateFixedTable();
DBCreateOperativeTable();
DBCreateEndodonticsTable();
DBCreateSurgeryTokenTable();*/

echo "creating initial fake admin\n";
DBFakeUser();
?>
