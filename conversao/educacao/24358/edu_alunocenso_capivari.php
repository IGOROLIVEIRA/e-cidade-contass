<?
set_time_limit(0);
$host="";
$base="";
$user="postgres";
$pass="";
$port="5432";
if(!($conn = pg_connect("host=$host dbname=$base port=$port user=$user password=$pass"))) {
 echo "Erro ao conectar...\n\n";
 exit;
}else{
 echo "conectado...\n\n";
}

function TiraCaracteres(&$string){
 $string = str_replace("/","",$string);
 $string = str_replace(chr(92),"",$string);// contrabarra -> \
 $string = str_replace(";","",$string);
 $string = str_replace(":","",$string);
 $string = str_replace("?","",$string);
 $string = str_replace(",","",$string);
 $string = str_replace(".","",$string);
 $string = str_replace("'","",$string);
 $string = str_replace(chr(34),"",$string);// aspas dupla -> "
 $string = str_replace("!","",$string);
 $string = str_replace("@","",$string);
 $string = str_replace("#","",$string);
 $string = str_replace("$","",$string);
 $string = str_replace("%","",$string);
 $string = str_replace("&","",$string);
 $string = str_replace("*","",$string);
 $string = str_replace("(","",$string);
 $string = str_replace(")","",$string);
 $string = str_replace("_","",$string);
 $string = str_replace("+","",$string);
 $string = str_replace("=","",$string);
 $string = str_replace("{","",$string);
 $string = str_replace("}","",$string);
 $string = str_replace("[","",$string);
 $string = str_replace("]","",$string);
 $string = str_replace("<","",$string);
 $string = str_replace(">","",$string);
 $string = str_replace("|","",$string);
 $string = str_replace("§","",$string);
 $string = str_replace("°","",$string);
 $string = str_replace("¹","",$string);
 $string = str_replace("²","",$string);
 $string = str_replace("³","",$string);
 $string = str_replace("£","",$string);
 $string = str_replace("¢","",$string);
 $string = str_replace("¬","",$string);

 return $string;
}

function maiusculo(&$string){
 $string = strtoupper($string);
 $string = str_replace("Ã¡","Ã",$string);
 $string = str_replace("Ã©","Ã",$string);
 $string = str_replace("Ã­","Ã",$string);
 $string = str_replace("Ã³","Ã",$string);
 $string = str_replace("Ãº","Ã",$string);
 $string = str_replace("Ã¢","Ã",$string);
 $string = str_replace("Ãª","Ã",$string);
 $string = str_replace("Ã´","Ã",$string);
 $string = str_replace("Ã®","Ã",$string);
 $string = str_replace("Ã»","Ã",$string);
 $string = str_replace("Ã£","Ã",$string);
 $string = str_replace("Ãµ","Ã",$string);
 $string = str_replace("Ã§","Ã",$string);
 $string = str_replace("Ã ","Ã",$string);
 $string = str_replace("Ã¨","Ã",$string);
 return $string;
}

function TiraAcento($string){
 set_time_limit(240);
 $acentos = 'áéíóúÁÉÍÓÚàÀÂâÊêôÔüÜïÏöÖñÑãÃõÕçÇªºäÄ\'';
 $letras  = 'AEIOUAEIOUAAAAEEOOUUIIOONNAAOOCCAOAA ';
 $new_string = '';
 for($x=0; $x<strlen($string); $x++){
  $let = substr($string, $x, 1);
  for($y=0; $y<strlen($acentos); $y++){
   if($let==substr($acentos, $y, 1)){
    $let=substr($letras, $y, 1);
    break;
   }
  }
  $new_string = $new_string . $let;
 }
 return $new_string;
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
$ed47_c_certidaomunic_banco = array("GRAVATAÍ"=>"4309209",
                                    "OSÓRIO"=>"4313508",
                                    "SANTO ÂNGELO"=>"4317509",
                                    "TRÊS PASSOS"=>"4321907",
                                    "VIAMÃO"=>"4323002"
                                   );
$ed47_c_naturalidade_banco =  array("OSÓRIO"=>"4313508",
                                    "POTO ALEGRE"=>"4314902",
                                    "SANTO ÂNGELO"=>"4317509",
                                    "TRAMANDAÍ"=>"4321600",
                                    "TRÊS PASSOS"=>"4321907",
                                    "VIAMÃO"=>"4323002"
                                   );
$sql = "SELECT ed47_v_munic,
               ed47_v_uf,
               ed47_c_naturalidadeuf,
               ed47_v_identorgao,
               ed47_v_identuf,
               ed47_c_certidaouf,
               ed47_c_certidaomunic,
               ed47_c_naturalidade,
               ed47_i_codigo,
               ed47_v_nome,
               ed47_c_transporte,
               ed47_v_pai,
               ed47_v_mae
        FROM aluno
       ";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
$erro = false;
for($x=0;$x<$linhas;$x++){
 $ed47_v_munic          = trim(pg_result($result,$x,0));
 $ed47_v_uf             = trim(pg_result($result,$x,1));
 $ed47_c_naturalidadeuf = trim(pg_result($result,$x,2));
 $ed47_v_identorgao     = trim(pg_result($result,$x,3));
 $ed47_v_identuf        = trim(pg_result($result,$x,4));
 $ed47_c_certidaouf     = trim(pg_result($result,$x,5));
 $ed47_c_certidaomunic  = trim(pg_result($result,$x,6));
 $ed47_c_naturalidade   = trim(pg_result($result,$x,7));
 $ed47_i_codigo         = trim(pg_result($result,$x,8));
 $ed47_v_nome           = trim(pg_result($result,$x,9));
 $ed47_c_transporte     = trim(pg_result($result,$x,10));
 $ed47_v_pai            = trim(pg_result($result,$x,11));
 $ed47_v_mae            = trim(pg_result($result,$x,12));
 //// ed47_v_munic -> ed47_i_censomunicend
 //// ed47_v_uf -> ed47_i_censoufend
 if($ed47_v_munic!=""){
  $sql1 = "SELECT ed261_i_codigo,ed261_i_censouf FROM censomunic WHERE ed261_c_nome = '$ed47_v_munic'";
  $result1 = pg_query($sql1);
  if(pg_num_rows($result1)>0){
   $ed47_v_munic = pg_result($result1,0,0);
   $ed47_v_uf    = pg_result($result1,0,1);
  }else{
   $ed47_v_munic = "null";
   $ed47_v_uf    = "null";
  }
 }else{
  $ed47_v_munic = "null";
  $ed47_v_uf = "null";
 }
 //// ed47_v_identorgao -> ed47_i_censoorgemissrg
 if($ed47_v_identorgao!=""){
  $ed47_v_identorgao = 10;
 }else{
  $ed47_v_identorgao = "null";
 }
 //// ed47_v_identuf -> ed47_i_censoufident
 if($ed47_v_identuf!=""){
  $ed47_v_identuf = 43;
 }else{
  $ed47_v_identuf = "null";
 }
 //// ed47_c_certidaomunic -> ed47_i_censomuniccert
 //// ed47_c_certidaouf    -> ed47_i_censoufcert
 if($ed47_c_certidaomunic!=""){
  $naotem = false;
  reset($ed47_c_certidaomunic_banco);
  for($t=0;$t<count($ed47_c_certidaomunic_banco);$t++){
   if($ed47_c_certidaomunic==key($ed47_c_certidaomunic_banco)){
    $ed47_c_certidaomunic = $ed47_c_certidaomunic_banco[key($ed47_c_certidaomunic_banco)];
    $naotem = true;
    break;
   }
   next($ed47_c_certidaomunic_banco);
  }
  if($naotem==false){
   $sql1 = "SELECT ed261_i_codigo,ed261_i_censouf FROM censomunic WHERE ed261_c_nome = '$ed47_c_certidaomunic'";
   $result1 = pg_query($sql1);
   if(pg_num_rows($result1)>0){
    $ed47_c_certidaomunic = pg_result($result1,0,0);
    $ed47_c_certidaouf    = pg_result($result1,0,1);
   }else{
    $ed47_c_certidaomunic = "null";
    $ed47_c_certidaouf    = "null";
   }
  }else{
   if($ed47_c_certidaomunic!=""){
    $sql1 = "SELECT ed261_i_censouf FROM censomunic WHERE ed261_i_codigo = $ed47_c_certidaomunic";
    $result1 = pg_query($sql1);
    $ed47_c_certidaouf = pg_result($result1,0,0);
   }else{
    $ed47_c_certidaomunic = "null";
    $ed47_c_certidaouf    = "null";
   }
  }
 }else{
  $ed47_c_certidaomunic = "null";
  $ed47_c_certidaouf    = "null";
 }

 //// ed47_c_naturalidade   -> ed47_i_censomunicnat
 //// ed47_c_naturalidaadeuf -> ed47_i_censoufnat
 if($ed47_c_naturalidade!=""){
  $naotem = false;
  reset($ed47_c_naturalidade_banco);
  for($t=0;$t<count($ed47_c_naturalidade_banco);$t++){
   if($ed47_c_naturalidade==key($ed47_c_naturalidade_banco)){
    $ed47_c_naturalidade = $ed47_c_naturalidade_banco[key($ed47_c_naturalidade_banco)];
    $naotem = true;
    break;
   }
   next($ed47_c_naturalidade_banco);
  }
  if($naotem==false){
   $sql1 = "SELECT ed261_i_codigo,ed261_i_censouf FROM censomunic WHERE ed261_c_nome = '$ed47_c_naturalidade'";
   $result1 = pg_query($sql1);
   if(pg_num_rows($result1)>0){
    $ed47_c_naturalidade   = pg_result($result1,0,0);
    $ed47_c_naturalidadeuf = pg_result($result1,0,1);
   }else{
    $ed47_c_naturalidade   = "null";
    $ed47_c_naturalidadeuf = "null";
   }
  }else{
   if($ed47_c_naturalidade!=""){
    $sql1 = "SELECT ed261_i_censouf FROM censomunic WHERE ed261_i_codigo = $ed47_c_naturalidade";
    $result1 = pg_query($sql1);
    $ed47_c_naturalidadeuf = pg_result($result1,0,0);
   }else{
    $ed47_c_naturalidade   = "null";
    $ed47_c_naturalidadeuf = "null";
   }
  }
 }else{
  $ed47_c_naturalidade   = "null";
  $ed47_c_naturalidadeuf = "null";
 }
 //// ed47_i_transpublico
 if($ed47_c_transporte!=""){
  $ed47_i_transpublico = 1;
 }else{
  $ed47_i_transpublico = 0;
 }
 //// ed47_i_filiacao
 if($ed47_v_pai!="" || $ed47_v_mae!=""){
  $ed47_i_filiacao = 1;
 }else{
  $ed47_i_filiacao = 0;
 }
 //// ed47_i_atendespec
 $sql11 = "SELECT ed214_i_codigo FROM alunonecessidade WHERE ed214_i_aluno = $ed47_i_codigo";
 $result11 = pg_query($sql11);
 if(pg_num_rows($result11)>0){
  $ed47_i_atendespec = 1;
 }else{
  $ed47_i_atendespec = "null";
 }
 $ed47_v_nome = TiraCaracteres($ed47_v_nome);
 $ed47_v_pai = TiraCaracteres($ed47_v_pai);
 $ed47_v_mae = TiraCaracteres($ed47_v_mae);
 $sql2 = "UPDATE aluno SET
           ed47_i_censoufend = $ed47_v_uf,
           ed47_i_censomunicend = $ed47_v_munic,
           ed47_i_censoufnat = $ed47_c_naturalidadeuf,
           ed47_i_censomunicnat = $ed47_c_naturalidade,
           ed47_i_censoufcert = $ed47_c_certidaouf,
           ed47_i_censomuniccert = $ed47_c_certidaomunic,
           ed47_i_censoorgemissrg = $ed47_v_identorgao,
           ed47_i_censoufident = $ed47_v_identuf,
           ed47_i_transpublico = $ed47_i_transpublico,
           ed47_i_filiacao = $ed47_i_filiacao,
           ed47_i_atendespec = $ed47_i_atendespec,
           ed47_v_nome = '$ed47_v_nome',
           ed47_v_pai = '$ed47_v_pai',
           ed47_v_mae = '$ed47_v_mae'
          WHERE ed47_i_codigo = $ed47_i_codigo";
 $result2 = pg_query($sql2);
 if($result2==false){
  $erro = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,$linhas,$ed47_i_codigo,$ed47_v_nome," PROGRESSÃO:");
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
