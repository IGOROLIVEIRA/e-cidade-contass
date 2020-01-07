  <?php
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
require_once("libs/db_usuariosonline.php");
require_once("libs/db_utils.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_liclicita_classe.php");
require_once("classes/db_liclancedital_classe.php");
require_once("classes/db_cflicita_classe.php");
include("dbforms/db_classesgenericas.php");

$clliclicita = new cl_liclicita;
$clliclancedital = new cl_liclancedital;
$clcflicita  = new cl_cflicita;

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$sqlerro = false;

//  Realizar busca pelos campos
  $l20_nroedital = $edital != '' ? $edital : $l20_nroedital;
  $sqlLicita = $clliclicita->sql_query('', 'l20_codigo, l20_edital, l20_objeto, pctipocompratribunal.l44_sequencial as tipo_tribunal,
	   UPPER(pctipocompratribunal.l44_descricao) as descr_tribunal, l20_naturezaobjeto as natureza_objeto, 
	   (CASE 
          WHEN pc50_pctipocompratribunal in (48, 49, 50, 52, 53, 54) 
            THEN liclicita.l20_dtpublic
          WHEN pc50_pctipocompratribunal in (100, 101, 102, 106) 
            THEN liclicita.l20_datacria
          END) as dl_Data_Referencia', '', 'l20_nroedital = '.$l20_nroedital);
  $rsLicita = $clliclicita->sql_record($sqlLicita);
  db_fieldsmemory($rsLicita, 0);

  if(isset($incluir)){
    $data_formatada = str_replace('/', '-',db_formatar($data_referencia, 'd'));
    $clliclancedital->l47_linkpub = $links;
    $clliclancedital->l47_origemrecurso = $origem_recurso;
    $clliclancedital->l47_descrecurso = $descricao_recurso;
    $clliclancedital->l47_dataenvio = $data_formatada;
    $clliclancedital->l47_liclicita = $l20_codigo;
    $clliclancedital->incluir(null);

  if ($clliclancedital->erro_status=="0"){
    $erro_msg = $clliclancedital->erro_msg;
    $sqlerro=true;
  }

}

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/widgets/windowAux.widget.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/widgets/dbmessageBoard.widget.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/widgets/dbtextField.widget.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/widgets/dbcomboBox.widget.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/widgets/dbautocomplete.widget.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.maskedinput.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/datagrid.widget.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/classes/dbViewCadDadosComplementares.classe.js"></script>

<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<style>
  #msgBoardEnderecodadosCompl_title{
    padding-top: 15px;
  }
</style>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="430" align="center" valign="top" bgcolor="#CCCCCC">
    <center>
    <?
    include("forms/db_frmlicedital.php");
    ?>
    </center>
    </td>
  </tr>
</table>
<script>
</script>
</body>
</html>
<?
if(isset($incluir) ) {
    echo "<script>";
    echo "alert('" . $clliclancedital->erro_sql . "')";
    echo "</script>";

  if (!$sqlerro && trim($clliclancedital->erro_sql) != '') {
    echo "<script>";
    echo "parent.document.formaba.documentos.disabled=false;";
    echo "console.log(parent.document.formaba.documentos);";
    echo "parent.mo_camada('documentos');";
    echo "</script>";
  }
}
?>


