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
  $aLinhasArquivo    =  file("arquivos/censoorgemissrg.cvs");
  $iTotalAtualizados = 0;
  $iTotalNovos       = 0;

  echo "Aguarde, migrando dados da tabela censoorgemissrg para a base {$sBase}\n";
  pg_query("select fc_startsession();"); 
  pg_query("select fc_putsession('DB_login', 'iuri');"); 
  foreach ($aLinhasArquivo as $sLinha) {
     
    $aCampos               = explode(";", $sLinha);
    $iCodigoOrgao          = $aCampos[0];
    $sDescricaoOrgao       = strtoupper(TiraAcento(trim($aCampos[1]))); 
    $sSqlVerificaExistente = "select * From censoorgemissrg where ed132_i_codigo = {$iCodigoOrgao}";
    $rsSqlExiste           = pg_query($sSqlVerificaExistente);
    if (pg_num_rows($rsSqlExiste) > 0) {
      
      $sSqlAcerto        = "update censoorgemissrg set ed132_c_descr = '{$sDescricaoOrgao}' where ed132_i_codigo = {$iCodigoOrgao}";
      $iTotalAtualizados ++; 
    } else {

      $iTotalNovos++;
      $sSqlAcerto = "insert into censoorgemissrg (ed132_i_codigo, ed132_c_descr) values ({$iCodigoOrgao},'{$sDescricaoOrgao}')";
    }

    pg_query($sSqlAcerto);
  }
  echo "Total de Registros Atualizados: {$iTotalAtualizados}\n";
  echo "Total de Registros Novos:       {$iTotalNovos}\n";
?>
