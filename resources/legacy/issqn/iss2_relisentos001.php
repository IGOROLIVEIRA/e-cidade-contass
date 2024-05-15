<?php

require_once "libs/db_stdlib.php";
require_once "libs/db_conecta.php";
require_once "libs/db_sessoes.php";
require_once "libs/db_usuariosonline.php";
require_once "dbforms/db_funcoes.php";
require_once "classes/db_isstipoisen_classe.php";
$clisstipoisen = new cl_isstipoisen;
$clrotulo = new rotulocampo;
$clrotulo->label('DBtxt12');
$clrotulo->label('DBtxt13');
$clrotulo->label('DBtxt21');
$clrotulo->label('DBtxt22');
$clrotulo->label('q147_tipo');
$clrotulo->label('q147_descr');
db_postmemory($HTTP_POST_VARS);
?>

<html lang="">
<head>
    <title>DBSeller Informática Ltda - Página Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <script type="text/javascript" src="scripts/scripts.js"></script>
    <?php
    if (isset($ordem)) {
        if (isset($campos)) {
            $xcampo = '';
            $tamanho = sizeof($campos);
            $virgula = '';
            for ($i = 0; $i < $tamanho; $i++) {
                $xcampo .= $virgula . $campos[$i];
                $virgula = "-";
            }
        }
    }
    ?>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body class="body-default">
<div class="container">
    <fieldset style="width: 800px; margin: 0 auto;">
        <legend><strong>Filtros: </strong></legend>
        <form name="form1" method="post" action="">
            <table class="table-container" style="border: none; margin: 0 auto;">
                <tr>
                    <td nowrap="">
                        <strong>Tipo da data:</strong>
                    </td>
                    <td>
                        <select style="width: 235px;" name="tipodata">
                            <option value="dtinc">Data de Inclusão da Isenção</option>
                            <option value="dtini">Data de Inicio da Isenção</option>
                            <option value="dtfim">Data de Fim da Isenção</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td nowrap="" title="Intervalo entre as datas de inclusão das isenções">
                        <strong>Período:</strong></td>
                    <td>
                        <?php
                        db_inputdata('DBtxt21','','','',true,'text',4);
                        ?>
                        Até
                        <?php
                        db_inputdata('DBtxt22','','','',true,'text',4);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap><strong>Ordem: </strong></td>
                    <td>
                        <select style="width: 105px;" name="order">
                            <option value="z01_nome">por nome</option>
                            <option value="matricula">por inscrição</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td nowrap colspan="2"
                        title="Escolha os tipos de isenções a serem listados ou deixe em branco para listar todos">
                        <fieldset>
                            <Legend>Selecione os Tipos</legend>
                            <table border="0">
                                <tr>
                                    <td nowrap title="<?= $Tq147_tipo ?>" colspan="2">
                                        <?php
                                        db_ancora($Lq147_tipo, "js_pesquisaisencao(true);", 2);
                                        ?>
                                        <?php
                                        db_input('q147_tipo', 8, $Iq147_tipo, true, 'text', 2, " onchange='js_pesquisaisencao(false);'")
                                        ?>
                                        <?php
                                        db_input('q147_descr', 25, $Iq147_descr, true, 'text', 3, '')
                                        ?>
                                        <input name="lanca" type="button" value="Lançar">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;">

                                        <select name="campos[]" id="campos" size="7" style="width:250px"
                                                multiple>
                                            <?php
                                            if (isset($chavepesquisa)) {

                                                $resulta = $clisstipoisen->sql_record($clisstipoisen->sql_query($chavepesquisa, "", "q147_tipo,q147_descr", ""));

                                                if ($clisstipoisen->numrows != 0) {
                                                    $numrows = $clisstipoisen->numrows;
                                                    for ($i = 0; $i < $numrows; $i++) {
                                                        db_fieldsmemory($resulta, $i);
                                                        echo "<option value=\"$q147_tipo \">$q147_descr</option>";
                                                    }

                                                }


                                            }
                                            ?>

                                        </select>
                                    </td>
                                    <td style="text-align: left;">
                                        <img style="cursor:hand" onClick="js_sobe();return false;"
                                             src="skins/img.php?file=Controles/seta_up.png" alt=""/>
                                        <br/><br/>
                                        <img style="cursor:hand" onClick="js_desce()"
                                             src="skins/img.php?file=Controles/seta_down.png" alt=""/>
                                        <br/><br/>
                                        <img style="cursor:hand" onClick="js_excluir()"
                                             src="skins/img.php?file=Controles/bt_excluir.png" alt=""/>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center" colspan="2">
                        <input  name="emite2" id="emite2" type="button" value="Processar" onClick="js_emite();">
                    </td>
                </tr>
            </table>
        </form>
    </fieldset>
    <?php
    db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
    ?>
</div>
</body>
</html>

<script type="text/javascript">
    function js_pesquisaisencao(mostra) {
        document.form1.lanca.onclick = "";
        parent.bstatus.document.getElementById('st').innerHTML = '<font size="2" color="darkblue"><b>Processando<blink>...</blink></b></font>';
        if (mostra === true) {
            db_iframe.jan.location.href = 'func_isstipoisen.php?funcao_js=parent.js_mostraisencao1|q147_tipo|q147_descr';
            db_iframe.mostraMsg();
            db_iframe.show();
            db_iframe.focus();
        } else {
            db_iframe.jan.location.href = 'func_isstipoisen.php?pesquisa_chave=' + document.form1.q147_tipo.value + '&funcao_js=parent.js_mostraisencao';
        }
    }

    function js_mostraisencao(chave, erro) {
        document.form1.q147_descr.value = chave;
        if (erro === true) {
            document.form1.q147_tipo.focus();
            document.form1.q147_tipo.value = '';
        } else {
            document.form1.lanca.onclick = js_insSelect;
        }
        parent.bstatus.document.getElementById('st').innerHTML = "Configuração -> Documentos";

    }

    function js_mostraisencao1(chave1, chave2) {
        document.form1.q147_tipo.value = chave1;
        document.form1.q147_descr.value = chave2;
        db_iframe.hide();
        document.form1.lanca.onclick = js_insSelect;
    }

    function js_pesquisa() {
        db_iframe.mostraMsg();
        db_iframe.show();
        db_iframe.focus();
    }

    function js_preenchepesquisa(chave) {
        db_iframe.hide();
        location.href = '<?=basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])?>' + "?chavepesquisa=" + chave;
    }
    function js_sobe() {
        const F = document.getElementById("campos");
        if (F.selectedIndex !== -1 && F.selectedIndex > 0) {
            const SI = F.selectedIndex - 1;
            const auxText = F.options[SI].text;
            const auxValue = F.options[SI].value;
            F.options[SI] = new Option(F.options[SI + 1].text, F.options[SI + 1].value);
            F.options[SI + 1] = new Option(auxText, auxValue);
            js_trocacordeselect();
            F.options[SI].selected = true;
        }
    }

    function js_desce() {
        const F = document.getElementById("campos");
        if (F.selectedIndex !== -1 && F.selectedIndex < (F.length - 1)) {
            const SI = F.selectedIndex + 1;
            const auxText = F.options[SI].text;
            const auxValue = F.options[SI].value;
            F.options[SI] = new Option(F.options[SI - 1].text, F.options[SI - 1].value);
            F.options[SI - 1] = new Option(auxText, auxValue);
            js_trocacordeselect();
            F.options[SI].selected = true;
        }
    }

    function js_excluir() {
        const F = document.getElementById("campos");
        const SI = F.selectedIndex;
        if (F.selectedIndex !== -1 && F.length > 0) {
            F.options[SI] = null;
            js_trocacordeselect();
            if (SI <= (F.length - 1))
                F.options[SI].selected = true;
        }
    }

    function js_insSelect() {
        let texto = document.form1.q147_descr.value;
        let valor = document.form1.q147_tipo.value;
        if (texto !== "" && valor !== "") {
            const F = document.getElementById("campos");
            let testa = false;

            for (let x = 0; x < F.length; x++) {

                if (F.options[x].value === valor || F.options[x].text === texto) {
                    testa = true;
                    break;
                }
            }
            if (testa === false) {
                F.options[F.length] = new Option(texto, valor);
                js_trocacordeselect();
            }
        }
        texto = document.form1.q147_descr.value = "";
        valor = document.form1.q147_tipo.value = "";
        document.form1.lanca.onclick = '';
    }

    function js_emite() {

        const mes1 = Number(document.form1.DBtxt21_mes.value);
        const val1 = new Date(document.form1.DBtxt21_ano.value, mes1 - 1, document.form1.DBtxt21_dia.value, 0, 0, 0);
        const mes2 = Number(document.form1.DBtxt22_mes.value);
        const val2 = new Date(document.form1.DBtxt22_ano.value, mes2 - 1, document.form1.DBtxt22_dia.value, 0, 0, 0);
        if (val1.valueOf() > val2.valueOf()) {
            alert('Data inicial maior que data final. Verifique!');
            return false;
        }
        const F = document.getElementById("campos").options;
        for (let i = 0; i < F.length; i++) {
            F[i].selected = true;
        }

        const H = document.getElementById("campos").options;
        let campo = '';
        if (H.length > 0) {
            campo = 'campo=';
            let virgula = '';
            for (let i = 0; i < H.length; i++) {
                campo += virgula + H[i].value;
                virgula = '-';
            }
        }
        const jan = window.open('iss2_relisentos002.php?' + campo + '&order=' + document.form1.order.value + '&datai=' + document.form1.DBtxt21_ano.value + '-' + document.form1.DBtxt21_mes.value + '-' + document.form1.DBtxt21_dia.value + '&dataf=' + document.form1.DBtxt22_ano.value + '-' + document.form1.DBtxt22_mes.value + '-' + document.form1.DBtxt22_dia.value + '&tipodata=' + document.form1.tipodata.value, '', 'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ');
        jan.moveTo(0, 0);
    }
</script>
<?php
$func_iframe = new janela('db_iframe', '');
$func_iframe->posX = 1;
$func_iframe->posY = 20;
$func_iframe->largura = 780;
$func_iframe->altura = 430;
$func_iframe->titulo = 'Pesquisa';
$func_iframe->iniciarVisivel = false;
$func_iframe->mostrar();

if (isset($ordem)) {
    echo "<script>
       js_emite();
       </script>";
}
?>
