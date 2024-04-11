<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_acordo_classe.php");
require_once("classes/db_parametroscontratos_classe.php");
db_postmemory($_POST);
parse_str($_SERVER["QUERY_STRING"]);
$clacordo = new cl_acordo;
$clacordo->rotulo->label();

$colunasFiltros = [
    'ac16_sequencial'       => 'chave_ac16_sequencial',
    'ac16_numeroacordo'     => 'ac16_numeroacordo',
    'ac16_coddepto'         => 'coddeptoinc',
    'ac16_deptoresponsavel' => 'coddeptoresp',
    'ac16_acordogrupo'      => 'ac16_acordogrupo'
];

$filtros = [];
$estadoBusca = false;

foreach($colunasFiltros as $key => $valor) {
    if (!empty(${$valor})) {
        $estadoBusca =true;
        $filtros[$key] = ${$valor};
    }
}

$sql = $clacordo->queryAcordosComAditamento($filtros);

?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/DBAncora.widget.js"></script>

    <link href="estilos.css" rel="stylesheet" type="text/css">

</head>

<body style="background-color: #CCCCCC">

    <div class="container">
        <form name="form2" method="post" action="">
            <fieldset>
                <legend class="bold">Filtros</legend>

                <table border="0" align="center" cellspacing="0">
                    <tr>
                        <td width="4%" align="left" nowrap title="<?php echo $Tac16_sequencial; ?>">
                            <?php echo $Lac16_sequencial; ?>
                        </td>
                        <td width="96%" align="left" nowrap>
                            <?php
                            db_input("ac16_sequencial", 10, $Iac16_sequencial, true, "text", 4, "", "chave_ac16_sequencial");
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td width="4%" align="left" nowrap title="<?php echo $Tac16_numeroacordo; ?>" class="bold">
                            Número do Acordo:
                        </td>
                        <td width="96%" align="left" nowrap>
                            <?php db_input("ac16_numeroacordo", 10, 0, true, "text", 4); ?>
                        </td>
                    </tr>

                    <tr>
                        <td nowrap title="<?php echo @$Tac16_acordogrupo; ?>" class="bold" align="">
                            <?php
                            db_ancora("Grupo:", "js_pesquisaac16_acordogrupo(true);", 1);
                            ?>
                        </td>
                        <td>
                            <?php
                            db_input('ac16_acordogrupo', 10, $Iac16_acordogrupo, true, 'text', 1, "onchange='js_pesquisaac16_acordogrupo(false);'");
                            db_input('ac02_descricao', 30, "", true, 'text', 3);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php db_ancora('Depto. de Inclusão:', "js_pesquisa_depart(true);", 1); ?>
                        </td>
                        <td>
                            <?php
                            db_input("coddeptoinc", 10, $Icoddepto, true, "text", 4, "style='width: 90px;'onchange='js_pesquisa_depart(false);'");
                            ?>

                            <?php db_input("descrdeptoinc", 50, $Idescrdepto, true, "text", 3); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php db_ancora('Depto. Responsável', "js_pesquisa_departamento(true);", 1); ?>
                        </td>
                        <td>
                            <?php
                            db_input('coddeptoresp', 10, '', true, 'text', 4, " style='width: 90px;'onchange='js_pesquisa_departamento(false);'");
                            ?>

                            <?php db_input('descrdeptoresp', 50, '', true, 'text', 3, "", ""); ?>
                        </td>
                    </tr>
                </table>

            </fieldset>
            <p align="center">
                <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
                <input name="limpar" type="reset" id="limpar" value="Limpar">
                <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_acordo.hide();">
            </p>

        </form>
    </div>

    <fieldset style="width: 98%">
        <legend class="bold">Registros</legend>



        <table height="100%" border="0" align="center" cellspacing="0" bgcolor="#CCCCCC">
            <tr>
                <td align="center" valign="top">
                    <?php db_lovrot($sql, 15, "()", "", $funcao_js, "", "NoMe", []); ?>
                </td>
            </tr>
        </table>
    </fieldset>
</body>

</html>
<?php
if ($estadoBusca) {
?>
    <script>

    </script>
<?php
}
?>
<script>
    /**
     * Formata numero / ano de um elemento html
     *
     * @param {object} elemento
     * @returns {void}
     */
    function js_formatarNumeroAno(elemento) {

        /**
         * Formata a cada tecla digitada
         *
         * @param {object} elemento
         * @returns {boolean}
         */
        elemento.onkeypress = function(event) {

            var iTecla = event.keyCode ? event.keyCode : event.charCode;
            var sTecla = String.fromCharCode(iTecla);

            /**
             * Nao permite por 2x '/' ou como primeiro caracter
             */
            if (sTecla == '/') {

                if (this.value.indexOf('/') !== -1 || this.value == '') {
                    return false;
                }
            }

            return js_mask(event, "0-9|/");
        };
    }

    js_formatarNumeroAno(document.getElementById('ac16_numeroacordo'));

    js_tabulacaoforms("form2", "chave_ac16_sequencial", true, 1, "chave_ac16_sequencial", true);

    function js_pesquisaac16_acordogrupo(mostra) {

        if (mostra == true) {

            var sUrl = 'func_acordogrupo.php?funcao_js=parent.js_mostraacordogrupo1|ac02_sequencial|ac02_descricao';
            js_OpenJanelaIframe('',
                'db_iframe_acordogrupo',
                sUrl,
                'Pesquisa de Grupo de Acordo',
                true,
                '0');

        } else {

            if ($('ac16_acordogrupo').value != '') {

                js_OpenJanelaIframe('',
                    'db_iframe_acordogrupo',
                    'func_acordogrupo.php?pesquisa_chave=' + $('ac16_acordogrupo').value +
                    '&funcao_js=parent.js_mostraacordogrupo',
                    'Pesquisa de Grupo de Acordo',
                    false,
                    '0');
            } else {
                $('ac02_sequencial').value = '';
            }
        }
    }

    function js_mostraacordogrupo(chave, erro) {

        $('ac02_descricao').value = chave;
        if (erro == true) {

            $('ac16_acordogrupo').focus();
            $('ac16_acordogrupo').value = '';
        }
    }

    function js_mostraacordogrupo1(chave1, chave2) {

        $('ac16_acordogrupo').value = chave1;
        $('ac02_descricao').value = chave2;
        $('ac16_acordogrupo').focus();

        db_iframe_acordogrupo.hide();
    }

    function js_pesquisa_depart(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('', 'db_iframe_db_depart', 'func_db_depart.php?funcao_js=parent.js_mostradepart1|coddepto|descrdepto', 'Pesquisa', true);
        } else {
            if (document.form1.coddeptoinc.value != '') {
                js_OpenJanelaIframe('', 'db_iframe_db_depart', 'func_db_depart.php?pesquisa_chave=' + document.form1.coddeptoinc.value + '&funcao_js=parent.js_mostradepart', 'Pesquisa', false);
            } else {
                $('descrdeptoinc').value = '';
            }
        }
    }

    function js_mostradepart(chave, erro) {
        $('descrdeptoinc').value = chave;
        if (erro == true) {
            $('coddeptoinc').focus();
            $('coddeptoinc').value = '';
        }
    }

    function js_mostradepart1(chave1, chave2) {
        $('coddeptoinc').value = chave1;
        $('descrdeptoinc').value = chave2;
        db_iframe_db_depart.hide();
    }

    function js_pesquisa_departamento(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('', 'db_iframe_departamento', 'func_departamento.php?funcao_js=parent.js_mostradepartamento1|coddepto|descrdepto', 'Pesquisa', true);
        } else {
            if ($('coddeptoresp').value != '') {
                js_OpenJanelaIframe('', 'db_iframe_departamento', 'func_departamento.php?pesquisa_chave=' + $('coddeptoresp').value + '&funcao_js=parent.js_mostradepartamento', 'Pesquisa', false);
            } else {
                $('descrdeptoresp').value = '';
            }
        }
    }

    function js_mostradepartamento1(chave1, chave2, erro) {
        $('coddeptoresp').value = chave1;
        $('descrdeptoresp').value = chave2;
        db_iframe_departamento.hide();
    }

    function js_mostradepartamento(chave1, erro) {
        if (!erro) {
            $('descrdeptoresp').value = chave1;
        }
        db_iframe_departamento.hide();
    }
</script>
