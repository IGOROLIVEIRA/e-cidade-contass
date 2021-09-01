<?
set_time_limit(0);
/*$DB_SERVIDOR="127.0.0.1";
$DB_BASE="bage";
$DB_USUARIO="postgres";
$DB_SENHA="";
$DB_PORTA="5432";*/
include(__DIR__ . "/../../../libs/db_conn.php");
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

$sql  = " SELECT me28_i_codigo,me28_i_turma,ed223_i_serie ";
$sql .= " FROM mer_tpcardapioturma";
$sql .= "  inner join turma on turma.ed57_i_codigo = mer_tpcardapioturma.me28_i_turma";
$sql .= "  inner join turmaserieregimemat on turmaserieregimemat.ed220_i_turma = turma.ed57_i_codigo";
$sql .= "  inner join serieregimemat on serieregimemat.ed223_i_codigo = turmaserieregimemat.ed220_i_serieregimemat";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
$erro = false;
$sql_alter = pg_query("ALTER TABLE mer_tpcardapioturma RENAME COLUMN me28_i_turma TO me28_i_serie");
$sql_alter1 = pg_query("ALTER TABLE mer_tpcardapioturma DROP CONSTRAINT mer_tpcardapioturma_turma_fk");
$codigos_alterados = "0";
for ($y=0;$y<$linhas;$y++) {
    
  $me28_i_codigo       = trim(pg_result($result,$y,0));
  $me28_i_turma        = trim(pg_result($result,$y,1));
  $ed223_i_serie       = trim(pg_result($result,$y,2));
  $sql_serie  = " SELECT me28_i_codigo as nada";
  $sql_serie .= " FROM mer_tpcardapioturma";
  $sql_serie .= "  inner join turma on turma.ed57_i_codigo = mer_tpcardapioturma.me28_i_serie";
  $sql_serie .= "  inner join turmaserieregimemat on turmaserieregimemat.ed220_i_turma = turma.ed57_i_codigo";
  $sql_serie .= "  inner join serieregimemat on serieregimemat.ed223_i_codigo = turmaserieregimemat.ed220_i_serieregimemat";
  $sql_serie .= " WHERE ed223_i_serie = $ed223_i_serie ";
  $sql_serie .= " AND me28_i_codigo not in ($codigos_alterados)";
  $result_serie = pg_query($sql_serie);
  $linhas_serie = pg_num_rows($result_serie);
  if ($linhas_serie>0) {
  
     $sql2 = "DELETE from mer_tpcardapioturma
              WHERE me28_i_codigo = $me28_i_codigo";
     $result2 = pg_query($sql2);
     
  } else {    
  
    $sql2 = "UPDATE mer_tpcardapioturma SET 
              me28_i_serie = $ed223_i_serie
             WHERE me28_i_codigo = $me28_i_codigo";
    $result2 = pg_query($sql2);
    $codigos_alterados .= ",".$me28_i_codigo;
  }
  if ($result2==false) {

    $erro = true;
    break;
  
  } else {
    
    system("clear");
    echo Progresso($y,$linhas,$me28_i_codigo,$ed223_i_serie," PROGRESSÃO: MER_TPCARDAPIOTURMA");
  
  }
}
$result3 = pg_query("ALTER TABLE mer_tpcardapioturma ADD CONSTRAINT mer_tpcardapioturma_serie_fk FOREIGN KEY (me28_i_serie) REFERENCES serie(ed11_i_codigo)");
$result4 = pg_query("CREATE UNIQUE INDEX mer_tpcardapioturma_carescola_serie_in ON mer_tpcardapioturma(me28_i_cardapioescola,me28_i_serie);");
if ($result3==false) {
  $erro = true;
}
if ($erro==true) {
    
  echo "\n\n ERRO: ".pg_errormessage()."\n SQL: ".$sql2."\n\n";
  pg_exec("rollback");
  exit;
 
} else {
    
  echo "  \nProcesso Concluído\n\n";
  pg_exec("commit");
 
}
?>                                                           