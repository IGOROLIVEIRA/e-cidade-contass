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
$db_opcao = 2;

if(!isset($alterar)){
  $sqlEdital = $clliclicita->sql_query_edital('', '*', '', 'l20_nroedital = '.$numero_edital. ' and extract(year from l20_datacria) >= 2020 ');
  $rsEdital = $clliclicita->sql_record($sqlEdital);
  $oDados = db_utils::fieldsMemory($rsEdital, 0);

  $numero_edital = $oDados->l20_nroedital;
  $objeto = $oDados->l20_objeto;
  $edital = $oDados->l20_edital;
  $tipo_tribunal = $oDados->l44_sequencial;
  $descr_tribunal = strtoupper($oDados->l44_descricao);
  $origem_recurso = $oDados->l47_origemrecurso;
  $descricao_recurso = $oDados->l47_descrecurso;
  $links = $oDados->l47_linkpub;
  $data_referencia = join('/', array_reverse(explode('-', $oDados->l47_dataenvio)));
  $natureza_objeto = $oDados->l20_naturezaobjeto;
}

if(isset($alterar)){

  $sqlEdital = $clliclancedital->sql_query_completo('', 'l20_codigo, l47_sequencial', '', 'l20_nroedital = '.$numero_edital);
  $rsEdital = $clliclancedital->sql_record($sqlEdital);
  $oDadosEdital = db_utils::fieldsMemory($rsEdital, 0);

  if(isset($oDadosEdital->l47_sequencial)){
    $data_formatada = str_replace('/', '-',db_formatar($data_referencia, 'd'));
    $clliclancedital->l47_linkpub = $links;
    $clliclancedital->l47_origemrecurso = $origem_recurso;
    $clliclancedital->l47_descrecurso = $descricao_recurso;
    $clliclancedital->l47_dataenvio = $data_formatada;
    $clliclancedital->l47_liclicita = $oDadosEdital->l20_codigo;

    $clliclancedital->alterar($oDadosEdital->l47_sequencial);
    $erro_msg = $clliclancedital->erro_sql;
    if ($clliclancedital->erro_status == '0'){
      $sqlerro=true;
    }
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

echo "<script>";
echo "parent.document.formaba.documentos.disabled=false;";
echo "parent.iframe_documentos.location.href='lic4_editaldocumentos.php?l20_codigo=$oDadosEdital->l20_codigo&l20_nroedital=$numero_edital&l47_sequencial=$oDadosEdital->l47_sequencial&natureza_objeto=$natureza_objeto&cod_tribunal=$tipo_tribunal';";
echo "</script>";

if(isset($alterar)) {
  echo "<script>";
  echo "alert('" . $erro_msg . "');";
  echo "</script>";

//  if(!$sqlerro){
//    echo "<script>";
//    echo "parent.document.formaba.documentos.disabled=false;";
//    echo "parent.iframe_documentos.location.href='lic4_editaldocumentos.php?l20_codigo=$oDadosEdital->l20_codigo&l20_nroedital=$numero_edital&l47_sequencial=$oDadosEdital->l47_sequencial&natureza_objeto=$natureza_objeto&cod_tribunal=$tipo_tribunal';";
//    echo "</script>";
//  }
}
  echo "<script>document.form1.data_referencia.value = '".$data_referencia."';</script>";
?>
