<?

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");

db_postmemory($HTTP_POST_VARS);
db_postmemory($HTTP_GET_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);


?> <html>

<head>
  <meta http-equiv="Content-Type" content="text/html;
charset=iso-8859-1">
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
  <table height="100%" width="100%" border="0" align="center" cellspacing="0" bgcolor="#CCCCCC">
    <tr>
      <td height="63" align="center" valign="top">
        <table width="35%" border="0" align="center" cellspacing="0">
          <form name="form2" method="post" action="">
            <tr>
              <td width="4%" align="left">
                <b> Codigo: </b>
              </td>
              <td width="96%" align="left" nowrap>
                <?
                db_input("chave_t98_sequencial", 20, 1, true, "text", 4, "", "chave_t98_sequencial");
                ?>
              </td>
            </tr>
            <tr>
              <td width="4%" align="left" nowrap>
                <b> Descrição: </b>
              </td>
              <td width="96%" align="left" nowrap>
                <?
                db_input("chave_t98_descricao", 40, 3, true, "text", 4, "", "chave_t98_descricao");
                ?>
              </td>
            </tr>

            <tr>
              <td colspan="2" align="center">
                <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
                <input name="limpar" type="button" id="limpar" value="Limpar" onClick="js_limpar();">
                <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_bens.hide();">
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


          $where = "";


          if (isset($chave_t98_sequencial) && trim($chave_t98_sequencial)) {
            $where .= " and t98_sequencial = '$chave_t98_sequencial'";
          }

          if (isset($chave_t98_descricao) && trim($chave_t98_descricao)) {
            $where .= " and t98_descricao like '$chave_t98_descricao%'";
          }

          if ($exclusao == true) {
            $where .= " and t98_manutencaoprocessada = 'f'";
          }

          $sql = "select t98_sequencial, t98_bem, t98_data, t98_vlrmanut, t98_descricao,t98_tipo,t52_ident,t52_descr,t52_valaqu,t44_valoratual,t52_depart,descrdepto,t98_manutencaoprocessada
          from bemmanutencao
          inner join bens on t52_bem = t98_bem
          inner join bensdepreciacao on t44_bens = t98_bem
          inner join db_depart on coddepto = t52_depart
          where t98_sequencial in (select max(t98_sequencial) from bemmanutencao where t98_bem=t52_bem) $where order by t98_sequencial";
          db_lovrot($sql, 15, "()", "", $funcao_js);
        }
        ?>
      </td>
    </tr>
  </table>
</body>

</html>
<script>
  function js_limpar() {
    document.form2.t64_class.value = "";
    document.form2.chave_t52_bem.value = "";
    document.form2.chave_t52_descr.value = "";
    document.form2.descrdepto.value = "";
  }
</script>