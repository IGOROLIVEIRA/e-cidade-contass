<?php

require_once("model/licitacao/PortalCompras/Julgamento/Julgamento.model.php");
require_once("classes/db_liclicitaimportarjulgamento_classe.php");
require_once("model/licitacao/PortalCompras/Julgamento/Proposta.model.php");
require_once("model/licitacao/PortalCompras/Julgamento/Item.model.php");

class InsereJulgamento
{
    private $dao;

    /**
     * Metodo construtor
     */
    public function __construct()
    {
        $this->dao = new cl_liclicitaimportarjulgamento;
    }

    public function execute(Julgamento $julgamento)
    {
        $idJulgamento = $julgamento->getId();
        $numero = $julgamento->getNumero();
        $this->dao->pc20_obs = "ORCAMENTO IMPORTADO -"
            . $idJulgamento
            ." - ". $numero;
        $this->dao->pc20_dtate = $julgamento->getDataProposta();
        $this->dao->pc20_hrate = $julgamento->getHoraProposta();
        $lotes = $julgamento->getLotes();
        $itens = array_map(fn(Lote $lote) => $lote->getItems(), $lotes);
        $quantidadeItens = count($itens);
        //$propostas = array_map(fn(Item $item) => $item->getPropostas(), $itens);
        //$idForncedores = array_map(fn(Proposta $proposta) => $proposta->getIdFornecedor(), $propostas);

        try{
            pg_exec('begin');

            $idOrcamento = $this->dao->inserePcorcam();
            $this->dao->pc21_codorc = $idOrcamento;
            $this->dao->pc22_codorc = $idOrcamento;

         /*    $idPcorcamforne = $this->lidaPcorcamforne($idForncedores);

            $idLiclicitem = $this->lidaLiclicitem($quantidadeItens);

            $idPcorcamitemlic = $this->lidaPcorcamitemlic($idLiclicitem, $itens);
 */
            /** @var Item[] $itens */
            foreach($itens as $item) {
                $propostas = $item->getPropostas();

                foreach($propostas as $proposta) {
                    $idPcorcamforne = $this->lidaPcorcamforne($proposta);
                    $idLiclicitem = $this->lidaLiclicitem();
                    $idPcorcamitemlic = $this->lidaPcorcamitemlic($item->getId(), $idLiclicitem);


                }
            }

            pg_exec("commit");

        } catch(Exception $e) {

            pg_exec('rollback');
        }
    }

    //private function lidaPcorcamforne(array $idForncedores): array
    private function lidaPcorcamforne(Proposta $proposta): int
    {
        /* $idPcorcamforne = [];

        foreach($idForncedores as $id) {
            $numcgmResource = $this->dao->buscaNumCgm($id);
            $numcgm = (db_utils::fieldsMemory($numcgmResource, 0))->numcgm;
            $this->dao->pc21_numcgm = $numcgm;
            $idPcorcamforne[] = $this->dao->inserePcorcamforne();
        }

        return $idPcorcamforne; */;
        $numcgmResource = $this->dao->buscaNumCgm($proposta->getIdFornecedor());
        $this->dao->pc21_numcgm = (db_utils::fieldsMemory($numcgmResource, 0))->numcgm;
        return $this->dao->inserePcorcamforne();
    }

    //private function lidaLiclicitem(int $quantidadeItens): array
    private function lidaLiclicitem(): int
    {
        /* $idLiclicitem = [];

        for ($i = 0; $i < $quantidadeItens; $i++) {
            $idLiclicitem[] = $this->dao->inserePcorcamitem();
        }

        return $idLiclicitem; */
        return $this->dao->inserePcorcamitem();
    }

    //private function lidaPcorcamitemlic(array $idLiclicitem, array $itens)
    private function lidaPcorcamitemlic(int $id, int $idPcorcamitem ): int
    {
       /*  $idPcorcamitemlic = [];
        $indice = 0;

        foreach($itens as $item) {
            $this->dao->pc26_liclicitem = $this->dao->buscaL21codigo(
                $item->getId()
            );

            $this->dao->pc26_orcamitem = $idLiclicitem[$indice];

            $idPcorcamitemlic[] = $this->dao->inserePcorcamitemlic();

            $indice++;

        }

        return $idPcorcamitemlic; */
        $this->dao->pc26_liclicitem = $this->dao->buscaL21codigo(

        );

        $this->dao->pc26_orcamitem = $idLiclicitem[$indice];

        return $this->dao->inserePcorcamitemlic();
    }

    //private function lidaPcorcamval(array $proposta)
    private function lidaPcorcamval(Proposta $proposta, int $orcamforne, int $orcamitem )
    {
       /*  foreach($propostas as $proposta) {
            $this->pc23_orcamforne =
            $this->pc23_orcamitem =
            $this->pc23_valor =
            $this->pc23_quant =
            $this->pc23_obs =
            $this->pc23_vlrun =
            $this->pc23_validmin =
            $this->pc23_percentualdesconto =
            $this->pc23_perctaxadesctabela =

        } */
            $this->dao->pc23_orcamforne =
            $this->dao->pc23_orcamitem =
            $this->dao->pc23_valor = $proposta->getValorTotal();
            $this->dao->pc23_quant = $proposta->getQuantidade();
            $this->dao->pc23_obs = $proposta->getMarca();
            $this->dao->pc23_vlrun = $proposta->getVlRun();
            $this->dao->pc23_validmin = null
            $this->dao->pc23_percentualdesconto = $proposta->getPercentualDesconto();
            $this->dao->pc23_perctaxadesctabela = $proposta->getPercentualTaxa();
    }


}