<div id="lista" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Empenhos</span>
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
<td><strong>Empenho:</strong></td>
<td> <input type="text" name="codigoEmpenho" id="codigoEmpenho" maxlength="13" onkeyup="js_ValidaCampos(this,1,'código','f','f',event);"></td>
</tr>
<tr>
<td><strong>Ano Empenho:</strong></td>
<td>
 <input type="text" name="anoEmpenhoPesq" id="anoEmpenhoPesq" maxlength="13" onkeyup="js_ValidaCampos(this,1,'Ano Empenho','f','f',event);">
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
<fieldset style="width: 500px; height: 180px;"><legend><b>Empenhos</b></legend>
  <table cellspacing="5px">
  
  <tr>
  <td><strong>Código</strong></td>
  <td> <input type="text" name="codigo" id="codigo" readonly="readonly" style="background-color: rgb(222, 184, 135);" ></td>
  </tr>
  
  <tr>
  <td><strong>Código Contrato</strong></td>
  <td> <input type="text" name="codContrato" id="codContrato" readonly="readonly" style="background-color: rgb(222, 184, 135);" 
  value="<?php echo $_GET['codigo'] ?>" ></td>
  </tr>
  
  <tr>
  <td><strong>Empenho</strong></td>
  <td> <input type="text" name="codEmpenho" id="codEmpenho" maxlength="20"  onkeyup="js_ValidaCampos(this,1,'Empenho','f','f',event);"/></td>
  </tr>
  
  <tr>
  <td><strong>Ano Empenho</strong></td>
  <td> <input type="text" name="anoEmpenho" id="anoEmpenho" maxlength="4"  onkeyup="js_ValidaCampos(this,1,'Ano Empenho','f','f',event);"/></td>
  </tr>
  
  <tr>
	<td align="right" colspan="2">
	<input type="submit" value="Salvar" name="btnSalvar" />
	<input type="submit" value="Excluir" name="btnExcluir" />
	<input type="button" value="Pesquisar" name="btnPesquisar" onclick="pesquisar()" />
	<input type="reset"  value="Novo"  name="btnNovo">
	</td>
</tr>
</table>
</fieldset>
</form>

<script type="text/javascript">

	/**
	 * buscar dados do xml para criar a tabela
	 */
	function pesquisar(){

		var oAjax = new Ajax.Request("con4_pesquisarxmldotacao.php",
				{
			method: "post",
			parameters:{codigo1: $("codContrato").value},
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

		var oAjax = Ajax.Request("con4_pesquisarxmldotacao.php",
				{
			method:"post",
			parameters:{codigo1: $("codContrato").value, codigo2: $("codigoEmpenho").value, codigo3: $("anoEmpenhoPesq").value},
			onComplete:cria_tabela
			  }
		  );
		
	}

	/**
	 * 
	 */
	function pegar_valor(param1, param2, param3, param4) {
		
		$('codigo').value      = param1;
		$('codContrato').value = param2;
		$('codEmpenho').value  = param3;
		$('anoEmpenho').value  = param4;
		
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

		jsonObj = eval("("+json.responseText+")");
		
		var tabela;
		var color = "#e796a4";
		tabela  = "<table id=\"TabDbLov\" cellspacing=\"1\" cellpadding=\"2\" border=\"1\">";
		tabela +=	"<tr style=\"text-decoration: underline;\"><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
		tabela += "Código";

		tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
		tabela += "Código Contrato";
		
		tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
		tabela += "Código Empenho";
		
		tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
		tabela += "Ano Empenho";
		
		tabela += "</td></tr>";
		for (var i = 0; i < jsonObj.length; i++) {
			
			if(i % 2 != 0){
					color = "#97b5e6";
			}else{
				color = "#e796a4";
			}
			tabela += "<tr>";
			
			tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].codContrato+"','"+jsonObj[i].codEmpenho+"','"+jsonObj[i].anoEmpenho+"')\">"+jsonObj[i].codigo+"</a>";

			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].codContrato+"','"+jsonObj[i].codEmpenho+"','"+jsonObj[i].anoEmpenho+"')\">"+jsonObj[i].codContrato+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].codContrato+"','"+jsonObj[i].codEmpenho+"','"+jsonObj[i].anoEmpenho+"')\">"+jsonObj[i].codEmpenho+"</a>";
			
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].codContrato+"','"+jsonObj[i].codEmpenho+"','"+jsonObj[i].anoEmpenho+"')\">"+jsonObj[i].anoEmpenho+"</a>";

			tabela += "</td></tr>";
			
		}
		tabela += "</table>";
		var conteudo = document.getElementById('lista');
		conteudo.innerHTML += tabela;
    conteudo.style.visibility = "visible";
		
	}
</script>