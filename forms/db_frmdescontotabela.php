<?
//MODULO: licitacao
$cldescontotabela->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("l20_codigo");
$clrotulo->label("pc21_codorc");

?>

<script>
function js_processa(){
    if(document.getElementById('l204_licitacao').value != "") {
      document.form1.submit();
    }else{
      alert("Selecione uma licitacao");
      return false;
    }
  }
</script>
<link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tl204_sequencial?>">
       <?=@$Ll204_sequencial?>
    </td>
    <td>
<?
db_input('l204_sequencial',10,$Il204_sequencial,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl204_licitacao?>">
       <?
       db_ancora(@$Ll204_licitacao,"js_pesquisal204_licitacao(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('l204_licitacao',5,$Il204_licitacao,true,'text',3," onchange='js_pesquisal204_licitacao(false);'")
?>
<b>Edital:</b>
       <?
db_input('l20_codigo',10,$Il20_codigo,true,'text',3,'')
       ?>
    </td>
  </tr>
<? if(!empty($l204_licitacao)){

     $iCodOrc = $cldescontotabela->getCodOrc($l204_licitacao);

?>
  <tr>
    <td nowrap title="<?=@$Tl204_fornecedor?>">
       <?=@$Ll204_fornecedor?>
    </td>
    <td>
       <?//echo "string novo";
       $result = $cldescontotabela->sql_record($cldescontotabela->sql_query_fornec(null,"pc21_orcamforne,z01_nome","","pc21_codorc = $iCodOrc"));
       db_selectrecord("l204_fornecedor",$result,true,$db_opcao);
       if (pg_num_rows($result) == 0) {
       	 echo "<script>alert('Licitação sem fornecedor');
       	 location.href='lic1_descontotabela001.php'</script>";
       }
       if ($l204_fornecedor == '') {
       	 $l204_fornecedor = db_utils::fieldsMemory($result, 0)->pc21_orcamforne;
       }
       ?>
    </td>
  </tr>
<? } ?>
  </table>
  </center>
<? if(!empty($l204_licitacao)){ ?>

    <? if($db_opcao == 1){ ?>
      <input id="db_opcao" type="submit" value="Incluir" onclick="js_submit()" name="incluir" tabindex="4">
    <? }else{ ?>
      <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit"  id="db_opcao" value="<?=($db_opcao==1?"Homologar":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
    <? } ?>
<? }else{ ?>
<input name="processar" type="button" id="processar" value="Processar" onclick="js_processa()">
<? } ?>
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
<? if($db_opcao == 1 and !empty($l204_licitacao)){ ?>
<input name="novo" type="button" id="novo" value="Novo" onclick="location.href='lic1_descontotabela001.php'" >
<? } ?>
<center>
  <table>
  <div id="ctnGridDotacoesItens">
    <table id="gridDotacoes" class="DBGrid" cellspacing="0" cellpadding="0" width="100%" border="0" style="border:2px inset white;">
    <tr>
      <th class="table_header" nowrap="" style="">Item</th>
      <th class="table_header" nowrap="" style="">Valor%</th>
    </tr>
  <?

  if(!empty($l204_licitacao)){

  $sql     = $cldescontotabela->sql_query_itens($l204_licitacao,'pc01_descrmater, pc01_complmater, pc01_codmater');
  $rsItens = db_query($sql);
    for ($iCont = 0; $iCont < pg_num_rows($rsItens); $iCont++) {
      $oItem = db_utils::fieldsMemory($rsItens, $iCont);

      if( $db_opcao == 1 && pg_num_rows($cldescontotabela->sql_record($cldescontotabela->sql_query(null,"l204_item,l204_valor","","l204_item = $oItem->pc01_codmater  and l204_licitacao = $l204_licitacao and l204_fornecedor = $l204_fornecedor"))) >= 1 ){

        echo
                    "<script>
                    document.getElementById('db_opcao').disabled                    = true;
                    document.getElementById('l204_licitacao').style.backgroundColor = '#DEB887';
                    document.getElementById('l204_licitacao').readOnly              = true;
                    </script>";
      }


         $iValor=db_utils::fieldsMemory($cldescontotabela->sql_record($cldescontotabela->sql_query(null,"l204_item,l204_valor","","l204_item = $oItem->pc01_codmater and l204_licitacao = $l204_licitacao and l204_fornecedor = $l204_fornecedor")), 0)->l204_valor;

  ?>
      <tr id="DotacoesrowDotacoes1" class="normal" style="height:1em;; ">
	<td id="Dotacoesrow1cell0" class="linhagrid" nowrap="" style="text-align:left;width:50px;"><?=$oItem->pc01_codmater ?></td>
        <td title="<?php echo $oItem->pc01_descrmater .' - '. $oItem->pc01_complmater ?> " id="Dotacoesrow1cell0" class="linhagrid" nowrap="" style="text-align:left;;"><?=$oItem->pc01_descrmater ?></td>
        <td id="Dotacoesrow1cell3" class="linhagrid" nowrap="" style="text-align:center;">
        <input id="item_<?=$oItem->pc01_codmater ?>" class="linhagrid" name="<?=$oItem->pc01_codmater ?>"
        <?
        if( $db_opcao == 3 || $db_opcao == 1 && pg_num_rows($cldescontotabela->sql_record($cldescontotabela->sql_query(null,"l204_item,l204_valor","","l204_item = $oItem->pc01_codmater and l204_licitacao = $l204_licitacao and l204_fornecedor = $l204_fornecedor"))) >= 1 ){
        ?>
        style="background-color:#DEB887;" readonly
        <?php } ?>

        value="<?php if(!empty($iValor)){ echo $iValor;  } ?>" type="text" style="width: 80px"
        onkeyup="js_ValidaCampos(this,4,'valor','f','f',event);" >
        </td>
      </tr>
<?//echo "<br>".$cldescontotabela->sql_query(null,"l204_item,l204_valor","","l204_item = $oItem->pc01_codmater");
    }
  }

?>
</table>
</div>
</form>
<script>

function js_ProcCod_l204_fornecedor(proc,res) {
    var sel1 = document.forms[0].elements[proc];
    var sel2 = document.forms[0].elements[res];
    for(var i = 0;i < sel1.options.length;i++) {
	 if(sel1.options[sel1.selectedIndex].value == sel2.options[i].value)
	   sel2.options[i].selected = true;
	 }
    document.form1.submit();
}


function js_pesquisal204_licitacao(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_liclicita','func_liclicita.php?funcao_js=parent.js_mostraliclicita1|l20_codigo|l20_edital|l20_anousu|l204_fornecedor','Pesquisa',true);
  }else{
     if(document.form1.l204_licitacao.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_liclicita','func_liclicita.php?pesquisa_chave='+document.form1.l204_licitacao.value+'&funcao_js=parent.js_mostraliclicita','Pesquisa',false);
     }else{
       document.form1.l20_codigo.value = '';
     }
  }
}
function js_mostraliclicita(chave,erro){
  document.form1.l20_codigo.value = chave;
  if(erro==true){
    document.form1.l204_licitacao.focus();
    document.form1.l204_licitacao.value = '';
  }
}
function js_mostraliclicita1(chave1,chave2,chave3,chave4){
  document.form1.l204_licitacao.value = chave1;
  document.form1.l20_codigo.value = chave2+'/'+chave3;
  db_iframe_liclicita.hide();
}
function js_pesquisal204_fornecedor(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pcorcamforne','func_pcorcamforne.php?funcao_js=parent.js_mostrapcorcamforne1|pc21_orcamforne|pc21_codorc','Pesquisa',true);
  }else{
     if(document.form1.l204_fornecedor.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pcorcamforne','func_pcorcamforne.php?pesquisa_chave='+document.form1.l204_fornecedor.value+'&funcao_js=parent.js_mostrapcorcamforne','Pesquisa',false);
     }else{
       document.form1.pc21_codorc.value = '';
     }
  }
}
function js_mostrapcorcamforne(chave,erro){
  document.form1.pc21_codorc.value = chave;
  if(erro==true){
    document.form1.l204_fornecedor.focus();
    document.form1.l204_fornecedor.value = '';
  }
}
function js_mostrapcorcamforne1(chave1,chave2){
  document.form1.l204_fornecedor.value = chave1;
  document.form1.pc21_codorc.value = chave2;
  db_iframe_pcorcamforne.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_descontotabela','func_descontotabela.php?funcao_js=parent.js_preenchepesquisa|l204_licitacao|l204_fornecedor','Pesquisa',true);
}
function js_preenchepesquisa(chave1,chave2){
  db_iframe_descontotabela.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave1+'&fornecedor='+chave2";
  }
  ?>
}
</script>
