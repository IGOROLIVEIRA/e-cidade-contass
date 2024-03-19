<?php

namespace App\Domain\Patrimonial\Aditamento\Factory;

use App\Domain\Patrimonial\Aditamento\ItemDotacao;
use stdClass;

class ItemDotacaoFactory
{
    /**
     * Undocumented function
     *
     * @param stdClass $dotacaoRaw
     * @param integer|null $acordoItem
     * @return ItemDotacao
     */
    public function createByStdLegacy(stdClass $dotacaoRaw): ItemDotacao
    {
        $itemDotacao = new ItemDotacao(
            $dotacaoRaw->dotacao,
            db_getsession("DB_anousu"),db_getsession("DB_instit"),
            $dotacaoRaw->valor,
            $dotacaoRaw->quantidade
        );

        return $itemDotacao;
    }

    /**
     * Undocumented function
     *
     * @param array $itensDotacoes
     * @param integer $acordoItem
     * @return array
     */
    public function createlistByStdLegacy(array $itensDotacoes): array
    {
        $lista = [];

        foreach ($itensDotacoes as $itemDotacao) {
            $lista[] = $this->createByStdLegacy($itemDotacao);
        }

        return $lista;
    }
}

