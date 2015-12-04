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

echo " ->Iniciando processo...";
sleep(1);
system("clear");
pg_exec("begin");
$erro = false;
$result0 = pg_query("ALTER TABLE necessidade ALTER ed48_c_descr TYPE char(100)");

$result1 = pg_query("INSERT INTO necessidade VALUES(101,'CEGUEIRA')");
$result2 = pg_query("INSERT INTO necessidade VALUES(102,'BAIXA VISAO')");
$result3 = pg_query("INSERT INTO necessidade VALUES(103,'SURDEZ')");
$result4 = pg_query("INSERT INTO necessidade VALUES(104,'DEFICIENCIA AUDITIVA')");
$result5 = pg_query("INSERT INTO necessidade VALUES(105,'SURDOCEGUEIRA')");
$result6 = pg_query("INSERT INTO necessidade VALUES(106,'DEFICIENCIA FISICA')");
$result7 = pg_query("INSERT INTO necessidade VALUES(107,'DEFICIENCIA MENTAL')");
$result8 = pg_query("INSERT INTO necessidade VALUES(108,'DEFICIENCIA MULTIPLA')");
$result9 = pg_query("INSERT INTO necessidade VALUES(109,'AUTISMO CLASSICO')");
$result10 = pg_query("INSERT INTO necessidade VALUES(110,'SINDROME DE ASPERGER')");
$result11 = pg_query("INSERT INTO necessidade VALUES(111,'SINDROME DE RETT')");
$result12 = pg_query("INSERT INTO necessidade VALUES(112,'TRANSTORNO DESINTEGRATIVO DA INFANCIA (PSICOSE INFANTIL)')");
$result13 = pg_query("INSERT INTO necessidade VALUES(113,'ALTAS HABILIDADES/SUPERDOTACAO')");

$result14 = pg_query("UPDATE alunonecessidade SET ed214_i_necessidade = 101 WHERE ed214_i_necessidade = 1");
$result15 = pg_query("UPDATE alunonecessidade SET ed214_i_necessidade = 102 WHERE ed214_i_necessidade = 2");
$result16 = pg_query("UPDATE alunonecessidade SET ed214_i_necessidade = 104 WHERE ed214_i_necessidade = 4");
$result17 = pg_query("UPDATE alunonecessidade SET ed214_i_necessidade = 106 WHERE ed214_i_necessidade = 6");
$result18 = pg_query("UPDATE alunonecessidade SET ed214_i_necessidade = 107 WHERE ed214_i_necessidade = 7");
$result19 = pg_query("UPDATE alunonecessidade SET ed214_i_necessidade = 112 WHERE ed214_i_necessidade = 8");
$result20 = pg_query("UPDATE alunonecessidade SET ed214_i_necessidade = 107 WHERE ed214_i_necessidade = 9");
$result21 = pg_query("UPDATE alunonecessidade SET ed214_i_necessidade = 108 WHERE ed214_i_necessidade = 10");

$result22 = pg_query("DELETE FROM necessidade WHERE ed48_i_codigo < 100");
$result23 = pg_query("ALTER SEQUENCE necessidade_ed48_i_codigo_seq START 114");

$result24 = pg_query("UPDATE telefoneescola SET ed26_i_ddd = substr(ed26_i_ddd,1,2)::integer");
$result25 = pg_query("UPDATE telefoneescola SET ed26_i_numero = substr(ed26_i_numero,1,8)::integer");
$result26 = pg_query("ALTER TABLE escolaestrutura ADD ed255_i_aee integer");
$result27 = pg_query("UPDATE escolaestrutura SET ed255_i_aee = 0");
$result28 = pg_query("ALTER TABLE escolaestrutura ADD ed255_i_efciclos integer");
$result29 = pg_query("UPDATE escolaestrutura SET ed255_i_efciclos = 0");
$result30 = pg_query("ALTER TABLE turmaac ADD ed268_c_aee char(20)");
$result31 = pg_query("UPDATE escolaestrutura SET ed255_c_dependencias = '00000000000000001'");
$result32 = pg_query("UPDATE escolaestrutura SET ed255_c_equipamentos = '0000000'");
$result33 = pg_query("UPDATE escolaestrutura SET ed255_c_materdidatico = '100'");

$result34 = pg_query("ALTER TABLE caddisciplina DROP CONSTRAINT caddisciplina_censodisciplina_fk");

$result35 = pg_query("INSERT INTO censodisciplina VALUES(25,'DISCIPLINAS PEDAGOGICAS')");
$result36 = pg_query("INSERT INTO censodisciplina VALUES(26,'ENSINO RELIGIOSO')");
$result37 = pg_query("INSERT INTO censodisciplina VALUES(27,'LINGUA INDIGENA')");
$result38 = pg_query("INSERT INTO censodisciplina VALUES(99,'OUTRAS DISCIPLINAS')");
$result39 = pg_query("DELETE FROM censoregradisc WHERE ed272_i_censodisciplina in (18,19)");
$result40 = pg_query("DELETE FROM censodisciplina WHERE ed265_i_codigo in (18,19)");
$result41 = pg_query("UPDATE caddisciplina SET ed232_i_codcenso = 99 WHERE ed232_i_codcenso in (18,19,24)");
$result42 = pg_query("UPDATE censoregradisc SET ed272_i_censodisciplina = 99 WHERE ed272_i_censodisciplina = 24");
$result43 = pg_query("UPDATE caddisciplina SET ed232_i_codcenso = 26 WHERE ed232_i_codigo = 10");
$result44 = pg_query("DELETE FROM censodisciplina WHERE ed265_i_codigo = 24");

$result45 = pg_query("ALTER TABLE caddisciplina ADD CONSTRAINT caddisciplina_censodisciplina_fk FOREIGN KEY (ed232_i_codcenso) REFERENCES censodisciplina");
$result46 = pg_query("ALTER TABLE turmaac ADD ed268_c_horaini char(5)");
$result47 = pg_query("ALTER TABLE turmaac ADD ed268_c_horafim char(5)");

for($r=0;$r<48;$r++){
 $var_result = "result$r";
 if(!$$var_result){
  $erro = true;
  break;
 }
}

//////////CENSOORGREG
$t = 0;
$total = 800;
$ponteiro = fopen("tabela_censoorgreg.txt","r");
$erro2 = false;
$x = 0;
while (!feof($ponteiro)){
 $linha = fgets($ponteiro,200);
 $array_linha = explode("|",$linha);
 $array_linha[0] = str_replace(chr(39),"",$array_linha[0]);
 $array_linha[1] = (int)str_replace(chr(39),"",$array_linha[1]);
 $array_linha[2] = str_replace(chr(39),"",$array_linha[2]);
 $array_linha[2] = trim(strtoupper(maiusculo(TiraAcento($array_linha[2]))));
 $sql3 = "SELECT ed263_i_codigo FROM censoorgreg
          WHERE ed263_i_censouf = $array_linha[1]
          AND ed263_c_nome = '$array_linha[2]'
         ";
 $result3 = pg_query($sql3);
 if(pg_num_rows($result3)>0){
  $ed263_i_codigo = pg_result($result3,0,0);
  $sql4 = "UPDATE censoorgreg SET ed263_i_codigocenso = '$array_linha[0]' WHERE ed263_i_codigo = $ed263_i_codigo";
  $result4 = pg_query($sql4);
  if($result4==false){
   $erro2 = true;
   break;
  }else{
   system("clear");
   echo Progresso($x,800,$array_linha[0],$array_linha[2]," PROGRESSÃO: TABELA CENSOORGREG");
  }
  $x++;
  $t++;
 }
}
fclose($ponteiro);

if($erro==true){
 echo "\n\n ERRO: ".pg_errormessage()."\n\n";
 pg_exec("rollback");
 exit;
}
system("clear");
echo " \n->Terminado processo...\n\n";
if($erro==false){
 pg_exec("commit");
}
?>