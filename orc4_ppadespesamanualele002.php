<?php
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2012  DBselller Servicos de Informatica             
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

/**
 * 
 * @author I
 * @revision $Author: dbiuri $
 * @version $Revision: 1.9 $
 */
require("libs/db_stdlib.php");
require("libs/db_utils.php");
require("libs/db_app.utils.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_ppadotacao_classe.php");
include("dbforms/db_funcoes.php");
$db_opcao = 1;
$clppadotacao = new cl_ppadotacao();
$clppadotacao->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("o54_anousu");
$clrotulo->label("o56_codele");
$clrotulo->label("o55_descr");
$clrotulo->label("o40_descr");
$clrotulo->label("o41_descr");
$clrotulo->label("o52_descr");
$clrotulo->label("o53_descr");
$clrotulo->label("o54_anousu");
$clrotulo->label("o55_descr");
$clrotulo->label("o55_descr");
$clrotulo->label("o56_codele");
$clrotulo->label("o56_elemento");
$clrotulo->label("o05_valor");
$clrotulo->label("o11_descricao");
$clrotulo->label("o08_concarpeculiar");
$clrotulo->label("c58_descr");
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<?
db_app::load("scripts.js");
db_app::load("prototype.js");
db_app::load("datagrid.widget.js");
db_app::load("strings.js");
db_app::load("grid.style.css");
db_app::load("estilos.css");
?>
<style>
.dotacaoautomatica {
  background-color:  #d1f07c;
}
.dotacaonormal {
  background-color:  #FFFFFF;
}
#o56_descr {
    width: 311px;
}
#o15_descr, #o11_descricao, #c58_descr {
    width: 420px;
}
</style>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="js_init()">
<center> 
<form method="post" name='form1'>
  <table width="850px">
   <tr>
   <td>
   <fieldset><legend><b>Elementos</legend>
   <center> 
   <table>
     <tr>
    <td nowrap title="<?=@$To08_elemento?>">
       <?
       db_ancora(@$Lo08_elemento,"js_pesquisao08_elemento(true);",$db_opcao, "","o08_elementoancora");
       
       ?>
    </td>
    <td> 
     <?
     db_input('o08_elemento',10,$Io08_elemento,true,'text',$db_opcao," onchange='js_pesquisao08_elemento(false,this);'");
     db_input('o56_elemento',13,$Io56_elemento,true,'text',$db_opcao," onchange='js_pesquisao08_elemento(false,this);'");
     db_input('o56_descr',41,$Io56_codele,true,'text',3,'');
     db_input('oo8_sequencial',10,0,true,'hidden',3,'')  
     ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$To08_recurso?>">
     <? 
       db_ancora(@$Lo08_recurso,"js_pesquisac62_codrec(true);",$db_opcao, "", "o08_recursoancora");
     ?>  
    </td>
    <td> 
    <?
    db_input('o08_recurso',10,$Io08_recurso,true,'text',$db_opcao,"onchange='js_pesquisac62_codrec(false);'");
    db_input('o15_descr',56,$Io08_recurso,true,'text',3,"");
    ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$To08_localizadorgastos?>">
       <?
       db_ancora(@$Lo08_localizadorgastos,"js_pesquisao08_localizadorgastos(true);",$db_opcao,"","o08_gastosancora");
       ?>
    </td>
    <td> 
   <?
   $o08_localizadorgastos = 3;
   db_input('o08_localizadorgastos',10,$Io08_localizadorgastos,true,'text',$db_opcao," onchange='js_pesquisao08_localizadorgastos(false);'");  
   db_input('o11_descricao',40,$Io11_descricao,true,'text',3,'');
    ?>
    </td>
    </tr>
    <tr>
        <td nowrap title="<?=@$To08_concarpeculiar?>">
      <?
            db_ancora ( @$Lo08_concarpeculiar, "js_pesquisao08_concarpeculiar(true);", $db_opcao );
            ?>
      </td>
        <td> 
      <?    
            $o08_concarpeculiar = '000';
            db_input ( 'o08_concarpeculiar', 10, $Io08_concarpeculiar, true, 'text', $db_opcao, " onchange='js_pesquisao08_concarpeculiar(false);'" );
            db_input ( 'c58_descr', 40, $Ic58_descr, true, 'text', 3, '' );
            ?>
      </td>
    </tr>
    <tr>
      <td> 
        <b>Ano:</b>
      </td>
      <td>
       <?
        db_input('o05_anoreferencia',10,3, true,'text',1,"onchange='js_validaAno(this);'");
       ?> 
      </td>
    </tr>
    <tr>
      <td> 
        <b>Valor:</b>
      </td>
      <td>
       <?
        db_input('o05_valor',10,$Io05_valor, true,'text',1,"");
       ?> 
      </td>
    </tr>
    <tr>
      <td colspan='2' style='text-align:center;' valign="middle" >
        <hr style='color:white'>
        <input id='btnsalvar'   type='button' value='Salvar' onclick='js_save()'>
        <input id='btnexcluir'  type='button' value='Excluir' onclick='js_excluir()' disabled>
        <input id='btncancelar' type='button' value='Cancelar' >
      </td>
    </tr>
    </center>
  </table>
  </fieldset>
  </tr>
  <tr>
      <td colspan="5">
        <fieldset>
          <legend><b>Elementos/Recursos</b></legend>
          <div id='gridItensPPA'> 
          </div>
        </fieldset>      
   </td>
  </table>
</form>
</center>
</body>
</html>
<script>
iAnoIni     = 0;
iAnoFim     = 0;
iCodigoItem = null;
function js_pesquisao08_elemento(mostra,elemento){
    
    let sUrl = '';

    if (mostra==true) {

        sUrl = 'func_orcelemento.php?funcao_js=parent.js_mostraorcelemento1|o56_codele|o56_descr|o56_elemento&analitica=1';
        js_openJanela(sUrl, true);
        
    } else {

        if (elemento.name == 'o08_elemento' && document.form1.o08_elemento.value != '') {

            sUrl = 'func_orcelemento.php?pesquisa_chave='+document.form1.o08_elemento.value+
                    '&funcao_js=parent.js_mostraorcelemento&tipo_pesquisa=1&analitica=1&busca_elemento=true';

        } else if (elemento.name == 'o56_elemento' && document.form1.o56_elemento.value != '') {

            sUrl = 'func_orcelemento.php?pesquisa_chave='+document.form1.o56_elemento.value+
                    '&funcao_js=parent.js_mostraorcelemento&analitica=1&busca_elemento=true';

        } else {
            document.form1.o56_descr.value = '';
        }

        js_openJanela(sUrl, false);

    }
}

function js_openJanela(sUrl = '', mostra = null) {

    if (sUrl != '' && mostra != null) {

        js_OpenJanelaIframe('top.corpo.iframe_ppadotacaoele',
                            'db_iframe_orcelemento',
                            sUrl,
                            'Elementos da Despesa',
                            mostra);
    }
}

function js_mostraorcelemento(chave1,erro,chave2,chave3){

  document.form1.o56_descr.value    = chave1;
  document.form1.o56_elemento.value = chave2;
  document.form1.o08_elemento.value = chave3;
   
  if(erro==true){ 
    document.form1.o08_elemento.focus(); 
    document.form1.o08_elemento.value = ''; 
    document.form1.o56_elemento.value = '';
    document.form1.o08_elemento.value = '';
  }
}
function js_mostraorcelemento1(chave1,chave2,chave3){
  document.form1.o08_elemento.value = chave1;
  document.form1.o56_descr.value    = chave2;
  document.form1.o56_elemento.value = chave3;
  db_iframe_orcelemento.hide();
}
function js_pesquisao08_localizadorgastos(mostra){
  
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo.iframe_ppadotacaoele',
                        'db_iframe_ppasubtitulolocalizadorgasto',
                        'func_ppasubtitulolocalizadorgasto.php?funcao_js=parent.js_mostrappasubtitulolocalizadorgasto1|o11_sequencial|o11_descricao',
                        'Pesquisa',true);
  }else{
     if(document.form1.o08_localizadorgastos.value != ''){ 
        js_OpenJanelaIframe('top.corpo.iframe_ppadotacaoele','db_iframe_ppasubtitulolocalizadorgasto','func_ppasubtitulolocalizadorgasto.php?pesquisa_chave='+document.form1.o08_localizadorgastos.value+'&funcao_js=parent.js_mostrappasubtitulolocalizadorgasto','Pesquisa',false);
     }else{
       document.form1.o11_descricao.value = ''; 
     }
  }
}
function js_mostrappasubtitulolocalizadorgasto(chave,erro){
  document.form1.o11_descricao.value = chave; 
  if(erro==true){ 
    document.form1.o08_localizadorgastos.focus(); 
    document.form1.o08_localizadorgastos.value = ''; 
  }
}
function js_mostrappasubtitulolocalizadorgasto1(chave1,chave2){
  document.form1.o08_localizadorgastos.value = chave1;
  document.form1.o11_descricao.value = chave2;
  db_iframe_ppasubtitulolocalizadorgasto.hide();
}

function js_pesquisac62_codrec(mostra){
   if(mostra==true){
       js_OpenJanelaIframe('top.corpo.iframe_ppadotacaoele',
                           'db_iframe_orctiporec',
                           'func_orctiporec.php?funcao_js=parent.js_mostraorctiporec1|o15_codigo|o15_descr',
                           'Recursos',true);
   }else{
       if(document.form1.o08_recurso.value != ''){ 
           js_OpenJanelaIframe('top.corpo.iframe_ppadotacaoele',
                               'db_iframe_orctiporec','func_orctiporec.php?pesquisa_chave='
                                +document.form1.o08_recurso.value+'&funcao_js=parent.js_mostraorctiporec',
                                'Pesquisa',false);
       }else{
           document.form1.o15_descr.value = ''; 
       }
   }
}
function js_mostraorctiporec(chave,erro){
   document.form1.o15_descr.value = chave; 
   if(erro==true){ 
      document.form1.o08_recurso.focus(); 
      document.form1.o08_recurso.value = ''; 
   } 
}

function js_mostraorctiporec1(chave1,chave2){
    document.form1.o08_recurso.value = chave1;
    document.form1.o15_descr.value = chave2;
    db_iframe_orctiporec.hide();
}

function js_pesquisao08_concarpeculiar(mostra){
  
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo.iframe_ppadotacaoele',
                        'db_iframe_concarpeculiar',
                        'func_concarpeculiar.php?funcao_js=parent.js_mostraconcarpeculiar1|c58_sequencial|c58_descr',
                        'Pesquisa',true,0,0);
  }else{
     if(document.form1.o08_concarpeculiar.value != ''){ 
        js_OpenJanelaIframe('top.corpo.iframe_ppadotacaoele','db_iframe_concarpeculiar','func_concarpeculiar.php?pesquisa_chave='+document.form1.o08_concarpeculiar.value.trim()+'&funcao_js=parent.js_mostraconcarpeculiar','Pesquisa',false);
     }else{
       $("o08_concarpeculiar").setValue(''); 
     }
  }
}

function js_mostraconcarpeculiar(chave,erro){
  $("c58_descr").value = chave; 
  if(erro==true){ 
    $("o08_concarpeculiar").focus(); 
    $("o08_concarpeculiar").setValue(''); 
  }
}

function js_mostraconcarpeculiar1(chave1,chave2){
  $("o08_concarpeculiar").setValue(chave1); 
  $("c58_descr").setValue(chave2); 
  db_iframe_concarpeculiar.hide();
}


function js_init() {
  
  iCodigoItem = null;
  oGridPPA = new DBGrid('oGridPPA');
  oGridPPA.nameInstance = 'oGridPPA';
  oGridPPA.allowSelectColumns(true);
  oGridPPA.setHeight(150);
  oGridPPA.setCellWidth(new Array("6%","48%","10%","10%","4%","4%","8%","6%"));
  oGridPPA.setCellAlign(new Array("right","left","center","center","center","center","center","center"));
  oGridPPA.setHeader(new Array(
                              "Código",
                              "Elemento", 
                              "Recurso",
                              "Localizador",
                              "CP/CA",
                              "Ano",
                              "Valor",
                              "Ação"
                                ));
 oGridPPA.show(document.getElementById('gridItensPPA'));
}      

function addValoresGrid(aValores, db_opcao = null) {
  js_limparCampos();
  oGridPPA.clearAll(true);
  $('btnsalvar').disabled = false;
  if (top.corpo.iframe_ppadotacao.$('db_opcao').disabled || db_opcao == 3) {
    $('btnsalvar').disabled = true; 
  }
  aValores.each(function(oElemento,id) {
  
     aLinha = new Array();
     aLinha[0]  = oElemento.o05_sequencial;   
     aLinha[1]  = oElemento.o56_elemento+' - '+oElemento.o56_descr.urlDecode();   
     aLinha[2]  = oElemento.o08_recurso;   
     aLinha[3]  = oElemento.o08_localizadorgastos;   
     aLinha[4]  = oElemento.o08_concarpeculiar.urlDecode();   
     aLinha[5]  = oElemento.o05_anoreferencia;   
     aLinha[6]  = js_formatar(oElemento.o05_valor,'f'); 
     if (top.corpo.iframe_ppadotacao.$('db_opcao').disabled || db_opcao == 3) {
       aLinha[7]  = '';
     } else {
       aLinha[7]  = "<input id='teste' type='button' value='Editar' onclick='js_editarValor("+id+")'>";
     }
     oGridPPA.addRow(aLinha);
     if (oElemento.o19_coddot != "") {
      oGridPPA.aRows[id].setClassName('dotacaoautomatica');
     } else {
       oGridPPA.aRows[id].setClassName('dotacaonormal');
     }
     
  });
  oGridPPA.renderRows();
                             
}

function js_editarValor(key) {

  setReadOnly(false);
  
  $('o05_anoreferencia').style.backgroundColor   = "#DEB887";
  $('o05_anoreferencia').readOnly                = true;
  oGridPPA.aRows[key].isSelected = true;
  var aItem   = oGridPPA.getSelection();
  iLinha      = key;
  oGridPPA.aRows[key].isSelected = false;
  iCodigoItem           = aItem[0][0];
  var oParam            = new Object();
  oParam.exec           = "getInformacaoEstivativa";
  oParam.o05_sequencial = iCodigoItem;
  js_divCarregando('Aguarde, Pesquisando','msgbox');
  var oRequest = new Ajax.Request(
                                 'orc4_ppadotacaoalteracaoRPC.php',
                                  {
                                   method    : 'post', 
                                   parameters: 'json='+Object.toJSON(oParam), 
                                   onComplete: js_retornoEditaValor 
                                  }
                                );
                                           
}
function js_retornoEditaValor(oRequest) {
  
  js_removeObj('msgbox');
  var oRetorno = eval("("+oRequest.responseText+")");
  if (oRetorno.status == 1) {
    
    /**
     * Colcamos o objeto com os dados do item no escopo global
     */
    oObjetoSelecionado =  oRetorno.itens;
    if (oRetorno.itens.o19_coddot != "") {
    
       setReadOnly(true);
    } 
    var a = $$('input[type=text],select');
    a.each(function(input,id) {
       
       var valor   = eval("oRetorno.itens."+input.id);
       if (valor    != null ) {
         input.value = valor.urlDecode();
         
       }
       
     });
     $('btnsalvar').disabled   = false;
     $('btnexcluir').disabled = false;
     
  }
}

function setReadOnly(lReadOnly) {

  if (lReadOnly) {
  
    $('o08_elemento').style.backgroundColor          = "#DEB887";
    $('o08_elemento').readOnly                       = true;
    $('o08_elementoancora').onclick                  ='return false';
    $('o08_recurso').style.backgroundColor           = "#DEB887";
    $('o08_recurso').readOnly                        = true;
    $('o08_recursoancora').onclick                   ='return false';  
    //$('o08_localizadorgastos').style.backgroundColor = "#DEB887";
    //$('o08_localizadorgastos').readOnly              = true;
    //$('o08_gastosancora').onclick                    ='return false';
     
  } else {
  
    $('o08_elemento').style.backgroundColor          = "#FFFFFF";
    $('o08_elemento').readOnly                       = false;
    $('o08_elementoancora').onclick                  = function (){js_pesquisao08_elemento(true)};
    $('o08_recurso').style.backgroundColor           = "#FFFFFF";
    $('o08_recurso').readOnly                        = false;
    $('o08_recursoancora').onclick                   = function (){js_pesquisac62_codrec(true)};  
    //$('o08_localizadorgastos').style.backgroundColor = "#FFFFFF";
    //$('o08_localizadorgastos').readOnly              = false;
    //$('o08_gastosancora').onclick                    = function (){js_pesquisao08_localizadorgastos(true)}; 
    
    
  }
}

function js_save() {

  var oParam                   = new Object();
  
  if ($F('o08_concarpeculiar') == "") {
  
     alert("Você deve selecionar uma C.Peculiar/Cod. de Aplicação antes de incluir o registro.");
     return false;
  }
  if (iCodigoItem != null) {

    let atualiza_anos_seguintes = false;
    atualiza_anos_seguintes = confirm("Deseja atualizar os valores dos anos seguintes?");  
    
    oParam.exec                  = "salvarElemento";
    oParam.o05_sequencial        = iCodigoItem;
    oParam.o08_sequencial        = oObjetoSelecionado.o08_sequencial;
    oParam.o08_elemento          = $F('o08_elemento');    
    oParam.o08_recurso           = $F('o08_recurso');    
    oParam.o08_localizadorgastos = $F('o08_localizadorgastos');    
    oParam.o08_concarpeculiar    = $F('o08_concarpeculiar');    
    oParam.o19_coddot            = oObjetoSelecionado.o19_coddot;    
    oParam.o05_valor             = $F('o05_valor');
    oParam.o05_anoreferencia     = $F('o05_anoreferencia');
    oParam.atualiza_anos_seguintes = atualiza_anos_seguintes;
    js_divCarregando('Aguarde, Salvando Dotação','msgbox');
    var oRequest = new Ajax.Request(
                                 'orc4_ppadotacaoalteracaoRPC.php',
                                  {
                                   method    : 'post', 
                                   parameters: 'json='+Object.toJSON(oParam), 
                                   onComplete: js_retornoSave 
                                  }
                                );
    
  } else {
    
    var sMsgInclusao  = "Será incluído as projeções ate o último ano do ppa, conforme as configuracoes ";
        sMsgInclusao += "do cenário macroeconômico configurado para o Elemento.\n";
       
    $('btnsalvar').disabled               = true;
    oParam.exec                           = 'incluirAcao';
    oParam.ultimoano                      = iAnoFim;
    oParam.o08_ppaversao                  = top.corpo.iframe_ppadotacao.$F('o05_ppaversao');
    oParam.oDotacao                       = new Object();
    oParam.oDotacao.iAno                  = $F('o05_anoreferencia');    
    oParam.oDotacao.o08_orgao             = top.corpo.iframe_ppadotacao.$F('o08_orgao');    
    oParam.oDotacao.o08_unidade           = top.corpo.iframe_ppadotacao.$F('o08_unidade');    
    oParam.oDotacao.o08_funcao            = top.corpo.iframe_ppadotacao.$F('o08_funcao')    
    oParam.oDotacao.o08_subfuncao         = top.corpo.iframe_ppadotacao.$F('o08_subfuncao');    
    oParam.oDotacao.o08_programa          = top.corpo.iframe_ppadotacao.$F('o08_programa');
    oParam.oDotacao.o08_concarpeculiar    = $F('o08_concarpeculiar');       
    oParam.oDotacao.o08_projativ          = top.corpo.iframe_ppadotacao.$F('o08_projativ');    
    oParam.oDotacao.o08_elemento          = $F('o08_elemento');    
    oParam.oDotacao.o08_recurso           = $F('o08_recurso');    
    oParam.oDotacao.nValor                = $F('o05_valor');    
    oParam.oDotacao.o08_localizadorgastos = $F('o08_localizadorgastos');
    sMsgInclusao += "Confirma Inclusão?";
    if (!confirm(sMsgInclusao)) {
      return false;
    }
    
    js_divCarregando('Aguarde, Salvando Dotação','msgbox');
    var oRequest = new Ajax.Request(
                                 'orc4_ppadotacaoalteracaoRPC.php',
                                  {
                                   method    : 'post', 
                                   parameters: 'json='+Object.toJSON(oParam), 
                                   onComplete: js_retornoInclusao
                                  }
                                ); 
  }
  
  
}
function js_retornoInclusao(oResponse) {
  
  js_removeObj('msgbox');
  var oRetorno = eval("("+oResponse.responseText+")");
  if (oRetorno.status == 1) {
  
    var iFuncao    = top.corpo.iframe_ppadotacao.$F('o08_funcao');
    var iSubFuncao = top.corpo.iframe_ppadotacao.$F('o08_subfuncao');  
    var iUnidade   = top.corpo.iframe_ppadotacao.$F('o08_unidade');  
    var iOrgao     = top.corpo.iframe_ppadotacao.$F('o08_orgao');  
    var iPrograma  = top.corpo.iframe_ppadotacao.$F('o08_programa');  
    var iProjAtiv  = top.corpo.iframe_ppadotacao.$F('o08_projativ');  
    var iPpaVersao = top.corpo.iframe_ppadotacao.$F('o05_ppaversao');
    
    top.corpo.iframe_ppadotacao.js_preenchepesquisa(iOrgao, 
                                                    iUnidade,
                                                    iFuncao,
                                                    iSubFuncao,
                                                    iPrograma,
                                                    iProjAtiv,
                                                    iPpaVersao
                                                    ); 
    $('btncancelar').click();
  } else {
    alert(oRetorno.message.urlDecode());
  }
  $('btnsalvar').disabled   = false;
  
}
function js_retornoSave(oRequest) {
  
  js_removeObj('msgbox');
  var oRetorno = eval("("+oRequest.responseText+")");
  if (oRetorno.status == 1) {
   
    js_limparCampos(); 
    delete iLinha;
    delete iCodigoItem;
    delete oObjetoSelecionado;
    getElementos();
    
  } else {
    alert(oRetorno.message.urlDecode());
  }
  iCodigoItem = null;
  $('o05_anoreferencia').style.backgroundColor     = "#FFFFFF";
  $('o05_anoreferencia').readOnly                  = false;
}

function js_limparCampos() {
  
   $('btncancelar').click();
}


function js_excluir() {

var sMsg = "Confirma a exclusão da dotação Selecionada?"; 
if (!confirm(sMsg)) {
  return false;
}
if (iCodigoItem) {
  
    var oParam                   = new Object();
    oParam.exec                  = "excluirElemento";
    oParam.o05_sequencial        = iCodigoItem;
    oParam.o08_sequencial        = oObjetoSelecionado.o08_sequencial;
    oParam.o08_elemento          = $F('o08_elemento');    
    oParam.o08_recurso           = $F('o08_recurso');    
    oParam.o08_localizadorgastos = $F('o08_localizadorgastos');    
    oParam.o19_coddot            = oObjetoSelecionado.o19_coddot;    
    oParam.o05_valor             = $F('o05_valor');
    js_divCarregando('Aguarde, excluindo dotação','msgbox');
    var oRequest = new Ajax.Request(
                                 'orc4_ppadotacaoalteracaoRPC.php',
                                  {
                                   method    : 'post', 
                                   parameters: 'json='+Object.toJSON(oParam), 
                                   onComplete: js_retornoExcluir 
                                  }
                                );
    
  }
  
}
function js_retornoExcluir(oRequest) {
  
  js_removeObj('msgbox');
  var oRetorno = eval("("+oRequest.responseText+")");
  if (oRetorno.status == 1) {
  
    js_limparCampos(); 
    var iFuncao    = top.corpo.iframe_ppadotacao.$F('o08_funcao');
    var iSubFuncao = top.corpo.iframe_ppadotacao.$F('o08_subfuncao');  
    var iUnidade   = top.corpo.iframe_ppadotacao.$F('o08_unidade');  
    var iOrgao     = top.corpo.iframe_ppadotacao.$F('o08_orgao');  
    var iPrograma  = top.corpo.iframe_ppadotacao.$F('o08_programa');  
    var iProjAtiv  = top.corpo.iframe_ppadotacao.$F('o08_projativ');  
    var iPpaVersao  = top.corpo.iframe_ppadotacao.$F('o05_ppaversao');
    top.corpo.iframe_ppadotacao.js_preenchepesquisa(iOrgao, 
                                                    iUnidade,
                                                    iFuncao,
                                                    iSubFuncao,
                                                    iPrograma,
                                                    iProjAtiv,
                                                    iPpaVersao
                                                    );  
  }
  iCodigoItem = null;
}  
function js_validaAno(input) {
   
   if (input.value < iAnoIni) {
     input.value = iAnoIni;
   }
   if (input.value > iAnoFim) {
     input.value = iAnoFim;
   }
}

$('o05_anoreferencia').onfocus = function(event) {
  if (this.value == "") {
    this.value = 2011;
  }
}
$('o05_anoreferencia').onkeydown = function(event) {
  
  if (!this.readOnly) {
   
    if (event.which == 40) {
    
     this.value = new Number(this.value)+1;
     js_validaAno(this);
     event.preventDefault();
    } else if(event.which == 38) {
      
      this.value -= 1;
      js_validaAno(this);
      event.preventDefault();
    }
  }
}

$('btncancelar').onclick = function() {
  
  iCodigoItem = null;
  var a = $$('input[type=text],select');
  a.each(function(input,id) {
      input.value = "";
  });
  setReadOnly(false);
  $('o05_anoreferencia').style.backgroundColor     = "#FFFFFF";
  $('o05_anoreferencia').readOnly                  = false;  
  $('btnexcluir').disabled = true;
  $('o08_concarpeculiar').value = '000';
  $('o08_localizadorgastos').value = '3';
  
  let eChange = new Event('change');
  $('o08_localizadorgastos').dispatchEvent(eChange);
  $('o08_concarpeculiar').dispatchEvent(eChange);
  
}
$('o05_anoreferencia').onkeypress=function (event){
   return js_mask(event,'0-9');
}

function getElementos() {

    oGrupoOriginal = new Object();
    js_divCarregando('Aguarde, Carregando estimativas','msgbox');
    oGrupoOriginal.exec          = "getElementosFromAcao";
    oGrupoOriginal.o40_orgao     = top.corpo.iframe_ppadotacao.$F('o08_orgao');
    oGrupoOriginal.o41_unidade   = top.corpo.iframe_ppadotacao.$F('o08_unidade');
    oGrupoOriginal.o52_funcao    = top.corpo.iframe_ppadotacao.$F('o08_funcao');
    oGrupoOriginal.o53_subfuncao = top.corpo.iframe_ppadotacao.$F('o08_subfuncao');
    oGrupoOriginal.o54_programa  = top.corpo.iframe_ppadotacao.$F('o08_programa');
    oGrupoOriginal.o55_projativ  = top.corpo.iframe_ppadotacao.$F('o08_projativ');
    oGrupoOriginal.o08_ppaversao = top.corpo.iframe_ppadotacao.$F('o05_ppaversao');
    
    var oRequest = new Ajax.Request(
                                    'orc4_ppadotacaoalteracaoRPC.php',
                                    {
                                        method    : 'post', 
                                        parameters: 'json='+Object.toJSON(oGrupoOriginal), 
                                        onComplete: js_retornoPesquisa 
                                    }
                                );

}

function js_retornoPesquisa(oRequest) {
  
    js_removeObj('msgbox');
    
    var oRetorno = eval("("+oRequest.responseText+")");
    if (oRetorno.status == 1) {
        addValoresGrid(oRetorno.itens, 1); 
    }

}
$('o05_anoreferencia').maxLength       = '4';
$('o05_anoreferencia').style.textAlign = 'right';
$('o05_valor').style.textAlign         = 'right';
$('btnsalvar').disabled = false;
</script>