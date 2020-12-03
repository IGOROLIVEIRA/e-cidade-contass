<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_dclrf102021_classe.php");
require_once ("classes/db_dclrf112021_classe.php");
require_once ("classes/db_dclrf202021_classe.php");
require_once ("classes/db_dclrf302021_classe.php");
require_once ("classes/db_dclrf402021_classe.php");
require_once ("classes/db_infocomplementaresinstit_classe.php");
require_once ("classes/db_dadoscomplementareslrf_classe.php");
require_once ("classes/db_medidasadotadaslrf_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2021/GerarDCLRF.model.php");


/**
 * Dados Complementares Sicom Acompanhamento Mensal
 * @author marcony
 * @package Contabilidade
 */
class SicomArquivoDadosComplementares extends SicomArquivoBase implements iPadArquivoBaseCSV {

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
    protected $sNomeArquivo = 'DCLRF';

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
        return $this->iCodigoLayout;
    }

    /**
     *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
     */
    public function getCampos(){

    }

    public function getTipoinstit($CodInstit){
        $sSqltipoistint = "select si09_tipoinstit from infocomplementaresinstit inner join db_config on codigo = si09_instit where codigo = {$CodInstit}";
        $iTipoInstit = db_utils::fieldsMemory(db_query($sSqltipoistint), 0)->si09_tipoinstit;
        if ($iTipoInstit == "") {
            throw new Exception("Não foi possível encontrar o código do TCE do instituição {$CodInstit} em " . db_getsession('DB_anousu') . " Verifique o cadastro da instituição no módulo Configurações, menu Cadastros->Instiuições.");
        }
        return $iTipoInstit;
    }

    /**
     * selecionar os dados de Dados Complementares à LRF do mes para gerar o arquivo
     * @see iPadArquivoBase::gerarDados()
     */
    public function gerarDados() {

        $cldclrf10                  = new cl_dclrf102021();
        $cldclrf11                  = new cl_dclrf112021();
        $cldclrf20                  = new cl_dclrf202021();
        $cldclrf30                  = new cl_dclrf302021();
        $cldclrf40                  = new cl_dclrf402021();
        $cldadoscomplementareslrf   = new cl_dadoscomplementareslrf();
        $clmedidasadotadaslrf       = new cl_medidasadotadaslrf();
        $clinfocomplementaresinstit = new cl_infocomplementaresinstit();

        //PEGA O CÓDIGO DO ÓRGAO
        $oInstituicao = $clinfocomplementaresinstit->sql_query_file(null,"*",null,"si09_instit = ".db_getsession('DB_instit'));
        $oInstituicao = $clinfocomplementaresinstit->sql_record($oInstituicao);
        $oInstituicao = db_utils::fieldsMemory($oInstituicao);
        $iCodOrgao = $oInstituicao->si09_codorgaotce;
        $iCodInstit = db_getsession("DB_instit");
        $iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];


        // $this->sDataFinal['5'].$this->sDataFinal['6']

        //LIMPA AS TABELAS
        $cldclrf40->excluir(null,"si193_mes = {$iMes} and si193_instit = {$iCodInstit}");

        if($cldclrf40->erro_status == 0){
            throw new Exception($cldclrf40->erro_msg);
        }
        $cldclrf30->excluir($iMes, $iCodInstit);
        if($cldclrf30->erro_status == 0){
            throw new Exception($cldclrf30->erro_msg);
        }
        $cldclrf20->excluir(null,"si191_mes = {$iMes} and si191_instit = {$iCodInstit}");
        if($cldclrf20->erro_status == 0){
            throw new Exception($cldclrf20->erro_msg);
        }
        $cldclrf11->excluir($iMes,$iCodInstit);
        if($cldclrf11->erro_status == 0){
            throw new Exception($cldclrf11->erro_msg);
        }
        $cldclrf10->excluir($iMes, $iCodInstit);
        if($cldclrf10->erro_status == 0){
            throw new Exception($cldclrf10->erro_msg);
        }

        db_inicio_transacao();

        /*
         * selecionar informacoes registro 10
         */

        $sSqldadoscomplementares = $cldadoscomplementareslrf->sql_query(null,"*",null, "c218_mesusu=".$this->sDataFinal['5'].$this->sDataFinal['6']." AND c218_codorgao = '$iCodOrgao' AND c218_anousu = ".db_getsession('DB_anousu')." ");
        $rsDadoscomplementares = $cldadoscomplementareslrf->sql_record($sSqldadoscomplementares);
        $rsDadoscomplementares = db_utils::getColectionByRecord($rsDadoscomplementares);
    //echo '<pre>'; var_dump($rsDadoscomplementares);die;
        foreach ($rsDadoscomplementares as $dados) {

            $cldclrf10 = new cl_dclrf102021();
            $cldclrf10->si157_tiporegistro = 10;
            $cldclrf10->si157_codorgao                          = $dados->c218_codorgao;
            $cldclrf10->si157_passivosreconhecidos              = $dados->c218_passivosreconhecidos;
            $cldclrf10->si157_vlsaldoatualconcgarantiainterna   = $dados->c218_vlsaldoatualconcgarantiainterna;
            $cldclrf10->si157_vlsaldoatualconcgarantia          = $dados->c218_vlsaldoatualconcgarantia;
            $cldclrf10->si157_vlsaldoatualcontragarantiainterna = $dados->c218_vlsaldoatualcontragarantiainterna;
            $cldclrf10->si157_vlsaldoatualcontragarantiaexterna = $dados->c218_vlsaldoatualcontragarantiaexterna;
            $cldclrf10->si157_medidascorretivas                 = $this->removeCaracteres($dados->c218_medidascorretivas);
            $cldclrf10->si157_recalieninvpermanente             = $dados->c218_recalieninvpermanente;
            $cldclrf10->si157_vldotinicialincentcontrib         = $dados->c218_vldotinicialincentivocontrib;
            $cldclrf10->si157_vldotatualizadaincentcontrib      = $dados->c218_vldotatualizadaincentcontrib;
            $cldclrf10->si157_vlempenhadoicentcontrib           = $dados->c218_vlempenhadoicentcontrib;
            $cldclrf10->si157_vldotinicialincentinstfinanc      = $dados->c218_vldotincentconcedinstfinanc;
            $cldclrf10->si157_vldotatualizadaincentinstfinanc   = $dados->c218_vldotatualizadaincentinstfinanc;
            $cldclrf10->si157_vlempenhadoincentinstfinanc       = $dados->c218_vlempenhadoincentinstfinanc;
            $cldclrf10->si157_vlliqincentcontrib                = $dados->c218_vlliqincentcontrib;
            $cldclrf10->si157_vlliqincentinstfinanc             = $dados->c218_vlliqincentinstfinanc;
            $cldclrf10->si157_vlirpnpincentcontrib              = $dados->c218_vlirpnpincentcontrib;
            $cldclrf10->si157_vlirpnpincentinstfinanc           = $dados->c218_vlirpnpincentinstfinanc;
            $cldclrf10->si157_vlapropiacaodepositosjudiciais    = $dados->c218_vlapropiacaodepositosjudiciais;
            $cldclrf10->si157_vlajustesrelativosrpps            = $dados->c218_vlajustesrelativosrpps;
            $cldclrf10->si157_vloutrosajustes                   = $dados->c218_vloutrosajustes;
            $cldclrf10->si157_metarrecada                       = $dados->c218_metarrecada;
            $cldclrf10->si157_dscmedidasadotadas                = $this->removeCaracteres($dados->c218_dscmedidasadotadas);//OC8680
            $cldclrf10->si157_instit                            = db_getsession("DB_instit");
            $cldclrf10->si157_mes                               = $dados->c218_mesusu;

            $cldclrf10->incluir(null);
            if ($cldclrf10->erro_status == 0) {
                throw new Exception($cldclrf10->erro_msg);
            }

            /**
             * Registro 11
             */
            if($dados->c218_metarrecada == 2){
                $sSqlMedidasAdotadas = $clmedidasadotadaslrf->sql_query(null,"*",null,"c225_dadoscomplementareslrf = {$dados->c218_sequencial}");
                $oResultMedidasAdotadas = $clmedidasadotadaslrf->sql_record($sSqlMedidasAdotadas);
                $rsDadosMedidasAdotadas = db_utils::getColectionByRecord($oResultMedidasAdotadas);

                foreach ($rsDadosMedidasAdotadas as $medida) {

                    $cldclrf11->si205_tiporegistro = 11;
                    $cldclrf11->si205_medidasadotadas = $medida->c225_metasadotadas;
                    if($medida->c225_metasadotadas == 99){
                        $cldclrf11->si205_dscmedidasadotadas = $this->removeCaracteres($dados->c218_dscmedidasadotadas);
                    }else{
                        $cldclrf11->si205_dscmedidasadotadas = "";
                    }
                    $cldclrf11->si205_reg10 = $cldclrf10->si157_sequencial;
                    $cldclrf11->si205_mes = $dados->c218_mesusu;
                    $cldclrf11->si205_instit = db_getsession("DB_instit");
                    $cldclrf11->incluir(null);

                    if ($cldclrf11->erro_status == 0) {
                        throw new Exception($cldclrf11->erro_msg);
                    }
                }

            }

            if($this->getTipoinstit(db_getsession('DB_instit')) == 2){
                if($this->sDataFinal['5'].$this->sDataFinal['6'] == '12'){
                    $cldclrf20 = new cl_dclrf202021();
                    $cldclrf20->si191_tiporegistro = 20;
                    $cldclrf20->si191_reg10 = $cldclrf10->si157_sequencial;
                    $cldclrf20->si191_contopcredito = $dados->c219_contopcredito;
                    $cldclrf20->si191_dsccontopcredito = $this->removeCaracteres($dados->c219_dsccontopcredito);
                    $cldclrf20->si191_realizopcredito = $dados->c219_realizopcredito;
                    $cldclrf20->si191_tiporealizopcreditocapta = $dados->c219_tiporealizopcreditocapta;
                    $cldclrf20->si191_tiporealizopcreditoreceb = $dados->c219_tiporealizopcreditoreceb;
                    $cldclrf20->si191_tiporealizopcreditoassundir = $dados->c219_tiporealizopcreditoassundir;
                    $cldclrf20->si191_tiporealizopcreditoassunobg = $dados->c219_tiporealizopcreditoassunobg;
                    $cldclrf20->si191_mes = $dados->c218_mesusu;
                    $cldclrf20->si191_instit = db_getsession("DB_instit");
                    $cldclrf20->incluir(null);

                    if ($cldclrf20->erro_status == 0) {
                        throw new Exception($cldclrf20->erro_msg);
                    }

                }
                $cldclrf30 = new cl_dclrf302021();
                $cldclrf30->si192_tiporegistro = 30;
                $cldclrf30->si192_publiclrf = $dados->c220_publiclrf;
                $cldclrf30->si192_dtpublicacaorelatoriolrf = $dados->c220_dtpublicacaorelatoriolrf;
                $cldclrf30->si192_localpublicacao = $this->removeCaracteres($dados->c220_localpublicacao);
                $cldclrf30->si192_tpbimestre = $dados->c220_tpbimestre;
                $cldclrf30->si192_exerciciotpbimestre = $dados->c220_exerciciotpbimestre;
                $cldclrf30->si192_reg10 = $cldclrf10->si157_sequencial;
                $cldclrf30->si192_mes = $dados->c218_mesusu;
                $cldclrf30->si192_instit = db_getsession("DB_instit");
//                echo"<pre>"; print_r($cldclrf30);exit;
                $cldclrf30->incluir(null);
                if ($cldclrf30->erro_status == 0) {
                    throw new Exception($cldclrf30->erro_msg);
                }

            }
            $cldclrf40 = new cl_dclrf402021();
            $cldclrf40->si193_tiporegistro = 40;
            $cldclrf40->si193_reg10 = $cldclrf10->si157_sequencial;
            $cldclrf40->si193_publicrgf = $dados->c221_publicrgf;
            $cldclrf40->si193_dtpublicacaorgf = $dados->c221_dtpublicacaorelatoriorgf;
            $cldclrf40->si193_localpublicacaorgf = $this->removeCaracteres($dados->c221_localpublicacaorgf);
            $cldclrf40->si193_tpperiodo = $dados->c221_tpperiodo;
            $cldclrf40->si193_exerciciotpperiodo = $dados->c221_exerciciotpperiodo;
            $cldclrf40->si193_mes = $dados->c218_mesusu;
            $cldclrf40->si193_instit = db_getsession("DB_instit");
            $cldclrf40->incluir(null);
            if ($cldclrf40->erro_status == 0) {
                throw new Exception($cldclrf40->erro_msg);
            }

        }

        db_fim_transacao();

        $oGerarDCLRF = new GerarDCLRF();
        $oGerarDCLRF->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $oGerarDCLRF->iOrgao = $iCodOrgao;
        $oGerarDCLRF->iTipoIntint = $this->getTipoinstit(db_getsession('DB_instit'));
        $oGerarDCLRF->gerarDados();

    }

}
