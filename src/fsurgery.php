<?php

//funcion para eliminar la tabla de cirugia
function DBDropSurgeryiiTable() {
    //conexcion de la base de datos..
	 $c = DBConnect();

	 $r = DBExec($c, "drop table \"surgeryiitable\"", "DBDropSurgeryiiTable(drop table)");

}
function DBCreateSurgeryiiTable() {
	 $c = DBConnect();
	 $conf = globalconf();
	 if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
	 $r = DBExec($c, "
CREATE TABLE \"surgeryiitable\" (
				\"remissionid\" int4 NOT NULL,                							-- (id de remision unica)
				\"surgeryiiid\" int4 UNIQUE NOT NULL,                							-- (id de ficha clinica cirugia bucal ii)
				\"surgeryiipractice\" varchar(20) DEFAULT '',								-- (numero de practica cirugia bucal iii)
				\"surgeryiimotconsult\" text DEFAULT '',										-- (historia del motivo de la consulta cirugia bucal iii)
        \"surgeryiipersonalremote\" text DEFAULT '',      					-- (anamnesis remota personal cirugia bucal iii)
        \"surgeryiidentalhistory\" text DEFAULT '',       					-- (historia odontologica cirugia bucal iii)
        \"surgeryiiphysicalexam\" text DEFAULT '',        					-- (examen fisico cirugia bucal iii)
        \"surgeryiiodontogram\" text DEFAULT '',          					-- (odontograma cirugia bucal iii)
        \"surgeryiiasa\" varchar(100) DEFAULT '',         					-- (clasificacion del estado fisico cirugia bucal iii)
        \"surgeryiianxiety\" varchar(100) DEFAULT '',     					-- (nivel de ansiedad cirugia bucal iii)
        \"surgeryiidiagnosishypothesis\" varchar(200) DEFAULT '',  	-- (hipotesisi diagnostica cirugia bucal iii)
        \"surgeryiicomplementaryexam\" text DEFAULT '',          		-- (examenes complementarios cirugia bucal iii)
        \"surgeryiisurgicaldifficulty\" text DEFAULT '',          	-- (grado de dificultad quirurgico cirugia bucal iii)
        \"surgeryiiconsent\" text DEFAULT '',  				-- (consentimiento del paciente cirugia bucal iii)
        \"surgeryiitreatmentplan\" text DEFAULT '',  				-- (plan de tratameinto cirugia bucal iii)
				\"surgeryiidisease\" varchar(300) DEFAULT '',			-- (historia de la enfermedad actual)
				\"surgeryiiexam\" varchar(300) DEFAULT '',        -- (examenenes complentarios)
        \"surgeryiidiagnosis\" varchar(200) DEFAULT '',   -- (diagnostico definitiva)
        \"surgeryiitreatment\" text DEFAULT '',           -- (tratamiento y anestesias)
        \"surgeryiiprescriptions\" text DEFAULT '',       -- (prescripciones)
        \"surgeryiiindications\" text DEFAULT '',     		-- (indicaciones)
        \"surgeryiievolution\" text DEFAULT '',       		-- (tratamiento p.o y evolucion)
        \"surgeryiiforecast\" varchar(200) DEFAULT '',    -- (pronostico)

			  \"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
        CONSTRAINT \"surgeryii_pkey\" PRIMARY KEY (\"remissionid\"),
				CONSTRAINT \"remissionhistory_fk\" FOREIGN KEY (\"remissionid\")
								REFERENCES \"remissionhistorytable\" (\"remissionid\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
)", "DBCreateSurgeryiiTable(create table)");

	$r = DBExec($c, "REVOKE ALL ON \"surgeryiitable\" FROM PUBLIC", "DBCreateSurgeryiiTable(revoke public)");
	$r = DBExec($c, "GRANT ALL ON \"surgeryiitable\" TO \"".$conf["dbuser"]."\"", "DBCreateSurgeryiiTable(grant sihcouser)");
	$r = DBExec($c, "CREATE INDEX \"surgeryii_index\" ON \"surgeryiitable\" USING btree ".
				"(\"surgeryiiid\" int4_ops)",
				"DBCreateSurgeryiiTable(create surgeryii_index)");
	$r = DBExec($c, "CREATE INDEX \"surgeryii_indexremission\" ON \"surgeryiitable\" USING btree ".
				"(\"remissionid\" int4_ops)",
				"DBCreateSurgeryiiTable(create surgeryii_indexremission)");
}

//funcion para registrar o actualizar cirugia bucal II
function DBNewSurgeryii($param , $c=null){

		if(isset($param['remissionid']) && !isset($param['remission'])) $param['remission']=$param['remissionid'];

		if(isset($param['surgeryiipractice']) && !isset($param['practice'])) $param['practice']=$param['surgeryiipractice'];
		if(isset($param['surgeryiimotconsult']) && !isset($param['motconsult'])) $param['motconsult']=$param['surgeryiimotconsult'];
		if(isset($param['surgeryiipersonalremote']) && !isset($param['personalremote'])) $param['personalremote']=$param['surgeryiipersonalremote'];
		if(isset($param['surgeryiidentalhistory']) && !isset($param['dentalhistory'])) $param['dentalhistory']=$param['surgeryiidentalhistory'];
		if(isset($param['surgeryiiphysicalexam']) && !isset($param['physicalexam'])) $param['physicalexam']=$param['surgeryiiphysicalexam'];
		if(isset($param['surgeryiiodontogram']) && !isset($param['odontogram'])) $param['odontogram']=$param['surgeryiiodontogram'];
		if(isset($param['surgeryiiasa']) && !isset($param['asa'])) $param['asa']=$param['surgeryiiasa'];
		if(isset($param['surgeryiianxiety']) && !isset($param['anxiety'])) $param['anxiety']=$param['surgeryiianxiety'];
		if(isset($param['surgeryiidiagnosishypothesis']) && !isset($param['diagnosishypothesis'])) $param['diagnosishypothesis']=$param['surgeryiidiagnosishypothesis'];
		if(isset($param['surgeryiicomplementaryexam']) && !isset($param['complementaryexam'])) $param['complementaryexam']=$param['surgeryiicomplementaryexam'];
		if(isset($param['surgeryiisurgicaldifficulty']) && !isset($param['surgicaldifficulty'])) $param['surgicaldifficulty']=$param['surgeryiisurgicaldifficulty'];
		if(isset($param['surgeryiiconsent']) && !isset($param['consent'])) $param['consent']=$param['surgeryiiconsent'];
		if(isset($param['surgeryiitreatmentplan']) && !isset($param['treatmentplan'])) $param['treatmentplan']=$param['surgeryiitreatmentplan'];

		if(isset($param['surgeryiidisease']) && !isset($param['disease'])) $param['disease']=$param['surgeryiidisease'];
		if(isset($param['surgeryiiexam']) && !isset($param['exam'])) $param['exam']=$param['surgeryiiexam'];
		if(isset($param['surgeryiidiagnosis']) && !isset($param['diagnosis'])) $param['diagnosis']=$param['surgeryiidiagnosis'];
		if(isset($param['surgeryiitreatment']) && !isset($param['treatment'])) $param['treatment']=$param['surgeryiitreatment'];
		if(isset($param['surgeryiiprescriptions']) && !isset($param['prescriptions'])) $param['prescriptions']=$param['surgeryiiprescriptions'];
		if(isset($param['surgeryiiindications']) && !isset($param['indications'])) $param['indications']=$param['surgeryiiindications'];
		if(isset($param['surgeryiievolution']) && !isset($param['evolution'])) $param['evolution']=$param['surgeryiievolution'];
		if(isset($param['surgeryiiforecast']) && !isset($param['forecast'])) $param['forecast']=$param['surgeryiiforecast'];

		$ac=array('remission');
		$ac1=array('clinicalid', 'practice',	'motconsult',	'personalremote',	'dentalhistory',
		'physicalexam',	'odontogram',	'asa',	'anxiety',	'diagnosishypothesis',
		'complementaryexam',	'surgicaldifficulty',	'consent',	'treatmentplan',
		'disease', 'exam', 'diagnosis', 'treatment', 'prescriptions', 'indications',
		'evolution', 'forecast', 'updatetime');

		$typei['remission']=-1;
		$typei['clinicalid']=-1;
		$typei['updatetime']=-1;

		foreach($ac as $key) {
			if(!isset($param[$key]) || $param[$key]=="") {
				MSGError("DBNewSurgeryii param error: $key not found");
				return false;
			}
			if(isset($typei[$key]) && !is_numeric($param[$key])) {
				MSGError("DBNewSurgeryii param error: $key is not numeric");
				return false;
			}
			$$key = myhtmlspecialchars($param[$key]);
		}

		$practice='';
		$motconsult='';
		$personalremote='';
		$dentalhistory='';
		$physicalexam='';
		$odontogram='';
		$asa='';
		$anxiety='';
		$diagnosishypothesis='';
		$complementaryexam='';
		$surgicaldifficulty='';
		$consent='';
		$treatmentplan='';

		$disease= '';
		$exam= '';
		$diagnosis= '';
		$treatment= '';
		$prescriptions= '';
		$indications= '';
		$evolution= '';
		$forecast= '';

		$clinicalid=-1;
		$updatetime=-1;
		foreach($ac1 as $key) {
			if(isset($param[$key])) {
				$$key = myhtmlspecialchars($param[$key]);
				if(isset($typei[$key]) && !is_numeric($param[$key])) {
					MSGError("DBNewSurgeryii param error: $key is not numeric");
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
			DBExec($c, "begin work", "DBNewSurgeryii(begin)");
		}
		DBExec($c, "lock table surgeryiitable", "DBNewSurgeryii(lock)");

		$ret=1;

		//antes de registrar chekear las claves foraneas
		$sql = "select * from surgeryiitable where remissionid= $remission";
		$a = DBGetRow ($sql, 0, $c);

	  //para insercion o actulizacion
		if ($a == null) {
				  $ret=2;
					$surgery=DBSurgeryiiNumberMax();
	    		$sql = "insert into surgeryiitable(remissionid, surgeryiiid, surgeryiipractice,	surgeryiimotconsult, surgeryiipersonalremote, ".
					"surgeryiidentalhistory, surgeryiiphysicalexam,	surgeryiiodontogram, surgeryiiasa, surgeryiianxiety, ".
					"surgeryiidiagnosishypothesis, surgeryiicomplementaryexam, surgeryiisurgicaldifficulty, ".
					"surgeryiiconsent, surgeryiitreatmentplan, surgeryiidisease, surgeryiiexam, surgeryiidiagnosis, ".
					"surgeryiitreatment, surgeryiiprescriptions, surgeryiiindications, surgeryiievolution, surgeryiiforecast, ".
					"updatetime) values ".
	    		"($remission, $surgery, '$practice',	'$motconsult',	'$personalremote',	'$dentalhistory',	'$physicalexam', ".
					"'$odontogram',	'$asa',	'$anxiety',	'$diagnosishypothesis',	'$complementaryexam',	".
					"'$surgicaldifficulty',	'$consent',	'$treatmentplan', '$disease', '$exam', '$diagnosis', ".
					"'$treatment', '$prescriptions', '$indications', '$evolution', '$forecast', " .
					"$updatetime)";

					DBExec ($c, $sql, "DBNewSurgeryii(insert)");
	    		if($cw) {
	    				DBExec ($c, "commit work");
	    		}
	    		LOGLevel ("Ficha Cirugia II $remission registrado.",2);
		} else {
				if($updatetime > $a['updatetime']) {
					$ret=2;
					$sql="update surgeryiitable set ";

					if($clinicalid == 14){
						if($practice!='') $sql.="surgeryiipractice='$practice', ";
						if($motconsult!='') $sql.="surgeryiimotconsult='$motconsult', ";
						if($personalremote!='') $sql.="surgeryiipersonalremote='$personalremote', ";
						if($dentalhistory!='') $sql.="surgeryiidentalhistory='$dentalhistory', ";
						if($physicalexam!='') $sql.="surgeryiiphysicalexam='$physicalexam', ";
						if($odontogram!='') $sql.="surgeryiiodontogram='$odontogram', ";
						if($asa!='') $sql.="surgeryiiasa='$asa', ";
						if($anxiety!='') $sql.="surgeryiianxiety='$anxiety', ";
						if($diagnosishypothesis!='') $sql.="surgeryiidiagnosishypothesis='$diagnosishypothesis', ";
						if($complementaryexam!='') $sql.="surgeryiicomplementaryexam='$complementaryexam', ";
						if($surgicaldifficulty!='') $sql.="surgeryiisurgicaldifficulty='$surgicaldifficulty', ";
						if($treatmentplan!='') $sql.="surgeryiitreatmentplan='$treatmentplan', ";
						if($diagnosis!='') $sql.="surgeryiidiagnosis='$diagnosis', ";

					}else{
						if($disease!='') $sql.="surgeryiidisease='$disease', ";
						if($exam!='') $sql.="surgeryiiexam='$exam', ";
						if($diagnosis!='') $sql.="surgeryiidiagnosis='$diagnosis', ";
						if($treatment!='') $sql.="surgeryiitreatment='$treatment', ";
						if($prescriptions!='') $sql.="surgeryiiprescriptions='$prescriptions', ";
						if($indications!='') $sql.="surgeryiiindications='$indications', ";
						if($evolution!='') $sql.="surgeryiievolution='$evolution', ";
						if($forecast!='') $sql.="surgeryiiforecast='$forecast', ";
					}


					$sql.="updatetime=$updatetime where remissionid=$remission";

					$r = DBExec ($c, $sql, "DBNewSurgeryii(update)");
					if($cw) {
						DBExec ($c, "commit work");
					}
					LOGLevel("Ficha Cirugia Bucal II $remission actualizado.",2);
				}
		}

		if($cw) DBExec($c, "commit work");
		return $ret;
}
function DBSurgeryiiNumberMax($c=null){
    $cw=false;
    if($c==null){
        $cw=true;
        $c=DBConnect();
        DBExec($c,"begin work","DBUserNumberMax(begin)");
    }
    //no retorna un array asociativo el primer resultado
    $a=DBGetRow("select max(surgeryiiid) as n from surgeryiitable",0,$c,
        "DBSurgeryiiNumberMax(max(n))");
		if($a==null)
			$a["n"]=-1;
		if($cw){
        DBExec($c,"commit work", "DBSurgeryiiNumberMax(commit)");
    }
    $n=$a["n"]+1;
    return $n;
}
//para sacar la informacion de sirugia bucal ii

//funcion para eliminar la tabla de ficha de cirugia
function DBDropSurgeryTokenTable() {
    //conexcion de la base de datos..
	 $c = DBConnect();
	 $r = DBExec($c, "drop table \"surgerytokentable\"", "DBDropSurgeryTokenTable(drop table)");

}
function DBCreateSurgeryTokenTable() {
	 $c = DBConnect();
	 $conf = globalconf();
	 if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
	 $r = DBExec($c, "
CREATE TABLE \"surgerytokentable\" (
				\"tokenid\" serial NOT NULL,               	   -- (id de token)
				\"tokenarea\" varchar(100) DEFAULT '',				 -- (zona a intervenir)
				\"tokendiagnosis\" varchar(300) DEFAULT '',         -- (diagnostico quirurgico)
        \"tokenpremedication\" varchar(100) DEFAULT '',    -- (premedicacion)
        \"tokendose\" varchar(100) DEFAULT '',     -- (dosis)
        \"tokendate\" varchar(100) DEFAULT '',     -- (fecha)
        \"tokenhourstart\" varchar(100) DEFAULT '',     -- (hora inicio)
        \"tokenhourend\" varchar(100) DEFAULT '',     -- (hora final)
        \"tokensurgeon\" varchar(100) DEFAULT '',		-- (cirujano)
        \"tokenattendee\" varchar(100) DEFAULT '',		-- (asistente/instrumentista)
        \"tokenanesthetic\" varchar(100) DEFAULT '',		-- (medicamento anestesico)
        \"tokentechnique\" varchar(100) DEFAULT '',		-- (tecnica)
        \"tokenauthorization\" varchar(100) DEFAULT '',		-- (firma de autorizacion)
        \"tokentracing\" varchar(100) DEFAULT '',		-- (firma de seguimiento)
        \"tokenending\" varchar(100) DEFAULT '',		-- (firma de finalizacion)
        \"tokenobsintra\" varchar(300) DEFAULT '',     	     -- (observaciones intraoperatorio)
        \"tokensensitivity\" varchar(300) DEFAULT '',     	     -- (sensibilidad)
        \"tokenedema\" varchar(300) DEFAULT '',     	     -- (edema)
        \"tokenbuccalmucosa\" varchar(50) DEFAULT '',     	     -- (mucosa bucal)
				\"tokenobspost\" varchar(300) DEFAULT '',     	     -- (observaciones postoperatorio)

				\"remissionid\" int4 NOT NULL,                        -- (id de ficha)
			  \"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
        CONSTRAINT \"token_pkey\" PRIMARY KEY (\"tokenid\"),
				CONSTRAINT \"surgeryii_fk\" FOREIGN KEY ( \"remissionid\")
								REFERENCES \"surgeryiitable\" (\"remissionid\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
)", "DBCreateSurgeryTokenTable(create table)");

	$r = DBExec($c, "REVOKE ALL ON \"surgerytokentable\" FROM PUBLIC", "DBCreateSurgeryTokenTable(revoke public)");
	$r = DBExec($c, "GRANT ALL ON \"surgerytokentable\" TO \"".$conf["dbuser"]."\"", "DBCreateSurgeryTokenTable(grant sihcouser)");
	$r = DBExec($c, "CREATE INDEX \"surgerytoken_index\" ON \"surgerytokentable\" USING btree ".
				"(\"tokenid\" int4_ops)", "DBCreateSurgeryTokenTable(create surgerytoken_index)");
	$r = DBExec($c, "CREATE INDEX \"surgerytoken_indexremission\" ON \"surgerytokentable\" USING btree ".
				"(\"remissionid\" int4_ops)", "DBCreateSurgeryTokenTable(create surgerytoken_index)");
}
//control de datos
function DBNewSurgeryToken($param , $c=null){

		if(isset($param['remissionid']) && !isset($param['remission'])) $param['remission']=$param['remissionid'];
		if(isset($param['studentid']) && !isset($param['student'])) $param['student']=$param['studentid'];
		if(isset($param['teacherid']) && !isset($param['teacher'])) $param['teacher']=$param['teacherid'];

		if(isset($param['tokenid']) && !isset($param['id'])) $param['id']=$param['tokenid'];
		if(isset($param['tokenarea']) && !isset($param['area'])) $param['area']=$param['tokenarea'];
		if(isset($param['tokendiagnosis']) && !isset($param['diagnosis'])) $param['diagnosis']=$param['tokendiagnosis'];
		if(isset($param['tokenpremedication']) && !isset($param['premedication'])) $param['premedication']=$param['tokenpremedication'];
		if(isset($param['tokendose']) && !isset($param['dose'])) $param['dose']=$param['tokendose'];
		if(isset($param['tokendate']) && !isset($param['date'])) $param['date']=$param['tokendate'];
		if(isset($param['tokenhourstart']) && !isset($param['hourstart'])) $param['hourstart']=$param['tokenhourstart'];
		if(isset($param['tokenhourend']) && !isset($param['hourend'])) $param['hourend']=$param['tokenhourend'];
		if(isset($param['tokenattendee']) && !isset($param['attendee'])) $param['attendee']=$param['tokenattendee'];
		if(isset($param['tokenanesthetic']) && !isset($param['anesthetic'])) $param['anesthetic']=$param['tokenanesthetic'];
		if(isset($param['tokentechnique']) && !isset($param['technique'])) $param['technique']=$param['tokentechnique'];
		if(isset($param['tokenauthorization']) && !isset($param['authorization'])) $param['authorization']=$param['tokenauthorization'];
		if(isset($param['tokentracing']) && !isset($param['tracing'])) $param['tracing']=$param['tokentracing'];
		if(isset($param['tokenending']) && !isset($param['ending'])) $param['ending']=$param['tokenending'];
		if(isset($param['tokenobsintra']) && !isset($param['obsintra'])) $param['obsintra']=$param['tokenobsintra'];
		if(isset($param['tokensensitivity']) && !isset($param['sensitivity'])) $param['sensitivity']=$param['tokensensitivity'];
		if(isset($param['tokenedema']) && !isset($param['edema'])) $param['edema']=$param['tokenedema'];
		if(isset($param['tokenbuccalmucosa']) && !isset($param['buccalmucosa'])) $param['buccalmucosa']=$param['tokenbuccalmucosa'];
		if(isset($param['tokenobspost']) && !isset($param['obspost'])) $param['obspost']=$param['tokenobspost'];

		$ac=array('remission', 'id');
		$ac1=array('area', 'diagnosis', 'premedication', 'dose', 'date', 'hourstart',
		'hourend', 'attendee', 'anesthetic', 'technique', 'authorization', 'tracing',
		'ending', 'obsintra', 'sensitivity', 'edema', 'buccalmucosa', 'obspost');
		$typei['remission']=-1;
		$typei['id']=-1;


		foreach($ac as $key) {
			if(!isset($param[$key]) || $param[$key]=="") {
				MSGError("DBNewSurgeryToken param error: $key not found");
				return false;
			}
			if(isset($typei[$key]) && !is_numeric($param[$key])) {
				MSGError("DBNewSurgeryToken param error: $key is not numeric");
				return false;
			}
			$$key = myhtmlspecialchars($param[$key]);
		}
		$area='';
		$diagnosis='';
		$premedication='';
		$dose='';
		$date='';
		$hourstart='';
		$hourend='';
		$attendee='';
		$anesthetic='';
		$technique='';
		$authorization='';
		$tracing='';
		$ending='';
		$obsintra='';
		$sensitivity='';
		$edema='';
		$buccalmucosa='';
		$obspost='';

		$updatetime=-1;
		foreach($ac1 as $key) {
			if(isset($param[$key])) {
				$$key = myhtmlspecialchars($param[$key]);
				if(isset($typei[$key]) && !is_numeric($param[$key])) {
					MSGError("DBNewSurgeryToken param error: $key is not numeric");
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
			DBExec($c, "begin work", "DBNewSurgeryToken(begin)");
		}
		DBExec($c, "lock table surgerytokentable", "DBNewSurgeryToken(lock)");

		$ret=1;

		//antes de registrar chekear las claves foraneas
		$sql = "select * from surgerytokentable where tokenid=$id and remissionid= $remission";
		$a = DBGetRow ($sql, 0, $c);

	    //para insercion o actulizacion
			if ($a == null) {
				  $ret=2;

	    		$sql = "insert into surgerytokentable(tokenarea, tokendiagnosis, tokenpremedication, ".
					"tokendose, tokendate, tokenhourstart, tokenhourend, tokenattendee, tokenanesthetic, ".
					"tokentechnique, tokenauthorization, tokentracing, tokenending, tokenobsintra, tokensensitivity, ".
					"tokenedema, tokenbuccalmucosa, tokenobspost, ".
					"remissionid) values ".
					"('$area', '$diagnosis', '$premedication', '$dose', '$date', '$hourstart', ".
					"'$hourend', '$attendee', '$anesthetic', '$technique', '$authorization', '$tracing', ".
					"'$ending', '$obsintra', '$sensitivity', '$edema', '$buccalmucosa', '$obspost', ".
					"$remission) returning tokenid";

					$ret=DBExec ($c, $sql, "DBNewSurgeryToken(insert)");
	    		if($cw) {
	    				DBExec ($c, "commit work");
	    		}
	    		LOGLevel ("Ficha Surgery Token $remission registrado.",2);
			} else {
				if($updatetime > $a['updatetime']) {
					$ret=$id;//returna el id de tokenid
					$sql = "update surgerytokentable set tokenarea='$area',tokendiagnosis='$diagnosis',".
					"tokenpremedication='$premedication',tokendose='$dose',tokendate='$date',".
					"tokenhourstart='$hourstart',tokenhourend='$hourend',tokenattendee='$attendee',".
					"tokenanesthetic='$anesthetic',tokentechnique='$technique',tokenauthorization='$authorization',".
					"tokentracing='$tracing',tokenending='$ending',tokenobsintra='$obsintra',tokensensitivity='$sensitivity',".
					"tokenedema='$edema',tokenbuccalmucosa='$buccalmucosa',tokenobspost='$obspost',updatetime=$updatetime ".
					"where tokenid=$id and remissionid=$remission";

					$r = DBExec ($c, $sql, "DBNewSurgeryToken(update)");
					if($cw) {
						DBExec ($c, "commit work");
					}
					LOGLevel("Ficha Surgery Token $id actualizado.",2);
				}
			}

		if($cw) DBExec($c, "commit work");
		return $ret;
}
function DBSurgeryTokenInfo($id, $c=null) {

	$sql = "select tokenid as token, tokenarea as area, tokendiagnosis as diagnosis, ".
	"tokenpremedication as premedicacion, tokendose as dose, tokendate date, tokenhourstart hourstart, ".
	"tokenhourend as hourend, tokenattendee as attendee, tokenanesthetic as anesthetic, ".
	"tokentechnique as technique, tokenauthorization as authorization, ".
	"tokentracing as tracing, tokenending as ending, tokenobsintra as obsintra, ".
	"tokensensitivity as sensitivity, tokenedema as edema, tokenbuccalmucosa as buccalmucosa, ".
	"tokenobspost as obspost, remissionid from surgerytokentable where tokenid=$id";

	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");
		//MSGError("Unable to find the user in the database. Contact an admin now!");
		return null;
	}
	$a=clearsurgerytoken($a);
	return $a;
}
//funcion para liminar algunos campos
function clearsurgerytoken($a){

	if(isset($a['area'])&&$a['area']!=null){
		$r=explode(']',$a['area']);
		$size=count($r);
		$akey = array('preoperatorio1','preoperatorio2','preoperatorio3','preoperatorio4');
		for ($i=0; $i <$size-1 ; $i++) {
			$r2=explode('[',$r[$i]);
			$a[$akey[$i]]=filter_var(trim($r2[1]), FILTER_VALIDATE_BOOLEAN);
		}
	}
	if(isset($a['tokenarea'])&&$a['tokenarea']!=null){
		$r=explode(']',$a['tokenarea']);
		$size=count($r);
		$akey = array('preoperatorio1','preoperatorio2','preoperatorio3','preoperatorio4');
		for ($i=0; $i <$size-1 ; $i++) {
			$r2=explode('[',$r[$i]);
			$a[$akey[$i]]=filter_var(trim($r2[1]), FILTER_VALIDATE_BOOLEAN);
		}
	}
	if(isset($a['premedicacion'])&&$a['premedicacion']!=null){
		$r=explode(']',$a['premedicacion']);
		$size=count($r);
		$akey = array('premedication1','premedication2','premedication3','premedication4');
		for ($i=0; $i <$size-1 ; $i++) {
			$r2=explode('[',$r[$i]);
			$a[$akey[$i]]=filter_var(trim($r2[1]), FILTER_VALIDATE_BOOLEAN);
		}
	}
	if(isset($a['tokenpremedication'])&&$a['tokenpremedication']!=null){
		$r=explode(']',$a['tokenpremedication']);
		$size=count($r);
		$akey = array('premedication1','premedication2','premedication3','premedication4');
		for ($i=0; $i <$size-1 ; $i++) {
			$r2=explode('[',$r[$i]);
			$a[$akey[$i]]=filter_var(trim($r2[1]), FILTER_VALIDATE_BOOLEAN);
		}
	}
	if(isset($a['sensitivity'])&&$a['sensitivity']!=null){
		$r=explode(']',$a['sensitivity']);
		$size=count($r);
		$akey = array('sensibilidad1','sensibilidad2','sensibilidad3','sensibilidad4');
		for ($i=0; $i <$size-1 ; $i++) {
			$r2=explode('[',$r[$i]);
			$a[$akey[$i]]=filter_var(trim($r2[1]), FILTER_VALIDATE_BOOLEAN);
		}
	}
	if(isset($a['tokensensitivity'])&&$a['tokensensitivity']!=null){
		$r=explode(']',$a['tokensensitivity']);
		$size=count($r);
		$akey = array('sensibilidad1','sensibilidad2','sensibilidad3','sensibilidad4');
		for ($i=0; $i <$size-1 ; $i++) {
			$r2=explode('[',$r[$i]);
			$a[$akey[$i]]=filter_var(trim($r2[1]), FILTER_VALIDATE_BOOLEAN);
		}
	}
	if(isset($a['edema'])&&$a['edema']!=null){
		$r=explode(']',$a['edema']);
		$size=count($r);
		$akey = array('edema1','edema2','edema3','edema4');
		for ($i=0; $i <$size-1 ; $i++) {
			$r2=explode('[',$r[$i]);
			$a[$akey[$i]]=filter_var(trim($r2[1]), FILTER_VALIDATE_BOOLEAN);
		}
	}
	if(isset($a['tokenedema'])&&$a['tokenedema']!=null){
		$r=explode(']',$a['tokenedema']);
		$size=count($r);
		$akey = array('edema1','edema2','edema3','edema4');
		for ($i=0; $i <$size-1 ; $i++) {
			$r2=explode('[',$r[$i]);
			$a[$akey[$i]]=filter_var(trim($r2[1]), FILTER_VALIDATE_BOOLEAN);
		}
	}
	if(isset($a['buccalmucosa'])&&$a['buccalmucosa']!=null){
		$r=explode(']',$a['buccalmucosa']);
		$size=count($r);
		$akey = array('buccalmucosa1','buccalmucosa2');
		for ($i=0; $i <$size-1 ; $i++) {
			$r2=explode('[',$r[$i]);
			$a[$akey[$i]]=filter_var(trim($r2[1]), FILTER_VALIDATE_BOOLEAN);
		}
	}
	if(isset($a['tokenbuccalmucosa'])&&$a['tokenbuccalmucosa']!=null){
		$r=explode(']',$a['tokenbuccalmucosa']);
		$size=count($r);
		$akey = array('buccalmucosa1','buccalmucosa2');
		for ($i=0; $i <$size-1 ; $i++) {
			$r2=explode('[',$r[$i]);
			$a[$akey[$i]]=filter_var(trim($r2[1]), FILTER_VALIDATE_BOOLEAN);
		}
	}
	return $a;
}
function DBAllSurgeryTokenInfo($file=-1, $tbody=false){
	$sql = "select *from surgerytokentable";

	if($file!=-1){
		$sql.=" where remissionid=$file";
	}
	$sql.=" order by updatetime desc";
	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBAllSurgeryTokenInfo(get all surgerytoken of file $file)");
	$n = DBnlines($r);

	$a = array();
	for ($i=0;$i<$n;$i++) {
		$a[$i] = DBRow($r,$i);
		$a[$i]=clearsurgerytoken($a[$i]);
	}
	if($tbody==true){
		$tbody='';
		/*'<i style="color:red;" class="fa fa-times fa-2x"></i>'.*/
	  for ($i=0; $i < count($a); $i++) {
				$intervenir='';
				if($a[$i]['tokenarea']!=null){
					$r=explode(']',$a[$i]['tokenarea']);
					$size2=count($r);
					$akey = array('maxiliar anterior', 'maxiliar posterior', 'mandíbula anterior', 'mandíbula posterior');
					for ($j=0; $j <$size2-1; $j++) {
						$r2=explode('[',$r[$j]);
						$val=trim($r2[1]);
						if($val=='true'){
							$intervenir.=$akey[$j].' ';
						}
					}
				}
				$tbody.='<tr>'.
	        '<td>'.$intervenir.'</td>'.
	        '<td>'.$a[$i]['tokendiagnosis'].'</td>'.
	        '<td>'.$a[$i]['tokendate'].'</td>'.
	        '<td><div class="btn-group">'.
					'<button class="btn btn-sm btn-primary" onclick="tdataupdate('.$a[$i]['tokenid'].')" type="button" name="trbutton">'.
					'<i class="fa fa-align-justify" aria-hidden="true"></i>'.
					'</button>'.
					'<button class="btn btn-sm btn-danger" onclick="tdatadelete('.$a[$i]['tokenid'].')" type="button" name="trbutton">'.
					'<i class="fa fa-trash" aria-hidden="true"></i>'.
					'</button>'.
					'</div></td>'.
	      '</tr>\n';
	  }
		return $tbody;
	}else{
		return $a;
	}

}
//funcion para eliminar un registrio de surgerytoken
function DBDeleteSurgeryToken($id){

	$c = DBConnect();
	DBExec($c, "begin work");
	DBExec($c, "lock table surgerytokentable");
	$sql = "select * from surgerytokentable where tokenid=$id for update";
	$a = DBGetRow ($sql, 0, $c);
	if ($a != null) {
			//echo "yes delete";
      $sql = "delete from surgerytokentable where tokenid=$id";
			DBExec ($c, $sql);
			DBExec($c, "commit work");//para el commit de exito
			return true;
	} else {
		DBExec($c, "rollback work");
		LOGLevel("token id = $id could not be removed.", 1);
		return false;
	}
}
//funcion para firma del paciente
function DBUpdateSurgeryiiFirm($param, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBUpdateSurgeryiiFirm(begin)");
		}
		DBExec($c, "lock table surgeryiitable", "DBUpdateSurgeryiiFirm(lock)");

		$ret=2;
		$time=time();
		if(isset($param['file']) && is_numeric($param['file'])&& isset($param['firm'])){
				$sql="update surgeryiitable set surgeryiiconsent='".$param['firm']."' where surgeryiiid=".$param['file'];
				DBExec($c, $sql, "DBUpdateSurgeryiiFirm(update surgeryiitable)");
		}
		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}
function DBUpdateRemissionPatientSurgeryii($param, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBUpdateRemissionPatientSurgeryii(begin)");
		}
		DBExec($c, "lock table patientadmissiontable", "DBUpdateRemissionPatientSurgeryii(lock)");
		$ret=0;
		$sql="update patientadmissiontable set ";
		if($param['faces']!='') $sql.="dentalfaces='".$param['faces']."', ";
		if($param['profile']!='') $sql.="dentalprofile='".$param['profile']."', ";
		if($param['scars']!='') $sql.="dentalscars='".$param['scars']."', ";
		if($param['atm']!='') $sql.="dentalatm='".$param['atm']."', ";
		if($param['ganglia']!='') $sql.="dentalganglia='".$param['ganglia']."', ";
		if($param['lips']!='') $sql.="dentallips='".$param['lips']."', ";
		if($param['ulcerations']!='') $sql.="dentalulcerations='".$param['ulcerations']."', ";
		if($param['cheilitis']!='') $sql.="dentalcheilitis='".$param['cheilitis']."', ";
		if($param['commissures']!='') $sql.="dentalcommissures='".$param['commissures']."', ";
		if($param['tongue']!='') $sql.="dentaltongue='".$param['tongue']."', ";
		if($param['piso']!='') $sql.="dentalpiso='".$param['piso']."', ";
		if($param['encias']!='') $sql.="dentalencias='".$param['encias']."', ";
		if($param['mucosa']!='') $sql.="dentalmucosa='".$param['mucosa']."', ";
		if($param['occlusion']!='') $sql.="dentaltypeo='".$param['occlusion']."', ";
		if($param['prosthesis']!='') $sql.="dentaltypep='".$param['prosthesis']."', ";
		if($param['hygiene']!='') $sql.="dentalhygiene='".$param['hygiene']."', ";
		if($param['lastconsultation']!='') $sql.="lastconsult='".$param['lastconsultation']."', ";
		if($param['consultation']!='') $sql.="motconsult='".$param['consultation']."', ";
		if($param['generalstatus']!='') $sql.="generalstatus='".$param['generalstatus']."', ";

		if($param['tr']!='') $sql.="tr='".$param['tr']."', ";
		if($param['tl']!='') $sql.="tl='".$param['tl']."', ";
		if($param['tlr']!='') $sql.="tlr='".$param['tlr']."', ";
		if($param['tll']!='') $sql.="tll='".$param['tll']."', ";
		if($param['bl']!='') $sql.="bl='".$param['bl']."', ";
		if($param['br']!='') $sql.="br='".$param['br']."', ";
		if($param['bll']!='') $sql.="bll='".$param['bll']."', ";
		if($param['blr']!='') $sql.="blr='".$param['blr']."', ";
		if($param['odontogramdesc']!='') $sql.="description='".$param['odontogramdesc']."', ";

		if(isset($param['odontodraw'])&& $param['odontodraw']!='' && is_numeric($param['idpa'])){
					$ret=2;
					$sql.="draw='".$param['odontodraw']."' where patientadmissionid=".$param['idpa'];
					DBExec($c, $sql, "DBUpdateRemissionPatientSurgeryii(update patientadmissiontable)");
		}

		if($cw) DBExec ($c, "commit work");

		return $ret;
}
//funcion para eliminar la tabla de periodoncia
function DBDropPeriodonticsiiTable() {
    //conexcion de la base de datos..
	 $c = DBConnect();

	 $r = DBExec($c, "drop table \"periodonticsiitable\"", "DBDropPeriodonticsiiTable(drop table)");

}
function DBCreatePeriodonticsiiTable() {
	 $c = DBConnect();
	 $conf = globalconf();
	 if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
	 $r = DBExec($c, "
CREATE TABLE \"periodonticsiitable\" (
				\"periodonticsiiid\" serial NOT NULL,                	-- (id de ficha clinica periodoncia ii)
				\"periodonticsiirotation\" varchar(100) DEFAULT '',			-- (rotacion periodoncia iii)
				\"periodonticsiipoll\" text DEFAULT '',			-- (encuesta cerrada periodoncia iii)
				\"periodonticsiimotconsult\" varchar(300) DEFAULT '',			-- (motivo de consulta periodoncia iii)
				\"periodonticsiigram\" text DEFAULT '',			-- (periodontograma)
				\"periodonticsiiexam\" varchar(300) DEFAULT '',        -- (examen de periodontograma)
        \"periodonticsiidiagnosis\" varchar(300) DEFAULT '',   -- (diagnostico de periodoncia)
        \"periodonticsiitreatment\" text DEFAULT '',           -- (tipo de tratamiento: profilaxis - tartrectomia)
        \"periodonticsiiprophylaxis\" text DEFAULT '',       	-- (profilaxis)
        \"periodonticsiitartarectomy\" text DEFAULT '',     		-- (tartrectomia)
        \"periodonticsiioleary\" text DEFAULT '',    -- (indice de oleary)
				\"periodonticsiimedicine\" varchar(300) DEFAULT '',       -- (medicamento prescrito periodoncia III)
				\"periodonticsiibrushed\" varchar(300) DEFAULT '',       -- (instruccion texnica de cepillado)
				\"periodonticsiicomment\" varchar(300) DEFAULT '',       -- (comentario)
				\"periodonticsiistatus\" varchar(50) DEFAULT '',       -- (estado new, process, end, fail)

				\"patientid\" int4 NOT NULL,      								-- (id del paciente)
				\"student\" int4 NOT NULL,                        -- (id del estudiate)
				\"remissionid\" int4 NOT NULL,                    -- (id de la remission)
				\"teacher\" int4 NOT NULL,                        -- (id del docente)
				\"clinicalid\" int4 NOT NULL,
			  \"startdatetime\" int4 DEFAULT -1 NOT NULL, -- (indica la fecha de inicio de ficha clinica)
			  \"enddatetime\" int4 DEFAULT -1 NOT NULL, -- (indica la fecha de finalizacion)
			  \"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
        CONSTRAINT \"periodii_pkey\" PRIMARY KEY (\"periodonticsiiid\", \"student\", \"teacher\"),
				CONSTRAINT \"remission_fk\" FOREIGN KEY (\"patientid\", \"student\", \"remissionid\", \"clinicalid\")
								REFERENCES \"remissiontable\" (\"patientid\", \"examined\", \"remissionid\", \"clinicalid\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
				CONSTRAINT \"specialty_fk\" FOREIGN KEY (\"teacher\", \"clinicalid\")
								REFERENCES \"specialtytable\" (\"userid\", \"clinicalid\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
)", "DBCreatePeriodonticsiiTable(create table)");

	$r = DBExec($c, "REVOKE ALL ON \"periodonticsiitable\" FROM PUBLIC", "DBCreatePeriodonticsiiTable(revoke public)");
	$r = DBExec($c, "GRANT ALL ON \"periodonticsiitable\" TO \"".$conf["dbuser"]."\"", "DBCreatePeriodonticsiiTable(grant sihcouser)");
	$r = DBExec($c, "CREATE INDEX \"periodii_index\" ON \"periodonticsiitable\" USING btree ".
				"(\"periodonticsiiid\" int4_ops, \"patientid\" int4_ops, \"student\" int4_ops)",
				"DBCreatePeriodonticsiiTable(create periodii_index)");
}
//funcion para eliminar la tabla de observacion
function DBDropSessionPeriodonticsiiTable() {
    //conexcion de la base de datos..
	 $c = DBConnect();

	 $r = DBExec($c, "drop table \"sessionperiodonticsiitable\"", "DBDropSessionPeriodonticsiiTable(drop table)");

}
//funcion para actualizar datos del paciente
function DBUpdatePatientSurgery($param, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBUpdatePatientSurgery(begin)");
		}
		DBExec($c, "lock table patientadmissiontable", "DBUpdatePatientSurgery(lock)");

		$ret=2;
		$time=time();
		if(isset($param['patientid']) && is_numeric($param['patientid'])){

				if(isset($param['patientadmissionid']) && is_numeric($param['patientadmissionid']) &&
					isset($param['patientstreet']) && $param['patientstreet'] && isset($param['patientresident']) && $param['patientresident']!=''){
						$sql="update patientadmissiontable set patientstreet='".$param['patientstreet']."', patientresident='".$param['patientresident']."' where patientadmissionid=".$param['patientadmissionid'];
						DBExec($c, $sql, "DBUpdatePatientSurgery(update patientadmissiontable)");
				}
		}

		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}
//funcion para crear la tabla de observacion.
function DBCreateSessionPeriodonticsiiTable() {
	 $c = DBConnect();
	 $conf = globalconf();
	 if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
	 $r = DBExec($c, "
CREATE TABLE \"sessionperiodonticsiitable\" (
				\"sessionid\" serial NOT NULL,                -- (id de ficha clinica periodoncia II)
				\"sessiondesc\" text DEFAULT '',							-- (descripcion de session)
				\"sessionevaluated\" bool DEFAULT 'f',        -- (evaluado)
				\"sessionfluor\" varchar(20) DEFAULT '',       -- (fluorizacion)
        \"sessiontype\" varchar(50) DEFAULT '',   -- (tipo de session profilaxis tartrectomia)

				\"fileid\" int4 NOT NULL,      						-- (id de ficha clinica)
				\"student\" int4 NOT NULL,                        	-- (id del estudiante)
				\"teacher\" int4 NOT NULL,                        	-- (id del de docente)
			  \"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
        CONSTRAINT \"sessionperiodonticsii_pkey\" PRIMARY KEY (\"sessionid\"),
				CONSTRAINT \"periodonticsii_fk\" FOREIGN KEY (\"fileid\", \"student\", \"teacher\")
								REFERENCES \"periodonticsiitable\" (\"periodonticsiiid\", \"student\", \"teacher\")
								ON DELETE CASCADE ON UPDATE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
)", "DBCreateSessionPeriodonticsiiTable(create table)");

	$r = DBExec($c, "REVOKE ALL ON \"sessionperiodonticsiitable\" FROM PUBLIC", "DBCreateSessionPeriodonticsiiTable(revoke public)");
	$r = DBExec($c, "GRANT ALL ON \"sessionperiodonticsiitable\" TO \"".$conf["dbuser"]."\"", "DBCreateSessionPeriodonticsiiTable(grant sihcouser)");
	$r = DBExec($c, "CREATE INDEX \"sessionperiodonticsii_index\" ON \"sessionperiodonticsiitable\" USING btree ".
				"(\"sessionid\" ,\"fileid\" int4_ops, \"student\" int4_ops, \"teacher\" int4_ops)",
				"DBCreateSessionPeriodonticsiiTable(create session_index)");
}
//funcion para registrar o actualizar la tabla periodoncia II
function DBNewPeriodonticsii($param , $c=null){

		if(isset($param['patientid']) && !isset($param['patient'])) $param['patient']=$param['patientid'];
		if(isset($param['studentid']) && !isset($param['student'])) $param['student']=$param['studentid'];
		if(isset($param['remissionid']) && !isset($param['remission'])) $param['remission']=$param['remissionid'];
		if(isset($param['teacherid']) && !isset($param['teacher'])) $param['teacher']=$param['teacherid'];
		if(isset($param['clinicalid']) && !isset($param['clinical'])) $param['clinical']=$param['clinicalid'];

		//if(isset($param['surgeryiiid']) && !isset($param['id'])) $param['id']=$param['surgeryiiid'];
		if(isset($param['periodonticsiirotation']) && !isset($param['rotation'])) $param['rotation']=$param['periodonticsiirotation'];
		if(isset($param['periodonticsiimotconsult']) && !isset($param['motconsult'])) $param['motconsult']=$param['periodonticsiimotconsult'];
		if(isset($param['periodonticsiipoll']) && !isset($param['poll'])) $param['poll']=$param['periodonticsiipoll'];
		if(isset($param['periodonticsiigram']) && !isset($param['gram'])) $param['gram']=$param['periodonticsiigram'];
		if(isset($param['periodonticsiiexam']) && !isset($param['exam'])) $param['exam']=$param['periodonticsiiexam'];
		if(isset($param['periodonticsiidiagnosis']) && !isset($param['diagnosis'])) $param['diagnosis']=$param['periodonticsiidiagnosis'];
		if(isset($param['periodonticsiitreatment']) && !isset($param['treatment'])) $param['treatment']=$param['periodonticsiitreatment'];
		if(isset($param['periodonticsiiprophylaxis']) && !isset($param['prophylaxis'])) $param['prophylaxis']=$param['periodonticsiiprophylaxis'];
		if(isset($param['periodonticsiitartarectomy']) && !isset($param['tartarectomy'])) $param['tartarectomy']=$param['periodonticsiitartarectomy'];
		if(isset($param['periodonticsiioleary']) && !isset($param['oleary'])) $param['oleary']=$param['periodonticsiioleary'];
		if(isset($param['periodonticsiibrushed']) && !isset($param['brushed'])) $param['brushed']=$param['periodonticsiibrushed'];
		if(isset($param['periodonticsiicomment']) && !isset($param['comment'])) $param['comment']=$param['periodonticsiicomment'];
		if(isset($param['periodonticsiimedicine']) && !isset($param['medicine'])) $param['medicine']=$param['periodonticsiimedicine'];
		if(isset($param['periodonticsiistatus']) && !isset($param['status'])) $param['status']=$param['periodonticsiistatus'];

		$ac=array('patient', 'student', 'remission', 'teacher', 'clinical');
		$ac1=array('rotation', 'motconsult', 'poll', 'gram', 'exam', 'diagnosis', 'treatment', 'prophylaxis', 'tartarectomy', 'oleary', 'brushed','comment','medicine','status');

		$typei['patient']=-1;
		$typei['student']=-1;
		$typei['remission']=-1;
		$typei['teacherid']=-1;//admin
		$typei['clinical']=6;//clinica periodoncia II


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

		$rotation= '';
		$motconsult= '';
		$poll= '';
		$gram= '';
		$exam= '';
		$diagnosis= '';
		$treatment= '';
		$prophylaxis= '';
		$tartarectomy= '';
		$oleary= '';
		$brushed= '';
		$comment= '';
		$medicine= '';
		$status= 'new';
		$updatetime=-1;
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
			DBExec($c, "begin work", "DBNewPeriodonticsii(begin)");
		}
		DBExec($c, "lock table periodonticsiitable", "DBNewPeriodonticsii(lock)");

		$ret=1;

		//antes de registrar chekear las claves foraneas
		$sql = "select * from periodonticsiitable where patientid=$patient and remissionid= $remission";
		$a = DBGetRow ($sql, 0, $c);
			if($teacher==-1){
				if($a!=null){

					$teacher=$a['teacher'];
					$rotation=$a['periodonticsiirotation'];
					$motconsult=$a['periodonticsiimotconsult'];
					$poll=$a['periodonticsiipoll'];
					$gram=$a['periodonticsiigram'];
					$exam=$a['periodonticsiiexam'];
					$diagnosis=$a['periodonticsiidiagnosis'];
					$treatment=$a['periodonticsiitreatment'];
					$prophylaxis=$a['periodonticsiiprophylaxis'];
					$tartarectomy=$a['periodonticsiitartarectomy'];
					$oleary=$a['periodonticsiioleary'];
					$brushed=$a['periodonticsiibrushed'];
					$comment=$a['periodonticsiicomment'];
					$medicine=$a['periodonticsiimedicine'];
					$status=$a['periodonticsiistatus'];
				}else{
					$teacher=0;
				}
			}
	      	//para insercion o actulizacion
			if ($a == null) {
				  $ret=2;

	    		$sql = "insert into periodonticsiitable(periodonticsiirotation, periodonticsiimotconsult, periodonticsiipoll, periodonticsiigram, periodonticsiiexam, periodonticsiidiagnosis, ".
								 "periodonticsiitreatment,periodonticsiiprophylaxis, periodonticsiitartarectomy, periodonticsiioleary, periodonticsiibrushed, periodonticsiicomment, ".
								 "periodonticsiimedicine, periodonticsiistatus, patientid, student, remissionid, teacher, clinicalid) values ".
	    					 "('$rotation', '$motconsult', '$poll', '$gram', '$exam', '$diagnosis', '$treatment', '$prophylaxis', '$tartarectomy', '$oleary', '$brushed', " .
								 "'$comment', '$medicine', '$status', $patient, $student, $remission, $teacher, $clinical)";

					DBExec ($c, $sql, "DBNewPeriodonticsii(insert)");
	    		if($cw) {
	    				DBExec ($c, "commit work");
	    		}
	    		LOGLevel ("Ficha Periondicia II $remission registrado.",2);
			} else {
				if($updatetime > $a['updatetime']) {
					$ret=2;
					$sql = "update periodonticsiitable set periodonticsiirotation='$rotation', periodonticsiimotconsult='$motconsult', periodonticsiipoll='$poll', periodonticsiigram='$gram', periodonticsiiexam='$exam', periodonticsiidiagnosis='$diagnosis', ".
								"periodonticsiitreatment='$treatment' , ".
								"periodonticsiioleary='$oleary', periodonticsiibrushed='$brushed', periodonticsiicomment='$comment', periodonticsiimedicine='$medicine', periodonticsiistatus='$status', student=$student, teacher=$teacher, updatetime=$updatetime " .
								"where patientid=$patient and remissionid=$remission";

					$r = DBExec ($c, $sql, "DBNewPeriodonticsii(update)");
					if($cw) {
						DBExec ($c, "commit work");
					}
					LOGLevel("Ficha Periodoncia II $remission actualizado.",2);
				}
			}

		if($cw) DBExec($c, "commit work");
		return $ret;
}

function DBSurgeryiiInfo($id, $xremission=false, $c=null) {

	$sql = "select *from surgeryiitable where surgeryiiid=$id";
	if($xremission)
		$sql = "select *from surgeryiitable where remissionid=$id";
	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");

		//MSGError("Unable to find the user in the database. Contact an admin now!");
		return null;
	}
	$a=clearexam($a);
	$a=cleartreatment($a);
	$a=clearsurgeryii($a);

	$conf=globalconf();
	if($a['surgeryiiodontogram']!=null)
		$a['surgeryiiodontogram'] = decryptData($a['surgeryiiodontogram'], $conf["key"]);

	return $a;
}
//funcion para autorizar tecnica de anestesia
function DBAuthorizationAnesthesia($user, $time=null, $type, $id, $c=null){
	$userinfo=DBUserInfo($user);

	if($userinfo==null)
		return false;
	//funcion para saber si es por qr o no
	if($time!=null){
		if($userinfo['usertype']!='teacher'&& $userinfo['usertype']!='nursing'|| $userinfo['userinfo']!=$time)
			return false;
	}

	if($userinfo['usertype']=='teacher'){
		//registrado en cirugia cuarto año
		if(DBSpecialtyInfo($user, 6, 4)==null){
			return false;
		}
	}

	$file=DBSurgeryiiInfo($id);
	$file['surgeryiitreatment'];
	if(trim($file['surgeryiitreatment'])==''){
		$file['surgeryiitreatment']='[false-false][false-false-false-false-false-false][(*,*)(*,*)(*,*)(*,*)(*,*)(*,*)]';
	}else{
		$treat=explode(']',$file['surgeryiitreatment']);
		$size=count($treat);
		if($size!=4){
			$file['surgeryiitreatment']='[false-false][false-false-false-false-false-false][(*,*)(*,*)(*,*)(*,*)(*,*)(*,*)]';
		}
	}
	$treat_tmp=explode(']',$file['surgeryiitreatment']);
	$treat=explode('[',$treat_tmp[2]);
	$treat=trim($treat[1]);

	$auto=explode(')',$treat);
	$size=count($auto);
	if($size!=7)
		return false;
	$data=$auto[$type-1];
	$data=explode('(',$data);
	$data=trim($data[1]);

	$data=explode(',',$data);
	$teacher=trim($data[0]);
	$nursing=trim($data[1]);
	if($userinfo['usertype']=='teacher')
		$teacher=$user.'*'.time();
	if($userinfo['usertype']=='nursing')
		$nursing=$user.'*'.time();

	$data='('.$teacher.','.$nursing;

	$auto[$type-1]=$data;

	$auto1='';
	for ($i=0; $i < count($auto)-1; $i++) {
		$auto1=$auto1.$auto[$i].')';
	}
	$treat_tmp[2]='['.$auto1;
	$treat='';
	for ($i=0; $i < count($treat_tmp)-1; $i++) {
		$treat=$treat.$treat_tmp[$i].']';
	}


	$cw = false;
	if($c == null) {
		$cw = true;
		$c = DBConnect();
		DBExec($c, "begin work", "DBAuthorizationAnesthesia(begin)");
	}
	DBExec($c, "lock table surgeryiitable", "DBAuthorizationAnesthesia(lock)");

	$ret=1;
	$time=time();
	$sql="update surgeryiitable set surgeryiitreatment='$treat' where surgeryiiid=$id";
	DBExec($c, $sql, "DBAuthorizationAnesthesia(update surgeryiitable)");

	if($cw) {
			DBExec ($c, "commit work");
	}

	$msg=$teacher.','.$nursing;//$treat;

	//DBSurgeryiiInfo($id);
	return $msg;
}
//funcion para autorizar una firma a complementaryexam
function DBAuthorizationComplementaryexam($user, $time=null, $type, $id, $c=null){
	$userinfo=DBUserInfo($user);

	if($userinfo==null)
		return false;
	//funcion para saber si es por qr o no
	if($time!=null){
		if($userinfo['usertype']!='teacher'&& $userinfo['usertype']!='nursing'|| $userinfo['userinfo']!=$time)
			return false;
	}

	if($userinfo['usertype']=='teacher'){
		//registrado en cirugia cuarto año
		if(DBSpecialtyInfo($user, 14, 5)==null){
			return false;
		}
	}

	$file=DBSurgeryiiInfo($id);
	$file['surgeryiicomplementaryexam'];
	if(trim($file['surgeryiicomplementaryexam'])==''){
		$file['surgeryiicomplementaryexam']='[false-false-false-false-false-false-false-false-false-false-false-false-false-false-false-false-false-false-false-false-false-false][(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)]';
	}else{
		$treat=explode(']',$file['surgeryiicomplementaryexam']);
		$size=count($treat);
		if($size!=3){
			$file['surgeryiicomplementaryexam']='[false-false-false-false-false-false-false-false-false-false-false-false-false-false-false-false-false-false-false-false-false-false][(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)]';
		}
	}
	$treat_tmp=explode(']',$file['surgeryiicomplementaryexam']);
	$treat=explode('[',$treat_tmp[1]);
	$treat=trim($treat[1]);

	$auto=explode(')',$treat);
	$size=count($auto);
	if($size!=23)
		return false;
	$data=$auto[$type-1];
	$data=explode('(',$data);
	$data=trim($data[1]);

	//$data=explode(',',$data);
	$teacher=trim($data);
	//$nursing=trim($data[1]);
	if($userinfo['usertype']=='teacher')
		$teacher=$user.'*'.time();
	//if($userinfo['usertype']=='nursing')
	//	$nursing=$user.'*'.time();

	$data='('.$teacher;
	//$data='('.$teacher.','.$nursing;

	$auto[$type-1]=$data;

	$auto1='';
	for ($i=0; $i < count($auto)-1; $i++) {
		$auto1=$auto1.$auto[$i].')';
	}
	$treat_tmp[1]='['.$auto1;
	$treat='';
	for ($i=0; $i < count($treat_tmp)-1; $i++) {
		$treat=$treat.$treat_tmp[$i].']';
	}

	$cw = false;
	if($c == null) {
		$cw = true;
		$c = DBConnect();
		DBExec($c, "begin work", "DBAuthorizationComplementaryexam(begin)");
	}
	DBExec($c, "lock table surgeryiitable", "DBAuthorizationComplementaryexam(lock)");

	$ret=1;
	$time=time();
	$sql="update surgeryiitable set surgeryiicomplementaryexam='$treat' where surgeryiiid=$id";
	DBExec($c, $sql, "DBAuthorizationComplementaryexam(update surgeryiitable)");

	if($cw) {
			DBExec ($c, "commit work");
	}

	$msg=$teacher;//.','.$nursing;//$treat;

	//DBSurgeryiiInfo($id);
	return $msg;
}
function DBPatientRemissionSurgeryiiInfo($id, $c=null) {

	$sql = "SELECT pa.*, p.*, rh.*,
	su.surgeryiiid,
	su.surgeryiipractice,
	su.surgeryiimotconsult,
	su.surgeryiipersonalremote,
	su.surgeryiidentalhistory,
	su.surgeryiiphysicalexam,
	su.surgeryiiodontogram,
	su.surgeryiiasa,
	su.surgeryiianxiety,
	su.surgeryiidiagnosishypothesis,
	su.surgeryiicomplementaryexam,
	su.surgeryiisurgicaldifficulty,
	su.surgeryiiconsent,
	su.surgeryiitreatmentplan,
	su.surgeryiidisease,
	su.surgeryiiexam,
	su.surgeryiidiagnosis,
	su.surgeryiitreatment,
	su.surgeryiiprescriptions,
	su.surgeryiiindications,
	su.surgeryiievolution,
	su.surgeryiiforecast
	FROM remissionhistorytable AS rh JOIN patientadmissiontable AS pa
		ON pa.patientadmissionid = rh.patientadmissionid JOIN patienttable AS p ON p.patientid = pa.patientid
		LEFT JOIN surgeryiitable AS su ON su.remissionid = rh.remissionid where rh.remissionid=$id";

	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");

		//MSGError("Unable to find the user in the database. Contact an admin now!");
		return null;
	}

	$a=clearexam($a);
	$a=cleartreatment($a);
	$a=clearsurgeryii($a);
	$a=clearcomplementaryexam($a);
	$a=clearreview($a);
	$conf=globalconf();
	if($a['surgeryiiodontogram']!=null)
		$a['surgeryiiodontogram'] = decryptData($a['surgeryiiodontogram'], $conf["key"]);

	return $a;
}
//funcion para limpiar datos de cirugia bucal iii
function clearsurgeryii($a){

	if($a['surgeryiimotconsult']!=null){
		$r=explode(']',$a['surgeryiimotconsult']);
		$size=count($r);
		$akey = array('surgeryiimotconsult','historiaconsulta','anamnesisfamiliar');
		for ($i=0; $i <$size-1; $i++) {
			$r2=explode('[',$r[$i]);
			$a[$akey[$i]]=trim($r2[1]);
			//$a[$akey[$i]]=filter_var(trim($r2[1]), FILTER_VALIDATE_BOOLEAN);
		}
	}
	if($a['surgeryiipersonalremote']!=null){
		$r=explode(']',$a['surgeryiipersonalremote']);
		$size=count($r);
		$akey = array('remota1','remota2','remota3', 'remota4a', 'remota4b1', 'remota4b2', 'remota4b3',
		'remota4b4', 'remota4b5', 'remota4c', 'remota4d', 'remota4e', 'remota4f1', 'remota4f2', 'remota4f3',
		'remota4g', 'remota4h', 'remota4i', 'remota4j', 'remota4k', 'remota4l', 'remota4m', 'remota4n',
		'remota51', 'remota52', 'remota53', 'remota6', 'remota7', 'remota81', 'remota82', 'remota83',
		'remota84', 'remota85', 'remota86', 'remota87', 'remota88', 'remota89', 'remota810', 'remota811',
		'remota812', 'remota9', 'remota10', 'remota111', 'remota112', 'remota12');

		for ($i=0; $i <$size-1; $i++) {
			$r2=explode('[',$r[$i]);
			$r3=explode('=',$r2[1]);
			if(isset($r3[1])&&$r3){
					$a['obs'.$akey[$i]]=trim($r3[1]);
					$a[$akey[$i]]=trim($r3[0]);
			}else{
					$a[$akey[$i]]=trim($r3[0]);
			}
		}
	}
	if($a['surgeryiidentalhistory']!=null){
		$r=explode(']',$a['surgeryiidentalhistory']);
		$size=count($r);
		$akey = array('historia1', 'historia2', 'historia3', 'historia4', 'historia5',
		'historia6', 'historia7', 'historia8');

		for ($i=0; $i <$size-1; $i++) {
			$r2=explode('[',$r[$i]);
			$r3=explode('=',$r2[1]);
			if(isset($r3[1])&&$r3){
					$a['obs'.$akey[$i]]=trim($r3[1]);
					$a[$akey[$i]]=trim($r3[0]);
			}else{
					$a[$akey[$i]]=trim($r3[0]);
			}
		}
	}
	if($a['surgeryiiphysicalexam']!=null){
		$r=explode(']',$a['surgeryiiphysicalexam']);
		$size=count($r);
		$akey = array('arterial', 'cardiaca', 'respiratoria', 'torax', 'abdomen', 'extremidades', 'faneras',
		'neurologico', 'cuello', 'craneo', 'cara', 'musculos', 'linfaticos', 'atm', 'salivales', 'vestibulo',
		'anterior', 'superior', 'posterior', 'inferior', 'laterales', 'language', 'encias');

		for ($i=0; $i <$size-1; $i++) {
			$r2=explode('[',$r[$i]);
			$a[$akey[$i]]=trim($r2[1]);
		}
	}
	if($a['surgeryiianxiety']!=null){
		$r=explode(']',$a['surgeryiianxiety']);
		$size=count($r);
		$akey = array('nivelansiedad1', 'nivelansiedad2', 'nivelansiedad3', 'nivelansiedad4');

		for ($i=0; $i <$size-1; $i++) {
			$r2=explode('[',$r[$i]);
			$a[$akey[$i]]=trim($r2[1]);
		}
	}

	if($a['surgeryiisurgicaldifficulty']!=null){
		$r=explode(']',$a['surgeryiisurgicaldifficulty']);
		$size=count($r);
		$akey = array('gradodificultad1', 'gradodificultad2', 'gradodificultad3');

		for ($i=0; $i <$size-1; $i++) {
			$r2=explode('[',$r[$i]);
			$a[$akey[$i]]=trim($r2[1]);
		}
	}
	if($a['surgeryiitreatmentplan']!=null){
		$r=explode(']',$a['surgeryiitreatmentplan']);
		$size=count($r);
		$akey = array('inmediato', 'mediato');

		for ($i=0; $i <$size-1; $i++) {
			$r2=explode('[',$r[$i]);
			$a[$akey[$i]]=trim($r2[1]);
		}
	}

	return $a;
}

function DBPeriodonticsiiInfo($id, $c=null) {

	$sql = "select *from periodonticsiitable where periodonticsiiid=$id";

	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");

		//MSGError("Unable to find the user in the database. Contact an admin now!");

		return null;
	}
	$conf=globalconf();
	if($a['periodonticsiigram']!=null)
		$a['periodonticsiigram'] = decryptData($a['periodonticsiigram'], $conf["key"]);
	if($a['periodonticsiioleary']!=null){
		$a['periodonticsiioleary'] = decryptData($a['periodonticsiioleary'], $conf["key"]);

		$oleary=strpos($a['periodonticsiioleary'],'[xu=');
		if($oleary!==false){
			$dataf=substr($a['periodonticsiioleary'],$oleary);
			$a['periodonticsiioleary']=substr($a['periodonticsiioleary'],0,strlen($a['periodonticsiioleary'])-strlen($dataf));
			$a=cleardataf($a, $dataf);
		}
	}


	$a=clearpexam($a);
	$a=clearsession($a);
	$a=clearperiodonticsii($a);
	$ob=DBObservationInfo($a['periodonticsiiid'],$a['remissionid']);
	if($ob!=null){
		$a=array_merge($a, $ob);
	}

	//$a=clearexam($a);
	//$a=cleartreatment($a);
	return $a;
}
function clearperiodonticsii($a){
	if(trim($a['periodonticsiipoll'])!=null){
		$r=explode(']',$a['periodonticsiipoll']);
		$size=count($r);
		$akey = array('question1','question2','question3', 'question4', 'question5', 'question6', 'question7',
		'question8', 'question9', 'question10', 'question11', 'question12', 'question13', 'question14', 'question15',
		'question16', 'question17', 'question18', 'question19');

		for ($i=0; $i <$size-1; $i++) {
			$r2=explode('[',$r[$i]);
			$r3=explode('=',$r2[1]);
			if(isset($r3[1])&&$r3){
					$a['obs'.$akey[$i]]=trim($r3[1]);
					$a[$akey[$i]]=trim($r3[0]);
			}else{
					$a[$akey[$i]]=trim($r3[0]);
			}
		}
	}

	return $a;
}
function clearsession($a){
	if(isset($a['periodonticsiiprophylaxis'])&& $a['periodonticsiiprophylaxis']!=''){
		$r=explode(']',$a['periodonticsiiprophylaxis']);
		$size=count($r);
		for ($i=0; $i <$size-1 ; $i++) {
			$r2=explode('[',$r[$i]);
			$r2=explode('=',$r2[1]);
			$a['session1date'.($i+1)]=trim($r2[0]);
			$a['session1evalued'.($i+1)]=trim($r2[1]);
			if($i>2){
				$a['session1date0']=trim($r2[0]);
				$a['session1evalued0']=trim($r2[1]);
			}
		}
	}
	if(isset($a['periodonticsiitartarectomy'])&& $a['periodonticsiitartarectomy']!=''){
		$r=explode(']',$a['periodonticsiitartarectomy']);
		$size=count($r);
		for ($i=0; $i <$size-1 ; $i++) {
			$r2=explode('[',$r[$i]);
			$r2=explode('=',$r2[1]);

			$a['session2date'.($i+1)]=trim($r2[0]);
			$a['session2evalued'.($i+1)]=trim($r2[1]);
			if($i>2){
				$a['session2date0']=trim($r2[0]);
				$a['session2evalued0']=trim($r2[1]);
			}
		}
	}
	return $a;
}
function cleardataf($a, $dataf , $two=false){
	$r=explode(']',$dataf);
	$size=count($r);

	if($two){
		//MSGError($dataf);

		$akey = array('info1','info2','info3','date1','date2','date3','evaluedoleary1','evaluedoleary2','evaluedoleary3','st');
		for ($i=0; $i <$size-1 ; $i++) {
			$r2=explode('[',$r[$i]);
			$r2=explode('=',$r2[1]);
			$a[$akey[$i]]=trim($r2[1]);
		}
	}else{
		$akey = array('info1','info2','date1','date2');
		for ($i=0; $i <$size-1 ; $i++) {
			$r2=explode('[',$r[$i]);
			$r2=explode('=',$r2[1]);
			$a[$akey[$i]]=trim($r2[1]);
		}
	}
	return $a;
}
function clearpexam($a){

	$r=explode(']',$a['periodonticsiiexam']);
	$size=count($r);

	if($size>1){
		$r2=explode('[',$r[0]);
		$a['bucal']=$r2[1];
		if($size>2){
			$r3=explode('[',$r[1]);
			$a['gingival']=$r3[1];
			if($size>3){
				$r3=explode('[',$r[2]);
				$a['sondeo']=$r3[1];
				if($size>4){
					$r3=explode('[',$r[3]);
					$a['tartaro']=$r3[1];
				}
			}
		}
	}

	return $a;
}
function cleartreatment($a){
	$r=explode(']',$a['surgeryiitreatment']);
	$len=count($r);
	if($len>1){

		$r2=explode('[',$r[0]);
		$a['treatment']=array();//$r2[1];
		$r3=explode('-',$r2[1]);
		if(count($r3)==2){
			$a['treatment']['quirurgico']=$r3[0];
			$a['treatment']['farmacologico']=$r3[1];
		}

		if($len>2){
			$r2=explode('[',$r[1]);
			$a['anestesia']=array();//$r2[1];
			$r3=explode('-',$r2[1]);
			if(count($r3)==6){
				$a['anestesia']['spix']=$r3[0];
				$a['anestesia']['mentoniana']=$r3[1];
				$a['anestesia']['local']=$r3[2];
				$a['anestesia']['infraorbitaria']=$r3[3];
				$a['anestesia']['tuberositaria']=$r3[4];
				$a['anestesia']['carrea']=$r3[5];
			}
			if($len>3){
				$r2=explode('[',$r[2]);
				//$a['anestesia']=array();//$r2[1];

				$r3=explode(')',$r2[1]);
				if(count($r3)==7){
					$r4=explode('(',$r3[0]);
					$r5=explode(',',$r4[1]);
					$a['anestesia']['spixteacher']=$r5[0];
					$a['anestesia']['spixnursing']=$r5[1];
					$r4=explode('(',$r3[1]);
					$r5=explode(',',$r4[1]);
					$a['anestesia']['mentonianateacher']=$r5[0];
					$a['anestesia']['mentoniananursing']=$r5[1];
					$r4=explode('(',$r3[2]);
					$r5=explode(',',$r4[1]);
					$a['anestesia']['localteacher']=$r5[0];
					$a['anestesia']['localnursing']=$r5[1];
					$r4=explode('(',$r3[3]);
					$r5=explode(',',$r4[1]);
					$a['anestesia']['infraorbitariateacher']=$r5[0];
					$a['anestesia']['infraorbitarianursing']=$r5[1];
					$r4=explode('(',$r3[4]);
					$r5=explode(',',$r4[1]);
					$a['anestesia']['tuberositariateacher']=$r5[0];
					$a['anestesia']['tuberositarianursing']=$r5[1];
					$r4=explode('(',$r3[5]);
					$r5=explode(',',$r4[1]);
					$a['anestesia']['carreateacher']=$r5[0];
					$a['anestesia']['carreanursing']=$r5[1];
				}
			}
		}
	}
	return $a;
}
function clearcomplementaryexam($a){
	$r=explode(']',$a['surgeryiicomplementaryexam']);
	$len=count($r);

	if($len>1){
		$r2=explode('[',$r[0]);
		$a['complementaryexam']=array();//$r2[1];
		$r3=explode('-',$r2[1]);
		if(count($r3)==22){
			$ac = array('laboratorio1','laboratorio2','laboratorio3','laboratorio4','laboratorio5','histopatologico1',
			'histopatologico2','histopatologico3','histopatologico4','diagenologia1','diagenologia2','diagenologia3',
			'diagenologia4','diagenologia5','diagenologia6','fotografia1','fotografia2','fotografia3','fotografia4',
			'fotografia5','impresiones1','impresiones2');
			for ($i=0; $i < count($ac); $i++) {
				$a['complementaryexam'][$ac[$i]]=$r3[$i];
			}

			if($len>2){
				$r2=explode('[',$r[1]);
				$r3=explode(')',$r2[1]);
				if(count($r3)==23){
					for ($i=0; $i < count($ac); $i++) {
						$r4=explode('(',$r3[$i]);
						$a['complementaryexam'][$ac[$i].'teacher']=$r4[1];
					}
				}
			}
		}

	}
	return $a;
}
function clearexam($a){

	$r=explode(']',$a['surgeryiiexam']);
	$size=count($r);
	if($size>1){
		$r2=explode('[',$r[0]);
		$a['exam']=unsanitizeTextNHTML($r2[1]);
		if($size>2){
			$r3=explode('[',$r[1]);
			$a['pieza']=unsanitizeTextNHTML($r3[1]);
		}
	}

	return $a;
}

//saca la information de session periodncia
function DBSessionPeriodonticsiiInfo($file, $c=null) {

	$sql = "select *from sessionperiodonticsiitable where fileid=$file and sessionid=(select max(sessionid) from sessionperiodonticsiitable where fileid=$file)";

	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		//LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");

		//MSGError("Unable to find the user in the database. Contact an admin now!");
		return null;
	}
	return $a;
}
//el id es de cirugia
function DBObservationInfo($file, $remission, $c=null) {

	$sql = "select *from observationtable where (fileid=$file and remissionid=$remission) and observationid=(select max(observationid) from observationtable where fileid=$file and remissionid=$remission)";

	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		//LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");

		//MSGError("Unable to find the user in the database. Contact an admin now!");
		return null;
	}
	return $a;

}
//el id es de cirugia
function DBObservationInfo2($file, $remission, $c=null) {

	$sql = "select observationdesc as description, observationevaluated as evaluated, observationaccepted as accepted from observationtable where (fileid=$file and remissionid=$remission) and observationid=(select max(observationid) from observationtable where fileid=$file and remissionid=$remission)";

	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		//LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");

		//MSGError("Unable to find the user in the database. Contact an admin now!");
		return null;
	}
	$n=DBAllObservationInfo($remission,$file,true);

	$a['row']=$n;
	return $a;

}
//funcion para designar docente
function DBDesignedTeacher($teacher, $record, $clinical, $starttime=-1){
	if($clinical==1||$clinical==9)
		DBDesignedTeacherRemovable($teacher, $record);
	if($clinical==2||$clinical==10)
		DBDesignedTeacherFixed($teacher, $record);
	if($clinical==3||$clinical==11)
		DBDesignedTeacherOperative($teacher, $record);
	if($clinical==4||$clinical==12)
		DBDesignedTeacherEndodontics($teacher, $record);
	if($clinical==5 || $clinical==13)
		DBDesignedTeacherSurgeryii($teacher, $record, $starttime);
	if($clinical==6 || $clinical==14)
		DBDesignedTeacherPeriodonticsii($teacher, $record);
	if($clinical==7 || $clinical==15)
		DBDesignedTeacherPediatrics($teacher, $record, $starttime);
	if($clinical==8 || $clinical==16)
		DBDesignedTeacherOrthodontics($teacher, $record);
}
function DBTeachersInfo($clinical, $names=false){
	$sql="select u.usernumber as teacherid , u.userfullname as teachername from usertable as u, specialtytable s where ".
	"u.usernumber=s.userid and s.clinicalid=$clinical and u.usertype='teacher'";
	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBTeacherRevInfo(get rev fixed)");
	$n = DBnlines($r);
	$teachers="";
	$a = array();
	for ($i=0;$i<$n;$i++) {
		$t = DBRow($r,$i);
		$a[$i]=$t;
		$teachers.='['.$t['teacherid'].']';
	}
	if($names==true){
		return $a;
	}else{
		return $teachers;
	}
}
//funcion para designar y observar:: se asigno para añadir a docentes para revision
function DBDesignedTeacherFixed($teacher, $record, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBDesignedTeacherFixed(begin)");
		}
		$a=DBFixedInfo($record);
		if($a==null){
			if($cw) {
					DBExec ($c, "commit work");
			}
			return false;
		}
		$teachers=DBTeachersInfo($a['clinicalid']);//prostodoncia fija II
		$ret=2;
		$time=time();//asignamos todos los docentes de prostodoncia fija
		$sql = "update fixedtable set teacher=$teacher, fixedrev='$teachers', startdatetime=$time where fixedid=$record";

		DBExec ($c, $sql, "DBDesignedTeacherFixed(update)");

		$sql = "update observationtable set teacher=$teacher where fileid=$record and remissionid=".$a['remissionid'];
		DBExec ($c, $sql, "DBDesignedTeacherFixed(update observation)");
		if($cw) {
				DBExec ($c, "commit work");
		}

		return $ret;
}
//funcion para designar y observar:: se asigno para añadir a docentes para revision
function DBDesignedTeacherOperative($teacher, $record, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBDesignedTeacherOperative(begin)");
		}
		$a=DBOperativeInfo($record);
		if($a==null){
			if($cw) {
					DBExec ($c, "commit work");
			}
			return false;
		}
		$teachers=DBTeachersInfo($a['clinicalid']);//operatoria dental ii
		$ret=2;
		$time=time();//asignamos todos los docentes
		$sql = "update operativetable set teacher=$teacher, operativerev='$teachers', startdatetime=$time where operativeid=$record";

		DBExec ($c, $sql, "DBDesignedTeacherOperative(update)");

		$sql = "update observationtable set teacher=$teacher where fileid=$record and remissionid=".$a['remissionid'];
		DBExec ($c, $sql, "DBDesignedTeacherOperative(update observation)");
		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}
//funcion para designar y observar:: se asigno para añadir a docentes para revision
function DBDesignedTeacherEndodontics($teacher, $record, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBDesignedTeacherEndodontics(begin)");
		}
		$a=DBEndodonticsInfo($record);
		if($a==null){
			if($cw) {
					DBExec ($c, "commit work");
			}
			return false;
		}
		$teachers=DBTeachersInfo($a['clinicalid']);//endodoncia II
		$ret=2;
		$time=time();//asignamos todos los docentes
		$sql = "update endodonticstable set teacher=$teacher, endodonticsrev='$teachers', startdatetime=$time where endodonticsid=$record";

		DBExec ($c, $sql, "DBDesignedTeacherEndodontics(update)");

		$sql = "update observationtable set teacher=$teacher where fileid=$record and remissionid=".$a['remissionid'];
		DBExec ($c, $sql, "DBDesignedTeacherEndodontics(update observation)");
		if($cw) {
				DBExec ($c, "commit work");
		}

		return $ret;
}
function DBDesignedTeacherRemovable($teacher, $record, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBDesignedTeacherRemovable(begin)");
		}
		$a=DBRemovableInfo($record);
		if($a==null){
			if($cw) {
					DBExec ($c, "commit work");
			}
			return false;
		}
		$teachers=DBTeachersInfo($a['clinicalid']);//1 prostodoncia removable II
		$ret=2;
		$time=time();//asignamos todos los docentes de prostodoncia fija
		$sql = "update removabletable set teacher=$teacher, removablerev='$teachers', startdatetime=$time where removableid=$record";

		DBExec ($c, $sql, "DBDesignedTeacherRemovable(update)");

		$sql = "update observationtable set teacher=$teacher where fileid=$record and remissionid=".$a['remissionid'];
		DBExec ($c, $sql, "DBDesignedTeacherRemovable(update observation)");
		if($cw) {
				DBExec ($c, "commit work");
		}

		return $ret;
}
//funcion para designar y observar
function DBDesignedTeacherSurgeryii($teacher, $record, $starttime=-1, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBDesignedTeacherSurgeryii(begin)");
		}
		//DBExec($c, "lock table surgeryiitable", "DBDesignedTeacherSurgeryii(lock)");
		$a=DBSurgeryiiInfo($record);
		if($a==null){
			if($cw) {
					DBExec ($c, "commit work");
			}
			return false;
		}

		$ret=2;
		$time=time();
		if($starttime!=-1){
				$time=$starttime;
		}
		$sql = "update surgeryiitable set teacher=$teacher, startdatetime=$time where surgeryiiid=$record";

		DBExec ($c, $sql, "DBDesignedTeacherSurgeryii(insert)");

		$sql = "update observationtable set teacher=$teacher where fileid=$record and remissionid=".$a['remissionid'];
		DBExec ($c, $sql, "DBDesignedTeacherSurgeryii(insert)");
		if($cw) {
				DBExec ($c, "commit work");
		}

		return $ret;
}
//funcion para designar y observar
function DBDesignedTeacherPeriodonticsii($teacher, $record, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBDesignedTeacherPeriodonticsii(begin)");
		}
		//DBExec($c, "lock table surgeryiitable", "DBDesignedTeacherSurgeryii(lock)");
		$a=DBPeriodonticsiiInfo($record);
		if($a==null){
			if($cw) {
					DBExec ($c, "commit work");
			}
			return false;
		}

		$ret=2;
		$time=time();
		$sql = "update periodonticsiitable set teacher=$teacher, startdatetime=$time where periodonticsiiid=$record";

		DBExec ($c, $sql, "DBDesignedTeacherPeriodonticsii(update)");

		$sql = "update observationtable set teacher=$teacher where fileid=$record and remissionid=".$a['remissionid'];
		DBExec ($c, $sql, "DBDesignedTeacherPeriodonticsii(update observation)");
		if($cw) {
				DBExec ($c, "commit work");
		}

		return $ret;
}
//funcion para designar y observar
function DBDesignedTeacherPediatrics($teacher, $record, $starttime=-1, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBDesignedTeacherPediatrics(begin)");
		}
		//DBExec($c, "lock table surgeryiitable", "DBDesignedTeacherSurgeryii(lock)");
		$a=DBPediatricsiInfo($record);
		if($a==null){
			if($cw) {
					DBExec ($c, "commit work");
			}
			return false;
		}


		$teachers=DBTeachersInfo($a['clinicalid']);//1 prostodoncia removable II
		$ret=2;
		$time=time();//asignamos todos los docentes de prostodoncia fija
		if($starttime!=-1){
				$time=$starttime;
		}
		$sql = "update pediatricsitable set teacher=$teacher, pediatricsirev='$teachers', startdatetime=$time where pediatricsiid=$record";
		DBExec ($c, $sql, "DBDesignedTeacherPediatrics(update)");

		$sql = "update observationtable set teacher=$teacher where fileid=$record and remissionid=".$a['remissionid'];

		DBExec ($c, $sql, "DBDesignedTeacherPediatrics(update observation)");
		if($cw) {
				DBExec ($c, "commit work");
		}

		return $ret;
}
//funcion para designar y observar
function DBDesignedTeacherOrthodontics($teacher, $record, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBDesignedTeacherOrthodontics(begin)");
		}
		//DBExec($c, "lock table surgeryiitable", "DBDesignedTeacherSurgeryii(lock)");
		$a=DBOrthodonticsInfo($record);
		if($a==null){
			if($cw) {
					DBExec ($c, "commit work");
			}
			return false;
		}

		$ret=2;
		$time=time();
		$sql = "update orthodonticstable set teacher=$teacher, startdatetime=$time where orthodonticsid=$record";

		DBExec ($c, $sql, "DBDesignedTeacherOrthodontics(update)");

		$sql = "update observationtable set teacher=$teacher where fileid=$record and remissionid=".$a['remissionid'];
		DBExec ($c, $sql, "DBDesignedTeacherOrthodontics(update observation)");
		if($cw) {
				DBExec ($c, "commit work");
		}

		return $ret;
}

//DBSurgeryiiInfo
function DBDeleteObservation($remission){

	$c = DBConnect();
	DBExec($c, "begin work");
	DBExec($c, "lock table observationtable");
	$sql = "select * from observationtable where remissionid=$remission for update";
	$a = DBGetRow ($sql, 0, $c);
	if ($a != null) {
			//echo "yes delete";
      $sql = "delete from observationtable where remissionid=$remission";
			DBExec ($c, $sql);

			DBExec($c, "commit work");//para el commit de exito
	} else {
		DBExec($c, "rollback work");
		LOGLevel("Observation remissionid = $remission could not be removed.", 1);
		return false;
	}
}
//funcion para eliminar una remision equivocada
function DBDeleteSurgeryii($remission){

	$c = DBConnect();
	DBExec($c, "begin work");
	DBExec($c, "lock table surgeryiitable");
	$sql = "select * from surgeryiitable where remissionid=$remission for update";
	$a = DBGetRow ($sql, 0, $c);
	$yes=false;
	if ($a != null) {
			//echo "yes delete";
      $sql = "delete from surgeryiitable where remissionid=$remission";
			DBExec ($c, $sql);
			$yes=true;
			DBExec($c, "commit work");//para el commit de exito
	} else {
		echo "no delete";
		DBExec($c, "rollback work");
		LOGLevel("Surgery remissionid = $remission could not be removed.", 1);
		return false;
	}
	if($yes)
		DBDeleteObservation($remission);
}
//funcion para eliminar una remision equivocada
function DBDeletePeriodonticsii($remission){

	$c = DBConnect();
	DBExec($c, "begin work");
	DBExec($c, "lock table periodonticsiitable");
	$sql = "select * from periodonticsiitable where remissionid=$remission for update";
	$a = DBGetRow ($sql, 0, $c);
	$yes=false;
	if ($a != null) {
			//echo "yes delete";
      $sql = "delete from periodonticsiitable where remissionid=$remission";
			DBExec ($c, $sql);
			DBExec($c, "commit work");//para el commit de exito
			$yes=true;
	} else {
		echo "no delete";
		DBExec($c, "rollback work");
		LOGLevel("Periodonticsii remissionid = $remission could not be removed.", 1);
		return false;
	}
	if($yes)
		DBDeleteObservation($remission);
}

//funcion para eliminar la tabla de observacion
function DBDropObservationTable() {
    //conexcion de la base de datos..
	 $c = DBConnect();

	 $r = DBExec($c, "drop table \"observationtable\"", "DBDropObservationTable(drop table)");

}
//funcion para crear la tabla de observacion.
function DBCreateObservationTable() {
	 $c = DBConnect();
	 $conf = globalconf();
	 if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
	 $r = DBExec($c, "
CREATE TABLE \"observationtable\" (
				\"observationid\" serial NOT NULL,                	-- (id de ficha clinica cirugia bucal ii)
				\"observationdesc\" text DEFAULT '',			-- (descripcion de observacion)
				\"observationevaluated\" bool DEFAULT 'f',        -- (evaluado)
        \"observationaccepted\" bool DEFAULT 'f',   -- (observacion aceptado o finalizado)

				\"fileid\" int4 NOT NULL,      								-- (id de ficha clinica)
				\"student\" int4 NOT NULL,                        	-- (id del estudiante)
				\"teacher\" int4 NOT NULL,                        	-- (id del de docente)
				\"remissionid\" int4 NOT NULL,									-- (id de la remision)
			  \"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
        CONSTRAINT \"observation_pkey\" PRIMARY KEY (\"observationid\")
)", "DBCreateObservationTable(create table)");

	$r = DBExec($c, "REVOKE ALL ON \"observationtable\" FROM PUBLIC", "DBCreateObservationTable(revoke public)");
	$r = DBExec($c, "GRANT ALL ON \"observationtable\" TO \"".$conf["dbuser"]."\"", "DBCreateObservationTable(grant sihcouser)");
	$r = DBExec($c, "CREATE INDEX \"observation_index\" ON \"observationtable\" USING btree ".
				"(\"observationid\" ,\"fileid\" int4_ops, \"student\" int4_ops, \"teacher\" int4_ops)",
				"DBCreateObservationTable(create observation_index)");
}
//funcion para sacar todas as observaciones
function DBAllObservationInfo($remission=-1, $file=-1, $row=false){
	$sql = "select observationdesc as description, observationevaluated as evaluated, observationaccepted as accepte, updatetime as time ".
	"from observationtable";

	if($remission!=-1 && $file!=-1){
		$sql.=" where remissionid=$remission and fileid=$file";
	}
	$sql.=" order by updatetime desc";
	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBAllObservationInfo(get all observation of remission $remission file $file)");
	$n = DBnlines($r);
	if($row)
		return $n;
	$a = array();
	for ($i=0;$i<$n;$i++) {
		$a[$i] = DBRow($r,$i);
	}
	return $a;
}
//funcion para crear un nuevo observacion
function DBNewObservation($param , $c=null){

		if(isset($param['studentid']) && !isset($param['student'])) $param['student']=$param['studentid'];
		if(isset($param['teacherid']) && !isset($param['teacher'])) $param['teacher']=$param['teacherid'];
		//if(isset($param['surgeryiiid']) && !isset($param['surgery'])) $param['surgery']=$param['surgeryiiid'];
		if(isset($param['fileid']) && !isset($param['file'])) $param['file']=$param['fileid'];
		if(isset($param['remissionid']) && !isset($param['remission'])) $param['remission']=$param['remissionid'];

		if(isset($param['observationdesc']) && !isset($param['desc'])) $param['desc']=$param['observationdesc'];
		if(isset($param['observationevaluated']) && !isset($param['evaluated'])) $param['evaluated']=$param['observationevaluated'];
		if(isset($param['observationaccepted']) && !isset($param['accepted'])) $param['accepted']=$param['observationaccepted'];


		//$ac=array('student', 'surgery', 'teacher');
		$ac=array('student', 'file', 'teacher', 'remission');
		$ac1=array('desc', 'evaluated', 'accepted', 'updatetime');

		$typei['student']=-1;
		//$typei['surgery']=-1;
		$typei['file']=-1;
		$typei['remission']=-1;
		$typei['teacherid']=-1;//admin
		$typei['updatetime']=-1;//admin


		foreach($ac as $key) {
			if(!isset($param[$key]) || $param[$key]=="") {
				MSGError("DBNewObservation param error: $key not found");
				return false;
			}
			if(isset($typei[$key]) && !is_numeric($param[$key])) {
				MSGError("DBNewObservation param error: $key is not numeric");
				return false;
			}
			$$key = myhtmlspecialchars($param[$key]);
		}

		$desc ='';
		$evaluated='f';
		$accepted='f';
		$updatetime=-1;
		foreach($ac1 as $key) {
			if(isset($param[$key])) {
				$$key = myhtmlspecialchars($param[$key]);
				if(isset($typei[$key]) && !is_numeric($param[$key])) {
					MSGError("DBNewObservation param error: $key is not numeric");
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
			DBExec($c, "begin work", "DBNewObservation(begin)");
		}
		DBExec($c, "lock table observationtable", "DBNewObservation(lock)");
		$ret=2;

		$sql = "insert into observationtable(observationdesc, observationevaluated, observationaccepted, ".
					 "fileid, student, teacher, remissionid, updatetime) values ".
					 "('$desc', '$evaluated', '$accepted', $file, $student, $teacher, $remission, $updatetime)";

		DBExec ($c, $sql, "DBNewObservation(insert)");
		if($cw) {
				DBExec ($c, "commit work");
		}
		LOGLevel ("Ficha $file remission $remission asignado una observacion.",2);

		if($cw) DBExec($c, "commit work");
		return $ret;
}
//funcion para sacar la informacion de fichas clinicas aun no designados
function DBAllDesignedUserNotInfo($user){
	return DBAllDesignedUserInfo($user, true, 8000000);
}
//funcion para sacar la informacion de docente designado a las especialidades
function DBAllDesignedUserInfo($user, $admin=false, $limit=800) {//25

	$sql = "select s.userid as user, s.clinicalid as clinical, c.clinicalspecialty as clinicalname from specialtytable as s, clinicaltable as c where s.userid=$user and c.clinicalid=s.clinicalid";
	if($admin)
		$user=0;//el docente aun no designado.
	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBAllDesignedUserInfo(get designed user)");
	$n = DBnlines($r);

	$limit=$limit/$n;
	//MSGError($limit.' n= '.$n);
	$a = array();
	$a1 = array();
	$j=0;
	for ($i=0;$i<$n;$i++) {
		$a[$i] = DBRow($r,$i);
		//una clinica pude tener 0 o muchos fichas clinicas
		if($a[$i]['clinical']==1||$a[$i]['clinical']==9){//ficha clinica de prostodoncia removable II
			$a1[$j]=DBAllRemovableTeacherInfo($user, $a[$i]['clinical'], $limit);
			$j++;
		}
		//una clinica pude tener 0 o muchos fichas clinicas
		if($a[$i]['clinical']==2||$a[$i]['clinical']==10){//ficha clinica de prostodoncia fija II
			$a1[$j]=DBAllFixedTeacherInfo($user, $a[$i]['clinical'], $limit);
			$j++;
		}
		if($a[$i]['clinical']==3||$a[$i]['clinical']==11){//ficha clinica de operatoria dental II

			$a1[$j]=DBAllOperativeTeacherInfo($user, $a[$i]['clinical'], $limit);
			$j++;
		}
		if($a[$i]['clinical']==4||$a[$i]['clinical']==12){//ficha clinica de endodoncia II

			$a1[$j]=DBAllEndodonticsTeacherInfo($user, $a[$i]['clinical'], $limit);
			$j++;
		}
		if($a[$i]['clinical']==5||$a[$i]['clinical']==13){
			$a1[$j]=DBAllSurgeryTeacherInfo($user, $a[$i]['clinical'], $limit);
			$j++;
		}
		if($a[$i]['clinical']==6 || $a[$i]['clinical']==14){

			$a1[$j]=DBAllPeriodonticsTeacherInfo($user, $a[$i]['clinical'], $limit);
			$j++;
		}
		if($a[$i]['clinical']==7 || $a[$i]['clinical']==15){//odontopediatria I

			$a1[$j]=DBAllPediatricsTeacherInfo($user, $a[$i]['clinical'], $limit);
			$j++;
		}
		if($a[$i]['clinical']==8||$a[$i]['clinical']==16){//ortodoncia

			$a1[$j]=DBAllOrthodonticsTeacherInfo($user, $a[$i]['clinical'], $limit);
			$j++;
		}
	}
	$a=$a1;
	//ordena2($a);

	//$a[$j][$i]['time']=3834818732;
	$aux=array();
	$b=0;
	for ($i=0; $i < count($a); $i++) {
		for ($j=0; $j < count($a[$i]) ; $j++) {
			$aux[$b]=$a[$i][$j];
			$b++;
		}
	}
	//$aux=ordena2($aux);
	$aux=mergesort($aux);//funcion para ordenar de forma descendente por un campo llamado time
	//algoritmo de ordenamiento merge sort

	return $aux;//$a
}
//ordenamiento merge sort inicio


//ordenamiento merge sort fin




//funcion para sacar toda la informacion ciruga bucal ii
function DBAllSurgeryTeacherInfo($user, $clinical, $limit=100){
	$sql = "select c.clinicalid as clinical, r.remissionid as remission, su.surgeryiiid as ficha, p.patientfullname as patientfullname,
de.motconsult as consult, c.clinicalspecialty as clinicalname, u.userfullname as student,
su.surgeryiidiagnosis as diagnosis, su.surgeryiistatus as status, su.updatetime as time from surgeryiitable
as su, usertable as u, patienttable as p, clinicaltable as c, dentalexamtable as de, remissiontable as r
where su.teacher=$user and su.surgeryiistatus!='new' and p.patientid=su.patientid and de.patientid=r.patientid and
de.dentalid=r.patientdentalid and r.remissionid=su.remissionid and su.clinicalid=$clinical and c.clinicalid=r.clinicalid and
r.examined=su.student and u.usernumber=r.examined order by su.updatetime desc limit $limit";

	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBAllSurgeryTeacherInfo(get all surgeryii)");
	$n = DBnlines($r);

	$a = array();
	for ($i=0;$i<$n;$i++) {
		$a[$i] = DBRow($r,$i);
		//para sacar la observacion de cada ficha clinica
		$ob=DBObservationInfo2($a[$i]['ficha'], $a[$i]['remission']);
		if($ob!=null)
			$a[$i]=array_merge($a[$i],$ob);
		$a[$i]['file']='surgeryii';
	}
	return $a;
}
//funcion para sacar la informacion de un docente designado
function DBAllPeriodonticsTeacherInfo($user, $clinical, $limit=100){
	$sql = "select c.clinicalid as clinical, r.remissionid as remission, pe.periodonticsiiid as ficha, p.patientfullname as patientfullname,
de.motconsult as consult, c.clinicalspecialty as clinicalname, u.userfullname as student,
pe.periodonticsiidiagnosis as diagnosis, pe.periodonticsiistatus as status, pe.updatetime as time from periodonticsiitable
as pe, usertable as u, patienttable as p, clinicaltable as c, dentalexamtable as de, remissiontable as r
where pe.teacher=$user and pe.periodonticsiistatus!='new' and p.patientid=pe.patientid and de.patientid=r.patientid and
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
		$a[$i]['file']='periodonticsii';
	}

	return $a;
}
function DBUpdateComplementaryExam($param, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBUpdateComplementaryExam(begin)");
		}
		DBExec($c, "lock table surgeryiitable", "DBUpdateComplementaryExam(lock)");

		$ret=2;
		$time=time();
		if(isset($param['file']) && is_numeric($param['file']) && isset($param['complementaryexam'])){
				$sql="update surgeryiitable set surgeryiicomplementaryexam='".$param['complementaryexam']."' where surgeryiiid=".$param['file'];
				DBExec($c, $sql, "DBUpdateComplementaryExam(update surgeryiitable complementaryexam)");
		}
		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}
//funcion para actualizar las firma de revision de docente
function DBUpdateSurgeryToken($file, $token, $start, $proces, $end, $intra, $post, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBUpdateSurgeryToken(begin)");
		}
		DBExec($c, "lock table surgerytokentable", "DBUpdateSurgeryToken(lock)");

		$ret=2;
		$time=time();
		if(isset($file) && is_numeric($file) && isset($token) && isset($start) && isset($proces) && isset($end)){
				$sql="update surgerytokentable set tokenauthorization='".$start."', tokentracing='".$proces."', tokenending='".$end."', tokenobsintra='".$intra."', tokenobspost='".$post."' where tokenid=".$token." and fileid=".$file;
				DBExec($c, $sql, "DBUpdateSurgeryToken(update surgeryiitable complementaryexam)");
		}
		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}
//funcion para sacar la informacion de cirugia bucal

function DBSurgeryiiInfo2($id, $c=null) {

	$sql = "select c.clinicalid as clinical, r.remissionid as remission, su.surgeryiiid as ficha, p.patientfullname as patientfullname,
de.motconsult as consult, c.clinicalspecialty as clinicalname, u.userfullname as student,
su.surgeryiidiagnosis as diagnosis, su.surgeryiistatus as status, su.teacher as teacher, su.updatetime as time from surgeryiitable
as su, usertable as u, patienttable as p, clinicaltable as c, dentalexamtable as de, remissiontable as r
where su.surgeryiiid=$id and su.surgeryiistatus!='new' and p.patientid=su.patientid and de.patientid=r.patientid and
de.dentalid=r.patientdentalid and r.remissionid=su.remissionid and c.clinicalid=r.clinicalid and
r.examined=su.student and u.usernumber=r.examined";

	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");

		//MSGError("Unable to find the user in the database. Contact an admin now!");
		return null;
	}
	$ob=DBObservationInfo2($id,$a['remission']);
	if($ob!=null)
		$a=array_merge($a,$ob);
	return $a;
}
//para sacar la informacion de periodoncia 2
function DBPeriodonticsiiInfo2($id, $c=null) {

	$sql = "select c.clinicalid as clinical, r.remissionid as remission, pe.periodonticsiiid as ficha, p.patientfullname as patientfullname,
de.motconsult as consult, c.clinicalspecialty as clinicalname, u.userfullname as student,
pe.periodonticsiidiagnosis as diagnosis, pe.periodonticsiistatus as status, pe.periodonticsiitartarectomy as periodonticsiitartarectomy, pe.periodonticsiiprophylaxis as periodonticsiiprophylaxis, pe.periodonticsiitreatment as treatment, pe.teacher as teacher, pe.updatetime as time from periodonticsiitable
as pe, usertable as u, patienttable as p, clinicaltable as c, dentalexamtable as de, remissiontable as r
where pe.periodonticsiiid=$id and pe.periodonticsiistatus!='new' and p.patientid=pe.patientid and de.patientid=r.patientid and
de.dentalid=r.patientdentalid and r.remissionid=pe.remissionid and c.clinicalid=r.clinicalid and
r.examined=pe.student and u.usernumber=r.examined";

	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");

		//MSGError("Unable to find the user in the database. Contact an admin now!");
		return null;
	}
	$a=clearsession($a);
	$ob=DBObservationInfo2($id,$a['remission']);
	if($ob!=null)
		$a=array_merge($a,$ob);
	return $a;
}
//funcion para evaluar
function DBEvaluate($desc, $evaluated, $accepted, $status, $record, $c=null){
	$cw = false;
	if($c == null) {
		$cw = true;
		$c = DBConnect();
		DBExec($c, "begin work", "DBEvaluate(begin)");
	}
	//DBExec($c, "lock table surgeryiitable", "DBEvaluate(lock)");
	$updatetime=time();

	$ret=2;
	$sql = "update surgeryiitable set surgeryiistatus='$status', ";
	if($status=='end')
		$sql.="enddatetime=$updatetime, ";
	$sql.="updatetime=$updatetime where surgeryiiid=$record";

	DBExec ($c, $sql, "DBEvaluate(update surgeryii)");
	//DBExec($c, "lock table observationtable", "DBEvaluate(lock)");
	$b=DBSurgeryiiInfo($record);
	$remission=$b['remissionid'];
	$sql = "update observationtable set observationdesc='$desc', observationevaluated='$evaluated', ".
	"observationaccepted='$accepted', updatetime=$updatetime where (fileid=$record and remissionid=$remission) and observationid=(select max(observationid) ".
	"from observationtable where fileid=$record and remissionid=$remission)";

	DBExec ($c, $sql, "DBEvaluate(update observation)");

	if($cw) {
			DBExec ($c, "commit work");
	}

	return $ret;
}
function DBEvaluatePeriodonticsii($desc, $evaluated, $accepted, $status, $record, $c=null){
	$cw = false;
	if($c == null) {
		$cw = true;
		$c = DBConnect();
		DBExec($c, "begin work", "DBEvaluatePeriodonticsii(begin)");
	}
	//DBExec($c, "lock table surgeryiitable", "DBEvaluate(lock)");
	$updatetime=time();

	$ret=2;
	$sql = "update periodonticsiitable set periodonticsiistatus='$status', ";
	if($status=='end')
		$sql.="enddatetime=$updatetime, ";
	$sql.="updatetime=$updatetime where periodonticsiiid=$record";

	DBExec ($c, $sql, "DBEvaluatePeriodonticsii(update periodonticsii)");
	//DBExec($c, "lock table observationtable", "DBEvaluate(lock)");
	$b=DBPeriodonticsiiInfo($record);
	$remission=$b['remissionid'];
	$sql = "update observationtable set observationdesc='$desc', observationevaluated='$evaluated', ".
	"observationaccepted='$accepted', updatetime=$updatetime where (fileid=$record and remissionid=$remission) and observationid=(select max(observationid) ".
	"from observationtable where fileid=$record and remissionid=$remission)";

	DBExec ($c, $sql, "DBEvaluatePeriodonticsii(update observation)");

	if($cw) {
			DBExec ($c, "commit work");
	}

	return $ret;
}
//funcion para sacar la informacion de remission cirugia
function DBRemissionSurgeryiiInfo($id, $c=null){

	$sql = "select su.remissionid as remission, p.patientid as patientid, p.patientfullname as patientfullname, p.patientgender as patientgender,
pa.patientage as patientage, pa.patientdirection as patientdirection, pa.patientlocation as patientlocation,
pa.patientprovenance as patientprovenance, pa.patientphone as patientphone, pa.patientcivilstatus as patientcivilstatus,
pa.patientoccupation as patientoccupation, pa.patientgmh as patientgmh, de.dentalfaces as dentalfaces,
de.dentalprofile as dentalprofile, de.dentalscars as dentalscars, de.dentalatm as dentalatm, de.dentalganglia as
dentalganglia, de.dentallips as dentallips, de.dentalulcerations as dentalulcerations, de.dentalcheilitis as
dentalcheilitis, de.dentalcommissures as dentalcommissures, de.dentaltongue as dentaltongue, de.dentalpiso as dentalpiso,
de.dentalencias as dentalencias, de.dentalmucosa as dentalmucosa, de.dentaltypeo as dentaltypeo, de.dentaltypep as
dentaltypep, de.dentalhygiene as dentalhygiene, de.lastconsult as lastconsult, de.motconsult as motconsult,
de.generalstatus as generalstatus, od.tr as tr, od.tl as tl, od.tlr as tlr, od.tll as tll, od.bl as bl, od.br as br,
od.bll as bll, od.blr as blr, od.description as odontogramdesc, od.draw as draw, u.userfullname as studentname, u.userci as studentci,
su.surgeryiidisease as surgeryiidisease, su.surgeryiiexam as surgeryiiexam, su.surgeryiidiagnosis as surgeryiidiagnosis,
su.surgeryiitreatment as surgeryiitreatment, su.surgeryiiprescriptions as surgeryiiprescriptions, su.surgeryiiindications as
surgeryiiindications, su.surgeryiievolution as surgeryiievolution, su.surgeryiiforecast as surgeryiiforecast,
su.surgeryiistatus as surgeryiistatus, su.teacher as teacher, su.surgeryiiid as surgeryiiid, su.clinicalid as clinical, su.updatetime as time, su.startdatetime as startdatetime, su.enddatetime as enddatetime
from remissiontable as r, patienttable as p, patientadmissiontable as pa,
dentalexamtable as de, odontogramtable as od, usertable as u, surgeryiitable as su
where su.surgeryiiid=$id and r.remissionid=su.remissionid and p.patientid=r.patientid and pa.patientadmissionid=r.patientadmissionid
and de.dentalid=r.patientdentalid and od.odontogramid=r.odontogramid and
u.usernumber=r.examined";
	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");

		//MSGError("Unable to find the user in the database. Contact an admin now!");
		return null;
	}
	//$a=clearpa($a);
	$ob=DBObservationInfo2($id,$a['remission']);
	if($ob!=null)
		$a=array_merge($a,$ob);
	$a=clearexam($a);
	$a=cleartreatment($a);
	return $a;
}
//funcion para crear un nuevo observacion
function DBNewSessionPeriodonticsii($param , $new=true, $c=null){

		if(isset($param['studentid']) && !isset($param['student'])) $param['student']=$param['studentid'];
		if(isset($param['teacherid']) && !isset($param['teacher'])) $param['teacher']=$param['teacherid'];
		//if(isset($param['surgeryiiid']) && !isset($param['surgery'])) $param['surgery']=$param['surgeryiiid'];
		if(isset($param['fileid']) && !isset($param['file'])) $param['file']=$param['fileid'];
		//if(isset($param['remissionid']) && !isset($param['remission'])) $param['remission']=$param['remissionid'];

		if(isset($param['sessiondesc']) && !isset($param['desc'])) $param['desc']=$param['sessiondesc'];
		if(isset($param['sessionevaluated']) && !isset($param['evaluated'])) $param['evaluated']=$param['sessionevaluated'];
		if(isset($param['sessiontype']) && !isset($param['type'])) $param['type']=$param['sessiontype'];
		if(isset($param['sessionfluor']) && !isset($param['fluor'])) $param['fluor']=$param['sessionfluor'];


		//$ac=array('student', 'surgery', 'teacher');
		$ac=array('student', 'file', 'teacher');
		$ac1=array('desc', 'evaluated', 'type', 'fluor');

		$typei['student']=-1;
		//$typei['surgery']=-1;
		$typei['file']=-1;
		//$typei['remission']=-1;
		$typei['teacherid']=-1;//admin


		foreach($ac as $key) {
			if(!isset($param[$key]) || $param[$key]=="") {
				MSGError("DBNewSessionPeriodonticsii param error: $key not found");
				return false;
			}
			if(isset($typei[$key]) && !is_numeric($param[$key])) {
				MSGError("DBNewSessionPeriodonticsii param error: $key is not numeric");
				return false;
			}
			$$key = myhtmlspecialchars($param[$key]);
		}

		$desc ='';
		$evaluated='f';
		$type='';
		$fluor='';
		$updatetime=-1;
		foreach($ac1 as $key) {
			if(isset($param[$key])) {
				$$key = myhtmlspecialchars($param[$key]);
				if(isset($typei[$key]) && !is_numeric($param[$key])) {
					MSGError("DBNewSessionPeriodonticsii param error: $key is not numeric");
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
			DBExec($c, "begin work", "DBNewSessionPeriodonticsii(begin)");
		}
		DBExec($c, "lock table sessionperiodonticsiitable", "DBNewSessionPeriodonticsii(lock)");
		$ret=2;
		if($new){
			$sql = "insert into sessionperiodonticsiitable(sessiondesc, sessionevaluated, sessiontype, sessionfluor, ".
						 "fileid, student, teacher) values ".
						 "('$desc', '$evaluated', '$type', '$fluor', $file, $student, $teacher)";
			DBExec ($c, $sql, "DBNewSessionPeriodonticsii(insert)");
			LOGLevel ("Ficha $file de periodoncia II crea un nueva session",2);
		}else{
			$sql = "update sessionperiodonticsiitable set sessiondesc='$desc', sessionevaluated='$evaluated', sessiontype='$type', sessionfluor='$fluor'".
						 " where fileid=$file";
			DBExec ($c, $sql, "DBNewSessionPeriodonticsii(update)");
			LOGLevel ("Ficha $file de periodoncia II actualizado session",2);
		}




		if($cw) DBExec($c, "commit work");
		return $ret;
}
//para modificacion de sesiones
function DBUpdateSessionPeriodonticsii($param, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBUpdateSessionPeriodonticsii(begin)");
		}
		DBExec($c, "lock table periodonticsiitable", "DBUpdateSessionPeriodonticsii(lock)");

		$ret=2;
		$time=time();
		$treatment=$param['treatment'];
		if(isset($param['ficha']) && is_numeric($param['ficha'])){
			$ficha=$param['ficha'];
			if(isset($param['prophylaxis']) && $param['prophylaxis']!=''){
				$data=$param['prophylaxis'];
				$sql = "update periodonticsiitable set periodonticsiiprophylaxis='$data', periodonticsiitreatment='$treatment' where periodonticsiiid=$ficha";
				DBExec ($c, $sql, "DBUpdateSessionPeriodonticsii(update)");

			}
			if(isset($param['tartarectomy']) && $param['tartarectomy']!=''){
				$data=$param['tartarectomy'];
				$sql = "update periodonticsiitable set periodonticsiitartarectomy='$data', periodonticsiitreatment='$treatment' where periodonticsiiid=$ficha";
				DBExec ($c, $sql, "DBUpdateSessionPeriodonticsii(update)");
			}
		}else{
			echo "No es numerico el id";
		}

		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}
?>
