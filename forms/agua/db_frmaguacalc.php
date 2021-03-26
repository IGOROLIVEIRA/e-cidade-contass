<?
//MODULO: agua
$claguacalc->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("x19_descr");
$clrotulo->label("x01_numcgm");
      if($db_opcao==1){
 	   $db_action="agu1_aguacalc004.php";
      }else if($db_opcao==2||$db_opcao==22){
 	   $db_action="agu1_aguacalc005.php";
      }else if($db_opcao==3||$db_opcao==33){
 	   $db_action="agu1_aguacalc006.php";
      }
?>
<form name="form1" method="post" action="<?=$db_action?>">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tx22_codcalc?>">
       <?=@$Lx22_codcalc?>
    </td>
    <td>
<?
db_input('x22_codcalc',5,$Ix22_codcalc,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx22_codconsumo?>">
       <?
       db_ancora(@$Lx22_codconsumo,"js_pesquisax22_codconsumo(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('x22_codconsumo',5,$Ix22_codconsumo,true,'text',$db_opcao," onchange='js_pesquisax22_codconsumo(false);'")
?>
       <?
db_input('x19_descr',40,$Ix19_descr,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx22_exerc?>">
       <?=@$Lx22_exerc?>
    </td>
    <td>
<?
db_input('x22_exerc',4,$Ix22_exerc,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx22_mes?>">
       <?=@$Lx22_mes?>
    </td>
    <td>
<?
db_input('x22_mes',2,$Ix22_mes,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx22_matric?>">
       <?
       db_ancora(@$Lx22_matric,"js_pesquisax22_matric(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('x22_matric',10,$Ix22_matric,true,'text',$db_opcao," onchange='js_pesquisax22_matric(false);'")
?>
       <?
db_input('x01_numcgm',10,$Ix01_numcgm,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx22_area?>">
       <?=@$Lx22_area?>
    </td>
    <td>
<?
db_input('x22_area',8,$Ix22_area,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx22_numpre?>">
       <?=@$Lx22_numpre?>
    </td>
    <td>
<?
db_input('x22_numpre',8,$Ix22_numpre,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisax22_codconsumo(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aguacalc','db_iframe_aguaconsumo','func_aguaconsumo.php?funcao_js=parent.js_mostraaguaconsumo1|x19_codconsumo|x19_descr','Pesquisa',true,'0','1','775','390');
  }else{
     if(document.form1.x22_codconsumo.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aguacalc','db_iframe_aguaconsumo','func_aguaconsumo.php?pesquisa_chave='+document.form1.x22_codconsumo.value+'&funcao_js=parent.js_mostraaguaconsumo','Pesquisa',false,'0','1','775','390');
     }else{
       document.form1.x19_descr.value = '';
     }
  }
}
function js_mostraaguaconsumo(chave,erro){
  document.form1.x19_descr.value = chave;
  if(erro==true){
    document.form1.x22_codconsumo.focus();
    document.form1.x22_codconsumo.value = '';
  }
}
function js_mostraaguaconsumo1(chave1,chave2){
  document.form1.x22_codconsumo.value = chave1;
  document.form1.x19_descr.value = chave2;
  db_iframe_aguaconsumo.hide();
}
function js_pesquisax22_matric(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aguacalc','db_iframe_aguabase','func_aguabase.php?funcao_js=parent.js_mostraaguabase1|x01_matric|x01_numcgm','Pesquisa',true,'0','1','775','390');
  }else{
     if(document.form1.x22_matric.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aguacalc','db_iframe_aguabase','func_aguabase.php?pesquisa_chave='+document.form1.x22_matric.value+'&funcao_js=parent.js_mostraaguabase','Pesquisa',false,'0','1','775','390');
     }else{
       document.form1.x01_numcgm.value = '';
     }
  }
}
function js_mostraaguabase(chave,erro){
  document.form1.x01_numcgm.value = chave;
  if(erro==true){
    document.form1.x22_matric.focus();
    document.form1.x22_matric.value = '';
  }
}
function js_mostraaguabase1(chave1,chave2){
  document.form1.x22_matric.value = chave1;
  document.form1.x01_numcgm.value = chave2;
  db_iframe_aguabase.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aguacalc','db_iframe_aguacalc','func_aguacalc.php?funcao_js=parent.js_preenchepesquisa|x22_codcalc','Pesquisa',true,'0','1','775','390');
}
function js_preenchepesquisa(chave){
  db_iframe_aguacalc.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
