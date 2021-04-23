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
        // db_criatabela($result);

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

                    echo '<pre>';print_r($oDespesa);echo '</pre>';

                    $iCodPlan = $this->getCodPlanilha($oDespesa);

                    if ($iCodPlan == 238 || $iCodPlan == 239 || $iCodPlan == 240 || $iCodPlan == 173) {
                        $oNaturdessiope = $this->getNaturDesSiope($oDespesa->o58_elemento, 't');
                    } else {
                        $oNaturdessiope = $this->getNaturDesSiope($oDespesa->o58_elemento, 'f');
                    }
                    if ((substr($oDespesa->o58_codigo,1,2) == 22)) {
                        // echo '<pre>';print_r($oDespesa);echo '</pre>';
                    }
                    if ((substr($oDespesa->o58_codigo,1,2) == 18 || substr($oDespesa->o58_codigo,1,2) == 19) && (substr($oNaturdessiope->c222_natdespsiope, 0, 3) == 331)) {
                        $sHashDesp = $oDespesa->o58_codigo.$iCodPlan.$oNaturdessiope->c222_natdespsiope;
                    } else {
                        $sHashDesp = $iCodPlan.$oNaturdessiope->c222_natdespsiope;
                    }

                    if (!isset($this->aDespesas[$sHashDesp])) {

                        $aArrayTemp = array();

                        $aArrayTemp['o58_codigo']       = $oDespesa->o58_codigo;
                        $aArrayTemp['o58_subfuncao']    = $oDespesa->o58_subfuncao;
                        $aArrayTemp['cod_planilha']     = $iCodPlan;
                        $aArrayTemp['elemento_siope']   = $oNaturdessiope->c222_natdespsiope;
                        $aArrayTemp['descricao_siope']  = $oNaturdessiope->c223_descricao;
                        $aArrayTemp['dot_atualizada']   = ($oDespesa->dot_ini + $oDespesa->suplementado_acumulado - $oDespesa->reduzido_acumulado);
                        $aArrayTemp['empenhado']        = 0;
                        $aArrayTemp['liquidado']        = 0;
                        $aArrayTemp['pagamento']        = 0;
                        $aArrayTemp['tipo']             = 'sintetico';

                        $this->aDespesas[$sHashDesp] = $aArrayTemp;                  

                    } else {
                        $this->aDespesas[$sHashDesp]['dot_atualizada'] += ($oDespesa->dot_ini + $oDespesa->suplementado_acumulado - $oDespesa->reduzido_acumulado);
                    }
                    
                    // echo '<pre>';print_r($oDespesa);echo '</pre>';

                    // $sele_work2         = " 1=1 and o58_orgao in ({$oDespesa->o58_orgao}) and ( ( o58_orgao = {$oDespesa->o58_orgao} and o58_unidade = {$oDespesa->o58_unidade} ) ) and o58_funcao in ({$oDespesa->o58_funcao}) and o58_subfuncao in ({$oDespesa->o58_subfuncao}) and o58_programa in ({$oDespesa->o58_programa}) and o58_projativ in ({$oDespesa->o58_projativ}) and (o56_elemento like '" . substr($oDespesa->o58_elemento, 0, 7) . "%') and o58_codigo in ({$oDespesa->o58_codigo}) and o58_instit in ({$this->iInstit}) and o58_anousu={$this->iAnoUsu} ";
                    // $cldesdobramento    = new cl_desdobramento();
                    // $sSqlDesd           = $cldesdobramento->sql($sele_work2, $this->dtIni, $this->dtFim, "({$this->iInstit})",'');
                    // $resDepsMes         = db_query($sSqlDesd) or die($sSqlDesd . pg_last_error());
                    // db_criatabela($resDepsMes);
                    
                    $sSqlDesd = "   SELECT  conplanoorcamento.c60_estrut,
                                            conplanoorcamento.c60_descr,
                                            substr(ele.o56_elemento||'00',1,15) AS o56_elemento,
                                            ele.o56_descr,
                                            e60_numconvenio,
                                            c207_esferaconcedente,
                                            COALESCE(SUM(CASE
                                                WHEN c53_tipo = 10 THEN ROUND(c70_valor, 2)
                                                WHEN c53_tipo = 11 THEN ROUND(c70_valor * -(1::FLOAT8),2)
                                                ELSE 0::FLOAT8
                                            END),0) AS empenhado,
                                            COALESCE(SUM(CASE
                                                WHEN c53_tipo = 20 THEN ROUND(c70_valor, 2)
                                                WHEN c53_tipo = 21 THEN ROUND(c70_valor * -(1::FLOAT8),2)
                                                ELSE 0::FLOAT8
                                            END),0) AS liquidado,
                                            COALESCE(SUM(CASE
                                                WHEN c53_tipo = 30 THEN ROUND(c70_valor, 2)
                                                WHEN c53_tipo = 31 THEN ROUND(c70_valor * -(1::FLOAT8),2)
                                                ELSE 0::FLOAT8
                                            END),0) AS pago
                                    FROM conlancamele
                                        INNER JOIN conlancam ON c67_codlan = c70_codlan
                                        INNER JOIN conlancamemp ON c75_codlan = c70_codlan
                                        INNER JOIN empempenho ON e60_numemp = c75_numemp AND e60_anousu = {$this->iAnoUsu}
                                        INNER JOIN orcdotacao ON o58_coddot = empempenho.e60_coddot AND o58_anousu = e60_anousu
                                        INNER JOIN conplanoorcamento ON c60_codcon = orcdotacao.o58_codele AND c60_anousu = {$this->iAnoUsu}
                                        INNER JOIN conlancamdoc ON c71_codlan = c70_codlan
                                        INNER JOIN conhistdoc ON c71_coddoc = c53_coddoc
                                        INNER JOIN orcelemento ele ON ele.o56_codele = conlancamele.c67_codele AND ele.o56_anousu = o58_anousu
                                        LEFT JOIN convconvenios ON e60_numconvenio = c206_sequencial
                                        LEFT JOIN convdetalhaconcedentes ON c207_codconvenio = c206_sequencial
                                    WHERE o58_orgao IN ({$oDespesa->o58_orgao})
                                        AND ((o58_orgao = {$oDespesa->o58_orgao} AND o58_unidade = {$oDespesa->o58_unidade}))
                                        AND o58_funcao IN ({$oDespesa->o58_funcao})
                                        AND o58_subfuncao IN ({$oDespesa->o58_subfuncao})
                                        AND o58_programa IN ({$oDespesa->o58_programa})
                                        AND o58_projativ IN ({$oDespesa->o58_projativ})
                                        AND (o56_elemento LIKE '" . substr($oDespesa->o58_elemento, 0, 7) . "%')
                                        AND o58_codigo IN ({$oDespesa->o58_codigo})
                                        AND o58_instit IN ({$this->iInstit})
                                        AND o58_anousu = {$this->iAnoUsu}
                                        AND empempenho.e60_instit IN ({$this->iInstit})
                                        AND (conlancam.c70_data >= '{$this->dtIni}' AND conlancam.c70_data <= '{$this->dtFim}')
                                        AND conhistdoc.c53_tipo IN (10, 11, 20, 21, 30, 31)
                                    GROUP BY c60_estrut,
                                            c60_descr,
                                            o56_elemento,
                                            o56_descr,
                                            e60_numconvenio,
                                            c207_esferaconcedente
                                    ORDER BY o56_elemento";

                    $resDepsMes = db_query($sSqlDesd) or die($sSqlDesd . pg_last_error());                    
                    // db_criatabela($resDepsMes);

                    for ($contDesp = 0; $contDesp < pg_num_rows($resDepsMes); $contDesp++) {

                        $oDadosMes = db_utils::fieldsMemory($resDepsMes, $contDesp);
                        echo '<pre>';print_r($oDadosMes);echo '</pre>';
                        
                        if ($iCodPlan == 238 || $iCodPlan == 239 || $iCodPlan == 240 || $iCodPlan == 173) {
                            $oNaturdessiopeDesd = $this->getNaturDesSiope($oDadosMes->o56_elemento, 't');
                        } else {
                            $oNaturdessiopeDesd = $this->getNaturDesSiope($oDadosMes->o56_elemento, 'f');
                        }

                        if ((substr($oDespesa->o58_codigo,1,2) == 18 || substr($oDespesa->o58_codigo,1,2) == 19) && (substr($oNaturdessiopeDesd->c222_natdespsiope, 0, 3) == 331)) {
                            $sHashDespDesd = $oDespesa->o58_codigo.$iCodPlan.$oNaturdessiopeDesd->c222_natdespsiope;
                        } else {
                            $sHashDespDesd = $iCodPlan.$oNaturdessiopeDesd->c222_natdespsiope;
                        }

                        if (!isset($this->aDespesas[$sHashDespDesd])) {                            

                            $aArrayDesdTemp = array();

                            $aArrayDesdTemp['o58_codigo']       = $oDespesa->o58_codigo;
                            $aArrayDesdTemp['o58_subfuncao']    = $oDespesa->o58_subfuncao;
                            $aArrayDesdTemp['cod_planilha']     = $iCodPlan;
                            $aArrayDesdTemp['elemento_siope']   = $oNaturdessiopeDesd->c222_natdespsiope;
                            $aArrayDesdTemp['descricao_siope']  = $oNaturdessiopeDesd->c223_descricao;
                            $aArrayDesdTemp['dot_atualizada']   = 0;
                            $aArrayDesdTemp['empenhado']        = $oDadosMes->empenhado;
                            $aArrayDesdTemp['liquidado']        = $oDadosMes->liquidado;
                            $aArrayDesdTemp['pagamento']        = $oDadosMes->pago;
                            $aArrayDesdTemp['tipo']             = 'analitico';
                            $aArrayDesdTemp['c207_esferaconcedente'] = $oDadosMes->c207_esferaconcedente;

                            $this->aDespesas[$sHashDespDesd] = $aArrayDesdTemp;

                        } else {

                            $this->aDespesas[$sHashDespDesd]['c207_esferaconcedente'] = $oDadosMes->c207_esferaconcedente;
                            $this->aDespesas[$sHashDespDesd]['empenhado'] += $oDadosMes->empenhado;
                            $this->aDespesas[$sHashDespDesd]['liquidado'] += $oDadosMes->liquidado;
                            $this->aDespesas[$sHashDespDesd]['pagamento'] += $oDadosMes->pago;

                        }

                    }

                }

            }

        }
        // echo '<pre>';print_r($this->aDespesas);echo '</pre>';

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

        if (substr($oDespesa->o58_codigo,1,2) == 01) {
            return $this->getCod101201($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif(substr($oDespesa->o58_codigo,1,2) == 06) {
            return $this->getCod106206($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif(substr($oDespesa->o58_codigo,1,2) == 07) {
            return $this->getCod107207($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif(substr($oDespesa->o58_codigo,1,2) == 18) {
            return $this->getCod118218($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif(substr($oDespesa->o58_codigo,1,2) == 19) {
            return $this->getCod119219($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif(substr($oDespesa->o58_codigo,1,2) == 66) {
            return $this->getCod166266($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif(substr($oDespesa->o58_codigo,1,2) == 67) {
            return $this->getCod167267($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif(substr($oDespesa->o58_codigo,1,2) == 44) {
            return $this->getCod144244($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);//aqui
        } elseif(substr($oDespesa->o58_codigo,1,2) == 45) {
            return $this->getCod145245($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif(substr($oDespesa->o58_codigo,1,2) == 43) {
            return $this->getCod143243($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif(substr($oDespesa->o58_codigo,1,2) == 22) {
            return $this->getCod122222($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif(substr($oDespesa->o58_codigo,1,2) == 46) {
            return $this->getCod146246($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif(substr($oDespesa->o58_codigo,1,2) == 47) {
            return $this->getCod147247($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } else {
            return $this->getCodGenerico($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        }

    }

    /**
     * Realiza De/Para da Natureza da despesa com tabela eledessiope composta pelo Cód Elemento e Descrição
     */
    public function getNaturDesSiope($elemento, $previdencia) {

        $clnaturdessiope    = new cl_naturdessiope();
        // echo $clnaturdessiope->sql_query_siope(substr($elemento, 0, 11),"", $this->iAnoUsu, $previdencia).'<br>';
        $rsNaturdessiope    = db_query($clnaturdessiope->sql_query_siope(substr($elemento, 0, 11),"", $this->iAnoUsu, $previdencia));
        // db_criatabela($rsNaturdessiope);

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

        switch ($iSubFuncao) {

            case 271: return 238;
            case 272: return 239;
            case 273: return 240;
            case 274: return 173;
            case 392: return 337;
            case 722: return 338;
            case 812: return 602;
            case 813: return 609;
            case 121:
            case 122:
            case 123:
            case 124:
            case 125:
            case 126:
            case 127:
            case 128:
            case 129:
            case 130:
            case 131:
                switch ($iTipoEnsino) {
                    case 2:
                        switch ($iTipoPasta) {                            
                            case 1: return 257;
                            case 2: return 258;
                            default: return 1398;
                        }                    
                    case 3:
                        switch ($iTipoPasta) {
                            case 1: return 296;
                            case 2: return 299;
                            default: return 1399;
                        }
                    case 4:
                        switch ($iTipoPasta) {
                            case 2: return 308;
                            default: return 1400;
                        }
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 710;
                            case 2: return 714;
                            default: return 1401;
                        }
                    case 6:
                        switch ($iTipoPasta) {                            
                            case 1: return 137;
                            case 2: return 315;
                            default: return 1402;
                        }
                    default:                        
                        switch ($iTipoPasta) {
                            case 1: return 5;
                            case 2: return 246;
                            default: return 1397;
                        }
                }                
            case 361:
                switch ($iTipoPasta) {
                    case 1: return 5;
                    case 2: return 246;
                    default: return 7;
                }
            case 362:
                switch ($iTipoPasta) {
                    case 1: return 257;
                    case 2: return 258;
                    default: return 189;
                }
            case 363:
                switch ($iTipoPasta) {
                    case 1: return 296;
                    case 2: return 299;
                    default: return 298;
                }
            case 364:
                switch ($iTipoPasta) {
                    case 2: return 308;
                    default: return 307;
                }
            case 366:
                switch ($iTipoEnsino) {
                    case 2:
                        switch ($iTipoPasta) {
                            case 1: return 257;
                            case 2: return 258;
                            default: return 1417;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 5;
                            case 2: return 246;
                            default: return 1415;
                        }
                        
                }
            case 367:
                switch ($iTipoEnsino) {                    
                    case 2:
                        switch ($iTipoPasta) {                            
                            case 1: return 257;
                            case 2: return 258;
                            default: return 1418;
                        }
                    case 5:
                        switch ($iTipoPasta) {                            
                            case 1: return 710;
                            case 2: return 714;
                            default: return 1419;
                        }
                    case 6:
                        switch ($iTipoPasta) {                            
                            case 1: return 137;
                            case 2: return 315;
                            default: return 1420;
                        }
                    default:
                        switch ($iTipoPasta) {                            
                            case 1: return 5;
                            case 2: return 246;
                            default: return 1416;
                        }
                }
            case 365:
                switch ($iTipoEnsino) {                    
                    case 5:
                        switch ($iTipoPasta) {                            
                            case 1: return 710;
                            case 2: return 714;
                            default: return 712;
                        }
                    default:
                        switch ($iTipoPasta) {                            
                            case 1: return 137;
                            case 2: return 315;
                            default: return 11;
                        }
                }
            case 306:
                switch ($iTipoEnsino) {
                    case 2: return 257;
                    case 3: return 296;
                    case 5: return 710; 
                    case 6: return 137; 
                    default: return 5;

                }
            case 782:
            case 784:
            case 785:
                switch ($iTipoEnsino) {
                    case 2: return 258;
                    case 3: return 299;
                    case 4: return 308;
                    case 5: return 714; 
                    case 6: return 315; 
                    default: return 246;

                }
            default:
                switch ($iTipoEnsino) {
                    case 2:
                        switch ($iTipoPasta) {
                            case 1: return 257;
                            case 2: return 258;
                            default: return 189;
                        }
                    case 3:
                        switch ($iTipoPasta) {
                            case 1: return 296;
                            case 2: return 299;
                            default: return 298;
                        }
                    case 4:
                        switch ($iTipoPasta) {
                            case 2: return 308;
                            default: return 307;
                        }
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 710;
                            case 2: return 714;
                            default: return 712;
                        }
                    case 6:
                        switch ($iTipoPasta) {
                            case 1: return 137;
                            case 2: return 315;
                            default: return 11;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 5;
                            case 2: return 246;
                            default: return 7;
                        }
                }                
                
        }
    }

    public function getCod106206($iSubFuncao, $iTipoEnsino, $iTipoPasta) {

        switch ($iSubFuncao) {
            
            case 361: return 1179;
            case 362: return 1193;
            case 363: return 1218;
            case 364: return 1206;
            case 366:
                switch ($iTipoEnsino) {
                    case 2: return 1193;
                    default: return 1179;
                }
            case 367:
                switch ($iTipoEnsino) {
                    case 2: return 1193;
                    case 5: return 1231;
                    case 6: return 1244;
                    default: return 1179;
                }
            case 365:
                switch ($iTipoEnsino) {
                    case 5: return 1232;
                    default: return 1244;
                }
            default:
                switch ($iTipoEnsino) {
                    case 2: return 1193;
                    case 3: return 1218;
                    case 4: return 1206;
                    case 5: return 1231;
                    case 6: return 1244;
                    default: return 1179;
                }

        }
    }

    public function getCod107207($iSubFuncao, $iTipoEnsino, $iTipoPasta) {

        switch ($iSubFuncao) {

            case 121:
            case 122:
            case 123:
            case 124:
            case 125:
            case 126:
            case 127:
            case 128:
            case 129:
            case 130:
            case 131:
                switch ($iTipoEnsino) {
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 1254;
                            case 2: return 1257;
                            default: return 1482;
                        }
                    case 6:
                        switch ($iTipoPasta) {
                            case 1: return 1259;
                            case 2: return 1262;
                            default: return 1483;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 1248;
                            case 2: return 1252;
                            default: return 1481;
                        }
                }
            case 361:
                switch ($iTipoPasta) {
                    case 1: return 1248;
                    case 2: return 1252;
                    default: return 1249;
                }
            case 366:
                switch ($iTipoPasta) {
                    case 1: return 1248;
                    case 2: return 1252;
                    default: return 1429;
                }
            case 367:
                switch ($iTipoEnsino) {
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 1254;
                            case 2: return 1257;
                            default: return 1431;
                        }
                    case 6:
                        switch ($iTipoPasta) {
                            case 1: return 1259;
                            case 2: return 1262;
                            default: return 1342;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 1248;
                            case 2: return 1252;
                            default: return 1430;
                        }
                }
            case 365:
                switch ($iTipoEnsino) {
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 1254;
                            case 2: return 1257;
                            default: return 1255;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 1259;
                            case 2: return 1262;
                            default: return 1260;
                        }
                }
            case 306:
                switch ($iTipoEnsino) {
                    case 5: return 1254;
                    case 6: return 1259;
                    default: return 1248;
                }
            case 782:
            case 784:
            case 785:
                switch ($iTipoEnsino) {
                    case 5: return 1257;
                    case 6: return 1262;
                    default: return 1252;
                }
            default:
                switch ($iTipoEnsino) {
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 1254;
                            case 2: return 1257;
                            default: return 1255;
                        }
                    case 6:
                        switch ($iTipoPasta) {
                            case 1: return 1259;
                            case 2: return 1262;
                            default: return 1260;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 1248;
                            case 2: return 1252;
                            default: return 1249;
                        }
                }
        }

    }

    public function getCod118218($iSubFuncao, $iTipoEnsino, $iTipoPasta) {

        switch ($iSubFuncao) {

            case 361: return 1651;
            case 366: return 1652;
            case 367:
                switch ($iTipoEnsino) {
                    case 5: return 1659;
                    case 6: return 1665;
                    default: return 1653;
                }
            case 365:
                switch ($iTipoEnsino) {
                    case 5: return 1658;
                    default: return 1664;
                }
            default:
                switch ($iTipoEnsino) {
                    case 5: return 1658;
                    case 6: return 1664;
                    default: return 1651;
                }
        }

    }

    public function getCod119219($iSubFuncao, $iTipoEnsino, $iTipoPasta) {

        switch ($iSubFuncao) {
            case 121:
            case 122:
            case 123:
            case 124:
            case 125:
            case 126:
            case 127:
            case 128:
            case 129:
            case 130:
            case 131:
                switch ($iTipoEnsino) {
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 1525;
                            case 2: return 1528;
                            default: return 1524;
                        }
                    case 6:
                        switch ($iTipoPasta) {
                            case 1: return 1531;
                            case 2: return 1534;
                            default: return 1530;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 1518;
                            case 2: return 1522;
                            default: return 1517;
                        }
                }
            case 361:
                switch ($iTipoPasta) {
                    case 1: return 1518;
                    case 2: return 1522;
                    default: return 1519;
                }
            case 366:
                switch ($iTipoPasta) {
                    case 1: return 1518;
                    case 2: return 1522;
                    default: return 1520;
                }
            case 367:
                switch ($iTipoEnsino) {
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 1525;
                            case 2: return 1528;
                            default: return 1527;
                        }
                    case 6:
                        switch ($iTipoPasta) {
                            case 1: return 1531;
                            case 2: return 1534;
                            default: return 1533;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 1518;
                            case 2: return 1522;
                            default: return 1521;
                        }
                }
            case 365:
                switch ($iTipoEnsino) {
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 1524;
                            case 2: return 1528;
                            default: return 1526;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 1531;
                            case 2; return 1534;
                            default: return 1532;
                        }
                }
            case 306:
                switch ($iTipoEnsino) {
                    case 5: return 1525;
                    case 6: return 1531;
                    default: return 1518;
                }
            case 782:
            case 784:
            case 785:
                switch ($iTipoEnsino) {
                    case 5: return 1528;
                    case 6: return 1534;
                    default: return 1522;
                }
            default:
                switch ($iTipoEnsino) {
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 1525;
                            case 2: return 1528;
                            default: return 1526;
                        }
                    case 6:
                        switch ($iTipoPasta) {
                            case 1: return 1531;
                            case 2: return 1534;
                            default: return 1532;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 1518;
                            case 2: return 1522;
                            default: return 1519;
                        }
                }

        }
    }

    public function getCod166266($iSubFuncao, $iTipoEnsino, $iTipoPasta) {

        switch ($iSubFuncao) {
            
            case 361: return 1689;
            case 366: return 1690;
            case 367:
                switch ($iTipoEnsino) {
                    case 5: return 1697;
                    case 6: return 1702;
                    default: return 1691;
                }
            case 365:
                switch ($iTipoEnsino) {
                    case 5: return 1696;
                    default: return 1702;
                }
            default:
                switch ($iTipoEnsino) {
                    case 5: return 1696;
                    case 6: return 1702;
                    default: return 1689;
                }
        }
    }

    public function getCod167267($iSubFuncao, $iTipoEnsino, $iTipoPasta) {

        switch ($iSubFuncao) {

            case 121:
            case 122:
            case 123:
            case 124:
            case 125:
            case 126:
            case 127:
            case 128:
            case 129:
            case 130:
            case 131:
                switch ($iTipoEnsino) {
                    case 5: 
                        switch ($iTipoPasta) {
                            case 1: return 1349;
                            case 2: return 1351;
                            default: return 1411;
                        }
                    case 6:
                        switch ($iTipoPasta) {
                            case 1: return 1353;
                            case 2: return 1355;
                            default: return 1412;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 1345;
                            case 2: return 1347;
                            default: return 1410;
                        }
                }
            case 361:
                switch ($iTipoPasta) {
                    case 1: return 1345;
                    case 2: return 1347;
                    default: return 1346;
                }
            case 366:
                switch ($iTipoPasta) {
                    case 1: return 1345;
                    case 2: return 1347;
                    default: return 1425;
                }
            case 367:
                switch ($iTipoEnsino) {
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 1349;
                            case 2: return 1351;
                            default: return 1427;
                        }
                    case 6: 
                        switch ($iTipoPasta) {
                            case 1: return 1353;
                            case 2: return 1355;
                            default: return 1428;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 1345;
                            case 2: return 1347;
                            default: return 1426;
                        }
                }
            case 365:
                switch ($iTipoEnsino) {
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 1349;
                            case 2: return 1351;
                            default: return 1350;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 1353;
                            case 2: return 1355;
                            default: return 1354;
                        }
                }
            case 306:
                switch ($iTipoEnsino) {
                    case 5: return 1349;
                    case 6: return 1353;
                    default: return 1345;
                }
            case 782:
            case 784:
            case 785:
                switch ($iTipoEnsino) {
                    case 5: return 1351;
                    case 6: return 1355;
                    default: return 1347;
                }
            default:
                switch ($iTipoEnsino) {
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 1349;
                            case 2: return 1351;
                            default: return 1350;
                        }
                    case 6:
                        switch ($iTipoPasta) {
                            case 1: return 1353;
                            case 2: return 1355;
                            default: return 1354;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 1345;
                            case 2: return 1347;
                            default: return 1346;
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