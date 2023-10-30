<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
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

if (!isset($arqinclude)) {

  require_once("fpdf151/pdf.php");
  require_once("libs/db_sql.php");
  require_once("libs/db_utils.php");
  require_once("libs/db_libcontabilidade.php");
  require_once("libs/db_liborcamento.php");
  require_once("dbforms/db_funcoes.php");
  require_once("classes/db_db_config_classe.php");

  parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
  db_postmemory($HTTP_SERVER_VARS);
}

$xinstit    = db_getsession("DB_instit");
$resultinst = db_query("select codigo,nomeinst,munic,nomeinstabrev, uf from db_config where codigo = {$xinstit}");
$descr_inst = '';
$xvirg = '';
$flag_abrev = false;

function calculaReceita($natureza, $array)
{
  foreach ($array as $naturezaArray) {
    if (substr($natureza, 0, strlen($naturezaArray)) == $naturezaArray) {
      return true;
    }
  }
  return false;
}

for ($xins = 0; $xins < pg_numrows($resultinst); $xins++) {

  db_fieldsmemory($resultinst, $xins);

  if (strlen(trim($nomeinstabrev)) > 0) {

    $descr_inst .= $xvirg . $nomeinstabrev;
    $flag_abrev  = true;
  } else {
    $descr_inst .= $xvirg . $nomeinst;
  }

  $xvirg = ', ';
}

if (!isset($arqinclude)) {

  if ($tipo_relatorio == 'arrecadado') {
    $tipo = 1;
  } else {
    $tipo = 2;
  }
  $oDaoPeriodo         = db_utils::getDao("periodo");
  $anousu              = db_getsession("DB_anousu");
  $sSqlPeriodo         = $oDaoPeriodo->sql_query($periodo);
  $oPeriodo            = db_utils::fieldsMemory($oDaoPeriodo->sql_record($sSqlPeriodo), 0);
  $sSiglaPeriodo       = $oPeriodo->o114_sigla;
  $mesInicial          = $oPeriodo->o114_mesinicial;
  if ($tipo == 1) {
    $dt_ini            = date('Y-m-d', strtotime('- 11 month', strtotime($anousu . '-' . $mesInicial . '-01')));
  } else {
    $dt_ini            = date('Y-m-d', strtotime($anousu . '-' . $mesInicial . '-01'));
  }
  $dt_fin              = date('Y-m-t', strtotime($anousu . '-' . $mesInicial . '-01'));

  // uma matriz para facilitar a impresso dos nomes dos meses no relatorio
  $mes_dresc[1]  = 'Jan';
  $mes_dresc[2]  = 'Fev';
  $mes_dresc[3]  = 'Mar';
  $mes_dresc[4]  = 'Abr';
  $mes_dresc[5]  = 'Mai';
  $mes_dresc[6]  = 'Jun';
  $mes_dresc[7]  = 'Jul';
  $mes_dresc[8]  = 'Ago';
  $mes_dresc[9]  = 'Set';
  $mes_dresc[10] = 'Out';
  $mes_dresc[11] = 'Nov';
  $mes_dresc[12] = 'Dez';
}

if (!isset($arqinclude)) {
  $head2 = "MUNICIPIO DE {$munic} - {$uf}";
  $head3 = "RELATÓRIO RESUMIDO DA EXECUÇÃO ORÇAMENTARIA";
  $head4 = "DEMONSTRATIVO DA RECEITA CORRENTE LIQUIDA";
  $head5 = "ORÇAMENTOS FISCAL E DA SEGURIDADE SOCIAL ";

  if ($tipo == 1) {

    $aDtIni   = split('-', $dt_ini);
    $aDtFin   = split('-', $dt_fin);
    $dt1    = "$dtd1[2]/$dtd1[1]/$dtd1[0]";
    $dt2    = "$dtd2[2]/$dtd2[1]/$dtd2[0]";
    $head6  = strtoupper(db_mes($aDtIni[1])) . ' / ' . $aDtIni[0];
    $head6 .= " A ";
    $head6 .= strtoupper(db_mes($aDtFin[1])) . ' /' . $aDtFin[0];
  } else {
    $head6  = "EXERCÍCIO: ";
    $head6 .= $anousu;
  }
}

//Matriz com Especificações e valores
$receitas[1][0]  = " RECEITAS CORRENTES (I)";
$receitas[2][0]  = " Impostos, Taxas e Contribuições de Melhoria";
$receitas[3][0]  = "    IPTU";
$receitas[4][0]  = "    ISS";
$receitas[5][0]  = "    ITBI";
$receitas[6][0]  = "    IRRF";
$receitas[7][0]  = "    Outros Impostos, Taxas e Contribuições de Melhoria";
$receitas[8][0]  = " Contribuições";
$receitas[9][0]  = " Receita Patrimonial";
$receitas[10][0] = "    Rendimentos de Aplicação Financeira";
$receitas[11][0] = "    Outras Receitas Patrimoniais";
$receitas[12][0] = " Receita Agropecuária";
$receitas[13][0] = " Receita Industrial";
$receitas[14][0] = " Receita de Serviços";
$receitas[15][0] = " Transferências Correntes";
$receitas[16][0] = "    Cota-Parte do FPM";
$receitas[17][0] = "    Cota-Parte do ICMS";
$receitas[18][0] = "    Cota-Parte do IPVA";
$receitas[19][0] = "    Cota-Parte do ITR";
$receitas[20][0] = "    Transferências da LC 61/1989";
$receitas[21][0] = "    Transferências do FUNDEB";
$receitas[22][0] = "    Outras Transferências Correntes";
$receitas[23][0] = " Outras Receitas Correntes";
$receitas[24][0] = " DEDUÇOES (II)";
$receitas[25][0] = "  Contrib. do Servidor para o Plano de Previdência";
$receitas[26][0] = "  Compensação Financ. entre Regimes Previdência";
$receitas[27][0] = "  Rendimentos de Aplicações de Rec. Previdenciários";
$receitas[28][0] = "  Dedução de Receita para Formação do FUNDEB";
$receitas[29][0] = " RECEITA CORRENTE LÍQUIDA (RCL)";
$receitas[30][0] = "  ( - ) Transf. obrigatórias da União relativas às emendas";
$receitas[31][0] = " RCL DOS LIMITES DE ENDIVIDAMENTO";
$receitas[32][0] = "  ( - ) Transf. obrigatórias da União relativas às emendas";
$receitas[33][0] = " RCL DOS LIMITES DA DESPESA COM PESSOAL";

//NATUREZAS
$iptu = array('4111250', '491111250', '492111250', '493111250', '496111250', '498111250', '499111250');
$iss = array('41114511', '41114512', '4911114511', '4921114511', '4931114511', '4961114511', '4981114511', '4991114511', '4911114512', '4921114512', '4931114512', '4961114512', '4981114512', '4991114512');
$itbi = array('4111253', '491111253', '492111253', '493111253', '496111253', '498111253', '499111253');
$irrf = array('4111303', '491111303', '492111303', '493111303', '496111303', '498111303', '499111303');
$outrosImpostos = array('411', '49111', '49211', '49311', '49611', '49811', '49911');
$contibuicoes = array('412', '49112', '49212', '49312', '49612', '49812', '49912');
$rendimentos = array('4132101', '491132101', '492132101', '493132101', '496132101', '498132101', '499132101', '4132102', '491132102', '492132102', '493132102', '496132102', '498132102', '499132102', '4132103', '491132103', '492132103', '493132103', '496132103', '498132103', '499132103', '4132104', '491132104', '492132104', '493132104', '496132104', '498132104', '499132104', '4132105', '491132105', '492132105', '493132105', '496132105', '498132105', '499132105', '4132999', '491132999', '492132999', '493132999', '496132999', '498132999', '499132999');
$outrasReceitasPatrimonias = array('413', '49113', '49213', '49313', '49613', '49813', '49913');
$agropecuaria = array('414', '49114', '49214', '49314', '49614', '49814', '49914');
$industrial = array('415', '49115', '49215', '49315', '49615', '49815', '49915');
$servicos = array('416', '49116', '49216', '49316', '49616', '49816', '49916');
$fpm = array('41711511', '4911711511', '4921711511', '4931711511', '4961711511', '4981711511', '4991711511', '41711512', '4911711512', '4921711512', '4931711512', '4961711512', '4981711512', '4991711512');
$icms = array('4172150', '491172150', '492172150', '493172150', '496172150', '498172150', '499172150');
$ipva = array('4172151', '491172151', '492172151', '493172151', '496172151', '498172151', '499172151');
$itr = array('4171152', '491171152', '492171152', '493171152', '496171152', '498171152', '499171152');
$lc = array('4172152', '491172152', '492172152', '493172152', '496172152', '498172152', '499172152');
$fundeb = array('417515', '49117515', '49217515', '49317515', '49617515', '49817515', '49917515', '41715', '4911715', '4921715', '4931715', '4961715', '4981715', '4991715');
$outrasTransferencias = array('417', '49117', '49217', '49317', '49617', '49817', '49917');
$outrasReceitasCorrentes = array('419', '49119', '49219', '49319', '49619', '49819', '49919');
$contribPlanoPrev = array('4121501', '491121501', '492121501', '493121501', '496121501', '498121501', '499121501', '4121502', '491121502', '492121502', '493121502', '496121502', '498121502', '499121502', '4121503', '491121503', '492121503', '493121503', '496121503', '498121503', '499121503', '4121550', '491121550', '492121550', '493121550', '496121550', '498121550', '499121550', '4121551', '491121551', '492121551', '493121551', '496121551', '498121551', '499121551');
$conpensacaoRegimePrev = array('4199903', '491199903', '492199903', '493199903', '496199903', '498199903', '499199903');
$rendimentosRecursosPrev = array('4132104', '491132104', '492132104', '493132104', '496132104', '498132104', '499132104');
$deducaoFundeb = array('495');

if (!isset($arqinclude)) {

  //-------------------------------------------------------------------------------------------------
  $pdf = new PDF();
  $pdf->Open();
  $pdf->AliasNbPages();
  $pdf->setfillcolor(235);
  $pdf->setfont('arial', '', 6);
  $alt            = 4;
  $cl = 16.5;
  $clEspec = 54;
  $bold = array(1, 2, 8, 9, 12, 13, 14, 15, 23, 24, 29, 31, 33);
  $preencCelula = array(24, 29, 31, 33);
  $fonteNumeroGrande = 14;

  if ($tipo_relatorio == 'arrecadado') {
    $pdf->addpage("L");
    $pdf->cell($clEspec, $alt, "RREO - Anexo III (LRF, Art. 53, inciso I)", "b", 0, "L", 0);
    $pdf->cell(($cl * 14), $alt, "Em Reais", "b", 1, "R", 0);
    $pdf->cell($clEspec, $alt, "ESPECIFICAÇÃO", 'RTL', 0, "C", 0);
    $pdf->cell(($cl * 12), $alt, "EVOLUÇÃO DA RECEITA REALIZADA NOS ULTIMOS 12 MESES", 'RTB', 0, "C", 0);
    $pdf->setfont('arial', '', 6);
    $pdf->cell($cl, $alt, "TOTAL", 'RT', 0, "C", 0);
    $pdf->cell($cl, $alt, "PREVISÃO", 'TR', 0, "C", 0);
    $pdf->ln();
    $pdf->setfont('arial', '', 6);
    $pdf->cell($clEspec, $alt, "", 'BRL', 0, "C", 0);

    $mesInicial = $oPeriodo->o114_mesinicial;
    $dt_ini = $anousu . '-' . $mesInicial . '-01';
    $dt_ini = date('Y-m-d', strtotime('- 12 month', strtotime($dt_ini)));

    for ($i = 1; $i <= 12; $i++) {
      $sData = strtotime('+' . $i . ' month', strtotime($dt_ini));
      $dataInicial = date('Y-m-d', $sData);
      $dataFinal = date('Y-m-t', $sData);
      $mes = date('n', $sData);
      $pdf->cell($cl, $alt, $mes_dresc[$mes] . '/' . date('Y', $sData), 'TBR', 0, "C", 0);
      $ano = date('Y', $sData);
      $result = db_receitasaldo(11, 2, 3, true, '', $ano, $dataInicial, $dataFinal, false, ' * ', true, 0);
      $transfIndividuais = getSaldoArrecadadoEmendaParlamentarRelatorioReceita($dataInicial, $dataFinal, array(1), true);
      $transfBancada = getSaldoArrecadadoEmendaParlamentarRelatorioReceita($dataInicial, $dataFinal, array(2), true, array(16040000));

      for ($linha = 0; $linha < pg_num_rows($result); $linha++) {
        $row = pg_fetch_object($result, $linha);
        //iptu
        if (calculaReceita($row->o57_fonte, $iptu)) {
          $receitas[3][$i] += $row->saldo_arrecadado;
          if ($mes == 1) {
            $receitas[3][14] += $row->saldo_inicial;
          }
          if ($i == 12) {
            $receitas[3][14] += $row->saldo_prevadic_acum;
          }
        }
        //iss
        if (calculaReceita($row->o57_fonte, $iss)) {
          $receitas[4][$i] += $row->saldo_arrecadado;
          if ($mes == 1) {
            $receitas[4][14]  += $row->saldo_inicial;
          }
          if ($i == 12) {
            $receitas[4][14] += $row->saldo_prevadic_acum;
          }
        }
        //itbi
        if (calculaReceita($row->o57_fonte, $itbi)) {
          $receitas[5][$i] += $row->saldo_arrecadado;
          if ($mes == 1) {
            $receitas[5][14]  += $row->saldo_inicial;
          }
          if ($i == 12) {
            $receitas[5][14] += $row->saldo_prevadic_acum;
          }
        }
        //irrf
        if (calculaReceita($row->o57_fonte, $irrf)) {
          $receitas[6][$i] += $row->saldo_arrecadado;
          if ($mes == 1) {
            $receitas[6][14]  += $row->saldo_inicial;
          }
          if ($i == 12) {
            $receitas[6][14] += $row->saldo_prevadic_acum;
          }
        }
        //outros Impostos
        if (calculaReceita($row->o57_fonte, $outrosImpostos)) {
          $receitas[7][$i] += $row->saldo_arrecadado;
          if ($mes == 1) {
            $receitas[7][14]  += $row->saldo_inicial;
          }
          if ($i == 12) {
            $receitas[7][14] += $row->saldo_prevadic_acum;
          }
        }
        //contribuicos
        if (calculaReceita($row->o57_fonte, $contibuicoes)) {
          $receitas[8][$i] += $row->saldo_arrecadado;
          if ($mes == 1) {
            $receitas[8][14]  += $row->saldo_inicial;
          }
          if ($i == 12) {
            $receitas[8][14] += $row->saldo_prevadic_acum;
          }
        }
        //rendimentos
        if (calculaReceita($row->o57_fonte, $rendimentos)) {
          $receitas[10][$i] += $row->saldo_arrecadado;
          if ($mes == 1) {
            $receitas[10][14] += $row->saldo_inicial;
          }
          if ($i == 12) {
            $receitas[10][14] += $row->saldo_prevadic_acum;
          }
        }
        //outras receitas patrimoniais
        if (calculaReceita($row->o57_fonte, $outrasReceitasPatrimonias)) {
          $receitas[11][$i] += $row->saldo_arrecadado;
          if ($mes == 1) {
            $receitas[11][14] += $row->saldo_inicial;
          }
          if ($i == 12) {
            $receitas[11][14] += $row->saldo_prevadic_acum;
          }
        }
        //Receita Agropecuária
        if (calculaReceita($row->o57_fonte, $agropecuaria)) {
          $receitas[12][$i] += $row->saldo_arrecadado;
          if ($mes == 1) {
            $receitas[12][14] += $row->saldo_inicial;
          }
          if ($i == 12) {
            $receitas[12][14] += $row->saldo_prevadic_acum;
          }
        }
        //Receita Industrial
        if (calculaReceita($row->o57_fonte, $industrial)) {
          $receitas[13][$i] += $row->saldo_arrecadado;
          if ($mes == 1) {
            $receitas[13][14] += $row->saldo_inicial;
          }
          if ($i == 12) {
            $receitas[13][14] += $row->saldo_prevadic_acum;
          }
        }
        //Receita de Serviços
        if (calculaReceita($row->o57_fonte, $servicos)) {
          $receitas[14][$i] += $row->saldo_arrecadado;
          if ($mes == 1) {
            $receitas[14][14] += $row->saldo_inicial;
          }
          if ($i == 12) {
            $receitas[14][14] += $row->saldo_prevadic_acum;
          }
        }
        //Cota-Parte do FPM
        if (calculaReceita($row->o57_fonte, $fpm)) {
          $receitas[16][$i] += $row->saldo_arrecadado;
          if ($mes == 1) {
            $receitas[16][14] += $row->saldo_inicial;
          }
          if ($i == 12) {
            $receitas[16][14] += $row->saldo_prevadic_acum;
          }
        }
        //Cota-Parte do ICMS
        if (calculaReceita($row->o57_fonte, $icms)) {
          $receitas[17][$i] += $row->saldo_arrecadado;
          if ($mes == 1) {
            $receitas[17][14] += $row->saldo_inicial;
          }
          if ($i == 12) {
            $receitas[17][14] += $row->saldo_prevadic_acum;
          }
        }
        //Cota-Parte do IPVA
        if (calculaReceita($row->o57_fonte, $ipva)) {
          $receitas[18][$i] += $row->saldo_arrecadado;
          if ($mes == 1) {
            $receitas[18][14] += $row->saldo_inicial;
          }
          if ($i == 12) {
            $receitas[18][14] += $row->saldo_prevadic_acum;
          }
        }
        //Cota-Parte do ITR
        if (calculaReceita($row->o57_fonte, $itr)) {
          $receitas[19][$i] += $row->saldo_arrecadado;
          if ($mes == 1) {
            $receitas[19][14] += $row->saldo_inicial;
          }
          if ($i == 12) {
            $receitas[19][14] += $row->saldo_prevadic_acum;
          }
        }
        //Transferências da LC 61/1989
        if (calculaReceita($row->o57_fonte, $lc)) {
          $receitas[20][$i] += $row->saldo_arrecadado;
          if ($mes == 1) {
            $receitas[20][14] += $row->saldo_inicial;
          }
          if ($i == 12) {
            $receitas[20][14] += $row->saldo_prevadic_acum;
          }
        }
        //Transferências do FUNDEB
        if (calculaReceita($row->o57_fonte, $fundeb)) {
          $receitas[21][$i] += $row->saldo_arrecadado;
          if ($mes == 1) {
            $receitas[21][14] += $row->saldo_inicial;
          }
          if ($i == 12) {
            $receitas[21][14] += $row->saldo_prevadic_acum;
          }
        }
        //Outras Transferências Correntes
        if (calculaReceita($row->o57_fonte, $outrasTransferencias)) {
          $receitas[22][$i] += $row->saldo_arrecadado;
          if ($mes == 1) {
            $receitas[22][14] += $row->saldo_inicial;
          }
          if ($i == 12) {
            $receitas[22][14] += $row->saldo_prevadic_acum;
          }
        }
        //Outras Receitas Correntes
        if (calculaReceita($row->o57_fonte, $outrasReceitasCorrentes)) {
          $receitas[23][$i] += $row->saldo_arrecadado;
          if ($mes == 1) {
            $receitas[23][14] += $row->saldo_inicial;
          }
          if ($i == 12) {
            $receitas[23][14] += $row->saldo_prevadic_acum;
          }
        }
        //Contrib. do Servidor para o Plano de Previdência
        if (calculaReceita($row->o57_fonte, $contribPlanoPrev)) {
          $receitas[25][$i] += $row->saldo_arrecadado;
          if ($mes == 1) {
            $receitas[25][14] += $row->saldo_inicial;
          }
          if ($i == 12) {
            $receitas[25][14] += $row->saldo_prevadic_acum;
          }
        }
        //Compensação Financ. entre Regimes Previdência
        if (calculaReceita($row->o57_fonte, $conpensacaoRegimePrev)) {
          $receitas[26][$i] += $row->saldo_arrecadado;
          if ($mes == 1) {
            $receitas[26][14] += $row->saldo_inicial;
          }
          if ($i == 12) {
            $receitas[26][14] += $row->saldo_prevadic_acum;
          }
        }
        //Rendimentos de Aplicações de Recursos Previdenciários
        if (calculaReceita($row->o57_fonte, $rendimentosRecursosPrev)) {
          $receitas[27][$i] += $row->saldo_arrecadado;
          if ($mes == 1) {
            $receitas[27][14] += $row->saldo_inicial;
          }
          if ($i == 12) {
            $receitas[27][14] += $row->saldo_prevadic_acum;
          }
        }
        //Dedução de Receita para Formação do FUNDEB
        if (calculaReceita($row->o57_fonte, $deducaoFundeb)) {
          $receitas[28][$i] += ($row->saldo_arrecadado * -1);
          if ($mes == 1) {
            $receitas[28][14] += ($row->saldo_inicial * -1);
          }
          if ($i == 12) {
            $receitas[28][14] += ($row->saldo_prevadic_acum * -1);
          }
        }
        // Transf. obrigatórias da União relativas às emendas individuais
        if (calculaReceita($row->o57_fonte, $transfIndividuais)) {
          if ($mes == 1) {
            $receitas[30][14] += $row->saldo_inicial;
          }
          if ($i == 12) {
            $receitas[30][14] += $row->saldo_prevadic_acum;
          }
        }
        // Transf. obrigatórias da União relativas às emendas de bancada
        if (calculaReceita($row->o57_fonte, array('4171')) && $row->o70_codigo == 16040000) {
          $receitas[32][$i] += $row->saldo_arrecadado;
          if ($mes == 1) {
            $receitas[32][14] += $row->saldo_inicial;
          }
          if ($i == 12) {
            $receitas[32][14] += $row->saldo_prevadic_acum;
          }
        }
        if (calculaReceita($row->o57_fonte, $transfBancada)) {
          if ($i == 12) {
            $receitas[32][14] += $row->saldo_prevadic_acum;
          }
        }
      }
      // Transf. obrigatórias da União relativas às emendas individuais
      $aSaldoArrecadadoEmendaIndividuais = getSaldoArrecadadoEmendaParlamentarRelatorioReceita($dataInicial, $dataFinal, array(1));
      $receitas[30][$i] = $aSaldoArrecadadoEmendaIndividuais[0];

      // Transf. obrigatórias da União relativas às emendas de bancada
      $aSaldoArrecadadoEmendaBancada = getSaldoArrecadadoEmendaParlamentarRelatorioReceita($dataInicial, $dataFinal, array(2), false, array(16040000));
      $receitas[32][$i] += $aSaldoArrecadadoEmendaBancada[0];

      //TOTALIZADORES
      //Outros Impostos, Taxas e Contribuições de Melhoria
      $receitas[7][$i]  -= $receitas[3][$i] + $receitas[4][$i] + $receitas[5][$i] + $receitas[6][$i];
      //Impostos, taxas e Contribuições de Melhoria
      $receitas[2][$i]   = $receitas[3][$i] + $receitas[4][$i] + $receitas[5][$i] + $receitas[6][$i] + $receitas[7][$i];
      //Outras Receitas Patrimoniais
      $receitas[11][$i] -= $receitas[10][$i];
      //Receita Patrimonial
      $receitas[9][$i]   = $receitas[11][$i] + $receitas[10][$i];
      //Outras Transferências Correntes
      $receitas[22][$i] -= ($receitas[16][$i] + $receitas[17][$i] + $receitas[18][$i] + $receitas[19][$i] + $receitas[20][$i] + $receitas[21][$i]);
      //Transferências Correntes
      $receitas[15][$i]  = $receitas[22][$i] + $receitas[16][$i] + $receitas[17][$i] + $receitas[18][$i] + $receitas[19][$i] + $receitas[20][$i] + $receitas[21][$i];
      //RECEITAS CORRENTES (I)
      $receitas[1][$i]   = $receitas[2][$i] + $receitas[8][$i] +  $receitas[9][$i] + $receitas[12][$i] + $receitas[13][$i] + $receitas[14][$i] + $receitas[15][$i] + $receitas[23][$i];
      //DEDUÇOES (II)
      $receitas[24][$i]  = $receitas[25][$i] + $receitas[26][$i] + $receitas[27][$i] + $receitas[28][$i];
      //RECEITA CORRENTE LÍQUIDA
      $receitas[29][$i]  = $receitas[1][$i] - $receitas[24][$i];
      //RCL DOS LIMITES DE ENDIVIDAMENTO
      $receitas[31][$i]  = $receitas[29][$i] - $receitas[30][$i];
      //RCL DOS LIMITES DA DESPESA COM PESSOAL
      $receitas[33][$i]  = $receitas[31][$i] - $receitas[32][$i];

      db_inicio_transacao();
      db_query("drop table if exists work_receita");
      db_fim_transacao(false);
    }
    //PREVISAO ATUALIZADA TOTALIZADORES 
    //Outros Impostos, Taxas e Contribuições de Melhoria
    $receitas[7][14] -= ($receitas[3][14] + $receitas[4][14] + $receitas[5][14] + $receitas[6][14]);
    //Impostos, taxas e Contribuições de Melhoria
    $receitas[2][14] = $receitas[3][14] + $receitas[4][14] + $receitas[5][14] + $receitas[6][14] + $receitas[7][14];
    //Outras Receitas Patrimoniais
    $receitas[11][14] -= $receitas[10][14];
    //Receita Patrimonial
    $receitas[9][14] = $receitas[11][14] + $receitas[10][14];
    //Outras Transferências Correntes
    $receitas[22][14] -= ($receitas[16][14] + $receitas[17][14] + $receitas[18][14] + $receitas[19][14] + $receitas[20][14] + $receitas[21][14]);
    //Transferências Correntes
    $receitas[15][14] = $receitas[22][14] + $receitas[16][14] + $receitas[17][14] + $receitas[18][14] + $receitas[19][14] + $receitas[20][14] + $receitas[21][14];
    //RECEITAS CORRENTES (I)
    $receitas[1][14] = $receitas[2][14] + $receitas[8][14] +  $receitas[9][14] + $receitas[12][14] + $receitas[13][14] + $receitas[14][14] + $receitas[15][14] + $receitas[23][14];
    //DEDUÇOES (II)
    $receitas[24][14] = $receitas[25][14] + $receitas[26][14] + $receitas[27][14] + $receitas[28][14];
    //RECEITA CORRENTE LÍQUIDA
    $receitas[29][14] = $receitas[1][14] - $receitas[24][14];
    //RCL DOS LIMITES DE ENDIVIDAMENTO
    $receitas[31][14] = $receitas[29][14] - $receitas[30][14];
    //RCL DOS LIMITES DA DESPESA COM PESSOAL
    $receitas[33][14] = $receitas[31][14] - $receitas[32][14];

    $pdf->cell($cl, $alt, "", 'BR', 0, "C", 0);
    $pdf->cell($cl, $alt, "ATUALIZADA", 'BR', 0, "C", 0);
    $pdf->setfont('arial', '', 6);
    $pdf->ln();

    for ($j = 1; $j <= 33; $j++) {
      if (in_array($j, $bold)) {
        $fonte = 'B';
      } else {
        $fonte = '';
      }

      if (in_array($j, $preencCelula)) {
        $pdf->SetFillColor(211, 211, 211);
      } else {
        $pdf->SetFillColor(255, 255, 255);
      }
      $pdf->setfont('arial', $fonte, 6);
      $pdf->cell($clEspec, $alt, $receitas[$j][0], $j == 33 ? 'RBL' : 'RL', 0, "L", 1);
      $totalMes = 0;
      for ($i = 1; $i <= 14; $i++) {
        $pdf->setfont('arial', $fonte, 6);
        $valor = trim(db_formatar($receitas[$j][$i], 'f'));
        if ($i < 13) {
          if (strlen($valor) > $fonteNumeroGrande) {
            $pdf->setfont('arial', $fonte, 5);
          }

          $pdf->cell($cl, $alt, $valor, $j == 33 ? 'RB' : 'R', 0, "R", 1);
          $totalMes += $receitas[$j][$i];
        } else if ($i == 13) {
          $totalMes = trim(db_formatar($totalMes, 'f'));
          if (strlen($totalMes) > $fonteNumeroGrande) {
            $pdf->setfont('arial', $fonte, 5);
          }

          $pdf->cell($cl, $alt, $totalMes, $j == 33 ? 'RB' : 'R', 0, "R", 1);
        } else {
          if (strlen($valor) > $fonteNumeroGrande) {
            $pdf->setfont('arial', $fonte, 5);
          }

          $pdf->cell($cl, $alt, $valor, $j == 33 ? 'RB' : 'R', 0, "R", 1);
        }
      }
      $pdf->ln();
      if ($j == 30) {
        $pdf->cell($clEspec, 3, "  individuais", 'RL', 0, "L", 1);
        for ($k = 1; $k <= 14; $k++) {
          $pdf->cell($cl, 3, "", 'R', 0, "R", 1);
        }
        $pdf->ln();
      }
      if ($j == 32) {
        $pdf->cell($clEspec, 3, "  de bancada e ao vencimento dos agentes comunitários", 'RL', 0, "L", 1);
        for ($k = 1; $k <= 14; $k++) {
          $pdf->cell($cl, 3, "", 'R', 0, "R", 1);
        }
        $pdf->ln();
        $pdf->cell($clEspec, 3, " de saúde e de combate às endemias", 'RL', 0, "L", 1);
        for ($k = 1; $k <= 14; $k++) {
          $pdf->cell($cl, 3, "", 'R', 0, "R", 1);
        }
        $pdf->ln();
      }
    }
    $pdf->ln();
  } else if ($tipo_relatorio == 'orcado') {
    $pdf->addpage("P");
    $cl = 18;
    $clEspec = 120;
    $espaçamento = 35;
    $pdf->setX($espaçamento);
    $pdf->cell($clEspec, $alt, "RREO - Anexo III (LRF, Art. 53, inciso I)", "b", 0, "L", 0);
    $pdf->cell($cl, $alt, "Em Reais", "b", 1, "R", 0);
    $pdf->setX($espaçamento);
    $pdf->cell($clEspec, $alt, "ESPECIFICAÇÃO", 'RTL', 0, "C", 0);
    $pdf->cell($cl, $alt, "ORÇADO", 'TR', 0, "C", 0);
    $pdf->ln();
    $pdf->setX($espaçamento);
    $pdf->setfont('arial', '', 6);
    $pdf->cell($clEspec, $alt, "", 'BRL', 0, "C", 0);
    $pdf->cell($cl, $alt, "", 'BRL', 0, "C", 0);
    $pdf->ln();
    $pdf->setX($espaçamento);

    $sData = strtotime($dt_ini);
    $dataInicial = date('Y-m-d', $sData);
    $dataFinal = date('Y-m-t', $sData);
    $ano = date('Y', $sData);
    $result = db_receitasaldo(11, 2, 3, true, '', $ano, $dataInicial, $dataFinal, false, ' * ', true, 0);
    $transfIndividuais = getSaldoArrecadadoEmendaParlamentarRelatorioReceita($dataInicial, $dataFinal, array(1), true);
    $transfBancada = getSaldoArrecadadoEmendaParlamentarRelatorioReceita($dataInicial, $dataFinal, array(2), true, array(16040000));

    for ($linha = 0; $linha < pg_num_rows($result); $linha++) {
      $row = pg_fetch_object($result, $linha);
      //iptu
      if (calculaReceita($row->o57_fonte, $iptu)) {
        $receitas[3][1] += $row->saldo_inicial;
      }
      //iss
      if (calculaReceita($row->o57_fonte, $iss)) {
        $receitas[4][1] += $row->saldo_inicial;
      }
      //itbi
      if (calculaReceita($row->o57_fonte, $itbi)) {
        $receitas[5][1] += $row->saldo_inicial;
      }
      //irrf
      if (calculaReceita($row->o57_fonte, $irrf)) {
        $receitas[6][1] += $row->saldo_inicial;
      }
      //outros Impostos
      if (calculaReceita($row->o57_fonte, $outrosImpostos)) {
        $receitas[7][1] += $row->saldo_inicial;
      }
      //contribuicos
      if (calculaReceita($row->o57_fonte, $contibuicoes)) {
        $receitas[8][1] += $row->saldo_inicial;
      }
      //rendimentos
      if (calculaReceita($row->o57_fonte, $rendimentos)) {
        $receitas[10][1] += $row->saldo_inicial;
      }
      //outras receitas patrimoniais
      if (calculaReceita($row->o57_fonte, $outrasReceitasPatrimonias)) {
        $receitas[11][1] += $row->saldo_inicial;
      }
      //Receita Agropecuária
      if (calculaReceita($row->o57_fonte, $agropecuaria)) {
        $receitas[12][1] += $row->saldo_inicial;
      }
      //Receita Industrial
      if (calculaReceita($row->o57_fonte, $industrial)) {
        $receitas[13][1] += $row->saldo_inicial;
      }
      //Receita de Serviços
      if (calculaReceita($row->o57_fonte, $servicos)) {
        $receitas[14][1] += $row->saldo_inicial;
      }
      //Cota-Parte do FPM
      if (calculaReceita($row->o57_fonte, $fpm)) {
        $receitas[16][1] += $row->saldo_inicial;
      }
      //Cota-Parte do ICMS
      if (calculaReceita($row->o57_fonte, $icms)) {
        $receitas[17][1] += $row->saldo_inicial;
      }
      //Cota-Parte do IPVA
      if (calculaReceita($row->o57_fonte, $ipva)) {
        $receitas[18][1] += $row->saldo_inicial;
      }
      //Cota-Parte do ITR
      if (calculaReceita($row->o57_fonte, $itr)) {
        $receitas[19][1] += $row->saldo_inicial;
      }
      //Transferências da LC 61/1989
      if (calculaReceita($row->o57_fonte, $lc)) {
        $receitas[20][1] += $row->saldo_inicial;
      }
      //Transferências do FUNDEB
      if (calculaReceita($row->o57_fonte, $fundeb)) {
        $receitas[21][1] += $row->saldo_inicial;
      }
      //Outras Transferências Correntes
      if (calculaReceita($row->o57_fonte, $outrasTransferencias)) {
        $receitas[22][1] += $row->saldo_inicial;
      }
      //Outras Receitas Correntes
      if (calculaReceita($row->o57_fonte, $outrasReceitasCorrentes)) {
        $receitas[23][1] += $row->saldo_inicial;
      }
      //Contrib. do Servidor para o Plano de Previdência
      if (calculaReceita($row->o57_fonte, $contribPlanoPrev)) {
        $receitas[25][1] += $row->saldo_inicial;
      }
      //Compensação Financ. entre Regimes Previdência
      if (calculaReceita($row->o57_fonte, $conpensacaoRegimePrev)) {
        $receitas[26][1] += $row->saldo_inicial;
      }
      //Rendimentos de Aplicações de Recursos Previdenciários
      if (calculaReceita($row->o57_fonte, $rendimentosRecursosPrev)) {
        $receitas[27][1] += $row->saldo_inicial;
      }
      //Dedução de Receita para Formação do FUNDEB
      if (calculaReceita($row->o57_fonte, $deducaoFundeb)) {
        $receitas[28][1] += ($row->saldo_inicial * -1);
      }
      // Transf. obrigatórias da União relativas às emendas individuais
      if (calculaReceita($row->o57_fonte, $transfIndividuais)) {
        $receitas[30][1] += $row->saldo_inicial;
      }
      // Transf. obrigatórias da União relativas às emendas de bancada
      if (calculaReceita($row->o57_fonte, array('4171')) && $row->o70_codigo == 16040000) {
        $receitas[32][1] += $row->saldo_inicial;
      }
      if (calculaReceita($row->o57_fonte, $transfBancada)) {
        $receitas[32][1] += $row->saldo_inicial;
      }
    }

    //TOTALIZADORES
    //Outros Impostos, Taxas e Contribuições de Melhoria
    $receitas[7][1]  -= ($receitas[3][1] + $receitas[4][1] + $receitas[5][1] + $receitas[6][1]);
    //Impostos, taxas e Contribuições de Melhoria
    $receitas[2][1]   = $receitas[3][1] + $receitas[4][1] + $receitas[5][1] + $receitas[6][1] + $receitas[7][1];
    //Outras Receitas Patrimoniais
    $receitas[11][1] -= $receitas[10][1];
    //Receita Patrimonial
    $receitas[9][1]   = $receitas[11][1] + $receitas[10][1];
    //Outras Transferências Correntes
    $receitas[22][1] -= ($receitas[16][1] + $receitas[17][1] + $receitas[18][1] + $receitas[19][1] + $receitas[20][1] + $receitas[21][1]);
    //Transferências Correntes
    $receitas[15][1]  = $receitas[22][1] + $receitas[16][1] + $receitas[17][1] + $receitas[18][1] + $receitas[19][1] + $receitas[20][1] + $receitas[21][1];
    //RECEITAS CORRENTES (I)
    $receitas[1][1]   = $receitas[2][1] + $receitas[8][1] +  $receitas[9][1] + $receitas[12][1] + $receitas[13][1] + $receitas[14][1] + $receitas[15][1] + $receitas[23][1];
    //DEDUÇOES (II)
    $receitas[24][1]  = $receitas[25][1] + $receitas[26][1] + $receitas[27][1] + $receitas[28][1];
    //RECEITA CORRENTE LÍQUIDA
    $receitas[29][1]  = $receitas[1][1] - $receitas[24][1];
    //RCL DOS LIMITES DE ENDIVIDAMENTO
    $receitas[31][1]  = $receitas[29][1] - $receitas[30][1];
    //RCL DOS LIMITES DA DESPESA COM PESSOAL
    $receitas[33][1]  = $receitas[31][1] - $receitas[32][1];

    for ($j = 1; $j <= 33; $j++) {
      if (in_array($j, $bold)) {
        $fonte = 'B';
      } else {
        $fonte = '';
      }

      if (in_array($j, $preencCelula)) {
        $pdf->SetFillColor(211, 211, 211);
      } else {
        $pdf->SetFillColor(255, 255, 255);
      }

      if ($j < 30) {
        $pdf->setfont('arial', $fonte, 6);
        $pdf->cell($clEspec, $alt, $receitas[$j][0], 'RL', 0, "L", 1);
      } else if ($j == 30) {
        $pdf->setfont('arial', $fonte, 6);
        $pdf->cell($clEspec, $alt, '  ( - ) Transf. obrigatórias da União relativas às emendas individuais', 'RL', 0, "L", 1);
      } else if ($j == 32) {
        $pdf->setfont('arial', $fonte, 5);
        $pdf->cell($clEspec, $alt, '  ( - ) Transf. obrigatórias da União relativas às emendas de bancada e ao vencimento dos agentes comunitários de saúde e de combate às endemias', 'RL', 0, "L", 1);
        $pdf->setfont('arial', $fonte, 6);
      } else {
        $pdf->setfont('arial', $fonte, 6);
        $pdf->cell($clEspec, $alt, $receitas[$j][0], $j == 33 ? 'RBL' : 'RL', 0, "L", 1);
      }
      $valor = trim(db_formatar($receitas[$j][1], 'f'));
      if (strlen($valor) > $fonteNumeroGrande) {
        $pdf->setfont('arial', $fonte, 5);
      }
      $pdf->cell($cl, $alt, $valor, $j == 33 ? 'RBL' : 'RL', 0, "R", 1);
      $pdf->ln();
      $pdf->setX($espaçamento);
    }
    $pdf->ln();
    // ----------------------------------------------------------------
  }
  $pdf->Output();
}
