<?php
// ini_set('display_errors','On');
// error_reporting(E_ALL);
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2013  DBselller Servicos de Informatica
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

require_once(modification("libs/db_stdlib.php"));
require_once(modification("std/db_stdClass.php"));
require_once(modification("libs/db_utils.php"));
require_once(modification("libs/db_app.utils.php"));
require_once(modification("libs/db_conecta.php"));
require_once(modification("libs/db_sessoes.php"));
require_once(modification("libs/JSON.php"));
require_once(modification("dbforms/db_funcoes.php"));
require_once(modification("model/contabilidade/planoconta/ContaCorrente.model.php"));
require_once(modification("model/contabilidade/planoconta/ContaPlano.model.php"));
db_app::import("configuracao.*");
db_app::import("contabilidade.*");
db_app::import("contabilidade.planoconta.*");
db_app::import("financeiro.*");
db_app::import("exceptions.*");

$oParam = json_decode(str_replace("\\", "", $_POST["json"]));
$iAnoSessao = db_getsession("DB_anousu");
$oRetorno = new stdClass();
$oRetorno->status = 1;
$oRetorno->message = '';

try {

    switch ($oParam->exec) {


        /**
         * case para inclusão de um novo detalhamento
         */
        case 'incluirDetalhamento' :

            $oDaoContaCorrenteDetalhe = db_utils::getDao('contacorrentedetalhe');
            $oDaoVerificaDetalhe = db_utils::getDao('contacorrentedetalhe');

            $iReduzido = $oParam->iCodigoReduzido;
            $iContaCorrente = $oParam->iContaCorrente;
            $iInstituicao = db_getsession("DB_instit");
            $iAnoUsu = db_getsession("DB_anousu");

            $iTipoReceita = $oParam->iTipoReceita;
            $iConcarPeculiar = $oParam->iConcarPeculiar;
            $iContaBancaria = $oParam->iContaBancaria;
            $iEmpenho = $oParam->iEmpenho;
            $iNome = $oParam->iNome;
            $iOrgao = $oParam->iOrgao;
            $iUnidade = $oParam->iUnidade;
            $iAcordo = $oParam->iAcordo;


            db_inicio_transacao();
            switch ($iContaCorrente) {

                case 1:  //disponibilidade financeira

                    $sWhereVerificacao = "     c19_contacorrente       = {$iContaCorrente}    ";
                    $sWhereVerificacao .= " and c19_orctiporec          = {$iTipoReceita}      ";
                    $sWhereVerificacao .= " and c19_instit              = {$iInstituicao}      ";
                    $sWhereVerificacao .= " and c19_concarpeculiar      = '{$iConcarPeculiar}' ";
                    $sWhereVerificacao .= " and c19_reduz               = {$iReduzido}         ";
                    $sWhereVerificacao .= " and c19_conplanoreduzanousu = {$iAnoUsu}           ";

                    $sSqlVerificaDetalhe = $oDaoVerificaDetalhe->sql_query_file(null, "*", null, $sWhereVerificacao);
                    $rsVerificacao = $oDaoVerificaDetalhe->sql_record($sSqlVerificaDetalhe);

                    if ($oDaoVerificaDetalhe->numrows > 0) {
                        $sDescricaoContaCorrenteErro = "1 - Disponibilidade Financeira";
                    }

                    $oDaoContaCorrenteDetalhe->c19_contacorrente = $iContaCorrente;
                    $oDaoContaCorrenteDetalhe->c19_orctiporec = $iTipoReceita;
                    $oDaoContaCorrenteDetalhe->c19_instit = $iInstituicao;
                    $oDaoContaCorrenteDetalhe->c19_concarpeculiar = "'{$iConcarPeculiar}'";
                    $oDaoContaCorrenteDetalhe->c19_reduz = $iReduzido;
                    $oDaoContaCorrenteDetalhe->c19_conplanoreduzanousu = $iAnoUsu;


                    break;

                case 2:  //domicilio bancario

                    $sWhereVerificacao = "     c19_contacorrente       = {$iContaCorrente} ";
                    $sWhereVerificacao .= " and c19_instit              = {$iInstituicao}   ";
                    $sWhereVerificacao .= " and c19_reduz               = {$iReduzido}      ";
                    $sWhereVerificacao .= " and c19_conplanoreduzanousu = {$iAnoUsu}        ";
                    $sWhereVerificacao .= " and c19_contabancaria       = {$iContaBancaria} ";

                    $sSqlVerificaDetalhe = $oDaoVerificaDetalhe->sql_query_file(null, "*", null, $sWhereVerificacao);
                    $rsVerificacao = $oDaoVerificaDetalhe->sql_record($sSqlVerificaDetalhe);

                    if ($oDaoVerificaDetalhe->numrows > 0) {
                        $sDescricaoContaCorrenteErro = "2 - Domicilio Bancário";
                    }

                    $oDaoContaCorrenteDetalhe->c19_contacorrente = $iContaCorrente;
                    $oDaoContaCorrenteDetalhe->c19_instit = $iInstituicao;
                    $oDaoContaCorrenteDetalhe->c19_conplanoreduzanousu = $iAnoUsu;
                    $oDaoContaCorrenteDetalhe->c19_reduz = $iReduzido;
                    $oDaoContaCorrenteDetalhe->c19_contabancaria = $iContaBancaria;
                    break;

                case 3: // credor fornecedor / devedor

                    $sWhereVerificacao = "     c19_contacorrente       = {$iContaCorrente} ";
                    $sWhereVerificacao .= " and c19_instit              = {$iInstituicao}   ";
                    $sWhereVerificacao .= " and c19_reduz               = {$iReduzido}      ";
                    $sWhereVerificacao .= " and c19_conplanoreduzanousu = {$iAnoUsu}        ";
                    $sWhereVerificacao .= " and c19_numcgm              = {$iNome}          ";

                    $sSqlVerificaDetalhe = $oDaoVerificaDetalhe->sql_query_file(null, "*", null, $sWhereVerificacao);
                    $rsVerificacao = $oDaoVerificaDetalhe->sql_record($sSqlVerificaDetalhe);

                    if ($oDaoVerificaDetalhe->numrows > 0) {
                        $sDescricaoContaCorrenteErro = "3 - Credor / Fornecedor / Devedor";
                    }

                    $oDaoContaCorrenteDetalhe->c19_contacorrente = $iContaCorrente;
                    $oDaoContaCorrenteDetalhe->c19_instit = $iInstituicao;
                    $oDaoContaCorrenteDetalhe->c19_reduz = $iReduzido;
                    $oDaoContaCorrenteDetalhe->c19_conplanoreduzanousu = $iAnoUsu;
                    $oDaoContaCorrenteDetalhe->c19_numcgm = $iNome;
                    break;

                case 19:  // ADIANTAMENTOS - CONCESSÃO

                    $sWhereVerificacao = "     c19_contacorrente       = {$iContaCorrente} ";
                    $sWhereVerificacao .= " and c19_instit              = {$iInstituicao}   ";
                    $sWhereVerificacao .= " and c19_reduz               = {$iReduzido}      ";
                    $sWhereVerificacao .= " and c19_conplanoreduzanousu = {$iAnoUsu}        ";
                    $sWhereVerificacao .= " and c19_numcgm              = {$iNome}          ";
                    $sWhereVerificacao .= " and c19_numemp              = {$iEmpenho}       ";
                    $sWhereVerificacao .= " and c19_orcunidadeanousu    = {$iAnoUsu}        ";
                    $sWhereVerificacao .= " and c19_orcunidadeorgao     = {$iOrgao}         ";
                    $sWhereVerificacao .= " and c19_orcunidadeunidade   = {$iUnidade}       ";
                    $sWhereVerificacao .= " and c19_orcorgaoanousu      = {$iAnoUsu}        ";
                    $sWhereVerificacao .= " and c19_orcorgaoorgao       = {$iOrgao}         ";

                    $sSqlVerificaDetalhe = $oDaoVerificaDetalhe->sql_query_file(null, "*", null, $sWhereVerificacao);
                    $rsVerificacao = $oDaoVerificaDetalhe->sql_record($sSqlVerificaDetalhe);

                    if ($oDaoVerificaDetalhe->numrows > 0) {
                        $sDescricaoContaCorrenteErro = "19 - Adiantamentos - Concessão";
                    }

                    $oDaoContaCorrenteDetalhe->c19_contacorrente = $iContaCorrente;
                    $oDaoContaCorrenteDetalhe->c19_instit = $iInstituicao;
                    $oDaoContaCorrenteDetalhe->c19_reduz = $iReduzido;
                    $oDaoContaCorrenteDetalhe->c19_conplanoreduzanousu = $iAnoUsu;
                    $oDaoContaCorrenteDetalhe->c19_numcgm = $iNome;
                    $oDaoContaCorrenteDetalhe->c19_numemp = $iEmpenho;
                    $oDaoContaCorrenteDetalhe->c19_orcunidadeanousu = $iAnoUsu;
                    $oDaoContaCorrenteDetalhe->c19_orcunidadeorgao = $iOrgao;
                    $oDaoContaCorrenteDetalhe->c19_orcunidadeunidade = $iUnidade;
                    $oDaoContaCorrenteDetalhe->c19_orcorgaoanousu = $iAnoUsu;
                    $oDaoContaCorrenteDetalhe->c19_orcorgaoorgao = $iOrgao;
                    break;

                case 25: //CONTRATOS

                    $sWhereVerificacao = "     c19_contacorrente       = {$iContaCorrente} ";
                    $sWhereVerificacao .= " and c19_instit              = {$iInstituicao}   ";
                    $sWhereVerificacao .= " and c19_reduz               = {$iReduzido}      ";
                    $sWhereVerificacao .= " and c19_conplanoreduzanousu = {$iAnoUsu}        ";
                    $sWhereVerificacao .= " and c19_numcgm              = {$iNome}          ";
                    $sWhereVerificacao .= " and c19_acordo              = {$iAcordo}        ";

                    $sSqlVerificaDetalhe = $oDaoVerificaDetalhe->sql_query_file(null, "*", null, $sWhereVerificacao);
                    $rsVerificacao = $oDaoVerificaDetalhe->sql_record($sSqlVerificaDetalhe);

                    if ($oDaoVerificaDetalhe->numrows > 0) {
                        $sDescricaoContaCorrenteErro = "25 - Contratos";
                    }

                    $oDaoContaCorrenteDetalhe->c19_contacorrente = $iContaCorrente;
                    $oDaoContaCorrenteDetalhe->c19_instit = $iInstituicao;
                    $oDaoContaCorrenteDetalhe->c19_reduz = $iReduzido;
                    $oDaoContaCorrenteDetalhe->c19_conplanoreduzanousu = $iAnoUsu;
                    $oDaoContaCorrenteDetalhe->c19_acordo = $iAcordo;
                    $oDaoContaCorrenteDetalhe->c19_numcgm = $iNome;

                    break;
                case 103:  //Fonte de Recurso

                    $sWhereVerificacao = "     c19_contacorrente       = {$iContaCorrente}    ";
                    $sWhereVerificacao .= " and c19_orctiporec          = {$iTipoReceita}      ";
                    $sWhereVerificacao .= " and c19_instit              = {$iInstituicao}      ";
                    $sWhereVerificacao .= " and c19_reduz               = {$iReduzido}         ";
                    $sWhereVerificacao .= " and c19_conplanoreduzanousu = {$iAnoUsu}           ";

                    $sSqlVerificaDetalhe = $oDaoVerificaDetalhe->sql_query_file(null, "*", null, $sWhereVerificacao);
                    $rsVerificacao = $oDaoVerificaDetalhe->sql_record($sSqlVerificaDetalhe);

                    if ($oDaoVerificaDetalhe->numrows > 0) {
                        $sDescricaoContaCorrenteErro = "103 - Fonte de Recurso";
                    }

                    $oDaoContaCorrenteDetalhe->c19_contacorrente = $iContaCorrente;
                    $oDaoContaCorrenteDetalhe->c19_orctiporec = $iTipoReceita;
                    $oDaoContaCorrenteDetalhe->c19_instit = $iInstituicao;
                    $oDaoContaCorrenteDetalhe->c19_reduz = $iReduzido;
                    $oDaoContaCorrenteDetalhe->c19_conplanoreduzanousu = $iAnoUsu;


                    break;

            }

            if ($oDaoVerificaDetalhe->numrows > 0) {

                $sMsgErro = "Conta corrente [$sDescricaoContaCorrenteErro] com detalhamento selecionado já ";
                $sMsgErro .= "incluído no sistema.\n\nProcedimento abortado.";
                throw new BusinessException($sMsgErro);
            }

            $oDaoContaCorrenteDetalhe->incluir(null);
            if ($oDaoContaCorrenteDetalhe->erro_status == 0 || $oDaoContaCorrenteDetalhe->erro_status == '0') {

                throw new DBException('ERRO - [ 1 ] - Incluindo Detalhe de Conta Corrente : ' . $oDaoContaCorrenteDetalhe->erro_msg);
            }

            $oRetorno->message = urlencode("Detalhe incluído com sucesso.");
            db_fim_transacao(false);

            break;


        /*
         * case para buscar detalhamento de uma contacorrentedetalhe
         * especifica (tela de viewdetalhes)
         */
        case "getDetalheContaCorrente" :

            $sEmpenho = "";
            $sContaBancaria = "";
            $oDaoContaCorrenteDetalhe = db_utils::getDao("contacorrentedetalhe");

            $sCamposDetalhes = "*";

            $sWhereDetalhes = "c19_sequencial = {$oParam->iDetalhe} ";

            $sSqlDetalhes = $oDaoContaCorrenteDetalhe->sql_query_viewDetalhes(null, $sCamposDetalhes, null, $sWhereDetalhes);
            $rsDetalhes = $oDaoContaCorrenteDetalhe->sql_record($sSqlDetalhes);
            $oDetalhes = db_utils::fieldsMemory($rsDetalhes, 0);

            if ($oDetalhes->c19_numemp != '') {
                $sEmpenho = $oDetalhes->e60_codemp . " / " . $oDetalhes->e60_anousu;
            }
            if ($oDetalhes->c19_contabancaria != '') {

                $sBco = $oDetalhes->db89_db_bancos;
                $sAg = $oDetalhes->db89_codagencia;
                $iDigitoAg = $oDetalhes->db89_digito;
                $sConta = $oDetalhes->db83_conta;
                $iDigitoConta = $oDetalhes->db83_dvconta;

                $sContaBancaria = "<strong>Banco:</strong> {$sBco}   ";
                $sContaBancaria .= "<strong>Agência:</strong> {$sAg} - {$iDigitoAg}    ";
                $sContaBancaria .= "<strong>Conta:</strong> {$sConta} - {$iDigitoConta} ";
            }

            $oValoresDetalhes = new stdClass();
            $oValoresDetalhes->c19_sequencial = $oDetalhes->c19_sequencial;
            $oValoresDetalhes->c17_descricao = $oDetalhes->c17_contacorrente . " - " . $oDetalhes->c17_descricao;
            $oValoresDetalhes->o15_descr = $oDetalhes->o15_descr;
            $oValoresDetalhes->nomeinst = $oDetalhes->nomeinst;
            $oValoresDetalhes->c58_descr = $oDetalhes->c58_descr;
            $oValoresDetalhes->c19_contabancaria = urlencode($sContaBancaria);
            $oValoresDetalhes->c19_reduz = $oDetalhes->c19_reduz;
            $oValoresDetalhes->c19_numemp = $sEmpenho;
            $oValoresDetalhes->z01_nome = $oDetalhes->z01_nome;
            $oValoresDetalhes->c19_orcunidadeanousu = $oDetalhes->c19_orcunidadeanousu;
            $oValoresDetalhes->c19_orcunidadeorgao = urlencode($oDetalhes->o40_descr);//$oDetalhes->c19_orcunidadeorgao     ;
            $oValoresDetalhes->c19_orcunidadeunidade = urlencode($oDetalhes->o41_descr);//$oDetalhes->c19_orcunidadeunidade   ;
            $oValoresDetalhes->c19_orcorgaoanousu = $oDetalhes->c19_orcorgaoanousu;
            $oValoresDetalhes->c19_orcorgaoorgao = urlencode($oDetalhes->o40_descr);//$oDetalhes->c19_orcorgaoorgao       ;
            $oValoresDetalhes->c19_conplanoreduzanousu = $oDetalhes->c19_conplanoreduzanousu;
            $oValoresDetalhes->c19_acordo = $oDetalhes->c19_acordo;

            $oRetorno->aDados = $oValoresDetalhes;

            break;

        /*
         * case para reprocessamento de contas correntes
         *
         */
        case "reprocessarContaCorrente" :


            /*
             * definimos as variaveis que serão utilizadas em filtros e processamento;
             */
            $iCodigoContaCorrente = $oParam->iCodigoContaCorrente;
            $iMes = $oParam->iMes;
            $dtInicial = "{$iAnoSessao}-{$iMes}-01";
            $dtFinal = "{$iAnoSessao}-{$iMes}-" . cal_days_in_month(CAL_GREGORIAN, $iMes, $iAnoSessao);
            $aDetalhamentos = $oParam->aContaCorrente;
            $oDaoConlancamVal = db_utils::getDao("conlancamval");
            $sCodigosDetalhes = "";

            if (count($aDetalhamentos) > 0) {

                $aCodigosDetalhes = array();
                foreach ($aDetalhamentos as $iIndice => $oValores) {
                    $aCodigosDetalhes[] = $oValores->sCodigo;
                }
                $sCodigosDetalhes = implode(", ", $aCodigosDetalhes);
            }
            $sCamposConlancamVal = "c19_sequencial, ";
            $sCamposConlancamVal .= "c69_data,       ";
            $sCamposConlancamVal .= "c69_sequen,     ";
            $sCamposConlancamVal .= "c19_reduz,      ";
            $sCamposConlancamVal .= "c69_codlan      ";

            $sWhereConlancamVal = " c19_contacorrente = {$iCodigoContaCorrente} ";
            /*
             * se houver lista de contas detalhes, incluimos no in do where
             */
            if ($sCodigosDetalhes != "") {

                $sWhereConlancamVal .= " and  c19_sequencial in ($sCodigosDetalhes) ";
            }
            /*
             * verificamos se foi selecionado um intervalo de datas para incluir no where
             */
            $sWhereConlancamVal .= " and c69_data between '{$dtInicial}' and '{$dtFinal}' ";

            $sSqlConlancamVal = $oDaoConlancamVal->sql_query_contacorrentedetalhe(null, $sCamposConlancamVal, null, $sWhereConlancamVal);
            $rsConlancamVal = $oDaoConlancamVal->sql_record($sSqlConlancamVal);
            $iTotalRegistros = $oDaoConlancamVal->numrows;

            if ($iTotalRegistros == 0) {
                throw new BusinessException('Não foram encontrados vínculos entre a conta corrente e seus lançamentos contábeis.');
            }


            db_inicio_transacao();

            /**
             * Excluímos o saldo no período informado para conseguirmos reprocessar
             */
            for ($iExcluirRegistro = 0; $iExcluirRegistro < $iTotalRegistros; $iExcluirRegistro++) {

                $oDadosConLancamVal = db_utils::fieldsMemory($rsConlancamVal, $iExcluirRegistro);
                $oDaoContaCorrenteSaldo = db_utils::getDao('contacorrentesaldo');
                $sWhereExcluirSaldo = "     c29_anousu = {$iAnoSessao}";
                $sWhereExcluirSaldo .= " and c29_mesusu = {$iMes}";
                $sWhereExcluirSaldo .= " and c29_contacorrentedetalhe = {$oDadosConLancamVal->c19_sequencial}";
                $oDaoContaCorrenteSaldo->excluir(null, $sWhereExcluirSaldo);
                if ($oDaoContaCorrenteSaldo->erro_status == '0') {
                    throw new DBException('ERRO [1] - Excluir saldo conta corrente.');
                }
                unset($oDaoContaCorrenteSaldo);
            }

            /**
             * Atualizamos os valores
             */
            for ($iRegistro = 0; $iRegistro < $iTotalRegistros; $iRegistro++) {

                $oDadosConLancamVal = db_utils::fieldsMemory($rsConlancamVal, $iRegistro);
                $iSequencialDetalhe = $oDadosConLancamVal->c19_sequencial;
                $iSequencialConlancam = $oDadosConLancamVal->c69_codlan;
                $iSequencialConlancamVal = $oDadosConLancamVal->c69_sequen;
                $dtConLancamVal = $oDadosConLancamVal->c69_data;
                $iReduzido = $oDadosConLancamVal->c19_reduz;

                $oLancamentoAuxiliar = new LancamentoAuxiliarContaCorrente($iSequencialConlancam);

                $oContaDetalhamento = ContaCorrenteFactory::getInstance($iSequencialConlancamVal,
                    $iReduzido,
                    $oLancamentoAuxiliar);

                if ($oContaDetalhamento) {
                    $oContaDetalhamento->reprocessarSaldo($iSequencialDetalhe, $dtConLancamVal);
                }
            }

            db_fim_transacao(false);

            $oRetorno->message = "Reprocessamento de conta corrente realizado com sucesso.";


            break;


        /*
         * case para implantação de saldo em conta corrente
         * sera implantado com mesusu 0 e para o anousu
         */
        /**
         * @description:
         * Funcionalidade adaptada para a geração do SICOM Balancete
         * Descrição da alteração:
         * 1. Quando o sTipoImplantacao for crédito e o nValor for negativo, devemos implantar na contacorrentesaldo como débito, se não será crédito.
         * 2. Quando o sTipoImplantacao for débito e o nValor for negativo, devemos implantar na contacorrentesaldo como crédito, se não será débito.
         * @author: rodrigo@contass e igor@contass
         */
        case "implantarSaldoContaCorrente" :


            $iCodigoReduzido = $oParam->iCodigoReduzido;
            $sTipoImplantacao = $oParam->sTipoImplantacao;
            $sColunaImplantar = "c29_credito";
            $sColunaZerar = "c29_debito";
            $iAnoUsu = db_getsession("DB_anousu");
            $aValores = $oParam->aValores;

            if ($sTipoImplantacao == 'debito') {

                $sColunaImplantar = "c29_debito";
                $sColunaZerar = "c29_credito";
            }

            db_inicio_transacao();

            foreach ($aValores as $iIndiceValores => $oValores) {

                /**
                 * Remove os registros existentes na contacorrentesaldo para o ano atual e mes 0 do contacorrentedetalhe em questao
                 */
                $oDaoContaCorrenteSaldo = new cl_contacorrentesaldo();
                $sWhereExcluir = "c29_anousu = {$iAnoUsu} and c29_mesusu = 0 and c29_contacorrentedetalhe = {$oValores->iSequencial}";
                $oDaoContaCorrenteSaldo->excluir(null, $sWhereExcluir);

                if ($oDaoContaCorrenteSaldo->erro_status == "0") {
                    throw new DBException("ERRO [ 1 ] - Excluindo Registros - " . $oDaoContaCorrenteSaldo->erro_msg);
                }

                if ($oValores->nValor == 0) {
                    continue;
                }

                if ($sTipoImplantacao == 'debito') {

                    if ($oValores->nValor < 0) {

                        $sColunaImplantar = "c29_credito";
                        $sColunaZerar = "c29_debito";

                    } else {
                        $sColunaImplantar = "c29_debito";
                        $sColunaZerar = "c29_credito";
                    }

                } elseif ($sTipoImplantacao == 'credito') {

                    if ($oValores->nValor < 0) {

                        $sColunaImplantar = "c29_debito";
                        $sColunaZerar = "c29_credito";

                    } else {
                        $sColunaImplantar = "c29_credito";
                        $sColunaZerar = "c29_debito";
                    }
                }

                /*
                 * modificação para reajustar valores, basicamente devemos verificar se
                 * ja foi feita implantação na contacorrentesaldo pelo detalhe em questão
                 * se retornar registro, para o detalhe, ano e mes = 0, significa que devemos altera-lo
                 * se não retornar significa que é a primeira vez que está sendo implantado e logo devemos incluir registro na
                 * contacorrentesaldo
                 */
                $sWhereImplantacao = "     c29_contacorrentedetalhe = {$oValores->iSequencial} ";
                $sWhereImplantacao .= " and c29_anousu = {$iAnoUsu} ";
                $sWhereImplantacao .= " and c29_mesusu = 0 ";
                $sSqlImplantcao = $oDaoContaCorrenteSaldo->sql_query_file(null, "*", null, $sWhereImplantacao);
                $rsImplantacao = $oDaoContaCorrenteSaldo->sql_record($sSqlImplantcao);

                $oDaoContaCorrenteSaldo->c29_contacorrentedetalhe = $oValores->iSequencial;
                $oDaoContaCorrenteSaldo->c29_anousu = $iAnoUsu;
                $oDaoContaCorrenteSaldo->c29_mesusu = '0';
                $oDaoContaCorrenteSaldo->$sColunaImplantar = abs($oValores->nValor);
                $oDaoContaCorrenteSaldo->$sColunaZerar = '0';

                // se retornou registros devemos alterar
                if ($oDaoContaCorrenteSaldo->numrows > 0) {

                    $oValoresInplantados = db_utils::fieldsMemory($rsImplantacao, 0);

                    $oDaoContaCorrenteSaldo->c29_sequencial = $oValoresInplantados->c29_sequencial;
                    $oDaoContaCorrenteSaldo->alterar($oDaoContaCorrenteSaldo->c29_sequencial);

                } else { // senao, incluimos

                    $oDaoContaCorrenteSaldo->incluir(null);
                }


                if ($oDaoContaCorrenteSaldo->erro_status == "0") {
                    throw new DBException("ERRO [ 2 ] - Atualizando Registros - " . $oDaoContaCorrenteSaldo->erro_msg);
                }

            }

            db_fim_transacao(false);

            $oRetorno->message = "Procedimento realizado com sucesso.";

            break;


        /*
         * case para trazer o detalhamento da conta a partir do reduzido
         * para a rotina de implantação de saldo:
         *
         * Contabilidade > Procedimento > Utilitarios da Contabilidade > Conta Corrente > Implantação de Saldo
         *
         */
        case "getDetalhamento" :

            /*
             * Tabelas envolvidas:
             *
             * conplanoreduz
             * conplanoexe
             * contacorrentedetalhe
             */
            $iAnoUsu = db_getsession("DB_anousu");
            $iReduzido = $oParam->iCodigoReduzido;
            $aDetalhesContas = array();

            $sWhereConplanoExe = "     c62_anousu = {$iAnoUsu}   ";
            $sWhereConplanoExe .= " and c62_reduz  = {$iReduzido} ";

            $sCamposConplanoExe = " c62_vlrcre , ";
            $sCamposConplanoExe .= " c62_vlrdeb   ";

            // primeiro buscamos o saldo a credito ou a debito do reduzido na conplanoexe
            $oDaoConplanoExe = db_utils::getDao("conplanoexe");
            $sSqlConplanoExe = $oDaoConplanoExe->sql_query(null, null, $sCamposConplanoExe, null, $sWhereConplanoExe);
            $rsConplanoExe = $oDaoConplanoExe->sql_record($sSqlConplanoExe);
            $oValoresConplanoExe = db_utils::fieldsMemory($rsConplanoExe, 0);

            if ($oValoresConplanoExe->c62_vlrcre > 0 && $oValoresConplanoExe->c62_vlrdeb > 0) {

                $sErroMessage = "ERRO [ 1 ] - Conta sem saldo a ser distribuído.";
                throw new BusinessException($sErroMessage);
            }
            if ($oValoresConplanoExe->c62_vlrcre <= 0 && $oValoresConplanoExe->c62_vlrdeb <= 0) {

                $sErroMessage = "ERRO [ 2 ] - Conta sem saldo a ser distribuído.";
                throw new BusinessException($sErroMessage);
            }

            /*
             * buscamos os detalhes das contas pelo estrutural
             * deve retornar as contas que ainda não foram incluidas na
             * contacorrentesaldo com o mes 0 - implantacao
             */
            $oDaoContaCorrenteDetalhe = db_utils::getDao("contacorrentedetalhe");
            /*
             * Busca o contacorrente do reduzido
             *
             */
            $sSqlContaCorrente = " SELECT distinct c18_contacorrente,substr(c60_estrut,1,4) as c60_estrut
								FROM conplanocontacorrente
								INNER JOIN conplano ON conplano.c60_codcon = conplanocontacorrente.c18_codcon
								AND conplanocontacorrente.c18_anousu = conplano.c60_anousu
								INNER JOIN conplanoreduz ON conplanoreduz.c61_codcon = conplano.c60_codcon
								AND conplanoreduz.c61_anousu = conplano.c60_anousu
								INNER JOIN contacorrente ON contacorrente.c17_sequencial = conplanocontacorrente.c18_contacorrente
								WHERE c61_reduz = {$iReduzido}
								  AND c18_anousu = " . db_getsession('DB_anousu') . "
								  AND c60_anousu = " . db_getsession('DB_anousu') . "
								  AND c61_anousu = " . db_getsession('DB_anousu') . "
								  AND c61_instit = " . db_getsession('DB_instit') . "
								 limit 1";
            $iCorrente = db_utils::fieldsMemory(db_query($sSqlContaCorrente), 0)->c18_contacorrente;
            $sEstrutural = db_utils::fieldsMemory(db_query($sSqlContaCorrente), 0)->c60_estrut;
            $sCamposDetalhe = "distinct           ";
            $sCamposDetalhe .= "c19_sequencial,    ";
            $sCamposDetalhe .= "c17_sequencial,    ";
            $sCamposDetalhe .= "c17_contacorrente, ";
            $sCamposDetalhe .= "c17_descricao,     ";
            $sCamposDetalhe .= "o15_descr,         ";  // CC1 - Disponibilidade Financeira
            $sCamposDetalhe .= "db89_db_bancos,    ";
            $sCamposDetalhe .= "db89_codagencia,   ";
            $sCamposDetalhe .= "db89_digito,       ";
            $sCamposDetalhe .= "db83_conta,        ";
            $sCamposDetalhe .= "db83_dvconta,      "; // CC2 - Domicilio Bancario
            $sCamposDetalhe .= "cgm.z01_nome,      ";
            $sCamposDetalhe .= "c58_descr,         ";
            $sCamposDetalhe .= "c19_programa,       "; //CC 101
            $sCamposDetalhe .= "c19_projativ       "; //CC 101
            $iTroca = 0;
            switch ($iCorrente) {
                case 106:
                    db_inicio_transacao();
                    //echo $sEstrutural;exit;

                    if ($sEstrutural == "5312" || $sEstrutural == "5322" || $sEstrutural == "6311" || $sEstrutural == "6321" || $sEstrutural == "5317"
                        || $sEstrutural == "5327" || $sEstrutural == "6327" || $sEstrutural == "6317" || $sEstrutural == "6313") {
                        $iTroca = 1;
                        $iAnousuEmp = db_getsession('DB_anousu') - 1;
                        $nMes = 12;
                        /**
                         * 5312,5312,6311,6321 - restos dos exercícios anteriores (anteriores a $iAnousuEmp)
                         */
                        if (in_array($sEstrutural, array("5322", "5312", "6311","6321"))) {

                            $sSqlLancamentos = "
                                select distinct c19_sequencial,
                                                    c17_descricao,
                                                    e60_numemp,
                                                    e60_codemp,
                                                    e60_anousu,
                                                    c19_estrutural,
                                                    c19_orcdotacao,
                                                    c19_orcdotacaoanousu
                                 from contacorrentedetalhe
                                            inner join contacorrente on c19_contacorrente = c17_sequencial
                                            inner join empempenho on e60_numemp = c19_numemp
                                            inner join empelemento on e64_numemp = e60_numemp
                                            inner join empresto on e91_numemp = e60_numemp
                                where c19_contacorrente = {$iCorrente}
                                    and c19_reduz = {$iReduzido} and c19_conplanoreduzanousu = {$iAnousuEmp} and e60_anousu < {$iAnousuEmp}
                                    and c19_instit = " . db_getsession('DB_instit');

                            $rsLancamentos = db_query($sSqlLancamentos);
                            //Busca a movimentação dos empenhos quando não há encerramento ou movimentação de abertura em exercicios anteriores
                            if(pg_num_rows($rsLancamentos) == 0){
                                $sSqlLancamentos = "select
                                                DISTINCT
                                                'RESTOS A PAGAR' as c17_descricao,
                                                e60_numemp,
                                                e60_codemp,
                                                e60_anousu,
                                                o56_elemento as c19_estrutural,
                                                e60_coddot as c19_orcdotacao,
                                                e60_anousu as c19_orcdotacaoanousu
                                                from empresto
                                                inner join empempenho on e60_numemp = e91_numemp
                                                inner join empelemento on e60_numemp  = e64_numemp
                                                inner join orcelemento on e64_codele = o56_codele and o56_anousu = e60_anousu
                                                where e60_anousu < {$iAnousuEmp}
                                                ";
                                $rsLancamentos = db_query($sSqlLancamentos);
                            }

                        }

                        /**
                         * 5317,5327,6317,6327 -  restos do exercício (ano = $iAnousuEmp)
                         */
                        if(in_array($sEstrutural, array("5317", "5327", "6317", "6327"))){
                            $sSqlLancamentos = "
                                select distinct c19_sequencial,
                                                    c17_descricao,
                                                    e60_numemp,
                                                    e60_codemp,
                                                    e60_anousu,
                                                    c19_estrutural,
                                                    c19_orcdotacao,
                                                    c19_orcdotacaoanousu
                                 from contacorrentedetalhe
                                            inner join contacorrente on c19_contacorrente = c17_sequencial
                                            inner join empempenho on e60_numemp = c19_numemp
                                            inner join empelemento on e64_numemp = e60_numemp
                                            inner join empresto on e91_numemp = e60_numemp
                                where c19_contacorrente = {$iCorrente}
                                    and c19_reduz = {$iReduzido} and c19_conplanoreduzanousu = {$iAnousuEmp} and e60_anousu = {$iAnousuEmp}
                                    and c19_instit = " . db_getsession('DB_instit');

                            $rsLancamentos = db_query($sSqlLancamentos);
                            //Busca a movimentação dos empenhos quando não há encerramento ou movimentação de abertura em exercicios anteriores
                            if(pg_num_rows($rsLancamentos) == 0){
                                $sSqlLancamentos = "select
                                                DISTINCT
                                                'RESTOS A PAGAR' as c17_descricao,
                                                e60_numemp,
                                                e60_codemp,
                                                e60_anousu,
                                                o56_elemento as c19_estrutural,
                                                e60_coddot as c19_orcdotacao,
                                                e60_anousu as c19_orcdotacaoanousu
                                                from empresto
                                                inner join empempenho on e60_numemp = e91_numemp
                                                inner join empelemento on e60_numemp  = e64_numemp
                                                left join orcelemento on e64_codele = o56_codele and o56_anousu = e60_anousu
                                                where e60_anousu = {$iAnousuEmp}
                                                ";
                                $rsLancamentos = db_query($sSqlLancamentos);
                            }
                        }
                        $aLancamento = db_utils::getColectionByRecord($rsLancamentos);
                        $aDadosAgrupados = array();
                        foreach ($aLancamento as $oLancamentos) {

                            $sSqlReg14saldos = " SELECT
                                      (SELECT round(coalesce(saldoimplantado,0) + coalesce(debitoatual,0) - coalesce(creditoatual,0),2) AS saldoinicial
                                       FROM
                                         (SELECT
                                            (SELECT distinct CASE WHEN c29_debito > 0 THEN c29_debito WHEN c29_credito > 0 THEN -1 * c29_credito ELSE 0 END AS saldoanterior
                                             FROM contacorrente
                                             INNER JOIN contacorrentedetalhe ON contacorrente.c17_sequencial = contacorrentedetalhe.c19_contacorrente
                                             INNER JOIN contacorrentesaldo ON contacorrentesaldo.c29_contacorrentedetalhe = contacorrentedetalhe.c19_sequencial
                                             AND contacorrentesaldo.c29_mesusu = 0 and contacorrentesaldo.c29_anousu = {$iAnousuEmp}
                                             WHERE c19_reduz = {$iReduzido}
                                               AND c19_conplanoreduzanousu =  $iAnousuEmp
                                               AND c17_sequencial = {$iCorrente}
                                               AND c19_numemp = {$oLancamentos->e60_numemp}) AS saldoimplantado,

                                            (SELECT sum(c69_valor) AS debito
                                             FROM conlancamval
                                       INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                       AND conlancam.c70_anousu = conlancamval.c69_anousu
                                       INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                       INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                       INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                       INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                       WHERE c28_tipo = 'D'
                                         AND DATE_PART('MONTH',c69_data) < " . $nMes . "
                                         AND DATE_PART('YEAR',c69_data) = {$iAnousuEmp}
                                         AND c19_contacorrente = {$iCorrente}
                                         AND c19_reduz = {$iReduzido}
                                         AND c19_conplanoreduzanousu =  $iAnousuEmp
                                         AND c19_instit = " . db_getsession("DB_instit") . "
                                         AND c19_numemp = {$oLancamentos->e60_numemp}
                                         AND conhistdoc.c53_tipo not in (1000)
                                       GROUP BY c28_tipo) AS debitoatual,

                                            (SELECT sum(c69_valor) AS credito
                                             FROM conlancamval
                                       INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                       AND conlancam.c70_anousu = conlancamval.c69_anousu
                                       INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                       INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                       INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                       INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                       WHERE c28_tipo = 'C'
                                         AND DATE_PART('MONTH',c69_data) < " . $nMes . "
                                         AND DATE_PART('YEAR',c69_data) = {$iAnousuEmp}
                                         AND c19_contacorrente = {$iCorrente}
                                         AND c19_reduz = {$iReduzido}
                                         AND c19_conplanoreduzanousu =  $iAnousuEmp
                                         AND c19_instit = " . db_getsession("DB_instit") . "
                                         AND c19_numemp = {$oLancamentos->e60_numemp}
                                         AND conhistdoc.c53_tipo not in (1000)
                                       GROUP BY c28_tipo) AS creditoatual) AS movi) AS saldoanterior,

                                      (SELECT sum(c69_valor)
                                       FROM conlancamval
                                       INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                       AND conlancam.c70_anousu = conlancamval.c69_anousu
                                       INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                       INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                       INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                       INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                       WHERE c28_tipo = 'C'
                                         AND DATE_PART('MONTH',c69_data) = " . $nMes . "
                                         AND DATE_PART('YEAR',c69_data) = {$iAnousuEmp}
                                         AND c19_contacorrente = {$iCorrente}
                                         AND c19_reduz = {$iReduzido}
                                         AND c19_conplanoreduzanousu =  $iAnousuEmp
                                         AND c19_instit = " . db_getsession("DB_instit") . "
                                         AND c19_numemp = {$oLancamentos->e60_numemp}
                                         AND conhistdoc.c53_tipo not in (1000)
                                       GROUP BY c28_tipo) AS creditos,

                                      (SELECT sum(c69_valor)
                                       FROM conlancamval
                                       INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                       AND conlancam.c70_anousu = conlancamval.c69_anousu
                                       INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                       INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                       INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                       INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                       WHERE c28_tipo = 'D'
                                         AND DATE_PART('MONTH',c69_data) = " . $nMes . "
                                         AND DATE_PART('YEAR',c69_data) = {$iAnousuEmp}
                                         AND c19_contacorrente = {$iCorrente}
                                         AND c19_reduz = {$iReduzido}
                                         AND c19_conplanoreduzanousu =  $iAnousuEmp
                                         AND c19_instit = " . db_getsession("DB_instit") . "
                                         AND c19_numemp = {$oLancamentos->e60_numemp}
                                         AND conhistdoc.c53_tipo not in (1000)
                                       GROUP BY c28_tipo) AS debitos";

                            $sSqlReg14saldos .= ",(SELECT sum(c69_valor)
                                           FROM conlancamval
                                           INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                           AND conlancam.c70_anousu = conlancamval.c69_anousu
                                           INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                           INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                           INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                           INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                           WHERE c28_tipo = 'C'
                                             AND DATE_PART('MONTH',c69_data) = " . $nMes . "
                                             AND DATE_PART('YEAR',c69_data) = {$iAnousuEmp}
                                             AND c19_contacorrente = {$iCorrente}
                                             AND c19_reduz = {$iReduzido}
                                             AND c19_conplanoreduzanousu =  $iAnousuEmp
                                             AND c19_instit = " . db_getsession("DB_instit") . "
                                             AND c19_numemp = {$oLancamentos->e60_numemp}
                                             AND conhistdoc.c53_tipo in (1000)
                                           GROUP BY c28_tipo) AS creditosEncerramento,

                                          (SELECT sum(c69_valor)
                                           FROM conlancamval
                                           INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                           AND conlancam.c70_anousu = conlancamval.c69_anousu
                                           INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                           INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                           INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                           INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                           WHERE c28_tipo = 'D'
                                             AND DATE_PART('MONTH',c69_data) = " . $nMes . "
                                             AND DATE_PART('YEAR',c69_data) = {$iAnousuEmp}
                                             AND c19_contacorrente = {$iCorrente}
                                             AND c19_reduz = {$iReduzido}
                                             AND c19_conplanoreduzanousu =  $iAnousuEmp
                                             AND c19_instit = " . db_getsession("DB_instit") . "
                                             AND c19_numemp = {$oLancamentos->e60_numemp}
                                             AND conhistdoc.c53_tipo in (1000)
                                           GROUP BY c28_tipo) AS debitosEncerramento";

                            $saldoanterior = db_utils::fieldsMemory(db_query($sSqlReg14saldos), 0)->saldoanterior;
                            $creditos = db_utils::fieldsMemory(db_query($sSqlReg14saldos), 0)->creditos;
                            $debitos = db_utils::fieldsMemory(db_query($sSqlReg14saldos), 0)->debitos;
                            $creditosencerramento = db_utils::fieldsMemory(db_query($sSqlReg14saldos), 0)->creditosencerramento;
                            $debitosencerramento = db_utils::fieldsMemory(db_query($sSqlReg14saldos), 0)->debitosencerramento;

                            $nSaldoInicial = $saldoanterior + $debitos - $creditos;
                            $nSaldoFinal = $nSaldoInicial + $debitosencerramento - $creditosencerramento;//saldo a ser implantado

                            /**
                             * Caso o saldo a implantar seja zero, busca-se o saldo do empenho
                             *  RP PROCESSADO EXERCICIO ATUAL							RP NAO PROCESSADO EXERCICIO ATUAL
                             *  5321 - 5327												5311 - 5317
                             *  6327 - 6321												63171 - 6311
                             *
                             *  RP PROCESSADO EXERCICIO ANTERIOR						RP NAO PROCESSADO EXERCICIOS ANTERIORES
                             *  5322 - 5327												5312 - 5317
                             *  6327 - 6321												63171 - 6311
                             */

                            if ($nSaldoFinal == 0 || $iAnoSessao > 2016) {
                                $oDaoEmpresto = db_utils::getDao("empempenho");

                                /*
                                 * Processados
                                 * se não
                                 * Não processados
                                 */
                                if ($sEstrutural == "5321" || $sEstrutural == "5327" || $sEstrutural == "6327" || $sEstrutural == "6321" || $sEstrutural == "5322" ) {
                                    $sSqlEmpresto = $oDaoEmpresto->sql_query_saldo_abertura_rp($iAnousuEmp,$oLancamentos->e60_numemp);
                                    $rsSqlEmpresto = $oDaoEmpresto->sql_record($sSqlEmpresto);
//
                                    $nSaldoFinal = db_utils::fieldsMemory($rsSqlEmpresto,0)->valor_processado;

                                } else {
                                    $sSqlEmpresto = $oDaoEmpresto->sql_query_saldo_abertura_rp($iAnousuEmp, $oLancamentos->e60_numemp);
                                    $rsSqlEmpresto = $oDaoEmpresto->sql_record($sSqlEmpresto);
                                    $nSaldoFinal = db_utils::fieldsMemory($rsSqlEmpresto,0)->valor_nao_processado;
                                }

                            }

                            $iContaCorrenteDetalhe = 0;
                            $oDaoCCDetalhe = db_utils::getDao("contacorrentedetalhe");
                            $sWhereCCDetalhe  = " c19_conplanoreduzanousu = " . db_getsession("DB_anousu") . " and c19_reduz = {$iReduzido} ";
                            $sWhereCCDetalhe .= " and c19_contacorrente = {$iCorrente} and c19_numemp = {$oLancamentos->e60_numemp} ";
                            $sSqlCCDetalhe = $oDaoCCDetalhe->sql_query_file(null, " c19_sequencial ",null, $sWhereCCDetalhe);

                            $rsCCDetalhe = $oDaoCCDetalhe->sql_record($sSqlCCDetalhe);
                            $iContaCorrenteDetalhe = db_utils::fieldsMemory($rsCCDetalhe, 0)->c19_sequencial;

                            //verifica se existe ccdetalhe para o anouso se não existir cria um novo.
                            if( ($iContaCorrenteDetalhe == null || $iContaCorrenteDetalhe == '0')   ){

                                //$oDaoCCDetalhe->c19_sequencial          =;
                                $oDaoCCDetalhe->c19_contacorrente       = $iCorrente;
                                $oDaoCCDetalhe->c19_instit              = db_getsession("DB_instit");
                                $oDaoCCDetalhe->c19_reduz               = $iReduzido;
                                $oDaoCCDetalhe->c19_numemp              = $oLancamentos->e60_numemp;
                                $oDaoCCDetalhe->c19_conplanoreduzanousu = db_getsession("DB_anousu");
                                $oDaoCCDetalhe->c19_estrutural          = $oLancamentos->c19_estrutural;
                                $oDaoCCDetalhe->c19_orcdotacao          = $oLancamentos->c19_orcdotacao;
                                $oDaoCCDetalhe->c19_orcdotacaoanousu    = $oLancamentos->c19_orcdotacaoanousu;

                                $oDaoCCDetalhe->incluir(null);
                                if ($oDaoCCDetalhe->erro_status == 0 || $oDaoCCDetalhe->erro_status == '0') {
                                    throw new DBException('ERRO - [ 1 ] - Incluindo Detalhe de Conta Corrente : ' . $oDaoCCDetalhe->erro_msg);
                                }

                                $oDaoCCDetalhe = db_utils::getDao("contacorrentedetalhe");
                                $sWhereCCDetalhe  = " c19_conplanoreduzanousu = " . db_getsession("DB_anousu") . " and c19_reduz = {$iReduzido} ";
                                $sWhereCCDetalhe .= " and c19_contacorrente = {$iCorrente} and c19_numemp = {$oLancamentos->e60_numemp} ";
                                $sSqlCCDetalhe = $oDaoCCDetalhe->sql_query_file(null, " c19_sequencial ",null, $sWhereCCDetalhe);
                                $rsCCDetalhe = $oDaoCCDetalhe->sql_record($sSqlCCDetalhe);
                                $iContaCorrenteDetalhe = db_utils::fieldsMemory($rsCCDetalhe, 0)->c19_sequencial;

                            }

                            $hash = $iContaCorrenteDetalhe;

                            if (!isset($aDadosAgrupados[$hash])) {

                                $oMovimento = new stdClass();

                                $oMovimento->c19_sequencial = $iContaCorrenteDetalhe;
                                $oMovimento->c17_descricao = $oLancamentos->c17_descricao;
                                $oMovimento->e60_codemp = $oLancamentos->e60_codemp;
                                $oMovimento->e60_anousu = $oLancamentos->e60_anousu;
                                $oMovimento->c69_valor = abs($nSaldoFinal);

                                $aDadosAgrupados[$hash] = $oMovimento;
                            }

                        }
                        //echo "<pre>";print_r($aDadosAgrupados);exit;
                        db_query('drop table if exists omov; create table omov ( c19_sequencial integer, c17_sequencial integer, c17_contacorrente varchar,c17_descricao varchar, e60_codemp bigint, e60_anousu integer, c69_valor float);') or die(pg_last_error());
                        foreach ($aDadosAgrupados as $oMov) {
                            if($oMov->c69_valor > 0)
                              db_query("insert into omov values ({$oMov->c19_sequencial},106,'CC 106','{$oMov->c17_descricao}',{$oMov->e60_codemp},{$oMov->e60_anousu}, {$oMov->c69_valor});") or die(pg_last_error());
                        }

                    } else {
                        $sCamposDetalhe .= ",sum(c69_valor) c69_valor, ";
                        $sCamposDetalhe .= "e60_codemp,        ";
                        $sCamposDetalhe .= "e60_anousu         ";
                        $iAnousuEmp = db_getsession('DB_anousu');
                        $sWhereDetalhes = "c19_reduz = {$iReduzido} and c69_anousu = {$iAnousuEmp} and e60_anousu < {$iAnousuEmp} and c19_conplanoreduzanousu = " . db_getsession('DB_anousu') . " group by c19_sequencial,
								c17_sequencial,
								c17_contacorrente,
								c17_descricao,
								o15_descr,
								db89_db_bancos,
								db89_codagencia,
								db89_digito,
								db83_conta,
								db83_dvconta,
								cgm.z01_nome,
								c58_descr,
								e60_codemp,
								e60_anousu ";
                    }
                    db_fim_transacao(false);
                    break;

                case 103:

                    $iTroca = 1;
                    $iAnousuEmp = db_getsession('DB_anousu') - 1;
                    $nMes = 12;

                    /*
                     * Busca tas as fontes de recurso.
                     * Aqui temos os dois SQL para buscar os dados no ano atual. Caso nao encontre, busca no ano anterior e duplica para o ano atual.
                     * */

                    $sSqlfr = " SELECT DISTINCT
                                c19_sequencial,
                                c17_descricao,
                                o15_codigo,
                                o15_descr,
                                o15_codtri
                                FROM orctiporec
                                INNER JOIN contacorrentedetalhe ON c19_orctiporec = o15_codigo
                                       and c19_contacorrente = {$iCorrente} and c19_reduz = {$iReduzido}
                                       and c19_conplanoreduzanousu = ".db_getsession('DB_anousu')."
                                INNER JOIN contacorrente on c19_contacorrente = c17_sequencial
                                WHERE o15_codtri IS NOT NULL ";

                    $sSqlfr .= " union SELECT DISTINCT
                            c19_sequencial,
                            c17_descricao,
                            o15_codigo,
                            o15_descr,
                            o15_codtri
                            FROM orctiporec
                            INNER JOIN contacorrentedetalhe ON c19_orctiporec = o15_codigo
                                   and c19_contacorrente = {$iCorrente} and c19_reduz = {$iReduzido}
                                   and c19_conplanoreduzanousu = {$iAnousuEmp}
                            INNER JOIN contacorrente on c19_contacorrente = c17_sequencial
                            WHERE o15_codtri IS NOT NULL ";
                    $rsSqlfr = db_query($sSqlfr) or die($sSqlfr);


                    $aDadosAgrupados = array();

                    for ($iContfr = 0; $iContfr < pg_num_rows($rsSqlfr); $iContfr++) {

                        $objContasfr = db_utils::fieldsMemory($rsSqlfr, $iContfr);

                        $sSqlReg18saldos = " SELECT
                                          (SELECT round(coalesce(saldoimplantado,0) + coalesce(debitoatual,0) - coalesce(creditoatual,0),2) AS saldoinicial
                                           FROM
                                             (SELECT
                                                (SELECT SUM(saldoanterior) AS saldoanterior FROM
                                                    (SELECT CASE WHEN c29_debito > 0 THEN c29_debito WHEN c29_credito > 0 THEN -1 * c29_credito ELSE 0 END AS saldoanterior
                                                     FROM contacorrente
                                                     INNER JOIN contacorrentedetalhe ON contacorrente.c17_sequencial = contacorrentedetalhe.c19_contacorrente
                                                     INNER JOIN contacorrentesaldo ON contacorrentesaldo.c29_contacorrentedetalhe = contacorrentedetalhe.c19_sequencial
                                                     AND contacorrentesaldo.c29_mesusu = 0 and contacorrentesaldo.c29_anousu = {$iAnousuEmp}
                                                     WHERE c19_reduz = {$iReduzido}

                                                       AND c19_orctiporec = {$objContasfr->o15_codigo}) as x) AS saldoimplantado,

                                                (SELECT sum(c69_valor) AS debito
                                                 FROM conlancamval
                                                   INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                                   AND conlancam.c70_anousu = conlancamval.c69_anousu
                                                   INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                                   INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                                   INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                                   INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                                   WHERE c28_tipo = 'D'
                                                     AND DATE_PART('MONTH',c69_data) < " . $nMes . "
                                                     AND DATE_PART('YEAR',c69_data) = {$iAnousuEmp}
                                                     AND c19_contacorrente = {$iCorrente}
                                                     AND c19_reduz = {$iReduzido}
                                                     AND c19_orctiporec = {$objContasfr->o15_codigo}
                                                     AND conhistdoc.c53_tipo not in (1000)
                                                   GROUP BY c28_tipo) AS debitoatual,

                                                (SELECT sum(c69_valor) AS credito
                                                 FROM conlancamval
                                                   INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                                   AND conlancam.c70_anousu = conlancamval.c69_anousu
                                                   INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                                   INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                                   INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                                   INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                                   WHERE c28_tipo = 'C'
                                                     AND DATE_PART('MONTH',c69_data) < " . $nMes . "
                                                     AND DATE_PART('YEAR',c69_data) = {$iAnousuEmp}
                                                     AND c19_contacorrente = {$iCorrente}
                                                     AND c19_reduz = {$iReduzido}
                                                     AND c19_orctiporec = {$objContasfr->o15_codigo}
                                                     AND conhistdoc.c53_tipo not in (1000)
                                                   GROUP BY c28_tipo) AS creditoatual) AS movi) AS saldoanterior,

                                          (SELECT sum(c69_valor)
                                           FROM conlancamval
                                           INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                           AND conlancam.c70_anousu = conlancamval.c69_anousu
                                           INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                           INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                           INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                           INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                           WHERE c28_tipo = 'C'
                                             AND DATE_PART('MONTH',c69_data) = " . $nMes . "
                                             AND DATE_PART('YEAR',c69_data) = {$iAnousuEmp}
                                             AND c19_contacorrente = {$iCorrente}
                                             AND c19_reduz = {$iReduzido}
                                             AND c19_orctiporec = {$objContasfr->o15_codigo}
                                             AND conhistdoc.c53_tipo not in (1000)
                                           GROUP BY c28_tipo) AS creditos,

                                          (SELECT sum(c69_valor)
                                           FROM conlancamval
                                           INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                           AND conlancam.c70_anousu = conlancamval.c69_anousu
                                           INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                           INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                           INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                           INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                           WHERE c28_tipo = 'D'
                                             AND DATE_PART('MONTH',c69_data) = " . $nMes . "
                                             AND DATE_PART('YEAR',c69_data) = {$iAnousuEmp}
                                             AND c19_contacorrente = {$iCorrente}
                                             AND c19_reduz = {$iReduzido}
                                             AND c19_orctiporec = {$objContasfr->o15_codigo}
                                             AND conhistdoc.c53_tipo not in (1000)
                                           GROUP BY c28_tipo) AS debitos";

                        $sSqlReg18saldos .= ",(SELECT sum(c69_valor)
                                           FROM conlancamval
                                           INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                           AND conlancam.c70_anousu = conlancamval.c69_anousu
                                           INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                           INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                           INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                           INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                           WHERE c28_tipo = 'C'
                                             AND DATE_PART('MONTH',c69_data) = " . $nMes . "
                                             AND DATE_PART('YEAR',c69_data) = {$iAnousuEmp}
                                             AND c19_contacorrente = {$iCorrente}
                                             AND c19_reduz = {$iReduzido}
                                             AND c19_orctiporec = {$objContasfr->o15_codigo}
                                             AND conhistdoc.c53_tipo in (1000)
                                           GROUP BY c28_tipo) AS creditosEncerramento,

                                          (SELECT sum(c69_valor)
                                           FROM conlancamval
                                           INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                           AND conlancam.c70_anousu = conlancamval.c69_anousu
                                           INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                           INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                           INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                           INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                           WHERE c28_tipo = 'D'
                                             AND DATE_PART('MONTH',c69_data) = " . $nMes . "
                                             AND DATE_PART('YEAR',c69_data) = {$iAnousuEmp}
                                             AND c19_contacorrente = {$iCorrente}
                                             AND c19_reduz = {$iReduzido}
                                             AND c19_orctiporec = {$objContasfr->o15_codigo}
                                             AND conhistdoc.c53_tipo in (1000)
                                           GROUP BY c28_tipo) AS debitosEncerramento";

                        $saldoanterior = db_utils::fieldsMemory(db_query($sSqlReg18saldos), 0)->saldoanterior;
                        $creditos = db_utils::fieldsMemory(db_query($sSqlReg18saldos), 0)->creditos;
                        $debitos = db_utils::fieldsMemory(db_query($sSqlReg18saldos), 0)->debitos;
                        $creditosencerramento = db_utils::fieldsMemory(db_query($sSqlReg18saldos), 0)->creditosencerramento;
                        $debitosencerramento = db_utils::fieldsMemory(db_query($sSqlReg18saldos), 0)->debitosencerramento;

                        $nSaldoInicial = $saldoanterior + $debitos - $creditos;
                        $nSaldoFinal = $nSaldoInicial + $debitosencerramento - $creditosencerramento;//saldo a ser implantado

                        $iContaCorrenteDetalhe = 0;
                        $oDaoCCDetalhe = db_utils::getDao("contacorrentedetalhe");
                        $sWhereCCDetalhe  = " c19_conplanoreduzanousu = " . db_getsession("DB_anousu") . " and c19_reduz = {$iReduzido} ";
                        $sWhereCCDetalhe .= " and c19_contacorrente = {$iCorrente} and c19_orctiporec = {$objContasfr->o15_codigo} ";
                        $sSqlCCDetalhe = $oDaoCCDetalhe->sql_query_file(null, " c19_sequencial ",null, $sWhereCCDetalhe);

                        $rsCCDetalhe = $oDaoCCDetalhe->sql_record($sSqlCCDetalhe);
                        $iContaCorrenteDetalhe = db_utils::fieldsMemory($rsCCDetalhe, 0)->c19_sequencial;

                        //verifica se existe ccdetalhe para o anouso se não existir cria um novo. Se não, usa oq eu foi buscado.
                        if($iContaCorrenteDetalhe == null || $iContaCorrenteDetalhe == '0'){

                            $oDaoCCDetalhe->c19_contacorrente       = $iCorrente;
                            $oDaoCCDetalhe->c19_instit              = db_getsession("DB_instit");
                            $oDaoCCDetalhe->c19_reduz               = $iReduzido;
                            $oDaoCCDetalhe->c19_conplanoreduzanousu = db_getsession("DB_anousu");
                            $oDaoCCDetalhe->c19_orctiporec          = $objContasfr->o15_codigo;

                            $oDaoCCDetalhe->incluir(null);
                            if ($oDaoCCDetalhe->erro_status == 0 || $oDaoCCDetalhe->erro_status == '0') {
                                throw new DBException('ERRO - [ 1 ] - Incluindo Detalhe de Conta Corrente : ' . $oDaoCCDetalhe->erro_msg);
                            }

                            $objContasfr->c19_sequencial = $oDaoCCDetalhe->c19_sequencial;
                        }else{
                            $objContasfr->c19_sequencial = $iContaCorrenteDetalhe;
                        }

                        $hash = $objContasfr->o15_codigo;

                        if (!isset($aDadosAgrupados[$hash])) {

                            $oMovimento = new stdClass();

                            $oMovimento->c19_sequencial = $objContasfr->c19_sequencial;
                            $oMovimento->c17_descricao = $objContasfr->c17_descricao;
                            $oMovimento->o15_codtri = $objContasfr->o15_codtri;
                            $oMovimento->o15_descr = $objContasfr->o15_descr;
                            $oMovimento->c69_valor = number_format($nSaldoFinal,2,'.','');

                            $aDadosAgrupados[$hash] = $oMovimento;
                        }

                    }

                    db_query('drop table if exists omov; create table omov ( c19_sequencial integer, c17_sequencial integer, c17_contacorrente varchar,c17_descricao varchar, o15_codtri varchar, o15_descr varchar, c69_valor float);') or die(pg_last_error());
                    foreach ($aDadosAgrupados as $oMov) {
                        db_query("insert into omov values ({$oMov->c19_sequencial},103,'CC 103','{$oMov->c17_descricao}','{$oMov->o15_codtri}','{$oMov->o15_descr}', {$oMov->c69_valor});") or die(pg_last_error());
                    }

                    break;
                default:

                    /**
                     * Importação dos dados para implantação do saldo do cc
                     * Esta funcionalidade é para as contas do CC 101 que não tiveram movimentação em períodos anteriores,
                     * mas que necessitam de implantar saldo.
                     *
                     * Funcionamento:
                     * 1. Quando a conta já possui movimentações em anos anterioes, o fluxo segue pelo getDetalhamento
                     * normalmente, porém, o parametro iImportar é diferente de 1. Assim busca a movimentação normal do
                     * CC Detalhe.
                     * 2. Quando não existe movimentações em anos anteriores, é possível realizar a importação das
                     * informações do SICOM Balancete Encerramento do exercício anterior ao da implantação do saldo.
                     * Para que seja possível realizar essa importação, antes é preciso fazer a importação do arquivo
                     * do Sicom Balancete Encerramento na área TCEMG, módulo Sicom, menu Procedimentos->Importar Sicom.
                     * 3. No processamento da rotina, é criado os contacorrente detalhes de cada registro importado
                     * no detalhamento 13.
                     * 4. É exibido na tela os CC criados para implantação do saldo.
                     *
                     */
                    if($oParam->iImportar == 1){
                        db_inicio_transacao();
                        /*
                         * Cria a tabela auxiliar que irá armezenar os dados que serão listados na tela
                         */
                        db_query('drop table if exists omov; create table omov ( c19_sequencial integer, c17_sequencial integer, c17_contacorrente varchar,c17_descricao varchar, c19_programa varchar, c19_projativ varchar, c69_valor float);') or die(pg_last_error());
                        /*
                         * Obtem a conta pelo reduzido
                         */
                        $oContaContabil = new ContaPlanoPCASP(null,db_getsession('DB_anousu'),$oParam->iCodigoReduzido,db_getsession('DB_instit'));

                        /**
                         * Busca os dados importados atraves do conta
                         *
                         */
                        $sNomeClasse = 'cl_balancete13'.($iAnoUsu-1);
                        $oBalancete13 = new $sNomeClasse;
                        $sWhere = "si180_mes = ".$oBalancete13::PERIODO_ENCERRAMENTO." and si180_instit = ".db_getsession('DB_instit')." and si180_contacontabil = '".str_replace('.','',$oContaContabil->getEstruturaAteNivel($oContaContabil->getEstruturalComMascara(),7))."'";
                        $oDadosImportados = db_utils::getCollectionByRecord($oBalancete13->sql_record($oBalancete13->sql_query_file(null,"distinct si180_codprograma,si180_idacao,case when si180_naturezasaldofinaipa = 'C' then si180_saldofinaipa*-1 else si180_saldofinaipa end as si180_saldofinaipa",null,$sWhere)));
                        if(count($oDadosImportados) == 0){
                            $sMsgErro = "Não foram encontradas informações sobre o balancete de encerramento do sicom do exercicio anterior. Por favor, faça a importação em: TCE->SICOM->Procedimentos->Importar SICOM.";
                            throw new BusinessException($sMsgErro);
                        }
                        /*
                         * Como não existe os dados da dotação e é uma chave obrigatória para o cc 101, utiliza-se a primeira dotação do ano
                         */
                        $oDotacao = new cl_orcdotacao();
                        $sWhereDotacao = " o58_instit = " . db_getsession('DB_instit') . " and o58_anousu = " . db_getsession('DB_anousu') . " order by 1 limit 1 ";
                        $oDadosDotacao = db_utils::getCollectionByRecord($oDotacao->sql_record($oDotacao->sql_query_file(null, null, "o58_coddot,o58_anousu", null, $sWhereDotacao)));
                        $oDotacao = new Dotacao($oDadosDotacao[0]->o58_coddot,$oDadosDotacao[0]->o58_anousu);
                        foreach ($oDadosImportados as $oDadoImportado) {

                            try {

                                /*
                                 * Cria o contacorrente detalhe para ser exibido na tela
                                 */

                                $oContaCorreteDetalhe = new cl_contacorrentedetalhe();

                                $oContaCorreteDetalhe->c19_contacorrente = $oContaContabil->getContaCorrente()->getCodigo();
                                $oContaCorreteDetalhe->c19_orctiporec = $oContaContabil->getRecurso();
                                $oContaCorreteDetalhe->c19_instit = db_getsession('DB_instit');
                                $oContaCorreteDetalhe->c19_reduz = $oContaContabil->getReduzido();
                                $oContaCorreteDetalhe->c19_conplanoreduzanousu = $oContaContabil->getAno();
                                $oContaCorreteDetalhe->c19_estrutural = $oDotacao->getElemento();
                                $oContaCorreteDetalhe->c19_orcdotacao = $oDotacao->getCodigo();
                                $oContaCorreteDetalhe->c19_orcdotacaoanousu = $oDotacao->getAno();
                                $oContaCorreteDetalhe->c19_programa = $oDadoImportado->si180_codprograma;
                                $oContaCorreteDetalhe->c19_projativ = $oDadoImportado->si180_idacao;

                                /*
                                 * Verifica se existe contacorrentedetalhe para não duplicar a importação
                                 */
                                $sSqlDelete = " select c19_sequencial from
                                                    contacorrentedetalhe
                                                    where c19_programa = '{$oContaCorreteDetalhe->c19_programa}'
                                                    and c19_projativ = '{$oContaCorreteDetalhe->c19_projativ}'
                                                    and c19_orcdotacao = {$oContaCorreteDetalhe->c19_orcdotacao}
                                                    and c19_orcdotacaoanousu = {$oContaCorreteDetalhe->c19_orcdotacaoanousu}
                                                    and c19_estrutural = '{$oContaCorreteDetalhe->c19_estrutural}'
                                                    and c19_conplanoreduzanousu = '{$oContaCorreteDetalhe->c19_conplanoreduzanousu}'
                                                    and c19_reduz = {$oContaCorreteDetalhe->c19_reduz}
                                                    and c19_instit = {$oContaCorreteDetalhe->c19_instit}
                                                    and c19_orctiporec = {$oContaCorreteDetalhe->c19_orctiporec}
                                                    and c19_contacorrente = {$oContaCorreteDetalhe->c19_contacorrente}
                                                    ";
                                if(pg_num_rows(db_query($sSqlDelete)) > 0 ){
                                    $sSqlDeleteSaldo = "delete from contacorrentesaldo where c29_contacorrentedetalhe = ".db_utils::fieldsMemory(db_query($sSqlDelete),0)->c19_sequencial." and c29_mesusu = 0 and c29_anousu = ".db_getsession('DB_anousu');
                                    $sSqlDelete = " delete from
                                                    contacorrentedetalhe
                                                    where c19_programa = '{$oContaCorreteDetalhe->c19_programa}'
                                                    and c19_projativ = '{$oContaCorreteDetalhe->c19_projativ}'
                                                    and c19_orcdotacao = {$oContaCorreteDetalhe->c19_orcdotacao}
                                                    and c19_orcdotacaoanousu = {$oContaCorreteDetalhe->c19_orcdotacaoanousu}
                                                    and c19_estrutural = '{$oContaCorreteDetalhe->c19_estrutural}'
                                                    and c19_conplanoreduzanousu = '{$oContaCorreteDetalhe->c19_conplanoreduzanousu}'
                                                    and c19_reduz = {$oContaCorreteDetalhe->c19_reduz}
                                                    and c19_instit = {$oContaCorreteDetalhe->c19_instit}
                                                    and c19_orctiporec = {$oContaCorreteDetalhe->c19_orctiporec}
                                                    and c19_contacorrente = {$oContaCorreteDetalhe->c19_contacorrente}
                                                    ";
                                    db_query($sSqlDeleteSaldo) or die(pg_last_error());
                                    db_query($sSqlDelete) or die(pg_last_error());
                                }

                                $oContaCorreteDetalhe->incluir(null);

                                /*
                                 * Povoa a tabela auxiliar que armazena os dados que serão exibidos na tela
                                 */
                                db_query("insert into omov values ({$oContaCorreteDetalhe->c19_sequencial},{$oContaCorreteDetalhe->c19_contacorrente},'CC {$oContaCorreteDetalhe->c19_contacorrente}','{$oContaContabil->getContaCorrente()->getDescricao()}','{$oContaCorreteDetalhe->c19_programa}','{$oContaCorreteDetalhe->c19_projativ}', {$oDadoImportado->si180_saldofinaipa})") or die(pg_last_error());

                            }catch (Exception $ex){
                                throw new Exception($ex->getMessage());
                            }
                        }
                        db_fim_transacao(false);
                        $iTroca = 1;
                    }
                    $sWhereDetalhes = "c19_reduz = {$iReduzido}";
            }

            $sSqlDetalhe = $iTroca == 0 ? $oDaoContaCorrenteDetalhe->sql_query_fileAtributos(null, $sCamposDetalhe, null, $sWhereDetalhes."order by 1") : "select * from omov order by 1";
            $rsDetalhes = $oDaoContaCorrenteDetalhe->sql_record($sSqlDetalhe);

            if ($oDaoContaCorrenteDetalhe->numrows > 0) {

                $sDescricao = "";

                for ($iDetalhe = 0; $iDetalhe < $oDaoContaCorrenteDetalhe->numrows; $iDetalhe++) {

                    $oValores = db_utils::fieldsMemory($rsDetalhes, $iDetalhe);
                    $oDadosDetalhes = new stdClass();
                    $oDadosDetalhes->nValorImplantado = 0;
                    $oDadosDetalhes->nValor = 0;

                    switch ($oValores->c17_sequencial) {

                        case 1: //  1 | CC 1    | DISPONIBILIDADE FINANCEIRA
                            $sDescricao = $oValores->o15_descr . " - " . $oValores->c58_descr;
                            break;

                        case 2: //  2 | CC 2    | DOMICÍLIO BANCÁRIO

                            $sBco = $oValores->db89_db_bancos;
                            $sAg = $oValores->db89_codagencia;
                            $iDigitoAg = $oValores->db89_digito;
                            $sConta = $oValores->db83_conta;
                            $iDigitoConta = $oValores->db83_dvconta;

                            $sDescricao = "<strong>Banco:</strong> {$sBco}  ";
                            $sDescricao .= "<strong>Agência:</strong> {$sAg} - {$iDigitoAg}  ";
                            $sDescricao .= "<strong>Conta:</strong> {$sConta} - {$iDigitoConta} ";
                            break;

                        case 3: //  3 | CC 3    | CREDOR/FORNECEDOR/DEVEDOR
                            $sDescricao = $oValores->z01_nome;
                            break;

                        case 19: // 19 | CC 19   | ADIANTAMENTOS - CONCESSÃO
                            $sDescricao = $oValores->z01_nome;
                            break;

                        case 25: // 25 | CC 25   | CONTRATOS
                            $sDescricao = $oValores->z01_nome;
                            break;
                        case 103:
                            $sDescricao = "Fonte: " . $oValores->o15_codtri . " - " . $oValores->o15_descr;
                            $oDadosDetalhes->nValor = $oValores->c69_valor;
                            break;
                        case 106:
                            $sDescricao = "Empenho: " . $oValores->e60_codemp . "/" . $oValores->e60_anousu;
                            $oDadosDetalhes->nValor = $oValores->c69_valor;
                            break;
                        case 101:
                            $sDescricao = "Programa: $oValores->c19_programa - Ação: $oValores->c19_projativ";
                            $oDadosDetalhes->nValor = empty($oValores->c69_valor) ? 0 : $oValores->c69_valor;
                            break;
                        default:
                            $sDescricao = $oValores->o15_descr;
                            $oDadosDetalhes->nValor = empty($oValores->c69_valor) ? 0 : $oValores->c69_valor;

                    }
                    // setamoso sequencial dos detalhes e a descrição que irá na grid
                    $oDadosDetalhes->iCodigo = $oValores->c19_sequencial;
                    $oDadosDetalhes->sConta = urlencode($sDescricao);


                    /*
                     * sql para verificar se existe valor ja implantado
                     */
                    $oDaoContaCorrenteSaldo = db_utils::getDao("contacorrentesaldo");

                    $sWhereImplantacao = "     c29_contacorrentedetalhe = {$oValores->c19_sequencial} ";
                    $sWhereImplantacao .= " and c29_anousu = {$iAnoUsu} ";
                    $sWhereImplantacao .= " and c29_mesusu = 0 ";
                    $sSqlValorImplantado = $oDaoContaCorrenteSaldo->sql_query_file(null, "*", null, $sWhereImplantacao);
                    $rsImplantado = $oDaoContaCorrenteSaldo->sql_record($sSqlValorImplantado);

                    // se existir valor ja implantado, setamos eles no objeto que irá retornar
                    if ($oDaoContaCorrenteSaldo->numrows > 0) {
                        /**
                         * @description:
                         * se o saldo da conta for credito e o saldo implantado no cc for debito, então o valor deve ser negativado.
                         * se o saldo da conta for debito e o saldo implantado no cc for credito, então o valor deve ser negativado.
                         */
                        $oValorInplantado = db_utils::fieldsMemory($rsImplantado, 0);

                        $oDadosDetalhes->nValorImplantado = $oValorInplantado->c29_credito;

                        if ($oValorInplantado->c29_credito == 0 || $oValorInplantado->c29_credito == null) {
                            if ($oValoresConplanoExe->c62_vlrcre > 0) {
                                $oDadosDetalhes->nValorImplantado = $oValorInplantado->c29_debito * -1;
                            } else {
                                $oDadosDetalhes->nValorImplantado = $oValorInplantado->c29_debito;
                            }

                        } else {
                            if ($oValoresConplanoExe->c62_vlrdeb > 0) {
                                $oDadosDetalhes->nValorImplantado = $oValorInplantado->c29_credito * -1;
                            }
                        }

                    }

                    // adicionamos o objeto com os atributos que irão para tela em array
                    $aDetalhesContas[] = $oDadosDetalhes;
                }
                $oRetorno->iCodigoDescricao = $oValores->c17_sequencial;
                $oRetorno->sDescricaoContaCorrente = $oValores->c17_contacorrente . " - " . urlencode($oValores->c17_descricao);

            } else {

                $oPlanoContaPCASP = new ContaPlanoPCASP(null,
                    db_getsession('DB_anousu'),
                    $iReduzido,
                    db_getsession("DB_instit"));

                if (!$oPlanoContaPCASP->getContaCorrente() instanceof ContaCorrente) {

                    $sDescricaoConta = $oPlanoContaPCASP->getDescricao();
                    $sMsgErro = "A conta {$iReduzido} - {$sDescricaoConta} não está vinculada a nenhuma conta ";
                    $sMsgErro .= "corrente.\n\nVerifique o cadastro.";
                    throw new BusinessException(urlencode($sMsgErro));
                }

                $sDescricaoContaCorrente = "{$oPlanoContaPCASP->getContaCorrente()->getContaCorrente()} - ";
                $sDescricaoContaCorrente .= $oPlanoContaPCASP->getDescricao();

                $oRetorno->iCodigoDescricao = $oPlanoContaPCASP->getContaCorrente()->getCodigo();
                $oRetorno->sDescricaoContaCorrente = urlencode($sDescricaoContaCorrente);
            }


            $oRetorno->nSaldoCredito = trim($oValoresConplanoExe->c62_vlrcre);
            $oRetorno->nSaldoDebito = trim($oValoresConplanoExe->c62_vlrdeb);
            $oRetorno->aDados = $aDetalhesContas;

            break;

        case "salvarVinculo":

            db_inicio_transacao();
            $oContaCorrente = new ContaCorrente($oParam->iCodigoContaCorrente);
            $oContaCorrente->vincularContasContabeisPorEstrutural($oParam->sEstrutural);
            $oRetorno->message = urlencode("Contas vinculadas com sucesso.");
            db_fim_transacao(false);
            break;

        case "getContasVinculadas":

            $oContaCorrente = new ContaCorrente($oParam->iCodigoContaCorrente);
            $aContasContabeis = $oContaCorrente->getContasContabeis();
            $aContasRetorno = array();
            foreach ($aContasContabeis as $iIndice => $oContaPCASP) {

                $oStdContaRetorno = new stdClass();
                $oStdContaRetorno->iCodigoConta = $oContaPCASP->getCodigoConta();
                $oStdContaRetorno->sEstrutural = $oContaPCASP->getEstrutural();
                $oStdContaRetorno->sDescricao = urlencode($oContaPCASP->getDescricao());
                $aContasRetorno[] = $oStdContaRetorno;
            }

            $oRetorno->aContas = $aContasRetorno;
            break;

        case "excluirVinculo":

            db_inicio_transacao();
            $oContaCorrente = new ContaCorrente($oParam->iCodigoContaCorrente);
            foreach ($oParam->aContas as $iCodigoConta) {
                $oContaCorrente->excluirVinculoComConta($iCodigoConta);
            }
            db_fim_transacao(false);
            $oRetorno->message = urlencode("Vínculo excluído com sucesso.");
            break;
    }

} catch (Exception $eException) {

    $oRetorno->message = urlencode($eException->getMessage());
    $oRetorno->status = 2;
    db_fim_transacao(true);

} catch (BusinessException $eBException) {

    $oRetorno->message = urlencode($eBException->getMessage());
    $oRetorno->status = 2;
    db_fim_transacao(true);

} catch (DBException $eDBException) {

    $oRetorno->message = urlencode($eDBException->getMessage());
    $oRetorno->status = 2;
    db_fim_transacao(true);
} catch (ParameterException $eParameterException) {

    $oRetorno->message = urlencode($eParameterException->getMessage());
    $oRetorno->status = 2;
    db_fim_transacao(true);
}

echo json_encode($oRetorno);
?>
