<?php
return array(
    'ideVinculo' => array(
        'properties' => array(
            'cpfTrab' => 'cpfTrab',
            'matricula' => 'matricula',
            'codCateg' => 'codCateg',
        )
    ),
    'iniAfastamento' => array(
        'properties' => array(
            'dtIniAfast' => 'dtIniAfast',
            'codMotAfast' => 'codMotAfast',
            'infomesmomtv' => 'infomesmomtv',
            'tpacidtransito' => 'tpacidtransito',
            'observacao' => 'observacao',
            'perAquis' => array(
                'dtInicio' => 'dtInicio',
                'dtFim' => 'dtFim'
            )
        )
    ),
    'perAquis' => array(
        'properties' => array(
            'dtInicio' => 'dtInicio',
            'dtFim' => 'dtFim'
        )
    ),
    'fimAfastamento' => array(
        'properties' => array(
            'dtTermAfast' => 'dtTermAfast'
        )
    )
    
);
