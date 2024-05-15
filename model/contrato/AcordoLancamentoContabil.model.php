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
// ini_set('display_errors', 'On');
// error_reporting(E_ALL);
require_once "libs/db_app.utils.php";
require_once("model/Acordo.model.php");
require_once("model/configuracao/Instituicao.model.php");
require_once("model/contabilidade/contacorrente/ContaCorrenteFactory.model.php");
require_once("model/contabilidade/contacorrente/ContaCorrenteBase.model.php");
db_app::import("Acordo");
db_app::import("contabilidade.*");
db_app::import("contabilidade.lancamento.*");
/**
 * Lançamento contabil do arcordo
 *
 * @package Contrato
 */
class AcordoLancamentoContabil
{

    public function __construct()
    {

    }

    /**
     * Registra lançamento contabil movimentação contrato
     *
     * @param  integer $iCodigoAcordo
     * @param  float $nValorLancamento
     * @param  string $sHistorico
     * @param  DBDate $oDataLancamento
     * @return Resource
     */
    public function registraControleContrato($iCodigoAcordo, $nValorLancamento, $sHistorico, $datoDataLancamentoLancamento)
    {
        if(db_getsession('DB_anousu') < 2022){
            return;
        }
        $iAnoUsu = db_getsession('DB_anousu');
        $oDataImplantacao = new DBDate(date("Y-m-d", db_getsession('DB_datausu')));
        $oInstituicao     = InstituicaoRepository::getInstituicaoByCodigo(db_getsession('DB_instit'));
        if (!ParametroIntegracaoPatrimonial::possuiIntegracaoContrato($oDataImplantacao, $oInstituicao)) {
            return null;
        }
        $oAcordo               = new Acordo($iCodigoAcordo);
        $oEventoContabilAcordo = new EventoContabil(900, $iAnoUsu);

        $oLancamentoAuxiliarAcordoHomologacao = new LancamentoAuxiliarAcordoMovimentacao();
        $oLancamentoAuxiliarAcordoHomologacao->setAcordo($oAcordo);
        $oLancamentoAuxiliarAcordoHomologacao->setValorTotal($nValorLancamento);
        $oLancamentoAuxiliarAcordoHomologacao->setObservacaoHistorico($sHistorico);
        $oLancamentoAuxiliarAcordoHomologacao->setDocumento($oEventoContabilAcordo->getCodigoDocumento());

        $oContaCorrente = new ContaCorrenteDetalhe();
        $oContaCorrente->setAcordo($oAcordo);
        $oLancamentoAuxiliarAcordoHomologacao->setContaCorrenteDetalhe($oContaCorrente);
        return $oEventoContabilAcordo->executaLancamento($oLancamentoAuxiliarAcordoHomologacao, $datoDataLancamentoLancamento);

    }

    /**
     * Registra lançamento contabil movimentação contrato
     *
     * @param  integer $iCodigoAcordo
     * @param  float $nValorLancamento
     * @param  string $sHistorico
     * @param  DBDate $oDataLancamento
     * @return Resource
     */
    public function anulaRegistroControleContrato($iCodigoAcordo, $nValorLancamento, $sHistorico, $datoDataLancamentoLancamento)
    {
        if(db_getsession("DB_anousu") < 2022){
            return;
        }
        $iAnoUsu = db_getsession('DB_anousu');
        $oDataImplantacao = new DBDate(date("Y-m-d", db_getsession('DB_datausu')));
        $oInstituicao     = InstituicaoRepository::getInstituicaoByCodigo(db_getsession('DB_instit'));
        if (!ParametroIntegracaoPatrimonial::possuiIntegracaoContrato($oDataImplantacao, $oInstituicao)) {
            return null;
        }
        $oAcordo               = new Acordo($iCodigoAcordo);
        $oEventoContabilAcordo = new EventoContabil(903, $iAnoUsu);
        $oLancamentoAuxiliarAcordoHomologacao = new LancamentoAuxiliarAcordoMovimentacao();
        $oLancamentoAuxiliarAcordoHomologacao->setAcordo($oAcordo);
        $oLancamentoAuxiliarAcordoHomologacao->setValorTotal($nValorLancamento);
        $oLancamentoAuxiliarAcordoHomologacao->setObservacaoHistorico($sHistorico);
        $oLancamentoAuxiliarAcordoHomologacao->setDocumento($oEventoContabilAcordo->getCodigoDocumento());

        $oContaCorrente = new ContaCorrenteDetalhe();
        $oContaCorrente->setAcordo($oAcordo);
        $oLancamentoAuxiliarAcordoHomologacao->setContaCorrenteDetalhe($oContaCorrente);
        return $oEventoContabilAcordo->executaLancamento($oLancamentoAuxiliarAcordoHomologacao, $datoDataLancamentoLancamento);
    }
}
