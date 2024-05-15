<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_contratos102014_classe.php");
require_once ("classes/db_contratos112014_classe.php");
require_once ("classes/db_contratos122014_classe.php");
require_once ("classes/db_contratos132014_classe.php");
require_once ("classes/db_contratos202014_classe.php");
require_once ("classes/db_contratos212014_classe.php");
require_once ("classes/db_contratos302014_classe.php");
require_once ("classes/db_contratos402014_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarCONTRATOS.model.php");


 /**
  * Contratos Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoContratos extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 163;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'CONTRATOS';
  
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
   *esse metodo sera implementado criando um array com os campos que serao necessarios 
   *para o escritor gerar o arquivo CSV 
   */
  public function getCampos(){
    
  }
  
  /**
   * selecionar os dados de Leis de Alteração
   * 
   */
  public function gerarDados() {
    
    $clcontratos102014 = new cl_contratos102014();
    $clcontratos112014 = new cl_contratos112014();
    $clcontratos122014 = new cl_contratos122014();
    $clcontratos132014 = new cl_contratos132014();
    $clcontratos202014 = new cl_contratos202014();
    $clcontratos212014 = new cl_contratos212014();
    $clcontratos302014 = new cl_contratos302014();
    $clcontratos402014 = new cl_contratos402014();
    
    db_inicio_transacao();

    /*
     * excluir informacoes do mes selecionado registro 13
     */
    /*$result = $clcontratos132014->sql_record($clcontratos132014->sql_query(NULL,"*",NULL,"si86_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']));
    if (pg_num_rows($result) > 0) {
      
      $clcontratos132014->excluir(NULL,"si86_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']);
      if ($clcontratos132014->erro_status == 0) {
        throw new Exception($clcontratos132014->erro_msg);
      }
    }*/
    //echo pg_last_error();exit;
    
    /*
     * excluir informacoes do mes selecionado registro 12
     */
    $result = $clcontratos122014->sql_record($clcontratos122014->sql_query(NULL,"*",NULL,"si85_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si85_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      
      $clcontratos122014->excluir(NULL,"si85_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si85_instit = ".db_getsession("DB_instit"));
      if ($clcontratos122014->erro_status == 0) {
        throw new Exception($clcontratos122014->erro_msg);
      }
    }

     /*
     * excluir informacoes do mes selecionado registro 11
     */
    $result = $clcontratos112014->sql_record($clcontratos112014->sql_query(NULL,"*",NULL,"si84_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si84_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      
      $clcontratos112014->excluir(NULL,"si84_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." si84_instit = ".db_getsession("DB_instit"));
      if ($clcontratos112014->erro_status == 0) {
        throw new Exception($clcontratos112014->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 10
     */
    $result = $clcontratos102014->sql_record($clcontratos102014->sql_query(NULL,"*",NULL,"si83_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si83_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clcontratos102014->excluir(NULL,"si83_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si83_instit = ".db_getsession("DB_instit"));
      if ($clcontratos102014->erro_status == 0) {
        throw new Exception($clcontratos102014->erro_msg);
      }
    }
    
    /*
     * excluir informacoes do mes selecionado registro 21
     */
    $result = $clcontratos212014->sql_record($clcontratos212014->sql_query(NULL,"*",NULL,"si88_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si88_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clcontratos212014->excluir(NULL,"si88_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si88_instit = ".db_getsession("DB_instit"));
      if ($clcontratos212014->erro_status == 0) {
        throw new Exception($clcontratos212014->erro_msg);
      }
    }
    
    /*
     * excluir informacoes do mes selecionado registro 20
     */
    $result = $clcontratos202014->sql_record($clcontratos202014->sql_query(NULL,"*",NULL,"si87_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si87_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clcontratos202014->excluir(NULL,"si87_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si87_instit = ".db_getsession("DB_instit"));
      if ($clcontratos202014->erro_status == 0) {
        throw new Exception($clcontratos202014->erro_msg);
      }
    }
    
    /*
     * excluir informacoes do mes selecionado registro 30
     */
    $result = $clcontratos302014->sql_record($clcontratos302014->sql_query(NULL,"*",NULL,"si89_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si89_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clcontratos302014->excluir(NULL,"si89_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si89_instit = ".db_getsession("DB_instit"));
      if ($clcontratos302014->erro_status == 0) {
        throw new Exception($clcontratos302014->erro_msg);
      }
    }
    
    /*
     * excluir informacoes do mes selecionado registro 40
     */
    $result = $clcontratos402014->sql_record($clcontratos402014->sql_query(NULL,"*",NULL,"si91_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si91_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clcontratos402014->excluir(NULL,"si91_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si91_instit = ".db_getsession("DB_instit"));
      if ($clcontratos402014->erro_status == 0) {
        throw new Exception($clcontratos402014->erro_msg);
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

    $sSql = "select * from contratos where si172_dataassinatura <= '{$this->sDataFinal}' 
    and si172_dataassinatura >= '{$this->sDataInicial}' 
    and si172_instit = ". db_getsession("DB_instit");

    $rsResult10 = db_query($sSql);
    
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
      
      $clcontratos102014 = new cl_contratos102014();

      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

      $sSql  = "select * from db_departorg where db01_coddepto = ".$oDados10->si172_codunidadesubresp;
      
      $rsDepart    = db_query($sSql);
      $sOrgDepart  = db_utils::fieldsMemory($rsDepart, 0)->db01_orgao;
      $sUnidDepart = db_utils::fieldsMemory($rsDepart, 0)->db01_unidade;      

      $clcontratos102014->si83_tiporegistro                  = 10;
      $clcontratos102014->si83_codcontrato                   = $oDados10->si172_sequencial;
      $clcontratos102014->si83_codorgao                      = $sCodorgao;
      $clcontratos102014->si83_codunidadesub                 = str_pad($sOrgDepart, 2, "0", STR_PAD_LEFT).str_pad($sUnidDepart, 3, "0", STR_PAD_LEFT);
      $clcontratos102014->si83_nrocontrato                   = $oDados10->si172_nrocontrato;
      $clcontratos102014->si83_exerciciocontrato             = $oDados10->si172_exerciciocontrato;
      $clcontratos102014->si83_dataassinatura                = $oDados10->si172_dataassinatura;
      $clcontratos102014->si83_contdeclicitacao              = $oDados10->si172_contdeclicitacao;
      $clcontratos102014->si83_codorgaoresp                  = $sCodorgao;
      $clcontratos102014->si83_codunidadesubresp             = str_pad($sOrgDepart, 2, "0", STR_PAD_LEFT).str_pad($sUnidDepart, 3, "0", STR_PAD_LEFT);
      $clcontratos102014->si83_nroprocesso                   = $oDados10->si172_nroprocesso;
      $clcontratos102014->si83_exercicioprocesso             = $oDados10->si172_exercicioprocesso;
      $clcontratos102014->si83_tipoprocesso                  = $oDados10->si172_tipoprocesso;
      $clcontratos102014->si83_naturezaobjeto                = $oDados10->si172_naturezaobjeto;
      $clcontratos102014->si83_objetocontrato                = $oDados10->si172_objetocontrato;
      $clcontratos102014->si83_tipoinstrumento               = $oDados10->si172_tipoinstrumento;
      $clcontratos102014->si83_datainiciovigencia            = $oDados10->si172_datainiciovigencia;
      $clcontratos102014->si83_datafinalvigencia             = $oDados10->si172_datafinalvigencia;
      $clcontratos102014->si83_vlcontrato                    = $oDados10->si172_vlcontrato;
      $clcontratos102014->si83_formafornecimento             = $oDados10->si172_formafornecimento;
      $clcontratos102014->si83_formapagamento                = $oDados10->si172_formapagamento;
      $clcontratos102014->si83_prazoexecucao                 = $oDados10->si172_prazoexecucao;
      $clcontratos102014->si83_multarescisoria               = $oDados10->si172_multarescisoria;
      $clcontratos102014->si83_multainadimplemento           = $oDados10->si172_multainadimplemento;
      $clcontratos102014->si83_garantia                      = $oDados10->si172_garantia;
      $clcontratos102014->si83_cpfsignatariocontratante      = $oDados10->si172_cpfsignatariocontratante;
      $clcontratos102014->si83_datapublicacao                = $oDados10->si172_datapublicacao;
      $clcontratos102014->si83_veiculodivulgacao             = $oDados10->si172_veiculodivulgacao;
      $clcontratos102014->si83_mes                           = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clcontratos102014->si83_instit                        = $oDados10->si172_instit;
      
      $clcontratos102014->incluir(null);

      if ($clcontratos102014->erro_status == 0) {
        throw new Exception($clcontratos102014->erro_msg);
      }
        
      /*
       * selecionar informacoes registro 11
       */

      $sSql = "select * from contratos inner join empcontratos on si173_codcontrato = si172_sequencial 
      where si172_dataassinatura <= '{$this->sDataFinal}' and si172_dataassinatura >= '{$this->sDataInicial}' 
      and si172_instit = ". db_getsession("DB_instit") ." and si172_sequencial = ".$clcontratos102014->si83_sequencial;

      $rsResult11 = db_query($sSql);

      for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {
        
        $clcontratos112014 = new cl_contratos112014();
        $oDados11 = db_utils::fieldsMemory($rsResult11, $iCont11);

        $sSql   = "SELECT pc01_codmater,m60_codmater,m60_codmatunid,m61_descr,e60_numemp, e60_codemp, e60_anousu,e60_emiss, pc01_descrmater, "; 
        $sSql  .= "e62_quant, e62_vlrun from empempenho ";
        $sSql  .= "left join empempitem on e62_numemp = e60_numemp ";
        $sSql  .= "left join pcmater on e62_item = pc01_codmater left join transmater on pc01_codmater =  m63_codpcmater ";
        $sSql  .= "left join matmater on m60_codmater = m63_codmatmater";
        $sSql  .= "left join matunid on m60_codmatunid = m61_codmatunid "; 
        $sSql  .= "where e60_numemp = '".$oDados11->si173_empenho ."' and e60_anousu = '".$oDados11->si173_anoempenho ."'";
        $sSql  .= " and e60_anousu = ".db_getsession("DB_anousu")." ";

        $rsEmpempenho = db_query($sSql);
        
        $clcontratos112014->si84_tiporegistro           = 11;
        $clcontratos112014->si84_reg10                  = $clcontratos102014->si83_sequencial;
        $clcontratos112014->si84_codcontrato            = $oDados11->si173_codcontrato;
        $clcontratos112014->si84_coditem                = db_utils::fieldsMemory($rsEmpempenho, 0)->pc01_codmater;
        $clcontratos112014->si84_quantidadeitem         = number_format(db_utils::fieldsMemory($rsEmpempenho, 0)->e62_quant, 4, "", "");
        $clcontratos112014->si84_valorunitarioitem      = number_format(db_utils::fieldsMemory($rsEmpempenho, 0)->e62_vlrun, 4, "", "");
        $clcontratos112014->si84_mes                    = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $clcontratos112014->si84_instit                 = db_getsession("DB_instit");
        
        $clcontratos112014->incluir(null);

        if ($clcontratos112014->erro_status == 0) {
          throw new Exception($clcontratos112014->erro_msg);
        }
        
      }

      /*
       * selecionar informacoes registro 12
       */

      $sSql = "select * from contratos inner join empcontratos on si173_codcontrato = si172_sequencial 
      where si172_dataassinatura <= '{$this->sDataFinal}' and si172_dataassinatura >= '{$this->sDataInicial}' 
      and si172_instit = ". db_getsession("DB_instit") ." and si172_sequencial = ".$clcontratos102014->si83_sequencial;

      $rsResult12 = db_query($sSql);
      for ($iCont12 = 0; $iCont12 < pg_num_rows($rsResult12); $iCont12++) {
        
        $clcontratos122014 = new cl_contratos122014();
        $oDados12 = db_utils::fieldsMemory($rsResult12, $iCont12);


        $sSql    = "SELECT o58_orgao, o58_unidade, o58_funcao, o58_subfuncao,o58_programa,o58_projativ,";
        $sSql   .= "o56_elemento,o15_codtri from empempenho ";
        $sSql   .= "join orcdotacao on e60_coddot = o58_coddot "; 
        $sSql   .= "join orcelemento on o58_codele = o56_codele and o56_anousu =   ".db_getsession("DB_anousu"); 
        $sSql   .= " join orctiporec on o58_codigo = o15_codigo"; 
        $sSql   .= " where o58_anousu =  ".db_getsession("DB_anousu")." and e60_anousu = ".db_getsession("DB_anousu"); 
        $sSql   .= " and e60_numemp = '".$oDados12->si173_empenho ."' and e60_anousu = '".$oDados12->si173_anoempenho ."'";
        $sSql   .= " and e60_anousu = ".db_getsession("DB_anousu")." ";    

        $rsDados = db_query($sSql);
        
        $clcontratos122014->si85_tiporegistro           = 12;
        $clcontratos122014->si85_reg10                  = $clcontratos102014->si83_sequencial;
        $clcontratos122014->si85_codcontrato            = $oDados12->si173_codcontrato;
        $clcontratos122014->si85_codorgao               = $sCodorgao;
        $clcontratos122014->si85_codunidadesub          = str_pad(db_utils::fieldsMemory($rsDados, 0)->o58_orgao, 2, "0", STR_PAD_LEFT).str_pad(db_utils::fieldsMemory($rsDados, 0)->o58_unidade, 3, "0", STR_PAD_LEFT);
        $clcontratos122014->si85_codfuncao              = db_utils::fieldsMemory($rsDados, 0)->o58_funcao;
        $clcontratos122014->si85_codsubfuncao           = db_utils::fieldsMemory($rsDados, 0)->o58_subfuncao;
        $clcontratos122014->si85_codprograma            = db_utils::fieldsMemory($rsDados, 0)->o58_programa;
        $clcontratos122014->si85_idacao                 = db_utils::fieldsMemory($rsDados, 0)->o58_projativ;
        $clcontratos122014->si85_idsubacao              = " ";
        $clcontratos122014->si85_naturezadespesa        = db_utils::fieldsMemory($rsDados, 0)->o56_elemento;
        $clcontratos122014->si85_codfontrecursos        = db_utils::fieldsMemory($rsDados, 0)->o15_codtri;
        $clcontratos122014->si85_vlrecurso              = db_utils::fieldsMemory($rsDados, 0)->o58_valor;
        $clcontratos122014->si85_mes                    = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $clcontratos122014->si85_instit                 = db_getsession("DB_instit");
        
        $clcontratos122014->incluir(null);

        if ($clcontratos122014->erro_status == 0) {
          throw new Exception($clcontratos122014->erro_msg);
        }
        
      }
 
    }
    
    /*
     * selecionar informacoes registro 20
     */
    $sSql       = "select * from aditivoscontratos 
    where si174_dataassinaturacontoriginal <= '{$this->sDataFinal}' 
    and si174_dataassinaturacontoriginal >= '{$this->sDataInicial}' 
    and si174_instit = ". db_getsession("DB_instit") ." ";
        
    $rsResult20 = db_query($sSql);
    
    for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {
      
      $clcontratos202014 = new cl_contratos202014();
      $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);
      
      $clcontratos202014->si87_tiporegistro                   = 20;
      $clcontratos202014->si87_codaditivo                     = $oDados20->si174_codaditivo;
      $clcontratos202014->si87_codorgao                       = $sCodorgao;
      $clcontratos202014->si87_codunidadesub                  = $oDados20->si174_codunidadesub;
      $clcontratos202014->si87_nrocontrato                    = $oDados20->si174_nrocontrato;
      $clcontratos202014->si87_dataassinaturacontoriginal     = $oDados20->si174_dataassinaturacontoriginal;
      $clcontratos202014->si87_nroseqtermoaditivo             = $oDados20->si174_nroseqtermoaditivo;
      $clcontratos202014->si87_dtassinaturatermoaditivo       = $oDados20->si174_dataassinaturatermoaditivo;
      $clcontratos202014->si87_tipoalteracaovalor             = $oDados20->si174_tipoalteracaovalor;
      $clcontratos202014->si87_tipotermoaditivo               = $oDados20->si174_tipotermoaditivo;
      $clcontratos202014->si87_dscalteracao                   = $oDados20->si174_dscalteracao;
      $clcontratos202014->si87_novadatatermino                = $oDados20->si174_novadatatermino;
      $clcontratos202014->si87_valoraditivo                   = $oDados20->si174_valoraditivo;
      $clcontratos202014->si87_datapublicacao                 = $oDados20->si174_datapublicacao;
      $clcontratos202014->si87_veiculodivulgacao              = $oDados20->si174_veiculodivulgacao;
      $clcontratos202014->si87_mes                            = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clcontratos202014->si87_instit                         = $oDados20->si174_instit;
      
      $clcontratos202014->incluir(null);
      if ($clcontratos202014->erro_status == 0) {
        throw new Exception($clcontratos202014->erro_msg);
      }
      
      /*
       * selecionar informacoes registro 21
       */

      $sSql = "select * from aditivoscontratos 
      inner join itensaditivados on si174_sequencial = si175_codaditivo 
      where si174_dataassinaturacontoriginal <= '{$this->sDataFinal}' 
      and si174_dataassinaturacontoriginal >= '{$this->sDataInicial}' 
      and si174_sequencial = ". $clcontratos202014->si87_sequencial ."
      and si174_instit = ". db_getsession("DB_instit") ." ";

      $rsResult21 = db_query($sSql);
      for ($iCont21 = 0; $iCont21 < pg_num_rows($rsResult21); $iCont21++) {
        
        $clcontratos212014 = new cl_contratos212014();
        $oDados21 = db_utils::fieldsMemory($rsResult21, $iCont21);
        
        $clcontratos212014->si88_tiporegistro            = 21;
        $clcontratos212014->si88_reg20                   = $clcontratos202014->si87_sequencial;
        $clcontratos212014->si88_codaditivo              = $oDados21->si175_codaditivo;
        $clcontratos212014->si88_tipoalteracaoitem       = $oDados21->si175_tipoalteracaoitem;
        $clcontratos212014->si88_quantacrescdecresc      = $oDados21->si175_quantacrescdecresc;
        $clcontratos212014->si88_valorunitarioitem       = $oDados21->si175_valorunitarioitem;
        $clcontratos212014->si88_mes                     = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $clcontratos212014->si88_instit                  = $oDados21->si174_instit;
        
        $clcontratos212014->incluir(null);
        if ($clcontratos212014->erro_status == 0) {
          throw new Exception($clcontratos212014->erro_msg);
        }
        
      }
      
    }

    /*
     * selecionar informacoes registro 30
     */
    $sSql       = "select * from apostilamento 
    where si03_dataassinacontrato <= '{$this->sDataFinal}' 
    and si03_dataassinacontrato >= '{$this->sDataInicial}'
    and si03_instit = ". db_getsession("DB_instit");
        
    $rsResult30 = db_query($sSql);
    
    for ($iCont30 = 0; $iCont30 < pg_num_rows($rsResult30); $iCont30++) {
      
      $clcontratos302014 = new cl_contratos302014();
      $oDados30 = db_utils::fieldsMemory($rsResult30, $iCont30);
      
      $clcontratos302014->si89_tiporegistro                   = 30;
      $clcontratos302014->si89_codorgao                       = $sCodorgao;
      $clcontratos302014->si89_codunidadesub                  = " ";
      $clcontratos302014->si89_nrocontrato                    = $oDados30->si03_numcontrato;
      $clcontratos302014->si89_dtassinaturacontoriginal       = $oDados30->si03_dataassinacontrato;
      $clcontratos302014->si89_tipoapostila                   = $oDados30->si03_tipoapostila;
      $clcontratos302014->si89_nroseqapostila                 = $oDados30->si03_numapostilamento;
      $clcontratos302014->si89_dataapostila                   = $oDados30->si03_dataapostila;
      $clcontratos302014->si89_tipoalteracaoapostila          = $oDados30->si03_tipoalteracaoapostila;
      $clcontratos302014->si89_dscalteracao                   = $oDados30->si03_descrapostila;
      $clcontratos302014->si89_valorapostila                  = $oDados30->si03_valorapostila;
      $clcontratos302014->si89_mes                            = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clcontratos302014->si89_instit                         = $oDados30->si03_instit;
    
      $clcontratos302014->incluir(null);
      if ($clcontratos302014->erro_status == 0) {
        throw new Exception($clcontratos302014->erro_msg);
      }

    }

     /*
     * selecionar informacoes registro 40
     */
    $sSql       = "select * from rescisaocontrato 
      join contratos on si176_nrocontrato = si172_sequencial
      where si176_dataassinaturacontoriginal <= '{$this->sDataFinal}' 
      and si176_dataassinaturacontoriginal >= '{$this->sDataInicial}' 
      and si172_instit = ".db_getsession("DB_instit");
    
    $rsResult40 = db_query($sSql);
    
    for ($iCont40 = 0; $iCont40 < pg_num_rows($rsResult40); $iCont40++) {
      
      $clcontratos402014 = new cl_contratos402014();
      $oDados40 = db_utils::fieldsMemory($rsResult40, $iCont40);
      
      $clcontratos402014->si91_tiporegistro                   = 40;
      $clcontratos402014->si91_codorgao                       = $sCodorgao;
      $clcontratos402014->si91_codunidadesub                  = " ";
      $clcontratos402014->si91_nrocontrato                    = $oDados40->si176_nrocontrato;
      $clcontratos402014->si91_dtassinaturacontoriginal       = $oDados40->si176_dataassinaturacontoriginal;
      $clcontratos402014->si91_datarescisao                   = $oDados40->si1176_datarescisao;
      $clcontratos402014->si91_valorcancelamentocontrato      = $oDados40->si176_valorcancelamentocontrato;
      $clcontratos402014->si91_mes                            = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clcontratos402014->si91_instit                         = $oDados40->si172_instit;

      $clcontratos402014->incluir(null);

      if ($clcontratos402014->erro_status == 0) {
        throw new Exception($clcontratos402014->erro_msg);
      }
      
    }

    db_fim_transacao();
    
    $oGerarCONTRATOS = new GerarCONTRATOS();
    $oGerarCONTRATOS->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarCONTRATOS->gerarDados();
    
  }
  
}			