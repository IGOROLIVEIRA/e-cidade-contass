<?php
namespace Model\Itbi;

use db_utils;
use DBException;
use UsuarioSistema;

require_once "Paritbi.model.php";
require_once "model/configuracao/UsuarioSistema.model.php";

class Itbidivida
{
    /**
     * @var int
     */
    public $it36_guia;

    /**
     * @var int
     */
    public $it36_coddiv;

    /**
     * @var string
     */
    public $it36_data;

    /**
     * @var int
     */
    public $it36_usuario;

    /**
     * @var string
     */
    public $it36_observacao;

    /**
     * @var UsuarioSistema
     */
    private $usuarioSistema;

    /**
     * @var Paritbi
     */
    private $parItbi;

    /**
     * @throws DBException
     */
    public function __construct($it36_guia = null)
    {
        if(empty($it36_guia) === false) {
            $oItbiDivida = db_utils::getDao('itbi_divida');
            $oItbiDivida = current(db_utils::getCollectionByRecord($oItbiDivida->sql_record($oItbiDivida->sql_query(null, "*", null, "it36_guia = {$it36_guia}"))));
            $this->it36_guia = $oItbiDivida->it36_guia;
            $this->it36_coddiv = $oItbiDivida->it36_coddiv;
            $this->it36_data = $oItbiDivida->it36_data;
            $this->it36_usuario = $oItbiDivida->it36_usuario;
            $this->it36_observacao = $oItbiDivida->it36_observacao;
            $this->usuarioSistema = new UsuarioSistema($this->it36_usuario);
            $this->parItbi = new Paritbi(db_getsession('DB_anousu'));
        }
        return $this;
    }

    /**
     * @return UsuarioSistema
     */
    public function getUsuarioSistema()
    {
        return $this->usuarioSistema;
    }

    /**
     * @return Paritbi
     */
    public function getParItbi()
    {
        return $this->parItbi;
    }
}
