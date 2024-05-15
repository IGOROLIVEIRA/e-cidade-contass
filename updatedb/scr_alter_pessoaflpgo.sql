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

commit;