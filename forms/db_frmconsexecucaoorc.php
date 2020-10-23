<?
//MODULO: contabilidade
include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clconsexecucaoorc->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("o58_funcao");
$clrotulo->label("o58_subfuncao");
if(isset($db_opcaoal) && !isset($opcao) && !isset($excluir)){
   $db_opcao=33;
   $db_botao=false;
}else if(isset($opcao) && $opcao=="alterar"){
    $db_botao=true;
    $db_opcao = 2;
}else if(isset($opcao) && $opcao=="excluir"){
    $db_opcao = 3;
    $db_botao=true;
}else if (!isset($excluir)) {
	if (isset($alterar) && $sqlerro==true) {  
    $db_opcao = 2;
	} else {
		$db_opcao = 1;
	}
    $db_botao=true;
    if(isset($novo) || (isset($alterar) && $sqlerro==false) || (isset($incluir) && $sqlerro==false ) ){
     $c202_sequencial = "";
     //$c202_consconsorcios = "";
     $c202_mescompetencia = "";
     $c202_funcao = "";
     $c202_subfuncao = "";
     $c202_codfontrecursos = "";
     $c202_elemento = "";
     $c202_valorempenhado = "";
     $c202_valorempenhadoanu = "";
     $c202_valorliquidado = "";
     $c202_valorliquidadoanu = "";
     $c202_valorpago = "";
     $c202_valorpagoanu = "";
     $o52_descr = "";
     $o53_descr = "";
   }
} 
?>
<style type="text/css">
.linhagrid.center {
  text-align: center;
}
.linhagrid input[type='text'] {
  width: 100%;
}
.normal:hover {
  background-color: #eee;
}
.DBGrid {
  width: 100%;
  border: 1px solid #888;
  margin: 20px 0;
}
</style>
<form name="form1" method="post" action="">
<center>
<fieldset style="margin-left: 80px; margin-top: 10px;">
<legend>Execução Orçamentária da Despesa</legend>
<table border="0">
  <tr>
    <td nowrap title="<?//=@$Tc202_sequencial?>">
       <?//=@$Lc202_sequencial?>
    </td>
    <td> 
<?
db_input('c202_sequencial',10,$Ic202_sequencial,true,'hidden',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc202_consconsorcios?>">
       <?=@$Lc202_consconsorcios?>
    </td>
    <td> 
<?
db_input('c202_consconsorcios',10,$Ic202_consconsorcios,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc202_mescompetencia?>">
       <?=@$Lc202_mescompetencia?>
    </td>
    <td> 
<?
$x = array("1"=>"JANEIRO","2"=>"FEVEREIRO","3"=>"MARÇO","4"=>"ABRIL","5"=>"MAIO","6"=>"JUNHO","7"=>"JULHO","8"=>"AGOSTO","9"=>"SETEMBRO","10"=>"OUTUBRO","11"=>"NOVEMBRO","12"=>"DEZEMBRO");
db_select('c202_mescompetencia',$x,true,1,"onchange='js_buscaInformacaoPorMes(this.value, ".$db_opcao.")'");

//db_input('c202_mescompetencia',10,$Ic202_mescompetencia,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$To58_funcao?>">
       <?
       db_ancora(@$Lo58_funcao,"js_pesquisao58_funcao(true);",$db_opcao);
       ?>
    </td>
    <td> 
<?
db_input('c202_funcao',11,$Ic202_funcao,true,'text',$db_opcao," onchange='js_pesquisao58_funcao(false);'")
?>
       <?
db_input('o52_descr',55,$Io52_descr,true,'text',3,'')
       ?>
    </td>
  </tr>
<tr>
    <td nowrap title="<?=@$To58_subfuncao?>">
       <?
       db_ancora(@$Lo58_subfuncao,"js_pesquisao58_subfuncao(true);",$db_opcao);
       ?>
    </td>
    <td> 
<?
db_input('c202_subfuncao',11,$Ic202_subfuncao,true,'text',$db_opcao," onchange='js_pesquisao58_subfuncao(false);'")
?>
       <?
db_input('o53_descr',55,$Io53_descr,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="Código da fonte de recursos">
       <b>Fonte de Recursos: </b>
    </td>
    <td> 
<?
db_input('c202_codfontrecursos',10,$Ic202_codfontrecursos,true,'text',$db_opcao,"","","","",3)
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc202_elemento?>">
       <?=@$Lc202_elemento?>
    </td>
    <td> 
<?
db_input('c202_elemento',10,$Ic202_elemento,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </tr>
    <td colspan="2" align="center">
      <input type="button" name="IncluirDotacao" id="IncluirDotacao" value="Incluir" onclick="js_novaLinha()" <?=($db_botao==false?"disabled":"")?>>
    </td>
  </tr>
  </table>
  
  <table class="DBGrid" id="gridConsExecOrc">
      <tr>
          <th class="table_header" style="width: 33px; cursor: pointer;" onclick="marcarTodos(<?= $iFonte ?>);" id="marcarTodos">M</th>
          <th class="table_header" style="width: 70px;">Função</th>
          <th class="table_header" style="width: 240px;">Subfunção</th>
          <th class="table_header" style="width: 100px;">Fonte</th>
          <th class="table_header" style="width: 110px;">Elemento</th>
          <th class="table_header" style="width: 100px;">Empenhado no Mês</th>
          <th class="table_header" style="width: 100px;">Empenhado Anulado no Mês</th>
          <th class="table_header" style="width: 100px;">Liquidado no Mês</th>
          <th class="table_header" style="width: 100px;">Liquidado Anulado no Mês</th>
          <th class="table_header" style="width: 100px;">Pago no Mês</th>
          <th class="table_header" style="width: 100px;">Pago Anulado no Mês</th>
          <th class="table_header" style="width: 100px;">Empenhado até o Mês</th>
          <th class="table_header" style="width: 100px;">Empenhado Anulado até o Mês</th>
          <th class="table_header" style="width: 100px;">Liquidado até o Mês</th>
          <th class="table_header" style="width: 100px;">Liquidado Anulado até o Mês</th>
          <th class="table_header" style="width: 100px;">Pago até o Mês</th>
          <th class="table_header" style="width: 100px;">Pago Anulado até o Mês</th>
    </tr>
</table>

  <center>
    <input type="button" name="Salvar" id="Salvar" value="Salvar" onclick="js_salvarGeral()" <?=($db_botao==false?"disabled":"")?>>
    <input type="button" name="Excluir" id="Excluir" value="Excluir" onclick="js_excluir()" <?=($db_botao==false?"disabled":"")?>>
    <input type="hidden" name="iNumItensGrid" value="0">
  </center>


 </fieldset>
  </center>
</form>
<script>
iMes = document.form1.c202_mescompetencia.value;
if(iMes) {
    js_buscaInformacaoPorMes(iMes, <?= $db_opcao ?>);
}

function js_cancelar(){
  var opcao = document.createElement("input");
  opcao.setAttribute("type","hidden");
  opcao.setAttribute("name","novo");
  opcao.setAttribute("value","true");
  document.form1.c202_codfontrecursos.value = null;
  document.form1.appendChild(opcao);
  document.form1.submit();
}

function js_pesquisao58_funcao(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_orcfuncao','func_orcfuncao.php?funcao_js=parent.js_mostraorcfuncao1|o52_funcao|o52_descr','Pesquisa',true);
  }else{
    js_OpenJanelaIframe('','db_iframe_orcfuncao','func_orcfuncao.php?pesquisa_chave='+document.form1.c202_funcao.value+'&funcao_js=parent.js_mostraorcfuncao','Pesquisa',false);
  }
}
function js_mostraorcfuncao(chave,erro){
  document.form1.o52_descr.value = chave; 
  if(erro==true){ 
    document.form1.c202_funcao.focus(); 
    document.form1.c202_funcao.value = ''; 
  }
}
function js_mostraorcfuncao1(chave1,chave2){
  document.form1.c202_funcao.value = chave1;
  document.form1.o52_descr.value = chave2;
  db_iframe_orcfuncao.hide();
}

function js_pesquisao58_subfuncao(mostra){
	  if(mostra==true){
	    js_OpenJanelaIframe('','db_iframe_orcsubfuncao','func_orcsubfuncao.php?funcao_js=parent.js_mostraorcsubfuncao1|o53_subfuncao|o53_descr','Pesquisa',true);
	  }else{
	    js_OpenJanelaIframe('','db_iframe_orcsubfuncao','func_orcsubfuncao.php?pesquisa_chave='+document.form1.c202_subfuncao.value+'&funcao_js=parent.js_mostraorcsubfuncao','Pesquisa',false);
	  }
	}
	function js_mostraorcsubfuncao(chave,erro){
	  document.form1.o53_descr.value = chave; 
	  if(erro==true){ 
	    document.form1.c202_subfuncao.focus(); 
				document.form1.c202_subfuncao.value = ''; 
	  }
	}
	function js_mostraorcsubfuncao1(chave1,chave2){
	  document.form1.c202_subfuncao.value = chave1;
	  document.form1.o53_descr.value = chave2;
	  db_iframe_orcsubfuncao.hide();
}

  function js_salvarGeral() {

      iNumItens = parseInt(document.form1.iNumItensGrid.value);

      if (iNumItens < 1) {
          
          alert('Adicione pelo menos um registro.');
          return false;

      }

      var itensEnviar = [];

      try {

          for (i = 0; i <= iNumItens-1; i++) {

              var elemento = 'aItensConsExecOrc[' + i + ']';

              valorEmpenhado    = document.form1[elemento+'[c202_valorempenhado]'].getAttribute('value');
              valorEmpenhadoAnu = document.form1[elemento+'[c202_valorempenhadoanu]'].getAttribute('value');
              valorLiquidado    = document.form1[elemento+'[c202_valorliquidado]'].getAttribute('value');
              valorLiquidadoAnu = document.form1[elemento+'[c202_valorliquidadoanu]'].getAttribute('value');
              valorPago         = document.form1[elemento+'[c202_valorpago]'].getAttribute('value');
              valorPagoAnu      = document.form1[elemento+'[c202_valorpagoanu]'].getAttribute('value');

              var novoItem = {
                iItem:                    Number(i),
                c202_mescompetencia:      document.form1.c202_mescompetencia.value,
                c202_consconsorcios:      document.form1.c202_consconsorcios.value,
                c202_funcao:              document.form1[elemento+'[c202_funcao]'].getAttribute('value'),
                c202_subfuncao:           document.form1[elemento+'[c202_subfuncao]'].getAttribute('value'),
                c202_codfontrecursos:     document.form1[elemento+'[c202_codfontrecursos]'].getAttribute('value'),
                c202_elemento:            document.form1[elemento+'[c202_elemento]'].getAttribute('value'),
                c202_valorempenhado:      isNaN(Number(valorEmpenhado))    ? valorEmpenhado.replace(/\./g, '').replace(/\,/, '.')     : valorEmpenhado,
                c202_valorempenhadoanu:   isNaN(Number(valorEmpenhadoAnu)) ? valorEmpenhadoAnu.replace(/\./g, '').replace(/\,/, '.')  : valorEmpenhadoAnu,
                c202_valorliquidado:      isNaN(Number(valorLiquidado))    ? valorLiquidado.replace(/\./g, '').replace(/\,/, '.')     : valorLiquidado,
                c202_valorliquidadoanu:   isNaN(Number(valorLiquidadoAnu)) ? valorLiquidadoAnu.replace(/\./g, '').replace(/\,/, '.')  : valorLiquidadoAnu,
                c202_valorpago:           isNaN(Number(valorPago))         ? valorPago.replace(/\./g, '').replace(/\,/, '.')          : valorPago,
                c202_valorpagoanu:        isNaN(Number(valorPagoAnu))      ? valorPagoAnu.replace(/\./g, '').replace(/\,/, '.')       : valorPagoAnu,
              };

              itensEnviar.push(novoItem);

          }

          var oParam    = new Object();
          oParam.exec   = 'salvar';
          oParam.aItens = itensEnviar;
          
          js_divCarregando('Aguarde', 'div_aguarde');

          var oAjax = new Ajax.Request('con4_consconsorcios.RPC.php', {
              method:'post',
              parameters:'json='+Object.toJSON(oParam),
              onComplete: js_retornoSalvar
          });

      } catch(e) {

          alert(e.toString());

      }

      return false;

  }

  function js_retornoSalvar(oAjax) {

      js_removeObj('div_aguarde');

      var oRetorno = eval("("+oAjax.responseText+")");

      if (oRetorno.status == 1) {

          alert(oRetorno.sMensagem.urlDecode());
          js_buscaInformacaoPorMes(oRetorno.iMes, 1);

      } else {
          alert(oRetorno.sMensagem.urlDecode());
      }

  }

  function js_buscaInformacaoPorMes(iMes = 1, iOpcao = null) {
      
      var iConsorcio    = document.form1.c202_consconsorcios.value;
      var oParam        = new Object();
      oParam.exec       = 'getRegistrosAno';
      oParam.iMes       = iMes;
      oParam.iConsorcio = iConsorcio;
      oParam.iOpcao     = iOpcao;

      js_divCarregando('Aguarde, buscando registros', 'div_aguarde');

      var oAjax = new Ajax.Request('con4_consconsorcios.RPC.php', {
          method:'post',
          parameters:'json='+Object.toJSON(oParam),
          onComplete: js_retornoBuscaInformacaoPorMes
      });

  }

  function js_retornoBuscaInformacaoPorMes(oAjax) {

      js_removeObj('div_aguarde');
      var oRetorno  = eval("("+oAjax.responseText+")");
      var iMes      = oRetorno.iMes;
      var iOpcao    = oRetorno.iOpcao;

      if (oRetorno.status == 1) {

          if (oRetorno.iNumReg > 0) {
          
              js_limpaTabela();     
              document.form1.iNumItensGrid.value = oRetorno.iNumReg;

              var oTotalizador = new Object();
              
              oTotalizador.iTotEmpMes         = 0;
              oTotalizador.iTotEmpAnuMes      = 0;
              oTotalizador.iTotLiqMes         = 0;
              oTotalizador.iTotLiqAnuMes      = 0;
              oTotalizador.iTotPagMes         = 0;
              oTotalizador.iTotPagAnuMes      = 0;
              oTotalizador.iTotEmpAteMes      = 0;
              oTotalizador.iTotEmpAnuAteMes   = 0;
              oTotalizador.iTotLiqAteMes      = 0;
              oTotalizador.iTotLiqAnulAteMes  = 0;
              oTotalizador.iTotPagAteMes      = 0;
              oTotalizador.iTotPagAnuAteMes   = 0;
            
              oRetorno.aItens.each(function (oItem, iLinha) {
              
                  js_adicionaLinhaTabela(oItem, iLinha, iOpcao);      
                  
                  oTotalizador.iTotEmpMes         += parseFloat(oItem.c202_valorempenhado);
                  oTotalizador.iTotEmpAnuMes      += parseFloat(oItem.c202_valorempenhadoanu);
                  oTotalizador.iTotLiqMes         += parseFloat(oItem.c202_valorliquidado);
                  oTotalizador.iTotLiqAnuMes      += parseFloat(oItem.c202_valorliquidadoanu);
                  oTotalizador.iTotPagMes         += parseFloat(oItem.c202_valorpago);
                  oTotalizador.iTotPagAnuMes      += parseFloat(oItem.c202_valorpagoanu);                  
                  oTotalizador.iTotEmpAteMes      += parseFloat(oItem.empenhado_ate_mes);
                  oTotalizador.iTotEmpAnuAteMes   += parseFloat(oItem.empenhado_anulado_ate_mes);
                  oTotalizador.iTotLiqAteMes      += parseFloat(oItem.liquidado_ate_mes);
                  oTotalizador.iTotLiqAnulAteMes  += parseFloat(oItem.liquidado_anulado_ate_mes);
                  oTotalizador.iTotPagAteMes      += parseFloat(oItem.pago_ate_mes);
                  oTotalizador.iTotPagAnuAteMes   += parseFloat(oItem.pago_anulado_ate_mes);

              });
              
              js_adicionaLinhaTotalizador(oTotalizador, true);

          } else {

              if (iMes != 1) {
                    alert("Nenhuma registro de Execução Orçamentária Encontrado para o Consórcio.");
              }
              js_limpaTabela();   

          }
          
      } else {
          alert("Erro ao buscar informação do mês.")
      }
  }

  function js_adicionaLinhaTabela(oItem = null, iLinha = null, iOpcao = null) {

      var sLinhaTabela = "";

      if (iOpcao == "1" || iOpcao == "2") {
          
          sStyle       = "style='width: 70px'";
          sCheckStatus = "";

      } else {
          
          sStyle        = "style='width: 70px; background: #DEB887;' readonly='true'";
          sCheckStatus  = "disabled";

          document.getElementById('marcarTodos').setAttribute('onclick','');

      }

      sLinhaTabela += "<tr id='"+iLinha+"' class='normal'>";
      sLinhaTabela += "   <th class='table_header'>";
      sLinhaTabela += "       <input type='checkbox' class='marca_itens' name='aItensMarcados[]' value='"+ iLinha +"' "+sCheckStatus+">";
      sLinhaTabela += "       <input type='hidden' name='aItensConsExecOrc["+ iLinha +"][c202_sequencial]' value='"+ oItem.c202_sequencial +"'>";
      sLinhaTabela += "   </th>";
      sLinhaTabela += "   <td class='linhagrid center'>";
      sLinhaTabela +=         oItem.c202_funcao +"<input type='hidden' name='aItensConsExecOrc["+ iLinha +"][c202_funcao]' value='"+ oItem.c202_funcao +"'>";
      sLinhaTabela += "   </td>";
      sLinhaTabela += "   <td class='linhagrid center'>";
      sLinhaTabela +=         oItem.c202_subfuncao+"<input type='hidden' name='aItensConsExecOrc["+ iLinha +"][c202_subfuncao]' value='"+ oItem.c202_subfuncao +"'>";
      sLinhaTabela += "   </td>";
      sLinhaTabela += "   <td class='linhagrid center'>";
      sLinhaTabela +=         oItem.c202_codfontrecursos+"<input type='hidden' name='aItensConsExecOrc["+ iLinha +"][c202_codfontrecursos]' value='"+ oItem.c202_codfontrecursos +"'>";
      sLinhaTabela += "   </td>";
      sLinhaTabela += "   <td class='linhagrid center'>";
      sLinhaTabela +=         oItem.c202_elemento+"<input type='hidden' name='aItensConsExecOrc["+ iLinha +"][c202_elemento]' value='"+ oItem.c202_elemento +"'>";
      sLinhaTabela += "   </td>";
      sLinhaTabela += "   <td class='linhagrid'>";
      sLinhaTabela += "       <input type='text' "+sStyle+" name='aItensConsExecOrc["+ iLinha +"][c202_valorempenhado]' value='"+ js_formatar(oItem.c202_valorempenhado, 'f') +"' onchange='js_atualizaValorTotal(\"c202_valorempenhado\", "+ iLinha +", this.value);' onKeyUp='js_ValidaCampos(this,4,\"valor\",\"f\",\"f\",event);' >";
      sLinhaTabela += "   </td>";
      sLinhaTabela += "   <td class='linhagrid'>";
      sLinhaTabela += "       <input type='text' "+sStyle+" name='aItensConsExecOrc["+ iLinha +"][c202_valorempenhadoanu]' value='"+ js_formatar(oItem.c202_valorempenhadoanu, 'f') +"' onchange='js_atualizaValorTotal(\"c202_valorempenhadoanu\", "+ iLinha +", this.value);' onKeyUp='js_ValidaCampos(this,4,\"valor\",\"f\",\"f\",event);' >";
      sLinhaTabela += "   </td>";
      sLinhaTabela += "   <td class='linhagrid'>";
      sLinhaTabela += "       <input type='text' "+sStyle+" name='aItensConsExecOrc["+ iLinha +"][c202_valorliquidado]' value='"+ js_formatar(oItem.c202_valorliquidado, 'f') +"' onchange='js_atualizaValorTotal(\"c202_valorliquidado\", "+ iLinha +", this.value);' onKeyUp='js_ValidaCampos(this,4,\"valor\",\"f\",\"f\",event);' >";
      sLinhaTabela += "   </td>";
      sLinhaTabela += "   <td class='linhagrid'>";
      sLinhaTabela += "       <input type='text' "+sStyle+" name='aItensConsExecOrc["+ iLinha +"][c202_valorliquidadoanu]' value='"+ js_formatar(oItem.c202_valorliquidadoanu, 'f') +"' onchange='js_atualizaValorTotal(\"c202_valorliquidadoanu\", "+ iLinha +", this.value);' onKeyUp='js_ValidaCampos(this,4,\"valor\",\"f\",\"f\",event);' >";
      sLinhaTabela += "   </td>";
      sLinhaTabela += "   <td class='linhagrid'>";
      sLinhaTabela += "       <input type='text' "+sStyle+" name='aItensConsExecOrc["+ iLinha +"][c202_valorpago]' value='"+ js_formatar(oItem.c202_valorpago, 'f') +"' onchange='js_atualizaValorTotal(\"c202_valorpago\", "+ iLinha +", this.value);' onKeyUp='js_ValidaCampos(this,4,\"valor\",\"f\",\"f\",event);' >";
      sLinhaTabela += "   </td>";
      sLinhaTabela += "   <td class='linhagrid'>";
      sLinhaTabela += "       <input type='text' "+sStyle+" name='aItensConsExecOrc["+ iLinha +"][c202_valorpagoanu]' value='"+ js_formatar(oItem.c202_valorpagoanu, 'f') +"' onchange='js_atualizaValorTotal(\"c202_valorpagoanu\", "+ iLinha +", this.value);' onKeyUp='js_ValidaCampos(this,4,\"valor\",\"f\",\"f\",event);' >";
      sLinhaTabela += "   </td>";
      sLinhaTabela += "   <td class='linhagrid'>";
      sLinhaTabela += "       <input type='text' style='width: 70px; background: #DEB887;' name='aItensConsExecOrc["+ iLinha +"][empenhado_ate_mes]' value='"+ js_formatar(oItem.empenhado_ate_mes, 'f') +"' readonly='true'>";
      sLinhaTabela += "   </td>";
      sLinhaTabela += "   <td class='linhagrid'>";
      sLinhaTabela += "       <input type='text' style='width: 70px; background: #DEB887;' name='aItensConsExecOrc["+ iLinha +"][empenhado_anulado_ate_mes]' value='"+ js_formatar(oItem.empenhado_anulado_ate_mes, 'f') +"' readonly='true'>";
      sLinhaTabela += "   </td>";
      sLinhaTabela += "   <td class='linhagrid'>";
      sLinhaTabela += "       <input type='text' style='width: 70px; background: #DEB887;' name='aItensConsExecOrc["+ iLinha +"][liquidado_ate_mes]' value='"+ js_formatar(oItem.liquidado_ate_mes, 'f') +"' readonly='true'>";
      sLinhaTabela += "   </td>";
      sLinhaTabela += "   <td class='linhagrid'>";
      sLinhaTabela += "       <input type='text' style='width: 70px; background: #DEB887;' name='aItensConsExecOrc["+ iLinha +"][liquidado_anulado_ate_mes]' value='"+ js_formatar(oItem.liquidado_anulado_ate_mes, 'f') +"' readonly='true'>";
      sLinhaTabela += "   </td>";
      sLinhaTabela += "   <td class='linhagrid'>";
      sLinhaTabela += "       <input type='text' style='width: 70px; background: #DEB887;' name='aItensConsExecOrc["+ iLinha +"][pago_ate_mes]' value='"+ js_formatar(oItem.pago_ate_mes, 'f') +"' readonly='true'>";
      sLinhaTabela += "   </td>";
      sLinhaTabela += "   <td class='linhagrid'>";
      sLinhaTabela += "       <input type='text' style='width: 70px; background: #DEB887;' name='aItensConsExecOrc["+ iLinha +"][pago_anulado_ate_mes]' value='"+ js_formatar(oItem.pago_anulado_ate_mes, 'f') +"' readonly='true'>";
      sLinhaTabela += "   </td>";
      sLinhaTabela += "</tr>";
      
      document.getElementById("gridConsExecOrc").innerHTML += sLinhaTabela;

  }

  function js_adicionaLinhaTotalizador(oTotalizador = null, iNovo) {

      if (iNovo) {
          
          sLinhaTotalizador = "<tr id='totalizador'>";
          sLinhaTotalizador += "  <th class='table_header' colspan='5'>TOTAL</th>";      
          sLinhaTotalizador += "  <th class='table_header' style='width: 100px;' id='c202_valorempenhado_total'>"+ js_formatar(oTotalizador.iTotEmpMes, 'f') +"</th>";
          sLinhaTotalizador += "  <th class='table_header' style='width: 100px;' id='c202_valorempenhadoanu_total'>"+ js_formatar(oTotalizador.iTotEmpAnuMes, 'f') +"</th>";
          sLinhaTotalizador += "  <th class='table_header' style='width: 100px;' id='c202_valorliquidado_total'>"+ js_formatar(oTotalizador.iTotLiqMes, 'f') +"</th>";
          sLinhaTotalizador += "  <th class='table_header' style='width: 100px;' id='c202_valorliquidadoanu_total'>"+ js_formatar(oTotalizador.iTotLiqAnuMes, 'f') +"</th>";
          sLinhaTotalizador += "  <th class='table_header' style='width: 100px;' id='c202_valorpago_total'>"+ js_formatar(oTotalizador.iTotPagMes, 'f') +"</th>";
          sLinhaTotalizador += "  <th class='table_header' style='width: 100px;' id='c202_valorpagoanu_total'>"+ js_formatar(oTotalizador.iTotPagAnuMes, 'f') +"</th>";
          sLinhaTotalizador += "  <th class='table_header' style='width: 100px;'>"+ js_formatar(oTotalizador.iTotEmpAteMes, 'f') +"</th>";
          sLinhaTotalizador += "  <th class='table_header' style='width: 100px;'>"+ js_formatar(oTotalizador.iTotEmpAnuAteMes, 'f') +"</th>";
          sLinhaTotalizador += "  <th class='table_header' style='width: 100px;'>"+ js_formatar(oTotalizador.iTotLiqAteMes, 'f') +"</th>";
          sLinhaTotalizador += "  <th class='table_header' style='width: 100px;'>"+ js_formatar(oTotalizador.iTotLiqAnulAteMes, 'f') +"</th>";
          sLinhaTotalizador += "  <th class='table_header' style='width: 100px;'>"+ js_formatar(oTotalizador.iTotPagAteMes, 'f') +"</th>";
          sLinhaTotalizador += "  <th class='table_header' style='width: 100px;'>"+ js_formatar(oTotalizador.iTotPagAnuAteMes, 'f') +"</th>";
          sLinhaTotalizador += "</tr>";
          
          document.getElementById("gridConsExecOrc").innerHTML += sLinhaTotalizador;

      } else {
          
          totalizador     = document.getElementById('totalizador');
          tempTotalizador = totalizador.innerHTML;
          totalizador.parentNode.parentNode.removeChild(totalizador.parentNode);          
          document.getElementById("gridConsExecOrc").innerHTML += "<tr id='totalizador'>"+tempTotalizador+"</tr>";

      }

  }

  function js_novaLinha(){
      
      if (document.form1.c202_funcao.value == '') {
          
          alert("Informe o Código da função.");
          document.form1.c202_funcao.focus();
          return;

      }

      if (document.form1.c202_subfuncao.value == '') {
          
          alert("Informe a Sub Função.");
          document.form1.c202_subfuncao.focus();
          return;

      }

      if (document.form1.c202_codfontrecursos.value == '') {
          
          alert("Informe a Fonte de Recursos.");
          document.form1.c202_codfontrecursos.focus();
          return;

      }

      if (document.form1.c202_elemento.value == '') {
          
          alert("Informe o Elemento.");
          document.form1.c202_elemento.focus();
          return;

      }
      
      oItem = new Object();

      oItem.c202_funcao               = document.form1.c202_funcao.value;
      oItem.c202_subfuncao            = document.form1.c202_subfuncao.value;
      oItem.c202_codfontrecursos      = document.form1.c202_codfontrecursos.value;
      oItem.c202_elemento             = document.form1.c202_elemento.value;
      oItem.c202_mescompetencia       = document.form1.c202_mescompetencia.value;
      oItem.c202_consconsorcios       = document.form1.c202_consconsorcios.value;
      oItem.c202_valorempenhado       = 0;
      oItem.c202_valorempenhadoanu    = 0;
      oItem.c202_valorliquidado       = 0;
      oItem.c202_valorliquidadoanu    = 0;
      oItem.c202_valorpago            = 0;
      oItem.c202_valorpagoanu         = 0;
      oItem.empenhado_ate_mes         = 0;
      oItem.empenhado_anulado_ate_mes = 0;
      oItem.liquidado_ate_mes         = 0;
      oItem.liquidado_anulado_ate_mes = 0;
      oItem.pago_ate_mes              = 0;
      oItem.pago_anulado_ate_mes      = 0;
      oItem.c202_valorempenhado       = 0;

      try {

          var oParam    = new Object();
          oParam.exec   = 'salvarNovo';
          oParam.oItem  = oItem;
          
          js_divCarregando('Aguarde', 'div_aguarde');

          var oAjax = new Ajax.Request('con4_consconsorcios.RPC.php', {
              method:'post',
              parameters:'json='+Object.toJSON(oParam),
              onComplete: js_retornoSalvarNovo
          });

      } catch(e) {
          alert(e.toString());
      }

  }

  function js_retornoSalvarNovo(oAjax) {

      js_removeObj('div_aguarde');
      var oRetorno = eval("("+oAjax.responseText+")");

      if (oRetorno.status == 1) {
          
          alert(oRetorno.sMensagem.urlDecode());
          
          iItem = parseInt(document.form1.iNumItensGrid.value);
          document.form1.c202_elemento.value = '';
          js_buscaInformacaoPorMes(oRetorno.iMes, 1);

      } else {
          alert(oRetorno.sMensagem.urlDecode());
      }

  }

  function aItens() {
      
      var itensNum = document.querySelectorAll('.marca_itens');

      return Array.prototype.map.call(itensNum, function (item) {
          return item;
      });

  }

  function marcarTodos() {

      aItens().forEach(function (item) {

          var check = item.classList.contains('marcado');

          if (check) {
              item.classList.remove('marcado');
          } else {
              item.classList.add('marcado');
          }
          item.checked = !check;

      });

  }

  function getItensMarcados() {

      return aItens().filter(function (item) {
        return item.checked;
      });

  }

  function js_excluir() {

      var itens = getItensMarcados();

      if (itens.length < 1) {

        alert('Selecione pelo menos um item da lista.');
        return;

      }

      itens = itens.map(function (item) {
          return Number(item.value);
      });

      try {

          var itensExcluir = [];
          
          itens.forEach(function (item) {

              if (typeof document.form1['aItensConsExecOrc['+item+'][c202_funcao]'] != "undefined") {

                  var elemento = 'aItensConsExecOrc[' + item + ']';

                  var novoItem = {
                    iItem:                    Number(item),
                    c202_mescompetencia:      document.form1.c202_mescompetencia.value,
                    c202_consconsorcios:      document.form1.c202_consconsorcios.value,
                    c202_funcao:              document.form1[elemento+'[c202_funcao]'].getAttribute('value'),
                    c202_subfuncao:           document.form1[elemento+'[c202_subfuncao]'].getAttribute('value'),
                    c202_codfontrecursos:     document.form1[elemento+'[c202_codfontrecursos]'].getAttribute('value'),
                    c202_elemento:            document.form1[elemento+'[c202_elemento]'].getAttribute('value')
                  };

                  itensExcluir.push(novoItem);

              }

          });

          var oParam    = new Object();
          oParam.exec   = 'excluir';
          oParam.aItens = itensExcluir;
          
          js_divCarregando('Aguarde', 'div_aguarde');

          var oAjax = new Ajax.Request('con4_consconsorcios.RPC.php', {
              
              method:'post',
              parameters:'json='+Object.toJSON(oParam),
              onComplete: js_retornoExcluir

          });

      } catch(e) {

          alert(e.toString());

      }

  }

  function js_retornoExcluir(oAjax) {
      
      js_removeObj('div_aguarde');
      var oRetorno = eval("("+oAjax.responseText+")");

      if (oRetorno.status == 1) {

          alert(oRetorno.sMensagem.urlDecode());

          oRetorno.aItensExcluidos.forEach(function (item) {
              js_excluiLinha(item);
          });

      } else {
          alert(oRetorno.sMensagem.urlDecode());
      }

  }

  function js_excluiLinha(id){

      try {

          linha = document.getElementById(id);
          linha.parentNode.parentNode.removeChild(linha.parentNode);

      }catch (e) {}  

      document.form1.iNumItensGrid.value = parseInt(document.form1.iNumItensGrid.value)-1;
      
      if (parseInt(document.form1.iNumItensGrid.value) == 0) {
          totalizador = document.getElementById('totalizador');
          totalizador.style.display = 'none';
      }

  }

  function js_limpaTabela(){

      var j = 0;

      for (var i = parseInt(document.form1.iNumItensGrid.value)-1; i >= 0; i--) {
        
          j = i;
          while(document.getElementById(j) == null) {
              j++;
          }
          js_excluiLinha(j);

      }
      
      js_excluiLinha('totalizador');

      document.form1.iNumItensGrid.value = 0;

  }

  function js_atualizaValorTotal(sNome, iLinha, iValue) {

      if (iLinha != null && iValue) {
          document.form1['aItensConsExecOrc['+iLinha+']['+sNome+']'].setAttribute('value', iValue); 
      } else if (iLinha != null) {
          document.form1['aItensConsExecOrc['+iLinha+']['+sNome+']'].setAttribute('value', 0); 
      }
      
      linha = document.getElementById(sNome+'_total');
      var iTotal  = 0;

      for (i = 0; i < parseInt(document.form1.iNumItensGrid.value); i++) {

          if (typeof document.form1['aItensConsExecOrc['+i+']['+sNome+']'] != "undefined") {
              if (isNaN(Number(document.form1['aItensConsExecOrc['+i+']['+sNome+']'].value))) {
                iTotal += Number(document.form1['aItensConsExecOrc['+i+']['+sNome+']'].value.replace(/\./g, '').replace(/\,/, '.'));
              } else {
                  iTotal += Number(document.form1['aItensConsExecOrc['+i+']['+sNome+']'].value);
              }
          } 

      }
      
      linha.innerHTML = js_formatar(iTotal, 'f');
  }

  function js_atualizaTotalizadores() {

      js_atualizaValorTotal("c202_valorempenhado", null, null);
      js_atualizaValorTotal("c202_valorempenhadoanu", null, null);
      js_atualizaValorTotal("c202_valorliquidado", null, null);
      js_atualizaValorTotal("c202_valorliquidadoanu", null, null);
      js_atualizaValorTotal("c202_valorpago", null, null);
      js_atualizaValorTotal("c202_valorpagoanu", null, null);

  }

</script>
