<?php
/**
 * @author widouglas
 */
interface IOrcSuplemValRepository
{
    /**
     * @param string $sFonte
     * @param array $aTipoSup
     * @return float
     */
    public function pegarValorSuplementadoPorFonteETipoSup($sFonte, $aTipoSup);

    /**
     * @param array $aTipoSup
     * @return array
     */
    public function pegarArrayValorPelaFonteSuplementadoPorTipoSup($aTipoSup);
}
