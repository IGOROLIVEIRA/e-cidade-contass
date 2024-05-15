<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_pessoasobra102021_classe.php");
require_once("model/contabilidade/arquivos/sicom/2021/obra/geradores/gerarPESSOAOBRA.php");

/**
 * Dados Cadastro de Reponsaveis Sicom Obras
 * @author Mario Junior
 * @package Obras
 */

class SicomArquivoPessoaObras extends SicomArquivoBase implements iPadArquivoBaseCSV
{

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
  public function __construct()
  {

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
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   */
  public function getCampos()
  {

    $aElementos[10] = array(
      "tipoRegistro",
      "nroDocumento",
      "nomePessoaFisica",
      "tipoCadastro",
      "justificativaAlteracao"
    );

    return $aElementos;
  }

  public function gerarDados()
  {
        /**
     * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
     */
    $clpessoasobra102021 = new cl_pessoasobra102021();


    /**
     * excluir informacoes do mes selecioado para evitar duplicacao de registros
     */

    /**
     * registro 10 exclusão
     */
    $result = db_query($clpessoasobra102021->sql_query(null, "*", null, "si194_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si194_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clpessoasobra102021->excluir(null, "si194_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si194_instit=" . db_getsession("DB_instit"));
      if ($clpessoasobra102021->erro_status == 0) {
        throw new Exception($clpessoasobra102021->erro_msg);
      }
    }

    /**
     * registro 10
     */

    $sql = "SELECT DISTINCT 10 AS si194_tiporegistro,
             cgm.z01_cgccpf AS si194_nrodocumento,
             cgm.z01_nome AS si194_nome,
             1 AS si194_tipocadastro,
             '' AS si194_justificativaalteracao
            FROM licobrasresponsaveis
            INNER JOIN cgm ON z01_numcgm = obr05_responsavel
            INNER JOIN licobras ON obr05_seqobra = obr01_sequencial
            WHERE DATE_PART('YEAR',licobrasresponsaveis.obr05_dtcadastrores)= " . db_getsession("DB_anousu") . "
            AND DATE_PART('MONTH',licobrasresponsaveis.obr05_dtcadastrores)=" . $this->sDataFinal['5'] . $this->sDataFinal['6']."
            AND z01_cgccpf NOT IN
            (SELECT si194_nrodocumento
                 FROM pessoasobra102021
            INNER JOIN cgm ON si194_nrodocumento = z01_cgccpf)
    ";
    $rsResult10 = db_query($sql);//db_criatabela($rsResult10);die($sql);

    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
      $clpessoasobra102021 = new cl_pessoasobra102021();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

      $clpessoasobra102021->si194_tiporegistro           = 10;
      $clpessoasobra102021->si194_nrodocumento           = $oDados10->si194_nrodocumento;
      $clpessoasobra102021->si194_nome                   = $this->removeCaracteres($oDados10->si194_nome);
      $clpessoasobra102021->si194_tipocadastro           = $oDados10->si194_tipocadastro;
      $clpessoasobra102021->si194_justificativaalteracao = $oDados10->si194_justificativaalteracao;
      $clpessoasobra102021->si194_mes                    = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clpessoasobra102021->si194_instit                 = db_getsession("DB_instit");

      $clpessoasobra102021->incluir(null);
      if ($clpessoasobra102021->erro_status == 0) {
        throw new Exception($clpessoasobra102021->erro_msg);
      }
    }

    $oGerarPESSOAOBRA = new gerarPESSOAOBRA();
    $oGerarPESSOAOBRA->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarPESSOAOBRA->gerarDados();

  }
}
