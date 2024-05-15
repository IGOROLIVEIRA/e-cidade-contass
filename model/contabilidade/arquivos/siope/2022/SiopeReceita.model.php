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
            list($natureza, $descricao, $prev_atualizada, $rec_realizada,$ded_fundeb,$outras_ded,$intra) = array_values($row);
        
         if($natureza){
            $iSubTotalPrev      = isset($aRecAgrup[$natureza]['prev_atualizada']) ? $aRecAgrup[$natureza]['prev_atualizada'] : 0;
            $iSubTotalRec       = isset($aRecAgrup[$natureza]['rec_realizada']) ? $aRecAgrup[$natureza]['rec_realizada'] : 0;
            $iSubTotalDed       = isset($aRecAgrup[$natureza]['ded_fundeb']) ? $aRecAgrup[$natureza]['ded_fundeb'] : 0;
            $iSubTotalOutras    = isset($aRecAgrup[$natureza]['outras_ded']) ? $aRecAgrup[$natureza]['outras_ded'] : 0;
            $iSubTotalIntra     = isset($aRecAgrup[$natureza]['intra']) ? $aRecAgrup[$natureza]['intra'] : 0;
         
            $aRecAgrup[$natureza]['natureza']          = $natureza;
            $aRecAgrup[$natureza]['descricao']         = $descricao;
            $aRecAgrup[$natureza]['prev_atualizada']   = ($iSubTotalPrev + $prev_atualizada);
            $aRecAgrup[$natureza]['rec_realizada']     = ($iSubTotalRec + $rec_realizada);
            $aRecAgrup[$natureza]['ded_fundeb']        = ($iSubTotalDed + $ded_fundeb);
            $aRecAgrup[$natureza]['outras_ded']        = ($iSubTotalOutras + $outras_ded);
            $aRecAgrup[$natureza]['intra']             = ($iSubTotalIntra + $intra);

          } 
        }
       

        foreach ($aRecAgrup as $aAgrupado) {
            $this->aReceitasAgrupadas[$aAgrupado['natureza']] = $aAgrupado;
        }

        if ($this->lOrcada) {

            $aRecAgrupAnoSeg = array();

            /**
             * Agrupa receitas do ano seguinte.
             */
            foreach ($this->aReceitasAnoSeg as $index => $row) {

                list($natureza, $descricao, $rec_orcada) = array_values($row);

                $iSubTotalRecOrc = isset($aRecAgrupAnoSeg[$natureza]['rec_orcada']) ? $aRecAgrupAnoSeg[$natureza]['rec_orcada'] : 0;

                $aRecAgrupAnoSeg[$natureza]['natureza']     = $natureza;
                $aRecAgrupAnoSeg[$natureza]['descricao']    = $descricao;
                $aRecAgrupAnoSeg[$natureza]['rec_orcada']   = ($iSubTotalRecOrc + $rec_orcada);

            }

            foreach ($aRecAgrupAnoSeg as $aAgrupado) {
                $this->aReceitasAnoSegAgrupadas[$aAgrupado['natureza']] = $aAgrupado;
            }

            /**
             * Une os dois arrays do ano corrente com o ano seguinte.
             * ***Pode haver registros no ano seguinte que não estão no ano corrente.***
             */
            foreach ($this->aReceitasAgrupadas as $index => $receita) {

                if (isset($this->aReceitasAnoSegAgrupadas[$index])) {
                    $receita['rec_orcada'] = $this->aReceitasAnoSegAgrupadas[$index]['rec_orcada'];
                    $this->aReceitasAnoSegAgrupadas[$index]['flag'] = 1;
                    array_push($this->aReceitasAgrupadasFinal, $receita);
                } else {
                    $this->aReceitasAnoSegAgrupadas[$index]['flag'] = 1;
                    array_push($this->aReceitasAgrupadasFinal, $receita);
                }

            }

            foreach ($this->aReceitasAnoSegAgrupadas as $index => $receita) {

                if (!isset($receita['flag']) || $receita['flag'] != 1) {
                    $receita['dot_atualizada'] = isset($this->aReceitasAgrupadas[$index]['prev_atualizada']) ? $this->aReceitasAgrupadas[$index]['prev_atualizada'] : 0;
                    $receita['empenhado'] = isset($this->aReceitasAgrupadas[$index]['rec_realizada']) ? $this->aReceitasAgrupadas[$index]['rec_realizada'] : 0;
                    array_push($this->aReceitasAgrupadasFinal, $receita);
                }

            }

        } else {
            
            $this->aReceitasAgrupadasFinal = $this->aReceitasAgrupadas;
          
        }
        

    }

    /**
     * Busca as receitas conforme relatório do Balancete da Receita
     * Especificamente: PREVISÃO ATUALIZADA DA RECEITA (previsão inicial + previsão adicional da receita), RECEITA REALIZADA e NATUREZA DA RECEITA.
     *
     * Busca também a RECEITA ORÇADA do ano seguinte.
     */
    public function setReceitas() {

        $result = db_receitasaldo(11,1,3,true,$this->sFiltros,$this->iAnoUsu,$this->dtIni,$this->dtFim,false,' * ',true,0);
      
        for ($i = 0; $i < pg_num_rows($result); $i++) {

            $oReceita = db_utils::fieldsMemory($result, $i);
            
            if ($oReceita->o70_codrec > 0) {
                
                $oNaturrecsiope = $this->getNaturRecSiope($oReceita->o57_fonte);
                $aReceita = array();
                $aReceita['natureza'] = $oNaturrecsiope->c225_natrecsiope;
                $aReceita['descricao']          = $oNaturrecsiope->c225_descricao;   
             
                if (substr($oReceita->o57_fonte,1,1) == 7 || substr($oReceita->o57_fonte,1,1) == 8) { 
                    $aReceita['natureza'] = substr($oNaturrecsiope->c225_natrecsiope,1,1) == 7 ? '41' : '42';
                    $aReceita['natureza'] .= substr($oNaturrecsiope->c225_natrecsiope,2,9); 
                        
                        if (!isset($oNaturrecsiope->c225_natrecsiope)) {

                            $aReceita['natureza']           = $oNaturrecsiope->c225_natrecsiope;       
                            $aReceita['descricao']          = $oNaturrecsiope->c225_descricao;
                            $aReceita['prev_atualizada']    = (abs($oReceita->saldo_inicial) + abs($oReceita->saldo_prevadic_acum));
                            $aReceita['rec_realizada']      = 0;
                            $aReceita['ded_fundeb']         = 0;
                            $aReceita['outras_ded']         = 0;
                            $aReceita['intra']              = abs($oReceita->saldo_arrecadado);
        
                        } else {
                             $aReceita['prev_atualizada']   += (abs($oReceita->saldo_inicial) + abs($oReceita->saldo_prevadic_acum));
                             $aReceita['rec_realizada']      = 0;
                             $aReceita['ded_fundeb']         = 0;
                             $aReceita['outras_ded']         = 0;
                             $aReceita['intra']             += abs($oReceita->saldo_arrecadado);
                        }
           
                }
                elseif (in_array(substr($oReceita->o57_fonte,1,2), array(91, 92, 93, 96, 98, 99))) {
                   $aReceita['natureza'] = substr($oNaturrecsiope->c225_natrecsiope,0,15);
 
                   if (!isset($oNaturrecsiope->c225_natrecsiope)) {
                    
                    $aReceita['natureza']           = $oNaturrecsiope->c225_natrecsiope;
                    $aReceita['descricao']          = $oNaturrecsiope->c225_descricao;
                    $aReceita['prev_atualizada']    = (abs($oReceita->saldo_inicial) + abs($oReceita->saldo_prevadic_acum))*-1;
                    $aReceita['rec_realizada']      = 0;
                    $aReceita['ded_fundeb']         = 0;
                    $aReceita['outras_ded']         = abs($oReceita->saldo_arrecadado);
                    $aReceita['intra']              = 0;
                   
                    } else {
                        $aReceita['prev_atualizada']   += (abs($oReceita->saldo_inicial) + abs($oReceita->saldo_prevadic_acum))*-1;
                        $aReceita['rec_realizada']      = 0;
                        $aReceita['ded_fundeb']         = 0;
                        $aReceita['outras_ded']        += abs($oReceita->saldo_arrecadado);
                        $aReceita['intra']              = 0;
                    }
                        
                }else {
               
                    if (substr($oReceita->o57_fonte,1,2) == 95){
                        $aReceita['natureza'] = 41..substr($oNaturrecsiope->c225_natrecsiope,2,15);
                        
                    }else{
                        $aReceita['natureza'] = substr($oNaturrecsiope->c225_natrecsiope,0,15);
                    }
                    if (!isset($oNaturrecsiope->c225_natrecsiope)) {
                        $aReceita['natureza']           = $oNaturrecsiope->c225_natrecsiope;
                        $aReceita['descricao']          = $oNaturrecsiope->c225_descricao;
                        $aReceita['prev_atualizada']    = (abs($oReceita->saldo_inicial) + abs($oReceita->saldo_prevadic_acum));
                        $aReceita['rec_realizada']      = abs($oReceita->saldo_arrecadado);
                        $aReceita['ded_fundeb']       = 0;
                        $aReceita['outras_ded']       = 0;
                        $aReceita['intra']            = 0;
    
                    } else{
                      
                            if (substr($oReceita->o57_fonte,1,2) == 95){
                                    $aReceita['prev_atualizada']   -= (abs($oReceita->saldo_inicial) + abs($oReceita->saldo_prevadic_acum));
                                    $aReceita['rec_realizada']      = 0;
                                    $aReceita['ded_fundeb']        += abs($oReceita->saldo_arrecadado);
                                    $aReceita['outras_ded']       = 0;
                                    $aReceita['intra']            = 0;
                            }else {
                                
                                    $aReceita['prev_atualizada']   += (abs($oReceita->saldo_inicial) + abs($oReceita->saldo_prevadic_acum));
                                    $aReceita['rec_realizada']     += abs($oReceita->saldo_arrecadado);
                                    $aReceita['ded_fundeb']        = 0;
                                    $aReceita['outras_ded']       = 0;
                                    $aReceita['intra']            = 0;
                            }
                         }
                   }   
                                   
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

                    $oNaturrecsiope = $this->getNaturRecSiope($oReceitaAnoSeg->o57_fonte);

                    $aReceitaAnoSeg = array();

                    $aReceitaAnoSeg['natureza']     = $oNaturrecsiope->c225_natrecsiope;
                    $aReceitaAnoSeg['descricao']    = $oNaturrecsiope->c225_descricao;
                    $aReceitaAnoSeg['rec_orcada']   = abs($oReceitaAnoSeg->saldo_inicial);

                    array_push($this->aReceitasAnoSeg, $aReceitaAnoSeg);

                }

            }

        }

    }

    /**
     * Realiza De/Para da Natureza da despesa com tabela elerecsiope composta pela Natureza Receita e Descrição
     */
    public function getNaturRecSiope($natureza) {
            
        if(substr($natureza,0,2) == 49){
            $zero = "00";
            $natureza1 = substr($natureza,0,1);
            $natureza = $natureza1.(substr($natureza,3,15)).$zero.$zero;
        }else{
            $zero = "00";
            $natureza = $natureza.$zero;
        }
        $clnaturrecsiope    = new cl_naturrecsiope();
        $rsNaturrecsiope    = db_query($clnaturrecsiope->sql_query_siope(substr($natureza, 0, 15),"", $this->iAnoUsu));
        $rsRequisSiope      = db_query($clnaturrecsiope->sql_query("","", "*","","naturrecsiope.c224_natrececidade = '".substr($natureza, 0, 15)."' and c224_anousu =  $this->iAnoUsu")); 

        if (pg_num_rows($rsRequisSiope) > 0) {
            $oRequisSiope = db_utils::fieldsMemory($rsRequisSiope, 0);
        }
        else{
            if (strpos($this->sMensagem, $natureza) === false){
                $this->status = 3;
                $this->sMensagem .= " {$natureza} ";
            }
        }

        if (pg_num_rows($rsNaturrecsiope) > 0) {
            $oNaturrecsiope = db_utils::fieldsMemory($rsNaturrecsiope, 0);
            return $oNaturrecsiope;
        } 
        else {
            if (strpos($this->sMensagem, $natureza) === false && pg_num_rows($rsRequisSiope) > 0){
                $this->status = 2;
                $this->sMensagem .= "{$oRequisSiope->c224_natrecsiope} ";
            }
        }
    }

}