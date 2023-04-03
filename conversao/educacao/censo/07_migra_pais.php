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
  $aLinhasArquivo    =  file("arquivos/pais.csv");
  $iTotalAtualizados = 0;
  $iTotalNovos       = 0;

  echo "Aguarde, migrando dados da tabela pais para a base {$sBase}\n";
  pg_query("select fc_startsession();"); 
  pg_query("select fc_putsession('DB_login', 'iuri');"); 
  foreach ($aLinhasArquivo as $sLinha) {
     
    $aCampos               = explode(";", $sLinha);
    $iCodigoPais           = $aCampos[0];
    $sCodigoIso            = $aCampos[1];
    $sDescricaoPais        = strtoupper(TiraAcento(trim($aCampos[2]))); 
    $sSqlVerificaExistente = "select * From pais where ed228_i_paisonu = {$iCodigoPais}";
    $rsSqlExiste           = pg_query($sSqlVerificaExistente);
    if (pg_num_rows($rsSqlExiste) > 0) {
      
      $sSqlAcerto    = "update pais set ";
      $sSqlAcerto   .= "       ed228_c_descr    = '{$sDescricaoPais}',";
      $sSqlAcerto   .= "       ed228_c_abrev    = '{$sCodigoIso}' ";
      $sSqlAcerto   .= "  where ed228_i_paisonu = {$iCodigoPais}";
      $iTotalAtualizados ++; 
    } else {

      $iTotalNovos++;
      $sSqlAcerto  = "insert into pais ";
      $sSqlAcerto .= "            (ed228_i_codigo, ";
      $sSqlAcerto .= "             ed228_c_descr,";
      $sSqlAcerto .= "             ed228_i_paisonu, ";
      $sSqlAcerto .= "             ed228_c_abrev) "; 
      $sSqlAcerto .= "            values ";
      $sSqlAcerto .= "           (nextval('pais_ed228_i_codigo_seq'),";
      $sSqlAcerto .= "           '{$sDescricaoPais}',";
      $sSqlAcerto .= "           {$iCodigoPais},";
      $sSqlAcerto .= "           '{$sCodigoIso}' ";
      $sSqlAcerto .= "          )";
    }

    pg_query($sSqlAcerto);
  }
  echo "Total de Registros Atualizados: {$iTotalAtualizados}\n";
  echo "Total de Registros Novos:       {$iTotalNovos}\n";
?>
