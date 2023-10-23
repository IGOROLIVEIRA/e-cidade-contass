<?php

namespace App\Services\Patrimonial\Aditamento\Command;

use App\Domain\Patrimonial\Aditamento\Aditamento;
use App\Services\Contracts\Patrimonial\Aditamento\UpdateAditamentoInterfaceCommand;
use Illuminate\Support\Facades\DB;

class UpdateAditamentoCommand implements UpdateAditamentoInterfaceCommand
{

    public function __construct()
    {
        
    }

    public function execute(Aditamento $aditamento)
    {
        try {
            DB::beginTransaction();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

        }

    }

}
