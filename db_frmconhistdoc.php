<?
//MODULO: contabilidade
$clconhistdoc->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tc53_coddoc?>">
       <?=@$Lc53_coddoc?>
    </td>
    <td>
<?
db_input('c53_coddoc',4,$Ic53_coddoc,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc53_descr?>">
       <?=@$Lc53_descr?>
    </td>
    <td>
<?
db_input('c53_descr',50,$Ic53_descr,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc53_tipo?>">
       <?=@$Lc53_tipo?>
    </td>
    <td>
<?
$x = array('10'=>'Empenho','11'=>'Anula��o de Empenho','20'=>'Liquida��o','21'=>'Anula��o de Liquida��o','30'=>'Pagamento Empenho','31'=>'Estorno Pagamento ','40'=>'Suplementa��o','41'=>'Estorno Suplementa��o','50'=>'Transposi��o','51'=>'Estorno Transporsi��o','60'=>'Redu��o','61'=>'Estorno Redu��o','100'=>'Arrecada��o Receita','101'=>'Estorno Receita','70'=>'Redu��o Transposi��o','71'=>'Estorno Redu��o Transp.');
db_select('c53_tipo',$x,true,$db_opcao,"");
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
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_conhistdoc','func_conhistdoc.php?funcao_js=parent.js_preenchepesquisa|c53_coddoc','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_conhistdoc.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
