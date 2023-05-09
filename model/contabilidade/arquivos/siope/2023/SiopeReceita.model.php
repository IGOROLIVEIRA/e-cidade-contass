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
     * agrupaReceitas
     * Este método agrupa as receitas por natureza, somando os valores correspondentes e criando um novo array com as somas para cada natureza.
     */
    public function agrupaReceitas()
    {
        $aRecAgrup = array();

        foreach($this->aReceitas as $index => $row) {
            list($natureza, $descricao, $prev_atualizada, $rec_realizada,$ded_fundeb,$outras_ded,$intra) = array_values($row);

            if($natureza){
                $natureza = substr($natureza,1,8);
                // verifica se já há somas registradas para essa natureza
                if (isset($natureza_somas[$natureza])) {
                    // se sim, soma os valores correspondentes
                    $prev_atualizada    += $natureza_somas[$natureza]['prev_atualizada'];
                    $rec_realizada      += $natureza_somas[$natureza]['rec_realizada'];
                    $ded_fundeb         += $natureza_somas[$natureza]['ded_fundeb'];
                    $outras_ded         += $natureza_somas[$natureza]['outras_ded'];
                    $intra              += $natureza_somas[$natureza]['intra'];
                }

                // registra as somas para essa natureza no array auxiliar
                $natureza_somas[$natureza] = array(
                    'prev_atualizada'   => $prev_atualizada,
                    'rec_realizada'     => $rec_realizada,
                    'ded_fundeb'        => $ded_fundeb,
                    'outras_ded'        => $outras_ded,
                    'intra'             => $intra,
                    'descricao'         => $descricao,
                    'natureza'          => $natureza
                );
            }
        }

        // agora usar o array $natureza_somas para acessar as somas de cada natureza
        foreach ($natureza_somas as $natureza => $somas) {

            $aRecAgrup[$natureza]['natureza']          = $somas['natureza'];
            $aRecAgrup[$natureza]['descricao']         = $somas['descricao'];
            $aRecAgrup[$natureza]['prev_atualizada']   = $somas['prev_atualizada'];
            $aRecAgrup[$natureza]['rec_realizada']     = $somas['rec_realizada'];
            $aRecAgrup[$natureza]['ded_fundeb']        = $somas['ded_fundeb'];
            $aRecAgrup[$natureza]['outras_ded']        = $somas['outras_ded'];
            $aRecAgrup[$natureza]['intra']             = $somas['intra'];
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
    public function setReceitas()
    {
        $aReceita = array();
        
        $result = pg_fetch_all(db_receitasaldo(11, 1, 3, true, $this->sFiltros, $this->iAnoUsu, $this->dtIni, $this->dtFim, false, ' * ', true, 0));

        /**
         * Identificador da dedução da receita. Obedecer a seguinte codificação:
         * 91 == Renúncia;
         * 92 == Restituições;
         * 93 == Descontos concedidos;
         * 95 == FUNDEB;
         * 96 == Compensações;
         * 98 == Retificações;
         * 99 == Outras Deduções.
         */
        $deducaoFundeb = 95;
        $outrasDeducoes = array(91, 92, 93, 96, 98, 99);
        $result = array_reverse($result, false);

        foreach ($result as $value) {

            $oReceita = (object) $value;

            if ($oReceita->o70_codrec > 0) {

                $sHash = substr($oReceita->o57_fonte, 1, 8);

                $oNaturrecsiope = $this->getNaturRecSiope($oReceita->o57_fonte, $oReceita->o57_descr);

                $aReceita[$sHash]['natureza']       = $oNaturrecsiope->c225_natrecsiope;
                $aReceita[$sHash]['descricao']      = $oNaturrecsiope->c225_descricao;


                if (substr($oReceita->o57_fonte, 1, 1) == 7 || substr($oReceita->o57_fonte, 1, 1) == 8) {

                    $aReceita[$sHash]['natureza'] = substr($oNaturrecsiope->c225_natrecsiope, 1, 1) == 7 ? '41' : '42';
                    $aReceita[$sHash]['natureza'] .= substr($oNaturrecsiope->c225_natrecsiope, 2, 9);

                    $aReceita[$sHash]['descricao']          = $oNaturrecsiope->c225_descricao;
                    $aReceita[$sHash]['prev_atualizada']   += (abs($oReceita->saldo_inicial) + abs($oReceita->saldo_prevadic_acum));
                    $aReceita[$sHash]['rec_realizada']      = 0;
                    $aReceita[$sHash]['ded_fundeb']         = 0;
                    $aReceita[$sHash]['outras_ded']         = 0;
                    $aReceita[$sHash]['intra']             += abs($oReceita->saldo_arrecadado);

                } elseif (in_array(substr($oReceita->o57_fonte, 1, 2), $outrasDeducoes)) {

                    $aReceita[$sHash]['natureza'] = substr($oNaturrecsiope->c225_natrecsiope, 0, 11);
                    
                    $aReceita[$sHash]['descricao']          = $oNaturrecsiope->c225_descricao;
                    $aReceita[$sHash]['prev_atualizada']   += (abs($oReceita->saldo_inicial) + abs($oReceita->saldo_prevadic_acum)) * -1;
                    $aReceita[$sHash]['rec_realizada']      = 0;
                    $aReceita[$sHash]['ded_fundeb']         = 0;
                    $aReceita[$sHash]['outras_ded']        += abs($oReceita->saldo_arrecadado);
                    $aReceita[$sHash]['intra']              = 0;
                    
                } else {

                    if (substr($oReceita->o57_fonte, 1, 2) == $deducaoFundeb) {

                        $aReceita[$sHash]['natureza']           = 41..substr($oNaturrecsiope->c225_natrecsiope, 2, 11);
                        $aReceita[$sHash]['descricao']          = $oNaturrecsiope->c225_descricao;

                        $aReceita[$sHash]['prev_atualizada']   -= (abs($oReceita->saldo_inicial) + abs($oReceita->saldo_prevadic_acum));
                        $aReceita[$sHash]['rec_realizada']      = 0;
                        $aReceita[$sHash]['ded_fundeb']        += abs($oReceita->saldo_arrecadado);
                        $aReceita[$sHash]['outras_ded']         = 0;
                        $aReceita[$sHash]['intra']              = 0;

                    } else {

                        $aReceita[$sHash]['natureza']           = substr($oNaturrecsiope->c225_natrecsiope, 0, 11);
                        $aReceita[$sHash]['descricao']          = $oNaturrecsiope->c225_descricao;

                        $aReceita[$sHash]['prev_atualizada']   += (abs($oReceita->saldo_inicial) + abs($oReceita->saldo_prevadic_acum));
                        $aReceita[$sHash]['rec_realizada']     += abs($oReceita->saldo_arrecadado);
                        $aReceita[$sHash]['ded_fundeb']         = 0;
                        $aReceita[$sHash]['outras_ded']         = 0;
                        $aReceita[$sHash]['intra']              = 0;
                    }
                }
            }
            $this->aReceitas = $aReceita;
        }
    }

    /**
     * Realiza De/Para da Natureza da despesa com tabela elerecsiope composta pela Natureza Receita e Descrição
     */
    public function getNaturRecSiope($natureza, $descr)
    {

        if (substr($natureza, 0, 2) == 49) {
            $zero = "00";
            $natureza1 = substr($natureza, 0, 1);
            $natureza = $natureza1 . (substr($natureza, 3, 15)) . $zero . $zero;
        } else {
            $zero = "00";
            $natureza = $natureza . $zero;
        }

        $clnaturrecsiope    = new cl_naturrecsiope();
        $rsNaturrecsiope    = db_query($clnaturrecsiope->sql_query_siope(substr($natureza, 0, 15), "", $this->iAnoUsu, $descr));
        $rsRequisSiope      = db_query($clnaturrecsiope->sql_query("", "", "*", "", "naturrecsiope.c224_natrececidade = '" . substr($natureza, 0, 15) . "' and c224_anousu =  $this->iAnoUsu"));

        if (pg_num_rows($rsRequisSiope) > 0) {
            $oRequisSiope = db_utils::fieldsMemory($rsRequisSiope, 0);
        }

        if (pg_num_rows($rsNaturrecsiope) > 0) {
            $oNaturrecsiope = db_utils::fieldsMemory($rsNaturrecsiope, 0);
            return $oNaturrecsiope;
        } else {
            if (strpos($this->sMensagem, $natureza) === false && pg_num_rows($rsRequisSiope) > 0) {
                $this->status = 2;
                $this->sMensagem .= "{$oRequisSiope->c224_natrecsiope} ";
            }
        }
    }

}