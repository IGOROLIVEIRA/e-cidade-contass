<?php

require_once("model/licitacao/PortalCompras/Julgamento/Julgamento.model.php");
require_once("classes/db_liclicitaimportarjulgamento_classe.php");
require_once("model/licitacao/PortalCompras/Julgamento/Proposta.model.php");
require_once("model/licitacao/PortalCompras/Julgamento/Item.model.php");
require_once("model/licitacao/PortalCompras/Julgamento/Ranking.model.php");
require_once("classes/db_pcorcam_classe.php");
require_once("classes/db_pcorcamitem_classe.php");
require_once("classes/db_pcorcamitemproc_classe.php");
require_once("classes/db_pcorcamforne_classe.php");
require_once("classes/db_pcorcamval_classe.php");
require_once("classes/db_pcorcamjulg_classe.php");
require_once("classes/db_habilitacaoforn_classe.php");

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
        $clpcorcam = new cl_pcorcam;

        $idJulgamento = $julgamento->getId();
        $numero = $julgamento->getNumero();
        $this->dao->pc20_obs = "ORCAMENTO IMPORTADO -"
            . $idJulgamento
            ." - ". $numero;
        $clpcorcam->pc20_dtate = $julgamento->getDataProposta();
        $clpcorcam->pc20_hrate = $julgamento->getHoraProposta();
        $lotes = $julgamento->getLotes();
        $itens = array_map(fn(Lote $lote) => $lote->getItems(), $lotes);
        $quantidadeItens = count($itens);

        try{
            db_inicio_transacao();

            $clpcorcam->incluir(null);

            $idPcorcam = (int)$clpcorcam->pc20_codorc;

            /** @var Item[] $itens */
            foreach($itens as $item) {
                $propostas = $item->getPropostas();
                $tipoJulgamento = $item->getTipoJulgamento();
                $ranking = $item->getRanking();

                foreach($propostas as $proposta) {
                    $numcgmResource = $this->dao->buscaNumCgm($proposta->getIdFornecedor());
                    $numcgm = (db_utils::fieldsMemory($numcgmResource, 0))->numcgm;

                    $idPcorcamforne   = $this->lidaPcorcamforne($numcgm, $idPcorcam);
                    $idPcorcamitem    = $this->lidaPcorcamitem($idPcorcam);
                    $idPcorcamitemlic = $this->lidaPcorcamitemlic($item->getId(), $idPcorcamitem);
                    $idPcorcamval     = $this->lidaPcorcamval(
                        $proposta,
                        $idPcorcamforne,
                        $idPcorcamitem,
                        $tipoJulgamento
                    );
                    $this->lidaPcorcamjulg(
                        $proposta,
                        $ranking,
                        $idPcorcamitem,
                        $idPcorcamforne
                    );

                    $this->lidaHabilitacaoforn(
                        $numcgm,
                        $idJulgamento,
                    );
                }
            }

            db_fim_transacao(false);

        } catch(Exception $e) {
            db_fim_transacao(true);
            throw new Exception($e->getMessage());
        }
    }


    private function lidaPcorcamforne(string $numcgm, int $idPcorcam): int
    {
        $clpcorcamforne             = new cl_pcorcamforne;
        $clpcorcamforne->pc21_codorc     = $idPcorcam;
        $clpcorcamforne->pc21_numcgm     = $numcgm;
        $clpcorcamforne->pc21_importado  = true;
        $clpcorcamforne->pc21_prazoent   = null;
        $clpcorcamforne->pc21_validadorc = null;
        $clpcorcamforne->incluir(null);

        if ($clpcorcamforne->erro_status == 0) {
            throw new Exception($clpcorcamforne->erro_msg);
        }

        return (int)$clpcorcamforne->pc21_orcamforne;
    }

    private function lidaPcorcamitem(int $idPcorcam): int
    {
        $clpcorcamitem              = new cl_pcorcamitem;
        $clpcorcamitem->pc22_codorc = $idPcorcam;
		$clpcorcamitem->incluir(null);

        if ($clpcorcamitem->erro_status == 0 ) {
            throw new Exception($clpcorcamitem->erro_msg);
        }

        return $clpcorcamitem->pc22_orcamitem;
    }

    private function lidaPcorcamitemlic(int $id, int $idPcorcamitem ): int
    {
        $clpcorcamitemlic                  = new cl_pcorcamitemlic;
        $clpcorcamitemlic->pc26_liclicitem = $this->dao->buscaL21codigo(
            $id
        );

        $clpcorcamitemlic->pc26_orcamitem  = $idPcorcamitem;
        $clpcorcamitemlic->incluir(null);

        if ($clpcorcamitemlic->erro_status == 0 ) {
            throw new Exception($clpcorcamitemlic->erro_msg);
        }

        return (int)$clpcorcamitemlic->pc26_liclicitem;
    }

    private function lidaPcorcamval(Proposta $proposta, int $idOrcamforne, int $idOrcamitem, int $tipoJulgamento )
    {
        $clpcorcamval                          = new cl_pcorcamval;
        $clpcorcamval->pc23_valor              = $proposta->getValorTotal();
        $clpcorcamval->pc23_quant              = $proposta->getQuantidade();
        $clpcorcamval->pc23_obs                = $proposta->getMarca();
        $clpcorcamval->pc23_vlrun              = $proposta->getValorUnitario();
        $clpcorcamval->pc23_validmin           = null;
        $clpcorcamval->pc23_perctaxadesctabela = null;
        $clpcorcamval->pc23_percentualdesconto = $tipoJulgamento == 1 ? $proposta->getValorDesconto()
            : null;

        $clpcorcamval->incluir($idOrcamforne, $idOrcamitem);

        if ($clpcorcamval->erro_status == 0 ) {
            throw new Exception($clpcorcamval->erro_msg);
        }

    }

    private function lidaPcorcamjulg(Proposta $proposta, Array $ranking, int $idPcorcamitem, int $idPcorcamforne): void
    {
        $cnpj            = $proposta->getIdFornecedor();
        $posicaoFiltrada = array_filter($ranking, function(Ranking $posicao) use($cnpj) {
            return $posicao->getIdFornecedor() == $cnpj;
        });

        $clpcorcamjulg                  = new cl_pcorcamjulg;
        $clpcorcamjulg->pc24_pontuacao  = $posicaoFiltrada;

        $clpcorcamjulg->incluir($idPcorcamitem, $idPcorcamforne);

        if ($clpcorcamjulg->erro_status == 0 ) {
            throw new Exception($clpcorcamjulg->erro_msg);
        }
    }

    private function lidaHabilitacaoforn(
        string $numcgm,
        int $idJulgamento
    ): void {
        $clhabilitacaoforn = new cl_habilitacaoforn;
        $clhabilitacaoforn->l206_fornecedor        = $numcgm;
        $clhabilitacaoforn->l206_licitacao        = $idJulgamento;
        $clhabilitacaoforn->l206_representante    = "teste";
        $clhabilitacaoforn->l206_datahab          = "21-12-2021";
        $clhabilitacaoforn->l206_numcertidaoinss  = null;
        $clhabilitacaoforn->l206_dataemissaoinss  = null;
        $clhabilitacaoforn->l206_datavalidadeinss = null;
        $clhabilitacaoforn->l206_numcertidaofgts  = null;
        $clhabilitacaoforn->l206_dataemissaofgts  = null;
        $clhabilitacaoforn->l206_datavalidadefgts = null;
        $clhabilitacaoforn->l206_numcertidaocndt  = null;
        $clhabilitacaoforn->l206_dataemissaocndt  = null;
        $clhabilitacaoforn->l206_datavalidadecndt = null;

        $$clhabilitacaoforn->incluir(null);

        if ($clhabilitacaoforn->erro_status == 0 ) {
            throw new Exception($clhabilitacaoforn->erro_msg);
        }

    }

    private function lidaLiclicitasituacao(int $idJulgamento): void
    {
        $clliclicitasituacao   = new cl_liclicitasituacao;
        $clliclicitasituacao->l11_data        = date("Y-m-d", db_getsession("DB_datausu"));
        $clliclicitasituacao->l11_hora        = db_hora();
        $clliclicitasituacao->l11_obs         = "Julgamento importado plataforma eletrônica";
        $clliclicitasituacao->l11_licsituacao = 13;
        $clliclicitasituacao->l11_id_usuario  = db_getsession("DB_id_usuario");
        $clliclicitasituacao->l11_liclicita   = $idJulgamento;
        $clliclicitasituacao->incluir(null);

    }
}