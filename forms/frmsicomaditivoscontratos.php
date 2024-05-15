<div id="lista" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Aditivo de Contrato</span>
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
<td> <input type="text" name="codigoA" id="codigoA" ></td>
</tr>
<tr>
<td><strong>Código do Aditivo:</strong></td>
<td>
 <input type="text" name="codAdi" id="codAdi" >
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
<fieldset style="width: 500px; height: 582px;"><legend><b>Aditivo de Contrato</b></legend>
  <table cellspacing="5px">
  <tr>
  <td><strong>Código</strong></td>
  <td> <input type="text" name="codigo" id="codigo" readonly="readonly" style="background-color: rgb(222, 184, 135);" ></td>
  </tr>
  <tr>
  <td><strong>Código do Aditivo</strong></td>
  <td> <input type="text" name="codAditivo" id="codAditivo" onkeyup="js_ValidaCampos(this,1,'Código do Aditivo','f','f',event);"></td>
  </tr>
  <tr>
  <td><strong>Número Contrato:</strong></td>
  <td> <input type="text" name="nroContrato" id="nroContrato" onkeyup="js_ValidaCampos(this,1,'Número Contrato','f','f',event);"></td>
  </tr>
  <tr>
  <td><strong>Ano Contrato:</strong></td>
  <td><input type="text" name=AnoContrato id="AnoContrato" maxlength="4" onkeyup="js_ValidaCampos(this,1,'Ano Contrato','f','f',event);"></td>
  </tr>
  <tr>
  <td><strong>Data Assinatura Contrato:</strong></td>
  <td><input type="text" name=dataAssinaturaContOriginal id="dataAssinaturaContOriginal" onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)"
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10">
  <input id="dataAssinaturaContOriginal_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataAssinaturaContOriginal_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataAssinaturaContOriginal_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparaDataAssinaturaContOriginal(dia,mes,ano){
      var objData = document.getElementById('dtInicio');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>

  </td>
  </tr>
  <tr>
  <td><strong>Tipo Termo Aditivo:</strong></td>
  <td>
  <select name="tipoTermoAditivo" id="tipoTermoAditivo" >
  	<option value="1" id="01" >Prorrogação de Prazo</option>
  	<option value="2" id="02" >Acréscimo de valor</option>
  	<option value="3" id="03" >Decréscimo de valor</option>
  	<option value="4" id="04" >Reajuste</option>
  	<option value="5" id="05" >Recomposição</option>
  	<option value="6" id="06" >Outros</option>
  </select>
  </td>
  </tr>
  <tr>
	<td><strong>Descrição Alteração:<strong></td>
	<td><span id="left"></span>
	<textarea type="text" name="dscAlteracao" id="dscAlteracao" value="" cols="30" rows="7"
	onKeyDown="textCounter(this.form1.descricaoArtigo,this.form.remLen,250)" onKeyUp="textCounter(this.form1.descricaoArtigo,this.form.remLen,250)">
	</textarea></td>
  </tr>
  <tr>
  <td><strong>Número do Aditivo:</strong></td>
  <td><input type="text" name="nroSeqTermoAditivo" id="nroSeqTermoAditivo" onkeyup="js_ValidaCampos(this,1,'Número do Aditivo','f','f',event);"></td>
  </tr>
  <tr>
  <td><strong>Data Assina. Aditivo:</strong></td>
  <td><input type="text" name="dataAssinaturaTermoAditivo" id="dataAssinaturaTermoAditivo" onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)"
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10">
  <input id="dataAssinaturaTermoAditivo_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataAssinaturaTermoAditivo_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataAssinaturaTermoAditivo_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparadataAssinaturaTermoAditivo(dia,mes,ano){
      var objData = document.getElementById('dtInicio');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>
  </td>
  </tr>
  <tr>
  <td><strong>Nova data Final:</strong></td>
  <td><input type="text" name="novaDataTermino" id="novaDataTermino" onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)"
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10">
  <input id="novaDataTermino_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="novaDataTermino_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="novaDataTermino_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparanovaDataTermino(dia,mes,ano){
      var objData = document.getElementById('dtInicio');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>
  </td>
  </tr>
  <tr>
  <td><strong>Valor Aditivado:</strong></td>
  <td><input type="text" name="valorAditivo" id="valorAditivo" onkeyup="js_ValidaCampos(this,4,'Valor Aditivado','f','f',event);"></td>
  </tr>
  <tr>
  <td><strong>Valor Atualizado Contrato:</strong></td>
  <td><input type="text" name="valorAtualizadoContrato" id="valorAtualizadoContrato" onkeyup="js_ValidaCampos(this,4,'Valor Atualizado Contrato','f','f',event);"></td>
  </tr>
  <tr>
  <td><strong>Data da Publicação do Termo Aditivo:</strong></td>
  <td><input type="text" name="dataPublicacao" id="dataPublicacao" onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)"
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10">
  <input id="dataPublicacao_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataPublicacao_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataPublicacao_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparadataPublicacao(dia,mes,ano){
      var objData = document.getElementById('dtInicio');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>
  </td>
  </tr>
  <tr>
  <td><strong>Veículo de divulgação:</strong></td>
  <td><input type="text" name="veiculoDivulgacao" id="veiculoDivulgacao" maxlength="50" ></td>
  </tr>
  <tr>
	<td align="right" colspan="2">
	<input type="submit" value="Salvar" name="btnSalvar" />
	<input type="submit" value="Excluir" name="btnExcluir" />
	<input type="button" value="Pesquisar" name="btnPesquisar" onclick="pesquisar()" />
	<input type="reset" value="Novo" name="btnNovo" onclick="limpar_codigo('','','')" />
	</td>
</tr>
</table>
</fieldset>
</form>

<script type="text/javascript">



function limpar_codigo(param1, param2, param3) {

	CurrentWindow.corpo.iframe_db_aditens.location.href='con4_sicomitensaditivados.php?codigoAd='+param1+'&nroContrato='+param2+'&anoContrato='+param3;
	if (param1 == '') {
	  parent.document.formaba.db_aditens.disabled=true;
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
function pesquisar() {

	var oAjax = new Ajax.Request("con4_pesquisarxmladitivoscontratos.php",
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

	var oAjax = Ajax.Request("con4_pesquisarxmladitivoscontratos.php",
			{
		method:"post",
		parameters:{codigo1: $("codigoA").value, codigo2: $("codAdi").value},
		onComplete:cria_tabela
		  }
	  );

}

/**
 *
 */
function pegar_valor(param1, param2, param3, param4, param5, param6, param7, param8, param9, param10,
		 param11, param12, param13, param14){

	$('codigo').value = param1;
	$('codAditivo').value = param2;
	$('nroContrato').value = param3;
	$('AnoContrato').value = param4;
	$('dataAssinaturaContOriginal').value = param5;
	document.getElementById("tipoTermoAditivo").options['0'+param6].selected = "true";
	$('dscAlteracao').value = param7;
	$('nroSeqTermoAditivo').value = param8;
	$('dataAssinaturaTermoAditivo').value = param9;
	$('novaDataTermino').value = param10;
	$('valorAditivo').value = param11;
	$('valorAtualizadoContrato').value = param12;
	$('dataPublicacao').value = param13;
	$('veiculoDivulgacao').value = param14;
	document.getElementById('lista').style.visibility = "hidden";

  if ($('codAditivo').value != "" && $('nroContrato').value != "") {

	  CurrentWindow.corpo.iframe_db_aditens.location.href='con4_sicomitensaditivados.php?codigoAd='+param2+'&nroContrato='+param3+'&anoContrato='+param4;
    parent.document.formaba.db_aditens.disabled=false;

  } else {

	  CurrentWindow.corpo.iframe_db_aditens.location.href='con4_sicomitensaditivados.php?codigoAd='+param2+'&nroContrato='+param3+'&anoContrato='+param4;
	  parent.document.formaba.db_aditens.disabled=true;

	}

    var campo = document.getElementById('TabDbLov');
	  document.getElementById('lista').removeChild(campo);
}

function fechar() {

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
	tabela += "Código do Aditivo";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Número Contrato";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Ano Contrato";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Data Assinatura Contrato";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Tipo Termo Aditivo";
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
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].codAditivo+"','"+jsonObj[i].nroContrato+"','"+jsonObj[i].AnoContrato+"','"
			+jsonObj[i].dataAssinaturaContOriginal+"','"+jsonObj[i].tipoTermoAditivo+"','"+jsonObj[i].dscAlteracao+"','"+jsonObj[i].nroSeqTermoAditivo+"','"
			+jsonObj[i].dataAssinaturaTermoAditivo+"','"+jsonObj[i].novaDataTermino+"','"+jsonObj[i].valorAditivo+"','"+jsonObj[i].valorAtualizadoContrato+"','"
			+jsonObj[i].dataPublicacao+"','"+jsonObj[i].veiculoDivulgacao+"')\">"+jsonObj[i].codigo+"</a>";

			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].codAditivo+"','"+jsonObj[i].nroContrato+"','"+jsonObj[i].AnoContrato+"','"
			+jsonObj[i].dataAssinaturaContOriginal+"','"+jsonObj[i].tipoTermoAditivo+"','"+jsonObj[i].dscAlteracao+"','"+jsonObj[i].nroSeqTermoAditivo+"','"
			+jsonObj[i].dataAssinaturaTermoAditivo+"','"+jsonObj[i].novaDataTermino+"','"+jsonObj[i].valorAditivo+"','"+jsonObj[i].valorAtualizadoContrato+"','"
			+jsonObj[i].dataPublicacao+"','"+jsonObj[i].veiculoDivulgacao+"')\">"+jsonObj[i].codAditivo+"</a>";

			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].codAditivo+"','"+jsonObj[i].nroContrato+"','"+jsonObj[i].AnoContrato+"','"
			+jsonObj[i].dataAssinaturaContOriginal+"','"+jsonObj[i].tipoTermoAditivo+"','"+jsonObj[i].dscAlteracao+"','"+jsonObj[i].nroSeqTermoAditivo+"','"
			+jsonObj[i].dataAssinaturaTermoAditivo+"','"+jsonObj[i].novaDataTermino+"','"+jsonObj[i].valorAditivo+"','"+jsonObj[i].valorAtualizadoContrato+"','"
			+jsonObj[i].dataPublicacao+"','"+jsonObj[i].veiculoDivulgacao+"')\">"+jsonObj[i].nroContrato+"</a>";

			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].codAditivo+"','"+jsonObj[i].nroContrato+"','"+jsonObj[i].AnoContrato+"','"
			+jsonObj[i].dataAssinaturaContOriginal+"','"+jsonObj[i].tipoTermoAditivo+"','"+jsonObj[i].dscAlteracao+"','"+jsonObj[i].nroSeqTermoAditivo+"','"
			+jsonObj[i].dataAssinaturaTermoAditivo+"','"+jsonObj[i].novaDataTermino+"','"+jsonObj[i].valorAditivo+"','"+jsonObj[i].valorAtualizadoContrato+"','"
			+jsonObj[i].dataPublicacao+"','"+jsonObj[i].veiculoDivulgacao+"')\">"+jsonObj[i].AnoContrato+"</a>";

			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].codAditivo+"','"+jsonObj[i].nroContrato+"','"+jsonObj[i].AnoContrato+"','"
			+jsonObj[i].dataAssinaturaContOriginal+"','"+jsonObj[i].tipoTermoAditivo+"','"+jsonObj[i].dscAlteracao+"','"+jsonObj[i].nroSeqTermoAditivo+"','"
			+jsonObj[i].dataAssinaturaTermoAditivo+"','"+jsonObj[i].novaDataTermino+"','"+jsonObj[i].valorAditivo+"','"+jsonObj[i].valorAtualizadoContrato+"','"
			+jsonObj[i].dataPublicacao+"','"+jsonObj[i].veiculoDivulgacao+"')\">"+jsonObj[i].dataAssinaturaContOriginal+"</a>";

			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].codAditivo+"','"+jsonObj[i].nroContrato+"','"+jsonObj[i].AnoContrato+"','"
			+jsonObj[i].dataAssinaturaContOriginal+"','"+jsonObj[i].tipoTermoAditivo+"','"+jsonObj[i].dscAlteracao+"','"+jsonObj[i].nroSeqTermoAditivo+"','"
			+jsonObj[i].dataAssinaturaTermoAditivo+"','"+jsonObj[i].novaDataTermino+"','"+jsonObj[i].valorAditivo+"','"+jsonObj[i].valorAtualizadoContrato+"','"
			+jsonObj[i].dataPublicacao+"','"+jsonObj[i].veiculoDivulgacao+"')\">"+(jsonObj[i].tipoTermoAditivo == 1 ? "Prorrogação de Prazo" :
		  jsonObj[i].tipoTermoAditivo == 2 ? "Acréscimo de valor" : jsonObj[i].tipoTermoAditivo == 3 ? "Decréscimo de valor" :
			jsonObj[i].tipoTermoAditivo == 4 ? "Reajuste" : jsonObj[i].tipoTermoAditivo == 5 ? "Recomposição" : "Outros")+"</a>";

			tabela += "</td></tr>";

		}

	}catch (e) {
	}
	tabela += "</table>";
	var conteudo = document.getElementById('lista');
	conteudo.innerHTML += tabela;
	conteudo.style.visibility = "visible";

}

function passar_valores(cod) {

	var oAjax = new Ajax.Request("con4_pesquisarxmladitivoscontratos.php",
			{
		method:"post",
		parameters:{codigo1: cod},
		onComplete: function(json) {
			var jsonObj = eval("("+json.responseText+")");
		  var i = 0;
		  pegar_valor(jsonObj[i].codigo,jsonObj[i].codAditivo,jsonObj[i].nroContrato,jsonObj[i].AnoContrato,
				jsonObj[i].dataAssinaturaContOriginal,jsonObj[i].tipoTermoAditivo,jsonObj[i].dscAlteracao,jsonObj[i].nroSeqTermoAditivo,
				jsonObj[i].dataAssinaturaTermoAditivo,jsonObj[i].novaDataTermino,jsonObj[i].valorAditivo,jsonObj[i].valorAtualizadoContrato,
				jsonObj[i].dataPublicacao,jsonObj[i].veiculoDivulgacao);
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
