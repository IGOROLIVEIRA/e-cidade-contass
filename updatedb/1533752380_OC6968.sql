
-- Ocorrência 6968 - SCRIPT 03


-- Início do script
BEGIN;
SELECT fc_startsession();

create or replace
 function fc_duplicarelat6968(numreg int, codparamrel int) returns void as $$

   DECLARE reg record;

   begin
   -- realiza um loop e busca todos os registros
   for reg in (
    SELECT o69_codseq FROM orcparamseq WHERE o69_codparamrel = codparamrel
   )loop


   INSERT
    INTO orcparamseq (o69_codparamrel, o69_codseq, o69_descr, o69_grupo, o69_grupoexclusao, o69_nivel, o69_libnivel,
                      o69_librec, o69_libsubfunc, o69_libfunc, o69_verificaano, o69_labelrel, o69_manual,
                      o69_totalizador, o69_ordem, o69_nivellinha, o69_observacao, o69_desdobrarlinha, o69_origem)
    VALUES(
      numreg,
      (SELECT o69_codseq FROM orcparamseq WHERE o69_codparamrel = codparamrel AND o69_codseq = reg.o69_codseq),
      (SELECT o69_descr FROM orcparamseq WHERE o69_codparamrel = codparamrel AND o69_codseq = reg.o69_codseq),
      (SELECT o69_grupo FROM orcparamseq WHERE o69_codparamrel = codparamrel AND o69_codseq = reg.o69_codseq),
      (SELECT o69_grupoexclusao FROM orcparamseq WHERE o69_codparamrel = codparamrel AND o69_codseq = reg.o69_codseq),
      (SELECT o69_nivel FROM orcparamseq WHERE o69_codparamrel = codparamrel AND o69_codseq = reg.o69_codseq),
      (SELECT o69_libnivel FROM orcparamseq WHERE o69_codparamrel = codparamrel AND o69_codseq = reg.o69_codseq),
      (SELECT o69_librec FROM orcparamseq WHERE o69_codparamrel = codparamrel AND o69_codseq = reg.o69_codseq),
      (SELECT o69_libsubfunc FROM orcparamseq WHERE o69_codparamrel = codparamrel AND o69_codseq = reg.o69_codseq),
      (SELECT o69_libfunc FROM orcparamseq WHERE o69_codparamrel = codparamrel AND o69_codseq = reg.o69_codseq),
      (SELECT o69_verificaano FROM orcparamseq WHERE o69_codparamrel = codparamrel AND o69_codseq = reg.o69_codseq),
      (SELECT o69_labelrel FROM orcparamseq WHERE o69_codparamrel = codparamrel AND o69_codseq = reg.o69_codseq),
      (SELECT o69_manual FROM orcparamseq WHERE o69_codparamrel = codparamrel AND o69_codseq = reg.o69_codseq),
      (SELECT o69_totalizador FROM orcparamseq WHERE o69_codparamrel = codparamrel AND o69_codseq = reg.o69_codseq),
      (SELECT o69_ordem FROM orcparamseq WHERE o69_codparamrel = codparamrel AND o69_codseq = reg.o69_codseq),
      (SELECT o69_nivellinha FROM orcparamseq WHERE o69_codparamrel = codparamrel AND o69_codseq = reg.o69_codseq),
      (SELECT o69_observacao FROM orcparamseq WHERE o69_codparamrel = codparamrel AND o69_codseq = reg.o69_codseq),
      (SELECT o69_desdobrarlinha FROM orcparamseq WHERE o69_codparamrel = codparamrel AND o69_codseq = reg.o69_codseq),
      (SELECT o69_origem FROM orcparamseq WHERE o69_codparamrel = codparamrel AND o69_codseq = reg.o69_codseq)
    );

   end loop;
end
$$
language plpgsql;
COMMIT;



BEGIN;
SELECT fc_startsession();
create or replace
 function fc_duplicarelat() returns void as $$

   DECLARE reg record;
    aux int:=-1;
    numreg int:=0;
    a integer[] := array[145,81,148,88,146,147,105,149,106,107,87,89,90,91,92,108,109,93];
    i integer;

   BEGIN
   -- realiza um loop e busca todos os registros
   FOREACH i IN ARRAY a loop

   IF aux <> numreg
    THEN aux := numreg;
     numreg := (SELECT max(o69_codparamrel) + 1 FROM orcparamseq WHERE o69_codparamrel not in (4000003));
   END IF;

   PERFORM fc_duplicarelat6968(numreg, i);

   end loop;
end
$$
language plpgsql;
COMMIT;


BEGIN;
 SELECT fc_startsession();
 SELECT fc_duplicarelat();
COMMIT;

-- Fim do script