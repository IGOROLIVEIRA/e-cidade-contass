<?php
return array(
    'infoCadastro' => array(
        'properties' => array(
            'classTrib'=> array(
                'classTrib' => 'classTrib',
                'type' => 'string'
            ),
            'indCoop' => array(
                'type' => 'int'
            ),
            'indConstr' => array(
                'type' => 'int'
            ),
            'indDesFolha' => array(
                'type' => 'int'
            ),
            'indOpcCP' => array(
                'type' => 'int'
            ),
            'indPorte' => array(
                'type' => 'int'
            ),
            'indOptRegEletron' => array(
                'type' => 'int'
            ),
            'cnpjEFR',
        )
    ),

    'dadosIsencao' => array(
        'properties' => array(
            'ideMinLei' => 'ideMinLei',
            'nrCertif' => 'nrCertif',
            'dtEmisCertif' => 'dtEmisCertif',
            'dtVencCertif' => 'dtVencCertif',
            'nrProtRenov' => 'nrProtRenov',
            'dtProtRenov' => 'dtProtRenov',
            'dtDou' => 'dtDou',
            'pagDou' => array(
                'nome_api'=> 'pagDou',
                'type' => 'int'
            )
        )
    ),
    'infoOrgInternacional' => array(
        'properties' => array(
            'indAcordoIsenMulta' => array(
                'nome_api'=> 'indAcordoIsenMulta',
                'type' => 'int'
            )
        )
    )
);
