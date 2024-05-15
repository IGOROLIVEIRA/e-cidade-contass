<?php

/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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
require_once("classes/db_rubricasesocial_classe.php");
require_once("classes/db_baserubricasesocial_classe.php");
require_once("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
$clcriaabas     = new cl_criaabas;
$db_opcao = 3;
db_postmemory($HTTP_POST_VARS);
$clrubricasesocial  = new cl_rubricasesocial;
$clbaserubricasesocial  = new cl_baserubricasesocial;
if(isset($excluir)){
  //deleta
  db_inicio_transacao();
  $clbaserubricasesocial->excluir(null, $e990_sequencial);
  if($clbaserubricasesocial->erro_status == '0'){
    db_fim_transacao(true);
    db_msgbox($clbaserubricasesocial->erro_msg);
  }

  $clrubricasesocial->excluir($e990_sequencial);
  if($clrubricasesocial->erro_status == '0'){
    db_fim_transacao(true);
    db_msgbox($clrubricasesocial->erro_msg);
  }
  if($clrubricasesocial->erro_status != '0'){
    db_msgbox($clrubricasesocial->erro_msg);
    db_fim_transacao(false);
  }
  echo '<script type="text/javascript">';
  echo " location.href='pes2_rubricasesocial001.php' ";
  echo '</script>';

}
if(isset($incluir)){
  $clrubricasesocial->e990_sequencial = $e990_sequencial;
  $clrubricasesocial->e990_descricao = $e990_descricao;
  $clrubricasesocial->incluir();
}
if(isset($alterar)){
  //altera
 $clrubricasesocial->e990_descricao = $e990_descricao;
 $clrubricasesocial->alterar($e990_sequencial);

 db_msgbox($clrubricasesocial->erro_msg);

 echo '<script type="text/javascript">';
 echo " parent.location.href='pes2_rubricasesocial002.php?liberaaba=true&chavepesquisa=$e990_sequencial' ";
 echo '</script>';
}

db_postmemory($HTTP_GET_VARS);
if(isset($chavepesquisa)){

 $rubrica = $clrubricasesocial->sql_query_file($chavepesquisa);

 $orubrica = $clrubricasesocial->sql_record($rubrica);
 db_fieldsmemory($orubrica);
 $db_opcao = 3;
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
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" >
    <tr>
      <td width="360" height="18">&nbsp;</td>
      <td width="263">&nbsp;</td>
      <td width="25">&nbsp;</td>
      <td width="140">&nbsp;</td>
    </tr>
  </table>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="200" align="left" valign="top" bgcolor="#CCCCCC">
        <center>

          <?php
          include("forms/db_frmrubricasesocial.php");
          ?>

        </center>
      </td>
    </tr>
  </table>
  <?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
  ?>

  <?php
  if(isset($incluir)){

    if($clrubricasesocial->erro_status != 0){
      db_msgbox($clrubricasesocial->erro_msg);
      echo '<script type="text/javascript">';
      echo " parent.location.href='pes2_rubricasesocial002.php?liberaaba=true&chavepesquisa=$e990_sequencial' ";
      echo '</script>';
    }else{
      db_msgbox($clrubricasesocial->erro_msg);
    }
  }
  ?>

</body>
</html>
