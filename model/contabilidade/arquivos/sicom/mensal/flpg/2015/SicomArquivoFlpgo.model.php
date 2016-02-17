<?php

require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_flpgo102015_classe.php");
require_once ("classes/db_flpgo112015_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2015/GerarFLPGO.model.php");

/**
 * selecionar dados de Notas Fiscais Sicom Acompanhamento Mensal
 * @author robson
 * @package Contabilidade
 */
class SicomArquivoFlpgo extends SicomArquivoBase implements iPadArquivoBaseCSV {

    /**
     *
     * Codigo do layout
     * @var Integer
     */
    protected $iCodigoLayout = 174;

    /**
     *
     * Nome do arquivo a ser criado
     * @var String
     */
    protected $sNomeArquivo = 'FLPGO';

    /**
     *
     * Contrutor da classe
     */
    public function __construct() {

    }

    /**
     * retornar o codio do layout
     *
     *@return Integer
     */
    public function getCodigoLayout(){
        return $this->iCodigoLayout;
    }

    /**
     *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
     *@return Array
     */
    public function getCampos() {

    }

    /**
     * selecionar os dados de Notas Fiscais referentes a instituicao logada
     *
     */
    public function gerarDados() {

        $clflpgo10 = new cl_flpgo102015();
        $clflpgo11 = new cl_flpgo112015();

        db_inicio_transacao();

        /*
        * excluir informacoes do mes selecionado registro 11
        */
        $result = $clflpgo11->sql_record($clflpgo11->sql_query(NULL,"*",NULL,"si196_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si196_instit = ".db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {

            $clflpgo11->excluir(NULL,"si196_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si196_instit = ".db_getsession("DB_instit"));
            if ($clflpgo11->erro_status == 0) {
                throw new Exception($clflpgo11->erro_msg);
            }
        }

        /*
         * excluir informacoes do mes selecionado registro 10
         */
        $result = $clflpgo10->sql_record($clflpgo10->sql_query(NULL,"*",NULL,"si195_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si195_instit = ".db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $clflpgo10->excluir(NULL,"si195_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si195_instit = ".db_getsession("DB_instit"));
            if ($clflpgo10->erro_status == 0) {
                throw new Exception($clflpgo10->erro_msg);
            }
        }

        db_fim_transacao();

        echo
        /*
         * selecionar informacoes registro 10
         */
        db_inicio_transacao();

        $sSql = "SELECT DISTINCT
        '10' as tiporegistro,
        z01_cgccpf as si195_numcpf,
        'C' as si195_regime,
        case
            when r70_ativo = 't' then 'A'
            when r70_ativo = 'f' then 'I'
        end as si195_indsituacaoservidorpensionista,
        rh01_admiss as si195_datconcessaoaposentadoriapensao,

        case
            when rh02_vincrais = 30 then 'CEF'
        end as sglCargo
	FROM cgm
        INNER JOIN rhpessoal ON rh01_numcgm = z01_numcgm
        INNER JOIN rhpessoalmov ON rh01_regist = rh02_regist
        INNER JOIN rhlota ON rhlota.r70_codigo = rhpessoalmov.rh02_lota
        LEFT JOIN rhpescargo ON rhpescargo.rh20_seqpes = rhpessoalmov.rh02_seqpes
        AND rhlota.r70_instit = rhpessoalmov.rh02_instit
        WHERE rh02_anousu = ".db_getsession('DB_anousu')."
        AND rh02_mesusu = ". $this->sDataFinal['5'].$this->sDataFinal['6'] ."
        AND rhlota.r70_instit = ". db_getsession('DB_instit');

        $rsResult10 = db_query($sSql);

        for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

            $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

            $clflpgo10 = new cl_flpgo102015();
            $clflpgo10->si195_tiporegistro                      = $oDados10->si195_tiporegistro;
            $clflpgo10->si195_numcpf                            = $oDados10->si195_numcpf;
            $clflpgo10->si195_regime                            = $oDados10->si195_regime;
            $clflpgo10->si195_indtipopagamento                  = $oDados10->si195_indtipopagamento;
            $clflpgo10->si195_indsituacaoservidorpensionista    = $oDados10->si195_indsituacaoservidorpensionista;
            $clflpgo10->si195_datconcessaoaposentadoriapensao   = $oDados10->si195_datconcessaoaposentadoriapensao;
            $clflpgo10->si195_dsccargo                          = $oDados10->si195_dsccargo;
            $clflpgo10->si195_sglcargo                          = $oDados10->si195_sglcargo;
            $clflpgo10->si195_reqcargo                          = $oDados10->si195_reqcargo;
            $clflpgo10->si195_indcessao                         = $oDados10->si195_indcessao;
            $clflpgo10->si195_dsclotacao                        = $oDados10->si195_dsclotacao;
            $clflpgo10->si195_vlrcargahorariasemanal            = $oDados10->si195_vlrcargahorariasemanal;
            $clflpgo10->si195_datefetexercicio                  = $oDados10->si195_datefetexercicio;
            $clflpgo10->si195_datexclusao                       = $oDados10->si195_datexclusao;
            $clflpgo10->si195_natsaldobruto                     = $oDados10->si195_natsaldobruto;
            $clflpgo10->si195_vlrremuneracaobruta               = $oDados10->si195_vlrremuneracaobruta;
            $clflpgo10->si195_natsaldoliquido                   = $oDados10->si195_natsaldoliquido;
            $clflpgo10->si195_vlrremuneracaoliquida             = $oDados10->si195_vlrremuneracaoliquida;
            $clflpgo10->si195_vlrdeducoesobrigatorias           = $oDados10->si195_vlrdeducoesobrigatorias;
            $clflpgo10->si195_vlrabateteto                      = $oDados10->si195_vlrabateteto;
            $clflpgo10->si195_mes                               = $oDados10->si195_mes;
            $clflpgo10->si195_instit                            = $oDados10->si195_instit;

            $clflpgo10->incluir(null);
            if ($clflpgo10->erro_status == 0) {
                throw new Exception($clflpgo10->erro_msg);
            }


            $sSql2 = "select distinct  '10' as tiporegistro
            from empenho.empnota as empnota ";

            $rsResult11 = db_query($sSql2);

              for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {

                $oDados11 = db_utils::fieldsMemory($rsResult11, $iCont11);


                $clflpgo11 = new cl_flpgo202015();
                $clflpgo11->si196_tiporegistro            = $oDados11->si196_tiporegistro;
                $clflpgo11->si196_reg10                   = $clflpgo10->si195_sequencial;
                $clflpgo11->si196_numcpf                  = $clflpgo10->si195_numcpf;
                $clflpgo11->si196_tiporemuneracao         = $oDados11->si196_tiporemuneracao;
                $clflpgo11->si196_descoutros              = $oDados11->si196_descoutros;
                $clflpgo11->si196_natsaldodetalhe         = $oDados11->si196_natsaldodetalhe;
                $clflpgo11->si196_vlrremuneracaodetalhada = $oDados11->si196_vlrremuneracaodetalhada;
                $clflpgo11->si196_mes                     = $oDados11->si196_mes;
                $clflpgo11->si196_instit                  = $oDados11->si196_instit;
                $clflpgo11->incluir(null);

                if ($clflpgo11->erro_status == 0) {
                    throw new Exception($clflpgo11->erro_msg);
                }

            }

        }

        db_fim_transacao();

        $oGerarFLPGO = new GerarFLPGO();
        $oGerarFLPGO->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $oGerarFLPGO->gerarDados();

    }

}
