<?
//MODULO: contabilidade
$clconclass->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tc51_codcla?>">
       <?=@$Lc51_codcla?>
    </td>
    <td>
<?
db_input('c51_codcla',2,$Ic51_codcla,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc51_descr?>">
       <?=@$Lc51_descr?>
    </td>
    <td>
<?
db_input('c51_descr',50,$Ic51_descr,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_conclass','func_conclass.php?funcao_js=parent.js_preenchepesquisa|c51_codcla','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_conclass.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
