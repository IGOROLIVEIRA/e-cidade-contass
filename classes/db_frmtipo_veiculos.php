<?
//MODULO: Trânsito
$cltipo_veiculos->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Ttr05_id?>">
       <?=@$Ltr05_id?>
    </td>
    <td>
<?
db_input('tr05_id',5,$Itr05_id,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Ttr05_descr?>">
       <?=@$Ltr05_descr?>
    </td>
    <td>
<?
db_input('tr05_descr',35,$Itr05_descr,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </table>
  </center>
<input name="db_opcao" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_tipo_veiculos','func_tipo_veiculos.php?funcao_js=parent.js_preenchepesquisa|tr05_id','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_tipo_veiculos.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave;";
  }
  ?>
}
</script>
