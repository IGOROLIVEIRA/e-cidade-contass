<?
//MODULO: Obras
$cllicobras->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tobr01_sequencial?>">
    <input name="oid" type="hidden" value="<?=@$oid?>">
       <?=@$Lobr01_sequencial?>
    </td>
    <td>
<?
db_input('obr01_sequencial',16,$Iobr01_sequencial,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tobr01_licitacao?>">
       <?=@$Lobr01_licitacao?>
    </td>
    <td>
<?
db_input('obr01_licitacao',16,$Iobr01_licitacao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tobr01_dtlancamento?>">
       <?=@$Lobr01_dtlancamento?>
    </td>
    <td>
<?
db_inputdata('obr01_dtlancamento',@$obr01_dtlancamento_dia,@$obr01_dtlancamento_mes,@$obr01_dtlancamento_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tobr01_numeroobra?>">
       <?=@$Lobr01_numeroobra?>
    </td>
    <td>
<?
db_input('obr01_numeroobra',16,$Iobr01_numeroobra,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tobr01_linkobra?>">
       <?=@$Lobr01_linkobra?>
    </td>
    <td>
<?
db_textarea('obr01_linkobra',0,0,$Iobr01_linkobra,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tobr01_tiporesponsavel?>">
       <?=@$Lobr01_tiporesponsavel?>
    </td>
    <td>
<?
db_input('obr01_tiporesponsavel',16,$Iobr01_tiporesponsavel,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tobr01_responsavel?>">
       <?=@$Lobr01_responsavel?>
    </td>
    <td>
<?
db_input('obr01_responsavel',16,$Iobr01_responsavel,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tobr01_tiporegistro?>">
       <?=@$Lobr01_tiporegistro?>
    </td>
    <td>
<?
db_input('obr01_tiporegistro',16,$Iobr01_tiporegistro,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tobr01_numregistro?>">
       <?=@$Lobr01_numregistro?>
    </td>
    <td>
<?
db_textarea('obr01_numregistro',0,0,$Iobr01_numregistro,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tobr01_numartourrt?>">
       <?=@$Lobr01_numartourrt?>
    </td>
    <td>
<?
db_input('obr01_numartourrt',13,$Iobr01_numartourrt,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tobr01_dtinicioatividades?>">
       <?=@$Lobr01_dtinicioatividades?>
    </td>
    <td>
<?
db_inputdata('obr01_dtinicioatividades',@$obr01_dtinicioatividades_dia,@$obr01_dtinicioatividades_mes,@$obr01_dtinicioatividades_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tobr01_vinculoprofissional?>">
       <?=@$Lobr01_vinculoprofissional?>
    </td>
    <td>
<?
db_input('obr01_vinculoprofissional',1,$Iobr01_vinculoprofissional,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tobr01_instit?>">
       <?=@$Lobr01_instit?>
    </td>
    <td>
<?
db_input('obr01_instit',16,$Iobr01_instit,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('top.corpo','db_iframe_licobras','func_licobras.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_licobras.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
