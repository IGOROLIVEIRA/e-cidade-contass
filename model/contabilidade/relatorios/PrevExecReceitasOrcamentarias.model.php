<?php
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
require_once ("model/contabilidade/relatorios/RelatoriosLegaisMultiplosFiltrosBase.model.php");
require_once ("fpdf151/PDFDocument.php");

/**
 * Class PrevExecReceitasOrcamentarias
 */
class PrevExecReceitasOrcamentarias extends RelatoriosLegaisMultiplosFiltrosBase  {

  /**
   * Código do Relatório cadastrado no e-cidade
   * @type integer
   */
  const CODIGO_RELATORIO = 173;

  /**
   * @type PDFDocument
   */
  private $oPdf;

  /**
   * @type stdClass[]
   */
  private $aReceitas = array();

  /**
   * @type stdClass[]
   */
  private $aReceitasIntra = array();

  /**
   * Linha Inicial referente a Receita
   * @type integer
   */
  const LINHA_RECEITA_INICIAL = 1;

  /**
   * Linha Inicial referente a Receita
   * @type integer
   */
  const LINHA_RECEITA_FINAL   = 370;

  /**
   * Linhas que são totalizadoras no relatório
   * @type array
   */
  private static $aLinhasTotalizadoras = array(63, 71, 72, 73, 89, 97, 98, 99);

  /**
   * @param integer $iAnoUsu ano de emissao do relatorio
   * @param integer $iCodigoRelatorio codigo do relatorio
   * @param integer $iCodigoPeriodo Codigo do periodo de emissao do relatorio
   */
  public function __construct($iAnoUsu, $iCodigoRelatorio, $iCodigoPeriodo) {

    parent::__construct($iAnoUsu, $iCodigoRelatorio, $iCodigoPeriodo);
    $this->setDataInicial($this->getDataInicialPeriodo());

  }

  /**
   * Retorna o Titulo do periodo de emissão do relatório
   * @return string
   */
  public function getTituloPeriodo() {

    $sNomeMesInicial = mb_strtoupper(db_mes($this->oPeriodo->o114_mesinicial));
    $sNomeMesFinal   = mb_strtoupper(db_mes($this->oPeriodo->o114_mesfinal));

    $sPeriodo = $this->oPeriodo->o114_descricao." - $this->iAnoUsu\n";
    $sPeriodo .= " {$sNomeMesInicial}-{$sNomeMesFinal}";
    return $sPeriodo;
  }

  /**
   * @return void
   */
  public function emitir() {
    $this->getDados();
    $this->processar();
    $this->processarExerciciosAnteriores();

    $this->oPdf = new PDFDocument("L");
    $this->oPdf->Open();
    $oPrefeitura = InstituicaoRepository::getInstituicaoPrefeitura();
    $this->oPdf->addHeaderDescription("");
    $this->oPdf->addHeaderDescription("MUNICÍPIO DE ".$oPrefeitura->getMunicipio() . " - " . $oPrefeitura->getUf());
    $this->oPdf->addHeaderDescription("PREVISÃO E EXECUÇÃO DAS RECEITAS ORÇAMENTÁRIA");
    $this->oPdf->addHeaderDescription("SIOPS");
    $this->oPdf->addHeaderDescription("");
    $this->oPdf->addHeaderDescription($this->getTituloPeriodo());


    $this->adicionarPagina();
    $this->imprimirCabecalhoReceita();
    $this->imprimirReceita(false);
    $this->oPdf->Cell($this->oPdf->getAvailWidth(), 2, '', "T", 1);

    $this->getNotaExplicativa($this->oPdf, $this->iCodigoPeriodo, $this->oPdf->getAvailWidth());
    $this->imprimirAssinaturas();

    $this->oPdf->showPDF('PREV_E_EXEC_DAS_REC_ORÇAMENTÁRIAS');
  }


  /**
   * @return void
   */
  public function emitirCsv() {

    $this->getDados();
    $this->processar();
    $this->processarExerciciosAnteriores();
    $aCodigos = $this->codigos();

    $fp = fopen("tmp/prevexecrecorc.csv","w");
    fputs($fp,"Códigos;Descrição das Contas de Receitas Orçamentárias;Previsão Inicial das Receitas Brutas (a);");
    fputs($fp,"Previsão Atualizada das Receitas Brutas (b);Receitas Realizadas Brutas (c);");
    fputs($fp,"Deduções das Receitas (d);Receitas Realizadas da base para cálculo do percentual de aplicação em ASPS (e) = (c-d);");
    fputs($fp,"Dedução Para Formação do FUNDEB (f);Total Geral das Receitas Líquidas Realizadas (g) = (c- d-f);\n");

    foreach ($this->aReceitas as $iK => $oStdLinha) {

      fputs($fp,"$aCodigos[$iK];$oStdLinha->descricao;$oStdLinha->previnirecbruta;$oStdLinha->prevatualrecbruta;");
      fputs($fp,"$oStdLinha->recrealizadabruta;$oStdLinha->deducrec;$oStdLinha->recrealizadabasecalcpercaplicasps;");
      fputs($fp,"$oStdLinha->deducformacfundeb;$oStdLinha->totgeralrecliqrealiza;\n");

    }

    echo "<html><body bgcolor='#cccccc'><center><a href='tmp/prevexecrecorc.csv'>Clique com botão direito para Salvar o arquivo <b>prevexecrecorc.csv</b></a></body></html>";
    unlink($fp);

  }

  /**
   * Carrega os dados para emissão do relatório
   * @return array
   */
  public function getDados() {

    parent::getDados();
    return $this->aLinhasConsistencia;

  }

  /**
   * Adiciona uma nova página no relatório
   * @return void
   */
  private function adicionarPagina() {

    $this->oPdf->SetFontSize(5);

    if ($this->oPdf->getCurrentPage() > 0) {
      $this->oPdf->cell($this->oPdf->getAvailWidth(), 4, "Continua na página " . ($this->oPdf->PageNo() + 1) . "/{nb}", 'T', 0, 'R');
    }
    $this->oPdf->addPage();
    if ($this->oPdf->getCurrentPage() != 1) {
      $this->oPdf->cell($this->oPdf->getAvailWidth(), 4, "Continuação da página " . ($this->oPdf->PageNo() - 1) . "/{nb}", 'B', 1, 'R');
    }

  }


  /**
   * Percorre as linhas do relatório ajustando as propriedades para imprimir posteriormente
   * @return void
   */
  private function processar() {

    foreach ($this->aLinhasConsistencia as $iOrdem => $oStdDadosLinha) {

      if (Check::between($iOrdem, self::LINHA_RECEITA_INICIAL, self::LINHA_RECEITA_FINAL)) {
        $this->adicionarReceita($oStdDadosLinha);
      }

    }

  }

  /**
   * Processa totalizadores do Superavit / Créditos Adicionais
   * @throws \Exception
   * @return void
   */
  private function processarExerciciosAnteriores() {

    $aWhereSuperavit = array(
      "o46_tiposup in (1008, 1003)",
      "o49_data between '{$this->iAnoUsu}-01-01' and '{$this->getDataFinal()->getDate()}'",
      "o46_instit in ({$this->getInstituicoes()})"
    );
    $oDaoOrcSuplem      = new cl_orcsuplem();
    $sSqlBuscaSuperavit = $oDaoOrcSuplem->sql_query_suplementacoes(null, "coalesce(sum(o47_valor), 0) as total", null, implode(" and ", $aWhereSuperavit));
    $rsBuscaSuperavit   = db_query($sSqlBuscaSuperavit);
    if (!$rsBuscaSuperavit) {
      throw new Exception("Ocorreu um erro na busca dos valores de suplementação da coluna SUPERAVIT.");
    }

    $aWhereCreditos = array(
      "o46_tiposup in (1012, 1013)",
      "o49_data between '{$this->getDataInicial()->getDate()}' and '{$this->getDataFinal()->getDate()}'",
      "o46_instit in ({$this->getInstituicoes()})"
    );
    $sSqlBuscaCreditos = $oDaoOrcSuplem->sql_query_suplementacoes(null, "coalesce(sum(o47_valor), 0) as total", null, implode(" and ", $aWhereCreditos));
    $rsBuscaCreditos   = db_query($sSqlBuscaCreditos);
    if (!$rsBuscaCreditos) {
      throw new Exception("Ocorreu um erro na busca dos valores de suplementação da coluna CRÉDITOS ADICIONAIS.");
    }

    $nValorSuperavit = db_utils::fieldsMemory($rsBuscaSuperavit, 0)->total;
    $nValorCreditos  = db_utils::fieldsMemory($rsBuscaCreditos, 0)->total;
  }

  /**
   * @param stdClass $oStdDadosLinha
   * @param boolean $lReceitaIntraOrcamentaria
   * @return void
   */
  private function adicionarReceita(stdClass $oStdDadosLinha) {

    $oStdRetorno                        = new stdClass();
    $oStdRetorno->ordem                 = $oStdDadosLinha->oLinhaRelatorio->getOrdem();
    $oStdRetorno->totalizar             = $oStdDadosLinha->totalizar;
    $oStdRetorno->descricao             = $oStdDadosLinha->descricao;
    $oStdRetorno->nivel                 = $oStdDadosLinha->nivel;
    $oStdRetorno->previnirecbruta       = trim(db_formatar($oStdDadosLinha->previnirecbruta, 'f'));
    $oStdRetorno->prevatualrecbruta     = trim(db_formatar($oStdDadosLinha->prevatualrecbruta, 'f'));
    $oStdRetorno->recrealizadabruta     = trim(db_formatar($oStdDadosLinha->recrealizadabruta, 'f'));
    $oStdRetorno->deducrec              = trim(db_formatar($oStdDadosLinha->deducrec, 'f'));
    $oStdRetorno->recrealizadabasecalcpercaplicasps = trim(db_formatar($oStdDadosLinha->recrealizadabasecalcpercaplicasps, 'f'));
    $oStdRetorno->deducformacfundeb     = trim(db_formatar($oStdDadosLinha->deducformacfundeb, 'f'));
    $oStdRetorno->totgeralrecliqrealiza = trim(db_formatar($oStdDadosLinha->totgeralrecliqrealiza, 'f'));
    $oStdRetorno->receitasorcadas = trim(db_formatar($oStdDadosLinha->receitasorcadas, 'f'));

    $this->aReceitas[$oStdRetorno->ordem] = $oStdRetorno;

  }

  /**
   * Imprime o cabeçalho das receitas (I)
   * @param boolean $lReceitaIntra
   * @return void
   */
  private function imprimirCabecalhoReceita($lReceitaIntra = false) {

    $aLarguraColunas = array(20,74.5,24,24,24,24,32,25.5,30,48,135.5);
    $aAlturaColunas = array(5.34,4,5.34,5.34,4,5.34,5.34);

    if((int)$this->iCodigoPeriodo === 130) {
      $aLarguraColunas = array(20,74.5,22,22,22,16,27,22,26,44,113);
      $aAlturaColunas = array(5.34,4,5.34,5.34,3.2,5.34,4);
    }

    $this->oPdf->setfont('arial','b',7);
    $this->oPdf->Cell($aLarguraColunas[0], 24, "Código", "TB", 0, PDFDocument::ALIGN_CENTER);
    $nPosicaoX = $this->oPdf->GetX();
    $nPosicaoY = $this->oPdf->GetY();
    $this->oPdf->MultiCell($aLarguraColunas[1], 24, "Descrição das Contas de Receitas Orçamentárias", 1, PDFDocument::ALIGN_CENTER);

    $this->oPdf->SetXY($nPosicaoX+$aLarguraColunas[1],$nPosicaoY);
    $this->oPdf->Cell($aLarguraColunas[9], 8, "Previsão das Receitas", 1, 0, PDFDocument::ALIGN_CENTER);
    $this->oPdf->Cell($aLarguraColunas[10], 8, "Execução das Receitas Orçamentárias", 'TB', 0, PDFDocument::ALIGN_CENTER);

    $this->oPdf->SetXY($nPosicaoX+74.5,$nPosicaoY+8);
    $nPosicaoX = $this->oPdf->GetX();
    $nPosicaoY = $this->oPdf->GetY();

    $this->oPdf->MultiCell($aLarguraColunas[2], $aAlturaColunas[0], "Previsão Inicial das Receitas Brutas (a)", 1, PDFDocument::ALIGN_CENTER);
    $this->oPdf->SetXY($nPosicaoX+$aLarguraColunas[2],$nPosicaoY);
    $nPosicaoX = $this->oPdf->GetX();
    $nPosicaoY = $this->oPdf->GetY();
    $this->oPdf->MultiCell($aLarguraColunas[3], $aAlturaColunas[1], "Previsão Atualizada das Receitas Brutas (b)", 1, PDFDocument::ALIGN_CENTER);
    $this->oPdf->SetXY($nPosicaoX+$aLarguraColunas[3],$nPosicaoY);
    $nPosicaoX = $this->oPdf->GetX();
    $nPosicaoY = $this->oPdf->GetY();
    $this->oPdf->MultiCell($aLarguraColunas[4], $aAlturaColunas[2], "Receitas Realizadas Brutas (c)", 1, PDFDocument::ALIGN_CENTER);
    $this->oPdf->SetXY($nPosicaoX+$aLarguraColunas[4],$nPosicaoY);
    $nPosicaoX = $this->oPdf->GetX();
    $nPosicaoY = $this->oPdf->GetY();
    $this->oPdf->MultiCell($aLarguraColunas[5], $aAlturaColunas[3], "Deduções\ndas\nReceitas (d)", 1, PDFDocument::ALIGN_CENTER);
    $this->oPdf->SetXY($nPosicaoX+$aLarguraColunas[5],$nPosicaoY);
    $nPosicaoX = $this->oPdf->GetX();
    $nPosicaoY = $this->oPdf->GetY();
    $this->oPdf->MultiCell($aLarguraColunas[6], $aAlturaColunas[4], "Receitas Realizadas da base para cálculo do percentual de aplicação em ASPS (e) = (c-d)", 1, PDFDocument::ALIGN_CENTER);
    $this->oPdf->SetXY($nPosicaoX+$aLarguraColunas[6],$nPosicaoY);
    $nPosicaoX = $this->oPdf->GetX();
    $nPosicaoY = $this->oPdf->GetY();
    $this->oPdf->MultiCell($aLarguraColunas[7], $aAlturaColunas[5], "Dedução Para Formação do FUNDEB (f)", 1, PDFDocument::ALIGN_CENTER);
    $this->oPdf->SetXY($nPosicaoX+$aLarguraColunas[7],$nPosicaoY);
    $nPosicaoX = $this->oPdf->GetX();
    $nPosicaoY = $this->oPdf->GetY();
    $this->oPdf->MultiCell($aLarguraColunas[8], $aAlturaColunas[6], "Total Geral das Receitas Líquidas Realizadas (g) = (c- d-f)", 'TB', PDFDocument::ALIGN_CENTER);

    if((int)$this->iCodigoPeriodo === 130) {
      $this->oPdf->SetXY($nPosicaoX+26,$nPosicaoY-8);
      $this->oPdf->MultiCell(24.5, 4, "\n\nReceitas\nOrçadas\n\n\n", 'TBL', PDFDocument::ALIGN_CENTER);
    }

    $this->oPdf->ln(0);

  }

  /**
   * Imprime as linhas de receita
   * @param bool $lReceitaIntra
   * @return void
   */
  private function imprimirReceita($lReceitaIntra = false) {

    $aReceitas = $lReceitaIntra ? $this->aReceitasIntra : $this->aReceitas;
    $aCodigos = $this->codigos();

    foreach ($aReceitas as $iK => $oStdLinha) {

      if ($this->oPdf->getAvailHeight() <= 10) {

        $this->adicionarPagina();
        $this->imprimirCabecalhoReceita($lReceitaIntra);

      }

      $this->oPdf->setBold(false);
      if ($oStdLinha->totalizar) {
        $this->oPdf->setBold(true);
      }

      $sBorda     = '';
      $sDescricao = $this->limitarTexto($oStdLinha->descricao,55);
      $this->oPdf->setAutoNewLineMulticell(false);

      $iHeight = $this->oPdf->getMultiCellHeight(100, 4, $sDescricao);

      $aLarguraColunas = array(20,74.5,24,24,24,24,32,25.5,30,48,135.5);
      if((int)$this->iCodigoPeriodo === 130) {
        $aLarguraColunas = array(20,74.5,22,22,22,16,27,22,26,44,113);
      }

      // COLUNA CÓDIGO
      $this->oPdf->cell($aLarguraColunas[0],$iHeight, $aCodigos[$iK],'R',0,"L");
      $this->oPdf->MultiCell($aLarguraColunas[1],4, $sDescricao, "R{$sBorda}", PDFDocument::ALIGN_LEFT);
      $this->oPdf->Cell($aLarguraColunas[2], $iHeight, $oStdLinha->previnirecbruta   ,   "LR{$sBorda}", 0, $this->getAlinhamento($oStdLinha->previnirecbruta));
      $this->oPdf->Cell($aLarguraColunas[3], $iHeight, $oStdLinha->prevatualrecbruta,   "LR{$sBorda}", 0, $this->getAlinhamento($oStdLinha->prevatualrecbruta));
      $this->oPdf->Cell($aLarguraColunas[4], $iHeight, $oStdLinha->recrealizadabruta,   "LR{$sBorda}", 0, $this->getAlinhamento($oStdLinha->recrealizadabruta));
      $this->oPdf->Cell($aLarguraColunas[5], $iHeight, $oStdLinha->deducrec,  "LR{$sBorda}", 0, $this->getAlinhamento($oStdLinha->deducrec));
      $this->oPdf->Cell($aLarguraColunas[6], $iHeight, $oStdLinha->recrealizadabasecalcpercaplicasps,  "LR{$sBorda}", 0, $this->getAlinhamento($oStdLinha->recrealizadabasecalcpercaplicasps));
      $this->oPdf->Cell($aLarguraColunas[7], $iHeight, $oStdLinha->deducformacfundeb, "LR{$sBorda}", 0, $this->getAlinhamento($oStdLinha->deducformacfundeb));
      if((int)$this->iCodigoPeriodo === 130) {
        $this->oPdf->Cell($aLarguraColunas[8], $iHeight, $oStdLinha->totgeralrecliqrealiza,"LR{$sBorda}",  0, $this->getAlinhamento($oStdLinha->totgeralrecliqrealiza));
        $this->oPdf->Cell($aLarguraColunas[8], $iHeight, $oStdLinha->receitasorcadas, "{$sBorda}", 1, $this->getAlinhamento($oStdLinha->receitasorcadas));
      }else{
        $this->oPdf->Cell($aLarguraColunas[8], $iHeight, $oStdLinha->totgeralrecliqrealiza,"L{$sBorda}",  1, $this->getAlinhamento($oStdLinha->totgeralrecliqrealiza));

      }
      $this->oPdf->setBold(false);
      $this->oPdf->setAutoNewLineMulticell(true);

    }

  }

  /**
   * Imprime as assinaturas padrão
   * @return void
   */
  private function imprimirAssinaturas() {

    $this->oPdf->ln(10);
    $oAssinatura = new cl_assinatura();
    assinaturas($this->oPdf, $oAssinatura,'LRF');
  }

  /**
   * Retorna onde deve ser alinhado o campo
   * @param $sValor
   * @return string
   */
  private function getAlinhamento($sValor) {
    return $sValor == '-' ? PDFDocument::ALIGN_CENTER : PDFDocument::ALIGN_RIGHT;
  }

  /**
   * Retorna as bordas top e botton para a linha, caso seja preciso
   * @param integer $iLinha
   * @return string
   */
  private function getBordaLinha($iLinha) {
    return in_array($iLinha,  array(63, 71, 72, 73, 89, 97, 98, 99)) ?  "TB" : "";
  }


  /*
   * Retorna uma descrição dentro do limite de caracteres informado
   */
  private function limitarTexto($sTexto, $iLimite){

    if( strlen($sTexto) > (int)$iLimite ){
      $sTextoLimitado = mb_substr($sTexto, 0, $iLimite-3);
      return $this->limitarTexto($sTextoLimitado, $iLimite)."...";
    }else if(strlen(preg_replace('![^A-Z]+!', '', $sTexto)) >= 35){
      return trim(mb_substr($sTexto, 0, 45))."...";
    }
    return $sTexto;

  }

  private function codigos(){
    return array('1.0.00.00.00.00',
      '1.0.00.00.00.00','1.1.00.00.00.00','1.1.10.00.00.00','1.1.12.00.00.00','1.1.12.01.00.00','1.1.12.02.00.00',
      '1.1.12.04.00.00','1.1.12.04.31.00','1.1.12.04.34.00','1.1.12.08.00.00','1.1.13.00.00.00','1.1.13.05.00.00',
      '1.1.13.05.01.00','1.1.13.05.02.00','1.1.13.06.00.00','1.1.20.00.00.00','1.1.21.00.00.00','1.1.21.17.00.00',
      '1.1.21.20.00.00','1.1.21.50.00.00','1.1.21.99.00.00','1.1.22.00.00.00','1.1.30.00.00.00','1.2.00.00.00.00',
      '1.2.10.00.00.00','1.2.10.07.00.00','1.2.10.29.00.00','1.2.10.29.01.00','1.2.10.29.02.00','1.2.10.29.03.00',
      '1.2.10.29.04.00','1.2.10.29.05.00','1.2.10.29.06.00','1.2.10.29.07.00','1.2.10.29.08.00','1.2.10.29.09.00',
      '1.2.10.29.10.00','1.2.10.29.11.00','1.2.10.29.12.00','1.2.10.29.13.00','1.2.10.29.15.00','1.2.10.29.16.00',
      '1.2.10.29.17.00','1.2.10.29.18.00','1.2.10.29.19.00','1.2.10.29.99.00','1.2.10.99.00.00','1.3.00.00.00.00',
      '1.3.10.00.00.00','1.3.20.00.00.00','1.3.21.00.00.00','1.3.25.00.00.00','1.3.25.01.00.00','1.3.25.01.01.00',
      '1.3.25.01.01.01','1.3.25.01.01.02','1.3.25.01.01.99','1.3.25.01.02.00','1.3.25.01.03.00','1.3.25.01.06.00',
      '1.3.25.01.11.00','1.3.25.01.12.00','1.3.25.01.99.00','1.3.25.02.00.00','1.3.29.00.00.00','1.3.40.00.00.00',
      '1.3.90.00.00.00','1.4.00.00.00.00','1.5.00.00.00.00','1.6.00.00.00.00','1.6.00.05.00.00','1.6.00.05.01.00',
      '1.6.00.05.02.00','1.6.00.05.03.00','1.6.00.05.05.00','1.6.00.05.09.00','1.6.00.05.09.02','1.6.00.05.09.03',
      '1.6.00.05.09.04','1.6.00.05.09.05','1.6.00.05.09.99','1.6.00.05.10.00','1.6.00.05.99.00','1.6.00.99.00.00',
      '1.7.00.00.00.00','1.7.20.00.00.00','1.7.21.00.00.00','1.7.21.01.00.00','1.7.21.01.02.00','1.7.21.01.03.00',
      '1.7.21.01.04.00','1.7.21.01.05.00','1.7.21.01.13.00','1.7.21.01.32.00','1.7.21.22.00.00','1.7.21.22.11.00',
      '1.7.21.22.20.00','1.7.21.22.30.00','1.7.21.22.40.00','1.7.21.22.50.00','1.7.21.22.70.00','1.7.21.22.90.00',
      '1.7.21.33.00.00','1.7.21.33.11.00','1.7.21.33.12.00','1.7.21.33.13.00','1.7.21.33.14.00','1.7.21.33.15.00',
      '1.7.21.33.99.00','1.7.21.34.00.00','1.7.21.35.00.00','1.7.21.35.01.00','1.7.21.35.02.00','1.7.21.35.03.00',
      '1.7.21.35.04.00','1.7.21.35.99.00','1.7.21.36.00.00','1.7.21.37.00.00','1.7.21.38.00.00','1.7.21.99.00.00',
      '1.7.22.00.00.00','1.7.22.01.00.00','1.7.22.01.01.00','1.7.22.01.02.00','1.7.22.01.04.00','1.7.22.01.13.00',
      '1.7.22.01.33.00','1.7.22.01.99.00','1.7.22.22.00.00','1.7.22.22.11.00','1.7.22.22.20.00','1.7.22.22.30.00',
      '1.7.22.22.90.00','1.7.22.33.00.00','1.7.22.35.00.00','1.7.22.36.00.00','1.7.22.37.00.00','1.7.22.99.00.00',
      '1.7.23.00.00.00','1.7.23.01.00.00','1.7.23.02.00.00','1.7.23.03.00.00','1.7.23.04.00.00','1.7.23.06.00.00',
      '1.7.23.07.00.00','1.7.23.08.00.00','1.7.23.37.00.00','1.7.23.99.00.00','1.7.24.00.00.00','1.7.24.01.00.00',
      '1.7.24.02.00.00','1.7.24.99.00.00','1.7.30.00.00.00','1.7.30.03.00.00','1.7.30.10.00.00','1.7.30.99.00.00',
      '1.7.40.00.00.00','1.7.40.03.00.00','1.7.40.10.00.00','1.7.40.20.00.00','1.7.40.99.00.00','1.7.50.00.00.00',
      '1.7.50.03.00.00','1.7.50.10.00.00','1.7.50.99.00.00','1.7.60.00.00.00','1.7.61.00.00.00','1.7.61.01.00.00',
      '1.7.61.02.00.00','1.7.61.05.00.00','1.7.61.05.10.00','1.7.61.05.99.00','1.7.61.99.00.00','1.7.62.00.00.00',
      '1.7.62.01.00.00','1.7.62.02.00.00','1.7.62.99.00.00','1.7.63.00.00.00','1.7.63.01.00.00','1.7.63.02.00.00',
      '1.7.63.99.00.00','1.7.64.00.00.00','1.7.65.00.00.00','1.7.90.00.00.00','1.9.00.00.00.00','1.9.10.00.00.00',
      '1.9.11.00.00.00','1.9.11.08.00.00','1.9.11.35.00.00','1.9.11.36.00.00','1.9.11.38.00.00','1.9.11.39.00.00',
      '1.9.11.40.00.00','1.9.11.44.00.00','1.9.11.99.00.00','1.9.12.00.00.00','1.9.12.29.00.00','1.9.12.30.00.00',
      '1.9.12.99.00.00','1.9.13.00.00.00','1.9.13.08.00.00','1.9.13.11.00.00','1.9.13.12.00.00','1.9.13.13.00.00',
      '1.9.13.25.00.00','1.9.13.35.00.00','1.9.13.99.00.00','1.9.14.00.00.00','1.9.14.04.00.00','1.9.14.99.00.00',
      '1.9.15.00.00.00','1.9.18.00.00.00','1.9.19.00.00.00','1.9.20.00.00.00','1.9.21.00.00.00','1.9.22.00.00.00',
      '1.9.22.00.00.20','1.9.22.00.00.99','1.9.30.00.00.00','1.9.31.00.00.00','1.9.31.04.00.00','1.9.31.11.00.00',
      '1.9.31.12.00.00','1.9.31.13.00.00','1.9.31.21.00.00','1.9.31.35.00.00','1.9.31.36.00.00','1.9.31.99.00.00',
      '1.9.32.00.00.00','1.9.32.01.00.00','1.9.32.40.00.00','1.9.32.99.00.00','1.9.40.00.00.00','1.9.50.00.00.00',
      '1.9.90.00.00.00','2.0.00.00.00.00','2.1.00.00.00.00','2.1.10.00.00.00','2.1.14.00.00.00','2.1.14.01.00.00',
      '2.1.14.02.00.00','2.1.14.03.00.00','2.1.14.99.00.00','2.1.19.00.00.00','2.1.20.00.00.00','2.1.23.00.00.00',
      '2.1.23.01.00.00','2.1.23.02.00.00','2.1.23.03.00.00','2.1.23.99.00.00','2.1.29.00.00.00','2.2.00.00.00.00',
      '2.3.00.00.00.00','2.4.00.00.00.00','2.4.20.00.00.00','2.4.21.00.00.00','2.4.21.01.00.00','2.4.21.01.01.00',
      '2.4.21.01.01.01','2.4.21.01.01.02','2.4.21.01.01.03','2.4.21.01.01.04','2.4.21.01.01.05','2.4.21.01.99.00',
      '2.4.21.02.00.00','2.4.21.03.00.00','2.4.21.37.00.00','2.4.21.38.00.00','2.4.21.99.00.00','2.4.22.00.00.00',
      '2.4.22.01.00.00','2.4.22.02.00.00','2.4.22.03.00.00','2.4.22.37.00.00','2.4.22.99.00.00','2.4.23.00.00.00',
      '2.4.23.01.00.00','2.4.23.02.00.00','2.4.23.03.00.00','2.4.23.37.00.00','2.4.23.99.00.00','2.4.30.00.00.00',
      '2.4.30.01.00.00','2.4.30.02.00.00','2.4.30.03.00.00','2.4.30.99.00.00','2.4.40.00.00.00','2.4.40.01.00.00',
      '2.4.40.02.00.00','2.4.40.03.00.00','2.4.40.99.00.00','2.4.50.00.00.00','2.4.50.01.00.00','2.4.50.02.00.00',
      '2.4.50.03.00.00','2.4.50.99.00.00','2.4.60.00.00.00','2.4.70.00.00.00','2.4.71.00.00.00','2.4.71.01.00.00',
      '2.4.71.02.00.00','2.4.71.03.00.00','2.4.71.03.10.00','2.4.71.03.99.00','2.4.71.99.00.00','2.4.72.00.00.00',
      '2.4.72.01.00.00','2.4.72.02.00.00','2.4.72.03.00.00','2.4.72.99.00.00','2.4.73.00.00.00','2.4.73.01.00.00',
      '2.4.73.02.00.00','2.4.73.03.00.00','2.4.73.99.00.00','2.4.74.00.00.00','2.4.75.00.00.00','2.5.00.00.00.00',
      '7.0.00.00.00.00','7.1.00.00.00.00','7.1.10.00.00.00','7.1.12.00.00.00','7.1.12.01.00.00','7.1.12.04.00.00',
      '7.1.13.00.00.00','7.1.13.06.00.00','7.1.20.00.00.00','7.1.21.00.00.00','7.1.21.17.00.00','7.1.21.20.00.00',
      '7.1.21.22.00.00','7.1.21.29.00.00','7.2.00.00.00.00','7.2.10.29.00.00','7.2.10.29.01.00','7.2.10.29.02.00',
      '7.2.10.29.03.00','7.2.10.29.04.00','7.2.10.29.05.00','7.2.10.29.06.00','7.2.10.29.07.00','7.2.10.29.08.00',
      '7.2.10.29.09.00','7.2.10.29.10.00','7.2.10.29.11.00','7.2.10.29.12.00','7.2.10.29.13.00','7.2.10.29.15.00',
      '7.2.10.29.16.00','7.2.10.29.17.00','7.2.10.29.18.00','7.2.10.29.19.00','7.2.10.29.99.00','7.2.10.30.00.00',
      '7.2.10.99.00.00','7.3.00.00.00.00','7.5.00.00.00.00','7.6.00.00.00.00','7.6.00.05.00.00','7.6.00.05.01.00',
      '7.6.00.99.00.00','7.9.00.00.00.00','7.9.10.00.00.00','7.9.20.00.00.00','7.9.30.00.00.00','7.9.31.00.00.00',
      '7.9.31.99.00.00','7.9.90.00.00.00','8.0.00.00.00.00');
  }

}