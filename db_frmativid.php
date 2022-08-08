<?
//MODULO: issqn
$clativid->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tq03_ativ?>">
       <?=@$Lq03_ativ?>
    </td>
    <td>
<?
db_input('q03_ativ',8,$Iq03_ativ,true,'text',3)
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tq03_descr?>">
       <?=@$Lq03_descr?>
    </td>
    <td>
<?
db_input('q03_descr',40,$Iq03_descr,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tq03_atmemo?>">
       <?=@$Lq03_atmemo?>
    </td>
    <td>
<?
db_textarea('q03_atmemo',0,37,$Iq03_atmemo,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_ativid','func_ativid.php?funcao_js=parent.js_preenchepesquisa|q03_ativ','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_ativid.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave;";
  }
  ?>
}
</script>
