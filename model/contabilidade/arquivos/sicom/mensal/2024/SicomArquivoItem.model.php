<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_item102023_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2023/GerarITEM.model.php");

/**
 * gerar arquivo de identificacao da Remessa Sicom Acompanhamento Mensal
 * @author robson
 * @package Contabilidade
 */
class SicomArquivoItem extends SicomArquivoBase implements iPadArquivoBaseCSV
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
  protected $sNomeArquivo = 'ITEM';

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
    $clitem10 = new cl_item102023();

    /**
     * excluir informacoes do mes selecioado
     */
    db_inicio_transacao();
    $result = db_query($clitem10->sql_query(null, "*", null, "si43_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si43_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clitem10->excluir(null, "si43_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si43_instit=" . db_getsession("DB_instit"));
      if ($clitem10->erro_status == 0) {
        throw new Exception($clitem10->erro_msg);
      }
    }
    $mes = intval($this->sDataFinal['5'] . $this->sDataFinal['6']);
    $sSql = "SELECT    db150_tiporegistro AS tipoRegistro,
                       db150_coditem AS coditem,
                       db150_dscitem AS dscItem,
                       db150_unidademedida AS unidadeMedida,
                       db150_tipocadastro AS tipoCadastro,
                       '' AS justificativaAlteracao
                FROM historicomaterial
                WHERE db150_instit = " . db_getsession("DB_instit") . "
                    AND db150_mes = $mes
                UNION
                SELECT db150_tiporegistro AS tipoRegistro,
                       db150_coditem AS coditem,
                       db150_dscitem AS dscItem,
                       db150_unidademedida AS unidadeMedida,
                       db150_tipocadastro AS tipoCadastro,
                       '' AS justificativaAlteracao
                FROM historicomaterial
                WHERE db150_instit = " . db_getsession("DB_instit") . "
                    AND db150_tipocadastro = 2
                    AND db150_mes = $mes";
    $rsResult10 = db_query($sSql);

    // matriz de entrada
    $what = array("°", chr(13), chr(10), 'ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'Ã', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º');

    // matriz de saída
    $by = array('', '', '', 'a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ');
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

      $clitem10 = new cl_item102023();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
      $sSqlitem = "select si43_coditem,si43_unidademedida from item102023  where si43_instit = " . db_getsession('DB_instit') . " and si43_coditem=" . $oDados10->coditem . " and si43_mes <= " . $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $sSqlitem .= " union
        select si43_coditem,si43_unidademedida from item102022 where si43_instit = " . db_getsession('DB_instit') . " and si43_coditem=" . $oDados10->coditem;
      $sSqlitem .= " union
        select si43_coditem,si43_unidademedida from item102021  where si43_instit = " . db_getsession('DB_instit') . " and si43_coditem=" . $oDados10->coditem;
      $sSqlitem .= " union
        select si43_coditem,si43_unidademedida from item102020  where si43_instit = " . db_getsession('DB_instit') . " and si43_coditem=" . $oDados10->coditem;
      $sSqlitem .= " union
        select si43_coditem,si43_unidademedida from item102019  where si43_instit = " . db_getsession('DB_instit') . " and si43_coditem=" . $oDados10->coditem;
      $sSqlitem .= " union
        select si43_coditem,si43_unidademedida from item102018  where si43_instit = " . db_getsession('DB_instit') . " and si43_coditem=" . $oDados10->coditem;
      $sSqlitem .= " union
        select si43_coditem,si43_unidademedida from item102017  where si43_instit = " . db_getsession('DB_instit') . " and si43_coditem=" . $oDados10->coditem;
      $sSqlitem .= " union
    	select si43_coditem,si43_unidademedida from item102016  where si43_instit = " . db_getsession('DB_instit') . " and si43_coditem=" . $oDados10->coditem;
      $sSqlitem .= " union
    	select si43_coditem,si43_unidademedida from item102015  where si43_instit = " . db_getsession('DB_instit') . " and si43_coditem=" . $oDados10->coditem;
      $sSqlitem .= " union
    	select si43_coditem,si43_unidademedida from item102014  where si43_instit = " . db_getsession('DB_instit') . " and si43_coditem=" . $oDados10->coditem;
      $rsResultitem = db_query($sSqlitem);

      /**
       * verifica se já nao existe o registro  na base de dados do sicom
       */
      if (pg_num_rows($rsResultitem) == 0) {


        $clitem10->si43_tiporegistro = 10;
        $clitem10->si43_coditem = $oDados10->coditem;
        $clitem10->si43_dscItem = trim(preg_replace("/[^a-zA-Z0-9 ]/", "", str_replace($what, $by, $oDados10->dscitem))) . " $oDados10->coditem";
        $clitem10->si43_unidademedida = trim(preg_replace("/[^a-zA-Z0-9 ]/", "", str_replace($what, $by, $oDados10->unidademedida)));
        $clitem10->si43_tipocadastro = $oDados10->tipocadastro;
        $clitem10->si43_justificativaalteracao = $oDados10->justificativaalteracao;
        $clitem10->si43_instit = db_getsession("DB_instit");
        $clitem10->si43_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        // echo pg_last_error();
        $clitem10->incluir(null);
        if ($clitem10->erro_status == 0) {
          throw new Exception($clitem10->erro_msg);
        }
      }
    }

    db_fim_transacao();

    $oGerarItem = new GerarITEM();
    $oGerarItem->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarItem->gerarDados();
  }
}
