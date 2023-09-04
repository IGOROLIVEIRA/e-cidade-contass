<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2012  DBselller Servicos de Informatica
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
include("classes/db_pagordem_classe.php");
include("classes/db_empempenho_classe.php");
include("classes/db_conlancam_classe.php");
require_once("std/Modification.php");

$clmatordem = new cl_matordem;
$clpagordem   = new cl_pagordem;
$clempempenho = new cl_empempenho;
$clrotulo = new rotulocampo;
$clconlancam = new cl_conlancam;

$clempempenho->rotulo->label();
$clmatordem->rotulo->label();
$clrotulo->label("e60_codemp");
$clrotulo->label("e60_numemp");
$clrotulo->label("e50_codord");
$clrotulo->label("e50_obs");
// $clrotulo->label("e50_compdesp");

$clpagordem->rotulo->label("e60_codemp");
$clpagordem->rotulo->label("e60_numemp");
$clpagordem->rotulo->label("e50_codord");
$clpagordem->rotulo->label("e50_obs");
// $clpagordem->rotulo->label("e50_compdesp");

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS['QUERY_STRING'], $aFiltros);

if (isset($aFiltros['empenho']) && !empty($aFiltros['empenho'])) {
    $empenho = $aFiltros['empenho'];
}

$sqlerro = false;

db_inicio_transacao();

if (isset($alterar)) {
    $estornoAlterado = false;
    if($dataEstorno !== ""){
        $dataEstorno = str_replace('/', '-', $dataEstorno);
        $dataEstorno = date('Y-m-d', strtotime($dataEstorno));
        if($dataEstornoAtual !== ""){
            $dataEstornoAtual = str_replace('/', '-', $dataEstornoAtual);
            $dataEstornoAtual = date('Y-m-d', strtotime($dataEstornoAtual));
            $estornoAlterado = strtotime($dataEstornoAtual) !== strtotime($dataEstorno) ? true : false;
        }
    }

    $liquidacaoAlterado = false;
    if($dataLiquidacao !== ""){
        $dataLiquidacao = str_replace('/', '-', $dataLiquidacao);
        $dataLiquidacao = date('Y-m-d', strtotime($dataLiquidacao));
        if($dataLiquidacaoAtual !== ""){
            $dataLiquidacaoAtual = str_replace('/', '-', $dataLiquidacaoAtual);
            $dataLiquidacaoAtual = date('Y-m-d', strtotime($dataLiquidacaoAtual));
            $liquidacaoAlterado = strtotime($dataLiquidacaoAtual) !== strtotime($dataLiquidacao) ? true : false;
        }
    }
    
    $sSqlConsultaFimPeriodoContabil   = "SELECT * FROM condataconf WHERE c99_anousu = ".db_getsession('DB_anousu')." and c99_instit = ".db_getsession('DB_instit');
    $rsConsultaFimPeriodoContabil     = db_query($sSqlConsultaFimPeriodoContabil);

    if (pg_num_rows($rsConsultaFimPeriodoContabil) > 0) {
      
        $oFimPeriodoContabil = db_utils::fieldsMemory($rsConsultaFimPeriodoContabil, 0);

        if ($oFimPeriodoContabil->c99_data != '' 
        && (db_strtotime($e50_data) <= db_strtotime($oFimPeriodoContabil->c99_data)
        || ($estornoAlterado && db_strtotime($dataEstorno) <= db_strtotime($oFimPeriodoContabil->c99_data))
        || ($liquidacaoAlterado && db_strtotime($dataLiquidacao) <= db_strtotime($oFimPeriodoContabil->c99_data)))) {

            $erro_msg = "Alteração não realizada!\nData inferior à data do fim do período contábil.";
            $sqlerro = true;

        }

    }

    //Verifica se a data de OP e anterior a data da OC, caso não seja uma OC gerada automaticamente
    if(!$sqlerro && isset($dataLiquidacao) && $dataLiquidacao !== ""){
        $ordemCompra = $clmatordem->verificaTipo($e50_codord);
        if(isset($ordemCompra)){
            if($ordemCompra->tipo === 'normal'){
                if($dataLiquidacao < $ordemCompra->m51_data){
                    $erro_msg = "Alteração não realizada!\nA data informada é inconsistente. Verifique as datas dos lançamentos contábeis.";
                    $sqlerro = true;
                }
            }
        }
    }

    //Verifica se data da liquidação é anterior a data do empenho
    if(!$sqlerro && $liquidacaoAlterado){
        $sql = $clconlancam->verificaDataEmpenho($e60_numemp);
        $result = db_query($sql);
        if(pg_num_rows($result) > 0){
            $result = pg_fetch_object($result);
            if (strtotime($dataLiquidacao) < strtotime($result->data_empenho)){
                $erro_msg = "Alteração não realizada!\nVerifique as datas dos lançamentos contábeis.";
                $sqlerro = true;
            }
        }
    }

    //Verifica se data de liquidaçao é posterior a data de pagamento
    if(!$sqlerro && $liquidacaoAlterado){
        $sql = $clconlancam->verificaDataPagamento($e50_codord);
        $result = db_query($sql);
        if(pg_num_rows($result) > 0){
            $result = pg_fetch_object($result);
            if (strtotime($dataLiquidacao) > strtotime($result->data_pagamento)){
                $erro_msg = "Alteração não realizada!\nA data informada é inconsistente. Verifique as datas dos lançamentos contábeis.";
                $sqlerro = true;
            }
        }
    }

    //Verifica se empenho tem saldo na data desejada
    if(!$sqlerro && strtotime($dataLiquidacao) < strtotime($e50_data) && $liquidacaoAlterado){
        $sql = $clempempenho->verificaSaldoEmpenho($e60_numemp, $dataLiquidacao);
        $result = pg_fetch_object(db_query($sql));
        if ($result->saldo_empenho < $e53_valor){
            $erro_msg = "Alteração não realizada!\nEmpenho não possui saldo na data desejada.";
            $sqlerro = true;
        }
    }

    //Verifica se empenho não ficará negativo
    if(!$sqlerro && $liquidacaoAlterado){
        $sql = $clempempenho->verificaSaldoEmpenhoPosterior($e60_numemp, $dataLiquidacao, $e50_codord, 20);
        $result = pg_fetch_object(db_query($sql));
        if ($result->saldo_empenho < 0){
            $erro_msg = "Alteração não realizada!\nO empenho não pode ficar com saldo negativo.";
            $sqlerro = true;
        }
    }

    //Verifica se data da liquidação é posterior a data do estorno
    if(!$sqlerro && ($estornoAlterado || $liquidacaoAlterado)){
        if(isset($dataEstorno) && $dataEstorno !== ""){
            if (strtotime($dataLiquidacao) > strtotime($dataEstorno)){
                $erro_msg = "Alteração não realizada!\nA data informada é inconsistente. Verifique as datas dos lançamentos contábeis.";
                $sqlerro = true;
            }
        }
    }

    //Altera data liquidação
    if(!$sqlerro && $liquidacaoAlterado){
        $dataLiquidacaoAtual = str_replace('/', '-', $dataLiquidacaoAtual);
        $dataLiquidacaoAtual = date('Y-m-d', strtotime($dataLiquidacaoAtual)); 
        if(strtotime($dataLiquidacao) <= db_getsession("DB_datausu")){
            db_inicio_transacao();
            $sqlAlteraDataOp = $clpagordem->alteraDataOp($e50_codord,$dataLiquidacaoAtual,$dataLiquidacao, date('m',db_getsession('DB_datausu')), $ordemCompra->tipo);
            db_query($sqlAlteraDataOp);
            db_fim_transacao();
        }else{
            $erro_msg = "Alteração não realizada!\nA data da OP não pode ser posterior a data atual.";
            $sqlerro = true;  
        }
    }

    //Altera data do estorno
    if(!$sqlerro && $estornoAlterado){

        if(strtotime($dataEstorno) <= db_getsession("DB_datausu")){
            db_inicio_transacao();
            $sqlAlteraDataEstorno = $clpagordem->alteraDataEstorno($e50_codord,$dataEstornoAtual,$dataEstorno, date('m',db_getsession('DB_datausu')));
            db_query($sqlAlteraDataEstorno);
            db_fim_transacao();
        }else{
            $erro_msg = "Alteração não realizada!\nA data do estorno não pode ser posterior a data atual.";
            $sqlerro = true;  
        }
    }

    if (!$sqlerro) {
    
        $aEmpenho = explode("/",$e60_codemp);
        $sSql = $clpagordem->sql_query_pagordemele("","substr(o56_elemento,1,7) AS o56_elemento","e50_codord","e60_codemp =  '".$aEmpenho[0]."' and e60_anousu = ".$aEmpenho[1]." and e60_instit = ".db_getsession("DB_instit"));
        $rsElementDesp = db_query($sSql);
    
        $clpagordem->alterar($e50_codord,db_utils::fieldsMemory($rsElementDesp,0)->o56_elemento);
        if($clpagordem->erro_status == 0) {
            $sqlerro = true;
        }
        $erro_msg = $clpagordem->erro_msg;

    }

    if (!$sqlerro) {
        $erro_msg = "Alteração realizada com sucesso!";
    }
}
db_fim_transacao($sqlerro);

?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#cccccc" onload="pesquisaOrdemPagamento(document.form1.empenho.value)" >
<br><br>
<center>
    <?php require_once (modification::getFile("forms/db_frmordempagamento.php")); ?>
</center>
</body>
</html>
<?php
if(isset($alterar)){
    if($sqlerro == true){
        db_msgbox($erro_msg);
        if($clpagordem->erro_campo!=""){
            echo "<script> document.form1.".$clpagordem->erro_campo.".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1.".$clpagordem->erro_campo.".focus();</script>";
        }
    }else{
        db_msgbox($erro_msg);
    }
}
?>