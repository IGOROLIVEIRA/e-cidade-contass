<?
//MODULO: contabilidade
$clcodsistema->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tc52_codsis?>">
       <?=@$Lc52_codsis?>
    </td>
    <td>
<?
db_input('c52_codsis',1,$Ic52_codsis,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc52_descr?>">
       <?=@$Lc52_descr?>
    </td>
    <td>
<?
db_input('c52_descr',50,$Ic52_descr,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc52_descrred?>">
       <?=@$Lc52_descrred?>
    </td>
    <td>
<?
$x = array('F'=>'Financeiro','P'=>'Patrimonial','O'=>'Orçamentário','C'=>'Contábil');
db_select('c52_descrred',$x,true,$db_opcao,"");
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
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_codsistema','func_codsistema.php?funcao_js=parent.js_preenchepesquisa|c52_codsis','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_codsistema.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
