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
     * @param integer $acordoItem
     * @return ItemDotacao
     */
    public function createByStdLegacy(stdClass $dotacaoRaw, int $acordoItem): ItemDotacao
    {
        $itemDotacao = new ItemDotacao(
            $dotacaoRaw->dotacao,
            db_getsession("DB_anousu"),db_getsession("DB_instit"),
            $acordoItem,
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
    public function createlistByStdLegacy(array $itensDotacoes, int $acordoItem): array
    {
        $lista = [];

        foreach ($itensDotacoes as $itemDotacao) {
            $lista[] = $this->createlistByStdLegacy($itemDotacao, $acordoItem);
        }

        return $lista;
    }
}

