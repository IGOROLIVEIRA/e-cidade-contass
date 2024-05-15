<?
//MODULO: contabilidade
$clemprestosemdesponi->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("e60_numcgm");
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tc218_anousu?>">
       <?=@$Lc218_anousu?>
    </td>
    <td>
<?
$c218_anousu = db_getsession('DB_anousu');
db_input('c218_anousu',8,$Ic218_anousu,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc218_numemp?>">
       <?
       db_ancora(@$Lc218_numemp,"js_pesquisac218_numemp(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('c218_numemp',8,$Ic218_numemp,true,'text',$db_opcao," onchange='js_pesquisac218_numemp(false);'")
?>
       <?
db_input('e60_numcgm',10,$Ie60_numcgm,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc218_valorpago?>">
       <?=@$Lc218_valorpago?>
    </td>
    <td>
<?
db_input('c218_valorpago',14,$Ic218_valorpago,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisac218_numemp(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_empempenho','func_empempenho.php?funcao_js=parent.js_mostraempempenho1|e60_numemp|e60_numcgm','Pesquisa',true);
  }else{
     if(document.form1.c218_numemp.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_empempenho','func_empempenho.php?pesquisa_chave='+document.form1.c218_numemp.value+'&funcao_js=parent.js_mostraempempenho','Pesquisa',false);
     }else{
       document.form1.e60_numcgm.value = '';
     }
  }
}
function js_mostraempempenho(chave,erro){
  document.form1.e60_numcgm.value = chave;
  if(erro==true){
    document.form1.c218_numemp.focus();
    document.form1.c218_numemp.value = '';
  }
}
function js_mostraempempenho1(chave1,chave2){
  document.form1.c218_numemp.value = chave1;
  document.form1.e60_numcgm.value = chave2;
  db_iframe_empempenho.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_emprestosemdesponi','func_emprestosemdesponi.php?funcao_js=parent.js_preenchepesquisa|c218_numemp|c218_anousu','Pesquisa',true);
}
function js_preenchepesquisa(chave,chave1){
  db_iframe_emprestosemdesponi.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave+'&chavepesquisa1='+chave1";
  }
  ?>
}
</script>
