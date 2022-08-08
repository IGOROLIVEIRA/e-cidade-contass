<?
//MODULO: issqn
$clativtipo->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("q03_descr");
?>
<form name="form1" method="post" action="">
<center>
<br>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tq80_ativ?>" align="right">
       <?
       db_ancora(@$Lq80_ativ,"js_pesquisaq80_ativ(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('q80_ativ',4,$Iq80_ativ,true,'text',$db_opcao," onchange='js_pesquisaq80_ativ(false);'")
?>
       <?
db_input('q03_descr',40,$Iq03_descr,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center">
      <input name="atualizar" type="button" id="db_opcao" value="Atualizar" onclick="calculos.js_atualizar();" >
    </td>
  </tr>
  <tr>
    <td colspan="2">
       <iframe id="calculos"  frameborder="0" name="calculos"   leftmargin="0" topmargin="0" src="iss1_ativtipo014.php" height="300" width="500">
       </iframe>
    </td>
  </tr>
  </table>
  </center>
</form>
<script>
function js_pesquisaq80_ativ(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_ativid','func_ativid.php?funcao_js=parent.js_mostraativid1|q03_ativ|q03_descr','Pesquisa',true);
  }else{
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_ativid','func_ativid.php?pesquisa_chave='+document.form1.q80_ativ.value+'&funcao_js=parent.js_mostraativid','Pesquisa',false);
  }
}
function js_mostraativid(chave,erro){
  document.form1.q03_descr.value = chave;
  if(erro==true){
    document.form1.q80_ativ.focus();
    document.form1.q80_ativ.value = '';
    calculos.location.href="iss1_ativtipo014.php";
  }else{
    if(document.form1.q80_ativ.value!=""){
      calculos.location.href="iss1_ativtipo014.php?q80_ativ="+document.form1.q80_ativ.value;
    }
  }
}
function js_mostraativid1(chave1,chave2){
  document.form1.q80_ativ.value = chave1;
  document.form1.q03_descr.value = chave2;
  calculos.location.href="iss1_ativtipo014.php?q80_ativ="+chave1;
  db_iframe_ativid.hide();
}
</script>
