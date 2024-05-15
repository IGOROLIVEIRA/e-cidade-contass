<?
//MODULO: sicom
$cldotacaorpsicom->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("e60_codemp");
?>
<form name="form1" method="post" action="">
<center>
<fieldset style="margin-left: 80px; margin-top: 10px;">
<legend>Alterar Dotação RP</legend>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tsi177_sequencial?>">
       <?//=@$Lsi177_sequencial?>
    </td>
    <td>
<?
db_input('si177_sequencial',11,$Isi177_sequencial,true,'hidden',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi177_numemp?>">
       <?
       db_ancora("Empenho RP:","js_pesquisasi177_numemp(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('si177_numemp',11,$Isi177_numemp,true,'text',3," onchange='js_pesquisasi177_numemp(false);'")
?>
       <?
       if ($e60_codemp != '') {
       	 $e60_codemp = $e60_codemp."/".$e60_anousu." ".$z01_nome;
       }
db_input('e60_codemp',50,$Ie60_codemp,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi177_codorgaotce?>">
       <?=@$Lsi177_codorgaotce?>
    </td>
    <td>
<?
db_input('si177_codorgaotce',2,$Isi177_codorgaotce,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi177_codunidadesub?>">
       <?=@$Lsi177_codunidadesub?>
    </td>
    <td>
<?
db_input('si177_codunidadesub',8,$Isi177_codunidadesub,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi177_codunidadesuborig?>">
       <?=@$Lsi177_codunidadesuborig?>
    </td>
    <td>
<?
db_input('si177_codunidadesuborig',8,$Isi177_codunidadesuborig,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi177_codfuncao?>">
       <?=@$Lsi177_codfuncao?>
    </td>
    <td>
<?
db_input('si177_codfuncao',2,$Isi177_codfuncao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi177_codsubfuncao?>">
       <?=@$Lsi177_codsubfuncao?>
    </td>
    <td>
<?
db_input('si177_codsubfuncao',3,$Isi177_codsubfuncao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi177_codprograma?>">
       <?=@$Lsi177_codprograma?>
    </td>
    <td>
<?
db_input('si177_codprograma',4,$Isi177_codprograma,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi177_idacao?>">
       <?=@$Lsi177_idacao?>
    </td>
    <td>
<?
db_input('si177_idacao',4,$Isi177_idacao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi177_idsubacao?>">
       <?=@$Lsi177_idsubacao?>
    </td>
    <td>
<?
db_input('si177_idsubacao',4,$Isi177_idsubacao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi177_naturezadespesa?>">
       <?=@$Lsi177_naturezadespesa?>
    </td>
    <td>
<?
db_input('si177_naturezadespesa',6,$Isi177_naturezadespesa,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi177_subelemento?>">
       <?=@$Lsi177_subelemento?>
    </td>
    <td>
<?
db_input('si177_subelemento',2,$Isi177_subelemento,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi177_codfontrecursos?>">
       <?=@$Lsi177_codfontrecursos?>
    </td>
    <td>
<?
db_input('si177_codfontrecursos',3,$Isi177_codfontrecursos,true,'text',$db_opcao,"")
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
function js_pesquisasi177_numemp(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_empempenho','func_empempenho.php?funcao_js=parent.js_mostraempempenho1|e60_numemp|e60_codemp|e60_anousu|z01_nome','Pesquisa',true);
  }else{
     if(document.form1.si177_numemp.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_empempenho','func_empempenho.php?pesquisa_chave='+document.form1.si177_numemp.value+'&funcao_js=parent.js_mostraempempenho','Pesquisa',false);
     }else{
       document.form1.e60_codemp.value = '';
     }
  }
}
function js_mostraempempenho(chave,erro){
  document.form1.e60_codemp.value = chave;
  if(erro==true){
    document.form1.si177_numemp.focus();
    document.form1.si177_numemp.value = '';
  }
}
function js_mostraempempenho1(chave1,chave2,chave3,chave4){
  document.form1.si177_numemp.value = chave1;
  document.form1.e60_codemp.value = chave2+'/'+chave3+' '+chave4;
  db_iframe_empempenho.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_dotacaorpsicom','func_dotacaorpsicom.php?funcao_js=parent.js_preenchepesquisa|si177_sequencial','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_dotacaorpsicom.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
