<?php
//funcion para eliminar la tabla de periodoncia
function DBDropPediatricsiTable() {
    //conexcion de la base de datos..
	 $c = DBConnect();

	 $r = DBExec($c, "drop table \"pediatricsitable\"", "DBDropPeriodonticsiiTable(drop table)");

}
function DBCreatePediatricsiTable() {
	 $c = DBConnect();
	 $conf = globalconf();
	 if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
	 $r = DBExec($c, "
CREATE TABLE \"pediatricsitable\" (
				\"pediatricsiid\" serial NOT NULL,                	-- (id de ficha clinica odontoperidria i)
				\"pediatricsirefer\" varchar(200) DEFAULT '',				-- (quien lo refiere)
				\"pediatricsireason\" text DEFAULT '',        			-- (por que razón)
        \"pediatricsivitalsigns\" text DEFAULT '',   				-- (signos vitales)
        \"pediatricsimotconsult\" text DEFAULT '',          -- (motivo de la consulta)
        \"pediatricsiattitude\" text DEFAULT '',       			-- (actitud del niño y de sus padres en esta situacion odontologica)
        \"pediatricsiauthorization\" varchar(50) DEFAULT '',     -- (autorizacion de los padres o encargado)
        \"pediatricsiarmchair\" int4 DEFAULT -1,   							 -- (numero de sillon)
				\"pediatricsiprior\" varchar(300) DEFAULT '',       		 -- (del ñino atencion previa)
				\"pediatricsilastattention\" varchar(100) DEFAULT '',    -- (fecha de la ultima atencion)
				\"pediatricsiperiodic\" varchar(300) DEFAULT '',       	 -- (atencion periodica)
				\"pediatricsiexperiences\" varchar(300) DEFAULT '',      -- (experiencias traumaticas)
				\"pediatricsiodontoattitude\" varchar(300) DEFAULT '',   -- (actitud del niño frente a ala odontologia)
				\"pediatricsidiseases\" varchar(300) DEFAULT '',         -- (enfermedades del: )
				\"pediatricsiinterventions\" varchar(300) DEFAULT '',    -- (intervenciones quirurgicas)
				\"pediatricsiexplanations\" varchar(300) DEFAULT '',     -- (con explicaciones previas)
				\"pediatricsiexperiencesinye\" varchar(300) DEFAULT '',      -- (experiencias traumaticas inyecciones)
				\"pediatricsigodoctor\" varchar(300) DEFAULT '',         -- (va la medico periodicamente)
				\"pediatricsiconsistency\" varchar(300) DEFAULT '',      -- (tipo y consistencia)
				\"pediatricsidieta\" text DEFAULT '',       		 				 -- (Dieta)
				\"pediatricsibacterialcontrol\" text DEFAULT '',     -- (control mecanico de placa bacteriana)
				\"pediatricsifluoridetherapy\" text DEFAULT '',       -- (terapia con fluoruros)
				\"pediatricsisealants\" varchar(300) DEFAULT '',       	 -- (selladores)
				\"pediatricsioralhabits\" varchar(300) DEFAULT '',       -- (habitos orales)
				\"pediatricsiresumefather\" varchar(300) DEFAULT '',       -- (actutud de los padres frente al interrogatorio)
				\"pediatricsifirstvisit\" text DEFAULT '',        				 -- (primera visita)
				\"pediatricsifirstsynthesis\" varchar(500) DEFAULT '',     -- (sintesis de la historia y de la primera visita con el objeto de orientar el trameinto)
				\"pediatricsiodontogram\" text DEFAULT '',                 -- (odontogram)
				\"pediatricsiodontometa\" text DEFAULT '',                 -- (para la asignacion de metadatos al odontograma)
				\"pediatricsidiagnosisradiographic\" text DEFAULT '',       -- (para quinto año diagnostico radiográfico)
				\"pediatricsioleary\" text DEFAULT '',                 		-- (oleary gram)
				\"pediatricsicpce\" varchar(300) DEFAULT '',       				 -- (cpod, cpos:ceod ceos)
				\"pediatricsiteethpresent\" varchar(300) DEFAULT '',       -- (cantidad de dinetes presentes)
				\"pediatricsiteethtype\" varchar(300) DEFAULT '',       	 -- (tipo diente)
				\"pediatricsianomaly\" text DEFAULT '',       						-- (para quinto año anomalias dentarias)
				\"pediatricsitreatmentplan\" text DEFAULT '',       	 -- (tipo diente)
				\"pediatricsimonitoring\" varchar(500) DEFAULT '',        -- (monitoreo)
				\"pediatricsicomment\" varchar(500) DEFAULT '',       -- (comentario)

				\"pediatricsirev\"	text DEFAULT '',									-- (ID cola de docentes revisores)
				\"pediatricsistatus\" varchar(50) DEFAULT '',       -- (estado new, process, end, fail)

				\"pediatricsiinputfilename\" varchar(100) DEFAULT '',     -- (nombre del archivo)
				\"pediatricsiinputfile\" oid,															-- (el archivo conclido)
				\"pediatricsiinputfilehash\" varchar(50),               --(apuntador para archivo)

				\"patientid\" int4 NOT NULL,      								-- (id del paciente)
				\"student\" int4 NOT NULL,                        -- (id del estudiate)
				\"remissionid\" int4 NOT NULL,                    -- (id de la remission)
				\"teacher\" int4 NOT NULL,                        -- (id del docente)
				\"clinicalid\" int4 NOT NULL,
			  \"startdatetime\" int4 DEFAULT -1 NOT NULL, -- (indica la fecha de inicio de ficha clinica)
			  \"enddatetime\" int4 DEFAULT -1 NOT NULL, -- (indica la fecha de finalizacion)
			  \"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
        CONSTRAINT \"pediatricsi_pkey\" PRIMARY KEY (\"pediatricsiid\", \"student\", \"teacher\"),
				CONSTRAINT \"remission_fk\" FOREIGN KEY (\"patientid\", \"student\", \"remissionid\", \"clinicalid\")
								REFERENCES \"remissiontable\" (\"patientid\", \"examined\", \"remissionid\", \"clinicalid\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
				CONSTRAINT \"specialty_fk\" FOREIGN KEY (\"teacher\", \"clinicalid\")
								REFERENCES \"specialtytable\" (\"userid\", \"clinicalid\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
)", "DBCreatePediatricsiTable(create table)");

	$r = DBExec($c, "REVOKE ALL ON \"pediatricsitable\" FROM PUBLIC", "DBCreatePediatricsiTable(revoke public)");
	$r = DBExec($c, "GRANT ALL ON \"pediatricsitable\" TO \"".$conf["dbuser"]."\"", "DBCreatePediatricsiTable(grant sihcouser)");
	$r = DBExec($c, "CREATE INDEX \"pediatricsi_index\" ON \"pediatricsitable\" USING btree ".
				"(\"pediatricsiid\" int4_ops, \"patientid\" int4_ops, \"student\" int4_ops)",
				"DBCreatePediatricsiTable(create pediatricsi_index)");
}
//funcion para eliminar la tabla de periodoncia
function DBDropOrthodonticsTable() {
    //conexcion de la base de datos..
	 $c = DBConnect();
	 $r = DBExec($c, "drop table \"orthodonticstable\"", "DBDropOrthodonticsTable(drop table)");
}
function DBCreateOrthodonticsTable() {
	 $c = DBConnect();
	 $conf = globalconf();
	 if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
	 $r = DBExec($c, "
CREATE TABLE \"orthodonticstable\"(
				\"orthodonticsid\" serial NOT NULL,                	-- (id de ficha clinica ortodoncia i)
				\"orthodonticsyear\" varchar(20) DEFAULT '',						-- (gestion)
        \"orthodonticsmotconsult\" text DEFAULT '',         -- (motivo de la consulta)
        \"orthodonticsalterations\" text DEFAULT '',       			-- (alteraciones)
        \"orthodonticshereditary\" varchar(500) DEFAULT '',   			 -- (antecedentes hereditarios)
				\"orthodonticsnutritional\" varchar(300) DEFAULT '',       	 -- (antecedentes personales: estadp nutricional)
				\"orthodonticslactation\" varchar(100) DEFAULT '',    -- (lactancia(duraccion) seno materno)
				\"orthodonticsdiseases\" varchar(300) DEFAULT '',       	 -- (enfermedades infecciosas)
				\"orthodonticstreatments\" varchar(300) DEFAULT '',      -- (tratamientos farmacologicos)
				\"orthodonticsimportance\" varchar(300) DEFAULT '',   -- (importancia)
				\"orthodonticsbadhabits\" varchar(300) DEFAULT '',         -- (malos habitos)
				\"orthodonticstrauma\" varchar(300) DEFAULT '',    -- (traumatismo)
				\"orthodonticsrespirator\" varchar(300) DEFAULT '',     -- (tipo de respirador)
				\"orthodonticseruption\" varchar(300) DEFAULT '',      -- (erupcion de la denticion)
				\"orthodonticsarcade\" varchar(300) DEFAULT '',         -- (arcada)
				\"orthodonticsdentition\" varchar(300) DEFAULT '',      -- (tipo de denticion)
				\"orthodonticsmissing\" text DEFAULT '',       		 				 -- (piezas ausentes por)
				\"orthodonticscavities\" varchar(300) DEFAULT '',     -- (piezas con caries)
				\"orthodonticsincluded\" varchar(300) DEFAULT '',     -- (dientes incluidos)
				\"orthodonticsretained\" varchar(300) DEFAULT '',     -- (dientes incluidos)
				\"orthodonticsnumerous\" varchar(300) DEFAULT '',     -- (dientes supernumerarios)
				\"orthodonticssealed\" varchar(300) DEFAULT '',       -- (dientes obturados)
				\"orthodonticsrebuilt\" varchar(300) DEFAULT '',      -- (dientes reconstruidos)
				\"orthodonticsendodontics\" varchar(500) DEFAULT '',  -- (dientes con endodoncia)
				\"orthodonticsgram\" text DEFAULT '',                 						-- (grafico)
				\"orthodonticsphoto\" varchar(300) DEFAULT '',                 		-- (fotos)
				\"orthodonticsmodel\" varchar(300) DEFAULT '',       				 -- (analisis de modelos)
				\"orthodonticsradiographic\" varchar(300) DEFAULT '',       -- (examen radiografico)
				\"orthodonticsdiagnosispre\" varchar(300) DEFAULT '',       	 -- (diagnostico presuntivo)
				\"orthodonticsdiagnosisdef\" varchar(300) DEFAULT '',       	 -- (diagnostico definitivo)
				\"orthodonticstreatmentplan\" text DEFAULT '',       	 -- (plan de tratamiento)
				\"orthodonticsstudy\" varchar(500) DEFAULT '',        -- (estudio)
				\"orthodonticstreatment\" varchar(500) DEFAULT '',        -- (trabajo)
				\"orthodonticsdesign\" varchar(500) DEFAULT '',        -- (diseño)
				\"orthodonticswire\" varchar(500) DEFAULT '',        -- (labrado de alambre)
				\"orthodonticswax\" varchar(500) DEFAULT '',        -- (encerado)
				\"orthodonticsmaking\" varchar(500) DEFAULT '',        -- (confeccion)
				\"orthodonticsacrylic\" varchar(500) DEFAULT '',        -- (autorizacion de acrilizado)
				\"orthodonticsfacility\" varchar(500) DEFAULT '',        -- (instalacion de aparato logico)
				\"orthodonticscontrols\" varchar(500) DEFAULT '',        -- (evolucion y controles)
				\"orthodonticsstatus\" varchar(50) DEFAULT '',       -- (estado new, process, end, fail)

				\"patientid\" int4 NOT NULL,      								-- (id del paciente)
				\"student\" int4 NOT NULL,                        -- (id del estudiate)
				\"remissionid\" int4 NOT NULL,                    -- (id de la remission)
				\"teacher\" int4 NOT NULL,                        -- (id del docente)
				\"clinicalid\" int4 NOT NULL,
			  \"startdatetime\" int4 DEFAULT -1 NOT NULL, -- (indica la fecha de inicio de ficha clinica)
			  \"enddatetime\" int4 DEFAULT -1 NOT NULL, -- (indica la fecha de finalizacion)
			  \"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
        CONSTRAINT \"orthodontics_pkey\" PRIMARY KEY (\"orthodonticsid\", \"student\", \"teacher\"),
				CONSTRAINT \"remission_fk\" FOREIGN KEY (\"patientid\", \"student\", \"remissionid\", \"clinicalid\")
								REFERENCES \"remissiontable\" (\"patientid\", \"examined\", \"remissionid\", \"clinicalid\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
				CONSTRAINT \"specialty_fk\" FOREIGN KEY (\"teacher\", \"clinicalid\")
								REFERENCES \"specialtytable\" (\"userid\", \"clinicalid\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
)", "DBCreateOrthodonticsTable(create table)");

	$r = DBExec($c, "REVOKE ALL ON \"orthodonticstable\" FROM PUBLIC", "DBCreateOrthodonticsTable(revoke public)");
	$r = DBExec($c, "GRANT ALL ON \"orthodonticstable\" TO \"".$conf["dbuser"]."\"", "DBCreateOrthodonticsTable(grant sihcouser)");
	$r = DBExec($c, "CREATE INDEX \"orthodontics_index\" ON \"orthodonticstable\" USING btree ".
				"(\"orthodonticsid\" int4_ops, \"patientid\" int4_ops, \"student\" int4_ops)",
				"DBCreateOrthodonticsTable(create orthodontics_index)");
}
//funcion para crear un nuevo registro de ortodoncia
function DBNewOrthodontics($param , $c=null){

		if(isset($param['patientid']) && !isset($param['patient'])) $param['patient']=$param['patientid'];
		if(isset($param['studentid']) && !isset($param['student'])) $param['student']=$param['studentid'];
		if(isset($param['remissionid']) && !isset($param['remission'])) $param['remission']=$param['remissionid'];
		if(isset($param['teacherid']) && !isset($param['teacher'])) $param['teacher']=$param['teacherid'];
		if(isset($param['clinicalid']) && !isset($param['clinical'])) $param['clinical']=$param['clinicalid'];

		//if(isset($param['pediatricsiid']) && !isset($param['id'])) $param['id']=$param['pediatricsiid'];
		if(isset($param['orthodonticsyear']) && !isset($param['year'])) $param['year']=$param['orthodonticsyear'];
		if(isset($param['orthodonticsmotconsult']) && !isset($param['motconsult'])) $param['motconsult']=$param['orthodonticsmotconsult'];
		if(isset($param['orthodonticsalterations']) && !isset($param['alterations'])) $param['alterations']=$param['orthodonticsalterations'];
		if(isset($param['orthodonticshereditary']) && !isset($param['hereditary'])) $param['hereditary']=$param['orthodonticshereditary'];
		if(isset($param['orthodonticsnutritional']) && !isset($param['nutritional'])) $param['nutritional']=$param['orthodonticsnutritional'];
		if(isset($param['orthodonticslactation']) && !isset($param['lactation'])) $param['lactation']=$param['orthodonticslactation'];
		if(isset($param['orthodonticsdiseases']) && !isset($param['diseases'])) $param['diseases']=$param['orthodonticsdiseases'];
		if(isset($param['orthodonticstreatments']) && !isset($param['treatments'])) $param['treatments']=$param['orthodonticstreatments'];
		if(isset($param['orthodonticsimportance']) && !isset($param['importance'])) $param['importance']=$param['orthodonticsimportance'];
		if(isset($param['orthodonticsbadhabits']) && !isset($param['badhabits'])) $param['badhabits']=$param['orthodonticsbadhabits'];
		if(isset($param['orthodonticstrauma']) && !isset($param['trauma'])) $param['trauma']=$param['orthodonticstrauma'];
		if(isset($param['orthodonticsrespirator']) && !isset($param['respirator'])) $param['respirator']=$param['orthodonticsrespirator'];
		if(isset($param['orthodonticseruption']) && !isset($param['eruption'])) $param['eruption']=$param['orthodonticseruption'];
		if(isset($param['orthodonticsarcade']) && !isset($param['arcade'])) $param['arcade']=$param['orthodonticsarcade'];
		if(isset($param['orthodonticsdentition']) && !isset($param['dentition'])) $param['dentition']=$param['orthodonticsdentition'];
		if(isset($param['orthodonticsmissing']) && !isset($param['missing'])) $param['missing']=$param['orthodonticsmissing'];
		if(isset($param['orthodonticscavities']) && !isset($param['cavities'])) $param['cavities']=$param['orthodonticscavities'];
		if(isset($param['orthodonticsincluded']) && !isset($param['included'])) $param['included']=$param['orthodonticsincluded'];
		if(isset($param['orthodonticsretained']) && !isset($param['retained'])) $param['retained']=$param['orthodonticsretained'];
		if(isset($param['orthodonticsnumerous']) && !isset($param['numerous'])) $param['numerous']=$param['orthodonticsnumerous'];
		if(isset($param['orthodonticssealed']) && !isset($param['sealed'])) $param['sealed']=$param['orthodonticssealed'];
		if(isset($param['orthodonticsrebuilt']) && !isset($param['rebuilt'])) $param['rebuilt']=$param['orthodonticsrebuilt'];
		if(isset($param['orthodonticsendodontics']) && !isset($param['endodontics'])) $param['endodontics']=$param['orthodonticsendodontics'];
		if(isset($param['orthodonticsgram']) && !isset($param['gram'])) $param['gram']=$param['orthodonticsgram'];
		if(isset($param['orthodonticsphoto']) && !isset($param['photo'])) $param['photo']=$param['orthodonticsphoto'];
		if(isset($param['orthodonticsmodel']) && !isset($param['model'])) $param['model']=$param['orthodonticsmodel'];
		if(isset($param['orthodonticsradiographic']) && !isset($param['radiographic'])) $param['radiographic']=$param['orthodonticsradiographic'];
		if(isset($param['orthodonticsdiagnosispre']) && !isset($param['diagnosispre'])) $param['diagnosispre']=$param['orthodonticsdiagnosispre'];
		if(isset($param['orthodonticsdiagnosisdef']) && !isset($param['diagnosisdef'])) $param['diagnosisdef']=$param['orthodonticsdiagnosisdef'];
		if(isset($param['orthodonticstreatmentplan']) && !isset($param['treatmentplan'])) $param['treatmentplan']=$param['orthodonticstreatmentplan'];
		if(isset($param['orthodonticsstudy']) && !isset($param['study'])) $param['study']=$param['orthodonticsstudy'];
		if(isset($param['orthodonticstreatment']) && !isset($param['treatment'])) $param['treatment']=$param['orthodonticstreatment'];
		if(isset($param['orthodonticsdesign']) && !isset($param['design'])) $param['design']=$param['orthodonticsdesign'];
		if(isset($param['orthodonticswire']) && !isset($param['wire'])) $param['wire']=$param['orthodonticswire'];
		if(isset($param['orthodonticswax']) && !isset($param['wax'])) $param['wax']=$param['orthodonticswax'];
		if(isset($param['orthodonticsmaking']) && !isset($param['making'])) $param['making']=$param['orthodonticsmaking'];
		if(isset($param['orthodonticsacrylic']) && !isset($param['acrylic'])) $param['acrylic']=$param['orthodonticsacrylic'];
		if(isset($param['orthodonticsfacility']) && !isset($param['facility'])) $param['facility']=$param['orthodonticsfacility'];
		if(isset($param['orthodonticscontrols']) && !isset($param['controls'])) $param['controls']=$param['orthodonticscontrols'];
		if(isset($param['orthodonticsstatus']) && !isset($param['status'])) $param['status']=$param['orthodonticsstatus'];

		$ac=array('patient', 'student', 'remission', 'teacher', 'clinical');

		$ac1=array('year', 'motconsult',	'alterations',	'hereditary',	'nutritional',	'lactation',
		'diseases',	'treatments',	'importance',	'badhabits',	'trauma',	'respirator',	'eruption',
		'arcade',	'dentition',	'missing',	'cavities',	'included',	'retained',	'numerous',	'sealed',
		'rebuilt',	'endodontics',	'gram',	'photo',	'model',	'radiographic',	'diagnosispre',
		'diagnosisdef',	'treatmentplan',	'study',	'treatment',	'design',	'wire',	'wax',	'making',
		'acrylic',	'facility',	'controls',	'status');

		$typei['patient']=-1;
		$typei['student']=-1;
		$typei['remission']=-1;
		$typei['teacherid']=-1;//admin
		$typei['clinical']=6;//clinica Ortodoncia


		foreach($ac as $key) {
			if(!isset($param[$key]) || $param[$key]=="") {
				MSGError("DBNewOrthodontics param error: $key not found");
				return false;
			}
			if(isset($typei[$key]) && !is_numeric($param[$key])) {
				MSGError("DBNewOrthodontics param error: $key is not numeric");
				return false;
			}
			$$key = myhtmlspecialchars($param[$key]);
		}

		$year='';
		$motconsult='';
		$alterations='';
		$hereditary='';
		$nutritional='';
		$lactation='';
		$diseases='';
		$treatments='';
		$importance='';
		$badhabits='';
		$trauma='';
		$respirator='';
		$eruption='';
		$arcade='';
		$dentition='';
		$missing='';
		$cavities='';
		$included='';
		$retained='';
		$numerous='';
		$sealed='';
		$rebuilt='';
		$endodontics='';
		$gram='';
		$photo='';
		$model='';
		$radiographic='';
		$diagnosispre='';
		$diagnosisdef='';
		$treatmentplan='';
		$study='';
		$treatment='';
		$design='';
		$wire='';
		$wax='';
		$making='';
		$acrylic='';
		$facility='';
		$controls='';

		$status='new';

		$updatetime=-1;
		foreach($ac1 as $key) {
			if(isset($param[$key])) {
				$$key = myhtmlspecialchars($param[$key]);
				if(isset($typei[$key]) && !is_numeric($param[$key])) {
					MSGError("DBNewOrthodontics param error: $key is not numeric");
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
			DBExec($c, "begin work", "DBNewOrthodontics(begin)");
		}
		DBExec($c, "lock table orthodonticstable", "DBNewOrthodontics(lock)");

		$ret=1;

		//antes de registrar chekear las claves foraneas
		$sql = "select * from orthodonticstable where patientid=$patient and remissionid= $remission";
		$a = DBGetRow ($sql, 0, $c);
			if($teacher==-1){
				if($a!=null){

					$teacher=$a['teacher'];

					$year=$a['orthodonticsyear'];
					$motconsult=$a['orthodonticsmotconsult'];
					$alterations=$a['orthodonticsalterations'];
					$hereditary=$a['orthodonticshereditary'];
					$nutritional=$a['orthodonticsnutritional'];
					$lactation=$a['orthodonticslactation'];
					$diseases=$a['orthodonticsdiseases'];
					$treatments=$a['orthodonticstreatments'];
					$importance=$a['orthodonticsimportance'];
					$badhabits=$a['orthodonticsbadhabits'];
					$trauma=$a['orthodonticstrauma'];
					$respirator=$a['orthodonticsrespirator'];
					$eruption=$a['orthodonticseruption'];
					$arcade=$a['orthodonticsarcade'];
					$dentition=$a['orthodonticsdentition'];
					$missing=$a['orthodonticsmissing'];
					$cavities=$a['orthodonticscavities'];
					$included=$a['orthodonticsincluded'];
					$retained=$a['orthodonticsretained'];
					$numerous=$a['orthodonticsnumerous'];
					$sealed=$a['orthodonticssealed'];
					$rebuilt=$a['orthodonticsrebuilt'];
					$endodontics=$a['orthodonticsendodontics'];
					$gram=$a['orthodonticsgram'];
					$photo=$a['orthodonticsphoto'];
					$smodel=$a['orthodonticsmodel'];
					$radiographic=$a['orthodonticsradiographic'];
					$diagnosispre=$a['orthodonticsdiagnosispre'];
					$diagnosisdef=$a['orthodonticsdiagnosisdef'];
					$treatmentplan=$a['orthodonticstreatmentplan'];
					$study=$a['orthodonticsstudy'];
					$treatment=$a['orthodonticstreatment'];
					$design=$a['orthodonticsdesign'];
					$wire=$a['orthodonticswire'];
					$wax=$a['orthodonticswax'];
					$making=$a['orthodonticsmaking'];
					$acrylic=$a['orthodonticsacrylic'];
					$facility=$a['orthodonticsfacility'];
					$controls=$a['orthodonticscontrols'];
					$status=$a['orthodonticsstatus'];
				}else{
					$teacher=0;
				}
			}
	      	//para insercion o actulizacion
			if ($a == null) {
				  $ret=2;

	    		$sql = "insert into orthodonticstable(orthodonticsyear, orthodonticsmotconsult,	orthodonticsalterations, ".
					"orthodonticshereditary,	orthodonticsnutritional,	orthodonticslactation,	orthodonticsdiseases,	".
					"orthodonticstreatments,	orthodonticsimportance,	orthodonticsbadhabits,	orthodonticstrauma,	".
					"orthodonticsrespirator,	orthodonticseruption,	orthodonticsarcade,	orthodonticsdentition, ".
					"orthodonticsmissing,	orthodonticscavities,	orthodonticsincluded,	orthodonticsretained,	".
					"orthodonticsnumerous,	orthodonticssealed,	orthodonticsrebuilt,	orthodonticsendodontics, ".
					"orthodonticsgram,	orthodonticsphoto,	orthodonticsmodel,	orthodonticsradiographic,	".
					"orthodonticsdiagnosispre,	orthodonticsdiagnosisdef,	orthodonticstreatmentplan,	orthodonticsstudy, ".
					"orthodonticstreatment,	orthodonticsdesign,	orthodonticswire,	orthodonticswax,	orthodonticsmaking,	".
					"orthodonticsacrylic,	orthodonticsfacility,	orthodonticscontrols,	orthodonticsstatus, ".
					" patientid, student, remissionid, teacher, clinicalid) values (".
					"'$year','$motconsult','$alterations','$hereditary','$nutritional','$lactation','$diseases', ".
					"'$treatments','$importance','$badhabits','$trauma','$respirator','$eruption','$arcade', ".
					"'$dentition','$missing','$cavities','$included','$retained','$numerous','$sealed','$rebuilt', ".
					"'$endodontics','$gram','$photo','$model','$radiographic','$diagnosispre','$diagnosisdef', ".
					"'$treatmentplan','$study','$treatment','$design','$wire','$wax','$making','$acrylic', ".
					"'$facility','$controls','$status', $patient, $student, $remission, $teacher, $clinical)";

					DBExec ($c, $sql, "DBNewOrthodontics(insert)");
	    		if($cw) {
	    				DBExec ($c, "commit work");
	    		}
	    		LOGLevel ("Ficha Ortodoncia I $remission registrado.",2);
			} else {
				if($updatetime > $a['updatetime']) {
					$ret=2;
					$pm='';
					if($facility!='t'){
						$pm="orthodonticsfacility='$facility',";
					}
					$sql = "update orthodonticstable set orthodonticsyear='$year', orthodonticsmotconsult='$motconsult', ".
					"orthodonticsalterations='$alterations', orthodonticshereditary='$hereditary', ".
					"orthodonticsnutritional='$nutritional', orthodonticslactation='$lactation', ".
					"orthodonticsdiseases='$diseases', orthodonticstreatments='$treatments', ".
					"orthodonticsimportance='$importance', orthodonticsbadhabits='$badhabits', ".
					"orthodonticstrauma='$trauma', orthodonticsrespirator='$respirator', ".
					"orthodonticseruption='$eruption', orthodonticsarcade='$arcade', ".
					"orthodonticsdentition='$dentition', orthodonticsmissing='$missing', orthodonticscavities='$cavities',".
					"orthodonticsincluded='$included', orthodonticsretained='$retained', ".
					"orthodonticsnumerous='$numerous', orthodonticssealed='$sealed', ".
					"orthodonticsrebuilt='$rebuilt', orthodonticsendodontics='$endodontics', ".
					"orthodonticsgram='$gram', orthodonticsphoto='$photo', orthodonticsmodel='$model', ".
					"orthodonticsradiographic='$radiographic', orthodonticsdiagnosispre='$diagnosispre', ".
					"orthodonticsdiagnosisdef='$diagnosisdef', orthodonticstreatmentplan='$treatmentplan',".
					"orthodonticsstudy='$study', orthodonticstreatment='$treatment', orthodonticsdesign='$design', ".
					"orthodonticswire='$wire', orthodonticswax='$wax', orthodonticsmaking='$making',".
					"orthodonticsacrylic='$acrylic', ".$pm."orthodonticscontrols='$controls', ".
					"orthodonticsstatus='$status', student=$student, teacher=$teacher, updatetime=$updatetime ".
					"where patientid=$patient and remissionid=$remission";

					$r = DBExec ($c, $sql, "DBNewOrthodontics(update)");
					if($cw) {
						DBExec ($c, "commit work");
					}
					LOGLevel("Ficha Ortodoncia I $remission actualizado.",2);
				}
			}

		if($cw) DBExec($c, "commit work");
		return $ret;
}

function DBOrthodonticsInfo($id, $c=null) {

	$sql = "select *from orthodonticstable where orthodonticsid=$id";

	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");

		//MSGError("Unable to find the user in the database. Contact an admin now!");

		return null;
	}
	/*$conf=globalconf();

	if($a['pediatricsioleary']!=''){
		$a['pediatricsioleary'] = decryptData($a['pediatricsioleary'], $conf["key"]);

		$oleary=strpos($a['pediatricsioleary'],'[xu=');
		if($oleary!==false){
			$dataf=substr($a['pediatricsioleary'],$oleary);
			$a['pediatricsioleary']=substr($a['pediatricsioleary'],0,strlen($a['pediatricsioleary'])-strlen($dataf));
			$a=cleardataf($a, $dataf, true);//para oleary de odontopediatria
		}
	}*/

	/*
	$a=clearpexam($a);
	$a=clearsession($a);*/

	$ob=DBObservationInfo($a['orthodonticsid'],$a['remissionid']);
	if($ob!=null){
		$a=array_merge($a, $ob);
	}

	//$a=clearvitalsigns($a);
	$a=clearorthodontics($a);
	return $a;
}
function clearorthodontics($a){
	$r=explode(']',$a['orthodonticslactation']);
	$size=count($r);

	$akey = array('tipolactancia','duracionlactancia');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}

	$r=explode(']',$a['orthodonticsarcade']);
	$size=count($r);

	$akey = array('forma', 'tamano', 'simetria');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}
	$r=explode(']',$a['orthodonticsmissing']);
	$size=count($r);

	$akey = array('tipoausente', 'piezaausente');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}

	if($a['orthodonticsfacility']!=''){
		$r=explode(']',$a['orthodonticsfacility']);
		$size=count($r);

		$akey = array('logiadesc', 'logiafirma', 'logiadate');
		for ($i=0; $i <$size-1 ; $i++) {
			$r2=explode('[',$r[$i]);
			$a[$akey[$i]]=trim($r2[1]);
		}
	}






	return $a;
}
function DBPediatricsiInfo($id, $xremission=false, $c=null) {

	$sql = "select *from pediatricsitable where pediatricsiid=$id";
	if($xremission)
		$sql = "select *from pediatricsitable where remissionid=$id";
	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");

		//MSGError("Unable to find the user in the database. Contact an admin now!");

		return null;
	}
	$conf=globalconf();

	if($a['pediatricsioleary']!=''){
		$a['pediatricsioleary'] = decryptData($a['pediatricsioleary'], $conf["key"]);

		$oleary=strpos($a['pediatricsioleary'],'[xu=');
		if($oleary!==false){
			$dataf=substr($a['pediatricsioleary'],$oleary);
			$a['pediatricsioleary']=substr($a['pediatricsioleary'],0,strlen($a['pediatricsioleary'])-strlen($dataf));
			$a=cleardataf($a, $dataf, true);//para oleary de odontopediatria
		}
	}

	/*
	$a=clearpexam($a);
	$a=clearsession($a);*/

	$ob=DBObservationInfo($a['pediatricsiid'],$a['remissionid']);
	if($ob!=null){
		$a=array_merge($a, $ob);
	}

	$a=clearvitalsigns($a);
	$a=clearperiodic($a);
	//$a=clearexam($a);
	//$a=cleartreatment($a);
	return $a;
}
//limpiar signos vitales
function clearvitalsigns($a){
	$r=explode(']',$a['pediatricsivitalsigns']);
	$size=count($r);

	$akey = array('temp','fc','fr','pd','talla','peso','constit','pulso','diast');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}
	$r=explode(']',$a['pediatricsiodontometa']);
	$size=count($r);

	$akey = array('tl8','tl7','tl6','tl5','tl4','tl3','tl2','tl1',
								'tr8','tr7','tr6','tr5','tr4','tr3','tr2','tr1',
								'bl8','bl7','bl6','bl5','bl4','bl3','bl2','bl1',
								'br8','br7','br6','br5','br4','br3','br2','br1');
	if($size>=32){
		for ($i=0; $i <$size-1 ; $i++) {
			$r2=explode('[',$r[$i]);
			$a[$akey[$i]]=trim($r2[1]);
		}
	}
	$r=explode(']',$a['pediatricsidiagnosisradiographic']);
	$size=count($r);
	$akey = array('dentaria', 'anquilosis', 'agenesias', 'ectopica', 'supernumerarios', 'precoz', 'dentariaobs');
	if($size>=7){
		for ($i=0; $i <$size-1 ; $i++) {
			$r2=explode('[',$r[$i]);
			$a[$akey[$i]]=trim($r2[1]);
		}
	}
	$r=explode(']',$a['pediatricsianomaly']);
	$size=count($r);
	$akey = array('iniciacion','histo','morfo','aposicion','calcificacion','erupcion','abrasion','anomaliaobs');
	if($size>=8){
		for ($i=0; $i <$size-1 ; $i++) {
			$r2=explode('[',$r[$i]);
			$a[$akey[$i]]=trim($r2[1]);
		}
	}
	return $a;
}
function clearperiodic($a){
	$r=explode(']',$a['pediatricsiperiodic']);
	$size=count($r);

	$akey = array('periodica','periodicacuales');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}


	$r=explode(']',$a['pediatricsiexperiences']);
	$size=count($r);

	$akey = array('traumaticas','traumaticascuales');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}

	$r=explode(']',$a['pediatricsiexplanations']);
	$size=count($r);

	$akey = array('conexplicaciones','sinconexplicaciones');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}

	$r=explode(']',$a['pediatricsiexperiencesinye']);
	$size=count($r);

	$akey = array('experienciastraumaticas','experienciastraumaticasotros');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}
	$r=explode(']',$a['pediatricsigodoctor']);
	$size=count($r);

	$akey = array('medicoperiodicamente','medicoirregularmente');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}

	$r=explode(']',$a['pediatricsidieta']);
	$size=count($r);

	$akey = array('desayuno','desayunoalmuerzo','almuerzo','merienda','cena','despuescena','despierta','dulcedia','riesgocaries','actitudalimentacion');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}

	$r=explode(']',$a['pediatricsibacterialcontrol']);
	$size=count($r);

	$akey = array('tecnicabacterial','ensenadopor','tipocepillo','dentifrico');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}

	$r=explode(']',$a['pediatricsifluoridetherapy']);
	$size=count($r);

	$akey = array('fluoruros','foururoedad','foururocontinua','topicos','topicostiempo','topicoscontinua','enjuagatorio','enjuagatoriocontinua');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}

	$r=explode(']',$a['pediatricsifirstvisit']);
	$size=count($r);

	$akey = array('actituddelnino','actituddelpadre','actitudacompanante');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}

	$r=explode(']',$a['pediatricsicpce']);
	$size=count($r);

	$akey = array('cpod','cpos','ceod','ceos');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}

	$r=explode(']',$a['pediatricsiteethpresent']);
	$size=count($r);

	$akey = array('pri','per');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}

	$r=explode(']',$a['pediatricsiteethtype']);
	$size=count($r);

	$akey = array('activa','lenta','detenida');
	for ($i=0; $i <$size-1 ; $i++) {
		$r2=explode('[',$r[$i]);
		$a[$akey[$i]]=trim($r2[1]);
	}
	return $a;
}
//para sacar la informacion de odontopediatria I
function DBPediatricsiInfo2($id, $c=null) {

	$sql = "select c.clinicalid as clinical, r.remissionid as remission, pe.pediatricsiid as ficha, p.patientfullname as patientfullname,
de.motconsult as consult, c.clinicalspecialty as clinicalname, u.userfullname as student,
pe.pediatricsistatus as status, pe.teacher as teacher, pe.updatetime as time from pediatricsitable
as pe, usertable as u, patienttable as p, clinicaltable as c, dentalexamtable as de, remissiontable as r
where pe.pediatricsiid=$id and pe.pediatricsistatus!='new' and p.patientid=pe.patientid and de.patientid=r.patientid and
de.dentalid=r.patientdentalid and r.remissionid=pe.remissionid and c.clinicalid=r.clinicalid and
r.examined=pe.student and u.usernumber=r.examined";

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
//para sacar la informacion de odontopediatria I
function DBOrthodonticsInfo2($id, $c=null) {

	$sql = "select c.clinicalid as clinical, r.remissionid as remission, o.orthodonticsid as ficha, p.patientfullname as patientfullname,
de.motconsult as consult, c.clinicalspecialty as clinicalname, u.userfullname as student,
o.orthodonticsstatus as status, o.teacher as teacher, o.updatetime as time from orthodonticstable
as o, usertable as u, patienttable as p, clinicaltable as c, dentalexamtable as de, remissiontable as r
where o.orthodonticsid=$id and o.orthodonticsstatus!='new' and p.patientid=o.patientid and de.patientid=r.patientid and
de.dentalid=r.patientdentalid and r.remissionid=o.remissionid and c.clinicalid=r.clinicalid and
r.examined=o.student and u.usernumber=r.examined";

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
//para modificacion paciente datos de fecha de nacimiento
function DBUpdatePatientPediatrics($param, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBUpdatePatientPediatrics(begin)");
		}
		DBExec($c, "lock table patienttable", "DBUpdatePatientPediatrics(lock)");

		$ret=2;
		$time=time();
		if(isset($param['patientid']) && is_numeric($param['patientid']) && isset($param['patientdatebirth']) &&
		$param['patientdatebirth']!='' && isset($param['patientplacebirth']) && $param['patientplacebirth']){

				$sql="update patienttable set patientdatebirth='".$param['patientdatebirth']."', patientplacebirth='".$param['patientplacebirth']."' where patientid=".$param['patientid'];
				DBExec($c, $sql, "DBUpdatePatientPediatrics(update patienttable)");

				if(isset($param['patientadmissionid']) && is_numeric($param['patientadmissionid']) &&
					isset($param['patientfather']) && isset($param['patientmother']) &&
					isset($param['brothers']) && isset($param['patientschools'])){

						$sql="update patientadmissiontable set patientfather='".$param['patientfather']."', patientmother='".$param['patientmother']."', patientbrothers='".$param['brothers']."', patientschools='".$param['patientschools']."'  where patientadmissionid=".$param['patientadmissionid'];
						DBExec($c, $sql, "DBUpdatePatientPediatrics(update patientadmissiontable)");
				}
		}

		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}
//para modificacion de tabla dentaltable de admision
function DBUpdatePatientOrthodontics($param, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBUpdatePatientOrthodontics(begin)");
		}
		DBExec($c, "lock table dentalexamtable", "DBUpdatePatientOrthodontics(lock)");

		$ret=2;
		$time=time();
		if(isset($param['dentalid']) && is_numeric($param['dentalid']) &&
			isset($param['faces']) && isset($param['profile']) && isset($param['liprelation']) &&
			isset($param['mucosa']) && isset($param['encias']) && isset($param['braces']) &&
			isset($param['palatine']) && isset($param['tongue'])){

				$sql="update dentalexamtable set dentalfaces='".$param['faces'].
				"', dentalprofile='".$param['profile']."', dentallips='".$param['liprelation'].
				"', dentalmucosa='".$param['mucosa']."', dentalencias='".$param['encias'].
				"', dentalbraces='".$param['braces']."', dentalpalatine='".$param['palatine']."', dentaltongue='".$param['tongue']."' where dentalid=".$param['dentalid'];
				DBExec($c, $sql, "DBUpdatePatientOrthodontics(update patientadmissiontable)");
		}

		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}
function DBUpdateOleary($param, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBUpdateOleary(begin)");
		}
		DBExec($c, "lock table pediatricsitable", "DBUpdateOleary(lock)");

		$ret=2;
		$time=time();
		if(isset($param['file']) && is_numeric($param['file']) && isset($param['olearygram'])){
				$sql="update pediatricsitable set pediatricsioleary='".$param['olearygram']."' where pediatricsiid=".$param['file'];
				DBExec($c, $sql, "DBUpdateOleary(update pediatricsitable)");
		}

		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}
function DBUpdateOrthodonticsImpresion($param, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBUpdateOrthodonticsImpresion(begin)");
		}
		DBExec($c, "lock table orthodonticstable", "DBUpdateOrthodonticsImpresion(lock)");

		$ret=2;
		$time=time();
		if(isset($param['file']) && is_numeric($param['file'])&& isset($param['study'])&&
		isset($param['treatment'])&&	isset($param['design'])&&	isset($param['wire'])&&
		isset($param['wax'])&&	isset($param['making'])&&	isset($param['acrylic'])&&	isset($param['facility'])){
				$sql="update orthodonticstable set orthodonticsstudy='".$param['study']."', orthodonticstreatment='".$param['treatment'].
				"', orthodonticsdesign='".$param['design']."', orthodonticswire='".$param['wire']."', orthodonticswax='".$param['wax'].
				"', orthodonticsmaking='".$param['making']."', orthodonticsacrylic='".$param['acrylic']."', orthodonticsfacility='".$param['facility']."' where orthodonticsid=".$param['file'];
				DBExec($c, $sql, "DBUpdateOrthodonticsImpresion(update orthodonticstable)");
		}

		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}
function DBUpdateOrthodonticsControls($param, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBUpdateOrthodonticsControls(begin)");
		}
		DBExec($c, "lock table orthodonticstable", "DBUpdateOrthodonticsControls(lock)");

		$ret=2;
		$time=time();
		if(isset($param['file']) && is_numeric($param['file'])&& isset($param['controls'])){
				$sql="update orthodonticstable set orthodonticscontrols='".$param['controls']."' where orthodonticsid=".$param['file'];
				DBExec($c, $sql, "DBUpdateOrthodonticsControls(update orthodonticstable)");
		}

		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}
function DBUpdateOrthodonticsGram($param, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBUpdateOrthodonticsGram(begin)");
		}
		DBExec($c, "lock table orthodonticstable", "DBUpdateOrthodonticsGram(lock)");

		$ret=2;
		$time=time();
		if(isset($param['file']) && is_numeric($param['file'])&& isset($param['gram'])){
				$sql="update orthodonticstable set orthodonticsgram='".$param['gram']."' where orthodonticsid=".$param['file'];
				DBExec($c, $sql, "DBUpdateOrthodonticsGram(update orthodonticstable)");
		}

		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}
//funcion para actualizar....
function DBUpdatePlan($param, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBUpdatePlan(begin)");
		}
		DBExec($c, "lock table pediatricsitable", "DBUpdatePlan(lock)");

		$ret=2;
		$time=time();
		if(isset($param['file']) && is_numeric($param['file']) && isset($param['plantxt'])){
				$sql="update pediatricsitable set pediatricsitreatmentplan='".$param['plantxt']."' where pediatricsiid=".$param['file'];
				DBExec($c, $sql, "DBUpdatePlan(update pediatricsitable)");
		}

		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}

//funcion para crear una nueva ficha clinica odontopediatria
function DBNewPediatricsi($param , $c=null){

		if(isset($param['patientid']) && !isset($param['patient'])) $param['patient']=$param['patientid'];
		if(isset($param['studentid']) && !isset($param['student'])) $param['student']=$param['studentid'];
		if(isset($param['remissionid']) && !isset($param['remission'])) $param['remission']=$param['remissionid'];
		if(isset($param['teacherid']) && !isset($param['teacher'])) $param['teacher']=$param['teacherid'];
		if(isset($param['clinicalid']) && !isset($param['clinical'])) $param['clinical']=$param['clinicalid'];

		//if(isset($param['pediatricsiid']) && !isset($param['id'])) $param['id']=$param['pediatricsiid'];
		if(isset($param['pediatricsirefer']) && !isset($param['refer'])) $param['refer']=$param['pediatricsirefer'];
		if(isset($param['pediatricsireason']) && !isset($param['reason'])) $param['reason']=$param['pediatricsireason'];
		if(isset($param['pediatricsivitalsigns']) && !isset($param['vitalsigns'])) $param['vitalsigns']=$param['pediatricsivitalsigns'];
		if(isset($param['pediatricsimotconsult']) && !isset($param['motconsult'])) $param['motconsult']=$param['pediatricsimotconsult'];
		if(isset($param['pediatricsiattitude']) && !isset($param['attitude'])) $param['attitude']=$param['pediatricsiattitude'];
		if(isset($param['pediatricsiauthorization']) && !isset($param['authorization'])) $param['authorization']=$param['pediatricsiauthorization'];
		if(isset($param['pediatricsiarmchair']) && !isset($param['armchair'])) $param['armchair']=$param['pediatricsiarmchair'];
		if(isset($param['pediatricsiprior']) && !isset($param['prior'])) $param['prior']=$param['pediatricsiprior'];
		if(isset($param['pediatricsilastattention']) && !isset($param['lastattention'])) $param['lastattention']=$param['pediatricsilastattention'];
		if(isset($param['pediatricsiperiodic']) && !isset($param['periodic'])) $param['periodic']=$param['pediatricsiperiodic'];
		if(isset($param['pediatricsiexperiences']) && !isset($param['experiences'])) $param['experiences']=$param['pediatricsiexperiences'];
		if(isset($param['pediatricsiodontoattitude']) && !isset($param['odontoattitude'])) $param['odontoattitude']=$param['pediatricsiodontoattitude'];
		if(isset($param['pediatricsidiseases']) && !isset($param['diseases'])) $param['diseases']=$param['pediatricsidiseases'];
		if(isset($param['pediatricsiinterventions']) && !isset($param['interventions'])) $param['interventions']=$param['pediatricsiinterventions'];
		if(isset($param['pediatricsiexplanations']) && !isset($param['explanations'])) $param['explanations']=$param['pediatricsiexplanations'];
		if(isset($param['pediatricsiexperiencesinye']) && !isset($param['experiencesinye'])) $param['experiencesinye']=$param['pediatricsiexperiencesinye'];
		if(isset($param['pediatricsigodoctor']) && !isset($param['godoctor'])) $param['godoctor']=$param['pediatricsigodoctor'];
		if(isset($param['pediatricsiconsistency']) && !isset($param['consistency'])) $param['consistency']=$param['pediatricsiconsistency'];
		if(isset($param['pediatricsidieta']) && !isset($param['dieta'])) $param['dieta']=$param['pediatricsidieta'];
		if(isset($param['pediatricsibacterialcontrol']) && !isset($param['bacterialcontrol'])) $param['bacterialcontrol']=$param['pediatricsibacterialcontrol'];
		if(isset($param['pediatricsifluoridetherapy']) && !isset($param['fluoridetherapy'])) $param['fluoridetherapy']=$param['pediatricsifluoridetherapy'];
		if(isset($param['pediatricsisealants']) && !isset($param['sealants'])) $param['sealants']=$param['pediatricsisealants'];
		if(isset($param['pediatricsioralhabits']) && !isset($param['oralhabits'])) $param['oralhabits']=$param['pediatricsioralhabits'];
		if(isset($param['pediatricsiresumefather']) && !isset($param['resumefather'])) $param['resumefather']=$param['pediatricsiresumefather'];
		if(isset($param['pediatricsifirstvisit']) && !isset($param['firstvisit'])) $param['firstvisit']=$param['pediatricsifirstvisit'];
		if(isset($param['pediatricsifirstsynthesis']) && !isset($param['firstsynthesis'])) $param['firstsynthesis']=$param['pediatricsifirstsynthesis'];
		if(isset($param['pediatricsiodontogram']) && !isset($param['odontogram'])) $param['odontogram']=$param['pediatricsiodontogram'];
		if(isset($param['pediatricsiodontometa']) && !isset($param['odontometa'])) $param['odontometa']=$param['pediatricsiodontometa'];
		if(isset($param['pediatricsidiagnosisradiographic']) && !isset($param['diagnosisradiographic'])) $param['diagnosisradiographic']=$param['pediatricsidiagnosisradiographic'];
		if(isset($param['pediatricsianomaly']) && !isset($param['anomaly'])) $param['anomaly']=$param['pediatricsianomaly'];
		if(isset($param['pediatricsicpce']) && !isset($param['cpce'])) $param['cpce']=$param['pediatricsicpce'];
		if(isset($param['pediatricsiteethpresent']) && !isset($param['teethpresent'])) $param['teethpresent']=$param['pediatricsiteethpresent'];
		if(isset($param['pediatricsiteethtype']) && !isset($param['teethtype'])) $param['teethtype']=$param['pediatricsiteethtype'];
		if(isset($param['pediatricsitreatmentplan']) && !isset($param['treatmentplan'])) $param['treatmentplan']=$param['pediatricsitreatmentplan'];
		if(isset($param['pediatricsimonitoring']) && !isset($param['monitoring'])) $param['monitoring']=$param['pediatricsimonitoring'];
		if(isset($param['pediatricsicomment']) && !isset($param['comment'])) $param['comment']=$param['pediatricsicomment'];
		if(isset($param['pediatricsistatus']) && !isset($param['status'])) $param['status']=$param['pediatricsistatus'];

		$ac=array('patient', 'student', 'remission', 'teacher', 'clinical');
		$ac1=array('year','refer','reason','vitalsigns','motconsult','attitude','authorization',
		'armchair','prior','lastattention','periodic','experiences','odontoattitude','diseases',
		'interventions','explanations','experiencesinye','godoctor','consistency','dieta',
		'bacterialcontrol','fluoridetherapy','sealants','oralhabits','resumefather','firstvisit',
		'firstsynthesis','odontogram','odontometa','diagnosisradiographic','anomaly','cpce','teethpresent','teethtype','treatmentplan','monitoring',
		'comment','status','updatetime', 'startdatetime', 'enddatetime');
		$typei['patient']=-1;
		$typei['student']=-1;
		$typei['remission']=-1;
		$typei['teacherid']=-1;//admin
		$typei['clinical']=6;//clinica periodoncia II


		$typei['updatetime']=-1;//clinica periodoncia II
		$typei['startdatetime']=-1;//clinica periodoncia II
		$typei['enddatetime']=-1;//clinica periodoncia II


		foreach($ac as $key) {
			if(!isset($param[$key]) || $param[$key]=="") {
				MSGError("DBNewPeriodonticsii param error: $key not found");
				return false;
			}
			if(isset($typei[$key]) && !is_numeric($param[$key])) {
				MSGError("DBNewPeriodonticsii param error: $key is not numeric");
				return false;
			}
			$$key = myhtmlspecialchars($param[$key]);
		}

		$refer='';
		$reason='';
		$vitalsigns='';
		$motconsult='';
		$attitude='';
		$authorization='';
		$armchair=-1;
		$prior='';
		$lastattention='';
		$periodic='';
		$experiences='';
		$odontoattitude='';
		$diseases='';
		$interventions='';
		$explanations='';
		$experiencesinye='';
		$godoctor='';
		$consistency='';
		$dieta='';
		$bacterialcontrol='';
		$fluoridetherapy='';
		$sealants='';
		$oralhabits='';
		$resumefather='';
		$firstvisit='';
		$firstsynthesis='';
		$odontogram='';
		$odontometa='';
		$diagnosisradiographic='';
		$anomaly='';
		$cpce='';
		$teethpresent='';
		$teethtype='';
		$treatmentplan='';
		$monitoring='';
		$comment='';
		$status='new';

		$updatetime=-1;
		$startdatetime=-1;
		$enddatetime=-1;
		foreach($ac1 as $key) {
			if(isset($param[$key])) {
				$$key = myhtmlspecialchars($param[$key]);
				if(isset($typei[$key]) && !is_numeric($param[$key])) {
					MSGError("DBNewPeriodonticsii param error: $key is not numeric");
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
			DBExec($c, "begin work", "DBNewPediatricsi(begin)");
		}
		DBExec($c, "lock table pediatricsitable", "DBNewPediatricsi(lock)");

		$ret=1;

		//antes de registrar chekear las claves foraneas
		$sql = "select * from pediatricsitable where patientid=$patient and remissionid= $remission";
		$a = DBGetRow ($sql, 0, $c);
			if($teacher==-1){
				if($a!=null){

					$teacher=$a['teacher'];

					$refer=$a['pediatricsirefer'];
					$reason=$a['pediatricsireason'];
					$vitalsigns=$a['pediatricsivitalsigns'];
					$motconsult=$a['pediatricsimotconsult'];
					$attitude=$a['pediatricsiattitude'];
					$authorization=$a['pediatricsiauthorization'];
					$armchair=$a['pediatricsiarmchair'];
					$prior=$a['pediatricsiprior'];
					$lastattention=$a['pediatricsilastattention'];
					$periodic=$a['pediatricsiperiodic'];
					$experiences=$a['pediatricsiexperiences'];
					$odontoattitude=$a['pediatricsiodontoattitude'];
					$diseases=$a['pediatricsidiseases'];
					$interventions=$a['pediatricsiinterventions'];
					$explanations=$a['pediatricsiexplanations'];
					$experiencesinye=$a['pediatricsiexperiencesinye'];
					$godoctor=$a['pediatricsigodoctor'];
					$consistency=$a['pediatricsiconsistency'];
					$dieta=$a['pediatricsidieta'];
					$bacterialcontrol=$a['pediatricsibacterialcontrol'];
					$fluoridetherapy=$a['pediatricsifluoridetherapy'];
					$sealants=$a['pediatricsisealants'];
					$oralhabits=$a['pediatricsioralhabits'];
					$resumefather=$a['pediatricsiresumefather'];
					$firstvisit=$a['pediatricsifirstvisit'];
					$firstsynthesis=$a['pediatricsifirstsynthesis'];
					$odontogram=$a['pediatricsiodontogram'];
					$odontometa=$a['pediatricsiodontometa'];
					$diagnosisradiographic=$a['pediatricsidiagnosisradiographic'];
					$anomaly=$a['pediatricsianomaly'];
					$cpce=$a['pediatricsicpce'];
					$teethpresent=$a['pediatricsiteethpresent'];
					$teethtype=$a['pediatricsiteethtype'];
					$treatmentplan=$a['pediatricsitreatmentplan'];
					$monitoring=$a['pediatricsimonitoring'];
					$comment=$a['pediatricsicomment'];
					$status=$a['pediatricsistatus'];

				}else{
					$teacher=0;
				}
			}
	      	//para insercion o actulizacion
			if ($a == null) {
				  $ret=2;

	    		$sql = "insert into pediatricsitable(pediatricsirefer, pediatricsireason, pediatricsivitalsigns, pediatricsimotconsult, ".
					"pediatricsiattitude, pediatricsiauthorization, pediatricsiarmchair, pediatricsiprior, pediatricsilastattention, ".
					"pediatricsiperiodic, pediatricsiexperiences, pediatricsiodontoattitude, pediatricsidiseases, ".
					"pediatricsiinterventions, pediatricsiexplanations, pediatricsiexperiencesinye, pediatricsigodoctor, ".
					"pediatricsiconsistency, pediatricsidieta, pediatricsibacterialcontrol, pediatricsifluoridetherapy, ".
					"pediatricsisealants, pediatricsioralhabits, pediatricsiresumefather, pediatricsifirstvisit, ".
					"pediatricsifirstsynthesis, pediatricsiodontogram, pediatricsiodontometa, pediatricsidiagnosisradiographic, pediatricsianomaly, pediatricsicpce, pediatricsiteethpresent, ".
					"pediatricsiteethtype, pediatricsitreatmentplan, pediatricsimonitoring, pediatricsicomment, ".
					"pediatricsistatus, patientid, student, remissionid, teacher, clinicalid, updatetime) values ".
					"('$refer','$reason','$vitalsigns','$motconsult','$attitude','$authorization',$armchair,".
					"'$prior','$lastattention','$periodic','$experiences','$odontoattitude','$diseases',".
					"'$interventions','$explanations','$experiencesinye','$godoctor','$consistency','$dieta',".
					"'$bacterialcontrol','$fluoridetherapy','$sealants','$oralhabits','$resumefather',".
					"'$firstvisit','$firstsynthesis','$odontogram','$odontometa','$diagnosisradiographic','$anomaly','$cpce','$teethpresent','$teethtype',".
					"'$treatmentplan','$monitoring','$comment','$status',$patient, $student, $remission, $teacher, $clinical, $updatetime)";

					DBExec ($c, $sql, "DBNewPediatricsi(insert)");
	    		if($cw) {
	    				DBExec ($c, "commit work");
	    		}
	    		LOGLevel ("Ficha Pediatria I $remission registrado.",2);
			} else {
				if($updatetime > $a['updatetime']) {
					$ret=2;
					$treatmentplan=$a['pediatricsitreatmentplan'];
					$sql = "update pediatricsitable set pediatricsirefer='$refer', pediatricsireason='$reason', ".
					"pediatricsivitalsigns='$vitalsigns', pediatricsimotconsult='$motconsult', pediatricsiattitude='$attitude', ".
					"pediatricsiauthorization='$authorization', pediatricsiarmchair=$armchair, pediatricsiprior='$prior', ".
					"pediatricsilastattention='$lastattention', pediatricsiperiodic='$periodic', pediatricsiexperiences='$experiences', ".
					"pediatricsiodontoattitude='$odontoattitude', pediatricsidiseases='$diseases', pediatricsiinterventions='$interventions', ".
					"pediatricsiexplanations='$explanations', pediatricsiexperiencesinye='$experiencesinye', pediatricsigodoctor='$godoctor', ".
					"pediatricsiconsistency='$consistency', pediatricsidieta='$dieta', pediatricsibacterialcontrol='$bacterialcontrol', ".
					"pediatricsifluoridetherapy='$fluoridetherapy', pediatricsisealants='$sealants', pediatricsioralhabits='$oralhabits', ".
					"pediatricsiresumefather='$resumefather', pediatricsifirstvisit='$firstvisit', pediatricsifirstsynthesis='$firstsynthesis', ".
					"pediatricsiodontogram='$odontogram', pediatricsiodontometa='$odontometa', pediatricsidiagnosisradiographic='$diagnosisradiographic', pediatricsianomaly='$anomaly', pediatricsicpce='$cpce', pediatricsiteethpresent='$teethpresent', pediatricsiteethtype='$teethtype', ".
					"pediatricsitreatmentplan='$treatmentplan', pediatricsimonitoring='$monitoring', pediatricsicomment='$comment', pediatricsistatus='$status', ".
					"student=$student, teacher=$teacher, updatetime=$updatetime";
					if($startdatetime!=-1&&$enddatetime!=-1){
						$sql.=", startdatetime=$startdatetime, enddatetime=$enddatetime";
					}
					$sql.=" where patientid=$patient and remissionid=$remission";
					$r = DBExec ($c, $sql, "DBNewPediatricsi(update)");
					if($cw) {
						DBExec ($c, "commit work");
					}
					LOGLevel("Ficha Pediatricsi I $remission actualizado.",2);
				}
			}

		if($cw) DBExec($c, "commit work");
		return $ret;
}

//funcion para eliminar la tabla de periodoncia
function DBDropPediatricsiOlearyTable() {
    //conexcion de la base de datos..
	 $c = DBConnect();
	 $r = DBExec($c, "drop table \"pediatricsiolearytable\"", "DBDropPediatricsiOlearyTable(drop table)");

}
/*function DBCreatePediatricsiOlearyTable() {
	 $c = DBConnect();
	 $conf = globalconf();
	 if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
	 $r = DBExec($c, "
CREATE TABLE \"pediatricsiolearytable\" (
				\"olearyid\" serial NOT NULL,               			-- (id de oleary)
				\"olearygram\" text DEFAULT '',										-- (grafico)
				\"olearypor\" varchar(100) DEFAULT '',        		-- (porcentaje)
        \"olearydate\" varchar(100) DEFAULT '',   				-- (fecha de registro)
        \"olearyevalued\" bool DEFAULT 'f',          			-- (es revisado)
        \"olearyaccepted\" varchar(300) DEFAULT '',   		-- (firma)
        \"olearyobs\" varchar(300) DEFAULT '',     	 			-- (observaciones)

				\"fileid\" int4 NOT NULL,                    			-- (id de ficha)
				\"student\" int4 NOT NULL,                        -- (id del estudiate)
				\"teacher\" int4 NOT NULL,                        -- (id del docente)
			  \"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
        CONSTRAINT \"oleary_pkey\" PRIMARY KEY (\"olearyid\"),
				CONSTRAINT \"pediatricsi_fk\" FOREIGN KEY ( \"fileid\", \"student\", \"teacher\")
								REFERENCES \"pediatricsitable\" (\"pediatricsiid\", \"student\", \"teacher\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
)", "DBCreatePediatricsiOlearyTable(create table)");

	$r = DBExec($c, "REVOKE ALL ON \"pediatricsiolearytable\" FROM PUBLIC", "DBCreatePediatricsiOlearyTable(revoke public)");
	$r = DBExec($c, "GRANT ALL ON \"pediatricsiolearytable\" TO \"".$conf["dbuser"]."\"", "DBCreatePediatricsiOlearyTable(grant sihcouser)");
	$r = DBExec($c, "CREATE INDEX \"pediatricsioleary_index\" ON \"pediatricsiolearytable\" USING btree ".
				"(\"olearyid\" int4_ops, \"fileid\" int4_ops, \"student\" int4_ops, \"teacher\" int4_ops)",
				"DBCreatePediatricsiOlearyTable(create pediatricsioleary_index)");
}*/
/*
//funcion para eliminar la tabla de periodoncia
function DBDropPediatricsiUrgencyTable() {
    //conexcion de la base de datos..
	 $c = DBConnect();
	 $r = DBExec($c, "drop table \"pediatricsiurgencytable\"", "DBDropPediatricsiUrgencyTable(drop table)");

}
function DBCreatePediatricsiUrgencyTable() {
	 $c = DBConnect();
	 $conf = globalconf();
	 if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
	 $r = DBExec($c, "
CREATE TABLE \"pediatricsiurgencytable\" (
				\"urgencyid\" serial NOT NULL,               	   -- (id de urgencia)
				\"urgencydate\" varchar(300) DEFAULT '',				 -- (fecha)
				\"urgencypart\" varchar(300) DEFAULT '',         -- (pieza)
        \"urgencydiagnosis\" text DEFAULT '',    -- (diagnostico)
        \"urgencytreatment\" varchar(300) DEFAULT '',     -- (tratamiento)
        \"urgencystart\" bool DEFAULT 'f',						   -- (firma)
        \"urgencyend\" bool DEFAULT 'f',     	           -- (conclusion)
        \"urgencyobs\" varchar(300) DEFAULT '',     	   -- (observaciones)

				\"fileid\" int4 NOT NULL,                        -- (id de ficha)
				\"student\" int4 NOT NULL,                       -- (id del estudiate)
				\"teacher\" int4 NOT NULL,                       -- (id del docente)
			  \"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
        CONSTRAINT \"urgency_pkey\" PRIMARY KEY (\"urgencyid\"),
				CONSTRAINT \"pediatricsi_fk\" FOREIGN KEY ( \"fileid\", \"student\", \"teacher\")
								REFERENCES \"pediatricsitable\" (\"pediatricsiid\", \"student\", \"teacher\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
)", "DBCreatePediatricsiUrgencyTable(create table)");

	$r = DBExec($c, "REVOKE ALL ON \"pediatricsiurgencytable\" FROM PUBLIC", "DBCreatePediatricsiUrgencyTable(revoke public)");
	$r = DBExec($c, "GRANT ALL ON \"pediatricsiurgencytable\" TO \"".$conf["dbuser"]."\"", "DBCreatePediatricsiUrgencyTable(grant sihcouser)");
	$r = DBExec($c, "CREATE INDEX \"pediatricsiurgency_index\" ON \"pediatricsiurgencytable\" USING btree ".
				"(\"urgencyid\" int4_ops, \"fileid\" int4_ops, \"student\" int4_ops, \"teacher\" int4_ops)",
				"DBCreatePediatricsiUrgencyTable(create pediatricsiurgency_index)");
}*/

//funcion para eliminar la tabla de periodoncia
function DBDropPediatricsiControlTable() {
    //conexcion de la base de datos..
	 $c = DBConnect();
	 $r = DBExec($c, "drop table \"pediatricsicontroltable\"", "DBDropPediatricsiControlTable(drop table)");

}
function DBCreatePediatricsiControlTable() {
	 $c = DBConnect();
	 $conf = globalconf();
	 if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
	 $r = DBExec($c, "
CREATE TABLE \"pediatricsicontroltable\" (
				\"controlid\" serial NOT NULL,               	   -- (id de control)
				\"controldate\" varchar(300) DEFAULT '',				 -- (fecha)
				\"controlpart\" varchar(300) DEFAULT '',         -- (pieza)
        \"controldiagnosis\" text DEFAULT '',    -- (diagnostico)
        \"controltreatment\" varchar(300) DEFAULT '',     -- (tratamiento)
        \"controltype\" varchar(100) DEFAULT '',     -- (tipo de control)
        \"controlstart\" varchar(50) DEFAULT '',						   -- (firma)
        \"controlend\" varchar(50) DEFAULT '',     	           -- (conclusion)
        \"controlobs\" varchar(300) DEFAULT '',     	   -- (observaciones)

				\"fileid\" int4 NOT NULL,                        -- (id de ficha)
				\"student\" int4 NOT NULL,                       -- (id del estudiate)
				\"teacher\" int4 NOT NULL,                       -- (id del docente)
			  \"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
        CONSTRAINT \"control_pkey\" PRIMARY KEY (\"controlid\"),
				CONSTRAINT \"pediatricsi_fk\" FOREIGN KEY ( \"fileid\", \"student\", \"teacher\")
								REFERENCES \"pediatricsitable\" (\"pediatricsiid\", \"student\", \"teacher\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
)", "DBCreatePediatricsiControlTable(create table)");

	$r = DBExec($c, "REVOKE ALL ON \"pediatricsicontroltable\" FROM PUBLIC", "DBCreatePediatricsiControlTable(revoke public)");
	$r = DBExec($c, "GRANT ALL ON \"pediatricsicontroltable\" TO \"".$conf["dbuser"]."\"", "DBCreatePediatricsiControlTable(grant sihcouser)");
	$r = DBExec($c, "CREATE INDEX \"pediatricsicontrol_index\" ON \"pediatricsicontroltable\" USING btree ".
				"(\"controlid\" int4_ops, \"fileid\" int4_ops, \"student\" int4_ops, \"teacher\" int4_ops)",
				"DBCreatePediatricsiControlTable(create pediatricsicontrol_index)");
}
//para crear urgencias o actualizar
function DBNewPediatricsiControl($param , $c=null){

		if(isset($param['fileid']) && !isset($param['file'])) $param['file']=$param['fileid'];
		if(isset($param['studentid']) && !isset($param['student'])) $param['student']=$param['studentid'];
		if(isset($param['teacherid']) && !isset($param['teacher'])) $param['teacher']=$param['teacherid'];

		//if(isset($param['pediatricsiid']) && !isset($param['id'])) $param['id']=$param['pediatricsiid'];
		if(isset($param['controlid']) && !isset($param['id'])) $param['id']=$param['controlid'];
		if(isset($param['controldate']) && !isset($param['date'])) $param['date']=$param['controldate'];
		if(isset($param['controlpart']) && !isset($param['part'])) $param['part']=$param['controlpart'];
		if(isset($param['controldiagnosis']) && !isset($param['diagnosis'])) $param['diagnosis']=$param['controldiagnosis'];
		if(isset($param['controltreatment']) && !isset($param['treatment'])) $param['treatment']=$param['controltreatment'];
		if(isset($param['controltype']) && !isset($param['type'])) $param['type']=$param['controltype'];
		if(isset($param['controlstart']) && !isset($param['start'])) $param['start']=$param['controlstart'];
		if(isset($param['controlend']) && !isset($param['end'])) $param['end']=$param['controlend'];
		if(isset($param['controlobs']) && !isset($param['obs'])) $param['obs']=$param['controlobs'];

		$ac=array('file', 'student', 'teacher', 'id');
		$ac1=array('date','part','diagnosis','treatment','type','start','end','obs','updatetime');
		$typei['file']=-1;
		$typei['student']=-1;
		$typei['teacher']=-1;//admin
		$typei['id']=-1;//clinica periodoncia II
		$typei['updatetime']=-1;//clinica periodoncia II


		foreach($ac as $key) {
			if(!isset($param[$key]) || $param[$key]=="") {
				MSGError("DBNewPediatricsiControl param error: $key not found");
				return false;
			}
			if(isset($typei[$key]) && !is_numeric($param[$key])) {
				MSGError("DBNewPediatricsiControl param error: $key is not numeric");
				return false;
			}
			$$key = myhtmlspecialchars($param[$key]);
		}

		$date='';
		$part='';
		$diagnosis='';
		$treatment='';
		$type='';
		$start='';
		$end='';
		$obs='';


		$updatetime=-1;
		foreach($ac1 as $key) {
			if(isset($param[$key])) {
				$$key = myhtmlspecialchars($param[$key]);
				if(isset($typei[$key]) && !is_numeric($param[$key])) {
					MSGError("DBNewPediatricsiControl param error: $key is not numeric");
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
			DBExec($c, "begin work", "DBNewPediatricsiControl(begin)");
		}
		DBExec($c, "lock table pediatricsicontroltable", "DBNewPediatricsiControl(lock)");

		$ret=1;

		//antes de registrar chekear las claves foraneas
		$sql = "select * from pediatricsicontroltable where controlid=$id and fileid= $file";
		$a = DBGetRow ($sql, 0, $c);

	    //para insercion o actulizacion
			if ($a == null) {
				  $ret=2;

	    		$sql = "insert into pediatricsicontroltable(controldate, controlpart,	controldiagnosis,	".
					"controltreatment, controltype, controlstart,	controlend,	controlobs,	fileid,	student,	teacher, updatetime) values ".
					"('$date', '$part', '$diagnosis', '$treatment', '$type', '$start', '$end', '$obs', $file, $student, $teacher, $updatetime)";

					DBExec ($c, $sql, "DBNewPediatricsiControl(insert)");
	    		if($cw) {
	    				DBExec ($c, "commit work");
	    		}
	    		LOGLevel ("Ficha Pediatria I Control $file registrado.",2);

			} else {
				if($updatetime > $a['updatetime']) {
					$ret=2;
					$sql = "update pediatricsicontroltable set controldate='$date', controlpart='$part', ".
					"controldiagnosis='$diagnosis', controltreatment='$treatment', controltype='$type', controlstart='$start', ".
					"controlend='$end', controlobs='$obs', updatetime=$updatetime, ".
					"student=$student, teacher=$teacher " .
					"where controlid=$id and fileid=$file";

					$r = DBExec ($c, $sql, "DBNewPediatricsiControl(update)");
					if($cw) {
						DBExec ($c, "commit work");
					}
					LOGLevel("Ficha Pediatricsi I Control $id actualizado.",2);
				}
			}

		if($cw) DBExec($c, "commit work");
		return $ret;
}
function DBDeletePediatricsiControl($id){

	$c = DBConnect();
	DBExec($c, "begin work");
	DBExec($c, "lock table pediatricsicontroltable");
	$sql = "select * from pediatricsicontroltable where controlid=$id for update";
	$a = DBGetRow ($sql, 0, $c);
	if ($a != null) {
			//echo "yes delete";
      $sql = "delete from pediatricsicontroltable where controlid=$id";
			DBExec ($c, $sql);

			DBExec($c, "commit work");//para el commit de exito
	} else {
		DBExec($c, "rollback work");
		LOGLevel("Control controlid = $id could not be removed.", 1);
		return false;
	}
}
function DBAllPediatricsiControlInfo($file, $type='') {

	$sql = "select *from pediatricsicontroltable where fileid=$file";
	if($type!=''){
		$sql.=" and controltype='$type'";
	}
	$sql.=" order by controlid asc";
	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBAllPediatricsiControlInfo(gets control)");
	$n = DBnlines($r);

	$a = array();
	for ($i=0;$i<$n;$i++) {
		$a[$i] = DBRow($r,$i);
		if($a[$i]['controltype']=='pulpar' || $a[$i]['controltype']=='rehabilitation'){
			$a[$i]=clearsessioncontrol($a[$i], $a[$i]['controltype']);
		}
	}
	return $a;
}
function clearsessioncontrol($a, $type){
	if(isset($a['controlstart'])&& $a['controlstart']!=''){
		$r=explode('[',$a['controlstart']);
		$r=explode(',',$r[1]);
		$size=count($r);
		for ($i=0; $i <$size-1 ; $i++) {
			//sessionpulpar-0
			$a[$a['controlid'].'session'.$type.'-'.$i]=trim($r[$i]);
		}
	}

	return $a;
}
//para crear urgencias o actualizar
/*function DBNewPediatricsiUrgency($param , $c=null){

		if(isset($param['fileid']) && !isset($param['file'])) $param['file']=$param['fileid'];
		if(isset($param['studentid']) && !isset($param['student'])) $param['student']=$param['studentid'];
		if(isset($param['teacherid']) && !isset($param['teacher'])) $param['teacher']=$param['teacherid'];

		//if(isset($param['pediatricsiid']) && !isset($param['id'])) $param['id']=$param['pediatricsiid'];
		if(isset($param['urgencyid']) && !isset($param['id'])) $param['id']=$param['urgencyid'];
		if(isset($param['urgencydate']) && !isset($param['date'])) $param['date']=$param['urgencydate'];
		if(isset($param['urgencypart']) && !isset($param['part'])) $param['part']=$param['urgencypart'];
		if(isset($param['urgencydiagnosis']) && !isset($param['diagnosis'])) $param['diagnosis']=$param['urgencydiagnosis'];
		if(isset($param['urgencytreatment']) && !isset($param['treatment'])) $param['treatment']=$param['urgencytreatment'];
		if(isset($param['urgencystart']) && !isset($param['start'])) $param['start']=$param['urgencystart'];
		if(isset($param['urgencyend']) && !isset($param['end'])) $param['end']=$param['urgencyend'];
		if(isset($param['urgencyobs']) && !isset($param['obs'])) $param['obs']=$param['urgencyobs'];

		$ac=array('file', 'student', 'teacher', 'id');
		$ac1=array('date','part','diagnosis','treatment','start','end','obs');
		$typei['file']=-1;
		$typei['student']=-1;
		$typei['teacher']=-1;//admin
		$typei['id']=-1;//clinica periodoncia II


		foreach($ac as $key) {
			if(!isset($param[$key]) || $param[$key]=="") {
				MSGError("DBNewPediatricsiUrgency param error: $key not found");
				return false;
			}
			if(isset($typei[$key]) && !is_numeric($param[$key])) {
				MSGError("DBNewPediatricsiUrgency param error: $key is not numeric");
				return false;
			}
			$$key = myhtmlspecialchars($param[$key]);
		}

		$date='';
		$part='';
		$diagnosis='';
		$treatment='';
		$start='f';
		$end='f';
		$obs='';


		$updatetime=-1;
		foreach($ac1 as $key) {
			if(isset($param[$key])) {
				$$key = myhtmlspecialchars($param[$key]);
				if(isset($typei[$key]) && !is_numeric($param[$key])) {
					MSGError("DBNewPediatricsiUrgency param error: $key is not numeric");
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
			DBExec($c, "begin work", "DBNewPediatricsiUrgency(begin)");
		}
		DBExec($c, "lock table pediatricsiurgencytable", "DBNewPediatricsiUrgency(lock)");

		$ret=1;

		//antes de registrar chekear las claves foraneas
		$sql = "select * from pediatricsiurgencytable where urgencyid=$id and fileid= $file";
		$a = DBGetRow ($sql, 0, $c);

	    //para insercion o actulizacion
			if ($a == null) {
				  $ret=2;

	    		$sql = "insert into pediatricsiurgencytable(urgencydate, urgencypart,	urgencydiagnosis,	".
					"urgencytreatment,	urgencystart,	urgencyend,	urgencyobs,	fileid,	student,	teacher) values ".
					"('$date', '$part', '$diagnosis', '$treatment', '$start', '$end', '$obs', $file, $student, $teacher)";

					DBExec ($c, $sql, "DBNewPediatricsiUrgency(insert)");
	    		if($cw) {
	    				DBExec ($c, "commit work");
	    		}
	    		LOGLevel ("Ficha Pediatria I Urgencias $file registrado.",2);

			} else {
				if($updatetime > $a['updatetime']) {
					$ret=2;
					$sql = "update pediatricsiurgencytable set urgencydate='$date', urgencypart='$part', ".
					"urgencydiagnosis='$diagnosis', urgencytreatment='$treatment', urgencystart='$start', ".
					"urgencyend='$end', urgencyobs='$obs', updatetime=$updatetime, ".
					"student=$student, teacher=$teacher " .
					"where urgencyid=$id and fileid=$file";

					$r = DBExec ($c, $sql, "DBNewPediatricsiUrgency(update)");
					if($cw) {
						DBExec ($c, "commit work");
					}
					LOGLevel("Ficha Pediatricsi I Urgencias $id actualizado.",2);
				}
			}

		if($cw) DBExec($c, "commit work");
		return $ret;
}
function DBDeletePediatricsiUrgency($id){

	$c = DBConnect();
	DBExec($c, "begin work");
	DBExec($c, "lock table pediatricsiurgencytable");
	$sql = "select * from pediatricsiurgencytable where urgencyid=$id for update";
	$a = DBGetRow ($sql, 0, $c);
	if ($a != null) {
			//echo "yes delete";
      $sql = "delete from pediatricsiurgencytable where urgencyid=$id";
			DBExec ($c, $sql);

			DBExec($c, "commit work");//para el commit de exito
	} else {
		DBExec($c, "rollback work");
		LOGLevel("Observation urgencyid = $id could not be removed.", 1);
		return false;
	}
}
function DBAllPediatricsiUrgencyInfo($file) {

	$sql = "select *from pediatricsiurgencytable where fileid=$file";

	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBAllPediatricsiUrgencyInfo(gets urgency)");
	$n = DBnlines($r);

	$a = array();
	for ($i=0;$i<$n;$i++) {
		$a[$i] = DBRow($r,$i);
	}
	return $a;
}*/
function InArray($array, $element){
	for ($i=0; $i < count($array); $i++) {
		if($array[$i]==$element)
			return $i;
	}
	return false;
}

function DBAllControlFirmInfo($file) {

	$sql = "select *from pediatricsicontroltable where fileid=$file and (controlstart='f' or controlend='f')";

	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBAllControlFirmInfo(gets Firms)");
	$n = DBnlines($r);

	$a = array();
	for ($i=0;$i<$n;$i++) {
		$a[$i] = DBRow($r,$i);
	}
	return $a;
}

function DBDropPediatricsiInactivationTable() {
    //conexcion de la base de datos..
	 $c = DBConnect();
	 $r = DBExec($c, "drop table \"pediatricsiinactivationtable\"", "DBDropPediatricsiInactivationTable(drop table)");

}
function DBCreatePediatricsiInactivationTable() {
	 $c = DBConnect();
	 $conf = globalconf();
	 if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
	 $r = DBExec($c, "
CREATE TABLE \"pediatricsiinactivationtable\" (
				\"inactivationid\" serial NOT NULL,               	   -- (id de urgencia)
				\"inactivationdate\" varchar(300) DEFAULT '',				 -- (fecha)
				\"inactivationpart\" varchar(300) DEFAULT '',         -- (pieza)
        \"inactivationdiagnosis\" text DEFAULT '',    -- (diagnostico)
        \"inactivationtreatment\" varchar(300) DEFAULT '',     -- (tratamiento)
        \"inactivationstart\" bool DEFAULT 'f',						   -- (firma)
        \"inactivationend\" bool DEFAULT 'f',     	           -- (conclusion)
        \"inactivationobs\" varchar(300) DEFAULT '',     	   -- (observaciones)

				\"fileid\" int4 NOT NULL,                        -- (id de ficha)
				\"student\" int4 NOT NULL,                       -- (id del estudiate)
				\"teacher\" int4 NOT NULL,                       -- (id del docente)
			  \"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
        CONSTRAINT \"inactivation_pkey\" PRIMARY KEY (\"inactivationid\"),
				CONSTRAINT \"pediatricsi_fk\" FOREIGN KEY ( \"fileid\", \"student\", \"teacher\")
								REFERENCES \"pediatricsitable\" (\"pediatricsiid\", \"student\", \"teacher\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
)", "DBCreatePediatricsiInactivationTable(create table)");

	$r = DBExec($c, "REVOKE ALL ON \"pediatricsiinactivationtable\" FROM PUBLIC", "DBCreatePediatricsiInactivationTable(revoke public)");
	$r = DBExec($c, "GRANT ALL ON \"pediatricsiinactivationtable\" TO \"".$conf["dbuser"]."\"", "DBCreatePediatricsiInactivationTable(grant sihcouser)");
	$r = DBExec($c, "CREATE INDEX \"pediatricsiinactivation_index\" ON \"pediatricsiinactivationtable\" USING btree ".
				"(\"inactivationid\" int4_ops, \"fileid\" int4_ops, \"student\" int4_ops, \"teacher\" int4_ops)",
				"DBCreatePediatricsiInactivationTable(create pediatricsiinactivation_index)");
}

function DBDropPediatricsiControlqmTable() {
    //conexcion de la base de datos..
	 $c = DBConnect();
	 $r = DBExec($c, "drop table \"pediatricsicontrolqmtable\"", "DBDropPediatricsiControlqmTable(drop table)");

}
function DBCreatePediatricsiControlqmTable() {
	 $c = DBConnect();
	 $conf = globalconf();
	 if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
	 $r = DBExec($c, "
CREATE TABLE \"pediatricsicontrolqmtable\" (
				\"controlqmid\" serial NOT NULL,               	   -- (id de urgencia)
				\"controlqmdate\" varchar(300) DEFAULT '',				 -- (fecha)
				\"controlqmpart\" varchar(300) DEFAULT '',         -- (pieza)
        \"controlqmdiagnosis\" text DEFAULT '',    -- (diagnostico)
        \"controlqmtreatment\" varchar(300) DEFAULT '',     -- (tratamiento)
        \"controlqmstart\" bool DEFAULT 'f',						   -- (firma)
        \"controlqmend\" bool DEFAULT 'f',     	           -- (conclusion)
        \"controlqmobs\" varchar(300) DEFAULT '',     	   -- (observaciones)

				\"fileid\" int4 NOT NULL,                        -- (id de ficha)
				\"student\" int4 NOT NULL,                       -- (id del estudiate)
				\"teacher\" int4 NOT NULL,                       -- (id del docente)
			  \"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
        CONSTRAINT \"controlqm_pkey\" PRIMARY KEY (\"controlqmid\"),
				CONSTRAINT \"pediatricsi_fk\" FOREIGN KEY ( \"fileid\", \"student\", \"teacher\")
								REFERENCES \"pediatricsitable\" (\"pediatricsiid\", \"student\", \"teacher\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
)", "DBCreatePediatricsiControlqmTable(create table)");

	$r = DBExec($c, "REVOKE ALL ON \"pediatricsicontrolqmtable\" FROM PUBLIC", "DBCreatePediatricsiControlqmTable(revoke public)");
	$r = DBExec($c, "GRANT ALL ON \"pediatricsicontrolqmtable\" TO \"".$conf["dbuser"]."\"", "DBCreatePediatricsiControlqmTable(grant sihcouser)");
	$r = DBExec($c, "CREATE INDEX \"pediatricsicontrolqm_index\" ON \"pediatricsicontrolqmtable\" USING btree ".
				"(\"controlqmid\" int4_ops, \"fileid\" int4_ops, \"student\" int4_ops, \"teacher\" int4_ops)",
				"DBCreatePediatricsiControlqmTable(create pediatricsicontrolqm_index)");
}

function DBDropPediatricsiMorphologicalTable() {
    //conexcion de la base de datos..
	 $c = DBConnect();
	 $r = DBExec($c, "drop table \"pediatricsimorphologicaltable\"", "DBDropPediatricsiMorphologicalTable(drop table)");

}
function DBCreatePediatricsiMorphologicalTable() {
	 $c = DBConnect();
	 $conf = globalconf();
	 if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
	 $r = DBExec($c, "
CREATE TABLE \"pediatricsimorphologicaltable\" (
				\"morphologicalid\" serial NOT NULL,               	   -- (id de urgencia)
				\"morphologicaldate\" varchar(300) DEFAULT '',				 -- (fecha)
				\"morphologicalpart\" varchar(300) DEFAULT '',         -- (pieza)
        \"morphologicaldiagnosis\" text DEFAULT '',    -- (diagnostico)
        \"morphologicaltreatment\" varchar(300) DEFAULT '',     -- (tratamiento)
        \"morphologicalstart\" bool DEFAULT 'f',						   -- (firma)
        \"morphologicalend\" bool DEFAULT 'f',     	           -- (conclusion)
        \"morphologicalobs\" varchar(300) DEFAULT '',     	   -- (observaciones)

				\"fileid\" int4 NOT NULL,                        -- (id de ficha)
				\"student\" int4 NOT NULL,                       -- (id del estudiate)
				\"teacher\" int4 NOT NULL,                       -- (id del docente)
			  \"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
        CONSTRAINT \"morphological_pkey\" PRIMARY KEY (\"morphologicalid\"),
				CONSTRAINT \"pediatricsi_fk\" FOREIGN KEY ( \"fileid\", \"student\", \"teacher\")
								REFERENCES \"pediatricsitable\" (\"pediatricsiid\", \"student\", \"teacher\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
)", "DBCreatePediatricsiMorphologicalTable(create table)");

	$r = DBExec($c, "REVOKE ALL ON \"pediatricsimorphologicaltable\" FROM PUBLIC", "DBCreatePediatricsiMorphologicalTable(revoke public)");
	$r = DBExec($c, "GRANT ALL ON \"pediatricsimorphologicaltable\" TO \"".$conf["dbuser"]."\"", "DBCreatePediatricsiMorphologicalTable(grant sihcouser)");
	$r = DBExec($c, "CREATE INDEX \"pediatricsimorphological_index\" ON \"pediatricsimorphologicaltable\" USING btree ".
				"(\"morphologicalid\" int4_ops, \"fileid\" int4_ops, \"student\" int4_ops, \"teacher\" int4_ops)",
				"DBCreatePediatricsiMorphologicalTable(create pediatricsimorphological_index)");
}

function DBDropPediatricsiStructuralTable() {
    //conexcion de la base de datos..
	 $c = DBConnect();
	 $r = DBExec($c, "drop table \"pediatricsistructuraltable\"", "DBDropPediatricsiStructuralTable(drop table)");

}
function DBCreatePediatricsiStructuralTable() {
	 $c = DBConnect();
	 $conf = globalconf();
	 if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
	 $r = DBExec($c, "
CREATE TABLE \"pediatricsistructuraltable\" (
				\"structuralid\" serial NOT NULL,               	   -- (id de urgencia)
				\"structuraldate\" varchar(300) DEFAULT '',				 -- (fecha)
				\"structuralpart\" varchar(300) DEFAULT '',         -- (pieza)
        \"structuraldiagnosis\" text DEFAULT '',    -- (diagnostico)
        \"structuraltreatment\" varchar(300) DEFAULT '',     -- (tratamiento)
        \"structuralstart\" bool DEFAULT 'f',						   -- (firma)
        \"structuralend\" bool DEFAULT 'f',     	           -- (conclusion)
        \"structuralobs\" varchar(300) DEFAULT '',     	   -- (observaciones)

				\"fileid\" int4 NOT NULL,                        -- (id de ficha)
				\"student\" int4 NOT NULL,                       -- (id del estudiate)
				\"teacher\" int4 NOT NULL,                       -- (id del docente)
			  \"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
        CONSTRAINT \"structural_pkey\" PRIMARY KEY (\"structuralid\"),
				CONSTRAINT \"pediatricsi_fk\" FOREIGN KEY ( \"fileid\", \"student\", \"teacher\")
								REFERENCES \"pediatricsitable\" (\"pediatricsiid\", \"student\", \"teacher\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
)", "DBCreatePediatricsiStructuralTable(create table)");

	$r = DBExec($c, "REVOKE ALL ON \"pediatricsistructuraltable\" FROM PUBLIC", "DBCreatePediatricsiStructuralTable(revoke public)");
	$r = DBExec($c, "GRANT ALL ON \"pediatricsistructuraltable\" TO \"".$conf["dbuser"]."\"", "DBCreatePediatricsiStructuralTable(grant sihcouser)");
	$r = DBExec($c, "CREATE INDEX \"pediatricsistructural_index\" ON \"pediatricsistructuraltable\" USING btree ".
				"(\"structuralid\" int4_ops, \"fileid\" int4_ops, \"student\" int4_ops, \"teacher\" int4_ops)",
				"DBCreatePediatricsiStructuralTable(create pediatricsistructural_index)");
}

function DBDropPediatricsiPulpTable() {
    //conexcion de la base de datos..
	 $c = DBConnect();
	 $r = DBExec($c, "drop table \"pediatricsipulptable\"", "DBDropPediatricsiPulpTable(drop table)");

}
function DBCreatePediatricsiPulpTable() {
	 $c = DBConnect();
	 $conf = globalconf();
	 if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
	 $r = DBExec($c, "
CREATE TABLE \"pediatricsipulptable\" (
				\"pulpid\" serial NOT NULL,               	   -- (id de urgencia)
				\"pulpdate\" varchar(300) DEFAULT '',				 -- (fecha)
				\"pulppart\" varchar(300) DEFAULT '',         -- (pieza)
        \"pulpdiagnosis\" text DEFAULT '',    -- (diagnostico)
        \"pulptreatment\" varchar(300) DEFAULT '',     -- (tratamiento)
        \"pulpsessions\" text DEFAULT '',						   -- (sesiones)
        \"pulpstart\" bool DEFAULT 'f',						   -- (firma)
        \"pulpend\" bool DEFAULT 'f',     	           -- (conclusion)
        \"pulpobs\" varchar(300) DEFAULT '',     	   -- (observaciones)

				\"fileid\" int4 NOT NULL,                        -- (id de ficha)
				\"student\" int4 NOT NULL,                       -- (id del estudiate)
				\"teacher\" int4 NOT NULL,                       -- (id del docente)
			  \"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
        CONSTRAINT \"pulp_pkey\" PRIMARY KEY (\"pulpid\"),
				CONSTRAINT \"pediatricsi_fk\" FOREIGN KEY ( \"fileid\", \"student\", \"teacher\")
								REFERENCES \"pediatricsitable\" (\"pediatricsiid\", \"student\", \"teacher\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
)", "DBCreatePediatricsiPulpTable(create table)");

	$r = DBExec($c, "REVOKE ALL ON \"pediatricsipulptable\" FROM PUBLIC", "DBCreatePediatricsiPulpTable(revoke public)");
	$r = DBExec($c, "GRANT ALL ON \"pediatricsipulptable\" TO \"".$conf["dbuser"]."\"", "DBCreatePediatricsiPulpTable(grant sihcouser)");
	$r = DBExec($c, "CREATE INDEX \"pediatricsipulp_index\" ON \"pediatricsipulptable\" USING btree ".
				"(\"pulpid\" int4_ops, \"fileid\" int4_ops, \"student\" int4_ops, \"teacher\" int4_ops)",
				"DBCreatePediatricsiPulpTable(create pediatricsipulp_index)");
}

function DBDropPediatricsiSurgeryTable() {
    //conexcion de la base de datos..
	 $c = DBConnect();
	 $r = DBExec($c, "drop table \"pediatricsisurgerytable\"", "DBDropPediatricsiSurgeryTable(drop table)");

}
function DBCreatePediatricsiSurgeryTable() {
	 $c = DBConnect();
	 $conf = globalconf();
	 if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
	 $r = DBExec($c, "
CREATE TABLE \"pediatricsisurgerytable\" (
				\"surgeryid\" serial NOT NULL,               	   -- (id de urgencia)
				\"surgerydate\" varchar(300) DEFAULT '',				 -- (fecha)
				\"surgerypart\" varchar(300) DEFAULT '',         -- (pieza)
        \"surgerydiagnosis\" text DEFAULT '',    -- (diagnostico)
        \"surgerytreatment\" varchar(300) DEFAULT '',     -- (tratamiento)
        \"surgerystart\" bool DEFAULT 'f',						   -- (firma)
        \"surgeryend\" bool DEFAULT 'f',     	           -- (conclusion)
        \"surgeryobs\" varchar(300) DEFAULT '',     	   -- (observaciones)

				\"fileid\" int4 NOT NULL,                        -- (id de ficha)
				\"student\" int4 NOT NULL,                       -- (id del estudiate)
				\"teacher\" int4 NOT NULL,                       -- (id del docente)
			  \"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
        CONSTRAINT \"surgery_pkey\" PRIMARY KEY (\"surgeryid\"),
				CONSTRAINT \"pediatricsi_fk\" FOREIGN KEY ( \"fileid\", \"student\", \"teacher\")
								REFERENCES \"pediatricsitable\" (\"pediatricsiid\", \"student\", \"teacher\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
)", "DBCreatePediatricsiSurgeryTable(create table)");

	$r = DBExec($c, "REVOKE ALL ON \"pediatricsisurgerytable\" FROM PUBLIC", "DBCreatePediatricsiSurgeryTable(revoke public)");
	$r = DBExec($c, "GRANT ALL ON \"pediatricsisurgerytable\" TO \"".$conf["dbuser"]."\"", "DBCreatePediatricsiSurgeryTable(grant sihcouser)");
	$r = DBExec($c, "CREATE INDEX \"pediatricsisurgery_index\" ON \"pediatricsisurgerytable\" USING btree ".
				"(\"surgeryid\" int4_ops, \"fileid\" int4_ops, \"student\" int4_ops, \"teacher\" int4_ops)",
				"DBCreatePediatricsiSurgeryTable(create pediatricsisurgery_index)");
}

function DBDropPediatricsiRehabilitationTable() {
    //conexcion de la base de datos..
	 $c = DBConnect();
	 $r = DBExec($c, "drop table \"pediatricsirehabilitationtable\"", "DBDropPediatricsiRehabilitationTable(drop table)");

}
function DBCreatePediatricsiRehabilitationTable() {
	 $c = DBConnect();
	 $conf = globalconf();
	 if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
	 $r = DBExec($c, "
CREATE TABLE \"pediatricsirehabilitationtable\" (
				\"rehabilitationid\" serial NOT NULL,               	   -- (id de urgencia)
				\"rehabilitationdate\" varchar(300) DEFAULT '',				 -- (fecha)
				\"rehabilitationpart\" varchar(300) DEFAULT '',         -- (pieza)
        \"rehabilitationdiagnosis\" text DEFAULT '',    -- (diagnostico)
        \"rehabilitationtreatment\" varchar(300) DEFAULT '',     -- (tratamiento)
        \"rehabilitationsessions\" text DEFAULT '',						   -- (sesiones)
        \"rehabilitationstart\" bool DEFAULT 'f',						   -- (firma)
        \"rehabilitationend\" bool DEFAULT 'f',     	           -- (conclusion)
        \"rehabilitationobs\" varchar(300) DEFAULT '',     	   -- (observaciones)

				\"fileid\" int4 NOT NULL,                        -- (id de ficha)
				\"student\" int4 NOT NULL,                       -- (id del estudiate)
				\"teacher\" int4 NOT NULL,                       -- (id del docente)
			  \"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
        CONSTRAINT \"rehabilitation_pkey\" PRIMARY KEY (\"rehabilitationid\"),
				CONSTRAINT \"pediatricsi_fk\" FOREIGN KEY ( \"fileid\", \"student\", \"teacher\")
								REFERENCES \"pediatricsitable\" (\"pediatricsiid\", \"student\", \"teacher\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
)", "DBCreatePediatricsiRehabilitationTable(create table)");

	$r = DBExec($c, "REVOKE ALL ON \"pediatricsirehabilitationtable\" FROM PUBLIC", "DBCreatePediatricsiRehabilitationTable(revoke public)");
	$r = DBExec($c, "GRANT ALL ON \"pediatricsirehabilitationtable\" TO \"".$conf["dbuser"]."\"", "DBCreatePediatricsiRehabilitationTable(grant sihcouser)");
	$r = DBExec($c, "CREATE INDEX \"pediatricsirehabilitation_index\" ON \"pediatricsirehabilitationtable\" USING btree ".
				"(\"rehabilitationid\" int4_ops, \"fileid\" int4_ops, \"student\" int4_ops, \"teacher\" int4_ops)",
				"DBCreatePediatricsiRehabilitationTablepTable(create pediatricsirehabilitation_index)");
}

//funcion para eliminar una remision equivocada
function DBDeletePediatricsi($remission){

	$c = DBConnect();
	DBExec($c, "begin work");
	DBExec($c, "lock table pediatricsitable");
	$sql = "select * from pediatricsitable where remissionid=$remission for update";
	$a = DBGetRow ($sql, 0, $c);
	$yes=false;
	if ($a != null) {
			//echo "yes delete";
      $sql = "delete from pediatricsitable where remissionid=$remission";
			DBExec ($c, $sql);
			DBExec($c, "commit work");//para el commit de exito
			$yes=true;
	} else {
		echo "no delete";
		DBExec($c, "rollback work");
		LOGLevel("Pediatricsi remissionid = $remission could not be removed.", 1);
		return false;
	}
	if($yes)
		DBDeleteObservation($remission);
}
//funcion para eliminar una remision equivocada
function DBDeleteOrthodontics($remission){

	$c = DBConnect();
	DBExec($c, "begin work");
	DBExec($c, "lock table orthodonticstable");
	$sql = "select * from orthodonticstable where remissionid=$remission for update";
	$a = DBGetRow ($sql, 0, $c);
	$yes=false;
	if ($a != null) {
			//echo "yes delete";
      $sql = "delete from orthodonticstable where remissionid=$remission";
			DBExec ($c, $sql);
			DBExec($c, "commit work");//para el commit de exito
			$yes=true;
	} else {
		echo "no delete";
		DBExec($c, "rollback work");
		LOGLevel("Orthodontics remissionid = $remission could not be removed.", 1);
		return false;
	}
	if($yes)
		DBDeleteObservation($remission);
}
//funcion para sacar la informacion de un docente designado
function DBAllPediatricsTeacherInfo($user, $clinical, $limit=100){
	$sql = "select c.clinicalid as clinical, r.remissionid as remission, pe.pediatricsiid as ficha, p.patientfullname as patientfullname,
de.motconsult as consult, c.clinicalspecialty as clinicalname, u.userfullname as student,
pe.pediatricsistatus as status, pe.updatetime as time from pediatricsitable
as pe, usertable as u, patienttable as p, clinicaltable as c, dentalexamtable as de, remissiontable as r
where (pe.teacher=$user or pe.pediatricsirev LIKE '%[$user]%') and pe.pediatricsistatus!='new' and p.patientid=pe.patientid and de.patientid=r.patientid and
de.dentalid=r.patientdentalid and r.remissionid=pe.remissionid and pe.clinicalid=$clinical and c.clinicalid=r.clinicalid and
r.examined=pe.student and u.usernumber=r.examined order by pe.updatetime desc limit $limit";

	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBAllPeriodonticsTeacherInfo(get all surgeryii)");
	$n = DBnlines($r);

	$a = array();
	for ($i=0;$i<$n;$i++) {
		$a[$i] = DBRow($r,$i);
		//para sacar la observacion de cada ficha clinica
		$ob=DBObservationInfo2($a[$i]['ficha'], $a[$i]['remission']);
		if($ob!=null)
			$a[$i]=array_merge($a[$i],$ob);
		$a[$i]['file']='pediatricsi';
		$a[$i]['diagnosis']='';
	}

	return $a;
}
//funcion para sacar la informacion de un docente designado
function DBAllOrthodonticsTeacherInfo($user, $clinical, $limit=100){
	$sql = "select c.clinicalid as clinical, r.remissionid as remission, o.orthodonticsid as ficha, p.patientfullname as patientfullname,
de.motconsult as consult, c.clinicalspecialty as clinicalname, u.userfullname as student,
o.orthodonticsdiagnosisdef as diagnosis, o.orthodonticsstatus as status, o.updatetime as time from orthodonticstable
as o, usertable as u, patienttable as p, clinicaltable as c, dentalexamtable as de, remissiontable as r
where o.teacher=$user and o.orthodonticsstatus!='new' and p.patientid=o.patientid and de.patientid=r.patientid and
de.dentalid=r.patientdentalid and r.remissionid=o.remissionid and o.clinicalid=$clinical and c.clinicalid=r.clinicalid and
r.examined=o.student and u.usernumber=r.examined order by o.updatetime desc limit $limit";

	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBAllOrthodonticsTeacherInfo(get all orthodontics)");
	$n = DBnlines($r);

	$a = array();
	for ($i=0;$i<$n;$i++) {
		$a[$i] = DBRow($r,$i);
		//para sacar la observacion de cada ficha clinica
		$ob=DBObservationInfo2($a[$i]['ficha'], $a[$i]['remission']);
		if($ob!=null)
			$a[$i]=array_merge($a[$i],$ob);
		$a[$i]['file']='orthodontics';
	}

	return $a;
}
function DBEvaluatePediatrics($desc, $evaluated, $accepted, $status, $record, $c=null){
	$cw = false;
	if($c == null) {
		$cw = true;
		$c = DBConnect();
		DBExec($c, "begin work", "DBEvaluatePediatrics(begin)");
	}
	//DBExec($c, "lock table surgeryiitable", "DBEvaluate(lock)");
	$updatetime=time();

	$ret=2;
	$sql = "update pediatricsitable set pediatricsistatus='$status', ";
	if($status=='end')
		$sql.="enddatetime=$updatetime, ";
	$sql.="updatetime=$updatetime where pediatricsiid=$record";

	DBExec ($c, $sql, "DBEvaluatePediatrics(update pediatricsi)");
	//DBExec($c, "lock table observationtable", "DBEvaluate(lock)");
	$b=DBPediatricsiInfo($record);
	$remission=$b['remissionid'];
	$sql = "update observationtable set observationdesc='$desc', observationevaluated='$evaluated', ".
	"observationaccepted='$accepted', updatetime=$updatetime where (fileid=$record and remissionid=$remission) and observationid=(select max(observationid) ".
	"from observationtable where fileid=$record and remissionid=$remission)";

	DBExec ($c, $sql, "DBEvaluatePediatrics(update observation)");

	if($cw) {
			DBExec ($c, "commit work");
	}

	return $ret;
}

function DBEvaluateOrthodontics($desc, $evaluated, $accepted, $status, $record, $c=null){
	$cw = false;
	if($c == null) {
		$cw = true;
		$c = DBConnect();
		DBExec($c, "begin work", "DBEvaluateOrthodontics(begin)");
	}
	//DBExec($c, "lock table surgeryiitable", "DBEvaluate(lock)");
	$updatetime=time();

	$ret=2;
	$sql = "update orthodonticstable set orthodonticsstatus='$status', ";
	if($status=='end')
		$sql.="enddatetime=$updatetime, ";
	$sql.="updatetime=$updatetime where orthodonticsid=$record";

	DBExec ($c, $sql, "DBEvaluateOrthodontics(update orthodontics)");
	//DBExec($c, "lock table observationtable", "DBEvaluate(lock)");
	$b=DBOrthodonticsInfo($record);
	$remission=$b['remissionid'];
	$sql = "update observationtable set observationdesc='$desc', observationevaluated='$evaluated', ".
	"observationaccepted='$accepted', updatetime=$updatetime where (fileid=$record and remissionid=$remission) and observationid=(select max(observationid) ".
	"from observationtable where fileid=$record and remissionid=$remission)";

	DBExec ($c, $sql, "DBEvaluateOrthodontics(update observation)");

	if($cw) {
			DBExec ($c, "commit work");
	}

	return $ret;
}
?>
