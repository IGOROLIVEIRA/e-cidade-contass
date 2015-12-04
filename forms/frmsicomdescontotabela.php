<div id="lista" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Preço Médio</span>
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
<td><strong>Número Licitação:</strong></td>
<td>
 <input type="text" name="nroLicitacao" id="nroLicitacao" maxlength="13" onkeyup="js_ValidaCampos(this,1,'Licitação','f','f',event);">
</td>
</tr>
<tr>
<td></td>
<td><input type="button" name="bntPesquisarXml" value="Pesquisar" onclick="pesquisar_codigo()"></td>
</tr>
</table>
</div><!-- campos -->
</div><!-- lista -->
<?
if (!isset($nroProcessoLicitatorio)) {
	?>
	<form name="form1" method="post" action="" onsubmit="return valida_licitacao(this);">
<fieldset style="width: 500px; height: 110px; margin-top: 20px;"><legend><b>Desconto Tabela</b></legend>
  <table cellspacing="5px">
  <tr>
  <td><strong>Código</strong></td>
  <td> <input type="text" name="codigo" id="codigo" readonly="readonly" style="background-color: rgb(222, 184, 135);" ></td>
  </tr>
  
  <tr> 
    <td  nowrap title="<?=$Tl20_codigo?>">
    <b>
    <?db_ancora('Licitação:',"js_pesquisa_liclicita(true);",1);?>
    </b> 
    </td> 
    <td>
    <input name="nroProcessoLicitatorio" id="nroProcessoLicitatorio" onchange="js_pesquisa_liclicita(false);" 
     onkeyup="js_ValidaCampos(this,1,'Código Licitação','f','f',event);"   />
     <input type="hidden" name="dtCotacao" id="dtCotacao" >
    </td>      
  </tr>

    <tr>
	<td></td>
	<td align="right">
	<input type="submit" value="Processar" name="btnProcessar" />
	<input type="button" value="Pesquisar" name="btnPesquisar" onclick="pesquisar()" />
	<input type="reset" value="Novo" name="btnNovo" />
	</td>
</tr>
</table>
</fieldset>
</form>
	
	<?
} else {
?>
<link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
<form name="form1" method="post" action="">
<fieldset style="width: 500px; height: 120px; margin-top: 20px;"><legend><b>Desconto Tabela</b></legend>
  <table cellspacing="5px">
  <tr>
  <td><strong>Código</strong></td>
  <td> 
  <input type="text" name="codigo" id="codigo" value="<?=$codigo ?>" readonly="readonly" style="background-color: rgb(222, 184, 135);" >
  </td>
  </tr>
  
  <tr> 
    <td>
    <strong>Licitação: </strong>
    </td> 
    <td>
    <input name="nroProcessoLicitatorio" id="nroProcessoLicitatorio" value="<?=$nroProcessoLicitatorio ?>"
     onkeyup="js_ValidaCampos(this,1,'Código Licitação','f','f',event);"  readonly="readonly" style="background-color: rgb(222, 184, 135);"/>
    </td>      
  </tr>
  
  <tr>
  <td><strong>Fornecedores:</strong></td>
  <td>
  <select name="fornecedor" id="fornecedor" onchange="js_itens_fornecedor();">
  <? 
   for ($iContfornec = 0; $iContfornec < pg_num_rows($rsFornecedores); $iContfornec++) {
   
   	$oFornecedores = db_utils::fieldsMemory($rsFornecedores, $iContfornec);
   	echo "<option value=\"{$oFornecedores->z01_numcgm}\" id=\"{$oFornecedores->z01_numcgm}\" >{$oFornecedores->z01_nome}</option>";
   	
   }
  ?>
  </select>

  </td>
  </tr>
  
  <tr>
  <tr>
	<td></td>
	<td align="right">
	<input type="submit" value="Salvar" name="btnSalvar" />
	<input type="submit" value="Excluir" name="btnExcluir" />
	<input type="submit" value="Novo" name="btnNovo" />
	</td>
</tr>
</table>
</fieldset>


<?
$sSql = "select distinct l21_ordem, pc81_codprocitem, pc81_codproc, pc11_seq, pc11_resum, pc11_codigo, pc11_vlrun, 
pc11_quant, pc01_descrmater,pc01_codmater, pc22_orcamitem, l21_codigo, l20_usaregistropreco, pc11_resum, pc32_orcamitem, pc32_orcamforne, 
l04_descricao as descr_lote from pcorcamitem inner join pcorcam on pcorcam.pc20_codorc = pcorcamitem.pc22_codorc 
left join pcorcamforne on pcorcamforne.pc21_codorc = pcorcam.pc20_codorc inner join pcorcamitemlic 
on pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem inner join liclicitem 
on pcorcamitemlic.pc26_liclicitem = liclicitem.l21_codigo inner join liclicita on liclicita.l20_codigo = liclicitem.l21_codliclicita 
inner join pcprocitem on pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem inner join solicitem 
on solicitem.pc11_codigo = pcprocitem.pc81_solicitem left join solicitemunid on solicitemunid.pc17_codigo = solicitem.pc11_codigo 
left join matunid on matunid.m61_codmatunid = solicitemunid.pc17_unid left join solicitempcmater 
on solicitempcmater.pc16_solicitem = solicitem.pc11_codigo left join pcmater on pcmater.pc01_codmater = solicitempcmater.pc16_codmater 
left join pcorcamval on pcorcamval.pc23_orcamitem = pcorcamitem.pc22_orcamitem and pcorcamval.pc23_orcamforne = pcorcamforne.pc21_orcamforne 
left join pcorcamdescla on pcorcamdescla.pc32_orcamitem = pcorcamitem.pc22_orcamitem 
and pcorcamdescla.pc32_orcamforne = pcorcamforne.pc21_orcamforne 
left join liclicitemlote on liclicitemlote.l04_liclicitem = liclicitem.l21_codigo 
left join licsituacao on liclicita.l20_licsituacao = licsituacao.l08_sequencial 
where pc20_codorc={$oOrcamento->pc22_codorc} and l21_situacao = 0 order by pc81_codproc,l21_ordem,l04_descricao,pc22_orcamitem";

$rsItens = db_query($sSql);
?>
<fieldset  style="width: 800px;">
<legend>
<b>Itens</b>
</legend>
<div id="ctnGridDotacoesItens">
  <table id="gridDotacoes" class="DBGrid" cellspacing="0" cellpadding="0" width="100%" border="0" style="border:2px inset white;">
  <tr>
    <th class="table_header" nowrap="" style="">Item</th>
	<th class="table_header" nowrap="" style="">Valor%</th>
	</tr>
	
	<?

/*
 * Criar tabela de itens
 */
for ($iCont = 0; $iCont < pg_num_rows($rsItens); $iCont++) {
	
	$oItem = db_utils::fieldsMemory($rsItens, $iCont);
	
  $iVerifica = 0;	
	
  /*
   * pega itens do xml $aItensXml
   */	
  foreach ($aItensXml as $itenXml) {
    	
  	if ($oItem->pc01_codmater == $itenXml->pc01_codmater) {
   	  $iVerifica = 1;
?>
	
  <tr id="DotacoesrowDotacoes1" class="normal" style="height:1em;; ">
  		
		<td id="Dotacoesrow1cell0" class="linhagrid" nowrap="" style="text-align:left;;"><?=$oItem->pc01_descrmater ?></td>
		<td id="Dotacoesrow1cell3" class="linhagrid" nowrap="" style="text-align:center;">
		<input id="item_<?=$oItem->pc01_codmater ?>" class="linhagrid" name="<?=$oItem->pc01_codmater ?>" value="<?php echo $itenXml->vldesconto  ?>" type="text" style="width: 80px;"; 
		onkeyup="js_ValidaCampos(this,4,'valor','f','f',event);" >
		
		</td>
  </tr>
  
	<?
    
   }

   }
   
   if ($iVerifica == 0) {
   	
    ?> 	 
   	
    <tr id="DotacoesrowDotacoes1" class="normal" style="height:1em;; ">
  		
		<td id="Dotacoesrow1cell0" class="linhagrid" nowrap="" style="text-align:left;;"><?=$oItem->pc01_descrmater ?></td>
		<td id="Dotacoesrow1cell3" class="linhagrid" nowrap="" style="text-align:center;">
		<input id="item_<?=$oItem->pc01_codmater ?>" class="linhagrid" name="<?=$oItem->pc01_codmater ?>" type="text" style="width: 80px;"; 
		onkeyup="js_ValidaCampos(this,4,'valor','f','f',event);" >
		</td>
		
    </tr>	
   	
   	<? 
   
   }
	
}
?>
</table>
</div>
</fieldset>
</form>

<?
}
?>

<script type="text/javascript">

function js_itens_fornecedor() {

	var oAjax = new Ajax.Request("con4_pesquisarxmldescontotabela.php",
			{
		method:"post",
		parameters:{fornecedor: $('fornecedor').value,licitacao: $("nroProcessoLicitatorio").value},
		onComplete:js_passarvalores
		  }
	);
	
}

function js_passarvalores(json) {

	var jsonObj = eval("("+json.responseText+")");
	for (var i = 0; i < jsonObj.length; i++) {
    document.getElementById("item_"+jsonObj[i].pc01_codmater).value = jsonObj[i].vldesconto;
	}

	if (jsonObj.length < 1) {
	  
		var campos = document.getElementById('ctnGridDotacoesItens').getElementsByTagName('input');
    for (i = 0; i < campos.length; i++) {
		  campos[i].value = "";
    }
    
	}
	
}

function valida_licitacao(form) {

	if (form.nroProcessoLicitatorio.value == "") {

	  alert("Nenhuma licitação foi selecionada!");
	  return false;
		
	} else {
		return true;
	}
	
}


/*
 * Pesquisar dados da licitação
 */
 function js_pesquisa_liclicita(mostra){
	 document.form1.codigo.value = '';
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

		var oAjax = new Ajax.Request("con4_pesquisarxmldescontotabela.php",
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
		
		var oAjax = new Ajax.Request("con4_pesquisarxmldescontotabela.php",
				{
			method:"post",
			parameters:{codigo1: $('codigoSeq').value, codigo2: $('nroLicitacao').value},
			onComplete:cria_tabela
			  }
		);
		
	}

	/**
	 * passar valores para os campos do formulario
	 */
	function pegar_valor(param1, param2, param3) {
		
		$('codigo').value = param1;
		$('nroProcessoLicitatorio').value = param2;
		
		document.getElementById('lista').style.visibility = "hidden";
		var campo = document.getElementById('TabDbLov'); 
		document.getElementById('lista').removeChild(campo);
		
	}

	function fechar() {
		
		var campo = document.getElementById('TabDbLov'); 
		document.getElementById('lista').removeChild(campo); 
		document.getElementById('lista').style.visibility = "hidden";
		
	}

	/**
	 * criar tabela html com os dados do xml
	 */
	function cria_tabela(json) {

	  var jsonObj = eval("("+json.responseText+")"); 
		var tabela;
		var color = "#e796a4";
		tabela  = "<table id=\"TabDbLov\" cellspacing=\"1\" cellpadding=\"2\" border=\"1\">";
		tabela +=	"<tr style=\"text-decoration: underline;\"><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
		tabela += "Código";
		
		tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
		tabela += "Licitação";
		
		
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
				tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].nroProcessoLicitatorio+"','"
				+jsonObj[i].dtCotacao+"')\">"+jsonObj[i].codigo+"</a>";
				
				tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
				tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].nroProcessoLicitatorio+"','"
				+jsonObj[i].dtCotacao+"')\">"+jsonObj[i].nroProcessoLicitatorio+"</a>";
				
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