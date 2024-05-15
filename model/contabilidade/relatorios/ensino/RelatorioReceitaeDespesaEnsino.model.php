<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

/**
 * Class RelatorioReceitaeDespesaEnsino
 */
class RelatorioReceitaeDespesaEnsino
{
    private $aFontes;
    private $dtini;
    private $dtfim;
    private $instits;
    private $tipo;
    private $sFuncao;
    private $aSubFuncoes;
    private $aInstits;
    private $nFonte;
    private $anousu;
    private $iSubFuncao;
    private $oDespesaPrograma;
    private $fSubTotal;
    private $nValorTotalPago;
    private $nValorTotalEmpenhadoENaoLiquidado;
    private $nValorTotalLiquidadoAPagar;
    private $nValorTotalGeral;
    private $aFonteFundeb;

    public function setFontes($aFontes) 
    {
		$this->aFontes = $aFontes;
	}

    public function setDataInicial($dtini) 
    {
		$this->dtini = $dtini;
	}

    public function setDataFinal($dtfim) 
    {
		$this->dtfim = $dtfim;
	}

    public function setInstits($instits) 
    {
		$this->instits = $instits;
	}

    public function setTipo($tipo) 
    {
		$this->tipo = $tipo;
	}

    public function setFuncao($sFuncao) 
    {
		$this->sFuncao = $sFuncao;
	}

    public function setSubFuncoes($aSubFuncoes) 
    {
		$this->aSubFuncoes = $aSubFuncoes;
	}

    public function setFonte($nFonte) 
    {
		$this->nFonte = $nFonte;
	}

    public function setAnousu($anousu) 
    {
		$this->anousu = $anousu;
	}

    public function setSubFuncao($iSubFuncao) 
    {
		$this->iSubFuncao = $iSubFuncao;
	}

    public function setDespesaPrograma($oDespesaPrograma) 
    {
		$this->oDespesaPrograma = $oDespesaPrograma;
	}

    public function setSubTotal($fSubTotal) 
    {
		$this->fSubTotal = $fSubTotal;
	}
 
    public function setValorTotalPago($nValorTotalPago) 
    {
		$this->nValorTotalPago = $nValorTotalPago;
	}
 
    public function setValorTotalEmpenhadoENaoLiquidado($nValorTotalEmpenhadoENaoLiquidado) 
    {
		$this->$nValorTotalEmpenhadoENaoLiquidado = $nValorTotalEmpenhadoENaoLiquidado;
	}
 
    public function setValorTotalLiquidadoAPagar($nValorTotalLiquidadoAPagar) 
    {
		$this->nValorTotalLiquidadoAPagar = $nValorTotalLiquidadoAPagar;
	}
 
    public function setValorTotalGeral($nValorTotalGeral) 
    {
		$this->nValorTotalGeral = $nValorTotalGeral;
	}
 
    public function setFonteFundeb($aFonteFundeb) 
    {
		$this->aFonteFundeb = $aFonteFundeb;
	}
  
    /*Calcula as Despesas Custeados Com Superavit */
    public static function getDespesasCusteadosComSuperavit($aFontes, $dtini, $dtfim, $instits)
    {
        $clempempenho = new cl_empempenho();
        if (count($aFontes) < 1) {
            $aFontes = array("'218','219','25400007','25400000'");
        }

        $sSqlOrder = "";
        $sCampos = " o15_codtri, sum(vlrpag) as vlrpag ";
        $sSqlWhere = db_getsession("DB_anousu") > 2022 ? " o15_codigo in (" . implode(",", $aFontes) . ") group by 1" : " o15_codtri in (" . implode(",", $aFontes) . ") group by 1";
        $dtfim = db_getsession("DB_anousu") . "-04-30";
        $aEmpEmpenho = $clempempenho->getDespesasCusteadosComSuperavit(db_getsession("DB_anousu"), $dtini, $dtfim, $instits, $sCampos, $sSqlWhere, $sSqlOrder);
        $valorEmpPagoSuperavit = 0;
        foreach ($aEmpEmpenho as $oEmp) {
            $valorEmpPagoSuperavit += $oEmp->vlrpag;
        }
        return $valorEmpPagoSuperavit;
    }

    /*Calcula Empenhos a Paga */
    public function getEmpenhosAPagar()
    {
        $clempempenho = new cl_empempenho();
        $sSqlOrder = "";
        $sCampos = "o15_codtri, sum(e60_vlremp) as vlremp, sum(vlranu) as vlranu,  sum(vlrpag) as vlrpago, sum(vlrliq) as vlrliq ";
        $sSqlWhere = db_getsession("DB_anousu") > 2022 ? " o15_codigo in (" . implode(",", $this->aFontes) . ") group by 1" : " o15_codtri in (" . implode(",", $this->aFontes) . ") group by 1";
        $aEmpEmpenho = $clempempenho->getEmpenhosMovimentosPeriodo(db_getsession("DB_anousu"), $this->dtini, $this->dtfim, $this->instits, $sCampos, $sSqlWhere, $sSqlOrder);
        $valorEmpLQDAPagar = 0;
        $valorEmpNaoLQDAPagar = 0;
        foreach ($aEmpEmpenho as $oEmp) {
            $valorEmpLQDAPagar += ($oEmp->vlrliq - $oEmp->vlrpago);
            $valorEmpNaoLQDAPagar += ($oEmp->vlremp - $oEmp->vlranu - $oEmp->vlrliq);
        }
        if ($this->tipo == 'lqd') {
            return $valorEmpLQDAPagar;
        }
        if ($this->tipo == 'ambos') {
            return $valorEmpLQDAPagar + $valorEmpNaoLQDAPagar;
        }
        return $valorEmpNaoLQDAPagar;
    }

    /*Calcula Empenhos a Paga das sub funções*/
    public function getEmpenhosAPagarNovo()
    {
        $clempempenho = new cl_empempenho();
        $sSqlOrder = "";
        $sCampos = "o15_codtri, sum(e60_vlremp) as vlremp, sum(vlranu) as vlranu,  sum(vlrpag) as vlrpago, sum(vlrliq) as vlrliq ";
        $aFuncao = "";
        $virgula = "";
        foreach ($this->aSubFuncoes as $iSubFuncao) {
            $aFuncao .= $virgula . $iSubFuncao;
            $virgula = ",";
        }
        $sSqlWhere = db_getsession("DB_anousu") > 2022 ? " o15_codigo in (" . implode(",", $this->aFontes) . ") group by 1" : " o15_codtri in (" . implode(",", $this->aFontes) . ") and o58_funcao = {$this->sFuncao} and o58_subfuncao in ({$aFuncao})  group by 1";
        $aEmpEmpenho = $clempempenho->getEmpenhosMovimentosPeriodo(db_getsession("DB_anousu"), $this->dtini, $this->dtfim, $this->instits, $sCampos, $sSqlWhere, $sSqlOrder);
        $valorEmpLQDAPagar = 0;
        $valorEmpNaoLQDAPagar = 0;
        foreach ($aEmpEmpenho as $oEmp) {
            $valorEmpLQDAPagar += ($oEmp->vlrliq - $oEmp->vlrpago);
            $valorEmpNaoLQDAPagar += ($oEmp->vlremp - $oEmp->vlranu - $oEmp->vlrliq);
        }
        if ($this->tipo == 'lqd') {
            return $valorEmpLQDAPagar;
        }
        if ($this->tipo == 'ambos') {
            return $valorEmpLQDAPagar + $valorEmpNaoLQDAPagar;
        }
        return $valorEmpNaoLQDAPagar;
    }

     /*Calcula os Restos a Pagar Sem Disponibilidade do Fundeb*/
    public function getRestosSemDisponilibidadeFundeb()
    {
        $iSaldoRestosAPagarSemDisponibilidade = 0;
        foreach ($this->aFontes as $sFonte) {
            db_inicio_transacao();
            $clEmpResto = new cl_empresto();
            $sSqlOrder = "";
            $sCampos = " o15_codtri, o15_codigo, sum(vlrpag) as pagorpp, sum(vlrpagnproc) as pagorpnp  ";
            $sSqlWhere = db_getsession('DB_anousu') > 2022 ? " o15_codigo in ($sFonte) group by o15_codtri, o15_codigo " : " o15_codtri in ($sFonte) group by o15_codtri, o15_codigo ";
            $aEmpRestos = $clEmpResto->getRestosPagarInscritosComDisponibilidadeFin(db_getsession("DB_anousu"), $this->dtini, $this->dtfim, $this->aInstits, $sCampos, $sSqlWhere, $sSqlOrder);
            $nValorRpPago = 0;
            foreach ($aEmpRestos as $oEmpResto) {
                $nValorRpPago += $oEmpResto->pagorpp + $oEmpResto->pagorpnp;
            }
            $nTotalAnterior = self::getSaldoPlanoContaFonteFundeb($sFonte, $this->dtini, $this->dtfim, $this->aInstits);
            $nSaldo = 0;

            if ($nValorRpPago > $nTotalAnterior) {
                $nSaldo = $nValorRpPago - $nTotalAnterior;
            }
            $iSaldoRestosAPagarSemDisponibilidade += $nSaldo;
            db_query("drop table if exists work_pl");
            db_fim_transacao();
        }
        return $iSaldoRestosAPagarSemDisponibilidade;
    }

    /*Calcula o Saldo do Plano Conta Fonte Fundeb */
    public static function getSaldoPlanoContaFonteFundeb($nFonte, $dtini, $dtfim, $aInstits)
    {
        $where = " c61_instit in ({$aInstits})";
        $where .= db_getsession("DB_anousu") > 2022 ? " and c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ($nFonte) ) " : " and c61_codigo in ( select o15_codigo from orctiporec where o15_codtri in ($nFonte) ) ";
        $result = db_planocontassaldo_matriz(db_getsession("DB_anousu"), $dtini, $dtfim, false, $where, '111');
        $nTotalAnterior = 0;
        for ($x = 0; $x < pg_numrows($result); $x++) {
            $oPlanoConta = db_utils::fieldsMemory($result, $x);
            if (($oPlanoConta->movimento == "S")
                && (($oPlanoConta->saldo_anterior + $oPlanoConta->saldo_anterior_debito + $oPlanoConta->saldo_anterior_credito) == 0)) {
                continue;
            }
            if (substr($oPlanoConta->estrutural, 1, 14) == '00000000000000') {
                if ($oPlanoConta->sinal_anterior == "C")
                    $nTotalAnterior -= $oPlanoConta->saldo_anterior;
                else {
                    $nTotalAnterior += $oPlanoConta->saldo_anterior;
                }
            }
        }
        return $nTotalAnterior;
    }

    /*Calcula o Cancelamento de Restos a Pagar Com Disponibilidade */
    public function getCancelamentoRestosComDisponilibidade($aFontes, $dtini, $dtfim, $instits)
    {
        $clempresto = new cl_empresto();
        $sSqlOrder = "";
        $sSqlWhere = "";
        $sCampos = " o15_codtri, o15_codigo, sum(vlranu) as vlranu ";
        $sSqlWhere = db_getsession('DB_anousu') > 2022 ? " o15_codigo in (" . implode(",", $aFontes) . ") group by o15_codtri, o15_codigo " : " o15_codtri in (" . implode(",", $aFontes) . ") group by o15_codtri, o15_codigo ";
        $aEmpRestos = $clempresto->getRestosPagarInscritosComDisponibilidadeFin(db_getsession("DB_anousu"), $dtini, $dtfim, $instits, $sCampos, $sSqlWhere, $sSqlOrder);
        $valorRpAnulado = 0;
        foreach ($aEmpRestos as $oEmpResto) {
            $valorRpAnulado += $oEmpResto->vlranu;
        }
        return $valorRpAnulado;
    }

   /*Calcula o Saldo a Pagar De todas as Fontes */
    public function getSaldoApagarGeral()
    {  
        foreach ($this->aFontes as $sFonte) {
            db_inicio_transacao();
            $clEmpResto = new cl_empresto();
            $sSqlOrder = "";
            $sCampos = " o15_codtri, o15_codigo, sum(vlrpag) as pagorpp, sum(vlrpagnproc) as pagorpnp, sum(vlrpag) as vlrpago, sum(vlrliq) as vlrliq, 	sum((round(round(e91_vlremp, 2) - (round(e91_vlranu, 2) + round(vlranu, 2)), 2)) - ( round(e91_vlrpag, 2) + round(vlrpag, 2) + round(vlrpagnproc,2) )) as saldoapagargeral";
            $sSqlWhere = db_getsession('DB_anousu') > 2022 ? " o15_codigo in ($sFonte) group by o15_codigo,o15_codtri " : " o15_codtri in ($sFonte) group by o15_codigo,o15_codtri ";
            $aEmpRestos = $clEmpResto->getRestosPagarInscritosComDisponibilidadeFin(db_getsession("DB_anousu"), $this->dtini, $this->dtfim, $this->instits, $sCampos, $sSqlWhere, $sSqlOrder);
            $nValorRpPago = 0;

            foreach ($aEmpRestos as $oEmpResto) {
                $nValorRpPago += $oEmpResto->saldoapagargeral;
            }
        }
        return $nValorRpPago;
    }

    /*Calcula a linha 1 - EDUCAÇÃO 12 - IMPOSTOS E TRANSFERÊNCIAS DE IMPOSTOS, das Despesa de Ensino */
    public function getLinha1FuncaoeSubfuncao()
    {
        $sDescrSubfuncao = db_utils::fieldsMemory(db_query("select o53_descr from orcsubfuncao where o53_codtri = '{$this->iSubFuncao}'"), 0)->o53_descr;
        if ($this->anousu > 2022) {
            $aDespesasProgramas = getSaldoDespesa(null, "o58_programa,o58_anousu, coalesce(sum(pago),0) as pago, coalesce(sum(empenhado),0) as empenhado, coalesce(sum(anulado),0) as anulado, coalesce(sum(liquidado),0) as liquidado", null, "o58_funcao in ({$this->sFuncao}) and o58_subfuncao in ({$this->iSubFuncao}) and o15_codigo in (" . implode(",", $this->aFontes) . ") and o58_instit in ({$this->instits}) group by 1,2");
            $aDespesasSubFuncao = getSaldoDespesa(null, "o58_subfuncao, o58_anousu, coalesce(sum(pago),0) as pago, coalesce(sum(empenhado),0) as empenhado, coalesce(sum(anulado),0) as anulado, coalesce(sum(liquidado),0) as liquidado", null, "o58_funcao in ({$this->sFuncao}) and o58_subfuncao in ({$this->iSubFuncao}) and o15_codigo in (" . implode(",", $this->aFontes) . ") and o58_instit in ({$this->instits}) group by 1,2");
        } else {
            $aDespesasProgramas = getSaldoDespesa(null, "o58_programa,o58_anousu, coalesce(sum(pago),0) as pago, coalesce(sum(empenhado),0) as empenhado, coalesce(sum(anulado),0) as anulado, coalesce(sum(liquidado),0) as liquidado", null, "o58_funcao = {$this->sFuncao} and o58_subfuncao in ({$this->iSubFuncao}) and o15_codtri in (" . implode(",", $this->aFontes) . ") and o58_instit in ({$this->instits}) group by 1,2");
            $aDespesasSubFuncao = getSaldoDespesa(null, "o58_subfuncao, o58_anousu, coalesce(sum(pago),0) as pago, coalesce(sum(empenhado),0) as empenhado, coalesce(sum(anulado),0) as anulado, coalesce(sum(liquidado),0) as liquidado", null, "o58_funcao = {$this->sFuncao} and o58_subfuncao in ({$this->iSubFuncao}) and o15_codtri in (" . implode(",", $this->aFontes) . ") and o58_instit in ({$this->instits}) group by 1,2");
        }
        $nValorPagoSubFuncao = $aDespesasSubFuncao[0]->pago;
        $nValorEmpenhadoENaoLiquidadoSubFuncao = $aDespesasSubFuncao[0]->empenhado - $aDespesasSubFuncao[0]->anulado - $aDespesasSubFuncao[0]->liquidado;
        $nValorLiquidadoAPagarSubFuncao = $aDespesasSubFuncao[0]->liquidado - $aDespesasSubFuncao[0]->pago;
        $nValorTotalSubFuncao = $nValorPagoSubFuncao + $nValorEmpenhadoENaoLiquidadoSubFuncao + $nValorLiquidadoAPagarSubFuncao;
        
        return array($sDescrSubfuncao, $aDespesasProgramas, $nValorPagoSubFuncao, $nValorEmpenhadoENaoLiquidadoSubFuncao, $nValorLiquidadoAPagarSubFuncao, $nValorTotalSubFuncao);
    }

    /*Calcula a linha 2 - EDUCAÇÃO 12 - AUXÍLIO FINANCEIRO - OUTORGA CRÉDITO TRIBUTÁRIO ICMS - ART. 5º, INCISO V, EC Nº 123/2022, das Despesa de Ensino */
    public function getLinha2FuncaoeSubfuncao()
    {
        $oPrograma = new Programa($this->oDespesaPrograma->o58_programa, $this->oDespesaPrograma->o58_anousu);
        $fSubTotal = $this->oDespesaPrograma->pago;
        $nValorPago = $this->oDespesaPrograma->pago;
        $nValorEmpenhadoENaoLiquidado = $this->oDespesaPrograma->empenhado - $this->oDespesaPrograma->anulado - $this->oDespesaPrograma->liquidado;
        $nValorLiquidadoAPagar = $this->oDespesaPrograma->liquidado - $this->oDespesaPrograma->pago;
        $nValorTotal = $nValorPago + $nValorEmpenhadoENaoLiquidado + $nValorLiquidadoAPagar;
        $nValorTotalPago = $nValorPago;
        $this->nValorTotalEmpenhadoENaoLiquidado = $nValorEmpenhadoENaoLiquidado;
        $this->nValorTotalLiquidadoAPagar = $nValorLiquidadoAPagar;
        $nValorTotalGeral = $nValorTotal;
        return array($oPrograma, $fSubTotal, $nValorPago, $nValorEmpenhadoENaoLiquidado, $nValorLiquidadoAPagar, $nValorTotal, $nValorTotalPago, $this->nValorTotalEmpenhadoENaoLiquidado, $this->nValorTotalLiquidadoAPagar, $nValorTotalGeral);
    }

    /*Calcula a linha 3 - EDUCAÇÃO 12 - FUNDEB, das Despesa de Ensino */
    public function getLinha1FuncaoFundeb()
    {
        $sDescrSubfuncao = db_utils::fieldsMemory(db_query("select o53_descr from orcsubfuncao where o53_codtri = '{$this->iSubFuncao}'"), 0)->o53_descr;
        if (db_getsession("DB_anousu") > 2022) {
            $aDespesasProgramas = getSaldoDespesa(null, "o58_programa,o58_anousu, coalesce(sum(pago),0) as pago, coalesce(sum(empenhado),0) as empenhado, coalesce(sum(anulado),0) as anulado, coalesce(sum(liquidado),0) as liquidado", null, "o58_funcao in ({$this->sFuncao}) and o58_subfuncao in ({$this->iSubFuncao}) and o15_codigo in (" . implode(",", $this->aFonteFundeb) . ") and o58_instit in ({$this->instits}) group by 1,2");
            $aDespesasSubFuncao = getSaldoDespesa(null, "o58_subfuncao, o58_anousu, coalesce(sum(pago),0) as pago, coalesce(sum(empenhado),0) as empenhado, coalesce(sum(anulado),0) as anulado, coalesce(sum(liquidado),0) as liquidado", null, "o58_funcao in ({$this->sFuncao}) and o58_subfuncao in ({$this->iSubFuncao}) and o15_codigo in (" . implode(",", $this->aFonteFundeb) . ") and o58_instit in ({$this->instits}) group by 1,2");
        } else {
            $aDespesasProgramas = getSaldoDespesa(null, "o58_programa,o58_anousu, coalesce(sum(pago),0) as pago, coalesce(sum(empenhado),0) as empenhado, coalesce(sum(anulado),0) as anulado, coalesce(sum(liquidado),0) as liquidado", null, "o58_funcao = {$this->sFuncao} and o58_subfuncao in ({$this->iSubFuncao}) and o15_codtri in (" . implode(",", $this->aFonteFundeb) . ") and o58_instit in ({$this->instits}) group by 1,2");
            $aDespesasSubFuncao = getSaldoDespesa(null, "o58_subfuncao, o58_anousu, coalesce(sum(pago),0) as pago, coalesce(sum(empenhado),0) as empenhado, coalesce(sum(anulado),0) as anulado, coalesce(sum(liquidado),0) as liquidado", null, "o58_funcao = {$this->sFuncao} and o58_subfuncao in ({$this->iSubFuncao}) and o15_codtri in (" . implode(",", $this->aFonteFundeb) . ") and o58_instit in ({$this->instits}) group by 1,2");
        }
        $nValorPagoSubFuncao = $aDespesasSubFuncao[0]->pago;
        $nValorEmpenhadoENaoLiquidadoSubFuncao = $aDespesasSubFuncao[0]->empenhado - $aDespesasSubFuncao[0]->anulado - $aDespesasSubFuncao[0]->liquidado;
        $nValorLiquidadoAPagarSubFuncao = $aDespesasSubFuncao[0]->liquidado - $aDespesasSubFuncao[0]->pago;
        $nValorTotalSubFuncao = $nValorPagoSubFuncao + $nValorEmpenhadoENaoLiquidadoSubFuncao + $nValorLiquidadoAPagarSubFuncao;
        return array($sDescrSubfuncao, $aDespesasProgramas, $nValorPagoSubFuncao, $nValorEmpenhadoENaoLiquidadoSubFuncao, $nValorLiquidadoAPagarSubFuncao, $nValorTotalSubFuncao);
    }

    /*Calcula a linha 3 - EDUCAÇÃO 12 - FUNDEB, das Despesa de Ensino */
    public function getLinha2FuncaoFundeb()
    {
        $oPrograma = new Programa($this->oDespesaPrograma->o58_programa, $this->oDespesaPrograma->o58_anousu);
        $nValorPago = $this->oDespesaPrograma->pago;
        $nValorEmpenhadoENaoLiquidado = $this->oDespesaPrograma->empenhado - $this->oDespesaPrograma->anulado - $this->oDespesaPrograma->liquidado;
        $nValorLiquidadoAPagar = $this->oDespesaPrograma->liquidado - $this->oDespesaPrograma->pago;
        $nValorTotal = $nValorPago + $nValorEmpenhadoENaoLiquidado + $nValorLiquidadoAPagar;
        $nValorTotalPago = $nValorPago;
        $nValorTotalEmpenhadoENaoLiquidado = $nValorEmpenhadoENaoLiquidado;
        $nValorTotalLiquidadoAPagar = $nValorLiquidadoAPagar;
        $nValorTotalGeral = $nValorTotal;
        return array($oPrograma, $nValorPago, $nValorEmpenhadoENaoLiquidado, $nValorLiquidadoAPagar, $nValorTotal, $nValorTotalPago, $nValorTotalEmpenhadoENaoLiquidado, $nValorTotalLiquidadoAPagar, $nValorTotalGeral);
    }

    /*Calcula a linha 7 - DESPESAS CUSTEADAS COM SUPERÁVIT DO FUNDEB ATÉ O PRIMEIRO QUADRIMESTRE - IMPOSTOS E TRANSFERÊNCIAS DE IMPOSTOS, das Despesa de Ensino */
    public function getLinha7DespesasCusteadaSuperavitDoFundeb()
    {
        $oDadosExercicioAnterior = new cl_dadosexercicioanterior;
        $rsDadosExercicioAnterior = $oDadosExercicioAnterior->sql_record($oDadosExercicioAnterior->sql_query_file(null, '*', null, 'c235_anousu = '. db_getsession("DB_anousu")));        
        if ($oDadosExercicioAnterior->numrows > 0) {            
            $iSuperavitFundebPermitido = db_utils::fieldsMemory($rsDadosExercicioAnterior,0)->c235_naoaplicfundebimposttransf;
            $nValorCusteadoSuperavit = self::getDespesasCusteadosComSuperavit(array("'218','219','25400007','25400000'"), $this->dtini, $this->dtfim, $this->instits);
            if ($nValorCusteadoSuperavit > $iSuperavitFundebPermitido){
                $nValorCusteadoSuperavit = $iSuperavitFundebPermitido;
            }
        } else {
            $nValorCusteadoSuperavit = 0;
        }
        return $nValorCusteadoSuperavit;
    }

    /*Calcula a linha 8 - RESTOS A PAGAR INSCRITOS NO EXERCÍCIO, das Despesa de Ensino */
    public function getLinha8RestosaPagarInscritosFonte101()
    {
        $nLiqAPagarPrecessado = 0;
        $nLiqAPagarNaoPrecessado = 0;
        $dtfimExercicio = db_getsession("DB_anousu") . "-12-31";
        if ($this->dtfim == $dtfimExercicio) {
            if (db_getsession("DB_anousu") > 2022) {
                $this->setFontes(array("'15000001','25000001'"));
                $this->setTipo('ambos');
                $nLiqAPagarPrecessado = self::getEmpenhosAPagar();
                $this->setFontes(array("'15020001','15400000'"));
                $nLiqAPagarNaoPrecessado = self::getEmpenhosAPagar();
                $this->setFontes(array("'17180000'"));
                $nLiqAPagar136 = self::getEmpenhosAPagar();
            } else {
                $this->setFontes(array("'101','15000001','201','25000001'"));
                $this->setTipo('ambos');
                $nLiqAPagarPrecessado = self::getEmpenhosAPagar();
                $this->setFontes(array("'118','119','1118','1119','15400007','15400000'"));
                $nLiqAPagarNaoPrecessado = self::getEmpenhosAPagar();
                $this->setFontes(array("'136','17180000'"));
                $nLiqAPagar136 = self::getEmpenhosAPagar();
            }
        }
        return $nLiqAPagarPrecessado + $nLiqAPagarNaoPrecessado + $nLiqAPagar136;
    }

    /*Calcula a linha 9 - RESTOS A PAGAR INSCRITOS NO EXERCÍCIO SEM DISPONIBILIDADE FINANCEIRA, das Despesa de Ensino */
    public function getLinha9RestosaPagarInscritoSemDis()
    {
        $dtfimExercicio = db_getsession("DB_anousu") . "-12-31";
        if ($this->dtfim == $dtfimExercicio) {
            $this->setFontes(array("'101', '1101','15000001','201', '2101','25000001'"));
            $nSaldoApagarGeral101 = self::getSaldoApagarGeral();
            $this->setFontes(array("'136','17180000','236','27180000'"));
            $nSaldoApagarGeral136 = self::getSaldoApagarGeral();
            if (db_getsession("DB_anousu") > 2022) {
                $this->setFontes(array("'15020001', 25020001"));
            } else {
                $this->setFontes(array("'118','119','1118','1119','15400007','15400000'"));
            }
            $nSaldoApagarGeral118_119 = self::getSaldoApagarGeral();
        }
        $nSaldoFonteAno101 = getSaldoPlanoContaFonte("'101','15000001','201','25000001'", $this->dtini, $this->dtfim, $this->instits);

        $nRPIncritosSemDesponibilidade101 = 0;
        $this->setFontes(array("'101','15000001','201','25000001'"));
        $this->setTipo('lqd');
        $nLiqAPagar101 = self::getEmpenhosAPagar();
        $this->setTipo('');
        $nNaoLiqAPagar101 = self::getEmpenhosAPagar();
        $aTotalPago101 = $nLiqAPagar101 + $nNaoLiqAPagar101;

        if ($this->dtfim == $dtfimExercicio) {
            $nSaldoFonteAno101 = getSaldoPlanoContaFonte("'101','15000001','201','25000001'", $this->dtini, $this->dtfim, $this->instits);
            $dtfimExercicio = db_getsession("DB_anousu") . "-12-31";
            $nRPSemDesponibilidade101 = $nSaldoFonteAno101 - $nSaldoApagarGeral101;

            if ($nRPSemDesponibilidade101 <= 0) {
                $nRPIncritosSemDesponibilidade101 = $aTotalPago101;
            }
            if ($nRPSemDesponibilidade101 > 0) {
                $nRPIncritosSemDesponibilidade101 = $nRPSemDesponibilidade101 - $aTotalPago101;
                if ($nRPIncritosSemDesponibilidade101 >= 0) {
                    $nRPIncritosSemDesponibilidade101 = 0;
                }
                $nRPIncritosSemDesponibilidade101 = abs($nRPIncritosSemDesponibilidade101);
            }
        }
        $nRPIncritosSemDesponibilidade136 = 0;
        $this->setFontes(array("'136','17180000','236','27180000'"));
        $this->setTipo('lqd');
        $nLiqAPagar136 = self::getEmpenhosAPagar();
        $this->setTipo('');
        $nNaoLiqAPagar136 = self::getEmpenhosAPagar();
        $aTotalPago136 = $nLiqAPagar136 + $nNaoLiqAPagar136;

        if ($this->dtfim == $dtfimExercicio) {
            $nSaldoFonteAno136 = getSaldoPlanoContaFonte("'136','17180000', '236','27180000'", $this->dtini, $this->dtfim, $this->instits);
            $dtfimExercicio = db_getsession("DB_anousu") . "-12-31";
            $nRPSemDesponibilidade136 = $nSaldoFonteAno136 - $nSaldoApagarGeral136;

            if ($nRPSemDesponibilidade136 <= 0) {
                $nRPIncritosSemDesponibilidade136 = $aTotalPago136;
            }
            if ($nRPSemDesponibilidade136 > 0) {
                $nRPIncritosSemDesponibilidade136 = $nRPSemDesponibilidade136 - $aTotalPago136;
                if ($nRPIncritosSemDesponibilidade136 >= 0) {
                    $nRPIncritosSemDesponibilidade136 = 0;
                }
                $nRPIncritosSemDesponibilidade136 = abs($nRPIncritosSemDesponibilidade136);
            }
        }
        $nRPIncritosSemDesponibilidade118_119 = 0;
        if (db_getsession("DB_anousu") > 2022) {
            $this->setFontes(array("'15020001', 25020001"));
        } else {
            $this->setFontes(array("'118','119','1118','1119','15400007','15400000'"));
        }
        $this->setTipo('lqd');
        $nLiqAPagar118_119 = self::getEmpenhosAPagar();
        $this->setTipo('');
        $nNaoLiqAPagar118_119 = self::getEmpenhosAPagar();
        $aTotalPago118_119 = $nLiqAPagar118_119 + $nNaoLiqAPagar118_119;

        if ($this->dtfim == $dtfimExercicio) {
            if (db_getsession("DB_anousu") > 2022) {
                $nSaldoFonteAno118_119 = getSaldoPlanoContaFonte("'15020001', 25020001", $this->dtini, $this->dtfim, $this->instits);
            } else {
                $nSaldoFonteAno118_119 = getSaldoPlanoContaFonte("'118','119','1118','1119','15400007','15400000'", $this->dtini, $this->dtfim, $this->instits);
            }
            $dtfimExercicio = db_getsession("DB_anousu") . "-12-31";
            $nRPSemDesponibilidade118_119 = $nSaldoFonteAno118_119 - $nSaldoApagarGeral118_119;

            if ($nRPSemDesponibilidade118_119 <= 0) {
                $nRPIncritosSemDesponibilidade118_119 = $aTotalPago118_119;
            }
            if ($nRPSemDesponibilidade118_119 > 0) {
                $nRPIncritosSemDesponibilidade118_119 = $nRPSemDesponibilidade118_119 - $aTotalPago118_119;
                if ($nRPIncritosSemDesponibilidade118_119 >= 0) {
                    $nRPIncritosSemDesponibilidade118_119 = 0;
                }
                $nRPIncritosSemDesponibilidade118_119 = abs($nRPIncritosSemDesponibilidade118_119);
            }
        }
        return array($nRPIncritosSemDesponibilidade101, $nRPIncritosSemDesponibilidade136, $nRPIncritosSemDesponibilidade118_119, $nRPSemDesponibilidade101, $nRPSemDesponibilidade136, $nRPSemDesponibilidade118_119);
    }

    /*Calcula a linha 10 - RESTOS A PAGAR DE EXERCÍCIOS ANTERIORES SEM DISPONIBILIDADE FINANCEIRA PAGOS NO EXERCÍCIO ATUAL (CONSULTA 932.736), das Despesa de Ensino */
    public function getLinha10RestoaPagarSemDis()
    {
        if (db_getsession('DB_anousu') > 2022) {
            return $nValorRecursoTotal = self::getRestosSemDisponilibidadeFundeb(array("'101','15000001','15020001','1101'", "'201','25000001','25020001'"), $this->dtini, $this->dtfim, $this->instits);
        } else {
            return $nValorRecursoTotal = self::getRestosSemDisponilibidadeFundeb(array("'101','15000001','1101'", "'201','25000001'", "'118','119','1118','1119','15400007','15400000'", "'218','219','25400007','25400000'"), $this->dtini, $this->dtfim, $this->instits);
        }
    }

    /*Calcula a linha 11 - CANCELAMENTO, NO EXERCÍCIO, DE RESTOS A PAGAR INSCRITOS COM DISPONIBILIDADE FINANCEIRA, das Despesa de Ensino */
    public function getLinha11CancelamentodeRestoaPagar()
    {
        $valorDescontos101 = self::getSaldoPlanoContaFonteFundeb("'101','1101','201','15000001','25000001'", $this->dtini, $this->dtfim, $this->instits);
        $valorDescontos136 = self::getSaldoPlanoContaFonteFundeb("'136','236','17180000','27180000'", $this->dtini, $this->dtfim, $this->instits) - $valorDescontos101;
        $valorDescontos118 = self::getSaldoPlanoContaFonteFundeb("'118','119','1118','1119','218','219','15400007','15400000','25400007','25400000'", $this->dtini, $this->dtfim, $this->instits);
        $valorDescontos1502 = self::getSaldoPlanoContaFonteFundeb("'15020001','25020001'", $this->dtini, $this->dtfim, $this->instits);
        $nValorRecursoTotal101 = self::getCancelamentoRestosComDisponilibidade(array("'101','1101','201','15000001','25000001'"), $this->dtini, $this->dtfim, $this->instits);
        $nValorRecursoTotal136 = self::getCancelamentoRestosComDisponilibidade(array("'136','236','17180000','27180000'"), $this->dtini, $this->dtfim, $this->instits);
        $nValorRecursoTotal118 = self::getCancelamentoRestosComDisponilibidade(array("'118','119','1118','1119','218','219','15400007','15400000','25400007','25400000'"), $this->dtini, $this->dtfim, $this->instits);
        $nValorRecursoTotal1502 = self::getCancelamentoRestosComDisponilibidade(array("'15020001','25020001'"), $this->dtini, $this->dtfim, $this->instits);
        $nValorRecursoTotal101 = $nValorRecursoTotal101 > $valorDescontos101 ? $nValorRecursoTotal101 - $valorDescontos101 : $nValorRecursoTotal101;
        $nValorRecursoTotal136 = $nValorRecursoTotal136 > $valorDescontos136 ? $nValorRecursoTotal136 - $valorDescontos136 : $nValorRecursoTotal136;
        $nValorRecursoTotal118 = $nValorRecursoTotal118 > $valorDescontos118 ? $nValorRecursoTotal118 - $valorDescontos118 : $nValorRecursoTotal118;
        $nValorRecursoTotal1502 = $nValorRecursoTotal1502 > $valorDescontos1502 ? $nValorRecursoTotal1502 - $valorDescontos1502 : $nValorRecursoTotal1502;
        return array($nValorRecursoTotal101, $nValorRecursoTotal136, $nValorRecursoTotal118, $nValorRecursoTotal1502);
    }
}