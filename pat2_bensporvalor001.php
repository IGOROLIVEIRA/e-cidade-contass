<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2013  DBselller Servicos de Informatica
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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_bens_classe.php");
include("libs/db_utils.php");
include("dbforms/db_classesgenericas.php");
include("classes/db_cfpatri_classe.php");
include("classes/db_db_depart_classe.php");
include("classes/db_departdiv_classe.php");
include("libs/db_app.utils.php");
include("classes/db_empnota_classe.php");

$clrotulo       = new rotulocampo;
$cldb_depart    = new cl_db_depart;
$clcfpatric     = new cl_cfpatri;
$clbens         = new cl_bens;
$cldepartdiv    = new cl_departdiv;
$clsituabens    = new cl_situabens;

// ocorrência 2505
$clrotulo->label("e69_codnota");
$clrotulo->label("e69_numero");
$clrotulo->label("z01_nome");
$clrotulo->label("t53_empen");
$clrotulo->label("t04_sequencial");
$clbens->rotulo->label();
$cldb_depart->rotulo->label();

db_postmemory($HTTP_POST_VARS);

//Verifica se utiliza pesquisa por orgão sim ou não
$t06_pesqorgao = "f";
$resPesquisaOrgao = $clcfpatric->sql_record($clcfpatric->sql_query_file(null, 't06_pesqorgao'));
if ($clcfpatric->numrows > 0) {
    db_fieldsmemory($resPesquisaOrgao, 0);
}

$aSituacaoBens = array('Selecione');
$resultadoClsituabens = db_utils::getCollectionByRecord(db_query($clsituabens->sql_query()));

$indice = 1;
foreach ($resultadoClsituabens as $resSiBens) {
    $aSituacaoBens[$indice] .= $resSiBens->t70_descr;
    $indice++;
}
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <?php
    db_app::load('scripts.js');
    db_app::load('prototype.js');
    db_app::load('estilos.css');
    ?>
</head>
<body bgcolor=#CCCCCC>
<form class="container" name="form1" method="post" action="">
    <fieldset>
        <legend>Relatório - Bens Valor por Período</legend>
        <table class="form-container">
            <tr>
                <td>
                    <strong>Mês:</strong>
                </td>
                <td align="left" nowrap>
                    <?php
                    db_input("mes", 10, $iMes, true, "text", 4, "");
                    ?>
                    <strong>Ano:</strong>
                    <?php
                    db_input("ano", 10, $iAno, true, "text", 4, "");
                    ?>
                </td>
            </tr>
            <tr>
                <td align="right" nowrap title="<?= $Tcoddepto ?>">
                    <?php db_ancora(@$Lcoddepto, "js_pesquisa_depart(true);", $db_opcao); ?>
                </td>
                <td align="left" nowrap>
                    <?php
                    db_input("coddepto", 10, $Icoddepto, true, "text", 4, "onchange='js_pesquisa_depart(false);'");
                    db_input("descrdepto", 50, $Idescrdepto, true, "text", 3);
                    ?>
                </td>
            </tr>
            <tr>
                <td><b>Tipo bens:</b></td>
                <td nowrap>
                    <?php
                    $aTipobens = ['1' => 'Móveis','2' => 'Imóveis','3' => 'Semoventes'];
                    db_select("iTipobens", $aTipobens, true, 1); ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <input type="button" value="Emitir" onClick="js_emite();">
</form>
<?php
db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
?>
</body>
</html>
<script>

    document.getElementById('ano').addEventListener('input', function(event) {
        // Remove caracteres não numéricos
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    document.getElementById('mes').addEventListener('input', function(event) {
        // Remove caracteres não numéricos
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function js_emite() {
        let query = "";

        let departamento = document.getElementById('coddepto').value;

        query += 'codigoDepartamento=' + departamento;

        let mes = document.getElementById('mes').value;

        if (mes.trim() === '') {
            alert("Campo Mês não Informado.");
            return false
        }

        query += '&mes=' + mes

        let ano = document.getElementById('ano').value;

        if (ano.value === '') {
            alert("Campo Ano não Informado.");
            return false
        }
        query += '&ano=' + ano

        let tipobens = document.getElementById('iTipobens').value;

        query += '&itipobens=' + tipobens;

        var arquivoRelatorio = 'pat2_bensporvalorDepartamento002.php?';

        jan = window.open( arquivoRelatorio + query, '', 'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ');
        jan.moveTo(0, 0);
    }

    function js_pesquisa_depart(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_db_depart', 'func_db_depart.php?funcao_js=parent.js_mostradepart1|coddepto|descrdepto', 'Pesquisa', true);
        } else {
            if (document.form1.coddepto.value != '') {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_db_depart', 'func_db_depart.php?pesquisa_chave=' + document.form1.coddepto.value + '&funcao_js=parent.js_mostradepart', 'Pesquisa', false);
            } else {
                document.form1.descrdepto.value = '';
                document.form1.submit();
            }
        }
    }

    function js_mostradepart(chave, erro) {
        document.form1.descrdepto.value = chave;

        if (erro == true) {
            document.form1.coddepto.focus();
            document.form1.coddepto.value = '';
        } else {
            document.form1.submit();
        }
    }

    function js_mostradepart1(chave1, chave2) {
        document.form1.coddepto.value = chave1;
        document.form1.descrdepto.value = chave2;
        db_iframe_db_depart.hide();
        document.form1.submit();
    }

</script>
