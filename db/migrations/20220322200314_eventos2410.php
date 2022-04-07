<?php

use Phinx\Migration\AbstractMigration;

class Eventos2410 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
        BEGIN;
        update avaliacao set db101_cargadados ='
                SELECT cgm.z01_cgccpf AS cpfbenef,
                rh01_matorgaobeneficio AS matricula,
                rh01_cnpjrespmatricula AS cnpjorigem,
                CASE
                    WHEN rh01_admiss < \'2021-11-21\' THEN 4002206
                    ELSE 4002207
                END AS cadini,
                4002208 AS indsitbenef,
                rh01_regist AS nrbeneficio,
                rh01_admiss AS dtinibeneficio,
                CASE
                    WHEN rh02_tipobeneficio = \'0801\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0801\')
                    WHEN rh02_tipobeneficio = \'0101\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0101\')
                    WHEN rh02_tipobeneficio = \'0102\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0102\')
                    WHEN rh02_tipobeneficio = \'0103\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0103\')
                    WHEN rh02_tipobeneficio = \'0104\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0104\')
                    WHEN rh02_tipobeneficio = \'0105\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0105\')
                    WHEN rh02_tipobeneficio = \'0106\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0106\')
                    WHEN rh02_tipobeneficio = \'0107\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0107\')
                    WHEN rh02_tipobeneficio = \'0108\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0108\')
                    WHEN rh02_tipobeneficio = \'0201\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0201\')
                    WHEN rh02_tipobeneficio = \'0202\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0202\')
                    WHEN rh02_tipobeneficio = \'0203\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0203\')
                    WHEN rh02_tipobeneficio = \'0301\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0301\')
                    WHEN rh02_tipobeneficio = \'0302\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0302\')
                    WHEN rh02_tipobeneficio = \'0303\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0303\')
                    WHEN rh02_tipobeneficio = \'0304\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0304\')
                    WHEN rh02_tipobeneficio = \'0601\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0601\')
                    WHEN rh02_tipobeneficio = \'0602\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0602\')
                    WHEN rh02_tipobeneficio = \'0603\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0603\')
                    WHEN rh02_tipobeneficio = \'0802\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0802\')
                    WHEN rh02_tipobeneficio = \'0803\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0803\')
                    WHEN rh02_tipobeneficio = \'0804\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0804\')
                    WHEN rh02_tipobeneficio = \'0805\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0805\')
                    WHEN rh02_tipobeneficio = \'0806\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0806\')
                    WHEN rh02_tipobeneficio = \'0807\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0807\')
                    WHEN rh02_tipobeneficio = \'0808\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0808\')
                    WHEN rh02_tipobeneficio = \'0809\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0809\')
                    WHEN rh02_tipobeneficio = \'0810\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0810\')
                    WHEN rh02_tipobeneficio = \'0811\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0811\')
                    WHEN rh02_tipobeneficio = \'0812\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_0812\')
                    WHEN rh02_tipobeneficio = \'1001\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_1001\')
                    WHEN rh02_tipobeneficio = \'1009\' THEN
                                (SELECT db104_sequencial
                                FROM avaliacaoperguntaopcao
                                WHERE db104_identificador=\'tpbeneficio_1009\')
                END AS tpbeneficio,
                CASE
                    WHEN rh02_plansegreg = 1 THEN 4002215
                    WHEN rh02_plansegreg = 2 THEN 4002216
                    WHEN rh02_plansegreg = 3 THEN 4002217
                    WHEN rh02_plansegreg = 0 THEN 4002214
                END AS tpplanrp,
                rh02_descratobeneficio AS dsc,
                CASE
                    WHEN rh01_concedido = \'t\' THEN 4002219
                    ELSE 4002220
                END AS inddecjud,
                rh02_validadepensao,
                CASE
                    WHEN rh30_vinculo = \'I\' THEN NULL
                    WHEN rh02_validadepensao IS NOT NULL THEN 4002221
                    ELSE 4002222
                END AS tppenmorte,
                instituidor.z01_cgccpf AS cpfinst,
                rh02_dtobitoinstituidor AS dtinst,
                rh30_vinculo,
                rh02_cgminstituidor
            FROM rhpessoal
            INNER JOIN cgm ON cgm.z01_numcgm = rhpessoal.rh01_numcgm
            LEFT JOIN rhpessoalmov ON rh02_anousu = fc_getsession(\'DB_anousu\')::int
            AND rh02_mesusu = date_part(\'month\',fc_getsession(\'DB_datausu\')::date)
            AND rh02_regist = rh01_regist
            AND rh02_instit = fc_getsession(\'DB_instit\')::int
            LEFT JOIN rhpesrescisao ON rh02_seqpes = rh05_seqpes
            LEFT JOIN rhregime ON rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
            LEFT JOIN rescisao ON rescisao.r59_anousu = rhpessoalmov.rh02_anousu
            AND rescisao.r59_mesusu = rhpessoalmov.rh02_mesusu
            AND rescisao.r59_regime = rhregime.rh30_regime
            AND rescisao.r59_causa = rhpesrescisao.rh05_causa
            AND rescisao.r59_caub = rhpesrescisao.rh05_caub::char(2)
            LEFT JOIN cgm instituidor ON instituidor.z01_numcgm = rh02_cgminstituidor
            WHERE rh30_vinculo IN (\'I\',\'P\')
                AND r59_anousu IS NULL
                AND rh01_matorgaobeneficio IS NOT NULL
        ' where db101_sequencial = 4000118;

        UPDATE db_itensmenu
        SET funcao = 'con4_manutencaoformulario001.php?esocial=49'
        WHERE descricao LIKE '%S-2410%';


        UPDATE avaliacaopergunta
        SET db103_camposql = LOWER(db103_identificadorcampo)
        WHERE db103_avaliacaogrupopergunta = 4000364;


        UPDATE avaliacaopergunta
        SET db103_camposql = LOWER(db103_identificadorcampo)
        WHERE db103_avaliacaogrupopergunta = 4000365;


        UPDATE avaliacaopergunta
        SET db103_camposql = LOWER(db103_identificadorcampo)
        WHERE db103_avaliacaogrupopergunta = 4000366;


        UPDATE avaliacaopergunta
        SET db103_camposql = LOWER(db103_identificadorcampo)
        WHERE db103_avaliacaogrupopergunta = 4000367;


        UPDATE avaliacaopergunta
        SET db103_camposql = LOWER(db103_identificadorcampo)
        WHERE db103_avaliacaogrupopergunta = 4000368;


        UPDATE avaliacaopergunta
        SET db103_camposql = LOWER(db103_identificadorcampo)
        WHERE db103_avaliacaogrupopergunta = 4000369;


        UPDATE avaliacaopergunta
        SET db103_camposql = LOWER(db103_identificadorcampo)
        WHERE db103_avaliacaogrupopergunta = 4000370;


        UPDATE avaliacaopergunta
        SET db103_camposql = LOWER(db103_identificadorcampo)
        WHERE db103_avaliacaogrupopergunta = 4000371;

        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0801 - Aposentadoria sem paridade concedida antes da obrigatoriedade de envio dos eventos não periódicos para entes públicos no eSocial'               ,true,'tpbeneficio_0801',0,'0801','');

        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0101 - Aposentadoria por idade e tempo de contribuição - Proventos com integralidade, revisão pela paridade'                                           ,true,'tpbeneficio_0101',0,'0101','');
        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0102 - Aposentadoria por idade e tempo de contribuição - Proventos pela média, reajuste manter valor real'                                             ,true,'tpbeneficio_0102',0,'0102','');
        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0103 - Aposentadoria por idade - Proventos proporcionais calculado sobre integralidade, revisão pela paridade'                                         ,true,'tpbeneficio_0103',0,'0103','');
        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0104 - Aposentadoria por idade - Proventos proporcionais calculado sobre a média, reajuste manter valor real'                                          ,true,'tpbeneficio_0104',0,'0104','');
        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0105 - Aposentadoria compulsória - Proventos proporcionais calculado sobre integralidade, revisão pela paridade'                                       ,true,'tpbeneficio_0105',0,'0105','');
        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0106 - Aposentadoria compulsória - Proventos proporcionais calculado sobre a média, reajuste manter valor real'                                        ,true,'tpbeneficio_0106',0,'0106','');
        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0107 - Aposentadoria de professor - Proventos com integralidade, revisão pela paridade'                                                                ,true,'tpbeneficio_0107',0,'0107','');
        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0108 - Aposentadoria de professor - Proventos pela média, reajuste manter valor real'                                                                  ,true,'tpbeneficio_0108',0,'0108','');

        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0201 - Aposentadoria especial - Risco'                                                                                                                 ,true,'tpbeneficio_0201',0,'0201','');
        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0202 - Aposentadoria especial - Exposição a agentes nocivos'                                                                                           ,true,'tpbeneficio_0202',0,'0202','');
        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0203 - Aposentadoria da pessoa com deficiência'                                                                                                        ,true,'tpbeneficio_0203',0,'0203','');

        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0301 - Aposentadoria por invalidez - Proventos com integralidade, revisão pela paridade'                                                               ,true,'tpbeneficio_0301',0,'0301','');
        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0302 - Aposentadoria por invalidez - Proventos pela média, reajuste manter valor real'                                                                 ,true,'tpbeneficio_0302',0,'0302','');
        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0303 - Aposentadoria por invalidez - Proventos proporcionais calculado sobre integralidade, revisão pela paridade'                                     ,true,'tpbeneficio_0303',0,'0303','');
        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0304 - Aposentadoria por invalidez - Proventos proporcionais calculado sobre a média, reajuste manter valor real'                                      ,true,'tpbeneficio_0304',0,'0304','');

        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0601 - Pensão por morte (art. 40, § 7º, da CF/1988)'                                                                                                   ,true,'tpbeneficio_0601',0,'0601','');
        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0602 - Pensão por morte com paridade, decorrente do art. 6º-A da EC 41/2003'                                                                           ,true,'tpbeneficio_0602',0,'0602','');
        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0603 - Pensão por morte com paridade, decorrente do art. 3º da EC 47/2005'                                                                             ,true,'tpbeneficio_0603',0,'0603','');

        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0802 - Aposentadoria com paridade concedida antes da obrigatoriedade de envio dos eventos não periódicos para entes públicos no eSocial'               ,true,'tpbeneficio_0802',0,'0802','');
        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0803 - Aposentadoria por invalidez com paridade concedida antes da obrigatoriedade de envio dos eventos não periódicos para entes públicos no eSocial' ,true,'tpbeneficio_0803',0,'0803','');
        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0804 - Aposentadoria por invalidez sem paridade concedida antes da obrigatoriedade de envio dos eventos não periódicos para entes públicos no eSocial' ,true,'tpbeneficio_0804',0,'0804','');
        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0805 - Transferência para reserva concedida antes da obrigatoriedade de envio dos eventos não periódicos para entes públicos no eSocial'               ,true,'tpbeneficio_0805',0,'0805','');
        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0806 - Reforma concedida antes da obrigatoriedade de envio dos eventos não periódicos para entes públicos no eSocial'                                  ,true,'tpbeneficio_0806',0,'0806','');
        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0807 - Pensão por morte com paridade concedida antes da obrigatoriedade de envio dos eventos não periódicos para entes públicos no eSocial'            ,true,'tpbeneficio_0807',0,'0807','');
        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0808 - Pensão por morte sem paridade concedida antes da obrigatoriedade de envio dos eventos não periódicos para entes públicos no eSocial'            ,true,'tpbeneficio_0808',0,'0808','');
        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0809 - Outros benefícios previdenciários concedidos antes da obrigatoriedade de envio dos eventos não periódicos para entes públicos no eSocial'       ,true,'tpbeneficio_0809',0,'0809','');
        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0810 - Aposentadoria de parlamentar - Plano próprio'                                                                                                   ,true,'tpbeneficio_0810',0,'0810','');
        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0811 - Aposentadoria de servidor vinculado ao Poder Legislativo - Plano próprio'                                                                       ,true,'tpbeneficio_0811',0,'0811','');
        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'0812 - Pensão por morte - Plano próprio'                                                                                                               ,true,'tpbeneficio_0812',0,'0812','');

        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'1001 - Pensão especial sem vínculo previdenciário'                                                                                                     ,true,'tpbeneficio_1001',0,'1001','');
        insert into avaliacaoperguntaopcao values ((select max(db104_sequencial)+1 from avaliacaoperguntaopcao),4001269 ,'1009 - Outros benefícios sem vínculo previdenciário'                                                                                                   ,true,'tpbeneficio_1009',0,'1009','');
        
        COMMIT;
SQL;
        $this->execute($sql);
    }
}
