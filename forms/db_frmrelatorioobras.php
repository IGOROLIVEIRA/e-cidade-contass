<form name="form1" method="post" action="">
  <fieldset>
    <legend>Obras</legend>
    <table border="0">
      <tr>
        <td>
          <?php
          db_ancora('Cód. obra: ', "js_pesquisa_obra(true)", 1);
          echo "<span style='margin-left:120px;'>";
          db_input('obr02_seqobra', 11, $Iobr02_seqobra, true, 'text', 1, "onchange='js_pesquisa_obra(false)'");
          db_input('l20_objeto', 40, $l20_objeto, true, 'text', 3, "");
          echo "</span>";
          ?>
        </td>
      </tr>
    </table>
  </fieldset>
  <center>
    <input style="margin-top: 10px;" name="imprimir" type="button" id="imprimir" value="Imprimir" onclick="js_gerarRelatorio();">
  </center>
</form>
<script>
  function js_gerarRelatorio() {
    jan = window.open('obr1_relatorioobras002.php?obr02_seqobra=' + document.form1.obr02_seqobra.value,
      'width=' + (screen.availWidth - 5) + ', height=' + (screen.availHeight - 40) + ', scrollbars=1, location=0');
    jan.moveTo(0, 0);

  }
  /**
   * funcao para retornar obras
   */
  function js_pesquisa_obra(mostra) {
    if (mostra == true) {

      js_OpenJanelaIframe('top.corpo',
        'db_iframe_licobrasituacao',
        'func_licobras.php?pesquisa=true&funcao_js=parent.js_preencheObra|obr01_sequencial|l20_objeto',
        'Pesquisa Obras', true);
    } else {

      if (document.form1.obr02_seqobra.value != '') {

        js_OpenJanelaIframe('top.corpo',
          'db_iframe_licobrasituacao',
          'func_licobras.php?rotinarelatorio=true&pesquisa=true&pesquisa_chave=' +
          document.form1.obr02_seqobra.value + '&funcao_js=parent.js_preencheObra2',
          'Pesquisa', false);
      } else {
        document.form1.l20_objeto.value = "";
      }
    }
  }
  /**
   * funcao para preencher licitacao  da ancora
   */
  function js_preencheObra(codigo, objeto) {
    document.form1.obr02_seqobra.value = codigo;
    document.form1.l20_objeto.value = objeto;
    db_iframe_licobrasituacao.hide();
  }

  function js_preencheObra2(codigo, objeto, param3, param4, erro) {

    document.form1.obr02_seqobra.value = codigo;
    document.form1.l20_objeto.value = objeto;

    if (erro == true) {
      alert('Nenhuma obra encontrada.');
      document.form1.obr02_seqobra.value = "";
      document.form1.l20_objeto.value = "";
    }

  }
</script>