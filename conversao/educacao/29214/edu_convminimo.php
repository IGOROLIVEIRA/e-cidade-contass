<?
set_time_limit(0);
/*$DB_SERVIDOR="172.30.6.5";
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
echo " ->Iniciando processo...\n\n";
sleep(1);
system("clear");
pg_exec("begin");
$sqlproc1 =  pg_query(" alter table historicomps add ed62_c_minimo char(20);");
$sqlproc2 =  pg_query(" alter table historicompsfora add ed99_c_minimo char(20);");
$sql = "SELECT  ed62_i_escola,ed62_i_serie,ed62_i_anoref,ed61_i_aluno,ed62_i_codigo         
        FROM historicomps 
        inner join historico  on  historico.ed61_i_codigo = historicomps.ed62_i_historico
       ";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
$erro = false;
for($x=0;$x<$linhas;$x++){
 $ed62_i_escola = trim(pg_result($result,$x,0));
 $ed62_i_serie = trim(pg_result($result,$x,1));
 $ed62_i_anoref = trim(pg_result($result,$x,2));
 $ed61_i_aluno = trim(pg_result($result,$x,3));
 $ed62_i_codigo = trim(pg_result($result,$x,4));
  $sql36="select ed60_c_situacao,ed57_i_escola,ed57_i_serie,ed52_i_ano,ed60_i_aluno,ed57_i_procedimento from matricula
         inner join turma on turma.ed57_i_codigo = matricula.ed60_i_turma
         inner join calendario on calendario.ed52_i_codigo= turma.ed57_i_calendario
         inner join aluno on aluno.ed47_i_codigo= matricula.ed60_i_aluno
         where ed57_i_escola = $ed62_i_escola 
           AND ed57_i_serie = $ed62_i_serie 
           AND ed52_i_ano = $ed62_i_anoref 
           AND ed60_i_aluno = $ed61_i_aluno 
           AND ed60_c_situacao = 'MATRICULADO'";
 $result36 = pg_query($sql36) or die('Erro select matricula \n >>>> SQL: $sql36 <<<< \n');
 $linhas36 = pg_num_rows($result36);
 if($linhas36>0){
   $ed57_i_procedimento = trim(pg_result($result36,0,5));
   $sqlminimo="select ed37_c_minimoaprov,ed37_c_tipo from procedimento
               inner join procresultado on procresultado.ed43_i_procedimento = procedimento.ed40_i_codigo
               inner join formaavaliacao on formaavaliacao.ed37_i_codigo= procresultado.ed43_i_formaavaliacao       
               where ed40_i_codigo= $ed57_i_procedimento
               and ed43_c_geraresultado='S'
               ";
   $resultminimo = pg_query($sqlminimo) or die('Erro select procedimento\n >>>> SQL: $sqlminimo <<<< \n');
   $linhasminimo = pg_num_rows($resultminimo);
   $ed37_c_minimoaprov=pg_result($resultminimo,0,0);
   $ed37_c_tipo=pg_result($resultminimo,0,1);
   if(trim($ed37_c_tipo)!='PARECER'){
     $sql2 = "UPDATE historicomps SET
           ed62_c_minimo='$ed37_c_minimoaprov'           
          WHERE ed62_i_codigo = $ed62_i_codigo";
     $result2 = pg_query($sql2) or die('Erro select historicomps \n >>>> SQL: $sql2 <<<< \n');   
     if($result2==false){
      $erro = true;
      break;
     }else{     	
      system("clear");
      echo Progresso($x,$linhas,$ed62_i_codigo,$ed37_c_minimoaprov," PROGRESSÃO:");
     }
   }   
 }            
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