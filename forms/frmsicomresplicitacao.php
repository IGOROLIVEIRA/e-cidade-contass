<div id="lista" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Responsáveis pela Licitação</span>
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
<td> <input type="text" name="codigoResp" id="codigoResp" ></td>
</tr>
<tr>
<td><strong>Código número do Decreto Municipal:</strong></td>
<td>
 <input type="text" name="nroProcesso" id="nroProcesso" >
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
<fieldset style="width: 500px; height: 582px;"><legend><b>Responsáveis pela Licitação</b></legend>
  <table cellspacing="5px">
  <tr>
  <td><strong>Código</strong></td>
  <td> <input type="text" name="codigo" id="codigo" readonly="readonly" style="background-color: rgb(222, 184, 135);" ></td>
  </tr>
  <tr>
  <td><strong>Codigo do Tipo de Comissao:</strong></td>
  <td>
  <select name=codTipoComissao id="codTipoComissao" >
  	<option value="01" id="01">Especial</option>
  	<option value="02" id="02">Permanente</option>
  </select>
  </td>
  </tr>
  <tr>
  <td><strong>Descrição do ato de nomeação:</strong></td>
  <td>
  <select name=descricaoAtoNomeacao id="descricaoAtoNomeacao">
  	<option value="01" id="11">Portaria</option>
  	<option value="02" id="12">Decreto</option>
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
  <td><strong>CPF Membro Comissão:</strong></td>
  <td><input type="text" name=cpfMembroComissao id="cpfMembroComissao" maxlength="11" 
  onkeyup="js_ValidaCampos(this,1,'CPF Membro Comissão','f','f',event);" ></td>
  </tr>
  <tr>
  <td><strong>Nome do membro da Comissão de Licitação:</strong></td>
  <td><input type="text" name=nomMembroComLic id="nomMembroComLic" maxlength="50"></td>
  </tr>
  <tr>
  <td><strong>Código da atribuição do responsável pela licitação:</strong></td>
  <td>
  <select name=codAtribuicao id="codAtribuicao" >
  	<option value="01" id="21">Leiloeiro</option>
  	<option value="02" id="22">Membro / Equipe de Apoio</option>
  	<option value="03" id="23">Presidente</option>
  	<option value="04" id="24">Secretário</option>
  	<option value="05" id="25">Servidor Designado</option>
  	<option value="06" id="26">Pregoeiro</option>
  </select>
  </td>
  </tr>
  <tr>
  <td><strong>Descrição do cargo:</strong></td>
  <td><input type="text" name=cargo id="cargo" maxlength="50"></td>
  </tr>
  <tr>
  <td><strong>Natureza do Cargo:</strong></td>
  <td>
  <select name=naturezaCargo id="naturezaCargo" >
  	<option value="01" id="31">Servidor Efetivo</option>
  	<option value="02" id="32">Empregado Temporário</option>
  	<option value="03" id="33">Cargo em Comissão</option>
  	<option value="04" id="34">Empregado Público</option>
  	<option value="05" id="35">Agente Político</option>
  	<option value="06" id="36">Outra</option>
  </select>
  </td>
  <tr>
  <td><strong>Logradouro Residencial:</strong></td>
  <td><input type="text" name=logradouro id="logradouro" maxlength="75"></td>
  </tr>
  <tr>
  <td><strong>Bairro do logradouro:</strong></td>
  <td><input type="text" name=bairroLogra id="bairroLogra" maxlength="50"></td>
  </tr>
  <tr>
  <td><strong>Código do município do logradouro:</strong></td>
  <td><input type="text" name=codCidadeLogra id="codCidadeLogra" maxlength="5"></td>
  </tr>
  <tr>
  <td><strong>Unidade da Federação da Cidade:</strong></td>
  <td><input type="text" name=ufCidadeLogra id="ufCidadeLogra" maxlength="2"></td>
  </tr>
  <tr>
  <td><strong>CEP do logradouro:</strong></td>
  <td><input type="text" name=cepLogra id="cepLogra" maxlength="8" 
  onkeyup="js_ValidaCampos(this,1,'CEP do logradouro','f','f',event);"></td>
  </tr>
  <tr>
  <td><strong>Número do telefone:</strong></td>
  <td><input type="text" name=telefone id="telefone" maxlength="10" 
  onkeyup="js_ValidaCampos(this,1,'Número do telefone','f','f',event);"></td>
  </tr>
  <tr>
  <td><strong>Endereço eletrônico (e-mail) do Membro:</strong></td>
  <td><input type="text" name=email id="email" maxlength="50"></td>
  </tr>
  <tr>
	<td align="right" colspan="2">
	<input type="submit" value="Salvar" name="btnSalvar" />
	<input type="submit" value="Excluir" name="btnExcluir" />
	<input type="button" value="Pesquisar" name="btnPesquisar" onclick="pesquisar()" />
	<input type="reset" value="Novo" name="btnNovo">
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
function pesquisar(){
	
	$.post('con4_pesquisarxmlresplicitacao.php', function(data){
		
		var jsonObj = eval(data);
		cria_tabela(jsonObj);
		$('#lista').css("visibility", "visible");
	}
	);
}

/**
 * pesquisar dados no xml pelo codigo digitado
 */
function pesquisar_codigo(){

	var campo = document.getElementById('TabDbLov');
	document.getElementById('lista').removeChild(campo);
	
	var cod1 = $('#codigoResp').val();
	var cod2 = $('#nroProcesso').val();
	
	$.post('con4_pesquisarxmlresplicitacao.php', {codigo1: cod1, codigo2: cod2}, function(data){
		var jsonObj = eval(data);
		cria_tabela(jsonObj);
		$('#lista').css("visibility", "visible");
		} 
	);
}

/**
 * 
 */
function pegar_valor(param1, param2, param3, param4, param5, param6, param7, param8, param9, param10,
		 param11, param12, param13, param14, param15, param16, param17, param18, param19){
	 
	$('#codigo').val(param1);
	$('#0'+param2+'').attr("selected","selected");
	$('#1'+param3+'').attr("selected","selected");
	$('#nroAtoNomeacao').val(param4);
	$('#dataAtoNomeacao').val(param5);
	$('#inicioVigencia').val(param6);
	$('#finalVigencia').val(param7);
	$('#cpfMembroComissao').val(param8);
	$('#nomMembroComLic').val(param9);
	$('#2'+param10+'').attr("selected","selected");
	$('#cargo').val(param11);
	$('#3'+param12+'').attr("selected","selected");
	$('#logradouro').val(param13);
	$('#bairroLogra').val(param14);
	$('#codCidadeLogra').val(param15);
	$('#ufCidadeLogra').val(param16);
	$('#cepLogra').val(param17);
	$('#telefone').val(param18);
	$('#email').val(param19);
	$('#lista').css("visibility", "hidden");
	var campo = document.getElementById('TabDbLov'); 
	document.getElementById('lista').removeChild(campo); 
}

function fechar(){
	var campo = document.getElementById('TabDbLov'); 
	document.getElementById('lista').removeChild(campo); 
	$('#lista').css("visibility","hidden");
}

function cria_tabela(jsonObj){
	var tabela;
	var color = "#e796a4";
	tabela  = "<table id=\"TabDbLov\" cellspacing=\"1\" cellpadding=\"2\" border=\"1\">";
	tabela +=	"<tr style=\"text-decoration: underline;\"><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Código";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "inicioVigencia";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "finalVigencia";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "nomMembroComLic";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "codAtribuicao";
	tabela += "</td></tr>";
	for (var i in jsonObj){
		if(i % 2 != 0){
				color = "#97b5e6";
		}else{
			color = "#e796a4";
		}
		tabela += "<tr>";

		tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
		tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+","+jsonObj[i].codTipoComissao+","+jsonObj[i].descricaoAtoNomeacao+","
		+jsonObj[i].nroAtoNomeacao+",'"+jsonObj[i].dataAtoNomeacao+"','"+jsonObj[i].inicioVigencia+"','"+jsonObj[i].finalVigencia+"',"
		+jsonObj[i].cpfMembroComissao+",'"+jsonObj[i].nomMembroComLic+"',"+jsonObj[i].codAtribuicao+",'"+jsonObj[i].cargo+"',"
		+jsonObj[i].naturezaCargo+",'"+jsonObj[i].logradouro+"','"+jsonObj[i].bairroLogra+"','"+jsonObj[i].codCidadeLogra+"','"
		+jsonObj[i].ufCidadeLogra+"',"+jsonObj[i].cepLogra+","+jsonObj[i].telefone+",'"+jsonObj[i].email+"')\">"+jsonObj[i].codigo+"</a>";

		tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
		tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+","+jsonObj[i].codTipoComissao+","+jsonObj[i].descricaoAtoNomeacao+","
		+jsonObj[i].nroAtoNomeacao+",'"+jsonObj[i].dataAtoNomeacao+"','"+jsonObj[i].inicioVigencia+"','"+jsonObj[i].finalVigencia+"',"
		+jsonObj[i].cpfMembroComissao+",'"+jsonObj[i].nomMembroComLic+"',"+jsonObj[i].codAtribuicao+",'"+jsonObj[i].cargo+"',"
		+jsonObj[i].naturezaCargo+",'"+jsonObj[i].logradouro+"','"+jsonObj[i].bairroLogra+"','"+jsonObj[i].codCidadeLogra+"','"
		+jsonObj[i].ufCidadeLogra+"',"+jsonObj[i].cepLogra+","+jsonObj[i].telefone+",'"+jsonObj[i].email+"')\">"+jsonObj[i].inicioVigencia+"</a>";

		tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
		tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+","+jsonObj[i].codTipoComissao+","+jsonObj[i].descricaoAtoNomeacao+","
		+jsonObj[i].nroAtoNomeacao+",'"+jsonObj[i].dataAtoNomeacao+"','"+jsonObj[i].inicioVigencia+"','"+jsonObj[i].finalVigencia+"',"
		+jsonObj[i].cpfMembroComissao+",'"+jsonObj[i].nomMembroComLic+"',"+jsonObj[i].codAtribuicao+",'"+jsonObj[i].cargo+"',"
		+jsonObj[i].naturezaCargo+",'"+jsonObj[i].logradouro+"','"+jsonObj[i].bairroLogra+"','"+jsonObj[i].codCidadeLogra+"','"
		+jsonObj[i].ufCidadeLogra+"',"+jsonObj[i].cepLogra+","+jsonObj[i].telefone+",'"+jsonObj[i].email+"')\">"+jsonObj[i].finalVigencia+"</a>";

		tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
		tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+","+jsonObj[i].codTipoComissao+","+jsonObj[i].descricaoAtoNomeacao+","
		+jsonObj[i].nroAtoNomeacao+",'"+jsonObj[i].dataAtoNomeacao+"','"+jsonObj[i].inicioVigencia+"','"+jsonObj[i].finalVigencia+"',"
		+jsonObj[i].cpfMembroComissao+",'"+jsonObj[i].nomMembroComLic+"',"+jsonObj[i].codAtribuicao+",'"+jsonObj[i].cargo+"',"
		+jsonObj[i].naturezaCargo+",'"+jsonObj[i].logradouro+"','"+jsonObj[i].bairroLogra+"','"+jsonObj[i].codCidadeLogra+"','"
		+jsonObj[i].ufCidadeLogra+"',"+jsonObj[i].cepLogra+","+jsonObj[i].telefone+",'"+jsonObj[i].email+"')\">"+jsonObj[i].nomMembroComLic+"</a>";

		tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
		tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+","+jsonObj[i].codTipoComissao+","+jsonObj[i].descricaoAtoNomeacao+","
		+jsonObj[i].nroAtoNomeacao+",'"+jsonObj[i].dataAtoNomeacao+"','"+jsonObj[i].inicioVigencia+"','"+jsonObj[i].finalVigencia+"',"
		+jsonObj[i].cpfMembroComissao+",'"+jsonObj[i].nomMembroComLic+"',"+jsonObj[i].codAtribuicao+",'"+jsonObj[i].cargo+"',"
		+jsonObj[i].naturezaCargo+",'"+jsonObj[i].logradouro+"','"+jsonObj[i].bairroLogra+"','"+jsonObj[i].codCidadeLogra+"','"
		+jsonObj[i].ufCidadeLogra+"',"+jsonObj[i].cepLogra+","+jsonObj[i].telefone+",'"+jsonObj[i].email+"')\">"+jsonObj[i].codAtribuicao+"</a>";
	
		tabela += "</td></tr>";
	}
	tabela += "</table>";
	var conteudo = document.getElementById('lista');
	conteudo.innerHTML += tabela;
}
</script>