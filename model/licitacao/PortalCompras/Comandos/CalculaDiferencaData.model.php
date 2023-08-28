<?php

class CalculaDiferencaData
{
    /**
     * Calcula diferença entre duas datas
     *
     * @param string $dtInicio
     * @param string $dtTermino
     * @return integer
     */
    public function meses(string $dtInicio, string $dtTermino): int
    {
        $dataInicio  = new DateTime($dtInicio);
        $dataTermino = new DateTime($dtTermino);
        $intervalo = $dataInicio->diff($dataTermino);
        return $intervalo->y * 12 + $intervalo->m;
    }
}
