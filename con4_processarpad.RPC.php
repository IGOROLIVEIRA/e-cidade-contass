<?php
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_libcontabilidade.php");
require_once("libs/db_liborcamento.php");
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_libpostgres.php");
require_once("libs/db_sessoes.php");
require_once("model/padArquivoEscritorXML.model.php");
require_once ("model/PadArquivoEscritorCSV.model.php");

$oJson    = new services_json();
$oParam   = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\","",$_POST["json"])));

$oRetorno = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = 1;
$oRetorno->itens   = array();
switch($oParam->exec) {

  case "excluirArquivosIP":

  try {
      $iAnoReferencia = db_getsession('DB_anousu');
      $ano = substr($iAnoReferencia, -2);

      if (file_exists("PPA{$ano}.pdf")){
        array_map( "unlink", glob( "PPA{$ano}.pdf" ) );
      }
      if(file_exists("LDO{$ano}.pdf")){
        array_map( "unlink", glob( "LDO{$ano}.pdf" ) );
      }
      if(file_exists("LOA{$ano}.pdf")){
        array_map( "unlink", glob( "LOA{$ano}.pdf" ) );
      }
      if(file_exists("ANEXOS_LOA.pdf")){
        array_map( "unlink", glob( "ANEXOS_LOA.pdf" ) );
      }
      if(file_exists("OPCAOSEMESTRALIDADE.pdf")){
        array_map( "unlink", glob( "OPCAOSEMESTRALIDADE.pdf" ) );
      }
      if(file_exists("DESOPCAOSEMESTRALIDADE.pdf")){
        array_map( "unlink", glob( "DESOPCAOSEMESTRALIDADE.pdf" ) );
      }
  }catch (Exception $eErro) {
          $oRetorno->status  = 2;
          $sGetMessage       = "retornou com erro: \\n \\n {$eErro->getMessage()}";
          $oRetorno->message = urlencode(str_replace("\\n", "\n",$sGetMessage));
  }



  break;

  case "processarSigap":

  $sDataInicial = db_getsession("DB_anousu").'-01-01';
  $iUltimoDia   = cal_days_in_month(CAL_GREGORIAN, $oParam->iPeriodo, db_getsession("DB_anousu"));
  $sDataFinal   = db_getsession("DB_anousu")."-".str_pad($oParam->iPeriodo, 2, "0",STR_PAD_LEFT)."-{$iUltimoDia}";
  if (count($oParam->aArquivos) > 0) {

    $oEscritorXML = new padArquivoEscritorXML();
    $otxtLogger   = fopen("tmp/SIGAP.log", "w");
    foreach ($oParam->aArquivos as $sArquivo) {

      if (file_exists("model/PadArquivoSigap{$sArquivo}.model.php")) {

        require_once("model/PadArquivoSigap{$sArquivo}.model.php");
        $sNomeClasse = "PadArquivoSigap{$sArquivo}";

        $oArquivo    = new $sNomeClasse;
        $oArquivo->setDataInicial($sDataInicial);
        $oArquivo->setDataFinal($sDataFinal);
        $oArquivo->setCodigoTCE($oParam->iCodigoTCE);
        $oArquivo->setTXTLogger($otxtLogger);
        if ($sArquivo == 'Ppa') {
          $oArquivo->setCodigoVersao($oParam->iPerspectivaPPa);
        }
        if ($sArquivo == 'LoaDespesa' || $sArquivo == 'LoaReceita') {
          $oArquivo->setCodigoVersao($oParam->iPerspectivaCronograma);
        }
        try {

          $oArquivo->gerarDados();
          $oEscritorXML->adicionarArquivo($oEscritorXML->criarArquivo($oArquivo), $oArquivo->getNomeArquivo());
        } catch (Exception $eErro) {

          $oRetorno->status  = 2;
          $sGetMessage       = "Arquivo:{$oArquivo->getNomeArquivo()} retornou com erro: \\n \\n {$eErro->getMessage()}";
          $oRetorno->message = urlencode(str_replace("\\n", "\n",$sGetMessage));
        }
      }
    }

    $oEscritorXML->zip("SIGAP");
    $oEscritorXML->adicionarArquivo("tmp/SIGAP.log", "SIGAP.log");
    $oEscritorXML->adicionarArquivo("tmp/SIGAP.zip", "SIGAP.zip");
    $oRetorno->itens  = $oEscritorXML->getListaArquivos();
    fclose($otxtLogger);
  }
  break;

  case "processarObra":
//    ini_set('display_errors','on');
    $iUltimoDiaMes = date("d", mktime(0,0,0,$oParam->mesReferencia+1,0,db_getsession("DB_anousu")));
    $sDataInicial = db_getsession("DB_anousu")."-{$oParam->mesReferencia}-01";
    $sDataFinal   = db_getsession("DB_anousu")."-{$oParam->mesReferencia}-{$iUltimoDiaMes}";
    if (count($oParam->arquivos) > 0) {
      $sSql  = "SELECT db21_codigomunicipoestado FROM db_config where codigo = ".db_getsession("DB_instit");
      $rsInst = db_query($sSql);
      $sInst  = str_pad(db_utils::fieldsMemory($rsInst, 0)->db21_codigomunicipoestado, 5, "0", STR_PAD_LEFT);
      $iAnoReferencia = db_getsession('DB_anousu');

      $sSql  = "SELECT si09_codorgaotce AS codorgao
                    FROM db_config
                    LEFT JOIN infocomplementaresinstit ON si09_instit = codigo
                    WHERE codigo = ".db_getsession("DB_instit");
      $rsOrgao = db_query($sSql);
      $sOrgao  = str_pad(db_utils::fieldsMemory($rsOrgao, 0)->codorgao, 2,"0",STR_PAD_LEFT);
      echo pg_last_error();

//      $sql = "select si201_codobra,si201_tipomedicao,si201_nummedicao
// from cadobras302020 where si201_mes = $oParam->mesReferencia and si201_tipomedicao in(1,3,4,5)";
      $sql = "SELECT si201_codobra,
                       si201_tipomedicao,
                       si201_nummedicao
                FROM cadobras302020
                INNER JOIN licobrasmedicao ON obr03_nummedicao::int = si201_nummedicao::int
                INNER JOIN licobrasanexo ON obr03_sequencial = obr04_licobrasmedicao
                WHERE si201_mes = $oParam->mesReferencia";
      $rsRegistro30 = db_query($sql);

      $arquivosgerados = array();

      /*
       * array para adicionar os arquivos de inslusao de programas
       */
      $aArquivoProgramas =  array();
      /*
       * gerar arquivos correspondentes a todas as opcoes selecionadas
       */
      $oEscritorPDF          = new padArquivoEscritorCSV();
      $oEscritorProgramasCSV = new padArquivoEscritorCSV();
      /*
       * instanciar cada arqivo selecionado e gerar o CSV correspondente
       */
      $aArrayArquivos = array();
      foreach ($oParam->arquivos as $sArquivo) {
        if (file_exists("model/contabilidade/arquivos/sicom/".db_getsession('DB_anousu')."/obra/SicomArquivo{$sArquivo}.model.php")) {
          require_once("model/contabilidade/arquivos/sicom/".db_getsession('DB_anousu')."/obra/SicomArquivo{$sArquivo}.model.php");
          $sNomeClasse = "SicomArquivo{$sArquivo}";
          $oArquivo    = new $sNomeClasse;
          $oArquivo->setDataInicial($sDataInicial);
          $oArquivo->setDataFinal($sDataFinal);
          $oArquivoCsv = new stdClass();
          try {
            $oArquivo->gerarDados();
            $oArquivoCsv->nome    = "{$oArquivo->getNomeArquivo()}.csv";
            $oArquivoCsv->caminho = "{$oArquivo->getNomeArquivo()}.csv";
            $aArrayArquivos[] = $oArquivoCsv;
          } catch (Exception $eErro) {
            $oRetorno->status  = 2;
            $sGetMessage       = "Arquivo:{$oArquivo->getNomeArquivo()} retornou com erro: \\n \\n {$eErro->getMessage()}";
            $oRetorno->message = urlencode(str_replace("\\n", "\n",$sGetMessage));
          }
        }
        if($sArquivo == "DetalhamentodeObras"){
          for ($iCont30 = 0; $iCont30 < pg_num_rows($rsRegistro30); $iCont30++) {

            $oDados30 = db_utils::fieldsMemory($rsRegistro30, $iCont30);
            $filePdf = 'FOTO_MEDICAO' . "_" . $sOrgao . "_" . $oDados30->si201_codobra . "_" . $oDados30->si201_tipomedicao . "_" . $oDados30->si201_nummedicao . ".pdf";
            $arquivosgerados[] = $filePdf;
          }
        }
      }
      $aListaArquivos = " ";
      foreach ($aArrayArquivos as $oArquivo){
        $aListaArquivos .= " ".$oArquivo->caminho;
      }
      system("rm -f OBRA_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip");
      system("bin/zip -q OBRA_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip $aListaArquivos");
//echo "<pre>"; print_r($arquivosgerados);exit;
      if($arquivosgerados[0] != null){

        foreach ($arquivosgerados as $arq) {
          $aListaArquivospdf .= " ".$arq;
          if (file_exists("$arq")){
            $oEscritorPDF->adicionarArquivo("$arq", "$arq");
          }
        }
        $oEscritorPDF->zip("FOTO_MEDICAO_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}");

        foreach ($arquivosgerados as $arquivo) {
          unlink($arquivo);
        }

        $oArquivopdf = new stdClass();
        $aPdfs = array();
        foreach ($oEscritorPDF->getListaArquivos() as $pdf){
          $aPdfs[] =$pdf;
        }
        $oArquivopdf->pdfs = $aPdfs;
        $oArquivopdf->nome = "FOTO_MEDICAO_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip";
        $oArquivopdf->caminho = "tmp/FOTO_MEDICAO_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip";
        $aArrayArquivos[] = $oArquivopdf;
      }

      $oArquivoZip = new stdClass();
      $oArquivoZip->nome    = "OBRA_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip";
      $oArquivoZip->caminho = "OBRA_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip";
      $aArrayArquivos[] = $oArquivoZip;

      $oRetorno->itens  = $aArrayArquivos;

    }
    break;

  case "processarSicomAnual" :
    /**
     * sempre usar essa funcao para pegar o ano
     */
    $sDataInicial = db_getsession("DB_anousu").'-01-01';
    $sDataFinal   = db_getsession("DB_anousu")."-12-31";


    $sSql  = "SELECT db21_codigomunicipoestado FROM db_config WHERE codigo = ".db_getsession('DB_instit');

    $rsInst = db_query($sSql);
    $sInst  = str_pad(db_utils::fieldsMemory($rsInst, 0)->db21_codigomunicipoestado, 5, "0", STR_PAD_LEFT);

    $iAnoReferencia = db_getsession('DB_anousu');
    $ano = substr($iAnoReferencia, -2);

    $oEscritorCSV = new padArquivoEscritorCSV();
      /**
       * Verificar se existe pelo menos um pdf de leis antes de tentar processar
       */
     //  if (!file_exists("PPA{$ano}.pdf") && !file_exists("LDO{$ano}.pdf")
     //          && !file_exists("LOA{$ano}.pdf") && !file_exists("ANEXOS_LOA.pdf")) {
     //    	$oRetorno->status  = 2;
     //      $sGetMessage       = "Envie os arquivos das Leis antes de processar!";
     //      $oRetorno->message = urlencode(str_replace("\\n", "\n",$sGetMessage));
     //      break;
    	// }

      $iVerifica=0;
      if (file_exists("PPA{$ano}.pdf")){
        $oEscritorCSV->adicionarArquivo("PPA{$ano}.pdf", "PPA{$ano}.pdf");
        $iVerifica=1;
      }
      if(file_exists("LDO{$ano}.pdf")){
        $oEscritorCSV->adicionarArquivo("LDO{$ano}.pdf", "LDO{$ano}.pdf");
        $iVerifica=1;
      }
      if(file_exists("LOA{$ano}.pdf")){
        $oEscritorCSV->adicionarArquivo("LOA{$ano}.pdf", "LOA{$ano}.pdf");
        $iVerifica=1;
      }
      if(file_exists("ANEXOS_LOA.pdf")){
        $oEscritorCSV->adicionarArquivo("ANEXOS_LOA.pdf", "ANEXOS_LOA.pdf");
        $iVerifica=1;
      }
      if(file_exists("OPCAOSEMESTRALIDADE.pdf")){
        $oEscritorCSV->adicionarArquivo("OPCAOSEMESTRALIDADE.pdf", "OPCAOSEMESTRALIDADE.pdf");
        $iVerifica=1;
      }
      if(file_exists("DESOPCAOSEMESTRALIDADE.pdf")){
        $oEscritorCSV->adicionarArquivo("DESOPCAOSEMESTRALIDADE.pdf", "DESOPCAOSEMESTRALIDADE.pdf");
        $iVerifica=1;
      }
      if($iVerifica==1){
        $oEscritorCSV->zip("DOC_IP_{$sInst}_{$iAnoReferencia}");
        $oEscritorCSV = new padArquivoEscritorCSV();
      }

    	/*
       * instanciar cada arqivo selecionado e gerar o CSV correspondente
       */
      foreach ($oParam->arquivos as $sArquivo) {

        $sArquivoPath = "model/contabilidade/arquivos/sicom/".db_getsession('DB_anousu')."/SicomArquivo{$sArquivo}.model.php";

        if (file_exists($sArquivoPath)) {

          require_once($sArquivoPath);

          $sNomeClasse = "SicomArquivo{$sArquivo}";

          $oArquivo    = new $sNomeClasse;
          $oArquivo->setDataInicial($sDataInicial);
          $oArquivo->setDataFinal($sDataFinal);
          $oArquivo->setCodigoPespectiva($oParam->pespectivappa);

          try {

            $oArquivo->gerarDados();
            $oEscritorCSV->adicionarArquivo($oEscritorCSV->criarArquivo($oArquivo), $oArquivo->getNomeArquivo());

          } catch (Exception $eErro) {

            $oRetorno->status  = 2;
            $sGetMessage       = "Arquivo:{$oArquivo->getNomeArquivo()} retornou com erro: \\n \\n {$eErro->getMessage()}";
            $oRetorno->message = urlencode(str_replace("\\n", "\n",$sGetMessage));
          }
        }
      }

      if (count($oParam->arquivos) > 0) {
        $oEscritorCSV->zip("IP_{$sInst}_{$iAnoReferencia}");
        $oEscritorCSV->adicionarArquivo("tmp/IP_{$sInst}_{$iAnoReferencia}.zip", "IP_{$sInst}_{$iAnoReferencia}.zip");
      }

      if($iVerifica==1){
        $oEscritorCSV->adicionarArquivo("tmp/DOC_IP_{$sInst}_{$iAnoReferencia}.zip", "DOC_IP_{$sInst}_{$iAnoReferencia}.zip");
      }

      $oRetorno->itens = $oEscritorCSV->getListaArquivos();

      break;


      case "processarSicomMensal" :


      if (db_getsession("DB_anousu") >= 2014) {
    /*
     * Definindo o periodo em que serao selecionado os dados
     */
    $iUltimoDiaMes = date("d", mktime(0,0,0,$oParam->mesReferencia+1,0,db_getsession("DB_anousu")));
    $sDataInicial = db_getsession("DB_anousu")."-{$oParam->mesReferencia}-01";
    $sDataFinal   = db_getsession("DB_anousu")."-{$oParam->mesReferencia}-{$iUltimoDiaMes}";

    if (count($oParam->arquivos) > 0) {

    	$sSql  = "SELECT db21_codigomunicipoestado,cgc FROM db_config where codigo = ".db_getsession("DB_instit");

    	$rsInst = db_query($sSql);
    	$sInst  = str_pad(db_utils::fieldsMemory($rsInst, 0)->db21_codigomunicipoestado, 5, "0", STR_PAD_LEFT);
      $sInstCgc  = str_pad(db_utils::fieldsMemory($rsInst, 0)->cgc, 5, "0", STR_PAD_LEFT);
                                          //pmluislandia    pmsaoromao       prev. sao romao    pmvarzelandia   pmclarodospocoes  pmverdelandia
      $aCgcExtFonte = $arrayName = array('01612887000131', '24891418000102','06263590000121', '18017467000100','21498274000122','01612505000170');
      $iAnoReferencia = db_getsession('DB_anousu');

      $sSql  = "SELECT si09_codorgaotce AS codorgao
      FROM db_config
      LEFT JOIN infocomplementaresinstit ON si09_instit = codigo
      WHERE codigo = ".db_getsession("DB_instit");

      $rsOrgao = db_query($sSql);
      $sOrgao  = str_pad(db_utils::fieldsMemory($rsOrgao, 0)->codorgao, 2,"0",STR_PAD_LEFT);


      $sSqlExtFonte  = "select count(*) as exist from conextsaldo where ces01_anousu=".db_getsession("DB_anousu");
      $rsEXTFonte = db_query($sSqlExtFonte);
      $nEXTFonte  = db_utils::fieldsMemory($rsEXTFonte, 0)->exist;


      /*
       * array para adicionar os arquivos de inslusao de programas
       */
      $aArquivoProgramas =  array();

      /*
       * gerar arquivos correspondentes a todas as opcoes selecionadas
       */
      $oEscritorCSV          = new padArquivoEscritorCSV();
      $oEscritorProgramasCSV = new padArquivoEscritorCSV();

      /*
       * instanciar cada arqivo selecionado e gerar o CSV correspondente
       */
      $aArrayArquivos = array();

      foreach ($oParam->arquivos as $sArquivo) {
        if (db_getsession("DB_anousu") > 2016 && $sArquivo == "SuperavitFinanceiro") {
          continue;
        }
        if ( ($sArquivo == 'DetalhamentoExtraOrcamentarias' && in_array($sInstCgc, $aCgcExtFonte))
         || ($sArquivo == 'DetalhamentoExtraOrcamentarias' && $nEXTFonte > 0)  ){
          $sArquivo = "DetalhamentoExtraOrcamentariasPorFonte";
      }
      if (($sArquivo == 'SicomArquivoAnulacaoExtraOrcamentaria' && in_array($sInstCgc, $aCgcExtFonte))
       || ($sArquivo == 'SicomArquivoAnulacaoExtraOrcamentaria' && $nEXTFonte > 0) ){
        $sArquivo = 'SicomArquivoAnulacaoExtraOrcamentariaPorFonte';
    }

    if (file_exists("model/contabilidade/arquivos/sicom/mensal/".db_getsession("DB_anousu")."/SicomArquivo{$sArquivo}.model.php")) {

     require_once("model/contabilidade/arquivos/sicom/mensal/".db_getsession("DB_anousu")."/SicomArquivo{$sArquivo}.model.php");
     $sNomeClasse = "SicomArquivo{$sArquivo}";

     $oArquivo    = new $sNomeClasse;
     $oArquivo->setDataInicial($sDataInicial);
     $oArquivo->setDataFinal($sDataFinal);
     if ($sArquivo == "MetasFisicasRealizadas"){
      $oArquivo->setCodigoPespectiva($oParam->pespectivappa);
    }
    $oArquivoCsv = new stdClass();
    try {

     $oArquivo->gerarDados();
     $oArquivoCsv->nome    = "{$oArquivo->getNomeArquivo()}.csv";
     $oArquivoCsv->caminho = "{$oArquivo->getNomeArquivo()}.csv";
     $aArrayArquivos[] = $oArquivoCsv;
	          /*if ($sArquivo == "IdentificacaoRemessa" || $sArquivo == "ProgramasAnuais" || $sArquivo == "AcoesMetasAnuais") {

      	      $oEscritorProgramasCSV->adicionarArquivo($oEscritorProgramasCSV->criarArquivo($oArquivo), $oArquivo->getNomeArquivo());
      	      if ($sArquivo == "IdentificacaoRemessa") {
      	      	$oEscritorCSV->adicionarArquivo($oEscritorCSV->criarArquivo($oArquivo), $oArquivo->getNomeArquivo());
      	      }

      	    }else{
	              $oEscritorCSV->adicionarArquivo($oEscritorCSV->criarArquivo($oArquivo), $oArquivo->getNomeArquivo());
             }*/

           } catch (Exception $eErro) {

             $oRetorno->status  = 2;
             $sGetMessage       = "Arquivo:{$oArquivo->getNomeArquivo()} retornou com erro: \\n \\n {$eErro->getMessage()}";
             $oRetorno->message = urlencode(str_replace("\\n", "\n",$sGetMessage));

           }
         }
       }

      /*$oEscritorCSV->zip("AM_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}");
      $oEscritorCSV->adicionarArquivo("tmp/AM_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip", "AM_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip");
      $oEscritorProgramasCSV->zip("AIP_{$sInst}_{$iAnoReferencia}");
      $oEscritorProgramasCSV->adicionarArquivo("tmp/AIP_{$sInst}_{$iAnoReferencia}.zip", "AIP_{$sInst}_{$iAnoReferencia}.zip");*/

      $aListaArquivos = " ";
      foreach ($aArrayArquivos as $oArquivo){
        $aListaArquivos .= " ".$oArquivo->caminho;
      }
      //print_r($aListaArquivos);
      system("rm -f AM_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip");
      system("bin/zip -q AM_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip $aListaArquivos");

      $oArquivoZip = new stdClass();
      $oArquivoZip->nome    = "AM_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip";
      $oArquivoZip->caminho = "AM_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip";
      $aArrayArquivos[] = $oArquivoZip;

      $oRetorno->itens  = $aArrayArquivos;
    }

  } else {

    $iUltimoDiaMes = date("d", mktime(0,0,0,$oParam->mesReferencia+1,0,db_getsession("DB_anousu")));
    $sDataInicial = db_getsession("DB_anousu")."-{$oParam->mesReferencia}-01";
    $sDataFinal   = db_getsession("DB_anousu")."-{$oParam->mesReferencia}-{$iUltimoDiaMes}";

    if (count($oParam->arquivos) > 0) {

    	$sSql  = "SELECT db21_codigomunicipoestado FROM db_config where codigo = ".db_getsession("DB_instit");

    	$rsInst = db_query($sSql);
    	$sInst  = str_pad(db_utils::fieldsMemory($rsInst, 0)->db21_codigomunicipoestado, 5, "0", STR_PAD_LEFT);

      $iAnoReferencia = db_getsession('DB_anousu');

      $sSql  = "SELECT * FROM db_config ";
      $sSql .= "	WHERE prefeitura = 't'";

      $rsInst = db_query($sSql);
      $sCnpj  = db_utils::fieldsMemory($rsInst, 0)->cgc;

      $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomorgao.xml";
      if (!file_exists($sArquivo)) {
      	throw new Exception("Arquivo de configuracao dos orgaos do sicom inexistente!");
      }
      $sTextoXml    = file_get_contents($sArquivo);
      $oDOMDocument = new DOMDocument();
      $oDOMDocument->loadXML($sTextoXml);
      $oOrgaos      = $oDOMDocument->getElementsByTagName('orgao');

      /**
       * passar o codigo do orgao da instiruicao logada
       */

      foreach ($oOrgaos as $oOrgao) {

      	if ($oOrgao->getAttribute('instituicao') == db_getsession('DB_instit')) {
         $sOrgao = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);
       }

     }
     if (!isset($oOrgao)) {
      throw new Exception("Arquivo sem configuracao de Orgaos.");
    }

      /*
       * array para adicionar os arquivos de inslusao de programas
       */
      $aArquivoProgramas =  array();

      /*
       * gerar arquivos correspondentes a todas as opcoes selecionadas
       */
      $oEscritorCSV          = new padArquivoEscritorCSV();
      $oEscritorProgramasCSV = new padArquivoEscritorCSV();

      /*
       * instanciar cada arqivo selecionado e gerar o CSV correspondente
       */
      foreach ($oParam->arquivos as $sArquivo) {

       if (file_exists("model/contabilidade/arquivos/sicom/mensal/".db_getsession("DB_anousu")."/SicomArquivo{$sArquivo}.model.php")) {

         require_once("model/contabilidade/arquivos/sicom/mensal/".db_getsession("DB_anousu")."/SicomArquivo{$sArquivo}.model.php");
         $sNomeClasse = "SicomArquivo{$sArquivo}";

         $oArquivo    = new $sNomeClasse;
         $oArquivo->setDataInicial($sDataInicial);
         $oArquivo->setDataFinal($sDataFinal);
         try {

           $oArquivo->gerarDados();
           if ($sArquivo == "IdentificacaoRemessa" || $sArquivo == "ProgramasAnuais" || $sArquivo == "AcoesMetasAnuais") {

             $oEscritorProgramasCSV->adicionarArquivo($oEscritorProgramasCSV->criarArquivo($oArquivo), $oArquivo->getNomeArquivo());
             if ($sArquivo == "IdentificacaoRemessa") {
              $oEscritorCSV->adicionarArquivo($oEscritorCSV->criarArquivo($oArquivo), $oArquivo->getNomeArquivo());
            }

          }else{
           $oEscritorCSV->adicionarArquivo($oEscritorCSV->criarArquivo($oArquivo), $oArquivo->getNomeArquivo());
         }

       } catch (Exception $eErro) {

         $oRetorno->status  = 2;
         $sGetMessage       = "Arquivo:{$oArquivo->getNomeArquivo()} retornou com erro: \\n \\n {$eErro->getMessage()}";
         $oRetorno->message = urlencode(str_replace("\\n", "\n",$sGetMessage));

       }
     }
   }

   $oEscritorCSV->zip("AM_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}");
   $oEscritorCSV->adicionarArquivo("tmp/AM_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip", "AM_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip");
   $oEscritorProgramasCSV->zip("AIP_{$sInst}_{$iAnoReferencia}");
   $oEscritorProgramasCSV->adicionarArquivo("tmp/AIP_{$sInst}_{$iAnoReferencia}.zip", "AIP_{$sInst}_{$iAnoReferencia}.zip");
   $oRetorno->itens  = array_merge($oEscritorCSV->getListaArquivos(), $oEscritorProgramasCSV->getListaArquivos());
 }

}

break;

case "processarBalancete" :

    /*
     * Definindo o periodo em que serao selecionado os dados
     * Parametro de encerramento de exercicio.
     */
    $bEncerramento = false;

    if($oParam->mesReferencia == 13){
      $oParam->mesReferencia = 12;
      $bEncerramento = true;
    }
    $iUltimoDiaMes = date("d", mktime(0,0,0,$oParam->mesReferencia+1,0,db_getsession("DB_anousu")));
    $sDataInicial = db_getsession("DB_anousu")."-{$oParam->mesReferencia}-01";
    $sDataFinal   = db_getsession("DB_anousu")."-{$oParam->mesReferencia}-{$iUltimoDiaMes}";


    $deParaNatureza = $oParam->deParaNatureza;

    if (count($oParam->arquivos) > 0) {

      $sSql  = "SELECT db21_codigomunicipoestado FROM db_config where codigo = ".db_getsession("DB_instit");

      $rsInst = db_query($sSql);
      $sInst  = str_pad(db_utils::fieldsMemory($rsInst, 0)->db21_codigomunicipoestado, 5, "0", STR_PAD_LEFT);

      $iAnoReferencia = db_getsession('DB_anousu');

      $sSql  = "SELECT si09_codorgaotce AS codorgao
      FROM db_config
      LEFT JOIN infocomplementaresinstit ON si09_instit = codigo
      WHERE codigo = ".db_getsession("DB_instit");

      $rsOrgao = db_query($sSql);
      $sOrgao  = str_pad(db_utils::fieldsMemory($rsOrgao, 0)->codorgao, 2,"0",STR_PAD_LEFT);

      /*
       * array para adicionar os arquivos de inslusao de programas
       */
      $aArquivoProgramas =  array();

      /*
       * gerar arquivos correspondentes a todas as opcoes selecionadas
       */
      $oEscritorCSV          = new padArquivoEscritorCSV();
      $oEscritorProgramasCSV = new padArquivoEscritorCSV();

      /*
       * instanciar cada arqivo selecionado e gerar o CSV correspondente
       */
      $aArrayArquivos = array();
      foreach ($oParam->arquivos as $sArquivo) {

        if (file_exists("model/contabilidade/arquivos/sicom/mensal/balancete/".db_getsession("DB_anousu")."/SicomArquivo{$sArquivo}.model.php")) {

          require_once("model/contabilidade/arquivos/sicom/mensal/balancete/".db_getsession("DB_anousu")."/SicomArquivo{$sArquivo}.model.php");
          $sNomeClasse = "SicomArquivo{$sArquivo}";

          $oArquivo    = new $sNomeClasse;
          $oArquivo->setDataInicial($sDataInicial);
          $oArquivo->setDataFinal($sDataFinal);
          $oArquivo->setEncerramento($bEncerramento);
          $oArquivo->setDeParaNatureza($deParaNatureza);
          $oArquivoCsv = new stdClass();
          try {

            $oArquivo->gerarDados();
            $oArquivoCsv->nome    = "{$oArquivo->getNomeArquivo()}.csv";
            $oArquivoCsv->caminho = "{$oArquivo->getNomeArquivo()}.csv";
            $aArrayArquivos[] = $oArquivoCsv;

          } catch (Exception $eErro) {

            $oRetorno->status  = 2;
            $sGetMessage       = "Arquivo:{$oArquivo->getNomeArquivo()} retornou com erro: \\n \\n {$eErro->getMessage()}";
            $oRetorno->message = urlencode(str_replace("\\n", "\n",$sGetMessage));

          }
        }
      }

      /*$oEscritorCSV->zip("AM_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}");
      $oEscritorCSV->adicionarArquivo("tmp/AM_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip", "AM_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip");
      $oEscritorProgramasCSV->zip("AIP_{$sInst}_{$iAnoReferencia}");
      $oEscritorProgramasCSV->adicionarArquivo("tmp/AIP_{$sInst}_{$iAnoReferencia}.zip", "AIP_{$sInst}_{$iAnoReferencia}.zip");*/

      $aListaArquivos = " ";
      foreach ($aArrayArquivos as $oArquivo){
        $aListaArquivos .= " ".$oArquivo->caminho;
      }
      //print_r($aListaArquivos);
      system("rm -f BALANCETE_{$sInst}_{$sOrgao}_".($bEncerramento == true ? 13 : $oParam->mesReferencia)."_{$iAnoReferencia}.zip");
      system("bin/zip -q BALANCETE_{$sInst}_{$sOrgao}_".($bEncerramento == true ? 13 : $oParam->mesReferencia)."_{$iAnoReferencia}.zip $aListaArquivos");

      $oArquivoZip = new stdClass();
      $oArquivoZip->nome    = "BALANCETE_{$sInst}_{$sOrgao}_".($bEncerramento == true ? 13 : $oParam->mesReferencia)."_{$iAnoReferencia}.zip";
      $oArquivoZip->caminho = "BALANCETE_{$sInst}_{$sOrgao}_".($bEncerramento == true ? 13 : $oParam->mesReferencia)."_{$iAnoReferencia}.zip";
      $aArrayArquivos[] = $oArquivoZip;

      $oRetorno->itens  = $aArrayArquivos;
      if($bEncerramento)
        $oRetorno->calculos = getCalculoEncerramento();
      // var_dump($oRetorno);
    }


    break;

    case "processarPCA" :

    $sSql  = "SELECT db21_codigomunicipoestado,si09_tipoinstit,si09_codorgaotce FROM db_config left join infocomplementaresinstit on si09_instit = ".db_getsession("DB_instit");
    $rsInst = db_query($sSql);
    $sInst  = str_pad(db_utils::fieldsMemory($rsInst, 0)->db21_codigomunicipoestado, 5, "0", STR_PAD_LEFT);
    $iTipoInst  = db_utils::fieldsMemory($rsInst, 0)->si09_tipoinstit;
    $iCodOrgao  = str_pad(db_utils::fieldsMemory($rsInst, 0)->si09_codorgaotce, 2, "0", STR_PAD_LEFT);

    $iAnoReferencia = db_getsession('DB_anousu');

      /*
       * gerar arquivos correspondentes a todas as opcoes selecionadas
       */
      $oEscritorCSV          = new padArquivoEscritorCSV();

      /*
       * instanciar cada arqivo selecionado e gerar o CSV correspondente
       */

      foreach ($oParam->arquivos as $sArquivo) {


        if (file_exists("{$sArquivo}_{$iAnoReferencia}.pdf")) {

        	$oArquivoCsv          = new stdClass();
          $oArquivoCsv->nome    = "{$sArquivo}_{$iAnoReferencia}.pdf";
          $oArquivoCsv->caminho = "{$sArquivo}_{$iAnoReferencia}.pdf";
          $aArrayArquivos[] = $oArquivoCsv;

        } else {

          if($iTipoInst == 5 && $sArquivo == 'DRAA') {
              $oRetorno->status = 2;
              $sGetMessage = "Arquivo {$sArquivo}_{$iAnoReferencia}.pdf não encontrado. Envie este arquivo e tente novamente";
              $oRetorno->message = urlencode(str_replace("\\n", "\n", $sGetMessage));
          }

        }
      }

      $aListaArquivos = " ";
      foreach ($aArrayArquivos as $oArquivo){
        $aListaArquivos .= " ".$oArquivo->caminho;
      }
      //print_r($aListaArquivos);
      system("rm -f DCASP_DOC_{$oParam->tipoGeracao}_{$sInst}_{$iCodOrgao}_{$iAnoReferencia}.zip");
      system("bin/zip -q DCASP_DOC_{$oParam->tipoGeracao}_{$sInst}_{$iCodOrgao}_{$iAnoReferencia}.zip $aListaArquivos");
      //echo $aListaArquivos;
      $oArquivoZip = new stdClass();
      $oArquivoZip->nome    = "DCASP_DOC_{$oParam->tipoGeracao}_{$sInst}_{$iCodOrgao}_{$iAnoReferencia}.zip";
      $oArquivoZip->caminho = "DCASP_DOC_{$oParam->tipoGeracao}_{$sInst}_{$iCodOrgao}_{$iAnoReferencia}.zip";
      $aArrayArquivos[] = $oArquivoZip;

      $oRetorno->itens  = $aArrayArquivos;

      break;


      case "processarLCF" :

      $iUltimoDiaMes = date("d", mktime(0,0,0,$oParam->mesReferencia+1,0,db_getsession("DB_anousu")));
      $sDataInicial = db_getsession("DB_anousu")."-{$oParam->mesReferencia}-01";
      $sDataFinal   = db_getsession("DB_anousu")."-{$oParam->mesReferencia}-{$iUltimoDiaMes}";

      $sSql = "SELECT db21_codigomunicipoestado FROM db_config WHERE codigo = " . db_getsession('DB_instit');

      $rsInst = db_query($sSql);
      $sInst = str_pad(db_utils::fieldsMemory($rsInst, 0)->db21_codigomunicipoestado, 5, "0", STR_PAD_LEFT);

      $iAnoReferencia = db_getsession('DB_anousu');

      $oEscritorCSV = new padArquivoEscritorCSV();
    /**
     * Só vai gerar esses arquivos se os mesmos existirem
     */
    if (file_exists("LAO_{$iAnoReferencia}.pdf") || file_exists("LAOP_{$iAnoReferencia}.pdf")) {
      $oEscritorCSV->adicionarArquivo("LAO_{$iAnoReferencia}.pdf", "LAO_{$iAnoReferencia}.pdf");
      $oEscritorCSV->adicionarArquivo("LAOP_{$iAnoReferencia}.pdf", "LAOP_{$iAnoReferencia}.pdf");
    }
    if(isset($oParam->arquivos[0])) {
      /**
       * Nova lógica para gerar o DEC
       */
      /*
       * Sql que busca os decretos do mes
       */
      $sSqlDecretosMes = "select  distinct o39_codproj as codigovinc,
      '10' as tiporegistro,
      si09_codorgaotce as codorgao,
      o39_numero as nroDecreto,
      o39_data as dataDecreto,o39_tipoproj as tipodecreto
      from
      orcsuplem
      join orcsuplemval  on o47_codsup = o46_codsup
      join orcprojeto    on o46_codlei = o39_codproj
      join db_config on prefeitura  = 't'
      join orcsuplemlan on o49_codsup=o46_codsup and o49_data is not null
      left join infocomplementaresinstit on si09_instit = " . db_getsession("DB_instit") . "
      where o39_data between  '$sDataInicial' and '$sDataFinal'";
      $aDecretos = db_utils::getColectionByRecord(db_query($sSqlDecretosMes));

      require_once("model/contabilidade/arquivos/sicom/mensal/" . db_getsession("DB_anousu") . "/SicomArquivoLegislacaoCaraterFinanceiro.model.php");
      $oArquivo = new SicomArquivoLegislacaoCaraterFinanceiro;

      foreach ($aDecretos as $objDecretos) {

        /**
         * Para cada decreto:
         * 1. Gerar o PDF com o nome conforme o layout com o output para salvar o arquivo na pasta raiz do e-cidade
         * 2. Incluir esse pdf no EscritorCSV
         */

        $sNomeArquivo = "DEC_".trim(preg_replace("/[^0-9\s]/", "", $objDecretos->nrodecreto))."_".db_getsession("DB_anousu").".pdf";
        $oArquivo->gerarDecretoPdf($objDecretos->codigovinc, $sNomeArquivo);
        $oEscritorCSV->adicionarArquivo($sNomeArquivo, $sNomeArquivo);
      }
      /*
       * Fim Lógiga gerar o DEC
       */
    }
    $oEscritorCSV->zip("DECRETOSLEIS_{$sInst}_{$oParam->mesReferencia}_{$iAnoReferencia}");
    $oEscritorCSV->adicionarArquivo("tmp/DECRETOSLEIS_{$sInst}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip", "DECRETOSLEIS_{$sInst}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip");

    $oRetorno->itens = $oEscritorCSV->getListaArquivos();

    break;

    case "processarFlpgo" :

    /*
     * Definindo o periodo em que serao selecionado os dados
     * Parametro de encerramento de exercicio.
     */
    $bEncerramento = false;
    if($oParam->mesReferencia == 13){
      $oParam->mesReferencia = 12;
      $bEncerramento = true;
    }
    $iUltimoDiaMes = date("d", mktime(0,0,0,$oParam->mesReferencia+1,0,db_getsession("DB_anousu")));
    $sDataInicial = db_getsession("DB_anousu")."-{$oParam->mesReferencia}-01";
    $sDataFinal   = db_getsession("DB_anousu")."-{$oParam->mesReferencia}-{$iUltimoDiaMes}";
    if (count($oParam->arquivos) > 0) {
      $sSql  = "SELECT db21_codigomunicipoestado FROM db_config where codigo = ".db_getsession("DB_instit");
      $rsInst = db_query($sSql);
      $sInst  = str_pad(db_utils::fieldsMemory($rsInst, 0)->db21_codigomunicipoestado, 5, "0", STR_PAD_LEFT);
      $iAnoReferencia = db_getsession('DB_anousu');
      $sSql  = "SELECT si09_codorgaotce AS codorgao
      FROM db_config
      LEFT JOIN infocomplementaresinstit ON si09_instit = codigo
      WHERE codigo = ".db_getsession("DB_instit");
      $rsOrgao = db_query($sSql);
      $sOrgao  = str_pad(db_utils::fieldsMemory($rsOrgao, 0)->codorgao, 2,"0",STR_PAD_LEFT);
      echo pg_last_error();
      /*
       * array para adicionar os arquivos de inslusao de programas
       */
      $aArquivoProgramas =  array();
      /*
       * gerar arquivos correspondentes a todas as opcoes selecionadas
       */
      $oEscritorCSV          = new padArquivoEscritorCSV();
      $oEscritorProgramasCSV = new padArquivoEscritorCSV();
      /*
       * instanciar cada arqivo selecionado e gerar o CSV correspondente
       */
      $aArrayArquivos = array();

      foreach ($oParam->arquivos as $sArquivo) {
        if (file_exists("model/contabilidade/arquivos/sicom/mensal/flpg/".db_getsession("DB_anousu")."/SicomArquivo{$sArquivo}.model.php")) {
          require_once("model/contabilidade/arquivos/sicom/mensal/flpg/".db_getsession("DB_anousu")."/SicomArquivo{$sArquivo}.model.php");
          $sNomeClasse = "SicomArquivo{$sArquivo}";
          $oArquivo    = new $sNomeClasse;
          $oArquivo->setDataInicial($sDataInicial);
          $oArquivo->setDataFinal($sDataFinal);
          $oArquivo->setEncerramento($bEncerramento);
          $oArquivoCsv = new stdClass();
          try {
            $oArquivo->gerarDados();
            $oArquivoCsv->nome    = "{$oArquivo->getNomeArquivo()}.csv";
            $oArquivoCsv->caminho = "{$oArquivo->getNomeArquivo()}.csv";
            $aArrayArquivos[] = $oArquivoCsv;
            /*if ($sArquivo == "IdentificacaoRemessa" || $sArquivo == "ProgramasAnuais" || $sArquivo == "AcoesMetasAnuais") {
              $oEscritorProgramasCSV->adicionarArquivo($oEscritorProgramasCSV->criarArquivo($oArquivo), $oArquivo->getNomeArquivo());
              if ($sArquivo == "IdentificacaoRemessa") {
                $oEscritorCSV->adicionarArquivo($oEscritorCSV->criarArquivo($oArquivo), $oArquivo->getNomeArquivo());
              }
            }else{
                $oEscritorCSV->adicionarArquivo($oEscritorCSV->criarArquivo($oArquivo), $oArquivo->getNomeArquivo());
              }*/
            } catch (Exception $eErro) {
              $oRetorno->status  = 2;
              $sGetMessage       = "Arquivo:{$oArquivo->getNomeArquivo()} retornou com erro: \\n \\n {$eErro->getMessage()}";
              $oRetorno->message = urlencode(str_replace("\\n", "\n",$sGetMessage));
            }
          }
        }
      /*$oEscritorCSV->zip("AM_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}");
      $oEscritorCSV->adicionarArquivo("tmp/AM_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip", "AM_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip");
      $oEscritorProgramasCSV->zip("AIP_{$sInst}_{$iAnoReferencia}");
      $oEscritorProgramasCSV->adicionarArquivo("tmp/AIP_{$sInst}_{$iAnoReferencia}.zip", "AIP_{$sInst}_{$iAnoReferencia}.zip");*/
      $aListaArquivos = " ";
      foreach ($aArrayArquivos as $oArquivo){
        $aListaArquivos .= " ".$oArquivo->caminho;
      }
      //print_r($aListaArquivos);
      system("rm -f FLPG_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip");
      system("bin/zip -q FLPG_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip $aListaArquivos");
      $oArquivoZip = new stdClass();
      $oArquivoZip->nome    = "FLPG_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip";
      $oArquivoZip->caminho = "FLPG_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip";
      $aArrayArquivos[] = $oArquivoZip;
      $oRetorno->itens  = $aArrayArquivos;
    }
    break;

    case "processarDCASP" :
    /*
     * Definindo o periodo em que serao selecionado os dados
     * Sempre em dezembro
     */
    $oParam->mesReferencia = 12;

    $iUltimoDiaMes = date("d", mktime(0,0,0,$oParam->mesReferencia+1,0,db_getsession("DB_anousu")));
    $sDataInicial = db_getsession("DB_anousu")."-{$oParam->mesReferencia}-01";
    $sDataFinal   = db_getsession("DB_anousu")."-{$oParam->mesReferencia}-{$iUltimoDiaMes}";
    if (count($oParam->arquivos) > 0) {
      $sSql  = "SELECT db21_codigomunicipoestado FROM db_config where codigo = ".db_getsession("DB_instit");
      $rsInst = db_query($sSql);
      $sInst  = str_pad(db_utils::fieldsMemory($rsInst, 0)->db21_codigomunicipoestado, 5, "0", STR_PAD_LEFT);
      $iAnoReferencia = db_getsession('DB_anousu');
      $sSql  = "SELECT si09_codorgaotce AS codorgao
      FROM db_config
      LEFT JOIN infocomplementaresinstit ON si09_instit = codigo
      WHERE codigo = ".db_getsession("DB_instit");
      $rsOrgao = db_query($sSql);
      $sOrgao  = str_pad(db_utils::fieldsMemory($rsOrgao, 0)->codorgao, 2,"0",STR_PAD_LEFT);
      echo pg_last_error();
      /*
       * array para adicionar os arquivos de inslusao de programas
       */
      $aArquivoProgramas =  array();
      /*
       * gerar arquivos correspondentes a todas as opcoes selecionadas
       */
      $oEscritorCSV          = new padArquivoEscritorCSV();
      $oEscritorProgramasCSV = new padArquivoEscritorCSV();
      /*
       * instanciar cada arqivo selecionado e gerar o CSV correspondente
       */
      $aArrayArquivos = array();

      foreach ($oParam->arquivos as $sArquivo) {
        if (file_exists("model/contabilidade/arquivos/sicom/".db_getsession('DB_anousu')."/dcasp/SicomArquivo{$sArquivo}.model.php")) {
          require_once("model/contabilidade/arquivos/sicom/".db_getsession('DB_anousu')."/dcasp/SicomArquivo{$sArquivo}.model.php");
          $sNomeClasse = "SicomArquivo{$sArquivo}";
          $oArquivo    = new $sNomeClasse;
          $oArquivo->setDataInicial($sDataInicial);
          $oArquivo->setDataFinal($sDataFinal);

          $oArquivo->setTipoGeracao($oParam->tipoGeracao);

          $oArquivoCsv = new stdClass();
          try {
            $oArquivo->gerarDados();
            $oArquivoCsv->nome    = "{$oArquivo->getNomeArquivo()}.csv";
            $oArquivoCsv->caminho = "{$oArquivo->getNomeArquivo()}.csv";
            $aArrayArquivos[] = $oArquivoCsv;
          } catch (Exception $eErro) {
            $oRetorno->status  = 2;
            $sGetMessage       = "Arquivo:{$oArquivo->getNomeArquivo()} retornou com erro: \\n \\n {$eErro->getMessage()}";
            $oRetorno->message = urlencode(str_replace("\\n", "\n",$sGetMessage));
          }
        }
      }
      $aListaArquivos = " ";
      foreach ($aArrayArquivos as $oArquivo){
        $aListaArquivos .= " ".$oArquivo->caminho;
      }
      system("rm -f DCASP_{$oParam->tipoGeracao}_{$sInst}_{$sOrgao}_{$iAnoReferencia}.zip");
      system("bin/zip -q DCASP_{$oParam->tipoGeracao}_{$sInst}_{$sOrgao}_{$iAnoReferencia}.zip $aListaArquivos");
      $oArquivoZip = new stdClass();
      $oArquivoZip->nome    = "DCASP_{$oParam->tipoGeracao}_{$sInst}_{$sOrgao}_{$iAnoReferencia}.zip";
      $oArquivoZip->caminho = "DCASP_{$oParam->tipoGeracao}_{$sInst}_{$sOrgao}_{$iAnoReferencia}.zip";
      $aArrayArquivos[] = $oArquivoZip;
      $oRetorno->itens  = $aArrayArquivos;
    }
    break;

  	case "processarEditais" :

    	if (count($oParam->arquivos) > 0) {

      		$sSql  = "SELECT db21_codigomunicipoestado FROM db_config where codigo = ".db_getsession("DB_instit");

			$rsInst = db_query($sSql);
			$iMunicipio  = str_pad(db_utils::fieldsMemory($rsInst, 0)->db21_codigomunicipoestado, 5, "0", STR_PAD_LEFT);

			$iAnoReferencia = db_getsession('DB_anousu');

			$sSql  = "SELECT si09_codorgaotce AS codorgao
			FROM db_config
			LEFT JOIN infocomplementaresinstit ON si09_instit = codigo
			WHERE codigo = ".db_getsession("DB_instit");

			$rsOrgao = db_query($sSql);

			$sOrgao  = str_pad(db_utils::fieldsMemory($rsOrgao, 0)->codorgao, 2,"0",STR_PAD_LEFT);

			/*
			* array para adicionar os arquivos de inslusao de programas
			*/
			$aArquivoProgramas =  array();

			/*
			* gerar arquivos correspondentes a todas as opcoes selecionadas
			*/
			$oEscritorCSV          = new padArquivoEscritorCSV();
			$oEscritorProgramasCSV = new padArquivoEscritorCSV();

			/*
			* instanciar cada arqivo selecionado e gerar o CSV correspondente
			*/
			$aArrayArquivos = array();
			$sDataFinal = $oParam->diaReferencia;

			foreach ($oParam->arquivos as $sArquivo) {

				if (file_exists("model/contabilidade/arquivos/sicom/mensal/edital/".db_getsession("DB_anousu")."/SicomArquivo{$sArquivo}.model.php")) {

					require_once("model/contabilidade/arquivos/sicom/mensal/edital/".db_getsession("DB_anousu")."/SicomArquivo{$sArquivo}.model.php");
					$sNomeClasse = "SicomArquivo{$sArquivo}";

					$oArquivo    = new $sNomeClasse;
					$oArquivo->setDataFinal($sDataFinal);

					$oArquivoCsv = new stdClass();

					try {

						$oArquivo->gerarDados();
						$oArquivoCsv->nome    = "{$oArquivo->getNomeArquivo()}.csv";
						$oArquivoCsv->caminho = "{$oArquivo->getNomeArquivo()}.csv";
						$aArrayArquivos[] = $oArquivoCsv;
						$aArrayArquivosZip[] = $oArquivoCsv;

					} catch (Exception $eErro) {

						$oRetorno->status  = 2;
						$sGetMessage       = "Arquivo:{$oArquivo->getNomeArquivo()} retornou com erro: \\n \\n {$eErro->getMessage()}";
						$oRetorno->message = urlencode(str_replace("\\n", "\n",$sGetMessage));
					}
				}
			}
			if(in_array('ResumoAberturaLicitacao', $oParam->arquivos) || in_array('ResumoDispensaInexigibilidade', $oParam->arquivos)) {
				/*    Consulta os arquivos anexos */
				$dia = join('-', array_reverse(explode('/', $oParam->diaReferencia)));
				$sSql = "
					SELECT l47_dataenvio AS dataenvio,
						   editaldocumentos.l48_caminho AS caminho,
						   editaldocumentos.l48_tipo as tipo,
						   editaldocumentos.l48_sequencial as sequencial,
						   liclicita.l20_edital AS nroprocesso,
						   (CASE
								WHEN liclicita.l20_exercicioedital IS NULL
									THEN EXTRACT(YEAR FROM l20_datacria)
									ELSE l20_exercicioedital
							END )AS exercicio,
						   pctipocompratribunal.l44_sequencial AS tipo_tribunal,
						   pctipocompratribunal.l44_codigotribunal AS tipoProcesso,
						       (SELECT CASE
									WHEN o41_subunidade != 0
										 OR NOT NULL THEN lpad((CASE
																	WHEN o40_codtri = '0'
																		 OR NULL THEN o40_orgao::varchar
																	ELSE o40_codtri
																END),2,0)||lpad((CASE
																					 WHEN o41_codtri = '0'
																						  OR NULL THEN o41_unidade::varchar
																					 ELSE o41_codtri
																				 END),3,0)||lpad(o41_subunidade::integer,3,0)
									ELSE lpad((CASE
												   WHEN o40_codtri = '0'
														OR NULL THEN o40_orgao::varchar
												   ELSE o40_codtri
											   END),2,0)||lpad((CASE
																	WHEN o41_codtri = '0'
																		 OR NULL THEN o41_unidade::varchar
																	ELSE o41_codtri
																END),3,0)
								END AS codunidadesubresp
						 FROM db_departorg
						 JOIN infocomplementares ON si08_anousu = db01_anousu
						 AND si08_instit = ".db_getsession('DB_instit')."
						 JOIN orcunidade ON db01_orgao=o41_orgao
						 AND db01_unidade=o41_unidade
						 AND db01_anousu = o41_anousu
						 JOIN orcorgao ON o40_orgao = o41_orgao
						 AND o40_anousu = o41_anousu
						 WHERE db01_coddepto=l20_codepartamento
							 AND db01_anousu = ".db_getsession('DB_anousu')."
						 LIMIT 1) AS unidade
					FROM liclancedital
					INNER JOIN editaldocumentos ON editaldocumentos.l48_liclicita = liclancedital.l47_liclicita
					INNER JOIN liclicita ON liclicita.l20_codigo = l47_liclicita
					INNER JOIN cflicita ON l03_codigo = liclicita.l20_codtipocom
					INNER JOIN db_config ON db_config.codigo = cflicita.l03_instit
					INNER JOIN pctipocompra ON pctipocompra.pc50_codcom = cflicita.l03_codcom
					INNER JOIN pctipocompratribunal ON pctipocompratribunal.l44_sequencial = cflicita.l03_pctipocompratribunal
					WHERE liclancedital.l47_dataenvio = '$dia'
				";

				$rsAnexos = db_query($sSql);

				$aListaAnexos = " ";

				if(!pg_num_rows($rsAnexos)){
					$oRetorno->erro = urlencode('Não há registros a serem gerados para a data informada!');
					break;
				}

				for ($cont = 0; $cont < pg_num_rows($rsAnexos); $cont++) {
					$oAnexo = db_utils::fieldsMemory($rsAnexos, $cont);

					if(in_array($oAnexo->tipo_tribunal, array(100, 101, 102, 103, 106))){
						$novoNome = 'DISPENSA_';
						$tipoProcesso = '_'.$oAnexo->tipoprocesso;
					}else{
						$novoNome = 'EDITAL_';
						$tipoProcesso = '';
					}

					switch ($oAnexo->tipo) {
						case 'mc':
							$novoNome .= 'MINUTA_CONTRATO_';
							break;
						case 'po':
							$novoNome .= 'PLANILHA_ORCAMENTARIA_';
							break;
						case 'cr':
							$novoNome .= 'CRONOGRAMA_';
							break;
						case 'cb':
							$novoNome .= 'COMPOSICAO_BDI_';
							break;
						case 'fl':
							$novoNome .= 'FOTO_LOCAL_';
							break;
					}
					$valores = explode('/', $oAnexo->caminho);
					$nomeArq = $valores[5] != null ? $valores[5] : $valores[4];
					$extensao = explode('.', $nomeArq);
					$unidade = $oAnexo->unidade != '' ? $oAnexo->unidade : '0';
					$novoNome .= "{$iMunicipio}_{$sOrgao}_{$unidade}_{$oAnexo->exercicio}_{$oAnexo->nroprocesso}{$tipoProcesso}.$extensao[1]";
					$aListaAnexos .= $novoNome . ' ';
					system("cp {$oAnexo->caminho} ./{$novoNome}");
				}

				$ano = explode('/', $oParam->diaReferencia);
				$mesReferencia = $ano[1];

				if(trim($aListaAnexos)){
					system("rm -f EDITAL_TERMO_{$iMunicipio}_{$sOrgao}_{$mesReferencia}_{$iAnoReferencia}.zip");

					system("bin/zip -q EDITAL_TERMO_{$iMunicipio}_{$sOrgao}_{$mesReferencia}_{$iAnoReferencia}.zip $aListaAnexos");

					$aAnexos = explode(' ', $aListaAnexos);

					foreach ($aAnexos as $arquivo) {
						unlink($arquivo);
					}

					$oArquivoZipAnexo = new stdClass();
					$oArquivoZipAnexo->nome = "EDITAL_TERMO_{$iMunicipio}_{$sOrgao}_{$mesReferencia}_{$iAnoReferencia}.zip";
					$oArquivoZipAnexo->caminho = "EDITAL_TERMO_{$iMunicipio}_{$sOrgao}_{$mesReferencia}_{$iAnoReferencia}.zip";
					$aArrayArquivosZip[] = $oArquivoZipAnexo;
				}
			}
			$aListaArquivos = " ";
			foreach ($aArrayArquivos as $oArquivo){
				$aListaArquivos .= " ".$oArquivo->caminho;
			}

			system("rm -f EDITAL_{$iMunicipio}_{$sOrgao}_{$mesReferencia}_{$iAnoReferencia}.zip");
			system("bin/zip -q EDITAL_{$iMunicipio}_{$sOrgao}_{$mesReferencia}_{$iAnoReferencia}.zip $aListaArquivos");

			$oArquivoZip = new stdClass();
			$oArquivoZip->nome    = "EDITAL_{$iMunicipio}_{$sOrgao}_{$mesReferencia}_{$iAnoReferencia}.zip";
			$oArquivoZip->caminho = "EDITAL_{$iMunicipio}_{$sOrgao}_{$mesReferencia}_{$iAnoReferencia}.zip";

			$aArrayArquivosZip[] = $oArquivoZip;

			$oRetorno->itens  = $aArrayArquivosZip;

		}

    break;

  }

  echo $oJson->encode($oRetorno);

/**
 * Calculos do Encerramento do Balancete
 */

function getCalculoEncerramento(){

  $sSqlEncerramento = "SELECT si177_contacontaabil,
  si177_totaldebitos,
  si177_totalcreditos,
  si177_saldofinal,
  si177_naturezasaldofinal
  FROM balancete10".db_getsession('DB_anousu')."
  WHERE si177_mes = 13";

  // print_r($sSqlEncerramento);
  $rsSqlEncerramento = db_query($sSqlEncerramento) or die(pg_last_error());
  $aEncerramentos = db_utils::getColectionByRecord($rsSqlEncerramento);

  foreach ($aEncerramentos as $objEncerramento) {
    /**
     * Subfluxo saldos de ativo e passivo
     * Verificar se o somatório do saldo final das contas do Ativo (primeiro dígito igual a 1)
     * é igual ao somatório do saldo final das contas do Passivo (primeiro dígito igual a 2),
     * seguindo os passos:
     */

    /*
     * Etapa 1 ? Filtros a serem utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas onde o primeiro dígito seja 1.
     */
    if (substr($objEncerramento->si177_contacontaabil, 0, 1) == "1") {
      /*
       * Obter o somatório dos valores informados no campo saldoFinal das contas de natureza devedora
       * (campo naturezaSaldoFinal igual a ?D ? Natureza devedora?) e armazenar em ?Total Devedor Ativo?
       *
       * Obter o somatório dos valores informados no campo saldoFinal das contas de natureza credora
       * (campo naturezaSaldoFinal igual a ?C ? Natureza credora?) e armazenar em ?Total Credor Ativo?.
       */
      if ($objEncerramento->si177_naturezasaldofinal == "D") {
        $nTotalDevedorAtivo += $objEncerramento->si177_saldofinal;
      } else {
        $nTotalCredorAtivo += $objEncerramento->si177_saldofinal;
      }

      /*
       * Obter o ?Total Ativo? por meio da seguinte operação: ?Total Devedor? (-) ?Total Credor?.
       */
      $nTotalAtivo = $nTotalDevedorAtivo - $nTotalCredorAtivo;

    } elseif (substr($objEncerramento->si177_contacontaabil, 0, 1) == "2") {

      /*
       * Obter o somatório dos valores informados no campo saldoFinal das contas de natureza devedora
       * (campo naturezaSaldoFinal igual a ?D ? Natureza devedora?) e armazenar em ?Total Devedor Passivo?
       *
       * Obter o somatório dos valores informados no campo saldoFinal das contas de natureza credora
       * (campo naturezaSaldoFinal igual a ?C ? Natureza credora?) e armazenar em ?Total Credor Passivo?.
       */
      if ($objEncerramento->si177_naturezasaldofinal == "D") {
        $nTotalDevedorPassivo += $objEncerramento->si177_saldofinal;
      } else {
        $nTotalCredorPassivo += $objEncerramento->si177_saldofinal;
      }

      /*
       * Obter o ?Total Passivo? por meio da seguinte operação: ?Total Devedor? (-) ?Total Credor?.
       */
      $nTotalPassivo = $nTotalDevedorPassivo - $nTotalCredorPassivo;

    } elseif (substr($objEncerramento->si177_contacontaabil, 0, 1) == "3" || substr($objEncerramento->si177_contacontaabil, 0, 1) == "4" && substr($objEncerramento->si177_contacontaabil, 0, 5) == "1") {
      /**
       *  Subfluxo validar encerramento das variações patrimoniais aumentativas e diminutivas
       * 1. Total de débitos e créditos das classes 3 e 4 igual ao total de débitos e créditos
       * das contas de apuração do resultado do exercício ? Consolidação
       */

      /* Etapa 1 ? Filtros utilizados: Filtrar pelo campo contaContábil obtendo apenas as
       * contas onde o primeiro dígito seja igual a 3 e 4 e o quinto digito igual a 1.
       */
      //Obter o somatório dos valores informados no campo totalDebitos e armazena em ?Total Débitos VP?.
      $nTotalDebitosVP += $objEncerramento->si177_totaldebitos;
      //Obter o somatório dos valores informados no campo totalCreditos e armazena em ?Total Créditos VP?.
      $nTotalCreditosVP += $objEncerramento->si177_totalcreditos;

    } elseif ($objEncerramento->si177_contacontaabil == "237110100" || $objEncerramento->si177_contacontaabil == "237210100") {
      /**
       * Etapa 2 ? Filtros utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas 2.3.7.1.1.01.00 e 2.3.7.2.1.01.00.
       */

      //Obter o somatório dos valores informados no campo totalDebitos e armazena em ?Total Débitos Resultado ?.
      $nTotalDebitosResultado += $objEncerramento->si177_totaldebitos;
      //Obter o somatório dos valores informados no campo totalCreditos e armazena em ?Total Créditos Resultado?.
      $nTotalCreditosResultado += $objEncerramento->si177_totalcreditos;

    } elseif (substr($objEncerramento->si177_contacontaabil, 0, 1) == "3" || substr($objEncerramento->si177_contacontaabil, 0, 1) == "4" && substr($objEncerramento->si177_contacontaabil, 0, 5) == "2") {
      /**
       * Verificar se para as contas iniciadas com 3 e 4 onde o quinto digito é igual a 2,
       * o total de débitos é igual ao total de créditos das contas 2.3.7.1.2.01.00 e 2.3.7.2.2.01.00,
       * e o total de créditos é igual ao total de débitos das contas 2.3.7.1.2.01.00 e 2.3.7.2.2.01.00, seguindo os passos:
       * Etapa 1 ? Filtros utilizados: Filtrar pelo campo contaContábil
       * obtendo apenas as contas onde o primeiro dígito seja igual a 3 e 4 e o quinto digito igual a 2.
       */
      //Obter o somatório dos valores informados no campo totalDebitos e armazena em ?Total Débitos VP2?.
      $nTotalDebitosVP2 += $objEncerramento->si177_totaldebitos;
      //Obter o somatório dos valores informados no campo totalCreditos e armazena em ?Total Créditos VP2?.
      $nTotalCreditosVP2 += $objEncerramento->si177_totalcreditos;
    } elseif ($objEncerramento->si177_contacontaabil == "237120100" || $objEncerramento->si177_contacontaabil == "237220100") {
      /**
       * Etapa 2 ? Filtros utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas 2.3.7.1.2.01.00 e 2.3.7.2.2.01.00.
       */

      //Obter o somatório dos valores informados no campo totalDebitos e armazena em ?Total Débitos Resultado2 ?.
      $nTotalDebitosResultado2 += $objEncerramento->si177_totaldebitos;
      //Obter o somatório dos valores informados no campo totalCreditos e armazena em ?Total Créditos Resultado2?.
      $nTotalCreditosResultado2 += $objEncerramento->si177_totalcreditos;

    } elseif (substr($objEncerramento->si177_contacontaabil, 0, 1) == "3" || substr($objEncerramento->si177_contacontaabil, 0, 1) == "4" && substr($objEncerramento->si177_contacontaabil, 0, 5) == "3") {
      /**
       * 3.1. Validação: Verificar se para as contas iniciadas com 3 e 4 onde o quinto digito é igual a 3,
       * o total de débitos é igual ao total de créditos das contas 2.3.7.1.3.01.00 e 2.3.7.2.3.01.00,
       * e o total de créditos é igual ao total de débitos das contas 2.3.7.1.3.01.00 e 2.3.7.2.3.01.00, seguindo os passos:
       * Etapa 1 ? Filtros utilizados: Filtrar pelo campo contaContábil
       * obtendo apenas as contas onde o primeiro dígito seja igual a 3 e 4 e o quinto digito igual a 3.
       */
      //Obter o somatório dos valores informados no campo totalDebitos e armazena em ?Total Débitos VP3?.
      $nTotalDebitosVP3 += $objEncerramento->si177_totaldebitos;
      //Obter o somatório dos valores informados no campo totalCreditos e armazena em ?Total Créditos VP3?.
      $nTotalCreditosVP3 += $objEncerramento->si177_totalcreditos;
    } elseif ($objEncerramento->si177_contacontaabil == "237130100" || $objEncerramento->si177_contacontaabil == "237230100") {
      /**
       * Etapa 2 ? Filtros utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas 2.3.7.1.3.01.00 e 2.3.7.2.3.01.00.
       */

      //Obter o somatório dos valores informados no campo totalDebitos e armazena em ?Total Débitos Resultado3 ?.
      $nTotalDebitosResultado3 += $objEncerramento->si177_totaldebitos;
      //Obter o somatório dos valores informados no campo totalCreditos e armazena em ?Total Créditos Resultado3?.
      $nTotalCreditosResultado3 += $objEncerramento->si177_totalcreditos;

    } elseif (substr($objEncerramento->si177_contacontaabil, 0, 1) == "3" || substr($objEncerramento->si177_contacontaabil, 0, 1) == "4" && substr($objEncerramento->si177_contacontaabil, 0, 5) == "4") {
      /**
       * 3.1. Validação: Verificar se para as contas iniciadas com 3 e 4 onde o quinto digito é igual a 4,
       * o total de débitos é igual ao total de créditos das contas 2.3.7.1.3.01.00 e 2.3.7.2.3.01.00,
       * e o total de créditos é igual ao total de débitos das contas 2.3.7.1.3.01.00 e 2.3.7.2.3.01.00, seguindo os passos:
       * Etapa 1 ? Filtros utilizados: Filtrar pelo campo contaContábil
       * obtendo apenas as contas onde o primeiro dígito seja igual a 3 e 4 e o quinto digito igual a 4.
       */
      //Obter o somatório dos valores informados no campo totalDebitos e armazena em ?Total Débitos VP4?.
      $nTotalDebitosVP4 += $objEncerramento->si177_totaldebitos;
      //Obter o somatório dos valores informados no campo totalCreditos e armazena em ?Total Créditos VP4?.
      $nTotalCreditosVP4 += $objEncerramento->si177_totalcreditos;
    } elseif ($objEncerramento->si177_contacontaabil == "237140100" || $objEncerramento->si177_contacontaabil == "237240100") {
      /**
       * Etapa 2 ? Filtros utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas 2.3.7.1.3.01.00 e 2.3.7.2.3.01.00.
       */

      //Obter o somatório dos valores informados no campo totalDebitos e armazena em ?Total Débitos Resultado4 ?.
      $nTotalDebitosResultado4 += $objEncerramento->si177_totaldebitos;
      //Obter o somatório dos valores informados no campo totalCreditos e armazena em ?Total Créditos Resultado4?.
      $nTotalCreditosResultado4 += $objEncerramento->si177_totalcreditos;

    } elseif (substr($objEncerramento->si177_contacontaabil, 0, 1) == "3" || substr($objEncerramento->si177_contacontaabil, 0, 1) == "4" && substr($objEncerramento->si177_contacontaabil, 0, 5) == "5") {
      /**
       * 3.1. Validação: Verificar se para as contas iniciadas com 3 e 4 onde o quinto digito é igual a 5,
       * o total de débitos é igual ao total de créditos das contas 2.3.7.1.3.01.00 e 2.3.7.2.3.01.00,
       * e o total de créditos é igual ao total de débitos das contas 2.3.7.1.3.01.00 e 2.3.7.2.3.01.00, seguindo os passos:
       * Etapa 1 ? Filtros utilizados: Filtrar pelo campo contaContábil
       * obtendo apenas as contas onde o primeiro dígito seja igual a 3 e 4 e o quinto digito igual a 5.
       */
      //Obter o somatório dos valores informados no campo totalDebitos e armazena em ?Total Débitos VP5?.
      $nTotalDebitosVP5 += $objEncerramento->si177_totaldebitos;
      //Obter o somatório dos valores informados no campo totalCreditos e armazena em ?Total Créditos VP5?.
      $nTotalCreditosVP5 += $objEncerramento->si177_totalcreditos;
    } elseif ($objEncerramento->si177_contacontaabil == "237150100" || $objEncerramento->si177_contacontaabil == "237250100") {
      /**
       * Etapa 2 ? Filtros utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas 2.3.7.1.3.01.00 e 2.3.7.2.3.01.00.
       */

      //Obter o somatório dos valores informados no campo totalDebitos e armazena em ?Total Débitos Resultado5 ?.
      $nTotalDebitosResultado5 += $objEncerramento->si177_totaldebitos;
      //Obter o somatório dos valores informados no campo totalCreditos e armazena em ?Total Créditos Resultado5?.
      $nTotalCreditosResultado5 += $objEncerramento->si177_totalcreditos;

    }
  }
  $nTotalAtivo   = number_format(abs($nTotalAtivo),2,",",".");
  $nTotalPassivo = number_format(abs($nTotalPassivo),2,",",".");
  $nTotalDebitosVP = number_format(abs($nTotalDebitosVP),2,",",".");
  $nTotalCreditosResultado = number_format(abs($nTotalCreditosResultado),2,",",".");
  $nTotalCreditosVP = number_format(abs($nTotalCreditosVP),2,",",".");
  $nTotalDebitosResultado = number_format(abs($nTotalDebitosResultado),2,",",".");
  $nTotalDebitosVP2 = number_format(abs($nTotalDebitosVP2),2,",",".");
  $nTotalCreditosResultado2 = number_format(abs($nTotalCreditosResultado2),2,",",".");
  $nTotalCreditosVP2 = number_format(abs($nTotalCreditosVP2),2,",",".");
  $nTotalDebitosResultado2 = number_format(abs($nTotalDebitosResultado2),2,",",".");
  $nTotalDebitosVP3 = number_format(abs($nTotalDebitosVP3),2,",",".");
  $nTotalCreditosResultado3 = number_format(abs($nTotalCreditosResultado3),2,",",".");
  $nTotalCreditosVP3 = number_format(abs($nTotalCreditosVP3),2,",",".");
  $nTotalDebitosResultado3 = number_format(abs($nTotalDebitosResultado3),2,",",".");
  $nTotalDebitosVP4 = number_format(abs($nTotalDebitosVP4),2,",",".");
  $nTotalCreditosResultado4 = number_format(abs($nTotalCreditosResultado4),2,",",".");
  $nTotalCreditosVP4 = number_format(abs($nTotalCreditosVP4),2,",",".");
  $nTotalDebitosResultado4 = number_format(abs($nTotalDebitosResultado4),2,",",".");
  $nTotalDebitosVP5 = number_format(abs($nTotalDebitosVP5),2,",",".");
  $nTotalCreditosResultado5 = number_format(abs($nTotalCreditosResultado5),2,",",".");
  $nTotalCreditosVP5 = number_format(abs($nTotalCreditosVP5),2,",",".");
  $nTotalDebitosResultado5 = number_format(abs($nTotalDebitosResultado5),2,",",".");

  $aRetorno = array();

  if($nTotalAtivo != $nTotalPassivo){
    array_push($aRetorno,array("mensagem" => "ME714_CLS_1_2_SLD_FINAL_INCONSIST", "calculo" => "Total Ativo: {$nTotalAtivo} - Total Passivo: {$nTotalPassivo} = ".$nTotalAtivo-$nTotalPassivo,
      "regras" => "<p>1. Saldo final do Ativo igual ao saldo final do Passivo após o encerramento do balancete.<br>
      1.1. Validação: Verificar se o somatório do saldo final das contas do Ativo (primeiro dígito igual a 1) é igual ao somatório do saldo final das contas do Passivo (primeiro dígito igual a 2), seguindo os passos:<br><br>
      Registro a ser utilizado: '10 - Balancete Contábil'.<br><br>
      Etapa 1 - Filtros a serem utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas onde o primeiro dígito seja 1.<br>
      Obter o somatório dos valores informados no campo saldoFinal das contas de natureza devedora (campo naturezaSaldoFinal igual a 'D - Natureza devedora') e armazenar em 'Total Devedor'.<br>
      Obter o somatório dos valores informados no campo saldoFinal das contas de natureza credora (campo naturezaSaldoFinal igual a 'C - Natureza credora') e armazenar em 'Total Credor'.<br><br>
      Obter o 'Total Ativo' por meio da seguinte operação: 'Total Devedor' (-) 'Total Credor'.<br>
      Etapa 2 - Filtros a serem utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas onde o primeiro dígito seja 2.<br>
      Obter o somatório dos valores informados no campo saldoFinal das contas de natureza credora (campo naturezaSaldoFinal igual a 'C - Natureza credora') e armazenar em 'Total Credor'.<br>
      Obter o somatório dos valores informados no campo saldoFinal das contas de natureza devedora (campo naturezaSaldoFinal igual a 'D - Natureza devedora') e armazenar em 'Total Devedor'.<br>
      Obter o 'Total Passivo' por meio da seguinte operação: 'Total Credor' (-) 'Total Devedor'.<br>
      Comparar 'Total Ativo' com 'Total Passivo'.<br>
      1.2. Mensagem: ME714_CLS_1_2_SLD_FINAL_INCONSIST.</p>"));
  }

  if($nTotalDebitosVP != $nTotalCreditosResultado){
    array_push($aRetorno,array("mensagem"=>"ME757_DEBITOSVP_TOTAL_INCONSISTENTE", "calculo" => "Total Debitos VP: {$nTotalDebitosVP} Total Creditos Resultado: {$nTotalCreditosResultado}",
      "regras"=>"<p>1. Total de débitos e créditos das classes 3 e 4 igual ao total de débitos e créditos das contas de apuração do resultado do exercício - Consolidação.<br>
      1.1. Validação: Verificar se para as contas iniciadas com 3 e 4 onde o quinto digito é igual a 1 o total de débitos é igual ao total de créditos das contas 2.3.7.1.1.01.00 e 2.3.7.2.1.01.00, e o total de créditos é igual ao total de débitos das contas 2.3.7.1.1.01.00 e 2.3.7.2.1.01.00, seguindo os passos:<br><br>

      Registro a ser utilizado: '10 - Balancete Contábil'.<br>
      Etapa 1 - Filtros utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas onde o primeiro dígito seja igual a 3 e 4 e o quinto digito igual a 1.<br>
      Obter o somatório dos valores informados no campo totalDebitos e armazena em 'Total Débitos VP'.<br>
      Obter o somatório dos valores informados no campo totalCreditos e armazena em 'Total Créditos VP'.<br><br>

      Etapa 2 - Filtros utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas 2.3.7.1.1.01.00 e 2.3.7.2.1.01.00.<br>
      Obter o somatório dos valores informados no campo totalDebitos e armazena em 'Total Débitos Resultado '.<br>
      Obter o somatório dos valores informados no campo totalCreditos e armazena em 'Total Créditos Resultado'.<br><br>

      Etapa 3 - O 'Total Débitos VP' deve ser igual ao 'Total Créditos Resultado'.<br>
      1.1.1. Mensagem: ME757_DEBITOSVP_TOTAL_INCONSISTENTE.<br><br>

      O 'Total Créditos VP' deve ser igual ao 'Total Débito Resultado'.<br>
      1.1.2. Mensagem: ME758_CREDITOSVP_TOTAL_INCONSISTENTE.</p>"));
  }

  if($nTotalCreditosVP != $nTotalDebitosResultado){
    array_push($aRetorno,array("mensagem"=>"ME758_CREDITOSVP_TOTAL_INCONSISTENTE","calculo" => "Total Creditos VP: {$nTotalCreditosVP} Total Debitos Resultado: {$nTotalDebitosResultado}",
      "regras"=>utf8_encode("<p>1. Total de débitos e créditos das classes 3 e 4 igual ao total de débitos e créditos das contas de apuração do resultado do exercício - Consolidação.<br>
        1.1. Validação: Verificar se para as contas iniciadas com 3 e 4 onde o quinto digito é igual a 1<br>
        o total de débitos é igual ao total de créditos das contas 2.3.7.1.1.01.00 e 2.3.7.2.1.01.00, e o total
        de créditos é igual ao total de débitos das contas 2.3.7.1.1.01.00 e 2.3.7.2.1.01.00, seguindo os passos:<br><br>

        Registro a ser utilizado: '10 - Balancete Contábil'.<br>
        Etapa 1 - Filtros utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas onde o primeiro dígito seja igual a 3 e 4 e o quinto digito igual a 1.<br>
        Obter o somatório dos valores informados no campo totalDebitos e armazena em 'Total Débitos VP'.<br>
        Obter o somatório dos valores informados no campo totalCreditos e armazena em 'Total Créditos VP'.<br><br>

        Etapa 2 - Filtros utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas 2.3.7.1.1.01.00 e 2.3.7.2.1.01.00.<br>
        Obter o somatório dos valores informados no campo totalDebitos e armazena em 'Total Débitos Resultado'.<br>
        Obter o somatório dos valores informados no campo totalCreditos e armazena em 'Total Créditos Resultado'.<br><br>

        Etapa 3 - O 'Total Débitos VP' deve ser igual ao 'Total Créditos Resultado'.<br>
        1.1.1. Mensagem: ME757_DEBITOSVP_TOTAL_INCONSISTENTE.<br><br>

        O 'Total Créditos VP' deve ser igual ao 'Total Débito Resultado'.<br>
        1.1.2. Mensagem: ME758_CREDITOSVP_TOTAL_INCONSISTENTE.<br></p>")));
  }

  if($nTotalDebitosVP2 != $nTotalCreditosResultado2){
    array_push($aRetorno,array("mensagem"=>"ME757_DEBITOSVP_TOTAL_INCONSISTENTE2", "calculo" => "Total Debitos VP2: {$nTotalDebitosVP2} Total Creditos Resultado2: {$nTotalCreditosResultado2}",
      "regras"=> utf8_encode("<p>2. Total de débitos e créditos das classes 3 e 4 igual ao total de débitos e créditos das contas de apuração do resultado do exercício ? Intra OFSS.<br>
        2.1. Validação: Verificar se para as contas iniciadas com 3 e 4 onde o quinto digito é igual a 2,<br>
        o total de débitos é igual ao total de créditos das contas 2.3.7.1.2.01.00 e 2.3.7.2.2.01.00, <br>
        e o total de créditos é igual ao total de débitos das contas 2.3.7.1.2.01.00 e 2.3.7.2.2.01.00, seguindo os passos:<br><br>

        Registro a ser utilizado: '10 ? Balancete Contábil'.<br>
        Etapa 1 - Filtros utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas onde o primeiro dígito seja igual a 3 e 4 e o quinto digito igual a 1.<br>
        Obter o somatório dos valores informados no campo totalDebitos e armazena em 'Total Débitos VP'.<br>
        Obter o somatório dos valores informados no campo totalCreditos e armazena em 'Total Créditos VP'.<br><br>

        Etapa 2 - Filtros utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas 2.3.7.1.2.01.00 e 2.3.7.2.2.01.00.<br>
        Obter o somatório dos valores informados no campo totalDebitos e armazena em 'Total Débitos Resultado'.<br>
        Obter o somatório dos valores informados no campo totalCreditos e armazena em 'Total Créditos Resultado'.<br><br>

        Etapa 3 - O 'Total Débitos VP' deve ser igual ao 'Total Créditos Resultado'.<br>
        1.1.1. Mensagem: ME757_DEBITOSVP_TOTAL_INCONSISTENTE.<br><br>

        O 'Total Créditos VP' deve ser igual ao 'Total Débito Resultado'.<br>
        1.1.2. Mensagem: ME758_CREDITOSVP_TOTAL_INCONSISTENTE.<br></p>")));
  }

  if($nTotalCreditosVP2 != $nTotalDebitosResultado2){
    array_push($aRetorno,array("mensagem"=>"ME758_CREDITOSVP_TOTAL_INCONSISTENTE2","calculo" => "Total Creditos VP2: {$nTotalCreditosVP2} Total Debitos Resultado2: {$nTotalDebitosResultado2}",
      "regras"=> utf8_encode("<p>2. Total de débitos e créditos das classes 3 e 4 igual ao total de débitos e créditos das contas de apuração do resultado do exercício ? Intra OFSS.<br>
        2.1. Validação: Verificar se para as contas iniciadas com 3 e 4 onde o quinto digito é igual a 2,<br>
        o total de débitos é igual ao total de créditos das contas 2.3.7.1.2.01.00 e 2.3.7.2.2.01.00, <br>
        e o total de créditos é igual ao total de débitos das contas 2.3.7.1.2.01.00 e 2.3.7.2.2.01.00, seguindo os passos:<br><br>

        Registro a ser utilizado: '10 ? Balancete Contábil'.<br>
        Etapa 1 - Filtros utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas onde o primeiro dígito seja igual a 3 e 4 e o quinto digito igual a 1.<br>
        Obter o somatório dos valores informados no campo totalDebitos e armazena em 'Total Débitos VP'.<br>
        Obter o somatório dos valores informados no campo totalCreditos e armazena em 'Total Créditos VP'.<br><br>

        Etapa 2 - Filtros utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas 2.3.7.1.2.01.00 e 2.3.7.2.2.01.00.<br>
        Obter o somatório dos valores informados no campo totalDebitos e armazena em 'Total Débitos Resultado'.<br>
        Obter o somatório dos valores informados no campo totalCreditos e armazena em 'Total Créditos Resultado'.<br><br>

        Etapa 3 - O 'Total Débitos VP' deve ser igual ao 'Total Créditos Resultado'.<br>
        1.1.1. Mensagem: ME757_DEBITOSVP_TOTAL_INCONSISTENTE.<br><br>

        O 'Total Créditos VP' deve ser igual ao 'Total Débito Resultado'.<br>
        1.1.2. Mensagem: ME758_CREDITOSVP_TOTAL_INCONSISTENTE.")));
  }

  if($nTotalDebitosVP3 != $nTotalCreditosResultado3){
    array_push($aRetorno,array("mensagem"=>"ME757_DEBITOSVP_TOTAL_INCONSISTENTE3", "calculo" => "Total Debitos VP3: {$nTotalDebitosVP3} Total Creditos Resultado3: {$nTotalCreditosResultado3}",
      "regras"=> utf8_encode("<p>3. Total de débitos e créditos das classes 3 e 4 igual ao total de débitos e créditos das contas de apuração do resultado do exercício ? Inter OFSS - União.<br>
       3.1. Validação: Verificar se para as contas iniciadas com 3 e 4 onde o quinto digito é igual a 3,<br>
       o total de débitos é igual ao total de créditos das contas 2.3.7.1.3.01.00 e 2.3.7.2.3.01.00, <br>
       e o total de créditos é igual ao total de débitos das contas 2.3.7.1.3.01.00 e 2.3.7.2.3.01.00, seguindo os passos:<br><br>

       Registro a ser utilizado: '10 ? Balancete Contábil'.<br>
       Etapa 1 - Filtros utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas onde o primeiro dígito seja igual a 3 e 4 e o quinto digito igual a 3.<br>
       Obter o somatório dos valores informados no campo totalDebitos e armazena em 'Total Débitos VP'.<br>
       Obter o somatório dos valores informados no campo totalCreditos e armazena em 'Total Créditos VP'.<br><br>

       Etapa 2 - Filtros utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas 2.3.7.1.3.01.00 e 2.3.7.2.3.01.00<br>
       Obter o somatório dos valores informados no campo totalDebitos e armazena em 'Total Débitos Resultado'.<br>
       Obter o somatório dos valores informados no campo totalCreditos e armazena em 'Total Créditos Resultado'.<br><br>

       Etapa 3 - O 'Total Débitos VP' deve ser igual ao 'Total Créditos Resultado'.<br>
       1.1.1. Mensagem: ME757_DEBITOSVP_TOTAL_INCONSISTENTE.<br><br>

       O 'Total Créditos VP' deve ser igual ao 'Total Débito Resultado'.<br>
       1.1.2. Mensagem: ME758_CREDITOSVP_TOTAL_INCONSISTENTE.<br></p>")));
  }

  if($nTotalCreditosVP3 != $nTotalDebitosResultado3){
    array_push($aRetorno,array("mensagem"=>"ME758_CREDITOSVP_TOTAL_INCONSISTENTE3","calculo" => "Total Creditos VP3: {$nTotalDebitosVP3} Total Debitos Resultado3: {$nTotalCreditosResultado3}",
      "regras"=> utf8_encode("<p>3. Total de débitos e créditos das classes 3 e 4 igual ao total de débitos e créditos das contas de apuração do resultado do exercício ? Inter OFSS - União.<br>
       3.1. Validação: Verificar se para as contas iniciadas com 3 e 4 onde o quinto digito é igual a 3,<br>
       o total de débitos é igual ao total de créditos das contas 2.3.7.1.3.01.00 e 2.3.7.2.3.01.00, <br>
       e o total de créditos é igual ao total de débitos das contas 2.3.7.1.3.01.00 e 2.3.7.2.3.01.00, seguindo os passos:<br><br>

       Registro a ser utilizado: '10 ? Balancete Contábil'.<br>
       Etapa 1 - Filtros utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas onde o primeiro dígito seja igual a 3 e 4 e o quinto digito igual a 3.<br>
       Obter o somatório dos valores informados no campo totalDebitos e armazena em 'Total Débitos VP'.<br>
       Obter o somatório dos valores informados no campo totalCreditos e armazena em 'Total Créditos VP'.<br><br>

       Etapa 2 - Filtros utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas 2.3.7.1.3.01.00 e 2.3.7.2.3.01.00<br>
       Obter o somatório dos valores informados no campo totalDebitos e armazena em 'Total Débitos Resultado'.<br>
       Obter o somatório dos valores informados no campo totalCreditos e armazena em 'Total Créditos Resultado'.<br><br>

       Etapa 3 - O 'Total Débitos VP' deve ser igual ao 'Total Créditos Resultado'.<br>
       1.1.1. Mensagem: ME757_DEBITOSVP_TOTAL_INCONSISTENTE.<br><br>

       O 'Total Créditos VP' deve ser igual ao 'Total Débito Resultado'.<br>
       1.1.2. Mensagem: ME758_CREDITOSVP_TOTAL_INCONSISTENTE.<br></p>")));
  }

  if($nTotalDebitosVP4 != $nTotalCreditosResultado4){
    array_push($aRetorno,array("mensagem"=>"ME757_DEBITOSVP_TOTAL_INCONSISTENTE4", "calculo" => "Total Debitos VP4: {$nTotalDebitosVP4} Total Creditos Resultado4: {$nTotalCreditosResultado4}",
      "regras"=>utf8_encode("<p>4. Total de débitos e créditos das classes 3 e 4 igual ao total de débitos e créditos das contas de apuração do resultado do exercício - Inter OFSS - Estado.<br>
        4.1. Validação: Verificar se para as contas iniciadas com 3 e 4 onde o quinto digito é igual a 4,<br>
        o total de débitos é igual ao total de créditos das contas 2.3.7.1.4.01.00 e 2.3.7.2.4.01.00, <br>
        e o total de créditos é igual ao total de débitos das contas 2.3.7.1.4.01.00 e 2.3.7.2.4.01.00, seguindo os passos:<br><br>

        Registro a ser utilizado: '10 ? Balancete Contábil'.<br>
        Etapa 1 - Filtros utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas onde o primeiro dígito seja igual a 3 e 4 e o quinto digito igual a 4.<br>
        Obter o somatório dos valores informados no campo totalDebitos e armazena em 'Total Débitos VP'.<br>
        Obter o somatório dos valores informados no campo totalCreditos e armazena em 'Total Créditos VP'.<br><br>

        Etapa 2 - Filtros utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas 2.3.7.1.4.01.00 e 2.3.7.2.4.01.00.<br>
        Obter o somatório dos valores informados no campo totalDebitos e armazena em 'Total Débitos Resultado'.<br>
        Obter o somatório dos valores informados no campo totalCreditos e armazena em 'Total Créditos Resultado'.<br><br>

        Etapa 3 - O 'Total Débitos VP' deve ser igual ao 'Total Créditos Resultado'.<br>
        1.1.1. Mensagem: ME757_DEBITOSVP_TOTAL_INCONSISTENTE.<br><br>

        O 'Total Créditos VP' deve ser igual ao 'Total Débito Resultado'.<br>
        1.1.2. Mensagem: ME758_CREDITOSVP_TOTAL_INCONSISTENTE.<br></p>")));
  }

  if($nTotalCreditosVP4 != $nTotalDebitosResultado4){
    array_push($aRetorno,array("mensagem"=>"ME758_CREDITOSVP_TOTAL_INCONSISTENTE4","calculo" => "Total Creditos VP4: {$nTotalCreditosVP4} Total Debitos Resultado4: {$nTotalDebitosResultado4}",
      "regras"=>utf8_encode("<p>4. Total de débitos e créditos das classes 3 e 4 igual ao total de débitos e créditos das contas de apuração do resultado do exercício - Inter OFSS - Estado.<br>
        4.1. Validação: Verificar se para as contas iniciadas com 3 e 4 onde o quinto digito é igual a 4,<br>
        o total de débitos é igual ao total de créditos das contas 2.3.7.1.4.01.00 e 2.3.7.2.4.01.00, <br>
        e o total de créditos é igual ao total de débitos das contas 2.3.7.1.4.01.00 e 2.3.7.2.4.01.00, seguindo os passos:<br><br>

        Registro a ser utilizado: '10 ? Balancete Contábil'.<br>
        Etapa 1 - Filtros utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas onde o primeiro dígito seja igual a 3 e 4 e o quinto digito igual a 4.<br>
        Obter o somatório dos valores informados no campo totalDebitos e armazena em 'Total Débitos VP'.<br>
        Obter o somatório dos valores informados no campo totalCreditos e armazena em 'Total Créditos VP'.<br><br>

        Etapa 2 - Filtros utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas 2.3.7.1.4.01.00 e 2.3.7.2.4.01.00.<br>
        Obter o somatório dos valores informados no campo totalDebitos e armazena em 'Total Débitos Resultado'.<br>
        Obter o somatório dos valores informados no campo totalCreditos e armazena em 'Total Créditos Resultado'.<br><br>

        Etapa 3 - O 'Total Débitos VP' deve ser igual ao 'Total Créditos Resultado'.<br>
        1.1.1. Mensagem: ME757_DEBITOSVP_TOTAL_INCONSISTENTE.<br><br>

        O 'Total Créditos VP' deve ser igual ao 'Total Débito Resultado'.<br>
        1.1.2. Mensagem: ME758_CREDITOSVP_TOTAL_INCONSISTENTE.<br></p>")));
  }

  if($nTotalDebitosVP5 != $nTotalCreditosResultado5){
    array_push($aRetorno,array("mensagem"=>"ME757_DEBITOSVP_TOTAL_INCONSISTENTE5", "calculo" => "Total Debitos VP5: {$nTotalDebitosVP5} Total Creditos Resultado5: {$nTotalCreditosResultado5}",
      "regras"=>utf8_encode("<p>5. Total de débitos e créditos das classes 3 e 4 igual ao total de débitos e créditos das contas de apuração do resultado do exercício - Inter OFSS - Município.<br>
        5.1. Validação: Verificar se para as contas iniciadas com 3 e 4 onde o quinto digito é igual a 5,<br>
        o total de débitos é igual ao total de créditos das contas 2.3.7.1.5.01.00 e 2.3.7.2.5.01.00, <br
        e o total de créditos é igual ao total de débitos das contas 2.3.7.1.5.01.00 e 2.3.7.2.5.01.00, seguindo os passos:<br<br

        Registro a ser utilizado: '10 ? Balancete Contábil'.<br>
        Etapa 1 - Filtros utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas onde o primeiro dígito seja igual a 3 e 4 e o quinto digito igual a 5.<br>
        Obter o somatório dos valores informados no campo totalDebitos e armazena em 'Total Débitos VP'.<br>
        Obter o somatório dos valores informados no campo totalCreditos e armazena em 'Total Créditos VP'.<br><br>

        Etapa 2 - Filtros utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas 2.3.7.1.5.01.00 e 2.3.7.2.5.01.00.<br>
        Obter o somatório dos valores informados no campo totalDebitos e armazena em 'Total Débitos Resultado'.<br>
        Obter o somatório dos valores informados no campo totalCreditos e armazena em 'Total Créditos Resultado'.<br><br>

        Etapa 3 - O 'Total Débitos VP' deve ser igual ao 'Total Créditos Resultado'.<br>
        1.1.1. Mensagem: ME757_DEBITOSVP_TOTAL_INCONSISTENTE.<br><br>

        O 'Total Créditos VP' deve ser igual ao 'Total Débito Resultado'.<br>
        1.1.2. Mensagem: ME758_CREDITOSVP_TOTAL_INCONSISTENTE.<br></p>")));
  }

  if($nTotalCreditosVP5 != $nTotalDebitosResultado5){
    array_push($aRetorno,array("mensagem"=>"ME758_CREDITOSVP_TOTAL_INCONSISTENTE5","calculo" => "Total Creditos VP5: {$nTotalCreditosVP5} Total Debitos Resultado5: {$nTotalDebitosResultado5}",
      "regras"=>utf8_encode("<p>5. Total de débitos e créditos das classes 3 e 4 igual ao total de débitos e créditos das contas de apuração do resultado do exercício - Inter OFSS - Município.<br>
        5.1. Validação: Verificar se para as contas iniciadas com 3 e 4 onde o quinto digito é igual a 5,<br>
        o total de débitos é igual ao total de créditos das contas 2.3.7.1.5.01.00 e 2.3.7.2.5.01.00, <br
        e o total de créditos é igual ao total de débitos das contas 2.3.7.1.5.01.00 e 2.3.7.2.5.01.00, seguindo os passos:<br<br

        Registro a ser utilizado: '10 ? Balancete Contábil'.<br>
        Etapa 1 - Filtros utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas onde o primeiro dígito seja igual a 3 e 4 e o quinto digito igual a 5.<br>
        Obter o somatório dos valores informados no campo totalDebitos e armazena em 'Total Débitos VP'.<br>
        Obter o somatório dos valores informados no campo totalCreditos e armazena em 'Total Créditos VP'.<br><br>

        Etapa 2 - Filtros utilizados: Filtrar pelo campo contaContábil obtendo apenas as contas 2.3.7.1.5.01.00 e 2.3.7.2.5.01.00.<br>
        Obter o somatório dos valores informados no campo totalDebitos e armazena em 'Total Débitos Resultado'.<br>
        Obter o somatório dos valores informados no campo totalCreditos e armazena em 'Total Créditos Resultado'.<br><br>

        Etapa 3 - O 'Total Débitos VP' deve ser igual ao 'Total Créditos Resultado'.<br>
        1.1.1. Mensagem: ME757_DEBITOSVP_TOTAL_INCONSISTENTE.<br><br>

        O 'Total Créditos VP' deve ser igual ao 'Total Débito Resultado'.<br>
        1.1.2. Mensagem: ME758_CREDITOSVP_TOTAL_INCONSISTENTE.<br></p>")));
  }

  return $aRetorno;


}
