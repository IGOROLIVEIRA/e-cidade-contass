<?php
//MODULO: licitacao

use ECidade\V3\Extension\Document;

db_postmemory($HTTP_POST_VARS);
$cllicatareg->rotulo->label();
$cllicatareg = new cl_licatareg;
?>
<form name="form1" method="post" action="">
  <center>
    <table align=center style="margin-top:25px;">

      <tr>
        <td>
          <fieldset style="margin-top: 30px;">
            <legend>Ata de Registro de Preço</legend>
            <table border="0">
              <tr>
                <td nowrap title="<?= @$Tl221_sequencial ?>">
                  <input name="oid" type="hidden" value="<?= @$oid ?>">
                  <?= @$Ll221_sequencial ?>
                </td>
                <td>
                  <?php
                  db_input('l221_sequencial', 10, $Il221_sequencial, true, 'text', 3, "")
                  ?>
                </td>
              </tr>
              <tr>
                <td nowrap title="<?= @$Tl221_licitacao ?>">
                  <?php
                  if (isset($l221_sequencial) && $l221_sequencial != "" && $l221_sequencial != null) {
                    echo "<b>Licitação:</b>";
                  } else {
                    db_ancora("Licitação: ", "js_pesquisarLicitacao(true);", $iOpcaoLicitacao);
                  }
                  ?>
                </td>
                <td>
                  <?php
                  if (isset($l221_sequencial) && $l221_sequencial != "" && $l221_sequencial != null) {
                    db_input('l221_licitacao', 10, $Il221_licitacao, true, 'text', 3, " onChange='js_pesquisarLicitacao(false);'");
                  } else {
                    db_input('l221_licitacao', 10, $Il221_licitacao, true, 'text', $iOpcaoLicitacao, " onChange='js_pesquisarLicitacao(false);'");
                  }
                  ?>
                </td>
              </tr>
              <tr>
                <td nowrap title="<?= @$Tl221_numata ?>">
                  <?php echo "<b>Número da Ata:</b>" ?>
                </td>
                <td>
                  <?php
                  db_input('l221_numata', 10, $Il221_numata, true, 'text', $db_opcao, "")
                  ?>
                </td>
              </tr>
              <tr>
                <td nowrap title="<?= @$Tl221_exercicio ?>">
                  <?php echo "<b>Exercí­cio da Ata:</b>" ?>
                </td>
                <td>
                  <?php
                  db_input('l221_exercicio', 4, $Il221_exercicio, true, 'text', 3, "")
                  ?>
                </td>
              </tr>
              <tr>
                <td nowrap title="<?= @$Tl221_fornecedor ?>">
                  <?= @$Ll221_fornecedor ?>
                </td>
                <td>
                  <?php

                  if (isset($l221_sequencial) && $l221_sequencial != "" && $l221_sequencial != null) {


                    $result_forn = $cllicatareg->sql_record("select z01_numcgm, z01_nome 
                                        from  licatareg 
                                        inner join cgm on
                                        cgm.z01_numcgm = licatareg.l221_fornecedor
                                        where 
                                        l221_sequencial =" . $l221_sequencial);
                    $oForn = db_utils::fieldsMemory($result_forn, $iIndiceTipo);
                    $tipo[$oForn->z01_numcgm] = $oForn->z01_nome;
                    db_select("l221_fornecedor", $tipo, true, $db_opcao, "style='width: 100%;'");
                  } else {
                    $tipo = array();
                    $tipo[0] = "Selecione";
                    $result_forn = $cllicatareg->sql_record(" 	select
                                        distinct (
                                        select
                                          z01_nome
                                        from
                                          liclicita
                                        inner join liclicitem lli on
                                          lli.l21_codliclicita = liclicita.l20_codigo
                                        inner join pcorcamitemlic on
                                          pcorcamitemlic.pc26_liclicitem = lli.l21_codigo
                                        inner join pcorcamval on
                                          pcorcamval.pc23_orcamitem = pcorcamitemlic.pc26_orcamitem
                                        inner join pcorcamjulg on
                                          pcorcamval.pc23_orcamitem = pcorcamjulg.pc24_orcamitem
                                          and pcorcamval.pc23_orcamforne = pcorcamjulg.pc24_orcamforne
                                          and pcorcamjulg.pc24_pontuacao = 1
                                        inner join pcorcamforne on
                                          pcorcamforne.pc21_orcamforne = pcorcamjulg.pc24_orcamforne
                                        inner join cgm on
                                          cgm.z01_numcgm = pcorcamforne.pc21_numcgm
                                        where
                                          lli.l21_codigo = liclicitem.l21_codigo) as z01_nome,
                                          (
                                        select
                                          z01_numcgm
                                        from
                                          liclicita
                                        inner join liclicitem lli on
                                          lli.l21_codliclicita = liclicita.l20_codigo
                                        inner join pcorcamitemlic on
                                          pcorcamitemlic.pc26_liclicitem = lli.l21_codigo
                                        inner join pcorcamval on
                                          pcorcamval.pc23_orcamitem = pcorcamitemlic.pc26_orcamitem
                                        inner join pcorcamjulg on
                                          pcorcamval.pc23_orcamitem = pcorcamjulg.pc24_orcamitem
                                          and pcorcamval.pc23_orcamforne = pcorcamjulg.pc24_orcamforne
                                          and pcorcamjulg.pc24_pontuacao = 1
                                        inner join pcorcamforne on
                                          pcorcamforne.pc21_orcamforne = pcorcamjulg.pc24_orcamforne
                                        inner join cgm on
                                          cgm.z01_numcgm = pcorcamforne.pc21_numcgm
                                        where
                                          lli.l21_codigo = liclicitem.l21_codigo) as z01_numcgm
                                        from liclicitem 
                                        inner join pcprocitem on liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem 
                                        left join pcorcamitemproc on pc31_pcprocitem = pc81_codprocitem 
                                        inner join pcproc on pcproc.pc80_codproc = pcprocitem.pc81_codproc 
                                        left join itemprecoreferencia on si02_itemproccompra = pcorcamitemproc.pc31_orcamitem 
                                        inner join solicitem on solicitem.pc11_codigo = pcprocitem.pc81_solicitem 
                                        inner join solicita on solicita.pc10_numero = solicitem.pc11_numero 
                                        inner join db_depart on db_depart.coddepto = solicita.pc10_depto 
                                        left join liclicita on liclicita.l20_codigo = liclicitem.l21_codliclicita 
                                        left join licsituacao on l08_sequencial = l20_licsituacao 
                                        left join cflicita on cflicita.l03_codigo = liclicita.l20_codtipocom 
                                        left join pctipocompra on pctipocompra.pc50_codcom = cflicita.l03_codcom 
                                        left join solicitemunid on solicitemunid.pc17_codigo = solicitem.pc11_codigo 
                                        left join matunid on matunid.m61_codmatunid = solicitemunid.pc17_unid 
                                        left join pcorcamitemlic on l21_codigo = pc26_liclicitem 
                                        left join pcorcamval on pc26_orcamitem = pc23_orcamitem 
                                        left join pcorcamjulg on pcorcamval.pc23_orcamitem = pcorcamjulg.pc24_orcamitem and pcorcamval.pc23_orcamforne = pcorcamjulg.pc24_orcamforne 
                                        left join pcorcamforne on pc21_orcamforne = pc23_orcamforne 
                                        left join cgm on pc21_numcgm = z01_numcgm 
                                        left join db_usuarios on pcproc.pc80_usuario = db_usuarios.id_usuario 
                                        left join solicitempcmater on solicitempcmater.pc16_solicitem = solicitem.pc11_codigo 
                                        left join pcmater on pcmater.pc01_codmater = solicitempcmater.pc16_codmater 
                                        left join pcsubgrupo on pcsubgrupo.pc04_codsubgrupo = pcmater.pc01_codsubgrupo 
                                        left join pctipo on pctipo.pc05_codtipo = pcsubgrupo.pc04_codtipo 
                                        left join solicitemele on solicitemele.pc18_solicitem = solicitem.pc11_codigo 
                                        left join orcelemento on orcelemento.o56_codele = solicitemele.pc18_codele and orcelemento.o56_anousu = " . db_getsession("DB_anousu") . " 
                                        left join empautitempcprocitem on empautitempcprocitem.e73_pcprocitem = pcprocitem.pc81_codprocitem 
                                        left join empautitem on empautitem.e55_autori = empautitempcprocitem.e73_autori and empautitem.e55_sequen = empautitempcprocitem.e73_sequen 
                                        left join empautoriza on empautoriza.e54_autori = empautitem.e55_autori 
                                        left join empempaut on empempaut.e61_autori = empautitem.e55_autori 
                                        left join empempenho on empempenho.e60_numemp = empempaut.e61_numemp 
                                        left join pcdotac on solicitem.pc11_codigo = pcdotac.pc13_codigo 
                                        where l21_codliclicita = " . $l221_licitacao . " 
                                        order by z01_nome ");


                    for ($iIndiceTipo = 0; $iIndiceTipo < $cllicatareg->numrows; $iIndiceTipo++) {

                      $oForn = db_utils::fieldsMemory($result_forn, $iIndiceTipo);
                      if ($oForn->z01_numcgm != null && $oForn->z01_nome != null) {
                        $tipo[$oForn->z01_numcgm] = $oForn->z01_nome;
                      }
                    }


                    db_select("l221_fornecedor", $tipo, true, $db_opcao, "style='width: 100%;'");
                  }

                  ?>
                </td>
              </tr>
              <tr>
                <td nowrap title="<?= @$Tl221_dataini ?>">
                  <?php echo "<b>Vigência:</b>" ?>
                </td>
                <td>
                  <?php
                  db_inputdata('l221_dataini', @$l221_dataini_dia, @$l221_dataini_mes, @$l221_dataini_ano, true, 'text', $db_opcao, "");
                  echo "<b>Á</b>";
                  db_inputdata('l221_datafinal', @$l221_datafinal_dia, @$l221_datafinal_mes, @$l221_datafinal_ano, true, 'text', $db_opcao, "");
                  ?>
                </td>
              </tr>

              <tr>
                <td nowrap title="<?= @$Tl221_datapublica ?>">
                  <?php echo "<b>Data de Publicação:</b>" ?>
                </td>
                <td>
                  <?php
                  db_inputdata('l221_datapublica', @$l221_datapublica_dia, @$l221_datapublica_mes, @$l221_datapublica_ano, true, 'text', $db_opcao, "")
                  ?>
                </td>
              </tr>
              <tr>
                <td nowrap title="<?= @$Tl221_veiculopublica ?>">
                  <?php echo "<b>Veí­culo de Publicação:</b>" ?>
                </td>
                <td>
                  <?php
                  db_input('l221_veiculopublica', 82, 3, true, 'text', $db_opcao, "")
                  ?>
                </td>
              </tr>
            </table>
            <fieldset>
              <legend>Objeto</legend>
              <table>
                <tr>

                  <td>
                    <?php

                    db_textarea('l20_objeto', 0, 100, $Il20_objeto, true, 'text', $db_opcao, "onkeyup='limitaTextareaobj(this);' onkeypress='doNothing()';");

                    ?>
                  </td>
                </tr>
              </table>
            </fieldset>

          </fieldset>

        </td>
      </tr>
    </table>
  </center>
  <input name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?>>
  <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
</form>
<script>
  document.form1.l221_exercicio.value = <?= db_getsession('DB_anousu') ?>;

  function js_pesquisa() {
    js_OpenJanelaIframe('', 'db_iframe_licatareg', 'func_licatareg.php?funcao_js=parent.js_preenchepesquisa|0', 'Pesquisa', true);
  }

  function js_preenchepesquisa(chave) {
    db_iframe_licatareg.hide();
    <?php
    if ($db_opcao != 1) {
      echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave";
    }
    ?>
  }

  function js_pesquisarLicitacao(lMostra) {

    var sArquivo = 'func_liclicita.php?situacao=10&tiponatu=2&funcao_js=parent.';

    if (lMostra == true) {
      sArquivo += 'js_mostraLicitacao|l20_codigo|l20_objeto';
    } else {

      var iNumeroLicitacao = document.getElementById('l221_licitacao').value;



      sArquivo += 'js_mostraLicitacaoHidden&pesquisa_chave=' + iNumeroLicitacao + '&sCampoRetorno=l20_codigo';

    }

    js_OpenJanelaIframe('', 'db_iframe_proc', sArquivo, 'Pesquisa de Licitação', lMostra);
  }

  function js_mostraLicitacao(iCodigoLicitacao, descricao) {

    location.href = 'lic1_licatareg001.php?l221_licitacao=' + iCodigoLicitacao + '&l20_objeto=' + descricao;

    /*document.form1.l20_codigo.value = iCodigoLicitacao;
    document.form1.l20_objeto.value = descricao;
    document.form1.l221_exercicio.value = <?= db_getsession('DB_anousu') ?>*/

    db_iframe_proc.hide();


  }

  function js_mostraLicitacaoHidden(descricao, lErro) {

    /**
     * Nao encontrou Licitacao
     */
    if (!lErro) {
      location.href = 'lic1_licatareg001.php?l221_licitacao=' + document.getElementById('l221_licitacao').value + '&l20_objeto=' + descricao;
    } else {
      alert("Licitação não permitida!");
      location.href = 'lic1_licatareg001.php';
    }

  }
</script>