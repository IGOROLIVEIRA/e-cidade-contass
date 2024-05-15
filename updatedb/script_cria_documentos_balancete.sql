begin;
select fc_startsession();
	insert into conhistdoc
		select 2015,'ABERTURA DEDUCOES RECEITA FUNDEB',2000;
	insert into conhistdoc
		select 2016,'ESTORNO ABERTURA DEDUCOES RECEITA FUNDEB',2001;
	select setval('contabilidade.vinculoeventoscontabeis_c115_sequencial_seq', (select max(c115_sequencial) from vinculoeventoscontabeis));
	insert into vinculoeventoscontabeis
		select nextval('contabilidade.vinculoeventoscontabeis_c115_sequencial_seq') ,2015,2016;
		insert into contrans
			select nextval('contabilidade.contrans_c45_seqtrans_seq'), 2015, 2015,1;
		insert into contranslan
			values(nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
		(select c45_seqtrans from contrans where c45_coddoc = 2015 and c45_anousu = 2015 limit 1),
		2001,'PRIMEIRO LANCAMENTO',0,false,0,'PRIMEIRO LANCAMENTO',1);
		insert into contrans
			select nextval('contabilidade.contrans_c45_seqtrans_seq'), 2015, 2016,1;
		insert into contranslan
			values(nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
		(select c45_seqtrans from contrans where c45_coddoc = 2016 and c45_anousu = 2015 limit 1),
		2001,'PRIMEIRO LANCAMENTO',0,false,0,'PRIMEIRO LANCAMENTO',1);
	insert into conhistdoc
		select 2017,'ABERTURA DEDUCOES RECEITA RENUNCIA',2000;
	insert into conhistdoc
		select 2018,'ESTORNO ABERTURA DEDUCOES RECEITA RENUNCIA',2001;
	select setval('contabilidade.vinculoeventoscontabeis_c115_sequencial_seq', (select max(c115_sequencial) from vinculoeventoscontabeis));
	insert into vinculoeventoscontabeis
		select nextval('contabilidade.vinculoeventoscontabeis_c115_sequencial_seq') ,2017,2018;
		insert into contrans
			select nextval('contabilidade.contrans_c45_seqtrans_seq'), 2015, 2017,1;
		insert into contranslan
			values(nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
		(select c45_seqtrans from contrans where c45_coddoc = 2017 and c45_anousu = 2015 limit 1),
		2001,'PRIMEIRO LANCAMENTO',0,false,0,'PRIMEIRO LANCAMENTO',1);
		insert into contrans
			select nextval('contabilidade.contrans_c45_seqtrans_seq'), 2015, 2018,1;
		insert into contranslan
			values(nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
		(select c45_seqtrans from contrans where c45_coddoc = 2018 and c45_anousu = 2015 limit 1),
		2001,'PRIMEIRO LANCAMENTO',0,false,0,'PRIMEIRO LANCAMENTO',1);
	insert into conhistdoc
		select 2019,'ABERTURA DEMAIS DEDUCOES RECEITA',2000;
	insert into conhistdoc
		select 2020,' ESTORNO ABERTURA DEMAIS DEDUCOES RECEITA',2001;
	select setval('contabilidade.vinculoeventoscontabeis_c115_sequencial_seq', (select max(c115_sequencial) from vinculoeventoscontabeis));
	insert into vinculoeventoscontabeis
		select nextval('contabilidade.vinculoeventoscontabeis_c115_sequencial_seq') ,2019,2020;
		insert into contrans
			select nextval('contabilidade.contrans_c45_seqtrans_seq'), 2015, 2019,1;
		insert into contranslan
			values(nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
		(select c45_seqtrans from contrans where c45_coddoc = 2019 and c45_anousu = 2015 limit 1),
		2001,'PRIMEIRO LANCAMENTO',0,false,0,'PRIMEIRO LANCAMENTO',1);
		insert into contrans
			select nextval('contabilidade.contrans_c45_seqtrans_seq'), 2015, 2020,1;
		insert into contranslan
			values(nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
		(select c45_seqtrans from contrans where c45_coddoc = 2020 and c45_anousu = 2015 limit 1),
		2001,'PRIMEIRO LANCAMENTO',0,false,0,'PRIMEIRO LANCAMENTO',1);
	insert into conhistdoc
		select 2009,'INSCRICAO RP NAO PROCESSADOS EXE ANTERIORES',2000;
	insert into conhistdoc
		select 2010,'EST INSCRICAO RP NAO PROCESSADOS EXE ANTERIORES',2001;
	select setval('contabilidade.vinculoeventoscontabeis_c115_sequencial_seq', (select max(c115_sequencial) from vinculoeventoscontabeis));
	insert into vinculoeventoscontabeis
		select nextval('contabilidade.vinculoeventoscontabeis_c115_sequencial_seq') ,2009,2010;
		insert into contrans
			select nextval('contabilidade.contrans_c45_seqtrans_seq'), 2015, 2009,1;
		insert into contranslan
			values(nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
		(select c45_seqtrans from contrans where c45_coddoc = 2009 and c45_anousu = 2015 limit 1),
		2001,'PRIMEIRO LANCAMENTO',0,false,0,'PRIMEIRO LANCAMENTO',1);
		insert into contrans
			select nextval('contabilidade.contrans_c45_seqtrans_seq'), 2015, 2010,1;
		insert into contranslan
			values(nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
		(select c45_seqtrans from contrans where c45_coddoc = 2010 and c45_anousu = 2015 limit 1),
		2001,'PRIMEIRO LANCAMENTO',0,false,0,'PRIMEIRO LANCAMENTO',1);
	insert into conhistdoc
		select 2011,'INSCRICAO RP PROCESSADOS EXERC. ANTER.',2000;
	insert into conhistdoc
		select 2012,'EST INSCRICAO RP PROCESSADOS EXERC. ANTER.',2001;
	select setval('contabilidade.vinculoeventoscontabeis_c115_sequencial_seq', (select max(c115_sequencial) from vinculoeventoscontabeis));
	insert into vinculoeventoscontabeis
		select nextval('contabilidade.vinculoeventoscontabeis_c115_sequencial_seq') ,2011,2012;
		insert into contrans
			select nextval('contabilidade.contrans_c45_seqtrans_seq'), 2015, 2011,1;
		insert into contranslan
			values(nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
		(select c45_seqtrans from contrans where c45_coddoc = 2011 and c45_anousu = 2015 limit 1),
		2001,'PRIMEIRO LANCAMENTO',0,false,0,'PRIMEIRO LANCAMENTO',1);
		insert into contrans
			select nextval('contabilidade.contrans_c45_seqtrans_seq'), 2015, 2012,1;
		insert into contranslan
			values(nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
		(select c45_seqtrans from contrans where c45_coddoc = 2012 and c45_anousu = 2015 limit 1),
		2001,'PRIMEIRO LANCAMENTO',0,false,0,'PRIMEIRO LANCAMENTO',1);
COMMIT;

