<?php

use Phinx\Migration\AbstractMigration;

class AjusteCargadeDados extends AbstractMigration
{
    public function up()
    {
        $this->execute("
        UPDATE habitacao.avaliacao
        SET db101_cargadados='SELECT eso05_codclassificacaotributaria,
        eso05_indicativocooperativa,
        CASE
            WHEN eso05_indicativodeconstrutora = 't' THEN 3003674
            ELSE 3003673
        END AS eso05_indicativodeconstrutora,
        CASE
            WHEN eso05_indicativodesoneracao = 't' THEN 3003676
            ELSE 3003675
        END AS eso05_indicativodesoneracao,
        CASE
            WHEN eso05_indicativoprodutorrural = 1 THEN 4000525
            WHEN eso05_indicativoprodutorrural = 2 THEN 4000526
            ELSE 2
        END AS eso05_indicativoprodutorrural,
        CASE
            WHEN eso05_microempresa = 't' THEN 4000527
            ELSE 3
        END AS eso05_microempresa,
        CASE
            WHEN eso05_registroeletronicodeempregados = 1 THEN 3003677
            ELSE 3003678
        END AS eso05_registroeletronicodeempregados,
        eso05_cnpjdoentefederativoresp
 FROM avaliacaoS1000
 WHERE eso05_instit = fc_getsession('DB_instit')::int'
        WHERE db101_sequencial=3000015;

        ");
    }
}
