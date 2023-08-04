<?php

class LigadorClasses
{
    /**
     * Retorna lista com bind de fabrica e codigo da modalidade tribunal
     *
     * @return array
     */
    public static function listaBindModalidades(): array
    {
        return [
            '53' => 'PregaoFabrica',
            '52' => 'PregaoFabrica',
            '101' => 'DispensaFabrica',
            '50' => 'ConcorrenciaFabrica'
       ];
    }
}
