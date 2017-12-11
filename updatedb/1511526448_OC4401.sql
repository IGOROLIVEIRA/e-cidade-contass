
-- Ocorrência 4401
begin;
select fc_startsession();

ALTER TABLE empempenho ADD COLUMN e60_id_usuario int4;
ALTER TABLE empempenho ADD CONSTRAINT empempenho_usuario_fk FOREIGN KEY (e60_id_usuario) REFERENCES db_usuarios;

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES (
    (select max(codcam)+1 from db_syscampo)
    ,'e60_id_usuario'
    ,'int4'
    ,'Código do Usuário'
    ,''
    ,'Cód. do Usuário'
    ,10
    ,false
    ,true
    ,false
    ,0
    ,'text'
    ,'Código do Usuário'
  );

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('e60_numemp')) order by codarq limit 1)
   ,(select codcam from db_syscampo where nomecam = 'e60_id_usuario')
   ,(select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('e60_numemp')) order by codarq limit 1))
   ,0
  );

commit;


begin;
select fc_startsession();

ALTER TABLE empanulado ADD COLUMN e94_id_usuario int4;
ALTER TABLE empanulado ADD CONSTRAINT empanulado_usuario_fk FOREIGN KEY (e94_id_usuario) REFERENCES db_usuarios;

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES (
    (select max(codcam)+1 from db_syscampo)
    ,'e94_id_usuario'
    ,'int4'
    ,'Código do Usuário'
    ,''
    ,'Cód. do Usuário'
    ,10
    ,false
    ,true
    ,false
    ,0
    ,'text'
    ,'Código do Usuário'
  );

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('e94_codanu')) order by codarq limit 1)
   ,(select codcam from db_syscampo where nomecam = 'e94_id_usuario')
   ,(select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('e94_codanu')) order by codarq limit 1))
   ,0
  );

commit;

begin;
select fc_startsession();

ALTER TABLE slip ADD COLUMN k17_id_usuario int4;
ALTER TABLE slip ADD CONSTRAINT slip_usuario_fk FOREIGN KEY (k17_id_usuario) REFERENCES db_usuarios;

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES (
    (select max(codcam)+1 from db_syscampo)
    ,'k17_id_usuario'
    ,'int4'
    ,'Código do Usuário'
    ,''
    ,'Cód. do Usuário'
    ,10
    ,false
    ,true
    ,false
    ,0
    ,'text'
    ,'Código do Usuário'
  );

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('k17_codigo')) order by codarq limit 1)
   ,(select codcam from db_syscampo where nomecam = 'k17_id_usuario')
   ,(select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('k17_codigo')) order by codarq limit 1))
   ,0
  );

commit;
