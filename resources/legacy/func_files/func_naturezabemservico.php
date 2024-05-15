<?
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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_naturezabemservico_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clnaturezabemservico = new cl_naturezabemservico;
$clnaturezabemservico->rotulo->label("e101_sequencial");
$clnaturezabemservico->rotulo->label("e101_descr");
$clnaturezabemservico->rotulo->label("e101_aliquota");
?>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
  <table height="100%" border="0" align="center" cellspacing="0" bgcolor="#CCCCCC">
    <tr>
      <td height="63" align="center" valign="top">
        <table width="50%" border="0" align="center" cellspacing="0">
          <form name="form2" method="post" action="">
            <tr>
              <td width="4%" align="center" nowrap title="<?= $Te101_sequencial ?>">
                <?= $Le101_sequencial ?>
                <?
                db_input("e101_sequencial", 8, $Ie101_sequencial, true, "text", 4, "", "chave_e101_sequencial");
                ?>
              </td>
            </tr>
            <tr>
              <td colspan="2" align="center">
                <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
                <input name="limpar" type="reset" id="limpar" value="Limpar">
                <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_naturezabemservico.hide();">
              </td>
            </tr>
          </form>
        </table>
      </td>
    </tr>
    <tr>
      <td align="center" valign="top">
        <?
        if (!isset($pesquisa_chave)) {
          if (isset($campos) == false) {
            if (file_exists("funcoes/db_func_naturezabemservico.php") == true) {
              include("funcoes/db_func_naturezabemservico.php");
            } else {
              $campos = "e101_sequencial, e101_codnaturezarendimento, e101_resumo, e101_aliquota ";
            }
          }
          if (isset($chave_e101_sequencial) && (trim($chave_e101_sequencial) != "")) {
            $sql = $clnaturezabemservico->sql_query($chave_e101_sequencial, $campos, "e101_sequencial");
          } else {
            $sql = $clnaturezabemservico->sql_query("", $campos, "e101_sequencial");
          }
          db_lovrot($sql, 15, "()", "", $funcao_js);
        }else{
          if($pesquisa_chave != ""){
              $result = $clnaturezabemservico->sql_record($clnaturezabemservico->sql_query(null,"*",null,"e101_codnaturezarendimento = ".$pesquisa_chave));
              if (($result != false) && (pg_numrows($result) != 0)) {
                db_fieldsmemory($result, 0);
              echo "<script>" . $funcao_js . "(false,'$e101_descr');</script>\n";
            }else{
              echo "<script>" . $funcao_js . "(true,'Código (" . $pesquisa_chave . ") não Encontrado');</script>\n";
            }
          }
        }
        ?>
      </td>
    </tr>
  </table>
</body>

</html>
