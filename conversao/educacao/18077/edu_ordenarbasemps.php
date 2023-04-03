<?
set_time_limit(0);
/*$DB_SERVIDOR="172.30.6.2";
$DB_BASE="capivari";
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
$sqlproc1 =  pg_query(" alter table basemps add ed34_i_ordenacao integer;");
$sqlproc3 =  pg_query("	alter table regencia add ed59_i_ordenacao integer;");
$sql = "SELECT * FROM base ";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
$erro = false;
for($x=0;$x<$linhas;$x++){
 $ed31_i_codigo          = trim(pg_result($result,$x,0));
 $sql1 = "SELECT distinct ed34_i_serie,ed11_i_sequencia FROM basemps 
               inner join serie on serie.ed11_i_codigo =  basemps.ed34_i_serie 
               WHERE ed34_i_base = '$ed31_i_codigo' order by ed11_i_sequencia";
 $result1 = pg_query($sql1);
 $linhas1 = pg_num_rows($result1);
  for($p=0;$p<$linhas1;$p++){
  	$ed34_i_serie          = trim(pg_result($result1,$p,0));
   echo $sql2 = "SELECT ed34_i_codigo,ed232_c_descr FROM basemps
  	                  inner join disciplina on disciplina.ed12_i_codigo = basemps.ed34_i_disciplina 
  	                  inner join caddisciplina on caddisciplina.ed232_i_codigo = disciplina.ed12_i_caddisciplina
  	                  WHERE ed34_i_base = '$ed31_i_codigo' and ed34_i_serie='$ed34_i_serie' order by ed232_c_descr";
    $result2 = pg_query($sql2);
    $linhas2 = pg_num_rows($result2);  	  
  for($y=0;$y<$linhas2;$y++){
  	$cont= $y+1;
  	  $ed34_i_codigo = trim(pg_result($result2,$y,0));
      $sql3 = "UPDATE basemps SET
           ed34_i_ordenacao =$cont            
          WHERE ed34_i_codigo = $ed34_i_codigo";
     $result3 = pg_query($sql3);  
  }
 }
if($result2==false){
  $erro = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,$linhas,$ed34_i_codigo,$ed34_i_ordenacao," PROGRESSÃO:");
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