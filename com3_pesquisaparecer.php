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

require_once("dbforms/db_funcoes.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("classes/db_parecerlicitacao_classe.php");
$clparecerlicitacao = new cl_parecerlicitacao;

$oDaoRotulo = new rotulocampo;
$clparecerlicitacao->rotulo->label();

?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/datagrid.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/datagrid/plugins/DBHint.plugin.js"></script>
    <link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <link href="estilos/tab.style.css" rel="stylesheet" type="text/css">
    <style type="text/css">

        #ctnGridParecer {
            text-align: center;
        }
    </style>
</head>
<body bgcolor="#cccccc" onload="">
<div style="float:left;width: 100%">
    <fieldset>
        <legend><b>Parecer</b></legend>
        <div id="ctnGridParecer"></div>
    </fieldset>
</div>
</body>
</html>

<script>
    var aHeaders = ["Sequencial", "Data do Parecer", "Tipo do Parecer", "Responsável Técnico"];

    var aCellAlign = ["center", "center", "center", "center"];

    var aCellWidth = ["10%", "20%", "20%", "50%"];

    var oGridItens = new DBGrid("oGridItens");
    oGridItens.sNameInstance = "oGridItens";
    oGridItens.setHeader(aHeaders);
    oGridItens.setCellAlign(aCellAlign);
    oGridItens.setCellWidth(aCellWidth);

    var oGet = js_urlToObject();
    let oParametro = {
        "exec" : "parecerLicitacao",
        "iCodigoLicitacao": oGet.l20_codigo
    };

    js_divCarregando("Aguarde, carregando itens da licitação", "msgBox");

    new Ajax.Request("lic4_licitacao.RPC.php",
        {
            method: 'post',
            asynchronous: false,
            parameters: 'json='+Object.toJSON(oParametro),
            onComplete: completarGrid
        }
    );

    function completarGrid(oAjax) {

        js_removeObj("msgBox");
        let oRetorno = eval("("+oAjax.responseText+")");

        oGridItens.clearAll(true);

        if (oRetorno.itens.length == 0) {
            let node = document.createElement('b');

            node.appendChild(document.createTextNode('Nenhum registro retornado. '));

            document.getElementById('ctnGridParecer').appendChild(node);
        }else{
            oGridItens.show($('ctnGridParecer'));
        }

        /**
         * Adicionamos os itens na grid
         */
        oRetorno.itens.each( (oItem, iIndice) => {

            let aLinha = [
                oItem.sequencial,
                oItem.dataparecer.split('-').reverse().join('/'),
                oItem.tipoparecer.urlDecode(),
                oItem.nomeresp.urlDecode()
            ];

            oGridItens.addRow(aLinha);

        });

        oGridItens.renderRows();

    }
</script>