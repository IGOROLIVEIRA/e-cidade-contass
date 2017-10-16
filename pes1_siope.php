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

  db_query("CREATE SEQUENCE teste_seq;");

$datageracao_ano = date("Y", db_getsession("DB_datausu"));
$datageracao_mes = date("m", db_getsession("DB_datausu"));
$datageracao_dia = date("d", db_getsession("DB_datausu"));

$sSql = "
SELECT 'I;'|| nextval('teste_seq') || ';' || lpad(x.rh02_mesusu,2,0) || ';' || z01_cgccpf || ';' || z01_nome || ';' || coalesce(rh55_inep,'00000000') || ';' || coalesce(rh55_descr,'') || ';' || x.rh02_hrssem || ';' || CASE
                                                                                                                                                                                                                           WHEN x.rh02_tipcatprof IN (14,
                                                                                                                                                                                                                                                      15,
                                                                                                                                                                                                                                                      16) THEN 2
                                                                                                                                                                                                                           ELSE 1
                                                                                                                                                                                                                       END || ';' ||CASE
                                                                                                                                                                                                                                        WHEN x.rh02_tipcatprof IN (14,
                                                                                                                                                                                                                                                                   15,
                                                                                                                                                                                                                                                                   16) THEN 'Outros profissionais da educação'
                                                                                                                                                                                                                                        ELSE 'Profissionais do magistério'
                                                                                                                                                                                                                                    END || ';' || x.rh02_tipcatprof|| ';'|| CASE
                                                                                                                                                                                                                                                                                WHEN x.rh02_tipcatprof = 0 THEN 'Nenhum'
                                                                                                                                                                                                                                                                                WHEN x.rh02_tipcatprof = 1 THEN 'Docente habilitado em curso de nível médio'
                                                                                                                                                                                                                                                                                WHEN x.rh02_tipcatprof = 2 THEN 'Docente habilitado em curso de pedagogia'
                                                                                                                                                                                                                                                                                WHEN x.rh02_tipcatprof = 3 THEN 'Docente habilitado em curso de licenciatura plena'
                                                                                                                                                                                                                                                                                WHEN x.rh02_tipcatprof = 4 THEN 'Docente habilitado em programa especial de formação pedagógica de docentes'
                                                                                                                                                                                                                                                                                WHEN x.rh02_tipcatprof = 5 THEN 'Docente pós-graduado em cursos de especialização para formação de docentes para educação profissional técnica de nível médio'
                                                                                                                                                                                                                                                                                WHEN x.rh02_tipcatprof = 6 THEN 'Docente graduado bacharel e tecnólogo com diploma de mestrado ou doutorado na área do componente curricular da educação profissional técnica de nível médio'
                                                                                                                                                                                                                                                                                WHEN x.rh02_tipcatprof = 7 THEN 'Docente professor indígena sem prévia formação pedagógica'
                                                                                                                                                                                                                                                                                WHEN x.rh02_tipcatprof = 8 THEN 'Docente instrutor, tradutor e intérprete de libras.'
                                                                                                                                                                                                                                                                                WHEN x.rh02_tipcatprof = 9 THEN 'Docente professor de comunidade quilombola'
                                                                                                                                                                                                                                                                                WHEN x.rh02_tipcatprof = 10 THEN 'Profissionais não habilitados, porém autorizados a exercer a docência em caráter precário e provisório na educação infantil e nos anos iniciais do ensino fundamental.'
                                                                                                                                                                                                                                                                                WHEN x.rh02_tipcatprof = 11 THEN 'Profissionais graduados, bacharéis e tecnólogos autorizados a atuar como docentes, em caráter precário e provisório, nos anos finais do ensino fundamental e no ensino médio e médio integrado à educação.'
                                                                                                                                                                                                                                                                                WHEN x.rh02_tipcatprof = 12 THEN 'Profissionais experientes, não graduados, autorizados a atuar como docentes, em caráter precário e provisório, no ensino médio e médio integrado à educação profissional técnica de nível médio.'
                                                                                                                                                                                                                                                                                WHEN x.rh02_tipcatprof = 13 THEN 'Profissionais em efetivo exercício no âmbito da educação infantil e ensino fundamental.'
                                                                                                                                                                                                                                                                                WHEN x.rh02_tipcatprof = 14 THEN 'Auxiliar/Assistente Educacional'
                                                                                                                                                                                                                                                                                WHEN x.rh02_tipcatprof = 15 THEN 'Profissionais que exercem funções de secretaria escolar, alimentação escolar (merendeiras), multimeios didáticos e infraestrutura.'
                                                                                                                                                                                                                                                                                WHEN x.rh02_tipcatprof = 16 THEN 'Profissionais que atuam na realização das atividades requeridos nos ambientes de secretaria, de manutenção em geral.'
                                                                                                                                                                                                                                                                            END || ';'

|| 
translate(trim(to_char(round(x.rh02_salari,2),'99999999.99')),'.',',') || ';' || 
translate(trim((round(sum( case      when x.r14_pd=2 and rh25_recurso in (118,1118) then -x.valor 
                   when x.r14_pd=1 and rh25_recurso in (118,1118) then x.valor 
                   when x.r48_pd=2 and rh25_recurso in (118,1118) then -x.r48_valor 
                   when x.r48_pd=1 and rh25_recurso in (118,1118) then x.r48_valor  
                   when x.r20_pd=2 and rh25_recurso in (118,1118) then -x.r20_valor 
                   when x.r20_pd=1 and rh25_recurso in (118,1118) then x.r20_valor  
                   when x.r35_pd=2 and rh25_recurso in (118,1118) then -x.r35_valor 
                   when x.r35_pd=1 and rh25_recurso in (118,1118) then x.r35_valor  
                   else 0 end ),2))::varchar),'.',',')  || ';' ||
translate(trim((round(sum( case      when x.r14_pd=2 and rh25_recurso in (119,1119) then -x.valor 
                   when x.r14_pd=1 and rh25_recurso in (119,1119) then x.valor 
                   when x.r48_pd=2 and rh25_recurso in (119,1119) then -x.r48_valor 
                   when x.r48_pd=1 and rh25_recurso in (119,1119) then x.r48_valor  
                   when x.r20_pd=2 and rh25_recurso in (119,1119) then -x.r20_valor 
                   when x.r20_pd=1 and rh25_recurso in (119,1119) then x.r20_valor  
                   when x.r35_pd=2 and rh25_recurso in (119,1119) then -x.r35_valor 
                   when x.r35_pd=1 and rh25_recurso in (119,1119) then x.r35_valor  
                   else 0 end ),2))::varchar),'.',',')  || ';' ||
' '


AS dado 
FROM
    (SELECT r14_rubric,
            r48_rubric,
            r20_rubric,
            r35_rubric,
            r14_instit AS instit,
            round(sum(r14_valor),2) AS valor,
            round(sum(r48_valor),2) AS r48_valor,
            round(sum(r20_valor),2) AS r20_valor,
            round(sum(r35_valor),2) AS r35_valor,
            r14_pd,
            r48_pd,
            r20_pd,
            r35_pd,
            count(r14_rubric) AS soma,
            round(sum(r14_quant),2) AS quant,
            rh02_mesusu,
            rh02_anousu,
            rh01_numcgm,
            rh02_seqpes,
            rh02_hrssem,
            rh02_tipcatprof,
            rh02_salari,
            rh01_regist,
            rh25_recurso

     FROM rhpessoal 
     INNER JOIN rhpessoalmov ON rh02_regist = rh01_regist
     AND rh02_anousu = $anofolha
     AND rh02_mesusu = $mesfolha
     AND rh02_instit = ".db_getsession("DB_instit")."
     LEFT JOIN rhpesbanco ON rh44_seqpes = rh02_seqpes
     INNER JOIN rhregime ON rh02_codreg = rh30_codreg
     AND rh30_instit = rh02_instit
     INNER JOIN rhlota ON rh02_lota = r70_codigo
     AND r70_instit = rh02_instit
     LEFT JOIN rhlotavinc ON rh25_codigo = r70_codigo
     AND rh25_anousu = $anofolha
     LEFT JOIN gerfsal ON r14_regist = rh01_regist
     AND r14_anousu = $anofolha
     AND r14_mesusu = $mesfolha
     AND r14_instit = ".db_getsession("DB_instit")."
     LEFT JOIN gerfcom ON r48_regist = rh01_regist
     AND r48_anousu = $anofolha
     AND r48_mesusu = $mesfolha
     AND r48_instit = ".db_getsession("DB_instit")."
     LEFT JOIN gerfres ON r20_regist = rh01_regist
     AND r20_anousu = $anofolha
     AND r20_mesusu = $mesfolha
     AND r20_instit = ".db_getsession("DB_instit")."
     LEFT JOIN gerfs13 ON r35_regist = rh01_regist
     AND r35_anousu = $anofolha
     AND r35_mesusu = $mesfolha
     AND r35_instit = ".db_getsession("DB_instit")."
     WHERE rh25_recurso in (119,118,1119,1118)
     GROUP BY r14_rubric,
              r48_rubric,
              r20_rubric,
              r35_rubric,
              r14_instit,
              r14_pd,
              r48_pd,
              r20_pd,
              r35_pd,
              rh02_mesusu,
              rh02_anousu,
              rh01_numcgm,
              rh02_seqpes,
              rh02_hrssem,
              rh02_tipcatprof,
              rh02_salari,
              rh01_regist,
              rh25_recurso) AS x

LEFT JOIN rhpeslocaltrab ON x.rh02_seqpes = rh56_seqpes
LEFT JOIN rhlocaltrab ON rh55_codigo = rh56_localtrab
INNER JOIN cgm ON z01_numcgm = x.rh01_numcgm
LEFT JOIN rhrubricas ON x.r14_rubric=rh27_rubric
          or x.r48_rubric=rh27_rubric
          or x.r20_rubric=rh27_rubric
          or x.r35_rubric=rh27_rubric
AND rh27_instit = instit
LEFT JOIN rhrubelemento ON rh23_rubric = rh27_rubric
AND rh23_instit = rh27_instit
LEFT JOIN rhrubretencao ON rh75_rubric = rh27_rubric
AND rh75_instit = rh27_instit
LEFT JOIN retencaotiporec ON e21_sequencial = rh75_retencaotiporec
LEFT JOIN retencaotipocalc ON e32_sequencial = e21_retencaotipocalc
LEFT JOIN retencaotiporecgrupo ON e01_sequencial = e21_retencaotiporecgrupo
where rh23_rubric IS NOT NULL and rh75_rubric is null and rh23_rubric IS NOT NULL 
group by x.rh01_regist,x.rh02_mesusu,cgm.z01_cgccpf,cgm.z01_nome,rhlocaltrab.rh55_inep,rhlocaltrab.rh55_descr,x.rh02_hrssem,x.rh02_tipcatprof,x.rh02_salari
ORDER BY rh01_regist;

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
