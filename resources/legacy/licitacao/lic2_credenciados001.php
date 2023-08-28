<?

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");

db_app::load("scripts.js,windowAux.widget.js, prototype.js");
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
  <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
    <tr>
      <td width="360" height="18">&nbsp;</td>
      <td width="263">&nbsp;</td>
      <td width="25">&nbsp;</td>
      <td width="140">&nbsp;</td>
    </tr>
  </table>

  <table align="center" style="margin-top: 20px;">
    <form name="form1" method="post" action="">

      <tr>
        <td align="left" nowrap title="<?= $Tl20_codigo ?>">
          <b>
            <? db_ancora('Licitação', "js_pesquisa_liclicita(true);", 1); ?>&nbsp;:
          </b>
        </td>

        <td align="left" nowrap>
          <? db_input("l20_codigo", 6, $Il20_codigo, true, "text", 1, "onchange='js_pesquisa_liclicita(false);'");
          ?></td>
      </tr>

      <tr>
        <td colspan="2" align="center">
          <input style="margin-top: 10px;" name="emite2" id="emite2" type="button" value="Processar" onclick="js_selecionarFormatoRelatorio();">
        </td>
      </tr>

    </form>
  </table>
  <?
  db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
  ?>
</body>

</html>

<script>
  js_pesquisa_liclicita(true);

  function js_pesquisa_liclicita(mostra) {

    if (mostra == true) {
      js_OpenJanelaIframe('top.corpo', 'db_iframe_liclicita', 'func_liclicita.php?relatoriocredenciamento=true&funcao_js=parent.js_mostraliclicita1|l20_codigo', 'Pesquisa', true);
      return true;
    }

    if (document.form1.l20_codigo.value != '') {
      js_OpenJanelaIframe('top.corpo', 'db_iframe_liclicita', 'func_liclicita.php?relatoriocredenciamento=true&pesquisa_chave=' + document.form1.l20_codigo.value + '&funcao_js=parent.js_mostraliclicita', 'Pesquisa', false);
      return true;
    }

    document.form1.l20_codigo.value = '';

  }

  function js_mostraliclicita(chave, erro) {
    if (erro == true) {
      alert('Usuário: Licitação não encontrada.');
      document.form1.l20_codigo.value = '';
      document.form1.l20_codigo.focus();
    }
  }

  function js_mostraliclicita1(chave1) {
    document.form1.l20_codigo.value = chave1;
    db_iframe_liclicita.hide();
  }

  function js_selecionarFormatoRelatorio() {

    if (document.form1.l20_codigo.value == '') return alert('Usuário: Selecione a licitação.');

    var iHeight = 200;
    var iWidth = 300;
    windowFormatoRelatorio = new windowAux('windowFormatoRelatorio',
      'Gerar Relatório ',
      iWidth,
      iHeight
    );

    var sContent = "<div style='margin-top:30px;'>";
    sContent += "<fieldset>";
    sContent += "<legend>Gerar Relatório de Credenciados em:</legend>";
    sContent += "  <div >";
    sContent += "  <input checked type='radio' id='pdf' name='formato'>";
    sContent += "  <label>PDF</label>";
    sContent += "  </div>";
    sContent += "  <div>";
    sContent += "  <input type='radio' id='word' name='formato'>";
    sContent += "  <label>WORD</label>";
    sContent += "  </div>";
    sContent += "</fieldset>";
    sContent += "<center>";
    sContent += "<input type='button' id='btnGerar' value='Confirmar' onclick='js_gerarRelatorio()'>";
    sContent += "</center>";
    sContent += "</div>";
    windowFormatoRelatorio.setContent(sContent);
    windowFormatoRelatorio.show();

    document.getElementById('windowwindowFormatoRelatorio_btnclose').onclick = destroyWindow;

  }

  function destroyWindow() {
    windowFormatoRelatorio.destroy();
  }


  function js_gerarRelatorio() {
    if (document.getElementById('pdf').checked == true) {
      jan = window.open('lic2_credenciadospdf002.php?l20_codigo=' + document.form1.l20_codigo.value, '', 'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ');
      jan.moveTo(0, 0);
    }
    if (document.getElementById('word').checked == true) {
      jan = window.open('lic2_credenciadosword002.php?l20_codigo=' + document.form1.l20_codigo.value, '', 'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ');
      jan.moveTo(0, 0);
    }

  }
</script>