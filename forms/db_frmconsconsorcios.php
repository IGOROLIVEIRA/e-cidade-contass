<?
//MODULO: contabilidade
$clconsconsorcios->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");
      if($db_opcao==1){
 	   $db_action="con1_consconsorcios004.php";
      }else if($db_opcao==2||$db_opcao==22){
 	   $db_action="con1_consconsorcios005.php";
      }else if($db_opcao==3||$db_opcao==33){
 	   $db_action="con1_consconsorcios006.php";
      }
?>
<form name="form1" method="post" action="<?=$db_action?>">
<center>
<fieldset style="margin-left: 80px; margin-top: 10px;">
<legend>Consórcio</legend>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tc200_sequencial?>">
       <?=@$Lc200_sequencial?>
    </td>
    <td>
<?
db_input('c200_sequencial',10,$Ic200_sequencial,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc200_codconsorcio?>">
       <?=@$Lc200_codconsorcio?>
    </td>
    <td>
<?
db_input('c200_codconsorcio',10,$Ic200_codconsorcio,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc200_numcgm?>">
       <?
       db_ancora(@$Lc200_numcgm,"js_pesquisac200_numcgm(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('c200_numcgm',10,$Ic200_numcgm,true,'text',$db_opcao," onchange='js_pesquisac200_numcgm(false);'")
?>
       <?
db_input('z01_nome',60,$Iz01_nome,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc200_areaatuacao?>">
       <?=@$Lc200_areaatuacao?>
    </td>
    <td>
<?
$x = array("1"=>"SÁUDE","2"=>"EDUCAÇÃO","3"=>"SANEAMENTO BÁSICO","4"=>"ASSISTENCIA SOCIAL","5"=>"MEIO AMBIENTE","6"=>"Desenvolvimento Socioeconômico e Segurança Alimentar","99"=>"OUTROS");
db_select('c200_areaatuacao',$x,true,$db_opcao,"");
//db_input('',10,$Ic200_areaatuacao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc200_descrarea?>">
       <?=@$Lc200_descrarea?>
    </td>
    <td>
<?
db_textarea('c200_descrarea',15,75,$Ic200_descrarea,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc200_dataadesao?>">
       <?=@$Lc200_dataadesao?>
    </td>
    <td>
<?
db_inputdata('c200_dataadesao',@$c200_dataadesao_dia,@$c200_dataadesao_mes,@$c200_dataadesao_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>

  </table>
  </fieldset>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisac200_numcgm(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_consconsorcios','db_iframe_cgm','func_nome.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome','Pesquisa',true,'0','1');
  }else{
     if(document.form1.c200_numcgm.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_consconsorcios','db_iframe_cgm','func_nome.php?pesquisa_chave='+document.form1.c200_numcgm.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false,'0','1');
     }else{
       document.form1.z01_nome.value = '';
     }
  }
}
function js_mostracgm(erro,chave){
  document.form1.z01_nome.value = chave;
  if(erro==true){
    document.form1.c200_numcgm.focus();
    document.form1.c200_numcgm.value = '';
  }
}
function js_mostracgm1(chave1,chave2){
  document.form1.c200_numcgm.value = chave1;
  document.form1.z01_nome.value = chave2;
  db_iframe_cgm.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo.iframe_consconsorcios','db_iframe_consconsorcios','func_consconsorcios.php?funcao_js=parent.js_preenchepesquisa|c200_sequencial','Pesquisa',true,'0','1');
}
function js_preenchepesquisa(chave){
  db_iframe_consconsorcios.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
