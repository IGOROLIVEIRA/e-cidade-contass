<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("dbforms/db_classesgenericas.php");
require_once("model/contabilidade/relatorios/AnexoIBalancoOrcamentario.model.php");

$oGet = db_utils::postMemory($_GET,0);

$clCriaAbas = new cl_criaabas;
$iAnoUsu    = db_getsession("DB_anousu");

if(isset($oGet->newlrf) && $oGet->newlrf == true){
    $iCodRel = 155;
} else if (isset($oGet->dfiscal) && $oGet->dfiscal == true) {
  $iCodRel = 79;

	if ($iAnoUsu >= 2015) {
		$iCodRel = AnexoIBalancoOrcamentario::CODIGO_RELATORIO;
	}

} else {

	if ( $iAnoUsu <= 2007 ){
	  $iCodRel = 15;
	} else {
	  $iCodRel = 22;
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
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

	    $clCriaAbas->identifica = array("relatorio"=>"Relatorio",
	                                    "parametro"=>"Parametros",
	                                    "notas"    =>"Fonte/Notas Explicativas"
	                                    );

	    $clCriaAbas->title      = array("relatorio"=>"Relatorio",
	                                    "parametro"=>"Parametros",
	                                    "notas"    =>"Fonte/Notas Explicativas"
	                                    );

	    $clCriaAbas->src        = array("relatorio"=>"con2_lrfbalorc011.php?c83_codrel={$iCodRel}",
	                                    "parametro"=>"con4_parametrosrelatorioslegais001.php?c83_codrel={$iCodRel}",
	                                    "notas"    =>"con2_conrelnotas.php?c83_codrel={$iCodRel}"
	                                    );

	    $clCriaAbas->sizecampo  = array("relatorio"=>"23",
	                                    "parametro"=>"23",
	                                    "notas"    =>"23");
	    $clCriaAbas->cria_abas();

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