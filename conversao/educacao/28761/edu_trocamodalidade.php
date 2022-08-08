<?
set_time_limit(0);
include(__DIR__ . "/../../../libs/db_conn.php");


// $DB_SERVIDOR = "127.0.0.1";
// $DB_BASE     = "bage";
// $DB_USUARIO  = "postgres";
// $DB_SENHA    = "";
// $DB_PORTA    = "5432";


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

$sql = "SELECT ed60_i_codigo,ed60_i_aluno,ed69_d_datatransf,ed69_i_turmadestino
	FROM alunotransfturma
	 inner join matricula on matricula.ed60_i_codigo = alunotransfturma.ed69_i_matricula
	 inner join aluno on aluno.ed47_i_codigo = matricula.ed60_i_aluno
	 inner join turma on turma.ed57_i_codigo = alunotransfturma.ed69_i_turmaorigem
	 inner join serie on serie.ed11_i_codigo = turma.ed57_i_serie
	 inner join escola on escola.ed18_i_codigo = turma.ed57_i_escola
	 inner join calendario on calendario.ed52_i_codigo = turma.ed57_i_calendario
	 inner join turma as turmadestino on turmadestino.ed57_i_codigo = alunotransfturma.ed69_i_turmadestino
	 inner join serie as seriedestino on seriedestino.ed11_i_codigo = turmadestino.ed57_i_serie
	 inner join escola as escoladestino on escoladestino.ed18_i_codigo = turmadestino.ed57_i_escola
	 inner join calendario as calendariodestino on calendariodestino.ed52_i_codigo = turmadestino.ed57_i_calendario
	WHERE serie.ed11_i_ensino != seriedestino.ed11_i_ensino
        ORDER BY ed69_d_datatransf
       ";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
$erro = false;
for($x=0;$x<$linhas;$x++){
 $codmatricula = trim(pg_result($result,$x,'ed60_i_codigo'));
 $codaluno     = trim(pg_result($result,$x,'ed60_i_aluno'));
 $datatransf   = trim(pg_result($result,$x,'ed69_d_datatransf'));
 $turmadestino = trim(pg_result($result,$x,'ed69_i_turmadestino'));
 $sql1 = "SELECT ed60_i_codigo as codmatriculadestino
          FROM matricula
          WHERE ed60_i_aluno = $codaluno
          AND ed60_i_turma = $turmadestino
         ";
 $result1 = pg_query($sql1);
 $linhas1 = pg_num_rows($result1);
 $codmatriculadestino = trim(pg_result($result1,0,'codmatriculadestino'));
 $sql2 = "SELECT ed229_i_codigo,ed229_i_matricula,ed229_t_descr
          FROM matriculamov
          WHERE ed229_i_matricula in ($codmatricula,$codmatriculadestino)
          AND ed229_c_procedimento = 'TROCAR ALUNO DE TURMA'
         ";
 $result2 = pg_query($sql2);
 $linhas2 = pg_num_rows($result2);
 for($t=0;$t<$linhas2;$t++){
  $codmatriculamov = trim(pg_result($result2,$t,'ed229_i_codigo'));
  $codmatriculamov_mat = trim(pg_result($result2,$t,'ed229_i_matricula'));
  $descrmatriculamov = trim(pg_result($result2,$t,'ed229_t_descr'));
  $descrmatriculamov = str_replace("DE TURMA,","DE MODALIDADE,",$descrmatriculamov);
  $sql3 = "UPDATE matriculamov SET
            ed229_c_procedimento = 'TROCAR ALUNO DE MODALIDADE',
            ed229_t_descr        = '$descrmatriculamov'
           WHERE ed229_i_codigo = $codmatriculamov
          ";
  @$result3 = pg_query($sql3);
  if($result3==false){
   $erro = true;
   break;
  }else{
   system("clear");
   echo Progresso($x,$linhas,$codmatriculamov,$descrmatriculamov," PROGRESSÃO:");
  }
 }
 if($erro==true){
  break;
 }
}
if($erro==true){
 echo "\n\n ".pg_errormessage()."\n SQL: ".$sql3."\n\n";
 pg_query("rollback");
 exit;
}else{
 echo "  \nProcesso Concluído\n\n";
 pg_query("commit");
}
?>
