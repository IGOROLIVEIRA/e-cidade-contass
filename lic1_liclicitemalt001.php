<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2013  DBselller Servicos de Informatica
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
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_liclicita_classe.php");
require_once("classes/db_liclicitem_classe.php");
require_once("classes/db_liclicitemlote_classe.php");
require_once("classes/db_pcproc_classe.php");
require_once("classes/db_pcprocitem_classe.php");
require_once("classes/db_pcorcamitemproc_classe.php");
require_once("classes/db_itensregpreco_classe.php");
require_once("classes/db_adesaoregprecos_classe.php");

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$clliclicita  = new cl_liclicita;
$clliclicitem = new cl_liclicitem;
$clliclicitemlote = new cl_liclicitemlote;
$clpcproc = new cl_pcproc;
$clpcprocitem = new cl_pcprocitem;
$clpcorcamitemproc = new cl_pcorcamitemproc;
$clitensregpreco = new cl_itensregpreco;
$cladesaoregprecos = new cl_adesaoregprecos;

$sqlerro = false;
$erro_msg = '';

if(isset($codprocesso) && $codprocesso != ''){
    //liclicitem

    $sSqlLicita = $clliclicita->sql_query_pco($licitacao, ' DISTINCT liclicita.* ');
    $rsLicita = $clliclicita->sql_record($sSqlLicita);
    $oLicitacao = db_utils::fieldsMemory($rsLicita, 0);

    if($oLicitacao->l20_cadinicial != 1 && pg_num_rows($rsLicita)){
        $sqlerro = true;
    }

    $sSqlFornec = $clliclicita->sql_query($licitacao, " DISTINCT pcorcamforne.* ", '',
        " l20_codigo = $licitacao and pc21_orcamforne IS NOT NULL ");
    $rsFornec = $clliclicita->sql_record($sSqlFornec);

    if(pg_num_rows($rsFornec)){
        $sqlerro = true;
    }

}

if(!$sqlerro && $codprocesso){

    $oDaoPcorcamitemlic = db_utils::getDao('pcorcamitemlic');
    $sSqlOrcamItem = $oDaoPcorcamitemlic->sql_query(null, '*', null, 'pc81_codproc = '.$codprocesso);
    $rsOrcamItem = $oDaoPcorcamitemlic->sql_record($sSqlOrcamItem);

    if(pg_numrows($rsOrcamItem)){
        $sqlerro = true;
        $erro_msg = 'Existe orçamento lançado para o processo de compras ' . $codprocesso;
    }

	if(!$sqlerro){
	    $clliclicitemlote->excluir('', ' l04_liclicitem in (select l21_codigo from liclicitem
	        where l21_codpcprocitem in (select pc81_codprocitem from pcprocitem where pc81_codproc = '.$codprocesso.'))');

	    if($clliclicitemlote->erro_status == '0'){
			$sqlerro = true;
			$erro_msg = $clpcprocitem->erro_msg;
        }
    }

    if(!$sqlerro){
	    $clliclicitem->excluir('',
            'l21_codpcprocitem in (select pc81_codprocitem from pcprocitem where pc81_codproc = '.$codprocesso.')');

	    if($clliclicitem->erro_status == '0'){
	        $sqlerro = true;
	        $erro_msg = $clliclicitem->erro_msg;
        }

    }

    if(!$sqlerro){
		$clitensregpreco->excluir('',
            'si07_sequencialadesao = (select si06_sequencial from adesaoregprecos where si06_processocompra = '.$codprocesso.')');
        
        if($clitensregpreco->erro_status = '0'){
		    $sqlerro = true;
		    $erro_msg = $clitensregpreco->erro_msg;
        }
    }

}

if($codprocesso){
    if($sqlerro){
        if(!$erro_msg){
            echo "<script>alert('Processo de Compra $codprocesso não pode ser excluído.');</script>";
        }else{
            echo "<script>alert('$erro_msg');</script>";
        }
    }else{
        echo "<script>alert('Processo de Compra $codprocesso excluído com sucesso!');</script>";
    }
}


$db_opcao = 1;
$db_botao = true;
$lRegistroPreco = false;
if (isset($licitacao) && trim($licitacao)!="" && !$sqlerro){
     $result = $clliclicita->sql_record($clliclicita->sql_query($licitacao,"l08_altera, l20_usaregistropreco, l20_nroedital, l20_naturezaobjeto"));
     if ($clliclicita->numrows > 0){
          db_fieldsmemory($result,0);

          if ($l08_altera == "t"){
               $db_botao = true;
          }
          if ($l20_usaregistropreco == "t") {
            $lRegistroPreco = true;
          }
     }
}
$db_botao = true;
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
<table width="790" border="0" cellpadding="0" cellspacing="0" >
  <tr>
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table width="790" border="0" cellspacing="0" cellpadding="0" style="margin:0 auto;">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
    <center>
	<?
	include("forms/db_frmliclicitemalt.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
