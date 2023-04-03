<?

set_time_limit(0);

include(__DIR__ . "/../libs/db_conn.php");

$conn = pg_connect("dbname=$DB_BASE user=postgres host=$DB_SERVIDOR port=$DB_PORTA") or die('ERRO AO CONECTAR NA BASE DE DADOS !!');

@$isTeste = (strtoupper($argv[1])=="TESTE");

echo "Conectado a base $DB_BASE\n";

// Inicia Transacao
pg_query($conn, "begin");

if ($isTeste == false){
  $sql_w_liclicitem = "create table w_liclicitem as select * from liclicitem";

  $res_liclicitem   = @pg_query($conn,$sql_w_liclicitem);
  if ($res_liclicitem == false) {
    die("Tabela de backup da Liclicitem ja criada ou processo ja executado.\n\n");
  }
}

$sql  = "select l20_codigo ";
$sql .= "from liclicita";

$resLiclicita = pg_query($conn, $sql);
$numrows      = pg_numrows($resLiclicita);

echo "Total de registros encontrados: ".$numrows."\n\n";

$erro = true;
if ($numrows > 0) {
  $sql_update  = "";
  $cont_update = 0;

  for ($i = 0; $i < $numrows; $i++) {
    $l20_codigo = pg_result($resLiclicita, $i, "l20_codigo");

    $sql  = "select l21_codigo ";
    $sql .= "from liclicitem ";
    $sql .= "where l21_codliclicita = $l20_codigo ";
    $sql .= "order by l21_codigo";

    $resLiclicitem     = pg_query($conn, $sql);
    $numrowsLiclicitem = pg_numrows($resLiclicitem);

    $seq = 1;
    for($ii = 0; $ii < $numrowsLiclicitem; $ii++) {
      $l21_codigo = pg_result($resLiclicitem, $ii, "l21_codigo");
    
      $sql_update = "update liclicitem set l21_ordem = $seq where l21_codigo = $l21_codigo";
      $erro       = pg_query($sql_update) or die("Erro ao alterar item $l21_codigo para Licitacao $l20_codigo");

      echo "   * Alterado item $l21_codigo (Sequencia $seq) para Licitacao $l20_codigo\n";

      if($erro == false) {
          break;
      }       

      $seq++;
      $cont_update++;
    }
  }
  
  echo "Total de Itens de Licitacao Alterados: ".$cont_update."\n";
} else {
  echo "\nNão foi encontrada nenhum registro de Licitacao!!\n";
}

if ($erro == false || $isTeste == true) {

  if($isTeste == true) {
    echo "\nExecutando em modo de teste. Executando Rollback!!\n\n";
  }

  pg_query("rollback");
} else {
  pg_query("commit");
}

?>
