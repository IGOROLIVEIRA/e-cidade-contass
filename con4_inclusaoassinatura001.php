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

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_acordo_classe.php");
require_once("classes/db_acordomovimentacao_classe.php");

$oPost = db_utils::postMemory($_POST);
$oGet  = db_utils::postMemory($_GET);

$clacordo             = new cl_acordo;
$clacordomovimentacao = new cl_acordomovimentacao;

$db_opcao = 1;

$clacordo->rotulo->label();
$clacordomovimentacao->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("ac16_sequencial");
$clrotulo->label("ac16_resumoobjeto");
$clrotulo->label("ac10_datamovimento");
$clrotulo->label("ac10_obs");
?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <?
  db_app::load("scripts.js, strings.js, prototype.js");
  db_app::load("widgets/messageboard.widget.js, widgets/windowAux.widget.js");
  db_app::load("estilos.css, grid.style.css");
  db_app::load("datagrid.widget.js");
  ?>
  <style>
    td {
      white-space: nowrap;
    }

    fieldset table td:first-child {
      width: 80px;
      white-space: nowrap;
    }
  </style>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
  <table border="0" align="center" cellspacing="0" cellpadding="0" style="padding-top:40px;">
    <form id="form1" action="" name="form1">
      <tr>
        <td valign="top" align="center">
          <fieldset>
            <legend><b>Assinatura de aditamentos</b></legend>
            <table align="center" border="0">
              <tr>
                <td title="<?=@$Tac16_sequencial?>" align="left">
                  <?php db_ancora($Lac16_sequencial, "js_pesquisaac16_sequencial(true);",$db_opcao); ?>
                </td>
                <td align="left">
                  <?
                  db_input('ac16_sequencial',10,$Iac16_sequencial,true,'text',
                   $db_opcao," onchange='js_pesquisaac16_sequencial(false);'");
                   ?>
                 </td>
                 <td align="left">
                  <?
                  db_input('ac16_resumoobjeto',40,$Iac16_resumoobjeto,true,'text',3);
                  ?>
                </td>
              </tr>


            </table>
          </fieldset>
        </td>
      </tr>
      <tr>
        <td></td>
      </tr>

    </table>
    <br>
    <div id="ctnGridItens" style="width:80%; text-align:center; margin:0 auto;"></div>
    <br>
    <table border="0" id="assinatura" align="center" cellspacing="0" cellpadding="0" style="padding-top:40px;">
      <tr>
        <td valign="top" align="center">
          <fieldset>
            <legend><b>Clique duplo sobre o aditamento que deseja assinar</b></legend>
            <table align="center" border="0">
              <tr>
                <td title="Código do Aditivo" align="left">
                  <b>Código do Aditivo:</b>
                </td>
                <td align="left">
                  <?
                  db_input('iCodigoAditivo',14,"",true,'text',
                   3," onchange=''");
                   ?>
                 </td>
                 <td align="left">
                  <?
                  db_input('sDescricaoAditivo',40,"",true,'text',3);
                  ?>
                </td>
              </tr>
              <tr>
                <td title="Data" align="left">
                  <b>Data de Assinatura</b>
                </td>
                <td align="left">
                  <?
                  db_inputdata("sData", "", "", "", true, 'text', 1, "", "", "","none","","", "");
                  ?>
                </td>
                <td align="left">

                </td>
              </tr>
              <tr>
                <td title="Data" align="left">
                  <b>Data da publicação</b>
                </td>
                <td align="left">
                  <?
                  db_inputdata("sDataPublicacao", "", "", "", true, 'text', 1, "", "", "","none","","", "");
                  ?>
                </td>
                <td align="left">

                </td>
              </tr>
              <tr>
                <td title="Data" align="left">
                  <b>Veículo de divulgação</b>
                </td>
                <td align="left" colspan="2">
                  <?
                  db_input('sVeiculoDivulgacao',40,"",true,'text',1);
                  ?>
                </td>

              </tr>


            </table>
          </fieldset>
        </td>
      </tr>
      <tr>
        <td></td>
      </tr>

    </table>
    <br>
    <table width="100%">
      <tr>
        <td align="center">
          <input id="incluir" name="incluir" type="button" value="Salvar Assinatura" onclick="return js_salvaAssinatura();">
        </td>
      </tr>
    </form>
  </table>
  <?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
  ?>
</body>
<script>
  $('ac16_sequencial').style.width   = "100%";
  $('ac16_resumoobjeto').style.width = "100%";

/**
 * Pesquisa acordos
 */
 function js_pesquisaac16_sequencial(lMostrar) {

  if (lMostrar == true) {

    var sUrl = 'func_acordo.php?funcao_js=parent.js_mostraacordo1|ac16_sequencial|ac16_resumoobjeto';
    js_OpenJanelaIframe('CurrentWindow.corpo',
      'db_iframe_acordo',
      sUrl,
      'Pesquisar Acordo',
      true);
  } else {

    if ($('ac16_sequencial').value != '') {

      var sUrl = 'func_acordo.php?descricao=true&pesquisa_chave='+$('ac16_sequencial').value+
      '&funcao_js=parent.js_mostraacordo';

      js_OpenJanelaIframe('CurrentWindow.corpo',
        'db_iframe_acordo',
        sUrl,
        'Pesquisar Acordo',
        false);
    } else {
     $('ac16_sequencial').value = '';
   }
 }
}

/**
 * Retorno da pesquisa acordos
 */
 function js_mostraacordo(chave1,chave2,erro) {
  // alert(chave1);
  // alert(chave2);
  if (erro == true) {

    $('ac16_sequencial').value   = '';
    $('ac16_resumoobjeto').value = chave1;
    $('ac16_sequencial').focus();
  } else {

    $('ac16_sequencial').value   = chave1;
    $('ac16_resumoobjeto').value = chave2;
  }
  js_carregaAditamentos();
}

/**
 * Retorno da pesquisa acordos
 */
 function js_mostraacordo1(chave1,chave2) {
  // alert(chave1);
  // alert(chave2);
  $('ac16_sequencial').value    = chave1;
  $('ac16_resumoobjeto').value  = chave2;
  js_carregaAditamentos();
  db_iframe_acordo.hide();



}
function js_carregaAditamentos(){
  db_iframe_acordo.hide();

  oGridItens              = new DBGrid("oGridItens");
  oGridItens.nameInstance   = "oGridItens";
  oGridItens.setCheckbox(true);

  oGridItens.setHeight(200);
  oGridItens.setCellAlign(new Array("center", "center", "center","center", "center"));
  oGridItens.setHeader(new Array("Código",
    "Número",
    "Tipo",
    "Assinatura",
    "Publicação",
    ));
  oGridItens.selectSingle = function (oCheckbox, sRow, oRow) {
    document.form1.iCodigoAditivo.value = (oRow.aCells[1].getValue());
    document.form1.sDescricaoAditivo.value = (oRow.aCells[3].getValue());

  }

  oGridItens.show($('ctnGridItens'));

  oGridItens.clearAll(true);


  sUrl = 'con4_contratosmovimentacoesfinanceiras.RPC.php';

  var oParam = new Object();
  oParam.exec = "getPosicoesAcordo";
  oParam.iAcordo = $F('ac16_sequencial');

  var oAjax = new Ajax.Request(
    sUrl,
    {
      method: 'post',
      parameters: 'json=' + Object.toJSON(oParam),
      onComplete: function(o){

        var oRetorno = eval("(" + o.responseText + ")").posicoes;
        oRetorno.forEach(function(aditivo){
          if(aditivo.codigoaditivo!=""){
                    var aLinha = new Array();
                    aLinha[0]  = aditivo.codigoaditivo;
                    aLinha[1]  = aditivo.numero;
                    aLinha[2]  = aditivo.descricaotipo.urlDecode();
                    aLinha[3]  = (aditivo.dataassinatura == null || aditivo.dataassinatura == "") ? '-' : (aditivo.dataassinatura);
                    aLinha[4]  = (aditivo.datapublicacao == null || aditivo.datapublicacao == "") ? '-' : (aditivo.datapublicacao);
                    disabled = false;
                    if(aditivo.dataassinatura != null && aditivo.dataassinatura != ""){
                      disabled = true;
                    }
                    oGridItens.addRow(aLinha, true, disabled, false);
          }
        });
      }
    }
    );
  oGridItens.renderRows();

  //mete o ajax de busca

}
function  js_salvaAssinatura(){
  sUrl = 'con4_contratosaditamentos.RPC.php';

  var oParam = new Object();

  oParam.exec = "salvaAssinatura";
  if($F('ac16_sequencial') == ""){
    alert("Preencha o campo Código do Acordo");
    return false;
  }
  if($F('iCodigoAditivo') == ""){
    alert("Selecione um aditivo");
    return false;
  }
  if($F('sData') == ""){
    alert("Preencha o campo data de assinatura");
    return false;
  }
  if($F('sDataPublicacao') == ""){
    alert("Preencha o campo data da publicação");
    return false;
  }
  if($F('sVeiculoDivulgacao') == ""){
    alert("Preencha o campo veículo de divulgação");
    return false;
  }
  oParam.iAcordo = $F('ac16_sequencial');
  oParam.iCodigoAditivo = $F('iCodigoAditivo');
  oParam.sData = $F('sData');
  oParam.sDataPublicacao = $F('sDataPublicacao');
  oParam.sVeiculoDivulgacao = $F('sVeiculoDivulgacao');

  var oAjax = new Ajax.Request(
    sUrl,
    {
      method: 'post',
      parameters: 'json=' + Object.toJSON(oParam),
      onComplete: function(o){
        alert((eval("(" + o.responseText + ")").message).urlDecode());
        document.form1.iCodigoAditivo.value = '';
        document.form1.sDescricaoAditivo.value = '';
        document.form1.sData.value = '';
        document.form1.sDataPublicacao.value = '';
        document.form1.sVeiculoDivulgacao.value = '';
        js_carregaAditamentos();
      }
    });
}
</script>
</html>
