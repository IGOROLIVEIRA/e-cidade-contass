<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBselller Servicos de Informatica
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
require_once("dbforms/db_funcoes.php");
require_once("classes/db_itbi_classe.php");
require_once("classes/db_itbirural_classe.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");

db_postmemory($HTTP_POST_VARS);

$clitbi = new cl_itbi;
$clitbirural = new cl_itbirural;
$clrotulo = new rotulocampo;

$clitbi->rotulo->label();
$clitbirural->rotulo->label();
$clrotulo->label('DBtxt23');
$clrotulo->label('DBtxt25');
$clrotulo->label('DBtxt27');
$clrotulo->label('DBtxt28');

$clrotulo->label("j34_setor");
$clrotulo->label("j34_quadra");
$clrotulo->label("j34_lote");

?>
<html lang="">
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <?php
    db_app::load('grid.style.css');
    db_app::load('estilos.css');
    ?>
</head>
<body bgcolor=#CCCCCC leftmargin='0' topmargin='0' marginwidth='0' marginheight='0' onLoad='a=1' bgcolor='#cccccc'>
<form name='form1' method='post' action=''>
    <table align='center' border='0' width='100%'>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table align='center' cellpadding='0' cellspacing='0'>
                    <tr>
                        <td>
                            <fieldset>
                                <legend>
                                    <b>Resumo de ITBI</b>
                                </legend>
                                <table border='0'>
                                    <tr>
                                        <td align='right'>
                                            <?php
                                            db_ancora('<b>Guia :</b>', 'js_pesquisait01_guia(true);', 1);
                                            ?>
                                        </td>
                                        <td width='20'>
                                            <?php
                                            db_input('it01_guia_ini', 15, $Iit01_guia, true, 'text', 1, " onchange='js_pesquisait01_guia(false);'");
                                            ?>
                                        </td>
                                        <td align='center'>
                                            <b> a </b>
                                        </td>
                                        <td>
                                            <?php
                                            db_input('it01_guia_fim', 15, $Iit01_guia, true, 'text', 1, '');
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align='right'>
                                            <b>Periodo de :</b>
                                        </td>
                                        <td width='20'>
                                            <?php
                                            db_inputdata('dtIni', '', '', '', true, 'text', 1, '');
                                            ?>
                                        </td>
                                        <td align='center'>
                                            <b> a </b>
                                        </td>
                                        <td>
                                            <?php
                                            db_inputdata('dtFim', '', '', '', true, 'text', 1, '');
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align='right'>
                                            <b>Vencimento de :</b>
                                        </td>
                                        <td width='20'>
                                            <?php
                                            db_inputdata('dtVencIni', '', '', '', true, 'text', 1, '');
                                            ?>
                                        </td>
                                        <td align='center'>
                                            <b> a </b>
                                        </td>
                                        <td>
                                            <?php
                                            db_inputdata('dtVencFim', '', '', '', true, 'text', 1, '');
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align='right'>
                                            <b>Logradouro :</b>
                                        </td>
                                        <td colspan='3'>
                                            <?php
                                            db_input('logradouroid', 40, '', true, 'hidden', 3);
                                            db_input('it18_nomelograd', 40, $Iit18_nomelograd, true, 'text', 1);
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align='right'>
                                            <b>Ordem :</b>
                                        </td>
                                        <td colspan='3'>
                                            <?php
                                            $aOrdem = array('g' => 'Guia',
                                                'v' => 'Valor',
                                                'n' => 'Nome');
                                            db_select('ordem', $aOrdem, true, 2, " style='width:275px;'");
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align='right'>
                                            <b>Modo :</b>
                                        </td>
                                        <td colspan='3'>
                                            <table border='0' width='100%'>
                                                <tr>
                                                    <td width='50%'>
                                                        <input type='radio' name='modoOrdem' value='asc' checked>Ascendente</input>
                                                        <br>
                                                        <input type='radio' name='modoOrdem'
                                                               value='desc'>Descendente</input>
                                                    </td>
                                                    <td width='50%'>
                                                        <input type='radio' name='modoImp' value='anal' checked>Análitico</input>
                                                        <br>
                                                        <input type='radio' name='modoImp'
                                                               value='sint'>Sintético</input>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align='right'>
                                            <b>Tipo :</b>
                                        </td>
                                        <td colspan='3'>
                                            <?php
                                            $aTipo = array('t' => 'Todos',
                                                'u' => 'Urbano',
                                                'r' => 'Rural');

                                            db_select('tipo', $aTipo, true, 2, " style='width:275px;'");
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align='right'>
                                            <b>Situaçao:</b>
                                        </td>
                                        <td colspan='3'>
                                            <?php
                                            $aSituacao = array('1' => 'Todos',
                                                '2' => 'Aberto',
                                                '3' => 'Pago',
                                                '4' => 'Cancelado',
                                                '5' => 'Inscrito D.A');
                                            db_select('situacao', $aSituacao, true, 2, " style='width:275px;'");
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align='right'>
                                            <b>Liberadas:</b>
                                        </td>
                                        <td colspan='3'>
                                            <?php
                                            $aLiberadas = array('t' => 'Todos',
                                                's' => 'Sim',
                                                'n' => 'Não');
                                            db_select('liberadas', $aLiberadas, true, 2, " style='width:275px;'");
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align='right' nowrap title="<?= @$Tj34_setor ?>">
                                            <?= $Lj34_setor ?>
                                        </td>
                                        <td colspan='3'>
                                            <?php
                                            db_input('j34_setor', 10, $Ij34_setor, true, 'text', 1);
                                            ?>
                                            <?= $Lj34_quadra ?>
                                            <?php
                                            db_input('j34_quadra', 10, $Ij34_quadra, true, 'text', 1);
                                            ?>

                                            <?= $Lj34_lote ?>
                                            <?php
                                            db_input('j34_lote', 10, $Ij34_lote, true, 'text', 1);
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table align='center'>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <input name='emitir' id='emitir' type='button' value='Processar'
                                               onclick='js_validar();'>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>
<?php
db_menu(db_getsession('DB_id_usuario'), db_getsession('DB_modulo'), db_getsession('DB_anousu'), db_getsession('DB_instit'));
db_app::load('scripts.js');
db_app::load('prototype.js');
db_app::load('datagrid.widget.js');
db_app::load('strings.js');
db_app::load('/widgets/dbautocomplete.widget.js');
?>

<script>

    const inputDtIni = document.querySelector('#dtIni');
    const inputDtFim = document.querySelector('#dtFim');
    const inputVencDtIni = document.querySelector('#dtVencIni');
    const inputVencDtFim = document.querySelector('#dtVencFim');
    const inputOrdem = document.querySelector('#ordem');
    const inputTipo = document.querySelector('#tipo');
    const inputSituacao = document.querySelector('#situacao');
    const inputLiberadas = document.querySelector('#liberadas');
    const inputGuiaIni = document.querySelector('#it01_guia_ini');
    const inputGuiaFim = document.querySelector('#it01_guia_fim');
    const inputLogradouro = document.querySelector('#it18_nomelograd');
    const inputLogradouroId = document.querySelector('#logradouroid');
    const inputSetor = document.querySelector('#j34_setor');
    const inputQuadra = document.querySelector('#j34_quadra');
    const inputLote = document.querySelector('#j34_lote');

    const js_emite = () => {

        let iInd;
        let sModo = null;
        let sModoImp = null;
        const dtIni = inputDtIni.value;
        const dtFim = inputDtFim.value;
        const dtVencIni = inputVencDtIni.value;
        const dtVencFim = inputVencDtFim.value;
        const sOrdem = inputOrdem.value;
        const sTipo = inputTipo.value;
        const sSituacao = inputSituacao.value;
        const sLiberadas = inputLiberadas.value;
        const guiaIni = inputGuiaIni.value;
        const guiaFim = inputGuiaFim.value;
        const sLogradouro = inputLogradouro.value;
        const sSetor = inputSetor.value;
        const sQuadra = inputQuadra.value;
        const sLote = inputLote.value;

        const aObjModo = document.getElementsByName('modoOrdem');
        for (iInd = 0; iInd < aObjModo.length; iInd++) {
            if (aObjModo[iInd].checked) {
                sModo = aObjModo[iInd].value;
            }
        }

        const aObjModoImp = document.getElementsByName('modoImp');
        for (iInd = 0; iInd < aObjModoImp.length; iInd++) {
            if (aObjModoImp[iInd].checked) {
                sModoImp = aObjModoImp[iInd].value;
            }
        }

        let sQuery = '?ordem=' + sOrdem;
        sQuery += '&modo=' + sModo;
        sQuery += '&modoimp=' + sModoImp;
        sQuery += '&dtini=' + dtIni;
        sQuery += '&dtfim=' + dtFim;
        sQuery += '&dtVencini=' + dtVencIni;
        sQuery += '&dtVemcfim=' + dtVencFim;
        sQuery += '&tipo=' + sTipo;
        sQuery += '&situacao=' + sSituacao;
        sQuery += '&liberadas=' + sLiberadas;
        sQuery += '&guiaini=' + guiaIni;
        sQuery += '&guiafim=' + guiaFim;
        sQuery += '&sLogradouro=' + sLogradouro;
        sQuery += '&sSetor=' + sSetor;
        sQuery += '&sQuadra=' + sQuadra;
        sQuery += '&sLote=' + sLote;

        const sUrl = 'itb2_relresumoitbi002.php' + sQuery;

        const sParam = 'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ';
        const jan = window.open(sUrl, '', sParam);
        jan.moveTo(0, 0);
    }

    inputLogradouro.style.width = '275px';

    oAutoComplete = new dbAutoComplete(inputLogradouro, 'itb2_pesquisalogradouro.RPC.php');
    oAutoComplete.setTxtFieldId(inputLogradouroId);
    oAutoComplete.show();

    function js_validar() {
        js_emite();
    }

    function js_pesquisait01_guia(mostra) {

        const sUrl1 = 'func_itbi.php?funcao_js=parent.js_mostrarit01_guia|it01_guia';
        const sUrl2 = 'func_itbi.php?pesquisa_chave=' + inputGuiaIni.value + '&funcao_js=parent.js_mostrarit01_guia1';

        if (mostra === true) {
            js_OpenJanelaIframe('', 'db_iframe_itbi', sUrl1, 'Pesquisa', true);
        } else {

            if (inputGuiaIni.value !== '') {
                js_OpenJanelaIframe('', 'db_iframe_itbi', sUrl2, 'Pesquisa', false);
            } else {
                inputGuiaIni.value = '';
            }
        }
    }

    function js_mostrarit01_guia1(chave, erro) {

        if (erro === true) {

            alert(chave);
            inputGuiaIni.value = '';
            inputGuiaIni.focus();

        } else {
            inputGuiaIni.value = chave;
        }
    }

    function js_mostrarit01_guia(chave) {

        inputGuiaIni.value = chave;
        db_iframe_itbi.hide();

    }
</script>
</body>
</html>
