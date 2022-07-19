<?php

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_sql.php");
require_once "model/configuracao/Instituicao.model.php";
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
?>
<html lang="">
<head>
<title>Descritivo do Parcelamento</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<style>
<!--
td {
  font-family: Arial, Helvetica, sans-serif;
  font-size: 11px;
    border-right-width: 1px;
    border-right-style: solid;
    border-right-color: #000000;
}
th {
  font-family: Arial, Helvetica, sans-serif;
  font-size: 11px;
    border-right-width: 1px;
    border-right-style: solid;
    border-right-color: #000000;
}
-->
</style>
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php
$oInstituicao = new Instituicao(db_getsession('DB_instit'));

if ($oInstituicao->getUsaDebitosItbi() === true) {
    $it01_guia = ", itbinumpre.it15_guia";
    $left_join_itbi = " inner join itbinumpre on itbinumpre.it15_numpre = a.k00_numpre and it15_ultimaguia is true";

}

$sql = "select a.k00_numpre,
                k00_numpar,
                k00_numtot,
                k00_dtoper,
                k00_dtvenc,
                k00_receit,
                k02_drecei,
                k00_valor,
                k00_hist,
                k01_descr
                {$it01_guia}
        from arrecad a
                 inner join arreinstit on arreinstit.k00_numpre = a.k00_numpre
                                      and arreinstit.k00_instit = " . db_getsession('DB_instit') . "
             left outer join arrematric on arrematric.k00_numpre = a.k00_numpre
             left outer join arreinscr on arreinscr.k00_numpre = a.k00_numpre
             {$left_join_itbi}
             ,tabrec inner join tabrecjm on tabrecjm.k02_codjm = tabrec.k02_codjm
         ,histcalc
        where a.k00_numpre = " . $numpre . " and
              k02_codigo   = k00_receit and
              k01_codigo   = k00_hist
        ";
if ($numpar != 0) {
    $sql .= " and k00_numpar = $numpar";
}
$js_func = "";
db_lovrot($sql, 5, "()", "", $js_func);
?>

  <table width="100%" border="0" cellspacing="0" cellpadding="3">
   <tr bgcolor="#FFCC66">
      <?php if ($oInstituicao->getUsaDebitosItbi() === true) : ?>
      <th width="5%" nowrap>ITBI</th>
      <th width="5%" nowrap>Numpre</th>
      <?php else : ?>
      <th width="10%" nowrap>Numpre</th>
      <?php endif; ?>
      <th width="5%" nowrap>Par</th>
      <th width="5%" nowrap>Tot</th>
      <th width="9%" nowrap>Dt. Lanc.</th>
      <th width="10%" nowrap>Dt. Venc.</th>
      <th width="8%" nowrap>Hist</th>
      <th width="12%" nowrap>Descri&ccedil;&atilde;o</th>
      <th width="9%" nowrap>Receita</th>
      <th width="17%" nowrap>Descri&ccedil;&atilde;o</th>
      <th width="15%" nowrap>Valor</th>
    </tr>
    <?php
    $sql = "select a.k00_numpre,
                    k00_numpar,
                    k00_numtot,
                    k00_dtoper,
                    k00_dtvenc,
                    k00_hist,
                    k00_receit,
                    k02_drecei,
                    k01_descr,
                    k00_valor
                    {$it01_guia}
            from arrecad a
               inner join arreinstit on arreinstit.k00_numpre = a.k00_numpre
                                                  and arreinstit.k00_instit = ".db_getsession('DB_instit')."
                 left outer join arrematric on arrematric.k00_numpre = a.k00_numpre
                 left outer join arreinscr on arreinscr.k00_numpre = a.k00_numpre
                 {$left_join_itbi}
                 ,tabrec inner join tabrecjm on tabrecjm.k02_codjm = tabrec.k02_codjm
             ,histcalc
            where a.k00_numpre = ".$numpre." and
                  k02_codigo   = k00_receit and
                  k01_codigo   = k00_hist
            ";
    if($numpar != 0){
       $sql .= " and k00_numpar = $numpar";
    }
    $dados = pg_exec($sql);
    $ConfCor1 = "#EFE029";
    $ConfCor2 = "#E4F471";
    $numpre_cor = "";
    $numpre_par = "";
    $qcor= $ConfCor1;
    if(pg_numrows($dados)>0){
      for($x=0;$x<pg_numrows($dados);$x++){
        db_fieldsmemory($dados,$x,"1");
        if($numpre_cor==""){
           $numpre_cor = $k00_numpre;
           $numpre_par = $k00_numpar;
        }
      if($numpre_cor != $k00_numpre || $numpre_par != $k00_numpar ){
         $numpre_cor = $k00_numpre;
         $numpre_par = $k00_numpar;
         if($qcor == $ConfCor1)
            $qcor = $ConfCor2;
         else $qcor = $ConfCor1;
      }
      ?>
       <tr bgcolor="<?=$qcor?>">
        <?php if ($oInstituicao->getUsaDebitosItbi() === true) : ?>
         <td width="5%" nowrap align="right" > <?=$it01_guia?></td>
         <td width="5%" nowrap align="right" > <?=$k00_numpre?></td>
        <?php else : ?>
         <td width="10%" nowrap align="right" > <?=$k00_numpre?></td>
        <?php endif; ?>
         <td width="5%" nowrap align="right" ><?=$k00_numpar?></td>
         <td width="5%" nowrap align="right"><?=$k00_numtot?></td>
         <td width="9%" nowrap><?=$k00_dtoper?></td>
         <td width="10%" nowrap><?=$k00_dtvenc?> </td>
         <td width="8%" nowrap align="right"><?=$k00_hist?></td>
         <td width="12%" nowrap><?=$k01_descr?></td>
         <td width="9%" nowrap align="center"> <?=$k00_receit?> </td>
         <td width="17%" nowrap><?=$k02_drecei?></td>
         <td width="15%" nowrap align="right"> <?=db_formatar(db_formatar($k00_valor,"v")*-1,"f")?> </td>
      </tr>
    <?php
      }
    }
    ?>
  </table>
</body>
</html>
