<?php
require_once "Itbinomecgm.model.php";
class Itbinome
{
    CONST TIPO_COMPRADOR = 'C';
    CONST TIPO_TRANSMITENTE = 'T';

    public $it03_seq;
    public $it03_guia;
    public $it03_tipo;
    public $it03_princ;
    public $it03_nome;
    public $it03_sexo;
    public $it03_cpfcnpj;
    public $it03_endereco;
    public $it03_numero;
    public $it03_compl;
    public $it03_cxpostal;
    public $it03_bairro;
    public $it03_munic;
    public $it03_uf;
    public $it03_cep;
    public $it03_mail;
    public $Itbinomecgm;

    public function findByItbi($it03_guia = null)
    {
        $aNomes = array();
        if(!empty($it03_guia)) {
            $oDaoItbinome = db_utils::getDao('itbinome');
            $oDaoItbinome = db_utils::getCollectionByRecord($oDaoItbinome->sql_record($oDaoItbinome->sql_query(null, "*", null, "it03_guia = {$it03_guia}")));
            foreach($oDaoItbinome as $obj){
                $oItbiNome = new Itbinome();
                $oItbiNome->it03_seq = $obj->it03_seq;
                $oItbiNome->it03_guia = $obj->it03_guia;
                $oItbiNome->it03_tipo = $obj->it03_tipo;
                $oItbiNome->it03_princ = $obj->it03_princ;
                $oItbiNome->it03_nome = $obj->it03_nome;
                $oItbiNome->it03_sexo = $obj->it03_sexo;
                $oItbiNome->it03_cpfcnpj = $obj->it03_cpfcnpj;
                $oItbiNome->it03_endereco = $obj->it03_endereco;
                $oItbiNome->it03_numero = $obj->it03_numero;
                $oItbiNome->it03_compl = $obj->it03_compl;
                $oItbiNome->it03_cxpostal = $obj->it03_cxpostal;
                $oItbiNome->it03_bairro = $obj->it03_bairro;
                $oItbiNome->it03_munic = $obj->it03_munic;
                $oItbiNome->it03_uf = $obj->it03_uf;
                $oItbiNome->it03_cep = $obj->it03_cep;
                $oItbiNome->it03_mail = $obj->it03_mail;
                $oItbiNome->Itbinomecgm = new Itbinomecgm();
                $oItbiNome->Itbinomecgm = $oItbiNome->Itbinomecgm->getIntanceByItbinome($obj->it03_seq);
                $aNomes[] = $oItbiNome;
            }
        }
        return $aNomes;
    }

    public function isComprador()
    {
        return $this->it03_tipo == self::TIPO_COMPRADOR;
    }

    public function isTransmitente()
    {
        return $this->it03_tipo == self::TIPO_TRANSMITENTE;
    }

    public function getCgm()
    {
        return $this->Itbinomecgm->it21_numcgm;
    }
}