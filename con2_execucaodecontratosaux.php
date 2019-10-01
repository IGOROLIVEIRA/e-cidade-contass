<?php

class ExecucaoDeContratos{

  /*
 * Monta Cabecalho dos Arcordos
 */
  public static function imprimirCabecalhoAcordos($oPdf, $iAlt, $iFonte, $oAcordo, $aLicitacoesVinculadas) {

    // BLOCO DE PRÉ-RENDERIZAÇÃO
    $iDepartamento = $oAcordo->getDepartamentoResponsavel();
    $oDepartamento = new DBDepartamento($iDepartamento);
    $sDepartamentoResponsavel = $iDepartamento.' - '.$oDepartamento->getNomeDepartamento();

    $dDataAssinatura = $oAcordo->getDataAssinatura();
    if(empty( $dDataAssinatura )){
      $dDataAssinatura = 'Não informado';
    }

//    $dDataAssinatura = empty( $oAcordo->getDataAssinatura() ) ? 'Não informado' : date("d/m/Y", strtotime( $oAcordo->getDataAssinatura() ));

    $oPdf->SetFont('Arial','B',$iFonte);
    $oPdf->SetFillColor(220);

    // 1ª linha
    $oPdf->Cell(70 ,$iAlt,'Cód. do Acordo: '.$oAcordo->getCodigo(),0,0,'L',0);
    $oPdf->Cell(150 ,$iAlt,'Contratado: '.$oAcordo->getContratado()->getNome(),0,0,'L',0);

    // 2ª linha
    $oPdf->Ln();
    $oPdf->Cell(70 ,$iAlt,'Nº Contrato: '.$oAcordo->getNumero().'/'.$oAcordo->getAno(),0,0,'L',0);
    $oPdf->Cell(150 ,$iAlt,"Departamento Responsável: $sDepartamentoResponsavel",0,0,'L',0);

    // 3ª linha
    $oPdf->Ln();
    $oPdf->Cell(70 ,$iAlt,"Data de Assinatura: $dDataAssinatura",0,0,'L',0);

    if(!empty($aLicitacoesVinculadas)){

      $oLicitacoesVinculadas = $aLicitacoesVinculadas[0];
      $oStdDados = $oLicitacoesVinculadas->getDados();

      $oPdf->Cell(70 ,$iAlt,'Licitação: '.$oStdDados->l20_edital.'/'.$oStdDados->l20_anousu.' - '.
        $oStdDados->l03_descr.' '.$oStdDados->l20_numero.'/'.$oStdDados->l20_anousu,0,0,'L',0);
    }

    if($oAcordo->licitacao != ""){
      $oPdf->Cell(50 ,$iAlt,'Processo Licitatorio: '.$oAcordo->licitacao.'/'.$oAcordo->ano_processo_licitatorio,0,0,'L',0);
    }

    $oPdf->Ln();

  }

  public static function imprimirCabecalhoTabela($oPdf, $iAlt, $oEmpenhamento = null, $iFonte, $iQuebra, $oPosicao = null, $iP4 = null){

    $oPdf->SetFont('Arial','B',$iFonte);

    $oPdf->Ln();
    if($oPdf->GetY() > 190){
      $oPdf->AddPage('L');
    }

    if($iQuebra == '2'){

      $oPdf->Cell(50 ,$iAlt,"Empenho: $oEmpenhamento->empenho",0,0,'L',0);
      $oPdf->Cell(50 ,$iAlt,"Data: ".date('d/m/Y', strtotime($oEmpenhamento->dataemissao)),0,0,'L',0);
      $oPdf->Ln();

    }

    if($iQuebra == '3'  && (int)$oPosicao->getTipo() !== 1){

      $sApostilamentoOuAditamento = "Nº aditivo: ";
      $iNumApostilamentoOuAditamento = $oPosicao->getNumeroAditamento();

      if(empty( $iNumApostilamentoOuAditamento )){
        $sApostilamentoOuAditamento = "Nº apostilamento: ";
        $iNumApostilamentoOuAditamento = $oPosicao->getNumeroApostilamento();
      }

      $oPdf->Cell(35 ,$iAlt,$sApostilamentoOuAditamento.$iNumApostilamentoOuAditamento,0,0,'L',0);
      $oPdf->Cell(106 ,$iAlt,"Tipo: ".$oPosicao->getTipo().' - '.self::limitarTexto($oPosicao->getDescricaoTipo(),50),0,0,'L',0);
      $oPdf->Cell(50 ,$iAlt,"Data: ".$oPosicao->getData(),0,0,'L',0);
      $oPdf->Ln();

    }
    if( $iQuebra == '3' && (int)$oPosicao->getTipo() === 1 ){
      $oPdf->Cell(35 ,$iAlt,"Sem aditamento",0,0,'L',0);
      $oPdf->Ln();
    }

    $oPdf->Cell(18 ,$iAlt,'Cód. Item',1,0,'C',1);
    $oPdf->Cell(124,$iAlt,'Descrição Item',1,0,'C',1);
    $oPdf->Cell(22 ,$iAlt,'Valor. Unit.',1,0,'C',1);
    $oPdf->Cell(25 ,$iAlt,'Qt. Empenhada',1,0,'C',1);
    $oPdf->Cell(20 ,$iAlt,'Qt. Anulada',1,0,'C',1);
    $oPdf->Cell(24 ,$iAlt,'Qtd. solicitada',1,0,'C',1);
    $oPdf->Cell(25 ,$iAlt,'Total solicitado',1,0,'C',1);
    $oPdf->Cell(22 ,$iAlt,'Qt. a solicitar',1,0,'C',1);
    $oPdf->Ln();

  }

  public static function imprimirCabecalhoTabela4($oPdf, $iAlt, $oEmpenhamento = null, $iFonte, $oPosicao = null, $iP4, $iKp = null){

    $oPdf->SetFont('Arial','B',$iFonte);

    $iKp !== 0 ? $oPdf->Ln() : null;
    if($oPdf->GetY() > 190){
      $oPdf->AddPage('L');
    }

    if( (int)$iP4 === 1 && (int)$oPosicao->getTipo() !== 1 ){

      $sApostilamentoOuAditamento = "Nº aditivo: ";
      $iNumApostilamentoOuAditamento = $oPosicao->getNumeroAditamento();

      if(empty( $iNumApostilamentoOuAditamento )){
        $sApostilamentoOuAditamento = "Nº apostilamento: ";
        $iNumApostilamentoOuAditamento = $oPosicao->getNumeroApostilamento();
      }

      $oPdf->Cell(35 ,$iAlt,$sApostilamentoOuAditamento.$iNumApostilamentoOuAditamento,0,0,'L',0);
      $oPdf->Cell(106 ,$iAlt,"Tipo: ".$oPosicao->getTipo().' - '.self::limitarTexto($oPosicao->getDescricaoTipo(),50),0,0,'L',0);
      $oPdf->Cell(50 ,$iAlt,"Data: ".$oPosicao->getData(),0,0,'L',0);
//        $oPdf->Ln();

    }

    if( (int)$oPosicao->getTipo() === 1 && $iKp === 0 ){

      $oPdf->Ln();
      $oPdf->Cell(35 ,$iAlt,"Sem aditamento",0,0,'L',0);

    }

    if( (int)$iP4 === 2 ){

      $oPdf->Cell(50 ,$iAlt,"Empenho: $oEmpenhamento->e60_codemp/$oEmpenhamento->e60_anousu",0,0,'L',0);
      $oPdf->Cell(50 ,$iAlt,"Data: ".date('d/m/Y', strtotime($oEmpenhamento->e60_emiss)),0,0,'L',0);
      $oPdf->Ln();

    }
    if((int)$iP4 !== 1){

      $oPdf->Cell(18 ,$iAlt,'Cód. Item',1,0,'C',1);
      $oPdf->Cell(124,$iAlt,'Descrição Item',1,0,'C',1);
      $oPdf->Cell(22 ,$iAlt,'Valor. Unit.',1,0,'C',1);
      $oPdf->Cell(25 ,$iAlt,'Qt. Empenhada',1,0,'C',1);
      $oPdf->Cell(20 ,$iAlt,'Qt. Anulada',1,0,'C',1);
      $oPdf->Cell(24 ,$iAlt,'Qtd. solicitada',1,0,'C',1);
      $oPdf->Cell(25 ,$iAlt,'Total solicitado',1,0,'C',1);
      $oPdf->Cell(22 ,$iAlt,'Qt. a solicitar',1,0,'C',1);
      $oPdf->Ln();
    }

  }

  public static function consultarNumOrdem($sCodigoempenho){

    $sCampos = ' distinct m51_codordem ';
    $oDaoMatOrdem  = db_utils::getDao('matordem');

    $sSqlItens         = $oDaoMatOrdem->sql_query_anu("",$sCampos,null,"m52_numemp = $sCodigoempenho");
    $rsMatOrdem    = $oDaoMatOrdem->sql_record($sSqlItens);

    $aItensRetorno = array();
    $oStdItem = new stdClass;

    for ($iRowItem = 0; $iRowItem < $oDaoMatOrdem->numrows; $iRowItem++) {

      $oStdItem = db_utils::fieldsMemory($rsMatOrdem, $iRowItem);
      $aItensRetorno[] = $oStdItem;

    }

    return $aItensRetorno;

  }

  /*
   * Retorna os itens de um empenho
   */
  public static function consultarItensEmpenho($iCodigoEmpenho, $iCodigoMaterial = null){

    $sCamposEmpenho  = "distinct riseqitem     as item_empenho";
    $sCamposEmpenho .= "         ,ricodmater   as codigo_material";
    $sCamposEmpenho .= "         ,rsdescr      as descricao_material";
    $sCamposEmpenho .= "         ,ricodordem as ordem_de_compra";
    $sCamposEmpenho .= "         ,e62_descr";
    $sCamposEmpenho .= "         ,rnquantini   as quantidade";
    $sCamposEmpenho .= "         ,rnvalorini   as valor_total";
    $sCamposEmpenho .= "         ,rnvaloruni   as valor_unitario";
    $sCamposEmpenho .= "         ,rnsaldoitem  as saldo";
    $sCamposEmpenho .= "         ,round(rnsaldovalor,2) as saldo_valor";
    $sCamposEmpenho .= "         ,o56_descr";
    $sCamposEmpenho .= "         ,case when pcorcamval.pc23_obs is not null";
    $sCamposEmpenho .= "              then pcorcamval.pc23_obs";
    $sCamposEmpenho .= "              else pcorcamvalpai.pc23_obs";
    $sCamposEmpenho .= "         end as observacao";

    $oDaoEmpenho      = db_utils::getDao("empempenho");

    $sSqlItensEmpenho = $oDaoEmpenho->sql_query_itens_consulta_empenho($iCodigoEmpenho,$sCamposEmpenho,'ricodmater');
    $rsBuscaEmpenho   = $oDaoEmpenho->sql_record($sSqlItensEmpenho);

    $aItensRetorno = array();

    for ($iRowItem = 0; $iRowItem < $oDaoEmpenho->numrows; $iRowItem++) {

      $oStdItem = db_utils::fieldsMemory($rsBuscaEmpenho, $iRowItem);
      $oStdItem->descricao_material = $oStdItem->descricao_material;
      $oStdItem->observacao         = urlencode($oStdItem->observacao);
      $aItensRetorno[] = $oStdItem;

    }

    return $aItensRetorno;

  }

  /*
   * Retorna os itens anulados de um empenho
   */
  public static function itensAnulados($iCodigoEmpenho,$iCodigoMaterial){

    $oDaoItemAnulado    = db_utils::getDao("empanuladoitem");
    $sCamposItemAnulado = "pc01_codmater,pc01_descrmater,e37_qtd AS quantidade, e37_vlranu,e94_data";
    $sWhere = "e62_numemp = $iCodigoEmpenho AND pc01_codmater = $iCodigoMaterial ";
    $sSqlAnulados       = $oDaoItemAnulado->sql_query(null, $sCamposItemAnulado, "e62_sequen", $sWhere);
    $rsBuscaItemAnulado = $oDaoItemAnulado->sql_record($sSqlAnulados);

    return db_utils::getCollectionByRecord($rsBuscaItemAnulado);

  }

  public static function empenhosDeUmaPosicao($iCodPosicao,$ac16_datainicio,$ac16_datafim){

    $oDaoAcordoPosicao    = db_utils::getDao("acordoposicao");
    $sSqlEmpenhos = $oDaoAcordoPosicao->getEmpenhosDeUmaPosicao($iCodPosicao,$ac16_datainicio,$ac16_datafim);
    $rsBuscaEmpenhos = $oDaoAcordoPosicao->sql_record($sSqlEmpenhos);
    $aItensRetorno = array();
    for ($iRowItem = 0; $iRowItem < pg_num_rows($rsBuscaEmpenhos); $iRowItem++) {
      $aItensRetorno[] = db_utils::fieldsMemory($rsBuscaEmpenhos, $iRowItem);
    }

    return $aItensRetorno;

  }

  public static function getAcordosFornecedor($iFornecedor){
      $oDaoAcordo    = db_utils::getDao("acordo");
      $sSqlAcordos = $oDaoAcordo->sql_query(null,"ac16_sequencial",null,"ac16_contratado = $iFornecedor");
      $rsBuscaAcordo = $oDaoAcordo->sql_record($sSqlAcordos);
      $aAcordosRetorno = array();
      for ($iRowItem = 0; $iRowItem < pg_num_rows($rsBuscaAcordo); $iRowItem++) {
          $aAcordosRetorno[] = db_utils::fieldsMemory($rsBuscaAcordo, $iRowItem);
      }

      return $aAcordosRetorno;
  }

  public static function getValoresEmpenho($iEmpenho){
      $oDaoEmpempenho    = db_utils::getDao("empempenho");
      $sSqlEmpempenho    = $oDaoEmpempenho->sql_query(null,"e60_vlremp,e60_vlrliq,e60_vlrpag,e60_vlranu",null,"e60_numemp = $iEmpenho",null,null);
      $rsValoresEmp      = $oDaoEmpempenho->sql_record($sSqlEmpempenho);
      $aValoresEmp[]     = db_utils::fieldsMemory($rsValoresEmp, 0);
      return $aValoresEmp;
  }

  public static function arrayDeMateriais($oExecucaoDeContratos, $aEmpenhamentos, $iCodRel = null){

    $aCodigosDosMateriais = array();

    // Gera um array com o código de cada material de cada empenho
    foreach($aEmpenhamentos as $oEmpenhamento){

      $iCodEmpenho = $iCodRel === 3 ? (int)$oEmpenhamento->e61_numemp : (int)$oEmpenhamento->codigoempenho;

      if(empty($iCodEmpenho)){
        continue;
      }

      $aEmpenho = $oExecucaoDeContratos->consultarItensEmpenho($iCodEmpenho);

      // Percorre os itens do empenho atual para extrair dele o código do material
      foreach ($aEmpenho as $oItem){
        $aCodigosDosMateriais[] = (object) array('codigo'=>$oItem->codigo_material,'descricao'=>$oItem->descricao_material);
      }

    }

    return $aCodigosDosMateriais;

  }

  /*
   * Retorna uma descrição dentro do limite de caracteres informado
   */
  public static function limitarTexto($texto, $limite, $quebrar = true){

    //corta as tags HTML do texto para evitar corte errado
    $contador = strlen(strip_tags($texto));
    if($contador <= $limite){
      return $texto;
    }

    if($quebrar != true){
      //localiza ultimo espaço antes de $limite
      $ultimo_espaço = strrpos(mb_substr($texto, 0, $limite)," ");
      //corta o $texto até a posição lozalizada
      return trim(mb_substr($texto, 0, $ultimo_espaço))."...";
    }

    //corta o texto no limite indicado e retira o ultimo espaço branco
    return trim(mb_substr($texto, 0, $limite))."...";

  }

  /**
   * Retorna os itens de um mesmo material que esteja em ordem de compra
   */
  public static function quantidadeEmOrdemDeCompra($iOrdemCompra, $iCodEmpenho, $iCodMaterial){

    $oOrdemCompra = new OrdemDeCompra($iOrdemCompra);
    return $oOrdemCompra->getItem($iOrdemCompra, $iCodEmpenho, $iCodMaterial);

  }

  public static function quantidadeTotalEmOrdensDeCompra($iCodEmp, $iCodMat){

    $aOrdensDeEmpenho = self::ordensDeUmEmpenho( (int)$iCodEmp, (int)$iCodMat );

    $dQuantidadeEmOrdemDeCompra = 0;
    $dQuantidadeAnuladaEmOrdemDeCompra = 0;

    foreach($aOrdensDeEmpenho as $ordemDeEmpenho){

      $oOrdemDeCompra = self::quantidadeEmOrdemDeCompra( (int)$ordemDeEmpenho->ordem, (int)$iCodEmp, (int)$iCodMat );
      $dQuantidadeEmOrdemDeCompra += (double)$oOrdemDeCompra->quantidade;
      $dQuantidadeAnuladaEmOrdemDeCompra += (double)$oOrdemDeCompra->qtdanulada;

    }

    return (double)$dQuantidadeEmOrdemDeCompra - (double)$dQuantidadeAnuladaEmOrdemDeCompra;

  }

  public static function ordensDeUmEmpenho($iNumEmp, $iCodMaterial){

    $oDaoMatOrdemItem  = db_utils::getDao('matordemitem');
    $sWhere = "matordemitem.m52_numemp = $iNumEmp AND pc01_codmater = $iCodMaterial";
    $sSqlOrdensDeUmEmp = $oDaoMatOrdemItem->sql_query(null, 'm52_codordem as ordem', 'm52_codordem', $sWhere);

    $rsOrdensDeUmEmp = $oDaoMatOrdemItem->sql_record($sSqlOrdensDeUmEmp);

    for($iCont = 0; $iCont < pg_num_rows($rsOrdensDeUmEmp); $iCont++){
      $aOrdensDeUmEmp[] = db_utils::fieldsMemory($rsOrdensDeUmEmp,$iCont);
    }

    return $aOrdensDeUmEmp;

  }

  public static function imprimeFinalizacao($oPdf,$iFonte,$iAlt,$aMateriais,$comprim,$iNumItens = null){

    $oPdf->SetFont('Arial','B',$iFonte);

    $oPdf->Ln();
    $oPdf->Cell(278 ,$iAlt-3,'',0,1,'C',0);
    $oPdf->Cell(34 ,$iAlt,'Total de Registros:',0,0,'L',0);
    $oPdf->Cell(30 ,$iAlt,''.is_null($iNumItens) ? count($aMateriais) : $iNumItens.'',0,0,'L',0);

    $oPdf->Ln();
    $oPdf->SetFont('Arial','',9);
    $Espaco = $oPdf->w - 80;
    $margemesquerda = $oPdf->lMargin;
    $oPdf->setleftmargin($Espaco+5);
    $oPdf->sety(6);
    $oPdf->setfillcolor(235);
    $oPdf->roundedrect($Espaco - 3,5,75,28,2,'DF','123');
    $oPdf->line(10,33,$comprim,33);
    $oPdf->setfillcolor(255);

    $oPdf->multicell(0,3,@$GLOBALS["head1"],0,"J",0);
    $oPdf->multicell(0,3,@$GLOBALS["head2"],0,"J",0);
    $oPdf->multicell(0,3,@$GLOBALS["head3"],0,"J",0);
    $oPdf->multicell(0,3,@$GLOBALS["head4"],0,"J",0);
    $oPdf->multicell(0,3,@$GLOBALS["head5"],0,"J",0);
    $oPdf->multicell(0,3,@$GLOBALS["head6"],0,"J",0);
    $oPdf->multicell(0,3,@$GLOBALS["head7"],0,"J",0);
    $oPdf->multicell(0,3,@$GLOBALS["head8"],0,"J",0);
    $oPdf->multicell(0,3,@$GLOBALS["head9"],0,"J",0);

    $oPdf->setleftmargin($margemesquerda);
    $oPdf->SetY(35);
    $oPdf->Output();

  }

  public static function isServico($oContrato, $oParam){

    foreach ($oContrato->getPosicoes() as $oPosicaoContrato) {

      if ($oPosicaoContrato->getCodigo() == $oParam->iPosicao) {

        $oRetorno = new stdClass();

        foreach ($oPosicaoContrato->getItens() as $oItem) {

          $oItemRetorno                      = new stdClass();
          $oItemRetorno->codigo              = $oItem->getCodigo();
          $oItemRetorno->material            = $oItem->getMaterial()->getDescricao();
          $oItemRetorno->codigomaterial      = urlencode($oItem->getMaterial()->getMaterial());
          $oItemRetorno->elemento            = $oItem->getElemento();
          $oItemRetorno->desdobramento       = $oItem->getDesdobramento();
          $oItemRetorno->valorunitario       = $oItem->getValorUnitario();
          $oItemRetorno->valortotal          = $oItem->getValorTotal();
          $oItemRetorno->quantidade          = $oItem->getQuantidade();
          $oItemRetorno->lControlaQuantidade = $oItem->getControlaQuantidade();

          $aCasasDecimais = explode(".", $oItemRetorno->valorunitario);
          if (count($aCasasDecimais) > 1 && strlen($aCasasDecimais[1]) > 2) {
            $oRetorno->iCasasDecimais = 3;
          }

          foreach ($oItem->getDotacoes() as $oDotacao) {

            $oDotacaoSaldo = new Dotacao($oDotacao->dotacao, $oDotacao->ano);
            $oDotacao->saldoexecutado = 0;
            $oDotacao->valorexecutar  = 0;
            $oDotacao->saldodotacao   = $oDotacaoSaldo->getSaldoFinal();

            $oDotacao->valor -= $oDotacao->executado;

          }
          $oItemRetorno->dotacoes       = $oItem->getDotacoes();
          $oItemRetorno->saldos         = $oItem->getSaldos();
          $oItemRetorno->servico        = $oItem->getMaterial()->isServico();
          $oRetorno->itens[]            = $oItemRetorno;
        }
        break;
      }
    }

  }

  public static function vd($var, $die = true, $marcador = null, $pre = true){

    if($pre) echo '<pre>';
    var_dump($var);
    echo '<br><br>';

    if($die){
      if(is_null($marcador)) die();
      die($marcador);
    }
    echo "$marcador<br><br>";

  }

  public static function pd($var, $die = true, $marcador = null, $pre = true){

    if($pre) echo '<pre>';
    print_r($var);
    echo '<br><br>';

    if($die){
      if($marcador) die($marcador);
      die();
    }

  }

  public static function objetoVazio($object){

    foreach($object as $value){
      return false;
    }
    return true;

  }

  // Verifica se $a é maior que $b
  public static function cmp($a, $b) {
    return $a['coditem'] > $b['coditem'];
  }

}