<?
set_time_limit(0);
$host="127.0.0.1";
$base="sapiranga2";
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
$ed47_v_munic_banco =         array("140SAPIRANGA"=>"4319901",
                                    "1705SAPIRANGA"=>"4319901",
                                    "425SAPIRANGA"=>"4319901",
                                    "61"=>"4319901",
                                    "ARARICÁ"=>"4300877",
                                    "DOIS IRMÃOS"=>"4306403",
                                    "PAROBÉ"=>"4314050",
                                    "SÃO LEO"=>"4318705",
                                    "sapiranga"=>"4319901",
                                    "SAPIRANTela de acesso para GA"=>"4319901"
                                   );
$ed47_c_certidaomunic_banco = array("BAGÉ"=>"4301602",
                                    "BARRACÃO"=>"4301800",
                                    "BENTO GONÇALVES"=>"4302105",
                                    "BOA ESPERANÇA DO IGUAÇU"=>"4103024",
                                    "BOQUEIRÃO DO LEÃO"=>"4302451",
                                    "CAÇAPAVA DO SUL"=>"4302808",
                                    "CAIBATÉ"=>"4303301",
                                    "CAIÇARA"=>"4303400",
                                    "CAMBARÁ DO SUL"=>"4303608",
                                    "CAMPO COM"=>"4303905",
                                    "CANGUÇU"=>"4304507",
                                    "CAPÃO DA CANOA"=>"4304630",
                                    "CARLOS  BARBOSA"=>"4304804",
                                    "CHAPECÓ"=>"4204202",
                                    "COMARCA  DE SAPIRANGA"=>"4319901",
                                    "CRISCIUMAL"=>"4306007",
                                    "CUIDAD DEL ESTE"=>"",
                                    "DOIS IRMÃOES"=>"4306403",
                                    "DOIS IRMÃOS"=>"4306403",
                                    "ESTÂNCIA VELHA"=>"4307609",
                                    "FOZ DO IGUAÇU"=>"4108304",
                                    "FOZ DO IGUAÇÚ"=>"4108304",
                                    "FREDERICO WESPHALEN"=>"4308508",
                                    "GOIOERE"=>"4108601",
                                    "GRAVATAÍ"=>"4309209",
                                    "IJUÍ"=>"4310207",
                                    "IMBÉ"=>"4310330",
                                    "JAGUARÃO"=>"4311007",
                                    "JULIO DE CASTILHO"=>"4311205",
                                    "LAGOÃO"=>"4311254",
                                    "MINAS DO LEÃO"=>"4312252",
                                    "MOGI-GUACU"=>"3530706",
                                    "NÃO-ME-TOQUE"=>"4312658",
                                    "PALHOÇA"=>"4211900",
                                    "PALMEIRA DAS MISSÕES"=>"4313706",
                                    "PARIQUERA-AÇU"=>"3536208",
                                    "PAROBÉ"=>"4314050",
                                    "PORTÃO"=>"4314803",
                                    "PORTELÂNDIA"=>"5218102",
                                    "SAIRANGA"=>"4319901",
                                    "SANTA BÁRBARA DO SUL"=>"4316709",
                                    "SANTO ÂNGELO"=>"4317509",
                                    "SÃO FRANCISCO DE PAULA"=>"4318200",
                                    "SÃO JOÃO DO OESTE"=>"4216255",
                                    "SÃO JOSÉ DO NORTE"=>"4318507",
                                    "SÃO LEOPOLDO"=>"4318705",
                                    "SÃO LOURENÇO DO SUL"=>"4318804",
                                    "SÃO LUIZ GANZAGA"=>"4318903",
                                    "SÃO LUIZ GONZAGA"=>"4318903",
                                    "SÃO MARTINHO"=>"4319109",
                                    "SÃO MIGUEL DA MISSÕES"=>"4319158",
                                    "SAO MIGUEL DOESTE"=>"4217204",
                                    "SÃO MIGUEL DO IGUAÇU"=>"4125704",
                                    "SÃO NICOLAU"=>"4319208",
                                    "SÃO PAULO"=>"3550308",
                                    "SÃO PEDRO DO SUL"=>"4319406",
                                    "SÃOPEDRO DO SUL"=>"4319406",
                                    "SÃO SEBASTIÃO DO CAÍ"=>"4319505",
                                    "SAPIRABGA"=>"4319901",
                                    "'SAPIRANGA"=>"4319901",
                                    "SAPÍRANGA"=>"4319901",
                                    "SAPORANGA"=>"4319901",
                                    "TRAMANDAÍ"=>"4321600",
                                    "TRÊS COROAS"=>"4321709",
                                    "TUPANCIRETÃ"=>"4322202",
                                    "VIAMÃO"=>"4323002",
                                   );
$ed47_c_naturalidade_banco =  array("ARGENTINA"=>"",
                                    "BAGÉ"=>"4301602",
                                    "BARÃO"=>"4301651",
                                    "BARNABÉ"=>"",
                                    "BARRACÃO"=>"4301800",
                                    "BENTO GONÇALVES"=>"4302105",
                                    "BRASILEIRO"=>"",
                                    "BUTIÁ"=>"4302709",
                                    "CAÇAPAVA DO SUL"=>"4302808",
                                    "CAÇAPAV DO SUL"=>"4302808",
                                    "CAIBATÉ"=>"4303301",
                                    "CAIÇARA"=>"4303400",
                                    "CAMAQUÃ"=>"4303509",
                                    "CAMBARÁ DO SUL"=>"4303608",
                                    "campo bom"=>"4303905",
                                    "CANDELÁRIA"=>"4304200",
                                    "CANGUÇU"=>"4304507",
                                    "Canoas"=>"4304606",
                                    "CAPÃO DA CANOA"=>"4304630",
                                    "CHAPECÓ"=>"4204202",
                                    "CHILE"=>"",
                                    "COMARCA DE SAPIRANGA"=>"4319901",
                                    "CRISCIUMAL"=>"4306007",
                                    "CUIDAD DEL ESTE"=>"",
                                    "DOIS IRMÃOS"=>"4306403",
                                    "ENCERUZILHADA DO SUL"=>"4306908",
                                    "ESTÂNCIA VELHA"=>"4307609",
                                    "ESTÃNCIA VELHA"=>"4307609",
                                    "FLORIANÓPOLIS"=>"4205407",
                                    "FOZ DO IGUAÇU"=>"4108304",
                                    "FOZ DO IGUAÇÚ"=>"4108304",
                                    "FREDERICO WESPHALEN"=>"4308508",
                                    "GOIOERE"=>"4108601",
                                    "GRAVATAÍ"=>"4309209",
                                    "GUAPORÉ"=>"4309407",
                                    "IJU"=>"4310207",
                                    "IJUÍ"=>"4310207",
                                    "INDEPENDÊNCIA"=>"4310405",
                                    "IRAÍ"=>"4310504",
                                    "JAGUARÃO"=>"4311007",
                                    "JÓIA"=>"4311155",
                                    "JULIO DE CASTILHO"=>"4311205",
                                    "LAGOÃO"=>"4311254",
                                    "MOGI-GUACU"=>"3530706",
                                    "NÃO-ME-TOQUE"=>"4312658",
                                    "NOVA PETRÓPOLIS"=>"4313201",
                                    "NOVA PRATA DO IGUAÇU"=>"4307708",
                                    "NOVOHAMBURGO"=>"4313409",
                                    "OSÓRIO"=>"4313508",
                                    "PALHOÇA"=>"4211900",
                                    "PALMEIRA DAS MISSÕES"=>"4313706",
                                    "PAROBÉ"=>"4314050",
                                    "PEJUÇARA"=>"4314308",
                                    "PÉROLA D' OESTE"=>"4119004",
                                    "PORTÃO"=>"4314803",
                                    "PORTELÂNDIA"=>"5218102",
                                    "QUEDAS DO IGUAÇU"=>"4120903",
                                    "SAIRANGA"=>"4319901",
                                    "SANTA BÁRBARA DO SUL"=>"4316709",
                                    "SANTA IZABEL D OESTE"=>"4123808",
                                    "SANTO ÂNGELO"=>"4317509",
                                    "SANTO ANTÔNIO DA PATRULHA"=>"4317608",
                                    "SANTO ANTÔNIO DAS MISSÕES"=>"4317707",
                                    "SÃO CARLOS"=>"4216008",
                                    "SÃO FRANCISCO DE APULA"=>"4318200",
                                    "SÃO FRANCISCO DE PAULA"=>"4318200",
                                    "SÃO GABRIEL"=>"4318309",
                                    "SÃO JERONIMO"=>"4318408",
                                    "SÃO JERÔNIMO"=>"4318408",
                                    "SÃO JOÃO BATISTA"=>"4216305",
                                    "SÃO JOÃO DO OESTE"=>"4216255",
                                    "SÃO JOAQUIM"=>"4216503",
                                    "SÃO JOSÉ DO CEDRO"=>"4216701",
                                    "SÃO JOSÉ DO NORTE"=>"4318507",
                                    "SÃO LEOPOLDO"=>"4318705",
                                    "SÃO LOURENÇO DO SUL"=>"4318804",
                                    "SÃO LUIZ GONGAZA"=>"4318903",
                                    "SÃO LUIZ GONZAGA"=>"4318903",
                                    "SÃO MARCOS"=>"4319000",
                                    "SÃO MIGUEL DAS MISSÕES"=>"4319158",
                                    "SAO MIGUEL DOESTE"=>"4217204",
                                    "SÃO MIGUEL DO IGUAÇU"=>"4125704",
                                    "SÃO NICOLAU"=>"4319208",
                                    "SÃO PAULO"=>"3550308",
                                    "SÃO PEDRO DO SUL"=>"4319406",
                                    "SÃO SEBASTIÃO DO CAÍ"=>"4319505",
                                    "SAPIRAN9/03/2009GA"=>"4319901",
                                    "sapiranga"=>"4319901",
                                    "Sapiranga"=>"4319901",
                                    "SAPIRAN GA"=>"4319901",
                                    "SAPIRANGARS"=>"4319901",
                                    "SAPIRNAGA"=>"4319901",
                                    "SASPIRANGA"=>"4319901",
                                    "TAQUARUÇU DO SUL"=>"4321329",
                                    "TRAMANDAÍ"=>"4321600",
                                    "TRÊS COROAS"=>"4321709",
                                    "TRÊS PASSOS"=>"4321907",
                                    "TUPACIRETÃ"=>"4322202",
                                    "TUPANCIRETÃ"=>"4322202",
                                    "VENÂNCIO AIRES"=>"4322608",
                                    "VISTA GAÚCHA"=>"4323705",
                                    "VIAMÃO"=>"4323002",
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
 //// ed47_v_uf    -> ed47_i_censoufend
 if($ed47_v_munic!=""){
  $naotem = false;
  reset($ed47_v_munic_banco);
  for($t=0;$t<count($ed47_v_munic_banco);$t++){
   if($ed47_v_munic==key($ed47_v_munic_banco)){
    $ed47_v_munic = $ed47_v_munic_banco[key($ed47_v_munic_banco)];
    $naotem = true;
    break;
   }
   next($ed47_v_munic_banco);
  }
  if($naotem==false){
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
   if($ed47_v_munic!=""){
    $sql1 = "SELECT ed261_i_censouf FROM censomunic WHERE ed261_i_codigo = $ed47_v_munic";
    $result1 = pg_query($sql1);
    $ed47_v_uf = pg_result($result1,0,0);
   }else{
    $ed47_v_munic = "null";
    $ed47_v_uf    = "null";
   }
  }
 }else{
  $ed47_v_munic = "null";
  $ed47_v_uf    = "null";
 }

 //// ed47_v_identorgao -> ed47_i_censoorgemissrg
 if($ed47_v_identorgao!=""){
  $ed47_v_identorgao = 10;
 }else{
  $ed47_v_identorgao = "null";
 }
 //// ed47_v_identuf -> ed47_i_censoufident
 if($ed47_v_identuf!=""){
  $ed47_v_identuf = $ed47_v_identuf=="rs"?"RS":$ed47_v_identuf;
  $sql1 = "SELECT ed260_i_codigo FROM censouf WHERE ed260_c_sigla = '$ed47_v_identuf'";
  $result1 = pg_query($sql1);
  $ed47_v_identuf = pg_result($result1,0,0);
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
