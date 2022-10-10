<?php

namespace App\Services\Tributario\Itbi;

use cl_arrecad;
use cl_divida;
use cl_itbi_divida;
use cl_numpref;
use DateTime;
use db_utils;
use DBException;
use Exception;
use InvalidArgumentException;
use Itbi;
use LogicException;
use UsuarioSistema;

require_once "libs/db_utils.php";
require_once "model/configuracao/UsuarioSistema.model.php";
require_once "model/itbi/Itbi.model.php";
require_once "classes/db_numpref_classe.php";
require_once "classes/db_arrecad_classe.php";
require_once "classes/db_divida_classe.php";
require_once "classes/db_itbi_divida_classe.php";
require_once "CancelaItbiService.php";

class InscricaoDividaAtivaItbiService
{

    /**
     * @var UsuarioSistema $LegacyUsuarioSistemaModel
     */
    private $LegacyUsuarioSistemaModel;

    /**
     * @var cl_itbi_divida $LegacyItbiDividaRepository
     */
    private $LegacyItbiDividaRepository;

    /**
     * @var cl_divida $LegacyDividaRepository
     */
    private $LegacyDividaRepository;

    /**
     * @var cl_numpref $LegacyNumprefRepository
     */
    private $LegacyNumprefRepository;

    /**
     * @var cl_arrecad $LegacyArrecadRepository
     */
    private $LegacyArrecadRepository;

    /**
     * @var CancelaItbiService
     */
    private $CancelaItbiService;

    /**
     * @throws DBException
     */
    public function __construct()
    {
        $this->LegacyUsuarioSistemaModel = new UsuarioSistema(db_getsession('DB_id_usuario'));
        $this->LegacyItbiDividaRepository = new cl_itbi_divida();
        $this->LegacyDividaRepository = new cl_divida();
        $this->LegacyNumprefRepository = new cl_numpref();
        $this->LegacyArrecadRepository = new cl_arrecad();
        $this->CancelaItbiService = new CancelaItbiService($this->LegacyUsuarioSistemaModel);
    }

    /**
     * @param DateTime $dataVencimento
     * @return void
     * @throws Exception
     */
    public function execute($dataVencimento)
    {
        if(empty($dataVencimento) === true) {
            throw new InvalidArgumentException('Campo data de vencimento não informado');
        }

        $arrItbis = db_utils::getCollectionByRecord(
            $this->LegacyItbiDividaRepository->sql_record(
                $this->LegacyItbiDividaRepository->sql_query_vencidos($dataVencimento->format('Y-m-d')
                )
            )
        );
        foreach ($arrItbis as $itbi) {
            $legacyItbiModel = new Itbi($itbi->it01_guia);
            $this->includeDivida($legacyItbiModel);
        }
    }

    /**
     * @param Itbi $LegacyItbiModel
     * @return void
     * @throws Exception
     */
    private function includeDivida($LegacyItbiModel)
    {
        $dataDia = new DateTime();
        $exercicioDivida = new DateTime($LegacyItbiModel->it01_data);

        $this->LegacyDividaRepository->v01_coddiv = null;
        $this->LegacyDividaRepository->v01_numcgm = $LegacyItbiModel->getCgmDevedor();
        $this->LegacyDividaRepository->v01_dtinsc = $dataDia->format('Y-m-d');
        $this->LegacyDividaRepository->v01_exerc  = $exercicioDivida->format('Y');
        $this->LegacyDividaRepository->v01_numpre = $this->LegacyNumprefRepository->sql_numpre();
        $this->LegacyDividaRepository->v01_numpar = 1;
        $this->LegacyDividaRepository->v01_numtot = 1;
        $this->LegacyDividaRepository->v01_vlrhis = $LegacyItbiModel->ItbiAvalia->it14_valorpaga;
        $this->LegacyDividaRepository->v01_proced = $LegacyItbiModel->parItbi->getProced();
        $this->LegacyDividaRepository->v01_dtvenc = $LegacyItbiModel->ItbiAvalia->it14_dtvenc;
        $this->LegacyDividaRepository->v01_dtoper = $LegacyItbiModel->ItbiAvalia->it14_dtliber;
        $this->LegacyDividaRepository->v01_valor  = $LegacyItbiModel->ItbiAvalia->it14_valorpaga;
        $this->LegacyDividaRepository->v01_obs    = "Inscrição do ITBI #{$LegacyItbiModel->it01_guia} em dívida ativa.";
        $this->LegacyDividaRepository->v01_numdig = "0";
        $this->LegacyDividaRepository->v01_instit = db_getsession("DB_instit");
        $this->LegacyDividaRepository->v01_dtinclusao = $dataDia->format('Y-m-d');

        $this->LegacyDividaRepository->incluir($this->LegacyDividaRepository->v01_coddiv);
        if ($this->LegacyDividaRepository->erro_status === 0) {
            throw new LogicException("Erro ao incluir D.A do Itbi {$LegacyItbiModel->it01_guia}. ");
        }

        $this->includeArrecad($LegacyItbiModel, $this->LegacyDividaRepository->v01_numpre, $dataDia);
        $this->includeItbiDivida($LegacyItbiModel, $this->LegacyDividaRepository);
        $this->cancelItbi($LegacyItbiModel, $this->LegacyDividaRepository);
    }

    /**
     * @param Itbi $LegacyItbiModel
     * @param int $numpre
     * @param DateTime $date
     * @return void
     * @throws Exception
     */
    private function includeArrecad($LegacyItbiModel, $numpre, $date)
    {
        $this->LegacyArrecadRepository->k00_numpre = $numpre;
        $this->LegacyArrecadRepository->k00_numpar = 1;
        $this->LegacyArrecadRepository->k00_numcgm = $LegacyItbiModel->getCgmDevedor();
        $this->LegacyArrecadRepository->k00_dtoper = $date->format('Y-m-d');
        $this->LegacyArrecadRepository->k00_receit = $LegacyItbiModel->parItbi->getReceita();
        $this->LegacyArrecadRepository->k00_hist   = $LegacyItbiModel->parItbi->ProcedenciaDivida->getHistoricoCalculo();
        $this->LegacyArrecadRepository->k00_valor  = $LegacyItbiModel->ItbiAvalia->it14_valorpaga;
        $this->LegacyArrecadRepository->k00_dtvenc = $LegacyItbiModel->ItbiAvalia->it14_dtvenc;
        $this->LegacyArrecadRepository->k00_numtot = 1;
        $this->LegacyArrecadRepository->k00_numdig = 1;
        $this->LegacyArrecadRepository->k00_tipo   = $LegacyItbiModel->parItbi->ProcedenciaDivida->getProcedArretipo();
        $this->LegacyArrecadRepository->k00_tipojm = '0';

        $this->LegacyArrecadRepository->incluir();
        if ($this->LegacyArrecadRepository->erro_status === "0") {
            throw new LogicException("Não foi possível salvar os dados do novo débito.".$this->LegacyArrecadRepository->erro_msg);
        }
    }

    /**
     * @param Itbi $LegacyItbiModel
     * @param cl_divida $LegacyDividaRepository
     * @return void
     */
    private function includeItbiDivida($LegacyItbiModel, $LegacyDividaRepository)
    {
        $this->LegacyItbiDividaRepository->it36_guia = $LegacyItbiModel->it01_guia;
        $this->LegacyItbiDividaRepository->it36_coddiv = $LegacyDividaRepository->v01_coddiv;
        $this->LegacyItbiDividaRepository->it36_usuario = $this->LegacyUsuarioSistemaModel->getCodigo();
        $this->LegacyItbiDividaRepository->it36_data = date('Y-m-d');
        $this->LegacyItbiDividaRepository->it36_observacao = 'Inscrição feita via rotina de automação.';
        $this->LegacyItbiDividaRepository->incluir();
        if ($this->LegacyItbiDividaRepository->erro_status === "0") {
            throw new LogicException("Não foi possível incluir o vínculo da D.A com o ITBI: ".$this->LegacyItbiDividaRepository->erro_msg);
        }
    }

    /**
     * @param Itbi $LegacyItbiModel
     * @param cl_divida $LegacyDividaRepository
     * @return void
     */
    private function cancelItbi($LegacyItbiModel, $LegacyDividaRepository)
    {
        $this->CancelaItbiService
            ->execute($LegacyItbiModel, 'Inscrito em D.A. Código da D.A: '. $LegacyDividaRepository->v01_coddiv);
    }
}
