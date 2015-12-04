<div id="lista" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Alteração Limite Credito Adicional</span>
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
<td> <input type="text" name="codigoCad" id="codigoCad" onkeyup="js_ValidaCampos(this,1,'Código','f','f',event);"></td>
</tr>
<tr>
  <td><strong>Número da Lei que alterou a lei orçamentária</strong></td>
  <td>
  <input id="nroLei" name="nroLei" maxlength="6" onkeyup="js_ValidaCampos(this,1,'Número da Lei','f','f',event);">
  </td>
</tr>
<tr>
<td></td>
<td><input type="button" name="bntPesquisarXml" value="Pesquisar" onclick="pesquisar_codigo()"></td>
</tr>
</table>
</div><!-- campos -->
</div><!-- lista -->


<form name="form1" method="post" action="">
<fieldset style="width: 533px; height: 375px;"><legend><b>Alteração Limite Credito Adicional</b></legend>
  <table cellspacing="5px">
  <tr>
  <td><strong>Código</strong></td>
  <td> <input type="text" name="codigo" id="codigo" readonly="readonly" style="background-color: rgb(222, 184, 135);" ></td>
  </tr>
  <tr>
  <td><strong>Número da Lei que alterou a lei orçamentária</strong></td>
  <td>
  <input id="nroLeiAlterOrcam" name="nroLeiAlterOrcam" maxlength="6" onkeyup="js_ValidaCampos(this,1,'Número da Lei','f','f',event);">
  </td>
  </tr>
   <tr>
  <td><strong>Data da Lei que alterou a lei orçamentária </strong></td>
  <td><input id="dataLeiAlterOrcam" name="dataLeiAlterOrcam" onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)" 
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10" size="7">
  <input id="dataLeiAlterOrcam_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataLeiAlterOrcam_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataLeiAlterOrcam_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparaDataLeiAlterOrcam(dia,mes,ano){
      var objData = document.getElementById('dtInicio');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>
  </td>
  </tr> 
  <tr>
  <td><strong>Artigo da Lei que alterou a Lei Orçamentária</strong></strong></td>
  <td><input id="artigoLeiAlterOrcamento" name="artigoLeiAlterOrcamento" maxlength="6" onkeyup="js_ValidaCampos(this,1,'Artigo','f','f',event);">
  </td>
  </tr>
  <tr>
	<td><strong>Descrição do artigo da Lei que alterou a Lei Orçamentária:<strong></td>
	<td><span id="left"></span>
	<textarea type="text" name="descricaoArtigo" id="descricaoArtigo" value="" cols="40" rows="7"
	onKeyDown="textCounter(this.form1.descricaoArtigo,this.form.remLen,512)" onKeyUp="textCounter(this.form1.descricaoArtigo,this.form.remLen,512)">
	</textarea></td>
  </tr>
  <tr>
    <td><strong>Novo percentual de suplementação após alteração</strong></td>
    <td>
    <input id="NovoPercentual" name="NovoPercentual" maxlength="6" onkeyup="js_ValidaCampos(this,4,'Percentual','f','f',event);" >
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

	var oAjax =  new Ajax.Request("con4_pesquisarxmlalteracaolimitecreditoadicional.php",
			{
		method:'post',
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
	
	var oAjax =  new Ajax.Request("con4_pesquisarxmlalteracaolimitecreditoadicional.php",
			{
		method:'post',
		parameters:{codigo1: $('codigoCad').value, codigo2: $('nroLei').value},
		onComplete:cria_tabela
		  }
	);
	
}

/**
 * 
 */
function pegar_valor(param1, param2, param3, param4, param5, param6) {
	
	$('codigo').value = param1;
	$('nroLeiAlterOrcam').value = param2;
	$('dataLeiAlterOrcam').value = param3;
	$('artigoLeiAlterOrcamento').value = param4;
	$('descricaoArtigo').value = param5;
	$('NovoPercentual').value = param6;
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
	tabela += "Número da Lei que alterou a lei orçamentária ";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Data da Lei que alterou a lei orçamentária ";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Artigo da Lei que alterou a Lei Orçamentária";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Descrição do artigo da Lei que alterou a Lei Orçamentária";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Novo percentual de sup após alteração ";
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
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].nroLeiAlterOrcam+"','"
			+jsonObj[i].dataLeiAlterOrcam+"','"+jsonObj[i].artigoLeiAlterOrcamento+"','"+jsonObj[i].descricaoArtigo+"','"
			+jsonObj[i].NovoPercentual+"')\">"+jsonObj[i].codigo+"</a>";
	
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].nroLeiAlterOrcam+"','"
			+jsonObj[i].dataLeiAlterOrcam+"','"+jsonObj[i].artigoLeiAlterOrcamento+"','"+jsonObj[i].descricaoArtigo+"','"
			+jsonObj[i].NovoPercentual+"')\">"+jsonObj[i].nroLeiAlterOrcam+"</a>";
	
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].nroLeiAlterOrcam+"','"
			+jsonObj[i].dataLeiAlterOrcam+"','"+jsonObj[i].artigoLeiAlterOrcamento+"','"+jsonObj[i].descricaoArtigo+"','"
			+jsonObj[i].NovoPercentual+"')\">"+jsonObj[i].dataLeiAlterOrcam+"</a>";
	
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].nroLeiAlterOrcam+"','"
			+jsonObj[i].dataLeiAlterOrcam+"','"+jsonObj[i].artigoLeiAlterOrcamento+"','"+jsonObj[i].descricaoArtigo+"','"
			+jsonObj[i].NovoPercentual+"')\">"+jsonObj[i].artigoLeiAlterOrcamento+"</a>";
	
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].nroLeiAlterOrcam+"','"
			+jsonObj[i].dataLeiAlterOrcam+"','"+jsonObj[i].artigoLeiAlterOrcamento+"','"+jsonObj[i].descricaoArtigo+"','"
			+jsonObj[i].NovoPercentual+"')\">"+jsonObj[i].descricaoArtigo+"</a>";
	
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].nroLeiAlterOrcam+"','"
			+jsonObj[i].dataLeiAlterOrcam+"','"+jsonObj[i].artigoLeiAlterOrcamento+"','"+jsonObj[i].descricaoArtigo+"','"
			+jsonObj[i].NovoPercentual+"')\">"+jsonObj[i].NovoPercentual+"</a>";
	
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