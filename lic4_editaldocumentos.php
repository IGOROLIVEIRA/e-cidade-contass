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

require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("std/db_stdClass.php");
require_once("libs/db_libdicionario.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("classes/db_caddocumento_classe.php");
require_once("dbforms/db_funcoes.php");

$oGet              = db_utils::postMemory($_GET);
$clCadDocumento = new cl_caddocumento;

$db_opcao          = 22;
$db_botao          = false;

$clrotulo = new rotulocampo;
$clrotulo->label("z06_numcgm");
$clrotulo->label("z01_nome");
$clrotulo->label("db44_descricao");
$aTipos = array();
$codtribunal = $oGet->cod_tribunal;
$natureza_objeto = $oGet->natureza_objeto;
$db_opcao = 1;

?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <meta http-equiv="Expires" CONTENT="0">
  <?php
  db_app::load("scripts.js, prototype.js, widgets/windowAux.widget.js,strings.js");
  db_app::load("widgets/dbtextField.widget.js, dbViewCadEndereco.classe.js");
  db_app::load("dbmessageBoard.widget.js, dbautocomplete.widget.js,dbcomboBox.widget.js, datagrid.widget.js");
  db_app::load("estilos.css,grid.style.css");
  ?>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<div style="margin-top: 10px;"></div>
<form name="form1" id='form1' method="post" action="" enctype="multipart/form-data">
  <center>
    <div style="width: 600px;">
      <fieldset>
        <legend><b>Adicionar Documento:</b></legend>
        <table>
          <tr>
            <td valign="top">
              <b>Documento: </b>
            </td>
            <td valign='top' style="height: 25px;">
              <?php
              db_input("uploadfile",30,0,true,"file",1);
              db_input("namefile",30,0,true,"hidden",1);
              ?>
            </td>
          </tr>
          <tr id='lancaDoc'>
            <td nowrap title="<?=@$Tdb44_descricao?>">
              <b>Tipo:</b>
            </td>
            <td>
              <?
              switch ($codtribunal) {
                case 100:
                case 101:
                case 102:
                case 103:
                case 106:
                  if($natureza_objeto != 1){
                    $aTipos[] = 'Selecione';
                    $aTipos['td'] = 'Termo de Dispensa';
                  }else{
                    $aTipos[] = 'Selecione';
                    $aTipos['dp'] = 'Dispensa';
                    $aTipos['mc'] = 'Minuta do Contrato';
                    $aTipos['po'] = 'Planilha Orçamentária';
                    $aTipos['cr'] = 'Cronograma';
                    $aTipos['cb'] = 'Composição BDI';
                    $aTipos['fl'] = 'Fotos do local';
                  }
                  break;

                default:
                  if($natureza_objeto != 1){
                    $aTipos[] = 'Selecione';
                    $aTipos['ed'] = 'Edital';
                  }else{
                    $aTipos[] = 'Selecione';
					$aTipos['ed'] = 'Edital';
                    $aTipos['mc'] = 'Minuta do Contrato';
                    $aTipos['po'] = 'Planilha Orçamentária';
                    $aTipos['cr'] = 'Cronograma';
                    $aTipos['cb'] = 'Composição BDI';
                    $aTipos['fl'] = 'Fotos do local';
                  }
                  break;
              }
              db_select('caddocumento', $aTipos, true, $db_opcao, "style='width:233px;'");
              ?>
            </td>
          </tr>

        </table>
      </fieldset>
    </div>
    <input type='button' id='btnSalvar' Value='Salvar' />
    <div style="width: 600px;">
      <fieldset>
        <legend><b>Documentos Cadastrados</b></legend>
        <div id='ctnDbGridDocumentos'>
        </div>
      </fieldset>
    </div>
  </center>
</form>
</body>
<div id='teste' style='display:none'></div>
</html>

<script type="text/javascript">

    var iLicitacao = '<?php echo $oGet->l20_codigo;?>';
    var iEdital = '<?php echo $oGet->l20_nroedital;?>';
    var iSequencial = '<?php echo $oGet->l47_sequencial;?>';
    var sUrlRpc = "lic4_licitacao.RPC.php";

    oGridDocumento     = new DBGrid('gridDocumento');
    oGridDocumento.nameInstance = "oGridDocumento";
    oGridDocumento.setHeight(200);
    oGridDocumento.setCellAlign(new Array("right","right","left","center", "center"));
    //oGridDocumento.setCellWidth("20%", "20%", "20%", "20%","20%");
    oGridDocumento.setHeader(new Array("Codigo","Edital","Tipo","Download", "Ação"));
    oGridDocumento.show($('ctnDbGridDocumentos'));

    js_getDocumento();

    /**
     * Cria um listener para subir a imagem, e criar um preview da mesma
     */
    $("uploadfile").observe('change', function() {
        if(!tipoArquivoValido($('uploadfile').files[0].type)){
            alert('Selecione um arquivo do tipo PDF ou XLS');
            $('uploadfile').value = '';
            return false;
        }
        startLoading();
        var iFrame = document.createElement("iframe");
        iFrame.src = 'func_uploadfiledocumento.php?clone=form1';
        iFrame.id  = 'uploadIframe';
        $('teste').appendChild(iFrame);
    });

    if($('caddocumento').length == 2){
        $('caddocumento').selectedIndex = 1;
    }

    function tipoArquivoValido(tipo){
        let valido = tipo.includes('pdf') || tipo.includes('xml') ? true : false;
        return valido;
    }

    function startLoading() {
        js_divCarregando('Aguarde... Carregando Documento','msgbox');
    }

    function endLoading() {
        js_removeObj('msgbox');
    }

    function js_salvarDocumento() {
        if ($F('namefile') == '') {

            alert('Escolha um Documento!');
            return false;
        }

        if($F('caddocumento') == 0){
            alert('Selecione um Tipo Válido!');
            return false;
        }

        var oParam       = new Object();
        oParam.exec      = 'adicionarDocumento';
        oParam.licitacao    = iLicitacao;

        oParam.tipo      = $F('caddocumento');
        oParam.arquivo   = $F('namefile');
        js_divCarregando('Aguarde... Salvando Documento','msgbox');
        var oAjax        = new Ajax.Request(
            sUrlRpc,
            { parameters: 'json='+Object.toJSON(oParam),
                method: 'post',
                asynchronous:false,
                onComplete : js_retornoSalvarDocumento
            });
    }

    function js_retornoSalvarDocumento(oAjax) {

        js_removeObj("msgbox");
        var oRetorno = eval('('+oAjax.responseText+")");

        alert(oRetorno.message.urlDecode());

        if (oRetorno.status == 1) {
            js_getDocumento();
            $('uploadfile').value     = '';
            $("caddocumento").value = "";
            $('namefile').value = '';
        }

        if($('caddocumento').length == 2)
            $('caddocumento').selectedIndex = 1;

    }

    function js_getDocumento() {
        var oParam       = new Object();
        oParam.exec      = 'getDocumento';
        oParam.licitacao   = iLicitacao;
        var oAjax        = new Ajax.Request(
            sUrlRpc,
            { parameters: 'json='+Object.toJSON(oParam),
                asynchronous:false,
                method: 'post',
                onComplete : js_retornoGetDocumento
            });
    }

    function js_descricaoTipo(sigla){
        let nova_sigla = '';
        switch (sigla) {
            case 'ed':
                nova_sigla = 'Edital';
                break;
            case 'td':
                nova_sigla = 'Termo de Dispensa';
                break;
            case 'mc':
                nova_sigla = 'Minuta do Contrato';
                break;
            case 'po':
                nova_sigla = 'Planilha Orçamentária';
                break;
            case 'cr':
                nova_sigla = 'Cronograma';
                break;
            case 'cb':
                nova_sigla = 'Composição do BDI';
                break;
            case 'fl':
                nova_sigla = 'Fotos do local';
                break;
            case 'dp':
                nova_sigla = 'Dispensa';
                break;
        }
        return nova_sigla;
    }

    function js_retornoGetDocumento(oAjax) {

        var oRetorno = eval('('+oAjax.responseText+")");
        console.log('Valor retornado: ', oRetorno);
        oGridDocumento.clearAll(true);

        if (oRetorno.dados.length == 0) {
            return false;
        }

        oRetorno.dados.each( (oDocumento, iSeq) => {

            var aLinha = new Array();
            aLinha[0]  = iSeq + 1;
            aLinha[1]  = oDocumento.iEdital != null ? oDocumento.iEdital : ' ';
            aLinha[2]  = js_descricaoTipo(oDocumento.iTipo);
            aLinha[3]  = '<input type="button" value="Dowload" onclick="js_documentoDownload('+oDocumento.iCodigo+')">';
            aLinha[4]  = '<input type="button" value="E" onclick="js_excluirDocumento('+oDocumento.iCodigo+')">';
            oGridDocumento.addRow(aLinha);
        });

        oGridDocumento.renderRows();

    }
    $('btnSalvar').observe("click",js_salvarDocumento);
    js_getDocumento();

    function js_excluirDocumento(iCodigoDocumento) {
        if (!confirm('Confirma a Exclusão do Documento?')) {
            return false;
        }
        var oParam             = new Object();
        oParam.exec            = 'excluirDocumento';
        oParam.codigoDocumento = iCodigoDocumento;
        js_divCarregando('Aguarde... excluindo documento','msgbox');
        var oAjax        = new Ajax.Request(
            sUrlRpc,
            { asynchronous:false,
                parameters: 'json='+Object.toJSON(oParam),
                method: 'post',
                onComplete : js_retornoExcluiDocumento
            });

    }

    function js_retornoExcluiDocumento(oAjax) {

        js_removeObj("msgbox");
        var oRetorno = eval('('+oAjax.responseText+")");
        if (oRetorno.status == 2) {
            alert("Não foi possivel excluir o documento:\n "+ oRetorno.message);
        }

        js_getDocumento();
        alert(oRetorno.message.urlDecode());
    }

    function js_documentoDownload(iCodigoDocumento) {

        if (!confirm('Deseja realizar o Download do Documento?')) {
            return false;
        }
        var oParam             = new Object();
        oParam.exec            = 'downloadDocumento';
        oParam.acordo          = iLicitacao;
        oParam.iCodigoDocumento = iCodigoDocumento;
        js_divCarregando('Aguarde... realizando Download do documento','msgbox');
        var oAjax        = new Ajax.Request(
            sUrlRpc,
            { asynchronous:false,
                parameters: 'json='+Object.toJSON(oParam),
                method: 'post',
                onComplete : js_downloadDocumento
            });
    }

    function js_downloadDocumento(oAjax) {

        js_removeObj("msgbox");
        var oRetorno = eval('('+oAjax.responseText+")");
        if (oRetorno.status == 2) {
            alert("Não foi possivel carregar o documento:\n "+ oRetorno.message);
        }
        window.open("db_download.php?arquivo="+oRetorno.nomearquivo);
    }

</script>
