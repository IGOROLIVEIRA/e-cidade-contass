<?
//MODULO: sicom
$clapostilamento->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("l20_codigo");
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tsi03_sequencial?>">
       <?=@$Lsi03_sequencial?>
    </td>
    <td>
<?
db_input('si03_sequencial',10,$Isi03_sequencial,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi03_licitacao?>">
       <?
       db_ancora(@$Lsi03_licitacao,"js_pesquisasi03_licitacao(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('si03_licitacao',10,$Isi03_licitacao,true,'text',3," onchange='js_pesquisasi03_licitacao(false);'")
?>
<b>Número Processo:</b>
       <?
db_input('l20_edital',10,$Il20_edital,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi03_numcontrato?>">
       <?=@$Lsi03_numcontrato?>
    </td>
    <td>
<?
//$result = $clcontratos->sql_record($clcontratos->sql_query(null,"si172_sequencial, si172_nrocontrato"));
//db_selectrecord("si03_numcontrato",$result,true,$db_opcao);


$result = $clcontratos->sql_record($clcontratos->sql_query_novo(null,"si172_nrocontrato||'/'||si172_exerciciocontrato as nrocontrato, z01_nome
  "));
/*if (empty($nrocontrato) && $nrocontrato == "") {
  //$nrocontrato                      = db_utils::fieldsMemory($result, 0)->nrocontrato;
} */

db_selectrecord("nrocontrato",$result,true,$db_opcao,"","",""," - ","js_seleciona_contrato()");

?>
    </td>
  </tr>
    <tr>
    <td>
      <b> N Contrato Anos Anteriores:</b>
    </td>
    <td>
<?
db_input('si03_numcontratoanosanteriores',10,1,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi03_dataassinacontrato?>">
       <?=@$Lsi03_dataassinacontrato?>
    </td>
    <td>
<?
db_inputdata('si03_dataassinacontrato',@$si03_dataassinacontrato_dia,@$si03_dataassinacontrato_mes,@$si03_dataassinacontrato_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi03_tipoapostila?>">
       <?=@$Lsi03_tipoapostila?>
    </td>
    <td>
<?
$x = array("01"=>"Reajuste de preço previsto no contrato","02"=>"Atualizações, compensações ou penalizações","03"=>"Empenho de dotações orçamentárias suplementares");
db_select('si03_tipoapostila',$x,true,$db_opcao,"");
//db_input('si03_tipoapostila',1,$Isi03_tipoapostila,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi03_dataapostila?>">
       <?=@$Lsi03_dataapostila?>
    </td>
    <td>
<?
db_inputdata('si03_dataapostila',@$si03_dataapostila_dia,@$si03_dataapostila_mes,@$si03_dataapostila_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi03_descrapostila?>">
       <?=@$Lsi03_descrapostila?>
    </td>
    <td>
<?
db_textarea('si03_descrapostila',8,30,$Isi03_descrapostila,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi03_tipoalteracaoapostila?>">
       <?=@$Lsi03_tipoalteracaoapostila?>
    </td>
    <td>
<?
$x = array("1"=>"Acréscimo de valor","2"=>"Decréscimo de valor","3"=>"Não houve alteração de valor");
db_select('si03_tipoalteracaoapostila',$x,true,$db_opcao,"");
//db_input('si03_tipoalteracaoapostila',1,$Isi03_tipoalteracaoapostila,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi03_numapostilamento?>">
       <?=@$Lsi03_numapostilamento?>
    </td>
    <td>
<?
db_input('si03_numapostilamento',10,$Isi03_numapostilamento,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi03_valorapostila?>">
       <?=@$Lsi03_valorapostila?>
    </td>
    <td>
<?
db_input('si03_valorapostila',14,$Isi03_valorapostila,true,'text',$db_opcao,"")
?>
    </td>
  </tr>

<?
$si03_instit = db_getsession("DB_instit");
db_input('si03_instit',10,$Isi03_instit,true,'hidden',$db_opcao,"")
?>
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

var opcao  = document.form1.controle.value;

function js_pesquisasi03_licitacao(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_liclicita','func_liclicita.php?funcao_js=parent.js_mostraliclicita1|l20_codigo|l20_edital|l20_anousu','Pesquisa',true);
  }else{
     if(document.form1.si03_licitacao.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_liclicita','func_liclicita.php?pesquisa_chave='+document.form1.si03_licitacao.value+'&funcao_js=parent.js_mostraliclicita','Pesquisa',false);
     }else{
       document.form1.l20_codigo.value = '';
     }
  }
}
function js_mostraliclicita(chave,erro){
  document.form1.l20_codigo.value = chave;
  if(erro==true){
    document.form1.si03_licitacao.focus();
    document.form1.si03_licitacao.value = '';
  }
}
function js_mostraliclicita1(chave1,chave2,chave3){
  document.form1.si03_licitacao.value = chave1;
  document.form1.l20_edital.value = chave2+'/'+chave3;
  db_iframe_liclicita.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_apostilamento','func_apostilamento.php?funcao_js=parent.js_preenchepesquisa|si03_sequencial','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_apostilamento.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
function js_seleciona_contrato(){
	if (document.form1.nrocontrato.value != ' ') {
		document.form1.si03_numcontratoanosanteriores.readOnly = true;
		document.form1.si03_numcontratoanosanteriores.style.backgroundColor = '#DEB887';
		document.form1.si03_numcontratoanosanteriores.value = '';
		var oParam           = new Object();
		  oParam.nrocontrato = document.form1.nrocontrato.value;
		  var oAjax = new Ajax.Request("pesqdataasscontrato.RPC.php",
	              {
	            method:'post',
	            parameters:'json='+Object.toJSON(oParam),
	            onComplete:js_retornoPesquisa
	              }
	    );
	} else {
	  document.form1.si03_numcontratoanosanteriores.readOnly = false;
		document.form1.si03_numcontratoanosanteriores.style.backgroundColor = '#FFF';
	}
}
function js_retornoPesquisa(oAjax) {
	var oRetorno = eval("("+oAjax.responseText+")");
	document.form1.si03_dataassinacontrato.value = oRetorno.si172_dataassinatura;
	var aData = document.form1.si03_dataassinacontrato.value.split("/");
	js_setDiaMesAno(document.form1.si03_dataassinacontrato,aData[0],aData[1],aData[2]);
}
js_seleciona_contrato();
</script>
