<?php
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2013  DBselller Servicos de Informatica             
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

require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_libcontabilidade.php");
require_once("libs/JSON.php");

require_once("std/db_stdClass.php");
require_once("std/DBNumber.php");
require_once("dbforms/db_funcoes.php");

require_once("model/contabilidade/planoconta/ContaPlano.model.php");
require_once("model/contabilidade/planoconta/ContaPlanoPCASP.model.php");
require_once("model/contabilidade/planoconta/SistemaConta.model.php");
require_once("model/contabilidade/planoconta/ClassificacaoConta.model.php");
require_once("model/contabilidade/planoconta/SubSistemaConta.model.php");
require_once("model/contabilidade/lancamento/LancamentoAuxiliarBase.model.php");
require_once("classes/db_regraaberturaexercicio_classe.php");
require_once("classes/db_conplano_classe.php");
require_once("model/contabilidade/EncerramentoExercicio.model.php");

db_app::import("exceptions.*");
db_app::import("contabilidade.lancamento.*");
db_app::import("contabilidade.*");
db_app::import("contabilidade.contacorrente.*");
db_app::import("patrimonio.*");
db_app::import("patrimonio.depreciacao.*");
db_app::import("recursosHumanos.RefactorProvisaoFerias");
db_app::import("orcamento.*");
db_app::import("Dotacao");

$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\","",$_POST["json"]));
$oRetorno          = new db_stdClass();
$oRetorno->status  = 1;
$oRetorno->message = '';
$oRetorno->erro    = false;

$iInstituicao = db_getsession("DB_instit");
$iAnoSessao   = db_getsession("DB_anousu");

try {

  switch ($oParam->exec) {

  	/**
  	 * Case para pegar os valores previsto para o ano, da orcreceita e orcdotacao
  	 */
  	case 'getDadosOrcamento' :

  		$oRetorno->nValorDotacao = Dotacao::getValorPrevistoNoAno($iAnoSessao,$iInstituicao);
  		$oRetorno->nValorReceita = ReceitaContabil::getValorPrevistoAno($iAnoSessao, $iInstituicao);
  		$oRetorno->iAnoSessao    = $iAnoSessao;

  		$oDaoAberturaexercicioorcamento = db_utils::getDao("aberturaexercicioorcamento");
  		$sWhere                         = "     c104_instit     = {$iInstituicao} ";
  		$sWhere                        .= " and c104_ano        = {$iAnoSessao}      ";
  		$sWhere                        .= " and c104_processado = '{$oParam->lProcessados}' ";
  		$sSqlAberturaexercicioorcamento = $oDaoAberturaexercicioorcamento->sql_query_file(null, "1", null, $sWhere);
  		$rsAberturaexercicioorcamento   = $oDaoAberturaexercicioorcamento->sql_record($sSqlAberturaexercicioorcamento);

  		$oRetorno->lBloquearTela        = false;
  		if ($oDaoAberturaexercicioorcamento->numrows > 0) {
  			$oRetorno->lBloquearTela = true;
  		}


  	break;

  	/**
  	 * Case para gerar lancamento contabil para valores previsto para o ano
  	 * Um lancamento para receita e outro pra despesa
  	 *
  	 * @todo criar funcao para usar tanto no processar quanto no desprocessar
  	 */
  	case 'processar' :

  	  db_inicio_transacao();

  	  $oDaoAberturaexercicioorcamento = db_utils::getDao("aberturaexercicioorcamento");
  	  $sWhere                         = "c104_instit = {$iInstituicao} and c104_ano = {$iAnoSessao}";
  	  $sSqlAberturaexercicioorcamento = $oDaoAberturaexercicioorcamento->sql_query_file(null, "*", null, $sWhere);
  	  $rsAberturaexercicioorcamento   = $oDaoAberturaexercicioorcamento->sql_record($sSqlAberturaexercicioorcamento);

  	  $oDaoAberturaexercicioorcamento->c104_usuario    = db_getsession("DB_id_usuario");
      $oDaoAberturaexercicioorcamento->c104_instit     = db_getsession("DB_instit");
      $oDaoAberturaexercicioorcamento->c104_ano        = $iAnoSessao;
      $oDaoAberturaexercicioorcamento->c104_data       = date('Y-m-d', db_getsession("DB_datausu"));
      $oDaoAberturaexercicioorcamento->c104_processado = "true";

      if ( $oDaoAberturaexercicioorcamento->numrows > 0 ) {

        $oAberturaexercicioorcamento = db_utils::fieldsMemory($rsAberturaexercicioorcamento, 0);

        /**
         * Caso já exista um processamento para o período, não poderá haver novo lançamento sem haver um estorno
         */
    	  if ( $oAberturaexercicioorcamento->c104_processado == "t" ) {
    	  	throw new Exception("Não é possível processar novamente lançamentos da abertura de exercícios do ano {$iAnoSessao}");
    	  }

        $oDaoAberturaexercicioorcamento->c104_sequencial	= $oAberturaexercicioorcamento->c104_sequencial;
        $oDaoAberturaexercicioorcamento->alterar($oAberturaexercicioorcamento->c104_sequencial);

      } else {
        $oDaoAberturaexercicioorcamento->incluir(null);
      }

      if ($oDaoAberturaexercicioorcamento->erro_status == "0") {
        throw new BusinessException("Erro técnico: Não foi possível realizar lançamentos !");
      }

      $iSequencialAberturaExercicio = $oDaoAberturaexercicioorcamento->c104_sequencial;
      $sObservacao                  = $oParam->sObservacao;

      /**
	   * Receita - Lancamento contabil para abertura de exercicio
	   */

      /* Documento 2003 - ABERTURA DO ORÇAMENTO RECEITA */

      $iTipoDocumento = 2003;
  	  //$nValorReceita  = ReceitaContabil::getValorPrevistoAno( $iAnoSessao, $iInstituicao );

	  $sSqlOrcreceita  = "SELECT DISTINCT o70_codigo, o70_anousu, o70_valor, o57_fonte FROM orcreceita
	   					  INNER JOIN orcfontes ON o70_codfon = o57_codfon AND o70_anousu = o57_anousu
	   					  INNER JOIN orctiporec ON o70_codigo = o15_codigo
	  					  WHERE o70_instit = {$iInstituicao} AND o70_anousu= {$iAnoSessao}";
	  $rsSqlOrcreceita = db_query($sSqlOrcreceita) or die ($sSqlOrcreceita);

	  for ($iContRec = 0; $iContRec < pg_num_rows($rsSqlOrcreceita); $iContRec++) {

		  $oReceita = db_utils::fieldsMemory($rsSqlOrcreceita, $iContRec);

		  if($oReceita->o70_valor > 0){
			  executaLancamento($iTipoDocumento, $oReceita->o70_valor, $iSequencialAberturaExercicio, $sObservacao, null, null, $oReceita->o70_codigo, $oReceita->o57_fonte);
		  }

	  }

	  /**
       * Receita - Lançamento contábil das Deduções das Receitas para abertura do exercício
	  */

	  /* Documento 2015 - ABERTURA DEDUCOES RECEITA FUNDEB */

	  $iTipoDocumento = 2015;

	  $sSqlRecDeduFundeb  = $sSqlOrcreceita." AND substr(o57_fonte,1,3) = '495'";
	  $sSqlRecDeduFundeb .= " AND substr(o57_fonte,1,3) = '495'";

	  $rsSqlRecDeduFundeb = db_query($sSqlRecDeduFundeb);

	  for ($iContDedu = 0; $iContDedu < pg_num_rows($rsSqlRecDeduFundeb); $iContDedu++){

	      $oDeduFundeb = db_utils::fieldsMemory($rsSqlRecDeduFundeb, $iContDedu);

	      $vlrDeduFundeb = $oDeduFundeb->o70_valor * -1;

          if($vlrDeduFundeb > 0){
              executaLancamento($iTipoDocumento, $vlrDeduFundeb, $iSequencialAberturaExercicio, $sObservacao, null, null, $oDeduFundeb->o70_codigo, $oDeduFundeb->o57_fonte);
          }
      }

      /* Documento 2017 - ABERTURA DEDUCOES RECEITA RENUNCIA */

	  $iTipoDocumento = 2017;

	  $sSqlRecDeduRenuncia  = $sSqlOrcreceita;
	  $sSqlRecDeduRenuncia .= " AND substr(o57_fonte,1,3) = '491'";

	  $rsSqlRecDeduRenuncia = db_query($sSqlRecDeduRenuncia);

	  for ($iContRenuncia = 0; $iContRenuncia < pg_num_rows($rsSqlRecDeduRenuncia); $iContRenuncia++){

	      $oDeduRenuncia = db_utils::fieldsMemory($rsSqlRecDeduRenuncia, $iContRenuncia);

	      $vlrDeduRenuncia = $oDeduRenuncia->o70_valor * -1;

          if($vlrDeduRenuncia > 0){
              executaLancamento($iTipoDocumento, $vlrDeduRenuncia, $iSequencialAberturaExercicio, $sObservacao, null, null, $oDeduRenuncia->o70_codigo, $oDeduRenuncia->o57_fonte);
          }
      }

      /* Documento 2019 - ABERTURA DEMAIS DEDUCOES RECEITA */

	  $iTipoDocumento = 2019;

	  $sSqlDemaisDeduRec  = $sSqlOrcreceita;
	  $sSqlDemaisDeduRec .= " AND substr(o57_fonte,1,2) = '49' AND substr(o57_fonte,1,3) NOT IN ('491', '495')";

	  $rsSqlDemaisDeduRec = db_query($sSqlDemaisDeduRec);

	  for ($iContOutrasDedu = 0; $iContOutrasDedu < pg_num_rows($rsSqlDemaisDeduRec); $iContOutrasDedu++){

	      $oDeduDemaisRec = db_utils::fieldsMemory($rsSqlDemaisDeduRec, $iContOutrasDedu);

	      $vlrDeduDemaisRec = $oDeduDemaisRec->o70_valor * -1;

          if($vlrDeduDemaisRec > 0){
              executaLancamento($iTipoDocumento, $vlrDeduDemaisRec, $iSequencialAberturaExercicio, $sObservacao, null, null, $oDeduDemaisRec->o70_codigo, $oDeduDemaisRec->o57_fonte);
          }
      }


	  /**
	   * Despesa - Lancamento contabil para abertura de exercicio
	   */
	  $iTipoDocumento = 2001;
  	  //$nValorDespesa  = Dotacao::getValorPrevistoNoAno( $iAnoSessao, $iInstituicao );
      $oDaoOrcDotacao = db_utils::getDao("orcdotacao");
      $sWhere         = "o58_anousu = {$iAnoSessao} and o58_instit = {$iInstituicao}";
      $sSqlDotacao    = $oDaoOrcDotacao->sql_query_file(null,
          null,
          "DISTINCT o58_coddot, o58_anousu, o58_valor",
          null,
          $sWhere
      );

      $rsDotacao = $oDaoOrcDotacao->sql_record($sSqlDotacao);

      for ($iContDot = 0; $iContDot < pg_num_rows($rsDotacao); $iContDot++) {
        $oDotacao = db_utils::fieldsMemory($rsDotacao, $iContDot);
    	  if ($oDotacao->o58_valor > 0) {
    	  	executaLancamento($iTipoDocumento, $oDotacao->o58_valor, $iSequencialAberturaExercicio, $sObservacao, $oDotacao->o58_coddot, $oDotacao->o58_anousu);
    	  }
      }

		/**
		 * Abertura pelas regras
		 * documento 2023
		 */
		$aRegras = getRegrasAberturaExercicio($iAnoSessao,$iInstituicao);

		if (count($aRegras) == 0) {
			$oRetorno->message = "Não é possível executar o encerramento pois não existem regras configuradas para Abertura de Exercício";
			$oRetorno->erro = true;
			break;
		}

		$oDaoConPlano = new cl_conplano();
	    $oEncerramentoExercicio = new EncerramentoExercicio(new Instituicao($iInstituicao),$iAnoSessao);

		foreach ($aRegras as $oRegra) {

			/**
			 * A conta usada como referência para os lançamentos é aquela indicada na tela de cadastro das regras.
			 * @contareferencia: $sContaReferencia
			 */

			$sContaReferencia = ($oRegra->c217_contareferencia == "C" ? $oRegra->c217_contacredora : $oRegra->c217_contadevedora);
			$sWhereContaReferencia = "c61_instit = {$iInstituicao} ";
			$sWhereContaReferencia .= "and c60_estrut like '{$sContaReferencia}%' ";
			$sWhereContaReferencia .= "and c61_anousu = {$iAnoSessao}";
			$sSqlContaReferencia = $oDaoConPlano->sql_query_reduz(null, 'c61_reduz, c60_estrut', 'c60_estrut limit 1', $sWhereContaReferencia);
			$rsContaReferencia   = $oDaoConPlano->sql_record($sSqlContaReferencia);

			if ($oDaoConPlano->numrows == 0) {
				throw new BusinessException("Não foram encontradas contas analiticas com a regra {$sContaReferencia}.");
			}

			$iContaReferencia = db_utils::fieldsMemory($rsContaReferencia, 0)->c61_reduz;

			$iTamanhoEstruturalDevedor = strlen($oRegra->c217_contadevedora);
			$iTamanhoEstruturalCredor  = strlen($oRegra->c217_contacredora);

			$sWhereBalancete  = "(substr(c60_estrut, 1, {$iTamanhoEstruturalDevedor}) = '{$oRegra->c217_contadevedora}'  ";
			$sWhereBalancete .= "or substr(c60_estrut, 1, {$iTamanhoEstruturalCredor}) = '{$oRegra->c217_contacredora}' )";
			$sWhereBalancete .= " and c61_reduz <> {$iContaReferencia}";
			$rsBalancete      = $oEncerramentoExercicio->exececutarBalanceteVerificacao($sWhereBalancete);

			$iTotalLinhas     = pg_num_rows($rsBalancete);

			for ($iConta = 0; $iConta < $iTotalLinhas; $iConta++) {

				$oConta = db_utils::fieldsMemory($rsBalancete, $iConta);

				/**
				 * Contas sinteticas, nao devemos encerrar
				 */
				if (empty($oConta->c61_reduz)) {
					continue;
				}
				/**
				 *
				 * 1. Buscar o cc do reduzido.
				 * 2. Apurar o saldo do contacorrente atravez do reduzido na conlancamval
				 * 3. Gravar na contacorrentedetalhe
				 *
				 */

				$iContaCorrente = getContaCorrenteByReduz($iContaReferencia);

				if ($iContaCorrente != "") {

					foreach (getContaCorrenteDetalheByReduz($iContaReferencia,$iContaCorrente) as $oContaCorrente) {

						$oContaCorrenteDetalhe = new ContaCorrenteDetalhe($oContaCorrente->c19_sequencial);
						$aSaldo = getSaldoContaCorrente($oContaCorrente->c19_sequencial, $iContaCorrente);
						$nValorFinal = $aSaldo[0]->saldoimplantado == "" ? 0 : $aSaldo[0]->saldoimplantado;

						/**
						 * Inverção do saldo da conta referência para o lançamento correto na conta credora.
						 */
						$sSinalFinal = ($nValorFinal >= 0 ? 'C' : 'D');

						if($nValorFinal == 0){

							continue;
						}

						$oMovimentacaoContabil = new MovimentacaoContabil();
						$oMovimentacaoContabil->setConta($oConta->c61_reduz);
						$oMovimentacaoContabil->setSaldoFinal(abs($nValorFinal));
						$oMovimentacaoContabil->setTipoSaldo($sSinalFinal);
						$oContaCorrenteDetalhe->setRecurso(new Recurso($oContaCorrente->c19_orctiporec));
						$oLancamento = new LancamentoAuxiliarAberturaExercicio();
						$oLancamento->setValorTotal($oMovimentacaoContabil->getSaldoFinal());
						$oLancamento->setObservacaoHistorico("Inscrição no valor de " . trim(db_formatar($nValorFinal, "f")));
						$oLancamento->setMovimentacaoContabil($oMovimentacaoContabil);
						$oLancamento->setContaReferencia($iContaReferencia);
						$oLancamento->setContaCorrenteDetalhe($oContaCorrenteDetalhe);

						$oEvento           = new EventoContabil(2023, $iAnoSessao);

						$iCodigoLancamento = $oEvento->executaLancamento($oLancamento);

						unset($oMovimentacaoContabil);
						unset($oLancamento);

					}

				} else {

					/**
					 * Busca o saldo inicial da conta referencia
					 */

					$sWhereBalanceteConraRef  = "(substr(c60_estrut, 1, {$iTamanhoEstruturalDevedor}) = '{$oRegra->c217_contadevedora}'  ";
					$sWhereBalanceteConraRef .= "or substr(c60_estrut, 1, {$iTamanhoEstruturalCredor}) = '{$oRegra->c217_contacredora}' )";
					$sWhereBalanceteConraRef .= " and c61_reduz = {$iContaReferencia}";
					$rsBalanceteConraRef      = $oEncerramentoExercicio->exececutarBalanceteVerificacao($sWhereBalanceteConraRef);

					for ($iContaRef = 0; $iContaRef < pg_num_rows($rsBalanceteConraRef); $iContaRef++) {

						$oContaRef = db_utils::fieldsMemory($rsBalanceteConraRef, $iContaRef);

						/**
						 * Contas sinteticas, nao devemos encerrar
						 */
						if (empty($oContaRef->c61_reduz)) {
							continue;
						}
						if ($oContaRef->saldo_anterior == 0) {
							continue;
						}

						/**
						 * Inverção do saldo da conta referência para o lançamento correto na conta credora.
						 */
						$oContaRef->sinal_anterior = ($oContaRef->sinal_anterior == 'C' ? 'D' : 'C');

						$oMovimentacaoContabil = new MovimentacaoContabil();
						$oMovimentacaoContabil->setConta($oConta->c61_reduz);
						$oMovimentacaoContabil->setSaldoFinal($oContaRef->saldo_anterior);
						$oMovimentacaoContabil->setTipoSaldo($oContaRef->sinal_anterior);

						$oLancamento = new LancamentoAuxiliarAberturaExercicio();
						$oLancamento->setValorTotal($oMovimentacaoContabil->getSaldoFinal());
						$oLancamento->setObservacaoHistorico("Inscrição no valor de " . trim(db_formatar($oContaRef->saldo_anterior, "f")));
						$oLancamento->setMovimentacaoContabil($oMovimentacaoContabil);
						$oLancamento->setContaReferencia($iContaReferencia);
						$oEvento = new EventoContabil(2023, $iAnoSessao);
						$iCodigoLancamento = $oEvento->executaLancamento($oLancamento);
						unset($oMovimentacaoContabil);
						unset($oLancamento);
					}
				}
			}
		}

  	  $oRetorno->message = 'Lançamentos processados com sucesso.';

  	  db_fim_transacao(false);

  	break;

  	/**
  	 * Case para estornar um lancamento contabil realizado previamente
  	 * Um lancamento para receita e outro pra despesa
  	 *
  	 * @todo criar funcao para usar tanto no processar quanto no desprocessar
  	 */
  	case 'desprocessar' :

  	  db_inicio_transacao();

  		$oDaoAberturaexercicioorcamento = db_utils::getDao("aberturaexercicioorcamento");
  		$sWhere                         = "c104_instit = {$iInstituicao} and c104_ano = {$iAnoSessao} and c104_processado = 't'";
  		$sSqlAberturaexercicioorcamento = $oDaoAberturaexercicioorcamento->sql_query_file(null, "*", null, $sWhere);
  		$rsAberturaexercicioorcamento   = $oDaoAberturaexercicioorcamento->sql_record($sSqlAberturaexercicioorcamento);

  		if ($oDaoAberturaexercicioorcamento->numrows == "0") {
  			throw new Exception("Não há lançamentos para abertura de exercicio para desprocessamento");
  		}

  		$oDaoAberturaexercicioorcamento->c104_usuario    = db_getsession("DB_id_usuario");
  		$oDaoAberturaexercicioorcamento->c104_instit     = db_getsession("DB_instit");
  		$oDaoAberturaexercicioorcamento->c104_ano        = $iAnoSessao;
  		$oDaoAberturaexercicioorcamento->c104_data       = date('Y-m-d', db_getsession("DB_datausu"));
  		$oDaoAberturaexercicioorcamento->c104_processado = "false";

  		$oAberturaexercicioorcamento 								      = db_utils::fieldsMemory($rsAberturaexercicioorcamento, 0);
  		$oDaoAberturaexercicioorcamento->c104_sequencial	= $oAberturaexercicioorcamento->c104_sequencial;
  		$oDaoAberturaexercicioorcamento->alterar($oAberturaexercicioorcamento->c104_sequencial);

  		if ($oDaoAberturaexercicioorcamento->erro_status == "0") {
  			throw new BusinessException("Erro técnico: Não foi possível estornar o lançamento da depreciação!");
  		}

  		$iSequencialAberturaExercicio = $oDaoAberturaexercicioorcamento->c104_sequencial;
  		$sObservacao                  = $oParam->sObservacao;

		$rsTabelaLancamentos = db_query("create temp table w_conlancam as
                                      select distinct c105_codlan as c70_codlan
                                      from conlancamaberturaexercicioorcamento
                                      inner join aberturaexercicioorcamento on c105_aberturaexercicioorcamento = c104_sequencial
                                      where c104_instit = ".db_getsession('DB_instit')." and c104_ano = ".db_getsession('DB_anousu'));
	    $rsTabelaLancamentos = db_query(" insert into w_conlancam select c71_codlan from conlancamdoc inner join conlancam on c71_codlan = c70_codlan inner join conlancaminstit on c71_codlan = c02_codlan where c71_coddoc = 2023 and c70_anousu = ".db_getsession('DB_anousu')." and c02_instit = ".db_getsession("DB_instit"));

		if (!$rsTabelaLancamentos) {
			throw new Exception('Não foi possivel criar tabela para exclusão de lançamentos'.pg_last_error());
		}

		$rsConlancamemp = db_query("DELETE FROM conlancamemp
                                        WHERE c75_codlan IN
                                            (select c70_codlan from w_conlancam)");

		if (!$rsConlancamemp) {
			throw new Exception('Não foi possivel excluir dados da tabela conlancamemp');
		}

		$rsConlancambol = db_query("DELETE FROM conlancambol
                                            WHERE c77_codlan IN
                                                (select c70_codlan from w_conlancam)");

		if (!$rsConlancambol) {
			throw new Exception('Não foi possivel excluir dados da tabela conlancambol');
		}


		$rsConlancamdig = db_query("DELETE FROM conlancamdig
                                            WHERE c78_codlan IN
                                                (select c70_codlan from w_conlancam)");

		if (!$rsConlancamdig) {
			throw new Exception('Não foi possivel excluir dados da tabela conlancamdig');
		}

		$rsDeleteConlancamCgm = db_query("delete from conlancamcgm  where c76_codlan in (select c70_codlan from w_conlancam)");
		if (!$rsDeleteConlancamCgm) {
			throw new Exception('Não foi possivel excluir dados da tabela conlancamcgm');
		}
		$rsDeleteConlancamGrupo = db_query("delete from conlancamcorgrupocorrente
                                         where c23_conlancam in (select c70_codlan from w_conlancam)"
		);
		if (!$rsDeleteConlancamGrupo) {
			throw new Exception('Não foi possivel excluir dados da tabela conlancamGrupo');
		}

		$rsDeletePagordemdescontolanc = db_query("DELETE FROM pagordemdescontolanc
                                                        WHERE e33_conlancam IN (select c70_codlan from w_conlancam)");
		if (!$rsDeletePagordemdescontolanc) {
			throw new Exception('Não foi possivel excluir dados da tabela pagordemdescontolanc');
		}

		$rsDeleteconlancammatestoqueinimei = db_query("DELETE FROM conlancammatestoqueinimei
                                                        WHERE c103_conlancam IN (select c70_codlan from w_conlancam)");
		if (!$rsDeleteconlancammatestoqueinimei) {
			throw new Exception('Não foi possivel excluir dados da tabela conlancammatestoqueinimei');
		}

		$rsDeleteConlancamCorrente = db_query("delete from conlancamcorrente
                                            where c86_conlancam in (select c70_codlan from w_conlancam)"
		);
		if (!$rsDeleteConlancamCorrente) {
			throw new Exception("Não foi possivel excluir dados da tabela conlancamcorrente\n" . pg_last_error());
		}

		$rsDeleteConlancamRec = db_query("delete from conlancamrec
                                       where c74_codlan in (select c70_codlan from w_conlancam)"
		);
		if (!$rsDeleteConlancamRec) {
			throw new Exception('Não foi possivel excluir dados da tabela conlancamrec');
		}

		$rsDeleteConlancamCompl = db_query("delete from conlancamcompl
                                       where c72_codlan in (select c70_codlan from w_conlancam)"
		);
		if (!$rsDeleteConlancamCompl) {
			throw new Exception('Não foi possivel excluir dados da tabela conlancamcompl');
		}

		$rsDeleteConlancamnota = db_query("DELETE FROM conlancamnota
                                                WHERE c66_codlan IN (select c70_codlan from w_conlancam)");
		if (!$rsDeleteConlancamnota) {
			throw new Exception('Não foi possivel excluir dados da tabela conlancamnota');
		}

		$rsDeleteConlancamele = db_query("DELETE FROM conlancamele
                                                WHERE c67_codlan IN (select c70_codlan from w_conlancam)");
		if (!$rsDeleteConlancamele) {
			throw new Exception('Não foi possivel excluir dados da tabela conlancamele');
		}

		$rsDeleteConlancamPag = db_query("delete from conlancampag
                                       where c82_codlan in (select c70_codlan from w_conlancam)"
		);
		if (!$rsDeleteConlancamPag) {
			throw new Exception('Não foi possivel excluir dados da tabela conlancampag');
		}

		$rsDeleteConlancamDoc = db_query("delete from conlancamdoc
                                       where c71_codlan in (select c70_codlan from w_conlancam)"
		);
		if (!$rsDeleteConlancamDoc) {
			throw new Exception('Não foi possivel excluir dados da tabela conlancamdoc');
		}

		$rsDeleteConlancamdot = db_query("DELETE FROM conlancamdot
                                                    WHERE c73_codlan IN
                                                        (select c70_codlan from w_conlancam)");

		if (!$rsDeleteConlancamdot) {
			throw new Exception('Não foi possivel excluir dados da tabela conlancamdot');
		}

		$rsdeleteConlancamlr = db_query("DELETE FROM conlancamlr
                                                WHERE c81_sequen IN
                                                    (SELECT c69_sequen
                                                     FROM conlancamval
                                                     WHERE c69_codlan IN
                                                         (select c70_codlan from w_conlancam))");

		if (!$rsdeleteConlancamlr) {
			throw new Exception('Não foi possivel excluir dados da tabela conlancamlr');
		}

		$rsDeleteConlancamCC = db_query("delete from contacorrentedetalheconlancamval
                                       where c28_conlancamval in (select c69_sequen
                                                                    from conlancamval
                                                                   where c69_codlan in (select c70_codlan
                                                                                         from w_conlancam)
                                                                   )"
		);
		if (!$rsDeleteConlancamCC) {
			throw new Exception('Não foi possivel excluir dados da tabela contacorrentedetalheconlancamval');
		}

		$rsDeleteConlanordem = db_query(" delete from conlancamordem
                                        where c03_codlan in (select c70_codlan from w_conlancam)"
		);
		if (!$rsDeleteConlanordem) {
			throw new Exception('Não foi possivel excluir dados da tabela conlancamordem');
		}

		$rsDeleteConlancamVal = db_query(" delete from conlancamval
                                        where c69_codlan in (select c70_codlan from w_conlancam)"
		);
		if (!$rsDeleteConlancamVal) {
			throw new Exception('Não foi possivel excluir dados da tabela conlancamval: '.pg_last_error());
		}

		$rsDeleteConlancamCP = db_query("delete from conlancamconcarpeculiar
                                      where c08_codlan in (select c70_codlan from w_conlancam)"
		);
		if (!$rsDeleteConlancamCP) {
			throw new Exception('Não foi possivel excluir dados da tabela conlancamconcarpeculiar');
		}

		$rsDeleteConlancamord = db_query("delete from conlancamord where c80_codlan in (select c70_codlan from w_conlancam)");

		if (!$rsDeleteConlancamord) {
			throw new Exception('Não foi possivel excluir dados da tabela conlancamord');
		}

		$rsDeleteConlancamInstit = db_query("delete from conlancaminstit where c02_codlan in (select c70_codlan from w_conlancam)");

		if (!$rsDeleteConlancamInstit) {
			throw new Exception('Não foi possivel excluir dados da tabela conlancaminstit');
		}

		$rsDeleteConlancamOrdem = db_query("delete from conlancamordem where c03_codlan in (select c70_codlan from w_conlancam)");

		if (!$rsDeleteConlancamOrdem) {
			throw new Exception('Não foi possivel excluir dados da tabela conlancamordem');
		}

		$rsDeleteconlancambem = db_query("delete from conlancambem where c110_codlan in (select c70_codlan from w_conlancam)");

		if (!$rsDeleteConlancamOrdem) {
			throw new Exception('Não foi possivel excluir dados da tabela conlancamordem');
		}

		$rsDeleteconlancamaberturaexercicioorcamento = db_query("DELETE FROM conlancamaberturaexercicioorcamento
																	where c105_codlan IN
																		(SELECT c70_codlan
																		 FROM w_conlancam)");
		if (!$rsDeleteconlancamaberturaexercicioorcamento) {
			throw new Exception('Não foi possivel excluir dados da tabela conlancamaberturaexercicioorcamento');
		}

		$rsDeleteConlancam = db_query("delete from conlancam where c70_codlan in (select c70_codlan from w_conlancam)");
		if (!$rsDeleteConlancam) {
			throw new Exception('Não foi possivel excluir dados da tabela conlancam');
		}

  		$oRetorno->message = 'Lançamentos desprocessados com sucesso.';

  		db_fim_transacao(false); // @todo

		break;
	  case "buscarRegras":

		  $oRetorno->aRegras = getRegrasAberturaExercicio($iAnoSessao,$iInstituicao);
		  break;

	  case "salvarRegra":

		  if (empty($oParam->contadevedora)) {
			  throw new Exception("Conta Devedora não informada.");
		  }

		  if (empty($oParam->contacredora)) {
			  throw new Exception("Conta Credora não informada.");
		  }

		  $oDaoRegrasAbertura = new cl_regraaberturaexercicio();

		  $oDaoRegrasAbertura->c217_sequencial = null;
		  $oDaoRegrasAbertura->c217_anousu = db_getsession("DB_anousu");
		  $oDaoRegrasAbertura->c217_instit = db_getsession("DB_instit");
		  $oDaoRegrasAbertura->c217_contadevedora = $oParam->contadevedora;
		  $oDaoRegrasAbertura->c217_contacredora = $oParam->contacredora;
		  $oDaoRegrasAbertura->c217_contareferencia = $oParam->contareferencia;

		  $oDaoRegrasAbertura->incluir(null);

		  if ($oDaoRegrasAbertura->erro_status == 0) {
			  throw new Exception($oDaoRegrasAbertura->erro_msg);
		  }

		  break;

	  case "removerRegra":

		  if (empty($oParam->iCodigoRegra)) {
			  throw new Exception("Código da Regra não informado.");
		  }

		  $oDaoRegrasAbertura = new cl_regraaberturaexercicio();

		  $oDaoRegrasAbertura->excluir(null,
			  "c217_sequencial = {$oParam->iCodigoRegra} "
			  . "and c217_anousu = " . db_getsession("DB_anousu")
			  . " and c217_instit = " . db_getsession("DB_instit"));
		  if ($oDaoRegrasAbertura->erro_status == 0) {
			  $oRetorno->message = $oDaoRegrasAbertura->erro_msg;
		  }
		  $oRetorno->message = 'Regra Excluída com sucesso!.';
		  break;
	  case "importarRegra":

		  $oDaoRegrasAbertura = new cl_regraaberturaexercicio();

		  $sSqlVerifica = "SELECT ";
		  $sSqlVerifica .= db_getsession("DB_anousu") . "       as c217_anousu, ";
		  $sSqlVerifica .= "       c217_instit, ";
		  $sSqlVerifica .= "       c217_contadevedora, ";
		  $sSqlVerifica .= "       c217_contacredora, ";
		  $sSqlVerifica .= "       c217_contareferencia ";
		  $sSqlVerifica .= "FROM   regraaberturaexercicio WHERE  c217_anousu = {$iAno}";
		  $sSqlVerifica .= "       AND c217_instit = " . db_getsession("DB_instit");

		  if(pg_num_rows(db_query($sSqlVerifica)) > 0) {


			  $oDaoRegrasAbertura->excluir(null,
				  " c217_anousu = " . db_getsession("DB_anousu")
				  . " and c217_instit = " . db_getsession("DB_instit"));

			  $iAno = db_getsession("DB_anousu") - 1;

			  $sSqlImportarRegras = " INSERT INTO regraaberturaexercicio ";
			  $sSqlImportarRegras .= "SELECT nextval('regraaberturaexercicio_c217_sequencial_seq') AS ";
			  $sSqlImportarRegras .= "       c217_sequencial, ";
			  $sSqlImportarRegras .= db_getsession("DB_anousu") . "       as c217_anousu, ";
			  $sSqlImportarRegras .= "       c217_instit, ";
			  $sSqlImportarRegras .= "       c217_contadevedora, ";
			  $sSqlImportarRegras .= "       c217_contacredora, ";
			  $sSqlImportarRegras .= "       c217_contareferencia ";
			  $sSqlImportarRegras .= "FROM   regraaberturaexercicio WHERE  c217_anousu = {$iAno}";
			  $sSqlImportarRegras .= "       AND c217_instit = " . db_getsession("DB_instit");

			  $oDaoRegrasAbertura->sql_record($sSqlImportarRegras);

		  }
		  break;

  }

} catch (BusinessException $oErro){

	$oRetorno->status  = 2;
	$oRetorno->message = $oErro->getMessage();

} catch (ParameterException $oErro) {

	$oRetorno->status  = 2;
	$oRetorno->message = $oErro->getMessage();

} catch (DBException $oErro) {

	$oRetorno->status  = 2;
	$oRetorno->message = $oErro->getMessage();

} catch (Exception $oErro) {

	$oRetorno->status  = 2;
	$oRetorno->message = $oErro->getMessage();
}

$oRetorno->message = urlEncode($oRetorno->message);

echo $oJson->encode($oRetorno);

/**
 * Executa lancamento
 * @param $iCodigoDocumento
 * @param $nValorLancamento
 * @param $iSequencialAberturaExercicio
 * @param $sObservacao
 * @param null $iCodDot
 * @param null $iAnoDotacao
 * @param null $iCodFontRec
 * @param null $sEstrutFont
 * @return bool
 * @throws BusinessException
 */
function executaLancamento($iCodigoDocumento, $nValorLancamento, $iSequencialAberturaExercicio, $sObservacao, $iCodDot = null, $iAnoDotacao = null, $iCodFontRec = null, $sEstrutFont = null) {

	/**
	 * Descobre o codigo do documento pelo tipo
	 */
	$oEventoContabil  = new EventoContabil($iCodigoDocumento, db_getsession("DB_anousu"));
	$aLancamentos     = $oEventoContabil->getEventoContabilLancamento();
	$iCodigoHistorico = $aLancamentos[0]->getHistorico();

	unset($oDocumentoContabil);
	unset($aLancamentos);
  
	$oLancamentoAuxiliarAberturaExercicio = new LancamentoAuxiliarAberturaExercicioOrcamento();
	$oLancamentoAuxiliarAberturaExercicio->setObservacaoHistorico($sObservacao);
	$oLancamentoAuxiliarAberturaExercicio->setValorTotal($nValorLancamento);
	$oLancamentoAuxiliarAberturaExercicio->setHistorico($iCodigoHistorico);
	$oLancamentoAuxiliarAberturaExercicio->setAberturaExercicioOrcamento($iSequencialAberturaExercicio);

  if($iCodDot != null){

    $oDotacao = new Dotacao($iCodDot, $iAnoDotacao);
    $oContaCorrenteDetalhe = new ContaCorrenteDetalhe();
    $oContaCorrenteDetalhe->setDotacao($oDotacao);
    $oLancamentoAuxiliarAberturaExercicio->setContaCorrenteDetalhe($oContaCorrenteDetalhe);

  }

  if($iCodFontRec != null){
	  $oRecurso = new Recurso($iCodFontRec);
	  $oContaCorrenteDetalhe = new ContaCorrenteDetalhe();
	  $oContaCorrenteDetalhe->setRecurso($oRecurso);
	  $oContaCorrenteDetalhe->setEstrutural($sEstrutFont);
	  $oLancamentoAuxiliarAberturaExercicio->setContaCorrenteDetalhe($oContaCorrenteDetalhe);
  }

	$oEventoContabil->executaLancamento($oLancamentoAuxiliarAberturaExercicio);

	return true;
}

/**
 * Retorna as regras da natureza orçamnetária
 * @throws Exception
 * @return array
 */
function getRegrasAberturaExercicio($iAno, $iInstit) {

	$oDaoRegrasAbertura = new cl_regraaberturaexercicio();
	$sSqlRegrasAbertura = $oDaoRegrasAbertura->sql_query( null,
		"*",
		" c217_sequencial ",
		"c217_anousu = {$iAno}"
		. " and c217_instit = {$iInstit}" );
	$rsRegrasAbertura   = $oDaoRegrasAbertura->sql_record( $sSqlRegrasAbertura );

	$aRegras = array();

	if ($oDaoRegrasAbertura->numrows > 0) {
		$aRegras = db_utils::getCollectionByRecord($rsRegrasAbertura);
	}

	return $aRegras;
}

/**
 * Busca o saldo implantado
 * @param $iReduz
 * @param $iContaCorrente
 */
function getSaldoImplantado($iReduz, $iContaCorrente){
	$sSql = "SELECT CASE WHEN c29_debito > 0 THEN c29_debito WHEN c29_credito > 0 THEN -1 * c29_credito ELSE 0 END AS saldoanterior
			 FROM contacorrente
			 INNER JOIN contacorrentedetalhe ON contacorrente.c17_sequencial = contacorrentedetalhe.c19_contacorrente
			 INNER JOIN contacorrentesaldo ON contacorrentesaldo.c29_contacorrentedetalhe = contacorrentedetalhe.c19_sequencial
			 AND contacorrentesaldo.c29_mesusu = 0 and contacorrentesaldo.c29_anousu = " . db_getsession("DB_anousu") . "
			 WHERE c19_reduz IN (" . implode(',', $oContas10->contas) . ")
			   AND c17_sequencial = {$nContaCorrente}
			   AND c19_orcdotacao = {$oReg11->c73_coddot}";
}

function getContaCorrenteByReduz($iReduz){

	$oDaoConplanoContaCorrente = new cl_conplanocontacorrente();
	$sWhere = " c61_reduz = {$iReduz} and c61_anousu = ".db_getsession("DB_anousu")." and c61_instit = ".db_getsession("DB_instit");
	$sSqlConplanoContaCorrente = $oDaoConplanoContaCorrente->sql_query_conplano_contacorrente(null,"DISTINCT c17_sequencial",null,$sWhere);
	$iContacorrente = db_utils::fieldsMemory(db_query($sSqlConplanoContaCorrente), 0)->c17_sequencial;

	return $iContacorrente;

}

function getContaCorrenteDetalheByReduz($iReduzido, $iFiltroContaCorrente){

	$sSqlLancamentos = " select distinct c19_sequencial,c19_orctiporec from contacorrentesaldo  ";
	$sSqlLancamentos .= " inner join contacorrentedetalhe on c29_contacorrentedetalhe = c19_sequencial ";
	$sSqlLancamentos .= " where c19_conplanoreduzanousu = ".db_getsession('DB_anousu')." and c19_reduz = {$iReduzido} ";
	$sSqlLancamentos .= " and c29_anousu = ".db_getsession('DB_anousu')." and c29_mesusu =0 AND c19_contacorrente = {$iFiltroContaCorrente} AND c19_orctiporec IS NOT NULL";

	$rsLancamentos    = db_query($sSqlLancamentos) or die($sSqlLancamentos);
	$aLancamento      = db_utils::getColectionByRecord($rsLancamentos);

	return $aLancamento;

}

function getSaldoContaCorrente($nContaCorrenteDetalhe, $nContaCorrente){

	$sSqlSaldos = "SELECT CASE WHEN c29_debito > 0 THEN c29_debito WHEN c29_credito > 0 THEN -1 * c29_credito ELSE 0 END AS saldoimplantado
                                     FROM contacorrente
                                     INNER JOIN contacorrentedetalhe ON contacorrente.c17_sequencial = contacorrentedetalhe.c19_contacorrente
                                     INNER JOIN contacorrentesaldo ON contacorrentesaldo.c29_contacorrentedetalhe = contacorrentedetalhe.c19_sequencial
                                     AND contacorrentesaldo.c29_mesusu = 0 and contacorrentesaldo.c29_anousu = " . db_getsession("DB_anousu") . "
                                     WHERE contacorrentedetalhe.c19_sequencial = {$nContaCorrenteDetalhe}
                                     AND c17_sequencial = {$nContaCorrente}";
	try{

		$rsSaldos         = db_query($sSqlSaldos) or die($sSqlSaldos." Erro: ".pg_last_error());
		$aSaldos          = db_utils::getColectionByRecord($rsSaldos);

		return $aSaldos;

	} catch (Exception $ex){

		throw new Exception("Erro ao executar o SQL getSaldoContaCorrente. Erro: ".$ex->getMessage());

	}


}