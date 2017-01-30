<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_lao102014_classe.php");
require_once ("classes/db_lao112014_classe.php");
require_once ("classes/db_lao202014_classe.php");
require_once ("classes/db_lao212014_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarCONV.model.php");

 /**
  * selecionar dados de Convenios Sicom Acompanhamento Mensal
  * @author Marcelo
  * @package Contabilidade
  */
class SicomArquivoConvenios extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
  /**
   * 
   * Codigo do layout
   * @var Integer
   */
  protected $iCodigoLayout;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var unknown_type
   */
  protected $sNomeArquivo = 'CONV';
  
  /* 
   * Contrutor da classe
   */
  public function __construct() {
    
  }
  
  /**
   * retornar o codigo do layout
   * 
   *@return Integer
   */
  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   *@return Array 
   */
  public function getCampos(){}
  
  /**
   * selecionar os dados de Leis de Alteração
   * 
   */
  public function gerarDados() {
        
    $clconv102014 = new cl_conv102014();
    $clconv112014 = new cl_conv112014();
    $clconv202014 = new cl_conv202014();
    
    db_inicio_transacao();



      /*
     * excluir informacoes do mes selecionado registro 11
     */
    $result = $clconv112014->sql_record($clconv112014->sql_query(NULL,"*",NULL,"si93_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si93_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      
      $clconv112014->excluir(NULL,"si93_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si93_instit = ".db_getsession("DB_instit") );
      if ($clconv112014->erro_status == 0) {
        throw new Exception($clconv112014->erro_msg);
      }
    }
    

    /*
     * excluir informacoes do mes selecionado registro 10
     */

    $result = $clconv102014->sql_record($clconv102014->sql_query(NULL,"*",NULL,"si92_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si92_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $clconv102014->excluir(NULL,"si92_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6'] ." and si92_instit = ".db_getsession("DB_instit"));
      if ($clconv102014->erro_status == 0) {
        throw new Exception($clconv102014->erro_msg);
      }
    }
    
    /*
     * excluir informacoes do mes selecionado registro 20
     */
    $result = $clconv202014->sql_record($clconv202014->sql_query(NULL,"*",NULL,"si94_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si94_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $clconv202014->excluir(NULL,"si94_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si93_instit = ".db_getsession("DB_instit"));
      if ($clconv202014->erro_status == 0) {
        throw new Exception($clconv202014->erro_msg);
      }
    }
    
    $sSql  = "SELECT si09_codorgaotce AS codorgao
              FROM infocomplementaresinstit
              WHERE si09_instit = ".db_getsession("DB_instit");
    
    $rsResult  = db_query($sSql);
    $sCodorgao = db_utils::fieldsMemory($rsResult, 0)->codorgao;

    /*
     * selecionar informacoes registro 10
     */
    $sSql   = "select * from convconvenios where c206_dataassinatura >= '{$this->sDataInicial}' and c206_dataassinatura <= '{$this->sDataFinal}' and c206_instit = ".db_getsession("DB_instit");

    $rsResult10 = db_query($sSql);
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
      
      $clconv102014 = new cl_conv102014();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
      
      $clconv102014->si92_tiporegistro          = 10;
      $clconv102014->si92_codconvenio           = $oDados10->c206_sequencial;
      $clconv102014->si92_codorgao              = $sCodorgao;
      $clconv102014->si92_nroconvenio           = $oDados10->c206_nroconvenio;
      $clconv102014->si92_dataassinatura        = $oDados10->c206_dataassinatura;
      $clconv102014->si92_objetoconvenio        = $oDados10->c206_objetoconvenio;
      $clconv102014->si92_datainiciovigencia    = $oDados10->c206_datainiciovigencia;
      $clconv102014->si92_datafinalvigencia     = $oDados10->c206_datafinalvigencia;
      $clconv102014->si92_vlconvenio            = $oDados10->c206_vlconvenio;
      $clconv102014->si92_vlcontrapartida       = $oDados10->c206_vlcontrapartida;
      $clconv102014->si92_mes                   = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clconv102014->si92_instit                = db_getsession("DB_instit");

      $clconv102014->incluir(null);

      if ($clconv102014->erro_status == 0) {
        throw new Exception($clconv102014->erro_msg);
      }
      /*
       * selecionar informacoes registro 11
       */
      $sSql = "select * from convdetalhaconcedentes cd
               inner join convconvenios cc on cc.c206_sequencial = cd.c207_codconvenio
               where c206_dataassinatura >= '{$this->sDataInicial}' and c206_dataassinatura <= '{$this->sDataFinal}' 
               and c207_codconvenio = '{$oDados10->c206_sequencial}' 
               and c206_instit = ".db_getsession("DB_instit");
      
      $rsResult11 = db_query($sSql);
      
      for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {
          
        $clconv112014 = new cl_conv112014();
        $oDados11 = db_utils::fieldsMemory($rsResult11, $iCont11);
        
        $clconv112014->si93_tiporegistro          = 11;
        $clconv112014->si93_codconvenio           = $oDados10->c206_sequencial;
        $clconv112014->si93_tipodocumento         = 2;
        $clconv112014->si93_nrodocumento          = $oDados11->c207_nrodocumento;
        $clconv112014->si93_esferaconcedente      = $oDados11->c207_esferaconcedente;
        $clconv112014->si93_valorconcedido        = $oDados11->c207_valorconcedido;
        $clconv112014->si93_mes                   = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $clconv112014->si93_reg10                 = $clconv102014->si92_sequencial;
        $clconv112014->si93_instit                = db_getsession("DB_instit");

        $clconv112014->incluir(null);

        if ($clconv112014->erro_status == 0) {
          throw new Exception($clconv112014->erro_msg);
        }
        
      }

      /*
     * selecionar informacoes registro 20
     */
    $sSql = "select * from convdetalhatermos cdt
               inner join convconvenios cc on cc.c206_sequencial = cdt.c208_codconvenio
               where c208_dataassinaturatermoaditivo >= '{$this->sDataInicial}' and c208_dataassinaturatermoaditivo <= '{$this->sDataFinal}'
               and c208_codconvenio = '{$oDados10->c206_sequencial}' 
               and c206_instit = ".db_getsession("DB_instit");
    
    $rsResult20 = db_query($sSql);
    
    for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {
      
      $clconv202014 = new cl_conv202014();
      $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);

      $clconv202014->si94_tiporegistro                     = 20;
      $clconv202014->si94_codorgao                         = $sCodorgao;
      $clconv202014->si94_nroconvenio                      = $oDados20->c208_codconvenio;
      $clconv202014->si94_dtassinaturaconvoriginal         = $oDados20->c206_dataassinatura;
      $clconv202014->si94_nroseqtermoaditivo               = $oDados20->c208_nroseqtermo;
      $clconv202014->si94_dscalteracao                     = $oDados20->c208_dscalteracao;
      $clconv202014->si94_dtassinaturatermoaditivo         = $oDados20->c208_dataassinaturatermoaditivo;
      $clconv202014->si94_datafinalvigencia                = $oDados20->c208_datafinalvigencia;
      $clconv202014->si94_valoratualizadoconvenio          = $oDados20->c208_valoratualizadoconvenio;
      $clconv202014->si94_valoratualizadocontrapartida     = $oDados20->c208_valoratualizadocontrapartida;
      $clconv202014->si94_mes                              = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clconv202014->si94_instit                           = db_getsession("DB_instit");
      
      $clconv202014->incluir(null);
      if ($clconv202014->erro_status == 0) {
        throw new Exception($clconv202014->erro_msg);
      }
      
    }
      
    }
    
    db_fim_transacao();
    
    $oGerarCONV = new GerarCONV();
    $oGerarCONV->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarCONV->gerarDados();
    
  }
  
}