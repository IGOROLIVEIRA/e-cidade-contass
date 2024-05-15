<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

/**
 *
 * selecionar dados de Receita Orcamentaria Sicom Instrumento de Planejamento
 * @author robson
 * @package Contabilidade
 */
class SicomArquivoReceitaOrcamentariaOrgao extends SicomArquivoBase implements iPadArquivoBaseCSV
{
  
  /**
   * Código do layout. (db_layouttxt.db50_codigo)
   *
   * @var Integer
   */
  protected $iCodigoLayout = 142;
  
  /**
   * Nome do arquivo a ser criado
   *
   * @var String
   */
  protected $sNomeArquivo = 'REC';
  
  /**
   * Código da Pespectiva. (ppaversao.o119_sequencial)
   *
   * @var Integer
   */
  protected $iCodigoPespectiva;
  
  /**
   *
   * Construtor da classe
   */
  public function __construct()
  {
    
  }
  
  /**
   * retornar o codio do layout
   *
   * @return Integer
   */
  public function getCodigoLayout()
  {
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   *
   * @return Array
   */
  public function getCampos()
  {
    
    $aElementos[10] = array(
      "tipoRegistro",
      "codReceita",
      "codOrgao",
      "eDeducaoDeReceita",
      "identificadorDeducao",
      "naturezaReceita",
      "especificacao",
      "vlPrevisto"
    );
    $aElementos[11] = array(
      "tipoRegistro",
      "codReceita",
      "codFontRecursos",
      "valorFonte"
    );
    
    return $aElementos;
  }
  
  /**
   * Gerar os dados necessarios para o arquivo
   *
   */
  public function gerarDados()
  {
    
    /**
     * Realizar a selecao das instiuicoes cadastradas
     */
    $sSqlOrgaos = "SELECT * FROM db_config left join infocomplementaresinstit on si09_instit = codigo";
    
    $rsInst = db_query($sSqlOrgaos);
    
    /*
     * RUBRICAS DE RECEITAS ACEITAS PELO TCE-MG
     * */
    $aRectce = array('111202', '111208', '172136', '191138', '191139', '191140', '191308', '191311', '191312', '191313', '193104', '193111', '193112', '193113', '172401', '247199', '247299', '176299', '172199', '172134', '160099', '112299', '176202', '242201', '242202', '222900', '193199', '191199', '176101', '160004', '132810', '132820', '132830', '192210', '242102', '247101', '172402', '172233');
    
    for ($iContador = 0; $iContador < pg_num_rows($rsInst); $iContador++) {
      
      $oInstit = db_utils::fieldsMemory($rsInst, $iContador);
      
      
      /*
       * SQL RETORNA RECEITA ORCADA PARA CADA INSTITUICAO DENTRO DO FOR
      */
      $sSqlReceita = "SELECT * FROM orcfontes f ";
      $sSqlReceita .= "JOIN orcreceita r ON f.o57_codfon = r.o70_codfon ";
      $sSqlReceita .= "AND f.o57_anousu = o70_anousu ";
      $sSqlReceita .= "JOIN orctiporec t ";
      $sSqlReceita .= "ON r.o70_codigo = t.o15_codigo ";
      $sSqlReceita .= "JOIN conplanoorcamento cp on f.o57_codfon = cp.c60_codcon ";
      $sSqlReceita .= "WHERE f.o57_anousu = " . db_getsession("DB_anousu");
      $sSqlReceita .= " AND cp.c60_anousu = " . db_getsession("DB_anousu");
      $sSqlReceita .= " AND r.o70_instit = $oInstit->codigo";
      
      $rsReceita = db_query($sSqlReceita);
      //db_criatabela($rsReceita);
      $aDadosAgrupados = array();
      for ($iCont = 0; $iCont < pg_num_rows($rsReceita); $iCont++) {
        
        $oReceita = db_utils::fieldsMemory($rsReceita, $iCont);
        
        
        if (in_array(substr($oReceita->o57_fonte, 1, 6), $aRectce)) {
          $rubricarec = substr($oReceita->o57_fonte, 1, 6) . "00";
        } else {
          if (substr($oReceita->o57_fonte, 0, 2) == '49') {
            $rubricarec = substr($oReceita->o57_fonte, 3, 8);
            
          } else {
            $rubricarec = substr($oReceita->o57_fonte, 1, 8);
          }
        }
        $iIdentDeducao = (substr($oReceita->o57_fonte, 0, 2) == 49) ? substr($oReceita->c60_estrut, 1, 2) : " ";
        
        $sHash = "10" . $iIdentDeducao . $rubricarec;
        
        if (!isset($aDadosAgrupados[$sHash])) {
          $oDadosReceita = new stdClass();
          $oDadosReceita->tipoRegistro          = 10;
          $oDadosReceita->detalhesessao         = 10;
          $oDadosReceita->codReceita            = substr($oReceita->o57_codfon, 0, 15);
          $oDadosReceita->codOrgao              = str_pad($oInstit->si09_codorgaotce, 2, "0", STR_PAD_LEFT);
          $oDadosReceita->eDeducaoDeReceita     = (substr($oReceita->o57_fonte, 0, 2) == 49) ? "1" : "2";
          $oDadosReceita->identificadorDeducao  = $iIdentDeducao;
          $oDadosReceita->naturezaReceita       = str_pad($rubricarec, 8, "0", STR_PAD_LEFT);
          $oDadosReceita->especificacao         = substr($oReceita->o57_descr, 0, 100);
          $oDadosReceita->vlPrevisto            = 0;
          $oDadosReceita->FonteRecurso = array();
          
          
          $aDadosAgrupados[$sHash] = $oDadosReceita;
          
        } else {
          $oDadosReceita = $aDadosAgrupados[$sHash];
        }
        
        $sHash11 = str_pad($oReceita->o15_codtri, 3, "0", STR_PAD_LEFT);
        
        if (!isset($oDadosReceita->FonteRecurso[$sHash11])) {
          $oDadosFonteRecurso = new stdClass();
          $oDadosFonteRecurso->tipoRegistro   = 11;
          $oDadosFonteRecurso->detalhesessao  = 11;
          $oDadosFonteRecurso->codReceita     = $oDadosReceita->codReceita;
          $oDadosFonteRecurso->codFontRecursos = str_pad($oReceita->o15_codtri, 3, "0", STR_PAD_LEFT);
          $oDadosFonteRecurso->valorFonte     = 0;
          
          $oDadosReceita->FonteRecurso[$sHash11] = $oDadosFonteRecurso;
        } else {
          $oDadosFonteRecurso = $oDadosReceita->FonteRecurso[$sHash11];
        }
        $oDadosFonteRecurso->valorFonte += $oReceita->o70_valor;
        
        $oDadosReceita->vlPrevisto += $oReceita->o70_valor;
        
      }
      
      
      //echo '<pre>';
      //print_r($aDadosAgrupados);
      
      /**
       * passar todos os dados registro 10 para o $this->aDados[]
       */
      
      foreach ($aDadosAgrupados as $oDado) {
        if ($oDado->vlPrevisto != 0) {
          
          $oDadosReceita = clone $oDado;
          unset($oDadosReceita->FonteRecurso);
          $oDadosReceita->vlPrevisto = number_format(abs($oDadosReceita->vlPrevisto), 2, ",", "");
          $this->aDados[] = $oDadosReceita;
          
          /**
           * passar todos os dados registro 11 para o $this->aDados[]
           */
          foreach ($oDado->FonteRecurso as $oFonteRecurso) {
            if ($oFonteRecurso->valorFonte != 0) {
              $oFonteRecurso->valorFonte = number_format(abs($oFonteRecurso->valorFonte), 2, ",", "");
              $this->aDados[] = $oFonteRecurso;
            }
          }
        }
      }
    }
  }
  
  /**
   *
   * passar valor para o $this->iCodigoPespectiva
   * @param Integer $iCodigoPespectiva
   */
  public function setCodigoPespectiva($iCodigoPespectiva)
  {
    $this->iCodigoPespectiva = $iCodigoPespectiva;
  }
  
  /**
   *
   * retornar o valor do $this->iCodigoPespectiva
   * @return Integer
   */
  public function getCodigoPespectiva()
  {
    return $this->iCodigoPespectiva;
  }
}
