<?php
//MODULO: licitacao
$cllicataregitem->rotulo->label();
?>
<form name="form1" method="post" action="">
  <center>

    &nbsp;
    &nbsp;
    <table border='1' cellspacing="4" cellpadding="4" style='background-color:#EEEFF2;' width='90%' bgcolor="white" id="dadosDaOrdem">
      <tr class=''>

        <td class='table_header' align='center' style='border-style: outset;'><b>Ordem</b></td>
        <td class='table_header' align='center' style='border-style: outset;'><b>Item</b></td>
        <td class='table_header' align='center' style='border-style: outset;'><b>Descrição Item</b></td>
        <td class='table_header' align='center' style='border-style: outset;'><b>Unidade</b></td>
        <td class='table_header' align='center' style='border-style: outset;'><b>Quantidade</b></td>
        <td class='table_header' align='center' style='border-style: outset;'><b>Vlr Unitario</b></td>
        <td class='table_header' align='center' style='border-style: outset;'><b>Vlr Total</b></td>

      </tr>
      <tbody id='dados' style='height:150px;width:95%;overflow:scroll;overflow-x:hidden;background-color:white'>
        <?php
        if ((isset($l222_licatareg) && $l222_licatareg != "" && isset($licitacao) && $licitacao != "" && isset($fornecedor) && $fornecedor != "")) {


          $sSQLemp  = "SELECT DISTINCT
                    l21_ordem,
                    pc01_codmater,
                    pc01_descrmater,
                    m61_descr,
                    pc23_quant,
                    pc23_vlrun,
                    pc23_percentualdesconto,
                    pc21_numcgm
                    FROM liclicitem
                    INNER JOIN pcprocitem ON liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem
                    INNER JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
                    INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
                    INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
                    LEFT JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
                    LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
                    LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
                    LEFT JOIN pcorcamitemlic ON l21_codigo = pc26_liclicitem
                    LEFT JOIN pcorcamval ON pc26_orcamitem = pc23_orcamitem
                    LEFT JOIN pcorcamjulg ON pcorcamval.pc23_orcamitem = pcorcamjulg.pc24_orcamitem
                    AND pcorcamval.pc23_orcamforne = pcorcamjulg.pc24_orcamforne
                    LEFT JOIN pcorcamforne ON pc21_orcamforne = pc23_orcamforne
                    LEFT JOIN cgm ON pc21_numcgm = z01_numcgm
                    LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
                    LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
                    WHERE l21_codliclicita = $licitacao and pc24_pontuacao=1 and pc21_numcgm = $fornecedor
                    ORDER BY l21_ordem";
          $result   = db_query($sSQLemp);

          $numrows  = pg_num_rows($result);

          $sClassName = 'normal';
          $sChecked   = '';
          //      if ($numrows == 1) {
          //
          //        $sChecked   = " checked ";
          //        $sClassName = " marcado ";
          //      }
          $SomaTotal = 0;
          for ($i = 0; $i < $numrows; $i++) {

            $disabled    = null;
            $iOpcao      = 1;
            $sClassName  = "normal";
            db_fieldsmemory($result, $i);


            echo "<tr>";


            // Sequencia
            echo "  <td class='linhagrid' id='sequen{$l21_ordem}' align='center'  style='border-style: outset;height:5px;'>$l21_ordem</td>";

            // Número do empenho
            echo "  <td class='linhagrid' align='center'  style='border-style: outset;height5px;'>$pc01_codmater</td>";

            // SequÃªncia do empenho
            echo "  <td class='linhagrid' align='center'  style='border-style: outset;height5px;'>$pc01_descrmater</td>";

            // CÃ³digo do item
            echo "  <td class='linhagrid' align='center'  style='border-style: outset;height5px;'>$m61_descr</td>";

            // Item
            echo "  <td class='linhagrid' align='center'  style='border-style: outset;height5px;'>$pc23_quant</td>";

            // Unidade
            echo "  <td class='linhagrid' align='center'  style='border-style: outset;height5px;'>$pc23_vlrun</td>";

            // Descrição
            $vlrtotal = $pc23_quant * $pc23_vlrun;
            $SomaTotal = $SomaTotal + $vlrtotal;
            echo "  <td class='linhagrid' align='center'  style='border-style: outset;height5px;'>" . number_format($vlrtotal, 2, ',', '.') . "</td>";
          }
        }



        echo " <tr style='height: 35; background-color:#EEEFF2; border-top:1px solid #444444;'>";

        echo " <td colspan='7' align='right'><b>Total dos Itens: </b><span id='valor_total'><b>" . number_format($SomaTotal, 2, ',', '.') . "</b></span></td>";
        ?>
        </tr>

      </tbody>
    </table>
  </center>

  <input name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? "Salvar" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?>>



</form>
<script>
  function js_pesquisa() {
    js_OpenJanelaIframe('top.corpo', 'db_iframe_licataregitem', 'func_licataregitem.php?funcao_js=parent.js_preenchepesquisa|0', 'Pesquisa', true);
  }

  function js_preenchepesquisa(chave) {
    db_iframe_licataregitem.hide();
    <?php
    if ($db_opcao != 1) {
      echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave";
    }
    ?>
  }
</script>