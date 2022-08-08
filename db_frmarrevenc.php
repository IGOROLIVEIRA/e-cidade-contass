<?
//MODULO: caixa
$clarrevenc->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tk00_numpre?>">
    <input name="oid" type="hidden" value="<?=@$oid?>">
       <?=@$Lk00_numpre?>
    </td>
    <td>
<?
db_input('k00_numpre',8,$Ik00_numpre,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tk00_numpar?>">
       <?=@$Lk00_numpar?>
    </td>
    <td>
<?
db_input('k00_numpar',4,$Ik00_numpar,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tk00_dtini?>">
       <?=@$Lk00_dtini?>
    </td>
    <td>
<?
db_inputdata('k00_dtini',@$k00_dtini_dia,@$k00_dtini_mes,@$k00_dtini_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tk00_dtfim?>">
       <?=@$Lk00_dtfim?>
    </td>
    <td>
<?
db_inputdata('k00_dtfim',@$k00_dtfim_dia,@$k00_dtfim_mes,@$k00_dtfim_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tk00_obs?>">
       <?=@$Lk00_obs?>
    </td>
    <td>
<?
db_textarea('k00_obs',3,40,$Ik00_obs,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_arrevenc','func_arrevenc.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_arrevenc.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave;";
  }
  ?>
}
</script>
