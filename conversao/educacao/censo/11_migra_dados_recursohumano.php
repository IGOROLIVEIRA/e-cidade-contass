<?
 /**
  * Programa para atualização das tabelas Auxilizares do Censo.
  * Atualizacao da tabela censoorgemissrg
  */
 include (__DIR__ . "/../../../libs/db_conn.php");
 
 /**
  * Dados de Conexao
  */
/**
 $aDadosConexao = parse_ini_file("libs/db_conecta_avaliacoes.ini");
 $DB_SERVIDOR = $aDadosConexao["host"];
 $DB_BASE     = $aDadosConexao["dbname"];
 $DB_PORTA    = $aDadosConexao["port"];
 $DB_USUARIO  = $aDadosConexao["user"];
 $DB_SENHA    = $aDadosConexao["password"];
*/
 $conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA") or die ("Erro na conexão com o banco de dados");
 require_once(__DIR__ . "/../../../libs/db_utils.php");
 require_once(__DIR__ . "/../../../libs/db_stdlibwebseller.php");

 pg_query("select fc_startsession()");
 $sSqlRecursoHumano  = "select ed20_i_codigo, ";  
 $sSqlRecursoHumano .= "       ed20_c_posgraduacao,";
 $sSqlRecursoHumano .= "       ed20_c_outroscursos ";
 $sSqlRecursoHumano .= "  from rechumano ";
 echo "Aguarde, iniciando a migração dos dados do censo dos recursos humanos\n";
 $rsRecursoHumano  = pg_query($sSqlRecursoHumano);
 $aRecursosHumanos = db_utils::getCollectionByRecord($rsRecursoHumano);
 pg_query("begin");
 foreach ($aRecursosHumanos  as $oRecursoHumano) {
   
   echo "Migrando dados do Recurso Humano {$oRecursoHumano->ed20_i_codigo}\n";
   try {

    /**
     * Iniciando a verificando da avaliacao;
     */
     $sSqlVerificaAvaliacao     = "select ed309_avaliacaogruporesposta";
     $sSqlVerificaAvaliacao    .= "  from rechumanodadoscenso ";
     $sSqlVerificaAvaliacao    .= " where ed309_rechumano = {$oRecursoHumano->ed20_i_codigo} ";
     $rsAvaliacaoRecursoHumano  = pg_query($sSqlVerificaAvaliacao);
     if (!$rsAvaliacaoRecursoHumano) {
       throw new Exception("Erro ao selecionar dados da avaliacao do Recurso Humano. ".pg_last_error());
     }
       if (pg_num_rows($rsAvaliacaoRecursoHumano) == 0) {

       $sCodigoGrupoAvaliacao          = "select nextval('avaliacaogruporesposta_db107_sequencial_seq') as proximo_codigo";
       $rsCodigoGrupo                  = pg_query($sCodigoGrupoAvaliacao);
       $iCodigoGrupoAvaliacao          = db_utils::fieldsMemory($rsCodigoGrupo, 0)->proximo_codigo;
       $sInsertAvaliacaoGrupoResposta  = "insert into avaliacaogruporesposta ";
       $sInsertAvaliacaoGrupoResposta .= "            (db107_sequencial,";
       $sInsertAvaliacaoGrupoResposta .= "             db107_usuario,   ";
       $sInsertAvaliacaoGrupoResposta .= "             db107_datalancamento, ";
       $sInsertAvaliacaoGrupoResposta .= "             db107_hora)" ;
       $sInsertAvaliacaoGrupoResposta .= "     values  ({$iCodigoGrupoAvaliacao}, ";
       $sInsertAvaliacaoGrupoResposta .= "              1,  ";
       $sInsertAvaliacaoGrupoResposta .= "              current_date, ";
       $sInsertAvaliacaoGrupoResposta .= "              '00:00' ";
       $sInsertAvaliacaoGrupoResposta .= "             )";

       $rsInsertAvaliacaoGrupo         = pg_query($sInsertAvaliacaoGrupoResposta);
       if (!$rsInsertAvaliacaoGrupo) {
          throw new exception ("Erro ao inserir dados da avaliacao da RecursoHumano");
       }
       $sInsertDadosCensoRecursoHumano  = "insert into rechumanodadoscenso";
       $sInsertDadosCensoRecursoHumano .= "            (ed309_sequencial, ";
       $sInsertDadosCensoRecursoHumano .= "             ed309_avaliacaogruporesposta,";
       $sInsertDadosCensoRecursoHumano .= "            ed309_rechumano)";
       $sInsertDadosCensoRecursoHumano .= "     values (nextval('rechumanodadoscenso_ed309_sequencial_seq'), ";
       $sInsertDadosCensoRecursoHumano .= "            {$iCodigoGrupoAvaliacao}, ";
       $sInsertDadosCensoRecursoHumano .= "            {$oRecursoHumano->ed20_i_codigo})";
       $rsInsertDadosRecursoHumanoCenso = pg_query($sInsertDadosCensoRecursoHumano);
       if (!$rsInsertDadosRecursoHumanoCenso) {
          throw new exception ("Erro ao inserir dados do censo da RecursoHumano");
       }
     } else {

        $iCodigoGrupoAvaliacao = db_utils::fieldsMemory($rsAvaliacaoRecursoHumano, 0)->ed309_avaliacaogruporesposta;
     }
     
     /**
      * iniciamos a migração das outros cursos do  RecursoHumanos.
      * para isso fazemso um de-para do campo 
      */ 
     $aRespostasRecursoHumano = array(); 
     $lEspecializacao   = substr($oRecursoHumano->ed20_c_posgraduacao, 0, 1) == 1?true:false;
     if ($lEspecializacao) {
       $aRespostasRecursoHumano[] = 3000073;
     }
     $lMestrado   = substr($oRecursoHumano->ed20_c_posgraduacao, 1, 1) == 1?true:false;
     if ($lMestrado) {
       $aRespostasRecursoHumano[] = 3000074;
     }
     $lDoutorado   = substr($oRecursoHumano->ed20_c_posgraduacao, 2, 1) == 1?true:false;
     if ($lDoutorado) {
       $aRespostasRecursoHumano[] = 3000075;
     }
     $lNenhum   = substr($oRecursoHumano->ed20_c_posgraduacao, 3, 1) == 1?true:false;
     if ($lNenhum) {
       $aRespostasRecursoHumano[] = 3000076;
     }
     /**
      * Outros Cursos
      */
     $lEspecificoCreche  = substr($oRecursoHumano->ed20_c_outroscursos, 0, 1) == 1?true:false;
     if ($lEspecificoCreche) {
       $aRespostasRecursoHumano[] = 3000077;
     }
     $lEspecificoPreEscola  = substr($oRecursoHumano->ed20_c_outroscursos, 1, 1) == 1?true:false;
     if ($lEspecificoPreEscola) {
       $aRespostasRecursoHumano[] = 3000078;
     }
     $lAnosIniciais  = substr($oRecursoHumano->ed20_c_outroscursos, 2, 1) == 1?true:false;
     if ($lAnosIniciais) {
       $aRespostasRecursoHumano[] = 3000079;
     }
     $lAnosFinais   = substr($oRecursoHumano->ed20_c_outroscursos, 3, 1) == 1?true:false;
     if ($lAnosFinais) {
       $aRespostasRecursoHumano[] = 3000080;
     }

     $lEnsinoMedio   = substr($oRecursoHumano->ed20_c_outroscursos, 4, 1) == 1?true:false;
     if ($lEnsinoMedio) {
       $aRespostasRecursoHumano[] = 3000081;
     }
     $lEja   = substr($oRecursoHumano->ed20_c_outroscursos, 5, 1) == 1?true:false;
     if ($lEja) {
       $aRespostasRecursoHumano[] = 3000082;
     }

     $lModalidadeSubstitutiva  = substr($oRecursoHumano->ed20_c_outroscursos, 6, 1) == 1?true:false;
     if ($lModalidadeSubstitutiva) {
       $aRespostasRecursoHumano[] = 3000083;
     }
     $lEducacaoIndigena  = substr($oRecursoHumano->ed20_c_outroscursos, 7, 1) == 1?true:false;
     if ($lEducacaoIndigena) {
       $aRespostasRecursoHumano[] = 3000084;
     }
     $lIntercultural  = substr($oRecursoHumano->ed20_c_outroscursos, 8, 1) == 1?true:false;
     if ($lIntercultural) {
       $aRespostasRecursoHumano[] = 3000085;
     }
     $lOutros  = substr($oRecursoHumano->ed20_c_outroscursos, 9, 1) == 1?true:false;
     if ($lIntercultural) {
       $aRespostasRecursoHumano[] = 3000086;
     }
     $lNenhum  = substr($oRecursoHumano->ed20_c_outroscursos, 10, 1) == 1?true:false;
     if ($lNenhum) {
       $aRespostasRecursoHumano[] = 3000121;
     }
     /*
      * Deletamos todos os dados da avaliacao da RecursoHumano.
      */
     $sSqlRespostasRecursoHumano     = "select db108_avaliacaoresposta, db108_sequencial ";
     $sSqlRespostasRecursoHumano    .= "  from avaliacaogrupoperguntaresposta ";
     $sSqlRespostasRecursoHumano    .= " where db108_avaliacaogruporesposta = {$iCodigoGrupoAvaliacao} ";
     $rsRespostas             = pg_query($sSqlRespostasRecursoHumano);
     $aRespostasRecursoHumanoSalvas  = db_utils::getCollectionByRecord($rsRespostas);
     foreach ($aRespostasRecursoHumanoSalvas as $oResposta) {
       
       $sDeleteGrupoResposta = "delete from avaliacaogrupoperguntaresposta where  db108_sequencial = {$oResposta->db108_sequencial} ";
       pg_query($sDeleteGrupoResposta);

       $sDeleteResposta = "delete from avaliacaoresposta where db106_sequencial = {$oResposta->db108_avaliacaoresposta} ";
       pg_query($sDeleteResposta);
     }
     /**
      * Incluimos as respostas da RecursoHumano
      */
      foreach ($aRespostasRecursoHumano as $mResposta) {

        $sTextoResposta = '';
        if (is_array($mResposta)) {

          $iCodigoResposta = $mResposta[0];
          $sTextoResposta  = $mResposta[1];
        } else {
          $iCodigoResposta  = $mResposta;  
        }
        $sNextvalAvaliacaoResposta = "select nextval('avaliacaoresposta_db106_sequencial_seq') as proximo_codigo";
        $iProximoCodigoResposta    = db_utils::fieldsMemory(pg_query($sNextvalAvaliacaoResposta), 0)->proximo_codigo;
        $sInsertAvaliacaoResposta  = "insert into avaliacaoresposta ";
        $sInsertAvaliacaoResposta .= "       (db106_sequencial, ";
        $sInsertAvaliacaoResposta .= "        db106_avaliacaoperguntaopcao,";
        $sInsertAvaliacaoResposta .= "        db106_resposta ) ";
        $sInsertAvaliacaoResposta .= " values ({$iProximoCodigoResposta}, ";
        $sInsertAvaliacaoResposta .= "         {$iCodigoResposta}, ";
        $sInsertAvaliacaoResposta .= "         '{$sTextoResposta}' )";

        $rsInsertAvaliacaoResposta = pg_query($sInsertAvaliacaoResposta);
        if (!$rsInsertAvaliacaoResposta) {
         throw new Exception("Erro ao incluir Resposta");
        }
       
        $sInsertGrupoResposta  = "insert into avaliacaogrupoperguntaresposta ";
        $sInsertGrupoResposta .= "            (db108_sequencial,";
        $sInsertGrupoResposta .= "             db108_avaliacaogruporesposta, ";
        $sInsertGrupoResposta .= "            db108_avaliacaoresposta) ";
        $sInsertGrupoResposta .= " values (nextval('avaliacaogrupoperguntaresposta_db108_sequencial_seq'),";
        $sInsertGrupoResposta .= "        {$iCodigoGrupoAvaliacao},";
        $sInsertGrupoResposta .= "        {$iProximoCodigoResposta} )";
        $rsInsertGrupoResposta = pg_query($sInsertGrupoResposta);
        if (!$rsInsertGrupoResposta) {
          throw new Exception("Erro ao incluir grupo de  Resposta");
        }
      }
     unset($aRespostasRecursoHumanoSalvas);
     print_r($aRespostasRecursoHumano);
     pg_query("commit");
   } catch (Exception $eErro) {

     pg_query("rollback");
     echo $eErro->getMessage();  
   }
 }
 pg_query("commit");
 echo "Fim da Migração dos dados das RecursoHumanos\n";
 ?>
