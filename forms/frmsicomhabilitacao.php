<div id="lista" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Habilitação</span>
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
<td> <input type="text" name="codigoCred" id="codigoCred" ></td>
</tr>
<tr>
<td><strong>Número do documento</strong></td>
<td> <input type="text" name="nroDocumentoP" id="nroDocumentoP" ></td>
</tr>
<tr>
<td></td>
<td><input type="button" name="bntPesquisarXml" value="Pesquisar" onclick="pesquisar_codigo()"></td>
</tr>
</table>
</div><!-- campos -->
</div><!-- lista -->

<form name="form1" method="post" action="">

<table>
<tr>
<td>
<fieldset style="width: 540px; height: 550px;"><legend><b>Habilitação</b></legend>
  <table cellspacing="5px">
  <tr>
  <td><strong>Código</strong></td>
  <td><input type="text" name="codigo" id="codigo" readonly="readonly" style="background-color: rgb(222, 184, 135);" >
  </td>
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
  <td><strong>CPF/CNPJ do participante da licitação:</strong></td>
  <td><input type="text" name=nroDocumento id="nroDocumento" maxlength="14" 
  onkeyup="js_ValidaCampos(this,1,'Número do documento','f','f',event);">
  </td>
  </tr>
  
  <tr>
  <td><strong>Nome ou razão social do participante da licitação:</strong></td>
  <td><input type="text" name="nomRazaoSocial" id="nomRazaoSocial" maxlength="120" size="41"></td>
  </tr>
  
  <tr>
  <td><strong>Objeto Social</strong></td>
  <td>
  <textarea id="objetoSocial" onkeyup="textCounter(this.form1.descricaoArtigo,this.form.remLen,250)" 
  onkeydown="textCounter(this.form1.descricaoArtigo,this.form.remLen,250)" rows="7" cols="39" value="" name="objetoSocial" 
  type="text"> </textarea>
  </td>
  </tr>
  
  <tr>
  <td><strong>Órgão responsável pelo registro:</strong></td>
  <td>
  <select name="orgaoRespRegistro" id="orgaoRespRegistro">
  <option value="1" id="01">Cartório de Registro, títulos e documentos</option>
  <option value="2" id="02">Junta Comercial</option>
  </select>
  </td>
  </tr>
  
  <tr>
  <td><strong>Data do Registro:</strong></td>
  <td><input type="text" name="dataRegistro" id="dataRegistro" 
  onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)" 
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10" size="7">
  <input id="dataRegistro_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataRegistro_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataRegistro_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparaDtEmissaoCertidaoRegularidadeINSS(dia,mes,ano){
      var objData = document.getElementById('dataRegistro');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>
  </td>
  </tr>
  
  <tr>
  <td><strong>Número do Registro:</strong></td>
  <td><input type="text" name="nroRegistro" id="nroRegistro" maxlength="30"  
	onkeyup="js_ValidaCampos(this,1,'Número do registro','f','f',event);" >
  </td>
  </tr>
  
    <tr>
  <td><strong>Data do Registro(Capital Aberto):</strong></td>
  <td><input type="text" name="dataRegistroCVM" id="dataRegistroCVM" 
  onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)" 
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10" size="7">
  <input id="dataRegistroCVM_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataRegistroCVM_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataRegistroCVM_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparaDtEmissaoCertidaoRegularidadeINSS(dia,mes,ano){
      var objData = document.getElementById('dataRegistroCVM');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>
  </td>
  </tr>
  
    <tr>
  <td><strong>Número do Registro(Capital Aberto):</strong></td>
  <td><input type="text" name="nroRegistroCVM" id="nroRegistroCVM" maxlength="30"  
	onkeyup="js_ValidaCampos(this,1,'Número do registro','f','f',event);" >
  </td>
  </tr>
  
  <tr>
  <td><strong>Número da inscrição estadual do participante da licitação:</strong></td>
  <td><input type="text" name=nroInscricaoEstadual id="nroInscricaoEstadual" maxlength="30" 
  onkeyup="js_ValidaCampos(this,1,'Número da inscrição','f','f',event);" >
  </td>
  </tr>
  
  <tr>
  <td><strong>UF correspondente à inscrição estadual do participante da licitação:</strong></td>
  <td><input type="text" name=ufInscricaoEstadual id="ufInscricaoEstadual" maxlength="2" size="2" style="text-transform: uppercase;"></td>
  </tr>
  
  <tr>
  <td><strong>Número da certidão de regularidade do INSS:</strong></td>
  <td><input type="text" name=nroCertidaoRegularidadeINSS id="nroCertidaoRegularidadeINSS" maxlength="30"  
	onkeyup="js_ValidaCampos(this,1,'Número da certidão','f','f',event);" >
  </td>
  </tr>
  
  <tr>
  <td><strong>Data de emissão da certidão de regularidade do INSS:</strong></td>
  <td><input type="text" name=dtEmissaoCertidaoRegularidadeINSS id="dtEmissaoCertidaoRegularidadeINSS" 
  onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)" 
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10" size="7">
  <input id="dtEmissaoCertidaoRegularidadeINSS_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dtEmissaoCertidaoRegularidadeINSS_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dtEmissaoCertidaoRegularidadeINSS_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparaDtEmissaoCertidaoRegularidadeINSS(dia,mes,ano){
      var objData = document.getElementById('dtInicio');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>
  </td>
  </tr>
  
  <tr>
  <td><strong>Data de validade da certidão de regularidade do INSS:</strong></td>
  <td><input type="text" name=dtValidadeCertidaoRegularidadeINSS id="dtValidadeCertidaoRegularidadeINSS"
  onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)" 
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10" size="7">
  <input id="dtValidadeCertidaoRegularidadeINSS_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dtValidadeCertidaoRegularidadeINSS_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dtValidadeCertidaoRegularidadeINSS_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparaDtValidadeCertidaoRegularidadeINSS(dia,mes,ano){
      var objData = document.getElementById('dtInicio');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>
  
  </td>
  </tr>
  
  </table>
  </fieldset>
  </td>
 
  <td> 
  <fieldset style="width: 500px; height: 480px;">
  <table>
  
  <tr>
  <td><strong>Número da certidão de regularidade do FGTS:</strong></td>
  <td><input type="text" name=nroCertidaoRegularidadeFGTS id="nroCertidaoRegularidadeFGTS" maxlength="30"  
	onkeyup="js_ValidaCampos(this,1,'Número da certidão','f','f',event);" >
  </td>
  </tr>
  <tr>
  <td><strong>Data de emissão da certidão de regularidade do FGTS:</strong></td>
  <td><input type="text" name=dtEmissaoCertidaoRegularidadeFGTS id="dtEmissaoCertidaoRegularidadeFGTS" 
  onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)" 
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10" size="7">
  <input id="dtEmissaoCertidaoRegularidadeFGTS_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dtEmissaoCertidaoRegularidadeFGTS_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dtEmissaoCertidaoRegularidadeFGTS_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparaDtEmissaoCertidaoRegularidadeFGTS(dia,mes,ano){
      var objData = document.getElementById('dtInicio');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>
  
  </td>
  </tr>
  <tr>
  <td><strong>Data de validade da certidão de regularidade do FGTS:</strong></td>
  <td><input type="text" name=dtValidadeCertidaoRegularidadeFGTS id="dtValidadeCertidaoRegularidadeFGTS"
  onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)" 
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10" size="7">
  <input id="dtValidadeCertidaoRegularidadeFGTS_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dtValidadeCertidaoRegularidadeFGTS_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dtValidadeCertidaoRegularidadeFGTS_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparaDtValidadeCertidaoRegularidadeFGTS(dia,mes,ano){
      var objData = document.getElementById('dtInicio');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>
  
  </td>
  </tr>
  <tr>
  <td><strong>Data da habilitação:</strong></td>
  <td><input type="text" name=dtHabilitacao id="dtHabilitacao"
  onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)" 
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10" size="7">
  <input id="dtHabilitacao_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dtHabilitacao_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dtHabilitacao_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparaDtHabilitacao(dia,mes,ano){
      var objData = document.getElementById('dtInicio');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>
  
  </td>
  </tr>
  
  <tr>
  <td>
  <strong>Número da Certidão Negativa de Débitos Trabalhistas</strong>
  </td>
  <td><input type="text" name="nroCNDT" id="nroCNDT" maxlength="30"  
	onkeyup="js_ValidaCampos(this,1,'Número da certidão','f','f',event);"></td>
  </tr>
  
  <tr>
  <td><strong>Data de emissão da certidão Negativa de Débitos Trabalhistas:</strong></td>
  <td><input type="text" name="dtEmissaoCNDT" id="dtEmissaoCNDT"
  onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)" 
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10" size="7">
  <input id="dtEmissaoCNDT_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dtEmissaoCNDT_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dtEmissaoCNDT_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparaDtValidadeCertidaoRegularidadeFGTS(dia,mes,ano){
      var objData = document.getElementById('dtEmissaoCNDT');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>
  </td>
  </tr>
  
  <tr>
  <td><strong>Data de validade da certidão Negativa de Débitos Trabalhistas :</strong></td>
  <td><input type="text" name="dtValidadeCNDT" id="dtValidadeCNDT"
  onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)" 
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10" size="7">
  <input id="dtValidadeCNDT_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dtValidadeCNDT_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dtValidadeCNDT_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparaDtValidadeCertidaoRegularidadeFGTS(dia,mes,ano){
      var objData = document.getElementById('dtValidadeCNDT');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>
  </td>
  </tr>
  
  <tr>
  <td><strong>Presença Registrada em Ata:</strong></td>
  <td>
  <select name="PresencaLicitantes" id="PresencaLicitantes">
  <option value="1" id="01">Sim</option>
  <option value="2" id="02">Não</option>
  </select>
  </td>
  </tr>
  
  <tr>
  <td><strong>Informar a existência de renúncia a prazo recursal:</strong></td>
  <td>
  <select name="renunciaRecurso" id="renunciaRecurso">
  <option value="1" id="01">Sim</option>
  <option value="2" id="02">Não</option>
  </select>
  </td>
  </tr>
  
  <tr>
  <td colspan="2">
  <fieldset style="height: 240px;"><legend><strong>Dados do Sócio</strong></legend>
  <table>
  
  <tr>
  <td><strong>CPF/CNPJ do sócio da empresa habilitada:</strong></td>
  <td><input type="text" name="nroDocumentoSocio" id="nroDocumentoSocio" maxlength="14" 
  onkeyup="js_ValidaCampos(this,1,'Número do documento','f','f',event);">
  </td>
  </tr>
  
  <tr>
  <td><strong>Nome do sócio da empresa habilitada:</strong></td>
  <td><input type="text" name="nomeSocio" id="nomeSocio" maxlength="120" size="37"></td>
  </tr>
  
  <tr>
  <td><strong>Tipo de Participação no Quadro Societário:</strong></td>
  <td>
  <select name="tipoParticipacao" id="tipoParticipacao">
  <option value="1" id="01">Representante legal</option>
  <option value="2" id="02">Demais membros do quadro societário</option>
  </select>
  </td>
  </tr>
  
  <tr>
  <td><input type="button" name="IncluirSocio" id="IncluirSocio" value="Incluir" onclick="js_nova_linha()"></td>
  </tr>
  
  </table>
  
  <div id="ctnGridSocios" style="overflow: scroll; height: 120px;">
  <table id="gridSocios" class="DBGrid" cellspacing="0" cellpadding="0" width="100%" border="0" style="border:2px inset white; ">
  <tr>
  <th class="table_header" style="width: 10%;">Documento do sócio</th>
    <th class="table_header" style="width: 70%;">Nome</th>
	<th class="table_header" style="width: 10%;">Tipo</th>
	<th class="table_header" style="width: 10%;"></th>
	</tr>
	<?php 
	$iCont = 0;
	echo "<input type=\"hidden\" name=\"cont_socios\" />
	<script>
	document.form1.cont_socios.value = $iCont;
	</script>";
	?>
	</table>
</div>
  
  </fieldset>
  </td>
  </tr>
  
</table>
</fieldset>
<br><br>
	<input type="submit" value="Salvar" name="btnSalvar" />
	<input type="submit" value="Excluir" name="btnExcluir" />
	<input type="button" value="Pesquisar" name="btnPesquisar" onclick="pesquisar()" />
	<input type="reset" value="Novo" name="btnNovo" onclick="js_excluir_todos()" />
</td>
</tr>

</table>
</form>

<script type="text/javascript">

function js_nova_linha(){

	if (document.form1.nroDocumentoSocio.value == '') {
		alert("Digite o CPF/CNPJ do sócio");
    document.form1.nroDocumentoSocio.focus();
		return;
	}
	
	if (document.form1.nomeSocio.value == '') {
		alert("Digite o nome do sócio");
    document.form1.nomeSocio.focus();
		return;
	}
	var codigo = parseInt(document.form1.cont_socios.value)+1;
	var tabela = "<tr id=\""+codigo+"\" class=\"normal\" style=\"height:1em;\">";
	tabela += "<td id=\"Sociosrow1cell0\" class=\"linhagrid\" style=\"text-align:left;\">";
	tabela += "<input type=\"text\" name=\"nroDocumentoSocio"+codigo+"\" size=\"12\" readonly=\"readonly\" value=\""+document.form1.nroDocumentoSocio.value+"\"/></td>";
	tabela    += "<td id=\"Sociosrow1cell0\" class=\"linhagrid\" style=\"text-align:left;\">"
	tabela += "<input type=\"text\" name=\"nomeSocio"+codigo+"\" size=\"38\" readonly=\"readonly\" value=\""+document.form1.nomeSocio.value+"\"/></td>";
	tabela    += "<td id=\"Sociosrow1cell0\" class=\"linhagrid\" style=\"text-align:center;\">"
  tabela += "<input type=\"text\" name=\"tipoParticipacao"+codigo+"\" size=\"2\" readonly=\"readonly\" value=\""+document.form1.tipoParticipacao.value+"\"/></td>";
	tabela    += "<td id=\"Sociosrow1cell3\" class=\"linhagrid\" style=\"text-align:center;\">";
	tabela    += "<input type=\"button\" name=\"excluir\" value=\"Excluir\" onclick=\"js_excluir2("+codigo+")\"></td></tr>";

	document.getElementById("gridSocios").innerHTML += tabela;
	document.form1.cont_socios.value = codigo;
	document.form1.cont_socios.value = parseInt(codigo)+1;
	document.form1.nroDocumentoSocio.value = '';
	document.form1.nomeSocio.value = '';
	document.form1.tipoParticipacao.options[0].selected=true;
  document.form1.nroDocumentoSocio.focus();
	
}

function js_excluir2(id){

	try {
	  linha = document.getElementById(id);
	  linha.parentNode.parentNode.removeChild(linha.parentNode);
	}catch (e) {
	}  
	  document.form1.cont_socios.value = parseInt(document.form1.cont_socios.value)-1;
	
}

function js_excluir_todos(){

	var j = 0;
	for (var i = parseInt(document.form1.cont_socios.value)-1; i >= 0; i--) {
		j = i;
		while(document.getElementById(j) == null) {
      j++;
		}
	  js_excluir2(j);
  }
	document.form1.cont_socios.value = 0;
	
}

/**
 * limitar caracteres de textarea
 */
function textCounter(field, countfield, maxlimit) {
	
	if (field.value.length > maxlimit) {
		field.value = field.value.substring(0, maxlimit);
	}else{ 
		countfield.value = maxlimit - field.value.length;
	}
	
}

/**
* Pesquisar dados da licitação
*/
function js_pesquisa_liclicita(mostra) {
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
       function js_mostraliclicita(chave,erro) {
         document.form1.nroProcessoLicitatorio.value = chave; 
         if(erro==true){ 
           document.form1.nroProcessoLicitatorio.value = ''; 
           document.form1.nroProcessoLicitatorio.focus(); 
         }
       }
       function js_mostraliclicita1(chave1) {
          document.form1.nroProcessoLicitatorio.value = chave1;  
          db_iframe_liclicita.hide();
       }

 /**
  * buscar dados do xml para criar a tabela
  */
 function pesquisar() {

   var oAjax = new Ajax.Request("con4_pesquisarxmlhabilitacao.php",
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
  	
    var oAjax = new Ajax.Request("con4_pesquisarxmlhabilitacao.php",
 		 	{
		 	method:"post",
		 	parameters:{codigo1: $('codigoCred').value, codigo2: $('nroDocumentoP').value},
		 	onComplete:cria_tabela
		 	}
 	  );
	 
  }

  function fechar() {
	  
		var campo = document.getElementById('TabDbLov'); 
		document.getElementById('lista').removeChild(campo); 
		document.getElementById('lista').style.visibility = "hidden";
		
  }

  function pegar_valor(param1, param2, param3, param4, param5, param6, param7, param8, param9, param10, param11, param12, param13, param14,
		  param15,param16,param17,param18,param19,param20,param21,param22,param23,param24,param25,param26){
		
	  	$('codigo').value = param1;
	  	$('nroProcessoLicitatorio').value = param2;
	  	$('nroDocumento').value = param3;
	  	$('nomRazaoSocial').value = param4;
	  	$('nroInscricaoEstadual').value = param5;
	  	$('ufInscricaoEstadual').value = param6;
	  	$('nroCertidaoRegularidadeINSS').value = param7;
	  	$('dtEmissaoCertidaoRegularidadeINSS').value = param8;
	  	$('dtValidadeCertidaoRegularidadeINSS').value = param9;
	  	$('nroCertidaoRegularidadeFGTS').value = param10;
	  	$('dtEmissaoCertidaoRegularidadeFGTS').value = param11;
	  	$('dtValidadeCertidaoRegularidadeFGTS').value = param12;
	  	$('dtHabilitacao').value = param13;
	  	document.getElementById('renunciaRecurso').options['0'+param14].selected = "true";
	  	$('objetoSocial').value = param15;
	  	document.getElementById('orgaoRespRegistro').options['0'+param16].selected = "true";
	  	$('dataRegistro').value = param17;
	  	$('nroRegistro').value  = param18;
	  	$('dataRegistroCVM').value  = param19;
	  	$('nroRegistroCVM').value   = param20;
	  	$('nroCNDT').value   = param21;
	  	$('dtEmissaoCNDT').value   = param22;
	  	$('dtValidadeCNDT').value   = param23;
	  	$('PresencaLicitantes').value   = param24;

	  	var oAjax = new Ajax.Request("con4_pesquisarxmlhabilitacaosocios.php",
	 		 	{
			 	method:"post",
			 	parameters:{codigo: param1},
			 	onComplete:cria_tabela_socios
			 	}
	 	  );
	  	
	  	
	  	document.getElementById('lista').style.visibility = "hidden";
	  	var campo = document.getElementById('TabDbLov');
	  	document.getElementById('lista').removeChild(campo); 
	  	
	  }

  function cria_tabela(json) {

	  var jsonObj = eval("("+json.responseText+")");
		var tabela;
		var color = "#e796a4";
		tabela  = "<table id=\"TabDbLov\" cellspacing=\"1\" cellpadding=\"2\" border=\"1\">";
		tabela +=	"<tr style=\"text-decoration: underline;\"><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
		tabela += "Código";
		tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
		tabela += "Código da Licitação";
		tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
		tabela += "Nro do documento do participante da licitação";
		tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
		tabela += "Razão social do participante da licitação";
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
				tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].nroProcessoLicitatorio+"','"
				+jsonObj[i].nroDocumento+"','"+jsonObj[i].nomRazaoSocial+"','"+jsonObj[i].nroInscricaoEstadual+"','"
				+jsonObj[i].ufInscricaoEstadual+"','"+jsonObj[i].nroCertidaoRegularidadeINSS+"','"+jsonObj[i].dtEmissaoCertidaoRegularidadeINSS+"','"
				+jsonObj[i].dtValidadeCertidaoRegularidadeINSS+"','"+jsonObj[i].nroCertidaoRegularidadeFGTS+"','"+jsonObj[i].dtEmissaoCertidaoRegularidadeFGTS+"','"
				+jsonObj[i].dtValidadeCertidaoRegularidadeINSS+"','"+jsonObj[i].dtHabilitacao+"','"+jsonObj[i].renunciaRecurso+"','"
				+jsonObj[i].objetoSocial+"','"+jsonObj[i].orgaoRespRegistro+"','"+jsonObj[i].dataRegistro+"','"+jsonObj[i].nroRegistro+"','"
				+jsonObj[i].dataRegistroCVM+"','"+jsonObj[i].nroRegistroCVM+"','"+jsonObj[i].nroCNDT+"','"+jsonObj[i].dtEmissaoCNDT+"','"
				+jsonObj[i].dtValidadeCNDT+"','"+jsonObj[i].PresencaLicitantes+"')\">"+jsonObj[i].codigo+"</a>";
	
				tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
				tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].nroProcessoLicitatorio+"','"
				+jsonObj[i].nroDocumento+"','"+jsonObj[i].nomRazaoSocial+"','"+jsonObj[i].nroInscricaoEstadual+"','"
				+jsonObj[i].ufInscricaoEstadual+"','"+jsonObj[i].nroCertidaoRegularidadeINSS+"','"+jsonObj[i].dtEmissaoCertidaoRegularidadeINSS+"','"
				+jsonObj[i].dtValidadeCertidaoRegularidadeINSS+"','"+jsonObj[i].nroCertidaoRegularidadeFGTS+"','"+jsonObj[i].dtEmissaoCertidaoRegularidadeFGTS+"','"
				+jsonObj[i].dtValidadeCertidaoRegularidadeINSS+"','"+jsonObj[i].dtHabilitacao+"','"+jsonObj[i].renunciaRecurso+"','"
				+jsonObj[i].objetoSocial+"','"+jsonObj[i].orgaoRespRegistro+"','"+jsonObj[i].dataRegistro+"','"+jsonObj[i].nroRegistro+"','"
				+jsonObj[i].dataRegistroCVM+"','"+jsonObj[i].nroRegistroCVM+"','"+jsonObj[i].nroCNDT+"','"+jsonObj[i].dtEmissaoCNDT+"','"
				+jsonObj[i].dtValidadeCNDT+"','"+jsonObj[i].PresencaLicitantes+"')\">"+jsonObj[i].nroProcessoLicitatorio+"</a>";
	
				tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
				tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].nroProcessoLicitatorio+"','"
				+jsonObj[i].nroDocumento+"','"+jsonObj[i].nomRazaoSocial+"','"+jsonObj[i].nroInscricaoEstadual+"','"
				+jsonObj[i].ufInscricaoEstadual+"','"+jsonObj[i].nroCertidaoRegularidadeINSS+"','"+jsonObj[i].dtEmissaoCertidaoRegularidadeINSS+"','"
				+jsonObj[i].dtValidadeCertidaoRegularidadeINSS+"','"+jsonObj[i].nroCertidaoRegularidadeFGTS+"','"+jsonObj[i].dtEmissaoCertidaoRegularidadeFGTS+"','"
				+jsonObj[i].dtValidadeCertidaoRegularidadeINSS+"','"+jsonObj[i].dtHabilitacao+"','"+jsonObj[i].renunciaRecurso+"','"
				+jsonObj[i].objetoSocial+"','"+jsonObj[i].orgaoRespRegistro+"','"+jsonObj[i].dataRegistro+"','"+jsonObj[i].nroRegistro+"','"
				+jsonObj[i].dataRegistroCVM+"','"+jsonObj[i].nroRegistroCVM+"','"+jsonObj[i].nroCNDT+"','"+jsonObj[i].dtEmissaoCNDT+"','"
				+jsonObj[i].dtValidadeCNDT+"','"+jsonObj[i].PresencaLicitantes+"')\">"+jsonObj[i].nroDocumento+"</a>";
	
				tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
				tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].nroProcessoLicitatorio+"','"
				+jsonObj[i].nroDocumento+"','"+jsonObj[i].nomRazaoSocial+"','"+jsonObj[i].nroInscricaoEstadual+"','"
				+jsonObj[i].ufInscricaoEstadual+"','"+jsonObj[i].nroCertidaoRegularidadeINSS+"','"+jsonObj[i].dtEmissaoCertidaoRegularidadeINSS+"','"
				+jsonObj[i].dtValidadeCertidaoRegularidadeINSS+"','"+jsonObj[i].nroCertidaoRegularidadeFGTS+"','"+jsonObj[i].dtEmissaoCertidaoRegularidadeFGTS+"','"
				+jsonObj[i].dtValidadeCertidaoRegularidadeINSS+"','"+jsonObj[i].dtHabilitacao+"','"+jsonObj[i].renunciaRecurso+"','"
				+jsonObj[i].objetoSocial+"','"+jsonObj[i].orgaoRespRegistro+"','"+jsonObj[i].dataRegistro+"','"+jsonObj[i].nroRegistro+"','"
				+jsonObj[i].dataRegistroCVM+"','"+jsonObj[i].nroRegistroCVM+"','"+jsonObj[i].nroCNDT+"','"+jsonObj[i].dtEmissaoCNDT+"','"
				+jsonObj[i].dtValidadeCNDT+"','"+jsonObj[i].PresencaLicitantes+"')\">"+jsonObj[i].nomRazaoSocial+"</a>";
				
				tabela += "</td></tr>";
				
			}

		}catch (e) {
		}
		tabela += "</table>";
		var conteudo = document.getElementById('lista');
		conteudo.innerHTML += tabela;
    conteudo.style.visibility = "visible";
		
	}

  function cria_tabela_socios(json) {

	  
	  js_excluir_todos();
	  
	  var jsonObj = eval("("+json.responseText+")");
		var codigo = 0;
		try {
			
			for (var i = 0; i < jsonObj.length; i++) {
				
				var tabela = "<tr id=\""+codigo+"\" class=\"normal\" style=\"height:1em;\">";
				tabela += "<td id=\"Sociosrow1cell0\" class=\"linhagrid\" style=\"text-align:left;\">";
				tabela += "<input type=\"text\" name=\"nroDocumentoSocio"+codigo+"\" size=\"12\" readonly=\"readonly\" value=\""+jsonObj[i].nroDocumentoSocio+"\"/></td>";
				tabela    += "<td id=\"Sociosrow1cell0\" class=\"linhagrid\" style=\"text-align:left;\">"
				tabela += "<input type=\"text\" name=\"nomeSocio"+codigo+"\" size=\"38\" readonly=\"readonly\" value=\""+jsonObj[i].nomeSocio+"\"/></td>";
				tabela    += "<td id=\"Sociosrow1cell0\" class=\"linhagrid\" style=\"text-align:center;\">"
			  tabela += "<input type=\"text\" name=\"tipoParticipacao"+codigo+"\" size=\"2\" readonly=\"readonly\" value=\""+jsonObj[i].tipoParticipacao+"\"/></td>";
				tabela    += "<td id=\"Sociosrow1cell3\" class=\"linhagrid\" style=\"text-align:center;\">";
				tabela    += "<input type=\"button\" name=\"excluir\" value=\"Excluir\" onclick=\"js_excluir2("+codigo+")\"></td></tr>";
				document.getElementById("gridSocios").innerHTML += tabela;
				codigo++;
				
			}

			document.form1.cont_socios.value = codigo;
			document.form1.nroDocumentoSocio.value = '';
			document.form1.nomeSocio.value = '';
			document.form1.tipoParticipacao.options[0].selected=true;
		  document.form1.nroDocumentoSocio.focus();
			
		}catch (e) {
		}
		
	}
  
</script>
