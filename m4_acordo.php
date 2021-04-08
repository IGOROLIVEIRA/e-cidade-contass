<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_utils.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_acordo_classe.php");
require_once("classes/db_acordoacordogarantia_classe.php");
require_once("classes/db_acordoacordopenalidade_classe.php");
require_once("classes/db_acordoitem_classe.php");
require_once("classes/db_acordoaux_classe.php");
require_once("classes/db_parametroscontratos_classe.php");

$clacordo = new cl_acordo;

$clacordo->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("ac17_sequencial");
$clrotulo->label("descrdepto");
$clrotulo->label("ac02_sequencial");
$clrotulo->label("ac08_descricao");
$clrotulo->label("ac50_descricao");
$clrotulo->label("z01_nome");
$clrotulo->label("ac16_licitacao");
$clrotulo->label("l20_objeto");


parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

//$cliframe_seleciona = new cl_iframe_seleciona;

if(isset($alterar)){
    $sqlerro=false;
    db_inicio_transacao();
    //print_r($_POST);exit;


    $rsPosicoes = db_query(
                "SELECT distinct ac26_sequencial as POSICAO
        FROM acordo
        inner join acordoposicao on  ac16_sequencial = ac26_acordo
        inner join acordoposicaoperiodo on ac36_acordoposicao = ac26_sequencial
        inner join acordovigencia on ac18_acordoposicao = ac26_sequencial
        inner join acordoposicaotipo on ac27_sequencial = ac26_acordoposicaotipo
        inner join acordoitem on ac20_acordoposicao = ac26_sequencial
        inner join acordoitemperiodo on ac20_sequencial = ac41_acordoitem
        WHERE ac16_sequencial = '$ac16_sequencial'"
    );
    //db_criatabela($rsPosicoes);exit;
    for ($iCont = 0; $iCont < pg_num_rows($rsPosicoes); $iCont++) {
        $oPosicao = db_utils::fieldsMemory($rsPosicoes, $iCont);
        //print_r($oPosicao->posicao);
        $rsPosicoes = db_query(
            "SELECT distinct ac26_sequencial as POSICAO
        FROM acordo
        inner join acordoposicao on  ac16_sequencial = ac26_acordo
        inner join acordoposicaoperiodo on ac36_acordoposicao = ac26_sequencial
        inner join acordovigencia on ac18_acordoposicao = ac26_sequencial
        inner join acordoposicaotipo on ac27_sequencial = ac26_acordoposicaotipo
        inner join acordoitem on ac20_acordoposicao = ac26_sequencial
        inner join acordoitemperiodo on ac20_sequencial = ac41_acordoitem
        WHERE ac16_sequencial = '$ac16_sequencial'"
        );
        db_criatabela($rsPosicoes);exit;
    }
    exit;

    if(pg_num_rows($rsVerify) == 0){
        db_inicio_transacao();
        //$cl_scripts->excluiEmpenho($e60_numemp);
        echo "<script>alert(\"".$cl_scripts->erro_msg."\");</script>";
        //echo "<script>alert(\"periodo vazio\");</script>";
        db_fim_transacao();
    }


    //$clacordo->alterar($ac16_sequencial);
    if($clacordo->erro_status==0){
        $sqlerro=true;
    }
    $erro_msg = $clacordo->erro_msg;
    db_fim_transacao($sqlerro);
    $db_opcao = 2;
    $db_botao = true;
}else if(isset($chavepesquisa)) {
    $db_opcao = 2;
    $db_botao = true;
    $result = $clacordo->sql_record($clacordo->sql_query($chavepesquisa));
    db_fieldsmemory($result,0);
}

?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <?
    db_app::load("scripts.js, strings.js, prototype.js,datagrid.widget.js, widgets/dbautocomplete.widget.js");
    db_app::load("widgets/windowAux.widget.js, widgets/DBToogle.widget.js");
    ?>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
    <style>

        .fora {background-color: #d1f07c;}
        #fieldset_depart_inclusao, #fieldset_depart_responsavel {
            width: 500px;
        }

        #fieldset_depart_inclusao table, #fieldset_depart_responsavel table{
            margin: 0 auto;
        }
    </style>
</head>
<body bgcolor="#CCCCCC">
<?php
$sContass = explode(".",db_getsession("DB_login"));

if ($sContass[1] == 'contass') {

    echo "<br><center><br><H2>Essa rotina apenas pode ser usada por usuários da contass</h2></center>";
} else {
?>

<form name='form1' method="post" action="" onsubmit="return confirm('Deseja realmente alterar?');">
    <div class="container">
        <fieldset>
            <legend><b></b></legend>
            <table>
                <tr>
                    <td nowrap title="<?php echo $Tac16_sequencial; ?>" width="130">
                        <?php db_ancora($Lac16_sequencial, "js_acordo(true);",1); ?>
                    </td>
                    <td colspan="2">
                        <?php
                        db_input('ac16_sequencial', 10, $Iac16_sequencial, true, 'text', 1, "onchange='js_acordo(false);'");
                        db_input('ac16_resumoobjeto', 40, $Iac16_resumoobjeto, true, 'text', 3);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Tac16_numeroacordo ?>">
                        <?= @$Lac16_numeroacordo ?>
                    </td>
                    <td>
                        <?
                        //$ac16_numeroacordo = $ac16_numeroacordo != "" ? $ac16_numeroacordo : Acordo::getProximoNumeroDoAno($ac16_anousu,db_getsession('DB_instit'));
                        db_input('ac16_numeroacordo', 10, $Iac16_numeroacordo, true, 'text', $db_opcao);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <fieldset class='fieldsetinterno'>
                            <legend>
                                <b>Vigência</b>
                            </legend>
                            <table cellpadding="0" border="0" width="100%" class="table-vigencia">
                                <tr>
                                    <td width="1%">
                                        <b>Inicio:</b>
                                    </td>
                                    <td>
                                        <?
                                        $iCampo = 2;

                                        db_inputdata('ac16_datainicio', @$ac16_datainicio_dia, @$ac16_datainicio_mes,
                                            @$ac16_datainicio_ano, true, 'text', $iCampo,
                                            "onchange='return js_somardias();'", "", "",
                                            "return parent.js_somardias();");
                                        ?>
                                    </td>
                                    <td>
                                        <b>Fim:</b>
                                    </td>
                                    <td>
                                        <?

                                        db_inputdata('ac16_datafim', @$ac16_datafim_dia, @$ac16_datafim_mes, @$ac16_datafim_ano,
                                            true, 'text', $iCampo, "onchange='return js_somardias();'",
                                            "", "", "return parent.js_somardias();");
                                        ?>
                                    </td>
                                    <td>
                                        <b>Dias:</b>
                                    </td>
                                    <td>
                                        <?
                                        db_input('diasvigencia', 10, "", true, 'text', 3);
                                        ?>
                                    </td>
                                </tr>
<!--                                <tr>-->
<!--                                    <td nowrap title="Prazo de Execução">-->
<!--                                        <strong>Unid.Execução/Entrega:</strong>-->
<!--                                    </td>-->
<!--                                    <td>-->
<!--                                        --><?//
//                                        db_input('ac16_qtdperiodo', 2, @$Iac16_qtdperiodo, true, 'text', $db_opcao,
//                                            "", "", "");
//                                        $aTipoUnidades = array_merge(array(0=>'Selecione'), getValoresPadroesCampo("ac16_tipounidtempoperiodo"));
//
//                                        db_select("ac16_tipounidtempoperiodo", $aTipoUnidades,
//                                            true, $db_opcao);
//                                        ?>
<!--                                    </td>-->
<!--                                </tr>-->
                            </table>
                        </fieldset>
                    </td>
                </tr>
            </table>
        </fieldset>
        <input name="alterar" type="submit" id="alterar" value="Alterar" <?=($db_botao==false?"disabled":"")?> >
    </div>
</form>
</div>

</body>
</html>
    <div style='position:absolute;top: 200px; left:15px;
            border:1px solid black;
            width:400px;
            text-align: left;
            padding:3px;
            z-index:10000;
            background-color: #FFFFCC;
            display:none;' id='ajudaItem'>

    </div>
    <script>

        function js_acordo(mostra){
            if(mostra==true){
                js_OpenJanelaIframe('','db_iframe_acordo',
                    'func_acordoinstit.php?funcao_js=parent.js_mostraAcordo1|ac16_sequencial|z01_nome',
                    'Pesquisa',true);
            }else{
                if($F('ac16_sequencial').trim() != ''){
                    js_OpenJanelaIframe('','db_iframe_depart',
                        'func_acordoinstit.php?pesquisa_chave='+$F('ac16_sequencial')+'&funcao_js=parent.js_mostraAcordo'+
                        '&descricao=true',
                        'Pesquisa',false);
                }else{
                    $('ac16_resumoobjeto').value = '';
                }
            }
        }
        function js_mostraAcordo(chave, descricao, erro){

            $('ac16_resumoobjeto').value = descricao;
            if(erro==true){
                $('ac16_sequencial').focus();
                $('ac16_sequencial').value = '';
            }

            <?
            echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave;";
            ?>
        }
        function js_mostraAcordo1(chave1,chave2){
            $('ac16_sequencial').value = chave1;
            $('ac16_resumoobjeto').value = chave2;
            db_iframe_acordo.hide();

            <?
            echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave1;";
            ?>
        }

        function js_somardias() {
            alert('here');
            var sDataInicio = $('ac16_datainicio').value;
            var sDataFim = $('ac16_datafim').value;

            if (js_somarDiasVigencia(sDataInicio, sDataFim) != false) {
                $('diasvigencia').value = js_somarDiasVigencia(sDataInicio, sDataFim);
            }
        }
    </script>
<?
}
?>
