<?
set_time_limit(0);
$host="";
$base="";
$user="";
$pass="";
$port="";
if(!($conn = pg_connect("host=$host dbname=$base port=$port user=$user password=$pass"))) {
 echo "Erro ao conectar...\n\n";
 exit;
}else{
 echo "conectado...\n\n";
}
system("clear");
echo "Iniciando ajustes...\n\n";
pg_exec("begin");
$erro = false;
$codalunosexc = "";
$sep = "";
$sql = "SELECT count(*),ed56_i_aluno
        FROM alunocurso
        GROUP BY ed56_i_aluno
        HAVING count(*) > 1
        ORDER BY count desc
       ";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
for($r=0;$r<$linhas;$r++){
 $codigoaluno = pg_result($result,$r,'ed56_i_aluno');
 $sql1 = "SELECT ed57_i_calendario,ed52_i_ano,ed11_c_descr,ed10_c_descr
          FROM matricula
           inner join turma on ed57_i_codigo = ed60_i_turma
           inner join calendario on ed52_i_codigo = ed57_i_calendario
           inner join serie on ed11_i_codigo = ed57_i_serie
           inner join ensino on ed10_i_codigo = ed11_i_ensino
          WHERE ed60_i_aluno = $codigoaluno
          ORDER BY ed52_i_ano DESC,ed52_d_inicio desc
          LIMIT 1
         ";
 $result1 = pg_query($sql1);
 $linhas1 = pg_num_rows($result1);
 if($linhas1>0){
  $cal_ultima_matricula = pg_result($result1,0,'ed57_i_calendario');
 }else{
  $cal_ultima_matricula = 0;
 }
 $sql2 = "SELECT *
          FROM alunocurso
           inner join calendario on ed52_i_codigo = ed56_i_calendario
           inner join alunopossib on ed79_i_alunocurso = ed56_i_codigo
           inner join serie on ed11_i_codigo = ed79_i_serie
           inner join ensino on ed10_i_codigo = ed11_i_ensino
          WHERE ed56_i_aluno = $codigoaluno
          ORDER BY ed52_i_ano,ed52_d_inicio
         ";
 $result2 = pg_query($sql2);
 $linhas2 = pg_num_rows($result2);
 $exclusao = "";
 $sepexc = "";
 for($t=0;$t<$linhas2;$t++){
  $codalunocurso = trim(pg_result($result2,$t,'ed56_i_codigo'));
  $situacaoaluno = trim(pg_result($result2,$t,'ed56_c_situacao'));
  $calendarioaluno = pg_result($result2,$t,'ed56_i_calendario');
  $anoaluno = pg_result($result2,$t,'ed52_i_ano');
  $descrcalaluno = pg_result($result2,$t,'ed52_c_descr');
  $seriealuno = trim(pg_result($result2,$t,'ed11_c_descr'));
  $ensinoaluno = trim(pg_result($result2,$t,'ed10_c_descr'));
  $seqserie = trim(pg_result($result2,$t,'ed11_i_sequencia'));
  if(trim($situacaoaluno=="CANDIDATO")){
   $sql3 = "DELETE FROM alunopossib WHERE ed79_i_alunocurso = $codalunocurso";
   $result3 = pg_query($sql3);
   $sql4 = "DELETE FROM alunocurso WHERE ed56_i_codigo = $codalunocurso";
   $result4 = pg_query($sql4);
   $codalunosexc .= $sep.$codigoaluno;
   $sep = ",";
   echo ($r+1)."--> EXC - $codigoaluno | $situacaoaluno | $descrcalaluno ($seriealuno - $ensinoaluno)\n";
   $exclusao .= $sepexc."EXC";
   $sepexc = "|";
  }else{
   if($cal_ultima_matricula!=$calendarioaluno){
    $sql3 = "DELETE FROM alunopossib WHERE ed79_i_alunocurso = $codalunocurso";
    $result3 = pg_query($sql3);
    $sql4 = "DELETE FROM alunocurso WHERE ed56_i_codigo = $codalunocurso";
    $result4 = pg_query($sql4);
    $codalunosexc .= $sep.$codigoaluno;
    $sep = ",";
    echo ($r+1)."--> EXC - $codigoaluno | $situacaoaluno | $descrcalaluno ($seriealuno - $ensinoaluno)\n";
    $exclusao .= $sepexc."EXC";
    $sepexc = "|";
   }elseif($cal_ultima_matricula==$calendarioaluno && trim($situacaoaluno=="ENCERRADO") && $seqserie<4){
    $sql3 = "DELETE FROM alunopossib WHERE ed79_i_alunocurso = $codalunocurso";
    $result3 = pg_query($sql3);
    $sql4 = "DELETE FROM alunocurso WHERE ed56_i_codigo = $codalunocurso";
    $result4 = pg_query($sql4);
    $codalunosexc .= $sep.$codigoaluno;
    $sep = ",";
    echo ($r+1)."--> EXC - $codigoaluno | $situacaoaluno | $descrcalaluno ($seriealuno - $ensinoaluno)\n";
    $exclusao .= $sepexc."EXC";
    $sepexc = "|";
   }elseif($cal_ultima_matricula==$calendarioaluno && trim($situacaoaluno=="TRANSFERIDO FORA")){
    $sql3 = "DELETE FROM alunopossib WHERE ed79_i_alunocurso = $codalunocurso";
    $result3 = pg_query($sql3);
    $sql4 = "DELETE FROM alunocurso WHERE ed56_i_codigo = $codalunocurso";
    $result4 = pg_query($sql4);
    $codalunosexc .= $sep.$codigoaluno;
    $sep = ",";
    echo ($r+1)."--> EXC - $codigoaluno | $situacaoaluno | $descrcalaluno ($seriealuno - $ensinoaluno)\n";
    $exclusao .= $sepexc."EXC";
    $sepexc = "|";
   }else{
    echo ($r+1)."--> NAO - $codigoaluno | $situacaoaluno | $descrcalaluno ($seriealuno - $ensinoaluno)\n";
    $exclusao .= $sepexc."NAO";
    $sepexc = "|";
   }
  }
 }
 echo "------------------------------------------------------------------------\n";
}
$sql5 = "DROP INDEX alunocurso_esc_alu_base_cal_in";
$result5 = pg_query($sql5);
$sql6 = "CREATE UNIQUE INDEX alunocurso_aluno_in ON alunocurso(ed56_i_aluno)";
$result6 = pg_query($sql6);

echo "Finalizado...\n\n";

pg_exec("commit");
?>