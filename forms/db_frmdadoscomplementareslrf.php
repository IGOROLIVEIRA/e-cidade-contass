<?
//MODULO: sicom
$cldadoscomplementareslrf->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tsi170_sequencial?>">
       <?=@$Lsi170_sequencial?>
    </td>
    <td> 
<?
db_input('si170_sequencial',10,$Isi170_sequencial,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi170_vlsaldoatualconcgarantia?>">
       <?=@$Lsi170_vlsaldoatualconcgarantia?>
    </td>
    <td> 
<?
db_input('si170_vlsaldoatualconcgarantia',14,$Isi170_vlsaldoatualconcgarantia,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi170_recprivatizacao?>">
       <?=@$Lsi170_recprivatizacao?>
    </td>
    <td> 
<?
db_input('si170_recprivatizacao',14,$Isi170_recprivatizacao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi170_vlliqincentcontrib?>">
       <?=@$Lsi170_vlliqincentcontrib?>
    </td>
    <td> 
<?
db_input('si170_vlliqincentcontrib',14,$Isi170_vlliqincentcontrib,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi170_vlliqincentInstfinanc?>">
       <?=@$Lsi170_vlliqincentInstfinanc?>
    </td>
    <td> 
<?
db_input('si170_vlliqincentInstfinanc',14,$Isi170_vlliqincentInstfinanc,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi170_vlIrpnpincentcontrib?>">
       <?=@$Lsi170_vlIrpnpincentcontrib?>
    </td>
    <td> 
<?
db_input('si170_vlIrpnpincentcontrib',14,$Isi170_vlIrpnpincentcontrib,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi170_vllrpnpincentinstfinanc?>">
       <?=@$Lsi170_vllrpnpincentinstfinanc?>
    </td>
    <td> 
<?
db_input('si170_vllrpnpincentinstfinanc',14,$Isi170_vllrpnpincentinstfinanc,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi170_vlcompromissado?>">
       <?=@$Lsi170_vlcompromissado?>
    </td>
    <td> 
<?
db_input('si170_vlcompromissado',14,$Isi170_vlcompromissado,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi170_vlrecursosnaoaplicados?>">
       <?=@$Lsi170_vlrecursosnaoaplicados?>
    </td>
    <td> 
<?
db_input('si170_vlrecursosnaoaplicados',14,$Isi170_vlrecursosnaoaplicados,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <?
$si170_instit = db_getsession("DB_instit");
db_input('si170_instit',10,$Isi170_instit,true,'hidden',$db_opcao,"")
?>
  <tr>
    <td nowrap title="<?=@$Tsi170_mesreferencia?>">
       <?=@$Lsi170_mesreferencia?>
    </td>
    <td> 
<?
$x = array("1"=>"jan","2"=>"fev","3"=>"mar","4"=>"abr","5"=>"mai","6"=>"jun","7"=>"jul","8"=>"ago","9"=>"sete","10"=>"outu","11"=>"nov","12"=>"dez");
db_select('si170_mesreferencia',$x,true,$db_opcao,"");
//db_input('si170_mesreferencia',10,$Isi170_mesreferencia,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('top.corpo','db_iframe_dadoscomplementareslrf','func_dadoscomplementareslrf.php?funcao_js=parent.js_preenchepesquisa|si170_sequencial','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_dadoscomplementareslrf.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
