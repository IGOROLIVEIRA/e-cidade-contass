<div id="lista" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Limites Credito Adicional</span>
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
<td> <input type="text" name="codigoCad" id="codigoCad" 
onkeyup="js_ValidaCampos(this,1,'Código','f','f',event);"></td>
</tr>
<tr>
  <td><strong>Número da Lei</strong></td>
  <td><input id="nroLei" name="nroLei" maxlength="6" 
  onkeyup="js_ValidaCampos(this,1,'Número da Lei','f','f',event);"></td>
</tr>
<tr>
<td></td>
<td><input type="button" name="bntPesquisarXml" value="Pesquisar" onclick="pesquisar_codigo()"></td>
</tr>
</table>
</div><!-- campos -->
</div><!-- lista -->


<form name="form1" method="post" action="">
<fieldset style="width: 533px; height: 375px;"><legend><b>Limites Credito Adicional</b></legend>
  <table cellspacing="5px">
  <tr>
  <td><strong>Código</strong></td>
  <td> <input type="text" name="codigo" id="codigo" readonly="readonly" style="background-color: rgb(222, 184, 135);" ></td>
  </tr>
  <tr>
  <td><strong>Tipo de Lei</strong></td>
  <td>
  <select id="tipoLeiAlteracao" name="tipoLeiAlteracao" style="width: 303px;" >
  <option value="1" id="01" >Lei autorizativa de Crédito Suplementar</option>
  <option value="2" id="02" >Lei autorizativa de Crédito Especial</option>
  <option value="3" id="03" >Lei autorizativa de Remanejamento /transposição / transferência</option>
  <option value="4" id="04" >Lei autorizativa de alteração da fonte de recurso</option>
  </select>
  </td>
  </tr>
  <tr>
  <td><strong>Número da Lei</strong></td>
  <td><input id="nroLeiAlteracao" name="nroLeiAlteracao" maxlength="6" 
  onkeyup="js_ValidaCampos(this,1,'Número da Lei','f','f',event);"></td>
  </tr>
  <tr>
  <td><strong>Data da Lei</strong></td>
  <td><input id="dataLeiAlteracao" name="dataLeiAlteracao" onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)" 
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10" size="7">
  <input id="dataLeiAlteracao_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataLeiAlteracao_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataLeiAlteracao_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparaDataLeiAlteracao(dia,mes,ano){
      var objData = document.getElementById('dtInicio');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>
  
  
  </td>
  </tr> 
  <tr>
  <td><strong>Número Artigo da Lei</strong></td>
  <td><input id="artigoLeiAlteracao" name="artigoLeiAlteracao" maxlength="6" 
  onkeyup="js_ValidaCampos(this,1,'Número da Lei','f','f',event);"></td>
  </tr>
  
  <tr>
	<td><strong>Descrição Artigo:<strong></td>
	<td><span id="left"></span>
	<textarea type="text" name="descricaoArtigo" id="descricaoArtigo" value="" cols="40" rows="7" 
	onKeyDown="textCounter(this.form1.descricaoArtigo,this.form.remLen,512)" onKeyUp="textCounter(this.form1.descricaoArtigo,this.form.remLen,512)">
	</textarea></td>
  </tr>

  <tr>
  <td><strong>Valor Autorizado</strong></strong></td>
  <td><input id="vlAutorizadoAlteracao" name="vlAutorizadoAlteracao"    
  onkeyup="js_ValidaCampos(this,4,'Valor Autorizado','f','f',event);"></td>
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

	var oAjax = new Ajax.Request("con4_pesquisarxmllimitescreditoadicional.php",
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
	
	var oAjax = new Ajax.Request("con4_pesquisarxmllimitescreditoadicional.php",
			{
		method:"post",
		parameters:{codigo1:  $('codigoCad').value, codigo2: $('nroLei').value},
		onComplete:cria_tabela
		  }
	);
	
}

/**
 * 
 */
function pegar_valor(param1, param2, param3, param4, param5, param6, param7) {
	
	$('codigo').value = param1;
	$('tipoLeiAlteracao').options['0'+param2].selected = "true";
	$('nroLeiAlteracao').value = param3;
	$('dataLeiAlteracao').value = param4;
	$('artigoLeiAlteracao').value = param5;
	$('descricaoArtigo').value = param6;
	$('vlAutorizadoAlteracao').value = param7;
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
	tabela += "Tipo de Lei";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Número da Lei";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Data da Lei";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Número Artigo da Lei";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Descrição Artigo";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Valor Autorizado";
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
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].tipoLeiAlteracao+"','"+jsonObj[i].nroLeiAlteracao+"','"
			+jsonObj[i].dataLeiAlteracao+"','"+jsonObj[i].artigoLeiAlteracao+"','"+jsonObj[i].descricaoArtigo+"','"
			+jsonObj[i].vlAutorizadoAlteracao+"')\">"+jsonObj[i].codigo+"</a>";
	
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].tipoLeiAlteracao+"','"+jsonObj[i].nroLeiAlteracao+"','"
			+jsonObj[i].dataLeiAlteracao+"','"+jsonObj[i].artigoLeiAlteracao+"','"+jsonObj[i].descricaoArtigo+"','"
			+jsonObj[i].vlAutorizadoAlteracao+"')\">"+(jsonObj[i].tipoLeiAlteracao == 1 ? "Lei autorizativa de Crédito Suplementar" :
			jsonObj[i].tipoLeiAlteracao == 2 ? "Lei autorizativa de Crédito Especial" : jsonObj[i].tipoLeiAlteracao == 3 ? 
			"Lei autorizativa de Remanejamento /transposição / transferência" : "Lei autorizativa de alteração da fonte de recurso")+"</a>";
	
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].tipoLeiAlteracao+"','"+jsonObj[i].nroLeiAlteracao+"','"
			+jsonObj[i].dataLeiAlteracao+"','"+jsonObj[i].artigoLeiAlteracao+"','"+jsonObj[i].descricaoArtigo+"','"
			+jsonObj[i].vlAutorizadoAlteracao+"')\">"+jsonObj[i].nroLeiAlteracao+"</a>";
	
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].tipoLeiAlteracao+"','"+jsonObj[i].nroLeiAlteracao+"','"
			+jsonObj[i].dataLeiAlteracao+"','"+jsonObj[i].artigoLeiAlteracao+"','"+jsonObj[i].descricaoArtigo+"','"
			+jsonObj[i].vlAutorizadoAlteracao+"')\">"+jsonObj[i].dataLeiAlteracao+"</a>";
	
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].tipoLeiAlteracao+"','"+jsonObj[i].nroLeiAlteracao+"','"
			+jsonObj[i].dataLeiAlteracao+"','"+jsonObj[i].artigoLeiAlteracao+"','"+jsonObj[i].descricaoArtigo+"','"
			+jsonObj[i].vlAutorizadoAlteracao+"')\">"+jsonObj[i].artigoLeiAlteracao+"</a>";
	
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].tipoLeiAlteracao+"','"+jsonObj[i].nroLeiAlteracao+"','"
			+jsonObj[i].dataLeiAlteracao+"','"+jsonObj[i].artigoLeiAlteracao+"','"+jsonObj[i].descricaoArtigo+"','"
			+jsonObj[i].vlAutorizadoAlteracao+"')\">"+jsonObj[i].descricaoArtigo+"</a>";
	
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].tipoLeiAlteracao+"','"+jsonObj[i].nroLeiAlteracao+"','"
			+jsonObj[i].dataLeiAlteracao+"','"+jsonObj[i].artigoLeiAlteracao+"','"+jsonObj[i].descricaoArtigo+"','"
			+jsonObj[i].vlAutorizadoAlteracao+"')\">"+jsonObj[i].vlAutorizadoAlteracao+"</a>";
		
			tabela += "</td></tr>";
		}

	}catch (e) {
	}
	tabela += "</table>";
	var conteudo = document.getElementById('lista');
	conteudo.innerHTML += tabela;
	conteudo.style.visibility = "visible";
	
}
</script>