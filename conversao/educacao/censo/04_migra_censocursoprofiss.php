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
  $aLinhasArquivo    =  file("arquivos/censocursoprofiss.csv");
  $iTotalAtualizados = 0;
  $iTotalNovos       = 0;

  echo "Aguarde, migrando dados da tabela censocursoprofiss para a base {$sBase}\n";
  pg_query("select fc_startsession();"); 
  pg_query("select fc_putsession('DB_login', 'iuri');"); 
  $iCodigoGrupo = 0;
  foreach ($aLinhasArquivo as $sLinha) {
     
    $aCampos                    = explode(";", $sLinha);
    $sPrimeiroCampo             = $aCampos[0];

    if (trim($sPrimeiroCampo) != "") {
     
     $aDadosCampo = explode(".", $sPrimeiroCampo);
     $iCodigoGrupo = $aDadosCampo[0];

    }
    $iCodigoCurso = $aCampos[1]; 
    if (trim($iCodigoCurso) == "") {
     continue;
    }
    $sDescricaoCurso  = strtoupper(TiraAcento(trim($aCampos[2])));
    $sSqlVerificaExistente = "select * From censocursoprofiss where ed247_i_codigo = {$iCodigoCurso}";
    $rsSqlExiste           = pg_query($sSqlVerificaExistente);
    if (pg_num_rows($rsSqlExiste) > 0) {
      
      $sSqlAcerto        = "update censocursoprofiss set";
      $sSqlAcerto       .= "       ed247_c_descr   = '{$sDescricaoCurso}', ";
      $sSqlAcerto       .= "       ed247_i_tipo    = {$iCodigoGrupo} ";
      $sSqlAcerto       .= " where  ed247_i_codigo = '{$iCodigoCurso}'";
      $iTotalAtualizados ++; 
    } else {

      $iTotalNovos++;
      $sSqlAcerto  = "insert into censocursoprofiss  ";
      $sSqlAcerto .= "            (ed247_i_codigo, ";
      $sSqlAcerto .= "             ed247_c_descr,";
      $sSqlAcerto .= "             ed247_i_tipo";
      $sSqlAcerto .= "            )";
      $sSqlAcerto .= "     values ( "; 
      $sSqlAcerto .= "             {$iCodigoCurso},";
      $sSqlAcerto .= "             '{$sDescricaoCurso}',";
      $sSqlAcerto .= "             {$iCodigoGrupo}";
      $sSqlAcerto .= "            )";
    }

   $rsAcerto =  pg_query($sSqlAcerto);
   if (!$rsAcerto) {
     echo $sSqlAcerto."\n";    
   }
 }
  echo "Total de Registros Atualizados: {$iTotalAtualizados}\n";
  echo "Total de Registros Novos:       {$iTotalNovos}\n";
?>
