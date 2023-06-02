<?php
require_once("fpdf151/pdf.php");
require_once("fpdf151/assinatura.php");
require_once("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("libs/db_libcontabilidade.php");
require_once("libs/db_liborcamento.php");
require_once("classes/db_orcparamrel_classe.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_conrelinfo_classe.php");
require_once("classes/db_db_config_classe.php");
require_once("classes/db_orcparamrelnota_classe.php");
require_once("classes/db_orcparamelemento_classe.php");
require_once("model/linhaRelatorioContabil.model.php");
require_once("model/relatorioContabil.model.php");

$classinatura = new cl_assinatura;

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

/*parametros*/
$encerramento = "n";
$sistema_contas = "";
$agrupa_estrutural = 0;
$conta = "S";
$estrut_inicial = 111;
$estrut_inicial2 = 2188;
$estrut_inicial3 = 1138;
$movimento = "S";
$tipo = "A";
////$recurso = array(102);
$recurso = array(100,101,118,119,103,/*educação*/113,122,143,144,145,146,147/*fimeducação*/,102,
    /*saude*/112,123,148,149,150,151,152,153,154,155/*fimsaude*/,156,129,190,191,192,/*outras*/116,117,142,124,157,158);
//$recurso = array(100);
$anousu = db_getsession("DB_anousu");
$perini = $anousu."-01-01";
$perfim = $anousu."-12-31";
$indicador_superavit = "";
$xinstit = str_replace("-", ",",$db_selinstit);

foreach ($recurso as $fonte) {
    $sql = "SELECT
       o15_codtri,
       round(substr(fc_planosaldonovo,45,14)::float8,2)::float8 AS saldo_final,
       substr(fc_planosaldonovo,60,1)::varchar(1) AS sinal_final
     FROM
    (SELECT p.c60_estrut AS estrut_mae,
            p.c60_estrut AS estrut,
            c61_reduz,
            c61_codcon,
            c61_codigo,
            p.c60_descr,
            p.c60_finali,
            r.c61_instit, fc_planosaldonovo(2018,c61_reduz,'2018-01-01','2018-12-31',FALSE),
            p.c60_identificadorfinanceiro,
            c60_consistemaconta,
            o15_codtri
     FROM conplanoexe e
     INNER JOIN conplanoreduz r ON r.c61_anousu = c62_anousu
     AND r.c61_reduz = c62_reduz
     INNER JOIN conplano p ON r.c61_codcon = c60_codcon
     AND r.c61_anousu = c60_anousu
     LEFT OUTER JOIN consistema ON c60_codsis = c52_codsis
     INNER JOIN orctiporec ON o15_codigo = c61_codigo
     WHERE c62_anousu = $anousu
         AND c61_instit IN ($xinstit)
         AND o15_codtri::int = $fonte
         AND o15_codtri != ''
         AND (p.c60_estrut LIKE '$estrut_inicial%') ) AS x";

    $result = db_query($sql);
//    echo $sql; db_criatabela($result);
    for($i = 0; $i < pg_numrows($result); $i++) {
        db_fieldsmemory($result,$i);

        if ($sinal_final == "C")
            $saldo_final *= -1;

        $nomeVariavel = "tot_saldo".$o15_codtri;
        $$nomeVariavel += $saldo_final;

    }

    $sql = "SELECT e91_numemp,
                e91_vlremp,
       e91_vlranu,
       e91_vlrliq,
       e91_vlrpag,
       o15_codtri,
       vlranu,
       vlrliq,
       vlrpag,
       vlrpagnproc,
       vlranuliq,
       vlranuliqnaoproc
FROM
    (SELECT e91_numemp,
            e91_anousu,
            e91_codtipo,
            e90_descr,
            o15_descr,
            o15_codtri,
            c70_anousu,
            coalesce(e91_vlremp,0) AS e91_vlremp,
            coalesce(e91_vlranu,0) AS e91_vlranu,
            coalesce(e91_vlrliq,0) AS e91_vlrliq,
            coalesce(e91_vlrpag,0) AS e91_vlrpag,e91_recurso,
            coalesce(vlranu,0) AS vlranu,
            coalesce(vlranuliq,0) AS vlranuliq,
            coalesce(vlranuliqnaoproc,0) AS vlranuliqnaoproc,
            coalesce(vlrliq,0) AS vlrliq,
            coalesce(vlrpag,0) AS vlrpag,
            coalesce(vlrpagnproc,0) AS vlrpagnproc
     FROM empresto
     INNER JOIN emprestotipo ON e91_codtipo = e90_codigo
     INNER JOIN orctiporec ON e91_recurso = o15_codigo
     LEFT OUTER JOIN
         (SELECT c75_numemp,
                 c70_anousu,
                 sum(round(CASE
                               WHEN c53_tipo = 11 THEN c70_valor
                               ELSE 0
                           END,2)) AS vlranu,
                 sum(round(CASE
                               WHEN c71_coddoc = 31 THEN c70_valor
                               ELSE 0
                           END,2)) AS vlranuliq,
                 sum(round(CASE
                               WHEN c71_coddoc = 32 THEN c70_valor
                               ELSE 0
                           END,2)) AS vlranuliqnaoproc,
                 sum(round(CASE
                               WHEN c53_tipo = 20 THEN c70_valor
                               ELSE (CASE
                                         WHEN c53_tipo = 21 THEN c70_valor*-1
                                         ELSE 0
                                     END)
                           END,2)) AS vlrliq,
                 sum(round(CASE
                               WHEN c71_coddoc = 35 THEN c70_valor
                               ELSE (CASE
                                         WHEN c71_coddoc = 36 THEN c70_valor*-1
                                         ELSE 0
                                     END)
                           END,2)) AS vlrpag,
                 sum(round(CASE
                               WHEN c71_coddoc = 37 THEN c70_valor
                               ELSE (CASE
                                         WHEN c71_coddoc = 38 THEN c70_valor*-1
                                         ELSE 0
                                     END)
                           END,2)) AS vlrpagnproc
          FROM conlancamemp
          INNER JOIN conlancamdoc ON c71_codlan = c75_codlan
          INNER JOIN conhistdoc ON c53_coddoc = c71_coddoc
          INNER JOIN conlancam ON c70_codlan = c75_codlan
          INNER JOIN empempenho ON e60_numemp = c75_numemp
          WHERE e60_anousu < $anousu
              AND c75_data BETWEEN '$perini' AND '$perfim'
              AND e60_instit IN ($xinstit)
          GROUP BY c75_numemp,
                   c70_anousu) AS x ON x.c75_numemp = e91_numemp
     WHERE e91_anousu = $anousu ) AS x
INNER JOIN empempenho ON e60_numemp = e91_numemp
AND e60_instit IN ($xinstit)
INNER JOIN empelemento ON e64_numemp = e60_numemp
INNER JOIN cgm ON z01_numcgm = e60_numcgm
INNER JOIN orcdotacao ON o58_coddot = e60_coddot
AND o58_anousu = e60_anousu
AND o58_instit = e60_instit
INNER JOIN orcorgao ON o40_orgao = o58_orgao
AND o40_anousu = o58_anousu
INNER JOIN orcunidade ON o41_anousu = o58_anousu
AND o41_orgao = o58_orgao
AND o41_unidade = o58_unidade
INNER JOIN orcfuncao ON o52_funcao = orcdotacao.o58_funcao
INNER JOIN orcsubfuncao ON o53_subfuncao = orcdotacao.o58_subfuncao
INNER JOIN orcprograma ON o54_programa = o58_programa
AND o54_anousu = orcdotacao.o58_anousu
INNER JOIN orcprojativ ON o55_projativ = o58_projativ
AND o55_anousu = orcdotacao.o58_anousu
INNER JOIN orcelemento ON o58_codele = o56_codele
AND o58_anousu = o56_anousu
AND 1=1
AND o15_codtri::int4 IN($fonte)
AND o15_codtri != ''
ORDER BY e91_recurso,
         e60_anousu,
         e60_codemp::bigint";

    $result = db_query($sql);
//echo db_criatabela($result);die();
    for ($i = 0; $i < pg_numrows($result); $i++) {
        db_fieldsmemory($result, $i);

        $nomeVariavelEmp = "tot_empenhado".$o15_codtri;
        $$nomeVariavelEmp += $e91_vlremp;

        $nomeVariavelLiq = "tot_liquidado".$o15_codtri;
        $$nomeVariavelLiq += $e91_vlrliq;

        $nomeVariavelEmpAnu = "tot_empenhadoAnu".$o15_codtri;
        $$nomeVariavelEmpAnu += $e91_vlranu;

        $nomeVariavelPago = "tot_empenhadoPago".$o15_codtri;
        $$nomeVariavelPago += $e91_vlrpag;

        $nomeVariavelvlranu = "tot_vlranu".$o15_codtri;
        $$nomeVariavelvlranu += $vlranu;

        $nomeVariavelvlrliq = "tot_vlrliq".$o15_codtri;
        $$nomeVariavelvlrliq += $vlrliq;

        $nomeVariavelvlrpag = "tot_vlrpag".$o15_codtri;
        $$nomeVariavelvlrpag += $vlrpag;

        $nomeVariavelvlrpagnproc = "tot_vlrpagnproc".$o15_codtri;
        $$nomeVariavelvlrpagnproc += $vlrpagnproc;

        $nomeVariavelvlranuliq = "tot_vlranuliq".$o15_codtri;
        $$nomeVariavelvlranuliq += $vlranuliq;

        $nomeVariavelvlranuliqnaoproc = "tot_vlranuliqnaoproc".$o15_codtri;
        $$nomeVariavelvlranuliqnaoproc += $vlranuliqnaoproc;

        $nomeVariavelTotal      = "total".$o15_codtri;
        $$nomeVariavelTotal     =  ($$nomeVariavelLiq - $$nomeVariavelPago -
                                   $$nomeVariavelvlrpag - $$nomeVariavelvlranuliq) + ($$nomeVariavelvlrliq - $$nomeVariavelvlrpagnproc);

        $nomeVariavelTotalNP    = "totalNP".$o15_codtri;
        $$nomeVariavelTotalNP   =  $$nomeVariavelEmp - $$nomeVariavelEmpAnu - $$nomeVariavelLiq -
            $$nomeVariavelvlranuliqnaoproc - $$nomeVariavelvlrliq;
    }

//    echo "valor liq:".$$nomeVariavelLiq;die();

    $sql = "SELECT * FROM
    (SELECT fonte,
            empenho,
            credor,
            round(sum(e60_vlremp - e60_vlranu - e60_vlrliq),2) AS vlr_n_lqd,
            round(sum(e60_vlrliq - e60_vlrpag),2) AS vlr_lqd,
            z01_numcgm,
            e60_anousu
     FROM
         (SELECT o15_codtri AS fonte,
                 e60_codemp AS empenho,
                 z01_numcgm,
                 z01_numcgm||'-'||z01_nome AS credor,
                 round(sum((CASE
                            WHEN c53_tipo = 10 THEN c70_valor
                            ELSE 0
                        END)),2) AS e60_vlremp,
                 round(sum((CASE
                            WHEN c53_tipo = 11 THEN c70_valor
                            ELSE 0
                        END)),2) AS e60_vlranu,
                 round(sum((CASE
                                WHEN c53_tipo = 20 THEN c70_valor
                                ELSE 0
                            END) - (CASE
                                        WHEN c53_tipo = 21 THEN c70_valor
                                        ELSE 0
                                    END)),2) AS e60_vlrliq,
                 round(sum((CASE
                                WHEN c53_tipo = 30 THEN c70_valor
                                ELSE 0
                            END) - (CASE
                                        WHEN c53_tipo = 31 THEN c70_valor
                                        ELSE 0
                                    END)),2) AS e60_vlrpag,
                 e60_anousu
          FROM empempenho
          JOIN conlancamemp ON c75_numemp = e60_numemp
          JOIN conlancamdoc ON c71_codlan = c75_codlan
          JOIN conlancam ON c70_codlan = c75_codlan
          JOIN conhistdoc ON c53_coddoc = c71_coddoc
          JOIN orcdotacao ON (e60_anousu, e60_coddot) = (o58_anousu, o58_coddot)
          JOIN orctiporec ON o15_codigo = o58_codigo
          JOIN cgm ON (e60_numcgm) = (z01_numcgm)
          WHERE e60_instit IN ($xinstit) and e60_anousu = $anousu
              AND c75_data BETWEEN '$perini' AND '$perfim'
              AND o15_codtri::INT = $fonte
              AND o15_codtri != ''
          GROUP BY 1,2,3,4,c53_tipo,c70_valor,e60_anousu
          ORDER BY 2, 3) AS x
     GROUP BY 1, 2, 3,z01_numcgm, e60_anousu
     ORDER BY 1, 2, 3) AS total
     WHERE (vlr_n_lqd > 0 OR vlr_lqd > 0)";

    $result = db_query($sql);
//  echo $sql; db_criatabela($result);
    for ($i = 0; $i < pg_numrows($result); $i++) {
        db_fieldsmemory($result, $i);

        $nomeTotaliq    = "tot_liqAPG".$fonte;
        $$nomeTotaliq   += $vlr_lqd;

        $nomeTotalaliq  = "tot_aliq".$fonte;
        $$nomeTotalaliq += $vlr_n_lqd;
    }

    $sql = "SELECT e60_vlremp,
                   e60_vlranu,
                   e60_vlrliq,
                   e60_vlrpag,
                   o15_codtri,
                   e94_empanuladotipo
            FROM empempenho
JOIN orcdotacao ON (o58_coddot,o58_anousu) = (e60_coddot,e60_anousu)
JOIN orctiporec ON o15_codigo = o58_codigo
LEFT JOIN empanulado ON e94_numemp = e60_numemp
WHERE e60_anousu = $anousu
    AND e60_instit IN ($xinstit)
    AND o15_codtri::INT4 IN ($fonte)
    AND o15_codtri != '' ";

    $result = db_query($sql);
//  echo $sql; db_criatabela($result);
    for ($i = 0; $i < pg_numrows($result); $i++) {
        db_fieldsmemory($result, $i);

        if ($e94_empanuladotipo == 1) {
            $nomevariavelempcancel = "tot_empcancel" . $o15_codtri;
            $$nomevariavelempcancel += $e60_vlranu;
        }

    }

    $sql = "SELECT
       o15_codtri,
       round(substr(fc_planosaldonovo,45,14)::float8,2)::float8 AS saldo_final,
       substr(fc_planosaldonovo,60,1)::varchar(1) AS sinal_final
     FROM
    (SELECT p.c60_estrut AS estrut_mae,
            p.c60_estrut AS estrut,
            c61_reduz,
            c61_codcon,
            o15_codtri,
            p.c60_descr,
            p.c60_finali,
            r.c61_instit, fc_planosaldonovo(2018,c61_reduz,'2018-01-01','2018-12-31',FALSE),
            p.c60_identificadorfinanceiro,
            c60_consistemaconta
     FROM conplanoexe e
     INNER JOIN conplanoreduz r ON r.c61_anousu = c62_anousu
     AND r.c61_reduz = c62_reduz
     INNER JOIN conplano p ON r.c61_codcon = c60_codcon
     AND r.c61_anousu = c60_anousu
     INNER JOIN orctiporec ON o15_codigo = r.c61_codigo
     LEFT OUTER JOIN consistema ON c60_codsis = c52_codsis
     WHERE c62_anousu = $anousu
         AND c61_instit IN ($xinstit)
         AND o15_codtri::INT = $fonte
         AND o15_codtri != ''
         AND (p.c60_estrut LIKE '$estrut_inicial2%') ) AS x";

    $result = db_query($sql);
//    echo $sql; db_criatabela($result);
    for($i = 0; $i < pg_numrows($result); $i++) {
        db_fieldsmemory($result,$i);

        if ($sinal_final == "C")
            $saldo_final *= -1;

        $tot_2188 = "tot_2188".$o15_codtri;
        $$tot_2188 += $saldo_final;

        if($sinal_final == "D"){
            $$tot_2188 == 0;
        }
    }

    $sSql = "SELECT
       o15_codtri,
       round(substr(fc_planosaldonovo,45,14)::float8,2)::float8 AS saldo_final,
       substr(fc_planosaldonovo,60,1)::varchar(1) AS sinal_final
     FROM
    (SELECT p.c60_estrut AS estrut_mae,
            p.c60_estrut AS estrut,
            c61_reduz,
            c61_codcon,
            o15_codtri,
            p.c60_descr,
            p.c60_finali,
            r.c61_instit, fc_planosaldonovo(2018,c61_reduz,'2018-01-01','2018-12-31',FALSE),
            p.c60_identificadorfinanceiro,
            c60_consistemaconta
     FROM conplanoexe e
     INNER JOIN conplanoreduz r ON r.c61_anousu = c62_anousu
     AND r.c61_reduz = c62_reduz
     INNER JOIN conplano p ON r.c61_codcon = c60_codcon
     AND r.c61_anousu = c60_anousu
     INNER JOIN orctiporec ON o15_codigo = r.c61_codigo
     LEFT OUTER JOIN consistema ON c60_codsis = c52_codsis
     WHERE c62_anousu = $anousu
         AND c61_instit IN ($xinstit)
         AND o15_codtri::INT = $fonte
         AND o15_codtri != ''
         AND (p.c60_estrut LIKE '$estrut_inicial3%') ) AS x";

    $result = db_query($sSql);
//    echo $sql; db_criatabela($result);
    for($i = 0; $i < pg_numrows($result); $i++) {
        db_fieldsmemory($result,$i);
        if ($sinal_final == "C")
            $saldo_final *= -1;
        $tot_1138 = "tot_1138".$o15_codtri;
        $$tot_1138 += $saldo_final;
        if($sinal_final == "D"){
            $$nomeVariavel == 0;
        }
    }
}

$tot_demaisobg100 = $tot_2188100 + $tot_1138100;
$tot_demaisobg100 < 0 ? $tot_demaisobg100 *= -1 : $tot_demaisobg100;
$tot_demaisobg101 = $tot_2188101 + $tot_1138101;
$tot_demaisobg101 < 0 ? $tot_demaisobg101 *= -1 : $tot_demaisobg101;
$tot_demaisobg118 = $tot_2188118 + $tot_1138118;
$tot_demaisobg118 < 0 ? $tot_demaisobg118 *= -1 : $tot_demaisobg118;
$tot_demaisobg119 = $tot_2188119 + $tot_1138119;
$tot_demaisobg119 < 0 ? $tot_demaisobg119 *= -1 : $tot_demaisobg119;
//inicio destinado a educação
$tot_demaisobg113 = $tot_2188113 + $tot_1138113;
$tot_demaisobg113 < 0 ? $tot_demaisobg113 *= -1 : $tot_demaisobg113;
$tot_demaisobg122 = $tot_2188122 + $tot_1138122;
$tot_demaisobg122 < 0 ? $tot_demaisobg122 *= -1 : $tot_demaisobg122;
$tot_demaisobg143 = $tot_2188143 + $tot_1138143;
$tot_demaisobg143 < 0 ? $tot_demaisobg143 *= -1 : $tot_demaisobg143;
$tot_demaisobg144 = $tot_2188144 + $tot_1138144;
$tot_demaisobg144 < 0 ? $tot_demaisobg144 *= -1 : $tot_demaisobg144;
$tot_demaisobg145 = $tot_2188145 + $tot_1138145;
$tot_demaisobg145 < 0 ? $tot_demaisobg145 *= -1 : $tot_demaisobg145;
$tot_demaisobg146 = $tot_2188146 + $tot_1138146;
$tot_demaisobg146 < 0 ? $tot_demaisobg146 *= -1 : $tot_demaisobg146;
$tot_demaisobg147 = $tot_2188147 + $tot_1138147;
$tot_demaisobg147 < 0 ? $tot_demaisobg147 *= -1 : $tot_demaisobg147;
//fim destinado a educação
$tot_demaisobg102 = $tot_2188102 + $tot_1138102;
$tot_demaisobg102 < 0 ? $tot_demaisobg102 *= -1 : $tot_demaisobg102;
//inicio destinado a saude
$tot_demaisobg112 = $tot_2188112 + $tot_1138112;
$tot_demaisobg112 < 0 ? $tot_demaisobg112 *= -1 : $tot_demaisobg112;
$tot_demaisobg123 = $tot_2188123 + $tot_1138123;
$tot_demaisobg123 < 0 ? $tot_demaisobg123 *= -1 : $tot_demaisobg123;
$tot_demaisobg148 = $tot_2188148 + $tot_1138148;
$tot_demaisobg148 < 0 ? $tot_demaisobg148 *= -1 : $tot_demaisobg148;
$tot_demaisobg149 = $tot_2188149 + $tot_1138149;
$tot_demaisobg148 < 0 ? $tot_demaisobg148 *= -1 : $tot_demaisobg148;
$tot_demaisobg150 = $tot_2188150 + $tot_1138150;
$tot_demaisobg150 < 0 ? $tot_demaisobg150 *= -1 : $tot_demaisobg150;
$tot_demaisobg151 = $tot_2188151 + $tot_1138151;
$tot_demaisobg151 < 0 ? $tot_demaisobg151 *= -1 : $tot_demaisobg151;
$tot_demaisobg152 = $tot_2188152 + $tot_1138152;
$tot_demaisobg152 < 0 ? $tot_demaisobg152 *= -1 : $tot_demaisobg152;
$tot_demaisobg153 = $tot_2188153 + $tot_1138153;
$tot_demaisobg153 < 0 ? $tot_demaisobg153 *= -1 : $tot_demaisobg153;
$tot_demaisobg154 = $tot_2188154 + $tot_1138154;
$tot_demaisobg154 < 0 ? $tot_demaisobg154 *= -1 : $tot_demaisobg154;
//fim destinado a saude
//inicio destinado a assistencia social
$tot_demaisobg156 = $tot_2188159 + $tot_1138159;
$tot_demaisobg156 < 0 ? $tot_demaisobg156 *= -1 : $tot_demaisobg156;
$tot_demaisobg129 = $tot_2188129 + $tot_1138129;
$tot_demaisobg129 < 0 ? $tot_demaisobg129 *= -1 : $tot_demaisobg129;
//fim destinado a assistencia social
$tot_demaisobg103 = $tot_2188103 + $tot_1138103;
$tot_demaisobg103 < 0 ? $tot_demaisobg103 *= -1 : $tot_demaisobg103;
$tot_demaisobg190 = $tot_2188190 + $tot_1138190;
$tot_demaisobg190 < 0 ? $tot_demaisobg190 *= -1 : $tot_demaisobg190;
$tot_demaisobg191 = $tot_2188191 + $tot_1138191;
$tot_demaisobg191 < 0 ? $tot_demaisobg191 *= -1 : $tot_demaisobg191;
$tot_demaisobg192 = $tot_2188192 + $tot_1138192;
$tot_demaisobg192 < 0 ? $tot_demaisobg192 *= -1 : $tot_demaisobg192;
//inicio outras destinações
$tot_demaisobg116 = $tot_2188116 + $tot_1138116;
$tot_demaisobg116 < 0 ? $tot_demaisobg116 *= -1 : $tot_demaisobg116;
$tot_demaisobg117 = $tot_2188117 + $tot_1138117;
$tot_demaisobg117 < 0 ? $tot_demaisobg117 *= -1 : $tot_demaisobg117;
$tot_demaisobg124 = $tot_2188124 + $tot_1138124;
$tot_demaisobg124 < 0 ? $tot_demaisobg124 *= -1 : $tot_demaisobg124;
$tot_demaisobg142 = $tot_2188142 + $tot_1138142;
$tot_demaisobg142 < 0 ? $tot_demaisobg142 *= -1 : $tot_demaisobg142;
$tot_demaisobg157 = $tot_2188157 + $tot_1138157;
$tot_demaisobg157 < 0 ? $tot_demaisobg157 *= -1 : $tot_demaisobg157;
$tot_demaisobg158 = $tot_2188158 + $tot_1138158;
$tot_demaisobg158 < 0 ? $tot_demaisobg158 *= -1 : $tot_demaisobg158;
//fim outras destinações

///////////////////////////////////////*disponibilidade de caixa (a)*///////////////////////////////////////////////////////
$tot_saldo_educacao         = $tot_saldo113 + $tot_saldo122 + $tot_saldo143 + $tot_saldo144 + $tot_saldo145 + $tot_saldo146 +
                              $tot_saldo147;
$tot_saldo_saude            = $tot_saldo112 + $tot_saldo123 + $tot_saldo148 + $tot_saldo149 + $tot_saldo150 + $tot_saldo151 +
                              $tot_saldo152 + $tot_saldo153 + $tot_saldo154 + $tot_saldo155;
$tot_saldo_associal         = $tot_saldo156 + $tot_saldo129;
$tot_saldo_opcredexetosaude = $tot_saldo190 + $tot_saldo191;
$tot_saldo_outrosdestinados = $tot_saldo116 + $tot_saldo117 + $tot_saldo124 + $tot_saldo142 + $tot_saldo157 + $tot_saldo158;
$tot_total_de_recursos      = $tot_saldo101 + $tot_saldo118 + $tot_saldo119 + $tot_saldo_educacao +
                              $tot_saldo102 + $tot_saldo_saude + $tot_saldo_associal + $tot_saldo103 +
                              $tot_saldo_opcredexetosaude + $tot_saldo192 + $tot_saldo_outrosdestinados;

//////////////////////////////////////*fim disponibilidade de caixa*////////////////////////////////////////////////////
//////////////////////////////////////*liquidados não pagos anos anteriores (b)*////////////////////////////////////////////
$tot_educacao_liquidadosNP  = $total113 + $total122 + $total143 + $total144 + $total145 + $total146 + $total147;
$tot_saude_liquidadosNP     = $total112 + $total123 + $total148 + $total149 + $total150 + $total151 + $total152 +
                              $total153 + $total154 + $total155;
$tot_associal_liquidadoNP   = $total156 + $total129;
$tot_opcredexetosaude_liqNP = $total190 + $total191;
$tot_recursoslicNP          = $total116 + $total117 + $total124 + $total142 + $total157 + $total158;
$total_de_liquidadosNP      = $total101 + $total118 + $total119 + $tot_educacao_liquidadosNP +
                              $total102 + $tot_associal_liquidadoNP + $tot_saude_liquidadosNP + $total103 +
                              $tot_opcredexetosaude_liqNP + $total192 + $tot_recursoslicNP;
////////////////////////////////////*fim liquidados nao pagos anos anteriores*//////////////////////////////////////////
////////////////////////////////////*liquidados e nao pagos do exercicio*///////////////////////////////////////////////
$tot_educ_liqnoexercicio             = $tot_liqAPG113 + $tot_liqAPG122 + $tot_liqAPG143 + $tot_liqAPG144 + $tot_liqAPG145 +
                                       $tot_liqAPG146 + $tot_liqAPG147;
$tot_saude_liqnoexercicio            = $tot_liqAPG112 + $tot_liqAPG123 + $tot_liqAPG148 + $tot_liqAPG149 + $tot_liqAPG150 +
                                       $tot_liqAPG151 + $tot_liqAPG152 + $tot_liqAPG153 + $tot_liqAPG154 + $tot_liqAPG155;
$tot_associal_liqnoexercicio         = $tot_liqAPG156 + $tot_liqAPG129;
$tot_opcredexetosaude_liqnoexercicio = $tot_liqAPG190 + $tot_liqAPG191;
$tot_recursosliqnoexercicio          = $tot_liqAPG116 + $tot_liqAPG117 + $tot_liqAPG124 + $tot_liqAPG142 + $tot_liqAPG157 + $tot_liqAPG158;
$total_de_liqnoexercicio             = $tot_liqAPG101 + $tot_liqAPG118 + $tot_liqAPG119 + $tot_educ_liqnoexercicio +
                                       $tot_liqAPG102 + $tot_associal_liqnoexercicio + $tot_saude_liqnoexercicio + $tot_liqAPG103 +
                                       $tot_opcredexetosaude_liqnoexercicio + $tot_liqAPG192 + $tot_recursosliqnoexercicio;
////////////////////////////////////*fim liquidados e nao pagos do exercicio*///////////////////////////////////////////
////////////////////////////////////*Restos a Pagar Empenhados e Não Liquidados de Exercícios Anteriores (d)*///////////
$tot_educ_NP             = $totalNP113 + $totalNP122 + $totalNP143 + $totalNP144 + $totalNP145 +
                           $totalNP146 + $totalNP147;
$tot_saude_NP            = $totalNP112 + $totalNP123 + $totalNP148 + $totalNP149 + $totalNP150 +
                           $totalNP151 + $totalNP152 + $totalNP153 + $totalNP154 + $totalNP155;
$tot_associal_NP         = $totalNP156 + $totalNP129;
$tot_opcredexetosaude_NP = $totalNP190 + $totalNP191;
$tot_recursosNP          = $totalNP116 + $totalNP117 + $totalNP124 + $totalNP142 + $totalNP157 + $totalNP158;
$total_de_NP             = $totalNP101 + $totalNP118 + $totalNP119 + $tot_educ_NP +
                           $totalNP102 + $tot_associal_NP + $tot_saude_NP + $totalNP103 +
                           $tot_opcredexetosaude_NP + $totalNP192 + $tot_recursosNP;
///////////////////////////////////*fim liquidados e nao pagos do exercicio*////////////////////////////////////////////
///////////////////////////////////*Não liquidados e nao pagos do exercicio*////////////////////////////////////////////
$tot_educ_aliqnoexercicio             = $tot_aliq113 + $tot_aliq122 + $tot_aliq143 + $tot_aliq144 + $tot_aliq145 +
                                        $tot_aliq146 + $tot_aliq147;
$tot_saude_aliqnoexercicio            = $tot_aliq112 + $tot_aliq123 + $tot_aliq148 + $tot_aliq149 + $tot_aliq150 +
                                        $tot_aliq151 + $tot_aliq152 + $tot_aliq153 + $tot_aliq154 + $tot_aliq155;
$tot_associal_aliqnoexercicio         = $tot_aliq156 + $tot_aliq129;
$tot_opcredexetosaude_aliqnoexercicio = $tot_aliq190 + $tot_aliq191;
$tot_recursosaliqnoexercicio          = $tot_aliq142 + $tot_aliq116 + $tot_aliq117 + $tot_aliq124 + $tot_aliq157 + $tot_aliq158;
$total_de_aliqnoexercicio             = $tot_aliq101 + $tot_aliq118 + $tot_aliq119 + $tot_educ_aliqnoexercicio +
                                        $tot_aliq102 + $tot_associal_aliqnoexercicio + $tot_saude_aliqnoexercicio + $tot_aliq103 +
                                        $tot_opcredexetosaude_aliqnoexercicio + $tot_aliq192 + $tot_recursosaliqnoexercicio;
/////////////////////////////////////*fim liquidados e nao pagos do exercicio*//////////////////////////////////////////
/////////////////////////////////////*disponibilidade de caixa estrutural 2188*/////////////////////////////////////////
$tot_demaisobg_educacao         = $tot_demaisobg113 + $tot_demaisobg122 + $tot_demaisobg143 + $tot_demaisobg144 +
                                  $tot_demaisobg145 + $tot_demaisobg146 + $tot_demaisobg147;
$tot_demaisobg_saude            = $tot_demaisobg112 + $tot_demaisobg123 + $tot_demaisobg148 + $tot_demaisobg149 +
                                  $tot_demaisobg150 + $tot_demaisobg151 + $tot_demaisobg152 + $tot_demaisobg153 +
                                  $tot_demaisobg154 + $tot_demaisobg155;
$tot_demaisobg_associal         = $tot_demaisobg156 + $tot_demaisobg129;
$tot_demaisobg_opcredexetosaude = $tot_demaisobg190 + $tot_demaisobg191;
$tot_demaisobg_outrosdestinados = $tot_demaisobg116 + $tot_demaisobg117 + $tot_demaisobg124 + $tot_demaisobg142 +
                                  $tot_demaisobg157 + $tot_demaisobg158;
$tot_demaisobg                  = $tot_demaisobg101 + $tot_demaisobg118 + $tot_demaisobg119 + $tot_demaisobg_educacao +
                                  $tot_demaisobg102 + $tot_demaisobg_saude + $tot_demaisobg_associal + $tot_demaisobg103 +
                                  $tot_demaisobg_opcredexetosaude + $tot_demaisobg192 + $tot_demaisobg_outrosdestinados;
///////////////////////////////*fim disponibilidade de caixa 2188*//////////////////////////////////////////////////////
///////////////////////////////*empenhos nao liquidados cancelados InsuFinan*///////////////////////////////////////////
$tot_empcanceleducao         = $tot_empcancel113 + $tot_empcancel122 + $tot_empcancel143 + $tot_empcancel144 +
                               $tot_empcancel145 + $tot_empcancel146 + $tot_empcancel147;
$tot_empcancelsaude          = $tot_empcancel112 + $tot_empcancel123 + $tot_empcancel148 + $tot_empcancel149 +
                               $tot_empcancel150 + $tot_empcancel151 + $tot_empcancel152 + $tot_empcancel153 +
                               $tot_empcancel154 + $tot_empcancel155;
$tot_empcancelassocial       = $tot_empcancel156 + $tot_empcancel129;
$tot_empdemaisobgcancel      = $tot_empcancel190 + $tot_empcancel191;
$tot_outrosdestinadoscancel  = $tot_empcancel116 + $tot_empcancel117 + $tot_empcancel124 + $tot_empcancel142 +
                               $tot_empcancel157 + $tot_empcancel158;
$tot_demaisobginsuf          = $tot_empcancel101 + $tot_empcancel118 + $tot_empcancel119 + $tot_empcanceleducao +
                               $tot_empcancel102 + $tot_empcancelsaude + $tot_empcancelassocial + $tot_empcancel103 +
                               $tot_empdemaisobgcancel + $tot_empcancel192 + $tot_outrosdestinadoscancel;
/////////////////////////////////*fim empenhos nao liquidados cancelados*///////////////////////////////////////////////
/////////////////////////////////*Aqui e criado o valores totais utilizando a formula (g)=(a-(b+c+d+e)-f)*//////////////
/**
    Busca os parametros do relatorio por ano
 */
$sql = "select * from parametrosrelatoriosiconf where c222_anousu = $anousu";
$result = db_query($sql);
if($result > 0){
    db_fieldsmemory($result, 0);
}
$total_NV = $c222_recimpostostranseduc + $c222_transfundeb60 + $c222_transfundeb40 + $c222_recdestinadoeduc + $c222_recimpostostranssaude +
            $c222_recdestinadosaude + $c222_recdestinadoassist + $c222_recdestinadoassist + $c222_recdestinadorppspp + $c222_recopcreditoexsaudeeduc +
            $c222_recavaliacaodebens + $c222_outrasdestinacoes + $c222_recordinarios;
$total_vinculado = $tot_total_de_recursos - ($total_de_liquidadosNP + $total_de_liqnoexercicio + $total_de_NP + $tot_demaisobg) - 0;
$total_receitaseducacao = $tot_saldo101 - ($tot_demaisobg101 + $total101 + $tot_liqAPG101 + $totalNP101) - $c222_recimpostostranseduc;
$total_transfundeb60 = $tot_saldo118 - ($total118 + $tot_liqAPG118 + $totalNP118 + $tot_demaisobg118) - $c222_transfundeb60;
$total_transfundeb40 = $tot_saldo119 - ($total119 + $tot_liqAPG119 + $totalNP119 + $tot_demaisobg119) - $c222_transfundeb40;
$total_outroseducacao= $tot_saldo_educacao - ($tot_educacao_liquidadosNP + $tot_educ_liqnoexercicio + $tot_educ_NP + $tot_demaisobg_educacao) - $c222_recdestinadoeduc;
$total_transsaude    = $tot_saldo102 - ($total102 + $tot_liqAPG102 + $totalNP102 + $tot_demaisobg102) - $c222_recimpostostranssaude;
$total_outrossaude   = $tot_saldo_saude - ($tot_saude_liquidadosNP + $tot_saude_liqnoexercicio + $tot_saude_NP + $tot_demaisobg_saude) - $c222_recdestinadosaude;
$total_assissocial   = $tot_saldo_associal - ($tot_associal_liquidadoNP + $tot_associal_liqnoexercicio + $tot_associal_NP + $tot_demaisobg_associal) - $c222_recdestinadoassist;
$total_destRPPS      = $tot_saldo103 - ($total103 + $tot_liqAPG103 + $totalNP103 + $tot_demaisobg103) - $c222_recdestinadorppspp;
$total_exetosaudeeduc= $tot_saldo_opcredexetosaude - ($tot_opcredexetosaude_liqNP + $tot_opcredexetosaude_liqnoexercicio + $tot_opcredexetosaude_NP + $tot_demaisobg_opcredexetosaude) - $c222_recopcreditoexsaudeeduc;
$total_alienacaobens = $tot_saldo192 - ($total192 + $tot_liqAPG192 + $totalNP192 + $tot_demaisobg192) - $c222_recavaliacaodebens;
$total_outrasdestina = $tot_saldo_outrosdestinados - ($tot_recursoslicNP + $tot_recursosliqnoexercicio + $tot_recursosNP + $tot_demaisobg_outrosdestinados) - $c222_outrasdestinacoes;
$total_recursosordina= $tot_saldo100 - ($total100 + $tot_liqAPG100 + $totalNP100 + $tot_demaisobg100) - $c222_recordinarios;
//////////////////////////////////////*TOTAL DOS RECURSOS NÂO VINCULADOS*///////////////////////////////////////////////
//////////////////////////////////////*TOTAL DOS RECURSOS NÂO VINCULADOS*///////////////////////////////////////////////
//////////////////////////////////////*TOTAL FINAL*/////////////////////////////////////////////////////////////////////
$tot_a =  $tot_saldo100 + $tot_total_de_recursos;
$tot_b =  $total100 + $total_de_liquidadosNP;
$tot_c =  $tot_liqAPG100 + $total_de_liqnoexercicio;
$tot_d =  $totalNP100 + $total_de_NP;
$tot_e =  $tot_demaisobg100 + $tot_demaisobg;
$tot_f =  $total_NV + $c222_recordinarios;
$tot_g =  $total_recursosordina + $total_vinculado;
$tot_h =  $tot_aliq100 + $total_de_aliqnoexercicio;
$tot_i =  $tot_empcancel100 + $tot_demaisobginsuf;
//////////////////////////////////////*TOTAL FINAL*/////////////////////////////////////////////////////////////////////
$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->setfillcolor(235);
$pdf->setfont('arial','B',7);
$alt            = 4;
$pagina         = 1;
$cl = 16;
$tp = 'B';
$ta ='TBRL';

$perinic = "01-01-".$anousu;
$perfim = "31-12-".$anousu;

$head1 = "RELATÓRIO DE GESTÃO FISCAL";
$head2 = "DEMONSTRATIVO DA DISPONIBILIDADE DE CAIXA E DOS RESTOS A PAGAR";
$head3 = "ORÇAMENTOS FISCAL E DA SEGURIDADE SOCIAL";
$head4 = "Janeiro à Dezembro de ".$anousu;
$head5 = "RGF - ANEXO 5 (LRF, art. 55, Inciso III, alínea a)";

$pdf->addpage("L");
$pdf->cell(33 ,35,"Disponibilidade de Caixa"         ,1,0,"C",1,"");
$pdf->cell(246,7,"Disponibilidade de Caixa"          ,1,1,"C",1,"");
$pdf->x = 63;
$pdf->cell(100,5,"OBRIGAÇÕES FINANCEIRAS",1,1,"C",1,"");
$pdf->x = 43;
$pdf->y = 42;
$pdf->MultiCell(20 ,9.4,"DISPONIB. DE CAIXA BRUTA (a)",1,"C",1,0);
$pdf->x = 63;
$pdf->y = 47;
$pdf->cell(50 ,8,"Restos a Pagar Liquidados e Não Pagos",1,0,"C",1,"");
$pdf->x = 113;
$pdf->MultiCell(22 ,4.6,"Resto a pagar Empenhados e não liquidados de anos anteriores",1,"C",1,0);
$pdf->x = 135;
$pdf->y = 47;
$pdf->MultiCell(22 ,7.7,"Demais Obrigações financeiras",1,"C",1,0);
$pdf->x = 157;
$pdf->y = 42;
$pdf->MultiCell(25 ,5.6,"INSUFICIÊNCIA FINANCEIRA VERIFICADA NO CONSÓRCIO PÚBLICO (f)",1,"C",1,0);
$pdf->x = 182;
$pdf->y = 42;
$pdf->MultiCell(40 ,4.67,"DISPONIBILIDADE DE CAIXA LÍQUIDA (ANTES DA INSCRIÇÃO EM RESTOS A PAGAR NÃO PROCESSADOS DO EXERCÍCIO) (g)=(a-(b+c+d+e)-f)",1,"C",1,0);
$pdf->x = 222;
$pdf->y = 42;
$pdf->MultiCell(33 ,7,"RESTOS A PAGAR EMPENHADOS E NÃO LIQUIDADOS DO EXERCÍCIO (h)",1,"C",1,0);
$pdf->x = 255;
$pdf->y = 42;
$pdf->MultiCell(34 ,4.69,"EMPENHOS NÃO LIQUIDADOS CANCELADOS (NÃO INSCRITOS POR INSUFICIÊNCIA FINANCEIRA) (i)",1,"C",1,0);
$pdf->x = 63;
$pdf->y = 55;
$pdf->MultiCell(25 ,7.6,"De Exercícios Anteriores (b)",1,"C",1,0);
$pdf->x = 88;
$pdf->y = 55;
$pdf->MultiCell(25 ,15.2,"Do Exercício (c)",1,"C",1,0);

/*inicio da linha recursos vinculados*/
$pdf->MultiCell(33 ,5,"TOTAL DOS RECURSOS VINCULADOS",1,"C",0,0);
$pdf->x = 43;
$pdf->y = 70;
$pdf->cell(20 ,10.2,db_formatar($tot_total_de_recursos,"f"),1,0,"C",0,"");
$pdf->x = 63;
$pdf->cell(25 ,10.2,db_formatar($total_de_liquidadosNP,"f"),1,0,"C",0,"");
$pdf->x = 88;
$pdf->cell(25 ,10.2,db_formatar($total_de_liqnoexercicio,"f"),1,0,"C",0,"");
$pdf->x = 113;
$pdf->cell(22 ,10.2,db_formatar($total_de_NP,"f"),1,0,"C",0,"");
$pdf->x = 135;
$pdf->cell(22 ,10.2,db_formatar($tot_demaisobg > 0 ? 0 : $tot_demaisobg,"f"),1,0,"C",0,"");
$pdf->x = 157;
$pdf->cell(25 ,10.2,db_formatar($total_NV,"f"),1,0,"C",0,"");
$pdf->x = 182;
$pdf->cell(40 ,10.2,db_formatar($total_vinculado,"f"),1,0,"C",0,"");
$pdf->x = 222;
$pdf->x = 222;
$pdf->cell(33 ,10.2,db_formatar($total_de_aliqnoexercicio,"f"),1,0,"C",0,"");
$pdf->x = 255;
$pdf->cell(34 ,10.2,db_formatar($tot_demaisobginsuf > 0 ? 0 : $tot_demaisobginsuf,"f"),1,1,"C",0,"");
/*fim da linha*/

$pdf->setfont('arial','',7);
/*inicio da linha Receitas de Impostos*/
$pdf->MultiCell(33 ,2.6,"Receitas de Impostos e de Transferência de Impostos-Educação","LTRB","C",0,0);
$pdf->x = 43;
$pdf->y = 80;
$pdf->cell(20 ,8,db_formatar($tot_saldo101,"f"),"LR",0,"C",0,"");
$pdf->x = 63;
$pdf->cell(25 ,8,db_formatar(abs($total101),"f"),"LR",0,"C",0,"");
$pdf->x = 88;
$pdf->cell(25 ,8,db_formatar($tot_liqAPG101,"f"),"LR",0,"C",0,"");
$pdf->cell(22 ,8,db_formatar($totalNP101,"f"),"LR",0,"C",0,"");
$pdf->cell(22 ,8,db_formatar($tot_demaisobg101 > 0 ? 0 : $tot_demaisobg101,"f"),"LR",0,"C",0,"");
$pdf->cell(25 ,8,db_formatar($c222_recimpostostranseduc,"f"),"LR",0,"C",0,"");
$pdf->cell(40 ,8,db_formatar($total_receitaseducacao,"f"),"LR",0,"C",0,"");
$pdf->cell(33 ,8,db_formatar($tot_aliq101,"f"),"LR",0,"C",0,"");
$pdf->cell(34 ,8,db_formatar($tot_empcancel101,"f"),"LR",1,"C",0,"");
/*fim da linha*/

/*inicio da linha transferencai do fundeb 60%*/
$pdf->MultiCell(33 ,4,"Transferencia do FUNDEB 60%","LTRB","C",0,0);
$pdf->x = 43;
$pdf->y = 88;
$pdf->cell(20 ,8,db_formatar($tot_saldo118,"f"),"LTRB",0,"C",0,"");
$pdf->x = 63;
$pdf->cell(25 ,8,db_formatar($total118,"f"),"LTRB",0,"C",0,"");
$pdf->x = 88;
$pdf->cell(25 ,8,db_formatar($tot_liqAPG118,"f"),"LTRB",0,"C",0,"");
$pdf->cell(22 ,8,db_formatar($totalNP118,"f"),"LTRB",0,"C",0,"");
$pdf->cell(22 ,8,db_formatar($tot_demaisobg118 > 0 ? 0 : $tot_demaisobg118,"f"),"LTRB",0,"C",0,"");
$pdf->cell(25 ,8,db_formatar($c222_transfundeb60,"f"),"LTRB",0,"C",0,"");
$pdf->cell(40 ,8,db_formatar($total_transfundeb60,"f"),"LTRB",0,"C",0,"");
$pdf->cell(33 ,8,db_formatar($tot_aliq118,"f"),"LTRB",0,"C",0,"");
$pdf->cell(34 ,8,db_formatar($tot_empcancel118,"f"),"LTRB",1,"C",0,"");
/*fim da linha*/

/*inicio da linha transferencai do fundeb 40%*/
$pdf->MultiCell(33 ,4,"Transferencia do FUNDEB 40%","LTRB","C",0,0);
$pdf->x = 43;
$pdf->y = 96;
$pdf->cell(20 ,8,db_formatar($tot_saldo119,"f"),"LTRB",0,"C",0,"");
$pdf->x = 63;
$pdf->cell(25 ,8,db_formatar($total119,"f"),"LTRB",0,"C",0,"");
$pdf->x = 88;
$pdf->cell(25 ,8,db_formatar($tot_liqAPG119,"f"),"LTRB",0,"C",0,"");
$pdf->cell(22 ,8,db_formatar($totalNP119,"f"),"LTRB",0,"C",0,"");
$pdf->cell(22 ,8,db_formatar($tot_demaisobg119 > 0 ? 0 : $tot_demaisobg119,"f"),"LTRB",0,"C",0,"");
$pdf->cell(25 ,8,db_formatar($c222_transfundeb40,"f"),"LTRB",0,"C",0,"");
$pdf->cell(40 ,8,db_formatar($total_transfundeb40,"f"),"LTRB",0,"C",0,"");
$pdf->cell(33 ,8,db_formatar($tot_aliq119,"f"),"LTRB",0,"C",0,"");
$pdf->cell(34 ,8,db_formatar($tot_empcancel119,"f"),"LTRB",1,"C",0,"");
/*fim da linha*/

/*inicio da linha Outros Recursos Destinados à Educação*/
$pdf->MultiCell(33 ,4,"Outros Recursos Destinados à Educação","LTRB","C",0,0);
$pdf->x = 43;
$pdf->y = 104;
$pdf->cell(20 ,8,db_formatar($tot_saldo_educacao,"f"),1,0,"C",0,"");
$pdf->x = 63;
$pdf->cell(25 ,8,db_formatar(abs($tot_educacao_liquidadosNP),"f"),1,0,"C",0,"");
$pdf->x = 88;
$pdf->cell(25 ,8,db_formatar($tot_educ_liqnoexercicio,"f"),1,0,"C",0,"");
$pdf->cell(22 ,8,db_formatar($tot_educ_NP,"f"),1,0,"C",0,"");
$pdf->cell(22 ,8,db_formatar($tot_demaisobg_educacao > 0 ? 0 : $tot_demaisobg_educacao,"f"),1,0,"C",0,"");
$pdf->cell(25 ,8,db_formatar($c222_recdestinadoeduc,"f"),1,0,"C",0,"");
$pdf->cell(40 ,8,db_formatar($total_outroseducacao,"f"),1,0,"C",0,"");
$pdf->cell(33 ,8,db_formatar($tot_educ_aliqnoexercicio,"f"),1,0,"C",0,"");
$pdf->cell(34 ,8,db_formatar($tot_empcanceleducao,"f"),1,1,"C",0,"");
/*fim da linha*/

/*inicio da linha Receitas de Impostos e de Transferência de Impostos - Saúde*/
$pdf->MultiCell(33 ,2.7,"Receitas de Impostos e de Transferência de Impostos-Saúde","LTRB","C",0,0);
$pdf->x = 43;
$pdf->y = 112;
$pdf->cell(20 ,8,db_formatar($tot_saldo102,"f"),1,0,"C",0,"");
$pdf->x = 63;
$pdf->cell(25 ,8,db_formatar($total102,"f"),1,0,"C",0,"");
$pdf->x = 88;
$pdf->cell(25 ,8,db_formatar($tot_liqAPG102,"f"),1,0,"C",0,"");
$pdf->cell(22 ,8,db_formatar($totalNP102,"f"),1,0,"C",0,"");
$pdf->cell(22 ,8,db_formatar($tot_demaisobg102 > 0 ? 0 : $tot_demaisobg102,"f"),1,0,"C",0,"");
$pdf->cell(25 ,8,db_formatar($c222_recimpostostranssaude,"f"),1,0,"C",0,"");
$pdf->cell(40 ,8,db_formatar($total_transsaude,"f"),1,0,"C",0,"");
$pdf->cell(33 ,8,db_formatar($tot_aliq102,"f"),1,0,"C",0,"");
$pdf->cell(34 ,8,db_formatar($tot_empcancel102,"f"),1,1,"C",0,"");
/*fim da linha*/

/*inicio da linha Outros recursos destinados a saude*/
$pdf->MultiCell(33 ,4,"Outros recursos destinados a saude","LTRB","C",0,0);
$pdf->x = 43;
$pdf->y = 120;
$pdf->cell(20 ,8,db_formatar($tot_saldo_saude,"f"),1,0,"C",0,"");
$pdf->x = 63;
$pdf->cell(25 ,8,db_formatar($tot_saude_liquidadosNP,"f"),1,0,"C",0,"");
$pdf->x = 88;
$pdf->cell(25 ,8,db_formatar($tot_saude_liqnoexercicio,"f"),1,0,"C",0,"");
$pdf->cell(22 ,8,db_formatar($tot_saude_NP,"f"),1,0,"C",0,"");
$pdf->cell(22 ,8,db_formatar($tot_demaisobg_saude > 0 ? 0 : $tot_demaisobg_saude,"f"),1,0,"C",0,"");
$pdf->cell(25 ,8,db_formatar($c222_recdestinadosaude,"f"),1,0,"C",0,"");
$pdf->cell(40 ,8,db_formatar($total_outrossaude,"f"),1,0,"C",0,"");
$pdf->cell(33 ,8,db_formatar($tot_saude_aliqnoexercicio,"f"),1,0,"C",0,"");
$pdf->cell(34 ,8,db_formatar($tot_empcancelsaude,"f"),1,1,"C",0,"");
/*fim da linha*/

/*Outros recursos destinados a saude*/
$pdf->MultiCell(33 ,4,"Recursos Destinados à Assistência Social","LTRB","C",0,0);
$pdf->x = 43;
$pdf->y = 128;
$pdf->cell(20 ,8,db_formatar($tot_saldo_associal,"f"),1,0,"C",0,"");
$pdf->x = 63;
$pdf->cell(25 ,8,db_formatar($tot_associal_liquidadoNP,"f"),1,0,"C",0,"");
$pdf->x = 88;
$pdf->cell(25 ,8,db_formatar($tot_associal_liqnoexercicio,"f"),1,0,"C",0,"");
$pdf->cell(22 ,8,db_formatar($tot_associal_NP,"f"),1,0,"C",0,"");
$pdf->cell(22 ,8,db_formatar($tot_demaisobg_associal > 0 ? 0 : $tot_demaisobg_associal,"f"),1,0,"C",0,"");
$pdf->cell(25 ,8,db_formatar($c222_recdestinadoassist,"f"),1,0,"C",0,"");
$pdf->cell(40 ,8,db_formatar($total_assissocial,"f"),1,0,"C",0,"");
$pdf->cell(33 ,8,db_formatar($tot_associal_aliqnoexercicio,"f"),1,0,"C",0,"");
$pdf->cell(34 ,8,db_formatar($tot_empcancelassocial,"f"),1,1,"C",0,"");
/*fim da linha*/

/*inicio da linha Recursos Destinados ao RPPS - Plano Previdenciário*/
$pdf->MultiCell(33 ,2.6,"Recursos Destinados ao RPPS - Plano Previdenciário","LTRB","C",0,0);
$pdf->x = 43;
$pdf->y = 136;
$pdf->cell(20 ,8,db_formatar($tot_saldo103,"f"),1,0,"C",0,"");
$pdf->x = 63;
$pdf->cell(25 ,8,db_formatar($total103,"f"),1,0,"C",0,"");
$pdf->x = 88;
$pdf->cell(25 ,8,db_formatar($tot_liqAPG103,"f"),1,0,"C",0,"");
$pdf->cell(22 ,8,db_formatar($totalNP103,"f"),1,0,"C",0,"");
$pdf->cell(22 ,8,db_formatar($tot_demaisobg103 > 0 ? 0 : $tot_demaisobg103,"f"),1,0,"C",0,"");
$pdf->cell(25 ,8,db_formatar($c222_recdestinadorppspp,"f"),1,0,"C",0,"");
$pdf->cell(40 ,8,db_formatar($total_destRPPS,"f"),1,0,"C",0,"");
$pdf->cell(33 ,8,db_formatar($tot_aliq103,"f"),1,0,"C",0,"");
$pdf->cell(34 ,8,db_formatar($tot_empcancel103,"f"),1,1,"C",0,"");
/*fim da linha*/

/*inicio da linha Recursos Destinados ao RPPS - Plano Financeiro*/
$pdf->MultiCell(33 ,3.9,"Recursos Destinados ao RPPS - Plano Financeiro","LTRB","C",0,0);
$pdf->x = 43;
$pdf->y = 144;
$pdf->cell(20 ,8,db_formatar(0,"f"),1,0,"C",0,"");
$pdf->x = 63;
$pdf->cell(25 ,8,db_formatar(0,"f"),1,0,"C",0,"");
$pdf->x = 88;
$pdf->cell(25 ,8,db_formatar(0,"f"),1,0,"C",0,"");
$pdf->cell(22 ,8,db_formatar(0,"f"),1,0,"C",0,"");
$pdf->cell(22 ,8,db_formatar(0,"f"),1,0,"C",0,"");
$pdf->cell(25 ,8,db_formatar(0,"f"),1,0,"C",0,"");
$pdf->cell(40 ,8,db_formatar(0,"f"),1,0,"C",0,"");
$pdf->cell(33 ,8,db_formatar(0,"f"),1,0,"C",0,"");
$pdf->cell(34 ,8,db_formatar(0,"f"),1,1,"C",0,"");
/*fim da linha*/

/*inicio da linha Recursos Destinados ao RPPS - Plano Financeiro*/
$pdf->MultiCell(33 ,2.7,"Recursos de Operações de Crédito (exceto destinados à Educação e à Saúde)","LTRB","C",0,0);
$pdf->x = 43;
$pdf->y = 152;
$pdf->cell(20 ,8,db_formatar($tot_saldo_opcredexetosaude,"f"),1,0,"C",0,"");
$pdf->x = 63;
$pdf->cell(25 ,8,db_formatar($tot_opcredexetosaude_liqNP,"f"),1,0,"C",0,"");
$pdf->x = 88;
$pdf->cell(25 ,8,db_formatar($tot_opcredexetosaude_liqnoexercicio,"f"),1,0,"C",0,"");
$pdf->cell(22 ,8,db_formatar($tot_opcredexetosaude_NP,"f"),1,0,"C",0,"");
$pdf->cell(22 ,8,db_formatar($tot_demaisobg_opcredexetosaude > 0 ? 0 : $tot_demaisobg_opcredexetosaude,"f"),1,0,"C",0,"");
$pdf->cell(25 ,8,db_formatar($c222_recopcreditoexsaudeeduc,"f"),1,0,"C",0,"");
$pdf->cell(40 ,8,db_formatar($total_exetosaudeeduc,"f"),1,0,"C",0,"");
$pdf->cell(33 ,8,db_formatar($tot_opcredexetosaude_aliqnoexercicio,"f"),1,0,"C",0,"");
$pdf->cell(34 ,8,db_formatar($tot_demaisobg_opcredexetosaude > 0 ? 0 : $tot_demaisobg_opcredexetosaude,"f"),1,1,"C",0,"");
/*fim da linha*/

/*inicio da linha Recursos Destinados ao RPPS - Plano Financeiro*/
$pdf->MultiCell(33 ,3.98,"Recursos de Alienação de Bens/Ativos","LTRB","C",0,0);
$pdf->x = 43;
$pdf->y = 160;
$pdf->cell(20 ,8,db_formatar($tot_saldo192,"f"),1,0,"C",0,"");
$pdf->x = 63;
$pdf->cell(25 ,8,db_formatar($total192,"f"),1,0,"C",0,"");
$pdf->x = 88;
$pdf->cell(25 ,8,db_formatar($tot_liqAPG192,"f"),1,0,"C",0,"");
$pdf->cell(22 ,8,db_formatar($totalNP192,"f"),1,0,"C",0,"");
$pdf->cell(22 ,8,db_formatar($tot_demaisobg192 > 0 ? 0 : $tot_demaisobg192,"f"),1,0,"C",0,"");
$pdf->cell(25 ,8,db_formatar($c222_recavaliacaodebens,"f"),1,0,"C",0,"");
$pdf->cell(40 ,8,db_formatar($total_alienacaobens,"f"),1,0,"C",0,"");
$pdf->cell(33 ,8,db_formatar($tot_aliq192,"f"),1,0,"C",0,"");
$pdf->cell(34 ,8,db_formatar($tot_empcancel192,"f"),1,1,"C",0,"");
/*fim da linha*/

//*inicio da linha Outras Destinações Vinculadas de Recursos */
$pdf->MultiCell(33 ,3.98,"Outras Destinações Vinculadas de Recursos ","LTRB","C",0,0);
$pdf->x = 43;
$pdf->y = 168;
$pdf->cell(20 ,8,db_formatar($tot_saldo_outrosdestinados,"f"),1,0,"C",0,"");
$pdf->x = 63;
$pdf->cell(25 ,8,db_formatar($tot_recursoslicNP,"f"),1,0,"C",0,"");
$pdf->x = 88;
$pdf->cell(25 ,8,db_formatar($tot_recursosliqnoexercicio,"f"),1,0,"C",0,"");
$pdf->cell(22 ,8,db_formatar($tot_recursosNP,"f"),1,0,"C",0,"");
$pdf->cell(22 ,8,db_formatar($tot_demaisobg_outrosdestinados > 0 ? 0 : $tot_demaisobg_outrosdestinados,"f"),1,0,"C",0,"");
$pdf->cell(25 ,8,db_formatar($c222_outrasdestinacoes,"f"),1,0,"C",0,"");
$pdf->cell(40 ,8,db_formatar($total_outrasdestina,"f"),1,0,"C",0,"");
$pdf->cell(33 ,8,db_formatar($tot_recursosaliqnoexercicio,"f"),1,0,"C",0,"");
$pdf->cell(34 ,8,db_formatar($tot_outrosdestinadoscancel,"f"),1,1,"C",0,"");
///*fim da linha*/
$pdf->setfont('arial','B',7);

//*total de recursos não vinculados vinculados*/
$pdf->MultiCell(33 ,5,"TOTAL DOS RECURSOS NÂO VINCULADOS",1,"C",0,0);
$pdf->x = 43;
$pdf->y = 176;
$pdf->cell(20 ,10.2,db_formatar($tot_saldo100,"f"),1,0,"C",0,"");
$pdf->x = 63;
$pdf->cell(25 ,10.2,db_formatar($total100,"f"),1,0,"C",0,"");
$pdf->x = 88;
$pdf->cell(25 ,10.2,db_formatar($tot_liqAPG100,"f"),1,0,"C",0,"");
$pdf->x = 113;
$pdf->cell(22 ,10.2,db_formatar($totalNP100,"f"),1,0,"C",0,"");
$pdf->x = 135;
$pdf->cell(22 ,10.2,db_formatar($tot_demaisobg100,"f"),1,0,"C",0,"");
$pdf->x = 157;
$pdf->cell(25 ,10.2,db_formatar($c222_recordinarios,"f"),1,0,"C",0,"");
$pdf->x = 182;
$pdf->cell(40 ,10.2,db_formatar($total_recursosordina,"f"),1,0,"C",0,"");
$pdf->x = 222;
$pdf->cell(33 ,10.2,db_formatar($tot_aliq100,"f"),1,0,"C",0,"");
$pdf->x = 255;
$pdf->cell(34 ,10.2,db_formatar($tot_empcancel100,"f"),1,1,"C",0,"");
//*fim da linha*/
$pdf->setfont('arial','',7);

///*Recursos Ordinários*/
/// $pdf->x = 43;
$pdf->MultiCell(33 ,10,"Recursos Ordinários",1,"C",0,0);
$pdf->x = 43;
$pdf->y = 35;
$pdf->cell(20 ,10.2,db_formatar($tot_saldo100,"f"),1,0,"C",0,"");
$pdf->x = 63;
$pdf->cell(25 ,10.2,db_formatar($total100,"f"),1,0,"C",0,"");
$pdf->x = 88;
$pdf->cell(25 ,10.2,db_formatar($tot_liqAPG100,"f"),1,0,"C",0,"");
$pdf->x = 113;
$pdf->cell(22 ,10.2,db_formatar($totalNP100,"f"),1,0,"C",0,"");
$pdf->x = 135;
$pdf->cell(22 ,10.2,db_formatar($tot_demaisobg100,"f"),1,0,"C",0,"");
$pdf->x = 157;
$pdf->cell(25 ,10.2,db_formatar($c222_recordinarios,"f"),1,0,"C",0,"");
$pdf->x = 182;
$pdf->cell(40 ,10.2,db_formatar($total_recursosordina,"f"),1,0,"C",0,"");
$pdf->x = 222;
$pdf->cell(33 ,10.2,db_formatar($tot_aliq100,"f"),1,0,"C",0,"");
//$pdf->x = 255;
$pdf->cell(33 ,10.2,db_formatar($tot_empcancel100,"f"),1,1,"C",0,"");
/*fim da linha*/

///*Outros Recursos não Vinculados*/
$pdf->MultiCell(33 ,5,"Outros Recursos não Vinculados",1,"C",0,0);
$pdf->x = 43;
$pdf->y = 45;
$pdf->cell(20 ,10.2,db_formatar(0,"f"),1,0,"C",0,"");
$pdf->x = 63;
$pdf->cell(25 ,10.2,db_formatar(0,"f"),1,0,"C",0,"");
$pdf->x = 88;
$pdf->cell(25 ,10.2,db_formatar(0,"f"),1,0,"C",0,"");
$pdf->x = 113;
$pdf->cell(22 ,10.2,db_formatar(0,"f"),1,0,"C",0,"");
$pdf->x = 135;
$pdf->cell(22 ,10.2,db_formatar($c222_outrosrecnaovinculados,"f"),1,0,"C",0,"");
$pdf->x = 157;
$pdf->cell(25 ,10.2,db_formatar(0,"f"),1,0,"C",0,"");
$pdf->x = 182;
$pdf->cell(40 ,10.2,db_formatar(0,"f"),1,0,"C",0,"");
$pdf->x = 255;
$pdf->cell(33 ,10.2,db_formatar(0,"f"),1,0,"C",0,"");
$pdf->x = 222;
$pdf->cell(33 ,10.2,db_formatar(0,"f"),1,1,"C",0,"");
/*fim da linha*/
$pdf->setfont('arial','B',7);

/*TOTAL*/
$pdf->cell(33 ,10,"TOTAL",1,0,"C",0,"");
$pdf->x = 43;
$pdf->cell(20 ,10.2,db_formatar($tot_a,"f"),1,0,"C",0,"");
$pdf->x = 63;
$pdf->cell(25 ,10.2,db_formatar($tot_b,"f"),1,0,"C",0,"");
$pdf->x = 88;
$pdf->cell(25 ,10.2,db_formatar($tot_c,"f"),1,0,"C",0,"");
$pdf->x = 113;
$pdf->cell(22 ,10.2,db_formatar($tot_d,"f"),1,0,"C",0,"");
$pdf->x = 135;
$pdf->cell(22 ,10.2,db_formatar(abs($tot_e),"f"),1,0,"C",0,"");
$pdf->x = 157;
$pdf->cell(25 ,10.2,db_formatar($tot_f,"f"),1,0,"C",0,"");
$pdf->x = 182;
$pdf->cell(40 ,10.2,db_formatar($tot_g,"f"),1,0,"C",0,"");
$pdf->x = 255;
$pdf->cell(33 ,10.2,db_formatar($tot_i,"f"),1,0,"C",0,"");
$pdf->x = 222;
$pdf->cell(33 ,10.2,db_formatar($tot_h,"f"),1,1,"C",0,"");
/*fim da linha*/

$pdf->Output();

?>