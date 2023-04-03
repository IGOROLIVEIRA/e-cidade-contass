<?
set_time_limit(0);
$host="";
$base="";
$user="postgres";
$pass="";
$port="5434";
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
 $string = str_replace("�","",$string);
 $string = str_replace("�","",$string);
 $string = str_replace("�","",$string);
 $string = str_replace("�","",$string);
 $string = str_replace("�","",$string);
 $string = str_replace("�","",$string);
 $string = str_replace("�","",$string);
 $string = str_replace("�","",$string);

 return $string;
}

function maiusculo(&$string){
 $string = strtoupper($string);
 $string = str_replace("á","�",$string);
 $string = str_replace("é","�",$string);
 $string = str_replace("í","�",$string);
 $string = str_replace("ó","�",$string);
 $string = str_replace("ú","�",$string);
 $string = str_replace("â","�",$string);
 $string = str_replace("ê","�",$string);
 $string = str_replace("ô","�",$string);
 $string = str_replace("î","�",$string);
 $string = str_replace("û","�",$string);
 $string = str_replace("ã","�",$string);
 $string = str_replace("õ","�",$string);
 $string = str_replace("ç","�",$string);
 $string = str_replace("à","�",$string);
 $string = str_replace("è","�",$string);
 return $string;
}

function TiraAcento($string){
 set_time_limit(240);
 $acentos = '�������������������������������Ǫ���\'';
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
 if($titulo!=" PROGRESS�O TOTAL DA TAREFA"){
  echo " ---> ".trim($dado1)." -- ".trim($dado2)."\n";
 }
}
echo " ->Iniciando processo...\n\n";
sleep(1);
system("clear");
pg_exec("begin");
$ed47_v_identuf_banco = array("Rs"=>"43","SR"=>"43");
$ed47_c_certidaomunic_banco = array("ACEGU�"=>"4300034",
                                    "AG�"=>"4301602",
                                    "ARAUC�RIA"=>"4101804",
                                    "BAGA�"=>"4301602",
                                    "BAG[E"=>"4301602",
                                    "BAG�"=>"4301602",
                                    "BAGGE"=>"4301602",
                                    "BALNE�RIO CAMBORI�"=>"4203204",
                                    "BASG�"=>"4301602",
                                    "BBAG�"=>"4301602",
                                    "BG�"=>"4301602",
                                    "BRSILIA"=>"5300108",
                                    "CA�APAVA"=>"4302808",
                                    "CA�APAVA DO SUL"=>"4302808",
                                    "CAJURU, CURITIBA"=>"3509403",
                                    "CAMAQU�"=>"4303509",
                                    "CAP�O DA CANOA"=>"4304630",
                                    "COPACABANA"=>"3304557",
                                    "DOMPEDRITO"=>"4306601",
                                    "FOZ DO IGUA�U"=>"4108304",
                                    "GAG�"=>"4301602",
                                    "GRAVATA�"=>"4309209",
                                    "GUA�BA"=>"4309308",
                                    "JAGUAR�O"=>"4311007",
                                    "JOS� OTAVIO"=>"4301602",
                                    "JOS� OT�VIO - BAG�"=>"4301602",
                                    "RIVERA"=>"",
                                    "ROS�RIO DE SUL"=>"4316402",
                                    "SANT DO LIVRAMENTO"=>"4317103",
                                    "SANTO ANT� DO PINHAL"=>"3548203",
                                    "S�O GABRIEL"=>"4318309",
                                    "SAO GON�ALO"=>"3304904",
                                    "S�O LEOPOLDO"=>"4318705",
                                    "S�O PAULO"=>"3550308",
                                    "SAO PULO"=>"3550308",
                                    "S�O SEP�"=>"4319604",
                                    "SER REG FONTOURA"=>"4301602",
                                    "SER REGISTRAL FONTOURA"=>"4301602",
                                    "SERV. REG. FONTOURA"=>"4301602",
                                    "TORRE"=>"4321501",
                                    "TRAMANDA�"=>"4321600",
                                    "TR�S COROAS"=>"4321709"
                                   );
$ed47_c_naturalidade_banco =  array("ACEGU�"=>"4300034",
                                    "AGE"=>"4301602",
                                    "A M�E"=>"4301602",
                                    "ARAUC�RIA"=>"4101804",
                                     "BA�"=>"4301602",
                                    "BAGA�"=>"4301602",
                                    "B AGE"=>"4301602",
                                    "BAG�[E"=>"4301602",
                                    "BAG[E"=>"4301602",
                                    "BAG�"=>"4301602",
                                    "BAG �"=>"4301602",
                                    "BAGE�"=>"4301602",
                                    "BAGEENSE"=>"4301602",
                                    "BAG�R"=>"4301602",
                                    "BAGERS"=>"4301602",
                                    "BAGGE"=>"4301602",
                                    "BALNE�RIO CAMBORI�"=>"4203204",
                                    "BASG�"=>"4301602",
                                    "BBAG�"=>"4301602",
                                    "BG�"=>"4301602",
                                    "B. CANOS"=>"4301602",
                                    "BEG�"=>"4301602",
                                    "BRAS�LIA"=>"5300108",
                                    "BOA VISTA - RR"=>"1400100",
                                    "BRASILEIRO"=>"2201960",
                                    "CA�APAVA"=>"4302808",
                                    "CA�APAVA DO SUL"=>"4302808",
                                    "CACHOERINHA"=>"4303103",
                                    "CURITIBA, CAJURU"=>"3509403",
                                    "CAMAQU�"=>"4303509",
                                    "CANGU�U"=>"4304507",
                                    "CAP�O DA CANOA"=>"4304630",
                                    "CAPUCAIA DO SUL"=>"4320008",
                                    "CAXIAS DO SULK"=>"4305108",
                                    "CHAPEC�"=>"4204202",
                                    "COLONIA NOVA"=>"4301602",
                                    "COL�NIA NOVA"=>"4301602",
                                    "COLONIA NOVA - BAG�"=>"4301602",
                                    "COPACABANA"=>"3304557",
                                    "CRUZEIRO, BRASILIA / DF"=>"3513405",
                                    "DOM PETRITO"=>"4306601",
                                    "FLORIAN�POLIS"=>"4205407",
                                    "FONTOURA"=>"4308300",
                                    "FOZ DO IGUA�U"=>"4108304",
                                    "GAG�"=>"4301602",
                                    "GRAVATA�"=>"4309209",
                                    "GUA�BA"=>"4309308",
                                    "HUKHA NEGRA"=>"4309654",
                                    "HULA NEGRA"=>"4309654",
                                    "HUSMO - SANTA MARIA"=>"4316907",
                                    "IJU�"=>"4310207",
                                    "ITAJAI (STA. CATARINA)"=>"4208203",
                                    "IVOR�"=>"4310751",
                                    "JAGUAR�O"=>"4311007",
                                    "JANGADA - MATO GROSSO"=>"5104906",
                                    "JANGADA/MT"=>"5104906",
                                    "JORGE FONTOURA"=>"4301602",
                                    "J�LIO DE CASTILHOS/RS"=>"4311205",
                                    "LAVRAS DOS UL"=>"4311502",
                                    "MALVINAS - ARGENTINA"=>"",
                                    "MELO"=>"4301602",
                                    "MICHELE VIEIRA VAZ"=>"4301602",
                                    "MINAS"=>"4312252",
                                    "MONTEVIDEO"=>"",
                                    "MORO DA FUMA�A"=>"4211207",
                                    "MU�UM"=>"4312609",
                                    "NILZA BEATRIZ ALVES BRANCO CHA"=>"4301602",
                                    "PEDRO OS�RIO"=>"4314209",
                                    "PNTA POR�"=>"5006606",
                                    "PORTO ALEGRENSE"=>"4314902",
                                    "RESTINGA S�CA"=>"4315503",
                                    "RESTINGA SECA/ RS"=>"4315503",
                                    "RIVERA"=>"",
                                    "ROS�RIO DA SUL"=>"4316402",
                                    "ROS�RIO DO SUL"=>"4316402",
                                    "SANDRA LOPES DA SILVA"=>"4301602",
                                    "SANTA VIT�RIA DOS PALMARES"=>"4317301",
                                    "SANTO ANDR� S�O PAULO"=>"3547809",
                                    "S�O BERNARDO DO CAMPO"=>"3548708",
                                    "S�O BORJA"=>"4318002",
                                    "S�O FRANCISCO DE ASSIS"=>"4318101",
                                    "S�OFRANCISCO DE ASSIS"=>"4318101",
                                    "SANT DO LIVRAMENTO"=>"4317103",
                                    "SANTO ANT� DO PINHAL"=>"3548203",
                                    "S�O GABRIEL"=>"4318309",
                                    "SAO GABRIEL - TREZE DE MAIO"=>"4318309",
                                    "S�O GERONIMO"=>"4318408",
                                    "SAO GON�ALO"=>"3304904",
                                    "S�O JOS�"=>"4216602",
                                    "S�O JOS� DOS CAMPOS"=>"3549904",
                                    "S�O LEOPOLDO"=>"4318705",
                                    "S�O LOUREN�O DO SUL"=>"4318804",
                                    "S�OPAULO"=>"3550308",
                                    "S�O PAULO"=>"3550308",
                                    "S�O PEDRO DO SUL"=>"4319406",
                                    "S�O SEPE"=>"4319604",
                                    "SAO SEP�"=>"4319604",
                                    "S�O SEP�"=>"4319604",
                                    "SAT DO LIVRAMENTO"=>"4317103",
                                    "SEIVAL"=>"4301602",
                                    "SOROBA"=>"3552205",
                                    "TACUAREMB�"=>"4301602",
                                    "TORRINHAS"=>"4321501",
                                    "TOYOHASHI - JAP�O"=>"",
                                    "TRAMANDA�"=>"4321600",
                                    "TR�S COROAS"=>"4321709",
                                    "TUPANCIRET�"=>"4322202",
                                    "URUGUAI"=>"4322400",
                                    "URUGUAINA"=>"4322400",
                                    "VACACA�"=>"4322509",
                                    "VIT�RIA"=>"3205309"
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
 if($ed47_v_munic!=""){
  $ed47_v_munic = 4301602;
 }else{
  $ed47_v_munic = "null";
  $ed47_v_uf = "null";
 }
 //// ed47_v_uf -> ed47_i_censoufend
 if($ed47_v_uf!=""){
  $ed47_v_uf = 43;
 }else{
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
  $naotem = false;
  reset($ed47_v_identuf_banco);
  for($t=0;$t<count($ed47_v_identuf_banco);$t++){
   if($ed47_v_identuf==key($ed47_v_identuf_banco)){
    $ed47_v_identuf = $ed47_v_identuf_banco[key($ed47_v_identuf_banco)];
    $naotem = true;
    break;
   }
   next($ed47_v_identuf_banco);
  }
  if($naotem==false){
   $sql1 = "SELECT ed260_i_codigo FROM censouf WHERE ed260_c_sigla = '$ed47_v_identuf'";
   $result1 = pg_query($sql1);
   $ed47_v_identuf = pg_result($result1,0,0);
  }
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
           ed47_i_censoufident = $ed47_v_identuf,
           ed47_i_censoorgemissrg = $ed47_v_identorgao,
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
  echo Progresso($x,$linhas,$ed47_i_codigo,$ed47_v_nome," PROGRESS�O:");
 }
}

if($erro==true){
 echo "\n\n ERRO: ".pg_errormessage()."\n SQL: ".$sql2."\n\n";
 pg_exec("rollback");
 exit;
}else{
 echo "  \nProcesso Conclu�do\n\n";
 pg_exec("commit");
}
?>
