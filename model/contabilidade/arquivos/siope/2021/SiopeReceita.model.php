<?php

class SiopeReceita extends Siope {

    //@var array
    public $aReceitas = array();
    //@var array
    public $aReceitasAnoSeg = array();
    //@var array
    public $aReceitasAgrupadas = array();
    //@var array
    public $aReceitasAnoSegAgrupadas = array();
    //@var boolean
    public $aReceitasAgrupadasFinal = array();

    public function gerarSiope() {

        $aDados = $this->aReceitasAgrupadasFinal;

        if (file_exists("model/contabilidade/arquivos/siope/{$this->iAnoUsu}/SiopeCsv.model.php")) {

            require_once("model/contabilidade/arquivos/siope/{$this->iAnoUsu}/SiopeCsv.model.php");

            $csv = new SiopeCsv();
            $csv->setNomeArquivo($this->getNomeArquivo());
            $csv->gerarArquivoCSV($aDados, 2);

        }

    }

    /**
     * Adiciona filtros de todas as instituições
     */
    public function setFiltros() {

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
     * Ordena receitas com base na substr da natureza 4.11.12 para permaneça agrupadas.
     */
    public function ordenaReceitas() {

        $sort = array();
        foreach ($this->aReceitasAgrupadasFinal as $k => $v) {
            $sort[$k] = substr($v['natureza'], 0, 5);
        }

        array_multisort($sort, SORT_ASC, $this->aReceitasAgrupadasFinal);

    }

    /**
     * Agrupa receitas pela natureza da receita.
     */
    public function agrupaReceitas() {

        $aRecAgrup = array();

        /**
         * Agrupa receitas do ano corrente.
         */
        foreach($this->aReceitas as $index => $row) {

            list($natureza, $descricao, $prev_atualizada, $rec_realizada) = array_values($row);

            $iSubTotalPrev      = isset($aRecAgrup[$natureza]['prev_atualizada']) ? $aRecAgrup[$natureza]['prev_atualizada'] : 0;
            $iSubTotalRec       = isset($aRecAgrup[$natureza]['rec_realizada']) ? $aRecAgrup[$natureza]['rec_realizada'] : 0;

            $aRecAgrup[$natureza]['natureza']          = $natureza;
            $aRecAgrup[$natureza]['descricao']         = $descricao;
            $aRecAgrup[$natureza]['prev_atualizada']   = ($iSubTotalPrev + $prev_atualizada);
            $aRecAgrup[$natureza]['rec_realizada']     = ($iSubTotalRec + $rec_realizada);

        }

        foreach ($aRecAgrup as $aAgrupado) {
            $this->aReceitasAgrupadas[$aAgrupado['natureza']] = $aAgrupado;
        }

        $this->aReceitasAgrupadasFinal = $this->aReceitasAgrupadas;

    }

    /**
     * Busca as receitas conforme relatório do Balancete da Receita
     * Especificamente: PREVISÃO ATUALIZADA DA RECEITA (previsão inicial + previsão adicional da receita), RECEITA REALIZADA e NATUREZA DA RECEITA.
     *
     * Busca também a RECEITA ORÇADA do ano seguinte.
     */
    public function setReceitas() {

        // $result = db_receitasaldo(11,1,3,true,$this->sFiltros,$this->iAnoUsu,$this->dtIni,$this->dtFim,false,' * ',true,0);
        $sSqlPrinc = db_receitasaldo(11,1,3,true,$this->sFiltros,$this->iAnoUsu,$this->dtIni,$this->dtFim,true,' * ',true,0);
        
        $sSql = "   SELECT  
                            -- o57_fonte, 
                            -- c224_natrececidade,
                            CASE 
                                WHEN c224_natrececidade IS NOT NULL THEN substr(c224_natrececidade,2,12)
                                ELSE substr(o57_fonte,2,12)
                            END AS naturezareceita,
                            CASE 
                                WHEN c224_natrececidade IS NOT NULL THEN c225_descricao
                                ELSE o57_descr
                            END AS descricao,
                            -- o57_descr,
                            -- c225_descricao,
                            o70_codrec,
                            saldo_inicial,
                            saldo_prevadic_acum,
                            saldo_arrecadado
                            
                    
                    FROM ($sSqlPrinc) AS principal
                    LEFT JOIN naturrecsiope ON o57_fonte = c224_natrececidade AND c224_anousu = {$this->iAnoUsu}
                    LEFT JOIN elerecsiope ON substr(naturrecsiope.c224_natrecsiope, 1, 11) = elerecsiope.c225_natrecsiope AND naturrecsiope.c224_anousu = elerecsiope.c225_anousu

                    WHERE o70_codrec > 0
                    ";
        $result = db_query($sSql);
        // db_criatabela($result);

        for ($i = 0; $i < pg_num_rows($result); $i++) {

            $oReceita = db_utils::fieldsMemory($result, $i);

            $sHash = $oReceita->naturezareceita;
            
            if (substr($oReceita->naturezareceita,0,1) == 7 || substr($oReceita->naturezareceita,0,1) == 8) {
                echo $sHash.'<br>';
                $sHash = substr($oReceita->naturezareceita,0,1) == 7 ? '1' : '2';
                $sHash .= substr($oReceita->naturezareceita,1,12);
                echo $sHash.'<br>';
                echo '<pre>';print_r($oReceita);echo '</pre>';  
            }

            // $oNaturrecsiope = $this->getNaturRecSiope($oReceita->o57_fonte);

            // $aReceita = array();

            // $aReceita['natureza']           = $oNaturrecsiope->c225_natrecsiope;
            // $aReceita['descricao']          = $oNaturrecsiope->c225_descricao;
            // $aReceita['prev_atualizada']    = (abs($oReceita->saldo_inicial) + abs($oReceita->saldo_prevadic_acum));
            // $aReceita['rec_realizada']      = abs($oReceita->saldo_arrecadado);

            // array_push($this->aReceitas, $aReceita);

        }

    }

}