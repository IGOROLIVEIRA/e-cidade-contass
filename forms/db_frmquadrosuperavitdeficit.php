
<div class="registro_empinscritosemrp">
<?php

$clorctiporec = new cl_orctiporec();

// Condição necessária devido a mudança do modelo de fonte de recursos no TCE-MG em 2023
if (db_getsession("DB_anousu") <= 2022) {
    $sql = "select distinct concat('1', substring(o15_codtri, 2, 2)) as o15_codtri from orctiporec o1 where o15_codtri != '' and o15_codtri::int >= 100 AND o15_codtri::int <= 299 AND (o15_datalimite IS NULL OR o15_datalimite >= '" . db_getsession("DB_anousu") . "-12-31') order by concat('1', substring(o15_codtri, 2, 2))";
} else {
    $sql = "select distinct concat('1', substring(o15_codtri, 2)) as o15_codtri from orctiporec o1 where o15_codtri != '' AND o15_codtri::int > 999999 AND (o15_datalimite IS NULL OR o15_datalimite <= '" . db_getsession("DB_anousu") . "-12-31') order by concat('1', substring(o15_codtri, 2))";
}

$recursos = $clorctiporec->sql_record($sql);

?>
<form name="form1" method="post" action="" onsubmit="return validaForm(this);">
    <fieldset style="width:0px">
        <legend align="center">
            <strong>Quadro do Superávit / Déficit Financeiro</strong>
        </legend>
        <table class="DBGrid" style="width: 600px">
            <tr>
                <th class="table_header">Fonte</th>
                <th class="table_header">Valor</th>
                <th class="table_header">Suplementado</th>
                <th class="table_header">Saldo</th>
            </tr>
        <?php
        $aRecurso = db_utils::getCollectionByRecord($recursos);
        $iTotalFontes = 0;
        $arrayEmpenhos = 0;

        foreach ($aRecurso as $oFot) :
            $iFonte = ltrim($oFot->o15_codtri, "0");
        ?>

            <tr>
                <td class="linhagrid">
                    <?= $iFonte ?>
                    <input type="hidden" name="aFonte[<?= $iFonte ?>][fonte]" value="<?= $oFot->o15_codtri ?>" id="">
                </td>

                <td class="linhagrid">
                    <input type="text" style="width: 100px; text-align: right" name="aFonte[<?= $iFonte ?>][valor]" value="0.00" size="16" maxlength="" onkeyup="js_ValidaCampos(this, 4, 'valor', false, null, event)" onblur="js_ValidaMaiusculo(this,'',event);" oninput="js_ValidaCampos(this,0,'','','',event);" onkeydown="return js_controla_tecla_enter(this,event);" id="">
                </td>

                <td class="linhagrid">
                    <input type="text" readonly="true" style="width: 100px; background: #DEB887; text-align: right" name="aFonte[<?= $iFonte ?>][suplementado]"  value="0.00" size="16" maxlength="" onkeyup="js_ValidaCampos(this, 4, 'valor', false, null, event)" onblur="js_ValidaMaiusculo(this,'',event);" oninput="js_ValidaCampos(this,0,'','','',event);" onkeydown="return js_controla_tecla_enter(this,event);" id="">
                </td>
                
                <td class="linhagrid">
                    <input type="text" readonly="true" style="width: 100px; background: #DEB887; text-align: right" name="aFonte[<?= $iFonte ?>][saldo]"  value="0.00" size="16" maxlength="" onkeyup="js_ValidaCampos(this, 4, 'valor', false, null, event)" onblur="js_ValidaMaiusculo(this,'',event);" oninput="js_ValidaCampos(this,0,'','','',event);" onkeydown="return js_controla_tecla_enter(this,event);" id="">
                </td>
            </tr>
            <?
            $iTotalFontes++;

            $arrayFontes[$iFonte] = $iFonte;

            ?>

        <?php endforeach; ?>
        <tr>
                <td class="linhagrid">
                    <?= "TOTAL" ?>
                    <input type="hidden" name="Total" value="Total" id="">
                </td>

                <td class="linhagrid">
                    <input type="text" readonly="true" style="width: 100px; background: #DEB887; text-align: right" name="aFonteTotalValor" value="0.00" size="16" maxlength="" >
                </td>
                <td class="linhagrid">
                    <input type="text" readonly="true" style="width: 100px; background: #DEB887; text-align: right" name="aFonteTotalSuplementado"  value="0.00" size="16" maxlength="" >
                </td>
                
                <td class="linhagrid">
                    <input type="text" readonly="true" style="width: 100px; background: #DEB887; text-align: right" name="aFonteTotalSaldo"  value="0.00" size="16" maxlength="" >
                </td>
            </tr>
        </table>
        <center>
            <input type="submit" value="Salvar" id="btmSalvar" name="incluir">
            <input type="button" onclick="importar()" value="Importar" id="btmImportar" name="">
        </center>
    </fieldset>
</form>
</div>
<script>
carregarvalores();

/**
 * função para carregar valores na tela
 */

function carregarvalores() {
    buscarvalores({
        exec: 'getValores',
        // fonte: fonte
    }, js_carregarValores);
    
    buscarvalores({
        exec: 'getSuplementado',
        // fonte: fonte
    }, js_carregarValoresSuplementados);
    
}

function importar()
{
    buscarvalores({
        exec: 'getImportar',
        // fonte: fonte
    }, js_carregarValores); 
}

function js_carregarValores(oRetorno) {
    var valores = JSON.parse(oRetorno.responseText.urlDecode());
    
    for (var [key, fonte] of Object.entries(valores.fonte)) {
        var valor = parseFloat(fonte.c241_valor);
        if (document.form1['aFonte[' + fonte.c241_fonte + '][valor]']) {
            document.form1['aFonte[' + fonte.c241_fonte + '][valor]'].value = valor.toLocaleString('pt-BR',  { minimumFractionDigits: 2, maximumFractionDigits: 2});
            var valor = fonte.c241_valor - document.form1['aFonte[' + fonte.c241_fonte + '][suplementado]'].value;
            document.form1['aFonte[' + fonte.c241_fonte + '][saldo]'].value = valor.toLocaleString('pt-BR',  { minimumFractionDigits: 2, maximumFractionDigits: 2});
        }
    }

    valores.fonte.forEach(function(fonte, b) {
        var valor = parseFloat(fonte.c241_valor);
        if (document.form1['aFonte[' + fonte.c241_fonte + '][valor]']) {
            document.form1['aFonte[' + fonte.c241_fonte + '][valor]'].value = fonte.c241_valor;
            var valor = fonte.c241_valor - document.form1['aFonte[' + fonte.c241_fonte + '][suplementado]'].value;
            document.form1['aFonte[' + fonte.c241_fonte + '][saldo]'].value = valor.toLocaleString('pt-BR',  { minimumFractionDigits: 2, maximumFractionDigits: 2});
        }
    });   
    document.form1['aFonteTotalSaldo'].value =  (valores.valor - valores.suplementado).toLocaleString('pt-BR',  { minimumFractionDigits: 2, maximumFractionDigits: 2});    
    document.form1['aFonteTotalValor'].value =  valores.valor.toLocaleString('pt-BR',  { minimumFractionDigits: 2, maximumFractionDigits: 2});
    document.form1['aFonteTotalSuplementado'].value = valores.suplementado.toLocaleString('pt-BR',  { minimumFractionDigits: 2, maximumFractionDigits: 2});
}

function js_carregarValoresSuplementados(oRetorno) {
    var valores = JSON.parse(oRetorno.responseText.urlDecode());
    valores.fonte.forEach(function(fonte, b) {
        if (document.form1['aFonte[' + fonte.fonte + '][suplementado]']) {
            document.form1['aFonte[' + fonte.fonte + '][suplementado]'].value = parseFloat(fonte.valor).toLocaleString('pt-BR',  { minimumFractionDigits: 2, maximumFractionDigits: 2});
            var valor = document.form1['aFonte[' + fonte.fonte + '][valor]'].value - fonte.valor;
            document.form1['aFonte[' + fonte.fonte + '][saldo]'].value = valor.toLocaleString('pt-BR',  { minimumFractionDigits: 2, maximumFractionDigits: 2});
        }
    });
}

function buscarvalores(params, onComplete) {
    js_divCarregando('Carregando Valores', 'div_aguarde');
    var request = new Ajax.Request('quadrosuperavitdeficit.RPC.php', {
        method: 'post',
        parameters: 'json=' + JSON.stringify(params),
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
    document.form1.reset();
    buscarSicom({
        exec: 'getSicom',
        // fonte: fonte
    }, Atualizar);
}

function Atualizar(oRetorno) {
    var valoresSicom = JSON.parse(oRetorno.responseText.urlDecode());
    if (valoresSicom == 0) {
        alert('Gere os os arquivos CTB, CAIXA e CUTE do mês de dezembro para atualizar a disponibilidade');
        return false;
    }

    valoresSicom.oDados.forEach(function(dadosfonte, b) {
        Object.keys(dadosfonte).forEach(function(fonte, key) {
            if (dadosfonte[fonte].vlrcaixabruta == undefined) {
                document.form1['aFonte[' + fonte + '][valor]'].value = 0;
            } else {
                document.form1['aFonte[' + fonte + '][valor]'].value = dadosfonte[fonte].vlrcaixabruta;
            }

            if (dadosfonte[fonte].VlrroexercicioAnteriores == undefined) {
                document.form1['aFonte[' + fonte + '][vlr_rpExerAnteriores]'].value = 0;
            } else {
                document.form1['aFonte[' + fonte + '][vlr_rpExerAnteriores]'].value = dadosfonte[fonte].VlrroexercicioAnteriores;
            }

            // if(dadosfonte[fonte].vlrrestorecolher == undefined){
            //   document.form1['aFonte[' + fonte + '][vlr_restArecolher]'].value = 0;
            // }else{
            //   document.form1['aFonte[' + fonte + '][vlr_restArecolher]'].value = dadosfonte[fonte].vlrrestorecolher;
            // }
            //
            // if(dadosfonte[fonte].vlrAtivoFian == undefined){
            //   document.form1['aFonte[' + fonte + '][vlr_restRegAtivoFinan]'].value = 0;
            // }else{
            //   document.form1['aFonte[' + fonte + '][vlr_restRegAtivoFinan]'].value = dadosfonte[fonte].vlrAtivoFian;
            // }

            document.form1['aFonte[' + fonte + '][vlr_DispCaixa]'].value = dadosfonte[fonte].vlrDisponibilidade;

        });
    });
}

function buscarSicom(params, onComplete) {
    js_divCarregando('Carregando Valores', 'div_aguarde');
    var request = new Ajax.Request('cadastrodespesainscritarp.RPC.php', {
        method: 'post',
        parameters: 'json=' + JSON.stringify(params),
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

    let vlrDisCaixaBruta = document.form1['aFonte[' + fonte + '][valor]'].value;
    let vlrRpExercicioanterior = document.form1['aFonte[' + fonte + '][vlr_rpExerAnteriores]'].value;
    // let vlrRestoRecolher       = document.form1['aFonte[' + fonte + '][vlr_restArecolher]'].value;
    // let vlrRegAtivoFian        = document.form1['aFonte[' + fonte + '][vlr_restRegAtivoFinan]'].value;
    let ResultVlrDisponibilidade = Number(vlrDisCaixaBruta) - Number(vlrRpExercicioanterior);

    //document.form1['aFonte[' + fonte + '][vlr_DispCaixa]'].value = ResultVlrDisponibilidade.toFixed(2)
    document.form1['aFonte[' + fonte + '][vlr_DispCaixa]'].value = ResultVlrDisponibilidade.toFixed(2)

}

function validaForm(form) {
    return true;
}
</script>