<?php
namespace App\Domain\Core\Base\Repository\Contracts;

use App\Domain\Core\Base\Model\BaseModel;
use Exception;

interface BaseDestroyRepository
{
    /**
     * @param BaseModel $model
     * @throws Exception
     */
    public function destroy(BaseModel $model);
}
