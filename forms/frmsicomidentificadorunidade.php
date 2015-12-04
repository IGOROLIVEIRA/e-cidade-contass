<div id="lista" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Dados Unidade</span>
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
<td><strong>Código Sequencial:</strong></td>
<td> <input type="text" name="codigoSeq" id="codigoSeq"></td>
</tr>
<tr>
<td><strong>Código Tribunal:</strong></td>
<td><input type="text" name="codigoTri" id="codigoTri"></td>
</tr>
<tr>
<td></td>
<td><input type="button" name="bntPesquisarXml" value="Pesquisar" onclick="pesquisar_codigo()"></td>
</tr>
</table>
</div><!-- campos -->
</div><!-- lista -->

<form name="form1" method="post" action="">
<fieldset style="width: 500px; height: 300px;"><legend><b>Identificador Unidade</b></legend>
<table cellspacing="5px">
<tr>
	<td>Código:</td>
	<td><input type="text" name="codigo" id="codigo" value="" style="background-color: rgb(222, 184, 135);" readonly="readonly"/></td>
</tr>
<tr>
	<td>Descrição:</td>
	<td><textarea name="dscTipoUnidade" id="dscTipoUnidade" value="" cols="30" rows="5" 
	onKeyDown="textCounter(this.form.dscTipoUnidade,this.form.remLen,300)" onKeyUp="textCounter(this.form.dscTipoUnidade,this.form.remLen,300)">
	</textarea></td>
</tr>
<tr>
	<td>Codigo do Tribunal:</td>
	<td><input type="text" name="codTribunal" id="codTribunal" value="" maxlength="2" onkeyup="js_ValidaCampos(this,1,'Ano Inicial','f','f',event);" />
	</td>
</tr>
<tr>
	<td></td>
	<td align="right"><input type="submit" value="Salvar" name="btnSalvar" /><input type="submit" value="Excluir" name="btnExcluir" />
	<input type="button" value="Pesquisar" name="btnPesquisar" onclick="pesquisar()" /></td>
</tr>
  <tr>
    <td nowrap title="<?=@$Te54_numcgm?>">
    <?
       db_ancora("<b>NumCgm</b>","js_pesquisae54_numcgm(true);",1);
     ?>        
    </td>
    <td>
	<input type="text" name="numCgm" id="numCgm" style="background-color: rgb(222, 184, 135);"  size="10" 
	 onchange="js_pesquisae54_numcgm(false);" />
	<br>
	<input type="text" name="nomeResponsavel" id="nomeResponsavel" style="background-color: rgb(222, 184, 135);" readonly="readonly" />
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

function textCounter(field, countfield, maxlimit) {
	
	if (field.value.length > maxlimit){
		field.value = field.value.substring(0, maxlimit);
	}else{ 
		countfield.value = maxlimit - field.value.length;
	}
	}

function pesquisar(){
	
	$.post('con4_pesquisar_xml.php', function(data){
		
		var jsonObj = eval(data);
		cria_tabela(jsonObj);
		$('#lista').css("visibility", "visible");
	}
	);
}

function pesquisar_codigo(){

	var campo = document.getElementById('TabDbLov');
	document.getElementById('lista').removeChild(campo);
	
	var codSeq = $('#codigoSeq').val();
	var codTri = $('#codigoTri').val();
	
	$.post('con4_pesquisar_xml.php', {codigoSeq: codSeq, codigoTri: codTri}, function(data){
		var jsonObj = eval(data);
		cria_tabela(jsonObj);
		$('#lista').css("visibility", "visible");
		} 
	);
}

function pegar_valor(codigo, descricao, codTri){
	$('#codigo').val(codigo);
	$('#dscTipoUnidade').val(descricao);
	$('#codTribunal').val(codTri);
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
	tabela += "Código Sequencial";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Descrição";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Código Tribunal";
	tabela += "</td></tr>";
	for (var i in jsonObj){
		if(i % 2 != 0){
				color = "#97b5e6";
		}else{
			color = "#e796a4";
		}
		tabela += "<tr>";
		tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
		tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].dscTipoUnidade+"',"+jsonObj[i].codTribunal+")\">"+jsonObj[i].codigo+"</a>";
		tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
		tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].dscTipoUnidade+"',"+jsonObj[i].codTribunal+")\">"+jsonObj[i].dscTipoUnidade+"</a>";
		tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
		tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].dscTipoUnidade+"',"+jsonObj[i].codTribunal+")\">"+jsonObj[i].codTribunal+"</a>";
		tabela += "</td></tr>";
	}
	tabela += "</table>";
	var conteudo = document.getElementById('lista');
	conteudo.innerHTML += tabela;
}
</script>