<?php

namespace App\Services\Tributario\Arrecadacao;

use App\Models\Arrecad;
use App\Models\Recibopaga;

class ExtractNumprePaymentReturnService
{
    public const NUMPRE_POSITION = 37;

    public function execute(string $line): array
    {
        $numpre = $this->getFormatedNumpre($line);
        $found = $this->searchInRecibopaga($line);

        if ($found) {
            return ['numpre' => $found->k00_numnov, 'numpar' => '000'];
        }

        $found = $this->searchInArrecad($numpre);

        if ($found) {
            return ['numpre' => $found->k00_numpre, 'numpar' => $found->k00_numpar];
        }

        return [
            'numpre' => str_pad((int)substr($line, self::NUMPRE_POSITION, 8), 8, '0', STR_PAD_LEFT),
            'numpar' => '000'
        ];
    }

    private function getFormatedNumpre(string $line): string
    {
        return str_pad((int)substr($line, self::NUMPRE_POSITION, 8), 8, '0', STR_PAD_LEFT);
    }

    private function searchInRecibopaga(string $line)
    {
        for ($i = 8; $i > 0; $i--) {
            $numpre = (int)str_replace(' ', '', substr($line, self::NUMPRE_POSITION, $i));
            $recibopaga = $this->getByNumnov($numpre);
            if ($recibopaga && $recibopaga->exists()) {
                return $recibopaga;
            }
        }

        return null;
    }

    private function getByNumnov(int $numpre)
    {
        return Recibopaga::query()->where('k00_numnov', $numpre)->first();
    }

    private function searchInArrecad(string $formatedNumpre)
    {
        $numpre = (int)substr($formatedNumpre, 0, strlen($formatedNumpre) - 1);
        $numpar = (int)substr($formatedNumpre, -1, 1);
        return $this->getByNumpreNumpar($numpre, $numpar);
    }

    private function getByNumpreNumpar(int $numpre, int $numpar)
    {
        $query = Arrecad::query()->where('k00_numpre', $numpre);
        if($numpar > 0) {
            $query->where('k00_numpar', $numpar);
        }
        return $query->first();
    }
}
