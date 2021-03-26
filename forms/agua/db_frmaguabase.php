<?
//MODULO: agua
$claguabase->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("j14_nome");
$clrotulo->label("j13_descr");
$clrotulo->label("z01_nome");
      if($db_opcao==1){
 	   $db_action="agu1_aguabase004.php";
      }else if($db_opcao==2||$db_opcao==22){
 	   $db_action="agu1_aguabase005.php";
      }else if($db_opcao==3||$db_opcao==33){
 	   $db_action="agu1_aguabase006.php";
      }
?>
<form name="form1" method="post" action="<?=$db_action?>">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tx01_matric?>">
       <?=@$Lx01_matric?>
    </td>
    <td>
<?
db_input('x01_matric',10,$Ix01_matric,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx01_numcgm?>">
       <?
       db_ancora(@$Lx01_numcgm,"js_pesquisax01_numcgm(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('x01_numcgm',10,$Ix01_numcgm,true,'text',$db_opcao," onchange='js_pesquisax01_numcgm(false);'")
?>
       <?
db_input('z01_nome',40,$Iz01_nome,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx01_codrua?>">
       <?
       db_ancora(@$Lx01_codrua,"js_pesquisax01_codrua(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('x01_codrua',7,$Ix01_codrua,true,'text',$db_opcao," onchange='js_pesquisax01_codrua(false);'")
?>
       <?
db_input('j14_nome',40,$Ij14_nome,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx01_codbairro?>">
       <?
       db_ancora(@$Lx01_codbairro,"js_pesquisax01_codbairro(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('x01_codbairro',4,$Ix01_codbairro,true,'text',$db_opcao," onchange='js_pesquisax01_codbairro(false);'")
?>
       <?
db_input('j13_descr',40,$Ij13_descr,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx01_numero?>">
       <?=@$Lx01_numero?>
    </td>
    <td>
<?
db_input('x01_numero',6,$Ix01_numero,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx01_quadra?>">
       <?=@$Lx01_quadra?>
    </td>
    <td>
<?
db_input('x01_quadra',6,$Ix01_quadra,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx01_distrito?>">
       <?=@$Lx01_distrito?>
    </td>
    <td>
<?
db_input('x01_distrito',4,$Ix01_distrito,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx01_zona?>">
       <?=@$Lx01_zona?>
    </td>
    <td>
<?
$x = array('1'=>'Zona 1','2'=>'Zona 2','3'=>'Zona 3','4'=>'Zona 4');
db_select('x01_zona',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx01_orientacao?>">
       <?=@$Lx01_orientacao?>
    </td>
    <td>
<?
db_input('x01_orientacao',10,$Ix01_orientacao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx01_rota?>">
       <?=@$Lx01_rota?>
    </td>
    <td>
<?
db_input('x01_rota',4,$Ix01_rota,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx01_qtdeconomia?>">
       <?=@$Lx01_qtdeconomia?>
    </td>
    <td>
<?
db_input('x01_qtdeconomia',4,$Ix01_qtdeconomia,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx01_dtcadastro?>">
       <?=@$Lx01_dtcadastro?>
    </td>
    <td>
<?
db_inputdata('x01_dtcadastro',@$x01_dtcadastro_dia,@$x01_dtcadastro_mes,@$x01_dtcadastro_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx01_qtdponto?>">
       <?=@$Lx01_qtdponto?>
    </td>
    <td>
<?
db_input('x01_qtdponto',4,$Ix01_qtdponto,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx01_obs?>">
       <?=@$Lx01_obs?>
    </td>
    <td>
<?
db_textarea('x01_obs',4,60,$Ix01_obs,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisax01_codrua(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aguabase','db_iframe_ruas','func_ruas.php?funcao_js=parent.js_mostraruas1|j14_codigo|j14_nome','Pesquisa',true,'0','1','775','390');
  }else{
     if(document.form1.x01_codrua.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aguabase','db_iframe_ruas','func_ruas.php?pesquisa_chave='+document.form1.x01_codrua.value+'&funcao_js=parent.js_mostraruas','Pesquisa',false,'0','1','775','390');
     }else{
       document.form1.j14_nome.value = '';
     }
  }
}
function js_mostraruas(chave,erro){
  document.form1.j14_nome.value = chave;
  if(erro==true){
    document.form1.x01_codrua.focus();
    document.form1.x01_codrua.value = '';
  }
}
function js_mostraruas1(chave1,chave2){
  document.form1.x01_codrua.value = chave1;
  document.form1.j14_nome.value = chave2;
  db_iframe_ruas.hide();
}
function js_pesquisax01_codbairro(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aguabase','db_iframe_bairro','func_bairro.php?funcao_js=parent.js_mostrabairro1|j13_codi|j13_descr','Pesquisa',true,'0','1','775','390');
  }else{
     if(document.form1.x01_codbairro.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aguabase','db_iframe_bairro','func_bairro.php?pesquisa_chave='+document.form1.x01_codbairro.value+'&funcao_js=parent.js_mostrabairro','Pesquisa',false,'0','1','775','390');
     }else{
       document.form1.j13_descr.value = '';
     }
  }
}
function js_mostrabairro(chave,erro){
  document.form1.j13_descr.value = chave;
  if(erro==true){
    document.form1.x01_codbairro.focus();
    document.form1.x01_codbairro.value = '';
  }
}
function js_mostrabairro1(chave1,chave2){
  document.form1.x01_codbairro.value = chave1;
  document.form1.j13_descr.value = chave2;
  db_iframe_bairro.hide();
}
function js_pesquisax01_numcgm(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aguabase','db_iframe_cgm','func_cgm.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome','Pesquisa',true,'0','1','775','390');
  }else{
     if(document.form1.x01_numcgm.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aguabase','db_iframe_cgm','func_cgm.php?pesquisa_chave='+document.form1.x01_numcgm.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false,'0','1','775','390');
     }else{
       document.form1.z01_nome.value = '';
     }
  }
}
function js_mostracgm(chave,erro){
  document.form1.z01_nome.value = chave;
  if(erro==true){
    document.form1.x01_numcgm.focus();
    document.form1.x01_numcgm.value = '';
  }
}
function js_mostracgm1(chave1,chave2){
  document.form1.x01_numcgm.value = chave1;
  document.form1.z01_nome.value = chave2;
  db_iframe_cgm.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aguabase','db_iframe_aguabase','func_aguabase.php?funcao_js=parent.js_preenchepesquisa|x01_matric','Pesquisa',true,'0','1','775','390');
}
function js_preenchepesquisa(chave){
  db_iframe_aguabase.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
