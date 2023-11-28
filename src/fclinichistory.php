<?php
//funcion para eliminar la tabla de historia clinica
function DBDropClinichistoryTable() {
    //conexcion de la base de datos..
	 $c = DBConnect();

	 $r = DBExec($c, "drop table \"clinichistorytable\"", "DBDropClinichistoryTable(drop table)");

}
function DBCreateClinichistoryTable() {
	 $c = DBConnect();
	 $conf = globalconf();
	 if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
	 $r = DBExec($c, "
CREATE TABLE \"clinichistorytable\" (
        \"remissionid\" int4 NOT NULL,          -- (id del registro remision)
        \"patientadmissionid\" int4 NOT NULL,		-- (admission patient id)
        \"patientid\" int4 NOT NULL,						-- (patient id)
        \"clinicalid\" int4 NOT NULL, 					-- (clinica remitida)

				\"status\" varchar(50) DEFAULT '',       -- (estado new, process, end, fail, error)
				\"inputfilename\" varchar(100) DEFAULT '',     -- (nombre del archivo)
				\"inputfile\" oid,															-- (el archivo conclido)
				\"inputfilehash\" varchar(50),               --(apuntador para archivo)
				\"authorized\" bool DEFAULT 'f' NOT NULL,							 	--(autorizado o no)
        \"studentid\" int4 NOT NULL, 														-- (id del estudiante)
        \"studentclinicalid\" int4 NOT NULL, 										-- (clinical del estudiante)
        \"studentcourseid\" int4 NOT NULL, 											-- (course del estudiante)

        \"teacherid\" int4 NOT NULL, 														-- (id del teacher)
        \"teacherclinicalid\" int4 NOT NULL, 										-- (clinical del teacher)
        \"teachercourseid\" int4 NOT NULL, 											-- (course del teacher)
				\"reviewteacher\"	text DEFAULT '',											-- (ID cola de docentes revisores)
				\"reviewany\"	bool DEFAULT 'f' NOT NULL,							 	--(revisar cualquiera)
				\"reviewstatus\"	bool DEFAULT 'f' NOT NULL,						--(estado de revisado)
			  \"stdatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la fecha de inicio de ficha clinica)
			  \"endatetime\" int4 DEFAULT -1 NOT NULL, -- (indica la fecha de finalizacion)
			  \"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
        CONSTRAINT \"pediatricsi_pkey\" PRIMARY KEY (\"remissionid\"),

        CONSTRAINT \"specialty_fk\" FOREIGN KEY (\"studentid\", \"studentclinicalid\", \"studentcourseid\")
               REFERENCES \"specialtytable\" (\"userid\", \"clinicalid\", \"coursenumber\")
               ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
        CONSTRAINT \"specialty2_fk\" FOREIGN KEY (\"teacherid\", \"teacherclinicalid\", \"teachercourseid\")
               REFERENCES \"specialtytable\" (\"userid\", \"clinicalid\", \"coursenumber\")
               ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,

        CONSTRAINT \"remission_fk\" FOREIGN KEY (\"remissionid\", \"patientadmissionid\", \"patientid\", \"clinicalid\")
								REFERENCES \"remissiontable\" (\"remissionid\", \"patientadmissionid\", \"patientid\", \"clinicalid\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
)", "DBCreateClinichistoryTable(create table)");

	$r = DBExec($c, "REVOKE ALL ON \"clinichistorytable\" FROM PUBLIC", "DBCreateClinichistoryTable(revoke public)");
	$r = DBExec($c, "GRANT ALL ON \"clinichistorytable\" TO \"".$conf["dbuser"]."\"", "DBCreateClinichistoryTable(grant sihcouser)");
	$r = DBExec($c, "CREATE INDEX \"clinichistory_index\" ON \"clinichistorytable\" USING btree ".
				"(\"remissionid\" int4_ops, \"patientid\" int4_ops, \"studentid\" int4_ops)",
				"DBCreateClinichistoryTable(create clinichistory_index)");
}
//funcion para eliminar la tabla de historia de la remision
function DBDropRemissionhistoryTable() {
   //conexcion de la base de datos..
	 $c = DBConnect();
	 $r = DBExec($c, "drop table \"remissionhistorytable\"", "DBDropRemissionhistoryTable(drop table)");
}
function DBCreateRemissionhistoryTable() {
	 $c = DBConnect();
	 $conf = globalconf();
	 if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
	 $r = DBExec($c, "
	 CREATE TABLE \"remissionhistorytable\" (
        \"remissionid\" int4 NOT NULL,          -- (id del registro remision)
        \"patientadmissionid\" int4 NOT NULL,		-- (admission patient id)
        \"patientid\" int4 NOT NULL,						-- (patient id)
        \"clinicalid\" int4 NOT NULL, 					-- (clinica remitida)

				\"status\" varchar(50) DEFAULT '',       -- (estado new, process, end, fail, error)
				\"inputfilename\" varchar(100) DEFAULT '',     -- (nombre del archivo)
				\"inputfile\" oid,															-- (el archivo conclido)
				\"inputfilehash\" varchar(50),               --(apuntador para archivo)
				\"authorized\" bool DEFAULT 'f' NOT NULL,							 	--(autorizado o no)
        \"studentid\" int4, 														-- (id del estudiante)
        \"studentclinicalid\" int4, 										-- (clinical del estudiante)
        \"studentcourseid\" int4, 											-- (course del estudiante)

        \"teacherid\" int4, 														-- (id del teacher)
        \"teacherclinicalid\" int4, 										-- (clinical del teacher)
        \"teachercourseid\" int4, 											-- (course del teacher)
				\"reviewteacher\"	text DEFAULT '',											-- (ID cola de docentes revisores)
				\"reviewany\"	bool DEFAULT 'f' NOT NULL,							 	--(revisar cualquiera)
				\"reviewstatus\"	bool DEFAULT 'f' NOT NULL,						--(estado de revisado)
			  \"stdatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la fecha de inicio de ficha clinica)
			  \"endatetime\" int4 DEFAULT -1 NOT NULL, -- (indica la fecha de finalizacion)
			  \"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
        CONSTRAINT \"remissionhistory_pkey\" PRIMARY KEY (\"remissionid\"),

        CONSTRAINT \"specialty_fk\" FOREIGN KEY (\"studentid\", \"studentclinicalid\", \"studentcourseid\")
               REFERENCES \"specialtytable\" (\"userid\", \"clinicalid\", \"coursenumber\")
               ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
        CONSTRAINT \"specialty2_fk\" FOREIGN KEY (\"teacherid\", \"teacherclinicalid\", \"teachercourseid\")
               REFERENCES \"specialtytable\" (\"userid\", \"clinicalid\", \"coursenumber\")
               ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
				CONSTRAINT \"clinical_fk\" FOREIGN KEY (\"clinicalid\")
								REFERENCES \"clinicaltable\" (\"clinicalid\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,

				CONSTRAINT \"patientadmission_fk\" FOREIGN KEY (\"patientadmissionid\", \"patientid\")
								REFERENCES \"patientadmissiontable\" (\"patientadmissionid\", \"patientid\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
)", "DBCreateRemissionhistoryTable(create table)");

	$r = DBExec($c, "REVOKE ALL ON \"remissionhistorytable\" FROM PUBLIC", "DBCreateRemissionhistoryTable(revoke public)");
	$r = DBExec($c, "GRANT ALL ON \"remissionhistorytable\" TO \"".$conf["dbuser"]."\"", "DBCreateRemissionhistoryTable(grant sihcouser)");
	$r = DBExec($c, "CREATE INDEX \"remissionhistory_index\" ON \"remissionhistorytable\" USING btree ".
				"(\"remissionid\" int4_ops)", "DBCreateRemissionhistoryTable(create remissionhistory_index)");
	$r = DBExec($c, "CREATE INDEX \"remissionhistory_indexpatientadmission\" ON \"remissionhistorytable\" USING btree ".
				"(\"patientadmissionid\" int4_ops)", "DBCreateRemissionhistoryTable(create remissionhistory_index)");
	$r = DBExec($c, "CREATE INDEX \"remissionhistory_indexpatient\" ON \"remissionhistorytable\" USING btree ".
				"(\"patientid\" int4_ops)", "DBCreateRemissionhistoryTable(create remissionhistory_index)");
	$r = DBExec($c, "CREATE INDEX \"remissionhistory_indexclinical\" ON \"remissionhistorytable\" USING btree ".
				"(\"clinicalid\" int4_ops)", "DBCreateRemissionhistoryTable(create remissionhistory_index)");
	$r = DBExec($c, "CREATE INDEX \"remissionhistory_indexstudent\" ON \"remissionhistorytable\" USING btree ".
				"(\"studentid\" int4_ops)", "DBCreateRemissionhistoryTable(create remissionhistory_index)");
	$r = DBExec($c, "CREATE INDEX \"remissionhistory_indexteacher\" ON \"remissionhistorytable\" USING btree ".
				"(\"teacherid\" int4_ops)", "DBCreateRemissionhistoryTable(create remissionhistory_index)");
}
function DBNewRemissionhistory($param, $c=null){
	if(isset($param['remissionid']) && !isset($param['idre'])) $param['idre']=$param['remissionid'];
	if(isset($param['patientid']) && !isset($param['idp'])) $param['idp']=$param['patientid'];
	if(isset($param['patientadmissionid']) && !isset($param['idpa'])) $param['idpa']=$param['patientadmissionid'];
	if(isset($param['clinicalid']) && !isset($param['clinical'])) $param['clinical']=$param['clinicalid'];


	$ac=array('idp', 'idpa', 'clinical');
	$ac1=array('studentid', 'studentclinicalid',
	'studentcourseid', 'teacherid', 'teacherclinicalid', 'teachercourseid', 'enddatetime', 'updatetime', 'status', 'authorized');

	$teacherid=0;

	$typei['updatetime']=-1;
	$typei['idp']=-1;
	$typei['idpa']=-1;
	$typei['clinical']=-1;
	$typei['studentid']=NULL;
	$typei['studentclinicalid']=NULL;
	$typei['studentcourseid']=NULL;
	$typei['teacherid']=NULL;
	$typei['teacherclinicalid']=NULL;
	$typei['teachercourseid']=NULL;
	$idre=-1;
	if(isset($param["remissionid"])&&is_numeric($param["remissionid"]))
		$idre=$param["remissionid"];
	else
		$idre=DBRemissionhistoryNumberMax($c);

	foreach($ac as $key) {
		if(!isset($param[$key])) {
			MSGError("DBNewRemissionhistory param error: $key not found");
			return false;
		}
		if(isset($typei[$key]) && !is_numeric($param[$key])) {
			MSGError("DBNewRemissionhistory param error: $key is not numeric");
			return false;
		}
		$$key = myhtmlspecialchars($param[$key]);
	}

	$acourse=array(3, 4,4,4,4,4,4,4,4, 5,5,5,5,5,5,5,5);
	if(isset($param['studentclinicalid'])){
				$param['studentcourseid']=$acourse[$param['studentclinicalid']-1];
	}
	if(isset($param['teacherclinicalid'])){
				$param['teachercourseid']=$acourse[$param['teacherclinicalid']-1];
	}

	$status='new';
	$authorized='f';

	$endatetime=-1;
	$updatetime=-1;
	$studentid = NULL;
	$studentclinicalid = NULL;
	$studentcourseid = NULL;
	$teacherid = NULL;
	$teacherclinicalid = NULL;
	$teachercourseid = NULL;
	foreach($ac1 as $key) {
		if(isset($param[$key])) {
			$$key = myhtmlspecialchars($param[$key]);
			if(isset($typei[$key]) && !is_numeric($param[$key])) {
				MSGError("DBNewRemissionhistory param error: $key is not numeric");
				return false;
			}
		}
	}

	$t = time();
	if($updatetime <= 0)
		$updatetime=$t;

	$cw = false;
	if($c == null) {
		$cw = true;
		$c = DBConnect();
		DBExec($c, "begin work", "DBNewRemissionhistory(begin)");
	}

	$sql="select *from remissionhistorytable where remissionid=$idre";
	$a = DBGetRow ($sql, 0, $c);
	$ret=0;
	if($a==null){
		$ret=2;
		$sql="insert into remissionhistorytable (remissionid, patientadmissionid, patientid, clinicalid, ".
		"status, studentid, studentclinicalid, studentcourseid, ".
		"teacherid, teacherclinicalid, teachercourseid) values ($idre, $idpa, $idp, $clinical, '$status'";
		if( $studentid ==	NULL) $sql .= ", NULL, NULL, NULL, NULL, NULL, NULL)";
		else $sql .= ", $studentid, $studentclinicalid, $studentcourseid, $teacherid, $teacherclinicalid, $teachercourseid)";

		DBExec($c, $sql, "DBNewRemissionhistory(insert)");
		LOGLevel ("new remission history $idre",2);

	}else{
		if($updatetime>=$a['updatetime']){
			$ret=2;
			$idre=$a['remissionid'];
			$sql="update remissionhistorytable set status='$status', clinicalid=$clinical";
			if($studentid != NULL){
					$sql.=" , studentid=$studentid, studentcourseid=$studentcourseid, studentclinicalid=$studentclinicalid,
							teacherid=$teacherid, teachercourseid=$teachercourseid, teacherclinicalid=$teacherclinicalid";
			}else{
				$sql.=" , studentid=NULL, studentcourseid=NULL, studentclinicalid=NULL,
						teacherid=NULL, teachercourseid=NULL, teacherclinicalid=NULL";
			}
			$sql.=" , authorized='$authorized' where remissionid=$idre";

			DBExec($c, $sql, "DBNewRemissionhistory(update)");
			LOGLevel ("update remission history $idre",2);
		}
	}

	if($cw) DBExec($c, "commit work");
	return $ret;
}

function DBNewClinichistory($param, $c=null, $authorized=false){
	if(isset($param['remissionid']) && !isset($param['idre'])) $param['idre']=$param['remissionid'];
	if(isset($param['patientid']) && !isset($param['idp'])) $param['idp']=$param['patientid'];
	if(isset($param['patientadmissionid']) && !isset($param['idpa'])) $param['idpa']=$param['patientadmissionid'];
	if(isset($param['clinicalid']) && !isset($param['clinical'])) $param['clinical']=$param['clinicalid'];

	$acourse=array(3, 4,4,4,4,4,4,4,4, 5,5,5,5,5,5,5,5);
	if(isset($param['studentclinicalid'])){
				$param['studentcourseid']=$acourse[$param['studentclinicalid']-1];
	}
	if(isset($param['teacherclinicalid'])){
				$param['teachercourseid']=$acourse[$param['teacherclinicalid']-1];
	}
	$ac=array('idre', 'idp', 'idpa', 'clinical', 'studentid', 'studentclinicalid',
	'studentcourseid', 'teacherid', 'teacherclinicalid', 'teachercourseid');
	$ac1=array('enddatetime', 'updatetime', 'status');

	$teacherid=0;

	$typei['updatetime']=-1;
	$typei['idre']=-1;
	$typei['idp']=-1;
	$typei['idpa']=-1;
	$typei['clinical']=-1;
	$typei['studentid']=-1;
	$typei['studentclinicalid']=-1;
	$typei['studentcourseid']=-1;
	$typei['teacherid']=-1;
	$typei['teacherclinicalid']=-1;
	$typei['teachercourseid']=-1;
	$typei['clinical']=-1;

	foreach($ac as $key) {
		if(!isset($param[$key])) {
			MSGError("DBNewClinichistory param error: $key not found");
			return false;
		}
		if(isset($typei[$key]) && !is_numeric($param[$key])) {
			MSGError("DBNewClinichistory param error: $key is not numeric");
			return false;
		}
		$$key = myhtmlspecialchars($param[$key]);
	}
	$status='new';
	$endatetime=-1;
	$updatetime=-1;

	foreach($ac1 as $key) {
		if(isset($param[$key])) {
			$$key = myhtmlspecialchars($param[$key]);
			if(isset($typei[$key]) && !is_numeric($param[$key])) {
				MSGError("DBNewClinichistory param error: $key is not numeric");
				return false;
			}
		}
	}

	$t = time();
	if($updatetime <= 0)
		$updatetime=$t;

	$cw = false;
	if($c == null) {
		$cw = true;
		$c = DBConnect();
		DBExec($c, "begin work", "DBNewClinichistory(begin)");
	}

	$sql="select *from clinichistorytable where remissionid=$idre";
	$a = DBGetRow ($sql, 0, $c);
	$ret=0;
	if($authorized==true){
		$authorized='t';
	}else{
		$authorized='f';
	}
	if($a==null){
		$ret=2;
		$sql="insert into clinichistorytable (remissionid, patientadmissionid, patientid, clinicalid, ".
		"status, authorized, studentid, studentclinicalid, studentcourseid, ".
		"teacherid, teacherclinicalid, teachercourseid) values ".
		"($idre, $idpa, $idp, $clinical, '$status', '$authorized', $studentid, $studentclinicalid, $studentcourseid, ".
		"$teacherid, $teacherclinicalid, $teachercourseid)";
		DBExec($c, $sql, "DBNewClinichistory(insert)");
		LOGLevel ("new clinic history $idre",2);
	}else{
		if($updatetime>=$a['updatetime']){
			$ret=2;
			$idre=$a['remissionid'];

			$sql="update clinichistorytable set status='$status'";
			if($studentid!=$a['studentid']){
					$sql.=" , studentid=$studentid, studentcourseid=$studentcourseid, studentclinicalid=$studentclinicalid";
			}
			if($teacherid!=$a['teacherid']){
				$sql.=" , teacherid=$teacherid, teachercourseid=$teachercourseid, teacherclinicalid=$teacherclinicalid";
			}
			$sql.=" , authorized='$authorized' where remissionid=$idre";
			DBExec($c, $sql, "DBNewClinichistory(update)");
			LOGLevel ("update clinic history $idre",2);
		}
	}

	if($cw) DBExec($c, "commit work");
	return $ret;
}
//funcion para actualizar revision del docente
function DBUpdateExamClinichistory($param, $c=null){
		if(isset($param['remissionid']) && !isset($param['idre'])) $param['idre']=$param['remissionid'];

		$ac=array('idre');
		$ac1=array('status', 'reviewany', 'reviewteacher', 'reviewstatus');

		$typei['idre']=-1;

		foreach($ac as $key) {
			if(!isset($param[$key])) {
				MSGError("DBUpdateExamClinichistory param error: $key not found");
				return false;
			}
			if(isset($typei[$key]) && !is_numeric($param[$key])) {
				MSGError("DBUpdateExamClinichistory param error: $key is not numeric");
				return false;
			}
			$$key = myhtmlspecialchars($param[$key]);
		}
		$updatetime=-1;
		$status='process';
		$reviewany='f';
		$reviewteacher='';
		$reviewstatus='f';
		foreach($ac1 as $key) {
			if(isset($param[$key])) {
				$$key = myhtmlspecialchars($param[$key]);
				if(isset($typei[$key]) && !is_numeric($param[$key])) {
					MSGError("DBUpdateExamClinichistory param error: $key is not numeric");
					return false;
				}
			}
		}
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBUpdateExamClinichistory(begin)");
		}
		DBExec($c, "lock table remissionhistorytable", "DBUpdateExamClinichistory(lock)");

		$ret=0;
		$t = time();
		if($updatetime <= 0)
			$updatetime=$t;

		$sql="select *from remissionhistorytable where remissionid=$idre";
		$a = DBGetRow ($sql, 0, $c);
		if($a!=null){
			$sql="update remissionhistorytable set status='$status'";
			if($reviewany!='f')
					$sql.=" , reviewany='$reviewany'";
			if($reviewteacher!='f')
					$sql.=" , reviewteacher='$reviewteacher'";
			if($reviewstatus!='f')
					$sql.=" , reviewstatus='$reviewstatus'";
			if($status=='end')
					$sql.=" , endatetime=$updatetime";
			$sql.=" , updatetime=$updatetime where remissionid=$idre";

			DBExec($c, $sql, "DBUpdateExamClinichistory(update)");
			LOGLevel ("update clinic history $idre",2);
		}else{
			MSGError("update clinic history not found $idre");
			LOGLevel ("update clinic history not found $idre",2);
		}
		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}
function DBUpdateReviewStatus($remission, $reviewstatus, $c=null){

		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBUpdateReviewStatus(begin)");
		}
		DBExec($c, "lock table remissionhistorytable", "DBUpdateReviewStatus(lock)");
		$ret=0;
		$t = time();
		$updatetime=-1;
		if($updatetime <= 0)
			$updatetime=$t;
		$sql="select *from remissionhistorytable where remissionid=$remission";
		$a = DBGetRow ($sql, 0, $c);
		if($a!=null){
			$sql="update remissionhistorytable set ";
			if($reviewstatus==false) $sql.="reviewstatus='f', ";
			if($reviewstatus==true) $sql.="reviewstatus='t', ";
			$sql.="updatetime=$updatetime where remissionid=$remission";
			DBExec($c, $sql, "DBUpdateReviewStatus(update)");
			LOGLevel ("update remission history $remission",2);
		}else{
			MSGError("update remission history not found $remission");
			LOGLevel ("update remission history not found $remission",2);
		}
		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}
//retorna la informacion de la tabla remissionhistorytable por id
function DBRemissionHistoryInfo2($id, $c=null){
	$sql = "select *from remissionhistorytable where remissionid=$id";
	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");
		//MSGError("Unable to find the user in the database. Contact an admin now!");
		return null;
	}
	$a=clearreview($a);
	return $a;
}
/*//retorna la informacion de la tabla clinichistorytable por id
function DBClinicHistoryInfo($id, $c=null){
	$sql = "select *from clinichistorytable where remissionid=$id";
	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");
		//MSGError("Unable to find the user in the database. Contact an admin now!");
		return null;
	}
	$a=clearreview($a);
	return $a;
}*/
function clearreview($a){
	if($a['reviewteacher']!=''){
		$rev=explode(']',$a['reviewteacher']);
		$size=count($rev);
		for ($i=0; $i < $size-1; $i++) {
			$rev2=explode('[',$rev[$i]);
			$rev2=explode('::=::',$rev2[1]);
			if(count($rev2)==3){
				$a['areviewteacher'][$i]['teacher']=$rev2[0];
				$a['areviewteacher'][$i]['obsdesc']=$rev2[1];
				$a['areviewteacher'][$i]['time']=$rev2[2];
			}
		}
	}
	return $a;
}
//funcion para importar pdf con datos de conclusion
function DBNewEndInputData($usernumber, $param, $c=null) {

      if(isset($param['remissionid']) && !isset($param['idre'])) $param['idre']=$param['remissionid'];
      if(isset($param['clinichistoryinputfilepath']) && !isset($param['inputfilepath'])) $param['inputfilepath']=$param['clinichistoryinputfilepath'];
      if(isset($param['clinichistoryinputfilename']) && !isset($param['inputfilename'])) $param['inputfilename']=$param['clinichistoryinputfilename'];

      $ac=array('idre');

      $type['updatetime']=1;
      $ac1=array('updatetime','inputfilename','inputfilepath');

      foreach($ac as $key) {

          if(!isset($param[$key])) {
              MSGError("DBNewEndInputData param error: $key is not set");
              return false;
          }
          if(isset($type[$key]) && !is_numeric($param[$key])) {
              MSGError("DBNewEndInputData param error: $key is not numeric");
              return false;
          }
          $$key = myhtmlspecialchars($param[$key]);
      }
      $inputfilename='';
      $inputfilepath='';
      $updatetime=-1;
      foreach($ac1 as $key) {
          if(isset($param[$key])) {
              if(isset($type[$key]) && !is_numeric($param[$key])) {
    	           MSGError("DBNewEndInputData param error: $key is not numeric");
    	           return false;
              }
              $$key = myhtmlspecialchars($param[$key]);
          }
      }

      $t = time();
      if($updatetime <= 0)
        $updatetime=$t;
      $inputhash = '';

      $sql2 = "select * from clinichistorytable where remissionid=$idre for update";

      $cw = false;
      if($c == null) {
          $cw = true;
          $c = DBConnect();
          DBExec($c, "begin work", "DBNewEndInputData(transaction)");
      }
      $r = DBExec ($c, $sql2, "DBNewEndInputData(get clinichistory for update)");
      $n = DBnlines($r);//0
      $ret=1;//empieza en 1
      $oldfullname='';
      $deservesupdatetime=false;
      if ($n == 0) {
					echo "no encontrado error";
      }else {
          $lr = DBRow($r,0);
          $t = $lr['updatetime'];
          $inputhash = $lr['inputfilehash'];
      }
      if($updatetime >= $t) {

          if(substr($inputfilepath,0,7)!="base64:") {

              if ($inputfilepath != "") {

						      ////funcion que retorna el pequeño sha1
    	           $hash = myshorthash(file_get_contents($inputfilepath));
    	           if($hash != $inputhash) {

    	                $oldoid='';
    	                if(isset($lr))
    	                     $oldoid = $lr['inputfile'];
                        //pg_lo_import () crea un nuevo objeto grande en la base de datos usando un
                        //archivo en el sistema de archivos como fuente de datos. devuelve el oid. dependiendo de la version 7.2 o < 4.2.0
    	                if (($oid1 = DB_lo_import($c, $inputfilepath)) === false) {

    	                      DBExec($c, "rollback work", "DBNewFinalInputData(rollback-input)");
                              //No se puede crear un objeto grande para el archivo $ inputfilename.
    	                      LOGError("No se puede crear un objeto grande para el archivo $inputfilename.");
                              //problema al importar el archivo a la base de datos. ¡Consulte el registro para obtener más detalles!
    	                      MSGError("problema al importar el archivo a la base de datos. ¡Consulte el registro para obtener más detalles!");
    	                      exit;
    	                }
                        //pg_lo_unlink () elimina un objeto grande con la oid . Rendimientos true en caso de éxito o false fracaso.
                        //Para utilizar la interfaz de objetos grandes, es necesario encerrarla dentro de un bloque de transacciones.
    	                if($oldoid != '') DB_lo_unlink($c,$oldoid);
                        //funcion devuelve la informacion de oid enviado pg_lo_read en hash1
    	                $inputhash = DBcrc($oid1, $c);
    	           } else
    	              $oid1 = $lr['inputfile'];
             }

          } else {

              $inputfilepath = base64_decode(substr($inputfilepath,7));
              $hash = myshorthash($inputfilepath);
              if($hash != $inputhash) {
                  $oldoid='';
                  if(isset($lr))
                	  $oldoid = $lr['inputfile'];
                  //importa un texto a un archivo creado en la base de datos y devuelve el oid del archivo
                  if (($oid1 = DB_lo_import_text($c, $inputfilepath)) == null) {
                	  DBExec($c, "rollback work", "DBNewEndInputData(rollback-i-import)");
										LOGError("No se puede crear un objeto grande para el archivo $inputfilename.");
											//problema al importar el archivo a la base de datos. ¡Consulte el registro para obtener más detalles!
										MSGError("problema al importar el archivo a la base de datos. ¡Consulte el registro para obtener más detalles!");
										exit;
                  }
                  //pg_lo_unlink () elimina un objeto grande con la oid . Rendimientos true en caso de éxito o false fracaso.
                  //Para utilizar la interfaz de objetos grandes, es necesario encerrarla dentro de un bloque de transacciones.
                  if($oldoid != '') DB_lo_unlink($c,$oldoid);
                      $inputhash = DBcrc($oid1, $c);//funcion devuelve la informacion de oid enviado pg_lo_read en hash1
               } else
        	         $oid1 = $lr['inputfile'];
          }
					if ($inputfilename != "") {
              $deservesupdatetime=true;
              DBExec ($c, "update clinichistorytable set inputfilename='$inputfilename' where ".
    	         "remissionid=$idre ", "DBNewEndInputData(update inputfilename)");
          }
          if ($inputfilepath != "") {
              $deservesupdatetime=true;
              DBExec ($c, "update clinichistorytable set inputfile=$oid1, inputfilehash='$inputhash' where remissionid=$idre ", "DBNewEndInputData(update inputfile)");
          }
          if($deservesupdatetime) {
              DBExec ($c, "update clinichistorytable set updatetime=" . $updatetime .
    	         " where remissionid=$idre ", "DBNewEndInputData(time)");
					}
          if($cw)
              DBExec($c, "commit work", "DBNewEndInputData(commit)");
          LOGLevel ("clinichistory $idre (inputfile=$inputfilename) update ($usernumber)", 2);
          $ret=2;
      } else {
          if($cw)
              DBExec($c, "commit work", "DBNewEndInputData(commit)");
      }
      return $ret;
}


?>
