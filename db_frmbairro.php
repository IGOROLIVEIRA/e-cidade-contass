<?
//MODULO: cadastro
$clbairro->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tj13_codi?>">
       <?=@$Lj13_codi?>
    </td>
    <td>
<?
db_input('j13_codi',4,$Ij13_codi,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tj13_descr?>">
       <?=@$Lj13_descr?>
    </td>
    <td>
<?
db_input('j13_descr',40,$Ij13_descr,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tj13_codant?>">
       <?=@$Lj13_codant?>
    </td>
    <td>
<?
db_input('j13_codant',10,$Ij13_codant,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tj13_rural?>">
       <?=@$Lj13_rural?>
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('j13_rural',$x,true,$db_opcao,"");
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
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_bairro','func_bairro.php?funcao_js=parent.js_preenchepesquisa|j13_codi','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_bairro.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave;";
  }
  ?>
}
</script>
