<?php

use Phinx\Migration\AbstractMigration;

class Oc13410 extends AbstractMigration
{
    public function up()
    {
        $sql = "

        BEGIN;

        CREATE TABLE public.receitas2021 (
            estrut varchar NULL,
            descr varchar(80) NULL,
            finalidade varchar NULL,
            vinc_pcasp varchar NULL,
            fonte varchar NULL,
            instit varchar NULL,
            tipo varchar NULL
        );


        INSERT INTO public.receitas2021 (estrut,descr,finalidade,vinc_pcasp,fonte,instit,tipo)
        VALUES ('413210061010000','JUROS SOBRE O CAPITAL PROPRIO - FONTE 100','Juros sobre o Capital Proprio - Fonte 100','492210000','100','PREFEITURA','INC'),
            ('417180491010000','OUTRAS TRANSFERENCIAS DE RECURSOS DO SUS FONTE 153','Outras Transferencias de Recursos do Sistema Unico de Saude - SUS, nao detalhadas anteriormente - Fonte 153','452130700','153','PREFEITURA','INC'),
            ('417180491020000','OUTRAS TRANSFERENCIAS DE RECURSOS DO SUS FONTE 154','Outras Transferencias de Recursos do Sistema Unico de Saude - SUS, nao detalhadas anteriormente - Fonte 154','452130700','154','PREFEITURA','INC'),
            ('417181111010000','TRANSF. DE REC. SEGURANCA PUBLICA - FUPEN - F. 165','Transferencia de Recursos do Fundo Penitenciario Nacional - Fupen - Fonte 165','452339900','165','PREFEITURA','INC'),
            ('417181131010000','TRANSF. DE REC. DO FNSP - ACORDADAS - FONTE 163','Transferencia de Recursos do Fundo Nacional de Seguranca Publica - FNSP - Acordadas - Fonte 163','452339900','163','PREFEITURA','INC'),
            ('417181191010000','OUTRAS TRANSF. PARA SEGURANCA PUBLICA - FONTE 165','Outras Transferencias para Seguranca Publica - Fonte 165','452339900','165','PREFEITURA','INC'),
            ('424180491010000','OUTRAS TRANSF. DE RECURSOS DO SUS - FONTE 153','Outras Transferencias de Recursos do Sistema Unico de Saude - SUS, nao detalhadas anteriormente - Fonte 153','452339900','153','PREFEITURA','INC'),
            ('424180491020000','OUTRAS TRANSF. DE RECURSOS DO SUS - FONTE 154','Outras Transferencias de Recursos do Sistema Unico de Saude - SUS, nao detalhadas anteriormente - Fonte 154','452339900','154','PREFEITURA','INC'),
            ('417180211020000','COTA-PARTE DA COMP. FINANCEIRA REC HIDRICOS F -165','Cota-parte da Compensacao Financeira de Recursos Hidricos - Fonte 165','452130600','165','PREFEITURA','INC'),
            ('417180231020000','COTA-PARTE ROYALTIES - COMPENSAÇÃO FINANCEIRA -165','Cota-parte Royalties - Compensacao Financeira pela Producao de Petroleo - Lei n 7.990/89 - Fonte 165','452130600','165','PREFEITURA','INC');
        INSERT INTO public.receitas2021 (estrut,descr,finalidade,vinc_pcasp,fonte,instit,tipo)
        VALUES ('417180241020000','COTA-PARTE ROYALTIES PELO EXCEDENTE DA PRODU. 165','Cota-parte Royalties pelo Excedente da Producao do Petroleo - Lei n 9.478/97, artigo 49, I e II - Principal','433112900','165','PREFEITURA','INC'),
            ('417180251020000','COTA-PARTE ROYALTIES PELA PARTICIPACAO ESPECIAL','Cota-parte Royalties pela Participacao Especial - Lei n 9.478/97 artigo 50 - Fonte 165','433112900','165','PREFEITURA','INC'),
            ('417180261020000','COTA-PARTE DO FUNDO ESPECIAL DO PETRÓLEO - FEP 165','Cota-parte Royalties pela Participacao Especial - Lei n 9.478/97 artigo 50 -  Fonte 165','433112900','165','PREFEITURA','INC'),
            ('417180291020000','Outras Transferencias decorrentes de Compensacao','Outras Transferencias decorrentes de Compensacao Financeira pela Exploracao de Recursos Naturais - Principal','433112900','165','PREFEITURA','INC'),
            ('417180391020000','Transferencia de Recursos do SUS - Outros Prog 159','Transferencia de Recursos do SUS - Outros Programas Financiados por Transfereªncias Fundo a Fundo -159','452130700','159','PREFEITURA','INC'),
            ('424189911020000','Outras Transferencias da Uniao - 165','Outras Transferencias da Uniao - 165','452339900','165','PREFEITURA','INC'),
            ('417280211020000','Cota-parte da Compensacao Financeira de Recursos H','Cota-parte da Compensacao Financeira de Recursos Hi­dricos - Fonte 165','452140500','165','PREFEITURA','INC'),
            ('417280231020000','Cota-parte Royalties - Compensacao Financeira pela','Cota-parte Royalties - Compensacao Financeira pela Producao do Petro³leo - Lei n 7.990/89 artigo 9 - Fonte 165','433112900','165','PREFEITURA','INC'),
            ('417280291020000','Outras Transferencias Decorrentes de Compensacoes','Outras Transferencias Decorrentes de Compensacoes Financeiras - Fonte 165','433112900','165','PREFEITURA','INC'),
            ('417389911020000','Outras Transferencias dos Municipios - 165','Outras Transferencias dos Municipios - Fonte 165','452359900','165','PREFEITURA','INC');
        INSERT INTO public.receitas2021 (estrut,descr,finalidade,vinc_pcasp,fonte,instit,tipo)
        VALUES ('417400011020000','Transferencias de Instituicoess Privadas - 165','Transferencias de Instituicoess Privadas - Fonte 165','453110100','165','PREFEITURA','INC'),
            ('417481011050000','Transferencias de Conv. Instituicoes Privadas 165','Transferencias de Convenios Instituicoess Privadas - Fonte 165','453110100','165','PREFEITURA','INC'),
            ('417500011020000','Transferencias de Outras Instituicoes Publicas','Transferencias de Outras Instituicoes Publicas - Fonte 165','452359900','165','PREFEITURA','INC'),
            ('417589911020000','Outras Transferencias Multigovernamentais - 165','Outras Transferencias Multigovernamentais - Fonte 165','454019900','165','PREFEITURA','INC'),
            ('417600011020000','Transferencias do Exterior - Fonte 165','Transferencias do Exterior - Fonte 165','456010000','165','PREFEITURA','INC'),
            ('417780111020000','Transferencias de Pessoas Fisicas - Saude - F 165','Transferencias de Pessoas Fi­sicas - Especificas de E/DF/M - Programas de Saude - Fonte 165','458010000','165','PREFEITURA','INC'),
            ('417780121020000','Transf  Pess.Fisicas-Espec.E/DF/M-Prog.Educ-F:165','Transferencias de Pessoas Fisicas - Especi­ficas de E/DF/M - Programas de Educacao - Fonte 165','458010000','165','PREFEITURA','INC'),
            ('417780191020000','OUTRAS TRANSFERENCIAS DE PESSOAS FISICAS - 165','Outras Transferencias de Pessoas Fisicas - Nao Especificadas Anteriormente - Fonte 165','458010000','165','PREFEITURA','INC'),
            ('413210060000000','JUROS SOBRE O CAPITAL PROPRIO','Juros sobre o Capital Proprio','0','0',NULL,'INC'),
            ('424180391020000','Transferencia de Recursos do SUS - Out. Prog 159','Transfereªncia de Recursos do SUS - Outros Programas Financiados por Transferencias Fundo a Fundo - 165','452339900','159','PREFEITURA','INC');
        INSERT INTO public.receitas2021 (estrut,descr,finalidade,vinc_pcasp,fonte,instit,tipo)
        VALUES ('424189911030000','Outras Transferencias da Uniao - 164','Outras Transferencias da Uniao - 164','452339900','164','PREFEITURA','INC'),
            ('424289911030000','Outras Transferencias dos Estados- Fonte 164','Outras Transferencias dos Estados- Fonte 164','452349900','164','PREFEITURA','INC'),
            ('424289911040000','Outras Transferencias dos Estados- Fonte 165','Outras Transferencias dos Estados- Fonte 165','452349900','165','PREFEITURA','INC'),
            ('424389911020000','Outras Transferencias dos Municipios - Fonte 165','Outras Transferencias dos Municipios - Fonte 165','452359900','165','PREFEITURA','INC'),
            ('424481011050000','Transferencias de Convenios de Instit. Priv. 165','Transferencias de Convenios de Instit. Priv. 165','453110100','165','PREFEITURA','INC'),
            ('424500011020000','Transferencias de Outras Instituicoess Publicas','Transferencias de Outras Instituicoess Publicas - Fonte 165','453110100','165','PREFEITURA','INC'),
            ('424580111020000','Transferencias de Outras Instituicoess Publicas','Transferencias de Outras Instituicoess Publicas - Fonte 165','453110100','165','PREFEITURA','INC'),
            ('424600011010000','Transferencias do Exterior - Fonte 100','Transferencias do Exterior - Fonte 100','456010000','100','PREFEITURA','INC'),
            ('424600011020000','Transferencias do Exterior - Fonte 165','Transferencias do Exterior - Fonte 165','456010000','165','PREFEITURA','INC'),
            ('424680111020000','TRANSFERENCIAS DO EXTERIOR PARA PROGRAMAS DE SAUDE','TRANSFERENCIAS DO EXTERIOR PARA PROGRAMAS DE SAUDE FONTE 165','456010000','165','PREFEITURA','INC');
        INSERT INTO public.receitas2021 (estrut,descr,finalidade,vinc_pcasp,fonte,instit,tipo)
        VALUES ('424680191020000','Outras Transferencias do Exterior Nao Especif. 165','Outras Transferencias do Exterior Nao Especificada Anteriormente - Fonte 165','456010000','165','PREFEITURA','INC'),
            ('424780111020000','Transferencias de Pessoas Fisicas para Prog. Saude','Transferencias de Pessoas Fisicas para Prog. Saude - Fonte 165','456010000','165','PREFEITURA','INC'),
            ('424780121020000','Transf Pess. Fisicas Prog Educacao- Fonte 165','Transferencias de Pessoas Fisicas para Programas de Educacao -  Fonte 165','452410000','165','PREFEITURA','INC'),
            ('424780191020000','Outras Transferencias de Pessoas Fisicas Nao Espec','Outras Transferencias de Pessoas Fisicas Nao Espec - Fonte 165','452410000','165','PREFEITURA','INC'),
            ('413210061000000','JUROS SOBRE O CAPITAL PROPRIO - PRINCIPAL','Juros sobre o Capital Proprio - Principal','0','0',NULL,'INC'),
            ('417180490000000','OUTRAS TRANSFERENCIAS DE RECURSOS DO SUS','Outras Transferencias de Recursos do Sistema Unico de Saude - SUS, nao detalhadas anteriormente','0','0',NULL,'INC'),
            ('417180491000000','OUTRAS TRANSFERENCIAS DE RECURSOS DO SUS PRINCIPAL','Outras Transferencias de Recursos do Sistema Unico de Saude - SUS, nao detalhadas anteriormente - Principal','0','0',NULL,'INC'),
            ('417181100000000','TRANSFERENCIAS DE RECURSOS PARA SEGURANCA PUBLICA','Transferencias de Recursos para Seguranca Publica','0','0',NULL,'INC'),
            ('417181110000000','TRANSF. DE RECURSOS PARA SEGURANCA PUBLICA - FUPEN','Transferencia de Recursos do Fundo Penitenciario Nacional - Fupen','0','0',NULL,'INC'),
            ('417181111000000','TRANSF. DE RECURSOS PARA SEGURANCA PUBLICA - FUPEN','Transferencia de Recursos do Fundo Penitenciario Nacional - Fupen - Principal','0','0',NULL,'INC');
        INSERT INTO public.receitas2021 (estrut,descr,finalidade,vinc_pcasp,fonte,instit,tipo)
        VALUES ('417181130000000','TRANSF. DE REC. DO FNSP - ACORDADAS','Transferencia de Recursos do Fundo Nacional de Seguranca Publica - FNSP - Acordadas','0','0',NULL,'INC'),
            ('417181131000000','TRANSF. DE REC. DO FNSP - ACORDADAS - PRINCIPAL','Transferencia de Recursos do Fundo Nacional de Seguranca Publica - FNSP - Acordadas - Principal','0','0',NULL,'INC'),
            ('417181190000000','OUTRAS TRANSFERENCIAS PARA SEGURANCA PUBLICA','Outras Transferencias para Seguranca Publica','0','0',NULL,'INC'),
            ('417181191000000','OUTRAS TRANSF. PARA SEGURANCA PUBLICA - PRINCIPAL','Outras Transferencias para Seguranca Publica - Principal','0','0',NULL,'INC'),
            ('424180490000000','OUTRAS TRANSF. DE RECURSOS DO SUS','Outras Transferencias de Recursos do Sistema Unico de Saude - SUS, nao detalhadas anteriormente','0','0',NULL,'INC'),
            ('424180491000000','OUTRAS TRANSF. DE RECURSOS DO SUS - PRINCIPAL','Outras Transferencias de Recursos do Sistema Unico de Saude - SUS, nao detalhadas anteriormente - Principal','0','0',NULL,'INC'),
            ('424600010000000','Transferencias do Exterior','Transferencias do Exterior','0','0',NULL,'INC'),
            ('424600011000000','Transferencias do Exterior - Principal','Transferencias do Exterior - Principal','0','0',NULL,'INC'),
            ('424680121020000','Transf do Exterior Prog Educacao-Principal - F:165','Transferencias do Exterior para Programas de Educacao - Principal - Fonte 165','0','0',NULL,'INC'),
            ('417180300000000','TRANSF. REC. DO SUS - BLOCO MANUTENCAO ASPS','Transferencia de Recursos do Sistema Unico de Saude - SUS - Repasses Fundo a Fundo - Bloco de Manutencao das Acões e Servicos Publicos de Saude',NULL,NULL,NULL,'ALT');
        INSERT INTO public.receitas2021 (estrut,descr,finalidade,vinc_pcasp,fonte,instit,tipo)
        VALUES ('417180310000000','TRANSF. REC. DO SUS - ATENCAO PRIMARIA','Transferencia de Recursos do SUS - Atencao Primaria',NULL,NULL,NULL,'ALT'),
            ('417180311000000','TRANSF. REC. DO SUS - ATENCAO PRIMARIA - PRINCIPAL','Transferencia de Recursos do SUS - Atencao Primaria - Principal',NULL,NULL,NULL,'ALT'),
            ('417180311010000','TRANSF. REC. DO SUS - ATENCAO PRIMARIA - FONTE 159','Transferencia de Recursos do SUS - Atencao Primaria - Fonte 159',NULL,NULL,NULL,'ALT'),
            ('417180320000000','TRANSF. REC. DO SUS - ATENCAO ESPECIALIZADA','Transferencia de Recursos do SUS - Atencao Especializada',NULL,NULL,NULL,'ALT'),
            ('417180321000000','TRANSF. REC. DO SUS - ATENCAO ESPECIALIZADA - PRINCIPAL','Transferencia de Recursos do SUS - Atencao Especializada - Principal',NULL,NULL,NULL,'ALT'),
            ('417180321010000','TRANSF. REC. DO SUS - ATENCAO ESPECIALIZADA F. 159','Transferencia de Recursos do SUS - Atencao Especializada - Fonte 159',NULL,NULL,NULL,'ALT'),
            ('417180400000000','TRANSF. REC. DO SUS - BLOCO ESTRUTURACAO ASPS','Transferencias de Recursos do Sistema Unico de Saude - SUS - Repasses Fundo a Fundo - Bloco de Estruturacao da Rede de Servicos Publicos de Saude',NULL,NULL,NULL,'ALT'),
            ('417180410000000','TRANSF. REC. DO SUS - DESTINADOS ATENCAO PRIMARIA','Transferencias de Recursos do Sistema Unico de Saude - SUS Destinados à Atencao Primaria',NULL,NULL,NULL,'ALT'),
            ('417180411000000','TRANSF. REC. DO SUS - ATENCAO PRIMARIA - PRINCIPAL','Transferencias de Recursos do Sistema Unico de Saude - SUS Destinados à Atencao Primaria - Principal',NULL,NULL,NULL,'ALT'),
            ('417180411010000','TRANSF. REC. DO SUS - ATENCAO PRIMARIA - FONTE 153','Transferencias de Recursos do Sistema Unico de Saude - SUS Destinados à Atencao Primaria - Fonte 153',NULL,NULL,NULL,'ALT');
        INSERT INTO public.receitas2021 (estrut,descr,finalidade,vinc_pcasp,fonte,instit,tipo)
        VALUES ('424180300000000','TRANSF. REC. DO SUS - BLOCO MANUTENCAO ASPS','Transferencia de Recursos do Sistema Unico de Saude - SUS - Fundo a Fundo - Bloco de Manutencao das Acões e Servicos Publicos de Saude',NULL,NULL,NULL,'ALT'),
            ('424180310000000','TRANSF. REC. DO SUS - ATENCAO PRIMARIA','Transferencia de Recursos do SUS - Atencao Primaria',NULL,NULL,NULL,'ALT'),
            ('424180311000000','TRANSF. REC. DO SUS - ATENCAO PRIMARIA - PRINCIPAL','Transferencia de Recursos do SUS - Atencao Primaria - Principal',NULL,NULL,NULL,'ALT'),
            ('424180311010000','TRANSF. REC. DO SUS - ATENCAO PRIMARIA - FONTE 159','Transferencia de Recursos do SUS - Atencao Primaria - Fonte 159',NULL,NULL,NULL,'ALT'),
            ('424180320000000','TRANSF. REC. DO SUS - ATENCAO ESPECIALIZADA','Transferencia de Recursos do SUS - Atencao Especializada',NULL,NULL,NULL,'ALT'),
            ('424180321000000','TRANSF. REC. DO SUS - ATENCAO ESPECIALIZADA - PRINCIPAL','Transferencia de Recursos do SUS - Atencao Especializada - Principal',NULL,NULL,NULL,'ALT'),
            ('424180321010000','TRANSF. REC. DO SUS - ATENCAO ESPECIALIZADA F. 159','Transferencia de Recursos do SUS - Atencao Especializada - Fonte 159',NULL,NULL,NULL,'ALT'),
            ('424180400000000','TRANSF. REC. DO SUS - BLOCO ESTRUTURACAO ASPS','Transferencias de Recursos do Sistema Unico de Saude - SUS - Fundo a Fundo - Bloco de Estruturacao da Rede de Servicos Publicos de Saude',NULL,NULL,NULL,'ALT'),
            ('424180410000000','TRANSF. REC. DO SUS - ATENCAO PRIMARIA','Transferencias de Recursos do Sistema Unico de Saude - SUS Destinados à Atencao Primaria',NULL,NULL,NULL,'ALT'),
            ('424180411000000','TRANSF. REC. DO SUS - ATENCAO PRIMARIA - PRINCIPAL','Transferencias de Recursos do Sistema Unico de Saude - SUS Destinados à Atencao Primaria - Principal',NULL,NULL,NULL,'ALT'),
            ('424180411010000','TRANSF. REC. DO SUS - ATENCAO PRIMARIA - FONTE 153','Transferencias de Recursos do Sistema Unico de Saude - SUS Destinados à Atencao Primaria - Fonte 153',NULL,NULL,NULL,'ALT');

        COMMIT;
        ";

        $this->execute($sql);

    }
}
