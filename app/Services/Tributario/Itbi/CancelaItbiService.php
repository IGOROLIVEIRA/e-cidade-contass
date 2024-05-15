<?php

namespace App\Services\Tributario\Itbi;
use cl_itbicancela;
use Itbi;
use LogicException;
use UsuarioSistema;

require_once 'model/itbi/Itbi.model.php';
require_once 'classes/db_itbicancela_classe.php';
require_once 'model/configuracao/UsuarioSistema.model.php';

class CancelaItbiService
{

    /**
     * @var cl_itbicancela $LegacyItbiCancelaRepository
     */
    private $LegacyItbiCancelaRepository;

    /**
     * @var UsuarioSistema
     */
    private $LegacyUsuarioSistemaModel;

    /**
     * @param UsuarioSistema $LegacyUsuarioSistemaModel
     */
    public function __construct($LegacyUsuarioSistemaModel)
    {
        $this->LegacyItbiCancelaRepository = new cl_itbicancela();
        $this->LegacyUsuarioSistemaModel = $LegacyUsuarioSistemaModel;
    }

    /**
     * @param Itbi $itbi
     * @param string $obs
     * @return void
     */
    public function execute($itbi, $obs)
    {
        $this->LegacyItbiCancelaRepository->it16_id_usuario = $this->LegacyUsuarioSistemaModel->getCodigo();
        $this->LegacyItbiCancelaRepository->it16_obs = $obs;
        $this->LegacyItbiCancelaRepository->it16_data = date('Y-m-d');
        $this->LegacyItbiCancelaRepository->incluir($itbi->it01_guia);
        if ($this->LegacyItbiCancelaRepository->erro_status === "0") {
            throw new LogicException("Não foi possível cancelar o ITBI: ".$this->LegacyItbiCancelaRepository->erro_msg);
        }
    }

}
