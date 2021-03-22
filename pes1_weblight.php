<?
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_utils.php");
require_once("dbforms/db_classesgenericas.php");

db_postmemory($HTTP_POST_VARS);


$sSql  = "SELECT * FROM db_config ";
$sSql .= "	WHERE prefeitura = 't'";

$rsInst = db_query($sSql);
$sCnpj  = db_utils::fieldsMemory($rsInst, 0)->cgc;

$sSeparador = "';'";

if (isset($geratxt)) {

if ($tipo == 'funcionarios'){

$datageracao_ano = date("Y", db_getsession("DB_datausu"));
$datageracao_mes = date("m", db_getsession("DB_datausu"));
$datageracao_dia = date("d", db_getsession("DB_datausu"));

$sSql = "
SELECT DISTINCT
lpad('$cnpj',14,0)
||$sSeparador
||rh01_regist::varchar
||$sSeparador
||'A'
||$sSeparador
||z01_cgccpf
||$sSeparador
||z01_nome
||$sSeparador
||coalesce(z01_email,'')
||$sSeparador
||coalesce(to_char(rh01_admiss,'dd/mm/YYYY'),'')
||$sSeparador
||coalesce(to_char(rh01_nasc,'dd/mm/YYYY'),'')
||$sSeparador
||coalesce(to_char(rh164_datafim,'dd/mm/YYYY'),'')
||$sSeparador
||rh02_funcao
||$sSeparador
||'01'
||$sSeparador
||substr(r70_estrut::varchar,2,5)
||$sSeparador
||''
||$sSeparador
||''
||$sSeparador
||''
||$sSeparador
||''
||$sSeparador
||''
||$sSeparador
||''
||$sSeparador
||''
||$sSeparador
||'0'
 as dados
FROM rhpessoal
LEFT JOIN rhpessoalmov ON rhpessoalmov.rh02_regist = rhpessoal.rh01_regist
AND rhpessoalmov.rh02_anousu = $anofolha
AND rhpessoalmov.rh02_mesusu = $mesfolha
LEFT JOIN rhlota ON rhlota.r70_codigo = rhpessoalmov.rh02_lota
AND rhlota.r70_instit = rhpessoalmov.rh02_instit
INNER JOIN cgm ON cgm.z01_numcgm = rhpessoal.rh01_numcgm
LEFT JOIN rhregime ON rh30_codreg = rh02_codreg
LEFT JOIN rhfuncao ON rhfuncao.rh37_funcao = rhpessoalmov.rh02_funcao
AND rhfuncao.rh37_instit = rhpessoalmov.rh02_instit
LEFT JOIN rhpesrescisao ON rh02_seqpes = rh05_seqpes
LEFT JOIN rhcontratoemergencial ON rhcontratoemergencial.rh163_matricula = rhpessoal.rh01_regist
LEFT JOIN afasta on r45_regist = rh01_regist
LEFT JOIN rhcontratoemergencialrenovacao on rh163_sequencial = rh164_contratoemergencial
WHERE rh01_instit = ".db_getsession("DB_instit")."
    AND rh05_seqpes IS NULL

";
$result = db_query($sSql);
  unlink("tmp/FUNCIONARIOS.csv");
  // Abre o arquivo para leitura e escrita
  $f = fopen("tmp/FUNCIONARIOS.csv", "x");

  // Lê o conteúdo do arquivo
  $content = "";
  if(filesize("tmp/FUNCIONARIOS.csv") > 0)
  $content = fread($f, filesize("tmp/FUNCIONARIOS.csv"));

  for ($iCont = 0; $iCont < pg_num_rows($result); $iCont++) {

        $oDados = db_utils::fieldsMemory($result, $iCont);

        //echo $oDados->dados;
        // Escreve no arquivo
        fwrite($f, $oDados->dados."\n");

  }

  // Libera o arquivo
  fclose($f);

  echo "
  <script >
  window.open('tmp/FUNCIONARIOS.csv','','location=yes, width=800,height=600,scrollbars=yes'); 
  </script>";

}else if ($tipo == 'verbas'){

$datageracao_ano = date("Y", db_getsession("DB_datausu"));
$datageracao_mes = date("m", db_getsession("DB_datausu"));
$datageracao_dia = date("d", db_getsession("DB_datausu"));


$sSql = "select 
lpad('$cnpj',14,0)
||$sSeparador
||r14_regist::varchar
||$sSeparador
||r14_rubric::varchar
||$sSeparador
||round(r14_quant,2)::varchar
||$sSeparador
||case when 
	r14_valor = null then '0.00'
    else round(r14_valor,2)::varchar
end  as dados
from gerfsal
where r14_anousu = $anofolha
and r14_mesusu = $mesfolha
and r14_pd in (1,2)
and r14_regist in 
(
SELECT DISTINCT 
rh01_regist
FROM rhpessoal
LEFT JOIN rhpessoalmov ON rhpessoalmov.rh02_regist = rhpessoal.rh01_regist
AND rhpessoalmov.rh02_anousu = $anofolha
AND rhpessoalmov.rh02_mesusu = $mesfolha
LEFT JOIN rhlota ON rhlota.r70_codigo = rhpessoalmov.rh02_lota
AND rhlota.r70_instit = rhpessoalmov.rh02_instit
INNER JOIN cgm ON cgm.z01_numcgm = rhpessoal.rh01_numcgm
LEFT JOIN rhregime ON rh30_codreg = rh02_codreg
LEFT JOIN rhfuncao ON rhfuncao.rh37_funcao = rhpessoalmov.rh02_funcao
AND rhfuncao.rh37_instit = rhpessoalmov.rh02_instit
LEFT JOIN rhpesrescisao ON rh02_seqpes = rh05_seqpes
LEFT JOIN rhcontratoemergencial ON rhcontratoemergencial.rh163_matricula = rhpessoal.rh01_regist
LEFT JOIN afasta on r45_regist = rh01_regist
WHERE rh01_instit = ".db_getsession("DB_instit")."
    AND rh05_seqpes IS NULL
)
";

$result = db_query($sSql);
  unlink("tmp/VERBAS.csv");
  // Abre o arquivo para leitura e escrita
  $f = fopen("tmp/VERBAS.csv", "x");

  // Lê o conteúdo do arquivo
  $content = "";
  if(filesize("tmp/VERBAS.csv") > 0)
  $content = fread($f, filesize("tmp/verbas.csv"));

  for ($iCont = 0; $iCont < pg_num_rows($result); $iCont++) {

        $oDados = db_utils::fieldsMemory($result, $iCont);

        //echo $oDados->dados;
        // Escreve no arquivo
        fwrite($f, $oDados->dados."\n");

  }

  // Libera o arquivo
  fclose($f);

  echo "<script>
  window.open('tmp/VERBAS.csv','','width=800,height=600,scrollbars=yes'); 
  </script>";

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
  <legend style="font-weight: bold;">Weblight </legend>

    <table align="left" class='formTable'>
        <?php
        $geraform = new cl_formulario_rel_pes;
        ?>
        <tr>
          <td align="right" nowrap="" title="Tipo">
            <strong>CNPJ:</strong>
          </td>
          <td>
            <input type="text" name="cnpj" value="<?php echo $sCnpj?>">
          </td>
        </tr>
        <tr>
        <td align="right" nowrap="" title="Tipo">
        <strong>Tipo:</strong>
        </td>
        <td>
          <select name="tipo" >
            <option value="funcionarios" >Funcionarios</option>
            <option value="verbas" >Verbas</option>
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
