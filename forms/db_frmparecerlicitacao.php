<?
//MODULO: licitacao
$clparecerlicitacao->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");
$clrotulo->label("l20_codigo");
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tl200_sequencial?>">
       <?=@$Ll200_sequencial?>
    </td>
    <td> 
<?
db_input('l200_sequencial',10,$Il200_sequencial,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl200_licitacao?>">
       <?
       db_ancora(@$Ll200_licitacao,"js_pesquisal200_licitacao(true);",$db_opcao);
       ?>
    </td>
    <td> 
    <input id="l20_edital" type="text" autocomplete="off" onkeydown="return js_controla_tecla_enter(this,event);" onkeyup="js_ValidaCampos(this,1,'Licicitação','f','f',event);" onblur="js_ValidaMaiusculo(this,'f',event);" onchange="js_pesquisal200_licitacao(false);" maxlength="10" size="10" value="<?php  echo $l20_edital ?>" tabindex="1">
    <?
    db_input('l200_licitacao',10,$Il200_licitacao,true,'hidden',$db_opcao," onchange='js_pesquisal200_licitacao(false);'")
    ?>
    <?
    db_input('pc50_descr',42,$Ipc50_descr,true,'text',3,'')
    ?>
    </td>
  </tr>
  <tr>
    <td nowrap="" title="Numera&ccedil;&atilde;">
      <strong>Numera&ccedil;&atilde;o:</strong>
    </td>
    <td> 
      <input id="l20_numero" type="text" style="background-color:#DEB887;" readonly="readonly" size="10" value="<?php echo $l20_numero ?>" title="Numera&ccedil;&atilde;o" tabindex="0">
    </td>
  </tr>

  </tr>
  <tr>
    <td> 
    <?
    $l200_exercicio = db_getsession("DB_anousu");
    db_input('l200_exercicio',4,$Il200_exercicio,true,'hidden',$db_opcao,"")
    ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl200_data?>">
       <?=@$Ll200_data?>
    </td>
    <td> 
<?
db_inputdata('l200_data',@$l200_data_dia,@$l200_data_mes,@$l200_data_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl200_tipoparecer?>">
       <?=@$Ll200_tipoparecer?>
    </td>
    <td> 
    <?$Il200_tipoparecer = array("01"=>"Tecnico","02"=>"Juridico - Edital", "03"=>"Juridico - Julgamento", "04"=>"Juridico - Outros");
    db_select("l200_tipoparecer",$Il200_tipoparecer,true,1,"style='width:153'");
    ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl200_numcgm?>">
       <?
       db_ancora(@$Ll200_numcgm,"js_pesquisal200_numcgm(true);",$db_opcao);
       ?>
    </td>
    <td> 
<?
db_input('l200_numcgm',10,$Il200_numcgm,true,'text',$db_opcao," onchange='js_pesquisal200_numcgm(false);'")
?>
       <?
db_input('z01_nome',100,$Iz01_nome,true,'text',3,'')
       ?>
    </td>
  </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisal200_numcgm(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_cgm','func_cgm.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome','Pesquisa',true);
  }else{
     if(document.form1.l200_numcgm.value != ''){ 
        js_OpenJanelaIframe('top.corpo','db_iframe_cgm','func_cgm.php?pesquisa_chave='+document.form1.l200_numcgm.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false);
     }else{
       document.form1.z01_nome.value = ''; 
     }
  }
}
function js_mostracgm(erro,chave){
  document.form1.z01_nome.value = chave; 
  if(erro==true){ 
    document.form1.l200_numcgm.focus(); 
    document.form1.l200_numcgm.value = ''; 
  }
}
function js_mostracgm1(chave1,chave2){
  document.form1.l200_numcgm.value = chave1;
  document.form1.z01_nome.value = chave2;
  db_iframe_cgm.hide();
}
function js_pesquisal200_licitacao(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_liclicita','func_liclicita.php?funcao_js=parent.js_mostraliclicita1|l20_codigo|l20_numero|l20_edital|pc50_descr','Pesquisa',true);
  }else{
     if(document.form1.l200_licitacao.value != ''){ 
        js_OpenJanelaIframe('top.corpo','db_iframe_liclicita','func_liclicita.php?pesquisa_chave='+document.form1.l200_licitacao.value+'&funcao_js=parent.js_mostraliclicita','Pesquisa',false);
     }else{
       document.form1.l20_codigo.value = ''; 
     }
  }
}
function js_mostraliclicita(chave,erro){
  document.form1.l20_codigo.value = chave; 
  if(erro==true){ 
    document.form1.l200_licitacao.focus(); 
    document.form1.l200_licitacao.value = ''; 
  }
}
function js_mostraliclicita1(chave1,chave2,chave3,chave4){
  document.form1.l200_licitacao.value = chave1;
  document.form1.l20_numero.value = chave2;
  document.form1.l20_edital.value = chave3;
  document.form1.pc50_descr.value = chave4;
  db_iframe_liclicita.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('top.corpo','db_iframe_parecerlicitacao','func_parecerlicitacao.php?funcao_js=parent.js_preenchepesquisa|l200_sequencial','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_parecerlicitacao.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
