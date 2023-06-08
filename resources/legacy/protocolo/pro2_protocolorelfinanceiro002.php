<?php

include("model/relatorios/Relatorio.php");
include("libs/db_utils.php");
include("std/DBDate.php");
include("libs/db_conecta.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS['QUERY_STRING'], $aFiltros);

$aConsulta   = array();
$sSQL        = "";
$whereFiltro = "";
$orderby     = "";
$quebra      = "";
$campoQuebra = "";
$textoQuebra = "";

$filtroAutPag = "";
$filtroSlip   = "";
$tpimpressao  = "";
$nomeFiltro   = "";
$ordenado     = "";

try {
    $tpimpressao = $aFiltros['tpimpressao'];
    switch ($tpimpressao) {
      case 'a':
        $dtini = $aFiltros['dtini'];
        $dtfim = $aFiltros['dtfim'];
        if (!empty($dtini) && !empty($dtfim)) {
          $whereFiltro .= " WHERE dtautorizacao BETWEEN '{$dtini}' AND '{$dtfim}'";
        }
        $filtro = $aFiltros['filtro'];
        switch ($filtro) {
          case "sp":
            $filtroAutPag = " WHERE e53_vlrpag >= 0 AND e53_vlrpag < e53_valor AND e53_vlranu = 0 ";
            $filtroSlip   = " WHERE k17_situacao = 1 ";
            $nomeFiltro   = "Saldo a Pagar";
          break;
          case "tp":
            $filtroAutPag = " WHERE e53_vlrpag - e53_valor = 0 AND e53_vlranu = 0 ";
            $filtroSlip   = " WHERE k17_situacao = 2 ";
            $nomeFiltro   = "Pagas";
          break;
          case "a":
            $filtroAutPag = " WHERE e53_valor = e53_vlranu OR e53_vlrpag = e53_vlranu ";
            $filtroSlip   = " WHERE k17_situacao = 3 OR k17_situacao = 4 ";
            $nomeFiltro   = "Anuladas";
          break;
          case "pa":
            $filtroAutPag = " WHERE e53_vlranu > 0 AND e53_vlranu < e53_valor ";
            $nomeFiltro   = "Parc. Anulada";
          break;
        }

        $quebra = $aFiltros['quebra'];
        switch ($quebra) {
          case "cr":
            $campoQuebra = "z01_numcgm";
            $textoQuebra = "CREDOR";
            $orderby = " ORDER BY ORDSLIP.z01_numcgm ";
          break;
          case "re":
            $campoQuebra = "codrecurso";
            $textoQuebra = "RECURSO";
            $orderby = " ORDER BY ORDSLIP.codrecurso ";
          break;
          case "si":
            $campoQuebra = "situacao";
            $textoQuebra = "SITUAÇÃO";
            $orderby = " ORDER BY ORDSLIP.situacao ";
          break;
          default:
            $campoQuebra = "";
          break;
        }

        $ordem = $aFiltros['ordem'];
        switch ($ordem) {
          case "nos":
            if(!empty($orderby)) {
              $orderby .= " ,ORDSLIP.ordslip ";
            } else {
                $orderby = " ORDER BY ORDSLIP.ordslip ";
            }
            $ordenado = "Nº Ord/Slip";
          break;
          case "da":
            if(!empty($orderby)) {
              $orderby .= " ,ORDSLIP.dtautorizacao ";
            } else {
                $orderby = " ORDER BY ORDSLIP.dtautorizacao ";
            }
            $ordenado = "Data Autorização";
          break;
          case "dos":
            if(!empty($orderby)) {
              $orderby .= " ,ORDSLIP.dataopslip ";
            } else {
                $orderby = " ORDER BY ORDSLIP.dataopslip ";
            }
            $ordenado = "Data OP/Slip";
          break;
          case "p":
            if(!empty($orderby)) {
              $orderby .= " ,ORDSLIP.protocolo ";
            } else {
                $orderby = " ORDER BY ORDSLIP.protocolo ";
            }
            $ordenado = "Protocolo";
          break;
          case "s":
            if(!empty($orderby)) {
              $orderby .= " ,ORDSLIP.situacao ";
            } else {
                $orderby = " ORDER BY ORDSLIP.situacao";
            }
            $ordenado = "Situação";
          break;
        }

        if (!empty($aFiltros['e53_codord'])) {
          $e53_codord = $aFiltros['e53_codord'];
          if(!empty($filtroAutPag)) {
            $filtroAutPag .= " AND e53_codord = {$e53_codord} ";
          } else {
              $filtroAutPag = " WHERE e53_codord = {$e53_codord} ";
          }
        }

        if (!empty($aFiltros['e60_codemp'])) {
          $empenho = $aFiltros['e60_codemp'];
          $emp = explode("/", $empenho);
          $e60_codemp = $emp[0];
          $e60_anousu = $emp[1];
          if(!empty($filtroAutPag)) {
            $filtroAutPag .= " AND e60_codemp = '{$e60_codemp}' AND e60_anousu = {$e60_anousu} ";
          } else {
              $filtroAutPag = " WHERE e60_codemp = '{$e60_codemp}' AND e60_anousu = {$e60_anousu} ";
          }
        }

        if (!empty($aFiltros['k17_codigo'])) {
          $k17_codigo = $aFiltros['k17_codigo'];
          if(!empty($filtroSlip)) {
            $filtroSlip .= " AND k17_codigo = {$k17_codigo} ";
          } else {
              $filtroSlip = " WHERE k17_codigo = {$k17_codigo} ";
          }
        }

        $sqlORDEMP = "
          SELECT DISTINCT pagordem.e50_codord ordslip,
             e60_codemp empenho,
             e60_anousu anousu,
             cgm.z01_numcgm,
             cgm.z01_nome,
             to_char(e50_data,'DD/MM/YYYY') dataopslip,
             orctiporec.o15_codtri codrecurso,
             orctiporec.o15_descr nomerecurso,
             pagordemele.e53_valor valor,
             to_char(p107_dt_cadastro,'DD/MM/YYYY') dtautorizacao,
             protocolos.p101_sequencial protocolo,
             CASE
                WHEN (e53_vlrpag >= 0 AND e53_vlrpag < e53_valor AND e53_vlranu = 0)
                  THEN 'Saldo a Pagar'
                WHEN (e53_vlrpag - e53_valor = 0 AND e53_vlranu = 0)
                  THEN 'Tot. Pago'
                WHEN (e53_valor = e53_vlranu OR e53_vlrpag = e53_vlranu)
                  THEN 'Anulado'
                WHEN (e53_vlranu > 0 AND e53_vlranu < e53_valor)
                  THEN 'Parc. Anulado'
              END AS situacao
          FROM pagordemele
          INNER JOIN pagordem ON pagordem.e50_codord = pagordemele.e53_codord
          INNER JOIN protpagordem ON protpagordem.p105_codord = pagordem.e50_codord
          INNER JOIN empempenho ON empempenho.e60_numemp = pagordem.e50_numemp
          INNER JOIN orcelemento ON orcelemento.o56_codele = pagordemele.e53_codele
          INNER JOIN orcdotacao ON orcdotacao.o58_coddot = empempenho.e60_coddot
            AND orcdotacao.o58_anousu = empempenho.e60_anousu
            AND orcdotacao.o58_instit = empempenho.e60_instit
          INNER JOIN orctiporec ON orctiporec.o15_codigo = orcdotacao.o58_codigo
          INNER JOIN cgm ON cgm.z01_numcgm = empempenho.e60_numcgm
            AND orcelemento.o56_anousu = empempenho.e60_anousu
          INNER JOIN autprotpagordem on autprotpagordem.p107_codord = pagordem.e50_codord
          INNER JOIN protocolos ON protocolos.p101_sequencial = autprotpagordem.p107_protocolo
          {$filtroAutPag}
        ";

        $sqlSLIP = "
          SELECT DISTINCT slip.k17_codigo ordslip,
              '-' empenho,
              0000 anousu,
              cgm.z01_numcgm,
              cgm.z01_nome,
              to_char(k17_data,'DD/MM/YYYY') dataopslip,
              orctiporec.o15_codtri codrecurso,
              orctiporec.o15_descr nomerecurso,
              slip.k17_valor valor,
              to_char(p108_dt_cadastro,'DD/MM/YYYY') dtautorizacao,
              protocolos.p101_sequencial protocolo,
              CASE
                WHEN k17_situacao  = 1 then 'Saldo a Pagar'
                WHEN k17_situacao  = 2 then 'Tot. Pago'
                WHEN (k17_situacao = 3 OR k17_situacao = 4) then 'Anulado'
              END AS situacao
         FROM slip
         INNER JOIN protslip ON protslip.p106_slip = slip.k17_codigo
         INNER JOIN autprotslip ON autprotslip.p108_slip = protslip.p106_slip
         INNER JOIN protocolos ON protocolos.p101_sequencial = autprotslip.p108_protocolo
         LEFT JOIN conplanoreduz r1 ON r1.c61_reduz  = k17_debito
          AND r1.c61_instit = k17_instit
         INNER JOIN orctiporec ON orctiporec.o15_codigo = r1.c61_codigo
         LEFT JOIN conplano c1 ON c1.c60_codcon = r1.c61_codcon
          AND c1.c60_anousu = r1.c61_anousu
         LEFT JOIN conplanoreduz r2 ON r2.c61_reduz = k17_credito
          AND r2.c61_instit = k17_instit
         LEFT JOIN conplano c2 ON c2.c60_codcon = r2.c61_codcon
          AND c2.c60_anousu = r2.c61_anousu
         LEFT JOIN slipnum ON slipnum.k17_codigo = slip.k17_codigo
         LEFT JOIN cgm ON cgm.z01_numcgm = slipnum.k17_numcgm
         LEFT JOIN slipprocesso ON slip.k17_codigo = slipprocesso.k145_slip
         {$filtroSlip}
        ";

        if (empty($aFiltros['e53_codord']) && empty($aFiltros['k17_codigo']) && empty($aFiltros['e60_codemp'])) {
          if (empty($ordem)) {
            if (!empty($orderby)) {
              $orderby .= " ,ORDSLIP.ordslip ";
            } else {
                $orderby .= " ORDER BY ORDSLIP.ordslip ";
            }
          }
          if (!empty($aFiltros['z01_numcgm'])) {
            $z01_numcgm = $aFiltros['z01_numcgm'];
            if (!empty($whereFiltro)) {
              $whereFiltro .= " AND ORDSLIP.z01_numcgm = {$z01_numcgm} ";
            } else {
                $whereFiltro .= " WHERE ORDSLIP.z01_numcgm = {$z01_numcgm} ";
            }
          }
          $sSQL = "SELECT *
                    FROM ($sqlORDEMP UNION $sqlSLIP) AS ORDSLIP
                      {$whereFiltro}
                        {$orderby}
                  ";

        } else {
            if (!empty($ordem)) {
              $orderby .= " ,ORDSLIP.ordslip ";
            } else {
                $orderby .= " ORDER BY ORDSLIP.ordslip ";
            }
            if (!empty($aFiltros['e53_codord']) || !empty($aFiltros['e60_codemp'])) {
              if (!empty($aFiltros['z01_numcgm'])) {
                if(!empty($whereFiltro)) {
                  $whereFiltro .= " AND ORDSLIP.z01_numcgm = {$z01_numcgm} ";
                } else {
                    $whereFiltro = " WHERE ORDSLIP.z01_numcgm = {$z01_numcgm} ";
                }
              }
              $sSQL = "SELECT *
                        FROM ($sqlORDEMP) AS ORDSLIP
                          {$whereFiltro}
                            {$orderby}
                  ";
            }
            else if (!empty($aFiltros['k17_codigo'])) {
              if (!empty($aFiltros['z01_numcgm'])) {
                if(!empty($whereFiltro)) {
                  $whereFiltro .= " AND ORDSLIP.z01_numcgm = {$z01_numcgm} ";
                } else {
                    $whereFiltro = " WHERE ORDSLIP.z01_numcgm = {$z01_numcgm} ";
                }
              }
              $sSQL = "SELECT *
                        FROM ($sqlSLIP) AS ORDSLIP
                          {$whereFiltro}
                            {$orderby}
                  ";
            }
        }

      break;
      //Relatório Sintético
      case 's' :
        $dtini = $aFiltros['dtini'];
        $dtfim = $aFiltros['dtfim'];
        if (!empty($dtini) && !empty($dtfim)) {
          $whereFiltro .= " WHERE dtautorizacao BETWEEN '{$dtini}' AND '{$dtfim}'";
        }
        if (!empty($aFiltros['e53_codord'])) {
          $e53_codord = $aFiltros['e53_codord'];
          $filtroAutPag = " AND e53_codord = {$e53_codord} ";
        }

        if (!empty($aFiltros['e60_codemp'])) {
          $empenho = $aFiltros['e60_codemp'];
          $emp = explode("/", $empenho);
          $e60_codemp = $emp[0];
          $e60_anousu = $emp[1];
          $filtroAutPag .= " AND e60_codemp = '{$e60_codemp}' AND e60_anousu = {$e60_anousu} ";
        }

        if (!empty($aFiltros['k17_codigo'])) {
          $k17_codigo = $aFiltros['k17_codigo'];
          $filtroSlip .= " AND k17_codigo = {$k17_codigo} ";
        }
        $sqlORDEMP = "
          SELECT DISTINCT pagordem.e50_codord ordslip,
             cgm.z01_numcgm,
             cgm.z01_nome,
             orctiporec.o15_codtri codrecurso,
             orctiporec.o15_descr nomerecurso,
             to_char(p107_dt_cadastro,'DD/MM/YYYY') dtautorizacao,
             total.e53_valor valor
          FROM pagordemele
          INNER JOIN pagordem ON pagordem.e50_codord = pagordemele.e53_codord
          INNER JOIN protpagordem ON protpagordem.p105_codord = pagordem.e50_codord
          INNER JOIN empempenho ON empempenho.e60_numemp = pagordem.e50_numemp
          INNER JOIN orcelemento ON orcelemento.o56_codele = pagordemele.e53_codele
          INNER JOIN orcdotacao ON orcdotacao.o58_coddot = empempenho.e60_coddot
            AND orcdotacao.o58_anousu = empempenho.e60_anousu
            AND orcdotacao.o58_instit = empempenho.e60_instit
          INNER JOIN orctiporec ON orctiporec.o15_codigo = orcdotacao.o58_codigo
          INNER JOIN cgm ON cgm.z01_numcgm = empempenho.e60_numcgm
            AND orcelemento.o56_anousu = empempenho.e60_anousu
          INNER JOIN (
            select sum(e53_valor) as e53_valor, o15_codigo, e60_numcgm
             from empempenho
              inner join cgm ON z01_numcgm = e60_numcgm
              inner join pagordem on e50_numemp = e60_numemp and e50_anousu = e60_anousu
              inner join pagordemele on e53_codord = e50_codord
              inner join autprotpagordem ON p107_codord = e50_codord
              inner join protocolos on p101_sequencial = p107_protocolo
              inner join orcdotacao ON o58_coddot = e60_coddot
                and orcdotacao.o58_anousu = empempenho.e60_anousu
                and orcdotacao.o58_instit = empempenho.e60_instit
              inner join  orctiporec ON o15_codigo = o58_codigo
               where e53_vlrpag >= 0
               and e53_vlrpag < e53_valor
               and e53_vlranu = 0
                group by o15_codigo, e60_numcgm
          ) AS total ON total.o15_codigo = orctiporec.o15_codigo and total.e60_numcgm = empempenho.e60_numcgm
          INNER JOIN autprotpagordem on autprotpagordem.p107_codord = pagordem.e50_codord
          INNER JOIN protocolos ON protocolos.p101_sequencial = autprotpagordem.p107_protocolo
            WHERE pagordemele.e53_vlrpag >= 0
             AND pagordemele.e53_vlrpag < pagordemele.e53_valor
             AND pagordemele.e53_vlranu = 0
          {$filtroAutPag}
        ";

        $sqlSLIP = "
          SELECT DISTINCT slip.k17_codigo ordslip,
              cgm.z01_numcgm,
              cgm.z01_nome,
              orctiporec.o15_codtri codrecurso,
              orctiporec.o15_descr nomerecurso,
              to_char(p108_dt_cadastro,'DD/MM/YYYY') dtautorizacao,
              slip.k17_valor valor
         FROM slip
         INNER JOIN protslip ON protslip.p106_slip = slip.k17_codigo
         INNER JOIN autprotslip ON autprotslip.p108_slip = protslip.p106_slip
         INNER JOIN protocolos ON protocolos.p101_sequencial = autprotslip.p108_protocolo
         LEFT JOIN conplanoreduz r1 ON r1.c61_reduz  = k17_debito
          AND r1.c61_instit = k17_instit
         INNER JOIN orctiporec ON orctiporec.o15_codigo = r1.c61_codigo
         LEFT JOIN conplano c1 ON c1.c60_codcon = r1.c61_codcon
          AND c1.c60_anousu = r1.c61_anousu
         LEFT JOIN conplanoreduz r2 ON r2.c61_reduz = k17_credito
          AND r2.c61_instit = k17_instit
         LEFT JOIN conplano c2 ON c2.c60_codcon = r2.c61_codcon
          AND c2.c60_anousu = r2.c61_anousu
         LEFT JOIN slipnum ON slipnum.k17_codigo = slip.k17_codigo
         LEFT JOIN cgm ON cgm.z01_numcgm = slipnum.k17_numcgm
         LEFT JOIN slipprocesso ON slip.k17_codigo = slipprocesso.k145_slip
          WHERE k17_situacao = 1
         {$filtroSlip}
        ";

        if (empty($aFiltros['e53_codord']) && empty($aFiltros['k17_codigo']) && empty($aFiltros['e60_codemp'])) {
          if (!empty($aFiltros['z01_numcgm'])) {
            $z01_numcgm = $aFiltros['z01_numcgm'];
            if (!empty($whereFiltro)) {
              $whereFiltro .= " AND ORDSLIP.z01_numcgm = {$z01_numcgm} ";
            } else {
                $whereFiltro .= " WHERE ORDSLIP.z01_numcgm = {$z01_numcgm} ";
            }
          }
          $sSQL = "SELECT *
                    FROM ($sqlORDEMP UNION $sqlSLIP) AS ORDSLIP
                      {$whereFiltro}
                      ORDER BY ORDSLIP.codrecurso, ORDSLIP.z01_numcgm, ORDSLIP.ordslip
                  ";

        } else {
            if (!empty($aFiltros['e53_codord']) || !empty($aFiltros['e60_codemp'])) {
              if (!empty($aFiltros['z01_numcgm'])) {
                $z01_numcgm = $aFiltros['z01_numcgm'];
                if(!empty($whereFiltro)) {
                  $whereFiltro .= " AND ORDSLIP.z01_numcgm = {$z01_numcgm} ";
                } else {
                    $whereFiltro = " WHERE ORDSLIP.z01_numcgm = {$z01_numcgm} ";
                }
              }
              $sSQL = "SELECT *
                        FROM ($sqlORDEMP) AS ORDSLIP
                          {$whereFiltro}
                          ORDER BY codrecurso, z01_numcgm, ordslip
                  ";
            }
            else if (!empty($aFiltros['k17_codigo'])) {
              if (!empty($aFiltros['z01_numcgm'])) {
                if(!empty($whereFiltro)) {
                  $whereFiltro .= " AND ORDSLIP.z01_numcgm = {$z01_numcgm} ";
                } else {
                    $whereFiltro = " WHERE ORDSLIP.z01_numcgm = {$z01_numcgm} ";
                }
              }
              $sSQL = "SELECT *
                        FROM ($sqlSLIP) AS ORDSLIP
                          {$whereFiltro}
                      ORDER BY ORDSLIP.codrecurso, ORDSLIP.z01_numcgm, ORDSLIP.ordslip
                  ";
            }
        }
      break;
    }
  $rsConsulta = db_query($sSQL);
  if (pg_num_rows($rsConsulta) == 0) {
    db_redireciona("db_erros.php?fechar=true&db_erro=Não exitem dados com os parâmetros informados.");
    exit;
  }

  $aConsulta = pg_fetch_all($rsConsulta);
  if ($aConsulta === false) {
    throw new Exception("Não foi possível imprimir Relatório! Entrar em contato com o setor de Desenvolvimento", 1);
  }

} catch (Exception $e) {
    echo $e->getMessage();
}
//echo "<pre>"; ini_set("display_errors", true);
$aOpSlips    = array();
$valortotal  = 0;
$totalquebra = 0;
switch ($tpimpressao) {
  case 'a':
    switch ($campoQuebra) {
      case '' :
        foreach ($aConsulta as $aOpSlip) {
            $oNovoOrdemSlip = new stdClass();
            $oNovoOrdemSlip->ordslip       = $aOpSlip['ordslip'];
            $oNovoOrdemSlip->empenho       = ($aOpSlip['empenho'] != '-') ? $aOpSlip['empenho']."/".$aOpSlip['anousu'] : '-' ;
            $oNovoOrdemSlip->z01_numcgm    = $aOpSlip['z01_numcgm'];
            $oNovoOrdemSlip->z01_nome      = $aOpSlip['z01_nome'];
            $oNovoOrdemSlip->dataopslip    = $aOpSlip['dataopslip'];
            $oNovoOrdemSlip->codrecurso    = $aOpSlip['codrecurso'];
            $oNovoOrdemSlip->nomerecurso   = $aOpSlip['nomerecurso'];
            $oNovoOrdemSlip->valor         = $aOpSlip['valor'];
            $oNovoOrdemSlip->dtautorizacao = $aOpSlip['dtautorizacao'];
            $oNovoOrdemSlip->protocolo     = $aOpSlip['protocolo'];
            $oNovoOrdemSlip->situacao      = $aOpSlip['situacao'];
            $valortotal += $aOpSlip['valor'];
            $aOpSlips[] = $oNovoOrdemSlip;
        }
      break;
      default:
        foreach ($aConsulta as $aOpSlip) {

          $iQuebra   = $aOpSlip[$campoQuebra];
          $iEmpenho  = ($aOpSlip['empenho'] != '-') ? $aOpSlip['empenho']."/".$aOpSlip['anousu'] : '-' ;
          $iOrdslip  = $aOpSlip['ordslip'];
          $iOrdslipp = $aOpSlip['ordslip']."-".$iEmpenho;


          if (!isset($aOpSlips[$iQuebra])) {
            $oNovoQuebra = new stdClass();
            switch ($campoQuebra) {
              case 'z01_numcgm' :
                $oNovoQuebra->z01_numcgm  = $iQuebra;
                $oNovoQuebra->z01_nome    = $aOpSlip['z01_nome'];
                $oNovoQuebra->ordempslips = array();
                $aOpSlips[$iQuebra]       = $oNovoQuebra;
              break;
              case 'codrecurso' :
                $oNovoQuebra->codrecurso  = $iQuebra;
                $oNovoQuebra->nomerecurso = $aOpSlip['nomerecurso'];
                $oNovoQuebra->ordempslips = array();
                $aOpSlips[$iQuebra]       = $oNovoQuebra;
              break;
              case 'situacao' :
                $oNovoQuebra->codsituacao = $iQuebra;
                $oNovoQuebra->situacao    = $aOpSlip['situacao'];
                $oNovoQuebra->ordempslips = array();
                $aOpSlips[$iQuebra]       = $oNovoQuebra;
              break;
            }

          }

          if (!isset($aOpSlips[$iQuebra]->ordempslips[$iOrdslipp])) {

            $valortotal += $aOpSlip['valor'];
            $oNovoOrdemSlip = new stdClass();
            $oNovoOrdemSlip->ordslip       = $iOrdslip;
            $oNovoOrdemSlip->empenho       = ($aOpSlip['empenho'] != '-') ? $aOpSlip['empenho']."/".$aOpSlip['anousu'] : '-' ;
            $oNovoOrdemSlip->z01_numcgm    = $aOpSlip['z01_numcgm'];
            $oNovoOrdemSlip->z01_nome      = $aOpSlip['z01_nome'];
            $oNovoOrdemSlip->dataopslip    = $aOpSlip['dataopslip'];
            $oNovoOrdemSlip->codrecurso    = $aOpSlip['codrecurso'];
            $oNovoOrdemSlip->nomerecurso   = $aOpSlip['nomerecurso'];
            $oNovoOrdemSlip->valor         = $aOpSlip['valor'];
            $oNovoOrdemSlip->dtautorizacao = $aOpSlip['dtautorizacao'];
            $oNovoOrdemSlip->protocolo     = $aOpSlip['protocolo'];
            $oNovoOrdemSlip->situacao      = $aOpSlip['situacao'];

            $aOpSlips[$iQuebra]->ordempslips[$iOrdslipp] = $oNovoOrdemSlip;
          }
        }
      break;
    }
  break;
  case 's':
    foreach ($aConsulta as $aOpSlip) {

      $iQuebra = $aOpSlip['codrecurso'];
      $iCredor = $aOpSlip['z01_numcgm'];

      if (!isset($aOpSlips[$iQuebra])) {
        $oNovoQuebra = new stdClass();
        $oNovoQuebra->codrecurso  = $iQuebra;
        $oNovoQuebra->nomerecurso = $aOpSlip['nomerecurso'];
        $oNovoQuebra->ordempslips = array();
        $aOpSlips[$iQuebra]       = $oNovoQuebra;

      }

      if (!isset($aOpSlips[$iQuebra]->ordempslips[$iCredor])) {

        $valortotal += $aOpSlip['valor'];
        $oNovoOrdemSlip = new stdClass();
        $oNovoOrdemSlip->ordslip     = $iCredor;
        $oNovoOrdemSlip->z01_numcgm  = $aOpSlip['z01_numcgm'];
        $oNovoOrdemSlip->z01_nome    = $aOpSlip['z01_nome'];
        $oNovoOrdemSlip->codrecurso  = $aOpSlip['codrecurso'];
        $oNovoOrdemSlip->nomerecurso = $aOpSlip['nomerecurso'];
        $oNovoOrdemSlip->valor       = $aOpSlip['valor'];

        $aOpSlips[$iQuebra]->ordempslips[$iCredor] = $oNovoOrdemSlip;

      }
    }
  break;
  default:

  break;
}
// Configurações do relatório
$head1 = "Relatório Financeiro";
$head2 = "Quebra: ".$textoQuebra;
$head3 = "Tipo: ";
$head3.= $tpimpressao == 'a' ? "Analítico" : "Sintético";
$head4 = "Período: ";
$head5 = "";
$head6 = "";
if (!empty($dtini) && !empty($dtfim)) {
  $head4 .= "{$dtini} à {$dtfim}";
}
if (!empty($nomeFiltro) && !empty($ordenado)) {
  $head5 = "Filtro: ".$nomeFiltro;
  $head6 = "Ordenado por: ".$ordenado;
}
else if (!empty($nomeFiltro) && empty($ordenado)) {
  $head5 = "Filtro: ".$nomeFiltro;
}
else if (empty($nomeFiltro) && !empty($ordenado)) {
  $head5 = "Ordenado por: ".$ordenado;
}
$mPDF = new Relatorio('', 'A4');
$mPDF->addInfo($head1, 1);
$mPDF->addInfo($head2, 2);
$mPDF->addInfo($head3, 3);
$mPDF->addInfo($head4, 4);
$mPDF->addInfo($head5, 5);
$mPDF->addInfo($head6, 6);
$contador = 0;
ob_start();
?>
<?php if (strcmp($tpimpressao, 'a') === 0) : ?>
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
      #empenho {width: 45px;}
      #ordslip {width: 70px;}
      #credor {width: 200px;}
      #dataops {width: 72px;}
      #recurso {width: 40px;}
      #valor {width: 55px;}
      #dtautorizacao {width: 95px;}
      #protocolo {width: 55px;}
      #situacao {width: 65px;}
    </style>
  </head>
  <body>
    <div class="pagina">
    <?php if (!empty($campoQuebra)) : ?>
      <?php foreach ($aOpSlips as $aOpSlip) : ?>
        <table>
          <tr>
            <th class="left"><?php echo $textoQuebra ?></th>
          </tr>
          <tr>
            <th class="left">
              <?php
                if ($campoQuebra == "situacao") {
                  echo $aOpSlip->situacao;
                }
                else if ($campoQuebra == "z01_numcgm") {
                  echo $aOpSlip->z01_numcgm." - ".$aOpSlip->z01_nome;
                } else {
                    echo $aOpSlip->codrecurso." - ".$aOpSlip->nomerecurso;
                }
              ?>
            </th>
          </tr>
        </table>
        <table class="table">
          <thead>
            <tr>
              <th id="empenho">Empenho</th>
              <th id="ordslip">Nº Ord./Slip</th>
              <th id="credor">Credor</th>
              <th id="dataops">Data OP/Slip</th>
              <th id="recurso">Recurso</th>
              <th id="valor">Valor</th>
              <th id="dtautorizacao">Data Autorização</th>
              <th id="protocolo">Protocolo</th>
              <th id="situacao">Situação</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($aOpSlip->ordempslips as $ordempslip) : ?>
              <?php $totalquebra += $ordempslip->valor; ?>
              <tr>
                <td><?= $ordempslip->empenho ?></td>
                <td><?= $ordempslip->ordslip ?></td>
                <td><?= $ordempslip->z01_numcgm." - ".$ordempslip->z01_nome ?></td>
                <td><?= $ordempslip->dataopslip ?></td>
                <td><?= $ordempslip->codrecurso ?></td>
                <td><?= number_format($ordempslip->valor, 2, ',', '.') ?></td>
                <td><?= $ordempslip->dtautorizacao ?></td>
                <td><?= $ordempslip->protocolo ?></td>
                <td><?= $ordempslip->situacao ?></td>
              </tr>
            <?php ++$contador; endforeach; ?>
          </tbody>
        </table>
        <div style="margin-left: 415px;">
          <strong>Total:</strong>
          <span>R$<?= number_format($totalquebra, 2, ',', '.'); $totalquebra = 0; ?></span>
        </div>
        <br>
      <?php endforeach; ?>
    <?php else : ?>
      <table class="table">
          <thead>
            <tr>
              <th id="empenho">Empenho</th>
              <th id="ordslip">Nº Ord./Slip</th>
              <th id="credor">Credor</th>
              <th id="dataops">Data OP/Slip</th>
              <th id="recurso">Recurso</th>
              <th id="valor">Valor</th>
              <th id="dtautorizacao">Data Autorização</th>
              <th id="protocolo">Protocolo</th>
              <th id="situacao">Situação</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($aOpSlips as $aOpSlip) : ?>
              <?php $totalquebra += $aOpSlip->valor; ?>
            <tr class="_<?php echo ($contador % 2 == 0) ?>">
              <td><?= $aOpSlip->empenho ?></td>
              <td><?= $aOpSlip->ordslip ?></td>
              <td><?= $aOpSlip->z01_numcgm." - ".$aOpSlip->z01_nome ?></td>
              <td><?= $aOpSlip->dataopslip ?></td>
              <td><?= $aOpSlip->codrecurso ?></td>
              <td><?= number_format($aOpSlip->valor, 2, ',', '.') ?></td>
              <td><?= $aOpSlip->dtautorizacao ?></td>
              <td><?= $aOpSlip->protocolo ?></td>
              <td><?= $aOpSlip->situacao ?></td>
            </tr>
            <?php ++$contador; endforeach; ?>
          </tbody>
        </table>
    <?php endif; ?>
    <table>
      <tfoot>
        <tr>
          <td>
            <strong>Total de Registros:</strong>
          </td>
          <td><?= $contador ?></td>
          <td style="width: 250px;">&nbsp;</td>
          <td>
            <strong>Total Geral:</strong>
          </td>
          <td>R$<?= number_format($valortotal, 2, ',', '.'); ?></td>
        </tr>
      </tfoot>
    </table>
    </div>
  </body>
</html>
<!-- Relatório Sintérico -->
<?php else : ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Relatório</title>
    <link rel="stylesheet" type="text/css" href="estilos/relatorios/padrao.style.css">
    <style type="text/css">
      body {
        font-family: Arial;
      }
      .table {border: 1px solid #bbb;background-color: #fff;font-size: 11px; width: 100%;}
      .table td {border: 1px solid #bbb;padding: 1px 3px;font-size: 10px;}
      .titulo {background-color: #ddd;text-align: center; font-weight: bold;}
      .pagina { clear: both;  height: 100%; margin-bottom: 0; padding: 0;}page-break-after: initial;*/
      #col1 {width: 70%;}
      #col2 {width: 30%;}
    </style>
  </head>
  <body>
    <div class="pagina">
      <table class="table">
        <tbody>
        <?php foreach ($aOpSlips as $aOpSlip) : ?>
          <tr>
            <td colspan="2" class="titulo">
              <?= $aOpSlip->codrecurso ?> - <?= $aOpSlip->nomerecurso ?>
            </td>
          </tr>
          <tr>
            <td id="col1"><strong>Credor</strong></td>
            <td id="col2"><strong>Valor</strong></td>
          </tr>
          <?php foreach ($aOpSlip->ordempslips as $ordempslip) : ?>
            <?php $totalquebra += $ordempslip->valor; ?>
          <tr>
            <td id="col1"><?= $ordempslip->z01_nome ?></td>
            <td id="col2">R$<?= number_format($ordempslip->valor, 2, ',', '.') ?></td>
          </tr>
          <?php endforeach; ?>
          <tr>
            <td>
              <strong>Total do Recurso <?= $aOpSlip->codrecurso ?></strong>
            </td>
            <td>
              <strong>R$<?= number_format($totalquebra, 2, ',', '.'); $totalquebra = 0; ?></strong>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2" class="titulo">Resumo Geral</td>
          </tr>
          <?php foreach ($aOpSlips as $aOpSlip) : ?>
            <?php
              foreach ($aOpSlip->ordempslips as $ordempslip) {
                $totalquebra += $ordempslip->valor;
              }
            ?>
          <tr>
            <td>
              <strong><?= $aOpSlip->codrecurso ?> - <?= $aOpSlip->nomerecurso ?></strong>
            </td>
            <td>
              <strong>R$<?= number_format($totalquebra, 2, ',', '.'); $totalquebra = 0; ?></strong>
            </td>
          </tr>
          <?php endforeach; ?>
          <tr>
            <td><strong>Total Geral</strong></td>
            <td><strong>R$<?= number_format($valortotal, 2, ',', '.'); ?></strong></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </body>
</html>
<?php endif ; ?>
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
