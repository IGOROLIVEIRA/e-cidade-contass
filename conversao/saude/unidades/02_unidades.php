<?

set_time_limit(0);

require("db_fieldsmemory.php");
require("db_conn.php");

if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))) {
  echo "erro ao conectar...\n";
  exit;
}



system("clear");

pg_exec("delete from  sau_esferaadmin" );
pg_exec("delete from  sau_atividadeensino");
pg_exec("delete from  sau_natorg");
pg_exec("delete from  sau_nivelhier");
pg_exec("delete from  sau_tipounidade"); 
pg_exec("delete from  sau_turnoatend");
pg_exec("delete from  sau_retentributo");
pg_exec("delete from sau_nivelhier");
pg_exec("delete from sau_atendprest ");
pg_exec("delete from sau_tipoatend ");
pg_exec("delete from sau_convenio");
pg_exec("delete from sau_fluxocliente");


pg_exec("delete from sau_orgaoemissor");
pg_exec("delete from sau_modvinculo");
pg_exec("delete from sau_tpmodvinculo");
pg_exec("delete from sau_subtpmodvinculo");



echo "nfces006 \n";
$sql1 = "INSERT INTO sau_esferaadmin select to_number(cod_esfadm, '99'), descricao from nfces006 ";  
$result1 = pg_exec($sql1);// or die( " >>>> $x <<<< $sql1  - \n".pg_errormessage()."\n" ) ;


echo"nfces007 \n";
$sql1 = "INSERT INTO sau_atividadeensino select to_number(cod_ativid, '99'), descricao from nfces007 ";  
$result1 = pg_exec($sql1);// or die( " >>>> $x <<<< $sql1  - \n".pg_errormessage()."\n" ) ;


echo"nfces008 \n";
$sql1 = "INSERT INTO sau_natorg select to_number(cod_natorg, '99'), descricao from nfces008 ";  
$result1 = pg_exec($sql1);// or die( " >>>>  <<<< $sql1  - \n".pg_errormessage()."\n" ) ;


echo"nfces009\n ";
$sql1 = "INSERT INTO sau_nivelhier select to_number(codnivhier, '99'), descricao from nfces009 ";  
$result1 = pg_exec($sql1);// or die( " >>>>  <<<< $sql1  - \n".pg_errormessage()."\n" ) ;


echo"nfces010 \n";
$sql1 = "INSERT INTO sau_tipounidade select to_number(tp_unid_id, '99'), descricao from nfces010 ";  
$result1 = pg_exec($sql1);// or die( " >>>>  <<<< $sql1  - \n".pg_errormessage()."\n" ) ;


echo"nfces011 \n";
$sql1 = "INSERT INTO sau_turnoatend select to_number(cod_turnat, '99'), descricao from nfces011 ";  
$result1 = pg_exec($sql1);// or die( " >>>>  <<<< $sql1  - \n".pg_errormessage()."\n" ) ;


echo"nfces030 \n";
$sql1 = "INSERT INTO sau_retentributo select to_number(codret, '99'), situacao from nfces030 ";  
$result1 = pg_exec($sql1);// or die( " >>>>  <<<< $sql1  - \n".pg_errormessage()."\n" ) ;


echo"nfces004 \n";
$sql1 = "INSERT INTO sau_atendprest select to_number(codatprest, '99'), descricao from nfces004 ";  
$result1 = pg_exec($sql1);// or die( " >>>>  <<<< $sql1  - \n".pg_errormessage()."\n" ) ;


echo"nfces012 \n";
$sql1 = "INSERT INTO sau_tipoatend select to_number(cod_prog, '99'), descricao, to_number(tp_prog,'9') from nfces012 ";  
$result1 = pg_exec($sql1);// or die( " >>>>  <<<< $sql1  - \n".pg_errormessage()."\n" ) ;


echo"nfces003 \n";
$sql1 = "INSERT INTO sau_convenio select to_number(cod_conven, '99'), descricao from nfces003 ";  
$result1 = pg_exec($sql1);// or die( " >>>>  <<<< $sql1  - \n".pg_errormessage()."\n" ) ;


echo"nfces033 \n";
$sql1 = "INSERT INTO sau_orgaoemissor select to_number(codorgemis, '99'), descricao from nfces033";  
$result1 = pg_exec($sql1);// or die( " >>>>  <<<< $sql1  - \n".pg_errormessage()."\n" ) ;


echo"nfces056 \n";
$sql1 = "INSERT INTO sau_modvinculo  select to_number(CD_VINCULACAO, '99'), DS_VINCULACAO from nfces056";  
$result1 = pg_exec($sql1);// or die( " >>>>  <<<< $sql1  - \n".pg_errormessage()."\n" ) ;


echo"nfces057 \n";
$sql1 = "INSERT INTO sau_tpmodvinculo select to_number(CD_VINCULACAO, '99'), to_number(TP_VINCULO, '99'), DS_VINCULO, null from nfces057";  
$result1 = pg_exec($sql1);// or die( " >>>>  <<<< $sql1  - \n".pg_errormessage()."\n" ) ;


echo"nfces058 \n";
$sql1 = "INSERT INTO sau_subtpmodvinculo select to_number(CD_VINCULACAO, '99'), 
                                             to_number(TP_VINCULO, '99'), 
					     to_number(TP_SUBVINCULO, '99' ),
					     DS_SUBVINCULO from nfces058";  
$result1 = pg_exec($sql1);// or die( " >>>>  <<<< $sql1  - \n".pg_errormessage()."\n" ) ;

echo"nfces002 \n";
$sql1 = "INSERT INTO sau_fluxocliente select to_number(COD_CLIENT, '99'), DESCRICAO from nfces002";  
$result1 = pg_exec($sql1);// or die( " >>>>  <<<< $sql1  - \n".pg_errormessage()."\n" ) ;


?>

