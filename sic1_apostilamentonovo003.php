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

require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("model/Dotacao.model.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_pcproc_classe.php");
require_once("classes/db_pcparam_classe.php");
require_once("classes/db_solicita_classe.php");
require_once("classes/db_pctipocompra_classe.php");
require_once("classes/db_emptipo_classe.php");
require_once("classes/db_empautoriza_classe.php");
require_once("classes/db_cflicita_classe.php");
$clpcproc = new cl_pcproc;
$clcflicita = new cl_cflicita;
$clpcparam = new cl_pcparam;
$clpctipocompra = new cl_pctipocompra;
$clsolicita = new cl_solicita;
$clemptipo = new cl_emptipo;
$clempautoriza = new cl_empautoriza;
$clempautoriza->rotulo->label();
$clpcproc->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("pc12_tipo");
$clrotulo->label("e54_codtipo");
$clrotulo->label("e54_autori");
$clrotulo->label("e54_destin");
$clrotulo->label("e54_numerl");
$clrotulo->label("e54_tipol");
$clrotulo->label("pc10_numero");
$clrotulo->label("pc10_resumo");
$clrotulo = new rotulocampo;
$clrotulo->label("ac16_sequencial");
$clrotulo->label("ac16_resumoobjeto");
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<?
db_app::load("scripts.js, strings.js, datagrid.widget.js, windowAux.widget.js,dbautocomplete.widget.js");
db_app::load("dbmessageBoard.widget.js, prototype.js, dbtextField.widget.js, dbcomboBox.widget.js");
db_app::load("estilos.css, grid.style.css");
?>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
  <br>
  <br>
  <center>
    <fieldset style="width: 75%;">
      <legend><b>Excluir Apostilamentos</b></legend>
      <table style='width: 100%' border='0'>
        <tr>
          <td width="100%">
            <table width="100%">
              <tr style="text-align: center;">
                <td title="<?php echo $Tac16_sequencial ; ?>">
                  <?php db_ancora($Lac16_sequencial, "js_pesquisaac16_sequencial(true);", 1); ?>
                  <span id='ctnTxtCodigoAcordo'></span>
                  <span id='ctnTxtDescricaoAcordo'></span>
                </td>
              </tr>
              <tr>
                <td colspan="3" style="text-align: center">
                  <input type="button" value='Pesquisar' id='btnPesquisarPosicoes'>
                </td>
              </tr>
              <tr>
                <td colspan='3'>
                  <fieldset>
                    <div id='ctnGridPosicoes'>
                    </div>
                  </fieldset>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td style="text-align: center">
          </td>
        </tr>
      </table>
    </fieldset>
    <input type='button' value='Excluir Apostilamento' onclick="js_processarExclusaoPosicao();" style="margin-top: 10px;">
  </center>
</body>
</html>
<script>

var sUrlRpc = 'con4_contratosmovimentacoesfinanceiras.RPC.php';
/**
 * Pesquisa acordos
 */
var iPosicaoAtual = 0;


function js_pesquisaac16_sequencial(lMostrar) {

  if (lMostrar == true) {

    var sUrl = 'func_acordo.php?lDepartamento=1&apostilamento=true&funcao_js=parent.js_mostraacordo1|ac16_sequencial|ac16_resumoobjeto&iTipoFiltro=4&lGeraAutorizacao=true';
    js_OpenJanelaIframe('top.corpo',
                        'db_iframe_acordo',
                        sUrl,
                        'Pesquisar Acordo',
                        true);
  } else {

    if (oTxtCodigoAcordo.getValue() != '') {

      var sUrl = 'func_acordo.php?lDepartamento=1&descricao=true&apostilamento=true&pesquisa_chave='+oTxtCodigoAcordo.getValue()+
                 '&funcao_js=parent.js_mostraacordo&iTipoFiltro=4&lGeraAutorizacao=true';

      js_OpenJanelaIframe('top.corpo',
                          'db_iframe_acordo',
                          sUrl,
                          'Pesquisar Acordo',
                          false);
     } else {
       oTxtCodigoAcordo.setValue('');
     }
  }
}

/**
 * Retorno da pesquisa acordos
 */
function js_mostraacordo(chave1,chave2,erro) {

  if (erro == true) {

    oTxtCodigoAcordo.setValue('');
    oTxtDescricaoAcordo.setValue('');
    $('oTxtDescricaoAcordo').focus();
  } else {

    oTxtCodigoAcordo.setValue(chave1);
    oTxtDescricaoAcordo.setValue(chave2);
    oGridPosicoes.clearAll(true);
  }
}

/**
 * Retorno da pesquisa acordos
 */
function js_mostraacordo1(chave1,chave2) {

  oTxtCodigoAcordo.setValue(chave1);
  oTxtDescricaoAcordo.setValue(chave2);
  oGridPosicoes.clearAll(true);
  db_iframe_acordo.hide();
}

function js_main() {

   oTxtCodigoAcordo = new DBTextField('oTxtCodigoAcordo', 'oTxtCodigoAcordo','', 10);
   oTxtCodigoAcordo.addEvent("onChange",";js_pesquisaac16_sequencial(false);");
   oTxtCodigoAcordo.show($('ctnTxtCodigoAcordo'));

   oTxtDescricaoAcordo = new DBTextField('oTxtDescricaoAcordo', 'oTxtDescricaoAcordo','', 50);
   oTxtDescricaoAcordo.show($('ctnTxtDescricaoAcordo'));
   oTxtDescricaoAcordo.setReadOnly(true);

   oGridPosicoes = new DBGrid('oGridPosicoes');
   oGridPosicoes.nameInstance = "oGridPosicoes";
   oGridPosicoes.setCheckbox(0);
   oGridPosicoes.setHeader(new Array('Código', 'Número', 'Tipo', "Data", "Emergencial"));
   oGridPosicoes.setHeight(100);
   oGridPosicoes.show($('ctnGridPosicoes'));

   $('btnPesquisarPosicoes').onclick = js_pesquisarPosicoesContrato;
   iTipoAcordo = 0;
}

function js_pesquisarPosicoesContrato() {

  if (oTxtCodigoAcordo.getValue() == "") {

    alert('Informe um acordo!');
    return false;
  }
  js_divCarregando('Aguarde, pesquisando dados do acordo', 'msgbox');

  oGridPosicoes.clearAll(true);
  var oParam                 = new Object();
  oParam.exec                = 'getApostilamentos';
  oParam.lGeracaoAutorizacao = true;
  oParam.iAcordo = oTxtCodigoAcordo.getValue();
  var oAjax      = new Ajax.Request(sUrlRpc,
                                    {method:'post',
                                     parameters:'json='+Object.toJSON(oParam),
                                     onComplete: js_retornoGetPosicoesAcordo
                                    }
                                   )
}

function js_retornoGetPosicoesAcordo(oAjax) {

  js_removeObj('msgbox');
  var oRetorno = eval("("+oAjax.responseText+")");
  aPosicoesAcordo = oRetorno.posicoes;
  oGridPosicoes.clearAll(true);
  iTipoAcordo = oRetorno.tipocontrato;
  if (oRetorno.status == 1) {

    oRetorno.posicoes.each(function (oPosicao, iLinha) {

      var aLinha = new Array();
      aLinha[0]  = oPosicao.codigo;
      aLinha[1]  = oPosicao.numero;
      aLinha[2]  = oPosicao.tipo+' - '+oPosicao.descricaotipo.urlDecode();
      aLinha[3]  = oPosicao.data;
      aLinha[4]  = oPosicao.emergencial.urlDecode();
      oGridPosicoes.addRow(aLinha);
    });
    oGridPosicoes.renderRows();
  }else{
      alert(oRetorno.message.urlDecode());
  }
}

function js_processarExclusaoPosicao() {

    var aPosicoes = oGridPosicoes.getSelection("object");
    if (aPosicoes.length == 0) {

        alert('Nenhum aditamento selecionado');
        return false;
    }

    js_divCarregando('Aguarde, processando.....', 'msgbox');
    var oParam        = new Object();
    oParam.exec       = "processarExclusaoPosicao";
    oParam.lProcessar = true;
    oParam.aPosicoes  = new Array();
    oParam.dados      = new Object();
    for (var i = 0; i < aPosicoes.length; i++) {

        with (aPosicoes[i]) {
            var oPosicao     = new Object();
            oPosicao.codigo  = aPosicoes[i].aCells[0].getValue();
            oParam.aPosicoes.push(oPosicao);
        }
    }
    var oAjax  = new Ajax.Request(sUrlRpc,
        {method:'post',
            parameters:'json='+Object.toJSON(oParam),
            onComplete: js_retornoExcluirPosicao
        }
    )
}

function js_retornoExcluirPosicao(oAjax){
    js_removeObj('msgbox');
    var oRetorno = eval("("+oAjax.responseText+")");
    var sMensagem = oRetorno.message.urlDecode();

    if ( oRetorno.status > 1 ) {

        alert(sMensagem);
        oGridPosicoes.clearAll(true);
        return false;
    }
}

js_main();
$('e54_resumo').style.width='100%';
</script>
<?php
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
