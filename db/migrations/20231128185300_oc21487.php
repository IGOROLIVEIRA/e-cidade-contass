<?php

use Phinx\Migration\AbstractMigration;

class oc21487 extends AbstractMigration
{

    public function up(){
        $this->atualizaTabelaEmpdiaria();
    }
    
    public function atualizaTabelaEmpdiaria(){
        $sql = " 
            BEGIN;

            ALTER TABLE empenho.empdiaria ADD COLUMN e140_horainicial varchar(5) NOT NULL DEFAULT '00:00';
            ALTER TABLE empenho.empdiaria ADD COLUMN e140_horafinal varchar(5) NOT NULL DEFAULT '00:00';
            ALTER TABLE empenho.empdiaria ADD COLUMN e140_qtdhospedagens int4;
            ALTER TABLE empenho.empdiaria ADD COLUMN e140_vrlhospedagemuni float8;

            INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
            VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e140_horainicial' ,'varchar(5)' ,'Hora Inicial' ,'' ,'Hora Inicial' ,10,'false' ,'false' ,'false' ,3 ,'text' ,'Hora Inicial' );
            
            INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
            VALUES (
            (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_horainicial'),15, 0);
           
            INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
            VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e140_horafinal' ,'varchar(5)' ,'Hora Final' ,'' ,'Hora Final' ,10,'false' ,'false' ,'false' ,3 ,'text' ,'Hora Final' );
            
            INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
            VALUES (
            (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_horafinal'),16, 0);   
           
            INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
            VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e140_qtdhospedagens' ,'int4' ,'Quantidade de Hospedagens' ,'0' ,'Quantidade de Hospedagens' ,10 ,'false' ,'false' ,'false' ,1 ,'text' ,'Quantidade de Hospedagens' );
            
            INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
            VALUES (
            (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_qtdhospedagens'),17, 0);       

            INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
            VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e140_vrlhospedagemuni' ,'float8' ,'Valor Unitario da Hospedagem' ,'' ,'Valor Unitario da Hospedagem' ,15 ,'false' ,'false' ,'false' ,4 ,'text' ,'Valor Unitario da Hospedagem' );
            
            INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
            VALUES (
            (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_vrlhospedagemuni'),18, 0);
            COMMIT;
        ";
        $this->execute($sql);
    }
}
