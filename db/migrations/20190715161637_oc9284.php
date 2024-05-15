<?php

use Phinx\Migration\AbstractMigration;

class Oc9284 extends AbstractMigration
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
        $sSql = "INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 've81_codigonovo', 'int4', 'Novo Código', '0', 'Novo Código', 11, false, false, true, 1, 'text', 've81_codigonovo');

                 INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 've81_codigonovo'), 8, 0);

                 UPDATE db_syscampo SET rotulo = 'Cod.unidade sub anterior',rotulorel='Cod.unidade sub anterior' WHERE codcam = (select codcam from db_syscampo where nomecam like '%ve81_codunidadesubant%');
                 
                 UPDATE db_syscampo SET rotulo = 'Código unidade sub atual',rotulorel='Código unidade sub atual' WHERE codcam = (select codcam from db_syscampo where nomecam like '%ve81_codunidadesubatual%');
                 
                 ALTER TABLE veiculostransferencia ADD column ve81_codigonovo int4;

                 UPDATE db_syscampo SET descricao='Tipo', rotulo='Tipo', rotulorel= 'Tipo' WHERE nomecam LIKE '%e38_sequencial%'";

        $this->execute($sSql);
    }
}
