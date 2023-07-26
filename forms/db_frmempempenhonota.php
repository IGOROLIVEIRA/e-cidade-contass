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

//MODULO: empenho
$clempautoriza->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");
$clrotulo->label("nome");
$clrotulo->label("e44_tipo");
$clrotulo->label("pc50_descr");
$clrotulo->label("e57_codhist");
$clrotulo->label("c58_descr");
$clrotulo->label("e69_numero");
$clrotulo->label("e69_dtnota");
$clrotulo->label("ac16_sequencial");
$clrotulo->label("ac16_resumoobjeto");
$clrotulo->label("ac10_obs");
$clrotulo->label("e50_obs");
$clrotulo->label("e60_convenio");
$clrotulo->label("e60_numconvenio");
$clrotulo->label("e60_dataconvenio");
$clrotulo->label("e60_datasentenca");
$clrotulo->label("e54_gestaut");
$clrotulo->label("e40_codhist");
$clrotulo->label("e40_historico");
$clrotulo->label("e60_emiss");
$clrotulo->label("e60_emiss");

if(isset($e57_codhist)){
    $query = "select e40_descr from emphist where e40_codhist = $e57_codhist";
    $resultado = db_query($query);
    $resultado = db_utils::fieldsMemory($resultado, 0);
    $e40_descr=$resultado->e40_descr;
}
if(!$e57_codhist){
    $query = "select distinct e57_codhist from empauthist where e57_codhist = 0";
    $resultado = db_query($query);
    $resultado = db_utils::fieldsMemory($resultado, 0);
    $e57_codhist=$resultado->e57_codhist;
    $query = "select e40_descr from emphist where e40_codhist = $e57_codhist";
    $resultado = db_query($query);
    $resultado = db_utils::fieldsMemory($resultado, 0);
    $e40_descr=$resultado->e40_descr;
}


if ($db_opcao == 1) {
    $ac = "emp4_empempenho004.php";
} else if ($db_opcao == 2 || $db_opcao == 22) {
    // $ac="emp1_empautoriza005.php";
} else if ($db_opcao == 3 || $db_opcao == 33) {
    //  $ac="emp1_empautoriza006.php";
}
$db_disab = true;
if (isset($chavepesquisa) && $db_opcao == 1) {
    $result_param = $clpcparam->sql_record($clpcparam->sql_query_file(db_getsession("DB_instit")));
    if ($clpcparam->numrows > 0) {
        db_fieldsmemory($result_param, 0);
        if ($pc30_contrandsol == 't') {
            $sql = "    select  pc81_codprocitem
      from (   select solandam.pc43_solicitem,
      max(pc43_ordem) as pc43_ordem
      from solandam
      group by solandam.pc43_solicitem
      ) as x
      inner join solandam             on solandam.pc43_solicitem             = x.pc43_solicitem
      and solandam.pc43_ordem                 = x.pc43_ordem
      inner join solandpadrao         on solandam.pc43_solicitem             = solandpadrao.pc47_solicitem
      and solandam.pc43_ordem                 = solandpadrao.pc47_ordem
      inner join pcprocitem           on x.pc43_solicitem                    = pc81_solicitem
      inner join empautitempcprocitem on empautitempcprocitem.e73_pcprocitem = pcprocitem.pc81_codprocitem
      inner join empautitem           on empautitem.e55_autori               = empautitempcprocitem.e73_autori
      and empautitem.e55_sequen               = empautitempcprocitem.e73_sequen
      inner join solicitemprot        on pc49_solicitem                      = x.pc43_solicitem
      where e55_autori= {$chavepesquisa}
      and solandpadrao.pc47_pctipoandam <> 7
      and solandam.pc43_depto = " . db_getsession("DB_coddepto");

            $result_andam = db_query($sql);
            if (pg_numrows($result_andam) > 0) {
                $sqltran = "select distinct x.p62_codtran,
        x.pc11_numero,
        x.pc11_codigo,
        x.p62_dttran,
        x.p62_hora,
        x.descrdepto,
        x.login
        from ( select distinct p62_codtran,
        p62_dttran,
        p63_codproc,
        descrdepto,
        p62_hora,
        login,
        pc11_numero,
        pc11_codigo,
        pc81_codproc,
        e55_autori,
        e54_anulad
        from proctransferproc

        inner join solicitemprot on pc49_protprocesso = proctransferproc.p63_codproc
        inner join solicitem on pc49_solicitem = pc11_codigo
        inner join proctransfer on p63_codtran = p62_codtran
        inner join db_depart on coddepto = p62_coddepto
        inner join db_usuarios on id_usuario = p62_id_usuario
        inner join pcprocitem on pcprocitem.pc81_solicitem = solicitem.pc11_codigo
        inner join empautitem on empautitem.e55_sequen = pcprocitem.pc81_codprocitem
        inner join empautoriza on empautoriza.e54_autori= empautitem.e55_autori
        where  p62_coddeptorec = " . db_getsession("DB_coddepto") . "
        ) as x
        left join proctransand 	on p64_codtran = x.p62_codtran
        left join arqproc 	on p68_codproc = x.p63_codproc
        where p64_codtran is null and
        p68_codproc is null and
        x.e55_autori = $chavepesquisa";

                $result_tran = db_query($sqltran);
                if (pg_numrows($result_tran) == 0) {
                    $db_disab = false;
                }
            } // else {
            //   $db_disab = false;
            //}
        }
    }
}
?>
<form name="form1" method="post" action="<?= $ac ?>">

    <fieldset style="width:900px">
        <legend><strong>Emisso do Empenho</strong></legend>


        <input type=hidden name=dadosRet value="">
        <input type=hidden name=chavepesquisa value="<?= $chavepesquisa ?>">

        <?php
        db_input('lanc_emp', 6, "", true, 'hidden', 3);
        db_input('lLiquidaMaterialConsumo', 10, "", true, 'hidden', 3);
        db_input('iElemento', 20, "", true, 'hidden', 3);
        db_input('e60_numemp', 20, "", true, 'hidden', 3);
        ?>

        <center>
        <table border="0">
                <tr>
                    <td nowrap title="Nmero Empenho">
                        <b>Nmero do Empenho</b>
                    </td>
                    <td>
                        <?php
                        db_input('e60_codemp', 8, $Ie60_codemp, true, 'text', $db_opcao, "onchange='js_ValidaCampos(),'");
                        echo " ","<b></b>","&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                        ?>
                        <b> Data Empenho:</b>
                        <?
                            if($db_opcao ==  1 && !$e60_emiss){
                                $e60_emiss_dia = date("d",db_getsession("DB_datausu"));
                                $e60_emiss_mes = date("m",db_getsession("DB_datausu"));
                                $e60_emiss_ano = date("Y",db_getsession("DB_datausu"));
                            }
                            db_inputData('e60_emiss', @$e60_emiss_dia, @$e60_emiss_mes, @$e60_emiss_ano, true, 'text', $db_opcao);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Te54_autori ?>">
                        <?= @$Le54_autori ?>
                    </td>
                    <td>
                        <?
                        db_input('e54_autori', 8, $Ie54_autori, true, 'text', 3);
                        echo " ","<b></b>","&nbsp;&nbsp;&nbsp;&nbsp;";
                        ?>
                        <b> Data Autorizao:</b>

                        <?
                          db_inputData('e54_emiss', @$e54_emiss_dia, @$e54_emiss_mes, @$e54_emiss_ano, true, 'text', 3);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Te54_numcgm ?>">
                    <b> Credor:</b>
                    </td>
                    <td>
                        <?
                        db_input('e54_numcgm', 8, $Ie54_numcgm, true, 'text', 3);
                        db_input('z01_nome', 100, $Iz01_nome, true, 'text', 3);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Te54_codcom ?>">
                        <?= @$Le54_codcom ?>
                    </td>
                    <td>
                        <?
                        if (isset($e54_codcom) && $e54_codcom == '') {
                            $pc50_descr = '';
                        }

                        /*
                           a opo mantem a seleo escolhida pelo usuario ao trocar o tipo de compra


                        */
                        if (isset($tipocompra) && $tipocompra != '') {
                            $e54_codcom = $tipocompra;
                        }

                        $result = $clpctipocompra->sql_record($clpctipocompra->sql_query_file(null, "pc50_codcom as e54_codcom,pc50_descr"));
                        db_selectrecord("e54_codcom", $result, true, $db_opcao, "", "", "", "", "js_reload(this.value)");
                        db_selectrecord("e54_codcom", $result, true, $db_opcao, "", "", "", "", "js_verificaTipoCompra(this.value, 'js_validaMudancaTipoCompra');");

                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Te54_tipol ?>">
                        <?= @$Le54_tipol ?>
                    </td>
                    <td>
                        <?
                        if (isset($tipocompra) || isset($e54_codcom)) {
                            if (isset($e54_codcom) && empty($tipocompra)) {
                                $tipocompra = $e54_codcom;
                            }
                            $instit = db_getsession("DB_instit");
                            $result = $clcflicita->sql_record($clcflicita->sql_query_file(null, "l03_tipo,l03_descr", '', "l03_codcom=$tipocompra and l03_instit = $instit"));
                            if ($clcflicita->numrows > 0) {
                                db_selectrecord("e54_tipol", $result, true, 1, "", "", "");
                                $dop = $db_opcao;
                            } else {
                                $e54_tipol2 = '';
                                $e54_tipol = '';
                                $e54_numerl = '';
                                db_input('e54_tipol2', 61, $Ie54_tipol, true, 'text', 3);
                                $dop = '3';
                            }
                        } else {
                            $dop = '3';
                            $e54_tipol = '';
                            $e54_numerl = '';
                            db_input('e54_tipol', 11, $Ie54_tipol, true, 'text', 3);
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?= @$Le54_numerl ?>
                    </td>
                    <td>
                        <?
                        db_input('e54_numerl', 8, $Ie54_numerl, true, 'text', 3, "onchange='js_validaNumLicitacao();'");
                        echo " ","<b></b>","&nbsp;&nbsp;&nbsp;&nbsp;";
                        ?>
                        <strong>Modalidade:</strong>

                        <?
                        db_input('e54_nummodalidade', 61, $e54_nummodalidade, true, 'text', 3, "");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Te54_codtipo ?>">
                        <?= $Le54_codtipo ?>
                    </td>
                    <td>
                        <?
                        $result = $clemptipo->sql_record($clemptipo->sql_query_file(null, "e41_codtipo,e41_descr"));
                        db_selectrecord("e54_codtipo", $result, true, $db_opcao);

                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Te44_tipo ?>">
                        <?= $Le44_tipo ?>
                    </td>
                    <td>
                        <?
                        $result = $clempprestatip->sql_record($clempprestatip->sql_query_file(null, "e44_tipo as tipo,e44_descr,e44_obriga", "e44_obriga "));
                        $numrows = $clempprestatip->numrows;
                        $arr = array();
                        for ($i = 0; $i < $numrows; $i++) {
                            db_fieldsmemory($result, $i);
                            if ($e44_obriga == 0 && empty($e44_tipo)) {
                                $e44_tipo = $tipo;
                            }
                            $arr[$tipo] = $e44_descr;
                        }
                        db_select("e44_tipo", $arr, true, 1);

                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="Desdobramentos">
                        <b>Desdobramento:</b>
                    </td>
                    <td>
                        <?
                        if (isset($e54_autori)) {
                            $anoUsu = db_getsession("DB_anousu");
                            $sWhere = "e56_autori = " . $e54_autori . " and e56_anousu = " . $anoUsu;
                            $result = $clempautidot->sql_record($clempautidot->sql_query_dotacao(null, "e56_coddot", null, $sWhere));
                            echo pg_last_error();
                            if ($clempautidot->numrows > 0) {
                                $oResult = db_utils::fieldsMemory($result, 0);
                                $result = $clorcdotacao->sql_record($clorcdotacao->sql_query($anoUsu, $oResult->e56_coddot, "o56_elemento,o56_codele"));
                                if ($clorcdotacao->numrows > 0) {

                                    $oResult = db_utils::fieldsMemory($result, 0);
                                    $oResult->estrutural = criaContaMae($oResult->o56_elemento . "00");
                                    $sWhere = "o56_elemento like '$oResult->estrutural%' and o56_codele <> $oResult->o56_codele and o56_anousu = $anoUsu";
                                    //$sSql   = $clempautitem->sql_query_pcmaterele(null,null,"o56_codele,o56_elemento,o56_descr",null,$sWhere);

                                    $sSql = "select distinct o56_codele,o56_elemento,o56_descr
                                from empautitem
                                inner join empautoriza on empautoriza.e54_autori = empautitem.e55_autori
                                inner join pcmater on pcmater.pc01_codmater    = empautitem.e55_item
                                inner join pcmaterele on pcmater.pc01_codmater = pcmaterele.pc07_codmater
                                left join orcelemento on orcelemento.o56_codele = pcmaterele.pc07_codele
                                and orcelemento.o56_anousu = $anoUsu
                                where o56_elemento like '$oResult->estrutural%'
                                and e55_autori = $e54_autori and o56_anousu = $anoUsu";

                                    $result = $clempautitem->sql_record($sSql);
                                    $aEle = array();
                                    $aCodele = array();
                                    if ($clempautitem->numrows > 0) {
                                        $oResult = db_utils::getCollectionByRecord($result);


                                        $numrows = $clorcelemento->numrows;


                                        foreach ($oResult as $oRow) {
                                            $aEle[$oRow->o56_codele] = $oRow->o56_descr;
                                            $aCodele[] = substr($oRow->o56_elemento, 0 , -6);
                                            $aCodele2[] = $oRow->o56_elemento;
                                        }

                                    }

                                    $result = $clempautitem->sql_record($clempautitem->sql_query_autoriza(null, null, "e55_codele", null, "e55_autori = $e54_autori"));

                                    if ($clempautitem->numrows > 0) {
                                        $oResult = db_utils::fieldsMemory($result, 0);
                                    }
                                    $e56_codele = $oResult->e55_codele;
                                    $e56_codele2 = $oResult->e55_codele;
                                    db_select("e56_codele", $aCodele2, true, 1);
                                    db_select("e56_codele2", $aEle, true, 1);

                                }
                            }
                        } else {
                            $aEle = array();
                            $aCodele = array();
                            $e56_codele = "";
                            db_select("e56_codele", $aEle, true, 1);
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="Tipos de despesa">
                        <strong>Tipos de despesa :</strong>
                    </td>
                    <td>
                        <?
                        $arr  = array('0' => 'No se aplica', '1' => 'Benefcios Previdencirios do Poder Executivo', '2' => 'Benefcios Previdencirios do Poder Legislativo');

                        $sSql = "SELECT si09_tipoinstit AS tipoinstit FROM infocomplementaresinstit WHERE si09_instit = " . db_getsession("DB_instit");

                        $rsResult = db_query($sSql);
                        db_fieldsMemory($rsResult, 0);

                        if ($tipoinstit == 5 || $tipoinstit == 6) {

                            $aElementos = array('3319001', '3319003', '3319091', '3319092', '3319094', '3319191', '3319192', '3319194');

                            if (db_getsession("DB_anousu") > 2021) {
                                $aElementos = array('331900101', '331900102', '331900301', '331900302', '331909102', '331909103', '331909201', '331909203', '331909403', '331909413');
                            }

                            if (count(array_intersect($aElementos, $aCodele)) > 0) {
                                $arr  = array('0' => 'Selecione', '1' => 'Benefcios Previdencirios do Poder Executivo', '2' => 'Benefcios Previdencirios do Poder Legislativo');
                            }
                        }

                        db_select("e60_tipodespesa", $arr, true, 1);
                        ?>
                    </td>
                </tr>

                <!-- Campos referentes ao sicom 2023 - OC19656 -->
                <tr id="trEmendaParlamentar" style="display: none;">
                    <td nowrap title="Referente a Emenda Parlamentar">
                        <strong>Referente a Emenda Parlamentar:</strong>
                    </td>
                    <td>
                        <?
                        $arr  = array(
                            '0' => 'Selecione',
                            '1' => '1 - Emenda Parlamentar Individual',
                            '2' => '2 - Emenda Parlamentar de Bancada ou Bloco',
                            '0' => 'Selecione',
                            '1' => '1 - Emenda Parlamentar Individual',
                            '2' => '2 - Emenda Parlamentar de Bancada ou Bloco',
                            '3' => '3 - No se aplica',
                            '4' => '4 - Emenda No Impositiva');

                        db_select("e60_emendaparlamentar", $arr, true, 1, "onchange='js_verificaresfera();'");
                        ?>
                    </td>
                </tr>

                <tr id="trEsferaEmendaParlamentar" style="display: none;">
                    <td nowrap title="Esfera da Emenda Parlamentar">
                        <strong>Esfera da Emenda Parlamentar:</strong>
                    </td>
                    <td>
                        <?
                        $arr  = array(
                            '0' => 'Selecione',
                            '1' => '1 - Unio',
                            '0' => 'Selecione',
                            '1' => '1 - Unio',
                            '2' => '2 - Estados');

                        db_select("e60_esferaemendaparlamentar", $arr, true, 1);
                        ?>
                    </td>
                </tr>
                <!-- Final dos campos referentes ao sicom 2023 - OC19656 -->


                <?php //var_dump($o56_elemento);
                ?>
                <tr id="trFinalidadeFundeb" style="display: none;">
                    <td><b>Finalidade:</b></td>
                    <td>
                        <?php
                        $oDaoFinalidadeFundeb = db_utils::getDao('finalidadepagamentofundeb');
                        $sSqlFinalidadeFundeb = $oDaoFinalidadeFundeb->sql_query_file(null, "e151_codigo, e151_descricao", "e151_codigo");
                        $rsBuscaFinalidadeFundeb = $oDaoFinalidadeFundeb->sql_record($sSqlFinalidadeFundeb);
                        db_selectrecord('e151_codigo', $rsBuscaFinalidadeFundeb, true, 1);
                        ?>
                    </td>
                </tr>

                <tr>
                    <td nowrap title="<?= @$Te54_destin ?>">
                        <?= @$Le54_destin ?>
                    </td>
                    <td>
                        <?
                        db_input('e54_destin', 90, $Ie54_destin, true, 'text', $db_opcao, "")
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="Gestor do Empenho">
                        <?php
                        db_ancora('Gestor do Empenho:', "js_pesquisae54_gestaut(true);", $db_opcao);
                        ?>
                    </td>
                    <td>
                        <?php
                        db_input("e54_gestaut", 10, $Ie54_gestaut, true, "text", 3);
                        db_input("e54_nomedodepartamento", 10, 0, true, "text", 3);

                        $iCodDepartamentoAtual = empty($e54_gestaut) ? db_getsession('DB_coddepto') : $e54_gestaut;
                        $sNomDepartamentoAtual = db_utils::fieldsMemory(db_query(" SELECT descrdepto FROM db_depart WHERE coddepto = {$iCodDepartamentoAtual} "), 0)->descrdepto;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Te57_codhist ?>">
                        <?= db_ancora(substr(@$Le40_codhist, 12, 50), "js_pesquisahistorico(true);", isset($emprocesso)&&$emprocesso==true?"1":"1"); ?>
                    </td>
                    <td nowrap="nowrap">
                        <?
                            db_input('e57_codhist', 8, $Ie57_codhist, true, '', 1, " onchange='js_pesquisahistorico(false);'");
                            if($db_opcao == 1)
                                db_input('e40_descr', 45, $Ie40_descr, true, '', 3);
                            else
                                db_input('e40_descr', 45, $Ie40_descr, true, '', 3);
                        ?>
                    </td>
                </tr>

                <tr>
                    <td nowrap title="<?= @$Te54_resumo ?>" valign='top' colspan="2">

                        <fieldset style="width:500px">
                            <legend><strong><?= @$Le54_resumo ?></strong></legend>
                            <?php
                                if (empty($e60_resumo))
                                    $e60_resumo = $e54_resumo;
                                db_textarea('e60_resumo', 3, 109, $Ie54_resumo, true, 'text', $db_opcao,"","","#FFFFFF");
                            ?>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td nowrap valign='top' colspan="2">
                        <fieldset style="width:500px">
                            <legend><b>Informaes da OP</b></legend>
                            <?php

                            if (empty($e50_obs)) {
                                $e50_obs = $e54_resumo;
                            }
                            db_textarea('e50_obs', 3, 109, $Ie54_resumo, true, 'text', $db_opcao, "", "e50_obs");
                            ?>
                        </fieldset>
                    </td>
                </tr>
                <?
                $anousu = db_getsession("DB_anousu");

                if ($anousu > 2007) {
                    ?>
                    <tr style="display: none;">
                        <td nowrap title="<?= @$Te54_concarpeculiar ?>"><?
                                                                        db_ancora(@$Le54_concarpeculiar, "js_pesquisae54_concarpeculiar(true);", $db_opcao);
                                                                        ?></td>
                        <td>
                            <?
                            if (isset($concarpeculiar) && trim(@$concarpeculiar) != "") {
                                $e54_concarpeculiar = $concarpeculiar;
                                $c58_descr = $descr_concarpeculiar;
                            }
                            db_input("e54_concarpeculiar", 10, $Ie54_concarpeculiar, true, "text", $db_opcao, "onChange='js_pesquisae54_concarpeculiar(false);'");
                            db_input("c58_descr", 50, 0, true, "text", 3);
                            ?>
                        </td>
                    </tr>
                <?
                } else {
                    $e54_concarpeculiar = 0;
                    db_input("e54_concarpeculiar", 10, 0, true, "hidden", 3, "");
                }
                ?>

                <tr>
                    <td title="<?= @$Tac16_sequencial ?>" align="left">
                        <?php
                        $db_opcao_antiga = $db_opcao;
                        if ($lAutorizacaoAcordo) {
                            $db_opcao = 3;
                        }
                        db_ancora($Lac16_sequencial, "js_pesquisaac16_sequencial(true);", $db_opcao);
                        ?>
                    </td>
                    <td align="left">
                        <?php
                        db_input('ac16_sequencial', 10, $Iac16_sequencial, true, 'text',
                            $db_opcao, " onchange='js_pesquisaac16_sequencial(false);'");
                        db_input('ac16_resumoobjeto', 50, $Iac16_resumoobjeto, true, 'text', 3);
                        $db_opcao = $db_opcao_antiga;
                        ?>
                    </td>
                </tr>
                <!--
                <tr>
                    <td nowrap title="<? //= @$Te60_convenio
                                        ?>">
                        <? //= @$Le60_convenio
                        ?>
                    </td>
                    <td>
                        <?
                        /*$aConvenio = array('2' => 'No', '1' => 'Sim');
                        db_select('e60_convenio', $aConvenio, true, $db_opcao, "");*/
                        ?>
                    </td>
                </tr>
                -->
                <tr>
                  <td nowrap title="Cdigo c206_sequencial" align="left">
                    <? db_ancora("Convnio:","js_pesquisae60_numconvenio(true);",$db_opcao); ?>
                  </td>
                  <td align="left">
                      <?
                      db_input("e60_numconvenio",10,$Ie60_numconvenio,true,'text',$db_opcao,"onchange='js_pesquisae60_numconvenio(false);'");
                      db_input("c206_objetoconvenio",49,$Ic206_objetoconvenio,true,'text',3);
                      ?>
                  </td>
                </tr>
                <!--
                <tr>
                    <td nowrap title="<? //= @$Te60_dataconvenio
                                        ?>">
                        <? //= @$Le60_dataconvenio
                        ?>
                    </td>
                    <td>
                        <?
                        //db_inputData('e60_dataconvenio',@$e60_dataconvenio_dia, @$e60_dataconvenio_mes,@$e60_dataconvenio_ano, true, 'text', $db_opcao);
                        ?>
                    </td>
                </tr>-->
                <tr>
                    <td nowrap title="Competncia da Sentena Judicial">
                        <strong>Competncia da Sentena Judicial:</strong>
                    </td>
                    <td>
                        <?
                        db_inputData('e60_datasentenca', @$e60_datasentenca_dia, @$e60_datasentenca_mes, @$e60_datasentenca_ano, true, 'text', $db_opcao);
                        ?>
                    </td>
                </tr>

            </table>
            <input name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>" type="submit" id="db_opcao" onclick='return js_valida()' ; value="<?= ($db_opcao == 1 || $db_opcao == 33 ? "Empenhar e imprimir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" "<?= ($db_botao == false ? "disabled" : ($db_disab == false ? "disabled" : "")) ?>">

            <? if ($db_opcao == 1) { ?>
                <input name="op" type="button" value="Empenhar e no imprimir" "<?= ($db_disab == false ? "disabled" : "") ?>" onclick="return js_naoimprimir();">
            <? } ?>

            <input name="lanc" type="button" id="lanc" value="Lanar autorizaes" onclick="parent.location.href='emp1_empautoriza001.php';">

            <?php $lDisable = empty($e60_numemp) ? "disabled" : ''; ?>

            <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar autorizaes"
                   onclick="js_pesquisa();">
        </center>
</form>

<div id="ctnCotasMensais" class="container" style=" width: 500px;">
</div>
<style>
    #e60_tipodespesa{ width: 282px; }#e44_tipo{width: 228px;}#e57_codhistdescr{width: 158px;}#e54_codtipodescr{width: 158px;}#e54_codtipo{width: 67px;}#e54_tipol{width: 67px;} #e54_tipoldescr{width: 370px;}#e54_codcom{width: 67px;}#z01_nome{width: 333px;}#e54_destin{width: 424px;}#e54_gestaut{width: 67px;}#e54_nomedodepartamento{width: 354px;}#ac16_resumoobjeto{width: 364px;}#e60_numconvenio{width: 85px;}#e54_resumo,#e60_resumo{width: 588px;}#e50_obs{width: 588px;}#e60_emendaparlamentar, #e60_esferaemendaparlamentar{width: 442px}
</style>

<script>
window.onload = function () {
    let codigoTipoCompra =  $F('e54_codcom');

    if (codigoTipoCompra) {
        js_divCarregando('Aguarde, carregando informaes...', 'msgbox');
        js_verificaTipoCompra(codigoTipoCompra, 'js_handleTipoAutorizacao');
    }

}

function js_verificaTipoCompra(codigoTipoCompra, funcaoRetorno) {
    let sUrlRPC = 'com4_tipocompra.RPC.php';
        const oParam = new Object();
        oParam.sExecucao = 'getTipocompratribunal';
        oParam.Codtipocom = codigoTipoCompra;

        var oAjax = new Ajax.Request(sUrlRPC, {
            method: 'post',
            parameters: 'json=' + Object.toJSON(oParam),
            onComplete: window[funcaoRetorno]
        });
}

function js_handleTipoAutorizacao(oAjax) {
    oRetorno = eval("(" + oAjax.responseText + ")");

    if (oRetorno.tipocompratribunal != 13) {
        js_desabilitaTipoCompra();
    }
    js_removeObj('msgbox');
}

function js_desabilitaTipoCompra() {

    const e54_codcom = document.querySelector('#e54_codcom');
    const e54_codcomdescr = document.querySelector('#e54_codcomdescr');

    let atributos = "background-color:#DEB887; pointer-events: none; touch-action: none;";

    e54_codcom.style.cssText = atributos;
    e54_codcom.setAttribute('readonly', 'true');

    e54_codcomdescr.style.cssText = atributos;
    e54_codcomdescr.setAttribute('readonly', 'true');
}

// executar a primeira vez
document.form1.e54_gestaut.value = '<?= $iCodDepartamentoAtual ?>';
document.form1.e54_nomedodepartamento.value = '<?= $sNomDepartamentoAtual ?>';

var lEsferaEmendaParlamentar = 'f';
var bEmendaParlamentar = false;
var bEsferaEmendaParlamentar = false;

function js_verificaresfera() {
    if ($F('e60_emendaparlamentar') != 3 && lEsferaEmendaParlamentar == 't') {
        $('trEsferaEmendaParlamentar').style.display = '';
        bEsferaEmendaParlamentar = true;
    } else {
        $('trEsferaEmendaParlamentar').style.display = 'none';
        bEsferaEmendaParlamentar = false;
    }
}

    function js_pesquisarRecursoDotacao() {

js_divCarregando("Aguarde, verificando recurso da dotao...", "msgBox");
var oParam = new Object();
oParam.exec = "validarRecursoDotacaoPorAutorizacao";
oParam.iCodigoAutorizacaoEmpenho = $F('e54_autori');

new Ajax.Request('emp4_empenhofinanceiro004.RPC.php', {
    method: 'post',
    parameters: 'json=' + Object.toJSON(oParam),
    onComplete: function(oAjax) {

        js_removeObj("msgBox");
        var oRetorno = eval("(" + oAjax.responseText + ")");

        lEsferaEmendaParlamentar = oRetorno.lEsferaEmendaParlamentar;
        js_verificaresfera();


        if (oRetorno.lEmendaParlamentar) {
            $('trEmendaParlamentar').style.display = '';
            bEmendaParlamentar = true;
            if (oRetorno.lEmendaIndividual) {
                document.getElementById("e60_emendaparlamentar").disabled = false;
                document.getElementById("e60_emendaparlamentar").remove(3);
                document.getElementById("e60_emendaparlamentar").remove(3);
                document.getElementById("e60_emendaparlamentar").remove(2);
                document.getElementById("e60_emendaparlamentar").remove(0);
            }

            if (oRetorno.lEmendaIndividualEBancada) {
                document.getElementById("e60_emendaparlamentar").disabled = false;
                document.getElementById("e60_emendaparlamentar").remove(3);
                document.getElementById("e60_emendaparlamentar").remove(3);
            }
        } else {
            $('trEmendaParlamentar').style.display = 'none';
            bEmendaParlamentar = false;
        }

        if (oRetorno.lFundeb) {
            $('trFinalidadeFundeb').style.display = '';
        } else {
            $('trFinalidadeFundeb').style.display = 'none';
        }
    }
});
}

js_pesquisarRecursoDotacao();



    /**
     * Ajustes no layout
     */

document.getElementById("e54_resumo").style.width="640px";
document.getElementById("e50_obs").style.width="640px";
document.getElementById("e54_emiss").style.width="71px";
document.getElementById("e54_codcom").style.width="71px";
document.getElementById("e54_codcomdescr").style.width="367px";
document.getElementById("e54_codtipo").style.width="70px";
document.getElementById("e54_codtipodescr").style.width="367px";
document.getElementById("z01_nome").style.width="367px";
document.getElementById("e54_nummodalidade").style.width="100px";
document.getElementById("e44_tipo").style.width="442px";
document.getElementById("e56_codele").style.width="130px";
document.getElementById("e56_codele2").style.width="312px";
document.getElementById("e60_tipodespesa").style.width="442px";
document.getElementById("e54_destin").style.width="442px";
document.getElementById("e40_descr").style.width="367px";
document.getElementById("e54_gestaut").style.width="80px";
document.getElementById("e54_nomedodepartamento").style.width="359px";
document.getElementById("c58_descr").style.width="360px";
document.getElementById("ac16_resumoobjeto").style.width="360px";
document.getElementById("c206_objetoconvenio").style.width="2px"  ? document.getElementById("c206_objetoconvenio").style.width="360px" : "";
document.getElementById("e54_concarpeculiar").style.width="360px"  ? document.getElementById("e54_concarpeculiar").style.width="360px" : "";

function js_pesquisahistorico(mostra) {
      if (mostra == true) {
        js_OpenJanelaIframe('', 'db_iframe_emphist', 'func_emphist.php?funcao_js=parent.js_mostrahistorico1|e40_codhist|e40_descr|e40_historico|e54_resumo', 'Pesquisa', true);
      } else {
        if (document.form1.e57_codhist.value != '') {
          js_OpenJanelaIframe('', 'db_iframe_emphist', 'func_emphist.php?pesquisa_chave=' + document.form1.e57_codhist.value +'&funcao_js=parent.js_mostrahistorico', 'Pesquisa', false);
        } else {
          document.form1.e57_codhist.value = '';
          document.form1.e40_descr.value = '';
          document.form1.e54_resumo.value = '';
        }
      }
	}
  function js_mostrahistorico1(chave,chave1,chave2,chave3) {

           document.form1.e57_codhist.value = chave;
           document.form1.e54_resumo.value = chave2 ;
           document.form1.e40_descr.value = chave1;

            db_iframe_emphist.hide();
	}

	function js_mostrahistorico(chave,chave1,erro) {
		document.form1.e40_descr.value = chave;
        document.form1.e54_resumo.value = chave1;

        db_iframe_emphist.hide();
	}



/*===========================================
    =            pesquisa 54_gestaut            =
    ===========================================*/

    function js_pesquisae54_gestaut() {
        js_OpenJanelaIframe(
            'top.corpo.iframe_empempenho',
            'db_iframe_db_depart',
            'func_db_depart.php?funcao_js=parent.js_preenchepesquisae54_gestaut|coddepto|descrdepto',
            'Pesquisa',
            true,
            '0',
            '1'
        );
    }

    function js_preenchepesquisae54_gestaut(codigo, descricao) {

        if (codigo == '' || descricao == '') {
            document.form1.e54_gestaut.value = '';
            document.form1.e54_gestaut.value.focus();
            return;
        }

        document.form1.e54_gestaut.value = codigo;
        document.form1.e54_nomedodepartamento.value = descricao;

        db_iframe_db_depart.hide();

    }



    /*=====  End of pesquisa 54_gestaut  ======*/


    function manutencaoCotasMensais() {

        oViewCotasMensais = new ViewCotasMensais('oViewCotasMensais', $F('e60_numemp'));
        oViewCotasMensais.setReadOnly(false);
        oViewCotasMensais.abrirJanela();
    }


    /**
     * funcao para avisar o usuario sobre liquidar empenho dos grupos 7, 8, 10
     * onde nao ira mais forar pela ordem de compra
     */
    $('id_1').observe('change', function() {

        if ($F('lLiquidaMaterialConsumo') == 'true') {

            var sGrupo = '<?php echo $sGrupoDesdobramento; ?>';
            var sMensagem = _M('financeiro.empenho.emp4_empempenho004.liquidacao_item_consumo_imediato', {
                sGrupo: sGrupo
            });
            alert(sMensagem);
        }
    });

    function js_pesquisae54_concarpeculiar(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('top.corpo.iframe_empempenho', 'db_iframe_concarpeculiar', 'func_concarpeculiar.php?funcao_js=parent.js_mostraconcarpeculiar1|c58_sequencial|c58_descr', 'Pesquisa', true, '0', '1');
        } else {
            if (document.form1.e54_concarpeculiar.value != '') {
                js_OpenJanelaIframe('top.corpo.iframe_empempenho', 'db_iframe_concarpeculiar', 'func_concarpeculiar.php?pesquisa_chave=' + document.form1.e54_concarpeculiar.value + '&funcao_js=parent.js_mostraconcarpeculiar', 'Pesquisa', false);
            } else {
                document.form1.c58_descr.value = '';
            }
        }
    }

    function js_mostraconcarpeculiar(chave, erro) {
        document.form1.c58_descr.value = chave;
        if (erro == true) {
            document.form1.e54_concarpeculiar.focus();
            document.form1.e54_concarpeculiar.value = '';
        }
    }

    function js_mostraconcarpeculiar1(chave1, chave2) {
        document.form1.e54_concarpeculiar.value = chave1;
        document.form1.c58_descr.value = chave2;
        db_iframe_concarpeculiar.hide();
    }

    function js_naoimprimir() {
        if (!document.querySelector('#e54_codcom').value) {
            alert("Campo Tipo de Compra nao Informado.")
            return false;
        }

        if (document.form1.e60_resumo.value == '') {
             alert("Campo Resumo nao Informado.");
             return false;
        }
        if (document.form1.e50_obs.value == '') {
             alert("Campo Informaes da OP nao Informado.")
             return false;
        }

        if (!js_valida()) {
            return false;
        }
        obj = document.createElement('input');
        obj.setAttribute('name', 'naoimprimir');
        obj.setAttribute('type', 'hidden');
        obj.setAttribute('value', 'true');
        document.form1.appendChild(obj);
        document.form1.incluir.click();
    }

    function js_reload(valor) {
        obj = document.createElement('input');
        obj.setAttribute('name', 'tipocompra');
        obj.setAttribute('type', 'hidden');
        obj.setAttribute('value', valor);
        document.form1.appendChild(obj);
        document.form1.submit();
    }

    function js_pesquisae54_numcgm(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('top.corpo.iframe_empempenho', 'db_iframe_cgm', 'func_nome.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome', 'Pesquisa', true, 0);
        } else {
            if (document.form1.e54_numcgm.value != '') {
                js_OpenJanelaIframe('top.corpo.iframe_empempenho', 'db_iframe_cgm', 'func_nome.php?pesquisa_chave=' + document.form1.e54_numcgm.value + '&funcao_js=parent.js_mostracgm', 'Pesquisa', false);
            } else {
                document.form1.z01_nome.value = '';
            }
        }
    }

    function js_mostracgm(erro, chave) {
        document.form1.z01_nome.value = chave;
        if (erro == true) {
            document.form1.e54_numcgm.focus();
            document.form1.e54_numcgm.value = '';
        }
    }

    function js_mostracgm1(chave1, chave2) {
        document.form1.e54_numcgm.value = chave1;
        document.form1.z01_nome.value = chave2;
        db_iframe_cgm.hide();
    }

    function js_pesquisae54_login(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('top.corpo.iframe_empempenho', 'db_iframe_db_usuarios', 'func_db_usuarios.php?funcao_js=parent.js_mostradb_usuarios1|id_usuario|nome', 'Pesquisa', true);
        } else {
            if (document.form1.e54_login.value != '') {
                js_OpenJanelaIframe('top.corpo.iframe_empempenho', 'db_iframe_db_usuarios', 'func_db_usuarios.php?pesquisa_chave=' + document.form1.e54_login.value + '&funcao_js=parent.js_mostradb_usuarios', 'Pesquisa', false);
            } else {
                document.form1.nome.value = '';
            }
        }
    }

    function js_mostradb_usuarios(chave, erro) {
        document.form1.nome.value = chave;
        if (erro == true) {
            document.form1.e54_login.focus();
            document.form1.e54_login.value = '';
        }
    }

    function js_mostradb_usuarios1(chave1, chave2) {
        document.form1.e54_login.value = chave1;
        document.form1.nome.value = chave2;
        db_iframe_db_usuarios.hide();
    }

    function js_pesquisa() {

        //alert(666);
        js_OpenJanelaIframe('top.corpo.iframe_empempenho', 'db_iframe_orcreservaaut', 'func_orcreservaautnota.php?funcao_js=parent.js_preenchepesquisa|e54_autori|e55_codele', 'Pesquisa', true, 0);
    }

    function js_preenchepesquisa(chave, chave2) {
        // alert(chave2);
        db_iframe_orcreservaaut.hide();
        <?
        echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave+'&iElemento='+chave2";
        ?>
    }

    function js_valida() {

        if (!document.querySelector('#e54_codcom').value) {
            alert("Campo Tipo de Compra nao Informado.")
            return false;
        }

        if (bEmendaParlamentar && document.form1.e60_emendaparlamentar.value == 0) {
            alert("Campo Emenda Parlamentar nao Informado.")
            return false;
        }

        if (bEsferaEmendaParlamentar && document.form1.e60_esferaemendaparlamentar.value == 0) {
            alert("Campo Esfera da Emenda Parlamentar nao Informado.")
             return false;
        }

        if (document.form1.e60_resumo.value == '') {
             alert("Campo Resumo nao Informado.")
             return false;
        }
        if (document.form1.e50_obs.value == '') {
             alert("Campo Informaes da OP nao Informado.")
             return false;
        }
        options = document.form1.op;
        sValor = '';
        for (var i = 0; i < options.length; i++) {
            if (options[i].checked) {
                sValor = options[i].value;
                break;
            }
        }
        //o usuario escolheu liquidar o empenho. entao  obrigatorio informar
        //a data da nota e o nmero da mesma;
        if (sValor == 2) {

            sNumeroNota = $F('e69_numero');
            sDtNota = $F('e69_dtnota');
            sObs = $F('e50_obs');
            if (sNumeroNota.trim() == '') {
                alert('Nmero da nota no pode ser vazio.');
                return false;
            }
            if (sDtNota.trim() == '') {
                alert('data nota no pode ser vazio.');
                return false;
            }
            if (sObs.trim() == '') {
                alert('Informaes da OP no deve ser vazia.');
                return false;
            }
            return true;
        } else {
            return true;
        }
    }
    /**
     * Pesquisa acordos
     */
    function js_pesquisaac16_sequencial(lMostrar) {

        if (lMostrar == true) {

            var sUrl = 'func_acordo.php?lDepartamento=1&funcao_js=parent.js_mostraacordo1|ac16_sequencial|ac16_resumoobjeto';
            js_OpenJanelaIframe('',
                'db_iframe_acordo',
                sUrl,
                'Pesquisar Acordo',
                true);
        } else {

            if ($('ac16_sequencial').value != '') {

                var sUrl = 'func_acordo.php?lDepartamento=1&descricao=true&pesquisa_chave=' + $('ac16_sequencial').value +
                    '&funcao_js=parent.js_mostraacordo';

                js_OpenJanelaIframe('',
                    'db_iframe_acordo',
                    sUrl,
                    'Pesquisar Acordo',
                    false);
            } else {
                $('ac16_sequencial').value = '';
            }
        }
    }

    /**
     * Retorno da pesquisa acordos
     */
    function js_mostraacordo(chave1, chave2, erro) {

        if (erro == true) {

            $('ac16_sequencial').value = '';
            $('ac16_resumoobjeto').value = chave1;
            $('ac16_sequencial').focus();
        } else {

            $('ac16_sequencial').value = chave1;
            $('ac16_resumoobjeto').value = chave2;
        }
    }

    /**
     * Retorno da pesquisa acordos
     */
    function js_mostraacordo1(chave1, chave2) {

        $('ac16_sequencial').value = chave1;
        $('ac16_resumoobjeto').value = chave2;
        db_iframe_acordo.hide();
    }


    /**
     * Ajustes no layout
     */
    // $('e54_codcom').style.width = "15%";
    // $('e54_codtipo').style.width = "15%";
    // $('e57_codhist').style.width = "15%";
    // $('e151_codigo').style.width = "15%";
    // $('e54_codcomdescr').style.width = "84%";
    // $('e54_codtipodescr').style.width = "84%";
    // $('e57_codhistdescr').style.width = "84%";
    // $('e151_codigodescr').style.width = "84%";
    // $('e56_codele').style.width = "100%";
    // $('e44_tipo').style.width = "100%";
    // $('e50_obs').style.width = "100%";

    function js_ValidaCampos() {
    function js_ValidaCampos() {
        var numero = document.form1.e60_codemp.value;
        if (numero % 1 !== 0) {
             alert("Campo de Nmero do Empenho informar apenas nmeros inteiros.");
             document.form1.e60_codemp.focus();
                document.form1.e60_codemp.value = '';
             return false;
        }
    }
        }
    }

    function js_validaNumLicitacao() {

        var expr = new RegExp("[^0-9\/]+");
        if (document.form1.e54_numerl.value.match(expr)) {
            alert("Este campo deve ser preenchido somente com nmeros separados por uma / ");
            document.form1.e54_numerl.focus();
            document.form1.e54_numerl.value = '';
        }
    }

    function js_pesquisae60_numconvenio(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('', 'db_iframe_convconvenios', 'func_convconvenios.php?funcao_js=parent.js_mostrae60_numconvenio1|c206_sequencial|c206_objetoconvenio', 'Pesquisa', true);
        } else {
            if (document.form1.e60_numconvenio.value != '') {
                js_OpenJanelaIframe('', 'db_iframe_convconvenios', 'func_convconvenios.php?pesquisa_chave=' + document.form1.e60_numconvenio.value + '&funcao_js=parent.js_mostrae60_numconvenio', 'Pesquisa', false);
            } else {
                document.form1.c206_objetoconvenio.value = '';
            }
        }
    }

    function js_mostrae60_numconvenio(chave, erro) {
        document.form1.c206_objetoconvenio.value = chave;
        if (erro == true) {
            document.form1.e60_numconvenio.focus();
            document.form1.e60_numconvenio.value = '';
        }
    }

    function js_mostrae60_numconvenio1(chave1, chave2) {
        document.form1.e60_numconvenio.value = chave1;
        document.form1.c206_objetoconvenio.value = chave2;
        db_iframe_convconvenios.hide();
    }

    function js_validaMudancaTipoCompra(oAjax) {
        let result = eval("(" + oAjax.responseText + ")");

        if (result.tipocompratribunal != 13) {
            alert('Tipo de compra invlido para este tipo de autorizao');
            document.querySelector('#e54_codcom').value = '';
            document.querySelector('#e54_codcomdescr').value = '';

            return;
        }
        js_reload(document.querySelector('#e54_codcom').value);
    }
</script>