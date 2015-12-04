<div id="lista" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Decreto Municipal Regulamentador do Pregão / Registro de Preços</span>
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
<td> <input type="text" name="codigoSeg" id="codigoSeg" maxlength="13" onkeyup="js_ValidaCampos(this,1,'Codigo','f','f',event);" /></td>
</tr>
<tr>
<td><strong>Número do Decreto Municipal:</strong></td>
<td>
 <input type="text" name="nroDecreto" id="nroDecreto" maxlength="14"  />
</td>
</tr>
<tr>
<td></td>
<td><input type="button" name="bntPesquisarXml" value="Pesquisar" onclick="pesquisar_codigo()" ></td>
</tr>
</table>
</div> <!-- campos -->
</div> <!-- lista -->


<form name="form1" method="post" action="">
<fieldset style="width: 500px; height: 200px;"><legend><b>Decreto Municipal Regulamentador do Pregão / Registro de Preços</b></legend>
  <table cellspacing="5px">
  <tr>
  <td><strong>Código</strong></td>
  <td> <input type="text" name="codigo" id="codigo" readonly="readonly" style="background-color: rgb(222, 184, 135);" ></td>
  </tr>
  <tr>
  <td><strong>Tipo Decreto:</strong></td>
  <td>
  <select name="tipoDecreto" id="tipoDecreto">
  	<option value="01" id="01">Registro de preço</option>
  	<option value="02" id="02">Pregão</option>
  </select>
  </td>
  </tr>
  <tr>
  <td><strong>Número do Decreto Municipal:</strong></td>
  <td><input type="text" name="nroDecretoMunicipal" id="nroDecretoMunicipal" maxlength="9" 
  >
  </td>
  </tr>
  <tr>
  <td>
  <strong>Data do Decreto Municipal:</strong></td>
  <td><input type="text" name="dataDecretoMunicipal" id="dataDecretoMunicipal" onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)" 
 autocomplete="off" onblur="js_validaDbData(this);" maxlength="10">
 <input id="dataDecretoMunicipal_dia" type="hidden" maxlength="2" size="2" value="" title="" >
 <input id="dataDecretoMunicipal_mes" type="hidden" maxlength="2" size="2" value="" title="" >
 <input id="dataDecretoMunicipal_ano" type="hidden" maxlength="4" size="4" value="" title="" >
 <script>
   var PosMouseY, PosMoudeX;
   function js_comparaDatasodataDecretoMunicipal(dia,mes,ano){
     var objData = document.getElementById('dtInicio');
     objData.value = dia+"/"+mes+'/'+ano;
   }
 </script>
 
  </td>
  </tr>
  <tr>
  <td><strong>Data da Publicação do Decreto Municipal:</strong></td>
  <td>
  <input type="text" name="dataPublicacaoDecretoMunicipal" id="dataPublicacaoDecretoMunicipal" onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)" 
 autocomplete="off" onblur="js_validaDbData(this);" maxlength="10">
 <input id="dataPublicacaoDecretoMunicipal_dia" type="hidden" maxlength="2" size="2" value="" title="" >
 <input id="dataPublicacaoDecretoMunicipal_mes" type="hidden" maxlength="2" size="2" value="" title="" >
 <input id="dataPublicacaoDecretoMunicipal_ano" type="hidden" maxlength="4" size="4" value="" title="" >
 <script>
   var PosMouseY, PosMoudeX;
   function js_comparaDatasodataPublicacaoDecretoMunicipal(dia,mes,ano){
     var objData = document.getElementById('dtInicio');
     objData.value = dia+"/"+mes+'/'+ano;
   }
 </script>
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
	
  var oAjax = new Ajax.Request("con4_pesquisarxmldecpregaoregpreco.php",
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

  var oAjax = new Ajax.Request("con4_pesquisarxmldecpregaoregpreco.php",
		  {
	  method:"post",
	  parameters:{codigo1: $("codigoSeg").value, codigo2: $("nroDecreto").value},
	  onComplete:cria_tabela
	    }
  );
	
}

/**
 * 
 */
function pegar_valor(param1, param2, param3, param4, param5) {
	
	$('codigo').value                         = param1;
	document.getElementById('tipoDecreto').options[param2].selected = "true";
	$('nroDecretoMunicipal').value            = param3;
	$('dataDecretoMunicipal').value           = param4;
	$('dataPublicacaoDecretoMunicipal').value = param5;
	
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
	tabela += "Tipo de decreto regulamentador";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Número do Decreto Municipal";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Data do Decreto Municipal";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Data da Publicação do DecretoMunicipal";
	tabela += "</td></tr>";

	try {
	
		for (var i = 0; i < jsonObj.length; i++) {
			
			if(i % 2 != 0) {
					color = "#97b5e6";
			} else {
				color = "#e796a4";
			}
			tabela += "<tr>";
	
			tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].tipoDecreto+"','"+jsonObj[i].nroDecretoMunicipal+"','"
			+jsonObj[i].dataDecretoMunicipal+"','"+jsonObj[i].dataPublicacaoDecretoMunicipal+"')\">"+jsonObj[i].codigo+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].tipoDecreto+"','"+jsonObj[i].nroDecretoMunicipal+"','"
			+jsonObj[i].dataDecretoMunicipal+"','"+jsonObj[i].dataPublicacaoDecretoMunicipal+"')\">"+(jsonObj[i].tipoDecreto == '01' ? 
			"Registro de preço" : "Pregão")+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].tipoDecreto+"','"+jsonObj[i].nroDecretoMunicipal+"','"
			+jsonObj[i].dataDecretoMunicipal+"','"+jsonObj[i].dataPublicacaoDecretoMunicipal+"')\">"+jsonObj[i].nroDecretoMunicipal+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].tipoDecreto+"','"+jsonObj[i].nroDecretoMunicipal+"','"
			+jsonObj[i].dataDecretoMunicipal+"','"+jsonObj[i].dataPublicacaoDecretoMunicipal+"')\">"+jsonObj[i].dataDecretoMunicipal+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].tipoDecreto+"','"+jsonObj[i].nroDecretoMunicipal+"','"
			+jsonObj[i].dataDecretoMunicipal+"','"+jsonObj[i].dataPublicacaoDecretoMunicipal+"')\">"+jsonObj[i].dataPublicacaoDecretoMunicipal+"</a>";
			
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