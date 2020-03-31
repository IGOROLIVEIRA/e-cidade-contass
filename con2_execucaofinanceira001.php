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
<form name="form1" id="form1">
    <input type="hidden" id="iNumeroEmpenhoInicial" />
    <input type="hidden" id="iNumeroEmpenhoFinal"   />
    <br><br>
    <fieldset>
        <legend><b>Execução Financeira</b></legend>
        <table>

            <tr>
                <td colspan="4">
                    <div id="sContainer" style="width: 615px;"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <b>Período:</b>
                </td>
                <td colspan="3">
                    <?php
                    db_inputdata('dtVigenciaInicial', '', '', '', true, 'text', 1, "");
                    echo " <b>a</b> ";
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
            <tr>
                <td>
					<?php db_ancora('Depto. de Inclusão:', "js_pesquisa_depart(true);", 1); ?>
                </td>
                <td>
					<?php
					db_input("coddeptoinc", 10, $Icoddepto, true, "text", 4, "style='width: 90px;'onchange='js_pesquisa_depart(false);'");
					?>
                </td>
                <td>
                    <?php db_input("descrdeptoinc", 50, $Idescrdepto, true, "text", 3);?>
                </td>
            </tr>
            <tr>
                <td>
					<?php db_ancora('Depto. Responsável',"js_pesquisa_departamento(true);",1); ?>
                </td>
                <td>
					<?php
					db_input('coddeptoresp',10,'',true,'text',4," style='width: 90px;'onchange='js_pesquisa_departamento(false);'");
					?>
                </td>
                <td>
                    <?php db_input('descrdeptoresp', 50, '', true, 'text', 3,"",""); ?>
                </td>
            </tr>

        </table>
    </fieldset>

    <p>
        <input type="button" name="btnImprimir" id="btnImprimir" value="Imprimir" onclick="js_imprimir()"/>
    </p>
</form>
</center>
</body>
</html>

<?php
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
<script type="text/javascript">

    /**
     * Lançador de contratos
     */
    function js_criarDBLancador() {

        oLancadorContrato = new DBLancador("oLancadorContrato");
        oLancadorContrato.setNomeInstancia("oLancadorContrato");
        oLancadorContrato.setLabelAncora("Código acordo: ");
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
        var iDepartInclusao       = $F("coddeptoinc");
        var iDepartResponsavel    = $F("coddeptoresp");
        var oContratos            = oLancadorContrato.getRegistros();
        var aContratos            = new Array();

        for (var iContrato = 0; iContrato < oContratos.length; iContrato++) {
            aContratos.push(oContratos[iContrato].sCodigo);
        }

        // if(aContratos.length != 0 && iFornecedor != ''){
        //     alert("Não foi retornado nenhum registro para a seleção.");
        //     return false;
        // }

        if(aContratos.length == 0 && iFornecedor == '' && !iDepartInclusao && !iDepartResponsavel){
            alert("Selecione uma opção de filtro (Acordo, Fornecedor ou Departamento)");
            return false;
        }

        if (dtVigenciaInicial != '' && dtVigenciaFinal != '') {

            if( !js_comparadata(dtVigenciaInicial, dtVigenciaFinal, '<=') ) {

                alert("A vigência de Início deve ser maior ou igual a vigência de Fim!");
                return false;
            }
        }

        var sQuery  = "";
        sQuery += "?dtVigenciaInicial="     + dtVigenciaInicial;
        sQuery += "&dtVigenciaFinal="       + dtVigenciaFinal;
        sQuery += "&fornecedor="            + iFornecedor;
        sQuery += "&aContratos="            + aContratos;
        sQuery += "&departInclusao="        + iDepartInclusao;
        sQuery += "&departResponsavel="     + iDepartResponsavel;

        var oJanela = window.open('con2_execucaofinanceira002.php' + sQuery, 'relatorioexecfinanacordo',
            'width='+(screen.availWidth-5)+', height='+(screen.availHeight-40)+', scrollbars=1, location=0');
        oJanela.moveTo(0,0);
        return true;
    }

    function js_pesquisa_depart(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_db_depart', 'func_db_depart.php?funcao_js=parent.js_mostradepart1|coddepto|descrdepto', 'Pesquisa', true);
        } else {
            if (document.form1.coddeptoinc.value != '') {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_db_depart', 'func_db_depart.php?pesquisa_chave=' + document.form1.coddeptoinc.value + '&funcao_js=parent.js_mostradepart', 'Pesquisa', false);
            } else {
                document.form1.descrdeptoinc.value = '';
            }
        }
    }
    function js_mostradepart(chave, erro) {
        document.form1.descrdeptoinc.value = chave;
        if (erro == true) {
            document.form1.coddeptoinc.focus();
            document.form1.coddeptoinc.value = '';
        }
    }
    function js_mostradepart1(chave1, chave2) {
        document.form1.coddeptoinc.value = chave1;
        document.form1.descrdeptoinc.value = chave2;
        db_iframe_db_depart.hide();
    }

    function js_pesquisa_departamento(mostra){
        if (mostra==true) {
            js_OpenJanelaIframe('top.corpo','db_iframe_departamento','func_departamento.php?funcao_js=parent.js_mostradepartamento1|coddepto|descrdepto','Pesquisa',true);
        } else {
            if (document.form1.coddeptoresp.value != '') {
                js_OpenJanelaIframe('','db_iframe_departamento','func_departamento.php?pesquisa_chave='+document.form1.coddeptoresp.value+'&funcao_js=parent.js_mostradepartamento','Pesquisa',false);
            } else {
                document.form1.descrdeptoresp.value = '';
            }
        }
    }

    function js_mostradepartamento1(chave1, chave2, erro) {
        document.form1.coddeptoresp.value = chave1;
        document.form1.descrdeptoresp.value = chave2;
        db_iframe_departamento.hide();
    }

    function js_mostradepartamento(chave1,erro) {
        if(!erro){
            document.form1.descrdeptoresp.value = chave1;
        }
        db_iframe_departamento.hide();
    }

    js_criarDBLancador();

    let codDepartInc = document.getElementById('coddeptoinc');
    let codDepartResp = document.getElementById('coddeptoresp');

    codDepartInc.addEventListener('keyup', (e) => {
        js_verificaTipo(e.target);
    });

    codDepartResp.addEventListener('keyup', (e) => {
        js_verificaTipo(e.target);
    });

    function js_verificaTipo(obj){
        if(/[aA-zZ]/.test(obj.value)){
            alert('Insira somente números');
            document.getElementById(obj.id).value = '';
            return false;
        }
    }

</script>
