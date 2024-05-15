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
 * Classe responsavel por importar receita
 * @package caixa
 * @author widouglas
 */
class ImportacaoReceita
{
    private $sProcessoAdministrativo;
    private $iLayout;
    private $iData;
    private $iInscricao = "";
    private $iMatricula = "";
    private $sObservacao = "";
    private $sOperacaoBancaria = "";
    private $iOrigem = 1; // 1 - CGM
    private $iEmParlamentar = 3;
    private $iConvenio = "";
    private $iRegularizacaoRepasse = "";
    private $iRegExercicio = "";
    private $oPlanilhaArrecadacao;
    private $iCodigoSlip = null;
    private $iCodigoTipoOperacao = 11;
    public $iCodigoPlanilhaArrecadada = 0;
    public $aCodigoSlip = array();
    public $aCodigoPlanilhaArrecadada = array();

    /**
     * Construtor
     *
     * @param string $sProcessoAdministrativo
     * @param int $iLayout
     */
    public function __construct($sProcessoAdministrativo, $iLayout, $iData)
    {
        $this->preencherProcessoAdministrativo($sProcessoAdministrativo);
        $this->iLayout = $iLayout;
        $this->iData   = $iData;
    }

    /**
     * O campo de processo adminsitrativo deve receber o nome do arquivo
     *
     * @param string $sProcessoAdministrativo
     * @return void
     */
    public function preencherProcessoAdministrativo($sProcessoAdministrativo)
    {
        if (strlen($sProcessoAdministrativo) >= 99)
            throw new BusinessException("Nome do arquivo não pode ter mais que 100 caracteres \n Nome Atual: {$sProcessoAdministrativo}");
        $this->sProcessoAdministrativo = $sProcessoAdministrativo;
    }

    /**
     * Recebe o array e importa na planilha de receitas e salva
     *
     * @param array $aArquivoImportar
     * @return void
     */
    public function salvar($aArquivoImportar)
    {
        $this->formateDateReverse($this->iData);
        $this->importarReceitas($aArquivoImportar);
        $this->salvarReceitaOrcamentaria();
        $this->salvarReceitaExtraOrcamentaria();
    }

    /**
     * Extrai os dados do array de importacao e adiciona nos metodos para salvar
     *
     * @param array $aArquivoImportar
     * @return void
     */
    public function importarReceitas($aArquivoImportar)
    {
        foreach ($aArquivoImportar as $iPosicao => $sLinha) {
            $oReceitaOrcamentaria = $this->preencherLayoutReceitaOrcamentaria($this->iLayout, $sLinha);
            $oReceitaExtraOrcamentaria = $this->preencherLayoutReceitaExtraOrcamentaria($this->iLayout, $sLinha);

            if (property_exists($oReceitaOrcamentaria, "iRecurso"))
                $this->adicionarPlanilhaReceitaOrcamentaria($oReceitaOrcamentaria);

            if (property_exists($oReceitaExtraOrcamentaria, "iRecurso"))
                $this->adicionarReceitaExtraOrcamentaria($oReceitaExtraOrcamentaria);
        }
    }

    /**
     * Adiciona as linhas de receita orcamentaria
     *
     * @param object $oReceitaOrcamentaria
     * @return void
     */
    public function adicionarPlanilhaReceitaOrcamentaria($oReceitaOrcamentaria)
    {
        $oReceitaPlanilha = new ReceitaPlanilha();
        $oReceitaPlanilha->setCaracteristicaPeculiar(new CaracteristicaPeculiar("000"));
        $oReceitaPlanilha->setCGM(CgmFactory::getInstanceByCgm($oReceitaOrcamentaria->iNumeroCgm));
        $oReceitaPlanilha->setContaTesouraria($oReceitaOrcamentaria->oContaTesouraria);
        $oReceitaPlanilha->setDataRecebimento(new DBDate($this->iData));
        $oReceitaPlanilha->setInscricao($this->iInscricao);
        $oReceitaPlanilha->setMatricula($this->iMatricula);
        $oReceitaPlanilha->setObservacao(db_stdClass::normalizeStringJsonEscapeString($this->sObservacao));
        $oReceitaPlanilha->setOperacaoBancaria($this->sOperacaoBancaria);
        $oReceitaPlanilha->setOrigem($this->iOrigem);
        $oReceitaPlanilha->setRecurso(new Recurso($oReceitaOrcamentaria->iRecurso));
        $oReceitaPlanilha->setRegularizacaoRepasse($this->iRegularizacaoRepasse);
        $oReceitaPlanilha->setRegExercicio($this->iRegExercicio);
        $oReceitaPlanilha->setEmendaParlamentar($this->iEmParlamentar);
        $oReceitaPlanilha->setTipoReceita($oReceitaOrcamentaria->iReceita);
        $oReceitaPlanilha->setValor($oReceitaOrcamentaria->nValor);
        $oReceitaPlanilha->setConvenio($this->iConvenio);
        $this->listaPlanilhas[$oReceitaOrcamentaria->iNumeroCgm][] = $oReceitaPlanilha;
    }

    /**
     * Adiciona a receita orçamentaria no array para salvar
     *
     * @param object $oReceitaExtraOrcamentaria
     * @return void
     */
    public function adicionarReceitaExtraOrcamentaria($oReceitaExtraOrcamentaria)
    {
        if (array_key_exists($oReceitaExtraOrcamentaria->iIdentificadorReceita, $this->oTransferencias)) {
            $valorAtualizado = $this->oTransferencias[$oReceitaExtraOrcamentaria->iIdentificadorReceita]->getValor() + $oReceitaExtraOrcamentaria->nValor;
            $this->oTransferencias[$oReceitaExtraOrcamentaria->iIdentificadorReceita]->setValor($valorAtualizado);
            return;
        }

        $oTransferencia = TransferenciaFactory::getInstance($this->iCodigoTipoOperacao, $this->iCodigoSlip);
        $oTransferencia->setContaDebito($oReceitaExtraOrcamentaria->oContaTesouraria->getCodigoConta());
        $oTransferencia->setContaCredito($oReceitaExtraOrcamentaria->iContaCredito);
        $oTransferencia->setFonteRecurso($oReceitaExtraOrcamentaria->iRecurso);
        $oTransferencia->setValor($oReceitaExtraOrcamentaria->nValor);
        $oTransferencia->adicionarRecurso($oReceitaExtraOrcamentaria->iRecurso, $oReceitaExtraOrcamentaria->nValor);
        $oTransferencia->setHistorico(9100);
        $oTransferencia->setObservacao("Arrecadação de Receita Extraorçamentária - BDA");
        $oTransferencia->setTipoPagamento(0);
        $oTransferencia->setSituacao(1);
        $oTransferencia->setCodigoCgm($oReceitaExtraOrcamentaria->iNumeroCgm);
        $oTransferencia->setCaracteristicaPeculiarDebito("000");
        $oTransferencia->setCaracteristicaPeculiarCredito("000");
        $oTransferencia->setData($this->iData);
        $oTransferencia->setProcessoAdministrativo(db_stdClass::normalizeStringJsonEscapeString($this->sProcessoAdministrativo));
        $oTransferencia->setExercicioCompetenciaDevolucao("");
        if ($oTransferencia instanceof TransferenciaFinanceira) {
            $oTransferencia->setInstituicaoDestino("");
        }

        $this->oTransferencias[$oReceitaExtraOrcamentaria->iIdentificadorReceita] = $oTransferencia;
        return;
    }

    /**
     * Salva a Planilha de Receita
     *
     * @return void
     */
    public function salvarReceitaOrcamentaria()
    {
        foreach ($this->listaPlanilhas as $cgm => $planilha) {
            $this->oPlanilhaArrecadacao = new PlanilhaArrecadacao();
            $this->oPlanilhaArrecadacao->setInstituicao(InstituicaoRepository::getInstituicaoByCodigo(db_getsession('DB_instit')));
            $this->oPlanilhaArrecadacao->setProcessoAdministrativo($this->sProcessoAdministrativo);
            foreach ($planilha as $oReceitaPlanilha) {
                $dtAutenticacao = $oReceitaPlanilha->getDataRecebimento()->convertTo(DBDate::DATA_EN);
                $this->oPlanilhaArrecadacao->setDataCriacao($oReceitaPlanilha->getDataRecebimento()->convertTo(DBDate::DATA_EN));
                $this->oPlanilhaArrecadacao->adicionarReceitaPlanilha($oReceitaPlanilha);
            }
            $this->oPlanilhaArrecadacao->salvar();
            $this->oPlanilhaArrecadacao->getReceitasPlanilha();
            $this->oPlanilhaArrecadacao->setDataAutenticacao($this->iData);   
            $this->oPlanilhaArrecadacao->autenticar();
            $this->aCodigoPlanilhaArrecadada[] = "CGM ({$cgm}) - Planilha: " . $this->oPlanilhaArrecadacao->getCodigo();
        }
    }

    public function formateDateReverse(string $date)
    {
        $data_objeto = DateTime::createFromFormat('d/m/Y', $date);
        $data_formatada = $data_objeto->format('Y-m-d');
        $this->iData = date('Y-m-d', strtotime($data_formatada));
    }
  
    /**
     * Salva os dados da receita extra orçamentária
     *
     * @return void
     */
    public function salvarReceitaExtraOrcamentaria()
    {
        foreach ($this->oTransferencias as $oTransferencia) {
            if ($oTransferencia->getValor() == 0)
                continue;

            if ($oTransferencia->getValor() < 0) {
                $nomeCGM = CgmFactory::getInstanceByCgm($oTransferencia->getCodigoCgm())->getNome();
                throw new BusinessException("Não foi possível importar o arquivo! O agente arrecadador {$nomeCGM} e conta contábil de reduzido " . $oTransferencia->getContaCredito() . " está com valor menor que zero na arrecadação. Ajuste o lançamento e tente novamente!");
            }
            
            $oTransferencia->salvar();
            if ((int) $oTransferencia->getCodigoSlip() <= 0)
                throw new BusinessException("Não foi possível salvar as receitas extra-orçamentárias");
            $oTransferencia->executaAutenticacao($oTransferencia->getData());
            $oTransferencia->executarLancamentoContabil();
            $this->aCodigoSlip[] = $oTransferencia->getCodigoSlip();
        }
    }

    /**
     * Recebe a linha e passa na classe de preenchimento conforme o layout e devolve um objeto preenchido
     *
     * @param int $iLayout
     * @param string $sLinha
     * @return object
     */
    public function preencherLayoutReceitaOrcamentaria($iLayout, $sLinha)
    {
        $sClassName = "ImportacaoReceitaOrcamentariaLayout{$iLayout}";

        if (!class_exists($sClassName))
            throw new BusinessException("Layout selecionado é inválido");

        $oImportacao = new $sClassName($sLinha);
        return $oImportacao->recuperarLinha();
    }

    public function preencherLayoutReceitaExtraOrcamentaria($iLayout, $sLinha)
    {
        $sClassName = "ImportacaoReceitaExtraOrcamentariaLayout{$iLayout}";

        if (!class_exists($sClassName))
            throw new BusinessException("Layout de Receita Extra Orcamentaria selecionado é inválido");

        $oImportacao = new $sClassName($sLinha);
        return $oImportacao->recuperarLinha();
    }
}
