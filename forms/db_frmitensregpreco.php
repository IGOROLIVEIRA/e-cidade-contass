<?
//MODULO: sicom
$clitensregpreco->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("pc01_descrmater");

?>
<fieldset style="width: 800px; height: 230px; margin-top: 15px; margin-left: 280px;"><legend><b>Itens adesão de registro de preço</b></legend>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td>
    </td>
    <td> 
<?
db_input('si07_sequencial',10,$Isi07_sequencial,true,'hidden','3',"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi07_numerolote?>">
       <?=@$Lsi07_numerolote?>
    </td>
    <td> 
<?
db_input('si07_numerolote',10,$Isi07_numerolote,true,'text',($iProcessoLote == 1 ? $db_opcao : 3),"")
?>
    </td>
  </tr>

  <tr>
    <td>
       <b>Descrição Lote: </b>
    </td>
    <td> 
<?
db_input('si07_descricaolote',50,0,true,'text',($iProcessoLote == 1 ? $db_opcao : 3),"","","","text-transform: uppercase;",250)
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi07_item?>">
       <?
       db_ancora(@$Lsi07_item,"js_pesquisasi07_item(true);",$db_opcao);
       ?>
    </td>
    <td> 
<?
db_input('si07_item',10,$Isi07_item,true,'text',$db_opcao," onchange='js_pesquisasi07_item(false);'")
?>
       <?
db_input('pc01_descrmater',80,$Ipc01_descrmater,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi07_unidade?>">
       <?=@$Lsi07_unidade?>
    </td>
    <td> 
<?
$sSqlUnidade = "select m61_codmatunid,m61_descr from matunid";
$result = db_query($sSqlUnidade);
db_selectrecord('si07_codunidade', $result, TRUE, $db_opcao);
?>
    </td>
  </tr>
  
  <tr>
    <td>
       <?
       db_ancora("Fornecedor Ganhador","js_pesquisasi07_fornecedor(true);",$db_opcao);
       ?>
    </td>
    <td> 
<?
db_input('si07_fornecedor',10,$Isi07_fornecedor,true,'text',$db_opcao," onchange='js_pesquisasi07_fornecedor(false);'")
?>
       <?
db_input('z01_nomef',40,$Iz01_nome,true,'text',3,'')
       ?>
    </td>
  </tr>
  
  <tr>
    <td nowrap title="<?=@$Tsi07_precounitario?>">
       <?=@$Lsi07_precounitario?>
    </td>
    <td> 
<?
db_input('si07_precounitario',10,$Isi07_precounitario,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi07_quantidadelicitada?>">
       <?=@$Lsi07_quantidadelicitada?>
    </td>
    <td> 
<?
db_input('si07_quantidadelicitada',10,$Isi07_quantidadelicitada,true,'text',($iDescontoTabela == 2 ? $db_opcao : 3),"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi07_quantidadeaderida?>">
       <?=@$Lsi07_quantidadeaderida?>
    </td>
    <td> 
<?
db_input('si07_quantidadeaderida',10,$Isi07_quantidadeaderida,true,'text',($iDescontoTabela == 2 ? $db_opcao : 3),"")
?>
    </td>
  </tr>

  <tr>
  <td>
<?
db_input('si07_sequencialadesao',10,$Isi07_sequencialadesao,true,'hidden',$db_opcao,"")
?>
</td>
  </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<!-- <input name="excluir" type="submit" id="db_opcao" value="Excluir"> 
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >-->
</form>
</fieldset>

<fieldset  style="width: 100%; margin-left: 115px; ">

<div id="ctnGridPagamentosItens">
  <table id="gridPagamentos" class="DBGrid" cellspacing="0" cellpadding="0" width="100%" border="0" style="border:2px inset white; overflow: scroll;">
  <tr>
    <th class="table_header" style="width: 5%;">Número do Item</th>
	<th class="table_header" style="width: 5%;">Item</th>
    <th class="table_header" style="width: 10%;">Número do lote</th>
    <th class="table_header" style="width: 20%;">Descrição Item</th>
    <th class="table_header" style="width: 20%;">Fornecedor Ganhador</th>
	<th class="table_header" style="width: 5%;">Preço unitário</th>
	<th class="table_header" style="width: 5%;">Quantidade Licitada</th>
	<th class="table_header" style="width: 5%;">Quantidade Aderida</th>
	<th class="table_header" style="width: 5%;">Unidade</th>
	<th class="table_header" style="width: 5%;"></th>
	<th class="table_header" style="width: 5%;"></th>
	</tr>
	<?php 
	
	for ($iCont = 0; $iCont < pg_num_rows($rsResultTabela); $iCont++) { 
	  $oDadosTabela = db_utils::fieldsMemory($rsResultTabela, $iCont);
	  
	$sTabela  = "<tr id=\"{$oDadosTabela->si07_sequencial}\" class=\"normal\" style=\"height:1em;\">";
	$sTabela .= "<td id=\"Pagamentosrow1cell0\" class=\"linhagrid\" style=\"text-align:center;\">{$oDadosTabela->si07_numeroitem}</td>";
	$sTabela .= "<td id=\"Pagamentosrow1cell1\" class=\"linhagrid\" style=\"text-align:center;\">{$oDadosTabela->si07_item}</td>";
	$sTabela .= "<td id=\"Pagamentosrow1cell0\" class=\"linhagrid\" style=\"text-align:center;\">".(($oDadosTabela->si07_numerolote==0?'':$oDadosTabela->si07_numerolote)."-".$oDadosTabela->si07_descricaolote)."</td>";
	$sTabela .= "<td id=\"Pagamentosrow1cell0\" class=\"linhagrid\" style=\"text-align:left;\">{$oDadosTabela->pc01_descrmater}</td>";
	$sTabela .= "<td id=\"Pagamentosrow1cell0\" class=\"linhagrid\" style=\"text-align:left;\">{$oDadosTabela->z01_nome}</td>";
	$sTabela .= "<td id=\"Pagamentosrow1cell2\" class=\"linhagrid\" style=\"text-align:center;\">{$oDadosTabela->si07_precounitario}</td>";
	$sTabela .= "<td id=\"Pagamentosrow1cell2\" class=\"linhagrid\" style=\"text-align:center;\">{$oDadosTabela->si07_quantidadelicitada}</td>";
	$sTabela .= "<td id=\"Pagamentosrow1cell2\" class=\"linhagrid\" style=\"text-align:center;\">{$oDadosTabela->si07_quantidadeaderida}</td>";
	$sTabela .= "<td id=\"Pagamentosrow1cell2\" class=\"linhagrid\" style=\"text-align:center;\">{$oDadosTabela->m61_descr}</td>";
	$sTabela .= "<td id=\"Pagamentosrow1cell3\" class=\"linhagrid\" style=\"text-align:center;\">";
	$sTabela .= "<input type=\"button\" name=\"alterar\" value=\"Alterar\" onclick=\"js_alterar({$oDadosTabela->si07_sequencial},this)\"></td>";
	$sTabela .= "<td id=\"Pagamentosrow1cell3\" class=\"linhagrid\" style=\"text-align:center;\">";
	$sTabela .= "<input type=\"button\" name=\"excluir\" value=\"Excluir\" onclick=\"js_excluir({$oDadosTabela->si07_sequencial},this)\"></td></tr>";
	echo $sTabela;	    	
	}
	?>
	</table>
</div>
</fieldset>



<script>

function js_pesquisasi07_item(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_pcmater','func_pcmater.php?funcao_js=parent.js_mostrapcmater1|pc01_codmater|pc01_descrmater','Pesquisa',true);
  }else{
     if(document.form1.si07_item.value != ''){ 
        js_OpenJanelaIframe('','db_iframe_pcmater','func_pcmater.php?pesquisa_chave='+document.form1.si07_item.value+'&funcao_js=parent.js_mostrapcmater','Pesquisa',false);
     }else{
       document.form1.pc01_descrmater.value = ''; 
     }
  }
}
function js_mostrapcmater(chave,erro){
  document.form1.pc01_descrmater.value = chave; 
  if(erro==true){ 
    document.form1.si07_item.focus(); 
    document.form1.si07_item.value = ''; 
  }
}
function js_mostrapcmater1(chave1,chave2){
  document.form1.si07_item.value = chave1;
  document.form1.pc01_descrmater.value = chave2;
  db_iframe_pcmater.hide();
}
//function js_pesquisa(){
//  js_OpenJanelaIframe('','db_iframe_itensregpreco','func_itensregpreco.php?funcao_js=parent.js_preenchepesquisa|si07_sequencial','Pesquisa',true);
//}

function js_alterar(chave,obj){
  <?
  if($db_opcao){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave+'&codigoAdesao=".$codigoAdesao."'";
  }
  ?>
}
function js_excluir(chave,obj){
	  <?
	  if($db_opcao){
	    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave+'&opcao=3&codigoAdesao=".$codigoAdesao."'";
	  }
	  ?>
	}
function js_novo(obj){
	  <?
	  if($db_opcao){
	    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?opcao='+1";
	  }
	  ?>
	}

  function js_pesquisasi07_fornecedor(mostra){
	  if(mostra==true){
	    js_OpenJanelaIframe('','db_iframe_cgm','func_cgm.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome','Pesquisa',true);
	  }else{
	     if(document.form1.si07_fornecedor.value != ''){ 
	        js_OpenJanelaIframe('','db_iframe_cgm','func_cgm.php?pesquisa_chave='+document.form1.si07_fornecedor.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false);
	     }else{
	       document.form1.z01_nomef.value = ''; 
	     }
	  }
	}
	function js_mostracgm(erro,chave){
	  document.form1.z01_nomef.value = chave; 
	  if(erro==true){ 
	    document.form1.si07_fornecedor.focus(); 
	    document.form1.si07_fornecedor.value = ''; 
	  }
	}
	function js_mostracgm1(chave1,chave2){
	  document.form1.si07_fornecedor.value = chave1;
	  document.form1.z01_nomef.value = chave2;
	  db_iframe_cgm.hide();
	}

<?php echo "document.getElementById('si07_sequencialadesao').value = ".$codigoAdesao; ?>

</script>


