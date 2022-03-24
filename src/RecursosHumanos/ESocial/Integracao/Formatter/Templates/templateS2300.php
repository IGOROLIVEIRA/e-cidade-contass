<?php
return array(
    'trabalhador' => array(
        'properties' => array(
            'cpfTrab' => 'cpfTrab',
            'nmTrab' => 'nmTrab',
            'sexo' => 'sexo',
            'racaCor' => array(
                'racaCor' => 'racaCor',
                'type' => 'int'
            ),
            'estCiv' => array(
                'estCiv' => 'estCiv',
                'type' => 'int'
            ),
            'grauInstr' => 'grauInstr',
            'nmSoc' => 'nmSoc'
        )
    ),
    'nascimento' => array(
        'properties' => array(
            'dtNascto' => 'dtNascto',
            'paisNascto' => 'paisNascto',
            'paisNac' => 'paisNac',
        )
    ),
    'brasil' => array(
        'properties' => array(
            'tpLograd' => 'tpLograd',
            'dscLograd' => 'dscLograd',
            'nrLograd' => 'nrLograd',
            'complemento' => 'complemento',
            'bairro' => 'bairro',
            'cep' => 'cep',
            'codMunic' => array(
                'codMunic' => 'codMunic',
                'type' => 'string'
            ),
            'uf' => 'uf'
        )
    ),
    'infoDeficiencia' => array(
        'properties' => array(
            'defFisica' => 'defFisica',
            'defVisual' => 'defVisual',
            'defAuditiva' => 'defAuditiva',
            'defMental' => 'defMental',
            'defIntelectual' => 'defIntelectual',
            'reabReadap' => 'reabReadap',
            'observacao' => 'observacao'
        )
    ),
    'contato' => array(
        'properties' => array(
            'fonePrinc' => 'fonePrinc',
            'emailPrinc' => 'emailPrinc'
        )
    ),
    'infoTSVInicio' => array(
        'properties' => array(
            'cadIni' => 'cadIni',
            'matricula' => 'matricula',
            'codCateg' => 'codCateg',
            'dtInicio' => 'dtInicio',
            'nrProcTrab' => 'nrProcTrab',
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
    'FGTS' => array(
        'properties' => array(
            'dtOpcFGTS' => 'dtOpcFGTS'
        )
    ),
    'infoTrabCedido' => array(
        'properties' => array(
            'categOrig' => 'categOrig',
            'cnpjCednt' => 'cnpjCednt',
            'matricCed' => 'matricCed',
            'dtAdmCed' => 'dtAdmCed',
            'tpRegTrab' => array(
                'tpRegTrab' => 'tpRegTrab',
                'type' => 'int'
            ),
            'tpRegPrev' => array(
                'tpRegPrev' => 'tpRegPrev',
                'type' => 'int'
            )
        )
    ),
    'infoMandElet' => array(
        'properties' => array(
            'indRemunCargo' => 'indRemunCargo',
            'tpRegTrab' => array(
                'tpRegTrab' => 'tpRegTrab',
                'type' => 'int'
            ),
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
            'cnpjInstEnsino' => 'cnpjInstEnsino'
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
    ),
    'afastamento' => array(
        'properties' => array(
            'dtIniAfast' => 'dtIniAfast',
            'codMotAfast' => 'codMotAfast'
        )
    ),
    'termino' => array(
        'properties' => array(
            'dtTerm' => 'dtTerm'
        )
    )
);