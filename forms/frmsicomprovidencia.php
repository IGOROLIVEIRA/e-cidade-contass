<div id="lista" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Providências</span>
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
<td><strong>Código Providencia:</strong></td> 
<td><input type="text" name="codigoProvidencia" id="codigoProvidencia"></td>
</tr>
<tr>
<td><strong>Código Risco:</strong></td>
<td> <input type="text" name="codigoRisco" id="codigoRisco"> </td>
</tr>
<td></td>
<td><input type="button" name="bntPesquisarXml" value="Pesquisar" onclick="pesquisar_codigo()"></td>
</table>
</div><!-- campos -->
</div><!-- lista -->

<div id="lista_riscos" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Riscos Fiscais</span>
<div id="fechar_riscos" onclick="fechar_risco()" style="background:url('imagens/jan_fechar_on.gif'); height: 20px;
    float: right;  width: 20px;"></div>
<div id="fechar_riscos" style="background:url('imagens/jan_max_off.gif'); height: 20px;
    float: right;  width: 20px;"></div>
<div id="fechar_riscos" onclick="fechar_riscos()" style="background:url('imagens/jan_mini_on.gif'); height: 20px;
    float: right;  width: 20px;"></div>
        
</div><!-- topo -->

<div id="campos_riscos" style="margin-bottom: 7px;">
<table>
<tr>
<td><strong>Código Risco:</strong></td>
 <td><input type="text" name="codigoRiscoFiscal" id="codigoRiscoFiscal"></td>
 </tr>
 <tr>
<td><strong>Código Perspectiva:</strong></td>
<td> <input type="text" name="codigoPerspectiva" id="codigoPerspectiva"></td>
</tr>
<tr>
<td></td>
<td><input type="button" name="bntPesquisarXml" value="Pesquisar" onclick="pesquisar_codigo_risco()"></td>
</tr>
</table>
</div><!-- campos_riscos -->
</div><!-- lista_riscos -->

<form name="form1" method="post" action="">
<fieldset style="width: 500px; height: 220px;">
<input type="hidden" name="instituicao" value="" />
<table cellspacing="5px" style="font-weight: bold;">
<tr>
	<td>Código do Risco:</td>
	<td><input type="text" name="codRisco" id="codRisco" value="" style="background-color: rgb(222, 184, 135);" readonly="readonly"/>
	<input type="button" name="bntPesquisarRisco" value="Pesquisar" onclick="pesquisar_risco()"></td>
</tr>
<tr>
<tr>
	<td>Código da Providencia:</td>
	<td>
	<input type="text" name="codProvidencia" id="codProvidencia" value="" style="background-color: rgb(222, 184, 135);" readonly="readonly"/>
	</td>
</tr>
<tr>
	<td>Descrição:</td>
	<td><textarea type="text" name="dscProvidencia" id="dscProvidencia" value="" cols="40" rows="7" 
	onKeyDown="textCounter(this.form.dscProvidencia,this.form.remLen,300)" onKeyUp="textCounter(this.form.dscProvidencia,this.form.remLen,300)">
	</textarea></td>
</tr>
<tr>
	<td>Valor:</td>
	<td><input type="text" name="vlAssociadoProvidencia" id="vlAssociadoProvidencia" value="" /></td>
</tr>
<tr>
	<td></td>
	<td align="right"><input type="submit" value="Salvar" name="btnSalvar" />
	<input type="submit" value="Excluir" name="btnExcluir" />
	<input type="button" value="Pesquisar" name="btnPesquisar" onclick="pesquisar()" />
	<input type="reset" value="Novo" name="btnNovo" />
	</td>
</tr>
</table>
</fieldset>
</form>

<script type="text/javascript">
function textCounter(field, countfield, maxlimit) {
	
	if (field.value.length > maxlimit){
		field.value = field.value.substring(0, maxlimit);
	}else{ 
		countfield.value = maxlimit - field.value.length;
	}
	}


function pesquisar(){
	
	var oAjax = new Ajax.Request("con4_pesquisar_xml_providencias.php",
			         {
		            method:'post',
		            onComplete:cria_tabela
	             }
	);
}

function pesquisar_codigo(){

	var campo = document.getElementById('TabDbLov');
	document.getElementById('lista').removeChild(campo);
	
	var oAjax = new Ajax.Request('con4_pesquisar_xml_providencias.php', 
			       {
               method:'post',
		           parameters:{codigoProvidencia: $('codigoProvidencia').value, codigoRisco: $('codigoRisco').value},
		           onComplete:cria_tabela
			       }
    );
    
}

function pegar_valor(risco, providencia, descricao, valor){
	
	$('codRisco').value = risco;
	$('codProvidencia').value = providencia;
	$('dscProvidencia').value = descricao;
	$('vlAssociadoProvidencia').value = valor;

	fechar();
	
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
	tabela += "Código Risco";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Código Providência";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Descrição";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Valor Associado";
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
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codRisco+","+jsonObj[i].codProvidencia+",'"+jsonObj[i].dscProvidencia;
			tabela += "','"+jsonObj[i].vlAssociadoProvidencia+"')\">"+jsonObj[i].codRisco+"</a>";
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codRisco+","+jsonObj[i].codProvidencia+",'"+jsonObj[i].dscProvidencia;
			tabela += "','"+jsonObj[i].vlAssociadoProvidencia+"')\">"+jsonObj[i].codProvidencia+"</a>";
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codRisco+","+jsonObj[i].codProvidencia+",'"+jsonObj[i].dscProvidencia;
			tabela += "','"+jsonObj[i].vlAssociadoProvidencia+"')\">"+jsonObj[i].dscProvidencia.substr(0,50)+"</a>";
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codRisco+","+jsonObj[i].codProvidencia+",'"+jsonObj[i].dscProvidencia;
			tabela += "','"+jsonObj[i].vlAssociadoProvidencia+"')\">"+jsonObj[i].vlAssociadoProvidencia+"</a>";
			tabela += "</td></tr>";
			
		}

	} catch (e) {
	}
	tabela += "</table>";
	var conteudo = document.getElementById('lista');
	conteudo.innerHTML += tabela;
	conteudo.style.visibility = "visible";
	
}

/*
 *funções para os riscos 
 */
 function fechar_risco(){
	 
		var campo = document.getElementById('TabDbLov'); 
		document.getElementById('lista_riscos').removeChild(campo); 
		document.getByElementId('lista_riscos').style.visibility = "hidden";
		
	}
 
function pesquisar_risco(){
	
	var oAjax = new Ajax.Request('con4_pesquisar_xml_riscos.php',
			        {
        			 method:'post',
						   onComplete:cria_tabela_riscos
	            }
	);
	
}

function pesquisar_codigo_risco(){

	var campo = document.getElementById('TabDbLov');
	document.getElementById('lista_riscos').removeChild(campo);
	
	var oAjax = new Ajax.Request('con4_pesquisar_xml_riscos.php', 
			        {
               method:'post',
			         parameters:{codigoRisco: $('codigoRiscoFiscal').value, codigoPerspectiva: $('codigoPerspectiva').value}, 
		           onComplete:cria_tabela
		          } 
	);
	
}

function pegar_valor_risco(risco){
	
	$('codRisco').value = risco;
	
	document.getElementById('lista_riscos').style.visibility = "hidden";
	var campo = document.getElementById('TabDbLov'); 
	document.getElementById('lista_riscos').removeChild(campo); 
}

function cria_tabela_riscos(json){

	jsonObj = eval("("+json.responseText+")");
	
	var tabela;
	var color = "#e796a4";
	tabela  = "<table id=\"TabDbLov\" cellspacing=\"1\" cellpadding=\"2\" border=\"1\">";
	tabela +=	"<tr style=\"text-decoration: underline;\"><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Código Risco";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Código Perspectiva";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Exercício";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Descrição";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Valor";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Cod Risco Fiscal";
	tabela += "</td></tr>";
	for (var i = 0; i < jsonObj.length; i++){
		if(i % 2 != 0){
				color = "#97b5e6";
		}else{
			color = "#e796a4";
		}
		tabela += "<tr>";
		tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
		tabela += "<a onclick=\"pegar_valor_risco('"+jsonObj[i].codRisco+"')\">"+jsonObj[i].codRisco+"</a>";
		tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
		tabela += "<a onclick=\"pegar_valor_risco('"+jsonObj[i].codRisco+"')\">"+jsonObj[i].codPerspectiva+"</a>";
		tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
		tabela += "<a onclick=\"pegar_valor_risco('"+jsonObj[i].codRisco+"')\">"+jsonObj[i].exercicio+"</a>";
		tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
		tabela += "<a onclick=\"pegar_valor_risco('"+jsonObj[i].codRisco+"')\">"+jsonObj[i].dscRiscoFiscal.substr(0,50)+"</a>";
		tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
		tabela += "<a onclick=\"pegar_valor_risco('"+jsonObj[i].codRisco+"')\">"+jsonObj[i].vlRiscoFiscal+"</a>";
		tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
		tabela += "<a onclick=\"pegar_valor_risco('"+jsonObj[i].codRisco+"')\">"+(jsonObj[i].codRiscoFiscal == '01' ? "Demandas Judiciais" :
			jsonObj[i].codRiscoFiscal == '02' ? "Dívidas em Processo de Reconhecimento" : jsonObj[i].codRiscoFiscal == '03' ? "Avais e Garantias Concedidas" : 
				jsonObj[i].codRiscoFiscal == '04' ? "Assunção de Passivos" : jsonObj[i].codRiscoFiscal == '05' ? "Assistências Diversas" : jsonObj[i].codRiscoFiscal == '06' ?
			  "Outros Passivos Contingentes" : jsonObj[i].codRiscoFiscal == '07' ? "Frustração de Arrecadação" : jsonObj[i].codRiscoFiscal == '08' ? "Restituição de Tributos a Maior" :
				jsonObj[i].codRiscoFiscal == '09' ? "Discrepância de Projeções" : "Outros Riscos Fiscais")+"</a>";
		tabela += "</td></tr>";
	}
	tabela += "</table>";
	var conteudo = document.getElementById('lista_riscos');
	conteudo.innerHTML += tabela;
	conteudo.style.visibility = "visible";
	
}
</script>