begin;
select fc_startsession();
	insert into conhistdoc
		select 1011,'INSCRIÇÃO DE RP EM LIQUIDAÇÃO',1000;
	select setval('contabilidade.vinculoeventoscontabeis_c115_sequencial_seq', (select max(c115_sequencial) from vinculoeventoscontabeis));
	insert into vinculoeventoscontabeis 
		select nextval('contabilidade.vinculoeventoscontabeis_c115_sequencial_seq') ,1011,null;
        insert into conhistdoc
		select 2021,'INSCRIÇÃO DE RP EM LIQUIDAÇÃO',2000;
	select setval('contabilidade.vinculoeventoscontabeis_c115_sequencial_seq', (select max(c115_sequencial) from vinculoeventoscontabeis));
	insert into vinculoeventoscontabeis 
		select nextval('contabilidade.vinculoeventoscontabeis_c115_sequencial_seq') ,2021,null;
commit;


