<?
//MODULO: contabilidade
$clcategoriatrabalhador->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tct01_codcategoria?>">
    <input name="oid" type="hidden" value="<?=@$oid?>">
       <?=@$Lct01_codcategoria?>
    </td>
    <td> 
<?
db_input('ct01_codcategoria',11,$Ict01_codcategoria,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tct01_descricaocategoria?>">
       <?=@$Lct01_descricaocategoria?>
    </td>
    <td> 
<?
db_input('ct01_descricaocategoria',250,$Ict01_descricaocategoria,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('top.corpo','db_iframe_categoriatrabalhador','func_categoriatrabalhador.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_categoriatrabalhador.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
