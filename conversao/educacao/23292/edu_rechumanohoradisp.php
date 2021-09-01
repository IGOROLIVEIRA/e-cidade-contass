<?
set_time_limit(0);
include(__DIR__ . "/../../../libs/db_conn.php");

/*
$DB_SERVIDOR = "127.0.0.1";
$DB_BASE     = "bage";
$DB_USUARIO  = "postgres";
$DB_SENHA    = "";
$DB_PORTA    = "5432";
*/

if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))) {
 echo "Erro ao conectar origem...\n\n";
 exit;
}else{
 echo "conectado...\n\n";
}
pg_query($conn,"select fc_startsession()");
function Progresso($linha,$total,$dado1,$dado2,$titulo){
 $linha++;
 $percent = ($linha/$total)*100;
 $percorrido = floor($percent);
 $restante = 100-$percorrido;
 $tracos = "";
 for($t=0;$t<$percorrido;$t++){
  $tracos .= "#";
 }
 $brancos = "";
 for($t=0;$t<$restante;$t++){
  $brancos .= ".";
 }
 echo " $titulo";
 echo " $linha de $total registros.\n";
 echo " [".$tracos.$brancos."] ".number_format($percent,2,".",".")."%\n";
 if($titulo!=" PROGRESSÃO TOTAL DA TAREFA"){
  echo " ---> ".trim($dado1)." -- ".trim($dado2)."\n";
 }
}

echo " ->Iniciando processo...\n\n";
sleep(1);
system("clear");
pg_exec("begin");
$sql = "SELECT count(*),ed33_i_rechumano,ed33_i_diasemana,ed33_i_periodo,ed17_h_inicio,ed17_h_fim,ed17_i_escola
        FROM rechumanohoradisp
         inner join periodoescola on ed17_i_codigo = ed33_i_periodo
        GROUP BY ed33_i_rechumano,ed33_i_diasemana,ed33_i_periodo,ed17_h_inicio,ed17_h_fim,ed17_i_escola
        HAVING count(*) > 1
        ORDER BY count desc,ed33_i_rechumano,ed33_i_periodo
       ";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
$erro = false;
for($x=0;$x<$linhas;$x++){
 $rechumano  = trim(pg_result($result,$x,'ed33_i_rechumano'));
 $diasemana  = trim(pg_result($result,$x,'ed33_i_diasemana'));
 $periodo    = trim(pg_result($result,$x,'ed33_i_periodo'));
 $sql2 = "SELECT ed33_i_codigo
          FROM rechumanohoradisp 
          WHERE ed33_i_rechumano = $rechumano
          AND ed33_i_diasemana = $diasemana
          AND ed33_i_periodo = $periodo
         ";
 $result2 = pg_query($sql2);
 $cod_rhdisp = trim(pg_result($result2,0,'ed33_i_codigo'));
 $sql3 = "DELETE FROM rechumanohoradisp WHERE ed33_i_codigo = $cod_rhdisp";
 $result3 = pg_query($sql3);
 if($result3==false){
  $erro = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,$linhas,$cod_rhdisp,$rechumano," PROGRESSÃO:");
 }
}
$sql = "SELECT count(*),ed58_i_regencia,ed58_i_rechumano,ed58_i_diasemana,ed58_i_periodo,ed17_h_inicio,ed17_h_fim,ed17_i_escola
	FROM regenciahorario
	 inner join periodoescola on ed17_i_codigo = ed58_i_periodo
	GROUP BY ed58_i_regencia,ed58_i_rechumano,ed58_i_diasemana,ed58_i_periodo,ed17_h_inicio,ed17_h_fim,ed17_i_escola
	HAVING count(*) > 1
	ORDER BY count desc,ed58_i_rechumano,ed58_i_periodo
       ";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
$erro = false;
for($x=0;$x<$linhas;$x++){
 $regencia   = trim(pg_result($result,$x,'ed58_i_regencia'));
 $rechumano  = trim(pg_result($result,$x,'ed58_i_rechumano'));
 $diasemana  = trim(pg_result($result,$x,'ed58_i_diasemana'));
 $periodo    = trim(pg_result($result,$x,'ed58_i_periodo'));
 $sql2 = "SELECT ed58_i_codigo
          FROM regenciahorario
          WHERE ed58_i_rechumano = $rechumano
          AND ed58_i_diasemana = $diasemana
          AND ed58_i_periodo = $periodo
          AND ed58_i_regencia = $regencia
         ";
 $result2 = pg_query($sql2);
 $cod_reghora = trim(pg_result($result2,0,'ed58_i_codigo'));
 $sql3 = "DELETE FROM regenciahorario WHERE ed58_i_codigo = $cod_reghora";
 $result3 = pg_query($sql3);
 if($result3==false){
  $erro = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,$linhas,$cod_reghora,$rechumano," PROGRESSÃO:");
 }
}
$result4 = pg_query("CREATE UNIQUE INDEX regenciahorario_reg_dia_periodo_rh_in ON regenciahorario(ed58_i_regencia,ed58_i_diasemana,ed58_i_periodo,ed58_i_rechumano)");
$result5 = pg_query("CREATE UNIQUE INDEX rechumanohoradisp_rh_dia_periodo_in ON rechumanohoradisp(ed33_i_rechumano,ed33_i_diasemana,ed33_i_periodo)");
if($result4==false || $result5==false){
  $erro = true;
  break;
}
if($erro==true){
 echo "\n\n ERRO: ".pg_errormessage()."\n SQL: ".$sql2."\n\n";
 pg_exec("rollback");
 exit;
}else{
 echo "  \nProcesso Concluído\n\n";
 pg_exec("commit");
}
?>
