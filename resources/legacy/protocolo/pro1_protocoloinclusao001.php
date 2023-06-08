<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBselller Servicos de Informatica
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
//echo '<pre>';ini_set("display_errors", "On");
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_classesgenericas.php");
include("dbforms/db_funcoes.php");

db_postmemory($HTTP_POST_VARS);

$clcriaabas = new cl_criaabas;
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
      <td width="360" height="18">&nbsp;</td>
      <td width="263">&nbsp;</td>
      <td width="25">&nbsp;</td>
      <td width="140">&nbsp;</td>
  </tr>
</table>
<table valign="top" marginwidth="0" width="790" border="0" cellspacing="0" cellpadding="0">
   <tr>
       <td>
        <?
          $clcriaabas->identifica = array("dadosprocesso"=>"Dados Processo",
                                          "autorizacaodeempenho"=>"Autorização de Empenho",
                                          "empenho"=>"Empenho",
                                          "ordemdecompra"=>"Ordem de Compra",
                                          "ordemdepagamento"=>"Ordem de Pagamento",
                                          "slip" => "Slip"
                                          );

          $clcriaabas->title      = array("dadosprocesso"=>"Dados Processo",
                                          "autorizacaodeempenho"=>"Autorização de Empenho",
                                          "empenho"=>"Empenho",
                                          "ordemdecompra"=>"Ordem de Compra",
                                          "ordemdepagamento"=>"Ordem de Pagamento",
                                          "slip" => "Slip"
                                          );


          $clcriaabas->src        = array("dadosprocesso"=>"pro1_aba1protocoloinclusao004.php",
                                          "autorizacaodeempenho"=>"pro1_aba2protprocesso004.php",
                                          "empenho"=>"pro1_aba3protprocesso004.php",
                                          "ordemdecompra"=>"pro1_aba4protprocesso004.php",
                                          "ordemdepagamento"=>"pro1_aba5protprocesso004.php",
                                          "slip" => "pro1_aba6protprocesso004.php"
                                          );

          $clcriaabas->disabled   = array("dadosprocesso"=>"false",
                                          "autorizacaodeempenho"=>"true",
                                          "empenho"=>"true",
                                          "ordemdecompra"=>"true",
                                          "ordemdepagamento"=>"true",
                                          "slip" => "true"
                                          );

          $clcriaabas->cria_abas();
        ?>
       </td>
   </tr>
   <tr>
  </tr>
</table>
<?php
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
<script>
  document.formaba.dadosprocesso.size        = 25;
  document.formaba.autorizacaodeempenho.size = 25;
  document.formaba.empenho.size              = 25;
  document.formaba.ordemdecompra.size        = 25;
  document.formaba.ordemdepagamento.size     = 25;
  document.formaba.slip.size                 = 25;
</script>
</html>
