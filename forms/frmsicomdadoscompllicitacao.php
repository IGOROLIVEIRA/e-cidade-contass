<div id="lista" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Dados Compl. Licitações</span>
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
<td><strong>Código Processo: </strong></td>
<td> <input type="text" name="codigoP" id="codigoP" maxlength="13" onkeyup="js_ValidaCampos(this,1,'Codigo','f','f',event);" /></td>
</tr>
<tr>
<td><strong>Ano Processo:</strong></td>
<td>
 <input type="text" name="anoP" id="anoP" maxlength="14"  />
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
<table>
<tr>
<td>
<fieldset style="width: 660px; height: 450px;"><legend><b>Dados Compl. Licitações</b></legend>
  <table cellspacing="5px">
  
  <tr>
  <td><strong>Código</strong></td>
  <td> <input type="text" name="codigo" id="codigo" readonly="readonly" style="background-color: rgb(222, 184, 135);" ></td>
  </tr>
  
  <tr> 
  <td  nowrap title="<?=$Tl20_codigo?>">
  <b>
  <?db_ancora('Licitação:',"js_pesquisa_liclicita(true);",1);?>
  </b> 
  </td> 
  <td>
  <input name="nroProcessoLicitatorio" id="nroProcessoLicitatorio" onchange="js_pesquisa_liclicita(false);" 
  readonly="readonly" style="background-color: rgb(222, 184, 135);"  />
  </td>      
  </tr>
  
  <tr>
  <td><strong>Código Processo:</strong></td>
  <td> <input type="text" name="codigoProcesso" id="codigoProcesso" onkeyup="js_ValidaCampos(this,1,'Codigo','f','f',event);" ></td>
  
  <td><strong>Ano Processo:</strong></td>
  <td> <input type="text" name="ano" id="ano" onkeyup="js_ValidaCampos(this,1,'Ano','f','f',event);" size="5" maxlength="4"></td>
  
  </tr>
  
  <tr>
  <td>
  <strong>Data Recebimento Doc:</strong></td>
  <td><input type="text" name="dtRecebimentoDoc" id="dtRecebimentoDoc" onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)" 
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10">
  <input id="dtRecebimentoDoc_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dtRecebimentoDoc_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dtRecebimentoDoc_ano" type="hidden" maxlength="4" size="4" value="" title="" >
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
  <td><strong>Tipo de licitação:</strong></td>
  <td>
  <select name=tipoLicitacao id="tipoLicitacao">
  	<option value="1" id="01">Menor Preço</option>
  	<option value="2" id="02">Melhor Técnica</option>
  	<option value="3" id="03">Tecnica e Preço</option>
  	<option value="4" id="04">Maior Lance ou Oferta</option>
  </select>
  </td>
  </tr>
  <tr>
  <td><strong>Natureza do Objeto:</strong></td>
  <td>
  <select name=naturezaObjeto id="naturezaObjeto">
  	<option value="1" id="01">Obras e Serviços de Engenharia</option>
  	<option value="2" id="02">Compras e outros serviços</option>
  	<option value="3" id="03">Locação de Imóveis</option>
  	<option value="4" id="04">Concessão</option>
  	<option value="5" id="05">Permissão</option>
  	<option value="6" id="06">Alienação de bens</option>
  </select>
  </td>  
  </tr>
  
  <tr>
  <td><strong>Regime de Execução Obras:</strong></td>
  <td>
  <select name="regimeExecucaoObras" id="regimeExecucaoObras">
  	<option value="1" id="01">Empreitada por Preço Global</option>
  	<option value="2" id="02">Empreitada por Preço Unitário</option>
  	<option value="3" id="03">Empreitada Integral</option>
  	<option value="4" id="04">Tarefa</option>
  	<option value="5" id="05">Execução Direta</option>
  </select> 
  </tr>
  
  <tr>
  <td><strong>Número de convidados:</strong></td>
  <td>
  <input type="text" name="nroConvidado" id="nroConvidado" onkeyup="js_ValidaCampos(this,1,'Número de convidados','f','f',event);" >
  </td>
  </tr>
  
   <tr>
  <td><strong>Unidade Medida Prazo de Execução:</strong></td>
  <td>
  <select name=unidadeMedidaPrazoExecucao id="unidadeMedidaPrazoExecucao">
  	<option value="1" id="01">Dias</option>
  	<option value="2" id="02">Meses</option>
  </select>
  </td>
  
  <td><strong>Prazo Execução:</strong></td>
  <td> <input type="text" name="prazoExecucao" id="prazoExecucao" onkeyup="js_ValidaCampos(this,1,'Prazo Execução','f','f',event);" size="5" ></td>
  </tr>
  
  <tr>
  	<td><strong>Forma pagamento:<strong></td>
	<td colspan="2"><span id="left"></span>
	<textarea type="text" name="formaPagamento" id="formaPagamento" value="" cols="40" rows="7" 
	onKeyDown="textCounter(this.form1.descricaoArtigo,this.form.remLen,80)" onKeyUp="textCounter(this.form1.descricaoArtigo,this.form.remLen,80)">
	</textarea></td>
  </tr>
  
  <tr>
  <td><strong>Desconto Tabela:</strong></td>
  <td>
  <select name=descontoTabela id="descontoTabela">
  	<option value="1" id="01">Sim</option>
  	<option value="2" id="02">Não</option>
  </select>
  </td> 
  </tr>
  
  <tr>
  <td><strong>Registro em Ata presença de licitantes:</strong></td>
  <td>
  <select name="PresencaLicitantes" id="PresencaLicitantes">
  	<option value="1" id="01">Sim</option>
  	<option value="2" id="02">Não</option>
  </select> 
  </td> 
  </tr>
</table>
</fieldset>
</td>

<td>
<fieldset style="width: 574px; height: 450px;"><legend><b>Somente Dispensa/Inexigibilidade</b></legend>

<table cellspacing="5px">

 <tr>
  <td><strong>Tipo de processo:</strong></td>
  <td>
  <select name=tipoProcesso id="tipoProcesso">
  	<option value="1" id="01">Dispensa</option>
  	<option value="2" id="02">Inexigibilidade</option>
  	<option value="3" id="03">Inexigibilidade por credenciamento</option>
  </select>
  </td>
  </tr>
  <tr>
  <td><strong>Natureza do Objeto:</strong></td>
  <td>
  <select name=naturezaObjeto2 id="naturezaObjeto2">
  	<option value="1" id="01">Obras e Serviços de Engenharia</option>
  	<option value="2" id="02">Compras e outros serviços</option>
  	<option value="3" id="03">Locação de Imóveis</option>
  </select>
  </td>  
  </tr>
  
  <tr>
  	<td><strong>Justificativa:<strong></td>
	<td><span id="left"></span>
	<textarea type="text" name="justificativa" id="justificativa" value="" cols="45" rows="5" 
	onKeyDown="textCounter(this.form1.descricaoArtigo,this.form.remLen,250)" onKeyUp="textCounter(this.form1.descricaoArtigo,this.form.remLen,250)">
	</textarea></td>
  </tr>
  
  <tr>
  	<td><strong>Razão:<strong></td>
	<td><span id="left"></span>
	<textarea type="text" name="razao" id="razao" value="" cols="45" rows="5" 
	onKeyDown="textCounter(this.form1.descricaoArtigo,this.form.remLen,80)" onKeyUp="textCounter(this.form1.descricaoArtigo,this.form.remLen,250)">
	</textarea></td>
  </tr>
   <tr>
  	<td><strong>Nome do veículo de divulgação:<strong></td>
	<td><span id="left"></span>
	<textarea type="text" name="veiculoPublicacao" id="veiculoPublicacao" value="" cols="45" rows="2" 
	onKeyDown="textCounter(this.form1.descricaoArtigo,this.form.remLen,80)" onKeyUp="textCounter(this.form1.descricaoArtigo,this.form.remLen,50)">
	</textarea></td>
  </tr>

</table>
</fieldset>
</td>
</tr>

<tr>
	<td align="center" colspan="2">
	<input type="submit" value="Salvar" name="btnSalvar" />
	<input type="submit" value="Excluir" name="btnExcluir" />
	<input type="button" value="Pesquisar" name="btnPesquisar" onclick="pesquisar()" />
	<input type="reset" value="Novo" name="btnNovo" />
	</td>
</tr>

</table>
</form>

<script type="text/javascript">


/*
 * Pesquisar dados da licitação
 */
 function js_pesquisa_liclicita(mostra){
	 document.form1.codigo.value = '';
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

	var oAjax = new Ajax.Request("con4_pesquisarxmldadoscompllicitacao.php",
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

	var oAjax = new Ajax.Request("con4_pesquisarxmldadoscompllicitacao.php",
			{
		method:"post",
		parameters:{codigo1: $('codigoP').value, codigo2: $('anoP').value},
		onComplete:cria_tabela
		  }
	  );
	  
}

/**
 * 
 */
function pegar_valor(param1, param2, param3, param4, param5, param6, param7,
		param8, param9, param10, param11, param12, param13, param14, param15, 
		param16, param17, param18,param19){

	$('codigo').value = param1;
	$('nroProcessoLicitatorio').value = param2;
	$('codigoProcesso').value = param3;
	$('ano').value = param4;
	$('dtRecebimentoDoc').value = param5;
	document.getElementById('tipoLicitacao').options['0'+param6].selected = "true";
	document.getElementById('naturezaObjeto').options['0'+param7].selected = "true";
	document.getElementById('regimeExecucaoObras').options['0'+param8].selected = "true";
	$('nroConvidado').value = param9;
	document.getElementById('unidadeMedidaPrazoExecucao').options['0'+param10].selected = "true";
	$('prazoExecucao').value = param11;
	$('formaPagamento').value = param12;
	document.getElementById('descontoTabela').options['0'+param13].selected = "true";	
	document.getElementById('tipoProcesso').options['0'+param14].selected = "true";
	document.getElementById('naturezaObjeto2').options['0'+param15].selected = "true";			
	$('justificativa').value = param16;	
	$('razao').value = param17;		
	$('veiculoPublicacao').value = param18;	
	document.getElementById('PresencaLicitantes').options['0'+param19].selected = "true";																	
	
	var campo = document.getElementById('TabDbLov'); 
	document.getElementById('lista').removeChild(campo); 
	document.getElementById('lista').style.visibility = "hidden";
	
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
	tabela += "Licitação";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Código Processo";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Ano Processo";
	tabela += "</td></tr>";
	try{
		
		for (var i = 0; i < jsonObj.length; i++) {
			
			if(i % 2 != 0) {
					color = "#97b5e6";
			} else {
				color = "#e796a4";
			}
			tabela += "<tr>";
	
			tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].nroProcessoLicitatorio+
			"','"+jsonObj[i].codigoProcesso+"','"+jsonObj[i].ano+"','"+jsonObj[i].dtRecebimentoDoc+
			"','"+jsonObj[i].tipoLicitacao+"','"+jsonObj[i].naturezaObjeto+"','"+jsonObj[i].regimeExecucaoObras+"','"+jsonObj[i].nroConvidado+
			"','"+jsonObj[i].unidadeMedidaPrazoExecucao+"','"+jsonObj[i].prazoExecucao+"','"+jsonObj[i].formaPagamento+"','"+jsonObj[i].descontoTabela+
			"','"+jsonObj[i].tipoProcesso+"','"+jsonObj[i].naturezaObjeto2+"','"+jsonObj[i].justificativa+"','"+jsonObj[i].razao+
			"','"+jsonObj[i].veiculoPublicacao+"','"+jsonObj[i].PresencaLicitantes+"')\">"+jsonObj[i].nroProcessoLicitatorio+"</a>";
	
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].nroProcessoLicitatorio+
			"','"+jsonObj[i].codigoProcesso+"','"+jsonObj[i].ano+"','"+jsonObj[i].dtRecebimentoDoc+
			"','"+jsonObj[i].tipoLicitacao+"','"+jsonObj[i].naturezaObjeto+"','"+jsonObj[i].regimeExecucaoObras+"','"+jsonObj[i].nroConvidado+
			"','"+jsonObj[i].unidadeMedidaPrazoExecucao+"','"+jsonObj[i].prazoExecucao+"','"+jsonObj[i].formaPagamento+"','"+jsonObj[i].descontoTabela+
			"','"+jsonObj[i].tipoProcesso+"','"+jsonObj[i].naturezaObjeto2+"','"+jsonObj[i].justificativa+"','"+jsonObj[i].razao+
			"','"+jsonObj[i].veiculoPublicacao+"','"+jsonObj[i].PresencaLicitantes+"')\">"+jsonObj[i].codigoProcesso+"</a>";
	
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].nroProcessoLicitatorio+
			"','"+jsonObj[i].codigoProcesso+"','"+jsonObj[i].ano+"','"+jsonObj[i].dtRecebimentoDoc+
			"','"+jsonObj[i].tipoLicitacao+"','"+jsonObj[i].naturezaObjeto+"','"+jsonObj[i].regimeExecucaoObras+"','"+jsonObj[i].nroConvidado+
			"','"+jsonObj[i].unidadeMedidaPrazoExecucao+"','"+jsonObj[i].prazoExecucao+"','"+jsonObj[i].formaPagamento+"','"+jsonObj[i].descontoTabela+
			"','"+jsonObj[i].tipoProcesso+"','"+jsonObj[i].naturezaObjeto2+"','"+jsonObj[i].justificativa+"','"+jsonObj[i].razao+
			"','"+jsonObj[i].veiculoPublicacao+"','"+jsonObj[i].PresencaLicitantes+"')\">"+jsonObj[i].ano+"</a>";
			
			tabela += "</td></tr>";
			
		}

	}catch(e){
	}
	tabela += "</table>";
	var conteudo = document.getElementById('lista');
	conteudo.innerHTML += tabela;
	conteudo.style.visibility = "visible";
	
}
</script>