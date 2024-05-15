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

include("fpdf151/pdf.php");
include("libs/db_liborcamento.php");
include("libs/db_libcontabilidade.php");
include("libs/db_sql.php");
include("fpdf151/assinatura.php");
$classinatura = new cl_assinatura;

$cldesdobramento = new cl_desdobramento();

//db_postmemory($HTTP_POST_VARS,2);exit;
db_postmemory($HTTP_POST_VARS);

$dtini = implode("-", array_reverse(explode("/", $DBtxt21)));
$dtfim = implode("-", array_reverse(explode("/", $DBtxt22)));

//---------------------------------------------------------------
$clselorcdotacao = new cl_selorcdotacao();

$clselorcdotacao->setDados($filtra_despesa); // passa os parametros vindos da func_selorcdotacao_abas.php
// $instits = $clselorcdotacao->getInstit();

$instits =  str_replace('-', ', ', $db_selinstit) ;

$w_elemento = $clselorcdotacao->getElemento();
//@ recupera as informações fornecidas para gerar os dados
//---------------------------------------------------------------

$head1 = "DESPESA POR ITEM/DESDOBRAMENTO";
$head2 = "EXERCÍCIO: " . db_getsession("DB_anousu");
$d1 = $DBtxt21;
$d2 = $DBtxt22;
$head3 = "Período selecionado: $d1 à $d2  ";

$resultinst = db_query("select codigo,nomeinstabrev from db_config where codigo in ($instits)");
$descr_inst = '';
$xvirg = '';
for ($xins = 0; $xins < pg_numrows($resultinst); $xins++) {
    db_fieldsmemory($resultinst, $xins);
    $descr_inst .= $xvirg . $nomeinstabrev;
    $xvirg = ', ';
}
$head6 = "INSTITUIÇÕES : " . $descr_inst;

/////////////////////////////////////////////////////////

$anousu = db_getsession("DB_anousu");
$sele_work = $clselorcdotacao->getDados(false, true) . " and o58_instit in ($instits) and  o58_anousu=$anousu  ";
if ($w_elemento != "") {
    $w_elemento = " and o58_codele in  ({$w_elemento}) ";
}

$sqlprinc = db_dotacaosaldo(8, 1, 4, true, $sele_work, $anousu, $dtini, $datafin, 8, 0, true);

$result = db_query($sqlprinc) or die(pg_last_error());

if (pg_num_rows($result) == 0) {
    db_redireciona('db_erros.php?fechar=true&db_erro=Nenhum registro encontrado, verifique as datas e tente novamente');
}



/**
 * Imprime Linha CSV
 * @param $array array Informações da respectiva linha
 * @return string
 */
function imprimeLinhaCSV($array)
{
  return implode(';', $array) . "\n";
}

//-----------------------------------------------------

// cabeçalho
$aTHs = array(
  'Órgão', '',
  'Unidade', '',
  'Função', '',
  'Subfunção', '',
  'Programa', '',
  'ProjAtiv', '',
  'Elemento', '',
  'Recurso',

  'Desdobramento',
  'Empenhado no mês',
  'Vlr. Emp. no mês a liquidar',
  'Vlr. Emp. no mês em liquidação',
  'Empenhado até mês',
  'Liquidado no mês',
  'Liquidado até mês',
  'Saldo de empenhos',
  'Saldo de Empenhos a liquidar',
  'Saldo Empenho em liquidação',
  'Pago no mês',
  'Pago até mês',
  'Saldo Líquido de Emp'
);

// header("Content-type: text/plain;");

ini_set("display_errors", 'On');
$fp = fopen("tmp/despitemdesdobramento.csv","w");
ini_set("display_errors", 'Off');

fputs($fp, imprimeLinhaCSV($aTHs));


// dados para as iterações

$troca = 1;
$alt = 4;
$pagina = 1;
$xorgao = 0;
$xunidade = 0;
$xfuncao = 0;
$xsubfuncao = 0;
$xprograma = 0;
$xprojativ = 0;
$pagina = 1;

$totgeralempenhado = 0;
$totgeralempenhadoa = 0;
$totgeralliquidado = 0;
$totgeralliquidadoa = 0;
$totgeralsaldoemp = 0;
$totgeralpago = 0;
$totgeralpagoa = 0;
$totgeralsaldoliqemp = 0;
$totgeralempdomes = 0;
$totgeralestornadoempdomes = 0;
$totgeralestornadooutrosmeses = 0;
$totgeralempdomesliquidar = 0;
$totgeralempdomesemliquidacao = 0;
$totgeralliquidadoempdomes = 0;
$totgeralempliquidara = 0;
$totgeralempemliquidacaoa = 0;

//Total Geral
$totgeralempenhadogeral = 0;
$totgeralempenhadoageral = 0;
$totgeralliquidadogeral = 0;
$totgeralliquidadoageral = 0;
$totgeralsaldoempgeral = 0;
$totgeralpagogeral = 0;
$totgeralpagoageral = 0;
$totgeralsaldoliqempgeral = 0;
$totgeralempdomesgeral = 0;
$totgeralestornadoempdomesgeral = 0;
$totgeralestornadooutrosmesesgeral = 0;
$totgeralempdomesliquidargeral = 0;
$totgeralempdomesemliquidacaogeral = 0;
$totgeralliquidadoempdomesgeral = 0;
$totgeralempliquidarageral = 0;
$totgeralempemliquidacaoageral = 0;

$quebra_unidade = 'N';
$nivela = 1;

$orguniant = "";

if (pg_numrows($result) > 0) {
    db_fieldsmemory($result, 0);
    $orguniant = db_formatar($o58_orgao, 'orgao') . db_formatar($o58_unidade, 'unidade');
}



// registros do banco

for ($i = 0; $i < pg_numrows($result); $i++) {

  db_fieldsmemory($result, $i);

  $aBaseLinha = array();
  $aLinhas    = array();
  $aSubtotal  = array();

  if ($nivela == 2 and $o58_unidade == 0) {
    continue;
  }

  // orgao
  $sCodOrgao    = db_formatar($o58_orgao, 'orgao');
  $aBaseLinha[] = $sCodOrgao;
  $aBaseLinha[] = $o40_descr;


  // unidade
  $sCodUnidade  = db_formatar($o58_unidade, 'orgao');
  $aBaseLinha[] = $sCodOrgao . $sCodUnidade;
  $aBaseLinha[] = $o41_descr;


  // função
  $sCodFuncao   = db_formatar($o58_funcao, 'orgao');
  $aBaseLinha[] = $sCodOrgao . $sCodUnidade . $sCodFuncao;
  $aBaseLinha[] = $o52_descr;


  // subfunção
  $sCodSubfuncao = db_formatar($o58_subfuncao, 's', '0', 3, 'e');
  $aBaseLinha[] = $sCodOrgao . $sCodUnidade . $sCodFuncao . '.' . $sCodSubfuncao;
  $aBaseLinha[] = $o53_descr;


  // programa
  $sCodPrograma = db_formatar($o58_programa, 'orgao');
  $aBaseLinha[] = $sCodOrgao . $sCodUnidade . $sCodFuncao . '.' . $sCodSubfuncao . '.' . $sCodPrograma;
  $aBaseLinha[] = $o54_descr;


  //projativ
  $sCodProjAtiv = db_formatar($o58_projativ, 'projativ');
  $aBaseLinha[] = $sCodOrgao . $sCodUnidade . $sCodFuncao . '.' . $sCodSubfuncao . '.' . $sCodPrograma . '.' . $sCodProjAtiv;
  $aBaseLinha[] = $o55_descr;


  // elemento
  $sCodElemento = db_formatar($o58_elemento, 'elemento');
  $aBaseLinha[] = $sCodOrgao . $sCodUnidade . $sCodFuncao . '.' . $sCodSubfuncao . '.' . $sCodPrograma . '.' . $sCodProjAtiv . '.' . $sCodElemento;
  $aBaseLinha[] = $o56_descr;


  // base de colunas da linha para linha do subtotal
  $aSubtotal = $aLinha = $aBaseLinha;


  // recurso
  $sRecursoAux = trim($o15_descr);
  if (empty($sRecursoAux) && empty($o58_codigo)) {
    continue;
  }

  $sColunaRecurso = 'Recurso: ' . $o58_codigo . '-' . $o15_descr;


  // dados da linha
  $totgeralempenhado            = 0;
  $totgeralempenhadoa           = 0;
  $totgeralliquidado            = 0;
  $totgeralliquidadoa           = 0;
  $totgeralsaldoemp             = 0;
  $totgeralpago                 = 0;
  $totgeralpagoa                = 0;
  $totgeralsaldoliqemp          = 0;
  $totgeralempdomes             = 0;
  $totgeralestornadoempdomes    = 0;
  $totgeralestornadooutrosmeses = 0;
  $totgeralempdomesliquidar     = 0;
  $totgeralempdomesemliquidacao = 0;
  $totgeralliquidadoempdomes    = 0;
  $totgeralempliquidara         = 0;
  $totgeralempemliquidacaoa     = 0;


  // desdobramentos
  if ($o58_elemento != "") {
    $sele_work2 = " 1=1 and o58_orgao in ({$o58_orgao}) and ( ( o58_orgao = {$o58_orgao} and o58_unidade = {$o58_unidade} ) ) and o58_funcao in ({$o58_funcao}) and o58_subfuncao in ({$o58_subfuncao}) and o58_programa in ({$o58_programa}) and o58_projativ in ({$o58_projativ}) and (o56_elemento like '" . substr($o58_elemento, 0, 7) . "%') and o58_codigo in ({$o58_codigo}) and o58_instit in ({$instits}) and o58_anousu={$anousu} ";
    /**
     * Despesas no mes
     */
    $resDepsMes = db_query($cldesdobramento->sql_liquidacao($sele_work2, $dtini, $dtfim, "({$instits})")) or die($cldesdobramento->sql_liquidacao($sele_work2, $dtini, $dtfim, "({$instits})") . pg_last_error());
    $aDadosAgrupados = array();

    for ($contDesp = 0; $contDesp < pg_num_rows($resDepsMes); $contDesp++) {
      $oDadosMes = db_utils::fieldsMemory($resDepsMes, $contDesp);

      $sHash = $oDadosMes->o56_elemento;

      if (!isset($aDadosAgrupados[$sHash])) {

        $oDespesas = new stdClass();
        $oDespesas->c60_estrut = $oDadosMes->c60_estrut;
        $oDespesas->c60_descr = $oDadosMes->c60_descr;
        $oDespesas->o56_elemento = $oDadosMes->o56_elemento;
        $oDespesas->o56_descr = $oDadosMes->o56_descr;
        $oDespesas->empenhado = $oDadosMes->empenhado;
        $oDespesas->empenhadoa = 0;
        $oDespesas->empenhado_estornado = $oDadosMes->empenhado_estornado;
        $oDespesas->empenhado_estornadoa = 0;
        $oDespesas->liquidado = $oDadosMes->liquidado;
        $oDespesas->liquidadoa = 0;
        $oDespesas->liquidado_estornado = $oDadosMes->liquidado_estornado;
        $oDespesas->liquidado_estornadoa = 0;
        $oDespesas->pagamento = $oDadosMes->pagamento;
        $oDespesas->pagamentoa = 0;
        $oDespesas->pagamento_estornado = $oDadosMes->pagamento_estornado;
        $oDespesas->pagamento_estornado = $oDadosMes->pagamento_estornado;
        $oDespesas->empenho_rpestornado = $oDadosMes->empenho_rpestornado;
        $oDespesas->empenho_rpestornadoa = 0;
        $oDespesas->estornado_mes_origem = $oDadosMes->estornado_mes_origem;
        $oDespesas->estornado_mes_diferente = $oDadosMes->estornado_mes_diferente;
        $oDespesas->em_liquidacao_mes_origem = $oDadosMes->em_liquidacao_mes_origem;
        $oDespesas->liquidado_mes_origem = $oDadosMes->liquidado_mes_origem;        
        $oDespesas->liquidado_estornado_mes_origem = $oDadosMes->liquidado_estornado_mes_origem;
        $oDespesas->liquidacao_mes_origem = $oDadosMes->liquidacao_mes_origem;
        $oDespesas->estorno_em_liquidacao_mes_origem = $oDadosMes->estorno_em_liquidacao_mes_origem;
        $oDespesas->estorno_liquidacao_mes_origem = $oDadosMes->estorno_liquidacao_mes_origem;        
        $oDespesas->em_liquidacaoa = 0;
        $oDespesas->liquidacaoa = 0;
        $oDespesas->estorno_em_liquidacaoa = 0;
        $oDespesas->estorno_liquidacaoa = 0;
        $aDadosAgrupados[$sHash] = $oDespesas;

      }
    }

    /**
     * Despesas até o mes
     */
    $resDepsAteMes = db_query($cldesdobramento->sql_em_liquidacao_ate_mes($sele_work2, $dtini, $dtfim, "({$instits})")) or die($cldesdobramento->sql_em_liquidacao_ate_mes($sele_work2, $dtini, $dtfim, "({$instits})") . pg_last_error());

    for ($contDesp = 0; $contDesp < pg_num_rows($resDepsAteMes); $contDesp++) {
      $oDadosAteMes = db_utils::fieldsMemory($resDepsAteMes, $contDesp);

      $sHash = $oDadosAteMes->o56_elemento;

      if (isset($aDadosAgrupados[$sHash])) {

        $aDadosAgrupados[$sHash]->empenhadoa = $oDadosAteMes->empenhadoa;
        $aDadosAgrupados[$sHash]->empenhado_estornadoa = $oDadosAteMes->empenhado_estornadoa;
        $aDadosAgrupados[$sHash]->liquidadoa = $oDadosAteMes->liquidadoa;
        $aDadosAgrupados[$sHash]->liquidado_estornadoa = $oDadosAteMes->liquidado_estornadoa;
        $aDadosAgrupados[$sHash]->pagamentoa = $oDadosAteMes->pagamentoa;
        $aDadosAgrupados[$sHash]->pagamento_estornadoa = $oDadosAteMes->pagamento_estornadoa;
        $aDadosAgrupados[$sHash]->em_liquidacaoa = $oDadosAteMes->em_liquidacaoa;
        $aDadosAgrupados[$sHash]->liquidacaoa = $oDadosAteMes->liquidacaoa;
        $aDadosAgrupados[$sHash]->estorno_em_liquidacaoa = $oDadosAteMes->estorno_em_liquidacaoa;
        $aDadosAgrupados[$sHash]->estorno_liquidacaoa = $oDadosAteMes->estorno_liquidacaoa;
      } else {

        $oDespesas = new stdClass();
        $oDespesas->c60_estrut = $oDadosAteMes->c60_estrut;
        $oDespesas->c60_descr = $oDadosAteMes->c60_descr;
        $oDespesas->o56_elemento = $oDadosAteMes->o56_elemento;
        $oDespesas->o56_descr = $oDadosAteMes->o56_descr;
        $oDespesas->empenhado = $oDadosAteMes->empenhado;
        $oDespesas->empenhadoa = $oDadosAteMes->empenhadoa;
        $oDespesas->empenhado_estornado = $oDadosAteMes->empenhado_estornado;
        $oDespesas->empenhado_estornadoa = $oDadosAteMes->empenhado_estornadoa;
        $oDespesas->liquidado = $oDadosAteMes->liquidado;
        $oDespesas->liquidadoa = $oDadosAteMes->liquidadoa;
        $oDespesas->liquidado_estornado = $oDadosAteMes->liquidado_estornado;
        $oDespesas->liquidado_estornadoa = $oDadosAteMes->liquidado_estornadoa;
        $oDespesas->pagamento = $oDadosAteMes->pagamento;
        $oDespesas->pagamentoa = $oDadosAteMes->pagamentoa;
        $oDespesas->pagamento_estornado = $oDadosAteMes->pagamento_estornado;
        $oDespesas->pagamento_estornadoa = $oDadosAteMes->pagamento_estornadoa;
        $oDespesas->empenho_rpestornado = $oDadosAteMes->empenho_rpestornado;
        $oDespesas->empenho_rpestornadoa = $oDadosAteMes->empenho_rpestornadoa;
        $oDespesas->em_liquidacaoa = $oDadosAteMes->em_liquidacaoa;
        $oDespesas->liquidacaoa = $oDadosAteMes->liquidacaoa;
        $oDespesas->estorno_em_liquidacaoa = $oDadosAteMes->estorno_em_liquidacaoa;
        $oDespesas->estorno_liquidacaoa = $oDadosAteMes->estorno_liquidacaoa;
        $aDadosAgrupados[$sHash] = $oDespesas;

      }
    }

    asort($aDadosAgrupados);

    if (empty($aDadosAgrupados)) {
      continue;
    }

    foreach ($aDadosAgrupados as $objElementos) {

      $aLinha = $aBaseLinha;

      // recurso
      $aLinha[] = $sColunaRecurso;

      $empenhadoNoMes         = ($objElementos->empenhado - $objElementos->empenhado_estornado - $objElementos->empenho_rpestornado);
      $empenhadoAteMes        = ($objElementos->empenhadoa - $objElementos->empenhado_estornadoa - $objElementos->empenho_rpestornadoa);
      $liquidadoNoMes         = ($objElementos->liquidado - $objElementos->liquidado_estornado);
      $liquidadoAteMes        = ($objElementos->liquidadoa - $objElementos->liquidado_estornadoa);
      $saldoEmpenho           = ($objElementos->empenhadoa - $objElementos->empenhado_estornadoa);
      $pagoMes                = ($objElementos->pagamento - $objElementos->pagamento_estornado);
      $pagoAteMes             = ($objElementos->pagamentoa - $objElementos->pagamento_estornadoa);
      $empenhadoLiquidacaoa   = ($objElementos->em_liquidacaoa - $objElementos->liquidacaoa + $objElementos->estorno_liquidacaoa - $objElementos->estorno_em_liquidacaoa);
      $empenhadoLiquidara     = ($empenhadoAteMes - $liquidadoAteMes - $empenhadoLiquidacaoa);
      $empenhadoLiquidacao    = ($objElementos->em_liquidacao_mes_origem - $objElementos->liquidacao_mes_origem + $objElementos->estorno_liquidacao_mes_origem - $objElementos->estorno_em_liquidacao_mes_origem); 
      $empenhadoLiquidadoMes  = ($objElementos->liquidado_mes_origem - $objElementos->liquidado_estornado_mes_origem);
      $empenhadoLiquidar      = ($objElementos->empenhado - $objElementos->estornado_mes_origem - $empenhadoLiquidacao - $empenhadoLiquidadoMes);

      // informações
      $aLinha[] = substr($objElementos->o56_elemento." - ".$objElementos->o56_descr, 0, 40);
      $aLinha[] = trim(db_formatar($empenhadoNoMes, 'f'));
      $aLinha[] = trim(db_formatar($empenhadoNoMes, 'f'));
      $aLinha[] = trim(db_formatar($empenhadoLiquidacao, 'f'));      
      $aLinha[] = trim(db_formatar($empenhadoAteMes, 'f'));
      $aLinha[] = trim(db_formatar($liquidadoNoMes, 'f'));
      $aLinha[] = trim(db_formatar($liquidadoAteMes, 'f'));
      $aLinha[] = trim(db_formatar($saldoEmpenho - $liquidadoAteMes, 'f'));
      $aLinha[] = trim(db_formatar($saldoEmpenho - $liquidadoAteMes, 'f'));
      $aLinha[] = trim(db_formatar($empenhadoLiquidacaoa, 'f'));   
      $aLinha[] = trim(db_formatar($pagoMes, 'f'));
      $aLinha[] = trim(db_formatar($pagoAteMes, 'f'));
      $aLinha[] = trim(db_formatar($liquidadoAteMes - $pagoAteMes, 'f'));

      //Totalizadores
      $totgeralempenhado              += $empenhadoNoMes;
      $totgeralempenhadoa             += $empenhadoAteMes;
      $totgeralliquidado              += $liquidadoNoMes;
      $totgeralliquidadoa             += $liquidadoAteMes;
      $totgeralsaldoemp               += ($saldoEmpenho - $liquidadoAteMes);
      $totgeralpago                   += $pagoMes;
      $totgeralpagoa                  += $pagoAteMes;
      $totgeralsaldoliqemp            += ($liquidadoAteMes - $pagoAteMes);
      $totgeralempdomes               += $objElementos->empenhado;
      $totgeralestornadoempdomes      += $objElementos->estornado_mes_origem;
      $totgeralestornadooutrosmeses   += $objElementos->estornado_mes_diferente;
      $totgeralempdomesliquidar       += $empenhadoLiquidar;
      $totgeralempdomesemliquidacao   += $empenhadoLiquidacao;
      $totgeralliquidadoempdomes      += $empenhadoLiquidadoMes;
      $totgeralempliquidara           += $empenhadoLiquidara;
      $totgeralempemliquidacaoa       += $empenhadoLiquidacaoa;

      /////////////////////////////;
      fputs($fp, imprimeLinhaCSV($aLinha));
      /////////////////////////////;

    }

  } else {
    continue;
  }

  // linha do subtotal
  $aSubtotal[] = ''; // coluna do recurso
  $aSubtotal[] = 'SUBTOTAL ';
  $aSubtotal[] = trim(db_formatar($totgeralempenhado, 'f'));
  $aSubtotal[] = trim(db_formatar($totgeralempenhado, 'f'));
  $aSubtotal[] = trim(db_formatar($totgeralempdomesemliquidacao, 'f'));  
  $aSubtotal[] = trim(db_formatar($totgeralempenhadoa, 'f'));
  $aSubtotal[] = trim(db_formatar($totgeralliquidado, 'f'));
  $aSubtotal[] = trim(db_formatar($totgeralliquidadoa, 'f'));
  $aSubtotal[] = trim(db_formatar($totgeralsaldoemp, 'f'));
  $aSubtotal[] = trim(db_formatar($totgeralsaldoemp, 'f'));
  $aSubtotal[] = trim(db_formatar($totgeralempemliquidacaoa, 'f'));  
  $aSubtotal[] = trim(db_formatar($totgeralpago, 'f'));
  $aSubtotal[] = trim(db_formatar($totgeralpagoa, 'f'));
  $aSubtotal[] = trim(db_formatar($totgeralsaldoliqemp, 'f'));

  //Total Geral
  $totgeralempenhadogeral             += $totgeralempenhado;
  $totgeralempenhadoageral            += $totgeralempenhadoa;
  $totgeralliquidadogeral             += $totgeralliquidado;
  $totgeralliquidadoageral            += $totgeralliquidadoa;
  $totgeralsaldoempgeral              += $totgeralsaldoemp;
  $totgeralpagogeral                  += $totgeralpago;
  $totgeralpagoageral                 += $totgeralpagoa;
  $totgeralsaldoliqempgeral           += $totgeralsaldoliqemp;
  $totgeralempdomesgeral              += $totgeralempdomes;
  $totgeralestornadoempdomesgeral     += $totgeralestornadoempdomes;
  $totgeralestornadooutrosmesesgeral  += $totgeralestornadooutrosmeses;
  $totgeralempdomesliquidargeral      += $totgeralempdomesliquidar;
  $totgeralempdomesemliquidacaogeral  += $totgeralempdomesemliquidacao;
  $totgeralliquidadoempdomesgeral     += $totgeralliquidadoempdomes;
  $totgeralempliquidarageral          += $totgeralempliquidara;
  $totgeralempemliquidacaoageral      += $totgeralempemliquidacaoa; 

  ////////////////////////////////;
  fputs($fp, imprimeLinhaCSV($aSubtotal));
  ////////////////////////////////;

}


////////////////////////////////;
fputs($fp, implode(';', array(
  // títulos
  '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',
  'TOTAL GERAL',
  trim(db_formatar($totgeralempenhadogeral, 'f')),
  trim(db_formatar($totgeralempenhadogeral, 'f')),
  trim(db_formatar($totgeralempdomesemliquidacaogeral, 'f')),
  trim(db_formatar($totgeralempenhadoageral, 'f')),
  trim(db_formatar($totgeralliquidadogeral, 'f')),
  trim(db_formatar($totgeralliquidadoageral, 'f')),
  trim(db_formatar($totgeralsaldoempgeral, 'f')),
  trim(db_formatar($totgeralsaldoempgeral, 'f')),
  trim(db_formatar($totgeralempemliquidacaoageral, 'f')),
  trim(db_formatar($totgeralpagogeral, 'f')),
  trim(db_formatar($totgeralpagoageral, 'f')),
  trim(db_formatar($totgeralsaldoliqempgeral, 'f'))

)));
////////////////////////////////;


pg_free_result($result);


echo "<html><body bgcolor='#cccccc'><center><a href='tmp/despitemdesdobramento.csv'>Clique com botão direito para Salvar o arquivo <b>tmp/despitemdesdobramento.csv</b></a></body></html>";

?>
