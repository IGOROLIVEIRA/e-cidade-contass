<?php 

use Phinx\Migration\AbstractMigration;

class Oc16314 extends AbstractMigration
{
    public function up()
    {

        $sql = <<<SQL

        BEGIN;

        SELECT fc_startsession();
  

        Create table IF NOT EXISTS db_operacaodecredito(
            op01_sequencial Serial,
            op01_numerocontratoopc varchar(30) not null,
            op01_dataassinaturacop date not null
        );

        ALTER TABLE contabancaria ADD COLUMN db83_codigoopcredito int;

        ALTER TABLE orcsuplemval ADD COLUMN o47_numerocontratooc varchar(30); 

        ALTER TABLE orcsuplemval ADD COLUMN o47_dataassinaturacop date; 

        ALTER TABLE orcsuplemval ADD COLUMN o47_codigoopcredito int;

        INSERT INTO db_syscampo
            ( codcam,nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
            VALUES
            ((select max(codcam)+1 from db_syscampo),'o47_numerocontratooc', 'int', 'Operação de Crédito', '0', 'Operação de Crédito', 11, false, false, false, 1, 'text', 'Operação de Crédito');

        INSERT INTO db_itensmenu 
            VALUES 
            ((select max(id_item)+1 from db_itensmenu), 'Operações de Crédito', 'Operações de Crédito', ' ', 1, 1, 'Operações de Crédito', 't');

        INSERT INTO db_menu 
            VALUES
            (29,(select max(id_item) from db_itensmenu),265,209);

        INSERT INTO db_itensmenu 
            VALUES 
            ((select max(id_item)+1 from db_itensmenu), 'Inclusão', 'Inclusão', 'con1_db_operacaodecredito001.php', 1, 1, 'Inclusão', 't');
        
        INSERT INTO db_menu 
            VALUES
            ((select id_item from db_itensmenu where descricao like 'Operações de Crédito') ,(select max(id_item) from db_itensmenu),1,209);

        INSERT INTO db_itensmenu 
            VALUES 
            ((select max(id_item)+1 from db_itensmenu), 'Alteração', 'Alteração', 'con1_db_operacaodecredito002.php', 1, 1, 'Alteração', 't');

        INSERT INTO db_menu 
            VALUES
            ((select id_item from db_itensmenu where descricao like 'Operações de Crédito') ,(select max(id_item) from db_itensmenu),2,209);

        INSERT INTO db_itensmenu 
            VALUES 
            ((select max(id_item)+1 from db_itensmenu), 'Exclusão', 'Exclusão', 'con1_db_operacaodecredito003.php', 1, 1, 'Exclusão', 't');

        INSERT INTO db_menu  
            VALUES
            ((select id_item from db_itensmenu where descricao like 'Operações de Crédito') ,(select max(id_item) from db_itensmenu),3,209);
       
        INSERT INTO db_syscampo 
                ( codcam,nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
                VALUES
                ((select max(codcam)+1 from db_syscampo),'op01_sequencial', 'int', 'Sequencial', '0', 'Sequencial', 11, false, false, false, 1, 'text', 'Sequencial');
        
        INSERT INTO db_syscampo
                (codcam,nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
                VALUES
                ((select max(codcam)+1 from db_syscampo),'op01_numerocontratoopc', 'varchar(30)', 'Nº do Contrato da Operação de Crédito', '0', 'Nº do Contrato da Operação de Crédito', 30, false, false, false, 1, 'text', 'Nº do Contrato da Operação de Crédito');

        INSERT INTO db_syscampo
                ( codcam,nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
                VALUES
                ((select max(codcam)+1 from db_syscampo),'op01_dataassinaturacop', 'data', 'Data de Assinatura do Contrato OP', '0', 'Data de Assinatura do Contrato OP', 10, false, false, false, 1, 'text', 'Data de Assinatura do Contrato OP');
                  
        INSERT INTO db_sysarqcamp 
                (codarq, codcam, seqarq, codsequencia) 
                VALUES 
                ((select max(codarq) from db_sysarquivo),(select codcam from db_syscampo where nomecam = 'op01_numerocontratoopc'),'1','0');

        INSERT INTO db_sysarqcamp 
                (codarq, codcam, seqarq, codsequencia) 
                VALUES 
                ((select max(codarq) from db_sysarquivo),(select codcam from db_syscampo where nomecam = 'op01_dataassinaturacop'),'2','0');

        INSERT INTO db_sysarqcamp 
                (codarq, codcam, seqarq, codsequencia) 
                VALUES 
                ((select max(codarq) from db_sysarquivo),(select codcam from db_syscampo where nomecam = 'op01_sequencial'),'3','0');
                
            
        
        UPDATE db_syscampo
        SET descricao = 'Nº do Contrato da Operação de Crédito', rotulo = 'Nº do Contrato da Operação de Crédito',rotulorel = 'Nº do Contrato da Operação de Crédito'
        WHERE nomecam = 'op01_numerocontratoopc'; 

        UPDATE db_syscampo
        SET descricao = 'Data de Assinatura do Contrato OP', rotulo = 'Data de Assinatura do Contrato OP',rotulorel = 'Data de Assinatura do Contrato OP'
        WHERE nomecam = 'op01_dataassinaturacop';

        UPDATE db_syscampo
        SET descricao = 'Sequencial', rotulo = 'Sequencial',rotulorel = 'Sequencial'
        WHERE nomecam = 'op01_sequencial';

        COMMIT;

SQL;
        $this->execute($sql);
    }
}
