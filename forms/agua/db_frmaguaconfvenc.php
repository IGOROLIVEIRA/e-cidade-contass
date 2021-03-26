<?
//MODULO: agua
$claguaconfvenc->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tx33_exerc?>">
       <?=@$Lx33_exerc?>
    </td>
    <td>
<?
db_input('x33_exerc',5,$Ix33_exerc,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx33_parcela?>">
       <?=@$Lx33_parcela?>
    </td>
    <td>
<?
db_input('x33_parcela',5,$Ix33_parcela,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx33_dtvenc?>">
       <?=@$Lx33_dtvenc?>
    </td>
    <td>
<?
db_inputdata('x33_dtvenc',@$x33_dtvenc_dia,@$x33_dtvenc_mes,@$x33_dtvenc_ano,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_aguaconfvenc','func_aguaconfvenc.php?funcao_js=parent.js_preenchepesquisa|x33_exerc|x33_parcela','Pesquisa',true);
}
function js_preenchepesquisa(chave,chave1){
  db_iframe_aguaconfvenc.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave+'&chavepesquisa1='+chave1";
  }
  ?>
}
</script>
