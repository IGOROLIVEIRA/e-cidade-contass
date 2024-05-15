<?
//MODULO: contabilidade
$clvinculopcasptce->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tc209_pcaspestrut?>">
    <input name="oid" type="hidden" value="<?=@$oid?>">
       <?=@$Lc209_pcaspestrut?>
    </td>
    <td>
<?
db_input('c209_pcaspestrut',9,$Ic209_pcaspestrut,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc209_tceestrut?>">
       <?=@$Lc209_tceestrut?>
    </td>
    <td>
<?

db_input('c209_tceestrut',9,$Ic209_tceestrut,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr style="display: none;">
    <td nowrap title="<?=@$Tc209_tceestrut?>">
       <?=@$Lc209_tceestrut?>
    </td>
    <td>
    <?
    db_input('pcaspestrut',9,$Ipcaspestrut,true,'text',$db_opcao,"");
    db_input('tceestrut',9,$Itceestrut,true,'text',2,"")
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
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_vinculopcasptce','func_vinculopcasptce.php?funcao_js=parent.js_preenchepesquisa|0|1','Pesquisa',true);
}
function js_preenchepesquisa(chave,chave1){
  document.form1.c209_pcaspestrut.value = chave;
  document.form1.c209_tceestrut.value = chave1;
  document.form1.pcaspestrut.value = chave;
  document.form1.tceestrut.value = chave1;

  db_iframe_vinculopcasptce.hide();
  <?
  if(!$db_opcao){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
