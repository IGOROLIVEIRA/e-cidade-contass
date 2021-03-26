<div id="lista" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Licitação</span>
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
<td> <input type="text" name="codigoLic" id="codigoLic" ></td>
</tr>
<tr>
<td></td>
<td><input type="button" name="bntPesquisarXml" value="Pesquisar" onclick="pesquisar_codigo()"></td>
</tr>
</table>
</div><!-- campos -->
</div><!-- lista -->


<form name="form1" method="post" action="">
<fieldset style="width: 500px; height: 300px;"><legend><b>Licitação</b></legend>
  <table cellspacing="5px">
  <tr>
  <td><strong>Código</strong></td>
  <td> <input type="text" name="codigo" id="codigo" readonly="readonly" style="background-color: rgb(222, 184, 135);" ></td>
  </tr>
  <tr>
  <td><strong>Codigo do Tipo de Comissao:</strong></td>
  <td>
  <select name="codTipoComissao" id="codTipoComissao" >
  	<option value="01" id="01">Especial</option>
  	<option value="02" id="02">Permanente</option>
  </select>
  </td>
  </tr>
  <tr>
  <td><strong>Descrição do ato de nomeação:</strong></td>
  <td>
  <select name="descricaoAtoNomeacao" id="descricaoAtoNomeacao">
  	<option value="01" id="01">Portaria</option>
  	<option value="02" id="02">Decreto</option>
  </select>
  </td>
  </tr>
  <tr>
  <td><strong>Número do Ato de Nomeação:</strong></td>
  <td><input type="text" name=nroAtoNomeacao id="nroAtoNomeacao" maxlength="7"
  onkeyup="js_ValidaCampos(this,1,'Número do Ato de Nomeação','f','f',event);"></td>
  </tr>
  <tr>
  <td><strong>Data do Ato de Nomeação:</strong></td>
  <td><input type="text" name=dataAtoNomeacao id="dataAtoNomeacao" onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)"
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10">
  <input id="dataAtoNomeacao_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataAtoNomeacao_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataAtoNomeacao_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparaDatasodataAtoNomeacao(dia,mes,ano){
      var objData = document.getElementById('dtInicio');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>

  </td>
  </tr>
  <tr>
  <td><strong>Data do início da vigência:</strong></td>
  <td><input type="text" name=inicioVigencia id="inicioVigencia" onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)"
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10">
  <input id="inicioVigencia_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="inicioVigencia_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="inicioVigencia_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparaDatasoinicioVigencia(dia,mes,ano){
      var objData = document.getElementById('dtInicio');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>
  </td>
  </tr>
  <tr>
  <td><strong>Data do fim da vigência:</strong></td>
  <td><input type="text" name=finalVigencia id="finalVigencia" onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)"
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10">
  <input id="finalVigencia_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="finalVigencia_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="finalVigencia_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparaDatasofinalVigencia(dia,mes,ano){
      var objData = document.getElementById('dtInicio');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>

  </td>
  </tr>
  <tr>
	<td align="right" colspan="2">
	<input type="submit" value="Salvar" name="btnSalvar" />
	<input type="submit" value="Excluir" name="btnExcluir" />
	<input type="button" value="Pesquisar" name="btnPesquisar" onclick="pesquisar()" />
	<input type="reset" value="Novo" name="btnNovo" onclick="limpar_codigo('')"/>
	</td>
</tr>
</table>
</fieldset>
</form>

<script type="text/javascript">

function limpar_codigo(cod) {

	CurrentWindow.corpo.iframe_db_resps.location.href='con4_sicomresponsavel.php?codigo='+cod;
	if (cod == '') {
	  parent.document.formaba.db_resps.disabled=true;
	}

}

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
function pesquisar(){

	var oAjax = new Ajax.Request("con4_pesquisarxmllicitacao.php",
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

	var oAjax = new Ajax.Request("con4_pesquisarxmllicitacao.php",
			{
		method:'post',
		parameters:{codigo1: $('codigoLic').value},
		onComplete:cria_tabela
			}
	 );

}

/**
 *
 */
function pegar_valor(param1, param2, param3, param4, param5, param6, param7){

	$('codigo').value = param1;
	document.getElementById("codTipoComissao").options[param2].selected = "true";
	document.getElementById("descricaoAtoNomeacao").options[param3].selected = "true";
	$('nroAtoNomeacao').value = param4;
	$('dataAtoNomeacao').value = param5;
	$('inicioVigencia').value = param6;
	$('finalVigencia').value = param7;

	CurrentWindow.corpo.iframe_db_resps.location.href='con4_sicomresponsavel.php?codigo='+param1;
    parent.document.formaba.db_resps.disabled=false;

	document.getElementById('lista').style.visibility = "hidden";
	var campo = document.getElementById('TabDbLov');
	document.getElementById('lista').removeChild(campo);

}

function fechar(){
	var campo = document.getElementById('TabDbLov');
	document.getElementById('lista').removeChild(campo);
	document.getElementById('lista').style.visibility = "hidden";
}

function cria_tabela(json){

	var jsonObj = eval("("+json.responseText+")");

	var tabela;
	var color = "#e796a4";
	tabela  = "<table id=\"TabDbLov\" cellspacing=\"1\" cellpadding=\"2\" border=\"1\">";
	tabela +=	"<tr style=\"text-decoration: underline;\"><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Código";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Codigo tipo de comissão";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Descrição do ato de nomeação";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Numeração do Ato";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Data Ato";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Inicio Vigencia";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Final Vigencia";
	tabela += "</td></tr>";

	try {

		for (var i = 0; i < jsonObj.length; i++){
			if(i % 2 != 0){
					color = "#97b5e6";
			}else{
				color = "#e796a4";
			}
			tabela += "<tr>";

			tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].codTipoComissao+"','"+jsonObj[i].descricaoAtoNomeacao+"','"
			+jsonObj[i].nroAtoNomeacao+"','"+jsonObj[i].dataAtoNomeacao+"','"+jsonObj[i].inicioVigencia+"','"+jsonObj[i].finalVigencia+
			"')\">"+jsonObj[i].codigo+"</a>";

			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].codTipoComissao+"','"+jsonObj[i].descricaoAtoNomeacao+"','"
			+jsonObj[i].nroAtoNomeacao+"','"+jsonObj[i].dataAtoNomeacao+"','"+jsonObj[i].inicioVigencia+"','"+jsonObj[i].finalVigencia+
			"')\">"+(jsonObj[i].codTipoComissao == '01' ? 'Especial' : 'Permanente')+"</a>";

			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].codTipoComissao+"','"+jsonObj[i].descricaoAtoNomeacao+"','"
			+jsonObj[i].nroAtoNomeacao+"','"+jsonObj[i].dataAtoNomeacao+"','"+jsonObj[i].inicioVigencia+"','"+jsonObj[i].finalVigencia+
			"')\">"+(jsonObj[i].descricaoAtoNomeacao == '01' ? "Portaria" : "Decreto")+"</a>";

			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].codTipoComissao+"','"+jsonObj[i].descricaoAtoNomeacao+"','"
			+jsonObj[i].nroAtoNomeacao+"','"+jsonObj[i].dataAtoNomeacao+"','"+jsonObj[i].inicioVigencia+"','"+jsonObj[i].finalVigencia+
			"')\">"+jsonObj[i].nroAtoNomeacao+"</a>";

			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].codTipoComissao+"','"+jsonObj[i].descricaoAtoNomeacao+"','"
			+jsonObj[i].nroAtoNomeacao+"','"+jsonObj[i].dataAtoNomeacao+"','"+jsonObj[i].inicioVigencia+"','"+jsonObj[i].finalVigencia+
			"')\">"+jsonObj[i].dataAtoNomeacao+"</a>";

			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].codTipoComissao+"','"+jsonObj[i].descricaoAtoNomeacao+"','"
			+jsonObj[i].nroAtoNomeacao+"','"+jsonObj[i].dataAtoNomeacao+"','"+jsonObj[i].inicioVigencia+"','"+jsonObj[i].finalVigencia+
			"')\">"+jsonObj[i].inicioVigencia+"</a>";

			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].codTipoComissao+"','"+jsonObj[i].descricaoAtoNomeacao+"','"
			+jsonObj[i].nroAtoNomeacao+"','"+jsonObj[i].dataAtoNomeacao+"','"+jsonObj[i].inicioVigencia+"','"+jsonObj[i].finalVigencia+
			"')\">"+jsonObj[i].finalVigencia+"</a>";


			tabela += "</td></tr>";
		}

	} catch (e) {
	}
	tabela += "</table>";
	var conteudo = document.getElementById('lista');
	conteudo.innerHTML += tabela;
	conteudo.style.visibility = "visible";
}


function passar_valores(cod) {

	var oAjax = new Ajax.Request("con4_pesquisarxmllicitacao.php",
			{
		method:'post',
	  parameters:{codigo1: cod},
	  onComplete:function(data){
			var jsonObj = eval("("+data.responseText+")");
			var i = 0;
			pegar_valor(jsonObj[i].codigo,jsonObj[i].codTipoComissao,jsonObj[i].descricaoAtoNomeacao,
					jsonObj[i].nroAtoNomeacao,jsonObj[i].dataAtoNomeacao,jsonObj[i].inicioVigencia,jsonObj[i].finalVigencia);
			}
		  }
	  );

}
</script>

<?
if (isset($iUltimoCodigo)) {
	echo "<script>
		passar_valores(".$iUltimoCodigo.");
	</script>";
}

?>
