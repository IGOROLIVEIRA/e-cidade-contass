<?php

use Phinx\Migration\AbstractMigration;

class oc21530 extends AbstractMigration
{

    public function up(){
        $this->atualizaTabelaPagordem();
        $this->povoaCampoNumeroLIquidacao();
    }
    
    public function atualizaTabelaPagordem(){
        $sql = " 
            BEGIN;

	        ALTER TABLE empenho.pagordem ADD COLUMN e50_numliquidacao int4 not null default 0;

            INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
            VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e50_numliquidacao' ,'int8' ,'Número da Liquidação por empenho' ,'0' ,'Número da Liquidação' ,10 ,'false' ,'false' ,'false' ,1 ,'text' ,'Número da Liquidação' );
            
            insert into db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
            values (
            (select codarq from db_sysarquivo where nomearq = 'pagordem'),
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'e50_numliquidacao'),
            (SELECT max(seqarq) FROM db_sysarqcamp WHERE codarq = ((select codarq from db_sysarquivo where nomearq = 'pagordem'))) + 1,0 );

            COMMIT;
        ";
        $this->execute($sql);
    }

    public function povoaCampoNumeroLIquidacao(){
        $sql = " 
            BEGIN;

            WITH sequenciamento AS (
                SELECT
                    e50_codord,
                    e50_numemp,
                    row_number() OVER (partition by e50_numemp ORDER BY e50_codord) AS sequencia
                FROM
                    empenho.pagordem p
                JOIN 
                    empenho.empempenho e ON
                    p.e50_numemp = e.e60_numemp
                LEFT JOIN
                    empenho.empresto e2 ON p.e50_numemp = e2.e91_numemp
                WHERE
                    (e60_anousu = 2023 OR e91_anousu = 2023))
                UPDATE
                    empenho.pagordem AS p SET
                    e50_numliquidacao = s.sequencia
                FROM
                    sequenciamento s
                WHERE
                    p.e50_codord = s.e50_codord;

            COMMIT;
        ";
        $this->execute($sql);
    }

    public function down(){
        $sSql = "
            BEGIN;

                DELETE FROM db_sysarqcamp WHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'e50_numliquidacao');
                            
                DELETE FROM db_syscampo WHERE nomecam = 'e50_numliquidacao';
                
                ALTER TABLE empenho.pagordem DROP COLUMN e50_numliquidacao;
                
            COMMIT;
        ";

        $this->execute($sSql);
    }
}
