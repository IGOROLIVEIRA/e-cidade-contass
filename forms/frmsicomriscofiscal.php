<div id="lista" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Riscos Fiscais</span>
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
<td><strong>Código Risco:</strong></td>
<td><input type="text" name="codigoRisco" id="codigoRisco"></td>
</tr>
<tr>
<td><strong>Código Perspectiva:</strong></td>
<td><input type="text" name="codigoPerspectiva" id="codigoPerspectiva"></td>
</tr>
<tr>
<td></td>
<td><input type="button" name="bntPesquisarXml" value="Pesquisar" onclick="pesquisar_codigo()"></td>
</tr>
</table>
</div><!-- campos -->
</div><!-- lista -->

<form name="form1" method="post" action="">
<fieldset style="width: 500px; height: 300px;">
<input type="hidden" name="instituicao" value="" />
<table cellspacing="5px" style="font-weight: bold;">
<tr>
	<td>Código do Risco:</td>
	<td><input type="text" name="codRisco" id="codRisco" value="" style="background-color: rgb(222, 184, 135);" readonly="readonly"/></td>
</tr>
<tr>
	<td><?php db_ancora("<b>Perspectiva PPA:</b>","js_pesquisa_ppa(true);", 1); ?></td>
	<td>
	<input type="text" name="codPerspectiva" id="codPerspectiva" style="background-color: rgb(222, 184, 135);" readonly="readonly" size="10" 
	 onchange="js_pesquisa_ppa(false);" />
	<br>
	<input type="text" name="dscPerspectiva" id="dscPerspectiva" style="background-color: rgb(222, 184, 135);" readonly="readonly" />
	</td>
</tr>
<tr>
	<td>Exercicio:</td>
	<td><input type="text" name="exercicio" id="exercicio" value="" maxlength="4" onkeyup="js_ValidaCampos(this,1,'Ano Inicial','f','f',event);" />
	</td>
</tr>
<tr>
	<td>Descrição:</td>
	<td><span id="left"></span>
	<textarea type="text" name="dscRiscoFiscal" id="dscRiscoFiscal" value="" cols="40" rows="7" 
	onKeyDown="textCounter(this.form.dscRiscoFiscal,this.form.remLen,300)" onKeyUp="textCounter(this.form.dscRiscoFiscal,this.form.remLen,300)">
	</textarea></td>
</tr>
<tr>
	<td>Valor:</td>
	<td>
	<input type="text" name="vlRiscoFiscal" id="vlRiscoFiscal" value="" onkeyup="js_ValidaCampos(this,4,'Valor','f','f',event);" />
	</td>
</tr>
<tr>
	<td>Codigo do Risco:</td>
	<td><select name="codRiscoFiscal" id="codRiscoFiscal">
	<option value="01" id="01">Demandas Judiciais</option>
	<option value="02" id="02">Dívidas em Processo de Reconhecimento</option>
	<option value="03" id="03">Avais e Garantias Concedidas</option>
	<option value="04" id="04">Assunção de Passivos</option>
	<option value="05" id="05">Assistências Diversas</option>
	<option value="06" id="06">Outros Passivos Contingentes </option>
	<option value="07" id="07">Frustração de Arrecadação </option>
	<option value="08" id="08">Restituição de Tributos a Maior</option>
	<option value="09" id="09">Discrepância de Projeções</option>
	<option value="10" id="10">Outros Riscos Fiscais</option>
	</select></td>
</tr>
<tr>
	<td></td>
	<td align="right"><input type="submit" value="Salvar" name="btnRisco" /><input type="submit" value="Excluir" name="btnExcluir" />
	<input type="button" value="Pesquisar" name="btnPesquisar" onclick="pesquisar()" /></td>
</tr>
</table>
</fieldset>
</form>

<script type="text/javascript">

function js_pesquisa_ppa(mostra) {

    if(mostra==true){
      js_OpenJanelaIframe('',
                          'db_iframe_ppa',
                          'func_ppaversaosigap.php?funcao_js='+
                          'parent.js_mostrappa1|o119_sequencial|o01_descricao',
                          'Perspectivas do Cronograma',true);
    }else{
        if( $('#codPerspectiva').val() != ''){
          
            js_OpenJanelaIframe('',
                                'db_iframe_ppa',
                                'func_ppaversaosigap.php?pesquisa_chave='+
                                $('#codPerspectiva').val()+
                                '&funcao_js=parent.js_mostrappa',
                                'Perspectivas do Cronograma',
                                false);
         }else{
         
           document.form1.dscPerspectiva.value = '';
            
         }
      }
  }

  function js_mostrappa(chave,erro, ano) {
    $('#dscPerspectiva').val(chave); 
    if(erro==true) { 
      
      $('#codPerspectiva').focus(); 
      $('#codPerspectiva').val();
        
    }
  }

  function js_mostrappa1(chave1,chave2,chave3) {

    $('#codPerspectiva').val(chave1);
    $('#dscPerspectiva').val(chave2);
    db_iframe_ppa.hide();
  }

  
  function textCounter(field, countfield, maxlimit) {
		
		if (field.value.length > maxlimit){
			field.value = field.value.substring(0, maxlimit);
		}else{ 
			countfield.value = maxlimit - field.value.length;
		}
		}

	function pesquisar(){
		
		$.post('con4_pesquisar_xml_riscos.php', function(data){

			var jsonObj = eval(data);		
			cria_tabela(jsonObj);
			$('#lista').css("visibility", "visible");
		}
		);
	}

function pesquisar_codigo(){

	var campo = document.getElementById('TabDbLov');
	document.getElementById('lista').removeChild(campo);
	
	var codRisco = $('#codigoRisco').val();
	var codPerspectiva = $('#codigoPerspectiva').val();
	
	$.post('con4_pesquisar_xml_riscos.php', {codigoRisco: codRisco, codigoPerspectiva: codPerspectiva}, function(data){
		var jsonObj = eval(data);
		cria_tabela(jsonObj);
		$('#lista').css("visibility", "visible");
		} 
	);
}

function pegar_valor(risco, perspectiva, exercicio, descricao, valor, fiscal){
	
	$('#codRisco').val(risco);
	$('#codPerspectiva').val(perspectiva);
	$('#exercicio').val(exercicio);
	$('#dscRiscoFiscal').val(descricao);
	$('#vlRiscoFiscal').val(valor);
	$('#0'+fiscal+'').attr("selected","selected");

	js_pesquisa_ppa(false);
	
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
	for (var i in jsonObj){
		if(i % 2 != 0){
				color = "#97b5e6";
		}else{
			color = "#e796a4";
		}
		tabela += "<tr>";
		tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
		tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codRisco+","+jsonObj[i].codPerspectiva+","+jsonObj[i].exercicio;
		tabela += ",'"+jsonObj[i].dscRiscoFiscal+"','"+jsonObj[i].vlRiscoFiscal+"',"+jsonObj[i].codRiscoFiscal+")\">"+jsonObj[i].codRisco+"</a>";
		tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
		tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codRisco+","+jsonObj[i].codPerspectiva+","+jsonObj[i].exercicio;
		tabela += ",'"+jsonObj[i].dscRiscoFiscal+"','"+jsonObj[i].vlRiscoFiscal+"',"+jsonObj[i].codRiscoFiscal+")\">"+jsonObj[i].codPerspectiva+"</a>";
		tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
		tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codRisco+","+jsonObj[i].codPerspectiva+","+jsonObj[i].exercicio;
		tabela += ",'"+jsonObj[i].dscRiscoFiscal+"','"+jsonObj[i].vlRiscoFiscal+"',"+jsonObj[i].codRiscoFiscal+")\">"+jsonObj[i].exercicio+"</a>";
		tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
		tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codRisco+","+jsonObj[i].codPerspectiva+","+jsonObj[i].exercicio;
		tabela += ",'"+jsonObj[i].dscRiscoFiscal+"','"+jsonObj[i].vlRiscoFiscal+"',"+jsonObj[i].codRiscoFiscal+")\">"+jsonObj[i].dscRiscoFiscal.substr(0,50)+"</a>";
		tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
		tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codRisco+","+jsonObj[i].codPerspectiva+","+jsonObj[i].exercicio;
		tabela += ",'"+jsonObj[i].dscRiscoFiscal+"','"+jsonObj[i].vlRiscoFiscal+"',"+jsonObj[i].codRiscoFiscal+")\">"+jsonObj[i].vlRiscoFiscal+"</a>";
		tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
		tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codRisco+","+jsonObj[i].codPerspectiva+","+jsonObj[i].exercicio;
		tabela += ",'"+jsonObj[i].dscRiscoFiscal+"','"+jsonObj[i].vlRiscoFiscal+"',"+jsonObj[i].codRiscoFiscal+")\">"+jsonObj[i].codRiscoFiscal+"</a>";
		tabela += "</td></tr>";
	}
	tabela += "</table>";
	var conteudo = document.getElementById('lista');
	conteudo.innerHTML += tabela;
}
</script>
