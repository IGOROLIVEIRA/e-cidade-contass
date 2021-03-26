<?
//MODULO: agua
$claguacondominio->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("x01_numcgm");
      if($db_opcao==1){
 	   $db_action="agu1_aguacondominio004.php";
      }else if($db_opcao==2||$db_opcao==22){
 	   $db_action="agu1_aguacondominio005.php";
      }else if($db_opcao==3||$db_opcao==33){
 	   $db_action="agu1_aguacondominio006.php";
      }
?>
<form name="form1" method="post" action="<?=$db_action?>">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tx31_codcondominio?>">
       <?=@$Lx31_codcondominio?>
    </td>
    <td>
<?
db_input('x31_codcondominio',8,$Ix31_codcondominio,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx31_matric?>">
       <?
       db_ancora(@$Lx31_matric,"js_pesquisax31_matric(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('x31_matric',10,$Ix31_matric,true,'text',$db_opcao," onchange='js_pesquisax31_matric(false);'")
?>
       <?
db_input('x01_numcgm',10,$Ix01_numcgm,true,'text',3,'')
       ?>
    </td>
  </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisax31_matric(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aguacondominio','db_iframe_aguabase','func_aguabase.php?funcao_js=parent.js_mostraaguabase1|x01_matric|x01_numcgm','Pesquisa',true,'0','1','775','390');
  }else{
     if(document.form1.x31_matric.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aguacondominio','db_iframe_aguabase','func_aguabase.php?pesquisa_chave='+document.form1.x31_matric.value+'&funcao_js=parent.js_mostraaguabase','Pesquisa',false,'0','1','775','390');
     }else{
       document.form1.x01_numcgm.value = '';
     }
  }
}
function js_mostraaguabase(chave,erro){
  document.form1.x01_numcgm.value = chave;
  if(erro==true){
    document.form1.x31_matric.focus();
    document.form1.x31_matric.value = '';
  }
}
function js_mostraaguabase1(chave1,chave2){
  document.form1.x31_matric.value = chave1;
  document.form1.x01_numcgm.value = chave2;
  db_iframe_aguabase.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aguacondominio','db_iframe_aguacondominio','func_aguacondominio.php?funcao_js=parent.js_preenchepesquisa|x31_codcondominio','Pesquisa',true,'0','1','775','390');
}
function js_preenchepesquisa(chave){
  db_iframe_aguacondominio.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
