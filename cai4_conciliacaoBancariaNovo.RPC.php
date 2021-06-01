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

require_once ("libs/db_stdlib.php");
require_once ("libs/db_app.utils.php");
require_once ("libs/JSON.php");
require_once ("std/db_stdClass.php");
require_once ("std/DBDate.php");
require_once ("dbforms/db_funcoes.php");
require_once ("libs/db_conecta.php");
require_once ("libs/db_utils.php");
require_once ("libs/db_sessoes.php");
require_once ("libs/db_usuariosonline.php");
require_once ("libs/exceptions/BusinessException.php");
require_once ("libs/exceptions/DBException.php");
require_once ("libs/exceptions/FileException.php");
require_once ("libs/exceptions/ParameterException.php");
require_once("classes/db_conciliacaobancaria_classe.php");
require_once("classes/db_conciliacaobancarialancamento_classe.php");
require_once("classes/db_caiparametro_classe.php");

$iEscola           = db_getsession("DB_coddepto");
$oJson             = new Services_JSON();
$oParam            = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oRetorno          = new stdClass();
$oRetorno->dados   = array();
$oRetorno->status  = 1;
$oRetorno->message = '';
$sCaminhoMensagens = 'financeiro.caixa.cai4_concbancnovo';

try {
    switch($oParam->exec) {
        case "getLancamentos":
            $oRetorno->aLinhasExtrato = array();
            $data_inicial = data($oParam->params[0]->data_inicial);
            $data_final = data($oParam->params[0]->data_final);
            $condicao_lancamento = $oParam->params[0]->tipo_lancamento > 0 ? " AND conlancamdoc.c71_coddoc IN (" . tipoDocumentoLancamento($oParam->params[0]->tipo_lancamento) . ") " : "";
            $sql = query_lancamentos($oParam->params[0]->conta, $data_inicial, $data_final, $condicao_lancamento, $oParam->params[0]->tipo_lancamento);
            // $oRetorno->aLinhasExtrato[] = $sql;
            $resultado = db_query($sql);
            $rows = pg_numrows($resultado);
            $lancamentos = array();
            $agrupado = array();
            $movimentacao_permitida = $oParam->params[0]->tipo_movimento ? array($oParam->params[0]->tipo_movimento) : array("E", "S");
            $i = 0;
            for ($linha = 0; $linha < $rows; $linha++) {
                db_fieldsmemory($resultado, $linha);
                $movimento = ($valor_debito > 0 OR $valor_credito < 0) ? "E" : "S";
                $movimento = $cod_doc == 116 ? "E" : $movimento;

                if (in_array($movimento, $movimentacao_permitida)) {
                    $cod_doc = $cod_doc == 116 ? 100 : $cod_doc;

                    $documento = numero_documento_lancamento($tipo, $ordem, $codigo, $codigo);
                    $chave = $credor . $data . $data_conciliacao . $movimento . $cod_doc;
                    $valor = $valor_debito <> 0 ? abs($valor_debito) : abs($valor_credito);
                    // $chave = $i++;
                    $agrupado[$chave][] = array("identificador" => $caixa,
                            "data_lancamento" => date("d/m/Y", strtotime($data)),
                            "data_conciliacao" => $data_conciliacao ? date("d/m/Y", strtotime($data_conciliacao)) : "",
                            "credor" => $credor,
                            "numcgm" => $numcgm,
                            "tipo" => descricaoTipoLancamento($cod_doc),
                            "op_rec_slip" => !$documento ? "" : $documento,
                            "documento" => trim($cheque),
                            "movimento" => $movimento,
                            "valor_individual" => $valor,
                            "valor" => $valor,
                            "historico" => descricaoHistorico($tipo, $codigo, $historico),
                            "cod_doc" => $cod_doc);

                    if (!array_key_exists($chave, $lancamentos)) {
                        $lancamentos[$chave]["identificador"] = $caixa;
                        $lancamentos[$chave]["tipo_lancamento"] = $tipo_lancamento;
                        $lancamentos[$chave]["data_lancamento"] = date("d/m/Y", strtotime($data));
                        $lancamentos[$chave]["data_conciliacao"] = ($data_conciliacao AND $data_conciliacao <= $data_final) ? date("d/m/Y", strtotime($data_conciliacao)) : "";
                        $lancamentos[$chave]["credor"] = $credor;
                        $lancamentos[$chave]["tipo"] = $tipo_lancamento == 2 ? "" : descricaoTipoLancamento($cod_doc);
                        $lancamentos[$chave]["op_rec_slip"][] = !$documento ? "" : $documento;
                        $lancamentos[$chave]["documento"][] = trim($cheque);
                        $lancamentos[$chave]["movimento"] = $movimento;
                        $lancamentos[$chave]["valor"] = $valor_debito <> 0 ? $valor_debito : $valor_credito;
                        $lancamentos[$chave]["valor_individual"][] = $valor_debito <> 0 ? $valor_debito : $valor_credito;
                        $lancamentos[$chave]["historico"] = descricaoHistorico($tipo, $codigo, $historico);
                        $lancamentos[$chave]["cod_doc"][] = $cod_doc;
                        $lancamentos[$chave]["numcgm"] = $numcgm;
                        $lancamentos[$chave]["agrupado"] = false;
                    } else {
                        $lancamentos[$chave]["valor"] += $valor_debito <> 0 ? $valor_debito : $valor_credito;
                        $lancamentos[$chave]["valor_individual"][] = $valor_debito <> 0 ? $valor_debito : $valor_credito;
                        $lancamentos[$chave]["cod_doc"][] = $cod_doc;
                        $lancamentos[$chave]["op_rec_slip"][] = !$documento ? "" : $documento;
                        $lancamentos[$chave]["documento"][] = trim($cheque);
                        $lancamentos[$chave]["agrupado"] = true;
                        $lancamentos[$chave]["historico"] = "<a href='#' onclick='js_janelaAgrupados(" .  json_encode($agrupado[$chave]) . ")'>(+) Mais Detalhes</a>";
                    }
                }
            }

            foreach ($lancamentos as $chave => $lancamento) {
                if ($lancamento["valor"] <> 0) {
                    $oDadosLinha = new StdClass();
                    $oDadosLinha->identificador = $lancamento["caixa"];
                    $oDadosLinha->data_lancamento  = $lancamento["data_lancamento"];
                    $oDadosLinha->data_conciliacao = $lancamento["data_conciliacao"];
                    $oDadosLinha->credor = $lancamento["credor"];
                    $oDadosLinha->tipo = $lancamento["tipo"];
                    $oDadosLinha->op_rec_slip = $lancamento["op_rec_slip"];
                    $oDadosLinha->documento = $lancamento["documento"];
                    $oDadosLinha->movimento = $lancamento["movimento"];
                    $oDadosLinha->valor_individual = $lancamento["valor_individual"];
                    $oDadosLinha->valor = abs($lancamento["valor"]);
                    $oDadosLinha->historico = $lancamento["historico"];
                    $oDadosLinha->numcgm = $lancamento["numcgm"];
                    $oDadosLinha->cod_doc = $lancamento["cod_doc"];
                    $oDadosLinha->tipo_lancamento = $lancamento["tipo_lancamento"];
                    $oDadosLinha->agrupado = $lancamento["agrupado"];
                    $oRetorno->aLinhasExtrato[] = $oDadosLinha;
                }
            }
            break;
        case 'Processar':
            db_inicio_transacao();
            $oRetorno->aLinhasExtrato = array();
            $oDaoConciliacaoBancaria = new cl_conciliacaobancaria();
            // Recebe os parametros
            $conta = $oParam->params[0]->conta;
            $data_final = data($oParam->params[0]->data_final);
            $data_conciliacao = data($oParam->params[0]->data_conciliacao);
            $saldo_final_extrato = number_format($oParam->params[0]->saldo_final_extrato, 2, ".", "");
            // busca conciliaCão
            $oSql = $oDaoConciliacaoBancaria->sql_query_file(null, "*", null, "k171_conta = {$conta} AND k171_data = '{$data_final}' ");
            $oDaoConciliacaoBancaria->sql_record($oSql);
            $oRetorno->aLinhasExtrato = array();
            $oRetorno->aLinhasExtrato[] = $oParam->params[0];
            // Tratativas
            if ($oDaoConciliacaoBancaria->numrows > 0) {
                $oDaoConciliacaoBancaria->k171_conta = $conta;
                $oDaoConciliacaoBancaria->k171_data = $data_final;
                $oDaoConciliacaoBancaria->k171_dataconciliacao = $data_conciliacao;
                $oDaoConciliacaoBancaria->k171_saldo = $saldo_final_extrato;
                $oDaoConciliacaoBancaria->alterar();
                // $oRetorno->aLinhasExtrato[] = $oDaoConciliacaoBancaria;
            } else {
                $oDaoConciliacaoBancaria->k171_conta = $conta;
                $oDaoConciliacaoBancaria->k171_data = $data_final;
                $oDaoConciliacaoBancaria->k171_dataconciliacao = $data_conciliacao;
                $oDaoConciliacaoBancaria->k171_saldo = $saldo_final_extrato;
                $oDaoConciliacaoBancaria->incluir();
                // $oRetorno->aLinhasExtrato[] = $oDaoConciliacaoBancaria;
            }
            // Preenche a movimentaCão
            $oRetorno->aLinhasExtrato[] = lancamentos_conciliados($oParam->params[0]->movimentos, $conta, $data_conciliacao);
            db_fim_transacao(false);
            break;
        case 'Desprocessar':
            db_inicio_transacao();
            $oRetorno->aLinhasExtrato = array();
            $oDaoConciliacaoBancaria = new cl_conciliacaobancaria();
            // Recebe os parametros
            $conta = $oParam->params[0]->conta;
            $data_final = data($oParam->params[0]->data_final);
            $data_conciliacao = data($oParam->params[0]->data_conciliacao);
            $saldo_final_extrato = number_format($oParam->params[0]->saldo_final_extrato, 2, ".", "");
            // busca conciliaCão
            $oRetorno->aLinhasExtrato[] = $oDaoConciliacaoBancaria->excluir(null, "k171_conta = {$conta} AND k171_data = '{$data_final}' AND k171_dataconciliacao = '{$data_conciliacao}'");
            // Preenche a movimentaCão
            $oRetorno->aLinhasExtrato[] = excluir_lancamentos_conciliados($oParam->params[0]->movimentos, $conta, $data_conciliacao);
            db_fim_transacao(false);
        break;
        case 'getDadosExtrato':
            $oRetorno->aLinhasExtrato = array();
            // $oRetorno->aLinhasExtrato[] = "Uso para debug";
            $data_inicial = data($oParam->params[0]->data_inicial);
            $data_final = data($oParam->params[0]->data_final);
            $conta = $oParam->params[0]->conta;
            // Preenche os dados para retorno
            $oDadosLinha = new StdClass();
            $oDadosLinha->saldo_anterior = saldo_anterior_extrato($conta, $data_inicial);
            $oDadosLinha->total_entradas = movimentacao_extrato($conta, $data_inicial, $data_final, 1);
            $oDadosLinha->total_saidas = movimentacao_extrato($conta, $data_inicial, $data_final, 2);
            $oDadosLinha->saldo_final = saldo_final_extrato($conta, $data_final);
            // Retorna os dados
            $oRetorno->aLinhasExtrato[] = $oDadosLinha;
            break;
    }
} catch (ParameterException $oErro) {
    db_fim_transacao(true);
    $oRetorno->status  = 2;
    $oRetorno->message = urlencode($oErro->getMessage());
} catch (BusinessException $oErro) {
    db_fim_transacao(true);
    $oRetorno->status  = 2;
    $oRetorno->message = urlencode($oErro->getMessage());
}
echo $oJson->encode($oRetorno);

function saldo_anterior_extrato($conta, $data) {
    $sql = "select
                substr(fc_saltessaldo, 2, 13)::float8 as saldo_anterior
            from
                (
                    select
                        fc_saltessaldo(k13_reduz, '{$data}', '{$data}', null, 1)
                    from
                        saltes
                        inner join conplanoexe on k13_reduz = c62_reduz
                            and c62_anousu = " . db_getsession('DB_anousu') . "
                        inner join conplanoreduz on c61_anousu = c62_anousu
                            and c61_reduz = c62_reduz
                            and c61_instit = " . db_getsession("DB_instit") . "
                        inner join conplano on c60_codcon = c61_codcon
                            and c60_anousu = c61_anousu
                    where
                        c61_reduz = {$conta}
                        and c60_codsis = 6
                ) as x";
    $resultado = pg_query($sql);
    while ($row = pg_fetch_object($resultado)) {
        return $row->saldo_anterior;
    }
}

function saldo_final_extrato($conta, $data_final) {
    $sql = "select
                k171_saldo
            from
               conciliacaobancaria
            WHERE
                k171_conta = {$conta}
                AND k171_data = '{$data_final}'";
    $resultado = pg_query($sql);

    if (pg_numrows($resultado) > 0) {
        while ($row = pg_fetch_object($resultado)) {
            return number_format($row->k171_saldo, 2, ".", "");
        }
    } else {
        return 0;
    }
}

function movimentacao_extrato($conta, $data_inicial, $data_final, $movimentacao) {
    $sql = "select
                sum(k172_valor) movimentacao
            from
               conciliacaobancarialancamento
            WHERE
                k172_conta = {$conta}
                AND k172_dataconciliacao BETWEEN '{$data_inicial}' AND '{$data_final}'
                AND k172_mov = {$movimentacao}";
    $resultado = pg_query($sql);
    $valor = 0;
    while ($row = pg_fetch_object($resultado)) {
        $valor = $row->movimentacao;
    }

    $sqlPendencias = "SELECT * FROM conciliacaobancariapendencia WHERE k173_data BETWEEN '{$data_inicial}' AND '{$data_final}' AND k173_conta = {$k13_reduz}";
    $query = pg_query($sqlPendencias);

    while ($data = pg_fetch_object($query)) {
        // Relátorio busca apenas não conciliados
        if (!conciliado($data->k173_conta, $data->k173_data, $data->k173_numcgm, $data->k173_tipomovimento, $data->k173_documento, $data->k173_codigo, $data->k173_valor, $movimentacao)) {
            $valor += $data->k173_valor;
        }
    }
    return number_format($valor, 2, ".", "");
}

function numero_documento_lancamento($tipoLancamento, $numeroOP, $planilha, $numeroSlip)
{
    switch ($tipoLancamento) {
        case "OP":
            return $numeroOP;
            break;
        case "REC":
            return $planilha;
            break;
        case "SLIP":
            return $numeroSlip;
            break;
        case 1:
            return $planilha;
            break;
        case 2:
            return $planilha;
            break;
    }
}

function tipoLancamento($id_tipo_lancamento)
{
    $tipo_lancamento = array("Selecione", "PGTO. EMPENHO", "EST. PGTO EMPENHO", "REC. ORCAMENTARIA",
                                "EST. REC. ORCAMENTARIA", "PGTO EXTRA ORCAMENTARIA", "EST. PGTO EXTRA ORCAMENTARIA",
                                "REC. EXTRA ORCAMENTARIA", "EST. REC. EXTRA ORCAMENTARIA", "PERDAS", "ESTORNO PERDAS",
                                "TRANSFERENCIA", "EST. TRANSFERENCIA", "PENDENCIA", "IMPLANTACAO");
    return $tipo_lancamento[$id_tipo_lancamento];
}

function tipoDocumentoLancamento($tipo_lancamento)
{
    switch (tipoLancamento($tipo_lancamento)) {
        case "PGTO. EMPENHO":
            return "30, 5, 37";
            break;
        case "EST. PGTO EMPENHO":
            return "31, 6";
            break;
        case "REC. ORCAMENTARIA":
            return "100, 116";
            break;
        case "EST. REC. ORCAMENTARIA":
            return "101";
            break;
        case "PGTO EXTRA ORCAMENTARIO":
            return "120, 161";
            break;
        case "EST. PGTO EXTRA ORCAMENTARIO":
            return "121, 163";
            break;
        case "EST. REC. EXTRA ORCAMENTARIA":
            return "131, 151, 153, 162";
            break;
        case "REC. EXTRA ORCAMENTARIA":
            return "130, 150, 152, 160";
            break;
        case "PERDAS":
            return "164";
            break;
        case "ESTORNO PERDAS":
            return "165";
            break;
        case "TRANSFERENCIA":
            return "140";
            break;
        case "EST. TRANSFERENCIA":
            return "141";
            break;
    }
}

function descricaoTipoLancamento($cod_doc)
{
    switch ($cod_doc) {
        case in_array($cod_doc, array("5", "30", "37")):
            return "PGTO. EMPENHO";
            break;
        case in_array($cod_doc, array("6", "31")):
            return "EST. PGTO EMPENHO";
            break;
        case "100":
            return "REC. ORCAMENTARIA";
            break;
        case "101":
            return "EST. REC. ORCAMENTARIA";
            break;
        case in_array($cod_doc, array("120", "161")):
            return "PGTO EXTRA ORCAMENTARIO";
            break;
        case in_array($cod_doc, array("121", "163")):
            return "EST. PGTO EXTRA ORCAMENTARIO";
            break;
        case in_array($cod_doc, array("131", "151", "153", "162")):
            return "EST. REC. EXTRA ORCAMENTARIA";
            break;
        case in_array($cod_doc, array("130", "150", "152", "160")):
            return "REC. EXTRA ORCAMENTARIA";
            break;
        case "164":
            return "PERDAS";
            break;
        case "165":
            return "ESTORNO PERDAS";
            break;
        case "140":
            return "TRANSFERENCIA";
            break;
        case "141":
            return "EST. TRANSFERENCIA";
            break;
        default :
            return "";
    }
}

function descricaoHistorico($tipo, $codigo, $historico)
{
    switch ($tipo) {
        case "OP":
            return "Empenho Nº {$codigo}";
            break;
        case "SLIP":
            return "Slip Nº {$codigo}";
            break;
        case "REC":
            return "Planilha Nº {$codigo}";
            break;
        default:
            return $historico;
    }
}

function naoPermitidos($cod_doc)
{
    $nao_permitidos = array("116");
    if (in_array($cod_doc, $nao_permitidos))
        return false;
    return true;
}

function data($data)
{
    $data = explode("/", $data);
    if (count($data) > 1) {
        return $data[2] . "-" . $data[1] . "-" . $data[0];
    } else {
        return $data[0];
    }
}

function excluir_lancamentos_conciliados($movimentos, $conta, $data_conciliacao)
{
    $retorno = array();
    // $retorno[] = $movimentos;
    foreach ($movimentos as $id => $movimento) {
        $i = 0;
        foreach ($movimento->tipo as $tipo) {
            $valor = $movimento->valor[$i];
            $numcgm = trim($movimento->cgm);
            $documento = trim($movimento->codigo[$i] . $movimento->documento[$i]);
            $data = data($movimento->data_lancamento);
            $where = where_conciliados($conta, $data, $tipo, $valor, $data_conciliacao, $numcgm, $documento);
            $conciliacao = new cl_conciliacaobancarialancamento();
            $retorno[] = $where;
            $retorno[] = $conciliacao->excluir(null, $where);
            $i++;
        }
    }
    return $retorno;
}

function where_conciliados($conta, $data, $tipo, $valor, $data_conciliacao, $numcgm, $documento)
{
    $where = "k172_conta = {$conta} AND k172_data = '{$data}' AND k172_valor = {$valor} AND k172_dataconciliacao = '{$data_conciliacao}'";
    $where .= $tipo ? " AND k172_coddoc = {$tipo} " : " AND k172_coddoc IS NULL ";
    $where .= $numcgm ? " AND k172_numcgm = {$numcgm} " :  " AND k172_numcgm IS NULL ";
    // $documento = preg_replace( "~\x{00a0}~siu", "", $documento);
    $where .= $documento ? " AND k172_codigo = '{$documento}' " : " AND k172_codigo IS NULL ";

    return $where;
}

function lancamentos_conciliados($movimentos, $conta, $data_conciliacao)
{
    $retorno = array();
    // $retorno[] = $movimentos;
    // $retorno[] = $movimentos;
    foreach ($movimentos as $id => $movimento) {
        $retorno[] = $movimento;
        $i = 0;
        foreach ($movimento->tipo as $tipo) {
            $valor = $movimento->valor[$i];
            $numcgm = trim($movimento->cgm);
            $documento = trim($movimento->codigo[$i] . $movimento->documento[$i]);
            $data = data($movimento->data_lancamento);
            $where = where_conciliados($conta, $data, $tipo, $valor, $data_conciliacao, $numcgm, $documento);

            $conciliacao = new cl_conciliacaobancarialancamento();

            $oSql = $conciliacao->sql_query_file(null, "*", null, $where);
            $conciliacao->sql_record($oSql);
            $retorno[] = $oSql;
            // Tratativas
            if ($conciliacao->numrows > 0) {
                $conciliacao->k172_conta = $conta;
                $conciliacao->k172_data = data($movimento->data_lancamento);
                $conciliacao->k172_numcgm = trim($movimento->cgm);
                $conciliacao->k172_coddoc = $tipo;
                $conciliacao->k172_mov = $movimento->movimentacao == "E" ? 1 : 2;
                $conciliacao->k172_codigo = $documento;
                $conciliacao->k172_valor = $valor;
                $conciliacao->k172_dataconciliacao = $data_conciliacao;
                $conciliacao->alterar();
                $retorno[] = $conciliacao;
            } else {
                $conciliacao->k172_conta = $conta;
                $conciliacao->k172_data = data($movimento->data_lancamento);
                $conciliacao->k172_numcgm = trim($movimento->cgm);
                $conciliacao->k172_coddoc = $tipo;
                $conciliacao->k172_mov = $movimento->movimentacao == "E" ? 1 : 2;
                $conciliacao->k172_codigo = $documento;
                $conciliacao->k172_valor = $valor;
                $conciliacao->k172_dataconciliacao = $data_conciliacao;
                $conciliacao->incluir();
                $retorno[] = $conciliacao;
            }
            $i++;
        }
    }
    return $retorno;
}

function data_implantacao_saldo()
{
    $clcaiparametro = new cl_caiparametro;
    $clcaiparametro->k29_instit = db_getsession("DB_instit");
    $result   = $clcaiparametro->sql_record($clcaiparametro->sql_query(db_getsession("DB_instit")));
    if($result != false && $clcaiparametro->numrows > 0 ) {
        return $clcaiparametro->k29_conciliacaobancaria;
    } else {
        return FALSE;
    }
}

function data_conciliacao($conta, $data, $numcgm, $cod_doc, $documento, $cheque, $valor)
{
    $oDaoConciliacaoBancaria = new cl_conciliacaobancarialancamento();
    if (is_array($cod_doc))
        $cod_doc = implode(",", $cod_doc);
    $data = data($data);
    $where = "k172_conta = {$conta} AND k172_data = '{$data}' AND k172_coddoc IN ({$cod_doc}) AND k172_valor = {$valor}";
    if ($numcgm)
        $where .= " AND k172_numcgm = {$numcgm} ";
    if ($documento)
        $where .= " AND k172_codigo = '{$documento}' ";

    $oSql = $oDaoConciliacaoBancaria->sql_query_file(null, "*", null, $where);
    $linha = $oDaoConciliacaoBancaria->sql_record($oSql);
    if ($oDaoConciliacaoBancaria->numrows > 0) {
        return date("d/m/Y", strtotime(pg_result($linha, 0, 6)));
    } else {
        return "";
    }
}

function query_lancamentos($conta, $data_inicial, $data_final, $condicao_lancamento, $tipo)
{
    $sSQL = "SELECT k29_conciliacaobancaria FROM caiparametro WHERE k29_instit = " . db_getsession('DB_instit');
    $rsResult = db_query($sSQL);
    $dataImplantacao = db_utils::fieldsMemory($rsResult, 0)->k29_conciliacaobancaria ? date("d/m/Y", strtotime(db_utils::fieldsMemory($rsResult, 0)->k29_conciliacaobancaria)) : "";

    if (in_array($tipo, array(0, 13, 14))) {
        $sql = query_pendencias($conta, $data_inicial, $data_final, $tipo);
    }
    if (!in_array($tipo, array(13, 14))) {
        if ($tipo == 0)
            $sql .= " union all ";
        $sql .= query_empenhos($conta, $data_inicial, $data_final, $condicao_lancamento, data($dataImplantacao));
        $sql .= " union all ";
        $sql .= query_planilhas($conta, $data_inicial, $data_final, $condicao_lancamento, data($dataImplantacao));
        $sql .= " union all ";
        $sql .= query_transferencias_debito($conta, $data_inicial, $data_final, $condicao_lancamento, data($dataImplantacao));
        $sql .= " union all ";
        $sql .= query_transferencias_credito($conta, $data_inicial, $data_final, $condicao_lancamento, data($dataImplantacao));
    }
    return $sql;
}

function query_pendencias($conta, $data_inicial, $data_final, $tipo)
{
        $sql = "SELECT
                k173_tipolancamento tipo_lancamento,
                k173_data as data,
                k172_dataconciliacao data_conciliacao,
                k173_tipomovimento cod_doc,
                CASE WHEN k173_mov = 1 THEN k173_valor ELSE 0 END as valor_debito,
                CASE WHEN k173_mov = 2 THEN k173_valor ELSE 0 END as valor_credito,
                k173_codigo codigo,
                k173_tipolancamento::text tipo,
                k173_documento as cheque,
                '' as ordem,
                z01_nome credor,
                k173_numcgm::text numcgm,
                k173_historico as historico
            FROM
                conciliacaobancariapendencia
            LEFT JOIN cgm ON z01_numcgm = k173_numcgm
            LEFT JOIN conciliacaobancarialancamento ON k172_data = k173_data
                AND ((k172_numcgm IS NULL AND k173_numcgm IS NULL) OR (k172_numcgm = k173_numcgm))
                AND ((k172_coddoc is null AND k173_tipomovimento = '') OR (k172_coddoc::text = k173_tipomovimento))
                AND ((k173_documento is null AND k172_codigo is null) OR
                 (k172_codigo::text = k173_codigo || k173_documento::text ))
                AND k172_valor = k173_valor
                AND k172_mov = k173_mov
            WHERE
                ((k173_data BETWEEN '{$data_inicial}'
                AND '{$data_final}') OR (k172_dataconciliacao > k173_data AND  k173_data < '{$data_final}')
                  OR (k172_dataconciliacao IS NULL AND k173_data < '{$data_inicial}')
                  OR (k172_dataconciliacao BETWEEN '{$data_inicial}'
                AND '{$data_final}'))
                AND k173_conta = {$conta} ";

        if ($tipo == 13)
            $sql .= " AND k173_tipolancamento = 2 ";
        if ($tipo == 14)
            $sql .= " AND k173_tipolancamento = 1 ";
    return $sql;
}

function query_empenhos($conta, $data_inicial, $data_final, $condicao_lancamento, $data_implantacao)
{
    $data_inicial = $data_inicial < $data_implantacao ? $data_implantacao : $data_inicial;
    if ($data_implantacao) {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND corrente.k12_data BETWEEN '{$data_implantacao}' AND '{$data_inicial}') ";
    } else {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND corrente.k12_data < '{$data_inicial}') ";
    }

    $sql = "select
            DISTINCT
                0 as tipo_lancamento,
                corrente.k12_data as data,
                k172_dataconciliacao data_conciliacao,
                conlancamdoc.c71_coddoc::text cod_doc,
                0 as valor_debito,
                corrente.k12_valor as valor_credito,
                e60_codemp || '/' || e60_anousu :: text as codigo,
                'OP' :: text as tipo,
                e81_numdoc :: text as cheque,
                coremp.k12_codord::text as ordem,
                z01_nome :: text as credor,
                z01_numcgm :: text as numcgm,
                '' as historico
            from
                corrente
                inner join coremp on coremp.k12_id = corrente.k12_id
                and coremp.k12_data = corrente.k12_data
                and coremp.k12_autent = corrente.k12_autent
                inner join empempenho on e60_numemp = coremp.k12_empen
                inner join cgm on z01_numcgm = e60_numcgm
                left join corhist on corhist.k12_id = corrente.k12_id
                and corhist.k12_data = corrente.k12_data
                and corhist.k12_autent = corrente.k12_autent
                left join corautent on corautent.k12_id = corrente.k12_id
                and corautent.k12_data = corrente.k12_data
                and corautent.k12_autent = corrente.k12_autent
                left join corgrupocorrente on corrente.k12_data = k105_data
                and corrente.k12_id = k105_id
                and corrente.k12_autent = k105_autent
                LEFT JOIN conlancamord ON conlancamord.c80_codord = coremp.k12_codord
                AND conlancamord.c80_data = coremp.k12_data
                LEFT JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamord.c80_codlan
                LEFT JOIN conlancamval ON conlancamval.c69_codlan = conlancamord.c80_codlan
                AND (
                    (
                        c69_credito = corrente.k12_conta
                        AND corrente.k12_valor > 0
                    )
                    OR (
                        c69_debito = corrente.k12_conta
                        AND corrente.k12_valor < 0
                    )
                )
                LEFT JOIN conciliacaobancarialancamento conc ON
                    conc.k172_conta = corrente.k12_conta
                    AND conc.k172_data = corrente.k12_data
                    AND conc.k172_coddoc = conlancamdoc.c71_coddoc
                    AND conc.k172_codigo = coremp.k12_codord::text || coremp.k12_cheque::text
                LEFT JOIN retencaopagordem ON e20_pagordem = coremp.k12_codord
                LEFT join retencaoreceitas on  e23_retencaopagordem = e20_sequencial  AND k12_valor = e23_valorretencao
                LEFT JOIN corempagemov ON corempagemov.k12_id = coremp.k12_id
                AND corempagemov.k12_autent = coremp.k12_autent
                AND corempagemov.k12_data = coremp.k12_data
                left join empagemov on e60_numemp = empagemov.e81_numemp
                  AND k12_codmov = e81_codmov
            WHERE
                corrente.k12_conta = {$conta}
                AND ((corrente.k12_data between '{$data_inicial}' AND '{$data_final}') {$condicao_implantacao} OR (k172_dataconciliacao BETWEEN '{$data_inicial}'
                AND '{$data_final}'))
                {$condicao_lancamento}
                AND c69_sequen IS NOT NULL
                AND e23_valorretencao IS NULL
                AND corrente.k12_instit = " . db_getsession("DB_instit");
    return $sql;
}

function query_planilhas($conta, $data_inicial, $data_final, $condicao_lancamento, $data_implantacao)
{
    $data_inicial = $data_inicial < $data_implantacao ? $data_implantacao : $data_inicial;
    if ($data_implantacao) {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND data BETWEEN '{$data_implantacao}' AND '{$data_inicial}') ";
    } else {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND data < '{$data_inicial}') ";
    }

    $sql = "select
                0 as tipo_lancamento,
                data,
                data_conciliacao,
                cod_doc::text,
                valor_debito,
                valor_credito,
                codigo,
                tipo,
                cheque,
                ordem::text,
                credor,
                ''::text as numcgm,
                '' as historico
            from
                (
                    select
          data,
            conc.k172_dataconciliacao as data_conciliacao,
            cod_doc,
            sum(k12_valor) as valor_debito,
            0 as valor_credito,
            tipo_movimentacao :: text,
            codigo :: text,
            tipo :: text,
            cheque :: text,
            ordem,
            credor :: text
        from
                        (
                        SELECT
                               DISTINCT
                                corrente.k12_conta as conta,
                                corrente.k12_data as data,
                                case
                                    when conlancamdoc.c71_coddoc = 116 then 100
                                    else conlancamdoc.c71_coddoc
                                end as cod_doc,
                                k12_valor,
                                ('planilha :' || k81_codpla) :: text as tipo_movimentacao,
                                k81_codpla :: text as codigo,
                                'REC' :: text as tipo,
                                (coalesce(placaixarec.k81_obs, '.')) :: text as historico,
                                null :: text as cheque,
                                0 as ordem,
                                null :: text as credor
                            from
                                corrente
                                inner join corplacaixa on k12_id = k82_id
                                and k12_data = k82_data
                                and k12_autent = k82_autent
                                inner join placaixarec on k81_seqpla = k82_seqpla
                                inner join tabrec on tabrec.k02_codigo = k81_receita
                                /* left join arrenumcgm on k00_numpre = cornump.k12_numpre left join cgm on k00_numcgm = z01_numcgm */
                                left join corhist on corhist.k12_id = corrente.k12_id
                                and corhist.k12_data = corrente.k12_data
                                and corhist.k12_autent = corrente.k12_autent
                                inner join corautent on corautent.k12_id = corrente.k12_id
                                and corautent.k12_data = corrente.k12_data
                                and corautent.k12_autent = corrente.k12_autent
                                /* Inclusão do tipo doc */
                                LEFT JOIN conlancamcorrente ON conlancamcorrente.c86_id = corrente.k12_id
                                AND conlancamcorrente.c86_data = corrente.k12_data
                                AND conlancamcorrente.c86_autent = corrente.k12_autent
                                LEFT JOIN conlancam ON conlancam.c70_codlan = conlancamcorrente.c86_conlancam
                                LEFT JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancam.c70_codlan

                            where
                                corrente.k12_conta = {$conta}
                                and corrente.k12_instit = " . db_getsession("DB_instit") . " {$condicao_lancamento}
                        ) as x
                                LEFT JOIN  conciliacaobancarialancamento conc ON conc.k172_conta = conta
                    AND conc.k172_data = data
                    AND conc.k172_coddoc = cod_doc
                    WHERE
                     ((data between '{$data_inicial}' AND '{$data_final}') {$condicao_implantacao} OR (k172_dataconciliacao BETWEEN '{$data_inicial}'
                                AND '{$data_final}'))
                    group by

                    data,
                    data_conciliacao,
                    cod_doc,
                    valor_credito,
                    tipo_movimentacao,
                    codigo,
                    tipo,

                    historico,
                    cheque,

                    ordem,
                    credor
                ) as xx";
    return $sql;
}

function query_transferencias_debito($conta, $data_inicial, $data_final, $condicao_lancamento, $data_implantacao)
{
    $data_inicial = $data_inicial < $data_implantacao ? $data_implantacao : $data_inicial;
    if ($data_implantacao) {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND corlanc.k12_data BETWEEN '{$data_implantacao}' AND '{$data_inicial}') ";
    } else {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND corlanc.k12_data < '{$data_inicial}') ";
    }

    $sql = "select
                0 as tipo_lancamento,
                corlanc.k12_data as data,
                k172_dataconciliacao data_conciliacao,
                conlancamdoc.c71_coddoc::text cod_doc,
                corrente.k12_valor as valor_debito,
                0 as valor_credito,
                k12_codigo::text as codigo,
                'SLIP'::text as tipo,
                e91_cheque::text as cheque,
                '' as ordem,
                z01_nome::text as credor,
                z01_numcgm::text as numcgm,
                '' as historico
            from
                corlanc
                inner join corrente on corrente.k12_id = corlanc.k12_id
                and corrente.k12_data = corlanc.k12_data
                and corrente.k12_autent = corlanc.k12_autent
                inner join slip on slip.k17_codigo = corlanc.k12_codigo
                inner join conplanoreduz on c61_reduz = slip.k17_credito
                and c61_anousu =  " . db_getsession('DB_anousu') . "
                inner join conplano on c60_codcon = c61_codcon
                and c60_anousu = c61_anousu
                left join slipnum on slipnum.k17_codigo = slip.k17_codigo
                left join cgm on slipnum.k17_numcgm = z01_numcgm
                left join sliptipooperacaovinculo on sliptipooperacaovinculo.k153_slip = slip.k17_codigo
                left join corconf on corconf.k12_id = corlanc.k12_id
                and corconf.k12_data = corlanc.k12_data
                and corconf.k12_autent = corlanc.k12_autent
                and corconf.k12_ativo is true
                left join empageconfche on empageconfche.e91_codcheque = corconf.k12_codmov
                and corconf.k12_ativo is true
                and empageconfche.e91_ativo is true
                left join corhist on corhist.k12_id = corrente.k12_id
                and corhist.k12_data = corrente.k12_data
                and corhist.k12_autent = corrente.k12_autent
                left join corautent on corautent.k12_id = corrente.k12_id
                and corautent.k12_data = corrente.k12_data
                and corautent.k12_autent = corrente.k12_autent
                /* Inclusão do tipo doc */
                LEFT JOIN conlancamcorrente ON conlancamcorrente.c86_id = corrente.k12_id
                AND conlancamcorrente.c86_data = corrente.k12_data
                AND conlancamcorrente.c86_autent = corrente.k12_autent
                LEFT JOIN conlancam ON conlancam.c70_codlan = conlancamcorrente.c86_conlancam
                LEFT JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancam.c70_codlan
    LEFT JOIN conciliacaobancarialancamento conc ON conc.k172_conta = corlanc.k12_conta
    AND conc.k172_data = corrente.k12_data
    AND conc.k172_coddoc = conlancamdoc.c71_coddoc
    AND conc.k172_valor = corrente.k12_valor
            where
                corlanc.k12_conta = {$conta}
                AND ((corlanc.k12_data between '{$data_inicial}' AND '{$data_final}') {$condicao_implantacao} OR (k172_dataconciliacao BETWEEN '{$data_inicial}'
                AND '{$data_final}'))  {$condicao_lancamento}";
    return $sql;
}

function query_transferencias_credito($conta, $data_inicial, $data_final, $condicao_lancamento, $data_implantacao)
{
    $data_inicial = $data_inicial < $data_implantacao ? $data_implantacao : $data_inicial;
    if ($data_implantacao) {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND corrente.k12_data BETWEEN '{$data_implantacao}' AND '{$data_inicial}') ";
    } else {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND corrente.k12_data < '{$data_inicial}') ";
    }

    $sql = "
        select
            0 as tipo_lancamento,
            corlanc.k12_data as data,
            k172_dataconciliacao data_conciliacao,
            conlancamdoc.c71_coddoc::text cod_doc,
            0 as valor_debito,
            corrente.k12_valor as valor_credito,
            k12_codigo::text as codigo,
            'SLIP'::text as tipo,
            e91_cheque::text as cheque,
            '' as ordem,
            z01_nome::text as credor,
            z01_numcgm::text as numcgm,
            '' as historico
        from
            corrente
            inner join corlanc on corrente.k12_id = corlanc.k12_id
            and corrente.k12_data = corlanc.k12_data
            and corrente.k12_autent = corlanc.k12_autent
            inner join slip on slip.k17_codigo = corlanc.k12_codigo
            inner join conplanoreduz on c61_reduz = slip.k17_debito
            and c61_anousu =  " . db_getsession('DB_anousu') . "
            inner join conplano on c60_codcon = c61_codcon
            and c60_anousu = c61_anousu
            left join slipnum on slipnum.k17_codigo = slip.k17_codigo
            left join cgm on slipnum.k17_numcgm = z01_numcgm
            left join corconf on corconf.k12_id = corlanc.k12_id
            and corconf.k12_data = corlanc.k12_data
            and corconf.k12_autent = corlanc.k12_autent
            and corconf.k12_ativo is true
            left join sliptipooperacaovinculo on sliptipooperacaovinculo.k153_slip = slip.k17_codigo
            left join empageconfche on empageconfche.e91_codcheque = corconf.k12_codmov
            and corconf.k12_ativo is true
            and empageconfche.e91_ativo is true
            left join corhist on corhist.k12_id = corrente.k12_id
            and corhist.k12_data = corrente.k12_data
            and corhist.k12_autent = corrente.k12_autent
            left join corautent on corautent.k12_id = corrente.k12_id
            and corautent.k12_data = corrente.k12_data
            and corautent.k12_autent = corrente.k12_autent
            /* Inclusão do tipo doc */
            LEFT JOIN conlancamcorrente ON conlancamcorrente.c86_id = corrente.k12_id
            AND conlancamcorrente.c86_data = corrente.k12_data
            AND conlancamcorrente.c86_autent = corrente.k12_autent
            LEFT JOIN conlancam ON conlancam.c70_codlan = conlancamcorrente.c86_conlancam
            LEFT JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancam.c70_codlan
       LEFT JOIN conciliacaobancarialancamento conc ON conc.k172_conta = corrente.k12_conta
            AND conc.k172_data = corrente.k12_data
            AND conc.k172_coddoc = conlancamdoc.c71_coddoc
            AND conc.k172_valor = corrente.k12_valor
        where
            corrente.k12_conta = {$conta}
            AND ((corrente.k12_data between '{$data_inicial}' AND '{$data_final}') {$condicao_implantacao} OR (k172_dataconciliacao BETWEEN '{$data_inicial}'
                AND '{$data_final}')) {$condicao_lancamento}
        order by
            data,
            codigo";
    return $sql;
}

/**
 * Retorna a data da conciliação atraves dos filtros de lancamentos
 * @return Bool
 */
function conciliado($conta, $data, $numcgm, $cod_doc, $documento, $cheque, $valor, $mov)
{
    $sql = "SELECT k172_dataconciliacao FROM conciliacaobancarialancamento WHERE k172_mov = {$mov} AND k172_conta = {$conta} AND k172_data = '{$data}' AND k172_coddoc IN ({$cod_doc}) AND k172_valor = {$valor}";
    if ($numcgm)
        $sql .= " AND k172_numcgm = {$numcgm} ";
    if ($documento)
        $sql .= " AND k172_codigo = '{$documento}' ";
    $query = pg_query($sql);
    if (pg_num_rows($query) > 0) {
        while ($row = pg_fetch_object($query)) {
            if ($row->k172_dataconciliacao)
                return TRUE;
            else
                return FALSE;
        }
    } else {
        return FALSE;
    }
}
