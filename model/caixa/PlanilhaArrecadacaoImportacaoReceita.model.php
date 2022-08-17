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
require_once('model/caixa/PlanilhaArrecadacaoImportacaoReceitaLayout2.model.php');

/**
 * Factory que retorna a instancia da classe Planilha de Arrecadacao Importacao Receita Layouts
 * @package caixa
 * @author widouglas
 */
class PlanilhaArrecadacaoImportacaoReceita
{
    private $sProcessoAdministrativo;
    private $iLayout;
    private $iNumeroCgm;
    private $oPlanilhaArrecadacao;

    public function __construct($sProcessoAdministrativo, $iLayout)
    {
        $this->preencherProcessoAdministrativo($sProcessoAdministrativo);
        $this->iLayout = $iLayout;
        $this->preencherPlanilhaArrecadacao();
        $this->preencherCGM();
    }

    public function preencherProcessoAdministrativo($sProcessoAdministrativo)
    {
        if (strlen($sProcessoAdministrativo) >= 99)
            throw new BusinessException("Nome do arquivo não pode ter mais que 100 caracteres \n Nome Atual: {$sProcessoAdministrativo}");
        $this->sProcessoAdministrativo = $sProcessoAdministrativo;
    }

    /**
     * Preencher a abertura da planilha de arrecadação
     *
     * @return void
     */
    public function preencherPlanilhaArrecadacao()
    {
        $this->oPlanilhaArrecadacao = new PlanilhaArrecadacao();
        $this->oPlanilhaArrecadacao->setDataCriacao(date('Y-m-d', db_getsession('DB_datausu')));
        $this->oPlanilhaArrecadacao->setInstituicao(InstituicaoRepository::getInstituicaoByCodigo(db_getsession('DB_instit')));
        $this->oPlanilhaArrecadacao->setProcessoAdministrativo($this->sProcessoAdministrativo);
    }

    /**
     * Buscar dados da institução da sessão
     *
     * @return void
     */
    public function preencherCGM()
    {
        $oDaoDBConfig = db_utils::getDao("db_config");
        $rsInstit = $oDaoDBConfig->sql_record($oDaoDBConfig->sql_query_file(db_getsession("DB_instit")));
        $this->iNumeroCgm = db_utils::fieldsMemory($rsInstit, 0)->numcgm;
    }

    /**
     * Recebe o array e importa na planilha de receitas
     *
     * @param array $aArquivoImportar
     * @return void
     */
    public function salvarPlanilhaReceita($aArquivoImportar)
    {
        try {
            db_inicio_transacao();
            foreach ($aArquivoImportar as $iPosicao => $sLinha) {
                $oReceita = $this->preencherLayout($this->iLayout, $sLinha);

                montarDebug($oReceita);

                $iInscricao        = "";
                $iMatricula        = "";
                $sObservacao       = "";
                $sOperacaoBancaria = "";
                $iOrigem           = 1; // 1 - CGM
                $iEmParlamentar    = 3;

                $oReceitaPlanilha = new ReceitaPlanilha();
                $oReceitaPlanilha->setCaracteristicaPeculiar(new CaracteristicaPeculiar("000"));
                $oReceitaPlanilha->setCGM(CgmFactory::getInstanceByCgm($this->iNumeroCgm));
                $oReceitaPlanilha->setContaTesouraria($oReceita->oContaTesouraria);
                $oReceitaPlanilha->setDataRecebimento(new DBDate($oReceita->dDataCredito));
                $oReceitaPlanilha->setInscricao($iInscricao);
                $oReceitaPlanilha->setMatricula($iMatricula);
                $oReceitaPlanilha->setObservacao(db_stdClass::normalizeStringJsonEscapeString($sObservacao));
                $oReceitaPlanilha->setOperacaoBancaria($sOperacaoBancaria);
                $oReceitaPlanilha->setOrigem($iOrigem);
                $oReceitaPlanilha->setRecurso(new Recurso($oReceita->iRecurso));
                $oReceitaPlanilha->setRegularizacaoRepasse("");
                $oReceitaPlanilha->setRegExercicio("");
                $oReceitaPlanilha->setEmendaParlamentar($iEmParlamentar);
                $oReceitaPlanilha->setTipoReceita($oReceita->iReceita);
                $oReceitaPlanilha->setValor($oReceita->nValor);
                $oReceitaPlanilha->setConvenio("");
                $this->oPlanilhaArrecadacao->adicionarReceitaPlanilha($oReceitaPlanilha);
            }

            $this->oPlanilhaArrecadacao->salvar();
            db_msgbox("Planilha {$this->oPlanilhaArrecadacao->getCodigo()} inclusa com sucesso.\n\n");
            db_fim_transacao(false);
        } catch (Exception $oException) {
            db_fim_transacao(true);
            db_msgbox($oException->getMessage());
        }
    }

    /**
     * Recebe a linha e passa na classe de preenchimento conforme o layout e devolve um objeto preenchido
     *
     * @param int $iLayout
     * @param string $sLinha
     * @return object
     */
    public function preencherLayout($iLayout, $sLinha)
    {
        $sClassName = "PlanilhaArrecadacaoImportacaoReceitaLayout{$iLayout}";

        if (!class_exists($sClassName)) 
            throw new BusinessException("Layout selecionado é inválido");
        
        $oImportacao = new $sClassName($sLinha);
        return $oImportacao->recuperarLinha();
    }
}
