<?
//MODULO: compras
$clpctabela->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("pc01_descrmater");
$clrotulo->label("pc01_codmater");
?>
<fieldset>
 <legend>
   <b>Adicionar Tabela</b>
 </legend>
<form name="form1" method="post" action="" >
<input type="hidden" id="dbopcao" value="<?php echo $db_opcao ?>">
<center>
<table border="0">
  <tr>
    <td>
      <?
        db_ancora(@$Lpc94_sequencial,"js_pesquisapc94_sequencial(true);",1);
      ?>
    </td>
    <td>
      <?
        db_input('pc94_sequencial',11,$Ipc94_sequencial,true,'text',3,"");
      ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tpc94_codmater?>">
       <?
       db_ancora(@$Lpc94_codmater,"js_pesquisapc94_codmater(true);",1,'');
       ?>
    </td>
    <td>
      <?

        db_input('pc94_codmater',11,$Ipc94_codmater,true,'text',$db_opcao," style='background-color:white' onchange='js_pesquisapc94_codmater(false);'")
      ?>
    </td>
    <td>
       <?
        db_input('pc01_descrmater',80,$Ipc01_descrmater,true,'text',3,'')
       ?>
    </td>
  </tr>
  </table>


<input onclick="<?php if ($db_opcao == 1) {echo "js_incluirTabela();";} else if ($db_opcao == 33) {echo "excluirTab();";} ?>"  style="margin-top: 10px;" name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="button" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input style="margin-top: 10px;" name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
<input style="margin-top: 10px;" type="button" value="Limpar" onclick="limparTabela();">
</center>
</form>

<center>
  <table width="100%">
    <tr>
      <td>
        <fieldset>
          <legend>
            <b>Adicionar Item</b>
          </legend>
          <center>
            <table>
              <tr>
                <td nowrap title="<?=@$Tpc01_codmater?>" align="right">
                   <?
                   db_ancora(@$Lpc01_codmater,"js_pesquisapc95_codmater(true);",1);
                   ?>
                </td>
                <td>
                  <?
                    db_input('pc95_codmater',10,$Ipc01_codmater,true,'text',1," onchange='js_pesquisapc95_codmater(false);'")
                  ?>
                  <?
                    db_input('pc01_descrmateritem',65,@$Ipc01_descrmater,true,'text',3,'')
                  ?>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="text-align: center;">
                 <input style="margin-top: 8px;" type="button" value='Adicionar Item' id='btnAddItem'>
                </td>
              </tr>
            </table>
          </center>
        </fieldset>
      </td>
    </tr>
    <tr>
      <td>
        <fieldset>
          <legend>
            <b>Itens Cadastrados</b>
          </legend>
          <div id='gridItensTabela'>

          </div>
        </fieldset>
      </td>
    </tr>
  </table>
</center>
</fieldset>
<script>

function js_pesquisapc94_sequencial(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pctabela','func_pctabela.php?funcao_js=parent.js_mostrapctabela1|pc94_sequencial|pc01_codmater|pc01_descrmater','Pesquisa',true);
  }else{
     if(document.form1.pc94_codmater.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pctabela','func_pcmater.php?pesquisa_chave='+document.form1.pc94_codmater.value+'&funcao_js=parent.js_mostrapcmater&tabela=t','Pesquisa',false);
     }else{
       document.form1.pc01_descrmater.value = '';
     }
  }
}

function js_mostrapctabela1(chave1, chave2, chave3){
  document.form1.pc94_sequencial.value = chave1;
  document.form1.pc94_codmater.value   = chave2;
  document.form1.pc01_descrmater.value = chave3;
  js_preencheGrid();
  db_iframe_pctabela.hide();
  document.getElementById('db_opcao').style.display  = "none";
}

function js_pesquisapc94_codmater(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pcmater','func_pcmater.php?funcao_js=parent.js_mostrapcmater1|pc01_codmater|pc01_descrmater&tabela=t','Pesquisa',true);
  }else{
     if(document.form1.pc94_codmater.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pcmater','func_pcmater.php?pesquisa_chave='+document.form1.pc94_codmater.value+'&funcao_js=parent.js_mostrapcmater&tabela=t','Pesquisa',false);
     }else{
       document.form1.pc01_descrmater.value = '';
     }
  }
}
function js_mostrapcmater(chave,erro){
  document.form1.pc01_descrmater.value = chave;
  if(erro==true){
    document.form1.pc94_codmater.focus();
    document.form1.pc94_codmater.value = '';
  }
}
function js_mostrapcmater1(chave1,chave2){
  document.form1.pc94_codmater.value = chave1;
  document.form1.pc01_descrmater.value = chave2;
  document.form1.pc94_sequencial.value = "";
  db_iframe_pcmater.hide();
  document.getElementById('db_opcao').style.display  = "inline-block";
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pctabela','func_pctabela.php?funcao_js=parent.js_preenchepesquisa|pc94_sequencial|pc01_codmater|pc01_descrmater','Pesquisa',true);
}
function js_preenchepesquisa(chave1, chave2, chave3){
  document.form1.pc94_sequencial.value = chave1;
  document.form1.pc94_codmater.value   = chave2;
  document.form1.pc01_descrmater.value = chave3;
  js_preencheGrid();
  db_iframe_pctabela.hide();
}

function js_pesquisapc95_codmater(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pcmater','func_pcmater.php?funcao_js=parent.js_mostrapcmateritem1|pc01_codmater|pc01_descrmater&tabela=f','Pesquisa',true);
  }else{
     if($('pc95_codmater').value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pcmater','func_pcmater.php?pesquisa_chave='+$('pc95_codmater').value+'&funcao_js=parent.js_mostrapcmateritem&tabela=f','Pesquisa',false);
     }else{
       $('pc01_descrmateritem').value = '';
     }
  }
}
function js_mostrapcmateritem(chave,erro){
  $('pc01_descrmateritem').value = chave;
  if(erro==true){
    $('pc95_codmater').focus();
    $('pc95_codmater').value = '';
  }
}
function js_mostrapcmateritem1(chave1,chave2){
  $('pc95_codmater').value = chave1;
  $('pc01_descrmateritem').value = chave2;
  db_iframe_pcmater.hide();
}

function novoAjax(params, onComplete) {

  var request = new Ajax.Request('com4_pctabela.RPC.php', {
    method:'post',
    parameters:'json='+Object.toJSON(params),
    onComplete: onComplete
  });

}

function js_incluirTabela() {
  var codMat = document.form1.pc94_codmater.value;
  var verificaCodMat = codMat == '';

  if (verificaCodMat) {
    alert("Informe o código do material para criar a tabela!");
    return;
  }
  insertTabela(codMat);
}

function insertTabela(codMat) {
  var params = {
    exec: 'insereTabela',
    codMaterial: codMat
  };

  novoAjax(params, function(e) {
    var oRetorno = JSON.parse(e.responseText);
      if (oRetorno.status == 1) {
        document.form1.pc94_sequencial.value = oRetorno.pc94_sequencial;
        document.getElementById('db_opcao').style.display  = "none";

      } else {
          alert(oRetorno.erro);
        return;
      }
    });
}

function limparTabela() {
  document.form1.pc94_sequencial.value = "";
  document.form1.pc94_codmater.value   = "";
  document.form1.pc01_descrmater.value = "";
  document.getElementById('db_opcao').style.display = "inline-block";
}

function excluirTab() {
  var params = {
    exec: 'excluirTabela',
    codTabela: document.form1.pc94_sequencial.value
  };

  novoAjax(params, function(e) {
    var oRetorno = JSON.parse(e.responseText);
      if (oRetorno.status == 1) {
        limparTabela();
        document.getElementById('body-container-gridItens').innerHTML = '';
        //js_preencheGrid();
      } else {
          alert(oRetorno.erro);
        return;
      }
    });
}

var sUrlRC = 'com1_pctabelaitem.RPC.php';
function js_init() {

oGridItens = new DBGrid('gridItens');
  oGridItens.nameInstance = "gridItens";
  oGridItens.setCellAlign(new Array("right","right","left","center"));
  oGridItens.setCellWidth(new Array("4%","8%","80%","8%"));
  oGridItens.setHeader(new Array("Seq.","Codigo","Descrição","Ação"));
  oGridItens.show($('gridItensTabela'));
  oGridItens.clearAll(true);

  $('btnAddItem').observe("click", js_adicionarItem);
  js_preencheGrid();

}

/**
 *Adicionar item a Tabela
 */
function js_adicionarItem() {

  if ($F('pc94_sequencial') == "") {

    alert('É necessário incluir uma Tabela para adicionar itens!');
    return false;

  }

  if ($F('pc95_codmater') == "") {

    alert('Informe o material!');
    return false;

  }



  js_divCarregando('Aguarde, adicionando item',"msgBox");
  var oParam            = new Object();
  oParam.iCodigoItem    = $F('pc95_codmater');
  oParam.iCodigoTabela  = $F('pc94_sequencial');
  oParam.exec           = "adicionarItem";
  var oAjax          = new Ajax.Request(sUrlRC,
                                         {
                                          method: "post",
                                          parameters:'json='+Object.toJSON(oParam),
                                          onComplete: js_retornoadicionarItem
                                         });
}

function js_retornoadicionarItem(oAjax) {

  js_removeObj('msgBox');
  var oRetorno = eval("("+oAjax.responseText+")");
  if (oRetorno.status == 1) {

    var aLinha = new Array();
    var index = oGridItens.aRows.length;

    aLinha[0]  = index+1;
    aLinha[1]  = $('pc95_codmater').value;
    aLinha[2]  = $('pc01_descrmateritem').value;
    if (document.form1.dbopcao.value != 33) {
      aLinha[3]  = "<input type='button' value='excluir' onclick='js_excluirLinha("+index+")'>";
    } else {
            aLinha[3]  = '<input type="hidden">';
    }
    oGridItens.addRow(aLinha);
    oGridItens.renderRows();

    $('pc95_codmater').value = "";
    $('pc01_descrmateritem').value = "";

  } else {
    alert(oRetorno.message.urlDecode());
  }
}

function js_excluirLinha(iSeq) {
  var oRow = oGridItens.aRows[iSeq];
  var sMsg ='Confirma a Exclusão do item '+oRow.aCells[1].getValue()+'-'+oRow.aCells[2].getValue()+"?";
  if (!confirm(sMsg)) {
    return false;
  }
  js_divCarregando('Aguarde, removendo item',"msgBox");
  var oParam            = new Object();
  oParam.iCodigoItem    = oRow.aCells[1].getValue();
  oParam.iCodigoTabela  = $F('pc94_sequencial');
  oParam.exec           = "excluirItem";
  var oAjax             = new Ajax.Request(sUrlRC,
                                         {
                                          method: "post",
                                          parameters:'json='+Object.toJSON(oParam),
                                          onComplete: js_retornoPreencherGrid
                                         });

}

function js_preencheGrid() {

  if ($F('pc94_sequencial') != "") {
    js_divCarregando('Aguarde, buscando itens',"msgBox");
    var oParam         = new Object();
    oParam.iCodigoTabela = $F('pc94_sequencial');
    oParam.exec          = "getItens";
    var oAjax            = new Ajax.Request(sUrlRC,
                                           {
                                            method: "post",
                                            parameters:'json='+Object.toJSON(oParam),
                                            onComplete: js_retornoPreencherGrid
                                           });
  }

}

function js_retornoPreencherGrid(oAjax) {
  js_removeObj('msgBox');
  var oRetorno = eval("("+oAjax.responseText+")");
  if (oRetorno.status == 2) {
    alert(oRetorno.message.urlDecode());
  }

    oGridItens.clearAll(true);
    console.log(oRetorno.aItens);
    for(var i = 0; i < oRetorno.aItens.length; i++) {

      with (oRetorno.aItens[i]) {

        var aLinha = new Array();
        aLinha[0]  = i+1;
        aLinha[1]  = pc95_codmater;
        aLinha[2]  = pc01_descrmater.urlDecode();
        if (document.form1.dbopcao.value != 33) {
          aLinha[3]  = "<input type='button' value='excluir' onclick='js_excluirLinha("+i+")'>";
        } else {
            aLinha[3]  = '<input type="hidden">';
        }
        oGridItens.addRow(aLinha);

      }
    }
    oGridItens.renderRows();
}
js_init();
</script>
