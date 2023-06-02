<?php
//ini_set("display_errors", true);
include("model/relatorios/Relatorio.php");
include("libs/db_utils.php");
include("std/DBDate.php");
include("libs/db_conecta.php");
include("dbforms/db_funcoes.php");

$aConsulta = array();

parse_str($HTTP_SERVER_VARS['QUERY_STRING'], $aFiltros);

try {

  $oDatas = new stdClass();

  if (isset($aFiltros['datas_inicio']) && isset($aFiltros['datas_final'])) {

    $oDatas->inicio = new DBDate($aFiltros['datas_inicio']);
    $oDatas->final  = new DBDate($aFiltros['datas_final']);
    $oDatas->inicio = $oDatas->inicio->getDate();
    $oDatas->final  = $oDatas->final->getDate();
    $whereDatas     = " e290_dtexclusao between '".$oDatas->inicio."' and '".$oDatas->final."' ";
    $cData          = true;
  } else {
      $cData = false;
  }

  if (isset($aFiltros['empenho']) && !empty($aFiltros['empenho'])) {
      $iCodEmp   = $aFiltros['empenho'];
      $whereEmp  = " e290_e60_numemp in (".$iCodEmp.") ";
      $cEmpenho  = true;
  } else {
      $whereEmp  = " e290_e60_numemp in (null) ";
      $cEmpenho  = false;
  }

  if (isset($aFiltros['credor']) && !empty($aFiltros['credor'])) {
      $iCodCred  = $aFiltros['credor'];
      $whereCred = " e290_z01_numcgm in (".$iCodCred.") ";
      $cCredor = true;
  } else {
      $whereCred = " e290_z01_numcgm in (null) ";
      $cCredor   = false;
  }

/*Montagem da QUERY final*/
  if ($cData == true && ($cEmpenho && $cCredor) == false) {
    $condicao = "{$whereDatas}";
  }

  else if ($cData == true && ($cEmpenho || $cCredor) == true) {
    $condicao  = "({$whereEmp} OR {$whereCred}) AND {$whereDatas}";
  }

  else if ($cData == false && ($cEmpenho || $cCredor) == true) {
    $condicao  = "({$whereEmp} OR {$whereCred})";
  }


  //$condicao  = "({$whereEmp} OR {$whereCred}) AND {$whereDatas}";

  $sSQL = "
    SELECT emp.e290_e60_numemp,
           cgm.z01_numcgm,
           emp.e290_e60_codemp,
           emp.e290_e60_anousu,
           cgm.z01_numcgm,
           cgm.z01_nome,
           emp.e290_e60_vlremp,
           emp.e290_e60_emiss,
           u.id_usuario,
           u.nome,
           emp.e290_dtexclusao
    FROM empenhosexcluidos AS emp
    INNER JOIN cgm ON cgm.z01_numcgm = emp.e290_z01_numcgm
    INNER JOIN db_usuarios AS u ON u.id_usuario = emp.e290_id_usuario
    WHERE {$condicao}
    GROUP BY emp.e290_z01_numcgm,
             emp.e290_e60_codemp,
             emp.e290_e60_numemp,
             emp.e290_e60_anousu,
             emp.e290_z01_nome,
             e290_e60_vlremp,
             e290_e60_emiss,
             u.id_usuario,
             u.nome,
             cgm.z01_numcgm,
             u.id_usuario,
             emp.e290_dtexclusao
    ORDER BY emp.e290_e60_anousu,
             emp.e290_z01_nome,
             emp.e290_e60_codemp
    ";

  //print_r($sSQL); die;
  $rsConsulta = db_query($sSQL);
  $aConsulta = pg_fetch_all($rsConsulta);

  if ($aConsulta === false) {

    throw new Exception("Nenhum dado para o filtro aplicado!", 1);

  }

} catch (Exception $e) {

  echo $e->getMessage();
  // db_redireciona('db_erros.php?fechar=true&db_erro='. $e->getMessage());

}


$aEmpenhos = array();


foreach ($aConsulta as $aEmpenho) {

  $iCredor = $aEmpenho['z01_numcgm'];
  $iEmp    = $aEmpenho['e290_e60_numemp'];

  if (!isset($aEmpenhos[$iCredor])) {

    $oNovoCredor = new stdClass();
    $oNovoCredor->z01_numcgm = $iCredor;
    $oNovoCredor->z01_nome   = $aEmpenho['z01_nome'];
    $oNovoCredor->empenhos   = array();
    $aEmpenhos[$iCredor] = $oNovoCredor;

  }

  if (!isset($aEmpenhos[$iCredor]->empenhos[$iEmp])) {

    $oNovoEmpenho = new stdClass();
    $oNovoEmpenho->e290_e60_numemp = $iEmp;
    $oNovoEmpenho->e290_e60_codemp = $aEmpenho['e290_e60_codemp'];
    $oNovoEmpenho->e290_e60_anousu = $aEmpenho['e290_e60_anousu'];
    $oNovoEmpenho->z01_numcgm      = $aEmpenho['z01_numcgm'];
    $oNovoEmpenho->z01_nome        = $aEmpenho['z01_nome'];
    $oNovoEmpenho->e290_e60_vlremp = number_format($aEmpenho['e290_e60_vlremp'], 2, ',', '.');
    $oNovoEmpenho->e290_e60_emiss  = implode("/",array_reverse(explode("-",$aEmpenho['e290_e60_emiss'])));
    $oNovoEmpenho->id_usuario      = $aEmpenho['id_usuario'];
    $oNovoEmpenho->nome            = $aEmpenho['nome'];
    $oNovoEmpenho->e290_dtexclusao = implode("/",array_reverse(explode("-",$aEmpenho['e290_dtexclusao'] )));

    $aEmpenhos[$iCredor]->empenhos[$iEmp] = $oNovoEmpenho;

  }

}

// Configurações do relatório
$head1 = "Empenhos Excluídos";
$head3 = (isset($aFiltros['datas_inicio']) && isset($aFiltros['datas_final'])) ? "Data: {$aFiltros['datas_inicio']} à {$aFiltros['datas_final']}" : "Data: ";
$head5 = isset($aFiltros['credor']) ? "Credor(es): {$aFiltros['credor']}" : "Credores(es): ";
$head7 = isset($aFiltros['empenho']) ? "Empenho(s): {$aFiltros['empenho']}" : "Empenho(s):";

$mPDF = new Relatorio('', 'A4-P');

$mPDF->addInfo($head1, 1);
$mPDF->addInfo($head3, 3);
$mPDF->addInfo($head5, 5);
$mPDF->addInfo($head7, 7);

ob_start();

?>

<!DOCTYPE html>
<html>
<head>
<title>Relatório</title>
<link rel="stylesheet" type="text/css" href="estilos/relatorios/padrao.style.css">
<style type="text/css">

.waffle, .grid-fixed-table { font-size: 13px; table-layout: fixed; border-collapse: separate; border-style: none; border-spacing: 0; width: 0; cursor: default }

.ritz .waffle a { color: inherit; }

.ritz .waffle .s3 { border-bottom: 1px SOLID #ffffff; border-right: 1px SOLID #ffffff; background-color: #ffffff; text-align: left; color: #000000; font-family: 'Arial'; font-size: 10pt; vertical-align: bottom; white-space: nowrap; direction: ltr; padding: 2px 3px 2px 3px; }

.ritz .waffle .s1 { border-bottom: 1px SOLID #000000; border-right: 1px SOLID #ffffff; background-color: #ffffff; text-align: left; font-weight: bold; color: #000000; font-family: 'Arial'; font-size: 10pt; vertical-align: bottom; white-space: nowrap; direction: ltr; padding: 2px 3px 2px 3px; }

.ritz .waffle .s5 { border-bottom: 1px SOLID #ffffff; background-color: #ffffff; text-align: center; color: #000000; font-family: 'Arial'; font-size: 10pt; vertical-align: bottom; white-space: nowrap; direction: ltr; padding: 2px 3px 2px 3px; }

.ritz .waffle .s4 { border-bottom: 1px SOLID #ffffff; border-right: 1px SOLID #ffffff; background-color: #ffffff; text-align: left; color: #000000; font-family: 'Arial'; font-size: 10pt; vertical-align: bottom; white-space: nowrap; direction: ltr; padding: 2px 3px 2px 3px; }

.ritz .waffle .s0 { border-bottom: 1px SOLID #000000; border-right: 1px SOLID #ffffff; background-color: #ffffff; text-align: left; color: #000000; font-family: 'Arial'; font-size: 10pt; vertical-align: bottom; white-space: nowrap; direction: ltr; padding: 2px 3px 2px 3px; }

.ritz .waffle .s2 { border-right: none; background-color: #ffffff; text-align: left; font-weight: bold; color: #000000; font-family: 'Arial'; font-size: 10pt; vertical-align: bottom; white-space: nowrap; direction: ltr; padding: 2px 3px 2px 3px; }

.bordabottom { border-bottom: 1px SOLID #000000; }

</style>
</head>
<body>
<div class="content">

    <?php foreach($aEmpenhos as $aEmpenho): ?>
    <div class="ritz" dir="ltr">
       <table class="waffle" cellspacing="0" cellpadding="0">
          <thead>
             <tr>
                <th style="width:98px">&nbsp;</th>
                <th style="width:352px">&nbsp;</th>
                <th style="width:119px">&nbsp;</th>
                <th style="width:106px">&nbsp;</th>
                <th style="width:281px">&nbsp;</th>
                <th style="width:100px">&nbsp;</th>
             </tr>
          </thead>
          <tbody>
             <tr style='height:20px;'>
                <td class="s0" dir="ltr">Credor.</td>
                <td class="s0" dir="ltr"><?= $aEmpenho->z01_numcgm ?> - <?= $aEmpenho->z01_nome ?></td>
                <td class="s0"></td>
                <td class="s0"></td>
                <td class="s0"></td>
                <td class="s0"></td>
             </tr>
             <?php foreach ($aEmpenho->empenhos as $empenho) : ?>
             <tr style='height:20px;'>
                <td class="s1" dir="ltr">Empenho</td>
                <td class="s1" dir="ltr">Fornecedor</td>
                <td class="s1" dir="ltr">Vlr. Empenho</td>
                <td class="s1 softmerge" dir="ltr">
                   <div class="softmerge-inner" style="width: 103px; left: -1px;">Data Empenho</div>
                </td>
                <td class="s1" dir="ltr">ID Usuário</td>
                <td class="s2 softmerge bordabottom" dir="ltr">
                   <div class="softmerge-inner " style="width: 198px; left: -1px;">Data Exclusão</div>
                </td>
             </tr>
             <tr style='height:20px;'>
                <td class="s3" dir="ltr"><?= $empenho->e290_e60_codemp ?>/<?= $empenho->e290_e60_anousu ?></td>
                <td class="s4" dir="ltr"><?= $empenho->z01_numcgm ?> - <?= $empenho->z01_nome ?></td>
                <td class="s4" dir="ltr">R$ <?= $empenho->e290_e60_vlremp ?></td>
                <td class="s3" dir="ltr"><?= $empenho->e290_e60_emiss ?></td>
                <td class="s4" dir="ltr"><?= $empenho->id_usuario ?> - <?= $empenho->nome ?></td>
                <td class="s3" dir="ltr"><?= $empenho->e290_dtexclusao ?></td>
             </tr>
             <tr style='height:20px;'>
                <td class="s4"></td>
                <td class="s4"></td>
                <td class="s4"></td>
                <td class="s4"></td>
                <td class="s4"></td>
                <td class="s4"></td>
             </tr>
             <tr style='height:20px;'>
                <td class="s4"></td>
                <td class="s4"></td>
                <td class="s4"></td>
                <td class="s4"></td>
                <td class="s4"></td>
                <td class="s4"></td>
             </tr>
             <tr style='height:20px;'>
                <td class="s4"></td>
                <td class="s4"></td>
                <td class="s4"></td>
                <td class="s4"></td>
                <td class="s4"></td>
                <td class="s4"></td>
             </tr>
             <tr style='height:20px;'>
                <td class="s4"></td>
                <td class="s4"></td>
                <td class="s4"></td>
                <td class="s4"></td>
                <td class="s4"></td>
                <td class="s4"></td>
             </tr>
            <?php endforeach; ?>
          </tbody>
       </table>
    </div>
    <?php endforeach; ?>
</div>
</body>
</html>

<?php

$html = ob_get_contents();

ob_end_clean();

try {

   $mPDF->WriteHTML(utf8_encode($html));
   $mPDF->Output();

} catch (Exception $e) {

  print_r($e->getMessage());

}

?>

