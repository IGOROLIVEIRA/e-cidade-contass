<div id="lista" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Dispensa ou inexigibilidade</span>
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
<td> <input type="text" name="codigoDisp" id="codigoDisp" ></td>
</tr>
<tr>
<td><strong>Licitação</strong></td>
<td> <input type="text" name="nroLicitatorio" id="nroLicitatorio" ></td>
</tr>
<tr>
<td></td>
<td><input type="button" name="bntPesquisarXml" value="Pesquisar" onclick="pesquisar_codigo()"></td>
</tr>
</table>
</div><!-- campos -->
</div><!-- lista -->

<form name="form1" method="post" action="">
<fieldset style="width: 540px; height: 262px;"><legend><b>Dispensa ou Inexigibilidade</b></legend>
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
  <td><strong>Data de abertura do processo administrativo:</strong></td>
  <td><input type="text" name=dtAbertura id="dtAbertura"
  onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)"
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10">
  <input id="dtAbertura_dia" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dtAbertura_mes" type="hidden" maxlength="2" size="2" value="" title="" >
  <input id="dtAbertura_ano" type="hidden" maxlength="4" size="4" value="" title="" >
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparaDataCredenciamento(dia,mes,ano){
      var objData = document.getElementById('dtAbertura');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>
  </td>
  </tr>

  <tr>
  <td><strong>Justificativa:</strong></td>
  <td><textarea name="justificativa" id="justificativa" value="" cols="30" rows="3"
	onKeyDown="textCounter(this.form.formaFornecimento,this.form.remLen,250)" onKeyUp="textCounter(this.form.formaFornecimento,this.form.remLen,250)">
	</textarea></td>
  </tr>

  <tr>
  <td><strong>Razão da Escolha:</strong></td>
  <td><textarea name="razao" id="razao" value="" cols="30" rows="3"
	onKeyDown="textCounter(this.form.formaFornecimento,this.form.remLen,250)" onKeyUp="textCounter(this.form.formaFornecimento,this.form.remLen,250)">
	</textarea>
  </td>
  </tr>

  <tr>
	<td align="right" colspan="2">
	<input type="submit" value="Salvar" name="btnSalvar" />
	<input type="submit" value="Excluir" name="btnExcluir" />
	<input type="button" value="Pesquisar" name="btnPesquisar" onclick="pesquisar()" />
	<input type="reset" value="Novo" name="btnNovo" onclick="limpa_codigo('')" />
	</td>
</tr>
</table>
</fieldset>
</form>

<script type="text/javascript">

/**
 * passar o codigo do contrato para o form da dotacao
 */
function limpa_codigo(cod) {

	CurrentWindow.corpo.iframe_db_respdisp.location.href='con4_sicomdotacao.php?codigo='+cod;
  parent.document.formaba.db_respdisp.disabled=true;

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
* Pesquisar dados da licitação
*/
function js_pesquisa_liclicita(mostra){
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
 function pesquisar(){
 	$.post('con4_pesquisarxmldispensa.php', function(data){

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

  	var cod1 = $('#codigoDisp').val();
  	var cod2 = $('#nroLicitatorio').val();

  	$.post('con4_pesquisarxmldispensa.php', {codigo1: cod1, codigo2: cod2}, function(data){
  		var jsonObj = eval(data);
  		cria_tabela(jsonObj);
  		$('#lista').css("visibility", "visible");
  		}
  	);
  }

  function fechar(){
		var campo = document.getElementById('TabDbLov');
		document.getElementById('lista').removeChild(campo);
		$('#lista').css("visibility","hidden");
  }

  function pegar_valor(param1, param2, param3, param4, param5){

	  	$('#codigo').val(param1);
	  	$('#nroProcessoLicitatorio').val(param2);
	  	$('#dtAbertura').val(param3);
	  	$('#justificativa').val(param4);
	  	$('#razao').val(param5);

		  CurrentWindow.corpo.iframe_db_respdisp.location.href='con4_sicomrespdispensa.php?codigo='+param1;
		  parent.document.formaba.db_respdisp.disabled=false;

	  	$('#lista').css("visibility","hidden");
	  	var campo = document.getElementById('TabDbLov');
	  	document.getElementById('lista').removeChild(campo);
	  }

  function cria_tabela(jsonObj){
		var tabela;
		var color = "#e796a4";
		tabela  = "<table id=\"TabDbLov\" cellspacing=\"1\" cellpadding=\"2\" border=\"1\">";
		tabela +=	"<tr style=\"text-decoration: underline;\"><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
		tabela += "Código";
		tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
		tabela += "Código da Licitação";
		tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
		tabela += "Data Abertura";
		tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
		tabela += "Justificativa";
		tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
		tabela += "Razão";
		tabela += "</td></tr>";
		for (var i in jsonObj){
			if(i % 2 != 0){
					color = "#97b5e6";
			}else{
				color = "#e796a4";
			}
			tabela += "<tr>";

			tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].nroProcessoLicitatorio+"','"
			+jsonObj[i].dtAbertura+"','"+jsonObj[i].justificativa+"','"+jsonObj[i].razao+"')\">"+jsonObj[i].codigo+"</a>";

			tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].nroProcessoLicitatorio+"','"
			+jsonObj[i].dtAbertura+"','"+jsonObj[i].justificativa+"','"+jsonObj[i].razao+"')\">"+jsonObj[i].nroProcessoLicitatorio+"</a>";

			tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].nroProcessoLicitatorio+"','"
			+jsonObj[i].dtAbertura+"','"+jsonObj[i].justificativa+"','"+jsonObj[i].razao+"')\">"+jsonObj[i].dtAbertura+"</a>";

			tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].nroProcessoLicitatorio+"','"
			+jsonObj[i].dtAbertura+"','"+jsonObj[i].justificativa+"','"+jsonObj[i].razao+"')\">"+jsonObj[i].justificativa.substr(0,25)+"</a>";

			tabela += "<td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor("+jsonObj[i].codigo+",'"+jsonObj[i].nroProcessoLicitatorio+"','"
			+jsonObj[i].dtAbertura+"','"+jsonObj[i].justificativa+"','"+jsonObj[i].razao+"')\">"+jsonObj[i].razao.substr(0,25)+"</a>";

			tabela += "</td></tr>";
		}
		tabela += "</table>";
		var conteudo = document.getElementById('lista');
		conteudo.innerHTML += tabela;
	}


function passar_valores(cod) {

					$.post('con4_pesquisarxmldispensa.php', {codigo1: cod}, function(data) {
						var jsonObj = eval(data);
						var i = 0;
						pegar_valor(jsonObj[i].codigo,jsonObj[i].nroProcessoLicitatorio,jsonObj[i].dtAbertura,jsonObj[i].justificativa,jsonObj[i].razao);

						}
					);
			}

</script>

<?
if (isset($iUltimoCodigo)) {
	echo "<script>
		passar_valores(".$iUltimoCodigo.");
	</script>";
}

?>
