<?
//MODULO: licitacao
$clsituacaoitemcompra->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tl218_codigo?>">
    <input name="oid" type="hidden" value="<?=@$oid?>">
       <?=@$Ll218_codigo?>
    </td>
    <td> 
<?
db_input('l218_codigo',8,$Il218_codigo,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl218_codigolicitacao?>">
       <?=@$Ll218_codigolicitacao?>
    </td>
    <td> 
<?
db_input('l218_codigolicitacao',8,$Il218_codigolicitacao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl218_pcorcamitemlic?>">
       <?=@$Ll218_pcorcamitemlic?>
    </td>
    <td> 
<?
db_input('l218_pcorcamitemlic',8,$Il218_pcorcamitemlic,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl218_liclicitem?>">
       <?=@$Ll218_liclicitem?>
    </td>
    <td> 
<?
db_input('l218_liclicitem',8,$Il218_liclicitem,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl218_pcmater?>">
       <?=@$Ll218_pcmater?>
    </td>
    <td> 
<?
db_input('l218_pcmater',8,$Il218_pcmater,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl218_motivoanulacao?>">
       <?=@$Ll218_motivoanulacao?>
    </td>
    <td> 
<?
db_input('l218_motivoanulacao',255,$Il218_motivoanulacao,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('top.corpo','db_iframe_situacaoitemcompra','func_situacaoitemcompra.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_situacaoitemcompra.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
