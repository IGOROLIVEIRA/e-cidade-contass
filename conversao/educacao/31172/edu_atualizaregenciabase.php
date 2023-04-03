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
$sql = "SELECT ed57_i_codigo,ed57_i_base,ed57_i_serie FROM turma ";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
$erro = false;
for($x=0;$x<$linhas;$x++){
   $ed57_i_codigo=trim(pg_result($result,$x,0));
   $ed57_i_base=trim(pg_result($result,$x,1));
   $ed57_i_serie=trim(pg_result($result,$x,2));
   $sql1 = "SELECT ed59_i_codigo,ed59_i_disciplina FROM regencia where ed59_i_turma = $ed57_i_codigo ";
   $result1 = pg_query($sql1);
   $linhas1 = pg_num_rows($result1);   
  for($y=0;$y<$linhas1;$y++){
  	  $ed59_i_codigo = trim(pg_result($result1,$y,0));
      $ed59_i_disciplina = trim(pg_result($result1,$y,1));
      $sql2 = "SELECT ed34_i_ordenacao FROM basemps where ed34_i_base=$ed57_i_base and ed34_i_serie= $ed57_i_serie and ed34_i_disciplina= $ed59_i_disciplina ";
      $result2 = pg_query($sql2);
      $linhas2 = pg_num_rows($result2);      
    for($t=0;$t<$linhas2;$t++){
    	$ed34_i_ordenacao = trim(pg_result($result2,$t,0));
       if($linhas2>0){
	      if($ed34_i_ordenacao==""){
		      $ed34_i_ordenacao=1;
	      }	    
	    $sql3 = "UPDATE regencia SET
           ed59_i_ordenacao = $ed34_i_ordenacao            
          WHERE ed59_i_codigo = $ed59_i_codigo";
        $result3 = pg_query($sql3);  
       }else{
	     $sql3 = "UPDATE regencia SET
           ed59_i_ordenacao = 1            
           WHERE ed59_i_codigo = $ed59_i_codigo";
         $result3 = pg_query($sql3);  
       }
    }
  }
     if($result2==false){
       $erro = true;
       break;
     }else{
       system("clear");
       echo Progresso($x,$linhas,$ed57_i_codigo,$ed34_i_ordenacao," PROGRESSÃO:");
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