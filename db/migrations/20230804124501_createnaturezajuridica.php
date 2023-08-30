<?php

use Phinx\Migration\AbstractMigration;

class Createnaturezajuridica extends AbstractMigration
{
    public function up()
    {
        $sql = "create table naturezajurifica (
            n1_sequencial int8,
            n1_codigo varchar(4),
            n1_descricao text
            );

            CREATE SEQUENCE naturezajurifica_n1_sequencial_seq
            INCREMENT 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1
            CACHE 1;

            alter table cgm add column z01_naturezajuridica varchar (4);

            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'0000', 'Natureza Jurídica não informada');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1015','Órgão Público do Poder Executivo Federal');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1023','Órgão Público do Poder Executivo Estadual ou do Distrito Federal');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1031','Órgão Público do Poder Executivo Municipal');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1040','Órgão Público do Poder Legislativo Federal');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1058','Órgão Público do Poder Legislativo Estadual ou do Distrito Federal');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1066','Órgão Público do Poder Legislativo Municipal');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1074','Órgão Público do Poder Judiciário Federal');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1082','Órgão Público do Poder Judiciário Estadual');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1104','Autarquia Federal');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1112','Autarquia Estadual ou do Distrito Federal');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1120','Autarquia Municipal');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1139','Fundação Pública de Direito Público Federal');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1147','Fundação Pública de Direito Público Estadual ou do Distrito Federal');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1155','Fundação Pública de Direito Público Municipal');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1163','Órgão Público Autônomo Federal');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1171','Órgão Público Autônomo Estadual ou do Distrito Federal');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1180','Órgão Público Autônomo Municipal');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1198','Comissão Polinacional');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1210','Consórcio Público de Direito Público (Associação Pública)');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1228','Consórcio Público de Direito Privado');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1236','Estado ou Distrito Federal');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1244','Município');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1252','Fundação Pública de Direito Privado Federal');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1260','Fundação Pública de Direito Privado Estadual ou do Distrito Federal');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1279','Fundação Pública de Direito Privado Municipal');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1287','Fundo Público da Administração Indireta Federal');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1295','Fundo Público da Administração Indireta Estadual ou do Distrito Federal');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1309','Fundo Público da Administração Indireta Municipal');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1317','Fundo Público da Administração Direta Federal');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1325','Fundo Público da Administração Direta Estadual ou do Distrito Federal');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1333','Fundo Público da Administração Direta Municipal');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'1341','União');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2011','Empresa Pública');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2038','Sociedade de Economia Mista');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2046','Sociedade Anônima Aberta');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2054','Sociedade Anônima Fechada');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2062','Sociedade Empresária Limitada');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2070','Sociedade Empresária em Nome Coletivo');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2089','Sociedade Empresária em Comandita Simples');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2097','Sociedade Empresária em Comandita por Ações');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2100','Sociedade Mercantil de Capital e Indústria');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2127','Sociedade em Conta de Participação');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2135','Empresário (Individual)');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2143','Cooperativa');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2151','Consórcio de Sociedades');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2160','Grupo de Sociedades');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2178','Estabelecimento, no Brasil, de Sociedade Estrangeira');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2194','Estabelecimento, no Brasil, de Empresa Binacional Argentino-Brasileira');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2216','Empresa Domiciliada no Exterior');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2224','Clube/Fundo de Investimento');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2232','Sociedade Simples Pura');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2240','Sociedade Simples Limitada');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2259','Sociedade Simples em Nome Coletivo');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2267','Sociedade Simples em Comandita Simples');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2275','Empresa Binacional');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2283','Consórcio de Empregadores');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2291','Consórcio Simples');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2305','Empresa Individual de Responsabilidade Limitada (de Natureza Empresária)');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2313','Empresa Individual de Responsabilidade Limitada (de Natureza Simples)');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2321','Sociedade Unipessoal de Advocacia');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2330','Cooperativas de Consumo');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2348','Empresa Simples de Inovação - Inova Simples');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'2356','Investidor Não Residente');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'3034','Serviço Notarial e Registral (Cartório)');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'3069','Fundação Privada');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'3077','Serviço Social Autônomo');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'3085','Condomínio Edilício');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'3107','Comissão de Conciliação Prévia');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'3115','Entidade de Mediação e Arbitragem');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'3131','Entidade Sindical');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'3204','Estabelecimento, no Brasil, de Fundação ou Associação Estrangeiras');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'3212','Fundação ou Associação Domiciliada no Exterior');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'3220','Organização Religiosa');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'3239','Comunidade Indígena');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'3247','Fundo Privado');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'3255','Órgão de Direção Nacional de Partido Político');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'3263','Órgão de Direção Regional de Partido Político');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'3271','Órgão de Direção Local de Partido Político');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'3280','Comitê Financeiro de Partido Político');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'3298','Frente Plebiscitária ou Referendária');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'3301','Organização Social (OS)');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'3328','Plano de Benefícios de Previdência Complementar Fechada');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'3999','Associação Privada');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'4014','Empresa Individual Imobiliária');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'4090','Candidato a Cargo Político Eletivo');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'4120','Produtor Rural (Pessoa Física)');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'5010','Organização Internacional');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'5029','Representação Diplomática Estrangeira');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'5037','Outras Instituições Extraterritoriais');
            insert into naturezajurifica values(nextval('naturezajurifica_n1_sequencial_seq'),'8885','Natureza Jurídica não informada');
        ";

        $this->execute($sql);
    }
}
