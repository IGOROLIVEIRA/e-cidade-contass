SELECT fc_startsession();

BEGIN;
ALTER TABLE issnotaavulsaservico ADD COLUMN q62_issgruposervico INT;

ALTER TABLE issnotaavulsaservico ADD CONSTRAINT issnotaavulsaservico_issgruposervico_fk
FOREIGN KEY (q62_issgruposervico) REFERENCES issgruposervico(q126_sequencial);


UPDATE issnotaavulsa
SET q51_codautent =
    (SELECT substring(md5(q51_sequencial::varchar||EXTRACT(SECONDS
                                                           FROM NOW())*1000000||'0'),1, 8)
     FROM issnotaavulsa na
     WHERE issnotaavulsa.q51_sequencial = na.q51_sequencial);


insert into db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Nota Avulsa','Nota Avulsa','',1,1,'Tabela','t');
insert into db_menu values (5458,(select max(id_item) from db_itensmenu),(select max(menusequencia)+1 from db_menu where id_item = 5458),5457);

insert into db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Verifica Autenticidade','Verifica Autenticidade','nfseaautentica.php',1,1,'Verifica Autenticidade','t');
insert into db_menu values ((select max(id_item)-1 from db_itensmenu),(select max(id_item) from db_itensmenu),1,5457);

-- parissqn
ALTER TABLE parissqn ADD COLUMN q60_notaavulsalinkautenticacao VARCHAR(200);

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
            (SELECT max(codcam)+1
             FROM db_syscampo), 'q60_notaavulsalinkautenticacao',
                                'varchar(200)',
                                'Link para autenticação da nota avulsa',
                                '',
                                'URL Autenticação',
                                200,
                                FALSE,
                                FALSE,
                                FALSE,
                                0,
                                'text',
                                'URL Aut.');
-- Vínculo tabelas com campos
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (664, (SELECT codcam
                                                                               FROM db_syscampo
                                                                               WHERE nomecam = 'q60_notaavulsalinkautenticacao'),
                                                                         (SELECT max(seqarq) + 1
                                                                          FROM db_sysarqcamp
                                                                          WHERE codarq = 664), 0);
COMMIT;