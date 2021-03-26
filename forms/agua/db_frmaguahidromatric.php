<?
//MODULO: agua
$claguahidromatric->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("x03_nomemarca");
$clrotulo->label("x15_diametro");
$clrotulo->label("x01_numcgm");
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tx04_codhidrometro?>">
       <?=@$Lx04_codhidrometro?>
    </td>
    <td>
<?
db_input('x04_codhidrometro',6,$Ix04_codhidrometro,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx04_matric?>">
       <?
       db_ancora(@$Lx04_matric,"js_pesquisax04_matric(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('x04_matric',10,$Ix04_matric,true,'text',$db_opcao," onchange='js_pesquisax04_matric(false);'")
?>
       <?
db_input('x01_numcgm',10,$Ix01_numcgm,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx04_coddiametro?>">
       <?
       db_ancora(@$Lx04_coddiametro,"js_pesquisax04_coddiametro(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('x04_coddiametro',4,$Ix04_coddiametro,true,'text',$db_opcao," onchange='js_pesquisax04_coddiametro(false);'")
?>
       <?
db_input('x15_diametro',10,$Ix15_diametro,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx04_codmarca?>">
       <?
       db_ancora(@$Lx04_codmarca,"js_pesquisax04_codmarca(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('x04_codmarca',6,$Ix04_codmarca,true,'text',$db_opcao," onchange='js_pesquisax04_codmarca(false);'")
?>
       <?
db_input('x03_nomemarca',50,$Ix03_nomemarca,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx04_nrohidro?>">
       <?=@$Lx04_nrohidro?>
    </td>
    <td>
<?
db_input('x04_nrohidro',20,$Ix04_nrohidro,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx04_qtddigito?>">
       <?=@$Lx04_qtddigito?>
    </td>
    <td>
<?
db_input('x04_qtddigito',4,$Ix04_qtddigito,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx04_dtinst?>">
       <?=@$Lx04_dtinst?>
    </td>
    <td>
<?
db_inputdata('x04_dtinst',@$x04_dtinst_dia,@$x04_dtinst_mes,@$x04_dtinst_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx04_leitinicial?>">
       <?=@$Lx04_leitinicial?>
    </td>
    <td>
<?
db_input('x04_leitinicial',15,$Ix04_leitinicial,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisax04_codmarca(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_aguahidromarca','func_aguahidromarca.php?funcao_js=parent.js_mostraaguahidromarca1|x03_codmarca|x03_nomemarca','Pesquisa',true);
  }else{
     if(document.form1.x04_codmarca.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_aguahidromarca','func_aguahidromarca.php?pesquisa_chave='+document.form1.x04_codmarca.value+'&funcao_js=parent.js_mostraaguahidromarca','Pesquisa',false);
     }else{
       document.form1.x03_nomemarca.value = '';
     }
  }
}
function js_mostraaguahidromarca(chave,erro){
  document.form1.x03_nomemarca.value = chave;
  if(erro==true){
    document.form1.x04_codmarca.focus();
    document.form1.x04_codmarca.value = '';
  }
}
function js_mostraaguahidromarca1(chave1,chave2){
  document.form1.x04_codmarca.value = chave1;
  document.form1.x03_nomemarca.value = chave2;
  db_iframe_aguahidromarca.hide();
}
function js_pesquisax04_coddiametro(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_aguahidrodiametro','func_aguahidrodiametro.php?funcao_js=parent.js_mostraaguahidrodiametro1|x15_coddiametro|x15_diametro','Pesquisa',true);
  }else{
     if(document.form1.x04_coddiametro.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_aguahidrodiametro','func_aguahidrodiametro.php?pesquisa_chave='+document.form1.x04_coddiametro.value+'&funcao_js=parent.js_mostraaguahidrodiametro','Pesquisa',false);
     }else{
       document.form1.x15_diametro.value = '';
     }
  }
}
function js_mostraaguahidrodiametro(chave,erro){
  document.form1.x15_diametro.value = chave;
  if(erro==true){
    document.form1.x04_coddiametro.focus();
    document.form1.x04_coddiametro.value = '';
  }
}
function js_mostraaguahidrodiametro1(chave1,chave2){
  document.form1.x04_coddiametro.value = chave1;
  document.form1.x15_diametro.value = chave2;
  db_iframe_aguahidrodiametro.hide();
}
function js_pesquisax04_matric(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_aguabase','func_aguabase.php?funcao_js=parent.js_mostraaguabase1|x01_matric|x01_numcgm','Pesquisa',true);
  }else{
     if(document.form1.x04_matric.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_aguabase','func_aguabase.php?pesquisa_chave='+document.form1.x04_matric.value+'&funcao_js=parent.js_mostraaguabase','Pesquisa',false);
     }else{
       document.form1.x01_numcgm.value = '';
     }
  }
}
function js_mostraaguabase(chave,erro){
  document.form1.x01_numcgm.value = chave;
  if(erro==true){
    document.form1.x04_matric.focus();
    document.form1.x04_matric.value = '';
  }
}
function js_mostraaguabase1(chave1,chave2){
  document.form1.x04_matric.value = chave1;
  document.form1.x01_numcgm.value = chave2;
  db_iframe_aguabase.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_aguahidromatric','func_aguahidromatric.php?funcao_js=parent.js_preenchepesquisa|x04_codhidrometro','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_aguahidromatric.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
