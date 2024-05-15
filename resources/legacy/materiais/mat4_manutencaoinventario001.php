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
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_utils.php");
require_once ("dbforms/db_classesgenericas.php");

$oGet                     = db_utils::postMemory($_GET);
$oRotuloInventario        = new rotulo("inventario");
$oRotuloDepartamento      = new rotulo("db_depart");
$oRotuloInstituicao       = new rotulo("db_config");
$oRotuloMateriais              = new rotulo("Materiais");
$oRotuloMateriaisPlaca         = new rotulo("Materiaisplaca");
$oRotuloConvenio          = new rotulo("Materiaiscadcedente");
$oRotuloClassificacaoMateriais = new rotulo("claMateriais");

$oRotuloInventario       ->label();
$oRotuloDepartamento     ->label();
$oRotuloInstituicao      ->label();
$oRotuloMateriais             ->label();
$oRotuloMateriaisPlaca        ->label();
$oRotuloConvenio         ->label();
$oRotuloClassificacaoMateriais->label();
$oGet->db_opcao = 1;

$oParametro         = db_utils::getDao("cfpatri");
$sSQLBuscaParametro = $oParametro->sql_query();
$rsBuscaParametro   = $oParametro->sql_record($sSQLBuscaParametro);
$lPesquisaOrgao     = db_utils::fieldsMemory($rsBuscaParametro,0)->t06_pesqorgao;

$sDisplayOrgaoUnidade = '';
if ($lPesquisaOrgao == 'f') {
  $sDisplayOrgaoUnidade = 'none';
}

db_app::load('scripts.js,estilos.css,prototype.js, dbmessageBoard.widget.js, windowAux.widget.js');
db_app::load('dbtextField.widget.js, dbcomboBox.widget.js, DBViewGeracaoAutorizacao.classe.js, grid.style.css');
db_app::load('datagrid.widget.js, strings.js, arrays.js, DBHint.widget.js, ');
?>

<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script type="text/javascript" src="scripts/scripts.js"></script>
  <script type="text/javascript" src="scripts/prototype.js"></script>

  <style>

  .MateriaisAtualizados {
   background-color: #D1F07C;
 }
 .MateriaisComInventario {
   background-color: #C0BFFF;
 }
 .MateriaisSemInventario {
  background-color: #FFF;
}
.MateriaisSemInventario {
  background-color: #FFF;
}

.filtros {
  display : none;
}
#Filtros {
  width:90px;
}
#iTipoBem{
  width:120px;
}
</style>
</head>

<body bgcolor="#CCCCCC">

  <form class="container" id="form1" name="form1">
    <fieldset style="width: 500px;">
      <legend>Manutenção de Inventário</legend>
      <table border='0' class="form-container">
        <!-- Inventário / inventario / t75-->
        <tr>
          <td width="30%">
            <?
            db_ancora("<b>Inventário:</b>", "js_pesquisaInventario(true)", $oGet->db_opcao);
            ?>
          </td>
          <td>
            <?
                //$funcaoJsIventario = "onchange = 'js_pesquisaInventario(false)'";
            db_input('iInventario', 10, $It75_sequencial, true, 'text',3);
            ?>
          </td>
        </tr>

        <tr id='filtroDepartamento'>
          <td>
            <?
            db_ancora("<b>Almoxarifado:</b>", "js_pesquisaDepartamento(true)", $oGet->db_opcao);
            ?>
          </td>
          <td>
            <?
            $funcaoJsDepartamento = "onchange = 'js_pesquisaDepartamento(false)'";
            db_input('iDepartamento', 10, $Icodigo, true, 'text', $oGet->db_opcao, $funcaoJsDepartamento);
            //db_input('sDepartamento', 35, $Inomeinst, true, 'text',3);
            ?>
          </td>
        </tr>
        <tr id='filtroDepartamento'>
          <td>
            <?
            db_ancora("<b>Almoxarifado:</b>", "js_pesquisaDepartamento2(true)", $oGet->db_opcao);
            ?>
          </td>
          <td>
            <?
            $funcaoJsDepartamento = "onchange = 'js_pesquisaDepartamento2(false)'";
            db_input('iDepartamento2', 10, $Icodigo, true, 'text', $oGet->db_opcao, $funcaoJsDepartamento);
            //db_input('sDepartamento', 35, $Inomeinst, true, 'text',3);
            ?>

            <?
            db_ancora("<b>Até:</b>", "js_pesquisaDepartamento3(true)", $oGet->db_opcao);
            ?>

            <?
            $funcaoJsDepartamento = "onchange = 'js_pesquisaDepartamento3(false)'";
            db_input('iDepartamento3', 10, $Icodigo, true, 'text', $oGet->db_opcao, $funcaoJsDepartamento);
            //db_input('sDepartamento', 35, $Inomeinst, true, 'text',3);
            ?>
          </td>
        </tr>
        <tr id='filtroMaterial'>
          <td>
            <?
            db_ancora("<b>Material:</b>", "js_pesquisaMaterial2(true)", $oGet->db_opcao);
            ?>
          </td>
          <td>
            <?
            $funcaoJsMaterial = "onchange = ''";
            db_input('iMaterial2', 10, $Icodigo, true, 'text', $oGet->db_opcao, $funcaoJsMaterial);
            //db_input('sMaterial', 35, $Inomeinst, true, 'text',3);
            ?>

            <?
            db_ancora("<b>Até:</b>", "js_pesquisaMaterial3(true)", $oGet->db_opcao);
            ?>

            <?
            $funcaoJsMaterial = "onchange = ''";
            db_input('iMaterial3', 10, $Icodigo, true, 'text', $oGet->db_opcao, $funcaoJsMaterial);
            //db_input('sDepartamento', 35, $Inomeinst, true, 'text',3);
            ?>
          </td>
        </tr>
        <tr>
          <td>
            <b>Listar materiais:</b>
          </td>
          <td style="width:200px;">
            <select name="estoque" id="estoque" style="width:200px;" onchange="js_mudaFiltroEstoque()" >
              <option value="1" selected >Somente com estoque</option>
              <option value="2">Sem estoque</option>
              <option value="0">Todos</option>
            </select>
          </td>
        </tr>
        <tr id="caixaMateriais" style="display:none;" >


             <?
             $aux = new cl_arquivo_auxiliar;
             $aux->cabecalho = "<strong>Material</strong>";
                 $aux->codigo = "m60_codmater"; //chave de retorno da func
                 $aux->descr  = "m60_descr";   //chave de retorno
                 $aux->nomeobjeto = 'material';
                 $aux->funcao_js = 'js_mostra2';
                 $aux->funcao_js_hide = 'js_mostra3';
                 $aux->sql_exec  = "";
                 $aux->passar_query_string_para_func  = "&semestoque=true&material=true";
                 $aux->func_arquivo = "func_matestoque.php";  //func a executar
                 $aux->nomeiframe = "db_iframe_matestoque";
                 $aux->localjan = "";
                 $aux->tamanho_campo_descricao = 29;
                 $aux->onclick = "";
                 $aux->db_opcao = 2;
                 $aux->tipo = 2;
                 $aux->top = 0;
                 $aux->linhas = 5;
                 $aux->vwidth = 400;
                 $aux->funcao_gera_formulario();
                 ?>


           </tr>
           <!-- Divisão -->

         </table>
       </div>
     </fieldset>
     <input type='button' name="btnExibirMateriais" value='Exibir' onclick = "js_exibirMateriais();">
   </form>
   <?
   db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
   ?>


   <script>
    var sUrlRpc                 = "mat4_inventario.RPC.php";
    var aSituacaoMateriais           = new Array();
    var aDepartamentos          = new Array();
    var aDivisaoPorDepartamento = new Array();
    var sCorMateriaisComInventario   = "#C0BFFF";
    var sCorMateriaisAtualizados     = "#D1F07C";
    var aMateriaisHint               = new Array();
    var nValorAntigo            = "";
    js_mudaFiltroEstoque();
    function js_mudaFiltroEstoque(){

      if(document.form1.estoque.value == '2'){
        document.getElementById("tr_inicio_material").style.display = "";
        document.getElementById("filtroMaterial").style.display = "none";
      }else{
        document.getElementById("tr_inicio_material").style.display = "none";
        document.getElementById("filtroMaterial").style.display = "";
      }
    }
    function js_pesquisaInventario(lMostra){
      var sUrlLookUp = "func_inventario.php?situacao=1&funcao_js=parent.js_mostraInventario|t75_sequencial";
      js_OpenJanelaIframe('', 'db_iframe_inventario', sUrlLookUp, 'Pesquisa Inventarário', lMostra);
    }
    function js_exibirMateriais() {

      var lancadormaterial = [];

      inventario = document.form1.iInventario.value;
      departamento1 = document.form1.iDepartamento.value;
      departamento2 = document.form1.iDepartamento2.value;
      departamento3 = document.form1.iDepartamento3.value;
      material = document.form1.iMaterial2.value;
      material2 = document.form1.iMaterial3.value;
      filtrosaldo = document.form1.estoque.value;
      for(i=0;i<document.form1.material.length;i++){
        lancadormaterial.push(document.form1.material[i].value);
      }
      lancadormaterial = lancadormaterial.join(",");

      if(filtrosaldo == 2 && (lancadormaterial == "" || lancadormaterial == null)){
        alert("Selecione os materiais que deseja implantar estoque.");
        return false;
      }
      if(inventario == ""){
        alert("Preencha o código do inventario");
        return false;
      }
      js_divCarregando("Carregando", "msgBox");
      var oParam                     = new Object();
      oParam.exec                    = 'getMateriais';
      oParam.inventario                  = inventario;
      oParam.departamento1               = departamento1;
      oParam.departamento2               = departamento2;
      oParam.departamento3               = departamento3;
      oParam.material                    = material;
      oParam.material2                   = material2;
      oParam.lancadormaterial            = lancadormaterial;
      oParam.filtrosaldo                 = filtrosaldo;

    //js_divCarregando(_M('patrimonial.material.mat4_manutencaoinventario001.realizando_consulta'), "msgBox");
    var oAjax = new Ajax.Request(sUrlRpc,
      {method:'post',
      parameters:'json='+Object.toJSON(oParam),
      onComplete: js_montaWindowGridItens});
  }
  function js_fecharWindow() {
    oWindowAux.destroy();
  }
  function js_montaWindowGridItens (oAjax) {
    js_removeObj("msgBox");
    var oRetorno = JSON.parse(oAjax.responseText);

    if (oRetorno.iStatus == 2) {

      alert(oRetorno.sMessage.urlDecode());
      return false;
    }


    var iHeight   = document.body.clientHeight-100;
    var iWidth    = document.body.clientWidth-50;
    var iWidthContainer = (iWidth-30);

    oWindowAux    = new windowAux('oWindowAux', 'Vincular Materiais', iWidth, iHeight);
    var sContent  = "<div style='width: "+iWidthContainer+"px;' id='cntGrid'></div>";
    sContent += "<fieldset style='width: 400px'>";
    sContent += "<legend><b>Legenda</b></legend>";
    sContent += "<table colspan='0'>";
    sContent += "  <tr>";
    sContent += "    <td align='center' class='MateriaisSemInventario' height='20px' width='150px'><b>Materiais Sem Inventário</b></td>";
    sContent += "    <td align='center' class='MateriaisAtualizados'   height='20px' width='150px'><b>Atualizados neste inventário</b></td>";
    sContent += "    <td align='center' class='MateriaisComInventario' height='20px' width='150px'><b>Atualizados em outro inventário</b></td>";
    sContent += "  </tr>";
    sContent += "</table>";
    sContent += "</fieldset>";
    sContent += "<p align='center'><input type='button' value='Fechar' onclick='js_fecharWindow();' /></p>";
    oWindowAux.setContent(sContent);


    var sHelpMsgBoardMateriais = 'Selecione registros';
    var oMessageBoardMateriais = new DBMessageBoard('msg_boardMateriais',
      'Selecione registos',
      sHelpMsgBoardMateriais,
      oWindowAux.getContentContainer());


    var aHeader     = new Array();
    aHeader[0]  = "Cod. Estoque";
    aHeader[1]  = "Cod. Material";
    aHeader[2]  = "Descrição";
    aHeader[3]  = "Almoxarifado";
    aHeader[4]  = "Estoque";
    aHeader[5]  = "Contagem";
    aHeader[6]  = "Preço médio";
    aHeader[7]  = "Preço unitario";
    aHeader[8]  = "Inventário";


    var aCellWidth     = new Array();

    aCellWidth[0]  = "76";
    aCellWidth[1]  = "76";
    aCellWidth[2]  = "350";
    //aCellWidth[3]  = "350";
    aCellWidth[4]  = "76";
    aCellWidth[5]  = "76";
    aCellWidth[6]  = "76";
    aCellWidth[7]  = "80";
    aCellWidth[8]  = "76";
    aCellWidth[9]  = "76";



    var aCellAlign     = new Array();
    aCellAlign[0]  = "center";
    aCellAlign[1]  = "center";
    aCellAlign[2]  = "center";
    aCellAlign[3]  = "center";
    aCellAlign[4]  = "center";
    aCellAlign[5]  = "center";
    aCellAlign[6]  = "center";
    aCellAlign[7]  = "center";
    aCellAlign[8]  = "center";
    aCellAlign[9]  = "center";

    oGridMateriais = new DBGrid('cntGrid');
    oGridMateriais.nameInstance = 'oGridMateriais';
    oGridMateriais.setCheckbox(0);
    oGridMateriais.allowSelectColumns(true);
    oGridMateriais.setHeader(aHeader);
    oGridMateriais.setCellWidth(aCellWidth);
    oGridMateriais.setCellAlign(aCellAlign);
    oGridMateriais.setHeight(300);
    oGridMateriais.show($('cntGrid'));
    oWindowAux.show();
    oWindowAux.setShutDownFunction(function(){
      js_fecharWindow();
    });
    js_preencheGrid(oRetorno.aMateriais);
    oGridMateriais.selectSingle = function (oCheckbox,sRow,oRow) {

      //console.log(oRow.aCells[2].getValue());
      js_salvaDadosLinhaSelecionada(oRow);
      var codigo = oRow.aCells[1].getValue();
      js_liberaDigitacao($("oTxtPreco"+codigo));
      js_liberaDigitacao($("oTxtEstoque"+codigo));
      oCheckbox.disabled = true;
      $(sRow).className = 'MateriaisAtualizados';

      $(oRow.aCells[9].sId).innerHTML = ( $F('iInventario'));
    };

  }

  function js_salvaDadosLinhaSelecionada(oRow) {

    js_divCarregando("Carregando", "msgBox");
    var oParam                 = new Object();
    oParam.exec                = "salvarMaterial";
    oParam.iCodigoEstoque     = oRow.aCells[1].getValue();
    oParam.iCodigoMaterial     = oRow.aCells[2].getValue();
    oParam.iDepartamento     = $F('Departamento'+oRow.aCells[1].getValue()+oRow.aCells[2].getValue());
    oParam.iValorEstoqueInicial     = oRow.aCells[5].getValue();
    oParam.iContagem     = oRow.aCells[6].getValue();
    oParam.iPreco     = oRow.aCells[8].getValue();
    oParam.iCodigoInventario   = $F('iInventario');

    var oAjax = new Ajax.Request(sUrlRpc,
      {method:'post',
      parameters:'json='+Object.toJSON(oParam),
      onComplete:
      function (oAjax) {

       js_removeObj("msgBox");
       var oRetorno =  eval("("+oAjax.responseText+")");
       //console.log(oRetorno.sMessage.urlDecode());
       if (oRetorno.status == 2) {

         alert("Não foi possível salvar o material.");
         oGridMateriais.clearAll(true);
         js_fecharWindow();
         js_exibirMateriais();

         return false;
       }
       //var sId          = oRow.aCells[6].sId;
       //$(sId).innerHTML = (oRetorno.iCodigoBemInventario);

       // var nValorResidual    = js_strToFloat(oRow.aCells[7].getValue());
       // var nValorAtual       = js_strToFloat(oRow.aCells[6].getValue());
       // var nValorDepreciavel = nValorAtual - nValorResidual;
       // $("oTxtValorDepreciavel"+oParam.iCodigoBem).setValue(js_formatar(nValorDepreciavel, "f"));

     }
   });
  }
  function js_preencheGrid(aMateriais) {

   oGridMateriais.clearAll(true);
   aMateriais.each(function(oItem, iIndice){


   var valorPreco = oItem.valor_original;
   if(oItem.inventario != '' && oItem.dataprocessamento == ''){
    valorPreco = oItem.valormedio;
   }

    var oPreco = window["oTxtPreco" + oItem.codigo] = new DBTextField("oTxtPreco"+oItem.codigo, "oTxtPreco"+oItem.codigo , js_formatar(valorPreco, 'f'), 10);
    var Departamento = '<input tipe="hidden" value="'+oItem.coddepto+'" name="Departamento'+ oItem.codigo+oItem.codigo_material +'" id="Departamento'+ oItem.codigo+oItem.codigo_material +'">';

    oPreco.addEvent("onKeyPress", "return js_mask(event,\"0-9|,|-\")");
    oPreco.addStyle('width', '100%');
    oPreco.addStyle('height', '100%');
    oPreco.addStyle('text-align', 'right');
    oPreco.addStyle('border', '1px solid transparent');
    if(oItem.inventario ==$F('iInventario') || oItem.inventario ==$F('iInventario')){
     oPreco.addEvent("onFocus", "js_liberaDigitacao(this);");
   }
   oPreco.addEvent("onBlur", "js_atualizaValor(this, event);");
   oPreco.addEvent("onChange","js_valorAtualizado(this,"+oItem.codigo+","+iIndice+"); js_atualizaValor(this, event);");
   oPreco.addEvent("onKeyUp",'js_ValidaValor(this, event);');
   oPreco.setReadOnly(true);

   var valorContagem = oItem.estoque;
   if(oItem.inventario != '' && oItem.dataprocessamento == ''){
    valorContagem = oItem.contagem;
   }

    /*js_formatar((oItem.contagem === undefined || (oItem.contagem === null || oItem.inventario != '' || (oItem.dataprocessamento != '' && oItem.dataprocessamento != null)))? "0" : oItem.contagem, 'f')*/
   var oEstoque = window["oTxtEstoque" + oItem.codigo] = new DBTextField("oTxtEstoque"+oItem.codigo, "oTxtEstoque"+oItem.codigo , js_formatar(valorContagem, 'f'), 10);

   oEstoque.addEvent("onKeyPress", "return js_mask(event,\"0-9|,|-\")");
   oEstoque.addStyle('width', '100%');
   oEstoque.addStyle('height', '100%');
   oEstoque.addStyle('text-align', 'right');
   oEstoque.addStyle('border', '1px solid transparent');
   if(oItem.inventario== $F('iInventario') || oItem.inventario ==$F('iInventario')){
     oEstoque.addEvent("onFocus", "js_liberaDigitacao(this);");
   }
   oEstoque.addEvent("onBlur", "js_atualizaValor(this, event);");
   oEstoque.addEvent("onChange","js_valorEstoque(this,"+oItem.codigo+","+iIndice+"); js_atualizaValor(this, event);");
   oEstoque.addEvent("onKeyUp",'js_ValidaValor(this, event);');
   oEstoque.setReadOnly(true);

   var aLinha     = new Array();
   aLinha[0]  = oItem.codigo;
   aLinha[1]  = oItem.codigo_material;
   aLinha[2]  = oItem.descricao;
   aLinha[3]  = oItem.departamento;
   aLinha[4]  = oItem.estoque;
   aLinha[5]  = oEstoque.toInnerHtml();
   aLinha[6]  = oItem.valor_original;
   aLinha[7]  = oPreco.toInnerHtml()+Departamento;
   aLinha[8]  = oItem.inventario;

   if(oItem.dataprocessamento != '' && oItem.dataprocessamento != null){
    aLinha[8]  = '';
  }

    //aLinha[5]  = oItem.valor_original;
    var lCheck = true;

    if(oItem.inventario == '' || oItem.inventario == $F('iInventario') || (oItem.dataprocessamento != '' && oItem.dataprocessamento != null)){
      lCheck = false;
    }
    oGridMateriais.addRow(aLinha, false, lCheck);
    var oRowAdicionado = oGridMateriais.aRows[iIndice];
    if(oItem.inventario != '' || (oItem.dataprocessamento != '' && oItem.dataprocessamento != null)){
      if(oItem.inventario == $F('iInventario')){
        oRowAdicionado.setClassName('MateriaisAtualizados');
      }else if(oItem.dataprocessamento == '' || oItem.dataprocessamento == null) {
        oRowAdicionado.setClassName('MateriaisComInventario');

      }
    }
  });
   oGridMateriais.renderRows();
   $('col2').style.display="none";
   $('col4').style.width="399px";
   $('col5').style.width="333px";
   for (var i = 0; i < aMateriais.length; i++) {
     $('cntGridrow'+i+'cell0').style.display="none";
     $('cntGridrow'+i+'cell2').style.width="399px";
   }
 }
 function js_bloqueiaDigitacao(oObject) {

  oObject.readOnly         = true;
  oObject.style.border     ='0px';
  oObject.style.fontWeight = "normal";
  oObject.value            = oObject.value;
}
function js_ValidaValor(obj, event) {

  if ( js_countOccurs(obj.value, '.') > 1 ) {

    obj.value = js_getInputValue(obj.name);
    obj.focus();
    return false;
  }
}
function js_valorAtualizado(oInputValorAtualizado, codigo, iCodigoLinha) {

  var iValor = js_strToFloat($F('oTxtPreco'+codigo)).valueOf();
  var iValorAtual    = parseFloat(oInputValorAtualizado.getValue());

  if (iValorAtual < 0) {

    alert("Valor Negativo");
    $("oTxtPreco"+codigo).value = nValorAntigo;
    return false;
  }

  js_salvaDadosLinhaSelecionada(oGridMateriais.aRows[iCodigoLinha]);
}
function js_valorEstoque(oInputValorEstoque, codigo, iCodigoLinha) {

  var iValor = js_strToFloat($F('oTxtEstoque'+codigo)).valueOf();
  var iValorAtual    = parseFloat(oInputValorEstoque.getValue());

  if (iValorAtual < 0) {

    alert("Valor Negativo");
    $("oTxtEstoque"+codigo).value = nValorAntigo;
    return false;
  }

  js_salvaDadosLinhaSelecionada(oGridMateriais.aRows[iCodigoLinha]);
}
function js_atualizaValor(object, event) {

  object.value  = js_formatar(object.value,'f');
  var teclaPressionada = event.which;

  if (teclaPressionada == 27) {
    object.value = nValorAntigo;
  }
}
function js_liberaDigitacao (object) {

  nValorObjeto            = js_strToFloat(object.value).valueOf();
  object.value            = nValorObjeto;
  object.style.border     = '1px solid black';
  object.readOnly         = false;
  object.removeAttribute("class");

  object.style.fontWeight = "bold";
  object.select();

  nValorAntigo = object.value;
}
function js_styleLiberaDigitacao(oRow, oObject) {
  //console.log(oRow.aCells[1].getValue());
  // oObject.style.backgroundColor = "#fff";
  // oObject.style.border          = "0px solid transparent";
  // oObject.style.width           = "100%";
  // oObject.style.height          = "100%";
  // oObject.style.textAlign       = "right";
  // oObject.style.color           = "#000";



}
function js_mostraInventario(iInventario) {
  db_iframe_inventario.hide();
  $('iInventario').value = iInventario;
}

function js_pesquisaDepartamento(lMostra) {


  if (document.form1.iDepartamento.value == "" && lMostra == false){
    document.form1.iDepartamento.value = "";
      //document.form1.sDepartamento.value = "";

      return false;
    }


    sUrlLookup = "func_db_depart_material.php?pesquisa_chave="+document.form1.iDepartamento.value+"&funcao_js=parent.js_preencheDepartamento";
    if (lMostra) {
      var sUrlLookup = "func_db_depart_material.php?funcao_js=parent.js_mostraDepartamento|coddepto|descrdepto";
    }
    js_OpenJanelaIframe('', 'db_iframe_db_departorg', sUrlLookup, 'Pesquisa Departamentos', lMostra);
  }

  function js_mostraDepartamento(iCodigoDepartamento, sDescricao) {

    document.form1.iDepartamento.value = iCodigoDepartamento;
    //document.form1.sDepartamento.value = sDescricao;
    db_iframe_db_departorg.hide();
  }

  function js_preencheDepartamento(sDescricao, lErro) {

    //document.form1.sDepartamento.value = sDescricao;
    if (lErro) {
      document.form1.iDepartamento.value = "";
    }
  }

  function js_pesquisaDepartamento2(lMostra) {


    if (document.form1.iDepartamento2.value == "" && lMostra == false){
      document.form1.iDepartamento2.value = "";
      //document.form1.sDepartamento.value = "";

      return false;
    }


    sUrlLookup = "func_db_depart_material.php?pesquisa_chave="+document.form1.iDepartamento2.value+"&funcao_js=parent.js_preencheDepartamento2";
    if (lMostra) {
      var sUrlLookup = "func_db_depart_material.php?funcao_js=parent.js_mostraDepartamento2|coddepto|descrdepto";
    }
    js_OpenJanelaIframe('', 'db_iframe_db_departorg', sUrlLookup, 'Pesquisa Departamentos', lMostra);
  }

  function js_mostraDepartamento2(iCodigoDepartamento, sDescricao) {

    document.form1.iDepartamento2.value = iCodigoDepartamento;
    //document.form1.sDepartamento.value = sDescricao;
    db_iframe_db_departorg.hide();
  }

  function js_preencheDepartamento2(sDescricao, lErro) {

    //document.form1.sDepartamento.value = sDescricao;
    if (lErro) {
      document.form1.iDepartamento2.value = "";
    }
  }
  function js_pesquisaDepartamento3(lMostra) {


    if (document.form1.iDepartamento3.value == "" && lMostra == false){
      document.form1.iDepartamento3.value = "";
      //document.form1.sDepartamento.value = "";

      return false;
    }


    sUrlLookup = "func_db_depart_material.php?pesquisa_chave="+document.form1.iDepartamento3.value+"&funcao_js=parent.js_preencheDepartamento3";
    if (lMostra) {
      var sUrlLookup = "func_db_depart_material.php?funcao_js=parent.js_mostraDepartamento3|coddepto|descrdepto";
    }
    js_OpenJanelaIframe('', 'db_iframe_db_departorg', sUrlLookup, 'Pesquisa Departamentos', lMostra);
  }

  function js_mostraDepartamento3(iCodigoDepartamento, sDescricao) {

    document.form1.iDepartamento3.value = iCodigoDepartamento;
    //document.form1.sDepartamento.value = sDescricao;
    db_iframe_db_departorg.hide();
  }

  function js_preencheDepartamento3(sDescricao, lErro) {

    //document.form1.sDepartamento.value = sDescricao;
    if (lErro) {
      document.form1.iDepartamento3.value = "";
    }
  }

  function js_pesquisaMaterial2(lMostra) {


    if (document.form1.iMaterial2.value == "" && lMostra == false){
      document.form1.iMaterial2.value = "";
      //document.form1.sMaterial.value = "";

      return false;
    }


    sUrlLookup = "func_matestoque.php?pesquisa_chave="+document.form1.iMaterial2.value+"&funcao_js=parent.js_preencheMaterial2";
    if (lMostra) {
      var sUrlLookup = "func_matestoque.php?funcao_js=parent.js_mostraMaterial2|m60_codmater|m60_descr";
    }
    js_OpenJanelaIframe('', 'db_iframe_db_departorg', sUrlLookup, 'Pesquisa Materials', lMostra);
  }

  function js_mostraMaterial2(iCodigoMaterial, sDescricao) {

    document.form1.iMaterial2.value = iCodigoMaterial;
    //document.form1.sMaterial.value = sDescricao;
    db_iframe_db_departorg.hide();
  }

  function js_preencheMaterial2(sDescricao, lErro) {

    //document.form1.sMaterial.value = sDescricao;
    if (lErro) {
      document.form1.iMaterial2.value = "";
    }
  }
  function js_pesquisaMaterial3(lMostra) {


    if (document.form1.iMaterial3.value == "" && lMostra == false){
      document.form1.iMaterial3.value = "";
      //document.form1.sMaterial.value = "";

      return false;
    }


    sUrlLookup = "func_matestoque.php?pesquisa_chave="+document.form1.iMaterial3.value+"&funcao_js=parent.js_preencheMaterial3";
    if (lMostra) {
      var sUrlLookup = "func_matestoque.php?funcao_js=parent.js_mostraMaterial3|m60_codmater|m60_descr";
    }
    js_OpenJanelaIframe('', 'db_iframe_db_departorg', sUrlLookup, 'Pesquisa Materials', lMostra);
  }

  function js_mostraMaterial3(iCodigoMaterial, sDescricao) {

    document.form1.iMaterial3.value = iCodigoMaterial;
    //document.form1.sMaterial.value = sDescricao;
    db_iframe_db_departorg.hide();
  }

  function js_preencheMaterial3(sDescricao, lErro) {


    //document.form1.sMaterial.value = sDescricao;
    if (lErro) {
      document.form1.iMaterial3.value = "";
    }
  }

</script>
