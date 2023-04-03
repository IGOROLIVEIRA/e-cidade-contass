<?
$HOST = "localhost";
$BASE = "bage";
$PORT = "5432";
$USER = "postgres";
$PASS = "";
set_time_limit(0);
if(!($conn = pg_connect("host=$HOST dbname=$BASE port=$PORT user=$USER password=$PASS"))){
 echo "Erro ao conectar base de dados...\n";
 exit;
}
system("clear");
pg_exec("begin");
$errosql = false;
$sql = "SELECT ed57_i_codigo,ed57_i_escola,ed57_i_base,ed57_i_calendario FROM turma WHERE ed57_i_codigo in (545,546,547,548,551,554,549,550,603,553,720) ORDER BY ed57_i_codigo";
$result = pg_query($sql);
if(!$result){
 $errosql = true;
}
$linhas = pg_num_rows($result);
echo "Iniciando.....\n\n";
sleep(3);
for($x=0;$x<$linhas;$x++){
 $ed57_i_codigo = pg_result($result,$x,'ed57_i_codigo');
 $ed57_i_escola = pg_result($result,$x,'ed57_i_escola');
 $ed57_i_base = pg_result($result,$x,'ed57_i_base');
 $ed57_i_calendario = pg_result($result,$x,'ed57_i_calendario');
 echo "-Turma $ed57_i_codigo \n\n";
 $sql1 = "SELECT ed60_i_codigo,ed60_i_aluno FROM matricula WHERE ed60_i_turma = $ed57_i_codigo";
 $result1 = pg_query($sql1);
 if(!$result1){
  $errosql = true;
  break;
 }
 $linhas1 = pg_num_rows($result1);
 for($y=0;$y<$linhas1;$y++){
  $ed60_i_codigo = pg_result($result1,$y,'ed60_i_codigo');
  $ed60_i_aluno = pg_result($result1,$y,'ed60_i_aluno');
  echo "---Aluno $ed60_i_aluno \n";
  $sql_exc = "SELECT ed95_i_codigo as coddiario
              FROM diario
              WHERE ed95_i_aluno = $ed60_i_aluno
              AND ed95_i_regencia in (select ed59_i_codigo from regencia where ed59_i_turma = $ed57_i_codigo)
             ";
  $result_exc = pg_query($sql_exc);
  if(!$result_exc){
   $errosql = true;
   break;
  }
  $linhas_exc = pg_num_rows($result_exc);
  for($z=0;$z<$linhas_exc;$z++){
   $coddiario = pg_result($result_exc,$z,'coddiario');
   echo "------Diário $coddiario \n";
   $sql_amp = "DELETE FROM amparo WHERE ed81_i_diario = $coddiario";
   $result_amp = pg_query($sql_amp);
   $sql_df = "DELETE FROM diariofinal WHERE ed74_i_diario = $coddiario";
   $result_df = pg_query($sql_df);
   $sql_pres= "DELETE FROM parecerresult WHERE ed63_i_diarioresultado in (select ed73_i_codigo from diarioresultado inner join diario on ed95_i_codigo = ed73_i_diario where ed73_i_diario = $coddiario)";
   $result_pres = pg_query($sql_pres);
   $sql_dr= "DELETE FROM diarioresultado WHERE ed73_i_diario = $coddiario";
   $result_dr = pg_query($sql_dr);
   $sql_paval= "DELETE FROM pareceraval WHERE ed93_i_diarioavaliacao in (select ed72_i_codigo from diarioavaliacao inner join diario on ed95_i_codigo = ed72_i_diario where ed72_i_diario = $coddiario)";
   $result_paval = pg_query($sql_paval);
   $sql_ab= "DELETE FROM abonofalta WHERE ed80_i_diarioavaliacao in (select ed72_i_codigo from diarioavaliacao inner join diario on ed95_i_codigo = ed72_i_diario where ed72_i_diario = $coddiario)";
   $result_ab = pg_query($sql_ab);
   $sql_da= "DELETE FROM diarioavaliacao WHERE ed72_i_diario = $coddiario";
   $result_da = pg_query($sql_da);
   $sql_dia= "DELETE FROM diario WHERE ed95_i_codigo = $coddiario";
   $result_dia = pg_query($sql_dia);
   if(!$result_amp||!$result_df||!$result_pres||!$result_dr||!$result_paval||!$result_ab||!$result_da||!$result_dia){
    $errosql = true;
    break;
   }
  }
  $sql_mv= "DELETE FROM matriculamov WHERE ed229_i_matricula = $ed60_i_codigo";
  $result_mv = pg_query($sql_mv);
  $sql_atr= "DELETE FROM alunotransfturma WHERE ed69_i_matricula = $ed60_i_codigo";
  $result_atr = pg_query($sql_atr);
  $sql_tre= "DELETE FROM transfescolarede WHERE ed103_i_matricula = $ed60_i_codigo";
  $result_tre = pg_query($sql_tre);
  $sql_mat= "DELETE FROM matricula WHERE ed60_i_codigo = $ed60_i_codigo";
  $result_mat = pg_query($sql_mat);
  if(!$result_mv||!$result_atr||!$result_tre||!$result_mat){
   $errosql = true;
   break;
  }
  echo "------Matricula $ed60_i_codigo \n";

  $sql2 = "SELECT ed56_i_codigo FROM alunocurso
           WHERE ed56_i_aluno = $ed60_i_aluno
           AND ed56_i_escola = $ed57_i_escola
           AND ed56_i_base = $ed57_i_base
           AND ed56_i_calendario = $ed57_i_calendario
          ";
  $query2 = pg_query($sql2);
  if(!$query2){
   $errosql = true;
   break;
  }
  $linhas2 = pg_num_rows($query2);
  if($linhas2>0){
   $ed56_i_codigo = pg_result($query2,0,'ed56_i_codigo');
   $sql_ap= "DELETE FROM alunopossib WHERE ed79_i_alunocurso = $ed56_i_codigo";
   $result_ap = pg_query($sql_ap);
   $sql_ac= "DELETE FROM alunocurso WHERE ed56_i_codigo = $ed56_i_codigo";
   $result_ac = pg_query($sql_ac);
   if(!$result_ap||!$result_ac){
    $errosql = true;
    break;
   }
  }
 }
 $sql_regh = "DELETE FROM regenciahorario WHERE ed58_i_regencia in (select ed59_i_codigo from regencia where ed59_i_turma = $ed57_i_codigo)";
 $result_regh = pg_query($sql_regh);
 $sql_regp = "DELETE FROM regenciaperiodo WHERE ed78_i_regencia in (select ed59_i_codigo from regencia where ed59_i_turma = $ed57_i_codigo)";
 $result_regp = pg_query($sql_regp);
 $sql_reg = "DELETE FROM regencia WHERE ed59_i_turma = $ed57_i_codigo";
 $result_reg = pg_query($sql_reg);
 $sql1 = "UPDATE alunopossib SET
           ed79_i_turmaant = null
          WHERE ed79_i_turmaant = $ed57_i_codigo
         ";
 $query1 = pg_query($sql1);
 $sql2 = "UPDATE matricula SET
           ed60_i_turmaant = null
          WHERE ed60_i_turmaant = $ed57_i_codigo
         ";
 $query2 = pg_query($sql2);
 $sql_atr = "DELETE FROM alunotransfturma WHERE ed69_i_turmaorigem = $ed57_i_codigo or ed69_i_turmadestino = $ed57_i_codigo";
 $result_atr = pg_query($sql_atr);
 $sql_pt = "DELETE FROM parecerturma WHERE ed105_i_turma = $ed57_i_codigo";
 $result_pt = pg_query($sql_pt);
 $sql_rc = "DELETE FROM regenteconselho WHERE ed235_i_turma = $ed57_i_codigo";
 $result_rc = pg_query($sql_rc);
 $sql_ts = "DELETE FROM trocaserie WHERE ed101_i_turmaorig = $ed57_i_codigo or ed101_i_turmadest = $ed57_i_codigo";
 $result_ts = pg_query($sql_ts);
 $sql_tt = "DELETE FROM turmaturno WHERE ed246_i_turma = $ed57_i_codigo";
 $result_tt = pg_query($sql_tt);
 $sql_t = "DELETE FROM turma WHERE ed57_i_codigo = $ed57_i_codigo";
 $result_t = pg_query($sql_t);
 if(!$result_regh||!$result_regp||!$result_reg||!$query1||!$query2||!$result_atr||!$result_pt||!$result_rc||!$result_ts||!$result_tt||!$result_t){
  $errosql = true;
  break;
 }
 echo "------Turma $ed57_i_codigo \n";
 echo "\n\n";
 sleep(2);
}
echo "\n\n Terminado...";
if($errosql==true){
 pg_exec("rollback");
}else{
 pg_exec("commit");
}
?>
