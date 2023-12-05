<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
require_once("classes/db_benscontrolerfid_classe.php");
include("dbforms/db_funcoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/JSON.php");
require_once("std/db_stdClass.php");

db_postmemory($HTTP_POST_VARS);
$clbenscontrolerfid = new cl_benscontrolerfid;
$db_opcao = 1;
$db_botao = true;
if(isset($incluir)){
  db_inicio_transacao();
  $clbenscontrolerfid->incluir();
  db_fim_transacao();
}
?>
<html>

<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <?php
  db_app::load("estilos.css, grid.style.css");
  db_app::load("scripts.js, prototype.js, strings.js, datagrid.widget.js");
  ?>
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

  <div class="container" style="width:650px;">
    <fieldset style="margin-top:15px;">
      <legend>Bens Pendentes de baixa</legend>
      <div id="ctnDbGridDocumentos"></div>
    </fieldset>

    <input type="button" id="btnExcluir" value="Enviar Selecionados" onClick="js_enviarBens();" />
    <!-- <input type="button" id="btnDownloadAnexos" value="Download" onClick="js_downloadAnexos();" /> -->

  </div>

  <?php if ($lExibirMenus) : ?>
    <?php db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit")); ?>
  <?php endif; ?>

</body>

</html>
<script type="text/javascript">

  /**
   * Mensagens do programa
   * @type constant
   */
  const MENSAGENS = 'patrimonial.licitacao.pat1_bensnovo.';

  var sUrlRpc = 'pat1_bensnovo.RPC.php';

  var oGridDocumentos = new DBGrid('gridDocumentos');

  oGridDocumentos.nameInstance = "oGridDocumentos";
  oGridDocumentos.setCheckbox(0);
  oGridDocumentos.setCellAlign(new Array("center","center", "center", "center"));
  oGridDocumentos.setCellWidth([ "30%","20%", "50%", "20%"]);
  oGridDocumentos.setHeader(new Array("Seq","Código Bem", "Descrição", "Placa"));
  oGridDocumentos.aHeaders[1].lDisplayed = false;
  oGridDocumentos.allowSelectColumns(true);
  oGridDocumentos.show($('ctnDbGridDocumentos'));


    /**
   * Buscar documentos do processo
   * @return boolean
   */
  function js_buscarDocumentos() {

    js_divCarregando('mensagem_buscando_baixas_pendentes', 'msgbox');

    var oParametros = new Object();

    oParametros.exec = 'carregaBenspendentes';
    oParametros.controle = 3;
   
    var oAjax = new Ajax.Request(
      sUrlRpc, {
        parameters: 'json=' + Object.toJSON(oParametros),
        method: 'post',
        asynchronous: false,

        /**
         * Retorno do RPC
         */
        onComplete: function(oAjax) {

          js_removeObj("msgbox");
          var oRetorno = eval('(' + oAjax.responseText + ")");
                    
          if (oRetorno.status == 2) {
            alert(oRetorno.msg);
            return false;
          }
          
          oGridDocumentos.clearAll(true);
          var iDocumentos =oRetorno.dados.length;
          
          oRetorno.dados.each(function (oDocumento, iSeq) {
            
            var sBem = oDocumento.codigobem;
            var sDescricaoDocumento = oDocumento.descricaobem;
            var sPlaca = oDocumento.placabem;

            var sHTMLBotoes = '<input type="button" value="Alterar" onClick="js_alterarDocumento(' + oDocumento.iCodigoDocumento + ', \'' + sDescricaoDocumento + '\');" />  ';
              sHTMLBotoes += '<input type="button" value="Excluir" onClick="js_excluirDocumento(' + oDocumento.iCodigoDocumento + ');" />  ';

              $bBloquea = false;

            var aLinha = [oDocumento,sBem,sDescricaoDocumento, sPlaca];
            oGridDocumentos.addRow(aLinha, false, $bBloquea);
          });
          
          oGridDocumentos.renderRows();
          
        }
      }
    );

  }

function js_enviarBens() {

var aBens = oGridDocumentos.getSelection("object");

if (aBens.length == 0) {
            alert('Nenhum Bem Selecionado');
            return false;
        }

var oParametros = new Object();

oParametros.aBens = new Array();

for (var i = 0; i < aBens.length; i++) {

  with(aBens[i]) {
      var bens = new Object();
      bens.codigobem = aCells[2].getValue();
      bens.placabem = aCells[4].getValue();
      oParametros.aBens.push(bens);
  }
}        

js_divCarregando('mensagem_enviando_baixa_bens_pendentes', 'msgbox');        


oParametros.exec = 'enviarBaixaspendentes';

var oAjax = new Ajax.Request(
  sUrlRpc, {
    parameters: 'json=' + Object.toJSON(oParametros),
    method: 'post',
    asynchronous: false,

    /**
     * Retorno do RPC
     */
    onComplete: function(oAjax) {

      js_removeObj("msgbox");
      var oRetorno = eval('(' + oAjax.responseText + ")");
               
      if (oRetorno.status == 2) {
        alert(oRetorno.msg);
        return false;
      }

      if (oRetorno.statusbens == 'f') {
          return;
      }
      
      if(oRetorno.statusbens == 'success'){
          alert(_M('patrimonial.patrimonio.db_frm_bensnovo.bem_sucesso'));
          window.location.href = "pat4_baixacontrolerfid001.php"; 
          return;
      } 
      return alert(_M('patrimonial.patrimonio.db_frm_bensnovo.pedentesbaixa_falha')); 
    }
  }
);

}

  js_buscarDocumentos();


</script>