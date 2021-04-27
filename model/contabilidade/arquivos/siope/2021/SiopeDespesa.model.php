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

        $sqlSec = "SELECT   o58_orgao,
                            o58_unidade,
                            o58_funcao,
                            o58_programa,
                            o58_projativ,                 
                            o58_codigo,
                            o58_subfuncao,
                            o58_elemento,
                            o56_descr,
                            o55_tipoensino,
                            o55_tipopasta,
                            dot_ini,
                            suplementado_acumulado,
                            reduzido_acumulado,
                            empenhado,
                            anulado,
                            liquidado,
                            pago,
                            c222_natdespsiope,
                            c223_descricao
                            FROM ({$sqlprinc}) AS princ
                                LEFT JOIN naturdessiope ON substr(o58_elemento,1,11) = c222_natdespecidade AND c222_anousu = {$this->iAnoUsu}
                                LEFT JOIN eledessiope ON eledessiope.c223_eledespecidade = naturdessiope.c222_natdespsiope AND naturdessiope.c222_anousu = eledessiope.c223_anousu
                            WHERE o58_codigo > 0
                                AND o58_elemento != ''";

        $result = db_query($sqlSec) or die(pg_last_error());

        if (pg_num_rows($result) == 0) {
            throw new Exception ("Nenhum registro encontrado.");
        }

        for ($i = 0; $i < pg_numrows($result); $i++) {

            $oDespesa = db_utils::fieldsMemory($result, $i);

            $sHashDesp = $oDespesa->o58_subfuncao;
            $sHashDesp .= $oDespesa->o58_codigo;
            $sHashDesp .= $oDespesa->o55_tipoensino;
            $sHashDesp .= $oDespesa->o55_tipopasta;
            $sHashDesp .= $oDespesa->o58_elemento;

            if (!isset($this->aDespesas[$sHashDesp])) {

                $aArrayTemp = array();

                $aArrayTemp['o58_codigo']       = $oDespesa->o58_codigo;
                $aArrayTemp['o58_subfuncao']    = $oDespesa->o58_subfuncao;
                $aArrayTemp['elemento']         = $oDespesa->o58_elemento;
                $aArrayTemp['elemento_siope']   = $oDespesa->c222_natdespsiope;
                $aArrayTemp['descricao_siope']  = $oDespesa->c223_descricao;
                $aArrayTemp['dot_atualizada']   = ($oDespesa->dot_ini + $oDespesa->suplementado_acumulado - $oDespesa->reduzido_acumulado);
                $aArrayTemp['empenhado']        = 0;
                $aArrayTemp['liquidado']        = 0;
                $aArrayTemp['pagamento']        = 0;
                $aArrayTemp['tipo']             = 'sintetico';

                $this->aDespesas[$sHashDesp] = $aArrayTemp;                  

            } else {
                $this->aDespesas[$sHashDesp]['dot_atualizada'] += ($oDespesa->dot_ini + $oDespesa->suplementado_acumulado - $oDespesa->reduzido_acumulado);
            }
            
            $sSqlDesd = "   SELECT  conplanoorcamento.c60_estrut,
                                    conplanoorcamento.c60_descr,
                                    substr(ele.o56_elemento||'00',1,15) AS o56_elemento,
                                    ele.o56_descr,
                                    e60_numconvenio,
                                    c207_esferaconcedente,
                                    c222_natdespsiope,
                                    c223_descricao,
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
                                left join naturdessiope on substr(o56_elemento,1,11) = c222_natdespecidade and c222_anousu = {$this->iAnoUsu} and c222_previdencia = 'f'
                                left join eledessiope on eledessiope.c223_eledespecidade = naturdessiope.c222_natdespsiope and naturdessiope.c222_anousu = eledessiope.c223_anousu
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
                                    c207_esferaconcedente,
                                    c222_natdespsiope,
                                    c223_descricao
                            ORDER BY o56_elemento";
            
            $resDepsMes = db_query($sSqlDesd) or die($sSqlDesd . pg_last_error());                    

            for ($contDesp = 0; $contDesp < pg_num_rows($resDepsMes); $contDesp++) {

                $oDadosMes = db_utils::fieldsMemory($resDepsMes, $contDesp);                      

                $sHashDespDesd = $oDespesa->o58_subfuncao;
                $sHashDespDesd .= $oDespesa->o58_codigo;
                $sHashDespDesd .= $oDespesa->o55_tipoensino;
                $sHashDespDesd .= $oDespesa->o55_tipopasta;
                $sHashDespDesd .= $oDadosMes->o56_elemento;

                if (!isset($this->aDespesas[$sHashDespDesd])) {                            

                    $aArrayDesdTemp = array();

                    $aArrayDesdTemp['o58_codigo']       = $oDespesa->o58_codigo;
                    $aArrayDesdTemp['o58_subfuncao']    = $oDespesa->o58_subfuncao;
                    $aArrayDesdTemp['elemento']         = $oDadosMes->o56_elemento;
                    $aArrayDesdTemp['elemento_siope']   = $oDadosMes->c222_natdespsiope;
                    $aArrayDesdTemp['descricao_siope']  = $oDadosMes->c223_descricao;
                    $aArrayDesdTemp['dot_atualizada']   = 0;
                    $aArrayDesdTemp['empenhado']        = $oDadosMes->empenhado;
                    $aArrayDesdTemp['liquidado']        = $oDadosMes->liquidado;
                    $aArrayDesdTemp['pagamento']        = $oDadosMes->pago;
                    $aArrayDesdTemp['tipo']             = 'analitico';
                    $aArrayDesdTemp['e60_numconvenio']  = $oDadosMes->e60_numconvenio;
                    $aArrayDesdTemp['c207_esferaconcedente'] = $oDadosMes->c207_esferaconcedente;

                    $this->aDespesas[$sHashDespDesd] = $aArrayDesdTemp;

                } else {

                    $this->aDespesas[$sHashDespDesd]['c207_esferaconcedente'] = $oDadosMes->c207_esferaconcedente;
                    $this->aDespesas[$sHashDespDesd]['e60_numconvenio'] = $oDadosMes->e60_numconvenio;
                    $this->aDespesas[$sHashDespDesd]['empenhado'] += $oDadosMes->empenhado;
                    $this->aDespesas[$sHashDespDesd]['liquidado'] += $oDadosMes->liquidado;
                    $this->aDespesas[$sHashDespDesd]['pagamento'] += $oDadosMes->pago;

                }

            }

        }
        echo '<pre>';print_r($this->aDespesas);echo '</pre>';

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
        } elseif(substr($oDespesa->o58_codigo,1,2) == 22) {
            return $this->getCod122222($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif(substr($oDespesa->o58_codigo,1,2) == 43) {
            return $this->getCod143243($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif(substr($oDespesa->o58_codigo,1,2) == 44) {
            return $this->getCod144244($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);//aqui
        } elseif(substr($oDespesa->o58_codigo,1,2) == 45) {
            return $this->getCod145245($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif(substr($oDespesa->o58_codigo,1,2) == 46) {
            return $this->getCod146246($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif(substr($oDespesa->o58_codigo,1,2) == 47) {
            return $this->getCod147247($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif(substr($oDespesa->o58_codigo,1,2) == 66) {
            return $this->getCod166266($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif(substr($oDespesa->o58_codigo,1,2) == 67) {
            return $this->getCod167267($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif(substr($oDespesa->o58_codigo,1,2) == 90 || substr($oDespesa->o58_codigo,1,2) == 91) {
            return $this->getCod190191290291($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
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

    public function getCod122222($iSubFuncao, $iTipoEnsino, $iTipoPasta) {

        
    }
    
    public function getCod143243($iSubFuncao, $iTipoEnsino, $iTipoPasta) {

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
                     case 2:
                         switch ($iTipoPasta) {
                             case 1: return 1013;
                             case 2: return 1016;
                             default: return 1485;
                         }
                     case 3: 
                         switch ($iTipoPasta) {
                             case 1: return 1023;
                             case 2: return 1026;
                             default: return 1486;
                         }
                     case 5:
                         switch ($iTipoPasta) {
                             case 1: return 1033;
                             case 3: return 1036;
                             default: return 1487;
                         }
                     case 6:
                         switch ($iTipoPasta) {
                             case 1: return 1043;
                             case 2: return 1046;
                             default: return 1488;
                         }
                     default:
                         switch ($iTipoPasta) {
                             case 1: return 1003;
                             case 2: return 1006;
                             default: return 1484;
                         }
                 }
             case 361:
                 switch ($iTipoPasta) {
                     case 1: return 1003;
                     case 2: return 1006;
                     default: return 1147;
                 }
             case 362:
                 switch ($iTipoPasta) {
                     case 1: return 1013;
                     case 2: return 1016;
                     default: return 1149;
                 }
             case 363:
                 switch ($iTipoPasta) {
                     case 1: return 1023;
                     case 2: return 1026;
                     default: return 1151;
                 }
             case 366:
                 switch ($iTipoEnsino) {
                     case 2:
                         switch ($iTipoPasta) {
                             case 1: return 1013;
                             case 2: return 1016;
                             default: return 1447;
                         }
                     default:
                         switch ($iTipoPasta) {
                             case 1: return 1003;
                             case 2: return 1006;
                             default: return 1445;
                         }
                 }
             case 367:
                 switch ($iTipoEnsino) {
                     case 2:
                         switch ($iTipoPasta) {
                             case 1: return 1013;
                             case 2: return 1016;
                             default: return 1448;
                         }
                     case 5:
                         switch ($iTipoPasta) {
                             case 1: return 1033;
                             case 2: return 1036;
                             default: return 1449;
                         }
                     case 6:
                         switch ($iTipoPasta) {
                             case 1: return 1043;
                             case 2: return 1046;
                             default: return 1450;
                         }
                     default:
                         switch ($iTipoPasta) {
                             case 1: return 1003;
                             case 2: return 1006;
                             default: return 1446;
                         }
                 }
             case 365:
                 switch ($iTipoEnsino) {
                     case 5:
                         switch ($iTipoPasta) {
                             case 1: return 1033;
                             case 2: return 1036;
                             default: return 1152;
                         }
                     default:
                         switch ($iTipoPasta) {
                             case 1: return 1043;
                             case 2: return 1046;
                             default: return 1153;
                         }
                 }
             case 306:
                 switch ($iTipoEnsino) {
                     case 2: return 1013;
                     case 3: return 1023;
                     case 5: return 1033;
                     case 6: return 1043;
                     default: return 1003;
                 }
             case 782:
             case 784:
             case 785:
                 switch ($iTipoEnsino) {
                     case 2: return 1016;
                     case 3: return 1026;
                     case 5: return 1036;
                     case 6: return 1046;
                     default: return 1006;
                 }
             default:
                 switch ($iTipoEnsino) {
                     case 2:
                         switch ($iTipoPasta) {
                             case 1: return 1013;
                             case 2: return 1016;
                             default: return 1149;
                         }
                     case 3:
                         switch ($iTipoPasta) {
                             case 1: return 1023;
                             case 2: return 1026;
                             default: return 1151;
                         }
                     case 5:
                         switch ($iTipoPasta) {
                             case 1: return 1033;
                             case 2: return 1036;
                             default: return 1152;
                         }
                     case 6:
                         switch ($iTipoPasta) {
                             case 1: return 1043;
                             case 2: return 1046;
                             default: return 1153;
                         }
                     default:
                         switch ($iTipoPasta) {
                             case 1: return 1003;
                             case 2: return 1006;
                             default: return 1147;
                         }
                 }
 
        }
 
     }
 
     public function getCod144244($iSubFuncao, $iTipoEnsino, $iTipoPasta) {
 
         switch ($iSubFuncao) {
 
             case 361: return 867;
             case 362: return 880;
             case 363: return 893;
             case 365:
                 switch ($iTipoEnsino) {
                     case 5: return 904;
                     default: return 916;
                 }
             default:
                 switch ($iTipoEnsino) {
                     case 2: return 880;
                     case 3: return 893;
                     case 5: return 904;
                     case 6: return 916;
                     default: return 867;
                 }
         
         }
 
     }
 
     public function getCod145245($iSubFuncao, $iTipoEnsino, $iTipoPasta) {
 
         switch ($iSubFuncao) {
 
             case 361: return 933;
             case 362: return 946;
             case 363: return 957;
             case 365:
                 switch ($iTipoEnsino) {
                     case 5: return 969;
                     default: return 981;
                 }
             default:
                 switch ($iTipoEnsino) {
                     case 2: return 946;
                     case 3: return 957;
                     case 5: return 969;
                     case 6: return 981;
                     default: return 933;
                 }
 
         }
 
     }
 
 
     public function getCod146246($iSubFuncao, $iTipoEnsino, $iTipoPasta) {

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
                    case 2:
                        switch ($iTipoPasta) {
                            case 1: return 1063;
                            case 2: return 1066;
                            default: return 1490;
                        }
                    case 3:
                        switch ($iTipoPasta) {
                            case 1: return 1073;
                            case 2: return 1076;
                            default: return 1491;
                        }
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 1083;
                            case 2: return 1086;
                            default: return 1492;
                        }
                    case 6:
                        switch ($iTipoPasta) {
                            case 1: return 1093;
                            case 2: return 1096;
                            default: return 1493;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 1053;
                            case 2: return 1056;
                            default: return 1489;
                        }
                }
            case 361:
                switch ($iTipoPasta) {
                    case 1: return 1053;
                    case 2: return 1056;
                    default: return 1154;
                }
            case 362:
                switch ($iTipoPasta) {
                    case 1: return 1063;
                    case 2: return 1066;
                    default: return 1156;
                }
            case 363:
                switch ($iTipoPasta) {
                    case 1: return 1073;
                    case 2: return 1076;
                    default: return 1158;
                }
            case 366:
                switch ($iTipoEnsino) {
                    case 2:
                        switch ($iTipoPasta) {
                            case 1: return 1063;
                            case 2: return 1066;
                            default: return 1453;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 1053;
                            case 2: return 1056;
                            default: return 1451;
                        }
                }
            case 367:
                switch ($iTipoEnsino) {
                    case 2:
                        switch ($iTipoPasta) {
                            case 1: return 1063;
                            case 2: return 1066;
                            default: return 1454;
                        }
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 1083;
                            case 2: return 1086;
                            default: return 1455;
                        }
                    case 6:
                        switch ($iTipoPasta) {
                            case 1: return 1093;
                            case 2: return 1096;
                            default: return 1456;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 1053;
                            case 2: return 1056;
                            default: return 1452;
                        }
                }
            case 365: 
                switch ($iTipoEnsino) {
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 1083;
                            case 2: return 1086;
                            default: return 1159;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 1093;
                            case 2: return 1096;
                            default: return 1160;
                        }
                }
            case 306:
                switch ($iTipoEnsino) {
                    case 2: return 1063;
                    case 3: return 1073;
                    case 5: return 1083;
                    case 6: return 1093;
                    default: return 1053;
                }
            case 782:
            case 784:
            case 785:
                switch ($iTipoEnsino) {
                    case 2: return 1066;
                    case 3: return 1076;
                    case 5: return 1096;
                    default: return 1056;
                }
            default:
                switch ($iTipoEnsino) {
                    case 2:
                        switch ($iTipoPasta) {
                            case 1: return 1063;
                            case 2: return 1066;
                            default: return 1156;
                        }
                    case 3: 
                        switch ($iTipoPasta) {
                            case 1: return 1073;
                            case 2: return 1076;
                            default: return 1158;
                        }
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 1083;
                            case 2: return 1086;
                            default: return 1159;
                        }
                    case 6:
                        switch ($iTipoPasta) {
                            case 1: return 1093;
                            case 2: return 1096;
                            default: return 1160;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 1053;
                            case 2: return 1056;
                            default: return 1154;
                        }
                }
        
        }
 
     }
 
     public function getCod147247($iSubFuncao, $iTipoEnsino, $iTipoPasta) {
        
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
                    case 2:
                        switch ($iTipoPasta) {
                            case 1: return 782;
                            case 2: return 787;
                            default: return 1511;
                        }
                    case 3:
                        switch ($iTipoPasta) {
                            case 1: return 795;
                            case 2: return 798;
                            default: return 1512;
                        }
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 806;
                            case 2: return 810;
                            default: return 1513;
                        }
                    case 6:
                        switch ($iTipoPasta) {
                            case 1: return 818;
                            case 2: return 822;
                            default: return 1514;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 769;
                            case 2: return 774;
                            default: return 1510;
                        }
                }
            case 361:
                switch ($iTipoPasta) {
                    case 1: return 769;
                    case 2: return 774;
                    default: return 771;
                }
            case 362:
                switch ($iTipoPasta) {
                    case 1: return 782;
                    case 2: return 787;
                    default: return 784;
                }
            case 363:
                switch ($iTipoPasta) {
                    case 1: return 795;
                    case 2: return 798;
                    default: return 797;
                }
            case 366:
                switch ($iTipoEnsino) {
                    case 2:
                        switch ($iTipoPasta) {
                            case 1: return 782;
                            case 2: return 787;
                            default: return 1477;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 769;
                            case 2: return 774;
                            default: return 1475;
                        }
                }
            case 367:
                switch ($iTipoEnsino) {
                    case 2:
                        switch ($iTipoPasta) {
                            case 1: return 782;
                            case 2: return 787;
                            default: return 1478;
                        }
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 806;
                            case 2: return 810;
                            default: return 1479;
                        }
                    case 6:
                        switch ($iTipoPasta) {
                            case 1: return 818;
                            case 2: return 822;
                            default: return 1480;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 769;
                            case 2: return 774;
                            default: return 1476;
                        }
                }
            case 365:
                switch ($iTipoEnsino) {
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 806;
                            case 2: return 810;
                            default: return 808;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 818;
                            case 2: return 822;
                            default: return 820;
                        }
                }
            case 306:
                switch ($iTipoEnsino) {
                    case 2: return 782;
                    case 3: return 795;
                    case 5: return 806;
                    case 6: return 818;
                    default: return 769;
                }
            case 782:
            case 784:
            case 785:
                switch ($iTipoEnsino) {
                    case 2: return 787;
                    case 3: return 798;
                    case 5: return 810;
                    case 6: return 822;
                    default: return 774;
                }
            default:
                switch ($iTipoEnsino) {
                    case 2:
                        switch ($iTipoPasta) {
                            case 1: return 782;
                            case 2: return 787;
                            default: return 784;
                        }
                    case 3: 
                        switch ($iTipoPasta) {
                            case 1: return 795;
                            case 2: return 798;
                            default: return 797;
                        }
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 806;
                            case 2: return 810;
                            default: return 808;
                        }
                    case 6:
                        switch ($iTipoPasta) {
                            case 1: return 818;
                            case 2: return 822;
                            default: return 820;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 769;
                            case 2: return 774;
                            default: return 771;
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

    public function getCod190191290291($iSubFuncao, $iTipoEnsino, $iTipoPasta) {

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
                    case 2:
                        switch ($iTipoPasta) {
                            case 1: return 1581;
                            case 2: return 1620;
                            default: return 1580;
                        }
                    case 3:
                        switch ($iTipoPasta) {
                            case 1: return 1585;
                            case 2: return 1622;
                            default: return 1584;
                        }
                    case 4:
                        switch ($iTipoPasta) {
                            case 1: return 1588;
                            case 2: return 1624;
                            default: return 1587;
                        }
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 1591;
                            case 2: return 1627;
                            default: return 1590;
                        }
                    case 6:
                        switch ($iTipoPasta) {
                            case 1: return 1594;
                            case 2: return 1630;
                            default: return 1593;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 1577;
                            case 2: return 1619;
                            default: return 1576;
                        }
                }
            case 361:
                switch ($iTipoPasta) {
                    case 1: return 1577;
                    case 2: return 1619;
                    default: return 1578;
                }
            case 362:
                switch ($iTipoPasta) {
                    case 1: return 1581;
                    case 2: return 1620;
                    default: return 1582;
                }
            case 363:
                switch ($iTipoPasta) {
                    case 1: return 1585;
                    case 2: return 1622;
                    default: return 1621;
                }
            case 364:
                switch ($iTipoPasta) {
                    case 1: return 1588;
                    case 2: return 1624;
                    default: return 1623;
                }
            case 366:
                switch ($iTipoEnsino) {
                    case 2:
                        switch ($iTipoPasta) {
                            case 1: return 1581;
                            case 2: return 1620;
                            default: return 1641;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 1577;
                            case 2: return 1619;
                            default: return 1639;
                        }
                }
            case 367;
                switch ($iTipoEnsino) {
                    case 2:
                        switch ($iTipoPasta) {
                            case 1: return 1581;
                            case 2: return 1620;
                            default: return 1642;
                        }
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 1591;
                            case 2: return 1627;
                            default: return 1626;
                        }
                    case 6:
                        switch ($iTipoPasta) {
                            case 1: return 1594;
                            case 2: return 1630;
                            default: return 1629;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 1577;
                            case 2: return 1619;
                            default: return 1640;
                        }
                }
            case 365:
                switch ($iTipoEnsino) {
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 1591;
                            case 2: return 1627;
                            default: return 1625;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 1594;
                            case 2: return 1630;
                            default: return 1628;
                        }
                }
            case 306:
                switch ($iTipoEnsino) {
                    case 2: return 1581;
                    case 3: return 1585;
                    case 4: return 1588;
                    case 5: return 1591;
                    case 6: return 1594;
                    default: return 1577;
                }
            case 782:
            case 784:
            case 785:
                switch ($iTipoEnsino) {
                    case 2: return 1620;
                    case 3: return 1622;
                    case 4: return 1624;
                    case 5: return 1627;
                    case 6: return 1630;
                    default: return 1619;
                }
            default:
                switch ($iTipoEnsino) {
                    case 2: 
                        switch ($iTipoPasta) {
                            case 1: return 1581;
                            case 2: return 1620;
                            default: return 1582;
                        }
                    case 3:
                        switch ($iTipoPasta) {
                            case 1: return 1585;
                            case 2: return 1622;
                            default: return 1621;
                        }
                    case 4:
                        switch ($iTipoPasta) {
                            case 1: return 1588;
                            case 2: return 1624;
                            default: return 1623;
                        }
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 1591;
                            case 2: return 1627;
                            default: return 1625;
                        }
                    case 6: 
                        switch ($iTipoPasta) {
                            case 1: return 1594;
                            case 2: return 1630;
                            default: return 1628;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 1577;
                            case 2: return 1619;
                            default: return 1578;
                        }
                }
        }
    }

    public function getCodGenerico($iSubFuncao, $iTipoEnsino, $iTipoPasta) {

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
                    case 2:
                        switch ($iTipoPasta) {
                            case 1: return 1375;
                            case 2: return 1377;
                            default: return 1506;
                        }
                    case 3:
                        switch ($iTipoPasta) {
                            case 1: return 1378;
                            case 2: return 1380;
                            default: return 1507;
                        }
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 1381;
                            case 2: return 1383;
                            default: return 1508;
                        }
                    case 6:
                        switch ($iTipoPasta) {
                            case 1: return 1384;
                            case 2: return 1386;
                            default: return 1509;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 1372;
                            case 2: return 1374;
                            default: return 1505;
                        }
                }
            case 361:
                switch ($iTipoPasta) {
                    case 1: return 1372;
                    case 2: return 1374;
                    default: return 1373;
                }
            case 362:
                switch ($iTipoPasta) {
                    case 1: return 1375;
                    case 2: return 1377;
                    default: return 1376;
                }
            case 363:
                switch ($iTipoPasta) {
                    case 1: return 1378;
                    case 2: return 1380;
                    default: return 1379;
                }
            case 366:
                switch ($iTipoEnsino) {
                    case 2:
                        switch ($iTipoPasta) {
                            case 1: return 1375;
                            case 2: return 1377;
                            default: return 1471;
                    }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 1372;
                            case 2: return 1374;
                            default: return 1469;
                        }
                    
                }
            case 367:
                switch ($iTipoEnsino) {
                    case 2:
                        switch ($iTipoPasta) {
                            case 1: return 1375;
                            case 2: return 1377;
                            default: return 1472;
                        }
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 1381;
                            case 2: return 1383;
                            default: return 1473;
                        }
                    case 6:
                        switch ($iTipoPasta) {
                            case 1: return 1384;
                            case 2: return 1386;
                            default: return 1474;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 1372;
                            case 2: return 1374;
                            default: return 1470;
                        }
                }
            case 365:
                switch ($iTipoEnsino) {
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 1381;
                            case 2: return 1383;
                            default: return 1382;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 1384;
                            case 2: return 1386;
                            default: return 1385;
                        }
                }
            case 366:
                switch ($iTipoEnsino) {
                    case 2: return 1375;
                    case 3: return 1378;
                    case 5: return 1381;
                    case 6: return 1384;
                    default: return 1372;
                }
            case 782:
            case 784:
            case 785:
                switch ($iTipoEnsino) {
                    case 2: return 1377;
                    case 3: return 1380;
                    case 5: return 1383;
                    case 6: return 1386;
                    default: return 1374;
                }
            default:
                switch ($iTipoEnsino) {
                    case 2:
                        switch ($iTipoPasta) {
                            case 1: return 1375;
                            case 2: return 1377;
                            default: return 1376;
                        }
                    case 3:
                        switch ($iTipoPasta) {
                            case 1: return 1378;
                            case 2: return 1380;
                            default: return 1379;
                        }
                    case 5:
                        switch ($iTipoPasta) {
                            case 1: return 1381;
                            case 2: return 1383;
                            default: return 1382;
                        }
                    case 6:
                        switch ($iTipoPasta) {
                            case 1: return 1384;
                            case 2: return 1386;
                            default: return 1385;
                        }
                    default:
                        switch ($iTipoPasta) {
                            case 1: return 1372;
                            case 2: return 1374;
                            default: return 1373;
                        }
                }
        }

    }
}