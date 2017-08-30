<?
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_utils.php");
require_once("dbforms/db_classesgenericas.php");

/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/

db_postmemory($HTTP_POST_VARS);

if (isset($geratxt)) { 

  db_query("CREATE SEQUENCE teste_seq");
//db_query("\o /tmp/qw101_descontos.txt");
//echo pg_last_error();exit;
$datageracao_ano = date("Y", db_getsession("DB_datausu"));
$datageracao_mes = date("m", db_getsession("DB_datausu"));
$datageracao_dia = date("d", db_getsession("DB_datausu"));

$sSql = "SELECT distinct 'H' 
|| 'QWIA001'
|| '$datageracao_ano'
|| '$datageracao_mes'
|| '$datageracao_dia'
|| rpad(nomeinst,60,' ')
|| '$anofolha'
|| lpad('$mesfolha',2,0)
|| lpad(nextval('teste_seq'),3,'0') AS dado
FROM db_config
WHERE db_config.codigo = 1

union all

select 
'I,'|| x.nextval || ',' || x.rh02_mesusu || ',' || x.z01_cgccpf || ',' 
|| x.z01_nome || ',' || coalesce(x.rh55_inep,'00000000') || ',' || coalesce(x.rh55_descr,'') || ',' || x.rh02_hrssem || ',' 
||  
case when x.rh02_tipcatprof in (14,15,16) then 2
     else 1 end 
|| ',' 
||
case when x.rh02_tipcatprof in (14,15,16) then 'Outros profissionais da
educação'
     else 'Profissionais do magistério' end 
|| ',' 
|| x.rh02_tipcatprof
|| ','
|| 
case when x.rh02_tipcatprof = 0 then 'Nenhum'
     when x.rh02_tipcatprof = 1 then 'Docente habilitado em curso de nível médio'
     when x.rh02_tipcatprof = 2 then 'Docente habilitado em curso de pedagogia'
     when x.rh02_tipcatprof = 3 then 'Docente habilitado em curso de licenciatura plena'
     when x.rh02_tipcatprof = 4 then 'Docente habilitado em programa especial de formação pedagógica de docentes'
     when x.rh02_tipcatprof = 5 then 'Docente pós-graduado em cursos de especialização para formação de docentes para educação profissional técnica de nível médio'
     when x.rh02_tipcatprof = 6 then 'Docente graduado bacharel e tecnólogo com diploma de mestrado ou doutorado na área do componente curricular da educação profissional técnica de nível médio'
     when x.rh02_tipcatprof =  7 then 'Docente professor indígena sem prévia formação pedagógica'
     when x.rh02_tipcatprof =  8 then 'Docente instrutor, tradutor e intérprete de libras.'
     when x.rh02_tipcatprof =  9 then 'Docente professor de comunidade quilombola'
     when x.rh02_tipcatprof =  10 then 'Profissionais não habilitados, porém autorizados a exercer a docência em caráter precário e provisório na educação infantil e nos anos iniciais do ensino fundamental.'
     when x.rh02_tipcatprof =  11 then 'Profissionais graduados, bacharéis e tecnólogos autorizados a atuar como docentes, em caráter precário e provisório, nos anos finais do ensino fundamental e no ensino médio e médio integrado à educação.'
     when x.rh02_tipcatprof =  12 then 'Profissionais experientes, não graduados, autorizados a atuar como docentes, em caráter precário e provisório, no ensino médio e médio integrado à educação profissional técnica de nível médio.'
     when x.rh02_tipcatprof =  13 then 'Profissionais em efetivo exercício no âmbito da educação infantil e ensino fundamental.'
     when x.rh02_tipcatprof =  14 then 'Auxiliar/Assistente Educacional'
     when x.rh02_tipcatprof =  15 then 'Profissionais que exercem funções de secretaria escolar, alimentação escolar (merendeiras), multimeios didáticos e infraestrutura.'
     when x.rh02_tipcatprof =  16 then 'Profissionais que atuam na realização das atividades requeridos nos ambientes de secretaria, de manutenção em geral.'
     end 
|| ','
|| x.rh02_salari
|| ','
|| 

case when (x.proventos_r14_118 + x.proventos_r48_118 + x.proventos_r20_118 + x.proventos_r35_118) > 0 then  
            (((x.base_r14 + x.base_r48 + x.base_r20 + x.base_r35)/100*(select r33_ppatro from inssirf 
    where  r33_anousu = 2016
                   and r33_mesusu = 12
                   and r33_instit = 1 
                   and r33_codtab = x.rh02_tbprev+2 limit 1)) + (x.proventos_r14_118 + x.proventos_r48_118 + x.proventos_r20_118 + x.proventos_r35_118))
     else 0
     end       

|| ','
|| 

case when (x.proventos_r14_119 + x.proventos_r48_119 + x.proventos_r20_119 + x.proventos_r35_119) > 0 then  
            (((x.base_r14 + x.base_r48 + x.base_r20 + x.base_r35)/100*(select r33_ppatro from inssirf 
    where  r33_anousu = 2016
                   and r33_mesusu = 12
                   and r33_instit = 1 
                   and r33_codtab = x.rh02_tbprev+2 limit 1)) + (x.proventos_r14_119 + x.proventos_r48_119 + x.proventos_r20_119 + x.proventos_r35_119))
     else 0
     end 

|| ','
|| 

case when (x.proventos_r14_101 + x.proventos_r48_101 + x.proventos_r20_101 + x.proventos_r35_101) > 0 then  
            (((x.base_r14 + x.base_r48 + x.base_r20 + x.base_r35)/100*(select r33_ppatro from inssirf 
    where  r33_anousu = 2016
                   and r33_mesusu = 12
                   and r33_instit = 1 
                   and r33_codtab = x.rh02_tbprev+2 limit 1)) + (x.proventos_r14_101 + x.proventos_r48_101 + x.proventos_r20_101 + x.proventos_r35_101))
     else 0
     end 

|| ','
|| 

case when   (x.proventos_r14_118 + x.proventos_r48_118 + x.proventos_r20_118 + x.proventos_r35_118) > 0
        and (x.proventos_r14_119 + x.proventos_r48_119 + x.proventos_r20_119 + x.proventos_r35_119) > 0
        and (x.proventos_r14_101 + x.proventos_r48_101 + x.proventos_r20_101 + x.proventos_r35_101) > 0 then   
            (((x.base_r14 + x.base_r48 + x.base_r20 + x.base_r35)/100*(select r33_ppatro from inssirf 
    where  r33_anousu = 2016
                   and r33_mesusu = 12
                   and r33_instit = 1 
                   and r33_codtab = x.rh02_tbprev+2 limit 1)) + (x.proventos_r14_118 + x.proventos_r48_118 + x.proventos_r20_118 + x.proventos_r35_118)) +
            (((x.base_r14 + x.base_r48 + x.base_r20 + x.base_r35)/100*(select r33_ppatro from inssirf 
    where  r33_anousu = 2016
                   and r33_mesusu = 12
                   and r33_instit = 1 
                   and r33_codtab = x.rh02_tbprev+2 limit 1)) + (x.proventos_r14_119 + x.proventos_r48_119 + x.proventos_r20_119 + x.proventos_r35_119)) +  
            (((x.base_r14 + x.base_r48 + x.base_r20 + x.base_r35)/100*(select r33_ppatro from inssirf 
    where  r33_anousu = 2016
                   and r33_mesusu = 12
                   and r33_instit = 1 
                   and r33_codtab = x.rh02_tbprev+2 limit 1)) + (x.proventos_r14_101 + x.proventos_r48_101 + x.proventos_r20_101 + x.proventos_r35_101))

     when   (x.proventos_r14_118 + x.proventos_r48_118 + x.proventos_r20_118 + x.proventos_r35_118) > 0
        and (x.proventos_r14_119 + x.proventos_r48_119 + x.proventos_r20_119 + x.proventos_r35_119) > 0
        and (x.proventos_r14_101 + x.proventos_r48_101 + x.proventos_r20_101 + x.proventos_r35_101) <= 0 then   
            (((x.base_r14 + x.base_r48 + x.base_r20 + x.base_r35)/100*(select r33_ppatro from inssirf 
    where  r33_anousu = 2016
                   and r33_mesusu = 12
                   and r33_instit = 1 
                   and r33_codtab = x.rh02_tbprev+2 limit 1)) + (x.proventos_r14_118 + x.proventos_r48_118 + x.proventos_r20_118 + x.proventos_r35_118)) +
            (((x.base_r14 + x.base_r48 + x.base_r20 + x.base_r35)/100*(select r33_ppatro from inssirf 
    where  r33_anousu = 2016
                   and r33_mesusu = 12
                   and r33_instit = 1 
                   and r33_codtab = x.rh02_tbprev+2 limit 1)) + (x.proventos_r14_119 + x.proventos_r48_119 + x.proventos_r20_119 + x.proventos_r35_119))

     when   (x.proventos_r14_118 + x.proventos_r48_118 + x.proventos_r20_118 + x.proventos_r35_118) > 0
        and (x.proventos_r14_119 + x.proventos_r48_119 + x.proventos_r20_119 + x.proventos_r35_119) > 0
        and (x.proventos_r14_101 + x.proventos_r48_101 + x.proventos_r20_101 + x.proventos_r35_101) <= 0 then   
            (((x.base_r14 + x.base_r48 + x.base_r20 + x.base_r35)/100*(select r33_ppatro from inssirf 
    where  r33_anousu = 2016
                   and r33_mesusu = 12
                   and r33_instit = 1 
                   and r33_codtab = x.rh02_tbprev+2 limit 1)) + (x.proventos_r14_118 + x.proventos_r48_118 + x.proventos_r20_118 + x.proventos_r35_118)) +
            (((x.base_r14 + x.base_r48 + x.base_r20 + x.base_r35)/100*(select r33_ppatro from inssirf 
    where  r33_anousu = 2016
                   and r33_mesusu = 12
                   and r33_instit = 1 
                   and r33_codtab = x.rh02_tbprev+2 limit 1)) + (x.proventos_r14_119 + x.proventos_r48_119 + x.proventos_r20_119 + x.proventos_r35_119))       

     when   (x.proventos_r14_118 + x.proventos_r48_118 + x.proventos_r20_118 + x.proventos_r35_118) > 0
        and (x.proventos_r14_119 + x.proventos_r48_119 + x.proventos_r20_119 + x.proventos_r35_119) <= 0
        and (x.proventos_r14_101 + x.proventos_r48_101 + x.proventos_r20_101 + x.proventos_r35_101) > 0 then   
            (((x.base_r14 + x.base_r48 + x.base_r20 + x.base_r35)/100*(select r33_ppatro from inssirf 
    where  r33_anousu = 2016
                   and r33_mesusu = 12
                   and r33_instit = 1 
                   and r33_codtab = x.rh02_tbprev+2 limit 1)) + (x.proventos_r14_118 + x.proventos_r48_118 + x.proventos_r20_118 + x.proventos_r35_118)) +
            (((x.base_r14 + x.base_r48 + x.base_r20 + x.base_r35)/100*(select r33_ppatro from inssirf 
    where  r33_anousu = 2016
                   and r33_mesusu = 12
                   and r33_instit = 1 
                   and r33_codtab = x.rh02_tbprev+2 limit 1)) + (x.proventos_r14_101 + x.proventos_r48_101 + x.proventos_r20_101 + x.proventos_r35_101))      

     when   (x.proventos_r14_118 + x.proventos_r48_118 + x.proventos_r20_118 + x.proventos_r35_118) > 0
        and (x.proventos_r14_119 + x.proventos_r48_119 + x.proventos_r20_119 + x.proventos_r35_119) <= 0
        and (x.proventos_r14_101 + x.proventos_r48_101 + x.proventos_r20_101 + x.proventos_r35_101) <= 0 then   
            (((x.base_r14 + x.base_r48 + x.base_r20 + x.base_r35)/100*(select r33_ppatro from inssirf 
    where  r33_anousu = 2016
                   and r33_mesusu = 12
                   and r33_instit = 1 
                   and r33_codtab = x.rh02_tbprev+2 limit 1)) + (x.proventos_r14_118 + x.proventos_r48_118 + x.proventos_r20_118 + x.proventos_r35_118))           

     else 0
     end  

AS dado

from 
(
    select distinct  
rh02_mesusu,z01_cgccpf,z01_nome,rh55_inep,rh55_descr,rh02_hrssem,rh02_tipcatprof,rh02_salari,rh02_tbprev,nextval('teste_seq'),

sum( case when r14_pd = 1 and rh25_recurso = 118 then r14_valor else 0 end ) as proventos_r14_118,
sum( case when r48_pd = 1 and rh25_recurso = 118 then r48_valor else 0 end ) as proventos_r48_118,
sum( case when r20_pd = 1 and rh25_recurso = 118 then r20_valor else 0 end ) as proventos_r20_118,
sum( case when r35_pd = 1 and rh25_recurso = 118 then r35_valor else 0 end ) as proventos_r35_118,

sum( case when r14_pd = 1 and rh25_recurso = 119 then r14_valor else 0 end ) as proventos_r14_119,
sum( case when r48_pd = 1 and rh25_recurso = 119 then r48_valor else 0 end ) as proventos_r48_119,
sum( case when r20_pd = 1 and rh25_recurso = 119 then r20_valor else 0 end ) as proventos_r20_119,
sum( case when r35_pd = 1 and rh25_recurso = 119 then r35_valor else 0 end ) as proventos_r35_119,

sum( case when r14_pd = 1 and rh25_recurso = 101 then r14_valor else 0 end ) as proventos_r14_101,
sum( case when r48_pd = 1 and rh25_recurso = 101 then r48_valor else 0 end ) as proventos_r48_101,
sum( case when r20_pd = 1 and rh25_recurso = 101 then r20_valor else 0 end ) as proventos_r20_101,
sum( case when r35_pd = 1 and rh25_recurso = 101 then r35_valor else 0 end ) as proventos_r35_101,


sum( case when r14_rubric = 'R992'  then r14_valor else 0 end ) as base_r14,
sum( case when r48_rubric = 'R992'  then r48_valor else 0 end ) as base_r48,
sum( case when r20_rubric = 'R992'  then r20_valor else 0 end ) as base_r20,
sum( case when r35_rubric = 'R992'  then r35_valor else 0 end ) as base_r35

            from rhpessoal 
            join rhpessoalmov on rh02_regist = rh01_regist
            join cgm on z01_numcgm = rh01_numcgm
            left join rhpeslocaltrab on rh02_seqpes = rh56_seqpes
            left join rhlocaltrab on rh55_codigo = rh56_localtrab
            join rhlota       on r70_codigo  = rh02_lota
                                and r70_instit  = rh02_instit
            join rhlotavinc  on rh25_codigo = r70_codigo 

            join gerfsal on r14_regist = rh01_regist    
                        and r14_anousu = $anofolha
                        and r14_mesusu = $mesfolha
                        and r14_instit = ".db_getsession("DB_instit")."

            left join gerfcom on r48_regist = rh01_regist    
                        and r48_anousu = $anofolha
                        and r48_mesusu = $mesfolha
                        and r48_instit = ".db_getsession("DB_instit")."  

            left join gerfres on r20_regist = rh01_regist    
                        and r20_anousu = $anofolha
                        and r20_mesusu = $mesfolha
                        and r20_instit = ".db_getsession("DB_instit")."  

            left join gerfs13 on r35_regist = rh01_regist    
                        and r35_anousu = $anofolha
                        and r35_mesusu = $mesfolha
                        and r35_instit = ".db_getsession("DB_instit")."                                
 
            where rh25_recurso in (101,118,119) and rh25_anousu = $anofolha
            and rh02_mesusu = $mesfolha and rh02_anousu = $anofolha
            group by 1,2,3,4,5,6,7,8,9
            order by nextval asc

            ) as x

;

";
$result = db_query($sSql);
  unlink("tmp/siope.csv");
  // Abre o arquivo para leitura e escrita
  $f = fopen("tmp/siope.csv", "x");

  // Lê o conteúdo do arquivo
  $content = "";
  if(filesize("tmp/siope.csv") > 0)
  $content = fread($f, filesize("tmp/siope.csv"));

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
  window.open('tmp/siope.csv','','location=yes, width=800,height=600,scrollbars=yes'); 
  </script>";

  db_query("DROP SEQUENCE teste_seq;");

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
  <legend style="font-weight: bold;">Siope </legend>
  
    <table align="left" class='formTable'>  
        <?php
        $geraform = new cl_formulario_rel_pes;
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
