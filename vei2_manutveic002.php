<?

/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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
require('model/relatorios/Relatorio.php');
require("libs/db_utils.php");

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_SERVER_VARS);

$sSql = "SELECT distinct veiculos.ve01_codigo,veiculos.ve01_placa,
ve01_veiccadmarca||'-'||ve21_descr AS marca,
ve01_veiccadmodelo||'-'||veiccadmodelo AS modelo,
ve36_coddepto||'-'||descrdepto AS central
FROM veicmanut
INNER JOIN veiccadtiposervico ON veiccadtiposervico.ve28_codigo = veicmanut.ve62_veiccadtiposervico
INNER JOIN veiculos ON veiculos.ve01_codigo = veicmanut.ve62_veiculos
INNER JOIN veiccadmarca ON veiccadmarca.ve21_codigo = veiculos.ve01_veiccadmarca
INNER JOIN veiccadmodelo ON veiccadmodelo.ve22_codigo = veiculos.ve01_veiccadmodelo

LEFT JOIN veicmanutretirada ON veicmanutretirada.ve65_veicmanut = veicmanut.ve62_codigo

LEFT JOIN empempenho ON ve62_numemp = e60_numemp
LEFT JOIN veiccentral ON ve40_veiculos = ve01_codigo
LEFT JOIN veiccadcentral ON ve40_veiccadcentral = ve36_sequencial
LEFT JOIN db_depart  on  db_depart.coddepto = veiccadcentral.ve36_coddepto
LEFT JOIN db_config  on  db_config.codigo = db_depart.instit";

 $sSql .= " where 1=1";

if($ve01_codigo){
    $sSql .= " and veicmanut.ve62_veiculos in ($ve01_codigo)";
}
if($ve70_dataini){
    $sSql .= " and ve62_dtmanut >= '$ve70_dataini' ";
}
if($ve70_datafin){
    $sSql .= " and ve62_dtmanut <= '$ve70_datafin' ";
}
if($pc60_numcgm){
    $sSql .= " and e60_numcgm = $pc60_numcgm";
}
if($idCentral){
    $sSql .= " and ve40_veiccadcentral = $idCentral";
}
if($ve62_veiccadtiposervico){
    $sSql .= " and ve62_veiccadtiposervico = $ve62_veiccadtiposervico";
}
       //echo $sSql;exit;
$rsResult = db_query($sSql) or die(pg_last_error());//db_criatabela($rsResult);exit;

$mPDF = new Relatorio('', 'A4-L');
$mPDF->addInfo("Manutenção de Veiculos", 2);

ob_start();

?>
<!DOCTYPE html>
<html>
<head>
<title>Relatório</title>
<link rel="stylesheet" type="text/css" href="estilos/relatorios/padrao.style.css">
<style type="text/css">.ritz .waffle a { color: inherit; }.ritz .waffle .s11{border-bottom:0;border-right:0;background-color:#d9d9d9;text-align:center;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s7{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#cccccc;text-align:left;font-weight:bold;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s10{border-bottom:0;background-color:#ffffff;text-align:right;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s12{border-bottom:0;border-right:0;background-color:#d9d9d9;text-align:left;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s2{border-left: none;background-color:#ffffff;text-align:left;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s1{border-left: none;background-color:#ffffff;text-align:right;font-weight:bold;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s4{background-color:#ffffff;text-align:left;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s3{background-color:#ffffff;text-align:right;font-weight:bold;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s5{border-bottom:1px SOLID #000000;background-color:#ffffff;text-align:left;font-weight:bold;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s9{border-bottom:0;background-color:#ffffff;text-align:left;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s6{border-bottom:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s13{border-bottom:0;border-right:0;background-color:#d9d9d9;text-align:right;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s0{background-color:#ffffff;text-align:left;font-weight:bold;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}.ritz .waffle .s8{border-bottom:0;background-color:#ffffff;text-align:center;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:0px 3px 0px 3px;}</style>
</head>
<body>
    <div class="ritz grid-container" dir="ltr">
      <table class="waffle" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th id="19688284C0" style="width:129px" class="column-headers-background">&nbsp;</th>
            <th id="19688284C1" style="width:194px" class="column-headers-background">&nbsp;</th>
            <th id="19688284C2" style="width:87px" class="column-headers-background">&nbsp;</th>
            <th id="19688284C3" style="width:91px" class="column-headers-background">&nbsp;</th>
            <th id="19688284C4" style="width:115px" class="column-headers-background">&nbsp;</th>
            <th id="19688284C5" style="width:100px" class="column-headers-background">&nbsp;</th>
            <th id="19688284C6" style="width:108px" class="column-headers-background">&nbsp;</th>
            <th id="19688284C7" style="width:100px" class="column-headers-background">&nbsp;</th>
            <th id="19688284C8" style="width:100px" class="column-headers-background">&nbsp;</th>
            <th id="19688284C9" style="width:100px" class="column-headers-background">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
              <?php
              for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {
                  $oResult = db_utils::fieldsMemory($rsResult, $iCont);
                  echo <<<HTML
                  <tr style='height:20px;'>
                      <td class="s0" colspan="10">DADOS DO VEICULO:</td>
                  </tr>
                  <tr style='height:20px;'>
                      <td class="s1 softmerge">
                          <div class="softmerge-inner" style="width: 141px; left: -15px;">Codigo do veiculo:</div>
                      </td>
                      <td class="s2" colspan="3">{$oResult->ve01_codigo}</td>
                      <td class="s3">Placa:</td>
                      <td class="s4" colspan="5">{$oResult->ve01_placa}</td>
                  </tr>
                  <tr style='height:20px;'>
                      <td class="s3">Marca:</td>
                      <td class="s4" colspan="3">{$oResult->marca}</td>
                      <td class="s3">Modelo:</td>
                      <td class="s4" colspan="5">{$oResult->modelo}</td>
                  </tr>
                  <tr style='height:20px;'>
                      <td class="s3">Central:</td>
                      <td class="s4" colspan="3">{$oResult->central}</td>
                      <td class="s3"></td>
                      <td class="s4" colspan="5"></td>
                  </tr>
                  <tr style='height:20px;'>
                      <td class="s5">MANUTENÇÕES:</td>
                      <td class="s6" colspan="9"></td>
                  </tr>
                  <tr style='height:20px;'>
                      <td class="s7">Manut.</td>
                      <td class="s7">Tipo de Serviço</td>
                      <td class="s7">Data</td>
                      <td class="s7">Media</td>
                      <td class="s7 softmerge">
                          <div class="softmerge-inner" style="width: 112px; left: -1px;">Vlr. Mão de Obra</div>
                      </td>
                      <td class="s7 softmerge">
                          <div class="softmerge-inner" style="width: 97px; left: -1px;">Vlr. em Peças</div>
                      </td>
                      <td class="s7" colspan="4">Fornecedor</td>
                  </tr>
HTML;


                      $sSql2 = "SELECT distinct ve01_codigo AS veic,
                           ve01_placa,
                           ve01_veiccadmarca||'-'||ve21_descr AS marca,
                           ve01_veiccadmodelo||'-'||veiccadmodelo AS modelo,
                           ve62_codigo AS manutencao,
                           ve62_dtmanut AS dtmanutencao,
                           ve62_vlrmobra AS vlmaoobra,
                           ve62_vlrpecas AS vlpecas,
                           ve62_descr,
                           ve62_notafisc,
                           ve62_medida,
                           ve62_veiccadtiposervico,
                           ve62_vlrmobra,
                           ve62_vlrpecas,
                           ve28_descr,
                           cgm.z01_numcgm||'-'||cgm.z01_nome as fornecedor
                    FROM veicmanut
                    INNER JOIN veiccadtiposervico ON veiccadtiposervico.ve28_codigo = veicmanut.ve62_veiccadtiposervico
                    INNER JOIN veiculos ON veiculos.ve01_codigo = veicmanut.ve62_veiculos
                    INNER JOIN veiccadmarca ON veiccadmarca.ve21_codigo = veiculos.ve01_veiccadmarca
                    INNER JOIN veiccadmodelo ON veiccadmodelo.ve22_codigo = veiculos.ve01_veiccadmodelo
                    INNER JOIN ceplocalidades ON ceplocalidades.cp05_codlocalidades = veiculos.ve01_ceplocalidades
                    INNER JOIN veiccadtipo ON veiccadtipo.ve20_codigo = veiculos.ve01_veiccadtipo
                    INNER JOIN veiccadcor ON veiccadcor.ve23_codigo = veiculos.ve01_veiccadcor
                    INNER JOIN veiccadtipocapacidade ON veiccadtipocapacidade.ve24_codigo = veiculos.ve01_veiccadtipocapacidade
                    LEFT JOIN veicmanutretirada ON veicmanutretirada.ve65_veicmanut = veicmanut.ve62_codigo
                    INNER JOIN veicmanutoficina ON veicmanutoficina.ve66_veicmanut = veicmanut.ve62_codigo
                    LEFT JOIN empempenho ON ve62_numemp = e60_numemp
                    LEFT JOIN cgm ON cgm.z01_numcgm = empempenho.e60_numcgm
                    LEFT JOIN veiccentral ON ve40_veiculos = ve01_codigo";

                      $sSql2 .= " where veiculos.ve01_codigo = $oResult->ve01_codigo ";

                      if ($ve01_codigo) {
                          $sSql2 .= " and veicmanut.ve62_veiculos in ($ve01_codigo)";
                      }
                      if ($ve70_dataini) {
                          $sSql2 .= " and ve62_dtmanut >= '$ve70_dataini' ";
                      }
                      if ($ve70_datafin) {
                          $sSql2 .= " and ve62_dtmanut <= '$ve70_datafin' ";
                      }
                      if ($pc60_numcgm) {
                          $sSql2 .= " and e60_numcgm = $pc60_numcgm";
                      }
                      if ($idCentral) {
                          $sSql2 .= " and ve40_veiccadcentral = $idCentral";
                      }
                      if ($ve62_veiccadtiposervico) {
                          $sSql2 .= " and ve62_veiccadtiposervico = $ve62_veiccadtiposervico";
                      }
                      //echo $sSql2;exit;
                      $rsResult2 = db_query($sSql2) or die(pg_last_error());//db_criatabela($rsResult2);exit;

                      for ($iCont2 = 0; $iCont2 < pg_num_rows($rsResult2); $iCont2++) {
                          $oResult2 = db_utils::fieldsMemory($rsResult2, $iCont2);
                          $datamanut = implode("/", array_reverse(explode("-", $oResult2->dtmanutencao)));
                        echo <<<HTML
                        <tr style="height:20px;">
                            <td class="s8">{$oResult2->manutencao}</td>
                            <td class="s9">{$oResult2->ve28_descr}</td>
                            <td class="s8">$datamanut</td>
                            <td class="s8">{$oResult2->ve62_medida}</td>
                            <td class="s10">{$oResult2->ve62_vlrmobra}</td>
                            <td class="s10">{$oResult2->ve62_vlrpecas}</td>
                            <td class="s9" colspan="4">{$oResult2->fornecedor}</td>
                        </tr>
HTML;
                  }
              }
              ?>
        </tbody>
      </table>
    </div>
</body>
</html>
<?php
$html = ob_get_contents();

ob_end_clean();

$mPDF->WriteHTML(utf8_encode($html));
$mPDF->Output();
