<?
//MODULO: agua
$claguacorresp->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("j13_descr");
$clrotulo->label("j14_nome");
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tx02_codcorresp?>">
       <?=@$Lx02_codcorresp?>
    </td>
    <td>
<?
db_input('x02_codcorresp',10,$Ix02_codcorresp,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx02_codbairro?>">
       <?
       db_ancora(@$Lx02_codbairro,"js_pesquisax02_codbairro(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('x02_codbairro',4,$Ix02_codbairro,true,'text',$db_opcao," onchange='js_pesquisax02_codbairro(false);'")
?>
       <?
db_input('j13_descr',40,$Ij13_descr,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx02_codrua?>">
       <?
       db_ancora(@$Lx02_codrua,"js_pesquisax02_codrua(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('x02_codrua',7,$Ix02_codrua,true,'text',$db_opcao," onchange='js_pesquisax02_codrua(false);'")
?>
       <?
db_input('j14_nome',40,$Ij14_nome,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx02_numero?>">
       <?=@$Lx02_numero?>
    </td>
    <td>
<?
db_input('x02_numero',4,$Ix02_numero,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx02_complemento?>">
       <?=@$Lx02_complemento?>
    </td>
    <td>
<?
db_input('x02_complemento',20,$Ix02_complemento,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx02_rota?>">
       <?=@$Lx02_rota?>
    </td>
    <td>
<?
db_input('x02_rota',4,$Ix02_rota,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx02_orientacao?>">
       <?=@$Lx02_orientacao?>
    </td>
    <td>
<?
db_input('x02_orientacao',10,$Ix02_orientacao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisax02_codbairro(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_bairro','func_bairro.php?funcao_js=parent.js_mostrabairro1|j13_codi|j13_descr','Pesquisa',true);
  }else{
     if(document.form1.x02_codbairro.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_bairro','func_bairro.php?pesquisa_chave='+document.form1.x02_codbairro.value+'&funcao_js=parent.js_mostrabairro','Pesquisa',false);
     }else{
       document.form1.j13_descr.value = '';
     }
  }
}
function js_mostrabairro(chave,erro){
  document.form1.j13_descr.value = chave;
  if(erro==true){
    document.form1.x02_codbairro.focus();
    document.form1.x02_codbairro.value = '';
  }
}
function js_mostrabairro1(chave1,chave2){
  document.form1.x02_codbairro.value = chave1;
  document.form1.j13_descr.value = chave2;
  db_iframe_bairro.hide();
}
function js_pesquisax02_codrua(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_ruas','func_ruas.php?funcao_js=parent.js_mostraruas1|j14_codigo|j14_nome','Pesquisa',true);
  }else{
     if(document.form1.x02_codrua.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_ruas','func_ruas.php?pesquisa_chave='+document.form1.x02_codrua.value+'&funcao_js=parent.js_mostraruas','Pesquisa',false);
     }else{
       document.form1.j14_nome.value = '';
     }
  }
}
function js_mostraruas(chave,erro){
  document.form1.j14_nome.value = chave;
  if(erro==true){
    document.form1.x02_codrua.focus();
    document.form1.x02_codrua.value = '';
  }
}
function js_mostraruas1(chave1,chave2){
  document.form1.x02_codrua.value = chave1;
  document.form1.j14_nome.value = chave2;
  db_iframe_ruas.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_aguacorresp','func_aguacorresp.php?funcao_js=parent.js_preenchepesquisa|x02_codcorresp','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_aguacorresp.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
