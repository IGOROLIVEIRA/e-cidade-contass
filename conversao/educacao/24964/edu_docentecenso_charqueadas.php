<?
set_time_limit(0);
$host="192.168.0.2";
$base="auto_charqueadas_20090428_v103";
$user="postgres";
$pass="";
$port="5432";
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
echo " ->Iniciando processo...\n\n";
sleep(1);
system("clear");
pg_exec("begin");
$rh01_natura_banco = array("BUTIÁ"=>"4302709",
                           "POROT ALEGRE"=>"4314902"
                          );
$sql = "SELECT z01_nome,
               z01_mae,
               z01_munic,
               z01_uf,
               rh01_natura,
               ed20_i_codigo
        FROM rechumano
         inner join rhpessoal on rh01_regist = ed20_i_codigo
         inner join cgm on z01_numcgm = rh01_numcgm
       ";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
$erro = false;
for($x=0;$x<$linhas;$x++){
 $z01_nome      = trim(pg_result($result,$x,0));
 $z01_mae       = trim(pg_result($result,$x,1));
 $z01_munic     = trim(pg_result($result,$x,2));
 $z01_uf        = trim(pg_result($result,$x,3));
 $rh01_natura   = trim(pg_result($result,$x,4));
 $ed20_i_codigo = trim(pg_result($result,$x,5));
 //// z01_munic -> ed20_i_censomunicender
 if($z01_munic!=""){
  $sql1 = "SELECT ed261_i_codigo,ed261_i_censouf FROM censomunic WHERE ed261_c_nome = '$z01_munic'";
  $result1 = pg_query($sql1);
  if(pg_num_rows($result1)>0){
   $ed20_i_censomunicender   = pg_result($result1,0,0);
   $ed20_i_censoufender = pg_result($result1,0,1);
  }else{
   $ed20_i_censomunicender = "null";
   $ed20_i_censoufender = "null";
  }
 }else{
  $ed20_i_censomunicender = "null";
  $ed20_i_censoufender = "null";
 }
 //// z01_uf -> ed20_i_censoufender
 if($z01_uf!=""){
  $ed20_i_censoufender = 43;
 }else{
  $ed20_i_censoufender = "null";
 }
 $ed20_i_censoorgemiss = 10;
 //// rh01_natura   -> ed20_i_censomunicnat
 if($rh01_natura!=""){
  $naotem = false;
  reset($rh01_natura_banco);
  for($t=0;$t<count($rh01_natura_banco);$t++){
   if($rh01_natura==key($rh01_natura_banco)){
    $rh01_natura = $rh01_natura_banco[key($rh01_natura_banco)];
    $naotem = true;
    break;
   }
   next($rh01_natura_banco);
  }
  if($naotem==false){
   $sql1 = "SELECT ed261_i_codigo,ed261_i_censouf FROM censomunic WHERE ed261_c_nome = '$rh01_natura'";
   $result1 = pg_query($sql1);
   if(pg_num_rows($result1)>0){
    $ed20_i_censomunicnat  = pg_result($result1,0,0);
    $ed20_i_censoufnat = pg_result($result1,0,1);
   }else{
    $ed20_i_censomunicnat = "null";
    $ed20_i_censoufnat = "null";
   }
  }else{
   if($rh01_natura!=""){
    $sql1 = "SELECT ed261_i_censouf FROM censomunic WHERE ed261_i_codigo = $rh01_natura";
    $result1 = pg_query($sql1);
    $ed20_i_censomunicnat = $rh01_natura;
    $ed20_i_censoufnat = pg_result($result1,0,0);
   }else{
    $ed20_i_censomunicnat = "null";
    $ed20_i_censoufnat = "null";
   }
  }
 }else{
  $ed20_i_censomunicnat = "null";
  $ed20_i_censoufnat = "null";
 }
 //// ed20_i_escolaridade
 $sql11 = "SELECT ed27_i_codigo FROM formacao WHERE ed27_i_rechumano = $ed20_i_codigo";
 $result11 = pg_query($sql11);
 if(pg_num_rows($result11)>0){
  $ed20_i_escolaridade = 6;
 }else{
  $ed20_i_escolaridade = 5;
 }
 $sql2 = "UPDATE rechumano SET
           ed20_i_raca = 1,
           ed20_i_nacionalidade = 1,
           ed20_i_pais = 10,
           ed20_i_censoufnat = $ed20_i_censoufnat,
           ed20_i_censomunicnat = $ed20_i_censomunicnat,
           ed20_i_censoorgemiss = $ed20_i_censoorgemiss,
           ed20_i_censoufender = $ed20_i_censoufender,
           ed20_i_censomunicender = $ed20_i_censomunicender,
           ed20_i_escolaridade = $ed20_i_escolaridade
          WHERE ed20_i_codigo = $ed20_i_codigo";
 $result2 = pg_query($sql2);
 if($result2==false){
  $erro = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,$linhas,$ed20_i_codigo,$z01_nome," PROGRESSÃO:");
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
