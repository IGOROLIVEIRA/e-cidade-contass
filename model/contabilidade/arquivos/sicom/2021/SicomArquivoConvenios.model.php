<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_lao10$PROXIMO_ANO_classe.php");
require_once ("classes/db_lao11$PROXIMO_ANO_classe.php");
require_once ("classes/db_lao20$PROXIMO_ANO_classe.php");
require_once ("classes/db_lao21$PROXIMO_ANO_classe.php");
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
        
    $clconv10$PROXIMO_ANO = new cl_conv10$PROXIMO_ANO();
    $clconv11$PROXIMO_ANO = new cl_conv11$PROXIMO_ANO();
    $clconv20$PROXIMO_ANO = new cl_conv20$PROXIMO_ANO();
    
    db_inicio_transacao();



      /*
     * excluir informacoes do mes selecionado registro 11
     */
    $result = $clconv11$PROXIMO_ANO->sql_record($clconv11$PROXIMO_ANO->sql_query(NULL,"*",NULL,"si93_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si93_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      
      $clconv11$PROXIMO_ANO->excluir(NULL,"si93_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si93_instit = ".db_getsession("DB_instit") );
      if ($clconv11$PROXIMO_ANO->erro_status == 0) {
        throw new Exception($clconv11$PROXIMO_ANO->erro_msg);
      }
    }
    

    /*
     * excluir informacoes do mes selecionado registro 10
     */

    $result = $clconv10$PROXIMO_ANO->sql_record($clconv10$PROXIMO_ANO->sql_query(NULL,"*",NULL,"si92_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si92_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $clconv10$PROXIMO_ANO->excluir(NULL,"si92_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6'] ." and si92_instit = ".db_getsession("DB_instit"));
      if ($clconv10$PROXIMO_ANO->erro_status == 0) {
        throw new Exception($clconv10$PROXIMO_ANO->erro_msg);
      }
    }
    
    /*
     * excluir informacoes do mes selecionado registro 20
     */
    $result = $clconv20$PROXIMO_ANO->sql_record($clconv20$PROXIMO_ANO->sql_query(NULL,"*",NULL,"si94_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si94_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $clconv20$PROXIMO_ANO->excluir(NULL,"si94_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si93_instit = ".db_getsession("DB_instit"));
      if ($clconv20$PROXIMO_ANO->erro_status == 0) {
        throw new Exception($clconv20$PROXIMO_ANO->erro_msg);
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
      
      $clconv10$PROXIMO_ANO = new cl_conv10$PROXIMO_ANO();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
      
      $clconv10$PROXIMO_ANO->si92_tiporegistro          = 10;
      $clconv10$PROXIMO_ANO->si92_codconvenio           = $oDados10->c206_sequencial;
      $clconv10$PROXIMO_ANO->si92_codorgao              = $sCodorgao;
      $clconv10$PROXIMO_ANO->si92_nroconvenio           = $oDados10->c206_nroconvenio;
      $clconv10$PROXIMO_ANO->si92_dataassinatura        = $oDados10->c206_dataassinatura;
      $clconv10$PROXIMO_ANO->si92_objetoconvenio        = $oDados10->c206_objetoconvenio;
      $clconv10$PROXIMO_ANO->si92_datainiciovigencia    = $oDados10->c206_datainiciovigencia;
      $clconv10$PROXIMO_ANO->si92_datafinalvigencia     = $oDados10->c206_datafinalvigencia;
      $clconv10$PROXIMO_ANO->si92_vlconvenio            = $oDados10->c206_vlconvenio;
      $clconv10$PROXIMO_ANO->si92_vlcontrapartida       = $oDados10->c206_vlcontrapartida;
      $clconv10$PROXIMO_ANO->si92_mes                   = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clconv10$PROXIMO_ANO->si92_instit                = db_getsession("DB_instit");

      $clconv10$PROXIMO_ANO->incluir(null);

      if ($clconv10$PROXIMO_ANO->erro_status == 0) {
        throw new Exception($clconv10$PROXIMO_ANO->erro_msg);
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
          
        $clconv11$PROXIMO_ANO = new cl_conv11$PROXIMO_ANO();
        $oDados11 = db_utils::fieldsMemory($rsResult11, $iCont11);
        
        $clconv11$PROXIMO_ANO->si93_tiporegistro          = 11;
        $clconv11$PROXIMO_ANO->si93_codconvenio           = $oDados10->c206_sequencial;
        $clconv11$PROXIMO_ANO->si93_tipodocumento         = 2;
        $clconv11$PROXIMO_ANO->si93_nrodocumento          = $oDados11->c207_nrodocumento;
        $clconv11$PROXIMO_ANO->si93_esferaconcedente      = $oDados11->c207_esferaconcedente;
        $clconv11$PROXIMO_ANO->si93_valorconcedido        = $oDados11->c207_valorconcedido;
        $clconv11$PROXIMO_ANO->si93_mes                   = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $clconv11$PROXIMO_ANO->si93_reg10                 = $clconv10$PROXIMO_ANO->si92_sequencial;
        $clconv11$PROXIMO_ANO->si93_instit                = db_getsession("DB_instit");

        $clconv11$PROXIMO_ANO->incluir(null);

        if ($clconv11$PROXIMO_ANO->erro_status == 0) {
          throw new Exception($clconv11$PROXIMO_ANO->erro_msg);
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
      
      $clconv20$PROXIMO_ANO = new cl_conv20$PROXIMO_ANO();
      $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);

      $clconv20$PROXIMO_ANO->si94_tiporegistro                     = 20;
      $clconv20$PROXIMO_ANO->si94_codorgao                         = $sCodorgao;
      $clconv20$PROXIMO_ANO->si94_nroconvenio                      = $oDados20->c208_codconvenio;
      $clconv20$PROXIMO_ANO->si94_dtassinaturaconvoriginal         = $oDados20->c206_dataassinatura;
      $clconv20$PROXIMO_ANO->si94_nroseqtermoaditivo               = $oDados20->c208_nroseqtermo;
      $clconv20$PROXIMO_ANO->si94_dscalteracao                     = $oDados20->c208_dscalteracao;
      $clconv20$PROXIMO_ANO->si94_dtassinaturatermoaditivo         = $oDados20->c208_dataassinaturatermoaditivo;
      $clconv20$PROXIMO_ANO->si94_datafinalvigencia                = $oDados20->c208_datafinalvigencia;
      $clconv20$PROXIMO_ANO->si94_valoratualizadoconvenio          = $oDados20->c208_valoratualizadoconvenio;
      $clconv20$PROXIMO_ANO->si94_valoratualizadocontrapartida     = $oDados20->c208_valoratualizadocontrapartida;
      $clconv20$PROXIMO_ANO->si94_mes                              = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clconv20$PROXIMO_ANO->si94_instit                           = db_getsession("DB_instit");
      
      $clconv20$PROXIMO_ANO->incluir(null);
      if ($clconv20$PROXIMO_ANO->erro_status == 0) {
        throw new Exception($clconv20$PROXIMO_ANO->erro_msg);
      }
      
    }
      
    }
    
    db_fim_transacao();
    
    $oGerarCONV = new GerarCONV();
    $oGerarCONV->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarCONV->gerarDados();
    
  }
  
}
