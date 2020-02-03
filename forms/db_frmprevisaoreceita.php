<div class="registro_empinscritosemrp">
    <?php

    $clorcfontes = new cl_orcfontes();

    $sCampos = 'o57_fonte, o57_descr, o70_codigo, o70_valor, o70_codrec, COALESCE(SUM(c229_vlprevisto),0) c229_vlprevisto';
    $sWhere = "o70_codigo in ('122', '123', '124', '142') and o70_anousu = ".db_getsession('DB_anousu')." and o70_instit = ".db_getsession("DB_instit")." and o70_valor > 0 group by 1, 2, 3, 4, 5";
    $sSql = $clorcfontes->sql_query_fonte_previsao_receita($sCampos, null, $sWhere);

    $result = db_query($sSql);

    ?>
    <form name="form1" method="post" action="" style="" onsubmit="return validaForm(this);">
        <table>
            <tr>
                <td>
                    <center><strong>Previsão das Receitas de Convênio</strong></center>
                </td>
            </tr>
            <tr>
                <td></td>
            </tr>
        </table>
        <table>
            <tr>
                <th class="table_header" style="width: 750px;">Receita</th>
                <th class="table_header" style="width: 100px;">Valor Previsto</th>
                <th class="table_header" style="width: 100px;">Vlr. Convênios Assinados</th>
                <th class="table_header" style="width: 100px;">Vlr. Convênios sem Assinatura</th>
            </tr>
        </table>
        <?php

        if(pg_num_rows($result) == 0) {

        ?>
            <br>
            <table>
                <tr>
                    <td>
                        <center><strong>Nenhuma receita encontrada.</strong></center>
                    </td>
                </tr>
                <tr>
                    <td></td>
                </tr>
            </table>

        <?php
        } else {

            $aReceitas = db_utils::getCollectionByRecord($result);

            foreach ($aReceitas as $index => $oRec):

                ?>

                <table class="DBGrid">

                    <td class="linhagrid" style="width: 750px; text-align: left;">
                        <?php
                        $sSubEstrut = substr($oRec->o57_fonte, 0, 14);
                        $sRec = $sSubEstrut. ' - '.$oRec->o57_descr. ' - Fonte - '.$oRec->o70_codigo;
                        db_ancora("<b>{$sRec}</b>", "js_associacaoConvenioPrevisaoReceita({$oRec->o70_codrec}, '{$sRec}', {$oRec->o70_valor}, {$index}, {$oRec->o70_codigo});", 1);
                        ?>
                    </td>

                    <td class="linhagrid">
                        <input type="text" style="width: 100px; background-color:#DEB887;" readonly="readonly" name="aFonte[<?= $index ?>][vlr_previsto]" value="<?= number_format($oRec->o70_valor, 2, ',', '.') ?>" id="" >
                    </td>

                    <td class="linhagrid">
                        <input type="text" style="width:  100px; background-color:#DEB887;" readonly="readonly" name="aFonte[<?= $index ?>][c229_vlprevisto]" value="<?= number_format($oRec->c229_vlprevisto, 2, ',', '.') ?>" id="">
                    </td>

                    <td class="linhagrid">
                        <input type="text" style="width: 100px; ; background-color:#DEB887;" readonly="readonly" name="aFonte[<?= $index ?>][vlr_conveniosSemAssinatura]" value="<?= number_format(($oRec->o70_valor - $oRec->c229_vlprevisto), 2, ',', '.') ?>" id="">
                    </td>

                </table>

            <?php endforeach;
        } ?>
    </form>

</div>
<script>

    function js_associacaoConvenioPrevisaoReceita(iCodRec, sReceita, fValorPrev, index, iFonte){
        console.log(sReceita);
        js_OpenJanelaIframe('top.corpo','db_iframe_conconvprevrec','func_previsaoreceita.php?c229_fonte='+iCodRec+'&sReceita='+sReceita+'&fValorPrev='+fValorPrev+'&index='+index+'&iFonte='+iFonte,'Associação de Convênio à Previsão da Receita',true);
    }

</script>