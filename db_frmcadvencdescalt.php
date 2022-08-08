<?
//MODULO: issqn
$clcadvencdesc->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("k00_descr");
$clrotulo->label("k01_descr");
$clrotulo->label("codbco");
$clrotulo->label("nomebco");
$clrotulo->label("k15_codigo");
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tq92_codigo?>">
       <?=@$Lq92_codigo?>
<?
db_input('tavainclu',5,10,true,'hidden',1);
// este campo sera preenchido apenas quando o sistema incluir um registro e for para alteração
?>
    </td>
    <td>
<?
db_input('q92_codigo',5,$Iq92_codigo,true,'text',3)
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tq92_descr?>">
       <?=@$Lq92_descr?>
    </td>
    <td>
<?
db_input('q92_descr',40,$Iq92_descr,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tk15_codigo?>">
       <?
       db_ancora(@$Lcodbco,"js_banco(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('k15_codigo',5,$Ik15_codigo,true,'text',$db_opcao," onchange='js_banco(false);'","","E6E4F1")
?>
       <?
db_input('nomebco',40,$Inomebco,true,'text',3,'',"","E6E4F1")
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tq92_tipo?>">
       <?
       db_ancora(@$Lq92_tipo,"js_pesquisaq92_tipo(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('q92_tipo',5,$Iq92_tipo,true,'text',$db_opcao," onchange='js_pesquisaq92_tipo(false);'")
?>
       <?
db_input('k00_descr',40,$Ik00_descr,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tq92_hist?>">
       <?
       db_ancora(@$Lq92_hist,"js_pesquisaq92_hist(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('q92_hist',5,$Iq92_hist,true,'text',$db_opcao," onchange='js_pesquisaq92_hist(false);'")
?>
       <?
db_input('k01_descr',40,$Ik01_descr,true,'text',3,'')
       ?>
    </td>
  </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<?
  if(!(isset($tavainclu) && $tavainclu==true)){
?>
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
<?
  }
?>
</form>
<script>
function js_banco(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_cadvencdesc','db_iframe_banco','func_cadban.php?funcao_js=parent.js_mostrabanco1|k15_codigo|nomebco','Pesquisa',true,0);
  }else{
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_cadvencdesc','db_iframe_banco','func_cadban.php?pesquisa_chave='+document.form1.k15_codigo.value+'&funcao_js=parent.js_mostrabanco','Pesquisa',false,0);
  }
}
function js_mostrabanco(chave,erro){
  document.form1.nomebco.value = chave;
  if(erro==true){
    document.form1.k15_codigo.focus();
    document.form1.k15_codigo.value = '';
  }
}
function js_mostrabanco1(chave1,chave2){
  document.form1.k15_codigo.value = chave1;
  document.form1.nomebco.value = chave2;
  db_iframe_banco.hide();
}
function js_pesquisaq92_tipo(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_cadvencdesc','db_iframe_arretipo','func_arretipo.php?funcao_js=parent.js_mostraarretipo1|k00_tipo|k00_descr','Pesquisa',true,0);
  }else{
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_cadvencdesc','db_iframe_arretipo','func_arretipo.php?pesquisa_chave='+document.form1.q92_tipo.value+'&funcao_js=parent.js_mostraarretipo','Pesquisa',false,0);
  }
}
function js_mostraarretipo(chave,erro){
  document.form1.k00_descr.value = chave;
  if(erro==true){
    document.form1.q92_tipo.focus();
    document.form1.q92_tipo.value = '';
  }
}
function js_mostraarretipo1(chave1,chave2){
  document.form1.q92_tipo.value = chave1;
  document.form1.k00_descr.value = chave2;
  db_iframe_arretipo.hide();
}
function js_pesquisaq92_hist(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_cadvencdesc','db_iframe_histcalc','func_histcalc.php?funcao_js=parent.js_mostrahistcalc1|k01_codigo|k01_descr','Pesquisa',true,0);
  }else{
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_cadvencdesc','db_iframe_histcalc','func_histcalc.php?pesquisa_chave='+document.form1.q92_hist.value+'&funcao_js=parent.js_mostrahistcalc','Pesquisa',false,0);
  }
}
function js_mostrahistcalc(chave,erro){
  document.form1.k01_descr.value = chave;
  if(erro==true){
    document.form1.q92_hist.focus();
    document.form1.q92_hist.value = '';
  }
}
function js_mostrahistcalc1(chave1,chave2){
  document.form1.q92_hist.value = chave1;
  document.form1.k01_descr.value = chave2;
  db_iframe_histcalc.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo.iframe_cadvencdesc','db_iframe_cadvencdesc','func_cadvencdesc.php?funcao_js=parent.js_preenchepesquisa|q92_codigo','Pesquisa',true,0);
}
function js_preenchepesquisa(chave){
  db_iframe_cadvencdesc.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave;";
  }
  ?>
}
</script>
