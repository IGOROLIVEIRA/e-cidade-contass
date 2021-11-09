<?php
return array(
    'ideLotacao' => array(
        'properties' => array(
            'codLotacao' => 'codLotacao',
            'iniValid' => 'iniValid',
            'fimValid' => 'fimValid'
        )
    ),
    'dadosLotacao' => array(
        'properties' => array(
            'tpLotacao' => 'tpLotacao',
            'tpInsc' => array (
                'tpInsc' => 'tpInsc',
                'type' => 'int'
            ),
            'nrInsc' => 'nrInsc'
        )
    ),
    'fpasLotacao' => array(
        'properties' => array(
            'fpas' => array(
                'fpas' => 'fpas',
                'type' => 'int'
                ),
            'codTercs' => 'codTercs',
            'codTercsSusp' => 'codTercsSusp',
        )
    ),
    'infoProcJudTerceiros' => array(
        'properties' => array(
            'codTerc' => 'codTerc',
            'nrProcJud' => 'nrProcJud',
            'codSusp' => 'codSusp',
        ),
        'infoEmprParcial'=> array(
            'properties' => array(
                'tpInscContrat' => array(
                    'tpInscContrat' => 'tpInscContrat',
                    'type' => 'int'
                ),
                'nrInscContrat' => 'nrInscContrat',
                'tpInscProp' => array(
                    'tpInscProp' => 'tpInscProp',
                    'type' => 'int'
                ),
                'nrInscProp' => 'nrInscProp',
            )
        )
    )
);