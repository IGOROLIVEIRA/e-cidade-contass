<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_pcmater_classe.php");
include("classes/db_pcsubgrupo_classe.php");
include("dbforms/db_funcoes.php");
require_once("libs/db_utils.php");
db_postmemory($HTTP_SERVER_VARS);
db_postmemory($HTTP_POST_VARS);
$clpcmater = new cl_pcmater;
$clpcsubgrupo = new cl_pcsubgrupo;
$db_opcao = 1;
$db_botao = true;
$clrotulo = new rotulocampo;
$clrotulo->label("pc01_codmater");
$clrotulo->label("pc01_descrmater");
$clrotulo->label("pc04_codsubgrupo");
$clrotulo->label("pc04_descrsubgrupo");
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="document.form1.pc01_codmater.focus();" >
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<fieldset  style="width: 800px; margin-left: 250px; margin-top: 20px; ">
<legend><b>Consulta Fornecedor por Material</b></legend>
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
    <center>
    <form name='form1'>
    <table border="0">
    <br>
  <tr>
    <td nowrap title="<?=@$Tpc01_codmater?>" align="right">
       <?
       db_ancora(@$Lpc01_codmater,"js_pesquisa(true);",1);
       ?>
    </td>
    <td>
<?
db_input('pc01_codmater',8,$Ipc01_codmater,true,'text',1,"onchange='js_pesquisa(false);'")
?>
       <?
db_input('pc01_descrmater',58,@$Ipc01_descrmater,true,'text',3,'')
       ?>
    </td>
  </tr>
    <tr>
   <td nowrap title="<?=@$pc04_codsubgrupo?>" align="right">
    <?
    db_ancora(@$Lpc04_codsubgrupo,"js_pesquisa2(true);",1);
    ?>
    </td>
    <td align='left'>
    <?
     db_input('pc04_codsubgrupo',8,$Ipc04_codsubgrupo,true,'text',1,"onchange='js_pesquisa2(false);'");
     db_input('pc04_descrsubgrupo',58,$Ipc04_descrsubgrupo,true,'text',3,"");
	?>
    </td>
  </tr>
  <tr>
   <td colspan=2 align='center'>
     <input type='button' name='processar' value='Processar' onclick='js_processar();'>
     <input type='button' name='gerarelatorio' value='Gerar Relatório' onclick='js_gerarelatorio();'>
   </td>
  </tr>
    </table>



<div id="ctnGridPagamentosItens">
  <table id="gridPagamentos" class="DBGrid" cellspacing="0" cellpadding="0" width="100%" border="0" style="border:2px inset white; overflow: scroll;">
  <tr>
    <th class="table_header" style="width: 20%;">Fornecedor</th>
	<th class="table_header" style="width: 10%;">CNPJ/CPF</th>
	<th class="table_header" style="width: 10%;">Telefone</th>
	</tr>
	<?php
	if (!empty($pc01_codmater) && !empty($pc04_codsubgrupo) ) {
	$sSql = "select distinct pc01_codmater, z01_numcgm,z01_nome,z01_cgccpf,z01_telef
			from pcorcam
			inner join pcorcamitem on pcorcamitem.pc22_codorc = pcorcam.pc20_codorc
			left join pcorcamforne on pcorcamforne.pc21_codorc = pcorcam.pc20_codorc
			left join cgm on cgm.z01_numcgm = pcorcamforne.pc21_numcgm
			inner join pcorcamitemproc on pcorcamitemproc.pc31_orcamitem = pcorcamitem.pc22_orcamitem
			inner join pcprocitem on pcprocitem.pc81_codprocitem= pcorcamitemproc.pc31_pcprocitem
			inner join solicitem on solicitem.pc11_codigo= pcprocitem.pc81_solicitem
			inner join pcdotac on pc13_codigo=solicitem.pc11_codigo
			left join solicitempcmater on solicitempcmater.pc16_solicitem= solicitem.pc11_codigo
			left join pcmater on pcmater.pc01_codmater = solicitempcmater.pc16_codmater
			left join pcsubgrupo on pcsubgrupo.pc04_codsubgrupo = pcmater.pc01_codsubgrupo
			left join pctipo on pctipo.pc05_codtipo = pcsubgrupo.pc04_codtipo
			left join solicitemele on solicitemele.pc18_solicitem= solicitem.pc11_codigo
			left join solicitemunid on solicitemunid.pc17_codigo= solicitem.pc11_codigo
			left join matunid on matunid.m61_codmatunid= solicitemunid.pc17_unid
			left join pcorcamjulg on pcorcamjulg.pc24_orcamforne = pcorcamforne.pc21_orcamforne and pcorcamjulg.pc24_orcamitem=pcorcamitem.pc22_orcamitem
			left join pcorcamval on pcorcamval.pc23_orcamforne=pcorcamforne.pc21_orcamforne and pcorcamval.pc23_orcamitem=pcorcamitem.pc22_orcamitem
			 where pcmater.pc01_codmater = ". $pc01_codmater ."
			 and pcsubgrupo.pc04_codsubgrupo = ".$pc04_codsubgrupo;
	$ctrl = 1;
	}if (empty($pc01_codmater) && !empty($pc04_codsubgrupo) ) {
	$sSql = "select distinct pc01_codmater, z01_numcgm,z01_nome,z01_cgccpf,z01_telef
				from pcorcam
				inner join pcorcamitem on pcorcamitem.pc22_codorc = pcorcam.pc20_codorc
				left join pcorcamforne on pcorcamforne.pc21_codorc = pcorcam.pc20_codorc
				left join cgm on cgm.z01_numcgm = pcorcamforne.pc21_numcgm
				inner join pcorcamitemproc on pcorcamitemproc.pc31_orcamitem = pcorcamitem.pc22_orcamitem
				inner join pcprocitem on pcprocitem.pc81_codprocitem= pcorcamitemproc.pc31_pcprocitem
				inner join solicitem on solicitem.pc11_codigo= pcprocitem.pc81_solicitem
				inner join pcdotac on pc13_codigo=solicitem.pc11_codigo
				left join solicitempcmater on solicitempcmater.pc16_solicitem= solicitem.pc11_codigo
				left join pcmater on pcmater.pc01_codmater = solicitempcmater.pc16_codmater
				left join pcsubgrupo on pcsubgrupo.pc04_codsubgrupo = pcmater.pc01_codsubgrupo
				left join pctipo on pctipo.pc05_codtipo = pcsubgrupo.pc04_codtipo
				left join solicitemele on solicitemele.pc18_solicitem= solicitem.pc11_codigo
				left join solicitemunid on solicitemunid.pc17_codigo= solicitem.pc11_codigo
				left join matunid on matunid.m61_codmatunid= solicitemunid.pc17_unid
				left join pcorcamjulg on pcorcamjulg.pc24_orcamforne = pcorcamforne.pc21_orcamforne and pcorcamjulg.pc24_orcamitem=pcorcamitem.pc22_orcamitem
				left join pcorcamval on pcorcamval.pc23_orcamforne=pcorcamforne.pc21_orcamforne and pcorcamval.pc23_orcamitem=pcorcamitem.pc22_orcamitem
			 where pcsubgrupo.pc04_codsubgrupo = ".$pc04_codsubgrupo;
	$ctrl = 1;
	}if (!empty($pc01_codmater) && empty($pc04_codsubgrupo) ) {
	$sSql = "select distinct pc01_codmater, z01_numcgm,z01_nome,z01_cgccpf,z01_telef
			from pcorcam
			inner join pcorcamitem on pcorcamitem.pc22_codorc = pcorcam.pc20_codorc
			left join pcorcamforne on pcorcamforne.pc21_codorc = pcorcam.pc20_codorc
			left join cgm on cgm.z01_numcgm = pcorcamforne.pc21_numcgm
			inner join pcorcamitemproc on pcorcamitemproc.pc31_orcamitem = pcorcamitem.pc22_orcamitem
			inner join pcprocitem on pcprocitem.pc81_codprocitem= pcorcamitemproc.pc31_pcprocitem
			inner join solicitem on solicitem.pc11_codigo= pcprocitem.pc81_solicitem
			inner join pcdotac on pc13_codigo=solicitem.pc11_codigo
			left join solicitempcmater on solicitempcmater.pc16_solicitem= solicitem.pc11_codigo
			left join pcmater on pcmater.pc01_codmater = solicitempcmater.pc16_codmater
			left join pcsubgrupo on pcsubgrupo.pc04_codsubgrupo = pcmater.pc01_codsubgrupo
			left join pctipo on pctipo.pc05_codtipo = pcsubgrupo.pc04_codtipo
			left join solicitemele on solicitemele.pc18_solicitem= solicitem.pc11_codigo
			left join solicitemunid on solicitemunid.pc17_codigo= solicitem.pc11_codigo
			left join matunid on matunid.m61_codmatunid= solicitemunid.pc17_unid
			left join pcorcamjulg on pcorcamjulg.pc24_orcamforne = pcorcamforne.pc21_orcamforne and pcorcamjulg.pc24_orcamitem=pcorcamitem.pc22_orcamitem
			left join pcorcamval on pcorcamval.pc23_orcamforne=pcorcamforne.pc21_orcamforne and pcorcamval.pc23_orcamitem=pcorcamitem.pc22_orcamitem
			 where pcmater.pc01_codmater = ". $pc01_codmater;
	$ctrl = 1;
	}

	//echo $sSql;

	$rsResultTabela = pg_query($sSql);

	if (pg_num_rows($rsResultTabela) == 0 && $ctrl == 1) {
		echo '<script>alert("Nenhum fornecedor foi encontrado");</script>';
	}

	for ($iCont = 0; $iCont < pg_num_rows($rsResultTabela); $iCont++) {
	  $oDadosTabela = db_utils::fieldsMemory($rsResultTabela, $iCont);

	$sTabela  = "<tr id=\"{$oDadosTabela->z01_numcgm}\" class=\"normal\" style=\"height:1em;\">";
	$sTabela .= "<td id=\"Pagamentosrow1cell0\" class=\"linhagrid\" style=\"text-align:left;\">{$oDadosTabela->z01_nome}</td>";
	$sTabela .= "<td id=\"Pagamentosrow1cell1\" class=\"linhagrid\" style=\"text-align:center;\">{$oDadosTabela->z01_cgccpf}</td>";
	$sTabela .= "<td id=\"Pagamentosrow1cell1\" class=\"linhagrid\" style=\"text-align:center;\">{$oDadosTabela->z01_telef}</td></tr>";
	echo $sTabela;
	}
	?>
	</table>
</div>
</fieldset>

    </form>
    </center>
	</td>
  </tr>
</table>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
function js_pesquisa(mostra){
	if (mostra==true){
  		js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pcmater','func_pcmater.php?funcao_js=parent.js_mostra1|pc01_codmater|pc01_descrmater|pc01_codsubgrupo|pc04_descrsubgrupo','Pesquisa',true);
	}else{
		js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pcmater','func_pcmater.php?pesquisa_chave='+document.form1.pc01_codmater.value+'&funcao_js=parent.js_mostra','Pesquisa',false);
    }
    if(document.form1.pc01_codmater.value==""){
    	document.form1.pc01_descrmater.value="";
    }
    if(document.form1.pc04_codsubgrupo.value==""){
    	document.form1.pc04_descrsubgrupo.value="";
    }
}
function js_mostra(nome,erro){
	document.form1.pc01_descrmater.value=nome;
	if (erro==true){
		document.form1.pc01_codmater.value="";
		document.form1.pc01_codmater.focus();
	}
}
function js_mostra1(cod,nome,cod2,nome2){
	document.form1.pc01_codmater.value=cod;
	document.form1.pc01_descrmater.value=nome;
	document.form1.pc04_codsubgrupo.value=cod2;
	document.form1.pc04_descrsubgrupo.value=nome2;
	db_iframe_pcmater.hide();
}
function js_pesquisa2(mostra){
	if (mostra==true){
  		js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pcsubgrupo','func_pcsubgrupo.php?funcao_js=parent.js_mostra3|pc04_codsubgrupo|pc04_descrsubgrupo','Pesquisa',true);
	}else{
		js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pcmater','func_pcsubgrupo.php?pesquisa_chave='+document.form1.pc04_codsubgrupo.value+'&funcao_js=parent.js_mostra2','Pesquisa',false);
    }
    if(document.form1.pc01_codmater.value==""){
    	document.form1.pc01_descrmater.value="";
    }
    if(document.form1.pc04_codsubgrupo.value==""){
    	document.form1.pc04_descrsubgrupo.value="";
    }
}
function js_mostra2(nome,erro){
	document.form1.pc04_descrsubgrupo.value=nome;
	if (erro==true){
		document.form1.pc01_codmater.value="";
		document.form1.pc01_codmater.focus();
	}
}
function js_mostra3(cod,nome){
	document.form1.pc04_codsubgrupo.value=cod;
	document.form1.pc04_descrsubgrupo.value=nome;
	db_iframe_pcsubgrupo.hide();
}
function js_processar(){
	  if(document.getElementById("pc01_codmater").value != "" && document.getElementById("pc04_codsubgrupo").value != "" ){
		<?
	  echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?pc01_codmater='+document.getElementById('pc01_codmater').value+'&pc04_codsubgrupo='+document.getElementById('pc04_codsubgrupo').value+'&pc01_descrmater='+document.getElementById('pc01_descrmater').value+'&pc04_descrsubgrupo='+document.getElementById('pc04_descrsubgrupo').value";
	  ?>
	  }
	  else if (document.getElementById("pc01_codmater").value != "" && document.getElementById("pc04_codsubgrupo").value == "" ) {
	      <?
		   echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?pc01_codmater='+document.getElementById('pc01_codmater').value+'&pc01_descrmater='+document.getElementById('pc01_descrmater').value";
		  ?>
	  }
	  else if (document.getElementById("pc01_codmater").value == "" && document.getElementById("pc04_codsubgrupo").value != "" ) {
	      <?
		   echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?pc04_codsubgrupo='+document.getElementById('pc04_codsubgrupo').value+'&pc04_descrsubgrupo='+document.getElementById('pc04_descrsubgrupo').value";
		  ?>
	  }
	  else {
	   alert('Escolha um material ou grupo');
	  }
}

function js_gerarelatorio() {

	  if(document.getElementById("pc01_codmater").value != "" && document.getElementById("pc04_codsubgrupo").value != "" ){
			  query = "pc04_codsubgrupo="+document.getElementById("pc04_codsubgrupo").value;
			  query += "&pc01_codmater="+document.getElementById("pc01_codmater").value;
			  jan    = window.open('com3_emitefornecedormaterial.php?'+query,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
			  jan.moveTo(0,0);
	  }
	  else if (document.getElementById("pc01_codmater").value != "" && document.getElementById("pc04_codsubgrupo").value == "" ) {
		  query = "pc01_codmater="+document.getElementById("pc01_codmater").value;
		  jan    = window.open('com3_emitefornecedormaterial.php?'+query,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
		  jan.moveTo(0,0);
	  }
	  else if (document.getElementById("pc01_codmater").value == "" && document.getElementById("pc04_codsubgrupo").value != "" ) {
		  query = "pc04_codsubgrupo="+document.getElementById("pc04_codsubgrupo").value;
		  jan    = window.open('com3_emitefornecedormaterial.php?'+query,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
		  jan.moveTo(0,0);
	  }
	  else {
	   alert('Escolha um material ou grupo');
	  }

}
</script>
