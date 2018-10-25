<?php
return array(
    'ideRubrica' => array(
        'properties' => array(
            'codRubr' => 'codRubr',
            'ideTabRubr' => array(
                'ideTabRubr' => 'ideTabRubr',
                'type' => 'string'),
            'iniValid' => 'iniValid',
            'fimValid' => 'fimValid'
        )
    ),
    'dadosRubrica' => array(
        'properties' => array(
            'dscRubr' => 'dscRubr',
            'natRubr' => array(
                'natRubr' => 'natRubr', 
                'type' => 'int'),
            'tpRubr' => array(
                'tpRubr' => 'tpRubr',
                'type' => 'int'
            ),
            'codIncCP' => array(
                'codIncCP' => 'codIncCP',
                'type' => 'string'
            ),
            'codIncIRRF' => array (
                'codIncIRRF' => 'codIncIRRF',
                'type' => 'string'
            ),
            'codIncFGTS' => array (
                'codIncFGTS' => 'codIncFGTS',
                'type' => 'string'
            ),
            'codIncSIND' => array (
                'codIncSIND' => 'codIncSIND',
                'type' => 'string'
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