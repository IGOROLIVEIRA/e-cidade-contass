<?
set_time_limit(0);
$DB_SERVIDOR="localhost";
$DB_BASE="cmubai";
$DB_USUARIO="dbportal";
$DB_SENHA="";
$DB_PORTA="5432";
//include(__DIR__ . "/../../../libs/db_conn.php");
if (!($conn = pg_connect("host='$DB_SERVIDOR' 
                          dbname='$DB_BASE' 
                          user='$DB_USUARIO' 
                          password='$DB_SENHA' 
                          port='$DB_PORTA'"))) {
  echo "Erro ao conectar...\n\n";
  exit;
} else {
  echo "conectado...\n\n";
}
pg_query($conn, "SELECT fc_startsession()");
function Progresso($linha,$total,$dado1,$dado2,$titulo) {
 $linha++;
 $percent = ($linha/$total)*100;
 $percorrido = floor($percent);
 $restante = 100-$percorrido;
 $tracos = "";
 for ($t=0;$t<$percorrido;$t++) {
    $tracos .= "#";
 }
 $brancos = "";
 for ($t=0;$t<$restante;$t++) {
    $brancos .= ".";
 }
 echo " $titulo";
 echo " $linha de $total registros.\n";
 echo " [".$tracos.$brancos."] ".number_format($percent,2,".",".")."%\n";
 if ($titulo!=" PROGRESSÃO TOTAL DA TAREFA") {
   echo " ---> ".trim($dado1)." -- ".trim($dado2)."\n";
 }
}
pg_exec("begin");
sleep(1);

system("clear");
echo " ->Iniciando processo...\n\n";

system("clear");

$sql = "select me02_i_codigo,me02_i_rechumano from mer_nutricionista";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
$erro = false;
$sql_alter = pg_query("ALTER TABLE mer_nutricionista RENAME COLUMN me02_i_rechumano TO me02_i_cgm");
$sql_alter1 = pg_query("ALTER TABLE mer_nutricionista drop constraint mer_nutricionista_rechumano_fk");
for ($y=0;$y<$linhas;$y++) {
	
  $me02_i_codigo       = trim(pg_result($result,$y,0));
  $me02_i_rechumano       = trim(pg_result($result,$y,1));
  $sql_cgm = "select rh01_numcgm from rhpessoal where rh01_regist= $me02_i_rechumano";
  $result_cgm = pg_query($sql_cgm);
  $linhas_cgm = pg_num_rows($result_cgm);

  $rh01_numcgm       = trim(pg_result($result_cgm,0,0)); 
  $sql2 = "UPDATE mer_nutricionista SET 
           me02_i_cgm = $rh01_numcgm
          WHERE me02_i_codigo = $me02_i_codigo";
  $result2 = pg_query($sql2);
  if ($result2==false) {
 	
    $erro = true;
    break;
  
  } else {
 	
    system("clear");
    echo Progresso($y,$linhas,$me02_i_codigo,$rh01_numcgm," PROGRESSÃO:");
  
  }
}
$sql_alter1 = pg_query("ALTER TABLE mer_nutricionista add constraint mer_nutricionista_cgm_fk foreign key (me02_i_cgm) references cgm(z01_numcgm)");
if ($erro==true) {
	
  echo "\n\n ERRO: ".pg_errormessage()."\n SQL: ".$sql2."\n\n";
  pg_exec("rollback");
  exit;
 
} else {
	
  echo "  \nProcesso Concluído\n\n";
  pg_exec("commit");
 
}
?>                                                           
