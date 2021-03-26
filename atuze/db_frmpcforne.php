<?
//MODULO: compras
$clpcforne->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");
      if($db_opcao==1){
 	   $db_action="com1_pcforne004.php";
      }else if($db_opcao==2||$db_opcao==22){
 	   $db_action="com1_pcforne005.php";
      }else if($db_opcao==3||$db_opcao==33){
 	   $db_action="com1_pcforne006.php";
      }
?>
<form name="form1" method="post" action="<?=$db_action?>">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tpc60_numcgm?>">
       <?
       db_ancora(@$Lpc60_numcgm,"js_pesquisapc60_numcgm(true);",($db_opcao==1?$db_opcao:3));
       ?>
    </td>
    <td>
<?
db_input('pc60_numcgm',8,$Ipc60_numcgm,true,'text',($db_opcao==1?$db_opcao:3)," onchange='js_pesquisapc60_numcgm(false);'")
?>
       <?
db_input('z01_nome',40,$Iz01_nome,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tpc60_dtlanc?>">
       <?=@$Lpc60_dtlanc?>
    </td>
    <td>
<?
db_inputdata('pc60_dtlanc',date("d",db_getsession("DB_datausu")),date("m",db_getsession("DB_datausu")),date("Y",db_getsession("DB_datausu")),true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tpc60_obs?>">
       <?=@$Lpc60_obs?>
    </td>
    <td>
<?
db_textarea('pc60_obs',2,80,$Ipc60_obs,true,'text',$db_opcao,"","","")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tpc60_bloqueado?>">
       <?=@$Lpc60_bloqueado?>
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('pc60_bloqueado',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisapc60_numcgm(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_pcforne','db_iframe_cgm','func_nome.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome','Pesquisa',true,'0','1','775','390');
  }else{
     if(document.form1.pc60_numcgm.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_pcforne','db_iframe_cgm','func_nome.php?pesquisa_chave='+document.form1.pc60_numcgm.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false,'0','1','775','390');
     }else{
       document.form1.z01_nome.value = '';
     }
  }
}
function js_mostracgm(erro,chave){
  document.form1.z01_nome.value = chave;
  if(erro==true){
    document.form1.pc60_numcgm.focus();
    document.form1.pc60_numcgm.value = '';
  }
}
function js_mostracgm1(chave1,chave2){
  document.form1.pc60_numcgm.value = chave1;
  document.form1.z01_nome.value = chave2;
  db_iframe_cgm.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo.iframe_pcforne','db_iframe_pcforne','func_pcforne.php?funcao_js=parent.js_preenchepesquisa|pc60_numcgm','Pesquisa',true,'0','1','775','390');
}
function js_preenchepesquisa(chave){
  db_iframe_pcforne.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
