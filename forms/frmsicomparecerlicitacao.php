<div id="lista" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Parecer da Licitação </span>
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
<td> <input type="text" name="codigoPar" id="codigoPar" ></td>
</tr>
<tr>
<td><strong>Número do processo:</strong></td>
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
<fieldset style="width: 500px; height: 394px;"><legend><b>Parecer da Licitação</b></legend>
  <table cellspacing="5px">
  <tr>
  <td><strong>Código</strong></td>
  <td> <input type="text" name="codigo" id="codigo" readonly="readonly" style="background-color: rgb(222, 184, 135);" ></td>
  </tr>
  <tr>
  <td><strong>Exercício em que foi instaurado:</strong></td>
  <td><input type="text" name="exercicioLicitacao" id="exercicioLicitacao" maxlength="4" 
  onkeyup="js_ValidaCampos(this,1,'Exercício em que foi instaurado o procedimento','f','f',event);"></td>
  </tr>
  <tr>
  <td>
  <b>
  <?db_ancora('Licitação:',"js_pesquisa_liclicita(true);",1);?>
  </b> 
  </td>
  <td>
  <input type="text" name="nroProcessoLicitatorio" id="nroProcessoLicitatorio" onchange="js_pesquisa_liclicita(false);" 
  onkeyup="js_ValidaCampos(this,1,'Código Licitação','f','f',event);" style="background-color: rgb(222, 184, 135);">
  </td>
  </tr>
  <tr>
  <td><strong>Data do parecer:</strong></td>
  <td><input type="text" name="dataParecer" id="dataParecer" onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)" 
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10">
  <input id="dataParecer_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataParecer_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataParecer_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparaDatasodataParecer(dia,mes,ano){
      var objData = document.getElementById('dtInicio');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>
  
  </td>
  </tr>
  <tr>
  <td><strong>Tipo do parecer:</strong></td>
  <td>
  
  <select name="tipoParecer" id="tipoParecer">
   	<option value="01" id="01">Técnico</option>
  	<option value="02" id="02">Jurídico - Edital</option>
  	<option value="03" id="03">Jurídico - Julgamento</option>
  	<option value="04" id="04">Jurídico - Outros</option>
  </select>
  
  </td>
  </tr>
  <tr>
  <td><strong>Número do CPF:</strong></td>
  <td><input type="text" name="nroCpf" id="nroCpf" maxlength="11" 
  onkeyup="js_ValidaCampos(this,1,'Número do CPF','f','f',event);"></td>
  </tr>
  <tr>
  <td><strong>Nome do responsável pelo parecer:</strong></td>
  <td><input type="text" name="nomRespParecer" id="nomRespParecer" maxlength="50"></td>
  </tr>
  <tr>
  <td><strong>Logradouro:</strong></td>
  <td><input type="text" name="logradouro" id="logradouro" maxlength="75"></td>
  </tr>
  <tr>
  <td><strong>Bairro do logradouro:</strong></td>
  <td><input type="text" name="bairroLogra" id="bairroLogra" maxlength="50"></td>
  </tr>
  <tr>
  <td><strong>Código do município do logradouro:</strong></td>
  <td><input type="text" name="codCidadeLogra" id="codCidadeLogra" maxlength="5"></td>
  </tr>
  <tr>
  <td><strong>Unidade da Federação da Cidade:</strong></td>
  <td><input type="text" name="ufCidadeLogra" id="ufCidadeLogra" maxlength="2" size="2" style="text-transform: uppercase;"></td>
  </tr>
  <tr>
  <td><strong>CEP do logradouro do responsável:</strong></td>
  <td><input type="text" name="cepLogra" id="cepLogra" maxlength="8" 
  onkeyup="js_ValidaCampos(this,1,'CEP do logradouro do responsável','f','f',event);"></td>
  </tr>
  <tr>
  <td><strong>Telefone do responsável:</strong></td>
  <td><input type="text" name="telefone" id="telefone" maxlength="10" 
  onkeyup="js_ValidaCampos(this,1,'Telefone do responsável','f','f',event);"></td>
  </tr>
  <tr>
  <td><strong>E-mail do responsável:</strong></td>
  <td><input type="text" name="email" id="email" maxlength="50"></td>
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
* Pesquisar dados da licitação
*/
function js_pesquisa_liclicita(mostra){
         if(mostra==true){
           js_OpenJanelaIframe('','db_iframe_liclicita','func_liclicita.php?funcao_js=parent.js_mostraliclicita1|l20_codigo','Pesquisa',true);
         }else{
            if(document.form1.nroProcessoLicitatorio.value != ''){ 
               js_OpenJanelaIframe('','db_iframe_liclicita','func_liclicita.php?pesquisa_chave='+document.form1.nroProcessoLicitatorio.value+'&funcao_js=parent.js_mostraliclicita','Pesquisa',false);
            }else{
              document.form1.nroProcessoLicitatorio.value = ''; 
            }
         }
       }
       function js_mostraliclicita(chave,erro){
         document.form1.nroProcessoLicitatorio.value = chave; 
         if(erro==true){ 
           document.form1.nroProcessoLicitatorio.value = ''; 
           document.form1.nroProcessoLicitatorio.focus(); 
         }
       }
       function js_mostraliclicita1(chave1){
          document.form1.nroProcessoLicitatorio.value = chave1;  
          db_iframe_liclicita.hide();
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

	var oAjax = new Ajax.Request("con4_pesquisarxmlparecerlicitacao.php",
			{
		method: 'post',
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

	var oAjax = new Ajax.Request("con4_pesquisarxmlparecerlicitacao.php",
			{
		method: 'post',
		parameters:{codigo1: $('codigoPar').value, codigo2: $('nroProcesso').value},
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
	$('exercicioLicitacao').value = param2;
	$('nroProcessoLicitatorio').value = param3;
	$('dataParecer').value = param4;
	document.getElementById("tipoParecer").options[param5].selected = "true";
	$('nroCpf').value = param6;
	$('nomRespParecer').value = param7;
	$('logradouro').value = param8;
	$('bairroLogra').value = param9;
	$('codCidadeLogra').value = param10;
	$('ufCidadeLogra').value = param11;
	$('cepLogra').value = param12;
	$('telefone').value = param13;
	$('email').value = param14;
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
	tabela += "Exercício Licitação";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Número do processo";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Tipo do parecer";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Nome do responsável";
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
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].exercicioLicitacao+"','"
			+jsonObj[i].nroProcessoLicitatorio+"','"+jsonObj[i].dataParecer+"','"+jsonObj[i].tipoParecer+"','"+jsonObj[i].nroCpf+"','"
			+jsonObj[i].nomRespParecer+"','"+jsonObj[i].logradouro+"','"+jsonObj[i].bairroLogra+"','"+jsonObj[i].codCidadeLogra+"','"
			+jsonObj[i].ufCidadeLogra+"','"+jsonObj[i].cepLogra+"','"+jsonObj[i].telefone+"','"+jsonObj[i].email+"')\">"+jsonObj[i].codigo+"</a>";	
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].exercicioLicitacao+"','"
			+jsonObj[i].nroProcessoLicitatorio+"','"+jsonObj[i].dataParecer+"','"+jsonObj[i].tipoParecer+"','"+jsonObj[i].nroCpf+"','"
			+jsonObj[i].nomRespParecer+"','"+jsonObj[i].logradouro+"','"+jsonObj[i].bairroLogra+"','"+jsonObj[i].codCidadeLogra+"','"
			+jsonObj[i].ufCidadeLogra+"','"+jsonObj[i].cepLogra+"','"+jsonObj[i].telefone+"','"+jsonObj[i].email+"')\">"+jsonObj[i].exercicioLicitacao+"</a>";	
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].exercicioLicitacao+"','"
			+jsonObj[i].nroProcessoLicitatorio+"','"+jsonObj[i].dataParecer+"','"+jsonObj[i].tipoParecer+"','"+jsonObj[i].nroCpf+"','"
			+jsonObj[i].nomRespParecer+"','"+jsonObj[i].logradouro+"','"+jsonObj[i].bairroLogra+"','"+jsonObj[i].codCidadeLogra+"','"
			+jsonObj[i].ufCidadeLogra+"','"+jsonObj[i].cepLogra+"','"+jsonObj[i].telefone+"','"+jsonObj[i].email+"')\">"+jsonObj[i].nroProcessoLicitatorio+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].exercicioLicitacao+"','"
			+jsonObj[i].nroProcessoLicitatorio+"','"+jsonObj[i].dataParecer+"','"+jsonObj[i].tipoParecer+"','"+jsonObj[i].nroCpf+"','"
			+jsonObj[i].nomRespParecer+"','"+jsonObj[i].logradouro+"','"+jsonObj[i].bairroLogra+"','"+jsonObj[i].codCidadeLogra+"','"
			+jsonObj[i].ufCidadeLogra+"','"+jsonObj[i].cepLogra+"','"+jsonObj[i].telefone+"','"+jsonObj[i].email+"')\">"+(jsonObj[i].tipoParecer == '01' ? 
			"Técnico" : jsonObj[i].tipoParecer == '02' ? "Jurídico - Edital" : jsonObj[i].tipoParecer == '03' ? "Jurídico - Julgamento" : "Jurídico - Outros")+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].exercicioLicitacao+"','"
			+jsonObj[i].nroProcessoLicitatorio+"','"+jsonObj[i].dataParecer+"','"+jsonObj[i].tipoParecer+"','"+jsonObj[i].nroCpf+"','"
			+jsonObj[i].nomRespParecer+"','"+jsonObj[i].logradouro+"','"+jsonObj[i].bairroLogra+"','"+jsonObj[i].codCidadeLogra+"','"
			+jsonObj[i].ufCidadeLogra+"','"+jsonObj[i].cepLogra+"','"+jsonObj[i].telefone+"','"+jsonObj[i].email+"')\">"+jsonObj[i].nomRespParecer.substr(0,50)+"</a>";	
		
			tabela += "</td></tr>";
		}

	} catch (e) {
	}
	tabela += "</table>";
	var conteudo = document.getElementById('lista');
	conteudo.innerHTML += tabela;
  conteudo.style.visibility = "visible";
	
}
</script>