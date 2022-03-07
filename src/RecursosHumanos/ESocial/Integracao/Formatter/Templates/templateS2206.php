<?php
return array(
    'ideVinculo' => array(
        'properties' => array(
            'cpfTrab' => 'cpfTrab',
            'matricula' => 'matricula'
        )
    ),
    'altContratual' => array(
        'properties' => array(
            'dtAlteracao' => 'dtAlteracao',
            'dtEf' => 'dtEf',
            'dscAlt' => 'dscAlt'
        )
    ),
    'vinculo' => array(
        'properties' => array(
            'tpRegPrev' => 'tpRegPrev'
        )
    ),
    'infoCeletista' => array(
        'properties' => array(
            'infoCeletista' => 'infoCeletista',
            'tpRegJor' => array(
                'tpRegJor' => 'tpRegJor',
                'type' => 'int'
            ),
            'natAtividade' => array(
                'natAtividade' => 'natAtividade',
                'type' => 'int'
            ),
            'dtBase' => 'dtBase',
            'cnpjSindCategProf' => 'cnpjsindcategprof'
        )
    ),
    'trabTemp' => array(
        'properties' => array(
            'justContr' => 'justContr'
        )
    ),
    'aprend' => array(
        'properties' => array(
            'tpInsc' => array(
                'tpInsc' => 'tpInsc',
                'type' => 'int'
            ),
            'nrInsc' => 'nrInsc'
        )
    ),
    'infoEstatutario' => array(
        'properties' => array(
            'tpPlanRP' => 'tpPlanRP',
            'indTetoRGPS' => 'indTetoRGPS',
            'indAbonoPerm' => 'indAbonoPerm'
        )
    ),
    'infoContrato' => array(
        'properties' => array(
            'nmCargo' => 'nmCargo',
            'cboCargo' => 'cboCargo',
            'nmFuncao' => 'nmFuncao',
            'cboFuncao' => 'cboFuncao',
            'acumCargo' => 'acumCargo',
            'codCateg' => array(
                'codCateg' => 'codCateg',
                'type' => 'int'
            ),
        )
    ),
    'remuneracao' => array(
        'properties' => array(
            'vrSalFx' => array(
                'vrSalFx' => 'vrsalfx',
                'type' => 'float'
            ),
            'undSalFixo' => array(
                'undSalFixo' => 'undSalFixo',
                'type' => 'int'
            ),
            'dscSalVar' => 'dscSalVar'
        )
    ),
    'duracao' => array(
        'properties' => array(
            'tpContr' => array(
                'tpContr' => 'tpContr',
                'type' => 'int'
            ),
            'dtTerm' => 'dtTerm',
            'objDet' => 'objDet'
        )
    ),
    'localTrabGeral' => array(
        'properties' => array(
            'tpInsc' => array(
                'tpInsc' => 'tpInsc',
                'type' => 'string'
            ),
            'nrInsc' => 'nrInsc',
            'descComp' => 'descComp'
        )
    ),
    'localTrabDom' => array(
        'nome_api' => 'localtempdom',
        'properties' => array(
            'tpLograd' => 'tpLograd',
            'dscLograd' => 'dscLograd',
            'nrLograd' => 'nrLograd',
            'complemento' => 'complemento',
            'bairro' => 'bairro',
            'cep' => 'cep',
            'codMunic' => 'codMunic',
            'uf' => 'uf'
        )
    ),
    'horContratual' => array(
        'qtdHrsSem' => array(
            'qtdHrsSem' => 'qtdHrsSem',
            'type' => 'float'
        ),
        'tpJornada' => array(
            'tpJornada' => 'tpJornada',
            'type' => 'int'
        ),
        'tmpParc' => array(
            'tmpParc' => 'tmpParc',
            'type' => 'int'
        ),
        'horNoturno ' => 'horNoturno',
        'dscTpJorn' => 'dscTpJorn'

    ),
    'alvaraJudicial' => array(
        'nrProcJud' => 'nrProcJud'
    ),
    'observacoes' => array(
        'observacao' => 'observacao'
    ),
    'treiCap' => array(
        'properties' => array(
            'codTreiCap' => 'codTreiCap'
        )
    )
);
