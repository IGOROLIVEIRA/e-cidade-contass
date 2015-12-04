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
  $aLinhasArquivo    =  file("arquivos/censodisciplina.csv");
  $iTotalAtualizados = 0;
  $iTotalNovos       = 0;

  echo "Aguarde, migrando dados da tabela censodisciplina para a base {$sBase}\n";
  pg_query("select fc_startsession();"); 
  pg_query("select fc_putsession('DB_login', 'iuri')");
  foreach ($aLinhasArquivo as $sLinha) {
     
    $aCampos               = explode(";", $sLinha);
    $iCodigoDisciplina     = $aCampos[0];
    $sDescricaoDisciplina  = strtoupper(TiraAcento(trim($aCampos[1]))); 
    $sSqlVerificaExistente = "select * From censodisciplina where ed265_i_codigo = {$iCodigoDisciplina}";
    $rsSqlExiste           = pg_query($sSqlVerificaExistente);
    if (pg_num_rows($rsSqlExiste) > 0) {
      
      $sSqlAcerto        = "update censodisciplina set ed265_c_descr = '{$sDescricaoDisciplina}' where ed265_i_codigo = {$iCodigoDisciplina}";
      $iTotalAtualizados ++; 
    } else {

      $iTotalNovos++;
      $sSqlAcerto = "insert into censodisciplina (ed265_i_codigo, ed265_c_descr) values ({$iCodigoDisciplina},'{$sDescricaoDisciplina}')";
    }

    pg_query($sSqlAcerto);
  }
  echo "Total de Registros Atualizados: {$iTotalAtualizados}\n";
  echo "Total de Registros Novos:       {$iTotalNovos}\n";
?>
