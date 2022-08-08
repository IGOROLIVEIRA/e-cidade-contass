<?php

/**
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

$clrotulo = new rotulocampo;
$clrotulo->label("rh02_salari");
$clrotulo->label("h12_tiporeajuste");
$clrotulo->label("rh01_reajusteparidade");
$clrotulo->label("rh02_codreg");
$clrotulo->label("rh02_codreg");
$clrotulo->label("rh30_regime");
$clrotulo->label("rh30_descr");
$clrotulo->label("rh30_vinculo");
?>

<style>

  select, #percentual{
    width: 200px !important;
  }

  #InputIntervaloInicial,
  #InputIntervaloFinal {
    width: 84px;
  }

  #frm-reajuste #containnerTipoFiltrosFolha {
    padding-top: 9px;
  }

  #txtCodigooLancadorMatricula,
  #txtCodigooLancadorLotacao,
  #txtCodigooLancadorCargo {
    margin-right: 5px;
  }

  #txtDescricaooLancadorMatricula,
  #txtDescricaooLancadorLotacao,
  #txtDescricaooLancadorCargo {
    width: 260px;
    margin-right: 5px;
  }

  #divacoes {
    width: 497px;
  }
</style>

<form action="" method="post" class="container" id="frm-reajuste" style="width: 365px;">
  <fieldset>
    <legend>Reajuste Salarial</legend>

    <table border="0" class="form-container">
        <tr>
          <td width="120">
            <label>Competência: </label>
          </td>
          <td id="containerCompetencia"></td>
        </tr>
	<tr>
        <td align="right" nowrap title="Seleção:" >
        <?
	db_ancora("<b>Seleção:</b>","js_pesquisasel(true)",1);
	?>
        </td>
        <td>
          <?
          db_input('r44_selec',4,$Ir44_selec,true,'text',2,'onchange="js_pesquisasel(false)"');
          db_input('r44_descr',40,$Ir44_selec,true,'text',3,'');
          ?>
	</td>
      </tr>
	<tr>
          <td colspan="2" id="containnerTipoFiltrosFolha"></td>
        </tr>
        <tr>
          <td>
            <label>Vínculo: </label>
          </td>
          <td id="containerVinculo"></td>
       </tr>
       <tr id="tiporeajuste">
          <td>
            <label><?=$Lrh01_reajusteparidade?></label>
          </td>
          <td id="containerTipoReajuste"></td>
        </tr>
        <tr>
          <td>
            <label>Tipo de Lançamento: </label>
          </td>
          <td>
            <select id="tipoLancamento" name="lancar">
              <option value="a">Automático</option>
              <option value="m">Manual</option>
            </select>
          </td>
        </tr>
        <tr id="paralinha" style="display: none;">
          <td>
            <label>Para: </label>
          </td>
          <td>
              <select name="para" id="para">
                <option value="t">Todos</option>
                <option value="s">Funcionários com salário</option>
              </select>
          </td>
        </tr>
        <tr id="percentuallinha">
          <td>
            <label>Percentual: </label>
          </td>
          <td>
            <input type="text" name="perc" id="percentual" />
          </td>
        </tr>
    </table>
  </fieldset>

  <table>
      <tr>
        <td width="575" align="center">
          <input name="incluir" type="button" value="Processar" onclick="js_processar()" />
        </td>
      </tr>
  </table>
</form>

<script>

var oTiposFiltrosFolha = null;

(function(){

  var oCompetencia = new DBViewFormularioFolha.CompetenciaFolha(true);
  oCompetencia.renderizaFormulario($('containerCompetencia'));
  oCompetencia.desabilitarFormulario();

  var oTipoReajuste = new DBViewFormularioFolha.ComboTipoReajuste();
  oTipoReajuste.show($('containerTipoReajuste'));

  var oTipoReajuste = new DBViewFormularioFolha.ComboVinculo(false);
  oTipoReajuste.show($('containerVinculo'));

  oTiposFiltrosFolha = new DBViewFormularioFolha.DBViewTipoFiltrosFolha(<?=db_getsession("DB_instit")?>);
  oTiposFiltrosFolha.aTipos = [0, 5];
  oTiposFiltrosFolha.sInstancia = 'oTiposFiltrosFolha';
  oTiposFiltrosFolha.show($('containnerTipoFiltrosFolha'));

  $('para').disable();
  js_comportamentoCampos();

  $('percentual').ondrop = $('percentual').onpaste = function(){
    return false;
  };

  /**
   * Valida campo percentual.
   */
  //$('percentual').onkeyup, $('percentual').onpaste = function(event){
  $('percentual').onkeyup =  function(event){

    var lValidou = js_ValidaCampos(this, 4, 'Percentual', false, false, event);

    if (!lValidou) {
      event.preventDefault();
      return false;
    }
    return true;
  }

  $('tipoLancamento').setValue('a');

})();

function js_comportamentoCampos(){

  $('tipoLancamento').observe('change', function(){

    /**
     * Quando for automatico(a) desabilita o campo 'para'
     * e habilita o campo 'percentual'
     */
    if (this.value == 'a') {

      $('para').disable();
      $('paralinha').hide();
      $('percentual').removeAttribute('disabled');
      $('percentual').removeClassName('readOnly');
      $('percentuallinha').show();
    }

    /**
     * Quando for manual(m) habilita o campo 'para'
     * e desabilita o campo 'percentual'
     */
    if (this.value == 'm') {

      $('para').removeAttribute('disabled');
      $('paralinha').show();
      $('percentual').disable();
      $('percentual').addClassName('readOnly');
      $('percentuallinha').hide();
    }
  });
}

function js_processar(){

  /**
   * Verifica se foi informado o percentual.
   */
  if ( $F('tipoLancamento') == 'a' && empty($F('percentual')) ) {

    alert('Percentual é obrigatório.');
    return false;
  }

  /**
   * Verifica se o numero informado é válido
   */
  if ( isNaN(parseFloat($F('percentual'))) && $F('tipoLancamento') == 'a') {

      alert('Informe um valor válido para o campo escolhido.');
      return false;
  }

  /**
   * Valida se o valor informado para percentual não é 0
   */
  /*if (parseFloat($F('percentual')) == 0 && $F('tipoLancamento') == 'a') {

      alert('Os campos valor e percentual não podem ser preenchidos com o valor \'0\'.');
      return false;
  }

  /**
   * Verifica se o valor informado para percentual não é menor que 0
   */
  /*if (parseFloat($F('percentual')) < 0 && $F('tipoLancamento') == 'a') {

    alert('Os campos valor e percentual não podem ser menores que \'0\'.');
    return false;
  }

  /**
   * Se o tipo de relatorio difrente de geral e tipo de filtro igual a selecionado,
   * obrigar o lançamento de 1 registro no respectivo lançador.
   */
  var oTipoRelatorio = $F('oCboTipoRelatorio');
  var oTipoFiltro    = $F('oCboTipoFiltro');

  if (oTipoRelatorio != 0 && oTipoFiltro == 2) {

    var oLancadorSelecionado = oTiposFiltrosFolha.getLancadorAtivo().getRegistros();
    if (oLancadorSelecionado.length == 0) {

      alert('Por favor, realize ao menos o lançamento de um registro.');
      return false
    }
  }

  /**
   * Se o tipo de relatorio diferente de geral e tipo de filtro igual a Intervalo,
   * obrigar o preenchimento de intervalo.
   */
  if (oTipoRelatorio != 0 && oTipoFiltro == 1) {

    if (parseFloat($F('InputIntervaloInicial')) > parseFloat($F('InputIntervaloFinal'))) {
      alert('Por favor, informe um intervalo válido para o tipo de resumo selecionado.');
      return false;
    };

    if ($F('InputIntervaloInicial') == '' || $F('InputIntervaloFinal') == '') {

      alert('Por favor, informe um intervalo para o tipo de resumo selecionado.');
      return false;
    }
  }

  if($F('tipoLancamento') != "a"){
    $('frm-reajuste').action = "pes1_reajustesal002.php";
  }

  enviaDados();
}

function enviaDados(){

  var sMensagem = "Aguarde, buscando servidores...";

  if ($F('Vinculo') ==  'a') {
    sMensagem = "Aguarde, processando reajuste...";
  }

  js_divCarregando(sMensagem, "msgBox");

  var oQuery             = {}
  oQuery.sMetodo         = 'reajustaServidores';
  oQuery.iAno            = $F('ano');
  oQuery.iMes            = $F('mes');
  oQuery.sVinculo        = $F('Vinculo');
  oQuery.sTipoResumo     = $F('oCboTipoRelatorio');
  oQuery.sTipoLancamento = $F('tipoLancamento');
  oQuery.sPara           = $F('para');
  oQuery.iPercentual     = $F('percentual');
  oQuery.sTipoReajuste   = $F('tipoReajuste');
  oQuery.iSelec          = $F('r44_selec');

  /**
   * Verifica se o tipo escolhido foi intervalo
   */
  if ($F('oCboTipoFiltro') == 1) {

    oQuery.iIntervaloInicial = $F('InputIntervaloInicial');
    oQuery.iIntervaloFinal   = $F('InputIntervaloFinal');
  }

  /**
   * Verifica se o tipo escolhido foi seleção
   */
  if ($F('oCboTipoFiltro') == 2 ) {

    var aSelecionados = [];
    var oTipoFiltros = oTiposFiltrosFolha.getLancadorAtivo().getRegistros();

    /**
     * Percorre os itens selecionados no lancador
     */
    oTipoFiltros.each (function(oFiltro, iIndice) {
      aSelecionados[iIndice] = oFiltro.sCodigo;
    });

    oQuery.aRegistros = aSelecionados;

  }

  var sUrl = 'pes1_reajustesalarial.RPC.php';

  var oAjax = new Ajax.Request( sUrl, {
                                        method: 'post',
                                        parameters: "json=" + Object.toJSON(oQuery),
                                        onComplete: js_retornoReajuste
                                      }
                                    );
}

function js_retornoReajuste(sRetorno) {

  js_removeObj("msgBox");

  var oRetorno = eval("("+sRetorno.responseText+")");
  var sRegistros = '';
  if ($F('oCboTipoFiltro') == 2 ) {
    var aSelecionados = [];
    var oTipoFiltros = oTiposFiltrosFolha.getLancadorAtivo().getRegistros();
    oTipoFiltros.each (function(oFiltro, iIndice) {
      aSelecionados[iIndice] = oFiltro.sCodigo;
    });
    sRegistros = aSelecionados.join(',');
  }

  if ( oRetorno.redireciona ) {
    var intervalo = '';
    if ($F('oCboTipoFiltro') == 1) {
      intervalo = '&intervaloInicial='+$F('InputIntervaloInicial')+'&intervaloFinal='+$F('InputIntervaloFinal');
    }

    js_OpenJanelaIframe(
      '',
      'janelaReajuste',
      'pes1_reajustesal002.php?selecao='+$F('r44_selec')+'&vinculo='+$F('Vinculo')+'&tipoReajuste='+$F('tipoReajuste')+'&tipoResumo='+$F('oCboTipoRelatorio')+'&tipoLancamento='+$F('tipoLancamento')+'&para='+$F('para')+intervalo+'&registros='+sRegistros,
      'Processar reajuste salarial dos servidores.',
      true
    );
  } else {
    alert(oRetorno.sMessage.urlDecode());
    $('percentual').value = '';
  }

}
function js_setfocus(acao){
  if(document.form1.matini){
    js_tabulacaoforms("form1","matini",acao,1,"matini",acao);
  }else if(document.form1.lotini){
    js_tabulacaoforms("form1","lotini",acao,1,"lotini",acao);
  }else if(document.form1.rh01_regist){
    js_tabulacaoforms("form1","rh01_regist",acao,1,"rh01_regist",acao);
  }else if(document.form1.r70_estrut){
    js_tabulacaoforms("form1","r70_estrut",acao,1,"r70_estrut",acao);
  }else if(document.form1.tipfil){
    js_tabulacaoforms("form1","tipfil",acao,1,"tipfil",acao);
  }else{
    js_tabulacaoforms("form1","tipres",acao,1,"tipres",acao);
  }
}

function js_pesquisasel(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_selecao','func_selecao.php?funcao_js=parent.js_mostrasel1|r44_selec|r44_descr','Pesquisa',true);
  }else{
     if($('r44_selec').value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_selecao','func_selecao.php?pesquisa_chave='+$('r44_selec').value+'&funcao_js=parent.js_mostrasel','Pesquisa',false);
     }else{
       document.form1.r44_descr.value = '';
     }
  }
}
function js_mostrasel(chave,erro){
  $('r44_descr').value = chave;
  if(erro==true){
    $('r44_selec').focus();
    $('r44_selec').value = '';
  }
}
function js_mostrasel1(chave1,chave2){
  $('r44_selec').value = chave1;
  $('r44_descr').value = chave2;
  db_iframe_selecao.hide();
}
</script>
