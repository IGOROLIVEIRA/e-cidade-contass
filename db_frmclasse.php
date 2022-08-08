<?
//MODULO: issqn
$clclasse->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tq12_classe?>">
       <?=@$Lq12_classe?>
    </td>
    <td>
<?
db_input('q12_classe',4,$Iq12_classe,true,'text',3)
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tq12_descr?>">
       <?=@$Lq12_descr?>
    </td>
    <td>
<?
db_input('q12_descr',40,$Iq12_descr,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_classe','func_classe.php?funcao_js=parent.js_preenchepesquisa|q12_classe','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_classe.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave;";
  }
  ?>
}
</script>
