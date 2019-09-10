<?php

require_once("classes/db_orcorgao_classe.php");
require_once("libs/db_liborcamento.php");
require_once("libs/db_libcontabilidade.php");
require_once("model/SiopeCsv.model.php");


class Siope {

    //@var integer
    public $iInstit;
    //@var integer
    public $iAnoUsu;
    //@var integer
    public $iBimestre;
    //@var string
    public $filtros;
    //@var string
    public $dtIni;
    //@var string
    public $dtFim;
    //var array
    public $despesas;

    public function setAno($iAnoUsu) {
        $this->iAnoUsu = $iAnoUsu;
    }

    public function setInstit($iInstit) {
        $this->iInstit = $iInstit;
    }

    public function setBimestre($iBimestre) {
        $this->iBimestre = $iBimestre;
    }

    public function setFiltros() {

        $clorcorgao       = new cl_orcorgao;
        $result           = db_query($clorcorgao->sql_query_file('', '', 'o40_orgao', 'o40_orgao asc', 'o40_instit = '.$this->iInstit.' and o40_anousu = '.$this->iAnoUsu));
        $this->filtros    = "instit_{$this->iInstit}-funcao_12-";

        if (pg_num_rows($result) > 1) {
            for ($i = 0; $i < pg_numrows($result); $i++) {
                $this->filtros .= "orgao_".db_utils::fieldsMemory($result, $i)->o40_orgao."-";
            }
        } else {
            $this->filtros = 'geral';
        }

    }

    public function setPeriodo() {

        $iBimestre  = $this->iBimestre;
        $dtData     = new \DateTime("{$this->iAnoUsu}-01-01");
        $dtIni      = new \DateTime("{$this->iAnoUsu}-01-01");


        if($iBimestre == 1) {
            $dtData->modify('last day of next month');
        } elseif($iBimestre == 2) {
            $dtData->modify('last day of April');
        } elseif($iBimestre == 3) {
            $dtData->modify('last day of June');
        } elseif($iBimestre == 4) {
            $dtData->modify('last day of August');
        } elseif($iBimestre == 5) {
            $dtData->modify('last day of October');
        } elseif($iBimestre == 6) {
            $dtData->modify('last day of December');
        }

        $this->dtIni = $dtIni->format('Y-m-d');
        $this->dtFim = $dtData->format('Y-m-d');

    }

    public function setDespesa() {

        $aDespesas = array();

        $clselorcdotacao = new cl_selorcdotacao();
        $clselorcdotacao->setDados($this->filtros);

        $sele_work  = $clselorcdotacao->getDados(false, true) . " and o58_instit in ($this->iInstit) and  o58_anousu=$this->iAnoUsu  ";

        $sqlprinc   = db_dotacaosaldo(8, 1, 4, true, $sele_work, $this->iAnoUsu, $this->dtIni, $this->dtFim, 8, 0, true);
        $result     = db_query($sqlprinc) or die(pg_last_error());

        if (pg_num_rows($result) == 0) {
            throw new Exception ("Nenhum registro encontrado.");
        }

        for ($i = 0; $i < pg_numrows($result); $i++) {

            $oDespesa = db_utils::fieldsMemory($result, $i);

            if ($oDespesa->o58_orgao != $xorgao && $oDespesa->o58_orgao != 0) {
                $xorgao = $oDespesa->o58_orgao;
            }
            if ($oDespesa->o58_orgao . $oDespesa->o58_unidade != $xunidade && $oDespesa->o58_unidade != 0) {
                $xunidade = $oDespesa->o58_orgao . $oDespesa->o58_unidade;
            }
            if ($oDespesa->o58_orgao . $oDespesa->o58_unidade . $oDespesa->o58_funcao != $xfuncao && $oDespesa->o58_funcao != 0) {
                $xfuncao = $oDespesa->o58_orgao . $oDespesa->o58_unidade . $oDespesa->o58_funcao;
            }
            if ($oDespesa->o58_orgao . $oDespesa->o58_unidade . $oDespesa->o58_funcao . $oDespesa->o58_subfuncao != $xsubfuncao && $oDespesa->o58_subfuncao != 0) {
                $xsubfuncao = $oDespesa->o58_orgao . $oDespesa->o58_unidade . $oDespesa->o58_funcao . $oDespesa->o58_subfuncao;
            }
            if ($oDespesa->o58_orgao . $oDespesa->o58_unidade . $oDespesa->o58_funcao . $oDespesa->o58_subfuncao . $oDespesa->o58_programa != $xprograma && $oDespesa->o58_programa != 0) {
                $xprograma = $oDespesa->o58_orgao . $oDespesa->o58_unidade . $oDespesa->o58_funcao . $oDespesa->o58_subfuncao . $oDespesa->o58_programa;
            }
            if ($oDespesa->o58_orgao . $oDespesa->o58_unidade . $oDespesa->o58_funcao . $oDespesa->o58_subfuncao . $oDespesa->o58_programa . $oDespesa->o58_projativ != $xprojativ && $oDespesa->o58_projativ != 0) {
                $xprojativ = $oDespesa->o58_orgao . $oDespesa->o58_unidade . $oDespesa->o58_funcao . $oDespesa->o58_subfuncao . $oDespesa->o58_programa . $oDespesa->o58_projativ;
            }

            if ($oDespesa->o58_codigo > 0) {

                if ($oDespesa->o58_elemento != "") {

                    $sele_work2 = " 1=1 and o58_orgao in ({$oDespesa->o58_orgao}) and ( ( o58_orgao = {$oDespesa->o58_orgao} and o58_unidade = {$oDespesa->o58_unidade} ) ) and o58_funcao in ({$oDespesa->o58_funcao}) and o58_subfuncao in ({$oDespesa->o58_subfuncao}) and o58_programa in ({$oDespesa->o58_programa}) and o58_projativ in ({$oDespesa->o58_projativ}) and (o56_elemento like '" . substr($oDespesa->o58_elemento, 0, 7) . "%') and o58_codigo in ({$oDespesa->o58_codigo}) and o58_instit in ({$this->iInstit}) and o58_anousu={$this->iAnoUsu} ";

                    $cldesdobramento = new cl_desdobramento();
                    $resDepsMes = db_query($cldesdobramento->sql($sele_work2, $this->dtIni, $this->dtFim, "({$this->iInstit})")) or die($cldesdobramento->sql($sele_work2, $this->dtIni, $this->dtFim, "({$this->iInstit})") . pg_last_error());
                    $aDadosAgrupados = array();

                    for ($contDesp = 0; $contDesp < pg_num_rows($resDepsMes); $contDesp++) {
                        $oDadosMes = db_utils::fieldsMemory($resDepsMes, $contDesp);

                        $sHash = $oDadosMes->o56_elemento;

                        if (!isset($aDadosAgrupados[$sHash])) {
                            $oDespesas = new stdClass();
                            $oDespesas->o56_elemento    = $oDadosMes->o56_elemento;
                            $oDespesas->o56_descr       = $oDadosMes->o56_descr;
                            $oDespesas->empenhado       = $oDadosMes->empenhado;
                            $oDespesas->liquidado       = $oDadosMes->liquidado;
                            $oDespesas->pagamento       = $oDadosMes->pagamento;
                            $aDadosAgrupados[$sHash]    = $oDespesas;
                        }

                    }

                    $resDepsAteMes = db_query($cldesdobramento->sql2($sele_work2, $this->dtIni, $this->dtFim, "({$this->iInstit})")) or die($cldesdobramento->sql2($sele_work2, $this->dtIni, $this->dtFim, "({$this->iInstit})") . pg_last_error());

                    for ($contDesp = 0; $contDesp < pg_num_rows($resDepsAteMes); $contDesp++) {
                        $oDadosAteMes = db_utils::fieldsMemory($resDepsAteMes, $contDesp);
                        $sHash = $oDadosAteMes->o56_elemento;
                        if (isset($aDadosAgrupados[$sHash])) {
                            $aDadosAgrupados[$sHash]->empenhadoa            = $oDadosAteMes->empenhadoa;
                            $aDadosAgrupados[$sHash]->empenhado_estornadoa  = $oDadosAteMes->empenhado_estornadoa;
                            $aDadosAgrupados[$sHash]->liquidadoa            = $oDadosAteMes->liquidadoa;
                            $aDadosAgrupados[$sHash]->liquidado_estornadoa  = $oDadosAteMes->liquidado_estornadoa;
                            $aDadosAgrupados[$sHash]->pagamentoa            = $oDadosAteMes->pagamentoa;
                            $aDadosAgrupados[$sHash]->pagamento_estornadoa  = $oDadosAteMes->pagamento_estornadoa;
                        }
                    }

                    asort($aDadosAgrupados);
                    foreach ($aDadosAgrupados as $objElementos) {
                        $aDespesas[$sHash]->elemento        = $objElementos->o56_elemento;
                        $aDespesas[$sHash]->empenhado       = $objElementos->empenhado;
                        $aDespesas[$sHash]->liquidado       = $objElementos->liquidado;
                        $aDespesas[$sHash]->pagamento       = $objElementos->pagamento;
                        $aDespesas[$sHash]->o58_codigo      = $objElementos->o58_codigo;
                        $aDespesas[$sHash]->o58_subfuncao   = $objElementos->o58_subfuncao;
                        $aDespesas[$sHash]->o55_tipopasta   = $objElementos->o55_tipopasta;
                        $aDespesas[$sHash]->o55_tipoensino  = $objElementos->o55_tipoensino;
                    }
                }
            }
        }

        $this->despesas = $aDespesas;
    }

    public function getDespesas() {
        return $this->despesas;
    }

}