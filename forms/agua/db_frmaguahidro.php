<?
//MODULO: Agua
$claguahidro->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tx03_codmarca?>">
       <?=@$Lx03_codmarca?>
    </td>
    <td>
<?
db_input('x03_codmarca',6,$Ix03_codmarca,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx03_nomemarca?>">
       <?=@$Lx03_nomemarca?>
    </td>
    <td>
<?
db_input('x03_nomemarca',50,$Ix03_nomemarca,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_aguahidro','func_aguahidro.php?funcao_js=parent.js_preenchepesquisa|x03_codmarca','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_aguahidro.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
