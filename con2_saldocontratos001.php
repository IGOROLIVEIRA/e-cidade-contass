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
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_liborcamento.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_acordogrupo_classe.php");

$oRotulo = new rotulocampo;
$clacordogrupo = new cl_acordogrupo;
$clacordogrupo->rotulo->label();

$oRotulo->label("ac16_sequencial");
$oRotulo->label("ac16_resumoobjeto");
$oRotulo->label("ac16_datainicio");
$oRotulo->label("ac16_datafim");
$oRotulo->label("coddepto");
$oRotulo->label("descrdepto");

?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <?php
  db_app::load("scripts.js, strings.js, prototype.js,datagrid.widget.js, widgets/dbautocomplete.widget.js");
  db_app::load("widgets/windowAux.widget.js");
  ?>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
  <style>
   .fora {background-color: #d1f07c;}
 </style>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
  <center>
    <form name="form1" target='relatorioacordosavencer' id="form1"  method="get" action="con2_saldocontratos002.php"  >
      <input type="hidden" id="listaacordogrupo"             name="listaacordogrupo"             value="" />
      <input type="hidden" id="listacontratado"              name="listacontratado"              value="" />
      <input type="hidden" id="ordemdescricao"               name="ordemdescricao"               value="" />
      <input type="hidden" id="sDepartsInclusao"             name="sDepartsInclusao"             value="" />
      <input type="hidden" id="sDepartsResponsavel"          name="sDepartsResponsavel"          value="" />
      <table style="margin-top: 20px;">
        <tr>
          <td>
            <fieldset>
              <legend>
                <b>Saldo de Contratos</b>
              </legend>
              <table border="0" width="100%">
                <tr>
                  <td>
                    <b>Filtrar por:</b>
                  </td>
                  <td>
                    <?php
                    $aFiltros = array(1 => "Acordo", 2 => "Departamento", 3 => "Licitação");
                    db_select("iAgrupamento", $aFiltros, true, 1, "class='select' onchange='js_verificaFiltro(this.value)'");
                    ?>
                  </td>
                </tr>
                <tr id="trLicitacao" style="display: none;">
                  <td nowrap title="<?php echo $Tac16_sequencial; ?>" width="130">
                   <?php
                   db_ancora("Licitação", "js_pesquisa_liclicita(true);",1);
                   ?>
                 </td>
                 <td colspan="3">
                  <?php
                  db_input('ac16_licitacao', 10, $Iac16_sequencial, true, 'text', 1, "onchange='js_pesquisa_liclicita(false);'");
                  db_input('l20_objeto', 45, $Iac16_resumoobjeto, true, 'text', 3);
                  ?>
                </td>
              
                </tr>
                <tr id="trDepartInc" style="display:none;">
                  <td colspan="4">
                    <table>
                      <tr>
                        <td nowrap="nowrap"><?db_ancora('<b>Depart. de Inclusão:</b>', 'js_pesquisaDepartInc(true);', 1)?></td>
                        <td nowrap="nowrap">
                          <?php
                          db_input('iCodigoDepartInc', 17, @$Icoddepto, true, 'text', 1, " onchange='js_pesquisaDepartInc(false);' ");
                          db_input('sDescricaoDepartInc', 26, @$Idescrdepto, true, 'text', 3, "");
                          ?>
                        </td>
                        <td>
                          <input type="button" onClick="js_lancarDepartInc()" value="Lançar" />
                        </td>
                      </tr>
                      <tr>
                        <td colspan="3">
                          <div id="ctnDepartInc"></div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr id="trDepartResp" style="display:none;">
                  <td colspan="4">
                      <table>
                          <tr>
                              <td nowrap="nowrap"><?db_ancora('<b>Depart. Responsável:</b>', 'js_pesquisaDepartResp(true);', 1)?></td>
                              <td nowrap="nowrap">
                                  <?php
                                  db_input('iCodigoDepartResp', 17, @$Icoddepto, true, 'text', 1, " onchange='js_pesquisaDepartResp(false);' ");
                                  db_input('sDescricaoDepartResp', 26, @$Idescrdepto, true, 'text', 3, "");
                                  ?>
                              </td>
                              <td>
                                  <input type="button" onClick="js_lancarDepartResp()" value="Lançar" />
                              </td>
                          </tr>
                          <tr>
                              <td colspan="3">
                                  <div id="ctnDepartResp"></div>
                              </td>
                          </tr>
                      </table>
                  </td>
                </tr>
                <tr id="trAcordos">
                  <td nowrap title="<?php echo $Tac16_sequencial; ?>" width="130">
                   <?php
                   db_ancora($Lac16_sequencial, "js_acordo(true);",1);
                   ?>
                 </td>
                 <td colspan="3">
                  <?php
                  db_input('ac16_sequencial', 10, $Iac16_sequencial, true, 'text', 1, "onchange='js_acordo(false);'");
                  db_input('ac16_resumoobjeto', 45, $Iac16_resumoobjeto, true, 'text', 3);
                  ?>
                </td>
              </tr>

              <tr>
                <td title="<?=@$Tac02_acordonatureza?>">
                 <?
                 db_ancora(@$Lac02_acordonatureza,"js_pesquisaac02_acordonatureza(true);",$db_opcao);
                 ?>
               </td>
               <td colspan="3">
                <?
                db_input('ac02_acordonatureza',10,$Iac02_acordonatureza,true,'text',$db_opcao,
                 " onchange='js_pesquisaac02_acordonatureza(false);'");
                 db_input('ac01_descricao',45,$Iac01_descricao,true,'text',3,"");
                 ?>
               </td>
             </tr>

             <tr>
              <td align="left" title="<?=@$Tac16_datainicio?>">
                <?=@$Lac16_datainicio?>
              </td>
              <td align="left">
                <?php
                db_inputdata('ac16_datainicio',@$ac16_datainicio_dia,@$ac16_datainicio_mes,@$ac16_datainicio_ano,true,
                 'text',1);
                 ?>
               </td>
               <td align="right" title="<?=@$Tac16_datafim?>">
                <?=@$Lac16_datafim?>
              </td>
              <td align="right">
                <?
                db_inputdata('ac16_datafim',@$ac16_datafim_dia,@$ac16_datafim_mes,@$ac16_datafim_ano,true,
                 'text',1)
                 ?>
               </td>
             </tr>
             <tr>
              <td nowrap title="" width="100">
               <b>Ordem:</b>
             </td>
             <td colspan="3">
              <?
              $aOrdem = array(
                1=>'Data de Vigência',
                2=>'Contratado',
                3=>'Nº Acordo',
                4=>'Código Acordo'
                );
              db_select('ordem', $aOrdem, true, 1, "style='width: 100%;'");
              ?>
            </td>
            <input type="hidden" id="departamentos" name="departamentos" value="">
          </tr>
        </table>
      </fieldset>
    </td>
  </tr>
  <tr>
    <td style="text-align: center;">
      <input type='button' onclick="js_selecionarFormatoRelatorio();" value='Gerar Relatório' >
    </td>
  </tr>
</table>
</form>
<?php db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit")); ?>
</center>
</body>
</html>
<script type="text/javascript">
  function js_pesquisaac02_acordonatureza(mostra){
    if(mostra==true){
      var sUrl1 = 'func_acordonatureza.php?funcao_js=parent.js_mostraacordonatureza1|ac01_sequencial|ac01_descricao';
      js_OpenJanelaIframe('','db_iframe_acordonatureza',sUrl1,'Pesquisa',true,'0');
    }else{
     if($('ac02_acordonatureza').value != ''){
      var sUrl2 = 'func_acordonatureza.php?pesquisa_chave='+$('ac02_acordonatureza').value
      +'&funcao_js=parent.js_mostraacordonatureza';
      js_OpenJanelaIframe('','db_iframe_acordonatureza',sUrl2,'Pesquisa',false,'0');
    }else{
     $('ac01_descricao').value = '';
   }
 }
}
function js_mostraacordonatureza(chave1,chave2,erro){
  $('ac01_descricao').value = chave2;
  if(erro==true){
    $('ac02_acordonatureza').focus();
    $('ac02_acordonatureza').value = '';
    $('ac01_descricao').value      = chave1;
  }
}
function js_mostraacordonatureza1(chave1,chave2) {
  $('ac02_acordonatureza').value = chave1;
  $('ac01_descricao').value      = chave2;
  db_iframe_acordonatureza.hide();
}
function js_acordo(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_acordo',
      'func_acordo.php?lDepartamento=true&funcao_js=parent.js_mostraAcordo1|ac16_sequencial|ac16_resumoobjeto',
      'Pesquisa',true,0);
  } else {
   if($F('ac16_sequencial').trim() != ''){
    js_OpenJanelaIframe('','db_iframe_depart',
      'func_acordo.php?lDepartamento=true&pesquisa_chave='+$F('ac16_sequencial')+'&funcao_js=parent.js_mostraAcordo'+
      '&descricao=true',
      'Pesquisa',false,0);
  } else {
   $('ac16_resumoobjeto').value = '';
 }
}
}

function js_mostraAcordo(chave,erro){

  $('ac16_resumoobjeto').value = erro
  if(erro==true){
    $('ac16_sequencial').focus();
    $('ac16_sequencial').value = '';
  }
}

function js_mostraAcordo1(chave1,chave2){
  $('ac16_sequencial').value = chave1;
  $('ac16_resumoobjeto').value = chave2;
  db_iframe_acordo.hide();
}

function js_selecionarFormatoRelatorio() {
  if (document.getElementById('trLicitacao').style.display == '' && document.getElementById('ac16_licitacao').value == '')
    return alert("Usuário: Selecione a licitação.");

  var iHeight = 200;
  var iWidth = 300;
  windowFormatoRelatorio = new windowAux(
    "windowFormatoRelatorio",
    "Gerar Relatório ",
    iWidth,
    iHeight,
  );

  var sContent = "<div style='margin-top:30px;'>";
  sContent += "<fieldset>";
  sContent += "<legend>Gerar Relatório de Credenciados em:</legend>";
  sContent += "  <div >";
  sContent += "  <input checked type='radio' id='pdf' name='formato'>";
  sContent += "  <label>PDF</label>";
  sContent += "  </div>";
  sContent += "  <div>";
  sContent += "  <input type='radio' id='excel' name='formato'>";
  sContent += "  <label>EXCEL</label>";
  sContent += "  </div>";
  sContent += "</fieldset>";
  sContent += "<center>";
  sContent +=
    "<input type='button' id='btnGerar' value='Confirmar' onclick='js_gerarRelatorio()'>";
  sContent += "</center>";
  sContent += "</div>";
  windowFormatoRelatorio.setContent(sContent);
  windowFormatoRelatorio.show();

  document.getElementById("windowwindowFormatoRelatorio_btnclose").onclick = destroyWindow;
}

function destroyWindow() {
  windowFormatoRelatorio.destroy();
}

function js_gerarRelatorio(){

    let sDepartsInclusao = "";

    for (var iDepartamento = 0; iDepartamento < aDepartsInclusao.length; iDepartamento++) {
        sDepartsInclusao += aDepartsInclusao[iDepartamento].iDepartInc + ",";
    }

    if (sDepartsInclusao != "") {
        sDepartsInclusao = sDepartsInclusao.substring(0, sDepartsInclusao.length -1);
    }

    $("sDepartsInclusao").value = sDepartsInclusao;

    let sDepartsResponsavel = '';
    for (var iDepartamento = 0; iDepartamento < aDepartsResponsavel.length; iDepartamento++) {
        sDepartsResponsavel += aDepartsResponsavel[iDepartamento].iDepartResp + ",";
    }

    if (sDepartsResponsavel != "") {
        sDepartsResponsavel = sDepartsResponsavel.substring(0, sDepartsResponsavel.length -1);
    }

    $("sDepartsResponsavel").value = sDepartsResponsavel;

    filtros = 'ac16_sequencial=' + $F("ac16_sequencial") + '&iAgrupamento=' + $F("iAgrupamento") +
    '&ac02_acordonatureza=' + $F("ac02_acordonatureza") + '&ac16_datainicio=' + $F('ac16_datainicio') +
    '&ac16_datafim=' + $F('ac16_datafim') + '&ordem=' + $F('ordem') + '&sDepartsInclusao=' + $F('sDepartsInclusao') +
    '&sDepartsResponsavel=' + $F('sDepartsResponsavel') + '&ac16_licitacao=' + $F("ac16_licitacao");

    if (document.getElementById('pdf').checked == true) {
      jan = window.open('con2_saldocontratos002.php?'+filtros, '', 'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ');
      jan.moveTo(0, 0);
    }

    if (document.getElementById('excel').checked == true) {
      jan = window.open('con2_saldocontratosexcel002.php?'+filtros, '', 'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ');
      jan.moveTo(0, 0);
    }

}

/**
 * Função para mostrar os campos necessários para os filtros
 */
function js_verificaFiltro(iValor) {
  if (iValor == 1) {
    $("trAcordos").style.display = "";
    $("trDepartInc").style.display = "none";
    $("trDepartResp").style.display = "none";
    $("trLicitacao").style.display = "none";
    return true;
  }

  if (iValor == 2) {
    $("trDepartInc").style.display = "";
    $("trDepartResp").style.display = "";
    $("trAcordos").style.display = "none";
    $("trLicitacao").style.display = "none";
    return true;
  }

  $("trLicitacao").style.display = "";
  $("trAcordos").style.display = "none";
  $("trDepartInc").style.display = "none";
  $("trDepartResp").style.display = "none";
}


function js_pesquisa_liclicita(mostra) {
  if (mostra == true) {
    js_OpenJanelaIframe(
      "top.corpo",
      "db_iframe_liclicita",
      "func_liclicita.php?situacao=10&funcao_js=parent.js_mostraliclicita1|l20_codigo|l20_objeto",
      "Pesquisa",
      true,
    );
    return true;
  }

  if (document.form1.ac16_licitacao.value != "") {
    js_OpenJanelaIframe(
      "top.corpo",
      "db_iframe_liclicita",
      "func_liclicita.php?situacao=10&pesquisa_chave=" +
        document.form1.ac16_licitacao.value +
        "&funcao_js=parent.js_mostraliclicita",
      "Pesquisa",
      false,
    );
    return true;
  }

  document.form1.l20_codigo.value = "";
}

function js_mostraliclicita(l20_objeto, erro) {
  if (erro == true) {
    document.getElementById("ac16_licitacao").value = "";
    document.getElementById("l20_objeto").value = "";
    document.getElementById("ac16_licitacao").focus();
    return;
  }
  document.getElementById("l20_objeto").value = l20_objeto;
}

function js_mostraliclicita1(ac16_licitacao, l20_objeto) {
  document.getElementById("ac16_licitacao").value = ac16_licitacao;
  document.getElementById("l20_objeto").value = l20_objeto;
  db_iframe_liclicita.hide();
}

var aDepartsInclusao        = new Array();
var aDepartsResponsavel     = new Array();
var oGridDepartInclusao     = js_montaGrid(true);
var oGridDepartResponsavel  = js_montaGrid(false);

/**
 * Monta grid
 */
 function js_montaGrid(inclusao) {

  var aAlinhamentos = new Array();
  var aHeader       = new Array();
  var aWidth        = new Array();

  aHeader[0]       = 'Código';
  aHeader[1]       = 'Departamento';
  aHeader[2]       = 'Remover';

  aWidth[0]        = '10%';
  aWidth[1]        = '75%';
  aWidth[2]        = '15%';

  aAlinhamentos[0] = 'left';
  aAlinhamentos[1] = 'left';
  aAlinhamentos[2] = 'center';

    if(inclusao){
        oGridDepartInclusao              = new DBGrid('datagridDepartInc');
        oGridDepartInclusao.sName        = 'datagridDepartInc';
        oGridDepartInclusao.nameInstance = 'oGridDepartInclusao';
        oGridDepartInclusao.setCellWidth( aWidth );
        oGridDepartInclusao.setCellAlign( aAlinhamentos );
        oGridDepartInclusao.setHeader( aHeader );
        oGridDepartInclusao.allowSelectColumns(true);
        oGridDepartInclusao.show( $('ctnDepartInc') );
        oGridDepartInclusao.clearAll(true);
        return oGridDepartInclusao;
    }else{
        oGridDepartResponsavel              = new DBGrid('datagridDepartResp');
        oGridDepartResponsavel.sName        = 'datagridDepartResp';
        oGridDepartResponsavel.nameInstance = 'oGridDepartResponsavel';
        oGridDepartResponsavel.setCellWidth( aWidth );
        oGridDepartResponsavel.setCellAlign( aAlinhamentos );
        oGridDepartResponsavel.setHeader( aHeader );
        oGridDepartResponsavel.allowSelectColumns(true);
        oGridDepartResponsavel.show( $('ctnDepartResp') );
        oGridDepartResponsavel.clearAll(true);
        return oGridDepartResponsavel;
    }

}

function js_lancarDepartInc() {

  var sDescricaoDepartInc = $F('sDescricaoDepartInc');

  if ( sDescricaoDepartInc == '' ) {
    return false;
  }

  oDepartamento = new Object();
  oDepartamento.iDepartInc          = $F('iCodigoDepartInc');
  oDepartamento.sDescricaoDepartInc = sDescricaoDepartInc;
  oDepartamento.iIndice             = aDepartsInclusao.length;

  //Limpa os campos
  $('sDescricaoDepartInc').value = "";
  $('iCodigoDepartInc').value    = "";

  aDepartsInclusao.push(oDepartamento);
  renderizarGrid(aDepartsInclusao, true);
}

    function js_lancarDepartResp() {

        let sDescricaoDepartResp = $F('sDescricaoDepartResp');

        if ( sDescricaoDepartResp == '' ) {
            return false;
        }

        oDepartamento = new Object();
        oDepartamento.iDepartResp          = $F('iCodigoDepartResp');
        oDepartamento.sDescricaoDepartResp = sDescricaoDepartResp;
        oDepartamento.iIndice             = aDepartsResponsavel.length;

        //Limpa os campos
        $('sDescricaoDepartResp').value = "";
        $('iCodigoDepartResp').value    = "";

        aDepartsResponsavel.push(oDepartamento);
        renderizarGrid(aDepartsResponsavel, false);
    }

    function js_removeDepartamento(iIndice, inclusao) {

        if(inclusao){
            aDepartsInclusao.splice(iIndice, 1);
            renderizarGrid (aDepartsInclusao, true);
        }else{
            aDepartsResponsavel.splice(iIndice, 1);
            renderizarGrid (aDepartsResponsavel, false);
        }
    }

    function renderizarGrid (aDepartamentos, inclusao) {

     if(inclusao){
        oGridDepartInclusao.clearAll(true);
        for ( var iIndice = 0; iIndice < aDepartamentos.length; iIndice++ ) {

        oDepartamento = aDepartamentos[iIndice];

        var aLinha = new Array();

        aLinha[0] = oDepartamento.iDepartInc;
        aLinha[1] = oDepartamento.sDescricaoDepartInc;

        sDisabled = '';

        aLinha[2] = `<input type="button" value="Remover" onclick="js_removeDepartamento(${iIndice}, true)" ${sDisabled}/>`;

        oGridDepartInclusao.addRow(aLinha, null, null, true);
        }

        oGridDepartInclusao.renderRows();

     }else{
         oGridDepartResponsavel.clearAll(true);
         for ( var iIndice = 0; iIndice < aDepartamentos.length; iIndice++ ) {

             oDepartamento = aDepartamentos[iIndice];

             var aLinha = new Array();

             aLinha[0] = oDepartamento.iDepartResp;
             aLinha[1] = oDepartamento.sDescricaoDepartResp;

             sDisabled = '';

             aLinha[2] = `<input type="button" value="Remover" onclick="js_removeDepartamento(${iIndice}, false)" ${sDisabled}/>`;

             oGridDepartResponsavel.addRow(aLinha, null, null, true);
         }

         oGridDepartResponsavel.renderRows();
     }

}

/**
 * Funções para busca do departamento inclusão
 */
 function js_pesquisaDepartInc(lMostra) {

  var sFuncao = 'func_departamento.php?funcao_js=parent.js_mostraDepartInc|coddepto|descrdepto';

  if (lMostra == false) {

    var iDepartamento = $F('iCodigoDepartInc');
    sFuncao = 'func_departamento.php?pesquisa_chave='+iDepartamento+'&funcao_js=parent.js_completaDepartInc';
  }

  js_OpenJanelaIframe('', 'db_iframe_departamento', sFuncao,'Pesquisar Departamento', lMostra, '10');
}

function js_completaDepartInc(sDescricao, lErro) {

  $('sDescricaoDepartInc').value = sDescricao;

  if (lErro) {
    $('iCodigoDepartInc').focus();
    $('iCodigoDepartInc').value = '';
  }
}

function js_mostraDepartInc (iCodigo, sDescricao) {

  $('iCodigoDepartInc').value = iCodigo;
  $('sDescricaoDepartInc').value = sDescricao;
  db_iframe_departamento.hide();
}

    /**
    * Funções para busca do departamento responsável
    */

    function js_pesquisaDepartResp(lMostra) {

        // coddepto as dl_Codigo_Departamento, descrdepto as dl_Departamento
        var sFuncao = 'func_departamento_alternativo.php?funcao_js=parent.js_mostraDepartResp|dl_Codigo_Departamento|dl_Departamento';

        if (lMostra == false) {

            var iDepartamento = $F('iCodigoDepartResp');
            sFuncao = 'func_departamento_alternativo.php?pesquisa_chave='+iDepartamento+'&funcao_js=parent.js_completaDepartResp';
        }

        js_OpenJanelaIframe('', 'db_iframe_departamento_resp', sFuncao,'Pesquisar Departamento', lMostra, '10');
    }

    function js_completaDepartResp(sDescricao, lErro) {

        $('sDescricaoDepartResp').value = sDescricao;

        if (lErro) {
            $('iCodigoDepartResp').focus();
            $('iCodigoDepartResp').value = '';
        }
    }

    function js_mostraDepartResp (iCodigo, sDescricao) {

        $('iCodigoDepartResp').value = iCodigo;
        $('sDescricaoDepartResp').value = sDescricao;
        db_iframe_departamento_resp.hide();
    }


function pesquisaCategoria(lMostra) {

  var sFuncaoPesquisa   = 'func_acordocategoria.php?funcao_js=parent.js_mostraCategoria|';
  sFuncaoPesquisa  += 'ac50_sequencial|ac50_descricao';

  if (!lMostra) {

    if ($('ac50_sequencial').value != '') {

      sFuncaoPesquisa   = "func_acordocategoria.php?pesquisa_chave="+$F('ac50_sequencial');
      sFuncaoPesquisa  += "&funcao_js=parent.js_completaCategoria";
    } else {
      $('ac50_descricao').value = '';
    }
  }
  js_OpenJanelaIframe('', 'db_iframe_acordocategoria', sFuncaoPesquisa, 'Pesquisar Categorias de Acordo',lMostra, '0');
}

function js_completaCategoria(chave1, chave2) {

  $('ac50_descricao').value  = chave1;
  $('ac50_sequencial').focus();

  db_iframe_acordocategoria.hide();
}

function js_mostraCategoria(chave1, chave2) {

  $('ac50_sequencial').value = chave1;
  $('ac50_descricao').value  = chave2;
  $('ac50_sequencial').focus();

  db_iframe_acordocategoria.hide();
}
</script>
