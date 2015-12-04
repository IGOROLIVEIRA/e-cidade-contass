Begin;
alter table matparam add column m90_sigaf boolean;
alter table transmater add column m63_codcatmat VARCHAR(75);
insert into db_syscampo values ( (select max(codcam)+1 from db_syscampo) ,'m63_codcatmat','varchar(75)','codigo catmat','','CATMAT',2,'t','t','f',0,'text');
Commit;
