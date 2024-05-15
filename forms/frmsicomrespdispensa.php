<div id="lista" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Empenhos</span>
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
<td><strong>Código:</strong></td>
<td> <input type="text" name="codigoSeq" id="codigoSeq" maxlength="13" onkeyup="js_ValidaCampos(this,1,'código','f','f',event);"></td>
</tr>
<tr>
<td><strong>Cgm:</strong></td>
<td>
 <input type="text" name="NumCgmPesq" id="NumCgmPesq" maxlength="13" onkeyup="js_ValidaCampos(this,1,'numCgm','f','f',event);">
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
<fieldset style="width: 500px; height: 180px;"><legend><b>Resposáveis</b></legend>
  <table cellspacing="5px">
  
  <tr>
  <td><strong>Código</strong></td>
  <td> <input type="text" name="codigo" id="codigo" readonly="readonly" style="background-color: rgb(222, 184, 135);" ></td>
  </tr>
  
  <tr>
  <td><strong>Código Dispensa</strong></td>
  <td> <input type="text" name="codDispensa" id="codDispensa" readonly="readonly" style="background-color: rgb(222, 184, 135);" 
  value="<?php echo $_GET['codigo'] ?>" ></td>
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
  <td><strong>Tipo Responsável</strong></td>
  <td>
  <select name="tipoResp" id="tipoResp">
   <option value="1" id="1">Autorização para abertura do procedimento de dispensa ou inexigibilidade</option>
   <option value="2" id="2">Cotação de preços</option>
   <option value="3" id="3">Informação de existência de recursos orçamentários</option>
   <option value="4" id="4">Ratificação</option>
   <option value="5" id="5">Publicação em órgão oficial</option>
   <option value="6" id="6">Parecer Jurídico</option>
   <option value="7" id="7">Parecer (outros)</option>
  </select>
  </td>
  </tr>
  
  <tr>
	<td align="right" colspan="2">
	<input type="submit" value="Salvar" name="btnSalvar" />
	<input type="submit" value="Excluir" name="btnExcluir" />
	<input type="button" value="Pesquisar" name="btnPesquisar" onclick="pesquisar()" />
	<input type="reset"  value="Novo"  name="btnNovo">
	</td>
</tr>
</table>
</fieldset>
</form>

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
	/**
	 * buscar dados do xml para criar a tabela
	 */
	function pesquisar(){

		 var cod1 = $('#codDispensa').val();
			
		$.post('con4_pesquisarxmlrespdispensa.php', {codigo1: cod1}, function(data){
			
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

		 var cod2 = $('#codigoSeq').val();
		 var cod3 = $('#NumCgmPesq').val(); 
		
		$.post('con4_pesquisarxmlrespdispensa.php', {codigo2: cod2, codigo3: cod3}, function(data){
			var jsonObj = eval(data);
			cria_tabela(jsonObj);
			$('#lista').css("visibility", "visible");
			} 
		);
	}

	/**
	 * 
	 */
	function pegar_valor(param1, param2, param3, param4, param5){
		
		$('#codigo').val(param1);
		$('#codDispensa').val(param2);
		$('#numCgm').val(param3);
		$('#nomeResponsavel').val(param4);
		$('#'+param5+'').attr("selected","selected");
		
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
		tabela += "Código Dispensa";
		
		tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
		tabela += "Cgm";

		tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
		tabela += "Nome Responsável";

		tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
		tabela += "Tipo Responsável";
		
		tabela += "</td></tr>";
		for (var i in jsonObj){
			if(i % 2 != 0){
					color = "#97b5e6";
			}else{
				color = "#e796a4";
			}
			tabela += "<tr>";
			
			tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].codDispensa+"','"+jsonObj[i].numCgm+"','"+jsonObj[i].nomeResponsavel+"','"+
			jsonObj[i].tipoResp+"')\">"+jsonObj[i].codigo+"</a>";

			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].codDispensa+"','"+jsonObj[i].numCgm+"','"+jsonObj[i].nomeResponsavel+"','"+
			jsonObj[i].tipoResp+"')\">"+jsonObj[i].codDispensa+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].codDispensa+"','"+jsonObj[i].numCgm+"','"+jsonObj[i].nomeResponsavel+"','"+
			jsonObj[i].tipoResp+"')\">"+jsonObj[i].numCgm+"</a>";
						
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].codDispensa+"','"+jsonObj[i].numCgm+"','"+jsonObj[i].nomeResponsavel+"','"+
			jsonObj[i].tipoResp+"')\">"+jsonObj[i].nomeResponsavel+"</a>";

			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].codDispensa+"','"+jsonObj[i].numCgm+"','"+jsonObj[i].nomeResponsavel+"','"+
			jsonObj[i].tipoResp+"')\">"+(jsonObj[i].tipoResp == '1' ? "Autorização para abertura do procedimento" :
			jsonObj[i].tipoResp == '2' ? "Cotação de preços" : jsonObj[i].tipoResp == '3' ? "Informação de existência de recursos orçamentários" :
		  jsonObj[i].tipoResp == '4' ? "Ratificação" : jsonObj[i].tipoResp == '5' ? "Publicação em órgão oficial" : jsonObj[i].tipoResp == '6' ? 
			"Parecer Jurídico" : "Parecer (outros)")+"</a>";
      			
			tabela += "</td></tr>";
		}
		tabela += "</table>";
		var conteudo = document.getElementById('lista');
		conteudo.innerHTML += tabela;
	}
</script>