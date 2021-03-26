<?
//MODULO: Agua
$claguatpemissao->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tx06_codtpemissao?>">
       <?=@$Lx06_codtpemissao?>
    </td>
    <td>
<?
db_input('x06_codtpemissao',4,$Ix06_codtpemissao,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx06_nometpemissao?>">
       <?=@$Lx06_nometpemissao?>
    </td>
    <td>
<?
db_input('x06_nometpemissao',50,$Ix06_nometpemissao,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_aguatpemissao','func_aguatpemissao.php?funcao_js=parent.js_preenchepesquisa|x06_codtpemissao','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_aguatpemissao.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
