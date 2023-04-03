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
$ed47_v_identuf_banco = array("Rs"=>"43","SR"=>"43");
$ed47_c_certidaomunic_banco = array("ACEGUÁ"=>"4300034",
                                    "AGÉ"=>"4301602",
                                    "ARAUCÁRIA"=>"4101804",
                                    "BAGAÉ"=>"4301602",
                                    "BAG[E"=>"4301602",
                                    "BAGÉ"=>"4301602",
                                    "BAGGE"=>"4301602",
                                    "BALNEÁRIO CAMBORIÚ"=>"4203204",
                                    "BASGÉ"=>"4301602",
                                    "BBAGÉ"=>"4301602",
                                    "BGÉ"=>"4301602",
                                    "BRSILIA"=>"5300108",
                                    "CAÇAPAVA"=>"4302808",
                                    "CAÇAPAVA DO SUL"=>"4302808",
                                    "CAJURU, CURITIBA"=>"3509403",
                                    "CAMAQUÃ"=>"4303509",
                                    "CAPÃO DA CANOA"=>"4304630",
                                    "COPACABANA"=>"3304557",
                                    "DOMPEDRITO"=>"4306601",
                                    "FOZ DO IGUAÇU"=>"4108304",
                                    "GAGÉ"=>"4301602",
                                    "GRAVATAÍ"=>"4309209",
                                    "GUAÍBA"=>"4309308",
                                    "JAGUARÃO"=>"4311007",
                                    "JOSÉ OTAVIO"=>"4301602",
                                    "JOSÉ OTÁVIO - BAGÉ"=>"4301602",
                                    "RIVERA"=>"",
                                    "ROSÁRIO DE SUL"=>"4316402",
                                    "SANT DO LIVRAMENTO"=>"4317103",
                                    "SANTO ANTº DO PINHAL"=>"3548203",
                                    "SÃO GABRIEL"=>"4318309",
                                    "SAO GONÇALO"=>"3304904",
                                    "SÃO LEOPOLDO"=>"4318705",
                                    "SÃO PAULO"=>"3550308",
                                    "SAO PULO"=>"3550308",
                                    "SÃO SEPÉ"=>"4319604",
                                    "SER REG FONTOURA"=>"4301602",
                                    "SER REGISTRAL FONTOURA"=>"4301602",
                                    "SERV. REG. FONTOURA"=>"4301602",
                                    "TORRE"=>"4321501",
                                    "TRAMANDAÍ"=>"4321600",
                                    "TRÊS COROAS"=>"4321709"
                                   );
$ed47_c_naturalidade_banco =  array("ACEGUÁ"=>"4300034",
                                    "AGE"=>"4301602",
                                    "A MÃE"=>"4301602",
                                    "ARAUCÁRIA"=>"4101804",
                                     "BAÉ"=>"4301602",
                                    "BAGAÉ"=>"4301602",
                                    "B AGE"=>"4301602",
                                    "BAG´[E"=>"4301602",
                                    "BAG[E"=>"4301602",
                                    "BAGÉ"=>"4301602",
                                    "BAG É"=>"4301602",
                                    "BAGEÉ"=>"4301602",
                                    "BAGEENSE"=>"4301602",
                                    "BAGÉR"=>"4301602",
                                    "BAGERS"=>"4301602",
                                    "BAGGE"=>"4301602",
                                    "BALNEÁRIO CAMBORIÚ"=>"4203204",
                                    "BASGÉ"=>"4301602",
                                    "BBAGÉ"=>"4301602",
                                    "BGÉ"=>"4301602",
                                    "B. CANOS"=>"4301602",
                                    "BEGÉ"=>"4301602",
                                    "BRASÍLIA"=>"5300108",
                                    "BOA VISTA - RR"=>"1400100",
                                    "BRASILEIRO"=>"2201960",
                                    "CAÇAPAVA"=>"4302808",
                                    "CAÇAPAVA DO SUL"=>"4302808",
                                    "CACHOERINHA"=>"4303103",
                                    "CURITIBA, CAJURU"=>"3509403",
                                    "CAMAQUÃ"=>"4303509",
                                    "CANGUÇU"=>"4304507",
                                    "CAPÃO DA CANOA"=>"4304630",
                                    "CAPUCAIA DO SUL"=>"4320008",
                                    "CAXIAS DO SULK"=>"4305108",
                                    "CHAPECÓ"=>"4204202",
                                    "COLONIA NOVA"=>"4301602",
                                    "COLÔNIA NOVA"=>"4301602",
                                    "COLONIA NOVA - BAGÉ"=>"4301602",
                                    "COPACABANA"=>"3304557",
                                    "CRUZEIRO, BRASILIA / DF"=>"3513405",
                                    "DOM PETRITO"=>"4306601",
                                    "FLORIANÓPOLIS"=>"4205407",
                                    "FONTOURA"=>"4308300",
                                    "FOZ DO IGUAÇU"=>"4108304",
                                    "GAGÉ"=>"4301602",
                                    "GRAVATAÍ"=>"4309209",
                                    "GUAÍBA"=>"4309308",
                                    "HUKHA NEGRA"=>"4309654",
                                    "HULA NEGRA"=>"4309654",
                                    "HUSMO - SANTA MARIA"=>"4316907",
                                    "IJUÍ"=>"4310207",
                                    "ITAJAI (STA. CATARINA)"=>"4208203",
                                    "IVORÁ"=>"4310751",
                                    "JAGUARÃO"=>"4311007",
                                    "JANGADA - MATO GROSSO"=>"5104906",
                                    "JANGADA/MT"=>"5104906",
                                    "JORGE FONTOURA"=>"4301602",
                                    "JÚLIO DE CASTILHOS/RS"=>"4311205",
                                    "LAVRAS DOS UL"=>"4311502",
                                    "MALVINAS - ARGENTINA"=>"",
                                    "MELO"=>"4301602",
                                    "MICHELE VIEIRA VAZ"=>"4301602",
                                    "MINAS"=>"4312252",
                                    "MONTEVIDEO"=>"",
                                    "MORO DA FUMAÇA"=>"4211207",
                                    "MUÇUM"=>"4312609",
                                    "NILZA BEATRIZ ALVES BRANCO CHA"=>"4301602",
                                    "PEDRO OSÓRIO"=>"4314209",
                                    "PNTA PORÃ"=>"5006606",
                                    "PORTO ALEGRENSE"=>"4314902",
                                    "RESTINGA SÊCA"=>"4315503",
                                    "RESTINGA SECA/ RS"=>"4315503",
                                    "RIVERA"=>"",
                                    "ROSÁRIO DA SUL"=>"4316402",
                                    "ROSÁRIO DO SUL"=>"4316402",
                                    "SANDRA LOPES DA SILVA"=>"4301602",
                                    "SANTA VITÓRIA DOS PALMARES"=>"4317301",
                                    "SANTO ANDRÉ SÃO PAULO"=>"3547809",
                                    "SÃO BERNARDO DO CAMPO"=>"3548708",
                                    "SÃO BORJA"=>"4318002",
                                    "SÃO FRANCISCO DE ASSIS"=>"4318101",
                                    "SÃOFRANCISCO DE ASSIS"=>"4318101",
                                    "SANT DO LIVRAMENTO"=>"4317103",
                                    "SANTO ANTº DO PINHAL"=>"3548203",
                                    "SÃO GABRIEL"=>"4318309",
                                    "SAO GABRIEL - TREZE DE MAIO"=>"4318309",
                                    "SÃO GERONIMO"=>"4318408",
                                    "SAO GONÇALO"=>"3304904",
                                    "SÃO JOSÉ"=>"4216602",
                                    "SÃO JOSÉ DOS CAMPOS"=>"3549904",
                                    "SÃO LEOPOLDO"=>"4318705",
                                    "SÃO LOURENÇO DO SUL"=>"4318804",
                                    "SÃOPAULO"=>"3550308",
                                    "SÃO PAULO"=>"3550308",
                                    "SÃO PEDRO DO SUL"=>"4319406",
                                    "SÃO SEPE"=>"4319604",
                                    "SAO SEPÉ"=>"4319604",
                                    "SÃO SEPÉ"=>"4319604",
                                    "SAT DO LIVRAMENTO"=>"4317103",
                                    "SEIVAL"=>"4301602",
                                    "SOROBA"=>"3552205",
                                    "TACUAREMBÓ"=>"4301602",
                                    "TORRINHAS"=>"4321501",
                                    "TOYOHASHI - JAPÃO"=>"",
                                    "TRAMANDAÍ"=>"4321600",
                                    "TRÊS COROAS"=>"4321709",
                                    "TUPANCIRETÃ"=>"4322202",
                                    "URUGUAI"=>"4322400",
                                    "URUGUAINA"=>"4322400",
                                    "VACACAÍ"=>"4322509",
                                    "VITÓRIA"=>"3205309"
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
