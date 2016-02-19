<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_terem102015_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2015/flpg/GerarTEREM.model.php");

 /**
  * Dados Complementares Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoTerem extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
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
  protected $sNomeArquivo = 'TEREM';
  
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
    
  	$clterem10 = new cl_terem102015();

    db_inicio_transacao();

    /*
     * excluir informacoes do mes selecionado registro 10
     */
    $result = $clterem10->sql_record($clterem10->sql_query(NULL,"*",NULL,"si194_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']));
    if (pg_num_rows($result) > 0) {
      $clterem10->excluir(NULL,"si194_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']);
      if ($clterem10->erro_status == 0) {
        throw new Exception($clterem10->erro_msg);
      }
    }
    
    /*
     * selecionar informacoes registro 10
     */
        if ($this->sDataFinal['5'].$this->sDataFinal['6'] == 01) {
          $sSql = "select r07_valor as si194_vlrparateto , ' ' as si194_justalteracao  from pesdiver where r07_codigo = 'D060' ";
          $sSql .= " and r07_instit = " . db_getsession("DB_instit") . " limit 1 ";

          $si194_tipocadastro = 1;

        }else{
          $sSql = "select r07_valor as si194_vlrparateto , r07_descr as si194_justalteracao from pesdiver where r07_codigo = 'D060' ";
          $sSql .= " and r07_valor not in (select r07_valor from respinf102015 where si194_mes < ".($this->sDataFinal['5'].$this->sDataFinal['6']).")";
          $sSql .= " and r07_instit = " . db_getsession("DB_instit") . " limit 1 ";
          if(pg_num_rows(db_query($sSql)) > 0){
            $si194_tipocadastro = 2;
          }
        }
        $rsResult10 = db_query($sSql);
        //echo $sSql;exit;
        //db_criatabela($rsResult10);exit;

        for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
          
          $clterem10 = new cl_terem102015();
          $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

          $clterem10->si194_tiporegistro          = 10;
          $clterem10->si194_vlrparateto           = $oDados10->si194_vlrparateto;
          $clterem10->si194_tipocadastro          = $si194_tipocadastro;
          $clterem10->si194_justalteracao         = $oDados10->si194_justalteracao;
          $clterem10->si194_mes                   = $this->sDataFinal['5'].$this->sDataFinal['6'];
          $clterem10->si194_inst                  = db_getsession("DB_instit");

          $clterem10->incluir(null);
          if ($clterem10->erro_status == 0) {
            throw new Exception($clterem10->erro_msg);
          }
          
        }

    db_fim_transacao();
    
    $oGerarTEREM = new GerarTEREM();
    $oGerarTEREM->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarTEREM->gerarDados();
    
  }

}
