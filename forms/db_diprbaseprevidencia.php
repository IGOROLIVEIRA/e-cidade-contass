<?
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
$clrotulo = new rotulocampo;
$clrotulo->label("k13_dtvlr");
$clrotulo->label("k13_conta");

$dados = "ordem";
require_once("std/db_stdClass.php");
$iTipoControleRetencaoMesAnterior = 0;
$lUsaData    = true;
/** Verificar utilidade
$aParamentrosCaixa = db_stdClass::getParametro("caiparametro", array(db_getsession("DB_anousu")));
if (count($aParamentrosCaixa) > 0) {
    $iTipoControleRetencaoMesAnterior = $aParamentrosCaixa[0]->e30_retencaomesanterior;
    $lUsaData = $aParamentrosCaixa[0]->e30_usadataagenda=="t"?true:false;
}
*/
?>
<style type="text/css">
    .pesquisaConta {
        list-style-type: none;
        padding: 0;
        margin: 0;
        display: none;
        overflow-y:auto;
        overflow-x: hidden;
        position: absolute;
        max-height: 200px;
    }

    .pesquisaConta li {
        border: 1px solid #ddd;
        margin-top: -1px;  /*Prevent double borders */
        background-color: #f6f6f6;
        padding: 10px;
        text-decoration: none;
        color: black;
        display: block
    }

    .pesquisaConta li:hover:not(.header) {
        background-color: #eee;
    }

    .codtipo {
        display: none;
    }

    .ctapag {
        width: 100%;
    }
</style>
<script>
    function js_mascara(evt){
        var evt = (evt) ? evt : (window.event) ? window.event : "";

        if((evt.charCode >46 && evt.charCode <58) || evt.charCode ==0){//8:backspace|46:delete|190:.
            return true;
        }else{
            return false;
        }
    }
</script>
<BR><BR>

<form name="form1" method="post" action="">
    <center>
        <table  border =0 style='width:90%'>
            <tr>
                <td>
                    <fieldset>
                        <legend><b>Base de Cálculo da  Contribuição Previdenciária por Órgão</b></legend>
                        <table width="100%">
                            <tr>
                                <td width="100%" valign="top">
                                    <table border="0" align="left" >
                                        <tr>
                                            <td>
                                                <b>Data Referência SICOM:</b>
                                            </td>
                                            <td nowrap>
                                                <?
                                                    db_inputdata("dtreferenciasicom", null, null, null, true, "text", 1);
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <b>CGM Ente:</b>
                                            </td>
                                            <td nowrap>
                                                <?
                                                    db_input('k13_conta', 10, $Ik13_conta, true, 'text', $db_opcao, " onchange='js_pesquisaz01_numcgm(false);'");
                                                    db_input('k13_descr', 46, $Ik13_descr, true, 'text', 3, '');?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><b>Tipo da base de cálculo da contribuição:</b></td>
                                            <td>
                                                <?php
                                                    db_select('basecalculo', array(0 => "Selecione", '1' => 'Patronal', '2' => 'Segurado'), true, 1, "");
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><b>Mês de competência:</b></td>
                                            <td>
                                                <?php
                                                    $meses = array(
                                                        0 => "Selecione",
                                                        1 => "Janeiro",
                                                        2 => "Fevereiro",
                                                        3 => "Março",
                                                        4 => "Abril",
                                                        5 => "Maio",
                                                        6 => "Junho",
                                                        7 => "Julho",
                                                        8 => "Agosto",
                                                        9 => "Setembro",
                                                        10 => "Outubro",
                                                        11 => "Novembro",
                                                        12 => "Dezembro"
                                                    );
                                                    db_select('basecalculo', $meses, true, 1, "");
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <b>Exercício de competência:</b>
                                            </td>
                                            <td nowrap>
                                                <?
                                                    db_input('exercicio', 10, $exercicio, true, 'text', $db_opcao, "");
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><b>Tipo de fundo:</b></td>
                                            <td>
                                                <?php
                                                    db_select('tipofundo', array(0 => "Selecione", '1' => 'Fundo em Capitalização (Plano Previdenciário)', '2' => 'Fundo em Repartição (Plano Financeiro)', '3' => 'Responsabilidade do tesouro municipal'), true, 1, "");
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <b>Remuneração bruta da folha de pagamento do órgão:</b>
                                            </td>
                                            <td nowrap>
                                                <?
                                                    db_input('remuneracao', 14, $remuneracao, true, 'text', $db_opcao, 14);
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <b>Tipo de base de cálculo das contribuições devidas, relativas as folhas do órgão:</b>
                                            </td>
                                            <td nowrap>
                                                <?php
                                                    $tipoBase = array("0" => "Selecione", 
                                                        "1" => "Servidores",
                                                        "2" => "Servidores afastados com benefícios pagos pela Unidade Gestora (auxílio-doença, salário maternidade e outros)",
                                                        "3" => "Aposentados",
                                                        "4" => "Pensionistas");
                                                    db_select('tipobase', $tipoBase, true, 1, "");
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <b>Valor da base de cálculo da contribuição previdenciária:</b>
                                            </td>
                                            <td nowrap>
                                                <?
                                                    db_input('remuneracao', 14, $remuneracao, true, 'text', $db_opcao, 14);
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <b>Tipo de Contribuição:</b>
                                            </td>
                                            <td nowrap>
                                                <?
                                                    $tipoBase = array("0" => "Selecione", 
                                                        "1" => "Normal",
                                                        "2" => "Suplementar");
                                                    db_select('tipobase', $tipoBase, true, 1, "");    
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <b>Alíquota:</b>
                                            </td>
                                            <td nowrap>
                                                <?
                                                    db_input('remuneracao', 14, $remuneracao, true, 'text', $db_opcao, 14);
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <b>Valor da contribuição devida:</b>
                                            </td>
                                            <td nowrap>
                                                <?
                                                    db_input('remuneracao', 14, $remuneracao, true, 'text', $db_opcao, 14);
                                                ?>
                                            </td>
                                        </tr>

                         
                        </table>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <td colspan='4' style='text-align: center'>
                        <input name="pesquisar" id='pesquisar' type="button"  value="Incluir" onclick='js_pesquisarOrdens();' />
                        <input name="atualizar" id='atualizar' type="button"  value="Pesquisar" onclick='js_configurar()' />
                             </fieldset>
                </td>
        </table>
</form>
</center>
<script>
</script>
