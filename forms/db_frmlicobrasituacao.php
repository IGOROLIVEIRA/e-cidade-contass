<?
//MODULO: Obras
$cllicobrasituacao->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tobr02_sequencial?>">
    <input name="oid" type="hidden" value="<?=@$oid?>">
       <?=@$Lobr02_sequencial?>
    </td>
    <td> 
<?
db_input('obr02_sequencial',11,$Iobr02_sequencial,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tobr02_seqobra?>">
       <?=@$Lobr02_seqobra?>
    </td>
    <td> 
<?
db_input('obr02_seqobra',11,$Iobr02_seqobra,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tobr02_dtlancamento?>">
       <?=@$Lobr02_dtlancamento?>
    </td>
    <td> 
<?
db_inputdata('obr02_dtlancamento',@$obr02_dtlancamento_dia,@$obr02_dtlancamento_mes,@$obr02_dtlancamento_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tobr02_situacao?>">
       <?=@$Lobr02_situacao?>
    </td>
    <td> 
<?
db_input('obr02_situacao',16,$Iobr02_situacao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tobr02_dtsituacao?>">
       <?=@$Lobr02_dtsituacao?>
    </td>
    <td> 
<?
db_inputdata('obr02_dtsituacao',@$obr02_dtsituacao_dia,@$obr02_dtsituacao_mes,@$obr02_dtsituacao_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tobr02_veiculopublicacao?>">
       <?=@$Lobr02_veiculopublicacao?>
    </td>
    <td> 
<?
db_textarea('obr02_veiculopublicacao',0,0,$Iobr02_veiculopublicacao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tobr02_descrisituacao?>">
       <?=@$Lobr02_descrisituacao?>
    </td>
    <td> 
<?
db_textarea('obr02_descrisituacao',0,0,$Iobr02_descrisituacao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tobr02_motivoparalisacao?>">
       <?=@$Lobr02_motivoparalisacao?>
    </td>
    <td> 
<?
db_input('obr02_motivoparalisacao',11,$Iobr02_motivoparalisacao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tobr02_dtparalizacao?>">
       <?=@$Lobr02_dtparalizacao?>
    </td>
    <td> 
<?
db_inputdata('obr02_dtparalizacao',@$obr02_dtparalizacao_dia,@$obr02_dtparalizacao_mes,@$obr02_dtparalizacao_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tobr02_outrosmotivos?>">
       <?=@$Lobr02_outrosmotivos?>
    </td>
    <td> 
<?
db_textarea('obr02_outrosmotivos',0,0,$Iobr02_outrosmotivos,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tobr02_dtretomada?>">
       <?=@$Lobr02_dtretomada?>
    </td>
    <td> 
<?
db_inputdata('obr02_dtretomada',@$obr02_dtretomada_dia,@$obr02_dtretomada_mes,@$obr02_dtretomada_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tobr02_instit?>">
       <?=@$Lobr02_instit?>
    </td>
    <td> 
<?
db_input('obr02_instit',11,$Iobr02_instit,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('top.corpo','db_iframe_licobrasituacao','func_licobrasituacao.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_licobrasituacao.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
