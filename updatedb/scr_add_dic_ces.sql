BEGIN;

select fc_startsession();

INSERT INTO db_syscampo values (1009331,'ces01_sequencial','int8','ces01_sequencial',0,'ces01_sequencial',10,'f','f','f',1,'text','ces01_sequencial');
INSERT INTO db_syscampo values (1009332,'ces01_reduz','int8','Reduzido',0,'Reduzido',10,'f','f','f',1,'text','Reduzido');
INSERT INTO db_syscampo values (1009333,'ces01_fonte','int8','Fonte',0,'Fonte',10,'f','f','f',1,'text','Fonte');
INSERT INTO db_syscampo values (1009334,'ces01_valor','float8','Valor',0,'Valor',10,'f','f','f',4,'text','Valor');
INSERT INTO db_syscampo values (1009335,'ces01_anousu','int8','ces01_anousu',0,'ces01_anousu',10,'f','f','f',1,'text','ces01_anousu');
INSERT INTO db_syscampo values (1009336,'ces01_inst','int8','ces01_inst',0,'ces01_inst',10,'f','f','f',1,'text','ces01_inst');
INSERT INTO db_syscampo values (1009337,'ces01_codcon','int8','Plano de contas',0,'Plano de contas',10,'f','f','f',1,'text','Plano de contas');

COMMIT;
