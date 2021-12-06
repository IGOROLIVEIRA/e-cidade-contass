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


include("classes/db_db_depart_classe.php");
$cldb_depart = new cl_db_depart;

$clliclicita->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("pc50_descr");
$clrotulo->label("l34_protprocesso");
$clrotulo->label("nome");
$clrotulo->label("l03_usaregistropreco");
$clrotulo->label("p58_numero");
$clrotulo->label("l20_naturezaobjeto");
$clrotulo->label("l20_nroedital");
require_once("libs/db_utils.php");
require_once("std/db_stdClass.php");

//verificação do tipo de usuário por login => .conttas 
$lusuario = db_getsession("DB_login");
$uLogin = explode(".", $lusuario, 2);

//url identificada para validação de campo modalidade da para uso de inclusão 
$url_atual = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$url_particao = explode("_", $url_atual, 2);


if ($db_opcao == 1) {

    /*
     * verifica na tabela licitaparam se deve utilizar processo do sistema
     */
    $oParamLicicita = db_stdClass::getParametro('licitaparam', array(db_getsession("DB_instit")));

    if (isset($oParamLicicita[0]->l12_escolheprotocolo) && $oParamLicicita[0]->l12_escolheprotocolo == 't') {
        $lprocsis = 's';
    } else {
        $lprocsis = 'n';
    }

    /*
     * verifica se existe apenas 1 cl_liclocal
     */
    $oLicLocal = new cl_liclocal();
    $rsLicLocal = $oLicLocal->sql_record($oLicLocal->sql_query_file());
    if ($oLicLocal->numrows == 1) {
        db_fieldsmemory($rsLicLocal, 0);
        $l20_liclocal = $l26_codigo;
    }

    /*
     * verifica se existe apenas 1 cl_liccomissao
     */
    $oLicComissao = new cl_liccomissao();
    $rsLicComissao = db_query($oLicComissao->sql_query_file());
    if (pg_num_rows($rsLicComissao) == 1) {
        db_fieldsmemory($rsLicComissao, 0);
        $l20_liccomissao = $l30_codigo;
    }
}

if ($l20_codepartamento != null) {
    $result_depto = $cldb_depart->sql_record($cldb_depart->sql_query_file($l20_codepartamento, 'descrdepto'));
    if ($cldb_depart->numrows != 0) {
        db_fieldsmemory($result_depto, 0);
        $l20_descricaodep = $descrdepto;
    }
}
$lBloqueadoRegistroPreco = (empty($itens_lancados) ? $db_opcao : 3);
?>

<style type="text/css">
    .fieldsetinterno {
        border: 0px;
        border-top: 2px groove white;
        margin-top: 10px;

    }

    fieldset table tr>td {
        width: 180px;
        white-space: nowrap
    }

    select:disabled {
        background-color: #DEB887;
        text-transform: uppercase;
        color: black;
        -webkit-appearance: none;
        -moz-appearance: none;
        text-indent: 1px;
        text-overflow: '';
    }
</style>
<form name="form1" method="post" action="" onsubmit="js_ativaregistro()">
    <input type="hidden" id="modalidade_tribunal" name="modalidade_tribunal">
    <center>

        <table align=center style="margin-top:25px;">
            <tr>
                <td>

                    <fieldset>
                        <legend><strong>Licitação</strong></legend>

                        <fieldset style="border:0px;">

                            <table border="0">
                                <tr>
                                    <td nowrap title="<?= @$Tl20_codigo ?>">
                                        <?= @$Ll20_codigo ?>
                                    </td>
                                    <td>
                                        <?
                                        db_input('l20_codigo', 10, $Il20_codigo, true, 'text', 3, "");
                                        if ($db_opcao == 1 || $db_opcao == 11) {
                                            $l20_correto = 'f';
                                        }
                                        db_input("l20_correto", 1, "", true, "hidden", 3);
                                        if ($db_botao == false && @$l20_correto == 't') {
                                        ?>
                                            &nbsp;&nbsp;<font color="#FF0000"><b>Licitação já julgada</b></font>
                                        <?
                                        }
                                        ?>



                                    </td>
                                </tr>

                                <tr>
                                    <td nowrap title="<?= @$Tl20_edital ?>">
                                        <?= @$Ll20_edital ?>
                                    </td>
                                    <td>
                                        <?
                                        db_input('l20_edital', 10, $Il20_edital, true, 'text', 3, "");
                                        ?>

                                        <strong>Numeração:</strong>
                                        <?
                                        db_input('l20_numero', 10, $Il20_numero, true, 'text', 3, "");
                                        ?>
                                        <?php if ($l20_anousu >= 2020 && $db_opcao == 2 || $l20_anousu == null && $db_opcao == 1) : ?>
                                            <span id="linha_nroedital">

                                                <strong>Edital:</strong>
                                                <?
                                                $mostra = $l20_nroedital && $db_opcao == 2 || !$l20_nroedital && $db_opcao == 1
                                                    || db_getsession('DB_anousu') >= 2021 ? 3 : 1;
                                                db_input('l20_nroedital', 10, $Il20_nroedital, true, 'text', $mostra, "");
                                                ?>
                                            </span>
                                        <?php endif; ?>


                                    </td>
                                </tr>
                                <!--
                                <tr>
                                    <td nowrap title="<?= @$Tl20_numero ?>">
                                        <?= @$Ll20_numero ?>
                                    </td>
                                    <td>
                                        <?
                                        db_input('l20_numero', 10, $Il20_numero, true, 'text', 3, "");
                                        ?>
                                    </td>
                                </tr> -->
                                <?php if ($l20_anousu >= 2020 && $db_opcao == 2 || $l20_anousu == null && $db_opcao == 1) : ?>
                                    <!--
                                <tr id="linha_nroedital">
                                    <td nowrap title="<?= @$Tl20_nroedital ?>">
                                        <?= @$Ll20_nroedital ?>
                                    </td>
                                    <td>
                                        <?
                                        $mostra = $l20_nroedital && $db_opcao == 2 || !$l20_nroedital && $db_opcao == 1
                                            || db_getsession('DB_anousu') >= 2021 ? 3 : 1;
                                        db_input('l20_nroedital', 10, $Il20_nroedital, true, 'text', $mostra, "");
                                        ?>
                                    </td>
                                </tr> -->
                                <?php endif; ?>
                                <tr>
                                    <td nowrap title="<?= @$Tl20_codepartamento ?>">
                                        <?
                                        db_ancora("Cod.Departamento", "js_pesquisal20_codepartamento(true);", $db_opcao)

                                        ?>
                                    </td>
                                    <td>
                                        <?
                                        db_input('l20_codepartamento', 4, $Il20_codepartamento, true, 'text', $db_opcao, "onchange='js_pesquisal20_codepartamento(false)';");
                                        db_input('l20_descricaodep', 45, $Il20_descricaodep, true, 'text', 3, "");
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td nowrap title="<?= @$Tl20_codtipocom ?>">
                                        <b>
                                            <?
                                            db_ancora("Modalidade :", "js_pesquisal20_codtipocom(true);", 3);
                                            ?>
                                        </b>
                                    </td>
                                    <td>
                                        <?
                                        $result_tipo = $clcflicita->sql_record($clcflicita->sql_query_numeracao(null, "l03_codigo,l03_descr", null, "l03_instit = " . db_getsession("DB_instit")));
                                        if ($clcflicita->numrows == 0) {
                                            db_msgbox("Nenhuma Modalidade cadastrada!!");
                                            $result_tipo = "";
                                            $db_opcao = 3;
                                            $db_botao = false;
                                            db_input("l20_codtipocom", 10, "", true, "text");
                                            db_input("l20_codtipocom", 40, "", true, "text");
                                        } else {
                                            db_selectrecord("l20_codtipocom", @$result_tipo, true, $db_opcao, "js_mostraRegistroPreco()");
                                            if (isset($l20_codtipocom) && $l20_codtipocom != "") {
                                                echo "<script>document.form1.l20_codtipocom.selected=$l20_codtipocom;</script>";
                                            }
                                        }
                                        ?>
                                        <input type="hidden" id="descricao" name="descricao" value="" onchange="js_convite()">
                                        <input type="hidden" id="vUsuario" name="vUsuario" value="<? echo $uLogin[1]; ?>">
                                        <input type="hidden" id="vInclu" name="vInclu" value="<? echo $url_particao[1]; ?>">

                                    </td>
                                </tr>

                                <tr style="display: none">
                                    <td nowrap title="<?= @$Tl20_id_usucria ?>">
                                        <?
                                        db_ancora(@$Ll20_id_usucria, "js_pesquisal20_id_usucria(true);", 3);
                                        ?>
                                    </td>
                                    <td>
                                        <?
                                        $usuario = db_getsession("DB_id_usuario");
                                        $result_usuario = $cldb_usuarios->sql_record($cldb_usuarios->sql_query_file($usuario));
                                        if ($cldb_usuarios->numrows > 0) {
                                            db_fieldsmemory($result_usuario, 0);
                                        }
                                        $l20_id_usucria = $id_usuario;
                                        db_input('l20_id_usucria', 10, $Il20_id_usucria, true, 'text', 3, " onchange='js_pesquisal20_id_usucria(false);'")
                                        ?>
                                        <?
                                        db_input('nome', 45, $Inome, true, 'text', 3, '')
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td nowrap title="<?= @$Tl20_tipliticacao ?>" id="tipolicitacao">
                                        <?= @$Ll20_tipliticacao ?>
                                    </td>

                                    <td id="licitacao1">
                                        <?
                                        $arr_tipo = array(
                                            "0" => "Selecione", "1" => "1- Menor Preço", "2" => "2- Melhor Técnica",
                                            "3" => "3- Técnica e Preço", "4" => "4- Maior Lance ou Oferta"
                                        );
                                        db_select("l20_tipliticacao", $arr_tipo, true, $db_opcao);
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td nowrap title="<?= @$Tl20_leidalicitacao ?>" id="leidalicitacao">
                                        <strong>Lei da Licitação:</strong>
                                    </td>
                                    <td>
                                        <?
                                        $arr_tipo = array(
                                            "0" => "Selecione",
                                            "1" => "1 - Lei 14.133/2021",
                                            "2" => "2 - Lei 8.666/1993 e outras"
                                        );
                                        db_select("l20_leidalicitacao", $arr_tipo, true, $db_opcao);
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td nowrap title="<?= @$Tl20_tipnaturezaproced ?>" id="tipnaturezaproced">
                                        <?= @$Ll20_tipnaturezaproced ?>
                                    </td>
                                    <td>
                                        <?
                                        $al20_tipnaturezaproced = array("0" => "Selecione", "1" => "1-Licitação Normal", "2" => "2-Registro de Preço", "3" => "3-Credenciamento/Chamada");
                                        db_select("l20_tipnaturezaproced", $al20_tipnaturezaproced, true, $db_opcao, "onchange='js_naturezaprocedimento(this.value);'");
                                        ?>
                                    </td>
                                </tr>
                                <span>
                                    <tr>
                                        <td nowrap title="<?= @$Tl20_naturezaobjeto ?>" id="natureOB1">
                                            <?= @$Ll20_naturezaobjeto ?>
                                        </td>
                                        <td id="natureOB">
                                            <?
                                            $al20_naturezaobjeto = array("0" => "Selecione", "1" => "1- Obras e Serviços de Engenharia", "2" => "2- Compras e outros serviços", "3" => "3- Locação de Imóveis", "4" => "4- Concessão", "5" => "5- Permissão", "6" => "6- Alienação de bens");
                                            if (db_getsession('DB_anousu') >= 2019) {
                                                $al20_naturezaobjeto[7] = "7-Compras para obras e/ou serviços de engenharia";
                                            }
                                            db_select("l20_naturezaobjeto", $al20_naturezaobjeto, true, $db_opcao, "onchange='js_regime(this.value)'");
                                            ?>
                                        </td>
                                    </tr>
                                </span>
                                <tr>
                                    <td nowrap title="<?= @$Tl20_regimexecucao ?>">
                                        <?= @$Ll20_regimexecucao ?>
                                    </td>
                                    <td>
                                        <?
                                        $al20_regimexecucao = array("0" => "Não se Aplica", "1" => "1- Empreitada por Preço Global", "2" => "2- Empreitada por Preço Unitário", "3" => "3- Empreitada Integral", "4" => "4- Tarefa", "5" => "5-Execução Direta");
                                        db_select("l20_regimexecucao", $al20_regimexecucao, true, $db_opcao);
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td id="descontotab">
                                        <label class="bold">Critério de Adjudicação:</label>
                                    </td>
                                    <td>
                                        <? //OC3770
                                        if (!isset($l20_criterioadjudicacao) || $l20_criterioadjudicacao == '') {
                                            $l20_criterioadjudicacao = "";
                                        }
                                        $aCriterios = array("3" => "Outros", "1" => "Desconto sobre tabela", "2" => "Menor taxa ou percentual");
                                        if (db_getsession('DB_anousu') >= 2019) {
                                            //                                        $aCriterios["3"] = "Menor preço global";
                                        }
                                        db_select("l20_criterioadjudicacao", $aCriterios, true, '');
                                        ?>
                                    </td>
                                </tr>


                                <tr style="display:none;" id="convite1">
                                    <td nowrap title="<?= @$Tl20_numeroconvidado ?>" id="numeroconvidado">
                                        <span><?= @$Ll20_numeroconvidado ?></span>
                                    </td>
                                    <td>
                                        <span>
                                            <?
                                            db_input('l20_numeroconvidado', 3, $Il20_numeroconvidado, true, 'text', $db_opcao, "", "", "#E6E4F1")
                                            ?>
                                        </span>
                                    </td>

                                </tr>


                                <tr>
                                    <td nowrap title="<?= @$Tl20_execucaoentrega ?>">
                                        <?= @$Ll20_execucaoentrega ?>
                                    </td>
                                    <td>
                                        <? $al20_diames = array("1" => "Dias", "2" => "Mes");
                                        db_select("l20_diames", $al20_diames, true, $db_opcao);
                                        db_input('l20_execucaoentrega', 3, $Il20_execucaoentrega, true, 'text', $db_opcao, "");
                                        ?>
                                    </td>
                                </tr>



                            </table>
                        </fieldset>

                        <fieldset class="fieldsetinterno">
                            <legend><strong>Datas</strong></legend>
                            <table>
                                <tr>
                                    <td nowrap title="Data Abertura Proc. Adm.">
                                        <b>Data Abertura Proc. Adm. :</b>
                                    </td>
                                    <td>
                                        <?
                                        if (!isset($l20_datacria)) {
                                            $l20_datacria_dia = date('d', db_getsession("DB_datausu"));
                                            $l20_datacria_mes = date('m', db_getsession("DB_datausu"));
                                            $l20_datacria_ano = date('Y', db_getsession("DB_datausu"));
                                        }
                                        db_inputdata("l20_datacria", @$l20_datacria_dia, @$l20_datacria_mes, @$l20_datacria_ano, true, 'text', $db_opcao);
                                        ?>
                                        <?= @$Ll20_horacria ?>
                                        <?
                                        if ($db_opcao == 1 || $db_opcao == 11) {
                                            $l20_horacria = db_hora();
                                        }
                                        echo "&nbsp;";
                                        db_input('l20_horacria', 5, $Il20_horacria, true, 'text', 3, "");
                                        echo "hh:mm";
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td nowrap title="Data Emis/Alt Edital/Convite" id="dataaber">
                                        <b> Data Emis/Alt Edital/Convite : </b>
                                    </td>
                                    <td>
                                        <?
                                        db_inputdata("l20_dataaber", @$l20_dataaber_dia, @$l20_dataaber_mes, @$l20_dataaber_ano, true, 'text', $db_opcao);
                                        ?>
                                        <?= @$Ll20_horaaber ?>
                                        <?
                                        if (empty($l20_horaaber)) {
                                            $l20_horaaber = db_hora();
                                        }
                                        db_input('l20_horaaber', 5, $Il20_horaaber, true, 'text', $db_opcao, "onchange='js_verifica_hora(this.value,this.name)';onkeypress='return js_mask(event, \"0-9|:|0-9\"); '");
                                        echo "hh:mm";
                                        ?>
                                    </td>
                                </tr>

                                <tr id="datenpc">
                                    <td nowrap title="Link no PNCP" id="linkpncp">
                                        <b>Link no PNCP: </b>
                                    </td>
                                    <td>
                                        <?
                                        db_inputdata("l20_dtpulicacaopncp", @$l20_dtpulicacaopncp_dia, @$l20_dtpulicacaopncp_mes, @$l20_dtpulicacaopncp_ano, true, 'text', $db_opcao);
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td nowrap title="Data Publicação DO" id="dtpublic">
                                        <b>Data Publicação DO : </b>
                                    </td>
                                    <td>
                                        <?
                                        db_inputdata('l20_dtpublic', @$l20_dtpublic_dia, @$l20_dtpublic_mes, @$l20_dtpublic_ano, true, 'text', $db_opcao, "", "", "#ffffff");
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td nowrap title="<?= @$Tl20_recdocumentacao ?>" id="recdocumentacao">
                                        <b>Abertura das Propostas :</b>
                                    </td>
                                    <td>
                                        <?
                                        db_inputdata('l20_recdocumentacao', @$l20_recdocumentacao_dia, @$l20_recdocumentacao_mes, @$l20_recdocumentacao_ano, true, 'text', $db_opcao, "");
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td nowrap title="<?= @$Tl20_datapublicacao1 ?>" id="datapublicacao1">
                                        <? //=@$Ll20_datapublicacao1
                                        ?>
                                        <strong>Publicação Veículo 1:</strong>
                                    </td>
                                    <td>
                                        <?
                                        db_inputdata('l20_datapublicacao1', @$l20_datapublicacao1_dia, @$l20_datapublicacao1_mes, @$l20_datapublicacao1_ano, true, 'text', $db_opcao, "");
                                        ?>
                                        <strong id="nomeveiculo1">Veículo Divulgação 1:</strong>
                                        <?
                                        db_input('l20_nomeveiculo1', 40, $Il20_nomeveiculo1, true, 'text', $db_opcao, "");
                                        ?>
                                    </td>

                                </tr>
                                <!--        
                                <tr>
                                    <td nowrap title="<?= @$Tl20_nomeveiculo1 ?>" id="nomeveiculo1">
                                        <?= @$Ll20_nomeveiculo1 ?>
                                    </td>
                                    <td>
                                        <?
                                        db_input('l20_nomeveiculo1', 50, $Il20_nomeveiculo1, true, 'text', $db_opcao, "");
                                        ?>
                                    </td>
                                </tr> -->

                                <tr>
                                    <td nowrap title="<?= @$Tl20_datapublicacao2 ?>" id="datapublicacao2">
                                        <? //=@$Ll20_datapublicacao2
                                        ?>
                                        <strong>Publicação Veículo 2:</strong>
                                    </td>
                                    <td>
                                        <?
                                        db_inputdata('l20_datapublicacao2', @$l20_datapublicacao2_dia, @$l20_datapublicacao2_mes, @$l20_datapublicacao2_ano, true, 'text', $db_opcao, "");
                                        ?>
                                        <strong id="nomeveiculo2">Veículo Divulgação 2:</strong>
                                        <?
                                        db_input('l20_nomeveiculo2', 40, $Il20_nomeveiculo2, true, 'text', $db_opcao, "");
                                        ?>
                                    </td>
                                </tr>
                                <!--        
                                <tr>
                                    <td nowrap title="<?= @$Tl20_nomeveiculo2 ?>" id="nomeveiculo2">
                                        <?= @$Ll20_nomeveiculo2 ?>
                                    </td>
                                    <td>
                                        <?
                                        db_input('l20_nomeveiculo2', 50, $Il20_nomeveiculo2, true, 'text', $db_opcao, "");
                                        ?>
                                       
                                    </td>
                                </tr> -->

                            </table>

                        </fieldset>

                        <fieldset>
                            <legend><strong>Detalhamento para ME e EPP </strong></legend>
                            <table>
                                <tr>
                                    <td nowrap title="<?= @$Tl20_critdesempate ?>">
                                        <?= @$Ll20_critdesempate ?>
                                    </td>
                                    <td>
                                        <?
                                        $al20_critdesempate = array("0" => "Selecione", "2" => "Não", "1" => "Sim");
                                        db_select("l20_critdesempate", $al20_critdesempate, true, $db_opcao);
                                        ?>
                                    <td>
                                        <?= @$Ll20_subcontratacao ?>
                                    </td>
                                    <td>
                                        <? $al20_subcontratacao = array("0" => "Selecione", "2" => "Não", "1" => "Sim");
                                        db_select("l20_subcontratacao", $al20_subcontratacao, true, $db_opcao);
                                        ?>
                                    </td>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Tl20_destexclusiva ?>">
                    <?= @$Ll20_destexclusiva ?>
                </td>
                <td>
                    <?
                    $al20_destexclusiva = array("0" => "Selecione", "2" => "Não", "1" => "Sim");
                    db_select("l20_destexclusiva", $al20_destexclusiva, true, $db_opcao);
                    ?>
                <td>
                    <?= @$Ll20_limitecontratacao ?>
                </td>
                <td>
                    <? $al20_limitcontratacao = array("0" => "Selecione", "2" => "Não", "1" => "Sim");
                    db_select("l20_limitcontratacao", $al20_limitcontratacao, true, $db_opcao);
                    ?>
                </td>
                </td>
            </tr>
        </table>
        </fieldset>

        <fieldset>
            <legend><strong>Informações Adicionais </strong></legend>
            <table>

                <tr id="trTipoJulgamento">
                    <td nowrap title="<?= @$Tl20_tipojulg ?>">
                        <?= @$Ll20_tipojulg ?>
                    </td>
                    <td>
                        <?
                        $arr_tipo = array("0" => "Selecione", "1" => "Por item", "3" => "Por lote");
                        db_select("l20_tipojulg", $arr_tipo, true, $lBloqueadoRegistroPreco);
                        db_input("tipojulg", 1, "", true, "hidden", 3, "");
                        db_input("confirmado", 1, "", true, "hidden", 3, "");
                        ?>
                    </td>
                    <td>
                        <span id="usaregistropreco">
                            <strong>Usa Registro de Preço:</strong>
                            <?
                            if (!isset($l20_usaregistropreco)) {
                                $l20_usaregistropreco = "f";
                            }
                            db_select("l20_usaregistropreco", array("t" => "Sim", "f" => "Não"), true, 3, "");
                            ?>
                        </span>
                    </td>
                </tr>
                <!--
                                <tr>
                                    <td id="usaregistropreco">
                                        <?= @$Ll03_usaregistropreco ?>
                                    </td>
                                    <td>
                                        <?
                                        if (!isset($l20_usaregistropreco)) {
                                            $l20_usaregistropreco = "f";
                                        }
                                        db_select("l20_usaregistropreco", array("t" => "Sim", "f" => "Não"), true, $db_opcao, "");
                                        ?>
                                    </td>
                                </tr> 
                                <tr>
                                    <td nowrap title="<?= @$Tl20_liclocal ?>">
                                        <?
                                        //db_ancora(@$Ll20_liclocal,"js_pesquisal20_liclocal(true);",$db_opcao);
                                        ?>
                                    </td>
                                    <td> -->
                <?
                db_input('l20_liclocal', 10, $Il20_liclocal, true, 'hidden', $db_opcao, " onchange='js_pesquisal20_liclocal(false);'")
                ?>
                <!--            
                                    </td>
                                </tr> -->
                <?
                db_input('l20_liccomissao', 10, $Il20_liccomissao, true, 'hidden', $db_opcao, " onchange='js_pesquisal20_liccomissao(false);'")
                /*
                                if(db_getsession("DB_anousu") >= 2016){
                                    ?>
                                    <tr>

                                        <td>
                                            <?
                                            db_input('l20_liccomissao',10,$Il20_liccomissao,true,'hidden',$db_opcao," onchange='js_pesquisal20_liccomissao(false);'")
                                            ?>
                                        </td>
                                    </tr>
                                    <?
                                }else {
                                    ?>
                                    <tr>
                                        <td nowrap title="<?=@$Tl20_liccomissao?>">
                                            <?
                                            db_ancora(@$Ll20_liccomissao,"js_pesquisal20_liccomissao(true);",$db_opcao);
                                            ?>
                                        </td>
                                        <td>
                                            <?
                                            db_input('l20_liccomissao',10,$Il20_liccomissao,true,'text',$db_opcao," onchange='js_pesquisal20_liccomissao(false);'")
                                            ?>
                                        </td>
                                    </tr>
                                    <?
                                }*/
                ?>
                <tr style="padding-bottom:70px important!;">
                    <td nowrap title="<?= @$Tl20_equipepregao ?>" id="equipepregao">
                        <?
                        db_ancora(@$Ll20_equipepregao, "js_pesquisal20_equipepregao(true);", $db_opcao);
                        ?>
                    </td>
                    <td>
                        <?
                        db_input('l20_equipepregao', 10, $Il20_equipepregao, true, 'text', $db_opcao, " onchange='js_pesquisal20_equipepregao(false);'");
                        ?>
                    </td>
                </tr>

                <tr id="formacontraleregistropreco">
                    <td nowrap title="<?= @$Tl20_formacontroleregistropreco ?>">
                        <?= @$Ll20_formacontroleregistropreco ?>
                    </td>
                    <td>
                        <?
                        if (!isset($ll20_formacontroleregistropreco)) {
                            $ll20_formacontroleregistropreco = "1";
                        }
                        db_select("l20_formacontroleregistropreco", array("1" => "Por Quantidade", "2" => "Por Valor"), true, $lBloqueadoRegistroPreco, "onchange='verificaTipoJulgamento()'");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <b>Processo do Sistema:</b>
                    </td>
                    <td>
                        <?
                        $aProcSistema = array(
                            "s" => "Sim",
                            "n" => "Não"
                        );
                        db_select('lprocsis', $aProcSistema, true, $db_opcao, "onChange='js_mudaProc(this.value);'");
                        ?>
                    </td>
                    <td>
                        <strong>Processo Administrativo:</strong>
                        <? db_input('l20_procadmin', 21, $Il20_procadmin, true, 'text', $db_opcao, "") ?>
                    </td>
                </tr>
            </table>
            <table>
                <!--
                                <tr>
                                    <td>
                                        <?= @$Ll20_procadmin ?>
                                    </td>
                                    <td>
                                        <? db_input('l20_procadmin', 21, $Il20_procadmin, true, 'text', $db_opcao, "") ?>
                                    </td>
                                </tr> -->
                <tr id="procSis">
                    <td nowrap title="<?= @$Tl34_protprocesso ?>">
                        <?
                        db_ancora($Ll34_protprocesso, "js_pesquisal34_protprocesso(true);", $db_opcao);
                        ?>
                    </td>
                    <td>
                        <?
                        db_input('p58_numero', 15, $Ip58_numero, true, 'hidden', $db_opcao, "onChange='js_pesquisal34_protprocesso(false);'");
                        db_input('l34_protprocesso', 10, $Il34_protprocesso, true, 'text', $db_opcao);
                        db_input('l34_protprocessodescr', 45, "",  true, 'text', 3, "");
                        ?>
                    </td>
                </tr>

            </table>

        </fieldset>

        <fieldset class="fieldsetinterno">
            <legend><b>Outras Informações</b></legend>

            <table>
                <tr>
                    <td nowrap title="<?= @$Tl20_local ?>" id="local">
                        <?= @$Ll20_local ?>
                    </td>
                    <td>
                        <?
                        db_textarea('l20_local', 0, 57, $Il20_local, true, 'text', $db_opcao, "onkeyup='limitaTextarea(this);'");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td nowrap title="<?= @$Tl20_objeto ?>">
                        <?= @$Ll20_objeto ?>
                    </td>
                    <td>
                        <?
                        db_textarea('l20_objeto', 0, 57, $Il20_objeto, true, 'text', $db_opcao, "onkeyup='limitaTextareaobj(this);' onkeypress='doNothing()';");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td nowrap title="<?= @$Tl20_localentrega ?>">
                        <?= @$Ll20_localentrega ?>
                    </td>
                    <td>
                        <?
                        db_textarea('l20_localentrega', 0, 57, $Il20_localentrega, true, 'text', $db_opcao, "onkeyup='limitaTextarea(this);'");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Tl20_prazoentrega ?>">
                        <?= @$Ll20_prazoentrega ?>
                    </td>
                    <td>
                        <?
                        db_textarea('l20_prazoentrega', 0, 57, $Il20_prazoentrega, true, 'text', $db_opcao, "onkeyup='limitaTextarea(this);'");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Tl20_condicoespag ?>">
                        <?= @$Ll20_condicoespag ?>
                    </td>
                    <td>
                        <?
                        db_textarea('l20_condicoespag', 0, 57, $Il20_condicoespag, true, 'text', $db_opcao, "onkeyup='limitaTextarea(this);'");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td nowrap title="<?= @$Tl20_validadeproposta ?>">
                        <?= @$Ll20_validadeproposta ?>
                    </td>
                    <td>
                        <?
                        db_textarea('l20_validadeproposta', 0, 57, $Il20_validadeproposta, true, 'text', $db_opcao, "onkeyup='limitaTextarea(this);'");
                        ?>
                    </td>
                </tr>


                <tr>
                    <td nowrap title="<?= @$Tl20_clausulapro ?>">
                        <?= @$Ll20_clausulapro ?>
                    </td>
                    <td>
                        <?
                        db_textarea('l20_clausulapro', 0, 57, $Il20_clausulapro, true, 'text', $db_opcao, "onkeyup='limitaTextareacpro(this);'", '', '#E6E4F1');
                        ?>
                    </td>
                </tr>


                <tr>
                    <td nowrap title="<?= @$Tl20_aceitabilidade ?>" id="aceitabilidade">
                        <b>Critério de Aceitabilidade:</b>
                    </td>
                    <td>
                        <?
                        db_textarea('l20_aceitabilidade', 0, 57, $Il20_aceitabilidade, true, 'text', $db_opcao, "onkeyup='limitaTextarea(this);'");
                        ?>
                    </td>
                </tr>

            </table>
        </fieldset>

        <fieldset style="display:none;" id="dispensa">
            <legend><b>Dispensa/Inexigibilidade</b></legend>

            <table>


                <tr>
                    <td nowrap title="<?= @$Tl20_tipoprocesso ?>">
                        <?= @$Ll20_tipoprocesso ?>
                    </td>
                    <td>
                        <?
                        $al20_tipoprocesso = array("0" => "", "1" => "1-Dispensa", "2" => "2-Inexigibilidade", "3" => "3-Inexigibilidade por credenciamento/chamada pública", "4" => "4-Dispensa por chamada publica");
                        db_select("l20_tipoprocesso", $al20_tipoprocesso, true, $db_opcao);
                        ?>
                    </td>
                </tr>

                <tr>
                    <td nowrap title="<?= @$Tl20_justificativa ?>">
                        <?= @$Ll20_justificativa ?>
                    </td>
                    <td>
                        <?
                        db_textarea('l20_justificativa', 0, 53, $Il20_justificativa, true, 'text', $db_opcao, "onkeyup='limitaTextarea(this);'");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td nowrap title="<?= @$Tl20_razao ?>">
                        <?= @$Ll20_razao ?>
                    </td>
                    <td>
                        <?
                        db_textarea('l20_razao', 0, 53, $Il20_razao, true, 'text', $db_opcao, "onkeyup='limitaTextarea(this);'");
                        ?>
                    </td>
                </tr>

            </table>
        </fieldset>

        </fieldset>

        </td>
        </tr>
        </table>

    </center>

    <?/*
   if ($db_opcao==2 || $db_opcao==22){
        $jscript = "onClick='return js_confirmar();'";
   } else {
        $jscript = "";
   }<?=$jscript?>*/
    ?>


    <input name="<?= ($db_opcao == 1 ? 'incluir' : ($db_opcao == 2 || $db_opcao == 22 ? 'alterar' : 'excluir')) ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? 'Incluir' : ($db_opcao == 2 || $db_opcao == 22 ? 'Alterar' : 'Excluir')) ?>" <?= ($db_botao == false ? 'disabled' : '') ?> onClick="return js_confirmadatas()">
    <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
</form>
<script>
    document.form1.l20_prazoentrega.style.backgroundColor = '#FFFFFF';
    document.form1.l20_condicoespag.style.backgroundColor = '#FFFFFF';
    document.form1.l20_local.style.backgroundColor = '#E6E4F1';
    document.getElementById('linha_nroedital').style.display = 'none';


    let elemento = document.getElementById('l20_tipnaturezaproced');
    elemento.addEventListener('change', (event) => {
        if (elemento.selectedIndex == 2) {
            document.getElementById('formacontraleregistropreco').style.display = '';
        } else {
            document.getElementById('formacontraleregistropreco').style.display = 'none';
        }
    });

    js_busca();


    // alterando a função padrao para verificar  as opçoes de convite e de INEXIGIBILIDADE
    function js_ProcCod_l20_codtipocom(proc, res) {

        var sel1 = document.forms[0].elements[proc];
        var sel2 = document.forms[0].elements[res];
        for (var i = 0; i < sel1.options.length; i++) {
            if (sel1.options[sel1.selectedIndex].value == sel2.options[i].value)
                sel2.options[i].selected = true;
        }
        // ajax para fazer consulta sql, retornando o codigo do tribunal
        var codigocompra = document.getElementById("l20_codtipocom").options[document.getElementById("l20_codtipocom").selectedIndex].text;
        var oParam = new Object();
        oParam.codigo = codigocompra;
        var url = 'lic1_liclicita_consulta.php';
        var oAjax = new Ajax.Request(url, {
            method: 'post',
            parameters: 'json=' + Object.toJSON(oParam),
            onComplete: js_retornolicitacao
        });

    }


    function js_retornolicitacao(oAjax) {


        var oRetorno = eval("(" + oAjax.responseText + ")");
        var campo = document.getElementById("l20_codtipocomdescr").options[document.getElementById("l20_codtipocomdescr").selectedIndex].text;

        var vUsua = document.getElementById("vUsuario").value;
        var vInclu = document.getElementById("vInclu").value;
        if (vUsua != "contass" && vInclu != "liclicita001.php") {
            document.getElementById("l20_codtipocom").disabled = true;
            document.getElementById("l20_codtipocomdescr").disabled = true;
        }

        document.getElementById("lprocsis").style.width = "85px";
        document.getElementById("l20_usaregistropreco").style.width = "85px";
        document.getElementById("l20_tipliticacao").style.width = "300px";
        document.getElementById("l20_leidalicitacao").style.width = "300px";
        document.getElementById("l20_tipnaturezaproced").style.width = "300px";
        document.getElementById("l20_regimexecucao").style.width = "300px";
        document.getElementById("l20_criterioadjudicacao").style.width = "300px";
        document.getElementById("l20_tipojulg").style.width = "85px";
        document.getElementById("l20_tipoprocesso").style.width = "400px";
        //document.getElementById("l20_codtipocom").style.width="85px";
        document.form1.modalidade_tribunal.value = oRetorno.tribunal;

        // verifica se e do tipo convite
        if (oRetorno.tribunal == 48) {
            document.form1.l20_numeroconvidado.style.backgroundColor = '#FFFFFF';
            document.getElementById("l20_numeroconvidado").readOnly = false;
            document.getElementById("convite1").style.display = "table-row";

            document.getElementById("numeroconvidado").style.display = "table-cell";
            document.getElementById("l20_tipliticacao").disabled = false;
            document.getElementById("l20_naturezaobjeto").disabled = false;
        } else {
            var campo = document.getElementById("l20_codtipocomdescr").options[document.getElementById("l20_codtipocomdescr").selectedIndex].text;


            document.getElementById("convite1").style.display = "none";

            if (campo == "CONCURSO") {

                document.getElementById("tipolicitacao").style.display = 'none';
                document.getElementById("licitacao1").style.display = "none";
                document.getElementById("natureOB").style.display = "none";
                document.getElementById("natureOB1").style.display = "none";
            } else {
                //document.getElementById("l20_tipliticacao").disabled=false;
                //document.getElementById("l20_naturezaobjeto").disabled=false;
                document.getElementById("licitacao1").style.display = "table-cell";
                document.getElementById("tipolicitacao").style.display = "table-cell";
                document.getElementById("natureOB").style.display = "table-cell";
                document.getElementById("natureOB1").style.display = "table-cell";
            }
            document.form1.l20_numeroconvidado.style.backgroundColor = '#E6E4F1';
            $("l20_numeroconvidado").value = "";
            document.getElementById("l20_numeroconvidado").readOnly = true;

        }

        if (oRetorno.tribunal == 100 || oRetorno.tribunal == 101 || oRetorno.tribunal == 102 || oRetorno.tribunal == 103) {

            // document.form1.l20_justificativa.style.backgroundColor='#FFFFFF ';
            // document.form1.l20_dtpubratificacao.style.backgroundColor='#FFFFFF ';
            // document.form1.l20_veicdivulgacao.style.backgroundColor='#FFFFFF ';
            document.form1.l20_justificativa.style.backgroundColor = '#FFFFFF ';
            document.form1.l20_razao.style.backgroundColor = '#FFFFFF ';

            // document.getElementById("l20_veicdivulgacao").disabled=false;
            // document.getElementById("l20_dtpubratificacao").disabled=false;
            document.getElementById("l20_justificativa").disabled = false;
            document.getElementById("l20_razao").disabled = false;
            document.getElementById("l20_tipoprocesso").disabled = false;
            document.getElementById("dispensa").style.display = 'block';
            //document.getElementById("l20_dtpubratificacao").value='';

            /*Demandas sicom 2016*/
            document.form1.l20_tipliticacao.style.display = 'none';
            document.form1.l20_tipnaturezaproced.style.display = 'none';
            document.form1.l20_criterioadjudicacao.style.display = 'none';
            document.form1.l20_numeroconvidado.style.display = 'none';
            document.form1.l20_dataaber.style.display = 'none';
            document.form1.dtjs_l20_dataaber.style.display = 'none';
            document.form1.l20_dtpublic.style.display = 'none';
            document.form1.dtjs_l20_dtpublic.style.display = 'none';
            document.form1.l20_recdocumentacao.style.display = 'none';
            document.form1.dtjs_l20_recdocumentacao.style.display = 'none';
            document.form1.l20_datapublicacao1.style.display = 'none';
            document.form1.dtjs_l20_datapublicacao1.style.display = 'none';
            document.form1.l20_nomeveiculo1.style.display = 'none';
            document.form1.l20_datapublicacao2.style.display = 'none';
            document.form1.dtjs_l20_datapublicacao2.style.display = 'none';
            document.form1.l20_nomeveiculo2.style.display = 'none';
            document.form1.l20_usaregistropreco.style.display = 'none';
            document.form1.l20_equipepregao.style.display = 'none';
            document.form1.l20_local.style.display = 'none';
            document.form1.l20_aceitabilidade.style.display = 'none';

            document.getElementById("tipolicitacao").style.display = 'none';
            document.getElementById("tipnaturezaproced").style.display = 'none';
            document.getElementById("descontotab").style.display = 'none';
            document.getElementById("numeroconvidado").style.display = 'none';
            document.getElementById("dataaber").style.display = 'none';
            document.getElementById("dtpublic").style.display = 'none';
            document.getElementById("recdocumentacao").style.display = 'none';
            document.getElementById("datapublicacao1").style.display = 'none';
            document.getElementById("nomeveiculo1").style.display = 'none';
            document.getElementById("datapublicacao2").style.display = 'none';
            document.getElementById("nomeveiculo2").style.display = 'none';
            document.getElementById("usaregistropreco").style.display = 'none';
            document.getElementById("equipepregao").style.display = 'none';
            document.getElementById("local").style.display = 'none';
            document.getElementById("aceitabilidade").style.display = 'none';
            document.getElementById("datenpc").style.display = '';

        } else {

            // document.getElementById("l20_veicdivulgacao").disabled=true;
            // document.getElementById("l20_dtpubratificacao").disabled=true;
            document.getElementById("l20_justificativa").disabled = true;
            document.getElementById("l20_razao").disabled = true;
            document.getElementById("l20_tipoprocesso").disabled = true;
            document.getElementById("dispensa").style.display = 'none';
            document.getElementById("datenpc").style.display = 'none';
            //document.getElementById("l20_dtpubratificacao").value='';

            /*document.form1.l20_dtpubratificacao.style.backgroundColor='#E6E4F1';)*/

            /*Demandas sicom 2016*/
            document.form1.l20_tipliticacao.style.display = 'inline';
            document.form1.l20_tipnaturezaproced.style.display = 'inline';
            document.form1.l20_criterioadjudicacao.style.display = 'inline';
            document.form1.l20_numeroconvidado.style.display = 'inline';
            document.form1.l20_dataaber.style.display = 'inline';
            document.form1.dtjs_l20_dataaber.style.display = 'inline';
            document.form1.l20_dtpublic.style.display = 'inline';
            document.form1.dtjs_l20_dtpublic.style.display = 'inline';
            document.form1.l20_recdocumentacao.style.display = 'inline';
            document.form1.dtjs_l20_recdocumentacao.style.display = 'inline';
            document.form1.l20_datapublicacao1.style.display = 'inline';
            document.form1.dtjs_l20_datapublicacao1.style.display = 'inline';
            document.form1.l20_nomeveiculo1.style.display = 'inline';
            document.form1.l20_datapublicacao2.style.display = 'inline';
            document.form1.dtjs_l20_datapublicacao2.style.display = 'inline';
            document.form1.l20_nomeveiculo2.style.display = 'inline';
            document.form1.l20_usaregistropreco.style.display = 'inline';
            document.form1.l20_equipepregao.style.display = 'inline';
            document.form1.l20_local.style.display = 'inline';
            document.form1.l20_aceitabilidade.style.display = 'inline';

            //document.getElementById("tipolicitacao").style.display='inline';
            document.getElementById("tipnaturezaproced").style.display = 'inline';
            document.getElementById("descontotab").style.display = 'inline';
            document.getElementById("numeroconvidado").style.display = 'inline';
            document.getElementById("dataaber").style.display = 'inline';
            document.getElementById("dtpublic").style.display = 'inline';
            document.getElementById("recdocumentacao").style.display = 'inline';
            document.getElementById("datapublicacao1").style.display = 'inline';
            document.getElementById("nomeveiculo1").style.display = 'inline';
            document.getElementById("datapublicacao2").style.display = 'inline';
            document.getElementById("nomeveiculo2").style.display = 'inline';
            document.getElementById("usaregistropreco").style.display = 'inline';
            document.getElementById("equipepregao").style.display = 'inline';
            document.getElementById("local").style.display = 'inline';
            document.getElementById("aceitabilidade").style.display = 'inline';


        }

        let aModalidades = ['48', '49', '50', '52', '53', '54'];
        let anousu = <?= db_getsession('DB_anousu'); ?>;

        if (anousu >= 2021) {
            aModalidades.push('102', '103');
        }

        if (aModalidades.includes(oRetorno.tribunal) && anousu >= 2020) {
            document.getElementById('linha_nroedital').style.display = '';
        } else {
            document.getElementById('linha_nroedital').style.display = 'none';
        }

        let tiposLicitacoes = document.getElementById('l20_tipliticacao').options;
        let listaExecucoes = document.getElementById('l20_regimexecucao').options;

        if (anousu >= 2020) {
            if (oRetorno.tribunal == 107) {
                tiposLicitacoes.add(new Option("5- Maior Oferta de Preço", 5));
                tiposLicitacoes.add(new Option("6- Maior Retorno Econômico", 6));


            } else {
                /* Remove tipos de licitações */
                if (tiposLicitacoes.item(6)) {
                    tiposLicitacoes.remove(6);
                }
                if (tiposLicitacoes.item(5)) {
                    tiposLicitacoes.remove(5);
                }

            }
        }

        if ($F('l20_equipepregao') != '') {
            let modalidade = document.form1.modalidade_tribunal.value; //document.form1.l20_codtipocomdescr.value;

            if (modalidade == 52 || modalidade == 53) {
                verificaMembrosModalidade("pregao");
            } else if (modalidade == 48 || modalidade == 49 || modalidade == 50) {
                verificaMembrosModalidade("outros");
            }
        }

    }
    /*adequando os campos para evitar  o preenchimento pelo usuario caso nao seja um tipo de  INEXIGIBILIDADE*/
    // document.getElementById("l20_veicdivulgacao").disabled=true;
    // document.getElementById("l20_dtpubratificacao").disabled=true;
    document.getElementById("l20_justificativa").disabled = true;
    document.getElementById("l20_razao").disabled = true;
    document.getElementById("l20_tipoprocesso").disabled = true;
    //document.getElementById("l20_dtpubratificacao").value='';

    /*para habiliatar o campo caso seja inex*/

    var campo = document.getElementById("l20_codtipocomdescr").options[document.getElementById("l20_codtipocomdescr").selectedIndex].text;
    campo = campo.replace(" ", "");
    if ([100, 101, 102, 103].includes(oRetorno.tribunal)) {
        // if(oRetorno.tribunal==100 || oRetorno.tribunal==101 || oRetorno.tribunal==102 || oRetorno.tribunal==103){
        //     document.getElementById("l20_veicdivulgacao").disabled=false;
        //     document.getElementById("l20_dtpubratificacao").disabled=false;
        document.getElementById("l20_justificativa").disabled = false;
        document.getElementById("l20_razao").disabled = false;
        document.getElementById("l20_tipoprocesso").disabled = false;
        //     document.getElementById("l20_dtpubratificacao").value='';
        //
        //     document.form1.l20_justificativa.style.backgroundColor='#FFFFFF ';
        //     document.form1.l20_dtpubratificacao.style.backgroundColor='#FFFFFF ';
        //     document.form1.l20_veicdivulgacao.style.backgroundColor='#FFFFFF ';
        document.form1.l20_justificativa.style.backgroundColor = '#FFFFFF ';
        document.form1.l20_razao.style.backgroundColor = '#FFFFFF ';

    }

    function js_busca() {

        var codigocompra = document.getElementById("l20_codtipocom").options[document.getElementById("l20_codtipocom").selectedIndex].text;
        var oParam = new Object();
        oParam.codigo = codigocompra;
        var url = 'lic1_liclicita_consulta.php';
        var oAjax = new Ajax.Request(url, {
            method: 'post',
            parameters: 'json=' + Object.toJSON(oParam),
            onComplete: js_retornolicitacao
        });
    }

    function js_naturezaprocedimento(valor) {
        if (valor == 2) {
            $('l20_usaregistropreco').value = 't';
            $('l20_usaregistropreco').disabled = "disabled";

        } else if (valor == 1) {
            $('l20_usaregistropreco').value = 'f';
            $('l20_usaregistropreco').disabled = "disabled";

        } else if (valor == 3) {
            $('l20_usaregistropreco').value = 'f';
            $('l20_usaregistropreco').disabled = '';
        }
    }

    function js_ativaregistro() {

        document.getElementById("l20_codtipocom").disabled = false;
        document.getElementById("l20_codtipocomdescr").disabled = false;
        var campo = $(l20_tipnaturezaproced).value;
        $('l20_usaregistropreco').disabled = "";
        var campo = document.getElementById("l20_codtipocomdescr").options[document.getElementById("l20_codtipocomdescr").selectedIndex].text;
        var convite = document.getElementById('l20_numeroconvidado').value;

        document.getElementById('descricao').value = campo;
        document.form1.submit();

    }

    function js_verifica_hora(valor, campo) {
        erro = 0;
        ms = "";
        hs = "";

        tam = "";
        pos = "";
        tam = valor.length;
        pos = valor.indexOf(":");
        if (pos != -1) {
            if (pos == 0 || pos > 2) {
                erro++;
            } else {
                if (pos == 1) {
                    hs = "0" + valor.substr(0, 1);
                    ms = valor.substr(pos + 1, 2);
                } else if (pos == 2) {
                    hs = valor.substr(0, 2);
                    ms = valor.substr(pos + 1, 2);
                }
                if (ms == "") {
                    ms = "00";
                }
            }
        } else {
            if (tam >= 4) {
                hs = valor.substr(0, 2);
                ms = valor.substr(2, 2);
            } else if (tam == 3) {
                hs = "0" + valor.substr(0, 1);
                ms = valor.substr(1, 2);
            } else if (tam == 2) {
                hs = valor;
                ms = "00";
            } else if (tam == 1) {
                hs = "0" + valor;
                ms = "00";
            }
        }
        if (ms != "" && hs != "") {
            if (hs > 24 || hs < 0 || ms > 60 || ms < 0) {
                erro++
            } else {
                if (ms == 60) {
                    ms = "59";
                }
                if (hs == 24) {
                    hs = "00";
                }
                hora = hs;
                minu = ms;
            }
        }

        if (erro > 0) {
            alert("Informe uma hora válida.");
        }
        if (valor != "") {
            eval("document.form1." + campo + ".focus();");
            eval("document.form1." + campo + ".value='" + hora + ":" + minu + "';");
        }
    }

    var sUrl = "lic4_licitacao.RPC.php";
    var oTipoJulgamento = $('trTipoJulgamento');



    function verificaTipoJulgamento() {

        oTipoJulgamento.style.display = '';
        if ($F('l20_formacontroleregistropreco') == "2") {
            $('l20_tipojulg').value = "1";
            oTipoJulgamento.style.display = 'none';
        }
    }

    $('l20_codtipocom').observe('change', function() {
        js_verificaModalidade();
    });
    $('l20_codtipocomdescr').observe('change', function() {

        js_verificaModalidade();
    });

    function js_verificaModalidade() {
        js_divCarregando("Aguarde, pesquisando dados da modalidade.", "msgBox");
        var oParam = new Object();
        oParam.exec = "verificaModalidade";
        oParam.iModalidade = $F('l20_codtipocom');

        var oAjax = new Ajax.Request(sUrl, {
            method: "post",
            parameters: 'json=' + Object.toJSON(oParam),
            onComplete: js_retornoVerificaModalidade
        });

    }

    function js_retornoVerificaModalidade(oAjax) {

        js_removeObj("msgBox");
        var oRetorno = eval("(" + oAjax.responseText + ")");

        $("l20_usaregistropreco").options.length = 0;
        if (oRetorno.l03_usaregistropreco == 't') {
            //true pode por sim nao no campo l20_usaregistropreco

            $("l20_usaregistropreco").options[0] = new Option("Não", "f");
            $("l20_usaregistropreco").options[1] = new Option("Sim", "t");
        } else {
            // false somentenao
            $("l20_usaregistropreco").options[0] = new Option("Não", "f");
        }
    }

    function js_mudaProc(sTipoProc) {

        if (sTipoProc == 's') {
            $('procSis').style.display = '';
            $('procAdm').style.display = 'none';
        } else {
            $('procSis').style.display = 'none';
            $('procAdm').style.display = '';
        }

    }

    function js_pesquisal20_codepartamento(mostra) {
        if (mostra == true) {
            var sUrl = 'func_db_depart.php?funcao_js=parent.js_mostradepartamento|coddepto|descrdepto';
            js_OpenJanelaIframe('', 'db_iframe_departamento', sUrl, 'Pesquisar Departamento', true, '0');
        } else {
            if (document.form1.l20_codepartamento.value != '') {
                js_OpenJanelaIframe('', 'db_iframe_departamento', 'func_db_depart.php?pesquisa_chave=' + document.form1.l20_codepartamento.value + '&funcao_js=parent.js_mostrardepartamento',
                    'Pesquisar licitação Outro Órgão',
                    false,
                    '0');
            }
        }

    }

    function js_mostrardepartamento(chave, erro) {
        document.form1.l20_descricaodep.value = chave;

        if (erro == true) {
            document.form1.l20_descricaodep.focus();
        }
    }

    function js_mostradepartamento(chave, chave2) {
        $('l20_codepartamento').value = chave;
        $('l20_descricaodep').value = chave2;
        $('l20_codepartamento').focus();

        db_iframe_departamento.hide();
    }

    function js_pesquisal20_codtipocom(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('', 'db_iframe_pctipocompra', 'func_pctipocompra.php?funcao_js=parent.js_mostrapctipocompra1|pc50_codcom|pc50_descr', 'Pesquisa', true, 0);
        } else {
            if (document.form1.l20_codtipocom.value != '') {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_pctipocompra', 'func_pctipocompra.php?pesquisa_chave=' + document.form1.l20_codtipocom.value + '&funcao_js=parent.js_mostrapctipocompra', 'Pesquisa', false);
            } else {
                document.form1.pc50_descr.value = '';
            }
        }
    }

    function js_mostrapctipocompra(chave, erro) {
        document.form1.pc50_descr.value = chave;
        if (erro == true) {
            document.form1.l20_codtipocom.focus();
            document.form1.l20_codtipocom.value = '';
        }
    }

    function js_mostrapctipocompra1(chave1, chave2) {
        document.form1.l20_codtipocom.value = chave1;
        document.form1.pc50_descr.value = chave2;
        db_iframe_pctipocompra.hide();
    }

    function js_pesquisal20_id_usucria(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('', 'db_iframe_db_usuarios', 'func_db_usuarios.php?funcao_js=parent.js_mostradb_usuarios1|id_usuario|nome', 'Pesquisa', true, 0);
        } else {
            if (document.form1.l20_id_usucria.value != '') {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_db_usuarios', 'func_db_usuarios.php?pesquisa_chave=' + document.form1.l20_id_usucria.value + '&funcao_js=parent.js_mostradb_usuarios', 'Pesquisa', false);
            } else {
                document.form1.nome.value = '';
            }
        }
    }

    function js_mostradb_usuarios(chave, erro) {
        document.form1.nome.value = chave;
        if (erro == true) {
            document.form1.l20_id_usucria.focus();
            document.form1.l20_id_usucria.value = '';
        }
    }

    function js_mostradb_usuarios1(chave1, chave2) {
        document.form1.l20_id_usucria.value = chave1;
        document.form1.nome.value = chave2;
        db_iframe_db_usuarios.hide();
    }

    function js_pesquisa() {
        js_OpenJanelaIframe('', 'db_iframe_liclicita', 'func_liclicita.php?tipo=1&situacao=0&funcao_js=parent.js_preenchepesquisa|l20_codigo', 'Pesquisa', true, "0");
    }

    function js_preenchepesquisa(chave) {
        db_iframe_liclicita.hide();
        <?
        if ($db_opcao != 1) {
            echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave;";
        ?>
            parent.iframe_liclicitem.location.href = 'lic1_liclicitemalt001.php?licitacao=' + chave;
        <?
        }
        ?>
    }

    function js_pesquisal20_liclocal(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('', 'db_iframe_local', 'func_liclocal.php?funcao_js=parent.js_mostralocal1|l26_codigo', 'Pesquisa', true, "0");
        } else {
            if (document.form1.l20_liclocal.value != '') {
                js_OpenJanelaIframe('', 'db_iframe_local', 'func_liclocal.php?pesquisa_chave=' + document.form1.l20_liclocal.value + '&funcao_js=parent.js_mostralocal&sCampoRetorno=l20_liclocal', 'Pesquisa', false);
            } else {
                document.form1.nome.value = '';
            }
        }
    }

    function js_mostralocal(chave, erro) {
        if (erro == true) {
            document.form1.l20_liclocal.focus();
            document.form1.l20_liclocal.value = '';
        }
    }

    function js_mostralocal1(chave1) {
        document.form1.l20_liclocal.value = chave1;
        db_iframe_local.hide();
    }

    function js_pesquisal20_liccomissao(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('', 'db_iframe_comissao', 'func_liccomissao.php?funcao_js=parent.js_mostracomissao1|l30_codigo', 'Pesquisa', true, "0");
        } else {

            if (document.form1.l20_liccomissao.value != '') {
                js_OpenJanelaIframe('', 'db_iframe_proc', 'func_liccomissao.php?pesquisa_chave=' + document.form1.l20_liccomissao.value + '&funcao_js=parent.js_mostracomissao&sCampoRetorno=l20_liccomissao', 'Pesquisa', false);
            } else {
                document.form1.l20_liccomissao.value = '';
            }



        }
    }

    function js_mostracomissao(chave, erro) {
        if (erro == true) {
            document.form1.l20_liccomissao.focus();
            document.form1.l20_liccomissao.value = '';
        }
    }

    function js_mostracomissao1(chave1) {
        document.form1.l20_liccomissao.value = chave1;
        db_iframe_comissao.hide();
    }

    function js_pesquisal34_protprocesso(mostra) {

        if (mostra == true) {
            js_OpenJanelaIframe('', 'db_iframe_proc', 'func_protprocesso_protocolo.php?funcao_js=parent.js_mostraprocesso1|p58_numero|p58_codproc|dl_nome_ou_razão_social', 'Pesquisa', true, "0");
        } else {

            if (document.form1.p58_numero.value != '') {
                js_OpenJanelaIframe('', 'db_iframe_proc', 'func_protprocesso_protocolo.php?pesquisa_chave=' + document.form1.p58_numero.value + '&funcao_js=parent.js_mostraprocesso&sCampoRetorno=p58_codproc', 'Pesquisa', false);
            } else {
                document.form1.l34_protprocessodescr.value = '';
            }
        }
    }

    function js_mostraprocesso(iCodigoProcesso, sNome, lErro) {

        document.form1.l34_protprocessodescr.value = sNome;

        if (lErro) {

            document.form1.p58_numero.focus();
            document.form1.p58_numero.value = '';
            document.form1.l34_protprocesso.value = '';
            return false;
        }

        document.form1.l34_protprocesso.value = iCodigoProcesso;

        db_iframe_proc.hide();
    }

    function js_mostraprocesso1(iNumeroProcesso, iCodigoProcesso, sNome) {

        document.form1.p58_numero.value = iNumeroProcesso;
        document.form1.l34_protprocesso.value = iCodigoProcesso;
        document.form1.l34_protprocessodescr.value = sNome;
        db_iframe_proc.hide();
    }

    function js_pesquisal20_equipepregao(mostra) {

        if (mostra == true) {
            js_OpenJanelaIframe('', 'db_iframe_proc', 'func_licpregao.php?funcao_js=parent.js_pregao|l45_sequencial', 'Pesquisa', true, "0");
        } else {

            if (document.form1.l20_equipepregao.value != '') {
                js_OpenJanelaIframe('', 'db_iframe_proc', 'func_licpregao.php?pesquisa_chave=' + document.form1.l20_equipepregao.value + '&funcao_js=parent.js_pregao&sCampoRetorno=l20_equipepregao', 'Pesquisa', false);
            } else {
                document.form1.nome.value = '';
            }
        }
    }

    function novoAjax(params, onComplete) {

        var request = new Ajax.Request('lic4_licitacao.RPC.php', {
            method: 'post',
            parameters: 'json=' + Object.toJSON(params),
            onComplete: onComplete
        });

    }

    function verificaMembrosModalidade(modalidade) {
        var params = {
            exec: 'VerificaMembrosModalidade',
            equipepregao: $F('l20_equipepregao'),
            modalidade: modalidade
        };

        novoAjax(params, function(e) {
            var oRetorno = JSON.parse(e.responseText);
            if (oRetorno.validaMod == 0) {
                if (modalidade == 'pregao') {
                    alert("Para as modalidades Pregão presencial e Pregão eletrônico é necessário\nque a Comissão de Licitação tenham os tipos Pregoeiro e Membro da Equipe de Apoio");
                    document.form1.l20_equipepregao.value = "";
                    document.form1.l20_equipepregao.focus();
                    return false;
                } else if (modalidade == 'outros') {
                    alert("Para as modalidades Tomada de Preços, Concorrência e Convite é necessário\nque a Comissão de Licitação tenham os tipos Secretário, Presidente e Membro da Equipe de Apoio");
                    document.form1.l20_equipepregao.value = "";
                    document.form1.l20_equipepregao.focus();
                    return false;
                }
            }
        });
    }

    function js_pregao(iCodigoProcesso, sNome, lErro) {

        document.form1.l20_equipepregao.value = iCodigoProcesso;
        db_iframe_proc.hide();

        let modalidade = document.form1.modalidade_tribunal.value; //document.form1.l20_codtipocomdescr.value;

        if (modalidade == 52 || modalidade == 53) {
            verificaMembrosModalidade("pregao");
        } else if (modalidade == 48 || modalidade == 49 || modalidade == 50) {
            verificaMembrosModalidade("outros");
        }

    }

    var sUrl = "lic4_licitacao.RPC.php";

    function js_mostraRegistroPreco() {

        js_divCarregando("Aguarde, pesquisando parametros", "msgBox");
        var oParam = new Object();
        oParam.exec = "verificaParametros";
        oParam.itipoLicitacao = $F('l20_codtipocom');
        db_iframe_estimativaregistropreco.hide();
        var oAjax = new Ajax.Request(sUrlRC, {
            method: "post",
            parameters: 'json=' + Object.toJSON(oParam),
            onComplete: js_retornoRegistroPreco
        });

    }

    function js_retornoRegistroPreco(oAjax) {

        js_removeObj("msgBox");
        var oRetorno = eval("(" + oAjax.responseText + ")");
        if (oRetorno.status == 1) {}
    }

    function js_verificaCritAdj(valor) {
        var codtipocom = $F('l20_codtipocom');
        return valor == codtipocom;
    }

    function js_confirmadatas() {

        var dataCriacao = $F('l20_datacria');
        var dataPublicacao = $F('l20_dtpublic');
        var dataAbertura = $F('l20_dataaber');
        var critadjudicac = $F('l20_criterioadjudicacao');
        var matriz = [1, 2, 3, 4, 5, 11, 19];
        var verifica = matriz.find(js_verificaCritAdj);

        if (verifica) {
            if (!critadjudicac) {
                alert("Informe Critério de Adjudicação");
                return false;
            }
        }

        if (js_CompararDatas(dataCriacao, dataPublicacao, '<=')) {
            if (js_CompararDatas(dataPublicacao, dataAbertura, '<=')) {
                <?
                if ($db_opcao == 2 || $db_opcao == 22) {
                    echo 'return js_confirmar();';
                } else {
                    echo 'return true;';
                }
                ?>
            } else {

                /*alert("A Data Edital/Convite deve ser maior ou igual a Data de Publicação.");
                document.form1.l20_dataaber.style.backgroundColor='#99A9AE';
                 document.form1.l20_dataaber.focus();
                return false;*/
            }
        } else {
            /*alert("A Data de Publicação deve ser maior ou igual a Data de Criação.");
            return false;*/
        }

    }

    function js_CompararDatas(data1, data2, comparar) {

        if (data1.indexOf('/') != -1) {
            datepart = data1.split('/');
            pYear = datepart[2];
            pMonth = datepart[1];
            pDay = datepart[0];
        }
        data1 = pYear + pMonth + pDay;

        if (data2.indexOf('/') != -1) {
            datepart = data2.split('/');
            pYear = datepart[2];
            pMonth = datepart[1];
            pDay = datepart[0];
        }
        data2 = pYear + pMonth + pDay;
        if (eval(data1 + " " + comparar + " " + data2)) {

            return true;

        } else {
            return false;
        }
    }

    /*Para desabilitar o combo  Usa Registro de Preço */
    var campo = $(l20_tipnaturezaproced).value;
    if (campo == '2') {
        $('l20_usaregistropreco').value = 't';
        $('l20_usaregistropreco').disabled = "disabled";
    }



    //$('l20_descontotab').value='2';


    // document.form1.l20_dtpubratificacao.style.backgroundColor='#E6E4F1';
    // document.form1.l20_veicdivulgacao.style.backgroundColor='#E6E4F1';
    document.form1.l20_justificativa.style.backgroundColor = '#E6E4F1';
    document.form1.l20_razao.style.backgroundColor = '#E6E4F1';
    document.getElementById("l20_numeroconvidado").readOnly = true;

    var campo = document.getElementById("l20_codtipocomdescr").options[document.getElementById("l20_codtipocomdescr").selectedIndex].text;
    if (campo == "CONVITE") {
        document.getElementById("l20_numeroconvidado").readOnly = false;
    }



    /*Função para limitar texaarea*/
    //"onkeyup='limitaTextarea(this.value);'");
    function limitaTextarea(valor) {
        var qnt = valor.value;
        quantidade = 80;
        total = qnt.length;

        if (total <= quantidade) {
            resto = quantidade - total;
            document.getElementById('contador').innerHTML = resto;
        } else {
            document.getElementById(valor.name).value = qnt.substr(0, quantidade);
            alert("Olá. Para atender  as normas do TCE MG / SICOM, este campo é  limitado. * LIMITE ALCANÇADO * !");
        }
    }

    function limitaTextareaobj(valor) {
        var qnt = valor.value;
        const arra = qnt.split("\n");
        var valAr = arra.length;
        var res = "";

        if (valAr > 1) {
            for (i = 0; i < valAr; i++) {
                res += " " + arra[i];
            }

            qnt = res;
            document.getElementById(valor.name).value = qnt;
        }

        quantidade = 499;
        total = qnt.length;

        if (total <= quantidade) {
            resto = quantidade - total;
            document.getElementById('contador').innerHTML = resto;
        } else {
            document.getElementById(valor.name).value = qnt.substr(0, quantidade);
            alert("Olá. Para atender  as normas do TCE MG / SICOM, este campo é  limitado. * LIMITE ALCANÇADO * !");
        }
    }

    function doNothing() {
        var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
        if (keyCode == 13) {


            if (!e) var e = window.event;

            e.cancelBubble = true;
            e.returnValue = false;

            if (e.stopPropagation) {
                e.stopPropagation();
                e.preventDefault();
            }
        }
    }

    function limitaTextareacpro(valor) {
        var qnt = valor.value;
        quantidade = 249;
        total = qnt.length;

        if (total <= quantidade) {
            resto = quantidade - total;
            document.getElementById('contador').innerHTML = resto;
        } else {
            document.getElementById(valor.name).value = qnt.substr(0, quantidade);
            alert("Olá. Para atender  as normas do TCE MG / SICOM, este campo é  limitado. * LIMITE ALCANÇADO * !");
        }
    }

    <?
    if ($db_opcao == 1) {
        echo "js_mudaProc('{$lprocsis}');";
    } else {
        if ((isset($l34_protprocesso) && trim($l34_protprocesso) != '')) {
            echo "js_mudaProc('s');";
        }
    }
    ?>

    function mostrarFormaControleRegistroPreco() {

        if ($F('l20_usaregistropreco') == 't') {
            $('formacontraleregistropreco').style.display = '';
        } else {
            $('l20_formacontroleregistropreco').value = '1'
            $('formacontraleregistropreco').style.display = 'none';
        }



        verificaTipoJulgamento();
    }

    function js_regime(valor) {
        let anousuario = "<?php echo db_getsession('DB_anousu'); ?>";

        if (anousuario >= 2019) {
            let opcoes = document.getElementById('l20_regimexecucao').options;

            if (document.getElementById('modalidade_tribunal').value) {
                console.log('Opcoes: ', opcoes);
                if (valor != 7) {
                    if (opcoes.item(7)) {
                        opcoes.remove(7);
                    }
                    if (opcoes.item(6)) {
                        opcoes.remove(6);
                    }
                    if (opcoes.item(5)) {
                        opcoes.remove(5);
                    }
                }

                if (valor == 7) {
                    opcoes.add(new Option('5- Execução Direta', 5));
                    opcoes.add(new Option('6- Contratação Integrada'), 6);
                    opcoes.add(new Option('7- Contratação Semi Integrada', 7));
                }
            }

        }
    }
</script>
<?
if (empty($l34_liclicita)) {
    echo "<script>
         document.form1.lprocsis.value = 'n';
         $('procSis').style.display = 'none';
         $('procAdm').style.display = '';
        </script>";
}
?>
<script>
    mostrarFormaControleRegistroPreco();

    function bloquearRegistroPreco() {

        $('l20_usaregistropreco').disabled = true;
        $('l20_usaregistropreco').className = 'readonly';
        $('l20_formacontroleregistropreco').disabled = true;
        $('l20_formacontroleregistropreco').className = 'readonly';
        verificaTipoJulgamento();
    }
</script>