<div id="lista" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Dados complementares LRF</span>
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
<td> <input type="text" name="codigoDados" id="codigoDados" ></td>
</tr>
<tr>
<td></td>
<td><input type="button" name="bntPesquisarXml" value="Pesquisar" onclick="pesquisar_codigo()"></td>
</tr>
</table>
</div><!-- campos -->
</div><!-- lista -->


<form name="form1" method="post" action="">
<fieldset style="width: 500px; height: 230px;"><legend><b>Dados complementares LRF</b></legend>
  <table cellspacing="5px">
  <tr>
  <td><strong>Código</strong></td>
  <td> <input type="text" name="codigo" id="codigo" readonly="readonly" style="background-color: rgb(222, 184, 135);" ></td>
  </tr>
  <tr>
  <td><strong>Saldo atual das concessões:</strong></td>
  <td><input type="text" name=vlSaldoAtualConcGarantia id="vlSaldoAtualConcGarantia" maxlength="13" 
  onkeyup="js_ValidaCampos(this,4,'Saldo atual das concessões','f','f',event);">
  </td>
  </tr>
  <tr>
  <td><strong>Receita de Privatização:</strong></td>
  <td><input type="text" name=recPrivatizacao id="recPrivatizacao"maxlength="13" 
  onkeyup="js_ValidaCampos(this,4,'Receita de Privatização','f','f',event);">
  </td>
  </tr>
  <tr>
  <td><strong>Valor Liquidado de Incentivo a Contribuinte:</strong></td>
  <td><input type="text" name=vlLiqIncentContrib id="vlLiqIncentContrib" maxlength="13" 
  onkeyup="js_ValidaCampos(this,4,'Valor Liquidado de Incentivo a Contribuinte','f','f',event);">
  </td>
  </tr>
  <tr>
  <td><strong>Valor concedido por Instituição Financeira:</strong></td>
  <td><input type="text" name=vlLiqIncentInstFinanc id="vlLiqIncentInstFinanc" maxlength="13" 
  onkeyup="js_ValidaCampos(this,4,'Valor concedido por Instituição Financeira','f','f',event);">
  </td>
  </tr>
  <tr>
  <td><strong>Valor Inscrito em RP Não Processados de Incentivo:</strong></td>
  <td><input type="text" name=vlIRPNPIncentContrib id="vlIRPNPIncentContrib" maxlength="13" 
  onkeyup="js_ValidaCampos(this,4,'Valor Inscrito em RP Não Processados de Incentivo','f','f',event);">
  </td>
  </tr>
  <tr>
  <td><strong>Valor Inscrito em RP Não Processados por Instituição Financeira:</strong></td>
  <td><input type="text" name=vlIRPNPIncentInstFinanc id="vlIRPNPIncentInstFinanc" maxlength="13" 
  onkeyup="js_ValidaCampos(this,4,'Valor Inscrito em RP Não Processados por Instituição Financeira','f','f',event);">
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
	
	if (field.value.length > maxlimit) {
		field.value = field.value.substring(0, maxlimit);
	}else{ 
		countfield.value = maxlimit - field.value.length;
	}
	
}

/**
 * buscar dados do xml para criar a tabela
 */
function pesquisar(){

  var oAjax = new Ajax.Request("con4_pesquisarxmldadoscomplementalrf.php",
		  {
	  method:'post',
	  onComplete:cria_tabela
	    }
  );
	
}

/**
 * pesquisar dados no xml pelo codigo digitado
 */
function pesquisar_codigo(){
	
	var campo = document.getElementById('TabDbLov');
	document.getElementById('lista').removeChild(campo);
	
  var oAjax = new Ajax.Request("con4_pesquisarxmldadoscomplementalrf.php",
		  {
	  method:'post',
	  parameters:{codigo1: $('codigoDados').value},
	  onComplete:cria_tabela
	    }
  );
	
}

/**
 * 
 */
function pegar_valor(param1, param2, param3, param4, param5, param6, param7, param8, param9, param10) {
	
	$('codigo').value                   = param1;
	$('vlSaldoAtualConcGarantia').value = param2;
	$('recPrivatizacao').value          = param3;
	$('vlLiqIncentContrib').value       = param4;
	$('vlLiqIncentInstFinanc').value    = param5;
	$('vlIRPNPIncentContrib').value     = param6;
	$('vlIRPNPIncentInstFinanc').value  = param7;
	
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
	tabela += "Saldo atual das concessões";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Receita de Privatização";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Valor Liquidado de Incentivo a Contribuinte";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Valor concedido por Instituição";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Valor Inscrito Incentivo a Contribuinte";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Valor Insc RP Não Proc de Incentivo Conc por Inst Financeira";
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
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].vlSaldoAtualConcGarantia+"','"+jsonObj[i].recPrivatizacao+"','"
			+jsonObj[i].vlLiqIncentContrib+"','"+jsonObj[i].vlLiqIncentInstFinanc+"','"+jsonObj[i].vlIRPNPIncentContrib+"','"
			+jsonObj[i].vlIRPNPIncentInstFinanc+"')\">"+jsonObj[i].codigo+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].vlSaldoAtualConcGarantia+"','"+jsonObj[i].recPrivatizacao+"','"
			+jsonObj[i].vlLiqIncentContrib+"','"+jsonObj[i].vlLiqIncentInstFinanc+"','"+jsonObj[i].vlIRPNPIncentContrib+"','"
			+jsonObj[i].vlIRPNPIncentInstFinanc+"')\">"+jsonObj[i].vlSaldoAtualConcGarantia+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].vlSaldoAtualConcGarantia+"','"+jsonObj[i].recPrivatizacao+"','"
			+jsonObj[i].vlLiqIncentContrib+"','"+jsonObj[i].vlLiqIncentInstFinanc+"','"+jsonObj[i].vlIRPNPIncentContrib+"','"
			+jsonObj[i].vlIRPNPIncentInstFinanc+"')\">"+jsonObj[i].recPrivatizacao+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].vlSaldoAtualConcGarantia+"','"+jsonObj[i].recPrivatizacao+"','"
			+jsonObj[i].vlLiqIncentContrib+"','"+jsonObj[i].vlLiqIncentInstFinanc+"','"+jsonObj[i].vlIRPNPIncentContrib+"','"
			+jsonObj[i].vlIRPNPIncentInstFinanc+"')\">"+jsonObj[i].vlLiqIncentContrib+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].vlSaldoAtualConcGarantia+"','"+jsonObj[i].recPrivatizacao+"','"
			+jsonObj[i].vlLiqIncentContrib+"','"+jsonObj[i].vlLiqIncentInstFinanc+"','"+jsonObj[i].vlIRPNPIncentContrib+"','"
			+jsonObj[i].vlIRPNPIncentInstFinanc+"')\">"+jsonObj[i].vlLiqIncentInstFinanc+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].vlSaldoAtualConcGarantia+"','"+jsonObj[i].recPrivatizacao+"','"
			+jsonObj[i].vlLiqIncentContrib+"','"+jsonObj[i].vlLiqIncentInstFinanc+"','"+jsonObj[i].vlIRPNPIncentContrib+"','"
			+jsonObj[i].vlIRPNPIncentInstFinanc+"')\">"+jsonObj[i].vlIRPNPIncentContrib+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].vlSaldoAtualConcGarantia+"','"+jsonObj[i].recPrivatizacao+"','"
			+jsonObj[i].vlLiqIncentContrib+"','"+jsonObj[i].vlLiqIncentInstFinanc+"','"+jsonObj[i].vlIRPNPIncentContrib+"','"
			+jsonObj[i].vlIRPNPIncentInstFinanc+"')\">"+jsonObj[i].vlIRPNPIncentInstFinanc+"</a>";
	
			tabela += "</td></tr>";
			
		}

	} catch(e) {
	}
	tabela += "</table>";
	var conteudo = document.getElementById('lista');
	conteudo.innerHTML += tabela;
  conteudo.style.visibility = "visible";
	
}
</script>