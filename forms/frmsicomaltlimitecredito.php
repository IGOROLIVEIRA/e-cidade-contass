<div id="lista" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Limites Crédito Adicional</span>
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
<td> <input type="text" name="codigoCad" id="codigoCad" onkeyup="js_ValidaCampos(this,1,'Código','f','f',event);" ></td>
</tr>
<tr>
<td><strong>Número Lei</strong></td>
<td> <input type="text" name="numLei" id="numLei" ></td>
</tr>
<tr>
<td></td>
<td><input type="button" name="bntPesquisarXml" value="Pesquisar" onclick="pesquisar_codigo()"></td>
</tr>
</table>
</div><!-- campos -->
</div><!-- lista -->


<form name="form1" method="post" action="">
<fieldset style="width: 700px; height: 274px;"><legend><b>Limites Crédito Adicional</b></legend>
  <table cellspacing="5px">
  
  <tr>
  <td><strong>Código</strong></td>
  <td> <input type="text" name="codigo" id="codigo" readonly="readonly" style="background-color: rgb(222, 184, 135);" ></td>
  </tr>
  
  <tr>
  <td><strong>Número da Lei de Alteração:</strong></td>
  <td>
  <input type="text" name="nroLeiAlterOrcam" id="nroLeiAlterOrcam" maxlength="10" >
  </td>
  </tr>

  <tr>
  <td><strong>Data da Lei de Alteração: </strong></td>
  <td>
  <input type="text" name="dataLeiAlterOrcam" id="dataLeiAlterOrcam" onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)" 
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10">
  <input id="dataLeiAlterOrcam_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataLeiAlterOrcam_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataLeiAlterOrcam_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparaDatasdataPublicacao(dia,mes,ano){
      var objData = document.getElementById('dataLeiAlterOrcam');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>

  </td>
  </tr>
  
  <tr>
  <td><strong>Número Artigo Lei de Alteração: </strong></td>
  <td>
  <input type="text" name="artigoLeiAlterOrcamento" id="artigoLeiAlterOrcamento" maxlength="10">
  </td>
  </tr>
  
  <tr>
	<td><strong>Descrição Artigo Lei de Alteração: </strong></td>
	<td>
	<textarea name="descricaoArtigo" id="descricaoArtigo" value="" cols="30" rows="2" 
	onKeyDown="textCounter(this.form.multaInadimplemento,this.form.remLen,100)" onKeyUp="textCounter(this.form.multaInadimplemento,this.form.remLen,512)">
	</textarea>
	</td>
  </tr>
  
  <tr>
  <td><strong>Valor Autorizado: </strong></td>
  <td>
  <input type="text" name="novoPercentual" id="novoPercentual" onkeyup="js_ValidaCampos(this,4,'Valor','f','f',event);">
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

	var oAjax = new Ajax.Request("con4_pesquisarxmlaltlimitecredito.php",
			{
		method:"post",
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

	var oAjax = new Ajax.Request("con4_pesquisarxmlaltlimitecredito.php",
			{
		method:"post",
		parameters:{codigo1: $('codigoCad').value,codigo2: $('numLei').value},
		onComplete:cria_tabela
		  }
	  );
	  
}

/**
 * 
 */
function pegar_valor(param1, param2, param3, param4, param5, param6){
	
	$('codigo').value = param1;
	$('nroLeiAlterOrcam').value = param2;
	$('dataLeiAlterOrcam').value = param3;
	$('artigoLeiAlterOrcamento').value = param4;
	$('descricaoArtigo').value = param5;
	$('novoPercentual').value = param6;
	
	document.getElementById('lista').style.visibility = "hidden";
	var campo = document.getElementById('TabDbLov'); 
	document.getElementById('lista').removeChild(campo); 
	
}

function fechar(){
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
	tabela += "Número da Lei";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Data da Lei";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Artigo Lei de Alteração";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Descrição Artigo";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Valor";
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
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].nroLeiAlterOrcam+"','"+jsonObj[i].dataLeiAlterOrcam+"','"
			+jsonObj[i].artigoLeiAlterOrcamento+"','"+jsonObj[i].descricaoArtigo+"','"+jsonObj[i].novoPercentual+"')\">"+jsonObj[i].codigo+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].nroLeiAlterOrcam+"','"+jsonObj[i].dataLeiAlterOrcam+"','"
			+jsonObj[i].artigoLeiAlterOrcamento+"','"+jsonObj[i].descricaoArtigo+"','"+jsonObj[i].novoPercentual+"')\">"+jsonObj[i].nroLeiAlterOrcam+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].nroLeiAlterOrcam+"','"+jsonObj[i].dataLeiAlterOrcam+"','"
			+jsonObj[i].artigoLeiAlterOrcamento+"','"+jsonObj[i].descricaoArtigo+"','"+jsonObj[i].novoPercentual+"')\">"+jsonObj[i].dataLeiAlterOrcam+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].nroLeiAlterOrcam+"','"+jsonObj[i].dataLeiAlterOrcam+"','"
			+jsonObj[i].artigoLeiAlterOrcamento+"','"+jsonObj[i].descricaoArtigo+"','"+jsonObj[i].novoPercentual+"')\">"+jsonObj[i].artigoLeiAlterOrcamento+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].nroLeiAlterOrcam+"','"+jsonObj[i].dataLeiAlterOrcam+"','"
			+jsonObj[i].artigoLeiAlterOrcamento+"','"+jsonObj[i].descricaoArtigo+"','"+jsonObj[i].novoPercentual+"')\">"+jsonObj[i].descricaoArtigo.substr(0,50)+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].nroLeiAlterOrcam+"','"+jsonObj[i].dataLeiAlterOrcam+"','"
			+jsonObj[i].artigoLeiAlterOrcamento+"','"+jsonObj[i].descricaoArtigo+"','"+jsonObj[i].novoPercentual+"')\">"+jsonObj[i].novoPercentual+"</a>";
			
			tabela += "</td></tr>";
		}
		
	} catch(e){
	}
	tabela += "</table>";
	var conteudo = document.getElementById('lista');
	conteudo.innerHTML += tabela;
	conteudo.style.visibility = "visible";
	
}
</script>