<?

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("dbforms/db_classesgenericas.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
require_once("classes/db_liclicita_classe.php");
db_postmemory($HTTP_POST_VARS);

$clrotulo = new rotulocampo;
$clrotulo->label("l20_codigo");
?>

<html>

<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>

  <script>
    function js_emite() {

      query = 'l20_codigo=' + document.form1.l20_codigo.value;

      query += '&listAutoriza=' + document.form1.listAutoriza.value;

      jan = window.open('lic2_taxatabela002.php?' + query, '', 'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ');
      jan.moveTo(0, 0);
    }
  </script>

  <link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
  <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
    <tr>
      <td width="360" height="18">&nbsp;</td>
      <td width="263">&nbsp;</td>
      <td width="25">&nbsp;</td>
      <td width="140">&nbsp;</td>
    </tr>
  </table>

  <div style="margin: 2% 29%;">
    <fieldset>
      <legend>Execução Taxa/Tabela </legend>
      <table align="center">
        <form name="form1" method="post" action="">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>

          <tr>
            <td align="left" nowrap title="<?= $Tl20_codigo ?>">
              <b>
                <?
                db_ancora('Licitação :', "js_pesquisa_liclicita(true);", 1);
                ?>
              </b>
            </td>
            <td align="left" nowrap>
              <?
              db_input("l20_codigo", 8, $Il20_codigo, true, "text", 1, "onchange='js_pesquisa_liclicita(false);'");
              db_input("l20_objeto", 40, $Il20_objeto, true, "text", 3, "");
              ?>
            </td>
          </tr>

          <tr>
            <td>
              <b>Listar Autorização:</b>
            </td>
            <td>
              <select name="listAutoriza" id="listAutoriza">
                <option value="f">NÃO</option>
                <option value="t">SIM</option>
              </select>
            </td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="center">
              <input name="emite2" id="emite2" type="button" value="Gerar Relatório" onclick="js_emite();">
            </td>
          </tr>

        </form>
      </table>
    </fieldset>
  </div>
  <?
  db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
  ?>
</body>

</html>

<script>
  function js_pesquisal20_numero(mostra) {
    if (mostra == true) {
      if (document.form1.l03_codigo.value != "") {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_licnumeracao', 'func_liclicita.php?chave_l03_codigo=' + document.form1.l03_codigo.value + '&funcao_js=parent.js_mostralicnumeracao1|l20_numero', 'Pesquisa', true);
      } else {
        alert("Selecione uma modalidade!");
        document.form1.l03_codigo.focus();
        document.form1.l03_codigo.select();
      }
    }
  }

  function js_mostralicnumeracao1(chave1) {
    document.form1.l20_numero.value = chave1;
    db_iframe_licnumeracao.hide();
  }

  function js_pesquisa_liclicita(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('top.corpo', 'db_iframe_liclicita', 'func_liclicita.php?lContratos=1&criterioadjudicacao=true&funcao_js=parent.js_mostraliclicita1|l20_codigo|l20_objeto', 'Pesquisa', true);
    } else {
      if (document.form1.l20_codigo.value != '') {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_liclicita', 'func_liclicita.php?lContratos=1&criterioadjudicacao=true&pesquisa_chave=' + document.form1.l20_codigo.value + '&funcao_js=parent.js_mostraliclicita', 'Pesquisa', false);
      } else {
        document.form1.l20_codigo.value = '';
        document.form1.l20_objeto.value = '';
      }
    }
  }

  function js_mostraliclicita(chave, erro) {
    document.form1.l20_objeto.value = chave;
    if (erro == true) {
      document.form1.l20_codigo.value = '';
      document.form1.l20_objeto.value = '';
      document.form1.l20_codigo.focus();
    }
  }

  function js_mostraliclicita1(chave1, chave2) {
    document.form1.l20_codigo.value = chave1;
    document.form1.l20_objeto.value = chave2;
    db_iframe_liclicita.hide();
  }
</script>