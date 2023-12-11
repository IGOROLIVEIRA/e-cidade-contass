<?php

use Phinx\Migration\AbstractMigration;

class oc21279 extends AbstractMigration
{

    public function up(){
        $this->atualizaTabelaPagordem();
        $this->atualizaTabelaEmpparametro();
        $this->criaTabelaEmpdiaria();
    }
    
    public function atualizaTabelaPagordem(){
        $sql = " 
            BEGIN;

            ALTER TABLE empenho.pagordem ADD COLUMN e50_dtvencimento date;

            insert into db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
            values ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e50_dtvencimento' ,'date' ,'Data de Vencimento' ,'null' ,'Vencimento' ,10 ,'false' ,'false' ,'false' ,1 ,'text' ,'Vencimento' );
            insert into db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
            values (
            (select codarq from db_sysarquivo where nomearq = 'pagordem'),
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'e50_dtvencimento'),
            (SELECT max(seqarq) FROM db_sysarqcamp WHERE codarq = ((select codarq from db_sysarquivo where nomearq = 'pagordem'))) + 1,0 );
            COMMIT;
        ";
        $this->execute($sql);
    }

    public function atualizaTabelaEmpparametro(){
        $sql="
            BEGIN;

            ALTER TABLE empenho.empparametro ADD COLUMN e30_obrigadiarias bool default true;

            insert into db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
            values ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e30_obrigadiarias' ,'bool' ,'Obriga Informar Diarias na Liquidação' ,'true' ,'Obriga Informar Diarias na Liquidação' ,5 ,'false' ,'false' ,'false' ,1 ,'text' ,'Obriga Informar Diarias na Liquidação' );
            insert into db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
            values (
            (select codarq from db_sysarquivo where nomearq = 'empparametro'),
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'e30_obrigadiarias'),
            (SELECT max(seqarq) FROM db_sysarqcamp WHERE codarq = ((select codarq from db_sysarquivo where nomearq = 'empparametro'))) + 1,0 );

            COMMIT;
        ";
        $this->execute($sql);
    }

    public function criaTabelaEmpdiaria(){
        $sql="
        BEGIN;

        CREATE TABLE IF NOT EXISTS empenho.empdiaria
        (
            e140_sequencial SERIAL,
            e140_codord int8 not null,
            e140_dtautorizacao DATE not null,
            e140_matricula int8 not null,
            e140_cargo varchar(60) not null,
            e140_dtinicial DATE not null,
            e140_dtfinal DATE not null,
            e140_origem varchar(60) not null,
            e140_destino varchar(60) not null,
            e140_qtddiarias int4,
            e140_vrldiariauni float8,
            e140_transporte varchar(60),
            e140_vlrtransport float8,
            e140_objetivo varchar(500)
        );

            INSERT INTO db_sysarquivo 
            VALUES ((SELECT max(codarq)+1 FROM db_sysarquivo), 'empdiaria', 'Tabela de Diárias', 'e140', CURRENT_DATE, 'Diárias', 0, 'f', 'f', 'f', 'f' );
            
            INSERT INTO db_sysarqmod 
            VALUES (38,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'));

            INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
            VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e140_sequencial' ,'int8' ,'Sequencial' ,'0' ,'Sequencial' ,10 ,'false' ,'false' ,'false' ,1 ,'text' ,'Sequencial' );
            
            INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
            VALUES (
            (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_sequencial'),1 ,0 );
           
            INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
            VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e140_codord' ,'int8' ,'Codigo de Ordem de Pagamento' ,'0' ,'Codigo de Ordem de Pagamento' ,10 ,'false' ,'false' ,'false' ,1 ,'text' ,'Codigo de Ordem de Pagamento' );
            
            INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
            VALUES (
            (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_codord'),2 ,0 );

            INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
            VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e140_dtautorizacao' ,'date' ,'Data de Autorização' ,'' ,'Data de Autorização' ,10 ,'false' ,'false' ,'false' ,0 ,'text' ,'Data de Autorização' );
            
            INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
            VALUES (
            (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_dtautorizacao'),3 ,0 );
           
            INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
            VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e140_matricula' ,'int8' ,'Matricula' ,'0' ,'Matricula' ,10 ,'false' ,'false' ,'false' ,1 ,'text' ,'Matricula' );
            
            INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
            VALUES (
            (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_matricula'),4 ,0 );

            INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
            VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e140_cargo' ,'varchar(60)' ,'Cargo' ,'' ,'Cargo' ,60,'false' ,'false' ,'false' ,3 ,'text' ,'Cargo' );
            
            INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
            VALUES (
            (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_cargo'),5 ,0 );
           
            INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
            VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e140_dtinicial' ,'date' ,'Data Inicial da Viagem' ,'' ,'Data Inicial da Viagem' ,10 ,'false' ,'false' ,'false' ,0 ,'text' ,'Data Inicial da Viagem' );
            
            INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
            VALUES (
            (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_dtautorizacao'),6 ,0 );
           
           	INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
            VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e140_dtfinal' ,'date' ,'Data Final da Viagem' ,'' ,'Data Final da Viagem' ,10 ,'false' ,'false' ,'false' ,0 ,'text' ,'Data Final da Viagem' );
            
            INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
            VALUES (
            (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_dtfinal'),7 ,0 );
           
            INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
            VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e140_origem' ,'varchar(60)' ,'Origem' ,'' ,'Origem' ,60,'false' ,'false' ,'false' ,2 ,'text' ,'Origem' );
            
            INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
            VALUES (
            (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_origem'),8 ,0 );
           
            INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
            VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e140_destino' ,'varchar(60)' ,'Destino' ,'' ,'Destino' ,60,'false' ,'false' ,'false' ,2 ,'text' ,'Destino' );
            
            INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
            VALUES (
            (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_destino'),9 ,0 );
           
            INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
            VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e140_qtddiarias' ,'int4' ,'Quantidade de Diárias' ,'0' ,'Quantidade de Diárias' ,10 ,'false' ,'false' ,'false' ,1 ,'text' ,'Quantidade de Diárias' );
            
            INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
            VALUES (
            (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_qtddiarias'),10 ,0 );       

            INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
            VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e140_vrldiariauni' ,'float8' ,'Valor Unitario da Diária' ,'' ,'Valor Unitario da Diária' ,15 ,'false' ,'false' ,'false' ,4 ,'text' ,'Valor Unitario da Diária' );
            
            INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
            VALUES (
            (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_vrldiariauni'),11 ,0 );
           
            INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
            VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e140_transporte' ,'varchar(60)' ,'Transporte' ,'' ,'Transporte' ,60,'false' ,'false' ,'false' ,3 ,'text' ,'Transporte' );
            
            INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
            VALUES (
            (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_transporte'),12 ,0 );
           
            INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
            VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e140_vlrtransport' ,'float8' ,'Valor do Transporte' ,'' ,'Valor do Transporte' ,15 ,'false' ,'false' ,'false' ,4 ,'text' ,'Valor do Transporte' );
            
            INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
            VALUES (
            (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_vlrtransport'),11 ,0 ); 
           
            INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
            VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e140_objetivo' ,'varchar(500)' ,'Objetivo da Viagem' ,'' ,'Objetivo da Viagem' ,500,'false' ,'false' ,'false' ,3 ,'text' ,'Objetivo da Viagem' );
            
            INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
            VALUES (
            (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_objetivo'),13 ,0 );

            INSERT INTO db_syssequencia VALUES((SELECT max(codsequencia) + 1 FROM db_syssequencia), 'empdiaria_e140_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
            UPDATE db_sysarqcamp SET codsequencia = (SELECT codsequencia FROM db_syssequencia WHERE nomesequencia = 'empdiaria_e140_sequencial_seq') WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria') and codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_sequencial');

        COMMIT;
        ";

        $this->execute($sql);
    }
}
