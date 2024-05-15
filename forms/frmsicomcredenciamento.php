<div id="lista" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Credenciamento</span>
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
<td> <input type="text" name="codigoHab" id="codigoHab" ></td>
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
<fieldset style="width: 540px; height: 480px;"><legend><b>Credenciamento</b></legend>
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
  onkeyup="js_ValidaCampos(this,1,'Código Licitação','f','f',event);"  />
  </td>      
  </tr>
  <tr>
  <td><strong>Número do documento:</strong></td>
  <td><input type="text" name=nroDocumento id="nroDocumento" maxlength="14"
  onkeyup="js_ValidaCampos(this,1,'Número do documento','f','f',event);">
  </td>
  </tr>
  <tr>
  <td><strong>Data do credenciamento:</strong></td>
  <td><input type="text" name=dataCredenciamento id="dataCredenciamento" 
  onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)" 
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10" size="7">
  <input id="dataCredenciamento_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataCredenciamento_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dataCredenciamento_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparaDataCredenciamento(dia,mes,ano){
      var objData = document.getElementById('dtInicio');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>
  </td>
  </tr>
  
  <tr>
  <td>
  <b>
  <a class="dbancora" onclick="js_pesquisa_liclicitem(true);" style="text-decoration:underline;" href="#">Item:</a>
  </b>
  </td>
  <td>
  <input type="text" name="nroItem" id="nroItem" size="10" maxlength="20" onkeyup="js_ValidaCampos(this,1,'Item','f','f',event);"
  onchange="js_pesquisa_liclicitem(false);"/><br>
  <input type="text" name="dscItem" id="dscItem" readonly="readonly" style="background-color: rgb(222, 184, 135);"/>
  </td>
  </tr>
  
  <tr>
  <td><strong>Nome ou razão social do participante da licitação:</strong></td>
  <td><input type="text" name=nomRazaoSocial id="nomRazaoSocial" maxlength="120"></td>
  </tr>
  <tr>
  <td><strong>Número da inscrição estadual:</strong></td>
  <td><input type="text" name=nroInscricaoEstadual id="nroInscricaoEstadual" maxlength="30" 
  onkeyup="js_ValidaCampos(this,1,'Número da inscrição','f','f',event);" >
  </td>
  </tr>
  <tr>
  <td><strong>UF da inscrição estadual:</strong></td>
  <td><input type="text" name=ufInscricaoEstadual id="ufInscricaoEstadual" maxlength="2" style="text-transform: uppercase;"
  size="2"></td>
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

<script type="text/javascript">

/*
 * Pesquisar dados dos itens da licitacao
 */
 function js_pesquisa_liclicitem(mostra){
	  if(document.form1.nroProcessoLicitatorio.value == ''){
	    alert("Nenhuma licitação foi selecionada acima");
	    return;
		}
	  if(mostra==true){
	    js_OpenJanelaIframe('','db_iframe_liclicitem','func_liclicitemlicita.php?funcao_js=parent.js_mostraliclicitem1|l21_codigo|pc01_descrmater&cod_licita='+document.form1.nroProcessoLicitatorio.value,'Pesquisa',true);
	  }else{
	     if(document.form1.nroItem.value != ''){ 
	        js_OpenJanelaIframe('','db_iframe_liclicitem','func_liclicitemlicita.php?pesquisa_chave='+document.form1.nroItem.value+'&funcao_js=parent.js_mostraliclicitem&cod_licita='+document.form1.nroProcessoLicitatorio.value,'Pesquisa',false);
	     }else{
	       document.form1.dscItem.value = ''; 
	     }
	  }
	}

 function js_mostraliclicitem(chave,erro){
     document.form1.dscItem.value = chave; 
     if(erro==true){ 
       document.form1.nroItem.focus(); 
       document.form1.nroItem.value = ''; 
     } 
   }
   
   function js_mostraliclicitem1(chave1, chave2){
     document.form1.nroItem.value = chave1;
     document.form1.dscItem.value = chave2;
     db_iframe_liclicitem.hide();
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
  * buscar dados do xml para criar a tabela
  */
 function pesquisar() {

 	var oAjax = new Ajax.Request("con4_pesquisarxmlcredenciamento.php",
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

	 	var oAjax = new Ajax.Request("con4_pesquisarxmlcredenciamento.php",
	 		 	{
			 	method:"post",
			 	parameters:{codigo1: $("codigoHab").value, codigo2: $("nroDocumentoP").value},
			 	onComplete:cria_tabela
			 	}
	 	);
 	
  	
  }

  function fechar() {
	  
		var campo = document.getElementById('TabDbLov'); 
		document.getElementById('lista').removeChild(campo); 
		document.getElementById('lista').style.visibility = "hidden";
		
  }

  function pegar_valor(param1, param2, param3, param4, param5, param6, param7, param8, param9, param10, param11,
	  		param12, param13, param14,param15,param16,param17){
		
	  	$('codigo').value = param1;
	  	$('nroProcessoLicitatorio').value = param2;
	  	$('nroDocumento').value = param3;
	  	$('dataCredenciamento').value = param4; 
	  	$('nroItem').value = param5;	  	
	  	$('nomRazaoSocial').value = param6;
	  	$('nroInscricaoEstadual').value = param7;
	  	$('ufInscricaoEstadual').value = param8;
	  	$('nroCertidaoRegularidadeINSS').value = param9;
	  	$('dtEmissaoCertidaoRegularidadeINSS').value = param10;
	  	$('dtValidadeCertidaoRegularidadeINSS').value = param11;
	  	$('nroCertidaoRegularidadeFGTS').value = param12;
	  	$('dtEmissaoCertidaoRegularidadeFGTS').value = param13;
	  	$('dtValidadeCertidaoRegularidadeFGTS').value = param14;
	  	$('nroCNDT').value = param15;
	  	$('dtEmissaoCNDT').value   = param16;
	  	$('dtValidadeCNDT').value   = param17;

	  	js_pesquisa_liclicitem(false);
	  	
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
		tabela += "Nro do documento";
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
				+jsonObj[i].nroDocumento+"','"+jsonObj[i].dataCredenciamento+"','"+jsonObj[i].nroItem+"','"+jsonObj[i].nomRazaoSocial+"','"+jsonObj[i].nroInscricaoEstadual+"','"
				+jsonObj[i].ufInscricaoEstadual+"','"+jsonObj[i].nroCertidaoRegularidadeINSS+"','"+jsonObj[i].dtEmissaoCertidaoRegularidadeINSS+"','"
				+jsonObj[i].dtValidadeCertidaoRegularidadeINSS+"','"+jsonObj[i].nroCertidaoRegularidadeFGTS+"','"+jsonObj[i].dtEmissaoCertidaoRegularidadeFGTS+"','"
				+jsonObj[i].dtValidadeCertidaoRegularidadeINSS+"','"+jsonObj[i].nroCNDT+"','"+jsonObj[i].dtEmissaoCNDT+"','"+jsonObj[i].dtValidadeCNDT+"')\">"+jsonObj[i].codigo+"</a>";
	
				tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
				tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].nroProcessoLicitatorio+"','"
				+jsonObj[i].nroDocumento+"','"+jsonObj[i].dataCredenciamento+"','"+jsonObj[i].nroItem+"','"+jsonObj[i].nomRazaoSocial+"','"+jsonObj[i].nroInscricaoEstadual+"','"
				+jsonObj[i].ufInscricaoEstadual+"','"+jsonObj[i].nroCertidaoRegularidadeINSS+"','"+jsonObj[i].dtEmissaoCertidaoRegularidadeINSS+"','"
				+jsonObj[i].dtValidadeCertidaoRegularidadeINSS+"','"+jsonObj[i].nroCertidaoRegularidadeFGTS+"','"+jsonObj[i].dtEmissaoCertidaoRegularidadeFGTS+"','"
				+jsonObj[i].dtValidadeCertidaoRegularidadeINSS+"','"+jsonObj[i].nroCNDT+"','"+jsonObj[i].dtEmissaoCNDT+"','"+jsonObj[i].dtValidadeCNDT+"')\">"+jsonObj[i].nroProcessoLicitatorio+"</a>";
	
				tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
				tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].nroProcessoLicitatorio+"','"
				+jsonObj[i].nroDocumento+"','"+jsonObj[i].dataCredenciamento+"','"+jsonObj[i].nroItem+"','"+jsonObj[i].nomRazaoSocial+"','"+jsonObj[i].nroInscricaoEstadual+"','"
				+jsonObj[i].ufInscricaoEstadual+"','"+jsonObj[i].nroCertidaoRegularidadeINSS+"','"+jsonObj[i].dtEmissaoCertidaoRegularidadeINSS+"','"
				+jsonObj[i].dtValidadeCertidaoRegularidadeINSS+"','"+jsonObj[i].nroCertidaoRegularidadeFGTS+"','"+jsonObj[i].dtEmissaoCertidaoRegularidadeFGTS+"','"
				+jsonObj[i].dtValidadeCertidaoRegularidadeINSS+"','"+jsonObj[i].nroCNDT+"','"+jsonObj[i].dtEmissaoCNDT+"','"+jsonObj[i].dtValidadeCNDT+"')\">"+jsonObj[i].nroDocumento+"</a>";
	
				tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
				tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].nroProcessoLicitatorio+"','"
				+jsonObj[i].nroDocumento+"','"+jsonObj[i].dataCredenciamento+"','"+jsonObj[i].nroItem+"','"+jsonObj[i].nomRazaoSocial+"','"+jsonObj[i].nroInscricaoEstadual+"','"
				+jsonObj[i].ufInscricaoEstadual+"','"+jsonObj[i].nroCertidaoRegularidadeINSS+"','"+jsonObj[i].dtEmissaoCertidaoRegularidadeINSS+"','"
				+jsonObj[i].dtValidadeCertidaoRegularidadeINSS+"','"+jsonObj[i].nroCertidaoRegularidadeFGTS+"','"+jsonObj[i].dtEmissaoCertidaoRegularidadeFGTS+"','"
				+jsonObj[i].dtValidadeCertidaoRegularidadeINSS+"','"+jsonObj[i].nroCNDT+"','"+jsonObj[i].dtEmissaoCNDT+"','"+jsonObj[i].dtValidadeCNDT+"')\">"+jsonObj[i].nomRazaoSocial+"</a>";
			
				tabela += "</td></tr>";
			}
			
		}catch (e) {
		}
		tabela += "</table>";
		var conteudo = document.getElementById('lista');
		conteudo.innerHTML += tabela;
    conteudo.style.visibility = "visible";
		
	}

  </script>
