<?php

require_once("repositorios/QuadroSuperavitDeficitRepository.php");
require_once("repositorios/OrcSuplemValRepository.php");
require_once("repositorios/TipoSuplementacaoSuperavitDeficitRepository.php");

/**
 * Classe responsavel pela regra de negocios da suplementação do orçamento
 * @author widouglas
 */
class ValidacaoSuplementacao
{
    /**
     * @var string
     */
    private $sSupTipo;

    /**
     * @var Recurso
     */
    private $oRecurso;

    /**
     * @var float
     */
    private $nValor;

    /**
     * @var array
     */
    private $aTipoSubSuplementacaoSuperavitDeficit = array();

    /**
     * @var int
     */
    private $iAnoUsu;

    /**
     * @var int
     */
    private $iInstituicao;

    /**
     * @var bol
     */
    private $bExisteQuadro;

    /**
     * @var float
     */
    private $nValorQuadroSuperavitDeficit = 0.00;

    public function __construct($sSupTipo, Recurso $oRecurso, $nValor)
    {
        $this->sSupTipo = $sSupTipo;
        $this->oRecurso = $oRecurso;
        $this->preencherValor($nValor);
        $this->preencherTipoSuplementacao();
        $this->iAnoUsu = db_getsession("DB_anousu");
        $this->iInstituicao = db_getsession("DB_instit");
        $this->oQuadroSuperavitDeficit = new QuadroSuperavitDeficitRepository($this->iAnoUsu, $this->iInstituicao);
    }

    public function preencherTipoSuplementacao()
    {
        $this->aTipoSubSuplementacaoSuperavitDeficit = TipoSuplementacaoSuperavitDeficitRepository::pegarTipoSup();
    }

    public function preencherValor($nValor)
    {
        $this->nValor = number_format($nValor, 2, ".", "");
    }

    /**
     * Verifica se o subtipo é de suplementação
     *
     * @return bool
     */
    public function eTipoSubSuplementacaoSuperavitDeficit()
    {
        if (in_array($this->sSupTipo, $this->aTipoSubSuplementacaoSuperavitDeficit))
            return true;
        return false;
    }

    /**
     * Desmembra fontes em casos especificos
     *
     * @return array
     */
    public function desmembrarFontes()
    {
        $sDigitosFonte = substr($this->oRecurso->getCodigo(), 1, 2);
        if (in_array($sDigitosFonte, array("00", "01", "02", "18", "19"))) {
            if (in_array(substr($sDigitosFonte, 1, 2), array("00", "01", "02"))) {
                return array("00", "01", "02");
            }
            return array("18", "19");
        }
        return array($sDigitosFonte);
    }

    /**
     * definir se existe quadro de superavit
     *
     * @param [type] $registros
     * @return void
     */
    public function definirExisteQuadroSuperavitDeficit($registros)
    {
        if ($registros === 0)
            $this->bExisteQuadro = FALSE;
        $this->bExisteQuadro = TRUE;
    }

    /**
     * @param string $sFonte
     * @return float
     */
    public function pegarValorQuadroSuperavitDeficit($sFonte)
    {
        return number_format($this->oQuadroSuperavitDeficit->pegarValorPorFonte($sFonte), 2, ".", "");
    }

    public function pegarValorSuplementadoPorFonte($sFonte)
    {
        $oOrcSuplemVal = new OrcSuplemValRepository($this->iAnoUsu, $this->iInstituicao);
        return $oOrcSuplemVal->pegarValorSuplementadoPorFonteETipoSup($sFonte, $this->aTipoSubSuplementacaoSuperavitDeficit);
    }

    public function pegarArrayValorSuplementado()
    {
        $oOrcSuplemVal = new OrcSuplemValRepository($this->iAnoUsu, $this->iInstituicao);
        return $oOrcSuplemVal->pegarArrayValorPelaFonteSuplementadoPorTipoSup($this->aTipoSubSuplementacaoSuperavitDeficit);
    }

    public function validar()
    {
        if (!$this->eTipoSubSuplementacaoSuperavitDeficit())
            return false;

        $this->verificarValoresSuperavitDeficitESuplementados();

        if (!$this->bExisteQuadro)
            throw new BusinessException("Não existe cadastro no quadro de superávit e deficit para a fonte informada no exercício.");

        if ($this->nValor > $this->nValorQuadroSuperavitDeficit)
            throw new BusinessException("Não existe superávit suficiente para realizar essa suplementação, saldo disponível R$ {$this->nValorQuadroSuperavitDeficit}");
    }

    /**
     * Verifica os valores de superavit, deficit e suplementados
     *
     * @return void
     */
    public function verificarValoresSuperavitDeficitESuplementados()
    {
        $aFontes = $this->desmembrarFontes();

        for ($i = 1; $i <= 2; $i++) {
            foreach ($aFontes as $sFonte) {
                $sFonteAtual = $i . $sFonte;
                $this->nValorQuadroSuperavitDeficit += $this->pegarValorQuadroSuperavitDeficit($sFonteAtual);
                $this->nValorQuadroSuperavitDeficit -= $this->pegarValorSuplementadoPorFonte($sFonteAtual);
                $this->definirExisteQuadroSuperavitDeficit($this->oQuadroSuperavitDeficit->pegarNumeroRegistros());
            }
        }
    }
}
