<div id="lista" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Receitas da Despesa</span>
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
<td> <input type="text" name="codigoPar" id="codigoPar" ></td>
</tr>
<tr>
<td><strong>Elemento E-cidade:</strong></td>
<td>
 <input type="text" name="nroReceita" id="nroReceita" >
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
<fieldset style="width: 500px; height: 102px;"><legend><b>Códigos da Receita</b></legend>
  <table cellspacing="5px">
  
  <tr>
  <td><input type="hidden" name="codigo" id="codigo"></td>
  <td><strong>E-cidade</strong></td>
  <td><strong>SICOM</strong></td>
  </tr>
  
  <tr>
  <td><strong>Código da Receita:</strong></td>
  <td ><input type="text" name="receitaEcidade" id="receitaEcidade" maxlength="8" 
  onkeyup="js_ValidaCampos(this,1,'O Código','f','f',event);" size="8"></td>
  <td><input type="text" name="receitaSicom" id="receitaSicom" maxlength="8" 
  onkeyup="js_ValidaCampos(this,1,'O Código','f','f',event);" size="8"></td>
  </tr>
  
  <tr>
	<td align="right" colspan="3">
	<input type="submit" value="Salvar" name="btnSalvar" /><input type="submit" value="Excluir" name="btnExcluir" />
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

/**
 * buscar dados do xml para criar a tabela
 */
function pesquisar() {

	var oAjax = new Ajax.Request("con4_pesquisarxmlnaturezareceita.php",
			{
		method: 'post',
		parameters:{inicio: $('inicio').value},
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

	var oAjax = new Ajax.Request("con4_pesquisarxmlnaturezareceita.php",
			{
		method: 'post',
		parameters:{codigo1: $('codigoPar').value, codigo2: $('nroReceita').value},
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
 * passar valores para os campos
 */
function pegar_valor(param1, param2, param3) {
	 
	$('codigo').value = param1;
	$('receitaEcidade').value = param2;
	$('receitaSicom').value = param3;
	fechar();
	
}

function fechar(){
	
	var campo = document.getElementById('TabDbLov'); 
	document.getElementById('lista').removeChild(campo); 
	document.getElementById('lista').style.visibility = "hidden";
	inicio: $('inicio').value = 0;
	
}

function cria_tabela(json){

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
	tabela += "Receita E-cidade";
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Receita SICOM";
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
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].receitaEcidade+"','"
			+jsonObj[i].receitaSicom+"')\">"+jsonObj[i].codigo+"</a>";	
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].receitaEcidade+"','"
			+jsonObj[i].receitaSicom+"')\">"+jsonObj[i].receitaEcidade+"</a>";	
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].receitaEcidade+"','"
			+jsonObj[i].receitaSicom+"')\">"+jsonObj[i].receitaSicom+"</a>";
			
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