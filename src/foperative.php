<?php
//funcion para eliminar la tabla de prostodoncia fija II
function DBDropEndodonticsTable() {
    //conexcion de la base de datos..
	 $c = DBConnect();
	 $r = DBExec($c, "drop table \"endodonticstable\"", "DBDropEndodonticsTable(drop table)");
}
function DBCreateEndodonticsTable() {
	 $c = DBConnect();
	 $conf = globalconf();
	 if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
	 $r = DBExec($c, "
CREATE TABLE \"endodonticstable\" (
				\"endodonticsid\" serial NOT NULL,                	  -- (id de ficha clinica endodoncia)
				\"endodonticsgrade\" varchar(20) DEFAULT '',					-- (curso)
				\"endodonticsyear\" varchar(20) DEFAULT '',						-- (gestion)
        \"endodonticsjobs\" text DEFAULT '',                  -- (trabajos)
        \"endodonticsprocedures\" text DEFAULT '',       			-- (tabla de procedimientos)
        \"endodonticstreatment\" text DEFAULT '',     -- (tratamiento concluido)
        \"endodonticsodontogram\" text DEFAULT '',            -- (odontograma)
        \"endodonticsmaterial\" text DEFAULT '',       			-- (tabla material)
				\"endodonticsrev\"	text DEFAULT '',									-- (ID cola de docentes revisores)
        \"endodonticsstatus\" varchar(50) DEFAULT '',       	-- (estado new, process, end, fail)

				\"endodonticsinputfilename\" varchar(100) DEFAULT '',     -- (nombre del archivo)
				\"endodonticsinputfile\" oid,															-- (el archivo conclido)
				\"endodonticsinputfilehash\" varchar(50),               --(apuntador para archivo)

				\"patientid\" int4 NOT NULL,      								-- (id del paciente)
				\"student\" int4 NOT NULL,                        -- (id del estudiate)
				\"remissionid\" int4 NOT NULL,                    -- (id de la remission)
				\"teacher\" int4 NOT NULL,                        -- (id del docente)
				\"clinicalid\" int4 NOT NULL,
			  \"startdatetime\" int4 DEFAULT -1 NOT NULL, -- (indica la fecha de inicio de ficha clinica)
			  \"enddatetime\" int4 DEFAULT -1 NOT NULL, -- (indica la fecha de finalizacion)
			  \"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
        CONSTRAINT \"endodontics_pkey\" PRIMARY KEY (\"endodonticsid\", \"student\", \"teacher\"),
				CONSTRAINT \"remission_fk\" FOREIGN KEY (\"patientid\", \"student\", \"remissionid\", \"clinicalid\")
								REFERENCES \"remissiontable\" (\"patientid\", \"examined\", \"remissionid\", \"clinicalid\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
				CONSTRAINT \"specialty_fk\" FOREIGN KEY (\"teacher\", \"clinicalid\")
								REFERENCES \"specialtytable\" (\"userid\", \"clinicalid\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
)", "DBCreateEndodonticsTable(create table)");

	$r = DBExec($c, "REVOKE ALL ON \"endodonticstable\" FROM PUBLIC", "DBCreateEndodonticsTable(revoke public)");
	$r = DBExec($c, "GRANT ALL ON \"endodonticstable\" TO \"".$conf["dbuser"]."\"", "DBCreateEndodonticsTable(grant sihcouser)");
	$r = DBExec($c, "CREATE INDEX \"endodontics_index\" ON \"endodonticstable\" USING btree ".
				"(\"endodonticsid\" int4_ops, \"patientid\" int4_ops, \"student\" int4_ops)",
				"DBCreateEndodonticsTable(create endodontics_index)");
}

//funcion para eliminar la tabla
function DBDropOperativeTable() {
    //conexcion de la base de datos..
	 $c = DBConnect();

	 $r = DBExec($c, "drop table \"operativetable\"", "DBDropOperativeTable(drop table)");

}
function DBCreateOperativeTable() {
	 $c = DBConnect();
	 $conf = globalconf();
	 if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
	 $r = DBExec($c, "
CREATE TABLE \"operativetable\" (
				\"operativeid\" serial NOT NULL,                	  -- (id de ficha clinica prostodoncia fija)
				\"operativegrade\" varchar(20) DEFAULT '',					-- (curso)
				\"operativeyear\" varchar(20) DEFAULT '',						-- (gestion)
        \"operativejobs\" text DEFAULT '',                  -- (trabajos)
        \"operativeprocedures\" text DEFAULT '',       			-- (tabla de procedimientos)
        \"operativetreatment\" text DEFAULT '',     -- (tratamiento concluido)
        \"operativeodontogram\" text DEFAULT '',            -- (odontograma)
        \"operativematerial\" text DEFAULT '',       			-- (tabla material)
				\"operativerev\"	text DEFAULT '',									-- (ID cola de docentes revisores)
        \"operativestatus\" varchar(50) DEFAULT '',       	-- (estado new, process, end, fail)

				\"operativeinputfilename\" varchar(100) DEFAULT '',     -- (nombre del archivo)
				\"operativeinputfile\" oid,															-- (el archivo conclido)
				\"operativeinputfilehash\" varchar(50),               --(apuntador para archivo)

				\"patientid\" int4 NOT NULL,      								-- (id del paciente)
				\"student\" int4 NOT NULL,                        -- (id del estudiate)
				\"remissionid\" int4 NOT NULL,                    -- (id de la remission)
				\"teacher\" int4 NOT NULL,                        -- (id del docente)
				\"clinicalid\" int4 NOT NULL,
			  \"startdatetime\" int4 DEFAULT -1 NOT NULL, -- (indica la fecha de inicio de ficha clinica)
			  \"enddatetime\" int4 DEFAULT -1 NOT NULL, -- (indica la fecha de finalizacion)
			  \"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
        CONSTRAINT \"operative_pkey\" PRIMARY KEY (\"operativeid\", \"student\", \"teacher\"),
				CONSTRAINT \"remission_fk\" FOREIGN KEY (\"patientid\", \"student\", \"remissionid\", \"clinicalid\")
								REFERENCES \"remissiontable\" (\"patientid\", \"examined\", \"remissionid\", \"clinicalid\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
				CONSTRAINT \"specialty_fk\" FOREIGN KEY (\"teacher\", \"clinicalid\")
								REFERENCES \"specialtytable\" (\"userid\", \"clinicalid\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
)", "DBCreateOperativeTable(create table)");

	$r = DBExec($c, "REVOKE ALL ON \"operativetable\" FROM PUBLIC", "DBCreateOperativeTable(revoke public)");
	$r = DBExec($c, "GRANT ALL ON \"operativetable\" TO \"".$conf["dbuser"]."\"", "DBCreateOperativeTable(grant sihcouser)");
	$r = DBExec($c, "CREATE INDEX \"operative_index\" ON \"operativetable\" USING btree ".
				"(\"operativeid\" int4_ops, \"patientid\" int4_ops, \"student\" int4_ops)",
				"DBCreateOperativeTable(create operative_index)");
}
//funcion para crear un nuevo registro de operatoria dental II
function DBNewOperative($param , $c=null){

		if(isset($param['patientid']) && !isset($param['patient'])) $param['patient']=$param['patientid'];
		if(isset($param['studentid']) && !isset($param['student'])) $param['student']=$param['studentid'];
		if(isset($param['remissionid']) && !isset($param['remission'])) $param['remission']=$param['remissionid'];
		if(isset($param['teacherid']) && !isset($param['teacher'])) $param['teacher']=$param['teacherid'];
		if(isset($param['clinicalid']) && !isset($param['clinical'])) $param['clinical']=$param['clinicalid'];

		//if(isset($param['pediatricsiid']) && !isset($param['id'])) $param['id']=$param['pediatricsiid'];
		if(isset($param['operativegrade']) && !isset($param['grade'])) $param['grade']=$param['operativegrade'];
		if(isset($param['operativeyear']) && !isset($param['year'])) $param['year']=$param['operativeyear'];
		if(isset($param['operativejobs']) && !isset($param['jobs'])) $param['jobs']=$param['operativejobs'];
		if(isset($param['operativeprocedures']) && !isset($param['procedures'])) $param['procedures']=$param['operativeprocedures'];
		if(isset($param['operativetreatment']) && !isset($param['treatment'])) $param['treatment']=$param['operativetreatment'];
		if(isset($param['operativeodontogram']) && !isset($param['odontogram'])) $param['odontogram']=$param['operativeodontogram'];
		if(isset($param['operativematerial']) && !isset($param['material'])) $param['material']=$param['operativematerial'];
		if(isset($param['operativestatus']) && !isset($param['status'])) $param['status']=$param['operativestatus'];

		$ac=array('patient', 'student', 'remission', 'teacher', 'clinical');

		$ac1=array('grade', 'year', 'jobs', 'procedures', 'treatment', 'odontogram', 'material', 'status');
		$typei['patient']=-1;
		$typei['student']=-1;
		$typei['remission']=-1;
		$typei['teacherid']=-1;//admin
		$typei['clinical']=3; //operatoria dental II


		foreach($ac as $key) {
			if(!isset($param[$key]) || $param[$key]=="") {
				MSGError("DBNewOperative param error: $key not found");
				return false;
			}
			if(isset($typei[$key]) && !is_numeric($param[$key])) {
				MSGError("DBNewOperative param error: $key is not numeric");
				return false;
			}
			$$key = myhtmlspecialchars($param[$key]);
		}

    $grade='';
    $year='';
    $jobs='';
    $procedures='';
    $treatment='';
    $odontogram='';
    $material='';
    $status='new';

		$updatetime=-1;
		foreach($ac1 as $key) {
			if(isset($param[$key])) {
				$$key = myhtmlspecialchars($param[$key]);
				if(isset($typei[$key]) && !is_numeric($param[$key])) {
					MSGError("DBNewOperative param error: $key is not numeric");
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
			DBExec($c, "begin work", "DBNewOperative(begin)");
		}
		DBExec($c, "lock table operativetable", "DBNewOperative(lock)");

		$ret=1;

		//antes de registrar chekear las claves foraneas
		$sql = "select * from operativetable where patientid=$patient and remissionid= $remission";
		$a = DBGetRow ($sql, 0, $c);
			if($teacher==-1){
				if($a!=null){

					$teacher=$a['teacher'];
          $grade=$a['operativegrade'];
          $year=$a['operativeyear'];
          $jobs=$a['operativejobs'];
          $procedures=$a['operativeprocedures'];
          $treatment=$a['operativetreatment'];
          $odontogram=$a['operativeodontogram'];
          $material=$a['operativematerial'];
          $status=$a['operativestatus'];

				}else{
					$teacher=0;
				}
			}
	      	//para insercion o actulizacion
			if ($a == null) {
				  $ret=2;

	    		$sql = "insert into operativetable(operativegrade, operativeyear, operativejobs, operativeprocedures, ".
          "operativetreatment, operativeodontogram, operativematerial, operativestatus, ".
					"patientid, student, remissionid, teacher, clinicalid) values (".
					"'$grade', '$year','$jobs','$procedures','$treatment','$odontogram','$material','$status', ".
					"$patient, $student, $remission, $teacher, $clinical)";

					DBExec ($c, $sql, "DBNewOperative(insert)");
	    		if($cw) {
	    				DBExec ($c, "commit work");
	    		}
	    		LOGLevel ("Ficha Operatoria dental II $remission registrado.",2);
			} else {
				if($updatetime > $a['updatetime']) {
					$ret=2;

					$sql = "update operativetable set operativegrade='$grade', operativeyear='$year', operativejobs='$jobs', ";
					if($procedures!='')
						$sql.="operativeprocedures='$procedures', ";
					if($treatment!='')
						$sql.="operativetreatment='$treatment', ";
					if($odontogram!='')
						$sql.="operativeodontogram='$odontogram', ";
					if($material!='')
						$sql.="operativematerial='$material', ";
					$sql.="operativestatus='$status', ".
					"student=$student, teacher=$teacher, updatetime=$updatetime ".
					"where patientid=$patient and remissionid=$remission";

					$r = DBExec ($c, $sql, "DBNewOperative(update)");
					if($cw) {
						DBExec ($c, "commit work");
					}
					LOGLevel("Ficha Operatoria Dental II $remission actualizado.",2);
				}
			}

		if($cw) DBExec($c, "commit work");
		return $ret;
}
//funcion para crear un nuevo registro de operatoria dental II
function DBNewEndodontics($param , $c=null){

		if(isset($param['patientid']) && !isset($param['patient'])) $param['patient']=$param['patientid'];
		if(isset($param['studentid']) && !isset($param['student'])) $param['student']=$param['studentid'];
		if(isset($param['remissionid']) && !isset($param['remission'])) $param['remission']=$param['remissionid'];
		if(isset($param['teacherid']) && !isset($param['teacher'])) $param['teacher']=$param['teacherid'];
		if(isset($param['clinicalid']) && !isset($param['clinical'])) $param['clinical']=$param['clinicalid'];

		//if(isset($param['pediatricsiid']) && !isset($param['id'])) $param['id']=$param['pediatricsiid'];
		if(isset($param['endodonticsgrade']) && !isset($param['grade'])) $param['grade']=$param['endodonticsgrade'];
		if(isset($param['endodonticsyear']) && !isset($param['year'])) $param['year']=$param['endodonticsyear'];
		if(isset($param['endodonticsjobs']) && !isset($param['jobs'])) $param['jobs']=$param['endodonticsjobs'];
		if(isset($param['endodonticsprocedures']) && !isset($param['procedures'])) $param['procedures']=$param['endodonticsprocedures'];
		if(isset($param['endodonticstreatment']) && !isset($param['treatment'])) $param['treatment']=$param['endodonticstreatment'];
		if(isset($param['endodonticsodontogram']) && !isset($param['odontogram'])) $param['odontogram']=$param['endodonticsodontogram'];
		if(isset($param['endodonticsmaterial']) && !isset($param['material'])) $param['material']=$param['endodonticsmaterial'];
		if(isset($param['endodonticsstatus']) && !isset($param['status'])) $param['status']=$param['endodonticsstatus'];

		$ac=array('patient', 'student', 'remission', 'teacher', 'clinical');

		$ac1=array('grade', 'year', 'jobs', 'procedures', 'treatment', 'odontogram', 'material', 'status');
		$typei['patient']=-1;
		$typei['student']=-1;
		$typei['remission']=-1;
		$typei['teacherid']=-1;//admin
		$typei['clinical']=4; //endodoncia II


		foreach($ac as $key) {
			if(!isset($param[$key]) || $param[$key]=="") {
				MSGError("DBNewEndodontics param error: $key not found");
				return false;
			}
			if(isset($typei[$key]) && !is_numeric($param[$key])) {
				MSGError("DBNewEndodontics param error: $key is not numeric");
				return false;
			}
			$$key = myhtmlspecialchars($param[$key]);
		}

    $grade='';
    $year='';
    $jobs='';
    $procedures='';
    $treatment='';
    $odontogram='';
    $material='';
    $status='new';

		$updatetime=-1;
		foreach($ac1 as $key) {
			if(isset($param[$key])) {
				$$key = myhtmlspecialchars($param[$key]);
				if(isset($typei[$key]) && !is_numeric($param[$key])) {
					MSGError("DBNewEndodontics param error: $key is not numeric");
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
			DBExec($c, "begin work", "DBNewEndodontics(begin)");
		}
		DBExec($c, "lock table endodonticstable", "DBNewEndodontics(lock)");

		$ret=1;

		//antes de registrar chekear las claves foraneas
		$sql = "select * from endodonticstable where patientid=$patient and remissionid= $remission";
		$a = DBGetRow ($sql, 0, $c);
			if($teacher==-1){
				if($a!=null){

					$teacher=$a['teacher'];
          $grade=$a['endodonticsgrade'];
          $year=$a['endodonticsyear'];
          $jobs=$a['endodonticsjobs'];
          $procedures=$a['endodonticsprocedures'];
          $treatment=$a['endodonticstreatment'];
          $odontogram=$a['endodonticsodontogram'];
          $material=$a['endodonticsmaterial'];
          $status=$a['endodonticsstatus'];

				}else{
					$teacher=0;
				}
			}
	      	//para insercion o actulizacion
			if ($a == null) {
				  $ret=2;

	    		$sql = "insert into endodonticstable(endodonticsgrade, endodonticsyear, endodonticsjobs, endodonticsprocedures, ".
          "endodonticstreatment, endodonticsodontogram, endodonticsmaterial, endodonticsstatus, ".
					"patientid, student, remissionid, teacher, clinicalid) values (".
					"'$grade', '$year','$jobs','$procedures','$treatment','$odontogram','$material','$status', ".
					"$patient, $student, $remission, $teacher, $clinical)";

					DBExec ($c, $sql, "DBNewEndodontics(insert)");
	    		if($cw) {
	    				DBExec ($c, "commit work");
	    		}
	    		LOGLevel ("Ficha Endodoncia II $remission registrado.",2);
			} else {
				if($updatetime > $a['updatetime']) {
					$ret=2;

					$sql = "update endodonticstable set endodonticsgrade='$grade', endodonticsyear='$year', endodonticsjobs='$jobs', ";
					if($procedures!='')
						$sql.="endodonticsprocedures='$procedures', ";
					if($treatment!='')
						$sql.="endodonticstreatment='$treatment', ";
					if($odontogram!='')
						$sql.="endodonticsodontogram='$odontogram', ";
					if($material!='')
						$sql.="endodonticsmaterial='$material', ";
					$sql.="endodonticsstatus='$status', ".
					"student=$student, teacher=$teacher, updatetime=$updatetime ".
					"where patientid=$patient and remissionid=$remission";

					$r = DBExec ($c, $sql, "DBNewEndodontics(update)");
					if($cw) {
						DBExec ($c, "commit work");
					}
					LOGLevel("Ficha Endodoncia II $remission actualizado.",2);
				}
			}

		if($cw) DBExec($c, "commit work");
		return $ret;
}
//funcion para eliminar una remision equivocada
function DBDeleteOperative($remission){

	$c = DBConnect();
	DBExec($c, "begin work");
	DBExec($c, "lock table operativetable");
	$sql = "select * from operativetable where remissionid=$remission for update";
	$a = DBGetRow ($sql, 0, $c);
	$yes=false;
	if ($a != null) {
			//echo "yes delete";
      $sql = "delete from operativetable where remissionid=$remission";
			DBExec ($c, $sql);
			DBExec($c, "commit work");//para el commit de exito
			$yes=true;
	} else {
		echo "no delete";
		DBExec($c, "rollback work");
		LOGLevel("Operative remissionid = $remission could not be removed.", 1);
		return false;
	}
	if($yes)
		DBDeleteObservation($remission);
}
//funcion para eliminar una remision equivocada
function DBDeleteEndodontics($remission){

	$c = DBConnect();
	DBExec($c, "begin work");
	DBExec($c, "lock table endodonticstable");
	$sql = "select * from endodonticstable where remissionid=$remission for update";
	$a = DBGetRow ($sql, 0, $c);
	$yes=false;
	if ($a != null) {
			//echo "yes delete";
      $sql = "delete from endodonticstable where remissionid=$remission";
			DBExec ($c, $sql);
			DBExec($c, "commit work");//para el commit de exito
			$yes=true;
	} else {
		echo "no delete";
		DBExec($c, "rollback work");
		LOGLevel("Endodontics remissionid = $remission could not be removed.", 1);
		return false;
	}
	if($yes)
		DBDeleteObservation($remission);
}


function DBOperativeInfo($id, $c=null) {

	$sql = "select *from operativetable where operativeid=$id";

	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");

		return null;
	}

	$ob=DBObservationInfo($a['operativeid'],$a['remissionid']);
	if($ob!=null){
		$a=array_merge($a, $ob);
	}

	$conf=globalconf();
	if($a['operativeodontogram']!=null)
		$a['operativeodontogram'] = decryptData($a['operativeodontogram'], $conf["key"]);
	$a=clearoperative($a);
	return $a;
}
function clearoperative($a){
	$r=explode(']',$a['operativejobs']);
	$size=count($r);

	$akey = array('trabajo1','trabajo2','trabajo3');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}
	$r=explode(']',$a['operativetreatment']);
	$size=count($r);

	$akey = array('treatmentdesc','treatmentdate','treatmentfirm');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}

	if(isset($a['operativeprocedures'])&&$a['operativeprocedures']){
		$r=explode('}',$a['operativeprocedures']);
		$size=count($r);

		for ($i=0; $i <$size-1 ; $i++) {
			$r2=explode('{',$r[$i]);
			$r3=explode(']',$r2[1]);
			$size2=count($r3);


			$akey = array('pieza','clase','caries','inicio','preparacion','cavitaria','obturacion','pulido');

			if($size2-1==count($akey)){
				for ($j=0; $j < $size2-1; $j++) {
					$r4=explode('[',$r3[$j]);
					$a['tableprocedures'][$akey[$j]][$i]=trim($r4[1]);
				}
			}

		}
	}
	return $a;
}

function DBUpdateOperativeTreament($file, $procedures, $treatment='', $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBUpdateOperativeTreament(begin)");
		}
		DBExec($c, "lock table operativetable", "DBUpdateOperativeTreament(lock)");

		$ret=2;
		$time=time();
		if(isset($file) && is_numeric($file) && isset($procedures)&&$procedures){
				$sql="update operativetable set operativeprocedures='$procedures' where operativeid=".$file;
				DBExec($c, $sql, "DBUpdateOperativeTreament(update operativetable)");
		}
		if(isset($file) && is_numeric($file) && isset($treatment)&&$treatment){
				$sql="update operativetable set operativetreatment='$treatment' where operativeid=".$file;
				DBExec($c, $sql, "DBUpdateOperativeTreament(update operativetable)");
		}
		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}
function DBUpdateOperativeMaterial($file, $material, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBUpdateOperativeMaterial(begin)");
		}
		DBExec($c, "lock table operativetable", "DBUpdateOperativeMaterial(lock)");

		$ret=2;
		$time=time();
		if(isset($file) && is_numeric($file) && isset($material)&&$material){
				$sql="update operativetable set operativematerial='$material' where operativeid=".$file;
				DBExec($c, $sql, "DBUpdateOperativeMaterial(update operativetable)");
		}
		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}

function DBAllOperativeTeacherInfo($user, $clinical, $limit=100){
	$sql = "select c.clinicalid as clinical, r.remissionid as remission, op.operativeid as ficha, p.patientfullname as patientfullname,
de.motconsult as consult, c.clinicalspecialty as clinicalname, u.userfullname as student,
op.operativestatus as status, op.updatetime as time from operativetable
as op, usertable as u, patienttable as p, clinicaltable as c, dentalexamtable as de, remissiontable as r
where (op.teacher=$user or op.operativerev LIKE '%[$user]%') and op.operativestatus!='new' and p.patientid=op.patientid and de.patientid=r.patientid and
de.dentalid=r.patientdentalid and r.remissionid=op.remissionid and op.clinicalid=$clinical and c.clinicalid=r.clinicalid and
r.examined=op.student and u.usernumber=r.examined order by op.updatetime desc limit $limit";

	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBAllOperativeTeacherInfo(get all fixed)");
	$n = DBnlines($r);

	$a = array();
	for ($i=0;$i<$n;$i++) {
		$a[$i] = DBRow($r,$i);
		//para sacar la observacion de cada ficha clinica
		$ob=DBObservationInfo2($a[$i]['ficha'], $a[$i]['remission']);
		if($ob!=null)
			$a[$i]=array_merge($a[$i],$ob);
		$a[$i]['file']='operative';
		$a[$i]['diagnosis']='';
	}



	return $a;
}

function DBEvaluateOperative($desc, $evaluated, $accepted, $status, $record, $c=null){
	$cw = false;
	if($c == null) {
		$cw = true;
		$c = DBConnect();
		DBExec($c, "begin work", "DBEvaluateOperative(begin)");
	}
	$updatetime=time();

	$ret=2;
	$sql = "update operativetable set operativestatus='$status', ";
	if($status=='end')
		$sql.="enddatetime=$updatetime, ";
	$sql.="updatetime=$updatetime where operativeid=$record";

	DBExec ($c, $sql, "DBEvaluateOperative(update operative)");
	//DBExec($c, "lock table observationtable", "DBEvaluate(lock)");
	$b=DBOperativeInfo($record);
	$remission=$b['remissionid'];
	$sql = "update observationtable set observationdesc='$desc', observationevaluated='$evaluated', ".
	"observationaccepted='$accepted', updatetime=$updatetime where (fileid=$record and remissionid=$remission) and observationid=(select max(observationid) ".
	"from observationtable where fileid=$record and remissionid=$remission)";

	DBExec ($c, $sql, "DBEvaluateOperative(update observation)");

	if($cw) {
			DBExec ($c, "commit work");
	}

	return $ret;
}

function DBOperativeInfo2($id, $c=null) {

	$sql = "select c.clinicalid as clinical, r.remissionid as remission, op.operativeid as ficha, p.patientfullname as patientfullname,
de.motconsult as consult, c.clinicalspecialty as clinicalname, u.userfullname as student,
op.operativestatus as status, op.teacher as teacher, op.updatetime as time from operativetable
as op, usertable as u, patienttable as p, clinicaltable as c, dentalexamtable as de, remissiontable as r
where op.operativeid=$id and op.operativestatus!='new' and p.patientid=op.patientid and de.patientid=r.patientid and
de.dentalid=r.patientdentalid and r.remissionid=op.remissionid and c.clinicalid=r.clinicalid and
r.examined=op.student and u.usernumber=r.examined";

	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");

		//MSGError("Unable to find the user in the database. Contact an admin now!");
		return null;
	}
	//$a=clearsession($a);
	$ob=DBObservationInfo2($id,$a['remission']);
	if($ob!=null)
		$a=array_merge($a,$ob);
	return $a;
}

//funciones para endodoncia:::::::::::
//:::::::::::::::::::::::::::::::::::::::
function DBEndodonticsInfo($id, $c=null) {

	$sql = "select *from endodonticstable where endodonticsid=$id";

	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");

		return null;
	}

	$ob=DBObservationInfo($a['endodonticsid'],$a['remissionid']);
	if($ob!=null){
		$a=array_merge($a, $ob);
	}

	$conf=globalconf();
	if($a['endodonticsodontogram']!=null)
		$a['endodonticsodontogram'] = decryptData($a['endodonticsodontogram'], $conf["key"]);
	$a=clearendodontics($a);
	return $a;
}
function clearendodontics($a){
	$r=explode(']',$a['endodonticsjobs']);
	$size=count($r);

	$akey = array('trabajo1','trabajo2','trabajo3');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}
	$r=explode(']',$a['endodonticstreatment']);
	$size=count($r);

	$akey = array('treatmentdesc','treatmentdate','treatmentfirm');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}

	if(isset($a['endodonticsprocedures'])&&$a['endodonticsprocedures']){
		$r=explode('}',$a['endodonticsprocedures']);
		$size=count($r);

		for ($i=0; $i <$size-1 ; $i++) {
			$r2=explode('{',$r[$i]);
			$r3=explode(']',$r2[1]);
			$size2=count($r3);


			$akey = array('pieza','clase','caries','inicio','preparacion','cavitaria','obturacion','pulido');

			if($size2-1==count($akey)){
				for ($j=0; $j < $size2-1; $j++) {
					$r4=explode('[',$r3[$j]);
					$a['tableprocedures'][$akey[$j]][$i]=trim($r4[1]);
				}
			}

		}
	}
	return $a;
}

function DBUpdateEndodonticsTreament($file, $procedures, $treatment='', $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBUpdateEndodonticsTreament(begin)");
		}
		DBExec($c, "lock table endodonticstable", "DBUpdateEndodonticsTreament(lock)");

		$ret=2;
		$time=time();
		if(isset($file) && is_numeric($file) && isset($procedures)&&$procedures){
				$sql="update endodonticstable set endodonticsprocedures='$procedures' where endodonticsid=".$file;
				DBExec($c, $sql, "DBUpdateEndodonticsTreament(update endodonticstable)");
		}
		if(isset($file) && is_numeric($file) && isset($treatment)&&$treatment){
				$sql="update endodonticstable set endodonticstreatment='$treatment' where endodonticsid=".$file;
				DBExec($c, $sql, "DBUpdateEndodonticsTreament(update endodonticstable)");
		}
		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}
function DBUpdateEndodonticsMaterial($file, $material, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBUpdateEndodonticsMaterial(begin)");
		}
		DBExec($c, "lock table endodonticstable", "DBUpdateEndodonticsMaterial(lock)");

		$ret=2;
		$time=time();
		if(isset($file) && is_numeric($file) && isset($material)&&$material){
				$sql="update endodonticstable set endodonticsmaterial='$material' where endodonticsid=".$file;
				DBExec($c, $sql, "DBUpdateEndodonticsMaterial(update endodonticstable)");
		}
		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}

function DBAllEndodonticsTeacherInfo($user, $clinical, $limit=100){
	$sql = "select c.clinicalid as clinical, r.remissionid as remission, op.endodonticsid as ficha, p.patientfullname as patientfullname,
de.motconsult as consult, c.clinicalspecialty as clinicalname, u.userfullname as student,
op.endodonticsstatus as status, op.updatetime as time from endodonticstable
as op, usertable as u, patienttable as p, clinicaltable as c, dentalexamtable as de, remissiontable as r
where (op.teacher=$user or op.endodonticsrev LIKE '%[$user]%') and op.endodonticsstatus!='new' and p.patientid=op.patientid and de.patientid=r.patientid and
de.dentalid=r.patientdentalid and r.remissionid=op.remissionid and op.clinicalid=$clinical and c.clinicalid=r.clinicalid and
r.examined=op.student and u.usernumber=r.examined order by op.updatetime desc limit $limit";

	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBAllEndodonticsTeacherInfo(get all fixed)");
	$n = DBnlines($r);

	$a = array();
	for ($i=0;$i<$n;$i++) {
		$a[$i] = DBRow($r,$i);
		//para sacar la observacion de cada ficha clinica
		$ob=DBObservationInfo2($a[$i]['ficha'], $a[$i]['remission']);
		if($ob!=null)
			$a[$i]=array_merge($a[$i],$ob);
		$a[$i]['file']='endodontics';
		$a[$i]['diagnosis']='';
	}



	return $a;
}

function DBEvaluateEndodontics($desc, $evaluated, $accepted, $status, $record, $c=null){
	$cw = false;
	if($c == null) {
		$cw = true;
		$c = DBConnect();
		DBExec($c, "begin work", "DBEvaluateEndodontics(begin)");
	}
	$updatetime=time();

	$ret=2;
	$sql = "update endodonticstable set endodonticsstatus='$status', ";
	if($status=='end')
		$sql.="enddatetime=$updatetime, ";
	$sql.="updatetime=$updatetime where endodonticsid=$record";

	DBExec ($c, $sql, "DBEvaluateEndodontics(update endodontics)");
	//DBExec($c, "lock table observationtable", "DBEvaluate(lock)");
	$b=DBEndodonticsInfo($record);
	$remission=$b['remissionid'];
	$sql = "update observationtable set observationdesc='$desc', observationevaluated='$evaluated', ".
	"observationaccepted='$accepted', updatetime=$updatetime where (fileid=$record and remissionid=$remission) and observationid=(select max(observationid) ".
	"from observationtable where fileid=$record and remissionid=$remission)";

	DBExec ($c, $sql, "DBEvaluateEndodontics(update observation)");

	if($cw) {
			DBExec ($c, "commit work");
	}

	return $ret;
}

function DBEndodonticsInfo2($id, $c=null) {

	$sql = "select c.clinicalid as clinical, r.remissionid as remission, op.endodonticsid as ficha, p.patientfullname as patientfullname,
de.motconsult as consult, c.clinicalspecialty as clinicalname, u.userfullname as student,
op.endodonticsstatus as status, op.teacher as teacher, op.updatetime as time from endodonticstable
as op, usertable as u, patienttable as p, clinicaltable as c, dentalexamtable as de, remissiontable as r
where op.endodonticsid=$id and op.endodonticsstatus!='new' and p.patientid=op.patientid and de.patientid=r.patientid and
de.dentalid=r.patientdentalid and r.remissionid=op.remissionid and c.clinicalid=r.clinicalid and
r.examined=op.student and u.usernumber=r.examined";

	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");

		//MSGError("Unable to find the user in the database. Contact an admin now!");
		return null;
	}
	//$a=clearsession($a);
	$ob=DBObservationInfo2($id,$a['remission']);
	if($ob!=null)
		$a=array_merge($a,$ob);
	return $a;
}









?>
