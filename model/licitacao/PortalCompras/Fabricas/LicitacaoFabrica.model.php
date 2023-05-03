<?php

require_once("model/licitacao/PortalCompras/Modalidades/Licitacao.model.php");
require_once("model/licitacao/PortalCompras/Fabricas/LicitacaoFabricaInterface.model.php");
require_once("model/licitacao/PortalCompras/Fabricas/PregaoFabrica.model.php");

class LicitacaoFabrica implements LicitacaoFabricaInterface
{
    private array $modalidades;

    /**
     * Constructor Method
     */
    public function __construct()
    {
       $this->modalidades = [
            '53' => 'PregaoFabrica',
       ];
    }

    /**
     * Undocumented function
     *
     * @param $data
     * @param integer $numrows
     * @return Licitacao
     */
    public function create($data, int $numrows): Licitacao
    {
        $codigoModalidade = db_utils::fieldsMemory($data, 0)->codigomodalidade;
        $licitacaoFabrica = new $this->modalidades[$codigoModalidade];
        $licitacao = $licitacaoFabrica->create($data, $numrows);

        var_dump("teste");
        var_dump(db_utils::fieldsMemory($data, 0)->codigomodalidade);
        var_dump("chegou aqui");
        die();
    }
}