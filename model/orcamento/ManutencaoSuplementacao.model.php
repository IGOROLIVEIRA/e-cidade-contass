<?php

require_once("repositorios/QuadroSuperavitDeficitRepository.php");
require_once("repositorios/OrcSuplemValRepository.php");

/**
 * Classe responsavel pela regra de negocios da suplementação do orçamento
 * @author widouglas
 */
class ManutencaoSuplementacao
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
    private $aTipoSubSuplementacao = array('1003', '1008', '1024', '1028', '2026');

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
    private $nValorQuadroSuperavitDeficit = 0;

    public function __construct($sSupTipo, Recurso $oRecurso, $nValor)
    {
        $this->sSupTipo = $sSupTipo;
        $this->oRecurso = $oRecurso;
        $this->nValor = $nValor;
        $this->iAnoUsu = db_getsession("DB_anousu");
        $this->iInstituicao = db_getsession("DB_instit");
    }

    /**
     * Verifica se o subtipo é de suplementação
     *
     * @return bool
     */
    public function eTipoSubSuplementacaoSuperavitDeficit()
    {
        if (in_array($this->sSupTipo, $this->aTipoSubSuplementacao))
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

    public function valorQuadroSuperavitDeficit($sFonte)
    {
        $oQuadroSuperavitDeficit = new QuadroSuperavitDeficitRepository($this->iAnoUsu, $this->iInstituicao);
        $oQuadroSuperavitDeficit->calcularPorFonte($sFonte);
        $this->definirExisteQuadroSuperavitDeficit($oQuadroSuperavitDeficit->pegarNumeroRegistros());
        return $oQuadroSuperavitDeficit->pegarValor();
    }

    public function valorSuplementado($sFonte)
    {
        $oOrcSuplemVal = new OrcSuplemValRepository($this->iAnoUsu, $this->iInstituicao);
        return $oOrcSuplemVal->pegarValorSuplementadoPorFonteETipoSup($sFonte, $this->aTipoSubSuplementacao);
    }

    public function validarSuplementacao()
    {
        
        if (!$this->eTipoSubSuplementacaoSuperavitDeficit())
            return false;

        $aFontes = $this->desmembrarFontes();

        for ($i = 1; $i <= 2; $i++) {
            foreach ($aFontes as $sFonte) {
                $sFonteAtual = $i . $sFonte;        
                $this->nValorQuadroSuperavitDeficit += $this->valorQuadroSuperavitDeficit($sFonteAtual);
                $this->nValorSuplementado -= $this->valorSuplementado($sFonteAtual);
            }
        }
        
        if (!$this->bExisteQuadro) 
            throw new BusinessException("Não existe cadastro no quadro de superávit e deficit para a fonte informada no exercício.");

        $nValorQuadroSuperavitDeficit = number_format($this->nValorQuadroSuperavitDeficit, 2, ".", "");

        if (number_format($this->nValor, 2, ".", "") > $nValorQuadroSuperavitDeficit)
            throw new BusinessException("Não existe superávit suficiente para realizar essa suplementação, saldo disponível R$ {$nValorQuadroSuperavitDeficit}");
    }
}
