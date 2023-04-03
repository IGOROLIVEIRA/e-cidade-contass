<?
set_time_limit(0);
$host="localhost";
$base="auto_sapiranga_20090516_v104";
$user="postgres";
$pass="";
$port="5434";
if(!($conn = pg_connect("host=$host dbname=$base port=$port user=$user password=$pass"))) {
 echo "Erro ao conectar...\n\n";
 exit;
}else{
 echo "conectado...\n\n";
}

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
echo " ->Iniciando processo...";
sleep(1);
system("clear");
pg_exec("begin");
$erro = false;
$sql = "select ed56_i_aluno,
               ed56_i_codigo,
               ed57_i_serie,
               (select ed11_i_codigo
                from serie
                where ed11_i_sequencia = t.ed11_i_sequencia+1
                and ed11_i_ensino = t.ed11_i_ensino
               ) as proxserie
        from alunopossib
         inner join alunocurso on ed56_i_codigo = ed79_i_alunocurso
         inner join aluno on ed47_i_codigo = ed56_i_aluno
         inner join matricula on ed60_i_aluno = ed47_i_codigo
         inner join turma on ed57_i_codigo = ed60_i_turma
         inner join serie as t on t.ed11_i_codigo = ed57_i_serie
        where ed56_c_situacao = 'APROVADO'
        and ed57_i_base = ed56_i_base
        and ed57_i_calendario = ed56_i_calendario
        and ed79_i_serie = ed57_i_serie
        order by ed56_i_aluno;
       ";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
for($x=0;$x<$linhas;$x++){
 $codalunocurso = pg_result($result,$x,'ed56_i_codigo');
 $codaluno      = pg_result($result,$x,'ed56_i_aluno');
 $proxserie     = pg_result($result,$x,'proxserie');
 if($proxserie!=""){
  $sql4 = "UPDATE alunopossib SET ed79_i_serie = $proxserie WHERE ed79_i_alunocurso = $codalunocurso";
  $result4 = pg_query($sql4);
  if($result4==false){
   $erro = true;
   break;
  }else{
   system("clear");
   echo Progresso($x,$linhas,$codaluno,$proxserie," PROGRESSÃO: TABELA ALUNOPOSSIB");
  }
 }
}
if($erro==true){
 echo "\n\n ERRO: ".pg_errormessage()."\n\n";
 pg_exec("rollback");
 exit;
}else{
 echo "  \nConcluído\n\n";
 sleep(1);
}

system("clear");
echo Progresso($linhas-1,$linhas,$codaluno,$proxserie," PROGRESSÃO TOTAL DA TAREFA");
echo " \n->Terminado processo...\n\n";
if($erro==false){
 pg_exec("commit");
}
?>
