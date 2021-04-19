<?php

class SiopeDespesa extends Siope {

    //@var array
    public $aDespesas = array();
    //@var array
    public $aDespesasAnoSeg = array();
    //@var array
    public $aDespesasAgrupadas = array();
    //@var array
    public $aDespesasAnoSegAgrupadas = array();
    //@var array
    public $aDespesasAgrupadasFinal = array();

    public function getDespesas() {
        return $this->aDespesas;
    }

    public function gerarSiope() {

        $aDados = $this->aDespesasAgrupadasFinal;

        if (file_exists("model/contabilidade/arquivos/siope/{$this->iAnoUsu}/SiopeCsv.model.php")) {

            require_once("model/contabilidade/arquivos/siope/{$this->iAnoUsu}/SiopeCsv.model.php");

            $csv = new SiopeCsv;
            $csv->setNomeArquivo($this->getNomeArquivo());
            $csv->gerarArquivoCSV($aDados, 1);

        }

    }

    /**
     * Adiciona filtros da instituição, função 12 (Educação) e todos os orgãos
     */
    public function setFiltros() {

        $clorcorgao       = new cl_orcorgao;
        $result           = db_query($clorcorgao->sql_query_file('', '', 'o40_orgao', 'o40_orgao asc', 'o40_instit = '.$this->iInstit.' and o40_anousu = '.$this->iAnoUsu));
        $this->sFiltros    = "instit_{$this->iInstit}-funcao_12-";

        if (pg_num_rows($result) > 0) {
            for ($i = 0; $i < pg_numrows($result); $i++) {
                $this->sFiltros .= "orgao_".db_utils::fieldsMemory($result, $i)->o40_orgao."-";
            }
        } else {
            $this->sFiltros = 'geral';
        }

    }

    /**
     * Busca as despesas conforme relatório de Despesa por Item/Desdobramento.
     * Especificamente: a DESPESA EMPENHADA, o valor da DESPESA LIQUIDADA, o valor da DESPESA PAGA por SUBFUNÇÃO,
     * FONTE DE RECURSOS, TIPO DE ENSINO - SIOPE,  TIPO DE PASTA - SIOPE e ELEMENTO DA DESPESA COM DESDOBRAMENTO.
     *
     * Busca a DOTAÇÃO ATUALIZADA com base no relatório Balancete da Despesa.
     * Busca também o CAMPO ORÇADO do ano seguinte.
     */
    public function setDespesas() {

        $clselorcdotacao = new cl_selorcdotacao();
        $clselorcdotacao->setDados($this->sFiltros);

        $sele_work  = $clselorcdotacao->getDados(false, true) . " and o58_instit in ($this->iInstit) and  o58_anousu=$this->iAnoUsu  ";
        $sqlprinc   = db_dotacaosaldo(8, 1, 4, true, $sele_work, $this->iAnoUsu, $this->dtIni, $this->dtFim, 8, 0, true);
        $result     = db_query($sqlprinc) or die(pg_last_error());

        /**
         * Caso seja 6º Bimestre, campo ORÇADO será alimentado através do relatório Balancete da Despesa no exercício subsequente ao de referência.
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
                    $sHashDesp          = $oDespesa->o58_elemento;
                    $aDadosAgrupados    = array();

                    if (!isset($aDadosAgrupados[$sHashDesp])) {

                        $aArrayTemp     = array();

                        $aArrayTemp['o58_codigo']       = $oDespesa->o58_codigo;
                        $aArrayTemp['o58_subfuncao']    = $oDespesa->o58_subfuncao;
                        $aArrayTemp['cod_planilha']     = $iCodPlan = $this->getCodPlanilha($oDespesa);

                        if ($iCodPlan == 238 || $iCodPlan == 239 || $iCodPlan == 240 || $iCodPlan == 173) {
                            $oNaturdessiope = $this->getNaturDesSiope($oDespesa->o58_elemento, 't');
                        } else {
                            $oNaturdessiope = $this->getNaturDesSiope($oDespesa->o58_elemento, 'f');
                        }

                        $aArrayTemp['elemento_siope']   = $oNaturdessiope->c223_eledespecidade;
                        $aArrayTemp['descricao_siope']  = $oNaturdessiope->c223_descricao;
                        $aArrayTemp['dot_atualizada']   = ($oDespesa->dot_ini + $oDespesa->suplementado_acumulado - $oDespesa->reduzido_acumulado);
                        $aArrayTemp['empenhado']        = 0;
                        $aArrayTemp['liquidado']        = 0;
                        $aArrayTemp['pagamento']        = 0;

                        array_push($this->aDespesas, $aArrayTemp);

                    }

                    for ($contDesp = 0; $contDesp < pg_num_rows($resDepsMes); $contDesp++) {

                        $oDadosMes          = db_utils::fieldsMemory($resDepsMes, $contDesp);
                        $sHashDespDesd      = $oDadosMes->o56_elemento;

                        if (isset($aDadosAgrupados[$sHashDesp])) {

                            $aArrayDesdTemp = array();

                            $aArrayDesdTemp['o58_codigo']       = $oDespesa->o58_codigo;
                            $aArrayDesdTemp['o58_subfuncao']    = $oDespesa->o58_subfuncao;
                            $aArrayDesdTemp['cod_planilha']     = $iCodPlan = $this->getCodPlanilha($oDespesa);

                            if ($iCodPlan == 238 || $iCodPlan == 239 || $iCodPlan == 240 || $iCodPlan == 173) {
                                $oNaturdessiopeDesd = $this->getNaturDesSiope($oDadosMes->o56_elemento, 't');
                            } else {
                                $oNaturdessiopeDesd = $this->getNaturDesSiope($oDadosMes->o56_elemento, 'f');
                            }

                            $aArrayDesdTemp['elemento_siope']   = $oNaturdessiopeDesd->c223_eledespecidade;
                            $aArrayDesdTemp['descricao_siope']  = $oNaturdessiopeDesd->c223_descricao;
                            $aArrayDesdTemp['dot_atualizada']   = 0;
                            $aArrayDesdTemp['empenhado']        = ($oDadosMes->empenhado - $oDadosMes->empenhado_estornado);
                            $aArrayDesdTemp['liquidado']        = ($oDadosMes->liquidado - $oDadosMes->liquidado_estornado);
                            $aArrayDesdTemp['pagamento']        = ($oDadosMes->pagamento - $oDadosMes->pagamento_estornado);

                            array_push($this->aDespesas, $aArrayDesdTemp);

                        } else {

                            $aArrayDesdTemp = array();

                            $aArrayDesdTemp['o58_codigo']       = $oDespesa->o58_codigo;
                            $aArrayDesdTemp['o58_subfuncao']    = $oDespesa->o58_subfuncao;
                            $aArrayDesdTemp['cod_planilha']     = $iCodPlan = $this->getCodPlanilha($oDespesa);

                            if ($iCodPlan == 238 || $iCodPlan == 239 || $iCodPlan == 240 || $iCodPlan == 173) {
                                $oNaturdessiopeDesd = $this->getNaturDesSiope($oDadosMes->o56_elemento, 't');
                            } else {
                                $oNaturdessiopeDesd = $this->getNaturDesSiope($oDadosMes->o56_elemento, 'f');
                            }

                            $aArrayDesdTemp['elemento_siope']   = $oNaturdessiopeDesd->c223_eledespecidade;
                            $aArrayDesdTemp['descricao_siope']  = $oNaturdessiopeDesd->c223_descricao;

                            $aArrayDesdTemp['dot_atualizada']   = 0;
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

            for ($i = 0; $i < pg_numrows($resultAnoSeg); $i++) {

                $oDespesaAnoSeg = db_utils::fieldsMemory($resultAnoSeg, $i);

                if ($oDespesaAnoSeg->o58_codigo > 0) {

                    if ($oDespesaAnoSeg->o58_elemento != "") {

                        $sele_work2 = " 1=1 and o58_orgao in ({$oDespesaAnoSeg->o58_orgao}) and ( ( o58_orgao = {$oDespesaAnoSeg->o58_orgao} and o58_unidade = {$oDespesaAnoSeg->o58_unidade} ) ) and o58_funcao in ({$oDespesaAnoSeg->o58_funcao}) and o58_subfuncao in ({$oDespesaAnoSeg->o58_subfuncao}) and o58_programa in ({$oDespesaAnoSeg->o58_programa}) and o58_projativ in ({$oDespesaAnoSeg->o58_projativ}) and (o56_elemento like '" . substr($oDespesaAnoSeg->o58_elemento, 0, 7) . "%') and o58_codigo in ({$oDespesaAnoSeg->o58_codigo}) and o58_instit in ({$this->iInstit}) and o58_anousu={$this->iAnoUsu} ";
                        $cldesdobramento = new cl_desdobramento();
                        $resDepsMes = db_query($cldesdobramento->sql($sele_work2, $this->dtIni, $this->dtFim, "({$this->iInstit})", '')) or die($cldesdobramento->sql($sele_work2, $this->dtIni, $this->dtFim, "({$this->iInstit})", '') . pg_last_error());
                        $sHashDesp = $oDespesaAnoSeg->o58_elemento;
                        $aDadosAgrupados = array();

                        if (!isset($aDadosAgrupados[$sHashDesp])) {

                            $aArrayTemp = array();

                            $aArrayTemp['o58_codigo'] = $oDespesaAnoSeg->o58_codigo;
                            $aArrayTemp['o58_subfuncao'] = $oDespesaAnoSeg->o58_subfuncao;
                            $aArrayTemp['cod_planilha'] = $iCodPlan = $this->getCodPlanilha($oDespesaAnoSeg);

                            if ($iCodPlan == 238 || $iCodPlan == 239 || $iCodPlan == 240 || $iCodPlan == 173) {
                                $oNaturdessiope = $this->getNaturDesSiope($oDespesaAnoSeg->o58_elemento, 't');
                            } else {
                                $oNaturdessiope = $this->getNaturDesSiope($oDespesaAnoSeg->o58_elemento, 'f');
                            }

                            $aArrayTemp['elemento_siope']   = $oNaturdessiope->c223_eledespecidade;
                            $aArrayTemp['descricao_siope']  = $oNaturdessiope->c223_descricao;

                            $aArrayTemp['desp_orcada'] = $oDespesaAnoSeg->dot_ini;

                            array_push($this->aDespesasAnoSeg, $aArrayTemp);

                        }

                    }

                }

            }

        }

    }

    /**
     * Ordena as despesas pela fonte de recursos em ordem crescente.
     */
    public function ordenaDespesas() {

        $sort = array();
        foreach($this->aDespesasAgrupadas as $k=>$v) {
            $sort[$k] = $v['o58_codigo'];
        }

        array_multisort($sort, SORT_ASC, $this->aDespesasAgrupadasFinal);

    }

    /**
     * Agrupa despesas somando valores pelo CÓDIGO DE PLANILHA e ELEMENTO DA DESPESA iguais.
     * EXCETO quando a fonte de recursos for 118, 218, 119 ou 219, o agrupamento é pelo CÓDIGO DE PLANILHA, FONTE DE RECURSOS e ELEMENTO DA DESPESA.
     */
    public function agrupaDespesas() {

        $aDespAgrup = array();

        /**
         * Agrupa despesas do ano corrente.
         */
        foreach($this->aDespesas as $row) {

            list($o58_codigo, $o58_subfuncao, $cod_planilha, $elemento_siope, $descricao_siope, $dot_atualizada, $empenhado, $liquidado, $pagamento) = array_values($row);

            if (($o58_codigo == 118 || $o58_codigo == 218 || $o58_codigo == 119 || $o58_codigo == 219) && (substr($elemento_siope, 0, 3) == 331)) {

                $iSubTotalDot = isset($aDespAgrup[$o58_codigo][$cod_planilha][$elemento_siope]['dot_atualizada']) ? $aDespAgrup[$o58_codigo][$cod_planilha][$elemento_siope]['dot_atualizada'] : 0;
                $iSubTotalEmp = isset($aDespAgrup[$o58_codigo][$cod_planilha][$elemento_siope]['empenhado']) ? $aDespAgrup[$o58_codigo][$cod_planilha][$elemento_siope]['empenhado'] : 0;
                $iSubTotalLiq = isset($aDespAgrup[$o58_codigo][$cod_planilha][$elemento_siope]['liquidado']) ? $aDespAgrup[$o58_codigo][$cod_planilha][$elemento_siope]['liquidado'] : 0;
                $iSubTotalPag = isset($aDespAgrup[$o58_codigo][$cod_planilha][$elemento_siope]['pagamento']) ? $aDespAgrup[$o58_codigo][$cod_planilha][$elemento_siope]['pagamento'] : 0;

                $aDespAgrup[$o58_codigo][$cod_planilha][$elemento_siope]['cod_planilha']    = $cod_planilha;
                $aDespAgrup[$o58_codigo][$cod_planilha][$elemento_siope]['elemento_siope']  = $elemento_siope;
                $aDespAgrup[$o58_codigo][$cod_planilha][$elemento_siope]['descricao_siope'] = $descricao_siope;
                $aDespAgrup[$o58_codigo][$cod_planilha][$elemento_siope]['dot_atualizada']  = ($iSubTotalDot + $dot_atualizada);
                $aDespAgrup[$o58_codigo][$cod_planilha][$elemento_siope]['empenhado']       = ($iSubTotalEmp + $empenhado);
                $aDespAgrup[$o58_codigo][$cod_planilha][$elemento_siope]['liquidado']       = ($iSubTotalLiq + $liquidado);
                $aDespAgrup[$o58_codigo][$cod_planilha][$elemento_siope]['pagamento']       = ($iSubTotalPag + $pagamento);
                $aDespAgrup[$o58_codigo][$cod_planilha][$elemento_siope]['o58_codigo']      = $o58_codigo;
                $aDespAgrup[$o58_codigo][$cod_planilha][$elemento_siope]['o58_subfuncao']   = $o58_subfuncao;
                $aDespAgrup[$o58_codigo][$cod_planilha][$elemento_siope]['desp_orcada']     = 0;

            } else {

                $iSubTotalDot = isset($aDespAgrup[$cod_planilha][$elemento_siope]['dot_atualizada']) ? $aDespAgrup[$cod_planilha][$elemento_siope]['dot_atualizada'] : 0;
                $iSubTotalEmp = isset($aDespAgrup[$cod_planilha][$elemento_siope]['empenhado']) ? $aDespAgrup[$cod_planilha][$elemento_siope]['empenhado'] : 0;
                $iSubTotalLiq = isset($aDespAgrup[$cod_planilha][$elemento_siope]['liquidado']) ? $aDespAgrup[$cod_planilha][$elemento_siope]['liquidado'] : 0;
                $iSubTotalPag = isset($aDespAgrup[$cod_planilha][$elemento_siope]['pagamento']) ? $aDespAgrup[$cod_planilha][$elemento_siope]['pagamento'] : 0;

                $aDespAgrup[$cod_planilha][$elemento_siope]['cod_planilha']     = $cod_planilha;
                $aDespAgrup[$cod_planilha][$elemento_siope]['elemento_siope']   = $elemento_siope;
                $aDespAgrup[$cod_planilha][$elemento_siope]['descricao_siope']  = $descricao_siope;
                $aDespAgrup[$cod_planilha][$elemento_siope]['dot_atualizada']   = ($iSubTotalDot + $dot_atualizada);
                $aDespAgrup[$cod_planilha][$elemento_siope]['empenhado']        = ($iSubTotalEmp + $empenhado);
                $aDespAgrup[$cod_planilha][$elemento_siope]['liquidado']        = ($iSubTotalLiq + $liquidado);
                $aDespAgrup[$cod_planilha][$elemento_siope]['pagamento']        = ($iSubTotalPag + $pagamento);
                $aDespAgrup[$cod_planilha][$elemento_siope]['o58_codigo']       = $o58_codigo;
                $aDespAgrup[$cod_planilha][$elemento_siope]['o58_subfuncao']    = $o58_subfuncao;
                $aDespAgrup[$cod_planilha][$elemento_siope]['desp_orcada']      = 0;

            }

        }

        foreach ($aDespAgrup as $recurso => $aAgrupado) {

            if ($recurso == 118 || $recurso == 218 || $recurso == 119 || $recurso == 219) {

                foreach ($aAgrupado as $elementos) {

                    foreach ($elementos as $elemento) {

                        if(substr($elemento['elemento_siope'], 0, 3) == 331) {
                            $chave1 = $elemento['o58_codigo'] . $elemento['cod_planilha'] . $elemento['elemento_siope'];
                            $this->aDespesasAgrupadas[$chave1] = $elemento;
                        }

                    }

                }

            } else {

                foreach ($aAgrupado as $elem) {
                    $chave2 = $elem['cod_planilha'].$elem['elemento_siope'];
                    $this->aDespesasAgrupadas[$chave2] = $elem;
                }

            }

        }

        /**
         * Agrupa despesas do ano seguinte.
         */
        if ($this->lOrcada) {

            $aDespAgrupAnoSeg = array();

            foreach($this->aDespesasAnoSeg as $row) {

                list($o58_codigo, $o58_subfuncao, $cod_planilha, $elemento_siope, $descricao_siope, $desp_orcada) = array_values($row);

                if ($o58_codigo == 118 || $o58_codigo == 218 || $o58_codigo == 119 || $o58_codigo == 219) {

                    $iSubTotalDes = isset($aDespAgrupAnoSeg[$o58_codigo][$cod_planilha][$elemento_siope]['desp_orcada']) ? $aDespAgrupAnoSeg[$o58_codigo][$cod_planilha][$elemento_siope]['desp_orcada'] : 0;

                    $aDespAgrupAnoSeg[$o58_codigo][$cod_planilha][$elemento_siope]['desp_orcada']     = ($iSubTotalDes + $desp_orcada);
                    $aDespAgrupAnoSeg[$o58_codigo][$cod_planilha][$elemento_siope]['o58_codigo']      = $o58_codigo;
                    $aDespAgrupAnoSeg[$o58_codigo][$cod_planilha][$elemento_siope]['o58_subfuncao']   = $o58_subfuncao;
                    $aDespAgrupAnoSeg[$o58_codigo][$cod_planilha][$elemento_siope]['cod_planilha']    = $cod_planilha;
                    $aDespAgrupAnoSeg[$o58_codigo][$cod_planilha][$elemento_siope]['elemento_siope']  = $elemento_siope;
                    $aDespAgrupAnoSeg[$o58_codigo][$cod_planilha][$elemento_siope]['descricao_siope'] = $descricao_siope;

                } else {

                    $iSubTotalDes = isset($aDespAgrupAnoSeg[$cod_planilha][$elemento_siope]['desp_orcada']) ? $aDespAgrupAnoSeg[$cod_planilha][$elemento_siope]['desp_orcada'] : 0;

                    $aDespAgrupAnoSeg[$cod_planilha][$elemento_siope]['desp_orcada']     = ($iSubTotalDes + $desp_orcada);
                    $aDespAgrupAnoSeg[$cod_planilha][$elemento_siope]['o58_codigo']      = $o58_codigo;
                    $aDespAgrupAnoSeg[$cod_planilha][$elemento_siope]['o58_subfuncao']   = $o58_subfuncao;
                    $aDespAgrupAnoSeg[$cod_planilha][$elemento_siope]['cod_planilha']    = $cod_planilha;
                    $aDespAgrupAnoSeg[$cod_planilha][$elemento_siope]['elemento_siope']  = $elemento_siope;
                    $aDespAgrupAnoSeg[$cod_planilha][$elemento_siope]['descricao_siope'] = $descricao_siope;

                }

            }

            foreach ($aDespAgrupAnoSeg as $recurso => $aAgrupado) {

                if ($recurso == 118 || $recurso == 218 || $recurso == 119 || $recurso == 219) {

                    foreach ($aAgrupado as $elementos) {

                        foreach ($elementos as $elemento) {
                            $chave1 = $elemento['o58_codigo'].$elemento['cod_planilha'].$elemento['elemento_siope'];
                            $this->aDespesasAnoSegAgrupadas[$chave1] = $elemento;
                        }

                    }

                } else {

                    foreach ($aAgrupado as $elem) {
                        $chave2 = $elem['cod_planilha'].$elem['elemento_siope'];
                        $this->aDespesasAnoSegAgrupadas[$chave2] = $elem;
                    }

                }

            }

            /**
             * Une os dois arrays do ano corrente com o ano seguinte.
             * ***Pode haver registros no ano seguinte que não estão no ano corrente.***
             */
            foreach ($this->aDespesasAgrupadas as $index => $despesa) {

                if (isset($this->aDespesasAnoSegAgrupadas[$index])) {
                    $despesa['desp_orcada'] = $this->aDespesasAnoSegAgrupadas[$index]['desp_orcada'];
                    $this->aDespesasAnoSegAgrupadas[$index]['flag'] = 1;
                    array_push($this->aDespesasAgrupadasFinal, $despesa);
                } else {
                    $this->aDespesasAnoSegAgrupadas[$index]['flag'] = 1;
                    array_push($this->aDespesasAgrupadasFinal, $despesa);
                }

            }

            foreach ($this->aDespesasAnoSegAgrupadas as $index => $despesa) {

                if (!isset($despesa['flag']) || $despesa['flag'] != 1) {
                    $despesa['dot_atualizada']  = $this->aDespesasAgrupadas[$index]['dot_atualizada'];
                    $despesa['empenhado']       = $this->aDespesasAgrupadas[$index]['empenhado'];
                    $despesa['liquidado']       = $this->aDespesasAgrupadas[$index]['liquidado'];
                    $despesa['pagamento']       = $this->aDespesasAgrupadas[$index]['pagamento'];
                    array_push($this->aDespesasAgrupadasFinal, $despesa);
                }

            }

        } else {

            $this->aDespesasAgrupadasFinal = $this->aDespesasAgrupadas;

        }

    }

    /**
     * Caso tenha uma despesa com fonte de recursos 119 ou 219, nas subfunções 361, 365, 366 e 367 e com elementos começados por ?331?,
     * Verifica se há uma linha correspondente com a fonte de recursos 118 ou 218, caso não haja, inclui uma linha com dados zerados.
     */
    public function geraLinhaVazia() {

        if ($this->verficaFonte119219()) {

            if (!$this->verificaFonte118218()) {

                $aArrayZerado = array();

                $aArrayZerado['o58_codigo']       = 118;
                $aArrayZerado['o58_subfuncao']    = 0;
                $aArrayZerado['cod_planilha']     = 0;
                $aArrayZerado['elemento_siope']   = 0;
                $aArrayZerado['descricao_siope']  = 0;
                $aArrayZerado['dot_atualizada']   = 0;
                $aArrayZerado['desp_orcada']      = 0;
                $aArrayZerado['empenhado']        = 0;
                $aArrayZerado['liquidado']        = 0;
                $aArrayZerado['pagamento']        = 0;

                array_push($this->aDespesasAgrupadasFinal, $aArrayZerado);

            }

        }

    }

    public function verficaFonte119219() {

        $lReturn = false;

        foreach ($this->aDespesasAgrupadasFinal as $despesa) {
            if ($despesa['o58_codigo'] == 119 || $despesa['o58_codigo'] == 219) {
                if ($despesa['o58_subfuncao'] == 361 || $despesa['o58_subfuncao'] == 365 || $despesa['o58_subfuncao'] == 366 || $despesa['o58_subfuncao'] == 367) {
                    if (substr($despesa['elemento_siope'], 0, 3) == 331) {
                        $lReturn = true;
                    }
                }
            }
        }

        return $lReturn;

    }

    public function verificaFonte118218() {

        $lReturn = false;

        foreach ($this->aDespesasAgrupadasFinal as $despesa) {
            if ($despesa['o58_codigo'] == 118 || $despesa['o58_codigo'] == 218) {
                $lReturn = true;
            }
        }

        return $lReturn;

    }

    /**
     * Cód Planilha recebe valor de acordo com fonte de recursos, subfunção, tipo de ensino siope e tipo de pasta siope.
     */
    public function getCodPlanilha($oDespesa) {

        if ($oDespesa->o58_codigo == 101 || $oDespesa->o58_codigo == 201) {
            return $this->getCod101201($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif($oDespesa->o58_codigo == 118 || $oDespesa->o58_codigo == 218) {
            return $this->getCod118218($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif($oDespesa->o58_codigo == 119 || $oDespesa->o58_codigo == 219) {
            return $this->getCod119219($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif($oDespesa->o58_codigo == 107 || $oDespesa->o58_codigo == 207) {
            return $this->getCod107207($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif($oDespesa->o58_codigo == 144 || $oDespesa->o58_codigo == 244) {
            return $this->getCod144244($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif($oDespesa->o58_codigo == 145 || $oDespesa->o58_codigo == 245) {
            return $this->getCod145245($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif($oDespesa->o58_codigo == 143 || $oDespesa->o58_codigo == 243) {
            return $this->getCod143243($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif($oDespesa->o58_codigo == 122 || $oDespesa->o58_codigo == 222) {
            return $this->getCod122222($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif($oDespesa->o58_codigo == 146 || $oDespesa->o58_codigo == 246) {
            return $this->getCod146246($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif($oDespesa->o58_codigo == 147 || $oDespesa->o58_codigo == 247) {
            return $this->getCod147247($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif($oDespesa->o58_codigo == 106 || $oDespesa->o58_codigo == 206) {
            return $this->getCod106206($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } else {
            return $this->getCodGenerico($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        }

    }

    /**
     * Realiza De/Para da Natureza da despesa com tabela eledessiope composta pelo Cód Elemento e Descrição
     */
    public function getNaturDesSiope($elemento, $previdencia) {

        $clnaturdessiope    = new cl_naturdessiope();
        $rsNaturdessiope    = db_query($clnaturdessiope->sql_query_siope(substr($elemento, 0, 11),"", $this->iAnoUsu, $previdencia));

        if (pg_num_rows($rsNaturdessiope) > 0) {
            $oNaturdessiope = db_utils::fieldsMemory($rsNaturdessiope, 0);
            return $oNaturdessiope;
        } else {
            $this->status = 2;
            if (strpos($this->sMensagem, $elemento) === false){
                $this->sMensagem .= "{$elemento} ";
            }
        }

    }

    public function getCod101201($iSubFuncao, $iTipoEnsino, $iTipoPasta) {

        if ($iSubFuncao == 242) {
            return 664;
        } elseif ($iSubFuncao == 243) {
            return 665;
        } elseif ($iSubFuncao == 271) {
            return 238;
        } elseif ($iSubFuncao == 271) {
            return 238;
        } elseif ($iSubFuncao == 272) {
            return 239;
        } elseif ($iSubFuncao == 273) {
            return 240;
        } elseif ($iSubFuncao == 274) {
            return 173;
        } elseif ($iSubFuncao == 392) {
            return 337;
        } elseif ($iSubFuncao == 695) {
            return 608;
        } elseif ($iSubFuncao == 722) {
            return 338;
        } elseif ($iSubFuncao == 812) {
            return 602;
        } elseif ($iSubFuncao == 813) {
            return 609;
        } elseif ($iSubFuncao == 121) {

            if ($iTipoEnsino == 2) {
                return 252;
            } elseif ($iTipoEnsino == 3) {
                return 264;
            } elseif ($iTipoEnsino == 4) {
                return 268;
            } elseif ($iTipoEnsino == 5) {
                return 703;
            } elseif ($iTipoEnsino == 6) {
                return 272;
            } else {
                return 241;
            }

        } elseif ($iSubFuncao == 122) {

            if ($iTipoEnsino == 2) {
                return 186;
            } elseif ($iTipoEnsino == 3) {
                return 265;
            } elseif ($iTipoEnsino == 4) {
                return 269;
            } elseif ($iTipoEnsino == 5) {
                return 704;
            } elseif ($iTipoEnsino == 6) {
                return 135;
            } else {
                return 3;
            }

        } elseif ($iSubFuncao == 123) {

            if ($iTipoEnsino == 2) {
                return 253;
            } elseif ($iTipoEnsino == 3) {
                return 266;
            } elseif ($iTipoEnsino == 4) {
                return 270;
            } elseif ($iTipoEnsino == 5) {
                return 705;
            } elseif ($iTipoEnsino == 6) {
                return 273;
            } else {
                return 242;
            }

        } elseif ($iSubFuncao == 124) {

            if ($iTipoEnsino == 2) {
                return 254;
            } elseif ($iTipoEnsino == 3) {
                return 267;
            } elseif ($iTipoEnsino == 4) {
                return 271;
            } elseif ($iTipoEnsino == 5) {
                return 706;
            } elseif ($iTipoEnsino == 6) {
                return 274;
            } else {
                return 243;
            }

        } elseif ($iSubFuncao == 126) {

            if ($iTipoEnsino == 2) {
                return 255;
            } elseif ($iTipoEnsino == 3) {
                return 283;
            } elseif ($iTipoEnsino == 4) {
                return 286;
            } elseif ($iTipoEnsino == 5) {
                return 707;
            } elseif ($iTipoEnsino == 6) {
                return 289;
            } else {
                return 244;
            }

        } elseif ($iSubFuncao == 128) {

            if ($iTipoEnsino == 2) {
                return 187;
            } elseif ($iTipoEnsino == 3) {
                return 284;
            } elseif ($iTipoEnsino == 4) {
                return 287;
            } elseif ($iTipoEnsino == 5) {
                return 708;
            } elseif ($iTipoEnsino == 6) {
                return 136;
            } else {
                return 4;
            }

        } elseif ($iSubFuncao == 131) {

            if ($iTipoEnsino == 2) {
                return 256;
            } elseif ($iTipoEnsino == 3) {
                return 285;
            } elseif ($iTipoEnsino == 4) {
                return 288;
            } elseif ($iTipoEnsino == 5) {
                return 709;
            } elseif ($iTipoEnsino == 6) {
                return 290;
            } else {
                return 245;
            }

        } elseif ($iSubFuncao == 331) {

            if ($iTipoEnsino == 2) {
                return 188;
            } elseif ($iTipoEnsino == 3) {
                return 297;
            } elseif ($iTipoEnsino == 4) {
                return 306;
            } elseif ($iTipoEnsino == 5) {
                return 711;
            } elseif ($iTipoEnsino == 6) {
                return 148;
            } else {
                return 50;
            }

        } elseif ($iSubFuncao == 841) {

            if ($iTipoEnsino == 5) {
                return 715;
            } elseif ($iTipoEnsino == 6) {
                return 625;
            } else {
                return 620;
            }

        } elseif ($iSubFuncao == 842) {

            if ($iTipoEnsino == 5) {
                return 716;
            } elseif ($iTipoEnsino == 6) {
                return 626;
            } else {
                return 621;
            }

        } elseif ($iSubFuncao == 843) {

            if ($iTipoEnsino == 5) {
                return 717;
            } elseif ($iTipoEnsino == 6) {
                return 627;
            } else {
                return 622;
            }

        } elseif ($iSubFuncao == 844) {

            if ($iTipoEnsino == 5) {
                return 718;
            } elseif ($iTipoEnsino == 6) {
                return 628;
            } else {
                return 623;
            }

        } elseif ($iSubFuncao == 846) {

            if ($iTipoEnsino == 5) {
                return 719;
            } elseif ($iTipoEnsino == 6) {
                return 629;
            } else {
                return 624;
            }

        } elseif ($iSubFuncao == 361) {

            if ($iTipoPasta == 1) {
                return 5;
            } elseif ($iTipoPasta == 2) {
                return 246;
            } else {
                return 7;
            }

        } elseif ($iSubFuncao == 362) {

            if ($iTipoPasta == 1) {
                return 257;
            } elseif ($iTipoPasta == 2) {
                return 258;
            } else {
                return 189;
            }

        } elseif ($iSubFuncao == 363) {

            if ($iTipoPasta == 1) {
                return 296;
            } elseif ($iTipoPasta == 2) {
                return 299;
            } else {
                return 298;
            }

        } elseif ($iSubFuncao == 364) {

            if ($iTipoPasta == 2) {
                return 308;
            } else {
                return 307;
            }

        } elseif ($iSubFuncao == 366) {

            if ($iTipoEnsino == 2) {

                if ($iTipoPasta == 1) {
                    return 257;
                } elseif($iTipoPasta == 2) {
                    return 258;
                } else {
                    return 700;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 5;
                } elseif($iTipoPasta == 2) {
                    return 246;
                } else {
                    return 617;
                }

            }

        } elseif ($iSubFuncao == 367) {

            if ($iTipoEnsino == 2) {

                if ($iTipoPasta == 1) {
                    return 257;
                } elseif($iTipoPasta == 2) {
                    return 258;
                } else {
                    return 701;
                }

            } elseif ($iTipoEnsino == 5) {

                if ($iTipoPasta == 1) {
                    return 710;
                } elseif($iTipoPasta == 2) {
                    return 714;
                } else {
                    return 713;
                }

            } elseif ($iTipoEnsino == 6) {

                if ($iTipoPasta == 1) {
                    return 137;
                } elseif($iTipoPasta == 2) {
                    return 315;
                } else {
                    return 619;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 5;
                } elseif($iTipoPasta == 2) {
                    return 246;
                } else {
                    return 618;
                }

            }

        } elseif ($iSubFuncao == 365) {

            if ($iTipoEnsino == 5) {

                if ($iTipoPasta == 1) {
                    return 710;
                } elseif($iTipoPasta == 2) {
                    return 714;
                } else {
                    return 712;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 137;
                } elseif($iTipoPasta == 2) {
                    return 315;
                } else {
                    return 11;
                }

            }

        } elseif ($iSubFuncao == 306) {

            if ($iTipoEnsino == 2) {
                return 257;
            } elseif ($iTipoEnsino == 3) {
                return 296;
            } elseif ($iTipoEnsino == 5) {
                return 710;
            } elseif ($iTipoEnsino == 6) {
                return 137;
            } else {
                return 5;
            }

        } else {

            if ($iTipoEnsino == 2) {

                if ($iTipoPasta == 1) {
                    return 257;
                } elseif($iTipoPasta == 2) {
                    return 258;
                } else {
                    return 186;
                }

            } elseif ($iTipoEnsino == 3) {

                if ($iTipoPasta == 1) {
                    return 296;
                } elseif($iTipoPasta == 2) {
                    return 299;
                } else {
                    return 265;
                }

            } elseif ($iTipoEnsino == 4) {

                if($iTipoPasta == 2) {
                    return 308;
                } else {
                    return 269;
                }

            } elseif ($iTipoEnsino == 5) {

                if($iTipoPasta == 1) {
                    return 710;
                } elseif($iTipoPasta == 2) {
                    return 714;
                } else {
                    return 704;
                }

            } elseif ($iTipoEnsino == 6) {

                if($iTipoPasta == 1) {
                    return 137;
                } elseif($iTipoPasta == 2) {
                    return 315;
                } else {
                    return 135;
                }

            } else {

                if($iTipoPasta == 1) {
                    return 5;
                } elseif($iTipoPasta == 2) {
                    return 246;
                } else {
                    return 3;
                }

            }

        }

    }

    public function getCod118218($iSubFuncao, $iTipoEnsino, $iTipoPasta) {

        if ($iSubFuncao == 361) {
            return 32;
        } elseif ($iSubFuncao == 366) {
            return 33;
        } elseif ($iSubFuncao == 367) {

            if ($iTipoEnsino == 5) {
                return 731;
            } elseif ($iTipoEnsino == 6) {
                return 360;
            } else {
                return 129;
            }

        } elseif($iSubFuncao == 365) {

            if ($iTipoEnsino == 5) {
                return 730;
            } else {
                return 359;
            }

        } else {

            if ($iTipoEnsino == 5) {
                return 730;
            } elseif ($iTipoEnsino == 6) {
                return 359;
            } else {
                return 32;
            }

        }

    }

    public function getCod119219($iSubFuncao, $iTipoEnsino, $iTipoPasta) {

        if ($iSubFuncao == 121) {

            if ($iTipoEnsino == 5) {
                return 721;
            } elseif ($iTipoEnsino == 6) {
                return 350;
            } else {
                return 341;
            }

        } elseif ($iSubFuncao == 122) {

            if ($iTipoEnsino == 5) {
                return 722;
            } elseif ($iTipoEnsino == 6) {
                return 351;
            } else {
                return 30;
            }

        } elseif ($iSubFuncao == 123) {

            if ($iTipoEnsino == 5) {
                return 723;
            } elseif ($iTipoEnsino == 6) {
                return 352;
            } else {
                return 342;
            }

        } elseif ($iSubFuncao == 124) {

            if ($iTipoEnsino == 5) {
                return 724;
            } elseif ($iTipoEnsino == 6) {
                return 353;
            } else {
                return 343;
            }

        } elseif ($iSubFuncao == 126) {

            if ($iTipoEnsino == 5) {
                return 725;
            } elseif ($iTipoEnsino == 6) {
                return 354;
            } else {
                return 344;
            }

        } elseif ($iSubFuncao == 128) {

            if ($iTipoEnsino == 5) {
                return 726;
            } elseif ($iTipoEnsino == 6) {
                return 355;
            } else {
                return 31;
            }

        } elseif ($iSubFuncao == 131) {

            if ($iTipoEnsino == 5) {
                return 727;
            } elseif ($iTipoEnsino == 6) {
                return 356;
            } else {
                return 345;
            }

        } elseif ($iSubFuncao == 331) {

            if ($iTipoEnsino == 5) {
                return 729;
            } elseif ($iTipoEnsino == 6) {
                return 358;
            } else {
                return 347;
            }

        } elseif ($iSubFuncao == 841) {

            if ($iTipoEnsino == 5) {
                return 733;
            } elseif ($iTipoEnsino == 6) {
                return 635;
            } else {
                return 630;
            }

        } elseif ($iSubFuncao == 842) {

            if ($iTipoEnsino == 5) {
                return 734;
            } elseif ($iTipoEnsino == 6) {
                return 636;
            } else {
                return 631;
            }

        } elseif ($iSubFuncao == 843) {

            if ($iTipoEnsino == 5) {
                return 735;
            } elseif ($iTipoEnsino == 6) {
                return 637;
            } else {
                return 632;
            }

        } elseif ($iSubFuncao == 844) {

            if ($iTipoEnsino == 5) {
                return 736;
            } elseif ($iTipoEnsino == 6) {
                return 638;
            } else {
                return 633;
            }

        } elseif ($iSubFuncao == 846) {

            if ($iTipoEnsino == 5) {
                return 737;
            } elseif ($iTipoEnsino == 6) {
                return 639;
            } else {
                return 634;
            }

        } elseif ($iSubFuncao == 361) {

            if ($iTipoPasta == 1) {
                return 346;
            } elseif ($iTipoPasta == 2) {
                return 348;
            } else {
                return 32;
            }

        } elseif ($iSubFuncao == 366) {

            if ($iTipoPasta == 1) {
                return 346;
            } elseif ($iTipoPasta == 2) {
                return 348;
            } else {
                return 33;
            }

        } elseif ($iSubFuncao == 367) {

            if ($iTipoEnsino == 5) {

                if ($iTipoPasta == 1) {
                    return 728;
                } elseif ($iTipoPasta == 2) {
                    return 732;
                } else {
                    return 731;
                }

            } elseif ($iTipoEnsino == 6) {

                if ($iTipoPasta == 1) {
                    return 357;
                } elseif ($iTipoPasta == 2) {
                    return 361;
                } else {
                    return 360;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 346;
                } elseif ($iTipoPasta == 2) {
                    return 348;
                } else {
                    return 129;
                }

            }

        } elseif ($iSubFuncao == 365) {

            if ($iTipoEnsino == 5) {

                if ($iTipoPasta == 1) {
                    return 728;
                } elseif ($iTipoPasta == 2) {
                    return 732;
                } else {
                    return 730;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 357;
                } elseif ($iTipoPasta == 2) {
                    return 361;
                } else {
                    return 359;
                }

            }

        } elseif ($iSubFuncao == 306) {

            if ($iTipoEnsino == 5) {
                return 728;
            } elseif ($iTipoEnsino == 6) {
                return 357;
            } else {
                return 346;
            }

        } else {

            if ($iTipoEnsino == 5) {

                if ($iTipoPasta == 1) {
                    return 728;
                } elseif ($iTipoPasta == 2) {
                    return 732;
                } else {
                    return 722;
                }

            } elseif ($iTipoEnsino == 6) {

                if ($iTipoPasta == 1) {
                    return 357;
                } elseif ($iTipoPasta == 2) {
                    return 361;
                } else {
                    return 351;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 346;
                } elseif ($iTipoPasta == 2) {
                    return 348;
                } else {
                    return 30;
                }

            }

        }

    }

    public function getCod107207($iSubFuncao, $iTipoEnsino, $iTipoPasta) {

        if ($iSubFuncao == 361) {

            if ($iTipoPasta == 1) {
                return 1248;
            } elseif ($iTipoPasta == 2) {
                return 1252;
            } else {
                return 1249;
            }

        } elseif ($iSubFuncao == 366) {

            if ($iTipoPasta == 1) {
                return 1248;
            } elseif ($iTipoPasta == 2) {
                return 1252;
            } else {
                return 1250;
            }

        } elseif ($iSubFuncao == 367) {

            if ($iTipoEnsino == 5) {

                if ($iTipoPasta == 1) {
                    return 1254;
                } elseif ($iTipoPasta == 2) {
                    return 1257;
                } else {
                    return 1256;
                }

            } elseif ($iTipoEnsino == 6) {

                if ($iTipoPasta == 1) {
                    return 1259;
                } elseif ($iTipoPasta == 2) {
                    return 1262;
                } else {
                    return 1261;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 1248;
                } elseif ($iTipoPasta == 2) {
                    return 1252;
                } else {
                    return 1251;
                }

            }

        } elseif ($iSubFuncao == 365) {

            if ($iTipoEnsino == 5) {

                if ($iTipoPasta == 1) {
                    return 1254;
                } elseif ($iTipoPasta == 2) {
                    return 1257;
                } else {
                    return 1255;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 1259;
                } elseif ($iTipoPasta == 2) {
                    return 1262;
                } else {
                    return 1260;
                }

            }

        } elseif ($iSubFuncao == 306) {

            if ($iTipoEnsino == 5) {
                return 1254;
            } elseif ($iTipoEnsino == 6) {
                return 1259;
            } else {
                return 1248;
            }

        } else {

            if ($iTipoEnsino == 5) {

                if ($iTipoPasta == 1) {
                    return 1254;
                } elseif ($iTipoPasta == 2) {
                    return 1257;
                } else {
                    return 1255;
                }

            } elseif ($iTipoEnsino == 6) {

                if ($iTipoPasta == 1) {
                    return 1259;
                } elseif ($iTipoPasta == 2) {
                    return 1262;
                } else {
                    return 1260;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 1248;
                } elseif ($iTipoPasta == 2) {
                    return 1252;
                } else {
                    return 1249;
                }

            }

        }

    }

    public function getCod144244($iSubFuncao, $iTipoEnsino, $iTipoPasta) {

        if ($iSubFuncao == 361) {
            return 867;
        } elseif ($iSubFuncao == 362) {
            return 880;
        } elseif ($iSubFuncao == 363) {
            return 893;
        } elseif ($iSubFuncao == 365) {

            if ($iTipoEnsino == 5) {
                return 904;
            } else {
                return 916;
            }

        } else {

            if ($iTipoEnsino == 2) {
                return 880;
            } elseif ($iTipoEnsino == 3) {
                return 893;
            } elseif ($iTipoEnsino == 5) {
                return 904;
            } elseif ($iTipoEnsino == 6) {
                return 916;
            } else {
                return 867;
            }

        }

    }

    public function getCod145245($iSubFuncao, $iTipoEnsino, $iTipoPasta) {

        if ($iSubFuncao == 361) {
            return 933;
        } elseif ($iSubFuncao == 362) {
            return 946;
        } elseif ($iSubFuncao == 363) {
            return 957;
        } elseif ($iSubFuncao == 365) {

            if ($iTipoEnsino == 5) {
                return 969;
            } else {
                return 981;
            }

        } else {

            if ($iTipoEnsino == 2) {
                return 946;
            } elseif ($iTipoEnsino == 3) {
                return 957;
            } elseif ($iTipoEnsino == 5) {
                return 969;
            } elseif ($iTipoEnsino == 6) {
                return 981;
            } else {
                return 933;
            }

        }

    }

    public function getCod143243($iSubFuncao, $iTipoEnsino, $iTipoPasta) {

        if ($iSubFuncao == 121) {

            if ($iTipoEnsino == 2) {
                return 983;
            } elseif ($iTipoEnsino == 3) {
                return 984;
            } elseif ($iTipoEnsino == 5) {
                return 985;
            } elseif ($iTipoEnsino == 6) {
                return 986;
            } else {
                return 982;
            }

        } elseif ($iSubFuncao == 122) {

            if ($iTipoEnsino == 2) {
                return 1007;
            } elseif ($iTipoEnsino == 3) {
                return 1017;
            } elseif ($iTipoEnsino == 5) {
                return 1027;
            } elseif ($iTipoEnsino == 6) {
                return 1037;
            } else {
                return 997;
            }

        } elseif ($iSubFuncao == 123) {

            if ($iTipoEnsino == 2) {
                return 1008;
            } elseif ($iTipoEnsino == 3) {
                return 1018;
            } elseif ($iTipoEnsino == 5) {
                return 1028;
            } elseif ($iTipoEnsino == 6) {
                return 1038;
            } else {
                return 998;
            }

        } elseif ($iSubFuncao == 124) {

            if ($iTipoEnsino == 2) {
                return 1009;
            } elseif ($iTipoEnsino == 3) {
                return 1019;
            } elseif ($iTipoEnsino == 5) {
                return 1029;
            } elseif ($iTipoEnsino == 6) {
                return 1039;
            } else {
                return 999;
            }

        } elseif ($iSubFuncao == 126) {

            if ($iTipoEnsino == 2) {
                return 1010;
            } elseif ($iTipoEnsino == 3) {
                return 1020;
            } elseif ($iTipoEnsino == 5) {
                return 1030;
            } elseif ($iTipoEnsino == 6) {
                return 1040;
            } else {
                return 1000;
            }

        } elseif ($iSubFuncao == 128) {

            if ($iTipoEnsino == 2) {
                return 1011;
            } elseif ($iTipoEnsino == 3) {
                return 1021;
            } elseif ($iTipoEnsino == 5) {
                return 1031;
            } elseif ($iTipoEnsino == 6) {
                return 1041;
            } else {
                return 1001;
            }

        } elseif ($iSubFuncao == 131) {

            if ($iTipoEnsino == 2) {
                return 1012;
            } elseif ($iTipoEnsino == 3) {
                return 1022;
            } elseif ($iTipoEnsino == 5) {
                return 1032;
            } elseif ($iTipoEnsino == 6) {
                return 1042;
            } else {
                return 1002;
            }

        } elseif ($iSubFuncao == 331) {

            if ($iTipoEnsino == 2) {
                return 1014;
            } elseif ($iTipoEnsino == 3) {
                return 1024;
            } elseif ($iTipoEnsino == 5) {
                return 1034;
            } elseif ($iTipoEnsino == 6) {
                return 1044;
            } else {
                return 1004;
            }

        } elseif ($iSubFuncao == 361) {

            if ($iTipoPasta == 1) {
                return 1003;
            } elseif ($iTipoPasta == 2) {
                return 1006;
            } else {
                return 1147;
            }

        } elseif ($iSubFuncao == 362) {

            if ($iTipoEnsino == 1) {
                return 1013;
            } elseif ($iTipoEnsino == 2) {
                return 1016;
            } else {
                return 1149;
            }

        } elseif ($iSubFuncao == 363) {

            if ($iTipoPasta == 1) {
                return 1023;
            } elseif ($iTipoPasta == 2) {
                return 1026;
            } else {
                return 1151;
            }

        } elseif ($iSubFuncao == 366) {

            if ($iTipoEnsino == 2) {

                if ($iTipoPasta == 1) {
                    return 1013;
                } elseif ($iTipoPasta == 2) {
                    return 1016;
                } else {
                    return 1150;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 1003;
                } elseif ($iTipoPasta == 2) {
                    return 1006;
                } else {
                    return 1148;
                }

            }

        } elseif ($iSubFuncao == 367) {

            if ($iTipoEnsino == 2) {

                if ($iTipoPasta == 1) {
                    return 1013;
                } elseif ($iTipoPasta == 2) {
                    return 1016;
                } else {
                    return 1015;
                }

            } elseif ($iTipoEnsino == 5) {

                if ($iTipoPasta == 1) {
                    return 1033;
                } elseif ($iTipoPasta == 2) {
                    return 1036;
                } else {
                    return 1035;
                }

            } elseif ($iTipoEnsino == 6) {

                if ($iTipoPasta == 1) {
                    return 1043;
                } elseif ($iTipoPasta == 2) {
                    return 1046;
                } else {
                    return 1045;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 1003;
                } elseif ($iTipoPasta == 2) {
                    return 1006;
                } else {
                    return 1005;
                }

            }

        } elseif ($iSubFuncao == 365) {

            if ($iTipoEnsino == 5) {

                if ($iTipoPasta == 1) {
                    return 1033;
                } elseif ($iTipoPasta == 2) {
                    return 1036;
                } else {
                    return 1152;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 1043;
                } elseif ($iTipoPasta == 2) {
                    return 1046;
                } else {
                    return 1153;
                }

            }

        } elseif ($iSubFuncao == 306) {

            if ($iTipoEnsino == 2) {
                return 1013;
            } elseif ($iTipoEnsino == 3) {
                return  1023;
            } elseif ($iTipoEnsino == 5) {
                return 1033;
            } elseif ($iTipoEnsino == 6) {
                return 1043;
            } else {
                return 1003;
            }

        } else {

            if ($iTipoEnsino == 2) {

                if ($iTipoPasta == 1) {
                    return 1013;
                } elseif ($iTipoPasta == 2) {
                    return 1016;
                } else {
                    return 1007;
                }

            } elseif ($iTipoEnsino == 3) {

                if ($iTipoPasta == 1) {
                    return 1023;
                } elseif ($iTipoPasta == 2) {
                    return 1026;
                } else {
                    return 1017;
                }

            } elseif ($iTipoEnsino == 5) {

                if ($iTipoPasta == 1) {
                    return 1033;
                } elseif ($iTipoPasta == 2) {
                    return 1036;
                } else {
                    return 1027;
                }

            } elseif ($iTipoEnsino == 6) {

                if ($iTipoPasta == 1) {
                    return 1043;
                } elseif ($iTipoPasta == 2) {
                    return 1046;
                } else {
                    return 1037;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 1003;
                } elseif ($iTipoPasta == 2) {
                    return 1006;
                } else {
                    return 997;
                }

            }

        }

    }

    public function getCod122222($iSubFuncao, $iTipoEnsino, $iTipoPasta) {

        if ($iSubFuncao == 121) {

            if ($iTipoEnsino == 2) {
                return 988;
            } elseif ($iTipoEnsino == 3) {
                return 989;
            } elseif ($iTipoEnsino == 5) {
                return 990;
            } elseif ($iTipoEnsino == 6) {
                return 991;
            } else {
                return 987;
            }

        } elseif ($iSubFuncao == 122) {

            if ($iTipoEnsino == 2) {
                return 1057;
            } elseif ($iTipoEnsino == 3) {
                return 1067;
            } elseif ($iTipoEnsino == 5) {
                return 1077;
            } elseif ($iTipoEnsino == 6) {
                return 1087;
            } else {
                return 1047;
            }

        } elseif ($iSubFuncao == 123) {

            if ($iTipoEnsino == 2) {
                return 1058;
            } elseif ($iTipoEnsino == 3) {
                return 1068;
            } elseif ($iTipoEnsino == 5) {
                return 1078;
            } elseif ($iTipoEnsino == 6) {
                return 1088;
            } else {
                return 1048;
            }

        } elseif ($iSubFuncao == 124) {

            if ($iTipoEnsino == 2) {
                return 1059;
            } elseif ($iTipoEnsino == 3) {
                return 1069;
            } elseif ($iTipoEnsino == 5) {
                return 1079;
            } elseif ($iTipoEnsino == 6) {
                return 1089;
            } else {
                return 1049;
            }

        } elseif ($iSubFuncao == 126) {

            if ($iTipoEnsino == 2) {
                return 1060;
            } elseif ($iTipoEnsino == 3) {
                return 1070;
            } elseif ($iTipoEnsino == 5) {
                return 1080;
            } elseif ($iTipoEnsino == 6) {
                return 1090;
            } else {
                return 1050;
            }

        } elseif ($iSubFuncao == 128) {

            if ($iTipoEnsino == 2) {
                return 1061;
            } elseif ($iTipoEnsino == 3) {
                return 1071;
            } elseif ($iTipoEnsino == 5) {
                return 1081;
            } elseif ($iTipoEnsino == 6) {
                return 1091;
            } else {
                return 1051;
            }

        } elseif ($iSubFuncao == 131) {

            if ($iTipoEnsino == 2) {
                return 1062;
            } elseif ($iTipoEnsino == 3) {
                return 1072;
            } elseif ($iTipoEnsino == 5) {
                return 1082;
            } elseif ($iTipoEnsino == 6) {
                return 1092;
            } else {
                return 1052;
            }

        } elseif ($iSubFuncao == 331) {

            if ($iTipoEnsino == 2) {
                return 1064;
            } elseif ($iTipoEnsino == 3) {
                return 1074;
            } elseif ($iTipoEnsino == 5) {
                return 1084;
            } elseif ($iTipoEnsino == 6) {
                return 1094;
            } else {
                return 1054;
            }

        } elseif ($iSubFuncao == 361) {

            if ($iTipoPasta == 1) {
                return 1053;
            } elseif ($iTipoPasta == 2) {
                return 1056;
            } else {
                return 1154;
            }

        } elseif ($iSubFuncao == 362) {

            if ($iTipoPasta == 1) {
                return 1063;
            } elseif ($iTipoPasta == 2) {
                return 1066;
            } else {
                return 1156;
            }

        } elseif ($iSubFuncao == 363) {

            if ($iTipoPasta == 1) {
                return 1073;
            } elseif ($iTipoPasta == 2) {
                return 1076;
            } else {
                return 1158;
            }

        } elseif ($iSubFuncao == 366) {

            if ($iTipoEnsino == 2) {

                if ($iTipoPasta == 1) {
                    return 1063;
                } elseif ($iTipoPasta == 2) {
                    return 1066;
                } else {
                    return 1157;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 1053;
                } elseif ($iTipoPasta == 2) {
                    return 1056;
                } else {
                    return 1155;
                }

            }

        } elseif ($iSubFuncao == 367) {

            if ($iTipoEnsino == 2) {

                if ($iTipoPasta == 1) {
                    return 1063;
                } elseif ($iTipoPasta == 2) {
                    return 1066;
                } else {
                    return 1065;
                }

            } elseif ($iTipoEnsino == 5) {

                if ($iTipoPasta == 1) {
                    return 1083;
                } elseif ($iTipoPasta == 2) {
                    return 1086;
                } else {
                    return 1085;
                }

            } elseif ($iTipoEnsino == 6) {

                if ($iTipoPasta == 1) {
                    return 1093;
                } elseif ($iTipoPasta == 2) {
                    return 1096;
                } else {
                    return 1095;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 1053;
                } elseif ($iTipoPasta == 2) {
                    return 1056;
                } else {
                    return 1055;
                }

            }

        } elseif ($iSubFuncao == 365) {

            if ($iTipoEnsino == 5) {

                if ($iTipoPasta == 1) {
                    return 1083;
                } elseif ($iTipoPasta == 2) {
                    return 1086;
                } else {
                    return 1159;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 1093;
                } elseif ($iTipoPasta == 2) {
                    return 1096;
                } else {
                    return 1160;
                }

            }

        } elseif ($iSubFuncao == 306) {

            if ($iTipoEnsino == 2) {
                return 1063;
            } elseif ($iTipoEnsino == 3) {
                return 1073;
            } elseif ($iTipoEnsino == 5) {
                return 1083;
            } elseif ($iTipoEnsino == 6) {
                return 1093;
            } else {
                return 1053;
            }

        } else {

            if ($iTipoEnsino == 2) {

                if ($iTipoPasta == 1) {
                    return 1063;
                } elseif ($iTipoPasta == 2) {
                    return 1066;
                } else {
                    return 1057;
                }

            } elseif ($iTipoEnsino == 3) {

                if ($iTipoPasta == 1) {
                    return 1073;
                } elseif ($iTipoPasta == 2) {
                    return 1076;
                } else {
                    return 1067;
                }

            } elseif ($iTipoEnsino == 5) {

                if ($iTipoPasta == 1) {
                    return 1083;
                } elseif ($iTipoPasta == 2) {
                    return 1086;
                } else {
                    return 1077;
                }

            } elseif ($iTipoEnsino == 6) {

                if ($iTipoPasta == 1) {
                    return 1093;
                } elseif ($iTipoPasta == 2) {
                    return 1096;
                } else {
                    return 1087;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 1053;
                } elseif ($iTipoPasta == 2) {
                    return 1056;
                } else {
                    return 1047;
                }

            }

        }

    }

    public function getCod146246($iSubFuncao, $iTipoEnsino, $iTipoPasta) {

        if ($iSubFuncao == 121) {

            if ($iTipoEnsino == 2) {
                return 993;
            } elseif ($iTipoEnsino == 3) {
                return 994;
            } elseif ($iTipoEnsino == 5) {
                return 995;
            } elseif ($iTipoEnsino == 6) {
                return 996;
            } else {
                return 982;
            }

        } elseif ($iSubFuncao == 122) {

            if ($iTipoEnsino == 2) {
                return 1107;
            } elseif ($iTipoEnsino == 3) {
                return 1117;
            } elseif ($iTipoEnsino == 5) {
                return 1127;
            } elseif ($iTipoEnsino == 6) {
                return 1137;
            } else {
                return 1097;
            }

        } elseif ($iSubFuncao == 123) {

            if ($iTipoEnsino == 2) {
                return 1108;
            } elseif ($iTipoEnsino == 3) {
                return 1118;
            } elseif ($iTipoEnsino == 5) {
                return 1128;
            } elseif ($iTipoEnsino == 6) {
                return 1138;
            } else {
                return 1098;
            }

        } elseif ($iSubFuncao == 124) {

            if ($iTipoEnsino == 2) {
                return 1109;
            } elseif ($iTipoEnsino == 3) {
                return 1119;
            } elseif ($iTipoEnsino == 5) {
                return 1129;
            } elseif ($iTipoEnsino == 6) {
                return 1139;
            } else {
                return 1099;
            }

        } elseif ($iSubFuncao == 126) {

            if ($iTipoEnsino == 2) {
                return 1110;
            } elseif ($iTipoEnsino == 3) {
                return 1120;
            } elseif ($iTipoEnsino == 5) {
                return 1130;
            } elseif ($iTipoEnsino == 6) {
                return 1140;
            } else {
                return 1100;
            }

        } elseif ($iSubFuncao == 128) {

            if ($iTipoEnsino == 2) {
                return 1111;
            } elseif ($iTipoEnsino == 3) {
                return 1121;
            } elseif ($iTipoEnsino == 5) {
                return 1131;
            } elseif ($iTipoEnsino == 6) {
                return 1141;
            } else {
                return 1101;
            }

        } elseif ($iSubFuncao == 131) {

            if ($iTipoEnsino == 2) {
                return 1112;
            } elseif ($iTipoEnsino == 3) {
                return 1122;
            } elseif ($iTipoEnsino == 5) {
                return 1132;
            } elseif ($iTipoEnsino == 6) {
                return 1142;
            } else {
                return 1102;
            }

        } elseif ($iSubFuncao == 331) {

            if ($iTipoEnsino == 2) {
                return 1114;
            } elseif ($iTipoEnsino == 3) {
                return 1124;
            } elseif ($iTipoEnsino == 5) {
                return 1134;
            } elseif ($iTipoEnsino == 6) {
                return 1144;
            } else {
                return 1104;
            }

        } elseif ($iSubFuncao == 361) {

            if ($iTipoPasta == 1) {
                return 1103;
            } elseif ($iTipoPasta == 2) {
                return 1106;
            } else {
                return 1161;
            }

        } elseif ($iSubFuncao == 362) {

            if ($iTipoPasta == 1) {
                return 1113;
            } elseif ($iTipoPasta == 2) {
                return 1116;
            } else {
                return 1163;
            }

        } elseif ($iSubFuncao == 363) {

            if ($iTipoPasta == 1) {
                return 1123;
            } elseif ($iTipoPasta == 2) {
                return 1126;
            } else {
                return 1125;
            }

        } elseif ($iSubFuncao == 366) {

            if ($iTipoEnsino == 2) {

                if ($iTipoPasta == 1) {
                    return 1113;
                } elseif ($iTipoPasta == 2) {
                    return 1116;
                } else {
                    return 1164;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 1103;
                } elseif ($iTipoPasta == 2) {
                    return 1106;
                } else {
                    return 1162;
                }

            }

        } elseif ($iSubFuncao == 367) {

            if ($iTipoEnsino == 2) {

                if ($iTipoPasta == 1) {
                    return 1113;
                } elseif ($iTipoPasta == 2) {
                    return 1116;
                } else {
                    return 1115;
                }

            } elseif ($iTipoEnsino == 5) {

                if ($iTipoPasta == 1) {
                    return 1133;
                } elseif ($iTipoPasta == 2) {
                    return 1136;
                } else {
                    return 1135;
                }

            } elseif ($iTipoEnsino == 6) {

                if ($iTipoPasta == 1) {
                    return 1143;
                } elseif ($iTipoPasta == 2) {
                    return 1146;
                } else {
                    return 1145;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 1103;
                } elseif ($iTipoPasta == 2) {
                    return 1106;
                } else {
                    return 1105;
                }

            }

        } elseif ($iSubFuncao == 365) {

            if ($iTipoEnsino == 5) {

                if ($iTipoPasta == 1) {
                    return 1133;
                } elseif ($iTipoPasta == 2) {
                    return 1136;
                } else {
                    return 1165;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 1143;
                } elseif ($iTipoPasta == 2) {
                    return 1146;
                } else {
                    return 1166;
                }

            }

        } elseif ($iSubFuncao == 306) {

            if ($iTipoEnsino == 2) {
                return 1113;
            } elseif ($iTipoEnsino == 3) {
                return 1123;
            } elseif ($iTipoEnsino == 5) {
                return 1133;
            } elseif ($iTipoEnsino == 6) {
                return 1143;
            } else {
                return 1103;
            }

        } else {

            if ($iTipoEnsino == 2) {

                if ($iTipoPasta == 1) {
                    return 1113;
                } elseif ($iTipoPasta == 2) {
                    return 1116;
                } else {
                    return 1107;
                }

            } elseif ($iTipoEnsino == 3) {

                if ($iTipoPasta == 1) {
                    return 1123;
                } elseif ($iTipoPasta == 2) {
                    return 1126;
                } else {
                    return 1117;
                }

            } elseif ($iTipoEnsino == 5) {

                if ($iTipoPasta == 1) {
                    return 1133;
                } elseif ($iTipoPasta == 2) {
                    return 1136;
                } else {
                    return 1127;
                }

            } elseif ($iTipoEnsino == 6) {

                if ($iTipoPasta == 1) {
                    return 1143;
                } elseif ($iTipoPasta == 2) {
                    return 1146;
                } else {
                    return 1137;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 1103;
                } elseif ($iTipoPasta == 2) {
                    return 1106;
                } else {
                    return 1097;
                }

            }

        }

    }

    public function getCod147247($iSubFuncao, $iTipoEnsino, $iTipoPasta) {

        if ($iSubFuncao == 121) {

            if ($iTipoEnsino == 2) {
                return 775;
            } elseif ($iTipoEnsino == 3) {
                return 788;
            } elseif ($iTipoEnsino == 5) {
                return 799;
            } elseif ($iTipoEnsino == 6) {
                return 811;
            } else {
                return 762;
            }

        } elseif ($iSubFuncao == 122) {

            if ($iTipoEnsino == 2) {
                return 776;
            } elseif ($iTipoEnsino == 3) {
                return 789;
            } elseif ($iTipoEnsino == 5) {
                return 800;
            } elseif ($iTipoEnsino == 6) {
                return 812;
            } else {
                return 763;
            }

        } elseif ($iSubFuncao == 123) {

            if ($iTipoEnsino == 2) {
                return 777;
            } elseif ($iTipoEnsino == 3) {
                return 790;
            } elseif ($iTipoEnsino == 5) {
                return 801;
            } elseif ($iTipoEnsino == 6) {
                return 813;
            } else {
                return 764;
            }

        } elseif ($iSubFuncao == 124) {

            if ($iTipoEnsino == 2) {
                return 778;
            } elseif ($iTipoEnsino == 3) {
                return 791;
            } elseif ($iTipoEnsino == 5) {
                return 802;
            } elseif ($iTipoEnsino == 6) {
                return 814;
            } else {
                return 765;
            }

        } elseif ($iSubFuncao == 126) {

            if ($iTipoEnsino == 2) {
                return 779;
            } elseif ($iTipoEnsino == 3) {
                return 792;
            } elseif ($iTipoEnsino == 5) {
                return 803;
            } elseif ($iTipoEnsino == 6) {
                return 815;
            } else {
                return 766;
            }

        } elseif ($iSubFuncao == 128) {

            if ($iTipoEnsino == 2) {
                return 780;
            } elseif ($iTipoEnsino == 3) {
                return 793;
            } elseif ($iTipoEnsino == 5) {
                return 804;
            } elseif ($iTipoEnsino == 6) {
                return 816;
            } else {
                return 767;
            }

        } elseif ($iSubFuncao == 131) {

            if ($iTipoEnsino == 2) {
                return 781;
            } elseif ($iTipoEnsino == 3) {
                return 794;
            } elseif ($iTipoEnsino == 5) {
                return 805;
            } elseif ($iTipoEnsino == 6) {
                return 817;
            } else {
                return 768;
            }

        } elseif ($iSubFuncao == 331) {

            if ($iTipoEnsino == 2) {
                return 783;
            } elseif ($iTipoEnsino == 3) {
                return 796;
            } elseif ($iTipoEnsino == 5) {
                return 807;
            } elseif ($iTipoEnsino == 6) {
                return 819;
            } else {
                return 770;
            }

        } elseif ($iSubFuncao == 361) {

            if ($iTipoPasta == 1) {
                return 769;
            } elseif ($iTipoPasta == 2) {
                return 774;
            } else {
                return 771;
            }

        } elseif ($iSubFuncao == 362) {

            if ($iTipoPasta == 1) {
                return 782;
            } elseif ($iTipoPasta == 2) {
                return 787;
            } else {
                return 784;
            }

        } elseif ($iSubFuncao == 363) {

            if ($iTipoPasta == 1) {
                return 795;
            } elseif ($iTipoPasta == 2) {
                return 798;
            } else {
                return 797;
            }

        } elseif ($iSubFuncao == 366) {

            if ($iTipoEnsino == 2) {

                if ($iTipoPasta == 1) {
                    return 782;
                } elseif ($iTipoPasta == 2) {
                    return 787;
                } else {
                    return 785;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 769;
                } elseif ($iTipoPasta == 2) {
                    return 774;
                } else {
                    return 772;
                }

            }

        } elseif ($iSubFuncao == 367) {

            if ($iTipoEnsino == 2) {

                if ($iTipoPasta == 1) {
                    return 782;
                } elseif ($iTipoPasta == 2) {
                    return 787;
                } else {
                    return 786;
                }

            } elseif ($iTipoEnsino == 5) {

                if ($iTipoPasta == 1) {
                    return 806;
                } elseif ($iTipoPasta == 2) {
                    return 810;
                } else {
                    return 809;
                }

            } elseif ($iTipoEnsino == 6) {

                if ($iTipoPasta == 1) {
                    return 818;
                } elseif ($iTipoPasta == 2) {
                    return 822;
                } else {
                    return 821;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 769;
                } elseif ($iTipoPasta == 2) {
                    return 774;
                } else {
                    return 773;
                }

            }

        } elseif ($iSubFuncao == 365) {

            if ($iTipoEnsino == 5) {

                if ($iTipoPasta == 1) {
                    return 806;
                } elseif ($iTipoPasta == 2) {
                    return 810;
                } else {
                    return 808;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 818;
                } elseif ($iTipoPasta == 2) {
                    return 822;
                } else {
                    return 820;
                }

            }

        } elseif ($iSubFuncao == 306) {

            if ($iTipoEnsino == 2) {
                return 782;
            } elseif ($iTipoEnsino == 3) {
                return 795;
            } elseif ($iTipoEnsino == 5) {
                return 806;
            } elseif ($iTipoEnsino == 6) {
                return 818;
            } else {
                return 769;
            }

        } else {

            if ($iTipoEnsino == 2) {

                if ($iTipoPasta == 1) {
                    return 782;
                } elseif ($iTipoPasta == 2) {
                    return 787;
                } else {
                    return 776;
                }

            } elseif ($iTipoEnsino == 3) {

                if ($iTipoPasta == 1) {
                    return 795;
                } elseif ($iTipoPasta == 2) {
                    return 798;
                } else {
                    return 789;
                }

            } elseif ($iTipoEnsino == 5) {

                if ($iTipoPasta == 1) {
                    return 806;
                } elseif ($iTipoPasta == 2) {
                    return 810;
                } else {
                    return 800;
                }

            } elseif ($iTipoEnsino == 6) {

                if ($iTipoPasta == 1) {
                    return 818;
                } elseif ($iTipoPasta == 2) {
                    return 822;
                } else {
                    return 812;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 769;
                } elseif ($iTipoPasta == 2) {
                    return 774;
                } else {
                    return 763;
                }

            }

        }

    }

    public function getCod106206($iSubFuncao, $iTipoEnsino, $iTipoPasta) {

        if ($iSubFuncao == 361) {
            return 1179;
        } elseif ($iSubFuncao == 362) {
            return 1190;
        } elseif ($iSubFuncao == 363) {
            return 1218;
        } elseif ($iSubFuncao == 364) {
            return 1206;
        } elseif ($iSubFuncao == 366) {

            if ($iTipoEnsino == 2) {
                return 1193;
            } else {
                return 1179;
            }

        } elseif ($iSubFuncao == 367) {

            if ($iTipoEnsino == 2) {
                return 1193;
            } elseif ($iTipoEnsino == 5) {
                return 1231;
            } elseif ($iTipoEnsino == 6) {
                return 1244;
            } else {
                return 1179;
            }

        } elseif ($iSubFuncao == 365) {

            if ($iTipoEnsino == 5) {
                return 1231;
            } else {
                return 1244;
            }

        } else {

            if ($iTipoEnsino == 2) {
                return 1193;
            } elseif ($iTipoEnsino == 3) {
                return 1218;
            } elseif ($iTipoEnsino == 4) {
                return 1206;
            } elseif ($iTipoEnsino == 5) {
                return 1231;
            } elseif ($iTipoEnsino == 6) {
                return 1244;
            } else {
                return 1179;
            }

        }

    }

    public function getCodGenerico($iSubFuncao, $iTipoEnsino, $iTipoPasta) {

        if ($iSubFuncao == 121) {

            if ($iTipoEnsino == 2) {
                return 1181;
            } elseif ($iTipoEnsino == 3) {
                return 1208;
            } elseif ($iTipoEnsino == 4) {
                return 1196;
            } elseif ($iTipoEnsino == 5) {
                return 1220;
            } elseif ($iTipoEnsino == 6) {
                return 1233;
            } else {
                return 1167;
            }

        } elseif ($iSubFuncao == 122) {

            if ($iTipoEnsino == 2) {
                return 1182;
            } elseif ($iTipoEnsino == 3) {
                return 1209;
            } elseif ($iTipoEnsino == 4) {
                return 1197;
            } elseif ($iTipoEnsino == 5) {
                return 1221;
            } elseif ($iTipoEnsino == 6) {
                return 1234;
            } else {
                return 1168;
            }

        } elseif ($iSubFuncao == 123) {

            if ($iTipoEnsino == 2) {
                return 1183;
            } elseif ($iTipoEnsino == 3) {
                return 1210;
            } elseif ($iTipoEnsino == 4) {
                return 1198;
            } elseif ($iTipoEnsino == 5) {
                return 1222;
            } elseif ($iTipoEnsino == 6) {
                return 1235;
            } else {
                return 1169;
            }

        } elseif ($iSubFuncao == 124) {

            if ($iTipoEnsino == 2) {
                return 1184;
            } elseif ($iTipoEnsino == 3) {
                return 1211;
            } elseif ($iTipoEnsino == 4) {
                return 1199;
            } elseif ($iTipoEnsino == 5) {
                return 1223;
            } elseif ($iTipoEnsino == 6) {
                return 1236;
            } else {
                return 1170;
            }

        } elseif ($iSubFuncao == 126) {

            if ($iTipoEnsino == 2) {
                return 1185;
            } elseif ($iTipoEnsino == 3) {
                return 1212;
            } elseif ($iTipoEnsino == 4) {
                return 1200;
            } elseif ($iTipoEnsino == 5) {
                return 1224;
            } elseif ($iTipoEnsino == 6) {
                return 1237;
            } else {
                return 1171;
            }

        } elseif ($iSubFuncao == 128) {

            if ($iTipoEnsino == 2) {
                return 1186;
            } elseif ($iTipoEnsino == 3) {
                return 1213;
            } elseif ($iTipoEnsino == 4) {
                return 1201;
            } elseif ($iTipoEnsino == 5) {
                return 1225;
            } elseif ($iTipoEnsino == 6) {
                return 1238;
            } else {
                return 1172;
            }

        } elseif ($iSubFuncao == 131) {

            if ($iTipoEnsino == 2) {
                return 1187;
            } elseif ($iTipoEnsino == 3) {
                return 1214;
            } elseif ($iTipoEnsino == 4) {
                return 1202;
            } elseif ($iTipoEnsino == 5) {
                return 1226;
            } elseif ($iTipoEnsino == 6) {
                return 1239;
            } else {
                return 1173;
            }

        } elseif ($iSubFuncao == 331) {

            if ($iTipoEnsino == 2) {
                return 1189;
            } elseif ($iTipoEnsino == 3) {
                return 1216;
            } elseif ($iTipoEnsino == 4) {
                return 1204;
            } elseif ($iTipoEnsino == 5) {
                return 1228;
            } elseif ($iTipoEnsino == 6) {
                return 1241;
            } else {
                return 1175;
            }

        } elseif ($iSubFuncao == 361) {

            if ($iTipoPasta == 1) {
                return 1174;
            } elseif ($iTipoPasta == 2) {
                return 1179;
            } else {
                return 1176;
            }

        } elseif ($iSubFuncao == 362) {

            if ($iTipoPasta == 1) {
                return 1188;
            } elseif ($iTipoPasta == 2) {
                return 1190;
            } else {
                return 1193;
            }

        } elseif ($iSubFuncao == 363) {

            if ($iTipoPasta == 1) {
                return 1215;
            } elseif ($iTipoPasta == 2) {
                return 1218;
            } else {
                return 1217;
            }

        } elseif ($iSubFuncao == 364) {

            if ($iTipoPasta == 1) {
                return 1203;
            } elseif ($iTipoPasta == 2) {
                return 1206;
            } else {
                return 1205;
            }

        } elseif ($iSubFuncao == 366) {

            if ($iTipoEnsino == 2) {

                if ($iTipoPasta == 1) {
                    return 1188;
                } elseif ($iTipoPasta == 2) {
                    return 1193;
                } else {
                    return 1191;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 1174;
                } elseif ($iTipoPasta == 2) {
                    return 1179;
                } else {
                    return 1177;
                }

            }

        } elseif ($iSubFuncao == 367) {

            if ($iTipoEnsino == 2) {

                if ($iTipoPasta == 1) {
                    return 1188;
                } elseif ($iTipoPasta == 2) {
                    return 1193;
                } else {
                    return 1192;
                }

            } elseif ($iTipoEnsino == 5) {

                if ($iTipoPasta == 1) {
                    return 1227;
                } elseif ($iTipoPasta == 2) {
                    return 1231;
                } else {
                    return 1230;
                }

            } elseif ($iTipoEnsino == 6) {

                if ($iTipoPasta == 1) {
                    return 1240;
                } elseif ($iTipoPasta == 2) {
                    return 1244;
                } else {
                    return 1243;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 1174;
                } elseif ($iTipoPasta == 2) {
                    return 1179;
                } else {
                    return 1178;
                }

            }

        } elseif ($iSubFuncao == 365) {

            if ($iTipoEnsino == 5) {

                if ($iTipoPasta == 1) {
                    return 1227;
                } elseif ($iTipoPasta == 2) {
                    return 1231;
                } else {
                    return 1229;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 1240;
                } elseif ($iTipoPasta == 2) {
                    return 1244;
                } else {
                    return 1242;
                }

            }

        } elseif ($iSubFuncao == 306) {

            if ($iTipoEnsino == 2) {
                return 1188;
            } elseif ($iTipoEnsino == 3) {
                return 1215;
            } elseif ($iTipoEnsino == 4) {
                return 1203;
            } elseif ($iTipoEnsino == 5) {
                return 1227;
            } elseif ($iTipoEnsino == 6) {
                return 1240;
            } else {
                return 1174;
            }

        } else {

            if ($iTipoEnsino == 2) {

                if ($iTipoPasta == 1) {
                    return 1188;
                } elseif ($iTipoPasta == 2) {
                    return 1193;
                } else {
                    return 1182;
                }

            } elseif ($iTipoEnsino == 3) {

                if ($iTipoPasta == 1) {
                    return 1215;
                } elseif ($iTipoPasta == 2) {
                    return 1218;
                } else {
                    return 1209;
                }

            } elseif ($iTipoEnsino == 4) {

                if ($iTipoPasta == 1) {
                    return 1203;
                } elseif ($iTipoPasta == 2) {
                    return 1206;
                } else {
                    return 1197;
                }

            } elseif ($iTipoEnsino == 5) {

                if ($iTipoPasta == 1) {
                    return 1227;
                } elseif ($iTipoPasta == 2) {
                    return 1231;
                } else {
                    return 1221;
                }

            } elseif ($iTipoEnsino == 6) {

                if ($iTipoPasta == 1) {
                    return 1240;
                } elseif ($iTipoPasta == 2) {
                    return 1244;
                } else {
                    return 1234;
                }

            } else {

                if ($iTipoPasta == 1) {
                    return 1174;
                } elseif ($iTipoPasta == 2) {
                    return 1179;
                } else {
                    return 1168;
                }

            }

        }

    }
}