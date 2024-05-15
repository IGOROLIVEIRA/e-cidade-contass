<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_conv102018_classe.php");
require_once("classes/db_conv112018_classe.php");
require_once("classes/db_conv202018_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2018/GerarCONV.model.php");

/**
 * selecionar dados de Convenios Sicom Acompanhamento Mensal
 * @author Marcelo
 * @package Contabilidade
 */
class SicomArquivoConvenios extends SicomArquivoBase implements iPadArquivoBaseCSV
{
  
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
  public function __construct()
  {
    
  }
  
  /**
   * retornar o codigo do layout
   *
   * @return Integer
   */
  public function getCodigoLayout()
  {
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   * @return Array
   */
  public function getCampos()
  {
  }
  
  /**
   * selecionar os dados de Leis de Alteração
   *
   */
  public function gerarDados()
  {

    $clconv10 = new cl_conv102018();
    $clconv11 = new cl_conv112018();
    $clconv20 = new cl_conv202018();
    
    db_inicio_transacao();


    /*
   * excluir informacoes do mes selecionado registro 11
   */
    $result = $clconv11->sql_record($clconv11->sql_query(null, "*", null, "si93_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si93_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      
      $clconv11->excluir(null, "si93_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si93_instit = " . db_getsession("DB_instit"));
      if ($clconv11->erro_status == 0) {
        throw new Exception($clconv11->erro_msg);
      }
    }
    

    /*
     * excluir informacoes do mes selecionado registro 10
     */

    $result = $clconv10->sql_record($clconv10->sql_query(null, "*", null, "si92_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si92_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clconv10->excluir(null, "si92_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si92_instit = " . db_getsession("DB_instit"));
      if ($clconv10->erro_status == 0) {
        throw new Exception($clconv10->erro_msg);
      }
    }
    
    /*
     * excluir informacoes do mes selecionado registro 20
     */
    $result = $clconv20->sql_record($clconv20->sql_query(null, "*", null, "si94_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si94_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clconv20->excluir(null, "si94_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si93_instit = " . db_getsession("DB_instit"));
      if ($clconv20->erro_status == 0) {
        throw new Exception($clconv20->erro_msg);
      }
    }
    
    $sSql = "SELECT si09_codorgaotce AS codorgao
              FROM infocomplementaresinstit
              WHERE si09_instit = " . db_getsession("DB_instit");
    
    $rsResult = db_query($sSql);
    $sCodorgao = db_utils::fieldsMemory($rsResult, 0)->codorgao;

    /*
     * selecionar informacoes registro 10
     */
    $sSql = "select * from convconvenios where c206_dataassinatura >= '{$this->sDataInicial}' and c206_dataassinatura <= '{$this->sDataFinal}' and c206_instit = " . db_getsession("DB_instit");

    $rsResult10 = db_query($sSql);
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
      
      $clconv10 = new cl_conv102018();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
      
      $clconv10->si92_tiporegistro = 10;
      $clconv10->si92_codconvenio = $oDados10->c206_sequencial;
      $clconv10->si92_codorgao = $sCodorgao;
      $clconv10->si92_nroconvenio = $oDados10->c206_nroconvenio;
      $clconv10->si92_dataassinatura = $oDados10->c206_dataassinatura;
      $clconv10->si92_objetoconvenio = $oDados10->c206_objetoconvenio;
      $clconv10->si92_datainiciovigencia = $oDados10->c206_datainiciovigencia;
      $clconv10->si92_datafinalvigencia = $oDados10->c206_datafinalvigencia;
      $clconv10->si92_vlconvenio = $oDados10->c206_vlconvenio;
      $clconv10->si92_vlcontrapartida = $oDados10->c206_vlcontrapartida;
      $clconv10->si92_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clconv10->si92_instit = db_getsession("DB_instit");

      $clconv10->incluir(null);

      if ($clconv10->erro_status == 0) {
        throw new Exception($clconv10->erro_msg);
      }
      /*
       * selecionar informacoes registro 11
       */
      $sSql = "select * from convdetalhaconcedentes cd
               inner join convconvenios cc on cc.c206_sequencial = cd.c207_codconvenio
               where c206_dataassinatura >= '{$this->sDataInicial}' and c206_dataassinatura <= '{$this->sDataFinal}' 
               and c207_codconvenio = '{$oDados10->c206_sequencial}' 
               and c206_instit = " . db_getsession("DB_instit");
      
      $rsResult11 = db_query($sSql);
      
      for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {

        $clconv11 = new cl_conv112018();
        $oDados11 = db_utils::fieldsMemory($rsResult11, $iCont11);
        
        $clconv11->si93_tiporegistro = 11;
        $clconv11->si93_codconvenio = $oDados10->c206_sequencial;
        $clconv11->si93_tipodocumento = 2;
        $clconv11->si93_nrodocumento = $oDados11->c207_nrodocumento;
        $clconv11->si93_esferaconcedente = $oDados11->c207_esferaconcedente;
        $clconv11->si93_valorconcedido = $oDados11->c207_valorconcedido;
        $clconv11->si93_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $clconv11->si93_reg10 = $clconv10->si92_sequencial;
        $clconv11->si93_instit = db_getsession("DB_instit");

        $clconv11->incluir(null);

        if ($clconv11->erro_status == 0) {
          throw new Exception($clconv11->erro_msg);
        }
        
      }

      /*
     * selecionar informacoes registro 20
     */
      $sSql = "select * from convdetalhatermos cdt
               inner join convconvenios cc on cc.c206_sequencial = cdt.c208_codconvenio
               where c208_dataassinaturatermoaditivo >= '{$this->sDataInicial}' and c208_dataassinaturatermoaditivo <= '{$this->sDataFinal}'
               and c208_codconvenio = '{$oDados10->c206_sequencial}' 
               and c206_instit = " . db_getsession("DB_instit");

      $rsResult20 = db_query($sSql);

      for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {

        $clconv20 = new cl_conv202018();
        $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);

        $clconv20->si94_tiporegistro = 20;
        $clconv20->si94_codorgao = $sCodorgao;
        $clconv20->si94_nroconvenio = $oDados20->c208_codconvenio;
        $clconv20->si94_dtassinaturaconvoriginal = $oDados20->c206_dataassinatura;
        $clconv20->si94_nroseqtermoaditivo = $oDados20->c208_nroseqtermo;
        $clconv20->si94_dscalteracao = $oDados20->c208_dscalteracao;
        $clconv20->si94_dtassinaturatermoaditivo = $oDados20->c208_dataassinaturatermoaditivo;
        $clconv20->si94_datafinalvigencia = $oDados20->c208_datafinalvigencia;
        $clconv20->si94_valoratualizadoconvenio = $oDados20->c208_valoratualizadoconvenio;
        $clconv20->si94_valoratualizadocontrapartida = $oDados20->c208_valoratualizadocontrapartida;
        $clconv20->si94_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $clconv20->si94_instit = db_getsession("DB_instit");

        $clconv20->incluir(null);
        if ($clconv20->erro_status == 0) {
          throw new Exception($clconv20->erro_msg);
        }

      }
      
    }
    
    db_fim_transacao();
    
    $oGerarCONV = new GerarCONV();
    $oGerarCONV->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarCONV->gerarDados();
    
  }
  
}
