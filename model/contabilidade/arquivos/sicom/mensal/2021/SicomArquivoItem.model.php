<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_item102021_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2021/GerarITEM.model.php");

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
    $clitem10 = new cl_item102021();

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


    $sSql = "
   
              SELECT DISTINCT '10' AS tipoRegistro,
                          pc11_codigo||''||m61_codmatunid AS coditem,
                          (CASE WHEN m61_abrev IS NULL THEN 'UNIDAD' ELSE m61_abrev END) AS unidadeMedida,
                          (pcmater.pc01_descrmater||substring(pc01_complmater,1,900)) AS dscItem,
                          CASE 
                            WHEN pc01_dataalteracao IS NULL OR 
                              (extract(month from pc01_data) = extract(month from pc01_dataalteracao) 
                                AND (extract(year from pc01_data) = extract(year from pc01_dataalteracao))) THEN '1' 
                              WHEN pc01_dataalteracao > pc01_data THEN '2'
                          END as tipoCadastro,
                          pc01_justificativa as justificativaalteracao
                FROM pcmater
                INNER JOIN solicitempcmater ON pc16_codmater=pc01_codmater
                INNER JOIN solicitem ON pc11_codigo=pc16_solicitem
                INNER JOIN solicitemunid ON pc17_codigo=pc11_codigo
                INNER JOIN matunid ON m61_codmatunid=pc17_unid
                WHERE extract(month from pc01_data) = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " 
                  AND extract(year from pc01_data) = ".db_getsession("DB_anousu")."
                  AND (
                        (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) NOT IN
                        (SELECT si43_coditem::varchar
                            FROM item102020
                            WHERE si43_instit = " . db_getsession('DB_instit') . ")
                    AND (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) NOT IN
                        (SELECT si43_coditem::varchar
                            FROM item102019
                            WHERE si43_instit = " . db_getsession('DB_instit') . ")
                    AND (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) NOT IN
                        (SELECT si43_coditem::varchar
                            FROM item102018
                            WHERE si43_instit = " . db_getsession('DB_instit') . ")
                    AND (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) NOT IN
                        (SELECT si43_coditem::varchar
                            FROM item102017
                            WHERE si43_instit = " . db_getsession('DB_instit') . ")
                    AND (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) NOT IN
                        (SELECT si43_coditem::varchar
                            FROM item102016
                            WHERE si43_instit = " . db_getsession('DB_instit') . ")
                    AND (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) NOT IN
                        (SELECT si43_coditem::varchar
                            FROM item102015
                            WHERE si43_instit = " . db_getsession('DB_instit') . ")
                    AND (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) NOT IN
                        (SELECT si43_coditem::varchar
                            FROM item102014
                            WHERE si43_instit = " . db_getsession('DB_instit') . ")
                  )
            
              UNION
            
              SELECT DISTINCT '10' AS tipoRegistro,
                          pc01_codmater||''||m61_codmatunid AS coditem,
                          (CASE WHEN m61_abrev IS NULL THEN 'UNIDAD' ELSE m61_abrev END) AS unidadeMedida,
                          (pcmater.pc01_descrmater||substring(pc01_complmater,1,900)) AS dscItem,
                          CASE 
                            WHEN pc01_dataalteracao IS NULL OR 
                              (extract(month from pc01_data) = extract(month from pc01_dataalteracao) 
                                AND (extract(year from pc01_data) = extract(year from pc01_dataalteracao))) THEN '1' 
                              WHEN pc01_dataalteracao > pc01_data THEN '2'
                          END as tipoCadastro,
                          pc01_justificativa as justificativaalteracao
                FROM empautoriza
                INNER JOIN empautitem ON e55_autori=e54_autori
                INNER JOIN pcmater ON pc01_codmater=e55_item
                INNER JOIN matunid ON m61_codmatunid=e55_unid
                WHERE extract(month from e54_emiss) = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
                  AND extract(month from e54_emiss) = " . db_getsession('DB_anousu')."
                  AND (
                        (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) NOT IN
                        (SELECT si43_coditem::varchar
                            FROM item102020
                            WHERE si43_instit = " . db_getsession('DB_instit') . ")
                    AND (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) NOT IN
                        (SELECT si43_coditem::varchar
                            FROM item102019
                            WHERE si43_instit = " . db_getsession('DB_instit') . ")
                    AND (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) NOT IN
                        (SELECT si43_coditem::varchar
                            FROM item102018
                            WHERE si43_instit = " . db_getsession('DB_instit') . ")
                    AND (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) NOT IN
                        (SELECT si43_coditem::varchar
                            FROM item102017
                            WHERE si43_instit = " . db_getsession('DB_instit') .")
                    AND (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) NOT IN
                        (SELECT si43_coditem::varchar
                            FROM item102016
                            WHERE si43_instit = " . db_getsession('DB_instit') . ")
                    AND (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) NOT IN
                        (SELECT si43_coditem::varchar
                            FROM item102015
                            WHERE si43_instit = " . db_getsession('DB_instit') . ")
                    AND (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) NOT IN
                        (SELECT si43_coditem::varchar
                            FROM item102014
                            WHERE si43_instit = " . db_getsession('DB_instit') . ")
                  )
            
              UNION
            
              SELECT DISTINCT '10' AS tipoRegistro,
                          pc01_codmater||''||m61_codmatunid AS coditem,
                          (CASE WHEN m61_abrev IS NULL THEN 'UNIDAD' ELSE m61_abrev END) AS unidadeMedida,
                          (pcmater.pc01_descrmater||substring(pc01_complmater,1,900)) AS dscItem,
                          CASE 
                            WHEN pc01_dataalteracao IS NULL OR 
                              (extract(month from pc01_data) = extract(month from pc01_dataalteracao) 
                                AND (extract(year from pc01_data) = extract(year from pc01_dataalteracao))) THEN '1' 
                              WHEN pc01_dataalteracao > pc01_data THEN '2'
                          END as tipoCadastro,
                          pc01_justificativa as justificativaalteracao
                FROM acordoitem
                INNER JOIN pcmater ON pc01_codmater = ac20_pcmater
                INNER JOIN matunid ON m61_codmatunid=ac20_matunid
                WHERE extract(month from pc01_data) = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
                  AND extract(year from pc01_data) = " . db_getsession('DB_anousu') . "
                  AND (
                        (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) NOT IN
                        (SELECT si43_coditem::varchar
                            FROM item102020
                            WHERE si43_instit = " . db_getsession('DB_instit') . ")
                    AND (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) NOT IN
                        (SELECT si43_coditem::varchar
                            FROM item102019
                            WHERE si43_instit = " . db_getsession('DB_instit') . ")
                    AND (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) NOT IN
                        (SELECT si43_coditem::varchar
                            FROM item102018
                            WHERE si43_instit = " . db_getsession('DB_instit') . ")
                    AND (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) NOT IN
                        (SELECT si43_coditem::varchar
                            FROM item102017
                            WHERE si43_instit = " . db_getsession('DB_instit') .")
                    AND (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) NOT IN
                        (SELECT si43_coditem::varchar
                            FROM item102016
                            WHERE si43_instit = ". db_getsession('DB_instit') . ")
                    AND (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) NOT IN
                        (SELECT si43_coditem::varchar
                            FROM item102015
                            WHERE si43_instit = " . db_getsession('DB_instit') .")
                    AND (pcmater.pc01_codmater::varchar || (CASE WHEN m61_codmatunid IS NULL THEN 1 ELSE m61_codmatunid END)::varchar) NOT IN
                        (SELECT si43_coditem::varchar
                            FROM item102014
                            WHERE si43_instit = ". db_getsession('DB_instit') . ")
                  )
                ";

    // echo $sSql;
    $rsResult10 = db_query($sSql);//echo $sSql;
    // db_criatabela($rsResult10);//die($sSql);
    //$aCaracteres = array("/","\","'","\"","°","ª","º","§");
    // matriz de entrada
    $what = array("°", chr(13), chr(10), 'ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'Ã', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º');

    // matriz de saída
    $by = array('', '', '', 'a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ');
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

      $clitem10 = new cl_item102021();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

      $sSqlitem = "select si43_coditem,si43_unidademedida from item102020  where si43_instit = ".db_getsession('DB_instit')." and si43_coditem=" . $oDados10->coditem . " and si43_mes <= " . $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $sSqlitem .= " union
        select si43_coditem,si43_unidademedida from item102019  where si43_instit = ".db_getsession('DB_instit')." and si43_coditem=" . $oDados10->coditem;
      $sSqlitem .= " union
        select si43_coditem,si43_unidademedida from item102018  where si43_instit = ".db_getsession('DB_instit')." and si43_coditem=" . $oDados10->coditem;
      $sSqlitem .= " union
        select si43_coditem,si43_unidademedida from item102017  where si43_instit = ".db_getsession('DB_instit')." and si43_coditem=" . $oDados10->coditem;
      $sSqlitem .= " union
    	select si43_coditem,si43_unidademedida from item102016  where si43_instit = ".db_getsession('DB_instit')." and si43_coditem=" . $oDados10->coditem;
      $sSqlitem .= " union
    	select si43_coditem,si43_unidademedida from item102015  where si43_instit = ".db_getsession('DB_instit')." and si43_coditem=" . $oDados10->coditem;
      $sSqlitem .= " union
    	select si43_coditem,si43_unidademedida from item102014  where si43_instit = ".db_getsession('DB_instit')." and si43_coditem=" . $oDados10->coditem;
      $rsResultitem = db_query($sSqlitem);//    db_criatabela($rsResultitem);echo $sSqlitem;exit;
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
