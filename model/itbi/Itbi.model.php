<?php
require_once "Itbinumpre.model.php";
require_once "Itbimatric.model.php";
require_once "Itbinome.model.php";
require_once "Paritbi.model.php";
require_once "Transfautomaticas.model.php";
require_once "model/cadastro/Imovel.model.php";
class Itbi
{
    public $it01_guia;
    public $it01_data;
    public $it01_hora;
    public $it01_tipotransacao;
    public $it01_areaterreno;
    public $it01_areaedificada;
    public $it01_obs;
    public $it01_valortransacao;
    public $it01_areatrans;
    public $it01_mail;
    public $it01_finalizado;
    public $it01_origem;
    public $it01_id_usuario;
    public $it01_coddepto;
    public $it01_valorterreno;
    public $it01_valorconstr;
    public $it01_envia;
    public $it01_percentualareatransmitida;
    public $Itbi;
    public $Itbinumpre;
    public $Itbimatric;
    public $Itbinome;

    public function __construct($it01_guia = null)
    {
        if(!empty($it01_guia)) {

            $oItbi = db_utils::getDao('itbi');
            $oItbi = current(db_utils::getCollectionByRecord($oItbi->sql_record($oItbi->sql_query(null, "*", null, "it01_guia = {$it01_guia}"))));
            $this->it01_guia = $oItbi->it01_guia;
            $this->it01_data = $oItbi->it01_data;
            $this->it01_hora = $oItbi->it01_hora;
            $this->it01_tipotransacao = $oItbi->it01_tipotransacao;
            $this->it01_areaterreno = $oItbi->it01_areaterreno;
            $this->it01_areaedificada = $oItbi->it01_areaedificada;
            $this->it01_obs = $oItbi->it01_obs;
            $this->it01_valortransacao = $oItbi->it01_valortransacao;
            $this->it01_areatrans = $oItbi->it01_areatrans;
            $this->it01_mail = $oItbi->it01_mail;
            $this->it01_finalizado = $oItbi->it01_finalizado;
            $this->it01_origem = $oItbi->it01_origem;
            $this->it01_id_usuario = $oItbi->it01_id_usuario;
            $this->it01_coddepto = $oItbi->it01_coddepto;
            $this->it01_valorterreno = $oItbi->it01_valorterreno;
            $this->it01_valorconstr = $oItbi->it01_valorconstr;
            $this->it01_envia = $oItbi->it01_envia;
            $this->it01_percentualareatransmitida = $oItbi->it01_percentualareatransmitida;
            $this->Itbimatric = new Itbimatric($it01_guia);
            $this->Itbinome = new Itbinome();
            $this->Itbinome = $this->Itbinome->findByItbi($it01_guia);
            $this->Itbinumpre = $this->getItbinumpre();
        }
        return $this;
    }

    /**
     * Processa a transferencia automatica em guias de itbi pagas
     * @param int $iCodRet
     * @throws Exception
     * @return Void
     */
    public function processarTransferenciaAutomatica($iCodRet)
    {
        $oParItbi = new Paritbi(db_getsession('DB_anousu'));
        if($oParItbi->getTransfautomatica() == 't') {
            $oDisbanco = new Disbanco();
            $aDisbanco = $oDisbanco->getNumpresByCodRet($iCodRet);

            foreach ($aDisbanco as $obj) {

                $oItbi = $this->getinstanceByNumpre($obj->k00_numpre);
                if ($oItbi->it01_guia != null) {
                    $this->_processarTransferenciaAutomatica($oItbi);
                }
            }
        }
    }

    public function getNumpre()
    {
        return current($this->Itbinumpre)->it15_numpre;
    }

    public function getMatric()
    {
        $this->Itbimatric->it06_matric;
    }

    public function getinstanceByNumpre($iNumpre)
    {
        $oItbinumpre = new Itbinumpre();
        $oItbinumpre = $oItbinumpre->getInstanceByNumpre($iNumpre);
        return new Itbi($oItbinumpre->it15_guia);
    }

    /**
     * Retorna o comprador principal
     * @return Itbinome|null
     */
    public function getCompradorPrincipal()
    {
        foreach($this->Itbinome as $obj)
        {
            if($obj->isComprador() && $obj->it03_princ){
                return $obj;
            }
        }

        return null;
    }

    /**
     * Retorna o transmitente principal
     * @author Rodrigo Cabral <rodrigo.cabral@contassconsultoria.com.br>
     * @return Itbinome|null
     */
    public function getTransmitentePrincipal()
    {
        foreach($this->Itbinome as $obj)
        {
            if($obj->isTransmitente() && $obj->it03_princ){
                return $obj;
            }
        }
        return null;
    }

    /**
     * Busca todos os numpres de uma guia de ITBI
     * @return Array
     */
    public function getItbinumpre()
    {
        $oItbinumpre = new Itbinumpre();
        return $oItbinumpre->findAllByItbi($this->it01_guia);
    }

    /**
     * Realiza a transferência de propriedade do imóvel
     * @param Itbi $oItbi
     */
    protected function _processarTransferenciaAutomatica(Itbi $oItbi)
    {
        $oRetorno = new stdClass();
        $oRetorno->error = false;
        $oRetorno->msg = "Processo realizado com sucesso!";
        try{
            $oImovel = new Imovel($oItbi->Itbimatric->it06_matric);
            $iMatric = $oImovel->getMatricula();
            if(empty($iMatric)){
                throw new Exception("Imóvel não existe");
            }

            $oProprietarioAtual = $oImovel->getProprietarioPrincipal();

            if($oProprietarioAtual->getCodigo() != $oItbi->getTransmitentePrincipal()->getCgm()){
                throw new Exception("CGM Proprietário atual ({$oProprietarioAtual->getCodigo()}) não é o mesmo do Transmitente ({$oItbi->getTransmitentePrincipal()->getCgm()})");
            }

            $oImovel->setNumcgm($oItbi->getCompradorPrincipal()->getCgm());
            $oImovel->alterarCgmProprietario();
        } catch (Exception $ex){
            $oRetorno->error = true;
            $oRetorno->msg = $ex->getMessage();
        }

        $this->_registraTransferencia($oRetorno, $oItbi);
    }

    /**
     * Registra na tabela os dados da transferencia
     * @param stdClass $oRetorno
     * @param Itbi $oItbi
     * @return Void
     */
    protected function _registraTransferencia($oRetorno, Itbi $oItbi)
    {
        $oTransf = db_utils::getDao('transfautomaticas');
        $oTransf->it35_guia = $oItbi->it01_guia;
        $oTransf->it35_transmitente = $oItbi->getTransmitentePrincipal()->getCgm();
        $oTransf->it35_comprador = $oItbi->getCompradorPrincipal()->getCgm();
        $oTransf->it35_usuario = db_getsession('DB_id_usuario');
        $oTransf->it35_numpre = $oItbi->getNumpre();
        $oTransf->it35_data = date('Y-m-d');
        $oTransf->it35_observacao = $oRetorno->msg;
        $oTransf->it35_status = $oRetorno->error ? Transfautomaticas::STATUS_FAIL : Transfautomaticas::STATUS_SUCCESS;
        $oTransf->incluir();
    }

}