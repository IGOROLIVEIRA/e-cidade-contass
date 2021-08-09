<?php

use Phinx\Migration\AbstractMigration;

class Oc15264 extends AbstractMigration
{
    public function up()
    {
        if ($this->inputTempRegister()){
            $sqlInsert = "INSERT INTO db_estruturavalor
                          SELECT nextval('db_estruturavalor_db121_sequencial_seq') AS db121_sequencial,
                                 db121_db_estrutura,
                                 db121_estrutural,
                                 db121_descricao,
                                 db121_estruturavalorpai,
                                 db121_nivel,
                                 db121_tipoconta
                          FROM dbestruturavalor_temp
                          WHERE db121_estrutural NOT IN (SELECT db121_estrutural FROM db_estruturavalor)";

            $this->execute($sqlInsert);

            $sql2 = "INSERT INTO orctiporec VALUES
                    (104,
                    substr('Rec Vinculados RPPS - Fundo em Reparticao (Plano Financeiro)',1,60),
                    '104',
                    'Controle dos recursos vinculados ao fundo em reparticao do RPPS. Esse plano deve existir somente nos entes que segregaram a massa dos segurados, observando-se o disposto na Portaria MF nº 464/2018.',
                    2,
                    null,
                    (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '104' LIMIT 1),
                    14200000),
                    
                    (120,
                    substr('Transf. de Recursos dos Estados para Programas de Educacao',1,60),
                    '120',
                    'Controle dos recursos transferidos pelos Estados para programas de educacao, que nao decorram de celebracao de convenios, contratos de repasse e termos de parceria.',
                    2,
                    null,
                    (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '120' LIMIT 1),
                    15760000),
                    
                    (121,
                    substr('Transf Fundo Fundo de Rec SUS provenientes dos Governos Muni',1,60),
                    '121',
                    'Controle dos recursos originarios de transferencias dos Fundos de saude de outros municipios, referentes ao Sistema Unico de Saude (SUS).',
                    2,
                    null,
                    (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '121' LIMIT 1),
                    12120000),
                    
                    (169,
                    substr('Transferencia Especial dos Estados ',1,60),
                    '169',
                    'Controle dos recursos transferidos pelos Estados provenientes de emendas individuais impositivas ao orcamento desses entes, por meio de transferencia especiais, nos termos das constituicoes estaduais que reproduziram o disposto no art. 166-A, inciso I, da Constituicao Federal.',
                    2,
                    null,
                    (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '169' LIMIT 1),
                    17100000),
                    
                    (170,
                    substr('Outros Recursos Nao Vinculados',1,60),
                    '170',
                    'Outros recursos nao vinculados que nao se enquadrem na especificacao acima.',
                    1,
                    null,
                    (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '170' LIMIT 1),
                    10900000),
                    
                    (171,
                    substr('Transf. do Estado referentes a Convenios ou de Contratos de Repasse vinculados a Educacao',1,60),
                    '171',
                    'Controle dos recursos originarios de transferencias em decorrencia da celebracao de convenios, contratos de repasse e termos de parceria com os Estados, cuja destinacao encontra-se vinculada a programas da educacao.',
                    2,
                    null,
                    (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '171' LIMIT 1),
                    11250000),
                    
                    (172,
                    substr('Transf. de Municipios referentes a Convenios ou de Contratos de Repasse Vinculados a Educacao',1,60),
                    '172',
                    'Controle dos recursos originarios de transferencias em decorrencia da celebracao de convenios, contratos de repasse e termos de parceria com outros municipios, cuja destinacao encontra-se vinculada a programas da educacao.',
                    2,
                    null,
                    (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '172' LIMIT 1),
                    11250000),
                    
                    (173,
                    substr('Transf. de Outras Entidades referentes a Convenios e Instrumentos Congeneres Vinculados a Educacao',1,60),
                    '173',
                    'Controle dos recursos originarios de transferencias de entidades privadas, estrangeiras ou multigovernamentais em virtude de assinatura de convenios, contratos de repasse ou legislacoes especificas, cuja destinacao encontra-se vinculada aos seus objetos. Nao serao controlados por esta fonte os recursos de convenios ou contratos de repasse vinculados a programas da educacao, da saude e da assistencia social.',
                    2,
                    null,
                    (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '173' LIMIT 1),
                    11250000),
                    
                    (174,
                    substr('Operacoes de Credito Vinculadas a Educacao',1,60),
                    '174',
                    'Controle dos recursos originarios de operacoes de credito, cuja destinacao encontra-se vinculada a programas da educacao.',
                    2,
                    null,
                    (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '174' LIMIT 1),
                    11300000),
                    
                    (175,
                    substr('Royalties do Petroleo e Gas Natural Vinculados a Educacao',1,60),
                    '175',
                    'Controle dos recursos vinculados a Educacao, originarios de transferencias recebidas pelo Municipio, relativos  a Royalties e Participacao Especial - Art. 2º da Lei nº 12.858/2013.',
                    2,
                    null,
                    (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '175' LIMIT 1),
                    11400000),
                    
                    (176,
                    substr('Transf. do Estado referentes a Convenios ou Contratos de Repasse Vinculados a Saude',1,60),
                    '176',
                    'Controle dos recursos originarios de transferencias em decorrencia da celebracao de convenios, contratos de repasse e termos de parceria com os Estados, cuja destinacao encontra-se vinculada a programas da saude.',
                    2,
                    null,
                    (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '176' LIMIT 1),
                    12200000),
                    
                    (177,
                    substr('Transf. De Municipios referentes a Convenios ou Contratos de Repasse Vinculados a Saude',1,60),
                    '177',
                    'Controle dos recursos originarios de transferencias em decorrencia da celebracao de convenios, contratos de repasse e termos de parceria com outros Municipios, cuja destinacao encontra-se vinculada a programas da saude.',
                    2,
                    null,
                    (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '177' LIMIT 1),
                    12200000),
                    
                    (178,
                    substr('Transf. de Outras Entidades referentes a Convenios e Instrumentos Congeneres Vinculados a Saude ',1,60),
                    '178',
                    'Controle dos recursos originarios de transferencias de entidades privadas, estrangeiras ou multigovernamentais em virtude de assinatura de convenios e instrumentos congeneres, cuja destinacao encontra-se vinculada a programas de saude.',
                    2,
                    null,
                    (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '178' LIMIT 1),
                    12200000),
                    
                    (179,
                    substr('Operacoes de Credito Vinculadas a Saude',1,60),
                    '179',
                    'Controle dos recursos originarios de operacoes de credito, cuja destinacao encontra-se vinculada a programas da saude.',
                    2,
                    null,
                    (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '179' LIMIT 1),
                    12300000),
                    
                    (180,
                    substr('Royalties do Petroleo e Gas Natural Vinculados a Saude',1,60),
                    '180',
                    'Controle dos recursos vinculados a Saude, originarios de transferencias recebidas pelo Municipio, relativos  a Royalties e Participacao Especial - Art. 2º da Lei nº 12.858/2013.',
                    2,
                    null,
                    (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '180' LIMIT 1),
                    12400000),
                    
                    (181,
                    substr('Outras Transferencias de Convenios ou Contratos de Repasse dos Estados',1,60),
                    '181',
                    'Controle dos recursos originarios de transferencias estaduais em decorrencia da celebracao de convenios, contratos de repasse e termos de parceria, cuja destinacao encontra-se vinculada aos seus objetos. Nao serao controlados por esta fonte os recursos de convenios ou contratos de repasse vinculados a programas da educacao, da saude e da assistencia social.',
                    2,
                    null,
                    (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '181' LIMIT 1),
                    15200000),
                    
                    (182,
                    substr('Outras Transferencias de Convenios ou Contratos de Repasse dos Municipios',1,60),
                    '182',
                    'Controle dos recursos originarios de transferencias de municipios em decorrencia da celebracao de convenios, contratos de repasse e termos de parceria, cuja destinacao encontra-se vinculada aos seus objetos. Nao serao controlados por esta fonte os recursos de convenios ou contratos de repasse vinculados a programas da educacao, da saude e da assistencia social.',
                    2,
                    null,
                    (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '182' LIMIT 1),
                    19900000),
                    
                    (183,
                    substr('Outras Transferencias de Convenios ou Contratos de Repasse de Outras Entidades',1,60),
                    '183',
                    'Controle dos recursos originarios de transferencias de entidades privadas, estrangeiras ou multigovernamentais em virtude de assinatura de convenios, contratos de repasse ou legislacoes especificas, cuja destinacao encontra-se vinculada aos seus objetos. Nao serao controlados por esta fonte os recursos de convenios ou contratos de repasse vinculados a programas da educacao, da saude e da assistencia social.',
                    2,
                    null,
                    (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '183' LIMIT 1),
                    19900000),
                    
                    (184,
                    substr('Transferencia da Uniao referente a Compensacao Financeira de Recursos Hidricos',1,60),
                    '184',
                    'Controle dos recursos transferidos pela Uniao, referentes a compensacao financeira pela exploracao dos recursos hidricos em atendimento a destinacoes e vedacoes previstas na legislacao.',
                    2,
                    null,
                    (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '184' LIMIT 1),
                    17090000),
                    
                    (185,
                    substr('Recursos Provenientes de Taxas e Contribuicoes',1,60),
                    '185',
                    'Controle dos recursos de taxas e contribuicoes vinculadas conforme legislacoes especificas.',
                    1,
                    null,
                    (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '185' LIMIT 1),
                    19500000),
                    
                    (186,
                    substr('Transferencia da Uniao referente a Royalties do Petroleo e Gas Natural',1,60),
                    '186',
                    'Controle dos recursos transferidos pela Uniao, originarios da arrecadacao de royalties, que nao sejam destinados a Areas da saude ou educacao.',
                    2,
                    null,
                    (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '186' LIMIT 1),
                    15300000),
                    
                    (187,
                    substr('Transferencia dos Estados referente a Royalties do Petroleo e Gas Natural',1,60),
                    '187',
                    'Controle dos recursos transferidos pelos Estados, originarios da arrecadacao de royalties, que nao sejam destinados a Areas da saude ou educacao.',
                    2,
                    null,
                    (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '187' LIMIT 1),
                    15400000);";

            $this->execute($sql2);
        }
    }

    private function inputTempRegister()
    {
       $sql1 = "SELECT fc_startsession();

                CREATE TABLE dbestruturavalor_temp (
                            db121_sequencial int4 DEFAULT 0,
                            db121_db_estrutura int4 DEFAULT 0,
                            db121_estrutural varchar(255),
                            db121_descricao text,
                            db121_estruturavalorpai int4 DEFAULT 0,
                            db121_nivel int4 DEFAULT 0,
                            db121_tipoconta int4 NULL DEFAULT 0);        
                
                INSERT INTO dbestruturavalor_temp VALUES
                (999, 5, '104', 'Rec Vinculados RPPS - Fundo em Reparticao (Plano Financeiro)', 0, 1, 1),
                (999, 5, '120', 'Transf. de Recursos dos Estados para Programas de Educacao', 0, 1, 1),                
                (999, 5, '121', 'Transf Fundo Fundo de Rec SUS provenientes dos Governos Muni', 0, 1, 1),                
                (999, 5, '169', 'Transferencia Especial dos Estados ', 0, 1, 1),                
                (999, 5, '170', 'Outros Recursos Nao Vinculados', 0, 1, 1),                
                (999, 5, '171', 'Transf. do Estado referentes a Convenios ou de Contratos de Repasse vinculados a Educacao', 0, 1, 1),                
                (999, 5, '172', 'Transf. de Municipios referentes a Convenios ou de Contratos de Repasse Vinculados a Educacao', 0, 1, 1),                
                (999, 5, '173', 'Transf. de Outras Entidades referentes a Convenios e Instrumentos Congeneres Vinculados a Educacao', 0, 1, 1),                
                (999, 5, '174', 'Operacoes de Credito Vinculadas a Educacao', 0, 1, 1),                
                (999, 5, '175', 'Royalties do Petroleo e Gas Natural Vinculados a Educacao', 0, 1, 1),                
                (999, 5, '176', 'Transf. do Estado referentes a Convenios ou Contratos de Repasse Vinculados a Saude', 0, 1, 1),                
                (999, 5, '177', 'Transf. De Municipios referentes a Convenios ou Contratos de Repasse Vinculados a Saude', 0, 1, 1),                
                (999, 5, '178', 'Transf. de Outras Entidades referentes a Convenios e Instrumentos Congeneres Vinculados a Saude ', 0, 1, 1),                
                (999, 5, '179', 'Operacoes de Credito Vinculadas a Saude', 0, 1, 1),                
                (999, 5, '180', 'Royalties do Petroleo e Gas Natural Vinculados a Saude', 0, 1, 1),                
                (999, 5, '181', 'Outras Transferencias de Convenios ou Contratos de Repasse dos Estados', 0, 1, 1),                
                (999, 5, '182', 'Outras Transferencias de Convenios ou Contratos de Repasse dos Municipios', 0, 1, 1),                
                (999, 5, '183', 'Outras Transferencias de Convenios ou Contratos de Repasse de Outras Entidades', 0, 1, 1),                
                (999, 5, '184', 'Transferencia da Uniao referente a Compensacao Financeira de Recursos Hidricos', 0, 1, 1),                
                (999, 5, '185', 'Recursos Provenientes de Taxas e Contribuicoes', 0, 1, 1),                
                (999, 5, '186', 'Transferencia da Uniao referente a Royalties do Petroleo e Gas Natural', 0, 1, 1),                
                (999, 5, '187', 'Transferencia dos Estados referente a Royalties do Petroleo e Gas Natural', 0, 1, 1);";


        $this->execute($sql1);

        $result1 = $this->fetchAll("SELECT * FROM dbestruturavalor_temp");

        if (!empty($result1)){
            return true;
        }
        return false;
    }

}
