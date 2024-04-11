<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_app.utils.php");
require_once("dbforms/db_funcoes.php");

$iOpcaoLicitacao = 1;
$lExibirMenus   = true;
$cltipoanexo = new cl_tipoanexo;
$clanexocomprapncp = new cl_anexocomprapncp;

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"], $result);

/**
 * Codigo do precesso informado por GET
 * - Pesquisa numero e ano do Licitacao
 */


$oRotulo  = new rotulocampo;
$oDaoLicanexopncpdocumento = db_utils::getDao('licanexopncpdocumento');
$oDaoLicanexopncpdocumento->rotulo->label();

$oRotulo->label("pc80_codproc");
$oRotulo->label("pc80_resumo");
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

    <table style="display:none;">
        <tr>
            <td>
                <?php
                    db_input('pc80_codproc', 12, $Ipc80_codproc, true, 'text', $iOpcaoLicitacao, "");
                ?>
            </td>
        </tr>
    </table>

    <fieldset style="margin-top:15px;">
        <legend>Documentos Anexados</legend>
        <div id="ctnDbGridDocumentos"></div>
    </fieldset>
    <input type="button" id="btnDownloadAnexos" value="Download" onClick="js_downloadAnexos();" />

</div>

<?php if ($lExibirMenus) : ?>
    <?php db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit")); ?>
<?php endif; ?>

<div id="teste" style="display:none;"></div>
</body>

</html>
<script type="text/javascript">

    /**
     * Mensagens do programa
     * @type constant
     */
    const MENSAGENS = 'patrimonial.licitacao.lic1_anexospncp.';

    var sUrlRpc = 'com1_anexospncp.RPC.php';

    var oGridDocumentos = new DBGrid('gridDocumentos');

    oGridDocumentos.nameInstance = "oGridDocumentos";
    oGridDocumentos.setCheckbox(0);
    oGridDocumentos.setCellAlign(new Array("center", "center", "center", "center"));
    oGridDocumentos.setCellWidth(["2%", "15%", "80%", "30%"]);
    oGridDocumentos.setHeader(new Array("Seq", "Código", "Tipo"));
    oGridDocumentos.aHeaders[1].lDisplayed = false;
    oGridDocumentos.allowSelectColumns(true);
    oGridDocumentos.show($('ctnDbGridDocumentos'));
    js_buscarDocumentos();

    /**
     * Buscar documentos do processo
     * @return boolean
     */
    function js_buscarDocumentos() {

        var iCodigoProcesso = $('pc80_codproc').value;

        if (empty(iCodigoProcesso)) {
            return false;
        }

        js_divCarregando('mensagem_buscando_documentos', 'msgbox');

        var oParametros = new Object();

        oParametros.exec = 'carregarDocumentos';
        oParametros.iCodigoProcesso = iCodigoProcesso;

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

                    var sMensagem = oRetorno.sMensagem.urlDecode();

                    if (oRetorno.iStatus > 1) {

                        alert(sMensagem);
                        return false;
                    }

                    oGridDocumentos.clearAll(true);
                    var iDocumentos = oRetorno.aDocumentosVinculados.length;

                    for (var iIndice = 0; iIndice < iDocumentos; iIndice++) {

                        var oDocumento = oRetorno.aDocumentosVinculados[iIndice];
                        var sDescricaoDocumento = oDocumento.sDescricaoDocumento.urlDecode();

                        $bBloquea = false;



                        var aLinha = [oDocumento.iCodigoDocumento, iIndice + 1, sDescricaoDocumento];
                        oGridDocumentos.addRow(aLinha, false, $bBloquea);
                    }

                    oGridDocumentos.renderRows();
                }
            }
        );

    }

    /**
     * Altera descricao de um documento
     * @param integer iCodigoDocumento
     * @param string sDescricaoDocumento
     * @return void
     */
    function js_alterar() {

        var iCodigoDocumento = $('iddocumento').value;
        var itipoanexo = $('l213_sequencial').value;
        if (empty(iCodigoDocumento)) {

            alert('Codigo do documento vazio.');
            return false;
        }

        if (itipoanexo == 0) {

            alert('Selecione um tipo de anexo.');
            return false;
        }

        js_divCarregando('Aguarde... Alterando documento.', 'msgbox');

        var oParametros = new Object();

        oParametros.exec = 'alterardocumento';
        oParametros.iCodigoDocumento = iCodigoDocumento;
        oParametros.itipoanexo = itipoanexo;

        var oAjax = new Ajax.Request(
            sUrlRpc, {
                parameters: 'json=' + Object.toJSON(oParametros),
                method: 'post',
                asynchronous: false,
                onComplete: function(oAjax) {

                    js_removeObj("msgbox");
                    var oRetorno = eval('(' + oAjax.responseText + ")");
                    var sMensagem = oRetorno.sMensagem.urlDecode();

                    if (oRetorno.iStatus > 1) {

                        alert(sMensagem);
                        return false;
                    }

                    $('l213_sequencial').value = 0;
                    $('namefile').value = '';
                    $('uploadfile').value = '';
                    $('iddocumento').value = '';
                    $('uploadfile').disabled = false;
                    $("btnSalvar").style.display = "";
                    $("btnAlterar").style.display = "none";
                    js_buscarDocumentos();
                    alert(sMensagem);
                }
            });


    }



    /**
     * Download de um documento
     * - busca arquivo do banco e salva no tmp
     * - exibe janela com link para download
     * @param  integer iCodigoDocumento
     * @return void
     */
    function js_downloadDocumento(iCodigoDocumento) {

        js_divCarregando('mensagem_carregando_documento', 'msgbox');

        var oParametros = new Object();

        oParametros.exec = 'download';
        oParametros.iCodigoDocumento = iCodigoDocumento;

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
                    var sMensagem = oRetorno.sMensagem.urlDecode();

                    if (oRetorno.iStatus > 1) {

                        alert(sMensagem);
                        return false;
                    }

                    var sCaminhoDownloadArquivo = oRetorno.sCaminhoDownloadArquivo.urlDecode();
                    var sTituloArquivo = oRetorno.sTituloArquivo.urlDecode();

                    window.open("db_download.php?arquivo=" + sCaminhoDownloadArquivo);
                }
            });

    }


    /**
     * Exclui documentos selecionados
     * @return boolean
     */
    function js_excluirDocumento(iCodigoDocumento) {
        js_divCarregando('Excluindo documento...', 'msgbox');

        var oParametros = new Object();

        const iCodigoProcesso = $('pc80_codproc').value;
        oParametros.exec = 'excluir';
        oParametros.iCodigoDocumento = iCodigoDocumento;
        oParametros.iCodigoProcesso = iCodigoProcesso;

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
                    var sMensagem = oRetorno.sMensagem.urlDecode();

                    if (oRetorno.iStatus > 1) {

                        alert(sMensagem);
                        return false;
                    }

                    alert(sMensagem);
                    js_buscarDocumentos();
                }
            });

    }

    /**
     * Realiza o download de todos os anexos ou apenas selecionados
     * @return boolean
     */
    const js_downloadAnexos = () => {


        const iCodigoProcesso = $('pc80_codproc').value

        if (empty(iCodigoProcesso)) {
            return false
        }

        const documentosSelecionados = oGridDocumentos.getSelection("object")
        if (documentosSelecionados.length == 0) {
            alert('Selecione pelo menos arquivo para download')
            return false
        }
        js_divCarregando('Aguarde... Organizando documentos para o download', 'msgbox')
        let codigosDosDocumentos = []

        for (documento of documentosSelecionados) {
            const codigoDoDocumento = documento.aCells[0].getValue()
            codigosDosDocumentos.push(codigoDoDocumento)
        }

        if (codigosDosDocumentos.length == '1') {
            js_downloadDocumento(codigosDosDocumentos[0])
            js_removeObj("msgbox");
            return false
        }

        let documentos = []
        if (documentosSelecionados.length === 0) {
            codigosDosDocumentos = js_documentosDeUmProcesso(iCodigoProcesso)
        }

        const urlDosArquivos = []

        codigosDosDocumentos.map(codigoDoDocumento => {
            const oCodigoDocumento = new Object()

            oCodigoDocumento.exec = 'download'
            oCodigoDocumento.iCodigoDocumento = codigoDoDocumento

            urlDosArquivos.push(js_arquivos(oCodigoDocumento))
        })

        js_ziparAnexos(urlDosArquivos, nomeDoZip => {
            js_removeObj("msgbox")
            window.open(`db_download.php?arquivo=${nomeDoZip}`)

            setTimeout(() => {
                js_apagarZip(nomeDoZip)
            }, 3000)
        });

    }


    const js_arquivos = oCodigoDocumento => {
        var oRetorno

        var oAjax2 = new Ajax.Request(
            sUrlRpc, {
                parameters: 'json=' + Object.toJSON(oCodigoDocumento),
                method: 'post',
                asynchronous: false,

                /**
                 * Retorno do RPC
                 */
                onComplete: oAjax2 => {
                    oRetorno = eval('(' + oAjax2.responseText + ")")
                    var sMensagem = oRetorno.sMensagem.urlDecode()

                    if (oRetorno.iStatus > 1) {

                        alert(sMensagem)
                        return false
                    }
                }
            })

        return oRetorno;

    }

    const js_documentosDeUmProcesso = iCodigoProcesso => {


        if (empty(iCodigoProcesso)) {
            return false
        }

        const oParametros = new Object()

        oParametros.exec = 'carregarDocumentos'
        oParametros.iCodigoProcesso = iCodigoProcesso

        const codigosDeDocumentos = []

        const oAjax = new Ajax.Request(
            sUrlRpc, {
                parameters: 'json=' + Object.toJSON(oParametros),
                method: 'post',
                asynchronous: false,
                onComplete: oAjax => {
                    const documentos = JSON.parse(oAjax.responseText).aDocumentosVinculados
                    documentos.map(documento => {
                        codigosDeDocumentos.push(documento.iCodigoDocumento)
                    })
                    const sMensagem = oRetorno.sMensagem.urlDecode()

                    if (oRetorno.iStatus > 1) {
                        alert(sMensagem)
                        return false
                    }
                }
            }
        )
        return codigosDeDocumentos

    }

    const js_ziparAnexos = (arquivos, callback) => {

        var oParametros = new Object()
        oParametros.exec = 'ziparAnexos'

        arquivos.map(documento => {
            novoTituloDeArquivo = documento.sCaminhoDownloadArquivo.replace('/tmp/', '')
            documento.sTituloArquivo = novoTituloDeArquivo
        })

        oParametros.arquivos = arquivos

        let oRetorno = null
        var oAjax = new Ajax.Request(
            sUrlRpc, {
                method: 'post',
                parameters: `json=${JSON.stringify(oParametros)}`,
                onComplete: oAjax => {

                    oRetorno = eval('(' + oAjax.responseText + ')')
                    var sMensagem = oRetorno.sMensagem.urlDecode()

                    if (oRetorno.iStatus > 1) {

                        alert(sMensagem)
                        return false
                    }

                    return callback(oRetorno.nomeDoZip)

                }
            })

    }

    const js_apagarZip = nomeDoZip => {
        const oParametros = new Object()
        oParametros.exec = 'apagarZip'
        oParametros.nomeDoZip = nomeDoZip
        const oAjax = new Ajax.Request(
            sUrlRpc, {
                method: 'post',
                parameters: `json=${JSON.stringify(oParametros)}`,
                onComplete: oAjax => {

                    oRetorno = eval('(' + oAjax.responseText + ')')
                    var sMensagem = oRetorno.sMensagem.urlDecode()

                    if (oRetorno.iStatus > 1) {

                        alert(sMensagem)
                        return false
                    }
                }
            })
    }

    function js_excluirSelecionados() {

        var documentosSelecionados = oGridDocumentos.getSelection("object");
        var iSelecionados = documentosSelecionados.length;
        var iCodigoProcesso = $('pc80_codproc').value;
        var aDocumentos = [];

        if (iSelecionados == 0) {

            alert('Nenhum docuento selecionado.');
            return false;
        }



        if (empty(iCodigoProcesso)) {

            alert('Licitação não informada.');
            return false;
        }

        for (var iIndice = 0; iIndice < iSelecionados; iIndice++) {

            var iDocumento = documentosSelecionados[iIndice].aCells[0].getValue();
            aDocumentos.push(iDocumento);
        }

        js_divCarregando('Aguarde... Excluindo documentos!', 'msgbox');

        var oParametros = new Object();

        oParametros.exec = 'excluirDocumento';
        oParametros.iCodigoProcesso = iCodigoProcesso;
        oParametros.aDocumentosExclusao = aDocumentos;

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
                    var sMensagem = oRetorno.sMensagem.urlDecode();

                    if (oRetorno.iStatus > 1) {

                        alert(sMensagem);
                        return false;
                    }

                    alert(sMensagem);
                    js_buscarDocumentos();
                }
            });

    }

    function startLoading() {
        js_divCarregando('Aguarde... Enviando documento.', 'msgbox');
    }

    function endLoading() {
        js_removeObj('msgbox');
    }

</script>
