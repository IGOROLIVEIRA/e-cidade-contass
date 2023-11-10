<?php
namespace App\Domain\Core\Base\Repository\Contracts;

use App\Domain\Core\Base\Model\BaseModel;

interface BaseFindReporitory extends BaseRepository
{
    /**
     * @return BaseModel
     * @throws Exception
     */
    public function find($id);
}
