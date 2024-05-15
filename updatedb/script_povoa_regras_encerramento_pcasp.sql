CREATE TABLE IF NOT EXISTS "public".aux_regraencerramentonaturezaorcamentaria
(
  c117_sequencial INTEGER
, c117_anousu INTEGER
, c117_instit INTEGER
, c117_contadevedora VARCHAR(15)
, c117_contacredora VARCHAR(15)
);
TRUNCATE TABLE "public".aux_regraencerramentonaturezaorcamentaria;

INSERT INTO "public".aux_regraencerramentonaturezaorcamentaria(c117_sequencial, c117_anousu, c117_instit, c117_contadevedora, c117_contacredora) VALUES (1,1,1,'6221304','5221101');
INSERT INTO "public".aux_regraencerramentonaturezaorcamentaria(c117_sequencial, c117_anousu, c117_instit, c117_contadevedora, c117_contacredora) VALUES (1,1,1,'6314','5311');
INSERT INTO "public".aux_regraencerramentonaturezaorcamentaria(c117_sequencial, c117_anousu, c117_instit, c117_contadevedora, c117_contacredora) VALUES (1,1,1,'6211','6212');
INSERT INTO "public".aux_regraencerramentonaturezaorcamentaria(c117_sequencial, c117_anousu, c117_instit, c117_contadevedora, c117_contacredora) VALUES (1,1,1,'63199','5311');
INSERT INTO "public".aux_regraencerramentonaturezaorcamentaria(c117_sequencial, c117_anousu, c117_instit, c117_contadevedora, c117_contacredora) VALUES (1,1,1,'6221302','6221301');
INSERT INTO "public".aux_regraencerramentonaturezaorcamentaria(c117_sequencial, c117_anousu, c117_instit, c117_contadevedora, c117_contacredora) VALUES (1,1,1,'5221399','5221303');
INSERT INTO "public".aux_regraencerramentonaturezaorcamentaria(c117_sequencial, c117_anousu, c117_instit, c117_contadevedora, c117_contacredora) VALUES (1,1,1,'6221303','6221307');
INSERT INTO "public".aux_regraencerramentonaturezaorcamentaria(c117_sequencial, c117_anousu, c117_instit, c117_contadevedora, c117_contacredora) VALUES (1,1,1,'522190209','5221101');
INSERT INTO "public".aux_regraencerramentonaturezaorcamentaria(c117_sequencial, c117_anousu, c117_instit, c117_contadevedora, c117_contacredora) VALUES (1,1,1,'6221307','5221101');
INSERT INTO "public".aux_regraencerramentonaturezaorcamentaria(c117_sequencial, c117_anousu, c117_instit, c117_contadevedora, c117_contacredora) VALUES (1,1,1,'62211','5221101');
INSERT INTO "public".aux_regraencerramentonaturezaorcamentaria(c117_sequencial, c117_anousu, c117_instit, c117_contadevedora, c117_contacredora) VALUES (1,1,1,'6221301','6221305');
INSERT INTO "public".aux_regraencerramentonaturezaorcamentaria(c117_sequencial, c117_anousu, c117_instit, c117_contadevedora, c117_contacredora) VALUES (1,1,1,'5221201','5221101');
INSERT INTO "public".aux_regraencerramentonaturezaorcamentaria(c117_sequencial, c117_anousu, c117_instit, c117_contadevedora, c117_contacredora) VALUES (1,1,1,'82114','72111');
INSERT INTO "public".aux_regraencerramentonaturezaorcamentaria(c117_sequencial, c117_anousu, c117_instit, c117_contadevedora, c117_contacredora) VALUES (1,1,1,'5317','63171');
INSERT INTO "public".aux_regraencerramentonaturezaorcamentaria(c117_sequencial, c117_anousu, c117_instit, c117_contadevedora, c117_contacredora) VALUES (1,1,1,'6322','5321');
INSERT INTO "public".aux_regraencerramentonaturezaorcamentaria(c117_sequencial, c117_anousu, c117_instit, c117_contadevedora, c117_contacredora) VALUES (1,1,1,'6221305','5221101');

CREATE OR REPLACE FUNCTION cria_regras_encerramento() RETURNS integer AS
$BODY$
DECLARE

    rRecordInstit record;

BEGIN

    delete from regraencerramentonaturezaorcamentaria;

    FOR rRecordInstit IN SELECT DISTINCT codigo FROM db_config
    LOOP

	insert into regraencerramentonaturezaorcamentaria
        select nextval('regraencerramentonaturezaorcamentaria_c117_sequencial_seq'),
        2015,
        rRecordInstit.codigo,
        c117_contadevedora,
        c117_contacredora
        from aux_regraencerramentonaturezaorcamentaria;

    END LOOP;
    RETURN 1;
END
$BODY$
LANGUAGE 'plpgsql' ;

select fc_startsession();
begin;
select cria_regras_encerramento();
commit;