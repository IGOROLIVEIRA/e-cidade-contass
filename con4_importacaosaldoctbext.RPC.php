<?php
require_once("std/db_stdClass.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("std/DBDate.php");
require_once "model/contabilidade/planoconta/ContaCorrente.model.php";
require_once "model/contabilidade/planoconta/ContaPlano.model.php";
db_app::import("configuracao.*");
db_app::import("contabilidade.*");
db_app::import("contabilidade.planoconta.*");
db_app::import("financeiro.*");
db_app::import("exceptions.*");
db_postmemory($_POST);

$oJson  = new services_json();
$oParam = $oJson->decode(str_replace("\\","",$_POST["json"]));
$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$sqlerro = false;

$ano = $oParam->ano;

switch ($oParam->exec) {

  case 'importSaldoCtbExt':

    try {

      db_inicio_transacao();

      $sSqlGeral = "select  10 as tiporegistro,
                     k13_reduz as icodigoreduzido,
                     c61_codtce as codtce,
                     si09_codorgaotce,
                     c63_banco,
                     c63_agencia,
                     c63_conta,
                     c63_dvconta,
                     c63_dvagencia,
                     case when db83_tipoconta in (2,3) then 2 else 1 end as tipoconta,
                     ' ' as tipoaplicacao,
                     ' ' as nroseqaplicacao,
                     db83_descricao as desccontabancaria,
                     CASE WHEN (db83_convenio is null or db83_convenio = 2) then 2 else  1 end as contaconvenio,
                     case when db83_convenio = 1 then db83_numconvenio else null end as nroconvenio,
                     case when db83_convenio = 1 then db83_dataconvenio else null end as dataassinaturaconvenio,
                     o15_codtri as recurso
               from saltes
               join conplanoreduz on k13_reduz = c61_reduz and c61_anousu = ".db_getsession("DB_anousu")."
               join conplanoconta on c63_codcon = c61_codcon and c63_anousu = c61_anousu
               join orctiporec on c61_codigo = o15_codigo
          left join conplanocontabancaria on c56_codcon = c61_codcon and c56_anousu = c61_anousu
          left join contabancaria on c56_contabancaria = db83_sequencial
          left join infocomplementaresinstit on si09_instit = c61_instit
            where c61_instit = ".db_getsession("DB_instit")." and k13_reduz = 4970 order by k13_reduz";
      //echo $sSqlGeral;
      $rsContas = db_query($sSqlGeral);//db_criatabela($rsContas);die;

      $aBancosAgrupados = array();

      $rsContas = db_query($sSqlGeral);

      for ($iCont = 0;$iCont < pg_num_rows($rsContas); $iCont++) {

          $oRegistro10 = db_utils::fieldsMemory($rsContas,$iCont);


          $aHash  = $oRegistro10->si09_codorgaotce;
          $aHash .= intval($oRegistro10->c63_banco);
          $aHash .= intval($oRegistro10->c63_agencia);
          $aHash .= intval($oRegistro10->c63_dvagencia);
          $aHash .= intval($oRegistro10->c63_conta);
          $aHash .= intval($oRegistro10->c63_dvconta);
          $aHash .= $oRegistro10->tipoconta;
          if ($oRegistro10->si09_codorgaotce == 5) {
              $aHash .= $oRegistro10->tipoaplicacao;
          }

          if(!isset($aBancosAgrupados[$aHash])){

              $cCtb10    =  new stdClass();

              $cCtb10->icodigoreduzido = $oRegistro10->icodigoreduzido;
              //$cCtb10->codtce = $oRegistro10->codtce;
              $cCtb10->contas = array();
              $aBancosAgrupados[$aHash] = $cCtb10;

          }else{
              $aBancosAgrupados[$aHash]->contas[] = $oRegistro10->icodigoreduzido;
          }

      }


      $anousu = db_getsession("DB_anousu") - 1;
      $aSaldoCtb = array();
      foreach ($aBancosAgrupados as $aBancosAgrupado) {
        $sSQL = "select si96_codfontrecursos, si96_vlsaldofinalfonte from ctb20{$anousu} where si96_codctb = {$aBancosAgrupado->icodigoreduzido} and si96_mes = 12 and si96_instit = ".db_getsession("DB_instit");
        $rsResult = db_query($sSQL);//echo "<pre>";var_dump($sSQL);die;
        $oCtbFontes = db_utils::getCollectionByRecord($rsResult);
        //echo "<pre>"; print_r($oCtbFontes);die;
        foreach ($oCtbFontes as $oCtbFonte) {
          $aHash = $aBancosAgrupado->icodigoreduzido.$oCtbFonte->si96_codfontrecursos;

          $ctbFonte = new stdClass();
          $ctbFonte->icodigoreduzido = $aBancosAgrupado->icodigoreduzido;
          $ctbFonte->si96_codfontrecursos = $oCtbFonte->si96_codfontrecursos;
          $ctbFonte->si96_vlsaldofinalfonte = $oCtbFonte->si96_vlsaldofinalfonte;
          $aSaldoCtb[$aHash] = $ctbFonte;
        }
      }

      //echo "<pre>"; print_r($aSaldoCtb);die;

      $oDaoContaCorrenteDetalhe = db_utils::getDao('contacorrentedetalhe');
      $oDaoVerificaDetalhe = db_utils::getDao('contacorrentedetalhe');

      $iReduzido = $oParam->iCodigoReduzido; // do array
      $iContaCorrente = $oParam->iContaCorrente; // sempre 103
      $iInstituicao = db_getsession("DB_instit");
      $iAnoUsu = db_getsession("DB_anousu");

      $iTipoReceita = $oParam->iTipoReceita;// si96_codfontrecursos
      $iConcarPeculiar = $oParam->iConcarPeculiar;//000
      $iContaBancaria = $oParam->iContaBancaria;//null
      $iEmpenho = $oParam->iEmpenho;//null
      $iNome = $oParam->iNome;//null
      $iOrgao = $oParam->iOrgao;//null
      $iUnidade = $oParam->iUnidade;//null
      $iAcordo = $oParam->iAcordo;//null

      $sWhereVerificacao =  "     c19_contacorrente       = {$iContaCorrente}    ";
      $sWhereVerificacao .= " and c19_orctiporec          = {$iTipoReceita}      ";
      $sWhereVerificacao .= " and c19_instit              = {$iInstituicao}      ";
      $sWhereVerificacao .= " and c19_reduz               = {$iReduzido}         ";
      $sWhereVerificacao .= " and c19_conplanoreduzanousu = {$iAnoUsu}           ";

      $sSqlVerificaDetalhe = $oDaoVerificaDetalhe->sql_query_file(null, "*", null, $sWhereVerificacao);
      $rsVerificacao = $oDaoVerificaDetalhe->sql_record($sSqlVerificaDetalhe);

      if ($oDaoVerificaDetalhe->numrows > 0) {
          $sDescricaoContaCorrenteErro = "103 - Fonte de Recurso";
      }

      $oDaoContaCorrenteDetalhe->c19_contacorrente = $iContaCorrente;
      $oDaoContaCorrenteDetalhe->c19_orctiporec = $iTipoReceita;
      $oDaoContaCorrenteDetalhe->c19_instit = $iInstituicao;
      $oDaoContaCorrenteDetalhe->c19_reduz = $iReduzido;
      $oDaoContaCorrenteDetalhe->c19_conplanoreduzanousu = $iAnoUsu;

      if ($oDaoVerificaDetalhe->numrows > 0) {
          $sqlerro = true;
          $sMsgErro = "Conta corrente [$sDescricaoContaCorrenteErro] com detalhamento selecionado já ";
          $sMsgErro .= "incluído no sistema.\n\nProcedimento abortado.";
          throw new BusinessException($sMsgErro);
      }

      $oDaoContaCorrenteDetalhe->incluir(null);
      if ($oDaoContaCorrenteDetalhe->erro_status == 0 || $oDaoContaCorrenteDetalhe->erro_status == '0') {
          $sqlerro = true;
          throw new DBException('ERRO - [ 1 ] - Incluindo Detalhe de Conta Corrente : ' . $oDaoContaCorrenteDetalhe->erro_msg);
      }

      $oRetorno->message = urlencode("Detalhe incluído com sucesso.");
      db_fim_transacao($sqlerro);

    } catch(Exception $eErro) {

      $oRetorno->status  = 2;
      $sGetMessage       = $eErro->getMessage();
      $oRetorno->message = $sGetMessage;

    }

    break;

}

if (isset($oRetorno->erro)) {
  $oRetorno->erro = utf8_encode($oRetorno->erro);
}

echo $oJson->encode($oRetorno);
