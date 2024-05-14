<?
/* aa a
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

require_once("fpdf151/scpdf.php");
require_once("fpdf151/impcarne.php");
require_once("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("classes/db_pagordem_classe.php");
require_once("classes/db_pagordemele_classe.php");
require_once("model/retencaoNota.model.php");
require_once("classes/db_empautitem_classe.php");
require_once("classes/db_empagetipo_classe.php");
require_once("classes/db_empagemov_classe.php");
require_once("classes/db_emite_nota_liq.php");
require_once("classes/db_empdiaria_classe.php");
require_once("classes/db_rhpessoal_classe.php");
require_once("classes/db_identificacaoresponsaveis_classe.php");
require_once("model/orcamento/ControleOrcamentario.model.php");

/*
 * Configurações GED
*/
require_once("integracao_externa/ged/GerenciadorEletronicoDocumento.model.php");
require_once("integracao_externa/ged/GerenciadorEletronicoDocumentoConfiguracao.model.php");
require_once("libs/exceptions/BusinessException.php");

$oGet           = db_utils::postMemory($_GET);
$clpagordem     = new cl_pagordem;
$clpagordemele  = new cl_pagordemele;
$clempautitem   = new cl_empautitem;
$clempagetipo   = new cl_empagetipo;
$clempagemov   = new cl_empagemov;
$clemite_nota_liq = new cl_emite_nota_liq;
$clDiaria = new cl_empdiaria;
$clRhpessoal = new cl_rhpessoal;
$clReponsaveis = new cl_identificacaoresponsaveis;

$sFornecedor = null;
if (isset($oGet) && !empty($oGet)) {
  $sFornecedor = !empty($oGet->aFornecedor) ? $oGet->aFornecedor : null;
}
$e50_codord = $codordem;
$oConfiguracaoGed = GerenciadorEletronicoDocumentoConfiguracao::getInstance();
if ($oConfiguracaoGed->utilizaGED()) {

  if (empty($oGet->e60_codemp_ini)) {
    $oGet->e60_codemp_ini = null;
  }

  if (empty($oGet->e60_codemp_fim)) {
    $oGet->e60_codemp_fim = null;
  }

  if (!empty($oGet->dtini) || !empty($oGet->dtfim) || $oGet->e60_codemp_ini != $oGet->e60_codemp_fim) {

    $sMsgErro  = "O parâmetro para utilização do GED (Gerenciador Eletrônico de Documentos) está ativado.<br><br>";
    $sMsgErro .= "Neste não é possível informar interválos de códigos ou datas.<br><br>";
    db_redireciona("db_erros.php?fechar=true&db_erro={$sMsgErro}");
    exit;
  }
}


parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$sqlpref = "select * from db_config where codigo = " . db_getsession("DB_instit");
$resultpref = db_query($sqlpref);
db_fieldsmemory($resultpref, 0);

$dbwhere = "";
$iAnoUso = db_getsession('DB_anousu');

if (isset($e60_codemp_ini) && $e60_codemp_ini != "") {
  if (isset($e60_codemp_fim) && $e60_codemp_fim != "") {
    $str = " e60_codemp::integer between " . $e60_codemp_ini . " and " . $e60_codemp_fim . " and e60_anousu = {$iAnoUso} ";
  } else {
    $codemp  = explode("/", $e60_codemp_ini);

    if (count($codemp) > 1) {
      $str = " e60_codemp = '" . $codemp[0] . "' and e60_anousu = " . $codemp[1] . " ";
    } else {
      $str = " e60_codemp = '" . $e60_codemp_ini . "' and e60_anousu = {$iAnoUso} ";
    }

    if (isset($e50_numliquidacao) && $e50_numliquidacao != '') {
      $str .= " and e50_numliquidacao = $e50_numliquidacao ";
    }
  }
  $str .= " and e60_instit = " . db_getsession("DB_instit");
  $dbwhere = " {$str} ";
}

if (isset($recursos) && $recursos != "") {
  if (strlen($dbwhere) > 0) {
    $dbwhere .= " and ";
  }
  $dbwhere .= " o58_codigo in ($recursos) ";
}

if (isset($codordem) && $codordem != '') {
  if (strlen($dbwhere) > 0) {
    $dbwhere .= " and ";
  }
  $dbwhere .= " e50_codord in ($codordem) ";
} elseif (isset($e50_codord_ini) && $e50_codord_ini != '') {
  if (strlen($dbwhere) > 0) {
    $dbwhere .= " and ";
  }

  if (isset($e50_codord_fim) && $e50_codord_fim != '') {
    $dbwhere .= "e50_codord::integer between " . $e50_codord_ini . " and " . $e50_codord_fim;
  } else {
    $dbwhere .= " e50_codord in ($e50_codord_ini) ";
  }
} else {
  if (strlen($dbwhere) > 0) {
    $dbwhere .= " and ";
  }
  $dbwhere .= "1=1 ";
}

if (isset($dtini) && $dtini != "") {
  if (strlen($dbwhere) > 0) {
    $dbwhere .= " and ";
  }

  $dtini = str_replace("X", "-", $dtini);
  $dbwhere .= " k12_data between '$dtini'";

  if (isset($dtfim) && $dtfim != "") {
    $dtfim = str_replace("X", "-", $dtfim);
    $dbwhere .= " and '$dtfim'";
  }else {
    $dbwhere .= " and '".date('Y-m-d',db_getsession('DB_datausu'))."'";
  }
}

if (isset($dtfim) && $dtfim != "" && !(isset($dtini) && $dtini != "")) {
  if (strlen($dbwhere) > 0) {
    $dbwhere .= " and ";
  }
  $dtfim = str_replace("X", "-", $dtfim);
  $dbwhere .= " k12_data between '$iAnoUso-01-01' and '$dtfim'";
}

if (isset($e60_numemp) && $e60_numemp != '') {

  if (strlen($dbwhere) > 0) {
    $dbwhere .= " and ";
  }
  $dbwhere .= " e60_numemp=$e60_numemp ";
  if (isset($e50_numliquidacao) && $e50_numliquidacao != '') {
    $dbwhere .= " and e50_numliquidacao = $e50_numliquidacao ";
  }
}

if (!empty($sFornecedor)) {

  if (strlen($dbwhere) > 0) {
    $dbwhere .= " and ";
  }
  $dbwhere .= " z01_numcgm in ({$sFornecedor}) ";
}

if(isset($sOrdens) && $sOrdens != '') {

  if (strlen($dbwhere) > 0) {
    $dbwhere .= " and ";
  }
  $dbwhere .= " e50_codord in ($sOrdens) ";
}

$dbwhere .= " and e60_instit = " . db_getsession("DB_instit");

$pdf = new scpdf();
$pdf->Open();
$pdf1 = new db_impcarne($pdf, '85');
$pdf1->objpdf->SetTextColor(0, 0, 0);

$sSqlPagordem = $clpagordem->consultaNotaDespesa('', 'distinct e50_codord,e60_numemp,e71_codnota,e60_numerol,pc50_descr,e50_numliquidacao', ' e60_numemp, e50_numliquidacao ', $dbwhere);
$result = $clpagordem->sql_record($sSqlPagordem);

if ($clpagordem->numrows < 1) {
  db_redireciona('db_erros.php?fechar=true&db_erro=Dados não encontrados. Verifique!');
}

$result2 = db_query("select * from empparametro where e39_anousu = " . db_getsession("DB_anousu"));

if (pg_numrows($result2) > 0) {
  db_fieldsmemory($result2, 0);
  $pdf1->nvias = $e30_nroviaord;
}

for ($i = 0; $i < $clpagordem->numrows; $i++) {
  db_fieldsmemory($result, $i);

  $dbWhere = "e60_instit = ".db_getsession('DB_instit')." and e50_codord = " . $e50_codord;
  if(isset($sMovimentos) && $sMovimentos != ''){
    $dbWhere .= " and e81_codmov in (".$sMovimentos.")";
  }

  $camposMovimentos = " case when k12_sequencial is not null then false
  when k12_sequencial is null and e81_cancelado is not null then true
  when k12_sequencial is null and e81_cancelado is null then false
  end as estornado, * ";
  $sqlMovimentos = $clempagemov->consultaMovimentosDaOp(null, $camposMovimentos, null, $dbWhere);
  $rsMovimentos = $clempagemov->sql_record($sqlMovimentos);

  for ($j = 0; $j < $clempagemov->numrows; $j++) {

    db_fieldsmemory($rsMovimentos, $j);

    if($k12_sequencial != null || $estornado == 't'){

    $rsBanco = db_utils::fieldsMemory(db_query("SELECT db90_descr FROM db_bancos WHERE db90_codban = '{$c63_banco}'"), 0)->db90_descr;
    $rsForma = db_utils::fieldsMemory(db_query("SELECT e96_descr FROM empageforma WHERE e96_codigo = " . $e97_codforma), 0)->e96_descr;

    if (strpos($db83_descricao, $db83_conta) !== false) {
      $conta = $c61_reduz . ' - ' . $db83_descricao;
    } else {
      $conta = $c61_reduz . ' - ' . $db83_conta . '-' . $db83_dvconta . ' - ' . $db83_descricao;
    }

    db_fieldsmemory($result, $i);
    $oRetencaoNota = new retencaoNota($e71_codnota);
    $oRetencaoNota->setINotaLiquidacao($e50_codord);

    $sql = $clemite_nota_liq->get_sql_ordem_pagamento(db_getsession("DB_instit"), db_getsession("DB_anousu"), $e50_codord);

    $resultord = db_query($sql);
    db_fieldsmemory($resultord, $i);

    if (pg_numrows($resultord) == 0) continue;

    db_fieldsmemory($resultord, 0);

    $sql1         = $clemite_nota_liq->get_sql_assinaturas($e50_codord);
    $resultordass = db_query($sql1);
    db_fieldsmemory($resultordass, 0);

    $aRetencoes = $oRetencaoNota->getRetencoesFromDB($e50_codord, false, 1, "", "", true, false);

    $sqlfornecon         = $clemite_nota_liq->get_sql_fornecedor($z01_cgccpf);
    $result_pcfornecon   = db_query($sqlfornecon);
    if (pg_numrows($result_pcfornecon) > 0) {
      db_fieldsmemory($result_pcfornecon, 0);
    }

    if ($o41_cnpj != "" && $o41_cnpj != $cgc) {
      $nomeinst = $o41_descr;
      $cgc      = $o41_cnpj;
    }

    $clControleOrc = new ControleOrcamentario;
    $e60_codco = $e60_codco == null ? '0000' : $e60_codco;
    $clControleOrc->setCodCO($e60_codco);

    $pdf1->bancoPagamento   = $c63_banco . ' - ' . $rsBanco;
    $pdf1->agenciaPagamento = $c63_agencia;
    $pdf1->contaPagamento   = $conta;
    $pdf1->movimento        = $e81_codmov;
    $pdf1->tipoDocumento    = $rsForma . ($e81_numdoc == null ? '' : ' / ' . $e81_numdoc);

    if($k12_sequencial != null){
      $sDataPagamento = $k12_data == null ? '' : date('d/m/Y', strtotime($k12_data));
      $sDataPagamentoISO = $k12_data;
    }else{
      $sDataPagamento = $e86_data == null ? '' : date('d/m/Y', strtotime($e86_data));
      $sDataPagamentoISO = $e86_data;
    }

    $pdf1->dataPagamento = $sDataPagamento;

    if ($e81_cancelado == null) {
      $sSqlEstorno = $clempagemov->consultaEstorno('c70_valor',$e50_codord,$sDataPagamentoISO, $e81_codmov);
      $aEstorno = pg_fetch_all(db_query($sSqlEstorno));
      $vlrEstorno = 0;
      foreach ($aEstorno as $estorno) {
        $vlrEstorno += $estorno['c70_valor'];
      }
    } else {
      $vlrEstorno = $e81_valor;
    }

    $sqlTesoureiro = $clReponsaveis->sql_query(null,'z01_nome',null, " si166_tiporesponsavel = 5 and ('$e80_data' between si166_dataini and si166_datafim) and si166_instit = ".db_getsession("DB_instit"));
    $tesoureiro = db_utils::fieldsMemory(db_query($sqlTesoureiro), 0)->z01_nome;

    //assinaturas
    $pdf1->ordenadespesa   = $assindsp;
    $pdf1->liquida         = $assinlqd;
    $pdf1->ordenapagamento = $assinord;
    $pdf1->contador        = $contador;
    $pdf1->crccontador     = $crc;
    $pdf1->controleinterno = $controleinterno;
    $pdf1->tesoureiro      = $tesoureiro;

    $pdf1->vlrEstorno       = $vlrEstorno == null ? 0 : $vlrEstorno;
    $pdf1->vlrPago          = $e81_valor;
    $pdf1->numliquidacao    = $e50_numliquidacao;
    $pdf1->logo             = $logo;
    $pdf1->processo         = $e60_numerol;
    $pdf1->descr_tipocompra = $pc50_descr;
    $pdf1->prefeitura       = $nomeinst;
    $pdf1->enderpref        = $ender;
    $pdf1->municpref        = $munic;
    $pdf1->telefpref        = $telef;
    $pdf1->emailpref        = $email;
    $pdf1->cgcpref          = $cgc;
    $pdf1->banco            = $pc63_banco;
    $pdf1->agencia          = $pc63_agencia;
    $pdf1->agenciadv        = $pc63_agencia_dig;
    $pdf1->conta            = $pc63_conta;
    $pdf1->tipoconta        = $pc63_tipoconta;
    $pdf1->contadv          = $pc63_conta_dig;
    $pdf1->numcgm           = $z01_numcgm;
    $pdf1->nome             = $z01_nome;
    $pdf1->cnpj             = $z01_cgccpf;
    $pdf1->ender            = $z01_ender;
    $pdf1->bairro           = $z01_bairro;
    $pdf1->cep              = $z01_cep;
    $pdf1->ufFornecedor     = $z01_uf;
    $pdf1->munic            = $z01_munic;
    $pdf1->ordpag           = $e50_codord;
    $pdf1->coddot           = $o58_coddot;
    $pdf1->dotacao          = $estrutural;
    $pdf1->ano              = $e60_anousu;
    $pdf1->aRetencoes       = $aRetencoes;
    $pdf1->empenhado        = $e60_vlremp;
    $pdf1->codemp           = $e60_codemp;
    $pdf1->numemp           = $e60_codemp . '/' . $e60_anousu;
    $pdf1->orgao            = $o58_orgao;
    $pdf1->descr_orgao      = $o40_descr;
    $pdf1->unidade          = $o58_unidade;
    $pdf1->descr_unidade    = $o41_descr;
    $pdf1->funcao           = $o58_funcao;
    $pdf1->descr_funcao     = $o52_descr;
    $pdf1->subfuncao        = $o58_subfuncao;
    $pdf1->descr_subfuncao  = $o53_descr;
    $pdf1->projativ         = $o58_projativ;
    $pdf1->descr_projativ   = $o55_descr;
    $pdf1->recurso          = $o58_codigo;
    $pdf1->descr_recurso    = $o15_descr;
    $pdf1->elemento         = $o56_elemento;
    $pdf1->descr_elemento   = $o56_descr;
    $pdf1->obs              = substr($e50_obs, 0, 300);
    $pdf1->texto            = db_getsession("DB_login") . '  -  ' . date("d-m-Y", db_getsession("DB_datausu")) . '    ' . db_hora(db_getsession("DB_datausu"));
    $pdf1->telef            = $z01_telef;
    $pdf1->fax              = $z01_numero;
    $pdf1->codco            = $e60_codco . ' - ' . $clControleOrc->getDescricaoResumoCO();

    if ($clpagordem->numrows == 1 && isset($valor_ordem)) {

      if (isset($historico) && trim($historico) != "") {
        $pdf1->obs = "$historico";
      } else {
        $pdf1->obs = "$e50_obs";
      }
    } else {
      $pdf1->valor_ordem = "";
      $pdf1->obs     = "$e50_obs";
    }

    if (in_array($e54_tipoautorizacao, array('0', '1', '2', '3', '4'))) {

      $oAutoriza = $clemite_nota_liq->get_dados_licitacao($e54_tipoautorizacao, $e54_autori);

      $pdf1->processo         = $oAutoriza->processo;
      $pdf1->descr_tipocompra = $pc50_descr;
    }

    $pdf1->imprime();
  }
  }
}

if ($oConfiguracaoGed->utilizaGED()) {

  try {

    $sTipoDocumento = GerenciadorEletronicoDocumentoConfiguracao::ORDEM_PAGAMENTO;
    $oGerenciador = new GerenciadorEletronicoDocumento();
    $oGerenciador->setLocalizacaoOrigem("tmp/");
    $oGerenciador->setNomeArquivo("{$sTipoDocumento}_{$e50_codord}.pdf");

    $oStdDadosGED        = new stdClass();
    $oStdDadosGED->nome  = $sTipoDocumento;
    $oStdDadosGED->tipo  = "NUMERO";
    $oStdDadosGED->valor = $e50_codord;
    $pdf1->objpdf->Output("tmp/{$sTipoDocumento}_{$e50_codord}.pdf");
    $oGerenciador->moverArquivo(array($oStdDadosGED));
  } catch (Exception $eErro) {
    db_redireciona("db_erros.php?fechar=true&db_erro=" . $eErro->getMessage());
  }
} else {
  $pdf1->objpdf->Output();
}
