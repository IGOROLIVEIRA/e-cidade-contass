<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_item102024_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2024/GerarITEM.model.php");

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
  function StringReplaceSicom($string){
    $string = preg_replace(array("/(á|à|ã|â|ä|å|æ)/","/(Á|À|Ã|Â|Ä|Å|Æ)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö|Ø)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç)/","/(Ç)/","/(ý|ÿ)/","/(Ý)/"),explode(" ","a A e E i I o O u U n N c C y Y"),$string);
    $string = preg_replace('/[^A-Za-z0-9 ?|_;{}\[\]]/', '', $string);
    $string = preg_replace("/[?|?_??]/u", "-", $string);
    $string = preg_replace("/[;]/u", ".", $string);
    $string = preg_replace("/[\[<{|]/u", "(", $string);
    $string = preg_replace("/[\]>}]/u", ")", $string);
    $string = preg_replace("/[+$&]/u", "", $string);
    return $string = preg_replace('/\s{2,}/', ' ', $string);
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
        $clitem10 = new cl_item102024();

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
        $instit = db_getsession("DB_instit");

        $sSql = "SELECT db150_tiporegistro AS tipoRegistro,
                           db150_coditem AS coditem,
                           CASE
                               WHEN pc01_complmater IS NOT NULL THEN regexp_replace(pcmater.pc01_descrmater || ' ' || substring(pc01_complmater,1,900), ' +', ' ', 'g')
                               ELSE regexp_replace(pcmater.pc01_descrmater, ' +', ' ', 'g')
                           END AS dscItem,
                           db150_unidademedida AS unidadeMedida,
                           db150_tipocadastro AS tipoCadastro,
                           pc01_justificativa AS justificativaAlteracao
                    FROM historicomaterial
                    INNER JOIN pcmater ON pc01_codmater = db150_pcmater
                    WHERE db150_instit IN ($instit, 0)
                        AND DATE_PART('YEAR', db150_data) = " . db_getsession("DB_anousu") . "
                        AND db150_mes = $mes
                        AND (
                            db150_tipocadastro = 1
                            OR (
                                db150_tipocadastro = 2
                                AND NOT EXISTS (
                            SELECT 1
                                    FROM historicomaterial h2
                                    WHERE h2.db150_coditem = historicomaterial.db150_coditem
                        AND h2.db150_mes = historicomaterial.db150_mes
                        AND h2.db150_tipocadastro = 1
                                )
                            )
                        )";
        $rsResult10 = db_query($sSql);//echo $sSql;db_criatabela($rsResult10);exit;

        for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

            $clitem10 = new cl_item102024();
            $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
            $sSqlitem = "select si43_coditem,si43_unidademedida from item102024  where si43_instit = " . db_getsession('DB_instit') . " and si43_coditem=" . $oDados10->coditem . " and si43_mes <= " . $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $sSqlitem .= " union
        select si43_coditem,si43_unidademedida from item102023 where si43_instit = " . db_getsession('DB_instit') . " and si43_coditem=" . $oDados10->coditem;
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
             * verifica se j? nao existe o registro  na base de dados do sicom
             */
            if (pg_num_rows($rsResultitem) == 0) {

                $clitem10->si43_tiporegistro = 10;
                $clitem10->si43_coditem = $oDados10->coditem;
                $clitem10->si43_dscItem = strtoupper($this->StringReplaceSicom($oDados10->dscitem)." ".$oDados10->coditem);
                $clitem10->si43_unidademedida = $this->StringReplaceSicom($oDados10->unidademedida);
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
