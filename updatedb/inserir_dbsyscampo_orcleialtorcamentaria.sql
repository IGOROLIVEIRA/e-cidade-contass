begin;
select fc_startsession();
insert into db_syscampo values (2011701,'o200_percautorizado','float8','Percentual Autorizado',0,'Percentual Autorizado',14,'f','f','f',4,'text','Percentual Autorizado');
insert into db_sysarqcamp values (2010394,2011701,7,0);
commit;
