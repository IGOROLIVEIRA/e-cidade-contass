<?
//MODULO: Agua
$claguatpimovel->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tx07_codtpimovel?>">
       <?=@$Lx07_codtpimovel?>
    </td>
    <td>
<?
db_input('x07_codtpimovel',4,$Ix07_codtpimovel,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx07_nometpimovel?>">
       <?=@$Lx07_nometpimovel?>
    </td>
    <td>
<?
db_input('x07_nometpimovel',50,$Ix07_nometpimovel,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_aguatpimovel','func_aguatpimovel.php?funcao_js=parent.js_preenchepesquisa|x07_codtpimovel','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_aguatpimovel.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
