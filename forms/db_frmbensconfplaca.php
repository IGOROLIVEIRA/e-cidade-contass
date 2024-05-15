<?
//MODULO: patrim
$clbensconfplaca->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tt40_codigo?>">
       <?=@$Lt40_codigo?>
    </td>
    <td>
<?
db_input('t40_codigo',5,$It40_codigo,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tt40_descr?>">
       <?=@$Lt40_descr?>
    </td>
    <td>
<?
db_input('t40_descr',40,$It40_descr,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_bensconfplaca','func_bensconfplaca.php?funcao_js=parent.js_preenchepesquisa|t40_codigo','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_bensconfplaca.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
