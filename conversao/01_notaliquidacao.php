<?php
if (!function_exists("pg_connect")) {

  dl("pgsql.so");
}
require(__DIR__ . "/../libs/db_utils.php");
$DB_USUARIO         = "postgres";
$DB_SENHA           = "";
$DB_SERVIDOR        = "192.168.0.2"; //ip do servidor.
$DB_BASE            = "auto_eldorado_20090106_v89"; //nome da base de dados
$DB_PORTA           = "5432";
$DB_SELLER          = "on";
$iAnoUsu            = 2008;
$CODIGO_DEPTO_ORDEM = 102;
echo "inicio da migracao: ".date("d/m/Y")." - ".date("h:i:s");
echo "Conectando...\n";
$fp         = fopen ("/tmp/migranotaliq.txt","w");

if(!($conn1 = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE       port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))){

  echo "erro ao conectar...\n";
  exit;
}

$sSQl       = "select e60_numemp        ";
$sSQl      .= "  from empempenho        ";
$sSQl      .= "       left join empempenhonl on e60_numemp = e68_numemp";
$sSQl      .= " where e60_anousu = {$iAnoUsu} "; 
$sSQl      .= "   and e60_vlrliq = 0";
$sSQl      .= "   and e60_vlranu = 0";
$sSQl      .= "   and e68_numemp is null";
$rsempenho  = pg_query($sSQl);
$iNumRows   = pg_num_rows($rsempenho);
pg_query("begin");
$iErro = 0;
for ($i = 0; $i < $iNumRows; $i++) {

  $oEmpenho = db_utils::fieldsmemory($rsempenho, $i);   
  $sInsert  = " insert into empempenhonl values (nextval('empempenhonl_e68_sequencial_seq'),{$oEmpenho->e60_numemp},current_date)";
  $rsInsert = pg_query($sInsert);
  if (!$rsInsert) {

    echo pg_last_error();
    $iErro++;
    break;
  }  
  $sInsertNota  = " insert into migra_empenhonl values ({$oEmpenho->e60_numemp},3)";
  pg_query($sInsertNota);

}  
if ($iErro > 0) {
  pg_query("rollback");
  echo "Erro ao migrar empenhos sem liqudacao.";
} else {

  pg_query("commit");
  echo "operacao 1 efetuada com sucesso.";
}
pg_query("begin");
$iErro = 0;
echo "\n----> Procurando empenho com uma ordem de compra e uma ordem de pagamento\n";
$sqlOrdens  = " select m52_numemp,";
$sqlOrdens .= "        m52_codordem,";
$sqlOrdens .= "        count(distinct m51_codordem), ";
$sqlOrdens .= "        m51_valortotal ";
$sqlOrdens .= "   from matordemitem ";
$sqlOrdens .= "        inner join matordem on m51_codordem = m52_codordem ";
$sqlOrdens .= "        inner join empempenho on m52_numemp = e60_numemp   ";
$sqlOrdens .= "        left join matordemanu on m51_codordem = m53_codordem ";
$sqlOrdens .= "        left join empempenhonl on e60_numemp = e68_numemp ";
$sqlOrdens .= "  where e60_anousu  = {$iAnoUsu} ";
$sqlOrdens .= "    and m53_codordem is null ";
$sqlOrdens .= "    and e68_numemp is null ";
$sqlOrdens .= "  group by m52_numemp, m51_valortotal, m52_codordem having count(distinct m51_codordem)  = 1";
$fpErro     = fopen ("/tmp/migranotaliqErro.txt","w");
$rsOrdem    = pg_query($sqlOrdens);
$iTotOrdens = pg_num_rows($rsOrdem);
for ($i = 0; $i < $iTotOrdens; $i++) {

  $oOCS    = db_utils::fieldsmemory($rsOrdem, $i);   
  $sSqlOP  = "select e50_codord, ";
  $sSqlOP .= "       e53_valor, ";
  $sSqlOP .= "       e50_anousu, ";
  $sSqlOP .= "       e50_data, ";
  $sSqlOP .= "       e53_codele ";
  $sSqlOP .= "  from pagordem ";
  $sSqlOP .= "       inner join pagordemele on e50_codord = e53_codord";
  $sSqlOP .= " where e50_numemp = {$oOCS->m52_numemp}";
  $sSqlOP .= "   and e53_vlranu = 0 ";       
  $sSqlOP .= "   and e53_valor  > 0 ";       
  $rsOP    = pg_query($sSqlOP);
  $iTotOP  = pg_num_rows($rsOP);
  if (!$rsOP) {
    fputs($fpErro,pg_last_error());
    exit;
  }
  if ($iTotOP == 1) {

    $oOP = db_utils::fieldsmemory($rsOP, 0); 
    if ($oOP->e53_valor == $oOCS->m51_valortotal) {

      $sSqlNota  = "select e69_codnota,";
      $sSqlNota .= "       e70_valor, ";
      $sSqlNota .= "       e69_anousu ";
      $sSqlNota .= "  from empnota ";
      $sSqlNota .= "       inner join empnotaele on e69_codnota = e70_codnota ";
      $sSqlNota .= "       left join empnotaitem on e72_codnota = e70_codnota ";
      $sSqlNota .= " where e69_numemp = {$oOCS->m52_numemp}";
      $sSqlNota .= "   and e72_codnota is null";
      $rsNotas   = pg_query($sSqlNota);
      if (!$rsNotas) {
        fputs($fpErro,pg_last_error());
        exit;
      }
      $iTotNotas = pg_num_rows($rsNotas);
      if ($iTotNotas == 1) {

        $oNota        = db_utils::fieldsmemory($rsNotas,0);
        fputs($fp,"[{$oOCS->m52_numemp}] -tem nota({$oNota->e69_codnota})\n");
        // Verificamos se a nota está ligada a ordem de pagamento. 
        // caso esteja, apenas incluimos os itens.
        // se no estiver vinculada, verificamos se o valor da nota e da ordem conferem, 
        // entao incluimos a ligacao da nota e a oP (pagordemnota), e seus itens (pegamos da ordem de compra);

        $sSqlNotaOrdem  = "select * ";
        $sSqlNotaOrdem .= "  from pagordemnota ";
        $sSqlNotaOrdem .= " where e71_codord  = {$oOP->e50_codord}";
        $sSqlNotaOrdem .= "   and e71_codnota = {$oNota->e69_codnota}";
        $sSqlNotaOrdem .= "   and e71_anulado is false";
        $rsNotaOrdem    = pg_query($sSqlNotaOrdem);
        if (!$rsNotaOrdem) {
          fputs($fpErro,pg_last_error());
          exit;
        }
        $iTotNotaOrdem  = pg_num_rows($rsNotaOrdem);
        if ($iTotNotaOrdem == 0 ){

          $sInsertNotaOrd = "insert into pagordemnota values ({$oOP->e50_codord},{$oNota->e69_codnota},false)";
          pg_query($sInsertNotaOrd);
          $sInsertNotaOrd = "insert into migra_pagordemnota values ({$oOP->e50_codord},{$oNota->e69_codnota})";
          pg_query($sInsertNotaOrd);

        }
        fputs($fp,"[{$oOCS->m52_numemp}]   - incluindo itens({$oNota->e69_codnota})\n");
        $sSqlItens  = "select * ";
        $sSqlItens .= "  from matordemitem ";
        $sSqlItens .= "       inner join empempitem on m52_numemp = e62_numemp";
        $sSqlItens .= "                            and e62_sequen = m52_sequen ";
        $sSqlItens .= " where m52_codordem = {$oOCS->m52_codordem}";
        $sSqlItens .= "   and m52_numemp   = {$oOCS->m52_numemp}";
        $rsItens    = pg_query($sSqlItens);
        if (!$rsItens) {
          fputs($fpErro,pg_last_error());
          exit;
        }
        $iTotItens  = pg_num_rows($rsItens);
        $iIncluidos = 0;
        for ($x = 0; $x < $iTotItens; $x++) {

          $oItens   = db_utils::fieldsmemory($rsItens, $x);
          if ($oOCS->m52_numemp == 39893) {
            echo $sSqlItens;
          }
          $sInsert  = "insert ";
          $sInsert .= "  into empnotaitem (e72_sequencial,e72_codnota,e72_empempitem, e72_qtd,e72_valor,e72_vlrliq)";
          $sInsert .= "  values (";
          $sInsert .= "          nextval('empnotaitem_e72_sequencial_seq'),";
          $sInsert .= "          {$oNota->e69_codnota},";
          $sInsert .= "          {$oItens->e62_sequencial},";
          $sInsert .= "          {$oItens->m52_quant},";
          $sInsert .= "          {$oItens->m52_valor},";
          $sInsert .= "          {$oItens->m52_valor}";
          $sInsert .= "         )";
          $rsInsert  = pg_query($sInsert);

          if (!$rsInsert) {

            $iErro++;
            fputs($fp,"[{$oOCS->m52_numemp}]   - Erro:({$sInsert})\n");
            fputs($fpErro,"[{$oOCS->m52_numemp}]   - Erro:({$sInsert})\n");

          } else {
            $sInsertLog  = "insert into migra_empnotaitem values (";
            $sInsertLog .= "                              (select e72_sequencial ";
            $sInsertLog .= "                                 from empnotaitem    ";
            $sInsertLog .= "                                where e72_empempitem={$oItens->e62_sequencial}";
            $sInsertLog .= "                                  and e72_codnota   = {$oNota->e69_codnota}),";
            $sInsertLog .= "                               {$oOCS->m52_numemp},";
            $sInsertLog .= "                               {$oNota->e69_codnota}";
            $sInsertLog .= "                              )";
            pg_query($sInsertLog);
            fputs($fp,"[{$oOCS->m52_numemp}]   - incluido itens para nota :({$oNota->e69_codnota}})\n");

          }
        }
        $sInsertNota  = " insert into empempenhonl values (nextval('empempenhonl_e68_sequencial_seq'),{$oOCS->m52_numemp},current_date)";
        pg_query($sInsertNota);
        $sInsertNota  = " insert into migra_empenhonl values ({$oOCS->m52_numemp},1)";
        pg_query($sInsertNota);

      } else {

        //aqui incluimos a nota pra o empenho.
        fputs($fp,"[{$oOCS->m52_numemp}] - incluindo Nota para ordem({$oOP->e50_codord})\n");
        $iCodNota     = pg_result(pg_query("select nextval('empnota_e69_codnota_seq')" ),0,0);
        $sInsertNota  = "insert into empnota values (";
        $sInsertNota .= "'{$iCodNota}',";
        $sInsertNota .= "'m{$oOP->e50_codord}',";
        $sInsertNota .= "'{$oOCS->m52_numemp}',";
        $sInsertNota .= "1,";
        $sInsertNota .= "'{$oOP->e50_data}',";
        $sInsertNota .= "'{$oOP->e50_data}',";
        $sInsertNota .= "'{$oOP->e50_anousu}')";
        $rsInsertNota = pg_query($sInsertNota);
        if (!$rsInsertNota) {

          $iErro++;
          fputs($fp,"[{$oOCS->m52_numemp}]   - Erro:({$sInsertNota})\n");
          fputs($fpErro,"[{$oOCS->m52_numemp}]   - Erro:({$sInsertNota})\n");

        } else {

          $sInsertNota  = "insert into empnotaele  (e70_codnota, e70_codele, e70_valor,e70_vlrliq, e70_vlranu) values (";
          $sInsertNota .= "{$iCodNota},";
          $sInsertNota .= "{$oOP->e53_codele},";
          $sInsertNota .= "{$oOP->e53_valor},";
          $sInsertNota .= "{$oOP->e53_valor},0)";
          $rsInsertEle  = pg_query($sInsertNota);

          $sInsertNotaOrd = "insert into pagordemnota values ({$oOP->e50_codord},{$iCodNota},false)";
          pg_query($sInsertNotaOrd);
          $sInsertNotaOrd = "insert into migra_pagordemnota values ({$oOP->e50_codord},{$iCodNota})";
          pg_query($sInsertNotaOrd);
          fputs($fp,"[{$oOCS->m52_numemp}]   - incluindo itens({$iCodNota})\n");
          $sSqlItens  = "select * ";
          $sSqlItens .= "  from matordemitem ";
          $sSqlItens .= "       inner join empempitem on m52_numemp = e62_numemp";
          $sSqlItens .= "                            and e62_sequen = m52_sequen ";
          $sSqlItens .= " where m52_codordem = {$oOCS->m52_codordem}";
          $sSqlItens .= "   and m52_numemp   = {$oOCS->m52_numemp}";
          $rsItens    = pg_query($sSqlItens);
          if (!$rsItens) {
            fputs($fpErro,pg_last_error());
            exit;
          }
          $iTotItens  = pg_num_rows($rsItens);
          $iIncluidos = 0;
          for ($x = 0; $x < $iTotItens; $x++) {

            $oItens   = db_utils::fieldsmemory($rsItens, $x);
            if ($oOCS->m52_numemp == 39893) {
              echo $sSqlItens;
            }
            $sInsert  = "insert ";
            $sInsert .= "  into empnotaitem (e72_sequencial,e72_codnota,e72_empempitem, e72_qtd,e72_valor,e72_vlrliq)";
            $sInsert .= "  values (";
            $sInsert .= "          nextval('empnotaitem_e72_sequencial_seq'),";
            $sInsert .= "          {$iCodNota},";
            $sInsert .= "          {$oItens->e62_sequencial},";
            $sInsert .= "          {$oItens->m52_quant},";
            $sInsert .= "          {$oItens->m52_valor},";
            $sInsert .= "          {$oItens->m52_valor}";
            $sInsert .= "         )";
            $rsInsert  = pg_query($sInsert);

            if (!$rsInsert) {

              $iErro++;
              fputs($fp,"[{$oOCS->m52_numemp}]   - Erro:({$sInsert})\n");
              fputs($fpErro,"[{$oOCS->m52_numemp}]   - Erro:({$sInsert})\n");

            } else {

              $sInsertLog  = "insert into migra_empnotaitem values (";
              $sInsertLog .= "                              (select e72_sequencial ";
              $sInsertLog .= "                                 from empnotaitem    ";
              $sInsertLog .= "                                where e72_empempitem={$oItens->e62_sequencial}";
              $sInsertLog .= "                                  and e72_codnota   = {$iCodNota}),";
              $sInsertLog .= "                               {$oOCS->m52_numemp},";
              $sInsertLog .= "                               {$iCodNota}";
              $sInsertLog .= "                              )";
              pg_query($sInsertLog);
              fputs($fp,"[{$oOCS->m52_numemp}]   - incluido itens para nota :({$iCodNota}})\n");

            }
          }
          $sInsertNota  = " insert into empempenhonl values (nextval('empempenhonl_e68_sequencial_seq'),{$oOCS->m52_numemp},current_date)";
          pg_query($sInsertNota);
          $sInsertNota  = " insert into migra_empenhonl values ({$oOCS->m52_numemp},2)";
          pg_query($sInsertNota);
        }
      }
    }
  }
}
if ($iErro > 0) {

  pg_query("rollback");
  echo "erros encontrados.\n";

} else {

  pg_query("commit");
  echo "-> Operacao realizada com sucesso\n";
}

echo " -> procurando empenhos com ordem de pagamento e sem ordem de compra\n";
pg_query("begin");
$iErro         = 0;
$sSqlEmpenhos  = "select e60_numemp,       ";
$sSqlEmpenhos .= "       e60_vlremp,       ";
$sSqlEmpenhos .= "       e60_numcgm       ";
$sSqlEmpenhos .= "  from empempenho        ";
$sSqlEmpenhos .= "       left join empempenhonl on e60_numemp = e68_numemp ";
$sSqlEmpenhos .= " where e60_anousu = {$iAnoUsu}  ";
$sSqlEmpenhos .= "   and e68_numemp is null "; 
$rsEmpenho     = pg_query($sSqlEmpenhos);
if ($rsEmpenho) {

  $iNumrowsEmpenho = pg_num_rows($rsEmpenho); 
  for ($iInd = 0; $iInd < $iNumrowsEmpenho; $iInd++) {

    echo "analisando empenho ".($iInd+1)." de {$iNumrowsEmpenho}.\r"; 
    $oEmpenho            = db_utils::fieldsMemory($rsEmpenho, $iInd);
    $sSqlOrdemPagamento  = "select e50_codord,";
    $sSqlOrdemPagamento .= "       e53_valor,";
    $sSqlOrdemPagamento .= "       e53_codele,";
    $sSqlOrdemPagamento .= "       e50_anousu,";
    $sSqlOrdemPagamento .= "       e50_data";
    $sSqlOrdemPagamento .= "  from pagordem";
    $sSqlOrdemPagamento .= "       inner join pagordemele on e53_codord = e50_codord";
    $sSqlOrdemPagamento .= " where e50_numemp  = {$oEmpenho->e60_numemp}"; 
    $rsOrdemPagamento    =  pg_query($sSqlOrdemPagamento);
    $iNumrowsOrdemPag    = pg_num_rows($rsOrdemPagamento);
    if ($iNumrowsOrdemPag == 1) {

      $oOrdemPag  = db_utils::fieldsMemory($rsOrdemPagamento, 0);
      if ($oEmpenho->e60_vlremp == $oOrdemPag->e53_valor) {

        fputs($fp,"[{$oEmpenho->e60_numemp}]   - tem Ordem ({$oOrdemPag->e50_codord})\n");
        //incluimos na tabelas pagordemnota, matordem, matordemitem, empnota, empnotaitem";
        //empnotaitem,  
        fputs($fp,"[{$oEmpenho->e50_numemp}] - incluindo Nota para ordem({$oOP->e50_codord})\n");
        $iCodNota     = pg_result(pg_query("select nextval('empnota_e69_codnota_seq')" ),0,0);
        $sInsertNota  = "insert into empnota values (";
        $sInsertNota .= "'{$iCodNota}',";
        $sInsertNota .= "'m{$oOrdemPag->e50_codord}',";
        $sInsertNota .= "'{$oEmpenho->e60_numemp}',";
        $sInsertNota .= "1,";
        $sInsertNota .= "'{$oOrdemPag->e50_data}',";
        $sInsertNota .= "'{$oOrdemPag->e50_data}',";
        $sInsertNota .= "'{$oOrdemPag->e50_anousu}')";
        $rsInsertNota = pg_query($sInsertNota);
        if (!$rsInsertNota) {

          $iErro++;
          fputs($fp,"[{$oOrdemPag->e50_numemp}]   - Erro:({$sInsertNota})\n");

          exit;
        } else {

          $sInsertNota  = "insert into empnotaele  (e70_codnota, e70_codele, e70_valor,e70_vlrliq, e70_vlranu) values (";
          $sInsertNota .= "{$iCodNota},";
          $sInsertNota .= "{$oOrdemPag->e53_codele},";
          $sInsertNota .= "{$oOrdemPag->e53_valor},";
          $sInsertNota .= "{$oOrdemPag->e53_valor},0)";
          $rsInsertEle  = pg_query($sInsertNota);

          $sInsertNotaOrd = "insert into pagordemnota values ({$oOrdemPag->e50_codord},{$iCodNota},false)";
          pg_query($sInsertNotaOrd);
          $sInsertNotaOrd = "insert into migra_pagordemnota values ({$oOrdemPag->e50_codord},{$iCodNota})";
          pg_query($sInsertNotaOrd);
          fputs($fp,"[{$oOrdemPag->e50_numemp}]   - incluindo ordem de compra\n");
          $iCodOrd          = pg_result(pg_query("select nextval('matordem_m51_codordem_seq')" ),0,0);
          $sInsertMatOrdem  = "insert into matordem values (";
          $sInsertMatOrdem .= "{$iCodOrd},";
          $sInsertMatOrdem .= "'{$oOrdemPag->e50_data}',";
          $sInsertMatOrdem .= "{$CODIGO_DEPTO_ORDEM}, ";
          $sInsertMatOrdem .= "{$oEmpenho->e60_numcgm},";
          $sInsertMatOrdem .= "'Ordem Migrada',";
          $sInsertMatOrdem .= "{$oEmpenho->e60_vlremp},";
          $sInsertMatOrdem .= "3,";
          $sInsertMatOrdem .= "2)";
          $rsMatordem      = pg_query($sInsertMatOrdem);
          if (!$rsMatordem) {

            $iErro++;
            fputs($fp,"[{$oOrdemPag->e50_numemp}]   - Erro:({$sInsertMatOrdem})\n");
            exit;

          } else {

             pg_query("insert into migra_matordem values ({$oEmpenho->e60_numemp} , {$iCodOrd})");
            $rsItensEmp   = pg_query("select * from empempitem where e62_numemp = {$oEmpenho->e60_numemp}");
            $iTotItensEmp = pg_num_rows($rsItensEmp);
            for ($iItens = 0; $iItens < $iTotItensEmp; $iItens++) {

              $oItensEmp     = db_utils::fieldsMemory($rsItensEmp,$iItens);
              $sInsertItens  = "insert into matordemitem values (";
              $sInsertItens .= "nextval('matordemitem_m52_codlanc_seq'),";
              $sInsertItens .= "{$iCodOrd},";
              $sInsertItens .= "{$oItensEmp->e62_numemp},";
              $sInsertItens .= "{$oItensEmp->e62_sequen},";
              $sInsertItens .= "{$oItensEmp->e62_quant},";
              $sInsertItens .= "{$oItensEmp->e62_vltot},";
              $sInsertItens .= "{$oItensEmp->e62_vlrun})";
              $rsInsertItens = pg_query($sInsertItens);
              if (!$rsInsertItens) {

                $iErro++;
                fputs($fp,"[{$oOrdemPag->e50_numemp}]   - Erro:({$sInsertItens})\n");
                exit;

              }
            }

            fputs($fp,"[{$oOrdemPag->e50_numemp}]   - incluindo itens({$iCodNota})\n");
            $sSqlItens  = "select * ";
            $sSqlItens .= "  from matordemitem ";
            $sSqlItens .= "       inner join empempitem on m52_numemp = e62_numemp";
            $sSqlItens .= "                            and e62_sequen = m52_sequen ";
            $sSqlItens .= " where m52_codordem = {$iCodOrd}";
            $sSqlItens .= "   and m52_numemp   = {$oEmpenho->e60_numemp}";
            $rsItens    = pg_query($sSqlItens);
            if (!$rsItens) {
              fputs($fpErro,pg_last_error());
              exit;
            }
            $iTotItens  = pg_num_rows($rsItens);
            $iIncluidos = 0;
            for ($x = 0; $x < $iTotItens; $x++) {

              $oItens   = db_utils::fieldsmemory($rsItens, $x);
              if ($oOCS->m52_numemp == 39893) {
                echo $sSqlItens;
              }
              $sInsert  = "insert ";
              $sInsert .= "  into empnotaitem (e72_sequencial,e72_codnota,e72_empempitem, e72_qtd,e72_valor,e72_vlrliq)";
              $sInsert .= "  values (";
              $sInsert .= "          nextval('empnotaitem_e72_sequencial_seq'),";
              $sInsert .= "          {$iCodNota},";
              $sInsert .= "          {$oItens->e62_sequencial},";
              $sInsert .= "          {$oItens->m52_quant},";
              $sInsert .= "          {$oItens->m52_valor},";
              $sInsert .= "          {$oItens->m52_valor}";
              $sInsert .= "         )";
              $rsInsert  = pg_query($sInsert);

              if (!$rsInsert) {

                $iErro++;
                fputs($fp,"[{$oEmpenho->e60_numemp}]   - Erro:({$sInsert})\n");
                fputs($fpErro,"[{$oEmpenho->e60_numemp}]   - Erro:({$sInsert})\n");
                exit;

              } else {

                $sInsertLog  = "insert into migra_empnotaitem values (";
                $sInsertLog .= "                              (select e72_sequencial ";
                $sInsertLog .= "                                 from empnotaitem    ";
                $sInsertLog .= "                                where e72_empempitem={$oItens->e62_sequencial}";
                $sInsertLog .= "                                  and e72_codnota   = {$iCodNota}),";
                $sInsertLog .= "                               {$oEmpenho->e60_numemp},";
                $sInsertLog .= "                               {$iCodNota}";
                $sInsertLog .= "                              )";
                pg_query($sInsertLog);
                fputs($fp,"[{$oOCS->m52_numemp}]   - incluido itens para nota :({$iCodNota}})\n");

              }
            }
            $sInsertNota  = " insert into empempenhonl values (nextval('empempenhonl_e68_sequencial_seq'),{$oEmpenho->e60_numemp},current_date)";
            pg_query($sInsertNota);
            $sInsertNota  = " insert into migra_empenhonl values ({$oEmpenho->e60_numemp},5)";
            pg_query($sInsertNota);
          }
        }
      }
    }
  }
}

if ($iErro > 0) {

  pg_query("rollback");
  echo "erros encontrados.\n";

} else {

  pg_query("commit");
  echo "-> Operacao realizada com sucesso\n";
}

fclose($fp);
echo "\nFim da migracao: ".date("d/m/Y")." - ".date("h:i:s");
?>
