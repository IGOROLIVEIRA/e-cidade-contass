<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

class SicomArquivoProgramaPPA extends SicomArquivoBase implements iPadArquivoBaseCSV
{
  
  protected $iCodigoLayout = 137;
  
  protected $sNomeArquivo = 'PRO';
  
  protected $iCodigoPespectiva;
  
  public function __construct()
  {
    
  }
  
  public function getCodigoLayout()
  {
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   */
  public function getCampos()
  {
    
    $aElementos = array(
      "codPrograma",
      "nomePrograma",
      "objetivo",
      "totRecursos1Ano",
      "totRecursos2Ano",
      "totRecursos3Ano",
      "totRecursos4Ano"
    );
    
    return $aElementos;
  }
  
  public function gerarDados()
  {
    require_once("model/ppaVersao.model.php");
    require_once("model/ppadespesa.model.php");
    
    $oPPAVersao = new ppaVersao($this->getCodigoPespectiva());
    $oPPADespesa = new ppaDespesa($this->getCodigoPespectiva());
    
    $sSqlInstit = "SELECT codigo FROM db_config ";
    $rsInstit = db_query($sSqlInstit);
    
    // Lista das instituições
    for ($iCont = 0; $iCont < pg_num_rows($rsInstit); $iCont++) {
      
      $oReceita = db_utils::fieldsMemory($rsInstit, $iCont);
      $sListaInstit[] = $oReceita->codigo;
    }
  
    $sListaInstit = implode(",", $sListaInstit);
    
    $sSqlPPA =  "select * from ppaestimativadespesa where o07_anousu = ". db_getsession("DB_anousu");
    $rsProgramaPPA = db_query($sSqlPPA);
    /**
     * pegar estimativas por programa
     */
    if(pg_num_rows($rsProgramaPPA) > 0){
      $oPPADespesa->setInstituicoes($sListaInstit);
      $aDespesa = $oPPADespesa->getQuadroEstimativas(null, 5);
    }    
    
    $sSqlPrograma = "SELECT DISTINCT p.o54_programa, p.o54_descr, p.o54_finali ";
    $sSqlPrograma .= "FROM orcprograma p inner join orcdotacao on o58_anousu = p.o54_anousu and o58_programa = p.o54_programa ";
    $sSqlPrograma .= "WHERE p.o54_anousu = ". db_getsession("DB_anousu");
    
    $rsPrograma = db_query($sSqlPrograma) or die($sSqlPrograma);
    $aCaracteres = array("°", chr(13), chr(10), "", "
");
    
    $sSqlVALOR = "select o58_programa,o28_anoref,round(sum(o28_valor),2) as o28_valor from orcdotacao inner join orcprojativprogramfisica on o28_orcprojativ = o58_projativ and o28_anousu = o58_anousu where o58_anousu = " . db_getsession("DB_anousu") . "  group by o58_programa,o28_anoref order by o58_programa,o28_anoref";

    $rsVALOR = db_query($sSqlVALOR);

    for ($iCont = 0; $iCont < pg_num_rows($rsPrograma); $iCont++) {
      
      $oPrograma = db_utils::fieldsMemory($rsPrograma, $iCont);

      $oDadosPRO = new stdClass();
      
      $oDadosPRO->codPrograma = str_pad($oPrograma->o54_programa, 4, "0", STR_PAD_LEFT);
      $oDadosPRO->nomePrograma = substr($oPrograma->o54_descr, 0, 100);
      $sDescricao = str_replace($aCaracteres, "", substr($oPrograma->o54_finali, 0, 230));
      if (!isset($oPrograma->o54_finali)) {
        $oDadosPRO->objetivo = $sDescricao;
      } else {
        $oDadosPRO->objetivo = substr($oPrograma->o54_descr, 0, 100);
      }
      /* caso tenha ppa feito pelo sistema ira gera por este for os valores do arquivo
      */
      foreach ($aDespesa as $sEstimativa) {
        
        if ($sEstimativa->iCodigo == $oPrograma->o54_programa) {
          
          $iNum = 1;
          foreach ($sEstimativa->aEstimativas as $iAno => $nValorAno) {
            
            if ($iAno == db_getsession("DB_anousu")) {
              
              $sqlValorProg = "select sum(o58_valor) as valor ";
              $sqlValorProg .= "  from orcdotacao where o58_anousu = " . db_getsession("DB_anousu") . " 
                                       and o58_programa = " . $oPrograma->o54_programa;
              $rsValorPrograma = db_query($sqlValorProg);
              $nValorAno = db_utils::fieldsMemory($rsValorPrograma, 0)->valor;
              
            }
            
            if ($nValorAno == '') {
              $nValorAno = 0;
            }
            $sRecurso = "totRecursos" . $iNum . "Ano";
            $oDadosPRO->$sRecurso = number_format($nValorAno, 2, ",", "");
            $iNum++;
          }
        }
      }
      if(pg_num_rows($rsProgramaPPA) <= 0){
        /** caso não exista ppa no sistema será feito este for.
        */
        $iNum = 1;
        for ($iCont1 = 0; $iCont1 < pg_num_rows($rsVALOR); $iCont1++) {
      
          $oProgramaValor = db_utils::fieldsMemory($rsVALOR, $iCont1);

          if ($oProgramaValor->o58_programa == $oPrograma->o54_programa) {
              
            if ($oProgramaValor->o28_anoref == db_getsession("DB_anousu")) {
              
              $sqlValorProg = "select sum(o58_valor) as valor ";
              $sqlValorProg .= "  from orcdotacao where o58_anousu = " . db_getsession("DB_anousu") . " 
                                       and o58_programa = " . $oPrograma->o54_programa;
              $rsValorPrograma = db_query($sqlValorProg);
              $nValorAno = db_utils::fieldsMemory($rsValorPrograma, 0)->valor;
              
            }else{
              $nValorAno = $oProgramaValor->o28_valor;
            }
            $sRecurso = "totRecursos" . $iNum . "Ano";
            $oDadosPRO->$sRecurso = number_format($nValorAno, 2, ",", "");
            $iNum++;
          
          }

        }
      }
      if ($oDadosPRO->totRecursos1Ano > 0 || $oDadosPRO->totRecursos2Ano > 0 || $oDadosPRO->totRecursos3Ano > 0 || $oDadosPRO->totRecursos4Ano > 0) {
        $this->aDados[] = $oDadosPRO;
      }
    }
    //echo "<pre>";
    //print_r($this->aDados);
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
