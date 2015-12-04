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
 * Classe para controle dos dados da emissao do BAlanco Financiero do DCASP
 *
 * @package contabilidade
 * @subpackage relatorios
 * @version $Revision: 1.11 $
 * @author Bruno De Boni bruno.boni@dbseller.com.br
 * @author Iuri Guntchnigg iuri@dbseller.com.br
 *
 */
final class BalancoFinanceiroDcasp extends RelatoriosLegaisBase {

  private $rsBalanceteReceita             = null;
  private $rsBalanceteReceitaAnoAnterior  = null;
  private $rsBalanceteDespesa             = null;
  private $rsBalanceteDespesaAnterior     = null;
  private $rsBalanceteVerificacao         = null;
  private $rsBalanceteVerificacaoAnterior = null;
  private $aLinhasRelatorio = array();

  /**
   * Contém os Recursos que não foram configurados
   * @var array
   */
  private $aRecursosNaoConfigurados = array();

  /**
   * Retorna os recursos vinculados que não foram vinculados nas configurações
   * @return Recursos[]
   */
  public function getRecursosNaoConfigurados() {
    return $this->aRecursosNaoConfigurados;
  }

  /**
   * Valida se todos os recursos do relatório estão na configuração
   */
  public function validarRecursos($lValidarExercicioAnterior = false) {

    $this->calculaValoresRelatorio();

    $this->aRecursosNaoConfigurados = array();

    $aRecursos = array();

    /**
     * Pega os recursos das movimentações do exercício atual
     */
    for ($iRowCalculo = 0; $iRowCalculo < pg_num_rows($this->rsBalanceteReceita); $iRowCalculo++)  {
      $aRecursos[] = pg_fetch_result($this->rsBalanceteReceita, $iRowCalculo, 'o70_codigo');
    }

    for ($iRowCalculo = 0; $iRowCalculo < pg_num_rows($this->rsBalanceteDespesa); $iRowCalculo++) {
      $aRecursos[] = pg_fetch_result($this->rsBalanceteDespesa, $iRowCalculo, 'o58_codigo');
    }

    /**
     * Pega os recursos das movimentações do exercício anterior
     */
    if ($lValidarExercicioAnterior) {

      for ($iRowCalculo = 0; $iRowCalculo < pg_num_rows($this->rsBalanceteReceitaAnoAnterior); $iRowCalculo++)  {
        $aRecursos[] = pg_fetch_result($this->rsBalanceteReceitaAnoAnterior, $iRowCalculo, 'o70_codigo');
      }

      for ($iRowCalculo = 0; $iRowCalculo < pg_num_rows($this->rsBalanceteDespesaAnterior); $iRowCalculo++) {
        $aRecursos[] = pg_fetch_result($this->rsBalanceteDespesaAnterior, $iRowCalculo, 'o58_codigo');
      }
    }

    $aRecursos = array_unique($aRecursos);
    sort($aRecursos);

    /**
     * Pega os recursos da configuração
     */
    $aRecursosConfiguradosIn    = array();
    $aRecursosConfiguradosNotIn = array();

    foreach (array(4, 5, 6, 15, 16, 17) as $iLinhaRelatorio) {

      $pArrayToMerge =& $aRecursosConfiguradosIn;

      if (strtolower(trim($this->aLinhasRelatorio[$iLinhaRelatorio]->parametros->orcamento->recurso->operador)) != 'in') {
        $pArrayToMerge =& $aRecursosConfiguradosNotIn;
      }

      $pArrayToMerge = array_merge($pArrayToMerge, $this->aLinhasRelatorio[$iLinhaRelatorio]->parametros->orcamento->recurso->valor);
    }

    $oDaoTipoRec = new cl_orctiporec();

    /**
     * Pega os recursos do tipo vinculado quando for "não contendo" na configuração
     */
    if (!empty($aRecursosConfiguradosNotIn)) {

      $sSqlTiporec = $oDaoTipoRec->sql_query_file( null, "o15_codigo", null, "o15_codigo not in (" . implode(', ', $aRecursosConfiguradosNotIn) . ") and o15_tipo = 2");
      $rsTiporec   = $oDaoTipoRec->sql_record($sSqlTiporec);

      if ($rsTiporec && pg_num_rows($rsTiporec) > 0) {

        for ($iRowTiporec = 0; $iRowTiporec < pg_num_rows($rsTiporec); $iRowTiporec++) {
          $aRecursosConfiguradosIn[] = db_utils::fieldsMemory($rsTiporec, $iRowTiporec)->o15_codigo;
        }
      }
    }

    $aRecursosNaoConfigurados = array_diff($aRecursos, array_unique($aRecursosConfiguradosIn));

    if (!empty($aRecursosNaoConfigurados)) {

      $sSqlTiporec = $oDaoTipoRec->sql_query_file( null, "o15_codigo", null, "o15_codigo in (" . implode(', ', $aRecursosNaoConfigurados) . ") and o15_tipo = 2");
      $rsTiporec   = $oDaoTipoRec->sql_record($sSqlTiporec);

      if ($rsTiporec && pg_num_rows($rsTiporec) > 0) {

        for ($iRowTiporec = 0; $iRowTiporec < pg_num_rows($rsTiporec); $iRowTiporec++) {
          $oDadosTiporec = db_utils::fieldsMemory($rsTiporec, $iRowTiporec);

          $this->aRecursosNaoConfigurados[] = new Recurso($oDadosTiporec->o15_codigo);
        }

        return false;
      }
    }

    return true;
  }

  private function calculaValoresRelatorio() {

    $sWhereReceita = " o70_instit in ({$this->getInstituicoes()}) ";
    $sWhereDespesa = " o58_instit in ({$this->getInstituicoes()}) ";
    $sWherePlano   = " c61_instit in ({$this->getInstituicoes()}) ";

    $oDataInicialAnterior = clone $this->getDataInicial();
    $oDataInicialAnterior->modificarIntervalo('-1 year');

    $oDataFinalAnterior   = clone $this->getDataFinal();
    $oDataFinalAnterior->modificarIntervalo('-1 year');

    $this->oDataInicialAnterior = $oDataInicialAnterior;
    $this->oDataFinalAnterior   = $oDataFinalAnterior;

    $aLinhasUtilizamBalanceteReceita       = array(2, 4, 6, 7);
    $aLinhasUtilizamBalanceteDespesa       = array(13, 14, 15, 16, 17);
    $aLinhasUtilizamBalanceteVerificacao   = array(11, 20);
    $aLinhasUtilizamBalanceteVerificacaoExtraDebito   = array(18, 19);
    $aLinhasUtilizamBalanceteVerificacaoExtraCredito   = array(8, 9);

    /**
     * Carregar a Receita do exericio atual
     */
    $this->rsBalanceteReceita = db_receitasaldo( 11, 1, 3, true,
                                                 $sWhereReceita,
                                                 $this->iAnoUsu,
                                                 $this->getDataInicial()->getDate(),
                                                 $this->getDataFinal()->getDate() );

    db_query("drop table work_receita");

    /**
     * Receita do ano Anterior
     */
    $this->rsBalanceteReceitaAnoAnterior = db_receitasaldo( 11, 1, 3, true,
                                                            $sWhereReceita,
                                                            $this->iAnoUsu -1 ,
                                                            $oDataInicialAnterior->getDate(),
                                                            $oDataFinalAnterior->getDate() );

    db_query("drop table work_receita");

    $this->rsBalanceteDespesa = db_dotacaosaldo( 8,2,2, true, $sWhereDespesa,
                                                 $this->iAnoUsu,
                                                 $this->getDataInicial()->getDate(),
                                                 $this->getDataFinal()->getDate() );

    $this->rsBalanceteDespesaAnterior = db_dotacaosaldo( 8,2,2, true, $sWhereDespesa,
                                                         $this->iAnoUsu -1,
                                                         $oDataInicialAnterior->getDate(),
                                                         $oDataFinalAnterior->getDate() );

    $this->rsBalanceteVerificacao =  db_planocontassaldo_matriz( $this->iAnoUsu,
                                                                 $this->getDataInicial()->getDate(),
                                                                 $this->getDataFinal()->getDate(),
                                                                 false,
                                                                 $sWherePlano,
                                                                 '',
                                                                 'true',
                                                                 'false' );

    db_query("drop table work_pl");

    $this->rsBalanceteVerificacaoAnterior =  db_planocontassaldo_matriz( $this->iAnoUsu - 1,
                                                                         $oDataInicialAnterior->getDate(),
                                                                         $oDataFinalAnterior->getDate(),
                                                                         false,
                                                                         $sWherePlano,
                                                                         '',
                                                                         'true',
                                                                         'false' );

    $this->aLinhasRelatorio = $this->getLinhasRelatorio();
  }

  /**
   * Retorna os Dados para emissão do Relatório
   */
  public function getDados() {

    $this->calculaValoresRelatorio();

    $aLinhasUtilizamBalanceteReceita       = array(2, 4, 5, 6, 7);
    $aLinhasUtilizamBalanceteDespesa       = array(13, 14, 15, 16, 17);
    $aLinhasUtilizamBalanceteVerificacao   = array(11, 20);
    $aLinhasUtilizamLancamentoPorDocumento = array(8, 9, 18, 19);

    foreach ($this->aLinhasRelatorio as $iLinha => $oLinha) {

      if ($oLinha->totalizar) {
        continue;
      }

      $aValoresColunasLinhas = $oLinha->oLinhaRelatorio->getValoresColunas(null, null, $this->getInstituicoes(),
                                                                           $this->iAnoUsu);
      foreach($aValoresColunasLinhas as $oValores) {
        foreach ($oValores->colunas as $oColuna) {
          $oLinha->{$oColuna->o115_nomecoluna} += $oColuna->o117_valor;
        }
      }

      /**
       * Analisamos cada conta configurada para a linha, conforme o balancete de Receita
       */
      if (in_array($iLinha, $aLinhasUtilizamBalanceteReceita)) {

        $oColuna          = new stdClass();
        $oColuna->nome    = 'vlrexatual';
        $oColuna->formula = '#saldo_arrecadado_acumulado';
        RelatoriosLegaisBase::calcularValorDaLinha($this->rsBalanceteReceita,
                                                   $oLinha,
                                                   array($oColuna),
                                                    RelatoriosLegaisBase::TIPO_CALCULO_RECEITA);

        $oColuna          = new stdClass();
        $oColuna->nome    = 'vlrexanter';
        $oColuna->formula = '#saldo_arrecadado_acumulado';
        RelatoriosLegaisBase::calcularValorDaLinha($this->rsBalanceteReceitaAnoAnterior,
                                                   $oLinha,
                                                   array($oColuna),
                                                   RelatoriosLegaisBase::TIPO_CALCULO_RECEITA);

      }

      /**
       * Contas configuradas para Utilizar despesa
       */
      if (in_array($iLinha, $aLinhasUtilizamBalanceteDespesa)) {
        /*
         * Ordinária 
         */
      	if($iLinha == 13){

	        for ($iLinha = 0; $iLinha < pg_num_rows($rsBalanceteDespesa); $iLinha++) {
	        	$oDadosResource = db_utils::fieldsMemory($rsBalanceteDespesa, $iLinha);
	            $sqlCodTriRec = "select o15_codtri as codtri from orctiporec where o15_codigo = ".$oDadosResource->o58_codigo;
	            $rsCodTriRec = db_query($sqlCodTriRec);
	            $codRecTri = db_utils::fieldsMemory($rsCodTriRec, 0)->codtri; 
	            if(substr($oDadosResource->o58_elemento,0,1) == '3' && substr($codRecTri,1,2) == '00'){
	            	$oLinha->{'vlrexatual'} += $oDadosResource->empenhado_acumulado - $oDadosResource->anulado_acumulado;
	            }
		    }

	        for ($iLinha = 0; $iLinha < pg_num_rows($rsBalanceteDespesaAnterior); $iLinha++) {
	            $oDadosResource = db_utils::fieldsMemory($rsBalanceteDespesaAnterior, $iLinha);
	            $sqlCodTriRec = "select o15_codtri as codtri from orctiporec where o15_codigo = ".$oDadosResource->o58_codigo;
	            $rsCodTriRec = db_query($sqlCodTriRec);
	            $codRecTri = db_utils::fieldsMemory($rsCodTriRec, 0)->codtri; 
	            if(substr($oDadosResource->o58_elemento,0,1) == '3' && substr($codRecTri,1,2) == '00'){
	            	$oLinha->{'vlrexanter'} += $oDadosResource->empenhado_acumulado - $oDadosResource->anulado_acumulado;
	            }
	        }
        } else if($iLinha == 15){
            /*
	         * Previdência Social 
	         */
	        for ($iLinha = 0; $iLinha < pg_num_rows($rsBalanceteDespesa); $iLinha++) {
	        	$oDadosResource = db_utils::fieldsMemory($rsBalanceteDespesa, $iLinha);
	            $sqlCodTriRec = "select o15_codtri as codtri from orctiporec where o15_codigo = ".$oDadosResource->o58_codigo;
	            $rsCodTriRec = db_query($sqlCodTriRec);
	            $codRecTri = db_utils::fieldsMemory($rsCodTriRec, 0)->codtri; 
	            if(substr($oDadosResource->o58_elemento,0,1) == '3' && substr($codRecTri,1,2) == '03'){
	            	$oLinha->{'vlrexatual'} += $oDadosResource->empenhado_acumulado - $oDadosResource->anulado_acumulado;
	            }
		        
		    }
	        
	        for ($iLinha = 0; $iLinha < pg_num_rows($rsBalanceteDespesaAnterior); $iLinha++) {
	            $oDadosResource = db_utils::fieldsMemory($rsBalanceteDespesaAnterior, $iLinha);
	            $sqlCodTriRec = "select o15_codtri as codtri from orctiporec where o15_codigo = ".$oDadosResource->o58_codigo;
	            $rsCodTriRec = db_query($sqlCodTriRec);
	            $codRecTri = db_utils::fieldsMemory($rsCodTriRec, 0)->codtri; 
	            if(substr($oDadosResource->o58_elemento,0,1) == '3' && substr($codRecTri,1,2) == '03'){
	            	$oLinha->{'vlrexanter'} += $oDadosResource->empenhado_acumulado - $oDadosResource->anulado_acumulado;
	            }
	        }
        }else  if($iLinha == 17){

	        for ($iLinha = 0; $iLinha < pg_num_rows($rsBalanceteDespesa); $iLinha++) {
	        	$oDadosResource = db_utils::fieldsMemory($rsBalanceteDespesa, $iLinha);
	        	
	            $sqlCodTriRec = "select o15_codtri as codtri from orctiporec where o15_codigo = ".$oDadosResource->o58_codigo;
	            $rsCodTriRec = db_query($sqlCodTriRec);
	            $codRecTri = db_utils::fieldsMemory($rsCodTriRec, 0)->codtri; 
	            if(substr($oDadosResource->o58_elemento,0,1) == '3' &&  in_array(substr($codRecTri,1,2), array('22','23','24','42')) ){
	            	$oLinha->{'vlrexatual'} += $oDadosResource->empenhado_acumulado - $oDadosResource->anulado_acumulado;
	            }
		        
		    }

		    for ($iLinha = 0; $iLinha < pg_num_rows($rsBalanceteDespesaAnterior); $iLinha++) {
	            $oDadosResource = db_utils::fieldsMemory($rsBalanceteDespesaAnterior, $iLinha);
	            	        	
	            $sqlCodTriRec = "select o15_codtri as codtri from orctiporec where o15_codigo = ".$oDadosResource->o58_codigo;
	            $rsCodTriRec = db_query($sqlCodTriRec);
	            $codRecTri = db_utils::fieldsMemory($rsCodTriRec, 0)->codtri; 
	            if(substr($oDadosResource->o58_elemento,0,1) == '3' && in_array(substr($codRecTri,1,2), array('22','23','24','42'))){
	            	$oLinha->{'vlrexanter'} += $oDadosResource->empenhado_acumulado - $oDadosResource->anulado_acumulado;
	            }
	        }
          }else if($iLinha == 16){

	        for ($iLinha = 0; $iLinha < pg_num_rows($rsBalanceteDespesa); $iLinha++) {
	        	$oDadosResource = db_utils::fieldsMemory($rsBalanceteDespesa, $iLinha);
	        	
	            $sqlCodTriRec = "select o15_codtri as codtri from orctiporec where o15_codigo = ".$oDadosResource->o58_codigo;
	            $rsCodTriRec = db_query($sqlCodTriRec);
	            $codRecTri = db_utils::fieldsMemory($rsCodTriRec, 0)->codtri; 
	            if( substr($oDadosResource->o58_elemento,0,1) == '3' && $codRecTri != 0 && !in_array(substr($codRecTri,1,2), array('00','22','23','24','42')) ){
	            	$oLinha->{'vlrexatual'} += $oDadosResource->empenhado_acumulado - $oDadosResource->anulado_acumulado;
	            }
		        
		    }

		    for ($iLinha = 0; $iLinha < pg_num_rows($rsBalanceteDespesaAnterior); $iLinha++) {
	            $oDadosResource = db_utils::fieldsMemory($rsBalanceteDespesaAnterior, $iLinha);
	            	        	
	            $sqlCodTriRec = "select o15_codtri as codtri from orctiporec where o15_codigo = ".$oDadosResource->o58_codigo;
	            $rsCodTriRec = db_query($sqlCodTriRec);
	            $codRecTri = db_utils::fieldsMemory($rsCodTriRec, 0)->codtri; 
	            if(substr($oDadosResource->o58_elemento,0,1) == '3' && $codRecTri != 0 && !in_array(substr($codRecTri,1,2), array('00','22','23','24','42'))){
	            	$oLinha->{'vlrexanter'} += $oDadosResource->empenhado_acumulado - $oDadosResource->anulado_acumulado;
	            }
	        }
         }
        
      }

      if (in_array($iLinha, $aLinhasUtilizamBalanceteVerificacao)) {

        $oColuna          = new stdClass();
        $oColuna->nome    = 'vlrexanter';
        $oColuna->formula = '#saldo_final';
        RelatoriosLegaisBase::calcularValorDaLinha($rsBalanceteVerificacaoAnterior,
                                                   $oLinha,
                                                   array($oColuna),
                                                   RelatoriosLegaisBase::TIPO_CALCULO_VERIFICACAO);

        $oColuna          = new stdClass();
        $oColuna->nome    = 'vlrexatual';
        $oColuna->formula = '#saldo_final';
        RelatoriosLegaisBase::calcularValorDaLinha($rsBalanceteVerificacao,
                                                   $oLinha,
                                                   array($oColuna),
                                                   RelatoriosLegaisBase::TIPO_CALCULO_VERIFICACAO);

      }
      
      if ($iLinha == 10) {

        $oColuna          = new stdClass();
        $oColuna->nome    = 'vlrexanter';
        $oColuna->formula = '#saldo_anterior';
        RelatoriosLegaisBase::calcularValorDaLinha($rsBalanceteVerificacaoAnterior,
                                                   $oLinha,
                                                   array($oColuna),
                                                   RelatoriosLegaisBase::TIPO_CALCULO_VERIFICACAO);

        $oColuna          = new stdClass();
        $oColuna->nome    = 'vlrexatual';
        $oColuna->formula = '#saldo_anterior';
        RelatoriosLegaisBase::calcularValorDaLinha($rsBalanceteVerificacao,
                                                   $oLinha,
                                                   array($oColuna),
                                                   RelatoriosLegaisBase::TIPO_CALCULO_VERIFICACAO);
      }
      /**
       * Contas configuradas para Utilizar despesa e receita extra
       */
      
      if (in_array($iLinha, $aLinhasUtilizamBalanceteVerificacaoExtraDebito)) {

        $oColuna          = new stdClass();
        $oColuna->nome    = 'vlrexanter';
        $oColuna->formula = '#saldo_anterior_debito';
        RelatoriosLegaisBase::calcularValorDaLinha($rsBalanceteVerificacaoAnterior,
                                                   $oLinha,
                                                   array($oColuna),
                                                   RelatoriosLegaisBase::TIPO_CALCULO_VERIFICACAO);

        $oColuna          = new stdClass();
        $oColuna->nome    = 'vlrexatual';
        $oColuna->formula = '#saldo_anterior_debito';
        RelatoriosLegaisBase::calcularValorDaLinha($rsBalanceteVerificacao,
                                                   $oLinha,
                                                   array($oColuna),
                                                   RelatoriosLegaisBase::TIPO_CALCULO_VERIFICACAO);

      }
      
      if (in_array($iLinha, $aLinhasUtilizamBalanceteVerificacaoExtraCredito)) {

        $oColuna          = new stdClass();
        $oColuna->nome    = 'vlrexanter';
        $oColuna->formula = '#saldo_anterior_credito';
        RelatoriosLegaisBase::calcularValorDaLinha($rsBalanceteVerificacaoAnterior,
                                                   $oLinha,
                                                   array($oColuna),
                                                   RelatoriosLegaisBase::TIPO_CALCULO_VERIFICACAO);

        $oColuna          = new stdClass();
        $oColuna->nome    = 'vlrexatual';
        $oColuna->formula = '#saldo_anterior_credito';
        RelatoriosLegaisBase::calcularValorDaLinha($rsBalanceteVerificacao,
                                                   $oLinha,
                                                   array($oColuna),
                                                   RelatoriosLegaisBase::TIPO_CALCULO_VERIFICACAO);
      }

      /**
       * Busca valores "a liquidar" + "a pagar liquidado" do Balancete da Despesa
       */
      if ($iLinha == 9) {

        $oColuna          = new stdClass();
        $oColuna->nome    = 'vlrexatual';
        $oColuna->formula = '(#empenhado - #anulado - #liquidado) + #atual_a_pagar_liquidado';
       
        for ($iLinha = 0; $iLinha < pg_num_rows($rsBalanceteDespesa); $iLinha++) {
            $oDadosResource = db_utils::fieldsMemory($rsBalanceteDespesa, $iLinha);
	        $oLinha->{ $oColuna->nome} += ($oDadosResource->empenhado - $oDadosResource->anulado - $oDadosResource->liquidado) + $oDadosResource->atual_a_pagar_liquidado;
	    }

        $oColuna          = new stdClass();
        $oColuna->nome    = 'vlrexanter';
        $oColuna->formula = '(#empenhado - #anulado - #liquidado) + #atual_a_pagar_liquidado';
        for ($iLinha = 0; $iLinha < pg_num_rows($rsBalanceteDespesaAnterior); $iLinha++) {
            $oDadosResource = db_utils::fieldsMemory($rsBalanceteDespesaAnterior, $iLinha);
	        $oLinha->{ $oColuna->nome} += ($oDadosResource->empenhado - $oDadosResource->anulado - $oDadosResource->liquidado) + $oDadosResource->atual_a_pagar_liquidado ;
	    }
      }


      if ($iLinha == 19) {

        /**
         * Saldo atual até o periodo
         */
        $rsRestosPagar    = $this->getResultSetRestosAPagar($this->getDataInicial(), $this->getDataFinal());
        $oColuna          = new stdClass();
        $oColuna->nome    = 'vlrexatual';
        $oColuna->formula = "#vlrpag + #vlrpagnproc";
        		
	    for ($iLinha = 0; $iLinha < pg_num_rows($rsRestosPagar); $iLinha++) {
            $oDadosResource = db_utils::fieldsMemory($rsRestosPagar, $iLinha);
	        $oLinha->{ $oColuna->nome} += $oDadosResource->vlrpag + $oDadosResource->vlrpagnproc;
	    }
        /**
         * Saldo Anterior até o periodo
         */
        $rsRestosPagar    = $this->getResultSetRestosAPagar($this->oDataInicialAnterior, $this->oDataFinalAnterior);
        $oColuna          = new stdClass();
        $oColuna->nome    = 'vlrexanter';
        $oColuna->formula = "(#e91_vlremp - #e91_vlranu - #e91_vlrliq) + (#e91_vlrliq - #e91_vlrpag)";
        
	    for ($iLinha1 = 0; $iLinha1 < pg_num_rows($rsRestosPagar); $iLinha1++) {
             $oDadosResource = db_utils::fieldsMemory($rsRestosPagar, $iLinha1);
	         $oLinha->{ $oColuna->nome} += $oDadosResource->vlrpag + $oDadosResource->vlrpagnproc;
	    	
	    }
	    
	    
        
      }
      
    if ($iLinha == 5) {
		
      	
        /**
         * Saldo atual até o periodo
         */
       
        $oColuna          = new stdClass();
        $oColuna->nome    = 'vlrexatual';
      
        /*db_criatabela($rsBalanceteReceita);
        echo "<pre>";
        print_r($oLinha);exit;*/
	    for ($iLinha = 0; $iLinha < pg_num_rows($rsBalanceteReceita); $iLinha++) {
	    	$codRecTri = 0;
            $oDadosResource = db_utils::fieldsMemory($rsBalanceteReceita, $iLinha);
            
            $sqlCodTriRec = "select o15_codtri as codtri from orctiporec where o15_codigo = ".$oDadosResource->o70_codigo;
            $rsCodTriRec = db_query($sqlCodTriRec);
           
            $codRecTri = db_utils::fieldsMemory($rsCodTriRec, 0)->codtri; 
           
	        if($codRecTri != 0 && $codRecTri != 100 && substr($oDadosResource->o57_fonte,0,4) != '4176' && substr($oDadosResource->o57_fonte,0,4) != '4247'
	           && substr($oDadosResource->o57_fonte,0,4) != '4721' && substr($oDadosResource->o57_fonte,0,4) != '4121' && substr($oDadosResource->o57_fonte,0,3) != '495'){
	        	
	        	$oLinha->{ $oColuna->nome} += $oDadosResource->saldo_arrecadado_acumulado;
	        	
	        }
            
	    }
        /**
         * Saldo Anterior até o periodo
         */

	    $oColuna          = new stdClass();
        $oColuna->nome    = 'vlrexanter';
        
	    for ($iLinha1 = 0; $iLinha1 < pg_num_rows($rsBalanceteReceitaAnoAnterior); $iLinha1++) {
            $oDadosResource = db_utils::fieldsMemory($rsBalanceteReceitaAnoAnterior, $iLinha1);
	        $sqlCodTriRec = "select o15_codtri as codtri from orctiporec where o15_codigo = ".$oDadosResource->o70_codigo;
            $rsCodTriRec = db_query($sqlCodTriRec);
           
            $codRecTri = db_utils::fieldsMemory($rsCodTriRec, 0)->codtri; 
           
	        if($codRecTri != 0 && $codRecTri != 100 && substr($oDadosResource->o57_fonte,0,4) != '4176' && substr($oDadosResource->o57_fonte,0,4) != '4247'
	           && substr($oDadosResource->o57_fonte,0,4) != '4721' && substr($oDadosResource->o57_fonte,0,4) != '4121' && substr($oDadosResource->o57_fonte,0,3) != '495'){
	        	
	        	$oLinha->{ $oColuna->nome} += $oDadosResource->saldo_arrecadado_acumulado;
	        	
	        }
	    	
	    }
	    
	    
        
      }

      /**
       * Linhas que utilizam valores totais documentos
       */
      if (in_array($iLinha, $aLinhasUtilizamLancamentoPorDocumento)) {

        $oValores = new stdClass();
        switch ($iLinha) {

          /**
           * Linha 8
           * Busca valores das transferencias financeiras recebidas
           * + 130 Recebimento de Transferência Financeira
           * - 131 Estorno de Receb de Transferência Financeira
           */
          case 8 :
            $oValores = $this->getValoresDocumentos(array(130));
          break;

          /**
           * Linha 9
           * Busca valores de recebimentos extra orcamentarios
           * + Saldo a pagar geral dos empenhos do exercício
           *   ("a liquidar" + "a pagar liquidado" do Balancete da Despesa)
           * + 150 Recebimento de Caução
           * - 152 Recebimento de Caução - Estorno
           * + 160 Depósitos de Diversas Origens - Recebimento
           * - 162 Depósitos de Diversas Origens - Estorno de Recebimento.
           */
          case 9:
            $oValores = $this->getValoresDocumentos(array(150, 160));
          break;

          /**
           * Linha 18
           * Busca valores de transferencias financeiras concedidas
           * + 120 Pagamento de Transferência Financeira
           * - 121 Estorno de Pagamento de Transferência Financeira
           */
          case 18 :
            $oValores = $this->getValoresDocumentos(array(120));
          break;

          /**
           * + Montante dos Pagamentos de Restos a Pagar processados e não processados (fonte: EMPENHO > RELATÓRIOS > RELATÓRIOS DE MOVIMENTAÇÃO > EXECUÇÃO DE RESTOS A PAGAR)
           * + Coddoc 151 ? Devolução de Caução
           * - Coddoc 153 ? Devolução de Caução ? Estorno
           * + Coddoc 161 ? Depósitos de Diversas Origens - Pagamento
           * - Coddoc 163 ? Depósitos de Diversas Origens ? Estorno de Pagamento.
           */
          case 19:
            $oValores = $this->getValoresDocumentos(array(151, 161));
            break;
        }

        $oLinha->vlrexanter += $oValores->nValorAnterior;
        $oLinha->vlrexatual += $oValores->nValorAtual;
      }

      unset($oLinha->oLinhaRelatorio);
    }

    $this->processaTotalizadores($this->aLinhasRelatorio);
    return $this->aLinhasRelatorio;
  }

  /**
   * @param DBDate $dtInicial
   * @param DBDate $dtFinal
   * @return bool|resource
   */
  private function getResultSetRestosAPagar(DBDate $dtInicial, DBDate $dtFinal) {

    $oDaoRestosAPagar = new cl_empresto();
    $sWhereRestoPagar = " e60_instit in({$this->getInstituicoes()})";
    $sSqlRestosaPagar = $oDaoRestosAPagar->sql_rp_novo(
      $this->iAnoUsu,
      $sWhereRestoPagar,
      $dtInicial->getDate(),
      $dtFinal->getDate()
    );
    return db_query($sSqlRestosaPagar);
  }


  /**
   * Busca valores atual e anterior de uma coleção de documentos
   * - busca documento inverso
   * - caso documento for de estorno, subtrai valores
   *
   * @param Array $aDocumentos
   * @return StdClass
   */
  private function getValoresDocumentos(Array $aDocumentos) {

    /**
     * StdClass retornado
     */
    $oStdValores = new StdClass();
    $oStdValores->nValorAnterior = 0;
    $oStdValores->nValorAtual = 0;

    /**
     * Eventos contabeis do exercicio atual
     */
    $aEventoContabilAtual = array();

    /**
     * Eventos contabeis do exercicio anterior
     */
    $aEventoContabilAnterior = array();

    foreach (explode(', ', $this->getInstituicoes()) as $iInstituicao) {

      /**
       * Percorre os documentos buscando eventos contabeis do exercicio atual e do anterior
       */
      foreach ($aDocumentos as $iDocumento) {

        /**
         * Evento contabil do exercicio atual
         */
        try {

          $oEventoContabilAtual = EventoContabilRepository::getEventoContabilByCodigo($iDocumento, $this->iAnoUsu, $iInstituicao);
          $oEventoContabilAtualInverso = $oEventoContabilAtual->getEventoInverso();
          $aEventoContabilAtual[$iDocumento][] = $oEventoContabilAtual;

          /**
           * Documento inverso do exercicio atual
           */
          if ($oEventoContabilAtualInverso) {
            $aEventoContabilAtual[$oEventoContabilAtualInverso->getCodigoDocumento()][] = $oEventoContabilAtualInverso;
          }

        } catch (Exception $oErro) {}

        try {

          /**
           * Evento contabil do exercicio anterior
           */
          $oEventoContabilAnterior = EventoContabilRepository::getEventoContabilByCodigo($iDocumento, $this->iAnoUsu - 1, $iInstituicao);
          $oEventoContabilAnteriorInverso = $oEventoContabilAnterior->getEventoInverso();
          $aEventoContabilAnterior[$iDocumento][] = $oEventoContabilAnterior;

          /**
           * Documento inverso do exercicio anterior
           */
          if ($oEventoContabilAnteriorInverso) {
            $aEventoContabilAnterior[$oEventoContabilAnteriorInverso->getCodigoDocumento()][] = $oEventoContabilAnteriorInverso;
          }

        } catch (Exception $oErro) {}

      } // foreach

    } // foreach

    /**
     * Calcula valores dos eventos contabeis do exercicio atual
     */
    foreach ($aEventoContabilAtual as $iDocumento => $aEventos) {

      foreach ($aEventos as $oEventoContabil) {

        $nValorAtual = RelatoriosLegaisBase::getValorLancamentoPorDocumentoPeriodo(
          $oEventoContabil, $this->getDataInicial(), $this->getDataFinal()
        );

        /**
         * Documento é de estorno
         */
        if (!$oEventoContabil->isEventoInclusao()) {

          $oStdValores->nValorAtual -= $nValorAtual;
          continue;
        }

        /**
         * Documento de inclusao
         */
        $oStdValores->nValorAtual += $nValorAtual;
      }
    }

    /**
     * Calcula valores dos eventos contabeis do exercicio anterior
     */
    foreach ($aEventoContabilAnterior as $iDocumento => $aEventos) {

      foreach ($aEventos as $oEventoContabil) {

        $nValorAnterior = RelatoriosLegaisBase::getValorLancamentoPorDocumentoPeriodo(
          $oEventoContabil, $this->oDataInicialAnterior, $this->oDataFinalAnterior
        );

        /**
         * Documento é de estorno
         */
        if (!$oEventoContabil->isEventoInclusao()) {

          $oStdValores->nValorAnterior -= $nValorAnterior;
          continue;
        }

        /**
         * Documento de inclusao
         */
        $oStdValores->nValorAnterior += $nValorAnterior;
      }
    }
    return $oStdValores;
  }
}

