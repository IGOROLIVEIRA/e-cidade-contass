<?
//MODULO: Agua
$claguahidrodiametro->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tx15_coddiametro?>">
       <?=@$Lx15_coddiametro?>
    </td>
    <td>
<?
db_input('x15_coddiametro',4,$Ix15_coddiametro,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx15_diametro?>">
       <?=@$Lx15_diametro?>
    </td>
    <td>
<?
db_input('x15_diametro',10,$Ix15_diametro,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_aguahidrodiametro','func_aguahidrodiametro.php?funcao_js=parent.js_preenchepesquisa|x15_coddiametro','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_aguahidrodiametro.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
