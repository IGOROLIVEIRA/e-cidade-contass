<?
set_time_limit(0);
$host="localhost";
$base="auto_bage_20081112_v84";
$user="postgres";
$pass="";
$port="5434";
if(!($conn = pg_connect("host=$host dbname=$base port=$port user=$user password=$pass"))) {
 echo "Erro ao conectar...\n\n";
 exit;
}else{
 echo "conectado...\n\n";
}

system("clear");
$erro = false;
$rematr = 0;
$matr = 0;
$codrematr = "";
$codmatr =  "";
$seprematr = "";
$sepmatr = "";
echo "Selecionando matrículas...\n\n";
$sql = "SELECT matricula.ed60_i_codigo,
	       matricula.ed60_i_aluno,
	       matricula.ed60_c_rfanterior,
	       matricula.ed60_c_situacao,
	       matricula.ed60_d_datamatricula,
	       matricula.ed60_i_turma as turmaatual,
	       matricula.ed60_i_turmaant as turmaant,
	       turma.ed57_i_escola as escolaatual,
	       turmaant.ed57_i_escola as escolaant
	FROM matricula
         inner join turma on turma.ed57_i_codigo = matricula.ed60_i_turma
         left join turma as turmaant on turmaant.ed57_i_codigo = matricula.ed60_i_turmaant
        ORDER BY ed60_d_datamatricula desc
        ";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
for($r=0;$r<$linhas;$r++){
 if($r==0){
  echo "Iniciando for $linhas registros...\n\n";
  sleep(2);
 }
 $matricula = pg_result($result,$r,'ed60_i_codigo');
 $aluno = pg_result($result,$r,'ed60_i_aluno');
 $rfanterior = trim(pg_result($result,$r,'ed60_c_rfanterior'));
 $situacao = trim(pg_result($result,$r,'ed60_c_situacao'));
 $datamatricula = pg_result($result,$r,'ed60_d_datamatricula');
 $turmaatual = pg_result($result,$r,'turmaatual');
 $turmaant = pg_result($result,$r,'turmaant');
 $escolaatual = pg_result($result,$r,'escolaatual');
 $escolaant = pg_result($result,$r,'escolaant');
 if($turmaant=="" || $turmaant==null){
  $retorno = "N";
 }else{
  if($escolaant==$escolaatual){
   $retorno = "R";
  }else{
   $retorno = "N";
  }
 }
 if($retorno=="R"){
  $sql1 = "SELECT ed101_i_codigo FROM trocaserie
           WHERE ed101_i_aluno = $aluno
	   AND ed101_i_turmadest = $turmaatual
          ";
  $result1 = pg_query($sql1);
  $linhas1 = pg_num_rows($result1);
  if($linhas1>0){
   $retorno = "N";
  }
  $sql2 = "SELECT ed103_i_codigo FROM transfescolarede
            inner join atestvaga on ed102_i_codigo = ed103_i_atestvaga
           WHERE ed102_i_escola = $escolaatual
	   AND ed102_i_aluno = $aluno
          ";
  $result2 = pg_query($sql2);
  $linhas2 = pg_num_rows($result2);
  if($linhas2>0){
   $retorno = "N";
  }
  $sql3 = "SELECT ed104_i_codigo FROM transfescolafora
           WHERE ed104_i_escoladestino = $escolaatual
	   AND ed104_i_aluno = $aluno
          ";
  $result3 = pg_query($sql3);
  $linhas3 = pg_num_rows($result3);
  if($linhas3>0){
   $retorno = "N";
  }
  $sql4 = "SELECT ed69_i_codigo FROM alunotransfturma
            inner join matricula on ed60_i_codigo = ed69_i_matricula
           WHERE ed69_i_turmadestino = $turmaatual
           AND ed60_i_aluno = $aluno
          ";
  $result4 = pg_query($sql4);
  $linhas4 = pg_num_rows($result4);
  if($linhas4>0){
   if($rfanterior==""){
    $retorno = "N";
   }
  }
 }
 if($retorno=="R"){
  $rematr++;
  $codrematr .= $seprematr.$matricula;
  $seprematr = ",";
 }else{
  $matr++;
  $codmatr .= $sepmatr.$matricula;
  $sepmatr = ",";
 }
 echo "Registro: ".$r."---> Aluno ".$aluno ."\n";
}
if($linhas>0){
 if(trim($codrematr)!=""){
  echo "\n UPDATE em Rematriculados \n\n";
  $sql5 = "UPDATE matricula SET ed60_c_tipo = 'R' WHERE ed60_i_codigo in ($codrematr)";
  $result5 = pg_query($sql5);
  if(!$result5){
   echo $sql5."\n\n".pg_errormessage();
   $erro = true;
  }
 }
 if(trim($codmatr)!=""){
  echo "\n UPDATE em Matriculados \n\n";
  $sql6 = "UPDATE matricula SET ed60_c_tipo = 'N' WHERE ed60_i_codigo in ($codmatr)";
  $result6 = pg_query($sql6);
  if(!$result6){
   echo $sql6."\n\n".pg_errormessage();
   $erro = true;
  }
 }
}
echo "Situação REMATRICULADOS: $rematr\n";
echo "Situação MATRICULADOS: $matr\n";
if($erro==true){
 pg_exec("rollback");
 exit;
}else{
 pg_exec("commit");
}
?>