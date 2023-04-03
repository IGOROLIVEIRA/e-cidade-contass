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
  $aLinhasArquivo    =  file("arquivos/censocartorio.csv");
  $iTotalAtualizados = 0;
  $iTotalNovos       = 0;

  echo "Aguarde, migrando dados da tabela censocartorio para a base {$sBase}\n";
  pg_query("select fc_startsession();"); 
  pg_query("select fc_putsession('DB_login', 'iuri');"); 
  foreach ($aLinhasArquivo as $sLinha) {
     
    $aCampos               = explode(";", $sLinha);
    $iCodigoCartorio       = $aCampos[0];
    $sDescricaoCartorio    = strtoupper(TiraAcento(trim($aCampos[1]))); 
    $iMunicipioCartorio    = $aCampos[2]; 
    $iServentiaCartorio    = $aCampos[4]; 
    if ($iServentiaCartorio == "") {
      $iServentiaCartorio = 'null';
    }
    $sSqlVerificaExistente = "select * From censocartorio where ed291_i_codigo = {$iCodigoCartorio}";
    $rsSqlExiste           = pg_query($sSqlVerificaExistente);
    if (pg_num_rows($rsSqlExiste) > 0) {
      
      $sSqlAcerto        = "update censocartorio set";
      $sSqlAcerto       .= "       ed291_c_nome       = '{$sDescricaoCartorio}', ";
      $sSqlAcerto       .= "       ed291_i_serventia  = {$iServentiaCartorio}, ";
      $sSqlAcerto       .= "       ed291_i_censomunic = {$iMunicipioCartorio} ";
      $sSqlAcerto       .= " where ed291_i_codigo     = {$iCodigoCartorio}";
      $iTotalAtualizados ++; 
    } else {

      $iTotalNovos++;
      $sSqlAcerto  = "insert into censocartorio  ";
      $sSqlAcerto .= "            (ed291_i_codigo, ";
      $sSqlAcerto .= "             ed291_c_nome,";
      $sSqlAcerto .= "             ed291_i_serventia,";
      $sSqlAcerto .= "             ed291_i_censomunic ";
      $sSqlAcerto .= "            )";
      $sSqlAcerto .= "     values ({$iCodigoCartorio}, ";
      $sSqlAcerto .= "             '{$sDescricaoCartorio}',";
      $sSqlAcerto .= "             {$iServentiaCartorio},";
      $sSqlAcerto .= "             {$iMunicipioCartorio})";
    }

   $rsAcerto =  pg_query($sSqlAcerto);
   if (!$rsAcerto) {
     echo $sSqlAcerto."\n";    
   }
 }
  echo "Total de Registros Atualizados: {$iTotalAtualizados}\n";
  echo "Total de Registros Novos:       {$iTotalNovos}\n";
?>
