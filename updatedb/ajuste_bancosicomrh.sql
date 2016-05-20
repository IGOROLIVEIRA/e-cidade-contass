begin;

select fc_startsession();
alter table  pessoaflpgo102013 alter column si193_datanascimento DROP NOT NULL;
alter table  pessoaflpgo102013 alter column si193_indsexo DROP NOT NULL;

alter table  pessoaflpgo102014 alter column si193_datanascimento DROP NOT NULL;
alter table  pessoaflpgo102014 alter column si193_indsexo DROP NOT NULL;

alter table  pessoaflpgo102015 alter column si193_datanascimento DROP NOT NULL;
alter table  pessoaflpgo102015 alter column si193_indsexo DROP NOT NULL;

alter table  pessoaflpgo102016 alter column si193_datanascimento DROP NOT NULL;
alter table  pessoaflpgo102016 alter column si193_indsexo DROP NOT NULL;


alter table flpgo102013 alter column si195_nrodocumento type varchar(14);
alter table flpgo102014 alter column si195_nrodocumento type varchar(14);
alter table flpgo102015 alter column si195_nrodocumento type varchar(14);
alter table flpgo102016 alter column si195_nrodocumento type varchar(14);

alter table flpgo112013 alter column si196_nrodocumento type varchar(14);
alter table flpgo112014 alter column si196_nrodocumento type varchar(14);
alter table flpgo112015 alter column si196_nrodocumento type varchar(14);
alter table flpgo112016 alter column si196_nrodocumento type varchar(14);

alter table flpgo122013 alter column si197_nrodocumento type varchar(14);
alter table flpgo122014 alter column si197_nrodocumento type varchar(14);
alter table flpgo122015 alter column si197_nrodocumento type varchar(14);
alter table flpgo122016 alter column si197_nrodocumento type varchar(14);


commit;