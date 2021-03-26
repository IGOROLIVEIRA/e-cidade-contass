<?
//MODULO: veiculos
$clveiccaddestino->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tve75_sequencial?>">
       <?=@$Lve75_sequencial?>
    </td>
    <td>
<?
db_input('ve75_sequencial',9,$Ive75_sequencial,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tve75_destino?>">
       <?=@$Lve75_destino?>
    </td>
    <td>
<?
db_input('ve75_destino',30,$Ive75_destino,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </table>
  </center>
<input id="btnEnviar" name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisa(){
  qry = "&enviadescr=true";
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_veiccaddestino','func_veiccaddestino.php?funcao_js=parent.js_preenchepesquisa|ve75_sequencial|ve75_destino'+qry,'Pesquisa',true);
}
function js_preenchepesquisa(chave,chave1){
  db_iframe_veiccaddestino.hide();
  document.form1.ve75_sequencial.value = chave;
  document.form1.ve75_destino.value = chave1;
  document.form1.btnEnviar.value = 'Alterar';
  document.form1.btnEnviar.name = 'alterar';
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
