<?
/*
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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_face_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clface = new cl_face;
$cllote = new cl_lote;
$clface->rotulo->label("j37_face");
$clface->rotulo->label("j37_setor");
$clface->rotulo->label("j37_quadra");
$cllote->rotulo->label("j34_distrito");

$config = db_query("select * from db_config where codigo = ".db_getsession("DB_instit"));
db_fieldsmemory($config,0);
?>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="document.form2.chave_j37_setor.focus();">
  <table height="100%" width="100%" border="0" align="center" cellspacing="0" bgcolor="#CCCCCC">
    <tr>
      <td height="63" align="center" valign="top">
        <table width="35%" border="0" align="center" cellspacing="0">
          <form name="form2" method="post" action="">
            <?php if (!empty($db21_usadistritounidade) && $db21_usadistritounidade == 't') : ?>
            <tr>
              <td width="4%" align="right" nowrap title="<?= $Tj34_distrito ?>">
                <?= $Lj34_distrito ?>
              </td>
              <td width="96%" align="left" nowrap>
                <?
                db_input("j34_distrito", 4, $Ij34_distrito, true, "text", 4, "", "chave_j34_distrito");
                ?>
              </td>
            </tr>
            <?php endif; ?>
            <tr>
              <td width="4%" align="right" nowrap title="<?= $Tj37_face ?>">
                <?= $Lj37_face ?>
              </td>
              <td width="96%" align="left" nowrap>
                <?
                db_input("j37_face", 4, $Ij37_face, true, "text", 4, "", "chave_j37_face");
                ?>
              </td>
            </tr>
            <tr>
              <td width="4%" align="right" nowrap title="<?= $Tj37_setor ?>">
                <?= $Lj37_setor ?>
              </td>
              <td width="96%" align="left" nowrap>
                <?
                db_input("j37_setor", 4, $Ij37_setor, true, "text", 4, "", "chave_j37_setor");
                ?>
              </td>
            </tr>
            <tr>
              <td width="4%" align="right" nowrap title="<?= $Tj37_quadra ?>">
                <?= $Lj37_quadra ?>
              </td>
              <td width="96%" align="left" nowrap>
                <?
                db_input("j37_quadra", 4, $Ij37_quadra, true, "text", 4, "", "chave_j37_quadra");
                ?>
              </td>
            </tr>
            <tr>
              <td colspan="2" align="center">
                <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
                <input name="limpar" type="reset" id="limpar" value="Limpar">
                <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe.hide();">
              </td>
            </tr>
          </form>
        </table>
      </td>
    </tr>
    <tr>
      <td align="center" valign="top">
        <?
        $wsetor = "";
        $wquadra = "";
        $xy = "";
        $join = " INNER JOIN ruas ON ruas.j14_codigo = face.j37_codigo
                                INNER JOIN setor ON setor.j30_codi = face.j37_setor
                                INNER JOIN lote ON lote.j34_setor = setor.j30_codi ";
        $group = " GROUP BY j37_face, j34_distrito, j14_nome ";
        if (!isset($pesquisa_chave)) {
          if (isset($campos) == false) {
            $distrito = $db21_usadistritounidade == 't' ? "j34_distrito," : "";
            $campos = "DISTINCT j37_face,{$distrito}j37_setor,j37_quadra,j37_codigo,j14_nome,j37_lado,j37_valor,j37_exten,j37_profr,j37_outros,j37_vlcons,j37_zona";
          }

          if (isset($chave_j37_face) && (trim($chave_j37_face) != "")) {
            $sql = $db21_usadistritounidade == 't' ? $clface->sql_query_join($chave_j37_face, $campos, "j37_face, j34_distrito", null, $join, $group)
                                                        : $clface->sql_query($chave_j37_face, $campos, "j37_face");
          }

          else {
            if (isset($chave_j37_setor) && (trim($chave_j37_setor) != "")) {
              $wsetor = " j37_setor = '$chave_j37_setor' ";
              $xy = " and ";
            }
            if (isset($chave_j37_quadra) && (trim($chave_j37_quadra) != "")) {
              $wquadra = $xy . " j37_quadra = '$chave_j37_quadra' ";
              $xy = " and ";
            }
            if (!empty($db21_usadistritounidade) && $db21_usadistritounidade == 't') {
                if (isset($chave_j34_distrito) && (trim($chave_j34_distrito) != "")) {
                  $wquadra = $xy . " j34_distrito = '$chave_j34_distrito' ";
                  $xy = " and ";
                }
            }

            if ($xy == "" && isset($pesquisar) || isset($filtroquery)) {
                $sql = $db21_usadistritounidade == 't' ? $clface->sql_query_join("", $campos, "j37_face, j34_distrito", null, $join, $group)
                                                            : $clface->sql_query("", $campos, "j37_face");
            } else if ($xy != "") {
                $sql = $db21_usadistritounidade == 't' ? $clface->sql_query_join("", $campos, "j37_face, j34_distrito", $wsetor . $wquadra, $join, $group)
                                                            : $clface->sql_query("", $campos, "j37_face", $wsetor . $wquadra);
            }
          }
          if (isset($sql) && $sql != "") {
            db_lovrot($sql, 15, "()", "", $funcao_js);
          }
        } else {
          $result = $clface->sql_record($clface->sql_query($pesquisa_chave));
          if ($clface->numrows != 0) {
            db_fieldsmemory($result, 0);
            echo "<script>" . $funcao_js . "('$j37_face',false);</script>";
          } else {
            echo "<script>" . $funcao_js . "('Chave(" . $pesquisa_chave . ") não Encontrado',true);</script>";
          }
        }
        ?>
      </td>
    </tr>
  </table>
</body>

</html>
<?
if (!isset($pesquisa_chave)) {
?>
  <script>
    document.form2.chave_j37_face.focus();
    document.form2.chave_j37_face.select();
  </script>
<?
}
?>
