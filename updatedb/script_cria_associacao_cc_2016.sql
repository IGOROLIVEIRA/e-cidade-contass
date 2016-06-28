---Script cria conplanocontacorrente em 2016 baseado em 2015, exceto os registros novos 23 e 24.
select fc_startsession();
begin;
delete from conplanocontacorrente where c18_anousu = 2016 and c18_contacorrente not in (3,100);
insert into conplanocontacorrente select distinct nextval('contabilidade.conplanocontacorrente_c18_sequencial_seq') as c18_sequencial, c18_codcon, 2016 as c18_anousu, c18_contacorrente from conplanocontacorrente where c18_anousu = 2015;
commit;