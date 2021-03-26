<?
//MODULO: sicom
$clsaldotransfctb->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<fieldset style="margin-top: 10px;">
	<legend>Saldos Transferência CTB</legend>
	<table border="0">
		<tr>
			<td nowrap title="<?=@$Tsi202_codctb?>">
			<input name="si202_seq" type="hidden" value="<?=@$si202_seq?>">
			<?=@$Lsi202_codctb?>
			</td>
			<td>
		<?
		db_input('si202_codctb',11,$Isi202_codctb,true,'text',$db_opcao,"")
		?>
			</td>
		</tr>
		<tr>
			<td nowrap title="<?=@$Tsi202_codfontrecursos?>">
			<?=@$Lsi202_codfontrecursos?>
			</td>
			<td>
		<?
		db_input('si202_codfontrecursos',3,$Isi202_codfontrecursos,true,'text',$db_opcao,"")
		?>
			</td>
		</tr>
		<tr>
			<td nowrap title="<?=@$Tsi202_saldofinal?>">
			<?=@$Lsi202_saldofinal?>
			</td>
			<td>
		<?
		db_input('si202_saldofinal',14,$Isi202_saldofinal,true,'text',$db_opcao,"")
		?>
			</td>
		</tr>
	</table>
</fieldset>
</center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_saldotransfctb','func_saldotransfctb.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_saldotransfctb.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
