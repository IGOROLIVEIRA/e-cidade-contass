<?php

require_once("model/licitacao/PortalCompras/Modalidades/Licitacao.model.php");
require_once("model/licitacao/PortalCompras/Fabricas/LicitacaoFabricaInterface.model.php");
require_once("model/licitacao/PortalCompras/Fabricas/PregaoFabrica.model.php");
require_once("model/licitacao/PortalCompras/Provedor/LigadorClasses.model.php");
require("model/licitacao/PortalCompras/Fabricas/LoteFabrica.model.php");
require_once("model/licitacao/PortalCompras/Fabricas/DispensaFabrica.model.php");
require_once("model/licitacao/PortalCompras/Fabricas/ConcorrenciaFabrica.model.php");
class LicitacaoFabrica implements LicitacaoFabricaInterface
{
    private array $modalidades;

    /**
     * Constructor Method
     */
    public function __construct()
    {
       $this->modalidades = LigadorClasses::listaBindModalidades();
    }

    /**
     * Cria fabrica de modalidade
     *
     * @param $data
     * @param integer $numrows
     * @return Licitacao
     */
    public function criar($data, int $numrows): Licitacao
    {
        $codigoModalidade = db_utils::fieldsMemory($data, 0)->codigomodalidade;
        $modalidadeFabrica = new $this->modalidades[$codigoModalidade];
        return $modalidadeFabrica->criar($data, $numrows);
    }
}
