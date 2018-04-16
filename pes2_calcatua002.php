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

include("fpdf151/pdf.php");
include("libs/db_libpessoal.php");
include("classes/db_selecao_classe.php");
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
$clselecao = new cl_selecao();
//db_postmemory($HTTP_SERVER_VARS,2);exit;

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<br><br><br>
<center>
<? 
db_criatermometro('calculo_folha','Concluido...','blue',1,'Efetuando Geracao calc_ativos.txt');
db_criatermometro('calculo_folha1','Concluido...','blue',1,'Efetuando Geracao calc_inativos.txt');
db_criatermometro('calculo_folha2','Concluido...','blue',1,'Efetuando Geracao calc_pens.txt');
?>

</center>
</body>
<?
$where = " ";
if(trim($selecao) != ""){
  $result_selecao = $clselecao->sql_record($clselecao->sql_query_file($selecao," r44_descr, r44_where ",db_getsession("DB_instit")));
  if($clselecao->numrows > 0){
    db_fieldsmemory($result_selecao, 0);
    $where = " and ".$r44_where;
    $head8 = "SELEÇÃO: ".$selecao." - ".$r44_descr;
  }
}

$db_erro = false;

if($banco == 1){
$erro_msg = calcatua_bb($anofolha,$mesfolha,$where);
}else{
$erro_msg = calcatua_cef($mesfolha,$anofolha,$where);
}

if(empty($erro_msg)){
  echo "
  <script>
    parent.js_detectaarquivo('/tmp/calc_ativos.txt','/tmp/calc_inativos.txt','/tmp/calc_pens.txt');
  </script>
  ";
}else{
  echo "
  <script>
    parent.js_erro('$erro_msg');
  </script>
  ";
}
//echo "<BR> antes do fim db_fim_transacao()";
//flush();
db_redireciona("pes2_calcatua001.php");


function calcatua_bb($anofolha,$mesfolha,$where){

  $arq = '/tmp/calc_ativos.txt';
  $arquivo = fopen($arq,'w');  

/*pg_query("drop sequence layout_ati_seq");
pg_query("create sequence layout_ati_seq");*/

$sql = " SELECT rh01_regist AS matricula,
       '1'||'#' 
       ||'1'||'#' 
       ||instituicao.z01_cgccpf||'#' 
       ||instituicao.z01_nome||'#' 
       ||'1'||'#' 
       ||'1'||'#' 
       ||'1'||'#' 
       ||case when rhfuncao.rh37_funcaogrupo != 2 then 4 else 2 end||'#' 
       ||' '||'#' 
       ||' '||'#' 
       ||lpad(rh01_regist::text,9,'0') ||'#' 
       ||servidor.z01_cgccpf||'#' 
       ||coalesce(servidor.z01_pis,' ')||'#' 
       ||CASE
          WHEN rh01_sexo = 'M' THEN 2
          ELSE 1
          END ||'#'
       ||rh01_estciv||'#'
       ||to_char(rh01_nasc, 'DD/MM/YYYY')||'#' 
       ||'1'||'#' 
       ||' '||'#' 
       ||to_char(rh01_admiss, 'DD/MM/YYYY')||'#' 
       ||to_char(rh01_admiss, 'DD/MM/YYYY')||'#' 
       ||rhfuncao.rh37_descr||'#' 
       ||to_char(rh01_admiss, 'DD/MM/YYYY')||'#' 
       ||rhfuncao.rh37_descr||'#' 
       ||trim(translate(to_char(round(sal.salariobase,2),'999999999.99'),'.',','))||'#' 
       ||trim(translate(to_char(round(sal.total,2),'999999999.99'),'.',','))||'#' 
       ||' '||'#' 
       ||' '||'#' 
       ||coalesce( 
  (select (count(*)||'#' ||coalesce(to_char(( select rh31_dtnasc from rhdepend as depend 
    where depend.rh31_regist=rhdependente.rh31_regist and rh31_gparen='C' limit 1), 'DD/MM/YYYY'),' ')||'#' 
  ||coalesce((select case when rh31_especi = 'N' then '1' else '2' end as cond from rhdepend depend 
    where depend.rh31_regist=rhdependente.rh31_regist and rh31_gparen='C' limit 1),' ')||'#' 
  ||to_char(max(rh31_dtnasc),'DD/MM/YYYY')||'#' 
  ||(select case when rh31_especi = 'N' then '1' else '2' end as cond from rhdepend as depend 
    where depend.rh31_regist=rhdependente.rh31_regist and depend.rh31_dtnasc = 
    (select max(rh31_dtnasc) from rhdepend as dependmax where dependmax.rh31_regist=depend.rh31_regist) limit 1)||'#' 
  ||coalesce(to_char(( select rh31_dtnasc from rhdepend as depend where depend.rh31_regist=rhdependente.rh31_regist 
    and rh31_gparen='O' limit 1), 'DD/MM/YYYY'),' ')||'#' 
  ||coalesce((select case when rh31_especi = 'N' then '1' else '2' end as cond from rhdepend as depend 
    where depend.rh31_regist=rhdependente.rh31_regist and rh31_gparen='O' limit 1),' ')) as dependentes FROM rhdepend rhdependente 
  WHERE rhdependente.rh31_regist=rh01_regist group by rh31_regist limit 1),' # # # # # # ')||'#'
       ||' '||'#' 
       ||' ' AS todo
FROM rhpessoal
INNER JOIN rhpessoalmov ON rh02_regist = rh01_regist
AND rh02_anousu = $anofolha
AND rh02_mesusu = $mesfolha
AND rh01_instit = ".db_getsession("DB_instit")."
INNER JOIN rhlota ON r70_codigo = rh02_lota
AND r70_instit = rh02_instit
INNER JOIN rhfuncao ON rh37_funcao = rh01_funcao
AND rh37_instit = rh02_instit
INNER JOIN rhregime ON rh30_codreg = rh02_codreg
AND rh30_instit = rh02_instit
INNER JOIN
    (SELECT r14_regist,
            sum(CASE
                    WHEN r14_rubric = 'R985' THEN r14_valor
                    ELSE 0
                END) AS salariobase,
            sum(case when r14_pd = 1 then r14_valor else 0 end) as total
     FROM gerfsal
     WHERE r14_anousu = $anofolha
         AND r14_mesusu = $mesfolha
     GROUP BY r14_regist) AS sal ON r14_regist = rh01_regist

     join db_config on codigo = rh01_instit
     join cgm instituicao on db_config.numcgm=instituicao.z01_numcgm
     join cgm servidor on servidor.z01_numcgm = rh01_numcgm
where rh30_vinculo = 'A'
  and rh30_regime = 1
  $where ";
  
//  echo $sql;exit;
  $result = pg_query($sql);
  $num = pg_numrows($result);
  for($x = 0;$x < pg_numrows($result);$x++){
//    echo 'Total de : '.$num.' / '.$x."\r";
   db_atutermometro($x,$num,'calculo_folha',1);
	$todo = pg_result($result,$x,'todo');	
  if (empty($todo)) {
    continue;
  }
  fputs($arquivo,$todo."\r\n");
  }
  fclose($arquivo);


//echo "\n\n"."inativos "."\n\n";

  $arq1 = '/tmp/calc_inativos.txt';

//echo "arquivo : ".$arq."\n\n";

  $arquivo = fopen($arq1,'w');  

/*pg_query("drop sequence layout_ina_seq");
pg_query("create sequence layout_ina_seq");*/
//echo "entrou no select"."\n\n";

$sql = "SELECT rh01_regist AS matricula,
       '1'||'#' 
       ||'3'||'#' 
       ||instituicao.z01_cgccpf||'#' 
       ||instituicao.z01_nome||'#' 
       ||'1'||'#' 
       ||'1'||'#' 
       ||'5'||'#' 
       ||'3'||'#' 
       ||case 
          when rh02_rhtipoapos = 4 then 1
          when rh02_rhtipoapos = 5 then 2
          when rh02_rhtipoapos = 2 then 3
          when rh02_rhtipoapos = 3 then 4
          else 5 end||'#' 
       ||' '||'#' 
       ||rh01_regist||'#' 
       ||servidor.z01_cgccpf||'#' 
       ||coalesce(servidor.z01_pis,' ')||'#' 
       ||CASE
          WHEN rh01_sexo = 'M' THEN 2
          ELSE 2
          END ||'#'
       ||rh01_estciv||'#'
       ||to_char(rh01_nasc, 'DD/MM/YYYY')||'#'
       ||to_char(rh01_admiss, 'DD/MM/YYYY')||'#' 
       ||trim(translate(to_char(round(sal.prov,2),'999999999.99'),'.',','))||'#' 
       ||'0'||'#' 
       ||' '||'#' 
       ||' '||'#' 
       ||' '||'#' 
       ||to_char(rh01_admiss, 'DD/MM/YYYY')||'#'
       ||' '||'#' 
       ||' '||'#' 
       ||coalesce( 
  (select (count(*)||'#' ||coalesce(to_char(( select rh31_dtnasc from rhdepend as depend 
    where depend.rh31_regist=rhdependente.rh31_regist and rh31_gparen='C' limit 1), 'DD/MM/YYYY'),' ')||'#' 
  ||coalesce((select case when rh31_especi = 'N' then '1' else '2' end as cond from rhdepend depend 
    where depend.rh31_regist=rhdependente.rh31_regist and rh31_gparen='C' limit 1),' ')||'#' 
  ||to_char(max(rh31_dtnasc),'DD/MM/YYYY')||'#' 
  ||(select case when rh31_especi = 'N' then '1' else '2' end as cond from rhdepend as depend 
    where depend.rh31_regist=rhdependente.rh31_regist and depend.rh31_dtnasc = 
    (select max(rh31_dtnasc) from rhdepend as dependmax where dependmax.rh31_regist=depend.rh31_regist) limit 1)||'#' 
  ||coalesce(to_char(( select rh31_dtnasc from rhdepend as depend where depend.rh31_regist=rhdependente.rh31_regist 
    and rh31_gparen='O' limit 1), 'DD/MM/YYYY'),' ')||'#' 
  ||coalesce((select case when rh31_especi = 'N' then '1' else '2' end as cond from rhdepend as depend 
    where depend.rh31_regist=rhdependente.rh31_regist and rh31_gparen='O' limit 1),' ')) as dependentes FROM rhdepend rhdependente 
  WHERE rhdependente.rh31_regist=rh01_regist group by rh31_regist limit 1),' # # # # # # ')
        AS todo
FROM rhpessoal
INNER JOIN rhpessoalmov ON rh02_regist = rh01_regist
AND rh02_anousu = $anofolha
AND rh02_mesusu = $mesfolha
AND rh01_instit = ".db_getsession("DB_instit")."
INNER JOIN rhlota ON r70_codigo = rh02_lota
AND r70_instit = rh02_instit
INNER JOIN rhfuncao ON rh37_funcao = rh01_funcao
AND rh37_instit = rh02_instit
INNER JOIN rhregime ON rh30_codreg = rh02_codreg
AND rh30_instit = rh02_instit
INNER JOIN
    (SELECT r14_regist,
            sum(case when r14_pd = 1 then r14_valor else 0 end) as prov,
            sum(case when r14_pd = 2 then r14_valor else 0 end) as desco,
            sum(case when r14_rubric = 'R992' then r14_valor else 0 end ) as base
     FROM gerfsal
     WHERE r14_anousu = $anofolha
         AND r14_mesusu = $mesfolha
     GROUP BY r14_regist) AS sal ON r14_regist = rh01_regist

     join db_config on codigo = rh01_instit
     join cgm instituicao on db_config.numcgm=instituicao.z01_numcgm
     join cgm servidor on servidor.z01_numcgm = rh01_numcgm 
where rh30_vinculo = 'I' 
  $where ";
  
//  echo $sql;exit;
  $result = pg_query($sql);
//  echo "gerou o result"."\n\n";
  $num = pg_numrows($result);
  for($x = 0;$x < pg_numrows($result);$x++){
//    echo 'Total de : '.$num.' / '.$x."\r";
    
   db_atutermometro($x,$num,'calculo_folha1',1);

    $matric = pg_result($result,$x,'matricula');
		
  $todo = pg_result($result,$x,'todo'); 
  if (empty($todo)) {
    continue;
  }
  fputs($arquivo,$todo."\r\n");
  }
  fclose($arquivo);




//echo "pensionistas"."\n\n";

  $arq2 = '/tmp/calc_pens.txt';

//echo "arquivo : ".$arq."\n\n";

  $arquivo = fopen($arq2,'w');  

/*pg_query("drop sequence layout_pen_seq");
pg_query("create sequence layout_pen_seq");*/

//echo "entrou no select"."\n\n";

$sql = " SELECT rh01_regist AS matricula,
       '1'||'#' 
       ||'3'||'#' 
       ||instituicao.z01_cgccpf||'#' 
       ||instituicao.z01_nome||'#' 
       ||'1'||'#' 
       ||'1'||'#' 
       ||'7'||'#' 
       ||'3'||'#' 
       ||' '||'#' 
       ||' '||'#' 
       ||' '||'#' 
       ||rh01_regist||'#' 
       ||servidor.z01_cgccpf||'#' 
       ||CASE
          WHEN rh01_sexo = 'M' THEN 2
          ELSE 1
          END ||'#'
       ||to_char(rh01_nasc, 'DD/MM/YYYY')||'#' 
       ||to_char(rh01_admiss, 'DD/MM/YYYY')||'#'
       ||trim(translate(to_char(round(sal.prov,2),'999999999.99'),'.',','))||'#' 
       ||'0'||'#' 
       ||'0'||'#' 
       ||' '||'#' 
       ||' '||'#' 
       ||case when rh02_rhtipoapos = 4 then 2 else 1 end||'#' 
       ||' ' AS todo
FROM rhpessoal
INNER JOIN rhpessoalmov ON rh02_regist = rh01_regist
AND rh02_anousu = $anofolha
AND rh02_mesusu = $mesfolha
AND rh01_instit = ".db_getsession("DB_instit")."
INNER JOIN rhlota ON r70_codigo = rh02_lota
AND r70_instit = rh02_instit
INNER JOIN rhfuncao ON rh37_funcao = rh01_funcao
AND rh37_instit = rh02_instit
INNER JOIN rhregime ON rh30_codreg = rh02_codreg
AND rh30_instit = rh02_instit
INNER JOIN
    (SELECT r14_regist,
            sum(case when r14_pd = 1 then r14_valor else 0 end) as prov,
            sum(case when r14_pd = 2 then r14_valor else 0 end) as desco,
            sum(case when r14_rubric = 'R992' then r14_valor else 0 end ) as base
     FROM gerfsal
     WHERE r14_anousu = $anofolha
         AND r14_mesusu = $mesfolha
     GROUP BY r14_regist) AS sal ON r14_regist = rh01_regist

     join db_config on codigo = rh01_instit
     join cgm instituicao on db_config.numcgm=instituicao.z01_numcgm
     join cgm servidor on servidor.z01_numcgm = rh01_numcgm
where rh30_vinculo = 'P'
  $where ";
  
//  echo $sql;exit;
  $result = pg_query($sql);
//  echo "gerou o result"."\n\n";
  $num = pg_numrows($result);
  for($x = 0;$x < pg_numrows($result);$x++){
//    echo 'Total de : '.$num.' / '.$x."\r";
    
   db_atutermometro($x,$num,'calculo_folha2',1);

  fputs($arquivo,pg_result($result,$x,'todo')."\r\n");
  }
  fclose($arquivo);

}



function calcatua_cef($mesfolha,$anofolha,$where){

  $arq = '/tmp/calc_ativos.txt';
  $arquivo = fopen($arq,'w'); 

$sql = "
SELECT rh01_regist AS matricula,
     trim(substr(r70_descr,1,20)) ||'#' || trim(substr(rh01_regist,1,40)) ||'#' || '1' ||'#' ||'S' ||'#' ||trim(rh01_sexo) ||'#' ||to_char(rh01_nasc,'DD/MM/YYYY') ||'#' ||
to_char(rh01_admiss,'DD/MM/YYYY') ||'#' ||
to_char(rh01_admiss,'DD/MM/YYYY') ||'#' ||
trim(translate(to_char(round(base,2),'99999999,99'),',','')) ||'#' ||
case
   when rh37_funcaogrupo in (0) then 4
   else rh37_funcaogrupo
end
||'#' ||
' '
||'#' ||
' '
||'#' ||
case
when (select rh31_gparen from rhdepend where rh31_regist = rhpessoal.rh01_regist and rh31_gparen = 'C' limit 1)  is not null then 'S'
else 'N'
end
||'#' ||
case
when (select rh31_gparen from rhdepend where rh31_regist = rhpessoal.rh01_regist and rh31_gparen = 'C' limit 1)  is not null then
(select to_char(rh31_dtnasc,'DD/MM/YYYY') from rhdepend where rh31_regist = rhpessoal.rh01_regist and rh31_gparen = 'C' limit 1)
else ' '
end
||'#' ||
case
when (select to_char(rh31_dtnasc,'DD/MM/YYYY') from rhdepend where rh31_regist = rhpessoal.rh01_regist and rh31_especi <> 'N' order by rh31_dtnasc desc  limit 1)  is not null then
(select to_char(rh31_dtnasc,'DD/MM/YYYY') from rhdepend where rh31_regist = rhpessoal.rh01_regist and rh31_especi <> 'N' order by rh31_dtnasc desc  limit 1)
else ' '
end
||'#' ||
case
when (select to_char(rh31_dtnasc,'DD/MM/YYYY') from rhdepend where rh31_regist = rhpessoal.rh01_regist and rh31_especi = 'N' order by rh31_dtnasc desc  limit 1)  is not null then
(select to_char(rh31_dtnasc,'DD/MM/YYYY') from rhdepend where rh31_regist = rhpessoal.rh01_regist and rh31_especi = 'N' order by rh31_dtnasc desc  limit 1)
else ' '
end
||'#' ||
' ' as todo
       
from rhpessoal 
     inner join cgm          on rh01_numcgm = z01_numcgm 
     inner join rhpessoalmov on rh02_regist = rh01_regist 
                            and rh02_anousu = $anofolha 
			                      and rh02_mesusu = $mesfolha 
     inner join rhlota       on r70_codigo = rh02_lota 
     inner join rhfuncao     on rh37_funcao = rh01_funcao
                            and rh37_instit = rh02_instit
     inner join rhregime on rh30_codreg = rh02_codreg
     inner join (select r14_regist,
                        sum(case when r14_pd != 3 and r14_pd = 1 then r14_valor else 0 end) as prov,
			                  sum(case when r14_pd != 3 and r14_pd = 2 then r14_valor else 0 end) as desco,
                   			sum(case when r14_rubric = 'R992' then r14_valor else 0 end ) as base
                 from gerfsal 
		 where r14_anousu = $anofolha 
		   and r14_mesusu = $mesfolha
		   group by r14_regist ) as sal on r14_regist = rh01_regist 
where rh30_vinculo = 'A' 
  and rh30_regime = 1
  $where
";

  //echo $sql;exit;
  $result = pg_query($sql);
  $num = pg_numrows($result);
  for($x = 0;$x < pg_numrows($result);$x++){
//    echo 'Total de : '.$num.' / '.$x."\r";

   db_atutermometro($x,$num,'calculo_folha',1);
    
    $matric = pg_result($result,$x,'matricula');
    

  fputs($arquivo,pg_result($result,$x,'todo')."\r\n");
  }
  fclose($arquivo);


  $arq1 = '/tmp/calc_inativos.txt';

  $arquivo = fopen($arq1,'w');  
$sql = "
SELECT rh01_regist AS matricula,
     trim(substr(r70_descr,1,20)) ||'#' || trim(substr(rh01_regist,1,40)) ||'#' || trim(rh01_sexo) ||'#' ||to_char(rh01_nasc,'DD/MM/YYYY') ||'#' ||
to_char(rh01_admiss,'DD/MM/YYYY') ||'#' ||
base ||'#' ||
case
   when rh37_funcaogrupo in (0) then 4
   else rh37_funcaogrupo
end
||'#' ||
case
   when rh02_rhtipoapos in (4) then 1
   when rh02_rhtipoapos in (2) then 2
   when rh02_rhtipoapos in (3) then 3
   when rh02_rhtipoapos in (5) then 4
   when rh02_rhtipoapos in (4) then 1
   when rh02_rhtipoapos in (1,0) then 3
end
||'#' ||
' '
||'#' ||
' '
||'#' ||
case
when (select rh31_gparen from rhdepend where rh31_regist = rhpessoal.rh01_regist and rh31_gparen = 'C' limit 1)  is not null then 'S'
else 'N'
end
||'#' ||
case
when (select rh31_gparen from rhdepend where rh31_regist = rhpessoal.rh01_regist and rh31_gparen = 'C' limit 1)  is not null then
(select to_char(rh31_dtnasc,'DD/MM/YYYY') from rhdepend where rh31_regist = rhpessoal.rh01_regist and rh31_gparen = 'C' limit 1)
else 'N'
end
||'#' ||
case
when (select to_char(rh31_dtnasc,'DD/MM/YYYY') from rhdepend where rh31_regist = rhpessoal.rh01_regist and rh31_especi <> 'N' order by rh31_dtnasc desc  limit 1)  is not null then
(select to_char(rh31_dtnasc,'DD/MM/YYYY') from rhdepend where rh31_regist = rhpessoal.rh01_regist and rh31_especi <> 'N' order by rh31_dtnasc desc  limit 1)
else ' '
end
||'#' ||
case
when (select to_char(rh31_dtnasc,'DD/MM/YYYY') from rhdepend where rh31_regist = rhpessoal.rh01_regist and rh31_especi = 'N' order by rh31_dtnasc desc  limit 1)  is not null then
(select to_char(rh31_dtnasc,'DD/MM/YYYY') from rhdepend where rh31_regist = rhpessoal.rh01_regist and rh31_especi = 'N' order by rh31_dtnasc desc  limit 1)
else ' '
end
||'#' ||
' '

AS todo
from rhpessoal 
     inner join cgm          on rh01_numcgm = z01_numcgm 
     inner join rhpessoalmov on rh02_regist = rh01_regist 
                            and rh02_anousu = $anofolha 
			                      and rh02_mesusu = $mesfolha 
     inner join rhlota       on r70_codigo = rh02_lota 
     inner join rhfuncao     on rh37_funcao = rh01_funcao
                            and rh37_instit = rh02_instit
     inner join rhregime on rh30_codreg = rh02_codreg
     inner join (select r14_regist,
                        sum(case when r14_pd != 3 and r14_pd = 1 then r14_valor else 0 end) as prov,
			                  sum(case when r14_pd != 3 and r14_pd = 2 then r14_valor else 0 end) as desco,
                   			sum(case when r14_rubric = 'R981' then r14_valor else 0 end ) as base
                 from gerfsal
		 where r14_anousu = $anofolha
		   and r14_mesusu = $mesfolha
		   group by r14_regist ) as sal on r14_regist = rh01_regist
where rh30_vinculo = 'I'
  and rh30_regime = 1
  $where
";
  
    //echo $sql;exit;
  $result = pg_query($sql);
  $num = pg_numrows($result);
  for($x = 0;$x < pg_numrows($result);$x++){
    //echo 'Total de : '.$num.' / '.$x."\r";
    
    db_atutermometro($x,$num,'calculo_folha1',1);

    $matric = pg_result($result,$x,'matricula');
    

  fputs($arquivo,pg_result($result,$x,'todo')."\r\n");
  }
  fclose($arquivo);




//echo "\n\n"."pensionistas"."\n\n";

  $arq2 = '/tmp/calc_pens.txt';

  $arquivo = fopen($arq2,'w');  
$sql = "
SELECT rh01_regist AS matricula,
' '
||'#' ||
' '
||'#' ||
' '
||'#' ||
' '
||'#' ||
' '
||'#' ||
'1'
||'#' ||
base
||'#' ||
to_char(rh01_admiss,'DD/MM/YYYY')
||'#' ||
trim(rh01_sexo)
||'#' ||
to_char(rh01_nasc,'DD/MM/YYYY')
||'#' ||
case
when (select to_char(rh31_dtnasc,'DD/MM/YYYY') from rhdepend where rh31_regist = rhpessoal.rh01_regist and rh31_especi <> 'N' order by rh31_dtnasc desc  limit 1)  is not null then
(select to_char(rh31_dtnasc,'DD/MM/YYYY') from rhdepend where rh31_regist = rhpessoal.rh01_regist and rh31_especi <> 'N' order by rh31_dtnasc desc  limit 1)
else ' '
end
||'#' ||
case
when (select to_char(rh31_dtnasc,'DD/MM/YYYY') from rhdepend where rh31_regist = rhpessoal.rh01_regist and rh31_especi = 'N' order by rh31_dtnasc desc  limit 1)  is not null then
(select to_char(rh31_dtnasc,'DD/MM/YYYY') from rhdepend where rh31_regist = rhpessoal.rh01_regist and rh31_especi = 'N' order by rh31_dtnasc desc  limit 1)
else ' '
end
||'#' ||
' '
AS todo

from rhpessoal
     inner join cgm          on rh01_numcgm = z01_numcgm
     inner join rhpessoalmov on rh02_regist = rh01_regist
                            and rh02_anousu = $anofolha
                           and rh02_mesusu = $mesfolha
     inner join rhlota       on r70_codigo = rh02_lota
     inner join rhfuncao     on rh37_funcao = rh01_funcao
                            and rh37_instit = rh02_instit
     inner join rhregime on rh30_codreg = rh02_codreg
     inner join (select r14_regist,
                        sum(case when r14_pd != 3 and r14_pd = 1 then r14_valor else 0 end) as prov,
                       sum(case when r14_pd != 3 and r14_pd = 2 then r14_valor else 0 end) as desco,
                         sum(case when r14_rubric = 'R981' then r14_valor else 0 end ) as base
                 from gerfsal
    where r14_anousu = $anofolha
      and r14_mesusu = $mesfolha
      group by r14_regist ) as sal on r14_regist = rh01_regist
where rh30_vinculo = 'P'
  and rh30_regime = 1
  $where
";
  
  //echo $sql;exit;
  $result = pg_query($sql);
  $num = pg_numrows($result);
  for($x = 0;$x < pg_numrows($result);$x++){
  //  echo 'Total de : '.$num.' / '.$x."\r";
    
    db_atutermometro($x,$num,'calculo_folha2',1);

    $matric = pg_result($result,$x,'matricula');
    

  fputs($arquivo,pg_result($result,$x,'todo')."\r\n");
  }
  fclose($arquivo);

}

?>