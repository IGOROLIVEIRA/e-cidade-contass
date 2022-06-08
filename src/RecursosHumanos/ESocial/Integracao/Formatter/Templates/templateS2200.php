<?php
return array(
    'trabalhador' => array(
        'properties' => array(
            'cpfTrab' => 'cpfTrab',
            'nisTrab' => 'nisTrab',
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
            'indPriEmpr' => 'indPriEmpr',
            'nmSoc' => 'nmSoc'
        )
    ),
    'nascimento' => array(
        'properties' => array(
            'dtNascto' => 'dtNascto',
            'codMunic' => 'codMunic',
            'paisNascto' => 'paisNascto',
            'paisNac' => 'paisNac',
            'nmMae' => 'nmMae',
            'nmPai' => 'nmPai'
        )
    ),
    'CTPS' => array(
        'properties' => array(
            'nrCtps' => 'nrCtps',
            'serieCtps' => 'serieCtps',
            'ufCtps' => 'ufCtps'
        )
    ),
    'RIC' => array(
        'properties' => array(
            'nrRic' => 'nrRic',
            'orgaoEmissor' => 'orgaoEmissor',
            'dtExped' => 'dtExped'
        )
    ),
    'RG' => array(
        'properties' => array(
            'nrRg' => 'nrRg',
            'orgaoEmissor' => 'orgaoEmissor',
            'dtExped' => 'dtExped'
        )
    ),
    'RNE' => array(
        'properties' => array(
            'nrRne' => 'nrRne',
            'orgaoEmissor' => 'orgaoEmissor',
            'dtExped' => 'dtExped'
        )
    ),
    'OC' => array(
        'properties' => array(
            'nrOc' => 'nrOc',
            'orgaoEmissor' => 'orgaoEmissor',
            'dtExped' => 'dtExped',
            'dtValid' => 'dtValid'
        )
    ),
    'CNH' => array(
        'properties' => array(
            'nrRegCnh' => 'nrRegCnh',
            'dtExped' => 'dtExped',
            'ufCnh' => 'ufCnh',
            'dtValid' => 'dtValid',
            'dtPriHab' => 'dtPriHab',
            'categoriaCnh' => 'categoriaCnh'
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
    'trabEstrangeiro' => array(
        'properties' => array(
            'dtChegada' => 'dtChegada',
            'classTrabEstrang' => array(
                'classTrabEstrang' => 'classTrabEstrang',
                'type' => 'int'
            ),
            'casadoBr' => 'casadoBr',
            'filhosBr' => 'filhosBr'
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
            'depirrf' => 'depirrf',
            'depsf' => 'depsf',
            'inctrab' => 'inctrab'
        )
    ),
    'aposentadoria' => array(
        'properties' => array(
            'trabAposent' => 'trabAposent'
        )
    ),
    'contato' => array(
        'properties' => array(
            'fonePrinc' => 'fonePrinc',
            'foneAlternat' => 'foneAlternat',
            'emailPrinc' => 'emailPrinc',
            'emailAlternat' => 'emailAlternat'
        )
    ),
    'vinculo' => array(
        'properties' => array(
            'matricula' => 'matricula',
            'tpRegTrab' => array(
                'tpRegTrab' => 'tpRegTrab',
                'type' => 'int'
            ),
            'tpRegPrev' => array(
                'tpRegPrev' => 'tpRegPrev',
                'type' => 'int'
            ),
            'nrRecInfPrelim' => 'nrRecInfPrelim',
            'cadIni' => 'cadIni'
        )
    ),
    'infoCeletista' => array(
        'properties' => array(
            'infoCeletista' => 'infoCeletista',
            'dtAdm' => 'dtAdm',
            'tpAdmissao' => array(
                'tpAdmissao' => 'tpAdmissao',
                'type' => 'int'
            ),
            'indAdmissao' => array(
                'indAdmissao' => 'indAdmissao',
                'type' => 'int'
            ),
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
    'FGTS' => array(
        'properties' => array(
            'opcFGTS' => array(
                'opcFGTS' => 'opcFGTS',
                'type' => 'int'
            ),
            'dtOpcFGTS' => 'dtOpcFGTS'
        )
    ),
    'trabTemporario' => array(
        'properties' => array(
            'hipLeg' => array(
                'hipLeg' => 'hipLeg',
                'type' => 'int'
            ),
            'justContr' => 'justContr',
            'tpInclContr' => array(
                'tpInclContr' => 'tpInclContr',
                'type' => 'int'
            )

        )
    ),
    'ideTomadorServ' => array(
        'properties' => array(
            'tpInsc' => array(
                'tpInsc' => 'tpInsc',
                'type' => 'int'
            ),
            'nrInsc' => 'nrInsc'
        )
    ),
    'ideEstabVinc' => array(
        'properties' => array(
            'tpInsc' => array(
                'tpInsc' => 'tpInsc',
                'type' => 'int'
            ),
            'nrInsc' => 'nrInsc'
        )
    ),
    'ideTrabSubstituido' => array(
        'properties' => array(
            'cpfTrabSubst' => 'cpfTrabSubst'
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
            'tpProv' => 'tpProv',
            'dtExercicio' => 'dtExercicio',
            'tpPlanRP' => 'tpPlanRP',
            'indTetoRGPS' => 'indTetoRGPS',
            'indAbonoPerm' => 'indAbonoPerm',
        )
    ),
    'infoContrato' => array(
        'properties' => array(
            'nmCargo' => 'nmCargo',
            'CBOCargo' => 'cbocargo',
            'dtIngrcargo' => 'dtIngrcargo',
            'nmFuncao' => 'nmFuncao',
            'CBOFuncao' => 'cbofuncao',
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
            'clauAssec' => 'clauAssec',
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
        'dscTpJorn' => 'dscTpJorn',
        'tmpParc' => array(
            'tmpParc' => 'tmpParc',
            'type' => 'int'
        )

    ),
    'horario' => array(
        'properties' => array(
            'dia' => array(
                'dia' => 'dia',
                'type' => 'int'
            ),
            'codHorContrat' => 'codHorContrat'
        )
    ),
    'filiacaoSindical' => array(
        'properties' => array(
            'cnpjSindTrab' => 'cnpjSindTrab'
        )
    ),
    'alvaraJudicial' => array(
        'nrProcJud' => 'nrProcJud'
    ),
    'observacoes' => array(
        'observacao' => 'observacao'
    ),
    'sucessaoVinc' => array(
        'properties' => array(
            'tpInscAnt' => array(
                'tpInscAnt' => 'tpInscAnt',
                'type' => 'int'
            ),
            'cnpjEmpregAnt' => 'cnpjEmpregAnt',
            'matricAnt' => 'matricAnt',
            'dtTransf' => 'dtTransf',
            'observacao' => 'observacao'
        )
    ),
    'transfDom' => array(
        'properties' => array(
            'cpfSubstituido' => 'cpfSubstituido',
            'matricAnt' => 'matricAnt',
            'dtTransf' => 'dtTransf'
        )
    ),
    'mudancaCPF' => array(
        'properties' => array(
            'cpfAnt' => 'cpfAnt',
            'matricAnt' => 'matricAnt',
            'dtAltCPF' => 'dtAltCPF',
            'observacao' => 'observacao'
        )
    ),
    'afastamento' => array(
        'properties' => array(
            'dtIniAfast' => 'dtIniAfast',
            'codMotAfast' => 'codMotAfast'
        )
    ),
    'desligamento' => array(
        'properties' => array(
            'dtDeslig' => 'dtDeslig'
        )
    ),
    'infoProcTrab' => array(
        'properties' => array(
            'nrProcTrab' => 'nrProcTrab'
        )
    )
);
