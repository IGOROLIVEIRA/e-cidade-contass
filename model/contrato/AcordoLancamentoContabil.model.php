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
 * Classificao do arcordo
 *
 * @package Contrato
 */
class AcordoLancamentoContabil
{
    public function __construct()
    {

    }

    public function registraControleContrato($oContrato, $nValorAnular, $aItens)
    {
        try{
            if(db_getsession('DB_anousu') < 2022){
                return;
            }
            $iAnoUsu = db_getsession('DB_anousu');
            $oDataImplantacao = new DBDate(date("Y-m-d", db_getsession('DB_datausu')));
            $oInstituicao     = InstituicaoRepository::getInstituicaoByCodigo(db_getsession('DB_instit'));
            if (ParametroIntegracaoPatrimonial::possuiIntegracaoContrato($oDataImplantacao, $oInstituicao)) {

                $iCodigoAcordo         = $oContrato->e100_acordo;
                $oAcordo               = new Acordo($iCodigoAcordo);
                $oEventoContabilAcordo = new EventoContabil(900, $iAnoUsu);

                $oLancamentoAuxiliarAcordo = new LancamentoAuxiliarAcordo();
                $oLancamentoAuxiliarAcordo->setAcordo($oAcordo);
                // TODO PEGAR VALOR DO LANÇAMENTO.
                $oLancamentoAuxiliarAcordo->setValorTotal();
                $oLancamentoAuxiliarAcordo->setDocumento($oEventoContabilAcordo->getCodigoDocumento());

                $oContaCorrente = new ContaCorrenteDetalhe();
                $oContaCorrente->setAcordo($oAcordo);
                $oLancamentoAuxiliarAcordo->setContaCorrenteDetalhe($oContaCorrente);
                $oEventoContabilAcordo->executaLancamento($oLancamentoAuxiliarAcordo);
            }
        } catch (Exception $eErro) {
            $this->lSqlErro = true;
            $this->sErroMsg = "({$eErro->getMessage()})";
        }
    }

    public function anulaRegistroControleContrato($nValorAnular, $aItens)
    {
        if(db_getsession("DB_anousu") < 2022){
            return false;
        }
        /**
         * Lancamentos do contrato
         * - busca empenho do contrato
         */
        $oDataImplantacao = new DBDate(date("Y-m-d", db_getsession('DB_datausu')));
        $oInstituicao     = new Instituicao(db_getsession('DB_instit'));
        $iAnoUsu = db_getsession('DB_anousu');
        $oEmpenhoFinanceiro = new EmpenhoFinanceiro($this->numemp);

        $oDaoAcordo = db_utils::getDao('acordo');

        $sql = $oDaoAcordo->sql_query_lancamentos_empenhocontrato("c71_coddoc", $this->numemp);

        $result = db_query($sql);

        $aDocumentos = array();

        for ($iCont=0; $iCont < pg_num_rows($result); $iCont++) {
            $aDocumentos[] =  db_utils::fieldsMemory($result,$iCont)->c71_coddoc;
        }

        $acordoLancamento = true;

        if (!in_array(900,$aDocumentos)) {
            $acordoLancamento = false;
        }

        if ((USE_PCASP && ParametroIntegracaoPatrimonial::possuiIntegracaoContrato($oDataImplantacao, $oInstituicao)) && $acordoLancamento == true) {

            $oDaoEmpenhoContrato = db_utils::getDao("empempenhocontrato");
            $sSqlContrato        = $oDaoEmpenhoContrato->sql_query_file(null,
                "e100_acordo",
                null,
                "e100_numemp = {$this->numemp}"
            );

            $rsContrato  = $oDaoEmpenhoContrato->sql_record($sSqlContrato);
            if (!$this->lSqlErro && $oDaoEmpenhoContrato->numrows > 0) {

                try {

                    $oAcordo = new Acordo(db_utils::fieldsMemory($rsContrato, 0)->e100_acordo);
                    $oEventoContabilAcordo = new EventoContabil(903, $iAnoUsu);
                    $oLancamentoAuxiliarAcordo = new LancamentoAuxiliarAcordo();
                    $oLancamentoAuxiliarAcordo->setEmpenho($oEmpenhoFinanceiro);
                    $oLancamentoAuxiliarAcordo->setAcordo($oAcordo);
                    $oLancamentoAuxiliarAcordo->setValorTotal(round($nValorAnular, 2));

                    $oContaCorrenteDetalhe = new ContaCorrenteDetalhe();
                    $oContaCorrenteDetalhe->setAcordo($oAcordo);
                    $oContaCorrenteDetalhe->setEmpenho($oEmpenhoFinanceiro);
                    $oLancamentoAuxiliarAcordo->setContaCorrenteDetalhe($oContaCorrenteDetalhe);
                    $oLancamentoAuxiliarAcordo->setDocumento($oEventoContabilAcordo->getCodigoDocumento());

                    $oEventoContabilAcordo->executaLancamento($oLancamentoAuxiliarAcordo);

                    /**
                     * Incluir novamente saldo da quantidade autorizada do acordo
                     */
                    $oDaoEmpempAut   = db_utils::getDao("empempaut");
                    $rsDaoEmpempAut  = $oDaoEmpempAut->sql_record($oDaoEmpempAut->sql_query_file($this->numemp,"distinct e61_autori as autori"));
                    if ($oDaoEmpempAut->numrows > 0){
                        $oDaoEmpempitem  = db_utils::getDao("empempitem");
                        $aItensAcordo = array();
                        foreach ($aItens as $oItem) {
                        $rsEmpempItem = $oDaoEmpempitem->sql_record($oDaoEmpempitem->sql_query_file(null,null,"e62_item",null,"e62_sequencial = {$oItem->e62_sequencial}"));
                        $iCodMaterial = db_utils::fieldsmemory($rsEmpempItem, 0)->e62_item;
                        $aItensAcordo[$iCodMaterial] = clone($oItem);
                        $aItensAcordo[$iCodMaterial]->pc01_codmater = $iCodMaterial;
                        }
                        $oAcordo->anularAutorizacao(db_utils::fieldsMemory($rsDaoEmpempAut,0)->autori, $aItensAcordo);

                    }
                } catch (Exception $eErro) {

                $this->lSqlErro = true;
                $this->sErroMsg = "({$eErro->getMessage()})";
                }
            }
        }
    }
}
