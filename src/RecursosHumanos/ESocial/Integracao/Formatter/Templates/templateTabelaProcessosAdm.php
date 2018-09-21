<?php
return array(
    'infoProcesso' => array(
        'properties' => array(
            'tpProc' => array (
                'tpProc' => 'tpProc',
                'type' => 'int'
            ),
            'nrProc' => array(
                'nrProc' => 'nrProc',
                'type' => 'int'
            ),
            'iniValid' => 'iniValid',
            'fimValid' => 'fimValid'
        ),
        'dadosProc' => array(
            'properties' => array(
                'indAutoria' => array(
                    'indAutoria' => 'indAutoria',
                    'type' => 'int'
                ),
                'indMatProc' => array(
                    'indMatProc' => 'indMatProc',
                    'type' => 'int'
                ),
                'observacao' => 'observacao'
            )
        ),
        'dadosProcJud' => array(
            'properties' => array(
                'ufVara' => 'ufVara',
                'codMunic' => 'codMunic',
                'idVara' => 'idVara'
            )
        ),
        'infoSusp' => array(
            'properties' => array(
                'codSusp' => 'codSusp',
                'indSusp' => array(
                    'indSusp' => 'indSusp',
                    'type' => 'int'
                ),
                'dtDecisao' => 'dtDecisao',
                'indDeposito' => 'indDeposito'
            )
        )
    ),


);