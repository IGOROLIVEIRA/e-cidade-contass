<?
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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_selecao_classe.php");
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <link href = "estilos.css" rel = "stylesheet" type = "text/css" >
</head>
<body>
<?
db_postmemory($HTTP_POST_VARS);
db_criatermometro('termometro','Concluido...','blue',1);
flush();
$wh = '';
$clselecao = null;

$xseparador = '';
$yseparador = '';
if($separador == 'S'){
    $xseparador = "||'#'";
    $yseparador = '#';
}



db_sel_instit();


$sql_prev = "select r33_ppatro,r33_nome from inssirf
                 where r33_anousu = $ano
								   and r33_mesusu = $mes
									 and r33_instit = ".db_getsession("DB_instit")."
									 and r33_codtab = $prev+2 limit 1;";

$res_prev = pg_query($sql_prev);
db_fieldsmemory($res_prev,0);

if ($_POST["r44_selec"] != ''){

    $clselecao = new cl_selecao;
    $rsselec   =  $clselecao->sql_record($clselecao->sql_query($r44_selec, db_getsession('DB_instit')));
    db_fieldsmemory($rsselec,0);
    $wh  =  "and $r44_where";

}
if ($_POST["vinculo"] == "S"){

    $arq = "tmp/SEGURADO.txt";

    $arquivo = fopen($arq,'w');

    db_query("drop sequence layout_ati_seq");
    db_query("create sequence layout_ati_seq");

    $sql = "SELECT lpad(5,3,0) ||lpad(COALESCE(rh01_regist::varchar,''),10,0) ||' ' ||rpad(COALESCE(z01_nome,''),80) ||lpad(' ',80) ||lpad(' ',8) ||lpad(' ',5) ||lpad(' ',40) ||lpad(' ',50) ||lpad(' ',8) ||to_char(rh01_nasc,'YYYYmmdd') ||lpad(COALESCE(z01_naturalidade,''),20) ||COALESCE(z01_sexo,'') ||lpad(' ',1) ||lpad(' ',40) ||lpad(' ',30) ||rpad(z01_mae,30) ||to_char(rh01_admiss,'YYYYmmdd') || CASE
WHEN h13_tpcont::integer = 12 THEN lpad(1,4,0)
WHEN h13_tpcont::integer = 21 THEN lpad(1,4,0)
WHEN h13_tpcont::integer = 19 THEN lpad(3,4,0)
WHEN h13_tpcont::integer = 20 THEN lpad(2,4,0)
END || lpad(' ',20) || lpad(COALESCE(rh44_codban::varchar,''),3) || lpad(COALESCE(rh44_agencia::varchar,''),4) || reverse(substring(reverse(rh44_conta),1,9)) || lpad(COALESCE(rh44_dvconta::varchar,''),1) ||
lpad(' ',8) || lpad(' ',7) || lpad(COALESCE(z01_cgccpf,''),11) || lpad(' ',11) || lpad(' ',11) || lpad(' ',2) || lpad(' ',4) || lpad(' ',5) || lpad(' ',11) || lpad(' ',8) || lpad(' ',6) || lpad('*',1) AS todo

  FROM rhpessoal
INNER JOIN rhpessoalmov ON rh02_regist = rh01_regist
INNER JOIN cgm ON rh01_numcgm = z01_numcgm
INNER JOIN rhlota ON r70_codigo = rh02_lota
AND r70_instit = rh02_instit
INNER JOIN rhregime ON rh30_codreg = rh02_codreg
AND rh30_instit = rh02_instit
INNER JOIN rhfuncao ON rh37_funcao = rh02_funcao
AND rh37_instit = rh02_instit
LEFT JOIN rhpespadrao ON rh03_seqpes = rh02_seqpes
INNER JOIN tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
INNER JOIN db_config ON codigo = rh02_instit
INNER JOIN
(SELECT r14_regist,
        round(sum(CASE WHEN r14_pd = 1 THEN r14_valor ELSE 0 END),2) AS prov,
        round(sum(CASE WHEN r14_pd = 2 THEN r14_valor ELSE 0 END),2) AS desco,
        round(sum(CASE WHEN r14_rubric = 'R992' THEN r14_valor ELSE 0 END),2) AS base
 FROM gerfsal
 WHERE r14_anousu = $ano
   AND r14_mesusu = $mes
   AND r14_instit = ".db_getsession('DB_instit')."
 GROUP BY r14_regist) AS sal ON r14_regist = rh01_regist
LEFT JOIN rhpessoalmovcontabancaria ON rh138_rhpessoalmov = rh02_seqpes
AND rh138_instit = rh02_instit
LEFT JOIN contabancaria ON rh138_contabancaria = db83_sequencial
LEFT JOIN rhpesrescisao ON rhpesrescisao.rh05_seqpes = rhpessoalmov.rh02_seqpes
LEFT JOIN rhpesbanco ON rh44_seqpes = rh02_seqpes
  where rh30_vinculo = 'A'
  AND rh02_anousu = $ano
  AND rh02_mesusu = $mes
  AND rh02_instit = ".db_getsession('DB_instit')."
  and rh02_tbprev = $prev
    $wh
";

    $result = db_query($sql);
    $num = pg_numrows($result);
    for($x = 0;$x < pg_numrows($result);$x++){

        db_atutermometro($x,$num,'termometro');
        flush();

        fputs($arquivo,pg_result($result,$x,'todo')."\r\n");
    }
    fclose($arquivo);

} else if ($_POST["vinculo"] == "C"){


    $arq = "tmp/CARGO.txt";


    $arquivo = fopen($arq,'w');

    db_query("drop sequence layout_ina_seq");
    db_query("create sequence layout_ina_seq");

    $sql = "
  SELECT rh01_regist AS matricula,
       lpad(5,3,0)
       $xseparador ||
       case when h13_tpcont::integer = 12 then lpad(1,1,0)
	    when h13_tpcont::integer = 21 then lpad(1,1,0)
	    when h13_tpcont::integer = 19 then lpad(3,1,0)
	    when h13_tpcont::integer = 20 then lpad(2,1,0)
       end
       $xseparador ||
       lpad(rh02_funcao,4,0)
       $xseparador || rpad(rh37_descr,80)
       $xseparador || 'N'
       $xseparador || '1'

       as todo

  from rhpessoal
     inner join rhpessoalmov on rh02_regist = rh01_regist
                            and rh02_anousu = $ano
                                  and rh02_mesusu = $mes
                            and rh02_instit = ".db_getsession('DB_instit')."
     inner join cgm          on z01_numcgm  = rh01_numcgm
     inner join rhlota       on r70_codigo  = rh02_lota
                            and r70_instit  = rh02_instit
     inner join rhregime     on rh30_codreg = rh02_codreg
                            and rh30_instit = rh02_instit
     inner join rhfuncao     on rh37_funcao  = rh02_funcao
                            and rh37_instit  = rh02_instit
     inner join (select r14_regist,
                        round(sum(case when r14_pd = 1 then r14_valor else 0 end),2) as prov,
                              round(sum(case when r14_pd = 2 then r14_valor else 0 end),2) as desco,
                              round(sum(case when r14_rubric = 'R992' then r14_valor else 0 end ),2) as base
                 from gerfsal
                     where r14_anousu = $ano
                     and r14_mesusu = $mes
                 and r14_instit = ".db_getsession('DB_instit')."
                     group by r14_regist ) as sal on r14_regist = rh01_regist

     INNER JOIN tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
      INNER JOIN rhpessoalmovcontabancaria ON rh138_rhpessoalmov = rh02_seqpes
					and rh138_instit = rh02_instit
    INNER JOIN contabancaria ON rh138_contabancaria = db83_sequencial
    LEFT JOIN rhpesrescisao ON rhpesrescisao.rh05_seqpes = rhpessoalmov.rh02_seqpes
  where 1 = 1
    $wh
";

    //echo $sql;exit;
    $result = db_query($sql);
    $num = pg_numrows($result);
    for($x = 0;$x < pg_numrows($result);$x++){

        db_atutermometro($x,$num,'termometro');
        flush();
        $matric = pg_result($result,$x,'matricula');

        fputs($arquivo,pg_result($result,$x,'todo')."\r\n");
    }
    fclose($arquivo);

}else if ($_POST["vinculo"] == "RB"){

    $arq = "tmp/RUBRICABENEFICIO.txt";
    $arquivo = fopen($arq,'w');

    db_query("drop sequence layout_pen_seq");
    db_query("create sequence layout_pen_seq");

    $sql = "

SELECT distinct
       lpad('',4,0)
       $xseparador ||lpad('',4,0)
       $xseparador || rh27_rubric
       $xseparador || rh27_descr
       $xseparador ||
       case when rh27_pd = 1 then 'P'
            when rh27_pd = 2 then 'D'
       end
       $xseparador||
       case when r08_codigo in ('B002','B003','B020') then 'S'
            else 'N'
       end
       $xseparador||
       case when r08_codigo in ('B004','B005','B006') then 'S'
            else 'N'
       end
       $xseparador||
       lpad(rh27_rubric||'-'||rh27_form||'-'||rh27_obs,80)

       as todo

      from  bases
        inner join basesr     on r09_anousu = r08_anousu
                             and r09_mesusu = r08_mesusu
                             and r09_base   = r08_codigo
                             and r09_instit = r08_instit
        inner join rhrubricas on r09_rubric = rh27_rubric
                             and r09_instit = rh27_instit

  where r08_anousu = $ano
    and r08_mesusu = $mes
    and r08_instit = ".db_getsession('DB_instit')."
    $wh
";

    $result = db_query($sql);
    $num = pg_numrows($result);
    for($x = 0;$x < pg_numrows($result);$x++){

        db_atutermometro($x,$num,'termometro');
        flush();


        fputs($arquivo,pg_result($result,$x,'todo')."\r\n");
    }
    fclose($arquivo);


}else if ($_POST["vinculo"] == "FP"){ /// Tab.Escolaridade

    $arq = "tmp/MMAAAA.txt";
    $arquivo = fopen($arq,'w');

    db_query("drop sequence layout_ina_seq");
    db_query("create sequence layout_ina_seq");

    $sql = "
 select y.rh02_mesusu||y.rh02_anousu||y.pref_mat||y.matricula||y.campobranco||y.cpf||y.z01_nome||y.valorbase|| y.valorcontrib|| y.valorcontribrespec ||y.valorcontribcomple||y.valorcontribcomple2||y.marca||y.final as todo from
(select x.rh02_mesusu as rh02_mesusu,x.rh02_anousu as rh02_anousu,x.pref_mat as pref_mat,
	lpad(x.matricula,10,0) as matricula,x.campobranco as campobranco,lpad(x.cpf,11) as cpf,
	rpad(x.z01_nome,80) as z01_nome,lpad(translate((coalesce(sum(x.valorbase),0.00))::varchar,'.',''),11,'0') as valorbase,
	lpad(translate((coalesce(sum(x.valorcontrib),0.00))::varchar,'.',''),9,0) as valorcontrib ,
	lpad(replace(round(coalesce(sum(x.valorcontribrespec),0.00),2)::varchar,'.',''),9,0) as valorcontribrespec,
	rpad(x.valorcontribcomple,9) as valorcontribcomple,rpad(x.valorcontribcomple2,9) as valorcontribcomple2,
	x.marca as marca,x.final as final 
	from 

(SELECT DISTINCT rh02_mesusu,rh02_anousu ,lpad(5,3,0) as pref_mat , lpad(rh01_regist,10,0) as matricula ,' ' as campobranco , lpad(z01_cgccpf,11) as cpf , z01_nome , basegerfsal as valorbase , basegerfsaldesc as valorcontrib , basegerfsal/100*$r33_ppatro as valorcontribrespec , rpad(' ',9) as valorcontribcomple , rpad(' ',9) as valorcontribcomple2 , 'N' as marca, rpad('*',1) as final  
FROM rhpessoal
INNER JOIN rhpessoalmov ON rh02_regist = rh01_regist
AND rh02_anousu = $ano
AND rh02_mesusu = $mes
AND rh02_instit = ".db_getsession('DB_instit')."
INNER JOIN cgm ON z01_numcgm = rh01_numcgm
INNER JOIN rhlota ON r70_codigo = rh02_lota
AND r70_instit = rh02_instit
INNER JOIN rhregime ON rh30_codreg = rh02_codreg
AND rh30_instit = rh02_instit
INNER JOIN rhfuncao ON rh37_funcao = rh02_funcao
AND rh37_instit = rh02_instit
INNER JOIN
    (SELECT r14_regist,
            round(sum(CASE
                          WHEN r14_pd = 1 THEN r14_valor
                          ELSE 0
                      END),2) AS provgerfsal,
            round(sum(CASE
                          WHEN r14_pd = 2 THEN r14_valor
                          ELSE 0
                      END),2) AS descogerfsal,
            round(sum(CASE
                          WHEN r14_rubric = 'R992' THEN r14_valor
                          ELSE 0
                      END),2) AS basegerfsal,
            round(sum(CASE
                          WHEN r14_rubric = 'R993' THEN r14_valor
                          ELSE 0
                      END),2) AS basegerfsaldesc
     FROM gerfsal
     WHERE r14_anousu = $ano
         AND r14_mesusu = $mes
         AND r14_instit = ".db_getsession('DB_instit')."
         AND r14_rubric IN ('R993',
                            'R992')
     GROUP BY r14_regist) AS salgerfsal ON r14_regist = rh01_regist
INNER JOIN tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
LEFT JOIN rhpessoalmovcontabancaria ON rh138_rhpessoalmov = rh02_seqpes
AND rh138_instit = rh02_instit
LEFT JOIN contabancaria ON rh138_contabancaria = db83_sequencial
LEFT JOIN rhpesrescisao ON rhpesrescisao.rh05_seqpes = rhpessoalmov.rh02_seqpes
WHERE 1=1 $wh
UNION
SELECT DISTINCT rh02_mesusu,rh02_anousu ,lpad(5,3,0) as pref_mat , lpad(rh01_regist,10,0) as matricula ,' ' as campobranco , lpad(z01_cgccpf,11) as cpf , z01_nome , basegerfsal as valorbase , basegerfsaldesc as valorcontrib , basegerfsal/100*$r33_ppatro as valorcontribrespec , rpad(' ',9) as valorcontribcomple , rpad(' ',9) as valorcontribcomple2 , 'N' as marca, rpad('*',1) as final
FROM rhpessoal
INNER JOIN rhpessoalmov ON rh02_regist = rh01_regist
AND rh02_anousu = $ano
AND rh02_mesusu = 8
AND rh02_instit = ".db_getsession('DB_instit')."
INNER JOIN cgm ON z01_numcgm = rh01_numcgm
INNER JOIN rhlota ON r70_codigo = rh02_lota
AND r70_instit = rh02_instit
INNER JOIN rhregime ON rh30_codreg = rh02_codreg
AND rh30_instit = rh02_instit
INNER JOIN rhfuncao ON rh37_funcao = rh02_funcao
AND rh37_instit = rh02_instit
INNER JOIN
    (SELECT r20_regist,
            round(sum(CASE
                          WHEN r20_pd = 1 THEN r20_valor
                          ELSE 0
                      END),2) AS provgerfsal,
            round(sum(CASE
                          WHEN r20_pd = 2 THEN r20_valor
                          ELSE 0
                      END),2) AS descogerfsal,
            round(sum(CASE
                          WHEN r20_rubric = 'R992' THEN r20_valor
                          ELSE 0
                      END),2) AS basegerfsal,
            round(sum(CASE
                          WHEN r20_rubric = 'R993' THEN r20_valor
                          ELSE 0
                      END),2) AS basegerfsaldesc
     FROM gerfres
     WHERE r20_anousu = $ano
         AND r20_mesusu = 8
         AND r20_instit = ".db_getsession('DB_instit')."
         AND r20_rubric IN ('R993',
                            'R992')
     GROUP BY r20_regist) AS salgerfsal ON r20_regist = rh01_regist
INNER JOIN tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
LEFT JOIN rhpessoalmovcontabancaria ON rh138_rhpessoalmov = rh02_seqpes
AND rh138_instit = rh02_instit
LEFT JOIN contabancaria ON rh138_contabancaria = db83_sequencial
LEFT JOIN rhpesrescisao ON rhpesrescisao.rh05_seqpes = rhpessoalmov.rh02_seqpes
WHERE 1=1 $wh
UNION
SELECT DISTINCT rh02_mesusu,rh02_anousu ,lpad(5,3,0) as pref_mat , lpad(rh01_regist,10,0) as matricula ,' ' as campobranco , lpad(z01_cgccpf,11) as cpf , z01_nome , basegerfsal as valorbase , basegerfsaldesc as valorcontrib , basegerfsal/100*$r33_ppatro as valorcontribrespec , rpad(' ',9) as valorcontribcomple , rpad(' ',9) as valorcontribcomple2 , 'N' as marca, rpad('*',1) as final
FROM rhpessoal
INNER JOIN rhpessoalmov ON rh02_regist = rh01_regist
AND rh02_anousu = $ano
AND rh02_mesusu = $mes
AND rh02_instit = ".db_getsession('DB_instit')."
INNER JOIN cgm ON z01_numcgm = rh01_numcgm
INNER JOIN rhlota ON r70_codigo = rh02_lota
AND r70_instit = rh02_instit
INNER JOIN rhregime ON rh30_codreg = rh02_codreg
AND rh30_instit = rh02_instit
INNER JOIN rhfuncao ON rh37_funcao = rh02_funcao
AND rh37_instit = rh02_instit
INNER JOIN
    (SELECT r48_regist,
            round(sum(CASE
                          WHEN r48_pd = 1 THEN r48_valor
                          ELSE 0
                      END),2) AS provgerfsal,
            round(sum(CASE
                          WHEN r48_pd = 2 THEN r48_valor
                          ELSE 0
                      END),2) AS descogerfsal,
            round(sum(CASE
                          WHEN r48_rubric = 'R992' THEN r48_valor
                          ELSE 0
                      END),2) AS basegerfsal,
            round(sum(CASE
                          WHEN r48_rubric = 'R993' THEN r48_valor
                          ELSE 0
                      END),2) AS basegerfsaldesc
     FROM gerfcom
     WHERE r48_anousu = $ano
         AND r48_mesusu = $mes
         AND r48_instit = ".db_getsession('DB_instit')."
         AND r48_rubric IN ('R993',
                            'R992')
     GROUP BY r48_regist) AS salgerfsal ON r48_regist = rh01_regist
INNER JOIN tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
LEFT JOIN rhpessoalmovcontabancaria ON rh138_rhpessoalmov = rh02_seqpes
AND rh138_instit = rh02_instit
LEFT JOIN contabancaria ON rh138_contabancaria = db83_sequencial
LEFT JOIN rhpesrescisao ON rhpesrescisao.rh05_seqpes = rhpessoalmov.rh02_seqpes
WHERE 1=1 $wh
UNION
SELECT DISTINCT rh02_mesusu,rh02_anousu ,lpad(5,3,0) as pref_mat , lpad(rh01_regist,10,0) as matricula ,' ' as campobranco , lpad(z01_cgccpf,11) as cpf , z01_nome , basegerfsal as valorbase , basegerfsaldesc as valorcontrib , basegerfsal/100*$r33_ppatro as valorcontribrespec , rpad(' ',9) as valorcontribcomple , rpad(' ',9) as valorcontribcomple2 , 'S' , rpad('*',1) as final
FROM rhpessoal
INNER JOIN rhpessoalmov ON rh02_regist = rh01_regist
AND rh02_anousu = $ano
AND rh02_mesusu = $mes
AND rh02_instit = ".db_getsession('DB_instit')."
INNER JOIN cgm ON z01_numcgm = rh01_numcgm
INNER JOIN rhlota ON r70_codigo = rh02_lota
AND r70_instit = rh02_instit
INNER JOIN rhregime ON rh30_codreg = rh02_codreg
AND rh30_instit = rh02_instit
INNER JOIN rhfuncao ON rh37_funcao = rh02_funcao
AND rh37_instit = rh02_instit
INNER JOIN
    (SELECT r35_regist,
            round(sum(CASE
                          WHEN r35_pd = 1 THEN r35_valor
                          ELSE 0
                      END),2) AS provgerfsal,
            round(sum(CASE
                          WHEN r35_pd = 2 THEN r35_valor
                          ELSE 0
                      END),2) AS descogerfsal,
            round(sum(CASE
                          WHEN r35_rubric = 'R986' THEN r35_valor
                          ELSE 0
                      END),2) AS basegerfsal,
            round(sum(CASE
                          WHEN r35_rubric = 'R993' THEN r35_valor
                          ELSE 0
                      END),2) AS basegerfsaldesc
     FROM gerfs13
     WHERE r35_anousu = $ano
         AND r35_mesusu = $mes
         AND r35_instit = ".db_getsession('DB_instit')."
         AND r35_rubric IN ('R993',
                            'R986')
     GROUP BY r35_regist) AS salgerfsal ON r35_regist = rh01_regist
INNER JOIN tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
LEFT JOIN rhpessoalmovcontabancaria ON rh138_rhpessoalmov = rh02_seqpes
AND rh138_instit = rh02_instit
LEFT JOIN contabancaria ON rh138_contabancaria = db83_sequencial
LEFT JOIN rhpesrescisao ON rhpesrescisao.rh05_seqpes = rhpessoalmov.rh02_seqpes
WHERE 1=1 $wh ) as x 
group by x.rh02_mesusu,x.rh02_anousu,x.pref_mat,x.matricula,x.campobranco,x.cpf,x.z01_nome,x.valorcontribcomple,x.valorcontribcomple2,x.marca,x.final) as y;
";
    //echo $sql;exit;
    $result = db_query($sql);
    $num = pg_numrows($result);
    for($x = 0;$x < pg_numrows($result);$x++){

        db_atutermometro($x,$num,'termometro');
        flush();
        //$matric = pg_result($result,$x,'matricula');

        fputs($arquivo,pg_result($result,$x,'todo')."\r\n");
    }
    fclose($arquivo);

}else if ($_POST["vinculo"] == "HS"){ /// Tab.Escolaridade

    $arq = "tmp/HISTORICODESALARIO.txt";
    $arquivo = fopen($arq,'w');

    db_query("drop sequence layout_ina_seq");
    db_query("create sequence layout_ina_seq");

    $sql = "
           SELECT lpad(5,3,0)
       $xseparador ||lpad(rh01_regist,10,0)
       $xseparador ||lpad(0,1,0)
       $xseparador ||lpad(replace(r14_rubric,'R','9'),4,0)
       $xseparador ||lpad($ano,4,0)
       $xseparador ||lpad($mes,2,0)
       $xseparador ||lpad($ano,4,0)
       $xseparador ||lpad($mes,2,0)
       $xseparador ||lpad(".date('Ymd').",8,0)
       $xseparador ||lpad(translate( coalesce(r14_valor,0.00)::varchar,'.',''),10,'0')
       $xseparador || 'N'


       AS todo
FROM rhpessoal
INNER JOIN rhpessoalmov ON rh02_regist = rh01_regist
AND rh02_anousu = $ano
AND rh02_mesusu = $mes
AND rh02_instit = ".db_getsession('DB_instit')."
INNER JOIN cgm ON rh01_numcgm = z01_numcgm
INNER JOIN rhlota ON r70_codigo = rh02_lota
AND r70_instit = rh02_instit
INNER JOIN rhregime ON rh30_codreg = rh02_codreg
AND rh30_instit = rh02_instit
INNER JOIN rhfuncao ON rh37_funcao = rh02_funcao
AND rh37_instit = rh02_instit
LEFT JOIN rhpespadrao ON rh03_seqpes = rh02_seqpes
INNER JOIN db_config ON codigo = rh02_instit

  LEFT JOIN gerfsal ON gerfsal.r14_anousu = rhpessoalmov.rh02_anousu
  AND gerfsal.r14_mesusu = rhpessoalmov.rh02_mesusu
  AND rhpessoalmov.rh02_instit = ".db_getsession('DB_instit')."
  AND gerfsal.r14_regist = rhpessoalmov.rh02_regist
  AND gerfsal.r14_instit = rhpessoalmov.rh02_instit
  AND gerfsal.r14_pd in (1,2)

  

INNER JOIN tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
LEFT JOIN rhpessoalmovcontabancaria ON rh138_rhpessoalmov = rh02_seqpes
 and rh138_instit = rh02_instit
LEFT JOIN contabancaria ON rh138_contabancaria = db83_sequencial
LEFT JOIN rhpesrescisao ON rhpesrescisao.rh05_seqpes = rhpessoalmov.rh02_seqpes
 where 1 = 1
AND rh30_vinculo = 'A'
AND rh30_regime = 1
AND r14_valor is not null
$wh

union all


SELECT lpad(5,3,0)
       $xseparador ||lpad(rh01_regist,10,0)
       $xseparador ||lpad(0,1,0)
       $xseparador ||lpad(replace(r48_rubric,'R','9'),4,0)
       $xseparador ||lpad($ano,4,0)
       $xseparador ||lpad($mes,2,0)
       $xseparador ||lpad($ano,4,0)
       $xseparador ||lpad($mes,2,0)
       $xseparador ||lpad(".date('Ymd').",8,0)
       $xseparador ||lpad(translate( coalesce(r48_valor,0.00)::varchar,'.',''),10,'0')
       $xseparador || 'N'


       AS todo
FROM rhpessoal
INNER JOIN rhpessoalmov ON rh02_regist = rh01_regist
AND rh02_anousu = $ano
AND rh02_mesusu = $mes
AND rh02_instit = ".db_getsession('DB_instit')."
INNER JOIN cgm ON rh01_numcgm = z01_numcgm
INNER JOIN rhlota ON r70_codigo = rh02_lota
AND r70_instit = rh02_instit
INNER JOIN rhregime ON rh30_codreg = rh02_codreg
AND rh30_instit = rh02_instit
INNER JOIN rhfuncao ON rh37_funcao = rh02_funcao
AND rh37_instit = rh02_instit
LEFT JOIN rhpespadrao ON rh03_seqpes = rh02_seqpes
INNER JOIN db_config ON codigo = rh02_instit

  LEFT JOIN gerfcom ON gerfcom.r48_anousu = rhpessoalmov.rh02_anousu
  AND gerfcom.r48_mesusu = rhpessoalmov.rh02_mesusu
  AND rhpessoalmov.rh02_instit = ".db_getsession('DB_instit')."
  AND gerfcom.r48_regist = rhpessoalmov.rh02_regist
  AND gerfcom.r48_instit = rhpessoalmov.rh02_instit
  AND gerfcom.r48_pd in (1,2)

  

INNER JOIN tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
LEFT JOIN rhpessoalmovcontabancaria ON rh138_rhpessoalmov = rh02_seqpes
 and rh138_instit = rh02_instit
LEFT JOIN contabancaria ON rh138_contabancaria = db83_sequencial
LEFT JOIN rhpesrescisao ON rhpesrescisao.rh05_seqpes = rhpessoalmov.rh02_seqpes
 where 1 = 1
AND rh30_vinculo = 'A'
AND rh30_regime = 1
AND r48_valor is not null
$wh

union all


SELECT lpad(5,3,0)
       $xseparador ||lpad(rh01_regist,10,0)
       $xseparador ||lpad(0,1,0)
       $xseparador ||lpad(replace(r20_rubric,'R','9'),4,0)
       $xseparador ||lpad($ano,4,0)
       $xseparador ||lpad($mes,2,0)
       $xseparador ||lpad($ano,4,0)
       $xseparador ||lpad($mes,2,0)
       $xseparador ||lpad(".date('Ymd').",8,0)
       $xseparador ||lpad(translate( coalesce(r20_valor,0.00)::varchar,'.',''),10,'0')
       $xseparador || 'N'


       AS todo
FROM rhpessoal
INNER JOIN rhpessoalmov ON rh02_regist = rh01_regist
AND rh02_anousu = $ano
AND rh02_mesusu = $mes
AND rh02_instit = ".db_getsession('DB_instit')."
INNER JOIN cgm ON rh01_numcgm = z01_numcgm
INNER JOIN rhlota ON r70_codigo = rh02_lota
AND r70_instit = rh02_instit
INNER JOIN rhregime ON rh30_codreg = rh02_codreg
AND rh30_instit = rh02_instit
INNER JOIN rhfuncao ON rh37_funcao = rh02_funcao
AND rh37_instit = rh02_instit
LEFT JOIN rhpespadrao ON rh03_seqpes = rh02_seqpes
INNER JOIN db_config ON codigo = rh02_instit

  LEFT JOIN gerfres ON gerfres.r20_anousu = rhpessoalmov.rh02_anousu
  AND gerfres.r20_mesusu = rhpessoalmov.rh02_mesusu
  AND rhpessoalmov.rh02_instit = ".db_getsession('DB_instit')."
  AND gerfres.r20_regist = rhpessoalmov.rh02_regist
  AND gerfres.r20_instit = rhpessoalmov.rh02_instit
  AND gerfres.r20_pd in (1,2)

  

INNER JOIN tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
LEFT JOIN rhpessoalmovcontabancaria ON rh138_rhpessoalmov = rh02_seqpes
 and rh138_instit = rh02_instit
LEFT JOIN contabancaria ON rh138_contabancaria = db83_sequencial
LEFT JOIN rhpesrescisao ON rhpesrescisao.rh05_seqpes = rhpessoalmov.rh02_seqpes
 where 1 = 1
AND rh30_vinculo = 'A'
AND rh30_regime = 1
AND r20_valor is not null
$wh

union all


      SELECT lpad(5,3,0)
       $xseparador ||lpad(rh01_regist,10,0)
       $xseparador ||lpad(0,1,0)
       $xseparador ||lpad(replace(r35_rubric,'R','9'),4,0)
       $xseparador ||lpad($ano,4,0)
       $xseparador ||lpad($mes,2,0)
       $xseparador ||lpad($ano,4,0)
       $xseparador ||lpad($mes,2,0)
       $xseparador ||lpad(".date('Ymd').",8,0)
       $xseparador ||lpad(translate( (coalesce(r35_valor,0.00))::varchar,'.',''),10,'0')
       $xseparador || 'S'

       AS todo
FROM rhpessoal
INNER JOIN rhpessoalmov ON rh02_regist = rh01_regist
AND rh02_anousu = $ano
AND rh02_mesusu = $mes
AND rh02_instit = ".db_getsession('DB_instit')."
INNER JOIN cgm ON rh01_numcgm = z01_numcgm
INNER JOIN rhlota ON r70_codigo = rh02_lota
AND r70_instit = rh02_instit
INNER JOIN rhregime ON rh30_codreg = rh02_codreg
AND rh30_instit = rh02_instit
INNER JOIN rhfuncao ON rh37_funcao = rh02_funcao
AND rh37_instit = rh02_instit
LEFT JOIN rhpespadrao ON rh03_seqpes = rh02_seqpes
INNER JOIN db_config ON codigo = rh02_instit

LEFT JOIN gerfs13 ON gerfs13.r35_anousu = rhpessoalmov.rh02_anousu
  AND gerfs13.r35_mesusu = rhpessoalmov.rh02_mesusu
  AND rhpessoalmov.rh02_instit = ".db_getsession('DB_instit')."
  AND gerfs13.r35_regist = rhpessoalmov.rh02_regist
  AND gerfs13.r35_instit = rhpessoalmov.rh02_instit
  AND gerfs13.r35_pd in (1,2)


INNER JOIN tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
LEFT JOIN rhpessoalmovcontabancaria ON rh138_rhpessoalmov = rh02_seqpes
 and rh138_instit = rh02_instit
lEFT JOIN contabancaria ON rh138_contabancaria = db83_sequencial
LEFT JOIN rhpesrescisao ON rhpesrescisao.rh05_seqpes = rhpessoalmov.rh02_seqpes
 where 1 = 1
AND rh30_vinculo = 'A'
AND rh30_regime = 1
AND r35_valor is not null
$wh

";
//echo $sql;exit;
    $result = db_query($sql);
    $num = pg_numrows($result);
    for($x = 0;$x < pg_numrows($result);$x++){

        db_atutermometro($x,$num,'termometro');
        flush();
        //$matric = pg_result($result,$x,'matricula');

        fputs($arquivo,pg_result($result,$x,'todo')."\r\n");
    }
    fclose($arquivo);

}else if ($_POST["vinculo"] == "VO"){ /// Tab.Escolaridade

    $arq = "tmp/VERBAORGANIZACAO.txt";
    $arquivo = fopen($arq,'w');

    db_query("drop sequence layout_ina_seq");
    db_query("create sequence layout_ina_seq");

    $sql = "
    SELECT DISTINCT
    lpad(5,3,0)
    $xseparador ||lpad(1,3,0)
    $xseparador || rpad(replace(rh27_rubric,'R','9'),4)
    $xseparador || rpad(rh27_descr,80)
    $xseparador ||
    CASE
    WHEN r08_codigo IN ('B907','B908') THEN '1'
    WHEN r08_codigo IN ('B002','B001','B020','B003') THEN '4'
    WHEN rh27_rubric IN ('R992') THEN '3'
    else '9'
    END
    $xseparador ||
    CASE
    WHEN rh27_pd = 1 THEN 'P'
    WHEN rh27_pd = 2 THEN 'D'
    END
    AS todo
    FROM bases
    INNER JOIN basesr ON r09_anousu = r08_anousu
    AND r09_mesusu = r08_mesusu
    AND r09_base = r08_codigo
    AND r09_instit = r08_instit
    INNER JOIN rhrubricas ON r09_rubric = rh27_rubric
    AND r09_instit = rh27_instit
    where 1 = 1
        $wh
      AND r08_anousu = $ano
      AND r08_mesusu = $mes
      AND r08_instit = 1
      AND rh27_pd in (1,2)

    ";

    $result = db_query($sql);
    $num = pg_numrows($result);
    for($x = 0;$x < pg_numrows($result);$x++){

        db_atutermometro($x,$num,'termometro');
        flush();
        //$matric = pg_result($result,$x,'matricula');

        fputs($arquivo,pg_result($result,$x,'todo')."\r\n");
    }
    fclose($arquivo);

}else if ($_POST["vinculo"] == "DP"){ /// Tab.Escolaridade

  $arq = "tmp/DEPENDENTES.txt";
  $arquivo = fopen($arq,'w');

  $sql = "
  
    SELECT COALESCE(lpad(5,3,0),'')
       ||COALESCE(lpad(rh01_regist,10,0),'')
       ||' '
       ||COALESCE(lpad(row_number() OVER (PARTITION by rh01_regist order by rh01_regist),2,'0'),'')
       ||COALESCE(rpad(rh31_nome,80),'')
       ||
       case when rh31_gparen = 'C' then COALESCE(lpad(1,2,0),'')
                  when rh31_gparen = 'F' and extract(year from age(rh31_dtnasc)) < 21 then COALESCE(lpad(3,2,0),'')
                  when rh31_gparen = 'F' and extract(year from age(rh31_dtnasc)) > 21 then COALESCE(lpad(15,2),'')
                  when rh31_gparen = 'P' then COALESCE(lpad(5,2,0),'')
                  when rh31_gparen = 'M' then COALESCE(lpad(5,2,0),'')
                  when rh31_gparen = 'O' then COALESCE(lpad(0,2,0),'')
                  else COALESCE(lpad(0,2,0),'')
                  end
       ||COALESCE(to_char(rh31_dtnasc,'YYYYmmdd'),'')
       AS todo
FROM rhpessoal
LEFT JOIN rhpessoalmov ON rhpessoalmov.rh02_regist = rhpessoal.rh01_regist
AND rhpessoalmov.rh02_anousu = $ano
AND rhpessoalmov.rh02_mesusu = $mes
join rhdepend on rh31_regist = rh01_regist
LEFT JOIN rhpesrescisao ON rh02_seqpes = rh05_seqpes
where rh05_seqpes IS NULL
$wh
    ";

  $result = db_query($sql);
  $num = pg_numrows($result);
  for($x = 0;$x < pg_numrows($result);$x++){

    db_atutermometro($x,$num,'termometro');
    flush();
    //$matric = pg_result($result,$x,'matricula');

    fputs($arquivo,pg_result($result,$x,'todo')."\r\n");
  }
  fclose($arquivo);

}
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));

?>
<form name = 'form1' id = 'form1'> </form>
<script>
    js_montarlista("<?=$arq?>#Arquivo gerado em: <?=$arq?>", 'form1');
    function js_manda() {
        location.href = 'pes4_geraraspprev.php?banco=001';
    }
    setTimeout(js_manda, 300);
</script>
</body>
</html>
