<?php
return array(
    'infoRubrica' => array(
        'properties' => array(
            'codRubr' => 'codRubr',
            'ideTabRubr' => 'ideTabRubr',
            'iniValid' => 'iniValid',
            'fimValid' => 'fimValid'
        )
    ),
    'dadosRubrica' => array(
        'properties' => array(
            'dscRubr' => 'dscRubr',
            'natRubr' => 'natRubr',
            'tpRubr' => array(
                'tpRubr' => 'tpRubr',
                'type' => 'int'
            ),
            'codIncCP' => array(
                'codIncCP' => 'codIncCP',
                'type' => 'int'
            ),
            'codIncIRRF' => array (
                'codIncIRRF' => 'codIncIRRF',
                'type' => 'int'
            ),
            'codIncFGTS' => array (
                'codIncFGTS' => 'codIncFGTS',
                'type' => 'int'
            ),
            'codIncSIND' => array (
                'codIncSIND' => 'codIncSIND',
                'type' => 'int'
            ),
            'observacao' => 'observacao')
    ),

    'ideProcessoCP' => array(

        'properties' => array(
            'ideProcessoCP' => 'ideProcessoCP',
            'tpProc' => array (
                'tpProc' => 'tpProc',
                'type' => 'int'
            ),
            'nrProc' => 'nrProc',
            'extDecisao' => array (
                'extDecisao' => 'extDecisao',
                'type' => 'int'
            ),
            'codSusp' => 'codSusp'
        )
    ),
    'ideProcessoIRRF' => array (
        'properties' => array(
            'nrProc' => 'nrProc',
            'codSusp' => 'codSusp'
        )
    ),
    'ideProcessoFGTS' => array (
        'properties' => array (
            'ideProcessoFGTS' => 'ideProcessoFGTS',
            'nrProc' => 'nrProc'
        )
    ),
    'ideProcessoSIND' => array (
        'properties' => array (
            'ideProcessoSIND' => 'ideProcessoSIND'
        )
    )
);