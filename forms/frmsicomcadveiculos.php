<div id="lista" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Cadastro de Veículos ou Equipamentos</span>
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
<td> <input type="text" name="codigoCad" id="codigoCad" ></td>
</tr>
<tr>
<td></td>
<td><input type="button" name="bntPesquisarXml" value="Pesquisar" onclick="pesquisar_codigo()"></td>
</tr>
</table>
</div><!-- campos -->
</div><!-- lista -->


<form name="form1" method="post" action="">
<fieldset style="width: 533px; height: 274px;"><legend><b>Transporte Escolar</b></legend>
  <table cellspacing="5px">
  <tr>
  <td><strong>Código</strong></td>
  <td> <input type="text" name="codigo" id="codigo" readonly="readonly" style="background-color: rgb(222, 184, 135);" ></td>
  </tr>
  
  <tr>
             <td nowrap title="<?=@$Tve70_veiculos?>">
                <?
                db_ancora("<b>Veículos</b>","js_pesquisave70_veiculos(true);",1);
                ?>
             </td>
             <td> 
               <input type="text" name="codVeiculo" id="codVeiculo" maxlength="10" onchange="js_pesquisave70_veiculos(false);"
               onblur="js_pesquisave70_veiculos(false);" onkeyup="js_ValidaCampos(this,1,'Código do Veículo','f','f',event);" />
             <input type="text" name="placaVeiculo" id="placaVeiculo" maxlength="10" readonly="readonly" 
             style="background-color: rgb(222, 184, 135);" />
             </td>
  </tr>

  <tr>
  <td><strong>Nome do estabelecimento de ensino:</strong></td>
  <td><input type="text" name="nomeEstabelecimento" id="nomeEstabelecimento" maxlength="250"></td>
  </tr>
  <tr>
  <td><strong>Localidade:</strong></td>
  <td><input type="text" name="localidade" id="localidade" maxlength="250"></td>
  </tr>
   <tr>
  <td><strong>Números de passageiros transportados no veículo:</strong></td>
  <td><input type="text" name="numeroPassageiros" id="numeroPassageiros" maxlength="5"
  onkeyup="js_ValidaCampos(this,1,'Números de passageiros transportados no veículo','f','f',event);">
  </td>
  </tr>
   <tr>
  <td><strong>Distância Percorrida no Mês:</strong></td>
  <td><input type="text" name=distanciaEstabelecimento id="distanciaEstabelecimento" maxlength="10"
  onkeyup="js_ValidaCampos(this,4,'Distância Percorrida','f','f',event);">
  </td>
  </tr>
  <tr>
  <td><strong>Turnos do estabelecimento:</strong></td>
  <td>
  <select name="turnos" id="turnos" >
  	<option value="01" id="01">Manhã</option>
  	<option value="02" id="02">Tarde</option>
  	<option value="03" id="03">Noite</option>
  	<option value="04" id="04">Manhã e Tarde</option>
  	<option value="05" id="05">Manhã e Noite</option>
  	<option value="06" id="06">Tarde e Noite</option>
  	<option value="07" id="07">Manhã, Tarde e Noite</option>
  </select>
  </td>
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
* pesquisar veiculo
*/
function js_pesquisave70_veiculos(mostra){
         if(mostra==true){
           js_OpenJanelaIframe('','db_iframe_veiculos','func_veiculosalt.php?funcao_js=parent.js_mostraveiculos1|ve01_codigo|ve01_placa','Pesquisa',true);
         }else{
            if(document.form1.codVeiculo.value != ''){ 
               js_OpenJanelaIframe('','db_iframe_veiculos','func_veiculosalt.php?pesquisa_chave='+document.form1.codVeiculo.value+'&funcao_js=parent.js_mostraveiculos','Pesquisa',true);
            }else{
              document.form1.placaVeiculo.value = ''; 
            }
         }
       }

       function js_mostraveiculos(chave,erro){
         document.form1.placaVeiculo.value = chave; 
         if(erro==true){ 
           document.form1.codVeiculo.focus(); 
           document.form1.codVeiculo.value = ''; 
         } else {
           js_OpenJanelaIframe('','db_iframe_veiculos','func_veiculos.php?sigla=true&pesquisa_chave='+document.form1.codVeiculo.value+'&funcao_js=parent.js_mostraveictipoabast','Pesquisa',false);
         }
       }
       
       function js_mostraveiculos1(chave1,chave2){
         document.form1.codVeiculo.value = chave1;
         document.form1.placaVeiculo.value = chave2;
         js_OpenJanelaIframe('','db_iframe_veiculos','func_veiculos.php?sigla=true&pesquisa_chave='+document.form1.codVeiculo.value+'&funcao_js=parent.js_mostraveictipoabast','Pesquisa',false);
         db_iframe_veiculos.hide();
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
	 
	var oAjax = new Ajax.Request("con4_pesquisarxmlcadveiculos.php",
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
	
	var oAjax = new Ajax.Request("con4_pesquisarxmlcadveiculos.php",
			{
		method:'post',
		parameters:{codigo1: $("codigoCad")},
		onComplete:cria_tabela
		  }
	);
	
}

/**
 * 
 */
function pegar_valor(param1, param2, param3, param4, param5, param6, param7, param8, param9){
	
	$('codigo').value                   = param1;
	$('codVeiculo').value               = param2;
	$('placaVeiculo').value             = param8;
	$('nomeEstabelecimento').value      = param3;
	$('localidade').value               = param4;
	$('distanciaEstabelecimento').value = param5;
	$('numeroPassageiros').value        = param6;
	
	document.getElementById("turnos").options[param7].selected = "true";
	
	document.getElementById('lista').style.visibility = "hidden";
	var campo = document.getElementById('TabDbLov'); 
	document.getElementById('lista').removeChild(campo); 
	
}

function fechar () {
	
	var campo = document.getElementById('TabDbLov'); 
	document.getElementById('lista').removeChild(campo); 
	document.getElementById('lista').style.visibility = "hidden";
	
}

function cria_tabela(json){

	if (typeof iPagina == 'undefined') {
		var iPagina = 0;
	} else {
		iPagina ++;
	}
  
  var jsonObj = eval("("+json.responseText+")");
	
	var tabela;
	var color = "#e796a4";
	tabela  = "<table id=\"TabDbLov\" cellspacing=\"1\" cellpadding=\"2\" border=\"1\">";
	tabela +=	"<tr style=\"text-decoration: underline;\"><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Código";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Código do Veiculo";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Nome do Veiculo";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Nome do estabelecimento";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Localidade";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Distância do estabelecimento";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Números de passageiros transportados";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Turnos do estabelecimento";
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
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].codVeiculo+"','"
			+jsonObj[i].nomeEstabelecimento+"','"+jsonObj[i].localidade+"','"+jsonObj[i].distanciaEstabelecimento+"','"
			+jsonObj[i].numeroPassageiros+"','"+jsonObj[i].turnos+"','"+jsonObj[i].placaVeiculo+"')\">"+jsonObj[i].codigo+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].codVeiculo+"','"
			+jsonObj[i].nomeEstabelecimento+"','"+jsonObj[i].localidade+"','"+jsonObj[i].distanciaEstabelecimento+"','"
			+jsonObj[i].numeroPassageiros+"','"+jsonObj[i].turnos+"','"+jsonObj[i].placaVeiculo+"')\">"+jsonObj[i].codVeiculo+"</a>";
	
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].codVeiculo+"','"
			+jsonObj[i].nomeEstabelecimento+"','"+jsonObj[i].localidade+"','"+jsonObj[i].distanciaEstabelecimento+"','"
			+jsonObj[i].numeroPassageiros+"','"+jsonObj[i].turnos+"','"+jsonObj[i].placaVeiculo+"')\">"+jsonObj[i].placaVeiculo+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].codVeiculo+"','"
			+jsonObj[i].nomeEstabelecimento+"','"+jsonObj[i].localidade+"','"+jsonObj[i].distanciaEstabelecimento+"','"
			+jsonObj[i].numeroPassageiros+"','"+jsonObj[i].turnos+"','"+jsonObj[i].placaVeiculo+"')\">"+jsonObj[i].nomeEstabelecimento+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].codVeiculo+"','"
			+jsonObj[i].nomeEstabelecimento+"','"+jsonObj[i].localidade+"','"+jsonObj[i].distanciaEstabelecimento+"','"
			+jsonObj[i].numeroPassageiros+"','"+jsonObj[i].turnos+"','"+jsonObj[i].placaVeiculo+"')\">"+jsonObj[i].localidade+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].codVeiculo+"','"
			+jsonObj[i].nomeEstabelecimento+"','"+jsonObj[i].localidade+"','"+jsonObj[i].distanciaEstabelecimento+"','"
			+jsonObj[i].numeroPassageiros+"','"+jsonObj[i].turnos+"','"+jsonObj[i].placaVeiculo+"')\">"+jsonObj[i].distanciaEstabelecimento+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].codVeiculo+"','"
			+jsonObj[i].nomeEstabelecimento+"','"+jsonObj[i].localidade+"','"+jsonObj[i].distanciaEstabelecimento+"','"
			+jsonObj[i].numeroPassageiros+"','"+jsonObj[i].turnos+"','"+jsonObj[i].placaVeiculo+"')\">"+jsonObj[i].numeroPassageiros+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].codVeiculo+"','"
			+jsonObj[i].nomeEstabelecimento+"','"+jsonObj[i].localidade+"','"+jsonObj[i].distanciaEstabelecimento+"','"
			+jsonObj[i].numeroPassageiros+"','"+jsonObj[i].turnos+"','"+jsonObj[i].placaVeiculo+"')\">"+(jsonObj[i].turnos == '01' ? 
			"Manhã" : jsonObj[i].turnos == '02' ? "Tarde" : jsonObj[i].turnos == '03' ? "Noite" : jsonObj[i].turnos == '04' ? 
			"Manhã e Tarde" : jsonObj[i].turnos == '05' ? "Manhã e Noite" : jsonObj[i].turnos == '06' ? "Tarde e Noite" : "Manhã, Tarde e Noite")+"</a>";
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