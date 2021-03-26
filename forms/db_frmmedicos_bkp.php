<?
//MODULO: saude
$clmedicos->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tsd03_i_codigo?>">
       <?
       db_ancora(@$Lsd03_i_codigo,"js_pesquisasd03_i_codigo(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('sd03_i_codigo',10,$Isd03_i_codigo,true,'text',$db_opcao," onchange='js_pesquisasd03_i_codigo(false);'")
?>
       <?
db_input('z01_nome',40,$Iz01_nome,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsd03_i_crm?>">
       <?=@$Lsd03_i_crm?>
    </td>
    <td>
<?
db_input('sd03_i_crm',10,$Isd03_i_crm,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsd03_d_ausencia1?>">
       <?=@$Lsd03_d_ausencia1?>
    </td>
    <td>
<?
db_inputdata('sd03_d_ausencia1',@$sd03_d_ausencia1_dia,@$sd03_d_ausencia1_mes,@$sd03_d_ausencia1_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsd03_d_ausencia2?>">
       <?=@$Lsd03_d_ausencia2?>
    </td>
    <td>
<?
db_inputdata('sd03_d_ausencia2',@$sd03_d_ausencia2_dia,@$sd03_d_ausencia2_mes,@$sd03_d_ausencia2_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsd03_i_numerodias?>">
       <?=@$Lsd03_i_numerodias?>
    </td>
    <td>
<?
db_input('sd03_i_numerodias',10,$Isd03_i_numerodias,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisasd03_i_codigo(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cgm','func_cgm.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome','Pesquisa',true);
  }else{
     if(document.form1.sd03_i_codigo.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cgm','func_cgm.php?pesquisa_chave='+document.form1.sd03_i_codigo.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false);
     }else{
       document.form1.z01_nome.value = '';
     }
  }
}
function js_mostracgm(chave,erro){
  document.form1.z01_nome.value = chave;
  if(erro==true){
    document.form1.sd03_i_codigo.focus();
    document.form1.sd03_i_codigo.value = '';
  }
}
function js_mostracgm1(chave1,chave2){
  document.form1.sd03_i_codigo.value = chave1;
  document.form1.z01_nome.value = chave2;
  db_iframe_cgm.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_medicos','func_medicos.php?funcao_js=parent.js_preenchepesquisa|sd03_i_codigo','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_medicos.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
