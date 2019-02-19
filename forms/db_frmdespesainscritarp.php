
<div class="registro_empinscritosemrp">
    <?php

    $arrayEmpenhos = array();
    $arrayFontes = array();
    $anousu = db_getsession("DB_anousu");
    $perini = $anousu."-01-01";
    $perfin = $anousu."-12-31";

    if(!isset($fonte)){
        $fonte = 1;
    }

    if(isset($fonte) && $fonte != 1){
        $where = "AND o15_codtri::INT = $fonte";
    }

    $sql = "SELECT * FROM
    (SELECT fonte,
            empenho,
            credor,
            round(sum(e60_vlremp - e60_vlranu - e60_vlrliq),2) AS vlr_n_lqd,
            round(sum(e60_vlrliq - e60_vlrpag),2) AS vlr_lqd,
            z01_numcgm,
            e60_anousu
     FROM
         (SELECT o15_codtri AS fonte,
                 e60_codemp AS empenho,
                 z01_numcgm,
                 z01_numcgm||'-'||z01_nome AS credor,
                 round(sum((CASE
                            WHEN c53_tipo = 10 THEN c70_valor
                            ELSE 0
                        END)),2) AS e60_vlremp,
                 round(sum((CASE
                            WHEN c53_tipo = 11 THEN c70_valor
                            ELSE 0
                        END)),2) AS e60_vlranu,
                 round(sum((CASE
                                WHEN c53_tipo = 20 THEN c70_valor
                                ELSE 0
                            END) - (CASE
                                        WHEN c53_tipo = 21 THEN c70_valor
                                        ELSE 0
                                    END)),2) AS e60_vlrliq,
                 round(sum((CASE
                                WHEN c53_tipo = 30 THEN c70_valor
                                ELSE 0
                            END) - (CASE
                                        WHEN c53_tipo = 31 THEN c70_valor
                                        ELSE 0
                                    END)),2) AS e60_vlrpag,
                 e60_anousu
          FROM empempenho
          JOIN conlancamemp ON c75_numemp = e60_numemp
          JOIN conlancamdoc ON c71_codlan = c75_codlan
          JOIN conlancam ON c70_codlan = c75_codlan
          JOIN conhistdoc ON c53_coddoc = c71_coddoc
          JOIN orcdotacao ON (e60_anousu, e60_coddot) = (o58_anousu, o58_coddot)
          JOIN orctiporec ON o15_codigo = o58_codigo
          JOIN cgm ON (e60_numcgm) = (z01_numcgm)
          WHERE e60_instit = ".db_getsession("DB_instit")." and e60_anousu = $anousu
              AND c75_data BETWEEN '$perini' AND '$perfin'
              $where
          GROUP BY 1,2,3,4,c53_tipo,c70_valor,e60_anousu
          ORDER BY 2, 3) AS x
     GROUP BY 1, 2, 3,z01_numcgm, e60_anousu
     ORDER BY 1, 2, 3) AS total
     WHERE (vlr_n_lqd > 0 OR vlr_lqd > 0)";
    //                die($sql);exit;
    $rsEmpenhos = db_query($sql);

    ?>
    <form name="form1" method="post" action="" style="" onsubmit="return validaForm(this);">
        <table>
            <tr>
                <td>
                    <center><strong>Despesas do Exercicio Inscritas em Resto a Pagar</strong></center>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    $clorctiporec = new cl_orctiporec();
                    $recursos = $clorctiporec->sql_record($clorctiporec->sql_query_file(null,"o15_codtri,o15_descr",null,"o15_codtri != ''"));
                    db_selectrecord("o15_codtri",$recursos,true,$db_opcao,"","","",true,"js_filtrafonte(this.value)");
                    ?>
                </td>
            </tr>
        </table>
        <?php
        $aEmpenhos = db_utils::getCollectionByRecord($rsEmpenhos);
        $iTotalFontes = 0;
        $arrayEmpenhos = 0;
        $oTotalrpfonte = array();

        foreach ($aEmpenhos as $chave => $emp){
            $iFonte = $emp->fonte;

            if(!$oTotalrpfonte[$iFonte]){
                $oTotalrpfonte[$iFonte]->saldo += $emp->vlr_n_lqd + $emp->vlr_lqd;
            }else{
                $oTotalrpfonte[$iFonte]->saldo += $emp->vlr_n_lqd + $emp->vlr_lqd;
            }
        }

        foreach ($aEmpenhos as $key => $oEmp):
            $iFonte = $oEmp->fonte;
            $iEmpenho = $oEmp->empenho;

            if (!isset($arrayFontes[$iFonte])) {
                ?>
                <center>
                    <input type="submit" value="Salvar">
                </center>
                <br>
                <table>
                    <tr class="DBGrid">
                        <td class="table_header" style="width: 30px;"> Fonte </td>
                        <td class="table_header" style="width: 75px;"> <?= $iFonte ?> </td>
                        <th class="table_header" style="width: 156px;" rowspan="2"> Disponibilidade Total </th>
                        <td class="table_header" style="width: 100px;">
                            <input type="text" name="aFonte[<?= $iFonte ?>][disp_total]" value="0" style="width: 100px; background: #DEB887;" readonly="true">
                        </td>
                        <th class="table_header" style="width: 110px;">Saldo Utilizado</th>
                        <td class="table_header" style="width: 100px;">
                            <input type="text" name="aFonte[<?= $iFonte ?>][vlr_utilizado]" value="0" style="width: 100px; background: #DEB887;" readonly="true">
                        </td>
                        <th class="table_header" style="width: 100px;">Saldo Disponivel</th>
                        <td class="table_header" style="width: 110px;">
                            <input type="text" name="aFonte[<?= $iFonte ?>][vlr_disponivel]" value="0" style="width: 100px; background: #DEB887;" readonly="true">
                        </td>

                        <th class="table_header" style="width: 70px;">Saldo Rp</th>
                        <td class="table_header" style="width: 70px;">
                            <input type="text" name="aFonte[<?= $iFonte ?>][vlr_totalrp]" value="<?= $oTotalrpfonte[$iFonte]->saldo?>" style="width: 95px; background: #DEB887;" readonly="true">
                        </td>
                        <th rowspan="2">
                            <input type="button" nome="" value="Aplicar Disp. T" rowspan="2" onclick="js_aplicardisptotal(<?= $iFonte ?>)">
                        </th>
                        </td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th class="table_header" style="width: 33px; cursor: pointer;" onclick="marcarTodos(<?= $iFonte ?>);">M</th>
                        <th class="table_header" style="width: 70px;">N� Empenho</th>
                        <th class="table_header" style="width: 240px;">Credor</th>
                        <th class="table_header" style="width: 100px;">Saldo n�o Liquidado</th>
                        <th class="table_header" style="width: 110px;">Saldo Liquidado</th>
                        <th class="table_header" style="width: 100px;">Valor de Disp. RPNP</th>
                        <th class="table_header" style="width: 100px;">Valor de Disp. RPP</th>
                        <th class="table_header" style="width: 100px;">Valor Sem Disp. RPNP</th>
                        <th class="table_header" style="width: 100px;">Valor Sem Disp. RPP</th>
                        <th class="table_header" style="width: 100px;">Dis. RPP e RPNP</th>
                    </tr>
                </table>
                <?
            }
            ?>

            <table class="DBGrid">

                <th class="table_header" style="width: 33px">
                    <input type="checkbox" class="marca_itens[<?= $iFonte ?>]" name="aItonsMarcados" value="<?= $iEmpenho ?>" id="<?= $iEmpenho?>">
                </th>

                <td class="linhagrid" style="width: 70px">
                    <?= $iEmpenho ?>
                    <input type="hidden" name="aEmpenho[<?= $iEmpenho ?>][empenho][<?= $iFonte ?>]" value="<?= $oEmp->empenho ?>" id="<?= $iFonte?>">
                </td>

                <td class="linhagrid left" style="width: 240px">
                    <?= str_replace('&','',$oEmp->credor) ?>
                    <input type="hidden" name="aEmpenho[<?= $iEmpenho ?>][credor][<?= $iFonte ?>]" value="<?= str_replace('&','',$oEmp->credor) ?>" id="<?= $iFonte?>">
                </td>

                <td class="linhagrid" style="width: 100px;">
                    <?= $oEmp->vlr_n_lqd ?>
                    <input type="hidden" name="aEmpenho[<?= $iEmpenho ?>][vlr_n_lqd][<?= $iFonte ?>]" value="<?= $oEmp->vlr_n_lqd ?>" id="<?= $iFonte?>">
                </td>

                <td class="linhagrid" style="width: 110px;">
                    <?= $oEmp->vlr_lqd ?>
                    <input type="hidden" name="aEmpenho[<?= $iEmpenho ?>][vlr_lqd][<?= $iFonte ?>]" value="<?= $oEmp->vlr_lqd ?>" id="<?= $iFonte?>">
                </td>

                <td class="linhagrid">
                    <input type="text" style="width: 100px" name="aEmpenho[<?= $iEmpenho ?>][vlr_dispRPNP][<?= $iFonte ?>]" value="0" onchange="adicionarEdicaoRPNP(<?= $iEmpenho ?>,<?= $iFonte?>)" id="<?= $iFonte?>">
                </td>

                <td class="linhagrid">
                    <input type="text" style="width: 100px" name="aEmpenho[<?= $iEmpenho ?>][vlr_dispRPP][<?= $iFonte ?>]" value="0" onchange="adicionarEdicaoRPP(<?= $iEmpenho ?>,<?= $iFonte?>)" id="<?= $iFonte?>">
                </td>

                <td class="linhagrid" style="width: 100px">
                    <input type="text" name="aEmpenho[<?= $iEmpenho ?>][vlr_semRPNP][<?= $iFonte ?>]" value="0" style="width: 100px; background: #DEB887;" readonly="true" id="<?= $iFonte?>">
                </td>

                <td class="linhagrid" style="width: 80px">
                    <input type="text" name="aEmpenho[<?= $iEmpenho ?>][vlr_semRPP][<?= $iFonte ?>]" value="0" style="width: 100px; background: #DEB887;" readonly="true" id="<?= $iFonte?>">
                </td>

                <td class="linhagrid" style="width: 70px; display: none">
                    <?= $iEmpenho ?>
                    <input type="hidden" name="aEmpenho[<?= $iEmpenho ?>][fonte][<?= $iFonte ?>]" value="<?= $oEmp->fonte ?>" id="<?= $iFonte?>">
                </td>

                <td class="linhagrid" style="width: 100px;">
                    <input type="button" name="aEmpenho[<?= $iEmpenho ?>][aplicar][<?= $iFonte ?>]" value="Aplicar" id="<?= $iFonte?>" onclick="js_aplicar(<?= $iFonte ?>,<?= $iEmpenho?>)">
                </td>
            </table>
            <?
            $iTotalFontes++;

            $arrayFontes[$iFonte] = $iFonte;

            ?>

        <?php endforeach; ?>
    </form>
</div>
<script>

    js_carregafonte();
    carregaritens(document.getElementById('o15_codtri').value);
    js_buscarVlrDisp(document.getElementById('o15_codtri').value);
    js_buscarDisponibilidade(document.getElementById('o15_codtri').value);

    function aItens() {
        var itensNum = document.getElementsByName("aItonsMarcados");

        return Array.prototype.map.call(itensNum, function (item) {
            return item;
        });
    }

    function aItensFonte(fonte) {
        var itensNum = document.getElementsByClassName("marca_itens["+ fonte +"]");

        return Array.prototype.map.call(itensNum, function (item) {
            return item;
        });
    }

    function marcarTodos(fonte) {

        aItensFonte(fonte).forEach(function (item) {

            var check = item.classList.contains('marcado');

            if (check) {
                item.classList.remove('marcado');
            } else {
                item.classList.add('marcado');
            }
            item.checked = !check;

        });
    }

    /**
     * fun��o para filtrar a fonte
     */

    function js_filtrafonte(value) {
        window.location.href = "con2_despesainscritarp001.php?fonte="+value;
        // carregaritens();
    }

    /**
     * fun��o para carregar a fonte
     */

    function js_carregafonte() {
        document.getElementById('o15_codtri').value = <?= $fonte?>;
        document.getElementById('o15_codtridescr').value = <?= $fonte?>;
    }

    /**
     * calcula e valida o campo vlr_dispRPNP
     */

    function adicionarEdicaoRPNP(codigo,fonte) {

        let vlr_n_lqd          = document.form1['aEmpenho[' + codigo + '][vlr_n_lqd]['+fonte+']'].value;
        let vlr_dispRPNP       = document.form1['aEmpenho[' + codigo + '][vlr_dispRPNP]['+fonte+']'].value;
        let vlr_disponivel     = document.form1['aFonte['+fonte+'][vlr_disponivel]'].value;
        let vlr_dispCaixa      = document.form1['aFonte['+fonte+'][disp_total]'].value;
        let vlr_utilizado      = document.form1['aFonte['+fonte+'][vlr_utilizado]'].value;

        if(vlr_n_lqd == 0){
            alert("N�o existe saldo n�o liquidado para este empenho!");
            // document.form1['aEmpenho[' + codigo + '][vlr_dispRPNP]['+fonte+']'].style.background = '#DEB887';
            document.form1['aEmpenho[' + codigo + '][vlr_dispRPNP]['+fonte+']'].value = 0;
            document.getElementById(codigo).checked = false;
        }else{
            if(Number(vlr_dispRPNP) > Number(vlr_n_lqd)){
                alert("Erro! Valor de Disp. RPNP maior que valor n�o liquidado");
                document.form1['aEmpenho[' + codigo + '][vlr_dispRPNP]['+fonte+']'].value = 0;
                document.getElementById(codigo).checked = false;
            }else{
                let resultvlrsemRPNP = vlr_n_lqd - vlr_dispRPNP;
                if(vlr_dispRPNP > vlr_disponivel){
                    alert("Erro! N�o existe saldo disponivel para essa opera��o.");
                    document.getElementById(codigo).checked = false;
                }else {
                    document.form1['aEmpenho[' + codigo + '][vlr_semRPNP]['+fonte+']'].value = js_roundDecimal(resultvlrsemRPNP,2);
                    document.form1['aFonte['+fonte+'][vlr_disponivel]'].value = js_roundDecimal(Number(vlr_disponivel) - Number(vlr_dispRPNP),2);
                    document.getElementById(codigo).checked = true;
                }
            }
        }
    }

    /**
     * calcula e valida o campo vlr_dispRPP
     */

    function adicionarEdicaoRPP(codigo,fonte) {
        let vlr_lqd      =  document.form1['aEmpenho[' + codigo + '][vlr_lqd]['+fonte+']'].value;
        let vlr_dispRPP  =  document.form1['aEmpenho[' + codigo + '][vlr_dispRPP]['+fonte+']'].value;
        let vlr_disponivel     = document.form1['aFonte['+fonte+'][vlr_disponivel]'].value;
        let vlr_dispCaixa      = document.form1['aFonte['+fonte+'][disp_total]'].value;
        let vlr_utilizado      = document.form1['aFonte['+fonte+'][vlr_utilizado]'].value;

        if(Number(vlr_lqd) == 0){
            alert("N�o existe saldo liquidado para este empenho!");
            // document.form1['aEmpenho[' + codigo + '][vlr_dispRPP]['+fonte+']'].style.background = '#DEB887';
            document.form1['aEmpenho[' + codigo + '][vlr_dispRPP]['+fonte+']'].value = 0;
            document.form1['aItonsMarcados['+ codigo +']'].checked = false;
        }else{
            if(Number(vlr_dispRPP) > Number(vlr_lqd)){
                alert("Erro! Valor de Disp. RPP maior que valor liquidado.");
                document.form1['aEmpenho[' + codigo + '][vlr_dispRPP]['+fonte+']'].value = 0;
                document.form1['aItonsMarcados['+ codigo +']'].checked = false;
            }else {
                let resultvlrsemRPP = vlr_lqd - vlr_dispRPP;
                if(vlr_dispRPP > vlr_disponivel) {
                    alert("Erro! N�o existe saldo disponivel para essa opera��o.");
                    document.getElementById(codigo).checked = false;
                }else {
                    document.form1['aEmpenho[' + codigo + '][vlr_semRPP][' + fonte + ']'].value = js_roundDecimal(resultvlrsemRPP,2);
                    document.form1['aFonte['+fonte+'][vlr_disponivel]'].value = js_roundDecimal(Number(vlr_disponivel) - Number(vlr_dispRPP),2);
                    document.getElementById(codigo).checked = true;
                }
            }
        }
    }

    /**
     * Retorna itens marcados
     */

    function getItensMarcados() {
        return aItens().filter(function (item) {
            return item.checked;
        });
    }

    /**
     * retorna itens marcados por fonte
     */
    function getItensMarcadosFonte(fonte) {
        let itensfonte = aItensFonte(fonte);
        return itensfonte.filter(function (item) {
            return item.checked;
        });
    }

    /**
     * Retorna todos os itens
     */
    function getItensFormulario() {
        return aItens().filter(function (item) {
            return item;
            // console.log(item);
        });
    }

    /**
     * Fun��o para salvar
     */

    function validaForm(fORM) {

        var itens = getItensMarcados();

        if (itens.length < 1) {
            alert('Selecione pelo menos um item da lista.');
            return false;
        }

        var itensEnviar = [];
        try {
            itens.forEach(function (item) {

                var fonte = item.className.substring(12);
                fonte = fonte.replace(']','');
                fonte = fonte.replace(' marcado','');

                var elemento = 'aEmpenho[' + item.value + ']';
                var elementofonte = 'aFonte[' + fonte + ']';

                var novoItem = {
                    c223_codemp:              fORM[elemento + '[empenho]['+fonte+']'].value,
                    c223_credor:              fORM[elemento + '[credor]['+fonte+']'].value,
                    c223_fonte:               fORM[elemento + '[fonte]['+fonte+']'].value,
                    c223_vlrnaoliquidado:     fORM[elemento + '[vlr_n_lqd]['+fonte+']'].value,
                    c223_vlrliquidado:        fORM[elemento + '[vlr_lqd]['+fonte+']'].value,
                    c223_vlrdisRPNP:          fORM[elemento + '[vlr_dispRPNP]['+fonte+']'].value,
                    c223_vlrdisRPP:           fORM[elemento + '[vlr_dispRPP]['+fonte+']'].value,
                    c223_vlrsemdisRPNP:       fORM[elemento + '[vlr_semRPNP]['+fonte+']'].value,
                    c223_vlrsemdisRPP:        fORM[elemento + '[vlr_semRPP]['+fonte+']'].value,
                    c223_vlrdisptotal:        fORM[elementofonte + '[disp_total]'].value,
                    c223_vlrutilizado:        fORM[elementofonte + '[vlr_utilizado]'].value,
                    c223_vlrdisponivel:       fORM[elementofonte + '[vlr_disponivel]'].value
                };
                itensEnviar.push(novoItem);
            });
            novoAjax({
                exec: 'salvar',
                itens: itensEnviar
            }, retornoAjax);
        } catch(e) {
            alert(e.toString());
        }
        return false;
    }

    function novoAjax(params, onComplete) {
        js_divCarregando('Aguarde Salvando', 'div_aguarde');
        var request = new Ajax.Request('despesainscritarp.RPC.php', {
            method:'post',
            parameters:'json=' + JSON.stringify(params),
            onComplete: function(res) {
                js_removeObj('div_aguarde');
                onComplete(res);
            }
        });
    }

    function retornoAjax(res) {
        var response = JSON.parse(res.responseText);
        if (response.status != 1) {
            alert(response.erro);
        } else if (!!response.sucesso) {
            alert('Salvo com Sucesso !');
            location.reload();
        }
    }

    /**
     * fun��o para carregar valores dos itens na tela
     */

    function carregaritens(fonte) {
        buscaritens({
            exec: 'getItens',
            fonte: fonte
        }, js_carregaritens);
    }

    function js_carregaritens(oRetorno){
        var itens = JSON.parse(oRetorno.responseText.urlDecode());
        // console.log(itens);
        itens.itens.forEach(function (item, b) {
            // console.log(item);
            if(document.form1['aEmpenho[' + item.c223_codemp + '][vlr_dispRPNP]['+item.c223_fonte+']'] != undefined ){
                document.form1['aEmpenho[' + item.c223_codemp + '][vlr_dispRPNP]['+item.c223_fonte+']'].value = item.c223_vlrdisrpnp;
                document.form1['aEmpenho[' + item.c223_codemp + '][vlr_dispRPP]['+item.c223_fonte+']'].value = item.c223_vlrdisrpp;
                document.form1['aEmpenho[' + item.c223_codemp + '][vlr_semRPP]['+item.c223_fonte+']'].value = item.c223_vlrsemdisrpp;
                document.form1['aEmpenho[' + item.c223_codemp + '][vlr_semRPNP]['+item.c223_fonte+']'].value = item.c223_vlrsemdisrpnp;
                if(document.form1['aFonte  [' + item.c223_fonte +  '][vlr_disponivel]'] != undefined){
                    document.form1['aFonte  [' + item.c223_fonte +  '][vlr_disponivel]'].value = item.c223_vlrdisponivel;
                }
            }
        });
    }

    function buscaritens(params, onComplete) {
        js_divCarregando('Carregando Novas Informa��es', 'div_aguarde');
        var request = new Ajax.Request('despesainscritarp.RPC.php', {
            method:'post',
            parameters:'json=' + JSON.stringify(params),
            onComplete: function(res) {
                js_removeObj('div_aguarde');
                onComplete(res);
            }
        });
    }

    /**
     * funcao para carregar o valor Utilizado
     *
     * */

    function js_buscarVlrDisp(fonte) {
        buscaritens({
            exec: 'getUtilizado',
            fonte: fonte
        }, js_carregarVlorDisp);
    }

    function js_carregarVlorDisp(oRetorno) {
        var vlrDispFonte = JSON.parse(oRetorno.responseText.urlDecode());

        if (vlrDispFonte != null) {

            vlrDispFonte.fontes.forEach(function (fonte, key) {
                let VlrUtilizado = Number(fonte.saldoUtilizado);
                if (document.form1['aFonte[' + fonte.fonte + '][vlr_utilizado]'] != undefined) {
                    document.form1['aFonte[' + fonte.fonte + '][vlr_utilizado]'].value = js_roundDecimal(VlrUtilizado,2);
                }
            });
        }
    }

    function js_calcularVlrDis(params, onComplete) {
        js_divCarregando('Carregando Valor Utilizado', 'div_aguarde');
        var request = new Ajax.Request('despesainscritarp.RPC.php', {
            method:'post',
            parameters:'json=' + JSON.stringify(params),
            onComplete: function(res) {
                js_removeObj('div_aguarde');
                onComplete(res);
            }
        });
    }

    /**
     * funcao para carregar o valor Disponibilidade
     * */

    function js_buscarDisponibilidade(fonte) {
        buscaritens({
            exec: 'getDisponibilidadetotal',
            fonte: fonte
        }, js_carregarDisponibilidade);
    }

    function js_carregarDisponibilidade(oRetorno){

        var oDisponiblidade = JSON.parse(oRetorno.responseText.urlDecode());
        oDisponiblidade.dispobilidade.forEach(function (dispfonte, key) {

            if(document.form1['aFonte[' + dispfonte.c224_fonte + '][disp_total]'] != undefined){
                VlrUtilizado = document.form1['aFonte[' + dispfonte.c224_fonte + '][vlr_utilizado]'].value;
            }

            if(document.form1['aFonte[' + dispfonte.c224_fonte + '][disp_total]'] != undefined ){
                document.form1['aFonte[' + dispfonte.c224_fonte + '][disp_total]'].value = dispfonte.c224_vlrdisponibilidadecaixa;
                document.form1['aFonte[' + dispfonte.c224_fonte + '][vlr_disponivel]'].value = js_roundDecimal(Number(dispfonte.c224_vlrdisponibilidadecaixa) - Number(VlrUtilizado),2);
            }
        });
    }

    function js_Disponibilidadetotal(params, onComplete) {
        js_divCarregando('Carregando Disponibilidade', 'div_aguarde');
        var request = new Ajax.Request('despesainscritarp.RPC.php', {
            method:'post',
            parameters:'json=' + JSON.stringify(params),
            onComplete: function(res) {
                js_removeObj('div_aguarde');
                onComplete(res);
            }
        });
    }

    function js_aplicardisptotal(fonte) {
        let VlrDispTotal = document.form1['aFonte[' + fonte + '][disp_total]'].value;
        let VlrTotalRP   = document.form1['aFonte[' + fonte + '][vlr_totalrp]'].value;

        if(Number(VlrTotalRP) > Number(VlrDispTotal)){
            alert("Erro! Valor Total RP maior que Valor Disp. Total");
            getItensMarcadosFonte(fonte).forEach(function (itens, key) {
                itens.checked = false;
            });
        }else {
            let VlrUtilizadoFonte = 0;
            getItensMarcadosFonte(fonte).forEach(function (itens, key) {
                itens.checked = true;
                let vlr_lqd        = document.form1['aEmpenho[' + itens.value + '][vlr_lqd]['+ fonte +']'].value;
                let vlr_n_lqd      = document.form1['aEmpenho[' + itens.value + '][vlr_n_lqd]['+ fonte +']'].value;
                VlrUtilizadoFonte += Number(vlr_lqd) + Number(vlr_n_lqd);

                document.form1['aEmpenho['+ itens.value +'][vlr_dispRPNP]['+ fonte +']'].value = vlr_n_lqd;
                document.form1['aEmpenho['+ itens.value +'][vlr_dispRPP]['+ fonte +']'].value = vlr_lqd;

            });
            if(VlrUtilizadoFonte > VlrDispTotal){
                alert("Erro! Valor utilizado maior que valor Disponivel");
                getItensMarcadosFonte(fonte).forEach(function (itens, key) {
                    itens.checked = false;
                    document.form1['aEmpenho['+ itens.value +'][vlr_dispRPNP]['+ fonte +']'].value = 0;
                    document.form1['aEmpenho['+ itens.value +'][vlr_dispRPP]['+ fonte +']'].value = 0;
                });
            }
            document.form1['aFonte[' + fonte + '][vlr_utilizado]'].value = js_roundDecimal(VlrUtilizadoFonte,2);
            document.form1['aFonte[' + fonte + '][vlr_disponivel]'].value = js_roundDecimal(Number(VlrDispTotal) - Number(VlrUtilizadoFonte),2);

        }
    }

    function js_aplicar(fonte,emp) {

        let vlr_dispRPNP = document.form1['aEmpenho[' + emp + '][vlr_dispRPNP][' + fonte + ']'].value;
        let vlr_dispRPP  = document.form1['aEmpenho[' + emp + '][vlr_dispRPP][' + fonte + ']'].value;
        let vlr_n_lqd    = document.form1['aEmpenho[' + emp + '][vlr_n_lqd][' + fonte + ']'].value;
        let vlr_lqd      = document.form1['aEmpenho[' + emp + '][vlr_lqd][' + fonte + ']'].value;
        let VlrDispTotal = document.form1['aFonte[' + fonte + '][disp_total]'].value;
        let VlrTotalRP   = document.form1['aFonte[' + fonte + '][vlr_totalrp]'].value;
        let VlrDisponivel   = document.form1['aFonte[' + fonte + '][vlr_disponivel]'].value;
        document.getElementById(emp).checked = true;

        if(Number(VlrDisponivel) == 0 || Number(vlr_lqd) > Number(VlrDisponivel) || Number(vlr_n_lqd) > Number(VlrDisponivel)){
            alert("Erro! N�o existe saldo Disponivel para essa Opera��o");
            document.getElementById(emp).checked = false;
        }else {
            if (Number(VlrTotalRP) > (VlrDispTotal) && Number(VlrDispTotal) == 0) {
                alert("Erro! Valor Total RP maior que Valor Disp. Total");
                document.getElementById(emp).checked = false;
            } else {

                if (Number(vlr_lqd) == 0) {
                    // alert("N�o existe saldo liquidado para este empenho!");
                    document.form1['aEmpenho[' + emp + '][vlr_dispRPP][' + fonte + ']'].style.background = '#DEB887';
                    document.form1['aEmpenho[' + emp + '][vlr_dispRPP][' + fonte + ']'].value = 0;
                } else {
                    if (Number(vlr_dispRPP) > Number(vlr_lqd)) {
                        // alert("Erro! Valor de Disp. RPP maior que valor liquidado.");
                        document.form1['aEmpenho[' + emp + '][vlr_dispRPP][' + fonte + ']'].value = 0;
                    } else {
                        let resultvlrsemRPP = vlr_lqd - vlr_dispRPP;
                        document.form1['aEmpenho[' + emp + '][vlr_semRPP][' + fonte + ']'].value = js_roundDecimal(resultvlrsemRPP, 2);
                        if (vlr_dispRPP == 0 || vlr_dispRPP == '') {
                            document.form1['aEmpenho[' + emp + '][vlr_dispRPP][' + fonte + ']'].value = vlr_lqd;
                        } else {
                            document.form1['aEmpenho[' + emp + '][vlr_dispRPP][' + fonte + ']'].value = vlr_dispRPP;
                        }
                    }
                }

                if (vlr_n_lqd == 0) {
                    // alert("N�o existe saldo n�o liquidado para este empenho!");
                    document.form1['aEmpenho[' + emp + '][vlr_dispRPNP][' + fonte + ']'].style.background = '#DEB887';
                    document.form1['aEmpenho[' + emp + '][vlr_dispRPNP][' + fonte + ']'].value = 0;
                } else {
                    if (Number(vlr_dispRPNP) > Number(vlr_n_lqd)) {
                        // alert("Erro! Valor de Disp. RPNP maior que valor n�o liquidado");
                        document.form1['aEmpenho[' + emp + '][vlr_dispRPNP][' + fonte + ']'].value = 0;
                    } else {
                        let resultvlrsemRPNP = vlr_n_lqd - vlr_dispRPNP;
                        document.form1['aEmpenho[' + emp + '][vlr_semRPNP][' + fonte + ']'].value = js_roundDecimal(resultvlrsemRPNP, 2);
                        if (vlr_dispRPNP == 0 || vlr_dispRPNP == '') {
                            document.form1['aEmpenho[' + emp + '][vlr_dispRPNP][' + fonte + ']'].value = js_roundDecimal(vlr_n_lqd, 2);
                        } else {
                            document.form1['aEmpenho[' + emp + '][vlr_dispRPNP][' + fonte + ']'].value = js_roundDecimal(vlr_dispRPNP, 2);
                        }
                    }
                }
            }
            /**
             *Calcular valor Disponivel
             */
            let VlrUtilizadoFonte = 0;
            aItensFonte(fonte).forEach(function (itens, key) {
                // itens.checked = true;
                let vlr_dispRPNP = document.form1['aEmpenho[' + itens.value + '][vlr_dispRPNP][' + fonte + ']'].value;
                let vlr_dispRPP = document.form1['aEmpenho[' + itens.value + '][vlr_dispRPP][' + fonte + ']'].value;
                VlrUtilizadoFonte += Number(vlr_dispRPNP) + Number(vlr_dispRPP);
            });

            document.form1['aFonte[' + fonte + '][vlr_utilizado]'].value = js_roundDecimal(VlrUtilizadoFonte, 2);
            document.form1['aFonte[' + fonte + '][vlr_disponivel]'].value = js_roundDecimal(Number(VlrDispTotal) - Number(VlrUtilizadoFonte), 2);
        }
    }

</script>