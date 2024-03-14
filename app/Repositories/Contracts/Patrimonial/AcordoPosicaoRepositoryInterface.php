<?php

namespace App\Repositories\Contracts\Patrimonial;

use App\Models\AcordoPosicao;

interface AcordoPosicaoRepositoryInterface
{
   /**
    *
    * @param integer $idAcordo
    * @param integer $numeroAditamento
    * @return AcordoPosicao|null
    */
    public function getAcordoPorNumeroAditamento(int $idAcordo, int $numeroAditamento): ?AcordoPosicao;
    /**
     *
     * @param integer $ac26Acordo
     * @return AcordoPosicao
     */
    public function getAditamentoUltimaPosicao(int $ac26Acordo): AcordoPosicao;

    /**
     *
     * @param integer $codigo
     * @param array $dados
     * @return void
     */
    public function update(int $codigo, array $dados);

     /**
     *
     * @param integer $ac26Acordo
     * @return AcordoPosicao
     */
    public function getAditamentoByNumero(int $ac26Acordo, int $numeroAditamento): AcordoPosicao;

    /**
     *
     * @param integer $acordo
     * @return integer|null
     */
    public function getUltimoIdApostilmentoByAcordo(int $acordo): ?int;
}
