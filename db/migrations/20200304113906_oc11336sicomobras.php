<?php

use Phinx\Migration\AbstractMigration;

class Oc11336sicomobras extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
      $sql = <<<SQL

        BEGIN;

        select fc_startsession();

        insert into db_itensmenu(id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente) values ( (select max(id_item)+1 from db_itensmenu) ,'Obras','Obras','con4_gerarobra.php','1','1','Obras','true');
        insert into db_menu(id_item,id_item_filho,menusequencia,modulo) values (8987,(select max(id_item) from db_itensmenu),458,2000018);

                --TABELA PESSOAOBRA102020


                -- INSERE db_sysarquivo
                INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'pessoasobra102020','cadastro pessoas obra','si194','2019-12-21','cadastro pessoas obra',0,'f','f','f','f');

                  -- INSERE db_sysarqmod
                INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((select codmod from db_sysmodulo where nomemod like '%sicom%'), (select max(codarq) from db_sysarquivo));

                -- INSERE db_syscampo
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si194_sequencial'             ,'int8' ,'Sequencial'                   ,'', 'Sequencial'                       ,11     ,false, false, false, 1, 'int8', 'Sequencial');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si194_tiporegistro'           ,'int8' ,'Tiporegistro'                 ,'', 'Tiporegistro'                     ,11     ,false, false, false, 1, 'int8', 'Tiporegistro');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si194_nrodocumento'           ,'text' ,'Numero Documento'             ,'', 'Numero Documento'                 ,14     ,false, false, false, 0, 'int4', 'Numero Documento');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si194_nome'                   ,'text' ,'Nome'                         ,'', 'Nome'                             ,120    ,false, false, false, 0, 'text', 'Nome');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si194_tipocadastro'           ,'int4' ,'Tipo Cadastro'                ,'', 'Tipo Cadastro'                    ,10     ,false, false, false, 0, 'int4', 'Tipo Cadastro');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si194_justificativaalteracao' ,'text' ,'Justificativa Alteracao'      ,'', 'Justificativa Alteracao'          ,100    ,false, false, false, 0, 'text', 'Justificativa Alteracao');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si194_mes'                    ,'int4' ,'Mes'                          ,'', 'Mes'                              ,10     ,false, false, false, 0, 'int4', 'Mes');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si194_instit'                 ,'int4' ,'Instituição'                  ,'', 'Instituição'                      ,10     ,false, false, false, 0, 'int4', 'Instituição');

                -- INSERE db_sysarqcamp
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si194_sequencial')            , 1, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si194_tiporegistro')          , 2, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si194_nrodocumento')          , 3, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si194_nome')                  , 4, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si194_tipocadastro')          , 5, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si194_justificativaalteracao'), 6, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si194_mes')                   , 7, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si194_instit')                , 8, 0);


                CREATE TABLE pessoasobra102020(
                si194_sequencial                int8  ,
                si194_tiporegistro              int8  ,
                si194_nrodocumento              varchar(14)  ,
                si194_nome                      varchar(120)  ,
                si194_tipocadastro              int8  ,
                si194_justificativaalteracao    text  ,
                si194_mes                       int8  ,
                si194_instit                    int4);

                CREATE SEQUENCE pessoasobra102020_si194_sequencial_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;

                --TABELA LICOBRAS102020

                  -- INSERE db_sysarquivo
                INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'licobras102020','Detalhamento da Dispensa ou Inexigibilidade','si195','2019-12-21','Detalhamento da Dispensa ou Inexigibilidade',0,'f','f','f','f');

                  -- INSERE db_sysarqmod
                INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((select codmod from db_sysmodulo where nomemod like '%sicom%'), (select max(codarq) from db_sysarquivo));

                -- INSERE db_syscampo
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si195_sequencial'               ,'int8' ,'Sequencial'                   ,'', 'Sequencial'                       ,11     ,false, false, false, 1, 'int8', 'Sequencial');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si195_tiporegistro'             ,'int8' ,'Tiporegistro'                 ,'', 'Tiporegistro'                     ,2      ,false, false, false, 1, 'int8', 'Tiporegistro');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si195_codorgaoresp'             ,'text' ,'codorgaoresp'                 ,'', 'codorgaoresp'                     ,3      ,false, false, false, 1, 'int8', 'codorgaoresp');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si195_codunidadesubrespestadual','text' ,'codUnidadeSubRespEstadual'    ,'', 'codUnidadeSubRespEstadual'        ,4      ,false, false, false, 0, 'int4', 'codUnidadeSubRespEstadual');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si195_exerciciolicitacao'       ,'int4' ,'exercicioLicitacao'           ,'', 'exercicioLicitacao'               ,4      ,false, false, false, 0, 'int4', 'exercicioLicitacao');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si195_nroprocessolicitatorio'   ,'text' ,'nroProcessoLicitatorio'       ,'', 'nroProcessoLicitatorio'           ,12     ,false, false, false, 0, 'text', 'nroProcessoLicitatorio');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si195_codobra'                  ,'int8' ,'codigoobra'                   ,'', 'codigoobra'                       ,20     ,false, false, false, 0, 'int8', 'codigoobra');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si195_objeto'                   ,'text' ,'objeto'                       ,'', 'objeto'                           ,1000   ,false, false, false, 0, 'text', 'objeto');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si195_linkobra'                 ,'text' ,'linkobra'                     ,'', 'linkobra'                         ,200    ,false, false, false, 0, 'text', 'linkobra');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si195_mes'                      ,'int4' ,'Mes'                          ,'', 'Mes'                              ,10     ,false, false, false, 0, 'int4', 'Mes');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si195_instit'                   ,'int4' ,'Instituição'                  ,'', 'Instituição'                      ,10     ,false, false, false, 0, 'int4', 'Instituição');

                -- INSERE db_sysarqcamp
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si195_sequencial')                   , 1, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si195_tiporegistro')                 , 2, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si195_codorgaoresp')                 , 3, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si195_codunidadesubrespestadual')    , 4, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si195_exerciciolicitacao')           , 5, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si195_nroprocessolicitatorio')       , 6, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si195_codobra')                      , 7, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si195_objeto')                       , 8, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si195_linkobra')                     , 9, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si195_mes')                          , 10, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si195_instit')                       , 11, 0);


                CREATE TABLE licobras102020(
                si195_sequencial                int8,
                si195_tiporegistro              int8,
                si195_codorgaoresp              varchar(3),
                si195_codunidadesubrespestadual varchar(4),
                si195_exerciciolicitacao        int8,
                si195_nroprocessolicitatorio    varchar(12),
                si195_codobra                   int8,
                si195_objeto                    text,
                si195_linkobra                  text,
                si195_mes                       int8,
                si195_instit                    int4);

                CREATE SEQUENCE licobras102020_si195_sequencial_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;

                --TABELA LICOBRAS202020

                  -- INSERE db_sysarquivo
                INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'licobras202020','cadastro de obras','si196','2019-12-21','cadastro de obras',0,'f','f','f','f');

                  -- INSERE db_sysarqmod
                INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((select codmod from db_sysmodulo where nomemod like '%sicom%'), (select max(codarq) from db_sysarquivo));

                -- INSERE db_syscampo
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si196_sequencial'               ,'int8' ,'Sequencial'                   ,'', 'Sequencial'                       ,11     ,false, false, false, 1, 'int8', 'Sequencial');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si196_tiporegistro'             ,'int8' ,'Tiporegistro'                 ,'', 'Tiporegistro'                     ,2      ,false, false, false, 1, 'int8', 'Tiporegistro');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si196_codorgaoresp'             ,'text' ,'codorgaoresp'                 ,'', 'codorgaoresp'                     ,3      ,false, false, false, 1, 'int8', 'codorgaoresp');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si196_codunidadesubrespestadual','text' ,'codUnidadeSubRespEstadual'    ,'', 'codUnidadeSubRespEstadual'        ,4      ,false, false, false, 0, 'int4', 'codUnidadeSubRespEstadual');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si196_exerciciolicitacao'       ,'int4' ,'exercicioLicitacao'           ,'', 'exercicioLicitacao'               ,4      ,false, false, false, 0, 'int4', 'exercicioLicitacao');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si196_nroprocessolicitatorio'   ,'text' ,'nroProcessoLicitatorio'       ,'', 'nroProcessoLicitatorio'           ,12     ,false, false, false, 0, 'text', 'nroProcessoLicitatorio');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si196_tipoprocesso'             ,'int4' ,'tipoProcesso'                 ,'', 'tipoProcesso'                     ,10     ,false, false, false, 0, 'int4', 'tipoProcesso');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si196_codobra'                  ,'int8' ,'codigoobra'                   ,'', 'codigoobra'                       ,20     ,false, false, false, 0, 'int8', 'codigoobra');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si196_objeto'                   ,'text' ,'objeto'                       ,'', 'objeto'                           ,1000   ,false, false, false, 0, 'text', 'objeto');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si196_linkobra'                 ,'text' ,'linkobra'                     ,'', 'linkobra'                         ,200    ,false, false, false, 0, 'text', 'linkobra');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si196_mes'                      ,'int4' ,'Mes'                          ,'', 'Mes'                              ,10     ,false, false, false, 0, 'int4', 'Mes');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si196_instit'                   ,'int4' ,'Instituição'                  ,'', 'Instituição'                      ,10     ,false, false, false, 0, 'int4', 'Instituição');

                -- INSERE db_sysarqcamp
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si196_sequencial')                   , 1, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si196_tiporegistro')                 , 2, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si196_codorgaoresp')                 , 3, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si196_codunidadesubrespestadual')    , 4, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si196_exerciciolicitacao')           , 5, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si196_nroprocessolicitatorio')       , 6, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si196_tipoprocesso')                 , 7, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si196_codobra')                      , 8, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si196_objeto')                       , 9, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si196_linkobra')                     , 10, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si196_mes')                          , 11, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si196_instit')                       , 12, 0);


                CREATE TABLE licobras202020(
                si196_sequencial                int8,
                si196_tiporegistro              int8,
                si196_codorgaoresp              varchar(3),
                si196_codunidadesubrespestadual varchar(4),
                si196_exerciciolicitacao        int8,
                si196_nroprocessolicitatorio    varchar(12),
                si196_tipoprocesso              int4,
                si196_codobra                   int8,
                si196_objeto                    text,
                si196_linkobra                  text,
                si196_mes                       int8,
                si196_instit                    int4);

                CREATE SEQUENCE licobras202020_si196_sequencial_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;



                --TABELA exeobras102020

                  -- INSERE db_sysarquivo
                INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'exeobras102020','execucao de obras','si197','2019-12-21','execucao de obras',0,'f','f','f','f');

                  -- INSERE db_sysarqmod
                INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((select codmod from db_sysmodulo where nomemod like '%sicom%'), (select max(codarq) from db_sysarquivo));

                -- INSERE db_syscampo
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si197_sequencial'               ,'int8' ,'Sequencial'                   ,'', 'Sequencial'                       ,11     ,false, false, false, 1, 'int8', 'Sequencial');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si197_tiporegistro'             ,'int8' ,'Tiporegistro'                 ,'', 'Tiporegistro'                     ,2      ,false, false, false, 1, 'int8', 'Tiporegistro');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si197_codorgao'                 ,'text' ,'codorgaoresp'                 ,'', 'codorgaoresp'                     ,3      ,false, false, false, 1, 'int8', 'codorgaoresp');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si197_codunidadesub'            ,'text' ,'codUnidadeSubRespEstadual'    ,'', 'codUnidadeSubRespEstadual'        ,4      ,false, false, false, 0, 'int4', 'codUnidadeSubRespEstadual');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si197_nrocontrato'              ,'int8' ,'nroContrato'                  ,'', 'nroContrato'                      ,14     ,false, false, false, 0, 'int8', 'nroContrato');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si197_exerciciolicitacao'       ,'int4' ,'exercicioLicitacao'           ,'', 'exercicioLicitacao'               ,4      ,false, false, false, 0, 'int4', 'exercicioLicitacao');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si197_codobra'                  ,'int8' ,'codigoobra'                   ,'', 'codigoobra'                       ,20     ,false, false, false, 0, 'int8', 'codigoobra');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si197_objeto'                   ,'text' ,'objeto'                       ,'', 'objeto'                           ,1000   ,false, false, false, 0, 'text', 'objeto');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si197_linkobra'                 ,'text' ,'linkobra'                     ,'', 'linkobra'                         ,200    ,false, false, false, 0, 'text', 'linkobra');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si197_mes'                      ,'int4' ,'Mes'                          ,'', 'Mes'                              ,10     ,false, false, false, 0, 'int4', 'Mes');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si197_instit'                   ,'int4' ,'Instituição'                  ,'', 'Instituição'                      ,10     ,false, false, false, 0, 'int4', 'Instituição');

                -- INSERE db_sysarqcamp
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si197_sequencial')                   , 1, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si197_tiporegistro')                 , 2, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si197_codorgao'    )                 , 3, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si197_codunidadesub')                , 4, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si197_nrocontrato')                  , 5, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si197_exerciciolicitacao')           , 6, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si197_codobra')                      , 7, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si197_objeto')                       , 8, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si197_linkobra')                     , 9, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si197_mes')                          , 10, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si197_instit')                       , 11, 0);


                CREATE TABLE exeobras102020(
                si197_sequencial                int8,
                si197_tiporegistro              int8,
                si197_codorgao                  varchar(3),
                si197_codunidadesub             varchar(8),
                si197_nrocontrato               int8,
                si197_exerciciolicitacao        int8,
                si197_codobra                   int8,
                si197_objeto                    text,
                si197_linkobra                  text,
                si197_mes                       int8,
                si197_instit                    int4);

                CREATE SEQUENCE exeobras102020_si197_sequencial_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;


                --TABELA cadobras102020

                  -- INSERE db_sysarquivo
                INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'cadobras102020','detalhamento dos responsaveis','si198','2019-12-21','detalhamento dos responsaveis',0,'f','f','f','f');

                  -- INSERE db_sysarqmod
                INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((select codmod from db_sysmodulo where nomemod like '%sicom%'), (select max(codarq) from db_sysarquivo));

                -- INSERE db_syscampo
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si198_sequencial'               ,'int8' ,'Sequencial'                   ,'', 'Sequencial'                       ,11     ,false, false, false, 1, 'int8', 'Sequencial');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si198_tiporegistro'             ,'int8' ,'Tiporegistro'                 ,'', 'Tiporegistro'                     ,2      ,false, false, false, 1, 'int8', 'Tiporegistro');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si198_codorgaoresp'             ,'text' ,'codorgaoresp'                 ,'', 'codorgaoresp'                     ,3      ,false, false, false, 1, 'int8', 'codorgaoresp');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si198_codobra'                  ,'int8' ,'codigoobra'                   ,'', 'codigoobra'                       ,20     ,false, false, false, 0, 'int8', 'codigoobra');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si198_tiporesponsavel'          ,'int8' ,'Tipo responsavel'             ,'', 'Tipo responsavel'                 ,1      ,false, false, false, 1, 'int8', 'Tipo responsavel');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si198_nrodocumento'             ,'text' ,'Numero Documento'             ,'', 'Numero Documento'                 ,14     ,false, false, false, 0, 'int4', 'Numero Documento');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si198_tiporegistroconselho'     ,'int8' ,'tipoRegistroConselho'         ,'', 'tipoRegistroConselho'             ,1      ,false, false, false, 1, 'int8', 'tipoRegistroConselho');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si198_nroregistroconseprof'     ,'text' ,'nroregistroconseprof'         ,'', 'nroregistroconseprof'             ,10     ,false, false, false, 0, 'int4', 'nroregistroconseprof');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si198_numrt'                    ,'int8' ,'numRT'                        ,'', 'numRT'                            ,13     ,false, false, false, 0, 'int8', 'numRT');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si198_dtinicioatividadeseng'    ,'date' ,'dtinicioatividadeseng'        ,'', 'dtinicioatividadeseng'            ,10     ,false, false, false, 0, 'int4', 'dtinicioatividadeseng');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si198_tipovinculo'              ,'int8' ,'Tipovinculo'                  ,'', 'Tipovinculo'                      ,2      ,false, false, false, 1, 'int8', 'Tipovinculo');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si198_mes'                      ,'int4' ,'Mes'                          ,'', 'Mes'                              ,10     ,false, false, false, 0, 'int4', 'Mes');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si198_instit'                   ,'int4' ,'Instituição'                  ,'', 'Instituição'                      ,10     ,false, false, false, 0, 'int4', 'Instituição');


                -- INSERE db_sysarqcamp
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si198_sequencial')                   , 1, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si198_tiporegistro')                 , 2, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si198_codorgaoresp')                 , 3, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si198_codobra')                      , 4, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si198_tiporesponsavel')              , 5, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si198_nrodocumento')                 , 6, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si198_tiporegistroconselho')         , 7, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si198_nroregistroconseprof')         , 8, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si198_numrt')                        , 9, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si198_dtinicioatividadeseng')        , 10, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si198_tipovinculo')                  , 11, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si198_mes')                          , 12, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si198_instit')                       , 13, 0);


                CREATE TABLE cadobras102020(
                si198_sequencial                int8,
                si198_tiporegistro              int8,
                si198_codorgaoresp              varchar(3),
                si198_codobra                   int8,
                si198_tiporesponsavel           int8,
                si198_nrodocumento              varchar(14),
                si198_tiporegistroconselho      int8,
                si198_nroregistroconseprof      varchar(10),
                si198_numrt                     int8,
                si198_dtinicioatividadeseng     date,
                si198_tipovinculo               int8,
                si198_mes                       int8,
                si198_instit                    int4);

                CREATE SEQUENCE cadobras102020_si198_sequencial_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;


                --TABELA cadobras202020

                  -- INSERE db_sysarquivo
                INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'cadobras202020','execucao do objeto','si199','2019-12-21','execucao do objeto',0,'f','f','f','f');

                  -- INSERE db_sysarqmod
                INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((select codmod from db_sysmodulo where nomemod like '%sicom%'), (select max(codarq) from db_sysarquivo));

                -- INSERE db_syscampo
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si199_sequencial'               ,'int8' ,'Sequencial'                   ,'', 'Sequencial'                       ,11     ,false, false, false, 1, 'int8', 'Sequencial');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si199_tiporegistro'             ,'int8' ,'Tiporegistro'                 ,'', 'Tiporegistro'                     ,2      ,false, false, false, 1, 'int8', 'Tiporegistro');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si199_codorgaoresp'             ,'text' ,'codorgaoresp'                 ,'', 'codorgaoresp'                     ,3      ,false, false, false, 1, 'int8', 'codorgaoresp');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si199_codobra'                  ,'int8' ,'codigoobra'                   ,'', 'codigoobra'                       ,20     ,false, false, false, 0, 'int8', 'codigoobra');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si199_situacaodaobra'           ,'int8' ,'situacao da obra'             ,'', 'situacao da obra'                 ,1      ,false, false, false, 1, 'int8', 'situacao da obra');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si199_dtsituacao'               ,'date' ,'dtsituacao'                   ,'', 'dtsituacao'                       ,10     ,false, false, false, 0, 'date', 'dtsituacao');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si199_veiculopublicacao'        ,'text' ,'viculo publicacao'            ,'', 'viculo publicacao'                ,50     ,false, false, false, 1, 'text', 'viculo publicacao');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si199_dtpublicacao'             ,'date' ,'dtpublicacao'                 ,'', 'dtpublicacao'                     ,10     ,false, false, false, 0, 'date', 'dtpublicacao');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si199_descsituacao'             ,'text' ,'desc situacao obra'           ,'', 'desc situacao obra'               ,500    ,false, false, false, 0, 'text', 'desc situacao obra');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si199_mes'                      ,'int4' ,'Mes'                          ,'', 'Mes'                              ,10     ,false, false, false, 0, 'int4', 'Mes');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si199_instit'                   ,'int4' ,'Instituição'                  ,'', 'Instituição'                      ,10     ,false, false, false, 0, 'int4', 'Instituição');


                -- INSERE db_sysarqcamp
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si199_sequencial')                   , 1, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si199_tiporegistro')                 , 2, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si199_tiporegistro')                 , 3, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si199_codobra')                      , 4, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si199_situacaodaobra')               , 5, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si199_dtsituacao')                   , 6, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si199_veiculopublicacao')            , 7, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si199_dtpublicacao')                 , 8, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si199_descsituacao')                 , 9, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si199_mes')                          , 10, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si199_instit')                       , 11, 0);


                CREATE TABLE cadobras202020(
                si199_sequencial                int8,
                si199_tiporegistro              int8,
                si199_codorgaoresp              varchar(3),
                si199_codobra                   int8,
                si199_situacaodaobra            int8,
                si199_dtsituacao                date,
                si199_veiculopublicacao         varchar(50),
                si199_dtpublicacao              date,
                si199_descsituacao              varchar(500),
                si199_mes                       int8,
                si199_instit                    int4);

                CREATE SEQUENCE cadobras202020_si199_sequencial_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;


                --TABELA cadobras212020

                -- INSERE db_sysarquivo
                INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'cadobras212020','detalhamento da paralisacao','si200','2019-12-21','detalhamento da paralisacao',0,'f','f','f','f');

                -- INSERE db_sysarqmod
                INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((select codmod from db_sysmodulo where nomemod like '%sicom%'), (select max(codarq) from db_sysarquivo));

                -- INSERE db_syscampo
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si200_sequencial'               ,'int8' ,'Sequencial'                   ,'', 'Sequencial'                       ,11     ,false, false, false, 1, 'int8', 'Sequencial');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si200_tiporegistro'             ,'int8' ,'Tiporegistro'                 ,'', 'Tiporegistro'                     ,2      ,false, false, false, 1, 'int8', 'Tiporegistro');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si200_codorgaoresp'             ,'text' ,'codorgaoresp'                 ,'', 'codorgaoresp'                     ,3      ,false, false, false, 1, 'int8', 'codorgaoresp');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si200_codobra'                  ,'int8' ,'codigoobra'                   ,'', 'codigoobra'                       ,20     ,false, false, false, 0, 'int8', 'codigoobra');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si200_dtparalisacao'            ,'date' ,'dtparalisacao'                ,'', 'dtparalisacao'                    ,10     ,false, false, false, 0, 'date', 'dtparalisacao');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si200_motivoparalisacap'        ,'int8' ,'motivo paralisacao'           ,'', 'motivo paralisacao'               ,2      ,false, false, false, 1, 'int8', 'motivo paralisacao');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si200_descoutrosparalisacao'    ,'text' ,'desc outros paralisacao'      ,'', 'desc outros paralisacao'          ,150    ,false, false, false, 1, 'text', 'desc outros paralisacao');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si200_dtretomada'               ,'date' ,'dtretomada'                   ,'', 'dtretomada'                       ,10     ,false, false, false, 0, 'date', 'dtretomada');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si200_mes'                      ,'int4' ,'Mes'                          ,'', 'Mes'                              ,10     ,false, false, false, 0, 'int4', 'Mes');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si200_instit'                   ,'int4' ,'Instituição'                  ,'', 'Instituição'                      ,10     ,false, false, false, 0, 'int4', 'Instituição');


                -- INSERE db_sysarqcamp
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si200_sequencial')                   , 1, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si200_tiporegistro')                 , 2, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si200_codorgaoresp')                 , 3, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si200_codobra')                      , 4, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si200_dtparalisacao')                , 5, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si200_motivoparalisacap')            , 6, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si200_descoutrosparalisacao')        , 7, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si200_dtretomada')                   , 8, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si200_mes')                          , 9, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si200_instit')                       , 10, 0);

                CREATE TABLE cadobras212020(
                si200_sequencial                int8,
                si200_tiporegistro              int8,
                si200_codorgaoresp              varchar(3),
                si200_codobra                   int8,
                si200_dtparalisacao             date,
                si200_motivoparalisacap         int8,
                si200_descoutrosparalisacao     varchar(150),
                si200_dtretomada                date,
                si200_mes                       int8,
                si200_instit                    int4);

                CREATE SEQUENCE cadobras212020_si200_sequencial_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;


                --TABELA cadobras302020

                -- INSERE db_sysarquivo
                INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'cadobras302020','detalhamento da medicao','si201','2019-12-21','detalhamento da medicao',0,'f','f','f','f');

                -- INSERE db_sysarqmod
                INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((select codmod from db_sysmodulo where nomemod like '%sicom%'), (select max(codarq) from db_sysarquivo));

                -- INSERE db_syscampo
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si201_sequencial'               ,'int8' ,'Sequencial'                   ,'', 'Sequencial'                       ,11     ,false, false, false, 1, 'int8', 'Sequencial');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si201_tiporegistro'             ,'int8' ,'Tiporegistro'                 ,'', 'Tiporegistro'                     ,2      ,false, false, false, 1, 'int8', 'Tiporegistro');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si201_codorgaoresp'             ,'text' ,'codorgaoresp'                 ,'', 'codorgaoresp'                     ,3      ,false, false, false, 1, 'int8', 'codorgaoresp');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si201_codobra'                  ,'int8' ,'codigoobra'                   ,'', 'codigoobra'                       ,20     ,false, false, false, 0, 'int8', 'codigoobra');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si201_tipomedicao'              ,'int8' ,'tipo medicao'                 ,'', 'tipo medicao'                     ,2      ,false, false, false, 1, 'int8', 'tipo medicao');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si201_descoutrostiposmed'       ,'text' ,'desc outros tipos medicao'    ,'', 'desc outros tipos medicao'        ,500    ,false, false, false, 1, 'text', 'desc outros tipos medicao');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si201_nummedicao'               ,'text' ,'numero medicao'               ,'', 'numero medicao'                   ,20     ,false, false, false, 1, 'text', 'numero medicao');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si201_descmedicao'              ,'text' ,'desc medicao'                 ,'', 'desc medicao'                     ,500    ,false, false, false, 1, 'text', 'desc  medicao');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si201_dtiniciomedicao'          ,'date' ,'data inicio'                  ,'', 'data incio'                       ,10     ,false, false, false, 0, 'date', 'data inicio');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si201_dtfimmedicao'             ,'date' ,'data fim'                     ,'', 'data fim'                         ,10     ,false, false, false, 0, 'date', 'data fim');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si201_dtmedicao'                ,'date' ,'data medicao'                 ,'', 'data medicao'                     ,10     ,false, false, false, 0, 'date', 'data medicao');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si201_valormedicao'             ,'float','valor medicao'                ,'', 'valor medicao'                    ,10     ,false, false, false, 0, 'float','valor medicao');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si201_mes'                      ,'int4' ,'Mes'                          ,'', 'Mes'                              ,10     ,false, false, false, 0, 'int4', 'Mes');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si201_pdf'                      ,'text' ,'pdf'                          ,'', 'pdf'                              ,25     ,false, false, false, 0, 'int4', 'pdf');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si201_instit'                   ,'int4' ,'Instituição'                  ,'', 'Instituição'                      ,10     ,false, false, false, 0, 'int4', 'Instituição');

                -- INSERE db_sysarqcamp
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si201_sequencial')                   , 1, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si201_tiporegistro')                 , 2, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si201_codorgaoresp')                 , 3, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si201_codobra')                      , 4, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si201_tipomedicao')                  , 5, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si201_descoutrostiposmed')           , 6, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si201_nummedicao')                   , 7, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si201_descmedicao')                  , 8, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si201_dtiniciomedicao')              , 9, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si201_dtfimmedicao')                 , 10, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si201_dtmedicao')                    , 11, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si201_valormedicao')                 , 12, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si201_mes')                          , 13, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si201_pdf')                          , 14, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si201_instit')                       , 15, 0);


                CREATE TABLE cadobras302020(
                si201_sequencial                int8,
                si201_tiporegistro              int8,
                si201_codorgaoresp              varchar(3),
                si201_codobra                   int8,
                si201_tipomedicao               int8,
                si201_descoutrostiposmed        varchar(500),
                si201_nummedicao                varchar(20),
                si201_descmedicao               varchar(500),
                si201_dtiniciomedicao           date,
                si201_dtfimmedicao              date,
                si201_dtmedicao                 date,
                si201_valormedicao              float,
                si201_mes                       int8,
                si201_pdf                       varchar(25),
                si201_instit                    int4);

                CREATE SEQUENCE cadobras302020_si201_sequencial_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;

                ALTER TABLE cadobras102020 ALTER COLUMN si198_numrt SET DEFAULT 0;

                --DROP TABLE:
                DROP TABLE IF EXISTS licobrasresponsaveis CASCADE;

                -- TABELAS E ESTRUTURA

                          -- Módulo: Obras
                          CREATE TABLE licobrasresponsaveis(
                          obr05_sequencial		      int8 ,
                          obr05_seqobra 			      int8 ,
                          obr05_responsavel		      int8 ,
                          obr05_tiporesponsavel	    int8 ,
                          obr05_tiporegistro		    int8 ,
                          obr05_numregistro		      varchar(10) ,
                          obr05_numartourrt		      int8 ,
                          obr05_vinculoprofissional int8 ,
                          obr05_dtcadastrores       date ,
                          obr05_instit			        int8 );

                -- CHAVE ESTRANGEIRA
                    ALTER TABLE licobrasresponsaveis ADD PRIMARY KEY (obr05_sequencial);
                    ALTER TABLE licobrasresponsaveis ADD CONSTRAINT licobrasresponsaveis_licobras_fk
                    FOREIGN KEY (obr05_seqobra) REFERENCES licobras (obr01_sequencial);

                    ALTER TABLE licobrasresponsaveis ADD CONSTRAINT licobrasresponsaveis_cgm_fk
                    FOREIGN KEY (obr05_responsavel) REFERENCES cgm (z01_numcgm);

                    ALTER table licobrasanexo alter COLUMN obr04_legenda type varchar(250);

COMMIT;


SQL;
      $this->execute($sql);
    }
}
