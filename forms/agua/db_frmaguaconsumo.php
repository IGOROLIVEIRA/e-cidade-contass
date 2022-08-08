<?
//MODULO: agua
$claguaconsumo->rotulo->label();
      if($db_opcao==1){
 	   $db_action="agu1_aguaconsumo004.php";
      }else if($db_opcao==2||$db_opcao==22){
 	   $db_action="agu1_aguaconsumo005.php";
      }else if($db_opcao==3||$db_opcao==33){
 	   $db_action="agu1_aguaconsumo006.php";
      }
?>
<form name="form1" method="post" action="<?=$db_action?>">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tx19_codconsumo?>">
       <?=@$Lx19_codconsumo?>
    </td>
    <td>
<?
db_input('x19_codconsumo',5,$Ix19_codconsumo,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx19_exerc?>">
       <?=@$Lx19_exerc?>
    </td>
    <td>
<?
db_input('x19_exerc',4,$Ix19_exerc,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx19_areaini?>">
       <?=@$Lx19_areaini?>
    </td>
    <td>
<?
db_input('x19_areaini',8,$Ix19_areaini,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx19_areafim?>">
       <?=@$Lx19_areafim?>
    </td>
    <td>
<?
db_input('x19_areafim',8,$Ix19_areafim,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx19_caract?>">
       <?=@$Lx19_caract?>
    </td>
    <td>
<?
db_input('x19_caract',5,$Ix19_caract,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx19_conspadrao?>">
       <?=@$Lx19_conspadrao?>
    </td>
    <td>
<?
db_input('x19_conspadrao',10,$Ix19_conspadrao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx19_descr?>">
       <?=@$Lx19_descr?>
    </td>
    <td>
<?
db_input('x19_descr',40,$Ix19_descr,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx19_ativo?>">
       <?=@$Lx19_ativo?>
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('x19_ativo',$x,true,$db_opcao,"");
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
  js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aguaconsumo','db_iframe_aguaconsumo','func_aguaconsumo.php?funcao_js=parent.js_preenchepesquisa|x19_codconsumo','Pesquisa',true,'0','1','775','390');
}
function js_preenchepesquisa(chave){
  db_iframe_aguaconsumo.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
