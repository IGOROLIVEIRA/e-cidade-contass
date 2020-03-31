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

$oRotulo = new rotulocampo;
$oRotulo->label("ac16_sequencial");
$oRotulo->label("ac16_resumoobjeto");
$oRotulo->label("ac16_datainicio");
$oRotulo->label("ac16_datafim");
$oRotulo->label("coddepto");
$oRotulo->label("descrdepto");
$oRotulo->label("ac50_descricao");
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
    <form name="form1" method="post" action="con2_relatorioacordosavencer002.php" target='relatorioacordosavencer'>
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
              <b>Filtro Acordos à Vencer</b>
            </legend>
            <table border="0" width="100%">
            <tr>
              <td>
                <b>Filtrar por:</b>
              </td>
              <td>
                <?php
                  $aFiltros = array(1 => "Acordo", 2 => "Departamento");
                  db_select("iAgrupamento", $aFiltros, true, 1, "class='select' onchange='js_verificaFiltro(this.value)'");
                ?>
              </td>
            </tr>
            <tr id="trDepartInclusao" style="display:none;">
              <td colspan="4">
                <table>
                  <tr>
                    <td nowrap="nowrap"><?db_ancora('<b>Depto. de Inclusão:</b>', 'js_pesquisaDepartamento(true);', 1)?></td>
                    <td nowrap="nowrap">
                      <?php
                        db_input('iCodigoDepartInclusao', 17, @$Icoddepto, true, 'text', 1, " onchange='js_pesquisaDepartamento(false);' ");
                        db_input('sDescricaoDepartInclusao', 26, @$Idescrdepto, true, 'text', 3, "");
                      ?>
                    </td>
                    <td>
                      <input type="button" onClick="js_lancarDepartInclusao()" value="Lançar" />
                    </td>
                  </tr>
                  <tr>
                    <td colspan="3">
                      <div id="ctnDepartInclusao"></div>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr id="trDepartResponsavel" style="display:none;">
                <td colspan="4">
                    <table>
                        <tr>
                            <td nowrap="nowrap"><?db_ancora('<b>Depto. Responsável:</b>', 'js_pesquisaDepartResp(true);', 1)?></td>
                            <td nowrap="nowrap">
                                <?php
                                db_input('iCodigoDepartResponsavel', 17, @$Icoddepto, true, 'text', 1, " onchange='js_pesquisaDepartResp(false);' ");
                                db_input('sDescricaoDepartResponsavel', 26, @$Idescrdepto, true, 'text', 3, "");
                                ?>
                            </td>
                            <td>
                                <input type="button" onClick="js_lancarDepartResponsavel()" value="Lançar" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div id="ctnDepartResponsavel"></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
                <tr id="trDepartResponsavel" style="display:none;">
                    <td colspan="4">
                        <table>
                            <tr>
                                <td nowrap="nowrap"><?db_ancora('<b>Depto. Responsável:</b>', 'js_pesquisaDepartResp(true);', 1)?></td>
                                <td nowrap="nowrap">
									<?php
									db_input('iCodigoDepartResponsavel', 17, @$Icoddepto, true, 'text', 1, " onchange='js_pesquisaDepartResp(false);' ");
									db_input('sDescricaoDepartResponsavel', 26, @$Idescrdepto, true, 'text', 3, "");
									?>
                                </td>
                                <td>
                                    <input type="button" onClick="js_lancarDepartResponsavel()" value="Lançar" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div id="ctnDepartResponsavel"></div>
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
                  db_input('ac16_resumoobjeto', 40, $Iac16_resumoobjeto, true, 'text', 3);
                ?>
              </td>
            </tr>
            
            <tr>
              <td nowrap title="<?=@$Tac50_descricao?>">
    		        <?php
    		          db_ancora('<b>Categoria:</b>', "onchange=pesquisaCategoria(true)", 1);
    		        ?>
    		      </td>
    		      <td colspan="3">
    		        <?php
    		          db_input('ac50_sequencial', 10, $Iac50_descricao, true, 'text', 1,
    		                   "style='width: 83px;' onchange=pesquisaCategoria(false)");
    		          ?>
                <?php
    		          db_input('ac50_descricao', 40, $Iac50_descricao, true, 'text', 3);
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
                  $aOrdem = array(1=>'Data de Vigência',
                                  2=>'Contratado');
                  db_select('ordem', $aOrdem, true, 1, "style='width: 100%;'");
                ?>
              </td>
            </tr>
          </table>
          </fieldset>
        </td>
      </tr>
      <tr>
        <td style="text-align: center;">
          <input type='submit' value='Gerar Relatório' onclick="return js_gerarRelatorio();">
        </td>
      </tr>
    </table>
    </form>
  </center>
</body>
</html>
<script type="text/javascript">
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

  $('ac16_resumoobjeto').value = erro;
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

function js_gerarRelatorio(){

  $('ordemdescricao').value = $('ordem').options[$('ordem').selectedIndex].innerHTML;

  var dataInicio = $F('ac16_datainicio');
  var dataFim    = $F('ac16_datafim');
  var iAcordo    = $F("ac16_sequencial");

  /**
   * Se tiver preenchido algo no campo acordo, não vai haver verificação de data
   */
  if (iAcordo == "") {

    if (dataInicio != '' && dataFim != '') {
      if( !js_comparadata(dataInicio, dataFim, '<=') ) {
        alert("A Data de Início deve ser maior ou igual a Data de Fim!");
        return false;
      }
    } else {
      alert('Informe uma Date de Início e Data de Fim!');
      return false;
    }
  }

  var sVirgula         = '';
  var listaacordogrupo = '';

  if(typeof parent.iframe_grupoacordo != 'undefined'){
      for(let i=0; i < parent.iframe_grupoacordo.$('listaacordogrupo').length; i++) {
        listaacordogrupo += sVirgula + parent.iframe_grupoacordo.$('listaacordogrupo').options[i].value;
        sVirgula          = ",";
      }

      $('listaacordogrupo').value = listaacordogrupo;
  }

  var sVirgula        = '';
  var listacontratado = '';


  for(let i=0; i < parent.iframe_contratado.$('listacontratado').length; i++) {
    listacontratado += sVirgula + parent.iframe_contratado.$('listacontratado').options[i].value;
    sVirgula         = ",";
  }

  $('listacontratado').value = listacontratado;
  var sDepartsInclusao         = "";

    for (var iDepartamento = 0; iDepartamento < aDepartInclusao.length; iDepartamento++) {
		sDepartsInclusao += aDepartInclusao[iDepartamento].iDepartInclusao + ",";
	}

	if (sDepartsInclusao != "") {
		sDepartsInclusao = sDepartsInclusao.substring(0, sDepartsInclusao.length -1);
	}

	$("sDepartsInclusao").value = sDepartsInclusao;

    var sDepartsResponsavel         = "";

    for (var iDepartamento = 0; iDepartamento < aDepartResponsavel.length; iDepartamento++) {
        sDepartsResponsavel += aDepartResponsavel[iDepartamento].iDepartReponsavel + ",";
    }

    if (sDepartsResponsavel != "") {
        sDepartsResponsavel = sDepartsResponsavel.substring(0, sDepartsResponsavel.length -1);
    }

    $("sDepartsResponsavel").value = sDepartsResponsavel;

  jan = window.open('', 'relatorioacordosavencer',
                    'width='+(screen.availWidth-5)+', height='+(screen.availHeight-40)+', scrollbars=1, location=0');
  jan.moveTo(0,0);
  return true;
}

/**
 * Função para mostrar os campos necessários para os filtros
 */
function js_verificaFiltro(iValor) {
  /**
    * Filtro por acordo
   */
  if (iValor == 1) {

    $("trAcordos").style.display = "";
    $("trDepartInclusao").style.display = "none";
    $("trDepartResponsavel").style.display = "none";
  } else { // Filtro por departamento

    $("trDepartInclusao").style.display = "";
    $("trDepartResponsavel").style.display = "";
    $("trAcordos").style.display = "none";
  }
}

var aDepartInclusao         = new Array();
var aDepartResponsavel      = new Array();
var oGridDepartInclusao     = js_montaGrid("oGridDepartInclusao", "inclusao");
var oGridDepartResponsavel  = js_montaGrid("oGridDepartResponsavel", "responsavel");

/**
 * Monta grid
 */
function js_montaGrid(nomeGrid, tipoDepart) {

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

  if(tipoDepart == 'inclusao'){
      oGridDepartInclusao              = new DBGrid('datagridDepartInclusao');
      oGridDepartInclusao.sName        = 'datagridDepartInclusao';
      oGridDepartInclusao.nameInstance = 'oGridDepartInclusao';
      oGridDepartInclusao.setCellWidth( aWidth );
      oGridDepartInclusao.setCellAlign( aAlinhamentos );
      oGridDepartInclusao.setHeader( aHeader );
      oGridDepartInclusao.allowSelectColumns(true);
      oGridDepartInclusao.show( $('ctnDepartInclusao') );
      oGridDepartInclusao.clearAll(true);
      return oGridDepartInclusao;
  }else{
      oGridDepartResponsavel              = new DBGrid('datagridDepartResponsavel');
      oGridDepartResponsavel.sName        = 'datagridDepartResponsavel';
      oGridDepartResponsavel.nameInstance = 'oGridDepartResponsavel';
      oGridDepartResponsavel.setCellWidth( aWidth );
      oGridDepartResponsavel.setCellAlign( aAlinhamentos );
      oGridDepartResponsavel.setHeader( aHeader );
      oGridDepartResponsavel.allowSelectColumns(true);
      oGridDepartResponsavel.show( $('ctnDepartResponsavel') );
      oGridDepartResponsavel.clearAll(true);
      return oGridDepartResponsavel;
  }
}

function js_lancarDepartInclusao() {

  var sDescricaoDepartInclusao = $F('sDescricaoDepartInclusao');

  if ( sDescricaoDepartInclusao == '' ) {
    return false;
  }

    oDepartamento = new Object();
    oDepartamento.iDepartInclusao          = $F('iCodigoDepartInclusao');
    oDepartamento.sDescricaoDepartInclusao = sDescricaoDepartInclusao;
    oDepartamento.iIndice                  = aDepartInclusao.length;

  //Limpa os campos
  $('sDescricaoDepartInclusao').value = "";
  $('iCodigoDepartInclusao').value    = "";

  aDepartInclusao.push(oDepartamento);
  renderizarGrid(aDepartInclusao, 'inclusao');
}

function js_lancarDepartResponsavel() {

    var sDescricaoDepartResponsavel = $F('sDescricaoDepartResponsavel');

    if ( sDescricaoDepartResponsavel == '' ) {
        return false;
    }

    oDepartamento = new Object();
    oDepartamento.iDepartReponsavel           = $F('iCodigoDepartResponsavel');
    oDepartamento.sDescricaoDepartResponsavel = sDescricaoDepartResponsavel;
    oDepartamento.iIndice                     = aDepartResponsavel.length;

    //Limpa os campos
    $('sDescricaoDepartResponsavel').value = "";
    $('iCodigoDepartResponsavel').value    = "";

    aDepartResponsavel.push(oDepartamento);
    renderizarGrid(aDepartResponsavel, 'responsavel');
}

function js_removeDepartamentoLancado(iIndice, nomeGrid) {
    if(nomeGrid == 'inclusao'){
        aDepartInclusao.splice(iIndice, 1);
        renderizarGrid (aDepartInclusao, 'inclusao');
    }else{
        aDepartResponsavel.splice(iIndice, 1);
        renderizarGrid (aDepartResponsavel, 'responsavel');
    }

}

function renderizarGrid (lista, nomeGrid) {

    if(nomeGrid == 'inclusao'){
        oGridDepartInclusao.clearAll(true);

        for ( var iIndice = 0; iIndice < lista.length; iIndice++ ) {

          oDepartamento = lista[iIndice];

          var aLinha = new Array();

          aLinha[0] = oDepartamento.iDepartInclusao;
          aLinha[1] = oDepartamento.sDescricaoDepartInclusao;

          sDisabled = '';

          aLinha[2] = `<input type="button" value="Remover" onclick="js_removeDepartamentoLancado(${iIndice}, 'inclusao')" ${sDisabled}/>`;

          oGridDepartInclusao.addRow(aLinha, null, null, true);
        }

        oGridDepartInclusao.renderRows();
    }else{
        oGridDepartResponsavel.clearAll(true);

        for ( var iIndice = 0; iIndice < lista.length; iIndice++ ) {

            oDepartamento = lista[iIndice];

            var aLinha = new Array();

            aLinha[0] = oDepartamento.iDepartReponsavel;
            aLinha[1] = oDepartamento.sDescricaoDepartResponsavel;

            sDisabled = '';

            aLinha[2] = `<input type="button" value="Remover" onclick="js_removeDepartamentoLancado(${iIndice}, 'responsavel')" ${sDisabled}/>`;

            oGridDepartResponsavel.addRow(aLinha, null, null, true);
        }

        oGridDepartResponsavel.renderRows();
    }
}

/**
 * Funções para busca de departamentos
 */
function js_pesquisaDepartamento(lMostra) {

  var sFuncao = 'func_departamento.php?funcao_js=parent.js_mostraDepartInclusao|coddepto|descrdepto';

  if (lMostra == false) {

    var iDepartamento = $F('iCodigoDepartInclusao');
    sFuncao = 'func_departamento.php?pesquisa_chave='+iDepartamento+'&funcao_js=parent.js_completaDepartInclusao';
  }

  js_OpenJanelaIframe('', 'db_iframe_departamento', sFuncao,'Pesquisar Departamento', lMostra, '10');
}

function js_completaDepartInclusao(sDescricao, lErro) {

  $('sDescricaoDepartInclusao').value = sDescricao;

  if (lErro) {
    $('iCodigoDepartInclusao').focus();
    $('iCodigoDepartInclusao').value = '';
  }
}

function js_mostraDepartInclusao (iCodigo, sDescricao) {

  $('iCodigoDepartInclusao').value = iCodigo;
  $('sDescricaoDepartInclusao').value = sDescricao;
  db_iframe_departamento.hide();
}

/*
*
* Funções para busca de departamentos
*
*/
function js_pesquisaDepartResp(lMostra) {

    var sFuncao = 'func_departamento_alternativo.php?funcao_js=parent.js_mostraDepartResponsavel|dl_Codigo_Departamento|dl_Departamento';

    if (lMostra == false) {

        var iDepartamento = $F('iCodigoDepartResponsavel');
        sFuncao = 'func_departamento_alternativo.php?pesquisa_chave='+iDepartamento+'&funcao_js=parent.js_completaDepartResponsavel';
    }

    js_OpenJanelaIframe('', 'db_iframe_departamento_resp', sFuncao,'Pesquisar Departamento', lMostra, '10');
}

function js_completaDepartResponsavel(sDescricao, lErro) {
    $('sDescricaoDepartResponsavel').value = sDescricao;

    if (lErro) {
        $('iCodigoDepartResponsavel').focus();
        $('iCodigoDepartResponsavel').value = '';
    }
}

function js_mostraDepartResponsavel (iCodigo, sDescricao) {
    $('iCodigoDepartResponsavel').value = iCodigo;
    $('sDescricaoDepartResponsavel').value = sDescricao;
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

let categoria = document.getElementById('ac50_sequencial');

categoria.addEventListener('keyup', (e) => {
    js_verificaTipo(e.target);
});

function js_verificaTipo(obj){
    if(/[aA-zZ]/.test(obj.value)){
        alert('Insira somente números');
        document.getElementById(obj.id).value = '';
        return false;
    }
}

</script>
