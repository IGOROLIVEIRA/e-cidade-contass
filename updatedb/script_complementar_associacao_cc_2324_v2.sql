---Script Complementar
create table  w_conplanocontacorrente_bkp_2016 as select * from conplanocontacorrente;
begin;
create temp table w_nroregobrig_contacorrente on commit drop as select 1 as nroregobrig, 2 as contacorrente limit 1;
delete from w_nroregobrig_contacorrente;
insert into w_nroregobrig_contacorrente values (23,100),(24,3);

delete from conplanocontacorrente where exists (select 1 from conplano where c60_nregobrig = 23 and c18_codcon = c60_codcon);
delete from conplanocontacorrente where c18_contacorrente = 3;

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
WHERE c60_nregobrig in (23,24)
  AND c61_instit = 1
  AND c18_sequencial IS NULL;
commit;