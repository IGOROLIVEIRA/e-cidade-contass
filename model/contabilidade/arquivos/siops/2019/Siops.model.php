<?php

require_once("classes/db_orcorgao_classe.php");
require_once("classes/db_orcdotacao_classe.php");
require_once("classes/db_orcreceita_classe.php");
require_once("classes/db_naturdessiops_classe.php");
//require_once("classes/db_naturrecsiope_classe.php");
require_once("libs/db_liborcamento.php");
require_once("libs/db_libcontabilidade.php");


class Siops {

    //@var integer
    public $iInstit;
    //@var integer
    public $iAnoUsu;
    //@var integer
    public $iBimestre;
    //@var string
    public $sFiltros;
    //@var string
    public $dtIni;
    //@var string
    public $dtFim;
    //@var array
    public $aDespesas = array();
    //@var array
    public $aReceitas = array();
    //@var array
    public $aReceitasAnoSeg = array();
    //@var array
    public $aDespesasAnoSeg = array();
    //@var array
    public $aDespesasAgrupadas = array();
    //@var array
    public $aReceitasAgrupadas = array();
    //@var array
    public $aReceitasAnoSegAgrupadas = array();
    //@var array
    public $aDespesasAnoSegAgrupadas = array();
    //@var array
    public $aDespesasAgrupadasFinal = array();
    //@var boolean
    public $aReceitasAgrupadasFinal = array();
    //@var boolean
    public $lOrcada;
    //@var string
    public $sNomeArquivo;
    //@var integer
    public $iErroSQL;
    //@var integer
    public $status;
    //@var string
    public $sMensagem;


    public function setAno($iAnoUsu) {
        $this->iAnoUsu = $iAnoUsu;
    }

    public function setInstit($iInstit) {
        $this->iInstit = $iInstit;
    }

    public function setBimestre($iBimestre) {
        $this->iBimestre = $iBimestre;
    }

    public function getErroSQL() {
        return $this->iErroSQL;
    }

    public function setErroSQL($iErroSQL) {
        $this->iErroSQL = $iErroSQL;
    }

    /**
     * Adiciona filtros da institui��o, fun��o 12 (Educa��o) e todos os org�os
     */
    public function setFiltrosDespesa() {

        $clorcorgao       = new cl_orcorgao;
        $result           = db_query($clorcorgao->sql_query_file('', '', 'o40_orgao', 'o40_orgao asc', 'o40_instit = '.$this->iInstit.' and o40_anousu = '.$this->iAnoUsu));
        $this->sFiltros    = "instit_{$this->iInstit}-funcao_10-";

        if (pg_num_rows($result) > 0) {
            for ($i = 0; $i < pg_numrows($result); $i++) {
                $this->sFiltros .= "orgao_".db_utils::fieldsMemory($result, $i)->o40_orgao."-";
            }
        } else {
            $this->sFiltros = 'geral';
        }

    }

    /**
     * Adiciona filtros de todas as institui��es
     */
    public function setFiltrosReceita() {


    }

    /**
     * Retorna datas correspondente ao per�odo do bimestre, sempre cumulativo.
     */
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

    /**
     * Busca as despesas conforme
     */
    public function setDespesas() {

        $clselorcdotacao = new cl_selorcdotacao();
        $clselorcdotacao->setDados($this->sFiltros);

        $sele_work  = $clselorcdotacao->getDados(false, true) . " and o58_instit in ($this->iInstit) and  o58_anousu=$this->iAnoUsu  ";
        $sqlprinc   = db_dotacaosaldo(8, 1, 4, true, $sele_work, $this->iAnoUsu, $this->dtIni, $this->dtFim, 8, 0, true);
        $result     = db_query($sqlprinc) or die(pg_last_error());

        /**
         * Caso seja 6� Bimestre, campo OR�ADO ser� alimentado atrav�s do relat�rio Balancete da Despesa no exerc�cio subsequente ao de refer�ncia.
         */
        if ($this->lOrcada) {
            $iAnoSeg          = $this->iAnoUsu+1;
            $sele_workAnoSeg  = $clselorcdotacao->getDados(false, true) . " and o58_instit in ($this->iInstit) and  o58_anousu=$iAnoSeg  ";
            $sqlprincAnoSeg   = db_dotacaosaldo(8, 1, 4, true, $sele_workAnoSeg, $iAnoSeg, "$iAnoSeg-01-01", "$iAnoSeg-01-01", 8, 0, true);
            $resultAnoSeg     = db_query($sqlprincAnoSeg) or die(pg_last_error());
        }

        if (pg_num_rows($result) == 0) {
            throw new Exception ("Nenhum registro encontrado.");
        }

        /**
         * Organiza despesas com respectivos desdobramentos.
         * Realiza De/Para da despesa com natureza siope.
         */
        for ($i = 0; $i < pg_numrows($result); $i++) {

            $oDespesa = db_utils::fieldsMemory($result, $i);

            if ($oDespesa->o58_codigo > 0) {

                if ($oDespesa->o58_elemento != "") {

                    $sele_work2         = " 1=1 and o58_orgao in ({$oDespesa->o58_orgao}) and ( ( o58_orgao = {$oDespesa->o58_orgao} and o58_unidade = {$oDespesa->o58_unidade} ) ) and o58_funcao in ({$oDespesa->o58_funcao}) and o58_subfuncao in ({$oDespesa->o58_subfuncao}) and o58_programa in ({$oDespesa->o58_programa}) and o58_projativ in ({$oDespesa->o58_projativ}) and (o56_elemento like '" . substr($oDespesa->o58_elemento, 0, 7) . "%') and o58_codigo in ({$oDespesa->o58_codigo}) and o58_instit in ({$this->iInstit}) and o58_anousu={$this->iAnoUsu} ";
                    $cldesdobramento    = new cl_desdobramento();
                    $resDepsMes         = db_query($cldesdobramento->sql($sele_work2, $this->dtIni, $this->dtFim, "({$this->iInstit})",'')) or die($cldesdobramento->sql($sele_work2, $this->dtIni, $this->dtFim, "({$this->iInstit})",'') . pg_last_error());
                    $oNaturdessiope     = $this->getNaturDesSiops($oDespesa->o58_elemento);
                    $sHashDesp          = $oDespesa->o58_elemento;
                    $aDadosAgrupados    = array();

                    if (!isset($aDadosAgrupados[$sHashDesp])) {

                        $aArrayTemp     = array();

                        $aArrayTemp['o58_codigo']       = $oDespesa->o58_codigo;
                        $aArrayTemp['o58_subfuncao']    = $oDespesa->o58_subfuncao;
                        $aArrayTemp['o58_elemento']     = $oDespesa->o58_elemento;
                        $aArrayTemp['cod_planilha']     = $this->getCodPlanilha($oDespesa);
                        $aArrayTemp['elemento_siops']   = $oNaturdessiope->c227_eledespsiops;
                        $aArrayTemp['descricao_siops']  = $oNaturdessiope->c227_descricao;
                        $aArrayTemp['campo_siops']      = $oNaturdessiope->c227_campo;
                        $aArrayTemp['linha_siops']      = $oNaturdessiope->c227_linha;
                        $aArrayTemp['dot_inicial']      = $oDespesa->dot_ini;
                        $aArrayTemp['dot_atualizada']   = ($oDespesa->dot_ini + $oDespesa->suplementado_acumulado - $oDespesa->reduzido_acumulado);
                        $aArrayTemp['inscritas_rpnp']   = 0;
                        $aArrayTemp['empenhado']        = 0;
                        $aArrayTemp['liquidado']        = 0;
                        $aArrayTemp['pagamento']        = 0;

                        array_push($this->aDespesas, $aArrayTemp);

                    }

                    for ($contDesp = 0; $contDesp < pg_num_rows($resDepsMes); $contDesp++) {

                        $oDadosMes          = db_utils::fieldsMemory($resDepsMes, $contDesp);
                        $oNaturdessiopeDesd = $this->getNaturDesSiops($oDadosMes->o56_elemento);
                        $sHashDespDesd      = $oDadosMes->o56_elemento;

                        if (isset($aDadosAgrupados[$sHashDesp])) {

                            $aArrayDesdTemp = array();

                            $aArrayDesdTemp['o58_codigo']       = $oDespesa->o58_codigo;
                            $aArrayDesdTemp['o58_subfuncao']    = $oDespesa->o58_subfuncao;
                            $aArrayDesdTemp['o56_elemento']     = $oDadosMes->o56_elemento;
                            $aArrayDesdTemp['cod_planilha']     = $this->getCodPlanilha($oDespesa);
                            $aArrayDesdTemp['elementos_siops']  = $oNaturdessiopeDesd->c227_eledespsiops;
                            $aArrayDesdTemp['descricao_siops']  = $oNaturdessiopeDesd->c227_descricao;
                            $aArrayDesdTemp['campo_siops']      = $oNaturdessiopeDesd->c227_campo;
                            $aArrayDesdTemp['linha_siops']      = $oNaturdessiopeDesd->c227_linha;
                            $aArrayDesdTemp['dot_inicial']      = 0;
                            $aArrayDesdTemp['dot_atualizada']   = 0;
                            $aArrayDesdTemp['inscritas_rpnp']   = ($oDadosMes->empenhado - $oDadosMes->empenhado_estornado) - ($oDadosMes->liquidado - $oDadosMes->liquidado_estornado);
                            $aArrayDesdTemp['empenhado']        = ($oDadosMes->empenhado - $oDadosMes->empenhado_estornado);
                            $aArrayDesdTemp['liquidado']        = ($oDadosMes->liquidado - $oDadosMes->liquidado_estornado);
                            $aArrayDesdTemp['pagamento']        = ($oDadosMes->pagamento - $oDadosMes->pagamento_estornado);

                            array_push($this->aDespesas, $aArrayDesdTemp);

                        } else {

                            $aArrayDesdTemp = array();

                            $aArrayDesdTemp['o58_codigo']       = $oDespesa->o58_codigo;
                            $aArrayDesdTemp['o58_subfuncao']    = $oDespesa->o58_subfuncao;
                            $aArrayDesdTemp['o56_elemento']     = $oDadosMes->o56_elemento;
                            $aArrayDesdTemp['cod_planilha']     = $this->getCodPlanilha($oDespesa);
                            $aArrayDesdTemp['elementos_siops']  = $oNaturdessiopeDesd->c227_eledespsiops;
                            $aArrayDesdTemp['descricao_siops']  = $oNaturdessiopeDesd->c227_descricao;
                            $aArrayDesdTemp['campo_siops']      = $oNaturdessiopeDesd->c227_campo;
                            $aArrayDesdTemp['linha_siops']      = $oNaturdessiopeDesd->c227_linha;
                            $aArrayDesdTemp['dot_inicial']      = 0;
                            $aArrayDesdTemp['dot_atualizada']   = 0;
                            $aArrayDesdTemp['inscritas_rpnp']   = ($oDadosMes->empenhado - $oDadosMes->empenhado_estornado) - ($oDadosMes->liquidado - $oDadosMes->liquidado_estornado);
                            $aArrayDesdTemp['empenhado']        = ($oDadosMes->empenhado - $oDadosMes->empenhado_estornado);
                            $aArrayDesdTemp['liquidado']        = ($oDadosMes->liquidado - $oDadosMes->liquidado_estornado);
                            $aArrayDesdTemp['pagamento']        = ($oDadosMes->pagamento - $oDadosMes->pagamento_estornado);

                            array_push($this->aDespesas, $aArrayDesdTemp);
                        }

                    }

                }
            }
        }
        echo '<pre>';
        print_r($this->aDespesas);
        echo '</pre>';
        die();
        /**
         * Organiza despesas do ano subsequente.
         */
        if ($this->lOrcada) {

            for ($i = 0; $i < pg_numrows($resultAnoSeg); $i++) {

                $oDespesaAnoSeg = db_utils::fieldsMemory($resultAnoSeg, $i);

                if ($oDespesaAnoSeg->o58_codigo > 0) {

                    if ($oDespesaAnoSeg->o58_elemento != "") {

                        $sele_work2 = " 1=1 and o58_orgao in ({$oDespesaAnoSeg->o58_orgao}) and ( ( o58_orgao = {$oDespesaAnoSeg->o58_orgao} and o58_unidade = {$oDespesaAnoSeg->o58_unidade} ) ) and o58_funcao in ({$oDespesaAnoSeg->o58_funcao}) and o58_subfuncao in ({$oDespesaAnoSeg->o58_subfuncao}) and o58_programa in ({$oDespesaAnoSeg->o58_programa}) and o58_projativ in ({$oDespesaAnoSeg->o58_projativ}) and (o56_elemento like '" . substr($oDespesaAnoSeg->o58_elemento, 0, 7) . "%') and o58_codigo in ({$oDespesaAnoSeg->o58_codigo}) and o58_instit in ({$this->iInstit}) and o58_anousu={$this->iAnoUsu} ";
                        $cldesdobramento = new cl_desdobramento();
                        $resDepsMes = db_query($cldesdobramento->sql($sele_work2, $this->dtIni, $this->dtFim, "({$this->iInstit})", '')) or die($cldesdobramento->sql($sele_work2, $this->dtIni, $this->dtFim, "({$this->iInstit})", '') . pg_last_error());
                        $oNaturdessiope = $this->getNaturDesSiope($oDespesaAnoSeg->o58_elemento);
                        $sHashDesp = $oDespesaAnoSeg->o58_elemento;
                        $aDadosAgrupados = array();

                        if (!isset($aDadosAgrupados[$sHashDesp])) {

                            $aArrayTemp = array();

                            $aArrayTemp['o58_codigo'] = $oDespesaAnoSeg->o58_codigo;
                            $aArrayTemp['o58_subfuncao'] = $oDespesaAnoSeg->o58_subfuncao;
                            $aArrayTemp['cod_planilha'] = $this->getCodPlanilha($oDespesaAnoSeg);
                            $aArrayTemp['elemento_siope'] = $oNaturdessiope->c223_eledespecidade;
                            $aArrayTemp['descricao_siope'] = $oNaturdessiope->c223_descricao;
                            $aArrayTemp['desp_orcada'] = $oDespesaAnoSeg->dot_ini;

                            array_push($this->aDespesasAnoSeg, $aArrayTemp);

                        }

                    }

                }

            }

        }


    }

    public function getDespesas() {
        return $this->aDespesas;
    }



    /**
     * Busca as receitas conforme
     */
    public function setReceitas() {


    }

    /**
     * C�d Planilha recebe valor de acordo com fonte de recursos, subfun��o, tipo de ensino siope e tipo de pasta siope.
     */
    public function getCodPlanilha($oDespesa) {

        if ($oDespesa->o58_codigo == 100 || $oDespesa->o58_codigo == 200) {

            if (in_array($oDespesa->o58_subfuncao, array(121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131))) {
                return '3_11';
            } elseif ($oDespesa->o58_subfuncao == 301) {
                return '3_12';
            } elseif ($oDespesa->o58_subfuncao == 302) {
                return '3_13';
            } elseif ($oDespesa->o58_subfuncao == 303) {
                return '3_14';
            } elseif ($oDespesa->o58_subfuncao == 304) {
                return '3_15';
            } elseif ($oDespesa->o58_subfuncao == 305) {
                return '3_16';
            } elseif ($oDespesa->o58_subfuncao == 306) {
                return '3_17';
            } else {
                return '3_18';
            }

        } elseif($oDespesa->o58_codigo == 102 || $oDespesa->o58_codigo == 202) {

            if (in_array($oDespesa->o58_subfuncao, array(121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131))) {
                return '4_11';
            } elseif ($oDespesa->o58_subfuncao == 301) {
                return '4_12';
            } elseif ($oDespesa->o58_subfuncao == 302) {
                return '4_13';
            } elseif ($oDespesa->o58_subfuncao == 303) {
                return '4_14';
            } elseif ($oDespesa->o58_subfuncao == 304) {
                return '4_15';
            } elseif ($oDespesa->o58_subfuncao == 305) {
                return '4_16';
            } elseif ($oDespesa->o58_subfuncao == 306) {
                return '4_17';
            } else {
                return '4_18';
            }

        } elseif (in_array($oDespesa->o58_codigo, array(148, 149, 150, 151, 152, 153, 154, 159, 248, 249, 250, 251, 252, 253, 254, 259))) {

            if (in_array($oDespesa->o58_subfuncao, array(121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131))) {
                return '5_11';
            } elseif ($oDespesa->o58_subfuncao == 301) {
                return '5_12';
            } elseif ($oDespesa->o58_subfuncao == 302) {
                return '5_13';
            } elseif ($oDespesa->o58_subfuncao == 303) {
                return '5_14';
            } elseif ($oDespesa->o58_subfuncao == 304) {
                return '5_15';
            } elseif ($oDespesa->o58_subfuncao == 305) {
                return '5_16';
            } elseif ($oDespesa->o58_subfuncao == 306) {
                return '5_17';
            } else {
                return '5_18';
            }

        } elseif($oDespesa->o58_codigo == 155 || $oDespesa->o58_codigo == 255) {

            if (in_array($oDespesa->o58_subfuncao, array(121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131))) {
                return '6_11';
            } elseif ($oDespesa->o58_subfuncao == 301) {
                return '6_12';
            } elseif ($oDespesa->o58_subfuncao == 302) {
                return '6_13';
            } elseif ($oDespesa->o58_subfuncao == 303) {
                return '6_14';
            } elseif ($oDespesa->o58_subfuncao == 304) {
                return '6_15';
            } elseif ($oDespesa->o58_subfuncao == 305) {
                return '6_16';
            } elseif ($oDespesa->o58_subfuncao == 306) {
                return '6_17';
            } else {
                return '6_18';
            }

        } elseif($oDespesa->o58_codigo == 123 || $oDespesa->o58_codigo == 223) {

            if (in_array($oDespesa->o58_subfuncao, array(121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131))) {
                return '7_11';
            } elseif ($oDespesa->o58_subfuncao == 301) {
                return '7_12';
            } elseif ($oDespesa->o58_subfuncao == 302) {
                return '7_13';
            } elseif ($oDespesa->o58_subfuncao == 303) {
                return '7_14';
            } elseif ($oDespesa->o58_subfuncao == 304) {
                return '7_15';
            } elseif ($oDespesa->o58_subfuncao == 305) {
                return '7_16';
            } elseif ($oDespesa->o58_subfuncao == 306) {
                return '7_17';
            } else {
                return '7_18';
            }

        } elseif($oDespesa->o58_codigo == 190 || $oDespesa->o58_codigo == 191 || $oDespesa->o58_codigo == 290 || $oDespesa->o58_codigo == 291) {

            if (in_array($oDespesa->o58_subfuncao, array(121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131))) {
                return '8_11';
            } elseif ($oDespesa->o58_subfuncao == 301) {
                return '8_12';
            } elseif ($oDespesa->o58_subfuncao == 302) {
                return '8_13';
            } elseif ($oDespesa->o58_subfuncao == 303) {
                return '8_14';
            } elseif ($oDespesa->o58_subfuncao == 304) {
                return '8_15';
            } elseif ($oDespesa->o58_subfuncao == 305) {
                return '8_16';
            } elseif ($oDespesa->o58_subfuncao == 306) {
                return '8_17';
            } else {
                return '8_18';
            }

        } else {

            if (in_array($oDespesa->o58_subfuncao, array(121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131))) {
                return '10_11';
            } elseif ($oDespesa->o58_subfuncao == 301) {
                return '10_12';
            } elseif ($oDespesa->o58_subfuncao == 302) {
                return '10_13';
            } elseif ($oDespesa->o58_subfuncao == 303) {
                return '10_14';
            } elseif ($oDespesa->o58_subfuncao == 304) {
                return '10_15';
            } elseif ($oDespesa->o58_subfuncao == 305) {
                return '10_16';
            } elseif ($oDespesa->o58_subfuncao == 306) {
                return '10_17';
            } else {
                return '10_18';
            }

        }

    }


    /**
     * Realiza De/Para da Natureza da despesa com tabela eledessiope composta pelo C�d Elemento e Descri��o
     */
    public function getNaturDesSiops($elemento) {

        $clnaturdessiops    = new cl_naturdessiops();
        $rsNaturdessiops    = db_query($clnaturdessiops->sql_query_siops(substr($elemento, 1, 10),"", $this->iAnoUsu));

        if (pg_num_rows($rsNaturdessiops) > 0) {
            $oNaturdessiops = db_utils::fieldsMemory($rsNaturdessiops, 0);
            return $oNaturdessiops;
        } else {
            $this->status = 2;
            if (strpos($this->sMensagem, $elemento) === false){
                $this->sMensagem .= "{$elemento} ";
            }
        }

    }

    /**
     * Realiza De/Para da Natureza da despesa com tabela elerecsiope composta pela Natureza Receita e Descri��o
     */
    public function getNaturRecSiops($natureza) {


//        $clnaturrecsiope    = new cl_naturrecsiope();
//        $rsNaturrecsiope    = db_query($clnaturrecsiope->sql_query_siope(substr($natureza, 0, 15),"", $this->iAnoUsu));
//
//        if (pg_num_rows($rsNaturrecsiope) > 0) {
//            $oNaturrecsiope = db_utils::fieldsMemory($rsNaturrecsiope, 0);
//            return $oNaturrecsiope;
//        } else {
//            $this->status = 2;
//            if (strpos($this->sMensagem, $natureza) === false){
//                $this->sMensagem .= "{$natureza} ";
//            }
//        }

    }

    /**
     * Se 6� bimestre, set true para buscar os valores dos anos seguintes.
     */
    public function setOrcado() {

        if($this->iBimestre == 6) {
            $this->lOrcada = true;
        } else {
            $this->lOrcada = false;
        }

    }

    public function getElementoFormat($elemento) {
//        return substr($elemento, 0, 1).".".substr($elemento, 1, 2).".".substr($elemento, 3, 2).".".substr($elemento, 5, 2).".".substr($elemento, 7, 2).".".substr($elemento, 9, 2);
    }

    public function getNaturezaFormat($natureza) {
//        return substr($natureza, 0, 1).".".substr($natureza, 1, 2).".".substr($natureza, 3, 2).".".substr($natureza, 5, 2).".".substr($natureza, 7, 2).".".substr($natureza, 9, 2);
    }


}