<?
//MODULO: contabilidade
$clconlancam->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tc70_codlan?>">
       <?=@$Lc70_codlan?>
    </td>
    <td>
<?
db_input('c70_codlan',8,$Ic70_codlan,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc70_anousu?>">
       <?=@$Lc70_anousu?>
    </td>
    <td>
<?
$c70_anousu = db_getsession('DB_anousu');
db_input('c70_anousu',4,$Ic70_anousu,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc70_data?>">
       <?=@$Lc70_data?>
    </td>
    <td>
<?
db_inputdata('c70_data',@$c70_data_dia,@$c70_data_mes,@$c70_data_ano,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_conlancam','func_conlancam.php?funcao_js=parent.js_preenchepesquisa|c70_codlan','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_conlancam.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
