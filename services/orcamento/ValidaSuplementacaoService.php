<?php

require_once "repositories/QuadroSuperavitDeficitRepositoryLegacy.php";
require_once "repositories/OrcSuplemValRepositoryLegacy.php";
require_once "repositories/TipoSuplementacaoSuperavitDeficitRepositoryLegacy.php";

/**
 * @author widouglas
 */
class ValidaSuplementacaoService
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
     * @var bool
     */
    private $bExisteQuadro;

    /**
     * @var float
     */
    private $nValorQuadroSuperavitDeficit = 0.00;

    /**
     * @var IQuadroSuperavitDeficitRepository
     */
    private $oQuadroSuperavitDeficit;

    /**
     * @var IOrcSuplemValRepository
     */
    private $oOrcSuplemVal;

    /**
     * @var ITipoSuplementacaoSuperavitDeficitRepository
     */
    private $tipoSuplementacaoSuperavitDeficitRepository;

    /**
     * @return void
     */
    public function __construct(
        $sSupTipo,
        Recurso $oRecurso,
        $nValor,
        IQuadroSuperavitDeficitRepository $QuadroSuperavitDeficitRepositoryLegacy,
        IOrcSuplemValRepository $OrcSuplemValRepository,
        ITipoSuplementacaoSuperavitDeficitRepository $TipoSuplementacaoSuperavitDeficitRepository
    )
    {
        $this->sSupTipo = $sSupTipo;
        $this->oRecurso = $oRecurso;
        $this->preencherValor($nValor);
        $this->tipoSuplementacaoSuperavitDeficitRepository = $TipoSuplementacaoSuperavitDeficitRepository;
        $this->aTipoSubSuplementacaoSuperavitDeficit = $this->tipoSuplementacaoSuperavitDeficitRepository->pegarTipoSup();
        $this->oQuadroSuperavitDeficit = $QuadroSuperavitDeficitRepositoryLegacy;
        $this->oOrcSuplemVal = $OrcSuplemValRepository;
    }

    /**
     * @param float $nValor
     * @return void
     */
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
       return in_array($this->sSupTipo, $this->aTipoSubSuplementacaoSuperavitDeficit);
    }

    /**
     * Desmembra fontes em casos especificos
     *
     * @return array
     */
    public function desmembrarFontes()
    {
        if (db_getsession("DB_anousu") > 2022)
            return array(substr($this->oRecurso->getCodigo(), 1, -1));

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
     * @param int $registros
     * @return void
     */
    public function definirExisteQuadroSuperavitDeficit($registros)
    {
        if ($registros === 0) {
            $this->bExisteQuadro = FALSE;
            return;
        }
        $this->bExisteQuadro = TRUE;
    }

    /**
     * @param string $sFonte
     * @return float
     */
    public function pegarValorQuadroSuperavitDeficit($sFonte)
    {
        return (float) number_format($this->oQuadroSuperavitDeficit->pegarValorPorFonte($sFonte), 2, ".", "");
    }

    /**
     * @param string $sFonte
     * @return float
     */
    public function pegarValorSuplementadoPorFonte($sFonte)
    {
        return $this->oOrcSuplemVal->pegarValorSuplementadoPorFonteETipoSup($sFonte, $this->aTipoSubSuplementacaoSuperavitDeficit);
    }

    /**
     * @return void
     * @throws BusinessException
     */
    public function validar()
    {
        if (!$this->eTipoSubSuplementacaoSuperavitDeficit())
            return;

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
