<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_respinf102014_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2014/GerarRESPINF.model.php");

 /**
  * Dados Complementares Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoRespinf extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
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
  protected $sNomeArquivo = 'RESPINF';
  
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
    
  	$clrespinf10 = new cl_respinf102014();

    db_inicio_transacao();

    /*
     * excluir informacoes do mes selecionado registro 10
     */
    $result = $clrespinf10->sql_record($clrespinf10->sql_query(NULL,"*",NULL,"si197_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']));
    if (pg_num_rows($result) > 0) {
      $clrespinf10->excluir(NULL,"si197_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']);
      if ($clrespinf10->erro_status == 0) {
        throw new Exception($clrespinf10->erro_msg);
      }
    }
    
    /*
     * selecionar informacoes registro 10
     */

        $sSql       = "select * from respinferacoes where si171_mesreferencia = '{$this->sDataFinal['6']}';";

        $rsResult10 = db_query($sSql);

        for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
          
          $clrespinf10 = new cl_respinf102014();
          $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

          $clrespinf10->si197_nomeresponsavel       = 10;
          $clrespinf10->si197_cartident             = $oDados10->si171_codarquivo;
          $clrespinf10->si197_orgemissorci          = $oDados10->si171_respinferacoes;
          $clrespinf10->si197_cpf                   = $oDados10->si171_respinferacoes;
          $clrespinf10->si197_dtinicio              = $oDados10->si171_respinferacoes;
          $clrespinf10->si197_dtfinal               = $oDados10->si171_respinferacoes;
          $clrespinf10->si197_mes                   = $this->sDataFinal['5'].$this->sDataFinal['6'];
          
          $clrespinf10->incluir(null);
          if ($clrespinf10->erro_status == 0) {
            throw new Exception($clrespinf10->erro_msg);
          }
          
        }

    db_fim_transacao();
    
    $oGerarRESPINF = new GerarRESPINF();
    $oGerarRESPINF->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarRESPINF->gerarDados();
    
  }

}
