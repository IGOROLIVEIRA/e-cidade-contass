<?php

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
    private $aSubTipoSuplementacao = array('1003', '1008', '1024', '1028', '2026');

    /**
     * @var int
     */
    private $iAnoUsu = db_getsession("DB_anousu");

    /**
     * @var int
     */
    private $iInstituicao = db_getsession("DB_instit");

    public function __construct($sSupTipo, Recurso $oRecurso, $nValor)
    {
        $this->sSupTipo = $sSupTipo;
        $this->oRecurso = $oRecurso;
        $this->nValor = $nValor;
    }

    /**
     * Verifica se o subtipo é de suplementação
     *
     * @return bool
     */
    public function eSubTipoSuplementacaoSuperavit()
    {
        if (in_array($this->sSupTipo, $this->aSubTipoSuplementacao))
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

    public function valorQuadroSuperavit($sFonte)
    {
        /*
        $clQuadroSuperavitDeficit = new cl_quadrosuperavitdeficit;
        $sWhere = " c241_fonte = {$sFonte} AND c241_ano = {$this->iAnoUsu} AND c241_instit = {$this->iInstituicao} ";
        $rResult = $clQuadroSuperavitDeficit->sql_record($clQuadroSuperavitDeficit->sql_query(null, "c241_valor", null, $sWhere));
        if (pg_num_rows($rResult) == 0) 
            return 0;
/*
            $subSql = "SELECT
            concat('1', substring(o58_codigo::TEXT, 2, 2)) fonte,
                sum(o47_valor) as valor
                    FROM
                    orcsuplemval
                        LEFT JOIN orcdotacao ON o47_coddot = o58_coddot
                        AND o47_anousu = o58_anousu
                        JOIN orcsuplem ON o47_codsup=o46_codsup
                    WHERE
                        o47_anousu = " . db_getsession("DB_anousu") . "
                        AND concat('1', substring(o58_codigo::TEXT, 2, 2)) = '{$sFonteAtual}'
                        AND o47_valor > 0
                        AND o46_instit IN (" . db_getsession("DB_instit") . ")
                        AND o46_tiposup IN (2026, 1003, 1008, 1024, 1028)
                    GROUP BY concat('1', substring(o58_codigo::TEXT, 2, 2))
                    UNION
                    select
                    concat('1', substring(o58_codigo::TEXT, 2, 2)) fonte,
                        sum(o136_valor) as valor
                    from
                    orcsuplemdespesappa
                        LEFT JOIN orcsuplemval ON o47_codsup = o136_orcsuplem
                        LEFT JOIN orcdotacao ON o47_coddot = o58_coddot
                        AND o47_anousu = o58_anousu
                        JOIN orcsuplem ON o47_codsup=o46_codsup
                
                    WHERE
                        o47_anousu = " . db_getsession("DB_anousu") . "
                        AND o46_instit IN (" . db_getsession("DB_instit") . ")
                        AND concat('1', substring(o58_codigo::TEXT, 2, 2)) = '$sFonteAtual'
                        AND o46_tiposup IN (2026, 1003, 1008, 1024, 1028)
                    AND 
                        o136_valor > 0 
                    GROUP BY concat('1', substring(o58_codigo::TEXT, 2, 2))";
        $subResult = db_query($subSql);

        for ($y = 0; $y < pg_num_rows($subResult); $y++) {
            $oFonte = db_utils::fieldsMemory($subResult, $y);
            $nValorTotalQuadro -= $oFonte->valor;
        }

        $oQuadro = db_utils::fieldsMemory($rResult, 0);
        return $oQuadro->c241_valor;
        
        return 0;
        */
    }

    public function validarSuplementacao()
    {
        /*
        if (!$this->eSubTipoSuplementacaoSuperavit())
            return false;

        $aFontes = $this->desmembrarFontes();
        $nValorTotalQuadro = 0;
        $bExisteQuadro = false;

        for ($i = 1; $i <= 2; $i++) {
            foreach ($aFontes as $sFonte) {
                $sFonteAtual = $i . $sFonte;
                /*
                echo "Fonte {$sFonteAtual} <br/>";
                $nValorQuadro = $this->valorQuadroSuperavit($sFonteAtual);
                if ($nValorQuadro > 0)
                    $bExisteQuadro = true;
                $nValorTotalQuadro += $this->valorQuadroSuperavit($sFonteAtual);
                echo $nValorTotalQuadro;
                
            }
            */
        }
        
        if (!$bExisteQuadro) 
            throw new BusinessException("Não existe cadastro no quadro de superávit e deficit para a fonte informada no exercício.");

        $nValorTotalQuadro = number_format($nValorTotalQuadro, 2, ".", "");

        if (number_format($this->nValor, 2, ".", "") > $nValorTotalQuadro)
            throw new BusinessException("Não existe superávit suficiente para realizar essa suplementação, saldo disponível R$ {$nValorTotalQuadro}");
    }
}
