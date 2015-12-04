<?
set_time_limit(0);

//************************************************/
$dbname   = "auto_ale_2107";
$dbhost   = "192.168.0.33";

//***********************************************/

$conn = pg_connect("dbname=$dbname user=postgres host=$dbhost") or die('ERRO AO CONECTAR NA BASE DE DADOS !!');

pg_query("BEGIN;");
	$result=pg_exec("select y08_codigo,y08_codproc from aidof;");
	for($w=0;$w<pg_numrows($result);$w++){
		$y08_codigo=pg_result($result,$w,"y08_codigo");
		$y08_codproc=pg_result($result,$w,"y08_codproc");
		$result_prot=pg_query("select * from protprocesso where p58_codproc=$y08_codproc");
		if (pg_numrows($result_prot)>0){
			$insert=pg_query("insert into aidofproc values (nextval('aidofproc_y02_codigo_seq'),$y08_codigo,$y08_codproc)");
		}
	}
pg_query("COMMIT;");
?>
