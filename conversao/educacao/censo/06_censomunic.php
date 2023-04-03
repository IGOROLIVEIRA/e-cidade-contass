<?
  /**
   * Programa para atualização das tabelas Auxilizares do Censo.
   * Atualizacao da tabela censoorgemissrg
   */
  $aDadosConexao = parse_ini_file("libs/db_conecta.ini");
  require_once("/var/www/dbportal2/libs/db_utils.php");
  require_once("/var/www/dbportal2/libs/db_stdlibwebseller.php");
  $sBase             = $aDadosConexao["dbname"]; 
  $sHost             = $aDadosConexao["host"];
  $sUser             = $aDadosConexao["user"];
  $sPassword         = $aDadosConexao["password"];

  $conn              = pg_connect("host='{$sHost}' user='{$sUser}' dbname ='{$sBase}' password='{$sPassword}'") or die('Erro na conexao');
  $aLinhasArquivo    =  file("arquivos/censomunic.csv");
  $iTotalAtualizados = 0;
  $iTotalNovos       = 0;

  echo "Aguarde, migrando dados da tabela censomunic para a base {$sBase}\n";
  pg_query("select fc_startsession();"); 
  pg_query("select fc_putsession('DB_login', 'iuri');"); 
  foreach ($aLinhasArquivo as $sLinha) {
     
    $aCampos               = explode(";", $sLinha);
    $iCodigoMunic          = $aCampos[0];
    $iCodigoUF             = $aCampos[1];
    $sDescricaoMunic       = strtoupper(TiraAcento(trim($aCampos[2]))); 
    $sSqlVerificaExistente = "select * From censomunic where ed261_i_codigo = {$iCodigoMunic}";
    $rsSqlExiste           = pg_query($sSqlVerificaExistente);
    if (pg_num_rows($rsSqlExiste) > 0) {
      
      $sSqlAcerto    = "update censomunic set ";
      $sSqlAcerto   .= "       ed261_c_nome    = '{$sDescricaoMunic}',";
      $sSqlAcerto   .= "       ed261_i_censouf = {$iCodigoUF} ";
      $sSqlAcerto   .= "  where ed261_i_codigo = {$iCodigoMunic}";
      $iTotalAtualizados ++; 
    } else {

      $iTotalNovos++;
      $sSqlAcerto = "insert into censomunic ";
      $sSqlAcerto = "            (ed261_i_codigo, ";
      $sSqlAcerto = "             ed261_i_censouf,";
      $sSqlAcerto = "             ed261_c_nome ";
      $sSqlAcerto = "            ) "; 
      $sSqlAcerto = "            values ";
      $sSqlAcerto = "           ({$iCodigoMunic},";
      $sSqlAcerto = "           {$iCodigoUF},";
      $sSqlAcerto = "           '{$sDescricaoMunic}' ";
      $sSqlAcerto = "          )";
    }

    pg_query($sSqlAcerto);
  }
  echo "Total de Registros Atualizados: {$iTotalAtualizados}\n";
  echo "Total de Registros Novos:       {$iTotalNovos}\n";
?>
