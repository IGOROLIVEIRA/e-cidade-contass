<?php

require_once("std/db_stdClass.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");

db_postmemory($_POST);

$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\","",$_POST["json"]));

$oRetorno          = new stdClass();
$oRetorno->status  = 1;

$nAnoUsu = db_getsession('DB_anousu');
$nInstit = db_getsession('DB_instit');

switch ($oParam->exec){

  case "buscaEntesConsorcionados":

    require_once("classes/db_entesconsorciados_classe.php");

    try {

      $oEntes = new cl_entesconsorciados();

      $sDataIni = "{$nAnoUsu}-{$oParam->mes}-01";
      $sDataFim = date('Y-m-t', mktime(0, 0, 0, $oParam->mes, 1, $nAnoUsu));

      $sWhere = "
        c215_datainicioparticipacao <= '{$sDataFim}'
        AND (
          (c215_datafimparticipacao >= '{$sDataIni}')
          OR
          (c215_datafimparticipacao IS NULL)
        )
      ";

      $sCampos = implode(', ', array(
        'c215_sequencial',
        'c215_cgm',
        'c215_percentualrateio',
        'z01_nome'
      ));

      $sSql = $oEntes->sql_query(null, $sCampos, null, $sWhere);

      $rsEntes = $oEntes->sql_record($sSql);

      $aEntes = db_utils::getCollectionByRecord($rsEntes);

      $oRetorno->entes = array();

      foreach ($aEntes as $oEnte) {

        $oNovoEnte = new stdClass();
        $oNovoEnte->sequencial   = $oEnte->c215_sequencial;
        $percentualrateio = getPercentual( $oParam->mes, $oEnte->c215_sequencial );

        $oNovoEnte->percentual   = $percentualrateio;
        $oNovoEnte->cgm          = $oEnte->c215_cgm;
        $oNovoEnte->nome         = utf8_encode($oEnte->z01_nome);

        $oRetorno->entes[] = $oNovoEnte;

      }
     //echo "<pre>";print_r($oRetorno);exit;
    } catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
    }

  break; // buscaEntesConsorcionados


  case "buscaDotacoes":

    require_once("classes/db_orcdotacao_classe.php");

    try {

      $oDotacoes = new cl_orcdotacao();

      $sCampos = implode(', ', array(
        'o58_coddot',
        'o58_orgao',
        'o58_unidade',
        'o58_funcao',
        'o58_subfuncao',
        'o58_programa',
        'o58_projativ',
        'o56_elemento',
        'o56_descr'
      ));

      $sWhere = "o58_anousu = {$nAnoUsu} AND o58_instit = {$nInstit}";

      $sSql = $oDotacoes->sql_query(null, null, $sCampos, 'o58_coddot', $sWhere);

      $rsDotacoes = $oDotacoes->sql_record($sSql);

      $aDotacoes = db_utils::getCollectionByRecord($rsDotacoes);

      $oRetorno->dotacoes = array();

      foreach ($aDotacoes as $oDotacao) {

        $oNovaDotacao = new stdClass();

        $oNovaDotacao->codigo     = $oDotacao->o58_coddot;
        $oNovaDotacao->orgao      = str_pad($oDotacao->o58_orgao, 2, '0', STR_PAD_LEFT);
        $oNovaDotacao->unidade    = str_pad($oDotacao->o58_unidade, 2, '0', STR_PAD_LEFT);
        $oNovaDotacao->funcao     = str_pad($oDotacao->o58_funcao, 2, '0', STR_PAD_LEFT);
        $oNovaDotacao->subfuncao  = str_pad($oDotacao->o58_subfuncao, 3, '0', STR_PAD_LEFT);
        $oNovaDotacao->programa   = str_pad($oDotacao->o58_programa, 4, '0', STR_PAD_LEFT);
        $oNovaDotacao->projativ   = str_pad($oDotacao->o58_projativ, 4, '0', STR_PAD_LEFT);
        $oNovaDotacao->elemento   = $oDotacao->o56_elemento;
        $oNovaDotacao->descricao  = utf8_encode($oDotacao->o56_descr);

        $oRetorno->dotacoes[] = $oNovaDotacao;

      }

    } catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
    }

  break; // buscaDotacoes


  case 'processarRateio':

    require_once('classes/db_conlancamdoc_classe.php');
    require_once('classes/db_despesarateioconsorcio_classe.php');
    require_once('classes/db_entesconsorciados_classe.php');

    $oConLancamDoc = new cl_conlancamdoc();

    try {

      if (empty($oParam->dotacoes)) {
        throw new Exception("Selecione pelo menos uma dotação", 1);
      }
      if (empty($oParam->entes)) {
        throw new Exception("Erro ao processar os entes: nenhum ente encontrado", 1);
      }
      if (empty($oParam->mes)) {
        throw new Exception("Mês inválido", 1);
      }

      $aEntes = array();

      $aRetornoFinal = array();
      foreach ($oParam->entes as $oEnte) {
        $aEntes[$oEnte->id] = $oEnte->percentual;
      }

      $sDotacoes = implode(', ', $oParam->dotacoes);
      //if (intval($oParam->mes) < 12) {
        $aClassificacao = $oConLancamDoc->classificacao($oParam->mes, $sDotacoes);

        $aPercenteAplicado = $oConLancamDoc->aplicaPercentDotacoes($aClassificacao, $aEntes);

        $aRetornoFinal = $aPercenteAplicado;

      // }else {

      //   $aClassificacaoDezembro = $oConLancamDoc->classificacaoAteDezembro($sDotacoes);

      //   $aPercenteAplicadoDezmb = $oConLancamDoc->aplicaPercentDotacoes($aClassificacaoDezembro, $aEntes);

      //   foreach ($aPercenteAplicadoDezmb as $nIdEnte => $oInfoEnte) {

      //     foreach ($oInfoEnte->dotacoes as $sHash => $oDotacao) {

      //       if (!isset($aRetornoFinal[$nIdEnte])) {
      //         $aRetornoFinal[$nIdEnte] = $oInfoEnte;
      //       }
           
      //       if (isset($aRetornoFinal[$nIdEnte]->dotacoes[$sHash])) {
              
      //         $aRetornoFinal[$nIdEnte]->dotacoes[$sHash]->valorempenhado  += $oDotacao->valorempenhado ;
      //         $aRetornoFinal[$nIdEnte]->dotacoes[$sHash]->valorliquidado  += $oDotacao->valorliquidado;
      //         $aRetornoFinal[$nIdEnte]->dotacoes[$sHash]->valorpago       += $oDotacao->valorpago;

      //       } else {
      //         $aRetornoFinal[$nIdEnte]->dotacoes[$sHash]= $oDotacao;
      //       }

      //     }

      //   }

      //} // mês 12
      //print_r($aRetornoFinal);
      $oDespesaRateioConsorcio  = new cl_despesarateioconsorcio();
      $sWhereExcluir = ''
        . ' c217_mes = ' . intval($oParam->mes)
        . ' AND c217_anousu = ' . intval($nAnoUsu)
      ;
      $oDespesaRateioConsorcio->excluir(null, $sWhereExcluir);

      foreach ($aRetornoFinal as $nIdEnte => $oInfoEnte) {

        $oEntesConsorciados = new cl_entesconsorciados();

        $oEntesConsorciados->c215_sequencial        = $oInfoEnte->enteconsorciado;
        $oEntesConsorciados->c215_percentualrateio  = floatval($oInfoEnte->percentualrateio);
        $oEntesConsorciados->alterar($oInfoEnte->enteconsorciado);

        foreach ($oInfoEnte->dotacoes as $sHash => $oDotacao) {

          $oDespesaRateioConsorcio  = new cl_despesarateioconsorcio();

          $oDespesaRateioConsorcio->c217_enteconsorciado        = $oInfoEnte->enteconsorciado;
          $oDespesaRateioConsorcio->c217_percentualrateio       = floatval($oInfoEnte->percentualrateio);
          $oDespesaRateioConsorcio->c217_funcao                 = intval($oDotacao->funcao);
          $oDespesaRateioConsorcio->c217_subfuncao              = intval($oDotacao->subfuncao);
          $oDespesaRateioConsorcio->c217_natureza               = $oDotacao->natureza;
          $oDespesaRateioConsorcio->c217_subelemento            = $oDotacao->subelemento;
          $oDespesaRateioConsorcio->c217_fonte                  = intval($oDotacao->fonte);
          $oDespesaRateioConsorcio->c217_valorempenhado         = floatval($oDotacao->valorempenhado);
          $oDespesaRateioConsorcio->c217_valorempenhadoanulado  = floatval($oDotacao->valorempenhadoanulado);
          $oDespesaRateioConsorcio->c217_valorliquidado         = floatval($oDotacao->valorliquidado);
          $oDespesaRateioConsorcio->c217_valorliquidadoanulado  = floatval($oDotacao->valorliquidadoanulado);
          $oDespesaRateioConsorcio->c217_valorpago              = floatval($oDotacao->valorpago);
          $oDespesaRateioConsorcio->c217_valorpagoanulado       = floatval($oDotacao->valorpagoanulado);
          $oDespesaRateioConsorcio->c217_mes                    = intval($oParam->mes);
          $oDespesaRateioConsorcio->c217_anousu                 = $nAnoUsu;

          $oDespesaRateioConsorcio->incluir();

          if (!in_array($oDespesaRateioConsorcio->erro_status, array(1, null))) {
            throw new Exception("{$nIdEnte} :: $sHash | " . $oDespesaRateioConsorcio->erro_msg, 1);
          }

        }
      }

      $oRetorno->classificacao = $aRetornoFinal;

    } catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
    }

    $oRetorno->sucesso = utf8_encode("Geração realizada.");

  break;

}
function saldoAntTodos($mes){
    
    $oEntesConsorciados = new cl_entesconsorciados();
    
    $rsRecSaldoInicialTodos = $oEntesConsorciados->sql_record( $oEntesConsorciados->sql_rec_saldo_inicial(null) );
    $nSaldoInicialRecTodos = db_utils::fieldsMemory($rsRecSaldoInicialTodos, 0)->c216_saldo3112;

    $rsDesp = $oEntesConsorciados->sql_record($oEntesConsorciados->gerarSQLDespesas($mes, null));
    $nDesp = db_utils::fieldsMemory($rsDesp, 0)->despesasatemes;

    $rsRecAntesTodos = $oEntesConsorciados->sql_record($oEntesConsorciados->gerarSQLReceitas($mes,null));
    $nRecAntesTodos = db_utils::getCollectionByRecord($rsRecAntesTodos, 0)->receitasatemes;
    
    $nSaldo = 0;
    $nSaldo = $nSaldoInicialRecTodos + $nRecAntesTodos - $nDesp ;

    // echo "<br> nSaldoInicialRecTodos => ".$nSaldoInicialRecTodos 
    //   ."<br> nDesp => ".$nDesp
    //   . "<br> nRecAntesTodos => ".$nRecAntesTodos;

    return $nSaldo;
}
function saldoAntEnte($mes, $ente){
    
    $oEntesConsorciados = new cl_entesconsorciados();
    
    $rsRecSaldoInicialEnte = $oEntesConsorciados->sql_record($oEntesConsorciados->sql_rec_saldo_inicial($ente));
    $nSaldoInicialRecEnte = db_utils::fieldsMemory($rsRecSaldoInicialEnte, 0)->c216_saldo3112;
    
    $rsDesp = $oEntesConsorciados->sql_record($oEntesConsorciados->gerarSQLDespesas($mes, $ente));
    $nDesp = db_utils::fieldsMemory($rsDesp, 0)->despesasatemes;

    $rsRelatorioFinanceiro = $oEntesConsorciados->sql_record($oEntesConsorciados->gerarSQLReceitas($mes, $ente));
    $nRecAntesEnte = db_utils::getCollectionByRecord($rsRelatorioFinanceiro,0)->receitasatemes;
    
    $nSaldo = 0;
    $nSaldo = $nSaldoInicialRecEnte + $nRecAntesEnte - $nDesp ;

    return $nSaldo;
}
  // funcao do sql para pegar valor percentual da arrecadação de um ente sobre todos os outros.
function getPercentual ( $mes, $ente) {
    $oEntesConsorciados = new cl_entesconsorciados();
    /*
      1 - Pegar arrecadação total de receitas totalRecMes ok
      2 - Pegar o saldo anterior do rateio para o ente saldoAntEnte. ok
      3 - Pegar o total arrecadado do ente no mês totalRecEnteMes. ok
      4 - Se o saldoAntEnte for menor que ZERO não utilizar. ok
      5 - Pegar o total saldo anterior geral saldoAntTodos
      5 - Percentual = ( (totalRecEnteMes + saldoAntEnte) / (totalRecMes + saldoAntTodos)) * 100
    */
      //retorna o total arrecadado de rateio no mes
      $sqlTotalRecMes = "SELECT coalesce(sum(CASE
                                              WHEN c71_coddoc = 100 THEN c70_valor
                                              ELSE c70_valor * -1
                                          END),0) AS totalrecmes
                      from orcreceita 
                      INNER JOIN conlancamrec ON c74_anousu=o70_anousu AND c74_codrec=o70_codrec
                      INNER JOIN conlancam ON c74_codlan=c70_codlan
                      INNER JOIN conlancamdoc ON c71_codlan=c70_codlan
                      WHERE date_part('MONTH',c70_data) = ".$mes."
                          AND date_part('YEAR',c70_data)=".db_getsession('DB_anousu')."
                          AND o70_codfon in 
                      (select c216_receita from entesconsorciadosreceitas where c216_anousu=".db_getsession('DB_anousu').") limit 1";
      
      $rsTotalRecMes = $oEntesConsorciados->sql_record($sqlTotalRecMes);
      $totalRecMes = db_utils::fieldsMemory($rsTotalRecMes,0)->totalrecmes;

      $sqlTotalRecEnteMes = " SELECT coalesce(sum( CASE
                                                      WHEN c71_coddoc = 100 THEN c70_valor
                                                      ELSE c70_valor * -1
                                                  END),0) AS totalrecentemes
                            from orcreceita 
                            INNER JOIN conlancamrec ON c74_anousu=o70_anousu AND c74_codrec=o70_codrec
                            INNER JOIN conlancam ON c74_codlan=c70_codlan
                            INNER JOIN conlancamdoc ON c71_codlan=c70_codlan
                            WHERE date_part('MONTH',c70_data) = ".$mes."
                                AND date_part('YEAR',c70_data)=".db_getsession('DB_anousu')."
                                AND o70_codfon = (select c216_receita 
                            from entesconsorciadosreceitas where c216_enteconsorciado = ".$ente." 
                             and c216_anousu=".db_getsession('DB_anousu')." limit 1 )  ";
      
      $rsTotalRecEnteMes = $oEntesConsorciados->sql_record($sqlTotalRecEnteMes);
      $totalRecEnteMes = db_utils::fieldsMemory($rsTotalRecEnteMes,0)->totalrecentemes;
      
      $saldoAntEnte = saldoAntEnte($mes, $ente);
      
      // if($saldoAntEnte < 0)
      //    $saldoAntEnte = 0;

      $saldoAntTodos = saldoAntTodos($mes);


      // echo "<br> totalRecEnteMes => ".$totalRecEnteMes 
      // ."<br> saldoAntEnte => ".$saldoAntEnte
      // . "<br> totalRecMes => ".$totalRecMes
      // ."<br> saldoAntTodos => ". $saldoAntTodos;
      $percent = ( ($totalRecEnteMes + $saldoAntEnte)/($totalRecMes + $saldoAntTodos) ) * 100;
      return round($percent,2);
}

if (isset($oRetorno->erro)) {
  $oRetorno->erro = utf8_encode($oRetorno->erro);
}

echo $oJson->encode($oRetorno);
?>
