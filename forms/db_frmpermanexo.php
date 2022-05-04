<?
//MODULO: protocolo
$clpermanexo->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tp202_sequencial?>">
    <input name="oid" type="hidden" value="<?=@$oid?>">
       <?=@$Lp202_sequencial?>
    </td>
    <td> 
<?
db_input('p202_sequencial',11,$Ip202_sequencial,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tp202_tipo?>">
       <?=@$Lp202_tipo?>
    </td>
    <td> 
<?
db_input('p202_tipo',200,$Ip202_tipo,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('top.corpo','db_iframe_permanexo','func_permanexo.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_permanexo.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
