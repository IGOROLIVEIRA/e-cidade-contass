<?php

use Phinx\Migration\AbstractMigration;

class Oc16737Estrutural extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
            begin;
                update conplano set c60_estrut = '218830104'||substr(c60_estrut,10,15) where c60_estrut like '218810104%' and c60_anousu>2021;
                update conplano set c60_estrut = '218830102'||substr(c60_estrut,10,15) where c60_estrut like '218810102%' and c60_anousu>2021;
                update conplano set c60_estrut = '218830106'||substr(c60_estrut,10,15) where c60_estrut like '218810106%' and c60_anousu>2021;
                update conplano set c60_estrut = '218840107'||substr(c60_estrut,10,15) where c60_estrut like '218810107%' and c60_anousu>2021;
                update conplano set c60_estrut = '218820108'||substr(c60_estrut,10,15) where c60_estrut like '218810108%' and c60_anousu>2021;
                update conplano set c60_estrut = '218820109'||substr(c60_estrut,10,15) where c60_estrut like '218810109%' and c60_anousu>2021;
                update conplano set c60_estrut = '228820101'||substr(c60_estrut,10,15) where c60_estrut like '228810101%' and c60_anousu>2021;
                update conplano set c60_estrut = '228830104'||substr(c60_estrut,10,15) where c60_estrut like '228810104%' and c60_anousu>2021;
                update conplano set c60_estrut = '228830106'||substr(c60_estrut,10,15) where c60_estrut like '228810106%' and c60_anousu>2021;
                update conplano set c60_estrut = '228840107'||substr(c60_estrut,10,15) where c60_estrut like '228810107%' and c60_anousu>2021;
                update conplano set c60_estrut = '228820108'||substr(c60_estrut,10,15) where c60_estrut like '228810108%' and c60_anousu>2021;
                update conplano set c60_estrut = '228820109'||substr(c60_estrut,10,15) where c60_estrut like '228810109%' and c60_anousu>2021;
                update conplano set c60_estrut = '8211401'||substr(c60_estrut,8,15) where c60_estrut like '82114%' and c60_anousu>2021;
                update conplano set c60_estrut = '218820112'||substr(c60_estrut,10,15) where c60_estrut like '218810112%' and c60_anousu>2021;
                update conplano set c60_estrut = '228820112'||substr(c60_estrut,10,15) where c60_estrut like '228810112%' and c60_anousu>2021;
            commit;
SQL;
        $this->execute($sql);
    }
}
