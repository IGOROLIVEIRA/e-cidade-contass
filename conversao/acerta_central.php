<?

set_time_limit(0);

include(__DIR__ . "/../libs/db_conn.php");

$conn = pg_connect("dbname=$DB_BASE user=postgres host=$DB_SERVIDOR port=$DB_PORTA") or die('ERRO AO CONECTAR NA BASE DE DADOS !!');

@$isTeste = (strtoupper($argv[1])=="TESTE");

echo "Conectado a base $DB_BASE\n";

// Inicia Transacao
pg_query($conn, "begin");

if ($isTeste == false){
  $sql_w_veiculos = "create table w_veiculos as select * from veiculos";

  $res_veiculos   = @pg_query($conn,$sql_w_veiculos);
  if ($res_veiculos == false) {
    die("Tabela de backup de Veiculos ja criada ou processo ja executado.\n\n");
  }
}

$sql  = "select ve01_codigo, ve01_depart ";
$sql .= "from veiculos ";
$sql .= "order by ve01_depart";

$resVeiculos = pg_query($conn, $sql);
$numrows     = pg_numrows($resVeiculos);

echo "Total de registros encontrados: ".$numrows."\n\n";

$erro = true;
if ($numrows > 0) {
  $sql_insert            = "";
  $cont_insert           = 0;
  $cont_veiccentral      = 0;
  $novocodveiccadcentral = 0;

  for ($i = 0; $i < $numrows; $i++) {
    $ve01_codigo = pg_result($resVeiculos, $i, "ve01_codigo");
    $ve01_depart = pg_result($resVeiculos, $i, "ve01_depart");

    $sql  = "select ve36_sequencial ";
    $sql .= "from veiccadcentral ";
    $sql .= "where ve36_coddepto = $ve01_depart";

    $resVeiccadcentral     = pg_query($conn, $sql);
    $numrowsVeiccadcentral = pg_numrows($resVeiccadcentral);

    if ($numrowsVeiccadcentral == 0){
      $resVeiccadcentral     = pg_query("select nextval('veiccadcentral_ve36_sequencial_seq')") or 
                               die("Erro ao buscar sequence veiccadcentral_ve36_sequencial_seq");
      $novocodveiccadcentral = pg_result($resVeiccadcentral,0,0) or 
                               die("Erro ao buscar novo codigo da Central de Abastecimento");;

      $sql_insert  = "insert into veiccadcentral (ve36_sequencial, ve36_coddepto) ";
      $sql_insert .= "values ($novocodveiccadcentral,$ve01_depart)";

      $erro        = pg_query($sql_insert) or die("Erro ao inserir nova Central $novocodveiccadcentral");
      echo "> Nova Central criada $novocodveiccadcentral (Depto. $ve01_depart)\n";

      if($erro == false) {
          break;
      }       
      
      $resVeiccentral     = pg_query("select nextval('veiccentral_ve40_sequencial_seq')") or 
                            die("Erro ao buscar sequence veiccentral_ve40_sequencial_seq");
      $novocodveiccentral = pg_result($resVeiccentral,0,0) or 
                            die("Erro ao buscar novo codigo da Central e Veiculos");;
      
      $sql_insert  = "insert into veiccentral(ve40_sequencial, ve40_veiccadcentral, ve40_veiculos)";
      $sql_insert .= "values($novocodveiccentral,$novocodveiccadcentral,$ve01_codigo)";
      
      $erro        = pg_query($sql_insert) or die("Erro ao inserir nova Central e Veiculos $novocodveiccentral");
      echo "> Nova Central e Veiculos criada $novocodveiccentral (Central: $novocodveiccadcentral, Veiculo: $ve01_codigo)\n";

      if($erro == false) {
          break;
      }       

      $cont_insert++;
      $cont_veiccentral++;
    } else {
      if ($novocodveiccadcentral != 0){
        $resVeiccentral     = pg_query("select nextval('veiccentral_ve40_sequencial_seq')") or 
                              die("Erro ao buscar sequence veiccentral_ve40_sequencial_seq");
        $novocodveiccentral = pg_result($resVeiccentral,0,0) or 
                              die("Erro ao buscar novo codigo da Central e Veiculos");;
      
        $sql_insert  = "insert into veiccentral(ve40_sequencial, ve40_veiccadcentral, ve40_veiculos)";
        $sql_insert .= "values($novocodveiccentral,$novocodveiccadcentral,$ve01_codigo)";
      
        $erro        = pg_query($sql_insert) or die("Erro ao inserir nova Central e Veiculos $novocodveiccentral");
        echo "> Nova Central e Veiculos criada $novocodveiccentral (Central: $novocodveiccadcentral, Veiculo: $ve01_codigo)\n";

        if($erro == false) {
          break;
        }       

        $cont_veiccentral++;
      }
    }
  }

  if ($erro == true){
    $sql = "alter table veiculos drop ve01_depart";

    $resVeicDepart = pg_query($sql) or die("Erro ao excluir campo ve01_depart");

    echo "\n> Alterada Tabela Veiculos - excluido campo ve01_depart\n";
  }

  echo "Total de Centrais cadastradas:            ".$cont_insert."\n";
  echo "Total de Centrais e Veiculos cadastrados: ".$cont_veiccentral."\n";
} else {
  echo "\nNão foi encontrada nenhum registro de Veiculos!!\n";
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
