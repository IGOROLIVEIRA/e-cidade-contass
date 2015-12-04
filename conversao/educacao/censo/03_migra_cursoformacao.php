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
  $aLinhasArquivo    =  file("arquivos/cursoformacao.csv");
  $iTotalAtualizados = 0;
  $iTotalNovos       = 0;

  echo "Aguarde, migrando dados da tabela cursoformacao para a base {$sBase}\n";
  pg_query("select fc_startsession();"); 
  pg_query("select fc_putsession('DB_login', 'iuri');"); 
  foreach ($aLinhasArquivo as $sLinha) {
     
    $aCampos                    = explode(";", $sLinha);
    $iCodigoCursoFormacao       = $aCampos[2];
    $iCodigoClasse              = $aCampos[0];
    $sDescricaoCursoFormacao    = strtoupper(TiraAcento(trim($aCampos[3]))); 
    $sClasseCursoFormacao       = strtoupper(TiraAcento(trim($aCampos[1]))); 
    $sGrauFormacao              = strtoupper(TiraAcento(trim($aCampos[4]))); 
    $iCodigoFormacao            = 0;
    switch ($sGrauFormacao) {
      
      case 'BACHARELADO':
        
        $iCodigoFormacao = 2;
        BREAK;
      case 'TECNOLOGICO':
        
        $iCodigoFormacao = 1;
        BREAK;
      case 'LICENCIATURA':
        
        $iCodigoFormacao = 3;
        BREAK;
    }
    $sSqlVerificaExistente = "select * From cursoformacao where  ed94_c_codigocenso = '{$iCodigoCursoFormacao}'";
    $rsSqlExiste           = pg_query($sSqlVerificaExistente);
    if (pg_num_rows($rsSqlExiste) > 0) {
      
      $sSqlAcerto        = "update cursoformacao set";
      $sSqlAcerto       .= "       ed94_c_descr         = '{$sDescricaoCursoFormacao}', ";
      $sSqlAcerto       .= "       ed94_c_descrclasse   = '{$sDescricaoCursoFormacao}', ";
      $sSqlAcerto       .= "       ed94_i_grauacademico = {$iCodigoFormacao}, ";
      $sSqlAcerto       .= "       ed94_i_codclasse     = {$iCodigoClasse} ";
      $sSqlAcerto       .= " where ed94_c_codigocenso   =   '{$iCodigoCursoFormacao}'";
      $iTotalAtualizados ++; 
    } else {

      $iTotalNovos++;
      $sSqlAcerto  = "insert into cursoformacao  ";
      $sSqlAcerto .= "            (ed94_i_codigo, ";
      $sSqlAcerto .= "             ed94_c_descr,";
      $sSqlAcerto .= "             ed94_c_descrclasse,";
      $sSqlAcerto .= "             ed94_i_codclasse,";
      $sSqlAcerto .= "             ed94_c_codigocenso, ";
      $sSqlAcerto .= "             ed94_i_grauacademico ";
      $sSqlAcerto .= "            )";
      $sSqlAcerto .= "     values (nextval('cursoformacao_ed94_i_codigo_seq'),";
      $sSqlAcerto .= "             '{$sDescricaoCursoFormacao}',";
      $sSqlAcerto .= "             '{$sClasseCursoFormacao}',";
      $sSqlAcerto .= "             {$iCodigoClasse},"; 
      $sSqlAcerto .= "             '{$iCodigoCursoFormacao}',";
      $sSqlAcerto .= "             '{$iCodigoFormacao}'";
      $sSqlAcerto .= "             )";
    }

   $rsAcerto =  pg_query($sSqlAcerto);
   if (!$rsAcerto) {
     echo $sSqlAcerto."\n";    
   }
 }
  echo "Total de Registros Atualizados: {$iTotalAtualizados}\n";
  echo "Total de Registros Novos:       {$iTotalNovos}\n";
?>
