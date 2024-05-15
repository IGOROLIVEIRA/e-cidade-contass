<div id="lista" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Projeção Atuarial do RPPS</span>
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
<td> <input type="text" name="codigoProj" id="codigoProj"  ></td>
</tr>
<tr>
<td></td>
<td><input type="button" name="bntPesquisarXml" value="Pesquisar" onclick="pesquisar_codigo()"></td>
</tr>
</table>
</div><!-- campos -->
</div><!-- lista -->


<form name="form1" method="post" action="">
<fieldset style="width: 500px; height: 200px;"><legend><b>Projeção Atuarial do RPPS</b></legend>
  <table cellspacing="5px">
  <tr>
  <td><strong>Código</strong></td>
  <td> <input type="text" name="codigo" id="codigo" readonly="readonly" style="background-color: rgb(222, 184, 135);" ></td>
  </tr>
  <tr>
  <td><strong>Exercício:</strong></td>
  <td><input type="text" name=exercicio id="exercicio" maxlength="4" 
  onkeyup="js_ValidaCampos(this,1,'Exercício','f','f',event);">
  </td>
  </tr>
  <tr>
  <td><strong>Valor projetado das receitas previdênciarias:</strong></td>
  <td><input type="text" name=vlReceitaPrevidenciaria id="vlReceitaPrevidenciaria" maxlength="13" 
  onkeyup="js_ValidaCampos(this,4,'Valor projetado das receitas previdênciarias','f','f',event);">
  </td>
  </tr>
  <tr>
  <td><strong>Valor projetado das despesas previdenciárias:</strong></td>
  <td><input type="text" name=vlDespesaPrevidenciaria id="vlDespesaPrevidenciaria" maxlength="13" 
  onkeyup="js_ValidaCampos(this,4,'Valor projetado das despesas previdenciárias','f','f',event);">
  </td>
  </tr>
  <tr>
  <td><strong>Valor do Saldo financeiro do exercício anterior:</strong></td>
  <td><input type="text" name=vlSaldoFinanceiroExercicioAnterior id="vlSaldoFinanceiroExercicioAnterior" maxlength="13" 
  onkeyup="js_ValidaCampos(this,4,'Valor do Saldo financeiro do exercício anterior','f','f',event);">
  </td>
  </tr>
  <tr>
	<td align="right" colspan="2">
	<input type="submit" value="Salvar" name="btnSalvar" /><input type="submit" value="Excluir" name="btnExcluir" />
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

	var oAjax = new Ajax.Request("con4_pesquisarxmlprojatuarialrpps.php",
			{
		method: 'post',
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
	
	var oAjax = new Ajax.Request("con4_pesquisarxmlprojatuarialrpps.php",
			{
		method: 'post',
		parameters:{codigo1: $('codigoProj').value},
		onComplete:cria_tabela
			}
   );
	
}

/**
 * 
 */
function pegar_valor(param1, param2, param3, param4, param5) {
	 
	$('codigo').value                             = param1;
	$('exercicio').value                          = param2;
	$('vlReceitaPrevidenciaria').value            = param3;
	$('vlDespesaPrevidenciaria').value            = param4;
	$('vlSaldoFinanceiroExercicioAnterior').value = param5;
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
	tabela += "Exercício";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Valor projetado das receitas previdênciarias";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Valor projetado das despesas previdenciárias";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Valor do Saldo financeiro do exercício anterior";
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
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].exercicio+"','"+jsonObj[i].vlReceitaPrevidenciaria+"','"
			+jsonObj[i].vlDespesaPrevidenciaria+"','"+jsonObj[i].vlSaldoFinanceiroExercicioAnterior+"')\">"+jsonObj[i].codigo+"</a>";
	
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].exercicio+"','"+jsonObj[i].vlReceitaPrevidenciaria+"','"
			+jsonObj[i].vlDespesaPrevidenciaria+"','"+jsonObj[i].vlSaldoFinanceiroExercicioAnterior+"')\">"+jsonObj[i].exercicio+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].exercicio+"','"+jsonObj[i].vlReceitaPrevidenciaria+"','"
			+jsonObj[i].vlDespesaPrevidenciaria+"','"+jsonObj[i].vlSaldoFinanceiroExercicioAnterior+"')\">"+jsonObj[i].vlReceitaPrevidenciaria+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].exercicio+"','"+jsonObj[i].vlReceitaPrevidenciaria+"','"
			+jsonObj[i].vlDespesaPrevidenciaria+"','"+jsonObj[i].vlSaldoFinanceiroExercicioAnterior+"')\">"+jsonObj[i].vlDespesaPrevidenciaria+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].exercicio+"','"+jsonObj[i].vlReceitaPrevidenciaria+"','"
			+jsonObj[i].vlDespesaPrevidenciaria+"','"+jsonObj[i].vlSaldoFinanceiroExercicioAnterior+"')\">"+jsonObj[i].vlSaldoFinanceiroExercicioAnterior+"</a>";
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