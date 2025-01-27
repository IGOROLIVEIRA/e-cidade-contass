<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/SicomArquivoSalvarSaldoRec.model.php");

 /**
  * detalhamento das receitas do m�s Sicom Acompanhamento Mensal
  * @author robson
  * @package Contabilidade
  */
class SicomArquivoDetalhamentoReceitasMes extends SicomArquivoBase implements iPadArquivoBaseCSV {

	/**
	 *
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 149;

  /**
   *
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'REC';

  /**
   *
   * Construtor da classe
   */
  public function __construct() {

  }

  /**
	 * Retorna o codigo do layout
	 *
	 * @return Integer
	 */
  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }

  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   */
  public function getCampos(){

    $aElementos[10] = array(
                          "tipoRegistro",
                          "codReceita",
                          "codOrgao",
                          "identificadorDeducao",
                          "rubrica",
                          "especificacao",
                          "vlArrecadado",
                          "vlAcumuladoMesAnt"
                        );
    $aElementos[11] = array(
                          "tipoRegistro",
                          "codReceita",
                          "codFonte",
                          "vlArrecadadoFonte",
    											"vlAcumuladoFonteMesAnt"
                        );
    return $aElementos;
  }

  /**
   * selecionar os dados das receitas do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {

    $sSql  = "SELECT * FROM db_config ";
		$sSql .= "	WHERE prefeitura = 't'";

    $rsInst = db_query($sSql);
    $sCnpj  = db_utils::fieldsMemory($rsInst, 0)->cgc;

  	/**
  	 * selecionar arquivo xml com dados dos org�o
  	 */
    $sArquivo = "legacy_config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomorgao.xml";
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configura��o dos org�os do sicom inexistente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oOrgaos      = $oDOMDocument->getElementsByTagName('orgao');

    /**
     * percorrer os orgaos retornados do xml para selecionar o orgao da inst logada
     * para selecionar os dados da instit
     */
    foreach ($oOrgaos as $oOrgao) {

    	if ($oOrgao->getAttribute('instituicao') == db_getsession("DB_instit")) {
        $sOrgao     = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);
    	}

    }

    /**
  	 * selecionar arquivo xml com dados das receitas
  	 */
    $sArquivo = "legacy_config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomnaturezareceita.xml";

    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oNaturezaReceita = $oDOMDocument->getElementsByTagName('receita');

   // select o57_fonte,o60_perc from orcfontesdes join orcfontes on  o57_codfon = o60_codfon and o60_anousu = o57_anousu where o60_anousu = 2013;


    if (!isset($oOrgao)) {
      throw new Exception("Arquivo sem configura��o de Org�os.");
    }

    $db_filtro  = "o70_instit = ".db_getsession("DB_instit");

    $anousu  = db_getsession("DB_anousu");

    $aDadosAgrupados = array();
    $rsResult = db_receitasaldo(11,1,3,true,$db_filtro,$anousu,$this->sDataInicial,$this->sDataFinal,false,' * ',true,0);
    //db_criatabela($rsResult);
    /**
     * percorrer os resultados retornados por db_receitasaldo
     */
    for ($iCont = 0;$iCont < pg_num_rows($rsResult); $iCont++) {

	    $oReceita = db_utils::fieldsMemory($rsResult,$iCont);

	    if ($oReceita->o70_codrec != 0) {

    	  /**
	       * o primeiro digito 9 identifica o identificador deducao do sicom no campo especificado
	       */
	      if($oReceita->o70_concarpeculiar[0] == '9'){
	        $iIdentDeducao = $oReceita->o70_concarpeculiar[1].$oReceita->o70_concarpeculiar[2];
	      }else{
	        $iIdentDeducao = " ";
	      }

	      /**
	       *
	       * Hash para agrupar informa��es no array pela rubrica
	       * @var String
	       */
        $sHash = substr($oReceita->o57_fonte, 1, 8);

	      if($oReceita->o57_fonte[1] == 5){
	        $oReceita->o57_fonte[1] = 1;
	      }

	      $sNatureza = substr($oReceita->o57_fonte, 1, 8);
	      foreach ($oNaturezaReceita as $oNatureza) {

      	  if ($oNatureza->getAttribute('instituicao') == db_getsession("DB_instit")
						  && $oNatureza->getAttribute('receitaEcidade') == $sNatureza) {

      	    $sNatureza = $oNatureza->getAttribute('receitaSicom');
      	    $sHash = $sNatureza;
      	    break;

      	  }

        }

	      /**
	       * cria nova posi��o no array ou usa uma existente para somar os valores de rubrica igual
	       */
        if (!isset($aDadosAgrupados[$sHash])) {

  	      $oDadosReceitaMes = new stdClass();

          $oDadosReceitaMes->tipoRegistro         = 10;
          $oDadosReceitaMes->detalhesessao        = 10;
          $oDadosReceitaMes->codReceita           = substr($oReceita->o70_codrec, 0, 15);
          $oDadosReceitaMes->codOrgao             = $sOrgao;
          $oDadosReceitaMes->identificadorDeducao = $iIdentDeducao;
          $oDadosReceitaMes->rubrica              = $sNatureza;//substr($oReceita->o57_fonte, 1, 8);
          $oDadosReceitaMes->especificacao        = substr($oReceita->o57_descr, 0, 100);
          $oDadosReceitaMes->vlArrecadado         = 0;
          $oDadosReceitaMes->vlAcumuladoMesAnt    = 0;
          $oDadosReceitaMes->FonteRecusroMes      = array();

          $aDadosAgrupados[$sHash] = $oDadosReceitaMes;

        } else {
	        $oDadosReceitaMes = $aDadosAgrupados[$sHash];
	      }

	      /**
	       *
	       * Hash para agrupar informa��es no array pela fonte
	       * @var String
	       */
	      //$sHashFonte = str_pad($oReceita->o70_codigo, 3, "0", STR_PAD_LEFT);
	      $rsResultCodTri = db_query("SELECT o15_codtri from orctiporec where o15_codigo = {$oReceita->o70_codigo}");
	      $iCodTri = db_utils::fieldsMemory($rsResultCodTri, 0)->o15_codtri;
	      $sHashFonte = $sNatureza;//substr($oReceita->o57_fonte, 1, 8);

	      /**
	       * cria nova posi��o no array ou usa uma existente para somar valores de fontes iguais
	       */
	      if (!isset($oDadosReceitaMes->FonteRecursoMes[$sHashFonte])) {

		      $oDadosFonteRecursoMes = new stdClass();

	        $oDadosFonteRecursoMes->tipoRegistro  = 11;
	        $oDadosFonteRecursoMes->detalhesessao = 11;
	        $oDadosFonteRecursoMes->codReceita    = substr($oReceita->o70_codrec, 0, 15);
	        $oDadosFonteRecursoMes->codFonte      = str_pad($iCodTri, 3, "0", STR_PAD_LEFT);

	        $oDadosFonteRecursoMes->vlArrecadadoFonte       = 0;
	        $oDadosFonteRecursoMes->vlAcumuladoFonteMesAnt  = 0;

	        $oDadosReceitaMes->FonteRecursoMes[$sHashFonte] = $oDadosFonteRecursoMes;

	      } else {
		      $oDadosFonteRecursoMes = $oDadosReceitaMes->FonteRecursoMes[$sHashFonte];
	      }

	      $oDadosFonteRecursoMes->vlArrecadadoFonte       += $oReceita->saldo_arrecadado;
	      $oDadosFonteRecursoMes->vlAcumuladoFonteMesAnt  += $oReceita->saldo_anterior;
		    $oDadosReceitaMes->FonteRecursoMes[$sHashFonte]  = $oDadosFonteRecursoMes;

        $oDadosReceitaMes->vlArrecadado         += $oReceita->saldo_arrecadado;
        $oDadosReceitaMes->vlAcumuladoMesAnt    += $oReceita->saldo_anterior;
        $aDadosAgrupados[$sHash] = $oDadosReceitaMes;

      }

    }

  	/**
	   * passar todos os dados registro 10 para o $this->aDados[]
	   */
    $aRectceSaudEduc = array('11120101','11120200','11120431','11120434','11120800','11130501','11130502','17210102', '17210105','17213600',
                            '17220101','17220102','17220104','19110801','19113800','19113900','19114000','19130800','19131100','19131200',
                            '19131300','19310400','19311100','19311200','19311300');
	  foreach ($aDadosAgrupados as $oDado) {

	  	if ($oDado->vlArrecadado <> 0 ) {

		  	$oDadosReceita = clone $oDado;
		  	unset($oDadosReceita->FonteRecursoMes);
		  	$nValorArrecadado = $oDadosReceita->vlArrecadado;
		  	$nVlAcumuladoFonteMesAnt =  $oDadosReceita->vlAcumuladoMesAnt;
		  	$oDadosReceita->vlPrevistoAtualizado = number_format(abs($oDadosReceita->vlPrevistoAtualizado), 2, "", "");
		  	$oDadosReceita->vlArrecadado         = number_format(abs($oDadosReceita->vlArrecadado), 2, "", "");
	      $oDadosReceita->vlAcumuladoMesAnt    = number_format(abs($oDadosReceita->vlAcumuladoMesAnt), 2, "", "");
		  	$this->aDados[] = $oDadosReceita;

		  /**
		   * passar todos os dados registro 11 para o $this->aDados[]
		   */
		    foreach ($oDado->FonteRecursoMes as $oFonteRecurso) {

		    	if ($oFonteRecurso->vlArrecadadoFonte != 0 || $oFonteRecurso->vlAcumuladoFonteMesAnt != 0) {

		    		if (in_array($oDadosReceita->rubrica, $aRectceSaudEduc) && $oDadosReceita->identificadorDeducao == ' ') {

		    			/**
  	           * selecionar arquivo xml com dados dos saldos mes
  	           */
              $sArquivo = "legacy_config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomsaldorec.xml";

              $sTextoXml    = file_get_contents($sArquivo);
              $oDOMDocument = new DOMDocument();
              $oDOMDocument->loadXML($sTextoXml);
              $oRecs        = $oDOMDocument->getElementsByTagName('rec');

              $oSaldoRec100 = '000';
              $oSaldoRec101 = '000';
              $oSaldoRec102 = '000';
		    		  foreach ($oRecs as $oRec) {

			          if ($oRec->getAttribute('instituicao') == db_getsession("DB_instit")
			              && $oRec->getAttribute('codReceita') == $oFonteRecurso->codReceita
			              && $oRec->getAttribute('mes') == ($this->sDataInicial['5'].$this->sDataInicial['6'])-1) {

				          if ($oRec->getAttribute('codFonte') == '100') {
				          	$oSaldoRec100 = $oRec->getAttribute('vlAcumuladoFonteMesAnt');
				          	continue;
				          }
			            if ($oRec->getAttribute('codFonte') == '101') {
				          	$oSaldoRec101 = $oRec->getAttribute('vlAcumuladoFonteMesAnt');
				          	continue;
				          }
			            if ($oRec->getAttribute('codFonte') == '102') {
				          	$oSaldoRec102 = $oRec->getAttribute('vlAcumuladoFonteMesAnt');
				          	continue;
				          }

			          }

		          }
		    			//echo "$oFonteRecurso->codReceita = $oSaldoRec100 | $oRec->vlAcumuladoFonteMesAnt <br>";
		    			$oFonteRec = new stdClass();
	            $oFonteRec->tipoRegistro  = 11;
	            $oFonteRec->detalhesessao = 11;
	            $oFonteRec->codReceita    = $oFonteRecurso->codReceita;
	            $oFonteRec->codFonte      = "100";
	            $oFonteRec->vlArrecadadoFonte       = number_format(abs($nValorArrecadado*0.60), 2, "", "");
	            $oFonteRec->vlAcumuladoFonteMesAnt  = $oSaldoRec100 == 0 ? '000' : $oSaldoRec100;
	            $this->aDados[] = $oFonteRec;
	            $oSalvarRec = new SicomArquivoSalvarSaldoRec();
	            $oSalvarRec->sCnpj = $sCnpj;
	            $oSalvarRec->sMes  = $this->sDataInicial['5'].$this->sDataInicial['6'];
	            $oSalvarRec->SalvarXml($oFonteRec);

	            $oFonteRec = new stdClass();
	            $oFonteRec->tipoRegistro  = 11;
	            $oFonteRec->detalhesessao = 11;
	            $oFonteRec->codReceita    = $oFonteRecurso->codReceita;
	            $oFonteRec->codFonte      = "101";
	            $oFonteRec->vlArrecadadoFonte       = number_format(abs($nValorArrecadado*0.25), 2, "", "");
	            $oFonteRec->vlAcumuladoFonteMesAnt  = $oSaldoRec101 == 0 ? '000' : $oSaldoRec101;
	            $this->aDados[] = $oFonteRec;
	            $oSalvarRec = new SicomArquivoSalvarSaldoRec();
	            $oSalvarRec->sCnpj = $sCnpj;
	            $oSalvarRec->sMes  = $this->sDataInicial['5'].$this->sDataInicial['6'];
	            $oSalvarRec->SalvarXml($oFonteRec);

	            $nValorArrecadado        = $oDadosReceita->vlArrecadado-(number_format(abs($nValorArrecadado*0.60), 2, "", "")+number_format(abs($nValorArrecadado*0.25), 2, "", ""));
	            $nVlAcumuladoFonteMesAnt = $oDadosReceita->vlAcumuladoMesAnt-(number_format(abs($nVlAcumuladoFonteMesAnt*0.60), 2, "", "")+number_format(abs($nVlAcumuladoFonteMesAnt*0.25), 2, "", ""));
	            $oFonteRec = new stdClass();
	            $oFonteRec->tipoRegistro  = 11;
	            $oFonteRec->detalhesessao = 11;
	            $oFonteRec->codReceita    = $oFonteRecurso->codReceita;
	            $oFonteRec->codFonte      = "102";
	            $oFonteRec->vlArrecadadoFonte       = $nValorArrecadado == 0 ? '000' : $nValorArrecadado;
	            $oFonteRec->vlAcumuladoFonteMesAnt  = $oSaldoRec102 == 0 ? '000' : $oSaldoRec102;
	            $this->aDados[] = $oFonteRec;
	            $oSalvarRec = new SicomArquivoSalvarSaldoRec();
	            $oSalvarRec->sCnpj = $sCnpj;
	            $oSalvarRec->sMes  = $this->sDataInicial['5'].$this->sDataInicial['6'];
	            $oSalvarRec->SalvarXml($oFonteRec);

		    		} else {

		    	    $oFonteRecurso->vlArrecadadoFonte      = number_format(abs($oFonteRecurso->vlArrecadadoFonte), 2, "", "");
		          $oFonteRecurso->vlAcumuladoFonteMesAnt = number_format(abs($oFonteRecurso->vlAcumuladoFonteMesAnt), 2, "", "");
		          $oFonteRecurso->codReceita             = $oDadosReceita->codReceita;
		  		    $this->aDados[] = $oFonteRecurso;

		    		}

		    	}

		   	}

	  	}	else {

	  	  /**
  	     * selecionar arquivo xml com dados dos saldos mes
  	     */
        $sArquivo = "legacy_config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomsaldorec.xml";

        $sTextoXml    = file_get_contents($sArquivo);
        $oDOMDocument = new DOMDocument();
        $oDOMDocument->loadXML($sTextoXml);
        $oRecs        = $oDOMDocument->getElementsByTagName('rec');

        $oSaldoRec100 = '000';
        $oSaldoRec101 = '000';
        $oSaldoRec102 = '000';
		    foreach ($oRecs as $oRec) {

			    if ($oRec->getAttribute('instituicao') == db_getsession("DB_instit")
			        && $oRec->getAttribute('codReceita') == $oDado->codReceita
			        && $oRec->getAttribute('mes') == ($this->sDataInicial['5'].$this->sDataInicial['6'])-1) {

				    if ($oRec->getAttribute('codFonte') == '100') {
				      $oSaldoRec100 = $oRec->getAttribute('vlAcumuladoFonteMesAnt');
				      continue;
				    }
			      if ($oRec->getAttribute('codFonte') == '101') {
				      $oSaldoRec101 = $oRec->getAttribute('vlAcumuladoFonteMesAnt');
				      continue;
				    }
			      if ($oRec->getAttribute('codFonte') == '102') {
				      $oSaldoRec102 = $oRec->getAttribute('vlAcumuladoFonteMesAnt');
				      continue;
				    }

			    }

		    }

		    $oFonteRec = new stdClass();
	      $oFonteRec->codReceita    = $oDado->codReceita;
	      $oFonteRec->codFonte      = "100";
	      $oFonteRec->vlArrecadadoFonte       = 0;
	      $oFonteRec->vlAcumuladoFonteMesAnt  = $oSaldoRec100;

		    $oSalvarRec = new SicomArquivoSalvarSaldoRec();
	      $oSalvarRec->sCnpj = $sCnpj;
	      $oSalvarRec->sMes  = $this->sDataInicial['5'].$this->sDataInicial['6'];
	      $oSalvarRec->SalvarXml($oFonteRec);

	      $oFonteRec = new stdClass();
	      $oFonteRec->codReceita    = $oDado->codReceita;
	      $oFonteRec->codFonte      = "101";
	      $oFonteRec->vlArrecadadoFonte       = 0;
	      $oFonteRec->vlAcumuladoFonteMesAnt  = $oSaldoRec101;
	      $oSalvarRec = new SicomArquivoSalvarSaldoRec();
	      $oSalvarRec->sCnpj = $sCnpj;
	      $oSalvarRec->sMes  = $this->sDataInicial['5'].$this->sDataInicial['6'];
	      $oSalvarRec->SalvarXml($oFonteRec);

	      $oFonteRec = new stdClass();
	      $oFonteRec->codReceita    = $oDado->codReceita;
	      $oFonteRec->codFonte      = "102";
	      $oFonteRec->vlArrecadadoFonte       = 0;
	      $oFonteRec->vlAcumuladoFonteMesAnt  = $oSaldoRec102;
	      $oSalvarRec = new SicomArquivoSalvarSaldoRec();
	      $oSalvarRec->sCnpj = $sCnpj;
	      $oSalvarRec->sMes  = $this->sDataInicial['5'].$this->sDataInicial['6'];
	      $oSalvarRec->SalvarXml($oFonteRec);

		   }

	  }

pg_exec("commit");

    }

  }
