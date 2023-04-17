<?php

//funcion para eliminar la tabla de cirugia
function DBDropClinicaTable() {
    //conexcion de la base de datos..
	 $c = DBConnect();

	 $r = DBExec($c, "drop table \"usertable\"", "DBDropUserTable(drop table)");

}
function DBCreateUserTable() {
	 $c = DBConnect();
	 $conf = globalconf();
	 if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
	 $r = DBExec($c, "
CREATE TABLE \"usertable\" (
				\"usernumber\" int4 NOT NULL,                     -- (id de usuario)
				\"userci\" int4 NOT NULL,													-- (ci de usuario)
				\"username\" varchar(20) NOT NULL,                -- (nombre do usuario)
        \"userfullname\" varchar(200) NOT NULL,           -- (nombre completo de usuario)
        \"userdesc\" varchar(300),                        -- (descripcion del usuario etc)
        \"usertype\" varchar(20) NOT NULL,                -- (admin, admission, teacher, student)
        \"userenabled\" bool DEFAULT 't' NOT NULL,        -- (usuario activo)
        \"usermultilogin\" bool DEFAULT 'f' NOT NULL,     -- (usuario puede loguearse multiples veces)
        \"userpassword\" varchar(200) DEFAULT '',         -- (password)
        \"userip\" varchar(300),                          -- (ip de ult accesso)
        \"userlastlogin\" int4,                           -- (ultima session)
        \"usersession\" varchar(50) DEFAULT '',           -- (session de usuario)
        \"usersessionextra\" varchar(50) DEFAULT '',      -- (dos session de usuario)
        \"userlastlogout\" int4,                          -- (ultima vez logout)
        \"userpermitip\" varchar(300),                    -- (acceso de ip permitido)
        \"userinfo\" varchar(300) DEFAULT '',
        \"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
        CONSTRAINT \"user_pkey\" PRIMARY KEY (\"usernumber\")
)", "DBCreateUserTable(create table)");
	$r = DBExec($c, "REVOKE ALL ON \"usertable\" FROM PUBLIC", "DBCreateUserTable(revoke public)");
	$r = DBExec($c, "GRANT ALL ON \"usertable\" TO \"".$conf["dbuser"]."\"", "DBCreateUserTable(grant sihcouser)");
	$r = DBExec($c, "CREATE UNIQUE INDEX \"user_index\" ON \"usertable\" USING btree ".
	     "(\"usernumber\" int4_ops)",
	     "DBCreateUserTable(create user_index)");
	$r = DBExec($c, "CREATE UNIQUE INDEX \"user_index2\" ON \"usertable\" USING btree ".
	     "(\"userci\" int4_ops, \"username\" varchar_ops)",
	     "DBCreateUserTable(create user_index2)");
}










//eof
?>
