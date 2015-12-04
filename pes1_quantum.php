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

if($tipo == 1){

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
          when 12 then '2 '
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

  unlink("valores_descontados.csv");
// Abre o arquivo para leitura e escrita
  $f = fopen("valores_descontados.csv", "x");

  // Lê o conteúdo do arquivo
  $content = "";
  if(filesize("valores_descontados.csv") > 0)
  $content = fread($f, filesize("valores_descontados.csv"));

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
  window.open('valores_descontados.csv','','width=800,height=600,scrollbars=yes'); 
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
