<?php
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2012  DBselller Servicos de Informatica             
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
require_once("libs/db_app.utils.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("dbforms/db_classesgenericas.php");

$oGet       = db_utils::postMemory($_GET);
$iAnoSessao = db_getsession("DB_anousu");

$sLegend = "Processar Abertura do Exercício";
if (isset($oGet->lDesprocessar) && $oGet->lDesprocessar == "true") {
	$sLegend = "Desprocessar Abertura do Exercício";
}

?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <?php
    db_app::load("scripts.js");
    db_app::load("strings.js, prototype.js, estilos.css, ");
  ?>
  <script language="JavaScript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/widgets/windowAux.widget.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/datagrid.widget.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbmessageBoard.widget.js"></script>
</head>
<body bgcolor="#CCCCCC" style="margin-top:30px;">
  <center>
    <form name='form1'>
      <fieldset style="width: 550px">
        <legend><b><?php echo $sLegend;?></b></legend>
        <table width="100%">
          <tr>
            <td nowrap="nowrap"><b>Ano:</b></td>
            <td nowrap="nowrap">
              <?php
                db_input("iAnoSessao", 10, null, true, 'text', 3);
              ?>
            </td>
          </tr>
          <tr>
          	<td nowrap="nowrap">
          		<b>Valor Receita:</b>
          	</td>
          	<td nowrap="nowrap">
          		<?php 
          		  db_input("nValorReceita", 10, null, true, "text", 3);
          		?>
          	</td>
          </tr>
          <tr>
          	<td nowrap="nowrap">
          		<b>Valor Despesa:</b>
          	</td>
          	<td nowrap="nowrap">
          		<?php 
          		  db_input("nValorDespesa", 10, null, true, "text", 3);
          		?>
          	</td>
          </tr>
          <?php if (!isset($oGet->lDesprocessar)) { ?>
          <tr>
          	<td nowrap="nowrap">
          		<b>Regras:</b>
          	</td>
          	<td nowrap="nowrap">
              <input name="regras_natureza" type="button" id="regras_natureza" value="Regras"/>
          	</td>
          </tr>
          <?php } ?>
          <tr>
            <td nowrap="nowrap" colspan="2">
              <fieldset>
                <legend><b>Observações</b></legend>
                <textarea name="sObservacao" id="sObservacao" style="width:100%; height: 100px" ></textarea>
              </fieldset>
            </td>
          </tr>
        </table>
      </fieldset>
      <input type="button" name="btnProcessar" id="btnProcessar" value="Processar" disabled="disabled"/>
      <div id="contentRegras">
        <table style="width: 650px; margin: 0 auto;">
          <tr>
            <td>
              <fieldset>
                <legend>Regras de Abertura de Exercício</legend>
                <table>
                  <tr>
                    <td>
                      <label class="bold" for="contadevedora" id="lbl_contadevedora">Conta a Debitar:</label>
                    </td>
                    <td>
                      <?php
                      $Scontadevedora = "Conta Devedora";
                      db_input('contadevedora', 15, 1, true, "text", 1, '', '', '', '', 15);
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="bold" for="contacredora" id="lbl_contacredora">Conta a Creditar:</label>
                    </td>
                    <td>
                      <?php
                      $Scontacredora = "Conta Credora";
                      db_input('contacredora', 15, 1, true, "text", 1, '', '', '', '', 15);
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="bold" for="c217_contareferencia" id="lbl_c217_contareferenciaa">Conta Referência:</label>
                    </td>
                    <td>
                      <?php
                      $x = array("D" => "Devedora", "C" => "Credora");
                      db_select('c217_contareferencia',$x,'','','','c217_contareferencia');
                      ?>
                    </td>
                  </tr>
                </table>
              </fieldset>
            </td>
          </tr>

          <tr>
            <td class="text-center">
              <input name="incluir_regra" type="button" id="incluir_regra" value="Incluir"/>
              <input name="importar_regra" type="button" id="importar_regra" value="Importar"/>
            </td>
          </tr>

          <tr>
            <td>
              <fieldset>
                <legend>Regras de Abertura Cadastradas</legend>
                <div id="gridRegras"></div>
              </fieldset>
            </td>
          </tr>
        </table>
      </div>
    </form>
  </center>
 </body>
  <?
	  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
  ?>
</html>
<script type="text/javascript">

var oGet          = js_urlToObject();
var sUrlRpc       = 'con4_aberturaexercicio.RPC.php';
var MENSAGEM      = "financeiro.contabilidade.con4_processaencerramentopcasp.";

/**
 * Busca o valor dos RPs nao processados para o ano da sessao
 */
function js_buscaValorAberturaExercicio() {

  js_divCarregando("Aguarde, buscando valores...", "msgBox");
  var oObject           = new Object();
  oObject.exec          = "getDadosOrcamento";
  oObject.lProcessados  = oGet.lDesprocessar == 'true' ? 'false' : 'true';

  var oAjax = new Ajax.Request (sUrlRpc,{ method:'post',
                                          parameters:'json='+Object.toJSON(oObject),
                                          onComplete:js_retornoValorAberturaExercicio});
}

function js_retornoValorAberturaExercicio(oAjax) {
  
  js_removeObj("msgBox");
  var oRetorno = eval("("+oAjax.responseText+")");
  if (oRetorno.status == 2) {
  
    alert(oRetorno.message.urlDecode());
    return false;
  }
  
  $('nValorDespesa').value = js_formatar(oRetorno.nValorDotacao, "f");
  $('nValorReceita').value = js_formatar(oRetorno.nValorReceita, "f");

  if (oRetorno.lBloquearTela) {
	  
		$('sObservacao').disabled              = true;
		$('sObservacao').style.backgroundColor = '#DEB887';
		$('sObservacao').style.color           = '#333333';
		$('btnProcessar').disabled = true;

		var sMsgAviso = "Abertura do exercício já processada.";
		if (oGet.lDesprocessar == 'true') {
			var sMsgAviso = "Abertura do exercício já desprocessada.";
		}
		sMsgAviso += "\nVocê não pode executar essa rotina novamente"; 
		
		alert(sMsgAviso);
  }
	  
  
}

js_buscaValorAberturaExercicio();

/**
 * Verificamos se o campo observacao foi devidamente preenchido
 */
$('sObservacao').observe('keyup', function() {

  if ($F('sObservacao').trim() == "") {
    $('btnProcessar').disabled = true;
  } else {
    $('btnProcessar').disabled = false;
  }
});

$('btnProcessar').observe('click', function() {

  var oObject           = new Object();
  oObject.exec          = oGet.lDesprocessar == 'true' ? 'desprocessar' : 'processar';
  oObject.sObservacao   = encodeURIComponent(tagString($F('sObservacao')));
  oObject.nValorDotacao = $F('nValorDespesa');
  oObject.nValorReceita = $F('nValorReceita');
  js_divCarregando("Aguarde, processando...", "msgBox");  
  
  var oAjax = new Ajax.Request (sUrlRpc,{ method:'post',
                                          parameters:'json='+Object.toJSON(oObject),
                                          onComplete:js_retornoProcessamento});
});


function js_retornoProcessamento(oAjax) {

  js_removeObj("msgBox");
  var oRetorno = eval("("+oAjax.responseText+")");

	$('sObservacao').disabled              = true;
	$('sObservacao').style.backgroundColor = '#DEB887';
	$('sObservacao').style.color           = '#333333';
	$('btnProcessar').disabled = true;
  
  alert(oRetorno.message.urlDecode());
}

var oButtons = {

      Natureza: {
        processar: $('processar_natureza'),
        desprocessar: $('desprocessar_natureza'),
        regras: $('regras_natureza')
      }
    },
    oRegra = {
      salvar: $('incluir_regra'),
      contacredora: $('contacredora'),
      contadevedora: $('contadevedora'),
      contareferencia: $('c217_contareferencia'),
      importar: $('importar_regra')
    },
    oData = $('data');
var oGridRegras = new DBGrid("gridRegras");
oGridRegras.nameInstance = "oGridRegras";
oGridRegras.setCellWidth(["40%", "40%", "20%", "20%"]);
oGridRegras.setCellAlign(["left", "left", "center", "center"]);
oGridRegras.setHeader(["Devedora", "Credora", "Referência", "Ação"]);
oGridRegras.show($('gridRegras'));

var oWindowRegras = new windowAux('windowRegras', 'Regras para Abertura do Exercício', 700, 420);
oMessageBoard = new DBMessageBoard("messageboard", "Regras", "Configurar regras para a abertura do exercício", $('contentRegras'));
oMessageBoard.show();
oWindowRegras.setContent($('contentRegras'));

function removerRegra(iRegra) {

  if (!confirm( 'Tem certeza que deseja excluir essa regra?' )) {
    return false;
  }

  var oParametros = {
    exec : "removerRegra",
    iCodigoRegra : iRegra
  }

  new AjaxRequest(sUrlRpc, oParametros, function(oRetorno, lErro) {

    if (lErro) {
      alert(oRetorno.sMessage.urlDecode());
      return false;
    }

    alert(oRetorno.message.urlDecode());
    carregarRegras();

  }).setMessage("Aguarde, excluindo regra...")
      .execute();
}

function carregarRegras() {

  var oParametros = {
    exec: "buscarRegras"
  }

  oGridRegras.clearAll(true);

  new AjaxRequest(sUrlRpc, oParametros, function (oRetorno, lErro) {
    if (lErro) {
      alert(oRetorno.sMessage.urlDecode());
      return false;
    }

    oRetorno.aRegras.each(function (oItem) {
      oGridRegras.addRow([oItem.c217_contadevedora,
        oItem.c217_contacredora, oItem.c217_contareferencia,
        '<input type="button" name="remover' + oItem.c217_sequencial + '" id="remover' + oItem.c217_sequencial
        + '" onclick="removerRegra(' + oItem.c217_sequencial + ')" value="E" title="Excluir"/>']);
    });

    oGridRegras.renderRows();

  }).setMessage("Aguarde, Carregando regras...")
      .execute();
}

/**
 * Abre a janela das regras
 */
oButtons.Natureza.regras.observe('click', function () {
  oWindowRegras.show();
  carregarRegras();
});

/**
 * Salva as regras
 */
oRegra.salvar.observe('click', function () {

  if (empty(oRegra.contadevedora.value)) {
    alert("Campo obrigatório: Conta a Debitar");
    return false;
  }

  if (empty(oRegra.contacredora.value)) {
    alert("Campo obrigatório: Conta a Creditar");
    return false;
  }

  var oParametros = {
    exec: "salvarRegra",
    contacredora: oRegra.contacredora.value,
    contadevedora: oRegra.contadevedora.value,
    contareferencia: oRegra.contareferencia.value
  }

  new AjaxRequest(sUrlRpc, oParametros, function (oRetorno, lErro) {

    if (lErro) {
      alert(oRetorno.sMessage.urlDecode());
      return false;
    }

    alert('Salvo com Sucesso!');

    oRegra.contacredora.value = '';
    oRegra.contadevedora.value = '';

    carregarRegras();
  }).setMessage("Aguarde, salvando regra...").execute();
});

/**
 * Importar regras do exercício anterior
 */

oRegra.importar.observe('click', function() {

  var resp = confirm("Ao importar as regras do exercício anterior, as atuais serão apagadas. Deseja Continuar?");

  if(resp == true) {
    var oParametros = {
      exec: "importarRegra"
    }

    new AjaxRequest(sUrlRpc, oParametros, function (oRetorno, lErro) {

      if (lErro) {
        alert(oRetorno.sMessage.urlDecode());
        return false;
      }

      alert("Importação realizada com sucesso!");

      carregarRegras();
    }).setMessage("Aguarde, importando regras...").execute();
  }
});
</script>