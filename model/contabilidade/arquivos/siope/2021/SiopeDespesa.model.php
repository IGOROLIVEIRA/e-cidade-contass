<?php

class SiopeDespesa extends Siope {

    //@var array
    public $aDespesas = array();
    //@var array
    public $aDespesasAgrupadas = array();
    //@var array
    public $aDespeAgrupaFundeb = array();

    public $csv = null;

    public function gerarSiope() {

        $aDados = $this->aDespesasAgrupadas;

        if (file_exists("model/contabilidade/arquivos/siope/{$this->iAnoUsu}/SiopeCsv.model.php")) {

            require_once("model/contabilidade/arquivos/siope/{$this->iAnoUsu}/SiopeCsv.model.php");

            $this->csv = new SiopeCsv;
            $this->csv->setNomeArquivo($this->getNomeArquivo());
            $this->csv->gerarArquivoCSV($aDados, 1);

        }

        $this->gerarDadosFundeb();
        $this->csv->gerarArquivoCSV($this->aDespeAgrupaFundeb, 3);

    }

    public function gerarDadosFundeb() {

        $oDesp = new stdClass();
        $oDesp->empenhado       = 0;
        $oDesp->liquidado       = 0;
        $oDesp->pagamento       = 0;
        $oDesp->rp_nprocessado  = 0;
        
        $this->agrupaFundeb($oDespesa, 13);
        $this->agrupaFundeb($oDespesa, 14);
        $this->agrupaFundeb($oDespesa, 15);
        $this->agrupaFundeb($oDespesa, 16);
        $this->agrupaFundeb($oDespesa, 17);
        $this->agrupaFundeb($oDespesa, 18);
        $this->setDescricaoFundeb();

        foreach ($this->aDespesas as $oDespesa) {
            
            if (in_array($oDespesa->o58_codigo, array(118, 166))) {
                $this->agrupaFundeb($oDespesa, 13);
            }
            
            if (in_array($oDespesa->o58_codigo, array(118, 119, 166, 167))) {
                $this->agrupaFundeb($oDespesa, 14);
            }

            if (in_array($oDespesa->o58_codigo, array(166, 167))) {
                $this->agrupaFundeb($oDespesa, 16);
            }

            if (in_array($oDespesa->o58_codigo, array(166, 167))) {

                if ($oDespesa->o58_subfuncao == 365) {
                    $this->agrupaFundeb($oDespesa, 17);
                } elseif (in_array($oDespesa->o55_tipoensino, array(5, 6))) {
                    $this->agrupaFundeb($oDespesa, 17);
                }

            }

            if (in_array($oDespesa->o58_codigo, array(166, 167)) && substr($oDespesa->elemento,0,2) == '34') {
                $this->agrupaFundeb($oDespesa, 18);
            }
        }

    }

    public function agrupaFundeb($oDespesa, $iCodLinha) {

        $this->aDespeAgrupaFundeb[$iCodLinha]->empenhado       += $oDespesa->empenhado;
        $this->aDespeAgrupaFundeb[$iCodLinha]->liquidado       += $oDespesa->liquidado;
        $this->aDespeAgrupaFundeb[$iCodLinha]->pagamento       += $oDespesa->pagamento;
        $this->aDespeAgrupaFundeb[$iCodLinha]->rp_nprocessado  += ($oDespesa->empenhado - $oDespesa->liquidado);
        $this->aDespeAgrupaFundeb[$iCodLinha]->rp_nprocscx      = 0;

    }

    public function setDescricaoFundeb() {

        $this->aDespeAgrupaFundeb[13]->descricao = 'Total das Despesas do FUNDEB com Profissionais da Educação Básica';
        $this->aDespeAgrupaFundeb[14]->descricao = 'Total das Despesas custeadas com FUNDEB - Impostos e Transferências de Impostos';
        $this->aDespeAgrupaFundeb[15]->descricao = 'Total das Despesas custeadas com FUNDEB - Complementação da União - VAAF';
        $this->aDespeAgrupaFundeb[16]->descricao = 'Total das Despesas custeadas com FUNDEB - Complementação da União - VAAT';
        $this->aDespeAgrupaFundeb[17]->descricao = 'Total das Despesas custeadas com FUNDEB - Complementação da União - VAAT Aplicadas na Educação Infantil';
        $this->aDespeAgrupaFundeb[18]->descricao = 'Total das Despesas custeadas com FUNDEB - Complementação da União - VAAT Aplicadas em Despesa de Capital';

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
                            o58_elemento as o56_elemento,
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
                            substr(c222_natdespsiope,1,8) AS c222_natdespsiope,
                            c223_descricao
                            FROM ({$sqlprinc}) AS princ
                                LEFT JOIN naturdessiope ON o58_elemento = substr(c222_natdespecidade,1,13) AND c222_anousu = {$this->iAnoUsu}
                                LEFT JOIN eledessiope ON eledessiope.c223_eledespsiope = substr(naturdessiope.c222_natdespsiope,1,8) AND naturdessiope.c222_anousu = eledessiope.c223_anousu
                            WHERE o58_codigo > 0
                                AND o58_elemento != ''
                            ORDER BY o58_codigo";

        $result = db_query($sqlSec) or die(pg_last_error());

        if (pg_num_rows($result) == 0) {
            throw new Exception ("Nenhum registro encontrado.");
        }

        for ($i = 0; $i < pg_numrows($result); $i++) {

            $oDespesa = db_utils::fieldsMemory($result, $i);

            $this->verificaDePara($oDespesa);

            $sHashDesp = $oDespesa->o58_subfuncao;
            $sHashDesp .= $oDespesa->o58_codigo;
            $sHashDesp .= $oDespesa->o55_tipoensino;
            $sHashDesp .= $oDespesa->o55_tipopasta;
            $sHashDesp .= $oDespesa->o56_elemento;

            if (!isset($this->aDespesas[$sHashDesp])) {

                $oDesp = new stdClass();

                $oDesp->o58_codigo       = $oDespesa->o58_codigo;
                $oDesp->o58_subfuncao    = $oDespesa->o58_subfuncao;
                $oDesp->o55_tipoensino   = $oDespesa->o55_tipoensino;
                $oDesp->o55_tipopasta    = $oDespesa->o55_tipopasta;
                $oDesp->elemento         = $oDespesa->o56_elemento;
                $oDesp->elemento_siope   = $oDespesa->c222_natdespsiope;
                $oDesp->descricao_siope  = $oDespesa->c223_descricao;
                $oDesp->dot_atualizada   = ($oDespesa->dot_ini + $oDespesa->suplementado_acumulado - $oDespesa->reduzido_acumulado);
                $oDesp->empenhado        = 0;
                $oDesp->liquidado        = 0;
                $oDesp->pagamento        = 0;
                $oDesp->tipo             = 1; //analítico
                $oDesp->esferaconcedente = 1;

                $this->aDespesas[$sHashDesp] = $oDesp;                  

            } else {
                $this->aDespesas[$sHashDesp]->dot_atualizada += ($oDespesa->dot_ini + $oDespesa->suplementado_acumulado - $oDespesa->reduzido_acumulado);
            }
            
            $sSqlDesd = "   SELECT  conplanoorcamento.c60_estrut,
                                    conplanoorcamento.c60_descr,
                                    ele.o56_elemento,
                                    ele.o56_descr,
                                    e60_numconvenio,
                                    c207_esferaconcedente as esferaconcedente,
                                    substr(c222_natdespsiope,1,8) AS c222_natdespsiope,
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
                                LEFT JOIN naturdessiope ON o56_elemento = substr(c222_natdespecidade,1,13) AND c222_anousu = {$this->iAnoUsu}
                                LEFT JOIN eledessiope ON eledessiope.c223_eledespsiope = substr(naturdessiope.c222_natdespsiope,1,8) AND naturdessiope.c222_anousu = eledessiope.c223_anousu
                            WHERE o58_orgao IN ({$oDespesa->o58_orgao})
                                AND ((o58_orgao = {$oDespesa->o58_orgao} AND o58_unidade = {$oDespesa->o58_unidade}))
                                AND o58_funcao IN ({$oDespesa->o58_funcao})
                                AND o58_subfuncao IN ({$oDespesa->o58_subfuncao})
                                AND o58_programa IN ({$oDespesa->o58_programa})
                                AND o58_projativ IN ({$oDespesa->o58_projativ})
                                AND (o56_elemento LIKE '" . substr($oDespesa->o56_elemento, 0, 7) . "%')
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

                $this->verificaDePara($oDadosMes);
                
                if(substr($oDespesa->o58_codigo,1,2) == 22) {
                    $this->verificaConvenio($oDadosMes);
                }

                $sHashDespDesd = $oDespesa->o58_subfuncao;
                $sHashDespDesd .= $oDespesa->o58_codigo;
                $sHashDespDesd .= $oDespesa->o55_tipoensino;
                $sHashDespDesd .= $oDespesa->o55_tipopasta;
                $sHashDespDesd .= $oDadosMes->o56_elemento;
                $sHashDespDesd .= $oDadosMes->e60_numconvenio;
                $sHashDespDesd .= $oDadosMes->esferaconcedente;

                if (!isset($this->aDespesas[$sHashDespDesd])) {                            

                    $oDespDesd = new stdClass();

                    $oDespDesd->o58_codigo       = $oDespesa->o58_codigo;
                    $oDespDesd->o58_subfuncao    = $oDespesa->o58_subfuncao;
                    $oDespDesd->o55_tipoensino   = $oDespesa->o55_tipoensino;
                    $oDespDesd->o55_tipopasta    = $oDespesa->o55_tipopasta;
                    $oDespDesd->elemento         = $oDadosMes->o56_elemento;
                    $oDespDesd->elemento_siope   = $oDadosMes->c222_natdespsiope;
                    $oDespDesd->descricao_siope  = $oDadosMes->c223_descricao;
                    $oDespDesd->dot_atualizada   = 0;
                    $oDespDesd->empenhado        = $oDadosMes->empenhado;
                    $oDespDesd->liquidado        = $oDadosMes->liquidado;
                    $oDespDesd->pagamento        = $oDadosMes->pago;
                    $oDespDesd->tipo             = 2; //analítico
                    $oDespDesd->e60_numconvenio  = $oDadosMes->e60_numconvenio;
                    $oDespDesd->esferaconcedente = $oDadosMes->esferaconcedente;

                    $this->aDespesas[$sHashDespDesd] = $oDespDesd;

                } else {

                    $this->aDespesas[$sHashDespDesd]->esferaconcedente = $oDadosMes->esferaconcedente;
                    $this->aDespesas[$sHashDespDesd]->e60_numconvenio = $oDadosMes->e60_numconvenio;
                    $this->aDespesas[$sHashDespDesd]->empenhado += $oDadosMes->empenhado;
                    $this->aDespesas[$sHashDespDesd]->liquidado += $oDadosMes->liquidado;
                    $this->aDespesas[$sHashDespDesd]->pagamento += $oDadosMes->pago;

                }

            }

        }

    }

    /**
     * Agrupa despesas somando valores pela FONTE, CÓDIGO DE PLANILHA e ELEMENTO DA DESPESA iguais.
     * Tratando exceção das fontes 122/222
     */
    public function agrupaDespesas() {

        $aDespAgrup = array();
        // $this->imprimeTabela($this->aDespesas);
        /**
         * Agrupa despesas.
         */
        foreach($this->aDespesas as $oDespesa) {

            $iCodPlanilha = $this->getCodPlanilha($oDespesa);

            $sHash = $iCodPlanilha.$oDespesa->o58_codigo.$oDespesa->elemento_siope;
            
            /**
             * Caso específico das fontes 122/222
             * Por padrão, a dotação atualizada é do convênio federal (esferaconcedente == 1 ou esferaconcedente == '')
             * Caso o convênio seja de outra esfera:
             *      a dotação atualizada será o valor empenhado
             *      e deduzida no valor da esfera federal (tipo == 1 - sintético)
             */
            
            if (substr($oDespesa->o58_codigo,1,2) == 22) {
                
                if ($oDespesa->tipo == 1) {
                    $sHashSintetico = $sHash;
                }

                if (!isset($this->aDespesasAgrupadas[$sHash])) {
                    
                    $oDesp = new stdClass();

                    $oDesp->o58_codigo          = $oDespesa->o58_codigo;
                    $oDesp->cod_planilha        = $iCodPlanilha;
                    $oDesp->elemento_siope      = $oDespesa->elemento_siope;
                    $oDesp->descricao_siope     = $oDespesa->descricao_siope;
                    if ($oDespesa->esferaconcedente != 1) {
                        $oDesp->dot_atualizada  = $oDespesa->empenhado;
                    } else {
                        $oDesp->dot_atualizada  = $oDespesa->dot_atualizada;
                    }
                    $oDesp->empenhado           = $oDespesa->empenhado;
                    $oDesp->liquidado           = $oDespesa->liquidado;
                    $oDesp->pagamento           = $oDespesa->pagamento;
                    $oDesp->rp_processado       = ($oDespesa->liquidado - $oDespesa->pagamento);
                    $oDesp->rp_nprocessado      = ($oDespesa->empenhado - $oDespesa->liquidado);                    
                    // $oDesp->esferaconcedente      = $oDespesa->esferaconcedente;       

                    $this->aDespesasAgrupadas[$sHash] = $oDesp;
                    
                } else {
                    
                    if ($oDespesa->esferaconcedente != '') {
                        $this->aDespesasAgrupadas[$sHash]->dot_atualizada += $oDespesa->empenhado;
                    } else {
                        $this->aDespesasAgrupadas[$sHash]->dot_atualizada += $oDespesa->dot_atualizada;
                    }
                    
                    $this->aDespesasAgrupadas[$sHash]->empenhado += $oDespesa->empenhado;
                    $this->aDespesasAgrupadas[$sHash]->pagamento += $oDespesa->pagamento;
                    $this->aDespesasAgrupadas[$sHash]->liquidado += $oDespesa->liquidado;
                    $this->aDespesasAgrupadas[$sHash]->rp_processado += ($oDespesa->liquidado - $oDespesa->pagamento);
                    $this->aDespesasAgrupadas[$sHash]->rp_nprocessado += ($oDespesa->empenhado - $oDespesa->liquidado);
                }

                if ($oDespesa->tipo == 2 && $oDespesa->esferaconcedente != 1) {
                    $this->aDespesasAgrupadas[$sHashSintetico]->dot_atualizada -= $oDespesa->empenhado;
                }

            } else {

                //Agrupamento padrão para demais fontes
                if (!isset($this->aDespesasAgrupadas[$sHash])) {
                    
                    $oDesp = new stdClass();

                    $oDesp->cod_planilha        = $iCodPlanilha;
                    $oDesp->o58_codigo          = $oDespesa->o58_codigo;
                    $oDesp->elemento_siope      = $oDespesa->elemento_siope;
                    $oDesp->descricao_siope     = $oDespesa->descricao_siope;
                    $oDesp->dot_atualizada      = $oDespesa->dot_atualizada;
                    $oDesp->empenhado           = $oDespesa->empenhado;
                    $oDesp->liquidado           = $oDespesa->liquidado;
                    $oDesp->pagamento           = $oDespesa->pagamento;
                    $oDesp->rp_processado       = ($oDespesa->liquidado - $oDespesa->pagamento);
                    $oDesp->rp_nprocessado      = ($oDespesa->empenhado - $oDespesa->liquidado);  
                    // $oDesp->esferaconcedente      = $oDespesa->esferaconcedente;            

                    $this->aDespesasAgrupadas[$sHash] = $oDesp;
                    
                } else {

                    $this->aDespesasAgrupadas[$sHash]->dot_atualizada += $oDespesa->dot_atualizada;                    
                    $this->aDespesasAgrupadas[$sHash]->empenhado += $oDespesa->empenhado;
                    $this->aDespesasAgrupadas[$sHash]->pagamento += $oDespesa->pagamento;
                    $this->aDespesasAgrupadas[$sHash]->liquidado += $oDespesa->liquidado;
                    $this->aDespesasAgrupadas[$sHash]->rp_processado += ($oDespesa->liquidado - $oDespesa->pagamento);
                    $this->aDespesasAgrupadas[$sHash]->rp_nprocessado += ($oDespesa->empenhado - $oDespesa->liquidado);
                }

            }

        }
        
        // echo '<pre>';print_r($this->aDespesasAgrupadas);echo '</pre>';die;
        // $this->imprimeTabela($this->aDespesasAgrupadas);
        // die;

    }

    public function imprimeTabela($array) {
        
        echo '<table border=1 cellpadding=0 cellspacing=0>';
        echo '<thead>';
        echo '<th>codplan</th>';
        echo '<th>fonte</th>';
        echo '<th>chave</th>';
        // echo '<th>ensino</th>';
        // echo '<th>pasta</th>';
        // echo '<th>elemento</th>';
        echo '<th>elemento_siope</th>';
        echo '<th>descricao</th>';
        echo '<th>dot_atualizada</th>';
        echo '<th>empenhado</th>';
        echo '<th>liquidado</th>';
        echo '<th>pago</th>';
        // echo '<th>tipo</th>';
        echo '<th>rp proc</th>';
        echo '<th>rp n proc</th>';
        // echo '<th>convenio</th>';
        echo '<th>esfera</th>';
        echo '</thead>';
        echo '<tbody>';
        foreach ($array as $row) {

            // if (/*substr($row->o58_codigo,1,2) == 22 ||*/ substr($row->o58_codigo,1,2) == 22) {

                echo '<tr>';
                echo "<td>". $row->cod_planilha."</td>";
                echo "<td>". $row->o58_codigo ."</td>";
                echo "<td>".$row->o58_codigo .' ;'. $row->cod_planilha.';'.$this->getElementoFormat($row->elemento_siope)."</td>";
                // echo "<td>". $row->o58_subfuncao ."</td>";
                // echo "<td>". $row->o55_tipoensino ."</td>";
                // echo "<td>". $row->o55_tipopasta ."</td>";
                // echo "<td>". $row->elemento ."</td>";
                echo "<td>". $row->elemento_siope ."</td>";
                echo "<td>". substr($row->descricao_siope,0,15) ."</td>";
                echo "<td>". $row->dot_atualizada ."</td>";
                echo "<td>". $row->empenhado ."</td>";
                echo "<td>". $row->liquidado ."</td>";
                echo "<td>". $row->pagamento ."</td>";
                echo "<td>". $row->rp_processado ."</td>";
                echo "<td>". $row->rp_nprocessado ."</td>";
                // echo "<td>". $row->tipo ."</td>";
                // echo "<td>". $row->e60_numconvenio ."</td>";
                echo "<td>". $row->esferaconcedente ."</td>";
                echo '</tr>';

            // }
        }
        echo '</tbody>';
        echo '</table><br>';

    }

    public function verificaDePara($oDespesa) {

        if ($oDespesa->c222_natdespsiope == '' || $oDespesa->c223_descricao == '') {
            
            $this->status = 2;
            
            if (strlen($this->sMensagemDePara) == 0) {
                $this->sMensagemDePara = "Não foi possível gerar a Despesa. De/Para do(s) seguinte(s) elemento(s) não encontrado(s): ";
            }

            if (strpos($this->sMensagemDePara, $oDespesa->o56_elemento) === false){
                $this->sMensagemDePara .= "{$oDespesa->o56_elemento}, ";
            }

        }

    }

    public function verificaConvenio($oDespesa) {

        if ($oDespesa->e60_numconvenio != '' && $oDespesa->esferaconcedente == '') {
            
            $this->status = 2;
            
            if (strlen($this->sMensagemConvenio) == 0) {
                $this->sMensagemConvenio = "Não foi possível gerar a Despesa. Esfera Concedente do(s) seguinte(s) convênio(s) não encontrada(s): ";
            }

            if (strpos($this->sMensagemConvenio, $oDespesa->e60_numconvenio) === false){
                $this->sMensagemConvenio .= "{$oDespesa->e60_numconvenio}, ";
            }
        }

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
            return $this->getCod122222($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta, $oDespesa->esferaconcedente);
        } elseif(substr($oDespesa->o58_codigo,1,2) == 43) {
            return $this->getCod143243($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
        } elseif(substr($oDespesa->o58_codigo,1,2) == 44) {
            return $this->getCod144244($oDespesa->o58_subfuncao, $oDespesa->o55_tipoensino, $oDespesa->o55_tipopasta);
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
                    case 5: return 1231;
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
                            case 1: return 1525;
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

    public function getCod122222($iSubFuncao, $iTipoEnsino, $iTipoPasta, $iEsferaConcedente) {

        switch ($iEsferaConcedente) {

            //Esfera concedente FEDERAL
            case 1:
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
                                    case 1: return 1113;
                                    case 2: return 1116;
                                    default: return 1495;
                                }
                            case 3:
                                switch ($iTipoPasta) {
                                    case 1: return 1123;
                                    case 2: return 1126;
                                    default: return 1496;
                                }
                            case 5: 
                                switch ($iTipoPasta) {
                                    case 1: return 1133;
                                    case 2: return 1136;
                                    default: return 1497;
                                }
                            case 6:
                                switch ($iTipoPasta) {
                                    case 1: return 1143;
                                    case 2: return 1146;
                                    default: return 1498;
                                }
                            default:
                                switch ($iTipoPasta) {
                                    case 1: return 1103;
                                    case 2: return 1106;
                                    default: return 1494;
                                }
                        }
                    case 361:
                        switch ($iTipoPasta) {
                            case 1: return 1103;
                            case 2: return 1106;
                            default: return 1161;
                        }
                    case 362:
                        switch ($iTipoPasta) {
                            case 1: return 1113;
                            case 2: return 1116;
                            default: return 1163;
                        }
                    case 363:
                        switch ($iTipoPasta) {
                            case 1: return 1123;
                            case 2: return 1126;
                            default: return 1125;
                        }
                    case 366:
                        switch ($iTipoEnsino) {
                            case 2:
                                switch ($iTipoPasta) {
                                    case 1: return 1113;
                                    case 2: return 1116;
                                    default: return 1459;
                                }
                            default:
                                switch ($iTipoPasta) {
                                    case 1: return 1103;
                                    case 2: return 1106;
                                    default: return 1457;
                                }
                        }
                    case 367:
                        switch ($iTipoEnsino) {
                            case 2:
                                switch ($iTipoPasta) {
                                    case 1: return 1113;
                                    case 2: return 1116;
                                    default: return 1460;
                                }
                            case 5:
                                switch ($iTipoPasta) {
                                    case 1: return 1133;
                                    case 2: return 1136;
                                    default: return 1461;
                                }
                            case 6:
                                switch ($iTipoPasta) {
                                    case 1: return 1143;
                                    case 2: return 1146;
                                    default: return 1462;
                                }
                            default:
                                switch ($iTipoPasta) {
                                    case 1: return 1103;
                                    case 2: return 1106;
                                    default: return 1458;
                                }
                        }
                    case 365:
                            switch ($iTipoEnsino) {
                                case 5:
                                    switch ($iTipoPasta) {
                                        case 1: return 1133;
                                        case 2: return 1136;
                                        default: return 1165;
                                    }
                                default:
                                    switch ($iTipoPasta) {
                                        case 1: return 1143;
                                        case 2: return 1146;
                                        default: return 1166;
                                    }
                            }
                    case 306:
                        switch ($iTipoEnsino) {
                            case 2: return 1113;
                            case 3: return 1123;
                            case 5: return 1133;
                            case 6: return 1143;
                            default: return 1103;
                        }
                    case 782:
                    case 784:
                    case 785:
                        switch ($iTipoEnsino) {
                            case 2: return 1116;
                            case 3: return 1126;
                            case 5: return 1136;
                            case 6: return 1146;
                            default: return 1106;
                        }
                    default:
                        switch ($iTipoEnsino) {
                            case 2:
                                switch ($iTipoPasta) {
                                    case 1; return 1113;
                                    case 2: return 1116;
                                    default: return 1163;
                                }
                            case 3: 
                                switch ($iTipoPasta) {
                                    case 1: return 1123;
                                    case 2: return 1126;
                                    default: return 1125;
                                }
                            case 5:
                                switch ($iTipoPasta) {
                                    case 1: return 1133;
                                    case 2: return 1136;
                                    default: return 1165;
                                }
                            case 6:
                                switch ($iTipoPasta) {
                                    case 1: return 1143;
                                    case 2: return 1146;
                                    default: return 1166;
                                }
                            default:
                                switch ($iTipoPasta) {
                                    case 1: return 1103;
                                    case 2: return 1106;
                                    default: return 1161;
                                }
                        }

                }
            //ESTADUAL
            case 2:
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
                                    case 1: return 1188;
                                    case 2: return 1193;
                                    default: return 1500;
                                }
                            case 3: 
                                switch ($iTipoPasta) {
                                    case 1: return 1215;
                                    case 2: return 1218;
                                    default: return 1501;
                                }
                            case 4:
                                switch ($iTipoPasta) {
                                    case 1: return 1203;
                                    case 2: return 1206;
                                    default: return 1502;
                                }
                            case 5:
                                switch ($iTipoPasta) {
                                    case 1: return 1227;
                                    case 2: return 1231;
                                    default: return 1503;
                                }
                            case 6:
                                switch ($iTipoPasta) {
                                    case 1: return 1240;
                                    case 2: return 1244;
                                    default: return 1504;
                                }
                            default:
                                switch ($iTipoPasta) {
                                    case 1: return 1174;
                                    case 2: return 1179;
                                    default: return 1499;
                                }
                        }
                    case 361:
                        switch ($iTipoPasta) {
                            case 1: return 1174;
                            case 2: return 1179;
                            default: return 1176;
                        }
                    case 362:
                        switch ($iTipoPasta) {
                            case 1: return 1188;
                            case 2: return 1193;
                            default: return 1190;
                        }
                    case 363:
                        switch ($iTipoPasta) {
                            case 1: return 1215;
                            case 2: return 1218;
                            default: return 1217;
                        }
                    case 364:
                        switch ($iTipoPasta) {
                            case 1: return 1203;
                            case 2: return 1206;
                            default: return 1205;
                        }
                    case 366:
                        switch ($iTipoEnsino) {
                            case 2:
                                switch ($iTipoPasta) {
                                    case 1: return 1188;
                                    case 2: return 1193;
                                    default: return 1465;
                                }
                            default:
                                switch ($iTipoPasta) {
                                    case 1: return 1174;
                                    case 2: return 1179;
                                    default: return 1463;
                                }
                        }
                    case 367:
                        switch ($iTipoEnsino) {
                            case 2:
                                switch ($iTipoPasta) {
                                    case 1: return 1188;
                                    case 2: return 1193;
                                    default: return 1466;
                                }
                            case 5:
                                switch ($iTipoPasta) {
                                    case 1: return 1227;
                                    case 2: return 1231;
                                    default: return 1467;
                                }
                            case 6:
                                switch ($iTipoPasta) {
                                    case 1: return 1240;
                                    case 2: return 1244;
                                    default: return 1468;
                                }
                            default:
                                switch ($iTipoPasta) {
                                    case 1: return 1174;
                                    case 2: return 1179;
                                    default: return 1464;
                                }
                        }
                    case 365:
                        switch ($iTipoEnsino) {
                            case 5:
                                switch ($iTipoPasta) {
                                    case 1: return 1227;
                                    case 2: return 1231;
                                    default: return 1229;
                                }
                            default:
                                switch ($iTipoPasta) {
                                    case 1: return 1240;
                                    case 2: return 1244;
                                    default: return 1242;
                                }
                        }
                    case 306:
                        switch ($iTipoEnsino) {
                            case 2: return 1188;
                            case 3: return 1215;
                            case 4: return 1203;
                            case 5: return 1227;
                            case 6: return 1240;
                            default: return 1174;
                        }
                    case 782:
                    case 784:
                    case 785:
                        switch ($iTipoEnsino) {
                            case 2: return 1193;
                            case 3: return 1218;
                            case 4: return 1206;
                            case 5: return 1231;
                            case 6: return 1244;
                            default: return 1179;
                        }
                    default:
                        switch ($iTipoEnsino) {
                            case 2:
                                switch ($iTipoPasta) {
                                    case 1: return 1188;
                                    case 2: return 1193;
                                    default: return 1190;
                                }
                            case 3:
                                switch ($iTipoPasta) {
                                    case 1: return 1215;
                                    case 2: return 1218;
                                    default: return 1217;
                                }
                            case 4:
                                switch ($iTipoPasta) {
                                    case 1: return 1203;
                                    case 2: return 1206;
                                    default: return 1205;
                                }
                            case 5:
                                switch ($iTipoPasta) {
                                    case 1: return 1227;
                                    case 2: return 1231;
                                    default: return 1229;
                                }
                            case 6:
                                switch ($iTipoPasta) {
                                    case 1: return 1240;
                                    case 2: return 1244;
                                    default: return 1242;
                                }
                            default:
                                switch ($iTipoPasta) {
                                    case 1: return 1174;
                                    case 2: return 1179;
                                    default: return 1176;
                                }
                        }

                    }
            //MUNICIPAL
            case 3:
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
                                    case 1: return 1541;
                                    case 2: return 1596;
                                    default: return 1540;
                                }
                            case 3:
                                switch ($iTipoPasta) {
                                    case 1: return 1545;
                                    case 2: return 1598;
                                    default: return 1544;
                                }
                            case 4:
                                switch ($iTipoPasta) {
                                    case 1: return 1548;
                                    case 2: return 1600;
                                    default: return 1547;
                                }
                            case 5:
                                switch ($iTipoPasta) {
                                    case 1: return 1551;
                                    case 2: return 1603;
                                    default: return 1550;
                                }
                            case 6:
                                switch ($iTipoPasta) {
                                    case 1: return 1554;
                                    case 2: return 1606;
                                    default: return 1553;
                                }
                            default:
                                switch ($iTipoPasta) {
                                    case 1: return 1537;
                                    case 2: return 1595;
                                    default: return 1536;
                                }
                            }
                        case 361:
                            switch ($iTipoPasta) {
                                case 1: return 1537;
                                case 2: return 1395;
                                default: return 1538;
                            }
                        case 362:
                            switch ($iTipoPasta) {
                                case 1: return 1541;
                                case 2: return 1596;
                                default: return 1542;
                            }
                        case 363:
                            switch ($iTipoPasta) {
                                case 1: return 1545;
                                case 2: return 1598;
                                default: return 1597;
                            }
                        case 364:
                            switch ($iTipoPasta) {
                                case 1: return 1548;
                                case 2: return 1600;
                                default: return 1599;
                            }
                        case 366:
                            switch ($iTipoEnsino) {
                                case 2:
                                    switch ($iTipoPasta) {
                                        case 1: return 1541;
                                        case 2: return 1596;
                                        default: return 1633;
                                    }
                                default:
                                    switch ($iTipoPasta) {
                                        case 1: return 1537;
                                        case 2: return 1595;
                                        default: return 1631;
                                    }
                            }
                        case 367:
                            switch ($iTipoEnsino) {
                                case 2:
                                    switch ($iTipoPasta) {
                                        case 1: return 1541;
                                        case 2: return 1596;
                                        default: return 1634;
                                    }
                                case 5:
                                    switch ($iTipoPasta) {
                                        case 1: return 1551;
                                        case 2: return 1603;
                                        default: return 1602;
                                    }
                                case 6:
                                    switch ($iTipoPasta) {
                                        case 1: return 1554;
                                        case 2: return 1606;
                                        default: return 1605;
                                    }
                                default:
                                    switch ($iTipoPasta) {
                                        case 1: return 1537;
                                        case 2: return 1595;
                                        default: return 1632;
                                    }
                            }
                        case 365:
                            switch ($iTipoEnsino) {
                                case 5:
                                    switch ($iTipoPasta) {
                                        case 1: return 1551;
                                        case 2: return 1603;
                                        default: return 1601;
                                    }
                                default:
                                    switch ($iTipoPasta) {
                                        case 1: return 1554;
                                        case 2: return 1606;
                                        default: return 1604;
                                    }
                            }
                        case 306:
                            switch ($iTipoEnsino) {
                                case 2: return 1541;
                                case 3: return 1545;
                                case 4: return 1548;
                                case 5: return 1551;
                                case 6: return 1554;
                                default: return 1537;
                            }
                        case 782:
                        case 784:
                        case 785:
                            switch ($iTipoEnsino) {
                                case 2: return 1596;
                                case 3: return 1598;
                                case 4: return 1600;
                                case 5: return 1603;
                                case 6: return 1606;
                                default: return 1595;
                            }
                        default:
                            switch ($iTipoEnsino) {
                                case 2:
                                    switch ($iTipoPasta) {
                                        case 1: return 1541;
                                        case 2: return 1596;
                                        default: return 1542;
                                    }
                                case 3:
                                    switch ($iTipoPasta) {
                                        case 1: return 1545;
                                        case 2: return 1598;
                                        default: return 1597;
                                    }
                                case 4:
                                    switch ($iTipoPasta) {
                                        case 1: return 1548;
                                        case 2: return 1600;
                                        default: return 1599;
                                    }
                                case 5:
                                    switch ($iTipoPasta) {
                                        case 1: return 1551;
                                        case 2: return 1603;
                                        default: return 1601;
                                    }
                                case 6:
                                    switch ($iTipoPasta) {
                                        case 1: return 1554;
                                        case 2: return 1606;
                                        default: return 1604;
                                    }
                                default:
                                    switch ($iTipoPasta) {
                                        case 1: return 1537;
                                        case 2: return 1595;
                                        default: return 1538;
                                    }
                            }

                        }
            //EXTERIOR OU INSTITUIÇÃO PRIVADA
            case 4:
            case 5:
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
                            case 1; return 1375;
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
                    case 306:
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
                            case 2: return 1036;
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
                    case 5: return 1086;
                    case 6: return 1096;
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
            case 306:
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