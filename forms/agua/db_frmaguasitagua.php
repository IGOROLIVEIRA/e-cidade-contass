<?
//MODULO: Agua
$claguasitagua->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tx08_codsitagua?>">
       <?=@$Lx08_codsitagua?>
    </td>
    <td>
<?
db_input('x08_codsitagua',4,$Ix08_codsitagua,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx08_nomesituacao?>">
       <?=@$Lx08_nomesituacao?>
    </td>
    <td>
<?
db_input('x08_nomesituacao',30,$Ix08_nomesituacao,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_aguasitagua','func_aguasitagua.php?funcao_js=parent.js_preenchepesquisa|x08_codsitagua','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_aguasitagua.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
