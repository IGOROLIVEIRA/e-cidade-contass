<?
//MODULO: caixa
$clnumpref->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("k06_descr");
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tk03_anousu?>">
       <?=@$Lk03_anousu?>
    </td>
    <td>
<?
$k03_anousu = db_getsession('DB_anousu');
db_input('k03_anousu',5,$Ik03_anousu,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?//=@$Tk03_numpre?>">
       <?//=@$Lk03_numpre?>
    </td>
    <td>
<?
//db_input('k03_numpre',10,$Ik03_numpre,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tk03_defope?>">
       <?=@$Lk03_defope?>
    </td>
    <td>
<?
db_input('k03_defope',5,$Ik03_defope,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tk03_recjur?>">
       <?=@$Lk03_recjur?>
    </td>
    <td>
<?
db_input('k03_recjur',5,$Ik03_recjur,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tk03_numsli?>">
       <?=@$Lk03_numsli?>
    </td>
    <td>
<?
db_input('k03_numsli',5,$Ik03_numsli,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tk03_impend?>">
       <?=@$Lk03_impend?>
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('k03_impend',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tk03_unipri?>">
       <?=@$Lk03_unipri?>
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('k03_unipri',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tk03_codbco?>">
       <?=@$Lk03_codbco?>
    </td>
    <td>
<?
db_input('k03_codbco',5,$Ik03_codbco,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tk03_codage?>">
       <?=@$Lk03_codage?>
    </td>
    <td>
<?
db_input('k03_codage',5,$Ik03_codage,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tk03_recmul?>">
       <?=@$Lk03_recmul?>
    </td>
    <td>
<?
db_input('k03_recmul',5,$Ik03_recmul,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tk03_calrec?>">
       <?=@$Lk03_calrec?>
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('k03_calrec',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tk03_msg?>">
       <?=@$Lk03_msg?>
    </td>
    <td>
<?
db_textarea('k03_msg',0,50,$Ik03_msg,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tk03_msgcarne?>">
       <?=@$Lk03_msgcarne?>
    </td>
    <td>
<?
db_textarea('k03_msgcarne',0,50,$Ik03_msgcarne,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td width="150" title="<?=@$Tk03_msgbanco?>">
       <?=@$Lk03_msgbanco?>
    </td>
    <td>
<?
db_textarea('k03_msgbanco',0,50,$Ik03_msgbanco,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tk03_certissvar?>">
       <?=@$Lk03_certissvar?>
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('k03_certissvar',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tk03_diasjust?>">
       <?=@$Lk03_diasjust?>
    </td>
    <td>
<?
db_input('k03_diasjust',5,$Ik03_diasjust,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tk03_reccert?>">
       <?=@$Lk03_reccert?>
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('k03_reccert',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tk03_taxagrupo?>">
       <?
       db_ancora(@$Lk03_taxagrupo,"js_pesquisak03_taxagrupo(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('k03_taxagrupo',5,$Ik03_taxagrupo,true,'text',$db_opcao," onchange='js_pesquisak03_taxagrupo(false);'")
?>
       <?
db_input('k06_descr',50,$Ik06_descr,true,'text',3,'')
       ?>
    </td>
  </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisak03_taxagrupo(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_taxagrupo','func_taxagrupo.php?funcao_js=parent.js_mostrataxagrupo1|k06_taxagrupo|k06_descr','Pesquisa',true);
  }else{
     if(document.form1.k03_taxagrupo.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_taxagrupo','func_taxagrupo.php?pesquisa_chave='+document.form1.k03_taxagrupo.value+'&funcao_js=parent.js_mostrataxagrupo','Pesquisa',false);
     }else{
       document.form1.k06_descr.value = '';
     }
  }
}
function js_mostrataxagrupo(chave,erro){
  document.form1.k06_descr.value = chave;
  if(erro==true){
    document.form1.k03_taxagrupo.focus();
    document.form1.k03_taxagrupo.value = '';
  }
}
function js_mostrataxagrupo1(chave1,chave2){
  document.form1.k03_taxagrupo.value = chave1;
  document.form1.k06_descr.value = chave2;
  db_iframe_taxagrupo.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_numpref','func_numpref.php?funcao_js=parent.js_preenchepesquisa|k03_anousu','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_numpref.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
