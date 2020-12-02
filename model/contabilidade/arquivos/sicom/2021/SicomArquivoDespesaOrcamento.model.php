<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

/**
 * selecionar dados de Despesas do Orcamento Sicom Instrumento de Planejamento
 * @package Contabilidade
 */
class SicomArquivoDespesaOrcamento extends SicomArquivoBase implements iPadArquivoBaseCSV
{
  
  protected $iCodigoLayout = 108;
  
  protected $sNomeArquivo = 'DSP';
  
  protected $iCodigoPespectiva;
  
  public function __construct()
  {
    
  }
  
  public function getCodigoLayout()
  {
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serão necessários para o escritor gerar o arquivo CSV
   */
  public function getCampos()
  {
    
    $aElementos[10] = array(
      "tipoRegistro",
      "codDespesa",
      "codOrgao",
      "codUnidadeSub",
      "codFuncao",
      "codSubFuncao",
      "codPrograma",
      "idAcao",
      "idSubAcao",
      "naturezaDespesa",
      "vlTotalrecurso"
    );
    $aElementos[11] = array(
      "tipoRegistro",
      "codDespesa",
      "codFontRecursos",
      "valorFonte"
    );
    
    return $aElementos;
  }
  
  public function gerarDados()
  {
    
    $sSql = "SELECT * FROM db_config ";
    $sSql .= "  WHERE prefeitura = 't'";
    
    $rsInst = db_query($sSql);
    $sCnpj = db_utils::fieldsMemory($rsInst, 0)->cgc;
    
    /**
     * selecionar arquivo xml de dados elemento da despesa
     */
    $sArquivo = "config/sicom/" . db_getsession("DB_anousu") . "/{$sCnpj}_sicomelementodespesa.xml";
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de elemento da despesa inexistente!");
    }
    $sTextoXml = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oElementos = $oDOMDocument->getElementsByTagName('elemento');
    
    
    $sSqlOrgaos = "SELECT * FROM db_config left join infocomplementaresinstit on si09_instit = codigo";
    //echo $sSqlOrgaos;exit;
    $rsInst = db_query($sSqlOrgaos);
    
    for ($iContador = 0; $iContador < pg_num_rows($rsInst); $iContador++) {
      
      $oInstit = db_utils::fieldsMemory($rsInst, $iContador);
      
      $iAnousu = db_getsession('DB_anousu');
      $sWhere = "o58_anousu = $iAnousu";
      $sWhere .= " AND o58_instit = $oInstit->codigo";
      $rsDotacao = db_dotacaosaldo(8, 2, 3, false, $sWhere, $iAnousu, $this->sDataInicial, $this->sDataFinal);
      
      
      $aDadosAgrupados = array();
      
      for ($iCont = 0; $iCont < pg_num_rows($rsDotacao); $iCont++) {
        
        $oRegistro = db_utils::fieldsMemory($rsDotacao, $iCont);
        
        $iTipoProjetoAtividade = $oRegistro->o58_projativ;
        
        $rsCodTriUnid = db_query("select o41_codtri from orcunidade where o41_unidade = " . $oRegistro->o58_unidade . "
                                  and o41_anousu = " . db_getsession('DB_anousu'));
        $oCodTriUnid = db_utils::fieldsMemory($rsCodTriUnid, 0);
        
        if ($oCodTriUnid->o41_codtri == 0) {
          $unidade = $oRegistro->o58_unidade;
        } else {
          $unidade = $oCodTriUnid->o41_codtri;
        }
        
        $rsCodTriOrg = db_query("select o40_codtri from orcorgao where o40_orgao = " . $oRegistro->o58_orgao . "
                      and o40_anousu = " . db_getsession('DB_anousu'));
        $oCodTriOrg = db_utils::fieldsMemory($rsCodTriOrg, 0);
        
        if ($oCodTriOrg->o40_codtri == 0) {
          $org = $oRegistro->o58_orgao;
        } else {
          $org = $oCodTriOrg->o40_codtri;
        }
        
        /**
         * segundo o manual do sicom, a natureza da acao deve ser descrita como 9 em vez do numeral 0 para indicar
         * operacoes especiais
         */
        if ($iTipoProjetoAtividade[0] == "0") {
          $iTipoProjetoAtividade[0] = 9;
        }
        
        
        $sElemento = substr($oRegistro->o56_elemento, 1, 8);
        
        
        $sHash = $oRegistro->o58_instit . $oRegistro->o58_orgao . $oRegistro->o58_unidade . $oRegistro->o58_funcao . $oRegistro->o58_subfuncao;
        $sHash .= $oRegistro->o58_programa . $iTipoProjetoAtividade . $oRegistro->o58_elemento;
        
        if (!isset($aDadosAgrupados[$sHash])) {
          
          /**
           * Caso não exista o indice, um objeto novo será criado
           */
          $oDadosAcao = new stdClass();
  
          $oDadosAcao->tipoRegistro   = 10;
          $oDadosAcao->detalhesessao  = 10;
          $oDadosAcao->codDespesa     = $oRegistro->o58_coddot . $oRegistro->o58_anousu;
          $oDadosAcao->codOrgao       = str_pad($oInstit->si09_codorgaotce, 2, "0", STR_PAD_LEFT);
          $oDadosAcao->codUnidadeSub  = str_pad($org, 2, "0", STR_PAD_LEFT);
          $oDadosAcao->codUnidadeSub .= str_pad($unidade, 3, "0", STR_PAD_LEFT);
          $oDadosAcao->codFuncao      = str_pad($oRegistro->o58_funcao, 2, "0", STR_PAD_LEFT);
          $oDadosAcao->codSubFuncao   = str_pad($oRegistro->o58_subfuncao, 3, "0", STR_PAD_LEFT);
          $oDadosAcao->codPrograma    = str_pad($oRegistro->o58_programa, 4, "0", STR_PAD_LEFT);
          $oDadosAcao->idAcao         = str_pad($iTipoProjetoAtividade, 4, "0", STR_PAD_LEFT);
          $oDadosAcao->idSubAcao      = " ";
          $oDadosAcao->naturezaDespesa = substr($oRegistro->o58_elemento, 1, 6);;
          $oDadosAcao->vlTotalrecurso = 0;
          $oDadosAcao->recursos = array();
          
          $aDadosAgrupados[$sHash] = $oDadosAcao;
          
          
        } else {
          /**
           *caso já exista esse indice no array, ele será passado para o objeto
           */
          $oDadosAcao = $aDadosAgrupados[$sHash];
        }
        $sSqlCodigoRecurso = "SELECT o15_codtri ";
        $sSqlCodigoRecurso .= "  FROM orctiporec ";
        $sSqlCodigoRecurso .= " WHERE o15_codigo = $oRegistro->o58_codigo";
        $rsCodigoRecurso = db_query($sSqlCodigoRecurso);
        $sCodigoRecurso = db_utils::fieldsMemory($rsCodigoRecurso, 0)->o15_codtri;
        
        $oDadosAcaoRecurso = new stdClass();
        $oDadosAcaoRecurso->codFontRecursos = str_pad($sCodigoRecurso, 3, "0", STR_PAD_LEFT);
        $oDadosAcaoRecurso->valorFonte = number_format($oRegistro->dot_ini, 2, ",", "");
        
        /**
         * realiza o somatorio dos recursos relacionados com o registro 10 em questao
         */
        $oDadosAcao->vlTotalrecurso += $oRegistro->dot_ini;
        
        /**
         * passa cada registro 11 relacionado com o registro 10 selecionado
         */
        if ($oRegistro->dot_ini != 0) {
          $oDadosAcao->recursos[] = $oDadosAcaoRecurso;
        }
      }
      
      
      /**
       * o repetição ocorrerá para cada linha do array $aDadosAgrupados passando a linha do registro 10 a ser gerada
       */
      foreach ($aDadosAgrupados as $oDado) {
        if ($oDado->vlTotalrecurso != 0) {
          $oDadosAcao = clone $oDado;
          unset($oDadosAcao->recursos);
          $oDadosAcao->vlTotalrecurso = number_format($oDadosAcao->vlTotalrecurso, 2, ",", "");
          $this->aDados[] = $oDadosAcao;
          /**
           * a repetição adicionará os registros tipo 11 abaixo do registro tipo 10 correspondente para serem gravados no arquivo
           */
          foreach ($oDado->recursos as $oRecurso) {
            
            $oRecurso->tipoRegistro   = 11;
            $oRecurso->detalhesessao  = 11;
            $oRecurso->codDespesa     = $oDadosAcao->codDespesa;
            $this->aDados[] = $oRecurso;
          }
        }
      }
      /**
       * excluir tabela temporaria para a criacao da mesma com os dados da proxima instituicao
       */
      pg_exec("DROP TABLE work_dotacao");
    }
  }
  
  public function setCodigoPespectiva($iCodigoPespectiva)
  {
    $this->iCodigoPespectiva = $iCodigoPespectiva;
  }
  
  public function getCodigoPespectiva()
  {
    return $this->iCodigoPespectiva;
  }
}
