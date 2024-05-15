<?php
return array(
	'ideTrabalhador' => array(
		'properties' => array(
			'cpfTrab' => 'cpfTrab',
			'nisTrab' => 'nisTrab'
		) 
	),
	'infoMV' => array(
		'properties' => array(
			'indMV' => array(
                'type' => 'int'
            )
		) 
	),
	'remunOutrEmpr' => array(
		'properties' => array(
			'tpInsc' => array(
                'type' => 'int'
            ),
			'nrInsc' => 'nrInsc',
			'codCateg' => array(
                'type' => 'int'
            ),
			'vlrRemunOE' => array(
                'type' => 'float'
            ),
		) 
	),
	'infoComplem' => array(
		'tpInscAnt' => 'nmTrab',
		'dtNascto' => 'dtNascto'
	),
	'sucessaoVinc' => array(
		'tpInscAnt' => array(
                'type' => 'int'
         ),
		'cnpjEmpregAnt' => 'cnpjEmpregAnt',
		'matricAnt' => 'matricAnt',
		'dtAdm' => 'dtAdm',
		'observacao' => 'observacao'
	),
	'procJudTrab' => array(
		'tpTrib' => array(
                'type' => 'int'
         ),
		'nrProcJud' => 'nrProcJud',
		'codSusp' => 'codSusp'
	),
	'infoInterm' => array(
		'qtdDiasInterm' => array(
                'type' => 'int'
         )
	),
	'dmDev' => array(
		'ideDmDev' => 'ideDmDev',
		'codCateg' => array(
                'type' => 'int'
         )
	),
	'ideEstabLot' => array(
		'tpInsc' => array(
                'type' => 'int'
         ),
		'nrInsc' => 'nrInsc',
		'codLotacao' => 'codLotacao',
		'qtdDiasAv' => array(
                'type' => 'int'
         ),
	),
	'remunPerApur' => array(
		'matricula' => 'matricula',
		'indSimples' => array(
                'type' => 'int'
        )
    ),
	'itensRemun' => array(
		'codRubr' => 'codRubr',
		'ideTabRubr' => 'ideTabRubr',
		'qtdRubr' => array(
                'type' => 'float'
         ),
		'fatorRubr' => array(
                'type' => 'float'
         ),
		'vrUnit' => array(
                'type' => 'float'
         ),
		'vrRubr' => array(
                'type' => 'float'
         ),
	),
	'detOper' => array(
		'cnpjOper' => 'cnpjOper',
		'regANS' => 'regANS',
		'vrPgTit' => array(
                'type' => 'float'
         )
	),
	'detPlano' => array(
		'tpDep' => 'tpDep',
		'cpfDep' => 'cpfDep',
		'nmDep' => 'nmDep',
		'dtNascto' => 'dtNascto',
		'vlrPgDep' => array(
                'type' => 'float'
         )
	),
	'infoAgNocivo' => array(
		'grauExp' => array(
                'type' => 'int'
         )
	),
	'infoTrabInterm' => array(
		'codConv' => 'codConv'
	),
	'ideADC' => array(
		'dtAcConv' => 'dtAcConv',
		'tpAcConv' => 'tpAcConv',
		'compAcConv' => 'compAcConv',
		'dtEfAcConv' => 'dtEfAcConv',
		'dtEfAcConv' => 'dtEfAcConv',
		'dsc' => 'dsc',
		'remunSuc' => 'remunSuc',
	),
	'idePeriodo' => array(
		'perRef' => 'perRef'
	),
	'ideEstabLot' => array(
		'tpInsc' => array(
                'type' => 'int'
         ),
		'nrInsc' => 'nrInsc',
		'codLotacao' => 'codLotacao',
	),
	'remunPerAnt' => array(
		'matricula' => 'matricula',
		'indSimples' => array(
                'type' => 'int'
         )
	),
);