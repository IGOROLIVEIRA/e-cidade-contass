<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_pessoa102015_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2015/flpg/GerarPESSOA.model.php");

 /**
  * Dados Complementares Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoPessoa extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'PESSOA';
  
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
    
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV 
   */
  public function getCampos(){
    
  }
  
  /**
   * selecionar os dados de Dados Complementares à LRF do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
    
  	$clpessoa10 = new cl_pessoa102015();

    db_inicio_transacao();

    /*
     * excluir informacoes do mes selecionado registro 10
     */
    $result = $clpessoa10->sql_record($clpessoa10->sql_query(NULL,"*",NULL,"si193_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']));
    if (pg_num_rows($result) > 0) {
      $clpessoa10->excluir(NULL,"si193_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']);
      if ($clpessoa10->erro_status == 0) {
        throw new Exception($clpessoa10->erro_msg);
      }
    }
    
    /*
     * selecionar informacoes registro 10
     */

        $sSql       = "select * from pessoaeracoes where si171_mesreferencia = '{$this->sDataFinal['6']}';";

        $rsResult10 = db_query($sSql);

        for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
          
          $clpessoa10 = new cl_pessoa102015();
          $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

          $clpessoa10->si193_tiporegistro          = 10;
          $clpessoa10->si193_tipodocumento         = $oDados10->si171_codarquivo;
          $clpessoa10->si193_nrodocumento          = $oDados10->si171_pessoaeracoes;
          $clpessoa10->si193_nome                  = $oDados10->si171_pessoaeracoes;
          $clpessoa10->si193_indsexo               = $oDados10->si171_pessoaeracoes;
          $clpessoa10->si193_datanascimento        = $oDados10->si171_pessoaeracoes;
          $clpessoa10->si193_tipocadastro          = $oDados10->si171_pessoaeracoes;
          $clpessoa10->si193_justalteracao         = $oDados10->si171_pessoaeracoes;
          $clpessoa10->si193_mes                   = $this->sDataFinal['5'].$this->sDataFinal['6'];
          
          $clpessoa10->incluir(null);
          if ($clpessoa10->erro_status == 0) {
            throw new Exception($clpessoa10->erro_msg);
          }
          
        }

    db_fim_transacao();
    
    $oGerarPESSOA = new GerarPESSOA();
    $oGerarPESSOA->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarPESSOA->gerarDados();
    
  }

}
