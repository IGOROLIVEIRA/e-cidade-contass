
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
            codigo,
            descricao,
            empenho,
            credor,
            round(sum(e60_vlremp - e60_vlranu - e60_vlrliq),2) AS vlr_n_lqd,
            round(sum(e60_vlrliq - e60_vlrpag),2) AS vlr_lqd,
            z01_numcgm,
            e60_anousu
     FROM
         (SELECT o15_codtri AS fonte,
                 o15_codigo AS codigo,
                 o15_descr  AS descricao,
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
          GROUP BY fonte, codigo, empenho, z01_numcgm, c53_tipo, c70_valor, e60_anousu
          ORDER BY codigo, empenho) AS x
     GROUP BY fonte, descricao, empenho, codigo, credor,z01_numcgm, e60_anousu
     ORDER BY fonte, codigo DESC, empenho::integer) AS total
     WHERE (vlr_n_lqd > 0 OR vlr_lqd > 0)";
    $rsEmpenhos = db_query($sql);

    ?>
    <br>
    <form name="form1" method="post" action="" style="" onsubmit="return validaForm(this);">
        <table>
            <tr>
                <td>
                    <center><strong>Despesas do Exercicio Inscritas em Resto a Pagar</strong></center>
                </td>
            </tr>
            <tr></tr>
            <tr>
                <td>
                    <?php
                    $clorctiporec = new cl_orctiporec();
                    $recursos = $clorctiporec->sql_record($clorctiporec->sql_query_file(null,"distinct on (o15_codtri) o15_codtri ,o15_descr","o15_codtri","o15_codtri != '' and (o15_datalimite is null or o15_datalimite >= '".date('Y-m-d', db_getsession('DB_datausu'))."')"));
                    db_selectrecord("o15_codtri",$recursos,true,$db_opcao,"","","",true,"js_filtrafonte(this.value)");
                    ?>
                </td>
                <td>
                    <input type="button" id = "deletarDados" value="Apagar Dados" onclick="js_deletarInscricao()">
                </td>
            </tr>
        </table>
        <?php
        $aEmpenhos = db_utils::getCollectionByRecord($rsEmpenhos);
        $iTotalFontes = 0;
        $arrayEmpenhos = 0;
        $oTotalrpfonte = array();
        $arrayFontesCodigo = array();

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
            $iFonteCodigo = $oEmp->codigo;
            $iFonteDescricao = $oEmp->descricao;
            $iEmpenho = $oEmp->empenho;

            if (!isset($arrayFontes[$iFonte])) {
                ?>
                <!-- <center>
                    <input type="submit" value="Salvar">
                </center> -->
                <br>
                <br>
                <br>
                <table>
                    <tr class="DBGrid">
                        <td class="table_header" style="width: 40px;"> Fonte </td>
                        <td class="table_header" style="width: 50px;"> <?= $iFonte ?> </td>
                        <th class="table_header" style="width: 70px;" rowspan="2"> Disp. Total </th>
                        <td class="table_header" style="width: 100px;">
                            <input type="text" name="aFonte[<?= $iFonte ?>][disp_total]" value="0" style="width: 100px; background: #DEB887;" readonly="true">
                        </td>
                        <th class="table_header" style="width: 90px;">Saldo Utilizado</th>
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
                        <th rowspan="4">
                            <input type="button" nome="" value="Aplicar Disp. T" rowspan="2" onclick="js_aplicardisptotal(<?= $iFonte ?>)">
                            <input type="button" nome="" value="RPP" rowspan="3" onclick="js_aplicardisptotalRPP(<?= $iFonte ?>)">
                            <input type="button" nome="" value="RPNP" rowspan="3" onclick="js_aplicardisptotalRPNP(<?= $iFonte ?>)">
                            <input type="submit" value="Salvar">
                        </th>
                        </td>
                    </tr>
                </table>
                <?
            }

            if (!isset($arrayFontesCodigo[$iFonteCodigo])) {
                ?>

                <br>
                <table>
                    <tr class="DBGrid">
                        <td class="table_header" style="width: 50px;"> Fonte </td>
                        <td class="table_header" style="width: 100px;"> <?= $iFonteCodigo ?> </td>
                        <td class="table_header" style="width: 900px;"> <?= $iFonteDescricao ?> </td>
                        <td><input type="submit" value="Salvar"></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th class="table_header" style="width: 33px; cursor: pointer;" onclick="marcarTodos(<?= $iFonteCodigo ?>);">M</th>
                        <th class="table_header" style="width: 70px;">Nº Empenho</th>                        
                        <th class="table_header" style="width: 240px;">Credor</th>
                        <th class="table_header" style="width: 110px;">Saldo Liquidado</th>
                        <th class="table_header" style="width: 100px;">Saldo não Liquidado</th>
                        <th class="table_header" style="width: 100px;">Valor de Disp. RPP</th>                        
                        <th class="table_header" style="width: 100px;">Valor de Disp. RPNP</th>
                        <th class="table_header" style="width: 100px;">Valor Sem Disp. RPP</th>
                        <th class="table_header" style="width: 100px;">Valor Sem Disp. RPNP</th>                        
                        <th class="table_header" style="width: 100px;">Aplicar Dis. RPNP e RPP</th>
                    </tr>
                </table>
                <?
            }
            ?>

            <table class="DBGrid">

                <th class="table_header" style="width: 33px">
                    <input type="checkbox" class="marca_itens[<?= $iFonte ?>] codigo_item[<?= $iFonteCodigo ?>]" name="aItensMarcados" value="<?= $iEmpenho ?>" id="<?= $iEmpenho?>">
                </th>

                <td class="linhagrid" style="width: 70px">
                    <?= $iEmpenho ?>
                    <input type="hidden" name="aEmpenho[<?= $iEmpenho ?>][empenho][<?= $iFonte ?>]" value="<?= $oEmp->empenho ?>" id="<?= $iFonte?>">
                </td>

                <td class="linhagrid left" style="width: 240px">
                    <?= str_replace('&','',$oEmp->credor) ?>
                    <input type="hidden" name="aEmpenho[<?= $iEmpenho ?>][credor][<?= $iFonte ?>]" value="<?= str_replace('&','',$oEmp->credor) ?>" id="<?= $iFonte?>">
                </td>

                <td class="linhagrid" style="width: 110px;">
                    <?= $oEmp->vlr_lqd ?>
                    <input type="hidden" name="aEmpenho[<?= $iEmpenho ?>][vlr_lqd][<?= $iFonte ?>]" value="<?= $oEmp->vlr_lqd ?>" id="<?= $iFonte?>">
                </td>

                <td class="linhagrid" style="width: 100px;">
                    <?= $oEmp->vlr_n_lqd ?>
                    <input type="hidden" name="aEmpenho[<?= $iEmpenho ?>][vlr_n_lqd][<?= $iFonte ?>]" value="<?= $oEmp->vlr_n_lqd ?>" id="<?= $iFonte?>">
                </td>

                <td class="linhagrid">
                    <input type="text" style="<?echo ($anousu >= 2023 ? "width: 100px; background: #DEB887;" : "width: 100px;")?>" readonly="<?echo ($anousu >= 2023 ? "true" : "false")?>" name="aEmpenho[<?= $iEmpenho ?>][vlr_dispRPP][<?= $iFonte ?>]" onKeyUp="return sem_virgula(this);" value="0" onchange="adicionarEdicaoRPP(<?= $iEmpenho ?>,<?= $iFonte?>)" id="<?= $iFonte?>">
                </td>

                <td class="linhagrid">
                    <input type="text" style="<?echo ($anousu >= 2023 ? "width: 100px; background: #DEB887;" : "width: 100px;")?>" readonly="<?echo ($anousu >= 2023 ? "true" : "false")?>" name="aEmpenho[<?= $iEmpenho ?>][vlr_dispRPNP][<?= $iFonte ?>]" value="0" onKeyUp="return sem_virgula(this);" onchange="adicionarEdicaoRPNP(<?= $iEmpenho ?>,<?= $iFonte?>)" id="<?= $iFonte?>">
                </td>

                <td class="linhagrid" style="width: 100px">
                    <input type="text" name="aEmpenho[<?= $iEmpenho ?>][vlr_semRPP][<?= $iFonte ?>]" value="0" style="width: 100px; background: #DEB887;" readonly="true" id="<?= $iFonte?>">                    
                </td>

                <td class="linhagrid" style="width: 80px">
                    <input type="text" name="aEmpenho[<?= $iEmpenho ?>][vlr_semRPNP][<?= $iFonte ?>]" value="0" style="width: 100px; background: #DEB887;" readonly="true" id="<?= $iFonte?>">    
                </td>

                <td class="linhagrid" style="width: 70px; display: none">
                    <?= $iEmpenho ?>
                    <input type="hidden" name="aEmpenho[<?= $iEmpenho ?>][fonte][<?= $iFonte ?>]" value="<?= $oEmp->fonte ?>" id="<?= $iFonte?>">
                </td>

                <td class="linhagrid" style="width: 100px;">
                    <input type="button" name="aEmpenho[<?= $iEmpenho ?>][aplicar][<?= $iFonte ?>]" value="RPP" id="<?= $iFonte?>" onclick="js_aplicarRPP(<?= $iFonte ?>,<?= $iEmpenho?>)">                    
                    <input type="button" name="aEmpenho[<?= $iEmpenho ?>][aplicar][<?= $iFonte ?>]" value="RPNP" id="<?= $iFonte?>" onclick="js_aplicarRPNP(<?= $iFonte ?>,<?= $iEmpenho?>)">    
                    <input type="button" name="aEmpenho[<?= $iEmpenho ?>][aplicar][<?= $iFonte ?>]" value="TODOS" id="<?= $iFonte?>" onclick="js_aplicar(<?= $iFonte ?>,<?= $iEmpenho?>)">                    
                </td>
            </table>
            <?
            $iTotalFontes++;

            $arrayFontes[$iFonte] = $iFonte;
            $arrayFontesCodigo[$iFonteCodigo] = $iFonteCodigo;

            ?>

        <?php endforeach; ?>
    </form>
</div>
<script>

    function resolverDepoisDe2Segundos() {
      js_divCarregando('finalizando carregamento', 'div_aguarde');
      return new Promise(resolve => {
        setTimeout(() => {
          resolve('resolved');
          js_removeObj('div_aguarde');
        }, 3000);
      });
    }

     js_carregafonte();
     js_buscarDisponibilidade(document.getElementById('o15_codtri').value);
    //  js_buscarVlrDisp(document.getElementById('o15_codtri').value);
     carregaritens(document.getElementById('o15_codtri').value);


    /**
     * bloquear virgula
     */
    function sem_virgula(campo){
      var digits=".1234567890"
      var campo_temp
      for (var i=0;i<campo.value.length;i++){
        campo_temp=campo.value.substring(i,i+1)
        if (digits.indexOf(campo_temp)==-1){
          campo.value = campo.value.substring(0,i);
          break;
        }
      }
    }

    function aItens() {
        var itensNum = document.getElementsByName("aItensMarcados");

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

    function aItensFonteCodigo(fonte) {
        var itensNum = document.getElementsByClassName("codigo_item["+ fonte +"]");

        return Array.prototype.map.call(itensNum, function (item) {
            return item;
        });
    }

    function marcarTodos(fonte) {

        aItensFonteCodigo(fonte).forEach(function (item) {

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
     * função para filtrar a fonte
     */

    function js_filtrafonte(value) {
        window.location.href = "con2_despesainscritarp001.php?fonte="+value;
        // carregaritens();
    }

    /**
     * função para carregar a fonte
     */

    async function js_carregafonte() {
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
            alert("Não existe saldo não liquidado para este empenho!");
            // document.form1['aEmpenho[' + codigo + '][vlr_dispRPNP]['+fonte+']'].style.background = '#DEB887';
            document.form1['aEmpenho[' + codigo + '][vlr_dispRPNP]['+fonte+']'].value = 0;
            document.getElementById(codigo).checked = false;
        }else{
            if(Number(vlr_dispRPNP) > Number(vlr_n_lqd)){
                alert("Erro! Valor de Disp. RPNP maior que valor não liquidado");
                document.form1['aEmpenho[' + codigo + '][vlr_dispRPNP]['+fonte+']'].value = 0;
                document.getElementById(codigo).checked = false;
            }else{
                let resultvlrsemRPNP = vlr_n_lqd - vlr_dispRPNP;
                if(vlr_dispRPNP > vlr_disponivel){
                    alert("Erro! Não existe saldo disponivel para essa operação.");
                    document.form1['aEmpenho[' + codigo + '][vlr_dispRPNP]['+fonte+']'].value = 0;
                    document.getElementById(codigo).checked = false;
                }else {
                    document.form1['aEmpenho[' + codigo + '][vlr_semRPNP]['+fonte+']'].value = js_roundDecimal(resultvlrsemRPNP,2);
                    document.form1['aFonte['+fonte+'][vlr_disponivel]'].value = js_roundDecimal(Number(vlr_disponivel) - Number(vlr_dispRPNP),2);
                    document.getElementById(codigo).checked = true;

                    let VlrUtilizadoFonte = 0;
                    aItensFonte(fonte).forEach(function (itens, key) {
                      // itens.checked = true;
                      let vlr_dispRPNP = document.form1['aEmpenho[' + itens.value + '][vlr_dispRPNP][' + fonte + ']'].value;
                      let vlr_dispRPP = document.form1['aEmpenho[' + itens.value + '][vlr_dispRPP][' + fonte + ']'].value;
                      VlrUtilizadoFonte += Number(vlr_dispRPNP) + Number(vlr_dispRPP);
                    });

                    document.form1['aFonte[' + fonte + '][vlr_utilizado]'].value = js_roundDecimal(VlrUtilizadoFonte, 2);

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
            alert("Não existe saldo liquidado para este empenho!");
            // document.form1['aEmpenho[' + codigo + '][vlr_dispRPP]['+fonte+']'].style.background = '#DEB887';
            document.form1['aEmpenho[' + codigo + '][vlr_dispRPP]['+fonte+']'].value = 0;
            document.form1['aItensMarcados['+ codigo +']'].checked = false;
        }else{
            if(Number(vlr_dispRPP) > Number(vlr_lqd)){
                alert("Erro! Valor de Disp. RPP maior que valor liquidado.");
                document.form1['aEmpenho[' + codigo + '][vlr_dispRPP]['+fonte+']'].value = 0;
                document.form1['aItensMarcados['+ codigo +']'].checked = false;
            }else {
                let resultvlrsemRPP = vlr_lqd - vlr_dispRPP;
                if(vlr_dispRPP > vlr_disponivel) {
                    alert("Erro! Não existe saldo disponivel para essa operação.");
                    document.form1['aEmpenho[' + codigo + '][vlr_dispRPP]['+fonte+']'].value = 0;
                    document.getElementById(codigo).checked = false;
                }else {
                    document.form1['aEmpenho[' + codigo + '][vlr_semRPP][' + fonte + ']'].value = js_roundDecimal(resultvlrsemRPP,2);
                    document.form1['aFonte['+fonte+'][vlr_disponivel]'].value = js_roundDecimal(Number(vlr_disponivel) - Number(vlr_dispRPP),2);
                    document.getElementById(codigo).checked = true;
                }

                let VlrUtilizadoFonte = 0;
                aItensFonte(fonte).forEach(function (itens, key) {
                  // itens.checked = true;
                  let vlr_dispRPNP = document.form1['aEmpenho[' + itens.value + '][vlr_dispRPNP][' + fonte + ']'].value;
                  let vlr_dispRPP = document.form1['aEmpenho[' + itens.value + '][vlr_dispRPP][' + fonte + ']'].value;
                  VlrUtilizadoFonte += Number(vlr_dispRPNP) + Number(vlr_dispRPP);
                });

                document.form1['aFonte[' + fonte + '][vlr_utilizado]'].value = js_roundDecimal(VlrUtilizadoFonte, 2);
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
        });
    }

    /**
     * Função para salvar
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

                var classes = Array.from(item.classList);
                var fonte = classes.find(function (classe) {
                    return classe.startsWith('marca_itens');
                });

                fonte = fonte.substring(12);
                fonte = fonte.replace(']','');                

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
            window.location.reload();
        }
    }

    /**
     * função para carregar valores dos itens na tela
     */

    async function carregaritens(fonte) {
        buscaritens({
            exec: 'getItens',
            fonte: fonte
        }, js_carregaritens);
    }

    async function js_carregaritens(oRetorno){

        var itens = JSON.parse(oRetorno.responseText.urlDecode());
        if(typeof itens.itens !== 'undefined') {
          itens.itens.forEach(function (item, b) {
            if (document.form1['aEmpenho[' + item.c223_codemp + '][vlr_dispRPNP][' + item.c223_fonte + ']'] != undefined) {
              document.form1['aEmpenho[' + item.c223_codemp + '][vlr_dispRPNP][' + item.c223_fonte + ']'].value = item.c223_vlrdisrpnp;
              document.form1['aEmpenho[' + item.c223_codemp + '][vlr_dispRPP][' + item.c223_fonte + ']'].value = item.c223_vlrdisrpp;
              document.form1['aEmpenho[' + item.c223_codemp + '][vlr_semRPP][' + item.c223_fonte + ']'].value = item.c223_vlrsemdisrpp;
              document.form1['aEmpenho[' + item.c223_codemp + '][vlr_semRPNP][' + item.c223_fonte + ']'].value = item.c223_vlrsemdisrpnp;
              if (document.form1['aFonte  [' + item.c223_fonte + '][vlr_disponivel]'] != undefined) {
                document.form1['aFonte  [' + item.c223_fonte + '][vlr_disponivel]'].value = item.c223_vlrdisponivel;
              }
            }
          });
        }
        js_buscarVlrDisp();
    }

    async function buscaritens(params, onComplete) {
        js_divCarregando('Carregando Novas Informações', 'div_aguarde');
        var request = new Ajax.Request('despesainscritarp.RPC.php', {
            method:'post',
            parameters:'json=' + JSON.stringify(params),
            onComplete: async function (res) {
              const result = await resolverDepoisDe2Segundos();
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
        js_divCarregando('', 'div_aguarde_disptotal');
        buscaritens({
            exec: 'getUtilizado',
            fonte: fonte
        }, js_carregarVlorDisp);
    }

    function js_carregarVlorDisp(oRetorno) {
        var vlrDispFonte = JSON.parse(oRetorno.responseText.urlDecode());

        if (typeof vlrDispFonte.fontes !== 'undefined') {

            vlrDispFonte.fontes.forEach(function (fonte, key) {
                let VlrUtilizado = Number(fonte.saldoUtilizado);
                if (document.form1['aFonte[' + fonte.fonte + '][vlr_utilizado]'] != undefined) {
                    document.form1['aFonte[' + fonte.fonte + '][vlr_utilizado]'].value = js_roundDecimal(VlrUtilizado,2);
                }
            });
        }
        js_removeObj('div_aguarde_disptotal')
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

   async function js_carregarDisponibilidade(oRetorno){
        const result = await resolverDepoisDe2Segundos();
        var oDisponiblidade = JSON.parse(oRetorno.responseText.urlDecode());
        oDisponiblidade.dispobilidade.forEach(function (dispfonte, key) {

            if(document.form1['aFonte[' + dispfonte.c224_fonte + '][disp_total]'] != undefined){
                VlrUtilizado = document.form1['aFonte[' + dispfonte.c224_fonte + '][vlr_utilizado]'].value;
            }

            if(document.form1['aFonte[' + dispfonte.c224_fonte + '][disp_total]'] != undefined ){
                document.form1['aFonte[' + dispfonte.c224_fonte + '][disp_total]'].value = dispfonte.c224_vlrdisponibilidadecaixa;

                document.form1['aFonte[' + dispfonte.c224_fonte + '][vlr_disponivel]'].value = js_roundDecimal(Number(js_roundDecimal(dispfonte.c224_vlrdisponibilidadecaixa,2)) - Number(js_roundDecimal(VlrUtilizado,2)),2);
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

    function js_aplicardisptotalRPNP(fonte) {

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
                let vlr_n_lqd      = document.form1['aEmpenho[' + itens.value + '][vlr_n_lqd]['+ fonte +']'].value;
                VlrUtilizadoFonte += Number(vlr_n_lqd);
                document.form1['aEmpenho['+ itens.value +'][vlr_dispRPNP]['+ fonte +']'].value = vlr_n_lqd;
            });
            if(VlrUtilizadoFonte > VlrDispTotal){
                alert("Erro! Valor utilizado maior que valor Disponivel");
                getItensMarcadosFonte(fonte).forEach(function (itens, key) {
                    itens.checked = false;
                    document.form1['aEmpenho['+ itens.value +'][vlr_dispRPNP]['+ fonte +']'].value = 0;
                });
            }
            document.form1['aFonte[' + fonte + '][vlr_utilizado]'].value = js_roundDecimal(VlrUtilizadoFonte,2);
            document.form1['aFonte[' + fonte + '][vlr_disponivel]'].value = js_roundDecimal(Number(VlrDispTotal) - Number(VlrUtilizadoFonte),2);
        }
    }

        function js_aplicardisptotalRPP(fonte) {

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
                VlrUtilizadoFonte += Number(vlr_lqd);
                document.form1['aEmpenho['+ itens.value +'][vlr_dispRPP]['+ fonte +']'].value = vlr_lqd;
            });
            if(VlrUtilizadoFonte > VlrDispTotal){
                alert("Erro! Valor utilizado maior que valor Disponivel");
                getItensMarcadosFonte(fonte).forEach(function (itens, key) {
                    itens.checked = false;
                    document.form1['aEmpenho['+ itens.value +'][vlr_dispRPP]['+ fonte +']'].value = 0;
                });
            }
            document.form1['aFonte[' + fonte + '][vlr_utilizado]'].value = js_roundDecimal(VlrUtilizadoFonte,2);
            document.form1['aFonte[' + fonte + '][vlr_disponivel]'].value = js_roundDecimal(Number(VlrDispTotal) - Number(VlrUtilizadoFonte),2);
        }
    }

    async function js_aplicar(fonte,emp) {

        let vlr_dispRPNP = document.form1['aEmpenho[' + emp + '][vlr_dispRPNP][' + fonte + ']'].value;
        let vlr_dispRPP  = document.form1['aEmpenho[' + emp + '][vlr_dispRPP][' + fonte + ']'].value;
        let vlr_n_lqd    = document.form1['aEmpenho[' + emp + '][vlr_n_lqd][' + fonte + ']'].value;
        let vlr_lqd      = document.form1['aEmpenho[' + emp + '][vlr_lqd][' + fonte + ']'].value;
        let VlrDispTotal = document.form1['aFonte[' + fonte + '][disp_total]'].value;
        let VlrTotalRP   = document.form1['aFonte[' + fonte + '][vlr_totalrp]'].value;
        let VlrDisponivel   = document.form1['aFonte[' + fonte + '][vlr_disponivel]'].value;
        document.getElementById(emp).checked = true;
        let saldo = Number(vlr_n_lqd) + Number(vlr_lqd);
        if(Number(VlrDisponivel) == 0 || Number(saldo) > Number(VlrDisponivel) ){
            alert("Erro! Não existe saldo Disponivel para essa Operação");
            document.getElementById(emp).checked = false;
        }else {
            if (Number(VlrTotalRP) > (VlrDispTotal) && Number(VlrDispTotal) == 0) {
                alert("Erro! Valor Total RP maior que Valor Disp. Total");
                document.getElementById(emp).checked = false;
            } else {

                const result = await resolverDepoisDe2Segundos();
                if (Number(vlr_lqd) == 0) {
                    // alert("Não existe saldo liquidado para este empenho!");
                    document.form1['aEmpenho[' + emp + '][vlr_dispRPP][' + fonte + ']'].style.background = '#DEB887';
                    document.form1['aEmpenho[' + emp + '][vlr_dispRPP][' + fonte + ']'].value = 0;
                } else {
                    if (Number(vlr_dispRPP) > Number(vlr_lqd)) {
                        // alert("Erro! Valor de Disp. RPP maior que valor liquidado.");
                        document.form1['aEmpenho[' + emp + '][vlr_dispRPP][' + fonte + ']'].value = 0;
                    } else {
                        //let resultvlrsemRPP = vlr_lqd - vlr_dispRPP;
                        //document.form1['aEmpenho[' + emp + '][vlr_semRPP][' + fonte + ']'].value = js_roundDecimal(resultvlrsemRPP, 2);
                        if (vlr_dispRPP == 0 || vlr_dispRPP == '') {
                            document.form1['aEmpenho[' + emp + '][vlr_dispRPP][' + fonte + ']'].value = vlr_lqd;
                        } else {
                            document.form1['aEmpenho[' + emp + '][vlr_dispRPP][' + fonte + ']'].value = vlr_dispRPP;
                        }
                    }
                }

                if (vlr_n_lqd == 0) {
                    // alert("Não existe saldo não liquidado para este empenho!");
                    document.form1['aEmpenho[' + emp + '][vlr_dispRPNP][' + fonte + ']'].style.background = '#DEB887';
                    document.form1['aEmpenho[' + emp + '][vlr_dispRPNP][' + fonte + ']'].value = 0;
                } else {
                    if (Number(vlr_dispRPNP) > Number(vlr_n_lqd)) {
                        // alert("Erro! Valor de Disp. RPNP maior que valor não liquidado");
                        document.form1['aEmpenho[' + emp + '][vlr_dispRPNP][' + fonte + ']'].value = 0;
                    } else {
                        const result = await resolverDepoisDe2Segundos();

                        // let resultvlrsemRPNP = vlr_n_lqd - vlr_dispRPNP;
                        // document.form1['aEmpenho[' + emp + '][vlr_semRPNP][' + fonte + ']'].value = js_roundDecimal(resultvlrsemRPNP, 2);
                        if (vlr_dispRPNP == 0 || vlr_dispRPNP == '') {
                            document.form1['aEmpenho[' + emp + '][vlr_dispRPNP][' + fonte + ']'].value = js_roundDecimal(vlr_n_lqd, 2);
                        } else {
                            document.form1['aEmpenho[' + emp + '][vlr_dispRPNP][' + fonte + ']'].value = js_roundDecimal(vlr_dispRPNP, 2);
                        }
                    }
                }
                if(document.form1['aEmpenho[' + emp + '][vlr_semRPNP][' + fonte + ']'].value !== null || document.form1['aEmpenho[' + emp + '][vlr_semRPP][' + fonte + ']'].value !== null) {
                  if(document.form1['aEmpenho[' + emp + '][vlr_semRPNP][' + fonte + ']'].value !== 0 || document.form1['aEmpenho[' + emp + '][vlr_semRPP][' + fonte + ']'].value !== 0) {
                    //let resultvlrsemRPP = vlr_lqd - vlr_dispRPP;
                    document.form1['aEmpenho[' + emp + '][vlr_semRPP][' + fonte + ']'].value = 0;
                    let resultvlrsemRPNP = vlr_n_lqd - vlr_dispRPNP;
                    document.form1['aEmpenho[' + emp + '][vlr_semRPNP][' + fonte + ']'].value = 0;
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
            document.form1['aFonte[' + fonte + '][vlr_disponivel]'].value = js_roundDecimal(Number(VlrDispTotal) - Number(js_roundDecimal(VlrUtilizadoFonte,2)), 2);
        }
    }

    async function js_aplicarRPP(fonte,emp) {

        let vlr_dispRPNP = document.form1['aEmpenho[' + emp + '][vlr_dispRPNP][' + fonte + ']'].value;
        let vlr_dispRPP  = document.form1['aEmpenho[' + emp + '][vlr_dispRPP][' + fonte + ']'].value;
        let vlr_n_lqd    = document.form1['aEmpenho[' + emp + '][vlr_n_lqd][' + fonte + ']'].value;
        let vlr_lqd      = document.form1['aEmpenho[' + emp + '][vlr_lqd][' + fonte + ']'].value;
        let VlrDispTotal = document.form1['aFonte[' + fonte + '][disp_total]'].value;
        let VlrTotalRP   = document.form1['aFonte[' + fonte + '][vlr_totalrp]'].value;
        let VlrDisponivel   = document.form1['aFonte[' + fonte + '][vlr_disponivel]'].value;
        document.getElementById(emp).checked = true;
        let saldo = Number(vlr_n_lqd) + Number(vlr_lqd);
        if(Number(VlrDisponivel) == 0 || Number(saldo) > Number(VlrDisponivel) ){
            alert("Erro! Não existe saldo Disponivel para essa Operação");
            document.getElementById(emp).checked = false;
        }else {
            if (Number(VlrTotalRP) > (VlrDispTotal) && Number(VlrDispTotal) == 0) {
                alert("Erro! Valor Total RP maior que Valor Disp. Total");
                document.getElementById(emp).checked = false;
            } else {
                const result = await resolverDepoisDe2Segundos();
                if (Number(vlr_lqd) == 0) {
                    document.form1['aEmpenho[' + emp + '][vlr_dispRPP][' + fonte + ']'].style.background = '#DEB887';
                    document.form1['aEmpenho[' + emp + '][vlr_dispRPP][' + fonte + ']'].value = 0;
                } else {
                    if (Number(vlr_dispRPP) > Number(vlr_lqd)) {
                        document.form1['aEmpenho[' + emp + '][vlr_dispRPP][' + fonte + ']'].value = 0;
                    } else {
                        if (vlr_dispRPP == 0 || vlr_dispRPP == '') {
                            document.form1['aEmpenho[' + emp + '][vlr_dispRPP][' + fonte + ']'].value = vlr_lqd;
                        } else {
                            document.form1['aEmpenho[' + emp + '][vlr_dispRPP][' + fonte + ']'].value = vlr_dispRPP;
                        }
                    }
                }
                if(document.form1['aEmpenho[' + emp + '][vlr_semRPP][' + fonte + ']'].value !== null) {
                  if(document.form1['aEmpenho[' + emp + '][vlr_semRPP][' + fonte + ']'].value !== 0) {
                    document.form1['aEmpenho[' + emp + '][vlr_semRPP][' + fonte + ']'].value = 0;
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
            document.form1['aFonte[' + fonte + '][vlr_disponivel]'].value = js_roundDecimal(Number(VlrDispTotal) - Number(js_roundDecimal(VlrUtilizadoFonte,2)), 2);
        }
    }

    async function js_aplicarRPNP(fonte,emp) {

        let vlr_dispRPNP = document.form1['aEmpenho[' + emp + '][vlr_dispRPNP][' + fonte + ']'].value;
        let vlr_dispRPP  = document.form1['aEmpenho[' + emp + '][vlr_dispRPP][' + fonte + ']'].value;
        let vlr_n_lqd    = document.form1['aEmpenho[' + emp + '][vlr_n_lqd][' + fonte + ']'].value;
        let vlr_lqd      = document.form1['aEmpenho[' + emp + '][vlr_lqd][' + fonte + ']'].value;
        let VlrDispTotal = document.form1['aFonte[' + fonte + '][disp_total]'].value;
        let VlrTotalRP   = document.form1['aFonte[' + fonte + '][vlr_totalrp]'].value;
        let VlrDisponivel   = document.form1['aFonte[' + fonte + '][vlr_disponivel]'].value;
        document.getElementById(emp).checked = true;
        let saldo = Number(vlr_n_lqd) + Number(vlr_lqd);
        if(Number(VlrDisponivel) == 0 || Number(saldo) > Number(VlrDisponivel) ){
            alert("Erro! Não existe saldo Disponivel para essa Operação");
            document.getElementById(emp).checked = false;
        }else {
            if (Number(VlrTotalRP) > (VlrDispTotal) && Number(VlrDispTotal) == 0) {
                alert("Erro! Valor Total RP maior que Valor Disp. Total");
                document.getElementById(emp).checked = false;
            } else {
                const result = await resolverDepoisDe2Segundos();
                if (vlr_n_lqd == 0) {
                    document.form1['aEmpenho[' + emp + '][vlr_dispRPNP][' + fonte + ']'].style.background = '#DEB887';
                    document.form1['aEmpenho[' + emp + '][vlr_dispRPNP][' + fonte + ']'].value = 0;
                } else {
                    if (Number(vlr_dispRPNP) > Number(vlr_n_lqd)) {
                        document.form1['aEmpenho[' + emp + '][vlr_dispRPNP][' + fonte + ']'].value = 0;
                    } else {
                        const result = await resolverDepoisDe2Segundos();
                        if (vlr_dispRPNP == 0 || vlr_dispRPNP == '') {
                            document.form1['aEmpenho[' + emp + '][vlr_dispRPNP][' + fonte + ']'].value = js_roundDecimal(vlr_n_lqd, 2);
                        } else {
                            document.form1['aEmpenho[' + emp + '][vlr_dispRPNP][' + fonte + ']'].value = js_roundDecimal(vlr_dispRPNP, 2);
                        }
                    }
                }
                if(document.form1['aEmpenho[' + emp + '][vlr_semRPNP][' + fonte + ']'].value !== null) {
                if(document.form1['aEmpenho[' + emp + '][vlr_semRPNP][' + fonte + ']'].value !== 0 ) {
                    document.form1['aEmpenho[' + emp + '][vlr_semRPNP][' + fonte + ']'].value = 0;
                }
                }
            }
            /**
             *Calcular valor Disponivel
            */
            let VlrUtilizadoFonte = 0;
            aItensFonte(fonte).forEach(function (itens, key) {
                let vlr_dispRPNP = document.form1['aEmpenho[' + itens.value + '][vlr_dispRPNP][' + fonte + ']'].value;
                let vlr_dispRPP = document.form1['aEmpenho[' + itens.value + '][vlr_dispRPP][' + fonte + ']'].value;
                VlrUtilizadoFonte += Number(vlr_dispRPNP) + Number(vlr_dispRPP);
            });

            document.form1['aFonte[' + fonte + '][vlr_utilizado]'].value = js_roundDecimal(VlrUtilizadoFonte, 2);
            document.form1['aFonte[' + fonte + '][vlr_disponivel]'].value = js_roundDecimal(Number(VlrDispTotal) - Number(js_roundDecimal(VlrUtilizadoFonte,2)), 2);
        }
    }

    function js_deletarInscricao(){
        const fonte = document.getElementById('o15_codtri').value;
        let sMensagem = "Esse processo irá apagar todas as inscrições de empenho da fonte "+fonte+". Deseja mesmo continuar?";

        if(fonte == ''){
            alert('Fonte invalida.');
            return false;
        }else{
            if(fonte == 1){
                sMensagem = "Esse processo irá apagar todas as inscrições de empenho de todas as fontes. Deseja mesmo continuar?";
            }
            if(!confirm(sMensagem)){
                return false;
            }else{

            let oParam = new Object();
            oParam.exec = 'deletarDados';
            oParam.fonte = fonte;        
            const oAjax = new Ajax.Request(
                            'despesainscritarp.RPC.php',
                            {
                            method: 'post',
                            parameters: 'json='+Object.toJSON(oParam),
                            onComplete: async function (res) {
                                    let msg = JSON.parse(res.responseText.urlDecode());
                                    alert(msg.message);
                                    const result = await resolverDepoisDe2Segundos();
                                    js_removeObj('div_aguarde');
                                    window.location.reload();
                                }
                            }
                            );
            }
        }
    }

</script>
