<?php

include("model/relatorios/Relatorio.php");
include("libs/db_utils.php");
include("std/DBDate.php");
include("libs/db_conecta.php");
include("dbforms/db_funcoes.php");
include("fpdf151/pdf.php");

$aConsulta = array();

parse_str($HTTP_SERVER_VARS['QUERY_STRING'], $aFiltros);
// print_r($aFiltros);die();

try{
    $situacao = ",case when sum(m41_quant) = sum(m43_quantatend) then 'ATENDIDA'
                      when coalesce(sum(m43_quantatend),0) = 0 then 'NÃO ATENDIDA'
                      when coalesce(sum(m43_quantatend),0) > 0 and coalesce(sum(m43_quantatend),0) < coalesce((SELECT SUM(m41_quant)
                       FROM matrequiitem WHERE m41_codmatrequi = m40_codigo ),0) then 'PARCIALMENTE ATENDIDA'
                       end as situacao";
   $where_matrequi = "";
  if ($atendimento == "a") {
    $atendimento = 'Atendidas';
    $where_matrequi .= " and atendrequiitem.m43_codmatrequiitem is not null     ";
    $where_matrequi .= "  group by m40_codigo,                                  ";
    $where_matrequi .= "    m40_almox,                                          ";
    $where_matrequi .= "    m40_data,                                           ";
    $where_matrequi .= "    m40_depto,                                          ";
    $where_matrequi .= "    d.descrdepto,                                       ";
    $where_matrequi .= "    a.descrdepto                                        ";
    $where_matrequi .= "    having sum(m41_quant) = sum(m43_quantatend)         ";

  // se for pedido para mostrar atendimento não atendidos
  } else if ($atendimento == "na") {
    $atendimento = 'Não Atendidas';
    $where_matrequi .= " group by m40_codigo,                          ";
    $where_matrequi .= "    m40_almox,                                 ";
    $where_matrequi .= "    m40_data,                                  ";
    $where_matrequi .= "    m40_depto,                                 ";
    $where_matrequi .= "    d.descrdepto,                              ";
    $where_matrequi .= "    a.descrdepto,                              ";
    $where_matrequi .= "    atendrequiitem.m43_quantatend              ";
    $where_matrequi .= "    having coalesce(sum(m43_quantatend),0) = 0 ";

  // se for pedido para mostrar os atendimentos parcialmente atendidos
  } else if ($atendimento == "pa") {
    $atendimento = 'Parcialmente Atendidas';
    $where_matrequi .= " group by m40_codigo,                                       ";
    $where_matrequi .= "    m40_almox,                                              ";
    $where_matrequi .= "    m40_data,                                               ";
    $where_matrequi .= "    m40_depto,                                              ";
    $where_matrequi .= "    d.descrdepto,                                           ";
    $where_matrequi .= "    a.descrdepto,                                           ";
    $where_matrequi .= "    m40_depto                                               ";
    $where_matrequi .= "    having coalesce(sum(m43_quantatend),0) > 0 and          ";
    $where_matrequi .= "           coalesce(sum(m43_quantatend),0) < coalesce((SELECT SUM(m41_quant)
                                                                                 FROM matrequiitem
                                                                                WHERE m41_codmatrequi = m40_codigo ),0) ";

  } else {
    $atendimento = 'Todas';
    $where_matrequi .= " group by m40_codigo,                                       ";
    $where_matrequi .= "    m40_almox,                                              ";
    $where_matrequi .= "    m40_data,                                               ";
    $where_matrequi .= "    m40_depto,                                              ";
    $where_matrequi .= "    d.descrdepto,                                           ";
    $where_matrequi .= "    a.descrdepto                                            ";
  }

  $ordenacao  = "order by m40_codigo,            ";
  $ordenacao .= "         m40_almox,             ";
  $ordenacao .= "         m40_data,              ";
  $ordenacao .= "         m40_depto,             ";
  $ordenacao .= "         d.descrdepto,          ";
  $ordenacao .= "         a.descrdepto           ";


  if (isset($aFiltros['ini']) && !empty($aFiltros['ini'])) {
        $requisicao_ini = $aFiltros['ini'];
  }

  if (isset($aFiltros['fim']) && !empty($aFiltros['fim'])) {
        $requisicao_fim = $aFiltros['fim'];
  }

  if(isset($requisicao_ini) && isset($requisicao_fim)){
    $filtros_requisicoes = " and m40_codigo >= {$requisicao_ini} and m40_codigo <= {$requisicao_fim}";
  }

  if (isset($aFiltros['perini']) && !empty($aFiltros['perini'])) {
        $periodo_ini = trim(implode("-",array_reverse(explode("/",$aFiltros['perini']))));
  }

  if (isset($aFiltros['perfim']) && !empty($aFiltros['perfim'])) {
        $periodo_fim = trim(implode("-",array_reverse(explode("/",$aFiltros['perfim']))));
  }

  if (isset($aFiltros['coddepto']) && !empty($aFiltros['coddepto'])) {
        $coddepto = $aFiltros['coddepto'];
        $filtro_depart = "(m40_depto = {$coddepto})";
  }else $filtro_depart = "";

  if (isset($aFiltros['almox']) && !empty($aFiltros['almox'])) {
    $almoxarifado = $aFiltros['almox'];
    if($coddepto)
        $filtro_almox = " and ";
    $filtro_almox .=  "(m91_codigo = {$almoxarifado})";
  }else $filtro_almox = "";

  if (isset($aFiltros['tObserva']) && !empty($aFiltros['tObserva'])) {
        $observacao = $aFiltros['tObserva'];
  }

  if (isset($aFiltros['departamento']) && !empty($aFiltros['departamento'])) {
        $departamento = $aFiltros['departamento'];
  }

  $sSQL = "
            SELECT m40_codigo,
                   m40_data,
                   m40_almox,
                   a.descrdepto descralmox,
                   m40_depto,
                   d.descrdepto descrdepart
                   {$situacao}
            FROM matrequi
            INNER JOIN matrequiitem ON matrequiitem.m41_codmatrequi = matrequi.m40_codigo
            INNER JOIN db_usuarios ON db_usuarios.id_usuario = matrequi.m40_login
            INNER JOIN db_depart d ON d.coddepto = matrequi.m40_depto
            LEFT JOIN atendrequiitem ON atendrequiitem.m43_codmatrequiitem = matrequiitem.m41_codigo
            LEFT JOIN atendrequi ON atendrequi.m42_codigo = atendrequiitem.m43_codatendrequi
            LEFT JOIN db_almox ON matrequi.m40_almox = db_almox.m91_codigo
            LEFT JOIN db_depart a on a.coddepto = db_almox.m91_depto
            WHERE
            ";

            if(!empty($filtro_depart) || !empty($filtro_almox)){

              $sSQL .= "({$filtro_depart}{$filtro_almox}) and ";

            }

            $sSQL .= " m40_data BETWEEN '{$periodo_ini}' AND '{$periodo_fim}'
                {$filtros_requisicoes}
            ";

  $sSQL .= $where_matrequi;
  $sSQL .= $ordenacao;
  $rsConsulta = db_query($sSQL);//die($sSQL);
  $aConsulta = pg_fetch_all($rsConsulta);

  if ($aConsulta === false) {
    throw new Exception("Não foi possível imprimir comprovante! Entrar em contato com o setor de Desenvolvimento", 1);
  }

} catch (Exception $e) {
    echo $e->getMessage();
}

$aResult = array();


$head3 = "Relatório de Requisições";
$data_inicial = trim(implode("/",array_reverse(explode("-",$periodo_ini))));
$data_final   = trim(implode("/",array_reverse(explode("-",$periodo_fim))));
$head5 = "De ".$data_inicial." até ".$data_final;
$head7 = "Tipo de Requisição: ".$atendimento;

$pdf = new PDF(); // abre a classe
$pdf->Open(); // abre o relatorio
$pdf->AddPage('L'); // adiciona uma pagina
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(235);
$tam = '04';
$alt = 4;
$pdf->SetFont("","B","");

$pdf->Cell(26,$tam,"REQUISIÇÃO",1,0,"C",1);
$pdf->Cell(40,$tam,"SITUAÇÃO",1,0,"C",1);
$pdf->Cell(26,$tam,"DATA",1,0,"C",1);
$pdf->Cell(104,$tam,"DEPARTAMENTO SOLICITANTE",1,0,"C",1);
$pdf->Cell(85,$tam,"ALMOXARIFADO ORIGEM",1,1,"C",1);


foreach ($aConsulta as $aResultados) {
    $iRequisicao = trim($aResultados['m40_codigo']);

  if(!isset($aResultados[$iRequisicao])){
    $oNovaRequisicao = new stdClass();
    $oNovaRequisicao->m40_codigo  = trim($iRequisicao);
    if($aResultados['situacao']){
      $oNovaRequisicao->atendimento = trim($aResultados['situacao']);
    }else $oNovaRequisicao->atendimento = "-";
    $oNovaRequisicao->m40_data    = trim(date("d/m/Y",strtotime($aResultados['m40_data'])));
    $oNovaRequisicao->descrdepart = trim($aResultados['descrdepart']);
    $oNovaRequisicao->descralmox  = trim($aResultados['descralmox']);
    $aResult[$iRequisicao] = $oNovaRequisicao;
  }
}

foreach ($aResult as $resultado) {

  $pdf->cell(26,$tam,$resultado->m40_codigo,1,0,"C",0);
  $pdf->cell(40,$tam,$resultado->atendimento,1,0,"C",0);
  $pdf->cell(26,$tam,$resultado->m40_data,1,0,"C",0);
  $pdf->cell(104,$tam,$resultado->descrdepart,1,0,"C",0);
  $pdf->cell(85,$tam,$resultado->descralmox,1,0,"C",0);
  $pdf->ln();
}
$pdf->Output();
?>
