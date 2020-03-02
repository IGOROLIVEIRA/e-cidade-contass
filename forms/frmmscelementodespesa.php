<?
//MODULO: contabilidade
$clelemdespmsc->rotulo->label();
?>
<form name="form1" method="post" action="">
<fieldset style="width: 350px; height: 90px; margin-bottom:10px;"><legend><b>Código da Despesa:</b></legend>
  <table style="margin-bottom: 10px;">
  <tr>
    <td>&nbsp;</td>
    <td nowrap title="<?=@$Tc211_elemdespestrut?>">
       <strong>E-Cidade</strong>
    </td>
    <td nowrap title="<?=@$Tc211_mscestrut?>">
      <strong>MSC</strong>
    </td>
  </tr>
  <tr>
    <td><strong>Código da Despesa:</strong></td>
    <td>
      <?
      db_input('c211_elemdespestrut',9,$Ic211_elemdespestrut,true,'text',1,"")
      ?>
    </td>
    <td>
      <?
      db_input('c211_mscestrut',9,$Ic211_mscestrut,true,'text',1,"")
      ?>
    </td>
  </tr>
</table>
<input name="c211_anousu" value="<?= isset($c211_anousu) ? $c211_anousu : db_getsession("DB_anousu") ?>" type="hidden" >
<input style="display:none" name="novo" type="submit" id="novo" value="Novo" onclick="novoEst();">
<input name="incluir" type="submit" id="incluir" value="Incluir">
<input style="display:none" name="excluir" type="submit" id="excluir" value="Excluir">
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</fieldset>
</form>
<script>
function js_pesquisa(){
  js_OpenJanelaIframe('','db_iframe_elemdespmsc','func_elemdespmsc.php?funcao_js=parent.js_preenchepesquisa|c211_elemdespestrut|c211_mscestrut|c211_anousu','Pesquisa',true);
}
function js_preenchepesquisa(chave, chave1,chave2){
  document.form1.novo.style.display = 'inline-block';
  document.form1.excluir.style.display = 'inline-block';
  document.form1.incluir.style.display = 'none';
  document.form1.c211_elemdespestrut.style.background = '#DEB887';
  document.form1.c211_mscestrut.style.background = '#DEB887';
  document.form1.c211_elemdespestrut.setAttribute('readonly',true);
  document.form1.c211_mscestrut.setAttribute('readonly',true);
  document.form1.c211_elemdespestrut.value = chave;
  document.form1.c211_mscestrut.value = chave1;
  document.form1.c211_anousu.value = chave2;
  db_iframe_elemdespmsc.hide();

}

function novoEst() {

  document.form1.novo.style.display = 'none';
  document.form1.excluir.style.display = 'none';
  document.form1.incluir.style.display = 'inline-block';
  document.form1.c211_elemdespestrut.style.background = '';
  document.form1.c211_mscestrut.style.background = '';
  document.form1.c211_elemdespestrut.setAttribute('readonly',false);
  document.form1.c211_mscestrut.setAttribute('readonly',false);
  document.form1.c211_elemdespestrut.value = "";
  document.form1.c211_mscestrut.value = "";
  document.form1.c211_anousu.value = <?= db_getsession("DB_anousu") ?>

}

</script>
