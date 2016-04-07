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

  $sql = "
SELECT rh01_regist AS matricula,
       lpad(3,3,0)
       $xseparador ||lpad(rh01_regist,10,0)
       $xseparador ||' '
       $xseparador ||lpad(z01_nome,80)
       $xseparador ||lpad(' ',80)
       $xseparador ||lpad(' ',8)
       $xseparador ||lpad(' ',40)
       $xseparador ||lpad(' ',50)
       $xseparador ||lpad(' ',8)
       $xseparador ||to_char(rh01_nasc,'YYYYmmdd')
       $xseparador ||z01_sexo
       $xseparador ||lpad(' ',1)
       $xseparador ||lpad(' ',40)
       $xseparador ||lpad(' ',30)
       $xseparador ||lpad(z01_mae,30)
       $xseparador ||to_char(rh01_admiss,'YYYYmmdd')
       $xseparador ||
       case when h13_tpcont::integer = 12 then lpad(1,3,0)
	    when h13_tpcont::integer = 21 then lpad(1,3,0)
	    when h13_tpcont::integer = 19 then lpad(3,3,0)
	    when h13_tpcont::integer = 20 then lpad(2,3,0)
       end
       $xseparador || lpad(' ',20)
       $xseparador || lpad(rh02_funcao,3,0)
       $xseparador || lpad(' ',20)
       $xseparador || translate(to_char(rh02_salari,'9999999999.99'),'.','')
       $xseparador ||
       translate(to_char(
       (SELECT r14_valor
	  FROM gerfsal
	  where
	  gerfsal.r14_anousu = $ano
	  AND gerfsal.r14_mesusu = $mes
	  AND gerfsal.r14_instit = ".db_getsession('DB_instit')."
	  AND gerfsal.r14_rubric = 'R985'
	  AND gerfsal.r14_regist = rh02_regist),'9999999999.99'),'.','')
       $xseparador || lpad(db83_sequencial,3)
       $xseparador || lpad(db83_bancoagencia,4)
       $xseparador || lpad(db83_conta,9)
       $xseparador || lpad(db83_dvconta,1)
       $xseparador || case when rh05_recis is not null then 'D'
		   else '1'
		end
       $xseparador || case when rh05_recis is not null then to_char(rh05_recis,'YYYYmmdd')
		   else '00000000'
		end
       $xseparador || lpad(' ',8)
       $xseparador || lpad(' ',7)
       $xseparador || lpad(z01_cgccpf,11)
       $xseparador || lpad(' ',11)
       $xseparador || lpad(' ',11)
       $xseparador || lpad(' ',2)
       $xseparador || lpad(' ',4)
       $xseparador || lpad(' ',5)
       $xseparador || lpad(' ',11)
       $xseparador || lpad(' ',6)
       $xseparador || lpad('*',1)

       as todo

  from rhpessoal
     inner join rhpessoalmov on rh02_regist  = rh01_regist
                            and rh02_anousu  = $ano
                                  and rh02_mesusu  = $mes
                            and rh02_instit  = ".db_getsession('DB_instit')."
     inner join cgm          on rh01_numcgm  = z01_numcgm
     inner join rhlota       on r70_codigo   = rh02_lota
                            and r70_instit   = rh02_instit
     inner join rhregime     on rh30_codreg  = rh02_codreg
                            and rh30_instit  = rh02_instit
     inner join rhfuncao     on rh37_funcao  = rh02_funcao
                            and rh37_instit  = rh02_instit
     left join rhpespadrao   on rh03_seqpes  = rh02_seqpes
     INNER JOIN tpcontra ON tpcontra.h13_codigo       = rhpessoalmov.rh02_tpcont
     inner join db_config    on codigo       = rh02_instit
     inner join (select r14_regist,
                        round(sum(case when r14_pd = 1 then r14_valor else 0 end),2) as prov,
                              round(sum(case when r14_pd = 2 then r14_valor else 0 end),2) as desco,
                              round(sum(case when r14_rubric = 'R992' then r14_valor else 0 end ),2) as base,
                 from gerfsal
                     where r14_anousu = $ano
                     and r14_mesusu = $mes
                 and r14_instit = ".db_getsession('DB_instit')."
                     group by r14_regist ) as sal on r14_regist = rh01_regist

     INNER JOIN rhpessoalmovcontabancaria ON rh138_rhpessoalmov = rh02_seqpes
                            and rh138_instit = rh02_instit
     INNER JOIN contabancaria ON rh138_contabancaria = db83_sequencial
     LEFT JOIN rhpesrescisao ON rhpesrescisao.rh05_seqpes = rhpessoalmov.rh02_seqpes
  where rh30_vinculo = 'A'
  and rh30_regime = 1
    $wh
";

  $result = db_query($sql);
  $num = pg_numrows($result);
  for($x = 0;$x < pg_numrows($result);$x++){

        db_atutermometro($x,$num,'termometro');
      flush();

    $matric = pg_result($result,$x,'matricula');

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
       rpad(5,4,0)
       $xseparador ||
       case when h13_tpcont::integer = 12 then lpad(1,1,0)
	    when h13_tpcont::integer = 21 then lpad(1,1,0)
	    when h13_tpcont::integer = 19 then lpad(3,1,0)
	    when h13_tpcont::integer = 20 then lpad(2,1,0)
       end
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
    echo $sql;exit;

  $result = db_query($sql);
  $num = pg_numrows($result);
  for($x = 0;$x < pg_numrows($result);$x++){

      db_atutermometro($x,$num,'termometro');
      flush();


  fputs($arquivo,pg_result($result,$x,'todo')."\r\n");
  }
  fclose($arquivo);


}else if ($_POST["vinculo"] == "FP"){ /// Tab.Escolaridade

    $arq = "tmp/FPMMAAAA.txt";
    $arquivo = fopen($arq,'w');

    db_query("drop sequence layout_ina_seq");
    db_query("create sequence layout_ina_seq");

    $sql = "
  SELECT
       'FP'||lpad($mes,2,0)||$ano
       $xseparador ||lpad(rh02_mesusu,2,0)||rh02_anousu
       $xseparador ||lpad(0,3,0)
       $xseparador ||lpad(rh01_regist,10,0)
       $xseparador ||' '
       $xseparador || lpad(z01_cgccpf,11)
       $xseparador ||rpad(z01_nome,80)
       $xseparador || translate(to_char(basegerfsal+ coalesce(basegerfcom,0.00)+coalesce(basegerfsres,0.00)+coalesce(basegerfs13,0.00),'999999999.99'),'.','')
       $xseparador || translate(to_char(basegerfsaldesc + coalesce(basegerfcomdesc,0.00) + coalesce(basegerfsresdesc,0.00) + coalesce(basegerfs13desc,0.00),'9999999.99'),'.','')
       $xseparador || replace(round(basegerfsal/100*$r33_ppatro,2)::varchar,'.','')
       $xseparador || rpad(' ',9)
       $xseparador || rpad(' ',9)
       $xseparador || rpad(' ',40)
       $xseparador || rpad(' ',3)
       $xseparador || rpad(' ',26)
       $xseparador || rpad('*',1)

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

     INNER JOIN
  (SELECT r14_regist,
          round(sum(CASE WHEN r14_pd = 1 THEN r14_valor ELSE 0 END),2) AS provgerfsal,
          round(sum(CASE WHEN r14_pd = 2 THEN r14_valor ELSE 0 END),2) AS descogerfsal,
          round(sum(CASE WHEN r14_rubric = 'R992' THEN r14_valor ELSE 0 END),2) AS basegerfsal,
          round(sum(CASE WHEN r14_rubric = 'R993' THEN r14_valor ELSE 0 END),2) AS basegerfsaldesc
   FROM gerfsal
   WHERE r14_anousu = $ano
     AND r14_mesusu = $mes
     AND r14_instit = ".db_getsession('DB_instit')."
   GROUP BY r14_regist) AS salgerfsal ON r14_regist = rh01_regist
LEFT JOIN
  (SELECT r48_regist,
          round(sum(CASE WHEN r48_pd = 1 THEN r48_valor ELSE 0 END),2) AS provgerfcom,
          round(sum(CASE WHEN r48_pd = 2 THEN r48_valor ELSE 0 END),2) AS descogerfcom,
          round(sum(CASE WHEN r48_rubric = 'R992' THEN r48_valor ELSE 0 END),2) AS basegerfcom,
          round(sum(CASE WHEN r48_rubric = 'R993' THEN r48_valor ELSE 0 END),2) AS basegerfcomdesc
   FROM gerfcom
   WHERE r48_anousu = $ano
     AND r48_mesusu = $mes
     AND r48_instit = ".db_getsession('DB_instit')."
   GROUP BY r48_regist) AS salgerfcom ON r48_regist = rh01_regist
LEFT JOIN
  (SELECT r20_regist,
          round(sum(CASE WHEN r20_pd = 1 THEN r20_valor ELSE 0 END),2) AS provgerfsres,
          round(sum(CASE WHEN r20_pd = 2 THEN r20_valor ELSE 0 END),2) AS descogerfsres,
          round(sum(CASE WHEN r20_rubric = 'R992' THEN r20_valor ELSE 0 END),2) AS basegerfsres,
          round(sum(CASE WHEN r20_rubric = 'R993' THEN r20_valor ELSE 0 END),2) AS basegerfsresdesc
   FROM gerfres
   WHERE r20_anousu = $ano
     AND r20_mesusu = $mes
     AND r20_instit = ".db_getsession('DB_instit')."
   GROUP BY r20_regist) AS salgerfres ON r20_regist = rh01_regist
LEFT JOIN
  (SELECT r35_regist,
          round(sum(CASE WHEN r35_pd = 1 THEN r35_valor ELSE 0 END),2) AS provgerfs13,
          round(sum(CASE WHEN r35_pd = 2 THEN r35_valor ELSE 0 END),2) AS descogerfs13,
          round(sum(CASE WHEN r35_rubric = 'R992' THEN r35_valor ELSE 0 END),2) AS basegerfs13,
          round(sum(CASE WHEN r35_rubric = 'R993' THEN r35_valor ELSE 0 END),2) AS basegerfs13desc
   FROM gerfs13
   WHERE r35_anousu = $ano
     AND r35_mesusu = $mes
     AND r35_instit = ".db_getsession('DB_instit')."
   GROUP BY r35_regist) AS salgerfs13 ON r35_regist = rh01_regist

     INNER JOIN tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
    LEFT JOIN rhpessoalmovcontabancaria ON rh138_rhpessoalmov = rh02_seqpes
					and rh138_instit = rh02_instit
    LEFT JOIN contabancaria ON rh138_contabancaria = db83_sequencial
    LEFT JOIN rhpesrescisao ON rhpesrescisao.rh05_seqpes = rhpessoalmov.rh02_seqpes
  where 1 = 1
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

}else if ($_POST["vinculo"] == "HS"){ /// Tab.Escolaridade

    $arq = "tmp/HISTORICODESALARIO.txt";
    $arquivo = fopen($arq,'w');

    db_query("drop sequence layout_ina_seq");
    db_query("create sequence layout_ina_seq");

    $sql = "
           SELECT lpad(5,4,0)
       $xseparador ||lpad(rh01_regist,8)
       $xseparador ||lpad(0,10)
       $xseparador ||lpad(replace(r14_rubric,'R','9'),4)
       $xseparador ||lpad('06',2)
       $xseparador ||lpad('2015',4)
       $xseparador ||lpad('06',2)
       $xseparador ||lpad('2015',4)
       $xseparador ||lpad('20150630',8)
       $xseparador ||translate(to_char(coalesce(r14_valor,0.00)+ coalesce(r48_valor,0.00)+coalesce(r20_valor,0.00),'999999999.99'),'.','')
       $xseparador || 'N'

       AS todo
FROM rhpessoal
INNER JOIN rhpessoalmov ON rh02_regist = rh01_regist
AND rh02_anousu = 2014
AND rh02_mesusu = 12
AND rh02_instit = 1
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
  AND rhpessoalmov.rh02_instit = 1
  AND gerfsal.r14_regist = rhpessoalmov.rh02_regist
  AND gerfsal.r14_instit = rhpessoalmov.rh02_instit
  LEFT JOIN gerfcom ON gerfcom.r48_anousu = rhpessoalmov.rh02_anousu
  AND gerfcom.r48_mesusu = rhpessoalmov.rh02_mesusu
  AND rhpessoalmov.rh02_instit = 1
  AND gerfcom.r48_regist = rhpessoalmov.rh02_regist
  AND gerfcom.r48_instit = rhpessoalmov.rh02_instit
  LEFT JOIN gerfres ON gerfres.r20_anousu = rhpessoalmov.rh02_anousu
  AND gerfres.r20_mesusu = rhpessoalmov.rh02_mesusu
  AND rhpessoalmov.rh02_instit = 1
  AND gerfres.r20_regist = rhpessoalmov.rh02_regist
  AND gerfres.r20_instit = rhpessoalmov.rh02_instit

INNER JOIN tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
INNER JOIN rhpessoalmovcontabancaria ON rh138_rhpessoalmov = rh02_seqpes
 and rh138_instit = rh02_instit
INNER JOIN contabancaria ON rh138_contabancaria = db83_sequencial
LEFT JOIN rhpesrescisao ON rhpesrescisao.rh05_seqpes = rhpessoalmov.rh02_seqpes
 where 1 = 1
AND rh30_vinculo = 'A'
AND rh30_regime = 1
$wh

union

SELECT lpad(5,4,0)
       $xseparador ||lpad(rh01_regist,8)
       $xseparador ||lpad(0,10)
       $xseparador ||lpad(replace(r35_rubric,'R','9'),4)
       $xseparador ||lpad('06',2)
       $xseparador ||lpad('2015',4)
       $xseparador ||lpad('06',2)
       $xseparador ||lpad('2015',4)
       $xseparador ||lpad('20150630',8)
       $xseparador ||translate(to_char(coalesce(r35_valor,0.00),'999999999.99'),'.','')
       $xseparador || 'S'

       AS todo
FROM rhpessoal
INNER JOIN rhpessoalmov ON rh02_regist = rh01_regist
AND rh02_anousu = 2014
AND rh02_mesusu = 12
AND rh02_instit = 1
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
  AND rhpessoalmov.rh02_instit = 1
  AND gerfs13.r35_regist = rhpessoalmov.rh02_regist
  AND gerfs13.r35_instit = rhpessoalmov.rh02_instit

INNER JOIN tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
INNER JOIN rhpessoalmovcontabancaria ON rh138_rhpessoalmov = rh02_seqpes
 and rh138_instit = rh02_instit
INNER JOIN contabancaria ON rh138_contabancaria = db83_sequencial
LEFT JOIN rhpesrescisao ON rhpesrescisao.rh05_seqpes = rhpessoalmov.rh02_seqpes
 where 1 = 1
AND rh30_vinculo = 'A'
AND rh30_regime = 1
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
      AND r08_anousu = 2015
      AND r08_mesusu = 06
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