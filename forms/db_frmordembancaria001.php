<?
$clcaiparametro->rotulo->label();
$clrotulo = new rotulocampo;
?>
<div id="lista"
	style="position: absolute; width: 100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
	<div id="topo"
		style="width: 100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

		<span style="float: left; margin-top: 5px; border: 0px solid red;">Dados
			Ordem Bancária</span>
		<div id="fechar" onclick="fechar()"
			style="background: url('imagens/jan_fechar_on.gif'); height: 20px; float: right; width: 20px;"></div>
		<div id="fechar"
			style="background: url('imagens/jan_max_off.gif'); height: 20px; float: right; width: 20px;"></div>
		<div id="fechar" onclick="fechar()"
			style="background: url('imagens/jan_mini_on.gif'); height: 20px; float: right; width: 20px;"></div>

	</div>
	<!-- topo -->
	<div id="campos" style="margin-bottom: 7px;">
		<table>
			<tr>
				<td><strong>Código</strong>
				</td>
				<td><input type="text" name="codigoseq" id="codigoseq"
					maxlength="13"
					onkeyup="js_ValidaCampos(this,1,'código','f','f',event);">
				</td>
			</tr>
			<tr>
				<td><strong>Conta Pagadora:</strong>
				</td>
				<td><input type="text" name="ctpagadora" id="ctpagadora"
					maxlength="13"
					onkeyup="js_ValidaCampos(this,1,'conta','f','f',event);"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="button" name="pesquisarbanco" value="Pesquisar"
					onclick="pesquisar_codigo()">
				</td>
			</tr>
		</table>
	</div>
	<!-- campos -->
</div>
<!-- lista -->

<form name="form1" method="post" action="" >
	<fieldset style="width: 500px; height: 110px;">
		<legend>
			<b>Inclusão de Ordem</b>
		</legend>
		<table cellspacing="5px">

			<tr>
				<td><strong>Código Ordem Bancária:</strong></td>
				<td><input type="text" name="k00_codigo" id="k00_codigo"
					readonly="readonly" style="background-color: rgb(222, 184, 135);"
<?php if (isset($oOrdem->k00_codigo)) {echo "value=\"".$oOrdem->k00_codigo."\"";}?> />
				</td>
			</tr>

			<tr>
      <td nowrap title="<?=@$Tk29_contapadraopag?>">
       <?
       db_ancora("Conta Pagamento","js_pesquisak29_contapadraopag(true);",$db_opcao);
       ?>
      </td>
      <td>
      <?
      db_input('k29_contapadraopag',10,$Ik29_contapadraopag,true,'text',$db_opcao,"onchange='js_pesquisak29_contapadraopag(false);'","","white");

      db_input('desc_conta',20,0,true,'text',3);
      ?>
      </td>
    </tr>

			<tr>
				<td align="right" colspan="2">
				<input type="button" value="Incluir" name="botao_incluir" onclick="js_valida_campos()"/>
				<input type="hidden" value="" name="incluir"  id="incluir"/>
				<input type="submit" value="Excluir" name="excluir" />
					<input type="button" value="Novo" name="novo" onclick="js_novo()"/>
					<input type="button" value="Pesquisar" name="pesquisa_banco"
					onclick="pesquisar()" />
				</td>
			</tr>
		</table>
	</fieldset>
	<input type="button" name="gerar_ordem" value="imprimir" onclick="js_abre()">
</form>
<input
	type="hidden" value="0" name="inicio" id="inicio" />
<input
	type="hidden" value="<?=$iTotalLista ?>" name="total" id="total" />
<script>
function js_pesquisak29_contapadraopag(mostra){
	  if(mostra==true){
	    js_OpenJanelaIframe('','db_iframe_saltes','func_saltes.php?funcao_js=parent.js_mostrasaltes1|k13_conta|k13_descr','Pesquisa',true);
	  }else{
	     if(document.form1.k29_contapadraopag.value != ''){
	        js_OpenJanelaIframe('','db_iframe_saltes','func_saltes.php?pesquisa_chave='+document.form1.k29_contapadraopag.value+'&funcao_js=parent.js_mostrasaltes','Pesquisa',false);
	     }
	  }
	}
	function js_mostrasaltes(chave,erro){
	  if(erro==true){
	    document.form1.k29_contapadraopag.focus();
	    document.form1.k29_contapadraopag.value = '';
	  } else {
		  document.form1.desc_conta.value = chave;
	  }
	}
	function js_mostrasaltes1(chave1,chave2){
	  document.form1.k29_contapadraopag.value = chave1;
	  document.form1.desc_conta.value = chave2;
	  db_iframe_saltes.hide();
	}

	function js_pesquisar_conta(){
	  if(document.form1.k29_contapadraopag.value != ''){
		  js_OpenJanelaIframe('','db_iframe_saltes','func_saltes.php?pesquisa_chave='+document.form1.k29_contapadraopag.value+'&funcao_js=parent.js_mostra','Pesquisa',false);
		}
	}
	function js_mostra(chave,erro){
		  if(erro==true){
			  js_pesquisac60_codcon();
		  } else {
			  document.form1.desc_conta.value = chave;
		  }
		}
	/**
	*pesquisar cantas de cadastros antigos
	*/
function js_pesquisac60_codcon(){
    if(document.form1.k29_contapadraopag.value != ''){
      js_OpenJanelaIframe('','db_iframe_conplano','func_conplano.php?pesquisa_chave='+document.form1.k29_contapadraopag.value+'&funcao_js=parent.js_mostraconplano','Pesquisa',false);
    }
}
function js_mostraconplano(chave,erro){
  if(erro==true){
    document.form1.k29_contapadraopag.focus();
    document.form1.k29_contapadraopag.value = '';
  } else {
	  document.form1.desc_conta.value = chave;
  }
}


function js_abre(){

	   obj = document.form1;
	   query  = document.form1.k00_codigo.value;

	   jan = window.open('cai4_ordembancaria002.php?codigo_ordem='+query,

	                 '',
	                   'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
	   jan.moveTo(0,0);

	}

	function js_novo() {
		document.form1.k00_codigo.value = '';
		document.form1.k29_contapadraopag.value = '';
		document.form1.c60_descr.value = '';
	  parent.document.formaba.db_pagamento.disabled=true;
	}

	/**
	 * buscar dados tabela
	 */
	function pesquisar(){
		var oAjax = new Ajax.Request("func_ordembancaria.php",
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

		var oAjax = new Ajax.Request("func_ordembancaria.php",
				{
		   method:'post',
		   parameters:{codigo1: $('codigoseq').value, codigo2: $('ctpagadora').value},
		   onComplete:cria_tabela
			  }
				);

	}

	/**
	 *
	 */
	function pegar_valor(param1, param2){

		$('k00_codigo').value = param1;
		$('k29_contapadraopag').value = param2;
		js_pesquisar_conta();
		CurrentWindow.corpo.iframe_db_pagamento.location.href='cai4_ordempagamentos001.php?k00_codigo='+param1;
		parent.document.formaba.db_pagamento.disabled=false;
		fechar();
		parent.mo_camada('db_pagamento');
    js_db_libera();
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
		tabela += "Conta Pagadora";

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
				tabela += "<a onclick=\"pegar_valor("+jsonObj[i].k00_codigo+",'"+jsonObj[i].k00_ctpagadora+"')\">"+jsonObj[i].k00_codigo+"</a>";

				tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
				tabela += "<a onclick=\"pegar_valor("+jsonObj[i].k00_codigo+",'"+jsonObj[i].k00_ctpagadora+"')\">"+jsonObj[i].k00_ctpagadora+"</a>";

				tabela += "</td></tr>";
			}

		} catch (e) {
		}
		tabela += "</table>";
		var conteudo = document.getElementById('lista');
		conteudo.innerHTML += tabela;
		conteudo.style.visibility = "visible";
	}

	function js_valida_campos(){
		if (document.form1.k29_contapadraopag.value == '') {
    alert("Nenhuma conta foi selecionada");
    return false;
	  } else {
		  document.form1.incluir.value = 1;
      document.form1.submit();
		}
	}

	function js_limpa_campos(){
		document.form1.k29_contapadraopag.value = '';
		document.form1.k00_codigo.value = '';
		document.form1.desc_conta.value = '';
	}
</script>
