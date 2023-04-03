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
echo " ->Iniciando processo...\n\n";
sleep(1);
system("clear");
pg_exec("begin");
$sql = "SELECT ed229_i_codigo,ed229_i_matricula,ed60_d_datamatricula,ed229_d_dataevento 
        FROM matricula 
         inner join matriculamov on ed229_i_matricula = ed60_i_codigo 
        WHERE (ed229_c_procedimento = 'REMATRICULAR ALUNO' or ed229_c_procedimento = 'MATRICULAR ALUNO') 
        AND ed229_d_dataevento != ed60_d_datamatricula
        AND exists(SELECT *
                   FROM matriculamov as mov1 
                   WHERE mov1.ed229_c_procedimento = 'ALTERAÇÃO DE DATA DA MATRÍCULA E/OU OBSERVAÇÕES' 
                   AND mov1.ed229_i_matricula = matricula.ed60_i_codigo)
        ";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
$erro = false;
for($x=0;$x<$linhas;$x++){
 $ed229_i_codigo       = trim(pg_result($result,$x,0));
 $ed229_i_matricula    = trim(pg_result($result,$x,1));
 $ed60_d_datamatricula = trim(pg_result($result,$x,2));
 $ed229_d_dataevento   = trim(pg_result($result,$x,3)); 
 $sql2 = "UPDATE matriculamov SET 
           ed229_d_dataevento = '$ed60_d_datamatricula'
          WHERE ed229_i_codigo = $ed229_i_codigo";
 $result2 = pg_query($sql2);
 if($result2==false){
  $erro = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,$linhas,$ed229_i_codigo,$ed60_d_datamatricula." - ".$ed229_d_dataevento," PROGRESSÃO:");
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