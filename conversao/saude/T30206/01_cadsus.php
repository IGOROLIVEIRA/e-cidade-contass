<?
$HTTP_SESSION_VARS["DB_id_usuario"] = 1;
$HTTP_SESSION_VARS["DB_datausu"]    = date("Y-m-d");
$HTTP_SESSION_VARS["DB_acessado"]   = 1;

require ("conn.php");
include(__DIR__ . "/../../../sau4_importsus002.php");
//if(extension_loaded('interbase')){
    atualiza_cadsus(0,$conn,null,$DB_SERVIDOR,$DB_BASE,$DB_PORTA,$DB_USUARIO,$DB_SENHA);
//}else{
//	echo"Firebird não instalado! Contate o administrador para mais informações";
//}
?>
