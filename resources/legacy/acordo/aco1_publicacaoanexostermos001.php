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

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"], $result);

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
      <legend>Anexos Termos PNCP</legend>
      <form name="form" id="form" method="post" action="" enctype="multipart/form-data">


        <?php db_input("namefile", 30, 0, true, "hidden", 1); ?>
        <?php db_input("iddocumento", 30, 0, true, "hidden", 1); ?>

        <table class="form-container">

          <tr>
            <td>
              <?php db_ancora("Termo: ", "js_pesquisatermo(true);", $iOpcaoLicitacao); ?>
            </td>
            <td>
              <?php
              db_input('l214_sequencial', 12, $Il214_sequencial, true, 'text', 3, " onChange='js_pesquisatermo(false);'");
              db_input('ac16_objeto', 60, $Iac16_objeto, true, 'text', 3, "");
              ?>
            </td>
          </tr>

          <tr>
            <td>
              <strong>Documento: </strong>
            </td>
            <td>
              <?php db_input("uploadfile", 53, 0, true, "file", 1); ?>
            </td>
          </tr>

          <tr>
            <td nowrap title="<?= @$Tl213_sequencial ?>">
              <b>
                Tipo de Documento:
              </b>
            </td>
            <td>
                <?php
                $aTipoAnexos = array(
                            0 => 'Selecione',
                            13 => 'Termo de Rescisão',
                            14 => 'Termo Aditivo',
                            15 => 'Termo de Apostilamento',
                            17 => 'Nota de Empenho'
                        );
                db_select('ac56_tipoanexo', $aTipoAnexos, true, $db_opcao, " onchange=''");
                ?>
            </td>
          </tr>
          <div id='anexo' style='display:none'></div>
        </table>
      </form>
    </fieldset>

    <input type="button" id="btnSalvar" onClick="js_salvarDocumento();" value="Salvar" />
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

  const oGridDocumentos = new DBGrid('gridDocumentos');

  oGridDocumentos.nameInstance = "oGridDocumentos";
  oGridDocumentos.setCheckbox(0);
  oGridDocumentos.setCellAlign(["center", "center", "center"]);
  oGridDocumentos.setCellWidth(["30%", "30%", "30%"]);
  oGridDocumentos.setHeader(["Código", "Tipo", "Ação"]);
  oGridDocumentos.allowSelectColumns(true);
  oGridDocumentos.show($('ctnDbGridDocumentos'));

  function js_pesquisatermo(mostra){
    if(mostra===true){
      js_OpenJanelaIframe('CurrentWindow.corpo',
      'db_iframe_acocontroletermospncp',
      'func_pesquisatermospncp.php?pesquisa=true&funcao_js=parent.js_preencheTermos|l214_sequencial|ac16_objeto',
      'Pesquisa Termos',true);
    }else{
      js_OpenJanelaIframe('CurrentWindow.corpo',
      'db_iframe_acocontroletermospncp',
      'func_pesquisatermospncp.php?pesquisa=true&pesquisa_chave='+
      document.form.l214_sequencial.value+'&funcao_js=parent.js_preencheTermos2',
      'Pesquisa',false);
    }
  }

  function js_preencheTermos(l214_sequencial,ac16_objeto){
    document.form.l214_sequencial.value = l214_sequencial;
    document.form.ac16_objeto.value = ac16_objeto;
    db_iframe_acocontroletermospncp.hide();
    js_getAnexo();
  }

  /**
  * Cria um listener para subir a imagem, e criar um preview da mesma
  */
  $("uploadfile").observe('change', function() {
      startLoading();
      let iFrame = document.createElement("iframe");
      iFrame.src = 'func_uploadtermos.php?clone=form';
      iFrame.id  = 'uploadIframe';
      $('anexo').appendChild(iFrame);
  });

  function startLoading() {
      js_divCarregando('Aguarde... Enviando documento.', 'msgbox');
  }

  function endLoading() {
      js_removeObj('msgbox');
  }

  function js_getAnexo() {
    let oParam        = {};
    oParam.exec       = 'getAnexos';
    oParam.sequencial = $F('l214_sequencial');
    js_divCarregando('Aguarde... Carregando Foto','msgbox');
    let oAjax         = new Ajax.Request(
        'con1_anexostermos.RPC.php',
        { parameters: 'json='+Object.toJSON(oParam),
            asynchronous:false,
            method: 'post',
            onComplete : js_retornoGetAnexo
        });
  }

  function js_retornoGetAnexo(oAjax) {
    js_removeObj("msgbox");
    let oRetorno = eval('('+oAjax.responseText+")");
    oGridDocumentos.clearAll(true);

    if (oRetorno.dados.length === 0) {
        return false;
    }
    oRetorno.dados.each(function (oDocumento, iSeq) {
        let aLinha = [];
        aLinha[0]  = oDocumento.iCodigo;
        aLinha[1]  = oDocumento.sTipo.urlDecode();
        aLinha[2]  = '<input type="button" value="E" onclick="js_excluirAnexo('+oDocumento.iCodigo+')"><input type="button" value="Download" onclick="js_DownloadAnexo('+oDocumento.iCodigo+')">';
        oGridDocumentos.addRow(aLinha);
    });
    oGridDocumentos.renderRows();
  }

  function js_salvarDocumento() {
    if ($F('ac56_tipoanexo') === 0) {
      alert('Selecione o tipo de anexo!');
      return false;
    }
    let oParam        = {};
    oParam.exec       = 'salvarDocumento';
    oParam.sequencial = $F('l214_sequencial');
    oParam.tipoanexo  = $F('ac56_tipoanexo');
    oParam.arquivo    = $F('namefile');
    js_divCarregando('Aguarde... Salvando Documento','msgbox');
    let oAjax         = new Ajax.Request('con1_anexostermos.RPC.php',{
              parameters: 'json='+Object.toJSON(oParam),
              method: 'post',
              asynchronous:false,
              onComplete : js_retornoSalvarFoto
          });
  }

  function js_retornoSalvarFoto(oAjax) {
    js_removeObj("msgbox");
    let oRetorno = eval('('+oAjax.responseText+")");
    if (oRetorno.status === 1) {
        $('uploadfile').value     = '';
        js_getAnexo();
    } else {
        alert(oRetorno.message.urlDecode());
    }
  }

  function js_excluirAnexo(iCodigoDocumento) {

    if (!confirm('Confirma a Exclusão do Documento?')) {
      return false;
    }

    let oParam             = {};
    oParam.exec            = 'excluirAnexo';
    oParam.codAnexo = iCodigoDocumento;
    js_divCarregando('Aguarde... excluindo foto','msgbox');
    let oAjax        = new Ajax.Request(
      'con1_anexostermos.RPC.php',
      { asynchronous:false,
        parameters: 'json='+Object.toJSON(oParam),
        method: 'post',
        onComplete : js_retornoexcuirAnexo
    });
  }

  function js_retornoexcuirAnexo(oAjax) {
    js_removeObj("msgbox");
    let oRetorno = eval('('+oAjax.responseText+")");

    if (oRetorno.status === 2) {
      alert(oRetorno.message);
    }else {
      alert("Anexo excluido com Sucesso !");
      js_getAnexo();
    }
  }

  function js_DownloadAnexo(iCodigo) {
    if (!confirm('Deseja realizar o Download do Documento?')) {
      return false;
    }
    let oParam             = {};
    oParam.exec            = 'downloadDocumento';
    oParam.codAnexo        = iCodigo;
    js_divCarregando('Aguarde... realizando Download do documento','msgbox');
    let oAjax        = new Ajax.Request(
      'con1_anexostermos.RPC.php',
      { asynchronous:false,
        parameters: 'json='+Object.toJSON(oParam),
        method: 'post',
        onComplete : js_downloadDocumento
      });
  }

  function js_downloadDocumento(oAjax) {

    js_removeObj("msgbox");
    let oRetorno = eval('('+oAjax.responseText+")");
    if (oRetorno.status === 2) {
      alert("Não foi possivel carregar o documento:\n "+ oRetorno.message);
    }
    window.open("db_download.php?arquivo="+oRetorno.nomearquivo);
  }

  function js_enviarDocumentoPNCP() {

      const documentosSelecionados = oGridDocumentos.getSelection("object")
      let iSelecionados = documentosSelecionados.length;
      let iCodigoTermo = $('l214_sequencial').value;
      let aDocumentos = [];

      if (iSelecionados === 0) {
          alert('Selecione pelo menos arquivo para Enviar')
          return false
      }

      if (!confirm('Confirma o Envio do Documento?')) {
          return false;
      }

      if (empty(iCodigoTermo)) {
          alert('Termo não informado.');
          return false;
      }

      for (let iIndice = 0; iIndice < iSelecionados; iIndice++) {

          let iDocumento = documentosSelecionados[iIndice].aCells[0].getValue();
          aDocumentos.push(iDocumento);

      }

      js_divCarregando('Aguarde... Enviando documentos!', 'msgbox');

      let oParametros = {};

      oParametros.exec = 'EnviarDocumentoPNCP';
      oParametros.iCodigoTermo = iCodigoTermo;
      oParametros.aDocumentos = aDocumentos;

      let oAjax = new Ajax.Request(
          'con1_envioanexostermos.RPC.php', {
              parameters: 'json=' + Object.toJSON(oParametros),
              method: 'post',
              asynchronous: false,

              /**
               *
               * Retorno do RPC
               */
              onComplete: function(oAjax) {

                  js_removeObj("msgbox");
                  let oRetorno = eval('(' + oAjax.responseText + ")");
                  console.log(oRetorno);
                  if (oRetorno.status === 1) {
                      alert("Anexo(s) Enviado(s) com Sucesso!");
                  } else {
                      alert(oRetorno.message.urlDecode());
                  }
              }
          });

  }

  function js_excluirDocumentoPNCP(){

      const documentosSelecionados = oGridDocumentos.getSelection("object")
      var iSelecionados = documentosSelecionados.length;
      var iCodigoTermo = $('l214_sequencial').value;
      var aDocumentos = [];

      if (iSelecionados== 0) {
          alert('Selecione pelo menos um arquivo para Excluir')
          return false
      }

      if (!confirm('Confirma a Exclusão do Documento?')) {
          return false;
      }

      if (empty(iCodigoTermo)) {
          alert('Termo não informado.');
          return false;
      }

      for (let iIndice = 0; iIndice < iSelecionados; iIndice++) {
          let iDocumento = documentosSelecionados[iIndice].aCells[0].getValue();
          aDocumentos.push(iDocumento);
      }

      js_divCarregando('Aguarde... Excluindo documentos!', 'msgbox');

      let oParametros = {}

      oParametros.exec = 'ExcluirDocumentoPNCP';
      oParametros.iCodigoTermo = iCodigoTermo;
      oParametros.aDocumentos = aDocumentos;

      let oAjax = new Ajax.Request(
          'con1_envioanexostermos.RPC.php', {
              parameters: 'json=' + Object.toJSON(oParametros),
              method: 'post',
              asynchronous: false,

              /**
               *
               * Retorno do RPC
               */
              onComplete: function(oAjax) {

                  js_removeObj("msgbox");
                  let oRetorno = eval('(' + oAjax.responseText + ")");
                  let sMensagem = oRetorno.message.urlDecode();
                  let status = oRetorno.status;
                  for (let cont = 0; cont <= oRetorno.length; cont++) {
                      document.write(oRetorno[cont] + "<br>");
                  }
                  if (oRetorno.status == 2) {
                      alert(sMensagem);
                      return false;
                  }
                  alert("Documento(s) Excluido(s) com Sucesso do PNCP!");

              }
          });

  }
</script>