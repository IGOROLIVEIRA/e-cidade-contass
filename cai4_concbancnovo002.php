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


include("fpdf151/pdf.php");
include ("libs/db_utils.php");

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$head1 = "Conciliaçãoo Bancária";
$head3 = "PERÍODO : " . db_formatar(@$data_inicial, "d") . " A " . db_formatar(@$data_final, "d");

/// CONTAS MOVIMENTO
$sql = "select   k13_reduz,
                     k13_descr,
		     k13_dtimplantacao,
                     c60_estrut,
                     c60_codsis,
	                   c63_conta,
                       c63_dvconta,
                       c63_agencia,
                       c63_dvagencia,
	                   substr(fc_saltessaldo,2,13)::float8 as anterior,
	                   substr(fc_saltessaldo,15,13)::float8 as debitado ,
	                   substr(fc_saltessaldo,28,13)::float8 as creditado,
	                   substr(fc_saltessaldo,41,13)::float8 as atual
            	from (
 	                  select k13_reduz,
 	                         k13_descr,
				 k13_dtimplantacao,
	                         c60_estrut,
		                       c60_codsis,
		                       c63_conta,
                               c63_dvconta,
                               c63_agencia,
                               c63_dvagencia,
	                         fc_saltessaldo(k13_reduz,'".$data_inicial."','".$data_final."',null," . db_getsession("DB_instit") . ")
	                  from   saltes
	                         inner join conplanoexe   on k13_reduz = c62_reduz
		                                              and c62_anousu = ".db_getsession('DB_anousu')."
		                     inner join conplanoreduz on c61_anousu=c62_anousu and c61_reduz = c62_reduz and c61_instit = " . db_getsession("DB_instit") . "
	                         inner join conplano      on c60_codcon = c61_codcon and c60_anousu=c61_anousu
	                         left  join conplanoconta on c60_codcon = c63_codcon and c63_anousu=c60_anousu ";
if($conta_nova != "") {
    $sql .= "where c61_reduz = {$conta_nova} ";
}
$sql .= "  ) as x ";
$sql .= " order by substr(k13_descr,1,3), k13_reduz ";

$resultcontasmovimento = db_query($sql);

if (pg_numrows($resultcontasmovimento) == 0) {
    db_redireciona('db_erros.php?fechar=true&db_erro=Não existem dados neste periodo.');
}
$aContas = array();

$numrows = pg_numrows($resultcontasmovimento);
for($linha=0; $linha<$numrows; $linha++) {
    db_fieldsmemory($resultcontasmovimento,$linha);
    $aContas[$k13_reduz]->k13_reduz = $k13_reduz;
    $aContas[$k13_reduz]->k13_descr = $k13_descr;
    $aContas[$k13_reduz]->c63_conta = $c63_conta . '-' . $c63_dvconta;
    $aContas[$k13_reduz]->c63_agencia = $c63_agencia . '-' . $c63_dvagencia;
}

$sqlPendencias = "SELECT
                      *
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
                      AND '{$data_final}' AND k172_dataconciliacao IS NULL) OR (k172_dataconciliacao > '{$data_final}' AND  k173_data < '{$data_final}') OR (k172_dataconciliacao IS NULL AND k173_data < '{$data_inicial}'))
                      AND k173_conta = {$k13_reduz} ";
$query = pg_query($sqlPendencias);

while ($row = pg_fetch_object($query)) {
    if ($row->k173_tipolancamento == 1)
        $lancamentos[$row->k173_mov][] = $row;
    else
        $pendencias[$row->k173_mov][] = $row;
}

$sql = query_lancamentos($k13_reduz, $data_inicial, $data_final);
$query = pg_query($sql);

while ($row = pg_fetch_object($query)) {
    $movimento = $row->valor_debito > 0 ? 1 : 2;
    $valor = $row->valor_debito > 0 ? $row->valor_debito : $row->valor_credito;
    if ($valor < 0)
        $movimento = $movimento == 1 ? 2 : 1;
    $data = new StdClass();
    $data->k173_data = $row->data;
    $data->k173_codigo = $row->ordem;
    $data->k173_documento = (!$row->cheque AND $row->cheque == "0") ? "" : $row->cheque;
    $data->k173_historico = descricaoHistorico($row->tipo, $row->codigo);
    $data->k173_valor = abs($valor);
    $lancamentos[$movimento][] = $data;
}

// Definindo a impressão
$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->SetTextColor(0,0,0);
$pdf->setfillcolor(235);
$pdf->AutoPageBreak = false;
$pdf->AddPage("P");

foreach ($aContas as $oConta) {
    if ($pdf->GetY() > $pdf->h - 25){
        $pdf->AddPage("P");
    }

    $totalMovimentacaoGeral = 0;
    imprimeConta($pdf,$oConta);
    imprimeCabecalho($pdf);
    imprimeSaldoExtratoBancario($pdf, $saldo_extrato);
    $totalMovimentacaoGeral += $saldo_extrato;

    imprimeCabecalhoSub($pdf, "(2) ENTRADAS NÃO CONSIDERADAS PELO BANCO");
    $totalMovimentacao = 0;
    foreach ($lancamentos[1] as $lancamento) {
        if ($pdf->GetY() > $pdf->h - 25) {
            $pdf->AddPage("P");
            imprimeConta($pdf,$oConta);
            imprimeCabecalho($pdf);
        }
        $pdf->Cell(25, 5, db_formatar($lancamento->k173_data, "d"), "T", 0, "C", 0);
        $pdf->Cell(25, 5, $lancamento->k173_codigo, "T", 0, "C", 0);
        $pdf->Cell(25, 5, $lancamento->k173_documento, "T", 0, "C", 0);
        $pdf->Cell(92, 5, $lancamento->k173_historico, "T", 0, "L", 0);
        $pdf->Cell(25, 5, db_formatar($lancamento->k173_valor, "f"), "T", 0, "R", 0);
        $totalMovimentacao += $lancamento->k173_valor;
        $totalMovimentacaoGeral += $lancamento->k173_valor;
        $pdf->Ln(5);
	  }
    imprimeTotalMovConta($pdf, $totalMovimentacao, 2);
    $pdf->Ln(5);

    // Saídas não consideradas pela contabilidade
    imprimeCabecalhoSub($pdf, "(3) SAÍDAS NÃO CONSIDERADAS PELA CONTABILIDADE");
    $totalMovimentacao = 0;
	  foreach ($pendencias[2] as $lancamento) {
        if ($pdf->GetY() > $pdf->h - 25){
            $pdf->AddPage("P");
            imprimeConta($pdf,$oConta);
            imprimeCabecalho($pdf);
        }
        $pdf->Cell(25, 5, db_formatar($lancamento->k173_data, "d"), "T", 0, "C", 0);
        $pdf->Cell(25, 5, $lancamento->k173_codigo, "T", 0, "C", 0);
        $pdf->Cell(25, 5, $lancamento->k173_documento, "T", 0, "C", 0);
        $pdf->Cell(92, 5, $lancamento->k173_historico, "T", 0, "L", 0);
        $pdf->Cell(25, 5, db_formatar($lancamento->k173_valor, "f"), "T", 0, "R", 0);
        $totalMovimentacao += $lancamento->k173_valor;
        $totalMovimentacaoGeral += $lancamento->k173_valor;
        $pdf->Ln(5);
	  }
    imprimeTotalMovConta($pdf, $totalMovimentacao, 3);
    $pdf->Ln(5);

	  // Saídas não consideradas pelo banco
    imprimeCabecalhoSub($pdf, "(4) SAÍDAS NÃO CONSIDERADAS PELO BANCO");
    $totalMovimentacao = 0;
	  foreach ($lancamentos[2] as $lancamento) {
        if ($pdf->GetY() > $pdf->h - 25){
            $pdf->AddPage("P");
            imprimeConta($pdf,$oConta);
            imprimeCabecalho($pdf);
        }
        $pdf->Cell(25, 5, db_formatar($lancamento->k173_data, "d"), "T", 0, "C", 0);
        $pdf->Cell(25, 5, $lancamento->k173_codigo, "T", 0, "C", 0);
        $pdf->Cell(25, 5, $lancamento->k173_documento, "T", 0, "C", 0);
        $pdf->Cell(92, 5, $lancamento->k173_historico, "T", 0, "L", 0);
        $pdf->Cell(25, 5, db_formatar($lancamento->k173_valor, "f"), "T", 0, "R", 0);
        $totalMovimentacao += $lancamento->k173_valor;
        $totalMovimentacaoGeral -= $lancamento->k173_valor;
        $pdf->Ln(5);
	  }
    imprimeTotalMovConta($pdf, $totalMovimentacao, 4);
    $pdf->Ln(5);

    // Entradas não consideradas pela contabilidade
    imprimeCabecalhoSub($pdf, "(5) ENTRADAS NÃO CONSIDERADAS PELA CONTABILIDADE");
    $totalMovimentacao = 0;
	  foreach ($pendencias[1] as $lancamento) {
		    if ($pdf->GetY() > $pdf->h - 25) {
            $pdf->AddPage("P");
            imprimeConta($pdf,$oConta);
            imprimeCabecalho($pdf);
		    }
        $pdf->Cell(25, 5, db_formatar($lancamento->k173_data, "d"), "T", 0, "C", 0);
        $pdf->Cell(25, 5, $lancamento->k173_codigo, "T", 0, "C", 0);
        $pdf->Cell(25, 5, $lancamento->k173_documento, "T", 0, "C", 0);
        $pdf->Cell(92, 5, $lancamento->k173_historico, "T", 0, "L", 0);
        $pdf->Cell(25, 5, db_formatar($lancamento->k173_valor, "f"), "T", 0, "R", 0);
        $totalMovimentacao += $lancamento->k173_valor;
        $totalMovimentacaoGeral -= $lancamento->k173_valor;
        $pdf->Ln(5);
	  }
    imprimeTotalMovConta($pdf, $totalMovimentacao, 5);
    imprimeTotalMovContabilidade($pdf, $totalMovimentacaoGeral);
    $pdf->Ln(5);
}

if ($pdf->GetY() > $pdf->h - 25){
	  $pdf->AddPage("P");
}
// die;
$pdf->Output();
exit();

function imprimeConta($pdf, $oConta) {
    $pdf->SetFont('Arial','b',8);
    $pdf->Cell(12,5,"CONTA:",0,0,"L",0);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(95,5,$oConta->k13_reduz." - ".$oConta->k13_descr,0,0,"L",0);
    $pdf->SetFont('Arial','b',8);
    $pdf->Cell(10,5,"Nº:",0,0,"L",0);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(15,5,$oConta->c63_conta,0,0,"L",0);
    $pdf->SetFont('Arial','b',8);
    $pdf->Cell(10,5,"AG:",0,0,"L",0);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(15,5,$oConta->c63_agencia,0,0,"L",0);
    $pdf->SetFont('Arial','b',8);
    $pdf->ln();
    $pdf->SetFont('Arial','',7);
}

function imprimeCabecalhoSub($pdf, $descricao)
{
    $pdf->SetFont('Arial', 'b', 8);
    $pdf->Cell(192, 5, $descricao, "T", 0, "L", 1);
    $pdf->ln();
    $pdf->SetFont('Arial','',7);
}

function imprimeCabecalho($pdf){
    $pdf->SetFont('Arial', 'b', 8);
    $pdf->Cell(25, 5, "DATA", "T", 0, "C", 1);
    $pdf->Cell(25, 5, "OPS/REC/SLIP", "TL", 0, "C", 1);
    $pdf->Cell(25, 5, "DOCUMENTO", "TL", 0, "C", 1);
    $pdf->Cell(92, 5, "HISTÓRICO", "TL", 0, "C", 1);
    $pdf->Cell(25, 5, "VALOR", "TL", 0, "C", 1);
    $pdf->SetFont('Arial','',7);
    $pdf->ln();
}

function imprimeSaldoExtratoBancario($pdf, $valor) {
    $pdf->SetFont('Arial', 'b', 8);
    $pdf->Cell(20,5,"","TB",0,"R",1);
    $pdf->Cell(122,5, "Saldo do Extrato Bancário (1):" ,"TB",0,"R",1);
    $pdf->Cell(25,5,"","TLB",0,"R",1);
    $pdf->Cell(25,5,$valor	== 0 ? "" : db_formatar($valor,'f')	,"TB",0,"R",1);
    $pdf->ln();
    $pdf->SetFont('Arial','',7);
}

function imprimeTotalMovConta($pdf, $valor, $total) {
    $pdf->SetFont('Arial','b',8);
    $pdf->Cell(20,5,""																	,"TB",0,"R",1);
    $pdf->Cell(122,5,"TOTAL ({$total}):" ,"TB",0,"R",1);
    $pdf->Cell(25,5,"","TLB",0,"R",1);
    $pdf->Cell(25,5,$valor	== 0 ? "" : db_formatar($valor,'f')	,"TB",0,"R",1);
    $pdf->ln();
    $pdf->SetFont('Arial','',7);
}

function imprimeTotalMovContabilidade($pdf, $valor) {
    $pdf->SetFont('Arial','b',8);
    $pdf->Cell(20,5,"","TB",0,"R",1);
    $pdf->Cell(122,5,"SALDO NA CONTABILIDADE (6) = (1) + (2) + (3) - (4) - (5):" ,"TB",0,"R",1);
    $pdf->Cell(25,5,"","TLB",0,"R",1);
    $pdf->Cell(25,5,$valor == 0 ? "" : db_formatar($valor,'f')	,"TB",0,"R",1);
    $pdf->ln();
    $pdf->SetFont('Arial','',7);
}

function query_lancamentos($conta, $data_inicial, $data_final)
{
	  $condicao_lancamento = "";
	  $sSQL = "SELECT k29_conciliacaobancaria FROM caiparametro WHERE k29_instit = " . db_getsession('DB_instit');
    $rsResult = db_query($sSQL);
    $dataImplantacao = db_utils::fieldsMemory($rsResult, 0)->k29_conciliacaobancaria ? date("d/m/Y", strtotime(db_utils::fieldsMemory($rsResult, 0)->k29_conciliacaobancaria)) : "";
    $data_implantacao = data($dataImplantacao);
    $sql = query_empenhos($conta, $data_inicial, $data_final, $condicao_lancamento, $data_implantacao);
    $sql .= " union all ";
    $sql .= query_planilhas($conta, $data_inicial, $data_final, $condicao_lancamento, $data_implantacao);
    $sql .= " union all ";
    $sql .= query_transferencias_debito($conta, $data_inicial, $data_final, $condicao_lancamento, $data_implantacao);
    $sql .= " union all ";
    $sql .= query_transferencias_credito($conta, $data_inicial, $data_final, $condicao_lancamento, $data_implantacao);
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
                AND ((corrente.k12_data between '{$data_inicial}' AND '{$data_final}' AND k172_dataconciliacao IS NULL) {$condicao_implantacao} OR (k172_dataconciliacao > '{$data_final}'))
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
                                /* Incluso do tipo doc */
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
                     ((data between '{$data_inicial}' AND '{$data_final}'  AND k172_dataconciliacao IS NULL) {$condicao_implantacao} OR (k172_dataconciliacao > '{$data_final}'))
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
                AND ((corlanc.k12_data between '{$data_inicial}' AND '{$data_final}' AND k172_dataconciliacao IS NULL)
    {$condicao_implantacao} OR (k172_dataconciliacao > '{$data_final}'))  {$condicao_lancamento}";
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
            AND ((corrente.k12_data between '{$data_inicial}' AND '{$data_final}' AND k172_dataconciliacao IS NULL) {$condicao_implantacao} OR (k172_dataconciliacao > '{$data_final}')) {$condicao_lancamento}
        order by
            data,
            codigo";
    return $sql;
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

function descricaoHistorico($tipo, $codigo)
{
    switch ($tipo) {
        case "OP":
            return "Empenho Nº {$codigo}";
            break;
        case "SLIP":
            return "Slip Nº {$codigo}";
            break;
        case "Baixa":
            return "Baixa Nº {$codigo}";
            break;
        case "REC":
            return "Planilha Nº {$codigo}";
            break;
    }
}
?>
