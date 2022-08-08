<?
//MODULO: agua
$claguasitleitura->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tx17_codigo?>">
       <?=@$Lx17_codigo?>
    </td>
    <td>
<?
db_input('x17_codigo',5,$Ix17_codigo,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx17_descr?>">
       <?=@$Lx17_descr?>
    </td>
    <td>
<?
db_input('x17_descr',40,$Ix17_descr,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx17_regra?>">
       <?=@$Lx17_regra?>
    </td>
    <td>
<?
$x = array('0'=>'Normal','1'=>'Sem Leitura','2'=>'Cancelamento');
db_select('x17_regra',$x,true,$db_opcao,"");
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
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_aguasitleitura','func_aguasitleitura.php?funcao_js=parent.js_preenchepesquisa|x17_codigo','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_aguasitleitura.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
