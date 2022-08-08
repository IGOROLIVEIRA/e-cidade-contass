<?
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

//MODULO: Configuracoes

$clrotulo = new rotulocampo;
$clrotulo->label("z06_numcgm");
$clrotulo->label("z01_nome");
$clrotulo->label("db44_descricao");
$aTipos = array();
$codtribunal = 12;//$pc50_pctipocompratribunal;
$natureza_objeto = 3;//$l20_naturezaobjeto;
$db_opcao = 1;
?>
<body>
<form name="form1" id="form1" method="post" action="" enctype="multipart/form-data">
<center>
<table align=center style="margin-top: 15px">
  <tr>
    <td id="td_principal">
      <fieldset>
        <legend>
          <b>Adicionar Documento</b>
        </legend>
        <table border="0" id="tbl_documentos">
          <tr>
            <td>
              <b>Documento:</b>
            </td>

            <td valign='top'>
              <?
                db_input("uploadfile", 30, 0, true, "file", 1);
                db_input("namefile", 30, 0, true, "hidden", 1);
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
                    if($natureza_objeto != 1 && $natureza_objeto != 7){
                     $aTipos['td'] = 'Termo de Dispensa';
                    }else{
                      $aTipos[] = 'Selecione';
                      $aTipos['mc'] = 'Minuta do Contrato';
                      $aTipos['po'] = 'Planilha Or?ament?ria';
                      $aTipos['cr'] = 'Cronograma';
                      $aTipos['cb'] = 'Composi??o BDI';
                      $aTipos['fl'] = 'Fotos do local';
                    }
                   break;

                 default:
                    if($natureza_objeto != 1 && $natureza_objeto != 7){
                      $aTipos['ed'] = 'Edital';
                    }else{
                      $aTipos[] = 'Selecione';
                      $aTipos['mc'] = 'Minuta do Contrato';
                      $aTipos['po'] = 'Planilha Orçamentária';
                      $aTipos['cr'] = 'Cronograma';
                      $aTipos['cb'] = 'Composi??o BDI';
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
      <div id="botao">
        <input name="salvar" type="button" id="salvar" value="Salvar" onclick="js_salvarDocumento();" >
      </div>
      <br>
      <fieldset>
        <legend>
          <b>Documentos Cadastrados</b>
        </legend>
        <div id="ctnDbGridDocumentos">
        </div>
       </fieldset>
     </td>
   </tr>
</table>
</div>

</center>
</form>
</body>
<div id='teste' style='display:none'></div>
<script>

// Recebe a Url
var sUrl = window.location.search;
var oUrl = null;
var sConsulta = false;
iAcordo = '';
var sUrlRpc = "con4_contratos.RPC.php";

if (sUrl) {

  oUrl = js_urlToObject(sUrl);
  //Se exitir a flag consulta na URL seta ela com o valor passado
  if (oUrl.consulta) {
    sConsulta = new Boolean(oUrl.consulta);
  }
}

function js_init() {

  // oDBGrid              = new DBGrid("gridDocumentos");
  // oDBGrid.nameInstance = "oDBGrid";
  // oDBGrid.aWidths      = new Array("20%","25%", "25%","15%", "15%");
  // oDBGrid.setCellAlign(new Array("center", "left", "center", "center", "center"));
  // oDBGrid.setHeader(new Array("Sequencial", "Processo", "Tipo", "Download", "A??o"));
  // oDBGrid.show($('cntDBGrid'));

    oGridDocumento     = new DBGrid('gridDocumento');
    oGridDocumento.nameInstance = "oGridDocumento";
    oGridDocumento.setHeight(200);
    oGridDocumento.setCellAlign(new Array("right","right","left","center", "center"));
    oGridDocumento.setHeader(new Array("Codigo","Acordo","Descricao","Download", "A??o"));
    oGridDocumento.show($('ctnDbGridDocumentos'));
}

js_init();

/**
 * Cria um listener para subir a imagem, e criar um preview da mesma
 */
$("uploadfile").observe('change', function() {

    startLoading();
    var iFrame = document.createElement("iframe");
    iFrame.src = 'func_uploadfiledocumento.php?clone=CurrentWindow.corpo.iframe_documentos.form1';
    iFrame.id  = 'uploadIframe';
    $('teste').appendChild(iFrame);

});

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

    if ($F('sDescricaoDocumento') == '') {

        alert('Informe uma descrição para o documento!');
        return false;
    }

    var oParam       = new Object();
    oParam.exec      = 'adicionarDocumento';
    oParam.acordo    = $F('iCodigoContrato');
    oParam.descricao = encodeURIComponent(($F('sDescricaoDocumento').replace(/\\/g,  "<contrabarra>")));
    oParam.arquivo   = $F('namefile');
    js_divCarregando('Aguarde... Salvando Documento','msgbox');
    var oAjax        = new Ajax.Request(
        sUrlRpc,
        { parameters: 'json='+Object.toJSON(oParam),
            method: 'post',
            asynchronous:false,
            onComplete : js_retornoSalvarFoto
        });
}

function js_retornoSalvarFoto(oAjax) {

    js_removeObj("msgbox");
    var oRetorno = eval('('+oAjax.responseText+")");
    if (oRetorno.status == 1) {

        $('uploadfile').value     = '';
        $("sDescricaoDocumento").value = "";
        js_getDocumento();
    } else {
        alert(oRetorno.message.urlDecode());
    }
}

function js_getDocumento() {

    if (iAcordo == null) {
        return false;
    }

    var oParam       = new Object();
    oParam.exec      = 'getDocumento';
    oParam.acordo   = iAcordo;
    var oAjax        = new Ajax.Request(
        sUrlRpc,
        { parameters: 'json='+Object.toJSON(oParam),
            asynchronous:false,
            method: 'post',
            onComplete : js_retornoGetDocumento
        });
}

function js_retornoGetDocumento(oAjax) {

    var oRetorno = eval('('+oAjax.responseText+")");
    oGridDocumento.clearAll(true);

    if (oRetorno.dados.length == 0) {
        return false;
    }

    oRetorno.dados.each(function (oDocumento, iSeq) {

        var aLinha = new Array();
        aLinha[0]  = oDocumento.iCodigo;
        aLinha[1]  = oDocumento.iAcordo;
        aLinha[2]  = decodeURIComponent(oDocumento.sDescricao.replace(/\+/g,  " "));
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
    oParam.acordo          = iAcordo;
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

        alert("N?o foi possivel excluir o documento:\n "+ oRetorno.message);
    }

    js_getDocumento();

}

function js_documentoDownload(iCodigoDocumento) {

    if (!confirm('Deseja realizar o Download do Documento?')) {
        return false;
    }
    var oParam              = new Object();
    oParam.exec             = 'downloadDocumento';
    oParam.acordo           = iAcordo;
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
        alert("N?o foi possivel carregar o documento:\n "+ oRetorno.message);
    }
    window.open("db_download.php?arquivo="+oRetorno.nomearquivo);
}

</script>
