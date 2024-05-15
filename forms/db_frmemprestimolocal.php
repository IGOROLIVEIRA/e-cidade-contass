<?
//MODULO: Biblioteca
$clemprestimolocal->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tbi20_codigo?>">
       <?=@$Lbi20_codigo?>
    </td>
    <td>
<?
db_input('bi20_codigo',10,$Ibi20_codigo,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tbi20_descr?>">
       <?=@$Lbi20_descr?>
    </td>
    <td>
<?
db_input('bi20_descr',30,$Ibi20_descr,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_emprestimolocal','func_emprestimolocal.php?funcao_js=parent.js_preenchepesquisa|bi20_codigo','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_emprestimolocal.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
