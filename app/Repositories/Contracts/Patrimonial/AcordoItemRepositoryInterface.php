<?php

namespace App\Repositories\Contracts\Patrimonial;

use App\Domain\Patrimonial\Aditamento\Item;
use App\Models\AcordoItem;

interface AcordoItemRepositoryInterface
{
   /**
    *
    * @param integer $pcMater
    * @param integer $posicao
    * @param array $dados
    * @return boolean
    */
    public function updateByPcmaterAndPosicao(int $pcMater,int $posicao, array $dados): bool;

    public function getItemByPcmaterAndPosicao(int $pcMater,int $posicao): ?AcordoItem;


    public function saveByItemAditamento(Item $item, int $sequencialAcordoPosicao): ?AcordoItem;

}
