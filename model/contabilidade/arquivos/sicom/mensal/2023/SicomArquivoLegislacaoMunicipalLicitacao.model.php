<?php

require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_reglic102023_classe.php");
require_once("classes/db_reglic202023_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2023/GerarREGLIC.model.php");

/**
 * gerar arquivo de identificacao da Remessa Sicom Acompanhamento Mensal
 * @author johnatan
 * @package Contabilidade
 */
class SicomArquivoLegislacaoMunicipalLicitacao extends SicomArquivoBase implements iPadArquivoBaseCSV
{


  /**
   *
   * Codigo do layout. (db_layouttxt.db50_codigo)
   * @var Integer
   */
  protected $iCodigoLayout = 0;
  
  /**
   *
   * NOme do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'REGLIC';
  
  /**
   *
   * Contrutor da classe
   */
  public function __construct()
  {
    
  }
  
  /**
   * Retorna o codigo do layout
   *
   * @return Integer
   */
  public function getCodigoLayout()
  {
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   */
  public function getCampos()
  {

  }
  
  /**
   * selecionar os dados de indentificacao da remessa pra gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados()
  {

    /**
     * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
     */

    $clreglic10 = new cl_reglic102023();
    $clreglic20 = new cl_reglic202023();

    
    /**
     * excluir informacoes do mes selecioado
     */
    db_inicio_transacao();
    $result = db_query($clreglic10->sql_query(null, "*", null, "si44_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si44_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clreglic10->excluir(null, "si44_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si44_instit=" . db_getsession("DB_instit"));
      if ($clreglic10->erro_status == 0) {
        throw new Exception($clreglic10->erro_msg);
      }
    }
    
    $result = db_query($clreglic20->sql_query(null, "*", null, "si45_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si45_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clreglic20->excluir(null, "si45_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si45_instit=" . db_getsession("DB_instit"));
      if ($clreglic20->erro_status == 0) {
        throw new Exception($clreglic20->erro_msg);
      }
    }
    
    $sSql = "SELECT '10' AS tipoRegistro,
                    2 AS codOrgao,
                    decretopregao.l201_tipodecreto AS tipoDecreto,
                    decretopregao.l201_numdecreto AS nroDecretoMunicipal,
                    decretopregao.l201_datadecreto AS dataDecretoMunicipal,
                    decretopregao.l201_datapublicacao AS dataPublicacaoDecretoMunicipal
             FROM licitacao.decretopregao AS decretopregao
             WHERE decretopregao.l201_instit = " . db_getsession("DB_instit") . "
             AND decretopregao.l201_numdecreto NOT IN
                          (SELECT si44_nrodecretomunicipal
                            FROM reglic102023
                           UNION SELECT si44_nrodecretomunicipal
                            FROM reglic102022
                           UNION SELECT si44_nrodecretomunicipal
                            FROM reglic102021
                           UNION SELECT si44_nrodecretomunicipal
                            FROM reglic102020
                           UNION SELECT si44_nrodecretomunicipal
                            FROM reglic102019
                           UNION SELECT si44_nrodecretomunicipal
                            FROM reglic102018
                           UNION SELECT si44_nrodecretomunicipal
                            FROM reglic102023 WHERE si44_mes <= " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . ") 
    AND DATE_PART ( 'YEAR' , l201_datapublicacao ) = '2023'
    AND DATE_PART ( 'MONTH' , l201_datapublicacao ) = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
    ";
    
    
    $rsResult10 = db_query($sSql);
    
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
      
      $clreglic10 = new cl_reglic102023();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

      $clreglic10->si44_tiporegistro = 10;
      $clreglic10->si44_codorgao = $oDados10->codorgao;
      $clreglic10->si44_tipodecreto = $oDados10->tipodecreto;
      $clreglic10->si44_nrodecretomunicipal = $oDados10->nrodecretomunicipal;
      $clreglic10->si44_datadecretomunicipal = $oDados10->datadecretomunicipal;
      $clreglic10->si44_datapublicacaodecretomunicipal = $oDados10->datapublicacaodecretomunicipal;
      $clreglic10->si44_instit = db_getsession("DB_instit");
      $clreglic10->si44_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];


      $clreglic10->incluir(null);
      if ($clreglic10->erro_status == 0) {
        throw new Exception($clreglic10->erro_msg);
      }

    }
    /**
     * campos faltantes  na especificação de AGNALDO. VERIFICAR ###########  SQL  ############
     */

    db_fim_transacao();
    
    $oGerarREGLIC = new GerarREGLIC();
    $oGerarREGLIC->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarREGLIC->gerarDados();
    
  }
  
}
