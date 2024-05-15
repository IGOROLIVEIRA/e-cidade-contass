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
</tr>
<tr>
<td></td>
<td><input type="button" name="bntPesquisarXml" value="Pesquisar" onclick="pesquisar_codigo()"></td>
</tr>
</table>
</div><!-- campos -->
</div><!-- lista -->

<form name="form1" method="post" action="">
<fieldset style="width: 540px; height: 230px;"><legend><b>Responsáveis</b></legend>
  <table cellspacing="5px">
  <tr>
  <td><strong>Código da Licitação</strong></td>
  <td> <input type="text" name="codigoLic" id="codigoLic" readonly="readonly" style="background-color: rgb(222, 184, 135);" 
  value="<?php echo $_GET['codigo']; ?>">
  </td>
  </tr>
  <tr>
  <td><strong>Código do Responsável</strong></td>
  <td><input type="text" name="codigo" id="codigo" readonly="readonly" style="background-color: rgb(222, 184, 135);">
  </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Te54_numcgm?>">
    <?
       db_ancora("<b>NumCgm</b>","js_pesquisae54_numcgm(true);",1);
     ?>        
    </td>
    <td>
	<input type="text" name="numCgm" id="numCgm" maxlength="13"  size="10" onkeyup="js_ValidaCampos(this,1,'numCgm','f','f',event);"
	 onchange="js_pesquisae54_numcgm(false);" onblur="js_pesquisae54_numcgm(false);"/>
	<br>
	<input type="text" name="nomeResponsavel" id="nomeResponsavel" style="background-color: rgb(222, 184, 135);" readonly="readonly" />
	</td>
  </tr>
  <tr>
  <td><strong>Código da atribuição do responsável pela licitação:</strong></td>
  <td>
  <select name="codAtribuicao" id="codAtribuicao" >
  	<option value="01" id="01">Leiloeiro</option>
  	<option value="02" id="02">Membro / Equipe de Apoio</option>
  	<option value="03" id="03">Presidente</option>
  	<option value="04" id="04">Secretário</option>
  	<option value="05" id="05">Servidor Designado</option>
  	<option value="06" id="06">Pregoeiro</option>
  </select>
  </td>
  </tr>
  <tr>
  <td><strong>Descrição do cargo:</strong></td>
  <td><input type="text" name="cargo" id="cargo" maxlength="50"></td>
  </tr>
  <tr>
  <td><strong>Natureza do Cargo:</strong></td>
  <td>
  <select name="naturezaCargo" id="naturezaCargo">
  	<option value="01" id="01">Servidor Efetivo</option>
  	<option value="02" id="02">Empregado Temporário</option>
  	<option value="03" id="03">Cargo em Comissão</option>
  	<option value="04" id="04">Empregado Público</option>
  	<option value="05" id="05">Agente Político</option>
  	<option value="06" id="06">Outra</option>
  </select>
  </td>
  </tr>
  <tr>
	<td align="right" colspan="2">
	<input type="submit" value="Salvar" name="btnSalvar" />
	<input type="submit" value="Excluir" name="btnExcluir" />
	<input type="button" value="Pesquisar" name="btnPesquisar" onclick="pesquisar()" />
	<input type="submit" value="Novo" name="btnNovo" />
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





function js_pesquisae54_numcgm(mostra){
	  if(mostra==true){
	    js_OpenJanelaIframe('','db_iframe_cgm','func_nome.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome','Pesquisa',true,'0','1');
	  }else{
	     if(document.form1.numCgm.value != ''){ 
	        js_OpenJanelaIframe('','db_iframe_cgm','func_nome.php?pesquisa_chave='+document.form1.numCgm.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false);
	     }else{
	       document.form1.nomeResponsavel.value = ''; 
	     }
	  }
	}

function js_mostracgm(erro,chave){
	
	  document.form1.nomeResponsavel.value = chave; 
	  if(erro==true){ 
	    document.form1.numCgm.focus(); 
	    document.form1.numCgm.value = ''; 
	  } else {
	    js_debitosemaberto();
	  }
	}

	function js_mostracgm1(chave1,chave2){

	  document.form1.numCgm.value          = chave1;
	  document.form1.nomeResponsavel.value = chave2;
	  db_iframe_cgm.hide();
	  
	  js_debitosemaberto();
	}

 /**
  * buscar dados do xml para criar a tabela
  */
 function pesquisar(){

 	var oAjax = new Ajax.Request("con4_pesquisarxmlresponsavel.php",
 			  {
			method:'post',
			parameters:{codigo_licitacao: $('codigoLic').value},
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

	var oAjax = new Ajax.Request("con4_pesquisarxmlresponsavel.php",
			{
		method:'post',
		parameters:{codigo1: $('codigoResp').value},
		onComplete:cria_tabela
		  }
	);
	
}

/**
 * 
 */
function pegar_valor(param1, param2, param3, param4, param5, param6){
	
	$('codigoLic').value = param1;
	$('codigo').value = param2;
	$('numCgm').value = param3;
	document.getElementById("codAtribuicao").options[param4].selected = "true";
	$('cargo').value = param5;
	document.getElementById("naturezaCargo").options[param6].selected = "true";
	document.getElementById('lista').style.visibility = "hidden";
	var campo = document.getElementById('TabDbLov');
	document.getElementById('lista').removeChild(campo); 

	js_pesquisae54_numcgm(false);
	
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
	tabela += "Código da licitação";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Código do responsável";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Nome";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Atribuição";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Desc Cargo";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Natureza";
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
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigoLic+"','"+jsonObj[i].codigo+"','"+jsonObj[i].numCgm+"','"+jsonObj[i].codAtribuicao+"','"
			+jsonObj[i].cargo+"','"+jsonObj[i].naturezaCargo+"')\">"+jsonObj[i].codigoLic+"</a>";
			
			tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigoLic+"','"+jsonObj[i].codigo+"','"+jsonObj[i].numCgm+"','"+jsonObj[i].codAtribuicao+"','"
			+jsonObj[i].cargo+"','"+jsonObj[i].naturezaCargo+"')\">"+jsonObj[i].codigo+"</a>";
	
			tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigoLic+"','"+jsonObj[i].codigo+"','"+jsonObj[i].numCgm+"','"+jsonObj[i].codAtribuicao+"','"
			+jsonObj[i].cargo+"','"+jsonObj[i].naturezaCargo+"')\">"+jsonObj[i].nomeResponsavel+"</a>";
	
			tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigoLic+"','"+jsonObj[i].codigo+"','"+jsonObj[i].numCgm+"','"+jsonObj[i].codAtribuicao+"','"
			+jsonObj[i].cargo+"','"+jsonObj[i].naturezaCargo+"')\">"+(jsonObj[i].codAtribuicao == '01' ? "Leiloeiro" : jsonObj[i].codAtribuicao == '02' ?
			"Membro / Equipe de Apoio" : jsonObj[i].codAtribuicao == '03' ? "Presidente" : jsonObj[i].codAtribuicao == '04' ? "Secretário" : 
		  jsonObj[i].codAtribuicao == '05' ? "Servidor Designado" : "Pregoeiro")+"</a>";
	
			tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigoLic+"','"+jsonObj[i].codigo+"','"+jsonObj[i].numCgm+"','"+jsonObj[i].codAtribuicao+"','"
			+jsonObj[i].cargo+"','"+jsonObj[i].naturezaCargo+"')\">"+jsonObj[i].cargo+"</a>";
	
			tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigoLic+"','"+jsonObj[i].codigo+"','"+jsonObj[i].numCgm+"','"+jsonObj[i].codAtribuicao+"','"
			+jsonObj[i].cargo+"','"+jsonObj[i].naturezaCargo+"')\">"+(jsonObj[i].naturezaCargo == '01' ? "Servidor Efetivo" : 
			jsonObj[i].naturezaCargo == '02' ? "Empregado Temporário" : jsonObj[i].naturezaCargo == '03' ? "Cargo em Comissão" : 
			jsonObj[i].naturezaCargo == '04' ? "Empregado Público" : jsonObj[i].naturezaCargo == '05' ? "Agente Político" : "Outra")+"</a>";
	
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