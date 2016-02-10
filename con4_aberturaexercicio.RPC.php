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
      $iTipoDocumento = 2003;
  	  //$nValorReceita  = ReceitaContabil::getValorPrevistoAno( $iAnoSessao, $iInstituicao );

	  $sSqlOrcreceita  = "SELECT DISTINCT o70_codigo, o70_anousu, o70_valor, o57_fonte FROM orcreceita
	   						inner join orcfontes on o70_codfon = o57_codfon and o70_anousu = o57_anousu
	   						inner join orctiporec on o70_codigo = o15_codigo
	  						 where o70_instit = {$iInstituicao} and o70_anousu= {$iAnoSessao}";
	  $rsSqlOrcreceita = db_query($sSqlOrcreceita) or die($sSqlOrcreceita);

	  for ($iContRec = 0; $iContRec < pg_num_rows($rsSqlOrcreceita); $iContRec++) {

		  $oReceita = db_utils::fieldsMemory($rsSqlOrcreceita, $iContRec);

		  if($oReceita->o70_valor > 0){
			  executaLancamento($iTipoDocumento, $oReceita->o70_valor, $iSequencialAberturaExercicio, $sObservacao, null, null, $oReceita->o70_codigo, $oReceita->o57_fonte);
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

  		/**
  		 * Receita - Lancamento contabil para abertura de exercicio
		 * Removido estorno da operação. Os lançamentos serão excluídos.

  		$iTipoDocumento = 2004;
  		$nValorReceita  = ReceitaContabil::getValorPrevistoAno($iAnoSessao, $iInstituicao);

  		if ($nValorReceita > 0) {
    		executaLancamento($iTipoDocumento, $nValorReceita, $iSequencialAberturaExercicio, $sObservacao);
  		}
		 *
		 * */

  		/**
  		 * Despesa - Lancamento contabil para abertura de exercicio
  		 * Removido estorno da operação. Os lançamentos serão excluídos.
  		$iTipoDocumento = 2002;
  		//$nValorDespesa  = Dotacao::getValorPrevistoNoAno($iAnoSessao, $iInstituicao);
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

  		if ($nValorDespesa > 0 ) {
    		executaLancamento($iTipoDocumento, $nValorDespesa, $iSequencialAberturaExercicio, $sObservacao);
  		}
		 */
		$rsTabelaLancamentos = db_query("create temp table w_conlancam as
                                      select distinct c105_codlan as c70_codlan
                                      from conlancamaberturaexercicioorcamento
                                      inner join aberturaexercicioorcamento on c105_aberturaexercicioorcamento = c104_sequencial
                                      where c104_instit = ".db_getsession('DB_instit')." and c104_ano = ".db_getsession('DB_anousu'));

		if (!$rsTabelaLancamentos) {
			throw new Exception('Não foi possivel criar tabela para exclusão de lançamentos');
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
			throw new Exception('Não foi possivel excluir dados da tabela conlancamval');
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
