<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
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
require_once("libs/db_app.utils.php");
require_once("dbforms/db_funcoes.php");

$protocolosigiloso = db_query("select * from protparam");
$protocolosigiloso = db_utils::fieldsMemory($protocolosigiloso, 0);

if ($protocolosigiloso->p90_protocolosigiloso == "f") {
  require_once("prot4_processodocumentoantigo001.php");
  exit;
}


$departamento  = db_getsession('DB_coddepto', false);
$iInstit     = db_getsession('DB_instit');
$adm = db_getsession('DB_administrador');
$iOpcaoProcesso = 1;
$lExibirMenus   = true;

$oGet = db_utils::postMemory($_GET);

/**
 * Codigo do precesso informado por GET
 * - Pesquisa numero e ano do processo
 */
if (!empty($oGet->iCodigoProcesso)) {

  $iOpcaoProcesso = 3;
  $lExibirMenus   = false;

  $oDaoProtprocesso = db_utils::getDao('protprocesso');
  $sSqlNumeroProcesso = $oDaoProtprocesso->sql_query_file($oGet->iCodigoProcesso, 'p58_numero, p58_ano');
  $rsNumeroProcesso = $oDaoProtprocesso->sql_record($sSqlNumeroProcesso);

  if ($oDaoProtprocesso->numrows > 0) {

    $oDaoProcesso = db_utils::fieldsMemory($rsNumeroProcesso, 0);
    $p58_numero = $oDaoProcesso->p58_numero . '/' . $oDaoProcesso->p58_ano;
  }
}

$oRotulo  = new rotulocampo;
$oDaoProtprocessodocumento = db_utils::getDao('protprocessodocumento');
$oDaoProtprocessodocumento->rotulo->label();

$oRotulo->label("p58_numero");
$oRotulo->label("z01_nome");

$allpermissoes = array();

$rsAllPermissoes = db_query("select * from permanexo;");
for ($i = 0; $i < pg_numrows($rsAllPermissoes); $i++) {
  $allpermissoes[pg_result($rsAllPermissoes, $i, "p202_sequencial")] = urlencode(pg_result($rsAllPermissoes, $i, "p202_tipo"));
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

  <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/datagrid.widget.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/widgets/windowAux.widget.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbautocomplete.widget.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbmessageBoard.widget.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbtextField.widget.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbtextFieldData.widget.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbcomboBox.widget.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/widgets/DBHint.widget.js"></script>
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

  <div class="container" style="width:650px;">

    <fieldset>
      <legend>Anexar Documentos aos Processos</legend>
      <form name="form" id="form" method="post" action="" enctype="multipart/form-data">


        <?php db_input("namefile", 30, 0, true, "hidden", 1); ?>
        <?php db_input("p01_sequencial", 30, 0, true, "hidden", 1); ?>
        <?php db_input("p58_codproc", 30, 0, true, "hidden", 1); ?>

        <table class="form-container">

          <tr>
            <td nowrap title="<?php echo $Tp01_protprocesso; ?>">
              <?php db_ancora($Lp58_numero, "js_pesquisarProcesso(true);", $iOpcaoProcesso); ?>
            </td>
            <td>
              <?php
              db_input('p58_numero', 12, $Ip58_numero, true, 'text', $iOpcaoProcesso, " onChange='js_pesquisarProcesso(false);'");
              db_input('z01_nome', 60, $Iz01_nome, true, 'text', 3, "");
              ?>
            </td>
          </tr>

          <tr>
            <td nowrap title="<?php echo $Tp01_documento; ?>">
              <?php echo $Lp01_documento; ?>
            </td>
            <td>
              <?php db_input("uploadfile", 53, 0, true, "file", 1); ?>
            </td>
          </tr>

          <tr>
            <td>
              Nível de Acesso:
            </td>
            <td>
              <?

              if ($adm == 1) {
                $rsPermissoes = db_query("select distinct p203_permanexo,p202_sequencial,p202_tipo  from perfispermanexo
                inner join db_permherda p203_perfil on p203_perfil = id_perfil
                inner join permanexo  p203_permanexo on p203_permanexo  = p202_sequencial order by p203_permanexo; 
               ");
                $numrows = pg_numrows($rsPermissoes);
              } else {
                $usuario = db_getsession('DB_id_usuario');
                $rsPermissoes = db_query("select distinct p203_permanexo,p202_sequencial,p202_tipo  from perfispermanexo
                inner join db_permherda p203_perfil on p203_perfil = id_perfil
                inner join permanexo  p203_permanexo on p203_permanexo  = p202_sequencial where id_usuario = $usuario or p202_sequencial = 1 order by p202_sequencial; 
               ");
                $numrows = pg_numrows($rsPermissoes);
              }



              for ($i = 0; $i < $numrows; $i++) {
                $permissoes[pg_result($rsPermissoes, $i, "p202_sequencial")] = pg_result($rsPermissoes, $i, "p202_tipo");
              }


              db_select(
                'p01_nivelacesso',
                $permissoes,
                true,
                $db_opcao,
                "style='width:48%;'"
              );

              ?>
            </td>
          </tr>

          <tr>
            <td nowrap title="<?php echo $Tp01_descricao; ?>">
              <?php echo $Lp01_descricao; ?>
            </td>
            <td>
              <?php db_input("p01_descricao", 50, 0, true, "text", 1, "class='field-size-max'"); ?>
            </td>
          </tr>

        </table>
      </form>
    </fieldset>

    <input type="button" id="btnSalvar" value="Salvar" onClick="js_salvar();" />

    <fieldset style="margin-top:15px;">
      <legend>Documentos Anexados</legend>
      <div id="ctnDbGridDocumentos"></div>
    </fieldset>

    <input type="button" id="btnExcluir" value="Excluir Selecionados" onClick="js_excluirSelecionados();" />
    <input type="button" id="btnDownloadAnexos" value="Download Anexos" onClick="js_downloadAnexos();" />

  </div>

  <?php if ($lExibirMenus) : ?>
    <?php db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit")); ?>
  <?php endif; ?>

  <div id="teste" style="display:none;"></div>
</body>

</html>
<script type="text/javascript">
  var descricaoDocumento = "";
  var protocolosComPermissaoParaDownload = new Map();




  /**
   * Inserindo ID nos options do select de nível de acesso
   */

  var select = document.getElementById('p01_nivelacesso');
  for (var i = 0; i < select.options.length; i++) {
    var value = select.options[i].value;
    select.options[i].setAttribute("id", value);
  }

  /**
   * Criação de variavel para armazenamento dos niveis de acesso que o usuário possui permissão
   */
  const niveisdeacesso = document.getElementById('p01_nivelacesso').innerHTML;


  /**
   * Pesquisa processo do protocolo e depois os documentos anexados
   */
  if (!empty($('p58_numero').value)) {
    js_pesquisarProcesso(false);
  }

  /**
   * Mensagens do programa
   * @type constant
   */
  const MENSAGENS = 'patrimonial.protocolo.prot4_processodocumento001.';

  var sUrlRpc = 'prot4_processodocumento.RPC.php';

  var oGridDocumentos = new DBGrid('gridDocumentos');

  oGridDocumentos.nameInstance = "oGridDocumentos";
  oGridDocumentos.setCheckbox(0);
  oGridDocumentos.setCellAlign(new Array("center", "left", "left", "center"));
  oGridDocumentos.setCellWidth(["10%", "20%", "30%", "40%"]);
  oGridDocumentos.setHeader(new Array("Código", "Descrição", "Departamento", "Ação"));
  oGridDocumentos.allowSelectColumns(true);
  oGridDocumentos.show($('ctnDbGridDocumentos'));
  var anexosSigilosos = new Array();
  var protocolosComPermissaoParaExclusao = new Array();


  /**
   * Buscar documentos do processo
   * @return boolean
   */
  function js_buscarDocumentos() {

    var departamentoLogado = <?php print_r($departamento) ?>;
    var adm = <?php print_r($adm) ?>;
    var iCodigoProcesso = $('p58_codproc').value;
    anexosSigilosos = new Array();

    if (empty(iCodigoProcesso)) {
      return false;
    }

    js_divCarregando(_M(MENSAGENS + 'mensagem_buscando_documentos'), 'msgbox');

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
            var sDescricaoDocumento = oDocumento.sDescricaoDocumento;
            var sHTMLBotoes = '';
            if(departamentoLogado == oDocumento.iDepart){
                protocolosComPermissaoParaExclusao.push(iIndice);
            }

            if (oDocumento.nivelacesso == '1') {

              sHTMLBotoes += '<input type="button"  value="Alterar Acesso" onClick="js_alterarNivelAcessoDocumento(' + oDocumento.iCodigoDocumento + ', \'' + sDescricaoDocumento + '\' , \'' + oDocumento.nivelacesso + '\' );" />  ';
              sHTMLBotoes += '<input type="button"  value="Alterar" onClick="js_alterarDocumento(' + oDocumento.iCodigoDocumento + ', \'' + sDescricaoDocumento + '\' , \'' + oDocumento.nivelacesso + '\' );" />  ';
              sHTMLBotoes += '<input type="button" value="Download" onClick="js_downloadDocumento(' + oDocumento.iCodigoDocumento + ');" />  ';

              protocolosComPermissaoParaDownload.set(oDocumento.iCodigoDocumento, true);
              
            } else {

              anexosSigilosos.push(iIndice);


              if (adm == 1) {

                sHTMLBotoes += '<input type="button"  value="Alterar Acesso" onClick="js_alterarNivelAcessoDocumento(' + oDocumento.iCodigoDocumento + ', \'' + sDescricaoDocumento + '\' , \'' + oDocumento.nivelacesso + '\' );" />  ';
                sHTMLBotoes += '<input type="button"  value="Alterar" onClick="js_alterarDocumento(' + oDocumento.iCodigoDocumento + ', \'' + sDescricaoDocumento + '\' , \'' + oDocumento.nivelacesso + '\' );" />  ';
                sHTMLBotoes += '<input type="button" value="Download" onClick="js_downloadDocumento(' + oDocumento.iCodigoDocumento + ');" />  ';
                protocolosComPermissaoParaDownload.set(oDocumento.iCodigoDocumento, true);
              } else if (departamentoLogado == oDocumento.iDepart && adm != 1 && !oDocumento.permissao) {
                sHTMLBotoes += '<input type="button"  value="Alterar" onClick="js_alterarDocumento(' + oDocumento.iCodigoDocumento + ', \'' + sDescricaoDocumento + '\' , \'' + oDocumento.nivelacesso + '\' );" />  ';
                protocolosComPermissaoParaDownload.set(oDocumento.iCodigoDocumento, false);
              } else if (departamentoLogado == oDocumento.iDepart && adm != 1 && oDocumento.permissao) {
                sHTMLBotoes += '<input type="button"  value="Alterar" onClick="js_alterarDocumento(' + oDocumento.iCodigoDocumento + ', \'' + sDescricaoDocumento + '\' , \'' + oDocumento.nivelacesso + '\' );" />  ';
                sHTMLBotoes += '<input type="button" value="Download" onClick="js_downloadDocumento(' + oDocumento.iCodigoDocumento + ');" />  ';
                protocolosComPermissaoParaDownload.set(oDocumento.iCodigoDocumento, true);
              } else if (departamentoLogado != oDocumento.iDepart && adm != 1 && oDocumento.permissao) {
                sHTMLBotoes += '<input type="button" value="Download" onClick="js_downloadDocumento(' + oDocumento.iCodigoDocumento + ');" />  ';
                protocolosComPermissaoParaDownload.set(oDocumento.iCodigoDocumento, true);
              } else if (departamentoLogado != oDocumento.iDepart && adm != 1 && !oDocumento.permissao) {
                sHTMLBotoes += '<input type="button" value="Detalhes" onClick="js_detalhes(' + oDocumento.iCodigoDocumento + ', \'' + sDescricaoDocumento + '\' , \'' + oDocumento.nivelacesso + '\');" />  ';
                protocolosComPermissaoParaDownload.set(oDocumento.iCodigoDocumento, false);
              }


            }

            var aLinha = [oDocumento.iCodigoDocumento, sDescricaoDocumento.urlDecode(), oDocumento.iDepart + ' - ' + oDocumento.sDepartamento.urlDecode(), sHTMLBotoes];
            oGridDocumentos.addRow(aLinha, false, false);

          }


          oGridDocumentos.renderRows();

          for (var iIndice = iDocumentos; iIndice > 0; iIndice--) {
            var oDocumento = oRetorno.aDocumentosVinculados[iIndice - 1];
            var sDescricaoDocumento = oDocumento.sDescricaoDocumento;
            idLinha = `gridDocumentosrow${iIndice-1}cell1`;
            linha = document.getElementById(idLinha);
            linha.setAttribute("title", sDescricaoDocumento.urlDecode());
            idLinha = `gridDocumentosrow${iIndice-1}cell2`;
            linha = document.getElementById(idLinha);
            linha.setAttribute("title", oDocumento.iDepart + ' - ' + oDocumento.sDepartamento.urlDecode());
          }



          for (var i = 0; i < anexosSigilosos.length; i++) {
            linhaAnexo = anexosSigilosos[i];
            document.getElementById('gridDocumentosrowgridDocumentos' + linhaAnexo).style.color = "red";

          }

          document.getElementById('p01_nivelacesso').innerHTML = niveisdeacesso;

        }
      }
    );

  }

  /**
   * Exclui documentos selecionados
   * @return boolean
   */
  function js_excluirSelecionados() {

    var documentosSelecionados = oGridDocumentos.getSelection("object");
    var iSelecionados = documentosSelecionados.length;
    var iCodigoProcesso = $('p58_codproc').value;
    var aDocumentos = [];

    for (var iIndice = 0; iIndice < iSelecionados; iIndice++) {
      if (protocolosComPermissaoParaExclusao.includes(documentosSelecionados[iIndice].getRowNumber()) != true) {
        alert("Usuário sem permissão para excluir documento selecionado.");
        return false;
      }
    }

    if (iSelecionados == 0) {

      alert(_M(MENSAGENS + 'erro_nenhum_documento_selecionado_exclusao'));
      return false;
    }

    if (empty(iCodigoProcesso)) {

      alert(_M(MENSAGENS + 'erro_processo_nao_informado'));
      return false;
    }

    for (var iIndice = 0; iIndice < iSelecionados; iIndice++) {

      var iDocumento = documentosSelecionados[iIndice].aCells[0].getValue();
      aDocumentos.push(iDocumento);
    }

    js_divCarregando(_M(MENSAGENS + 'mensagem_excluindo_documentos'), 'msgbox');

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
      novoTituloDeArquivo = documento.sCaminhoDownloadArquivo.replace('tmp/', '')
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
   * Realiza o download de todos os anexos ou apenas selecionados
   * @return boolean
   */
  const js_downloadAnexos = () => {

    js_divCarregando('Aguarde... Organizando documentos para o download', 'msgbox')
    const iCodigoProcesso = $('p58_codproc').value

    if (empty(iCodigoProcesso)) {
      return false
    }

    const documentosSelecionados = oGridDocumentos.getSelection("object")
    let codigosDosDocumentos = []

    for (documento of documentosSelecionados) {
      const codigoDoDocumento = documento.aCells[0].getValue()
      codigosDosDocumentos.push(codigoDoDocumento)
    }

    if (codigosDosDocumentos.length == '1') {
      if (protocolosComPermissaoParaDownload.get(codigosDosDocumentos[0]) == true) {
        js_downloadDocumento(codigosDosDocumentos[0])
        js_removeObj("msgbox");
        return false;
      } else {
        alert('Sem permissão para fazer o download do documento selecionado');
        js_removeObj("msgbox");
        return false;
      }

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
      if (protocolosComPermissaoParaDownload.get(codigoDoDocumento) == true) {
        urlDosArquivos.push(js_arquivos(oCodigoDocumento))

      }
    })

    js_ziparAnexos(urlDosArquivos, nomeDoZip => {
      js_removeObj("msgbox")
      window.open(`db_download.php?arquivo=${nomeDoZip}`)

      setTimeout(() => {
        js_apagarZip(nomeDoZip)
      }, 3000)
    });

  }

  /**
   * Altera descricao de um documento
   * @param integer iCodigoDocumento
   * @param string sDescricaoDocumento
   * @return void
   */
  function js_alterarNivelAcessoDocumento(iCodigoDocumento, sDescricaoDocumento, nivelAcesso) {
    $('btnSalvar').disabled = false;
    $('namefile').value = '';
    $('uploadfile').value = '';
    $('uploadfile').disabled = true;
    $('p01_descricao').value = sDescricaoDocumento.urlDecode();

    document.getElementById('p01_nivelacesso').innerHTML = niveisdeacesso;

    descricaoDocumento = sDescricaoDocumento;
    var select = document.querySelector('#p01_nivelacesso');
    for (var i = 0; i < select.options.length; i++) {
      if (select.options[i].value == nivelAcesso) {
        select.selectedIndex = i;
        break;
      }
    }

    $('p01_descricao').disabled = true;
    $('p01_nivelacesso').disabled = false;


    /**
     * Altera acao do botao salvar
     * @return void
     */
    $('btnSalvar').onclick = function() {

      var iCodigoProcesso = $('p58_codproc').value;
      var sDescricaoDocumento = encodeURIComponent(tagString($('p01_descricao').value));
      var iNivelAcesso = $('p01_nivelacesso').value;

      var oParam = new Object();

      if (empty(iCodigoProcesso)) {

        alert(_M(MENSAGENS + 'erro_processo_nao_informado'));
        return false;
      }
      /*
      if (empty(sDescricaoDocumento)) {

        alert(_M(MENSAGENS + 'erro_descricao_nao_informada'));
        return false;
      }
      */

      js_divCarregando(_M(MENSAGENS + 'mensagem_salvando_documento'), 'msgbox');

      oParam.exec = 'salvarDocumento';
      oParam.iCodigoDocumento = iCodigoDocumento;
      oParam.iCodigoProcesso = iCodigoProcesso;
      oParam.sDescricaoDocumento = sDescricaoDocumento;
      oParam.iNivelAcesso = iNivelAcesso;


      var oAjax = new Ajax.Request(
        sUrlRpc, {
          parameters: 'json=' + Object.toJSON(oParam),
          method: 'post',
          asynchronous: false,
          onComplete: function(oAjax) {

            js_removeObj("msgbox");
            var oRetorno = eval('(' + oAjax.responseText + ")");
            var sMensagem = oRetorno.sMensagem.urlDecode();

            if (oRetorno.iStatus > 1) {
              document.getElementById('p01_nivelacesso').innerHTML = niveisdeacesso;
              alert(sMensagem);
              return false;
            }

            $('btnSalvar').onclick = js_salvar;
            $('namefile').value = '';
            $('uploadfile').value = '';
            $('uploadfile').disabled = false;
            $('p01_descricao').value = '';

            alert(sMensagem);
            js_buscarDocumentos();
          }
        });

      $('p01_descricao').disabled = false;
      $('p01_nivelacesso').disabled = false;



    }
  }

  function js_detalhes(iCodigoDocumento, sDescricaoDocumento, nivelAcesso) {
    $('p01_descricao').value = sDescricaoDocumento.urlDecode();
    var select = document.querySelector('#p01_nivelacesso');
    for (var i = 0; i < select.options.length; i++) {
      if (select.options[i].value == nivelAcesso) {
        select.selectedIndex = i;
        break;
      }
    }

    var permissoes = <?= json_encode($allpermissoes); ?>;

    var selectnivelacesso = document.querySelector('#p01_nivelacesso');
    selectnivelacesso.options[select.options.length] = new Option(permissoes[nivelAcesso].urlDecode(), nivelAcesso);
    document.getElementById("p01_nivelacesso").value = nivelAcesso;

    $('p01_descricao').disabled = true;
    $('p01_nivelacesso').disabled = true;
    $('btnSalvar').disabled = true;


  }



  /**
   * Altera descricao de um documento
   * @param integer iCodigoDocumento
   * @param string sDescricaoDocumento
   * @return void
   */
  function js_alterarDocumento(iCodigoDocumento, sDescricaoDocumento, nivelAcesso) {
    $('btnSalvar').disabled = false;
    $('namefile').value = '';
    $('uploadfile').value = '';
    $('uploadfile').disabled = true;
    $('p01_descricao').value = sDescricaoDocumento.urlDecode();
    var select = document.querySelector('#p01_nivelacesso');
    for (var i = 0; i < select.options.length; i++) {
      if (select.options[i].value == nivelAcesso) {
        select.selectedIndex = i;
        break;
      }
    }

    var permissoes = <?= json_encode($allpermissoes); ?>;
    var selectnivelacesso = document.querySelector('#p01_nivelacesso');
    selectnivelacesso.options[select.options.length] = new Option(permissoes[nivelAcesso].urlDecode(), nivelAcesso);
    document.getElementById("p01_nivelacesso").value = nivelAcesso;

    $('p01_descricao').disabled = false;
    $('p01_nivelacesso').disabled = true;


    /**
     * Altera acao do botao salvar
     * @return void
     */
    $('btnSalvar').onclick = function() {

      var iCodigoProcesso = $('p58_codproc').value;
      var sDescricaoDocumento = encodeURIComponent(tagString($('p01_descricao').value));
      var iNivelAcesso = $('p01_nivelacesso').value;

      var oParam = new Object();

      if (empty(iCodigoProcesso)) {

        alert(_M(MENSAGENS + 'erro_processo_nao_informado'));
        return false;
      }

      if (empty(sDescricaoDocumento)) {

        alert(_M(MENSAGENS + 'erro_descricao_nao_informada'));
        return false;
      }

      js_divCarregando(_M(MENSAGENS + 'mensagem_salvando_documento'), 'msgbox');

      oParam.exec = 'salvarDocumento';
      oParam.iCodigoDocumento = iCodigoDocumento;
      oParam.iCodigoProcesso = iCodigoProcesso;
      oParam.sDescricaoDocumento = sDescricaoDocumento;
      oParam.iNivelAcesso = iNivelAcesso;


      var oAjax = new Ajax.Request(
        sUrlRpc, {
          parameters: 'json=' + Object.toJSON(oParam),
          method: 'post',
          asynchronous: false,
          onComplete: function(oAjax) {

            js_removeObj("msgbox");
            var oRetorno = eval('(' + oAjax.responseText + ")");
            var sMensagem = oRetorno.sMensagem.urlDecode();

            if (oRetorno.iStatus > 1) {
              document.getElementById('p01_nivelacesso').innerHTML = niveisdeacesso;
              alert(sMensagem);
              return false;
            }

            $('btnSalvar').onclick = js_salvar;
            $('namefile').value = '';
            $('uploadfile').value = '';
            $('uploadfile').disabled = false;
            $('p01_descricao').value = '';

            alert(sMensagem);
            js_buscarDocumentos();
          }
        });

      $('p01_descricao').disabled = false;
      $('p01_nivelacesso').disabled = false;

    }
  }

  /**
   * Download de um documento
   * - busca arquivo do banco e salva no tmp
   * - exibe janela com link para download
   * @param  integer iCodigoDocumento
   * @return void
   */
  function js_downloadDocumento(iCodigoDocumento) {

    js_divCarregando(_M(MENSAGENS + 'mensagem_carregando_documento'), 'msgbox');

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
   * Pesquisar processo
   *
   * @param boolean lMostra
   * @return boolean
   */
  function js_pesquisarProcesso(lMostra) {

    var sArquivo = 'func_protprocesso_protocolo.php?funcao_js=parent.';

    if (lMostra) {
      sArquivo += 'js_mostraProcesso|p58_codproc|p58_numero|dl_nome_ou_razão_social';
    } else {

      var iNumeroProcesso = $('p58_numero').value;

      if (empty(iNumeroProcesso)) {
        return false;
      }

      sArquivo += 'js_mostraProcessoHidden&pesquisa_chave=' + iNumeroProcesso + '&sCampoRetorno=p58_codproc';
    }

    js_OpenJanelaIframe('', 'db_iframe_proc', sArquivo, 'Pesquisa de Processos', lMostra);
  }

  /**
   * Retorno da js_pesquisarProcesso apor clicar em um processo
   * @param  integer iCodigoProcesso
   * @param  integer iNumeroProcesso
   * @param  string sNome
   * @return void
   */
  function js_mostraProcesso(iCodigoProcesso, iNumeroProcesso, sNome) {
    $('btnSalvar').disabled = false;
    $('p01_descricao').disabled = false;
    $('p01_nivelacesso').disabled = false;
    $('p01_nivelacesso').value = "1";
    $('p58_codproc').value = iCodigoProcesso;
    $('p58_numero').value = iNumeroProcesso;
    $('z01_nome').value = sNome;
    $('p01_descricao').value = '';
    $('uploadfile').disabled = false;
    db_iframe_proc.hide();
    js_buscarDocumentos();
  }

  /**
   * Retorno da pesquisa js_pesquisarProcesso apos mudar o campo p58_numero
   * @param  integer iCodigoProcesso
   * @param  string sNome
   * @param  boolean lErro
   * @return void
   */
  function js_mostraProcessoHidden(iCodigoProcesso, sNome, lErro) {

    /**
     * Nao encontrou processo
     */
    if (lErro) {

      $('p58_numero').value = '';
      $('p58_codproc').value = '';
      $('p01_descricao').value = '';
      $('uploadfile').disabled = false;
      oGridDocumentos.clearAll(true);
    }

    $('p01_descricao').disabled = false;
    $('p01_nivelacesso').disabled = false;
    $('p01_nivelacesso').value = "1";
    $('btnSalvar').disabled = false;


    $('p58_codproc').value = iCodigoProcesso;
    $('z01_nome').value = sNome;
    js_buscarDocumentos();
  }

  /**
   * Cria um listener para subir a imagem, e criar um preview da mesma
   */
  $("uploadfile").onchange = function() {

    startLoading();
    var iFrame = document.createElement("iframe");
    iFrame.src = 'func_uploadfiledocumento.php?clone=form';
    iFrame.id = 'uploadIframe';
    $('teste').appendChild(iFrame);
  }

  function startLoading() {
    js_divCarregando(_M(MENSAGENS + 'mensagem_enviando_documento'), 'msgbox');
  }

  function endLoading() {
    js_removeObj('msgbox');
  }

  function js_salvar() {

    var iCodigoProcesso = $('p58_codproc').value;
    var iCodigoDocumento = $('p01_sequencial').value;
    var sDescricaoDocumento = encodeURIComponent(tagString($('p01_descricao').value));

    var sCaminhoArquivo = $('namefile').value;
    var iNivelAcesso = $('p01_nivelacesso').value;


    if (empty(iCodigoProcesso)) {

      alert(_M(MENSAGENS + 'erro_processo_nao_informado'));
      return false;
    }

    if (empty(sDescricaoDocumento)) {

      alert(_M(MENSAGENS + 'erro_descricao_nao_informada'));
      return false;
    }

    if (empty(sCaminhoArquivo)) {

      alert(_M(MENSAGENS + 'erro_documento_nao_informado'));
      return false;
    }

    //js_divCarregando(_M(MENSAGENS + 'mensagem_salvando_documento'), 'msgbox');

    var oParametros = new Object();

    oParametros.exec = 'salvarDocumento';
    oParametros.iCodigoDocumento = iCodigoDocumento;
    oParametros.iCodigoProcesso = iCodigoProcesso;
    oParametros.sDescricaoDocumento = sDescricaoDocumento;
    oParametros.sCaminhoArquivo = sCaminhoArquivo;
    oParametros.iNivelAcesso = iNivelAcesso;

    var oAjax = new Ajax.Request(
      sUrlRpc, {
        parameters: 'json=' + Object.toJSON(oParametros),
        method: 'post',
        asynchronous: false,
        onComplete: function(oAjax) {

          //js_removeObj("msgbox");
          var oRetorno = eval('(' + oAjax.responseText + ")");

          var sMensagem = oRetorno.sMensagem.urlDecode();

          if (oRetorno.iStatus > 1) {
            document.getElementById('p01_nivelacesso').innerHTML = niveisdeacesso;
            alert(sMensagem);
            return false;
          }

          $('namefile').value = '';
          $('uploadfile').value = '';
          $('uploadfile').disabled = false;
          $('p01_descricao').value = '';
          document.querySelector('#p01_nivelacesso').selectedIndex = 0;

          alert(sMensagem);
          js_buscarDocumentos();

        }
      });

  }
</script>