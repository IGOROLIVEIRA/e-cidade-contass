<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

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
                          "vlPrevistoAtualizado",
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
    $sArquivo = "legacy_config/sicom/{$sCnpj}_sicomorgao.xml";
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

    if (!isset($oOrgao)) {
      throw new Exception("Arquivo sem configura��o de Org�os.");
    }

    /**
  	 * selecionar arquivo xml com dados das receitas do TCE
  	 */
    //$sArquivo = "legacy_config/sicom/{$sCnpj}_codrecanosessao.xml";
    $sArquivo = "legacy_config/sicom/".db_getsession("DB_anousu")."_codrecanosessao.xml";
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configura��o das receitas do sicom inexistente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oCodReceitasTce = $oDOMDocument->getElementsByTagName('receita');

    /**
  	 * selecionar arquivo xml com dados das receitas para substituicao
  	 */
    $sArquivo = "legacy_config/sicom/{$sCnpj}_sicomnaturezareceita.xml";
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configura��o de natureza das receitas do sicom inexistente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oCodReceitasSub = $oDOMDocument->getElementsByTagName('receita');

    $db_filtro  = "o70_instit = ".db_getsession("DB_instit")." and o70_codrec <> 0";

    $anousu  = db_getsession("DB_anousu");

    $aDadosAgrupados = array();
    $rsResult = db_receitasaldo(11,1,3,true,$db_filtro,$anousu,$this->sDataInicial,$this->sDataFinal,false,' * ',true,0);

    /**
     * array para armazenar as receitas invalidas para o sicom
     */
    $aCodReceita = array();
    /**
     * percorrer os resultados retornados por db_receitasaldo
     */
    for ($iCont = 0;$iCont < pg_num_rows($rsResult); $iCont++) {

	    $oReceita = db_utils::fieldsMemory($rsResult,$iCont);

	    $sVerificaReceita = 0;
	    $iCodRubrica = substr($oReceita->o57_fonte, 1, 8);
	    if ($oReceita->o70_codrec != 0) {

	    	/**
	    	 * percorrer xml de codreceitas do TCE/MG
	    	 */
	      foreach ($oCodReceitasTce as $oCodReceita) {

	    	  if (str_replace(".","", $oCodReceita->getAttribute('codigo')) == substr($oReceita->o57_fonte, 1, 8)) {

	    	  	if ($oCodReceita->getAttribute('tipo') == 1) {
	    	  		$sVerificaReceita = 1;
	    	  	} else {

	    	  		/**
	    	  		 * percorrer xml de codreceitas do e-cidade para o TCE/MG
	    	  		 */
	    	  		foreach ($oCodReceitasSub as $oCodReceitaSub) {

	    	  			if ($oCodReceitaSub->getAttribute('receitaEcidade') == substr($oReceita->o57_fonte, 1, 8)) {

	    	  				$iCodRubrica = $oCodReceitaSub->getAttribute('receitaSicom');
	                $sVerificaReceita = 1;
	    	  				break;

	    	  			}

	    	  		}

	    	  	}
	    	  	break;

	    	  }

	      }

	      if ($sVerificaReceita == 0 && $oReceita->o70_codrec != 0) {
		     /**
		    	* percorrer xml de codreceitas do e-cidade para o TCE/MG
		    	*/
		      foreach ($oCodReceitasSub as $oCodReceitaSub) {

		    	  if ($oCodReceitaSub->getAttribute('receitaEcidade') == substr($oReceita->o57_fonte, 1, 8)) {

		    	  	$iCodRubrica = $oCodReceitaSub->getAttribute('receitaSicom');
		          $sVerificaReceita = 1;
		    	    break;

		    	  }

		    	}

	      }

	    }

      if ($sVerificaReceita == 0 && $oReceita->o70_codrec != 0) {

      	if (!isset($aCodReceita[substr($oReceita->o57_fonte, 1, 8)])) {
      	  $aCodReceita[substr($oReceita->o57_fonte, 1, 8)] = substr($oReceita->o57_fonte, 1, 8);
      	}

      }

      if (count($aCodReceita) == 10) {
      	throw new Exception("C�digos ".implode(",", $aCodReceita)." da receita inexistente no siscom. Deve ser inclu�do um codigo de receita correspondente.");
      }

    	if ($oReceita->o70_codrec != 0 && $sVerificaReceita == 1) {

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
        $sHash = $iCodRubrica.$iIdentDeducao;

	      if($oReceita->o57_fonte[1] == 5){
	        $oReceita->o57_fonte[1] = 1;
	      }

	      /**
	       * cria nova posi��o no array ou usa uma existente para somar os valores de rubrica igual
	       */
        if (!isset($aDadosAgrupados[$sHash])) {

         /**
	    	  * percorrer xml de codreceitas do TCE/MG
	    	  */
	        foreach ($oCodReceitasTce as $oCodReceita) {

	    	    if (str_replace(".","", $oCodReceita->getAttribute('codigo')) == $iCodRubrica) {
	    	    	$sEspecificacaoRec = iconv('UTF-8','ISO-8859-1', substr($oCodReceita->getAttribute('descricao'), 0, 100));
	    	    	break;
	    	    }

	        }

  	      $oDadosReceitaMes = new stdClass();

          $oDadosReceitaMes->tipoRegistro         = 10;
          $oDadosReceitaMes->detalhesessao        = 10;
          $oDadosReceitaMes->codReceita           = substr($oReceita->o70_codrec, 0, 15);
          $oDadosReceitaMes->codOrgao             = $sOrgao;
          $oDadosReceitaMes->identificadorDeducao = $iIdentDeducao;
          $oDadosReceitaMes->rubrica              = $iCodRubrica;
          $oDadosReceitaMes->especificacao        = $sEspecificacaoRec;
          $oDadosReceitaMes->vlPrevistoAtualizado = 0;
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
	      $sHashFonte = str_pad($oReceita->o70_codigo, 3, "0", STR_PAD_LEFT);

	      /**
	       * cria nova posi��o no array ou usa uma existente para somar valores de fontes iguais
	       */
	      if (!isset($oDadosReceitaMes->FonteRecursoMes[$sHashFonte])) {

	      	$rsResultCodTri = db_query("SELECT o15_codtri from orctiporec where o15_codigo = {$oReceita->o70_codigo}");
	      	$iCodTri = db_utils::fieldsMemory($rsResultCodTri, 0)->o15_codtri;

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

	      $oDadosReceitaMes->vlPrevistoAtualizado += $oReceita->saldo_inicial;
        $oDadosReceitaMes->vlArrecadado         += $oReceita->saldo_arrecadado;
        $oDadosReceitaMes->vlAcumuladoMesAnt    += $oReceita->saldo_anterior;
        $aDadosAgrupados[$sHash] = $oDadosReceitaMes;

      }


    }

    if (count($aCodReceita) > 0) {
      throw new Exception("C�digos ".implode(",", $aCodReceita)." da receita inexistente no siscom. Deve ser inclu�do um codigo de receita correspondente.");
    }
  	/**
	   * passar todos os dados registro 10 para o $this->aDados[]
	   */
	  foreach ($aDadosAgrupados as $oDado) {

	  	if ($oDado->vlArrecadado <> 0) {

		  	$oDadosReceita = clone $oDado;
		  	unset($oDadosReceita->FonteRecursoMes);
		  	$oDadosReceita->vlPrevistoAtualizado = number_format(abs($oDadosReceita->vlPrevistoAtualizado), 2, "", "");
		  	$oDadosReceita->vlArrecadado         = number_format(abs($oDadosReceita->vlArrecadado), 2, "", "");
	      $oDadosReceita->vlAcumuladoMesAnt    = number_format(abs($oDadosReceita->vlAcumuladoMesAnt), 2, "", "");
		  	$this->aDados[] = $oDadosReceita;

		  /**
		   * passar todos os dados registro 11 para o $this->aDados[]
		   */
		    foreach ($oDado->FonteRecursoMes as $oFonteRecurso) {

		    	$oFonteRecurso->vlArrecadadoFonte      = number_format(abs($oFonteRecurso->vlArrecadadoFonte), 2, "", "");
		      $oFonteRecurso->vlAcumuladoFonteMesAnt = number_format(abs($oFonteRecurso->vlAcumuladoFonteMesAnt), 2, "", "");
		      $oFonteRecurso->codReceita             = $oDadosReceita->codReceita;
		  		$this->aDados[] = $oFonteRecurso;

		   	}

	  	}

	  }

pg_exec("commit");

    }

  }
