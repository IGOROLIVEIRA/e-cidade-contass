<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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

require_once ("libs/db_stdlib.php");
require_once ("libs/db_conecta.php");
require_once ("libs/db_sessoes.php");
require_once ("libs/db_usuariosonline.php");
require_once ("dbforms/db_funcoes.php");
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbmessageBoard.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/windowAux.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/DBFileUpload.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/datagrid.widget.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body class="body-default">
<div class="container">
    <form>
        <fieldset class="form-container">
            <legend>Importação arquivo CATMAT</legend>
            <div id="ctnImportacao"></div>
        </fieldset>
        <input id="btnProcessar" type="button" value="Processar" onclick="processar();" disabled="disabled" />
    </form>
</div>
</body>
<?php
db_menu( db_getsession ( "DB_id_usuario" ), db_getsession ( "DB_modulo" ), db_getsession ( "DB_anousu" ), db_getsession ( "DB_instit" ) );
?>
<script>
    const MENSAGENS_SAU4_IMPORTACNES001 = 'saude.ambulatorial.sau4_importacaocnes001.';

    var oWindowAuxVinculos = '';
    var oGridVinculos      = '';
    var sRpc               = 'sau4_importacaocnescatmat.RPC.php';
    var lTemInconsistencia = false;

    var oMensagemConfirm           = {};
    oMensagemConfirm.sMensagem =  _M( MENSAGENS_SAU4_IMPORTACNES001 + "importacao_sucesso_inconsistencia");

    var oFileUpload = new DBFileUpload( {callBack: retornoEnvioArquivo} );
    oFileUpload.show($('ctnImportacao'));

    /**
     * Função de retorno ao selecionar um arquivo para upload
     * Valida se foi registrado algum erro ou se o arquivo possui uma extensão inválida
     * @param oRetorno
     * @returns {boolean}
     */
    function retornoEnvioArquivo( oRetorno ) {

        if (oRetorno.error) {

            alert(oRetorno.error);
            $('btnProcessar').disabled = true;
            return false;
        }

        if( oRetorno.extension.toLowerCase() != 'xlsx' ) {

            alert( _M( MENSAGENS_SAU4_IMPORTACNES001 + 'arquivo_invalido' ) );
            $('btnProcessar').disabled = true;
            return false;
        }

        $('btnProcessar').disabled = false;
    }

    /**
     * Processa o arquivo que foi feito upload, enviando os dados para o RPC
     */
    function processar() {

        var oParametros                 = {};
        oParametros.sExecuta        = 'processar';
        oParametros.sNomeArquivo    = oFileUpload.file;
        oParametros.sCaminhoArquivo = oFileUpload.filePath;

        var oAjaxRequest = new AjaxRequest( sRpc, oParametros, retornoProcessar );
        oAjaxRequest.setMessage( _M( MENSAGENS_SAU4_IMPORTACNES001 + 'processando_arquivo' ) );
        oAjaxRequest.execute();
    }

    function retornoProcessar( oRetorno, lErro ) {
        if (oRetorno.iStatus == 1){
            alert("Importação Ralizada com sucesso !");
        }else{
            alert(oRetorno.sMensagem);
        }
    }

</script>
