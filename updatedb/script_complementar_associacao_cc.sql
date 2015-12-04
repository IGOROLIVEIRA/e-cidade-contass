---Script Complementar
begin;
create temp table w_nroregobrig_contacorrente on commit drop as select 1 as nroregobrig, 2 as contacorrente limit 1;
delete from w_nroregobrig_contacorrente;
insert into w_nroregobrig_contacorrente values (11,101),(12,100),(13,101),(14,106),(16,103),(17,103),(18,103);

insert into conplanocontacorrente
SELECT distinct
nextval('conplanocontacorrente_c18_sequencial_seq') c18_sequencial,
c60_codcon,
c61_anousu,
contacorrente
FROM conplanoreduz
INNER JOIN conplano ON conplano.c60_codcon = conplanoreduz.c61_codcon
AND conplano.c60_anousu = conplanoreduz.c61_anousu
INNER JOIN w_nroregobrig_contacorrente ON c60_nregobrig = nroregobrig
LEFT JOIN conplanocontacorrente ON conplanocontacorrente.c18_codcon = conplano.c60_codcon
AND conplanocontacorrente.c18_anousu = conplano.c60_anousu
WHERE c60_nregobrig in (18)
  AND c61_instit = 1
  AND c18_sequencial IS NULL;
commit;