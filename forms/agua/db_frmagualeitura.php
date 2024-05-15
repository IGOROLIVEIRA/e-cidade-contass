<?
//MODULO: agua
$clagualeitura->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("x04_codmarca");
$clrotulo->label("x17_descr");
$clrotulo->label("x16_numcgm");
$clrotulo->label("nome");
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tx21_codleitura?>">
       <?=@$Lx21_codleitura?>
    </td>
    <td>
<?
db_input('x21_codleitura',5,$Ix21_codleitura,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx21_codhidrometro?>">
       <?
       db_ancora(@$Lx21_codhidrometro,"js_pesquisax21_codhidrometro(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('x21_codhidrometro',6,$Ix21_codhidrometro,true,'text',$db_opcao," onchange='js_pesquisax21_codhidrometro(false);'")
?>
       <?
db_input('x04_codmarca',6,$Ix04_codmarca,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx21_exerc?>">
       <?=@$Lx21_exerc?>
    </td>
    <td>
<?
db_input('x21_exerc',4,$Ix21_exerc,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx21_mes?>">
       <?=@$Lx21_mes?>
    </td>
    <td>
<?
db_input('x21_mes',2,$Ix21_mes,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx21_situacao?>">
       <?
       db_ancora(@$Lx21_situacao,"js_pesquisax21_situacao(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('x21_situacao',5,$Ix21_situacao,true,'text',$db_opcao," onchange='js_pesquisax21_situacao(false);'")
?>
       <?
db_input('x17_descr',40,$Ix17_descr,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx21_numcgm?>">
       <?
       db_ancora(@$Lx21_numcgm,"js_pesquisax21_numcgm(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('x21_numcgm',10,$Ix21_numcgm,true,'text',$db_opcao," onchange='js_pesquisax21_numcgm(false);'")
?>
       <?
db_input('x16_numcgm',10,$Ix16_numcgm,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx21_dtleitura?>">
       <?=@$Lx21_dtleitura?>
    </td>
    <td>
<?
db_inputdata('x21_dtleitura',@$x21_dtleitura_dia,@$x21_dtleitura_mes,@$x21_dtleitura_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx21_usuario?>">
       <?
       db_ancora(@$Lx21_usuario,"js_pesquisax21_usuario(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('x21_usuario',10,$Ix21_usuario,true,'text',$db_opcao," onchange='js_pesquisax21_usuario(false);'")
?>
       <?
db_input('nome',40,$Inome,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx21_dtinc?>">
       <?=@$Lx21_dtinc?>
    </td>
    <td>
<?
db_inputdata('x21_dtinc',@$x21_dtinc_dia,@$x21_dtinc_mes,@$x21_dtinc_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx21_leitura?>">
       <?=@$Lx21_leitura?>
    </td>
    <td>
<?
db_input('x21_leitura',10,$Ix21_leitura,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx21_consumo?>">
       <?=@$Lx21_consumo?>
    </td>
    <td>
<?
db_input('x21_consumo',10,$Ix21_consumo,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx21_excesso?>">
       <?=@$Lx21_excesso?>
    </td>
    <td>
<?
db_input('x21_excesso',8,$Ix21_excesso,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisax21_codhidrometro(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_aguahidromatric','func_aguahidromatric.php?funcao_js=parent.js_mostraaguahidromatric1|x04_codhidrometro|x04_codmarca','Pesquisa',true);
  }else{
     if(document.form1.x21_codhidrometro.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_aguahidromatric','func_aguahidromatric.php?pesquisa_chave='+document.form1.x21_codhidrometro.value+'&funcao_js=parent.js_mostraaguahidromatric','Pesquisa',false);
     }else{
       document.form1.x04_codmarca.value = '';
     }
  }
}
function js_mostraaguahidromatric(chave,erro){
  document.form1.x04_codmarca.value = chave;
  if(erro==true){
    document.form1.x21_codhidrometro.focus();
    document.form1.x21_codhidrometro.value = '';
  }
}
function js_mostraaguahidromatric1(chave1,chave2){
  document.form1.x21_codhidrometro.value = chave1;
  document.form1.x04_codmarca.value = chave2;
  db_iframe_aguahidromatric.hide();
}
function js_pesquisax21_situacao(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_aguasitleitura','func_aguasitleitura.php?funcao_js=parent.js_mostraaguasitleitura1|x17_codigo|x17_descr','Pesquisa',true);
  }else{
     if(document.form1.x21_situacao.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_aguasitleitura','func_aguasitleitura.php?pesquisa_chave='+document.form1.x21_situacao.value+'&funcao_js=parent.js_mostraaguasitleitura','Pesquisa',false);
     }else{
       document.form1.x17_descr.value = '';
     }
  }
}
function js_mostraaguasitleitura(chave,erro){
  document.form1.x17_descr.value = chave;
  if(erro==true){
    document.form1.x21_situacao.focus();
    document.form1.x21_situacao.value = '';
  }
}
function js_mostraaguasitleitura1(chave1,chave2){
  document.form1.x21_situacao.value = chave1;
  document.form1.x17_descr.value = chave2;
  db_iframe_aguasitleitura.hide();
}
function js_pesquisax21_numcgm(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_agualeiturista','func_agualeiturista.php?funcao_js=parent.js_mostraagualeiturista1|x16_numcgm|x16_numcgm','Pesquisa',true);
  }else{
     if(document.form1.x21_numcgm.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_agualeiturista','func_agualeiturista.php?pesquisa_chave='+document.form1.x21_numcgm.value+'&funcao_js=parent.js_mostraagualeiturista','Pesquisa',false);
     }else{
       document.form1.x16_numcgm.value = '';
     }
  }
}
function js_mostraagualeiturista(chave,erro){
  document.form1.x16_numcgm.value = chave;
  if(erro==true){
    document.form1.x21_numcgm.focus();
    document.form1.x21_numcgm.value = '';
  }
}
function js_mostraagualeiturista1(chave1,chave2){
  document.form1.x21_numcgm.value = chave1;
  document.form1.x16_numcgm.value = chave2;
  db_iframe_agualeiturista.hide();
}
function js_pesquisax21_usuario(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_db_usuarios','func_db_usuarios.php?funcao_js=parent.js_mostradb_usuarios1|id_usuario|nome','Pesquisa',true);
  }else{
     if(document.form1.x21_usuario.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_db_usuarios','func_db_usuarios.php?pesquisa_chave='+document.form1.x21_usuario.value+'&funcao_js=parent.js_mostradb_usuarios','Pesquisa',false);
     }else{
       document.form1.nome.value = '';
     }
  }
}
function js_mostradb_usuarios(chave,erro){
  document.form1.nome.value = chave;
  if(erro==true){
    document.form1.x21_usuario.focus();
    document.form1.x21_usuario.value = '';
  }
}
function js_mostradb_usuarios1(chave1,chave2){
  document.form1.x21_usuario.value = chave1;
  document.form1.nome.value = chave2;
  db_iframe_db_usuarios.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_agualeitura','func_agualeitura.php?funcao_js=parent.js_preenchepesquisa|x21_codleitura','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_agualeitura.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
