<?
require_once ("libs/db_stdlib.php");
require_once ("libs/db_conecta.php");
require_once ("libs/db_sessoes.php");
require_once ("libs/db_usuariosonline.php");
require_once ("dbforms/db_funcoes.php");
require_once ("classes/db_pcorcam_classe.php");
require_once ("classes/db_pcorcamitem_classe.php");
require_once ("classes/db_pcorcamitemlic_classe.php");
require_once ("classes/db_pcorcamforne_classe.php");
require_once ("classes/db_pcorcamfornelic_classe.php");
require_once ("classes/db_pcorcamval_classe.php");
require_once ("classes/db_liclicita_classe.php");
require_once ("classes/db_liclicitem_classe.php");
require_once ("classes/db_liclicitatipoempresa_classe.php");
require_once ("classes/db_pcorcamjulgamentologitem_classe.php");
require_once ("classes/db_credenciamento_classe.php");
require_once ("libs/db_utils.php");
require_once ("model/licitacao.model.php");

db_postmemory($HTTP_POST_VARS);


echo "<script>parent.document.formaba.db_cred.disabled=true;</script>";
// Same as error_reporting(E_ALL);
//ini_set('error_reporting', E_ALL);

$clpcorcamforne               = new cl_pcorcamforne;
$clpcorcamfornelic            = new cl_pcorcamfornelic;
$clpcorcam                    = new cl_pcorcam;
$clpcorcamitem                = new cl_pcorcamitem;
$clpcorcamitemlic             = new cl_pcorcamitemlic;
$clliclicita                  = new cl_liclicita;
$clliclicitem                 = new cl_liclicitem;
$clpcorcamval                 = new cl_pcorcamval;
$oDaoTipoEmpresa              = new cl_liclicitatipoempresa;
$oDaoPcorcamjulgamentologitem = new cl_pcorcamjulgamentologitem;


$db_opcao = 2;
$db_botao = true;
$op       = 11;

if (isset ($alterar) || isset ($excluir) || isset ($incluir) || isset ($verificado)) {
	$sqlerro = false;
	$clpcorcamforne->pc21_orcamforne = $pc21_orcamforne;
	$clpcorcamforne->pc21_codorc = $pc20_codorc;
	$clpcorcamforne->pc21_numcgm = $pc21_numcgm;
	$clpcorcamforne->pc21_importado = '0';
}
if (isset ($incluir)) {


	db_inicio_transacao();


	/*
	 * logica para verificaÃ§Ã£o de saldos das modalidades
	 */

	//$lSaldoModalidade = licitacao::verificaSaldoModalidade($l20_codigo, $iModadalidade, $iItem, $dtJulgamento)

    //echo ("<pre>".print_r($oLicitacao, 1)."</pre>");
	//die();

	$result = $clliclicita->sql_record($clliclicita->sql_query_pco($l20_codigo));


	if ($clliclicita->numrows == 0) {
		$result_dt = $clliclicita->sql_record($clliclicita->sql_query_file($l20_codigo));
		db_fieldsmemory($result_dt, 0);

		$clpcorcam->pc20_dtate = $l20_dataaber;
		$clpcorcam->pc20_hrate = $l20_horaaber;
		$clpcorcam->incluir(null);
		$pc20_codorc = $clpcorcam->pc20_codorc;
		if ($clpcorcam->erro_status == 0) {
			$sqlerro = true;
			$erro_msg = $clpcorcam->erro_msg;
		}
		if ($sqlerro == false) {
			$result_itens = $clliclicitem->sql_record($clliclicitem->sql_query_file(null, "l21_codigo", null, "l21_codliclicita=$l20_codigo and l21_situacao=0"));
			if ($clliclicitem->numrows==0){
			  echo "<script>
			           alert('Impossivel incluir fornecedores!!Licitação sem itens cadastrados!!');
				   location.href='lic1_fornec001.php';
			        </script>";
			  exit;
			}

			for ($w = 0; $w < $clliclicitem->numrows; $w ++) {
				db_fieldsmemory($result_itens, $w);
				if ($sqlerro == false) {
					$clpcorcamitem->pc22_codorc = $pc20_codorc;
					$clpcorcamitem->incluir(null);
					$pc22_orcamitem = $clpcorcamitem->pc22_orcamitem;
					if ($clpcorcamitem->erro_status == 0) {
						$sqlerro = true;
						$erro_msg = $clpcorcamitem->erro_msg;
					}
				}
				if ($sqlerro == false) {
					$clpcorcamitemlic->pc26_orcamitem = $pc22_orcamitem;
					$clpcorcamitemlic->pc26_liclicitem = $l21_codigo;
					$clpcorcamitemlic->incluir();
					if ($clpcorcamitemlic->erro_status == 0) {
						$sqlerro = true;
						$erro_msg = $clpcorcamitemlic->erro_msg;
					}
				}
			}
		}
	}
	$result_igualcgm = $clpcorcamforne->sql_record($clpcorcamforne->sql_query_file(null, "pc21_codorc", "", " pc21_numcgm=$pc21_numcgm and pc21_codorc=$pc20_codorc"));
	if ($clpcorcamforne->numrows > 0) {
		$sqlerro = true;
		$erro_msg = "ERRO: Número de CGM já cadastrado.";
	}

	if ($sqlerro == false) {
		$clpcorcamforne->pc21_codorc = $pc20_codorc;
		$clpcorcamforne->incluir($pc21_orcamforne);
		$pc21_orcamforne = $clpcorcamforne->pc21_orcamforne;
		$erro_msg = $clpcorcamforne->erro_msg;
		if ($clpcorcamforne->erro_status == 0) {
			$sqlerro = true;
		}
	}
	if ($sqlerro == false) {
		$clpcorcamfornelic->incluir($pc21_orcamforne);
		if ($clpcorcamfornelic->erro_status == 0) {
			$sqlerro = true;
			$erro_msg = $clpcorcamfornelic->erro_msg;
		}
	}
	db_fim_transacao($sqlerro);
	$op = 1;



} else if (isset ($excluir)) {
	    $result_val=$clpcorcamval->sql_record($clpcorcamval->sql_query_file($pc21_orcamforne));
	    if ($clpcorcamval->numrows>0){
	    	$erro_msg="Existe valor lançado para o fornecedor!!";
	    }else{
			db_inicio_transacao();
			if ($sqlerro == false) {
				$clpcorcamfornelic->excluir($pc21_orcamforne);
				if ($clpcorcamfornelic->erro_status == 0) {
					$sqlerro = true;
					$erro_msg = $clpcorcamfornelic->erro_msg;
				}
			}

			/**
			 * Exclui da pcorcamjulgamentologitem
			 */
			if ( !$sqlerro ) {

				$sWhere = "pc93_pcorcamforne = {$pc21_orcamforne}";
				$oDaoPcorcamjulgamentologitem->excluir(null, $sWhere);

				$erro_msg = $oDaoPcorcamjulgamentologitem->erro_msg;
				if ( $oDaoPcorcamjulgamentologitem->erro_status == 0 ) {
					$sqlerro = true;
				}
			}

			if ($sqlerro == false) {
				$clpcorcamforne->excluir($pc21_orcamforne);
				$erro_msg = $clpcorcamforne->erro_msg;
				if ($clpcorcamforne->erro_status == 0) {
					$sqlerro = true;
				}
			}
			if ($sqlerro == false) {

			  $result_forne = $clpcorcamfornelic->sql_record($clpcorcamfornelic->sql_query(null,"*",null,"pc20_codorc=$pc20_codorc"));

				if ($clpcorcamfornelic->numrows==0){

					if ($sqlerro == false) {

					  $sWhere  = "pc26_orcamitem in                                         ";
					  $sWhere .= "(select pcorcamitem.pc22_orcamitem                        ";
					  $sWhere .= " from pcorcamitem                                         ";
					  $sWhere .= "   inner join pcorcam                                     ";
					  $sWhere .= "     on    pcorcam.pc20_codorc = pcorcamitem.pc22_codorc  ";
					  $sWhere .= "     where pcorcam.pc20_codorc ={$pc20_codorc})           ";
					  $sWhere .= "                                                          ";
						$clpcorcamitemlic->excluir(null, $sWhere);

						if ($clpcorcamitemlic->erro_status == 0) {

							$sqlerro = true;
							$erro_msg = $clpcorcamitemlic->erro_msg;
						}
					}

					if ($sqlerro == false) {

					  $sWhere  = " pcorcamitem.pc22_codorc in (                          ";
					  $sWhere .= " select pc20_codorc                                    ";
					  $sWhere .= " from pcorcam                                          ";
					  $sWhere .= " where                                                 ";
					  $sWhere .= "         pcorcam.pc20_codorc = pcorcamitem.pc22_codorc ";
					  $sWhere .= "   and   pcorcam.pc20_codorc = {$pc20_codorc})         ";
					  $clpcorcamitem->excluir(null, $sWhere);

						$pc22_orcamitem = $clpcorcamitem->pc22_orcamitem;

						if ($clpcorcamitem->erro_status == 0) {

						  $sqlerro = true;
							$erro_msg = $clpcorcamitem->erro_msg;
						}
					}

					if ($sqlerro == false) {

					  $clpcorcam->excluir($pc20_codorc);
						if ($clpcorcam->erro_status == 0) {

						  $sqlerro = true;
							$erro_msg = $clpcorcam->erro_msg;
						}
					}
					if ($sqlerro == false) {
						$exc_tudo=true;
					}
				}
			}
			/*
			if ($sqlerro == false) {
				db_msgbox("cert");
			}else{
				db_msgbox("err");
			}
			exit;
			*/
			$op = 1;
			db_fim_transacao($sqlerro);
	    }
} else if (isset ($opcao) || (isset ($chavepesquisa) && $chavepesquisa != "")) {
	$l20_codigo = $chavepesquisa;
	$result = $clliclicita->sql_record($clliclicita->sql_query_pco($chavepesquisa));
	if ($result != false && $clliclicita->numrows > 0) {
		db_fieldsmemory($result, 0);
	}
	$db_botao = true;
	$op = 1;
}
if ($l03_pctipocompratribunal == 102) {
		echo "<script>
     parent.document.formaba.db_cred.disabled=false;
    </script>";
		$clcredenciamento = new cl_credenciamento();
		$result_credenciamento = $clcredenciamento->sql_record($clcredenciamento->sql_query(null,"*",null,"l205_licitacao = $l20_codigo"));

		if (pg_num_rows($result_credenciamento) == 0) {
			$db_botao = false;
		}
	}

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
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
	include ("forms/db_frmforneclic.php");
	?>

    </center>
	</td>
  </tr>
</table>
</body>
</html>
<?


if (isset ($alterar) || isset ($excluir) || isset ($incluir) || isset ($verificado)) {
	if (isset ($excluir)&&isset($exc_tudo)&&$exc_tudo==true){
		db_msgbox($erro_msg);
		//echo "<script>location.href='lic1_fornec001.php';</script>";
	}else{
		if ($sqlerro == true) {
			db_msgbox($erro_msg);
			if ($clpcorcamforne->erro_campo != "") {
				echo "<script> document.form1.".$clpcorcamforne->erro_campo.".style.backgroundColor='#99A9AE';</script>";
				echo "<script> document.form1.".$clpcorcamforne->erro_campo.".focus();</script>";
			}
		} else {
			db_msgbox($erro_msg);
			//echo "<script>location.href='lic1_fornec001.php?chavepesquisa=$l20_codigo';</script>";
		}
	}
}

$sWhere = "1!=1";
if (isset($pc21_codorc) && !empty($pc21_codorc)) {
  $sWhere = "pc21_codorc=".@ $pc21_codorc;
}

$result_libera = $clpcorcamforne->sql_record($clpcorcamforne->sql_query_file(null, "pc21_codorc", "", $sWhere));
$tranca        = "true";

if ($clpcorcamforne->numrows > 0) {
	$tranca = "false";
}
if ($op == 11) {
	echo "<script>document.form1.pesquisar.click();</script>";
}

$sWhere = "pc21_codorc=".@ $pc20_codorc;
$result_fornaba = $clpcorcamforne->sql_record($clpcorcamforne->sql_query(null,"pc21_orcamforne,pc21_codorc,pc21_numcgm,z01_nome","",$sWhere));
$iNumCgmForn  = db_utils::fieldsMemory($result_fornaba, 0)->pc21_numcgm;
?>

<input type="hidden" id="cgmaba" value="<? echo $iNumCgmForn ?>" />

<script>

//parent.document.formaba.db_cred.disabled=true;
//parent.document.formaba.db_hab.disabled=true;

if(parent.document.formaba.db_cred.onclick != '') {

	var param1 = $('pc20_codorc').value;
	var param2 = $('l20_codigo').value;
	var param3 = $('cgmaba').value;

	CurrentWindow.corpo.iframe_db_cred.location.href='lic1_credenciamento001.php?pc20_codorc='+param1+'&l20_codigo='+param2+'&l205_fornecedor='+param3;
	//parent.document.formaba.db_cred.disabled=false;
	//parent.document.formaba.db_hab.disabled=false;

}

if(parent.document.formaba.db_habi.onclick != '') {

	var param1 = $('pc20_codorc').value;
	var param2 = $('l20_codigo').value;

	CurrentWindow.corpo.iframe_db_habi.location.href='lic1_habilitacaoforn001.php?l20_codigo='+param2+'&pc20_codorc='+param1;
	//parent.document.formaba.db_cred.disabled=false;
	//parent.document.formaba.db_hab.disabled=false;

}

</script>
