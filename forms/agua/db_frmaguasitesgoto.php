<?
//MODULO: Agua
$claguasitesgoto->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tx09_codsitesgoto?>">
       <?=@$Lx09_codsitesgoto?>
    </td>
    <td>
<?
db_input('x09_codsitesgoto',4,$Ix09_codsitesgoto,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx09_nomesituacao?>">
       <?=@$Lx09_nomesituacao?>
    </td>
    <td>
<?
db_input('x09_nomesituacao',30,$Ix09_nomesituacao,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_aguasitesgoto','func_aguasitesgoto.php?funcao_js=parent.js_preenchepesquisa|x09_codsitesgoto','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_aguasitesgoto.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
