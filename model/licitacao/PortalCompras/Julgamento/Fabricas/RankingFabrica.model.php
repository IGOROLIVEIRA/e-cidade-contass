<?php

class RankingFabrica
{
    /**
     * Criar Ranking
     *
     * @param array $posicao
     * @return Ranking
     */
    public function criar(array $posicao): Ranking
    {
        $ranking = new Ranking();
        $ranking->setIdFornecedor($posicao['IdFornecedor'])
        ->setPosicao($posicao['Posicao']);

        return $ranking;
    }

    /**
     * Criar lista de Ranking
     *
     * @param array $ranking
     * @return array
     */
    public function criarLista(array $ranking): array
    {
        $rankingLista = [];
        foreach ($ranking as $posicao) {
            $rankingLista[] = $this->criar($posicao);
        }

        return $rankingLista;
    }

}
