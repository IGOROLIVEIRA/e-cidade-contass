<?
set_time_limit(0);
//include(__DIR__ . "/../../../libs/db_conn.php");

  $DB_SERVIDOR = "192.168.0.2";
  $DB_BASE     = "auto_carazinho_20091001_v2_2_8";
  $DB_USUARIO  = "postgres";
  $DB_SENHA    = "";
  $DB_PORTA    = "5433";

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
pg_exec("begin");
sleep(1);

system("clear");
echo " ->Iniciando processo...\n\n";

$sql_alter1 = pg_query("ALTER TABLE transfescolafora ADD ed104_i_matricula bigint");
$sql_alter2 = pg_query("ALTER TABLE matricula ADD ed60_d_datasaida date");
$sql_alter3 = pg_query("ALTER TABLE matricula ADD ed60_d_datamodifant date");
$sql_alter4 = pg_query("ALTER TABLE matriculamov ADD ed229_d_dataevento date");
$sql_alter5 = pg_query("ALTER TABLE matriculamov ADD ed229_c_horaevento char(5)");
$sql_alter6 = pg_query("UPDATE matriculamov SET ed229_c_horaevento = '12:00'");
$sql_alter7 = pg_query("ALTER TABLE transfescolafora ADD CONSTRAINT transfescolafora_matricula_fk FOREIGN KEY(ed104_i_matricula) REFERENCES matricula(ed60_i_codigo)");
$sql_alter8 = pg_query("CREATE INDEX transfescolafora_matricula_in ON transfescolafora(ed104_i_matricula)");
$sql_alter9 = pg_query("CREATE INDEX matricula_datasaida_in ON matricula(ed60_d_datasaida)");
$sql_alter10 = pg_query("ALTER TABLE atividaderh ADD ed01_c_exigeato char(1)");
$sql_alter11 = pg_query("ALTER TABLE rechumanoativ ADD ed22_i_atolegal integer");
$sql_alter12 = pg_query("UPDATE atividaderh SET ed01_c_exigeato = 'N'");
$sql_alter13 = pg_query("ALTER TABLE rechumanoativ ADD CONSTRAINT rechumanoativ_atolegal_fk FOREIGN KEY(ed22_i_atolegal) REFERENCES atolegal(ed05_i_codigo)");

system("clear");
echo " ->Verificando registros...\n\n";

$sql = "SELECT ed104_i_codigo,
               ed104_i_aluno,
               ed104_d_data,
               ed104_i_escolaorigem,
               ed104_i_escoladestino
        FROM transfescolafora
        ORDER BY ed104_i_aluno,ed104_d_data";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
$erro = false;
$cont = 0;
for($x=0;$x<$linhas;$x++){
 $delete = false;
 $cont++;
 $codtransf     = trim(pg_result($result,$x,'ed104_i_codigo'));
 $codaluno      = trim(pg_result($result,$x,'ed104_i_aluno'));
 $datatransf    = trim(pg_result($result,$x,'ed104_d_data'));
 $escolaorigem  = trim(pg_result($result,$x,'ed104_i_escolaorigem'));
 $escoladestino = trim(pg_result($result,$x,'ed104_i_escoladestino'));
 $data_t = mktime(0,0,0,substr($datatransf,5,2),substr($datatransf,8,2),substr($datatransf,0,4));
 $ano_t = substr($datatransf,0,4);
 $sql1 = "SELECT ed60_i_codigo,
                 ed60_d_datamatricula,
                 ed52_i_ano,
                 ed57_i_escola,
                 ed60_c_situacao
          FROM matricula
           inner join turma on ed57_i_codigo = ed60_i_turma
           inner join calendario on ed52_i_codigo = ed57_i_calendario
          WHERE ed60_i_aluno = $codaluno
          AND ed57_i_escola = $escolaorigem
          AND ed60_c_situacao = 'TRANSFERIDO FORA'
          AND extract(year from ed60_d_datamatricula) = '$ano_t'
          ORDER BY ed60_d_datamatricula
         ";
 $result1 = pg_query($sql1);
 $linhas1 = pg_num_rows($result1);
 $matricula1 = array();
 if($linhas1>0){
  for($y=0;$y<$linhas1;$y++){
   $ed60_i_codigo = trim(pg_result($result1,$y,'ed60_i_codigo'));
   $ed60_d_datamatricula = trim(pg_result($result1,$y,'ed60_d_datamatricula'));
   $ed52_i_ano = trim(pg_result($result1,$y,'ed52_i_ano'));
   $ed57_i_escola = trim(pg_result($result1,$y,'ed57_i_escola'));
   $ed60_c_situacao = trim(pg_result($result1,$y,'ed60_c_situacao'));
   $data_m = mktime(0,0,0,substr($ed60_d_datamatricula,5,2),substr($ed60_d_datamatricula,8,2),substr($ed60_d_datamatricula,0,4));
   $dif = ($data_t-$data_m)/86400;
   if($dif>=0 || ($dif<0 && $linhas1==1)){
    $matricula1[] = $ed60_i_codigo;
   }
  }
  $codmatricula = count($matricula1)==1?$matricula1[0]:$matricula1[1];
 }else{
  $sql2 = "SELECT ed229_i_matricula,ed60_d_datamatricula
           FROM matriculamov
            inner join matricula on ed60_i_codigo = ed229_i_matricula
           WHERE ed229_c_procedimento = 'TRANSFERÊNCIA PARA OUTRA ESCOLA'
           AND ed60_i_aluno = $codaluno
           AND extract(year from ed229_d_data) = '$ano_t'
           ORDER BY ed229_i_matricula LIMIT 1
          ";
  $result2 = pg_query($sql2);
  $linhas2 = pg_num_rows($result2);
  if($linhas2>0){
   $codmatricula = trim(pg_result($result2,0,'ed229_i_matricula'));
   $ed60_d_datamatricula = trim(pg_result($result2,0,'ed60_d_datamatricula'));
  }else{
   $sql3 = "SELECT ed229_i_matricula,ed60_d_datamatricula
            FROM matriculamov
             inner join matricula on ed60_i_codigo = ed229_i_matricula
            WHERE ed229_c_procedimento = 'TRANSFERÊNCIA PARA OUTRA ESCOLA'
            AND ed60_i_aluno = $codaluno
            AND extract(year from ed229_d_data) != '$ano_t'
            ORDER BY ed229_i_matricula LIMIT 1
           ";
   $result3 = pg_query($sql3);
   $linhas3 = pg_num_rows($result3);
   if($linhas3>0){
    $codmatricula = trim(pg_result($result3,0,'ed229_i_matricula'));
    $ed60_d_datamatricula = trim(pg_result($result3,0,'ed60_d_datamatricula'));
   }else{
    $sql4 = "SELECT ed60_i_codigo
             FROM matricula
             WHERE ed60_i_aluno = $codaluno
             AND ed60_d_datamatricula < '$datatransf'
            ";
    $result4 = pg_query($sql4);
    $linhas4 = pg_num_rows($result4);
    if($linhas4>0){
     $codmatricula = trim(pg_result($result4,0,'ed60_i_codigo'));
    }else{
     $delete = true;
    }
   }
  }
 }
 if($delete==false){
  $sql_up = "UPDATE transfescolafora SET
              ed104_i_matricula = $codmatricula
             WHERE ed104_i_codigo = $codtransf
            ";
  $result_up = pg_query($sql_up);
 }else{
  $sql_up = "DELETE FROM transfescolafora WHERE ed104_i_codigo = $codtransf";
  $result_up = pg_query($sql_up);
 }
 if($result_up==false){
  $erro = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,$linhas,$codtransf,$codmatricula," PROGRESSÃO TRANSFESCOLAFORA:");
 }
 unset($matricula1);
}
if($erro==true){
 echo "\n\n SQL: ".$sql_up."\n\n";
 pg_query("rollback");
 exit;
}

////////////////////////////////////////////////////////////////////////////////////////

system("clear");
$sql = "SELECT ed229_i_codigo,
               ed229_c_procedimento,
               ed229_d_data,
               ed229_i_matricula,
               ed60_d_datamatricula,
               ed60_d_datamodif,
               ed60_i_aluno,
               ed60_i_turma
        FROM matriculamov
         inner join matricula on ed60_i_codigo = ed229_i_matricula
        ORDER BY ed229_i_matricula,ed229_d_data";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
$erro2 = false;
$cont = 0;
for($x=0;$x<$linhas;$x++){
 $cont++;
 $codmatmov     = trim(pg_result($result,$x,'ed229_i_codigo'));
 $datamov       = trim(pg_result($result,$x,'ed229_d_data'));
 $procedmov     = trim(pg_result($result,$x,'ed229_c_procedimento'));
 $codmatricula  = trim(pg_result($result,$x,'ed229_i_matricula'));
 $datamatricula = trim(pg_result($result,$x,'ed60_d_datamatricula'));
 $datamodif     = trim(pg_result($result,$x,'ed60_d_datamodif'));
 $codaluno      = trim(pg_result($result,$x,'ed60_i_aluno'));
 $codturma      = trim(pg_result($result,$x,'ed60_i_turma'));
 if(trim($procedmov)=="ALTERAÇÃO DE DATA DA MATRÍCULA E/OU OBSERVAÇÕES"){
  $dataevento = $datamodif;
 }elseif(trim($procedmov)=="ALTERAR SITUAÇÂO DA MATRÍCULA"){
  $dataevento = $datamov;
 }elseif(trim($procedmov)=="CANCELAR ENCERRAMENTO DE AVALIAÇÕES" || trim($procedmov)=="ENCERRAR AVALIAÇÕES"){
  $dataevento = $datamov;
 }elseif(trim($procedmov)=="MATRICULAR ALUNO" || trim($procedmov)=="MATRICULAR ALUNOS TRANSFERIDOS" || trim($procedmov)=="REMATRICULAR ALUNO"){
  $dataevento = $datamatricula;
 }elseif(trim($procedmov)=="PROGRESSÃO DE ALUNO -> AVANÇO" || trim($procedmov)=="PROGRESSÃO DE ALUNO -> CLASSIFICAÇÂO"){
  $sql1 = "SELECT ed101_d_data FROM trocaserie WHERE ed101_i_aluno = $codaluno AND ed101_i_turmaorig = $codturma ORDER BY ed101_d_data DESC LIMIT 1";
  $result1 = pg_query($sql1);
  $linhas1 = pg_num_rows($result1);
  if($linhas1>0){
   $dataevento = trim(pg_result($result1,0,'ed101_d_data'));
  }else{
   $dataevento = $datamov;
  }
 }elseif(trim($procedmov)=="TRANSFERÊNCIA ENTRE ESCOLAS DA REDE"){
  $sql1 = "SELECT ed103_d_data FROM transfescolarede WHERE ed103_i_matricula = $codmatricula ORDER BY ed103_d_data DESC LIMIT 1";
  $result1 = pg_query($sql1);
  $linhas1 = pg_num_rows($result1);
  if($linhas1>0){
   $dataevento = trim(pg_result($result1,0,'ed103_d_data'));
  }else{
   $dataevento = $datamov;
  }
 }elseif(trim($procedmov)=="TRANSFERÊNCIA PARA OUTRA ESCOLA"){
  $sql1 = "SELECT ed104_d_data FROM transfescolafora WHERE ed104_i_matricula = $codmatricula ORDER BY ed104_d_data DESC LIMIT 1";
  $result1 = pg_query($sql1);
  $linhas1 = pg_num_rows($result1);
  if($linhas1>0){
   $dataevento = trim(pg_result($result1,0,'ed104_d_data'));
  }else{
   $dataevento = $datamov;
  }
 }elseif(trim($procedmov)=="TROCAR ALUNO DE MODALIDADE" || trim($procedmov)=="TROCAR ALUNO DE TURMA"){
  $sql1 = "SELECT ed69_d_datatransf
           FROM alunotransfturma
            inner join matricula as matricanterior on matricanterior.ed60_i_codigo = alunotransfturma.ed69_i_matricula
           WHERE ed69_i_turmadestino = $codturma
           AND matricanterior.ed60_i_aluno = $codaluno
           ORDER BY ed69_d_datatransf DESC LIMIT 1";
  $result1 = pg_query($sql1);
  $linhas1 = pg_num_rows($result1);
  if($linhas1>0){
   $dataevento = trim(pg_result($result1,0,'ed69_d_datatransf'));
  }else{
   $dataevento = $datamov;
  }
 }
 $sql_up1 = "UPDATE matriculamov SET
              ed229_d_dataevento = '$dataevento'
             WHERE ed229_i_codigo = $codmatmov
            ";
 $result_up1 = pg_query($sql_up1);
 if($result_up1==false){
  $erro2 = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,$linhas,$codmatmov,$dataevento," PROGRESSÃO MATRICULAMOV:");
 }
}
if($erro2==true){
 echo "\n\n SQL: ".$sql_up1."\n\n";
 pg_query("rollback");
 exit;
}

///////////////////////////////////////////////////////////////////////////////////////

system("clear");
$sql = "SELECT ed60_i_codigo,ed60_c_situacao,ed60_i_aluno,ed60_i_turma,ed60_d_datamatricula,ed60_d_datamodif
        FROM matricula
        WHERE ed60_c_situacao != 'MATRICULADO'
        ORDER BY ed60_i_aluno
       ";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
$erro3 = false;
$cont = 0;
$errados = "";
for($x=0;$x<$linhas;$x++){
 $cont++;
 $codmatricula  = trim(pg_result($result,$x,'ed60_i_codigo'));
 $situacao      = trim(pg_result($result,$x,'ed60_c_situacao'));
 $codaluno      = trim(pg_result($result,$x,'ed60_i_aluno'));
 $codturma      = trim(pg_result($result,$x,'ed60_i_turma'));
 $datamat       = trim(pg_result($result,$x,'ed60_d_datamatricula'));
 $datamod       = trim(pg_result($result,$x,'ed60_d_datamodif'));
 if(trim($situacao)=="AVANÇADO" || trim($situacao)=="CLASSIFICADO"){
  $sql1 = "SELECT ed101_d_data FROM trocaserie WHERE ed101_i_aluno = $codaluno AND ed101_i_turmaorig = $codturma ORDER BY ed101_d_data DESC LIMIT 1";
  $result1 = pg_query($sql1);
  $linhas1 = pg_num_rows($result1);
  if($linhas1>0){
   $datasaida = trim(pg_result($result1,0,'ed101_d_data'));
  }else{
   $datasaida = "null";
  }
 }elseif(trim($situacao)=="CANCELADO"){
  $sql1 = "SELECT ed229_d_data FROM matriculamov WHERE ed229_i_matricula = $codmatricula AND ed229_c_procedimento = 'ALTERAR SITUAÇÂO DA MATRÍCULA' AND ed229_t_descr like '%PARA CANCELADO%' ORDER BY ed229_d_data DESC LIMIT 1";
  $result1 = pg_query($sql1);
  $linhas1 = pg_num_rows($result1);
  if($linhas1>0){
   $datasaida = trim(pg_result($result1,0,'ed229_d_data'));
  }else{
   $datasaida = $datamod;
  }
 }elseif(trim($situacao)=="EVADIDO"){
  $sql1 = "SELECT ed229_d_data FROM matriculamov WHERE ed229_i_matricula = $codmatricula AND ed229_c_procedimento = 'ALTERAR SITUAÇÂO DA MATRÍCULA' AND ed229_t_descr like '%PARA EVADIDO%' ORDER BY ed229_d_data DESC LIMIT 1";
  $result1 = pg_query($sql1);
  $linhas1 = pg_num_rows($result1);
  if($linhas1>0){
   $datasaida = trim(pg_result($result1,0,'ed229_d_data'));
  }else{
   $datasaida = $datamod;
  }
 }elseif(trim($situacao)=="FALECIDO"){
  $sql1 = "SELECT ed229_d_data FROM matriculamov WHERE ed229_i_matricula = $codmatricula AND ed229_c_procedimento = 'ALTERAR SITUAÇÂO DA MATRÍCULA' AND ed229_t_descr like '%PARA FALECIDO%' ORDER BY ed229_d_data DESC LIMIT 1";
  $result1 = pg_query($sql1);
  $linhas1 = pg_num_rows($result1);
  if($linhas1>0){
   $datasaida = trim(pg_result($result1,0,'ed229_d_data'));
  }else{
   $datasaida = $datamod;
  }
 }elseif(trim($situacao)=="TRANSFERIDO REDE"){
  $sql1 = "SELECT ed103_d_data FROM transfescolarede WHERE ed103_i_matricula = $codmatricula ORDER BY ed103_d_data DESC LIMIT 1";
  $result1 = pg_query($sql1);
  $linhas1 = pg_num_rows($result1);
  if($linhas1>0){
   $datasaida = trim(pg_result($result1,0,'ed103_d_data'));
  }else{
   $datasaida = "null";
  }
 }elseif(trim($situacao)=="TRANSFERIDO FORA"){
  $sql1 = "SELECT ed104_d_data FROM transfescolafora WHERE ed104_i_matricula = $codmatricula ORDER BY ed104_d_data DESC LIMIT 1";
  $result1 = pg_query($sql1);
  $linhas1 = pg_num_rows($result1);
  if($linhas1>0){
   $datasaida = trim(pg_result($result1,0,'ed104_d_data'));
  }else{
   $datasaida = "null";
  }
 }elseif(trim($situacao)=="TROCA DE MODALIDADE" || trim($situacao)=="TROCA DE TURMA"){
  $sql1 = "SELECT ed69_d_datatransf FROM alunotransfturma WHERE ed69_i_matricula = $codmatricula AND ed69_i_turmaorigem = $codturma ORDER BY ed69_d_datatransf DESC LIMIT 1";
  $result1 = pg_query($sql1);
  $linhas1 = pg_num_rows($result1);
  if($linhas1>0){
   $datasaida = trim(pg_result($result1,0,'ed69_d_datatransf'));
  }else{
   $datasaida = "null";
  }
 }
 $datasaida = $datasaida=="null"?$datamod:$datasaida;
 $sql_up2 = "UPDATE matricula SET
              ed60_d_datasaida = '$datasaida'
             WHERE ed60_i_codigo = $codmatricula
            ";
 $result_up2 = pg_query($sql_up2);
 if($result_up2==false){
  $erro3 = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,$linhas,$codmatricula,$datasaida," PROGRESSÃO MATRICULA:");
 }
}
if($erro3==true){
 echo "\n\n SQL: ".$sql_up2."\n\n";
 pg_query("rollback");
 exit;
}

if($erro==false && $erro2==false && $erro3==false){
 system("clear");
 echo "\n\nProcesso Concluido\n\n";
 pg_query("commit");
 exit;
}
?>
