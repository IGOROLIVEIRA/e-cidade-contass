<?php
/**
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
require_once 'fpdf151/pdf.php';
require_once 'libs/db_sql.php';
require_once 'libs/db_libpessoal.php';
require_once ('classes/db_rhpessoal_classe.php');

$rhpessoal = new cl_rhpessoal();
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$head2 = "CONFERÊNCIA (".$mes." / ".$ano.")";

$sSql = "
select distinct * from flpgo10". db_getsession('DB_anousu') ." where si195_mes = $mes";
$result_dados = db_query($sSql);
$numrows_dados = pg_numrows($result_dados);

if($numrows_dados == 0){
  db_redireciona('db_erros.php?fechar=true&db_erro=Não existem dados no período de '.$mes.' / '.$ano);
}

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->setfillcolor(235);
$alt   = 4;
// Inicia da geracao do relatorio

$pdf->ln(1750);


$sSqlRubricasSemBase = "select rh27_rubric, rh27_descr  from rhrubricas
where rh27_rubric not in (SELECT r09_rubric FROM basesr
WHERE (r09_base BETWEEN 'S001' AND 'SP99')
AND r09_anousu = ".db_anofolha()." AND r09_mesusu = ".db_mesfolha().")
AND rh27_pd <> 3";
$result_rsb  = db_query($sSqlRubricasSemBase);
$numrows_rsb = pg_numrows($result_rsb);
$cor = 1;
$pdf->setfont('arial', 'b', 7);
$pdf->cell(80, $alt, "Rubricas sem base", 1, 1, "C", $cor);

for($x = 0;$x < pg_numrows($result_rsb);$x++) {
    db_fieldsmemory($result_rsb, $x);

    $pdf->cell(80,$alt,$rh27_rubric,1,0,"C",0);
    $pdf->cell(80,$alt,$rh27_descr,1,1,"C",0);

}


$sSqlVerificaCargo = "select rh37_funcao from rhfuncao inner join db_config on db_config.codigo = rhfuncao.rh37_instit inner join rhfuncaogrupo on rhfuncaogrupo.rh100_sequencial = rhfuncao.rh37_funcaogrupo inner join cgm on cgm.z01_numcgm = db_config.numcgm where rh37_instit = 1 and rh37_reqcargo = 0  order by rh37_funcao ";
$result_cargo  = db_query($sSqlVerificaCargo);
$numrows_cargo = pg_numrows($result_cargo);
$cor = 1;
$pdf->setfont('arial', 'b', 7);
$pdf->cell(80, $alt, "CARGOS INDEFINIDOS", 1, 1, "C", $cor);

for($x = 0;$x < pg_numrows($result_cargo);$x++) {
    db_fieldsmemory($result_cargo, $x);

    $pdf->cell(80,$alt,$rh37_funcao,1,1,"C",0);

}

$sSqlVerificaRubricas = "select x.r09_base as r09_base, x.r09_rubric as r09_rubric from
((SELECT DISTINCT r09_base,
  r09_rubric
FROM basesr
  INNER JOIN bases ON r09_anousu = r08_anousu
WHERE r09_rubric in
      (
        SELECT x.r09_rubric
        FROM
          (SELECT r09_base,
             r09_rubric
           FROM basesr
             INNER JOIN bases ON r09_anousu = r08_anousu
           WHERE (r09_base BETWEEN 'S001' AND 'S017')


           GROUP BY r09_base,
             r09_rubric
           HAVING count(*) > 1
          ) AS x
        group by 1
        having count(x.r09_rubric) > 1
      )
      and
      (r09_base BETWEEN 'S001' AND 'S017')


order by r09_rubric asc)

union

(SELECT DISTINCT r09_base,
  r09_rubric
FROM basesr
  INNER JOIN bases ON r09_anousu = r08_anousu
WHERE r09_rubric in
      (
        SELECT x.r09_rubric
        FROM
          (SELECT r09_base,
             r09_rubric
           FROM basesr
             INNER JOIN bases ON r09_anousu = r08_anousu
           WHERE (r09_base BETWEEN 'S050' AND 'S076')


           GROUP BY r09_base,
             r09_rubric
           HAVING count(*) > 1
          ) AS x
        group by 1
        having count(x.r09_rubric) > 1
      )
      and
      (r09_base BETWEEN 'S050' AND 'S076')


order by r09_rubric asc)


union

(SELECT DISTINCT r09_base,
   r09_rubric
 FROM basesr
   INNER JOIN bases ON r09_anousu = r08_anousu
 WHERE r09_rubric in
       (
         SELECT x.r09_rubric
         FROM
           (SELECT r09_base,
              r09_rubric
            FROM basesr
              INNER JOIN bases ON r09_anousu = r08_anousu
            WHERE (r09_base = 'SP99')


            GROUP BY r09_base,
              r09_rubric
            HAVING count(*) > 1
           ) AS x
         group by 1
         having count(x.r09_rubric) > 1
       )
       and
       (r09_base = 'SP99')


 order by r09_rubric asc)


union

(SELECT DISTINCT r09_base,
   r09_rubric
 FROM basesr
   INNER JOIN bases ON r09_anousu = r08_anousu
 WHERE r09_rubric in
       (
         SELECT x.r09_rubric
         FROM
           (SELECT r09_base,
              r09_rubric
            FROM basesr
              INNER JOIN bases ON r09_anousu = r08_anousu
            WHERE (r09_base = 'SD99')


            GROUP BY r09_base,
              r09_rubric
            HAVING count(*) > 1
           ) AS x
         group by 1
         having count(x.r09_rubric) > 1
       )
       and
       (r09_base = 'SD99')


 order by r09_rubric asc)) as x

order by x.r09_rubric asc
";

$result_verifica  = db_query($sSqlVerificaRubricas);
$numrows_verifica = pg_numrows($result_verifica);



$cor = 1;
$pdf->setfont('arial','b',7);
$pdf->cell(80,$alt,"BASES COM RUBRICAS REPETIDAS",1,1,"C",$cor);
$pdf->cell(40,$alt,"BASE",1,0,"L",$cor);
$pdf->cell(40,$alt,"RUBRICA",1,1,"L",$cor);

$cor = 0;

for($x = 0;$x < pg_numrows($result_verifica);$x++) {
    db_fieldsmemory($result_verifica, $x);

    $pdf->cell(40,$alt,$r09_base,1,0,"L",$cor);
    $pdf->cell(40,$alt,$r09_rubric,1,1,"L",$cor);

}

$pdf->ln(2);

for($x = 0;$x < pg_numrows($result_dados);$x++) {
    db_fieldsmemory($result_dados,$x);

    $cor = 0;

    $result_cgm = db_query($rhpessoal->sql_query('','rh01_regist, z01_nome','',"z01_cgccpf = '$si195_numcpf'"));
    db_fieldsmemory($result_cgm,0);

    $pdf->cell(40,$alt,"MATRÍCULA: ".$rh01_regist,1,0,"L",$cor);
    $pdf->cell(40,$alt,"CPF: ".$si195_numcpf,1,0,"L",$cor);
    $pdf->cell(30,$alt,"REGIME: ".$si195_regime,1,0,"L",$cor);
    $pdf->cell(80,$alt,"NOME: ".$z01_nome,1,1,"L",$cor);
    $pdf->cell(40,$alt,"TIPO PAG: ".$si195_indtipopagamento,1,0,"L",$cor);
    $pdf->cell(40,$alt,"SITUAÇÃO: ".$si195_indsituacaoservidorpensionista,1,0,"L",$cor);
    $pdf->cell(40,$alt,"DT CONSESSÃO: ".$si195_datconcessaoaposentadoriapensao,1,1,"L",$cor);
    $pdf->cell(60,$alt,"CARGO: ".$si195_dsccargo,1,0,"L",$cor);
    $pdf->cell(40,$alt,"SIGLA: ".$si195_sglcargo,1,1,"L",$cor);
    $pdf->cell(190,$alt,"REQUISITO DO CARGO: ".  ($si195_reqcargo == 1) ." nível superior completo ou nível médio com especialização ".
        ($si195_reqcargo == 2) ." profissionais de saúde ". ($si195_reqcargo == 3) ." professor "  ,1,1,"L",$cor);
    $pdf->cell(40,$alt,"SERVIDOR CEDIDO: ".$si195_indcessao,1,0,"L",$cor);
    $pdf->cell(150,$alt,"DESCRIÇÃO LOTAÇÃO: ". $si195_dsclotacao,1,1,"L",$cor);
    $pdf->cell(40,$alt,"VALOR CARGA HORÁRIA: ". $si195_vlrcargahorariasemanal,1,0,"L",$cor);
    $pdf->cell(50,$alt,"DT EXERCÍCIO NO CARGO: ".$si195_datefetexercicio,1,0,"L",$cor);
    $pdf->cell(40,$alt,"DT EXCLUSÃO: ".$si195_datexclusão,1,1,"L",$cor);
    $pdf->cell(50,$alt,"VALOR TOTAL - RENDIMENTOS: ".$si195_vlrremuneracaobruta,1,1,"L",$cor);
    $pdf->cell(40,$alt,"NAT - SALDO LÍQUIDO: ".$si195_natsaldoliquido,1,0,"L",$cor);
    $pdf->cell(50,$alt,"VALOR TOTAL - RENDIMENTOS: ".$si195_vlrremuneracaoliquida,1,1,"L",$cor);
    $pdf->cell(40,$alt,"VALOR DEDUÇÕES: ".$si195_vlrdeducoes,1,0,"L",$cor);
    $pdf->cell(40,$alt,"TETO CONSTITUCIONAL: ".$si195_vlrabateteto,1,1,"L",$cor);

    $pdf->ln(1);

        $sSql2 = "
        select distinct * from flpgo11". db_getsession('DB_anousu') ." where si196_mes = $mes and si196_reg10 = $si195_sequencial";

        $result_dados2 = db_query($sSql2);
        $numrows_dados2 = pg_numrows($result_dados2);
        if($numrows_dados2 > 0){

            $cor = 1;

            $pdf->cell(68, $alt, "PROVENTO" , 1, 0, "L", $cor);
            $pdf->cell(50, $alt, "VALOR", 1, 1, "L", $cor);

            $cor = 0;

            for($y = 0;$y < $numrows_dados2;$y++) {
                db_fieldsmemory($result_dados2, $y);


                if($si196_tiporemuneracao == '01')
                    $sTiporemuneracao = "Subsídio";
                elseif($si196_tiporemuneracao == '02')
                    $sTiporemuneracao = "Pensão";
                elseif($si196_tiporemuneracao == '03')
                    $sTiporemuneracao = "Vencimento Cargo/Função Pública/Emprego Público";
                elseif($si196_tiporemuneracao == '04')
                    $sTiporemuneracao = "Proventos de Aposentadoria";
                elseif($si196_tiporemuneracao == '05')
                    $sTiporemuneracao = "Adicional por tempo de serviço";
                elseif($si196_tiporemuneracao == '06')
                    $sTiporemuneracao = "Vantagens Pessoais";
                elseif($si196_tiporemuneracao == '07')
                    $sTiporemuneracao = "Função Gratificada";
                elseif($si196_tiporemuneracao == '08')
                    $sTiporemuneracao = "Vantagens Eventuais";
                elseif($si196_tiporemuneracao == '09')
                    $sTiporemuneracao = "Pagamento Retroativo";
                elseif($si196_tiporemuneracao == '10')
                    $sTiporemuneracao = "Adicional Noturno";


                $pdf->cell(68, $alt,$sTiporemuneracao, 1, 0, "L", $cor);

                $pdf->cell(50, $alt,  $si196_vlrremuneracaodetalhada, 1, 1, "L", $cor);
            }
        }

    $sSql3 = "
        select distinct * from flpgo12". db_getsession('DB_anousu') ." where si197_mes = $mes and si197_reg10 = $si195_sequencial";

    $result_dados3 = db_query($sSql3);
    $numrows_dados3 = pg_numrows($result_dados3);
    if($numrows_dados3 > 0){

        $cor = 1;

        $pdf->cell(68, $alt, "DESCONTO" , 1, 0, "L", $cor);
        $pdf->cell(50, $alt, "VALOR", 1, 1, "L", $cor);

        $cor = 0;

        for($y = 0;$y < $numrows_dados3;$y++) {
            db_fieldsmemory($result_dados3, $y);


            if($si197_tipodesconto == '50')
                $stipodesconto = "Desc de Adiantamentos";
            elseif($si197_tipodesconto == '51')
                $stipodesconto = "Desc do Abate Teto sobre Remuneração";
            elseif($si197_tipodesconto == '52')
                $stipodesconto = "Desc do Abate Teto sobre Férias";
            elseif($si197_tipodesconto == '53')
                $stipodesconto = "Desconto do Abate Teto sobre 13º Salário";
            elseif($si197_tipodesconto == '54')
                $stipodesconto = "Desc da Contribuição Previdenciária";
            elseif($si197_tipodesconto == '55')
                $stipodesconto = "Desc do Imposto de Renda Retido na Fonte";
            elseif($si197_tipodesconto == '59')
                $stipodesconto = "Desc da 1ª Parcela do 13° Salário";
            elseif($si197_tipodesconto == '63')
                $stipodesconto = "Desc de Assistência Médica ou Odontológica";
            elseif($si197_tipodesconto == '64')
                $stipodesconto = "Desc de Férias";
            elseif($si197_tipodesconto == '65')
                $stipodesconto = "Desc de Outros Impostos e Contribuições";
            elseif($si197_tipodesconto == '66')
                $stipodesconto = "Desc da Previdência Complementar ? Parte do Empregado";
            elseif($si197_tipodesconto == '79')
                $stipodesconto = "Desc de Pagamento Indevido em Meses Anteriores";
            elseif($si197_tipodesconto == '99')
                $stipodesconto = "Outros Descontos Totalizados";


            $pdf->cell(68, $alt,$stipodesconto, 1, 0, "L", $cor);

            $pdf->cell(50, $alt,  $si197_vlrdescontodetalhado, 1, 1, "L", $cor);
        }
    }


    $pdf->ln(2);

}

$pdf->Output();