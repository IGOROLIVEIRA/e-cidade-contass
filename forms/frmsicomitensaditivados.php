<div id="lista" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Itens Aditivados</span>
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
<td> <input type="text" name="codigoPesq" id="codigoPesq" ></td>
</tr>
<tr>
<td></td>
<td><input type="button" name="bntPesquisarXml" value="Pesquisar" onclick="pesquisar_codigo()"></td>
</tr>
</table>
</div><!-- campos -->
</div><!-- lista -->


<form name="form1" method="post" action="">
<fieldset style="width: 500px; height: 582px;"><legend><b>Itens Aditivados</b></legend>
  <table cellspacing="5px">
  <tr>
  <td><strong>Código</strong></td>
  <td> <input type="text" name="codigo" id="codigo" readonly="readonly" style="background-color: rgb(222, 184, 135);" ></td>
  </tr>
  <tr>
  <td><strong>Código do Aditivo</strong></td>
  <td> <input type="text" name="codAditivo" id="codAditivo" value="<?php echo $_GET['codigoAd']; ?>"></td>
  </tr>
  <tr>
  <td><strong>Número Contrato:</strong></td>
  <td> <input type="text" name="nroContrato" id="nroContrato" value="<?php echo $_GET['nroContrato']; ?>"></td>
  </tr>
  <tr>
  <td><strong>Ano Contrato:</strong></td>
  <td><input type="text" name=AnoContrato id="AnoContrato" maxlength="4" onkeyup="js_ValidaCampos(this,1,'Ano Contrato','f','f',event);"
  value="<?php echo $_GET['anoContrato']; ?>"></td>
  </tr>
   <tr>
	<td><strong>Descrição do Item:<strong></td>
	<td><span id="left"></span>
	<textarea type="text" name="descricaoItem" id="descricaoItem" value="" cols="30" rows="7" 
	onKeyDown="textCounter(this.form1.descricaoArtigo,this.form.remLen,250)" onKeyUp="textCounter(this.form1.descricaoArtigo,this.form.remLen,250)">
	</textarea></td>
  </tr>
  <tr>
  <td><strong>Quantidade</strong></td>
  <td> <input type="text" name="quantidadeItem" id="quantidadeItem" onkeyup="js_ValidaCampos(this,4,'Quantidade','f','f',event);"></td>
  </tr>
  <tr>
  <td><strong>Unidade de Medida</strong></td>
  <td> <input type="text" name="unidade" id="unidade" ></td>
  </tr>
   <tr>
  <td><strong>Valor Unitário</strong></td>
  <td> <input type="text" name="valorUnitarioItem" id="valorUnitarioItem" onkeyup="js_ValidaCampos(this,4,'Valor Unitário','f','f',event);"></td>
  </tr>
  <tr>
	<td align="right" colspan="2" >
	<input type="submit" value="Salvar" name="btnSalvar" />
	<input type="submit" value="Excluir" name="btnExcluir" />
	<input type="button" value="Pesquisar" name="btnPesquisar" onclick="pesquisar()" />
	<input type="reset" value="Novo" name="btnNovo" >
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

	var oAjax = new Ajax.Request("con4_pesquisarxmlitensaditivados.php",
			  {
		  method:"post",
		  parameters:{codadi: $('codAditivo').value, codcontrato: $('nroContrato').value},
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

	var oAjax = new Ajax.Request("con4_pesquisarxmlitensaditivados.php",
			  {
		  method:"post",
		  parameters:{codigo1: $('codigoPesq').value, codadi: $('codAditivo').value, codcontrato: $('nroContrato').value},
		  onComplete:cria_tabela
		    }  
		 );
	
}

/**
 * 
 */
function pegar_valor(param1, param2, param3, param4, param5, param6, param7, param8){
	 
	$('codigo').value = param1;
	$('codAditivo').value = param2;
	$('nroContrato').value = param3;
	$('AnoContrato').value = param4;
	$('descricaoItem').value = param5;
	$('quantidadeItem').value = param6;
	$('unidade').value = param7;
	$('valorUnitarioItem').value = param8;
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
	tabela += "Código Aditivo";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Número do Contrato";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Descrição do Item";
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
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].codAditivo+"','"+jsonObj[i].nroContrato+"','"+jsonObj[i].AnoContrato+"','"+jsonObj[i].descricaoItem+"','"+jsonObj[i].quantidadeItem+"','"
			+jsonObj[i].unidade+"','"+jsonObj[i].valorUnitarioItem+"')\">"+jsonObj[i].codigo+"</a>";
	
			tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].codAditivo+"','"+jsonObj[i].nroContrato+"','"+jsonObj[i].AnoContrato+"','"+jsonObj[i].descricaoItem+"','"+jsonObj[i].quantidadeItem+"','"
			+jsonObj[i].unidade+"','"+jsonObj[i].valorUnitarioItem+"')\">"+jsonObj[i].codAditivo+"</a>";
	
			tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].codAditivo+"','"+jsonObj[i].nroContrato+"','"+jsonObj[i].AnoContrato+"','"+jsonObj[i].descricaoItem+"','"+jsonObj[i].quantidadeItem+"','"
			+jsonObj[i].unidade+"','"+jsonObj[i].valorUnitarioItem+"')\">"+jsonObj[i].nroContrato+"</a>";
	
			tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].codAditivo+"','"+jsonObj[i].nroContrato+"','"+jsonObj[i].AnoContrato+"','"+jsonObj[i].descricaoItem+"','"+jsonObj[i].quantidadeItem+"','"
			+jsonObj[i].unidade+"','"+jsonObj[i].valorUnitarioItem+"')\">"+jsonObj[i].descricaoItem+"</a>";
		
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