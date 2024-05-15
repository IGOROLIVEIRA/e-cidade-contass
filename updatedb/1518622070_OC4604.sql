BEGIN;


SELECT fc_startsession();


CREATE TABLE "rubricasesocial" ( "e990_sequencial" varchar NOT NULL,
                                                           "e990_descricao" varchar NOT NULL,
                                                                                    CONSTRAINT rubricasesocial_pk PRIMARY KEY ("e990_sequencial")) WITH ( OIDS=FALSE);


CREATE TABLE "baserubricasesocial" ( "e991_rubricasesocial" varchar NOT NULL,
                                                                                              "e991_rubricas" varchar NOT NULL,
                                                                                                                      "e991_instit" integer NOT NULL) WITH ( OIDS=FALSE);



ALTER TABLE "baserubricasesocial" ADD CONSTRAINT "baserubricasesocial_rubricasesocial_fk0"
FOREIGN KEY ("e991_rubricasesocial") REFERENCES "rubricasesocial"("e990_sequencial");


ALTER TABLE "baserubricasesocial" ADD CONSTRAINT "baserubricasesocial_rubricas_fk1"
FOREIGN KEY ("e991_rubricas",
             "e991_instit") REFERENCES "rhrubricas"("rh27_rubric",
                                                    "rh27_instit");

 -- INSERINDO db_sysarquivo

INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform)
VALUES (
          (SELECT max(codarq)+1
           FROM db_sysarquivo), 'rubricasesocial',
                                'estrutura de armazenamento de rúbricas do e-social',
                                'e990',
                                '2018-02-14',
                                'Rúbricas E-Social',
                                0,
                                FALSE,
                                FALSE,
                                FALSE,
                                FALSE);

 -- INSERINDO db_sysarqmod

INSERT INTO db_sysarqmod (codmod, codarq)
VALUES (28,
          (SELECT max(codarq)
           FROM db_sysarquivo));

 -- INSERINDO db_syscampo

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'e990_sequencial',
                              'int4',
                              'Sequencia rubricas e-social',
                              '0',
                              'Sequencia rubricas e-social',
                              10,
                              FALSE,
                              FALSE,
                              FALSE,
                              1,
                              'text',
                              'Sequencia rubricas e-social');


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'e990_descricao',
                              'int4                                    ',
                              'Nome da rúbrica',
                              '0',
                              'Nome da rúbrica',
                              10,
                              FALSE,
                              FALSE,
                              FALSE,
                              1,
                              'text',
                              'Nome da rúbrica');


INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
VALUES (
          (SELECT max(codarq)
           FROM db_sysarquivo),
          (SELECT codcam
           FROM db_syscampo
           WHERE nomecam = 'e990_sequencial'), 1,
                                               0);


INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
VALUES (
          (SELECT max(codarq)
           FROM db_sysarquivo),
          (SELECT codcam
           FROM db_syscampo
           WHERE nomecam = 'e990_descricao'), 2,
                                              0);


INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform)
VALUES (
          (SELECT max(codarq)+1
           FROM db_sysarquivo), 'baserubricasesocial',
                                'Bases das rúbricas do E-Social',
                                'e991',
                                '2018-02-14',
                                'Bases das rúbricas do E-Social',
                                0,
                                FALSE,
                                FALSE,
                                FALSE,
                                FALSE);

 -- INSERINDO db_sysarqmod

INSERT INTO db_sysarqmod (codmod, codarq)
VALUES (28,
          (SELECT max(codarq)
           FROM db_sysarquivo));

 -- INSERINDO db_syscampo



INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'e991_rubricasesocial',
                              'int4                                    ',
                              'Sequencial do rubricasesocial',
                              '0',
                              'Sequencial do rubricasesocial',
                              10,
                              FALSE,
                              FALSE,
                              FALSE,
                              1,
                              'text',
                              'Sequencial do rubricasesocial');


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'e991_rubricas',
                              'int4                                    ',
                              'Sequencial do rubricas',
                              '0',
                              'Sequencial do rubricas',
                              10,
                              FALSE,
                              FALSE,
                              FALSE,
                              1,
                              'text',
                              'Sequencial do rubricas');


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'e991_instit',
                              'text',
                              'Instituicao',
                              '0',
                              'Instituicao',
                              10,
                              FALSE,
                              FALSE,
                              FALSE,
                              1,
                              'text',
                              'Instituicao do rhrubricas');



INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
VALUES (
          (SELECT max(codarq)
           FROM db_sysarquivo),
          (SELECT codcam
           FROM db_syscampo
           WHERE nomecam = 'e991_rubricasesocial'), 2,
                                                    0);


INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
VALUES (
          (SELECT max(codarq)
           FROM db_sysarquivo),
          (SELECT codcam
           FROM db_syscampo
           WHERE nomecam = 'e991_rubricas'), 3,
                                             0);


INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
VALUES (
          (SELECT max(codarq)
           FROM db_sysarquivo),
          (SELECT codcam
           FROM db_syscampo
           WHERE nomecam = 'e991_instit'), 4,
                                           0);

 -- INSERINDO db_sysforkey

INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel)
VALUES (
          (SELECT max(codarq)
           FROM db_sysarquivo),
          (SELECT codcam
           FROM db_syscampo
           WHERE nomecam = 'e991_rubricasesocial'), 1,
          (SELECT codarq
           FROM db_sysarquivo
           WHERE nomearq = 'rubricasesocial'), 0);


INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel)
VALUES (
          (SELECT max(codarq)
           FROM db_sysarquivo),
          (SELECT codcam
           FROM db_syscampo
           WHERE nomecam = 'e991_rubricas'), 2,
          (SELECT codarq
           FROM db_sysarquivo
           WHERE nomearq = 'rhrubricas'), 0);


INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel)
VALUES (
          (SELECT max(codarq)
           FROM db_sysarquivo),
          (SELECT codcam
           FROM db_syscampo
           WHERE nomecam = 'e991_instit'), 3,
          (SELECT codarq
           FROM db_sysarquivo
           WHERE nomearq = 'rhrubricas'), 0);




INSERT INTO db_itensmenu
VALUES (
          (SELECT max(id_item) + 1
           FROM db_itensmenu), 'E-social / Rubricas',
                               'E-social / Rubricas',
                               '',
                               1,
                               1,
                               'E-social / Rubricas',
                               't');


INSERT INTO db_menu
VALUES (4374,
          (SELECT max(id_item)
           FROM db_itensmenu),
          (SELECT (max(menusequencia)+1)
           FROM db_menu
           WHERE id_item = 4374
             AND modulo = 952), 952);




INSERT INTO db_itensmenu
VALUES (
          (SELECT max(id_item) + 1
           FROM db_itensmenu), 'Inclusao',
                               'Inclusao',
                               'pes2_rubricasesocial001.php',
                               1,
                               1,
                               'Inclusao',
                               't');


INSERT INTO db_menu
VALUES (
          (SELECT max(id_item)-1
           FROM db_itensmenu),
          (SELECT max(id_item)
           FROM db_itensmenu),
          (SELECT (max(menusequencia)+1)
           FROM db_menu
           WHERE id_item =
               (SELECT max(id_item)-1
                FROM db_itensmenu)
             AND modulo = 952), 952);




INSERT INTO db_itensmenu
VALUES (
          (SELECT max(id_item) + 1
           FROM db_itensmenu), 'Alteracao',
                               'Alteracao',
                               'pes2_rubricasesocial002.php',
                               1,
                               1,
                               'Alteracao',
                               't');


INSERT INTO db_menu
VALUES (
          (SELECT max(id_item)-2
           FROM db_itensmenu),
          (SELECT max(id_item)
           FROM db_itensmenu),
          (SELECT (max(menusequencia)+1)
           FROM db_menu
           WHERE id_item =
               (SELECT max(id_item)-2
                FROM db_itensmenu)
             AND modulo = 952), 952);




INSERT INTO db_itensmenu
VALUES (
          (SELECT max(id_item) + 1
           FROM db_itensmenu), 'Exclusao',
                               'Exclusao',
                               'pes2_rubricasesocial003.php',
                               1,
                               1,
                               'Exclusao',
                               't');


INSERT INTO db_menu
VALUES (
          (SELECT max(id_item)-3
           FROM db_itensmenu),
          (SELECT max(id_item)
           FROM db_itensmenu),
          (SELECT (max(menusequencia)+1)
           FROM db_menu
           WHERE id_item =
               (SELECT max(id_item)-3
                FROM db_itensmenu)
             AND modulo = 952), 952);

TRUNCATE TABLE rubricasesocial CASCADE;

INSERT INTO rubricasesocial
VALUES('1000',
       'Salário, vencimento, soldo ou subsídio');


INSERT INTO rubricasesocial
VALUES('1002',
       'Descanso semanal remunerado - DSR');


INSERT INTO rubricasesocial
VALUES('1003',
       'Horas extraordinárias');


INSERT INTO rubricasesocial
VALUES('1004',
       'Horas extraordinárias - Indenização de banco de horas');


INSERT INTO rubricasesocial
VALUES('1020',
       'Férias - gozadas');


INSERT INTO rubricasesocial
VALUES('1023',
       'Férias - abono pecuniário');


INSERT INTO rubricasesocial
VALUES('1024',
       'Férias - o dobro na vigência do contrato');


INSERT INTO rubricasesocial
VALUES('1040',
       'Licença-prêmio');


INSERT INTO rubricasesocial
VALUES('1041',
       'Licença-prêmio indenizada');


INSERT INTO rubricasesocial
VALUES('1099',
       'Outras verbas salariais');


INSERT INTO rubricasesocial
VALUES('1201',
       'Adicional de função / cargo confiança');


INSERT INTO rubricasesocial
VALUES('1202',
       'Adicional de insalubridade');


INSERT INTO rubricasesocial
VALUES('1203',
       'Adicional de periculosidade');


INSERT INTO rubricasesocial
VALUES('1204',
       'Adicional de transferência');


INSERT INTO rubricasesocial
VALUES('1205',
       'Adicional noturno');


INSERT INTO rubricasesocial
VALUES('1206',
       'Adicional por tempo de serviço(quinquenio, bienio,etc)');


INSERT INTO rubricasesocial
VALUES('1211',
       'assiduidade/produtividade');


INSERT INTO rubricasesocial
VALUES('1212',
       'Gratificações ou outras verbas permanente - (integra remuneração do efetivo)');


INSERT INTO rubricasesocial
VALUES('1213',
       'Gratificações ou outras verbas transitória - (não integra remuneração)');


INSERT INTO rubricasesocial
VALUES('1215',
       'Adicional de unidocência');


INSERT INTO rubricasesocial
VALUES('1299',
       'Outros adicionais');


INSERT INTO rubricasesocial
VALUES('1350',
       'Bolsa de estudo - estagiário');


INSERT INTO rubricasesocial
VALUES('1407',
       'Auxílio-educação');


INSERT INTO rubricasesocial
VALUES('1409',
       'Salário-família');


INSERT INTO rubricasesocial
VALUES('1410',
       'Auxílio - Locais de difícil acesso');


INSERT INTO rubricasesocial
VALUES('1602',
       'Ajuda de custo de transferência');


INSERT INTO rubricasesocial
VALUES('1620',
       'Ressarcimento de despesas pelo uso de veículo próprio');


INSERT INTO rubricasesocial
VALUES('1621',
       'Ressarcimento de despesas de viagem, exceto despesas com veículos');


INSERT INTO rubricasesocial
VALUES('1623',
       'Ressarcimento de provisão (IRRF)');


INSERT INTO rubricasesocial
VALUES('1629',
       'Ressarcimento de outras despesas');


INSERT INTO rubricasesocial
VALUES('1651',
       'Diárias de viagem - até 50% do salário');


INSERT INTO rubricasesocial
VALUES('1652',
       'Diárias de viagem - acima de 50% do salário');


INSERT INTO rubricasesocial
VALUES('1801',
       'Auxílio-alimentação');


INSERT INTO rubricasesocial
VALUES('1805',
       'Auxílio-moradia');


INSERT INTO rubricasesocial
VALUES('1810',
       'Auxílio-transporte');


INSERT INTO rubricasesocial
VALUES('2920',
       'Reembolsos diversos / devolucao de descontos indevidos');


INSERT INTO rubricasesocial
VALUES('2930',
       'Insuficiência de saldo');


INSERT INTO rubricasesocial
VALUES('3501',
       'Remuneração por prestação de serviços(sem vinc. trabalhista)');


INSERT INTO rubricasesocial
VALUES('4050',
       'Salário maternidade');


INSERT INTO rubricasesocial
VALUES('4051',
       'Salário maternidade - 13° salário');


INSERT INTO rubricasesocial
VALUES('5001',
       '13º salário');


INSERT INTO rubricasesocial
VALUES('5005',
       '13° salário complementar/ diferença');


INSERT INTO rubricasesocial
VALUES('5504',
       '13º salário - Adiantamento');


INSERT INTO rubricasesocial
VALUES('6000',
       'Saldo de salários na rescisão contratual');


INSERT INTO rubricasesocial
VALUES('6001',
       '13º salário relativo ao aviso-prévio indenizado');


INSERT INTO rubricasesocial
VALUES('6002',
       '13° salário proporcional na rescisão');


INSERT INTO rubricasesocial
VALUES('6003',
       'Indenização compensatória do aviso-prévio');


INSERT INTO rubricasesocial
VALUES('6004',
       'Férias - o dobro na rescisão');


INSERT INTO rubricasesocial
VALUES('6006',
       'Férias proporcionais');


INSERT INTO rubricasesocial
VALUES('6007',
       'Férias vencidas na rescisão');


INSERT INTO rubricasesocial
VALUES('6101',
       'Indenização compensatória- multa rescisória 20 ou 40% (CF/88) - clt');


INSERT INTO rubricasesocial
VALUES('6102',
       'Indenização do art. 9º lei nº 7.238/84');


INSERT INTO rubricasesocial
VALUES('6104',
       'Indenização do art. 479 da CLT');


INSERT INTO rubricasesocial
VALUES('6106',
       'Multa do art. 477 da CLT');


INSERT INTO rubricasesocial
VALUES('6129',
       'Outras Indenizações - não prevista no manual e-social');


INSERT INTO rubricasesocial
VALUES('6901',
       'Desconto do aviso-prévio (pedido demissão e empregado não cumpriu aviso-prévio)');


INSERT INTO rubricasesocial
VALUES('6904',
       'Multa prevista no art. 480 da CLT');


INSERT INTO rubricasesocial
VALUES('7001',
       'Proventos Aposentados');


INSERT INTO rubricasesocial
VALUES('7002',
       'Proventos - Pensão por morte Civil');


INSERT INTO rubricasesocial
VALUES('9200',
       'Desconto de Adiantamentos (exceto desc. adiant. 13º)');


INSERT INTO rubricasesocial
VALUES('9201',
       'Contribuição Previdenciária');


INSERT INTO rubricasesocial
VALUES('9203',
       'Imposto de renda retido na fonte');


INSERT INTO rubricasesocial
VALUES('9205',
       'Provisão de contribuição previdenciária e IRRF');


INSERT INTO rubricasesocial
VALUES('9209',
       'Faltas ou atrasos');


INSERT INTO rubricasesocial
VALUES('9210',
       'DSR s/faltas e atrasos');


INSERT INTO rubricasesocial
VALUES('9213',
       'Pensão alimentícia');


INSERT INTO rubricasesocial
VALUES('9214',
       '13° salário - desconto de adiantamento');


INSERT INTO rubricasesocial
VALUES('9216',
       'Desconto de vale-transporte');


INSERT INTO rubricasesocial
VALUES('9217',
       'Contribuição a Outras Entidades e Fundos');


INSERT INTO rubricasesocial
VALUES('9218',
       'Retenções judiciais');


INSERT INTO rubricasesocial
VALUES('9219',
       'Desconto de assistência médica ou odontológica');


INSERT INTO rubricasesocial
VALUES('9221',
       'Desconto de férias');


INSERT INTO rubricasesocial
VALUES('9222',
       'Desconto de outros impostos e contribuições');


INSERT INTO rubricasesocial
VALUES('9223',
       'Previdência complementar - parte do empregado(clt)');


INSERT INTO rubricasesocial
VALUES('9225',
       'Previdência complementar - parte do servidor Público');


INSERT INTO rubricasesocial
VALUES('9230',
       'Contribuição Sindical - Compulsória(anual)');


INSERT INTO rubricasesocial
VALUES('9231',
       'Contribuição Sindical - Associativa(mensal)');


INSERT INTO rubricasesocial
VALUES('9232',
       'Contribuição Sindical - Assistencial (custeio das atividades assistenciais do sindicato)');


INSERT INTO rubricasesocial
VALUES('9250',
       'Seguro de vida - desconto');


INSERT INTO rubricasesocial
VALUES('9254',
       'Empréstimos consignados - desconto');


INSERT INTO rubricasesocial
VALUES('9258',
       'Convênios - fornecimento de produtos ou serviços ao empregado, sem pagamento imediato, mas com posterior desconto em folha');


INSERT INTO rubricasesocial
VALUES('9270',
       'Danos e prejuízos causados pelo trabalhador (ex: infração de transito)');


INSERT INTO rubricasesocial
VALUES('9290',
       'Desconto de pagamento indevido em meses anteriores');


INSERT INTO rubricasesocial
VALUES('9299',
       'Outros descontos não previstos nos itens anteriores');


INSERT INTO rubricasesocial
VALUES('9901',
       'Base de cálculo da contribuição previdenciária');


INSERT INTO rubricasesocial
VALUES('9902',
       'Total da base de cálculo do FGTS');


INSERT INTO rubricasesocial
VALUES('9903',
       'Total da base de cálculo do IRRF');


INSERT INTO rubricasesocial
VALUES('9904',
       'Total da base de cálculo do FGTS rescisório');


INSERT INTO rubricasesocial
VALUES('9908',
       'FGTS - depósito');


INSERT INTO rubricasesocial
VALUES('9930',
       'Salário maternidade pago pela Previdência Social');


INSERT INTO rubricasesocial
VALUES('9931',
       '13° salário maternidade pago pela Previdência Social');


INSERT INTO rubricasesocial
VALUES('9932',
       'Auxílio-doença acidentário');


INSERT INTO rubricasesocial
VALUES('9933',
       'Auxílio-doença');


INSERT INTO rubricasesocial
VALUES('9938',
       'Isenção IRRF - 65 anos');


INSERT INTO rubricasesocial
VALUES('9939',
       'Outros valores tributáveis');


INSERT INTO rubricasesocial
VALUES('9989',
       'Outros valores informativos, que não sejam vencimentos nem descontos');


COMMIT;

