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
$aux_orgao      = new cl_arquivo_auxiliar;
$aux_unidade    = new cl_arquivo_auxiliar;
$aux            = new cl_arquivo_auxiliar;
//$oEmpNota       = new cl_empnota;

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
        <legend>Relatório - Inventário de Bens</legend>
        <table class="form-container">
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
              <td align="right"  nowrap title="Divisão">
                  <?php db_ancora("Divisão","pesquisaCodigoDivisao(true);",$db_opcao); ?>
              </td>
              <td>
                  <?php db_input('t30_codigo',10,$It30_codigo,true,'text',$db_opcao," onchange='pesquisaCodigoDivisao(false);'") ?>
                  <?php db_input('t30_descr',50,'',true,'text',3); ?>
              </td>
            </tr>

            <tr>
              <td align="right"  nowrap title="Convênio">
                  <?php db_ancora("Convênio:","pesquisaConvenio(true);",$db_opcao); ?>
              </td>
              <td>
                  <?php db_input('t04_sequencial',10,$It04_sequencial,true,'text',$db_opcao," onchange='pesquisaConvenio(false);'") ?>
                  <?php db_input('z01_nome_convenio',50,'',true,'text',3); ?>
              </td>
            </tr>

            <tr>
              <td align="right"  nowrap title="Classificação">
                  <?php db_ancora("Classificação:","pesquisaClassificacao(true);",$db_opcao); ?>
              </td>
              <td>
                  <?php db_input('t64_codcla',50,$It64_codcla,true,'hidden',3); ?>
                  <?php db_input('t64_class',10,$It64_class,true,'text',$db_opcao," onchange='pesquisaClassificacao(false);'") ?>
                  <?php db_input('t64_descr',50,$It64_descr,true,'text',3); ?>
              </td>
            </tr>

            <tr>
                <td><?php db_ancora("Código do Bem: ", "pesquisaCodigoBem(true, `inicial`);", 1); ?></td>
                <td>
                    <?php
                    db_input('iCodigoBemInicial',10, true, 1, 'text', 1, "onchange='pesquisaCodigoBem(false, `inicial`);'");
                    ?>
                    <b><?php db_ancora('até', "pesquisaCodigoBem(true, `final`);",1); ?></b>
                    <?php
                    db_input('iCodigoBemFinal', 10, true, 1, 'text', 1, "onchange='pesquisaCodigoBem(false, `final`);'");
                    ?>
                </td>
            </tr>

            <tr>
                <td><?php db_ancora("Placa: ", "pesquisaCodigoPlaca(true, `inicial`);",1); ?></td>
                <td>
                    <?php
                    db_input('iCodigoPlacaInicial',10, true, 1, 'text', 1, "onchange='pesquisaCodigoPlaca(false, `inicial`);'");
                    ?>
                    <b><?php db_ancora('até', "pesquisaCodigoPlaca(true, `final`);",1); ?></b>
                    <?php
                    db_input('iCodigoPlacaFinal', 10, true, 1, 'text', 1, "onchange='pesquisaCodigoPlaca(false, `final`);'");
                    ?>
                </td>
            </tr>

            <tr id="intervalo">
                <td nowrap align="right"><b>Intervalo de Valor:</b>
                <td nowrap>
                    <?php
                    db_input('iIntervaloValorInicial',10,'',true,'text',$db_opcao, 'onchange = "validaIntervaloValor();" onkeypress="return js_mask(event, \'0-9|.\')"');
                    ?>&nbsp;<b>até</b>&nbsp;
                    <?php
                    db_input('iIntervaloValorFinal',10,'',true,'text',$db_opcao, 'onchange = "validaIntervaloValor();" onkeypress="return js_mask(event, \'0-9|.\')"');
                    ?>
                </td>
            </tr>

            <tr id="periodo_aquisicao_inicial">
                <td nowrap align="right"><b>Período de Aquisição Inicial:</b>
                <td nowrap>
                    <?php
                    db_inputdata("iDataAquisicaoInicial", "", "", "", true, "text", 4);
                    ?>
                </td>
            </tr>

            <tr id="periodo_aquisicao_final">
                <td nowrap align="right"><b>Período de Aquisição Final:</b>
                <td nowrap>
                    <?php
                    db_inputdata("iDataAquisicaoFinal", "", "", "", true, "text", 4);
                    ?>
                </td>
            </tr>

            <tr>
                <td><b>Tipo:</b></td>
                <td nowrap>
                    <?php
                    $aTiposBens = array("TODOS", "MÓVEIS", "IMÓVEIS", "SEMOVENTES");


                    db_select("sTipoBem", $aTiposBens, true, 1);
                    ?>
                </td>
            </tr>

            <tr>
                <td align="left" nowrap title="Tipo de Agrupamento do Valor" >
                    <strong>Agrupar por:&nbsp;&nbsp;</strong>
                </td>
                <td>
                    <?php db_input('iAgrupaTipoBem', 50, '', true, 'checkbox', 1);?>
                    <label for='iAgrupaTipoBem' >Tipo do Bem</label><br>
                    <?php db_input('iAgrupaClassificacao', 50, '', true, 'checkbox', 1);?>
                    <label for='iAgrupaClassificacao' >Classificação</label><br>
                    <?php db_input('iAgrupaLocalizacao', 50, '', true, 'checkbox', 1);?>
                    <label for='iAgrupaLocalizacao' >Localização</label><br>
                    <?php db_input('iAgrupaResponsavelDepto', 50, '', true, 'checkbox', 1);?>
                    <label for='iAgrupaResponsavelDepto' >Responsável Dep.</label><br>
                    <?php db_input('iAgrupaDivisao', 50, '', true, 'checkbox', 1);?>
                    <label for='iAgrupaDivisao' >Divisão</label><br>
                    <?php db_input('iAgrupaResponsavelDivisao', 50, '', true, 'checkbox', 1);?>
                    <label for='iAgrupaResponsavelDivisao' >Responável Div.</label>
                </td>
            </tr>

            <tr>
                <td><b>Situação do bem:</b></td>
                <td nowrap>
                    <?php db_select("iSituacaoBem", $aSituacaoBens, true, 1); ?>
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
    document.getElementById("sTipoBem").setAttribute("style","width:110px");
    document.getElementById("iSituacaoBem").setAttribute("style","width:110px");
    let sInicialFinal = '';

    function validaIntervaloValor() {
        if (Number($F("iIntervaloValorInicial")) > Number($F("iIntervaloValorFinal")) && Number($F("iIntervaloValorFinal")) > 0 ) {
            alert('Informe um intervalo final maior que o intervalo inicial ' + Number($F("iIntervaloValorInicial")));
            document.form1.iIntervaloValorFinal.value = "";
        }
    }

    function pesquisaCodigoPlaca(mostra, inicial_final) {
        sInicialFinal = inicial_final;

        if ((typeof sInicialFinal === 'string' && sInicialFinal === 'final')
            && Number($F('iCodigoPlacaInicial')) > Number($F('iCodigoPlacaFinal'))
            && Number($F('iCodigoPlacaFinal')) > 0
        ) {
            alert('Informe um bem final maior que o bem inicial ' + $F('iCodigoPlacaInicial'));

            document.querySelector(
                'form[name="form1"] input[name="iCodigoPlacaFinal"]'
            ).value = '';

            return;
        }

        const sAbreUrl =
            'func_bens.php?funcao_js=parent.preencheEscondeCodigoPlaca|t52_ident';
        const deveAparecer = !!mostra;

        js_OpenJanelaIframe('top.corpo', 'db_iframe_bens', sAbreUrl, 'Pesquisa', deveAparecer);
    }

    function preencheEscondeCodigoPlaca(codigoPlaca) {
        if (codigoPlaca === '') {
            return;
        }

        const codigoPlacaCompara = $F('iCodigoPlacaInicial');

        if ((typeof sInicialFinal === 'string' && sInicialFinal === 'final')
            && Number(codigoPlacaCompara) > Number(codigoPlaca)
        ) {
            alert('Informe uma placa final maior que a placa inicial ' + codigoPlacaCompara);
            return;
        }

        if (typeof sInicialFinal === 'string' && sInicialFinal === 'inicial') {
            document.querySelector(
                'form[name="form1"] input[name="iCodigoPlacaInicial"]'
            ).value = codigoPlaca;
        }

        if (typeof sInicialFinal === 'string' && sInicialFinal === 'final') {
            document.querySelector(
                'form[name="form1"] input[name="iCodigoPlacaFinal"]'
            ).value = codigoPlaca;
        }

        db_iframe_bens.hide();
    }

    function pesquisaCodigoBem(mostra, inicial_final) {
        sInicialFinal = inicial_final;

        if ((typeof sInicialFinal === 'string' && sInicialFinal === 'final')
            && Number($F('iCodigoBemInicial')) > Number($F('iCodigoBemFinal'))
            && Number($F('iCodigoBemFinal')) > 0
        ) {
            alert('Informe um bem final maior que o bem inicial ' + $F('iCodigoBemInicial'));
            document.querySelector(
                'form[name="form1"] input[name="iCodigoBemFinal"]'
            ).value = '';
            return;
        }

        const sAbreUrl =
            'func_bens.php?funcao_js=parent.preencheEscondeCodigoBem|t52_bem';
        const deveAparecer = !!mostra;

        js_OpenJanelaIframe('top.corpo', 'db_iframe_bens', sAbreUrl, 'Pesquisa', deveAparecer);
    }

    function preencheEscondeCodigoBem(codigoBem) {
        if (codigoBem === '') {
            return;
        }

        const codigoBemCompara = $F('iCodigoBemInicial');

        if ((typeof sInicialFinal === 'string' && sInicialFinal === 'final')
            && Number(codigoBemCompara) > Number(codigoBem)
        ) {
            alert('Informe um bem final maior que o bem inicial ' + codigoBemCompara);
            return;
        }

        if (typeof sInicialFinal === 'string' && sInicialFinal === 'inicial') {
            document.querySelector(
                'form[name="form1"] input[name="iCodigoBemInicial"]'
            ).value = codigoBem;
        }

        if (typeof sInicialFinal === 'string' && sInicialFinal === 'final') {
            document.querySelector(
                'form[name="form1"] input[name="iCodigoBemFinal"]'
            ).value = codigoBem;
        }

        db_iframe_bens.hide();
    }

    function js_emite() {
        let query = "";
        const inputDataAquisicaoInicial = document.querySelector('form[name="form1"] input[name="iDataAquisicaoInicial"]');
        const inputDataAquisicaoFinal = document.querySelector('form[name="form1"] input[name="iDataAquisicaoFinal"]');
        let dataAquisicaoInicialCompara = 0;
        let dataAquisicaoFinalCompara = 0;

          if (typeof inputDataAquisicaoInicial.value === 'string' && inputDataAquisicaoInicial.value.trim() !== '') {
              const dataAquisicaoInicial = [
                  document.form1.iDataAquisicaoInicial_ano.value,
                  document.form1.iDataAquisicaoInicial_mes.value,
                  document.form1.iDataAquisicaoInicial_dia.value
              ].join('-');

              dataAquisicaoInicialCompara = new Date(dataAquisicaoInicial);
              dataAquisicaoInicialCompara = dataAquisicaoInicialCompara.getTime();

              query = "dataAquisicaoInicial=" + dataAquisicaoInicial + '&';
          }

          if (typeof inputDataAquisicaoFinal.value === 'string' && inputDataAquisicaoFinal.value.trim() !== '') {
              const dataAquisicaoFinal = [
                  document.form1.iDataAquisicaoFinal_ano.value,
                  document.form1.iDataAquisicaoFinal_mes.value,
                  document.form1.iDataAquisicaoFinal_dia.value
              ].join('-');

              dataAquisicaoFinalCompara = new Date(dataAquisicaoFinal);
              dataAquisicaoFinalCompara = dataAquisicaoFinalCompara.getTime();

              query += "dataAquisicaoFinal=" + dataAquisicaoFinal + '&';
          }

          dataAquisicaoFinalCompara = dataAquisicaoFinalCompara === 0
              ? dataAquisicaoInicialCompara
              : dataAquisicaoFinalCompara

          if (dataAquisicaoInicialCompara > dataAquisicaoFinalCompara) {
              alert(_M("patrimonial.patrimonio.pat2_geralbens001.data_inicial_maior_data_final"));
              return;
          }

          $F('coddepto').trim() === ''
              ? query += "codigoDepartamento=" + 0 + '&'
              : query += "codigoDepartamento=" + document.form1.coddepto.value + '&'
                        + "descricaoDepartamento=" + document.form1.descrdepto.value + '&';

          $F('t30_codigo').trim() === ''
              ? query += ''
              : query += "codigoDivisao=" + document.form1.t30_codigo.value + '&'
                        + "descricaoDivisao=" + document.form1.t30_descr.value + '&';

          $F('t04_sequencial').trim() === ''
              ? query += ''
              : query += "codigoConvenio=" + document.form1.t04_sequencial.value + '&'
                        + "descricaoConvenio=" + document.form1.z01_nome_convenio.value + '&';

          $F('t64_class').trim() === ''
              ? query += ''
              : query += "codigoClassificacao=" + document.form1.t64_codcla.value + '&'
                        +  "classificacao=" + document.form1.t64_class.value + '&'
                        + "descricaoClassificacao=" + document.form1.t64_descr.value + '&';

          const inputCodigoBemInicial = document.querySelector('form[name="form1"] input[name="iCodigoBemInicial"]');
          const inputCodigoBemFinal = document.querySelector('form[name="form1"] input[name="iCodigoBemFinal"]');

          if (typeof inputCodigoBemInicial.value === 'string' && inputCodigoBemInicial.value.trim() !== '') {
              query += "codigoBemInicial=" + inputCodigoBemInicial.value + '&';
          }

          if (typeof inputCodigoBemFinal.value === 'string' && inputCodigoBemFinal.value.trim() !== '') {
              query += "codigoBemFinal=" + inputCodigoBemFinal.value + '&';
          }

          const inputCodigoPlacaInicial = document.querySelector('form[name="form1"] input[name="iCodigoPlacaInicial"]');
          const inputCodigoPlacaFinal = document.querySelector('form[name="form1"] input[name="iCodigoPlacaFinal"]');

          if (typeof inputCodigoPlacaInicial.value === 'string' && inputCodigoPlacaInicial.value.trim() !== '') {
              query += "codigoPlacaInicial=" + inputCodigoPlacaInicial.value + '&';
          }

          if (typeof inputCodigoPlacaFinal.value === 'string' && inputCodigoPlacaFinal.value.trim() !== '') {
              query += "codigoPlacaFinal=" + inputCodigoPlacaFinal.value + '&';
          }

          const inputIntervaloValorInicial = document.querySelector('form[name="form1"] input[name="iIntervaloValorInicial"]');
          const inputIntervaloValorFinal = document.querySelector('form[name="form1"] input[name="iIntervaloValorFinal"]');

          if (typeof inputIntervaloValorInicial.value === 'string' && inputIntervaloValorInicial.value.trim() !== '') {
              query += "intervalorValorInicial=" + inputIntervaloValorInicial.value + '&';
          }

          if (typeof inputIntervaloValorFinal.value === 'string' && inputIntervaloValorFinal.value.trim() !== '') {
              query += "intervalorValorFinal=" + inputIntervaloValorFinal.value + '&';
          }

          const selecaoTipoBem = document.querySelector('form[name="form1"] select[name="sTipoBem"]');
          query += "tipoBem=" + selecaoTipoBem.value + '&';

          const inputAgrupaTipoBem = document.getElementById('iAgrupaTipoBem');
          const inputAgrupaClassificacao = document.getElementById('iAgrupaClassificacao');
          const inputAgrupaLocalizacao = document.getElementById('iAgrupaLocalizacao');
          const inputAgrupaResponsavelDepto = document.getElementById('iAgrupaResponsavelDepto');
          const inputAgrupaDivisao = document.getElementById('iAgrupaDivisao');
          const inputAgrupaResponsavelDivisao = document.getElementById('iAgrupaResponsavelDivisao');

          inputAgrupaTipoBem.checked ? query += 'agrupaTipoBem=' + '1' + '&' : query += '';
          inputAgrupaClassificacao.checked ? query += 'agrupaClassificacao=' + '1' + '&' : query += '';
          inputAgrupaLocalizacao.checked ? query += 'agrupaLocalizacao=' + '1' + '&' : query += '';
          inputAgrupaResponsavelDepto.checked ? query += 'agrupaResponsavelDepto=' + '1' + '&' : query += '';
          inputAgrupaDivisao.checked ? query += 'agrupaDivisao=' + '1' + '&' : query += '';
          inputAgrupaResponsavelDivisao.checked ? query += 'agrupaResponsavelDivisao=' + '1' + '&' : query += '';

          const inputSituacaoBem = document.getElementById('iSituacaoBem');

          inputSituacaoBem.value !== '0' ? query += 'situacaoBem=' + inputSituacaoBem.value + '&' : query += '';

          const arquivoRelatorio = 'pat2_inventariobens002.php?';

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

    function pesquisaCodigoDivisao(mostra) {
        if (typeof mostra === 'boolean' && mostra === true) {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_departdiv', 'func_departdiv.php?funcao_js=parent.escondeIframePesquisaDivisao|t30_codigo|t30_descr', 'Pesquisa', true);
        } else {
            if (document.form1.t04_sequencial.value !== '') {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_departdiv', 'func_departdiv.php?pesquisa_chave=' + document.form1.t30_codigo.value + '&funcao_js=parent.mostraIframePesquisaDivisao', 'Pesquisa', false);
            } else {
                document.form1.t30_descr.value = '';
                document.form1.submit();
            }
        }
    }

    function mostraIframePesquisaDivisao(chave, erro) {
        document.form1.t30_descr.value = chave;
        if (typeof erro === 'boolean' && erro === true) {
            document.form1.t30_codigo.focus();
            document.form1.t30_codigo.value = '';
        } else {
            document.form1.submit();
        }
    }

    function escondeIframePesquisaDivisao(chave1, chave2) {
        document.form1.t30_codigo.value = chave1;
        document.form1.t30_descr.value = chave2;
        db_iframe_departdiv.hide();
        document.form1.submit();
    }


    function pesquisaConvenio(mostra) {
        if (typeof mostra === 'boolean' && mostra === true) {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_benscadcedente', 'func_benscadcedente.php?funcao_js=parent.escondeIframePesquisaConvenio|t04_sequencial|z01_nome', 'Pesquisa', true);
        } else {
            if (document.form1.t04_sequencial.value !== '') {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_benscadcedente', 'func_benscadcedente.php?pesquisa_chave=' + document.form1.t04_sequencial.value + '&funcao_js=parent.mostraIframePesquisaConvenio', 'Pesquisa', false);
            } else {
                document.form1.z01_nome_convenio.value = '';
                document.form1.submit();
            }
        }
    }

    function mostraIframePesquisaConvenio(chave, erro) {
        document.form1.z01_nome_convenio.value = chave;
        if (typeof erro === 'boolean' && erro === true) {
            document.form1.t04_sequencial.focus();
            document.form1.t04_sequencial.value = '';
        } else {
            document.form1.submit();
        }
    }

    function escondeIframePesquisaConvenio(chave1, chave2) {
        document.form1.t04_sequencial.value = chave1;
        document.form1.z01_nome_convenio.value = chave2;
        db_iframe_benscadcedente.hide();
        document.form1.submit();
    }

    function pesquisaClassificacao(mostra) {
        if (typeof mostra === 'boolean' && mostra === true) {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_clabens', 'func_clabens.php?funcao_js=parent.escondeIframePesquisaClassificacao|t64_class|t64_descr|t64_codcla', 'Pesquisa', true);
        } else {
            if (document.form1.t64_class.value !== '') {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_clabens', 'func_clabens.php?pesquisa_chave=' + document.form1.t64_class.value + '&funcao_js=parent.mostraIframePesquisaClassificacao', 'Pesquisa', false);
            } else {
                document.form1.t64_descr.value = '';
                document.form1.submit();
            }
        }
    }

    function mostraIframePesquisaClassificacao(chave, erro) {
        document.form1.t64_descr.value = chave;
        if (typeof erro === 'boolean' && erro === true) {
            document.form1.t64_class.focus();
            document.form1.t64_class.value = '';
        } else {
            document.form1.submit();
        }
    }

    function escondeIframePesquisaClassificacao(chave1, chave2, chave3) {
        document.form1.t64_class.value = chave1;
        document.form1.t64_descr.value = chave2;
        document.form1.t64_codcla.value = chave3;
        db_iframe_clabens.hide();
        document.form1.submit();
    }
</script>
