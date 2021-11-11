<?php

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_issbase_classe.php");
include("classes/db_iptubase_classe.php");
include("classes/db_cgm_classe.php");
db_postmemory($HTTP_SERVER_VARS);
db_postmemory($HTTP_POST_VARS);
$db_botao = 1;
$db_opcao = 1;
$cliptubase = new cl_iptubase;
$clrotulo = new rotulocampo;
$clrotulo->label("q02_inscr");
$clrotulo->label("z01_nome");
$clrotulo->label("dv05_numcgm");
$clrotulo->label("j01_matric");
$clrotulo->label("dv05_coddiver");
$clrotulo->label("dv09_procdiver");
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        <!--
        td {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        input {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            height: 17px;
            border: 1px solid #999999;
        }

        -->
    </style>
</head>
<body bgcolor=#CCCCCC>
<form class="container" name="form1" method="post" action="dvr3_consdiversos002.php"
      onSubmit="return js_verifica_campos_digitados();">
    <fieldset>
        <legend>Consulta de Diversos</legend>
        <table class="form-container">
            <tr>
                <td>
                    <?php
                    db_ancora($Ldv05_coddiver, 'js_diver(true); ', 1);
                    ?>
                </td>
                <td>
                    <?php
                    db_input('dv05_coddiver', 5, $Idv05_coddiver, true, 'text', 1, "onchange='js_diver(false)'");
                    db_input('z01_nome', 40, 0, true, 'text', 3, "", "z01_nomediver");
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    db_ancora($Ldv05_numcgm, ' js_cgm(true); ', 1);
                    ?>
                </td>
                <td>
                    <?php
                    db_input('dv05_numcgm', 5, $Idv05_numcgm, true, 'text', 1, "onchange='js_cgm(false)'", "dv05_numcgm");
                    db_input('z01_nome', 40, 0, true, 'text', 3, "", "z01_nomecgm");
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    db_ancora($Lj01_matric, ' js_matri(true); ', 1);
                    ?>
                </td>
                <td>
                    <?php
                    db_input('j01_matric', 5, $Ij01_matric, true, 'text', 1, "onchange='js_matri(false)'");
                    db_input('z01_nome', 40, 0, true, 'text', 3, "", "z01_nomematri");
                    ?>
                </td>
            </tr>

            <tr>
                <td>
                    <?php
                    db_ancora($Lq02_inscr, ' js_inscr(true); ', 1);
                    ?>
                </td>
                <td>
                    <?php
                    db_input('q02_inscr', 5, $Iq02_inscr, true, 'text', 1, "onchange='js_inscr(false)'");
                    db_input('z01_nome', 40, 0, true, 'text', 3, "", "z01_nomeinscr");
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    db_ancora($Ldv09_procdiver, 'js_proc(true); ', 1);
                    ?>
                </td>
                <td>
                    <?php
                    db_input('dv09_procdiver', 5, $Idv09_procdiver, true, 'text', 1, "onchange='js_proc(false)'");
                    db_input('z01_nome', 40, 0, true, 'text', 3, "", "z01_nomeproc");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="À partir de qual data">
                    Data inicial
                </td>
                <td>
                    <?php
                    db_inputdata('dataini', "", "", "", true, 'text', 1)
                    ?>
                    <b>até</b>
                    <?php
                    db_inputdata('datafim', "", "", "", true, 'text', 1)
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <input type="submit" name="pesquisar" value="Pesquisar">
</form>

<?php
db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
?>
</body>
</html>
<script>
    function js_proc(mostra) {
        var proc = document.form1.dv09_procdiver.value;
        if (mostra == true) {
            js_OpenJanelaIframe('top.corpo', 'db_iframe', 'func_procdiver.php?funcao_js=parent.js_mostraproc|dv09_procdiver|dv09_descr', 'Pesquisa', true);
        } else {
            js_OpenJanelaIframe('top.corpo', 'db_iframe', 'func_procdiver.php?pesquisa_chave=' + proc + '&funcao_js=parent.js_mostraproc1', 'Pesquisa', false);
        }
    }

    function js_mostraproc(chave1, chave2) {
        document.form1.dv09_procdiver.value = chave1;
        document.form1.z01_nomeproc.value = chave2;
        db_iframe.hide();
    }

    function js_mostraproc1(chave, erro) {
        document.form1.z01_nomeproc.value = chave;
        if (erro == true) {
            document.form1.dv09_procdiver.focus();
            document.form1.dv09_procdiver.value = '';
        }
    }

    function js_diver(mostra) {
        var diver = document.form1.dv05_coddiver.value;
        if (mostra == true) {
            js_OpenJanelaIframe('top.corpo', 'db_iframe', 'func_diversos.php?funcao_js=parent.js_mostradiver|dv05_coddiver|dv05_numcgm', 'Pesquisa', true);
        } else {
            js_OpenJanelaIframe('top.corpo', 'db_iframe', 'func_diversos.php?pesquisa_chave=' + diver + '&funcao_js=parent.js_mostradiver1', 'Pesquisa', false);
        }
    }

    function js_mostradiver(chave1, chave2) {
        document.form1.dv05_coddiver.value = chave1;
        document.form1.z01_nomediver.value = chave2;
        db_iframe.hide();
    }

    function js_mostradiver1(chave, erro) {
        document.form1.z01_nomediver.value = chave;
        if (erro == true) {
            document.form1.dv05_coddiver.focus();
            document.form1.dv05_coddiver.value = '';
        }
    }


    function js_matri(mostra) {
        var matri = document.form1.j01_matric.value;
        if (mostra == true) {
            js_OpenJanelaIframe('top.corpo', 'db_iframe3', 'func_iptubase.php?funcao_js=parent.js_mostramatri|j01_matric|z01_nome', 'Pesquisa', true);
        } else {
            js_OpenJanelaIframe('top.corpo', 'db_iframe3', 'func_iptubase.php?pesquisa_chave=' + matri + '&funcao_js=parent.js_mostramatri1', 'Pesquisa', false);
        }
    }

    function js_mostramatri(chave1, chave2) {
        document.form1.j01_matric.value = chave1;
        document.form1.z01_nomematri.value = chave2;
        db_iframe3.hide();
    }

    function js_mostramatri1(chave, erro) {
        document.form1.z01_nomematri.value = chave;
        if (erro == true) {
            document.form1.j01_matric.focus();
            document.form1.j01_matric.value = '';
        }
    }


    function js_inscr(mostra) {
        var inscr = document.form1.q02_inscr.value;
        if (mostra == true) {
            js_OpenJanelaIframe('top.corpo', 'db_iframe', 'func_issbase.php?funcao_js=parent.js_mostrainscr|q02_inscr|z01_nome', 'Pesquisa', true);
        } else {
            js_OpenJanelaIframe('top.corpo', 'db_iframe', 'func_issbase.php?pesquisa_chave=' + inscr + '&funcao_js=parent.js_mostrainscr1', 'Pesquisa', false);
        }
    }

    function js_mostrainscr(chave1, chave2) {
        document.form1.q02_inscr.value = chave1;
        document.form1.z01_nomeinscr.value = chave2;
        db_iframe.hide();
    }

    function js_mostrainscr1(chave, erro) {
        document.form1.z01_nomeinscr.value = chave;
        if (erro == true) {
            document.form1.q02_inscr.focus();
            document.form1.q02_inscr.value = '';
        }
    }


    function js_cgm(mostra) {
        var cgm = document.form1.dv05_numcgm.value;
        if (mostra == true) {
            js_OpenJanelaIframe('top.corpo', 'db_iframe2', 'func_nome.php?funcao_js=parent.js_mostracgm|0|1', 'Pesquisa', true);
        } else {
            js_OpenJanelaIframe('top.corpo', 'db_iframe2', 'func_nome.php?pesquisa_chave=' + cgm + '&funcao_js=parent.js_mostracgm1', 'Pesquisa', false);
        }
    }

    function js_mostracgm(chave1, chave2) {
        document.form1.dv05_numcgm.value = chave1;
        document.form1.z01_nomecgm.value = chave2;
        db_iframe2.hide();
    }

    function js_mostracgm1(erro, chave) {
        document.form1.z01_nomecgm.value = chave;
        if (erro == true) {
            document.form1.dv05_numcgm.focus();
            document.form1.dv05_numcgm.value = '';
        }
    }

</script>
<?php
if (isset($dado) && $dado == "inscr") {
    db_msgbox(_M("tributario.diversos.drv3_consdiversos001.inscricao_invalida"));
}
if (isset($dado) && $dado == "matric") {
    db_msgbox(_M("tributario.diversos.drv3_consdiversos001.matricula_invalida"));
}
if (isset($dado) && $dado == "numcgm") {
    db_msgbox(_M("tributario.diversos.drv3_consdiversos001.numcgm_invalido"));
}
$func_iframe = new janela('db_iframe', '');
$func_iframe->posX = 1;
$func_iframe->posY = 20;
$func_iframe->largura = 780;
$func_iframe->altura = 430;
$func_iframe->titulo = 'Pesquisa';
$func_iframe->iniciarVisivel = false;
$func_iframe->mostrar();
?>
<script>

    $("dv05_coddiver").addClassName("field-size2");
    $("z01_nomediver").addClassName("field-size7");
    $("dv05_numcgm").addClassName("field-size2");
    $("z01_nomecgm").addClassName("field-size7");
    $("j01_matric").addClassName("field-size2");
    $("z01_nomematri").addClassName("field-size7");
    $("q02_inscr").addClassName("field-size2");
    $("z01_nomeinscr").addClassName("field-size7");
    $("dv09_procdiver").addClassName("field-size2");
    $("z01_nomeproc").addClassName("field-size7");
    $("dataini").addClassName("field-size2");
    $("datafim").addClassName("field-size2");

</script>
