<?
//MODULO: transporteescolar
$cllinhafrequencia->rotulo->label();
?>
<div style="margin-top: 20px;"  id='ctnAbas'></div>

<!-- CONTAINER DA ABA Geral -->
<div id="ctnAbageral">
<form id="frmGeral" method="post" action="" class="container">
    <fieldset style="width: 100%;">
      <legend class="bold">Data de Laçamento</legend> 
<center>
<table border="0">
    <tr>
      <td nowrap title="<?=@$Ttre13_data?>">
        <?=@$Ltre13_data?>
      </td>
      <td> 
        <?
          db_inputdata('tre13_data',@$tre13_data_dia,@$tre13_data_mes,@$tre13_data_ano,true,'text',$db_opcao,"")
        ?>
    </td>
  </tr>
</table>
</center>
</fieldset>
  <input name="pesquisar" type="button" id="db_opcao" value="Pesquisar" onclick="tocarAba()">
</form>
</div>
<div>
  <fieldset style="margin-left:30px;" class="container">
    <legend class="bold">Frequências Lançadas</legend>
    <div id="ctnDbGridDocumentos"></div>
  </fieldset> 
    <center>  
        <input type="button" id="btnSalvar" value="Salvar Frequência" onclick="js_salvarFrequencia()" /> 
    </center>
</div>
<script>

var iOpcao  = "<?php print $db_opcao; ?>";

var sUrlRpc = 'tre1_linhasfrequencia.RPC.php';

var oGridDocumentos = new DBGrid('gridDocumentos');

  oGridDocumentos.nameInstance = "oGridDocumentos";
  oGridDocumentos.setCheckbox(0);
  oGridDocumentos.setCellAlign(new Array("center","center", "center"));
  oGridDocumentos.setCellWidth([ "10%","30%", "70%"]);
  oGridDocumentos.setHeader(new Array("Seq","Abreviatura", "Nome da Linha", "Sequencial"));
  oGridDocumentos.aHeaders[1].lDisplayed = false;
  oGridDocumentos.aHeaders[4].lDisplayed = false;
  oGridDocumentos.allowSelectColumns(true);
  oGridDocumentos.show($('ctnDbGridDocumentos'));

/**
 * Cria as abas Geral 
 */
var oDBAba         = new DBAbas($('ctnAbas'));
var oAbaLinha      = oDBAba.adicionarAba("Frequências", $('ctnAbageral'));

function tocarAba(){
  
  if($("tre13_data").value == '')
  {
    alert("Informe a Data!")
    return false;
  }

  js_buscarDocumentos($("tre13_data").value);
}

function js_buscarDocumentos(iData) {

js_divCarregando('mensagem_buscando_Linhas', 'msgbox');

var oParametros = new Object();

oParametros.exec = 'carregarLinhas';
oParametros.data = iData;

var oAjax = new Ajax.Request(
  sUrlRpc, {
    parameters: 'json=' + Object.toJSON(oParametros),
    method: 'post',
    asynchronous: false,

    /**
     * Retorno do RPC
     */
    onComplete: function(oAjax) {

      js_removeObj("msgbox");
      var oRetorno = eval('(' + oAjax.responseText + ")");
        
      if (oRetorno.iStatus == 2) {
        alert(oRetorno.sMensagem);
        return false;
      }
      
      oGridDocumentos.clearAll(true);
      var iDocumentos =oRetorno.dados.length;
      
      oRetorno.dados.each(function (oDocumento, iSeq) {

        var sAbreviatura    = oDocumento.abreviatura;
        var sNomelinha      = oDocumento.nomelinha;
        var sSequencial     = oDocumento.sequencial;
        var sSequencialFreq = oDocumento.sequencialFreq;
     
        $bBloquea     = false;
        var lMarca    = false;
                 
        if (sSequencialFreq != "") {
                    lMarca = true;
        }

        var aLinha = [oDocumento,sAbreviatura,sNomelinha,sSequencial];
        oGridDocumentos.addRow(aLinha, false, $bBloquea, lMarca);
      });
      
      oGridDocumentos.renderRows();
      
    }
  }
);
}

function js_salvarFrequencia() {
  
var aLinhas = oGridDocumentos.getSelection("object");

var iData = document.getElementById("tre13_data").value;

if (aLinhas.length == 0) {
            alert('Todas as frequências para essa data excluídas! ');
        }
var oParametros = new Object();

oParametros.aLinhas = new Array();
oParametros.data = iData;
oParametros.iOpcao = iOpcao;

for (var i = 0; i < aLinhas.length; i++) {

  with(aLinhas[i]) {
      var linhas         = new Object();
      linhas.abreviatura = aCells[2].getValue();
      linhas.nomelinha   = aCells[3].getValue();
      linhas.sequencial  = aCells[4].getValue();
      oParametros.aLinhas.push(linhas);
  }
}        

js_divCarregando('mensagem_enviando_Frequencia', 'msgbox');        

oParametros.exec = 'salvarFrequencia';

var oAjax = new Ajax.Request(
  sUrlRpc, {
    parameters: 'json=' + Object.toJSON(oParametros),
    method: 'post',
    asynchronous: false,

    /**
     * Retorno do RPC
     */
    onComplete: function(oAjax) {

      js_removeObj("msgbox");
      var oRetorno = eval('(' + oAjax.responseText + ")");
               
      if (oRetorno.status == 2) {
        alert(oRetorno.msg);
        return false;
      }
      if(iOpcao == 1)
        return alert('Frequências salvas com sucesso!');
      if(iOpcao == 2)
        return alert('Frequências alteradas com sucesso!');
      return alert('Frequências excluídas com sucesso!');     
    }
  }
);
}

function apagarData(event){
  
  var value = event.key;
  
  if(value == "Delete" || value == "Backspace"){
    document.getElementById("tre13_data").value = '';
  }

}

</script>
