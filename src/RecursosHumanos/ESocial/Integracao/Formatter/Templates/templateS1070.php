<?php
return array(
    'ideProcesso' => array(
        'properties' => array(
            'tpProc' => array(
                'tpProc' => 'tpProc',
                'type' => 'int'
            ),
            'nrProc' => array(
                'nrProc' => 'nrProc',
                'type' => 'string'
            ),
            'iniValid' => 'iniValid',
            'fimValid' => 'fimValid'
        )
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
            'codSusp' => 'codsusp',
            'indSusp' => 'indsusp',
            'dtDecisao' => 'dtdecisao',
            'indDeposito' => 'inddeposito'
        )
    ),
    'novavalidade' => array(
        'nome_api' => 'novavalidade',
        'properties' => array(
            'inivalid' => array(
                'nome_api' =>  'inivalid',
                'type' => 'string'
            ),
            'fimvalid' => array(
                'nome_api' =>  'fimvalid',
                'type' => 'string'
            ),
        )
    )
);
