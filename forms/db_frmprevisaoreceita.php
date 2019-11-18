<div class="registro_empinscritosemrp">
    <?php

    $clorcfontes = new cl_orcfontes();

    $sWhere = "substr(o57_fonte,1,7) in ('41321001', '41321005',' 4171808','4171810','4172810','4173810','4174801','4174810','4176801','4176810','4241808','4241810','4242810','4243810','4244801', '4244810') and o70_codigo in ('122', '123', '124', '142') and o70_anousu = ".db_getsession('DB_anousu');
    $sql = $clorcfontes->sql_query_fonte_receita('o57_fonte, o57_finali, o70_codigo, o70_valor, o70_codrec', null, $sWhere);

    $receitas = $clorcfontes->sql_record($sql);

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
                <th class="table_header" style="width: 500px;">Receita</th>
                <th class="table_header" style="width: 100px;">Valor Previsto</th>
                <th class="table_header" style="width: 100px;">Vlr. Convênios Assinados</th>
                <th class="table_header" style="width: 100px;">Vlr. Convênios sem Assinatura</th>
            </tr>
        </table>
        <?php
        $aReceitas = db_utils::getCollectionByRecord($receitas);


        foreach ($aReceitas as $index => $oRec):

//            $iFonte = ltrim($oFot->o15_codtri,"0");
            ?>

            <table class="DBGrid">

                <td class="linhagrid" style="width: 500px">
                    <?php
                    $sRec = substr($oRec->o57_fonte, 0, 10). ' - '.$oRec->o57_finali. ' Fonte - '.$oRec->o70_codigo;
                    db_ancora("<b>{$sRec}</b>", "js_associacaoConvenioPrevisaoReceita({$oRec->o70_codrec}, '{$oRec->o57_finali}');", 1);
                    ?>
                </td>

                <td class="linhagrid">
                    <input type="text" style="width: 100px" name="aFonte[<?= $index ?>][vlr_dispCaixaBruta]" value="<?= $oRec->o70_valor ?>" onchange="js_CalculaDisponibilidade(<?= $index ?>)" id="" >
                </td>

                <td class="linhagrid">
                    <input type="text" style="width:  100px" name="aFonte[<?= $index ?>][vlr_rpExerAnteriores]" value="0" onchange="js_CalculaDisponibilidade(<?= $index ?>)" id="">
                </td>

                <td class="linhagrid">
                    <input type="text" style="width: 100px" name="aFonte[<?= $index ?>][vlr_restArecolher]" value="0" onchange="js_CalculaDisponibilidade(<?= $index ?>)" id="">
                </td>

            </table>

        <?php endforeach; ?>
        <center>
            <input type="submit" value="Salvar" id="btmSalvar" name="">
        </center>
    </form>

</div>
<script>
    carregarvalores();

    function js_associacaoConvenioPrevisaoReceita(iCodRec, sReceita){
        js_OpenJanelaIframe('top.corpo','db_iframe_conconvprevrec','func_previsaoreceita.php?c229_fonte='+iCodRec+'&sReceita='+sReceita+'&funcao_js=parent.js_preencheprevisaoreceita|valor','Associa Convênio',true);
    }

    /**
     * função para carregar valores na tela
     */

    function carregarvalores() {
        buscarvalores({
            exec: 'getValores',
            // fonte: fonte
        }, js_carregarValores);
    }

    function js_carregarValores(oRetorno){
        var valores = JSON.parse(oRetorno.responseText.urlDecode());

        valores.fonte.forEach(function (fonte, b) {

            document.form1['aFonte[' + fonte.c224_fonte + '][vlr_dispCaixaBruta]'].value = fonte.c224_vlrcaixabruta;
            document.form1['aFonte[' + fonte.c224_fonte + '][vlr_rpExerAnteriores]'].value = fonte.c224_rpexercicioanterior;
            document.form1['aFonte[' + fonte.c224_fonte + '][vlr_restArecolher]'].value = fonte.c224_vlrrestoarecolher;
            document.form1['aFonte[' + fonte.c224_fonte + '][vlr_restRegAtivoFinan]'].value = fonte.c224_vlrrestoregativofinanceiro;
            document.form1['aFonte[' + fonte.c224_fonte + '][vlr_DispCaixa]'].value = fonte.c224_vlrdisponibilidadecaixa;

        });
    }

    function buscarvalores(params, onComplete) {
        js_divCarregando('Carregando Valores', 'div_aguarde');
        var request = new Ajax.Request('cadastrodespesainscritarp.RPC.php', {
            method:'post',
            parameters:'json=' + JSON.stringify(params),
            onComplete: function(res) {
                js_removeObj('div_aguarde');
                onComplete(res);
            }
        });
    }

    /**
     * função para carregar valores do SICOM
     */

    function carregarSicom() {
        buscarSicom({
            exec: 'getSicom',
            // fonte: fonte
        }, Atualizar);
    }

    function Atualizar(oRetorno){
        var valoresSicom = JSON.parse(oRetorno.responseText.urlDecode());

        valoresSicom.oDados.forEach(function (dadosfonte, b) {
            Object.keys(dadosfonte).forEach(function (fonte, key) {
                if(dadosfonte[fonte].vlrcaixabruta == undefined){
                    document.form1['aFonte[' + fonte + '][vlr_dispCaixaBruta]'].value = 0;
                }else{
                    document.form1['aFonte[' + fonte + '][vlr_dispCaixaBruta]'].value = dadosfonte[fonte].vlrcaixabruta;
                }

                if(dadosfonte[fonte].VlrroexercicioAnteriores == undefined){
                    document.form1['aFonte[' + fonte + '][vlr_rpExerAnteriores]'].value = 0;
                }else{
                    document.form1['aFonte[' + fonte + '][vlr_rpExerAnteriores]'].value = dadosfonte[fonte].VlrroexercicioAnteriores;
                }

                if(dadosfonte[fonte].vlrrestorecolher == undefined){
                    document.form1['aFonte[' + fonte + '][vlr_restArecolher]'].value = 0;
                }else{
                    document.form1['aFonte[' + fonte + '][vlr_restArecolher]'].value = dadosfonte[fonte].vlrrestorecolher;
                }

                if(dadosfonte[fonte].vlrAtivoFian == undefined){
                    document.form1['aFonte[' + fonte + '][vlr_restRegAtivoFinan]'].value = 0;
                }else{
                    document.form1['aFonte[' + fonte + '][vlr_restRegAtivoFinan]'].value = dadosfonte[fonte].vlrAtivoFian;
                }

                if(dadosfonte[fonte].vlrDisponibilidade < 0){
                    document.form1['aFonte[' + fonte + '][vlr_DispCaixa]'].value = 0;
                }else{
                    document.form1['aFonte[' + fonte + '][vlr_DispCaixa]'].value = dadosfonte[fonte].vlrDisponibilidade;
                }

            });
        });
    }

    function buscarSicom(params, onComplete) {
        js_divCarregando('Carregando Valores', 'div_aguarde');
        var request = new Ajax.Request('cadastrodespesainscritarp.RPC.php', {
            method:'post',
            parameters:'json=' + JSON.stringify(params),
            onComplete: function(res) {
                js_removeObj('div_aguarde');
                onComplete(res);
            }
        });
    }

    /**
     * Calculo disponibilidade de caixa quando digitar nos inputs da tela
     *
     */

    function js_CalculaDisponibilidade(fonte) {

        let vlrDisCaixaBruta       = document.form1['aFonte[' + fonte + '][vlr_dispCaixaBruta]'].value;
        let vlrRpExercicioanterior = document.form1['aFonte[' + fonte + '][vlr_rpExerAnteriores]'].value;
        let vlrRestoRecolher       = document.form1['aFonte[' + fonte + '][vlr_restArecolher]'].value;
        let vlrRegAtivoFian        = document.form1['aFonte[' + fonte + '][vlr_restRegAtivoFinan]'].value;
        let ResultVlrDisponibilidade = Number(vlrDisCaixaBruta) - Number(vlrRpExercicioanterior) - Number(vlrRestoRecolher) + Number(vlrRegAtivoFian);

        if(ResultVlrDisponibilidade < 0){
            document.form1['aFonte[' + fonte + '][vlr_DispCaixa]'].value = 0
        }else{
            document.form1['aFonte[' + fonte + '][vlr_DispCaixa]'].value = ResultVlrDisponibilidade
        }

    }

</script>