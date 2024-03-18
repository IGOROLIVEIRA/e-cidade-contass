<?PHP
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
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_usuariosonline.php");
require_once("classes/db_conlancamval_classe.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_conlancam_classe.php");
require_once("classes/db_conlancamcompl_classe.php");
require_once("classes/db_conlancaminstit_classe.php");
require_once("classes/db_conlancamordem_classe.php");
require_once("classes/db_conlancamdoc_classe.php");
require_once("classes/db_conplano_classe.php");
require_once("classes/db_contacorrentedetalhe_classe.php");
require_once("classes/db_conhist_classe.php");
require_once("classes/db_contacorrentedetalheconlancamval_classe.php");

db_postmemory($HTTP_POST_VARS);

$clconplano = new cl_conplano;
$clconlancamval = new cl_conlancamval;
$clconlancamcompl = new cl_conlancamcompl;
$clconlancaminstit = new cl_conlancaminstit;
$clconlancamordem = new cl_conlancamordem;
$clconlancamdoc = new cl_conlancamdoc;
$clconlancam = new cl_conlancam;
$clconhist = new cl_conhist;
$contacorrentedetalheconlancamval = new cl_contacorrentedetalheconlancamval;

$db_opcao = 1;
$db_botao = true;
$anousu = db_getsession('DB_anousu');

if (isset($HTTP_POST_VARS["db_opcao"]) && $HTTP_POST_VARS["db_opcao"] == "Incluir") {

  $erro = true;
  if ($conta_reduz == "" || $conta_reduz == "0") {
    echo "<script> alert('Conta não informada ! '); </script>";
  } else if ($c69_valor == "" || $c69_valor == "0") {
    echo "<script> alert('Valor não informado ! '); </script>";
  } else if ($c69_codhist == "" || $c69_codhist == "0") {
    echo "<script> alert('Histórico não informado !  '); </script>";
  } else if ($o15_codigo_debito == "" || $o15_codigo_credito == "") {
    echo "<script> alert('Fonte não informada !  '); </script>";
  } else {
    $erro = false;
    db_inicio_transacao();
    $clconlancam->c70_anousu = db_getsession('DB_anousu');
    $clconlancam->c70_data = "$c70_data_ano-$c70_data_mes-$c70_data_dia";
    $clconlancam->c70_valor = $c69_valor;
    $clconlancam->incluir("");
    if ($clconlancam->erro_status == "0") {
      db_msgbox("Não foi possível ajustar o lançamento. Procedimento abortado." . $clconlancam->erro_msg);
      $erro = true;
    } else {
      $codlan = $clconlancam->c70_codlan; //pega o codigo gerado
    }

    if ($c72_complem != "") {
      $clconlancamcompl->c72_complem = $c72_complem;
      $clconlancamcompl->incluir($codlan);
    }

    if (!$erro) {
      $clconlancaminstit->c02_instit = db_getsession("DB_instit");
      $clconlancaminstit->c02_codlan = $codlan;
      $clconlancaminstit->incluir(null);
      if ($clconlancaminstit->erro_status == "0") {
        db_msgbox("Não foi possível ajustar o lançamento. Procedimento abortado." . $clconlancaminstit->erro_msg);
        $erro = true;
      }
    }

    if (!$erro) {
      $clconlancamordem->c03_codlan = $codlan;
      $clconlancamordem->incluir(null);
      if ($clconlancamordem->erro_status == "0") {
        db_msgbox("Não foi possível ajustar o lançamento. Procedimento abortado." . $clconlancamordem->erro_msg);
        $erro = true;
      }
    }

    if (!$erro) {
      $clconlancamval->c69_anousu = $anousu;
      $clconlancamval->c69_codlan = $codlan;
      $clconlancamval->c69_codhist = $c69_codhist;
      $clconlancamval->c69_debito = $conta_reduz;
      $clconlancamval->c69_credito = $conta_reduz;
      $clconlancamval->c69_valor = $c69_valor;
      $clconlancamval->c69_data = "$c70_data_ano-$c70_data_mes-$c70_data_dia";
      $clconlancamval->incluir("");
      if ($clconlancamval->erro_status == "0") {
        db_msgbox("Não foi possível ajustar o lançamento. Procedimento abortado." . $clconlancamval->erro_msg);
        $erro = true;
      } else {
        $conlancamvalDebito = $clconlancamval->c69_sequen;
      }
    }

    if (!$erro) {
      $oDaoConLancamDoc = db_utils::getDao('conlancamdoc');
      $oDaoConLancamDoc->c71_codlan = $codlan;
      $oDaoConLancamDoc->c71_coddoc = $iDocumento;
      $oDaoConLancamDoc->c71_data   = "{$c70_data_ano}-{$c70_data_mes}-{$c70_data_dia}";
      $oDaoConLancamDoc->incluir($codlan);
      if ($oDaoConLancamDoc->erro_status == "0") {
        db_msgbox("Não foi possível vincular o documento ao lançamento. Procedimento abortado." . $oDaoConLancamDoc->erro_msg);
        $erro = true;
      }
    }

    if (!$erro) {

      $oDaoContaCorrenteDetalhe = db_utils::getDao('contacorrentedetalhe');
      $oDaoVerificaDetalhe = db_utils::getDao('contacorrentedetalhe');

      $iReduzido = $clconlancamval->c69_debito;
      $iContaCorrente = 103;
      $iInstituicao = db_getsession("DB_instit");
      $iAnoUsu = db_getsession("DB_anousu");

      $iTipoRec = $o15_codigo_debito;

      $rsDebito = $clconplano->sql_record($clconplano->sql_query_tudo(null, $campos = "c18_contacorrente", $ordem = null, $dbwhere = " c61_reduz={$iReduzido} and c61_anousu=" . db_getsession("DB_anousu")));
      db_fieldsmemory($rsDebito, 0);

      $sWhereVerificacao  = "     c19_contacorrente       = {$iContaCorrente}    ";
      $sWhereVerificacao .= " and c19_orctiporec          = {$iTipoRec}          ";
      $sWhereVerificacao .= " and c19_instit              = {$iInstituicao}      ";
      $sWhereVerificacao .= " and c19_reduz               = {$iReduzido}         ";
      $sWhereVerificacao .= " and c19_conplanoreduzanousu = {$iAnoUsu}           ";

      $sSqlVerificaDetalhe = $oDaoVerificaDetalhe->sql_query_file(null, "*", null, $sWhereVerificacao);

      $rsVerificacao = $oDaoVerificaDetalhe->sql_record($sSqlVerificaDetalhe);

      $oDaoContaCorrenteDetalhe->c19_contacorrente = $iContaCorrente;
      $oDaoContaCorrenteDetalhe->c19_orctiporec = $iTipoRec;
      $oDaoContaCorrenteDetalhe->c19_instit = $iInstituicao;
      $oDaoContaCorrenteDetalhe->c19_reduz = $iReduzido;
      $oDaoContaCorrenteDetalhe->c19_conplanoreduzanousu = $iAnoUsu;

      if ($oDaoVerificaDetalhe->numrows == 0) {
        $oDaoContaCorrenteDetalhe->incluir(null);
        if ($oDaoContaCorrenteDetalhe->erro_status == 0 || $oDaoContaCorrenteDetalhe->erro_status == '0') {
          db_msgbox("Não foi possível vincular o documento ao lançamento. Procedimento abortado." . $oDaoContaCorrenteDetalhe->erro_msg);
          $erro = true;
        }
      } else {
        $seqContaCorrenteDetalhe = db_utils::fieldsMemory($rsVerificacao, 0)->c19_sequencial;
      }

      $contacorrentedetalheconlancamval->c28_conlancamval = $conlancamvalDebito;
      $contacorrentedetalheconlancamval->c28_contacorrentedetalhe = $oDaoContaCorrenteDetalhe->c19_sequencial != '' ? $oDaoContaCorrenteDetalhe->c19_sequencial : $seqContaCorrenteDetalhe;
      $contacorrentedetalheconlancamval->c28_tipo = 'D';
      if ($c18_contacorrente == 103)
        $contacorrentedetalheconlancamval->incluir(null);
      if ($contacorrentedetalheconlancamval->erro_status == "0") {
        db_msgbox("Não foi possível incluir detalhe da conta débito. Procedimento abortado." . $contacorrentedetalheconlancamval->erro_msg);
        $erro = true;
      }

      $oDaoContaCorrenteDetalhe = db_utils::getDao('contacorrentedetalhe');
      $oDaoVerificaDetalhe = db_utils::getDao('contacorrentedetalhe');

      $iReduzido = $clconlancamval->c69_credito;
      $iContaCorrente = 103;
      $iInstituicao = db_getsession("DB_instit");
      $iAnoUsu = db_getsession("DB_anousu");

      $iTipoRec = $o15_codigo_credito;

      $rsCredito = $clconplano->sql_record($clconplano->sql_query_tudo(null, $campos = "c18_contacorrente", $ordem = null, $dbwhere = " c61_reduz={$iReduzido} and c61_anousu=" . db_getsession("DB_anousu")));
      db_fieldsmemory($rsCredito, 0);

      $sWhereVerificacao  = "     c19_contacorrente       = {$iContaCorrente}    ";
      $sWhereVerificacao .= " and c19_orctiporec          = {$iTipoRec}          ";
      $sWhereVerificacao .= " and c19_instit              = {$iInstituicao}      ";
      $sWhereVerificacao .= " and c19_reduz               = {$iReduzido}         ";
      $sWhereVerificacao .= " and c19_conplanoreduzanousu = {$iAnoUsu}           ";

      $sSqlVerificaDetalhe = $oDaoVerificaDetalhe->sql_query_file(null, "*", null, $sWhereVerificacao);
      $rsVerificacao = $oDaoVerificaDetalhe->sql_record($sSqlVerificaDetalhe);

      $oDaoContaCorrenteDetalhe->c19_contacorrente = $iContaCorrente;
      $oDaoContaCorrenteDetalhe->c19_orctiporec = $iTipoRec;
      $oDaoContaCorrenteDetalhe->c19_instit = $iInstituicao;
      $oDaoContaCorrenteDetalhe->c19_reduz = $iReduzido;
      $oDaoContaCorrenteDetalhe->c19_conplanoreduzanousu = $iAnoUsu;

      if ($oDaoVerificaDetalhe->numrows == 0) {
        $oDaoContaCorrenteDetalhe->incluir(null);
        if ($oDaoContaCorrenteDetalhe->erro_status == 0 || $oDaoContaCorrenteDetalhe->erro_status == '0') {
          db_msgbox("Não foi possível vincular o documento ao lançamento. Procedimento abortado." . $oDaoContaCorrenteDetalhe->erro_msg);
          $erro = true;
        }
      } else {
        $seqContaCorrenteDetalhe = db_utils::fieldsMemory($rsVerificacao, 0)->c19_sequencial;
      }
      $contacorrentedetalheconlancamval->c28_conlancamval = $conlancamvalDebito;
      $contacorrentedetalheconlancamval->c28_contacorrentedetalhe = $oDaoContaCorrenteDetalhe->c19_sequencial != '' ? $oDaoContaCorrenteDetalhe->c19_sequencial : $seqContaCorrenteDetalhe;
      $contacorrentedetalheconlancamval->c28_tipo = 'C';
      if ($c18_contacorrente == 103)
        $contacorrentedetalheconlancamval->incluir(null);
      if ($contacorrentedetalheconlancamval->erro_status == "0") {
        db_msgbox("Não foi possível incluir detalhe da conta crédito. Procedimento abortado." . $contacorrentedetalheconlancamval->erro_msg);
        $erro = true;
      }
    }

    db_fim_transacao($erro);
  }
} else {
  $result = $clconhist->sql_record($clconhist->sql_query(3980, 'c50_descr'));
  if ($clconhist->numrows != 0) {
    $c72_complem = db_utils::fieldsMemory($result, 0)->c50_descr;
  }
}
?>
<html>

<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
  <link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">

  <center>
    <?php
    require_once("forms/db_frmajustafonterecurso.php");
    ?>
  </center>
  <?php
  db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
  ?>
</body>

</html>
<?php
if ((isset($HTTP_POST_VARS["db_opcao"]) && $HTTP_POST_VARS["db_opcao"])
  == "Incluir"
) {
  if ($clconlancamval->erro_status == "0") {
    $clconlancamval->erro(true, false);
    $db_botao = true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if ($clconlancamval->erro_campo != "") {
      echo "<script> document.form1." . $clconlancamval->erro_campo
        . ".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1." . $clconlancamval->erro_campo
        . ".focus();</script>";
    };
  } else {
    $clconlancamval->erro(true, true);
  };
}
?>