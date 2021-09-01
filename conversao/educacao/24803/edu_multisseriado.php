<?
set_time_limit(0);
/*$DB_SERVIDOR="127.0.0.1";
$DB_BASE="bage";
$DB_USUARIO="postgres";
$DB_SENHA="";
$DB_PORTA="5432";*/
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

///////////////Insere na tabela serieregimemat
$sql = "SELECT ed11_i_codigo,ed11_i_sequencia FROM serie ORDER BY ed11_i_ensino,ed11_i_sequencia";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
$erro = false;
for($x=0;$x<$linhas;$x++){
 $ed11_i_codigo = trim(pg_result($result,$x,0));
 $ed11_i_sequencia = trim(pg_result($result,$x,1));
 $sql2 = "INSERT INTO serieregimemat VALUES(nextval('serieregimemat_ed223_i_codigo_seq'),$ed11_i_codigo,1,null,$ed11_i_sequencia)";
 $result2 = pg_query($sql2);
 if($result2==false){
  $erro = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,$linhas,$ed11_i_codigo,$ed11_i_sequencia," PROGRESSÃO SERIEREGIMEMAT:");
 }
}
///////////////Deleta bases sem vinculo com escolas
$sql = "select ed31_i_codigo,ed31_c_descr from base left join escolabase on ed77_i_base = ed31_i_codigo where ed77_i_base is null";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
$erro1 = false;
for($x=0;$x<$linhas;$x++){
 $ed31_i_codigo = trim(pg_result($result,$x,0));
 $ed31_c_descr = trim(pg_result($result,$x,1));
 $result1 = pg_query("DELETE FROM basemps WHERE ed34_i_base = $ed31_i_codigo;");
 $result2 = pg_query("DELETE FROM basech WHERE ed88_i_codigo = $ed31_i_codigo;");
 $result3 = pg_query("DELETE FROM basediscglob WHERE ed89_i_codigo = $ed31_i_codigo;");
 $result4 = pg_query("DELETE FROM baseserie WHERE ed87_i_codigo = $ed31_i_codigo;");
 $result5 = pg_query("DELETE FROM escolabase WHERE ed77_i_base = $ed31_i_codigo;");
 $result6 = pg_query("UPDATE escolabase SET ed77_i_basecont = null WHERE ed77_i_basecont = $ed31_i_codigo;");
 $result7 = pg_query("DELETE FROM atestvaga WHERE ed102_i_base = $ed31_i_codigo;");
 $result8 = pg_query("DELETE FROM base WHERE ed31_i_codigo = $ed31_i_codigo;");
 if($result1==false || $result2==false || $result3==false || $result4==false || $result5==false || $result6==false || $result7==false || $result8==false){
  $erro1 = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,$linhas,$ed31_i_codigo,$ed31_c_descr," PROGRESSÃO BASES:");
 }
}

///////////////Insere na tabela turmaserie
$sql = "select ed57_i_codigo,ed57_i_serie from turma";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
$erro2 = false;
for($x=0;$x<$linhas;$x++){
 $ed57_i_codigo = trim(pg_result($result,$x,0));
 $ed57_i_serie = trim(pg_result($result,$x,1));
 $result1 = pg_query("SELECT ed223_i_codigo FROM serieregimemat WHERE ed223_i_serie = $ed57_i_serie;");
 $ed223_i_codigo = trim(pg_result($result1,0,0));
 $sql2 = "INSERT INTO turmaserieregimemat VALUES(nextval('turmaserieregimemat_ed220_i_codigo_seq'),$ed57_i_codigo,$ed223_i_codigo,'S')";
 $result2 = pg_query($sql2);
 if($result2==false){
  $erro2 = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,$linhas,$ed57_i_codigo,$ed57_i_serie," PROGRESSÃO TURMASERIE:");
 }
}

///////////////Insere na tabela matriculaserie
$sql = "select ed60_i_codigo,ed60_i_turma from matricula";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
$erro3 = false;
for($x=0;$x<$linhas;$x++){
 $ed60_i_codigo = trim(pg_result($result,$x,0));
 $ed60_i_turma = trim(pg_result($result,$x,1));
 $result1 = pg_query("SELECT ed223_i_serie FROM turmaserieregimemat
                       inner join serieregimemat on ed223_i_codigo = ed220_i_serieregimemat
                      WHERE ed220_i_turma = $ed60_i_turma;");
 $ed223_i_serie = trim(pg_result($result1,0,0));
 $sql2 = "INSERT INTO matriculaserie VALUES (nextval('matriculaserie_ed221_i_codigo_seq'),$ed60_i_codigo,$ed223_i_serie,'S')";
 $result2 = pg_query($sql2);
 if($result2==false){
  $erro3 = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,$linhas,$ed60_i_codigo,$ed223_i_serie," PROGRESSÃO MATRICULASERIE:");
 }
}
///////////////Update Turma(tipo e codigo censo) e Regencia(serie)
$sql = "select ed57_i_codigo from turma";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
$erro4 = false;
for($x=0;$x<$linhas;$x++){
 $ed57_i_codigo = trim(pg_result($result,$x,0));
 $result1 = pg_query("SELECT ed223_i_serie,ed11_i_codcenso
                       FROM turmaserieregimemat
                       inner join serieregimemat on ed223_i_codigo = ed220_i_serieregimemat
                       inner join serie on ed11_i_codigo = ed223_i_serie
                      WHERE ed220_i_turma = $ed57_i_codigo;");
 $ed223_i_serie = trim(pg_result($result1,0,0));
 $ed11_i_codcenso = trim(pg_result($result1,0,1));
 $sql2 = "UPDATE turma SET ed57_i_tipoturma = 1, ed57_i_censoetapa = $ed11_i_codcenso WHERE ed57_i_codigo = $ed57_i_codigo";
 $result2 = pg_query($sql2);
 $sql3 = "UPDATE regencia SET ed59_i_serie = $ed223_i_serie WHERE ed59_i_turma = $ed57_i_codigo";
 $result3 = pg_query($sql3);
 if($result2==false || $result3==false){
  $erro4 = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,$linhas,$ed57_i_codigo,$ed223_i_serie," PROGRESSÃO TURMA E REGENCIA:");
 }
}

  
if($erro==true || $erro1==true || $erro2==true || $erro3==true || $erro4==true){
 echo "\n\n ERRO: ".pg_errormessage()."\n SQL: ".$sql2."\n\n";
 pg_exec("rollback");
 exit;
}else{
 $result = pg_query("ALTER TABLE base DROP ed31_c_matricula");
 $result = pg_query("ALTER TABLE turma DROP ed57_i_disciplina");
 $result = pg_query("ALTER TABLE turma DROP ed57_i_serie");
 $result = pg_query("ALTER TABLE turma DROP ed57_c_regime");
 echo "  \nProcesso Concluído\n\n";
 pg_exec("commit");
}
?>