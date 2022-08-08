<?
//MODULO: licitacao
$clprecomedio->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("pc01_descrmater");
$clrotulo->label("l20_codigo");


if (empty($l209_licitacao)) {
?>

<form name="form1" method="post" action="" onsubmit="return valida_licitacao(this);">
<fieldset style="width: 500px; height: 110px; margin-top: 20px;"><legend><b>Preço Médio</b></legend>
  <table cellspacing="5px">
  <tr>
  <td><strong>Código</strong></td>
  <td> <input type="text" name="codigo" id="codigo" readonly="readonly" style="background-color: rgb(222, 184, 135);" ></td>
  </tr>

 <tr>
    <td nowrap title="<?=@$Tl209_licitacao?>">
       <?
       db_ancora(@$Ll209_licitacao,"js_pesquisal209_licitacao(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('l209_licitacao',10,$Il209_licitacao,true,'text',$db_opcao," onchange='js_pesquisal209_licitacao(false);'")
?>
       <?
db_input('l20_codigo',10,$Il20_codigo,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>

    <tr>
  <td></td>
  <td align="right">
  <input type="submit" value="Processar" name="btnProcessar" />
  <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
  <input type="reset" value="Novo" name="btnNovo" />
  </td>
</tr>
</table>
</fieldset>
</form>

<?
}else{
?>

<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tl209_sequencial?>">
       <?=@$Ll209_sequencial?>
    </td>
    <td>
<?
db_input('l209_sequencial',15,$Il209_sequencial,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl209_licitacao?>">
       <?
       db_ancora(@$Ll209_licitacao,"js_pesquisal209_licitacao(true);",3);
       ?>
    </td>
    <td>
<?
db_input('l209_licitacao',10,$Il209_licitacao,true,'text',3," onchange='js_pesquisal209_licitacao(false);'")
?>
       <?
db_input('l20_codigo',10,$Il20_codigo,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl209_datacotacao?>">
       <?=@$Ll209_datacotacao?>
    </td>
    <td>
<?
$sSql = "select * from precomedio where l209_licitacao = ".$l209_licitacao;
$rsItemGravado     = db_query($sSql);
if (pg_num_rows($rsItemGravado) > 0) {
  $data  = explode('-', db_utils::fieldsMemory($rsItemGravado, 0)->l209_datacotacao);
  $l209_datacotacao_dia = $data[2];
  $l209_datacotacao_mes = $data[1];
  $l209_datacotacao_ano = $data[0];
}
db_inputdata('l209_datacotacao',@$l209_datacotacao_dia,@$l209_datacotacao_mes,@$l209_datacotacao_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>

  </table>

  <?
$sSql = "select distinct l21_ordem, pc81_codprocitem, pc81_codproc, pc11_seq, pc11_resum, pc11_codigo, pc11_vlrun, l20_codigo,
pc11_quant, pc01_descrmater,pc01_codmater, pc22_orcamitem, l21_codigo, l20_usaregistropreco, pc11_resum, pc32_orcamitem, pc32_orcamforne,
l04_descricao as descr_lote from pcorcamitem inner join pcorcam on pcorcam.pc20_codorc = pcorcamitem.pc22_codorc
left join pcorcamforne on pcorcamforne.pc21_codorc = pcorcam.pc20_codorc inner join pcorcamitemlic
on pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem inner join liclicitem
on pcorcamitemlic.pc26_liclicitem = liclicitem.l21_codigo inner join liclicita on liclicita.l20_codigo = liclicitem.l21_codliclicita
inner join pcprocitem on pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem inner join solicitem
on solicitem.pc11_codigo = pcprocitem.pc81_solicitem left join solicitemunid on solicitemunid.pc17_codigo = solicitem.pc11_codigo
left join matunid on matunid.m61_codmatunid = solicitemunid.pc17_unid left join solicitempcmater
on solicitempcmater.pc16_solicitem = solicitem.pc11_codigo left join pcmater on pcmater.pc01_codmater = solicitempcmater.pc16_codmater
left join pcorcamval on pcorcamval.pc23_orcamitem = pcorcamitem.pc22_orcamitem and pcorcamval.pc23_orcamforne = pcorcamforne.pc21_orcamforne
left join pcorcamdescla on pcorcamdescla.pc32_orcamitem = pcorcamitem.pc22_orcamitem
and pcorcamdescla.pc32_orcamforne = pcorcamforne.pc21_orcamforne
left join liclicitemlote on liclicitemlote.l04_liclicitem = liclicitem.l21_codigo
left join licsituacao on liclicita.l20_licsituacao = licsituacao.l08_sequencial
where pc20_codorc={$oOrcamento->pc22_codorc} and l21_situacao = 0 order by pc81_codproc,l21_ordem,l04_descricao,pc22_orcamitem";

$rsItens = db_query($sSql);

?>
<fieldset  style="width: 800px;">
<legend>
<b>Itens</b>
</legend>
<div id="ctnGridDotacoesItens">
  <table id="gridDotacoes" class="DBGrid" cellspacing="0" cellpadding="0" width="100%" border="0" style="border:2px inset white;">
  <tr>
    <th class="table_header" nowrap="" style="">Item</th>
  <th class="table_header" nowrap="" style="">Valor%</th>
  </tr>

  <?

/*
 * Criar tabela de itens
 */
for ($iCont = 0; $iCont < pg_num_rows($rsItens); $iCont++) {

  $oItem = db_utils::fieldsMemory($rsItens, $iCont);

  $sSql = "select * from precomedio where l209_licitacao = ".$oItem->l20_codigo ." and l209_item = ".$oItem->pc01_codmater;

  $rsItemGravado = db_query($sSql);
  $oItemGravado  = db_utils::fieldsMemory($rsItemGravado, 0);
  if (pg_num_rows($rsItemGravado) > 0) {

    $db_opcao = 2;
  }

  ?>

  <tr id="DotacoesrowDotacoes1" class="normal" style="height:1em;; ">

    <td id="Dotacoesrow1cell0" class="linhagrid" nowrap="" style="text-align:left;;"><?=$oItem->pc01_descrmater ?></td>
    <td id="Dotacoesrow1cell3" class="linhagrid" nowrap="" style="text-align:center;">
    <input id="item_<?=$oItem->pc01_codmater ?>" class="linhagrid" name="<?=$oItem->pc01_codmater ?>" value="<?php echo $oItemGravado->l209_valor  ?>" type="text" style="width: 80px;";
    onkeyup="js_ValidaCampos(this,4,'valor','f','f',event);" >
    </td>
  </tr>

<?


}
?>
</table>
</div>
</fieldset>

  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<? if($db_opcao == 2 || $db_opcao == 22) { ?>
<input name="excluir" type="submit" id="db_opcao" value="Excluir" >
<? } ?>
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
<input type="reset" value="Novo" name="btnNovo" onclick="location.href='lic1_precomedio001.php'" />
</form>

<? } ?>

<script>
function js_pesquisal209_item(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pcmater','func_pcmater.php?funcao_js=parent.js_mostrapcmater1|pc01_codmater|pc01_descrmater','Pesquisa',true);
  }else{
     if(document.form1.l209_item.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pcmater','func_pcmater.php?pesquisa_chave='+document.form1.l209_item.value+'&funcao_js=parent.js_mostrapcmater','Pesquisa',false);
     }else{
       document.form1.pc01_descrmater.value = '';
     }
  }
}
function js_mostrapcmater(chave,erro){
  document.form1.pc01_descrmater.value = chave;
  if(erro==true){
    document.form1.l209_item.focus();
    document.form1.l209_item.value = '';
  }
}
function js_mostrapcmater1(chave1,chave2){
  document.form1.l209_item.value = chave1;
  document.form1.pc01_descrmater.value = chave2;
  db_iframe_pcmater.hide();
}
function js_pesquisal209_licitacao(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_liclicita','func_liclicita.php?funcao_js=parent.js_mostraliclicita1|l20_codigo|l20_codigo','Pesquisa',true);
  }else{
     if(document.form1.l209_licitacao.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_liclicita','func_liclicita.php?pesquisa_chave='+document.form1.l209_licitacao.value+'&funcao_js=parent.js_mostraliclicita','Pesquisa',false);
     }else{
       document.form1.l20_codigo.value = '';
     }
  }
}
function js_mostraliclicita(chave,erro){
  document.form1.l20_codigo.value = chave;
  if(erro==true){
    document.form1.l209_licitacao.focus();
    document.form1.l209_licitacao.value = '';
  }
}
function js_mostraliclicita1(chave1,chave2){
  document.form1.l209_licitacao.value = chave1;
  document.form1.l20_codigo.value = chave2;
  db_iframe_liclicita.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_precomedio','func_precomedio.php?funcao_js=parent.js_preenchepesquisa|l209_licitacao','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_precomedio.hide();
  <?
  if($db_opcao){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
