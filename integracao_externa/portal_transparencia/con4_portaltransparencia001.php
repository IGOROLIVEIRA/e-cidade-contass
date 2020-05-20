<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */


/**
 * Alterado memria do PHP on the fly, para no estourar a carga dos dados do servidor
 */
ini_set("memory_limit", '-1');


$HTTP_SESSION_VARS['DB_acessado']       = 1;
$HTTP_SESSION_VARS['DB_datausu']        = time();
$HTTP_SESSION_VARS['DB_anousu']         = date('Y',time());
$HTTP_SESSION_VARS['DB_id_usuario']     = 1;
$HTTP_SESSION_VARS['DB_login']          = '';
$HTTP_SESSION_VARS['DB_traceLogAcount'] = false;

/*
 * Adicioando debug no script pelo tracelog, basta informar o parametro debug no momento de executar o script
 * php con4_portaltransparencia001.php debug
 *
 * ATENO:
 * Ser executado o script normalmente, se no ocorrer erro: COMMIT!
 */
if (isset($argv[1]) && $argv[1] == "debug") {
    $HTTP_SESSION_VARS['DB_traceLogAcount'] = true;
}

/**
 *  Nmero de bases antigas que o script ir manter automticamente
 */
$iNroBasesAntigas = 2;

/**
 *  Nome do Schema gerado pelo script
 */
$sSchema    = "transparencia";
$sBkpSchema = "bkp_transparencia_".date("Ymd_His");

/**
 *  A varivel iParamLog define o tipo de log que deve ser gerado :
 *  0 - Imprime log na tela e no arquivo
 *  1 - Imprime log somente da tela
 *  2 - Imprime log somente no arquivo
 */
$iParamLog = 0;

/**
 * Exericio corrente
 */
$iExercicio = date('Y',time());
if ( $iParamLog == 1 ) {
    $sArquivoLog = null;
} else {
    $sArquivoLog = "log/processamento_transparencia".date("Ymd_His").".log";
}

require_once('libs/dbportal.constants.php');
require_once('libs/db_conecta.php');
require_once('libs/databaseVersioning.php');
require_once(DB_MODEL."model/configuracao/TraceLog.model.php");
require_once(DB_MODEL."model/integracao/transparencia/IntegracaoPortalTransparencia.model.php");
require_once(DB_MODEL."model/integracao/transparencia/IntegracaoLicitacao.model.php");
require_once(DB_MODEL."model/integracao/transparencia/IntegracaoContrato.model.php");
require_once(DB_LIBS ."std/label/rotulo.php");
require_once(DB_LIBS ."std/label/RotuloDB.php");
require_once(DB_LIBS ."libs/db_stdlib.php");
require_once(DB_LIBS ."libs/db_utils.php");
require_once(DB_LIBS ."libs/db_sql.php");
require_once(DB_LIBS ."libs/db_libcontabilidade.integracao.php");
require_once(DB_MODEL."model/dataManager.php");

/**
 *  Exerccio que ser utilizado como base para migrao, ou seja sero consultados apenas
 *  dados apartir do exerccio informado.
 */
$iExercicioBase = EXERCICIO_BASE;
$aIntegracoesRealizar = array();
if (defined("INTEGRACOES_TRANSPARENCIA")) {
    $aIntegracoesRealizar = explode(",", INTEGRACOES_TRANSPARENCIA);
}

/**
 * Adicionado verificao para configurar a constant caso o cliente use PCASP
 */
$lUsarPcasp         = false;
$sSqlConParametro   = " select c90_usapcasp ";
$sSqlConParametro  .= "   from contabilidade.conparametro ";
$rsConParametro     = db_query($sSqlConParametro);
$lParametroUsaPCASP = pg_result($rsConParametro, 0, 0);
$iAnoServidor       = date("Y");

$iAnoImplantacaoPCASP = 2013;

if ($lParametroUsaPCASP == 't') {

    $sSqlTipoInstituicao  = "select db21_tipoinstit ";
    $sSqlTipoInstituicao .= "  from configuracoes.db_config ";
    $sSqlTipoInstituicao .= " where codigo = (select db_config.codigo from configuracoes.db_config where db_config.prefeitura is true)";
    $rsTipoInstituicao    = db_query($connOrigem, $sSqlTipoInstituicao);
    if (pg_num_rows($rsTipoInstituicao) == 1 && isset($iAnoServidor)) {

        $iTipoInstituicao = pg_result($rsTipoInstituicao, 0, "db21_tipoinstit");
        if ($iTipoInstituicao == 101) {

            if ($iAnoServidor >= 2012) {
                $lUsarPcasp = true;
            }

        } else {

            /**
             * Ano de implacantacao do PCASP
             * - busca ano do arquivo config/pcasp.txt
             * - caso arquivo nao exista sera 2013
             */
            if ( file_exists(DB_LIBS . 'config/pcasp.txt') ) {
                $iAnoImplantacaoPCASP = trim(file_get_contents(DB_LIBS . 'config/pcasp.txt'));
            }

            /**
             * Usar PCASP:
             * - Ano do servidor e ano de implantao do PCASP tem que ser maior ou igual a 2013
             */
            if ($iAnoServidor >= $iAnoImplantacaoPCASP && $iAnoImplantacaoPCASP >= 2013) {
                $lUsarPcasp = true;
            }
        }
    }
}

$iAnoAnteriorImplantacaoPCASP = $iAnoImplantacaoPCASP - 1;

define("USE_PCASP", $lUsarPcasp);
define("ANO_IMPLANTACAO_PCASP", $iAnoImplantacaoPCASP);
define("ANO_ANTERIOR_IMPLANTACAO_PCASP", $iAnoAnteriorImplantacaoPCASP);

if ( isset($argv[1])) {

    db_putsession("DB_traceLog", true);
    db_putsession("DB_login", "dbseller");
}

/**
 *  Caso o parmetro seja passado como true ento sero processados
 *  todas empresas cadastradas, caso contrrio sero processadas apenas
 *  as empresas cadastradas ou alteradas no dia
 */

$lErro      = false;
$dtDataHoje = date("Y-m-d");
$iAnoUsu    = date("Y");
$sHoraHoje  = date('H:i');

/**
 *  Inicia sesso e transao
 */
db_query($connOrigem ,"select fc_startsession();");
db_query($connDestino,"BEGIN;");

/**
 *  Verifica se existem atualizaes de base de dados
 *  e as aplica na mesma
 */






try {

  // SALVA PESSOAS QUE ACESSARAM DADOS DE FOLHA DE PAGAMENTO DO TRANSPARENCIA NO E-CIDADE
  $sSqlMaxRequisitante = "SELECT MAX(db149_data) AS maxdata FROM requisitantes_transparencia";
  $rsMaxRequisitantes = db_query($connOrigem, $sSqlMaxRequisitante);
  if ( !$rsMaxRequisitantes) {
    throw new Exception("ERRO-0: Erro ao buscar maior data requisitantes_transparencia !".$sSqlMaxRequisitante);
  }

  $sSqlRequisitantes = "SELECT * FROM transparencia.requisitantes";
  if(!empty(db_utils::fieldsMemory($rsMaxRequisitantes,0)->maxdata)) {
    $sSqlRequisitantes .= " WHERE data > '".db_utils::fieldsMemory($rsMaxRequisitantes,0)->maxdata."'";
  }
  $rsRequisitantes = db_query($connDestino, $sSqlRequisitantes);
  if ( !$rsRequisitantes) {
    throw new Exception("ERRO-0: Erro ao buscar requisitantes !".$sSqlRequisitantes);
  }
  for ( $iInd=0; $iInd < pg_num_rows($rsRequisitantes); $iInd++ ) {

    $oRequisitante = db_utils::fieldsMemory($rsRequisitantes,$iInd);
    $sSqlInserirRequisitante = "INSERT INTO requisitantes_transparencia
    (db149_matricula,db149_cpf,db149_nome,db149_data)
    VALUES 
    ({$oRequisitante->matricula},'{$oRequisitante->cpf}','{$oRequisitante->nome}','{$oRequisitante->data}')";

    if ( !db_query($connOrigem, $sSqlInserirRequisitante)) {
      throw new Exception("ERRO-0: Erro ao inserir requisitantes do transparencia ao e-cidade !".$sSqlInserirRequisitante);
    }
  }

    // RENOMEIA DE SCHEMAS ANTIGOS ************************************************************************************//

    $sSqlConsultaSchemasAtual = "select distinct schema_name
  from information_schema.schemata
  where schema_name = '{$sSchema}' ";
    $rsSchemasAtual      = db_query($connDestino,$sSqlConsultaSchemasAtual);
    $iLinhasSchemasAtual = pg_num_rows($rsSchemasAtual);

    if ( $iLinhasSchemasAtual > 0 ) {

        $sSqlRenomeiaSchema = " ALTER SCHEMA {$sSchema} RENAME TO {$sBkpSchema} ";

        if ( !db_query($connDestino,$sSqlRenomeiaSchema)) {
            throw new Exception("ERRO-0: Erro ao renomear schema !".$sSqlRenomeiaSchema);
        }
    }

    // CRIA NOVO SCHEMA ***********************************************************************************************//


    $sSqlCriaSchema = "CREATE SCHEMA {$sSchema} ";

    if ( !db_query($connDestino,$sSqlCriaSchema) ) {
        throw new Exception("Falha ao criar schema {$sSchema} !");
    }


    // ****************************************************************************************************************//

    $sSqlAlteraSchemaAtual = "ALTER DATABASE \"".$ConfigConexaoDestino["dbname"]."\" SET search_path TO {$sSchema} ";

    if ( !db_query($connDestino,$sSqlAlteraSchemaAtual)) {
        throw new Exception("Falha ao alterar schema atual para {$sSchema} !");
    }

    $sSqlDefineSchemaAtual = "SET search_path TO {$sSchema} ";

    if ( !db_query($connDestino,$sSqlDefineSchemaAtual) ) {
        throw new Exception("Falha ao definir schema atual para {$sSchema} !");
    }


    $rsUpgradeDatabase = upgradeDatabase($connDestino,'.',$sSchema);

    if (!$rsUpgradeDatabase) {
        throw new Exception("Falha ao atualizar base de dados!");
    }


    /**
     *  O script abaixo corrige possveis erros de base na tabela conplano, sendo elas podendo ser originrias
     *  da tabela orcdotacao ou orcreceita
     */
    $sSqlCorrigeConplano  = " SELECT DISTINCT o58_codele, ";
    $sSqlCorrigeConplano .= "                 o58_anousu ";
    $sSqlCorrigeConplano .= " FROM orcdotacao ";
    $sSqlCorrigeConplano .= " WHERE NOT EXISTS ";
    $sSqlCorrigeConplano .= "       (SELECT * FROM conplano ";
    $sSqlCorrigeConplano .= "        WHERE c60_codcon = o58_codele ";
    $sSqlCorrigeConplano .= "          AND c60_anousu = o58_anousu ) ";
    $sSqlCorrigeConplano .= "   AND EXISTS ";
    $sSqlCorrigeConplano .= "       (SELECT * FROM empempenho ";
    $sSqlCorrigeConplano .= "        WHERE e60_anousu = o58_anousu) ";

    $rsCorrigeConplano      = db_query($connOrigem,$sSqlCorrigeConplano);
    $iLinhasCorrigeConplano = pg_num_rows($rsCorrigeConplano);


    for ( $iInd=0; $iInd < $iLinhasCorrigeConplano; $iInd++ ) {

        $oConplano = db_utils::fieldsMemory($rsCorrigeConplano,$iInd);

        $sSqlOrcElemento = " select *
    from orcelemento
    where o56_codele  = {$oConplano->o58_codele}
    and o56_anousu >= {$oConplano->o58_anousu}
    order by o56_anousu asc ";

        $rsOrcElemento      = db_query($connOrigem,$sSqlOrcElemento);
        $iLinhasOrcElemento = pg_num_rows($rsOrcElemento);


        /**
         *  Caso exista registros na orcelemento, ento ser inserido um registro na conplano com base nesse registro
         *  caso contrrio ser procurado na conplano algum registro da mesma conta em outro exerccio.
         */
        if ( $iLinhasOrcElemento > 0 ) {

            $oOrcElemento = db_utils::fieldsMemory($rsOrcElemento,0);

            $sTabelaPlano = "conplano";
            if (USE_PCASP && $iExercicio >= ANO_IMPLANTACAO_PCASP) {
                $sTabelaPlano = "conplanoorcamento";
            }
            $sSqlInsereConplano = " insert into {$sTabelaPlano} ( c60_codcon,
      c60_anousu,
      c60_estrut,
      c60_descr,
      c60_finali,
      c60_codsis,
      c60_codcla
      ) values (
      {$oOrcElemento->o56_codele},
      {$oConplano->o58_anousu},
      '{$oOrcElemento->o56_elemento}',
      '{$oOrcElemento->o56_descr}',
      '{$oOrcElemento->o56_finali}',
      1,
      1
      )";

            /**
             * Condicao comentada pois caso a tabela de destino contenha os dados, a rotina eh abortada
             */
            /*
            if (!db_query($connOrigem,$sSqlInsereConplano)) {
              throw new Exception("ERRO-0: 1 - Falha ao inserir na conplano $sSqlInsereConplano");
            }
            */

        } else {

            $sSqlConplano = "select *
      from conplano
      where c60_codcon = {$oConplano->o58_codele}";

            $rsConplano      = db_query($connOrigem,$sSqlConplano);
            $iLinhasConplano = pg_num_rows($rsConplano);

            if ($iLinhasConplano > 0) {

                $oConplanoOrigem    = db_utils::fieldsMemory($rsConplano,0);
                $sTabelaPlano = "conplano";
                if (USE_PCASP && $iExercicio >= ANO_IMPLANTACAO_PCASP) {
                    $sTabelaPlano = "conplanoorcamento";
                }
                $sSqlInsereConplano = " insert into {$sTabelaPlano} ( c60_codcon,
        c60_anousu,
        c60_estrut,
        c60_descr,
        c60_finali,
        c60_codsis,
        c60_codcla
        ) values (
        {$oConplanoOrigem->c60_codcon},
        {$oConplano->o58_anousu},
        '{$oConplanoOrigem->c60_estrut}',
        '{$oConplanoOrigem->c60_descr}',
        '{$oConplanoOrigem->c60_finali}',
        {$oConplanoOrigem->c60_codsis},
        {$oConplanoOrigem->c60_codcla}
        )";

                /**
                 * Condicao comentada pois caso a tabela de destino contenha os dados, a rotina eh abortada
                 */
                /*
                if (!db_query($connOrigem,$sSqlInsereConplano)) {
                  throw new Exception("ERRO-0: 2 - Falha ao inserir na conplano $sSqlInsereConplano");
                }
                */

            } else {
                throw new Exception("ERRO-0: Erro na correo da tabela conplano ");
            }
        }
    }


    /**
     *  Consulta os registros da orcreceita com possveis erros de base
     */
    $sSqlCorrigeConplano = " select distinct
  o70_anousu,
  o70_codfon
  from orcreceita
  where not exists ( select *
  from conplano
  where c60_codcon = o70_codfon
  and c60_anousu = o70_anousu ) ";

    $rsCorrigeConplano      = db_query($connOrigem,$sSqlCorrigeConplano);
    $iLinhasCorrigeConplano = pg_num_rows($rsCorrigeConplano);


    for ( $iInd=0; $iInd < $iLinhasCorrigeConplano; $iInd++ ) {

        $oConplano = db_utils::fieldsMemory($rsCorrigeConplano,$iInd);



        $sSqlOrcFontes = " select *
    from orcfontes
    where o57_codfon  = {$oConplano->o70_codfon}
    and o57_anousu >= {$oConplano->o70_anousu}
    order by o57_anousu asc ";

        $rsOrcFontes      = db_query($connOrigem,$sSqlOrcFontes);
        $iLinhasOrcFontes = pg_num_rows($rsOrcFontes);


        /**
         *  Caso exista registros na orcfontes, ento ser inserido um registro na conplano com base nesse registro
         *  caso contrrio ser procurado na conplano algum registro da mesma conta em outro exerccio.
         */

        if ( $iLinhasOrcFontes > 0 ) {

            $oOrcFontes = db_utils::fieldsMemory($rsOrcFontes,0);
            $sTabelaPlano = "conplano";
            if (USE_PCASP && $iExercicio >= ANO_IMPLANTACAO_PCASP) {
                $sTabelaPlano = "conplanoorcamento";
            }
            $sSqlInsereConplano = " insert into {$sTabelaPlano} ( c60_codcon,
      c60_anousu,
      c60_estrut,
      c60_descr,
      c60_finali,
      c60_codsis,
      c60_codcla
      ) values (
      {$oOrcFontes->o57_codfon},
      {$oConplano->o70_anousu},
      '{$oOrcFontes->o57_fonte}',
      '{$oOrcFontes->o57_descr}',
      '{$oOrcFontes->o57_finali}',
      1,
      1
      )";

            /**
             * Condicao comentada pois caso a tabela de destino contenha os dados, a rotina eh abortada
             */
            /*
            if (!db_query($connOrigem,$sSqlInsereConplano)) {
              throw new Exception("ERRO-0: 3 - Falha ao inserir na conplano $sSqlInsereConplano");
            }
            */

        } else {

            $sSqlConplano = "select *
      from conplano
      where c60_codcon = {$oConplano->o70_codfon}";

            $rsConplano      = db_query($connOrigem,$sSqlConplano);
            $iLinhasConplano = pg_num_rows($rsConplano);

            if ($iLinhasConplano > 0 ) {

                $sTabelaPlano = "conplano";
                if (USE_PCASP && $iExercicio >= ANO_IMPLANTACAO_PCASP) {
                    $sTabelaPlano = "conplanoorcamento";
                }
                $oConplanoOrigem    = db_utils::fieldsMemory($rsConplano,0);

                $sSqlInsereConplano = " insert into {$sTabelaPlano} ( c60_codcon,
        c60_anousu,
        c60_estrut,
        c60_descr,
        c60_finali,
        c60_codsis,
        c60_codcla
        ) values (
        {$oConplanoOrigem->c60_codcon},
        {$oConplano->o70_anousu},
        '{$oConplanoOrigem->c60_estrut}',
        '{$oConplanoOrigem->c60_descr}',
        '{$oConplanoOrigem->c60_finali}',
        {$oConplanoOrigem->c60_codsis},
        {$oConplanoOrigem->c60_codcla}
        )";

                /**
                 * Condicao comentada pois caso a tabela de destino contenha os dados, a rotina eh abortada
                 */
                /*
                if (!db_query($connOrigem,$sSqlInsereConplano)) {
                  throw new Exception("ERRO-0: 4 - Falha ao inserir na conplano $sSqlInsereConplano");
                }
                */
            } else {
                throw new Exception("ERRO-0: 1 - Erro na correo da tabela conplano ");
            }
        }
    }


    $oTBInstituicoes               = new tableDataManager($connDestino, 'instituicoes'                , 'id', true, 500);
    $oTBOrgaos                     = new tableDataManager($connDestino, 'orgaos'                      , 'id', true, 500);
    $oTBUnidades                   = new tableDataManager($connDestino, 'unidades'                    , 'id', true, 500);
    $oTBProjetos                   = new tableDataManager($connDestino, 'projetos'                    , 'id', true, 500);
    $oTBFuncoes                    = new tableDataManager($connDestino, 'funcoes'                     , 'id', true, 500);
    $oTBSubFuncoes                 = new tableDataManager($connDestino, 'subfuncoes'                  , 'id', true, 500);
    $oTBProgramas                  = new tableDataManager($connDestino, 'programas'                   , 'id', true, 500);
    $oTBRecursos                   = new tableDataManager($connDestino, 'recursos'                    , 'id', true, 500);
    $oTBPlanoContas                = new tableDataManager($connDestino, 'planocontas'                 , 'id', true, 500);
    $oTBReceitas                   = new tableDataManager($connDestino, 'receitas'                    , 'id', true, 500);
    $oTBReceitasMovimentacoes      = new tableDataManager($connDestino, 'receitas_movimentacoes'      , 'id', true, 500);
    $oTBDotacoes                   = new tableDataManager($connDestino, 'dotacoes'                    , 'id', true, 500);
    $oTBPessoas                    = new tableDataManager($connDestino, 'pessoas'                     , 'id', true, 500);
    $oTBEmpenhos                   = new tableDataManager($connDestino, 'empenhos'                    , 'id', true, 500);
    $oTBEmpenhosItens              = new tableDataManager($connDestino, 'empenhos_itens'              , 'id', true, 500);
    $oTBEmpenhosProcessos          = new tableDataManager($connDestino, 'empenhos_processos'          , 'id', true, 500);
    $oTBEmpenhosMovimentacoes      = new tableDataManager($connDestino, 'empenhos_movimentacoes'      , 'id', true, 500);
    $oTBEmpenhosMovimentacoesTipos = new tableDataManager($connDestino, 'empenhos_movimentacoes_tipos', 'id', true, 500);
    $oTBGlossarios                 = new tableDataManager($connDestino, 'glossarios'                  , 'id', true, 500);
    $oTBGlossariosTipos            = new tableDataManager($connDestino, 'glossarios_tipos'            , 'id', true, 500);
    $oTBServidores                 = new tableDataManager($connDestino, 'servidores'                  , ''  , true, 500);
    $oTBMovimentacoesServidores    = new tableDataManager($connDestino, 'servidor_movimentacoes'      , 'id', true, 500);
    $oTBFolhaPagamento             = new tableDataManager($connDestino, 'folha_pagamento'             , 'id', true, 500);
    $oTBAssentamentos              = new tableDataManager($connDestino, 'assentamentos'               , 'id', true, 500);
    $oTBRepasses              = new tableDataManager($connDestino, 'repasses'               , 'id', true, 500);


    /**
     *  Arrays utiliz ados  para  referenciar os respectivos cdigos de origem aos IDs novos gerados.
     */
    $aListaInstit                  = array();
    $aListaOrgao                   = array();
    $aListaUnidade                 = array();
    $aListaProjeto                 = array();
    $aListaFuncao                  = array();
    $aListaSubFuncao               = array();
    $aListaPrograma                = array();
    $aListaRecurso                 = array();
    $aListaPlanoConta              = array();
    $aListaReceita                 = array();
    $aListaDotacao                 = array();
    $aListaEmpenhoMovimentacaoTipo = array();
    $aMatrizMovimentacaoServidor   = array();


    // TABELA DE IMPORTOES *******************************************************************************************//

    db_logTitulo(" CONFIGURA TABELA DE IMPORTAO",$sArquivoLog,$iParamLog);

    $sSqlInsereImportacoes = " INSERT INTO importacoes (data,hora)
  VALUES ('{$dtDataHoje}',
  '$sHoraHoje') ";

    $rsInsereImportacoes   = db_query($connDestino,$sSqlInsereImportacoes);

    if ( !$rsInsereImportacoes ) {
        throw new Exception("ERRO-0: Erro ao inserir tabela de importaes!");
    }

    // FIM TABELA DE IMPORTOES ***************************************************************************************//

    // INSTITUIES **************************************************************************************************//

    db_logTitulo(" IMPORTA INSTITUIES",$sArquivoLog,$iParamLog);

    /**
     * Consulta Instituies na base de origem
     */
    $sSqlInstit  = " select db_config.codigo   as codinstit, ";
    $sSqlInstit .= "        db_config.nomeinst as descricao  ";
    $sSqlInstit .= "   from db_config                        ";

    $rsInstit     = db_query($connOrigem,$sSqlInstit);
    $iRowsInstit = pg_num_rows($rsInstit);

    if ( $iRowsInstit ==  0 ) {
        throw new Exception('Nenhuma instituio encontrada!');
    }

    db_logNumReg($iRowsInstit,$sArquivoLog,$iParamLog);

    /**
     *  Insere os registros na base de destino atravs do mtodo insertValue da classe TableDataManager que quando
     *  atinge o nmero determinado de registros ( informado na assinatura da classe )  executado automticamente
     *  o mtodo persist que insere fisicamente os registros na base de dados atravs do COPY.
     */
    for ( $iInd=0; $iInd < $iRowsInstit; $iInd++ ) {

        $oInstit = db_utils::fieldsMemory($rsInstit,$iInd);

        logProcessamento($iInd,$iRowsInstit,$iParamLog);

        $oTBInstituicoes->setByLineOfDBUtils($oInstit);

        try {
            $oTBInstituicoes->insertValue();
        } catch ( Exception $eException ) {
            throw new Exception("ERRO-0: {$eException->getMessage()}");
        }

    }

    /**
     *  Aps o loop  executado manualmente o mtodo persist para que sejam inserido os registros restantes
     *  ( mesmo que no tenha atingido o nmero mximo do bloco de registros )
     */
    try {
        $oTBInstituicoes->persist();
    } catch ( Exception $eException ) {
        throw new Exception("ERRO-0: {$eException->getMessage()}");
    }


    /**
     *   consultado as instituies cadastradas na base de destino para que seja populado o array $aListaInstit
     *  com as instituies cadastradas sendo a varivel indexada pelo cdigo da instituio da base de origem.
     *  Essa varivel ser utilizada por todo o fonte para identificar o cdigo da instituio de origem.
     */
    $sSqlListaInstitDestino  = " select *           ";
    $sSqlListaInstitDestino .= "  from instituicoes ";

    $rsListaInstitDestino    = db_query($connDestino,$sSqlListaInstitDestino);
    $iRowsListaInstitDestino = pg_num_rows($rsListaInstitDestino);

    if ( $iRowsListaInstitDestino == 0 ) {
        throw new Exception('Nenhum registro encontrado');
    }


    for ( $iInd=0; $iInd < $iRowsListaInstitDestino; $iInd++ ) {

        $oInstitDestino = db_utils::fieldsMemory($rsListaInstitDestino,$iInd);
        $aListaInstit[$oInstitDestino->codinstit] = $oInstitDestino->id;

    }

    // FIM INSTITUIES ***********************************************************************************************//

    // ORGOS *********************************************************************************************************//


    db_logTitulo(" IMPORTA ORGOS",$sArquivoLog,$iParamLog);

    /**
     * Consulta Orgos na base de origem
     */
    $sSqlOrgao  = " select o40_instit as codinstit,        ";
    $sSqlOrgao .= "        o40_orgao  as codorgao,         ";
    $sSqlOrgao .= "        o40_descr  as descricao,        ";
    $sSqlOrgao .= "        o40_anousu as exercicio         ";
    $sSqlOrgao .= "   from orcorgao                        ";

    $rsOrgao    = db_query($connOrigem,$sSqlOrgao);
    $iRowsOrgao = pg_num_rows($rsOrgao);

    if ( $iRowsOrgao ==  0 ) {
        throw new Exception('Nenhum orgo encontrado!');
    }

    db_logNumReg($iRowsOrgao,$sArquivoLog,$iParamLog);

    /**
     *  Insere os registros na base de destino atravs do mtodo insertValue da classe TableDataManager que quando
     *  atinge o nmero determinado de registros ( informado na assinatura da classe )  executado automticamente
     *  o mtodo persist que insere fisicamente os registros na base de dados atravs do COPY.
     */
    for ( $iInd=0; $iInd < $iRowsOrgao; $iInd++ ) {

        $oOrgao = db_utils::fieldsMemory($rsOrgao,$iInd);

        logProcessamento($iInd,$iRowsOrgao,$iParamLog);

        $oOrgao->instituicao_id = $aListaInstit[$oOrgao->codinstit];
        $oTBOrgaos->setByLineOfDBUtils($oOrgao);

        try {
            $oTBOrgaos->insertValue();
        } catch ( Exception $eException ) {
            throw new Exception("ERRO-0: {$eException->getMessage()}");
        }

    }

    /**
     *  Aps o loop  executado manualmente o mtodo persist para que sejam inserido os registros restantes
     *  ( mesmo que no tenha atingido o nmero mximo do bloco de registros )
     */
    try {
        $oTBOrgaos->persist();
    } catch ( Exception $eException ) {
        throw new Exception("ERRO-0: {$eException->getMessage()}");
    }



    /**
     *   consultado os orgos cadastrados na base de destino para que seja populado o array $aListaOrgao
     *  com os orgos cadastrados sendo a varivel indexada pelo cdigo do orgo da base de origem.
     *  Essa varivel ser utilizada por todo o fonte para identificar o cdigo do orgo de origem.
     */
    $sSqlListaOrgaoDestino  = " select *      ";
    $sSqlListaOrgaoDestino .= "   from orgaos ";

    $rsListaOrgaoDestino    = db_query($connDestino,$sSqlListaOrgaoDestino);
    $iRowsListaOrgaoDestino = pg_num_rows($rsListaOrgaoDestino);

    if ( $iRowsListaOrgaoDestino == 0 ) {
        throw new Exception('Nenhum registro encontrado');
    }

    for ( $iInd=0; $iInd < $iRowsListaOrgaoDestino; $iInd++ ) {

        $oOrgaoDestino = db_utils::fieldsMemory($rsListaOrgaoDestino,$iInd);
        $aListaOrgao[$oOrgaoDestino->codorgao][$oOrgaoDestino->exercicio] = $oOrgaoDestino->id;

    }

    // FIM ORGOS *****************************************************************************************************//


    // UNIDADES *******************************************************************************************************//


    db_logTitulo(" IMPORTA UNIDADES",$sArquivoLog,$iParamLog);

    /**
     * Consulta Unidades na base de origem
     */
    $sSqlUnidade  = " select o41_instit  as codinstit,       ";
    $sSqlUnidade .= "        o41_orgao   as codorgao,        ";
    $sSqlUnidade .= "        o41_unidade as codunidade,      ";
    $sSqlUnidade .= "        o41_descr   as descricao,       ";
    $sSqlUnidade .= "        o41_anousu  as exercicio        ";
    $sSqlUnidade .= "   from orcunidade                      ";

    $rsUnidade    = db_query($connOrigem,$sSqlUnidade);
    $iRowsUnidade = pg_num_rows($rsUnidade);

    if ( $iRowsUnidade ==  0 ) {
        throw new Exception('Nenhuma unidade encontrada!');
    }

    db_logNumReg($iRowsUnidade,$sArquivoLog,$iParamLog);

    /**
     *  Insere os registros na base de destino atravs do mtodo insertValue da classe TableDataManager que quando
     *  atinge o nmero determinado de registros ( informado na assinatura da classe )  executado automticamente
     *  o mtodo persist que insere fisicamente os registros na base de dados atravs do COPY.
     */
    for ( $iInd=0; $iInd < $iRowsUnidade; $iInd++ ) {

        $oUnidade = db_utils::fieldsMemory($rsUnidade,$iInd);

        logProcessamento($iInd,$iRowsUnidade,$iParamLog);

        $oUnidade->instituicao_id = $aListaInstit[$oUnidade->codinstit];
        $oUnidade->orgao_id       = $aListaOrgao[$oUnidade->codorgao][$oUnidade->exercicio];

        $oTBUnidades->setByLineOfDBUtils($oUnidade);

        try {
            $oTBUnidades->insertValue();
        } catch ( Exception $eException ) {
            throw new Exception("ERRO-0: {$eException->getMessage()}");
        }

    }

    /**
     *  Aps o loop  executado manualmente o mtodo persist para que sejam inserido os registros restantes
     *  ( mesmo que no tenha atingido o nmero mximo do bloco de registros )
     */
    try {
        $oTBUnidades->persist();
    } catch ( Exception $eException ) {
        throw new Exception("ERRO-0: {$eException->getMessage()}");
    }


    /**
     *   consultado as unidades cadastradas na base de destino para que seja populado o array $aListaUnidade
     *  com as unidades cadastradas sendo a varivel indexada pelo cdigo da unidade da base de origem.
     *  Essa varivel ser utilizada por todo o fonte para identificar o cdigo da unidade de origem.
     */
    $sSqlListaUnidadeDestino  = " select *        ";
    $sSqlListaUnidadeDestino .= "   from unidades ";

    $rsListaUnidadeDestino    = db_query($connDestino,$sSqlListaUnidadeDestino);
    $iRowsListaUnidadeDestino = pg_num_rows($rsListaUnidadeDestino);

    if ( $iRowsListaUnidadeDestino == 0 ) {
        throw new Exception('Nenhum registro encontrado');
    }

    for ( $iInd=0; $iInd < $iRowsListaUnidadeDestino; $iInd++ ) {

        $oUnidadeDestino = db_utils::fieldsMemory($rsListaUnidadeDestino,$iInd);
        $aListaUnidade[$oUnidadeDestino->codunidade][$oUnidadeDestino->exercicio] = $oUnidadeDestino->id;

    }

    // FIM UNIDADES ***************************************************************************************************//


    /*

    OC5254 exigia exibio dos repasses recebidos e devolvidos da referntes  instituio Cmara
    */

    // REPASSES *******************************************************************************************************//
    $instit   = db_utils::fieldsMemory(db_query("SELECT codigo FROM db_config LEFT JOIN infocomplementaresinstit ON si09_instit = codigo WHERE si09_tipoinstit = 1"),0)->codigo;
    $matrixResultados = array();

    if ($instit) {
        $ianoMin = db_utils::fieldsMemory(db_query("select MIN(c60_anousu) as ano from conplano where c60_anousu = 2015;"), 0)->ano;
        $ianoMax = db_utils::fieldsMemory(db_query("select MAX(c60_anousu) as ano from conplano;"), 0)->ano;

        for ($i = $ianoMin; $i <= $ianoMax; $i++) {
            for ($j = 1; $j <= 12; $j++) {
                $dataInicial = date_create("$i-$j-01");
                $dataInicial = date_format($dataInicial, 'Y-m-d');
                if ($j == 12) {
                    $dataFinal = date_create(($i + 1) . '-01-01');
                    date_sub($dataFinal, date_interval_create_from_date_string('1 days'));
                    $dataFinal = date_format($dataFinal, 'Y-m-d');
                } else {
                    $dataFinal = date_create($i . '-' . ($j + 1) . '-01');
                    date_sub($dataFinal, date_interval_create_from_date_string('1 days'));
                    $dataFinal = date_format($dataFinal, 'Y-m-d');
                }

                $data1 = $dataInicial;
                $data2 = $dataFinal;
                $variavel = '1';
                $sDocumentos = '';
                $relatorio = 's';
                $contrapartida = 'off';
                $saldopordia = 'n';
                $contasemmov = 's';
                $quebrapaginaporconta = 's';
                $estrut_inicial = '';
///////////////////////////////////////////////////////////////////////

                $contaold = null;
                $anousu = $i;


                $txt_where = " 1 = 1 ";
                $txt_where .= " and conplanoreduz.c61_instit =" . $instit;

                $txt_where = $txt_where . " and (conplano.c60_estrut like '3511209%' OR conplano.c60_estrut like '4511202%')";


//-----------------------------------------------------------------------------

                $sql_analitico = "select conplanoreduz.c61_codcon, conplanoreduz.c61_reduz, conplano.c60_estrut, conplano.c60_descr from conplanoreduz inner join conplano     on c60_codcon = conplanoreduz.c61_codcon and c60_anousu=conplanoreduz.c61_anousu where conplanoreduz.c61_anousu = " . $anousu . " and " . $txt_where . " order by conplano.c60_estrut";
//----------------------------------------------------------------------------

                $res = db_query($sql_analitico);

                $contador = 0;
                $total_final_debito_devolucao = 0;
                $total_final_credito_estorno = 0;
                $total_final_debito = 0;
                $total_final_credito = 0;
                $total_final_saldo_final = 0;

                $txt_where .= " and c53_coddoc not in (1009)";
                for ($contas = 0; $contas < pg_numrows($res); $contas++) {

                    db_fieldsmemory($res, $contas);

                    $conta_atual = $c61_reduz;
                    $txt_where2 = $txt_where . " and conplanoreduz.c61_reduz = $c61_reduz  and conplanoreduz.c61_instit = " . $instit;
                    $txt_where2 .= " and c69_data between '$data1' and '$data2'  and conplanoreduz.c61_instit = " . $instit;

                    $sql_analitico = "
        select conplanoreduz.c61_codcon,
        conplanoreduz.c61_reduz,
        conplano.c60_estrut,
        conplano.c60_descr as conta_descr,
        c69_codlan,
        c69_sequen,
        c69_data,
        c69_codhist,
        c53_coddoc,
        c53_descr,
        c69_debito,
        debplano.c60_descr as debito_descr,
        c69_credito,
        credplano.c60_descr as credito_descr,
        c69_valor,
        case when c69_debito = conplanoreduz.c61_reduz
        then 'D'
        else 'C'
         end  as tipo,
       c50_codhist,
       c50_descr,
       c74_codrec,
       c79_codsup,
       c75_numemp,
       e60_codemp,
       e60_resumo,
       e60_anousu,
       c73_coddot,
       c76_numcgm,
       c78_chave,
       c72_complem ,
       z01_numcgm,
       z01_nome,
       ( select k81_codpla
       from conlancamcorrente
       inner join corplacaixa on k82_data = c86_data and k82_id = c86_id and k82_autent = c86_autent
       inner join placaixarec on k81_seqpla = k82_seqpla
       where c86_conlancam = c69_codlan ) as planilha,

       ( select distinct c84_slip
       from conlancamcorrente
       inner join corlanc on c86_id     = k12_id
       and c86_data   = k12_data
       and c86_autent = k12_autent
       inner join conlancamslip on c84_slip = k12_codigo
       where c86_conlancam = c69_codlan) as slip

       from conplanoreduz
       inner join conlancamval on  c69_anousu=conplanoreduz.c61_anousu and ( c69_debito=conplanoreduz.c61_reduz or c69_credito = conplanoreduz.c61_reduz)
       inner join conplano     on c60_codcon = conplanoreduz.c61_codcon and c60_anousu=conplanoreduz.c61_anousu
       inner join conplanoreduz debval on debval.c61_anousu = conlancamval.c69_anousu and
       debval.c61_reduz  = conlancamval.c69_debito
       inner join conplano  debplano  on debplano.c60_anousu = debval.c61_anousu and
       debplano.c60_codcon = debval.c61_codcon
       inner join conplanoreduz credval on credval.c61_anousu = conlancamval.c69_anousu and
       credval.c61_reduz  = conlancamval.c69_credito
       inner join conplano  credplano  on credplano.c60_anousu = credval.c61_anousu and
       credplano.c60_codcon = credval.c61_codcon

       left join conhist          on c50_codhist = c69_codhist
       left join conlancamdoc on c71_codlan  = c69_codlan
       left join conhistdoc   on c53_coddoc  = conlancamdoc.c71_coddoc
       left join conlancamrec on c74_codlan = c69_codlan
       and c74_anousu = c69_anousu
       left join conlancamsup on c79_codlan = c69_codlan

       left join conlancamemp on c75_codlan = c69_codlan
       left join empempenho   on  e60_numemp = conlancamemp.c75_numemp

       left join conlancamdot on c73_codlan = c69_codlan
       and c73_anousu = c69_anousu
       left join conlancamcgm on c76_codlan = c69_codlan
       left join cgm on z01_numcgm = c76_numcgm
       left join conlancamdig on c78_codlan = c69_codlan
       left join conlancamcompl on c72_codlan = c69_codlan
       where conplanoreduz.c61_anousu = {$anousu} and {$txt_where2}
       order by conplano.c60_estrut, c69_data,c69_codlan,c69_sequen ";

                    $reslista = db_query($sql_analitico);

                    if (!$reslista) {
                        echo "ERRO<br><br><br><br><br>";
                        die($sql_analitico);
                    }

                    if (pg_numrows($reslista) > 0) {
                        db_fieldsmemory($reslista, 0);
                        $datasaldo = $c69_data;
                    } else {
                        $datasaldo = $data1;
                    }

                    $sinal_dia = '';
                    $saldo_dia = 0;
                    $total_dia_debito = 0;
                    $total_dia_credito = 0;
                    $tot_mov_debito = 0;
                    $tot_mov_credito = 0;
                    $saldo_anterior = "";
                    $repete = "";
                    $repete_colunas = false;


                    $iTotalRegistros = pg_num_rows($reslista);
                    //------------------------------------------------------
                    if ($iTotalRegistros > 0) {

                        for ($x = 0; $x < $iTotalRegistros; $x++) {
                            db_fieldsmemory($reslista, $x);
                            $datasaldo = $c69_data;
                            if ($repete != $c61_codcon) {
                                // --- imprime movimentao da conta anterior, se houver conta anterior
                                if ($repete != "") {

                                    // --- calcula saldo final ---
                                    if ($tot_mov_debito > $tot_mov_credito)
                                        $sinal_final = "D";
                                    else
                                        $sinal_final = "C";
                                    if ($saldo_anterior != "") {
                                        if ($sinal_anterior == "D")
                                            $tot_mov_debito += $saldo_anterior;
                                        else
                                            $tot_mov_credito += $saldo_anterior;
                                    }

                                    // --- fim calculo saldo  final -- // --
                                }
                                //------------------ //  ------------------
                                $repete = $c61_codcon;
                                //--- saldo anterior
                                $saldo_anterior = 0;
                                $sinal_anterior = 'D';
                                $saldo_final_funcao = 0;
                                $c61_reduz_old = $c61_reduz; // na funo abaixoa tem um GLobal c61_reduz...

                                db_inicio_transacao();
                                $r_anterior = db_planocontassaldo_matriz($anousu, $data1, $data2, false, "c61_reduz = $c61_reduz and c61_instit=$instit");
                                db_fim_transacao(true);

                                @ $saldo_anterior = pg_result($r_anterior, 0, "saldo_anterior");
                                @ $sinal_anterior = pg_result($r_anterior, 0, "sinal_anterior");
                                @ $saldo_final_funcao = pg_result($r_anterior, 0, "saldo_final");
                                $c61_reduz = $c61_reduz_old; // devolvemos o valor a globals;

                                //-----------------------------
                                //---- totalizadores do movimento
                                $tot_mov_debito = 0;
                                $tot_mov_credito = 0;

                                $sinal_dia = $sinal_anterior;
                                $saldo_dia = $saldo_anterior;
                            }
                            $sNumeroEmpenho = "{$e60_codemp} / {$e60_anousu}";
                            if (empty($e60_codemp)) {
                                $sNumeroEmpenho = "";
                            }

                            // -- totalizadores do movimento -------------
                            if ($tipo == "D") {
                                $tot_mov_debito += $c69_valor;
                                $total_dia_debito += $c69_valor;
                            } else {
                                $tot_mov_credito += $c69_valor;
                                $total_dia_credito += $c69_valor;
                            }
                            //--------------   //   ----------------------

                        } // end for
                        // imprime totalizador da movimentao
                        if ($iTotalRegistros > 0) {
                            // --- calcula saldo final ---
                            if ($sinal_dia == "D")
                                $total_dia_debito += $saldo_dia;
                            else
                                $total_dia_credito += $saldo_dia;

                            if ($total_dia_debito > $total_dia_credito)
                                $sinal_dia = "D";
                            else
                                $sinal_dia = "C";
                            $saldo_dia = abs($total_dia_debito - $total_dia_credito);
                            $total_dia_debito = 0;
                            $total_dia_debito = 0;
                            // --- calcula saldo final ---
                            if ($saldo_anterior != "") {
                                if ($sinal_anterior == "D")
                                    $tot_mov_debito += $saldo_anterior;
                                else
                                    $tot_mov_credito += $saldo_anterior;
                            }
                            if ($tot_mov_debito > $tot_mov_credito)
                                $sinal_final = "D";
                            else
                                $sinal_final = "C";
                            $total_saldo_final = $tot_mov_debito - $tot_mov_credito;

                            //--- fim calculo saldo final
                        }
                    } else {

                        $reduz = $c61_reduz;
                        $descr = $c60_descr;
                        $estrut = $c60_estrut;

                        db_inicio_transacao();
                        $r_anterior = db_planocontassaldo_matriz($anousu, $data1, $data2, false, "c61_reduz = $reduz and c61_instit=$instit");
                        db_fim_transacao(true);
                        if ($contasemmov == 's') {

                            $saldo_anterior = @ pg_result($r_anterior, 0, "saldo_anterior");
                            $sinal_anterior = @ pg_result($r_anterior, 0, "sinal_anterior");
                            $saldo_final_funcao = @pg_result($r_anterior, 0, "saldo_final");

                        }
                    }

                    $contaold = null;
                    if ($iTotalRegistros > 0 || $contasemmov == 's') {
                        $contaold = $conta_atual;
                    }
                    if (substr($c60_estrut, 0, 7) == '3511209') {
                        $total_final_debito_devolucao += $tot_mov_debito;
                        $total_final_credito_estorno += $tot_mov_credito;
                    } else {
                        $total_final_debito += $tot_mov_debito;
                        $total_final_credito += $tot_mov_credito;
                    }
                }

                $total_final_credito = $total_final_credito > 0 ? ($total_final_credito - @$saldo_anterior) : 0;

                $matrixResultados[$i][$j]['credito_repasse_recebido'] = $total_final_credito;
                $matrixResultados[$i][$j]['debito_devolucao_repasse_recebido'] = $total_final_debito;

                $matrixResultados[$i][$j]['credito_devolucao_estorno_repasse_recebido'] = $total_final_credito_estorno;
                $matrixResultados[$i][$j]['debito_estorno_repasse_recebido'] = $total_final_debito_devolucao;

                $matrixResultados[$i][$j]['saldo_anterior'] = @$saldo_anterior;
                $matrixResultados[$i][$j]['saldo_total'] = @$saldo_anterior + (abs($total_final_credito) + abs($total_final_credito_estorno)) - (abs($total_final_debito) + abs($total_final_debito_devolucao));
            }
        }

        db_logTitulo(" IMPORTA REPASSES", $sArquivoLog, $iParamLog);
        db_logNumReg((count($matrixResultados) * 12), $sArquivoLog, $iParamLog);

        if (!empty($matrixResultados)) {
            $iInd = 0;
            foreach ($matrixResultados as $iAno => $aAno) {
                foreach ($aAno as $iMes => $aMes) {
                    $iInd++;
                    logProcessamento($iInd, (count($matrixResultados) * 12), $iParamLog);
                    $oRepasses = new stdClass();

                    $dataMovimentacao = date_create("$iAno-$iMes-01");
                    $dataMovimentacao = date_format($dataMovimentacao, 'Y-m-d');
                    $oRepasses->data = $dataMovimentacao;
                    $oRepasses->credito_repasse_recebido = $aMes['credito_repasse_recebido'];
                    $oRepasses->debito_devolucao_repasse_recebido = $aMes['debito_devolucao_repasse_recebido'];
                    $oRepasses->credito_devolucao_estorno_repasse_recebido = $aMes['credito_devolucao_estorno_repasse_recebido'];
                    $oRepasses->debito_estorno_repasse_recebido = $aMes['debito_estorno_repasse_recebido'];
                    $oRepasses->saldo = $aMes['saldo_total'];
                    $oRepasses->instituicao_id = $instit;
                    $oTBRepasses->setByLineOfDBUtils($oRepasses);
                    try {
                        $oTBRepasses->insertValue();
                    } catch (Exception $eException) {
                        throw new Exception("ERRO-0: {$eException->getMessage()}");
                    }
                }
            }
            try {
                $oTBRepasses->persist();
            } catch (Exception $eException) {
                throw new Exception("ERRO-0: {$eException->getMessage()}");
            }
        }

        // FIM REPASSES ***************************************************************************************************//

    }

    // PROJETOS *******************************************************************************************************//

    db_logTitulo(" IMPORTA PROJETOS",$sArquivoLog,$iParamLog);

    /**
     * Consulta Projetos na base de origem
     */
    $sSqlProjeto  = " select o55_instit   as codinstit,      ";
    $sSqlProjeto .= "        o55_tipo     as tipo,           ";
    $sSqlProjeto .= "        o55_projativ as codprojeto,     ";
    $sSqlProjeto .= "        o55_descr    as descricao,      ";
    $sSqlProjeto .= "        o55_anousu   as exercicio       ";
    $sSqlProjeto .= "   from orcprojativ                     ";

    $rsProjeto    = db_query($connOrigem,$sSqlProjeto);
    $iRowsProjeto = pg_num_rows($rsProjeto);

    if ( $iRowsProjeto ==  0 ) {
        throw new Exception('Nenhum projeto encontrado!');
    }

    db_logNumReg($iRowsProjeto,$sArquivoLog,$iParamLog);

    /**
     *  Insere os registros na base de destino atravs do mtodo insertValue da classe TableDataManager que quando
     *  atinge o nmero determinado de registros ( informado na assinatura da classe )  executado automticamente
     *  o mtodo persist que insere fisicamente os registros na base de dados atravs do COPY.
     */
    for ( $iInd=0; $iInd < $iRowsProjeto; $iInd++ ) {

        $oProjeto = db_utils::fieldsMemory($rsProjeto,$iInd);

        logProcessamento($iInd,$iRowsProjeto,$iParamLog);

        $oProjeto->instituicao_id = $aListaInstit[$oProjeto->codinstit];
        $oTBProjetos->setByLineOfDBUtils($oProjeto);

        try {
            $oTBProjetos->insertValue();
        } catch ( Exception $eException ) {
            throw new Exception("ERRO-0: {$eException->getMessage()}");
        }

    }

    /**
     *  Aps o loop  executado manualmente o mtodo persist para que sejam inserido os registros restantes
     *  ( mesmo que no tenha atingido o nmero mximo do bloco de registros )
     */
    try {
        $oTBProjetos->persist();
    } catch ( Exception $eException ) {
        throw new Exception("ERRO-0: {$eException->getMessage()}");
    }


    /**
     *   consultado os projetos cadastrados na base de destino para que seja populado o array $aListaProjeto
     *  com os projetos cadastrados sendo a varivel indexada pelo cdigo do projeto da base de origem.
     *  Essa varivel ser utilizada por todo o fonte para identificar o cdigo do projeto de origem.
     */
    $sSqlListaProjetoDestino  = " select *        ";
    $sSqlListaProjetoDestino .= "   from projetos ";

    $rsListaProjetoDestino    = db_query($connDestino,$sSqlListaProjetoDestino);
    $iRowsListaProjetoDestino = pg_num_rows($rsListaProjetoDestino);

    if ( $iRowsListaProjetoDestino == 0 ) {
        throw new Exception('Nenhum registro encontrado');
    }

    for ( $iInd=0; $iInd < $iRowsListaProjetoDestino; $iInd++ ) {

        $oProjetoDestino = db_utils::fieldsMemory($rsListaProjetoDestino,$iInd);
        $aListaProjeto[$oProjetoDestino->codprojeto][$oProjetoDestino->exercicio] = $oProjetoDestino->id;

    }

    // FIM PROJETOS ***************************************************************************************************//


    // FUNES ********************************************************************************************************//

    db_logTitulo(" IMPORTA FUNES",$sArquivoLog,$iParamLog);

    /**
     * Consulta Funes na base de origem
     */
    $sSqlFuncao  = " select o52_funcao as codfuncao, ";
    $sSqlFuncao .= "        o52_descr  as descricao  ";
    $sSqlFuncao .= "   from orcfuncao                ";

    $rsFuncao    = db_query($connOrigem,$sSqlFuncao);
    $iRowsFuncao = pg_num_rows($rsFuncao);

    if ( $iRowsFuncao ==  0 ) {
        throw new Exception('Nenhuma funo encontrada!');
    }

    db_logNumReg($iRowsFuncao,$sArquivoLog,$iParamLog);

    /**
     *  Insere os registros na base de destino atravs do mtodo insertValue da classe TableDataManager que quando
     *  atinge o nmero determinado de registros ( informado na assinatura da classe )  executado automticamente
     *  o mtodo persist que insere fisicamente os registros na base de dados atravs do COPY.
     */
    for ( $iInd=0; $iInd < $iRowsFuncao; $iInd++ ) {

        $oFuncao = db_utils::fieldsMemory($rsFuncao,$iInd);

        logProcessamento($iInd,$iRowsFuncao,$iParamLog);

        $oTBFuncoes->setByLineOfDBUtils($oFuncao);

        try {
            $oTBFuncoes->insertValue();
        } catch ( Exception $eException ) {
            throw new Exception("ERRO-0: {$eException->getMessage()}");
        }

    }

    /**
     *  Aps o loop  executado manualmente o mtodo persist para que sejam inserido os registros restantes
     *  ( mesmo que no tenha atingido o nmero mximo do bloco de registros )
     */
    try {
        $oTBFuncoes->persist();
    } catch ( Exception $eException ) {
        throw new Exception("ERRO-0: {$eException->getMessage()}");
    }


    /**
     *   consultado as funes cadastradas na base de destino para que seja populado o array $aListaFuncao
     *  com as funes cadastradas sendo a varivel indexada pelo cdigo da funo da base de origem.
     *  Essa varivel ser utilizada por todo o fonte para identificar o cdigo da funo de origem.
     */
    $sSqlListaFuncaoDestino  = " select *        ";
    $sSqlListaFuncaoDestino .= "   from funcoes  ";

    $rsListaFuncaoDestino    = db_query($connDestino,$sSqlListaFuncaoDestino);
    $iRowsListaFuncaoDestino = pg_num_rows($rsListaFuncaoDestino);

    if ( $iRowsListaFuncaoDestino == 0 ) {
        throw new Exception('Nenhum registro encontrado');
    }

    for ( $iInd=0; $iInd < $iRowsListaFuncaoDestino; $iInd++ ) {

        $oFuncaoDestino = db_utils::fieldsMemory($rsListaFuncaoDestino,$iInd);
        $aListaFuncao[$oFuncaoDestino->codfuncao] = $oFuncaoDestino->id;

    }

    // FIM FUNES ****************************************************************************************************//



    // SUBFUNES *****************************************************************************************************//

    db_logTitulo(" IMPORTA SUBFUNES",$sArquivoLog,$iParamLog);

    /**
     * Consulta Funes na base de origem
     */
    $sSqlSubFuncao  = " select o53_subfuncao as codsubfuncao, ";
    $sSqlSubFuncao .= "        o53_descr     as descricao     ";
    $sSqlSubFuncao .= "   from orcsubfuncao                   ";

    $rsSubFuncao    = db_query($connOrigem,$sSqlSubFuncao);
    $iRowsSubFuncao = pg_num_rows($rsSubFuncao);

    if ( $iRowsSubFuncao ==  0 ) {
        throw new Exception('Nenhuma SubFuno encontrada!');
    }

    db_logNumReg($iRowsSubFuncao,$sArquivoLog,$iParamLog);

    /**
     *  Insere os registros na base de destino atravs do mtodo insertValue da classe TableDataManager que quando
     *  atinge o nmero determinado de registros ( informado na assinatura da classe )  executado automticamente
     *  o mtodo persist que insere fisicamente os registros na base de dados atravs do COPY.
     */
    for ( $iInd=0; $iInd < $iRowsSubFuncao; $iInd++ ) {

        $oSubFuncao = db_utils::fieldsMemory($rsSubFuncao,$iInd);

        logProcessamento($iInd,$iRowsSubFuncao,$iParamLog);

        $oTBSubFuncoes->setByLineOfDBUtils($oSubFuncao);

        try {
            $oTBSubFuncoes->insertValue();
        } catch ( Exception $eException ) {
            throw new Exception("ERRO-0: {$eException->getMessage()}");
        }

    }

    /**
     *  Aps o loop  executado manualmente o mtodo persist para que sejam inserido os registros restantes
     *  ( mesmo que no tenha atingido o nmero mximo do bloco de registros )
     */
    try {
        $oTBSubFuncoes->persist();
    } catch ( Exception $eException ) {
        throw new Exception("ERRO-0: {$eException->getMessage()}");
    }


    /**
     *   consultado as subfunes cadastradas na base de destino para que seja populado o array $aListaSubFuncao
     *  com as subfunes cadastradas sendo a varivel indexada pelo cdigo da subfuno da base de origem.
     *  Essa varivel ser utilizada por todo o fonte para identificar o cdigo da subfuno de origem.
     */
    $sSqlListaSubFuncaoDestino  = " select *           ";
    $sSqlListaSubFuncaoDestino .= "   from subfuncoes  ";

    $rsListaSubFuncaoDestino    = db_query($connDestino,$sSqlListaSubFuncaoDestino);
    $iRowsListaSubFuncaoDestino = pg_num_rows($rsListaSubFuncaoDestino);

    if ( $iRowsListaSubFuncaoDestino == 0 ) {
        throw new Exception('Nenhum registro encontrado');
    }

    for ( $iInd=0; $iInd < $iRowsListaSubFuncaoDestino; $iInd++ ) {

        $oSubFuncaoDestino = db_utils::fieldsMemory($rsListaSubFuncaoDestino,$iInd);
        $aListaSubFuncao[$oSubFuncaoDestino->codsubfuncao] = $oSubFuncaoDestino->id;

    }

    // FIM SUBFUNES *************************************************************************************************//




    // PROGRAMAS ******************************************************************************************************//

    db_logTitulo(" IMPORTA PROGRAMAS",$sArquivoLog,$iParamLog);

    /**
     * Consulta Programas na base de origem
     */
    $sSqlPrograma  = " select o54_programa as codprograma,    ";
    $sSqlPrograma .= "        o54_descr    as descricao,      ";
    $sSqlPrograma .= "        o54_anousu    as exercicio      ";
    $sSqlPrograma .= "   from orcprograma                     ";

    $rsPrograma    = db_query($connOrigem,$sSqlPrograma);
    $iRowsPrograma = pg_num_rows($rsPrograma);

    if ( $iRowsPrograma ==  0 ) {
        throw new Exception('Nenhum programa encontrado!');
    }

    db_logNumReg($iRowsPrograma,$sArquivoLog,$iParamLog);

    /**
     *  Insere os registros na base de destino atravs do mtodo insertValue da classe TableDataManager que quando
     *  atinge o nmero determinado de registros ( informado na assinatura da classe )  executado automticamente
     *  o mtodo persist que insere fisicamente os registros na base de dados atravs do COPY.
     */
    for ( $iInd=0; $iInd < $iRowsPrograma; $iInd++ ) {

        $oPrograma = db_utils::fieldsMemory($rsPrograma,$iInd);

        logProcessamento($iInd,$iRowsPrograma,$iParamLog);

        $oTBProgramas->setByLineOfDBUtils($oPrograma);

        try {
            $oTBProgramas->insertValue();
        } catch ( Exception $eException ) {
            throw new Exception("ERRO-0: {$eException->getMessage()}");
        }

    }

    /**
     *  Aps o loop  executado manualmente o mtodo persist para que sejam inserido os registros restantes
     *  ( mesmo que no tenha atingido o nmero mximo do bloco de registros )
     */
    try {
        $oTBProgramas->persist();
    } catch ( Exception $eException ) {
        throw new Exception("ERRO-0: {$eException->getMessage()}");
    }


    /**
     *   consultado os programas cadastrados na base de destino para que seja populado o array $aListaPrograma
     *  com os programas cadastrados sendo a varivel indexada pelo cdigo do programa da base de origem.
     *  Essa varivel ser utilizada por todo o fonte para identificar o cdigo do programa de origem.
     */
    $sSqlListaProgramaDestino  = " select *         ";
    $sSqlListaProgramaDestino .= "   from programas ";

    $rsListaProgramaDestino    = db_query($connDestino,$sSqlListaProgramaDestino);
    $iRowsListaProgramaDestino = pg_num_rows($rsListaProgramaDestino);

    if ( $iRowsListaProgramaDestino == 0 ) {
        throw new Exception('Nenhum registro encontrado');
    }

    for ( $iInd=0; $iInd < $iRowsListaProgramaDestino; $iInd++ ) {

        $oProgramaDestino = db_utils::fieldsMemory($rsListaProgramaDestino,$iInd);
        $aListaPrograma[$oProgramaDestino->codprograma][$oProgramaDestino->exercicio] = $oProgramaDestino->id;

    }

    // FIM PROGRAMAS **************************************************************************************************//


    // RECURSOS *******************************************************************************************************//

    db_logTitulo(" IMPORTA RECURSOS",$sArquivoLog,$iParamLog);

    /**
     * Consulta Recursos na base de origem
     */
    $sSqlRecurso  = " select o15_codigo as codrecurso, ";
    $sSqlRecurso .= "        o15_descr  as descricao   ";
    $sSqlRecurso .= "   from orctiporec                ";

    $rsRecurso    = db_query($connOrigem,$sSqlRecurso);
    $iRowsRecurso = pg_num_rows($rsRecurso);

    if ( $iRowsRecurso ==  0 ) {
        throw new Exception('Nenhum recurso encontrado!');
    }

    db_logNumReg($iRowsRecurso,$sArquivoLog,$iParamLog);

    /**
     *  Insere os registros na base de destino atravs do mtodo insertValue da classe TableDataManager que quando
     *  atinge o nmero determinado de registros ( informado na assinatura da classe )  executado automticamente
     *  o mtodo persist que insere fisicamente os registros na base de dados atravs do COPY.
     */
    for ( $iInd=0; $iInd < $iRowsRecurso; $iInd++ ) {

        $oRecurso = db_utils::fieldsMemory($rsRecurso,$iInd);

        logProcessamento($iInd,$iRowsRecurso,$iParamLog);

        $oTBRecursos->setByLineOfDBUtils($oRecurso);

        try {
            $oTBRecursos->insertValue();
        } catch ( Exception $eException ) {
            throw new Exception("ERRO-0: {$eException->getMessage()}");
        }

    }

    /**
     *  Aps o loop  executado manualmente o mtodo persist para que sejam inserido os registros restantes
     *  ( mesmo que no tenha atingido o nmero mximo do bloco de registros )
     */
    try {
        $oTBRecursos->persist();
    } catch ( Exception $eException ) {
        throw new Exception("ERRO-0: {$eException->getMessage()}");
    }


    /**
     *   consultado os recursos cadastrados na base de destino para que seja populado o array $aListaRecurso
     *  com os recursos cadastrados sendo a varivel indexada pelo cdigo do recurso da base de origem.
     *  Essa varivel ser utilizada por todo o fonte para identificar o cdigo do recurso de origem.
     */
    $sSqlListaRecursoDestino  = " select *         ";
    $sSqlListaRecursoDestino .= "   from recursos ";

    $rsListaRecursoDestino    = db_query($connDestino,$sSqlListaRecursoDestino);
    $iRowsListaRecursoDestino = pg_num_rows($rsListaRecursoDestino);

    if ( $iRowsListaRecursoDestino == 0 ) {
        throw new Exception('Nenhum registro encontrado');
    }

    for ( $iInd=0; $iInd < $iRowsListaRecursoDestino; $iInd++ ) {

        $oRecursoDestino = db_utils::fieldsMemory($rsListaRecursoDestino,$iInd);
        $aListaRecurso[$oRecursoDestino->codrecurso] = $oRecursoDestino->id;
    }

    // FIM RECURSOS ***************************************************************************************************//



    // PLANOCONTAS ****************************************************************************************************//

    db_logTitulo(" IMPORTA PLANOCONTAS",$sArquivoLog,$iParamLog);

    $sSqlPlanoConta  = " select conplano.c60_codcon as codcon,     ";
    $sSqlPlanoConta .= "        conplano.c60_estrut as estrutural, ";
    $sSqlPlanoConta .= "        conplano.c60_descr  as descricao,  ";
    $sSqlPlanoConta .= "        conplano.c60_anousu as exercicio   ";
    $sSqlPlanoConta .= "   from conplano                           ";

    if (USE_PCASP || file_exists(DB_LIBS . 'config/pcasp.txt')) {

        $sSqlPlanoConta  = "   select distinct codcon,                                                                ";
        $sSqlPlanoConta .= "        estrutural,                                                                       ";
        $sSqlPlanoConta .= "        descricao,                                                                        ";
        $sSqlPlanoConta .= "        exercicio                                                                         ";
        $sSqlPlanoConta .= "   from (                                                                                 ";
        $sSqlPlanoConta .= "                                                                                          ";
        $sSqlPlanoConta .= " select conplano.c60_codcon as codcon,                                                    ";
        $sSqlPlanoConta .= "        conplano.c60_estrut as estrutural,                                                ";
        $sSqlPlanoConta .= "        conplano.c60_descr  as descricao,                                                 ";
        $sSqlPlanoConta .= "        conplano.c60_anousu as exercicio                                                  ";
        $sSqlPlanoConta .= "   from conplano where c60_anousu <= " . ANO_ANTERIOR_IMPLANTACAO_PCASP . "               ";
        $sSqlPlanoConta .= " union                                                                                    ";
        $sSqlPlanoConta .= " select conplanoorcamento.c60_codcon as codcon,                                           ";
        $sSqlPlanoConta .= "        conplanoorcamento.c60_estrut as estrutural,                                       ";
        $sSqlPlanoConta .= "        conplanoorcamento.c60_descr  as descricao,                                        ";
        $sSqlPlanoConta .= "        conplanoorcamento.c60_anousu as exercicio                                         ";
        $sSqlPlanoConta .= "   from conplanoorcamento where c60_anousu > " . ANO_ANTERIOR_IMPLANTACAO_PCASP . ") as x ";

    }

    $rsPlanoConta    = db_query($connOrigem,$sSqlPlanoConta);
    $iRowsPlanoConta = pg_num_rows($rsPlanoConta);

    if ( $iRowsPlanoConta ==  0 ) {
        throw new Exception('Nenhum recurso encontrado!');
    }

    db_logNumReg($iRowsPlanoConta,$sArquivoLog,$iParamLog);

    /**
     *  Insere os registros na base de destino atravs do mtodo insertValue da classe TableDataManager que quando
     *  atinge o nmero determinado de registros ( informado na assinatura da classe )  executado automticamente
     *  o mtodo persist que insere fisicamente os registros na base de dados atravs do COPY.
     */
    for ( $iInd=0; $iInd < $iRowsPlanoConta; $iInd++ ) {

        $oPlanoConta = db_utils::fieldsMemory($rsPlanoConta,$iInd);

        logProcessamento($iInd,$iRowsPlanoConta,$iParamLog);

        $oTBPlanoContas->setByLineOfDBUtils($oPlanoConta);

        try {
            $oTBPlanoContas->insertValue();
        } catch ( Exception $eException ) {
            throw new Exception("ERRO-0: {$eException->getMessage()}");
        }

    }

    /**
     *  Aps o loop  executado manualmente o mtodo persist para que sejam inserido os registros restantes
     *  ( mesmo que no tenha atingido o nmero mximo do bloco de registros )
     */
    try {
        $oTBPlanoContas->persist();
    } catch ( Exception $eException ) {
        throw new Exception("ERRO-0: {$eException->getMessage()}");
    }


    /**
     *   consultado os planocontas cadastrados na base de destino para que seja populado o array $aListaPlanoConta
     *  com os planocontas cadastrados sendo a varivel indexada pelo cdigo do planoconta da base de origem.
     *  Essa varivel ser utilizada por todo o fonte para identificar o cdigo do planoconta de origem.
     */
    $sSqlListaPlanoContaDestino  = " select *           ";
    $sSqlListaPlanoContaDestino .= "   from planocontas ";

    $rsListaPlanoContaDestino    = db_query($connDestino,$sSqlListaPlanoContaDestino);
    $iRowsListaPlanoContaDestino = pg_num_rows($rsListaPlanoContaDestino);

    if ( $iRowsListaPlanoContaDestino == 0 ) {
        throw new Exception('Nenhum registro encontrado');
    }

    for ( $iInd=0; $iInd < $iRowsListaPlanoContaDestino; $iInd++ ) {

        $oPlanoContaDestino = db_utils::fieldsMemory($rsListaPlanoContaDestino,$iInd);
        $aListaPlanoConta[$oPlanoContaDestino->codcon][$oPlanoContaDestino->exercicio] = $oPlanoContaDestino->id;
    }

    // FIM PLANOCONTAS ************************************************************************************************//


    // RECEITAS *******************************************************************************************************//

    $sSqlInstitPref = "SELECT db21_tipoinstit FROM configuracoes.db_config WHERE db21_tipoinstit NOT IN (2, 12)";
    $rsInstitPref   = db_query($connOrigem,$sSqlInstitPref);
    $sInstitPref    = pg_result($rsInstitPref,0,0);
    if (!empty($sInstitPref)) {

        db_logTitulo(" IMPORTA RECEITAS", $sArquivoLog, $iParamLog);

        /**
         * Consulta Receitas na base de origem
         */
        $sSqlReceita = " select o70_codrec as codreceita,       ";
        $sSqlReceita .= "        o70_codfon as codcon,           ";
        $sSqlReceita .= "        o70_anousu as exercicio,        ";
        $sSqlReceita .= "        o70_codigo as codrecurso,       ";
        $sSqlReceita .= "        o70_instit as codinstit,        ";
        $sSqlReceita .= "        o70_valor  as previsaoinicial   ";
        $sSqlReceita .= "   from orcreceita                      ";

//    echo $sSqlReceita; exit;

        $rsReceita = db_query($connOrigem, $sSqlReceita);
        $iRowsReceita = pg_num_rows($rsReceita);

        if ($iRowsReceita == 0) {
            throw new Exception('Nenhum recurso encontrado!');
        }

        db_logNumReg($iRowsReceita, $sArquivoLog, $iParamLog);

        /**
         *  Insere os registros na base de destino atravs do mtodo insertValue da classe TableDataManager que quando
         *  atinge o nmero determinado de registros ( informado na assinatura da classe )  executado automticamente
         *  o mtodo persist que insere fisicamente os registros na base de dados atravs do COPY.
         */
        for ($iInd = 0; $iInd < $iRowsReceita; $iInd++) {

            $oReceita = db_utils::fieldsMemory($rsReceita, $iInd);

            logProcessamento($iInd, $iRowsReceita, $iParamLog);

            if (!isset($aListaPlanoConta[$oReceita->codcon][$oReceita->exercicio])) {
                throw new Exception("ERRO-0: Plano de Contas no encontrado CODCON: $oReceita->codcon  EXERCICIO: $oReceita->exercicio RECEITA: $oReceita->codreceita");
            }

            $oReceita->recurso_id = $aListaRecurso[$oReceita->codrecurso];
            $oReceita->planoconta_id = $aListaPlanoConta[$oReceita->codcon][$oReceita->exercicio];
            $oReceita->instituicao_id = $aListaInstit[$oReceita->codinstit];

            $oTBReceitas->setByLineOfDBUtils($oReceita);

            try {
                $oTBReceitas->insertValue();
            } catch (Exception $eException) {
                throw new Exception("ERRO-0: {$eException->getMessage()}");
            }

        }

        /**
         *  Aps o loop  executado manualmente o mtodo persist para que sejam inserido os registros restantes
         *  ( mesmo que no tenha atingido o nmero mximo do bloco de registros )
         */
        try {
            $oTBReceitas->persist();
        } catch (Exception $eException) {
            throw new Exception("ERRO-0: {$eException->getMessage()}");
        }


        /**
         *   consultado as receitas cadastradas na base de destino para que seja populado o array $aListaReceita
         *  com as receitas cadastradas sendo a varivel indexada pelo cdigo do receita da base de origem.
         *  Essa varivel ser utilizada por todo o fonte para identificar o cdigo da receita de origem.
         */
        $sSqlListaReceitaDestino = " select *        ";
        $sSqlListaReceitaDestino .= "   from receitas ";

        $rsListaReceitaDestino = db_query($connDestino, $sSqlListaReceitaDestino);
        $iRowsListaReceitaDestino = pg_num_rows($rsListaReceitaDestino);

        if ($iRowsListaReceitaDestino == 0) {
            throw new Exception('Nenhum registro encontrado');
        }

        for ($iInd = 0; $iInd < $iRowsListaReceitaDestino; $iInd++) {

            $oReceitaDestino = db_utils::fieldsMemory($rsListaReceitaDestino, $iInd);
            $aListaReceita[$oReceitaDestino->codreceita][$oReceitaDestino->exercicio] = $oReceitaDestino->id;
        }

        // FIM RECEITAS ***************************************************************************************************//


        // MOVIMENTAES RECEITAS *****************************************************************************************//

        db_logTitulo(" IMPORTA MOVIMENTAES DAS RECEITAS", $sArquivoLog, $iParamLog);

        /**
         * Consulta Preparada para execuo da funo fc_receitasaldo na base de origem
         */

        $sSqlReceitaMovimentacao = " prepare stmt_receitasaldo(integer, integer) as ";
        $sSqlReceitaMovimentacao .= " select cast(                                                                               ";
        $sSqlReceitaMovimentacao .= "           substr(                                                                          ";
        $sSqlReceitaMovimentacao .= "           fc_receitasaldo($1,                                                              ";
        $sSqlReceitaMovimentacao .= "                           $2,                                                              ";
        $sSqlReceitaMovimentacao .= "                           3,                                                               ";
        $sSqlReceitaMovimentacao .= "                           current_date,                                                    ";
        $sSqlReceitaMovimentacao .= "                           current_date),41,13) as numeric(15,2));                          ";

        /**
         * Consulta ReceitasMovimentacoes na base de origem
         */

        $sRegraArrecadacaoReceita = " (case when o70_anousu < 2013 or (substr(o57_fonte , 1, 1) = '4') ";
        $sRegraArrecadacaoReceita .= "       then (case when c57_sequencial = 100 then c70_valor";
        $sRegraArrecadacaoReceita .= "                  when c57_sequencial = 101 then c70_valor * -1";
        $sRegraArrecadacaoReceita .= "                  else 0 end) ";
        $sRegraArrecadacaoReceita .= "       when o70_anousu >= 2013 then ";
        $sRegraArrecadacaoReceita .= "        (case when substr(o57_fonte, 1, 1) = '9' then  ";
        $sRegraArrecadacaoReceita .= "            (case  when c57_sequencial = 100 then c70_valor * -1";
        $sRegraArrecadacaoReceita .= "                   when c57_sequencial = 101 then c70_valor ";
        $sRegraArrecadacaoReceita .= "              end)";
        $sRegraArrecadacaoReceita .= "         end)";
        $sRegraArrecadacaoReceita .= "    end) ";

        $sSqlReceitaMovimentacao .= " select o70_codrec as codreceita,                                                           ";
        $sSqlReceitaMovimentacao .= "        o70_anousu as exercicio,                                                            ";
        $sSqlReceitaMovimentacao .= "        c70_data   as data,                                                                 ";
        $sSqlReceitaMovimentacao .= "        sum( {$sRegraArrecadacaoReceita}) as valor,                                         ";

        $sSqlReceitaMovimentacao .= "        sum(case                                                                            ";
        $sSqlReceitaMovimentacao .= "            when c57_sequencial = 110  then c70_valor                                       ";
        $sSqlReceitaMovimentacao .= "            when c57_sequencial = 111 then (c70_valor * -1)                                 ";
        $sSqlReceitaMovimentacao .= "            else 0                                                                          ";
        $sSqlReceitaMovimentacao .= "            end ) as previsaoadicional,                                                     ";

        $sSqlReceitaMovimentacao .= "        sum(case                                                                            ";
        $sSqlReceitaMovimentacao .= "            when c57_sequencial = 58   then c70_valor                                       ";
        $sSqlReceitaMovimentacao .= "            when c57_sequencial = 104 then (c70_valor * -1)                                 ";
        $sSqlReceitaMovimentacao .= "            else 0                                                                          ";
        $sSqlReceitaMovimentacao .= "            end ) as previsao_atualizada                                                    ";

        $sSqlReceitaMovimentacao .= "  from orcreceita                                                                           ";
        $sSqlReceitaMovimentacao .= "       inner join conlancamrec   on conlancamrec.c74_codrec = orcreceita.o70_codrec         ";
        $sSqlReceitaMovimentacao .= "                                and conlancamrec.c74_anousu = orcreceita.o70_anousu         ";
        $sSqlReceitaMovimentacao .= "       inner join orcfontes      on orcreceita.o70_codfon   = orcfontes.o57_codfon          ";
        $sSqlReceitaMovimentacao .= "                                and orcreceita.o70_anousu   = orcfontes.o57_anousu          ";
        $sSqlReceitaMovimentacao .= "       inner join conlancam      on conlancam.c70_codlan    = conlancamrec.c74_codlan       ";
        $sSqlReceitaMovimentacao .= "       inner join conlancamdoc   on conlancamdoc.c71_codlan = conlancam.c70_codlan          ";
        $sSqlReceitaMovimentacao .= "       inner join conhistdoc     on conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc         ";
        $sSqlReceitaMovimentacao .= "       inner join conhistdoctipo on conhistdoc.c53_tipo     = conhistdoctipo.c57_sequencial ";
        $sSqlReceitaMovimentacao .= " group by o70_codrec,o70_anousu,c70_data                                                    ";


        $rsReceitaMovimentacao = db_query($connOrigem, $sSqlReceitaMovimentacao);
        $iRowsReceitaMovimentacao = pg_num_rows($rsReceitaMovimentacao);

        if ($iRowsReceitaMovimentacao == 0) {
            throw new Exception('Nenhum recurso encontrado!');
        }

        db_logNumReg($iRowsReceitaMovimentacao, $sArquivoLog, $iParamLog);

        /**
         *  Insere os registros na base de destino atravs do mtodo insertValue da classe TableDataManager que quando
         *  atinge o nmero determinado de registros ( informado na assinatura da classe )  executado automticamente
         *  o mtodo persist que insere fisicamente os registros na base de dados atravs do COPY.
         */
        for ($iInd = 0; $iInd < $iRowsReceitaMovimentacao; $iInd++) {

            $oReceitaMovimentacao = db_utils::fieldsMemory($rsReceitaMovimentacao, $iInd);

            logProcessamento($iInd, $iRowsReceitaMovimentacao, $iParamLog);


            $sSqlReceitaSaldo = "EXECUTE stmt_receitasaldo({$oReceitaMovimentacao->exercicio}, {$oReceitaMovimentacao->codreceita})";
            $rsReceitaSaldo = db_query($connOrigem, $sSqlReceitaSaldo);
            $iRowsReceitaSaldo = pg_num_rows($rsReceitaSaldo);

            if ($iRowsReceitaSaldo == 0) {
                $oReceitaMovimentacao->valor_previsao_atualizada = 0;
            } else {
                $oReceitaMovimentacao->valor_previsao_atualizada = pg_result($rsReceitaSaldo, 0, 0);
            }

            $oReceitaMovimentacao->receita_id = $aListaReceita[$oReceitaMovimentacao->codreceita][$oReceitaMovimentacao->exercicio];

            $oTBReceitasMovimentacoes->setByLineOfDBUtils($oReceitaMovimentacao);

            try {
                $oTBReceitasMovimentacoes->insertValue();
            } catch (Exception $eException) {
                throw new Exception("ERRO-0: {$eException->getMessage()}");
            }

        }

        /**
         *  Aps o loop  executado manualmente o mtodo persist para que sejam inserido os registros restantes
         *  ( mesmo que no tenha atingido o nmero mximo do bloco de registros )
         */
        try {
            $oTBReceitasMovimentacoes->persist();
        } catch (Exception $eException) {
            throw new Exception("ERRO-0: {$eException->getMessage()}");
        }


        // ACERTA TABELA receitas_movimentacoes ***************************************************************************//


        $sSqlAcertaRecMov = " UPDATE receitas_movimentacoes SET valor = ( valor * -1 )
  WHERE receita_id in ( select distinct receitas.id
  from receitas
  inner join planocontas on planocontas.id = receitas.planoconta_id
  where planocontas.estrutural like '9%'
  or planocontas.estrutural like '49%')";

        $rsAcertaRecMov = db_query($connDestino, $sSqlAcertaRecMov);

        if (!$rsAcertaRecMov) {
            throw new Exception("ERRO-0: Erro ao acertar tabela receitas_movimentacoes !");
        }

        // ****************************************************************************************************************//
    }

    // FIM MOVIMENTAES RECEITAS *************************************************************************************//


    // DOTAES *******************************************************************************************************//


    db_logTitulo(" IMPORTA DOTACOES",$sArquivoLog,$iParamLog);

    /**
     * Consulta Dotacoes na base de origem
     */



    $sSqlDotacao  = " SELECT DISTINCT ON (o58_coddot, o58_anousu) ";
    $sSqlDotacao .= "                    o58_coddot AS coddotacao,  ";
    $sSqlDotacao .= "                    o58_orgao AS codorgao, ";
    $sSqlDotacao .= "                    o58_unidade AS codunidade, ";
    $sSqlDotacao .= "                    o58_funcao AS codfuncao, ";
    $sSqlDotacao .= "                    o58_subfuncao AS codsubfuncao, ";
    $sSqlDotacao .= "                    o58_programa AS codprograma, ";
    $sSqlDotacao .= "                    o58_projativ AS codprojeto,  ";
    $sSqlDotacao .= "                    o58_codigo AS codrecurso,  ";
    $sSqlDotacao .= "                    o58_instit AS codinstit, ";
    $sSqlDotacao .= "                    o58_anousu AS exercicio, ";
    $sSqlDotacao .= "                    o58_codigo AS recurso, ";
    $sSqlDotacao .= "                    codcon ";
    $sSqlDotacao .= " FROM  ";
    $sSqlDotacao .= " (SELECT DISTINCT ON (o58_coddot, o58_anousu)  ";
    $sSqlDotacao .= "                    o58_coddot,  ";
    $sSqlDotacao .= "                    o58_orgao, ";
    $sSqlDotacao .= "                    o58_unidade, ";
    $sSqlDotacao .= "                    o58_funcao,  ";
    $sSqlDotacao .= "                    o58_subfuncao, ";
    $sSqlDotacao .= "                    o58_programa,  ";
    $sSqlDotacao .= "                    o58_projativ,  ";
    $sSqlDotacao .= "                    o58_codigo as recurso1,  ";
    $sSqlDotacao .= "                    o58_instit,  ";
    $sSqlDotacao .= "                    o58_anousu,  ";
    $sSqlDotacao .= "                    o58_codigo,  ";
    $sSqlDotacao .= "                    CASE ";
    $sSqlDotacao .= "                      WHEN o58_anousu < 2013 AND o56_elemento = substr(c60_estrut,1,13)  ";
    $sSqlDotacao .= "                       THEN c60_codcon ";
    $sSqlDotacao .= "                     ELSE o58_codele ";
    $sSqlDotacao .= "                    END codcon ";
    $sSqlDotacao .= " FROM orcdotacao ";
    $sSqlDotacao .= " JOIN orcelemento ON o56_codele = o58_codele AND o58_anousu = o56_anousu ";
    $sSqlDotacao .= " JOIN conplano ON o56_elemento = substr(c60_estrut,1,13) AND o56_anousu = c60_anousu ";
    $sSqlDotacao .= " UNION ";
    $sSqlDotacao .= " SELECT o58_coddot,  ";
    $sSqlDotacao .= "        o58_orgao, ";
    $sSqlDotacao .= "        o58_unidade, ";
    $sSqlDotacao .= "        o58_funcao,  ";
    $sSqlDotacao .= "        o58_subfuncao, ";
    $sSqlDotacao .= "        o58_programa,  ";
    $sSqlDotacao .= "        o58_projativ,  ";
    $sSqlDotacao .= "        o58_codigo as recurso2,  ";
    $sSqlDotacao .= "        o58_instit,  ";
    $sSqlDotacao .= "        o58_anousu,  ";
    $sSqlDotacao .= "        o58_codigo,  ";
    $sSqlDotacao .= "        o58_codele ";
    $sSqlDotacao .= " FROM orcdotacao ";
    $sSqlDotacao .= " WHERE o58_anousu >= 2013) as x  ";


    $rsDotacao    = db_query($connOrigem,$sSqlDotacao);
    $iRowsDotacao = pg_num_rows($rsDotacao);

    if ( $iRowsDotacao ==  0 ) {
        throw new Exception('Nenhum recurso encontrado!');
    }

    db_logNumReg($iRowsDotacao,$sArquivoLog,$iParamLog);

    /**
     *  Insere os registros na base de destino atravs do mtodo insertValue da classe TableDataManager que quando
     *  atinge o nmero determinado de registros ( informado na assinatura da classe )  executado automticamente
     *  o mtodo persist que insere fisicamente os registros na base de dados atravs do COPY.
     */
    for ( $iInd=0; $iInd < $iRowsDotacao; $iInd++ ) {

        $oDotacao = db_utils::fieldsMemory($rsDotacao,$iInd);

        logProcessamento($iInd,$iRowsDotacao,$iParamLog);

        if ( !isset($aListaProjeto[$oDotacao->codprojeto][$oDotacao->exercicio]) ) {
            $sMsg  = "ERRO-0: Projeto no encontrado PROJETO: $oDotacao->codprojeto  EXERCICIO: $oDotacao->exercicio ";
            $sMsg .= "DOTACAO: $oDotacao->coddotacao ";
            throw new Exception($sMsg);
        }

        if ( !isset($aListaPlanoConta[$oDotacao->codcon][$oDotacao->exercicio]) ) {
            $sMsg  = "ERRO-0: Plano de Contas no encontrado CODCON: $oDotacao->codcon EXERCICIO: $oDotacao->exercicio ";
            $sMsg .= "DOTAO: $oDotacao->coddotacao ";
            throw new Exception($sMsg);
        }

        $oDotacao->orgao_id       = $aListaOrgao[$oDotacao->codorgao][$oDotacao->exercicio];
        $oDotacao->unidade_id     = $aListaUnidade[$oDotacao->codunidade][$oDotacao->exercicio];
        $oDotacao->funcao_id      = $aListaFuncao[$oDotacao->codfuncao];
        $oDotacao->subfuncao_id   = $aListaSubFuncao[$oDotacao->codsubfuncao];
        $oDotacao->programa_id    = $aListaPrograma[$oDotacao->codprograma][$oDotacao->exercicio];
        $oDotacao->projeto_id     = $aListaProjeto[$oDotacao->codprojeto][$oDotacao->exercicio];
        $oDotacao->planoconta_id  = $aListaPlanoConta[$oDotacao->codcon][$oDotacao->exercicio];
        $oDotacao->recurso_id     = $aListaRecurso[$oDotacao->codrecurso];
        $oDotacao->instituicao_id = $aListaInstit[$oDotacao->codinstit];

        $oTBDotacoes->setByLineOfDBUtils($oDotacao);

        try {
            $oTBDotacoes->insertValue();
        } catch ( Exception $eException ) {
            throw new Exception("ERRO-0: {$eException->getMessage()}");
        }

    }

    /**
     *  Aps o loop  executado manualmente o mtodo persist para que sejam inserido os registros restantes
     *  ( mesmo que no tenha atingido o nmero mximo do bloco de registros )
     */
    try {
        $oTBDotacoes->persist();
    } catch ( Exception $eException ) {
        throw new Exception("ERRO-0: {$eException->getMessage()}");
    }


    /**
     *   consultado as dotacoes cadastradas na base de destino para que seja populado o array $aListaDotacao
     *  com as dotacoes cadastradas sendo a varivel indexada pelo cdigo do receita da base de origem.
     *  Essa varivel ser utilizada por todo o fonte para identificar o cdigo da dotacao de origem.
     */
    $sSqlListaDotacaoDestino  = " select *        ";
    $sSqlListaDotacaoDestino .= "   from dotacoes ";

    $rsListaDotacaoDestino    = db_query($connDestino,$sSqlListaDotacaoDestino);
    $iRowsListaDotacaoDestino = pg_num_rows($rsListaDotacaoDestino);

    if ( $iRowsListaDotacaoDestino == 0 ) {
        throw new Exception('Nenhum registro encontrado');
    }

    for ( $iInd=0; $iInd < $iRowsListaDotacaoDestino; $iInd++ ) {

        $oDotacaoDestino = db_utils::fieldsMemory($rsListaDotacaoDestino,$iInd);
        $aListaDotacao[$oDotacaoDestino->coddotacao][$oDotacaoDestino->exercicio] = $oDotacaoDestino->id;
    }

    // FIM DOTAES ***************************************************************************************************//


    unset($aListaOrgao);
    unset($aListaUnidade);
    unset($aListaProjeto);
    unset($aListaFuncao);
    unset($aListaSubFuncao);
    unset($aListaPrograma);
    unset($aListaRecurso);
    unset($aListaReceita);


    // EMPENHOS *******************************************************************************************************//

    db_logTitulo(" IMPORTA EMPENHOS",$sArquivoLog,$iParamLog);


    /**
     * Consulta Empenhos na base de origem
     */
    $sSqlEmpenho  = " select distinct e60_numemp as codempenho,                                                      ";
    $sSqlEmpenho .= "        e60_codemp as codigo,                                                                   ";
    $sSqlEmpenho .= "        e60_anousu as exercicio,                                                                ";
    $sSqlEmpenho .= "        e60_instit as codinstit,                                                                ";
    $sSqlEmpenho .= "        e60_emiss  as dataemissao,                                                              ";
    $sSqlEmpenho .= "        e60_coddot as coddotacao,                                                               ";
    $sSqlEmpenho .= "        e60_vlremp as valor,                                                                    ";
    $sSqlEmpenho .= "        e60_vlrpag as valor_pago,                                                               ";
    $sSqlEmpenho .= "        e60_vlrliq as valor_liquidado,                                                          ";
    $sSqlEmpenho .= "        e60_vlranu as valor_anulado,                                                            ";
    $sSqlEmpenho .= "        e60_resumo as resumo,                                                                   ";
    $sSqlEmpenho .= "        z01_numcgm as numcgm,                                                                   ";
    $sSqlEmpenho .= "        coalesce(nullif(trim(z01_cgccpf),''),'0') as cgccpf,                                    ";
    $sSqlEmpenho .= "        case                                                                                    ";
    $sSqlEmpenho .= "           when c60_codcon is not null then c60_codcon                                          ";
    $sSqlEmpenho .= "           else o58_codele                                                                      ";
    $sSqlEmpenho .= "        end as codcon,                                                                          ";
    $sSqlEmpenho .= "        z01_nome    as nome,                                                                    ";
    $sSqlEmpenho .= "        e61_autori  as codautoriza,                                                             ";
    $sSqlEmpenho .= "        e60_numerol as numero_licitacao,                                                        ";
    $sSqlEmpenho .= "        pc50_descr  as descrtipocompra                                                          ";
    $sSqlEmpenho .= "   from empempenho                                                                              ";
    $sSqlEmpenho .= "        inner join cgm          on cgm.z01_numcgm           = empempenho.e60_numcgm             ";
    $sSqlEmpenho .= "        inner join orcdotacao   on orcdotacao.o58_coddot    = empempenho.e60_coddot             ";
    $sSqlEmpenho .= "        inner join pctipocompra on pctipocompra.pc50_codcom = empempenho.e60_codcom             ";
    $sSqlEmpenho .= "                               and orcdotacao.o58_anousu    = empempenho.e60_anousu             ";
    $sSqlEmpenho .= "        left join (  select distinct on (e.e64_numemp) e.e64_numemp, e.e64_codele               ";
    $sSqlEmpenho .= "                       from empelemento e                                                       ";
    $sSqlEmpenho .= "                   order by e.e64_numemp, e.e64_codele ) as x                                   ";
    $sSqlEmpenho .= "                                on x.e64_numemp           = empempenho.e60_numemp               ";
    $sSqlEmpenho .= "        left join conplanoorcamento      on conplanoorcamento.c60_codcon    = x.e64_codele      ";
    $sSqlEmpenho .= "                               and conplanoorcamento.c60_anousu    = empempenho.e60_anousu      ";
    $sSqlEmpenho .= "        left join empempaut     on empempaut.e61_numemp   = empempenho.e60_numemp               ";
    $sSqlEmpenho .= "  where exists (  select 1                                                                      ";
    $sSqlEmpenho .= "                    from conlancamemp                                                           ";
    $sSqlEmpenho .= "                         inner join conlancam on conlancam.c70_codlan = conlancamemp.c75_codlan ";
    $sSqlEmpenho .= "                   where c75_numemp = e60_numemp                                                ";
    $sSqlEmpenho .= "                     and c70_data >= '{$iExercicioBase}-01-01'::date )                          ";
    $sSqlEmpenho .= "    and exists (  select 1                                                                      ";
    $sSqlEmpenho .= "                    from empempitem                                                             ";
    $sSqlEmpenho .= "                   where empempitem.e62_numemp = empempenho.e60_numemp )                        ";

    $rsEmpenho    = db_query($connOrigem,$sSqlEmpenho);
    $iRowsEmpenho = pg_num_rows($rsEmpenho);

    if ( $iRowsEmpenho ==  0 ) {
        throw new Exception('Nenhum recurso encontrado!');
    }

    db_logNumReg($iRowsEmpenho,$sArquivoLog,$iParamLog);

    /**
     *  Insere os registros na base de destino atravs do mtodo insertValue da classe TableDataManager que quando
     *  atinge o nmero determinado de registros ( informado na assinatura da classe )  executado automticamente
     *  o mtodo persist que insere fisicamente os registros na base de dados atravs do COPY.
     */
    for ( $iInd=0; $iInd < $iRowsEmpenho; $iInd++ ) {

        $oEmpenho = db_utils::fieldsMemory($rsEmpenho,$iInd);

        logProcessamento($iInd,$iRowsEmpenho,$iParamLog);

        $sSqlPessoas = " select id
    from pessoas
    where codpessoa = {$oEmpenho->numcgm} ";

        $rsPessoas   = db_query($connDestino,$sSqlPessoas);

        if ( pg_num_rows($rsPessoas) > 0 ) {

            $iIdPessoa = db_utils::fieldsMemory($rsPessoas,0)->id;
        } else {

            $oTBPessoas->id        = '';
            $oTBPessoas->codpessoa = $oEmpenho->numcgm;
            $oTBPessoas->nome      = $oEmpenho->nome;
            $oTBPessoas->cpfcnpj   = $oEmpenho->cgccpf;

            try {
                $oTBPessoas->insertValue();
                $oTBPessoas->persist();
            } catch ( Exception $eException ) {
                throw new Exception("ERRO-0: {$eException->getMessage()}");
            }

            $iIdPessoa = $oTBPessoas->getLastPk();
        }

        if ( !isset($aListaDotacao[$oEmpenho->coddotacao][$oEmpenho->exercicio]) ) {
            $sMsg  = "ERRO-0: Dotao no encontrada DOTAO: $oEmpenho->coddotacao  EXERCICIO: $oEmpenho->exercicio ";
            $sMsg .= "NUMEMP  $oEmpenho->codempenho ";
            throw new Exception($sMsg);
        }

        if ( !isset($aListaPlanoConta[$oEmpenho->codcon][$oEmpenho->exercicio]) ) {
            $sMsg  = "ERRO-0: Plano de Conta no encontrado CODCON: $oEmpenho->codcon EXERCICIO: $oEmpenho->exercicio ";
            $sMsg .= "NUMEMP: $oEmpenho->codempenho ";
            throw new Exception($sMsg);
        }

        $sTipoCompra = "";

        if ( trim($oEmpenho->codautoriza) != '' ) {

            $sSqlTipoCompra  = " select * ";
            $sSqlTipoCompra .= "   from empautitem ";
            $sSqlTipoCompra .= "        inner join empautitempcprocitem on empautitempcprocitem.e73_sequen = empautitem.e55_sequen          ";
            $sSqlTipoCompra .= "                                       and empautitempcprocitem.e73_autori = empautitem.e55_autori          ";
            $sSqlTipoCompra .= "        inner join liclicitem           on liclicitem.l21_codpcprocitem    = empautitempcprocitem.e73_sequen";
            $sSqlTipoCompra .= "        inner join liclicita            on liclicitem.l21_codliclicita     = liclicita.l20_codigo           ";
            $sSqlTipoCompra .= "        inner join cflicita             on liclicita.l20_codtipocom        = cflicita.l03_codigo            ";
            $sSqlTipoCompra .= "        inner join empautoriza          on empautoriza.e54_autori          = empautitem.e55_autori          ";
            $sSqlTipoCompra .= "  where empautitem.e55_autori = {$oEmpenho->codautoriza} ";

            $rsLicita = db_query($connOrigem,$sSqlTipoCompra);

            if ( pg_num_rows($rsLicita) > 0 ) {

                $oLicita = db_utils::fieldsMemory($rsLicita,0);

                $aData       = explode("-",$oLicita->l20_dtpublic);
                $iAnoLic     = $aData[0];
                $sNumeroLic  = $oLicita->l20_numero."/".$iAnoLic;
                $sTipoCompra = $oLicita->l03_descr." Numero Licitao : {$sNumeroLic}";

            }

        }

        if ( trim($sTipoCompra) == '' ) {

            $sTipoCompra = $oEmpenho->descrtipocompra;

            if ( trim($oEmpenho->numero_licitacao) != '' ) {
                $sTipoCompra .= " Numero Licitao : {$oEmpenho->numero_licitacao}";
            }
        }


        $oEmpenho->pessoa_id      = $iIdPessoa;
        $oEmpenho->planoconta_id  = $aListaPlanoConta[$oEmpenho->codcon][$oEmpenho->exercicio];
        $oEmpenho->dotacao_id     = $aListaDotacao[$oEmpenho->coddotacao][$oEmpenho->exercicio];
        $oEmpenho->instituicao_id = $aListaInstit[$oEmpenho->codinstit];
        $oEmpenho->tipo_compra    = $sTipoCompra;

        $oTBEmpenhos->setByLineOfDBUtils($oEmpenho);

        try {
            $oTBEmpenhos->insertValue();
        } catch ( Exception $eException ) {
            throw new Exception("ERRO-0: {$eException->getMessage()}");
        }

    }

    /**
     *  Aps o loop  executado manualmente o mtodo persist para que sejam inserido os registros restantes
     *  ( mesmo que no tenha atingido o nmero mximo do bloco de registros )
     */
    try {
        $oTBEmpenhos->persist();
    } catch ( Exception $eException ) {
        throw new Exception("ERRO-0: {$eException->getMessage()}");
    }

    // FIM EMPENHOS ***************************************************************************************************//


    unset($aListaPlanoConta);
    unset($aListaDotacao);


    // ITENS EMPENHOS *************************************************************************************************//

    db_logTitulo(" IMPORTA ITENS EMPENHOS",$sArquivoLog,$iParamLog);


    $sSqlEmpenhosDestino  = " select *        ";
    $sSqlEmpenhosDestino .= "   from empenhos ";

    $rsDadosEmpenhosDestino = db_query($connDestino,$sSqlEmpenhosDestino);
    $iLinhasEmpenhosDestino = pg_num_rows($rsDadosEmpenhosDestino);

    db_logNumReg($iLinhasEmpenhosDestino,$sArquivoLog,$iParamLog);

    for ( $iInd=0; $iInd < $iLinhasEmpenhosDestino; $iInd++ ) {

        $oEmpenhoDestino = db_utils::fieldsMemory($rsDadosEmpenhosDestino,$iInd);

        logProcessamento($iInd,$iLinhasEmpenhosDestino,$iParamLog);


        $sSqlItensEmpenho    = " SELECT trim(replace(pc01_descrmater, '\r\n', ' ')) AS descricao, ";
        $sSqlItensEmpenho   .= "        e62_quant AS quantidade,                                  ";
        $sSqlItensEmpenho   .= "        e62_vlrun AS valor_unitario,                              ";
        $sSqlItensEmpenho   .= "        e62_vltot AS valor_total                                  ";
        $sSqlItensEmpenho   .= " FROM empempitem                                                  ";
        $sSqlItensEmpenho   .= " INNER JOIN pcmater ON pc01_codmater = e62_item                   ";
        $sSqlItensEmpenho   .= " INNER JOIN empempenho ON e60_numemp = e62_numemp                 ";
        $sSqlItensEmpenho   .= " WHERE e62_numemp = {$oEmpenhoDestino->codempenho}                ";

        $rsDadosItensEmpenho = db_query($connOrigem,$sSqlItensEmpenho);
        $iLinhasItensEmpenho = pg_num_rows($rsDadosItensEmpenho);

        if ( $iLinhasItensEmpenho > 0 ) {

            for ( $iIndItem=0; $iIndItem < $iLinhasItensEmpenho; $iIndItem++ ) {

                $oItemEmpenho = db_utils::fieldsMemory($rsDadosItensEmpenho,$iIndItem);

                if ( $oItemEmpenho->descricao == '' ) {
                    $oItemEmpenho->descricao = 'DESCRIO NO ESPECIFICADA';
                }

                $oItemEmpenho->empenho_id = $oEmpenhoDestino->id;
                $oTBEmpenhosItens->setByLineOfDBUtils($oItemEmpenho);

                try {
                    $oTBEmpenhosItens->insertValue();
                } catch ( Exception $eException ) {
                    throw new Exception("ERRO-0: {$eException->getMessage()}");
                }
            }

            try {
                $oTBEmpenhosItens->persist();
            } catch ( Exception $eException ) {
                throw new Exception("ERRO-0: {$eException->getMessage()}");
            }

        }

        // Consulta Processos do Empenho
        $sSqlProcessoEmpenho    = " select pc81_codproc as processo
    from empempaut
    inner join empautitem           on e55_autori = e61_autori
    inner join empautitempcprocitem on e73_autori = e55_autori
    and e73_sequen = e55_sequen
    inner join pcprocitem           on pc81_codprocitem = e73_pcprocitem
    where e61_numemp = {$oEmpenho->codempenho} ";

        $rsDadosProcessoEmpenho  = db_query($connOrigem,$sSqlProcessoEmpenho);
        $iLinhasProcessoEmpenho = pg_num_rows($rsDadosProcessoEmpenho);

        if ( $iLinhasProcessoEmpenho > 0 ) {

            for ( $iIndProcesso=0; $iIndProcesso < $iLinhasProcessoEmpenho; $iIndProcesso++ ) {

                $oProcessoEmpenho = db_utils::fieldsMemory($rsDadosProcessoEmpenho,$iIndProcesso);

                $oProcessoEmpenho->empenho_id = $oEmpenhoDestino->id;
                $oTBEmpenhosProcessos->setByLineOfDBUtils($oProcessoEmpenho);

                try {
                    $oTBEmpenhosProcessos->insertValue();
                } catch ( Exception $eException ) {
                    throw new Exception("ERRO-0: {$eException->getMessage()}");
                }
            }

            try {
                $oTBEmpenhosProcessos->persist();
            } catch ( Exception $eException ) {
                throw new Exception("ERRO-0: {$eException->getMessage()}");
            }
        }

    }

    // FIM ITENS EMPENHOS *********************************************************************************************//


    // MOVIMENTACOES EMPENHOS *****************************************************************************************//

    db_logTitulo(" IMPORTA MOVIMENTACOES EMPENHOS",$sArquivoLog,$iParamLog);

    /**
     * Consulta EmpenhosMovimentacoes na base de origem
     */

    $sSqlEmpenhoMovimentacao  = " SELECT conhistdoc.c53_coddoc AS codtipo,                                          ";
    $sSqlEmpenhoMovimentacao .= "        conhistdoc.c53_tipo AS codgrupo,                                           ";
    $sSqlEmpenhoMovimentacao .= "        conhistdoc.c53_descr AS descrtipo,                                         ";
    $sSqlEmpenhoMovimentacao .= "        conlancamemp.c75_numemp AS codempenho,                                     ";
    $sSqlEmpenhoMovimentacao .= "        c70_data AS DATA,                                                          ";
    $sSqlEmpenhoMovimentacao .= "        c70_valor AS valor,                                                        ";
    $sSqlEmpenhoMovimentacao .= "        c72_complem AS historico                                                   ";
    $sSqlEmpenhoMovimentacao .= " FROM conlancamemp                                                                 ";
    $sSqlEmpenhoMovimentacao .= " INNER JOIN conlancam ON conlancam.c70_codlan = conlancamemp.c75_codlan            ";
    $sSqlEmpenhoMovimentacao .= " INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamemp.c75_codlan      ";
    $sSqlEmpenhoMovimentacao .= " INNER JOIN conhistdoc ON conhistdoc.c53_coddoc = conlancamdoc.c71_coddoc          ";
    $sSqlEmpenhoMovimentacao .= " LEFT  JOIN conlancamcompl ON conlancamcompl.c72_codlan = conlancamemp.c75_codlan  ";
    $sSqlEmpenhoMovimentacao .= " WHERE EXISTS ( SELECT * FROM empempitem JOIN empempenho ON e62_numemp = e60_numemp";
    $sSqlEmpenhoMovimentacao .= " WHERE empempitem.e62_numemp = conlancamemp.c75_numemp                             ";
    $sSqlEmpenhoMovimentacao .= " AND empempenho.e60_emiss >= '{$iExercicioBase}-01-01'::date)                      ";
    $sSqlEmpenhoMovimentacao .= " AND c70_data >= '{$iExercicioBase}-01-01'::date                                   ";


    $rsEmpenhoMovimentacao    = db_query($connOrigem,$sSqlEmpenhoMovimentacao);
    $iRowsEmpenhoMovimentacao = pg_num_rows($rsEmpenhoMovimentacao);

    if ( $iRowsEmpenhoMovimentacao ==  0 ) {
        throw new Exception('Nenhuma movimentao encontrada!');
    }

    db_logNumReg($iRowsEmpenhoMovimentacao,$sArquivoLog,$iParamLog);

    /**
     *  Insere os registros na base de destino atravs do mtodo insertValue da classe TableDataManager que quando
     *  atinge o nmero determinado de registros ( informado na assinatura da classe )  executado automticamente
     *  o mtodo persist que insere fisicamente os registros na base de dados atravs do COPY.
     */
    for ( $iInd=0; $iInd < $iRowsEmpenhoMovimentacao; $iInd++ ) {

        $oEmpenhoMovimentacao = db_utils::fieldsMemory($rsEmpenhoMovimentacao,$iInd);

        logProcessamento($iInd,$iRowsEmpenhoMovimentacao,$iParamLog);


        if (!isset($aListaEmpenhoMovimentacaoTipo[$oEmpenhoMovimentacao->codtipo])) {

            $oTBEmpenhosMovimentacoesTipos->id        = '';
            $oTBEmpenhosMovimentacoesTipos->codtipo   = $oEmpenhoMovimentacao->codtipo;
            $oTBEmpenhosMovimentacoesTipos->codgrupo  = $oEmpenhoMovimentacao->codgrupo;
            $oTBEmpenhosMovimentacoesTipos->descricao = $oEmpenhoMovimentacao->descrtipo;

            try {
                $oTBEmpenhosMovimentacoesTipos->insertValue();
                $oTBEmpenhosMovimentacoesTipos->persist();
            } catch ( Exception $eException ) {
                throw new Exception("ERRO-0: {$eException->getMessage()}");
            }

            $aListaEmpenhoMovimentacaoTipo[$oEmpenhoMovimentacao->codtipo] = $oTBEmpenhosMovimentacoesTipos->getLastPk();

        }

        $sSqlEmpenhosDestino = "select id
    from empenhos
    where codempenho = {$oEmpenhoMovimentacao->codempenho} ";

        $rsEmpenhoDestino    = db_query($connDestino,$sSqlEmpenhosDestino);

        if ( pg_num_rows($rsEmpenhoDestino) > 0 ) {
            $iIdEmpenho = db_utils::fieldsMemory($rsEmpenhoDestino,0)->id ;
        } else {
            throw new Exception("ERRO-0: Empenho no encontrado!$oEmpenhoMovimentacao->codempenho  ");
        }

        $oEmpenhoMovimentacao->empenho_id                   = $iIdEmpenho;
        $oEmpenhoMovimentacao->empenho_movimentacao_tipo_id = $aListaEmpenhoMovimentacaoTipo[$oEmpenhoMovimentacao->codtipo];

        $oTBEmpenhosMovimentacoes->setByLineOfDBUtils($oEmpenhoMovimentacao);

        try {
            $oTBEmpenhosMovimentacoes->insertValue();
        } catch ( Exception $eException ) {
            throw new Exception("ERRO-0: {$eException->getMessage()}");
        }

    }

    /**
     *  Aps o loop  executado manualmente o mtodo persist para que sejam inserido os registros restantes
     *  ( mesmo que no tenha atingido o nmero mximo do bloco de registros )
     */
    try {
        $oTBEmpenhosMovimentacoes->persist();
    } catch ( Exception $eException ) {
        throw new Exception("ERRO-0: {$eException->getMessage()}");
    }

    // FIM MOVIMENTAES EMPENHOS *************************************************************************************//

    // SERVIDORES *********************************** //

    db_logTitulo(" IMPORTA SERVIDORES", $sArquivoLog, $iParamLog);

    $sSqlServidores  = "  create temp table dados_servidor as                        ";
    $sSqlServidores .= "  select rh02_anousu as ano,                                 ";
    $sSqlServidores .= "       rh02_mesusu as mes,                                   ";
    $sSqlServidores .= "       rh02_salari as salario_base,                          ";
    $sSqlServidores .= "       rh01_regist as matricula,                             ";
    $sSqlServidores .= "       z01_nome    as nome,                                  ";
    $sSqlServidores .= "       z01_cgccpf  as cpf,                                   ";
    $sSqlServidores .= "       rh37_descr  as cargo,                                 ";
    $sSqlServidores .= "       r70_descr   as lotacao,                               ";
    $sSqlServidores .= "       case 
                                    when rh55_descr is not null then rh55_descr                         
                                    else r70_descr
                                    end as localtrabalho,
                               ";
    $sSqlServidores .= "       rh30_descr  as vinculo,                               ";
    $sSqlServidores .= "       rh01_admiss as admissao,                              ";
    $sSqlServidores .= "       rh05_recis  as rescisao,                              ";
    $sSqlServidores .= "       codigo      as instituicao,                           ";
    $sSqlServidores .= "       rh01_instit as instit_servidor                        ";
    $sSqlServidores .= "  from rhpessoal                                             ";
    $sSqlServidores .= "       inner join rhpessoalmov on rh02_regist = rh01_regist  ";
    $sSqlServidores .= "       inner join rhfuncao     on rh37_funcao = rh02_funcao  ";
    $sSqlServidores .= "                              and rh37_instit = rh02_instit  ";
    $sSqlServidores .= "       inner join rhlota       on r70_codigo  = rh02_lota    ";
    $sSqlServidores .= "                              and r70_instit  = rh02_instit  ";
    $sSqlServidores .= "       inner join cgm          on z01_numcgm  = rh01_numcgm  ";
    $sSqlServidores .= "       inner join rhregime     on rh02_codreg = rh30_codreg  ";
    $sSqlServidores .= "                              and rh02_instit = rh30_instit  ";
    $sSqlServidores .= "       inner join db_config    on codigo      = rh02_instit  ";
    $sSqlServidores .= "       left join rhpesrescisao on rh05_seqpes = rh02_seqpes  ";
    $sSqlServidores .= "       left  join rhpeslocaltrab on rh56_seqpes = rh02_seqpes";
    $sSqlServidores .= "       and rh56_princ  = 't'                                 ";
    $sSqlServidores .= "       left  join rhlocaltrab    on rh55_codigo = rh56_localtrab";
    $sSqlServidores .= " where rh02_anousu >= {$iExercicioBase} AND rh01_sicom = 1";
    $sSqlServidores .= " AND

  ((
  rh02_anousu <
  (SELECT r11_anousu
  FROM cfpess
  ORDER BY r11_anousu DESC, r11_mesusu DESC
  LIMIT 1)
  AND rh02_mesusu <= 12
  )

  OR
  (
  rh02_anousu =
  (SELECT r11_anousu
  FROM cfpess
  ORDER BY r11_anousu DESC, r11_mesusu DESC
  LIMIT 1)

  AND rh02_mesusu <
  (SELECT r11_mesusu
  FROM cfpess
  ORDER BY r11_anousu DESC, r11_mesusu DESC
  LIMIT 1))
  )
  ";

    $sSqlServidores .= " order by rh02_anousu, rh02_mesusu, rh01_regist           ";

    db_query($connOrigem, $sSqlServidores);

    $sSqlCreateIndex = "create index dados_servidor_ano_mes_matricula_in on dados_servidor (ano, mes, matricula) ";
    db_query($connOrigem, $sSqlCreateIndex);

    $sSqlAnalyse = "analyze dados_servidor ";
    db_query($connOrigem, $sSqlAnalyse);


    // $sSqlDadosCadastraisServidor  = " select matricula as id,                         ";
    // $sSqlDadosCadastraisServidor .= "         nome,                                    ";
    // $sSqlDadosCadastraisServidor .= "        cpf,                                     ";
    // $sSqlDadosCadastraisServidor .= "        instit_servidor as instituicao,          ";
    // $sSqlDadosCadastraisServidor .= "        admissao,                                ";
    // $sSqlDadosCadastraisServidor .= "        max(rescisao) as rescisao                ";
    // $sSqlDadosCadastraisServidor .= "   from dados_servidor                           ";
    // $sSqlDadosCadastraisServidor .= "   group by id, nome, cpf, instit_servidor, admissao ";

    $sSqlDadosCadastraisServidor  = " select dados_servidor.matricula as id,";
    $sSqlDadosCadastraisServidor .= "        nome,                                    ";
    $sSqlDadosCadastraisServidor .= "        cpf,                                     ";
    $sSqlDadosCadastraisServidor .= "        instit_servidor as instituicao,          ";
    $sSqlDadosCadastraisServidor .= "        admissao,                                ";
    $sSqlDadosCadastraisServidor .= "        max (rescisao) as rescisao               ";
    $sSqlDadosCadastraisServidor .= "   from dados_servidor                           ";
    $sSqlDadosCadastraisServidor .= "
        inner join (
        select max(ano) as ano, matricula
          from dados_servidor
            GROUP BY matricula
         ) maxano on maxano.matricula = dados_servidor.matricula and maxano.ano = dados_servidor.ano ";
    $sSqlDadosCadastraisServidor .= "   group by id, nome, cpf, instit_servidor, admissao ";


    $rsServidores                 = db_query($connOrigem, $sSqlDadosCadastraisServidor);

    if ( !$rsServidores ) {
        throw new Exception("ERRO-1: Erro ao criar tabela temporaria dos servidores.!");
    }

    $iRowsServidores = pg_num_rows($rsServidores);

    db_logNumReg($iRowsServidores, $sArquivoLog, $iParamLog);

    for ($iInd = 0; $iInd < $iRowsServidores; $iInd++ ) {

        $oServidorRow                 = db_utils::fieldsMemory($rsServidores, $iInd);
        $oServidorRow->instituicao_id = $aListaInstit[$oServidorRow->instituicao];

        $oTBServidores->setByLineOfDBUtils($oServidorRow, true);
        logProcessamento($iInd, $iRowsServidores, $iParamLog);
    }

    try {
        $oTBServidores->persist();
    } catch ( Exception $eException ) {
        throw new Exception("ERRO-0: {$eException->getMessage()}");
    }

    // FIM SERVIDORES ***************************** //

    // IMPORTACAO MOVIMENTACOES SERVIDORES ******** //

    db_logTitulo(" IMPORTA MOVIMENTACOES DOS SERVIDORES", $sArquivoLog, $iParamLog);

    $sSqlMovimentacaoServidor  = " select matricula as servidor_id,                                         ";
    $sSqlMovimentacaoServidor .= "        ano,                                                              ";
    $sSqlMovimentacaoServidor .= "        mes,                                                              ";
    $sSqlMovimentacaoServidor .= "        cargo,                                                            ";
    $sSqlMovimentacaoServidor .= "        lotacao,                                                          ";
    $sSqlMovimentacaoServidor .= "        localtrabalho,                                                    ";
    $sSqlMovimentacaoServidor .= "        vinculo,                                                          ";
    $sSqlMovimentacaoServidor .= "        salario_base                                                      ";
    $sSqlMovimentacaoServidor .= "    from dados_servidor                                                   ";
    $sSqlMovimentacaoServidor .= "    group by servidor_id, ano, mes, cargo, lotacao, localtrabalho, vinculo, salario_base ";

    $rsServidoresMovimentacao  = db_query($connOrigem, $sSqlMovimentacaoServidor);

    if ( !$rsServidoresMovimentacao ) {
        throw new Exception("ERRO-1: Erro ao buscar movimentacoes dos servidores.!");
    }

    $iRowsServidores = pg_num_rows($rsServidoresMovimentacao);

    db_logNumReg($iRowsServidores, $sArquivoLog, $iParamLog);

    for ($iInd = 0; $iInd < $iRowsServidores; $iInd++) {

        $oMovimentacaoServidorRow = db_utils::fieldsMemory($rsServidoresMovimentacao, $iInd);

        $oTBMovimentacoesServidores->setByLineOfDBUtils($oMovimentacaoServidorRow, true);
        logProcessamento($iInd, $iRowsServidores, $iParamLog);
    }

    try {
        $oTBMovimentacoesServidores->persist();
    } catch (Exception $e) {
        throw new Exception("ERRO-0: {$eException->getMessage()}");
    }

    /**
     * Pega todas as movimentacoes dos servidores e monta uma matriz para pegar a movimentao correspondente
     * a competncia. a matriz $aMatrizMovimentacaoServidor ser usada ao inserir os dados financeiros.
     */
    $sSqlMatrizServidorMovimentacao  = " select id, servidor_id, mes, ano         ";
    $sSqlMatrizServidorMovimentacao .= "   from {$sSchema}.servidor_movimentacoes ";

    $rsListaServidorMovimentacao     = db_query($connDestino, $sSqlMatrizServidorMovimentacao);
    $iRowsListaServidorMovimentacao  = pg_num_rows($rsListaServidorMovimentacao);

    for ( $iInd=0; $iInd < $iRowsListaServidorMovimentacao; $iInd++ ) {

        $oServidorMovimentacaoRow = db_utils::fieldsMemory($rsListaServidorMovimentacao, $iInd);
        $aMatrizMovimentacaoServidor[$oServidorMovimentacaoRow->ano][$oServidorMovimentacaoRow->mes]
        [$oServidorMovimentacaoRow->servidor_id] = $oServidorMovimentacaoRow->id;
    }

    // FIM IMPORTACAO MOVIMENTACOES SERVIDORES **** //

    // IMPORTACAO DADOS FINANCEIROS SERVIDOR ****** //

    db_logTitulo(" IMPORTA DADOS FINANCEIROS SERVIDOR", $sArquivoLog, $iParamLog);

    /**
     * CRIA TABELA COM OS TOTALILZADORES
     */
    $sSqlTempTableSomatorio  = " create temp table somatorio as                                                                                                                ";
    $sSqlTempTableSomatorio .= "      select r14_anousu as anousu,                                                                                                                ";
    $sSqlTempTableSomatorio .= "              r14_mesusu as mesusu,                                                                                                               ";
    $sSqlTempTableSomatorio .= "              r14_regist as regist,                                                                                                               ";
    $sSqlTempTableSomatorio .= "              'Z888'::char(4) as rubrica,                                                                                                         ";
    $sSqlTempTableSomatorio .= "              sum(r14_valor)  as valor,                                                                                                           ";
    $sSqlTempTableSomatorio .= "              0               as quantidade,                                                                                                      ";
    $sSqlTempTableSomatorio .= "              'base'          as tiporubrica,                                                                                                     ";
    $sSqlTempTableSomatorio .= "              'salario'       as tipofolha,                                                                                                       ";
    $sSqlTempTableSomatorio .= "              r14_instit      as instit                                                                                                           ";
    $sSqlTempTableSomatorio .= "         from gerfsal                                                                                                                             ";
    $sSqlTempTableSomatorio .= "              inner join dados_servidor on matricula = r14_regist                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and ano       = r14_anousu                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and mes       = r14_mesusu                                                                                 ";
    $sSqlTempTableSomatorio .= "        where r14_pd     = 2                                                                                                                      ";
    $sSqlTempTableSomatorio .= "        group by r14_anousu, r14_mesusu, r14_regist, r14_instit                                                                                   ";
    $sSqlTempTableSomatorio .= "      union all                                                                                                                                   ";
    $sSqlTempTableSomatorio .= "      select r14_anousu, r14_mesusu, r14_regist, 'Z999'::char(4) as r14_rubric, sum(r14_valor) as r14_valor,0,'base', 'salario', r14_instit       ";
    $sSqlTempTableSomatorio .= "         from gerfsal                                                                                                                             ";
    $sSqlTempTableSomatorio .= "              inner join dados_servidor on matricula = r14_regist                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and ano       = r14_anousu                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and mes       = r14_mesusu                                                                                 ";
    $sSqlTempTableSomatorio .= "        where r14_pd = 1                                                                                                                          ";
    $sSqlTempTableSomatorio .= "        group by r14_anousu, r14_mesusu, r14_regist, r14_instit                                                                                   ";
    $sSqlTempTableSomatorio .= "      union all                                                                                                                                   ";
    $sSqlTempTableSomatorio .= "      select r14_anousu, r14_mesusu, r14_regist, 'Z777'::char(4) as r14_rubric, sum(r14_valor) as r14_valor,0,'base', 'salario', r14_instit       ";
    $sSqlTempTableSomatorio .= "         from gerfsal                                                                                                                             ";
    $sSqlTempTableSomatorio .= "              inner join dados_servidor on matricula = r14_regist                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and ano       = r14_anousu                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and mes       = r14_mesusu                                                                                 ";
    $sSqlTempTableSomatorio .= "        where r14_rubric between 'R901' and 'R915'                                                                                                ";
    $sSqlTempTableSomatorio .= "        group by r14_anousu, r14_mesusu, r14_regist, r14_instit                                                                                   ";
    $sSqlTempTableSomatorio .= "      union all                                                                                                                                   ";
    $sSqlTempTableSomatorio .= "      select r48_anousu, r48_mesusu, r48_regist, 'Z888'::char(4) as r48_rubric, sum(r48_valor) as r48_valor,0,'base', 'complementar', r48_instit  ";
    $sSqlTempTableSomatorio .= "         from gerfcom                                                                                                                             ";
    $sSqlTempTableSomatorio .= "              inner join dados_servidor on matricula = r48_regist                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and ano       = r48_anousu                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and mes       = r48_mesusu                                                                                 ";
    $sSqlTempTableSomatorio .= "        where r48_pd = 2                                                                                                                          ";
    $sSqlTempTableSomatorio .= "        group by r48_anousu, r48_mesusu, r48_regist, r48_instit                                                                                   ";
    $sSqlTempTableSomatorio .= "      union all                                                                                                                                   ";
    $sSqlTempTableSomatorio .= "      select r48_anousu, r48_mesusu, r48_regist, 'Z999'::char(4) as r48_rubric, sum(r48_valor) as r48_valor,0,'base', 'complementar', r48_instit  ";
    $sSqlTempTableSomatorio .= "         from gerfcom                                                                                                                             ";
    $sSqlTempTableSomatorio .= "              inner join dados_servidor on matricula = r48_regist                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and ano       = r48_anousu                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and mes       = r48_mesusu                                                                                 ";
    $sSqlTempTableSomatorio .= "        where r48_pd = 1                                                                                                                          ";
    $sSqlTempTableSomatorio .= "        group by r48_anousu, r48_mesusu, r48_regist, r48_instit                                                                                   ";
    $sSqlTempTableSomatorio .= "      union all                                                                                                                                   ";
    $sSqlTempTableSomatorio .= "      select r48_anousu, r48_mesusu, r48_regist, 'Z777'::char(4) as r48_rubric, sum(r48_valor) as r48_valor,0,'base', 'complementar', r48_instit  ";
    $sSqlTempTableSomatorio .= "         from gerfcom                                                                                                                             ";
    $sSqlTempTableSomatorio .= "              inner join dados_servidor on matricula = r48_regist                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and ano       = r48_anousu                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and mes       = r48_mesusu                                                                                 ";
    $sSqlTempTableSomatorio .= "        where r48_rubric between 'R901' and 'R915'                                                                                                ";
    $sSqlTempTableSomatorio .= "        group by r48_anousu, r48_mesusu, r48_regist, r48_instit                                                                                   ";
    $sSqlTempTableSomatorio .= "      union all                                                                                                                                   ";
    $sSqlTempTableSomatorio .= "      select r35_anousu, r35_mesusu, r35_regist, 'Z888'::char(4) as r35_rubric, sum(r35_valor) as r35_valor,0,'base', '13salario', r35_instit     ";
    $sSqlTempTableSomatorio .= "         from gerfs13                                                                                                                             ";
    $sSqlTempTableSomatorio .= "              inner join dados_servidor on matricula = r35_regist                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and ano       = r35_anousu                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and mes       = r35_mesusu                                                                                 ";
    $sSqlTempTableSomatorio .= "        where r35_pd = 2                                                                                                                          ";
    $sSqlTempTableSomatorio .= "        group by r35_anousu, r35_mesusu, r35_regist, r35_instit                                                                                   ";
    $sSqlTempTableSomatorio .= "      union all                                                                                                                                   ";
    $sSqlTempTableSomatorio .= "      select r35_anousu, r35_mesusu, r35_regist, 'Z999'::char(4) as r35_rubric, sum(r35_valor) as r35_valor,0,'base', '13salario', r35_instit     ";
    $sSqlTempTableSomatorio .= "         from gerfs13                                                                                                                             ";
    $sSqlTempTableSomatorio .= "              inner join dados_servidor on matricula = r35_regist                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and ano       = r35_anousu                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and mes       = r35_mesusu                                                                                 ";
    $sSqlTempTableSomatorio .= "        where r35_pd = 1                                                                                                                          ";
    $sSqlTempTableSomatorio .= "        group by r35_anousu, r35_mesusu, r35_regist, r35_instit                                                                                   ";
    $sSqlTempTableSomatorio .= "      union all                                                                                                                                   ";
    $sSqlTempTableSomatorio .= "      select r35_anousu, r35_mesusu, r35_regist, 'Z777'::char(4) as r35_rubric, sum(r35_valor) as r35_valor,0,'base', '13salario', r35_instit     ";
    $sSqlTempTableSomatorio .= "         from gerfs13                                                                                                                             ";
    $sSqlTempTableSomatorio .= "              inner join dados_servidor on matricula = r35_regist                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and ano       = r35_anousu                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and mes       = r35_mesusu                                                                                 ";
    $sSqlTempTableSomatorio .= "        where r35_rubric between 'R901' and 'R915'                                                                                                ";
    $sSqlTempTableSomatorio .= "        group by r35_anousu, r35_mesusu, r35_regist, r35_instit                                                                                   ";
    $sSqlTempTableSomatorio .= "      union all                                                                                                                                   ";
    $sSqlTempTableSomatorio .= "      select r20_anousu, r20_mesusu, r20_regist, 'Z888'::char(4) as r20_rubric, sum(r20_valor) as r20_valor,0,'base', 'rescisao', r20_instit      ";
    $sSqlTempTableSomatorio .= "         from gerfres                                                                                                                             ";
    $sSqlTempTableSomatorio .= "              inner join dados_servidor on matricula = r20_regist                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and ano       = r20_anousu                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and mes       = r20_mesusu                                                                                 ";
    $sSqlTempTableSomatorio .= "        where r20_pd = 2                                                                                                                          ";
    $sSqlTempTableSomatorio .= "        group by r20_anousu, r20_mesusu, r20_regist, r20_instit                                                                                   ";
    $sSqlTempTableSomatorio .= "      union all                                                                                                                                   ";
    $sSqlTempTableSomatorio .= "      select r20_anousu, r20_mesusu, r20_regist, 'Z999'::char(4) as r20_rubric, sum(r20_valor) as r20_valor,0,'base', 'rescisao', r20_instit      ";
    $sSqlTempTableSomatorio .= "         from gerfres                                                                                                                             ";
    $sSqlTempTableSomatorio .= "              inner join dados_servidor on matricula = r20_regist                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and ano       = r20_anousu                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and mes       = r20_mesusu                                                                                 ";
    $sSqlTempTableSomatorio .= "        where r20_pd = 1                                                                                                                          ";
    $sSqlTempTableSomatorio .= "        group by r20_anousu, r20_mesusu, r20_regist, r20_instit                                                                                   ";
    $sSqlTempTableSomatorio .= "      union all                                                                                                                                   ";
    $sSqlTempTableSomatorio .= "      select r20_anousu, r20_mesusu, r20_regist, 'Z777'::char(4) as r20_rubric, sum(r20_valor) as r20_valor,0,'base', 'rescisao', r20_instit      ";
    $sSqlTempTableSomatorio .= "         from gerfres                                                                                                                             ";
    $sSqlTempTableSomatorio .= "              inner join dados_servidor on matricula = r20_regist                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and ano       = r20_anousu                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and mes       = r20_mesusu                                                                                 ";
    $sSqlTempTableSomatorio .= "        where r20_rubric between 'R901' and 'R915'                                                                                                ";
    $sSqlTempTableSomatorio .= "        group by r20_anousu, r20_mesusu, r20_regist, r20_instit                                                                                   ";
    $sSqlTempTableSomatorio .= "                                                                                                                                                  ";
    $sSqlTempTableSomatorio .= "      union all                                                                                                                                   ";
    $sSqlTempTableSomatorio .= "      select r22_anousu, r22_mesusu, r22_regist, 'Z888'::char(4) as r22_rubric, sum(r22_valor) as r22_valor,0,'base', 'adiantamento', r22_instit  ";
    $sSqlTempTableSomatorio .= "         from gerfadi                                                                                                                             ";
    $sSqlTempTableSomatorio .= "              inner join dados_servidor on matricula = r22_regist                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and ano       = r22_anousu                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and mes       = r22_mesusu                                                                                 ";
    $sSqlTempTableSomatorio .= "        where r22_pd = 2                                                                                                                          ";
    $sSqlTempTableSomatorio .= "        group by r22_anousu, r22_mesusu, r22_regist, r22_instit                                                                                   ";
    $sSqlTempTableSomatorio .= "      union all                                                                                                                                   ";
    $sSqlTempTableSomatorio .= "      select r22_anousu, r22_mesusu, r22_regist, 'Z999'::char(4) as r22_rubric, sum(r22_valor) as r22_valor,0,'base', 'adiantamento', r22_instit  ";
    $sSqlTempTableSomatorio .= "         from gerfadi                                                                                                                             ";
    $sSqlTempTableSomatorio .= "              inner join dados_servidor on matricula = r22_regist                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and ano       = r22_anousu                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and mes       = r22_mesusu                                                                                 ";
    $sSqlTempTableSomatorio .= "        where r22_pd = 1                                                                                                                          ";
    $sSqlTempTableSomatorio .= "        group by r22_anousu, r22_mesusu, r22_regist, r22_instit                                                                                   ";
    $sSqlTempTableSomatorio .= "      union all                                                                                                                                   ";
    $sSqlTempTableSomatorio .= "      select r22_anousu, r22_mesusu, r22_regist, 'Z777'::char(4) as r22_rubric, sum(r22_valor) as r22_valor,0,'base', 'adiantamento', r22_instit  ";
    $sSqlTempTableSomatorio .= "         from gerfadi                                                                                                                             ";
    $sSqlTempTableSomatorio .= "              inner join dados_servidor on matricula = r22_regist                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and ano       = r22_anousu                                                                                 ";
    $sSqlTempTableSomatorio .= "                                       and mes       = r22_mesusu                                                                                 ";
    $sSqlTempTableSomatorio .= "        where r22_rubric between 'R901' and 'R915'                                                                                                ";
    $sSqlTempTableSomatorio .= "        group by r22_anousu, r22_mesusu, r22_regist, r22_instit                                                                                   ";
    $rsTempSomatorio = db_query($sSqlTempTableSomatorio);

    if(!$rsTempSomatorio){
        throw new Exception("ERRO-1: Erro ao criar tabela somatorio!");
    }

    $sSqlIndiceSomatorio  = "create index somatorio_anousu_mesusu_regist_in on somatorio (anousu, mesusu, regist)";
    $rsIndiceSomatorio    = db_query($sSqlIndiceSomatorio);

    if(!$rsIndiceSomatorio){
        throw new Exception("ERRO-1: Erro ao criar indice somatorio_anousu_mesusu_regist_in!");
    }

    $sSqlAnalizeSomatorio = "analyze somatorio";
    $rsAnalizeSomatorio   = db_query($sSqlAnalizeSomatorio);

    if(!$rsAnalizeSomatorio){
        throw new Exception("ERRO-1: Erro ao executar analyze!");
    }

    $sSqlDadosServidores = "select distinct ano, mes from dados_servidor";
    $rsDadosServidores   = db_query($connOrigem, $sSqlDadosServidores);
    $iDadosServidores    = pg_num_rows($rsDadosServidores);

    for ($iServidor = 0; $iServidor < $iDadosServidores; $iServidor++) {

        $oDadosServidores = db_utils::fieldsMemory($rsDadosServidores, $iServidor);
        $mes = $oDadosServidores->mes;
        $ano = $oDadosServidores->ano;

        $sSqlFolhaPagamento  = "   select ano,                                                                                                                                    ";
        $sSqlFolhaPagamento .= "          mes,                                                                                                                                    ";
        $sSqlFolhaPagamento .= "          matricula,                                                                                                                              ";
        $sSqlFolhaPagamento .= "          rubrica,                                                                                                                                ";
        $sSqlFolhaPagamento .= "          case when rh27_descr is not null then rh27_descr                                                                                        ";
        $sSqlFolhaPagamento .= "               when rubrica = 'Z999' then 'Total Bruto'                                                                                           ";
        $sSqlFolhaPagamento .= "               when rubrica = 'Z888' then 'Total Descontos'                                                                                       ";
        $sSqlFolhaPagamento .= "               when rubrica = 'Z777' then 'Descontos Obrigatrios'                                                                                ";
        $sSqlFolhaPagamento .= "          end as descr_rubrica,                                                                                                                   ";
        $sSqlFolhaPagamento .= "          valor,                                                                                                                                  ";
        $sSqlFolhaPagamento .= "          quantidade,                                                                                                                             ";
        $sSqlFolhaPagamento .= "          tiporubrica,                                                                                                                            ";
        $sSqlFolhaPagamento .= "          tipofolha,                                                                                                                              ";
        $sSqlFolhaPagamento .= "          instit                                                                                                                                  ";
        $sSqlFolhaPagamento .= "     from (                                                                                                                                       ";
        $sSqlFolhaPagamento .= "      select r14_anousu as ano,r14_mesusu as mes,r14_regist as matricula,r14_rubric as rubrica, r14_valor as valor, r14_quant as quantidade,      ";
        $sSqlFolhaPagamento .= "        case r14_pd when 1 then 'provento' when 2 then 'desconto' else 'base' end as tiporubrica, 'salario' as tipofolha, r14_instit as instit    ";
        $sSqlFolhaPagamento .= "        from gerfsal                                                                                                                              ";
        $sSqlFolhaPagamento .= "             inner join dados_servidor on matricula = r14_regist                                                                                  ";
        $sSqlFolhaPagamento .= "                                      and ano       = r14_anousu                                                                                  ";
        $sSqlFolhaPagamento .= "                                      and mes       = r14_mesusu                                                                                  ";
        $sSqlFolhaPagamento .= "      where r14_mesusu = {$mes}                                                                                                                   ";
        $sSqlFolhaPagamento .= "        and r14_anousu = {$ano}                                                                                                                   ";
        $sSqlFolhaPagamento .= "      union all                                                                                                                                   ";
        $sSqlFolhaPagamento .= "       select r48_anousu,r48_mesusu,r48_regist,r48_rubric, r48_valor, r48_quant,                                                                  ";
        $sSqlFolhaPagamento .= "         case r48_pd when 1 then 'provento' when 2 then 'desconto' else 'base' end, 'complementar', r48_instit                                    ";
        $sSqlFolhaPagamento .= "         from gerfcom                                                                                                                             ";
        $sSqlFolhaPagamento .= "              inner join dados_servidor on matricula = r48_regist                                                                                 ";
        $sSqlFolhaPagamento .= "                                       and ano       = r48_anousu                                                                                 ";
        $sSqlFolhaPagamento .= "                                       and mes       = r48_mesusu                                                                                 ";
        $sSqlFolhaPagamento .= "      where r48_mesusu = {$mes}                                                                                                                   ";
        $sSqlFolhaPagamento .= "        and r48_anousu = {$ano}                                                                                                                   ";
        $sSqlFolhaPagamento .= "      union all                                                                                                                                   ";
        $sSqlFolhaPagamento .= "       select r35_anousu,r35_mesusu,r35_regist,r35_rubric, r35_valor, r35_quant,                                                                  ";
        $sSqlFolhaPagamento .= "         case r35_pd when 1 then 'provento' when 2 then 'desconto' else 'base' end, '13salario', r35_instit                                       ";
        $sSqlFolhaPagamento .= "         from gerfs13                                                                                                                             ";
        $sSqlFolhaPagamento .= "              inner join dados_servidor on matricula = r35_regist                                                                                 ";
        $sSqlFolhaPagamento .= "                                       and ano       = r35_anousu                                                                                 ";
        $sSqlFolhaPagamento .= "                                       and mes       = r35_mesusu                                                                                 ";
        $sSqlFolhaPagamento .= "      where r35_mesusu = {$mes}                                                                                                                   ";
        $sSqlFolhaPagamento .= "        and r35_anousu = {$ano}                                                                                                                   ";
        $sSqlFolhaPagamento .= "      union all                                                                                                                                   ";
        $sSqlFolhaPagamento .= "       select r20_anousu,r20_mesusu,r20_regist,r20_rubric, r20_valor, r20_quant,                                                                  ";
        $sSqlFolhaPagamento .= "         case r20_pd when 1 then 'provento' when 2 then 'desconto' else 'base' end, 'rescisao', r20_instit                                        ";
        $sSqlFolhaPagamento .= "         from gerfres                                                                                                                             ";
        $sSqlFolhaPagamento .= "              inner join dados_servidor on matricula = r20_regist                                                                                 ";
        $sSqlFolhaPagamento .= "                                       and ano       = r20_anousu                                                                                 ";
        $sSqlFolhaPagamento .= "                                       and mes       = r20_mesusu                                                                                 ";
        $sSqlFolhaPagamento .= "      where r20_mesusu = {$mes}                                                                                                                   ";
        $sSqlFolhaPagamento .= "        and r20_anousu = {$ano}                                                                                                                   ";
        $sSqlFolhaPagamento .= "      union all                                                                                                                                   ";
        $sSqlFolhaPagamento .= "        select r22_anousu,r22_mesusu,r22_regist,r22_rubric, r22_valor, r22_quant,                                                                 ";
        $sSqlFolhaPagamento .= "         case r22_pd when 1 then 'provento' when 2 then 'desconto' else 'base' end, 'adiantamento', r22_instit                                    ";
        $sSqlFolhaPagamento .= "         from gerfadi                                                                                                                             ";
        $sSqlFolhaPagamento .= "              inner join dados_servidor on matricula = r22_regist                                                                                 ";
        $sSqlFolhaPagamento .= "                                       and ano       = r22_anousu                                                                                 ";
        $sSqlFolhaPagamento .= "                                       and mes       = r22_mesusu                                                                                 ";
        $sSqlFolhaPagamento .= "      where r22_mesusu = {$mes}                                                                                                                   ";
        $sSqlFolhaPagamento .= "        and r22_anousu = {$ano}                                                                                                                   ";
        $sSqlFolhaPagamento .= "      union all                                                                                                                                   ";
        $sSqlFolhaPagamento .= "       select anousu, mesusu, regist, rubrica, valor, quantidade, tiporubrica, tipofolha, instit                                                  ";
        $sSqlFolhaPagamento .= "         from somatorio                                                                                                                           ";
        $sSqlFolhaPagamento .= "      where mesusu = {$mes}                                                                                                                   ";
        $sSqlFolhaPagamento .= "        and anousu = {$ano}                                                                                                                   ";
        $sSqlFolhaPagamento .= "     ) as x                                                                                                                                       ";
        $sSqlFolhaPagamento .= "  left join rhrubricas on rubrica = rh27_rubric and instit = rh27_instit                                                                          ";
        $sSqlFolhaPagamento .= "  order by ano,mes,matricula,tipofolha, tiporubrica desc, rubrica;                                                                                ";

        $rsFolhaPagamento    = db_query($connOrigem, $sSqlFolhaPagamento);

        if ( !$rsFolhaPagamento ) {
            throw new Exception("ERRO-1: Erro ao buscar dados de rubricas.!");
        }

        $iRowsFolhaPagamento = pg_num_rows($rsFolhaPagamento);

        db_logNumReg($iRowsFolhaPagamento, $sArquivoLog, $iParamLog);

        for ($iInd = 0; $iInd < $iRowsFolhaPagamento; $iInd++) {

            $oFolhaPagamentoRow = db_utils::fieldsMemory($rsFolhaPagamento, $iInd);

            if ( !empty($aMatrizMovimentacaoServidor[$oFolhaPagamentoRow->ano][$oFolhaPagamentoRow->mes][$oFolhaPagamentoRow->matricula]) ) {

                $oFolhaPagamentoRow->servidor_movimentacao_id = $aMatrizMovimentacaoServidor[$oFolhaPagamentoRow->ano]
                [$oFolhaPagamentoRow->mes]
                [$oFolhaPagamentoRow->matricula];

                $oTBFolhaPagamento->setByLineOfDBUtils($oFolhaPagamentoRow, true);
                logProcessamento($iInd, $iRowsFolhaPagamento, $iParamLog);
            } else {

                $sMensagemSemMovimentacao = "Dados Financeiros: {$oFolhaPagamentoRow->matricula} - {$oFolhaPagamentoRow->ano}/{$oFolhaPagamentoRow->mes}  sem movimentaes.";
                db_log($sMensagemSemMovimentacao, $sArquivoLog, $iParamLog);
            }

        }

        try {
            $oTBFolhaPagamento->persist();
        } catch (Exception $e) {
            throw new Exception("ERRO-0: {$eException->getMessage()}");
        }

        // FIM IMPORTACAO DADOS FINANCEIROS SERVIDOR ** //

    }

    // IMPORTACAO RECURSOS HUMANOS SERVIDOR ******* //

    db_logTitulo(" IMPORTA DADOS RECURSOS HUMANOS SERVIDOR", $sArquivoLog, $iParamLog);

    $sSqlRecursosHumanos  = " select h16_regist as servidor_id,                         ";
    $sSqlRecursosHumanos .= "        h12_assent,                                        ";
    $sSqlRecursosHumanos .= "        h12_descr as descricao,                            ";
    $sSqlRecursosHumanos .= "        h16_nrport as numero_portaria,                     ";
    $sSqlRecursosHumanos .= "        h16_atofic as ato_oficial,                         ";
    $sSqlRecursosHumanos .= "        h16_dtconc data_concessao,                         ";
    $sSqlRecursosHumanos .= "        h16_dtterm as data_termino,                        ";
    $sSqlRecursosHumanos .= "        h16_quant as quantidade_dias,                      ";
    $sSqlRecursosHumanos .= "        h16_histor as historico                            ";
    $sSqlRecursosHumanos .= "   from assenta                                            ";
    $sSqlRecursosHumanos .= "      inner join tipoasse       on h12_codigo = h16_assent ";
    $sSqlRecursosHumanos .= "  where exists (select 1                                   ";
    $sSqlRecursosHumanos .= "                  from dados_servidor                      ";
    $sSqlRecursosHumanos .= "                 where matricula = h16_regist              ";
    $sSqlRecursosHumanos .= "               )                                           ";

    $rsRecursosHumanos    = db_query($connOrigem, $sSqlRecursosHumanos);

    if ( !$rsRecursosHumanos ) {
        throw new Exception("ERRO-1: Erro ao buscar dados recursos humanos.!");
    }

    $iRowsRecursosHumanos = pg_num_rows($rsRecursosHumanos);

    db_logNumReg($iRowsRecursosHumanos, $sArquivoLog, $iParamLog);

    for ($iInd = 0; $iInd < $iRowsRecursosHumanos; $iInd++) {

        $oRecursosHumanosRow = db_utils::fieldsMemory($rsRecursosHumanos, $iInd);

        $oTBAssentamentos->setByLineOfDBUtils($oRecursosHumanosRow, true);
        logProcessamento($iInd, $iRowsRecursosHumanos, $iParamLog);
    }

    try {
        $oTBAssentamentos->persist();
    } catch (Exception $e) {
        throw new Exception("ERRO-0: {$eException->getMessage()}");
    }

    // FIM IMPORTACAO RECURSOS HUMANOS ASSENTAMENTOS //

    /**
     * Importacao das Licitacoes
     */
    $oIntegracaoPortalTransparencia = new IntegracaoPortalTransparencia();
    $oIntegracaoPortalTransparencia->setConexaoDestino($connDestino);
    $oIntegracaoPortalTransparencia->setConexaoOrigem($connOrigem);
    $oIntegracaoPortalTransparencia->setAnoInicioIntegracao($iExercicioBase);
    $oIntegracaoPortalTransparencia->setArquivoLog($sArquivoLog);
    $oIntegracaoPortalTransparencia->setParamLog($iParamLog);

    foreach ($aIntegracoesRealizar as $sIntegracao) {
        $oIntegracaoPortalTransparencia->adicionarIntegracao(new $sIntegracao);
    }

    db_query($connOrigem, "begin");
    $oIntegracaoPortalTransparencia->executar();
    db_query($connOrigem, "commit");

    /**
     * Exclui os large objects vinculados ao schema de backup
     */

    $aLargeObjectsToRemove = array( 'licitacoes_documentos' => 'documento',
        'acordo_documentos' => 'arquivo' );

    if ( $iLinhasSchemasAtual > 0 ) {

        foreach ($aLargeObjectsToRemove as $sTabela => $sNomeCampoOid) {

            $rsFilesToRemove = db_query($connDestino, "select {$sNomeCampoOid} from {$sBkpSchema}.{$sTabela}");

            if (!pg_num_rows($rsFilesToRemove)) {
                continue;
            }

            for ($iIndice = 0; $iIndice < pg_num_rows($rsFilesToRemove); $iIndice++) {

                $oRow            = db_utils::fieldsMemory($rsFilesToRemove, $iIndice);
                $sSqlBuscaObjeto = "select pg_largeobject.loid
        from pg_largeobject
        where pg_largeobject.loid = {$oRow->{$sNomeCampoOid}} ";
                $rsBuscaObjeto   = pg_query($connDestino, $sSqlBuscaObjeto);

                if (pg_num_rows($rsBuscaObjeto) > 0) {

                    $lUnlink = pg_lo_unlink($connDestino, $oRow->{$sNomeCampoOid});
                    if (!$lUnlink) {
                        continue;
                    }
                }
            }
        }
    }

    // EXCLUSO DE SCHEMAS ANTIGOS ************************************************************************************//

    $sSqlConsultaSchemasAntigos = "select distinct schema_name
  from information_schema.schemata
  where schema_name like 'bkp_transparencia_%'
  order by schema_name desc
  offset {$iNroBasesAntigas} ";

    $rsSchemasAntigos      = db_query($connDestino,$sSqlConsultaSchemasAntigos);
    $iLinhasSchemasAntigos = pg_num_rows($rsSchemasAntigos);

    for ($iInd=0; $iInd < $iLinhasSchemasAntigos; $iInd++ ) {

        $oSchemaAntigo = db_utils::fieldsMemory($rsSchemasAntigos,$iInd);

        $sSqlExcluiSchemaAntigo = " DROP SCHEMA {$oSchemaAntigo->schema_name} CASCADE ";

        if ( !db_query($connDestino,$sSqlExcluiSchemaAntigo) ) {
            throw new Exception("ERRO-0: Erro ao excluir schema {$oSchemaAntigo->schema_name} !");
        }

    }

    // FIM DA EXCLUSO DE SCHEMAS ANTIGOS *****************************************************************************//


    if ( $iLinhasSchemasAtual > 0 ) {

        // ACERTA TABELA empenhos_movimentacoes_exercicios ****************************************************************//


        $sSqlAcertaEmpMovExerc = " INSERT INTO empenhos_movimentacoes_exercicios (empenho_id,exercicio)
    select distinct empenho_id,
    extract( year from data) as exercicio
    from empenhos_movimentacoes ";

        $rsAcertaEmpMovExerc = db_query($connDestino,$sSqlAcertaEmpMovExerc);

        if ( !$rsAcertaEmpMovExerc ) {
            throw new Exception("ERRO-0: Erro ao acertar tabela empenhos_movimentacoes_exercicios !");
        }

        // ****************************************************************************************************************//


        // ACERTA GLOSSARIOS TIPOS ****************************************************************************************//


        $sSqlGlossariosTipos    = " select *
    from {$sBkpSchema}.glossarios_tipos ";

        $rsDadosGlossariosTipos = db_query($connDestino,$sSqlGlossariosTipos);

        if ( !$rsDadosGlossariosTipos ) {
            throw new Exception("ERRO-0: Erro ao consultar tabela glossarios_tipos !");
        }

        $iLinhasGlossariosTipos = pg_num_rows($rsDadosGlossariosTipos);

        for ( $iInd=0; $iInd < $iLinhasGlossariosTipos; $iInd++ ) {

            $oGloassariosTipos = db_utils::fieldsMemory($rsDadosGlossariosTipos,$iInd);

            $oTBGlossariosTipos->setByLineOfDBUtils($oGloassariosTipos);

            try {
                $oTBGlossariosTipos->insertValue();
            } catch ( Exception $eException ) {
                throw new Exception("ERRO-0: {$eException->getMessage()}");
            }

        }

        try {
            $oTBGlossariosTipos->persist();
        } catch ( Exception $eException ) {
            throw new Exception("ERRO-0: {$eException->getMessage()}");
        }

        // ****************************************************************************************************************//

        // ACERTA GLOSSARIOS **********************************************************************************************//

        $sSqlGlossarios    = " select *
    from {$sBkpSchema}.glossarios ";

        $rsDadosGlossarios = db_query($connDestino,$sSqlGlossarios);

        if ( !$rsDadosGlossarios ) {
            throw new Exception("ERRO-0: Erro ao consultar tabela glossarios !");
        }

        $iLinhasGlossarios = pg_num_rows($rsDadosGlossarios);

        for ( $iInd=0; $iInd < $iLinhasGlossarios; $iInd++ ) {

            $oGloassarios = db_utils::fieldsMemory($rsDadosGlossarios,$iInd);

            $oTBGlossarios->setByLineOfDBUtils($oGloassarios);

            try {
                $oTBGlossarios->insertValue();
            } catch ( Exception $eException ) {
                throw new Exception("ERRO-0: {$eException->getMessage()}");
            }

        }

        try {
            $oTBGlossarios->persist();
        } catch ( Exception $eException ) {
            throw new Exception("ERRO-0: {$eException->getMessage()}");
        }

        // ****************************************************************************************************************//

    }

} catch (Exception $eException) {

    $lErro = true;
    db_log($eException->getMessage(),$sArquivoLog,$iParamLog);

}

if ( $lErro ) {

    db_query($connDestino,"ROLLBACK;");
    db_logTitulo(" FIM PROCESSAMENTO COM ERRO",$sArquivoLog,$iParamLog);
    throw new Exception('FIM PROCESSAMENTO COM ERRO');
} else {

    db_query($connDestino,"COMMIT;");
    db_logTitulo(" FIM PROCESSAMENTO ",$sArquivoLog,$iParamLog);
}


function db_log($sLog = "", $sArquivo = "", $iTipo = 0, $lLogDataHora = true, $lQuebraAntes = true) {

    $aDataHora    = getdate();
    $sQuebraAntes = $lQuebraAntes ? "\n" : "";

    if ($lLogDataHora) {
        $sOutputLog = sprintf("%s[%02d/%02d/%04d %02d:%02d:%02d] %s", $sQuebraAntes, $aDataHora ["mday"], $aDataHora ["mon"], $aDataHora ["year"], $aDataHora ["hours"], $aDataHora ["minutes"], $aDataHora ["seconds"], $sLog);
    } else {
        $sOutputLog = sprintf("%s%s", $sQuebraAntes, $sLog);
    }

    // Se habilitado saida na tela...
    if ($iTipo == 0 or $iTipo == 1) {
        echo $sOutputLog;
    }

    // Se habilitado saida para arquivo...
    if ($iTipo == 0 or $iTipo == 2) {
        if (! empty($sArquivo)) {
            $fd = fopen($sArquivo, "a+");
            if ($fd) {
                fwrite($fd, $sOutputLog);
                fclose($fd);
            }
        }
    }

    return $aDataHora;

}


/**
 * Funo que exibe na tela a quantidade de registros processados
 * e a quandidade de memria utilizada
 *
 * @param integer $iInd      Indice da linha que est sendo processada
 * @param integer $iTotalLinhas  Total de linhas a processar
 * @param integer $iParamLog     Caso seja passado true  exibido na tela
 */
function logProcessamento($iInd,$iTotalLinhas,$iParamLog) {

    $nPercentual = round((($iInd + 1) / $iTotalLinhas) * 100, 2);
    $nMemScript  = (float)round( (memory_get_usage()/1024 ) / 1024,2);
    $sMemScript  = $nMemScript ." Mb";
    $sMsg        = "".($iInd+1)." de {$iTotalLinhas} Processando ".str_pad($nPercentual,5,' ',STR_PAD_LEFT)." %"." Total de memoria utilizada : {$sMemScript} ";
    $sMsg        = str_pad($sMsg,100," ",STR_PAD_RIGHT);
    db_log($sMsg."\r",null,$iParamLog,true,false);

}


/**
 * Imprime o ttulo do log
 *
 * @param string  $sTitulo
 * @param boolean $iParamLog  Caso seja passado true  exibido na tela
 */
function db_logTitulo($sTitulo="",$sArquivoLog="",$iParamLog=0) {

    db_log("",$sArquivoLog,$iParamLog);
    db_log("//".str_pad($sTitulo,85,"-",STR_PAD_BOTH)."//",$sArquivoLog,$iParamLog);
    db_log("",$sArquivoLog,$iParamLog);
    db_log("",$sArquivoLog,$iParamLog);
}

function db_logNumReg($iLinhas,$sArquivoLog,$iParamLog) {

    db_log("Total de Registros Encontrados : {$iLinhas}",$sArquivoLog,$iParamLog);
    db_log("\n",$sArquivoLog,1);
}

?>
