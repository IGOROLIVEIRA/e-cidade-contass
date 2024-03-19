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
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("classes/db_conlancamval_classe.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_conlancam_classe.php");
require_once("classes/db_conlancamcompl_classe.php");
require_once("classes/db_conlancamdig_classe.php");
require_once("classes/db_conlancamdoc_classe.php");
require_once("classes/db_conplano_classe.php");
require_once("classes/db_contacorrentedetalhe_classe.php");
require_once("classes/db_contacorrentedetalheconlancamval_classe.php");

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$clconplano     = new cl_conplano;
$clconlancamval = new cl_conlancamval;
$clconlancamcompl = new cl_conlancamcompl;
$clconlancamdig   = new cl_conlancamdig;
$clconlancam      = new cl_conlancam;
$clconlancamdoc   = new cl_conlancamdoc;
$clcontacorrenteconlancamval = new cl_contacorrentedetalheconlancamval;

$anousu = db_getsession("DB_anousu");
$db_opcao = 22;
$db_botao = false;
if (isset($HTTP_POST_VARS["db_opcao"]) && $HTTP_POST_VARS["db_opcao"] == "Alterar") {

  $erro = false;
  $dataLancamento = "$c70_data_ano-$c70_data_mes-$c70_data_dia";
  $alt = false;
  if (strlen($dataLancamento) < 9) {
    db_msgbox('Data inválida !');
  }
  if ($conta_reduz == "") {
    db_msgbox('Conta não informada ! ');
  } else if ($c69_valor == "" || $c69_valor == "0") {
    db_msgbox('Valor não informado ! ');
  } else if ($c69_codhist == "" || $c69_codhist == "0") {
    db_msgbox('Histórico não informado !  ');
  } else {
    $alt = true;
  }

  $sSqlConsultaFimPeriodoContabil   = "SELECT * FROM condataconf WHERE c99_anousu = " . db_getsession('DB_anousu') . " and c99_instit = " . db_getsession('DB_instit');
  $rsConsultaFimPeriodoContabil     = db_query($sSqlConsultaFimPeriodoContabil);

  if (pg_num_rows($rsConsultaFimPeriodoContabil) > 0) {
    $oFimPeriodoContabil = db_utils::fieldsMemory($rsConsultaFimPeriodoContabil, 0);

    if ($oFimPeriodoContabil->c99_data != '' && db_strtotime($dataLancamento) <= db_strtotime($oFimPeriodoContabil->c99_data)) {
      $alt = false;
      db_msgbox("Data inferior à data do fim do período contábil.");
    }
  }

  if ($alt == true) {

    db_inicio_transacao();
    if ($c72_complem != "") {
      $r = $clconlancamcompl->sql_record($clconlancamcompl->sql_query_file($c70_codlan));
      if ($clconlancamcompl->numrows > 0) {
        $clconlancamcompl->c72_complem = $c72_complem;
        $clconlancamcompl->c72_codlan = $c70_codlan;
        $clconlancamcompl->alterar($c70_codlan);
      } else {
        $clconlancamcompl->c72_complem = $c72_complem;
        $clconlancamcompl->incluir($c70_codlan);
      }
    }
    $db_opcao = 2;
    $clconlancam->c70_valor = $c69_valor;
    $clconlancam->c70_anousu = $c70_data_ano;
    $clconlancam->c70_data  = "$c70_data_ano-$c70_data_mes-$c70_data_dia";
    $clconlancam->alterar($c70_codlan);
    
    if ($o15_codigo_debito != "") {

      //Ver se contacorrentedelhe existe para conta debito
      $oDaoContaCorrenteDetalhe = db_utils::getDao('contacorrentedetalhe');
      $oDaoVerificaDetalhe = db_utils::getDao('contacorrentedetalhe');

      $iReduzido = $conta_reduz;
      $iContaCorrente = 103;
      $iInstituicao = db_getsession("DB_instit");
      $iAnoUsu = db_getsession("DB_anousu");

      $iTipoRec = $o15_codigo_debito;

      $sWhereVerificacao  = " c19_contacorrente = {$iContaCorrente}";
      $sWhereVerificacao .= " and c19_instit = {$iInstituicao}";
      $sWhereVerificacao .= " and c19_reduz = {$iReduzido}";
      $sWhereVerificacao .= " and c19_conplanoreduzanousu = {$iAnoUsu}";
      $sWhereVerificacao .= " and c19_orctiporec          = {$iTipoRec}";

      $rsVerificacao = $oDaoVerificaDetalhe->sql_record($oDaoVerificaDetalhe->sql_query_file(null, "c19_sequencial", null, $sWhereVerificacao));
      $oDaoContaCorrenteDetalhe->c19_contacorrente = $iContaCorrente;
      $oDaoContaCorrenteDetalhe->c19_orctiporec = $iTipoRec;
      $oDaoContaCorrenteDetalhe->c19_instit = $iInstituicao;
      $oDaoContaCorrenteDetalhe->c19_reduz = $iReduzido;
      $oDaoContaCorrenteDetalhe->c19_conplanoreduzanousu = $iAnoUsu;

      if ($oDaoVerificaDetalhe->numrows == 0) {
        $oDaoContaCorrenteDetalhe->incluir(null);
        if ($oDaoContaCorrenteDetalhe->erro_status == 0 || $oDaoContaCorrenteDetalhe->erro_status == '0') {
          db_msgbox("Não foi possível alterar o lançamento. Procedimento abortado." . $oDaoContaCorrenteDetalhe->erro_msg);
          $erro = true;
        }
      }
      $seqContaCorrenteDetalheDebito = $oDaoContaCorrenteDetalhe->c19_sequencial != '' ? $oDaoContaCorrenteDetalhe->c19_sequencial : db_utils::fieldsMemory($rsVerificacao, 0)->c19_sequencial;
    }

    if ($o15_codigo_credito != "") {

      //Ver se contacorrentedelhe existe para conta debito
      $oDaoContaCorrenteDetalhe = db_utils::getDao('contacorrentedetalhe');
      $oDaoVerificaDetalhe = db_utils::getDao('contacorrentedetalhe');

      $iReduzido = $conta_reduz;
      $iContaCorrente = 103;
      $iInstituicao = db_getsession("DB_instit");
      $iAnoUsu = db_getsession("DB_anousu");

      $iTipoRec = $o15_codigo_credito;

      $sWhereVerificacao  = "     c19_contacorrente       = {$iContaCorrente} ";
      $sWhereVerificacao .= " and c19_instit              = {$iInstituicao}   ";
      $sWhereVerificacao .= " and c19_reduz               = {$iReduzido}      ";
      $sWhereVerificacao .= " and c19_conplanoreduzanousu = {$iAnoUsu}        ";
      $sWhereVerificacao .= " and c19_orctiporec          = {$iTipoRec}        ";

      $rsVerificacao = $oDaoVerificaDetalhe->sql_record($oDaoVerificaDetalhe->sql_query_file(null, "c19_sequencial", null, $sWhereVerificacao));

      $oDaoContaCorrenteDetalhe->c19_contacorrente = $iContaCorrente;
      $oDaoContaCorrenteDetalhe->c19_orctiporec = $iTipoRec;
      $oDaoContaCorrenteDetalhe->c19_instit = $iInstituicao;
      $oDaoContaCorrenteDetalhe->c19_reduz = $iReduzido;
      $oDaoContaCorrenteDetalhe->c19_conplanoreduzanousu = $iAnoUsu;

      if ($oDaoVerificaDetalhe->numrows == 0) {
        $oDaoContaCorrenteDetalhe->incluir(null);
        if ($oDaoContaCorrenteDetalhe->erro_status == 0 || $oDaoContaCorrenteDetalhe->erro_status == '0') {
          db_msgbox("Não foi possível alterar o lançamento. Procedimento abortado." . $oDaoContaCorrenteDetalhe->erro_msg);
          $erro = true;
        }
      }
      $seqContaCorrenteDetalheCredito = $oDaoContaCorrenteDetalhe->c19_sequencial != '' ? $oDaoContaCorrenteDetalhe->c19_sequencial : db_utils::fieldsMemory($rsVerificacao, 0)->c19_sequencial;
    }

    // exlcui do conlancamval e inclui novamente
    // devido a trigers do conplanoexe
    $clcontacorrenteconlancamval->excluir(null, " c28_conlancamval = {$c69_sequen}");
    $clconlancamval->excluir($c69_sequen);
    if ($clconlancamval->erro_status == "0") {
      $erro = true;
      $erro_msg = "$clconlancamval->erro_msg";
    }
    // inclui
    if ($erro == false) {
      if ($c71_coddoc == "0") {
        $clconlancamdoc->excluir($c70_codlan);
      } else {
        $resdoc = $clconlancamdoc->sql_record($clconlancamdoc->sql_query($c70_codlan));
        if ($clconlancamdoc->numrows > 0) {
          $clconlancamdoc->c71_codlan = $c70_codlan;
          $clconlancamdoc->c71_coddoc = $iDocumento;
          $clconlancamdoc->c71_data   = "$c70_data_ano-$c70_data_mes-$c70_data_dia";
          $clconlancamdoc->alterar($c70_codlan);
        } else {
          $clconlancamdoc->c71_codlan = $c70_codlan;
          $clconlancamdoc->c71_coddoc = $iDocumento;
          $clconlancamdoc->c71_data   = "$c70_data_ano-$c70_data_mes-$c70_data_dia";
          $clconlancamdoc->incluir($c70_codlan);
        }
      }
    }

    if ($erro == false) {
      $clconlancamval->c69_anousu  = $c70_data_ano;
      $clconlancamval->c69_codlan  = $c70_codlan;
      $clconlancamval->c69_codhist = $c69_codhist;
      $clconlancamval->c69_debito  = $conta_reduz;
      $clconlancamval->c69_credito = $conta_reduz;
      $clconlancamval->c69_valor   = $c69_valor;
      $clconlancamval->c69_data    = $clconlancam->c70_data;
      $clconlancamval->c69_sequen  = "0";
      $clconlancamval->incluir($c69_sequen);

      $clcontacorrenteconlancamval->c28_conlancamval = $c69_sequen;
      $clcontacorrenteconlancamval->c28_contacorrentedetalhe = $seqContaCorrenteDetalheDebito;
      $clcontacorrenteconlancamval->c28_tipo = 'D';
      $clcontacorrenteconlancamval->incluir(null);
      if ($clcontacorrenteconlancamval->erro_status == "0") {
        db_msgbox("Não foi possível incluir detalhe da conta debito. Procedimento abortado." . $clcontacorrenteconlancamval->erro_msg);
        $erro = true;
      }

      $clcontacorrenteconlancamval->c28_contacorrentedetalhe = $seqContaCorrenteDetalheCredito;
      $clcontacorrenteconlancamval->c28_tipo = 'C';
      $clcontacorrenteconlancamval->incluir(null);
      if ($clcontacorrenteconlancamval->erro_status == "0") {
        db_msgbox("Não foi possível incluir detalhe da conta credito. Procedimento abortado." . $clcontacorrenteconlancamval->erro_msg);
        $erro = true;
      }
    }
    db_fim_transacao($erro);
  }
} else if (isset($chavepesquisa)) {
  $db_opcao = 2;
  if (isset($sequen)) {
    $result = $clconlancamval->sql_record($clconlancamval->sql_query("", "*", "", "c69_codlan=$chavepesquisa and c69_sequen=$sequen"));
  } else {
    $result = $clconlancamval->sql_record($clconlancamval->sql_query($chavepesquisa));
  }
  db_fieldsmemory($result, 0);
  $db_botao = true;

  $result = $clconlancamdoc->sql_record($clconlancamdoc->sql_query($c69_codlan, '*'));
  if ($clconlancamdoc->numrows != 0) {
    db_fieldsmemory($result, 0);
  }

  $result = $clconlancamcompl->sql_record($clconlancamcompl->sql_query($c69_codlan, '*'));
  if ($clconlancamcompl->numrows != 0) {
    db_fieldsmemory($result, 0);
  }

  $result = $clcontacorrenteconlancamval->sql_record($clcontacorrenteconlancamval->sql_query(null, 'o15_codigo, o15_descr', null, " c28_conlancamval= {$c69_sequen} and c28_tipo = 'D'"));
  if ($clcontacorrenteconlancamval->numrows != 0) {
    $o15_codigo_debito = db_utils::fieldsMemory($result, 0)->o15_codigo;
    $o15_descr_debito = db_utils::fieldsMemory($result, 0)->o15_descr;
  }

  $result = $clcontacorrenteconlancamval->sql_record($clcontacorrenteconlancamval->sql_query(null, 'o15_codigo, o15_descr', null, " c28_conlancamval= {$c69_sequen} and c28_tipo = 'C'"));
  if ($clcontacorrenteconlancamval->numrows != 0) {
    $o15_codigo_credito = db_utils::fieldsMemory($result, 0)->o15_codigo;
    $o15_descr_credito = db_utils::fieldsMemory($result, 0)->o15_descr;
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
    <?PHP
    require_once("forms/db_frmajustafonterecurso.php");
    ?>
  </center>
  <?PHP
  db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
  ?>
</body>

</html>
<?PHP
if ((isset($HTTP_POST_VARS["db_opcao"]) && $HTTP_POST_VARS["db_opcao"]) == "Alterar") {
  if ($erro == true) {
    db_msgbox($erro_msg);

    $db_botao = true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if ($clconlancamval->erro_campo != "") {
      echo "<script> document.form1." . $clconlancamval->erro_campo . ".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1." . $clconlancamval->erro_campo . ".focus();</script>";
    };
  } else {
    $clconlancamval->erro(true, true);
  };
};
if ($db_opcao == 22) {
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>