<?
set_time_limit(0);
//$DB_SERVIDOR="localhost";
//$DB_BASE="auto_sapiranga_20091227_v_2_2_16";
//$DB_USUARIO="postgres";
//$DB_SENHA="";
//$DB_PORTA="5434";
include(__DIR__ . "/../../../libs/db_conn.php");
if(!($conn = pg_connect("host='$DB_SERVIDOR' dbname='$DB_BASE' user='$DB_USUARIO' password='$DB_SENHA' port='$DB_PORTA'"))) {
 echo "Erro ao conectar...\n\n";
 exit;
}else{
 echo "conectado...\n\n";
}
pg_query($conn, "SELECT fc_startsession()");

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
system("clear");

echo " ->Iniciando processo...\n\n";
sleep(1);
pg_exec("begin");

$sql = "select count(*) as duplicado,
               ed65_i_historicomps,
               (select count(*)
                from regencia
                 inner join turma on ed57_i_codigo = ed59_i_turma
                 inner join calendario on ed52_i_codigo = ed57_i_calendario
                where ed52_i_ano = ed62_i_anoref
                and ed57_i_serie = ed62_i_serie
                and trim(ed57_c_descr) = trim(ed62_i_turma)
                and ed57_i_escola = ed62_i_escola
                and ed59_c_condicao = 'OB'
               ) as qtdregencia
        from histmpsdisc
         inner join historicomps on ed62_i_codigo = ed65_i_historicomps
         inner join historico on ed61_i_codigo = ed62_i_historico
        group by ed65_i_historicomps,ed62_i_anoref,ed62_i_serie,ed62_i_turma,ed62_i_escola
        having count(*) > (select count(*)
                           from regencia
                           inner join turma on ed57_i_codigo = ed59_i_turma
                           inner join calendario on ed52_i_codigo = ed57_i_calendario
                           where ed52_i_ano = ed62_i_anoref
                           and ed57_i_serie = ed62_i_serie
                           and trim(ed57_c_descr) = trim(ed62_i_turma)
                           and ed57_i_escola = ed62_i_escola
                           and ed59_c_condicao = 'OB'
                          )
        order by duplicado desc
        ";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
$erro = false;
for($x=0;$x<$linhas;$x++){
 $duplicado = pg_result($result,$x,'duplicado');
 $ed65_i_historicomps = pg_result($result,$x,'ed65_i_historicomps');
 $qtdregencia = pg_result($result,$x,'qtdregencia');
 if($qtdregencia>0 && $duplicado>$qtdregencia){
  $sql1 = "SELECT * FROM histmpsdisc WHERE ed65_i_historicomps = $ed65_i_historicomps ORDER BY ed65_i_codigo";
  $result1 = pg_query($sql1);
  $linhas1 = pg_num_rows($result1);
  for($y=0;$y<$linhas1;$y++){
   if($y>=$qtdregencia){
    $ed65_i_codigo = pg_result($result1,$y,'ed65_i_codigo');
    $result2 = pg_query("DELETE FROM histmpsdisc WHERE ed65_i_codigo = $ed65_i_codigo");
    if($result2==false){
     $erro = true;
     break;
    }
   }
  }
 }
 system("clear");
 echo Progresso($x,$linhas,$ed65_i_historicomps,$duplicado." <-> ".$qtdregencia," PROGRESSÃO HISTORICO:");
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