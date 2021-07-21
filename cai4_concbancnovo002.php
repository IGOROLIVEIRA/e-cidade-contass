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
$head1 = "Conciliação Bancária";
$head3 = "Período : " . db_formatar(@$data_inicial, "d") . " a " . db_formatar(@$data_final, "d");

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
                      (
                        k172_codigo :: text = concat_ws('', k173_codigo::text, k173_documento::text)
                        ))
                      AND k172_valor = k173_valor
                      AND k172_mov = k173_mov
                  WHERE
                      ((k173_data BETWEEN '{$data_inicial}'
                      AND '{$data_final}' AND k172_dataconciliacao IS NULL)
                      OR (k172_dataconciliacao > '{$data_final}' AND  k173_data <= '{$data_final}')
                      OR (k172_dataconciliacao IS NULL AND k173_data <= '{$data_inicial}'))
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
    $movimento = $row->valor_credito < 0 ? 1 : $movimento;

    if ($movimento == 1) {
        $valor = $row->valor_debito  > 0 ? abs($row->valor_debito) : 0;
        $valor += $row->valor_credito < 0 ? abs($row->valor_credito) : 0;
    } else {
        $valor = $row->valor_debito  < 0 ? abs($row->valor_debito) : 0;
        $valor += $row->valor_credito > 0 ? abs($row->valor_credito) : 0;
    }


    $data = new StdClass();
    $data->k173_data = $row->data;
    $data->k173_codigo = ($row->codigo == 0 OR $row->codigo == "null") ? "" : $row->codigo;
    $data->k173_documento = (!$row->cheque AND $row->cheque == "0") ? "" : $row->cheque;
    $data->k173_historico = descricaoHistorico($row->tipo, $row->codigo, $row->historico);
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
$pdf->AddPage("L");

foreach ($aContas as $oConta) {
    if ($pdf->GetY() > $pdf->h - 25){
        $pdf->AddPage("L");
    }

    $totalMovimentacaoGeral = 0;
    imprimeConta($pdf,$oConta);
    imprimeCabecalho($pdf);
    $saldo_extrato = saldo_extrato_bancario($k13_reduz, $data_inicial, $data_final);
    imprimeSaldoExtratoBancario($pdf, $saldo_extrato);
    $pdf->Ln(5);
    $totalMovimentacaoGeral += $saldo_extrato;

    imprimeCabecalhoSub($pdf, "(2) ENTRADAS NÃO CONSIDERADAS PELO BANCO");
    $totalMovimentacao = 0;
    foreach ($lancamentos[1] as $lancamento) {
        if ($pdf->GetY() > $pdf->h - 25) {
            $pdf->AddPage("L");
            imprimeConta($pdf,$oConta);
            imprimeCabecalho($pdf);
        }
        $pdf->Cell(25, 5, db_formatar($lancamento->k173_data, "d"), "T", 0, "C", 0);
        $pdf->Cell(25, 5, $lancamento->k173_codigo, "T", 0, "C", 0);
        $pdf->Cell(25, 5, $lancamento->k173_documento, "T", 0, "C", 0);
        $pdf->Cell(179, 5, $lancamento->k173_historico, "T", 0, "L", 0);
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
            $pdf->AddPage("L");
            imprimeConta($pdf,$oConta);
            imprimeCabecalho($pdf);
        }
        $pdf->Cell(25, 5, db_formatar($lancamento->k173_data, "d"), "T", 0, "C", 0);
        $pdf->Cell(25, 5, $lancamento->k173_codigo, "T", 0, "C", 0);
        $pdf->Cell(25, 5, $lancamento->k173_documento, "T", 0, "C", 0);
        $pdf->Cell(179, 5, $lancamento->k173_historico, "T", 0, "L", 0);
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
            $pdf->AddPage("L");
            imprimeConta($pdf,$oConta);
            imprimeCabecalho($pdf);
        }
        $pdf->Cell(25, 5, db_formatar($lancamento->k173_data, "d"), "T", 0, "C", 0);
        $pdf->Cell(25, 5, ($lancamento->k173_codigo == "0" OR $lancamento->k173_codigo == NULL) ? "" : $lancamento->k173_codigo, "T", 0, "C", 0);
        $pdf->Cell(25, 5, $lancamento->k173_documento, "T", 0, "C", 0);
        $pdf->Cell(179, 5, $lancamento->k173_historico, "T", 0, "L", 0);
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
            $pdf->AddPage("L");
            imprimeConta($pdf,$oConta);
            imprimeCabecalho($pdf);
		    }
        $pdf->Cell(25, 5, db_formatar($lancamento->k173_data, "d"), "T", 0, "C", 0);
        $pdf->Cell(25, 5, ($lancamento->k173_codigo == "0" OR $lancamento->k173_codigo == NULL) ? "" : $lancamento->k173_codigo, "T", 0, "C", 0);
        $pdf->Cell(25, 5, $lancamento->k173_documento, "T", 0, "C", 0);
        $pdf->Cell(179, 5, $lancamento->k173_historico, "T", 0, "L", 0);
        $pdf->Cell(25, 5, db_formatar($lancamento->k173_valor, "f"), "T", 0, "R", 0);
        $totalMovimentacao += $lancamento->k173_valor;
        $totalMovimentacaoGeral -= $lancamento->k173_valor;
        $pdf->Ln(5);
	  }
    imprimeTotalMovConta($pdf, $totalMovimentacao, 5);
    $pdf->Ln(5);
    imprimeTotalMovContabilidade($pdf, $totalMovimentacaoGeral);
    $pdf->Ln(5);
}

$sqlparagpadrao  = " select db61_texto ";
$sqlparagpadrao .= " from db_documentopadrao ";
$sqlparagpadrao .= "     inner join db_docparagpadrao  on db62_coddoc   = db60_coddoc ";
$sqlparagpadrao .= "     inner join db_tipodoc         on db08_codigo   = db60_tipodoc ";
$sqlparagpadrao .= "     inner join db_paragrafopadrao on db61_codparag = db62_codparag ";
$sqlparagpadrao .= " where db60_tipodoc = 1507 and db60_instit = " . db_getsession("DB_instit") . " order by db62_ordem";

$resparagpadrao = @db_query($sqlparagpadrao);
if (@pg_numrows($resparagpadrao) > 0) {
    db_fieldsmemory($resparagpadrao, 0);
    // echo $db61_texto;
    if ($pdf->GetY() > $pdf->h - 35) {
        $pdf->AddPage("L");
    }
    @eval($db61_texto);
}

// die;
$pdf->Output();
exit();

function imprimeConta($pdf, $oConta) {
    $pdf->SetFont('Arial','b',8);
    $pdf->Cell(12,5,"CONTA:",0,0,"L",0);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(200,5,$oConta->k13_reduz." - ".$oConta->k13_descr,0,0,"L",0);
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

    if ($pdf->GetY() > $pdf->h - 25)
        $pdf->AddPage("L");

    $pdf->SetFont('Arial', 'b', 8);
    $pdf->Cell(279, 5, $descricao, "T", 0, "L", 1);
    $pdf->ln();
    $pdf->SetFont('Arial','',7);
}

function imprimeCabecalho($pdf){
    $pdf->SetFont('Arial', 'b', 8);
    $pdf->Cell(25, 5, "DATA", "T", 0, "C", 1);
    $pdf->Cell(25, 5, "OP/REC/SLIP", "TL", 0, "C", 1);
    $pdf->Cell(25, 5, "DOCUMENTO", "TL", 0, "C", 1);
    $pdf->Cell(179, 5, "HISTÓRICO", "TL", 0, "C", 1);
    $pdf->Cell(25, 5, "VALOR", "TL", 0, "C", 1);
    $pdf->SetFont('Arial','',7);
    $pdf->ln();
}

function imprimeSaldoExtratoBancario($pdf, $valor) {
    $pdf->SetFont('Arial', 'b', 8);
    $pdf->Cell(20,5,"","TB",0,"R",1);
    $pdf->Cell(209,5, "SALDO DO EXTRATO BANCÁRIO (1):" ,"TB",0,"R",1);
    $pdf->Cell(25,5,"","TLB",0,"R",1);
    $pdf->Cell(25,5,db_formatar($valor,'f'),"TB",0,"R",1);
    $pdf->ln();
    $pdf->SetFont('Arial','',7);
}

function imprimeTotalMovConta($pdf, $valor, $total) {
    $pdf->SetFont('Arial','b',8);
    $pdf->Cell(20,5,""																	,"TB",0,"R",1);
    $pdf->Cell(209,5,"TOTAL ({$total}):" ,"TB",0,"R",1);
    $pdf->Cell(25,5,"","TLB",0,"R",1);
    $pdf->Cell(25,5,db_formatar($valor,'f'),"TB",0,"R",1);
    $pdf->ln();
    $pdf->SetFont('Arial','',7);
}

function imprimeTotalMovContabilidade($pdf, $valor) {
    $pdf->SetFont('Arial','b',8);
    $pdf->Cell(20,5,"","TB",0,"R",1);
    $pdf->Cell(209,5,"SALDO NA CONTABILIDADE (6) = (1) + (2) + (3) - (4) - (5):" ,"TB",0,"R",1);
    $pdf->Cell(25,5,"","TLB",0,"R",1);
    $pdf->Cell(25,5,db_formatar($valor,'f')	,"TB",0,"R",1);
    $pdf->ln();
    $pdf->SetFont('Arial','',7);
}

function query_lancamentos($conta, $data_inicial, $data_final)
{
	$condicao_lancamento = "";
    $data_implantacao = data_implantacao();

    $sql  = query_empenhos($conta, $data_inicial, $data_final, $condicao_lancamento, $data_implantacao);
    $sql .= " union all ";
    $sql .= query_baixa($conta, $data_inicial, $data_final, $condicao_lancamento, $data_implantacao);
    $sql .= " union all ";
    $sql .= query_planilhas($conta, $data_inicial, $data_final, $condicao_lancamento, $data_implantacao);
    $sql .= " union all ";
    $sql .= query_transferencias_debito($conta, $data_inicial, $data_final, $condicao_lancamento, $data_implantacao);
    $sql .= " union all ";
    $sql .= query_transferencias_credito($conta, $data_inicial, $data_final, $condicao_lancamento, $data_implantacao);

    return $sql;
}

function query_baixa($conta, $inicio, $fim, $condicao, $implantacao) {
    $inicio = $inicio < $implantacao ? $implantacao : $inicio;
    $condicao_implantacao = query_baixa_implantacao($inicio, $fim, $implantacao);

    $sql  = query_baixa_padrao();
    $sql .= "       WHERE corrente.k12_conta = {$conta} ";
    $sql .= "           AND corrente.k12_instit = " . db_getsession('DB_instit');
    $sql .= "           AND corplacaixa.k82_id IS NULL ";
    $sql .= "           AND corplacaixa.k82_data IS NULL ";
    $sql .= "           AND corplacaixa.k82_autent IS NULL ";
    $sql .= "           {$condicao} ";
    $sql .= "       GROUP BY corrente.k12_conta, corrente.k12_data, discla.codret, c53_tipo, c71_coddoc, z01_numcgm ";
    $sql .= "    ) as x ";
    $sql .= "    LEFT JOIN conciliacaobancarialancamento conc ON conc.k172_conta = k12_conta ";
    $sql .= "        AND conc.k172_data = data ";
    $sql .= "        AND conc.k172_coddoc = cod_doc ";
    $sql .= "        AND conc.k172_codigo = codigo::text ";
    $sql .= "        AND round(conc.k172_valor, 2) = round(valor_debito, 2) ";
    $sql .= "    WHERE ";
    $sql .= "        ((data between '{$inicio}' AND '{$fim}' AND k172_dataconciliacao IS NULL) ";
    $sql .= "            {$condicao_implantacao}  OR (k172_dataconciliacao > '{$fim}' ";
    $sql .= "            AND data between '{$inicio}' AND '{$fim}')) ";
    $sql .= " ) as xx ";

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

    $sql  = query_padrao_op();
    $sql .= " WHERE corrente.k12_conta = {$conta} ";
    $sql .= "     AND ((corrente.k12_data between '{$data_inicial}' AND '{$data_final}' AND k172_dataconciliacao IS NULL) ";
    $sql .= "         {$condicao_implantacao} ";
    $sql .= "         OR (k172_dataconciliacao > '{$data_final}' AND corrente.k12_data between '{$data_inicial}' AND '{$data_final}')) ";
    $sql .= "    {$condicao_lancamento} ";
    $sql .= "    AND c69_sequen IS NOT NULL ";
    $sql .= "    AND corrente.k12_instit = " . db_getsession("DB_instit");
    $sql .= "    AND ";
    $sql .= condicao_retencao();

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

    $sql  = query_padrao_planilha($conta, $condicao_lancamento);
    $sql .= " WHERE ( ";
    $sql .= "     (data BETWEEN '{$data_inicial}' AND '{$data_final}' AND k172_dataconciliacao IS NULL) ";
    $sql .= "     {$condicao_implantacao} ";
    $sql .= "     OR (k172_dataconciliacao > '{$data_final}' AND data between '{$data_inicial}' AND '{$data_final}') ";
    $sql .= " ) ";
    return $sql;

}

function query_transferencias_debito($conta, $inicio, $fim, $condicao, $implantacao)
{
    $inicio = $inicio < $implantacao ? $implantacao : $inicio;
    if ($implantacao) {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND corlanc.k12_data BETWEEN '{$implantacao}' AND '{$inicio}') ";
    } else {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND corlanc.k12_data < '{$inicio}') ";
    }

    $sql  = query_padrao_slip_debito();
    $sql .= " WHERE corlanc.k12_conta = {$conta} ";
    $sql .= "    AND ((corlanc.k12_data between '{$inicio}' AND '{$fim}' AND k172_dataconciliacao IS NULL) ";
    $sql .= "    {$condicao_implantacao} ";
    $sql .= "    OR (k172_dataconciliacao > '{$fim}' AND corrente.k12_data between '{$inicio}' AND '{$fim}')) ";
    $sql .= "    {$condicao} ";

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

    $sql  = query_padrao_slip_credito();
    $sql .= " WHERE corrente.k12_conta = {$conta} ";
    $sql .= "     AND ((corrente.k12_data between '{$data_inicial}' AND '{$data_final}' AND k172_dataconciliacao IS NULL) ";
    $sql .= "         {$condicao_implantacao} ";
    $sql .= "         OR (k172_dataconciliacao > '{$data_final}' AND corrente.k12_data between '{$data_inicial}' AND '{$data_final}')) ";
    $sql .= "     {$condicao_lancamento} ";
    $sql .= " ORDER BY ";
    $sql .= "     data, ";
    $sql .= "     codigo ";

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

function descricaoHistorico($tipo, $codigo, $historico)
{
    switch ($tipo) {
        case "OP":
            return $historico;
            break;
        case "SLIP":
            return "Slip Nº {$codigo}";
            break;
        case "BAIXA":
            return "Arrecadação de Receita";
            break;
        case "REC":
            return "Planilha Nº {$codigo}";
            break;
    }
}

function saldo_extrato_bancario($conta, $inicio, $fim) {
    return (saldo_anterior_extrato($conta, $inicio, $fim)
        - movimentacao_extrato($conta, $inicio, $fim, 'E')
        + movimentacao_extrato($conta, $inicio, $fim, 'S'));
}

function saldo_anterior_extrato($conta, $inicio, $fim) {
    $sql  = " SELECT substr(fc_saltessaldo,41,13)::float8 as saldo_anterior ";
    $sql .= " FROM ( ";
    $sql .= "     SELECT fc_saltessaldo(k13_reduz, '{$inicio}', '{$fim}', null, " . db_getsession("DB_instit") . ") ";
    $sql .= "     FROM saltes ";
    $sql .= "     INNER JOIN conplanoexe ON k13_reduz = c62_reduz ";
    $sql .= "         AND c62_anousu = " . db_getsession('DB_anousu');
    $sql .= "     INNER JOIN conplanoreduz on c61_anousu = c62_anousu ";
    $sql .= "         AND c61_reduz = c62_reduz ";
    $sql .= "         AND c61_instit = " . db_getsession("DB_instit");
    $sql .= "     INNER JOIN conplano on c60_codcon = c61_codcon ";
    $sql .= "         AND c60_anousu = c61_anousu ";
    $sql .= "     WHERE c61_reduz = {$conta} ";
    $sql .= "         AND c60_codsis = 6 ";
    $sql .= " ) as x";

    return pg_fetch_object(pg_query($sql), 0)->saldo_anterior;
}

function movimentacao_extrato($conta, $inicio, $fim, $tipo)
{
	$implantacao = data_implantacao();
    $sql  = sql_total_empenhos($conta, $inicio, $fim, $implantacao);
    $sql .= " UNION ALL ";
    $sql .= query_baixa_total($conta, $inicio, $fim, $implantacao);
    $sql .= " UNION ALL ";
    $sql .= sql_total_planilha($conta, $inicio, $fim, $implantacao);
    $sql .= " UNION ALL ";
    $sql .= sql_total_transferencias_debito($conta, $inicio, $fim, $implantacao);
    $sql .= " UNION ALL ";
    $sql .= sql_total_transferencias_credito($conta, $inicio, $fim, $implantacao);

    $query = pg_query($sql);

    $valor = 0;
    while ($row = pg_fetch_object($query)) {
        // $movimento = $row->valor_debito > 0 ? 1 : 2;
        if ($tipo == 'E') {
            $valor += $row->valor_debito  > 0 ? abs($row->valor_debito) : 0;
            $valor += $row->valor_credito < 0 ? abs($row->valor_credito) : 0;
        } else {
            $valor += $row->valor_debito  < 0 ? abs($row->valor_debito) : 0;
            $valor += $row->valor_credito > 0 ? abs($row->valor_credito) : 0;
        }

    }

    $sql  = " SELECT ";
    $sql .= "    k173_tipolancamento, ";
    $sql .= "    k173_mov, ";
    $sql .= "    k173_valor ";
    $sql .= " FROM conciliacaobancariapendencia ";
    $sql .= " LEFT JOIN cgm ON z01_numcgm = k173_numcgm ";
    $sql .= " LEFT JOIN conciliacaobancarialancamento ON k172_data = k173_data ";
    $sql .= "     AND ((k172_numcgm IS NULL AND k173_numcgm IS NULL) OR (k172_numcgm = k173_numcgm)) ";
    $sql .= "     AND ((k172_coddoc is null AND k173_tipomovimento = '') OR (k172_coddoc::text = k173_tipomovimento)) ";
    $sql .= "     AND ((k173_documento is null AND k172_codigo is null) OR ";
    $sql .= "         (k172_codigo::text =  concat_ws('', k173_codigo::text, k173_documento::text))) ";
    $sql .= "     AND k172_valor = k173_valor ";
    $sql .= "     AND k172_mov = k173_mov ";
    $sql .= " WHERE ((k173_data BETWEEN '{$inicio}' AND '{$fim}' AND k172_dataconciliacao IS NULL) ";
    $sql .= "     OR (k172_dataconciliacao > '{$fim}' AND  k173_data <= '{$fim}') ";
    $sql .= "     OR (k172_dataconciliacao IS NULL AND k173_data <= '{$inicio}')) ";
    $sql .= "     AND k173_conta = {$conta} ";

    $query = pg_query($sql);
    while ($row = pg_fetch_object($query)) {
        if ($tipo == 'E') {
            if ($row->k173_tipolancamento == 1 AND $row->k173_mov == 1)
                $valor += $row->k173_valor;
            if ($row->k173_tipolancamento == 2 AND $row->k173_mov == 2)
                $valor += $row->k173_valor;
        }
        if ($tipo == 'S') {
          if ($row->k173_tipolancamento == 1 AND $row->k173_mov == 2)
              $valor += $row->k173_valor;
          if ($row->k173_tipolancamento == 2 AND $row->k173_mov == 1)
              $valor += $row->k173_valor;
        }
    }

    return $valor;
}

function data_implantacao() {
    $sql = "SELECT k29_conciliacaobancaria FROM caiparametro WHERE k29_instit = " . db_getsession('DB_instit');
    return db_utils::fieldsMemory(db_query($sql), 0)->k29_conciliacaobancaria ? date("Y-m-d", strtotime(db_utils::fieldsMemory(db_query($sql), 0)->k29_conciliacaobancaria)) : "";
}

function sql_total_empenhos($conta, $inicio, $fim, $implantacao)
{
    $inicio = $inicio < $implantacao ? $implantacao : $inicio;
    if ($implantacao) {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND corrente.k12_data  >= '{$implantacao}' AND corrente.k12_data <= '{$fim}') ";
    } else {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND corrente.k12_data < '{$inicio}') ";
    }

    $sql  = query_padrao_op();
    $sql .= " WHERE corrente.k12_conta = {$conta} ";
    $sql .= "     AND ( ";
    $sql .= "         (corrente.k12_data between '{$inicio}' AND '{$fim}' AND k172_dataconciliacao IS NULL) ";
    $sql .= "         {$condicao_implantacao} ";
    $sql .= "         OR (k172_dataconciliacao > '{$fim}' AND corrente.k12_data between '{$inicio}' AND '{$fim}') ";
    $sql .= "     ) ";
    $sql .= "     AND c69_sequen IS NOT NULL ";
    $sql .= "     AND corrente.k12_instit = " . db_getsession("DB_instit");
    $sql .= "     AND " . condicao_retencao();

    return $sql;
}

function condicao_retencao() {
    $sql  = " ( ";
    $sql .= " SELECT * ";
    $sql .= " FROM ( ";
    $sql .= "     SELECT SUM(e23_valorretencao) retencao ";
    $sql .= "     FROM retencaoreceitas ";
    $sql .= "     INNER JOIN retencaotiporec ON retencaotiporec.e21_sequencial = retencaoreceitas.e23_retencaotiporec ";
    $sql .= "     INNER JOIN retencaopagordem ON retencaopagordem.e20_sequencial = retencaoreceitas.e23_retencaopagordem ";
    $sql .= "     INNER JOIN tabrec ON tabrec.k02_codigo = retencaotiporec.e21_receita ";
    $sql .= "     INNER JOIN retencaotipocalc ON retencaotipocalc.e32_sequencial = retencaotiporec.e21_retencaotipocalc ";
    $sql .= "     INNER JOIN pagordem ON pagordem.e50_codord = retencaopagordem.e20_pagordem ";
    $sql .= "     INNER JOIN pagordemnota ON pagordem.e50_codord = pagordemnota.e71_codord ";
    $sql .= "     INNER JOIN empnota ON pagordemnota.e71_codnota = empnota.e69_codnota ";
    $sql .= "     INNER JOIN retencaoempagemov ON e23_sequencial = e27_retencaoreceitas ";
    $sql .= "     LEFT JOIN empagemovslips ON e27_empagemov = k107_empagemov ";
    $sql .= "     LEFT JOIN slipempagemovslips ON k107_sequencial = k108_empagemovslips ";
    $sql .= "     LEFT JOIN retencaocorgrupocorrente ON e23_sequencial = e47_retencaoreceita ";
    $sql .= "     LEFT JOIN corgrupocorrente ON e47_corgrupocorrente = k105_sequencial ";
    $sql .= "     LEFT JOIN cornump as numpre ON numpre.k12_data = k105_data ";
    $sql .= "         AND numpre.k12_autent = k105_autent ";
    $sql .= "         AND numpre.k12_id = k105_id ";
    $sql .= "     LEFT JOIN issplannumpre ON numpre.k12_numpre = q32_numpre ";
    $sql .= "     WHERE e20_pagordem = coremp.k12_codord ";
    $sql .= "         AND e27_principal IS true ";
    $sql .= "         AND e23_ativo IS true ";
    $sql .= "     ) as w ";
    $sql .= " WHERE round(retencao,2) = round(corrente.k12_valor,2) ";
    $sql .= " ) IS NULL ";

    return $sql;
}

function query_padrao_op()
{
    $sql  = " SELECT ";
    $sql .= "     0 as tipo_lancamento, ";
    $sql .= "     corrente.k12_data as data, ";
    $sql .= "     k172_dataconciliacao data_conciliacao, ";
    $sql .= "     conhistdoc.c53_tipo::text cod_doc, ";
    $sql .= "     0 as valor_debito, ";
    $sql .= "     corrente.k12_valor as valor_credito, ";
    $sql .= "     e60_codemp || '/' || e60_anousu::text as codigo, ";
    $sql .= "     'OP'::text as tipo, ";
    $sql .= "     CASE ";
    $sql .= "         WHEN e86_cheque IS NOT NULL AND e86_cheque <> '0' ";
    $sql .= "         THEN 'CHE ' || e86_cheque :: text ";
    $sql .= "         WHEN coremp.k12_cheque = 0 ";
    $sql .= "         THEN e81_numdoc::text ";
    $sql .= "         ELSE 'CHE ' || coremp.k12_cheque::text ";
    $sql .= "     END AS cheque, ";
    $sql .= "     coremp.k12_codord::text AS ordem, ";
    $sql .= "     z01_nome::text AS credor, ";
    $sql .= "     z01_numcgm::text AS numcgm, ";
    $sql .= "     '' AS historico ";
    $sql .= " FROM corrente ";
    $sql .= " INNER JOIN coremp ON coremp.k12_id = corrente.k12_id ";
    $sql .= "     AND coremp.k12_data = corrente.k12_data ";
    $sql .= "     AND coremp.k12_autent = corrente.k12_autent ";
    $sql .= " INNER JOIN empempenho ON e60_numemp = coremp.k12_empen ";
    $sql .= " INNER JOIN cgm ON z01_numcgm = e60_numcgm ";
    $sql .= " LEFT JOIN corhist ON corhist.k12_id = corrente.k12_id ";
    $sql .= "     AND corhist.k12_data = corrente.k12_data ";
    $sql .= "     AND corhist.k12_autent = corrente.k12_autent ";
    $sql .= " LEFT JOIN corautent ON corautent.k12_id = corrente.k12_id ";
    $sql .= "     AND corautent.k12_data = corrente.k12_data ";
    $sql .= "     AND corautent.k12_autent = corrente.k12_autent ";
    $sql .= " LEFT JOIN corgrupocorrente ON corrente.k12_data = k105_data ";
    $sql .= "     AND corrente.k12_id = k105_id ";
    $sql .= "     AND corrente.k12_autent = k105_autent ";
    $sql .= " LEFT JOIN conlancamcorgrupocorrente ON c23_corgrupocorrente = k105_sequencial ";
    $sql .= " LEFT JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamcorgrupocorrente.c23_conlancam ";
    $sql .= " LEFT JOIN conlancamval ON conlancamval.c69_codlan = conlancamcorgrupocorrente.c23_conlancam ";
    $sql .= "     AND (";
    $sql .= "         ( c69_credito = corrente.k12_conta";
    $sql .= "             AND corrente.k12_valor > 0 )";
    $sql .= "         OR ( c69_debito = corrente.k12_conta ";
    $sql .= "             AND corrente.k12_valor < 0 )";
    $sql .= "     )";
    $sql .= " LEFT JOIN corempagemov ON corempagemov.k12_id = coremp.k12_id";
    $sql .= "     AND corempagemov.k12_autent = coremp.k12_autent";
    $sql .= "     AND corempagemov.k12_data = coremp.k12_data";
    $sql .= " LEFT JOIN empagemov ON e60_numemp = empagemov.e81_numemp";
    $sql .= "      AND k12_codmov = e81_codmov";
    $sql .= " LEFT JOIN conhistdoc ON conhistdoc.c53_coddoc = conlancamdoc.c71_coddoc";
    $sql .= " LEFT JOIN empageconf ON empageconf.e86_codmov = empagemov.e81_codmov";
    $sql .= " LEFT JOIN conciliacaobancarialancamento conc ON conc.k172_conta = corrente.k12_conta";
    $sql .= "     AND conc.k172_data = corrente.k12_data";
    $sql .= "     AND conc.k172_coddoc = conhistdoc.c53_tipo";
    $sql .= "     AND conc.k172_codigo = concat_ws('', coremp.k12_codord::text, ( ";
    $sql .= "         CASE ";
    $sql .= "             WHEN e86_cheque IS NOT NULL AND e86_cheque <> '0' ";
    $sql .= "             THEN 'CHE ' || e86_cheque::text ";
    $sql .= "             WHEN coremp.k12_cheque = 0 ";
    $sql .= "             THEN e81_numdoc::text ";
    $sql .= "             ELSE 'CHE ' || coremp.k12_cheque::text ";
    $sql .= "         END ";
    $sql .= "         ) ";
    $sql .= "     ) ";

    return $sql;
}

function sql_total_planilha($conta, $inicio, $fim, $implantacao)
{
    $inicio = $inicio < $implantacao ? $implantacao : $inicio;
    if ($implantacao) {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND data >= '{$implantacao}' AND data <= '{$fim}')   ";
    } else {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND data < '{$inicio}') ";
    }

    $sql  = query_padrao_planilha($conta, "");
    $sql .= " WHERE ( ";
    $sql .= "     (data BETWEEN '{$inicio}' AND '{$fim}' AND k172_dataconciliacao IS NULL) ";
    $sql .= "     {$condicao_implantacao} ";
    $sql .= "     OR (k172_dataconciliacao > '{$fim}' AND data BETWEEN '{$inicio}' AND '{$fim}') ";
    $sql .= " ) ";

    return $sql;
}

function query_padrao_planilha($conta, $condicao) {
    $sql  = " SELECT ";
    $sql .= "     0 as tipo_lancamento, ";
    $sql .= "     data, ";
    $sql .= "     conc.k172_dataconciliacao as data_conciliacao, ";
    $sql .= "     cod_doc::text, ";
    $sql .= "     valor_debito, ";
    $sql .= "     valor_credito, ";
    $sql .= "     codigo, ";
    $sql .= "     tipo, ";
    $sql .= "     cheque, ";
    $sql .= "     ordem::text, ";
    $sql .= "     credor, ";
    $sql .= "     numcgm::text as numcgm, ";
    $sql .= "     '' as historico ";
    $sql .= " FROM ( ";
    $sql .= "     SELECT ";
    $sql .= "         data, ";
    $sql .= "         conta, ";
    $sql .= "         cod_doc, ";
    $sql .= "         sum(valor_debito) as valor_debito, ";
    $sql .= "         0 as valor_credito, ";
    $sql .= "         tipo_movimentacao::text, ";
    $sql .= "         codigo :: text, ";
    $sql .= "         tipo::text, ";
    $sql .= "         cheque::text, ";
    $sql .= "         ordem, ";
    $sql .= "         credor::text, ";
    $sql .= "         numcgm ";
    $sql .= "     FROM ( ";
    $sql .= "         SELECT ";
    $sql .= "            corrente.k12_id as caixa, ";
    $sql .= "            corrente.k12_conta as conta, ";
    $sql .= "            corrente.k12_data as data, ";
    $sql .= "            CASE ";
    $sql .= "                WHEN conlancamdoc.c71_coddoc = 100 THEN c70_valor ";
    $sql .= "                ELSE -1 * c70_valor ";
    $sql .= "            END as valor_debito, ";
    $sql .= "            0 valor_credito, ";
    $sql .= "            CASE ";
    $sql .= "                WHEN conlancamdoc.c71_coddoc = 116 ";
    $sql .= "                THEN 100 ";
    $sql .= "                ELSE conhistdoc.c53_tipo ";
    $sql .= "            END as cod_doc, ";
    $sql .= "            ('planilha :' || k81_codpla) :: text AS tipo_movimentacao, ";
    $sql .= "            k81_codpla::text as codigo, ";
    $sql .= "            'REC'::text AS tipo, ";
    $sql .= "            (coalesce(placaixarec.k81_obs, '.')) :: text as historico, ";
    $sql .= "            null::text AS cheque, ";
    $sql .= "            0 AS ordem, ";
    $sql .= "            z01_nome AS credor, ";
    $sql .= "            z01_numcgm AS numcgm ";
    $sql .= "        FROM corrente ";
    $sql .= "        INNER JOIN corplacaixa ON k12_id = k82_id ";
    $sql .= "            AND k12_data = k82_data ";
    $sql .= "            AND k12_autent = k82_autent ";
    $sql .= "        INNER JOIN placaixarec on k81_seqpla = k82_seqpla ";
    $sql .= "        INNER JOIN tabrec on tabrec.k02_codigo = k81_receita ";
    $sql .= "        LEFT JOIN corhist on corhist.k12_id = corrente.k12_id ";
    $sql .= "            AND corhist.k12_data = corrente.k12_data ";
    $sql .= "            AND corhist.k12_autent = corrente.k12_autent ";
    $sql .= "        INNER JOIN corautent on corautent.k12_id = corrente.k12_id ";
    $sql .= "            AND corautent.k12_data = corrente.k12_data ";
    $sql .= "            AND corautent.k12_autent = corrente.k12_autent ";
    $sql .= "        LEFT JOIN conlancamcorrente ON conlancamcorrente.c86_id = corrente.k12_id ";
    $sql .= "            AND conlancamcorrente.c86_data = corrente.k12_data ";
    $sql .= "            AND conlancamcorrente.c86_autent = corrente.k12_autent ";
    $sql .= "        LEFT JOIN conlancam ON conlancam.c70_codlan = conlancamcorrente.c86_conlancam ";
    $sql .= "        LEFT JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancam.c70_codlan ";
    $sql .= "        INNER JOIN cgm on cgm.z01_numcgm = placaixarec.k81_numcgm ";
    $sql .= "        LEFT JOIN conhistdoc ON conhistdoc.c53_coddoc = conlancamdoc.c71_coddoc ";
    $sql .= "        WHERE corrente.k12_conta = {$conta} ";
    $sql .= "            AND corrente.k12_instit = " . db_getsession("DB_instit") . $condicao;
    $sql .= "   ) AS x ";
    $sql .= "   GROUP BY ";
    $sql .= "        data, ";
    $sql .= "        cod_doc, ";
    $sql .= "        conta, ";
    $sql .= "        valor_credito, ";
    $sql .= "        tipo_movimentacao, ";
    $sql .= "        codigo, ";
    $sql .= "        tipo, ";
    $sql .= "        historico, ";
    $sql .= "        cheque, ";
    $sql .= "        numcgm, ";
    $sql .= "        ordem, ";
    $sql .= "        credor ";
    $sql .= "    ) as xx ";
    $sql .= " LEFT JOIN conciliacaobancarialancamento conc ON conc.k172_conta = conta ";
    $sql .= "    AND conc.k172_data = data ";
    $sql .= "    AND conc.k172_coddoc = cod_doc ";
    $sql .= "    AND conc.k172_codigo = codigo ";
    $sql .= "    AND conc.k172_valor::text = valor_debito::text ";

    return $sql;
}

function sql_total_transferencias_debito($conta, $inicio, $fim, $implantacao)
{
    $inicio = $inicio < $implantacao ? $implantacao : $inicio;
    if ($implantacao) {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND corlanc.k12_data  >= '{$implantacao}' AND corlanc.k12_data <= '{$fim}') ";
    } else {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND corlanc.k12_data < '{$inicio}') ";
    }

    $sql  = query_padrao_slip_debito();
    $sql .= " WHERE corlanc.k12_conta = {$conta} ";
    $sql .= "     AND ((corlanc.k12_data between '{$inicio}' AND '{$fim}' AND k172_dataconciliacao IS NULL) ";
    $sql .= "     {$condicao_implantacao} ";
    $sql .= "     OR (k172_dataconciliacao > '{$fim}' ";
    $sql .= "     AND corrente.k12_data between '{$inicio}' AND '{$fim}')) ";

    return $sql;
}


function sql_total_transferencias_credito($conta, $inicio, $fim, $implantacao)
{
    $inicio = $inicio < $implantacao ? $implantacao : $inicio;
    if ($implantacao) {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND corrente.k12_data  >= '{$implantacao}' AND corrente.k12_data <= '{$fim}') ";
    } else {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND corrente.k12_data < '{$inicio}') ";
    }

    $sql  = query_padrao_slip_credito();
    $sql .= " WHERE corrente.k12_conta = {$conta} ";
    $sql .= "     AND ((corrente.k12_data between '{$inicio}' AND '{$fim}' AND k172_dataconciliacao IS NULL) ";
    $sql .= "     {$condicao_implantacao} ";
    $sql .= "     OR (k172_dataconciliacao > '{$fim}' ";
    $sql .= "     AND corrente.k12_data between '{$inicio}' AND '{$fim}')) ";

    return $sql;
}

function query_padrao_slip_debito() {
    $sql  = " SELECT ";
    $sql .= "     0 AS tipo_lancamento, ";
    $sql .= "     corlanc.k12_data AS data, ";
    $sql .= "     k172_dataconciliacao data_conciliacao, ";
    $sql .= "     conhistdoc.c53_tipo::text cod_doc, ";
    $sql .= "     corrente.k12_valor AS valor_debito, ";
    $sql .= "     0 as valor_credito, ";
    $sql .= "     k12_codigo::text AS codigo, ";
    $sql .= "     'SLIP'::text AS tipo, ";
    $sql .= "     CASE ";
    $sql .= "         WHEN e91_cheque is null then e81_numdoc::text ";
    $sql .= "     else 'CHE ' || e91_cheque::text ";
    $sql .= "     end as cheque, ";
    $sql .= "     '' as ordem, ";
    $sql .= "     z01_nome::text as credor, ";
    $sql .= "     z01_numcgm::text as numcgm, ";
    $sql .= "     '' as historico ";
    $sql .= " FROM corlanc ";
    $sql .= " INNER JOIN corrente ON corrente.k12_id = corlanc.k12_id ";
    $sql .= "     AND corrente.k12_data = corlanc.k12_data ";
    $sql .= "     AND corrente.k12_autent = corlanc.k12_autent ";
    $sql .= " INNER JOIN slip ON slip.k17_codigo = corlanc.k12_codigo ";
    $sql .= " INNER JOIN conplanoreduz ON c61_reduz = slip.k17_credito ";
    $sql .= "     AND c61_anousu =  " . db_getsession('DB_anousu');
    $sql .= " INNER JOIN conplano on c60_codcon = c61_codcon ";
    $sql .= "     AND c60_anousu = c61_anousu ";
    $sql .= " LEFT JOIN slipnum on slipnum.k17_codigo = slip.k17_codigo ";
    $sql .= " LEFT JOIN cgm on slipnum.k17_numcgm = z01_numcgm ";
    $sql .= " LEFT JOIN sliptipooperacaovinculo on sliptipooperacaovinculo.k153_slip = slip.k17_codigo ";
    $sql .= " LEFT JOIN corconf on corconf.k12_id = corlanc.k12_id ";
    $sql .= "     AND corconf.k12_data = corlanc.k12_data ";
    $sql .= "     AND corconf.k12_autent = corlanc.k12_autent ";
    $sql .= "     AND corconf.k12_ativo IS TRUE ";
    $sql .= " LEFT JOIN empageconfche on empageconfche.e91_codcheque = corconf.k12_codmov ";
    $sql .= "     AND corconf.k12_ativo IS TRUE ";
    $sql .= "     AND empageconfche.e91_ativo IS TRUE ";
    $sql .= " LEFT JOIN corhist on corhist.k12_id = corrente.k12_id ";
    $sql .= "     AND corhist.k12_data = corrente.k12_data ";
    $sql .= "     AND corhist.k12_autent = corrente.k12_autent ";
    $sql .= " LEFT JOIN corautent on corautent.k12_id = corrente.k12_id ";
    $sql .= "     AND corautent.k12_data = corrente.k12_data ";
    $sql .= "     AND corautent.k12_autent = corrente.k12_autent ";
    $sql .= " LEFT JOIN conlancamcorrente ON conlancamcorrente.c86_id = corrente.k12_id ";
    $sql .= "     AND conlancamcorrente.c86_data = corrente.k12_data ";
    $sql .= "     AND conlancamcorrente.c86_autent = corrente.k12_autent ";
    $sql .= " LEFT JOIN conlancam ON conlancam.c70_codlan = conlancamcorrente.c86_conlancam ";
    $sql .= " LEFT JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancam.c70_codlan ";
    $sql .= " LEFT JOIN conhistdoc ON conhistdoc.c53_coddoc = conlancamdoc.c71_coddoc ";
    $sql .= " LEFT JOIN corempagemov on corempagemov.k12_data = corautent.k12_data ";
    $sql .= "     AND corempagemov.k12_id = corautent.k12_id ";
    $sql .= "     AND corempagemov.k12_autent = corautent.k12_autent ";
    $sql .= " LEFT JOIN  empagemov on corempagemov.k12_codmov = e81_codmov ";
    $sql .= " LEFT JOIN conciliacaobancarialancamento conc ON conc.k172_conta = corlanc.k12_conta ";
    $sql .= "     AND  conc.k172_data = corrente.k12_data ";
    $sql .= "     AND  conc.k172_coddoc = conhistdoc.c53_tipo ";
    $sql .= "     AND  conc.k172_valor = corrente.k12_valor ";
    $sql .= "     AND  conc.k172_codigo = concat_ws('', k12_codigo::text, ";
    $sql .= "         CASE ";
    $sql .= "             WHEN e91_cheque IS NULL ";
    $sql .= "             THEN e81_numdoc::text ";
    $sql .= "             ELSE 'CHE ' || e91_cheque::text ";
    $sql .= "         END) ";

    return $sql;
}

function query_padrao_slip_credito() {
    $sql  = " SELECT ";
    $sql .= "     0 AS tipo_lancamento, ";
    $sql .= "     corlanc.k12_data AS data, ";
    $sql .= "     k172_dataconciliacao data_conciliacao, ";
    $sql .= "     conhistdoc.c53_tipo::text cod_doc, ";
    $sql .= "     0 AS valor_debito, ";
    $sql .= "     corrente.k12_valor AS valor_credito, ";
    $sql .= "     k12_codigo::text AS codigo, ";
    $sql .= "     'SLIP'::text AS tipo, ";
    $sql .= "     CASE ";
    $sql .= "         WHEN e91_cheque IS NULL ";
    $sql .=  "         THEN e81_numdoc::text ";
    $sql .= "         ELSE 'CHE ' || e91_cheque::text ";
    $sql .= "     END AS cheque, ";
    $sql .= "     '' AS ordem, ";
    $sql .= "     z01_nome::text AS credor, ";
    $sql .= "     z01_numcgm::text AS numcgm, ";
    $sql .= "     '' AS historico ";
    $sql .= " FROM corrente ";
    $sql .= " INNER JOIN corlanc on corrente.k12_id = corlanc.k12_id ";
    $sql .= "     AND corrente.k12_data = corlanc.k12_data ";
    $sql .= "     AND  corrente.k12_autent = corlanc.k12_autent ";
    $sql  .= " INNER JOIN  slip on slip.k17_codigo = corlanc.k12_codigo ";
    $sql  .= " INNER JOIN  conplanoreduz on c61_reduz = slip.k17_debito ";
    $sql .= "     AND  c61_anousu = " . db_getsession('DB_anousu');
      $sql  .= " INNER JOIN  conplano on c60_codcon = c61_codcon ";
      $sql .= "     AND  c60_anousu = c61_anousu ";
      $sql .= " LEFT JOIN slipnum on slipnum.k17_codigo = slip.k17_codigo ";
      $sql .= " LEFT JOIN cgm on slipnum.k17_numcgm = z01_numcgm ";
      $sql .= " LEFT JOIN corconf on corconf.k12_id = corlanc.k12_id ";
      $sql .= "     AND  corconf.k12_data = corlanc.k12_data ";
      $sql .= "     AND  corconf.k12_autent = corlanc.k12_autent ";
      $sql .= "     AND  corconf.k12_ativo IS TRUE ";
      $sql .= " LEFT JOIN sliptipooperacaovinculo on sliptipooperacaovinculo.k153_slip = slip.k17_codigo ";
      $sql .= " LEFT JOIN empageconfche on empageconfche.e91_codcheque = corconf.k12_codmov ";
      $sql .= "     AND  corconf.k12_ativo IS TRUE ";
      $sql .= "     AND  empageconfche.e91_ativo IS TRUE ";
      $sql .= " LEFT JOIN corhist on corhist.k12_id = corrente.k12_id ";
      $sql .= "     AND  corhist.k12_data = corrente.k12_data ";
      $sql .= "     AND  corhist.k12_autent = corrente.k12_autent ";
      $sql .= " LEFT JOIN corautent on corautent.k12_id = corrente.k12_id ";
      $sql .= "     AND  corautent.k12_data = corrente.k12_data ";
      $sql .= "     AND  corautent.k12_autent = corrente.k12_autent ";
      $sql .= " LEFT JOIN conlancamcorrente ON conlancamcorrente.c86_id = corrente.k12_id ";
      $sql .= "     AND  conlancamcorrente.c86_data = corrente.k12_data ";
      $sql .= "     AND  conlancamcorrente.c86_autent = corrente.k12_autent ";
      $sql .= " LEFT JOIN conlancam ON conlancam.c70_codlan = conlancamcorrente.c86_conlancam ";
      $sql .= " LEFT JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancam.c70_codlan ";
      $sql .= " LEFT JOIN conhistdoc ON conhistdoc.c53_coddoc = conlancamdoc.c71_coddoc ";
      $sql .= " LEFT JOIN corempagemov on corempagemov.k12_data = corautent.k12_data ";
      $sql .= "     AND  corempagemov.k12_id = corautent.k12_id ";
      $sql .= "     AND  corempagemov.k12_autent = corautent.k12_autent ";
      $sql .= " LEFT JOIN empageslip ON empageslip.e89_codigo = slip.k17_codigo ";
      $sql .= " LEFT JOIN empagemov ON e89_codmov = e81_codmov ";
      $sql .= " LEFT JOIN conciliacaobancarialancamento conc ON conc.k172_conta = corrente.k12_conta ";
      $sql .= "     AND  conc.k172_data = corrente.k12_data ";
      $sql .= "     AND  conc.k172_coddoc = conhistdoc.c53_tipo ";
      $sql .= "     AND  conc.k172_valor = corrente.k12_valor ";
      $sql .= "     AND  conc.k172_codigo = concat_ws('', k12_codigo::text, ";
      $sql .= "         CASE ";
      $sql .= "             WHEN e91_cheque IS NULL ";
      $sql .= "             THEN e81_numdoc::text ";
      $sql .= "             ELSE 'CHE ' || e91_cheque::text ";
      $sql .= "         END) ";

      return $sql;
}


function query_baixa_implantacao($inicio, $fim, $implantacao) {
    if ($implantacao) {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND data >= '{$implantacao}' AND data <= '{$fim}') ";
    } else {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND data < '{$inicio}') ";
    }
    return $condicao_implantacao;
}

function query_baixa_padrao() {
    $sql = " SELECT ";
    $sql .= "     0 as tipo_lancamento, ";
    $sql .= "     data, ";
    $sql .= "     data_conciliacao, ";
    $sql .= "     cod_doc::text cod_doc, ";
    $sql .= "     valor_debito, ";
    $sql .= "     valor_credito, ";
    $sql .= "     codigo, ";
    $sql .= "     'BAIXA'::text as tipo, ";
    $sql .= "     NULL as cheque, ";
    $sql .= "     ordem::text ordem, ";
    $sql .= "     credor, ";
    $sql .= "     numcgm::text numcgm, ";
    $sql .= utf8_encode(" 'Arrecadação de Receita' historico ");
    $sql .= " FROM ( ";
    $sql .= "    SELECT ";
    $sql .= "        data, ";
    $sql .= "        valor_debito, ";
    $sql .= "        k172_dataconciliacao data_conciliacao, ";
    $sql .= "        valor_credito, ";
    $sql .= "        codigo :: text, ";
    $sql .= "        tipo :: text, ";
    $sql .= "        ordem, ";
    $sql .= "        credor :: text, ";
    $sql .= "        tipo_doc, ";
    $sql .= "        cod_doc, ";
    $sql .= "        numcgm ";
    $sql .= "    FROM ( ";
    $sql .= "       SELECT ";
    $sql .= "            corrente.k12_conta, ";
    $sql .= "            corrente.k12_data as data, ";
    $sql .= "            SUM(c70_valor) as valor_debito, ";
    $sql .= "            0 as valor_credito, ";
    $sql .= "            discla.codret as codigo, ";
    $sql .= "            'baixa' :: text as tipo, ";
    $sql .= "            0 as ordem, ";
    $sql .= "            z01_nome credor, ";
    $sql .= "            conhistdoc.c53_tipo tipo_doc, ";
    $sql .= "            c71_coddoc cod_doc, ";
    $sql .= "            z01_numcgm numcgm ";
    $sql .= "       FROM corrente ";
    $sql .= "       LEFT JOIN corhist on corhist.k12_id = corrente.k12_id ";
    $sql .= "           AND corhist.k12_data = corrente.k12_data ";
    $sql .= "           AND corhist.k12_autent = corrente.k12_autent ";
    $sql .= "       LEFT JOIN corautent on corautent.k12_id = corrente.k12_id ";
    $sql .= "           AND corautent.k12_data = corrente.k12_data ";
    $sql .= "           AND corautent.k12_autent = corrente.k12_autent ";
    $sql .= "       INNER JOIN corcla on corcla.k12_id = corrente.k12_id ";
    $sql .= "           AND corcla.k12_data = corrente.k12_data ";
    $sql .= "           AND corcla.k12_autent = corrente.k12_autent ";
    $sql .= "       INNER JOIN discla on discla.codcla = corcla.k12_codcla ";
    $sql .= "           AND discla.instit = " . db_getsession('DB_instit');
    $sql .= "       INNER JOIN disarq on disarq.codret = discla.codret ";
    $sql .= "           AND disarq.instit = discla.instit ";
    $sql .= "       LEFT JOIN corplacaixa ON corplacaixa.k82_id = corrente.k12_id ";
    $sql .= "           AND corplacaixa.k82_data = corrente.k12_data ";
    $sql .= "           AND corplacaixa.k82_autent = corrente.k12_autent ";
    $sql .= "       LEFT JOIN conlancamcorrente ON conlancamcorrente.c86_id = corrente.k12_id ";
    $sql .= "           AND conlancamcorrente.c86_data = corrente.k12_data ";
    $sql .= "           AND conlancamcorrente.c86_autent = corrente.k12_autent ";
    $sql .= "       LEFT JOIN conlancam ON conlancam.c70_codlan = conlancamcorrente.c86_conlancam ";
    $sql .= "       LEFT JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancam.c70_codlan ";
    $sql .= "       LEFT JOIN conhistdoc ON conhistdoc.c53_coddoc = conlancamdoc.c71_coddoc ";
    $sql .= "       LEFT JOIN placaixarec on k81_seqpla = k82_seqpla ";
    $sql .= "       LEFT JOIN cgm on cgm.z01_numcgm = placaixarec.k81_numcgm ";
    return $sql;
}

function query_baixa_total($conta, $inicio, $fim, $implantacao) {
    $inicio = $inicio < $implantacao ? $implantacao : $inicio;
    $condicao_implantacao = query_baixa_implantacao($inicio, $fim, $implantacao);

    $sql  = query_baixa_padrao();
    $sql .= "       WHERE corrente.k12_conta = {$conta} ";
    $sql .= "           AND corrente.k12_instit = " . db_getsession('DB_instit');
    $sql .= "           AND corplacaixa.k82_id IS NULL ";
    $sql .= "           AND corplacaixa.k82_data IS NULL ";
    $sql .= "           AND corplacaixa.k82_autent IS NULL ";
    $sql .= "       GROUP BY corrente.k12_conta, corrente.k12_data, discla.codret, c53_tipo, c71_coddoc, z01_numcgm ";
    $sql .= "    ) as x ";
    $sql .= "    LEFT JOIN conciliacaobancarialancamento conc ON conc.k172_conta = k12_conta ";
    $sql .= "        AND conc.k172_data = data ";
    $sql .= "        AND conc.k172_coddoc = cod_doc ";
    $sql .= "        AND conc.k172_codigo = codigo::text ";
    $sql .= "        AND round(conc.k172_valor, 2) = round(valor_debito, 2) ";
    $sql .= "    WHERE ";
    $sql .= "        ((data between '{$inicio}' AND '{$fim}' AND k172_dataconciliacao IS NULL) ";
    $sql .= "            {$condicao_implantacao} OR (k172_dataconciliacao > '{$fim}' ";
    $sql .= "            AND data between '{$inicio}' AND '{$fim}')) ";
    $sql .= " ) as xx ";

    return $sql;
}
?>
