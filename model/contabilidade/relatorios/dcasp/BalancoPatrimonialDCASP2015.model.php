<?php
/**
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

class BalancoPatrimonialDCASP2015 extends RelatoriosLegaisBase  {

  /**
   * Código do relatório no cadastrado no sistema
   * @var integer
   */
  const CODIGO_RELATORIO                  = 151;

  /**
   * Constantes que identificam as linhas iniciais e finais de cada quadro.
   */
  const QUADRO_PRINCIPAL_INICIAL          = 1;
  const QUADRO_PRINCIPAL_INICIO_PASSIVOS  = 20;
  const QUADRO_PRINCIPAL_FINAL            = 48;
  const QUADRO_ATIVOS_PASSIVOS_INICIAL    = 49;
  const QUADRO_ATIVOS_PASSIVOS_FINAL      = 57;
  const QUADRO_CONTAS_COMPENSACAO_INICIAL = 58;
  const QUADRO_CONTAS_COMPENSACAO_FINAL   = 69;

  /**
   * Constantes que identificam cada quadro.
   */
  const QUADRO_PRINCIPAL          = 1;
  const QUADRO_ATIVOS_PASSIVOS    = 2;
  const QUADRO_CONTAS_COMPENSACAO = 3;
  const QUADRO_SUPERAVIT          = 4;

  /**
   * @var PDFDocument
   */
  private $oPdf;

  /**
   * Linhas do relatório referente ao quadro principal.
   * @var stdClass[]
   */
  private $aQuadroPrincipal = array();

  /**
   * Linhas do relatório referente ao quadro de ativos e passivos.
   * @var stdClass[]
   */
  private $aQuadroAtivosPassivos = array();

  /**
   * Linhas do relatório referente ao quadro de contas de compensacao.
   * @var stdClass[]
   */
  private $aQuadroContasCompensacao = array();

  /**
   * Linhas do relatório referente ao quadro do Superávit/Déficit Financeiro.
   * @var stdClass[]
   */
  private $aQuadroSuperavitDeficit  = array();

  /**
   * Identifica quais quadros devem ser exibidos.
   * @var array
   */
  private $aRelatoriosExibir = array();

  /**
   * Identifica quais linhas são totalizadoras.
   * @var array
   */
  private $aLinhasTotalizadoras = array(7, 18, 19, 28, 37, 47, 48, 52, 56, 57, 63, 69);

  /**
   * Nome da instituição a ser exibida no relatório.
   * @var string
   */
  private $sDescricaoInstituicao;

  /**
   * Nome do período a ser exibido no relatório.
   * @var string
   */
  private $sDescricaoPeriodo;

  /**
   * Determina se deve buscar e exibir as informações do exercício anterior.
   * @var boolean
   */
  private $lExibirExercicioAnterior;

  /**
   * @param integer $iAnoUsu          Ano da emissão do relatório.
   * @param integer $iCodigoRelatorio Código do relatório cadastrado no sistema.
   * @param integer $iCodigoPeriodo   Código do período de emissão do relatório.
   */
  public function __construct($iAnoUsu, $iCodigoRelatorio, $iCodigoPeriodo) {

    parent::__construct($iAnoUsu, $iCodigoRelatorio, $iCodigoPeriodo);

    $this->oPdf     = new PDFDocument();
    $this->iAltura  = 4;
    $this->iLargura = $this->oPdf->getAvailWidth() - 10;
  }

  /**
   * Adiciona uma nova página, reinserindo o cabeçalho do relatório.
   * @param string $sNomeQuadro Nome do quadro do relatório.
   * @param string $sNomeColuna Nome da columa de descrição do cabeçalho do quadro.
   */
  private function adicionarPagina($sNomeQuadro, $sNomeColuna) {

    $this->oPdf->clearHeaderDescription();
    $this->oPdf->addHeaderDescription($this->sDescricaoInstituicao);
    $this->oPdf->addHeaderDescription("BALANÇO PATRIMONIAL");
    $this->oPdf->addHeaderDescription($sNomeQuadro);
    $this->oPdf->addHeaderDescription("EXERCÍCIO : {$this->iAnoUsu}");
    $this->oPdf->addHeaderDescription("PERÍODO : {$this->sDescricaoPeriodo}");
    $this->oPdf->AddPage();
    if ($sNomeColuna !== null) {
      $this->escreverCabecalhoQuadro($sNomeColuna);
    }
  }

  /**
   * Verifica se a linha é uma das totalizadoras que deve ter bordas.
   * @param integer $iLinha Número da linha.
   *
   * @return bool
   */
  private function verificaTotalizadorFinal($iLinha) {
    return in_array($iLinha, $this->aLinhasTotalizadoras);
  }

  /**
   * Escreve uma linha do relatório.
   * @param stdClass $oLinha Linha a ser escrita.
   */
  private function escreverLinha(stdClass $oLinha) {

    $nPorcemtagemDescricao = 0.6;

    if ($oLinha->totalizar) {
      $this->oPdf->setBold(true);
    }

    $sBorda = "";
    if ($oLinha->totalizadorFinal) {
      $sBorda = "TB";
    }

    $sExercioAnterior = "-";
    if ($this->lExibirExercicioAnterior) {
      $sExercioAnterior = db_formatar($oLinha->vlrexanter, 'f');
    }

    $sDescricao = str_repeat(' ', $oLinha->nivel * 2) . $oLinha->descricao;

    if (isset($oLinha->codigo)) {
      $this->oPdf->Cell($this->iLargura * 0.05, $this->iAltura, $oLinha->codigo, $sBorda . 'R', 0, 'C');
      $nPorcemtagemDescricao -= 0.05;
    }

    $this->oPdf->Cell($this->iLargura * $nPorcemtagemDescricao, $this->iAltura, $sDescricao, $sBorda, 0, 'L');
    $this->oPdf->Cell($this->iLargura * 0.20, $this->iAltura, db_formatar($oLinha->vlrexatual, 'f'), 'L' . $sBorda, 0, 'R');
    $this->oPdf->Cell($this->iLargura * 0.20, $this->iAltura, $sExercioAnterior, 'L' . $sBorda, 1, 'R');

    if ($oLinha->totalizadorFinal && !$oLinha->ultimaLinhaQuadro) {
      $this->oPdf->Cell($this->iLargura, $this->iAltura / 2, "", 'B', 1);
    }

    $this->oPdf->setBold(false);
  }

  /**
   * Escreve as assinaturas do quadro do relatório.
   *
   * @param string $sNomeQuadro Nome do quadro.
   * @param string $sNomeColuna Nome da coluna de descrição do quadro.
   */
  private function escreveAssinatura($sNomeQuadro, $sNomeColuna) {

    if ($this->oPdf->getAvailHeight() < 35) {
      $this->adicionarPagina($sNomeQuadro, $sNomeColuna);
    }
    $oAssinatura = new cl_assinatura();
    $this->oPdf->ln(18);
    assinaturas($this->oPdf, $oAssinatura, 'BG', false, false);
  }

  /**
   * Procura a descrição do período de acordo com o atributo iCodigoPeriodo
   * @return string
   */
  private function getDescricaoPeriodo() {

    $sNomePeriodo = "";
    $aPeriodos    = $this->getPeriodos();
    foreach ($aPeriodos as $oPeriodo) {

      if ($oPeriodo->o114_sequencial == $this->iCodigoPeriodo) {

        $sNomePeriodo = $oPeriodo->o114_descricao;
        break;
      }
    }
    return $sNomePeriodo;
  }

  /**
   * Popula os atributos que serão utilizados no cabeçalho para não precisar processa-los a cada página.
   */
  private function preparaCabecalhos() {

    $aListaInstituicoes = $this->getInstituicoes(true);

    if (count($aListaInstituicoes) > 1) {

      $oPrefeitura                 = InstituicaoRepository::getInstituicaoPrefeitura();
      $this->sDescricaoInstituicao = "INSTITUIÇÃO : {$oPrefeitura->getDescricao()} - CONSOLIDAÇÃO";
    } else {

      $oInstituicao                = current($aListaInstituicoes);
      $this->sDescricaoInstituicao = "INSTITUIÇÃO : {$oInstituicao->getDescricao()}";
    }

    $this->sDescricaoPeriodo = $this->getDescricaoPeriodo();
  }

  /**
   * Informa se um quadro do relatório deve ser exibido, de acordo com seu código.
   *
   * @param integer $iCodigo Código do quadro de acordo com as constantes desta classe.
   *
   * @return bool
   */
  private function exibirQuadroRelatorio($iCodigo) {
    return in_array($iCodigo, $this->aRelatoriosExibir);
  }

  /**
   * Prepara a linha para ser utilizada no relatório.
   * @param integer $iLinha            Número da linha.
   * @param integer $iLinhaFinalQuadro Número da linha final do quadro.
   *
   * @return stdClass
   */
  private function processarLinha($iLinha, $iLinhaFinalQuadro) {

    $oLinha                    = $this->aDados[$iLinha];
    $oLinha->ultimaLinhaQuadro = $iLinha == $iLinhaFinalQuadro;
    $oLinha->totalizadorFinal  = $this->verificaTotalizadorFinal($iLinha);
    return $oLinha;
  }

  /**
   * Popula os arrays de cada quadro caso deva exibi-los.
   */
  private function processarQuadros() {

    if ($this->exibirQuadroRelatorio(self::QUADRO_PRINCIPAL)) {

      for ($i = self::QUADRO_PRINCIPAL_INICIAL; $i <= self::QUADRO_PRINCIPAL_FINAL; $i++) {
        $this->aQuadroPrincipal[] = $this->processarLinha($i, self::QUADRO_PRINCIPAL_FINAL);
      }
    }

    if ($this->exibirQuadroRelatorio(self::QUADRO_ATIVOS_PASSIVOS)) {

      for ($i = self::QUADRO_ATIVOS_PASSIVOS_INICIAL; $i <= self::QUADRO_ATIVOS_PASSIVOS_FINAL; $i++) {
        $this->aQuadroAtivosPassivos[] = $this->processarLinha($i, self::QUADRO_ATIVOS_PASSIVOS_FINAL);;
      }
    }

    if ($this->exibirQuadroRelatorio(self::QUADRO_CONTAS_COMPENSACAO)) {

      for ($i = self::QUADRO_CONTAS_COMPENSACAO_INICIAL; $i <= self::QUADRO_CONTAS_COMPENSACAO_FINAL; $i++) {
        $this->aQuadroContasCompensacao[] = $this->processarLinha($i, self::QUADRO_CONTAS_COMPENSACAO_FINAL);;
      }
    }
  }

  /**
   * Realizar as configurações iniciais do pdf.
   */
  private function configurarPdf() {

    $this->oPdf->SetLeftMargin(10);
    $this->oPdf->Open();
    $this->oPdf->AliasNbPages();
    $this->oPdf->SetAutoPageBreak(true, 10);
    $this->oPdf->SetFillcolor(235);
    $this->oPdf->SetFont('arial', '', 6);
  }

  /**
   * Escreve o cabeçalho do quadro.
   * @param string $sNomeColuna Nome da coluna de descrição do quadro.
   */
  private function escreverCabecalhoQuadro($sNomeColuna) {

    $this->oPdf->setBold(true);
    $this->oPdf->Cell($this->iLargura * 0.60, $this->iAltura, $sNomeColuna, 'TB', 0, 'C');
    $this->oPdf->Cell($this->iLargura * 0.20, $this->iAltura, "Exercício Atual", 'LTB', 0, 'C');
    $this->oPdf->Cell($this->iLargura * 0.20, $this->iAltura, "Exercício Anterior", 'LTB', 1, 'C');
    $this->oPdf->setBold(false);
  }

  /**
   * Emite um quadro do relatório.
   *
   * @param string     $sNomeQuadro  Nome do quadro,
   * @param string     $sNomeColuna  Nome da coluna descrição,
   * @param stdClass[] $aDadosQuadro Linhas do quadro.
   */
  private function emitirQuadro($sNomeQuadro, $sNomeColuna, $aDadosQuadro) {

    /**
     * Se o quadro não foi processado
     */
    if (!$aDadosQuadro) return;

    $this->adicionarPagina($sNomeQuadro, $sNomeColuna);

    foreach ($aDadosQuadro as $oLinha) {

      if ($oLinha->ordem == self::QUADRO_PRINCIPAL_INICIO_PASSIVOS) {
        $sNomeColuna = "PASSIVO E PATRIMÔNIO LÍQUIDO";
        if ($this->oPdf->getAvailHeight() >= 18) {
          $this->escreverCabecalhoQuadro($sNomeColuna);
        }
      }

      if ($this->oPdf->getAvailHeight() < 18) {
        $this->adicionarPagina($sNomeQuadro, $sNomeColuna);
      }
      $this->escreverLinha($oLinha);
    }
    $this->escreverNotaExplicativa($sNomeQuadro, null);
    $this->escreveAssinatura($sNomeQuadro, null);
  }

  /**
   * Seta os quadros que devem ser exibidos de acordo com as constantes da classe.
   * @param array $aQuadrosExibir Array de constantes identificando quais quadros do relatório devem ser exibidos.
   */
  public function setExibirQuadros($aQuadrosExibir) {
    $this->aRelatoriosExibir = $aQuadrosExibir;
  }

  /**
   * Escreve a nota explicativa para o quadro.
   * @param string $sNomeQuadro Nome do quadro.
   * @param string $sNomeColuna Nome da coluna de descrição do quadro.
   */
  private function escreverNotaExplicativa($sNomeQuadro, $sNomeColuna) {

    $this->oPdf->Ln(2);
    if ($this->oPdf->getAvailWidth() < 10) {
      $this->adicionarPagina($sNomeQuadro, $sNomeColuna);
    }

    $this->getNotaExplicativa($this->oPdf, $this->iCodigoPeriodo, $this->oPdf->getAvailWidth());
  }

  /**
   * Sobreescreve o getDados.
   * @return array
   * @throws Exception
   */
  public function getDados() {

    if (!$this->exibirQuadroRelatorio(self::QUADRO_PRINCIPAL)
        && !$this->exibirQuadroRelatorio(self::QUADRO_ATIVOS_PASSIVOS)
        && !$this->exibirQuadroRelatorio(self::QUADRO_CONTAS_COMPENSACAO)) {
      return array();
    }

    $sWhereBalanceteVerificacao = " c61_instit in ({$this->getInstituicoes()}) ";

    $oDataInicialAnterior = clone $this->getDataInicial();
    $oDataInicialAnterior->modificarIntervalo('-1 year');

    $oDataFinalAnterior = clone $this->getDataFinal();
    $oDataFinalAnterior->modificarIntervalo('-1 year');

    $rsBalanceteVerificacaoAtual =  db_planocontassaldo_matriz($this->iAnoUsu,
                                                               $this->getDataInicial()->getDate(),
                                                               $this->getDataFinal()->getDate(),
                                                               false,
                                                               $sWhereBalanceteVerificacao,
                                                               '',
                                                               'true',
                                                               'false'
    );
    db_query("drop table work_pl");

    if ($this->lExibirExercicioAnterior) {
      $rsBalanceteVerificacaoAnterior = db_planocontassaldo_matriz($this->iAnoUsu - 1,
                                                                   $oDataInicialAnterior->getDate(),
                                                                   $oDataFinalAnterior->getDate(),
                                                                   false,
                                                                   $sWhereBalanceteVerificacao,
                                                                   '',
                                                                   'true',
                                                                   'false'
      );
      db_query("drop table work_pl");
    }
    $aLinhas = $this->getLinhasRelatorio();
    foreach ($aLinhas as $iLinha =>  $oLinha) {

      if ($oLinha->totalizar) {
        continue;
      }

      $aValoresColunasLinhas = $oLinha->oLinhaRelatorio->getValoresColunas(null, null, $this->getInstituicoes(),
                                                                           $this->iAnoUsu);
      foreach($aValoresColunasLinhas as $aColunas) {

        foreach ($aColunas->colunas as $oColuna) {
          $oLinha->{$oColuna->o115_nomecoluna} += $oColuna->o117_valor;
        }
      }

      $oColunaAtual       = new stdClass();
      $oColunaAtual->nome = 'vlrexatual';

      $oColunaAnterior       = new stdClass();
      $oColunaAnterior->nome = 'vlrexanter';

      foreach ($oLinha->colunas as $oLinhaColuna) {

        if ($oLinhaColuna->o115_nomecoluna == 'vlrexatual') {
          $oColunaAtual->formula = $oLinhaColuna->o116_formula;
        }

        if ($this->lExibirExercicioAnterior && $oLinhaColuna->o115_nomecoluna == 'vlrexanter') {
          $oColunaAnterior->formula = $oLinhaColuna->o116_formula;
        }

      }

      if ($this->lExibirExercicioAnterior) {
        RelatoriosLegaisBase::calcularValorDaLinha($rsBalanceteVerificacaoAnterior,
                                                   $oLinha,
                                                   array($oColunaAnterior),
                                                   RelatoriosLegaisBase::TIPO_CALCULO_VERIFICACAO
        );
      }
      RelatoriosLegaisBase::calcularValorDaLinha($rsBalanceteVerificacaoAtual,
                                                 $oLinha,
                                                 array($oColunaAtual),
                                                 RelatoriosLegaisBase::TIPO_CALCULO_VERIFICACAO
      );

      unset($oLinha->oLinhaRelatorio);
    }

    $this->processaTotalizadores($aLinhas);
    return $aLinhas;
  }

  /**
   * Busca o saldo de todas as contas agrupado por recurso.
   * @param integer $iAno Ano para aplicação do período.
   *
   * @return stdClass[]
   */
  private function getSaldoPorRecurso($iAno) {



    $sIntituicoes = $this->getInstituicoes();

    $sSqlfr = " select DISTINCT o15_codigo, o15_codtri,o15_descr  FROM orctiporec where o15_codtri is not null order by o15_codtri";

    $total = 0;
    $rsRecursos = db_query($sSqlfr) or die($sSqlfr);
    $aLinhas = array();


      for ($iRecurso = 0; $iRecurso < pg_num_rows($rsRecursos); $iRecurso++) {

          $oRecursoConta = db_utils::fieldsMemory($rsRecursos, $iRecurso);

          $rsSaldoFontes = db_query($this->sql_query_saldoInicialContaCorrente(false, $oRecursoConta->o15_codigo, $sIntituicoes, $iAno));

          $oSaldoFontes = db_utils::fieldsMemory($rsSaldoFontes, 0);
          $nSaldoFinal = ($oSaldoFontes->saldoanterior + $oSaldoFontes->debito - $oSaldoFontes->credito);

          $clDeParaRecurso = new DeParaRecurso;
          $iFonteRecurso = strlen($oRecursoConta->o15_codtri) == 7 ? $oRecursoConta->o15_codtri."0" : $oRecursoConta->o15_codtri; 
          $codtri = substr($clDeParaRecurso->getDePara($iFonteRecurso),0,7);

          $sHash = $codtri;
          if($iAno==2016)
              $valores =  $oSaldoFontes->saldoanterior * -1;
          else
              $valores =  $nSaldoFinal * -1;

          if ( !isset($aLinhas[$sHash]) ) {
              $oLinha            = new stdClass();
              $oLinha->codigo    = $codtri;
              $oLinha->descricao = $oRecursoConta->o15_descr;
              $oLinha->total     = $valores;
              $aLinhas[$sHash]   = $oLinha;
          }else{

              $aLinhas[$sHash]->total  += $valores;
          }


      }

      ksort($aLinhas);
    return $aLinhas;
  }

  /**
   * Prepara um array de stdClass para ser escrito como linha no relatório.
   * @param stdClass[] $aDadosExercicioAtual
   * @param stdClass[] $aDadosExercicioAnterior
   *
   * @return stdClass[]
   */
  private function processaSuperavitDeficit($aDadosExercicioAtual, $aDadosExercicioAnterior) {

    $aLinhas                             = array();
    $oLinhaTotalizado                    = new stdClass();
    $oLinhaTotalizado->descricao         = "Total das Fontes de Recursos";
    $oLinhaTotalizado->vlrexatual        = 0.0;
    $oLinhaTotalizado->vlrexanter        = 0.0;
    $oLinhaTotalizado->totalizar         = 1;
    $oLinhaTotalizado->totalizadorFinal  = true;
    $oLinhaTotalizado->ultimaLinhaQuadro = true;
    $oLinhaTotalizado->ordem             = 0;
    $oLinhaTotalizado->nivel             = 1;

    foreach ($aDadosExercicioAtual as $oAtual) {

      $oLinha             = new stdClass();
      $oLinha->codigo     = $oAtual->codigo;
      $oLinha->descricao  = $oAtual->descricao;
      $oLinha->vlrexatual = $oAtual->total;
      $oLinha->vlrexanter = 0.0;

      foreach ($aDadosExercicioAnterior as $oAnterior) {

        if (!$this->lExibirExercicioAnterior) break;

        if ($oAtual->codigo == $oAnterior->codigo) {

          $oLinha->vlrexanter = $oAnterior->total;
          break;
        }
      }

      $oLinhaTotalizado->vlrexatual += $oLinha->vlrexatual;
      $oLinhaTotalizado->vlrexanter += $oLinha->vlrexanter;

      $oLinha->totalizar         = 0;
      $oLinha->totalizadorFinal  = false;
      $oLinha->ultimaLinhaQuadro = false;
      $oLinha->ordem             = 0;
      $oLinha->nivel             = 1;
      if($oLinha->vlrexatual == 0 && $oLinha->vlrexanter == 0){
           continue;
      }
      $aLinhas[]                 = $oLinha;
    }
    $aLinhas[] = $oLinhaTotalizado;
    return $aLinhas;
  }

  /**
   * Busca os dados de Superavit/Deficit
   * @return stdClass[]
   */
  public function getSuperavitDeficit() {

    if (!$this->exibirQuadroRelatorio(self::QUADRO_SUPERAVIT)) return;

    $aDadosExercicioAtual    = $this->getSaldoPorRecurso($this->iAnoUsu);
    $aDadosExercicioAnterior = array();
    if ($this->lExibirExercicioAnterior) {
      $aDadosExercicioAnterior = $this->getSaldoPorRecurso($this->iAnoUsu - 1);
    }

    return $this->processaSuperavitDeficit($aDadosExercicioAtual, $aDadosExercicioAnterior);
  }

  /**
   * Busca e processa os dados necessários para os quadros do relatório.
   */
  private function getDadosQuadros() {

    $this->aDados = $this->getDados();
    $this->processarQuadros();
    $this->aQuadroSuperavitDeficit = $this->getSuperavitDeficit();
  }

  /**
   * Realiza a emissão do relatório.
   */
  public function emitir() {

    $this->preparaCabecalhos();
    $this->getDadosQuadros();
    $this->configurarPdf();

    $this->emitirQuadro("QUADRO PRINCIPAL", "ATIVO" , $this->aQuadroPrincipal);
    $this->emitirQuadro("QUADRO DE ATIVOS E PASSIVOS FINANCEIROS E PERMANENTES\n(Lei nº 4.320/1964)", "", $this->aQuadroAtivosPassivos);
    $this->emitirQuadro("QUADRO DE CONTAS DE COMPENSAÇÃO\n(Lei nº 4.320/1964)",  "", $this->aQuadroContasCompensacao);
    $this->emitirQuadro("QUADRO DE SUPERÁVIT/DÉFICIT FINANCEIRO\n(Lei nº 4.320/1964)",  "FONTES DE RECURSOS", $this->aQuadroSuperavitDeficit);

    $this->oPdf->showPDF("balancoPatrimonialDCASP_" . time());
  }

  /**
   * @param boolean $lExibirExercicioAnterior
   */
  public function setExibirExercicioAnterior($lExibirExercicioAnterior) {
    $this->lExibirExercicioAnterior = $lExibirExercicioAnterior;
  }

  function sql_query_saldoInicialContaCorrente ($iInstit=false,$iFonte=null, $sIntituicoes, $iAno=null){

        $sSqlReduzSuperavit = "select c61_reduz from conplano inner join conplanoreduz on c60_codcon=c61_codcon and c61_anousu=c60_anousu
                             where substr(c60_estrut,1,5)='82111' and c60_anousu=" . $iAno ." and c61_anousu=" . $iAno;
        $sWhere =  " AND conhistdoc.c53_tipo not in (1000) ";

        if($iAno==2016){
            $iAno = 2017;
            $sSqlReduzSuperavit = "select c61_reduz from conplano inner join conplanoreduz on c60_codcon=c61_codcon and c61_anousu=c60_anousu
                             where substr(c60_estrut,1,5)='82910' and c60_anousu=2017 and c61_anousu=2017";
            $sWhere =  " AND conhistdoc.c53_tipo in (2023) ";
        }

        if($iInstit==false){
            $sSqlReduzSuperavit = $sSqlReduzSuperavit." and c61_instit in (".$sIntituicoes.")";
        }

        $sSqlSaldos = " SELECT saldoanterior , debito , credito
                                        FROM
                                          (select coalesce((SELECT SUM(saldoanterior) AS saldoanterior FROM
                                                    (SELECT CASE WHEN c29_debito > 0 THEN c29_debito WHEN c29_credito > 0 THEN -1 * c29_credito ELSE 0 END AS saldoanterior
                                                     FROM contacorrente
                                                     INNER JOIN contacorrentedetalhe ON contacorrente.c17_sequencial = contacorrentedetalhe.c19_contacorrente
                                                     INNER JOIN contacorrentesaldo ON contacorrentesaldo.c29_contacorrentedetalhe = contacorrentedetalhe.c19_sequencial
                                                     AND contacorrentesaldo.c29_mesusu = 0 and contacorrentesaldo.c29_anousu = c19_conplanoreduzanousu
                                                     WHERE c19_reduz IN ( $sSqlReduzSuperavit )
                                                       AND c19_conplanoreduzanousu = " . $iAno . "
                                                       AND c17_sequencial = 103
                                                       AND c19_orctiporec = {$iFonte}) as x),0) saldoanterior) AS saldoanteriores,

                                            (select coalesce((SELECT sum(c69_valor) as credito
                                             FROM conlancamval
                                             INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                             AND conlancam.c70_anousu = conlancamval.c69_anousu
                                             INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                             INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                             INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                             INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                             INNER JOIN contacorrente ON contacorrente.c17_sequencial = contacorrentedetalhe.c19_contacorrente
                                             WHERE c28_tipo = 'C'
                                               AND DATE_PART('YEAR',c69_data) = " . $iAno . "
                                               AND c17_sequencial = 103
                                               AND c19_reduz IN (  $sSqlReduzSuperavit  )
                                               AND c19_conplanoreduzanousu = " . $iAno . "
                                               AND c19_orctiporec = {$iFonte}
                                              ".$sWhere."
                                             GROUP BY c28_tipo),0) as credito) AS creditos,

                                            (select coalesce((SELECT sum(c69_valor) as debito
                                             FROM conlancamval
                                             INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                             AND conlancam.c70_anousu = conlancamval.c69_anousu
                                             INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                             INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                             INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                             INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                             INNER JOIN contacorrente  ON contacorrente.c17_sequencial = contacorrentedetalhe.c19_contacorrente
                                             WHERE c28_tipo = 'D'
                                               AND DATE_PART('YEAR',c69_data) = " . $iAno . "
                                               AND c17_sequencial = 103
                                               AND c19_reduz IN ( $sSqlReduzSuperavit )
                                               AND c19_conplanoreduzanousu = " . $iAno . "
                                               AND c19_orctiporec = {$iFonte}
                                               ".$sWhere."
                                             GROUP BY c28_tipo),0) as debito) AS debitos";

        return $sSqlSaldos;


    }
}
