<?
//MODULO: issqn
$clcadescrito->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tq86_numcgm?>">
       <?
       db_ancora(@$Lq86_numcgm,"js_pesquisaq86_numcgm(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('q86_numcgm',6,$Iq86_numcgm,true,'text',$db_opcao," onchange='js_pesquisaq86_numcgm(false);'")
?>
       <?
db_input('z01_nome',40,$Iz01_nome,true,'text',3,'')
       ?>
    </td>
  </tr>
  </table>
  </center>
<input name="db_opcao" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisaq86_numcgm(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cgm','func_nome.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome','Pesquisa',true);
  }else{
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cgm','func_nome.php?pesquisa_chave='+document.form1.q86_numcgm.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false);
  }
}
function js_mostracgm(erro,chave){
  document.form1.z01_nome.value = chave;
  if(erro==true){
    document.form1.q86_numcgm.focus();
    document.form1.q86_numcgm.value = '';
  }
}
function js_mostracgm1(chave1,chave2){
  document.form1.q86_numcgm.value = chave1;
  document.form1.z01_nome.value = chave2;
  db_iframe_cgm.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cadescrito','func_cadescrito.php?funcao_js=parent.js_preenchepesquisa|q86_numcgm','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_cadescrito.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave;";
  }
  ?>
}
</script>
