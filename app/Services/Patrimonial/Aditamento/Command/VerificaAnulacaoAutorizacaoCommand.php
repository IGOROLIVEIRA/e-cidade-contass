<?php
namespace App\Services\Patrimonial\Aditamento\Command;

use App\Models\AcordoPosicao;
use App\Repositories\Contracts\Patrimonial\AcordoItemExecutadoRepositoryInterface;
use App\Repositories\Patrimonial\AcordoItemExecutadoRepository;

class VerificaAnulacaoAutorizacaoCommand
{
    /**
     * @param AcordoPosicao $acordoPosicao
     * @return boolean
     */
    public function execute(AcordoPosicao $acordoPosicao): bool
    {
        $validador = false;
        $repository = new AcordoItemExecutadoRepository();
        $itens =  $acordoPosicao->itens;

        $itens->each(function($item, $key) use($repository, &$validador) {
            $collection = $repository->buscaItensExecutado($item->ac20_sequencial);

            if (empty($collection)) return false;

            $result = $collection->filter(function ($value, $key) {
                return $value->ac29_valor < 0;
            });

            if ($result->count() > 0) {
                $validador = true;
                return false;
            }
        });

        return $validador;
    }
}
