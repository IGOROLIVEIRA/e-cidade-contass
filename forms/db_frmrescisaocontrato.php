<?
//MODULO: sicom
$clrescisaocontrato->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tsi176_sequencial?>">
       <?=@$Lsi176_sequencial?>
    </td>
    <td>
<?
db_input('si176_sequencial',10,$Isi176_sequencial,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi176_nrocontrato?>">
       <?=@$Lsi176_nrocontrato?>
    </td>
    <td>
<?


$result = $clcontratos->sql_record($clcontratos->sql_query_novo(null,"si172_nrocontrato||'/'||si172_exerciciocontrato as nrocontrato, z01_nome
  "));
db_selectrecord("nrocontrato",$result,true,$db_opcao,"","",""," - ","js_pesquisa_dataass_contrato();");

?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi176_dataassinaturacontoriginal?>">
       <?=@$Lsi176_dataassinaturacontoriginal?>
    </td>
    <td>
<?
db_inputdata('si176_dataassinaturacontoriginal',@$si176_dataassinaturacontoriginal_dia,@$si176_dataassinaturacontoriginal_mes,@$si176_dataassinaturacontoriginal_ano,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi1176_datarescisao?>">
       <?=@$Lsi1176_datarescisao?>
    </td>
    <td>
<?
db_inputdata('si1176_datarescisao',@$si1176_datarescisao_dia,@$si1176_datarescisao_mes,@$si1176_datarescisao_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi176_valorcancelamentocontrato?>">
       <?=@$Lsi176_valorcancelamentocontrato?>
    </td>
    <td>
<?
db_input('si176_valorcancelamentocontrato',14,$Isi176_valorcancelamentocontrato,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi176_ano?>">
       <?=@$Lsi176_ano?>
    </td>
    <td>
<?
if ($si176_ano == '') {
  $si176_ano = db_getsession("DB_anousu");
}
db_input('si176_ano',4,$Isi176_ano,true,'text',3,"")
?>
    </td>
  </tr>
  <?
  $controle = $db_opcao;
  db_input('controle',10,$Icontrole,true,'hidden',$db_opcao,"")
  //db_input('controle',10,$Icontrole,true,'hidden',$db_opcao,"")
  ?>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>

function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_rescisaocontrato','func_rescisaocontrato.php?funcao_js=parent.js_preenchepesquisa|si176_sequencial','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_rescisaocontrato.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
function js_pesquisa_dataass_contrato() {
	var oParam           = new Object();
	  oParam.nrocontrato = document.form1.nrocontrato.value;
	  var oAjax = new Ajax.Request("pesqdataasscontrato.RPC.php",
              {
            method:'post',
            parameters:'json='+Object.toJSON(oParam),
            onComplete:js_retornoPesquisa
              }
    );
}
function js_retornoPesquisa(oAjax) {
	var oRetorno = eval("("+oAjax.responseText+")");
	document.form1.si176_dataassinaturacontoriginal.value = oRetorno.si172_dataassinatura;
	var aData = document.form1.si176_dataassinaturacontoriginal.value.split("/");
	js_setDiaMesAno(document.form1.si176_dataassinaturacontoriginal,aData[0],aData[1],aData[2]);
}
</script>
