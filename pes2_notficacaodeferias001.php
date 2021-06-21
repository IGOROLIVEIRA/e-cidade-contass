<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_utils.php");
require_once("dbforms/db_funcoes.php");

db_postmemory($HTTP_POST_VARS);
$clrhpesrescisao = new cl_rhpesrescisao;
$rotulocampo = new rotulocampo;

$rotulocampo->label("rh01_regist");
$rotulocampo->label("rh02_seqpes");
$rotulocampo->label("z01_nome");
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script src="scripts/scripts.js"></script>
    <script src="scripts/strings.js"></script>
    <script src="scripts/prototype.js"></script>
    <script src="scripts/arrays.js"></script>
    <script src="scripts/datagrid.widget.js"></script>
    <script src="scripts/widgets/dbcomboBox.widget.js"></script>
    <script src="scripts/widgets/dbtextField.widget.js"></script>
    <script src="scripts/classes/DBViewFiltrosRelatorioNtfFerias.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        #datai{
            width: 78px;
        }
    </style>
</head>
<body class="body-default">
<div class="container">
    <form name="form1" method="post" action="" >
        <fieldset>
            <legend>Notificação de Férias</legend>

            <table>
                <tr>
                    <td>
                        <strong>Data Notificação: </strong>
                    </td>
                    <td>
                        <?
                        db_inputdata('dtnotificacao',null, null, null, true, 'text', 1);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td align="left" nowrap title="Digite o Ano / Mes de competência" >
                        <strong>Períodos de gozo: </strong>
                    </td>
                    <td>
                        <?
                        db_inputdata('inicioperiodo',null, null, null, true, 'text', 1);
                        ?>
                        <strong> á </strong>
                        <?
                        db_inputdata('fimperiodo',null, null, null, true, 'text', 1);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" id="containnerTipoFiltrosFolha"></td>
                </tr>
            </table>
        </fieldset>

        <input name="relatorio" id="relatorio" type="button" value="Processar" onclick="js_emite();" >

    </form>
</div>

<?php
db_menu( db_getsession("DB_id_usuario"),
    db_getsession("DB_modulo"),
    db_getsession("DB_anousu"),
    db_getsession("DB_instit") );
?>
</body>
<script>
    var oTiposFiltrosFolha;

    (function() {

        /**
         * Monta os componentes para o formulario
         */
        oTiposFiltrosFolha     = new DBViewFormularioFolha.DBViewTipoFiltrosFolha(<?=db_getsession("DB_instit")?>);
        oTiposFiltrosFolha.sInstancia     = 'oTiposFiltrosFolha';

        /**
         * Renderiza os componentes em seus respectivos contaners
         */
        oTiposFiltrosFolha.show($('containnerTipoFiltrosFolha'));

    })();

    function js_emite() {
        var oCboTipoRelatorio = $F('oCboTipoRelatorio');

        if(oCboTipoRelatorio != 0){

            var oLancadorSelecionado = oTiposFiltrosFolha.getLancadorAtivo().getRegistros();

            if (oLancadorSelecionado.length == 0) {
                alert('Por Favor, realize pelo menos o lançamento de 1 registro.');
                return false
            }
        }

        oQuery = '?dtnotificacao='   + $F('dtnotificacao');
        oQuery +='&dtinicio='        + $F('inicioperiodo');
        oQuery +='&dtfim='           + $F('fimperiodo');
        oQuery +='&tiporegistro='    + $F('oCboTipoRelatorio');

        if(oCboTipoRelatorio != 0) {
            var aSelecionados = [];
            var oTipoFiltros = oTiposFiltrosFolha.getLancadorAtivo().getRegistros();

            /**
             * Percorre os itens selecionados no lancador
             */
            selecionados = "";
            virgula_ssel = "";
            oTipoFiltros.each(function (oFiltro, iIndice) {
                selecionados+= virgula_ssel +oFiltro.sCodigo;
                virgula_ssel = ",";
            });

            oQuery += '&iRegistros=' + selecionados;
        }
        console.log(oQuery);
        jan = window.open( 'pes2_notficacaodeferias002.php' + oQuery,
            '',
            'width=' + (screen.availWidth-5) + ',height='+(screen.availHeight-40) + ',scrollbars=1,location=0 ' );
        jan.moveTo(0,0);

        js_limparCampos();
    }

</script>
</html>