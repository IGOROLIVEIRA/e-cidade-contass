<?php

require_once("classes/db_orcorgao_classe.php");
require_once("classes/db_orcdotacao_classe.php");
require_once("classes/db_orcreceita_classe.php");
require_once("classes/db_naturdessiops_classe.php");
require_once("classes/db_naturrecsiops_classe.php");
require_once("libs/db_liborcamento.php");
require_once("libs/db_libcontabilidade.php");


class Siops {

    //@var string
    public $sInstit;
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
    //@var array
    public $aNomesArquivos;
    //@var integer
    public $iErroSQL;
    //@var integer
    public $status;
    //@var string
    public $sMensagem;


    public function gerarSiopsDespesa() {

        if (file_exists("model/contabilidade/arquivos/siops/".db_getsession("DB_anousu")."/SiopsIMPT.model.php")) {

            require_once("model/contabilidade/arquivos/siops/" . db_getsession("DB_anousu") . "/SiopsIMPT.model.php");

            $iContador = 1;

            foreach ($this->aDespesasAgrupadasFinal as $cod_plan => $aDados) {

                $sContador = str_pad($iContador++, 2, '0', STR_PAD_LEFT);

                $sNomeArquivo = $sContador .'_'. str_replace(" ","_",preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($this->getNomeArquivoByCod($cod_plan)))));
                $this->setNomesArquivos($sNomeArquivo);
                $impt = new SiopeIMPT;
                $impt->setNomeArquivo($sNomeArquivo);
                $impt->gerarArquivoIMPT($aDados, 1);

            }

        }

    }

    public function gerarSiopsReceita() {

        $aDados = $this->aReceitasAgrupadasFinal;

        if (file_exists("model/contabilidade/arquivos/siops/".db_getsession("DB_anousu")."/SiopsIMPT.model.php")) {

            require_once("model/contabilidade/arquivos/siops/" . db_getsession("DB_anousu") . "/SiopsIMPT.model.php");

            $impt = new SiopeIMPT;
            $impt->setNomeArquivo($this->getNomeArquivo());
            $impt->gerarArquivoIMPT($aDados, 2);

        }

    }

    public function getNomeArquivoByCod($cod_plan) {

        $sql = "select c228_nomearquivo from nomearqdessiops where (c228_codplanilha, c228_anousu) = ('$cod_plan', $this->iAnoUsu)";
        $result = db_query($sql);

        if (pg_num_rows($result) > 0) {
            return db_utils::fieldsMemory($result, 0)->c228_nomearquivo;
        } else {
            return 'Siops genérico';
        }

    }

    public function setNomeArquivo($sNomeArquivo) {
        $this->sNomeArquivo = $sNomeArquivo;
    }

    public function getNomeArquivo() {
        return $this->sNomeArquivo;
    }

    public function setNomesArquivos($sNomeArquivo) {

        $this->aNomesArquivos[] = $sNomeArquivo;

    }

    public function getNomesArquivos() {
        return $this->aNomesArquivos;
    }

    public function setAno($iAnoUsu) {
        $this->iAnoUsu = $iAnoUsu;
    }

    public function setInstit() {

        $sql = 'select id_instit 
                    from db_config 
                        join db_userinst on db_config.codigo = db_userinst.id_instit 
                        join db_usuarios on db_usuarios.id_usuario=db_userinst.id_usuario 
                    where db_usuarios.id_usuario = '.db_getsession("DB_id_usuario");

        $result = db_query($sql);

        if (pg_num_rows($result) > 0) {

            for ($i = 0; $i < pg_numrows($result); $i++) {
                $filtro .= db_utils::fieldsMemory($result, $i)->id_instit;
                if($i+1 < pg_num_rows($result)) {
                    $filtro .= '-';
                }
            }
        }

        $this->sInstit = $filtro;

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
     * Adiciona filtros da instituição, função 12 (Educação) e todos os orgãos
     */
    public function setFiltrosDespesa() {

        $clorcorgao       = new cl_orcorgao;
        $instits          = str_replace('-', ', ', $this->sInstit);
        $result           = db_query($clorcorgao->sql_query_file('', '', 'o40_orgao', 'o40_orgao asc', 'o40_instit in ('.$instits.') and o40_anousu = '.$this->iAnoUsu));
        $this->sFiltros    = "instit_{$this->sInstit}-funcao_10-";

        if (pg_num_rows($result) > 0) {
            for ($i = 0; $i < pg_numrows($result); $i++) {
                $this->sFiltros .= "orgao_".db_utils::fieldsMemory($result, $i)->o40_orgao."-";
            }
        } else {
            $this->sFiltros = 'geral';
        }

    }

    /**
     * Adiciona filtros de todas as instituições
     */
    public function setFiltrosReceita() {

        $sql = 'select id_instit 
                    from db_config 
                        join db_userinst on db_config.codigo = db_userinst.id_instit 
                        join db_usuarios on db_usuarios.id_usuario=db_userinst.id_usuario 
                    where db_usuarios.id_usuario = '.db_getsession("DB_id_usuario");

        $result = db_query($sql);

        if (pg_num_rows($result) > 0) {
            $filtro = 'o70_instit in (';

            for ($i = 0; $i < pg_numrows($result); $i++) {
                $filtro .= db_utils::fieldsMemory($result, $i)->id_instit;
                if($i+1 < pg_num_rows($result)) {
                    $filtro .= ',';
                }
            }
            $filtro .= ')';
        }

        $this->sFiltros = $filtro;

    }

    /**
     * Retorna datas correspondente ao período do bimestre, sempre cumulativo.
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

        $instits          = str_replace('-', ', ', $this->sInstit);
        $sele_work  = $clselorcdotacao->getDados(false, true) . " and o58_instit in ($instits) and  o58_anousu=$this->iAnoUsu  ";
        $sqlprinc   = db_dotacaosaldo(8, 1, 4, true, $sele_work, $this->iAnoUsu, $this->dtIni, $this->dtFim, 8, 0, true);
        $result     = db_query($sqlprinc) or die(pg_last_error());

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

                    $sele_work2         = " 1=1 and o58_orgao in ({$oDespesa->o58_orgao}) and ( ( o58_orgao = {$oDespesa->o58_orgao} and o58_unidade = {$oDespesa->o58_unidade} ) ) and o58_funcao in ({$oDespesa->o58_funcao}) and o58_subfuncao in ({$oDespesa->o58_subfuncao}) and o58_programa in ({$oDespesa->o58_programa}) and o58_projativ in ({$oDespesa->o58_projativ}) and (o56_elemento like '" . substr($oDespesa->o58_elemento, 0, 7) . "%') and o58_codigo in ({$oDespesa->o58_codigo}) and o58_instit in ({$instits}) and o58_anousu={$this->iAnoUsu} ";
                    $cldesdobramento    = new cl_desdobramento();
                    $resDepsMes         = db_query($cldesdobramento->sql($sele_work2, $this->dtIni, $this->dtFim, "({$instits})",'')) or die($cldesdobramento->sql($sele_work2, $this->dtIni, $this->dtFim, "({$instits})",'') . pg_last_error());
                    $oNaturdessiope     = $this->getNaturDesSiops($oDespesa->o58_elemento);
                    $sHashDesp          = $oDespesa->o58_elemento;
                    $aDadosAgrupados    = array();

                    if (!isset($aDadosAgrupados[$sHashDesp])) {

                        $aArrayTemp     = array();

                        $aArrayTemp['cod_planilha']     = $this->getCodPlanilha($oDespesa);
                        $aArrayTemp['elemento_siops']   = $oNaturdessiope->c227_eledespsiops;
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

                            $aArrayDesdTemp['cod_planilha']     = $this->getCodPlanilha($oDespesa);
                            $aArrayDesdTemp['elemento_siops']   = $oNaturdessiopeDesd->c227_eledespsiops;
                            $aArrayDesdTemp['campo_siops']      = $oNaturdessiopeDesd->c227_campo;
                            $aArrayDesdTemp['linha_siops']      = $oNaturdessiopeDesd->c227_linha;
                            $aArrayDesdTemp['dot_inicial']      = 0;
                            $aArrayDesdTemp['dot_atualizada']   = 0;
                            $aArrayDesdTemp['inscritas_rpnp']   = $this->lOrcada ? round((round(($oDadosMes->empenhado - $oDadosMes->empenhado_estornado), 2) - round(($oDadosMes->liquidado - $oDadosMes->liquidado_estornado), 2)), 2) : 0;
                            $aArrayDesdTemp['empenhado']        = ($oDadosMes->empenhado - $oDadosMes->empenhado_estornado);
                            $aArrayDesdTemp['liquidado']        = ($oDadosMes->liquidado - $oDadosMes->liquidado_estornado);
                            $aArrayDesdTemp['pagamento']        = ($oDadosMes->pagamento - $oDadosMes->pagamento_estornado);

                            array_push($this->aDespesas, $aArrayDesdTemp);

                        } else {

                            $aArrayDesdTemp = array();

                            $aArrayDesdTemp['cod_planilha']     = $this->getCodPlanilha($oDespesa);
                            $aArrayDesdTemp['elemento_siops']   = $oNaturdessiopeDesd->c227_eledespsiops;
                            $aArrayDesdTemp['campo_siops']      = $oNaturdessiopeDesd->c227_campo;
                            $aArrayDesdTemp['linha_siops']      = $oNaturdessiopeDesd->c227_linha;
                            $aArrayDesdTemp['dot_inicial']      = 0;
                            $aArrayDesdTemp['dot_atualizada']   = 0;
                            $aArrayDesdTemp['inscritas_rpnp']   = $this->lOrcada ? round((round(($oDadosMes->empenhado - $oDadosMes->empenhado_estornado), 2) - round(($oDadosMes->liquidado - $oDadosMes->liquidado_estornado), 2)), 2) : 0;
                            $aArrayDesdTemp['empenhado']        = ($oDadosMes->empenhado - $oDadosMes->empenhado_estornado);
                            $aArrayDesdTemp['liquidado']        = ($oDadosMes->liquidado - $oDadosMes->liquidado_estornado);
                            $aArrayDesdTemp['pagamento']        = ($oDadosMes->pagamento - $oDadosMes->pagamento_estornado);

                            array_push($this->aDespesas, $aArrayDesdTemp);
                        }

                    }

                }

            }

        }

        /**
         * Organiza despesas do ano subsequente.
         */
        if ($this->lOrcada) {

            /**
             * Caso seja 6º Bimestre, campo ORÇADO será alimentado através do relatório Balancete da Despesa no exercício subsequente ao de referência.
             */
            $iAnoSeg          = $this->iAnoUsu+1;
            $sele_workAnoSeg  = $clselorcdotacao->getDados(false, true) . " and o58_instit in ($instits) and  o58_anousu=$iAnoSeg  ";
            $sqlprincAnoSeg   = db_dotacaosaldo(8, 1, 4, true, $sele_workAnoSeg, $iAnoSeg, "$iAnoSeg-01-01", "$iAnoSeg-01-01", 8, 0, true);
            $resultAnoSeg     = db_query($sqlprincAnoSeg) or die(pg_last_error());

            for ($i = 0; $i < pg_numrows($resultAnoSeg); $i++) {

                $oDespesaAnoSeg = db_utils::fieldsMemory($resultAnoSeg, $i);

                if ($oDespesaAnoSeg->o58_codigo > 0) {

                    if ($oDespesaAnoSeg->o58_elemento != "") {

                        $sele_work2 = " 1=1 and o58_orgao in ({$oDespesaAnoSeg->o58_orgao}) and ( ( o58_orgao = {$oDespesaAnoSeg->o58_orgao} and o58_unidade = {$oDespesaAnoSeg->o58_unidade} ) ) and o58_funcao in ({$oDespesaAnoSeg->o58_funcao}) and o58_subfuncao in ({$oDespesaAnoSeg->o58_subfuncao}) and o58_programa in ({$oDespesaAnoSeg->o58_programa}) and o58_projativ in ({$oDespesaAnoSeg->o58_projativ}) and (o56_elemento like '" . substr($oDespesaAnoSeg->o58_elemento, 0, 7) . "%') and o58_codigo in ({$oDespesaAnoSeg->o58_codigo}) and o58_instit in ({$instits}) and o58_anousu={$this->iAnoUsu} ";
                        $cldesdobramento = new cl_desdobramento();
                        $resDepsMes = db_query($cldesdobramento->sql($sele_work2, $this->dtIni, $this->dtFim, "({$instits})", '')) or die($cldesdobramento->sql($sele_work2, $this->dtIni, $this->dtFim, "({$instits})", '') . pg_last_error());
                        $oNaturdessiops = $this->getNaturDesSiops($oDespesaAnoSeg->o58_elemento);
                        $sHashDesp = $oDespesaAnoSeg->o58_elemento;
                        $aDadosAgrupados = array();

                        if (!isset($aDadosAgrupados[$sHashDesp])) {

                            $aArrayTemp = array();

                            $aArrayTemp['cod_planilha']     = $this->getCodPlanilha($oDespesaAnoSeg);
                            $aArrayTemp['elemento_siops']   = $oNaturdessiops->c227_eledespsiops;
                            $aArrayTemp['campo_siops']      = $oNaturdessiops->c227_campo;
                            $aArrayTemp['linha_siops']      = $oNaturdessiops->c227_linha;
                            $aArrayTemp['desp_orcada']      = $oDespesaAnoSeg->dot_ini;

                            array_push($this->aDespesasAnoSeg, $aArrayTemp);

                        }

                    }

                }

            }

        }

    }

    /**
     * Agrupa despesas somando valores pelo CÓDIGO DE PLANILHA e ELEMENTO DA DESPESA iguais.
     */
    public function agrupaDespesas() {

        $aDespAgrup = array();

        foreach ($this->aDespesas as $row) {

            list($cod_planilha, $elemento_siops, $campo_siops, $linha_siops, $dot_inicial, $dot_atualizada, $inscritas_rpnp, $empenhado, $liquidado, $pagamento) = array_values($row);

            $iSubTotalDotIni = isset($aDespAgrup[$cod_planilha][$elemento_siops]['dot_inicial']) ? $aDespAgrup[$cod_planilha][$elemento_siops]['dot_inicial'] : 0;
            $iSubTotalDotAtu = isset($aDespAgrup[$cod_planilha][$elemento_siops]['dot_atualizada']) ? $aDespAgrup[$cod_planilha][$elemento_siops]['dot_atualizada'] : 0;
            $iSubTotalInsc   = isset($aDespAgrup[$cod_planilha][$elemento_siops]['inscritas_rpnp']) ? $aDespAgrup[$cod_planilha][$elemento_siops]['inscritas_rpnp'] : 0;
            $iSubTotalEmp    = isset($aDespAgrup[$cod_planilha][$elemento_siops]['empenhado']) ? $aDespAgrup[$cod_planilha][$elemento_siops]['empenhado'] : 0;
            $iSubTotalLiq    = isset($aDespAgrup[$cod_planilha][$elemento_siops]['liquidado']) ? $aDespAgrup[$cod_planilha][$elemento_siops]['liquidado'] : 0;
            $iSubTotalPag    = isset($aDespAgrup[$cod_planilha][$elemento_siops]['pagamento']) ? $aDespAgrup[$cod_planilha][$elemento_siops]['pagamento'] : 0;

            $aDespAgrup[$cod_planilha][$elemento_siops]['cod_planilha']     = $cod_planilha;
            $aDespAgrup[$cod_planilha][$elemento_siops]['elemento_siops']   = $elemento_siops;
            $aDespAgrup[$cod_planilha][$elemento_siops]['campo_siops']      = $campo_siops;
            $aDespAgrup[$cod_planilha][$elemento_siops]['linha_siops']      = $linha_siops;
            $aDespAgrup[$cod_planilha][$elemento_siops]['dot_inicial']      = ($iSubTotalDotIni + $dot_inicial);
            $aDespAgrup[$cod_planilha][$elemento_siops]['dot_atualizada']   = ($iSubTotalDotAtu + $dot_atualizada);
            $aDespAgrup[$cod_planilha][$elemento_siops]['inscritas_rpnp']   = ($iSubTotalInsc + $inscritas_rpnp);
            $aDespAgrup[$cod_planilha][$elemento_siops]['empenhado']        = ($iSubTotalEmp + $empenhado);
            $aDespAgrup[$cod_planilha][$elemento_siops]['liquidado']        = ($iSubTotalLiq + $liquidado);
            $aDespAgrup[$cod_planilha][$elemento_siops]['pagamento']        = ($iSubTotalPag + $pagamento);
            $aDespAgrup[$cod_planilha][$elemento_siops]['desp_orcada']      = 0;

        }

        if ($this->lOrcada) {

            $aDespAgrupAnoSeg = array();

            foreach ($this->aDespesasAnoSeg as $row) {

                list($cod_planilha, $elemento_siops, $campo_siops, $linha_siops, $desp_orcada) = array_values($row);

                $iSubTotalDespOrc = isset($aDespAgrupAnoSeg[$cod_planilha][$elemento_siops]['desp_orcada']) ? $aDespAgrupAnoSeg[$cod_planilha][$elemento_siops]['desp_orcada'] : 0;

                $aDespAgrupAnoSeg[$cod_planilha][$elemento_siops]['cod_planilha']      = $cod_planilha;
                $aDespAgrupAnoSeg[$cod_planilha][$elemento_siops]['elemento_siops']    = $elemento_siops;
                $aDespAgrupAnoSeg[$cod_planilha][$elemento_siops]['campo_siops']       = $campo_siops;
                $aDespAgrupAnoSeg[$cod_planilha][$elemento_siops]['linha_siops']       = $linha_siops;
                $aDespAgrupAnoSeg[$cod_planilha][$elemento_siops]['desp_orcada']       = ($iSubTotalDespOrc + $desp_orcada);

            }

            /**
             * Une os dois arrays do ano corrente com o ano seguinte.
             * ***Pode haver registros no ano seguinte que não estão no ano corrente.***
             */

            foreach ($aDespAgrup as $cod => $despesa) {

                foreach ($despesa as $elem => $desp) {

                    if (isset($aDespAgrupAnoSeg[$cod][$elem])) {
                        $desp['desp_orcada'] = $aDespAgrupAnoSeg[$cod][$elem]['desp_orcada'];
                        $aDespAgrupAnoSeg[$cod][$elem]['flag'] = 1;
                        $this->aDespesasAgrupadasFinal[$cod][$elem] = $desp;
                    } else {
                        $aDespAgrupAnoSeg[$cod][$elem]['flag'] = 1;
                        $desp['desp_orcada'] = 0;
                        $this->aDespesasAgrupadasFinal[$cod][$elem] = $desp;
                    }

                }

            }

            foreach ($aDespAgrupAnoSeg as $cod => $despesa) {

                foreach ($despesa as $elem => $desp) {

                    if (!isset($desp['flag']) || $desp['flag'] != 1) {
                        $desp['dot_inicial'] = $aDespAgrup[$cod][$elem]['dot_inicial'];
                        $desp['dot_atualizada'] = $aDespAgrup[$cod][$elem]['dot_atualizada'];
                        $desp['inscritas_rpnp'] = $aDespAgrup[$cod][$elem]['inscritas_rpnp'];
                        $desp['empenhado'] = $aDespAgrup[$cod][$elem]['empenhado'];
                        $desp['liquidado'] = $aDespAgrup[$cod][$elem]['liquidado'];
                        $desp['pagamento'] = $aDespAgrup[$cod][$elem]['pagamento'];
                        $this->aDespesasAgrupadasFinal[$cod][$elem] = $desp;
                    }

                }

            }

        } else {

            $this->aDespesasAgrupadasFinal = $aDespAgrup;

        }

    }

    public function agrupaReceitas() {

        $aReceitaAgrup = array();

        foreach ($this->aReceitas as $row) {

            list($rec_realizada, $ded_receita, $rec_asps, $ded_fundeb, $natureza, $campo, $linha, $prev_inicial, $prev_atualizada, $total_receitas) = array_values($row);

            $iSubRecRealizada       = isset($aReceitaAgrup[$natureza]['rec_realizada']) ? $aReceitaAgrup[$natureza]['rec_realizada'] : 0;
            $iSubDedReceita         = isset($aReceitaAgrup[$natureza]['ded_receita']) ? $aReceitaAgrup[$natureza]['ded_receita'] : 0;
            $iSubRecAsps            = isset($aReceitaAgrup[$natureza]['rec_asps']) ? $aReceitaAgrup[$natureza]['rec_asps'] : 0;
            $iSubDedFundeb          = isset($aReceitaAgrup[$natureza]['ded_fundeb']) ? $aReceitaAgrup[$natureza]['ded_fundeb'] : 0;
            $iSubPrevInicial        = isset($aReceitaAgrup[$natureza]['prev_inicial']) ? $aReceitaAgrup[$natureza]['prev_inicial'] : 0;
            $iSubPrevAtualizada     = isset($aReceitaAgrup[$natureza]['prev_atualizada']) ? $aReceitaAgrup[$natureza]['prev_atualizada'] : 0;
            $iSubTotReceitas        = isset($aReceitaAgrup[$natureza]['total_receitas']) ? $aReceitaAgrup[$natureza]['total_receitas'] : 0;

            $aReceitaAgrup[$natureza]['rec_realizada']      = ($iSubRecRealizada + $rec_realizada);
            $aReceitaAgrup[$natureza]['ded_receita']        = ($iSubDedReceita + $ded_receita);
            $aReceitaAgrup[$natureza]['rec_asps']           = ($iSubRecAsps + $rec_asps);
            $aReceitaAgrup[$natureza]['ded_fundeb']         = ($iSubDedFundeb + $ded_fundeb);
            $aReceitaAgrup[$natureza]['prev_inicial']       = ($iSubPrevInicial + $prev_inicial);
            $aReceitaAgrup[$natureza]['prev_atualizada']    = ($iSubPrevAtualizada + $prev_atualizada);
            $aReceitaAgrup[$natureza]['total_receitas']     = ($iSubTotReceitas + $total_receitas);
            $aReceitaAgrup[$natureza]['natureza']           = $natureza;
            $aReceitaAgrup[$natureza]['campo']              = $campo;
            $aReceitaAgrup[$natureza]['linha']              = $linha;
            $aReceitaAgrup[$natureza]['rec_orcada']         = 0;

        }

        if ($this->lOrcada) {

            $aRecAgrupAnoSeg = array();

            foreach ($this->aReceitasAnoSeg as $row) {

                list($natureza, $campo, $linha, $rec_orcada) = array_values($row);

                $iSubTotalRecOrc = isset($aRecAgrupAnoSeg[$natureza]['rec_orcada']) ? $aRecAgrupAnoSeg[$natureza]['rec_orcada'] : 0;

                $aRecAgrupAnoSeg[$natureza]['natureza']     = $natureza;
                $aRecAgrupAnoSeg[$natureza]['campo']        = $campo;
                $aRecAgrupAnoSeg[$natureza]['linha']        = $linha;
                $aRecAgrupAnoSeg[$natureza]['rec_orcada']   = ($iSubTotalRecOrc + $rec_orcada);

            }

            /**
             * Une os dois arrays do ano corrente com o ano seguinte.
             * ***Pode haver registros no ano seguinte que não estão no ano corrente.***
             */

            foreach ($aReceitaAgrup as $cod => $receita) {

                if (isset($aRecAgrupAnoSeg[$cod])) {
                    $receita['rec_orcada']                  = $aRecAgrupAnoSeg[$cod]['rec_orcada'];
                    $aRecAgrupAnoSeg[$cod]['flag']          = 1;
                    $this->aReceitasAgrupadasFinal[$cod]    = $receita;
                } else {
                    $aRecAgrupAnoSeg[$cod]['flag']          = 1;
                    $receita['rec_orcada']                  = 0;
                    $this->aReceitasAgrupadasFinal[$cod]    = $receita;
                }

            }

            foreach ($aRecAgrupAnoSeg as $cod => $receita) {

                if (!isset($receita['flag']) || $receita['flag'] != 1) {
                    $receita['rec_realizada']               = $aReceitaAgrup[$cod]['rec_realizada'];
                    $receita['ded_receita']                 = $aReceitaAgrup[$cod]['ded_receita'];
                    $receita['rec_asps']                    = $aReceitaAgrup[$cod]['rec_asps'];
                    $receita['ded_fundeb']                  = $aReceitaAgrup[$cod]['ded_fundeb'];
                    $receita['prev_inicial']                = $aReceitaAgrup[$cod]['prev_inicial'];
                    $receita['prev_atualizada']             = $aReceitaAgrup[$cod]['prev_atualizada'];
                    $receita['total_receitas']              = $aReceitaAgrup[$cod]['total_receitas'];
                    $this->aReceitasAgrupadasFinal[$cod]    = $receita;
                }

            }

        } else {

            $this->aReceitasAgrupadasFinal = $aReceitaAgrup;

        }

    }

    public function getDespesas() {
        return $this->aDespesas;
    }

    /**
     * Busca as receitas conforme
     */
    public function setReceitas() {

        $result = db_receitasaldo(11,1,3,true,$this->sFiltros,$this->iAnoUsu,$this->dtIni,$this->dtFim,false,' * ',true,0);

        for ($i = 0; $i < pg_num_rows($result); $i++) {

            $oReceita = db_utils::fieldsMemory($result, $i);
            
            if ($oReceita->o70_codrec > 0) {
                
                $oNaturrecsiops = $this->getNaturRecSiops($oReceita->o57_fonte);

                $aReceita = array();

                $aReceita['rec_realizada']      = 0;
                $aReceita['ded_receita']        = 0;
                $aReceita['rec_asps']           = 0;
                $aReceita['ded_fundeb']         = 0;

                if(in_array(substr($oReceita->o57_fonte, 0, 2), array('41', '42', '47', '48'))) {
                    $aReceita['rec_realizada']  = abs($oReceita->saldo_arrecadado);
                }

                if(in_array(substr($oReceita->o57_fonte, 0, 3), array('491', '492', '493', '496', '498', '499'))) {
                    $aReceita['ded_receita']    = abs($oReceita->saldo_arrecadado);
                }

                if(in_array($oNaturrecsiops->c231_elerecsiops, array('11120100', '11120200', '11120431', '11120434', '11120800', '11130501', '11130502', '11130600', '17210102', '17210105', '17213600', '17220101', '17220102', '17220104', '19110800', '19113800', '19113900', '19114000', '19114400', '19130800', '19131100', '19131200', '19131300', '19132500', '19310400', '19311100', '19311200', '19311300', '19312100', '71120100', '71120400', '71130600'))) {
                    $aReceita['rec_asps']       = abs(($aReceita['rec_realizada'] - $aReceita['ded_receita']));
                }

                if(substr($oReceita->o57_fonte, 0, 3) == '495') {
                    $aReceita['ded_fundeb']     = abs($oReceita->saldo_arrecadado);
                }

                $aReceita['natureza']           = $oNaturrecsiops->c231_elerecsiops;
                $aReceita['campo']              = $oNaturrecsiops->c231_campo;
                $aReceita['linha']              = $oNaturrecsiops->c231_linha;
                $aReceita['prev_inicial']       = $oReceita->saldo_inicial;
                $aReceita['prev_atualizada']    = ($oReceita->saldo_inicial + $oReceita->saldo_prevadic_acum);
                $aReceita['total_receitas']     = ($aReceita['rec_realizada'] - ($aReceita['ded_receita'] + $aReceita['ded_fundeb']));

                array_push($this->aReceitas, $aReceita);

            }

        }

        /**
         * Caso seja 6º Bimestre, campo ORÇADO será alimentado através do relatório Balancete da Receita no exercício subsequente ao de referência.
         */
        if ($this->lOrcada) {

            db_query('drop table work_receita');
            $iAnoSeg = $this->iAnoUsu+1;
            $resultAnoSeg = db_receitasaldo(11, 1, 3, true, $this->sFiltros, $iAnoSeg, "{$iAnoSeg}-01-01", "{$iAnoSeg}-01-01", false, ' * ', true, 0);

            for ($i = 0; $i < pg_num_rows($resultAnoSeg); $i++) {

                $oReceitaAnoSeg = db_utils::fieldsMemory($resultAnoSeg, $i);

                if ($oReceitaAnoSeg->o70_codrec > 0) {

                    $oNaturrecsiops = $this->getNaturRecSiops($oReceitaAnoSeg->o57_fonte);

                    $aReceitaAnoSeg = array();

                    $aReceitaAnoSeg['natureza']     = $oNaturrecsiops->c231_elerecsiops;
                    $aReceitaAnoSeg['campo']        = $oNaturrecsiops->c231_campo;
                    $aReceitaAnoSeg['linha']        = $oNaturrecsiops->c231_linha;
                    $aReceitaAnoSeg['rec_orcada']   = $oReceitaAnoSeg->saldo_inicial;

                    array_push($this->aReceitasAnoSeg, $aReceitaAnoSeg);

                }

            }

        }

    }

    /**
     * Cód Planilha recebe valor de acordo com fonte de recursos, subfunção, tipo de ensino siope e tipo de pasta siope.
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

        } elseif (in_array($oDespesa->o58_codigo, array(153, 154, 159, 161, 253, 254, 259, 261))) { 

            if (in_array($oDespesa->o58_codigo, array(154, 159, 254, 259)) && strpos(strtolower($oDespesa->o55_descr), 'covid')) {
                if (in_array($oDespesa->o58_subfuncao, array(121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131))) {
                    return '87_11';
                }elseif ($oDespesa->o58_subfuncao == 301) {
                    return '87_12';
                }elseif ($oDespesa->o58_subfuncao == 302) {
                    return '87_13';
                }elseif ($oDespesa->o58_subfuncao == 303) {
                    return '87_14';
                }elseif ($oDespesa->o58_subfuncao == 304) {
                    return '87_15';
                }elseif ($oDespesa->o58_subfuncao == 305) {
                    return '87_16';
                }elseif ($oDespesa->o58_subfuncao == 306) {
                    return '87_17';
                }else {
                    return '87_18';
                }
                
            } elseif (in_array($oDespesa->o58_codigo, array(154, 159, 254, 259))) {
                if (in_array($oDespesa->o58_subfuncao, array(121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131))) {
                    return '86_11';
                }elseif ($oDespesa->o58_subfuncao == 301) {
                    return '86_12';
                }elseif ($oDespesa->o58_subfuncao == 302) {
                    return '86_13';
                }elseif ($oDespesa->o58_subfuncao == 303) {
                    return '86_14';
                }elseif ($oDespesa->o58_subfuncao == 304) {
                    return '86_15';
                }elseif ($oDespesa->o58_subfuncao == 305) {
                    return '86_16';
                }elseif ($oDespesa->o58_subfuncao == 306) {
                    return '86_17';
                }else {
                    return '86_18';
                }

            } elseif (in_array($oDespesa->o58_codigo, array(153, 253)) && strpos(strtolower($oDespesa->o55_descr), 'covid')) {
                if (in_array($oDespesa->o58_subfuncao, array(121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131))) {
                    return '89_11';
                }elseif ($oDespesa->o58_subfuncao == 301) {
                    return '89_12';
                }elseif ($oDespesa->o58_subfuncao == 302) {
                    return '89_13';
                }elseif ($oDespesa->o58_subfuncao == 303) {
                    return '89_14';
                }elseif ($oDespesa->o58_subfuncao == 304) {
                    return '89_15';
                }elseif ($oDespesa->o58_subfuncao == 305) {
                    return '89_16';
                }elseif ($oDespesa->o58_subfuncao == 306) {
                    return '89_17';
                }else {
                    return '89_18';
                }

            } elseif (in_array($oDespesa->o58_codigo, array(153, 253))) {
                if (in_array($oDespesa->o58_subfuncao, array(121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131))) {
                    return '88_11';
                }elseif ($oDespesa->o58_subfuncao == 301) {
                    return '88_12';
                }elseif ($oDespesa->o58_subfuncao == 302) {
                    return '88_13';
                }elseif ($oDespesa->o58_subfuncao == 303) {
                    return '88_14';
                }elseif ($oDespesa->o58_subfuncao == 304) {
                    return '88_15';
                }elseif ($oDespesa->o58_subfuncao == 305) {
                    return '88_16';
                }elseif ($oDespesa->o58_subfuncao == 306) {
                    return '88_17';
                }else {
                    return '88_18';
                }

            } elseif (in_array($oDespesa->o58_codigo, array(161, 261)) && $oDespesa->o58_funcao == '10') {
                if (in_array($oDespesa->o58_subfuncao, array(121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131))) {
                    return '90_11';
                }elseif ($oDespesa->o58_subfuncao == 301) {
                    return '90_12';
                }elseif ($oDespesa->o58_subfuncao == 302) {
                    return '90_13';
                }elseif ($oDespesa->o58_subfuncao == 303) {
                    return '90_14';
                }elseif ($oDespesa->o58_subfuncao == 304) {
                    return '90_15';
                }elseif ($oDespesa->o58_subfuncao == 305) {
                    return '90_16';
                }elseif ($oDespesa->o58_subfuncao == 306) {
                    return '90_17';
                }else {
                    return '90_18';
                }
            
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
     * Realiza De/Para da Natureza da despesa com tabela eledessiope composta pelo Cód Elemento e Descrição
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
     * Realiza De/Para da Natureza da despesa com tabela elerecsiops composta pela Natureza Receita e Descrição
     */
    public function getNaturRecSiops($natureza)
    {
        $sSqlNatRec = "SELECT c231_elerecsiops, c231_campo, c231_linha FROM elerecsiops
                       WHERE c231_anousu = {$this->iAnoUsu}
                         AND substr(c231_elerecsiops,1,length(rtrim(c231_elerecsiops,'0'))) = substr('{$natureza}',2,length(rtrim(c231_elerecsiops,'0')))
                       ORDER BY 1 DESC LIMIT 1";

        $rsNewNaturrecsiops = db_query($sSqlNatRec);

        if (pg_num_rows($rsNewNaturrecsiops) > 0) {
            
            $oNaturrecsiops = db_utils::fieldsMemory($rsNewNaturrecsiops, 0);        
            return $oNaturrecsiops;
            
        } else {
            
            $clnaturrecsiops    = new cl_naturrecsiops();
            $rsNaturrecsiops    = db_query($clnaturrecsiops->sql_query_siops(substr($natureza, 1, 14),"", $this->iAnoUsu));
    
            if (pg_num_rows($rsNaturrecsiops) > 0) {
                $oNaturrecsiops = db_utils::fieldsMemory($rsNaturrecsiops, 0);
                if (substr($oNaturrecsiops->c230_natrecsiops,0,1) == '9') {
                    $oNaturrecsiops->c231_elerecsiops = substr($oNaturrecsiops->c230_natrecsiops,2,8);
                } else {
                    $oNaturrecsiops->c231_elerecsiops = substr($oNaturrecsiops->c230_natrecsiops,0,8);
                }                
                return $oNaturrecsiops;
            } else {
                $this->status = 2;
                if (strpos($this->sMensagem, $natureza) === false){
                    $this->sMensagem .= "{$natureza} ";
                }
            }
        }
        

    }

    /**
     * Se 6º bimestre, set true para buscar os valores dos anos seguintes.
     */
    public function setOrcado() {

        if($this->iBimestre == 6) {
            $this->lOrcada = true;
        } else {
            $this->lOrcada = false;
        }

    }

    public function getElementoFormat($elemento) {
        return substr($elemento, 0, 1).".".substr($elemento, 1, 1).".".substr($elemento, 2, 2).".".substr($elemento, 4, 2).".".substr($elemento, 6, 2).".".substr($elemento, 8, 2);
    }

    public function getNaturezaFormat($natureza) {
        return substr($natureza, 0, 1).".".substr($natureza, 1, 1).".".substr($natureza, 2, 2).".".substr($natureza, 4, 2).".".substr($natureza, 6, 2).".".substr($natureza, 8, 2);
    }


}