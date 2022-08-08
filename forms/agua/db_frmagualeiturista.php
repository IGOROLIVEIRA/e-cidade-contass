<?
//MODULO: agua
$clagualeiturista->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tx16_numcgm?>">
       <?
       db_ancora(@$Lx16_numcgm,"js_pesquisax16_numcgm(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('x16_numcgm',10,$Ix16_numcgm,true,'text',$db_opcao," onchange='js_pesquisax16_numcgm(false);'")
?>
       <?
db_input('z01_nome',40,$Iz01_nome,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx16_dtini?>">
       <?=@$Lx16_dtini?>
    </td>
    <td>
<?
db_inputdata('x16_dtini',@$x16_dtini_dia,@$x16_dtini_mes,@$x16_dtini_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx16_dtfim?>">
       <?=@$Lx16_dtfim?>
    </td>
    <td>
<?
db_inputdata('x16_dtfim',@$x16_dtfim_dia,@$x16_dtfim_mes,@$x16_dtfim_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisax16_numcgm(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cgm','func_cgm.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome','Pesquisa',true);
  }else{
     if(document.form1.x16_numcgm.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cgm','func_cgm.php?pesquisa_chave='+document.form1.x16_numcgm.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false);
     }else{
       document.form1.z01_nome.value = '';
     }
  }
}
function js_mostracgm(chave,erro){
  document.form1.z01_nome.value = chave;
  if(erro==true){
    document.form1.x16_numcgm.focus();
    document.form1.x16_numcgm.value = '';
  }
}
function js_mostracgm1(chave1,chave2){
  document.form1.x16_numcgm.value = chave1;
  document.form1.z01_nome.value = chave2;
  db_iframe_cgm.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_agualeiturista','func_agualeiturista.php?funcao_js=parent.js_preenchepesquisa|x16_numcgm','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_agualeiturista.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
