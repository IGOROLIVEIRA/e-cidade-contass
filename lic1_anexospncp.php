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

$iOpcaoLicitacao = 1;
$lExibirMenus   = true;
$cltipoanexo = new cl_tipoanexo;

$oGet = db_utils::postMemory($_GET);

/**
 * Codigo do precesso informado por GET
 * - Pesquisa numero e ano do Licitacao
 */


$oRotulo  = new rotulocampo;
$oDaoLicanexopncpdocumento = db_utils::getDao('licanexopncpdocumento');
$oDaoLicanexopncpdocumento->rotulo->label();

$oRotulo->label("l20_codigo");
$oRotulo->label("l20_objeto");
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


        

        <table class="form-container">

          <tr>
            <td nowrap title="<?php echo $Tl216_licanexospncp; ?>">
              <?php db_ancora("Licitação: ", "js_pesquisarLicitacao(true);", $iOpcaoLicitacao); ?>
            </td>
            <td>
              <?php
              db_input('l20_codigo', 12, $Il20_codigo, true, 'text', $iOpcaoLicitacao, " onChange='js_pesquisarLicitacao(false);'");
              db_input('l20_objeto', 60, $Il20_objeto, true, 'text', 3, "");
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
                                        $result_tipo = $cltipoanexo->sql_record($cltipoanexo->sql_query());
                                        if ($cltipoanexo->numrows == 0) {
                                            db_msgbox("Nenhuma Tipo de anexo cadastrado!!");
                                            $result_tipo = "";
                                            $db_opcao = 3;
                                            $db_botao = false;
                                            db_input("l213_sequencial", 10, "", true, "text");
                                            db_input("l213_sequencial", 40, "", true, "text");
                                        } else {
                                            db_selectrecord("l213_sequencial", @$result_tipo, true, $db_opcao, "js_mostraRegistroPreco()");
                                            if (isset($l213_sequencial) && $l213_sequencial != "") {
                                                echo "<script>document.form1.l213_sequencial.selected=$l213_sequencial;</script>";
                                            }   
                                        }
                                        ?>
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
    <input type="button" id="btnDownloadAnexos" value="Download" onClick="js_downloadAnexos();" />

  </div>

  <?php if ($lExibirMenus) : ?>
    <?php db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit")); ?>
  <?php endif; ?>

  <div id="teste" style="display:none;"></div>
</body>

</html>
<script type="text/javascript">

document.getElementById("l213_sequencial").style.display = "none";
  /**
   * Pesquisa Licitacao do protocolo e depois os documentos anexados
   */
  if (!empty($('l20_codigo').value)) {
    js_pesquisarLicitacao(false);
  }

  /**
   * Mensagens do programa
   * @type constant
   */
  const MENSAGENS = 'patrimonial.licitacao.lic1_anexospncp.';

  var sUrlRpc = 'lic1_anexospncp.RPC.php';

  var oGridDocumentos = new DBGrid('gridDocumentos');

  oGridDocumentos.nameInstance = "oGridDocumentos";
  oGridDocumentos.setCheckbox(0);
  oGridDocumentos.setCellAlign(new Array("center", "center", "center"));
  oGridDocumentos.setCellWidth([ "30%", "30%", "30%"]);
  oGridDocumentos.setHeader(new Array("Código", "Tipo", "Ação"));
  oGridDocumentos.allowSelectColumns(true);
  oGridDocumentos.show($('ctnDbGridDocumentos'));

  /**
   * Pesquisar Licitacao
   *
   * @param boolean lMostra
   * @return boolean
   */
  function js_pesquisarLicitacao(lMostra) {

    var sArquivo = 'func_liclicita.php?situacao=0&lei=1&funcao_js=parent.';

    if (lMostra) {
      sArquivo += 'js_mostraLicitacao|l20_codigo|l20_objeto';
    } else {

      var iNumeroLicitacao = $('l20_codigo').value;

      if (empty(iNumeroLicitacao)) {
        return false;
      }

      sArquivo += 'js_mostraLicitacaoHidden&pesquisa_chave=' + iNumeroLicitacao + '&sCampoRetorno=l20_objeto';
    }

    js_OpenJanelaIframe('', 'db_iframe_proc', sArquivo, 'Pesquisa de Licitação', lMostra);
  }

  /**
   * Retorno da js_pesquisarLicitacao apor clicar em uma Licitacao
   * @param  integer iCodigoLicitacao
   * @param  integer iNumeroLicitacao
   * @param  string descricao
   * @return void
   */
  function js_mostraLicitacao(iCodigoLicitacao, descricao) {

    $('l20_codigo').value = iCodigoLicitacao;
    $('l20_objeto').value = descricao;
    $('uploadfile').disabled = false;
    db_iframe_proc.hide();
    
  }

  /**
   * Retorno da pesquisa js_pesquisarLicitacao apos mudar o campo l20_codigo
   * @param  integer iCodigoLicitacao
   * @param  string descricao
   * @param  boolean lErro
   * @return void
   */
  function js_mostraLicitacaoHidden(iCodigoLicitacao, descricao, lErro) {

    /**
     * Nao encontrou Licitacao
     */
    if (lErro) {

      $('l20_codigo').value = '';
      $('uploadfile').disabled = false;
      oGridDocumentos.clearAll(true);
    }

    $('l20_objeto').value = iCodigoLicitacao;
   
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

    var iCodigoLicitacao = $('l20_codigo').value;
    var iCodigoDocumento = $('l213_sequencial').value;

    if (empty(iCodigoLicitacao)) {

      alert(_M(MENSAGENS + 'erro_Licitacao_nao_informado'));
      return false;
    }


    js_divCarregando(_M(MENSAGENS + 'mensagem_salvando_documento'), 'msgbox');

    var oParametros = new Object();

    oParametros.exec = 'salvarDocumento';
    oParametros.iCodigoDocumento = iCodigoDocumento;
    oParametros.iCodigoLicitacao = iCodigoLicitacao;


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

          $('namefile').value = '';
          $('uploadfile').value = '';
          $('uploadfile').disabled = false;
          $('p01_descricao').value = '';

          alert(sMensagem);
        }
      });
} 
</script>