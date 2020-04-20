<?
//MODULO: contabilidade
$clvinculopcaspmsc->rotulo->label();
$c210_anousu = isset($chavepesquisa2) ? $chavepesquisa2 : $c210_anousu;
?>
<form name="form1" method="post" action="">
  <input type="hidden" name="c210_pcaspestrutant" value="<?=@$c210_pcaspestrut?>">
  <input type="hidden" name="c210_mscestrutant" value="<?=@$c210_mscestrut?>">
<center>
<fieldset style="margin-top:10px; margin-bottom:10px; ">
  <legend>De/Para Pcasp MSC</legend>
  <table border="0" style="">
  <tr>
    <td nowrap title="<?=@$Tc210_pcaspestrut?>">
       <?=@$Lc210_pcaspestrut?>
    </td>
    <td>
      <?
      db_input('c210_pcaspestrut',9,$Ic210_pcaspestrut,true,'text',$db_opcao,"")
      ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc210_mscestrut?>">
       <?=@$Lc210_mscestrut?>
    </td>
    <td>
      <?
      db_input('c210_mscestrut',9,$Ic210_mscestrut,true,'text',$db_opcao,"")
      ?>
    </td>
  </tr>
  </table>
</fieldset>
<center>
<input name="c210_anousu" value="<?= isset($c210_anousu) ? $c210_anousu : db_getsession("DB_anousu") ?>" type="hidden" >
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisa(){
  js_OpenJanelaIframe('top.corpo','db_iframe_vinculopcaspmsc','func_vinculopcaspmsc.php?funcao_js=parent.js_preenchepesquisa|c210_pcaspestrut|c210_mscestrut|c210_anousu','Pesquisa',true);
}
function js_preenchepesquisa(chave,chave1,chave2){
  db_iframe_vinculopcaspmsc.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave+'&chavepesquisa1='+chave1+'&chavepesquisa2='+chave2";
  }
  ?>
}
</script>
