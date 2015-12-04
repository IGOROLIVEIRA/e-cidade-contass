<div id="lista" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Dívida Consolidada</span>
<div id="fechar" onclick="fechar()" style="background:url('imagens/jan_fechar_on.gif'); height: 20px;
    float: right;  width: 20px;"></div>
<div id="fechar" style="background:url('imagens/jan_max_off.gif'); height: 20px;
    float: right;  width: 20px;"></div>
<div id="fechar" onclick="fechar()" style="background:url('imagens/jan_mini_on.gif'); height: 20px;
    float: right;  width: 20px;"></div>
    
</div><!-- topo -->
<div id="campos" style="margin-bottom: 7px;">
<table>
<tr>
<td><strong>Código</strong></td>
<td> <input type="text" name="codigoDiv" id="codigoDiv" ></td>
</tr>
<tr>
<td></td>
<td><input type="button" name="bntPesquisarXml" value="Pesquisar" onclick="pesquisar_codigo()"></td>
</tr>
</table>
</div><!-- campos -->
</div><!-- lista -->


<form name="form1" method="post" action="">
<fieldset style="width: 500px; height: 580px;"><legend><b>Dívida Consolidada</b></legend>
  <table cellspacing="5px">
  <tr>
  <td><strong>Código</strong></td>
  <td> <input type="text" name="codigo" id="codigo" readonly="readonly" style="background-color: rgb(222, 184, 135);" ></td>
  </tr>
  
  <tr>
  <td><strong>Tipo de Lançamento:</strong></td>
  <td>
  <select name="tipoLancamento" id="tipoLancamento" style="width: 150px;">
  	<option value="1" id="01">Dívida Mobiliária</option>
  	<option value="2" id="02">Dívida Contratual de PPP</option>
  	<option value="3" id="03">Demais Dívidas Contratuais Internas</option>
  	<option value="4" id="04">Dívidas Contratuais Externas</option>
  	<option value="5" id="05">Precatórios Posteriores a 05/05/2000</option>
  	<option value="6" id="06">Parcelamento de Dívidas de Tributos</option>
  	<option value="7" id="07">Parcelamento de Dívidas Previdenciárias</option>
  	<option value="8" id="08">Parcelamento de Dívidas das Demais Contribuições Sociais</option>
  	<option value="9" id="09">Parcelamento de Dívidas do FGTS</option>
  	<option value="10" id="010">Outras Dívidas</option>
  	<option value="11" id="011">Passivos Reconhecidos</option>
  </select>
  </td>
  </tr>
  
  <tr>
  <td><strong>Número da Lei de Autorização:</strong></td>
  <td><input type="text" name=nroLeiAutorizacao id="nroLeiAutorizacao" maxlength="7"></td>
  </tr>
  
  <tr>
  <td><strong>Data da Lei de Autorização:</strong></td>
  <td><input type="text" name=dtLeiAutorizacao id="dtLeiAutorizacao" onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)" 
 autocomplete="off" onblur="js_validaDbData(this);" maxlength="10">
 <input id="dtLeiAutorizacao_dia" type="hidden" maxlength="2" size="2" value="" title="" >
 <input id="dtLeiAutorizacao_mes" type="hidden" maxlength="2" size="2" value="" title="" >
 <input id="dtLeiAutorizacao_ano" type="hidden" maxlength="4" size="4" value="" title="" >
 <script>
   var PosMouseY, PosMoudeX;
   function js_comparaDatasodtLeiAutorizacao(dia,mes,ano){
     var objData = document.getElementById('dtInicio');
     objData.value = dia+"/"+mes+'/'+ano;
   }
 </script>
  </td>
  </tr>
  
  <tr>
  <td><strong>Número do contrato:</strong></td>
  <td><input type="text" name="nroContrato" id="nroContrato" maxlength="14" 
  onkeyup="js_ValidaCampos(this,1,'Número do contrato','f','f',event);" >
  </td>
  </tr>
  
  <tr>
  <td><strong>Data da Assinatura do Contrato:</strong></td>
  <td><input type="text" name="dataAssinatura" id="dataAssinatura" onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)" 
 autocomplete="off" onblur="js_validaDbData(this);" maxlength="10">
 <input id="dataAssinatura_dia" type="hidden" maxlength="2" size="2" value="" title="" >
 <input id="dataAssinatura_mes" type="hidden" maxlength="2" size="2" value="" title="" >
 <input id="dataAssinatura_ano" type="hidden" maxlength="4" size="4" value="" title="" >
 <script>
   var PosMouseY, PosMoudeX;
   function js_comparaDatasodtLeiAutorizacao(dia,mes,ano){
     var objData = document.getElementById('dataAssinatura');
     objData.value = dia+"/"+mes+'/'+ano;
   }
 </script>
  </td>
  </tr>
  
  <tr>
  <td><strong>Tipo do Documento:</strong></td>
  <td>
  <select name="tipoDocumento" id="tipoDocumento" style="width: 150px;">
  	<option value="1" id="01">CPF</option>
  	<option value="2" id="02">CNPJ</option>
  	<option value="3" id="03">Documento de Estrangeiros</option>
  </select>
  </td>
  </tr>
  
  <tr>
  <td><strong>CPF/CNPJ:</strong></td>
  <td><input type="text" name="nroDocumento" id="nroDocumento" maxlength="14" 
  onkeyup="js_ValidaCampos(this,1,'Número do contrato','f','f',event);" >
  </td>
  </tr>
  
  <tr>
  <td><strong>Nome do Credor:</strong></td>
  <td><input type="text" name="nomeCredor" id="nomeCredor" maxlength="120" >
  </td>
  </tr>
  
  <tr>
  	<td><strong>Justificativa:<strong></td>
	<td><span id="left"></span>
	<textarea type="text" name="justificativa" id="justificativa" value="" cols="45" rows="5" 
	onKeyDown="textCounter(this.form1.descricaoArtigo,this.form.remLen,250)" onKeyUp="textCounter(this.form1.descricaoArtigo,this.form.remLen,250)">
	</textarea></td>
  </tr>
  
  <tr>
  <td><strong>Valor do Saldo Anterior:</strong></td>
  <td><input type="text" name=vlSaldoAnterior id="vlSaldoAnterior" maxlength="13" 
  onkeyup="js_ValidaCampos(this,4,'Valor do Saldo Anterior','f','f',event);" >
  </td>
  </tr>
  
  <tr>
  <td><strong>Valor de Contratação:</strong></td>
  <td><input type="text" name=vlContratacao id="vlContratacao" maxlength="13" 
  onkeyup="js_ValidaCampos(this,4,'Valor de Contratação','f','f',event);">
  </td>
  </tr>
  
  <tr>
  <td><strong>Valor de Amortização:</strong></td>
  <td><input type="text" name=vlAmortizacao id="vlAmortizacao" maxlength="13" 
  onkeyup="js_ValidaCampos(this,4,'Valor de Amortização','f','f',event);">
  </td>
  </tr>
  
  <tr>
  <td><strong>Valor de Cancelamento:</strong></td>
  <td><input type="text" name=vlCancelamento id="vlCancelamento" maxlength="13" 
  onkeyup="js_ValidaCampos(this,4,'Valor de Cancelamento','f','f',event);">
  </td>
  </tr>
  
  <tr>
  <td><strong>Valor de Encampação:</strong></td>
  <td><input type="text" name=vlEncampacao id="vlEncampacao" maxlength="13" 
  onkeyup="js_ValidaCampos(this,4,'Valor de Encampação','f','f',event);">
  </td>
  </tr>
  
  <tr>
  <td><strong>Valor da Atualização:</strong></td>
  <td><input type="text" name=vlAtualizacao id="vlAtualizacao" maxlength="13" 
  onkeyup="js_ValidaCampos(this,4,'Valor da Atualização','f','f',event);">
  </td>
  </tr>
  
  <tr>
  <td><strong>Valor do Saldo Atual:</strong></td>
  <td><input type="text" name=vlSaldoAtual id="vlSaldoAtual" maxlength="13" 
  onkeyup="js_ValidaCampos(this,4,'Valor do Saldo Atual','f','f',event);">
  </td>
  </tr>
  <tr>
	<td align="right" colspan="2">
	<input type="submit" value="Salvar" name="btnSalvar" />
	<input type="submit" value="Excluir" name="btnExcluir" />
	<input type="button" value="Pesquisar" name="btnPesquisar" onclick="pesquisar()" />
	<input type="reset" value="Novo" name="btnNovo" />
	</td>
</tr>
</table>
</fieldset>
</form>

<script type="text/javascript">

/**
 * limitar caracteres de textarea
 */
function textCounter(field, countfield, maxlimit) {
	
	if (field.value.length > maxlimit){
		field.value = field.value.substring(0, maxlimit);
	}else{ 
		countfield.value = maxlimit - field.value.length;
	}
	}

/**
 * buscar dados do xml para criar a tabela
 */
function pesquisar() {
	
	var oAjax = new Ajax.Request("con4_pesquisarxmldividaconsolidada.php",
			{
		method:"post",
		onComplete:cria_tabela
		  }
	);
	
}

/**
 * pesquisar dados no xml pelo codigo digitado
 */
function pesquisar_codigo() {

	var campo = document.getElementById('TabDbLov');
	document.getElementById('lista').removeChild(campo);
	
	var oAjax = new Ajax.Request("con4_pesquisarxmldividaconsolidada.php",
			{
		method:"post",
		parameters:{codigo1: $("codigoDiv").value},
		onComplete:cria_tabela
		  }
	);
	
}

/**
 * 
 */
function pegar_valor(param1, param2, param3, param4, param5, param6, param7, param8, param9, param10, 
		 param11, param12,param13,param14,param15,param16,param17) {
	 
	$('codigo').value = param1;
	document.getElementById('tipoLancamento').options['0'+param2].selected = "true";
	$('nroLeiAutorizacao').value = param3;
	$('dtLeiAutorizacao').value  = param4;
	$('vlSaldoAnterior').value   = param5;
	$('vlContratacao').value     = param6;
	$('vlAmortizacao').value     = param7;
	$('vlCancelamento').value    = param8;
	$('vlEncampacao').value      = param9;
	$('vlAtualizacao').value     = param10;
	$('vlSaldoAtual').value      = param11;
	$('nroContrato').value       = param12;
	$('dataAssinatura').value    = param13;
	document.getElementById('tipoDocumento').options['0'+param14].selected = "true";
	$('nroDocumento').value       = param15;
	$('nomeCredor').value         = param16;
	$('justificativa').value      = param17;
	document.getElementById('lista').style.visibility = "hidden";
	var campo = document.getElementById('TabDbLov'); 
	document.getElementById('lista').removeChild(campo); 
	
}

function fechar() {
	
	var campo = document.getElementById('TabDbLov'); 
	document.getElementById('lista').removeChild(campo); 
	document.getElementById('lista').style.visibility = "hidden";
	
}

function cria_tabela(json) {

	var jsonObj = eval("("+json.responseText+")");
	var tabela;
	var color = "#e796a4";
	tabela  = "<table id=\"TabDbLov\" cellspacing=\"1\" cellpadding=\"2\" border=\"1\">";
	tabela +=	"<tr style=\"text-decoration: underline;\"><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Código";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Tipo de Lançamento";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Número da Lei de Autorização";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Data da Lei de Autorização";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Nome do credor";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Valor do Saldo Atual";
	tabela += "</td></tr>";
	try {
		
		for (var i = 0; i < jsonObj.length; i++) {
			
			if(i % 2 != 0){
					color = "#97b5e6";
			}else{
				color = "#e796a4";
			}
			tabela += "<tr>";
			tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].tipoLancamento+"','"+jsonObj[i].nroLeiAutorizacao+"','"
			+jsonObj[i].dtLeiAutorizacao+"','"+jsonObj[i].vlSaldoAnterior+"','"+jsonObj[i].vlContratacao+"','"
			+jsonObj[i].vlAmortizacao+"','"+jsonObj[i].vlCancelamento+"','"+jsonObj[i].vlEncampacao+"','"+jsonObj[i].vlAtualizacao+"','"
			+jsonObj[i].vlSaldoAtual+"','"+jsonObj[i].nroContrato+"','"+jsonObj[i].dataAssinatura+"','"+jsonObj[i].tipoDocumento+"','"
			+jsonObj[i].nroDocumento+"','"+jsonObj[i].nomeCredor+"','"+jsonObj[i].justificativa+"')\">"+jsonObj[i].codigo+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].tipoLancamento+"','"+jsonObj[i].nroLeiAutorizacao+"','"
			+jsonObj[i].dtLeiAutorizacao+"','"+jsonObj[i].vlSaldoAnterior+"','"+jsonObj[i].vlContratacao+"','"
			+jsonObj[i].vlAmortizacao+"','"+jsonObj[i].vlCancelamento+"','"+jsonObj[i].vlEncampacao+"','"+jsonObj[i].vlAtualizacao+"','"
			+jsonObj[i].vlSaldoAtual+"','"+jsonObj[i].nroContrato+"','"+jsonObj[i].dataAssinatura+"','"+jsonObj[i].tipoDocumento+"','"
			+jsonObj[i].nroDocumento+"','"+jsonObj[i].nomeCredor+"','"+jsonObj[i].justificativa+"')\">"+(jsonObj[i].tipoLancamento == '01' ? "Dívida Mobiliária" : jsonObj[i].tipoLancamento == '02' ? "Dívida Contratual de PPP" : 
			jsonObj[i].tipoLancamento == '03' ? "Demais Dívidas Contratuais Internas"	: jsonObj[i].tipoLancamento == '04' ? "Dívidas Contratuais Externas" :
		  jsonObj[i].tipoLancamento == '05' ? "Precatórios Posteriores a 05/05/2000" : jsonObj[i].tipoLancamento == '06' ? "Parcelamento de Dívidas de Tributos" :
			jsonObj[i].tipoLancamento == '07' ? "Parcelamento de Dívidas Previdenciárias" : jsonObj[i].tipoLancamento == '08' ? "Parcelamento de Dívidas das Demais Contribuições Sociais" :
		  jsonObj[i].tipoLancamento == '09' ?	"Parcelamento de Dívidas do FGTS" : jsonObj[i].tipoLancamento == '10' ? "Outras Dívidas" : "Passivos Reconhecidos")+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].tipoLancamento+"','"+jsonObj[i].nroLeiAutorizacao+"','"
			+jsonObj[i].dtLeiAutorizacao+"','"+jsonObj[i].vlSaldoAnterior+"','"+jsonObj[i].vlContratacao+"','"
			+jsonObj[i].vlAmortizacao+"','"+jsonObj[i].vlCancelamento+"','"+jsonObj[i].vlEncampacao+"','"+jsonObj[i].vlAtualizacao+"','"
			+jsonObj[i].vlSaldoAtual+"','"+jsonObj[i].nroContrato+"','"+jsonObj[i].dataAssinatura+"','"+jsonObj[i].tipoDocumento+"','"
			+jsonObj[i].nroDocumento+"','"+jsonObj[i].nomeCredor+"','"+jsonObj[i].justificativa+"')\">"+jsonObj[i].nroLeiAutorizacao+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].tipoLancamento+"','"+jsonObj[i].nroLeiAutorizacao+"','"
			+jsonObj[i].dtLeiAutorizacao+"','"+jsonObj[i].vlSaldoAnterior+"','"+jsonObj[i].vlContratacao+"','"
			+jsonObj[i].vlAmortizacao+"','"+jsonObj[i].vlCancelamento+"','"+jsonObj[i].vlEncampacao+"','"+jsonObj[i].vlAtualizacao+"','"
			+jsonObj[i].vlSaldoAtual+"','"+jsonObj[i].nroContrato+"','"+jsonObj[i].dataAssinatura+"','"+jsonObj[i].tipoDocumento+"','"
			+jsonObj[i].nroDocumento+"','"+jsonObj[i].nomeCredor+"','"+jsonObj[i].justificativa+"')\">"+jsonObj[i].dtLeiAutorizacao+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].tipoLancamento+"','"+jsonObj[i].nroLeiAutorizacao+"','"
			+jsonObj[i].dtLeiAutorizacao+"','"+jsonObj[i].vlSaldoAnterior+"','"+jsonObj[i].vlContratacao+"','"
			+jsonObj[i].vlAmortizacao+"','"+jsonObj[i].vlCancelamento+"','"+jsonObj[i].vlEncampacao+"','"+jsonObj[i].vlAtualizacao+"','"
			+jsonObj[i].vlSaldoAtual+"','"+jsonObj[i].nroContrato+"','"+jsonObj[i].dataAssinatura+"','"+jsonObj[i].tipoDocumento+"','"
			+jsonObj[i].nroDocumento+"','"+jsonObj[i].nomeCredor+"','"+jsonObj[i].justificativa+"')\">"+jsonObj[i].nomeCredor+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].tipoLancamento+"','"+jsonObj[i].nroLeiAutorizacao+"','"
			+jsonObj[i].dtLeiAutorizacao+"','"+jsonObj[i].vlSaldoAnterior+"','"+jsonObj[i].vlContratacao+"','"
			+jsonObj[i].vlAmortizacao+"','"+jsonObj[i].vlCancelamento+"','"+jsonObj[i].vlEncampacao+"','"+jsonObj[i].vlAtualizacao+"','"
			+jsonObj[i].vlSaldoAtual+"','"+jsonObj[i].nroContrato+"','"+jsonObj[i].dataAssinatura+"','"+jsonObj[i].tipoDocumento+"','"
			+jsonObj[i].nroDocumento+"','"+jsonObj[i].nomeCredor+"','"+jsonObj[i].justificativa+"')\">"+jsonObj[i].vlSaldoAtual+"</a>";
			tabela += "</td></tr>";
			
		}

	} catch (e) {
	}
	tabela += "</table>";
	var conteudo = document.getElementById('lista');
	conteudo.innerHTML += tabela;
	conteudo.style.visibility = "visible";
	
}
</script>