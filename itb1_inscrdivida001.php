<?php

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("classes/db_arretipo_classe.php");
require_once("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clarretipo = new cl_arretipo;
$clrotulo   = new rotulocampo;
$clrotulo->label("k00_tipo");

?>
<html lang="pt-br">
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
    <style type="text/css">
        select {
            width: 50%;
        }
    </style>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body class="body-default" onload="alert('Esta rotina importa todos os débitos de ITBI para dívida ativa. Utilize-a com cuidado! Se você não tem certeza do que está fazendo, não faça sem entrar em contato com o suporte ou com o responsável pelo CPD da prefeitura!')">

<?php
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
<div class="container">
    <form name="form1" method="post">
        <fieldset>
            <legend>Importar Dívidas (ITBI)</legend>
            <table class="form-container">
                <tr>
                    <td nowrap title="<?=$Tk00_tipo?>">Tipo de origem:</td>
                    <td nowrap>
                        <select name="tipor" id="tipor" onchange='js_habilita();' >
                            <option value="0" >Escolha origem</option>
                            <?php

                            $sSql = <<<SQL
                                SELECT arretipo.k00_tipo,
                                          arretipo.k00_descr
                                   FROM arretipo
                                   INNER JOIN cadtipo ON cadtipo.k03_tipo = arretipo.k03_tipo
                                   WHERE cadtipo.k03_parcano IS TRUE
                                     AND arretipo.k00_instit = 1
                                     AND cadtipo.k03_tipo = 8
                                   ORDER BY k00_tipo
SQL;
                            $result  = $clarretipo->sql_record($sSql);
                            $numrows = $clarretipo->numrows;
                            for($i=0;$i<$numrows;$i++){

                                db_fieldsmemory($result,$i,true);
                                echo " <option value=\"$k00_tipo\" >$k00_descr</option> ";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="">Débitos a serem importados:</td>
                    <td nowrap>
                        <select disabled name="parc" id="parc" onchange='js_habilita();' >
                            <option selected value="t">Totalmente vencidas</option>
                        </select>
                    </td>
                </tr>
                <tr id='data_vencidas'>
                    <td nowrap>Parcelas vencidas até:</td>
                    <td nowrap>
                        <?php
                        $datavenc_dia = date('d',db_getsession("DB_datausu"));
                        $datavenc_mes = date('m',db_getsession("DB_datausu"));
                        $datavenc_ano = date('Y',db_getsession("DB_datausu"));
                        db_inputdata('datavenc',$datavenc_dia,$datavenc_mes,$datavenc_ano,true,'text',1);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="Processos registrado no sistema?">Processo do Sistema:</td>
                    <td nowrap>
                        <?php
                        $lProcessoSistema = true;
                        db_select('lProcessoSistema', array(true=>'SIM', false=>'NÃO'), true, 1, "onchange='js_processoSistema()'")
                        ?>
                    </td>
                </tr>
                <tr id="processoSistema">
                    <td nowrap title="<?=@$Tp58_codproc?>">
                        <?php
                        db_ancora('Processo:', 'js_pesquisaProcesso(true)', 1);
                        ?>
                    </td>
                    <td nowrap>
                        <?php
                        db_input('v01_processo', 10, false, true, 'text', 1, 'onchange="js_pesquisaProcesso(false)"') ;
                        db_input('p58_requer', 40, false, true, 'text', 3);
                        ?>
                    </td>
                </tr>
                <tr id="processoExterno1" style="display: none;">
                    <td nowrap title="Número do processo externo">Processo:</td>
                    <td nowrap>
                        <?php
                        db_input('v01_processoExterno', 10, "", true, 'text', 1, null, null, null, "background-color: rgb(230, 228, 241);") ;
                        ?>
                    </td>
                </tr>
                <tr id="processoExterno2" style="display: none;">
                    <td nowrap title="Titular do processo">Titular do Processo:</td>
                    <td nowrap>
                        <?php
                        db_input('v01_titular', 54, 'false', true, 'text', 1) ;
                        ?>
                    </td>
                </tr>
                <tr id="processoExterno3" style="display: none;">
                    <td nowrap title="Data do processo">Data do Processo:</td>
                    <td nowrap>
                        <?php
                        db_inputdata('v01_dtprocesso', @$v01_dtprocesso_dia, @$v01_dtprocesso_mes, @$v01_dtprocesso_ano, true, 'text', 1);
                        ?>
                    </td>
                </tr>
            </table>
        </fieldset>
        <input name="pesquisa" type="button" onclick="js_abre();" disabled  value="Pesquisa" />
    </form>
</div>
</body>
</html>
<script type="text/javascript">

    /*
     * FUNCOES DE PESQUISA
     */
    function js_pesquisaProcesso(lMostra) {

        if (lMostra) {
            js_OpenJanelaIframe('','db_iframe_matric', 'func_protprocesso.php?funcao_js=parent.js_mostraProcesso|p58_codproc|z01_nome','Pesquisa',true);
        } else {
            js_OpenJanelaIframe('','db_iframe_matric', 'func_protprocesso.php?pesquisa_chave='+document.form1.v01_processo.value+'&funcao_js=parent.js_mostraProcessoHidden','Pesquisa',false);
        }

    }
    function js_mostraProcesso(iCodProcesso, sRequerente) {

        document.form1.v01_processo.value = iCodProcesso;
        document.form1.p58_requer.value  = sRequerente;
        db_iframe_matric.hide();
    }

    function js_mostraProcessoHidden(iCodProcesso, sNome, lErro) {

        if(lErro === true) {

            document.form1.v01_processo.value = "";
            document.form1.p58_requer.value   = sNome;
        } else {
            document.form1.p58_requer.value   = sNome;
        }
    }

    /**
     * funcao que trata se o processo é externo ou interno
     */
    function js_processoSistema() {

        const lProcessoSistema = $F('lProcessoSistema');

        if (lProcessoSistema === 1) {

            document.getElementById('processoExterno1').style.display = 'none';
            document.getElementById('processoExterno2').style.display = 'none';
            document.getElementById('processoExterno3').style.display = 'none';
            document.getElementById('processoSistema').style.display  = '';
            $('v01_processo').value = "";
            $('p58_requer').value   = "";
        }	else {

            document.getElementById('processoExterno1').style.display = '';
            document.getElementById('processoExterno2').style.display = '';
            document.getElementById('processoExterno3').style.display = '';
            document.getElementById('processoSistema').style.display  = 'none';
        }

    }

    function js_habilita(){

        const sDebimporta = document.getElementById('parc').value;

        if (sDebimporta === 'a') {
            document.getElementById('data_vencidas').style.display = 'none';
        }else{
            document.getElementById('data_vencidas').style.display = '';
        }

        document.form1.pesquisa.disabled = document.form1.tipor.value === 0;
    }
    function js_abre(){

        let data = '';

        if (document.form1.datavenc_dia.value === '' ||
            document.form1.datavenc_mes.value === '' || document.form1.datavenc_ano.value === ''){
            alert("Informe corretamente a data do vencimento.");
            return;
        } else {
            data = document.form1.datavenc_ano.value+'-'+document.form1.datavenc_mes.value+'-'+document.form1.datavenc_dia.value;
        }

        if (confirm('Tem certeza de que quer importar mesmo todos os registros do tipo de debitos escolhido?') === true) {

            if (confirm('Tem certeza mesmo?') === true) {
                if (document.form1.tipor.value===0) {
                    alert("Informe corretamente o tipo origem");
                } else {

                    const lProcessoSistema = parseInt($F('lProcessoSistema'));
                    let iProcesso = "";
                    let sTitular = "";
                    let dDataProcesso = "";

                    if (lProcessoSistema === 1) {

                        iProcesso     = $F('v01_processo');
                        sTitular      = "";
                        dDataProcesso = "";
                    } else {

                        iProcesso     = $F('v01_processoExterno');
                        sTitular      = $F("v01_titular");
                        dDataProcesso = $F("v01_dtprocesso");
                    }

                    const oProcesso = {};
                    oProcesso.lProcessoSistema = lProcessoSistema;
                    oProcesso.iProcesso        = iProcesso;
                    oProcesso.sTitular         = sTitular;
                    oProcesso.dDataProcesso    = dDataProcesso;

                    js_OpenJanelaIframe('top.corpo','db_iframe','itb1_inscrdivida002.php?oProcesso='+Object.toJSON(oProcesso)+'&k00_tipo_or='+document.form1.tipor.value+'&tipoparc='+document.form1.parc.value+'&datavenc='+data,'Pesquisa',true);
                }
            }
        }
    }

    $("v01_processo").addClassName("field-size2");
    $("p58_requer").addClassName("field-size9");
    $("lProcessoSistema").setAttribute("rel","ignore-css");
    $("lProcessoSistema").addClassName("field-size2");
    $("v01_processoExterno").addClassName("field-size2");
    $("v01_titular").addClassName("field-size9");
    $("v01_dtprocesso").addClassName("field-size2");
    $("datavenc").addClassName("field-size2");
    $("parc").setAttribute("rel","ignore-css");
    $("parc").addClassName("field-size5");
    $("tipor").setAttribute("rel","ignore-css");
    $("tipor").addClassName("field-size5");
</script>
