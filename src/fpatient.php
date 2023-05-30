<?php
//eliminar la tabla de usuarios...
function DBDropPatientTable() {
    //conexcion de la base de datos..
	 $c = DBConnect();

	 $r = DBExec($c, "drop table \"patienttable\"", "DBDropPatientTable(drop table)");

}
function DBCreatePatientTable() {
	 $c = DBConnect();
	 $conf = globalconf();
	 if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
	 $r = DBExec($c, "
CREATE TABLE \"patienttable\" (
				\"patientid\" int4 NOT NULL,                        -- (id de paciente)
				\"patientci\" varchar(50) DEFAULT '' NOT NULL,			-- (CI del paciente)
				\"patientname\" varchar(50) NOT NULL,								-- (nombre del paciente)
				\"patientfirstname\" varchar(50) NOT NULL,					-- (apellido paterno del paciente)
				\"patientlastname\" varchar(50) NOT NULL,						-- (apellido materno del paciente)
        \"patientgender\" varchar(20) DEFAULT '' NOT NULL,  -- (genero del paciente)
        \"patientnationality\" varchar(200) DEFAULT '',     -- (nacionalidad del paciente)
        \"patientdatebirth\" int4 NOT NULL,     						-- (fecha de nacimiento del paciente)
        \"patientplacebirth\" varchar(200) DEFAULT '',     	-- (lugar de nacimiento del paciente)
        \"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
        CONSTRAINT \"patient_pkey\" PRIMARY KEY (\"patientid\")
)", "DBCreatePatientTable(create table)");
	$r = DBExec($c, "REVOKE ALL ON \"patienttable\" FROM PUBLIC", "DBCreatePatientTable(revoke public)");
	$r = DBExec($c, "GRANT ALL ON \"patienttable\" TO \"".$conf["dbuser"]."\"", "DBCreatePatientTable(grant sihcouser)");
	$r = DBExec($c, "CREATE UNIQUE INDEX \"patient_index\" ON \"patienttable\" USING btree ".
	     "(\"patientid\" int4_ops)",
	     "DBCreatePatientTable(create patient_index)");
	$r = DBExec($c, "CREATE UNIQUE INDEX \"patient_index2\" ON \"patienttable\" USING btree ".
     "(\"patientci\" varchar_ops, \"patientname\" varchar_ops, \"patientfirstname\" varchar_ops, \"patientlastname\" varchar_ops)",
	     "DBCreatePatientTable(create patient_index2)");
}
//para eliminar la tabla paciente admision
function DBDropPatientAdmissionTable() {
         $c = DBConnect();
         $r = DBExec($c, "drop table \"patientadmissiontable\"", "DBDropPatientAdmissionTable(drop table)");
}
//funcion para crear tabla paciente admision
function DBCreatePatientAdmissionTable() {
         $c = DBConnect();
	       $conf = globalconf();

         if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
         $r = DBExec($c, "
         CREATE TABLE \"patientadmissiontable\" (
                \"patientadmissionid\" int4 NOT NULL,               -- (id de ingreso paciente)
								\"patientid\" int4 NOT NULL,                        -- (id de paciente)
                \"patientdirection\" varchar(200) DEFAULT '',         -- (direccion de paciente)
                \"patientlocation\" varchar(300) DEFAULT '',          -- (localidad del paciente)
                \"patientage\" varchar(20) DEFAULT '',                -- (edad del paciente)
                \"patientprovenance\" varchar(200) DEFAULT '',    -- (procedencia del paciente)
        				\"patientphone\" int4 DEFAULT 0,		      -- (tel del paciente)
                \"patientcivilstatus\" varchar(200) DEFAULT '',     -- (estado civil del paciente)
                \"patientoccupation\" varchar(200) DEFAULT '',                 -- (ocupacion del paciente)
                \"patientschool\" varchar(200) DEFAULT '',           	-- (grado de escolaridad del paciente)
                \"patientattorney\" varchar(200) DEFAULT '',         	-- (apoderado del paciente)
								\"patientgmh\" text DEFAULT '',												-- (antecedentes medico general)
								\"patientpa\" text DEFAULT '',												-- (presion arterial)
								\"patientfather\" text DEFAULT '',											-- (nombre del padre y ocupacion)
								\"patientmother\" text DEFAULT '',											-- (nombre de la madre y ocupacion)
								\"patientbrothers\" text DEFAULT '',											-- (hermanos)
								\"patientschools\" varchar(200) DEFAULT '',								-- (nombre de la escuela actual)
								\"patientstreet\" varchar(200) DEFAULT '',								-- (calle paciente)
								\"patientresident\" varchar(200) DEFAULT '',							-- (residencia en del paciente)
								\"patientprovince\" varchar(200) DEFAULT '',							-- (provincia del paciente)

                \"tr\" text DEFAULT '',        	-- (odontograma dietes de arriba derecho)
                \"tl\" text DEFAULT '',         -- (odontograma dietes de arriba izquierdo)
                \"tlr\" text DEFAULT '',        -- (odontograma dietes leche arriba derecho)
                \"tll\" text DEFAULT '',        -- (odontograma dietes leche arriba izquierdo)
                \"bl\" text DEFAULT '',    			-- (odontograma dietes debajo izquierdo)
        				\"br\" text DEFAULT '', 	      -- (odontograma dietes debajo derecho)
                \"bll\" text DEFAULT '',     		-- (odontograma dietes leche debajo izquierdo)
                \"blr\" text DEFAULT '',       	-- (odontograma dietes leche debajo izquierdo)
								\"description\" text DEFAULT '',	-- (odontograma descripcion o diagnostico)
								\"draw\"	text DEFAULT '',				-- (para dibujar odontograma en reporte)

								\"dentalfaces\"	varchar(50) DEFAULT '',						-- (facies)
								\"dentalprofile\"	varchar(50) DEFAULT '',					-- (perfil)
								\"dentalscars\"	varchar(50) DEFAULT '',						-- (cicatrices)
								\"dentalatm\"	varchar(50) DEFAULT '',							-- (a.t.m)
								\"dentalganglia\"	varchar(50) DEFAULT '',					-- (ganglios)
								\"dentallips\"	varchar(50) DEFAULT '',						-- (labios)
								\"dentalulcerations\"	varchar(50) DEFAULT '',			-- (ulceraciones)
								\"dentalcheilitis\"	varchar(50) DEFAULT '',				-- (queilitis)
								\"dentalcommissures\"	varchar(50) DEFAULT '',			-- (comisuras)
								\"dentaltez\"	varchar(50) DEFAULT '',							-- (Tez para prostodoncia removible)
								\"dentaltongue\" varchar(50) DEFAULT '',					-- (lengua)
                \"dentalpiso\" varchar(50) DEFAULT '',            -- (piso de la boca)
                \"dentalencias\" varchar(50) DEFAULT '',       		-- (encias)
                \"dentalmucosa\" varchar(50) DEFAULT '',    	-- (mucosa bucal)
                \"dentalbraces\" varchar(100) DEFAULT '',    	-- (insersion de frenillos)
                \"dentalpalatine\" varchar(50) DEFAULT '',    -- (boveda palatina)
                \"dentaltypeo\" varchar(50) DEFAULT '',       -- (tipo de oclusion)
                \"dentaltypep\" varchar(50) DEFAULT '',       -- (tipo de protesis)
                \"dentalhygiene\" varchar(50) DEFAULT '',     -- (higiene bucal)

								\"lastconsult\" varchar(200) DEFAULT '',			-- (ultima consulta)
								\"motconsult\" varchar(200) DEFAULT '',				-- (motivo de consulta)
								\"generalstatus\" varchar(200) DEFAULT '',		--(dental estado general del paciente)

                \"triagetemperature\" varchar(200) DEFAULT '',  -- (temperatura del paciente)
                \"triageheadache\" bool DEFAULT 'f',            -- (cefalea del paciente)
                \"triagerespiratory\" bool DEFAULT 'f',         -- (dificultad respiratoria del paciente)
                \"triagethroat\" bool DEFAULT 'f',    					-- (dolor de garganta del paciente)
        				\"triagegeneral\" bool DEFAULT 'f',		      		-- (malestar general del paciente)
                \"triagevaccine\" varchar(20) DEFAULT '',     	-- (vacula del paciente)

								\"diagnosis\" varchar(200) DEFAULT '',				-- (diagnostico)

								\"studentid\" int4 NOT NULL, 															-- (id del estudiante)
								\"studentclinicalid\" int4 NOT NULL, 											-- (clinical del estudiante)
								\"studentcourseid\" int4 NOT NULL, 												-- (course del estudiante)
								\"responsibleid\" int4 NOT NULL, 													-- (id del responsable)
								\"responsibleclinicalid\" int4 NOT NULL, 									-- (clinical del responsable)
								\"responsiblecourseid\" int4 NOT NULL, 										-- (course del responsable)

								\"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
								CONSTRAINT \"patientadmission_pkey\" PRIMARY KEY (\"patientadmissionid\", \"patientid\"),
                CONSTRAINT \"patient_fk\" FOREIGN KEY (\"patientid\")
                        REFERENCES \"patienttable\" (\"patientid\")
                        ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
								CONSTRAINT \"specialty_fk\" FOREIGN KEY (\"studentid\", \"studentclinicalid\", \"studentcourseid\")
			 								 REFERENCES \"specialtytable\" (\"userid\", \"clinicalid\", \"coursenumber\")
			 								 ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
								CONSTRAINT \"specialty2_fk\" FOREIGN KEY (\"responsibleid\", \"responsibleclinicalid\", \"responsiblecourseid\")
			 								 REFERENCES \"specialtytable\" (\"userid\", \"clinicalid\", \"coursenumber\")
			 								 ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        )", "DBCreatePatientAdmissionTable(create table)");
        $r = DBExec($c, "REVOKE ALL ON \"patientadmissiontable\" FROM PUBLIC", "DBCreatePatientAdmissionTable(revoke public)");

        $r = DBExec($c, "GRANT INSERT, SELECT ON \"patientadmissiontable\" TO \"".$conf["dbuser"]."\"", "DBCreatePatientAdmissionTable(grant sihcouser)");
	      $r = DBExec($c, "CREATE INDEX \"patientadmission_index\" ON \"patientadmissiontable\" USING btree ".
	     "(\"patientadmissionid\" int4_ops, \"patientid\" int4_ops)",
       "DBCreatePatientAdmissionTable(create patientadmission_index)");

}

//funcion para registrar pacientes
function DBNewPatient($param, $c=null){
	if(isset($param['studentid']) && !isset($param['stid'])) $param['stid']=$param['studentid'];
	if(isset($param['studentclinicalid']) && !isset($param['stclinicalid'])) $param['stclinicalid']=$param['studentclinicalid'];
	if(isset($param['studentcourseid']) && !isset($param['stcourseid'])) $param['stcourseid']=$param['studentcourseid'];

	if(isset($param['responsibleid']) && !isset($param['reid'])) $param['reid']=$param['responsibleid'];
	if(isset($param['responsibleclinicalid']) && !isset($param['reclinicalid'])) $param['reclinicalid']=$param['responsibleclinicalid'];
	if(isset($param['responsiblecourseid']) && !isset($param['recourseid'])) $param['recourseid']=$param['responsiblecourseid'];

	if(isset($param['patientid']) && !isset($param['idp'])) $param['idp']=$param['patientid'];
	if(isset($param['patientadmissionid']) && !isset($param['idpa'])) $param['idpa']=$param['patientadmissionid'];
	if(isset($param['patientname']) && !isset($param['name'])) $param['name']=$param['patientname'];
	if(isset($param['patientfirstname']) && !isset($param['firstname'])) $param['firstname']=$param['patientfirstname'];
	if(isset($param['patientlastname']) && !isset($param['lastname'])) $param['lastname']=$param['patientlastname'];
	if(isset($param['patientgender']) && !isset($param['gender'])) $param['gender']=$param['patientgender'];
	if(isset($param['patientnationality']) && !isset($param['nationality'])) $param['nationality']=$param['patientnationality'];
	if(isset($param['patientdatebirth']) && !isset($param['datebirth'])) $param['datebirth']=$param['patientdatebirth'];
	if(isset($param['patientplacebirth']) && !isset($param['placebirth'])) $param['placebirth']=$param['patientplacebirth'];

	if(isset($param['patientdirection']) && !isset($param['direction'])) $param['direction']=$param['patientdirection'];
	if(isset($param['patientlocation']) && !isset($param['location'])) $param['location']=$param['patientlocation'];
	if(isset($param['patientage']) && !isset($param['age'])) $param['age']=$param['patientage'];
	if(isset($param['patientprovenance']) && !isset($param['provenance'])) $param['provenance']=$param['patientprovenance'];
	if(isset($param['patientphone']) && !isset($param['phone'])) $param['phone']=$param['patientphone'];
	if(isset($param['patientcivilstatus']) && !isset($param['civilstatus'])) $param['civilstatus']=$param['patientcivilstatus'];
	if(isset($param['patientoccupation']) && !isset($param['occupation'])) $param['occupation']=$param['patientoccupation'];
	if(isset($param['patientschool']) && !isset($param['school'])) $param['school']=$param['patientschool'];
	if(isset($param['patientattorney']) && !isset($param['attorney'])) $param['attorney']=$param['patientattorney'];
	if(isset($param['patientgmh']) && !isset($param['gmh'])) $param['gmh']=$param['patientgmh'];
	if(isset($param['patientpa']) && !isset($param['pa'])) $param['pa']=$param['patientpa'];

	if(isset($param['odontogramtr']) && !isset($param['tr'])) $param['tr']=$param['odontogramtr'];
	if(isset($param['odontogramtl']) && !isset($param['tl'])) $param['tl']=$param['odontogramtl'];
	if(isset($param['odontogramtlr']) && !isset($param['tlr'])) $param['tlr']=$param['odontogramtlr'];
	if(isset($param['odontogramtll']) && !isset($param['tll'])) $param['tll']=$param['odontogramtll'];
	if(isset($param['odontogrambl']) && !isset($param['bl'])) $param['bl']=$param['odontogrambl'];
	if(isset($param['odontogrambr']) && !isset($param['br'])) $param['br']=$param['odontogrambr'];
	if(isset($param['odontogrambll']) && !isset($param['bll'])) $param['bll']=$param['odontogrambll'];
	if(isset($param['odontogramblr']) && !isset($param['blr'])) $param['blr']=$param['odontogramblr'];
	$desc=$param["odontogramdesc"];
	$draw=$param["odontodraw"];

	if(isset($param['patientfaces']) && !isset($param['faces'])) $param['faces']=$param['patientfaces'];
	if(isset($param['patientprofile']) && !isset($param['profile'])) $param['profile']=$param['patientprofile'];
	if(isset($param['patientscars']) && !isset($param['scars'])) $param['scars']=$param['patientscars'];
	if(isset($param['patientatm']) && !isset($param['atm'])) $param['atm']=$param['patientatm'];
	if(isset($param['patientganglia']) && !isset($param['ganglia'])) $param['ganglia']=$param['patientganglia'];
	if(isset($param['patientlips']) && !isset($param['lips'])) $param['lips']=$param['patientlips'];
	if(isset($param['patientulcerations']) && !isset($param['ulcerations'])) $param['ulcerations']=$param['patientulcerations'];
	if(isset($param['patientcheilitis']) && !isset($param['cheilitis'])) $param['cheilitis']=$param['patientcheilitis'];
	if(isset($param['patientcommissures']) && !isset($param['commissures'])) $param['commissures']=$param['patientcommissures'];
	if(isset($param['patienttongue']) && !isset($param['tongue'])) $param['tongue']=$param['patienttongue'];
	if(isset($param['patientpiso']) && !isset($param['piso'])) $param['piso']=$param['patientpiso'];
	if(isset($param['patientencias']) && !isset($param['encias'])) $param['encias']=$param['patientencias'];
	if(isset($param['patientmucosa']) && !isset($param['mucosa'])) $param['mucosa']=$param['patientmucosa'];
	if(isset($param['patientocclusion']) && !isset($param['occlusion'])) $param['occlusion']=$param['patientocclusion'];
	if(isset($param['patientprosthesis']) && !isset($param['prosthesis'])) $param['prosthesis']=$param['patientprosthesis'];
	if(isset($param['patienthygiene']) && !isset($param['hygiene'])) $param['hygiene']=$param['patienthygiene'];
	if(isset($param['patientlastconsultation']) && !isset($param['lastconsultation'])) $param['lastconsultation']=$param['patientlastconsultation'];
	if(isset($param['patientconsultation']) && !isset($param['consultation'])) $param['consultation']=$param['patientconsultation'];
	if(isset($param['patientgeneralstatus']) && !isset($param['generalstatus'])) $param['generalstatus']=$param['patientgeneralstatus'];

	if(isset($param['triagetemperature']) && !isset($param['temperature'])) $param['temperature']=$param['triagetemperature'];
	if(isset($param['triageheadache']) && !isset($param['headache'])) $param['headache']=$param['triageheadache'];
	if(isset($param['triagerespiratory']) && !isset($param['respiratory'])) $param['respiratory']=$param['triagerespiratory'];
	if(isset($param['triagethroat']) && !isset($param['throat'])) $param['throat']=$param['triagethroat'];
	if(isset($param['triagegeneral']) && !isset($param['general'])) $param['general']=$param['triagegeneral'];
	if(isset($param['triagevaccine']) && !isset($param['vaccine'])) $param['vaccine']=$param['triagevaccine'];

	if(isset($param['patientdiagnosis']) && !isset($param['diagnosis'])) $param['diagnosis']=$param['diagnosis'];

	if(isset($param['remissionclinical']) && !isset($param['clinical'])) $param['clinical']=$param['clinical'];
	if(isset($param['examinedid']) && !isset($param['examined'])) $param['examined']=$param['examinedid'];


	$ac=array('stid', 'stclinicalid', 'stcourseid', 'reid',
'reclinicalid', 'recourseid');

	$ac1=array('idp', 'idpa', 'name', 'firstname', 'lastname', 'gender', 'nationality', 'datebirth',
	'placebirth', 'direction', 'location', 'age', 'provenance', 'phone', 'civilstatus',
	'occupation', 'school', 'attorney', 'gmh', 'pa', 'tr', 'tl', 'tlr', 'tll', 'bl',
	'br', 'bll', 'blr', 'faces', 'profile', 'scars', 'atm', 'ganglia', 'lips',
	'ulcerations', 'cheilitis', 'commissures', 'tongue', 'piso', 'encias',
	'mucosa', 'occlusion', 'prosthesis', 'hygiene', 'lastconsultation', 'consultation',
	'generalstatus', 'temperature', 'headache', 'respiratory', 'throat', 'general',
	'vaccine', 'diagnosis', 'clinical', 'examined', 'updatetime');

	$typei['updatetime']=1;

	$typei['stid']=0;
	$typei['stclinicalid']=0;
	$typei['stcourseid']=3;

	$typei['reid']=0;
	$typei['reclinicalid']=0;
	$typei['recourseid']=3;
	foreach($ac as $key) {
		if(!isset($param[$key]) || $param[$key]=="") {
			MSGError("DBNewPacient param error: $key not found");
			return false;
		}
		if(isset($typei[$key]) && !is_numeric($param[$key])) {
			MSGError("DBNewPacient param error: $key is not numeric");
			return false;
		}
		$$key = myhtmlspecialchars($param[$key]);
	}

	$idp=-1;
	$idpa=-1;

	$name='';
	$firstname='';
	$lastname='';
	$gender='';
	$nationality='';
	$datebirth=-1;
	$placebirth='';
	$direction='';
	$location='';
	$age='';
	$provenance='';
	$phone=0;
	$civilstatus='';
	$occupation='';
	$school='';
	$attorney='';
	$gmh='';
	$pa='';
	$tr='';
	$tl='';
	$tlr='';
	$tll='';
	$bl='';
	$br='';
	$bll='';
	$blr='';
	$faces='';
	$profile='';
	$scars='';
	$atm='';
	$ganglia='';
	$lips='';
	$ulcerations='';
	$cheilitis='';
	$commissures='';
	$tongue='';
	$piso='';
	$encias='';
	$mucosa='';
	$occlusion='';
	$prosthesis='';
	$hygiene='';
	$lastconsultation='';
	$consultation='';
	$generalstatus='';
	$temperature='';
	$headache='f';
	$respiratory='f';
	$throat='f';
	$general='f';
	$vaccine='';
	$diagnosis='';

	$updatetime=-1;
	$clinical=-1;

	$typei['phone']=0;
	foreach($ac1 as $key) {
		if(isset($param[$key])) {
			$$key = myhtmlspecialchars($param[$key]);
			if(isset($typei[$key]) && !is_numeric($param[$key])) {
				MSGError("DBNewPacient param error: $key is not numeric");
				return false;
			}
		}
	}
	$t = time();
	if($updatetime <= 0)
		$updatetime=$t;
	if($idp==-1){
		$sql = "select * from patienttable where patientname='$name' and patientfirstname='$firstname' and patientlastname='$lastname'";
		$a = DBGetRow ($sql, 0, $c);
		if($a==null){
			$idp=DBPatientNumberMax();
		}else{
			$idp=$a['patientid'];
		}
	}else{
		//para actualizar o insertar
		$idp=$param['idp'];
	}
	$cw = false;
	if($c == null) {
		$cw = true;
		$c = DBConnect();
		DBExec($c, "begin work", "DBNewPacient(begin)");
	}
	//DBExec($c, "lock table patienttable", "DBNewPatient(lock)");
	$r = DBExec($c, "select * from patienttable where (patientname='$name' and patientfirstname='$firstname' and patientlastname='$lastname') and patientid!=$idp", "DBNewPatient(get user)");

	$n = DBnlines ($r);
	$ret=1;
	if ($n == 0) {
		$sql = "select * from patienttable where patientname='$name' and patientfirstname='$firstname' and patientlastname='$lastname'";
		$a = DBGetRow ($sql, 0, $c);
    //para insercion o actulizacion
		if ($a == null) {
			    $ret=2;
					$idpa=DBPatientAdmissionNumberMax();

    		  $sql = "insert into patienttable (patientid, patientname, patientfirstname, patientlastname, patientgender, " .
						"patientnationality, patientdatebirth, patientplacebirth, updatetime) values ".
    				"($idp, '$name', '$firstname', '$lastname','$gender', '$nationality', $datebirth, '$placebirth', $updatetime)";
    			DBExec ($c, $sql, "DBNewPatient(insert)");
					//insertar ingreso paciente
					$sql = "insert into patientadmissiontable (patientadmissionid, patientid, patientdirection, ".
					"patientlocation, patientage, patientprovenance, patientphone, patientcivilstatus, ".
					"patientoccupation, patientschool, patientattorney, patientgmh, patientpa, tr, tl, tlr, tll, bl, ".
					"br, bll, blr, description, draw, ".
					"dentaltongue, dentalpiso, dentalencias, dentalmucosa, dentaltypeo, dentaltypep, ".
					"dentalhygiene, lastconsult, motconsult, ".
					"triagetemperature, triageheadache, triagerespiratory, triagethroat, triagegeneral, triagevaccine, ".
					"diagnosis, studentid, studentclinicalid, studentcourseid, ".
					"responsibleid, responsibleclinicalid, responsiblecourseid) values (".
					"$idpa, $idp, '$direction', '$location', '$age', '$provenance', $phone, '$civilstatus', '$occupation', ".
					"'$school', '$attorney', '$gmh', '$pa', '$tr', '$tl', '$tlr', '$tll', '$bl', '$br', '$bll', '$blr', '$desc', '$draw', ".
					"'$tongue', '$piso', '$encias', '$mucosa', '$occlusion', '$prosthesis', '$hygiene', '$lastconsultation', '$consultation', ".
					"'$temperature', '$headache', '$respiratory', '$throat', '$general', '$vaccine', '$diagnosis', ".
					"$stid, $stclinicalid, $stcourseid, $reid, $reclinicalid, $recourseid)";

					DBExec($c, $sql, "DBNewPatient(insert patientadmission)");

					if($clinical!=-1&&is_numeric($clinical)&&$clinical>1&&$clinical<=17){
							$rdata=array();
							$rdata['patientid']=$idp;
							$rdata['patientadmissionid']=$idpa;
							$rdata['clinicalid']=$clinical;
							if(isset($examined)&&is_numeric($examined)){
								$rdata['examined']=$examined;
							}
							$ret=DBNewRemission($rdata, $c);

					}
					if($cw) {
    				DBExec ($c, "commit work");
    			}
    			LOGLevel ("Paciente $idp registrado.",2);
		} else {
			//para actualizar....
			if ($param['mod']=='new') {
				$ret=2;
				$idpa=DBPatientAdmissionNumberMax();
				$sql = "insert into patientadmissiontable (patientadmissionid, patientid, patientdirection, ".
				"patientlocation, patientage, patientprovenance, patientphone, patientcivilstatus, ".
				"patientoccupation, patientschool, patientattorney, patientgmh, patientpa, tr, tl, tlr, tll, bl, ".
				"br, bll, blr, description, draw, ".
				"dentaltongue, dentalpiso, dentalencias, dentalmucosa, dentaltypeo, dentaltypep, ".
				"dentalhygiene, lastconsult, motconsult, ".
				"triagetemperature, triageheadache, triagerespiratory, triagethroat, triagegeneral, triagevaccine, ".
				"diagnosis, studentid, studentclinicalid, studentcourseid, ".
				"responsibleid, responsibleclinicalid, responsiblecourseid) values (".
				"$idpa, $idp, '$direction', '$location', '$age', '$provenance', $phone, '$civilstatus', '$occupation', ".
				"'$school', '$attorney', '$gmh', '$pa', '$tr', '$tl', '$tlr', '$tll', '$bl', '$br', '$bll', '$blr', '$desc', '$draw', ".
				"'$tongue', '$piso', '$encias', '$mucosa', '$occlusion', '$prosthesis', '$hygiene', '$lastconsultation', '$consultation', ".
				"'$temperature', '$headache', '$respiratory', '$throat', '$general', '$vaccine', '$diagnosis', ".
				"$stid, $stclinicalid, $stcourseid, $reid, $reclinicalid, $recourseid)";


				DBExec($c, $sql, "DBNewPatient(insert patientadmission)");
				if($clinical!=-1&&is_numeric($clinical)&&$clinical>1&&$clinical<=17){
						$rdata=array();
						$rdata['patientid']=$idp;
						$rdata['patientadmissionid']=$idpa;
						$rdata['clinicalid']=$clinical;
						if(isset($examined)&&is_numeric($examined)){
							$rdata['examined']=$examined;
						}
						$ret=DBNewRemission($rdata, $c);

				}
				if($cw) {
					DBExec ($c, "commit work");
				}
				LOGLevel ("Paciente $idp admitido $idpa : registrado.",2);

			}else{
				if($updatetime >= $a['updatetime'] && $idpa!="") {
					$ret=2;
					$idpa=$param["idpa"];
					$sql="update patienttable set patientname='$name', patientfirstname='$firstname', patientlastname='$lastname', patientgender='$gender', " .
						"patientnationality='$nationality', patientdatebirth=$datebirth, patientplacebirth='$placebirth', updatetime=$updatetime where patientid=$idp";
					$r = DBExec ($c, $sql, "DBNewPatient(update patient)");
					$sql="update patientadmissiontable set patientdirection='$direction', ".
					"patientlocation='$location', patientage='$age', patientprovenance='$provenance', ".
					"patientphone='$phone', patientcivilstatus='$civilstatus', patientoccupation='$occupation', ".
					"patientschool='$school', patientattorney='$attorney', patientgmh='$gmh', patientpa='$pa', ".
					"tr='$tr', tl='$tl', tlr='$tlr', tll='$tll', bl='$bl', br='$br', bll='$bll', blr='$blr', description='$desc', draw='$draw', ".
					"dentaltongue='$tongue', dentalpiso='$piso', dentalencias='$encias', dentalmucosa='$mucosa', dentaltypeo='$occlusion', dentaltypep='$prosthesis', ".
					"dentalhygiene='$hygiene', lastconsult='$lastconsultation', motconsult='$consultation', ".
					"triagetemperature='$temperature', triageheadache='$headache', triagerespiratory='$respiratory', ".
					"triagethroat='$throat', triagegeneral='$general', triagevaccine='$vaccine', diagnosis='$diagnosis', updatetime=$updatetime where patientadmissionid=$idpa";
					$r = DBExec ($c, $sql, "DBNewPatient(update patientadmission)");
					if($clinical!=-1&&is_numeric($clinical)&&$clinical>1&&$clinical<=17){
							$rdata=array();
							$reinfo=DBRemissionInfo($idpa, $c);//idadmission
							$rdata['remissionid']=$reinfo['remissionid'];
							$rdata['patientid']=$idp;
							$rdata['patientadmissionid']=$idpa;
							$rdata['clinicalid']=$clinical;
							if(isset($examined)&&is_numeric($examined)){
								$rdata['examined']=$examined;
							}
							$ret=DBNewRemission($rdata, $c);
					}
					if($cw) {
						DBExec ($c, "commit work");
					}
					LOGLevel("Paciente Admision $idpa actualizado.",2);
				}
			}
		}
	} else {
	  if($cw)
	     DBExec ($c, "rollback work");
	  LOGLevel ("Problema de actualizacion para el paciente  $idp (tal vez el nombre de usuario ya esté en uso).",1);
//Problema de actualización para el usuario $ usuario, sitio $ sitio (tal vez el nombre de usuario ya esté en uso).
    MSGError ("Problema de actualizacion para el paciente $idp, (tal vez el nombre de usuario ya esté en uso).");
	  return false;
	}
	if($cw) DBExec($c, "commit work");
	return $ret;
}

//funcion para descriptar los datos
function decryptOdontogram($param=null){

	if($param!=null){
		$conf=globalconf();
    /*$param['tr'] = decryptData($param["tr"], $conf["key"]);

    $param['tl'] = decryptData($param["tl"], $conf["key"]);
    $param['tlr'] = decryptData($param["tlr"], $conf["key"]);
    $param['tll'] = decryptData($param["tll"], $conf["key"]);
    $param['bl'] = decryptData($param["bl"], $conf["key"]);
    $param['br'] = decryptData($param["br"], $conf["key"]);
    $param['bll'] = decryptData($param["bll"], $conf["key"]);
    $param['blr'] = decryptData($param["blr"], $conf["key"]);*/
		if($param['draw']!="")
    	$param['draw'] = decryptData($param["draw"], $conf["key"]);
	}
	return $param;
}

//funcion para sacar la informacion del paciente remetido maximo
function DBPatientRemissionMaxInfo($id, $c=null){

	$sql = "select *from patientadmissiontable as pa, patienttable as p, usertable as u
where p.patientid = $id and pa.patientid=p.patientid and u.usernumber=pa.studentid and
pa.patientadmissionid = (select max(pa.patientadmissionid) from patientadmissiontable as pa where pa.patientid=$id)";
	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");

		//MSGError("Unable to find the user in the database. Contact an admin now!");
		return null;
	}
	return $a;
}

//funcion para sacar la informacion del paciente remetido.
function DBPatientRemissionInfo($id, $c=null){

	$sql = "select *from patienttable as p, patientadmissiontable as pa
	where pa.patientadmissionid=$id and pa.patientid=p.patientid";
	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");

		//MSGError("Unable to find the user in the database. Contact an admin now!");
		return null;
	}

	$a['remission']=DBRemissionInfo($a['patientadmissionid'],$c);
	$a=clearpa($a);
	$a=clearfathers($a,'father');
	$a=clearfathers($a,'mother');
	return $a;
}
function DBRemissionInfo($id, $c=null, $idrem=null){

	$sql = "SELECT re.remissionid, re.patientadmissionid,re.patientid, ".
	"re.clinicalid, re.enabled, cli.clinicalmodule, cli.clinicalspecialty, cl.studentid ".
	"FROM remissiontable re LEFT JOIN clinichistorytable cl ".
	"ON re.remissionid = cl.remissionid INNER JOIN clinicaltable cli ".
	"ON re.clinicalid = cli.clinicalid where re.enabled='t'";
	if($idrem!=null){
		$sql.=" and re.remissionid=$idrem";
	}else{
		if($id!=null){
			$sql.=" and re.patientadmissionid=$id";
		}
	}
	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");
		//MSGError("Unable to find the user in the database. Contact an admin now!");
		return null;
	}
	return $a;
}
function DBAllRemissionInfo($id=null, $c=null) {
	$sql = "SELECT *FROM remissiontable re LEFT JOIN clinichistorytable cl ".
	"ON re.remissionid = cl.remissionid INNER JOIN clinicaltable cli ".
	"ON re.clinicalid = cli.clinicalid where re.enabled='t'";
	if($id!=null){
		$sql.=" and re.patientadmissionid=$id";
	}
	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBAllRemissionInfo(get remission)");
	$n = DBnlines($r);
	if ($n == 0) {

		LOGError("Unable to find users in the database. SQL=(" . $sql . ")");
		return null;
		//MSGError("¡No se pueden encontrar pacientes remitidos en la base de datos!");
	}

	$a = array();
	for ($i=0;$i<$n;$i++) {
		$a[$i] = DBRow($r,$i);
	}
	return $a;
}
function DBAllPatientRemissionInfo($student=null) {
	$sql = "select *from patienttable as p, patientadmissiontable as pa
	where p.patientid=pa.patientid";
	if($student!=null&&is_numeric($student)){
		$sql.=" and pa.studentid=$student";
	}
	$sql.=" order by pa.patientadmissionid desc";
	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBAllPatientRemissionInfo(get patients remission)");
	$n = DBnlines($r);
	if ($n == 0) {
		LOGError("Unable to find users in the database. SQL=(" . $sql . ")");
		MSGError("¡No se pueden encontrar pacientes remitidos en la base de datos!");
	}

	$a = array();
	for ($i=0;$i<$n;$i++) {
		$a[$i] = DBRow($r,$i);
		//$a[$i]['remission']=DBRemissionInfo($a[$i]['patientadmissionid'],$c);
		$a[$i]['remission']=DBAllRemissionInfo($a[$i]['patientadmissionid'],$c);
		$a[$i]=clearpa($a[$i]);
		$a[$i]=clearfathers($a[$i],'father');
		$a[$i]=clearfathers($a[$i],'mother');
	}
	return $a;
}
function DBAllPatientRemissionClinicalInfo($clinical=null, $patient=null) {
	$sql = "select *from patienttable as p, patientadmissiontable as pa, remissiontable re
	where p.patientid=pa.patientid and re.patientadmissionid=pa.patientadmissionid";
	if($clinical!=null&&is_numeric($clinical)){
		$sql.=" and re.clinicalid=$clinical";
	}
	if($patient!=null&&is_numeric($patient)){//buscar por id del paciente
		$sql.=" and p.patientid=$patient";
	}
	$sql.=" order by pa.patientadmissionid desc";
	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBAllPatientRemissionInfo(get patients remission)");
	$n = DBnlines($r);
	if ($n == 0) {
		LOGError("Unable to find users in the database. SQL=(" . $sql . ")");
		MSGError("¡No se pueden encontrar pacientes remitidos en la base de datos!");
	}

	$a = array();
	for ($i=0;$i<$n;$i++) {
		$a[$i] = DBRow($r,$i);
		//$a[$i]['remission']=DBRemissionInfo($a[$i]['patientadmissionid'],$c);
		$a[$i]['remission']=DBAllRemissionInfo($a[$i]['patientadmissionid'],$c);
		$a[$i]=clearpa($a[$i]);
		$a[$i]=clearfathers($a[$i],'father');
		$a[$i]=clearfathers($a[$i],'mother');
	}
	return $a;
}
//funcion para listar a todos los paciente con ultimo registro para seguimiento a paciente
function DBAllFollowPatient() {
	$sql = "select *from patienttable as p";

	$sql.=" order by p.patientid desc";
	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBAllFollowPatient(get patients)");
	$n = DBnlines($r);
	if ($n == 0) {
		LOGError("Unable to find users in the database. SQL=(" . $sql . ")");
		MSGError("¡No se pueden encontrar pacientes remitidos en la base de datos!");
	}

	$a = array();
	for ($i=0;$i<$n;$i++) {
		$a[$i] = DBRow($r,$i);
		$pa[$i] = DBGetRow ("select *from patientadmissiontable where
		patientadmissionid=(select max(patientadmissionid) from patientadmissiontable where patientid=".$a[$i]['patientid'].")", 0, $c);
		//$a[$i]['remission']=DBAllRemissionInfo($a[$i]['patientadmissionid'],$c);
		$a[$i] = array_merge($a[$i], $pa[$i]);
		$a[$i]=clearpa($a[$i]);
		$a[$i]=clearfathers($a[$i],'father');
		$a[$i]=clearfathers($a[$i],'mother');
	}
	return $a;
}
//funcion para saber en que especilidades esta presente
//funcion para sacar los pacientes de una especilidad asignada o a las especilidades derivados
function DBAllRemissionPatientInfo($student=null, $assigned=false, $all=false, $typeteacher=false, $typeteacherother=false) {
	$sql = "SELECT p.patientid, p.patientci, p.patientname, p.patientfirstname, p.patientlastname, p.patientgender,
p.patientnationality, p.patientdatebirth, pa.patientadmissionid, pa.patientdirection, pa.patientlocation,
pa.patientage, pa.patientprovenance, pa.patientphone, pa.patientcivilstatus, pa.patientoccupation,
pa.patientschool, pa.patientattorney, pa.patientgmh, pa.patientpa, pa.patientfather, pa.patientmother,
pa.patientbrothers, pa.patientschools, pa.patientstreet, pa.patientresident, pa.patientprovince,
pa.motconsult, pa.diagnosis, pa.studentid as studentidadmission, pa.responsibleid, pa.updatetime
as updatetimeadmission, re.remissionid, re.clinicalid, re.enabled, re.updatetime as updatetimeremission,
cli.remissionid as remissionidch, cli.studentid, cli.teacherid, cli.stdatetime, cli.endatetime,
c.clinicalspecialty, c.clinicalid, cli.status, cli.authorized, cli.inputfilename, cli.inputfile, cli.inputfilehash,
cli.reviewteacher, cli.reviewstatus FROM patienttable p JOIN patientadmissiontable pa ON p.patientid=pa.patientid
JOIN remissiontable re ON re.patientadmissionid=pa.patientadmissionid LEFT JOIN
clinichistorytable cli ON cli.remissionid=re.remissionid JOIN clinicaltable c ON c.clinicalid=re.clinicalid
where re.enabled='t'";

	if($student!=null&&is_numeric($student)){
		$us=DBAllSpecialtyInfo($student);
		$sql2="";
		$sql2.=" and (";
		$sw=true;$c=false;
		for ($i=0; $i <count($us) ; $i++) {
			if($us[$i]['clinicalid']!=1){
				$sw=false;
				if($c){
					$sql2.=" or re.clinicalid=".$us[$i]['clinicalid'];
				}else{
					$sql2.=" re.clinicalid=".$us[$i]['clinicalid'];
					$c=true;
				}
			}
		}
		if($sw)
			return array();
		if($assigned==true){//buscar quienes son mis pacientes
			if($typeteacher){
				if($typeteacherother){
					$sql.=$sql2." ) and cli.teacherid!=0 and cli.studentid!=0 and reviewany='t'";
				}else{
					$sql.=$sql2." ) and cli.teacherid=$student";
				}
			}else{
				$sql.=$sql2." ) and cli.studentid=$student";
			}
		}else{
			$sql.=$sql2.' )';
		}
	}
	$sql.=" order by re.updatetime desc";
	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBAllRemissionPatientInfo(get remission patients )");
	$n = DBnlines($r);
	if ($n == 0) {
		LOGError("Aun no se derivó a los pacientes. SQL=(" . $sql . ")");
		if($assigned)
			MSGError("¡Aun no tienes pacientes!");
		else
			MSGError("¡Aun no hay pacientes derivados!");
	}

	$a = array();
	for ($i=0;$i<$n;$i++) {
		$res = DBRow($r,$i);
		if($all|| $res['studentid']==NULL || $assigned){
				$a[$i]=$res;
				//$a[$i]['remission']=DBAllRemissionInfo($a[$i]['patientadmissionid'],$c);
				$a[$i]=clearpa($a[$i]);
				$a[$i]=clearfathers($a[$i],'father');
				$a[$i]=clearfathers($a[$i],'mother');
		}
	}
	return $a;
}

//funcion para saber en que especilidades esta presente
function DBAllSpecialtyInfo($student=null, $all=false) {
	$sql = "SELECT *from specialtytable s";

	if($all==false) $sql.=" where s.specialtyenabled='t'";
	if($student!=null&& is_numeric($student)){
		if(!$all) $sql.=" and s.userid=$student";
		else $sql.=" where s.userid=$student";
	}
	$sql.=" order by s.updatetime desc";
	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBAllSpecialtyInfo(get specialty)");
	$n = DBnlines($r);
	if ($n == 0) {
		LOGError("Unable to find users specialty in the database. SQL=(" . $sql . ")");
	}
	$a = array();
	for ($i=0;$i<$n;$i++) {
		$a[$i] = DBRow($r,$i);
	}
	return $a;
}
//para limpiar los corchetes
function clearpa($a){
	if(!isset($a['patientpa']))
		return $a;
	$r1=explode(']', $a['patientpa']);
	$size=count($r1);
	if($size>1){
		$r2=explode('[', $r1[0]);
		$a['sistolica']=$r2[1];
		if($size>=2){
			$r2=explode('[',$r1[1]);
			$a['diastolica']=$r2[1];
		}
	}

	return $a;
}
function clearfathers($a,$text=''){
	if($text=='')
		return $a;
	if(isset($a['patient'.$text])&& $a['patient'.$text]!=''){
		$r=explode(']',$a['patient'.$text]);
		$size=count($r);
		if($size>=1){
			$r2=explode('[',$r[0]);
			$a['patient'.$text.'name']=$r2[1];
			if($size>=2){
				$r2=explode('[',$r[1]);
				$a['patient'.$text.'occupation']=$r2[1];
			}
		}
	}
	return $a;
}
//seleccion la todos los pacientes remitidos
/*function DBAllRemissionInfo($student=null, $clinical=false, $limit=500) {
	$tmpsql="";
	if($clinical){
		$tmpsql="r.clinicalid=$student";
	}else{
		$tmpsql="r.examined=$student";
	}
	$sql = "select p.patientfullname as fullname, d.motconsult as consult, r.diagnostico as diagnostico,
	c.clinicalspecialty as remission, u.usernumber as usernumber, u.userfullname as examined, r.updatetime as time, r.remissionid as id
	from remissiontable as r, dentalexamtable as d, patienttable as p, specialtytable as s, clinicaltable as c,
	usertable as u where d.dentalid=r.patientdentalid and d.patientid=r.patientid
	and p.patientid=d.patientid and s.userid=r.examined and s.clinicalid=r.clinicalid and
	u.usernumber=s.userid and c.clinicalid=s.clinicalid order by r.remissionid desc limit $limit";
	if($student!=null&&is_numeric($student)){
		$sql = "select p.patientfullname as fullname, d.motconsult as consult, r.diagnostico as diagnostico,
		c.clinicalspecialty as remission, u.userfullname as examined, r.updatetime as time, r.remissionid as id
		from remissiontable as r, dentalexamtable as d, patienttable as p, specialtytable as s, clinicaltable as c,
		usertable as u where d.dentalid=r.patientdentalid and d.patientid=r.patientid
		and p.patientid=d.patientid and s.userid=r.examined and s.clinicalid=r.clinicalid and
		u.usernumber=s.userid and c.clinicalid=s.clinicalid and $tmpsql order by r.remissionid desc limit $limit";
	}

	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBAllRemissionInfo(get patients remission)");
	$n = DBnlines($r);
	if ($n == 0) {
		LOGError("Unable to find users in the database. SQL=(" . $sql . ")");
		MSGError("¡No se pueden encontrar pacientes remitidos en la base de datos!");
	}

	$a = array();
	for ($i=0;$i<$n;$i++) {
		$a[$i] = DBRow($r,$i);
	}
	return $a;
}*/
function cmp($a, $b) {
    if ($a['timef'] == $b['timef']) {
        return 0;
    }
    return ($a['timef'] < $b['timef']) ? 1 : -1;
}
function ordena($a) {
  uasort($a, "cmp");
  return $a;
}
function cmp2($a, $b) {
    if ($a['time'] == $b['time']) {
        return 0;
    }
    return ($a['time'] < $b['time']) ? 1 : -1;
}
function ordena2($a) {
  uasort($a, "cmp2");
  return $a;
}
//funcion para cada estudiante remitido
//seleccion la todos los pacientes remitidos
/*function DBRemissionInfo($examined, $clinical=false) {
	if($examined==null)
		return false;
	$tmpsql='';
	if($clinical){
		$tmpsql="and r.clinicalid=$examined";
	}else {
		$tmpsql="and r.examined=$examined";
	}

	$sql = "select p.patientfullname as fullname, d.motconsult as consult, r.diagnostico as diagnostico,
c.clinicalspecialty as remission, u.userfullname as examined, r.updatetime as time, r.remissionid as id, r.clinicalid as clinical
from remissiontable as r, dentalexamtable as d, patienttable as p, specialtytable as s, clinicaltable as c,
usertable as u where d.dentalid=r.patientdentalid and d.patientid=r.patientid
and p.patientid=d.patientid and s.userid=r.examined and s.clinicalid=r.clinicalid and
u.usernumber=s.userid and c.clinicalid=s.clinicalid $tmpsql order by r.remissionid desc";
	//and r.examined=$examined
	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBRemissionInfo(get patients remission)");
	$n = DBnlines($r);
	if ($n == 0) {
		LOGError("Unable to find users in the database. SQL=(" . $sql . ")");
		MSGError("¡No se pueden encontrar pacientes remitidos en la base de datos!");
	}
	$table = array(1=>'removable', 2=>'fixed', 3=>'operative', 4=>'endodontics', 5=>'surgeryii',6=>'periodonticsii',7=>'pediatricsi', 8=>'orthodontics', 9=>'removable', 10=>'fixed',  11=>'operative', 12=>'endodontics', 13=>'surgeryiii', 14=>'periodonticsiii', 15=>'pediatricsi', 16=>'orthodontics');
	$a = array();
	$sw=false;
	$cc=0;
	for ($i=0;$i<$n;$i++) {
		$a[$i] = DBRow($r,$i);
		if(array_key_exists($a[$i]['clinical'], $table)){

			$a[$i] = DBInfoClinicalRecord($a[$i],$table[$a[$i]['clinical']],$a[$i]['id'], null, $clinical);
			$cc++;
		}
	}
	if($cc==$n)
		ordena($a);
	return $a;
}*/
//funcion para sacar la informacion de la ficha clinica remitido
function DBInfoClinicalRecord($data, $table, $id, $c=null, $clinical=false){
	$sql='';
	$cat='';
	$tmpsql='';
	$tmp=$table;
	if($table=='orthodontics'){
		$cat='def';
	}
	if($table=='surgeryiii'){
		$table='surgeryii';
	}
	if($table=='periodonticsiii'){
		$table='periodonticsii';
	}
	if($clinical){
		$tmpsql=" and ".$table."status!='new'";
	}
	if($table=='pediatricsi' || $table=='removable' || $table=='operative' || $table=='endodontics'){
		$sql = "select ".$table."id as ficha, ".$table."status as status, updatetime as timef, teacher as teacher, ".$table."inputfile as inputfile, ".$table."inputfilehash as inputfilehash, ".$table."inputfilename as inputfilename from ".$table."table where remissionid=$id".$tmpsql;
		//funcion para capturar la fila del usuario
	}else{
		$sql = "select ".$table."id as ficha, ".$table."status as status, ".$table."diagnosis$cat as diagnosisd, updatetime as timef, teacher as teacher from ".$table."table where remissionid=$id".$tmpsql;
		//funcion para capturar la fila del usuario
	}

	//MSGError($table." - ".$id);
	$a = DBGetRow ($sql, 0, $c);
	if($a==null){
		$a=array('timef'=>0);
	}
	//$data+=$a;
	$data=array_merge($data, $a);
	$table=$tmp;
	$data['clinicalname']=$table;//nombre de pagina de direccion y reporte
	if ($a == null) {
		LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");
		MSGError("Unable to find the user in the database. Contact an admin now!");
	}
	return $data;
}
function patientgmh($a){
    $gmh="";
    $n=count($a);
    for ($i=0; $i < $n; $i++) {
      if(isset($a[$i]["disease"]))  $gmh.="[".$a[$i]["disease"]."]";
      else $gmh.="[]";
      if(isset($a[$i]["status"]))  $gmh.="[".$a[$i]["status"]."]";
      else $gmh.="[]";
      if(isset($a[$i]["obs"]))  $gmh.="[".$a[$i]["obs"]."]";
      else $gmh.="[]";
      if($n>$i+1)
        $gmh.=":-_-:";
    }
    return $gmh;
}

//funcion para limpiar antecedentes medico general
function cleanpatientgmh($gmh){

    $inst=explode(':-_-:',$gmh);
    $a=array();
    for ($i=0; $i < count($inst); $i++) {
        $a[$i]["disease"]='';
        $a[$i]["status"]='';
        $a[$i]["obs"]='';
        $inst2=explode(']',$inst[$i]);
        if(isset($inst2[0])){
          $inst3=explode('[',$inst2[0]);
          $a[$i]["disease"]=trim($inst3[1]);
        }
        if(isset($inst2[1])){
          $inst3=explode('[',$inst2[1]);
          $a[$i]["status"]=trim($inst3[1]);
        }
        if(isset($inst2[2])){
          $inst3=explode('[',$inst2[2]);
          $a[$i]["obs"]=trim($inst3[1]);
        }
    }
    return $a;
}
//funcion para crear tabla odontograma
function DBDropOdontogramTable() {
         $c = DBConnect();
         $r = DBExec($c, "drop table \"odontogramtable\"", "DBDropOdontogramTable(drop table)");
}
function DBCreateOdontogramTable() {
         $c = DBConnect();
	       $conf = globalconf();

         if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
         $r = DBExec($c, "
         CREATE TABLE \"odontogramtable\" (
                \"odontogramid\" int4 NOT NULL,         -- (id de odontograma)
                \"tr\" text DEFAULT '',        	-- (dietes de arriba derecho)
                \"tl\" text DEFAULT '',         -- (dietes de arriba izquierdo)
                \"tlr\" text DEFAULT '',        -- (dietes leche arriba derecho)
                \"tll\" text DEFAULT '',        -- (dietes leche arriba izquierdo)
                \"bl\" text DEFAULT '',    			-- (dietes debajo izquierdo)
        				\"br\" text DEFAULT '', 	      -- (dietes debajo derecho)
                \"bll\" text DEFAULT '',     		-- (dietes leche debajo izquierdo)
                \"blr\" text DEFAULT '',        -- (dietes leche debajo izquierdo)
								\"description\" text DEFAULT '',				-- (descripcion o diagnostico)
								\"draw\"	text DEFAULT '',			-- (para dibujar odontograma en reporte)
                \"patientid\" int4 NOT NULL,            -- (id del paciente)
                \"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)

                CONSTRAINT \"odontogram_pkey\" PRIMARY KEY (\"odontogramid\", \"patientid\"),
                CONSTRAINT \"odontogram\" FOREIGN KEY (\"patientid\")
                        REFERENCES \"patienttable\" (\"patientid\")
                        ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        )", "DBCreateOdontogramTable(create table)");
        $r = DBExec($c, "REVOKE ALL ON \"odontogramtable\" FROM PUBLIC", "DBCreateOdontogramTable(revoke public)");

        $r = DBExec($c, "GRANT INSERT, SELECT ON \"odontogramtable\" TO \"".$conf["dbuser"]."\"", "DBCreateOdontogramTable(grant sihcouser)");
	      $r = DBExec($c, "CREATE INDEX \"odontogram_index\" ON \"odontogramtable\" USING btree ".
	     "(\"odontogramid\" int4_ops, \"patientid\" int4_ops)",
       "DBCreateOdontogramTable(create odontogram_index)");

}
//crear una nueva odontograma
function DBNewOdontogram($param , $c=null){

		if(isset($param['patientid']) && !isset($param['id'])) $param['id']=$param['patientid'];
		if(isset($param['patientfullname']) && !isset($param['fullname'])) $param['fullname']=$param['patientfullname'];

		if(isset($param['odontogramtr']) && !isset($param['tr'])) $param['tr']=$param['odontogramtr'];
		if(isset($param['odontogramtl']) && !isset($param['tl'])) $param['tl']=$param['odontogramtl'];
		if(isset($param['odontogramtlr']) && !isset($param['tlr'])) $param['tlr']=$param['odontogramtlr'];
		if(isset($param['odontogramtll']) && !isset($param['tll'])) $param['tll']=$param['odontogramtll'];
		if(isset($param['odontogrambl']) && !isset($param['bl'])) $param['bl']=$param['odontogrambl'];
		if(isset($param['odontogrambr']) && !isset($param['br'])) $param['br']=$param['odontogrambr'];
		if(isset($param['odontogrambll']) && !isset($param['bll'])) $param['bll']=$param['odontogrambll'];
		if(isset($param['odontogramblr']) && !isset($param['blr'])) $param['blr']=$param['odontogramblr'];
		$desc=$param["odontogramdesc"];
		$draw=$param["odontodraw"];
		$ac=array('id');
		$ac1=array('tr', 'tl', 'tlr', 'tll', 'bl', 'br', 'bll', 'blr');

		$typei['id']=1;

		foreach($ac as $key) {
			if(!isset($param[$key]) || $param[$key]=="") {
				MSGError("DBNewSpecialty param error: $key not found");
				return false;
			}
			if(isset($typei[$key]) && !is_numeric($param[$key])) {
				MSGError("DBNewSpecialty param error: $key is not numeric");
				return false;
			}
			$$key = myhtmlspecialchars($param[$key]);
		}

		$tr= '';
		$tl= '';
		$tlr= '';
		$tll= '';
		$bl= '';
		$br= '';
		$bll= '';
		$blr= '';
		$updatetime=-1;
		foreach($ac1 as $key) {
			if(isset($param[$key])) {
				$$key = myhtmlspecialchars($param[$key]);
				if(isset($typei[$key]) && !is_numeric($param[$key])) {
					MSGError("DBNewSpecialty param error: $key is not numeric");
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
			DBExec($c, "begin work", "DBNewOdontogram(begin)");
			DBExec($c, "lock table odontogramtable", "DBNewOdontogram(lock)");
		}


		$ret=0;

		if($param["odontogramid"]=="")
			$oi=DBOdontogramNumberMax();
		else
			$oi=$param["odontogramid"];

		$sql="select *from odontogramtable where odontogramid=$oi";
		$a = DBGetRow ($sql, 0, $c);
		$ret=0;
		if($a==null){
			$ret=2;
			$oi=DBOdontogramNumberMax();
			$sql = "insert into odontogramtable (odontogramid, tr, tl, tlr, tll, ".
						 "bl, br, bll, blr, description, draw, patientid) values " .
					"($oi, '$tr', '$tl', '$tlr', '$tll', '$bl', '$br', '$bll', '$blr', '$desc', '$draw', $id)";
			DBExec ($c, $sql, "DBNewOdontogram(insert)");
			LOGLevel ("Odongram $oi registrado.",2);
		}else{
			if(isset($param["mod"])){
				if($param["mod"]=='new'){
					$oi=DBOdontogramNumberMax();

					$ret=2;
					$sql = "insert into odontogramtable (odontogramid, tr, tl, tlr, tll, ".
								 "bl, br, bll, blr, description, draw, patientid) values " .
							"($oi, '$tr', '$tl', '$tlr', '$tll', '$bl', '$br', '$bll', '$blr', '$desc', '$draw', $id)";
					DBExec ($c, $sql, "DBNewOdontogram(insert)");
					LOGLevel ("Odontogram $oi+1 registrado.",2);
				}elseif ($param["mod"]=='update') {
					$ret=2;

					$oi=$param["odontogramid"];
					$sql="update odontogramtable set tr='$tr', tl='$tl', tlr='$tlr', tll='$tll', bl='$bl', br='$br', ".
						"bll='$bll', blr='$blr', description='$desc', draw='$draw' where odontogramid=$oi and patientid=$id";

					DBExec ($c, $sql, "DBNewOdontogram(update)");
					LOGLevel ("Odontogram $oi actualizado.",2);
				}else{
					LOGLevel ("Modo de registrio invalido",2);
					return false;
				}
			}else{
				LOGLevel ("No encontrado el modo de registrio",2);
				return false;
			}

		}


		if($cw) DBExec($c, "commit work");

		return $ret;
}
//funciones para crear y eliminar la tabla de antecedentes medico general
function DBDropDentalExamTable() {
         $c = DBConnect();
         $r = DBExec($c, "drop table \"dentalexamtable\"", "DBDropDentalExamTable(drop table)");
}

function DBCreateDentalExamTable() {
         $c = DBConnect();
	       $conf = globalconf();

         if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
         $r = DBExec($c, "
         CREATE TABLE \"dentalexamtable\" (
                \"dentalid\" int4 NOT NULL,                      -- (id del examen dental)

								\"dentalfaces\"	varchar(50) DEFAULT '',								-- (facies)
								\"dentalprofile\"	varchar(50) DEFAULT '',								-- (perfil)
								\"dentalscars\"	varchar(50) DEFAULT '',								-- (cicatrices)
								\"dentalatm\"	varchar(50) DEFAULT '',								-- (a.t.m)
								\"dentalganglia\"	varchar(50) DEFAULT '',								-- (ganglios)
								\"dentallips\"	varchar(50) DEFAULT '',								-- (labios)
								\"dentalulcerations\"	varchar(50) DEFAULT '',								-- (ulceraciones)
								\"dentalcheilitis\"	varchar(50) DEFAULT '',								-- (queilitis)
								\"dentalcommissures\"	varchar(50) DEFAULT '',								-- (comisuras)
								\"dentaltez\"	varchar(50) DEFAULT '',								-- (Tez para prostodoncia removible)

								\"dentaltongue\" varchar(50) DEFAULT '',									-- (lengua)
                \"dentalpiso\" varchar(50) DEFAULT '',                   -- (piso de la boca)
                \"dentalencias\" varchar(50) DEFAULT '',       				-- (encias)
                \"dentalmucosa\" varchar(50) DEFAULT '',    -- (mucosa bucal)
                \"dentalbraces\" varchar(100) DEFAULT '',    -- (insersion de frenillos)
                \"dentalpalatine\" varchar(50) DEFAULT '',    -- (boveda palatina)
                \"dentaltypeo\" varchar(50) DEFAULT '',        -- (tipo de oclusion)
                \"dentaltypep\" varchar(50) DEFAULT '',        -- (tipo de protesis)
                \"dentalhygiene\" varchar(50) DEFAULT '',        -- (higiene bucal)

								\"lastconsult\" varchar(200) DEFAULT '',			-- (ultima consulta)
								\"motconsult\" varchar(200) DEFAULT '',				-- (motivo de consulta)
								\"generalstatus\" varchar(200) DEFAULT '',		--(estado general del paciente)

								\"patientid\" int4 NOT NULL,									-- (id de que registra admision)
                CONSTRAINT \"dental_pkey\" PRIMARY KEY (\"dentalid\", \"patientid\"),
                CONSTRAINT \"dentalpatient\" FOREIGN KEY (\"patientid\")
                        REFERENCES \"patienttable\" (\"patientid\")
                        ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        )", "DBCreateDentalExamTable(create table)");
        $r = DBExec($c, "REVOKE ALL ON \"dentalexamtable\" FROM PUBLIC", "DBCreateDentalExamTable(revoke public)");

        $r = DBExec($c, "GRANT INSERT, SELECT ON \"dentalexamtable\" TO \"".$conf["dbuser"]."\"", "DBCreateDentalExamTable(grant sihcouser)");
	      $r = DBExec($c, "CREATE INDEX \"dental_index\" ON \"dentalexamtable\" USING btree ".
	     "(\"dentalid\" int4_ops, \"patientid\" int4_ops)",
       "DBCreateDentalExamTable(create log_index)");

}
//funcion para insertar un nuevo
function DBNewRemissionPatient($param, $c=null){
	$cw = false;
	if($c == null) {
		$cw = true;
		$c = DBConnect();
		DBExec($c, "begin work", "DBNewRemissionPatient(begin)");
	}
	if($param["idpa"]!=""){
		if(($pat=DBPatientRemissionInfo($param["idpa"]))==null){
				MSGError("id remision no encontrado");
				return false;
		}
		$param["idp"]=$pat["patientid"];//se asigna el id del paciente.
		$param["idpa"]=$pat["patientadmissionid"];
	}
	//funcion para registrar paciente
	$exit=false;
	$ret=DBNewPatient($param, $c);

	if($cw) DBExec($c, "commit work");
	return $ret;
}

//funcion para crear un nuevo examen dental
function DBNewDentalExam($param , $c=null){

		if(isset($param['patientid']) && !isset($param['id'])) $param['id']=$param['patientid'];
		if(isset($param['dentalid']) && !isset($param['de'])) $param['de']=$param['dentalid'];
		if(isset($param['patientfullname']) && !isset($param['fullname'])) $param['fullname']=$param['patientfullname'];

		if(isset($param['patientfaces']) && !isset($param['faces'])) $param['faces']=$param['patientfaces'];
		if(isset($param['patientprofile']) && !isset($param['profile'])) $param['profile']=$param['patientprofile'];
		if(isset($param['patientscars']) && !isset($param['scars'])) $param['scars']=$param['patientscars'];
		if(isset($param['patientatm']) && !isset($param['atm'])) $param['atm']=$param['patientatm'];
		if(isset($param['patientganglia']) && !isset($param['ganglia'])) $param['ganglia']=$param['patientganglia'];
		if(isset($param['patientlips']) && !isset($param['lips'])) $param['lips']=$param['patientlips'];
		if(isset($param['patientulcerations']) && !isset($param['ulcerations'])) $param['ulcerations']=$param['patientulcerations'];
		if(isset($param['patientcheilitis']) && !isset($param['cheilitis'])) $param['cheilitis']=$param['patientcheilitis'];
		if(isset($param['patientcommissures']) && !isset($param['commissures'])) $param['commissures']=$param['patientcommissures'];

		if(isset($param['patienttongue']) && !isset($param['tongue'])) $param['tongue']=$param['patienttongue'];
		if(isset($param['patientpiso']) && !isset($param['piso'])) $param['piso']=$param['patientpiso'];
		if(isset($param['patientencias']) && !isset($param['encias'])) $param['encias']=$param['patientencias'];
		if(isset($param['patientmucosa']) && !isset($param['mucosa'])) $param['mucosa']=$param['patientmucosa'];
		if(isset($param['patientocclusion']) && !isset($param['occlusion'])) $param['occlusion']=$param['patientocclusion'];
		if(isset($param['patientprosthesis']) && !isset($param['prosthesis'])) $param['prosthesis']=$param['patientprosthesis'];
		if(isset($param['patienthygiene']) && !isset($param['hygiene'])) $param['hygiene']=$param['patienthygiene'];
		if(isset($param['patientlastconsultation']) && !isset($param['lastconsultation'])) $param['lastconsultation']=$param['patientlastconsultation'];
		if(isset($param['patientconsultation']) && !isset($param['consultation'])) $param['consultation']=$param['patientconsultation'];
		if(isset($param['patientgeneralstatus']) && !isset($param['generalstatus'])) $param['generalstatus']=$param['patientgeneralstatus'];

		$ac=array('id');
		$ac1=array('lastconsultation', 'consultation', 'generalstatus', 'tongue', 'piso', 'encias', 'mucosa', 'occlusion', 'prosthesis', 'hygiene',
							'faces', 'profile', 'scars', 'atm', 'ganglia', 'lips', 'ulcerations', 'cheilitis', 'commissures');

		$typei['id']=1;
		$typei['updatetime']=1;




		foreach($ac as $key) {
			if(!isset($param[$key]) || $param[$key]=="") {
				MSGError("DBNewDentalExam param error: $key not found");
				return false;
			}
			if(isset($typei[$key]) && !is_numeric($param[$key])) {
				MSGError("DBNewDentalExam param error: $key is not numeric");
				return false;
			}
			$$key = myhtmlspecialchars($param[$key]);
		}

		$fullname='';
		$updatetime=-1;
		$lastconsultation='';
		$consultation='';
		$generalstatus='';

		$faces='';
		$profile='';
		$scars='';
		$atm='';
		$ganglia='';
		$lips='';
		$ulcerations='';
		$cheilitis='';
		$commissures='';

		$tongue='';
		$piso='';
		$encias='';
		$mucosa='';
		$occlusion='';
		$prosthesis='';
		$hygiene='';

		foreach($ac1 as $key) {
			if(isset($param[$key])) {
				$$key = myhtmlspecialchars($param[$key]);
				if(isset($typei[$key]) && !is_numeric($param[$key])) {
					MSGError("DBNewDentalExam param error: $key is not numeric");
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
			DBExec($c, "begin work", "DBNewDentalExam(begin)");
			DBExec($c, "lock table dentalexamtable", "DBNewDentalExam(lock)");
		}

		$ret=2;

		if($param["dentalid"]=="")
			$de=DBDentalExamNumberMax();
		else
			$de=$param["dentalid"];

		$sql="select *from dentalexamtable where dentalid=$de";
		$a = DBGetRow ($sql, 0, $c);
		$ret=0;
		if($a==null){
			$ret=2;
			$de=DBDentalExamNumberMax();//el maximo registro de la tabla

			$sql = "insert into dentalexamtable (dentalid, dentaltongue, dentalpiso, dentalencias, ".
						 "dentalmucosa, dentaltypeo, dentaltypep, dentalhygiene, lastconsult, motconsult, patientid) values " .
					"($de, '$tongue', '$piso', '$encias', '$mucosa', '$occlusion', '$prosthesis', '$hygiene', '$lastconsultation', '$consultation', $id)";
			DBExec ($c, $sql, "DBNewDentalExam(insert)");
			LOGLevel ("Dental exam $de registrado.",2);
		}else{
			if(isset($param["mod"])){
				$de=DBDentalExamNumberMax();//el maximo registro de la tabla
				if($param["mod"]=='new'){

					$ret=2;
					$sql = "insert into dentalexamtable (dentalid, dentaltongue, dentalpiso, dentalencias, ".
								 "dentalmucosa, dentaltypeo, dentaltypep, dentalhygiene, lastconsult, motconsult, patientid) values " .
							"($de, '$tongue', '$piso', '$encias', '$mucosa', '$occlusion', '$prosthesis', '$hygiene', '$lastconsultation', '$consultation', $id)";
					DBExec ($c, $sql, "DBNewDentalExam(insert)");

					LOGLevel ("Dental Exam $de registrado.",2);
				}elseif ($param["mod"]=='update' && $param["dentalid"]!="") {
					$ret=2;
					$de=$param["dentalid"];

					$sql="update dentalexamtable set dentaltongue='$tongue', dentalpiso='$piso', dentalencias='$encias', ".
						"generalstatus='$generalstatus', dentalfaces='$faces', dentalprofile='$profile', dentalscars='$scars', ".
						"dentalatm='$atm', dentalganglia='$ganglia', dentallips='$lips', dentalulcerations='$ulcerations', ".
						"dentalcheilitis='$cheilitis', dentalcommissures='$commissures', ".
						"dentalmucosa='$mucosa', dentaltypeo='$occlusion', dentaltypep='$prosthesis', dentalhygiene='$hygiene', ".
						"lastconsult='$lastconsultation', motconsult='$consultation' where dentalid=$de and patientid=$id";
					DBExec ($c, $sql, "DBNewDentalExam(update)");
					LOGLevel ("Dental exam $de actualizado.",2);
				}else{
					if($cw)
			 			DBExec ($c, "rollback work");
					LOGLevel ("Modo de registrio invalido",2);
					return false;
				}
			}else{
				if($cw)
					DBExec ($c, "rollback work");
				LOGLevel ("No encontrado el modo de registrio",2);
				return false;
			}

		}

		if($cw) DBExec($c, "commit work");
		return $ret;
}
//funcion para sacar la informacion del paciente
//funcion para sacar la informacion de usuario
function DBPatientInfoFullname($fullname, $c=null) {

	$sql = "select * from patienttable where patientfullname='$fullname'";
	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");

		//MSGError("Unable to find the user in the database. Contact an admin now!");
		return null;
	}
	return $a;
}




/*
//funciones para crear y eliminar la tabla de antecedentes medico general
function DBDropGeneralPractitionerTable() {
         $c = DBConnect();
         $r = DBExec($c, "drop table \"generalpractitionertable\"", "DBDropGeneralPractitionerTable(drop table)");
}

function DBCreateGeneralPractitionerTable() {
         $c = DBConnect();
	       $conf = globalconf();

         if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
         $r = DBExec($c, "
         CREATE TABLE \"generalpractitionertable\" (
                \"gpnumber\" serial,                      -- (auto_incrementado para el gp)
								\"gpid\" int4,														-- (id de un registro)
                \"patientid\" int4,                       -- (id del paciente)
                \"gpdisease\" int4 NOT NULL,       				-- (numero de enfermedad)
                \"gpstatus\" varchar(20) DEFAULT 'on',    -- (no tiene enfermedad)
                \"gpobs\" varchar(200) DEFAULT '',        -- (observacion del enfermedad)
                CONSTRAINT \"gp_pkey\" PRIMARY KEY (\"gpnumber\",\"gpid\",\"patientid\"),
                CONSTRAINT \"gppatient\" FOREIGN KEY (\"patientid\")
                        REFERENCES \"patienttable\" (\"patientid\")
                        ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        )", "DBCreateGeneralPractitionerTable(create table)");
        $r = DBExec($c, "REVOKE ALL ON \"generalpractitionertable\" FROM PUBLIC", "DBCreateGeneralPractitionerTable(revoke public)");

        $r = DBExec($c, "GRANT INSERT, SELECT ON \"generalpractitionertable\" TO \"".$conf["dbuser"]."\"", "DBCreateGeneralPractitionerTable(grant sihcouser)");
	      $r = DBExec($c, "CREATE INDEX \"gp_index\" ON \"generalpractitionertable\" USING btree ".
	     "(\"gpnumber\" int4_ops, \"gpid\" int4_ops, \"patientid\" int4_ops)",
       "DBCreateLogTable(create log_index)");

}*/
//funcion para crear y eliminar la tabla para remision
//funciones para crear y eliminar la tabla de antecedentes medico general
function DBDropRemissionTable() {
         $c = DBConnect();
         $r = DBExec($c, "drop table \"remissiontable\"", "DBDropRemissionTable(drop table)");
}

function DBCreateRemissionTable() {
         $c = DBConnect();
	       $conf = globalconf();

         if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
         $r = DBExec($c, "
         CREATE TABLE \"remissiontable\" (
                \"remissionid\" int4 NOT NULL,          -- (id del registro remision)
								\"patientadmissionid\" int4 NOT NULL,		-- (admission patient id)
								\"patientid\" int4 NOT NULL,						-- (patient id)
								\"clinicalid\" int4 NOT NULL, 					-- (clinica remitida)
								\"enabled\" bool DEFAULT 't' NOT NULL,	 -- (para saber si esta remitido)

								\"stdatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la fecha del registro)
								\"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
								CONSTRAINT \"remission_pkey\" PRIMARY KEY (\"remissionid\", \"patientadmissionid\", \"patientid\", \"clinicalid\"),
                CONSTRAINT \"clinical_fk\" FOREIGN KEY (\"clinicalid\")
                        REFERENCES \"clinicaltable\" (\"clinicalid\")
                        ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,

								CONSTRAINT \"patientadmission_fk\" FOREIGN KEY (\"patientadmissionid\", \"patientid\")
                        REFERENCES \"patientadmissiontable\" (\"patientadmissionid\", \"patientid\")
                        ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        )", "DBCreateRemissionTable(create table)");
        $r = DBExec($c, "REVOKE ALL ON \"remissiontable\" FROM PUBLIC", "DBCreateRemissionTable(revoke public)");

        $r = DBExec($c, "GRANT INSERT, SELECT ON \"remissiontable\" TO \"".$conf["dbuser"]."\"", "DBCreateRemissionTable(grant sihcouser)");
	      $r = DBExec($c, "CREATE INDEX \"remission_index\" ON \"remissiontable\" USING btree ".
	     "(\"remissionid\" int4_ops, \"patientadmissionid\" int4_ops, \"patientid\" int4_ops, \"clinicalid\" int4_ops)",
       "DBCreateRemissionTable(create log_index)");
}
//funcion insertar una nueva remision
function DBNewRemission($param, $c=null){

	if(isset($param['remissionid']) && !isset($param['idre'])) $param['idre']=$param['remissionid'];
	if(isset($param['patientid']) && !isset($param['idp'])) $param['idp']=$param['patientid'];
	if(isset($param['patientadmissionid']) && !isset($param['idpa'])) $param['idpa']=$param['patientadmissionid'];
	if(isset($param['clinicalid']) && !isset($param['clinical'])) $param['clinical']=$param['clinicalid'];

	$ac=array('idp', 'idpa', 'clinical');

	$ac1=array('updatetime');

	$typei['updatetime']=1;

	$typei['idp']=-1;
	$typei['idpa']=-1;
	$typei['clinical']=-1;
	foreach($ac as $key) {
		if(!isset($param[$key]) || $param[$key]=="") {
			MSGError("DBNewRemission param error: $key not found");
			return false;
		}
		if(isset($typei[$key]) && !is_numeric($param[$key])) {
			MSGError("DBNewRemission param error: $key is not numeric");
			return false;
		}
		$$key = myhtmlspecialchars($param[$key]);
	}

	$updatetime=-1;

	foreach($ac1 as $key) {
		if(isset($param[$key])) {
			$$key = myhtmlspecialchars($param[$key]);
			if(isset($typei[$key]) && !is_numeric($param[$key])) {
				MSGError("DBNewRemission param error: $key is not numeric");
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
		DBExec($c, "begin work", "DBNewRemission(begin)");
	}
	//DBExec($c, "lock table remissiontable", "DBNewRemission(lock)");


	if(isset($param["remissionid"])&&is_numeric($param["remissionid"]))
		$idre=$param["remissionid"];
	else
		$idre=DBRemissionNumberMax();

	$sql="select *from remissiontable where remissionid=$idre";
	$a = DBGetRow ($sql, 0, $c);
	$ret=0;
	if($a==null){
		$ret=2;
		$sql="insert into remissiontable (remissionid, patientadmissionid, patientid, clinicalid) values ".
		"($idre, $idpa, $idp, $clinical)";
		DBExec($c, $sql, "DBNewRemission(insert remission)");
		if(isset($param['examined'])&&is_numeric($param['examined'])){
				$param['remissionid']=$idre;
				$param['idre']=$idre;

				$param['studentid']=$param['examined'];
				$param['studentclinicalid']=$clinical;
				$param['teacherid']=0;//admin
				$param['teacherclinicalid']=$clinical;
				DBNewClinichistory($param, $c);
		}

		LOGLevel ("remitido paciente $idp a la especilidad $clinical registrado.",2);
	}else{
		if($updatetime >= $a['updatetime'] ){
			$ret=2;
			$idre=$a['remissionid'];
			if($clinical!=$a['clinicalid']){
				if(($a=DBClinicHistoryInfo($idre))==null){
					$sql="update remissiontable set clinicalid=$clinical where remissionid=$idre";
					DBExec($c, $sql, "DBNewRemission(update clinicalid remission)");
					LOGLevel ("remission actualizada $idre",2);
				}else{
					$sql="update remissiontable set enabled='f' where remissionid=$idre";
					DBExec($c, $sql, "DBNewRemission(update enabled f remission)");
					$param['remissionid']='';
					$param['idre']='';
					DBNewRemission($param, $c);
					LOGLevel ("remission congelada $idre",2);
				}

			}else{
				if(isset($param['examined'])&&is_numeric($param['examined'])){
						$param['remissionid']=$idre;

						$param['studentid']=$param['examined'];
						$param['studentclinicalid']=$clinical;
						$param['teacherid']=0;//admin
						$param['teacherclinicalid']=$clinical;
						if(($a=DBClinicHistoryInfo($idre))!=null){
							$param['teacherid']=$a['teacherid'];
							$param['teacherclinicalid']=$a['teacherclinicalid'];
							$param['teachercourseid']=$a['teachercourseid'];
						}
						DBNewClinichistory($param, $c);
				}
			}

		}

	}


	if($cw) DBExec($c, "commit work");


	return $ret;
}
/*function DBNewRemission($param, $swrid=false, $c=null){


	if(isset($param['patientid']) && !isset($param['id'])) $param['id']=$param['patientid'];
	if(isset($param['admissionid']) && !isset($param['admission'])) $param['admission']=$param['admissionid'];
	if(isset($param['patientfullname']) && !isset($param['fullname'])) $param['fullname']=$param['patientfullname'];
	if(isset($param['patientdiagnostico']) && !isset($param['diagnostico'])) $param['diagnostico']=$param['patientdiagnostico'];
	if(isset($param['patientclinical']) && !isset($param['clinical'])) $param['clinical']=$param['patientclinical'];
	if(isset($param['patientexamined']) && !isset($param['examined'])) $param['examined']=$param['patientexamined'];

	$ac=array('clinical', 'examined', 'admission');
	//$ac=array('contest','site','user');

	$ac1=array('fullname', 'diagnostico', 'updatetime');
	$fullname=$param['fullname'];
	$id=$param["id"];




	$typei['updatetime']=1;

	$typei['clinical']=1;
	$typei['admission']=-1;
	$typei['examined']=0;
	$updatetime=-1;
	foreach($ac as $key) {
		if(!isset($param[$key]) || $param[$key]=="") {
			MSGError("DBNewSpecialty param error: $key not found");
			return false;
		}
		if(isset($typei[$key]) && !is_numeric($param[$key])) {
			MSGError("DBNewSpecialty param error: $key is not numeric");
			return false;
		}
		$$key = myhtmlspecialchars($param[$key]);
	}

	$fullname='';
	$diagnostico='';


	foreach($ac1 as $key) {
		if(isset($param[$key])) {
			$$key = myhtmlspecialchars($param[$key]);
			if(isset($typei[$key]) && !is_numeric($param[$key])) {
				MSGError("DBNewSpecialty param error: $key is not numeric");
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
		DBExec($c, "begin work", "DBNewRemission(begin)");
	}
	//DBExec($c, "lock table remissiontable", "DBNewRemission(lock)");



	if($param["remissionid"]=="")
		$rid=DBRemissionNumberMax();
	else
		$rid=$param["remissionid"];

	$sql="select *from remissiontable where remissionid=$rid";
	$a = DBGetRow ($sql, 0, $c);
	$ret=0;
	//$admission=$_SESSION["usertable"]["usernumber"];
	$data=array();//array para ficha clinica
	if($a==null){
		$ret=2;
		$paid=DBPatientAdmissionNumberMax()-1;
		$tid=DBTriageNumberMax()-1;
		$ed=DBDentalExamNumberMax()-1;
		$oi=DBOdontogramNumberMax()-1;
		$rid=DBRemissionNumberMax();

		$sql = "insert into remissiontable (remissionid, diagnostico, examined, clinicalid, ".
					 "patientadmissionid, patientdentalid, odontogramid, patientid, triageid, admissionid, updatetime) values " .
				"($rid, '$diagnostico', $examined, $clinical, $paid, $ed, $oi, $id, $tid, $admission, $updatetime)";
		DBExec ($c, $sql, "DBNewRemission(insert)");
		$data["clinicalold"]=$clinical;
		LOGLevel ("remitido paciente $id registrado.",2);
	}else{
		if(isset($param["mod"])){
			if($param["mod"]=='new'){
				$ret=2;
				$paid=DBPatientAdmissionNumberMax()-1;
				$tid=DBTriageNumberMax()-1;
				$ed=DBDentalExamNumberMax()-1;
				$oi=DBOdontogramNumberMax()-1;

				$rid=DBRemissionNumberMax();

				$sql = "insert into remissiontable (remissionid, diagnostico, examined, clinicalid, ".
							 "patientadmissionid, patientdentalid, odontogramid, patientid, triageid, admissionid, updatetime) values " .
						"($rid, '$diagnostico', $examined, $clinical, $paid, $ed, $oi, $id, $tid, $admission, $updatetime)";
				DBExec ($c, $sql, "DBNewRemission(insert)");

				$data['clinicalold']=$clinical;
				LOGLevel ("remitido paciente $id",2);
			}elseif ($param["mod"]=='update' && $param["patientadmissionid"]!="" && $param["triageid"]!="" &&
						$param["dentalid"]!="" && $param["odontogramid"]!="" && $param["remissionid"]!="") {
				$ret=2;
				$paid=$param["patientadmissionid"];
				$tid=$param["triageid"];
				$ed=$param["dentalid"];
				$oi=$param["odontogramid"];

				//$rid=$param["remissionid"];//id para actualizar un remision
				$ar= array(1 => 'removable', 2 => 'fixed', 3 => 'operative', 4 => 'endodontics', 5 => 'surgeryii', 6 => 'periodonticsii', 7 => 'pediatricsi', 8 => 'orthodontics', 9 => 'removable', 10 => 'fixed', 11 => 'operative', 12 => 'endodontics', 13 => 'surgeryii',
				14 => 'periodonticsii', 15 => 'pediatricsi', 16 => 'orthodontics');//añador para nuevas fichas clinicasl....
				if($a['clinicalid']!=$clinical && array_key_exists($clinical, $ar)){
					$sql="update ".$ar[$a['clinicalid']]."table set teacher=0 where remissionid=$rid";

					DBExec ($c, $sql, "DBNewRemission(update)");
				}

				$sql="update remissiontable set diagnostico='$diagnostico', examined=$examined, clinicalid=$clinical ".
						"where remissionid=$rid";

				DBExec ($c, $sql, "DBNewRemission(update)");

				$data['clinicalold']=$a['clinicalid'];
				LOGLevel ("Remision $rid actualizado.",2);
			}else{
				LOGLevel ("Modo de registrio invalido",2);
				return false;
			}
		}else{
			LOGLevel ("No encontrado el modo de registrio",2);
			return false;
		}

	}






	if($cw) DBExec($c, "commit work");
	LOGLevel ("Paciente $id remitido a la especialidad $clinical",2);

	if($ret==2 && $cw==false){
		DBExec($c, "commit work");//para el commit de exito
		$data['patientid']=$id;
		$data['studentid']=$examined;
		$data['teacherid']=-1;//para el docente default 0 que es el admin
		$data['clinicalid']=$clinical;
		$data['remissionid']=$rid;
		$data['type']=$param["mod"];
		$data['updatetime']=$updatetime;

		DBNewClinicalRecord($data);
	}
	if($swrid){
		$ret=$rid;
	}
	return $ret;
}*/
//funcion para crear un nuevo ficha clinica designada
function DBNewClinicalRecord($data){
	if($data['clinicalold']==1){
		if($data['clinicalold']!=$data['clinicalid']){
			DBDeleteRemovable($data['remissionid']);
			$data['clinicalold']=$data['clinicalid'];
			//echo "eliminado ficha prostodoncia fija II
			DBNewClinicalRecord($data);//recursive
		}else{
				//echo "crear una nueva ficha prostodoncia removible ii";
				DBNewRemovable($data);//funcion para actualizar.....-.-
		}
	}elseif($data['clinicalold']==2){
		if($data['clinicalold']!=$data['clinicalid']){
			DBDeleteFixed($data['remissionid']);
			$data['clinicalold']=$data['clinicalid'];
			//echo "eliminado ficha prostodoncia fija II
			DBNewClinicalRecord($data);//recursive
		}else{
				//echo "crear una nueva ficha prostodoncia fija ii";
				DBNewFixed($data);//funcion para actualizar.....-.-
		}
	}elseif($data['clinicalold']==3){
		if($data['clinicalold']!=$data['clinicalid']){
			DBDeleteOperative($data['remissionid']);
			$data['clinicalold']=$data['clinicalid'];
			//echo "eliminado ficha operatoria dental ii
			DBNewClinicalRecord($data);//recursive
		}else{
				//echo "crear una nueva ficha operatoria dental";
				DBNewOperative($data);//funcion para actualizar.....-.-
		}
	}elseif($data['clinicalold']==4){
		if($data['clinicalold']!=$data['clinicalid']){
			DBDeleteEndodontics($data['remissionid']);
			$data['clinicalold']=$data['clinicalid'];
			//echo "eliminado ficha endodonticia II
			DBNewClinicalRecord($data);//recursive
		}else{
				//echo "crear una nueva ficha endodoncia ii";
				DBNewEndodontics($data);//funcion para actualizar.....-.-
		}
	}elseif($data['clinicalold']==5){//cirugia bucal II
		if($data['clinicalold']!=$data['clinicalid']){
			DBDeleteSurgeryii($data['remissionid']);
			$data['clinicalold']=$data['clinicalid'];
			//echo "eliminado ficha cirugia bucal ii";
			DBNewClinicalRecord($data);//recursive
		}else{
				//echo "crear una nueva ficha cirugia bucal ii";
				DBNewSurgeryii($data);//funcion para actualizar.....-.-
		}
	}elseif ($data['clinicalold']==6){//periodoncia II
		if($data['clinicalold']!=$data['clinicalid']){
			DBDeletePeriodonticsii($data['remissionid']);
			$data['clinicalold']=$data['clinicalid'];
			//echo "eliminado periodoncia fija";
			DBNewClinicalRecord($data);//recursive
		}else{
				//echo "crear una nueva ficha periodoncia fija";
				DBNewPeriodonticsii($data);//funcion para actualizar.....-.-
		}
	}elseif ($data['clinicalold']==7){//odontopediatria I
		if($data['clinicalold']!=$data['clinicalid']){
			DBDeletePediatricsi($data['remissionid']);
			$data['clinicalold']=$data['clinicalid'];
			//echo "eliminado odonto pediatria I";
			DBNewClinicalRecord($data);//recursive
		}else{
				//echo "crear una nueva ficha odontopediatria I";
				DBNewPediatricsi($data);//funcion para actualizar.....-.-
		}
	}elseif ($data['clinicalold']==8){//Ortodoncia I
		if($data['clinicalold']!=$data['clinicalid']){

			DBDeleteOrthodontics($data['remissionid']);
			$data['clinicalold']=$data['clinicalid'];
			//echo "eliminado odonto pediatria I";
			DBNewClinicalRecord($data);//recursive
		}else{
				//echo "crear una nueva ficha odontopediatria I";
				DBNewOrthodontics($data);//funcion para actualizar.....-.-
		}
	}elseif($data['clinicalold']==9){
		if($data['clinicalold']!=$data['clinicalid']){
			DBDeleteRemovable($data['remissionid']);
			$data['clinicalold']=$data['clinicalid'];
			//echo "eliminado ficha prostodoncia removable III
			DBNewClinicalRecord($data);//recursive
		}else{
				//echo "crear una nueva ficha prostodoncia removible III";
				DBNewRemovable($data);//funcion para actualizar.....-.-
		}
	}elseif($data['clinicalold']==10){
		if($data['clinicalold']!=$data['clinicalid']){
			DBDeleteFixed($data['remissionid']);
			$data['clinicalold']=$data['clinicalid'];
			//echo "eliminado ficha prostodoncia fija II
			DBNewClinicalRecord($data);//recursive
		}else{
				//echo "crear una nueva ficha prostodoncia fija ii";
				DBNewFixed($data);//funcion para actualizar.....-.-
		}
	}elseif($data['clinicalold']==11){
		if($data['clinicalold']!=$data['clinicalid']){
			DBDeleteOperative($data['remissionid']);
			$data['clinicalold']=$data['clinicalid'];
			//echo "eliminado ficha operatoria dental ii
			DBNewClinicalRecord($data);//recursive
		}else{
				//echo "crear una nueva ficha operatoria dental";
				DBNewOperative($data);//funcion para actualizar.....-.-
		}
	}elseif($data['clinicalold']==12){
		if($data['clinicalold']!=$data['clinicalid']){
			DBDeleteEndodontics($data['remissionid']);
			$data['clinicalold']=$data['clinicalid'];
			//endodonticia III
			DBNewClinicalRecord($data);//recursive
		}else{
				//echo "crear una nueva ficha endodoncia ii";
				DBNewEndodontics($data);//funcion para actualizar.....-.-
		}
	}elseif($data['clinicalold']==13){//cirugia bucal III
		if($data['clinicalold']!=$data['clinicalid']){
			DBDeleteSurgeryii($data['remissionid']);
			$data['clinicalold']=$data['clinicalid'];
			//echo "eliminado ficha cirugia bucal ii";
			DBNewClinicalRecord($data);//recursive
		}else{
				//echo "crear una nueva ficha cirugia bucal ii";
				DBNewSurgeryii($data);//funcion para actualizar.....-.-
		}
	}elseif ($data['clinicalold']==14){//periodoncia II
		if($data['clinicalold']!=$data['clinicalid']){
			DBDeletePeriodonticsii($data['remissionid']);
			$data['clinicalold']=$data['clinicalid'];
			//echo "eliminado periodoncia fija";
			DBNewClinicalRecord($data);//recursive
		}else{
				//echo "crear una nueva ficha periodoncia fija";
				DBNewPeriodonticsii($data);//funcion para actualizar.....-.-
		}
	}elseif ($data['clinicalold']==15){//odontopediatria II
		if($data['clinicalold']!=$data['clinicalid']){
			DBDeletePediatricsi($data['remissionid']);
			$data['clinicalold']=$data['clinicalid'];
			//echo "eliminado odonto pediatria II";
			DBNewClinicalRecord($data);//recursive
		}else{
				//echo "crear una nueva ficha odontopediatria II";
				DBNewPediatricsi($data);//funcion para actualizar.....-.-
		}
	}elseif ($data['clinicalold']==16){//Ortodoncia I
		if($data['clinicalold']!=$data['clinicalid']){

			DBDeleteOrthodontics($data['remissionid']);
			$data['clinicalold']=$data['clinicalid'];
			//echo "eliminado odonto ortodonticia II";
			DBNewClinicalRecord($data);//recursive
		}else{
				//echo "crear una nueva ficha ortodoncia II";
				DBNewOrthodontics($data);//funcion para actualizar.....-.-
		}
	}
}
function DBSpecialtyInfo($user, $clinical, $course, $c=null) {
	//falta año
	$sql = "select * from specialtytable where userid=$user and clinicalid=$clinical and coursenumber=$course and specialtyenabled='t'";
	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");

		//MSGError("Unable to find the user in the database. Contact an admin now!");
		return null;
	}
	return $a;
}

//funcion para crear la tabla triage
function DBDropTriageTable() {
         $c = DBConnect();
         $r = DBExec($c, "drop table \"triagetable\"", "DBDropTriageTable(drop table)");
}

function DBCreateTriageTable() {
         $c = DBConnect();
	       $conf = globalconf();

         if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
         $r = DBExec($c, "
         CREATE TABLE \"triagetable\" (
                \"triageid\" int4 NOT NULL,               			-- (id de triage)
                \"patientid\" int4 NOT NULL,                    -- (id de paciente)
                \"triagetemperature\" varchar(200) DEFAULT '',  -- (temperatura del paciente)
                \"triageheadache\" bool DEFAULT 'f',            -- (cefalea del paciente)
                \"triagerespiratory\" bool DEFAULT 'f',         -- (dificultad respiratoria del paciente)
                \"triagethroat\" bool DEFAULT 'f',    					-- (dolor de garganta del paciente)
        				\"triagegeneral\" bool DEFAULT 'f',		      		-- (malestar general del paciente)
                \"triagevaccine\" varchar(20) DEFAULT '',     	-- (vacula del paciente)

                CONSTRAINT \"triage_pkey\" PRIMARY KEY (\"triageid\",\"patientid\"),
                CONSTRAINT \"triage\" FOREIGN KEY (\"patientid\")
                        REFERENCES \"patienttable\" (\"patientid\")
                        ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        )", "DBCreateTriageTable(create table)");

        $r = DBExec($c, "REVOKE ALL ON \"triagetable\" FROM PUBLIC", "DBCreateTriageTable(revoke public)");

        $r = DBExec($c, "GRANT INSERT, SELECT ON \"triagetable\" TO \"".$conf["dbuser"]."\"", "DBCreateTriageTable(grant sihcouser)");
	      $r = DBExec($c, "CREATE INDEX \"triage_index\" ON \"triagetable\" USING btree ".
	     "(\"triageid\" int4_ops, \"patientid\" int4_ops)",
       "DBCreateTriageTable(create triage_index)");

}
//funcion para crear especialidades clinical specialty
function DBDropClinicalTable() {
         $c = DBConnect();
         $r = DBExec($c, "drop table \"clinicaltable\"", "DBDropClinicalTable(drop table)");
}

function DBCreateClinicalTable() {
         $c = DBConnect();
	       $conf = globalconf();

         if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
         $r = DBExec($c, "
         CREATE TABLE \"clinicaltable\" (
                \"clinicalid\" serial,               				 			-- (id de clinica)
								\"clinicalmodule\" varchar(200) DEFAULT '',								-- (modulo de la clinical)
                \"clinicalspecialty\" varchar(200) DEFAULT '',  	-- (clinica especialidad)
                \"clinicalcourse\" varchar(200) DEFAULT '',    	 	-- (curso de especialidad)
								\"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
				        CONSTRAINT \"clinical_pkey\" PRIMARY KEY (\"clinicalid\")
				 )", "DBCreateClinicalTable(create table)");
				 $r = DBExec($c, "REVOKE ALL ON \"clinicaltable\" FROM PUBLIC", "DBCreateClinicalTable(revoke public)");
				 $r = DBExec($c, "GRANT ALL ON \"clinicaltable\" TO \"".$conf["dbuser"]."\"", "DBCreateClinicalTable(grant sihcouser)");
				 $r = DBExec($c, "CREATE UNIQUE INDEX \"clinical_index\" ON \"clinicaltable\" USING btree ".
					     "(\"clinicalid\" int4_ops)",
					     "DBCreateClinicalTable(create clinical_index)");
				 $r = DBExec($c, "CREATE UNIQUE INDEX \"clinical_index2\" ON \"clinicaltable\" USING btree ".
					     "(\"clinicalspecialty\" varchar_ops)",
					     "DBCreateClinicalTable(create clinical_index2)");
}
//funcion para crear la tabla especialidad
function DBDropSpecialtyTable() {
         $c = DBConnect();
         $r = DBExec($c, "drop table \"specialtytable\"", "DBDropSpecialtyTable(drop table)");
}

function DBCreateSpecialtyTable() {
         $c = DBConnect();
	       $conf = globalconf();
         if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
         $r = DBExec($c, "
         CREATE TABLE \"specialtytable\" (
								\"userid\" int4 NOT NULL,															-- (id del usuario)
                \"clinicalid\" int4 NOT NULL,  												-- (id de la clinica)
								\"coursenumber\" int4 NOT NULL,												-- (id de curso)
								\"coursename\" varchar(50) DEFAULT '' ,								-- (nombre del curso)
								\"rotate\" varchar(255) DEFAULT '' ,								-- (numero de rote con arrastrantes)
								\"specialtyenabled\" bool DEFAULT 't' NOT NULL,       -- (usuario asignado activo)

								\"stdatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la fecha de registro)
								\"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
				        CONSTRAINT \"specialty_pkey\" PRIMARY KEY (\"userid\", \"clinicalid\", \"coursenumber\"),
								CONSTRAINT \"user_fk\" FOREIGN KEY (\"userid\")
                        REFERENCES \"usertable\" (\"usernumber\")
                        ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
								CONSTRAINT \"clinical_fk\" FOREIGN KEY (\"clinicalid\")
                        REFERENCES \"clinicaltable\" (\"clinicalid\")
                        ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
				 )", "DBCreateSpecialtyTable(create table)");
				 $r = DBExec($c, "REVOKE ALL ON \"specialtytable\" FROM PUBLIC", "DBCreateSpecialtyTable(revoke public)");
				 $r = DBExec($c, "GRANT ALL ON \"specialtytable\" TO \"".$conf["dbuser"]."\"", "DBCreateSpecialtyTable(grant sihcouser)");
				 $r = DBExec($c, "CREATE INDEX \"specialty_index\" ON \"specialtytable\" USING btree ".
					     "(\"userid\" int4_ops, \"clinicalid\" int4_ops)",
					     "DBCreateSpecialtyTable(create specialty_index)");
}


//funcion para designar una especialidad
function DBNewSpecialty($param, $c=null){
	if(isset($param['usernumber']) && !isset($param['user'])) $param['user']=$param['usernumber'];
	if(isset($param['specialtyclinical']) && !isset($param['clinical'])) $param['clinical']=$param['specialtyclinical'];
	if(isset($param['specialtyenabled']) && !isset($param['enabled'])) $param['enabled']=$param['specialtyenabled'];

	$ac=array('user','clinical');
	//$ac=array('contest','site','user');
	$ac1=array('enabled', 'stdatetime','updatetime');

	//$typei['contest']=1;
	$typei['stdatetime']=1;
	$typei['updatetime']=1;
	$typei['user']=1;
	$typei['clinical']=1;
	foreach($ac as $key) {
		if(!isset($param[$key]) || $param[$key]=="") {
			MSGError("DBNewSpecialty param error: $key not found");
			return false;
		}
		if(isset($typei[$key]) && !is_numeric($param[$key])) {
			MSGError("DBNewSpecialty param error: $key is not numeric");
			return false;
		}
		$$key = myhtmlspecialchars($param[$key]);
	}
	$enabled='t';
	$updatetime=-1;
	$stdatetime=-1;
	foreach($ac1 as $key) {
		if(isset($param[$key])) {
			$$key = myhtmlspecialchars($param[$key]);
			if(isset($typei[$key]) && !is_numeric($param[$key])) {
				MSGError("DBNewSpecialty param error: $key is not numeric");
				return false;
			}
		}
	}
	$t = time();
	if($updatetime <= 0)
		$updatetime=$t;
	if($stdatetime <= 0)
		$stdatetime=$t;

	$cw = false;
	if($c == null) {
		$cw = true;
		$c = DBConnect();
		DBExec($c, "begin work", "DBNewSpecialty(begin)");
	}
	DBExec($c, "lock table specialtytable", "DBNewSpecialty(lock)");

	$acourse = array(3,4,4,4,4,4,4,4,4,5,5,5,5,5,5,5,5);
	$course=$acourse[$clinical-1];
	$sql2 = "select * from specialtytable where userid=$user and clinicalid=$clinical and coursenumber=$course";
	$a = DBGetRow ($sql2, 0, $c);
	$ret=0;

	if ($a==null) {
		$ret=2;
		$sql = "insert into specialtytable (userid, clinicalid, specialtyenabled, coursenumber, stdatetime, updatetime) values " .
				"($user, $clinical, '$enabled', $course, $stdatetime, $updatetime)";
		DBExec ($c, $sql, "DBNewSpecialty(insert)");
		if($cw) DBExec($c, "commit work");
		LOGLevel ("Usuario $user designado especialidad $clinical",2);
	}else{
		if($cw) DBExec($c, "commit work");
		LOGLevel ("Usuario $user ya esta designado a especialidad $clinical",2);
	}

	return $ret;
}
//funcion para insertar especilidad admin

function insertspecialty($c){

	DBExec($c, "insert into specialtytable (userid,clinicalid,coursenumber) values ".
			"(0,1,3)","DBFakeUser(insert specialty)");
	DBExec($c, "insert into specialtytable (userid,clinicalid,coursenumber) values ".
			"(0,2,4)","DBFakeUser(insert specialty)");
	DBExec($c, "insert into specialtytable (userid,clinicalid,coursenumber) values ".
			"(0,3,4)","DBFakeUser(insert specialty)");
	DBExec($c, "insert into specialtytable (userid,clinicalid,coursenumber) values ".
			"(0,4,4)","DBFakeUser(insert specialty)");
	DBExec($c, "insert into specialtytable (userid,clinicalid,coursenumber) values ".
			"(0,5,4)","DBFakeUser(insert specialty)");
	DBExec($c, "insert into specialtytable (userid,clinicalid,coursenumber) values ".
			"(0,6,4)","DBFakeUser(insert specialty)");
	DBExec($c, "insert into specialtytable (userid,clinicalid,coursenumber) values ".
			"(0,7,4)","DBFakeUser(insert specialty)");
	DBExec($c, "insert into specialtytable (userid,clinicalid,coursenumber) values ".
			"(0,8,4)","DBFakeUser(insert specialty)");
	DBExec($c, "insert into specialtytable (userid,clinicalid,coursenumber) values ".
			"(0,9,4)","DBFakeUser(insert specialty)");
	DBExec($c, "insert into specialtytable (userid,clinicalid,coursenumber) values ".
			"(0,10,5)","DBFakeUser(insert specialty)");
	DBExec($c, "insert into specialtytable (userid,clinicalid,coursenumber) values ".
			"(0,11,5)","DBFakeUser(insert specialty)");
	DBExec($c, "insert into specialtytable (userid,clinicalid,coursenumber) values ".
			"(0,12,5)","DBFakeUser(insert specialty)");
	DBExec($c, "insert into specialtytable (userid,clinicalid,coursenumber) values ".
			"(0,13,5)","DBFakeUser(insert specialty)");
	DBExec($c, "insert into specialtytable (userid,clinicalid,coursenumber) values ".
			"(0,14,5)","DBFakeUser(insert specialty)");
	DBExec($c, "insert into specialtytable (userid,clinicalid,coursenumber) values ".
			"(0,15,5)","DBFakeUser(insert specialty)");
	DBExec($c, "insert into specialtytable (userid,clinicalid,coursenumber) values ".
			"(0,16,5)","DBFakeUser(insert specialty)");
	DBExec($c, "insert into specialtytable (userid,clinicalid,coursenumber) values ".
			"(0,17,5)","DBFakeUser(insert specialty)");

	DBExec($c, "insert into specialtytable (userid,clinicalid,coursenumber) values ".
			"(1,1,3)","DBFakeUser(insert specialty)");
	DBExec($c, "insert into specialtytable (userid,clinicalid,coursenumber) values ".
			"(2,1,3)","DBFakeUser(insert specialty)");
	DBExec($c, "insert into specialtytable (userid,clinicalid,coursenumber) values ".
			"(3,6,4)","DBFakeUser(insert specialty)");
	DBExec($c, "insert into specialtytable (userid,clinicalid,coursenumber) values ".
			"(4,6,4)","DBFakeUser(insert specialty)");
}
//funcion para registrar todas las respuestas posibles en una competencia
function insertclinical($c){

    DBExec($c, "insert into clinicaltable (clinicalmodule, clinicalspecialty, clinicalcourse) values ".
        "('Admisión','Ficha Clinica Admisión','Tercero')","DBFakeUser(insert prostodoncia clinical)");
		DBExec($c, "insert into clinicaltable (clinicalmodule, clinicalspecialty, clinicalcourse) values ".
        "('PROSTODONCIA','PROSTODONCIA REMOVIBLE II','Cuarto')","DBFakeUser(insert prostodoncia clinical)");
		DBExec($c, "insert into clinicaltable (clinicalmodule, clinicalspecialty, clinicalcourse) values ".
		    "('PROSTODONCIA','PROSTODONCIA FIJA II','Cuarto')","DBFakeUser(insert prostodoncia clinical)");

		DBExec($c, "insert into clinicaltable (clinicalmodule, clinicalspecialty, clinicalcourse) values ".
        "('OPERATORIA','OPERATORIA DENTAL II','Cuarto')","DBFakeUser(insert operatoria clinical)");
		DBExec($c, "insert into clinicaltable (clinicalmodule, clinicalspecialty, clinicalcourse) values ".
		    "('OPERATORIA','ENDODONCIA II','Cuarto')","DBFakeUser(insert operatoria clinical)");

		DBExec($c, "insert into clinicaltable (clinicalmodule, clinicalspecialty, clinicalcourse) values ".
        "('CIRUGIA','CIRUGIA BUCAL II','Cuarto')","DBFakeUser(insert cirugia clinical)");
		DBExec($c, "insert into clinicaltable (clinicalmodule, clinicalspecialty, clinicalcourse) values ".
		    "('CIRUGIA','PERIODONCIA II','Cuarto')","DBFakeUser(insert cirugia clinical)");

		DBExec($c, "insert into clinicaltable (clinicalmodule, clinicalspecialty, clinicalcourse) values ".
        "('ODONTOPEDIATRIA','ODONTOPEDIATRIA I','Cuarto')","DBFakeUser(insert odontopediatria clinical)");
		DBExec($c, "insert into clinicaltable (clinicalmodule, clinicalspecialty, clinicalcourse) values ".
		    "('ODONTOPEDIATRIA','ORTODONCIA I','Cuarto')","DBFakeUser(insert odontopediatria clinical)");


		DBExec($c, "insert into clinicaltable (clinicalmodule, clinicalspecialty, clinicalcourse) values ".
        "('PROSTODONCIA','PROSTODONCIA REMOVIBLE III','Quinto')","DBFakeUser(insert prostodoncia clinical)");
		DBExec($c, "insert into clinicaltable (clinicalmodule, clinicalspecialty, clinicalcourse) values ".
		    "('PROSTODONCIA','PROSTODONCIA FIJA III','Quinto')","DBFakeUser(insert prostodoncia clinical)");

		DBExec($c, "insert into clinicaltable (clinicalmodule, clinicalspecialty, clinicalcourse) values ".
				"('OPERATORIA','OPERATORIA DENTAL III','Quinto')","DBFakeUser(insert operatoria clinical)");
		DBExec($c, "insert into clinicaltable (clinicalmodule, clinicalspecialty, clinicalcourse) values ".
				"('OPERATORIA','ENDODONCIA III','Quinto')","DBFakeUser(insert operatoria clinical)");

		DBExec($c, "insert into clinicaltable (clinicalmodule, clinicalspecialty, clinicalcourse) values ".
				"('CIRUGIA','CIRUGIA BUCAL III','Quinto')","DBFakeUser(insert cirugia clinical)");
		DBExec($c, "insert into clinicaltable (clinicalmodule, clinicalspecialty, clinicalcourse) values ".
				"('CIRUGIA','PERIODONCIA III','Quinto')","DBFakeUser(insert cirugia clinical)");

		DBExec($c, "insert into clinicaltable (clinicalmodule, clinicalspecialty, clinicalcourse) values ".
				"('ODONTOPEDIATRIA','ODONTOPEDIATRIA II','Quinto')","DBFakeUser(insert odontopediatria clinical)");
		DBExec($c, "insert into clinicaltable (clinicalmodule, clinicalspecialty, clinicalcourse) values ".
				"('ODONTOPEDIATRIA','ORTODONCIA II','Quinto')","DBFakeUser(insert odontopediatria clinical)");
}
//funcion para registrar triage
//funcion para registrar pacientes
function DBNewTriage($param, $c=null){

	if(isset($param['triagetemperature']) && !isset($param['temperature'])) $param['temperature']=$param['triagetemperature'];
	if(isset($param['triageheadache']) && !isset($param['headache'])) $param['headache']=$param['triageheadache'];
	if(isset($param['triagerespiratory']) && !isset($param['respiratory'])) $param['respiratory']=$param['triagerespiratory'];
	if(isset($param['triagethroat']) && !isset($param['throat'])) $param['throat']=$param['triagethroat'];
	if(isset($param['triagegeneral']) && !isset($param['general'])) $param['general']=$param['triagegeneral'];
	if(isset($param['triagevaccine']) && !isset($param['vaccine'])) $param['vaccine']=$param['triagevaccine'];

	$ac=array('id');
	//$ac=array('contest','site','user');
	$ac1=array('temperature','headache','respiratory','throat','general','vaccine');
  $temperature = '';
  $headache = 'f';
  $respiratory = 'f';
  $throat = 'f';
  $general = 'f';
  $vaccine = '';
	$updatetime=-1;
	$fullname=$param["patientfullname"];
	foreach($ac1 as $key) {
		if(isset($param[$key])) {
			$$key = myhtmlspecialchars($param[$key]);
		}
	}
	$t = time();

	if($updatetime <= 0)
		$updatetime=$t;

	//id s para registrar id

	$id=$param["patientid"];



	$cw = false;
	if($c == null) {
		$cw = true;
		$c = DBConnect();
		DBExec($c, "begin work", "DBNewPacient(begin)");
	}
	if($param["triageid"]=="")
		$idt=DBTriageNumberMax();
	else
		$idt=$param["triageid"];
	$sql = "select * from triagetable where triageid=$idt";
	$a = DBGetRow ($sql, 0, $c);
	$ret=0;
//insercion actualizacion inicio
//para actualizar....
	if($a==null){
		$ret=2;
		$idt=DBTriageNumberMax();

		$sql = "insert into triagetable (triageid, patientid, triagetemperature, ".
			"triageheadache, triagerespiratory, triagethroat, triagegeneral, triagevaccine) values (".
			"$idt, $id, '$temperature', '$headache', '$respiratory', '$throat', '$general', '$vaccine')";
		DBExec($c, $sql, "DBNewPatientAdmission(insert)");
		if($cw) {
			DBExec ($c, "commit work");
		}
		LOGLevel ("Triage $idt registrado.",2);
	}else{
		//para actualizar o crear un nuevo triage
		if(isset($param["mod"])){
			if($param["mod"]=='new'){
				$ret=2;
				$idt=DBTriageNumberMax();

				$sql = "insert into triagetable (triageid, patientid, triagetemperature, ".
					"triageheadache, triagerespiratory, triagethroat, triagegeneral, triagevaccine) values (".
					"$idt, $id, '$temperature', '$headache', '$respiratory', '$throat', '$general', '$vaccine')";
				DBExec($c, $sql, "DBNewPatientAdmission(insert)");
				if($cw) {
					DBExec ($c, "commit work");
				}
				LOGLevel ("Triage $idt registrado.",2);

			}elseif ($param["mod"]=='update' && $param["triageid"]!="") {
					$ret=2;

					$idt=$param["triageid"];
					$sql = "update triagetable set triagetemperature='$temperature', triageheadache='$headache', triagerespiratory='$respiratory', ".
					"triagethroat='$throat', triagegeneral='$general', triagevaccine='$vaccine' " .
					"where triageid=$idt and patientid=$id";

					$r = DBExec ($c, $sql, "DBNewTriage(update)");
					if($cw) {
						DBExec ($c, "commit work");
					}
					LOGLevel("Triage $idt actualizado.",2);

			}else{
				LOGLevel("MODO DE REGISTRO INVALIDO",2);
				return false;
			}
		}else{
			LOGLevel("NO EXISTE MODO DE REGISTRO",1);
			return false;
		}

	}



	//insercion actualizacion fin
	if($cw) DBExec($c, "commit work");
	return $ret;

}




//funcion para sacar el max number para paciente
function DBPatientNumberMax($c=null){
    $cw=false;
    if($c==null){
        $cw=true;
        $c=DBConnect();
        DBExec($c,"begin work","DBPatientNumberMax(begin)");
    }
    //no retorna un array asociativo el primer resultado
    $a=DBGetRow("select max(patientid) as n from patienttable",0,$c,
        "DBPatientNumberMax(max(n))");
		if($a==null)
			$a["n"]=-1;
		if($cw){
        DBExec($c,"commit work", "DBPatientNumberMax(commit)");
    }
    $n=$a["n"]+1;
    return $n;
}
//funcion para sacar el max number de examen buco dental
function DBDentalExamNumberMax($c=null){
    $cw=false;
    if($c==null){
        $cw=true;
        $c=DBConnect();
        DBExec($c,"begin work","DBDentalExamNumberMax(begin)");
    }
    //no retorna un array asociativo el primer resultado
    $a=DBGetRow("select max(dentalid) as n from dentalexamtable",0,$c,
        "DBDentalExamNumberMax(max(n))");
		if($a==null)
			$a["n"]=-1;
		if($cw){
        DBExec($c,"commit work", "DBDentalExamNumberMax(commit)");
    }
    $n=$a["n"]+1;
    return $n;
}
//funcion para sacar el max number de odontogram dental
function DBOdontogramNumberMax($c=null){
    $cw=false;
    if($c==null){
        $cw=true;
        $c=DBConnect();
        DBExec($c,"begin work","DBOdontogramNumberMax(begin)");
    }
    //no retorna un array asociativo el primer resultado
    $a=DBGetRow("select max(odontogramid) as n from odontogramtable",0,$c,
        "DBOdontogramNumberMax(max(n))");
		if($a==null)
			$a["n"]=-1;
		if($cw){
        DBExec($c,"commit work", "DBOdontogramNumberMax(commit)");
    }
    $n=$a["n"]+1;
    return $n;
}
//funcion para sacar el max number para paciente
function DBPatientAdmissionNumberMax($c=null){
    $cw=false;
    if($c==null){
        $cw=true;
        $c=DBConnect();
        DBExec($c,"begin work","DBPatientAdmissionNumberMax(begin)");
    }
    //no retorna un array asociativo el primer resultado
    $a=DBGetRow("select max(patientadmissionid) as n from patientadmissiontable",0,$c,
        "DBPatientAdmissionNumberMax(max(n))");
		if($a==null)
			$a["n"]=-1;
		if($cw){
        DBExec($c,"commit work", "DBPatientAdmissionNumberMax(commit)");
    }
    $n=$a["n"]+1;
    return $n;
}
//funcion para sacar el maximo numero de triage
function DBTriageNumberMax($c=null){
    $cw=false;
    if($c==null){
        $cw=true;
        $c=DBConnect();
        DBExec($c,"begin work","DBTriageNumberMax(begin)");
    }
    //no retorna un array asociativo el primer resultado
    $a=DBGetRow("select max(triageid) as n from triagetable",0,$c,
        "DBTriageNumberMax(max(n))");
		if($a==null)
			$a["n"]=-1;
		if($cw){
        DBExec($c,"commit work", "DBTriageNumberMax(commit)");
    }
    $n=$a["n"]+1;
    return $n;
}
//funcion para sacar el max number de remission
function DBRemissionNumberMax($c=null){
    $cw=false;
    if($c==null){
        $cw=true;
        $c=DBConnect();
        DBExec($c,"begin work","DBRemissionNumberMax(begin)");
    }
    //no retorna un array asociativo el primer resultado
    $a=DBGetRow("select max(remissionid) as n from remissiontable",0,$c,
        "DBRemissionNumberMax(max(n))");
		if($a==null)
			$a["n"]=-1;
		if($cw){
        DBExec($c,"commit work", "DBRemissionNumberMax(commit)");
    }
    $n=$a["n"]+1;
    return $n;
}


//funcion para sacar la informacion del paciente buscado
//retorna toda la informacion del de la tabla sitetimetable pasando los parametros de contest y sitio
function DBPatientSearchInfo($searchname, $searchfisrtname, $searchlastname, $print=true, $c=null) {
	$sql = "select patientid as id, patientname as name, patientfirstname as firstname, ".
	"patientlastname as lastname from patienttable";
	$sw=false;
	if(trim($searchname)!=null|| trim($searchfisrtname)!=null|| trim($searchlastname)!=null){
			$sql.=" where";
	}
	if(trim($searchname)!=null){
		$sw=true;
		$sql.=" patientname ILIKE '%$searchname%'";
	}
	if(trim($searchfisrtname)!=null){
		if($sw){
			$sql.=" and patientfirstname ILIKE '%$searchfisrtname%'";
		}else{
			$sw=true;
			$sql.=" patientfirstname ILIKE '%$searchfisrtname%'";
		}
	}
	if(trim($searchlastname)!=null){
		if($sw){
			$sql.=" and patientlastname ILIKE '%$searchlastname%'";
		}else{
			$sw=true;
			$sql.=" patientlastname ILIKE '%$searchlastname%'";
		}
	}
	if($sw){
			$sql.=" order by patientid";
	}
	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBPatientSearchInfo(get patients)");
	$n = DBnlines($r);
	if ($n == 0) {
		LOGError("Unable to find Patient in the database. SQL=(" . $sql . ")");
		//MSGError("Unable to find patient in the database!");
		if($print)
			exit;
		else
			return array();
	}
	if($n>9)
		$n=10;
	$a = array();
	for ($i=0;$i<$n;$i++) {
		$a[$i] = DBRow($r,$i);
		$id=$a[$i]["id"];
		$name=ucwords($a[$i]["name"]);
		$firstname=ucwords($a[$i]["firstname"]);
		$lastname=ucwords($a[$i]["lastname"]);
		$prm=DBPatientRemissionMaxInfo($id);
		$id=$prm["patientadmissionid"];
		if($print)
			echo "<a class=\"dropdown-item text-primary\" href=\"newadmission.php?id=$id#patient\">$name $firstname $lastname</a>";
	}

	return $a;
}
/*
select  *from remissiontable as r, patienttable as p
where r.patientid=2 and p.patientid=r.patientid and
r.remissionid=(select max(re.remissionid) from remissiontable as re where re.patientid=2)

*/


function DBPatientRemissionSearchInfo($search, $c=null) {
	$sql = "select patientid as id, patientfullname as fullname from patienttable where patientfullname LIKE '%$search%' order by patientid";
	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBPatientSearchInfo(get patients)");
	$n = DBnlines($r);
	if ($n == 0) {
		LOGError("Unable to find Patient in the database. SQL=(" . $sql . ")");
		//MSGError("Unable to find patient in the database!");

		exit;
	}
	if($n>9)
		$n=10;
	$a = array();
	for ($i=0;$i<$n;$i++) {
		$a[$i] = DBRow($r,$i);
		$id=$a[$i]["id"];
		$fullname=$a[$i]["fullname"];
		echo "<a class=\"dropdown-item text-primary\" href=\"admission.php?id=$id\">$fullname</a>";
	}

	return $a;
}

//ESTADISTICA FICHAS CLINICAS
function DBClinicalStatisticsInfo($start, $end, $clinicals=array(), $userid=null, $usertype=null){
	$tmpsql='';
	if($usertype!=null&&$userid!=null&&is_numeric($userid)){
		if($usertype=='student'){
			$tmpsql=" and studentid=$userid";
		}
	}

	$ar= array(1 => 'admision', 2 => 'removable', 3 => 'fixed', 4 => 'operative', 5 => 'endodontics', 6 => 'surgeryii',
	7 => 'periodonticsii', 8 => 'pediatricsi', 9 => 'orthodontics', 10 => 'removable', 11 => 'fixed',
	12 => 'operative', 13 => 'endodontics', 14 => 'surgeryii', 15 => 'periodonticsii',
	16 => 'pediatricsi', 17 => 'orthodontics');//añador para nuevas fichas clinicasl....

	$a = array('new' => 0, 'process' => 0, 'fail' => 0, 'end' => 0, 'canceled' => 0);
	$c = DBConnect();
	for ($i=0; $i <count($clinicals) ; $i++) {
		if($clinicals[$i]>16||$clinicals[$i]<2){
			continue;
		}
		//$sql="select ".$ar[$clinicals[$i]]."status as status, startdatetime, enddatetime, updatetime ".
		//" from ".$ar[$clinicals[$i]]."table where clinicalid=".$clinicals[$i]."$tmpsql";
		$sql="select status, stdatetime, endatetime, updatetime ".
		" from clinichistorytable where clinicalid=".$clinicals[$i]."$tmpsql";
		$r = DBExec ($c, $sql, "DBClinicalStatisticsInfo(get all ".$ar[$clinicals[$i]]." statistics)");
		$n = DBnlines($r);

		$ab = array();
		for ($j=0;$j<$n;$j++) {
			$ab[$j] = DBRow($r,$j);
			//nuevo
			if($ab[$j]['status']=='new'&& $ab[$j]['updatetime']>=$start&& $ab[$j]['updatetime']<=$end){
					$a['new']++;
			}
			//en proceso
			//echo "#".$ab[$j]['status']."/".$ab[$j]['startdatetime']."/".$ab[$j]['updatetime']."//$start//$end #";
			if($ab[$j]['status']=='process'&&$ab[$j]['stdatetime']>=$start&&$ab[$j]['updatetime']<=$end){
					$a['process']++;
			}
			//finalizado
			if($ab[$j]['status']=='end'&&$ab[$j]['stdatetime']>=$start&&$ab[$j]['endatetime']<=$end){
					$a['end']++;
			}
			//anulado
			if($ab[$j]['status']=='fail'&&$ab[$j]['stdatetime']>=$start&&$ab[$j]['updatetime']<=$end){
					$a['fail']++;
			}
			//abandonado
			if($ab[$j]['status']=='canceled'&&$ab[$j]['stdatetime']>=$start&&$ab[$j]['updatetime']<=$end){
					$a['canceled']++;
			}
		}
	}
	return $a;
}
/*function DBClinicalStatisticsInfo($start, $end, $clinicals=array(), $userid=null, $usertype=null){
	$tmpsql='';
	if($usertype!=null&&$userid!=null&&is_numeric($userid)){
		if($usertype=='student'){
			$tmpsql=" and student=$userid";
		}
	}

	$ar= array(1 => 'removable', 2 => 'fixed', 3 => 'operative', 4 => 'endodontics', 5 => 'surgeryii',
	6 => 'periodonticsii', 7 => 'pediatricsi', 8 => 'orthodontics', 9 => 'removable', 10 => 'fixed',
	11 => 'operative', 12 => 'endodontics', 13 => 'surgeryii', 14 => 'periodonticsii',
	15 => 'pediatricsi', 16 => 'orthodontics');//añador para nuevas fichas clinicasl....

	$a = array('new' => 0, 'process' => 0, 'fail' => 0, 'end' => 0, 'canceled' => 0);
	$c = DBConnect();
	for ($i=0; $i <count($clinicals) ; $i++) {
		if($clinicals[$i]>16||$clinicals[$i]<1){
			continue;
		}
		$sql="select ".$ar[$clinicals[$i]]."status as status, startdatetime, enddatetime, updatetime ".
		" from ".$ar[$clinicals[$i]]."table where clinicalid=".$clinicals[$i]."$tmpsql";

		$r = DBExec ($c, $sql, "DBClinicalStatisticsInfo(get all ".$ar[$clinicals[$i]]." statistics)");
		$n = DBnlines($r);

		$ab = array();
		for ($j=0;$j<$n;$j++) {
			$ab[$j] = DBRow($r,$j);
			//nuevo
			if(($ab[$j]['status']=='new'||$ab[$j]['status']=='process')&&$ab[$j]['startdatetime']==-1&&$ab[$j]['updatetime']>=$start&&$ab[$j]['updatetime']<=$end){
					$a['new']++;
			}
			//en proceso
			//echo "#".$ab[$j]['status']."/".$ab[$j]['startdatetime']."/".$ab[$j]['updatetime']."//$start//$end #";
			if($ab[$j]['status']=='process'&&$ab[$j]['startdatetime']>=$start&&$ab[$j]['updatetime']<=$end){
					$a['process']++;
			}
			//finalizado
			if($ab[$j]['status']=='end'&&$ab[$j]['startdatetime']>=$start&&$ab[$j]['enddatetime']<=$end){
					$a['end']++;
			}
			//anulado
			if($ab[$j]['status']=='fail'&&$ab[$j]['startdatetime']>=$start&&$ab[$j]['updatetime']<=$end){
					$a['fail']++;
			}
			//abandonado
			if($ab[$j]['status']=='canceled'&&$ab[$j]['startdatetime']>=$start&&$ab[$j]['updatetime']<=$end){
					$a['canceled']++;
			}
		}
	}
	return $a;
}*/
//funcion para validar odontograma
function validodontogram($str, $f){
	if(($str==substr($str,0,1)."caries"||$str==substr($str,0,1)."obturado")&&substr($str,0,1)==$f) return true;
	if($str=="necrosispulpar"||$str=="corona"||$str=="exodonciaindicada"||$str=="sellados"||
	$str=="perdidoausente") return true;
	else return false;
}

//funcion para actualizar nombre del paciente
function DBUpdatePatientfullname($patientid, $patientname, $patientfirstname, $patientlastname, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBUpdatePatientfullname(begin)");
		}
		DBExec($c, "lock table patienttable", "DBUpdatePatientfullname(lock)");

		$ret=1;
		$time=time();
		$patientname=ucfirst($patientname);
		$patientfirstname=ucfirst($patientfirstname);
		$patientlastname=ucfirst($patientlastname);
		if(is_numeric($patientid)&& is_numeric($patientid)&& $patientname&& $patientfirstname&& $patientlastname){
				$sql="update patienttable set patientname='$patientname', patientfirstname='$patientfirstname',
				patientlastname='$patientlastname', updatetime=$time where patientid=$patientid";
				DBExec($c, $sql, "DBUpdatePatientfullname(update patienttable)");
				$ret=2;
		}

		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}

?>
