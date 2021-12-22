<?php
//MODULO: contabilidade
$clconvconvenios->rotulo->label();
if ($db_opcao==1) {
  $db_action="con1_convconvenios004.php";
} else if ($db_opcao==2||$db_opcao==22) {
    $db_action="con1_convconvenios005.php";
} else if ($db_opcao==3||$db_opcao==33) {
    $db_action="con1_convconvenios006.php";
}

$sSQL = " SELECT o15_codigo, o15_codtri, o15_descr FROM orctiporec WHERE o15_codtri IN ('122','123','124','142','163') ORDER BY o15_codigo ";

if(db_getsession("DB_anousu") > 2020){
    $sSQL = " SELECT o15_codigo, o15_codtri, o15_descr FROM orctiporec WHERE o15_codtri IN ('122','123','124','142','163', '163', '171', '172', '173','176', '177', '178', '181', '182', '183') ORDER BY o15_codigo ";
}
$tpCadastros = db_utils::getCollectionByRecord(db_query($sSQL));

$aTpCadastros = array(""=>"Selecione");
foreach ($tpCadastros as $tpCadastro) {
  $aTpCadastros += array($tpCadastro->o15_codigo => "$tpCadastro->o15_codtri - $tpCadastro->o15_descr");
}
?>
<form name="form1" method="post" action="<?=$db_action?>">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tc206_sequencial?>">
       <?=@$Lc206_sequencial?>
    </td>
    <td>
      <?php
        db_input('c206_sequencial',10,$Ic206_sequencial,true,'text',3,"")
      ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc206_datacadastro?>">
       <?=@$Lc206_datacadastro?>
    </td>
    <td>
    <?php
      db_inputdata('c206_datacadastro',@$c206_datacadastro_dia,@$c206_datacadastro_mes,@$c206_datacadastro_ano,true,'text',$db_opcao,"")
    ?>
    </td>
  </tr>
  <?php
    $c206_instit = db_getsession("DB_instit");
    db_input('c206_instit',12,$Ic206_instit,true,'hidden',$db_opcao,"")
  ?>
  <tr>
    <td nowrap title="<?=@$Tc206_nroconvenio?>">
       <?=@$Lc206_nroconvenio?>
    </td>
    <td>
    <?php
      db_input('c206_nroconvenio',51,$Ic206_nroconvenio,true,'text',$db_opcao,"")
    ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc206_objetoconvenio?>">
       <?=@$Lc206_objetoconvenio?>
    </td>
    <td>
    <?php
      db_textarea('c206_objetoconvenio', 6, 50,'',true,"text",$db_opcao,"","","",500);
    ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc206_tipocadastro?>">
       <?=@$Lc206_tipocadastro?>
    </td>
    <td>
      <?php
        db_select("c206_tipocadastro", $aTpCadastros, true, $iOpcao, 'style="width: 373px;"');
      ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc206_dataassinatura?>">
       <?=@$Lc206_dataassinatura?>
    </td>
    <td>
    <?php
      db_inputdata('c206_dataassinatura',@$c206_dataassinatura_dia,@$c206_dataassinatura_mes,@$c206_dataassinatura_ano,true,'text',$db_opcao,"")
    ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc206_datainiciovigencia?>">
       <?=@$Lc206_datainiciovigencia?>
    </td>
    <td>
    <?php
      db_inputdata('c206_datainiciovigencia',@$c206_datainiciovigencia_dia,@$c206_datainiciovigencia_mes,@$c206_datainiciovigencia_ano,true,'text',$db_opcao,"")
    ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc206_datafinalvigencia?>">
       <?=@$Lc206_datafinalvigencia?>
    </td>
    <td>
    <?php
      db_inputdata('c206_datafinalvigencia',@$c206_datafinalvigencia_dia,@$c206_datafinalvigencia_mes,@$c206_datafinalvigencia_ano,true,'text',$db_opcao,"")
    ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc206_vlconvenio?>">
       <?=@$Lc206_vlconvenio?>
    </td>
    <td>
    <?php
      db_input('c206_vlconvenio',14,$Ic206_vlconvenio,true,'text',$db_opcao,"")
    ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc206_vlcontrapartida?>">
       <?=@$Lc206_vlcontrapartida?>
    </td>
    <td>
    <?php
      db_input('c206_vlcontrapartida',14,$Ic206_vlcontrapartida,true,'text',$db_opcao,"")
    ?>
    </td>
  </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisa(){
  js_OpenJanelaIframe('top.corpo.iframe_convconvenios','db_iframe_convconvenios','func_convconvenios.php?funcao_js=parent.js_preenchepesquisa|c206_sequencial','Pesquisa',true,'0','1');
}
function js_preenchepesquisa(chave){
  db_iframe_convconvenios.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
