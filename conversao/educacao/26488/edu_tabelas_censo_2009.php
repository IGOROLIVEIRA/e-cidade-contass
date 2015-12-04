<?
set_time_limit(0);
$host="localhost";
$base="auto_capivari_20090619_v110";
$user="postgres";
$pass="";
$port="5434";
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
pg_exec("begin");
system("clear");
echo " ->Iniciando processo...";
sleep(1);

$erro = false;
system("clear");
echo " ->Inserindo em censomunic...";
$result2 = pg_query("INSERT INTO censomunic VALUES(2206720,22,'NAZARIA')");
$result1 = pg_query("INSERT INTO censodistrito VALUES(nextval('censodistrito_ed262_i_codigo_seq'),2206720,5,'NAZARIA')");
system("clear");
echo " ->Alterando em turma...";
$result3 = pg_query("UPDATE turma SET ed57_i_censocursoprofiss = null");
system("clear");
echo " ->Deletando em censocursoprofiss...";
$result4 = pg_query("DELETE FROM censocursoprofiss");
$result5 = pg_query("DELETE FROM turmaacativnova WHERE ed274_i_turmaacativ in (select ed267_i_codigo from turmaacativ where ed267_i_censoativcompl = 89999)");
$result6 = pg_query("DELETE FROM turmaacativ WHERE ed267_i_censoativcompl = 89999");
$result7 = pg_query("ALTER TABLE censoinstsuperior ADD ed257_c_situacao char(10)");
system("clear");
echo " ->Deletando em censoregradisc...";
$result8 = pg_query("DELETE FROM censoregradisc WHERE ed272_i_censoetapa in (49,50,52,53,54,55,57,59)");
$result8 = pg_query("DELETE FROM censoregradisc WHERE ed272_i_censodisciplina in (22)");
$result9 = pg_query("UPDATE serie SET ed11_i_codcenso = 51 WHERE ed11_i_codcenso in (49,50,52,53,54,55,57,59)");
$result10 = pg_query("UPDATE caddisciplina SET ed232_i_codcenso = 99 WHERE ed232_i_codcenso in (22)");
$result11 = pg_query("DELETE FROM censodisciplina WHERE ed265_i_codigo in (22)");
$result12 = pg_query("DELETE FROM censoetapa WHERE ed266_i_codigo in (49,50,52,53,54,55,57,59)");
system("clear");
echo " ->Inserindo em censoetapa...";
$result13 = pg_query("INSERT INTO censoetapa VALUES(60,'EJA PRESENCIAL - INTEGRADO A EDUCACAO PROFISSIONAL DE ENSINO FUNDAMENTAL - FIC','N','S','S')");
$result14 = pg_query("INSERT INTO censoetapa VALUES(61,'EJA SEMI PRESENCIAL - INTEGRADO A EDUCACAO PROFISSIONAL DE ENSINO FUNDAMENTAL - FIC','N','S','S')");
$result15 = pg_query("INSERT INTO censoetapa VALUES(62,'EJA PRESENCIAL - INTEGRADA A EDUCACAO PROFISSIONAL DE NIVEL MEDIO','N','S','S')");
$result16 = pg_query("INSERT INTO censoetapa VALUES(63,'EJA SEMI PRESENCIAL - INTEGRADA A EDUCACAO PROFISSIONAL DE NIVEL MEDIO','N','S','S')");
system("clear");
echo " ->Inserindo em censoregradisc...";
$result17 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),4,26)");
$result18 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),4,27)");
$result19 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),5,26)");
$result20 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),5,27)");
$result21 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),6,26)");
$result22 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),6,27)");
$result23 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),7,26)");
$result24 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),7,27)");
$result25 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),14,26)");
$result26 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),14,27)");
$result27 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),15,26)");
$result28 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),15,27)");
$result29 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),16,26)");
$result30 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),16,27)");
$result31 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),17,26)");
$result32 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),17,27)");
$result33 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),18,26)");
$result34 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),18,27)");
$result35 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),43,26)");
$result36 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),43,27)");
$result37 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),46,26)");
$result38 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),46,27)");
$result39 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),56,26)");
$result40 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),56,27)");
$result41 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),8,26)");
$result42 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),8,27)");
$result43 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),9,26)");
$result44 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),9,27)");
$result45 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),10,26)");
$result46 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),10,27)");
$result47 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),11,26)");
$result48 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),11,27)");
$result49 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),19,26)");
$result50 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),19,27)");
$result51 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),20,26)");
$result52 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),20,27)");
$result53 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),21,26)");
$result54 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),21,27)");
$result55 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),41,26)");
$result56 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),41,27)");
$result57 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),44,26)");
$result58 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),44,27)");
$result59 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),47,26)");
$result60 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),47,27)");
$result61 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),51,26)");
$result62 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),51,27)");
$result63 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),58,26)");
$result64 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),58,27)");
$result65 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),13,26)");
$result66 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),13,27)");
$result67 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),23,26)");
$result68 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),23,27)");
$result69 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),12,26)");
$result70 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),12,27)");
$result71 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),22,26)");
$result72 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),22,27)");
$result73 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),24,26)");
$result74 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),24,27)");
$result75 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),60,1)");
$result76 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),60,2)");
$result77 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),60,3)");
$result78 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),60,4)");
$result79 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),60,5)");
$result80 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),60,6)");
$result81 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),60,7)");
$result82 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),60,8)");
$result83 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),60,9)");
$result84 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),60,10)");
$result85 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),60,11)");
$result86 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),60,12)");
$result87 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),60,13)");
$result88 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),60,14)");
$result89 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),60,15)");
$result90 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),60,16)");
$result91 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),60,17)");
$result92 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),60,23)");
$result93 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),60,26)");
$result94 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),60,27)");
$result95 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),60,99)");
$result96 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),61,1)");
$result97 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),61,2)");
$result98 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),61,3)");
$result99 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),61,4)");
$result100 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),61,5)");
$result101 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),61,6)");
$result102 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),61,7)");
$result103 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),61,8)");
$result104 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),61,9)");
$result105 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),61,10)");
$result106 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),61,11)");
$result107 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),61,12)");
$result108 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),61,13)");
$result109 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),61,14)");
$result110 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),61,15)");
$result111 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),61,16)");
$result112 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),61,17)");
$result113 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),61,23)");
$result114 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),61,26)");
$result115 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),61,27)");
$result116 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),61,99)");
$result117 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),25,26)");
$result118 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),25,27)");
$result119 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),26,26)");
$result120 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),26,27)");
$result121 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),27,26)");
$result122 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),27,27)");
$result123 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),28,26)");
$result124 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),28,27)");
$result125 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),29,26)");
$result126 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),29,27)");
$result127 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),45,26)");
$result128 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),45,27)");
$result129 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),48,26)");
$result130 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),48,27)");
$result131 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),30,26)");
$result132 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),30,27)");
$result133 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),31,26)");
$result134 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),31,27)");
$result135 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),32,26)");
$result136 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),32,27)");
$result137 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),33,26)");
$result138 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),33,27)");
$result139 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),34,26)");
$result140 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),34,27)");
$result141 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),62,1)");
$result142 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),62,2)");
$result143 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),62,3)");
$result144 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),62,4)");
$result145 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),62,6)");
$result146 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),62,7)");
$result147 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),62,8)");
$result148 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),62,9)");
$result149 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),62,10)");
$result150 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),62,11)");
$result151 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),62,12)");
$result152 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),62,13)");
$result153 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),62,14)");
$result154 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),62,15)");
$result155 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),62,16)");
$result156 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),62,17)");
$result157 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),62,23)");
$result158 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),62,26)");
$result159 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),62,27)");
$result160 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),62,99)");
$result161 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),63,1)");
$result162 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),63,2)");
$result163 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),63,3)");
$result164 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),63,4)");
$result165 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),63,6)");
$result166 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),63,7)");
$result167 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),63,8)");
$result168 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),63,9)");
$result169 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),63,10)");
$result170 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),63,11)");
$result171 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),63,12)");
$result172 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),63,13)");
$result173 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),63,14)");
$result174 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),63,15)");
$result175 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),63,16)");
$result176 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),63,17)");
$result177 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),63,23)");
$result178 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),63,26)");
$result179 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),63,27)");
$result180 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),63,99)");
$result181 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),35,25)");
$result182 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),35,26)");
$result183 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),35,27)");
$result184 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),36,25)");
$result185 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),36,26)");
$result186 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),36,27)");
$result187 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),37,25)");
$result188 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),37,26)");
$result189 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),37,27)");
$result190 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),38,25)");
$result191 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),38,26)");
$result192 = pg_query("INSERT INTO censoregradisc VALUES(nextval('censoregradisc_ed272_i_codigo_seq'),38,27)");
$result193 = pg_query("DELETE FROM censoinstcursos");
$result194 = pg_query("DELETE FROM censoativcompl WHERE ed133_i_codigo in (89999,22004)");
for($r=1;$r<=194;$r++){
 $var_result = "result$r";
 if(!$$var_result){
  echo "\n\n ERRO: ".pg_errormessage()."\n\n";
  $erro = true;
  break;
 }
}
$erro1 = false;
//////////CENSOCURSOPROFISS
$ponteiro = fopen("tabela_censocursoprofiss.txt","r");
$x = 0;
while (!feof($ponteiro)){
 $linha = fgets($ponteiro,200);
 $array_linha = explode("|",$linha);
 $array_linha[0] = (int)str_replace(chr(39),"",$array_linha[0]);
 $array_linha[1] = (int)str_replace(chr(39),"",$array_linha[1]);
 $array_linha[2] = str_replace(chr(39),"",$array_linha[2]);
 $array_linha[2] = trim(strtoupper(maiusculo(TiraAcento($array_linha[2]))));

 $sql5 = "INSERT INTO censocursoprofiss
          VALUES($array_linha[1],'$array_linha[2]',$array_linha[0])
         ";
 $result5 = pg_query($sql5);
 if($result5==false){
  $erro1 = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,197,$array_linha[1],$array_linha[2]," PROGRESSÃO: TABELA CENSOCURSOPROFISS");
 }
 $x++;
}
fclose($ponteiro);

//////////CENSOATIVCOMPL
$ponteiro = fopen("tabela_censoativcompl.txt","r");
$x = 0;
while (!feof($ponteiro)){
 $linha = fgets($ponteiro,200);
 $array_linha = explode("|",$linha);
 $array_linha[0] = (int)str_replace(chr(39),"",$array_linha[0]);
 $array_linha[1] = (int)str_replace(chr(39),"",$array_linha[1]);
 $array_linha[2] = str_replace(chr(39),"",$array_linha[2]);
 $array_linha[2] = trim(strtoupper(maiusculo(TiraAcento($array_linha[2]))));
 $result3 = pg_query("SELECT * FROM censoativcompl WHERE ed133_i_codigo = $array_linha[1]");
 if(pg_num_rows($result3)==0){
  $result4 = pg_query("INSERT INTO censoativcompl VALUES($array_linha[1],$array_linha[0],'$array_linha[2]')");
 }else{
  $result4 = pg_query("UPDATE censoativcompl SET
                        ed133_i_tipo = $array_linha[0],
                        ed133_c_descr = '$array_linha[2]'
                       WHERE ed133_i_codigo = $array_linha[1]
                      ");
 }
 if($result4==false){
  $erro1 = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,61,$array_linha[1],$array_linha[2]," PROGRESSÃO: TABELA CENSOATIVCOMPL");
 }
 $x++;
}
fclose($ponteiro);

//////////CENSOINSTSUPERIOR
$ponteiro = fopen("tabela_censoinstsuperior.txt","r");
$x = 0;
while (!feof($ponteiro)){
 $linha = fgets($ponteiro,200);
 $array_linha = explode("|",$linha);
 $array_linha[0] = (int)str_replace(chr(39),"",$array_linha[0]);//codigo
 $array_linha[1] = str_replace(chr(39),"",$array_linha[1]);//nome
 $array_linha[1] = trim(strtoupper(maiusculo(TiraAcento($array_linha[1]))));
 $array_linha[2] = (int)str_replace(chr(39),"",$array_linha[2]);//dependencia
 $array_linha[4] = (int)str_replace(chr(39),"",$array_linha[4]);//tipo
 $array_linha[8] = (int)str_replace(chr(39),"",$array_linha[8]);//municipio
 $array_linha[9] = str_replace(chr(39),"",$array_linha[9]);//situacao
 $array_linha[9] = trim(strtoupper(maiusculo(TiraAcento($array_linha[9]))));
 if($array_linha[0]!=9999999){
  if($array_linha[2]==0){
   $array_linha[2] = 4;
  }
 }
 $result3 = pg_query("SELECT * FROM censoinstsuperior WHERE ed257_i_codigo = $array_linha[0]");
 if(pg_num_rows($result3)==0){
  if($array_linha[0]==9999999){
   $array_linha[2] = "null";
   $array_linha[4] = "null";
   $array_linha[8] = "null";
   $array_linha[9] = "";
  }
  $result4 = pg_query("INSERT INTO censoinstsuperior VALUES($array_linha[0],'$array_linha[1]',$array_linha[2],$array_linha[4],$array_linha[8],'$array_linha[9]')");
 }else{
  $result4 = pg_query("UPDATE censoinstsuperior SET
                        ed257_c_nome = '$array_linha[1]',
                        ed257_i_dependencia = $array_linha[2],
                        ed257_i_tipo = $array_linha[4],
                        ed257_i_censomunic = $array_linha[8],
                        ed257_c_situacao = '$array_linha[9]'
                       WHERE ed257_i_codigo = $array_linha[0]
                      ");
 }
 if($result4==false){
  $erro1 = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,5301,$array_linha[0],$array_linha[1]," PROGRESSÃO: TABELA CENSOINSTSUPERIOR");
 }
 $x++;
}
fclose($ponteiro);
//////////CURSOFORMACAO
$ponteiro = fopen("tabela_cursoformacao.txt","r");
$x = 0;
while (!feof($ponteiro)){
 $linha = fgets($ponteiro,200);
 $array_linha = explode("|",$linha);
 $array_linha[0] = (int)str_replace(chr(39),"",$array_linha[0]);//codigo classe
 $array_linha[1] = str_replace(chr(39),"",$array_linha[1]);//descrição classe
 $array_linha[1] = trim(strtoupper(maiusculo(TiraAcento($array_linha[1]))));
 $array_linha[2] = str_replace(chr(39),"",$array_linha[2]);//codigo curso
 $array_linha[2] = trim(strtoupper(maiusculo(TiraAcento($array_linha[2]))));
 $array_linha[3] = str_replace(chr(39),"",$array_linha[3]);//descrição curso
 $array_linha[3] = trim(strtoupper(maiusculo(TiraAcento($array_linha[3]))));
 $result3 = pg_query("SELECT * FROM cursoformacao WHERE ed94_c_codigocenso = '$array_linha[2]'");
 if(pg_num_rows($result3)==0){
  $result4 = pg_query("INSERT INTO cursoformacao VALUES(nextval('cursoformacao_ed94_i_codigo_seq'),'$array_linha[3]',$array_linha[0],'$array_linha[2]','$array_linha[1]')");
 }else{
  $result4 = pg_query("UPDATE cursoformacao SET
                        ed94_c_descr = '$array_linha[3]',
                        ed94_i_codclasse = $array_linha[0],
                        ed94_c_descrclasse = '$array_linha[1]'
                       WHERE ed94_c_codigocenso = '$array_linha[2]'
                      ");
 }
 if($result4==false){
  $erro1 = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,124,$array_linha[2],$array_linha[3]," PROGRESSÃO: TABELA CURSOFORMACAO");
 }
 $x++;
}
fclose($ponteiro);
$result5 = pg_query("SELECT ed94_i_codigo,ed94_c_codigocenso FROM cursoformacao");
$linhas5 = pg_num_rows($result5);
for($t=0;$t<pg_num_rows($result5);$t++){
 $codigo_cursoformacao = pg_result($result5,$t,0);
 $codigo_censo = trim(pg_result($result5,$t,1));
 $ponteiro = fopen("tabela_cursoformacao.txt","r");
 $tem = false;
 while (!feof($ponteiro)){
  $linha = fgets($ponteiro,200);
  $array_linha = explode("|",$linha);
  $array_linha[2] = str_replace(chr(39),"",$array_linha[2]);//codigo curso
  $array_linha[2] = trim(strtoupper(maiusculo(TiraAcento($array_linha[2]))));
  if($array_linha[2]==$codigo_censo){
   $tem = true;
  }
 }
 fclose($ponteiro);
 if($tem==false){
  $result6 = pg_query("SELECT ed94_i_codigo FROM cursoformacao WHERE ed94_c_codigocenso = 999999");
  $codigo_999999 = trim(pg_result($result6,0,0));
  $result7 = pg_query("UPDATE formacao SET ed27_i_cursoformacao = $codigo_999999 WHERE ed27_i_cursoformacao = $codigo_cursoformacao");
  $result8 = pg_query("DELETE FROM cursoformacao WHERE ed94_i_codigo = $codigo_cursoformacao");
  if($result7==false || $result8==false){
   $erro1 = true;
   break;
  }else{
   system("clear");
   "TABELA FORMACAO -> $codigo_cursoformacao";
  }
 }
}
if($erro==true || $erro1==true){
 pg_exec("rollback");
 exit;
}else{
 echo " \n->Terminado processo...\n\n";
 pg_exec("commit");
}
?>
