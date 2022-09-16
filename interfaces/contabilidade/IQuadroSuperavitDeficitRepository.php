<?php
/**
 * @author widouglas
 */
interface IQuadroSuperavitDeficitRepository
{
    /**
     * @param string $sFonte
     * @return float
     */
    public function pegarValorPorFonte($sFonte);
    /**
     * Devolve array de valores por fonte
     *
     * @return array
     */
    public function pegarArrayValoresPelaFonte();

    /**
     * @return int
     */
    public function pegarNumeroRegistros();
}
