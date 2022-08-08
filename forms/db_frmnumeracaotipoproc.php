<?
//MODULO: protocolo
$clnumeracaotipoproc->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td>
<?
db_input('p200_codigo',8,$Ip200_codigo,true,'hidden',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tp200_ano?>">
       <?=@$Lp200_ano?>
    </td>
    <td>
<?
db_input('p200_ano',4,$Ip200_ano,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tp200_numeracao?>">
       <?=@$Lp200_numeracao?>
    </td>
    <td>
<?
db_input('p200_numeracao',10,$Ip200_numeracao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
<?
db_input('p200_tipoproc',10,$Ip200_tipoproc,true,'hidden',$db_opcao,"")
?>
    </td>
  </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="hidden" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_numeracaotipoproc','func_numeracaotipoproc.php?funcao_js=parent.js_preenchepesquisa|p200_codigo','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_numeracaotipoproc.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
