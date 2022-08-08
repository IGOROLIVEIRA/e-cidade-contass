<?
//MODULO: agua
$claguaisencaotipo->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tx29_codisencaotipo?>">
       <?=@$Lx29_codisencaotipo?>
    </td>
    <td>
<?
db_input('x29_codisencaotipo',5,$Ix29_codisencaotipo,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx29_descr?>">
       <?=@$Lx29_descr?>
    </td>
    <td>
<?
db_input('x29_descr',40,$Ix29_descr,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx29_tipo?>">
       <?=@$Lx29_tipo?>
    </td>
    <td>
<?
$x = array('0'=>'Normal','1'=>'Imune');
db_select('x29_tipo',$x,true,$db_opcao,"");
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
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_aguaisencaotipo','func_aguaisencaotipo.php?funcao_js=parent.js_preenchepesquisa|x29_codisencaotipo','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_aguaisencaotipo.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
