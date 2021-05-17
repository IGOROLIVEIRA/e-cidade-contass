<?php

class SiopeReceita extends Siope {

    //@var array
    public $aReceitas = array();

    public function gerarSiope() {

        $aDados = $this->aReceitas;

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
     * Ordena receitas com base na natureza.
     */
    public function ordenaReceitas() {

        $sort = array();

        foreach ($this->aReceitas as $k => $v) {
            $sort[$k] = $v->natureza;
        }

        array_multisort($sort, SORT_ASC, $this->aReceitas);

    }

    /**
     * Agrupa receitas pela natureza da receita.
     */
    public function agrupaReceitas() {}

    /**
     * Busca as receitas conforme relatório do Balancete da Receita
     * Especificamente: PREVISÃO ATUALIZADA DA RECEITA (previsão inicial + previsão adicional da receita), RECEITA REALIZADA e NATUREZA DA RECEITA.
     *
     */
    public function setReceitas() {

        $sSqlPrinc = db_receitasaldo(11,1,3,true,$this->sFiltros,$this->iAnoUsu,$this->dtIni,$this->dtFim,true,' * ',true,0);
        
        $sSql = "   SELECT  CASE 
                                WHEN c224_natrececidade IS NOT NULL THEN substr(c224_natrececidade,2,12)
                                ELSE substr(o57_fonte,2,12)
                            END AS naturezareceita,
                            CASE 
                                WHEN c224_natrececidade IS NOT NULL THEN c225_descricao
                                ELSE o57_descr
                            END AS descricao,
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

        for ($i = 0; $i < pg_num_rows($result); $i++) {

            $oReceita = db_utils::fieldsMemory($result, $i);
            
            if (substr($oReceita->naturezareceita,0,1) == 7 || substr($oReceita->naturezareceita,0,1) == 8) {              
                
                $sNatureza = substr($oReceita->naturezareceita,0,1) == 7 ? '1' : '2';
                $sNatureza .= substr($oReceita->naturezareceita,1,7);

                if (!isset($this->aReceitas[$sNatureza])) {

                    $oRec = new stdClass();

                    $oRec->natureza         = $sNatureza;
                    $oRec->descricao        = $oReceita->descricao;
                    $oRec->prev_atualizada  = (abs($oReceita->saldo_inicial) + abs($oReceita->saldo_prevadic_acum));
                    $oRec->rec_realizada    = 0;
                    $oRec->ded_fundeb       = 0;
                    $oRec->outras_ded       = 0;
                    $oRec->intra            = abs($oReceita->saldo_arrecadado);

                    $this->aReceitas[$sNatureza] = $oRec;

                } else {
                    $this->aReceitas[$sNatureza]->prev_atualizada   += (abs($oReceita->saldo_inicial) + abs($oReceita->saldo_prevadic_acum));
                    $this->aReceitas[$sNatureza]->intra             += abs($oReceita->saldo_arrecadado);
                }

            } elseif (substr($oReceita->naturezareceita,0,2) == 95) {  

                $sNatureza = substr($oReceita->naturezareceita,2,8);

                if (!isset($this->aReceitas[$sNatureza])) {

                    $oRec = new stdClass();

                    $oRec->natureza         = $sNatureza;
                    $oRec->descricao        = $oReceita->descricao;
                    $oRec->prev_atualizada  = 0;
                    $oRec->rec_realizada    = 0;
                    $oRec->ded_fundeb       = abs($oReceita->saldo_arrecadado);
                    $oRec->outras_ded       = 0;
                    $oRec->intra            = 0;

                    $this->aReceitas[$sNatureza] = $oRec;

                } else {
                    $this->aReceitas[$sNatureza]->ded_fundeb += abs($oReceita->saldo_arrecadado);
                }

            } elseif (in_array(substr($oReceita->naturezareceita,0,2), array(91, 92, 93, 96, 98, 99))) {

                $sNatureza = substr($oReceita->naturezareceita,2,8);

                if (!isset($this->aReceitas[$sNatureza])) {

                    $oRec = new stdClass();

                    $oRec->natureza         = $sNatureza;
                    $oRec->descricao        = $oReceita->descricao;
                    $oRec->prev_atualizada  = 0;
                    $oRec->rec_realizada    = 0;
                    $oRec->ded_fundeb       = 0;
                    $oRec->outras_ded       = abs($oReceita->saldo_arrecadado);
                    $oRec->intra            = 0;

                    $this->aReceitas[$sNatureza] = $oRec;

                } else {
                    $this->aReceitas[$sNatureza]->ded_fundeb += abs($oReceita->saldo_arrecadado);
                }

            } else {

                $sNatureza = substr($oReceita->naturezareceita,0,8);

                if (!isset($this->aReceitas[$sNatureza])) {

                    $oRec = new stdClass();

                    $oRec->natureza         = $sNatureza;
                    $oRec->descricao        = $oReceita->descricao;
                    $oRec->prev_atualizada  = (abs($oReceita->saldo_inicial) + abs($oReceita->saldo_prevadic_acum));
                    $oRec->rec_realizada    = abs($oReceita->saldo_arrecadado);
                    $oRec->ded_fundeb       = 0;
                    $oRec->outras_ded       = 0;
                    $oRec->intra            = 0;

                    $this->aReceitas[$sNatureza] = $oRec;

                } else {
                    $this->aReceitas[$sNatureza]->prev_atualizada   += (abs($oReceita->saldo_inicial) + abs($oReceita->saldo_prevadic_acum));
                    $this->aReceitas[$sNatureza]->rec_realizada     += abs($oReceita->saldo_arrecadado);
                }
            }

        }

    }

    public function getElementoFormat($elemento) {
        return substr($elemento, 0, 1).".".substr($elemento, 1, 1).".".substr($elemento, 2, 1).".".substr($elemento, 3, 1).".".substr($elemento, 4, 2).".".substr($elemento, 6, 1).".".substr($elemento, 7, 1);
    }

}