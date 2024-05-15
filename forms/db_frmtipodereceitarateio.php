<?
//MODULO: contabilidade
$cltipodereceitarateio->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tc218_codigo?>">
       <?=@$Lc218_codigo?>
    </td>
    <td>
<?
db_input('c218_codigo',11,$Ic218_codigo,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc218_descricao?>">
       <?=@$Lc218_descricao?>
    </td>
    <td>
<?
db_input('c218_descricao',50,$Ic218_descricao,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_tipodereceitarateio','func_tipodereceitarateio.php?funcao_js=parent.js_preenchepesquisa|c218_sequencial','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_tipodereceitarateio.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
