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
    
  case "processarSicomAnual" : 
    
    /**
     * sempre usar essa funcao para pegar o ano
     */
    $sDataInicial = db_getsession("DB_anousu").'-01-01';
    $sDataFinal   = db_getsession("DB_anousu")."-12-31";
    if (count($oParam->arquivos) > 0) {
      
    	$sSql  = "SELECT db21_codigomunicipoestado FROM db_config WHERE codigo = ".db_getsession('DB_instit');
    	
    	$rsInst = db_query($sSql);
    	$sInst  = str_pad(db_utils::fieldsMemory($rsInst, 0)->db21_codigomunicipoestado, 5, "0", STR_PAD_LEFT);
    	   	
      $iAnoReferencia = db_getsession('DB_anousu');
    	
      $oEscritorCSV = new padArquivoEscritorCSV();
      /**
       * Verificar se existe pelo menos um pdf de leis antes de tentar processar
       */
      if (!file_exists("PPA{$iAnoReferencia[2]}{$iAnoReferencia[3]}.pdf") && !file_exists("LDO{$iAnoReferencia[2]}{$iAnoReferencia[3]}.pdf") 
            && !file_exists("LOA{$iAnoReferencia[2]}{$iAnoReferencia[3]}.pdf")) {
      	$oRetorno->status  = 2;
        $sGetMessage       = "Envie os arquivos das Leis antes de processar!";
        $oRetorno->message = urlencode(str_replace("\\n", "\n",$sGetMessage));
        break;
    	}
      $oEscritorCSV->adicionarArquivo("PPA{$iAnoReferencia[2]}{$iAnoReferencia[3]}.pdf", "PPA{$iAnoReferencia[2]}{$iAnoReferencia[3]}.pdf");
      $oEscritorCSV->adicionarArquivo("LDO{$iAnoReferencia[2]}{$iAnoReferencia[3]}.pdf", "LDO{$iAnoReferencia[2]}{$iAnoReferencia[3]}.pdf");
    	$oEscritorCSV->adicionarArquivo("LOA{$iAnoReferencia[2]}{$iAnoReferencia[3]}.pdf", "LOA{$iAnoReferencia[2]}{$iAnoReferencia[3]}.pdf");
    	$oEscritorCSV->zip("LEIS_{$sInst}_{$iAnoReferencia}");
    	
    	$oEscritorCSV = new padArquivoEscritorCSV();
      
    	/*
       * instanciar cada arqivo selecionado e gerar o CSV correspondente
       */
      foreach ($oParam->arquivos as $sArquivo) {
        
        if (file_exists("model/contabilidade/arquivos/sicom/".db_getsession('DB_anousu')."/SicomArquivo{$sArquivo}.model.php")) {
          
          require_once("model/contabilidade/arquivos/sicom/".db_getsession('DB_anousu')."/SicomArquivo{$sArquivo}.model.php");
          
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

      $oEscritorCSV->zip("IP_{$sInst}_{$iAnoReferencia}");
      $oEscritorCSV->adicionarArquivo("tmp/LEIS_{$sInst}_{$iAnoReferencia}.zip", "LEIS_{$sInst}_{$iAnoReferencia}.zip");
      $oEscritorCSV->adicionarArquivo("tmp/IP_{$sInst}_{$iAnoReferencia}.zip", "IP_{$sInst}_{$iAnoReferencia}.zip");
      $oRetorno->itens = $oEscritorCSV->getListaArquivos();
    }
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
      	
	      if (file_exists("model/contabilidade/arquivos/sicom/mensal/".db_getsession("DB_anousu")."/SicomArquivo{$sArquivo}.model.php")) {
	          
	        require_once("model/contabilidade/arquivos/sicom/mensal/".db_getsession("DB_anousu")."/SicomArquivo{$sArquivo}.model.php");
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
     */
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
        
        if (file_exists("model/contabilidade/arquivos/sicom/mensal/balancete/".db_getsession("DB_anousu")."/SicomArquivo{$sArquivo}.model.php")) {
            
          require_once("model/contabilidade/arquivos/sicom/mensal/balancete/".db_getsession("DB_anousu")."/SicomArquivo{$sArquivo}.model.php");
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
      system("rm -f BALANCETE_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip");
      system("bin/zip -q BALANCETE_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip $aListaArquivos");
      
      $oArquivoZip = new stdClass();
      $oArquivoZip->nome    = "BALANCETE_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip";
      $oArquivoZip->caminho = "BALANCETE_{$sInst}_{$sOrgao}_{$oParam->mesReferencia}_{$iAnoReferencia}.zip";
      $aArrayArquivos[] = $oArquivoZip;
      
      $oRetorno->itens  = $aArrayArquivos;
    }
    
    

    break;
    
    case "processarPCA" : 

      $sSql  = "SELECT db21_codigomunicipoestado FROM db_config where codigo = ".db_getsession("DB_instit");
      $rsInst = db_query($sSql);
      $sInst  = str_pad(db_utils::fieldsMemory($rsInst, 0)->db21_codigomunicipoestado, 5, "0", STR_PAD_LEFT);
          
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
              
          $oRetorno->status  = 2;
          $sGetMessage       = "Arquivo {$sArquivo}_{$iAnoReferencia}.pdf não encontrado. Envie este arquivo e tente novamente";
          $oRetorno->message = urlencode(str_replace("\\n", "\n",$sGetMessage));
              
        }
      }
      
      $aListaArquivos = " ";
      foreach ($aArrayArquivos as $oArquivo){
        $aListaArquivos .= " ".$oArquivo->caminho;
      }
      //print_r($aListaArquivos);
      system("rm -f PCA_{$sInst}_{$iAnoReferencia}.zip");
      system("bin/zip -q PCA_{$sInst}_{$iAnoReferencia}.zip $aListaArquivos");
      //echo $aListaArquivos;
      $oArquivoZip = new stdClass();
      $oArquivoZip->nome    = "PCA_{$sInst}_{$iAnoReferencia}.zip";
      $oArquivoZip->caminho = "PCA_{$sInst}_{$iAnoReferencia}.zip";
      $aArrayArquivos[] = $oArquivoZip;
      
      $oRetorno->itens  = $aArrayArquivos;

    break;


  case "processarLCF" :

    $aListaArquivos .= " ".$oArquivo->caminho;
    //print_r($aListaArquivos);
    system("rm -f DECRETOSLEIS_{$sInst}_{$mesReferencia}_{$iAnoReferencia}.zip");
    system("bin/zip -q DECRETOSLEIS_{$sInst}_{$mesReferencia}_{$iAnoReferencia}.zip $aListaArquivos");
    //echo $aListaArquivos;
    $oArquivoZip = new stdClass();
    $oArquivoZip->nome    = "DECRETOSLEIS_{$sInst}_{$mesReferencia}_{$iAnoReferencia}.zip";
    $oArquivoZip->caminho = "DECRETOSLEIS_{$sInst}_{$mesReferencia}_{$iAnoReferencia}.zip";
    $aArrayArquivos[] = $oArquivoZip;

    $oRetorno->itens  = $aArrayArquivos;

    break;

}

echo $oJson->encode($oRetorno);
