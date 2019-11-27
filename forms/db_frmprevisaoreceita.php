<div class="registro_empinscritosemrp">
    <?php

    $clorcfontes = new cl_orcfontes();

    $sCampos = 'o57_fonte, o57_finali, o70_codigo, o70_valor, o70_codrec, COALESCE(SUM(c229_vlprevisto),0) c229_vlprevisto';
    $sWhere = "substr(o57_fonte,1,7) in ('41321001', '41321005',' 4171808','4171810','4172810','4173810','4174801','4174810','4176801','4176810','4241808','4241810','4242810','4243810','4244801', '4244810') and o70_codigo in ('122', '123', '124', '142') and o70_anousu = ".db_getsession('DB_anousu')." and o70_instit = ".db_getsession("DB_instit")." group by 1, 2, 3, 4, 5";
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
                        $sSubEstrut = substr($oRec->o57_fonte, 0, 10);
                        $sRec = $sSubEstrut. ' - '.$oRec->o57_finali. ' Fonte - '.$oRec->o70_codigo;
                        db_ancora("<b>{$sRec}</b>", "js_associacaoConvenioPrevisaoReceita({$oRec->o70_codrec}, {$sSubEstrut}, '{$oRec->o57_finali}', {$oRec->o70_valor}, {$index}, {$oRec->o70_codigo});", 1);
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

    function js_associacaoConvenioPrevisaoReceita(iCodRec, sEstRec, sReceita, fValorPrev, index, iFonte){
        js_OpenJanelaIframe('top.corpo','db_iframe_conconvprevrec','func_previsaoreceita.php?c229_fonte='+iCodRec+'&sReceita='+sEstRec+' - '+sReceita+'&fValorPrev='+fValorPrev+'&index='+index+'&iFonte='+iFonte,'Associa Convênio',true);
    }

</script>