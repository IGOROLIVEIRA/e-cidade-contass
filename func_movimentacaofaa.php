<?php

require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once ("dbforms/db_funcoes.php");

?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <link rel="stylesheet" type="text/css" href="estilos/grid.style.css">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/datagrid.widget.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/widgets/datagrid/plugins/DBHint.plugin.js"></script>

</head>
<body class='body-default'>
  <div style="width: 98%;">
    <fieldset style="width: 100%;">
      <legend>Movimentações da Ficha de Atendimento</legend>
      <div id="ctnGridMovimentacoes">

      </div>
    </fieldset>
  </div>
</body>

<script type="text/javascript">

var oGet = js_urlToObject();

var oGridMovimentacao   = new DBGrid('gridContasLancamentos');
var aHeaders   = ['Usuário', 'Situação', 'Data', 'Hora', 'Setor', 'Observação', 'codigo'];
var aCellWidth = [ '27%', '10%', '8%', '5%', '15%', '35%'];
var aCellAlign = ['left', 'left', 'center', 'center', 'left', 'left' ];

oGridMovimentacao.nameInstance = 'oGridMovimentacao';
oGridMovimentacao.setCellWidth(aCellWidth);
oGridMovimentacao.setCellAlign(aCellAlign);
oGridMovimentacao.setHeader(aHeaders);
oGridMovimentacao.setHeight(150);
oGridMovimentacao.aHeaders[6].lDisplayed = false;
oGridMovimentacao.show($('ctnGridMovimentacoes'));

var oParametro    = {'sExecucao': 'buscarMovimentacoes','iProntuario': oGet.iProntuario}
var oAjaxRequest  = new AjaxRequest('sau4_fichaatendimento.RPC.php', oParametro, callBackRetorno);
oAjaxRequest.setMessage('Buscando departamentos...');
oAjaxRequest.execute();

function callBackRetorno(oRetorno, lErro) {

  if (lErro) {
    alert ( oRetorno.sMensagem.urlDecode() );
    return false;
  }

  oGridMovimentacao.clearAll(true);

  oRetorno.aMovimentacoes.each(function(oMovimentacao) {

    var aLinha = [];
    aLinha.push( oMovimentacao.sUsuario.urlDecode() );
    aLinha.push( oMovimentacao.sSituacao.urlDecode() );
    aLinha.push( oMovimentacao.dtMovimentacao );
    aLinha.push( oMovimentacao.sHoraMovimentacao.urlDecode() );
    aLinha.push( oMovimentacao.sSetorAmbulatorial.urlDecode() );
    aLinha.push( oMovimentacao.sObservacao.urlDecode() );
    aLinha.push( oMovimentacao.iCodigo );

    oGridMovimentacao.addRow(aLinha);
  });

  oGridMovimentacao.renderRows();

  oRetorno.aMovimentacoes.each(function(oMovimentacao, iLinha) {

    oGridMovimentacao.aRows[iLinha].aCells[0].addClassName( "elipse" );
    if ( !empty( oMovimentacao.sObservacao ) ) {

      var sIdLinha        = oGridMovimentacao.aRows[iLinha].aCells[5].sId;
      $(sIdLinha).style.textOverflow = "ellipsis";
      oGridMovimentacao.setHint(iLinha, 5, oMovimentacao.sObservacao.urlDecode());
    }
  });
}

</script>
</html>
