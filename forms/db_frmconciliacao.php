<? 
//MODULO: caixa
$clconciliacao->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("db83_descricao");
//$abre_pesquisa=false; 
?>
<form name="form1" method="post" action="">
<center>
<fieldset style="width: 800px; margin-left: 200px; margin-top: 80px;"><legend
	style="font-weight: bold;"> Conciliação Manual</legend>
<table border="0">
	<tr>

		<td nowrap title="<?=@$Tk199_sequencial?>"><?=@$Lk199_sequencial?></td>
		<td><?	
		db_input('k199_sequencial',10,$Ik199_sequencial,true,'text',3,"");
		?></td>
	</tr>
	<tr>
		<td nowrap title="<?=@$Tk199_codconta?>"><?
		db_ancora(@$Lk199_codconta,"js_pesquisak199_codconta(true);",$db_opcao);
		?></td>
		<td><?
		db_input('k199_codconta',8,$Ik199_codconta,true,'text',3," onchange='js_pesquisak199_codconta(false);'")
		?> <?
		db_input('db83_descricao',40,$Idb83_descricao,true,'text',3,'')
		?></td>
	</tr>
	<tr>
		<td nowrap title="<?=@$Tk199_periodofinal?>"><?=@$Lk199_periodofinal?>
		</td>
		<td><?
		db_inputdata('k199_periodoini',@$k199_periodoini_dia,@$k199_periodoini_mes,@$k199_periodoini_ano,true,'text',$db_opcao,"")
		?> <b>a</b> <?
		db_inputdata('k199_periodofinal',@$k199_periodofinal_dia,@$k199_periodofinal_mes,@$k199_periodofinal_ano,true,'text',$db_opcao,"")
		?>
	
	</tr>
	<tr>
		<td nowrap title="<?=@$Tk199_saldofinalextrato?>"><?=@$Lk199_saldofinalextrato?>
		</td>
		<td><?
		db_input('k199_saldofinalextrato',10,$Ik199_saldofinalextrato,true,'text',$db_opcao,"")
		?></td>
	</tr>

</table>
</fieldset>
</center>
<input 	name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" 	type="submit" id="db_opcao" 	value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>"<?=($db_botao==false?"disabled":"")?>">
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar"	onclick="js_pesquisa(false);">

<? if($db_opcao==33 || $db_opcao==22  || $db_opcao==3 || $db_opcao==2){// 
		if($db_opcao==33){
			$pendencia="Exclusão dos itens de pendências";
		}else{$pendencia="Alteração dos itens de pendências";}?>
<fieldset style="width: 800px; margin-left: 200px; margin-top: 80px;">
<legend style="font-weight: bold;"><?=$pendencia?></legend>
<table border="0">
<tr>
	<td>Sequencial:</td>
	<td><?db_input('k202_sequencial',20,2,true,'text',$db_opcao,"") ?></td>
	</tr>
	<tr>
	<td>Tipo de Pendência</td>
	<td>
	 <?$ar = array("1"=>"Entradas não compensadas no Caixa","2"=>"Saidas não compensadas no Caixa ");
	             db_select("k202_tipopendencia",$ar,true,1,"style='width:153'");
	 ?>
	 </td>
	</tr>
	<tr>
	<td>Descrição:</td>
	<td><?db_input('k202_descricao',20,2,true,'text',$db_opcao,"") ?></td>
	</tr>
	<tr>
	<td>Valor R$:</td>
	<td>
	<?
    	db_input('k202_valor',20,4,true,'text',$db_opcao,"");
	?>	
	</td>
	</tr>
	<tr>
	<td>Data:</td>
	<td> <?db_inputdata('k202_data',@$k202_data_dia,@$k202_data_mes,@$k202_data_ano,true,'text',$db_opcao,"")?></td>
	</tr>
</table>
  </fieldset>
  		<input 	name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" 	type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>"<?=($db_botao==false?"disabled":"")?>">
		<input name="tipopendencia" type="button" id="pesquisar" value="Pesquisar"	onclick="js_pesquisaPendencia(true);">

<?}?>
</form>

<script>
function js_pesquisa(pendencia){ 
	if(pendencia==false){
		tipopendencia=false;
	}
		js_OpenJanelaIframe('','db_iframe_conciliacao','func_conciliacao.php?funcao_js=parent.js_preenchepesquisa|k199_sequencial','Pesquisa',true);
	}


/*Função responsavel em fazer as buscas/pesquisas referentes as  pendencias incluidas na tabela tipopendencia*/
function js_pesquisaPendencia(pendencia){
	if(pendencia==true){
		tipopendencia=true;
	}
	  js_OpenJanelaIframe('','db_iframe_conciliacao','func_tipopendencia.php?funcao_js=parent.js_preenchepesquisa|k202_sequencial','Pesquisa',true); 
	}
	

function js_pesquisak199_codconta(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_contabancaria','func_contabancaria.php?funcao_js=parent.js_mostracontabancaria1|db83_sequencial|db83_descricao','Pesquisa',true);
  }else{
     if(document.form1.k199_codconta.value != ''){ 
       js_OpenJanelaIframe('','db_iframe_contabancaria','func_contabancaria.php?pesquisa_chave='+document.form1.k199_codconta.value+'&funcao_js=parent.js_mostracontabancaria','Pesquisa',false);
     }else{
       document.form1.db83_descricao.value = ''; 
     }
  }
}
function js_mostracontabancaria(chave,erro){
  document.form1.db83_descricao.value = chave; 
  if(erro==true){ 
    document.form1.k199_codconta.focus(); 
    document.form1.k199_codconta.value = ''; 
  }
}
function js_mostracontabancaria1(chave1,chave2){
  document.form1.k199_codconta.value = chave1;
  document.form1.db83_descricao.value = chave2;
  db_iframe_contabancaria.hide();
}

function js_preenchepesquisa(chave){ 
  db_iframe_conciliacao.hide();
  <?
  if($db_opcao!=1){//?pesquisa_chave='+document.form1.k199_codconta.value+'&
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?tipopendencia='+tipopendencia+'&chavepesquisa='+chave";
  }
  ?>
}
</script>
