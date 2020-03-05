<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_ideedital2020_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2020/GerarIDEEDITAL.model.php");

/**
 * gerar arquivo de identificacao da Remessa Sicom Acompanhamento Mensal
 * @author Victor Felipe
 * @package Contabilidade
 */
class SicomArquivoIdentificacaoRemessa extends SicomArquivoBase implements iPadArquivoBaseCSV {

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
    protected $sNomeArquivo = 'IDE';

    /**
    *
    * Contrutor da classe
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
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   */
    public function getCampos(){

        $aElementos  = array(
            "codIdentificador",
            "cnpj",
            "codOrgao",
            "tipoOrgao",
            "exercicioReferencia",
            "mesReferencia",
            "dataGeracao",
            "codControleRemessa",
            "codSeqRemessaMes"
        );
        return $aElementos;
    }

    /**
     * selecionar os dados de indentificacao da remessa pra gerar o arquivo
     * @see iPadArquivoBase::gerarDados()
     */
    public function gerarDados(){

      /**
       * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
       */
        $clideedital = new cl_ideedital2020();

        $sSql  = "SELECT db21_codigomunicipoestado AS codIdentificador,
                  cgc::varchar cnpj,
                  si09_codorgaotce AS codorgao,
                  si09_tipoinstit AS tipoorgao,
                  prefeitura
                FROM db_config
                LEFT JOIN infocomplementaresinstit ON si09_instit = ".db_getsession("DB_instit")."
                WHERE codigo = ".db_getsession("DB_instit");

        $rsResult  = db_query($sSql);

        /**
         * inserir informacoes no banco de dados
         */
        db_inicio_transacao();
        $result = $clideedital->sql_record($clideedital->sql_query(NULL,"*",NULL,"si186_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si186_instit = ".db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $clideedital->excluir(NULL,"si186_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si186_instit = ".db_getsession("DB_instit"));
            if ($clideedital->erro_status == 0) {
                throw new Exception($clideedital->erro_msg);
            }
        }

        for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

            $clideedital = new cl_ideedital2020();
            $oDadosIde = db_utils::fieldsMemory($rsResult, $iCont);

            $clideedital->si186_codidentificador     = $oDadosIde->codidentificador;
            $clideedital->si186_cnpj                 = $oDadosIde->cnpj;
            $clideedital->si186_codorgao						 = $oDadosIde->codorgao;
            $clideedital->si186_tipoorgao            = $oDadosIde->tipoorgao;
            $clideedital->si186_exercicioreferencia  = db_getsession("DB_anousu");
            $clideedital->si186_mesreferencia        = $this->sDataFinal['5'].$this->sDataFinal['6'];
            $clideedital->si186_datageracao          = date("d-m-Y");
            $clideedital->si186_codcontroleremessa   = " ";
            $clideedital->si186_codseqremessames     = $iCont+1;
            $clideedital->si186_mes                  = $this->sDataFinal['5'].$this->sDataFinal['6'];
            $clideedital->si186_instit               = db_getsession("DB_instit");

            $clideedital->incluir(null);

            if ($clideedital->erro_status == 0) {
                throw new Exception($clideedital->erro_msg);
            }

        }

        db_fim_transacao();

        $oGerarIdeEdital = new GerarIDEEDITAL();
        $oGerarIdeEdital->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $oGerarIdeEdital->gerarDados();

    }

}
