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
                db_input("chave_e139_sequencial", 10, 1, true, "text", 4, "", "chave_e139_sequencial");
                ?>
              </td>
            </tr>
            <tr>
              <td width="4%" align="left" nowrap>
                <b> Descrição: </b>
              </td>
              <td width="96%" align="left" nowrap>
                <?
                db_input("pc01_descrmater", 60, 3, true, "text", 4, "", "pc01_descrmater");
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


          if (isset($chave_e139_sequencial) && trim($chave_e139_sequencial)) {
            $where .= " and e139_sequencial = '$chave_e139_sequencial'";
          }

          if (isset($chave_pc01_descrmater) && trim($chave_pc01_descrmater)) {
            $where .= " and pc01_descrmater like '$chave_pc01_descrmater%'";
          }


          $sql = "select e139_sequencial,pc01_descrmater  from bensdispensatombamento
          inner join matestoqueitem on m71_codlanc = e139_matestoqueitem
          inner join matestoque on m70_codigo = m71_codmatestoque
          inner join matmater on m70_codmatmater = m60_codmater
          inner join transmater on m63_codmatmater = m60_codmater
          inner join pcmater on pc01_codmater = m63_codpcmater where 1=1 $where order by e139_sequencial";


          db_lovrot($sql, 15, "()", "", $funcao_js);
        }
        ?>
      </td>
    </tr>
  </table>
</body>

</html>
<script>
  document.getElementsByClassName('DBLovrotTdCabecalho').item(10).style.display = 'none';
  document.getElementsByClassName('DBLovrotTdCabecalho').item(11).style.display = 'none'

  for (i = 0; i < 15; i++) {
    document.getElementById('I' + i + '10').style.display = 'none';
    document.getElementById('I' + i + '11').style.display = 'none';
  }

  function js_troca(obj) {
    js_mascara02_t64_class();
  }

  function js_limpar() {
    document.form2.t64_class.value = "";
    document.form2.chave_t52_bem.value = "";
    document.form2.chave_t52_descr.value = "";
    document.form2.descrdepto.value = "";
  }
</script>
<?
if (!isset($pesquisa_chave)) {
?>
  <script>
  </script>
<?
}
?>