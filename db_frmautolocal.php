<?
//MODULO: fiscal
$clautolocal->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("y50_codauto");
$clrotulo->label("j14_nome");
$clrotulo->label("j13_descr");
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Ty14_codauto?>">
       <?
       db_ancora(@$Ly14_codauto,"js_pesquisay14_codauto(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('y14_codauto',10,$Iy14_codauto,true,'text',$db_opcao," onchange='js_pesquisay14_codauto(false);'")
?>
       <?
db_input('y50_codauto',10,$Iy50_codauto,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Ty14_codigo?>">
       <?
       db_ancora(@$Ly14_codigo,"js_pesquisay14_codigo(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('y14_codigo',7,$Iy14_codigo,true,'text',$db_opcao," onchange='js_pesquisay14_codigo(false);'")
?>
       <?
db_input('j14_nome',40,$Ij14_nome,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Ty14_codi?>">
       <?
       db_ancora(@$Ly14_codi,"js_pesquisay14_codi(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('y14_codi',4,$Iy14_codi,true,'text',$db_opcao," onchange='js_pesquisay14_codi(false);'")
?>
       <?
db_input('j13_descr',40,$Ij13_descr,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Ty14_numero?>">
       <?=@$Ly14_numero?>
    </td>
    <td>
<?
db_input('y14_numero',10,$Iy14_numero,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Ty14_compl?>">
       <?=@$Ly14_compl?>
    </td>
    <td>
<?
db_input('y14_compl',20,$Iy14_compl,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </table>
  </center>
<input name="db_opcao" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisay14_codauto(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_auto','func_auto.php?funcao_js=parent.js_mostraauto1|y50_codauto|y50_codauto','Pesquisa',true);
  }else{
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_auto','func_auto.php?pesquisa_chave='+document.form1.y14_codauto.value+'&funcao_js=parent.js_mostraauto','Pesquisa',false);
  }
}
function js_mostraauto(chave,erro){
  document.form1.y50_codauto.value = chave;
  if(erro==true){
    document.form1.y14_codauto.focus();
    document.form1.y14_codauto.value = '';
  }
}
function js_mostraauto1(chave1,chave2){
  document.form1.y14_codauto.value = chave1;
  document.form1.y50_codauto.value = chave2;
  db_iframe_auto.hide();
}
function js_pesquisay14_codigo(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_ruas','func_ruas.php?funcao_js=parent.js_mostraruas1|j14_codigo|j14_nome','Pesquisa',true);
  }else{
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_ruas','func_ruas.php?pesquisa_chave='+document.form1.y14_codigo.value+'&funcao_js=parent.js_mostraruas','Pesquisa',false);
  }
}
function js_mostraruas(chave,erro){
  document.form1.j14_nome.value = chave;
  if(erro==true){
    document.form1.y14_codigo.focus();
    document.form1.y14_codigo.value = '';
  }
}
function js_mostraruas1(chave1,chave2){
  document.form1.y14_codigo.value = chave1;
  document.form1.j14_nome.value = chave2;
  db_iframe_ruas.hide();
}
function js_pesquisay14_codi(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_bairro','func_bairro.php?funcao_js=parent.js_mostrabairro1|j13_codi|j13_descr','Pesquisa',true);
  }else{
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_bairro','func_bairro.php?pesquisa_chave='+document.form1.y14_codi.value+'&funcao_js=parent.js_mostrabairro','Pesquisa',false);
  }
}
function js_mostrabairro(chave,erro){
  document.form1.j13_descr.value = chave;
  if(erro==true){
    document.form1.y14_codi.focus();
    document.form1.y14_codi.value = '';
  }
}
function js_mostrabairro1(chave1,chave2){
  document.form1.y14_codi.value = chave1;
  document.form1.j13_descr.value = chave2;
  db_iframe_bairro.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_autolocal','func_autolocal.php?funcao_js=parent.js_preenchepesquisa|y14_codauto','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_autolocal.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
