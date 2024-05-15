<?php

include("model/relatorios/Relatorio.php");
include("libs/db_utils.php");
include("std/DBDate.php");
include("libs/db_conecta.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS['QUERY_STRING'], $aFiltros);

$aConsulta = array();
$iInstitui = db_getsession("DB_instit");

try {

  $mes = $aFiltros['mes'];
  $ano = $aFiltros['ano'];

  $sSQL = <<<SQL
    select rh01_regist
      ,z01_nome
      ,rh02_anousu
      ,rh02_mesusu
      ,rh51_basefo
      ,rh51_descfo
      ,rh51_b13fo
      ,rh51_d13fo
      ,CASE
          WHEN rh51_ocorre = '05' THEN '05 - Não exposto no momento'
          WHEN rh51_ocorre = '06' THEN '06 - Exposta (aposentadoria esp. 15 anos)'
          WHEN rh51_ocorre = '07' THEN '07 - Exposta (aposentadoria esp. 20 anos)'
          WHEN rh51_ocorre = '08' THEN '08 - Exposta (aposentadoria esp. 25 anos)'
        END rh51_ocorre
        from rhinssoutros 
          join rhpessoalmov on rh02_seqpes = rh51_seqpes
          join rhpessoal    on rh01_regist = rh02_regist
          join cgm          on z01_numcgm  = rh01_numcgm
            where rh02_mesusu = $mes AND rh02_anousu = $ano AND rh02_instit = $iInstitui
SQL;

  $rsConsulta = db_query($sSQL);
  if (pg_num_rows($rsConsulta) == 0) {
    db_redireciona("db_erros.php?fechar=true&db_erro=Não exitem dados com os parâmetros informados.");
    exit;
  }

  $aConsulta = db_utils::getColectionByRecord($rsConsulta);

  //echo '<pre>';print_r($aConsulta);die;

} catch(Exception $e) {
    echo $e->getMessage();
}

// Configurações do relatório
$head1 = "Desconto Externo de Previdência";
$head2 = "Competência: ".($mes < 10 ? $mes = "0".$mes : $mes)."/$ano";

$mPDF = new Relatorio('', 'A4');
$mPDF->addInfo($head1, 1);
$mPDF->addInfo($head2, 2);
ob_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Relatório</title>
    <link rel="stylesheet" type="text/css" href="estilos/relatorios/padrao.style.css">
    <style type="text/css">
      body {
        font-family: Arial;
      }
      .table {background-color: #fff;border: 1px solid #bbb;text-align: center;font-size: 11px;}
      .table th {border: 1px solid #bbb;background-color: #ddd;padding: 1px 3px;font-size: 10px;}
      .left {text-align: left;}
      ._1 { background-color: #dfe2ff;}
      .pagina { clear: both;  height: 100%; margin-bottom: 0; padding: 0; }/*page-break-after: initial;*/
      #matricula {width: 30px;}
      #nome {width: 200px;}
      #baseinss {width: 45px;}
      #descinss {width: 45px;}
      #base13 {width: 45px;}
      #desc13 {width: 45px;}
      #ocorrencia {width: 150px;}
    </style>
  </head>
  <body>
    <div class="pagina">
      <table class="table">
          <thead>
            <tr>
              <th id="matricula">Matricula</th>
              <th id="nome">Nome</th>
              <th id="baseinss">Base INSS</th>
              <th id="descinss">Desconto INSS</th>
              <th id="base13">Base 13o sal INSS</th>
              <th id="desc13">Desconto 13o sal INSS</th>
              <th id="ocorrencia">Ocorrência</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($aConsulta as $aRegistro) : ?>
            <tr class="_<?php echo ($contador % 2 == 0) ?>">
              <td><?= $aRegistro->rh01_regist ?></td>
              <td><?= $aRegistro->z01_nome ?></td>
              <td><?= $aRegistro->rh51_basefo ?></td>
              <td><?= $aRegistro->rh51_descfo ?></td>
              <td><?= $aRegistro->rh51_b13fo ?></td>
              <td><?= $aRegistro->rh51_d13fo ?></td>
              <td><?= $aRegistro->rh51_ocorre ?></td>
            </tr>
            <?php ++$contador; endforeach; ?>
          </tbody>
        </table>
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