<?php
return array(
    'ideTrabalhador' => array(
        'properties' => array(
            'cpfTrab' => 'cpfTrab'
        )
    ),
    'alteracao' => array(
        'properties' => array(
            'dtAlteracao' => 'dtAlteracao'
        )
    ),
    'dadosTrabalhador' => array(
        'properties' => array(
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
            'nmSoc' => 'nmSoc',
            'paisNac' => 'paisNac'
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
    'exterior' => array(
        'properties' => array(
            'paisResid' => 'paisResid',
            'dscLograd' => 'dscLograd',
            'nrLograd' => 'nrLograd',
            'complemento' => 'complemento',
            'bairro' => 'bairro',
            'nmCid' => 'nmCid',
            'codPostal' => 'codPostal'
        )
    ),
    'trabImig' => array(
        'properties' => array(
            'tmpResid' => 'tmpResid',
            'condIng' => 'condIng'
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
            'infoCota' => 'infoCota',
            'observacao' => 'observacao'
        )
    ),
    'dependente' => array(
        'properties' => array(
            'tpdep' => 'tpdep',
            'nmdep' => 'nmdep',
            'dtnascto' => 'dtnascto',
            'cpfdep' => 'cpfdep',
            'sexoDep' => 'sexoDep',
            'depirrf' => 'depirrf',
            'depsf' => 'depsf',
            'inctrab' => 'inctrab'
        )
    ),
    'contato' => array(
        'properties' => array(
            'fonePrinc' => 'fonePrinc',
            'foneAlternat' => 'foneAlternat',
            'emailPrinc' => 'emailPrinc',
            'emailAlternat' => 'emailAlternat'
        )
    )
);
