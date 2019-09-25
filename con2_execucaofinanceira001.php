<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_stdlib.php");
require_once("dbforms/db_funcoes.php");

$oRotulo = new rotulocampo();
$oRotulo->label("ac16_deptoresponsavel");
$oRotulo->label("e60_codemp");
$oRotulo->label("ac50_descricao");
$oRotuloAcordo = new rotulo("acordo");
$oRotuloAcordo->label();

?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta http-equiv="Expires" CONTENT="0" />
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/DBAncora.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/DBLancador.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbtextField.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/datagrid.widget.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="width: 600px; margin: 0 auto;">
<center>
    <input type="hidden" id="iNumeroEmpenhoInicial" />
    <input type="hidden" id="iNumeroEmpenhoFinal"   />
    <br><br>
    <fieldset>
        <legend><b>Execu��o Financeira</b></legend>
        <table>

            <tr>
                <td colspan="4">
                    <div id="sContainer" style="width: 615px;"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <b>Per�odo:</b>
                </td>
                <td colspan="3">
                    <?php
                    db_inputdata('dtVigenciaInicial', '', '', '', true, 'text', 1, "");
                    echo " <b>�</b> ";
                    db_inputdata('dtVigenciaFinal', '', '', '', true, 'text', 1, "");
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    db_ancora('<b>Fornecedor:</b>', "onchange=pesquisaFornecedor(true)", 1);
                    ?>
                </td>
                <td>
                    <?php
                    db_input('pc60_numcgm', 10, $Ipc60_numcgm, true, 'text', 1,
                        "style='width: 90px;' onchange=pesquisaFornecedor(false)");
                    ?>
                </td>
                <td>
                    <?php
                    db_input('z01_nome', 50, $Iz01_nome, true, 'text', 3);
                    ?>
                </td>
            </tr>

        </table>
    </fieldset>

    <p>
        <input type="button" name="btnImprimir" id="btnImprimir" value="Imprimir" onclick="js_imprimir()"/>
    </p>
</center>
</body>
</html>

<?php
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
<script type="text/javascript">

    /**
     * Lan�ador de contratos
     */
    function js_criarDBLancador() {

        oLancadorContrato = new DBLancador("oLancadorContrato");
        oLancadorContrato.setNomeInstancia("oLancadorContrato");
        oLancadorContrato.setLabelAncora("C�digo acordo: ");
        oLancadorContrato.setParametrosPesquisa("func_acordoinstit.php", ['ac16_sequencial', 'z01_nome']);
        oLancadorContrato.show($("sContainer"));
    }
    
    function pesquisaFornecedor(lMostra) {

        var sFuncaoPesquisa   = 'func_pcforne.php?funcao_js=parent.js_completaFornecedor|';
        sFuncaoPesquisa  += 'pc60_numcgm|z01_nome';

        if (!lMostra) {

            if ($('pc60_numcgm').value != '') {

                sFuncaoPesquisa   = "func_pcforne.php?pesquisa_chave="+$F('pc60_numcgm');
                sFuncaoPesquisa  += "&iParam=true&funcao_js=parent.js_completaFornecedor2";
            } else {
                $('z01_nome').value = '';
            }
        }
        js_criarDBLancador();
        js_OpenJanelaIframe('top.corpo', 'db_iframe_acordofornecedor', sFuncaoPesquisa, 'Pesquisar Fornecedor',lMostra);
    }
    function js_completaFornecedor(codigo,nome) {
        $('pc60_numcgm').value = codigo;
        $('z01_nome').value  = nome;
        $('pc60_numcgm').focus();
        db_iframe_acordofornecedor.hide();
    }

    function js_completaFornecedor2(codigo,nome) {

        $('z01_nome').value  = nome;
        $('pc60_numcgm').focus();
        db_iframe_acordofornecedor.hide();
    }

    function js_imprimir() {

        var dtVigenciaInicial     = $F("dtVigenciaInicial");
        var dtVigenciaFinal       = $F("dtVigenciaFinal");
        var iFornecedor           = $F("pc60_numcgm");
        var oContratos            = oLancadorContrato.getRegistros();
        var aContratos            = new Array();

        for (var iContrato = 0; iContrato < oContratos.length; iContrato++) {
            aContratos.push(oContratos[iContrato].sCodigo);
        }

        if(aContratos.length != 0 && iFornecedor != ''){
            alert("Mensagem Deborah");
            return false;
        }

        if (dtVigenciaInicial != '' && dtVigenciaFinal != '') {

            if( !js_comparadata(dtVigenciaInicial, dtVigenciaFinal, '<=') ) {

                alert("A vig�ncia de In�cio deve ser maior ou igual a vig�ncia de Fim!");
                return false;
            }
        }

        var sQuery  = "";
        sQuery += "?dtVigenciaInicial="     + dtVigenciaInicial;
        sQuery += "&dtVigenciaFinal="       + dtVigenciaFinal;
        sQuery += "&fornecedor="            + iFornecedor;
        sQuery += "&aContratos="            + aContratos;


        var oJanela = window.open('con2_execucaofinanceira002.php' + sQuery, 'relatorioexecfinanacordo',
            'width='+(screen.availWidth-5)+', height='+(screen.availHeight-40)+', scrollbars=1, location=0');
        oJanela.moveTo(0,0);
        return true;
    }

    js_criarDBLancador();
</script>
