<?php

use Phinx\Migration\AbstractMigration;

class Oc11285 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
        
        BEGIN;
        
        --ALTER TABLE dadoscomplementareslrf DROP column c218_vldotinicialincentivocontrib;
        
        ALTER TABLE dadoscomplementareslrf ADD column c218_vldotinicialincentivocontrib float8 NOT NULL default 0;
        ALTER TABLE dadoscomplementareslrf ADD column c218_vldotincentconcedinstfinanc float8 NOT NULL default 0;
        ALTER TABLE dadoscomplementareslrf ADD column c218_vlajustesrelativosrpps float8 NOT NULL default 0;
        
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'c218_vldotinicialincentivocontrib', 'float8', 'valor dota��o inicial de incentivo  a contribuinte', false, 'valor dota��o inicial de incentivo  a contribuinte', 1, false, false, false, 5, 'text', 'c218_vldotinicialincentivocontrib');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'c218_vldotinicialincentivocontrib'), 8, 0);         
        UPDATE db_syscampo SET descricao='Valor dota��o inicial de incentivo  a contribuinte', rotulo='valor dota��o inicial de incentivo  a contribuinte', rotulorel= 'valor dota��o inicial de incentivo  a contribuinte' WHERE nomecam LIKE '%c218_vldotinicialincentivocontrib%';
        
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'c218_vldotincentconcedinstfinanc', 'float8', 'valor dota��o de incentivo concedido por institui��o financeira', false, 'valor dota��o de incentivo concedido por institui��o financeira', 1, false, false, false, 5, 'text', 'c218_vldotincentconcedinstfinanc');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'c218_vldotincentconcedinstfinanc'), 8, 0);         
        UPDATE db_syscampo SET descricao='Valor dota��o de incentivo concedido por institui��o financeira', rotulo='Valor dota��o de incentivo concedido por institui��o financeira', rotulorel= 'Valor dota��o de incentivo concedido por institui��o financeira' WHERE nomecam LIKE '%c218_vldotincentconcedinstfinanc%';
        
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'c218_vlajustesrelativosrpps', 'float8', 'Valor de ajustes relativos ao rpps', false, 'Valor de ajustes relativos ao rpps', 1, false, false, false, 5, 'text', 'c218_vlajustesrelativosrpps');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'c218_vlajustesrelativosrpps'), 8, 0);         
        UPDATE db_syscampo SET descricao='Valor de ajustes relativos ao rpps', rotulo='Valor de ajustes relativos ao rpps', rotulorel= 'Valor de ajustes relativos ao rpps' WHERE nomecam LIKE '%c218_vlajustesrelativosrpps%';
        
        COMMIT;
SQL;
        $this->execute($sql);
    }
}
