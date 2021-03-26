<?
//MODULO: empenho
$clemppresta->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("e44_descr");
$clrotulo->label("e60_codemp");
      $db_op=3;
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Te60_codemp?>">
       <?=@$Le60_codemp?>
    </td>
    <td>
<?
db_input('e60_codemp',10,$Ie60_codemp,true,'text',3);
db_input('e45_numemp',10,$Ie45_numemp,true,'hidden',3);
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Te45_tipo?>">
       <?
       db_ancora(@$Le45_tipo,"js_pesquisae45_tipo(true);",$db_op);
       ?>
    </td>
    <td>
<?
db_input('e45_tipo',8,$Ie45_tipo,true,'text',$db_op," onchange='js_pesquisae45_tipo(false);'")
?>
       <?
db_input('e44_descr',40,$Ie44_descr,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Te45_data?>">
       <?=@$Le45_data?>
    </td>
    <td>
<?
db_inputdata('e45_data',@$e45_data_dia,@$e45_data_mes,@$e45_data_ano,true,'text',$db_op)
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Te45_obs?>">
       <?=@$Le45_obs?>
    </td>
    <td>
<?
db_textarea('e45_obs',0,40,$Ie45_obs,true,'text',$db_op)
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Te45_conferido?>">
       <?=@$Le45_conferido?>
    </td>
    <td>
<?
db_inputdata('e45_conferido',@$e45_conferido_dia,@$e45_conferido_mes,@$e45_conferido_ano,true,'text',$db_opcao)
?>
    </td>
  </tr>
  </table>
  </center>
<input name="alterar" type="submit" id="db_opcao" value="Atualizar" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisae45_tipo(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_emppresta','db_iframe_empprestatip','func_empprestatip.php?funcao_js=parent.js_mostraempprestatip1|e44_tipo|e44_descr','Pesquisa',true);
  }else{
     if(document.form1.e45_tipo.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_emppresta','db_iframe_empprestatip','func_empprestatip.php?pesquisa_chave='+document.form1.e45_tipo.value+'&funcao_js=parent.js_mostraempprestatip','Pesquisa',false);
     }else{
       document.form1.e44_descr.value = '';
     }
  }
}
function js_mostraempprestatip(chave,erro){
  document.form1.e44_descr.value = chave;
  if(erro==true){
    document.form1.e45_tipo.focus();
    document.form1.e45_tipo.value = '';
  }
}
function js_mostraempprestatip1(chave1,chave2){
  document.form1.e45_tipo.value = chave1;
  document.form1.e44_descr.value = chave2;
  db_iframe_empprestatip.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo.iframe_emppresta','db_iframe_emppresta','func_empprestaconfere.php?funcao_js=parent.js_preenchepesquisa|e60_numemp','Pesquisa',true,0);
}
function js_preenchepesquisa(chave){
  db_iframe_emppresta.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
