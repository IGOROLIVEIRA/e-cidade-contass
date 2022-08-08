<?
//MODULO: Sicom
$clrecisaocontrato->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tsi01_codigo?>">
       <?=@$Lsi01_codigo?>
    </td>
    <td>
<?
db_input('si01_codigo',10,$Isi01_codigo,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi01_numcontrato?>">
       <?=@$Lsi01_numcontrato?>
    </td>
    <td>
<?
db_input('si01_numcontrato',20,$Isi01_numcontrato,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi01_dataassinatura?>">
       <?=@$Lsi01_dataassinatura?>
    </td>
    <td>
<?
db_inputdata('si01_dataassinatura',@$si01_dataassinatura_dia,@$si01_dataassinatura_mes,@$si01_dataassinatura_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi01_datarecisao?>">
       <?=@$Lsi01_datarecisao?>
    </td>
    <td>
<?
db_inputdata('si01_datarecisao',@$si01_datarecisao_dia,@$si01_datarecisao_mes,@$si01_datarecisao_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi01_valorcancelado?>">
       <?=@$Lsi01_valorcancelado?>
    </td>
    <td>
<?
db_input('si01_valorcancelado',10,$Isi01_valorcancelado,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi01_ano?>">
       <?=@$Lsi01_ano?>
    </td>
    <td>
<?
db_input('si01_ano',10,$Isi01_ano,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_recisaocontrato','func_recisaocontrato.php?funcao_js=parent.js_preenchepesquisa|si01_codigo','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_recisaocontrato.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
