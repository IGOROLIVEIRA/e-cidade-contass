<?
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_utils.php");
require_once("dbforms/db_classesgenericas.php");

db_postmemory($HTTP_POST_VARS);

if (isset($geratxt)) {

if ($tipo == 'qw101'){

  db_query("CREATE SEQUENCE teste_seq");
//db_query("\o /tmp/qw101_descontos.txt");
//echo pg_last_error();exit;
$datageracao_ano = date("Y", db_getsession("DB_datausu"));
$datageracao_mes = date("m", db_getsession("DB_datausu"));
$datageracao_dia = date("d", db_getsession("DB_datausu"));

$sSql = "
SELECT distinct 'H' 
|| 'QWIA001'
|| '$datageracao_ano'
|| '$datageracao_mes'
|| '$datageracao_dia'
|| rpad(nomeinst,60,' ')
|| $anofolha
|| lpad($mesfolha,2,0)
|| lpad(nextval('teste_seq'),3,'0') AS dado
FROM db_config
WHERE db_config.codigo = ".db_getsession('DB_instit')."

union all 

select x.* from
(SELECT distinct 'D' 
|| lpad(' ',15)
|| rh02_anousu
|| lpad(rh02_mesusu,2,0)
|| coalesce(lpad(translate(trim(to_char(round((r14_valor),2),'99999999.99')),'.',''),15,'0'),'000000000000000')
|| lpad(r14_rubric,6,0)
|| lpad(rh01_regist, 25,'0') 
|| lpad(' ',15)
|| '000'
|| '   '
|| case when rh05_seqpes is not null then lpad('rescisão',41)
    when r45_codigo is not null and rh05_seqpes is null then  lpad('afastamento ',14) || r45_dtafas || ' a ' || r45_dtreto
    else lpad(' ',37)
    end 
|| lpad(nextval('teste_seq'),6,'0') AS dado
FROM rhpessoal
INNER JOIN cgm ON z01_numcgm = rh01_numcgm
INNER JOIN rhpessoalmov ON rh01_regist = rh02_regist
LEFT JOIN rhpesrescisao ON rh02_seqpes = rh05_seqpes
LEFT JOIN db_config ON rh02_instit = db_config.codigo
LEFT JOIN gerfsal ON r14_regist = rh02_regist
      AND r14_pd = 2  
      AND r14_anousu = $anofolha
      AND r14_mesusu = $mesfolha 
      AND r14_rubric in (SELECT r09_rubric
              FROM basesr
              WHERE r09_anousu = $anofolha
                  AND r09_mesusu = $mesfolha
                  AND r09_instit = ".db_getsession('DB_instit')."
                  AND r09_base = 'B702')

LEFT JOIN afasta ON r45_regist = rh02_regist
      AND date_part('year', r45_dtafas) = '$anofolha' 
        AND date_part('month', r45_dtafas) = '$mesfolha' 

WHERE rh02_instit = ".db_getsession('DB_instit')."
    AND rh02_codreg NOT IN (0)
    AND rh02_anousu = $anofolha
    AND rh02_mesusu = $mesfolha) as x
    where x.dado is not null


union all

select x.* from
(SELECT distinct 'D' 
|| lpad(' ',15)
|| rh02_anousu
|| lpad(rh02_mesusu,2,0)
|| coalesce(lpad(translate(trim(to_char(round((r20_valor),2),'99999999.99')),'.',''),15,'0'),'000000000000000')
|| lpad(r20_rubric,6,0)
|| lpad(rh01_regist, 25,'0') 
|| lpad(' ',15)
|| '000'
|| '   '
|| case when rh05_seqpes is not null then lpad('rescisão',41)
    when r45_codigo is not null and rh05_seqpes is null then  lpad('afastamento ',14) || r45_dtafas || ' a ' || r45_dtreto
    else lpad(' ',37)
    end 
|| lpad(nextval('teste_seq'),6,'0') AS dado
FROM rhpessoal
INNER JOIN cgm ON z01_numcgm = rh01_numcgm
INNER JOIN rhpessoalmov ON rh01_regist = rh02_regist
LEFT JOIN rhpesrescisao ON rh02_seqpes = rh05_seqpes
LEFT JOIN db_config ON rh02_instit = db_config.codigo
LEFT JOIN gerfres ON r20_regist = rh02_regist
      AND r20_pd = 2  
      AND r20_anousu = $anofolha
      AND r20_mesusu = $mesfolha 
      AND r20_rubric in (SELECT r09_rubric
              FROM basesr
              WHERE r09_anousu = $anofolha
                  AND r09_mesusu = $mesfolha
                  AND r09_instit = ".db_getsession('DB_instit')."
                  AND r09_base = 'B702')
LEFT JOIN afasta ON r45_regist = rh02_regist
      AND date_part('year', r45_dtafas) = '$anofolha' 
        AND date_part('month', r45_dtafas) = '$mesfolha' 
WHERE rh02_instit = ".db_getsession('DB_instit')."
    AND rh02_codreg NOT IN (0)
    AND rh02_anousu = $anofolha
    AND rh02_mesusu = $mesfolha) as x
    where x.dado is not null
union all
select distinct 
'T'
|| '$datageracao_ano'
|| '$datageracao_mes'
|| '$datageracao_dia'
|| trim(lpad(count(x.*),6)) 
|| coalesce(lpad(translate(trim(to_char(round((sum(x.valor)),2),'99999999.99')),'.',''),15,'0'),'000000000000000') 
from
    (SELECT DISTINCT r14_valor as valor
    FROM rhpessoal
    INNER JOIN cgm ON z01_numcgm = rh01_numcgm
    INNER JOIN rhpessoalmov ON rh01_regist = rh02_regist
    LEFT JOIN rhpesrescisao ON rh02_seqpes = rh05_seqpes
    LEFT JOIN db_config ON rh02_instit = db_config.codigo
    LEFT JOIN gerfsal ON r14_regist = rh02_regist
    AND r14_pd = 2
    AND r14_anousu = $anofolha
    AND r14_mesusu = $mesfolha
    AND r14_rubric IN
        (SELECT r09_rubric
         FROM basesr
         WHERE r09_anousu = $anofolha
             AND r09_mesusu = $mesfolha
             AND r09_instit = 1
             AND r09_base = 'B702')
    LEFT JOIN afasta ON r45_regist = rh02_regist
    AND date_part('year', r45_dtafas) = '$anofolha'
    AND date_part('month', r45_dtafas) = '$mesfolha' WHERE rh02_instit = 1
    AND rh02_codreg NOT IN (0)
    AND rh02_anousu = $anofolha
    AND rh02_mesusu = $mesfolha
    UNION ALL
    SELECT DISTINCT 
    r20_valor as valor
    FROM rhpessoal
    INNER JOIN cgm ON z01_numcgm = rh01_numcgm
    INNER JOIN rhpessoalmov ON rh01_regist = rh02_regist
    LEFT JOIN rhpesrescisao ON rh02_seqpes = rh05_seqpes
    LEFT JOIN db_config ON rh02_instit = db_config.codigo
    LEFT JOIN gerfres ON r20_regist = rh02_regist
    AND r20_pd = 2
    AND r20_anousu = $anofolha
    AND r20_mesusu = $mesfolha
    AND r20_rubric IN
        (SELECT r09_rubric
         FROM basesr
         WHERE r09_anousu = $anofolha
             AND r09_mesusu = $mesfolha
             AND r09_instit = ".db_getsession('DB_instit')."
             AND r09_base = 'B702')
    LEFT JOIN afasta ON r45_regist = rh02_regist
    AND date_part('year', r45_dtafas) = '$mesfolha'
    AND date_part('month', r45_dtafas) = '$mesfolha' WHERE rh02_instit = ".db_getsession('DB_instit')."
    AND rh02_codreg NOT IN (0)
    AND rh02_anousu = $anofolha
    AND rh02_mesusu = $mesfolha) as x

;

";
$result = db_query($sSql);
  unlink("tmp/arqw101s.csv");
  // Abre o arquivo para leitura e escrita
  $f = fopen("tmp/arqw101s.csv", "x");

  // Lê o conteúdo do arquivo
  $content = "";
  if(filesize("tmp/arqw101s.csv") > 0)
  $content = fread($f, filesize("tmp/arqw101s.csv"));

  for ($iCont = 0; $iCont < pg_num_rows($result); $iCont++) {

        $oDados = db_utils::fieldsMemory($result, $iCont);

        //echo $oDados->dado;
        // Escreve no arquivo
        fwrite($f, $oDados->dado."\n");

  }

  // Libera o arquivo
  fclose($f);

  //db_criatabela($result);exit;
  //echo pg_last_error();exit;

  echo "
  <script >
  window.open('tmp/arqw101s.csv','','location=yes, width=800,height=600,scrollbars=yes'); 
  </script>";

  db_query("DROP SEQUENCE teste_seq;");

}else if ($tipo == 'qw301'){

  db_query("CREATE SEQUENCE teste_seq");
//db_query("\o /tmp/qw101_descontos.txt");
//echo pg_last_error();exit;
$datageracao_ano = date("Y", db_getsession("DB_datausu"));
$datageracao_mes = date("m", db_getsession("DB_datausu"));
$datageracao_dia = date("d", db_getsession("DB_datausu"));

$sSql = "
SELECT DISTINCT 'H' || 'QWF301S' 
|| '$datageracao_ano'
|| '$datageracao_mes'
|| '$datageracao_dia' 
|| 'FOLHA'|| '          ' || rpad(nomeinst,60)
|| $anofolha 
|| lpad($mesfolha,2,0)  AS dado
FROM db_config
WHERE db_config.codigo = 1

    UNION ALL

    select x.* from 
(SELECT DISTINCT 'D' 
    || CASE
        WHEN rh05_seqpes IS NOT NULL THEN 'D'
        WHEN r45_codigo IS NOT NULL and rh05_seqpes IS NULL THEN 'F'
        ELSE 'A'
    END
    || coalesce('000000000000000',null)
    || coalesce(lpad(rh01_regist, 25,'0'),' ')
    || coalesce(lpad(z01_cgccpf, 14,'0'),' ')
    || coalesce(rpad(z01_nome, 60),' ')
    || coalesce(replace(z01_nasc::varchar,'-',''),' ')
    || rpad(' ', 32)
    || lpad(rh02_tpcont, 2, '0')
    || rpad('$anofolha$mesfolha', 6)
    || rpad(' ', 15, '0')
    || rpad(' ', 1 ,'+')
    || lpad(nextval('teste_seq'),6,'0') AS dado
    FROM rhpessoal
    INNER JOIN cgm ON z01_numcgm = rh01_numcgm
    INNER JOIN rhpessoalmov ON rh01_regist = rh02_regist
    LEFT JOIN rhpesrescisao ON rh02_seqpes = rh05_seqpes
          AND date_part('year', rh05_recis) = '$anofolha' 
          AND date_part('month', rh05_recis) = '$mesfolha'   
    LEFT JOIN db_config ON rh02_instit = db_config.codigo
    LEFT JOIN afasta ON r45_regist = rh02_regist
    AND date_part('year', r45_dtafas) = '$anofolha'
    AND date_part('month', r45_dtafas) = '$mesfolha' WHERE rh02_instit = ".db_getsession('DB_instit')."
    AND rh02_codreg NOT IN (0)
    AND rh02_anousu = $anofolha
    AND rh02_mesusu = $mesfolha) as x 
where x.dado is not  null

    UNION ALL

    SELECT DISTINCT 'T' 
    || '$datageracao_ano'
    || '$datageracao_mes'
    || '$datageracao_dia' 
    || trim(lpad(count(x.*),6)) 
    FROM
        (SELECT DISTINCT 'D' 
    || CASE
        WHEN rh05_seqpes IS NOT NULL THEN 'D'
        WHEN r45_codigo IS NOT NULL and rh05_seqpes IS NULL THEN 'F'
        ELSE 'A'
    END
    || coalesce('000000000000000',null)
    || coalesce(lpad(rh01_regist, 25,'0'),' ')
    || coalesce(lpad(z01_cgccpf, 14,'0'),' ')
    || coalesce(rpad(z01_nome, 60),' ')
    || coalesce(replace(z01_nasc::varchar,'-',''),' ')
    || rpad(' ', 32)
    || lpad(rh02_tpcont, 2)
    || rpad('$anofolha$mesfolha', 6)
    || rpad(' ', 15)
    || rpad(' ', 1)
    || lpad(nextval('teste_seq'),6,'0') AS dado
         FROM rhpessoal
      INNER JOIN cgm ON z01_numcgm = rh01_numcgm
      INNER JOIN rhpessoalmov ON rh01_regist = rh02_regist
      LEFT JOIN rhpesrescisao ON rh02_seqpes = rh05_seqpes
            AND date_part('year', rh05_recis) = '$anofolha' 
            AND date_part('month', rh05_recis) = '$mesfolha'   
      LEFT JOIN db_config ON rh02_instit = db_config.codigo
      LEFT JOIN afasta ON r45_regist = rh02_regist
      AND date_part('year', r45_dtafas) = '$anofolha'
      AND date_part('month', r45_dtafas) = '$mesfolha' WHERE rh02_instit = ".db_getsession('DB_instit')."
      AND rh02_codreg NOT IN (0)
      AND rh02_anousu = $anofolha
      AND rh02_mesusu = $mesfolha) AS x ;

";

$result = db_query($sSql);
  unlink("tmp/arqw301s.csv");
  // Abre o arquivo para leitura e escrita
  $f = fopen("tmp/arqw301s.csv", "x");

  // Lê o conteúdo do arquivo
  $content = "";
  if(filesize("tmp/arqw301s.csv") > 0)
  $content = fread($f, filesize("tmp/arqw301s.csv"));

  for ($iCont = 0; $iCont < pg_num_rows($result); $iCont++) {

        $oDados = db_utils::fieldsMemory($result, $iCont);

        //echo $oDados->dado;
        // Escreve no arquivo
        fwrite($f, $oDados->dado."\n");

  }

  // Libera o arquivo
  fclose($f);

  //db_criatabela($result);exit;
  //echo pg_last_error();exit;

  echo "<script>
  window.open('tmp/arqw301s.csv','','width=800,height=600,scrollbars=yes'); 
  </script>";

  db_query("DROP SEQUENCE teste_seq;");

}else if ($tipo == 'qw601'){

  db_query("CREATE SEQUENCE teste_seq");
//db_query("\o /tmp/qw101_descontos.txt");
//echo pg_last_error();exit;
$datageracao_ano = date("Y", db_getsession("DB_datausu"));
$datageracao_mes = date("m", db_getsession("DB_datausu"));
$datageracao_dia = date("d", db_getsession("DB_datausu"));

$sSql = "
SELECT DISTINCT 'H' || 'QWI601S' 
|| '$datageracao_ano'
|| '$datageracao_mes'
|| '$datageracao_dia' 
|| 'FOLHA'|| '          ' 
|| rpad(nomeinst,60)
|| $anofolha 
|| lpad($mesfolha,2,0)  AS dado
FROM db_config
WHERE db_config.codigo = ".db_getsession('DB_instit')."
UNION ALL
SELECT x.*
    FROM
        (SELECT DISTINCT 'D' 
          || lpad(rh01_regist, 15,'0') 
          || lpad(' ',15) 
          || rh02_anousu 
          || lpad(rh02_mesusu,2,0)
          || CASE
                   WHEN r14_pd = 1 THEN 'P'
                   WHEN r14_pd = 2 THEN 'D'
               END 
            || lpad(r14_rubric,15,'0')
            || coalesce(lpad(translate(trim(to_char(round(r14_valor,2),'99999999.99')),'.',''),15,'0'),'000000000000000')
            || lpad(nextval('teste_seq'),6,'0') AS dado
         FROM rhpessoal
         INNER JOIN cgm ON z01_numcgm = rh01_numcgm
         INNER JOIN rhpessoalmov ON rh01_regist = rh02_regist
         LEFT JOIN rhpesrescisao ON rh02_seqpes = rh05_seqpes
         LEFT JOIN db_config ON rh02_instit = db_config.codigo
         LEFT JOIN gerfsal ON r14_regist = rh02_regist
         AND r14_pd in (1,2)
         AND r14_anousu = $anofolha
         AND r14_mesusu = $mesfolha
         WHERE rh02_instit = ".db_getsession('DB_instit')."
             AND rh02_codreg NOT IN (0)
             AND rh02_anousu = $anofolha
             AND rh02_mesusu = $mesfolha) AS x WHERE x.dado IS NOT NULL
UNION ALL

SELECT x.*
    FROM
        (SELECT DISTINCT 'D' 
          || lpad(rh01_regist, 15,'0') 
          || lpad(' ',15) 
          || rh02_anousu 
          || lpad(rh02_mesusu,2,0)
          || CASE
                   WHEN r48_pd = 1 THEN 'P'
                   WHEN r48_pd = 2 THEN 'D'
               END 
            || lpad(r48_rubric,15,'0')
            || coalesce(lpad(translate(trim(to_char(round(r48_valor,2),'99999999.99')),'.',''),15,'0'),'000000000000000')
            || lpad(nextval('teste_seq'),6,'0') AS dado
         FROM rhpessoal
         INNER JOIN cgm ON z01_numcgm = rh01_numcgm
         INNER JOIN rhpessoalmov ON rh01_regist = rh02_regist
         LEFT JOIN rhpesrescisao ON rh02_seqpes = rh05_seqpes
         LEFT JOIN db_config ON rh02_instit = db_config.codigo
         LEFT JOIN gerfcom ON r48_regist = rh02_regist
         AND r48_pd in (1,2)
         AND r48_anousu = $anofolha
         AND r48_mesusu = $mesfolha
         WHERE rh02_instit = ".db_getsession('DB_instit')."
             AND rh02_codreg NOT IN (0)
             AND rh02_anousu = $anofolha
             AND rh02_mesusu = $mesfolha) AS x WHERE x.dado IS NOT NULL
             
UNION ALL    

SELECT x.*
    FROM
        (SELECT DISTINCT 'D' 
          || lpad(rh01_regist, 15,'0') 
          || lpad(' ',15) 
          || rh02_anousu 
          || lpad(rh02_mesusu,2,0)
          || CASE
                   WHEN r20_pd = 1 THEN 'P'
                   WHEN r20_pd = 2 THEN 'D'
               END 
            || lpad(r20_rubric,15,'0')
            || coalesce(lpad(translate(trim(to_char(round(r20_valor,2),'99999999.99')),'.',''),15,'0'),'000000000000000')
            || lpad(nextval('teste_seq'),6,'0') AS dado
         FROM rhpessoal
         INNER JOIN cgm ON z01_numcgm = rh01_numcgm
         INNER JOIN rhpessoalmov ON rh01_regist = rh02_regist
         LEFT JOIN rhpesrescisao ON rh02_seqpes = rh05_seqpes
         LEFT JOIN db_config ON rh02_instit = db_config.codigo
         LEFT JOIN gerfres ON r20_regist = rh02_regist
         AND r20_pd in (1,2)
         AND r20_anousu = $anofolha
         AND r20_mesusu = $mesfolha
         WHERE rh02_instit = ".db_getsession('DB_instit')."
             AND rh02_codreg NOT IN (0)
             AND rh02_anousu = $anofolha
             AND rh02_mesusu = $mesfolha) AS x WHERE x.dado IS NOT NULL
             
UNION ALL

SELECT DISTINCT 'T' 
|| '2017' || '08' || '16' 
|| trim(lpad(count(x.*),6))
    FROM
        (SELECT DISTINCT 'D' 
          || lpad(rh01_regist, 15,'0') 
          || lpad(' ',15) 
          || rh02_anousu || rh02_mesusu 
          || CASE
                   WHEN r14_pd = 1 THEN 'P'
                   WHEN r14_pd = 2 THEN 'D'
               END 
            || lpad(r14_rubric,15,'0')
            || coalesce(lpad(translate(trim(to_char(round(r14_valor,2),'99999999.99')),'.',''),15,'0'),'000000000000000') as dado
         FROM rhpessoal
         INNER JOIN cgm ON z01_numcgm = rh01_numcgm
         INNER JOIN rhpessoalmov ON rh01_regist = rh02_regist
         LEFT JOIN rhpesrescisao ON rh02_seqpes = rh05_seqpes
         LEFT JOIN db_config ON rh02_instit = db_config.codigo
         LEFT JOIN gerfsal ON r14_regist = rh02_regist
         AND r14_pd in (1,2)
         AND r14_anousu = $anofolha
         AND r14_mesusu = $mesfolha
         WHERE rh02_instit = ".db_getsession('DB_instit')."
             AND rh02_codreg NOT IN (0)
             AND rh02_anousu = $anofolha
             AND rh02_mesusu = $mesfolha
           ) AS x ;

";

$result = db_query($sSql);
  unlink("arqw601s.csv");
  // Abre o arquivo para leitura e escrita
  $f = fopen("arqw601s.csv", "x");

  // Lê o conteúdo do arquivo
  $content = "";
  if(filesize("arqw601s.csv") > 0)
  $content = fread($f, filesize("arqw601s.csv"));

  for ($iCont = 0; $iCont < pg_num_rows($result); $iCont++) {

        $oDados = db_utils::fieldsMemory($result, $iCont);

        //echo $oDados->dado;
        // Escreve no arquivo
        fwrite($f, $oDados->dado."\n");

  }

  // Libera o arquivo
  fclose($f);

  //db_criatabela($result);exit;
  //echo pg_last_error();exit;

  echo "<script>
  window.open('arqw601s.csv','','width=800,height=600,scrollbars=yes'); 
  </script>";

  db_query("DROP SEQUENCE teste_seq;");

}else if($tipo == 1){

db_query("CREATE SEQUENCE teste_seq");
//db_query("\o /tmp/qw101_descontos.txt");
//echo pg_last_error();exit;
$sSql = "
select   'D' 
      || 'A' 
      || '000000000000000' 
      || lpad(rh01_regist , 25,'0')
      || lpad(z01_cgccpf,14,'0')
      || rpad(z01_nome,60,' ')
      || coalesce(to_char(rh01_nasc,'YYYYmmdd'),'        ')
      || '                                '
      || case rh02_codreg
          when  1 then '1 '
          when  2 then '1 '
      when  3 then '1 '
      when  4 then '1 '
          when  5 then '3 '
      when  6 then '3 '
          when  7 then '3 '
          when  8 then '1 '
          when  9 then '3 '
          when 10 then '3 '
          when 11 then '1 '
          when $mesfolha then '2 '
          when 13 then '2 '
    when 27 then '1 '
          else '1 '
       end
      || lpad(rh02_anousu,4,'0')||lpad(rh02_mesusu,2,'0')
      || coalesce(lpad(translate(trim(to_char(round((bruto - descontos ),2),'99999999.99')),'.',''),15,'0'),'000000000000000')
      || case when ( bruto - descontos) < 0 then '-' else '+' end
      || lpad(nextval('teste_seq'),6,'0') AS dado

from rhpessoal 
     inner join cgm            on z01_numcgm  = rh01_numcgm 
     inner join rhpessoalmov   on rh01_regist = rh02_regist 
     left join rhpesrescisao   on rh02_seqpes = rh05_seqpes 
     left join (select r53_regist, 
             round(sum(r53_valor),2) as bruto
      from gerffx 
      where r53_anousu = $anofolha
        and r53_mesusu = $mesfolha
        and r53_rubric in (select r09_rubric 
                           from basesr 
                           where r09_anousu = $anofolha
                             and r09_mesusu = $mesfolha
                             and r09_instit = ".db_getsession('DB_instit')."
                             and r09_base = 'B700')
      group by r53_regist ) as fx on r53_regist = rh01_regist
      left join (select r14_regist,
                 round(sum(r14_valor),2) as descontos 
        from gerfsal 
        where r14_anousu = $anofolha
          and r14_mesusu = $mesfolha
          and r14_rubric in (select r09_rubric 
                             from basesr 
                             where r09_anousu = $anofolha
                               and r09_mesusu = $mesfolha
                               and r09_instit = ".db_getsession('DB_instit')."
                               and r09_base   = 'B701'
                             ) 
       group by r14_regist ) as sal on r14_regist = rh01_regist
      
where rh05_seqpes is null 
  and rh02_instit = ".db_getsession('DB_instit')."
  and rh02_codreg not in (0)
  and rh02_anousu = $anofolha
  and rh02_mesusu = $mesfolha
;

";

$result = db_query($sSql);
  unlink("margem_mensal.csv");
  // Abre o arquivo para leitura e escrita
  $f = fopen("margem_mensal.csv", "x");

  // Lê o conteúdo do arquivo
  $content = "";
  if(filesize("margem_mensal.csv") > 0)
  $content = fread($f, filesize("margem_mensal.csv"));

  for ($iCont = 0; $iCont < pg_num_rows($result); $iCont++) {

        $oDados = db_utils::fieldsMemory($result, $iCont);

        //echo $oDados->dado;
        // Escreve no arquivo
        fwrite($f, $oDados->dado."\n");

  }

  // Libera o arquivo
  fclose($f);

  //db_criatabela($result);exit;
  //echo pg_last_error();exit;

  echo "<script>
  window.open('margem_mensal.csv','','width=800,height=600,scrollbars=yes'); 
  </script>";

  db_query("DROP SEQUENCE teste_seq;");

}else {

  db_query("CREATE SEQUENCE teste_seq");
//db_query("\o /tmp/qw101_descontos.txt");
//echo pg_last_error();exit;
$sSql = "
select 'D'
       ||r14_anousu
       ||lpad(r14_mesusu,2,'0')
       ||coalesce(lpad(translate(trim(to_char(round(r14_valor,2),'99999999.99')),'.',''),15,'0'),'000000000000000')
       ||'000'
       ||lpad(r14_rubric,6,'0')
       ||lpad(trim(to_char(r14_regist,'9999999999')),25,'0')
       || lpad(nextval('teste_seq'),6,'0') AS dado
from gerfsal 
     inner join rhrubricas on rh27_rubric = r14_rubric and rh27_instit = r14_instit
     inner join rhpessoal  on rh01_regist = r14_regist
     inner join cgm        on rh01_numcgm = z01_numcgm

where r14_anousu = $anofolha
  and r14_mesusu = $mesfolha and r14_instit = ".db_getsession("DB_instit")."
  and r14_rubric in (select r09_rubric 
                     from basesr 
                     where r09_anousu = $anofolha
                       and r09_mesusu = $mesfolha
                       and r09_instit = ".db_getsession("DB_instit")."
                       and r09_base   = 'B702'
                     ) 
order by r14_rubric;

";
$result = db_query($sSql);

  unlink("valores_d.csv");
// Abre o arquivo para leitura e escrita
  $f = fopen("valores_d.csv", "x");

  // Lê o conteúdo do arquivo
  $content = "";
  if(filesize("valores_d.csv") > 0)
  $content = fread($f, filesize("valores_d.csv"));

  for ($iCont = 0; $iCont < pg_num_rows($result); $iCont++) {

        $oDados = db_utils::fieldsMemory($result, $iCont);

        //echo $oDados->dado;
        // Escreve no arquivo
        fwrite($f, $oDados->dado."\n");

  }

  // Libera o arquivo
  fclose($f);

  //db_criatabela($result);exit;
  //echo pg_last_error();exit;

  echo "<script>
  window.open('valores_d.csv','','width=800,height=600,scrollbars=yes'); 
  </script>";

db_query("DROP SEQUENCE teste_seq;");

}


}

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<style>

 .formTable td {
   text-align: left;
  }

</style>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">

<form name="form1" >

<center>

  <fieldset style="margin-top: 50px; width: 40%">
  <legend style="font-weight: bold;">Quantum </legend>

    <table align="left" class='formTable'>
        <?php
        $geraform = new cl_formulario_rel_pes;
        ?>
        <tr>
        <td align="right" nowrap="" title="Tipo">
        <strong>Tipo:</strong>
        </td>
        <td>
          <select name="tipo" >
            <option value="qw101" >qw101</option>
            <option value="qw301" >qw301</option>
            <option value="qw601" >qw601</option>
            <option value="1" >Margem mensal</option>
            <option value="2" >Valores Descontados</option>
          </select>
        </td>
        </tr>
        <?php
        $geraform->gera_form($anofolha,$mesfolha);
        ?>

    </table>

  </fieldset>

  <table style="margin-top: 10px;">
    <tr>
      <td colspan="2" align = "center">
        <!-- <input  name="emite2" id="emite2" type="button" value="Processar" onclick="js_emite();" > -->
        <input  name="geratxt" id="geratxt" type="submit" value="Processar" >
      </td>
    </tr>
  </table>

</center>
</form>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
