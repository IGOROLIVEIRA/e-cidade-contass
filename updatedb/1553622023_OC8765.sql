
-- Ocorrência 8765
BEGIN;                   
SELECT fc_startsession();

-- Início do script

--adicionado campos na tabela projecaoatuarial10

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'si168_vlreceitaprevidenciaria', 'float8', 'Valor da receita previdenciária', '0', 'Valor da receita previdenciária', 14, false, false, false, 4, 'text', 'Valor da receita previdenciária');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'si168_vldespesaprevidenciaria', 'float8', 'Valor da despesa previdenciária', '0', 'Valor da despesa previdenciária', 14, false, false, false, 4, 'text', 'Valor da despesa previdenciária');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq like '%projecaoatuarial10%'), (select codcam from db_syscampo where nomecam = 'si168_vlreceitaprevidenciaria'), 5, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq like '%projecaoatuarial10%'), (select codcam from db_syscampo where nomecam = 'si168_vldespesaprevidenciaria'), 6, 0);

ALTER TABLE projecaoatuarial10 ADD COLUMN si168_vlreceitaprevidenciaria bigint;
ALTER TABLE projecaoatuarial10 ADD COLUMN si168_vldespesaprevidenciaria bigint;
ALTER TABLE projecaoatuarial10 ADD COLUMN si168_tipoplano int;

--criando ligacao entre as tabelas e adicionando compos na projecaoatuarial20
ALTER TABLE projecaoatuarial20 ADD COLUMN si169_projecaoatuarial10 bigint;
ALTER TABLE projecaoatuarial20 ADD COLUMN si169_tipoplano int4;
ALTER TABLE projecaoatuarial20 ADD CONSTRAINT fk_projecaotuarial
FOREIGN KEY (si169_projecaoatuarial10) REFERENCES projecaoatuarial10 (si168_sequencial);

-- Fim do script

COMMIT;

