<?php
return array(
    'dadosEstab' => array(
        'nome_api' => 'dadosEstab',
        'properties' => array(
            'cnaePrep' => array(
                        'nome_api'=>'cnaePrep',
                        'type' => 'int'
                    )
        ),
        'groups' => array (
            'aliqGilrat' => array(
                'nome_api' => 'aliqGilrat',
                'properties' => array(
                    'aliqRat' => array(
                        'nome_api'=>'aliqRat',
                        'type' => 'integer'
                    ),
                    'fap' => array(
                        'nome_api'=>'fap',
                        'type' => 'float'
                    ),
                ),
                'groups' =>array (
                    'procAdmJudRat' => array (
                        'properties' => array(
                            'tpProc' => array(
                                'nome_api'=> 'tpProc',
                                'type' => 'int'
                            ),
                            'nrProc' => 'nrProc',
                            'codSusp' => 'codSusp'
                        )
                    ),
                    'procAdmJudFap' => array (
                        'properties' => array(
                            'tpProc' => array(
                                'nome_api'=> 'tpProc',
                                'type' => 'int'
                            ),
                            'nrProc' => 'nrProc',
                            'codSusp' => 'codSusp'
                        )
                    )
                )
            ),
            'infoCaepf' => array (
                'nome_api' => 'infoCaepf',
                'properties' => array(
                    'tpCaepf' => array(
                        'nome_api'=> 'tpCaepf',
                        'type' => 'int'
                    ),
                )
            ),
            'infoObra' => array (
                'nome_api' => 'infoObra',
                'properties' => array(
                    'indSubstPatrObra' => array(
                        'nome_api'=>  'indSubstPatrObra',
                        'type' => 'int'
                    )
                )
            ),
            'infoTrab' => array (
                'nome_api' => 'infoTrab',
                'groups' => array(
                    'infoApr' => array (
                        'nome_api' => 'infoApr',
                        'properties' => array(
                            'nrProcJud',
                        ),
                        'groups' => array(
                            'infoEntEduc' => array (
                                'type' => 'array',
                                'nome_api' => 'infoEntEduc',
                                'items' => array(
                                    'properties' => array(
                                        'nrInsc' => array(
                                            'nome_api'=>  'nrInsc',
                                            'type' => 'int'

                                        ),
                                    )
                                )
                            ),
                        )
                    ),
                    'infoPCD' => array (
                        'nome_api' => 'infoPDC',
                        'properties' => array(
                            'contPCD' => array(
                                'nome_api'=>  'contPCD',
                                'type' => 'int'
                            ),
                            'nrProcJud' => 'nrProcJud'
                        )
                    )
                )
            ),
        )
    ),
    'novavalidade' => array (
        'nome_api' => 'novavalidade',
        'properties' => array(
            'inivalid' => array(
                'nome_api'=>  'inivalid',
                'type' => 'string'
            ),
            'fimvalid' => array(
                'nome_api'=>  'fimvalid',
                'type' => 'string'
            ),
        )
    )
);
