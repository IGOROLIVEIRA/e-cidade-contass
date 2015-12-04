<div id="lista" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Dados Identificação do Responsável</span>
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
<td> <input type="text" name="codigoSeq" id="codigoSeq" maxlength="13" onkeyup="js_ValidaCampos(this,1,'código','f','f',event);"></td>
</tr>
<tr>
<td><strong>Código numCgm:</strong></td>
<td>
 <input type="text" name="numCgmResp" id="numCgmResp" maxlength="13" onkeyup="js_ValidaCampos(this,1,'numCgm','f','f',event);">
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
<fieldset style="width: 500px; height: 340px;"><legend><b>Identificação do Responsável</b></legend>
  <table cellspacing="5px">
  <tr>
  <td><strong>Código</strong></td>
  <td> <input type="text" name="codigo" id="codigo" readonly="readonly" style="background-color: rgb(222, 184, 135);" ></td>
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
  <td><strong>Tipo Responsável:</strong></td>
  <td>
  <select name=tipoResponsavel id="tipoResponsavel" onchange="mostrar_orgaoresp();">
   <option value="01" id="01">Gestor</option>
   <option value="02" id="02">Contador</option>
   <option value="03" id="03">Controle Interno</option>
   <option value="04" id="04">Ordenador de Despesa por Delegação</option>
  </select>
  </td>
  </tr>
  <tr id="mostraOrgao" style="visibility: hidden;">
    <td nowrap title="<?=@$To41_orgao?>">
       <?
       db_ancora("<b>Orgão</b>","js_pesquisao41_orgao(true);", 1);
       ?>
    </td>
    <td> 
<input name="OrgaoResp" id="OrgaoResp" onchange="js_pesquisao41_orgao(false);" onblur="js_pesquisao41_orgao(false);" 
onkeyup="js_ValidaCampos(this,1,'Código do Orgão','f','f',event);" maxlength="13" size="10">

<input name="nomeOrgao" id="nomeOrgao" style="background-color: rgb(222, 184, 135);" readonly="readonly">
    </td>
  </tr>
  <tr>
  <td><strong>Orgão Emissor:</strong></td>
  <td><input type="text" name=orgEmissorCi id="orgEmissorCi" maxlength="10" style="text-transform:uppercase;"></td>
  </tr>
  <tr>
  <td><strong>CRC Contador:</strong></td>
  <td><input type="text" name=crcContador id="crcContador" maxlength="11"></td>
  </tr>
  <tr>
  <td><strong>UFCrc Contador:</strong></td>
  <td><input type="text" name=ufCrcContador id="ufCrcContador" maxlength="2" style="text-transform:uppercase;"></td>
  </tr>
  <tr>
  <td><strong>Cargo Ordenador por Despesa:</strong></td>
  <td><input type="text" name=cargoOrdDespDeleg id="cargoOrdDespDeleg"></td>
  </tr>
  <tr>
  <td><strong>Data inicial:</strong></td>
  <td>
  <input type="text" name="dtInicio" id="dtInicio" onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)" 
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10">
  <input id="dtInicio_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dtInicio_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dtInicio_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparaDatasodtInicio(dia,mes,ano){
      var objData = document.getElementById('dtInicio');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>

  </td>
  </tr>
  <tr>
  <td><strong>Data final:</strong></td>
  <td>
  <input type="text" name="dtFinal" id="dtFinal" onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)" 
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10">
  <input id="dtFinal_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dtFinal_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dtFinal_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparaDatasodtFinal(dia,mes,ano){
      var objData = document.getElementById('dtFinal');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>
  </td>
  </tr>
  <tr>
  <td><strong>Código município do logradouro:</strong></td>
  <td><input type="text" name=codCidadeLogra id="codCidadeLogra" maxlength="5"></td>
  </tr>
  <tr>
	<td align="right" colspan="2">
	<input type="submit" value="Salvar" name="btnSalvar" />
	<input type="submit" value="Excluir" name="btnExcluir" />
	<input type="button" value="Pesquisar" name="btnPesquisar" onclick="pesquisar()" />
	<input type="reset" value="Novo" name="btnNovo" />
	</td>
</tr>
</table>
</fieldset>
</form>
<input type="hidden" value="0" name="inicio" id="inicio"/>
<input type="hidden" value="<?=$iTotalLista ?>" name="total" id="total"/>
<script type="text/javascript">

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
	
	function js_pesquisao41_orgao(mostra){
		  if(mostra==true){
		    js_OpenJanelaIframe('','db_iframe_orcorgao','func_orcorgao.php?funcao_js=parent.js_mostraorcorgao1|o40_orgao|o40_descr','Pesquisa',true,'0','1');
		  }else{
		     if(document.form1.OrgaoResp.value != ''){
		        js_OpenJanelaIframe('','db_iframe_orcorgao','func_orcorgao.php?pesquisa_chave='+document.form1.OrgaoResp.value+'&funcao_js=parent.js_mostraorcorgao','Pesquisa',false);
		     }else{
		       document.form1.nomeOrgao.value = ''; 
		     }
		  }
		}
		function js_mostraorcorgao(chave,erro){
		  document.form1.nomeOrgao.value = chave; 
		  if(erro==true){ 
		    document.form1.OrgaoResp.focus(); 
		    document.form1.OrgaoResp.value = ''; 
		  }
		}
		function js_mostraorcorgao1(chave1,chave2){
		  document.form1.OrgaoResp.value = chave1;
		  document.form1.nomeOrgao.value = chave2;
		  db_iframe_orcorgao.hide();
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

  var oAjax = new Ajax.Request("con4_pesquisarxmlidentresponsavel.php",
		  {
	  method:'post',
	  parameters:{inicio: $('inicio').value},
	  onComplete:cria_tabela
		  }
	  );	
}

 /**
  * avançar para proxima lista da paginacao
  */
 function proximo(){

   if (parseInt(($('inicio').value)) < parseInt(($('total').value))) {

	   $('inicio').value = parseInt(($('inicio').value))+1;
		 var campo = document.getElementById('TabDbLov');
		 document.getElementById('lista').removeChild(campo);
	   
	   pesquisar();

   }
	  	
 }
  /**
   * voltar para lista anterior da paginacao
   */
  function anterior(){

	  if (parseInt($('inicio').value) > 0) {
		  
		  var campo = document.getElementById('TabDbLov');
	 	  document.getElementById('lista').removeChild(campo);
	    $('inicio').value = parseInt(($('inicio').value))-1;
	    pesquisar();
	  	  
	  }
 	  	
  }
 /**
  * voltar para primeira lista da paginacao
  */
  function inicio(){

	  if (parseInt($('inicio').value) > 0) {
		  
		  var campo = document.getElementById('TabDbLov');
	 	  document.getElementById('lista').removeChild(campo);
	    $('inicio').value = 0;
	    pesquisar();
	  	  
	  }
 	  	
  }
  /**
   * avançar para ultima lista da paginacao
   */
  function ultimo(){

    if (parseInt(($('inicio').value)) < parseInt(($('total').value))) {
 	   
 		 var campo = document.getElementById('TabDbLov');
 		 document.getElementById('lista').removeChild(campo);
 	   $('inicio').value = parseInt(($('total').value));
 	   pesquisar();

    }
 	  	
  }
 
/**
 * pesquisar dados no xml pelo codigo digitado
 */
function pesquisar_codigo(){

	var campo = document.getElementById('TabDbLov');
	document.getElementById('lista').removeChild(campo);

	var oAjax = new Ajax.Request("con4_pesquisarxmlidentresponsavel.php",
			{
	   method:'post',
	   parameters:{codigo1: $('codigoSeq').value, codigo2: $('numCgmResp').value},
	   onComplete:cria_tabela
		  }
			);

}

/**
 * 
 */
function pegar_valor(param1, param2, param3, param4, param5, param6, param7, param8, param9, param10, param11, param12, param13){
	
	$('codigo').value = param1;
	$('numCgm').value = param2;
	$('nomeResponsavel').value = param3;
	document.getElementById("tipoResponsavel").options[param4].selected = "true";
	$('orgEmissorCi').value = param5;
	$('crcContador').value = param6;
	$('ufCrcContador').value = param7;
	$('cargoOrdDespDeleg').value = param8;
	$('dtInicio').value = param9;
	$('dtFinal').value = param10;
	$('codCidadeLogra').value = param11;

	if (param4 == 4) {

		$('OrgaoResp').value = param12;
		$('nomeOrgao').value = param13;
		mostrar_orgaoresp();
		   
	} else {

		$('OrgaoResp').value = "";
		$('nomeOrgao').value = "";
		mostrar_orgaoresp();

	} 
	fechar();
	
}

function fechar(){
	var campo = document.getElementById('TabDbLov'); 
	document.getElementById('lista').removeChild(campo); 
	document.getElementById('lista').style.visibility = "hidden";
	inicio: $('inicio').value = 0;
}

function cria_tabela(json) {

	var jsonObj = eval("("+json.responseText+")");
	var tabela;
	var color = "#e796a4";
	tabela  = "<table id=\"TabDbLov\" cellspacing=\"1\" cellpadding=\"2\" border=\"1\">";

	tabela +=	"<tr style=\"text-decoration: underline;\"><td bgcolor=\"#cdcdff\" align=\"left\" nowrap=\"\" colspan=\"11\">";

	tabela += "<input type=\"button\" value=\"Início\" name=\"primeiro\" onclick=\"inicio()\">";
	tabela += "<input type=\"button\" value=\"Anterior\" name=\"anterior\" onclick=\"anterior()\">";
	tabela += "<input type=\"button\" value=\"Próximo\" name=\"proximo\" onclick=\"proximo()\">";
	tabela += "<input type=\"button\" value=\"Último\" name=\"ultimo\" onclick=\"ultimo()\">";

	tabela += "<br></td></tr>";
	
	tabela +=	"<tr style=\"text-decoration: underline;\"><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Código";
	
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Nome";
	
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "tipoResponsavel";

	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Orgao Ordenador";
	
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "orgEmissorCi";
	
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "crcContador";
	
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "ufCrcContador";
	
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "cargoOrdDespDeleg";
	
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "dtInicio";
	
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "dtFinal";
	
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "codCidadeLogra";
	
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
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].numCgm+"','"+jsonObj[i].nomeResponsavel+"','"+jsonObj[i].tipoResponsavel+"','"
			+jsonObj[i].orgEmissorCi+"','"+jsonObj[i].crcContador+"','"+jsonObj[i].ufCrcContador+"','"+jsonObj[i].cargoOrdDespDeleg+"','"
			+jsonObj[i].dtInicio+"','"+jsonObj[i].dtFinal+"','"+jsonObj[i].codCidadeLogra+"','"+jsonObj[i].OrgaoResp+"','"+jsonObj[i].nomeOrgao+"')\">"+jsonObj[i].codigo+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].numCgm+"','"+jsonObj[i].nomeResponsavel+"','"+jsonObj[i].tipoResponsavel+"','"
			+jsonObj[i].orgEmissorCi+"','"+jsonObj[i].crcContador+"','"+jsonObj[i].ufCrcContador+"','"+jsonObj[i].cargoOrdDespDeleg+"','"
			+jsonObj[i].dtInicio+"','"+jsonObj[i].dtFinal+"','"+jsonObj[i].codCidadeLogra+"','"+jsonObj[i].OrgaoResp+"','"+jsonObj[i].nomeOrgao+"')\">"+jsonObj[i].nomeResponsavel.substr(0,50)+"</a>";
			
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].numCgm+"','"+jsonObj[i].nomeResponsavel+"','"+jsonObj[i].tipoResponsavel+"','"
			+jsonObj[i].orgEmissorCi+"','"+jsonObj[i].crcContador+"','"+jsonObj[i].ufCrcContador+"','"+jsonObj[i].cargoOrdDespDeleg+"','"
			+jsonObj[i].dtInicio+"','"+jsonObj[i].dtFinal+"','"+jsonObj[i].codCidadeLogra+"','"+jsonObj[i].OrgaoResp+"','"+jsonObj[i].nomeOrgao+"')\">"+(jsonObj[i].tipoResponsavel == '01' ? "Gestor" : 
			jsonObj[i].tipoResponsavel == '02' ? "Contador" : jsonObj[i].tipoResponsavel == '03' ? "Controle Interno" : "Ordenador de Despesa por Delegação")+"</a>";
	
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].numCgm+"','"+jsonObj[i].nomeResponsavel+"','"+jsonObj[i].tipoResponsavel+"','"
			+jsonObj[i].orgEmissorCi+"','"+jsonObj[i].crcContador+"','"+jsonObj[i].ufCrcContador+"','"+jsonObj[i].cargoOrdDespDeleg+"','"
			+jsonObj[i].dtInicio+"','"+jsonObj[i].dtFinal+"','"+jsonObj[i].codCidadeLogra+"','"+jsonObj[i].OrgaoResp+"','"+jsonObj[i].nomeOrgao+"')\">"+(jsonObj[i].nomeOrgao)+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].numCgm+"','"+jsonObj[i].nomeResponsavel+"','"+jsonObj[i].tipoResponsavel+"','"
			+jsonObj[i].orgEmissorCi+"','"+jsonObj[i].crcContador+"','"+jsonObj[i].ufCrcContador+"','"+jsonObj[i].cargoOrdDespDeleg+"','"
			+jsonObj[i].dtInicio+"','"+jsonObj[i].dtFinal+"','"+jsonObj[i].codCidadeLogra+"','"+jsonObj[i].OrgaoResp+"','"+jsonObj[i].nomeOrgao+"')\">"+jsonObj[i].orgEmissorCi+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].numCgm+"','"+jsonObj[i].nomeResponsavel+"','"+jsonObj[i].tipoResponsavel+"','"
			+jsonObj[i].orgEmissorCi+"','"+jsonObj[i].crcContador+"','"+jsonObj[i].ufCrcContador+"','"+jsonObj[i].cargoOrdDespDeleg+"','"
			+jsonObj[i].dtInicio+"','"+jsonObj[i].dtFinal+"','"+jsonObj[i].codCidadeLogra+"','"+jsonObj[i].OrgaoResp+"','"+jsonObj[i].nomeOrgao+"')\">"+jsonObj[i].crcContador+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].numCgm+"','"+jsonObj[i].nomeResponsavel+"','"+jsonObj[i].tipoResponsavel+"','"
			+jsonObj[i].orgEmissorCi+"','"+jsonObj[i].crcContador+"','"+jsonObj[i].ufCrcContador+"','"+jsonObj[i].cargoOrdDespDeleg+"','"
			+jsonObj[i].dtInicio+"','"+jsonObj[i].dtFinal+"','"+jsonObj[i].codCidadeLogra+"','"+jsonObj[i].OrgaoResp+"','"+jsonObj[i].nomeOrgao+"')\">"+jsonObj[i].ufCrcContador+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].numCgm+"','"+jsonObj[i].nomeResponsavel+"','"+jsonObj[i].tipoResponsavel+"','"
			+jsonObj[i].orgEmissorCi+"','"+jsonObj[i].crcContador+"','"+jsonObj[i].ufCrcContador+"','"+jsonObj[i].cargoOrdDespDeleg+"','"
			+jsonObj[i].dtInicio+"','"+jsonObj[i].dtFinal+"','"+jsonObj[i].codCidadeLogra+"','"+jsonObj[i].OrgaoResp+"','"+jsonObj[i].nomeOrgao+"')\">"+jsonObj[i].cargoOrdDespDeleg.substr(0,50)+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].numCgm+"','"+jsonObj[i].nomeResponsavel+"','"+jsonObj[i].tipoResponsavel+"','"
			+jsonObj[i].orgEmissorCi+"','"+jsonObj[i].crcContador+"','"+jsonObj[i].ufCrcContador+"','"+jsonObj[i].cargoOrdDespDeleg+"','"
			+jsonObj[i].dtInicio+"','"+jsonObj[i].dtFinal+"','"+jsonObj[i].codCidadeLogra+"','"+jsonObj[i].OrgaoResp+"','"+jsonObj[i].nomeOrgao+"')\">"+jsonObj[i].dtInicio+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].numCgm+"','"+jsonObj[i].nomeResponsavel+"','"+jsonObj[i].tipoResponsavel+"','"
			+jsonObj[i].orgEmissorCi+"','"+jsonObj[i].crcContador+"','"+jsonObj[i].ufCrcContador+"','"+jsonObj[i].cargoOrdDespDeleg+"','"
			+jsonObj[i].dtInicio+"','"+jsonObj[i].dtFinal+"','"+jsonObj[i].codCidadeLogra+"','"+jsonObj[i].OrgaoResp+"','"+jsonObj[i].nomeOrgao+"')\">"+jsonObj[i].dtFinal+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].numCgm+"','"+jsonObj[i].nomeResponsavel+"','"+jsonObj[i].tipoResponsavel+"','"
			+jsonObj[i].orgEmissorCi+"','"+jsonObj[i].crcContador+"','"+jsonObj[i].ufCrcContador+"','"+jsonObj[i].cargoOrdDespDeleg+"','"
			+jsonObj[i].dtInicio+"','"+jsonObj[i].dtFinal+"','"+jsonObj[i].codCidadeLogra+"','"+jsonObj[i].OrgaoResp+"','"+jsonObj[i].nomeOrgao+"')\">"+jsonObj[i].codCidadeLogra+"</a>";
			
			tabela += "</td></tr>";
		}

	} catch (e) {
	}
	tabela += "</table>";
	var conteudo = document.getElementById('lista');
	conteudo.innerHTML += tabela;
	conteudo.style.visibility = "visible";
}

function mostrar_orgaoresp(){
	
	if ($('tipoResponsavel').value == 04) {
		document.getElementById('mostraOrgao').style.visibility = "visible";	
	} else {

		document.getElementById('mostraOrgao').style.visibility = "hidden";
	  $('OrgaoResp').value = "";
	  $('nomeOrgao').value = "";   
		
	}
	
}

</script>