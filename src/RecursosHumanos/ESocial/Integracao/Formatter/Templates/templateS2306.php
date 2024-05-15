<?php
return array(
    'ideTrabSemVinculo' => array(
        'properties' => array(
            'cpfTrab' => 'cpfTrab',
            'matricula' => 'matricula',
            'codCateg' => 'codCateg'
        )
    ),
    'infoTSVAlteracao' => array(
        'properties' => array(
            'dtAlteracao' => 'dtAlteracao',
            'natAtividade' => 'natAtividade'
        )
    ),
    'cargoFuncao' => array(
        'properties' => array(
            'nmCargo' => 'nmCargo',
            'CBOCargo' => 'CBOCargo',
            'nmFuncao' => 'nmFuncao',
            'cboFuncao' => 'cboFuncao'
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
    'infoDirigenteSindical' => array(
        'properties' => array(
            'tpRegPrev' => array(
                'tpRegPrev' => 'tpRegPrev',
                'type' => 'int'
            )
        )
    ),
    'infoTrabCedido' => array(
        'properties' => array(
            'tpRegPrev' => array(
                'tpRegPrev' => 'tpRegPrev',
                'type' => 'int'
            )
        )
    ),
    'infoMandElet' => array(
        'properties' => array(
            'indRemunCargo' => 'indRemunCargo',
            'tpRegPrev' => array(
                'tpRegPrev' => 'tpRegPrev',
                'type' => 'int'
            )
        )
    ),
    'infoEstagiario' => array(
        'properties' => array(
            'natEstagio' => 'natEstagio',
            'nivEstagio' => array(
                'nivEstagio' => 'nivEstagio',
                'type' => 'int'
            ),
            'areaAtuacao' => 'areaAtuacao',
            'nrApol' => 'nrApol',
            'dtPrevTerm' => 'dtPrevTerm'
        )
    ),
    'instEnsino' => array(
        'properties' => array(
            'cnpjInstEnsino' => 'cnpjInstEnsino',
            'nmrazao' => 'nmrazao',
            'dscLograd' => 'dscLograd',
            'nrLograd' => 'nrLograd',
            'bairro' => 'bairro',
            'cep' => 'cep',
            'codMunic' => array(
                'codMunic' => 'codMunic',
                'type' => 'string'
            ),
            'uf' => 'uf'
        )
    ),
    'ageIntegracao' => array(
        'properties' => array(
            'cnpjAgntInteg' => 'cnpjAgntInteg'
        )
    ),
    'supervisorEstagio' => array(
        'properties' => array(
            'cpfSupervisor' => 'cpfSupervisor'
        )
    )
);