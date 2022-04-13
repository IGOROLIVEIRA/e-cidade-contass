<?php

/**
* Este programa ira salvar CONCORRENTEDETALHE (caso não exista), CONTACORRENTESALDO, CONEXTSALDO, CONCTBSALDO.
* as informações iram vir da tabela CTB20(ANOUSU) E EXT20(ANOUSU).
*/

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
require_once("classes/db_conextsaldo_classe.php");
require_once("classes/db_conctbsaldo_classe.php");
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
$oRetorno->message = '';
$sqlerro = false;

try {
    switch ($oParam->exec) {

      case 'importarSaldoContaCorrente':

		$iAnoUsu       = $oParam->ano;
        $iAnoUsuOrigin = $iAnoUsu - 1;
        $iInstituicao = db_getsession("DB_instit");
        $aContas = array('1', '2', '5', '6', '7', '8');
        $dataInicio = $iAnoUsuOrigin."-01-01";
        $dataFim = $iAnoUsuOrigin."-12-31";

        $sSqlContaCorrenteSaldo = " select   c19_sequencial,
                                              c19_contacorrente,
                                              c19_orctiporec,
                                              c19_instit,
                                              c19_concarpeculiar,
                                              c19_contabancaria,
                                              c19_reduz,
                                              c19_numemp,
                                              c19_numcgm,
                                              c19_orcunidadeanousu,
                                              c19_orcunidadeorgao,
                                              c19_orcunidadeunidade,
                                              c19_orcorgaoanousu,
                                              c19_orcorgaoorgao,
                                              c19_conplanoreduzanousu,
                                              c19_acordo,
                                              c19_estrutural,
                                              c19_orcdotacao,
                                              c19_orcdotacaoanousu,
                                              c19_programa,
                                              c19_projativ,
                                              c19_emparlamentar, round(substr(fc_saldocontacorrente,161,15)::float8,2)::float8 AS saldofinal,
                                              substr(fc_saldocontacorrente,181,1)::varchar(1) AS sinalsaldofinal
                                              from
                                (select c19_sequencial,
                                    c19_contacorrente,
                                    c19_orctiporec,
                                    c19_instit,
                                    c19_concarpeculiar,
                                    c19_contabancaria,
                                    c19_reduz,
                                    c19_numemp,
                                    c19_numcgm,
                                    c19_orcunidadeanousu,
                                    c19_orcunidadeorgao,
                                    c19_orcunidadeunidade,
                                    c19_orcorgaoanousu,
                                    c19_orcorgaoorgao,
                                    c19_conplanoreduzanousu,
                                    c19_acordo,
                                    c19_estrutural,
                                    c19_orcdotacao,
                                    c19_orcdotacaoanousu,
                                    c19_programa,
                                    c19_projativ,
                                    c19_emparlamentar,
                                    fc_saldocontacorrente({$iAnoUsuOrigin},c19_sequencial, c19_contacorrente, 12, {$iInstituicao})
                                from conplanoexe e
                                    INNER JOIN conplanoreduz r ON (r.c61_anousu, r.c61_reduz) = (c62_anousu, c62_reduz)
                                    INNER JOIN conplano on c60_anousu=c61_anousu and c60_codcon=c61_codcon
                                    LEFT JOIN contacorrentedetalhe ON (c19_conplanoreduzanousu, c19_reduz) = ({$iAnoUsuOrigin}, c61_reduz)
                                where c19_instit = {$iInstituicao}
                                      and c62_anousu = {$iAnoUsu}
                                      and (c62_vlrcre != 0 or c62_vlrdeb  != 0 )
                                      and substr(c60_estrut, 1, 1)::int8 in (".implode(",", $aContas).")
                                      and c60_codsis not in (5,6,7) ) as movimento";

		$rsContaCorrenteSaldo = db_query($sSqlContaCorrenteSaldo);

        if (pg_num_rows($rsContaCorrenteSaldo) < 1) {
            throw new DBException(urlencode('ERRO - [ 2 ] - Nenhum registro encontrado com saldo!'));
        }

		db_inicio_transacao();

		$sLogContasNaoImplantadas = '';

        for ($iCont = 0;$iCont < pg_num_rows($rsContaCorrenteSaldo); $iCont++) {

            $oConta = db_utils::fieldsMemory($rsContaCorrenteSaldo, $iCont);

            $nSaldoInicial = $oConta->sinalsaldofinal == 'C' ? $oConta->saldofinal * -1 : $oConta->saldofinal;

            $oDaoContaCorrenteDetalhe 	                       = db_utils::getDao('contacorrentedetalhe');
            $oDaoContaCorrenteDetalhe->c19_contacorrente       = $oConta->c19_contacorrente;
            $oDaoContaCorrenteDetalhe->c19_orctiporec          = $oConta->c19_orctiporec;
            $oDaoContaCorrenteDetalhe->c19_instit              = $oConta->c19_instit;
            $oDaoContaCorrenteDetalhe->c19_concarpeculiar      = $oConta->c19_concarpeculiar;
            $oDaoContaCorrenteDetalhe->c19_contabancaria       = $oConta->c19_contabancaria;
            $oDaoContaCorrenteDetalhe->c19_reduz               = $oConta->c19_reduz;
            $oDaoContaCorrenteDetalhe->c19_numemp              = $oConta->c19_numemp;
            $oDaoContaCorrenteDetalhe->c19_numcgm              = $oConta->c19_numcgm;
            $oDaoContaCorrenteDetalhe->c19_orcunidadeanousu    = $oConta->c19_orcunidadeanousu;
            $oDaoContaCorrenteDetalhe->c19_orcunidadeorgao     = $oConta->c19_orcunidadeorgao;
            $oDaoContaCorrenteDetalhe->c19_orcunidadeunidade   = $oConta->c19_orcunidadeunidade;
            $oDaoContaCorrenteDetalhe->c19_orcorgaoanousu      = $oConta->c19_orcorgaoanousu;
            $oDaoContaCorrenteDetalhe->c19_orcorgaoorgao       = $oConta->c19_orcorgaoorgao;
            $oDaoContaCorrenteDetalhe->c19_conplanoreduzanousu = $iAnoUsu;
            $oDaoContaCorrenteDetalhe->c19_acordo              = $oConta->c19_acordo;
            $oDaoContaCorrenteDetalhe->c19_estrutural          = $oConta->c19_estrutural;
            $oDaoContaCorrenteDetalhe->c19_orcdotacao          = $oConta->c19_orcdotacao;
            $oDaoContaCorrenteDetalhe->c19_orcdotacaoanousu    = $oConta->c19_orcdotacaoanousu;
            $oDaoContaCorrenteDetalhe->c19_programa            = $oConta->c19_programa;
            $oDaoContaCorrenteDetalhe->c19_projativ            = $oConta->c19_projativ;
            $oDaoContaCorrenteDetalhe->c19_emparlamentar       = $oConta->c19_emparlamentar;

            $oDaoVerificaDetalhe 		= db_utils::getDao('contacorrentedetalhe');

            $sWhereVerificacao  = "     c19_contacorrente       = {$oConta->c19_contacorrente} ";
            $sWhereVerificacao .= " and c19_instit              = {$oConta->c19_instit} ";
            $sWhereVerificacao .= " and c19_reduz               = {$oConta->c19_reduz} ";
            $sWhereVerificacao .= " and c19_conplanoreduzanousu = {$iAnoUsu} ";
            if($oConta->c19_orctiporec){
                $sWhereVerificacao .= " and c19_orctiporec          = {$oConta->c19_orctiporec} ";
            }
            if($oConta->c19_concarpeculiar){
                $sWhereVerificacao .= " and c19_concarpeculiar      = {$oConta->c19_concarpeculiar} ";
            }
            if($oConta->c19_contabancaria){
                $sWhereVerificacao .= " and c19_contabancaria       = {$oConta->c19_contabancaria} ";
            }
            if($oConta->c19_numemp){
                $sWhereVerificacao .= " and c19_numemp              = {$oConta->c19_numemp} ";
            }
            if($oConta->c19_numcgm){
                $sWhereVerificacao .= " and c19_numcgm              = {$oConta->c19_numcgm} ";
            }
            if($oConta->c19_orcunidadeanousu){
                $sWhereVerificacao .= " and c19_orcunidadeanousu    = {$oConta->c19_orcunidadeanousu} ";
            }
            if($oConta->c19_orcunidadeorgao){
                $sWhereVerificacao .= " and c19_orcunidadeorgao     = {$oConta->c19_orcunidadeorgao} ";
            }
            if($oConta->c19_orcunidadeunidade){
                $sWhereVerificacao .= " and c19_orcunidadeunidade   = {$oConta->c19_orcunidadeunidade} ";
            }
            if($oConta->c19_orcorgaoanousu){
                $sWhereVerificacao .= " and c19_orcorgaoanousu      = {$oConta->c19_orcorgaoanousu} ";
            }
            if($oConta->c19_orcorgaoorgao){
                $sWhereVerificacao .= " and c19_orcorgaoorgao       = {$oConta->c19_orcorgaoorgao} ";
            }
            if($oConta->c19_acordo){
                $sWhereVerificacao .= " and c19_acordo              = {$oConta->c19_acordo} ";
            }
            if($oConta->c19_estrutural){
                $sWhereVerificacao .= " and c19_estrutural          = '{$oConta->c19_estrutural}' ";
            }
            if($oConta->c19_orcdotacao){
                $sWhereVerificacao .= " and c19_orcdotacao          = {$oConta->c19_orcdotacao} ";
            }
            if($oConta->c19_orcdotacaoanousu){
                $sWhereVerificacao .= " and c19_orcdotacaoanousu    = {$oConta->c19_orcdotacaoanousu} ";
            }
            if($oConta->c19_programa != "null"){
                $sWhereVerificacao .= " and c19_programa            = {$oConta->c19_programa} ";
            }
            if($oConta->c19_projativ != "null"){
                $sWhereVerificacao .= " and c19_projativ            = {$oConta->c19_projativ} ";
            }
            if($oConta->c19_emparlamentar){
                $sWhereVerificacao .= " and c19_emparlamentar       = {$oConta->c19_emparlamentar} ";
            }

            $sSqlVerificaDetalhe 	= $oDaoVerificaDetalhe->sql_query_file(null, "*", null, $sWhereVerificacao);
            $rsVerificacao 			= $oDaoVerificaDetalhe->sql_record($sSqlVerificaDetalhe);

            if ($oDaoVerificaDetalhe->numrows == 0) {

                if ($nSaldoInicial == 0) {
                    continue;
                }

                $oDaoContaCorrenteDetalhe->incluir(null);
                if ($oDaoContaCorrenteDetalhe->erro_status == 0 || $oDaoContaCorrenteDetalhe->erro_status == '0') {
                    $sqlerro = true;
                    throw new DBException(urlencode('ERRO - [ 3 ] - Erro ao incluir no Conta Corrente Detalhe!: '
                        . $oDaoContaCorrenteDetalhe->erro_msg));
                }

                salvarSaldo($oDaoContaCorrenteDetalhe, $nSaldoInicial);
                continue;
            }

            if ($oDaoVerificaDetalhe->numrows > 0) {
                $oContaCorrente = db_utils::fieldsMemory($rsVerificacao, 0);
            }

            salvarSaldo($oContaCorrente, $nSaldoInicial);

            $oRetorno->message = urlencode("Implantação no conta corrente detalhe realizada com sucesso.");

        }

        $oRetorno->sArquivoLog = '';

        if (!empty($sLogContasNaoImplantadas)) {

            $sArquivoLog = 'tmp/implantacao_saldo_conta_corrente_' . date('Y-m-d_H:i:s') . '.log';
            file_put_contents($sArquivoLog, $sLogContasNaoImplantadas);
            $oRetorno->sArquivoLog = $sArquivoLog;

        }

        db_fim_transacao($sqlerro);

		break;

    }

  } catch(Exception $eErro) {

      $oRetorno->status  = 2;
      $sGetMessage       = $eErro->getMessage();
      $oRetorno->message = $sGetMessage;

  }

function salvarSaldo($saldo, $valorSaldo){

     $sColunaImplantar = "c29_credito";
     $sColunaZerar = "c29_debito";

     $iAnoUsu = db_getsession("DB_anousu");

      /**
       * Remove os registros existentes na contacorrentesaldo para o ano atual e mes 0 do contacorrentedetalhe em questao
       */
      $oDaoContaCorrenteSaldo = new cl_contacorrentesaldo();
      $sWhereExcluir = "c29_anousu = {$iAnoUsu} and c29_mesusu = 0 and c29_contacorrentedetalhe = {$saldo->c19_sequencial}";
      $oDaoContaCorrenteSaldo->excluir(null, $sWhereExcluir);

      if ($oDaoContaCorrenteSaldo->erro_status == "0") {
          throw new DBException(urlencode("ERRO [ 22 ] - Excluindo Registros - " . $oDaoContaCorrenteSaldo->erro_msg ."<br>"));
      }

      if ($valorSaldo <> 0) {

          if ($valorSaldo < 0) {

              $sColunaImplantar = "c29_credito";
              $sColunaZerar = "c29_debito";

          } else {
              $sColunaImplantar = "c29_debito";
              $sColunaZerar = "c29_credito";
          }


          /*
           * modificação para reajustar valores, basicamente devemos verificar se
           * ja foi feita implantação na contacorrentesaldo pelo detalhe em questão
           * se retornar registro, para o detalhe, ano e mes = 0, significa que devemos altera-lo
           * se não retornar significa que é a primeira vez que está sendo implantado e logo devemos incluir registro na
           * contacorrentesaldo
           */
          $sWhereImplantacao = "     c29_contacorrentedetalhe = {$saldo->c19_sequencial} ";
          $sWhereImplantacao .= " and c29_anousu = {$iAnoUsu} ";
          $sWhereImplantacao .= " and c29_mesusu = 0 ";
          $sSqlImplantcao = $oDaoContaCorrenteSaldo->sql_query_file(null, "*", null, $sWhereImplantacao);
          $rsImplantacao = $oDaoContaCorrenteSaldo->sql_record($sSqlImplantcao);

          $oDaoContaCorrenteSaldo->c29_contacorrentedetalhe = $saldo->c19_sequencial;
          $oDaoContaCorrenteSaldo->c29_anousu = $iAnoUsu;
          $oDaoContaCorrenteSaldo->c29_mesusu = '0';
          $oDaoContaCorrenteSaldo->$sColunaImplantar = abs($valorSaldo);
          $oDaoContaCorrenteSaldo->$sColunaZerar = '0';

          // se retornou registros devemos alterar
          if ($oDaoContaCorrenteSaldo->numrows > 0) {

              $oValoresInplantados = db_utils::fieldsMemory($rsImplantacao, 0);
              $oDaoContaCorrenteSaldo->c29_sequencial = $oValoresInplantados->c29_sequencial;
              $oDaoContaCorrenteSaldo->alterar($oDaoContaCorrenteSaldo->c29_sequencial);

          } else { // senao, incluimos

              $oDaoContaCorrenteSaldo->incluir(null);

          }

          if ($oDaoContaCorrenteSaldo->erro_status == "0") {
              throw new DBException(urlencode("ERRO [ 2 ] - Atualizando Registros - " . $oDaoContaCorrenteSaldo->erro_msg));
          }
      }

}

if (isset($oRetorno->erro)) {
  $oRetorno->erro = utf8_encode($oRetorno->erro);
}

echo $oJson->encode($oRetorno);
