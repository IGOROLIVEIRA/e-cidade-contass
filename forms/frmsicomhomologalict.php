<div id="lista" style="position: absolute; width:100%; background: #CCCCCC; visibility: hidden; border: 1px solid black; margin-top: 10px; padding-bottom: 10px;">
<div id="topo" style="width:100%; clear: both; display: table; background: #2C7AFE; border: 1px solid black; margin-bottom: 5px;">

<span style=" float: left; margin-top: 5px; border: 0px solid red;">Dados Homologação Licitação</span>
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
	<form name="form1" method="post" action="" onsubmit="return verifica_licitacao(this);">
<fieldset style="width: 500px; height: 110px; margin-top: 20px;"><legend><b>Homologação Licitação</b></legend>
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
     <input type="hidden" name="dtAdjudicacao" id="dtAdjudicacao" >
     <input type="hidden" name="dtHomologacao" id="dtHomologacao" >
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
<fieldset style="width: 500px; height: 180px; margin-top: 20px;"><legend><b>Homologação Licitação</b></legend>
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
  <td><strong>Data Homologação:</strong></td>
  <td>
  <input type="text" name="dtHomologacao" id="dtHomologacao" value="<?=$dtHomologacao ?>" onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)" 
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10">
  <input id="dtHomologacao_dia" type="hidden" maxlength="2" size="2" value="" title="">
  <input id="dtHomologacao_mes" type="hidden" maxlength="2" size="2" value="" title="">
  <input id="dtHomologacao_ano" type="hidden" maxlength="4" size="4" value="" title="">
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparaDatasdtHomologacao(dia,mes,ano){
      var objData = document.getElementById('dtHomologacao');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>

  </td>
  </tr>
  
  <tr>
  <td><strong>Data Adjudicação:</strong></td>
  <td>
  <input type="text" name="dtAdjudicacao" id="dtAdjudicacao" value="<?=$dtAdjudicacao ?>" onfocus="js_validaEntrada(this);" onkeyup="return js_mascaraData(this,event)" 
  autocomplete="off" onblur="js_validaDbData(this);" maxlength="10">
  <input id="dtAdjudicacao_dia" type="hidden" maxlength="2" size="2" value="" title="">
  <input id="dtAdjudicacao_mes" type="hidden" maxlength="2" size="2" value="" title="">
  <input id="dtAdjudicacao_ano" type="hidden" maxlength="4" size="4" value="" title="">
  <script>
    var PosMouseY, PosMoudeX;
    function js_comparaDatasdtHomologacao(dia,mes,ano){
      var objData = document.getElementById('dtAdjudicacao');
      objData.value = dia+"/"+mes+'/'+ano;
    }
  </script>

  </td>
  </tr>
  
  <tr>
  <tr>
	<td></td>
	<td align="right">
	<input type="submit" value="Homologar" name="btnSalvar" />
	<input type="submit" value="Excluir" name="btnExcluir" />
	<input type="submit" value="Novo" name="btnNovo" />
	</td>
</tr>
</table>
</fieldset>
</form>

<?
//$oLicitacao       = new licitacao($nroProcessoLicitatorio);
//$aRetorno         = $oLicitacao->getItensParaAutorizacao();

      $sSql = "select distinct l21_ordem, l21_codigo, pc01_descrmater as descricaomaterial, pc81_codprocitem as codigoitemprocesso, pc11_seq, pc11_codigo, 
      pc11_quant as quantfornecedor, pc11_vlrun as valorunitariofornecedor, m61_descr, pc11_resum, pc23_obs,pc01_codmater, pc13_coddot as codigodotacao,
      z01_numcgm as codigofornecedor, z01_nome as fornecedor  
      from liclicitem inner join pcprocitem on liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem 
      inner join pcproc on pcproc.pc80_codproc = pcprocitem.pc81_codproc 
      inner join solicitem on solicitem.pc11_codigo = pcprocitem.pc81_solicitem 
      inner join solicita on solicita.pc10_numero = solicitem.pc11_numero 
      inner join db_depart on db_depart.coddepto = solicita.pc10_depto 
      left join liclicita on liclicita.l20_codigo = liclicitem.l21_codliclicita 
      left join cflicita on cflicita.l03_codigo = liclicita.l20_codtipocom 
      left join pctipocompra on pctipocompra.pc50_codcom = cflicita.l03_codcom 
      left join solicitemunid on solicitemunid.pc17_codigo = solicitem.pc11_codigo 
      left join matunid on matunid.m61_codmatunid = solicitemunid.pc17_unid 
      left join pcorcamitemlic on l21_codigo = pc26_liclicitem 
      left join pcorcamval on pc26_orcamitem = pc23_orcamitem 
      left join db_usuarios on pcproc.pc80_usuario = db_usuarios.id_usuario 
      left join solicitempcmater on solicitempcmater.pc16_solicitem = solicitem.pc11_codigo 
      left join pcmater on pcmater.pc01_codmater = solicitempcmater.pc16_codmater 
      left join pcsubgrupo on pcsubgrupo.pc04_codsubgrupo = pcmater.pc01_codsubgrupo 
      left join pctipo on pctipo.pc05_codtipo = pcsubgrupo.pc04_codtipo 
      left join solicitemele on solicitemele.pc18_solicitem = solicitem.pc11_codigo 
      left join orcelemento on orcelemento.o56_codele = solicitemele.pc18_codele and orcelemento.o56_anousu = ".db_getsession("DB_anousu")."
      left join empautitempcprocitem on empautitempcprocitem.e73_pcprocitem = pcprocitem.pc81_codprocitem 
      left join empautitem on empautitem.e55_autori = empautitempcprocitem.e73_autori and empautitem.e55_sequen = empautitempcprocitem.e73_sequen 
      left join empautoriza on empautoriza.e54_autori = empautitem.e55_autori left join empempaut on empempaut.e61_autori = empautitem.e55_autori 
      left join empempenho on empempenho.e60_numemp = empempaut.e61_numemp 
      left join pcdotac on solicitem.pc11_codigo = pcdotac.pc13_codigo 
      left join pcorcamforne on pcorcamval.pc23_orcamforne = pcorcamforne.pc21_orcamforne
      left join cgm on cgm.z01_numcgm = pcorcamforne.pc21_numcgm
      where l21_codliclicita = ".$nroProcessoLicitatorio." 
      order by l21_ordem
      ";

      $rsRetorno=db_query($sSql);
	  
      for ($iCont = 0; $iCont < pg_num_rows($rsRetorno); $iCont++) {

			$aRetorno[]  = db_utils::fieldsMemory($rsRetorno, $iCont);
      
      }
	 
?>
<fieldset  style="width: 800px;">
<legend>
<b>Itens da Dotação</b>
</legend>
<div id="ctnGridDotacoesItens">
  <table id="gridDotacoes" class="DBGrid" cellspacing="0" cellpadding="0" width="100%" border="0" style="border:2px inset white;">
  <tr>
    <th class="table_header" nowrap="" style="">Item</th>
    <th class="table_header" nowrap="" style="">Fornecedor</th>
    <th class="table_header" nowrap="" style="">Quantidade</th>
		<th class="table_header" nowrap="" style="">Valor Unitário</th>
		<th class="table_header" nowrap="" style="">Valor Total</th>
		<th class="table_header" nowrap="" style="">Dotação</th>
	</tr>
<?
$aItensDotacao = array();
/*
 *Agrupar itens repitidos 
 */
foreach ($aRetorno as $oItem) {

       if (!$aItensDotacao[$oItem->codigoitemprocesso]) {
               
         $aItensDotacao[$oItem->codigoitemprocesso] = $oItem;
                 
       }
}

/*
 * criar tabela de itens da licitação
 */
foreach ($aItensDotacao as $oItem) {
	?>
	
  <tr id="DotacoesrowDotacoes1" class="normal" style="height:1em;; ">
		<td id="Dotacoesrow1cell0" class="linhagrid" nowrap="" style="text-align:left;;"><?=urldecode($oItem->descricaomaterial)?></td>
		<td id="Dotacoesrow1cell1" class="linhagrid" nowrap="" style="text-align:left;;"><?=urldecode($oItem->fornecedor)?></td>
		<td id="Dotacoesrow1cell2" class="linhagrid" nowrap="" style="text-align:right;;"><?=$oItem->quantfornecedor ?></td>
		<td id="Dotacoesrow1cell3" class="linhagrid" nowrap="" style="text-align:right;;"><?=number_format($oItem->valorunitariofornecedor, 2) ?></td>
		<td id="Dotacoesrow1cell4" class="linhagrid" nowrap="" style="text-align:center;;">
		<?=($oItem->quantfornecedor * $oItem->valorunitariofornecedor) ?></td>
		<td id="Dotacoesrow1cell5" class="linhagrid" nowrap="" style="text-align:center;;"><?=$oItem->codigodotacao ?></td>
  </tr>
  
	<?
}
?>
</table>
</div>
</fieldset>
<?
}
?>

<script type="text/javascript">

function verifica_licitacao (form) {

	//campo = document.getElemenById("nroProcessoLicitatorio");
	
	if (form.nroProcessoLicitatorio.value == "") {
		alert("Nenhum processo licitatório foi selecionado");
		return false;
	} else {
    return true;
	}
	
}
/*
 * itens a serem homologados
 */
 function retornoAjax(oAjaxRetorno) {

	 var oRetorno = eval("("+oAjaxRetorno.responseText+")");
	 alert(oRetorno);
	 oRetorno.aItens.each( function(oItem, id) {
	     alert(oItem.codigomaterial);   
	      
	        });
  }
 
function busca_itens() {
	

 var oParam          = new Object();
 oParam.exec         = "getItensParaAutorizacao";
 oParam.iCodigo      = document.form1.nroProcessoLicitatorio.value;
 
 var oAjax = new Ajax.Request("lic4_geraAutorizacoes.RPC.php",
         {method:'post',
          parameters:'json='+Object.toJSON(oParam),
          onComplete: retornoAjax
         }
       );
 
}



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

<?php
/**
 * ValidaFornecedor:
 * Quando for passado por URL o parametro validafornecedor, só irá retornar licitações que possuem fornecedores habilitados.
 * @see ocorrência 2278
 */
?>
/*
 * Pesquisar dados da licitação
 */
 function js_pesquisa_liclicita(mostra){
	 document.form1.codigo.value = '';
	  if(mostra==true){

	    js_OpenJanelaIframe('','db_iframe_liclicita','func_liclicita.php?funcao_js=parent.js_mostraliclicita1|l20_codigo&validafornecedor=1','Pesquisa',true);
	  }else{
	     if(document.form1.nroProcessoLicitatorio.value != ''){ 
	        js_OpenJanelaIframe('','db_iframe_liclicita','func_liclicita.php?pesquisa_chave='+document.form1.nroProcessoLicitatorio.value+'&funcao_js=parent.js_mostraliclicita&validafornecedor=1','Pesquisa',false);
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

	var oAjax = new Ajax.Request("con4_pesquisarxmlhomologalicit.php",
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
	
	var oAjax = new Ajax.Request("con4_pesquisarxmlhomologalicit.php",
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
function pegar_valor(param1, param2, param3, param4) {
	
	$('codigo').value = param1;
	$('nroProcessoLicitatorio').value = param2;
	$('dtHomologacao').value = param3;
	$('dtAdjudicacao').value = param4;
	
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
	
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Data Homologação";
	
	tabela += "</td><td bgcolor=\"#cdcdff\" align=\"center\" nowrap=\"\">";
	tabela += "Data Adjudicacao";
	
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
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].nroProcessoLicitatorio+"','"+jsonObj[i].dtHomologacao+"','"
			+jsonObj[i].dtAdjudicacao+"')\">"+jsonObj[i].codigo+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].nroProcessoLicitatorio+"','"+jsonObj[i].dtHomologacao+"','"
			+jsonObj[i].dtAdjudicacao+"')\">"+jsonObj[i].nroProcessoLicitatorio+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].nroProcessoLicitatorio+"','"+jsonObj[i].dtHomologacao+"','"
			+jsonObj[i].dtAdjudicacao+"')\">"+jsonObj[i].dtHomologacao+"</a>";
			
			tabela += "</td><td id=\"I00\" bgcolor=\""+color+"\" nowrap=\"\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">";
			tabela += "<a onclick=\"pegar_valor('"+jsonObj[i].codigo+"','"+jsonObj[i].nroProcessoLicitatorio+"','"+jsonObj[i].dtHomologacao+"','"
			+jsonObj[i].dtAdjudicacao+"')\">"+jsonObj[i].dtAdjudicacao+"</a>";
			
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