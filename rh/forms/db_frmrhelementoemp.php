<?
//MODULO: pessoal
$clrhelementoemp->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("o56_descr");
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Trh38_seq?>">
       <?=@$Lrh38_seq?>
    </td>
    <td>
<?
db_input('rh38_seq',6,$Irh38_seq,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trh38_codele?>">
       <?
       db_ancora(@$Lrh38_codele,"js_pesquisarh38_codele(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('rh38_codele',6,$Irh38_codele,true,'text',$db_opcao," onchange='js_pesquisarh38_codele(false);'")
?>
       <?
db_input('o56_descr',30,$Io56_descr,true,'text',3,'')
       ?>
    </td>
  </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisarh38_codele(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcelemento','func_orcelementosub.php?funcao_js=parent.js_mostraorcelemento1|o56_codele|o56_descr','Pesquisa',true);
  }else{
     if(document.form1.rh38_codele.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcelemento','func_orcelementosub.php?pesquisa_chave='+document.form1.rh38_codele.value+'&funcao_js=parent.js_mostraorcelemento','Pesquisa',false);
     }else{
       document.form1.o56_descr.value = '';
     }
  }
}
function js_mostraorcelemento(chave,erro){
  document.form1.o56_descr.value = chave;
  if(erro==true){
    document.form1.rh38_codele.focus();
    document.form1.rh38_codele.value = '';
  }
}
function js_mostraorcelemento1(chave1,chave2){
  document.form1.rh38_codele.value = chave1;
  document.form1.o56_descr.value = chave2;
  db_iframe_orcelemento.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_rhelementoemp','func_rhelementoemp.php?funcao_js=parent.js_preenchepesquisa|rh38_seq','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_rhelementoemp.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
