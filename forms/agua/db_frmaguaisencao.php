<?
//MODULO: agua
$claguaisencao->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("x01_numcgm");
$clrotulo->label("x29_descr");
      if($db_opcao==1){
 	   $db_action="agu1_aguaisencao004.php";
      }else if($db_opcao==2||$db_opcao==22){
 	   $db_action="agu1_aguaisencao005.php";
      }else if($db_opcao==3||$db_opcao==33){
 	   $db_action="agu1_aguaisencao006.php";
      }
?>
<form name="form1" method="post" action="<?=$db_action?>">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tx10_codisencao?>">
       <?=@$Lx10_codisencao?>
    </td>
    <td>
<?
db_input('x10_codisencao',5,$Ix10_codisencao,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx10_codisencaotipo?>">
       <?
       db_ancora(@$Lx10_codisencaotipo,"js_pesquisax10_codisencaotipo(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('x10_codisencaotipo',5,$Ix10_codisencaotipo,true,'text',$db_opcao," onchange='js_pesquisax10_codisencaotipo(false);'")
?>
       <?
db_input('x29_descr',40,$Ix29_descr,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx10_matric?>">
       <?
       db_ancora(@$Lx10_matric,"js_pesquisax10_matric(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('x10_matric',10,$Ix10_matric,true,'text',$db_opcao," onchange='js_pesquisax10_matric(false);'")
?>
       <?
db_input('x01_numcgm',10,$Ix01_numcgm,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx10_obs?>">
       <?=@$Lx10_obs?>
    </td>
    <td>
<?
db_textarea('x10_obs',0,0,$Ix10_obs,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx10_dtini?>">
       <?=@$Lx10_dtini?>
    </td>
    <td>
<?
db_inputdata('x10_dtini',@$x10_dtini_dia,@$x10_dtini_mes,@$x10_dtini_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx10_dtfim?>">
       <?=@$Lx10_dtfim?>
    </td>
    <td>
<?
db_inputdata('x10_dtfim',@$x10_dtfim_dia,@$x10_dtfim_mes,@$x10_dtfim_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx10_processo?>">
       <?=@$Lx10_processo?>
    </td>
    <td>
<?
db_input('x10_processo',5,$Ix10_processo,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisax10_matric(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aguaisencao','db_iframe_aguabase','func_aguabase.php?funcao_js=parent.js_mostraaguabase1|x01_matric|x01_numcgm','Pesquisa',true,'0','1','775','390');
  }else{
     if(document.form1.x10_matric.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aguaisencao','db_iframe_aguabase','func_aguabase.php?pesquisa_chave='+document.form1.x10_matric.value+'&funcao_js=parent.js_mostraaguabase','Pesquisa',false,'0','1','775','390');
     }else{
       document.form1.x01_numcgm.value = '';
     }
  }
}
function js_mostraaguabase(chave,erro){
  document.form1.x01_numcgm.value = chave;
  if(erro==true){
    document.form1.x10_matric.focus();
    document.form1.x10_matric.value = '';
  }
}
function js_mostraaguabase1(chave1,chave2){
  document.form1.x10_matric.value = chave1;
  document.form1.x01_numcgm.value = chave2;
  db_iframe_aguabase.hide();
}
function js_pesquisax10_codisencaotipo(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aguaisencao','db_iframe_aguaisencaotipo','func_aguaisencaotipo.php?funcao_js=parent.js_mostraaguaisencaotipo1|x29_codisencaotipo|x29_descr','Pesquisa',true,'0','1','775','390');
  }else{
     if(document.form1.x10_codisencaotipo.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aguaisencao','db_iframe_aguaisencaotipo','func_aguaisencaotipo.php?pesquisa_chave='+document.form1.x10_codisencaotipo.value+'&funcao_js=parent.js_mostraaguaisencaotipo','Pesquisa',false,'0','1','775','390');
     }else{
       document.form1.x29_descr.value = '';
     }
  }
}
function js_mostraaguaisencaotipo(chave,erro){
  document.form1.x29_descr.value = chave;
  if(erro==true){
    document.form1.x10_codisencaotipo.focus();
    document.form1.x10_codisencaotipo.value = '';
  }
}
function js_mostraaguaisencaotipo1(chave1,chave2){
  document.form1.x10_codisencaotipo.value = chave1;
  document.form1.x29_descr.value = chave2;
  db_iframe_aguaisencaotipo.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aguaisencao','db_iframe_aguaisencao','func_aguaisencao.php?funcao_js=parent.js_preenchepesquisa|x10_codisencao','Pesquisa',true,'0','1','775','390');
}
function js_preenchepesquisa(chave){
  db_iframe_aguaisencao.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
