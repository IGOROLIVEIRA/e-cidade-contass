<?php

namespace App\Repositories\Patrimonial;

use App\Models\AcordoPosicao;
use App\Repositories\Contracts\Patrimonial\AcordoPosicaoRepositoryInterface;


class AcordoPosicaoRepository implements AcordoPosicaoRepositoryInterface
{
    /**
     *
     * @var AcordoPosicao
     */
    private AcordoPosicao $model;

    public function __construct()
    {
        $this->model = new AcordoPosicao();
    }

    /**
     * Undocumented function
     *
     * @param integer $idAcordo
     * @param integer $numeroAditamento
     * @return AcordoPosicao|null
     */
    public function getAcordoPorNumeroAditamento(int $idAcordo, int $numeroAditamento): ?AcordoPosicao
    {
        return $this->model->where('ac26_acordo', $idAcordo)
            ->where('ac26_numeroaditamento', $numeroAditamento)
            ->first();
    }

    /**
     *
     * @param integer $ac26Acordo
     * @return AcordoPosicao
     */
    public function getAditamentoUltimaPosicao(int $ac26Acordo): AcordoPosicao
    {
        $acordoPosicao = $this->model
            ->with(['itens', 'posicaoAditamento', 'acordo'])
            ->where('ac26_acordo', $ac26Acordo)
            ->where('ac26_numeroaditamento','<>', '')
            ->orderBy('ac26_numero', 'desc')
            ->first();

        return $acordoPosicao;
    }
    /**
     *
     * @param integer $ac26Acordo
     * @return AcordoPosicao
     */
    public function getPosicaoInicial(int $ac26Acordo): AcordoPosicao
    {
        $acordoPosicao = $this->model
            ->with(['itens', 'posicaoAditamento', 'acordo'])
            ->where('ac26_acordo', $ac26Acordo)
            ->where('ac26_numero', 1)
            ->orderBy('ac26_numero', 'asc')
            ->first();

        return $acordoPosicao;
    }

    /**
     *
     * @param integer $ac26Acordo
     * @return AcordoPosicao
     */
    public function getAditamentoByNumero(int $ac26Acordo, int $numeroAditamento): AcordoPosicao
    {
        $acordoPosicao = $this->model
            ->with(['itens', 'posicaoAditamento', 'acordo'])
            ->where('ac26_acordo', $ac26Acordo)
            ->where('ac26_numeroaditamento', $numeroAditamento)
            ->orderBy('ac26_numero', 'desc')
            ->first();

        return $acordoPosicao;
    }

    /**
     *
     * @param integer $ac26Acordo
     * @return AcordoPosicao
     */
    public function getAditamentoPosicaoAnterior(int $ac26Acordo, int $sequencial): AcordoPosicao
    {
        $acordoPosicao = $this->model
            ->with(['itens', 'posicaoAditamento', 'acordo'])
            ->where('ac26_acordo', $ac26Acordo)
            ->whereNotNull('ac26_numeroaditamento')
            ->where('ac26_sequencial', '<', $sequencial)
            ->orderBy('ac26_sequencial', 'desc')
            ->first();
        return $acordoPosicao;
    }

    public function getAditamentoByAcordo(int $acordo)
    {
        return $this->model->where('ac26_acordo', $acordo)
        ->whereNotNull('ac26_numeroaditamento')
        ->get();

    }

    public function getQtdAditamentoPorAcordo(int $acordo): int
    {
        $aditamentos = $this->getAditamentoByAcordo($acordo);

        if (empty($aditamentos)) {
            return 0;
        }

        return count($aditamentos->toArray());
    }

    /**
     *
     * @param integer $codigo
     * @param array $dados
     * @return boolean
     */
    public function update(int $codigo, array $dados): bool
    {
        $acordoPosicao = $this->model->find($codigo);

        return $acordoPosicao->update($dados);
    }

    public function getUltimoIdApostilmentoByAcordo(int $acordo): ?int
    {
        $acordoPosicao = $this->model->where('ac26_acordo', $acordo)
            ->where('ac26_numeroapostilamento','<>', '')
            ->orderBy('ac26_numero', 'desc')
            ->first(['ac26_sequencial']);
        return $acordoPosicao->ac26_sequencial;
    }
}
