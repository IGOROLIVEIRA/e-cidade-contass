<?php

use Classes\PostgresMigration;

class HotFixDuplos extends PostgresMigration
{
  public function up()
  {
    $sql = <<<SQL

        BEGIN;

                                  -- INSERE db_sysarquivo
INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'historicocgm','historico cgm','z09','2021-05-12','historico cgm',0,'f','f','f','f');

-- INSERE db_sysarqmod
INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((select codmod from db_sysmodulo where nomemod like '%protocolo%'), (select max(codarq) from db_sysarquivo));

-- INSERE db_syscampo
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'z09_sequencial'	 		,'int8' ,'Cód. Sequencial'			,'', 'Cód. Sequencial'			 ,11	,false, false, false, 1, 'int8', 'Cód. Sequencial');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'z09_motivo'	 		,'varchar(100)' ,'Motivo da Alteração' ,'', 'Motivo da Alteração'	 ,11	,false, false, false, 1, 'int8', 'Motivo da Alteração');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'z09_usuario'		,'int8' ,'Usuário da sessão'		,'', 'Usuário da sessão'		 ,16	,false, false, false, 0, 'int8', 'Usuário da sessão');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'z09_datacadastro'  		,'date' ,'Data cadastro'				,'', 'Data cadastro'				 ,16	,false, false, false, 1, 'date', 'Data cadastro');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'z09_dataservidor'    		,'date' ,'Link da Obra'			,'', 'Data do servidor'			 ,16	,false, false, false, 0, 'date', 'Data do servidor');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'z09_numcgm'	,'int4' ,' Número do CGM'		,'', ' Número do CGM'		 ,16	,false, false, false, 1, 'int4', ' Número do CGM');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'z09_horaalt'		,'varchar(5)' ,'Hora da alteração do CGM'			,'', 'Hora da alteração do CGM'			 ,16	,false, false, false, 1, 'varchar(5)', 'Hora da alteração do CGM');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'z09_tipo'		,'int4' ,'tipo sicom'	,'', 'tipo sicom'		 ,16	,false, false, false, 1, 'int4', 'tipo sicom');

-- INSERE db_sysarqcamp
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'z09_sequencial')		 	, 1, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'z09_motivo')			 	, 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'z09_usuario')		 	, 3, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'z09_datacadastro')		 	, 4, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'z09_dataservidor')		 	, 5, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'z09_numcgm')			 	, 6, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'z09_horaalt')	 	, 7, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'z09_tipo')		 	, 8, 0);

        COMMIT;
SQL;
    $this->execute($sql);
  }
}
