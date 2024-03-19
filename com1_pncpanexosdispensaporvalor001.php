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

        <fieldset>
            <legend>Anexos PNCP</legend>
            <form name="form" id="form" method="post" action="" enctype="multipart/form-data">


                <?php db_input("namefile", 30, 0, true, "hidden", 1); ?>
                <?php db_input("iddocumento", 30, 0, true, "hidden", 1); ?>

                <table class="form-container">

                    <tr>
                        <td nowrap title="<?php echo $Tl216_licanexospncp; ?>">
                            <?php db_ancora("Processo de Compras: ", "js_pesquisarProcessoCompras(true);", $iOpcaoLicitacao); ?>
                        </td>
                        <td>
                            <?php
                            db_input('pc80_codproc', 12, $Ipc80_codproc, true, 'text', $iOpcaoLicitacao, " onChange='js_pesquisarProcessoCompras(false);'");
                            db_input('pc80_resumo', 60, $Ipc80_resumo, true, 'text', 3, "");
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td nowrap title="<?php echo $Tl216_documento; ?>">
                            <?php echo $Ll216_documento; ?>
                        </td>
                        <td>
                            <?php db_input("uploadfile", 53, 0, true, "file", 1); ?>
                        </td>
                    </tr>

                    <tr>
                        <td nowrap title="<?= @$Tl213_sequencial ?>">
                            <b>
                                <?
                                db_ancora("Tipo de Anexo :", "js_pesquisal20_codtipocom(true);", 3);
                                ?>
                            </b>
                        </td>
                        <td>
                            <?


                            $tipo = array();
                            $tipo[0] = "Selecione";
                            $result_tipo = $cltipoanexo->sql_record($cltipoanexo->sql_query(null, "*", "l213_sequencial", "l213_sequencial in (5,6,8,9,10,16,20)"));


                            for ($iIndiceTipo = 0; $iIndiceTipo < $cltipoanexo->numrows; $iIndiceTipo++) {

                                $oTipo = db_utils::fieldsMemory($result_tipo, $iIndiceTipo);

                                $tipo[$oTipo->l213_sequencial] = utf8_decode($oTipo->l213_descricao);
                            }

                            if ($cltipoanexo->numrows == 0) {
                                db_msgbox("Nenhuma Tipo de anexo cadastrado!!");
                                $result_tipo = "";
                                $db_opcao = 3;
                                $db_botao = false;
                                db_input("l213_sequencial", 10, "", true, "text");
                                db_input("l213_sequencial", 40, "", true, "text");
                            } else {
                                db_select("l213_sequencial", $tipo, true, $db_opcao, "");
                            }
                            ?>
                        </td>
                    </tr>

                </table>
            </form>
        </fieldset>

        <input type="button" id="btnSalvar" onClick="js_salvar();" value="Salvar" />
        <input type="button" id="btnAlterar" onClick="js_alterar();" value="Alterar" />


        <fieldset style="margin-top:15px;">
            <legend>Documentos Anexados</legend>
            <div id="ctnDbGridDocumentos"></div>
        </fieldset>
        <input type="button" id="btnEnviarPNCP" value="Envia documento para o PNCP" onClick="js_enviarDocumentoPNCP();" />
        <input type="button" id="btnExcluirPNCP" value="Excluir documento no PNCP" onClick="js_excluirDocumentoPNCP();" />
        <input type="button" id="btnExcluir" value="Excluir Selecionados" onClick="js_excluirSelecionados();" />
        <input type="button" id="btnDownloadAnexos" value="Download" onClick="js_downloadAnexos();" />

    </div>

    <?php if ($lExibirMenus) : ?>
        <?php db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit")); ?>
    <?php endif; ?>

    <div id="teste" style="display:none;"></div>
</body>

</html>
<script type="text/javascript">
    document.getElementById("btnAlterar").style.display = "none";

    /**
     * Pesquisa Licitacao do protocolo e depois os documentos anexados
     */
    if (!empty($('pc80_codproc').value)) {
        js_pesquisarProcessoCompras(false);
    }

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
    oGridDocumentos.setCellWidth(["30%", "30%", "30%", "30%"]);
    oGridDocumentos.setHeader(new Array("Seq", "Código", "Tipo", "Ação"));
    oGridDocumentos.aHeaders[1].lDisplayed = false;
    oGridDocumentos.allowSelectColumns(true);
    oGridDocumentos.show($('ctnDbGridDocumentos'));


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


                        var sHTMLBotoes = '<input type="button" value="Alterar" onClick="js_alterarDocumento(' + oDocumento.iCodigoDocumento + ', \'' + sDescricaoDocumento + '\');" />  ';
                        sHTMLBotoes += '<input type="button" value="Excluir" onClick="js_excluirDocumento(' + oDocumento.iCodigoDocumento + ');" />  ';

                        $bBloquea = false;



                        var aLinha = [oDocumento.iCodigoDocumento, iIndice + 1, sDescricaoDocumento, sHTMLBotoes];
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
    function js_alterarDocumento(iCodigoDocumento) {


        if (empty(iCodigoDocumento)) {

            alert('Codigo do documento vazio.');
            return false;
        }

        js_divCarregando('Aguarde... Buscando documento.', 'msgbox');

        var oParametros = new Object();

        oParametros.exec = 'buscardocumento';
        oParametros.iCodigoDocumento = iCodigoDocumento;

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

                    $('l213_sequencial').value = oRetorno.idtipo;
                    $('namefile').value = '';
                    $('uploadfile').value = '';
                    $('iddocumento').value = iCodigoDocumento;
                    $('uploadfile').disabled = true;
                    $("btnSalvar").style.display = "none";
                    $("btnAlterar").style.display = "";


                }
            });


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

    /**
     * Pesquisar Licitacao
     *
     * @param boolean lMostra
     * @return boolean
     */
    function js_pesquisarProcessoCompras(lMostra) {

        var sArquivo = 'func_pcproc.php?pncp=t&pncp=true&funcao_js=parent.';

        if (lMostra) {
            sArquivo += 'js_mostraProcessodecompras|pc80_codproc|pc80_resumo';
        } else {

            var iNumeroLicitacao = $('pc80_codproc').value;

            if (empty(iNumeroLicitacao)) {
                return false;
            }

            sArquivo += 'js_mostraProcessodecomprasHidden&pesquisa_chave=' + iNumeroLicitacao + '&sCampoRetorno=pc80_resumo';
        }

        js_OpenJanelaIframe('', 'db_iframe_proc', sArquivo, 'Pesquisa de Licitação', lMostra);
    }

    /**
     * Retorno da js_pesquisarProcessoCompras apor clicar em uma Licitacao
     * @param  integer iCodigoProcesso
     * @param  integer iNumeroLicitacao
     * @param  string descricao
     * @return void
     */
    function js_mostraProcessodecompras(iCodigoProcesso, descricao) {

        $('pc80_codproc').value = iCodigoProcesso;
        $('pc80_resumo').value = descricao;
        $('uploadfile').value = '';
        $('uploadfile').disabled = false;
        $('iddocumento').value = '';
        $('namefile').value = '';
        db_iframe_proc.hide();

        js_buscarDocumentos();

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

    /**
     * Retorno da pesquisa js_pesquisarProcessoCompras apos mudar o campo pc80_codproc
     * @param  integer iCodigoProcesso
     * @param  string descricao
     * @param  boolean lErro
     * @return void
     */
    function js_mostraProcessodecomprasHidden(descricao, lErro) {
        console.log(descricao);
        /**
         * Nao encontrou Licitacao
         */
        if (lErro) {

            $('pc80_codproc').value = '';
            $('uploadfile').value = '';
            $('iddocumento').value = '';
            $('namefile').value = '';
            $('uploadfile').disabled = false;
            oGridDocumentos.clearAll(true);
        }

        $('pc80_resumo').value = descricao;
        js_buscarDocumentos();
    }

    /**
     * Cria um listener para subir a imagem, e criar um preview da mesma
     */
    $("uploadfile").onchange = function() {

        startLoading();
        var iFrame = document.createElement("iframe");
        iFrame.src = 'func_uploadfilelicitacaopncp.php?clone=form';
        iFrame.id = 'uploadIframe';
        $('teste').appendChild(iFrame);
    }

    function startLoading() {
        js_divCarregando('Aguarde... Enviando documento.', 'msgbox');
    }

    function endLoading() {
        js_removeObj('msgbox');
    }

    function js_salvar() {

        var iCodigoProcesso = $('pc80_codproc').value;



        if (empty(iCodigoProcesso)) {

            alert('Processo de Compras não incluido');
            return false;
        }

        var iCodigoDocumento = $('l213_sequencial').value;

        if (iCodigoDocumento == 0) {
            alert('Selecione um tipo de anexo!');
            return false;

        }

        var sCaminhoArquivo = $('namefile').value;


        if (sCaminhoArquivo == '') {

            alert('Arquivo anexo não informado!');
            return false;
        }

        js_divCarregando('Aguarde... Salvando documento.', 'msgbox');

        var oParametros = new Object();

        oParametros.exec = 'salvarDocumento';
        oParametros.iCodigoDocumento = iCodigoDocumento;
        oParametros.iCodigoProcesso = iCodigoProcesso;
        oParametros.sCaminhoArquivo = sCaminhoArquivo;

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
                    $('uploadfile').value = '';
                    $('namefile').value = '';
                    $('uploadfile').disabled = false;
                    js_buscarDocumentos();
                    alert(sMensagem);
                }
            });
    }

    function js_enviarDocumentoPNCP() {

        const documentosSelecionados = oGridDocumentos.getSelection("object")
        var iSelecionados = documentosSelecionados.length;
        var iCodigoProcesso = $('pc80_codproc').value;
        var aDocumentos = [];
        var aTipo = [];

        if (iSelecionados == 0) {
            alert('Selecione pelo menos arquivo para Enviar')
            return false
        }
        if (!confirm('Confirma o Envio do Documento?')) {
            return false;
        }

        if (empty(iCodigoProcesso)) {

            alert('Licitação não informada.');
            return false;
        }

        for (var iIndice = 0; iIndice < iSelecionados; iIndice++) {

            var iDocumento = documentosSelecionados[iIndice].aCells[0].getValue();
            aDocumentos.push(iDocumento);

            var iTipo = documentosSelecionados[iIndice].aCells[3].getValue();
            aTipo.push(iTipo);

        }

        js_divCarregando('Aguarde... Enviando documentos!', 'msgbox');

        var oParametros = new Object();

        oParametros.exec = 'EnviarDocumentoPNCP';
        oParametros.iCodigoProcesso = iCodigoProcesso;
        oParametros.aDocumentos = aDocumentos;
        oParametros.aTipoDocumentos = aTipo;

        var oAjax = new Ajax.Request(
            'com1_envioanexos.RPC.php', {
                parameters: 'json=' + Object.toJSON(oParametros),
                method: 'post',
                asynchronous: false,

                /**
                 *
                 * Retorno do RPC
                 */
                onComplete: function(oAjax) {

                    js_removeObj("msgbox");
                    var oRetorno = eval('(' + oAjax.responseText + ")");

                    if (oRetorno.status == 1) {
                        alert("Anexo(s) Enviado(s) com Sucesso!");
                    } else {
                        alert(oRetorno.message.urlDecode());
                    }
                }
            });

    }

    function js_excluirDocumentoPNCP() {
        const documentosSelecionados = oGridDocumentos.getSelection("object")
        var iSelecionados = documentosSelecionados.length;
        var iCodigoProcesso = $('pc80_codproc').value;
        var aDocumentos = [];
        var aTipo = [];

        if (iSelecionados == 0) {
            alert('Selecione pelo menos arquivo para Excluir')
            return false
        }
        if (!confirm('Confirma a Exclusão do Documento?')) {
            return false;
        }

        if (empty(iCodigoProcesso)) {

            alert('Licitação não informada.');
            return false;
        }

        for (var iIndice = 0; iIndice < iSelecionados; iIndice++) {

            var iDocumento = documentosSelecionados[iIndice].aCells[0].getValue();
            aDocumentos.push(iDocumento);

            var iTipo = documentosSelecionados[iIndice].aCells[3].getValue();
            aTipo.push(iTipo);

        }

        js_divCarregando('Aguarde... Excluindo documentos!', 'msgbox');

        var oParametros = new Object();

        oParametros.exec = 'ExcluirDocumentoPNCP';
        oParametros.iCodigoProcesso = iCodigoProcesso;
        oParametros.aDocumentos = aDocumentos;
        oParametros.aTipoDocumentos = aTipo;

        var oAjax = new Ajax.Request(
            'com1_envioanexos.RPC.php', {
                parameters: 'json=' + Object.toJSON(oParametros),
                method: 'post',
                asynchronous: false,

                /**
                 *
                 * Retorno do RPC
                 */
                onComplete: function(oAjax) {

                    js_removeObj("msgbox");
                    var oRetorno = eval('(' + oAjax.responseText + ")");
                    console.log(oRetorno);
                    if (oRetorno.status == 1) {
                        alert("Anexo(s) Excluidos(s) com Sucesso!");
                    } else {
                        alert(oRetorno.message.urlDecode());
                    }
                }
            });
    }
</script>
