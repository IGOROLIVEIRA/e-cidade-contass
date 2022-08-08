<?
//MODULO: agua
$claguaconsumotipo->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("k02_descr");
$clrotulo->label("k01_descr");
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tx25_codconsumotipo?>">
       <?=@$Lx25_codconsumotipo?>
    </td>
    <td>
<?
db_input('x25_codconsumotipo',5,$Ix25_codconsumotipo,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx25_receit?>">
       <?
       db_ancora(@$Lx25_receit,"js_pesquisax25_receit(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('x25_receit',5,$Ix25_receit,true,'text',$db_opcao," onchange='js_pesquisax25_receit(false);'")
?>
       <?
db_input('k02_descr',15,$Ik02_descr,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx25_descr?>">
       <?=@$Lx25_descr?>
    </td>
    <td>
<?
db_input('x25_descr',40,$Ix25_descr,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx25_codhist?>">
       <?
       db_ancora(@$Lx25_codhist,"js_pesquisax25_codhist(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('x25_codhist',5,$Ix25_codhist,true,'text',$db_opcao," onchange='js_pesquisax25_codhist(false);'")
?>
       <?
db_input('k01_descr',20,$Ik01_descr,true,'text',3,'')
       ?>
    </td>
  </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisax25_receit(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_tabrec','func_tabrec.php?funcao_js=parent.js_mostratabrec1|k02_codigo|k02_descr','Pesquisa',true);
  }else{
     if(document.form1.x25_receit.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_tabrec','func_tabrec.php?pesquisa_chave='+document.form1.x25_receit.value+'&funcao_js=parent.js_mostratabrec','Pesquisa',false);
     }else{
       document.form1.k02_descr.value = '';
     }
  }
}
function js_mostratabrec(chave,erro){
  document.form1.k02_descr.value = chave;
  if(erro==true){
    document.form1.x25_receit.focus();
    document.form1.x25_receit.value = '';
  }
}
function js_mostratabrec1(chave1,chave2){
  document.form1.x25_receit.value = chave1;
  document.form1.k02_descr.value = chave2;
  db_iframe_tabrec.hide();
}
function js_pesquisax25_codhist(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_histcalc','func_histcalc.php?funcao_js=parent.js_mostrahistcalc1|k01_codigo|k01_descr','Pesquisa',true);
  }else{
     if(document.form1.x25_codhist.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_histcalc','func_histcalc.php?pesquisa_chave='+document.form1.x25_codhist.value+'&funcao_js=parent.js_mostrahistcalc','Pesquisa',false);
     }else{
       document.form1.k01_descr.value = '';
     }
  }
}
function js_mostrahistcalc(chave,erro){
  document.form1.k01_descr.value = chave;
  if(erro==true){
    document.form1.x25_codhist.focus();
    document.form1.x25_codhist.value = '';
  }
}
function js_mostrahistcalc1(chave1,chave2){
  document.form1.x25_codhist.value = chave1;
  document.form1.k01_descr.value = chave2;
  db_iframe_histcalc.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_aguaconsumotipo','func_aguaconsumotipo.php?funcao_js=parent.js_preenchepesquisa|x25_codconsumotipo','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_aguaconsumotipo.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
