<?php
//funcion para eliminar la tabla de prostodoncia removible II
function DBDropRemovableTable() {
    //conexcion de la base de datos..
	 $c = DBConnect();

	 $r = DBExec($c, "drop table \"removabletable\"", "DBDropRemovableTable(drop table)");

}
function DBCreateRemovableTable() {
	 $c = DBConnect();
	 $conf = globalconf();
	 if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
	 $r = DBExec($c, "
CREATE TABLE \"removabletable\" (
				\"removableid\" serial NOT NULL,                	      -- (id de ficha clinica prostodoncia removible)
				\"removablegrade\" varchar(20) DEFAULT '',					-- (curso)
				\"removablehereditary\" varchar(200) DEFAULT '',				-- (antecedentes hereditarios)
				\"removablepersonal\" varchar(100) DEFAULT '',        	-- (antecedentes personales generales)
        \"removablepsychological\" varchar(100) DEFAULT '',   	-- (tipo psicologico)
        \"removabletoothless\" varchar(100) DEFAULT '',         -- (tipo de desdentado)
        \"removablekenedy\" varchar(100) DEFAULT '',       			-- (clasificacion de kenedy)
        \"removablediagnosis\" text DEFAULT '',                 -- (diagnostico)
				\"removablecavities\" varchar(50) DEFAULT '',            -- (indice de caries)
				\"removablecentral\" varchar(50) DEFAULT '',            -- (oclusion centrica)
				\"removablebraces\" varchar(100) DEFAULT '',       	    -- (frenilos o inserciones)
				\"removablesaliva\" varchar(100) DEFAULT '',            -- (la saliva)
				\"removableinterference\" text DEFAULT '',              -- (posibles interferencias)
				\"removablepalate\" varchar(100) DEFAULT '',            -- (paladar)
				\"removableresidual\" varchar(100) DEFAULT '',          -- (evaluacion del reborde residual)
				\"removableprosthesis\" varchar(50) DEFAULT '',         -- (rebordes)
				\"removableinterocclusal\" varchar(50) DEFAULT '',      -- (inter oclusal)
				\"removableplaneocclusal\" varchar(50) DEFAULT '',      -- (el plano oclusal)
				\"removableanomalies\" varchar(100) DEFAULT '',         -- (anomalias)
				\"removableparalyzer\" text DEFAULT '',       		 			-- (paralelizador)
				\"removableradiographic\" text DEFAULT '',              -- (interpretacion radiografica)
				\"removableprocedures\" text DEFAULT '',              -- (procedimientos)
				\"removableodontogram\" text DEFAULT '',              -- (odontograma)
				\"removablespecs\" text DEFAULT '',              -- (especificaciones del plan)

				\"removablerev\"	text DEFAULT '',									-- (ID cola de docentes revisores)
        \"removablestatus\" varchar(50) DEFAULT '',       -- (estado new, process, end, fail)

				\"removableinputfilename\" varchar(100) DEFAULT '',     -- (nombre del archivo)
				\"removableinputfile\" oid,															-- (el archivo conclido)
				\"removableinputfilehash\" varchar(50),               --(apuntador para archivo)

				\"patientid\" int4 NOT NULL,      								-- (id del paciente)
				\"student\" int4 NOT NULL,                        -- (id del estudiate)
				\"remissionid\" int4 NOT NULL,                    -- (id de la remission)
				\"teacher\" int4 NOT NULL,                        -- (id del docente)
				\"clinicalid\" int4 NOT NULL,
			  \"startdatetime\" int4 DEFAULT -1 NOT NULL, -- (indica la fecha de inicio de ficha clinica)
			  \"enddatetime\" int4 DEFAULT -1 NOT NULL, -- (indica la fecha de finalizacion)
			  \"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
        CONSTRAINT \"removable_pkey\" PRIMARY KEY (\"removableid\", \"student\", \"teacher\"),
				CONSTRAINT \"remission_fk\" FOREIGN KEY (\"patientid\", \"student\", \"remissionid\", \"clinicalid\")
								REFERENCES \"remissiontable\" (\"patientid\", \"examined\", \"remissionid\", \"clinicalid\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
				CONSTRAINT \"specialty_fk\" FOREIGN KEY (\"teacher\", \"clinicalid\")
								REFERENCES \"specialtytable\" (\"userid\", \"clinicalid\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
)", "DBCreateRemovableTable(create table)");

	$r = DBExec($c, "REVOKE ALL ON \"removabletable\" FROM PUBLIC", "DBCreateRemovableTable(revoke public)");
	$r = DBExec($c, "GRANT ALL ON \"removabletable\" TO \"".$conf["dbuser"]."\"", "DBCreateRemovableTable(grant sihcouser)");
	$r = DBExec($c, "CREATE INDEX \"removable_index\" ON \"removabletable\" USING btree ".
				"(\"removableid\" int4_ops, \"patientid\" int4_ops, \"student\" int4_ops)",
				"DBCreateRemovableTable(create removable_index)");
}
//funcion para crear un nuevo registro de prostodoncia removible
function DBNewRemovable($param , $c=null){

		if(isset($param['patientid']) && !isset($param['patient'])) $param['patient']=$param['patientid'];
		if(isset($param['studentid']) && !isset($param['student'])) $param['student']=$param['studentid'];
		if(isset($param['remissionid']) && !isset($param['remission'])) $param['remission']=$param['remissionid'];
		if(isset($param['teacherid']) && !isset($param['teacher'])) $param['teacher']=$param['teacherid'];
		if(isset($param['clinicalid']) && !isset($param['clinical'])) $param['clinical']=$param['clinicalid'];

		//if(isset($param['pediatricsiid']) && !isset($param['id'])) $param['id']=$param['pediatricsiid'];
		if(isset($param['removablegrade']) && !isset($param['grade'])) $param['grade']=$param['removablegrade'];
		if(isset($param['removablehereditary']) && !isset($param['hereditary'])) $param['hereditary']=$param['removablehereditary'];
		if(isset($param['removablepersonal']) && !isset($param['personal'])) $param['personal']=$param['removablepersonal'];
		if(isset($param['removablepsychological']) && !isset($param['psychological'])) $param['psychological']=$param['removablepsychological'];
		if(isset($param['removabletoothless']) && !isset($param['toothless'])) $param['toothless']=$param['removabletoothless'];
		if(isset($param['removablekenedy']) && !isset($param['kenedy'])) $param['kenedy']=$param['removablekenedy'];
		if(isset($param['removablediagnosis']) && !isset($param['diagnosis'])) $param['diagnosis']=$param['removablediagnosis'];
		if(isset($param['removablecavities']) && !isset($param['cavities'])) $param['cavities']=$param['removablecavities'];
		if(isset($param['removablecentral']) && !isset($param['central'])) $param['central']=$param['removablecentral'];
		if(isset($param['removablebraces']) && !isset($param['braces'])) $param['braces']=$param['removablebraces'];
		if(isset($param['removablesaliva']) && !isset($param['saliva'])) $param['saliva']=$param['removablesaliva'];
		if(isset($param['removableinterference']) && !isset($param['interference'])) $param['interference']=$param['removableinterference'];
		if(isset($param['removablepalate']) && !isset($param['palate'])) $param['palate']=$param['removablepalate'];
		if(isset($param['removableresidual']) && !isset($param['residual'])) $param['residual']=$param['removableresidual'];
		if(isset($param['removableprosthesis']) && !isset($param['prosthesis'])) $param['prosthesis']=$param['removableprosthesis'];
		if(isset($param['removableinterocclusal']) && !isset($param['interocclusal'])) $param['interocclusal']=$param['removableinterocclusal'];
		if(isset($param['removableplaneocclusal']) && !isset($param['planeocclusal'])) $param['planeocclusal']=$param['removableplaneocclusal'];
		if(isset($param['removableanomalies']) && !isset($param['anomalies'])) $param['anomalies']=$param['removableanomalies'];
		if(isset($param['removableparalyzer']) && !isset($param['paralyzer'])) $param['paralyzer']=$param['removableparalyzer'];
		if(isset($param['removableradiographic']) && !isset($param['radiographic'])) $param['radiographic']=$param['removableradiographic'];
		if(isset($param['removableodontogram']) && !isset($param['odontogram'])) $param['odontogram']=$param['removableodontogram'];
		if(isset($param['removablespecs']) && !isset($param['specs'])) $param['specs']=$param['removablespecs'];
		if(isset($param['removableprocedures']) && !isset($param['procedures'])) $param['procedures']=$param['removableprocedures'];
		if(isset($param['removablestatus']) && !isset($param['status'])) $param['status']=$param['removablestatus'];

		$ac=array('patient', 'student', 'remission', 'teacher', 'clinical');

		$ac1=array('grade', 'hereditary', 'personal', 'psychological', 'toothless',
		'kenedy', 'diagnosis', 'cavities', 'central', 'braces', 'saliva', 'interference', 'palate',
		'residual', 'prosthesis', 'interocclusal', 'planeocclusal', 'anomalies', 'paralyzer',
		'radiographic', 'odontogram', 'specs', 'procedures', 'status');

		$typei['patient']=-1;
		$typei['student']=-1;
		$typei['remission']=-1;
		$typei['teacherid']=-1;//admin
		$typei['clinical']=1;//clinica prostodoncia removible de cuarto año


		foreach($ac as $key) {
			if(!isset($param[$key]) || $param[$key]=="") {
				MSGError("DBNewRemovable param error: $key not found");
				return false;
			}
			if(isset($typei[$key]) && !is_numeric($param[$key])) {
				MSGError("DBNewRemovable param error: $key is not numeric");
				return false;
			}
			$$key = myhtmlspecialchars($param[$key]);
		}

		$grade='';
		$hereditary='';
		$personal='';
		$psychological='';
		$toothless='';
		$kenedy='';
		$diagnosis='';
		$cavities='';
		$central='';
		$braces='';
		$saliva='';
		$interference='';
		$palate='';
		$residual='';
		$prosthesis='';
		$interocclusal='';
		$planeocclusal='';
		$anomalies='';
		$paralyzer='';
		$radiographic='';
		$odontogram='';
		$specs='';
		$procedures='';
		$status='new';

		$updatetime=-1;
		foreach($ac1 as $key) {
			if(isset($param[$key])) {
				$$key = myhtmlspecialchars($param[$key]);
				if(isset($typei[$key]) && !is_numeric($param[$key])) {
					MSGError("DBNewRemovable param error: $key is not numeric");
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
			DBExec($c, "begin work", "DBNewRemovable(begin)");
		}
		DBExec($c, "lock table removabletable", "DBNewRemovable(lock)");

		$ret=1;

		//antes de registrar chekear las claves foraneas
		$sql = "select * from removabletable where patientid=$patient and remissionid= $remission";
		$a = DBGetRow ($sql, 0, $c);
			if($teacher==-1){
				if($a!=null){

					$teacher=$a['teacher'];
					$grade=$a['removablegrade'];
					$hereditary=$a['removablehereditary'];
					$personal=$a['removablepersonal'];
					$psychological=$a['removablepsychological'];
					$toothless=$a['removabletoothless'];
					$kenedy=$a['removablekenedy'];
					$diagnosis=$a['removablediagnosis'];
					$cavities=$a['removablecavities'];
					$central=$a['removablecentral'];
					$braces=$a['removablebraces'];
					$saliva=$a['removablesaliva'];
					$interference=$a['removableinterference'];
					$palate=$a['removablepalate'];
					$residual=$a['removableresidual'];
					$prosthesis=$a['removableprosthesis'];
					$interocclusal=$a['removableinterocclusal'];
					$planeocclusal=$a['removableplaneocclusal'];
					$anomalies=$a['removableanomalies'];
					$paralyzer=$a['removableparalyzer'];
					$radiographic=$a['removableradiographic'];
					$valueworked=$a['removableodontogram'];
					$worked=$a['removablespecs'];
					$procedures=$a['removableprocedures'];
					$status=$a['removablestatus'];

				}else{
					$teacher=0;
				}
			}
	      	//para insercion o actulizacion
			if ($a == null) {
				  $ret=2;

	    		$sql = "insert into removabletable(removablegrade, removablehereditary, removablepersonal, ".
					"removablepsychological, removabletoothless, removablekenedy, removablediagnosis, removablecavities, ".
					"removablecentral, removablebraces, removablesaliva, removableinterference, removablepalate, ".
					"removableresidual, removableprosthesis, removableinterocclusal, removableplaneocclusal, ".
					"removableanomalies, removableparalyzer, removableradiographic, removableodontogram, ".
					"removablespecs, removableprocedures, removablestatus, ".
					"patientid, student, remissionid, teacher, clinicalid) values (".
					"'$grade', '$hereditary', '$personal', '$psychological', '$toothless', ".
					"'$kenedy', '$diagnosis', '$cavities', '$central', '$braces', '$saliva', '$interference', ".
					"'$palate', '$residual', '$prosthesis', '$interocclusal', '$planeocclusal', ".
					"'$anomalies', '$paralyzer', '$radiographic', '$odontogram', '$specs', ".
					"'$procedures', '$status', $patient, $student, $remission, $teacher, $clinical)";

					DBExec ($c, $sql, "DBNewRemovable(insert)");
	    		if($cw) {
	    				DBExec ($c, "commit work");
	    		}
	    		LOGLevel ("Ficha Prostodoncia Removible II $remission registrado.",2);
			} else {
				if($updatetime > $a['updatetime']) {
					$ret=2;
					$procedures=$a['removableprocedures'];//para actualizar el mismo dato.
					$sql = "update removabletable set removablegrade='$grade', removablehereditary='$hereditary', ".
					"removablepersonal='$personal', removablepsychological='$psychological', ".
					"removabletoothless='$toothless', removablekenedy='$kenedy', ".
					"removablediagnosis='$diagnosis', removablecavities='$cavities', removablecentral='$central', removablebraces='$braces', ".
					"removablesaliva='$saliva', removableinterference='$interference', ".
					"removablepalate='$palate', removableresidual='$residual', ".
					"removableprosthesis='$prosthesis', removableinterocclusal='$interocclusal', ".
					"removableplaneocclusal='$planeocclusal', removableanomalies='$anomalies', ".
					"removableparalyzer='$paralyzer', removableradiographic='$radiographic', ".
					"removableodontogram='$odontogram', removablespecs='$specs', ".
					"removableprocedures='$procedures', removablestatus='$status', ".
					"student=$student, teacher=$teacher, updatetime=$updatetime ".
					"where patientid=$patient and remissionid=$remission";

					$r = DBExec ($c, $sql, "DBNewRemovable(update)");
					if($cw) {
						DBExec ($c, "commit work");
					}
					LOGLevel("Ficha Prostodoncia Removible II $remission actualizado.",2);
				}
			}

		if($cw) DBExec($c, "commit work");
		return $ret;
}
function DBUpdateRemovableSpecs($param, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBUpdateRemovableSpecs(begin)");
		}
		DBExec($c, "lock table removabletable", "DBUpdateRemovableSpecs(lock)");

		$ret=2;
		$time=time();
		if(isset($param['file']) && is_numeric($param['file'])&& isset($param['specs'])){
				$sql="update removabletable set removablespecs='".$param['specs']."' where removableid=".$param['file'];
				DBExec($c, $sql, "DBUpdateRemovableSpecs(update removabletable)");
		}

		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}
function DBUpdateRemovableGram($param, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBUpdateRemovableGram(begin)");
		}
		DBExec($c, "lock table removabletable", "DBUpdateRemovableGram(lock)");

		$ret=2;
		$time=time();
		if(isset($param['file']) && is_numeric($param['file'])&& isset($param['gram'])){
				$sql="update removabletable set removableodontogram='".$param['gram']."' where removableid=".$param['file'];
				DBExec($c, $sql, "DBUpdateRemovableGram(update removabletable)");
		}

		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}
//para modificacion de tabla dentaltable de admision
function DBUpdateDentalExamRemovible($param, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBUpdateDentalExamRemovible(begin)");
		}
		DBExec($c, "lock table dentalexamtable", "DBUpdateDentalExamRemovible(lock)");

		$ret=2;
		$time=time();
		if(isset($param['dentalid']) && is_numeric($param['dentalid']) && isset($param['hygiene']) &&
			isset($param['faces']) && isset($param['profile']) && isset($param['tez']) ){

				$sql="update dentalexamtable set dentalfaces='".$param['faces'].
				"', dentalprofile='".$param['profile']."', dentaltez='".$param['tez'].
				"', dentalhygiene='".$param['hygiene'].
				"' where dentalid=".$param['dentalid'];
				DBExec($c, $sql, "DBUpdateDentalExamRemovible(update dentalexamtable)");
		}

		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}
//funcion para eliminar la tabla de prostodoncia fija II
function DBDropFixedTable() {
    //conexcion de la base de datos..
	 $c = DBConnect();

	 $r = DBExec($c, "drop table \"fixedtable\"", "DBDropFixedTable(drop table)");

}
function DBCreateFixedTable() {
	 $c = DBConnect();
	 $conf = globalconf();
	 if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
	 $r = DBExec($c, "
CREATE TABLE \"fixedtable\" (
				\"fixedid\" serial NOT NULL,                	  -- (id de ficha clinica prostodoncia fija)
				\"fixedgrade\" varchar(20) DEFAULT '',					-- (curso)
				\"fixedyear\" varchar(20) DEFAULT '',						-- (gestion)
				\"fixeddiagnosis\" varchar(300) DEFAULT '',			-- (diagnostico)
				\"fixedetiology\" varchar(100) DEFAULT '',      -- (etiologia)
        \"fixedforecast\" varchar(100) DEFAULT '',   	  -- (pronostico)
        \"fixedtreatment\" varchar(100) DEFAULT '',     -- (plan de tratamiento)
        \"fixedprocedures\" text DEFAULT '',       			-- (tabla de procedimientos)
        \"fixedodontogram\" text DEFAULT '',            -- (odontograma)
				\"fixedrev\"	text DEFAULT '',									-- (ID cola de docentes revisores)
        \"fixedstatus\" varchar(50) DEFAULT '',       	-- (estado new, process, end, fail)

				\"patientid\" int4 NOT NULL,      								-- (id del paciente)
				\"student\" int4 NOT NULL,                        -- (id del estudiate)
				\"remissionid\" int4 NOT NULL,                    -- (id de la remission)
				\"teacher\" int4 NOT NULL,                        -- (id del docente)
				\"clinicalid\" int4 NOT NULL,
			  \"startdatetime\" int4 DEFAULT -1 NOT NULL, -- (indica la fecha de inicio de ficha clinica)
			  \"enddatetime\" int4 DEFAULT -1 NOT NULL, -- (indica la fecha de finalizacion)
			  \"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
        CONSTRAINT \"fixed_pkey\" PRIMARY KEY (\"fixedid\", \"student\", \"teacher\"),
				CONSTRAINT \"remission_fk\" FOREIGN KEY (\"patientid\", \"student\", \"remissionid\", \"clinicalid\")
								REFERENCES \"remissiontable\" (\"patientid\", \"examined\", \"remissionid\", \"clinicalid\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
				CONSTRAINT \"specialty_fk\" FOREIGN KEY (\"teacher\", \"clinicalid\")
								REFERENCES \"specialtytable\" (\"userid\", \"clinicalid\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
)", "DBCreateFixedTable(create table)");

	$r = DBExec($c, "REVOKE ALL ON \"fixedtable\" FROM PUBLIC", "DBCreateFixedTable(revoke public)");
	$r = DBExec($c, "GRANT ALL ON \"fixedtable\" TO \"".$conf["dbuser"]."\"", "DBCreateFixedTable(grant sihcouser)");
	$r = DBExec($c, "CREATE INDEX \"fixed_index\" ON \"fixedtable\" USING btree ".
				"(\"fixedid\" int4_ops, \"patientid\" int4_ops, \"student\" int4_ops)",
				"DBCreateFixedTable(create fixed_index)");
}
//funcion para crear un nuevo registro de prostodoncia fija
function DBNewFixed($param , $c=null){

		if(isset($param['patientid']) && !isset($param['patient'])) $param['patient']=$param['patientid'];
		if(isset($param['studentid']) && !isset($param['student'])) $param['student']=$param['studentid'];
		if(isset($param['remissionid']) && !isset($param['remission'])) $param['remission']=$param['remissionid'];
		if(isset($param['teacherid']) && !isset($param['teacher'])) $param['teacher']=$param['teacherid'];
		if(isset($param['clinicalid']) && !isset($param['clinical'])) $param['clinical']=$param['clinicalid'];

		//if(isset($param['pediatricsiid']) && !isset($param['id'])) $param['id']=$param['pediatricsiid'];
		if(isset($param['fixedgrade']) && !isset($param['grade'])) $param['grade']=$param['fixedgrade'];
		if(isset($param['fixedyear']) && !isset($param['year'])) $param['year']=$param['fixedyear'];
		if(isset($param['fixeddiagnosis']) && !isset($param['diagnosis'])) $param['diagnosis']=$param['fixeddiagnosis'];
		if(isset($param['fixedetiology']) && !isset($param['etiology'])) $param['etiology']=$param['fixedetiology'];
		if(isset($param['fixedforecast']) && !isset($param['forecast'])) $param['forecast']=$param['fixedforecast'];
		if(isset($param['fixedtreatment']) && !isset($param['treatment'])) $param['treatment']=$param['fixedtreatment'];
		if(isset($param['fixedprocedures']) && !isset($param['procedures'])) $param['procedures']=$param['fixedprocedures'];
		if(isset($param['fixedodontogram']) && !isset($param['odontogram'])) $param['odontogram']=$param['fixedodontogram'];
		if(isset($param['fixedstatus']) && !isset($param['status'])) $param['status']=$param['fixedstatus'];

		$ac=array('patient', 'student', 'remission', 'teacher', 'clinical');

		$ac1=array('grade', 'year', 'diagnosis', 'etiology', 'forecast', 'treatment', 'procedures', 'odontogram', 'status');
		$typei['patient']=-1;
		$typei['student']=-1;
		$typei['remission']=-1;
		$typei['teacherid']=-1;//admin
		$typei['clinical']=2;//clinica prostodoncia fija


		foreach($ac as $key) {
			if(!isset($param[$key]) || $param[$key]=="") {
				MSGError("DBNewFixed param error: $key not found");
				return false;
			}
			if(isset($typei[$key]) && !is_numeric($param[$key])) {
				MSGError("DBNewFixed param error: $key is not numeric");
				return false;
			}
			$$key = myhtmlspecialchars($param[$key]);
		}

		$grade='';
		$year='';
		$diagnosis='';
		$etiology='';
		$forecast='';
		$treatment='';
		$procedures='';
		$odontogram='';

		$status='new';

		$updatetime=-1;
		foreach($ac1 as $key) {
			if(isset($param[$key])) {
				$$key = myhtmlspecialchars($param[$key]);
				if(isset($typei[$key]) && !is_numeric($param[$key])) {
					MSGError("DBNewFixed param error: $key is not numeric");
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
			DBExec($c, "begin work", "DBNewFixed(begin)");
		}
		DBExec($c, "lock table fixedtable", "DBNewFixed(lock)");

		$ret=1;

		//antes de registrar chekear las claves foraneas
		$sql = "select * from fixedtable where patientid=$patient and remissionid= $remission";
		$a = DBGetRow ($sql, 0, $c);
			if($teacher==-1){
				if($a!=null){

					$teacher=$a['teacher'];
					$grade=$a['fixedgrade'];
					$year=$a['fixedyear'];
					$diagnosis=$a['fixeddiagnosis'];
					$etiology=$a['fixedetiology'];
					$forecast=$a['fixedforecast'];
					$treatment=$a['fixedtreatment'];
					$procedures=$a['fixedprocedures'];
					$odontogram=$a['fixedodontogram'];
					$status=$a['fixedstatus'];

				}else{
					$teacher=0;
				}
			}
	      	//para insercion o actulizacion
			if ($a == null) {
				  $ret=2;

	    		$sql = "insert into fixedtable(fixedgrade, fixedyear, fixeddiagnosis, fixedetiology, fixedforecast, ".
					"fixedtreatment, fixedprocedures, fixedodontogram, fixedstatus, ".
					"patientid, student, remissionid, teacher, clinicalid) values (".
					"'$grade', '$year','$diagnosis','$etiology','$forecast','$treatment','$procedures','$odontogram', ".
					"'$status', $patient, $student, $remission, $teacher, $clinical)";

					DBExec ($c, $sql, "DBNewFixed(insert)");
	    		if($cw) {
	    				DBExec ($c, "commit work");
	    		}
	    		LOGLevel ("Ficha Prostodoncia Fija II $remission registrado.",2);
			} else {
				if($updatetime > $a['updatetime']) {
					$ret=2;

					$sql = "update fixedtable set fixedgrade='$grade', fixedyear='$year', fixeddiagnosis='$diagnosis', ".
					"fixedetiology='$etiology', fixedforecast='$forecast', ".
					"fixedtreatment='$treatment', fixedprocedures='$procedures', ".
					"fixedodontogram='$odontogram', fixedstatus='$status', ".

					"student=$student, teacher=$teacher, updatetime=$updatetime ".
					"where patientid=$patient and remissionid=$remission";

					$r = DBExec ($c, $sql, "DBNewFixed(update)");
					if($cw) {
						DBExec ($c, "commit work");
					}
					LOGLevel("Ficha Prostodoncia Fija II $remission actualizado.",2);
				}
			}

		if($cw) DBExec($c, "commit work");
		return $ret;
}
//funcion para eliminar una remision equivocada
function DBDeleteFixed($remission){

	$c = DBConnect();
	DBExec($c, "begin work");
	DBExec($c, "lock table fixedtable");
	$sql = "select * from fixedtable where remissionid=$remission for update";
	$a = DBGetRow ($sql, 0, $c);
	$yes=false;
	if ($a != null) {
			//echo "yes delete";
      $sql = "delete from fixedtable where remissionid=$remission";
			DBExec ($c, $sql);
			DBExec($c, "commit work");//para el commit de exito
			$yes=true;
	} else {
		echo "no delete";
		DBExec($c, "rollback work");
		LOGLevel("Fixid remissionid = $remission could not be removed.", 1);
		return false;
	}
	if($yes)
		DBDeleteObservation($remission);
}
//funcion para eliminar una remision equivocada
function DBDeleteRemovable($remission){

	$c = DBConnect();
	DBExec($c, "begin work");
	DBExec($c, "lock table removabletable");
	$sql = "select * from removabletable where remissionid=$remission for update";
	$a = DBGetRow ($sql, 0, $c);
	$yes=false;
	if ($a != null) {
			//echo "yes delete";
      $sql = "delete from removabletable where remissionid=$remission";
			DBExec ($c, $sql);
			DBExec($c, "commit work");//para el commit de exito
			$yes=true;
	} else {
		echo "no delete";
		DBExec($c, "rollback work");
		LOGLevel("Fixid remissionid = $remission could not be removed.", 1);
		return false;
	}
	if($yes)
		DBDeleteObservation($remission);
}
function DBFixedInfo($id, $c=null) {

	$sql = "select *from fixedtable where fixedid=$id";

	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");

		return null;
	}

	$ob=DBObservationInfo($a['fixedid'],$a['remissionid']);
	if($ob!=null){
		$a=array_merge($a, $ob);
	}

	$conf=globalconf();
	if($a['fixedodontogram']!=null)
		$a['fixedodontogram'] = decryptData($a['fixedodontogram'], $conf["key"]);
	if($a['fixedprocedures']!=null)
		$a['fixedprocedures'] = decryptData($a['fixedprocedures'], $conf["key"]);
	$a=clearfixed($a);
	return $a;
}
function DBRemovableInfo($id, $c=null) {

	$sql = "select *from removabletable where removableid=$id";

	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");

		return null;
	}

	$ob=DBObservationInfo($a['removableid'],$a['remissionid']);
	if($ob!=null){
		$a=array_merge($a, $ob);
	}

	$a=clearremovable($a);
	return $a;
}
function clearremovable($a){

	$r=explode(']',$a['removablediagnosis']);
	$size=count($r);

	$akey = array('diagnosticobucal','diagnosticodeque','diagnosticoduracion','diagnosticoresultado', 'diagnosticoproblema', 'diagnosticodiente');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}

	$r=explode(']',$a['removablebraces']);
	$size=count($r);

	$akey = array('bracesoption','bracesobs');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}
	$r=explode(']',$a['removablekenedy']);
	$size=count($r);
	if($size>4){
		$akey = array('kenedysc','kenedysm','kenedyic','kenedyim');
		for ($i=0; $i <$size-1 ; $i++) {
			$r2=explode('[',$r[$i]);
			$a[$akey[$i]]=trim($r2[1]);
		}
	}

	$r=explode(']',$a['removablespecs']);
	$size=count($r);
	if($size>8){
		$akey = array('apoyos','retencion','reciprocidad','conector','indirecta','planos','base','contornear','protesis','protesisfecha');
		for ($i=0; $i <$size-1 ; $i++) {
			$r2=explode('[',$r[$i]);
			$a[$akey[$i]]=trim($r2[1]);
		}
	}
	$r=explode(']',$a['removableprocedures']);
	$size=count($r);
	if($size>29){
		$akey = array('valortrabajo','trabajo','remopro1','remopro2','remopro3','remopro4',
		'remopro5','remopro6','remopro7','remopro8','remopro9','remopro10','remopro11','remopro12',
		'remopro13','remopro14','remopro15','remopro16','remopro17','remopro18','remopro19',
		'remopro20','remopro21','remopro22','remopro23','remopro24','obstrabajo','notatrabajo','firmtrabajo');
		$remofirmyes=0;
		for ($i=0; $i <$size-1 ; $i++) {
			$r2=explode('[',$r[$i]);
			if(trim($r2[1])=='true'){
				$remofirmyes++;
			}
			$a[$akey[$i]]=trim($r2[1]);
			$a['remofirmyes']=$remofirmyes;
			if(strpos($akey[$i],'remopro')!==false){
				$desc=explode('=',trim($r2[1]));
				$size2=count($desc);
				if($size2==2){
					$a['sel'.$akey[$i]]=$desc[0];
					$a['tea'.$akey[$i]]=$desc[1];
				}
			}
		}
	}

	$r=explode(']',$a['removablesaliva']);
	$size=count($r);

	$akey = array('salivaoption','salivaobs');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}

	$r=explode(']',$a['removableinterference']);
	$size=count($r);

	$akey = array('milohoideadesc','milohoideaobs', 'alveolaresdesc', 'alveolaresdesc', 'alveolaresobs', 'tuberosidaddesc', 'tuberosidadobs', 'alveolardesc', 'alveolarobs');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}
	$r=explode(']',$a['removablepalate']);
	$size=count($r);

	$akey = array('palateoption','palateobs');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}

	$r=explode(']',$a['removableanomalies']);
	$size=count($r);

	$akey = array('anomaliesoption','anomaliesobs');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}

	$r=explode(']',$a['removableparalyzer']);
	$size=count($r);

	$akey = array('parpilar1', 'parpilar2', 'parpilar3', 'parpilar4', 'parotros', 'parfavorable', 'parprobables', 'paralteraciones', 'parobs');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}

	$r=explode(']',$a['removableradiographic']);
	$size=count($r);

	$akey = array('radpilar1', 'radpilar2', 'radpilar3', 'radpilar4', 'radhueso');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}
	return $a;
}
function procedureremovable($post, $info, $user, $n, $row, $col){
	$remopro='';

	if($post=='NULL'||($post!='NULL'&&$post=='')){
      if(isset($info["selremopro$n"])&&isset($info["tearemopro$n"])){
        if($info["tearemopro$n"]!=$user){
          if($post!=$info["selremopro$n"]){
              $userinf=DBUserInfo($info["tearemopro$n"]);
              echo "No se puede anular ya se revisó por Dr(a): ".$userinf['userfullname']." fila $row columna $col";
              $remopro=$info["selremopro$n"].'='.$info["tearemopro$n"];
          }else{
            $remopro=$post.'='.$info["tearemopro$n"];
          }
        }else{
          $remopro=$post.'='.$info["tearemopro$n"];
        }
      }else{
        if($post!='NULL') $remopro='true';
        else $remopro='false';
      }
  }elseif($post!='NULL'&&$post!=''){
    if(isset($info["selremopro$n"])&&isset($info["tearemopro$n"])){
      if($info["tearemopro$n"]!=$user){
        if($post!=$info["selremopro$n"]){
            $remopro=$post.'='.$user;
        }else{
          $remopro=$post.'='.$info["tearemopro$n"];
        }
      }else{
        $remopro=$post.'='.$info["tearemopro$n"];
      }
    }else{
      $remopro=$post.'='.$user;
    }
  }
	return $remopro;
}
function clearfixed($a){

	$r=explode(']',$a['fixedtreatment']);
	$size=count($r);

	$akey = array('tratamiento1','tratamiento2','tratamiento3','tratamiento4');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}

	$r=explode('[-]',$a['fixedprocedures']);
	$size=count($r);
	$vobo=0;
	$material=0;
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode(':<=>:',$r[$i]);
		$size2=count($r2);
		for ($j=0; $j < $size2; $j++) {
			$r3=explode('<=>',$r2[$j]);

			$a[trim($r3[0])]=trim($r3[1]);
			if($j==1&&$r3[1]=='f'){
				$vobo++;
			}
			if($j==2&&$r3[1]=='f'){
				$material++;
			}
		}
	}
	$a['vobo']=$vobo;
	$a['material']=$material;
	return $a;
}
function DBAllFixedTeacherInfo($user, $clinical, $limit=100){
	$sql = "select c.clinicalid as clinical, r.remissionid as remission, fi.fixedid as ficha, p.patientfullname as patientfullname,
de.motconsult as consult, c.clinicalspecialty as clinicalname, u.userfullname as student,
fi.fixeddiagnosis as diagnosis, fi.fixedstatus as status, fi.updatetime as time from fixedtable
as fi, usertable as u, patienttable as p, clinicaltable as c, dentalexamtable as de, remissiontable as r
where (fi.teacher=$user or fi.fixedrev LIKE '%[$user]%') and fi.fixedstatus!='new' and p.patientid=fi.patientid and de.patientid=r.patientid and
de.dentalid=r.patientdentalid and r.remissionid=fi.remissionid and fi.clinicalid=$clinical and c.clinicalid=r.clinicalid and
r.examined=fi.student and u.usernumber=r.examined order by fi.updatetime desc limit $limit";

	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBAllFixedTeacherInfo(get all fixed)");
	$n = DBnlines($r);

	$a = array();
	for ($i=0;$i<$n;$i++) {
		$a[$i] = DBRow($r,$i);
		//para sacar la observacion de cada ficha clinica
		$ob=DBObservationInfo2($a[$i]['ficha'], $a[$i]['remission']);
		if($ob!=null)
			$a[$i]=array_merge($a[$i],$ob);
		$a[$i]['file']='fixed';
	}



	return $a;
}
function DBAllRemovableTeacherInfo($user, $clinical, $limit=100){
	$sql = "select c.clinicalid as clinical, r.remissionid as remission, re.removableid as ficha, p.patientfullname as patientfullname,
de.motconsult as consult, c.clinicalspecialty as clinicalname, u.userfullname as student,
re.removablestatus as status, re.updatetime as time from removabletable
as re, usertable as u, patienttable as p, clinicaltable as c, dentalexamtable as de, remissiontable as r
where (re.teacher=$user or re.removablerev LIKE '%[$user]%') and re.removablestatus!='new' and p.patientid=re.patientid and de.patientid=r.patientid and
de.dentalid=r.patientdentalid and r.remissionid=re.remissionid and re.clinicalid=$clinical and c.clinicalid=r.clinicalid and
r.examined=re.student and u.usernumber=r.examined order by re.updatetime desc limit $limit";

	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBAllRemovableTeacherInfo(get all removable)");
	$n = DBnlines($r);

	$a = array();
	for ($i=0;$i<$n;$i++) {
		$a[$i] = DBRow($r,$i);
		//para sacar la observacion de cada ficha clinica
		$ob=DBObservationInfo2($a[$i]['ficha'], $a[$i]['remission']);
		if($ob!=null)
			$a[$i]=array_merge($a[$i],$ob);
		$a[$i]['file']='removable';
		//diagnostico
		$a[$i]['diagnosis']='';
	}

	return $a;
}
//funcion para saber si el docente puede revisar o no, una
//ficha clinica de prostodoncia fija
/*function DBTeacherRevInfo($table, $teacher, $rev=false){
	$sql="select $table"."id, "."$table"."rev"." from $table"."table where $table"."rev LIKE '%[$teacher]%'";
	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBTeacherRevInfo(get rev fixed)");
	$n = DBnlines($r);

	return $rev;
}*/

function DBEvaluateFixed($desc, $evaluated, $accepted, $status, $record, $c=null){
	$cw = false;
	if($c == null) {
		$cw = true;
		$c = DBConnect();
		DBExec($c, "begin work", "DBEvaluateFixed(begin)");
	}
	$updatetime=time();

	$ret=2;
	$sql = "update fixedtable set fixedstatus='$status', ";
	if($status=='end')
		$sql.="enddatetime=$updatetime, ";
	$sql.="updatetime=$updatetime where fixedid=$record";

	DBExec ($c, $sql, "DBEvaluateFixed(update fixed)");
	//DBExec($c, "lock table observationtable", "DBEvaluate(lock)");
	$b=DBFixedInfo($record);
	$remission=$b['remissionid'];
	$sql = "update observationtable set observationdesc='$desc', observationevaluated='$evaluated', ".
	"observationaccepted='$accepted', updatetime=$updatetime where (fileid=$record and remissionid=$remission) and observationid=(select max(observationid) ".
	"from observationtable where fileid=$record and remissionid=$remission)";

	DBExec ($c, $sql, "DBEvaluateFixed(update observation)");

	if($cw) {
			DBExec ($c, "commit work");
	}

	return $ret;
}
function DBEvaluateRemovable($desc, $evaluated, $accepted, $status, $record, $c=null){
	$cw = false;
	if($c == null) {
		$cw = true;
		$c = DBConnect();
		DBExec($c, "begin work", "DBEvaluateRemovable(begin)");
	}
	$updatetime=time();

	$ret=2;
	$sql = "update removabletable set removablestatus='$status', ";
	if($status=='end')
		$sql.="enddatetime=$updatetime, ";
	$sql.="updatetime=$updatetime where removableid=$record";

	DBExec ($c, $sql, "DBEvaluateRemovable(update removable)");
	//DBExec($c, "lock table observationtable", "DBEvaluate(lock)");
	$b=DBRemovableInfo($record);
	$remission=$b['remissionid'];
	$sql = "update observationtable set observationdesc='$desc', observationevaluated='$evaluated', ".
	"observationaccepted='$accepted', updatetime=$updatetime where (fileid=$record and remissionid=$remission) and observationid=(select max(observationid) ".
	"from observationtable where fileid=$record and remissionid=$remission)";

	DBExec ($c, $sql, "DBEvaluateRemovable(update observation)");

	if($cw) {
			DBExec ($c, "commit work");
	}

	return $ret;
}
function DBFixedInfo2($id, $c=null) {

	$sql = "select c.clinicalid as clinical, r.remissionid as remission, fi.fixedid as ficha, p.patientfullname as patientfullname,
de.motconsult as consult, c.clinicalspecialty as clinicalname, u.userfullname as student,
fi.fixedstatus as status, fi.teacher as teacher, fi.updatetime as time from fixedtable
as fi, usertable as u, patienttable as p, clinicaltable as c, dentalexamtable as de, remissiontable as r
where fi.fixedid=$id and fi.fixedstatus!='new' and p.patientid=fi.patientid and de.patientid=r.patientid and
de.dentalid=r.patientdentalid and r.remissionid=fi.remissionid and c.clinicalid=r.clinicalid and
r.examined=fi.student and u.usernumber=r.examined";

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
function DBRemovableInfo2($id, $c=null) {

	$sql = "select c.clinicalid as clinical, r.remissionid as remission, re.removableid as ficha, p.patientfullname as patientfullname,
de.motconsult as consult, c.clinicalspecialty as clinicalname, u.userfullname as student,
re.removablestatus as status, re.teacher as teacher, re.updatetime as time from removabletable
as re, usertable as u, patienttable as p, clinicaltable as c, dentalexamtable as de, remissiontable as r
where re.removableid=$id and re.removablestatus!='new' and p.patientid=re.patientid and de.patientid=r.patientid and
de.dentalid=r.patientdentalid and r.remissionid=re.remissionid and c.clinicalid=r.clinicalid and
r.examined=re.student and u.usernumber=r.examined";

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
function DBRemovableUpdateProcedure($param, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBRemovableUpdateProcedure(begin)");
		}
		DBExec($c, "lock table removabletable", "DBRemovableUpdateProcedure(lock)");

		$ret=2;
		$time=time();
		if(isset($param['file']) && is_numeric($param['file']) && isset($param['procedures'])){
				$sql="update removabletable set removableprocedures='".$param['procedures']."' where removableid=".$param['file'];
				DBExec($c, $sql, "DBRemovableUpdateProcedure(update removabletable)");
		}

		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}
function DBFixedUpdateProcedure($param, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBFixedUpdateProcedure(begin)");
		}
		DBExec($c, "lock table fixedtable", "DBFixedUpdateProcedure(lock)");

		$ret=2;
		$time=time();
		if(isset($param['file']) && is_numeric($param['file']) && isset($param['procedures'])){
				$sql="update fixedtable set fixedprocedures='".$param['procedures']."' where fixedid=".$param['file'];
				DBExec($c, $sql, "DBFixedUpdateProcedure(update fixedtable)");
		}

		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}

function DBNewFinalInput($usernumber, $param, $c=null) {

      if(isset($param['fileid']) && !isset($param['file'])) $param['file']=$param['fileid'];
      if(isset($param['removableinputfile']) && !isset($param['inputfilepath'])) $param['inputfilepath']=$param['probleminputfile'];
      if(isset($param['removableinputfilename']) && !isset($param['inputfilename'])) $param['inputfilename']=$param['probleminputfilename'];

      $ac=array('file');
      $type['file']=-1;
      $type['updatetime']=1;
      $ac1=array('updatetime','inputfilename','inputfilepath');

      foreach($ac as $key) {

          if(!isset($param[$key])) {
              MSGError("DBNewFinalInput param error: $key is not set");
              return false;
          }
          if(isset($type[$key]) && !is_numeric($param[$key])) {
              MSGError("DBNewFinalInput param error: $key is not numeric");
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
    	           MSGError("DBNewFinalInput param error: $key is not numeric");
    	           return false;
              }
              $$key = myhtmlspecialchars($param[$key]);
          }
      }

      $t = time();
      if($updatetime <= 0)
        $updatetime=$t;
      $inputhash = '';

      $sql2 = "select * from removabletable where removableid=$file for update";

      $cw = false;
      if($c == null) {
          $cw = true;
          $c = DBConnect();
          DBExec($c, "begin work", "DBNewFinalInput(transaction)");
      }
      $r = DBExec ($c, $sql2, "DBNewFinalInput(get removable for update)");
      $n = DBnlines($r);//0
      $ret=1;//empieza en 1
      $oldfullname='';
      $deservesupdatetime=false;
      if ($n == 0) {
					echo "no encontrado error";
      }else {
          $lr = DBRow($r,0);
          $t = $lr['updatetime'];
          $inputhash = $lr['removableinputfilehash'];
      }




      if($updatetime > $t) {

          if(substr($inputfilepath,0,7)!="base64:") {

              if ($inputfilepath != "") {

						      ////funcion que retorna el pequeño sha1
    	           $hash = myshorthash(file_get_contents($inputfilepath));
    	           if($hash != $inputhash) {

    	                $oldoid='';
    	                if(isset($lr))
    	                     $oldoid = $lr['removableinputfile'];
                        //pg_lo_import () crea un nuevo objeto grande en la base de datos usando un
                        //archivo en el sistema de archivos como fuente de datos. devuelve el oid. dependiendo de la version 7.2 o < 4.2.0
    	                if (($oid1 = DB_lo_import($c, $inputfilepath)) === false) {

    	                      DBExec($c, "rollback work", "DBNewFinalInput(rollback-input)");
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
    	              $oid1 = $lr['removableinputfile'];
             }

          } else {

              $inputfilepath = base64_decode(substr($inputfilepath,7));
              $hash = myshorthash($inputfilepath);

              if($hash != $inputhash) {

                  $oldoid='';
                  if(isset($lr))
                	  $oldoid = $lr['removableinputfile'];
                  //importa un texto a un archivo creado en la base de datos y devuelve el oid del archivo
                  if (($oid1 = DB_lo_import_text($c, $inputfilepath)) == null) {
                	  DBExec($c, "rollback work", "DBNewFinalInput(rollback-i-import)");
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
        	         $oid1 = $lr['removableinputfile'];
          }
					if ($inputfilename != "") {
              $deservesupdatetime=true;
              DBExec ($c, "update removabletable set removableinputfilename='$inputfilename' where ".
    	         "removableid=$file ", "DBNewFinalInput(update inputfilename)");
          }
          if ($inputfilepath != "") {
              $deservesupdatetime=true;
              DBExec ($c, "update removabletable set removableinputfile=$oid1, removableinputfilehash='$inputhash' where removableid=$file ", "DBNewFinalInput(update inputfile)");
          }

          if($deservesupdatetime) {
              DBExec ($c, "update removabletable set updatetime=" . $updatetime .
    	         " where removableid=$file ", "DBNewFinalInput(time)");
          }
          if($cw)
              DBExec($c, "commit work", "DBNewFinalInput(commit)");
          LOGLevel ("Removable $file (inputfile=$inputfilename) update ($usernumber)", 2);
          $ret=2;
      } else {

          if($cw)
              DBExec($c, "commit work", "DBNewFinalInput(commit)");
      }
      return $ret;
}
//funcion para importar pdf con datos de conclusion
function DBNewFinalInputData($usernumber, $param, $c=null) {

      if(isset($param['fileid']) && !isset($param['file'])) $param['file']=$param['fileid'];
      if(isset($param['removableinputfile']) && !isset($param['inputfilepath'])) $param['inputfilepath']=$param['probleminputfile'];
      if(isset($param['removableinputfilename']) && !isset($param['inputfilename'])) $param['inputfilename']=$param['probleminputfilename'];

			if(isset($param['meeting-time']) && !isset($param['updatetime'])) $param['updatetime']=$param['updatetime'];
      if(isset($param['teacherid']) && !isset($param['teacher'])) $param['teacher']=$param['teacherid'];

      $ac=array('file', 'teacher');
      $type['file']=-1;
      $type['teacher']=-1;
      $type['updatetime']=1;
      $ac1=array('updatetime','inputfilename','inputfilepath', 'table');

      foreach($ac as $key) {

          if(!isset($param[$key])) {
              MSGError("DBNewFinalInput param error: $key is not set");
              return false;
          }
          if(isset($type[$key]) && !is_numeric($param[$key])) {
              MSGError("DBNewFinalInput param error: $key is not numeric");
              return false;
          }
          $$key = myhtmlspecialchars($param[$key]);
      }
      $inputfilename='';
      $inputfilepath='';
      $updatetime=-1;
			$table='';
      foreach($ac1 as $key) {

          if(isset($param[$key])) {
              if(isset($type[$key]) && !is_numeric($param[$key])) {
    	           MSGError("DBNewFinalInput param error: $key is not numeric");
    	           return false;
              }
              $$key = myhtmlspecialchars($param[$key]);
          }
      }
			if($table==''){
					return 0;
			}
      $t = $updatetime;//time();
      if($updatetime <= 0)
        $updatetime=$t;
      $inputhash = '';

      $sql2 = "select * from ".$table."table where ".$table."id=$file for update";

      $cw = false;
      if($c == null) {
          $cw = true;
          $c = DBConnect();
          DBExec($c, "begin work", "DBNewFinalInputData(transaction)");
      }
      $r = DBExec ($c, $sql2, "DBNewFinalInputData(get $table for update)");
      $n = DBnlines($r);//0
      $ret=1;//empieza en 1
      $oldfullname='';
      $deservesupdatetime=false;
      if ($n == 0) {
					echo "no encontrado error";
      }else {
          $lr = DBRow($r,0);
          $t = $lr['updatetime'];
          $inputhash = $lr[$table.'inputfilehash'];
      }




      if($updatetime >= $t) {

          if(substr($inputfilepath,0,7)!="base64:") {

              if ($inputfilepath != "") {

						      ////funcion que retorna el pequeño sha1
    	           $hash = myshorthash(file_get_contents($inputfilepath));
    	           if($hash != $inputhash) {

    	                $oldoid='';
    	                if(isset($lr))
    	                     $oldoid = $lr[$table.'inputfile'];
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
    	              $oid1 = $lr[$table.'inputfile'];
             }

          } else {

              $inputfilepath = base64_decode(substr($inputfilepath,7));
              $hash = myshorthash($inputfilepath);

              if($hash != $inputhash) {

                  $oldoid='';
                  if(isset($lr))
                	  $oldoid = $lr[$table.'inputfile'];
                  //importa un texto a un archivo creado en la base de datos y devuelve el oid del archivo
                  if (($oid1 = DB_lo_import_text($c, $inputfilepath)) == null) {
                	  DBExec($c, "rollback work", "DBNewFinalInput(rollback-i-import)");
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
        	         $oid1 = $lr[$table.'inputfile'];
          }
					if ($inputfilename != "") {
              $deservesupdatetime=true;
              DBExec ($c, "update ".$table."table set ".$table."inputfilename='$inputfilename' where ".
    	         "".$table."id=$file ", "DBNewFinalInputData(update inputfilename)");
          }
          if ($inputfilepath != "") {
              $deservesupdatetime=true;
              DBExec ($c, "update ".$table."table set ".$table."inputfile=$oid1, ".$table."inputfilehash='$inputhash' where ".$table."id=$file ", "DBNewFinalInputData(update inputfile)");
          }

          if($deservesupdatetime) {
              DBExec ($c, "update ".$table."table set updatetime=" . $updatetime .
    	         " where ".$table."id=$file ", "DBNewFinalInput(time)");
					}
          if($cw)
              DBExec($c, "commit work", "DBNewFinalInputData(commit)");
          LOGLevel ("$table $file (inputfile=$inputfilename) update ($usernumber)", 2);
          $ret=2;
      } else {

          if($cw)
              DBExec($c, "commit work", "DBNewFinalInputData(commit)");
      }

      return $ret;
}
//finalizar tabla
function DBUpdateTableToEnd($table, $file, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBUpdatePatientPediatrics(begin)");
		}
		DBExec($c, "lock table ".$table."table", "DBUpdatePatientPediatrics(lock)");

		$ret=2;
		$time=time();

		$sql="update ".$table."table set ".$table."status='end' where ".$table."id=$file";
		DBExec($c, $sql, "DBUpdatePatientPediatrics(update patientadmissiontable)");

		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}
?>
