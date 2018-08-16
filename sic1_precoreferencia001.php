    <?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_precoreferencia_classe.php");
include("classes/db_itemprecoreferencia_classe.php");
include("dbforms/db_funcoes.php");
require("libs/db_utils.php");
db_postmemory($HTTP_POST_VARS);

$clprecoreferencia     = new cl_precoreferencia;
$clitemprecoreferencia = new cl_itemprecoreferencia;
$db_opcao = 1;
$db_botao = true;
if(isset($incluir)){
	db_inicio_transacao();

  $clprecoreferencia->incluir(null);

  if ($clprecoreferencia->erro_status != 0) {

  	if ($si01_tipoprecoreferencia == 1) {
     	$sFuncao = "avg";
     } else if ($si01_tipoprecoreferencia == 2) {
     	$sFuncao = "max";
     } else {
     	$sFuncao = "min";
     }

     $sSql = "select pc23_orcamitem,round($sFuncao(pc23_vlrun),$quant_casas) as valor,
                      round($sFuncao(pc23_perctaxadesctabela),2) as percreferencia1,
                      round($sFuncao(pc23_percentualdesconto),2) as percreferencia2
                        from pcproc
                        join pcprocitem on pc80_codproc = pc81_codproc
                        join pcorcamitemproc on pc81_codprocitem = pc31_pcprocitem
                        join pcorcamitem on pc31_orcamitem = pc22_orcamitem
                        join pcorcamval on pc22_orcamitem = pc23_orcamitem
                        where pc80_codproc = $si01_processocompra and pc23_vlrun > 0 group by pc23_orcamitem";

     $rsResult = db_query($sSql);

     for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

     	 $oItemOrc = db_utils::fieldsMemory($rsResult, $iCont);
       $clitemprecoreferencia->si02_vlprecoreferencia = $oItemOrc->valor;
       $clitemprecoreferencia->si02_itemproccompra    = $oItemOrc->pc23_orcamitem;
       $clitemprecoreferencia->si02_precoreferencia = $clprecoreferencia->si01_sequencial;
       if ($oItemOrc->percreferencia1 == 0 && $oItemOrc->percreferencia2 == 0) {
        $clitemprecoreferencia->si02_vlpercreferencia = 0;
       }
       else if ($oItemOrc->percreferencia1 > 0 && $oItemOrc->percreferencia2 == 0) {
        $clitemprecoreferencia->si02_vlpercreferencia = $oItemOrc->percreferencia1;
       } else {
          $clitemprecoreferencia->si02_vlpercreferencia = $oItemOrc->percreferencia2;
       }
       $clitemprecoreferencia->incluir(null);

     }
     if ($clitemprecoreferencia->erro_status == 0) {

       $sqlerro = true;
       $clprecoreferencia->erro_msg    = $clitemprecoreferencia->erro_msg;
       $clprecoreferencia->erro_status = "0";

     }

     if (pg_num_rows($rsResult) == 0) {

     	 $clprecoreferencia->erro_msg = "Não existe orçamentos cadastrados.";
     	 $sqlerro = true;
     	 $clprecoreferencia->erro_status = "0";

     }

  }

  db_fim_transacao($sqlerro);
  if ($clprecoreferencia->erro_status != 0){
    echo "<script>
    jan = window.open('sic1_precoreferencia004.php?codigo_preco='+{$clprecoreferencia->si01_processocompra}+'&quant_casas='+$quant_casas,

	                 '',
	                   'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
	   jan.moveTo(0,0);
    </script>";

  }

}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
    <center>
	<?
	include("forms/db_frmprecoreferencia.php");
	?>
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
js_tabulacaoforms("form1","si01_processocompra",true,1,"si01_processocompra",true);
</script>
<?
if(isset($incluir)){
  if($clprecoreferencia->erro_status=="0"){
    $clprecoreferencia->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clprecoreferencia->erro_campo!=""){
      echo "<script> document.form1.".$clprecoreferencia->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clprecoreferencia->erro_campo.".focus();</script>";
    }
  }else{
    $clprecoreferencia->erro(true,true);
  }
}
?>
