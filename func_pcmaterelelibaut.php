<?php
/*
 *     E-cidade Software Público para Gestão Municipal
 *  Copyright (C) 2014  DBseller Serviços de Informática
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa é software livre; você pode redistribuí-lo e/ou
 *  modificá-lo sob os termos da Licença Pública Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versão 2 da
 *  Licença como (a seu critério) qualquer versão mais nova.
 *
 *  Este programa e distribuído na expectativa de ser útil, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implícita de
 *  COMERCIALIZAÇÃO ou de ADEQUAÇÃO A QUALQUER PROPÓSITO EM
 *  PARTICULAR. Consulte a Licença Pública Geral GNU para obter mais
 *  detalhes.
 *
 *  Você deve ter recebido uma cópia da Licença Pública Geral GNU
 *  junto com este programa; se não, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Cópia da licença no diretório licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_utils.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_pcmaterele_classe.php");
require_once("classes/db_pctabelaitem_classe.php");
require_once("classes/db_pcparam_classe.php");
require_once("model/empenho/AutorizacaoEmpenho.model.php");

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clpcmaterele   = new cl_pcmaterele;
$clpctabelaitem = new cl_pctabelaitem;
$clpcparam = new cl_pcparam;
$clpcmaterele->rotulo->label("pc07_codmater");
$clpcmaterele->rotulo->label("pc07_codele");

$clrotulo = new rotulocampo;
$clrotulo->label("pc01_descrmater");
$clrotulo->label("o56_elemento");

$aTabFonec = array("" => "Selecione");
$tabsFonecVencedor = $clpctabelaitem->buscarTabFonecVencedor($iCodigoAutorizacao, $z01_numcgm);
if (!empty($tabsFonecVencedor)) {
    foreach($tabsFonecVencedor as $tabFonecVencedor) {
        $aTabFonec += array($tabFonecVencedor->pc94_sequencial => "$tabFonecVencedor->pc94_sequencial - $tabFonecVencedor->pc01_descrmater");
    }
}
$oGet = db_utils::postMemory($_GET);

/*
 * Buscamos o código do cliente para filtrar pelo estrutural
 * Somente um cliente irá utilizar o bloqueio os demais estarão liberados
 * @todo implementar parametro para este controle via sprint
 */
$lFiltroElemento = false;

$oDBConfig = db_utils::getDao("db_config");
$rsCodCli  = $oDBConfig->sql_record($oDBConfig->sql_query_file(db_getsession("DB_instit"), "db21_codcli"));
$iCodCli   = db_utils::fieldsMemory($rsCodCli, 0)->db21_codcli;
if (!empty($oGet->iCodigoAutorizacao) && in_array($iCodCli, array(1, 20, 123))) {

    $oAutorizacaoEmpenho = new AutorizacaoEmpenho($oGet->iCodigoAutorizacao);
    $lPessoaFisica       = $oAutorizacaoEmpenho->getFornecedor()->isFisico();
    $lFiltroElemento     = true;
    $sEstrutural = "36";
    if ($lPessoaFisica) {
        $sEstrutural = "39";
    }
}
    if ($taxatabela == "false"){
        $libera = false;
    }else{
        $libera = true;
    }

?>
    <html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link href="estilos.css" rel="stylesheet" type="text/css">
        <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    </head>

    <body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <table height="100%" border="0" align="center" cellspacing="0" bgcolor="#CCCCCC">
        <tr>
            <td height="63" align="center" valign="top">
                <table width="35%" border="0" align="center" cellspacing="0">
                    <form id="form2" name="form2" method="post" action="">
                        <tr>
                            <td width="4%" align="right" nowrap title="<?= $Tpc07_codmater ?>">
                                <?= $Lpc07_codmater ?>
                            </td>
                            <td width="96%" align="left" nowrap>
                                <? db_input("pc07_codmater", 15, $Ipc07_codmater, true, "text", 4, "", "chave_pc07_codmater"); ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="4%" align="right" nowrap title="<?= $To56_elemento ?>">
                                <?= $Lo56_elemento ?>
                            </td>
                            <td width="96%" align="left" nowrap>
                                <? db_input("o56_elemento", 15, $Io56_elemento, true, "text", 4, "", "chave_o56_elemento");   ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="4%" align="right" nowrap title="<?= $Tpc01_descrmater ?>">
                                <?= $Lpc01_descrmater ?>
                            </td>

                            <td width="96%" align="left" nowrap><? db_input("pc01_descrmater", 80, $Ipc01_descrmater, true, "text", 4, "", "chave_pc01_descrmater"); ?></td>
                        </tr>
                        <?php if($libera == true ): ?>
                        <?php if (!empty($aTabFonec)) : ?>
                            <tr>
                                <td width="4%" align="right" nowrap title="<?= $Tpc94_sequencial ?>">
                                    <strong>Tabela:</strong>
                                </td>
                                <td width="96%" align="left" nowrap>
                                    <?
                                    db_input("chave_pc94_sequencial", 15, $Ipc94_sequencial, true, "text", 4, "onchange='js_mudaTabela(true)'", "chave_pc94_sequencial");
                                    db_select('chave_tabela', $aTabFonec, true, $db_opcao, " onchange='js_mudaTabela(false)' style='width:452;' ");
                                    ?>

                                </td>
                            </tr>
                            <script>
                                function js_mudaTabela(campo) {
                                    if (campo) {
                                        let chave_tabela    = document.getElementById('chave_tabela');
                                        let pc94_sequencial = document.getElementById('chave_pc94_sequencial');

                                        let len = chave_tabela.options.length;
                                        for (i = 0; i < len; i++) {
                                            if (chave_tabela.options[i].value == pc94_sequencial.value) {
                                                chave_tabela.selectedIndex = i;
                                                break;
                                            }
                                        }
                                    } else {
                                        document.form2.chave_pc94_sequencial.value = document.form2.chave_tabela.value;
                                    }
                                    document.getElementById('form2').submit();
                                }
                            </script>
                        <?php endif; ?>
                        <?php endif; ?>
                        <tr>
                            <td colspan="2" align="center">
                                <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
                                <input name="limpar" type="reset" id="limpar" value="Limpar">
                                <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_pcmaterele.hide();">
                            </td>
                        </tr>
                        <script>
                            document.form2.chave_pc01_descrmater.focus();
                        </script>
                    </form>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center" valign="top">
                <?
                $where_libaut = "1=1";

                $result_pcparam = $clpcparam->sql_record($clpcparam->sql_query_file(db_getsession("DB_instit"), "pc30_itenslibaut"));
                if ($clpcparam->numrows > 0) {
                    db_fieldsmemory($result_pcparam, 0);
                    if ($pc30_itenslibaut == 'f') {
                        $where_libaut = "pc01_libaut = 't'";
                    }
                }
                $repassa = array();
                $where_ativo = "";
                $dDataAtual   = date('Y-m-d', db_getsession("DB_datausu"));
                $where_ativo .= " and pc01_data <= '$dDataAtual' ";
                if (isset($chave_pc07_codele)) {
                    $where_ativo .= " and pc07_codele=$chave_pc07_codele ";
                    $repassa["chave_pc07_codele"] = $chave_pc07_codele;
                }
                if (isset($opcao) && trim($opcao) != "i") {
                    $where_ativo .= " and pc01_ativo='$opcao' ";
                }

                $sWhereElementoAutorizacao = "";
                if ($lFiltroElemento) {
                    $sWhereElementoAutorizacao = " and substr(o56_elemento, 6, 2)::varchar <> {$sEstrutural}::varchar ";
                }

                if (!isset($pesquisa_chave)) {
                    if (isset($campos) == false) {
                        if (file_exists("funcoes/db_func_pcmaterele.php") == true) {
                            include("funcoes/db_func_pcmaterele.php");
                        } else {
                            $campos = "pc01_codmater,pc01_descrmater,pc01_complmater,o56_elemento,o56_descr,pc07_codele,pc01_servico";
                        }
                    }
                  if (isset($criterioadjudicacao) && $criterioadjudicacao == true && isset($z01_numcgm)) {
                    $whereTab = "";
                    if (isset($chave_pc94_sequencial) && (trim($chave_pc94_sequencial) != "")) {
                      $whereTab .= " AND pctabela.pc94_sequencial = {$chave_pc94_sequencial} ";
                    }else if (isset($chave_pc07_codmater) && (trim($chave_pc07_codmater) != "")) {
                      $whereTab .= " AND pcmater.pc01_codmater = {$chave_pc07_codmater} ";
                    }else if (isset($chave_o56_elemento) && (trim($chave_o56_elemento) != "")){
                      $whereTab .= " and o56_elemento like '$chave_o56_elemento%'  ";
                    }else if(isset($chave_pc01_descrmater) && (trim($chave_pc01_descrmater) != "")){
                      $whereTab .= "     pc01_descrmater like '%{$chave_pc01_descrmater}%' ";
                    }

                    $sql = "
            SELECT * FROM (
              SELECT DISTINCT pcmater.pc01_codmater,
                              pcmater.pc01_descrmater,
                              o56_elemento,
                              o56_descr,
                              pc07_codele,
                              pcmater.pc01_servico,
                              pc23_orcamforne,
                              z01_numcgm,
                              pc23_quant,
                              pc23_vlrun,
                              pc23_valor,
                              pc80_criterioadjudicacao,
                              pcmater.pc01_servico,
                              'itemtabela' as tipoitem,
                              pctabela.pc94_sequencial
              FROM liclicitem
              LEFT JOIN pcprocitem ON liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem
              LEFT JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
              LEFT JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
              LEFT JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
              LEFT JOIN db_depart ON db_depart.coddepto = solicita.pc10_depto
              LEFT JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
              LEFT JOIN cflicita ON cflicita.l03_codigo = liclicita.l20_codtipocom
              LEFT JOIN pctipocompra ON pctipocompra.pc50_codcom = cflicita.l03_codcom
              LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
              LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
              LEFT JOIN pcorcamitemlic ON l21_codigo = pc26_liclicitem
              LEFT JOIN pcorcamval ON pc26_orcamitem = pc23_orcamitem
              LEFT JOIN pcorcamforne ON pc21_orcamforne = pc23_orcamforne
              LEFT JOIN cgm ON z01_numcgm = pc21_numcgm
              LEFT JOIN pcorcamjulg ON pcorcamval.pc23_orcamitem = pcorcamjulg.pc24_orcamitem
                          AND pcorcamval.pc23_orcamforne = pcorcamjulg.pc24_orcamforne
              LEFT JOIN db_usuarios ON pcproc.pc80_usuario = db_usuarios.id_usuario
              LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
              LEFT JOIN pcmater itemtabela ON itemtabela.pc01_codmater = solicitempcmater.pc16_codmater
              LEFT JOIN pctabela ON pctabela.pc94_codmater = itemtabela.pc01_codmater
              LEFT JOIN pctabelaitem ON pctabelaitem.pc95_codtabela = pctabela.pc94_sequencial
              LEFT JOIN pcmater ON pcmater.pc01_codmater = pctabelaitem.pc95_codmater
              LEFT JOIN pcmaterele ON pcmaterele.pc07_codmater = pctabelaitem.pc95_codmater
              INNER JOIN orcelemento ON orcelemento.o56_codele = pcmaterele.pc07_codele
                          AND orcelemento.o56_anousu = " . db_getsession('DB_anousu') . "
              WHERE l20_codigo =
                      (SELECT e54_codlicitacao
                      FROM empautoriza
                      WHERE e54_autori = {$iCodigoAutorizacao})
                  AND pc24_pontuacao=1
                  {$whereTab}

              UNION

              SELECT DISTINCT pcmater.pc01_codmater,
                      pcmater.pc01_descrmater,
                      o56_elemento,
                      o56_descr,
                      pc07_codele,
                      pcmater.pc01_servico,
                      pc23_orcamforne,
                      z01_numcgm,
                      pc23_quant,
                      pc23_vlrun,
                      pc23_valor,
                      pc80_criterioadjudicacao,
                      pcmater.pc01_servico,
                      'naoitem' as tipoitem,
                      0 as pc94_sequencial
            FROM liclicitem
            LEFT JOIN pcprocitem ON liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem
            LEFT JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
            LEFT JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
            LEFT JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
            LEFT JOIN db_depart ON db_depart.coddepto = solicita.pc10_depto
            LEFT JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
            LEFT JOIN cflicita ON cflicita.l03_codigo = liclicita.l20_codtipocom
            LEFT JOIN pctipocompra ON pctipocompra.pc50_codcom = cflicita.l03_codcom
            LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
            LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
            LEFT JOIN pcorcamitemlic ON l21_codigo = pc26_liclicitem
            LEFT JOIN pcorcamval ON pc26_orcamitem = pc23_orcamitem
            LEFT JOIN pcorcamforne ON pc21_orcamforne = pc23_orcamforne
            LEFT JOIN cgm ON z01_numcgm = pc21_numcgm
            LEFT JOIN pcorcamjulg ON pcorcamval.pc23_orcamitem = pcorcamjulg.pc24_orcamitem
            AND pcorcamval.pc23_orcamforne = pcorcamjulg.pc24_orcamforne
            LEFT JOIN db_usuarios ON pcproc.pc80_usuario = db_usuarios.id_usuario
            LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
            LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
            LEFT JOIN pcmaterele ON pcmaterele.pc07_codmater = pcmater.pc01_codmater
            LEFT JOIN orcelemento ON orcelemento.o56_codele = pcmaterele.pc07_codele
            AND orcelemento.o56_anousu = " . db_getsession('DB_anousu') . "
            WHERE l20_codigo =
                    (SELECT e54_codlicitacao
                      FROM empautoriza
                      WHERE e54_autori = {$iCodigoAutorizacao})
                AND pc24_pontuacao=1
                {$whereTab}
                AND (pcmater.pc01_tabela = 't' OR pcmater.pc01_taxa = 't')
                AND pcmater.pc01_codmater NOT IN (select pc94_codmater from pctabela)

            ) fornecedores
            WHERE fornecedores.z01_numcgm = {$z01_numcgm}
            ORDER BY fornecedores.pc01_codmater
            ";
                  }else{
                    if (isset($chave_pc07_codmater) && (trim($chave_pc07_codmater) != "")) {

                      $sql = $clpcmaterele->sql_query(null, null, $campos, "pc07_codmater", " pc07_codmater=$chave_pc07_codmater $where_ativo and $where_libaut {$sWhereElementoAutorizacao}");
                      $repassa["chave_pc07_codmater"] = $chave_pc07_codmater;
                    } else if (isset($chave_pc01_descrmater) && (trim($chave_pc01_descrmater) != "") && isset($chave_o56_elemento) && (trim($chave_o56_elemento) != "")) {

                      $sql = $clpcmaterele->sql_query_funcauteledescr("", "", $campos, "pc07_codmater", "$chave_pc01_descrmater#$chave_o56_elemento", $sWhereElementoAutorizacao);
                      $repassa["chave_pc01_descrmater"] = $chave_pc01_descrmater;
                      $repassa["chave_o56_elemento"]    = $chave_o56_elemento;
                    } else if (isset($chave_pc01_descrmater) && (trim($chave_pc01_descrmater) != "")) {

                      $sPesquisaPorElemento = "";
                      if ((isset($chave_o56_elemento) and trim($chave_o56_elemento)  != "")) {
                        $sPesquisaPorElemento = " and o56_elemento like '$chave_o56_elemento%' ";
                      }

                      $sWhere  = "     pc01_descrmater like '%{$chave_pc01_descrmater}%' ";
                      $sWhere .= " and {$where_libaut} ";
                      $sWhere .= "     {$where_ativo} ";
                      $sWhere .= "     {$sPesquisaPorElemento}";

                      $sql = $clpcmaterele->sql_query_funcaut(null, null, $campos, "pc07_codmater", $sWhere, $sWhereElementoAutorizacao);
                      $repassa["chave_pc01_descrmater"] = $chave_pc01_descrmater;
                    } else if (isset($chave_o56_elemento) && (trim($chave_o56_elemento) != "")) {

                      $sql = $clpcmaterele->sql_query_funcautele("", "", $campos, "pc07_codmater", " o56_elemento like '$chave_o56_elemento%' and o56_anousu = " . db_getsession("DB_anousu"),  " {$sWhereElementoAutorizacao} ");
                      $repassa["chave_o56_elemento"]    = $chave_o56_elemento;
                    } else {
                      $sql = $clpcmaterele->sql_query_funcaut("", "", $campos, "pc07_codmater#pc07_codele", " 1=1 and $where_libaut $where_ativo {$sWhereElementoAutorizacao}");
                      $sql = "";
                    }
                  }
                    db_lovrot($sql, 12, "()", "", $funcao_js, "", "NoMe", $repassa);
                } else {
                    if ($pesquisa_chave != null && $pesquisa_chave != "") {

                        $sWhereElemento = "";
                        if (isset($chave_o56_elemento) && !empty($chave_o56_elemento)) {
                            $sWhereElemento = " and o56_elemento like '{$chave_o56_elemento}%'";
                        }

                        $result = $clpcmaterele->sql_record($clpcmaterele->sql_query(null, null, "*", "", " pc07_codmater=$pesquisa_chave and $where_libaut $where_ativo $sWhereElemento {$sWhereElementoAutorizacao}"));
                        if ($clpcmaterele->numrows != 0) {
                            db_fieldsmemory($result, 0);
                            echo "<script>" . $funcao_js . "('$pc01_descrmater',false,'$pc07_codele');</script>";
                        } else {
                            echo "<script>" . $funcao_js . "('Chave(" . $pesquisa_chave . ") não Encontrado',true,true);</script>";
                        }
                    } else {
                        echo "<script>" . $funcao_js . "('',false,'');</script>";
                    }
                }
                ?>
            </td>
        </tr>
    </table>
    </body>

    </html>
<?
if (!isset($pesquisa_chave)) {
    ?>
    <?
}
?>
