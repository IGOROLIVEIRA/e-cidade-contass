<?php

require_once("model/licitacao/PortalCompras/Julgamento/Julgamento.model.php");
require_once("classes/db_liclicitaimportarjulgamento_classe.php");
require_once("model/licitacao/PortalCompras/Julgamento/Proposta.model.php");
class InsereJulgamento
{
    private $dao;

    public function __construct()
    {
        $dao = new cl_liclicitaimportarjulgamento;
    }

    public function execute(Julgamento $julgamento)
    {
        $dao = $this->dao;
        $idJulgamento = $julgamento->getId();
        $numero = $julgamento->getNumero();
        $dao->pc20_obs = "ORCAMENTO IMPORTADO -"
            . $idJulgamento
            ." - ". $numero;
        $dao->pc20_dtate = $julgamento->getDataProposta();
        $dao->pc20_hrate = $julgamento->getHoraProposta();
        $lotes = $julgamento->getLotes();

        try{
            pg_exec('begin');

            $idOrcamento = $dao->inserePcorcam();
            $dao->pc21_codorc = $idOrcamento;

            foreach($lotes as $lote) {
                $propostas = $lote->getPropostas();

                foreach($propostas as $proposta) {
                    $numcgmResource = $dao->buscaNumCgm($proposta->getIdFornecedor());
                    $numcgm = (db_utils::fieldsMemory($numcgmResource, 0))->numcgm;
                    $dao->pc21_numcgm = $numcgm;
                    $idpcorcamforne = $dao->inserePcorcamforne();



                }
                $dao->l206_fornecedor = $numcgm;
                $dao->l206_licitacao = $idJulgamento;


            }


            pg_exec("commit");

        } catch(Exception $e) {

            pg_exec('rollback');
        }
    }

    private function insereFornecedores(array $propostas)
    {

    }
}