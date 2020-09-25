<?php
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
include("libs/db_sql.php");
include("libs/db_utils.php");
include("classes/db_matordem_classe.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$clmatordem = new cl_matordem;
$iInstit    = db_getsession('DB_instit');
$iAnoUsu    = db_getsession("DB_anousu");
$dtDataUsu  = date("Y-m-d", db_getsession("DB_datausu"));
$sWhere     = "";
$sOrder     = "";
$agrupa     = false;

if (isset($lFiltro) && $lFiltro == "t") {
    $sWhere .= " WHERE m51_valortotal > valorlancado AND (m51_data+{$iDiasPrazo}) < '{$dtDataUsu}' ";
} else {
    $sWhere .= " WHERE m51_valortotal > valorlancado ";
}

if (isset($lQuebra) && $lQuebra == "t") {
    $sOrder .= " ORDER BY fornecedor, m51_data";
    $agrupa = true;
} else {
    $sOrder .= " ORDER BY m51_data ";
}

$sSqlOrdemPendente = "  SELECT  m51_codordem as cod_ordem,
                                z01_numcgm as cgm,
                                fornecedor,
                                empenho,
                                m51_data as data_emissao,
                                ('{$dtDataUsu}'::date - m51_data::date)||' DIAS' as dias_atraso
                        FROM
                            (SELECT m51_codordem,
                                    z01_numcgm,
                                    z01_nome as fornecedor,
                                    empenho,
                                    m51_data,
                                    m51_valortotal,
                                    sum(m71_valor) as valorlancado
                                FROM 
                                    (SELECT DISTINCT
                                        m51_codordem,
                                        m52_codlanc,
                                        z01_numcgm,
                                        z01_nome,
                                        (e60_codemp||'/'||e60_anousu)::varchar AS empenho,
                                        m51_data,
                                        m51_valortotal
                                    FROM matordem
                                        INNER JOIN matordemitem ON  matordemitem.m52_codordem = matordem.m51_codordem
                                        LEFT  JOIN empnotaord ON empnotaord.m72_codordem = matordem.m51_codordem
                                        LEFT  JOIN empnota ON empnota.e69_codnota = empnotaord.m72_codnota
                                        INNER JOIN empempenho ON empempenho.e60_numemp = empnota.e69_numemp AND empempenho.e60_anousu = empnota.e69_anousu
                                        INNER JOIN cgm ON cgm.z01_numcgm = matordem.m51_numcgm
                                        LEFT  JOIN matordemanu ON matordemanu.m53_codordem = matordem.m51_codordem
                                        WHERE e60_anousu = {$iAnoUsu}
                                            AND (m51_obs != 'Ordem de Compra Automatica' OR m51_obs IS NULL)
                                            AND m53_codordem IS NULL
                                            AND e60_instit = {$iInstit}
                                    ) as x
                                INNER JOIN matestoqueitemoc ON m52_codlanc = m73_codmatordemitem
                                INNER JOIN matestoqueitem ON m71_codlanc = m73_codmatestoqueitem
                                WHERE m73_cancelado IS FALSE
                                GROUP BY 1, 2, 3, 4, 5, 6
                            ) AS xx
                        {$sWhere}
                        {$sOrder}";

$rsResultOrdemPendente = $clmatordem->sql_record($sSqlOrdemPendente);

if ($clmatordem->numrows == 0) {
    db_redireciona('db_erros.php?fechar=true&db_erro=Não há ordens de compra pendentes de entrada');
} 

$head3 = "Controle de Ordens de Compra";

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->setfillcolor(235);
$pdf->setfont('arial','b',8);

$troca = 1;
$alt   = 4;
$prenc = 1;

for ($i = 0; $i < $clmatordem->numrows; $i++) {

    db_fieldsmemory($rsResultOrdemPendente,$i);

    if ($pdf->gety() > $pdf->h - 30 || $troca != 0 ){

        $pdf->addpage("L");
        
        if (!$agrupa) {
        
            $pdf->setfont('arial','b',9);
            $pdf->cell(47,$alt,"Código da Ordem",0,0,"C",1);
            $pdf->cell(47,$alt,"Data de Emissão",0,0,"C",1);
            $pdf->cell(46,$alt,"Empenho",0,0,"C",1);
            $pdf->cell(70,$alt,"Fornecedor",0,0,"C",1);
            $pdf->cell(70,$alt,"Entrada com pendência de:",0,0,"C",1);
            $pdf->Ln();

        }

        $troca = 0;
        $prenc = 1;

    }

    if ($prenc == 0){
        $prenc = 1;
    } else $prenc = 0;

    if ($agrupa && $repete != $cgm) {
        $pdf->setfont('arial','',9);
        $pdf->cell(280,$alt+4,$fornecedor,0,0,"L",0);
        $pdf->ln();

        if ($agrupa) {
            
            $pdf->setfont('arial','b',9);
            $pdf->cell(47,$alt,"Código da Ordem",0,0,"C",1);
            $pdf->cell(47,$alt,"Data de Emissão",0,0,"C",1);
            $pdf->cell(46,$alt,"Empenho",0,0,"C",1);
            $pdf->cell(70,$alt,"Fornecedor",0,0,"C",1);
            $pdf->cell(70,$alt,"Entrada com pendência de:",0,0,"C",1);
            $pdf->Ln();
        
        }
    }
    
    $pdf->setfont('arial','',8);
    $pdf->cell(47,$alt,$cod_ordem,0,0,"C",$prenc);
    $pdf->cell(47,$alt,$data_emissao,0,0,"C",$prenc);
    $pdf->cell(46,$alt,$empenho,0,0,"C",$prenc);
    $pdf->cell(70,$alt,$fornecedor,0,0,"C",$prenc);
    $pdf->cell(70,$alt,$dias_atraso,0,0,"C",$prenc);
    $pdf->Ln();

    if ($agrupa) {
        $repete = $cgm;
    }

}

$pdf->Output();

?>