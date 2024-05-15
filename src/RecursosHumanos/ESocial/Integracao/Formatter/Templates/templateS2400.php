<?php
return array(
    'beneficiario' => array(
        'properties' => array(
            'cpfBenef' => 'cpfBenef',
            'nmBenefic' => 'nmBenefic',
            'dtNascto' => 'dtNascto',
            'dtInicio' => 'dtInicio',
            'sexo' => 'sexo',
            'racaCor' => array(
                'racaCor' => 'racaCor',
                'type' => 'int'
            ),
            'estCiv' => array(
                'estCiv' => 'estCiv',
                'type' => 'int'
            ),
            'incFisMen' => 'incFisMen',
            'dtIncFisMen' => 'dtIncFisMen'
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
            'nmCid' => 'nmCid',
            'codMunic' => 'codMunic',
            'uf' => 'uf'
        )
    ),
    'exterior' => array(
        'properties' => array(
            'paisResid' => 'paisResid',
            'dscLograd' => 'dscLograd',
            'nrLograd' => 'nrLograd',
            'complemento' => 'complemento',
            'bairro' => 'bairro',
            'cep' => 'cep',
            'codMunic' => 'codMunic',
            'uf' => 'uf'
        )
    ),
);