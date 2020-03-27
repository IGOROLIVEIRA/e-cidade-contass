<?
//MODULO: contabilidade
$clnatdespmsc->rotulo->label();
?>
<form name="form1" method="post" action="">
<fieldset style="width: 350px; height: 90px; margin-bottom:10px;"><legend><b>Códigos da Receita</b></legend>
  <table style="margin-bottom: 10px;">
  <tr>
    <td>&nbsp;</td>
    <td nowrap title="<?=@$Tc212_natdespestrut?>">
       <strong>E-Cidade</strong>
    </td>
    <td nowrap title="<?=@$Tc212_mscestrut?>">
      <strong>MSC</strong>
    </td>  
  </tr>
  <tr>
    <td><strong>Código da Receita:</strong></td>
    <td> 
      <?
      db_input('c212_natdespestrut',9,$Ic212_natdespestrut,true,'text',1,"")
      ?>
    </td>
    <td> 
      <?
      db_input('c212_mscestrut',9,$Ic212_mscestrut,true,'text',1,"")
      ?>
    </td>
  </tr>
</table>
<input name="c212_anousu" value="<?= db_getsession("DB_anousu") ?>" type="hidden" >
<input style="display:none" name="novo" type="submit" id="novo" value="Novo" onclick="novoEst();">
<input name="incluir" type="submit" id="incluir" value="Incluir">
<input style="display:none" name="excluir" type="submit" id="excluir" value="Excluir">
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</fieldset>
</form>
<script>
function js_pesquisa(){
  js_OpenJanelaIframe('','db_iframe_natdespmsc','func_natdespmsc.php?funcao_js=parent.js_preenchepesquisa|c212_natdespestrut|c212_mscestrut|c212_anousu','Pesquisa',true);
}
function js_preenchepesquisa(chave, chave1, chave2){
  document.form1.novo.style.display = 'inline-block';
  document.form1.excluir.style.display = 'inline-block';
  document.form1.incluir.style.display = 'none';
  document.form1.c212_natdespestrut.style.background = '#DEB887';
  document.form1.c212_mscestrut.style.background = '#DEB887';
  document.form1.c212_natdespestrut.setAttribute('readonly',true);
  document.form1.c212_mscestrut.setAttribute('readonly',true);
  document.form1.c212_natdespestrut.value = chave;
  document.form1.c212_mscestrut.value = chave1;
  document.form1.c212_anousu.value = chave2;
  db_iframe_natdespmsc.hide();

}

function novoEst() {

  document.form1.novo.style.display = 'none';
  document.form1.excluir.style.display = 'none';
  document.form1.incluir.style.display = 'inline-block';
  document.form1.c212_natdespestrut.style.background = '';
  document.form1.c212_mscestrut.style.background = '';
  document.form1.c212_natdespestrut.setAttribute('readonly',false);
  document.form1.c212_mscestrut.setAttribute('readonly',false);
  document.form1.c212_natdespestrut.value = "";
  document.form1.c212_mscestrut.value = "";
  document.form1.c212_anousu.value = <?= db_getsession("DB_anousu") ?>

}

</script>